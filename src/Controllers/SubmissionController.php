<?php

namespace Nebatech\Controllers;

use Nebatech\Core\Controller;
use Nebatech\Models\Assignment;
use Nebatech\Models\User;
use Nebatech\Repositories\SubmissionRepository;
use Nebatech\Services\AIService;

class SubmissionController extends Controller
{
    private const MAX_FILE_SIZE = 10485760; // 10MB
    private const ALLOWED_EXTENSIONS = [
        'pdf', 'doc', 'docx', 'txt', 'zip', 'rar', '7z',
        'jpg', 'jpeg', 'png', 'gif', 'svg',
        'html', 'css', 'js', 'php', 'py', 'java', 'cpp', 'c', 'cs',
        'json', 'xml', 'md', 'sql'
    ];

    private SubmissionRepository $submissionRepo;

    public function __construct()
    {
        $this->submissionRepo = new SubmissionRepository();
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->requireAuth();
        $this->requireRole('student');
    }

    /**
     * Show submission form for an assignment
     */
    public function create(int $assignmentId)
    {
        $user = $this->getCurrentUser();
        $assignment = Assignment::findById($assignmentId);

        if (!$assignment) {
            $_SESSION['error'] = 'Assignment not found';
            header('Location: ' . url('/my-courses'));
            exit;
        }

        // Check if student already submitted
        $existingSubmission = $this->submissionRepo->findByUserAndAssignment($user['id'], $assignmentId);

        echo $this->view('student/submit-assignment', [
            'title' => 'Submit Assignment',
            'user' => $user,
            'assignment' => $assignment,
            'existingSubmission' => $existingSubmission
        ]);
    }

    /**
     * Store a new submission
     */
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . url('/my-courses'));
            exit;
        }

        $user = $this->getCurrentUser();
        $assignmentId = (int)($_POST['assignment_id'] ?? 0);
        $contentType = $_POST['content_type'] ?? 'text';

        $assignment = Assignment::findById($assignmentId);
        if (!$assignment) {
            $_SESSION['error'] = 'Assignment not found';
            header('Location: ' . url('/my-courses'));
            exit;
        }

        // Check if already submitted
        $existingSubmission = $this->submissionRepo->findByUserAndAssignment($user['id'], $assignmentId);
        if ($existingSubmission && $existingSubmission['status'] !== 'revision_needed') {
            $_SESSION['error'] = 'You have already submitted this assignment';
            header('Location: ' . url('/assignment/' . $assignmentId));
            exit;
        }

        $data = [
            'assignment_id' => $assignmentId,
            'user_id' => $user['id'],
            'content_type' => $contentType,
            'status' => 'pending'
        ];

        // Handle different submission types
        switch ($contentType) {
            case 'text':
                $data['content'] = trim($_POST['content'] ?? '');
                if (empty($data['content'])) {
                    $_SESSION['error'] = 'Please provide your submission content';
                    header('Location: ' . url('/assignment/' . $assignmentId . '/submit'));
                    exit;
                }
                break;

            case 'code':
                $data['content'] = trim($_POST['code'] ?? '');
                $data['repository_url'] = trim($_POST['repository_url'] ?? '');
                
                if (empty($data['content']) && empty($data['repository_url'])) {
                    $_SESSION['error'] = 'Please provide code or repository URL';
                    header('Location: ' . url('/assignment/' . $assignmentId . '/submit'));
                    exit;
                }
                break;

            case 'file':
                if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
                    $_SESSION['error'] = 'Please upload a file';
                    header('Location: ' . url('/assignment/' . $assignmentId . '/submit'));
                    exit;
                }

                $uploadResult = $this->handleFileUpload($_FILES['file'], 'submissions');
                if (!$uploadResult) {
                    $_SESSION['error'] = 'File upload failed. Please try again.';
                    header('Location: ' . url('/assignment/' . $assignmentId . '/submit'));
                    exit;
                }

                $data['file_path'] = $uploadResult['path'];
                $data['file_name'] = $uploadResult['name'];
                $data['file_size'] = $uploadResult['size'];
                $data['content'] = $_POST['description'] ?? '';
                break;

            case 'url':
                $data['repository_url'] = trim($_POST['url'] ?? '');
                $data['content'] = trim($_POST['description'] ?? '');
                
                if (empty($data['repository_url'])) {
                    $_SESSION['error'] = 'Please provide a URL';
                    header('Location: ' . url('/assignment/' . $assignmentId . '/submit'));
                    exit;
                }

                if (!filter_var($data['repository_url'], FILTER_VALIDATE_URL)) {
                    $_SESSION['error'] = 'Please provide a valid URL';
                    header('Location: ' . url('/assignment/' . $assignmentId . '/submit'));
                    exit;
                }
                break;
        }

        // Get AI feedback if enabled
        if ($assignment['ai_feedback_enabled'] && !empty($data['content'])) {
            try {
                $aiService = new AIService();
                $aiFeedback = $aiService->evaluateSubmission(
                    $data['content'],
                    $assignment['description'],
                    $assignment['rubric'] ?? []
                );
                
                if ($aiFeedback) {
                    $data['ai_feedback'] = $aiFeedback; // Store entire feedback object
                    $data['ai_score'] = $aiFeedback['score'];
                }
            } catch (\Exception $e) {
                error_log("AI feedback failed: " . $e->getMessage());
                // Continue without AI feedback
            }
        }

        // Create or update submission
        if ($existingSubmission) {
            $success = $this->submissionRepo->update($existingSubmission['id'], $data);
            $submissionId = $existingSubmission['id'];
        } else {
            $submissionId = $this->submissionRepo->create($data);
            $success = $submissionId !== null;
        }

        if ($success) {
            $_SESSION['success'] = 'Assignment submitted successfully!';
            header('Location: ' . url('/submission/' . $submissionId));
        } else {
            $_SESSION['error'] = 'Failed to submit assignment. Please try again.';
            header('Location: ' . url('/assignment/' . $assignmentId . '/submit'));
        }
        exit;
    }

    /**
     * View a submission
     */
    public function viewSubmission(int $submissionId)
    {
        $user = $this->getCurrentUser();
        $submission = $this->submissionRepo->find($submissionId);

        if (!$submission || $submission['user_id'] !== $user['id']) {
            $_SESSION['error'] = 'Submission not found';
            header('Location: ' . url('/my-courses'));
            exit;
        }

        // Check if submission is already in portfolio
        $inPortfolio = \Nebatech\Models\Portfolio::submissionInPortfolio($submissionId);

        echo $this->view('student/view-submission', [
            'title' => 'View Submission',
            'user' => $user,
            'submission' => $submission,
            'inPortfolio' => $inPortfolio
        ]);
    }

    /**
     * Update a submission (for revisions)
     */
    public function update(int $submissionId)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . url('/submission/' . $submissionId));
            exit;
        }

        $user = $this->getCurrentUser();
        $submission = $this->submissionRepo->find($submissionId);

        if (!$submission || $submission['user_id'] !== $user['id']) {
            $_SESSION['error'] = 'Submission not found';
            header('Location: ' . url('/my-courses'));
            exit;
        }

        if ($submission['status'] !== 'revision_needed') {
            $_SESSION['error'] = 'This submission cannot be updated';
            header('Location: ' . url('/submission/' . $submissionId));
            exit;
        }

        // Similar logic to store() but updating existing submission
        $contentType = $submission['content_type'];
        $data = ['status' => 'pending'];

        switch ($contentType) {
            case 'text':
            case 'code':
                $data['content'] = trim($_POST['content'] ?? '');
                if (isset($_POST['repository_url'])) {
                    $data['repository_url'] = trim($_POST['repository_url']);
                }
                break;

            case 'file':
                if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
                    // Delete old file
                    if ($submission['file_path']) {
                        $oldFilePath = __DIR__ . '/../../storage/' . $submission['file_path'];
                        if (file_exists($oldFilePath)) {
                            unlink($oldFilePath);
                        }
                    }

                    $uploadResult = $this->handleFileUpload($_FILES['file'], 'submissions');
                    if ($uploadResult) {
                        $data['file_path'] = $uploadResult['path'];
                        $data['file_name'] = $uploadResult['name'];
                        $data['file_size'] = $uploadResult['size'];
                    }
                }
                if (isset($_POST['description'])) {
                    $data['content'] = trim($_POST['description']);
                }
                break;

            case 'url':
                if (isset($_POST['url'])) {
                    $data['repository_url'] = trim($_POST['url']);
                }
                if (isset($_POST['description'])) {
                    $data['content'] = trim($_POST['description']);
                }
                break;
        }

        $success = $this->submissionRepo->update($submissionId, $data);

        if ($success) {
            $_SESSION['success'] = 'Submission updated successfully!';
        } else {
            $_SESSION['error'] = 'Failed to update submission';
        }

        header('Location: ' . url('/submission/' . $submissionId));
        exit;
    }

    /**
     * Download submission file
     */
    public function download(int $submissionId)
    {
        $user = $this->getCurrentUser();
        $submission = $this->submissionRepo->find($submissionId);

        if (!$submission) {
            http_response_code(404);
            echo 'Submission not found';
            exit;
        }

        // Check access: owner or facilitator of the course
        $hasAccess = $submission['user_id'] === $user['id'];
        
        if (!$hasAccess && $user['role'] === 'facilitator') {
            // Check if facilitator owns the course
            $sql = "SELECT c.facilitator_id 
                    FROM courses c
                    INNER JOIN modules m ON c.id = m.course_id
                    INNER JOIN lessons l ON m.id = l.module_id
                    INNER JOIN assignments a ON l.id = a.lesson_id
                    WHERE a.id = :assignment_id";
            
            $courseData = \Nebatech\Core\Database::fetch($sql, ['assignment_id' => $submission['assignment_id']]);
            $hasAccess = $courseData && $courseData['facilitator_id'] === $user['id'];
        }

        if (!$hasAccess) {
            http_response_code(403);
            echo 'Access denied';
            exit;
        }

        if (!$submission['file_path']) {
            http_response_code(404);
            echo 'No file attached';
            exit;
        }

        $filePath = __DIR__ . '/../../storage/' . $submission['file_path'];
        
        if (!file_exists($filePath)) {
            http_response_code(404);
            echo 'File not found';
            exit;
        }

        $fileName = $submission['file_name'] ?? basename($filePath);
        $fileSize = filesize($filePath);
        $mimeType = mime_content_type($filePath);

        header('Content-Type: ' . $mimeType);
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        header('Content-Length: ' . $fileSize);
        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: 0');

        readfile($filePath);
        exit;
    }

    /**
     * Handle file upload with validation
     */
    private function handleFileUpload(array $file, string $subfolder = ''): ?array
    {
        // Validate file size
        if ($file['size'] > self::MAX_FILE_SIZE) {
            $_SESSION['error'] = 'File size exceeds maximum allowed (10MB)';
            return null;
        }

        // Validate file extension
        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($extension, self::ALLOWED_EXTENSIONS)) {
            $_SESSION['error'] = 'File type not allowed';
            return null;
        }

        // Create upload directory
        $uploadDir = __DIR__ . '/../../storage/uploads/' . $subfolder;
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Generate unique filename
        $filename = uniqid() . '_' . time() . '.' . $extension;
        $filepath = $uploadDir . '/' . $filename;

        // Move uploaded file
        if (move_uploaded_file($file['tmp_name'], $filepath)) {
            return [
                'path' => 'uploads/' . $subfolder . '/' . $filename,
                'name' => $file['name'],
                'size' => $file['size']
            ];
        }

        return null;
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
