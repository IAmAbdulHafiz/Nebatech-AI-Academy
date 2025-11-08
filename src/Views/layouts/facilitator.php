<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Facilitator Studio - Nebatech AI Academy' ?></title>
    
    <!-- Tailwind CSS -->
    <link href="<?= asset('css/main.css') ?>" rel="stylesheet">
    
    <!-- Alpine.js Collapse Plugin -->
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <!-- Alpine.js Core -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50" x-data="{ sidebarOpen: false }">
    
    <!-- Facilitator Sidebar -->
    <aside class="fixed inset-y-0 left-0 z-50 w-64 bg-gradient-to-b from-purple-900 to-purple-800 text-white transform transition-transform duration-300 lg:translate-x-0"
           :class="{ '-translate-x-full': !sidebarOpen, 'translate-x-0': sidebarOpen }">
        
        <!-- Logo -->
        <div class="flex items-center justify-between h-16 px-6 border-b border-purple-700">
            <a href="<?= url('/facilitator/dashboard') ?>" class="flex items-center">
                <i class="fas fa-chalkboard-teacher text-2xl text-purple-300"></i>
                <span class="ml-3 text-lg font-bold">Facilitator Studio</span>
            </a>
            <button @click="sidebarOpen = false" class="lg:hidden text-purple-300 hover:text-white">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
            <!-- Dashboard -->
            <a href="<?= url('/facilitator/dashboard') ?>" 
               class="flex items-center px-4 py-3 text-purple-100 rounded-lg hover:bg-purple-700 transition group">
                <i class="fas fa-home text-lg w-5"></i>
                <span class="ml-3 font-medium">Dashboard</span>
            </a>

            <!-- My Courses -->
            <a href="<?= url('/facilitator/courses') ?>" 
               class="flex items-center px-4 py-3 text-purple-100 rounded-lg hover:bg-purple-700 transition group">
                <i class="fas fa-book text-lg w-5"></i>
                <span class="ml-3 font-medium">My Courses</span>
            </a>

            <!-- Create Course -->
            <a href="<?= url('/facilitator/courses/create') ?>" 
               class="flex items-center px-4 py-3 text-purple-100 rounded-lg hover:bg-purple-700 transition group">
                <i class="fas fa-plus-circle text-lg w-5"></i>
                <span class="ml-3 font-medium">Create Course</span>
            </a>

            <!-- Student Submissions -->
            <a href="<?= url('/facilitator/submissions') ?>" 
               class="flex items-center px-4 py-3 text-purple-100 rounded-lg hover:bg-purple-700 transition group">
                <i class="fas fa-file-code text-lg w-5"></i>
                <span class="ml-3 font-medium">Submissions</span>
                <?php if (!empty($pendingSubmissions)): ?>
                <span class="ml-auto bg-yellow-500 text-purple-900 text-xs font-bold px-2 py-1 rounded-full">
                    <?= $pendingSubmissions ?>
                </span>
                <?php endif; ?>
            </a>

            <!-- Grading -->
            <a href="<?= url('/facilitator/grading') ?>" 
               class="flex items-center px-4 py-3 text-purple-100 rounded-lg hover:bg-purple-700 transition group">
                <i class="fas fa-check-circle text-lg w-5"></i>
                <span class="ml-3 font-medium">Grading</span>
            </a>

            <!-- Students -->
            <a href="<?= url('/facilitator/students') ?>" 
               class="flex items-center px-4 py-3 text-purple-100 rounded-lg hover:bg-purple-700 transition group">
                <i class="fas fa-users text-lg w-5"></i>
                <span class="ml-3 font-medium">My Students</span>
            </a>

            <!-- AI Content Generator -->
            <a href="<?= url('/facilitator/ai-generator') ?>" 
               class="flex items-center px-4 py-3 text-purple-100 rounded-lg hover:bg-purple-700 transition group">
                <i class="fas fa-robot text-lg w-5"></i>
                <span class="ml-3 font-medium">AI Generator</span>
            </a>

            <!-- Analytics -->
            <a href="<?= url('/facilitator/analytics') ?>" 
               class="flex items-center px-4 py-3 text-purple-100 rounded-lg hover:bg-purple-700 transition group">
                <i class="fas fa-chart-bar text-lg w-5"></i>
                <span class="ml-3 font-medium">Analytics</span>
            </a>

            <div class="border-t border-purple-700 my-4"></div>

            <!-- Resources -->
            <a href="<?= url('/facilitator/resources') ?>" 
               class="flex items-center px-4 py-3 text-purple-100 rounded-lg hover:bg-purple-700 transition group">
                <i class="fas fa-folder text-lg w-5"></i>
                <span class="ml-3 font-medium">Resources</span>
            </a>

            <!-- Messages -->
            <a href="<?= url('/facilitator/messages') ?>" 
               class="flex items-center px-4 py-3 text-purple-100 rounded-lg hover:bg-purple-700 transition group">
                <i class="fas fa-envelope text-lg w-5"></i>
                <span class="ml-3 font-medium">Messages</span>
                <?php if (!empty($unreadMessages)): ?>
                <span class="ml-auto bg-green-500 text-white text-xs font-bold px-2 py-1 rounded-full">
                    <?= $unreadMessages ?>
                </span>
                <?php endif; ?>
            </a>
        </nav>

        <!-- User Profile (bottom) -->
        <div class="border-t border-purple-700 p-4">
            <div class="flex items-center" x-data="{ profileOpen: false }">
                <img src="<?= $user['avatar'] ?? asset('images/default-avatar.png') ?>" 
                     alt="<?= htmlspecialchars($user['first_name'] ?? 'User') ?>"
                     class="w-10 h-10 rounded-full object-cover border-2 border-purple-600">
                <div class="ml-3 flex-1">
                    <p class="text-sm font-medium text-white">
                        <?= htmlspecialchars(($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? '')) ?>
                    </p>
                    <p class="text-xs text-purple-300">Facilitator</p>
                </div>
                <button @click="profileOpen = !profileOpen" class="text-purple-300 hover:text-white">
                    <i class="fas fa-ellipsis-v"></i>
                </button>
            </div>
            
            <!-- Profile Dropdown -->
            <div x-show="profileOpen" 
                 @click.away="profileOpen = false"
                 x-transition
                 class="mt-2 py-2 bg-purple-700 rounded-lg">
                <a href="<?= url('/profile') ?>" class="block px-4 py-2 text-sm text-purple-100 hover:bg-purple-600">
                    <i class="fas fa-user mr-2"></i> Profile Settings
                </a>
                <a href="<?= url('/logout') ?>" class="block px-4 py-2 text-sm text-red-300 hover:bg-purple-600">
                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                </a>
            </div>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="lg:pl-64 min-h-screen flex flex-col">
        <!-- Top Header -->
        <header class="sticky top-0 z-40 bg-white border-b border-gray-200 shadow-sm">
            <div class="flex items-center justify-between h-16 px-6">
                <!-- Mobile Menu Button -->
                <button @click="sidebarOpen = true" class="lg:hidden text-gray-500 hover:text-gray-700">
                    <i class="fas fa-bars text-xl"></i>
                </button>

                <!-- Page Title -->
                <h1 class="text-xl font-semibold text-gray-900 hidden lg:block">
                    <?= $pageTitle ?? 'Dashboard' ?>
                </h1>

                <!-- Right Side Actions -->
                <div class="flex items-center space-x-4">
                    <!-- Quick Actions -->
                    <a href="<?= url('/facilitator/courses/create') ?>" 
                       class="hidden md:flex items-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                        <i class="fas fa-plus mr-2"></i>
                        <span>New Course</span>
                    </a>

                    <!-- Notifications -->
                    <button class="relative text-gray-500 hover:text-gray-700">
                        <i class="fas fa-bell text-lg"></i>
                        <?php if (!empty($unreadNotifications)): ?>
                        <span class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center">
                            <?= min($unreadNotifications, 9) ?><?= $unreadNotifications > 9 ? '+' : '' ?>
                        </span>
                        <?php endif; ?>
                    </button>

                    <!-- User Avatar (Desktop) -->
                    <div class="hidden lg:block">
                        <img src="<?= $user['avatar'] ?? asset('images/default-avatar.png') ?>" 
                             alt="<?= htmlspecialchars($user['first_name'] ?? 'User') ?>"
                             class="w-8 h-8 rounded-full object-cover">
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1 p-6 bg-gray-50">
            <?php if (isset($_SESSION['success'])): ?>
            <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center justify-between">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-3"></i>
                    <span><?= htmlspecialchars($_SESSION['success']) ?></span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-green-600 hover:text-green-800">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <?php unset($_SESSION['success']); endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
            <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg flex items-center justify-between">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-3"></i>
                    <span><?= htmlspecialchars($_SESSION['error']) ?></span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-red-600 hover:text-red-800">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <?php unset($_SESSION['error']); endif; ?>

            <?= $content ?? '' ?>
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 py-6 px-6">
            <div class="flex flex-col md:flex-row justify-between items-center text-sm text-gray-600">
                <p>&copy; <?= date('Y') ?> Nebatech AI Academy - Facilitator Studio</p>
                <div class="flex space-x-6 mt-4 md:mt-0">
                    <a href="<?= url('/facilitator/help') ?>" class="hover:text-purple-600">Help & Guides</a>
                    <a href="<?= url('/facilitator/feedback') ?>" class="hover:text-purple-600">Give Feedback</a>
                    <a href="<?= url('/contact') ?>" class="hover:text-purple-600">Support</a>
                </div>
            </div>
        </footer>
    </div>

    <!-- Mobile Sidebar Overlay -->
    <div x-show="sidebarOpen" 
         @click="sidebarOpen = false"
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-gray-600 bg-opacity-75 lg:hidden z-40">
    </div>

</body>
</html>
