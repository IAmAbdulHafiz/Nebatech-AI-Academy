<?php

namespace Nebatech\Controllers\API;

use Nebatech\Core\Controller;
use Nebatech\Models\User;
use Nebatech\Services\AI\AITutorService;
use Nebatech\Services\AI\ContextManager;

/**
 * AI Tutor API Controller
 * Handles all AI tutor related API endpoints
 */
class AITutorController extends Controller
{
    private ?AITutorService $tutorService = null;
    private ?ContextManager $contextManager = null;
    private ?string $initError = null;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        try {
            $this->tutorService = new AITutorService();
            $this->contextManager = new ContextManager();
        } catch (\Exception $e) {
            $this->initError = $e->getMessage();
        }
    }

    /**
     * Check if service is properly initialized
     */
    private function checkServiceAvailable(): bool
    {
        if ($this->initError || !$this->tutorService) {
            $this->jsonResponse([
                'success' => false,
                'error' => $this->initError ?? 'AI service not available',
                'setup_required' => true
            ], 503);
            return false;
        }
        return true;
    }

    /**
     * Start a new AI tutor session
     * POST /api/ai/session/start
     */
    public function startSession(): void
    {
        $this->requireAuth();
        $userId = $_SESSION['user_id'];

        $data = $this->getJsonInput();
        
        $context = [
            'lesson_id' => $data['lesson_id'] ?? null,
            'course_id' => $data['course_id'] ?? null,
            'module_id' => $data['module_id'] ?? null,
            'type' => $data['type'] ?? 'general'
        ];

        $result = $this->tutorService->startSession($userId, $context);

        $this->jsonResponse([
            'success' => true,
            'session_id' => $result['session_id'],
            'welcome_message' => $result['welcome_message']
        ]);
    }

    /**
     * Send a message to the AI tutor
     * POST /api/ai/chat
     */
    public function chat(): void
    {
        $this->requireAuth();
        $userId = $_SESSION['user_id'];

        $data = $this->getJsonInput();
        
        if (empty($data['message'])) {
            $this->jsonResponse(['success' => false, 'error' => 'Message is required'], 400);
            return;
        }

        $message = trim($data['message']);
        $sessionId = $data['session_id'] ?? null;
        
        $context = [
            'lesson_id' => $data['lesson_id'] ?? null,
            'course_id' => $data['course_id'] ?? null,
            'module_id' => $data['module_id'] ?? null,
            'user_id' => $userId
        ];

        // Start new session if none provided
        if (!$sessionId) {
            $session = $this->tutorService->startSession($userId, $context);
            $sessionId = $session['session_id'];
        }

        $result = $this->tutorService->chat($userId, $message, $sessionId, $context);

        if ($result['success']) {
            $this->jsonResponse([
                'success' => true,
                'response' => $result['response'],
                'session_id' => $result['session_id'],
                'suggestions' => $result['suggestions'] ?? [],
                'cached' => $result['cached'] ?? false
            ]);
        } else {
            $this->jsonResponse([
                'success' => false,
                'error' => $result['error'],
                'limit_reached' => $result['limit_reached'] ?? false
            ], 400);
        }
    }

    /**
     * Review code with AI
     * POST /api/ai/review-code
     */
    public function reviewCode(): void
    {
        if (!$this->checkServiceAvailable()) return;
        $this->requireAuth();
        $userId = $_SESSION['user_id'];

        $data = $this->getJsonInput();

        if (empty($data['code'])) {
            $this->jsonResponse(['success' => false, 'error' => 'Code is required'], 400);
            return;
        }

        if (empty($data['language'])) {
            $this->jsonResponse(['success' => false, 'error' => 'Language is required'], 400);
            return;
        }

        $context = [
            'lesson_id' => $data['lesson_id'] ?? null,
            'assignment_id' => $data['assignment_id'] ?? null,
            'assignment_description' => $data['assignment_description'] ?? null
        ];

        $result = $this->tutorService->reviewCode(
            $userId,
            $data['code'],
            $data['language'],
            $context
        );

        $this->jsonResponse($result);
    }

    /**
     * Generate practice problems
     * POST /api/ai/generate-practice
     */
    public function generatePractice(): void
    {
        $this->requireAuth();
        $userId = $_SESSION['user_id'];

        $data = $this->getJsonInput();

        if (empty($data['lesson_id'])) {
            $this->jsonResponse(['success' => false, 'error' => 'Lesson ID is required'], 400);
            return;
        }

        $type = $data['type'] ?? 'mixed';
        $difficulty = $data['difficulty'] ?? 'adaptive';

        $result = $this->tutorService->generatePractice(
            $userId,
            (int)$data['lesson_id'],
            $type,
            $difficulty
        );

        $this->jsonResponse($result);
    }

    /**
     * Submit practice answer for evaluation
     * POST /api/ai/submit-practice
     */
    public function submitPractice(): void
    {
        $this->requireAuth();
        $userId = $_SESSION['user_id'];

        $data = $this->getJsonInput();

        if (empty($data['problem_id'])) {
            $this->jsonResponse(['success' => false, 'error' => 'Problem ID is required'], 400);
            return;
        }

        if (!isset($data['answer'])) {
            $this->jsonResponse(['success' => false, 'error' => 'Answer is required'], 400);
            return;
        }

        $result = $this->tutorService->submitPracticeAnswer(
            $userId,
            (int)$data['problem_id'],
            $data['answer']
        );

        $this->jsonResponse($result);
    }

    /**
     * Get personalized recommendations
     * GET /api/ai/recommendations
     */
    public function getRecommendations(): void
    {
        $this->requireAuth();
        $userId = $_SESSION['user_id'];

        $result = $this->tutorService->getRecommendations($userId);

        $this->jsonResponse($result);
    }

    /**
     * Explain a concept
     * POST /api/ai/explain
     */
    public function explainConcept(): void
    {
        $this->requireAuth();
        $userId = $_SESSION['user_id'];

        $data = $this->getJsonInput();

        if (empty($data['concept'])) {
            $this->jsonResponse(['success' => false, 'error' => 'Concept is required'], 400);
            return;
        }

        $style = $data['style'] ?? 'simple';
        $context = [
            'lesson_id' => $data['lesson_id'] ?? null,
            'course_id' => $data['course_id'] ?? null
        ];

        $result = $this->tutorService->explainConcept(
            $userId,
            $data['concept'],
            $style,
            $context
        );

        $this->jsonResponse($result);
    }

    /**
     * End a conversation session
     * POST /api/ai/session/end
     */
    public function endSession(): void
    {
        $this->requireAuth();
        $userId = $_SESSION['user_id'];

        $data = $this->getJsonInput();

        if (empty($data['session_id'])) {
            $this->jsonResponse(['success' => false, 'error' => 'Session ID is required'], 400);
            return;
        }

        $result = $this->tutorService->endSession($data['session_id'], $userId);

        $this->jsonResponse($result);
    }

    /**
     * Get conversation history
     * GET /api/ai/history
     */
    public function getHistory(): void
    {
        $this->requireAuth();
        $userId = $_SESSION['user_id'];

        $limit = (int)($_GET['limit'] ?? 10);
        
        $conversations = $this->contextManager->getRecentConversations($userId, $limit);

        $this->jsonResponse([
            'success' => true,
            'conversations' => $conversations
        ]);
    }

    /**
     * Get learning profile
     * GET /api/ai/profile
     */
    public function getProfile(): void
    {
        $this->requireAuth();
        $userId = $_SESSION['user_id'];

        $profile = $this->contextManager->getStudentProfile($userId);
        $usageStats = $this->contextManager->getUsageStats($userId);
        $strugglingTopics = $this->contextManager->identifyStrugglingTopics($userId);
        $masteredTopics = $this->contextManager->identifyMasteredTopics($userId);

        $this->jsonResponse([
            'success' => true,
            'profile' => $profile,
            'usage' => $usageStats,
            'struggling_topics' => $strugglingTopics,
            'mastered_topics' => $masteredTopics
        ]);
    }

    /**
     * Update learning preferences
     * POST /api/ai/profile/update
     */
    public function updateProfile(): void
    {
        $this->requireAuth();
        $userId = $_SESSION['user_id'];

        $data = $this->getJsonInput();

        $allowedUpdates = [
            'learning_style',
            'preferred_explanation_style',
            'preferred_difficulty'
        ];

        $updates = array_intersect_key($data, array_flip($allowedUpdates));

        if (empty($updates)) {
            $this->jsonResponse(['success' => false, 'error' => 'No valid updates provided'], 400);
            return;
        }

        $success = $this->contextManager->updateProfile($userId, $updates);

        $this->jsonResponse([
            'success' => $success,
            'message' => $success ? 'Profile updated successfully' : 'Failed to update profile'
        ]);
    }

    /**
     * Get AI usage statistics
     * GET /api/ai/usage
     */
    public function getUsage(): void
    {
        $this->requireAuth();
        $userId = $_SESSION['user_id'];

        $days = (int)($_GET['days'] ?? 30);
        $stats = $this->contextManager->getUsageStats($userId, $days);

        $this->jsonResponse([
            'success' => true,
            'stats' => $stats
        ]);
    }

    /**
     * Quick action handlers
     */
    public function quickAction(): void
    {
        $this->requireAuth();
        $userId = $_SESSION['user_id'];

        $data = $this->getJsonInput();
        $action = $data['action'] ?? '';
        
        $context = [
            'lesson_id' => $data['lesson_id'] ?? null,
            'course_id' => $data['course_id'] ?? null
        ];

        switch ($action) {
            case 'explain':
                $result = $this->tutorService->chat(
                    $userId,
                    'Please explain the main concept of this lesson in simple terms.',
                    $data['session_id'] ?? null,
                    $context
                );
                break;

            case 'example':
                $result = $this->tutorService->chat(
                    $userId,
                    'Can you show me a practical example of how to use what I\'m learning in this lesson?',
                    $data['session_id'] ?? null,
                    $context
                );
                break;

            case 'practice':
                $result = $this->tutorService->generatePractice(
                    $userId,
                    (int)($data['lesson_id'] ?? 0),
                    'mixed',
                    'adaptive'
                );
                break;

            case 'summary':
                $result = $this->tutorService->chat(
                    $userId,
                    'Please give me a brief summary of the key points from this lesson.',
                    $data['session_id'] ?? null,
                    $context
                );
                break;

            case 'hint':
                $result = $this->tutorService->chat(
                    $userId,
                    'I\'m stuck on the current exercise. Can you give me a hint without giving away the answer?',
                    $data['session_id'] ?? null,
                    $context
                );
                break;

            default:
                $this->jsonResponse(['success' => false, 'error' => 'Unknown action'], 400);
                return;
        }

        $this->jsonResponse($result);
    }

    // ========== Helper Methods ==========

    /**
     * Require authentication
     */
    protected function requireAuth(): void
    {
        if (!isset($_SESSION['user_id'])) {
            $this->jsonResponse(['success' => false, 'error' => 'Authentication required'], 401);
            exit;
        }
    }

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
}
