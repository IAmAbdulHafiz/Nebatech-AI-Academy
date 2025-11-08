<?php

namespace Nebatech\Models;

use Nebatech\Core\Model;
use Nebatech\Core\Database;

class Enrollment extends Model
{
    protected string $table = 'enrollments';
    protected string $primaryKey = 'id';

    /**
     * Create a new enrollment
     */
    public static function createEnrollment(array $data): ?int
    {
        // Set default status if not provided
        if (!isset($data['status'])) {
            $data['status'] = 'active';
        }

        // Set default progress if not provided
        if (!isset($data['progress'])) {
            $data['progress'] = 0.00;
        }

        try {
            return Database::insert('enrollments', $data);
        } catch (\Exception $e) {
            error_log("Enrollment creation failed: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Get user's enrollments
     */
    public static function getUserEnrollments(int $userId, ?string $status = null): array
    {
        $sql = "SELECT e.*, 
                       c.title as course_title,
                       c.slug as course_slug,
                       c.thumbnail as course_thumbnail,
                       c.level as course_level,
                       c.duration_hours,
                       u.first_name as facilitator_first_name,
                       u.last_name as facilitator_last_name
                FROM " . 'enrollments' . " e
                INNER JOIN courses c ON e.course_id = c.id
                LEFT JOIN users u ON c.facilitator_id = u.id
                WHERE e.user_id = :user_id";
        
        $params = ['user_id' => $userId];

        if ($status) {
            $sql .= " AND e.status = :status";
            $params['status'] = $status;
        }

        $sql .= " ORDER BY e.enrolled_at DESC";

        return Database::fetchAll($sql, $params);
    }

    /**
     * Get course enrollments
     */
    public static function getCourseEnrollments(int $courseId, ?string $status = null): array
    {
        $sql = "SELECT e.*, 
                       u.first_name,
                       u.last_name,
                       u.email,
                       u.avatar
                FROM " . 'enrollments' . " e
                INNER JOIN users u ON e.user_id = u.id
                WHERE e.course_id = :course_id";
        
        $params = ['course_id' => $courseId];

        if ($status) {
            $sql .= " AND e.status = :status";
            $params['status'] = $status;
        }

        $sql .= " ORDER BY e.enrolled_at DESC";

        return Database::fetchAll($sql, $params);
    }

    /**
     * Check if user is enrolled in course
     */
    public static function isEnrolled(int $userId, int $courseId): bool
    {
        $sql = "SELECT COUNT(*) as count FROM " . 'enrollments' . " 
                WHERE user_id = :user_id AND course_id = :course_id";
        
        $result = Database::fetch($sql, [
            'user_id' => $userId,
            'course_id' => $courseId
        ]);

        return $result && $result['count'] > 0;
    }

    /**
     * Get enrollment by user and course
     */
    public static function getByUserAndCourse(int $userId, int $courseId): ?array
    {
        $sql = "SELECT e.*, 
                       c.title as course_title,
                       c.slug as course_slug
                FROM " . 'enrollments' . " e
                INNER JOIN courses c ON e.course_id = c.id
                WHERE e.user_id = :user_id AND e.course_id = :course_id
                LIMIT 1";
        
        return Database::fetch($sql, [
            'user_id' => $userId,
            'course_id' => $courseId
        ]);
    }

    /**
     * Update enrollment progress
     */
    public static function updateProgress(int $enrollmentId, float $progress): bool
    {
        $progress = max(0, min(100, $progress)); // Clamp between 0 and 100

        $data = ['progress' => $progress];

        // If progress is 100%, mark as completed
        if ($progress >= 100) {
            $data['status'] = 'completed';
            $data['completed_at'] = date('Y-m-d H:i:s');
        }

        $result = Database::update(
            'enrollments',
            $data,
            'id = :id',
            ['id' => $enrollmentId]
        );

        return $result > 0;
    }

    /**
     * Update enrollment status
     */
    public static function updateStatus(int $enrollmentId, string $status): bool
    {
        $validStatuses = ['active', 'completed', 'dropped'];
        
        if (!in_array($status, $validStatuses)) {
            return false;
        }

        $data = ['status' => $status];

        if ($status === 'completed' && !self::isCompleted($enrollmentId)) {
            $data['completed_at'] = date('Y-m-d H:i:s');
            $data['progress'] = 100.00;
        }

        $result = Database::update(
            'enrollments',
            $data,
            'id = :id',
            ['id' => $enrollmentId]
        );

        return $result > 0;
    }

    /**
     * Check if enrollment is completed
     */
    protected static function isCompleted(int $enrollmentId): bool
    {
        $sql = "SELECT completed_at FROM " . 'enrollments' . " WHERE id = :id LIMIT 1";
        $result = Database::fetch($sql, ['id' => $enrollmentId]);
        
        return $result && $result['completed_at'] !== null;
    }

    /**
     * Drop enrollment
     */
    public static function drop(int $enrollmentId): bool
    {
        return self::updateStatus($enrollmentId, 'dropped');
    }

    /**
     * Get enrollment statistics
     */
    public static function getStats(): array
    {
        $sql = "SELECT 
                    COUNT(*) as total,
                    SUM(CASE WHEN status = 'active' THEN 1 ELSE 0 END) as active,
                    SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) as completed,
                    SUM(CASE WHEN status = 'dropped' THEN 1 ELSE 0 END) as dropped,
                    AVG(progress) as average_progress
                FROM " . 'enrollments';
        
        return Database::fetch($sql) ?? [
            'total' => 0,
            'active' => 0,
            'completed' => 0,
            'dropped' => 0,
            'average_progress' => 0
        ];
    }

    /**
     * Get enrollment count by course
     */
    public static function getCountByCourse(int $courseId): int
    {
        $sql = "SELECT COUNT(*) as count FROM " . 'enrollments' . " 
                WHERE course_id = :course_id";
        
        $result = Database::fetch($sql, ['course_id' => $courseId]);
        return $result ? (int)$result['count'] : 0;
    }

    /**
     * Get active enrollment count by user
     */
    public static function getActiveCountByUser(int $userId): int
    {
        $sql = "SELECT COUNT(*) as count FROM " . 'enrollments' . " 
                WHERE user_id = :user_id AND status = 'active'";
        
        $result = Database::fetch($sql, ['user_id' => $userId]);
        return $result ? (int)$result['count'] : 0;
    }

    /**
     * Get completed enrollment count by user
     */
    public static function getCompletedCountByUser(int $userId): int
    {
        $sql = "SELECT COUNT(*) as count FROM " . 'enrollments' . " 
                WHERE user_id = :user_id AND status = 'completed'";
        
        $result = Database::fetch($sql, ['user_id' => $userId]);
        return $result ? (int)$result['count'] : 0;
    }

    /**
     * Delete enrollment
     */
    public static function deleteEnrollment(int $enrollmentId): bool
    {
        $result = Database::delete('enrollments', 'id = :id', ['id' => $enrollmentId]);
        return $result > 0;
    }
}
