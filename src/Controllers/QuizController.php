<?php

namespace Nebatech\Controllers;

use Nebatech\Core\Controller;
use Nebatech\Models\CBT\Quiz;
use Nebatech\Models\CBT\QuizQuestion;
use Nebatech\Models\CBT\QuizAttempt;
use PDO;

/**
 * Quiz Controller - Handles quiz taking and submission
 */
class QuizController extends Controller
{
    private PDO $pdo;

    public function __construct()
    {
        parent::__construct();
        $this->requireAuth();
        $this->pdo = $this->getDatabase();
    }

    /**
     * Show quiz for a lesson
     * GET /quiz/:lessonId
     */
    public function show($lessonId = null)
    {
        $user = $this->getCurrentUser();
        $lessonId = (int)$lessonId;

        if (!$lessonId) {
            $this->redirect('/dashboard');
            return;
        }

        // Get quiz for this lesson
        $stmt = $this->pdo->prepare("SELECT * FROM quizzes WHERE lesson_id = ? AND status = 'published' LIMIT 1");
        $stmt->execute([$lessonId]);
        $quiz = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$quiz) {
            $_SESSION['error'] = 'Quiz not found for this lesson.';
            $this->redirect('/dashboard');
            return;
        }

        // Get lesson and course info
        $stmt = $this->pdo->prepare("
            SELECT l.*, m.course_id, m.title as module_title, c.title as course_title, c.slug as course_slug
            FROM lessons l
            JOIN modules m ON l.module_id = m.id
            JOIN courses c ON m.course_id = c.id
            WHERE l.id = ?
        ");
        $stmt->execute([$lessonId]);
        $lesson = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check enrollment
        $stmt = $this->pdo->prepare("
            SELECT * FROM enrollments WHERE user_id = ? AND course_id = ? AND status = 'active'
        ");
        $stmt->execute([$user['id'], $lesson['course_id']]);
        if (!$stmt->fetch()) {
            $_SESSION['error'] = 'You must be enrolled in this course to take the quiz.';
            $this->redirect('/courses');
            return;
        }

        // Check attempt count
        $stmt = $this->pdo->prepare("
            SELECT COUNT(*) as attempt_count FROM quiz_attempts 
            WHERE quiz_id = ? AND user_id = ?
        ");
        $stmt->execute([$quiz['id'], $user['id']]);
        $attemptCount = $stmt->fetch(PDO::FETCH_ASSOC)['attempt_count'];

        if ($quiz['max_attempts'] > 0 && $attemptCount >= $quiz['max_attempts']) {
            $_SESSION['error'] = 'You have used all available attempts for this quiz.';
            $this->redirect('/courses/' . $lesson['course_slug'] . '/lesson/' . $lessonId);
            return;
        }

        // Get questions
        $stmt = $this->pdo->prepare("
            SELECT * FROM quiz_questions WHERE quiz_id = ? ORDER BY question_number
        ");
        $stmt->execute([$quiz['id']]);
        $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Render quiz view
        echo $this->render('quiz/take', [
            'quiz' => $quiz,
            'questions' => $questions,
            'lesson' => $lesson,
            'course' => [
                'id' => $lesson['course_id'],
                'title' => $lesson['course_title'],
                'slug' => $lesson['course_slug']
            ],
            'attemptCount' => $attemptCount,
            'title' => $quiz['title']
        ]);
    }

    /**
     * Submit quiz answers
     * POST /api/quiz/submit
     */
    public function submit()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonError('Invalid request method', 405);
        }

        $user = $this->getCurrentUser();
        $input = $this->getJsonInput();

        $quizId = (int)($input['quiz_id'] ?? 0);
        $answers = $input['answers'] ?? [];
        $timeTaken = (int)($input['time_taken'] ?? 0);

        if (!$quizId) {
            $this->jsonError('Quiz ID is required', 400);
        }

        // Get quiz
        $stmt = $this->pdo->prepare("SELECT * FROM quizzes WHERE id = ?");
        $stmt->execute([$quizId]);
        $quiz = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$quiz) {
            $this->jsonError('Quiz not found', 404);
        }

        // Get questions
        $stmt = $this->pdo->prepare("SELECT * FROM quiz_questions WHERE quiz_id = ? ORDER BY question_number");
        $stmt->execute([$quizId]);
        $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Calculate score
        $correctCount = 0;
        $answerDetails = [];
        
        // Debug logging
        error_log("Quiz submit - Answers received: " . json_encode($answers));

        foreach ($questions as $index => $question) {
            $selectedIndex = $answers[$index] ?? null;
            $options = json_decode($question['options'], true);
            $correctAnswer = json_decode($question['correct_answer'], true);
            
            // Debug logging
            error_log("Q{$index}: selectedIndex={$selectedIndex}, options=" . json_encode($options) . ", correct={$correctAnswer}");
            
            $isCorrect = false;
            $selectedAnswer = null;
            
            if ($selectedIndex !== null && isset($options[$selectedIndex])) {
                $selectedAnswer = $options[$selectedIndex];
                $isCorrect = ($selectedAnswer === $correctAnswer);
                error_log("Q{$index}: selectedAnswer={$selectedAnswer}, isCorrect=" . ($isCorrect ? 'true' : 'false'));
                if ($isCorrect) {
                    $correctCount++;
                }
            }

            $answerDetails[] = [
                'question_id' => $question['id'],
                'selected_answer' => $selectedAnswer,
                'correct_answer' => $correctAnswer,
                'is_correct' => $isCorrect,
                'points_earned' => $isCorrect ? ($question['points'] ?? 1) : 0
            ];
        }

        $score = count($questions) > 0 ? round(($correctCount / count($questions)) * 100) : 0;
        $passed = $score >= ($quiz['passing_score'] ?? 70);

        // Create attempt record
        $stmt = $this->pdo->prepare("
            INSERT INTO quiz_attempts (
                quiz_id, user_id, score, passed, answers, time_taken_seconds,
                started_at, completed_at, created_at
            ) VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW(), NOW())
        ");
        
        $stmt->execute([
            $quizId,
            $user['id'],
            $score,
            $passed ? 1 : 0,
            json_encode($answerDetails),
            $timeTaken
        ]);

        $attemptId = $this->pdo->lastInsertId();

        // Update lesson progress if passed
        if ($passed) {
            $this->updateLessonQuizStatus($quiz['lesson_id'], $user['id'], true);
            $this->updateCompetencies($quizId, $user['id'], $score);
        }

        $this->jsonResponse([
            'success' => true,
            'attempt_id' => $attemptId,
            'score' => $score,
            'passed' => $passed,
            'correct_count' => $correctCount,
            'total_questions' => count($questions),
            'message' => $passed ? 'Congratulations! You passed!' : 'Keep trying, you\'ll get it!'
        ]);
    }

    /**
     * Get quiz results for an attempt
     * GET /api/quiz/results/:attemptId
     */
    public function results($attemptId = null)
    {
        $user = $this->getCurrentUser();
        $attemptId = (int)$attemptId;

        $stmt = $this->pdo->prepare("
            SELECT qa.*, q.title, q.passing_score, q.lesson_id
            FROM quiz_attempts qa
            JOIN quizzes q ON qa.quiz_id = q.id
            WHERE qa.id = ? AND qa.user_id = ?
        ");
        $stmt->execute([$attemptId, $user['id']]);
        $attempt = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$attempt) {
            $this->jsonError('Attempt not found', 404);
        }

        $this->jsonResponse([
            'success' => true,
            'attempt' => $attempt
        ]);
    }

    /**
     * Get quiz status for a lesson
     * GET /api/quiz/status/:lessonId
     */
    public function status($lessonId = null)
    {
        $user = $this->getCurrentUser();
        $lessonId = (int)$lessonId;

        // Get quiz
        $stmt = $this->pdo->prepare("SELECT * FROM quizzes WHERE lesson_id = ? AND status = 'published'");
        $stmt->execute([$lessonId]);
        $quiz = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$quiz) {
            $this->jsonResponse(['success' => true, 'has_quiz' => false]);
            return;
        }

        // Get best attempt
        $stmt = $this->pdo->prepare("
            SELECT * FROM quiz_attempts 
            WHERE quiz_id = ? AND user_id = ? 
            ORDER BY score DESC LIMIT 1
        ");
        $stmt->execute([$quiz['id'], $user['id']]);
        $bestAttempt = $stmt->fetch(PDO::FETCH_ASSOC);

        // Get attempt count
        $stmt = $this->pdo->prepare("SELECT COUNT(*) as count FROM quiz_attempts WHERE quiz_id = ? AND user_id = ?");
        $stmt->execute([$quiz['id'], $user['id']]);
        $attemptCount = $stmt->fetch(PDO::FETCH_ASSOC)['count'];

        $this->jsonResponse([
            'success' => true,
            'has_quiz' => true,
            'quiz' => [
                'id' => $quiz['id'],
                'title' => $quiz['title'],
                'passing_score' => $quiz['passing_score'],
                'max_attempts' => $quiz['max_attempts'],
                'time_limit' => $quiz['time_limit_minutes']
            ],
            'best_score' => $bestAttempt ? $bestAttempt['score'] : null,
            'passed' => $bestAttempt ? (bool)$bestAttempt['passed'] : false,
            'attempt_count' => $attemptCount,
            'can_retry' => $quiz['max_attempts'] === 0 || $attemptCount < $quiz['max_attempts']
        ]);
    }

    // ==================== Private Helper Methods ====================

    private function updateLessonQuizStatus(int $lessonId, int $userId, bool $passed): void
    {
        $stmt = $this->pdo->prepare("
            UPDATE lesson_progress 
            SET quiz_completed = ?, updated_at = NOW()
            WHERE lesson_id = ? AND user_id = ?
        ");
        $stmt->execute([$passed ? 1 : 0, $lessonId, $userId]);
    }

    private function updateCompetencies(int $quizId, int $userId, int $score): void
    {
        // Get competencies associated with this quiz's lesson
        $stmt = $this->pdo->prepare("
            SELECT c.id, c.course_id 
            FROM competencies c
            JOIN quizzes q ON q.lesson_id IN (
                SELECT l.id FROM lessons l 
                JOIN modules m ON l.module_id = m.id 
                WHERE m.course_id = c.course_id
            )
            WHERE q.id = ?
        ");
        $stmt->execute([$quizId]);
        $competencies = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($competencies as $comp) {
            // Update or create student competency record
            $stmt = $this->pdo->prepare("
                INSERT INTO student_competencies (user_id, competency_id, current_level, assessment_score, updated_at)
                VALUES (?, ?, 'developing', ?, NOW())
                ON DUPLICATE KEY UPDATE 
                    assessment_score = GREATEST(assessment_score, VALUES(assessment_score)),
                    current_level = CASE 
                        WHEN VALUES(assessment_score) >= 90 THEN 'mastered'
                        WHEN VALUES(assessment_score) >= 70 THEN 'proficient'
                        WHEN VALUES(assessment_score) >= 50 THEN 'developing'
                        ELSE 'novice'
                    END,
                    updated_at = NOW()
            ");
            $stmt->execute([$userId, $comp['id'], $score]);
        }
    }

    protected function getJsonInput(): array
    {
        $input = file_get_contents('php://input');
        return json_decode($input, true) ?? [];
    }

    protected function jsonResponse(array $data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    protected function jsonError(string $message, int $statusCode = 400): void
    {
        $this->jsonResponse(['success' => false, 'error' => $message], $statusCode);
    }

    protected function requireAuth(): void
    {
        if (!isset($_SESSION['user'])) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $this->jsonError('Authentication required', 401);
            } else {
                $this->redirect('/login');
            }
        }
    }

    protected function getDatabase(): PDO
    {
        static $pdo = null;
        if ($pdo === null) {
            $config = require __DIR__ . '/../../config/database.php';
            $pdo = new PDO(
                "mysql:host={$config['host']};dbname={$config['database']};charset=utf8mb4",
                $config['username'],
                $config['password'],
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
        }
        return $pdo;
    }

    protected function redirect(string $url): void
    {
        header('Location: ' . url($url));
        exit;
    }
}
