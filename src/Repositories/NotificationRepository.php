<?php

namespace Nebatech\Repositories;

use Nebatech\Core\Database;

class NotificationRepository
{
    /**
     * Find notification by ID
     */
    public function find(int $id): ?array
    {
        return Database::fetch(
            'SELECT * FROM notifications WHERE id = :id',
            ['id' => $id]
        );
    }

    /**
     * Get all notifications for a user
     */
    public function getByUser(int $userId, array $filters = []): array
    {
        $sql = 'SELECT * FROM notifications WHERE user_id = :user_id';
        $params = ['user_id' => $userId];

        if (isset($filters['read']) && $filters['read'] !== null) {
            if ($filters['read']) {
                $sql .= ' AND is_read = 1';
            } else {
                $sql .= ' AND is_read = 0';
            }
        }

        if (!empty($filters['type'])) {
            $sql .= ' AND type = :type';
            $params['type'] = $filters['type'];
        }

        $sql .= ' ORDER BY created_at DESC';

        if (!empty($filters['limit'])) {
            $sql .= ' LIMIT ' . (int)$filters['limit'];
        }

        return Database::fetchAll($sql, $params);
    }

    /**
     * Get unread notifications count
     */
    public function getUnreadCount(int $userId): int
    {
        $result = Database::fetch(
            'SELECT COUNT(*) as count FROM notifications 
             WHERE user_id = :user_id AND is_read = 0',
            ['user_id' => $userId]
        );

        return (int)($result['count'] ?? 0);
    }

    /**
     * Create new notification
     */
    public function create(array $data): int
    {
        $data['created_at'] = date('Y-m-d H:i:s');

        return Database::insert('notifications', $data);
    }

    /**
     * Create notification for multiple users
     */
    public function createForUsers(array $userIds, array $data): bool
    {
        try {
            Database::beginTransaction();

            foreach ($userIds as $userId) {
                $notificationData = array_merge($data, ['user_id' => $userId]);
                $this->create($notificationData);
            }

            Database::commit();
            return true;
        } catch (\Exception $e) {
            Database::rollback();
            error_log('Failed to create notifications: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Mark notification as read
     */
    public function markAsRead(int $id): bool
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
    public function markAllAsRead(int $userId): bool
    {
        return Database::update(
            'notifications',
            [
                'is_read' => 1,
                'read_at' => date('Y-m-d H:i:s')
            ],
            'user_id = :user_id AND is_read = 0',
            ['user_id' => $userId]
        ) > 0;
    }

    /**
     * Delete notification
     */
    public function delete(int $id): bool
    {
        return Database::delete('notifications', 'id = :id', ['id' => $id]) > 0;
    }

    /**
     * Delete all notifications for a user
     */
    public function deleteAllForUser(int $userId): bool
    {
        return Database::delete('notifications', 'user_id = :user_id', ['user_id' => $userId]) > 0;
    }

    /**
     * Delete old read notifications
     */
    public function deleteOldRead(int $daysOld = 30): int
    {
        $date = date('Y-m-d H:i:s', strtotime("-{$daysOld} days"));
        
        return Database::delete(
            'notifications',
            'is_read = 1 AND read_at < :date',
            ['date' => $date]
        );
    }
}
