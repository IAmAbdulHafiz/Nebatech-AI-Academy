<?php
/**
 * Student Sidebar Partial
 * Contains the sidebar navigation for the student portal
 * 
 * Required variables:
 * - $user: Current user data
 * - $studentStats: (optional) Array with 'courses', 'completed', 'certificates' counts
 */

// Active link helper
$currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$isActive = function($path) use ($currentPath) {
    if ($path === '/dashboard') {
        return $currentPath === '/dashboard';
    }
    return strpos($currentPath, $path) === 0;
};
?>

<!-- Student Sidebar -->
<aside class="fixed inset-y-0 left-0 z-50 w-72 bg-gradient-to-b from-slate-900 via-slate-800 to-slate-900 transform transition-transform duration-300 lg:translate-x-0 flex flex-col shadow-2xl"
       :class="{ '-translate-x-full': !sidebarOpen, 'translate-x-0': sidebarOpen }">
    
    <!-- Logo Section -->
    <div class="flex items-center justify-between h-20 px-6 border-b border-white/10 flex-shrink-0">
        <a href="<?= url('/dashboard') ?>" class="flex items-center group">
            <div class="w-11 h-11 bg-gradient-to-br from-blue-500 to-blue-700 rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/30 group-hover:shadow-blue-500/50 transition-shadow">
                <i class="fas fa-graduation-cap text-xl text-white"></i>
            </div>
            <div class="ml-3">
                <span class="text-lg font-bold text-white">Student Portal</span>
                <p class="text-xs text-blue-400">Nebatech Academy</p>
            </div>
        </a>
        <button @click="sidebarOpen = false" class="lg:hidden text-gray-400 hover:text-white transition">
            <i class="fas fa-times text-xl"></i>
        </button>
    </div>

    <!-- Quick Stats Bar -->
    <div class="px-6 py-4 border-b border-white/10">
        <div class="flex items-center justify-between">
            <div class="text-center">
                <p class="text-2xl font-bold text-white"><?= $studentStats['courses'] ?? 0 ?></p>
                <p class="text-xs text-gray-400">Courses</p>
            </div>
            <div class="w-px h-8 bg-white/20"></div>
            <div class="text-center">
                <p class="text-2xl font-bold text-green-400"><?= $studentStats['completed'] ?? 0 ?></p>
                <p class="text-xs text-gray-400">Completed</p>
            </div>
            <div class="w-px h-8 bg-white/20"></div>
            <div class="text-center">
                <p class="text-2xl font-bold text-yellow-400"><?= $studentStats['certificates'] ?? 0 ?></p>
                <p class="text-xs text-gray-400">Certificates</p>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 px-4 py-6 space-y-6 overflow-y-auto scrollbar-thin scrollbar-thumb-gray-600">
        
        <!-- MAIN Section -->
        <div>
            <h3 class="px-4 text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-3 flex items-center">
                <span class="w-2 h-2 bg-blue-500 rounded-full mr-2"></span>
                Main
            </h3>
            <div class="space-y-1">
                <!-- Dashboard -->
                <a href="<?= url('/dashboard') ?>" 
                   class="sidebar-link flex items-center px-4 py-3 rounded-xl transition group <?= $isActive('/dashboard') ? 'active text-white shadow-lg' : 'text-gray-300 hover:bg-white/5 hover:text-white' ?>">
                    <div class="w-9 h-9 rounded-lg <?= $isActive('/dashboard') ? 'bg-white/20' : 'bg-white/5 group-hover:bg-white/10' ?> flex items-center justify-center transition">
                        <i class="fas fa-home"></i>
                    </div>
                    <span class="ml-3 font-medium">Dashboard</span>
                    <?php if ($isActive('/dashboard')): ?>
                    <i class="fas fa-chevron-right ml-auto text-xs opacity-50"></i>
                    <?php endif; ?>
                </a>

                <!-- My Courses -->
                <a href="<?= url('/my-courses') ?>" 
                   class="sidebar-link flex items-center px-4 py-3 rounded-xl transition group <?= $isActive('/my-courses') ? 'active text-white shadow-lg' : 'text-gray-300 hover:bg-white/5 hover:text-white' ?>">
                    <div class="w-9 h-9 rounded-lg <?= $isActive('/my-courses') ? 'bg-white/20' : 'bg-white/5 group-hover:bg-white/10' ?> flex items-center justify-center transition">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <span class="ml-3 font-medium">My Courses</span>
                </a>

                <!-- My Cohorts -->
                <a href="<?= url('/my-cohorts') ?>" 
                   class="sidebar-link flex items-center px-4 py-3 rounded-xl transition group <?= $isActive('/my-cohorts') ? 'active text-white shadow-lg' : 'text-gray-300 hover:bg-white/5 hover:text-white' ?>">
                    <div class="w-9 h-9 rounded-lg <?= $isActive('/my-cohorts') ? 'bg-white/20' : 'bg-white/5 group-hover:bg-white/10' ?> flex items-center justify-center transition">
                        <i class="fas fa-users"></i>
                    </div>
                    <span class="ml-3 font-medium">My Cohorts</span>
                </a>

                <!-- My Applications -->
                <a href="<?= url('/my-applications') ?>" 
                   class="sidebar-link flex items-center px-4 py-3 rounded-xl transition group <?= $isActive('/my-applications') ? 'active text-white shadow-lg' : 'text-gray-300 hover:bg-white/5 hover:text-white' ?>">
                    <div class="w-9 h-9 rounded-lg <?= $isActive('/my-applications') ? 'bg-white/20' : 'bg-white/5 group-hover:bg-white/10' ?> flex items-center justify-center transition">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <span class="ml-3 font-medium">Applications</span>
                </a>
            </div>
        </div>

        <!-- LEARNING Section -->
        <div>
            <h3 class="px-4 text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-3 flex items-center">
                <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                Learning
            </h3>
            <div class="space-y-1">
                <!-- Browse Courses -->
                <a href="<?= url('/courses') ?>" 
                   class="sidebar-link flex items-center px-4 py-3 rounded-xl transition group <?= $isActive('/courses') ? 'active text-white shadow-lg' : 'text-gray-300 hover:bg-white/5 hover:text-white' ?>">
                    <div class="w-9 h-9 rounded-lg <?= $isActive('/courses') ? 'bg-white/20' : 'bg-white/5 group-hover:bg-white/10' ?> flex items-center justify-center transition">
                        <i class="fas fa-compass"></i>
                    </div>
                    <span class="ml-3 font-medium">Browse Courses</span>
                    <span class="ml-auto px-2 py-0.5 bg-green-500/20 text-green-400 text-[10px] font-bold rounded-full">NEW</span>
                </a>

                <!-- Code Playground -->
                <a href="<?= url('/playground') ?>" 
                   class="sidebar-link flex items-center px-4 py-3 rounded-xl transition group <?= $isActive('/playground') ? 'active text-white shadow-lg' : 'text-gray-300 hover:bg-white/5 hover:text-white' ?>">
                    <div class="w-9 h-9 rounded-lg <?= $isActive('/playground') ? 'bg-white/20' : 'bg-white/5 group-hover:bg-white/10' ?> flex items-center justify-center transition">
                        <i class="fas fa-code"></i>
                    </div>
                    <span class="ml-3 font-medium">Code Playground</span>
                </a>

                <!-- Student Showcase -->
                <a href="<?= url('/showcase') ?>" 
                   class="sidebar-link flex items-center px-4 py-3 rounded-xl transition group <?= $isActive('/showcase') ? 'active text-white shadow-lg' : 'text-gray-300 hover:bg-white/5 hover:text-white' ?>">
                    <div class="w-9 h-9 rounded-lg <?= $isActive('/showcase') ? 'bg-white/20' : 'bg-white/5 group-hover:bg-white/10' ?> flex items-center justify-center transition">
                        <i class="fas fa-trophy"></i>
                    </div>
                    <span class="ml-3 font-medium">Showcase</span>
                </a>
            </div>
        </div>

        <!-- PROGRESS Section -->
        <div>
            <h3 class="px-4 text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-3 flex items-center">
                <span class="w-2 h-2 bg-purple-500 rounded-full mr-2"></span>
                Progress
            </h3>
            <div class="space-y-1">
                <!-- My Progress -->
                <a href="<?= url('/progress/dashboard') ?>" 
                   class="sidebar-link flex items-center px-4 py-3 rounded-xl transition group <?= $isActive('/progress') ? 'active text-white shadow-lg' : 'text-gray-300 hover:bg-white/5 hover:text-white' ?>">
                    <div class="w-9 h-9 rounded-lg <?= $isActive('/progress') ? 'bg-white/20' : 'bg-white/5 group-hover:bg-white/10' ?> flex items-center justify-center transition">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <span class="ml-3 font-medium">My Progress</span>
                </a>

                <!-- Certificates -->
                <a href="<?= url('/my-certificates') ?>" 
                   class="sidebar-link flex items-center px-4 py-3 rounded-xl transition group <?= $isActive('/my-certificates') ? 'active text-white shadow-lg' : 'text-gray-300 hover:bg-white/5 hover:text-white' ?>">
                    <div class="w-9 h-9 rounded-lg <?= $isActive('/my-certificates') ? 'bg-white/20' : 'bg-white/5 group-hover:bg-white/10' ?> flex items-center justify-center transition">
                        <i class="fas fa-award"></i>
                    </div>
                    <span class="ml-3 font-medium">Certificates</span>
                </a>

                <!-- Portfolio -->
                <a href="<?= url('/my-portfolio') ?>" 
                   class="sidebar-link flex items-center px-4 py-3 rounded-xl transition group <?= $isActive('/my-portfolio') ? 'active text-white shadow-lg' : 'text-gray-300 hover:bg-white/5 hover:text-white' ?>">
                    <div class="w-9 h-9 rounded-lg <?= $isActive('/my-portfolio') ? 'bg-white/20' : 'bg-white/5 group-hover:bg-white/10' ?> flex items-center justify-center transition">
                        <i class="fas fa-briefcase"></i>
                    </div>
                    <span class="ml-3 font-medium">Portfolio</span>
                </a>
            </div>
        </div>

        <!-- QUICK ACTIONS -->
        <div class="pt-4 border-t border-white/10">
            <div class="space-y-1">
                <!-- Help & Support -->
                <a href="<?= url('/support') ?>" 
                   class="sidebar-link flex items-center px-4 py-3 rounded-xl transition group text-gray-400 hover:bg-white/5 hover:text-white">
                    <div class="w-9 h-9 rounded-lg bg-white/5 group-hover:bg-white/10 flex items-center justify-center transition">
                        <i class="fas fa-question-circle"></i>
                    </div>
                    <span class="ml-3 font-medium">Help Center</span>
                </a>

                <!-- Back to Site -->
                <a href="<?= url('/') ?>" 
                   class="sidebar-link flex items-center px-4 py-3 rounded-xl transition group text-gray-400 hover:bg-white/5 hover:text-white">
                    <div class="w-9 h-9 rounded-lg bg-white/5 group-hover:bg-white/10 flex items-center justify-center transition">
                        <i class="fas fa-external-link-alt"></i>
                    </div>
                    <span class="ml-3 font-medium">Back to Website</span>
                </a>
            </div>
        </div>
    </nav>

    <!-- User Profile (bottom) -->
    <div class="border-t border-white/10 p-4 flex-shrink-0 bg-black/20">
        <div class="flex items-center" x-data="{ profileOpen: false }">
            <div class="relative">
                <img src="<?= $user['avatar'] ?? asset('images/default-avatar.png') ?>" 
                     alt="<?= htmlspecialchars($user['first_name'] ?? 'User') ?>"
                     class="w-11 h-11 rounded-xl object-cover ring-2 ring-white/20">
                <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-slate-800 rounded-full"></span>
            </div>
            <div class="ml-3 flex-1 min-w-0">
                <p class="text-sm font-semibold text-white truncate">
                    <?= htmlspecialchars(($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? '')) ?>
                </p>
                <p class="text-xs text-gray-400 flex items-center">
                    <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1.5"></span>
                    Online
                </p>
            </div>
            <div class="relative">
                <button @click="profileOpen = !profileOpen" class="w-8 h-8 rounded-lg bg-white/10 hover:bg-white/20 text-gray-400 hover:text-white flex items-center justify-center transition">
                    <i class="fas fa-chevron-up text-xs" :class="{ 'rotate-180': profileOpen }"></i>
                </button>
                
                <!-- Profile Dropdown -->
                <div x-show="profileOpen" 
                     x-cloak
                     @click.away="profileOpen = false"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 translate-y-2"
                     class="absolute bottom-full right-0 mb-2 w-56 bg-slate-800 rounded-xl shadow-2xl border border-white/10 py-2 overflow-hidden">
                    <div class="px-4 py-3 border-b border-white/10">
                        <p class="text-xs text-gray-400">Signed in as</p>
                        <p class="text-sm font-semibold text-white truncate"><?= htmlspecialchars($user['email'] ?? '') ?></p>
                    </div>
                    <a href="<?= url('/profile') ?>" class="flex items-center px-4 py-2.5 text-sm text-gray-300 hover:bg-white/10 hover:text-white transition">
                        <i class="fas fa-user w-5 mr-3 text-gray-400"></i> My Profile
                    </a>
                    <a href="<?= url('/settings') ?>" class="flex items-center px-4 py-2.5 text-sm text-gray-300 hover:bg-white/10 hover:text-white transition">
                        <i class="fas fa-cog w-5 mr-3 text-gray-400"></i> Settings
                    </a>
                    <a href="<?= url('/notifications') ?>" class="flex items-center px-4 py-2.5 text-sm text-gray-300 hover:bg-white/10 hover:text-white transition">
                        <i class="fas fa-bell w-5 mr-3 text-gray-400"></i> Notifications
                    </a>
                    <div class="border-t border-white/10 my-1"></div>
                    <a href="<?= url('/logout') ?>" class="flex items-center px-4 py-2.5 text-sm text-red-400 hover:bg-red-500/10 hover:text-red-300 transition">
                        <i class="fas fa-sign-out-alt w-5 mr-3"></i> Sign Out
                    </a>
                </div>
            </div>
        </div>
    </div>
</aside>
