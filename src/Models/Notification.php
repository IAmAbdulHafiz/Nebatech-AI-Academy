<?php

namespace Nebatech\Models;

use Nebatech\Core\Model;
use Nebatech\Core\Database;

class Notification extends Model
{
    protected string $table = 'notifications';
    protected string $primaryKey = 'id';

    /**
     * Get icon for notification type
     */
    public static function getIcon(string $type): string
    {
        return match($type) {
            'grade', 'graded' => 'fa-star',
            'enrollment', 'enrolled' => 'fa-user-plus',
            'certificate' => 'fa-certificate',
            'announcement' => 'fa-bullhorn',
            'reminder' => 'fa-clock',
            'message' => 'fa-envelope',
            'comment' => 'fa-comment',
            'assignment' => 'fa-tasks',
            'course' => 'fa-book',
            'cohort' => 'fa-users',
            'feedback' => 'fa-comment-dots',
            'achievement', 'badge' => 'fa-trophy',
            'warning' => 'fa-exclamation-triangle',
            'info' => 'fa-info-circle',
            'success' => 'fa-check-circle',
            'error' => 'fa-times-circle',
            default => 'fa-bell'
        };
    }

    /**
     * Get color for notification type
     */
    public static function getColor(string $type): string
    {
        return match($type) {
            'grade', 'graded' => 'yellow',
            'enrollment', 'enrolled' => 'green',
            'certificate' => 'purple',
            'announcement' => 'blue',
            'reminder' => 'orange',
            'message' => 'indigo',
            'comment' => 'cyan',
            'assignment' => 'teal',
            'course' => 'blue',
            'cohort' => 'violet',
            'feedback' => 'pink',
            'achievement', 'badge' => 'amber',
            'warning' => 'orange',
            'info' => 'blue',
            'success' => 'green',
            'error' => 'red',
            default => 'gray'
        };
    }

    /**
     * Get notifications for a user
     */
    public static function getForUser(int $userId, int $limit = 50): array
    {
        $sql = "SELECT * FROM notifications 
                WHERE user_id = :user_id 
                ORDER BY created_at DESC 
                LIMIT :limit";
        
        $db = Database::connect();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC) ?: [];
    }

    /**
     * Get unread count for a user
     */
    public static function getUnreadCount(int $userId): int
    {
        $sql = "SELECT COUNT(*) FROM notifications 
                WHERE user_id = :user_id AND is_read = 0";
        
        return (int) Database::fetchColumn($sql, ['user_id' => $userId]);
    }

    /**
     * Mark notification as read
     */
    public static function markAsRead(int $notificationId, int $userId): bool
    {
        $sql = "UPDATE notifications 
                SET is_read = 1, read_at = NOW() 
                WHERE id = :id AND user_id = :user_id";
        
        return Database::execute($sql, [
            'id' => $notificationId,
            'user_id' => $userId
        ]) > 0;
    }

    /**
     * Mark all notifications as read for a user
     */
    public static function markAllAsRead(int $userId): int
    {
        $sql = "UPDATE notifications 
                SET is_read = 1, read_at = NOW() 
                WHERE user_id = :user_id AND is_read = 0";
        
        return Database::execute($sql, ['user_id' => $userId]);
    }

    /**
     * Create a notification
     */
    public static function createNotification(int $userId, string $type, string $title, ?string $message = null, ?string $link = null): ?int
    {
        return Database::insert('notifications', [
            'user_id' => $userId,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'link' => $link,
            'is_read' => 0
        ]);
    }

    /**
     * Delete old notifications (cleanup)
     */
    public static function deleteOld(int $daysOld = 90): int
    {
        $sql = "DELETE FROM notifications 
                WHERE created_at < DATE_SUB(NOW(), INTERVAL :days DAY)";
        
        return Database::execute($sql, ['days' => $daysOld]);
    }
}
