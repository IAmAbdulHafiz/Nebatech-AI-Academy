<?php

namespace Nebatech\Models\CBT;

use Nebatech\Core\Database;
use PDO;

/**
 * Quiz Question Model
 * Manages individual quiz questions
 */
class QuizQuestion
{
    /**
     * Create a new question
     */
    public static function create(array $data): int
    {
        $db = Database::connect();
        $stmt = $db->prepare("
            INSERT INTO quiz_questions (
                quiz_id, question_number, question_text, question_type,
                options, correct_answer, explanation, points, difficulty, code_language
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $data['quiz_id'],
            $data['question_number'] ?? 1,
            $data['question_text'],
            $data['question_type'] ?? 'multiple_choice',
            json_encode($data['options'] ?? []),
            json_encode($data['correct_answer']),
            $data['explanation'] ?? null,
            $data['points'] ?? 1,
            $data['difficulty'] ?? 'medium',
            $data['code_language'] ?? null
        ]);
        return (int)$db->lastInsertId();
    }

    /**
     * Bulk create questions for a quiz
     */
    public static function bulkCreate(int $quizId, array $questions): int
    {
        $db = Database::connect();
        $count = 0;
        
        foreach ($questions as $index => $question) {
            $stmt = $db->prepare("
                INSERT INTO quiz_questions (
                    quiz_id, question_number, question_text, question_type,
                    options, correct_answer, explanation, points, difficulty
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([
                $quizId,
                $index + 1,
                $question['question_text'],
                $question['question_type'] ?? 'multiple_choice',
                json_encode($question['options'] ?? []),
                json_encode($question['correct_answer']),
                $question['explanation'] ?? null,
                $question['points'] ?? 1,
                $question['difficulty'] ?? 'medium'
            ]);
            $count++;
        }
        
        return $count;
    }

    /**
     * Find question by ID
     */
    public static function findById(int $id): ?array
    {
        $db = Database::connect();
        $stmt = $db->prepare("SELECT * FROM quiz_questions WHERE id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result) {
            $result['options'] = json_decode($result['options'], true) ?: [];
            $result['correct_answer'] = json_decode($result['correct_answer'], true);
        }
        
        return $result ?: null;
    }

    /**
     * Get all questions for a quiz
     */
    public static function getByQuiz(int $quizId): array
    {
        $db = Database::connect();
        $stmt = $db->prepare("
            SELECT * FROM quiz_questions 
            WHERE quiz_id = ? 
            ORDER BY question_number
        ");
        $stmt->execute([$quizId]);
        $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($questions as &$q) {
            $q['options'] = json_decode($q['options'], true) ?: [];
            $q['correct_answer'] = json_decode($q['correct_answer'], true);
        }
        
        return $questions;
    }

    /**
     * Check if answer is correct
     */
    public static function checkAnswer(int $questionId, $userAnswer): array
    {
        $question = self::findById($questionId);
        if (!$question) {
            return ['correct' => false, 'error' => 'Question not found'];
        }
        
        $correct = false;
        $correctAnswer = $question['correct_answer'];
        
        switch ($question['question_type']) {
            case 'multiple_choice':
            case 'true_false':
                $correct = ($userAnswer === $correctAnswer);
                break;
                
            case 'multiple_select':
                // Both arrays must match (order doesn't matter)
                if (is_array($userAnswer) && is_array($correctAnswer)) {
                    sort($userAnswer);
                    sort($correctAnswer);
                    $correct = ($userAnswer === $correctAnswer);
                }
                break;
                
            case 'short_answer':
                // Case-insensitive comparison
                $correct = (strtolower(trim($userAnswer)) === strtolower(trim($correctAnswer)));
                break;
                
            case 'code':
                // Code questions typically need manual review or automated testing
                $correct = false; // Will be reviewed
                break;
        }
        
        return [
            'correct' => $correct,
            'points_earned' => $correct ? $question['points'] : 0,
            'points_possible' => $question['points'],
            'explanation' => $question['explanation'],
            'correct_answer' => $question['correct_answer']
        ];
    }

    /**
     * Delete all questions for a quiz
     */
    public static function deleteByQuiz(int $quizId): bool
    {
        $db = Database::connect();
        $stmt = $db->prepare("DELETE FROM quiz_questions WHERE quiz_id = ?");
        return $stmt->execute([$quizId]);
    }

    /**
     * Count questions for a quiz
     */
    public static function countByQuiz(int $quizId): int
    {
        $db = Database::connect();
        $stmt = $db->prepare("SELECT COUNT(*) FROM quiz_questions WHERE quiz_id = ?");
        $stmt->execute([$quizId]);
        return (int)$stmt->fetchColumn();
    }
}
