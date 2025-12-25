<?php

namespace Nebatech\Models\CBT;

use Nebatech\Core\Database;
use PDO;

/**
 * Quiz Attempt Model
 * Manages student quiz attempts and scoring
 */
class QuizAttempt
{
    /**
     * Start a new quiz attempt
     */
    public static function create(array $data): int
    {
        $db = Database::connect();
        
        // Get attempt number
        $stmt = $db->prepare("
            SELECT COALESCE(MAX(attempt_number), 0) + 1 
            FROM quiz_attempts 
            WHERE quiz_id = ? AND user_id = ?
        ");
        $stmt->execute([$data['quiz_id'], $data['user_id']]);
        $attemptNumber = (int)$stmt->fetchColumn();
        
        $stmt = $db->prepare("
            INSERT INTO quiz_attempts (
                quiz_id, user_id, enrollment_id, attempt_number, 
                answers, score, total_points, earned_points, passed
            ) VALUES (?, ?, ?, ?, ?, 0, 0, 0, 0)
        ");
        $stmt->execute([
            $data['quiz_id'],
            $data['user_id'],
            $data['enrollment_id'],
            $attemptNumber,
            json_encode([])
        ]);
        return (int)$db->lastInsertId();
    }

    /**
     * Find attempt by ID
     */
    public static function findById(int $id): ?array
    {
        $db = Database::connect();
        $stmt = $db->prepare("
            SELECT qa.*, q.title as quiz_title, q.passing_score, q.max_attempts
            FROM quiz_attempts qa
            JOIN quizzes q ON qa.quiz_id = q.id
            WHERE qa.id = ?
        ");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result) {
            $result['answers'] = json_decode($result['answers'], true) ?: [];
        }
        
        return $result ?: null;
    }

    /**
     * Submit quiz answers and calculate score
     */
    public static function submit(int $attemptId, array $answers): array
    {
        $db = Database::connect();
        
        $attempt = self::findById($attemptId);
        if (!$attempt) {
            return ['success' => false, 'error' => 'Attempt not found'];
        }
        
        $quiz = Quiz::findById($attempt['quiz_id']);
        $questions = QuizQuestion::getByQuiz($attempt['quiz_id']);
        
        $totalPoints = 0;
        $earnedPoints = 0;
        $results = [];
        
        foreach ($questions as $question) {
            $totalPoints += $question['points'];
            $userAnswer = $answers[$question['id']] ?? null;
            
            $checkResult = QuizQuestion::checkAnswer($question['id'], $userAnswer);
            $earnedPoints += $checkResult['points_earned'];
            
            $results[$question['id']] = [
                'user_answer' => $userAnswer,
                'correct' => $checkResult['correct'],
                'points_earned' => $checkResult['points_earned'],
                'explanation' => $quiz['show_explanations'] ? $checkResult['explanation'] : null,
                'correct_answer' => $quiz['show_correct_answers'] ? $checkResult['correct_answer'] : null
            ];
        }
        
        $score = $totalPoints > 0 ? round(($earnedPoints / $totalPoints) * 100, 2) : 0;
        $passed = $score >= $quiz['passing_score'];
        
        // Update attempt
        $stmt = $db->prepare("
            UPDATE quiz_attempts SET
                answers = ?,
                score = ?,
                total_points = ?,
                earned_points = ?,
                passed = ?,
                completed_at = NOW()
            WHERE id = ?
        ");
        $stmt->execute([
            json_encode($results),
            $score,
            $totalPoints,
            $earnedPoints,
            $passed ? 1 : 0,
            $attemptId
        ]);
        
        return [
            'success' => true,
            'score' => $score,
            'passed' => $passed,
            'earned_points' => $earnedPoints,
            'total_points' => $totalPoints,
            'passing_score' => $quiz['passing_score'],
            'results' => $results
        ];
    }

    /**
     * Get user's attempts for a quiz
     */
    public static function getByUserAndQuiz(int $userId, int $quizId): array
    {
        $db = Database::connect();
        $stmt = $db->prepare("
            SELECT * FROM quiz_attempts 
            WHERE user_id = ? AND quiz_id = ?
            ORDER BY attempt_number DESC
        ");
        $stmt->execute([$userId, $quizId]);
        $attempts = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($attempts as &$a) {
            $a['answers'] = json_decode($a['answers'], true) ?: [];
        }
        
        return $attempts;
    }

    /**
     * Get best attempt for user/quiz
     */
    public static function getBestAttempt(int $userId, int $quizId): ?array
    {
        $db = Database::connect();
        $stmt = $db->prepare("
            SELECT * FROM quiz_attempts 
            WHERE user_id = ? AND quiz_id = ?
            ORDER BY score DESC, completed_at DESC
            LIMIT 1
        ");
        $stmt->execute([$userId, $quizId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result) {
            $result['answers'] = json_decode($result['answers'], true) ?: [];
        }
        
        return $result ?: null;
    }

    /**
     * Get all attempts for an enrollment
     */
    public static function getByEnrollment(int $enrollmentId): array
    {
        $db = Database::connect();
        $stmt = $db->prepare("
            SELECT qa.*, q.title as quiz_title, q.lesson_id
            FROM quiz_attempts qa
            JOIN quizzes q ON qa.quiz_id = q.id
            WHERE qa.enrollment_id = ?
            ORDER BY qa.completed_at DESC
        ");
        $stmt->execute([$enrollmentId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Check if user can attempt quiz
     */
    public static function canAttempt(int $userId, int $quizId): array
    {
        $quiz = Quiz::findById($quizId);
        if (!$quiz) {
            return ['can_attempt' => false, 'reason' => 'Quiz not found'];
        }
        
        $db = Database::connect();
        $stmt = $db->prepare("
            SELECT COUNT(*) FROM quiz_attempts 
            WHERE user_id = ? AND quiz_id = ?
        ");
        $stmt->execute([$userId, $quizId]);
        $attemptCount = (int)$stmt->fetchColumn();
        
        if ($quiz['max_attempts'] > 0 && $attemptCount >= $quiz['max_attempts']) {
            return [
                'can_attempt' => false, 
                'reason' => 'Maximum attempts reached',
                'attempts_used' => $attemptCount,
                'max_attempts' => $quiz['max_attempts']
            ];
        }
        
        return [
            'can_attempt' => true,
            'attempts_used' => $attemptCount,
            'max_attempts' => $quiz['max_attempts'],
            'attempts_remaining' => $quiz['max_attempts'] > 0 ? $quiz['max_attempts'] - $attemptCount : 'unlimited'
        ];
    }

    /**
     * Count passed quizzes for enrollment
     */
    public static function countPassedByEnrollment(int $enrollmentId): int
    {
        $db = Database::connect();
        $stmt = $db->prepare("
            SELECT COUNT(DISTINCT quiz_id) FROM quiz_attempts 
            WHERE enrollment_id = ? AND passed = 1
        ");
        $stmt->execute([$enrollmentId]);
        return (int)$stmt->fetchColumn();
    }
}
