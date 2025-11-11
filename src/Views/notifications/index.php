<?php
$title = 'Notifications';
ob_start();
// Load appropriate sidebar based on user role
if ($user['role'] === 'student') {
    include __DIR__ . '/../partials/student-sidebar.php';
} elseif ($user['role'] === 'facilitator') {
    include __DIR__ . '/../partials/facilitator-sidebar.php';
} elseif ($user['role'] === 'admin') {
    include __DIR__ . '/../partials/admin-sidebar.php';
}
$sidebarContent = ob_get_clean();
ob_start();
?>

<!-- Page Header -->
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900 mb-2">Notifications</h1>
    <p class="text-gray-600">Stay updated with your latest activities</p>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Total</p>
                <p class="text-3xl font-bold text-gray-900"><?= count($notifications) ?></p>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-bell text-blue-600 text-xl"></i>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Unread</p>
                <p class="text-3xl font-bold text-orange-600"><?= $unreadCount ?></p>
            </div>
            <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-envelope text-orange-600 text-xl"></i>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Read</p>
                <p class="text-3xl font-bold text-green-600"><?= count($notifications) - $unreadCount ?></p>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-check-circle text-green-600 text-xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Notifications List -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200">
    <?php if (!empty($notifications)): ?>
        <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-900">All Notifications</h2>
            <div class="flex items-center gap-2">
                <?php if ($unreadCount > 0): ?>
                    <button onclick="markAllAsRead()" 
                            class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-blue-700 transition text-sm font-medium">
                        <i class="fas fa-check-double mr-2"></i>Mark All Read
                    </button>
                <?php endif; ?>
                <button onclick="deleteAllNotifications()" 
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-sm font-medium">
                    <i class="fas fa-trash-alt mr-2"></i>Delete All
                </button>
            </div>
        </div>
    <?php else: ?>
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">All Notifications</h2>
        </div>
    <?php endif; ?>

    <?php if (empty($notifications)): ?>
        <div class="text-center py-12">
            <i class="fas fa-bell-slash text-5xl text-gray-300 mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">No Notifications</h3>
            <p class="text-gray-600">You're all caught up! Check back later for updates.</p>
        </div>
    <?php else: ?>
        <div class="divide-y divide-gray-200">
                <?php foreach ($notifications as $notification): 
                    $icon = \Nebatech\Models\Notification::getIcon($notification['type']);
                    $color = \Nebatech\Models\Notification::getColor($notification['type']);
                    $isUnread = !$notification['is_read'];
                ?>
                    <div class="p-4 hover:bg-gray-50 transition <?= $isUnread ? 'bg-blue-50' : '' ?>" 
                         data-notification-id="<?= $notification['id'] ?>">
                        <div class="flex items-start gap-4">
                            <!-- Icon -->
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 rounded-full bg-<?= $color ?>-100 text-<?= $color ?>-600 flex items-center justify-center">
                                    <i class="fas <?= $icon ?> text-lg"></i>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between gap-4">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 mb-1">
                                            <h3 class="text-base font-semibold text-gray-900">
                                                <?= htmlspecialchars($notification['title']) ?>
                                            </h3>
                                            <?php if ($isUnread): ?>
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    New
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                        <p class="text-sm text-gray-600 mb-2">
                                            <?= htmlspecialchars($notification['message']) ?>
                                        </p>
                                        <div class="flex items-center gap-4 text-xs text-gray-500">
                                            <span>
                                                <i class="far fa-clock mr-1"></i>
                                                <?= timeAgo($notification['created_at']) ?>
                                            </span>
                                            <span class="text-gray-300">•</span>
                                            <span class="capitalize"><?= str_replace('_', ' ', $notification['type']) ?></span>
                                        </div>
                                    </div>

                                    <!-- Actions -->
                                    <div class="flex items-center gap-2">
                                        <?php if ($notification['action_url']): ?>
                                            <a href="<?= url($notification['action_url']) ?>" 
                                               onclick="markAsRead(<?= $notification['id'] ?>)"
                                               class="px-3 py-1.5 text-sm bg-primary text-white rounded hover:bg-blue-700 transition">
                                                View
                                            </a>
                                        <?php endif; ?>
                                        <?php if ($isUnread): ?>
                                            <button onclick="markAsRead(<?= $notification['id'] ?>)" 
                                                    class="px-3 py-1.5 text-sm border border-gray-300 text-gray-700 rounded hover:bg-gray-100 transition">
                                                Mark Read
                                            </button>
                                        <?php endif; ?>
                                        <button onclick="deleteNotification(<?= $notification['id'] ?>)" 
                                                class="p-1.5 text-gray-400 hover:text-red-600 transition">
                                            <i class="fas fa-trash text-sm"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<script>
async function markAsRead(notificationId) {
    try {
        const response = await fetch('/api/notifications/mark-read', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ notification_id: notificationId })
        });

        const data = await response.json();
        
        if (data.success) {
            // Remove unread styling
            const notificationEl = document.querySelector(`[data-notification-id="${notificationId}"]`);
            if (notificationEl) {
                notificationEl.classList.remove('bg-blue-50');
                const badge = notificationEl.querySelector('.bg-blue-100');
                if (badge) badge.remove();
                const markReadBtn = notificationEl.querySelector('button[onclick*="markAsRead"]');
                if (markReadBtn) markReadBtn.remove();
            }
            
            Toast.success('Notification marked as read');
            
            // Reload page to update counts
            setTimeout(() => location.reload(), 1000);
        } else {
            Toast.error('Failed to mark notification as read');
        }
    } catch (error) {
        console.error('Failed to mark as read:', error);
        Toast.error('An error occurred. Please try again.');
    }
}

async function markAllAsRead() {
    try {
        const response = await fetch('/api/notifications/mark-all-read', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            }
        });

        const data = await response.json();
        
        if (data.success) {
            Toast.success('All notifications marked as read');
            setTimeout(() => location.reload(), 1000);
        } else {
            Toast.error('Failed to mark all notifications as read');
        }
    } catch (error) {
        console.error('Failed to mark all as read:', error);
        Toast.error('An error occurred. Please try again.');
    }
}

async function deleteNotification(notificationId) {
    // Show confirmation modal
    const confirmed = await ConfirmModal.show(
        'Are you sure you want to delete this notification? This action cannot be undone.',
        {
            title: 'Delete Notification',
            confirmText: 'Delete',
            cancelText: 'Cancel',
            type: 'danger'
        }
    );

    if (!confirmed) {
        return;
    }

    try {
        const response = await fetch('/api/notifications/delete', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ notification_id: notificationId })
        });

        const data = await response.json();
        
        if (data.success) {
            // Remove notification from DOM with animation
            const notificationEl = document.querySelector(`[data-notification-id="${notificationId}"]`);
            if (notificationEl) {
                notificationEl.style.transition = 'opacity 0.3s ease-out';
                notificationEl.style.opacity = '0';
                setTimeout(() => notificationEl.remove(), 300);
            }
            
            Toast.success('Notification deleted successfully');
            
            // Reload page after a short delay
            setTimeout(() => location.reload(), 1000);
        } else {
            Toast.error('Failed to delete notification');
        }
    } catch (error) {
        console.error('Failed to delete notification:', error);
        Toast.error('An error occurred. Please try again.');
    }
}

async function deleteAllNotifications() {
    // Show confirmation modal
    const confirmed = await ConfirmModal.show(
        'Are you sure you want to delete ALL notifications? This action cannot be undone.',
        {
            title: 'Delete All Notifications',
            confirmText: 'Delete All',
            cancelText: 'Cancel',
            type: 'danger'
        }
    );

    if (!confirmed) {
        return;
    }

    try {
        const response = await fetch('/api/notifications/delete-all', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            }
        });

        const data = await response.json();
        
        if (data.success) {
            Toast.success('All notifications deleted successfully');
            // Reload page after a short delay
            setTimeout(() => location.reload(), 1000);
        } else {
            Toast.error('Failed to delete all notifications');
        }
    } catch (error) {
        console.error('Failed to delete all notifications:', error);
        Toast.error('An error occurred. Please try again.');
    }
}

function timeAgo(datetime) {
    const timestamp = new Date(datetime).getTime();
    const now = Date.now();
    const diff = Math.floor((now - timestamp) / 1000);

    if (diff < 60) return 'Just now';
    if (diff < 3600) {
        const mins = Math.floor(diff / 60);
        return mins + ' minute' + (mins > 1 ? 's' : '') + ' ago';
    }
    if (diff < 86400) {
        const hours = Math.floor(diff / 3600);
        return hours + ' hour' + (hours > 1 ? 's' : '') + ' ago';
    }
    if (diff < 604800) {
        const days = Math.floor(diff / 86400);
        return days + ' day' + (days > 1 ? 's' : '') + ' ago';
    }
    return new Date(timestamp).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
}
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/dashboard.php';
