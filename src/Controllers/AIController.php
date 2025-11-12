<?php

namespace Nebatech\Controllers;

use Nebatech\Core\Controller;
use Nebatech\Services\AIService;
use Nebatech\Models\Course;
use Nebatech\Models\Module;
use Nebatech\Models\Lesson;
use Nebatech\Models\Assignment;

class AIController extends Controller
{
    private $aiService;

    public function __construct()
    {
        parent::__construct();
        $this->requireAuth();
        $this->requireRole('facilitator');
        
        try {
            $this->aiService = new AIService();
        } catch (\Exception $e) {
            $_SESSION['error'] = $e->getMessage();
        }
    }

    /**
     * Generate course outline using AI
     */
    public function generateCourseOutline()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['success' => false, 'error' => 'Invalid request method'], 405);
            return;
        }

        $topic = trim($_POST['topic'] ?? '');
        $level = $_POST['level'] ?? 'beginner';
        $categorySlug = $_POST['category'] ?? '';
        $durationHours = (int)($_POST['duration_hours'] ?? 40);
        
        // Get category ID from slug
        $categoryId = null;
        if (!empty($categorySlug)) {
            $categoryData = \Nebatech\Core\Database::fetch(
                "SELECT id FROM course_categories WHERE slug = :slug AND is_active = 1",
                ['slug' => $categorySlug]
            );
            if ($categoryData) {
                $categoryId = $categoryData['id'];
            }
        }

        if (empty($topic)) {
            $this->jsonResponse(['success' => false, 'error' => 'Topic is required'], 400);
            return;
        }

        try {
            $modules = $this->aiService->generateCourseOutline($topic, $level, $categorySlug, $durationHours);
            
            $this->jsonResponse([
                'success' => true,
                'modules' => $modules,
                'message' => 'Course outline generated successfully'
            ]);
        } catch (\Exception $e) {
            $this->jsonResponse([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate lesson content using AI
     */
    public function generateLessonContent()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['success' => false, 'error' => 'Invalid request method'], 405);
            return;
        }

        $topic = trim($_POST['topic'] ?? '');
        $objectives = !empty($_POST['objectives']) ? json_decode($_POST['objectives'], true) : [];
        $lessonType = $_POST['lesson_type'] ?? 'text';
        $level = $_POST['level'] ?? 'beginner';

        if (empty($topic)) {
            $this->jsonResponse(['success' => false, 'error' => 'Topic is required'], 400);
            return;
        }

        try {
            $content = $this->aiService->generateLessonContent($topic, $objectives, $lessonType, $level);
            
            $this->jsonResponse([
                'success' => true,
                'content' => $content,
                'message' => 'Lesson content generated successfully'
            ]);
        } catch (\Exception $e) {
            $this->jsonResponse([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate project brief using AI
     */
    public function generateProjectBrief()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['success' => false, 'error' => 'Invalid request method'], 405);
            return;
        }

        $topic = trim($_POST['topic'] ?? '');
        $level = $_POST['level'] ?? 'intermediate';
        $skills = !empty($_POST['skills']) ? json_decode($_POST['skills'], true) : [];
        $estimatedHours = (int)($_POST['estimated_hours'] ?? 8);

        if (empty($topic)) {
            $this->jsonResponse(['success' => false, 'error' => 'Topic is required'], 400);
            return;
        }

        try {
            $projectBrief = $this->aiService->generateProjectBrief($topic, $level, $skills, $estimatedHours);
            
            $this->jsonResponse([
                'success' => true,
                'project' => $projectBrief,
                'message' => 'Project brief generated successfully'
            ]);
        } catch (\Exception $e) {
            $this->jsonResponse([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate and save complete course with modules using AI
     */
    public function generateCompleteCourse()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['success' => false, 'error' => 'Invalid request method'], 405);
            return;
        }

        $user = $this->getCurrentUser();
        $courseId = (int)($_POST['course_id'] ?? 0);
        
        // Verify course exists and belongs to facilitator
        $course = Course::findById($courseId);
        if (!$course || $course['facilitator_id'] !== $user['id']) {
            $this->jsonResponse(['success' => false, 'error' => 'Course not found or access denied'], 403);
            return;
        }

        try {
            // Generate course outline
            $modules = $this->aiService->generateCourseOutline(
                $course['title'],
                $course['level'],
                $course['category_slug'] ?? '',
                $course['duration_hours']
            );

            $createdModules = [];
            $moduleModel = new Module();

            // Create modules in database
            foreach ($modules as $moduleData) {
                $moduleId = $moduleModel->create(
                    $courseId,
                    $moduleData['title'],
                    $moduleData['description'] ?? '',
                    json_encode($moduleData['objectives'] ?? []),
                    'draft'
                );

                if ($moduleId) {
                    $createdModules[] = [
                        'id' => $moduleId,
                        'title' => $moduleData['title']
                    ];
                }
            }

            $this->jsonResponse([
                'success' => true,
                'modules' => $createdModules,
                'message' => 'Course structure generated successfully with ' . count($createdModules) . ' modules'
            ]);
        } catch (\Exception $e) {
            $this->jsonResponse([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate quiz questions using AI
     */
    public function generateQuiz()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['success' => false, 'error' => 'Invalid request method'], 405);
            return;
        }

        $topic = trim($_POST['topic'] ?? '');
        $questionCount = (int)($_POST['question_count'] ?? 5);
        $difficulty = $_POST['difficulty'] ?? 'beginner';
        $questionTypes = !empty($_POST['question_types']) ? json_decode($_POST['question_types'], true) : ['multiple_choice'];

        if (empty($topic)) {
            $this->jsonResponse(['success' => false, 'error' => 'Topic is required'], 400);
            return;
        }

        try {
            $questions = $this->aiService->generateQuizQuestions($topic, $questionCount, $difficulty, $questionTypes);
            
            $this->jsonResponse([
                'success' => true,
                'questions' => $questions,
                'message' => 'Quiz questions generated successfully'
            ]);
        } catch (\Exception $e) {
            $this->jsonResponse([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Helper method to send JSON response
     */
    protected function jsonResponse(array $data, int $statusCode = 200)
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    /**
     * Require facilitator role
     */
    private function requireRole(string $role)
    {
        $user = $this->getCurrentUser();
        if (!$user || $user['role'] !== $role) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $this->jsonResponse(['success' => false, 'error' => 'Unauthorized'], 403);
            } else {
                header('Location: ' . url('/login'));
                exit;
            }
        }
    }

    /**
     * Get current authenticated user
     */
    private function getCurrentUser()
    {
        return $_SESSION['user'] ?? null;
    }

    /**
     * Require authentication
     */
    private function requireAuth()
    {
        if (!isset($_SESSION['user'])) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $this->jsonResponse(['success' => false, 'error' => 'Authentication required'], 401);
            } else {
                header('Location: ' . url('/login'));
                exit;
            }
        }
    }
}
