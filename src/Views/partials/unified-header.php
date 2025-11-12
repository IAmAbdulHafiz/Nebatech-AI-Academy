<?php
// Unified Header Component - Context-aware navigation
// Detects current section and user context to show appropriate navigation

use Nebatech\Core\Database;

// Get current section and user context
$currentPath = $_SERVER['REQUEST_URI'] ?? '/';
$currentSection = 'corporate'; // Default to corporate

// Determine current section based on URL
if (strpos($currentPath, '/dashboard') !== false || 
    strpos($currentPath, '/my-') !== false || 
    strpos($currentPath, '/facilitator') !== false || 
    strpos($currentPath, '/admin') !== false ||
    strpos($currentPath, '/programmes') !== false ||
    strpos($currentPath, '/courses') !== false) {
    $currentSection = 'academy';
}

// Check if user is logged in
$isLoggedIn = isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
$userName = $_SESSION['user_name'] ?? 'User';
$userEmail = $_SESSION['user_email'] ?? '';
$userInitials = '';
if ($isLoggedIn) {
    $nameParts = explode(' ', $userName);
    $userInitials = strtoupper(substr($nameParts[0], 0, 1) . (isset($nameParts[1]) ? substr($nameParts[1], 0, 1) : ''));
}

// Determine user context
$userContext = 'visitor';
if ($isLoggedIn) {
    if (is_student()) $userContext = 'student';
    elseif (is_facilitator()) $userContext = 'facilitator';
    elseif (is_admin()) $userContext = 'admin';
}

// Fetch services for dropdown
$db = Database::connect();
$servicesStmt = $db->prepare("SELECT title, slug FROM services WHERE status = 'active' ORDER BY order_index ASC LIMIT 6");
$servicesStmt->execute();
$headerServices = $servicesStmt->fetchAll(\PDO::FETCH_ASSOC);

// Fetch courses for dropdown
$coursesStmt = $db->prepare("SELECT title, slug FROM courses WHERE status = 'published' ORDER BY created_at DESC LIMIT 6");
$coursesStmt->execute();
$headerCourses = $coursesStmt->fetchAll(\PDO::FETCH_ASSOC);
?>

<!-- Top Banner (Promotional) -->
<div class="bg-secondary text-white py-2 text-center text-sm">
    <p>🎉 <strong>New Year Special:</strong> All premium courses FREE until Dec 31st! <a href="<?= url('/register') ?>" class="underline font-semibold ml-2">Join Now</a></p>
</div>

<!-- Unified Header -->
<header class="bg-primary text-white shadow-lg sticky top-0 z-50" x-data="{ 
    mobileMenuOpen: false, 
    coursesDropdown: false, 
    servicesDropdown: false,
    searchOpen: false,
    userDropdown: false,
    isLoggedIn: <?= $isLoggedIn ? 'true' : 'false' ?>,
    currentSection: '<?= $currentSection ?>',
    userContext: '<?= $userContext ?>',
    scrolled: false
}" @scroll.window="scrolled = window.pageYOffset > 20">
    <nav class="container mx-auto px-6 py-4" :class="scrolled ? 'py-2' : 'py-4'" style="transition: padding 0.3s;">
        <div class="flex items-center justify-between gap-4">
            <!-- Logo -->
            <a href="<?= url('/') ?>" class="flex items-center space-x-2 flex-shrink-0">
                <div class="w-10 h-10 bg-secondary rounded-lg flex items-center justify-center font-bold text-xl">
                    N
                </div>
                <div class="text-xl md:text-2xl font-bold hidden sm:block">
                    <span class="text-white">Nebatech</span>
                    <?php if ($currentSection === 'academy'): ?>
                        <div class="text-xs text-gray-300 -mt-1">AI Academy</div>
                    <?php endif; ?>
                </div>
            </a>

            <!-- Search Bar (Desktop) -->
            <div class="hidden lg:flex flex-1 max-w-md mx-4">
                <form method="GET" action="<?= url('/search') ?>" class="relative w-full">
                    <input type="text" 
                           name="q"
                           placeholder="<?= $currentSection === 'academy' ? 'Search courses, topics, instructors...' : 'Search services, solutions...' ?>" 
                           class="w-full px-4 py-2 pl-10 rounded-lg text-gray-800 focus:outline-none focus:ring-2 focus:ring-secondary"
                           autocomplete="off">
                    <button type="submit" class="absolute left-3 top-2.5 text-gray-400 hover:text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </button>
                </form>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden lg:flex items-center space-x-6">
                <a href="<?= url('/') ?>" class="hover:text-secondary transition-colors font-semibold">Home</a>
                <a href="<?= url('/about') ?>" class="hover:text-secondary transition-colors font-semibold">About</a>
                
                <!-- Services Dropdown -->
                <div class="relative" @mouseenter="servicesDropdown = true" @mouseleave="servicesDropdown = false">
                    <button class="hover:text-secondary transition-colors font-semibold flex items-center">
                        Services
                        <svg class="w-4 h-4 ml-1 transform transition-transform duration-200" 
                             :class="servicesDropdown ? 'rotate-180' : ''" 
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="servicesDropdown" 
                         x-cloak
                         x-transition
                         class="absolute left-0 mt-2 w-96 bg-white text-gray-800 rounded-lg shadow-2xl py-4 z-50">
                        <div class="px-6 py-3 border-b border-gray-200">
                            <h3 class="font-bold text-primary text-lg">Our IT Services</h3>
                            <p class="text-sm text-gray-600">Professional solutions for your business</p>
                        </div>
                        <div class="p-4">
                            <?php if (!empty($headerServices)): ?>
                                <div class="grid grid-cols-2 gap-2">
                                    <?php foreach ($headerServices as $service): ?>
                                        <a href="<?= url('/services/' . $service['slug']) ?>" 
                                           class="block px-3 py-2 hover:bg-gray-100 rounded-md transition-colors">
                                            <span class="font-medium text-sm"><?= htmlspecialchars($service['title']) ?></span>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                                <div class="border-t border-gray-200 mt-4 pt-3">
                                    <a href="<?= url('/services') ?>" 
                                       class="block text-center px-4 py-2 bg-primary text-white rounded-md hover:bg-blue-700 transition-colors font-semibold">
                                        View All Services →
                                    </a>
                                </div>
                            <?php else: ?>
                                <div class="px-4 py-2 text-gray-500 text-center">
                                    <p>Services coming soon...</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <!-- Training Programs Dropdown -->
                <div class="relative" @mouseenter="coursesDropdown = true" @mouseleave="coursesDropdown = false">
                    <button class="hover:text-secondary transition-colors font-semibold flex items-center">
                        Training Programs
                        <svg class="w-4 h-4 ml-1 transform transition-transform duration-200" 
                             :class="coursesDropdown ? 'rotate-180' : ''" 
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="coursesDropdown" 
                         x-cloak
                         x-transition
                         class="absolute left-0 mt-2 w-96 bg-white text-gray-800 rounded-lg shadow-2xl py-4 z-50">
                        <div class="px-6 py-3 border-b border-gray-200">
                            <h3 class="font-bold text-primary text-lg">Training Programs</h3>
                            <p class="text-sm text-gray-600">Learn new skills with expert instructors</p>
                        </div>
                        <div class="p-4">
                            <?php if (!empty($headerCourses)): ?>
                                <div class="grid grid-cols-2 gap-2">
                                    <?php foreach ($headerCourses as $course): ?>
                                        <a href="<?= url('/programmes/' . $course['slug']) ?>" 
                                           class="block px-3 py-2 hover:bg-gray-100 rounded-md transition-colors">
                                            <span class="font-medium text-sm"><?= htmlspecialchars($course['title']) ?></span>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                                <div class="border-t border-gray-200 mt-4 pt-3">
                                    <a href="<?= url('/programmes') ?>" 
                                       class="block text-center px-4 py-2 bg-primary text-white rounded-md hover:bg-blue-700 transition-colors font-semibold">
                                        View All Programs →
                                    </a>
                                </div>
                            <?php else: ?>
                                <div class="px-4 py-2 text-gray-500 text-center">
                                    <p>Training programs coming soon...</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <a href="<?= url('/projects') ?>" class="hover:text-secondary transition-colors font-semibold">Projects</a>
                <a href="<?= url('/blog') ?>" class="hover:text-secondary transition-colors font-semibold">Blog</a>
                <a href="<?= url('/contact') ?>" class="hover:text-secondary transition-colors font-semibold">Contact</a>
            </div>

            <!-- Right Side Icons & Buttons -->
            <div class="flex items-center space-x-3">
                <!-- Context-aware CTA -->
                <?php if (!$isLoggedIn): ?>
                    <div class="hidden md:flex items-center space-x-3">
                        <a href="<?= url('/login') ?>" class="text-white hover:text-secondary font-semibold transition-colors">
                            Login
                        </a>
                        <a href="<?= url('/register') ?>" class="bg-secondary hover:bg-orange-600 text-white font-bold px-5 py-2 rounded-lg transition-colors">
                            <?= $currentSection === 'academy' ? 'Start Learning' : 'Get Started' ?>
                        </a>
                    </div>
                <?php else: ?>
                    <!-- User Area -->
                    <div class="hidden md:flex items-center space-x-3">
                        <?php if ($currentSection === 'corporate' && $userContext === 'student'): ?>
                            <a href="<?= url('/dashboard') ?>" class="text-secondary hover:text-orange-300 font-semibold">
                                My Academy
                            </a>
                        <?php elseif ($currentSection === 'academy'): ?>
                            <a href="<?= url('/services') ?>" class="text-secondary hover:text-orange-300 font-semibold">
                                Our Services
                            </a>
                        <?php endif; ?>
                        
                        <!-- User Dropdown -->
                        <div class="relative" @mouseenter="userDropdown = true" @mouseleave="userDropdown = false">
                            <button class="flex items-center space-x-2">
                                <div class="w-8 h-8 bg-secondary rounded-full flex items-center justify-center font-bold">
                                    <?= $userInitials ?>
                                </div>
                            </button>
                            <div x-show="userDropdown" 
                                 x-cloak
                                 x-transition
                                 class="absolute right-0 mt-2 w-56 bg-white text-gray-800 rounded-lg shadow-2xl py-2 z-50">
                                <div class="px-4 py-2 border-b border-gray-200">
                                    <p class="font-semibold truncate"><?= htmlspecialchars($userName) ?></p>
                                    <p class="text-sm text-gray-500 truncate"><?= htmlspecialchars($userEmail) ?></p>
                                </div>
                                
                                <?php if ($userContext === 'student'): ?>
                                    <a href="<?= url('/dashboard') ?>" class="block px-4 py-2 hover:bg-gray-100">Dashboard</a>
                                    <a href="<?= url('/my-courses') ?>" class="block px-4 py-2 hover:bg-gray-100">My Courses</a>
                                    <div class="border-t border-gray-200 mt-2 pt-2">
                                        <a href="<?= url('/services') ?>" class="block px-4 py-2 hover:bg-gray-100 text-blue-600">
                                            <i class="fas fa-briefcase mr-2"></i>Need Professional Services?
                                        </a>
                                    </div>
                                <?php elseif ($userContext === 'facilitator'): ?>
                                    <a href="<?= url('/facilitator/dashboard') ?>" class="block px-4 py-2 hover:bg-gray-100">Dashboard</a>
                                    <a href="<?= url('/facilitator/courses/create') ?>" class="block px-4 py-2 hover:bg-gray-100">My Courses</a>
                                <?php elseif ($userContext === 'admin'): ?>
                                    <a href="<?= url('/admin/dashboard') ?>" class="block px-4 py-2 hover:bg-gray-100">Admin Dashboard</a>
                                    <a href="<?= url('/facilitator/dashboard') ?>" class="block px-4 py-2 hover:bg-gray-100">Facilitator View</a>
                                <?php endif; ?>
                                
                                <a href="<?= url('/profile') ?>" class="block px-4 py-2 hover:bg-gray-100">Profile Settings</a>
                                <div class="border-t border-gray-200 mt-2"></div>
                                <a href="<?= url('/logout') ?>" class="block px-4 py-2 hover:bg-gray-100 text-red-600">Logout</a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Mobile Menu Button -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden text-white">
                    <svg x-show="!mobileMenuOpen" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg x-show="mobileMenuOpen" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileMenuOpen" x-cloak x-collapse class="lg:hidden mt-4 pb-4 border-t border-blue-600 pt-4">
            <div class="space-y-2">
                <a href="<?= url('/') ?>" class="block py-2 hover:text-secondary transition-colors font-semibold">Home</a>
                <a href="<?= url('/about') ?>" class="block py-2 hover:text-secondary transition-colors font-semibold">About</a>
                <a href="<?= url('/services') ?>" class="block py-2 hover:text-secondary transition-colors font-semibold">Services</a>
                <a href="<?= url('/programmes') ?>" class="block py-2 hover:text-secondary transition-colors font-semibold">Training Programs</a>
                <a href="<?= url('/projects') ?>" class="block py-2 hover:text-secondary transition-colors font-semibold">Projects</a>
                <a href="<?= url('/blog') ?>" class="block py-2 hover:text-secondary transition-colors font-semibold">Blog</a>
                <a href="<?= url('/contact') ?>" class="block py-2 hover:text-secondary transition-colors font-semibold">Contact</a>
                
                <?php if (!$isLoggedIn): ?>
                    <div class="border-t border-blue-600 pt-4 mt-4 space-y-2">
                        <a href="<?= url('/login') ?>" class="block py-2 hover:text-secondary transition-colors font-semibold">Login</a>
                        <a href="<?= url('/register') ?>" class="block bg-secondary hover:bg-orange-600 text-white font-bold px-4 py-3 rounded-lg text-center transition-colors">
                            <?= $currentSection === 'academy' ? 'Start Learning' : 'Get Started' ?>
                        </a>
                    </div>
                <?php else: ?>
                    <div class="border-t border-blue-600 pt-4 mt-4 space-y-2">
                        <div class="px-4 py-2 bg-blue-700 rounded-lg mb-2">
                            <p class="font-semibold truncate"><?= htmlspecialchars($userName) ?></p>
                            <p class="text-sm text-gray-300 break-all"><?= htmlspecialchars($userEmail) ?></p>
                        </div>
                        
                        <?php if ($userContext === 'student'): ?>
                            <a href="<?= url('/dashboard') ?>" class="block py-2 hover:text-secondary transition-colors font-semibold">Dashboard</a>
                            <a href="<?= url('/my-courses') ?>" class="block py-2 hover:text-secondary transition-colors font-semibold">My Courses</a>
                            <a href="<?= url('/services') ?>" class="block py-2 hover:text-secondary transition-colors font-semibold text-secondary">Need Professional Services?</a>
                        <?php endif; ?>
                        
                        <a href="<?= url('/profile') ?>" class="block py-2 hover:text-secondary transition-colors font-semibold">Profile Settings</a>
                        <a href="<?= url('/logout') ?>" class="block py-2 hover:text-secondary transition-colors font-semibold text-red-400">Logout</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </nav>
</header>
