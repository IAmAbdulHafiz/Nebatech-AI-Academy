<?php

namespace Nebatech\Controllers;

use Nebatech\Core\Controller;
use Nebatech\Services\AITutorService;

/**
 * AI Tutor Controller - Student-facing AI tutoring endpoints
 * 
 * This controller handles:
 * - Chat interactions with the AI tutor
 * - Getting hints for practicals
 * - Concept explanations
 * - Study recommendations
 * - Quiz review feedback
 */
class AITutorController extends Controller
{
    private ?AITutorService $tutorService = null;

    public function __construct()
    {
        parent::__construct();
        // Don't call requireAuth here - handle it in each method
    }
    
    /**
     * Check authentication, returning JSON error for API calls
     */
    private function ensureAuthenticated(): bool
    {
        if (!isset($_SESSION['user_id'])) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST' || 
                (isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false)) {
                $this->jsonError('Authentication required', 401);
                return false;
            }
            $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
            header('Location: ' . url('/login'));
            exit;
        }
        return true;
    }

    /**
     * Initialize the tutor service (lazy loading)
     */
    private function getTutorService(): AITutorService
    {
        if ($this->tutorService === null) {
            try {
                $this->tutorService = new AITutorService();
            } catch (\Exception $e) {
                $this->jsonError('AI Tutor service is currently unavailable', 503);
            }
        }
        return $this->tutorService;
    }

    /**
     * Show the AI Tutor chat interface
     * GET /ai-tutor
     */
    public function index()
    {
        $this->ensureAuthenticated();
        $user = $this->getCurrentUser();
        
        // Get user's enrolled courses for context selection
        $enrollments = $this->getEnrollments($user['id']);
        
        echo $this->render('ai-tutor/chat', [
            'user' => $user,
            'enrollments' => $enrollments,
            'title' => 'AI Tutor - Your Personal Learning Assistant'
        ]);
    }

    /**
     * Handle chat message from student
     * POST /ai-tutor/chat
     */
    public function chat()
    {
        // Set JSON header early to prevent HTML error pages
        header('Content-Type: application/json');
        
        try {
            if (!isset($_SESSION['user_id'])) {
                http_response_code(401);
                echo json_encode(['success' => false, 'error' => 'Authentication required']);
                exit;
            }
            
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                http_response_code(405);
                echo json_encode(['success' => false, 'error' => 'Invalid request method']);
                exit;
            }

            $user = $this->getCurrentUser();
            if (!$user) {
                http_response_code(401);
                echo json_encode(['success' => false, 'error' => 'User not found']);
                exit;
            }
            
            $input = $this->getJsonInput();

            $question = trim($input['message'] ?? '');
            if (empty($question)) {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => 'Please enter a message']);
                exit;
            }

            // Build context from the request
            $context = [
                'lesson_id' => (int)($input['lesson_id'] ?? 0) ?: null,
                'practical_id' => (int)($input['practical_id'] ?? 0) ?: null,
                'quiz_id' => (int)($input['quiz_id'] ?? 0) ?: null,
                'course_id' => (int)($input['course_id'] ?? 0) ?: null
            ];

            $persona = $input['persona'] ?? 'mentor';
            
            // Validate persona
            if (!in_array($persona, ['mentor', 'expert', 'peer'])) {
                $persona = 'mentor';
            }

            $response = $this->getTutorService()->askQuestion(
                $user['id'],
                $question,
                $context,
                $persona
            );

            echo json_encode($response);
            exit;
            
        } catch (\Exception $e) {
            error_log('AI Tutor chat error: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => 'Unable to process your question: ' . $e->getMessage()]);
            exit;
        }
    }

    /**
     * Get a hint for a practical exercise
     * POST /ai-tutor/hint
     */
    public function getHint()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonError('Invalid request method', 405);
        }

        $user = $this->getCurrentUser();
        $input = $this->getJsonInput();

        $practicalId = (int)($input['practical_id'] ?? 0);
        if (!$practicalId) {
            $this->jsonError('Practical ID is required', 400);
        }

        // Get current hint level for this user/practical
        $hintLevel = $this->getHintLevel($user['id'], $practicalId);

        if ($hintLevel >= 3) {
            $this->jsonResponse([
                'success' => false,
                'message' => 'You have used all available hints for this exercise. Try reviewing the lesson material or ask a question in the chat!',
                'hints_remaining' => 0
            ]);
            return;
        }

        try {
            $response = $this->getTutorService()->getHint(
                $user['id'],
                $practicalId,
                $hintLevel + 1
            );

            $this->jsonResponse($response);
        } catch (\Exception $e) {
            error_log('AI Tutor hint error: ' . $e->getMessage());
            $this->jsonError('Unable to generate hint. Please try again.', 500);
        }
    }

    /**
     * Explain a concept in context
     * POST /ai-tutor/explain
     */
    public function explainConcept()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonError('Invalid request method', 405);
        }

        $user = $this->getCurrentUser();
        $input = $this->getJsonInput();

        $concept = trim($input['concept'] ?? '');
        $lessonId = (int)($input['lesson_id'] ?? 0);
        $depth = $input['depth'] ?? 'standard';

        if (empty($concept)) {
            $this->jsonError('Please specify a concept to explain', 400);
        }

        if (!$lessonId) {
            $this->jsonError('Lesson context is required', 400);
        }

        // Validate depth
        if (!in_array($depth, ['brief', 'standard', 'detailed'])) {
            $depth = 'standard';
        }

        try {
            $response = $this->getTutorService()->explainConcept(
                $user['id'],
                $lessonId,
                $concept,
                $depth
            );

            $this->jsonResponse($response);
        } catch (\Exception $e) {
            error_log('AI Tutor explain error: ' . $e->getMessage());
            $this->jsonError('Unable to generate explanation. Please try again.', 500);
        }
    }

    /**
     * Get personalized study recommendations
     * GET /ai-tutor/recommendations/:courseId
     */
    public function recommendations($courseId = null)
    {
        $user = $this->getCurrentUser();
        $courseId = (int)$courseId;

        if (!$courseId) {
            $this->jsonError('Course ID is required', 400);
        }

        // Verify user is enrolled in the course
        if (!$this->isEnrolled($user['id'], $courseId)) {
            $this->jsonError('You are not enrolled in this course', 403);
        }

        try {
            $response = $this->getTutorService()->getStudyRecommendations(
                $user['id'],
                $courseId
            );

            $this->jsonResponse($response);
        } catch (\Exception $e) {
            error_log('AI Tutor recommendations error: ' . $e->getMessage());
            $this->jsonError('Unable to generate recommendations. Please try again.', 500);
        }
    }

    /**
     * Get feedback on a completed quiz
     * GET /ai-tutor/quiz-feedback/:attemptId
     */
    public function quizFeedback($attemptId = null)
    {
        $user = $this->getCurrentUser();
        $attemptId = (int)$attemptId;

        if (!$attemptId) {
            $_SESSION['error'] = 'Quiz attempt ID is required';
            header('Location: ' . url('/dashboard'));
            exit;
        }

        try {
            $response = $this->getTutorService()->reviewQuizAttempt(
                $user['id'],
                $attemptId
            );

            if (!$response['success']) {
                $_SESSION['error'] = $response['error'] ?? 'Unable to load quiz feedback';
                header('Location: ' . url('/dashboard'));
                exit;
            }

            // Get attempt details for lesson info
            $pdo = $this->getDatabase();
            $stmt = $pdo->prepare("
                SELECT qa.*, q.lesson_id, q.title as quiz_title, 
                       l.title as lesson_title, c.slug as course_slug
                FROM quiz_attempts qa
                JOIN quizzes q ON qa.quiz_id = q.id
                JOIN lessons l ON q.lesson_id = l.id
                JOIN modules m ON l.module_id = m.id
                JOIN courses c ON m.course_id = c.id
                WHERE qa.id = ?
            ");
            $stmt->execute([$attemptId]);
            $attempt = $stmt->fetch(\PDO::FETCH_ASSOC);

            $lesson = $attempt ? [
                'id' => $attempt['lesson_id'],
                'title' => $attempt['lesson_title'],
                'course_slug' => $attempt['course_slug']
            ] : null;

            echo $this->render('ai-tutor/quiz-feedback', [
                'feedback' => $response,
                'attempt' => $attempt,
                'lesson' => $lesson,
                'title' => 'Quiz Feedback'
            ]);
        } catch (\Exception $e) {
            error_log('AI Tutor quiz feedback error: ' . $e->getMessage());
            $_SESSION['error'] = 'Unable to generate feedback. Please try again.';
            header('Location: ' . url('/dashboard'));
            exit;
        }
    }

    /**
     * Get tutor personas for UI
     * GET /ai-tutor/personas
     */
    public function personas()
    {
        $this->jsonResponse([
            'success' => true,
            'personas' => [
                [
                    'id' => 'mentor',
                    'name' => 'Alex',
                    'title' => 'Your Mentor',
                    'description' => 'Supportive guide who asks questions to help you think',
                    'icon' => '👨‍🏫',
                    'style' => 'Encouraging, Socratic method'
                ],
                [
                    'id' => 'expert',
                    'name' => 'Dr. Tech',
                    'title' => 'Industry Expert',
                    'description' => 'Shares real-world insights and best practices',
                    'icon' => '🔬',
                    'style' => 'Professional, practical examples'
                ],
                [
                    'id' => 'peer',
                    'name' => 'Sam',
                    'title' => 'Peer Tutor',
                    'description' => 'Friendly helper who explains things simply',
                    'icon' => '🧑‍💻',
                    'style' => 'Casual, uses analogies'
                ]
            ]
        ]);
    }

    // ==================== PRIVATE HELPER METHODS ====================

    /**
     * Get JSON input from request body
     */
    protected function getJsonInput(): array
    {
        $input = file_get_contents('php://input');
        return json_decode($input, true) ?? [];
    }

    /**
     * Send JSON response
     */
    protected function jsonResponse(array $data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    /**
     * Send JSON error response
     */
    protected function jsonError(string $message, int $statusCode = 400): void
    {
        $this->jsonResponse([
            'success' => false,
            'error' => $message
        ], $statusCode);
    }

    /**
     * Require authentication
     */
    protected function requireAuth(): void
    {
        if (!isset($_SESSION['user'])) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $this->jsonError('Authentication required', 401);
            } else {
                header('Location: ' . url('/login'));
                exit;
            }
        }
    }

    /**
     * Get user's course enrollments
     */
    private function getEnrollments(int $userId): array
    {
        $pdo = $this->getDatabase();
        $stmt = $pdo->prepare("
            SELECT c.id, c.title, c.level, c.thumbnail,
                   e.enrolled_at, e.progress
            FROM enrollments e
            JOIN courses c ON e.course_id = c.id
            WHERE e.user_id = ? AND e.status = 'active'
            ORDER BY e.enrolled_at DESC
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Check if user is enrolled in a course
     */
    private function isEnrolled(int $userId, int $courseId): bool
    {
        $pdo = $this->getDatabase();
        $stmt = $pdo->prepare("
            SELECT 1 FROM enrollments 
            WHERE user_id = ? AND course_id = ? AND status = 'active'
        ");
        $stmt->execute([$userId, $courseId]);
        return (bool)$stmt->fetch();
    }

    /**
     * Get current hint level for user/practical
     */
    private function getHintLevel(int $userId, int $practicalId): int
    {
        $pdo = $this->getDatabase();
        $stmt = $pdo->prepare("
            SELECT COUNT(*) as hint_count
            FROM ai_tutor_interactions
            WHERE user_id = ? AND practical_id = ? AND interaction_type = 'hint'
        ");
        $stmt->execute([$userId, $practicalId]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return (int)($result['hint_count'] ?? 0);
    }

    /**
     * Get database connection
     */
    private function getDatabase(): \PDO
    {
        static $pdo = null;
        if ($pdo === null) {
            $config = require __DIR__ . '/../../config/database.php';
            $pdo = new \PDO(
                "mysql:host={$config['host']};dbname={$config['database']};charset=utf8mb4",
                $config['username'],
                $config['password'],
                [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]
            );
        }
        return $pdo;
    }
}
