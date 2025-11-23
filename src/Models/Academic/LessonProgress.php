<?php

namespace Nebatech\Models\Academic;

use Nebatech\Core\Model;
use Nebatech\Core\Database;

class LessonProgress extends Model
{
    protected string $table = 'lesson_progress';
    protected string $primaryKey = 'id';

    /**
     * Create or update lesson progress
     */
    public static function createOrUpdate(array $data): ?int
    {
        // Check if progress record exists
        $existing = self::findByUserAndLesson($data['user_id'], $data['lesson_id']);

        if ($existing) {
            // Update existing record
            $updateData = array_merge($data, [
                'last_accessed_at' => date('Y-m-d H:i:s'),
                'revisit_count' => ($existing['revisit_count'] ?? 0) + 1
            ]);

            unset($updateData['user_id'], $updateData['lesson_id'], $updateData['enrollment_id']);

            Database::update(
                'lesson_progress',
                $updateData,
                'id = :id',
                ['id' => $existing['id']]
            );

            return $existing['id'];
        }

        // Create new record
        $data['uuid'] = self::generateUUID();
        $data['first_accessed_at'] = date('Y-m-d H:i:s');
        $data['last_accessed_at'] = date('Y-m-d H:i:s');

        return Database::insert('lesson_progress', $data);
    }

    /**
     * Find progress by user and lesson
     */
    public static function findByUserAndLesson(int $userId, int $lessonId): ?array
    {
        $sql = "SELECT * FROM lesson_progress 
                WHERE user_id = :user_id AND lesson_id = :lesson_id 
                LIMIT 1";

        return Database::fetch($sql, [
            'user_id' => $userId,
            'lesson_id' => $lessonId
        ]);
    }

    /**
     * Get all progress for a user's enrollment
     */
    public static function getByEnrollment(int $enrollmentId): array
    {
        $sql = "SELECT lp.*, l.title as lesson_title, l.type as lesson_type,
                       m.title as module_title, m.order_index as module_order
                FROM lesson_progress lp
                INNER JOIN lessons l ON lp.lesson_id = l.id
                INNER JOIN modules m ON l.module_id = m.id
                WHERE lp.enrollment_id = :enrollment_id
                ORDER BY m.order_index, l.order_index";

        return Database::fetchAll($sql, ['enrollment_id' => $enrollmentId]);
    }

    /**
     * Mark lesson as started
     */
    public static function markAsStarted(int $userId, int $lessonId, int $enrollmentId): bool
    {
        $data = [
            'user_id' => $userId,
            'lesson_id' => $lessonId,
            'enrollment_id' => $enrollmentId,
            'status' => 'in_progress',
            'completion_percentage' => 0.00
        ];

        $id = self::createOrUpdate($data);
        return $id !== null;
    }

    /**
     * Mark lesson as completed
     */
    public static function markAsCompleted(int $userId, int $lessonId, int $enrollmentId): bool
    {
        $data = [
            'user_id' => $userId,
            'lesson_id' => $lessonId,
            'enrollment_id' => $enrollmentId,
            'status' => 'completed',
            'completion_percentage' => 100.00,
            'completed_at' => date('Y-m-d H:i:s')
        ];

        $id = self::createOrUpdate($data);

        // Update enrollment progress
        if ($id) {
            self::updateEnrollmentProgress($enrollmentId);
        }

        return $id !== null;
    }

    /**
     * Update lesson progress percentage
     */
    public static function updateProgress(
        int $userId, 
        int $lessonId, 
        int $enrollmentId, 
        float $percentage,
        ?string $lastPosition = null
    ): bool {
        $percentage = max(0, min(100, $percentage));

        $data = [
            'user_id' => $userId,
            'lesson_id' => $lessonId,
            'enrollment_id' => $enrollmentId,
            'completion_percentage' => $percentage,
            'status' => $percentage >= 100 ? 'completed' : 'in_progress'
        ];

        if ($lastPosition) {
            $data['last_position'] = $lastPosition;
        }

        if ($percentage >= 100) {
            $data['completed_at'] = date('Y-m-d H:i:s');
        }

        $id = self::createOrUpdate($data);

        // Update enrollment progress
        if ($id) {
            self::updateEnrollmentProgress($enrollmentId);
        }

        return $id !== null;
    }

    /**
     * Track time spent on lesson
     */
    public static function trackTimeSpent(int $userId, int $lessonId, int $seconds): bool
    {
        $existing = self::findByUserAndLesson($userId, $lessonId);

        if (!$existing) {
            return false;
        }

        $newTimeSpent = ($existing['time_spent_seconds'] ?? 0) + $seconds;

        $result = Database::update(
            'lesson_progress',
            [
                'time_spent_seconds' => $newTimeSpent,
                'last_accessed_at' => date('Y-m-d H:i:s')
            ],
            'id = :id',
            ['id' => $existing['id']]
        );

        return $result > 0;
    }

    /**
     * Increment interactions count
     */
    public static function incrementInteractions(int $userId, int $lessonId): bool
    {
        $existing = self::findByUserAndLesson($userId, $lessonId);

        if (!$existing) {
            return false;
        }

        $result = Database::update(
            'lesson_progress',
            ['interactions_count' => ($existing['interactions_count'] ?? 0) + 1],
            'id = :id',
            ['id' => $existing['id']]
        );

        return $result > 0;
    }

    /**
     * Toggle bookmark
     */
    public static function toggleBookmark(int $userId, int $lessonId): bool
    {
        $existing = self::findByUserAndLesson($userId, $lessonId);

        if (!$existing) {
            return false;
        }

        $result = Database::update(
            'lesson_progress',
            ['bookmarked' => !($existing['bookmarked'] ?? false)],
            'id = :id',
            ['id' => $existing['id']]
        );

        return $result > 0;
    }

    /**
     * Save or update notes
     */
    public static function saveNotes(int $userId, int $lessonId, string $notes): bool
    {
        $existing = self::findByUserAndLesson($userId, $lessonId);

        if (!$existing) {
            return false;
        }

        $result = Database::update(
            'lesson_progress',
            ['notes' => $notes],
            'id = :id',
            ['id' => $existing['id']]
        );

        return $result > 0;
    }

    /**
     * Get user's bookmarked lessons
     */
    public static function getBookmarkedLessons(int $userId): array
    {
        $sql = "SELECT lp.*, l.title as lesson_title, l.type as lesson_type, l.id as lesson_id,
                       m.title as module_title, c.title as course_title, c.slug as course_slug, c.id as course_id
                FROM lesson_progress lp
                INNER JOIN lessons l ON lp.lesson_id = l.id
                INNER JOIN modules m ON l.module_id = m.id
                INNER JOIN courses c ON m.course_id = c.id
                WHERE lp.user_id = :user_id AND lp.bookmarked = 1
                ORDER BY lp.updated_at DESC";

        return Database::fetchAll($sql, ['user_id' => $userId]);
    }

    /**
     * Get user's bookmarked lessons filtered by course
     */
    public static function getBookmarkedLessonsByCourse(int $userId, int $courseId): array
    {
        $sql = "SELECT lp.*, l.title as lesson_title, l.type as lesson_type, l.id as lesson_id,
                       m.title as module_title, c.title as course_title, c.slug as course_slug, c.id as course_id
                FROM lesson_progress lp
                INNER JOIN lessons l ON lp.lesson_id = l.id
                INNER JOIN modules m ON l.module_id = m.id
                INNER JOIN courses c ON m.course_id = c.id
                WHERE lp.user_id = :user_id AND lp.bookmarked = 1 AND c.id = :course_id
                ORDER BY m.order_index, l.order_index";

        return Database::fetchAll($sql, [
            'user_id' => $userId,
            'course_id' => $courseId
        ]);
    }

    /**
     * Get lesson to resume (last accessed in-progress lesson)
     */
    public static function getResumeLesson(int $enrollmentId): ?array
    {
        $sql = "SELECT lp.*, l.title as lesson_title, l.type as lesson_type,
                       m.id as module_id, m.title as module_title
                FROM lesson_progress lp
                INNER JOIN lessons l ON lp.lesson_id = l.id
                INNER JOIN modules m ON l.module_id = m.id
                WHERE lp.enrollment_id = :enrollment_id 
                  AND lp.status = 'in_progress'
                ORDER BY lp.last_accessed_at DESC
                LIMIT 1";

        return Database::fetch($sql, ['enrollment_id' => $enrollmentId]);
    }

    /**
     * Get next lesson to study
     */
    public static function getNextLesson(int $enrollmentId): ?array
    {
        $sql = "SELECT l.*, m.title as module_title, m.order_index as module_order
                FROM lessons l
                INNER JOIN modules m ON l.module_id = m.id
                INNER JOIN enrollments e ON m.course_id = e.course_id
                LEFT JOIN lesson_progress lp ON l.id = lp.lesson_id AND lp.user_id = e.user_id
                WHERE e.id = :enrollment_id 
                  AND (lp.status IS NULL OR lp.status != 'completed')
                ORDER BY m.order_index, l.order_index
                LIMIT 1";

        return Database::fetch($sql, ['enrollment_id' => $enrollmentId]);
    }

    /**
     * Update enrollment progress based on lesson completion
     */
    protected static function updateEnrollmentProgress(int $enrollmentId): bool
    {
        $sql = "SELECT 
                    COUNT(DISTINCT l.id) as total_lessons,
                    COUNT(DISTINCT CASE WHEN lp.status = 'completed' THEN l.id END) as completed_lessons
                FROM enrollments e
                INNER JOIN courses c ON e.course_id = c.id
                INNER JOIN modules m ON c.id = m.course_id
                INNER JOIN lessons l ON m.id = l.module_id
                LEFT JOIN lesson_progress lp ON l.id = lp.lesson_id AND lp.user_id = e.user_id
                WHERE e.id = :enrollment_id";

        $stats = Database::fetch($sql, ['enrollment_id' => $enrollmentId]);

        if (!$stats || $stats['total_lessons'] == 0) {
            return false;
        }

        $progress = ($stats['completed_lessons'] / $stats['total_lessons']) * 100;

        return Enrollment::updateProgress($enrollmentId, $progress);
    }

    /**
     * Get progress statistics for a user
     */
    public static function getUserStats(int $userId): array
    {
        $sql = "SELECT 
                    COUNT(DISTINCT lp.lesson_id) as total_lessons_accessed,
                    COUNT(DISTINCT CASE WHEN lp.status = 'completed' THEN lp.lesson_id END) as lessons_completed,
                    SUM(lp.time_spent_seconds) as total_time_spent,
                    AVG(lp.completion_percentage) as average_completion,
                    COUNT(DISTINCT CASE WHEN lp.bookmarked = 1 THEN lp.lesson_id END) as bookmarked_count
                FROM lesson_progress lp
                WHERE lp.user_id = :user_id";

        $stats = Database::fetch($sql, ['user_id' => $userId]);

        return $stats ?? [
            'total_lessons_accessed' => 0,
            'lessons_completed' => 0,
            'total_time_spent' => 0,
            'average_completion' => 0,
            'bookmarked_count' => 0
        ];
    }

    /**
     * Get module progress for an enrollment
     */
    public static function getModuleProgress(int $enrollmentId): array
    {
        $sql = "SELECT * FROM module_progress_view 
                WHERE enrollment_id = :enrollment_id
                ORDER BY order_index";

        return Database::fetchAll($sql, ['enrollment_id' => $enrollmentId]);
    }

    /**
     * Get recent activity for a user
     */
    public static function getRecentActivity(int $userId, int $limit = 10): array
    {
        $sql = "SELECT lp.*, l.title as lesson_title, l.type as lesson_type,
                       c.title as course_title, c.slug as course_slug
                FROM lesson_progress lp
                INNER JOIN lessons l ON lp.lesson_id = l.id
                INNER JOIN modules m ON l.module_id = m.id
                INNER JOIN courses c ON m.course_id = c.id
                WHERE lp.user_id = :user_id
                ORDER BY lp.last_accessed_at DESC
                LIMIT :limit";

        return Database::fetchAll($sql, [
            'user_id' => $userId,
            'limit' => $limit
        ]);
    }

    /**
     * Generate UUID v4
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
}
