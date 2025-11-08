<?php

namespace Nebatech\Controllers;

use Nebatech\Core\Controller;
use Nebatech\Models\Submission;
use Nebatech\Services\FeedbackService;

class FeedbackController extends Controller
{
    private FeedbackService $feedbackService;

    public function __construct()
    {
        $this->feedbackService = new FeedbackService();
    }

    /**
     * View feedback for a submission
     */
    public function view(array $params = [])
    {
        $submissionId = (int) ($params['id'] ?? 0);
        if (!$submissionId) {
            $_SESSION['error'] = 'Invalid submission ID.';
            header('Location: ' . url('/dashboard'));
            exit;
        }

        $this->requireAuth();
        $user = $this->getCurrentUser();
        
        $submission = Submission::findById($submissionId);
        
        if (!$submission) {
            $_SESSION['error'] = 'Submission not found.';
            header('Location: ' . url('/dashboard'));
            exit;
        }
        
        // Check if user owns this submission (or is facilitator)
        if ($submission['user_id'] !== $user['id'] && $user['role'] !== 'facilitator') {
            $_SESSION['error'] = 'You do not have permission to view this feedback.';
            header('Location: ' . url('/dashboard'));
            exit;
        }
        
        $feedback = $this->feedbackService->getFeedbackDetails($submissionId);
        
        echo $this->render('feedback/view', [
            'title' => 'Assignment Feedback',
            'user' => $user,
            'submission' => $submission,
            'feedback' => $feedback
        ]);
    }

    /**
     * Regenerate feedback for a submission (facilitator only)
     */
    public function regenerate(array $params = [])
    {
        $submissionId = (int) ($params['id'] ?? 0);
        if (!$submissionId) {
            $this->jsonResponse([
                'success' => false,
                'error' => 'Invalid submission ID'
            ], 400);
            return;
        }

        $this->requireAuth();
        $user = $this->getCurrentUser();
        
        if ($user['role'] !== 'facilitator') {
            $this->jsonResponse([
                'success' => false,
                'error' => 'Only facilitators can regenerate feedback'
            ], 403);
            return;
        }
        
        try {
            $result = $this->feedbackService->regenerateFeedback($submissionId);
            
            $this->jsonResponse($result);
        } catch (\Exception $e) {
            $this->jsonResponse([
                'success' => false,
                'error' => 'Failed to regenerate feedback: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get feedback details via API
     */
    public function getFeedback(array $params = [])
    {
        $submissionId = (int) ($params['id'] ?? 0);
        if (!$submissionId) {
            $this->jsonResponse([
                'success' => false,
                'error' => 'Invalid submission ID'
            ], 400);
            return;
        }

        $this->requireAuth();
        $user = $this->getCurrentUser();
        
        $submission = Submission::findById($submissionId);
        
        if (!$submission) {
            $this->jsonResponse([
                'success' => false,
                'error' => 'Submission not found'
            ], 404);
            return;
        }
        
        // Check permissions
        if ($submission['user_id'] !== $user['id'] && $user['role'] !== 'facilitator') {
            $this->jsonResponse([
                'success' => false,
                'error' => 'Permission denied'
            ], 403);
            return;
        }
        
        $feedback = $this->feedbackService->getFeedbackDetails($submissionId);
        
        $this->jsonResponse([
            'success' => true,
            'feedback' => $feedback,
            'submission' => [
                'id' => $submission['id'],
                'status' => $submission['status'],
                'submitted_at' => $submission['submitted_at'],
                'graded_at' => $submission['graded_at']
            ]
        ]);
    }

    /**
     * Batch generate feedback for pending submissions (facilitator only)
     */
    public function generateBatch()
    {
        $this->requireAuth();
        $user = $this->getCurrentUser();
        
        if ($user['role'] !== 'facilitator') {
            $this->jsonResponse([
                'success' => false,
                'error' => 'Only facilitators can generate batch feedback'
            ], 403);
            return;
        }
        
        $submissionIds = $_POST['submission_ids'] ?? [];
        
        if (empty($submissionIds)) {
            $this->jsonResponse([
                'success' => false,
                'error' => 'No submissions selected'
            ], 400);
            return;
        }
        
        try {
            $results = $this->feedbackService->generateBatchFeedback($submissionIds);
            
            $successCount = count(array_filter($results, fn($r) => $r['success']));
            $totalCount = count($results);
            
            $this->jsonResponse([
                'success' => true,
                'message' => "Generated feedback for $successCount of $totalCount submissions",
                'results' => $results
            ]);
        } catch (\Exception $e) {
            $this->jsonResponse([
                'success' => false,
                'error' => 'Batch generation failed: ' . $e->getMessage()
            ], 500);
        }
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
