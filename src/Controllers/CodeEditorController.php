<?php

namespace Nebatech\Controllers;

use Nebatech\Core\Controller;
use Nebatech\Models\Lesson;
use Nebatech\Models\Submission;
use Nebatech\Models\Assignment;
use Nebatech\Services\FeedbackService;

class CodeEditorController extends Controller
{
    /**
     * Show code editor for a lesson
     */
    public function index(int $lessonId = null)
    {
        $this->requireAuth();
        $user = $this->getCurrentUser();
        
        $lesson = null;
        if ($lessonId) {
            $lesson = Lesson::findById($lessonId);
            if (!$lesson) {
                $_SESSION['error'] = 'Lesson not found.';
                header('Location: ' . url('/dashboard'));
                exit;
            }
        }
        
        echo $this->view('code-editor/index', [
            'title' => 'Code Editor',
            'user' => $user,
            'lesson' => $lesson
        ]);
    }
    
    /**
     * Show code editor for an assignment
     */
    public function assignment(int $assignmentId)
    {
        $this->requireAuth();
        $user = $this->getCurrentUser();
        
        $assignment = Assignment::findById($assignmentId);
        if (!$assignment) {
            $_SESSION['error'] = 'Assignment not found.';
            header('Location: ' . url('/dashboard'));
            exit;
        }
        
        // Get the lesson
        $lesson = Lesson::findById($assignment['lesson_id']);
        
        // Check if user has already submitted
        $existingSubmission = Submission::getByUserAndAssignment($user['id'], $assignmentId);
        
        echo $this->view('code-editor/assignment', [
            'title' => 'Assignment: ' . $assignment['title'],
            'user' => $user,
            'assignment' => $assignment,
            'lesson' => $lesson,
            'submission' => $existingSubmission
        ]);
    }
    
    /**
     * Save code submission
     */
    public function saveSubmission()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['success' => false, 'error' => 'Invalid request method'], 405);
            return;
        }
        
        $this->requireAuth();
        $user = $this->getCurrentUser();
        
        $assignmentId = (int)($_POST['assignment_id'] ?? 0);
        $code = $_POST['code'] ?? '';
        
        if (!$assignmentId || empty($code)) {
            $this->jsonResponse(['success' => false, 'error' => 'Missing required fields'], 400);
            return;
        }
        
        try {
            // Save code to file
            $filename = $this->saveCodeToFile($user['id'], $assignmentId, $code);
            
            // Check if submission exists
            $existing = Submission::getByUserAndAssignment($user['id'], $assignmentId);
            
            if ($existing) {
                // Update existing submission
                Submission::update($existing['id'], [
                    'file_path' => $filename,
                    'submitted_at' => date('Y-m-d H:i:s'),
                    'status' => 'pending'
                ]);
                $submissionId = $existing['id'];
            } else {
                // Create new submission
                $submissionId = Submission::create([
                    'assignment_id' => $assignmentId,
                    'user_id' => $user['id'],
                    'file_path' => $filename,
                    'submitted_at' => date('Y-m-d H:i:s'),
                    'status' => 'pending'
                ]);
            }
            
            $this->jsonResponse([
                'success' => true,
                'message' => 'Code saved successfully',
                'submission_id' => $submissionId
            ]);
        } catch (\Exception $e) {
            error_log('Submission save error: ' . $e->getMessage());
            $this->jsonResponse([
                'success' => false,
                'error' => 'Failed to save submission'
            ], 500);
        }
    }
    
    /**
     * Submit assignment for grading
     */
    public function submitAssignment()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['success' => false, 'error' => 'Invalid request method'], 405);
            return;
        }
        
        $this->requireAuth();
        $user = $this->getCurrentUser();
        
        $assignmentId = (int)($_POST['assignment_id'] ?? 0);
        $htmlCode = $_POST['html'] ?? '';
        $cssCode = $_POST['css'] ?? '';
        $jsCode = $_POST['js'] ?? '';
        
        if (!$assignmentId) {
            $this->jsonResponse(['success' => false, 'error' => 'Assignment ID is required'], 400);
            return;
        }
        
        try {
            // Combine all code
            $fullCode = $this->buildSubmissionHTML($htmlCode, $cssCode, $jsCode);
            
            // Save code to file
            $filename = $this->saveCodeToFile($user['id'], $assignmentId, $fullCode);
            
            // Check if submission exists
            $existing = Submission::getByUserAndAssignment($user['id'], $assignmentId);
            
            if ($existing) {
                // Update existing submission
                Submission::update($existing['id'], [
                    'file_path' => $filename,
                    'submitted_at' => date('Y-m-d H:i:s'),
                    'status' => 'submitted'
                ]);
                $submissionId = $existing['id'];
            } else {
                // Create new submission
                $submissionId = Submission::create([
                    'assignment_id' => $assignmentId,
                    'user_id' => $user['id'],
                    'file_path' => $filename,
                    'submitted_at' => date('Y-m-d H:i:s'),
                    'status' => 'submitted'
                ]);
            }
            
            // Trigger AI feedback generation
            $this->generateFeedbackAsync($submissionId);
            
            $_SESSION['success'] = 'Assignment submitted successfully! AI feedback is being generated.';
            
            $this->jsonResponse([
                'success' => true,
                'message' => 'Assignment submitted successfully. Generating AI feedback...',
                'submission_id' => $submissionId
            ]);
        } catch (\Exception $e) {
            error_log('Submission error: ' . $e->getMessage());
            $this->jsonResponse([
                'success' => false,
                'error' => 'Failed to submit assignment'
            ], 500);
        }
    }
    
    /**
     * Load saved code for an assignment
     */
    public function loadCode(int $assignmentId)
    {
        $this->requireAuth();
        $user = $this->getCurrentUser();
        
        $submission = Submission::getByUserAndAssignment($user['id'], $assignmentId);
        
        if (!$submission || !$submission['file_path']) {
            $this->jsonResponse([
                'success' => false,
                'error' => 'No saved code found'
            ], 404);
            return;
        }
        
        $filePath = __DIR__ . '/../../storage/submissions/' . $submission['file_path'];
        
        if (!file_exists($filePath)) {
            $this->jsonResponse([
                'success' => false,
                'error' => 'Code file not found'
            ], 404);
            return;
        }
        
        $code = file_get_contents($filePath);
        
        // Try to parse HTML/CSS/JS if it's a complete HTML document
        $parsed = $this->parseHTMLDocument($code);
        
        $this->jsonResponse([
            'success' => true,
            'code' => $code,
            'html' => $parsed['html'] ?? '',
            'css' => $parsed['css'] ?? '',
            'js' => $parsed['js'] ?? ''
        ]);
    }
    
    /**
     * Save code to file system
     */
    private function saveCodeToFile(int $userId, int $assignmentId, string $code): string
    {
        $uploadDir = __DIR__ . '/../../storage/submissions';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        $filename = "user_{$userId}_assignment_{$assignmentId}_" . time() . '.html';
        $filepath = $uploadDir . '/' . $filename;
        
        if (file_put_contents($filepath, $code) === false) {
            throw new \Exception('Failed to write code file');
        }
        
        return $filename;
    }
    
    /**
     * Build complete HTML document from separate HTML/CSS/JS
     */
    private function buildSubmissionHTML(string $html, string $css, string $js): string
    {
        return "<!DOCTYPE html>
<html lang=\"en\">
<head>
    <meta charset=\"UTF-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <title>Submission</title>
    <style>
{$css}
    </style>
</head>
<body>
{$html}
    <script>
{$js}
    </script>
</body>
</html>";
    }
    
    /**
     * Parse HTML document to extract HTML/CSS/JS sections
     */
    private function parseHTMLDocument(string $code): array
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
            $result['html'] = trim($bodyMatches[1]);
            // Remove inline scripts from body
            $result['html'] = preg_replace('/<script[^>]*>.*?<\/script>/is', '', $result['html']);
        }
        
        return $result;
    }
    
    /**
     * Helper method to send JSON response
     */
    private function jsonResponse(array $data, int $statusCode = 200)
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
    
    /**
     * Generate AI feedback asynchronously (simulated)
     * In production, this would trigger a background job
     */
    private function generateFeedbackAsync(int $submissionId)
    {
        try {
            $feedbackService = new FeedbackService();
            
            // For now, we'll run synchronously
            // In production, queue this as a background job
            $result = $feedbackService->generateFeedback($submissionId);
            
            if ($result['success']) {
                error_log("Feedback generated successfully for submission $submissionId");
            } else {
                error_log("Feedback generation failed for submission $submissionId: " . $result['error']);
            }
        } catch (\Exception $e) {
            error_log("Feedback generation error: " . $e->getMessage());
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
