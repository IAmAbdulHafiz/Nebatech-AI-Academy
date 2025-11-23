<?php

namespace Nebatech\Controllers\System;

use Nebatech\Core\Controller;
use Nebatech\Services\NotificationService;
use Nebatech\Models\Community\Notification;
use Nebatech\Middleware\AuthMiddleware;

class NotificationController extends Controller
{
    private NotificationService $notificationService;

    public function __construct()
    {
        $this->notificationService = new NotificationService();
    }

    /**
     * Get all notifications for current user
     */
    public function index(): void
    {
        $user = $this->getCurrentUser();
        
        $page = (int)($_GET['page'] ?? 1);
        $limit = 20;
        $offset = ($page - 1) * $limit;

        $notifications = $this->notificationService->getUserNotifications($user['id'], [
            'limit' => $limit,
            'offset' => $offset
        ]);

        $unreadCount = $this->notificationService->getUnreadCount($user['id']);

        echo $this->view('notifications/index', [
            'user' => $user,
            'notifications' => $notifications,
            'unreadCount' => $unreadCount,
            'currentPage' => $page
        ]);
    }

    /**
     * Get notifications as JSON (for AJAX requests)
     */
    public function getNotifications(): void
    {
        header('Content-Type: application/json');
        
        $user = $this->getCurrentUser();
        if (!$user) {
            echo json_encode(['error' => 'Unauthorized'], JSON_UNESCAPED_SLASHES);
            http_response_code(401);
            return;
        }

        $limit = (int)($_GET['limit'] ?? 10);
        $unreadOnly = isset($_GET['unread_only']) && $_GET['unread_only'] === 'true';

        $notifications = $this->notificationService->getUserNotifications($user['id'], [
            'limit' => $limit,
            'unread_only' => $unreadOnly
        ]);

        $unreadCount = $this->notificationService->getUnreadCount($user['id']);

        // Format notifications for frontend
        $formattedNotifications = array_map(function($notification) {
            return [
                'id' => $notification['id'],
                'uuid' => $notification['uuid'],
                'type' => $notification['type'],
                'title' => $notification['title'],
                'message' => $notification['message'],
                'action_url' => $notification['action_url'],
                'is_read' => (bool)$notification['is_read'],
                'created_at' => $notification['created_at'],
                'time_ago' => $this->timeAgo($notification['created_at']),
                'icon' => Notification::getIcon($notification['type']),
                'color' => Notification::getColor($notification['type'])
            ];
        }, $notifications);

        echo json_encode([
            'success' => true,
            'notifications' => $formattedNotifications,
            'unread_count' => $unreadCount
        ], JSON_UNESCAPED_SLASHES);
    }

    /**
     * Get unread count
     */
    public function getUnreadCount(): void
    {
        header('Content-Type: application/json');
        
        $user = $this->getCurrentUser();
        if (!$user) {
            echo json_encode(['error' => 'Unauthorized'], JSON_UNESCAPED_SLASHES);
            http_response_code(401);
            return;
        }

        $count = $this->notificationService->getUnreadCount($user['id']);

        echo json_encode([
            'success' => true,
            'count' => $count
        ], JSON_UNESCAPED_SLASHES);
    }

    /**
     * Mark notification as read
     */
    public function markAsRead(): void
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['error' => 'Invalid request method'], JSON_UNESCAPED_SLASHES);
            http_response_code(405);
            return;
        }

        $user = $this->getCurrentUser();
        if (!$user) {
            echo json_encode(['error' => 'Unauthorized'], JSON_UNESCAPED_SLASHES);
            http_response_code(401);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);
        $notificationId = (int)($data['notification_id'] ?? 0);

        if (!$notificationId) {
            echo json_encode(['error' => 'Notification ID required'], JSON_UNESCAPED_SLASHES);
            http_response_code(400);
            return;
        }

        // Verify notification belongs to user
        $notification = Notification::findById($notificationId);
        if (!$notification || $notification['user_id'] != $user['id']) {
            echo json_encode(['error' => 'Notification not found'], JSON_UNESCAPED_SLASHES);
            http_response_code(404);
            return;
        }

        $success = $this->notificationService->markAsRead($notificationId);

        if ($success) {
            $unreadCount = $this->notificationService->getUnreadCount($user['id']);
            echo json_encode([
                'success' => true,
                'message' => 'Notification marked as read',
                'unread_count' => $unreadCount
            ], JSON_UNESCAPED_SLASHES);
        } else {
            echo json_encode(['error' => 'Failed to mark notification as read'], JSON_UNESCAPED_SLASHES);
            http_response_code(500);
        }
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead(): void
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['error' => 'Invalid request method'], JSON_UNESCAPED_SLASHES);
            http_response_code(405);
            return;
        }

        $user = $this->getCurrentUser();
        if (!$user) {
            echo json_encode(['error' => 'Unauthorized'], JSON_UNESCAPED_SLASHES);
            http_response_code(401);
            return;
        }

        $success = $this->notificationService->markAllAsRead($user['id']);

        if ($success) {
            echo json_encode([
                'success' => true,
                'message' => 'All notifications marked as read'
            ], JSON_UNESCAPED_SLASHES);
        } else {
            echo json_encode(['error' => 'Failed to mark notifications as read'], JSON_UNESCAPED_SLASHES);
            http_response_code(500);
        }
    }

    /**
     * Delete notification
     */
    public function delete(): void
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['error' => 'Invalid request method'], JSON_UNESCAPED_SLASHES);
            http_response_code(405);
            return;
        }

        $user = $this->getCurrentUser();
        if (!$user) {
            echo json_encode(['error' => 'Unauthorized'], JSON_UNESCAPED_SLASHES);
            http_response_code(401);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);
        $notificationId = (int)($data['notification_id'] ?? 0);

        if (!$notificationId) {
            echo json_encode(['error' => 'Notification ID required'], JSON_UNESCAPED_SLASHES);
            http_response_code(400);
            return;
        }

        // Verify notification belongs to user
        $notification = Notification::findById($notificationId);
        if (!$notification || $notification['user_id'] != $user['id']) {
            echo json_encode(['error' => 'Notification not found'], JSON_UNESCAPED_SLASHES);
            http_response_code(404);
            return;
        }

        $success = $this->notificationService->deleteNotification($notificationId);

        if ($success) {
            $unreadCount = $this->notificationService->getUnreadCount($user['id']);
            echo json_encode([
                'success' => true,
                'message' => 'Notification deleted',
                'unread_count' => $unreadCount
            ], JSON_UNESCAPED_SLASHES);
        } else {
            echo json_encode(['error' => 'Failed to delete notification'], JSON_UNESCAPED_SLASHES);
            http_response_code(500);
        }
    }

    /**
     * Delete all notifications for current user
     */
    public function deleteAll(): void
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['error' => 'Invalid request method'], JSON_UNESCAPED_SLASHES);
            http_response_code(405);
            return;
        }

        $user = $this->getCurrentUser();
        if (!$user) {
            echo json_encode(['error' => 'Unauthorized'], JSON_UNESCAPED_SLASHES);
            http_response_code(401);
            return;
        }

        $success = $this->notificationService->deleteAllNotifications($user['id']);

        if ($success) {
            echo json_encode([
                'success' => true,
                'message' => 'All notifications deleted'
            ], JSON_UNESCAPED_SLASHES);
        } else {
            echo json_encode(['error' => 'Failed to delete notifications'], JSON_UNESCAPED_SLASHES);
            http_response_code(500);
        }
    }

    /**
     * Helper function to format time ago
     */
    private function timeAgo(string $datetime): string
    {
        $timestamp = strtotime($datetime);
        $diff = time() - $timestamp;

        if ($diff < 60) {
            return 'Just now';
        } elseif ($diff < 3600) {
            $mins = floor($diff / 60);
            return $mins . ' minute' . ($mins > 1 ? 's' : '') . ' ago';
        } elseif ($diff < 86400) {
            $hours = floor($diff / 3600);
            return $hours . ' hour' . ($hours > 1 ? 's' : '') . ' ago';
        } elseif ($diff < 604800) {
            $days = floor($diff / 86400);
            return $days . ' day' . ($days > 1 ? 's' : '') . ' ago';
        } else {
            return date('M j, Y', $timestamp);
        }
    }
}
