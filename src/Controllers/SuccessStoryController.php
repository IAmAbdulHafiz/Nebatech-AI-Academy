<?php

namespace Nebatech\Controllers;

use Nebatech\Core\Controller;
use Nebatech\Core\Database;

class SuccessStoryController extends Controller
{
    public function __construct()
    {
        // Start session if not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Show the success story submission form
     */
    public function showForm()
    {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['redirect_after_login'] = '/submit-story';
            return $this->render('auth.login', [
                'pageTitle' => 'Login to Submit Your Story',
                'message' => 'Please log in to submit your success story.'
            ], 'main');
        }

        $userId = $_SESSION['user_id'];

        // Get user info
        $user = Database::fetch("SELECT * FROM users WHERE id = ?", [$userId]);

        // Get user's completed courses for dropdown
        $completedCourses = [];
        try {
            $courses = Database::fetchAll(
                "SELECT c.title 
                 FROM enrollments e 
                 JOIN courses c ON e.course_id = c.id 
                 WHERE e.user_id = ? AND e.status = 'completed'",
                [$userId]
            );
            $completedCourses = array_column($courses, 'title');
        } catch (\Exception $e) {
            // Table may not exist
        }

        // Check if user already has a pending story
        $pendingStory = null;
        try {
            $pendingStory = Database::fetch(
                "SELECT * FROM success_stories WHERE user_id = ? AND status = 'pending'",
                [$userId]
            );
        } catch (\Exception $e) {
            // Table may not exist yet
        }

        // Get flash messages
        $success = $_SESSION['success'] ?? null;
        $errors = $_SESSION['errors'] ?? null;
        $old_input = $_SESSION['old_input'] ?? null;
        
        // Clear flash messages
        unset($_SESSION['success'], $_SESSION['errors'], $_SESSION['old_input']);

        return $this->render('success-stories.submit', [
            'pageTitle' => 'Share Your Success Story',
            'user' => $user,
            'completedCourses' => $completedCourses,
            'pendingStory' => $pendingStory,
            'success' => $success,
            'errors' => $errors,
            'old_input' => $old_input
        ], 'main');
    }

    /**
     * Handle success story submission
     */
    public function submit()
    {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        $userId = $_SESSION['user_id'];

        // Validate inputs
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $role = trim($_POST['role'] ?? '');
        $courseCompleted = trim($_POST['course_completed'] ?? '');
        $currentPosition = trim($_POST['current_position'] ?? '');
        $testimonial = trim($_POST['testimonial'] ?? '');

        $errors = [];

        if (empty($name)) {
            $errors[] = 'Name is required.';
        }

        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Valid email is required.';
        }

        if (empty($testimonial)) {
            $errors[] = 'Your success story is required.';
        }

        if (strlen($testimonial) < 50) {
            $errors[] = 'Please write at least 50 characters for your story.';
        }

        if (strlen($testimonial) > 1000) {
            $errors[] = 'Please keep your story under 1000 characters.';
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old_input'] = $_POST;
            header('Location: /submit-story');
            exit;
        }

        // Check if user already has a pending story
        try {
            $existing = Database::fetch(
                "SELECT id FROM success_stories WHERE user_id = ? AND status = 'pending'",
                [$userId]
            );
            if ($existing) {
                $_SESSION['errors'] = ['You already have a pending story awaiting approval.'];
                header('Location: /submit-story');
                exit;
            }
        } catch (\Exception $e) {
            // Table may not exist
        }

        try {
            // Insert the story
            Database::query(
                "INSERT INTO success_stories (user_id, name, email, role, course_completed, current_position, testimonial, status, created_at)
                 VALUES (?, ?, ?, ?, ?, ?, ?, 'pending', NOW())",
                [
                    $userId,
                    $name,
                    $email,
                    $role ?: null,
                    $courseCompleted ?: null,
                    $currentPosition ?: null,
                    $testimonial
                ]
            );

            $_SESSION['success'] = 'Thank you for sharing your story! It will be reviewed by our team and published once approved.';
            header('Location: /submit-story');
            exit;

        } catch (\PDOException $e) {
            $_SESSION['errors'] = ['An error occurred while submitting your story. Please try again.'];
            $_SESSION['old_input'] = $_POST;
            header('Location: /submit-story');
            exit;
        }
    }

    /**
     * Admin: List all success stories for review
     */
    public function adminList()
    {
        // Check admin access
        if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
            header('Location: /login');
            exit;
        }

        // Get filter
        $status = $_GET['status'] ?? 'all';
        
        $query = "SELECT s.*, u.username, u.email as user_email 
                  FROM success_stories s 
                  JOIN users u ON s.user_id = u.id";
        $params = [];
        
        if ($status !== 'all') {
            $query .= " WHERE s.status = ?";
            $params[] = $status;
        }
        
        $query .= " ORDER BY 
                    CASE s.status 
                        WHEN 'pending' THEN 1 
                        WHEN 'approved' THEN 2 
                        WHEN 'rejected' THEN 3 
                    END, 
                    s.created_at DESC";

        $stories = Database::fetchAll($query, $params);

        // Count by status
        $counts = Database::fetch(
            "SELECT 
                COUNT(*) as total,
                SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
                SUM(CASE WHEN status = 'approved' THEN 1 ELSE 0 END) as approved,
                SUM(CASE WHEN status = 'rejected' THEN 1 ELSE 0 END) as rejected
            FROM success_stories"
        );

        return $this->render('admin.success-stories', [
            'pageTitle' => 'Manage Success Stories',
            'stories' => $stories,
            'counts' => $counts,
            'currentStatus' => $status
        ], 'admin');
    }

    /**
     * Admin: Approve a success story
     */
    public function approve()
    {
        header('Content-Type: application/json');
        
        if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            return;
        }

        $storyId = $_POST['story_id'] ?? null;
        
        if (!$storyId) {
            echo json_encode(['success' => false, 'message' => 'Story ID required']);
            return;
        }

        try {
            Database::query(
                "UPDATE success_stories 
                 SET status = 'approved', 
                     reviewed_by = ?, 
                     reviewed_at = NOW(),
                     admin_notes = ?
                 WHERE id = ?",
                [
                    $_SESSION['user_id'],
                    $_POST['admin_notes'] ?? null,
                    $storyId
                ]
            );

            echo json_encode(['success' => true, 'message' => 'Story approved successfully']);

        } catch (\PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Database error']);
        }
    }

    /**
     * Admin: Reject a success story
     */
    public function reject()
    {
        header('Content-Type: application/json');
        
        if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            return;
        }

        $storyId = $_POST['story_id'] ?? null;
        
        if (!$storyId) {
            echo json_encode(['success' => false, 'message' => 'Story ID required']);
            return;
        }

        try {
            Database::query(
                "UPDATE success_stories 
                 SET status = 'rejected', 
                     reviewed_by = ?, 
                     reviewed_at = NOW(),
                     admin_notes = ?
                 WHERE id = ?",
                [
                    $_SESSION['user_id'],
                    $_POST['admin_notes'] ?? 'Your story did not meet our guidelines.',
                    $storyId
                ]
            );

            echo json_encode(['success' => true, 'message' => 'Story rejected']);

        } catch (\PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Database error']);
        }
    }

    /**
     * Admin: Delete a success story
     */
    public function delete()
    {
        header('Content-Type: application/json');
        
        if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            return;
        }

        $storyId = $_POST['story_id'] ?? null;
        
        if (!$storyId) {
            echo json_encode(['success' => false, 'message' => 'Story ID required']);
            return;
        }

        try {
            Database::query("DELETE FROM success_stories WHERE id = ?", [$storyId]);

            echo json_encode(['success' => true, 'message' => 'Story deleted']);

        } catch (\PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Database error']);
        }
    }
}
