<?php

namespace Nebatech\Controllers;

use Nebatech\Core\Controller;
use Nebatech\Core\Database;
use Nebatech\Models\User;
use Nebatech\Repositories\EnrollmentRepository;
use Nebatech\Repositories\CertificateRepository;
use Nebatech\Repositories\SubmissionRepository;

class DashboardController extends Controller
{
    private EnrollmentRepository $enrollmentRepo;
    private CertificateRepository $certificateRepo;
    private SubmissionRepository $submissionRepo;

    public function __construct()
    {
        $this->enrollmentRepo = new EnrollmentRepository();
        $this->certificateRepo = new CertificateRepository();
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
                'thumbnail' => $enrollment['course_thumbnail'] ?? null,
                'progress' => $enrollment['progress'] ?? 0,
                'status' => $enrollment['status']
            ];
        }

        // Get pending assignments count
        $pendingSubmissions = $this->submissionRepo->getByUser($user['id'], ['status' => 'pending']);
        $pendingCount = count($pendingSubmissions);
        
        // Get upcoming deadlines
        $upcomingDeadlines = $this->getUpcomingDeadlines($user['id']);
        
        // Get learning streak
        $streak = $this->calculateLearningStreak($user['id']);
        
        // Get recent activity
        $recentActivity = $this->getRecentActivity($user['id']);
        
        // Get quick resume lesson
        $resumeLesson = $this->getLastAccessedLesson($user['id']);
        
        // Get recommended courses
        $recommendedCourses = $this->getRecommendedCourses($user['id']);

        // Student dashboard with student layout
        echo $this->render('dashboard/index', [
            'title' => 'Dashboard',
            'pageTitle' => 'Dashboard',
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
        
        echo $this->render('courses/my-courses', [
            'title' => 'My Courses',
            'pageTitle' => 'My Courses',
            'user' => $user
        ]);
    }

    /**
     * Display student's cohorts
     */
    public function myCohorts()
    {
        $user = $this->getCurrentUser();
        
        echo $this->render('cohorts/my-cohorts', [
            'title' => 'My Cohorts',
            'pageTitle' => 'My Cohorts',
            'user' => $user
        ]);
    }

    /**
     * Display student's progress dashboard
     */
    public function progressDashboard()
    {
        $user = $this->getCurrentUser();
        
        echo $this->render('progress/dashboard', [
            'title' => 'My Progress',
            'pageTitle' => 'My Progress',
            'user' => $user
        ]);
    }

    /**
     * Help Center page for students
     */
    public function helpCenter()
    {
        $user = $this->getCurrentUser();
        
        // FAQ categories with questions
        $faqCategories = [
            [
                'title' => 'Getting Started',
                'icon' => 'fas fa-rocket',
                'color' => 'blue',
                'faqs' => [
                    ['q' => 'How do I enroll in a course?', 'a' => 'Navigate to the Courses page, select a course you\'re interested in, and click the "Enroll Now" button. If you\'re part of a cohort, your facilitator may have already enrolled you.'],
                    ['q' => 'How do I access my enrolled courses?', 'a' => 'Go to "My Courses" from the sidebar to see all your enrolled courses. Click on any course to continue learning.'],
                    ['q' => 'What is a cohort?', 'a' => 'A cohort is a group of students learning together with a dedicated facilitator. You\'ll have access to group discussions, deadlines, and personalized support.'],
                ]
            ],
            [
                'title' => 'Learning & Progress',
                'icon' => 'fas fa-graduation-cap',
                'color' => 'green',
                'faqs' => [
                    ['q' => 'How is my progress tracked?', 'a' => 'Your progress is automatically tracked as you complete lessons and assignments. View your overall progress on the Dashboard or in each course.'],
                    ['q' => 'Can I retake lessons?', 'a' => 'Yes! You can revisit any lesson at any time. Simply navigate to the lesson and it will pick up where you left off.'],
                    ['q' => 'How do I submit assignments?', 'a' => 'Navigate to the assignment within your course and use the code editor or file upload option to submit your work. Your facilitator will review and provide feedback.'],
                ]
            ],
            [
                'title' => 'Certificates & Portfolio',
                'icon' => 'fas fa-certificate',
                'color' => 'yellow',
                'faqs' => [
                    ['q' => 'How do I earn a certificate?', 'a' => 'Complete all required lessons and assignments in a course to earn your certificate. Certificates are automatically generated upon course completion.'],
                    ['q' => 'Where can I view my certificates?', 'a' => 'Go to "My Certificates" from the sidebar to view and download all your earned certificates.'],
                    ['q' => 'How do I add projects to my portfolio?', 'a' => 'Visit "My Portfolio" and click "Add Project". You can showcase your best work with descriptions, images, and links.'],
                ]
            ],
            [
                'title' => 'Technical Support',
                'icon' => 'fas fa-tools',
                'color' => 'purple',
                'faqs' => [
                    ['q' => 'The code editor isn\'t working. What should I do?', 'a' => 'Try refreshing the page or clearing your browser cache. If the issue persists, try using a different browser (Chrome or Firefox recommended).'],
                    ['q' => 'I can\'t play video lessons. Help!', 'a' => 'Ensure you have a stable internet connection. Try lowering the video quality or refreshing the page. Disable browser extensions that might block video playback.'],
                    ['q' => 'How do I reset my password?', 'a' => 'Click "Forgot Password" on the login page, enter your email, and follow the instructions sent to your inbox.'],
                ]
            ],
        ];

        // Quick help resources
        $resources = [
            ['title' => 'Video Tutorials', 'description' => 'Watch step-by-step guides', 'icon' => 'fas fa-play-circle', 'color' => 'red', 'link' => '#tutorials'],
            ['title' => 'Documentation', 'description' => 'Detailed guides & references', 'icon' => 'fas fa-book', 'color' => 'blue', 'link' => '#docs'],
            ['title' => 'Community Forum', 'description' => 'Ask questions & share', 'icon' => 'fas fa-users', 'color' => 'green', 'link' => url('/community')],
            ['title' => 'Contact Support', 'description' => 'Get personalized help', 'icon' => 'fas fa-headset', 'color' => 'purple', 'link' => url('/contact')],
        ];

        echo $this->render('dashboard/help-center', [
            'title' => 'Help Center',
            'pageTitle' => 'Help Center',
            'currentPage' => 'help-center',
            'user' => $user,
            'faqCategories' => $faqCategories,
            'resources' => $resources,
        ], 'student');
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
        $sql = "SELECT lp.*, l.id as lesson_id, l.title as lesson_title,
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
     * Get recommended courses (main courses not enrolled in)
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
                  AND c.parent_course_id IS NULL
                  AND c.id NOT IN (SELECT course_id FROM enrollments WHERE user_id = :user_id)
                ORDER BY c.created_at DESC
                LIMIT 4";
        
        return Database::fetchAll($sql, ['user_id' => $userId]);
    }
}
