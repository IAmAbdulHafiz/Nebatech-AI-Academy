<?php

namespace Nebatech\Controllers;

use Nebatech\Core\Controller;
use PDO;

/**
 * Practical Controller - Handles practical exercises and submissions
 */
class PracticalController extends Controller
{
    private PDO $pdo;

    public function __construct()
    {
        parent::__construct();
        $this->requireAuth();
        $this->pdo = $this->getDatabase();
    }

    /**
     * Show practical exercise for a lesson
     * GET /practical/:lessonId
     */
    public function show($lessonId = null)
    {
        $user = $this->getCurrentUser();
        $lessonId = (int)$lessonId;

        if (!$lessonId) {
            $this->redirect('/dashboard');
            return;
        }

        // Get practical for this lesson
        $stmt = $this->pdo->prepare("SELECT * FROM practicals WHERE lesson_id = ? AND status = 'published' LIMIT 1");
        $stmt->execute([$lessonId]);
        $practical = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$practical) {
            $_SESSION['error'] = 'Practical exercise not found for this lesson.';
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
            $_SESSION['error'] = 'You must be enrolled in this course.';
            $this->redirect('/courses');
            return;
        }

        // Get existing submission
        $stmt = $this->pdo->prepare("
            SELECT * FROM practical_submissions 
            WHERE practical_id = ? AND user_id = ? 
            ORDER BY created_at DESC LIMIT 1
        ");
        $stmt->execute([$practical['id'], $user['id']]);
        $submission = $stmt->fetch(PDO::FETCH_ASSOC);

        // Get hint count
        $stmt = $this->pdo->prepare("
            SELECT COUNT(*) as hint_count FROM ai_tutor_interactions 
            WHERE user_id = ? AND practical_id = ? AND interaction_type = 'hint_request'
        ");
        $stmt->execute([$user['id'], $practical['id']]);
        $hintCount = $stmt->fetch(PDO::FETCH_ASSOC)['hint_count'];

        // Render practical view
        echo $this->render('practical/show', [
            'practical' => $practical,
            'lesson' => $lesson,
            'course' => [
                'id' => $lesson['course_id'],
                'title' => $lesson['course_title'],
                'slug' => $lesson['course_slug']
            ],
            'submission' => $submission,
            'hintCount' => $hintCount,
            'hintsRemaining' => max(0, 3 - $hintCount),
            'title' => $practical['title']
        ]);
    }

    /**
     * Submit practical exercise
     * POST /api/practical/submit
     */
    public function submit()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonError('Invalid request method', 405);
        }

        $user = $this->getCurrentUser();
        $input = $this->getJsonInput();

        $practicalId = (int)($input['practical_id'] ?? 0);
        $submittedCode = $input['code'] ?? '';
        $notes = $input['notes'] ?? '';

        if (!$practicalId) {
            $this->jsonError('Practical ID is required', 400);
        }

        if (empty($submittedCode)) {
            $this->jsonError('Please submit your code/work', 400);
        }

        // Get practical
        $stmt = $this->pdo->prepare("SELECT * FROM practicals WHERE id = ?");
        $stmt->execute([$practicalId]);
        $practical = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$practical) {
            $this->jsonError('Practical not found', 404);
        }

        // Check for existing submission
        $stmt = $this->pdo->prepare("
            SELECT id FROM practical_submissions 
            WHERE practical_id = ? AND user_id = ?
        ");
        $stmt->execute([$practicalId, $user['id']]);
        $existing = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existing) {
            // Update existing
            $stmt = $this->pdo->prepare("
                UPDATE practical_submissions 
                SET submitted_code = ?, submitted_content = ?, status = 'submitted', submitted_at = NOW(), attempts = attempts + 1
                WHERE id = ?
            ");
            $stmt->execute([$submittedCode, $notes, $existing['id']]);
            $submissionId = $existing['id'];
        } else {
            // Create new
            $stmt = $this->pdo->prepare("
                INSERT INTO practical_submissions (
                    practical_id, user_id, submitted_code, submitted_content, status, submitted_at, attempts
                ) VALUES (?, ?, ?, ?, 'submitted', NOW(), 1)
            ");
            $stmt->execute([$practicalId, $user['id'], $submittedCode, $notes]);
            $submissionId = $this->pdo->lastInsertId();
        }

        // Run auto-review if enabled
        $autoReview = null;
        if (!empty($practical['allow_ai_hints'])) {
            $autoReview = $this->runAutoReview($practical, $submittedCode);
            
            if ($autoReview) {
                $stmt = $this->pdo->prepare("
                    UPDATE practical_submissions 
                    SET ai_feedback = ?, score = ?, status = 'graded', graded_at = NOW()
                    WHERE id = ?
                ");
                $stmt->execute([
                    json_encode($autoReview['feedback']),
                    $autoReview['score'],
                    $submissionId
                ]);
            }
        }

        $this->jsonResponse([
            'success' => true,
            'submission_id' => $submissionId,
            'message' => 'Your work has been submitted successfully!',
            'auto_review' => $autoReview
        ]);
    }

    /**
     * Get practical status for a lesson
     * GET /api/practical/status/:lessonId
     */
    public function status($lessonId = null)
    {
        $user = $this->getCurrentUser();
        $lessonId = (int)$lessonId;

        // Get practical
        $stmt = $this->pdo->prepare("SELECT * FROM practicals WHERE lesson_id = ? AND status = 'published'");
        $stmt->execute([$lessonId]);
        $practical = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$practical) {
            $this->jsonResponse(['success' => true, 'has_practical' => false]);
            return;
        }

        // Get submission
        $stmt = $this->pdo->prepare("
            SELECT * FROM practical_submissions 
            WHERE practical_id = ? AND user_id = ? 
            ORDER BY created_at DESC LIMIT 1
        ");
        $stmt->execute([$practical['id'], $user['id']]);
        $submission = $stmt->fetch(PDO::FETCH_ASSOC);

        // Get hint count
        $stmt = $this->pdo->prepare("
            SELECT COUNT(*) as count FROM ai_tutor_interactions 
            WHERE user_id = ? AND practical_id = ? AND interaction_type = 'hint_request'
        ");
        $stmt->execute([$user['id'], $practical['id']]);
        $hintCount = $stmt->fetch(PDO::FETCH_ASSOC)['count'];

        $this->jsonResponse([
            'success' => true,
            'has_practical' => true,
            'practical' => [
                'id' => $practical['id'],
                'title' => $practical['title'],
                'difficulty' => $practical['difficulty'],
                'estimated_time' => $practical['estimated_time_minutes'],
                'max_points' => $practical['max_points']
            ],
            'submission' => $submission ? [
                'id' => $submission['id'],
                'status' => $submission['status'],
                'score' => $submission['ai_score'] ?? $submission['facilitator_score'] ?? null,
                'submitted_at' => $submission['created_at']
            ] : null,
            'hints_used' => $hintCount,
            'hints_remaining' => max(0, 3 - $hintCount)
        ]);
    }

    /**
     * Get learning objectives for a lesson
     * GET /api/objectives/:lessonId
     */
    public function objectives($lessonId = null)
    {
        $lessonId = (int)$lessonId;

        $stmt = $this->pdo->prepare("
            SELECT * FROM learning_objectives 
            WHERE lesson_id = ? 
            ORDER BY objective_number
        ");
        $stmt->execute([$lessonId]);
        $objectives = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->jsonResponse([
            'success' => true,
            'objectives' => $objectives
        ]);
    }

    // ==================== Private Helper Methods ====================

    private function runAutoReview(array $practical, string $code): ?array
    {
        // Simple auto-review based on code patterns
        $feedback = [];
        $score = 70; // Base score

        // Check if code is not empty
        if (strlen(trim($code)) < 50) {
            $feedback[] = 'Your submission seems quite short. Make sure you\'ve completed all requirements.';
            $score -= 20;
        }

        // Check for expected patterns based on practical type
        $exerciseType = $practical['exercise_type'] ?? 'coding';
        
        if ($exerciseType === 'coding') {
            // Check for comments
            if (strpos($code, '//') !== false || strpos($code, '/*') !== false || strpos($code, '#') !== false) {
                $feedback[] = '✓ Good job including comments in your code!';
                $score += 5;
            } else {
                $feedback[] = 'Consider adding comments to explain your code.';
            }

            // Check for function/method definitions
            if (preg_match('/function\s+\w+|def\s+\w+|const\s+\w+\s*=\s*\(|class\s+\w+/', $code)) {
                $feedback[] = '✓ Good code structure with proper function/class definitions.';
                $score += 10;
            }
        }

        // Ensure score is within bounds
        $score = max(0, min(100, $score));

        return [
            'score' => $score,
            'feedback' => $feedback,
            'passed' => $score >= ($practical['passing_score'] ?? 70)
        ];
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
