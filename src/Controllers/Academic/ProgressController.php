<?php

namespace Nebatech\Controllers\Academic;

use Nebatech\Core\Controller;
use Nebatech\Models\Academic\LessonProgress;
use Nebatech\Services\ProgressService;

class ProgressController extends Controller
{
    /**
     * Mark lesson as completed (AJAX endpoint)
     */
    public function markLessonComplete()
    {
        header('Content-Type: application/json');

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            exit;
        }

        $data = json_decode(file_get_contents('php://input'), true);
        $lessonId = $data['lesson_id'] ?? null;
        $enrollmentId = $data['enrollment_id'] ?? null;

        if (!$lessonId || !$enrollmentId) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Missing required fields']);
            exit;
        }

        $success = LessonProgress::markAsCompleted(
            $_SESSION['user_id'],
            $lessonId,
            $enrollmentId
        );

        if ($success) {
            // Update streak
            ProgressService::updateLearningStreak($_SESSION['user_id']);

            echo json_encode([
                'success' => true,
                'message' => 'Lesson marked as completed'
            ]);
        } else {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Failed to update progress'
            ]);
        }
    }

    /**
     * Update lesson progress (AJAX endpoint)
     */
    public function updateLessonProgress()
    {
        header('Content-Type: application/json');

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            exit;
        }

        $data = json_decode(file_get_contents('php://input'), true);
        $lessonId = $data['lesson_id'] ?? null;
        $enrollmentId = $data['enrollment_id'] ?? null;
        $percentage = $data['percentage'] ?? null;
        $lastPosition = $data['last_position'] ?? null;

        if (!$lessonId || !$enrollmentId || $percentage === null) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Missing required fields']);
            exit;
        }

        $success = LessonProgress::updateProgress(
            $_SESSION['user_id'],
            $lessonId,
            $enrollmentId,
            $percentage,
            $lastPosition
        );

        if ($success) {
            echo json_encode([
                'success' => true,
                'message' => 'Progress updated'
            ]);
        } else {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Failed to update progress'
            ]);
        }
    }

    /**
     * Track time spent on lesson (AJAX endpoint)
     */
    public function trackTime()
    {
        header('Content-Type: application/json');

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            exit;
        }

        $data = json_decode(file_get_contents('php://input'), true);
        $lessonId = $data['lesson_id'] ?? null;
        $seconds = $data['seconds'] ?? null;

        if (!$lessonId || !$seconds) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Missing required fields']);
            exit;
        }

        $success = LessonProgress::trackTimeSpent(
            $_SESSION['user_id'],
            $lessonId,
            $seconds
        );

        if ($success) {
            echo json_encode([
                'success' => true,
                'message' => 'Time tracked'
            ]);
        } else {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Failed to track time'
            ]);
        }
    }

    /**
     * Toggle lesson bookmark (AJAX endpoint)
     */
    public function toggleBookmark()
    {
        header('Content-Type: application/json');

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            exit;
        }

        $data = json_decode(file_get_contents('php://input'), true);
        $lessonId = $data['lesson_id'] ?? null;

        if (!$lessonId) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Missing lesson_id']);
            exit;
        }

        $success = LessonProgress::toggleBookmark($_SESSION['user_id'], $lessonId);

        if ($success) {
            $progress = LessonProgress::findByUserAndLesson($_SESSION['user_id'], $lessonId);
            echo json_encode([
                'success' => true,
                'bookmarked' => $progress['bookmarked'] ?? false
            ]);
        } else {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Failed to toggle bookmark'
            ]);
        }
    }

    /**
     * Save lesson notes (AJAX endpoint)
     */
    public function saveNotes()
    {
        header('Content-Type: application/json');

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            exit;
        }

        $data = json_decode(file_get_contents('php://input'), true);
        $lessonId = $data['lesson_id'] ?? null;
        $notes = $data['notes'] ?? '';

        if (!$lessonId) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Missing lesson_id']);
            exit;
        }

        $success = LessonProgress::saveNotes($_SESSION['user_id'], $lessonId, $notes);

        if ($success) {
            echo json_encode([
                'success' => true,
                'message' => 'Notes saved'
            ]);
        } else {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Failed to save notes'
            ]);
        }
    }

    /**
     * Get progress dashboard
     */
    public function dashboard()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . url('/login'));
            exit;
        }

        $user = \Nebatech\Models\User::findById($_SESSION['user_id']);
        $dashboardData = ProgressService::getProgressDashboard($_SESSION['user_id']);

        echo $this->view('progress/dashboard', [
            'title' => 'My Progress',
            'user' => $user,
            'data' => $dashboardData
        ]);
    }

    /**
     * Get bookmarked lessons
     */
    public function bookmarks()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . url('/login'));
            exit;
        }

        $user = \Nebatech\Models\User::findById($_SESSION['user_id']);
        $courseId = $_GET['course'] ?? null;
        
        // Get bookmarks, optionally filtered by course
        if ($courseId) {
            $bookmarks = LessonProgress::getBookmarkedLessonsByCourse($_SESSION['user_id'], (int)$courseId);
            $course = \Nebatech\Models\Course::findById((int)$courseId);
            $pageTitle = 'Bookmarks - ' . ($course['title'] ?? 'Course');
        } else {
            $bookmarks = LessonProgress::getBookmarkedLessons($_SESSION['user_id']);
            $pageTitle = 'Bookmarked Lessons';
        }

        echo $this->view('progress/bookmarks', [
            'title' => $pageTitle,
            'user' => $user,
            'bookmarks' => $bookmarks,
            'filteredCourseId' => $courseId
        ]);
    }
}
