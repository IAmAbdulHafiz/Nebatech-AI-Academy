<?php

namespace Nebatech\Controllers;

use Nebatech\Core\Controller;
use Nebatech\Models\User;
use Nebatech\Models\Course;
use Nebatech\Models\Module;
use Nebatech\Models\Lesson;
use Nebatech\Models\Submission;
use Nebatech\Services\EmailService;

class FacilitatorController extends Controller
{
    public function __construct()
    {
        // Start session if not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Require authentication and facilitator role
        $this->requireAuth();
        $this->requireRole('facilitator');
    }

    /**
     * Facilitator dashboard
     */
    public function dashboard()
    {
        $user = $this->getCurrentUser();
        
        // Get facilitator's courses
        $courses = Course::getByFacilitator($user['id']);
        
        // Get pending submissions for facilitator's courses
        $courseIds = array_column($courses, 'id');
        $pendingSubmissions = [];
        
        if (!empty($courseIds)) {
            $pendingSubmissions = Submission::getPendingSubmissions(10);
        }

        // Get stats
        $stats = [
            'total_courses' => count($courses),
            'published_courses' => count(array_filter($courses, fn($c) => $c['status'] === 'published')),
            'draft_courses' => count(array_filter($courses, fn($c) => $c['status'] === 'draft')),
            'pending_submissions' => count($pendingSubmissions)
        ];

        echo $this->view('facilitator/dashboard', [
            'title' => 'Facilitator Dashboard',
            'user' => $user,
            'courses' => $courses,
            'pendingSubmissions' => $pendingSubmissions,
            'stats' => $stats
        ]);
    }

    /**
     * Show course creation form
     */
    public function createCourse()
    {
        $user = $this->getCurrentUser();
        $errors = $_SESSION['errors'] ?? [];
        $oldInput = $_SESSION['old_input'] ?? [];
        
        unset($_SESSION['errors'], $_SESSION['old_input']);

        echo $this->view('facilitator/create-course', [
            'title' => 'Create Course',
            'user' => $user,
            'errors' => $errors,
            'oldInput' => $oldInput
        ]);
    }

    /**
     * Store new course
     */
    public function storeCourse()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . url('/facilitator/courses/create'));
            exit;
        }

        $user = $this->getCurrentUser();

        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $category = $_POST['category'] ?? '';
        $level = $_POST['level'] ?? 'beginner';
        $durationHours = (int)($_POST['duration_hours'] ?? 0);
        $status = $_POST['status'] ?? 'draft';

        $errors = [];

        // Validate input
        if (empty($title)) {
            $errors['title'] = 'Course title is required.';
        } elseif (strlen($title) < 5) {
            $errors['title'] = 'Course title must be at least 5 characters.';
        }

        if (empty($description)) {
            $errors['description'] = 'Course description is required.';
        } elseif (strlen($description) < 20) {
            $errors['description'] = 'Course description must be at least 20 characters.';
        }

        if (empty($category)) {
            $errors['category'] = 'Course category is required.';
        }

        if ($durationHours < 1) {
            $errors['duration_hours'] = 'Duration must be at least 1 hour.';
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old_input'] = $_POST;
            header('Location: ' . url('/facilitator/courses/create'));
            exit;
        }

        // Handle thumbnail upload
        $thumbnail = null;
        if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === UPLOAD_ERR_OK) {
            $thumbnail = $this->handleFileUpload($_FILES['thumbnail'], 'thumbnails');
        }

        // Create course
        $courseId = Course::create([
            'title' => $title,
            'description' => $description,
            'category' => $category,
            'level' => $level,
            'duration_hours' => $durationHours,
            'thumbnail' => $thumbnail,
            'facilitator_id' => $user['id'],
            'status' => $status,
            'ai_generated' => false
        ]);

        if (!$courseId) {
            $_SESSION['errors'] = ['general' => 'Failed to create course. Please try again.'];
            $_SESSION['old_input'] = $_POST;
            header('Location: ' . url('/facilitator/courses/create'));
            exit;
        }

        $_SESSION['success'] = 'Course created successfully!';
        header('Location: ' . url('/facilitator/courses/' . $courseId . '/edit'));
        exit;
    }

    /**
     * Edit course
     */
    public function editCourse(int $courseId)
    {
        $user = $this->getCurrentUser();
        $course = Course::findById($courseId);

        if (!$course || $course['facilitator_id'] !== $user['id']) {
            $_SESSION['error'] = 'Course not found or access denied.';
            header('Location: ' . url('/facilitator/dashboard'));
            exit;
        }

        // Get course modules
        $modules = Module::getByCourse($courseId);

        $errors = $_SESSION['errors'] ?? [];
        $success = $_SESSION['success'] ?? '';
        
        unset($_SESSION['errors'], $_SESSION['success']);

        echo $this->view('facilitator/edit-course', [
            'title' => 'Edit Course',
            'user' => $user,
            'course' => $course,
            'modules' => $modules,
            'errors' => $errors,
            'success' => $success
        ]);
    }

    /**
     * Update course
     */
    public function updateCourse(int $courseId)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . url('/facilitator/courses/' . $courseId . '/edit'));
            exit;
        }

        $user = $this->getCurrentUser();
        $course = Course::findById($courseId);

        if (!$course || $course['facilitator_id'] !== $user['id']) {
            $_SESSION['error'] = 'Course not found or access denied.';
            header('Location: ' . url('/facilitator/dashboard'));
            exit;
        }

        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $category = $_POST['category'] ?? '';
        $level = $_POST['level'] ?? 'beginner';
        $durationHours = (int)($_POST['duration_hours'] ?? 0);

        $errors = [];

        if (empty($title)) {
            $errors['title'] = 'Course title is required.';
        }

        if (empty($description)) {
            $errors['description'] = 'Course description is required.';
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            header('Location: ' . url('/facilitator/courses/' . $courseId . '/edit'));
            exit;
        }

        $updateData = [
            'title' => $title,
            'description' => $description,
            'category' => $category,
            'level' => $level,
            'duration_hours' => $durationHours
        ];

        // Handle thumbnail upload
        if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === UPLOAD_ERR_OK) {
            $thumbnail = $this->handleFileUpload($_FILES['thumbnail'], 'thumbnails');
            $updateData['thumbnail'] = $thumbnail;
        }

        $updated = Course::update($courseId, $updateData);

        if ($updated) {
            $_SESSION['success'] = 'Course updated successfully!';
        } else {
            $_SESSION['errors'] = ['general' => 'Failed to update course.'];
        }

        header('Location: ' . url('/facilitator/courses/' . $courseId . '/edit'));
        exit;
    }

    /**
     * Add module to course
     */
    public function addModule(int $courseId)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . url('/facilitator/courses/' . $courseId . '/edit'));
            exit;
        }

        $user = $this->getCurrentUser();
        $course = Course::findById($courseId);

        if (!$course || $course['facilitator_id'] !== $user['id']) {
            http_response_code(403);
            echo json_encode(['error' => 'Access denied']);
            exit;
        }

        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');

        if (empty($title)) {
            http_response_code(400);
            echo json_encode(['error' => 'Module title is required']);
            exit;
        }

        $moduleId = Module::create([
            'course_id' => $courseId,
            'title' => $title,
            'description' => $description,
            'status' => 'draft'
        ]);

        if ($moduleId) {
            echo json_encode(['success' => true, 'module_id' => $moduleId]);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to create module']);
        }
        exit;
    }

    /**
     * Add lesson to module
     */
    public function addLesson(int $moduleId)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed']);
            exit;
        }

        $user = $this->getCurrentUser();
        $module = Module::findById($moduleId);

        if (!$module) {
            http_response_code(404);
            echo json_encode(['error' => 'Module not found']);
            exit;
        }

        // Verify ownership
        $course = Course::findById($module['course_id']);
        if (!$course || $course['facilitator_id'] !== $user['id']) {
            http_response_code(403);
            echo json_encode(['error' => 'Access denied']);
            exit;
        }

        $title = trim($_POST['title'] ?? '');
        $type = $_POST['type'] ?? 'text';
        $content = $_POST['content'] ?? '';

        if (empty($title)) {
            http_response_code(400);
            echo json_encode(['error' => 'Lesson title is required']);
            exit;
        }

        $lessonId = Lesson::create([
            'module_id' => $moduleId,
            'title' => $title,
            'type' => $type,
            'content' => $content,
            'ai_generated' => false
        ]);

        if ($lessonId) {
            echo json_encode(['success' => true, 'lesson_id' => $lessonId]);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to create lesson']);
        }
        exit;
    }

    /**
     * Publish course
     */
    public function publishCourse(int $courseId)
    {
        $user = $this->getCurrentUser();
        $course = Course::findById($courseId);

        if (!$course || $course['facilitator_id'] !== $user['id']) {
            $_SESSION['error'] = 'Course not found or access denied.';
            header('Location: ' . url('/facilitator/dashboard'));
            exit;
        }

        Course::publish($courseId);
        $_SESSION['success'] = 'Course published successfully!';
        
        header('Location: ' . url('/facilitator/courses/' . $courseId . '/edit'));
        exit;
    }

    /**
     * Handle file upload
     */
    private function handleFileUpload(array $file, string $subfolder = ''): ?string
    {
        $uploadDir = __DIR__ . '/../../storage/uploads/' . $subfolder;
        
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . '_' . time() . '.' . $extension;
        $filepath = $uploadDir . '/' . $filename;

        if (move_uploaded_file($file['tmp_name'], $filepath)) {
            return 'uploads/' . $subfolder . '/' . $filename;
        }

        return null;
    }

    /**
     * View all submissions for review
     */
    public function submissions()
    {
        $user = $this->getCurrentUser();
        
        // Get filter parameters
        $status = $_GET['status'] ?? 'all';
        $courseId = $_GET['course_id'] ?? null;
        
        // Get facilitator's courses
        $courses = Course::getByFacilitator($user['id']);
        $courseIds = array_column($courses, 'id');
        
        // Get submissions
        $submissions = Submission::getForFacilitator($courseIds, $status, $courseId);
        
        echo $this->view('facilitator/submissions', [
            'title' => 'Review Submissions',
            'user' => $user,
            'submissions' => $submissions,
            'courses' => $courses,
            'currentStatus' => $status,
            'currentCourseId' => $courseId
        ]);
    }
    
    /**
     * Review a specific submission
     */
    public function reviewSubmission(int $submissionId)
    {
        $user = $this->getCurrentUser();
        
        // Get submission with full details
        $submission = Submission::findById($submissionId);
        
        if (!$submission) {
            $_SESSION['error'] = 'Submission not found.';
            header('Location: ' . url('/facilitator/submissions'));
            exit;
        }
        
        // Verify facilitator owns the course
        $course = Course::findById($submission['course_id']);
        if ($course['facilitator_id'] !== $user['id']) {
            $_SESSION['error'] = 'You do not have permission to review this submission.';
            header('Location: ' . url('/facilitator/submissions'));
            exit;
        }
        
        // Load the submitted code
        $codePath = __DIR__ . '/../../storage/submissions/' . $submission['file_path'];
        $code = file_exists($codePath) ? file_get_contents($codePath) : null;
        
        // Parse code into sections
        $parsedCode = $this->parseCode($code ?? '');
        
        echo $this->view('facilitator/review-submission', [
            'title' => 'Review Submission',
            'user' => $user,
            'submission' => $submission,
            'code' => $code,
            'parsedCode' => $parsedCode
        ]);
    }
    
    /**
     * Update submission grade and comments
     */
    public function updateSubmission()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['success' => false, 'error' => 'Invalid request method'], 405);
            return;
        }
        
        $user = $this->getCurrentUser();
        
        $submissionId = (int)($_POST['submission_id'] ?? 0);
        $score = isset($_POST['score']) ? (int)$_POST['score'] : null;
        $comments = $_POST['facilitator_comments'] ?? '';
        $status = $_POST['status'] ?? 'graded';
        
        if (!$submissionId) {
            $this->jsonResponse(['success' => false, 'error' => 'Submission ID required'], 400);
            return;
        }
        
        try {
            // Get submission
            $submission = Submission::findById($submissionId);
            
            if (!$submission) {
                $this->jsonResponse(['success' => false, 'error' => 'Submission not found'], 404);
                return;
            }
            
            // Verify ownership
            $course = Course::findById($submission['course_id']);
            if ($course['facilitator_id'] !== $user['id']) {
                $this->jsonResponse(['success' => false, 'error' => 'Permission denied'], 403);
                return;
            }
            
            // Update submission
            $updateData = [
                'status' => $status,
                'facilitator_comments' => $comments,
                'graded_at' => date('Y-m-d H:i:s')
            ];
            
            // Override score if provided
            if ($score !== null) {
                $updateData['score'] = $score;
            }
            
            Submission::update($submissionId, $updateData);
            
            // Send email notification
            $emailService = new EmailService();
            $userModel = new User();
            $studentUser = $userModel->findById($submission['user_id']);
            
            if ($studentUser) {
                // Prepare submission data for email
                $submissionData = array_merge($submission, [
                    'score' => $score ?? $submission['score'],
                    'facilitator_comments' => $comments,
                    'max_score' => $submission['max_score'] ?? 100
                ]);
                
                if ($status === 'graded') {
                    // Send grade notification
                    $emailService->queueEmail('grade_notification', $studentUser, [
                        'submission' => $submissionData,
                        'user' => $studentUser
                    ]);
                } elseif ($status === 'revision_requested') {
                    // Send revision request
                    $emailService->queueEmail('revision_request', $studentUser, [
                        'submission' => $submissionData,
                        'user' => $studentUser
                    ]);
                }
            }
            
            $this->jsonResponse([
                'success' => true,
                'message' => 'Submission updated successfully'
            ]);
        } catch (\Exception $e) {
            error_log('Submission update error: ' . $e->getMessage());
            $this->jsonResponse([
                'success' => false,
                'error' => 'Failed to update submission'
            ], 500);
        }
    }
    
    /**
     * Parse HTML code into sections
     */
    private function parseCode(string $code): array
    {
        $result = ['html' => '', 'css' => '', 'js' => ''];
        
        // Extract CSS
        if (preg_match('/<style[^>]*>(.*?)<\/style>/is', $code, $cssMatches)) {
            $result['css'] = trim($cssMatches[1]);
        }
        
        // Extract JS
        if (preg_match('/<script[^>]*>(.*?)<\/script>/is', $code, $jsMatches)) {
            $result['js'] = trim($jsMatches[1]);
        }
        
        // Extract body content
        if (preg_match('/<body[^>]*>(.*?)<\/body>/is', $code, $bodyMatches)) {
            $html = trim($bodyMatches[1]);
            $html = preg_replace('/<script[^>]*>.*?<\/script>/is', '', $html);
            $result['html'] = $html;
        }
        
        return $result;
    }
    
    /**
     * JSON response helper
     */
    private function jsonResponse(array $data, int $statusCode = 200)
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    /**
     * Check if user is authenticated
     */
    protected function requireAuth(): void
    {
        if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
            $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
            header('Location: ' . url('/login'));
            exit;
        }
    }

    /**
     * Require specific role
     */
    protected function requireRole(string $role): void
    {
        if ($_SESSION['user_role'] !== $role) {
            header('Location: ' . url('/dashboard'));
            exit;
        }
    }

    /**
     * Get current authenticated user
     */
    protected function getCurrentUser(): ?array
    {
        if (!isset($_SESSION['user_id'])) {
            return null;
        }

        return User::findById($_SESSION['user_id']);
    }
}
