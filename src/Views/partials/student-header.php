<?php
/**
 * Student Header Partial
 * Contains the top header bar for the student portal
 */
?>

<!-- Top Header -->
<header class="sticky top-0 z-40 bg-white/80 backdrop-blur-lg border-b border-gray-200/50 shadow-sm">
    <div class="flex items-center justify-between h-16 px-6">
        <!-- Mobile Menu Button -->
        <button @click="sidebarOpen = true" class="lg:hidden w-10 h-10 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-600 flex items-center justify-center transition">
            <i class="fas fa-bars text-lg"></i>
        </button>

        <!-- Page Title / Breadcrumb -->
        <div class="hidden lg:flex items-center">
            <nav class="flex items-center text-sm">
                <a href="<?= url('/dashboard') ?>" class="text-gray-400 hover:text-primary transition">
                    <i class="fas fa-home"></i>
                </a>
                <i class="fas fa-chevron-right text-gray-300 mx-3 text-xs"></i>
                <span class="font-semibold text-gray-900"><?= $pageTitle ?? 'Dashboard' ?></span>
            </nav>
        </div>

        <!-- Right Side Actions -->
        <div class="flex items-center space-x-3">
            <!-- Search -->
            <div class="hidden md:block relative">
                <input type="text" placeholder="Search courses, lessons..." 
                       class="w-72 pl-10 pr-4 py-2.5 bg-gray-100 border-0 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white text-sm transition">
                <i class="fas fa-search absolute left-3.5 top-3 text-gray-400"></i>
            </div>

            <!-- Quick Actions -->
            <a href="<?= url('/courses') ?>" class="hidden lg:flex items-center gap-2 px-4 py-2.5 bg-primary/10 text-primary rounded-xl hover:bg-primary/20 transition text-sm font-medium">
                <i class="fas fa-plus"></i>
                <span>Browse Courses</span>
            </a>

            <!-- Notifications -->
            <div class="relative" x-data="{ notifOpen: false }">
                <button @click="notifOpen = !notifOpen" class="relative w-10 h-10 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-600 flex items-center justify-center transition">
                    <i class="fas fa-bell text-lg"></i>
                    <?php if (!empty($unreadNotifications)): ?>
                    <span class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center font-bold">
                        <?= min($unreadNotifications, 9) ?><?= $unreadNotifications > 9 ? '+' : '' ?>
                    </span>
                    <?php endif; ?>
                </button>
                
                <!-- Notification Dropdown -->
                <div x-show="notifOpen" 
                     x-cloak
                     @click.away="notifOpen = false"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     class="absolute right-0 mt-2 w-80 bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden">
                    <div class="px-4 py-3 bg-gradient-to-r from-primary to-blue-700 text-white">
                        <div class="flex items-center justify-between">
                            <h3 class="font-semibold">Notifications</h3>
                            <span class="text-xs bg-white/20 px-2 py-0.5 rounded-full"><?= $unreadNotifications ?? 0 ?> new</span>
                        </div>
                    </div>
                    <div class="max-h-72 overflow-y-auto">
                        <div class="p-8 text-center">
                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-bell-slash text-2xl text-gray-400"></i>
                            </div>
                            <p class="text-gray-500 text-sm">You're all caught up!</p>
                            <p class="text-gray-400 text-xs mt-1">No new notifications</p>
                        </div>
                    </div>
                    <div class="p-3 border-t border-gray-100 bg-gray-50">
                        <a href="<?= url('/notifications') ?>" class="block text-center text-sm text-primary hover:text-blue-700 font-medium transition">
                            View all notifications →
                        </a>
                    </div>
                </div>
            </div>

            <!-- User Avatar (Desktop) -->
            <a href="<?= url('/profile') ?>" class="hidden lg:flex items-center gap-3 pl-3 pr-4 py-1.5 rounded-xl hover:bg-gray-100 transition">
                <img src="<?= avatar_url($user['avatar'] ?? null) ?>" 
                     alt="<?= htmlspecialchars($user['first_name'] ?? 'User') ?>"
                     class="w-8 h-8 rounded-lg object-cover">
                <div class="text-left">
                    <p class="text-sm font-medium text-gray-900"><?= htmlspecialchars($user['first_name'] ?? 'User') ?></p>
                    <p class="text-xs text-gray-500">View profile</p>
                </div>
            </a>
        </div>
    </div>
</header>
