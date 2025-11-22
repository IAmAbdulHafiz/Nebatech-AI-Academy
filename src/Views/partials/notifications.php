<!-- Notifications Dropdown -->
<div class="relative" x-data="{ open: false }">
    <button @click="open = !open" 
            class="relative p-2 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white focus:outline-none">
        <span class="sr-only">View notifications</span>
        🔔
        <?php if (isset($unreadCount) && $unreadCount > 0): ?>
            <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-500 rounded-full">
                <?= $unreadCount > 9 ? '9+' : $unreadCount ?>
            </span>
        <?php endif; ?>
    </button>

    <!-- Dropdown Panel -->
    <div x-show="open" 
         @click.away="open = false"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="transform opacity-100 scale-100"
         x-transition:leave-end="transform opacity-0 scale-95"
         class="absolute right-0 mt-2 w-96 bg-white dark:bg-gray-800 rounded-lg shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden z-50"
         style="display: none;">
        
        <!-- Header -->
        <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
            <h3 class="font-semibold text-gray-900 dark:text-white">Notifications</h3>
            <?php if (isset($unreadCount) && $unreadCount > 0): ?>
                <button onclick="markAllRead()" 
                        class="text-sm text-primary hover:underline">
                    Mark all read
                </button>
            <?php endif; ?>
        </div>

        <!-- Notifications List -->
        <div id="notifications-list" class="max-h-96 overflow-y-auto">
            <?php if (empty($notifications)): ?>
                <div class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                    <div class="text-4xl mb-2">🔕</div>
                    <p>No notifications yet</p>
                </div>
            <?php else: ?>
                <?php foreach ($notifications as $notification): ?>
                    <div class="px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700 border-b border-gray-200 dark:border-gray-700 <?= !$notification['is_read'] ? 'bg-blue-50 dark:bg-primary/90/20' : '' ?>"
                         data-id="<?= $notification['id'] ?>">
                        <div class="flex items-start space-x-3">
                            <!-- Icon -->
                            <div class="flex-shrink-0 text-2xl">
                                <?php
                                $icon = match($notification['type']) {
                                    'comment' => '💬',
                                    'like' => '❤️',
                                    'badge' => '🏅',
                                    'mention' => '📢',
                                    'follow' => '👤',
                                    'solution' => '✅',
                                    default => '🔔'
                                };
                                echo $icon;
                                ?>
                            </div>
                            
                            <!-- Content -->
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 dark:text-white">
                                    <?= htmlspecialchars($notification['title']) ?>
                                </p>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                    <?= htmlspecialchars($notification['message']) ?>
                                </p>
                                <div class="flex items-center space-x-2 mt-2">
                                    <span class="text-xs text-gray-500 dark:text-gray-400">
                                        <?php
                                        $time = strtotime($notification['created_at']);
                                        $diff = time() - $time;
                                        if ($diff < 60) {
                                            echo 'Just now';
                                        } elseif ($diff < 3600) {
                                            echo floor($diff / 60) . ' min ago';
                                        } elseif ($diff < 86400) {
                                            echo floor($diff / 3600) . ' hours ago';
                                        } else {
                                            echo date('M j', $time);
                                        }
                                        ?>
                                    </span>
                                    <?php if ($notification['link']): ?>
                                        <a href="<?= htmlspecialchars($notification['link']) ?>" 
                                           onclick="markAsRead(<?= $notification['id'] ?>)"
                                           class="text-xs text-primary hover:underline">
                                            View →
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Unread Indicator -->
                            <?php if (!$notification['is_read']): ?>
                                <div class="flex-shrink-0">
                                    <span class="inline-block w-2 h-2 bg-primary/90 rounded-full"></span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Footer -->
        <?php if (!empty($notifications)): ?>
            <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-700 text-center">
                <a href="/notifications" class="text-sm text-primary hover:underline font-medium">
                    View all notifications
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
async function markAsRead(notificationId) {
    try {
        await fetch('/api/notifications/read', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id: notificationId })
        });
    } catch (error) {
        console.error('Error marking notification as read:', error);
    }
}

async function markAllRead() {
    try {
        const response = await fetch('/api/notifications/mark-all-read', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' }
        });
        
        if (response.ok) {
            location.reload();
        }
    } catch (error) {
        console.error('Error marking all as read:', error);
    }
}

// Poll for new notifications every 30 seconds
setInterval(async () => {
    try {
        const response = await fetch('/api/notifications/unread-count');
        const data = await response.json();
        
        if (data.count !== <?= $unreadCount ?? 0 ?>) {
            // Reload notifications dropdown content
            location.reload();
        }
    } catch (error) {
        console.error('Error checking notifications:', error);
    }
}, 30000);
</script>

