/**
 * Notification Widget for Alpine.js
 * Handles real-time notifications in the dashboard
 */

function notificationWidget() {
    return {
        notifications: [],
        unreadCount: 0,
        loading: false,
        pollingInterval: null,

        init() {
            // Load initial unread count
            this.loadUnreadCount();
            
            // Start polling for new notifications every 30 seconds
            this.startPolling();
        },

        async loadNotifications() {
            this.loading = true;
            try {
                const response = await fetch('/api/notifications?limit=10');
                const data = await response.json();
                
                if (data.success) {
                    this.notifications = data.notifications;
                    this.unreadCount = data.unread_count;
                }
            } catch (error) {
                console.error('Failed to load notifications:', error);
            } finally {
                this.loading = false;
            }
        },

        async loadUnreadCount() {
            try {
                const response = await fetch('/api/notifications/unread-count');
                const data = await response.json();
                
                if (data.success) {
                    this.unreadCount = data.count;
                }
            } catch (error) {
                console.error('Failed to load unread count:', error);
            }
        },

        async markAsRead(notificationId) {
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
                    // Update notification in list
                    const notification = this.notifications.find(n => n.id === notificationId);
                    if (notification) {
                        notification.is_read = true;
                    }
                    this.unreadCount = data.unread_count;
                }
            } catch (error) {
                console.error('Failed to mark notification as read:', error);
            }
        },

        async markAllAsRead() {
            try {
                const response = await fetch('/api/notifications/mark-all-read', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    }
                });

                const data = await response.json();
                
                if (data.success) {
                    // Update all notifications in list
                    this.notifications.forEach(notification => {
                        notification.is_read = true;
                    });
                    this.unreadCount = 0;
                    
                    // Show success message using global Toast
                    if (typeof Toast !== 'undefined') {
                        Toast.success('All notifications marked as read');
                    }
                } else {
                    if (typeof Toast !== 'undefined') {
                        Toast.error('Failed to mark notifications as read');
                    }
                }
            } catch (error) {
                console.error('Failed to mark all as read:', error);
                if (typeof Toast !== 'undefined') {
                    Toast.error('Failed to mark notifications as read');
                }
            }
        },

        async deleteNotification(notificationId) {
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
                    // Remove notification from list
                    this.notifications = this.notifications.filter(n => n.id !== notificationId);
                    this.unreadCount = data.unread_count;
                    
                    if (typeof Toast !== 'undefined') {
                        Toast.success('Notification deleted');
                    }
                } else {
                    if (typeof Toast !== 'undefined') {
                        Toast.error('Failed to delete notification');
                    }
                }
            } catch (error) {
                console.error('Failed to delete notification:', error);
                if (typeof Toast !== 'undefined') {
                    Toast.error('Failed to delete notification');
                }
            }
        },

        handleNotificationClick(notification) {
            // Mark as read if unread
            if (!notification.is_read) {
                this.markAsRead(notification.id);
            }

            // Navigate to action URL if available
            if (notification.action_url) {
                window.location.href = notification.action_url;
            }
        },

        startPolling() {
            // Poll for new notifications every 30 seconds
            this.pollingInterval = setInterval(() => {
                this.loadUnreadCount();
            }, 30000);
        },

        stopPolling() {
            if (this.pollingInterval) {
                clearInterval(this.pollingInterval);
            }
        },

        destroy() {
            this.stopPolling();
        }
    };
}

// Make it globally available
window.notificationWidget = notificationWidget;
