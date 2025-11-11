<?php

namespace Nebatech\Controllers;

use Nebatech\Core\Controller;
use Nebatech\Models\User;
use Nebatech\Models\UserPreference;
use Nebatech\Repositories\EnrollmentRepository;
use Nebatech\Repositories\CertificateRepository;
use Nebatech\Repositories\CohortRepository;

class DashboardController extends Controller
{
    private EnrollmentRepository $enrollmentRepo;
    private CertificateRepository $certificateRepo;
    private CohortRepository $cohortRepo;

    public function __construct()
    {
        $this->enrollmentRepo = new EnrollmentRepository();
        $this->certificateRepo = new CertificateRepository();
        $this->cohortRepo = new CohortRepository();
        // Start session if not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Require authentication
        $this->requireAuth();
    }

    public function index()
    {
        $user = $this->getCurrentUser();
        
        // Redirect based on role
        if ($user['role'] === 'facilitator') {
            header('Location: ' . url('/facilitator/dashboard'));
            exit;
        } elseif ($user['role'] === 'admin') {
            header('Location: ' . url('/admin/dashboard'));
            exit;
        }

        // Student dashboard - Get enrollment statistics
        $enrollments = $this->enrollmentRepo->getByUser($user['id']);
        $stats = $this->enrollmentRepo->getStatistics($user['id']);
        
        // Get certificates count
        $certificates = $this->certificateRepo->getByUser($user['id']);
        $certificatesCount = count($certificates);
        
        // Calculate total learning hours from completed lessons
        $learningHours = $this->calculateLearningHours($user['id']);
        
        // Get recent/in-progress courses (limit to 3)
        $recentCourses = [];
        foreach (array_slice($enrollments, 0, 3) as $enrollment) {
            $recentCourses[] = [
                'id' => $enrollment['course_id'],
                'title' => $enrollment['course_title'],
                'slug' => $enrollment['course_slug'],
                'thumbnail' => $enrollment['course_thumbnail'],
                'progress' => $enrollment['progress'] ?? 0,
                'status' => $enrollment['status']
            ];
        }

        // Student dashboard
        echo $this->view('dashboard/index', [
            'title' => 'Dashboard',
            'user' => $user,
            'enrolledCount' => $stats['total_enrollments'],
            'activeCount' => $stats['active_count'],
            'completedCount' => $stats['completed_count'],
            'certificatesCount' => $certificatesCount,
            'learningHours' => $learningHours,
            'recentCourses' => $recentCourses
        ]);
    }

    /**
     * Display student's enrolled courses
     */
    public function myCourses()
    {
        $user = $this->getCurrentUser();
        
        // Get user's enrollments with course details (already includes course info)
        $enrollments = $this->enrollmentRepo->getByUser($user['id']);
        
        // Get bookmarked lessons count per course
        $bookmarkedCounts = $this->getBookmarkedCountsPerCourse($user['id']);
        
        // Format enrollments as courses with enrollment data
        $courses = [];
        foreach ($enrollments as $enrollment) {
            $courseId = $enrollment['course_id'];
            $courses[] = [
                'id' => $courseId,
                'title' => $enrollment['course_title'],
                'slug' => $enrollment['course_slug'],
                'description' => $enrollment['course_description'] ?? '',
                'thumbnail' => $enrollment['course_thumbnail'],
                'level' => $enrollment['course_level'],
                'duration_hours' => $enrollment['duration_hours'],
                'facilitator_first_name' => $enrollment['facilitator_first_name'],
                'facilitator_last_name' => $enrollment['facilitator_last_name'],
                'enrollment' => $enrollment,
                'progress' => $enrollment['progress'] ?? 0,
                'status' => $enrollment['status'],
                'bookmarked_count' => $bookmarkedCounts[$courseId] ?? 0,
                // Cohort information
                'cohort_id' => $enrollment['cohort_id'] ?? null,
                'cohort_name' => $enrollment['cohort_name'] ?? null,
                'cohort_start_date' => $enrollment['cohort_start_date'] ?? null,
                'cohort_end_date' => $enrollment['cohort_end_date'] ?? null
            ];
        }
        
        echo $this->view('courses/my-courses', [
            'title' => 'My Courses',
            'user' => $user,
            'courses' => $courses
        ]);
    }

    /**
     * Display student's cohorts
     */
    public function myCohorts()
    {
        $user = $this->getCurrentUser();
        
        // Get user's cohorts
        $cohorts = $this->cohortRepo->getByStudent($user['id']);
        
        echo $this->view('cohorts/my-cohorts', [
            'title' => 'My Cohorts',
            'user' => $user,
            'cohorts' => $cohorts
        ]);
    }

    /**
     * View cohort details (student view)
     */
    public function viewCohort(int $id)
    {
        $user = $this->getCurrentUser();
        
        // Get cohort details
        $cohort = $this->cohortRepo->find($id);
        
        if (!$cohort) {
            $_SESSION['error'] = 'Cohort not found.';
            header('Location: ' . url('/my-cohorts'));
            exit;
        }
        
        // Verify student is part of this cohort
        $students = $this->cohortRepo->getStudents($id);
        $studentIds = array_column($students, 'id');
        
        if (!in_array($user['id'], $studentIds)) {
            $_SESSION['error'] = 'You do not have access to this cohort.';
            header('Location: ' . url('/my-cohorts'));
            exit;
        }
        
        // Get courses in cohort
        $courses = $this->cohortRepo->getCourses($id);
        
        // Get student's enrollments to show progress
        $enrollments = $this->enrollmentRepo->getByUser($user['id']);
        
        echo $this->view('cohorts/view-cohort', [
            'title' => $cohort['name'],
            'user' => $user,
            'cohort' => $cohort,
            'courses' => $courses,
            'students' => $students,
            'enrollments' => $enrollments
        ]);
    }

    /**
     * Display user profile
     */
    public function profile()
    {
        $user = $this->getCurrentUser();
        
        echo $this->view('profile/index', [
            'title' => 'My Profile',
            'user' => $user
        ]);
    }

    /**
     * Update user profile
     */
    public function updateProfile()
    {
        $user = $this->getCurrentUser();
        
        $data = [
            'first_name' => $_POST['first_name'] ?? '',
            'last_name' => $_POST['last_name'] ?? '',
            'phone' => $_POST['phone'] ?? '',
            'bio' => $_POST['bio'] ?? '',
            'location' => $_POST['location'] ?? '',
            'website' => $_POST['website'] ?? '',
            'github' => $_POST['github'] ?? '',
            'linkedin' => $_POST['linkedin'] ?? '',
            'twitter' => $_POST['twitter'] ?? ''
        ];
        
        if (User::updateUser($user['id'], $data)) {
            $this->jsonResponse(['success' => true, 'message' => 'Profile updated successfully']);
        } else {
            $this->jsonResponse(['success' => false, 'error' => 'Failed to update profile'], 400);
        }
    }

    /**
     * Upload avatar
     */
    public function uploadAvatar()
    {
        header('Content-Type: application/json');
        
        $user = $this->getCurrentUser();
        
        if (!isset($_FILES['avatar']) || $_FILES['avatar']['error'] !== UPLOAD_ERR_OK) {
            $this->jsonResponse(['success' => false, 'error' => 'No file uploaded'], 400);
            return;
        }
        
        $file = $_FILES['avatar'];
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $maxSize = 5 * 1024 * 1024; // 5MB
        
        if (!in_array($file['type'], $allowedTypes)) {
            $this->jsonResponse(['success' => false, 'error' => 'Invalid file type. Only JPG, PNG, GIF, and WebP allowed'], 400);
            return;
        }
        
        if ($file['size'] > $maxSize) {
            $this->jsonResponse(['success' => false, 'error' => 'File too large. Maximum 5MB'], 400);
            return;
        }
        
        // Create uploads directory if not exists
        $uploadDir = __DIR__ . '/../../public/uploads/avatars/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        // Generate unique filename
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = 'avatar_' . $user['id'] . '_' . time() . '.' . $extension;
        $filepath = $uploadDir . $filename;
        
        if (move_uploaded_file($file['tmp_name'], $filepath)) {
            $avatarUrl = '/uploads/avatars/' . $filename;
            User::updateUser($user['id'], ['avatar' => $avatarUrl]);
            $this->jsonResponse(['success' => true, 'avatar_url' => $avatarUrl]);
        } else {
            $this->jsonResponse(['success' => false, 'error' => 'Failed to upload file'], 500);
        }
    }

    /**
     * Display settings page
     */
    public function settings()
    {
        $user = $this->getCurrentUser();
        
        // Get editor settings
        $editorSettings = UserPreference::getEditorSettings($user['id']);
        
        echo $this->view('settings/index', [
            'title' => 'Settings',
            'user' => $user,
            'editorSettings' => $editorSettings
        ]);
    }

    /**
     * Update settings
     */
    public function updateSettings()
    {
        $user = $this->getCurrentUser();
        
        $data = [
            'email' => $_POST['email'] ?? $user['email'],
            'timezone' => $_POST['timezone'] ?? 'UTC',
            'language' => $_POST['language'] ?? 'en',
            'email_notifications' => isset($_POST['email_notifications']) ? 1 : 0,
            'push_notifications' => isset($_POST['push_notifications']) ? 1 : 0,
            'marketing_emails' => isset($_POST['marketing_emails']) ? 1 : 0
        ];
        
        // Validate email if changed
        if ($data['email'] !== $user['email']) {
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $this->jsonResponse(['success' => false, 'error' => 'Invalid email address'], 400);
                return;
            }
            
            // Check if email already exists
            $existing = User::findByEmail($data['email']);
            if ($existing && $existing['id'] !== $user['id']) {
                $this->jsonResponse(['success' => false, 'error' => 'Email already in use'], 400);
                return;
            }
        }
        
        if (User::updateUser($user['id'], $data)) {
            $this->jsonResponse(['success' => true, 'message' => 'Settings updated successfully']);
        } else {
            $this->jsonResponse(['success' => false, 'error' => 'Failed to update settings'], 400);
        }
    }

    /**
     * Change password
     */
    public function changePassword()
    {
        $user = $this->getCurrentUser();
        
        $currentPassword = $_POST['current_password'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';
        
        // Validate current password
        if (!password_verify($currentPassword, $user['password'])) {
            $this->jsonResponse(['success' => false, 'error' => 'Current password is incorrect'], 400);
            return;
        }
        
        // Validate new password
        if (strlen($newPassword) < 8) {
            $this->jsonResponse(['success' => false, 'error' => 'Password must be at least 8 characters'], 400);
            return;
        }
        
        if ($newPassword !== $confirmPassword) {
            $this->jsonResponse(['success' => false, 'error' => 'Passwords do not match'], 400);
            return;
        }
        
        // Update password
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        if (User::updateUser($user['id'], ['password' => $hashedPassword])) {
            $this->jsonResponse(['success' => true, 'message' => 'Password changed successfully']);
        } else {
            $this->jsonResponse(['success' => false, 'error' => 'Failed to change password'], 500);
        }
    }

    /**
     * Delete account
     */
    public function deleteAccount()
    {
        $user = $this->getCurrentUser();
        $password = $_POST['password'] ?? '';
        
        // Verify password
        if (!password_verify($password, $user['password'])) {
            $this->jsonResponse(['success' => false, 'error' => 'Password is incorrect'], 400);
            return;
        }
        
        // Soft delete or mark as inactive
        if (User::updateUser($user['id'], ['status' => 'deleted'])) {
            session_destroy();
            $this->jsonResponse(['success' => true, 'message' => 'Account deleted successfully']);
        } else {
            $this->jsonResponse(['success' => false, 'error' => 'Failed to delete account'], 500);
        }
    }

    /**
     * Update editor settings
     */
    public function updateEditorSettings()
    {
        header('Content-Type: application/json');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['success' => false, 'error' => 'Invalid request method'], 400);
            return;
        }

        $user = $this->getCurrentUser();
        if (!$user) {
            $this->jsonResponse(['success' => false, 'error' => 'Unauthorized'], 401);
            return;
        }

        try {
            // Get JSON input
            $input = file_get_contents('php://input');
            $data = json_decode($input, true);

            if (!isset($data['editor_settings'])) {
                $this->jsonResponse(['success' => false, 'error' => 'No editor settings provided'], 400);
                return;
            }

            $editorSettings = $data['editor_settings'];
            
            // Validate and sanitize settings
            $validSettings = [
                'theme' => $editorSettings['theme'] ?? 'github-light',
                'fontSize' => (int)($editorSettings['fontSize'] ?? 14),
                'lineNumbers' => (bool)($editorSettings['lineNumbers'] ?? true),
                'lineWrapping' => (bool)($editorSettings['lineWrapping'] ?? false),
                'tabSize' => (int)($editorSettings['tabSize'] ?? 4),
                'indentWithTabs' => (bool)($editorSettings['indentWithTabs'] ?? false),
                'autoCloseBrackets' => (bool)($editorSettings['autoCloseBrackets'] ?? true),
                'language' => $editorSettings['language'] ?? 'javascript',
                'keyMap' => $editorSettings['keyMap'] ?? 'default'
            ];

            // Save to database
            UserPreference::setEditorSettings($user['id'], $validSettings);

            $this->jsonResponse([
                'success' => true,
                'message' => 'Editor settings updated successfully',
                'settings' => $validSettings
            ]);
        } catch (\Exception $e) {
            $this->jsonResponse(['success' => false, 'error' => $e->getMessage()], 500);
        }
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
     * Get current authenticated user
     */
    protected function getCurrentUser(): ?array
    {
        if (!isset($_SESSION['user_id'])) {
            return null;
        }

        return User::findById($_SESSION['user_id']);
    }

    /**
     * Get bookmarked lessons count per course for a user
     */
    private function getBookmarkedCountsPerCourse(int $userId): array
    {
        $sql = "SELECT c.id as course_id, COUNT(lp.id) as bookmark_count
                FROM lesson_progress lp
                INNER JOIN lessons l ON lp.lesson_id = l.id
                INNER JOIN modules m ON l.module_id = m.id
                INNER JOIN courses c ON m.course_id = c.id
                WHERE lp.user_id = :user_id AND lp.bookmarked = 1
                GROUP BY c.id";
        
        $results = \Nebatech\Core\Database::fetchAll($sql, ['user_id' => $userId]);
        
        $counts = [];
        foreach ($results as $row) {
            $counts[$row['course_id']] = (int)$row['bookmark_count'];
        }
        
        return $counts;
    }

    /**
     * Calculate total learning hours from time spent on lessons
     */
    private function calculateLearningHours(int $userId): float
    {
        $sql = "SELECT COALESCE(SUM(time_spent_seconds), 0) as total_seconds
                FROM lesson_progress
                WHERE user_id = :user_id";
        
        $result = \Nebatech\Core\Database::fetch($sql, ['user_id' => $userId]);
        
        // Convert seconds to hours
        $totalSeconds = $result ? (int)$result['total_seconds'] : 0;
        return round($totalSeconds / 3600, 1);
    }
}
