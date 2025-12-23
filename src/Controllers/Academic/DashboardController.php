<?php

namespace Nebatech\Controllers\Academic;

use Nebatech\Core\Controller;
use Nebatech\Core\Database;
use Nebatech\Models\Community\User;
use Nebatech\Models\Community\UserPreference;
use Nebatech\Repositories\EnrollmentRepository;
use Nebatech\Repositories\CertificateRepository;
use Nebatech\Repositories\CohortRepository;
use Nebatech\Repositories\SubmissionRepository;

class DashboardController extends Controller
{
    private EnrollmentRepository $enrollmentRepo;
    private CertificateRepository $certificateRepo;
    private CohortRepository $cohortRepo;
    private SubmissionRepository $submissionRepo;

    public function __construct()
    {
        $this->enrollmentRepo = new EnrollmentRepository();
        $this->certificateRepo = new CertificateRepository();
        $this->cohortRepo = new CohortRepository();
        $this->submissionRepo = new SubmissionRepository();
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

        // Get pending assignments count and list
        $pendingSubmissions = $this->submissionRepo->getByUser($user['id'], ['status' => 'pending']);
        $pendingCount = count($pendingSubmissions);
        
        // Get upcoming deadlines (assignments with due dates)
        $upcomingDeadlines = $this->getUpcomingDeadlines($user['id']);
        
        // Get learning streak
        $streak = $this->calculateLearningStreak($user['id']);
        
        // Get recent activity
        $recentActivity = $this->getRecentActivity($user['id']);
        
        // Get quick resume lesson (last accessed lesson)
        $resumeLesson = $this->getLastAccessedLesson($user['id']);
        
        // Get recommended courses (courses not enrolled in)
        $recommendedCourses = $this->getRecommendedCourses($user['id']);

        // Student dashboard
        echo $this->view('dashboard/index', [
            'title' => 'Dashboard',
            'user' => $user,
            'enrolledCount' => $stats['total_enrollments'] ?? 0,
            'activeCount' => $stats['active_count'] ?? 0,
            'completedCount' => $stats['completed_count'] ?? 0,
            'certificatesCount' => $certificatesCount,
            'learningHours' => $learningHours,
            'recentCourses' => $recentCourses,
            'pendingCount' => $pendingCount,
            'upcomingDeadlines' => $upcomingDeadlines,
            'streak' => $streak,
            'recentActivity' => $recentActivity,
            'resumeLesson' => $resumeLesson,
            'recommendedCourses' => $recommendedCourses
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
        
        echo $this->render('profile/index', [
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
        
        // Create uploads directory in public folder for web access
        // dirname(__DIR__, 3) goes from src/Controllers/Academic/ to project root
        $uploadDir = dirname(__DIR__, 3) . '/public/uploads/avatars/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        // Generate unique filename
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = 'avatar_' . $user['id'] . '_' . time() . '.' . $extension;
        $filepath = $uploadDir . $filename;
        
        if (move_uploaded_file($file['tmp_name'], $filepath)) {
            // Store relative path in database (without leading slash for consistency)
            $dbPath = 'uploads/avatars/' . $filename;
            // Full URL for immediate display
            $avatarUrl = base_url($dbPath);
            User::updateUser($user['id'], ['avatar' => $dbPath]);
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
        
        $result = Database::fetch($sql, ['user_id' => $userId]);
        
        // Convert seconds to hours
        $totalSeconds = $result ? (int)$result['total_seconds'] : 0;
        return round($totalSeconds / 3600, 1);
    }

    /**
     * Get upcoming assignment deadlines for a user
     */
    private function getUpcomingDeadlines(int $userId): array
    {
        $sql = "SELECT a.id, a.title as assignment_title, a.due_date, 
                       c.title as course_title, c.slug as course_slug,
                       l.id as lesson_id, l.title as lesson_title,
                       s.id as submission_id, s.status as submission_status
                FROM assignments a
                INNER JOIN lessons l ON a.lesson_id = l.id
                INNER JOIN modules m ON l.module_id = m.id
                INNER JOIN courses c ON m.course_id = c.id
                INNER JOIN enrollments e ON e.course_id = c.id AND e.user_id = :user_id
                LEFT JOIN submissions s ON s.assignment_id = a.id AND s.user_id = :user_id2
                WHERE a.due_date IS NOT NULL 
                  AND a.due_date >= CURDATE()
                  AND (s.id IS NULL OR s.status NOT IN ('verified', 'graded'))
                ORDER BY a.due_date ASC
                LIMIT 5";
        
        return Database::fetchAll($sql, ['user_id' => $userId, 'user_id2' => $userId]);
    }

    /**
     * Calculate learning streak (consecutive days with activity)
     */
    private function calculateLearningStreak(int $userId): array
    {
        // Get all activity dates for the user
        $sql = "SELECT DISTINCT DATE(last_accessed_at) as activity_date
                FROM lesson_progress
                WHERE user_id = :user_id
                ORDER BY activity_date DESC";
        
        $dates = Database::fetchAll($sql, ['user_id' => $userId]);
        
        if (empty($dates)) {
            return ['current' => 0, 'longest' => 0, 'last_activity' => null];
        }
        
        $currentStreak = 0;
        $longestStreak = 0;
        $tempStreak = 1;
        $today = new \DateTime('today');
        $yesterday = (new \DateTime('yesterday'))->format('Y-m-d');
        $todayStr = $today->format('Y-m-d');
        
        // Check if user was active today or yesterday
        $lastActivity = $dates[0]['activity_date'];
        $isActiveRecently = ($lastActivity === $todayStr || $lastActivity === $yesterday);
        
        // Calculate current streak
        if ($isActiveRecently) {
            $currentStreak = 1;
            $prevDate = new \DateTime($lastActivity);
            
            for ($i = 1; $i < count($dates); $i++) {
                $currentDate = new \DateTime($dates[$i]['activity_date']);
                $diff = $prevDate->diff($currentDate)->days;
                
                if ($diff === 1) {
                    $currentStreak++;
                    $prevDate = $currentDate;
                } else {
                    break;
                }
            }
        }
        
        // Calculate longest streak
        for ($i = 0; $i < count($dates) - 1; $i++) {
            $prevDate = new \DateTime($dates[$i]['activity_date']);
            $currentDate = new \DateTime($dates[$i + 1]['activity_date']);
            $diff = $prevDate->diff($currentDate)->days;
            
            if ($diff === 1) {
                $tempStreak++;
            } else {
                $longestStreak = max($longestStreak, $tempStreak);
                $tempStreak = 1;
            }
        }
        $longestStreak = max($longestStreak, $tempStreak);
        
        return [
            'current' => $currentStreak,
            'longest' => $longestStreak,
            'last_activity' => $lastActivity
        ];
    }

    /**
     * Get recent activity for the user
     */
    private function getRecentActivity(int $userId): array
    {
        $activities = [];
        
        // Get recent lesson progress
        $lessonProgress = Database::fetchAll(
            "SELECT lp.*, l.title as lesson_title, c.title as course_title, c.slug as course_slug,
                    'lesson' as activity_type
             FROM lesson_progress lp
             INNER JOIN lessons l ON lp.lesson_id = l.id
             INNER JOIN modules m ON l.module_id = m.id
             INNER JOIN courses c ON m.course_id = c.id
             WHERE lp.user_id = :user_id
             ORDER BY lp.last_accessed_at DESC
             LIMIT 5",
            ['user_id' => $userId]
        );
        
        foreach ($lessonProgress as $progress) {
            $activities[] = [
                'type' => 'lesson',
                'title' => $progress['lesson_title'],
                'course' => $progress['course_title'],
                'course_slug' => $progress['course_slug'],
                'status' => $progress['status'],
                'date' => $progress['last_accessed_at'],
                'icon' => 'fa-book-reader',
                'color' => $progress['status'] === 'completed' ? 'green' : 'blue'
            ];
        }
        
        // Get recent submissions
        $submissions = Database::fetchAll(
            "SELECT s.*, a.title as assignment_title, c.title as course_title, c.slug as course_slug,
                    'submission' as activity_type
             FROM submissions s
             INNER JOIN assignments a ON s.assignment_id = a.id
             INNER JOIN lessons l ON a.lesson_id = l.id
             INNER JOIN modules m ON l.module_id = m.id
             INNER JOIN courses c ON m.course_id = c.id
             WHERE s.user_id = :user_id
             ORDER BY s.submitted_at DESC
             LIMIT 5",
            ['user_id' => $userId]
        );
        
        foreach ($submissions as $submission) {
            $activities[] = [
                'type' => 'submission',
                'title' => $submission['assignment_title'],
                'course' => $submission['course_title'],
                'course_slug' => $submission['course_slug'],
                'status' => $submission['status'],
                'score' => $submission['facilitator_score'] ?? null,
                'date' => $submission['submitted_at'],
                'icon' => 'fa-paper-plane',
                'color' => $submission['status'] === 'verified' ? 'green' : 
                          ($submission['status'] === 'revision_needed' ? 'yellow' : 'purple')
            ];
        }
        
        // Sort by date and limit to 8 items
        usort($activities, function($a, $b) {
            return strtotime($b['date']) - strtotime($a['date']);
        });
        
        return array_slice($activities, 0, 8);
    }

    /**
     * Get the last accessed lesson for quick resume
     */
    private function getLastAccessedLesson(int $userId): ?array
    {
        $sql = "SELECT lp.*, l.id as lesson_id, l.title as lesson_title, l.slug as lesson_slug,
                       m.id as module_id, m.title as module_title,
                       c.id as course_id, c.title as course_title, c.slug as course_slug,
                       c.thumbnail as course_thumbnail
                FROM lesson_progress lp
                INNER JOIN lessons l ON lp.lesson_id = l.id
                INNER JOIN modules m ON l.module_id = m.id
                INNER JOIN courses c ON m.course_id = c.id
                WHERE lp.user_id = :user_id AND lp.status != 'completed'
                ORDER BY lp.last_accessed_at DESC
                LIMIT 1";
        
        return Database::fetch($sql, ['user_id' => $userId]);
    }

    /**
     * Get recommended courses (courses not enrolled in)
     */
    private function getRecommendedCourses(int $userId): array
    {
        $sql = "SELECT c.*, u.first_name as facilitator_first_name, u.last_name as facilitator_last_name,
                       cc.name as category_name,
                       (SELECT COUNT(*) FROM enrollments WHERE course_id = c.id) as enrollment_count
                FROM courses c
                LEFT JOIN users u ON c.facilitator_id = u.id
                LEFT JOIN course_categories cc ON c.category_id = cc.id
                WHERE c.status = 'published'
                  AND c.id NOT IN (SELECT course_id FROM enrollments WHERE user_id = :user_id)
                ORDER BY c.created_at DESC
                LIMIT 4";
        
        return Database::fetchAll($sql, ['user_id' => $userId]);
    }
}
