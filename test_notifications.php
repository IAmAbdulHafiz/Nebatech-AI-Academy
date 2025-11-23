<?php
/**
 * Notification System Test Script
 * Run this script to test the notification system
 * 
 * Usage: php test_notifications.php
 */

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/src/bootstrap.php';

use Nebatech\Services\NotificationService;
use Nebatech\Models\User;

echo "=== Notification System Test ===\n\n";

// Initialize service
$notificationService = new NotificationService();

// Get a test user (first user in database)
$users = User::getAll(['limit' => 1]);
if (empty($users)) {
    echo "❌ Error: No users found in database. Please create a user first.\n";
    exit(1);
}

$testUser = $users[0];
echo "✓ Test user found: {$testUser['first_name']} {$testUser['last_name']} (ID: {$testUser['id']})\n\n";

// Test 1: Send system notification
echo "Test 1: Sending system notification...\n";
$result1 = $notificationService->notifySystem(
    $testUser['id'],
    'Test Notification',
    'This is a test notification to verify the system is working correctly.',
    '/dashboard'
);
echo $result1 ? "✓ System notification sent\n" : "❌ Failed to send system notification\n";
echo "\n";

// Test 2: Send announcement
echo "Test 2: Sending announcement...\n";
$result2 = $notificationService->notifyAnnouncement(
    [$testUser['id']],
    'Test Announcement',
    'This is a test announcement for all users.',
    '/notifications'
);
echo $result2 > 0 ? "✓ Announcement sent to {$result2} user(s)\n" : "❌ Failed to send announcement\n";
echo "\n";

// Test 3: Get unread count
echo "Test 3: Getting unread count...\n";
$unreadCount = $notificationService->getUnreadCount($testUser['id']);
echo "✓ Unread notifications: {$unreadCount}\n\n";

// Test 4: Get user notifications
echo "Test 4: Getting user notifications...\n";
$notifications = $notificationService->getUserNotifications($testUser['id'], ['limit' => 5]);
echo "✓ Found " . count($notifications) . " notification(s)\n";
if (!empty($notifications)) {
    echo "\nRecent notifications:\n";
    foreach ($notifications as $notification) {
        $status = $notification['is_read'] ? '✓ Read' : '○ Unread';
        echo "  {$status} - {$notification['title']}\n";
        echo "    {$notification['message']}\n";
        echo "    Created: {$notification['created_at']}\n\n";
    }
}

// Test 5: Mark as read
if (!empty($notifications) && !$notifications[0]['is_read']) {
    echo "Test 5: Marking notification as read...\n";
    $result5 = $notificationService->markAsRead($notifications[0]['id']);
    echo $result5 ? "✓ Notification marked as read\n" : "❌ Failed to mark as read\n";
    echo "\n";
}

// Test 6: Database verification
echo "Test 6: Verifying database...\n";
try {
    $db = \Nebatech\Core\Database::query("SELECT COUNT(*) as count FROM notifications");
    $totalNotifications = $db[0]['count'] ?? 0;
    echo "✓ Total notifications in database: {$totalNotifications}\n";
    
    $unreadDb = \Nebatech\Core\Database::query(
        "SELECT COUNT(*) as count FROM notifications WHERE is_read = 0"
    );
    $totalUnread = $unreadDb[0]['count'] ?? 0;
    echo "✓ Total unread notifications: {$totalUnread}\n";
} catch (\Exception $e) {
    echo "❌ Database error: " . $e->getMessage() . "\n";
}

echo "\n=== Test Complete ===\n\n";

echo "Next steps:\n";
echo "1. Login to the application as: {$testUser['email']}\n";
echo "2. Click the bell icon in the top-right corner\n";
echo "3. You should see the test notifications\n";
echo "4. Try clicking on notifications to test navigation\n";
echo "5. Try marking notifications as read\n";
echo "6. Try deleting notifications\n";
echo "\nFull notifications page: /notifications\n";
