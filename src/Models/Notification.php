<?php

namespace Nebatech\Models;

use Nebatech\Core\Database;

class Notification
{
    /**
     * Create a new notification
     */
    public static function create(array $data): int
    {
        $data['uuid'] = self::generateUuid();
        return Database::insert('notifications', $data);
    }

    /**
     * Find notification by ID
     */
    public static function findById(int $id): ?array
    {
        $sql = "SELECT * FROM notifications WHERE id = :id LIMIT 1";
        return Database::fetch($sql, ['id' => $id]);
    }

    /**
     * Find notification by UUID
     */
    public static function findByUuid(string $uuid): ?array
    {
        $sql = "SELECT * FROM notifications WHERE uuid = :uuid LIMIT 1";
        return Database::fetch($sql, ['uuid' => $uuid]);
    }

    /**
     * Get all notifications for a user
     */
    public static function getByUser(int $userId, array $options = []): array
    {
        $limit = $options['limit'] ?? 50;
        $offset = $options['offset'] ?? 0;
        $unreadOnly = $options['unread_only'] ?? false;

        $conditions = ['user_id = :user_id'];
        $params = ['user_id' => $userId];

        if ($unreadOnly) {
            $conditions[] = 'is_read = 0';
        }

        $where = implode(' AND ', $conditions);
        
        $sql = "SELECT * FROM notifications 
                WHERE {$where} 
                ORDER BY created_at DESC 
                LIMIT {$limit} OFFSET {$offset}";

        return Database::fetchAll($sql, $params);
    }

    /**
     * Get unread count for a user
     */
    public static function getUnreadCount(int $userId): int
    {
        $sql = "SELECT COUNT(*) as count FROM notifications WHERE user_id = :user_id AND is_read = 0";
        $result = Database::fetch($sql, ['user_id' => $userId]);

        return (int)($result['count'] ?? 0);
    }

    /**
     * Mark notification as read
     */
    public static function markAsRead(int $id): bool
    {
        return Database::update(
            'notifications',
            [
                'is_read' => 1,
                'read_at' => date('Y-m-d H:i:s')
            ],
            'id = :id',
            ['id' => $id]
        ) > 0;
    }

    /**
     * Mark all notifications as read for a user
     */
    public static function markAllAsRead(int $userId): bool
    {
        return Database::update(
            'notifications',
            [
                'is_read' => 1,
                'read_at' => date('Y-m-d H:i:s')
            ],
            'user_id = :user_id AND is_read = 0',
            ['user_id' => $userId]
        ) >= 0;
    }

    /**
     * Delete notification
     */
    public static function deleteNotification(int $id): bool
    {
        return Database::delete('notifications', 'id = :id', ['id' => $id]) > 0;
    }

    /**
     * Delete all notifications for a user
     */
    public static function deleteAllForUser(int $userId): bool
    {
        return Database::delete('notifications', 'user_id = :user_id', ['user_id' => $userId]) >= 0;
    }

    /**
     * Delete old read notifications (cleanup)
     */
    public static function deleteOldReadNotifications(int $daysOld = 30): int
    {
        $date = date('Y-m-d H:i:s', strtotime("-{$daysOld} days"));
        return Database::delete(
            'notifications',
            'is_read = 1 AND read_at < :date',
            ['date' => $date]
        );
    }

    /**
     * Get recent notifications for a user
     */
    public static function getRecent(int $userId, int $limit = 10): array
    {
        return self::getByUser($userId, ['limit' => $limit]);
    }

    /**
     * Generate UUID
     */
    private static function generateUuid(): string
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
     * Get notification types
     */
    public static function getTypes(): array
    {
        return [
            'application_received' => 'Application Received',
            'application_approved' => 'Application Approved',
            'application_rejected' => 'Application Rejected',
            'info_requested' => 'Information Requested',
            'enrollment_created' => 'Enrollment Created',
            'cohort_assigned' => 'Cohort Assigned',
            'assignment_graded' => 'Assignment Graded',
            'course_published' => 'Course Published',
            'certificate_issued' => 'Certificate Issued',
            'submission_received' => 'Submission Received',
            'lesson_completed' => 'Lesson Completed',
            'course_completed' => 'Course Completed',
            'system' => 'System Notification',
            'announcement' => 'Announcement'
        ];
    }

    /**
     * Get notification icon based on type
     */
    public static function getIcon(string $type): string
    {
        $icons = [
            'application_received' => 'fa-file-alt',
            'application_approved' => 'fa-check-circle',
            'application_rejected' => 'fa-times-circle',
            'info_requested' => 'fa-question-circle',
            'enrollment_created' => 'fa-user-plus',
            'cohort_assigned' => 'fa-users',
            'assignment_graded' => 'fa-graduation-cap',
            'course_published' => 'fa-book',
            'certificate_issued' => 'fa-certificate',
            'submission_received' => 'fa-paper-plane',
            'lesson_completed' => 'fa-check',
            'course_completed' => 'fa-trophy',
            'system' => 'fa-cog',
            'announcement' => 'fa-bullhorn'
        ];

        return $icons[$type] ?? 'fa-bell';
    }

    /**
     * Get notification color based on type
     */
    public static function getColor(string $type): string
    {
        $colors = [
            'application_received' => 'blue',
            'application_approved' => 'green',
            'application_rejected' => 'red',
            'info_requested' => 'yellow',
            'enrollment_created' => 'green',
            'cohort_assigned' => 'purple',
            'assignment_graded' => 'blue',
            'course_published' => 'indigo',
            'certificate_issued' => 'yellow',
            'submission_received' => 'blue',
            'lesson_completed' => 'green',
            'course_completed' => 'green',
            'system' => 'gray',
            'announcement' => 'orange'
        ];

        return $colors[$type] ?? 'gray';
    }
}
