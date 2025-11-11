<?php

namespace Nebatech\Services;

use Nebatech\Core\Database;
use Nebatech\Models\LessonProgress;
use Nebatech\Models\Enrollment;
use Nebatech\Models\User;

class ProgressService
{
    /**
     * Track learning streak for a user
     */
    public static function updateLearningStreak(int $userId): array
    {
        $today = date('Y-m-d');
        
        // Get or create streak record
        $sql = "SELECT * FROM learning_streaks WHERE user_id = :user_id LIMIT 1";
        $streak = Database::fetch($sql, ['user_id' => $userId]);

        if (!$streak) {
            // Create new streak record
            $data = [
                'user_id' => $userId,
                'current_streak_days' => 1,
                'longest_streak_days' => 1,
                'total_learning_days' => 1,
                'last_activity_date' => $today,
                'streak_start_date' => $today
            ];

            Database::insert('learning_streaks', $data);
            return $data;
        }

        $lastActivity = $streak['last_activity_date'];
        $yesterday = date('Y-m-d', strtotime('-1 day'));

        // Check if already logged today
        if ($lastActivity === $today) {
            return $streak;
        }

        // Calculate new streak
        if ($lastActivity === $yesterday) {
            // Continue streak
            $currentStreak = $streak['current_streak_days'] + 1;
            $longestStreak = max($currentStreak, $streak['longest_streak_days']);
        } else {
            // Streak broken, start new
            $currentStreak = 1;
            $longestStreak = $streak['longest_streak_days'];
        }

        // Update streak
        $updateData = [
            'current_streak_days' => $currentStreak,
            'longest_streak_days' => $longestStreak,
            'total_learning_days' => $streak['total_learning_days'] + 1,
            'last_activity_date' => $today,
            'streak_start_date' => $currentStreak === 1 ? $today : $streak['streak_start_date']
        ];

        Database::update(
            'learning_streaks',
            $updateData,
            'user_id = :user_id',
            ['user_id' => $userId]
        );

        return array_merge($streak, $updateData);
    }

    /**
     * Get learning streak for a user
     */
    public static function getLearningStreak(int $userId): ?array
    {
        $sql = "SELECT * FROM learning_streaks WHERE user_id = :user_id LIMIT 1";
        return Database::fetch($sql, ['user_id' => $userId]);
    }

    /**
     * Start a study session
     */
    public static function startStudySession(int $userId, ?int $enrollmentId = null): int
    {
        $data = [
            'uuid' => self::generateUUID(),
            'user_id' => $userId,
            'enrollment_id' => $enrollmentId,
            'session_start' => date('Y-m-d H:i:s'),
            'device_type' => self::getDeviceType(),
            'browser' => self::getBrowser(),
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? null
        ];

        return Database::insert('study_sessions', $data);
    }

    /**
     * End a study session
     */
    public static function endStudySession(int $sessionId): bool
    {
        $sql = "SELECT session_start FROM study_sessions WHERE id = :id LIMIT 1";
        $session = Database::fetch($sql, ['id' => $sessionId]);

        if (!$session) {
            return false;
        }

        $start = strtotime($session['session_start']);
        $end = time();
        $duration = $end - $start;

        $result = Database::update(
            'study_sessions',
            [
                'session_end' => date('Y-m-d H:i:s'),
                'duration_seconds' => $duration
            ],
            'id = :id',
            ['id' => $sessionId]
        );

        return $result > 0;
    }

    /**
     * Get comprehensive progress dashboard data
     */
    public static function getProgressDashboard(int $userId): array
    {
        // Get learning streak
        $streak = self::getLearningStreak($userId);

        // Get lesson progress stats
        $lessonStats = LessonProgress::getUserStats($userId);

        // Get enrollment stats
        $enrollmentStats = self::getEnrollmentStats($userId);

        // Get recent activity
        $recentActivity = LessonProgress::getRecentActivity($userId, 5);

        // Get time distribution
        $timeDistribution = self::getTimeDistribution($userId);

        // Get learning goals
        $goals = self::getLearningGoals($userId);

        // Calculate insights
        $insights = self::generateInsights($userId, $lessonStats, $enrollmentStats);

        return [
            'streak' => $streak,
            'lesson_stats' => $lessonStats,
            'enrollment_stats' => $enrollmentStats,
            'recent_activity' => $recentActivity,
            'time_distribution' => $timeDistribution,
            'goals' => $goals,
            'insights' => $insights
        ];
    }

    /**
     * Get enrollment statistics for a user
     */
    protected static function getEnrollmentStats(int $userId): array
    {
        $sql = "SELECT 
                    COUNT(*) as total_enrollments,
                    SUM(CASE WHEN status = 'active' THEN 1 ELSE 0 END) as active_enrollments,
                    SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) as completed_enrollments,
                    AVG(progress) as average_progress
                FROM enrollments
                WHERE user_id = :user_id";

        $stats = Database::fetch($sql, ['user_id' => $userId]);

        return $stats ?? [
            'total_enrollments' => 0,
            'active_enrollments' => 0,
            'completed_enrollments' => 0,
            'average_progress' => 0
        ];
    }

    /**
     * Get time distribution across courses
     */
    protected static function getTimeDistribution(int $userId): array
    {
        $sql = "SELECT 
                    c.title as course_title,
                    c.slug as course_slug,
                    SUM(lp.time_spent_seconds) as time_spent,
                    COUNT(DISTINCT lp.lesson_id) as lessons_accessed
                FROM lesson_progress lp
                INNER JOIN lessons l ON lp.lesson_id = l.id
                INNER JOIN modules m ON l.module_id = m.id
                INNER JOIN courses c ON m.course_id = c.id
                WHERE lp.user_id = :user_id
                GROUP BY c.id, c.title, c.slug
                ORDER BY time_spent DESC
                LIMIT 5";

        return Database::fetchAll($sql, ['user_id' => $userId]);
    }

    /**
     * Get learning goals for a user
     */
    public static function getLearningGoals(int $userId, ?string $status = 'active'): array
    {
        $sql = "SELECT * FROM learning_goals WHERE user_id = :user_id";
        $params = ['user_id' => $userId];

        if ($status) {
            $sql .= " AND status = :status";
            $params['status'] = $status;
        }

        $sql .= " ORDER BY target_date ASC";

        return Database::fetchAll($sql, $params);
    }

    /**
     * Create a learning goal
     */
    public static function createLearningGoal(array $data): ?int
    {
        $data['uuid'] = self::generateUUID();
        $data['status'] = $data['status'] ?? 'active';
        $data['current_value'] = $data['current_value'] ?? 0.00;

        return Database::insert('learning_goals', $data);
    }

    /**
     * Update learning goal progress
     */
    public static function updateGoalProgress(int $goalId, float $currentValue): bool
    {
        $sql = "SELECT * FROM learning_goals WHERE id = :id LIMIT 1";
        $goal = Database::fetch($sql, ['id' => $goalId]);

        if (!$goal) {
            return false;
        }

        $updateData = ['current_value' => $currentValue];

        // Check if goal is completed
        if ($currentValue >= $goal['target_value']) {
            $updateData['status'] = 'completed';
            $updateData['completed_date'] = date('Y-m-d');
        }

        $result = Database::update(
            'learning_goals',
            $updateData,
            'id = :id',
            ['id' => $goalId]
        );

        return $result > 0;
    }

    /**
     * Generate personalized learning insights
     */
    protected static function generateInsights(int $userId, array $lessonStats, array $enrollmentStats): array
    {
        $insights = [];

        // Time-based insights
        $totalHours = round(($lessonStats['total_time_spent'] ?? 0) / 3600, 1);
        if ($totalHours > 0) {
            $insights[] = [
                'type' => 'time',
                'icon' => 'clock',
                'title' => 'Total Learning Time',
                'value' => $totalHours . ' hours',
                'description' => 'Keep up the great work!'
            ];
        }

        // Completion rate insight
        $completionRate = $lessonStats['average_completion'] ?? 0;
        if ($completionRate > 0) {
            $insights[] = [
                'type' => 'completion',
                'icon' => 'chart-line',
                'title' => 'Average Completion',
                'value' => round($completionRate, 1) . '%',
                'description' => $completionRate >= 70 ? 'Excellent progress!' : 'Keep pushing forward!'
            ];
        }

        // Active courses insight
        $activeCourses = $enrollmentStats['active_enrollments'] ?? 0;
        if ($activeCourses > 0) {
            $insights[] = [
                'type' => 'courses',
                'icon' => 'book',
                'title' => 'Active Courses',
                'value' => $activeCourses,
                'description' => $activeCourses > 1 ? 'Managing multiple courses well!' : 'Focused learning approach'
            ];
        }

        // Bookmarks insight
        $bookmarks = $lessonStats['bookmarked_count'] ?? 0;
        if ($bookmarks > 0) {
            $insights[] = [
                'type' => 'bookmarks',
                'icon' => 'bookmark',
                'title' => 'Bookmarked Lessons',
                'value' => $bookmarks,
                'description' => 'Great for quick reference!'
            ];
        }

        return $insights;
    }

    /**
     * Get detailed course progress with module breakdown
     */
    public static function getCourseProgressDetails(int $enrollmentId): array
    {
        // Get enrollment info
        $enrollment = Enrollment::findById($enrollmentId);
        if (!$enrollment) {
            return [];
        }

        // Get module progress
        $moduleProgress = LessonProgress::getModuleProgress($enrollmentId);

        // Get resume lesson
        $resumeLesson = LessonProgress::getResumeLesson($enrollmentId);

        // Get next lesson
        $nextLesson = LessonProgress::getNextLesson($enrollmentId);

        // Get overall stats
        $sql = "SELECT * FROM course_progress_summary WHERE enrollment_id = :enrollment_id LIMIT 1";
        $summary = Database::fetch($sql, ['enrollment_id' => $enrollmentId]);

        return [
            'enrollment' => $enrollment,
            'summary' => $summary,
            'module_progress' => $moduleProgress,
            'resume_lesson' => $resumeLesson,
            'next_lesson' => $nextLesson
        ];
    }

    /**
     * Get recommended next steps for a student
     */
    public static function getRecommendedNextSteps(int $userId): array
    {
        $recommendations = [];

        // Get active enrollments
        $activeEnrollments = Enrollment::getUserEnrollments($userId, 'active');

        foreach ($activeEnrollments as $enrollment) {
            // Get next lesson
            $nextLesson = LessonProgress::getNextLesson($enrollment['id']);
            
            if ($nextLesson) {
                $recommendations[] = [
                    'type' => 'continue_learning',
                    'course_id' => $enrollment['course_id'],
                    'course_title' => $enrollment['course_title'],
                    'course_slug' => $enrollment['course_slug'],
                    'lesson_id' => $nextLesson['id'],
                    'lesson_title' => $nextLesson['title'],
                    'module_title' => $nextLesson['module_title'],
                    'priority' => 'high'
                ];
            }
        }

        return $recommendations;
    }

    /**
     * Helper: Generate UUID
     */
    protected static function generateUUID(): string
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff)
        );
    }

    /**
     * Helper: Get device type
     */
    protected static function getDeviceType(): string
    {
        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
        
        if (preg_match('/mobile|android|iphone|ipad|tablet/i', $userAgent)) {
            return 'mobile';
        }
        
        return 'desktop';
    }

    /**
     * Helper: Get browser
     */
    protected static function getBrowser(): string
    {
        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
        
        if (strpos($userAgent, 'Chrome') !== false) return 'Chrome';
        if (strpos($userAgent, 'Firefox') !== false) return 'Firefox';
        if (strpos($userAgent, 'Safari') !== false) return 'Safari';
        if (strpos($userAgent, 'Edge') !== false) return 'Edge';
        
        return 'Unknown';
    }
}
