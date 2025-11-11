<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= csrf_token() ?>">
    <title><?= $title ?? 'Dashboard' ?> - Nebatech AI Academy</title>
    <link href="<?= asset('css/main.css') ?>" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script src="<?= asset('js/notification-widget.js') ?>"></script>
    <script src="<?= asset('js/notifications.js') ?>"></script>
    <script src="<?= asset('js/codeEditorSimple.js') ?>"></script>
    <?php if (isset($user) && $user['role'] === 'facilitator'): ?>
    <script src="<?= asset('js/facilitator-cohorts.js') ?>"></script>
    <?php endif; ?>
    <style>
        [x-cloak] { display: none !important; }
        /* Ensure proper margin on desktop for sidebar layout */
        @media (min-width: 1024px) {
            main.dashboard-main {
                margin-left: 16rem; /* Default: sidebar open (256px / 16rem) */
            }
            main.dashboard-main.sidebar-closed {
                margin-left: 4rem; /* Sidebar collapsed (64px / 4rem) */
            }
        }
    </style>
</head>
<body class="bg-gray-50" x-data="{ 
        sidebarOpen: localStorage.getItem('sidebarOpen') === 'false' ? false : true,
        profileDropdown: false,
        notificationDropdown: false,
        init() {
            this.$watch('sidebarOpen', value => localStorage.setItem('sidebarOpen', value));
        }
    }" x-init="init()">
    <!-- Dashboard Header -->
    <header class="bg-white border-b border-gray-200 fixed w-full top-0 z-40">
        <div class="flex items-center justify-between px-6 py-4">
            <!-- Logo & Menu Toggle -->
            <div class="flex items-center gap-4">
                <button @click="sidebarOpen = !sidebarOpen" class="text-gray-600 hover:text-primary">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <a href="<?= url('/dashboard') ?>" class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-primary rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-xl">N</span>
                    </div>
                    <span class="font-bold text-xl text-gray-900 hidden sm:block">Nebatech AI Academy</span>
                </a>
            </div>

            <!-- Search Bar (Desktop) -->
            <div class="hidden md:flex flex-1 max-w-xl mx-8">
                <div class="relative w-full">
                    <input type="text" placeholder="Search courses, lessons..." 
                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
            </div>

            <!-- Right Actions -->
            <div class="flex items-center gap-4">
                <!-- Notifications -->
                <div class="relative" @click.away="notificationDropdown = false" x-data="notificationWidget()">
                    <button @click="notificationDropdown = !notificationDropdown; if(notificationDropdown) loadNotifications()" 
                            class="relative text-gray-600 hover:text-primary transition">
                        <i class="fas fa-bell text-xl"></i>
                        <span x-show="unreadCount > 0" 
                              x-text="unreadCount > 99 ? '99+' : unreadCount"
                              class="absolute -top-1 -right-1 bg-secondary text-white text-xs min-w-[20px] h-5 rounded-full flex items-center justify-center px-2">
                        </span>
                    </button>

                    <!-- Notification Dropdown -->
                    <div x-show="notificationDropdown" 
                         x-cloak
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-96 bg-white rounded-lg shadow-xl border border-gray-200 z-50">
                        
                        <!-- Header -->
                        <div class="flex items-center justify-between px-4 py-3 border-b border-gray-200">
                            <h3 class="font-semibold text-gray-900">Notifications</h3>
                            <div class="flex items-center gap-2">
                                <button @click="markAllAsRead()" 
                                        x-show="unreadCount > 0"
                                        class="text-xs text-primary hover:text-blue-700 font-medium">
                                    Mark all read
                                </button>
                                <a href="<?= url('/notifications') ?>" 
                                   class="text-xs text-gray-600 hover:text-gray-900">
                                    View all
                                </a>
                            </div>
                        </div>

                        <!-- Notifications List -->
                        <div class="max-h-96 overflow-y-auto">
                            <template x-if="loading">
                                <div class="flex items-center justify-center py-8">
                                    <i class="fas fa-spinner fa-spin text-2xl text-gray-400"></i>
                                </div>
                            </template>

                            <template x-if="!loading && notifications.length === 0">
                                <div class="text-center py-8 text-gray-500">
                                    <i class="fas fa-bell-slash text-3xl mb-2"></i>
                                    <p class="text-sm">No notifications</p>
                                </div>
                            </template>

                            <template x-if="!loading && notifications.length > 0">
                                <div>
                                    <template x-for="notification in notifications" :key="notification.id">
                                        <div @click="handleNotificationClick(notification)"
                                             class="px-4 py-3 hover:bg-gray-50 cursor-pointer border-b border-gray-100 transition"
                                             :class="!notification.is_read ? 'bg-blue-50' : ''">
                                            <div class="flex items-start gap-3">
                                                <div class="flex-shrink-0 mt-1">
                                                    <div class="w-10 h-10 rounded-full flex items-center justify-center"
                                                         :class="'bg-' + notification.color + '-100 text-' + notification.color + '-600'">
                                                        <i :class="'fas ' + notification.icon"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <div class="flex items-start justify-between gap-2">
                                                        <p class="text-sm font-semibold text-gray-900" x-text="notification.title"></p>
                                                        <button @click.stop="deleteNotification(notification.id)" 
                                                                class="text-gray-400 hover:text-red-600 transition">
                                                            <i class="fas fa-times text-xs"></i>
                                                        </button>
                                                    </div>
                                                    <p class="text-sm text-gray-600 mt-1 line-clamp-2" x-text="notification.message"></p>
                                                    <p class="text-xs text-gray-400 mt-1" x-text="notification.time_ago"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </template>
                        </div>

                        <!-- Footer -->
                        <div class="px-4 py-3 bg-gray-50 border-t border-gray-200 text-center">
                            <a href="<?= url('/notifications') ?>" 
                               class="text-sm text-primary hover:text-blue-700 font-medium">
                                View All Notifications
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Profile Dropdown -->
                <div class="relative" @click.away="profileDropdown = false">
                    <button @click="profileDropdown = !profileDropdown" class="flex items-center gap-2 hover:bg-gray-100 rounded-lg px-3 py-2 transition">
                        <?php if (!empty($user['avatar'])): ?>
                            <img src="<?= htmlspecialchars($user['avatar']) ?>" alt="Profile" class="w-8 h-8 rounded-full object-cover">
                        <?php else: ?>
                            <div class="w-8 h-8 bg-primary text-white rounded-full flex items-center justify-center text-sm font-bold">
                                <?= strtoupper(substr($user['first_name'] ?? 'U', 0, 1) . substr($user['last_name'] ?? 'S', 0, 1)) ?>
                            </div>
                        <?php endif; ?>
                        <span class="hidden sm:block font-medium text-gray-700"><?= htmlspecialchars($user['first_name'] ?? 'User') ?></span>
                        <i class="fas fa-chevron-down text-xs text-gray-500"></i>
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="profileDropdown" 
                         x-cloak
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-lg border border-gray-200 py-2">
                        <div class="px-4 py-3 border-b border-gray-200">
                            <p class="text-sm font-semibold text-gray-900 truncate"><?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?></p>
                            <p class="text-xs text-gray-500 truncate" title="<?= htmlspecialchars($user['email']) ?>"><?= htmlspecialchars($user['email']) ?></p>
                        </div>
                        <a href="<?= url('/profile') ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-user mr-2 text-gray-400"></i>My Profile
                        </a>
                        <a href="<?= url('/settings') ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-cog mr-2 text-gray-400"></i>Settings
                        </a>
                        <div class="border-t border-gray-200 my-2"></div>
                        <a href="<?= url('/logout') ?>" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                            <i class="fas fa-sign-out-alt mr-2"></i>Logout
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Sidebar -->
    <aside :class="sidebarOpen ? 'translate-x-0 lg:w-64' : '-translate-x-full lg:translate-x-0 lg:w-16'" 
           class="fixed left-0 top-16 h-[calc(100vh-4rem)] w-64 bg-white border-r border-gray-200 transition-all duration-300 ease-in-out z-30 overflow-y-auto">
        <nav class="p-4 space-y-2">
            <?= $sidebarContent ?? '' ?>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="dashboard-main pt-16 transition-all duration-300 ease-in-out min-h-screen" 
          :class="{ 'sidebar-closed': !sidebarOpen }">
        <div class="p-6">
            <?= $content ?? '' ?>
        </div>
    </main>

    <!-- Mobile Sidebar Overlay -->
    <div x-show="sidebarOpen" 
         x-cloak
         @click="sidebarOpen = false"
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black bg-opacity-50 z-20 lg:hidden">
    </div>
</body>
</html>
