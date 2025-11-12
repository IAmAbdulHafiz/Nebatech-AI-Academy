<!-- Top Banner (Promotional) -->
<div class="bg-secondary text-white py-2 text-center text-sm">
    <p>🎉 <strong>New Year Special:</strong> All premium courses FREE until Dec 31st! <a href="<?= url('/register') ?>" class="underline font-semibold ml-2">Join Now</a></p>
</div>

<!-- Sticky Header -->
<?php
// Check if user is logged in
$isLoggedIn = isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
$userName = $_SESSION['user_name'] ?? 'User';
$userEmail = $_SESSION['user_email'] ?? '';
$userInitials = '';
if ($isLoggedIn) {
    $nameParts = explode(' ', $userName);
    $userInitials = strtoupper(substr($nameParts[0], 0, 1) . (isset($nameParts[1]) ? substr($nameParts[1], 0, 1) : ''));
}
?>
<header class="bg-primary text-white shadow-lg sticky top-0 z-50" x-data="{ 
    mobileMenuOpen: false, 
    coursesDropdown: false, 
    searchOpen: false,
    userDropdown: false,
    isLoggedIn: <?= $isLoggedIn ? 'true' : 'false' ?>,
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
                </div>
            </a>

            <!-- Search Bar (Desktop) -->
            <div class="hidden lg:flex flex-1 max-w-md mx-4">
                <div class="relative w-full">
                    <input type="text" 
                           placeholder="Search courses, topics, instructors..." 
                           class="w-full px-4 py-2 pl-10 rounded-lg text-gray-800 focus:outline-none focus:ring-2 focus:ring-secondary">
                    <svg class="w-5 h-5 absolute left-3 top-2.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden lg:flex items-center space-x-6">
                <a href="<?= url('/') ?>" class="hover:text-secondary transition-colors font-semibold">Home</a>
                <a href="<?= url('/about') ?>" class="hover:text-secondary transition-colors font-semibold">About</a>
                <a href="<?= url('/services') ?>" class="hover:text-secondary transition-colors font-semibold">Services</a>
                
                <!-- Programmes Mega Menu -->
                <div class="relative" @mouseenter="coursesDropdown = true" @mouseleave="coursesDropdown = false">
                    <button class="hover:text-secondary transition-colors font-semibold flex items-center">
                        Programmes
                        <svg class="w-4 h-4 ml-1 transform transition-transform duration-200" 
                             :class="coursesDropdown ? 'rotate-180' : ''" 
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                </div>

                <a href="<?= url('/projects') ?>" class="hover:text-secondary transition-colors font-semibold">Projects</a>
                <a href="<?= url('/blog') ?>" class="hover:text-secondary transition-colors font-semibold">Blog</a>
                <a href="<?= url('/contact') ?>" class="hover:text-secondary transition-colors font-semibold">Contact</a>
            </div>

            <!-- Right Side Icons & Buttons -->
            <div class="flex items-center space-x-3">
                <!-- Search Icon (Mobile/Tablet) -->
                <button @click="searchOpen = !searchOpen" class="lg:hidden text-white hover:text-secondary">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </button>

                <!-- Help/Support -->
                <a href="<?= url('/support') ?>" class="hidden md:block text-white hover:text-secondary" title="Help & Support">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </a>

                <!-- Notifications (when logged in) -->
                <button x-show="isLoggedIn" x-cloak class="hidden md:block relative text-white hover:text-secondary">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">3</span>
                </button>

                <!-- User Dropdown (when logged in) -->
                <div x-show="isLoggedIn" x-cloak class="hidden md:block relative" @mouseenter="userDropdown = true" @mouseleave="userDropdown = false">
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
                            <p class="text-sm text-gray-500 truncate" title="<?= htmlspecialchars($userEmail) ?>"><?= htmlspecialchars($userEmail) ?></p>
                            <?php if (is_facilitator() || is_admin()): ?>
                                <span class="inline-block mt-1 px-2 py-0.5 bg-green-100 text-green-800 text-xs font-semibold rounded">
                                    <?= ucfirst(user_role()) ?>
                                </span>
                            <?php endif; ?>
                        </div>
                        
                        <?php if (is_student()): ?>
                            <a href="<?= url('/dashboard') ?>" class="block px-4 py-2 hover:bg-gray-100">Dashboard</a>
                            <a href="<?= url('/my-courses') ?>" class="block px-4 py-2 hover:bg-gray-100">My Courses</a>
                            <a href="<?= url('/my-applications') ?>" class="block px-4 py-2 hover:bg-gray-100">My Applications</a>
                            <a href="<?= url('/my-portfolio') ?>" class="block px-4 py-2 hover:bg-gray-100">Portfolio</a>
                            <a href="<?= url('/my-certificates') ?>" class="block px-4 py-2 hover:bg-gray-100">Certificates</a>
                        <?php elseif (is_facilitator()): ?>
                            <a href="<?= url('/facilitator/dashboard') ?>" class="block px-4 py-2 hover:bg-gray-100">Dashboard</a>
                            <a href="<?= url('/facilitator/courses/create') ?>" class="block px-4 py-2 hover:bg-gray-100">My Courses</a>
                            <a href="<?= url('/facilitator/submissions') ?>" class="block px-4 py-2 hover:bg-gray-100">Submissions</a>
                            <a href="<?= url('/facilitator/students') ?>" class="block px-4 py-2 hover:bg-gray-100">Students</a>
                            <a href="<?= url('/my-certificates') ?>" class="block px-4 py-2 hover:bg-gray-100">Certificates</a>
                        <?php elseif (is_admin()): ?>
                            <a href="<?= url('/admin/dashboard') ?>" class="block px-4 py-2 hover:bg-gray-100">Admin Dashboard</a>
                            <a href="<?= url('/admin/applications') ?>" class="block px-4 py-2 hover:bg-gray-100">Applications</a>
                            <a href="<?= url('/admin/users') ?>" class="block px-4 py-2 hover:bg-gray-100">Users</a>
                            <a href="<?= url('/facilitator/dashboard') ?>" class="block px-4 py-2 hover:bg-gray-100">Facilitator View</a>
                        <?php endif; ?>
                        
                        <a href="<?= url('/profile') ?>" class="block px-4 py-2 hover:bg-gray-100">Profile Settings</a>
                        <div class="border-t border-gray-200 mt-2"></div>
                        <a href="<?= url('/logout') ?>" class="block px-4 py-2 hover:bg-gray-100 text-red-600">Logout</a>
                    </div>
                </div>

                <!-- Auth Buttons (when not logged in) -->
                <div x-show="!isLoggedIn" x-cloak class="hidden md:flex items-center space-x-3">
                    <a href="<?= url('/login') ?>" class="text-white hover:text-secondary font-semibold transition-colors">
                        Login
                    </a>
                    <a href="<?= url('/register') ?>" class="bg-secondary hover:bg-orange-600 text-white font-bold px-5 py-2 rounded-lg transition-colors">
                        Sign Up Free
                    </a>
                </div>

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

        <!-- Mobile Search Bar -->
        <div x-show="searchOpen" x-cloak x-collapse class="lg:hidden mt-4">
            <div class="relative">
                <input type="text" 
                       placeholder="Search courses..." 
                       class="w-full px-4 py-2 pl-10 rounded-lg text-gray-800 focus:outline-none focus:ring-2 focus:ring-secondary">
                <svg class="w-5 h-5 absolute left-3 top-2.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileMenuOpen" x-cloak x-collapse class="lg:hidden mt-4 pb-4 border-t border-blue-600 pt-4">
            <div class="space-y-2">
                <a href="<?= url('/') ?>" class="block py-2 hover:text-secondary transition-colors font-semibold">Home</a>
                <a href="<?= url('/about') ?>" class="block py-2 hover:text-secondary transition-colors font-semibold">About</a>
                <a href="<?= url('/services') ?>" class="block py-2 hover:text-secondary transition-colors font-semibold">Services</a>
                
                <!-- Mobile Programmes Submenu -->
                <div x-data="{ open: false }">
                    <button @click="open = !open" class="w-full text-left py-2 hover:text-secondary transition-colors font-semibold flex justify-between items-center">
                        Programmes
                        <svg class="w-4 h-4" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open" x-cloak x-collapse class="pl-4 space-y-2 mt-2">
                        <a href="<?= url('/programmes/category/ai-ml') ?>" class="block py-1 text-gray-300 hover:text-secondary">AI & Machine Learning</a>
                        <a href="<?= url('/programmes/category/development') ?>" class="block py-1 text-gray-300 hover:text-secondary">Software Development</a>
                        <a href="<?= url('/programmes/category/design') ?>" class="block py-1 text-gray-300 hover:text-secondary">Design & Multimedia</a>
                        <a href="<?= url('/programmes') ?>" class="block py-1 text-secondary font-semibold">View All →</a>
                    </div>
                </div>

                <a href="<?= url('/projects') ?>" class="block py-2 hover:text-secondary transition-colors font-semibold">Projects</a>
                <a href="<?= url('/blog') ?>" class="block py-2 hover:text-secondary transition-colors font-semibold">Blog</a>
                <a href="<?= url('/contact') ?>" class="block py-2 hover:text-secondary transition-colors font-semibold">Contact</a>
                <a href="<?= url('/faq') ?>" class="block py-2 hover:text-secondary transition-colors font-semibold">FAQs</a>
                
                <!-- Mobile Auth Buttons (when not logged in) -->
                <div x-show="!isLoggedIn" x-cloak class="border-t border-blue-600 pt-4 mt-4 space-y-2">
                    <a href="<?= url('/login') ?>" class="block py-2 hover:text-secondary transition-colors font-semibold">Login</a>
                    <a href="<?= url('/register') ?>" class="block bg-secondary hover:bg-orange-600 text-white font-bold px-4 py-3 rounded-lg text-center transition-colors">
                        Sign Up Free
                    </a>
                </div>
                
                <!-- Mobile User Menu (when logged in) -->
                <div x-show="isLoggedIn" x-cloak class="border-t border-blue-600 pt-4 mt-4 space-y-2">
                    <div class="px-4 py-2 bg-blue-700 rounded-lg mb-2">
                        <p class="font-semibold truncate"><?= htmlspecialchars($userName) ?></p>
                        <p class="text-sm text-gray-300 break-all"><?= htmlspecialchars($userEmail) ?></p>
                        <?php if (is_facilitator() || is_admin()): ?>
                            <span class="inline-block mt-1 px-2 py-0.5 bg-green-100 text-green-800 text-xs font-semibold rounded">
                                <?= ucfirst(user_role()) ?>
                            </span>
                        <?php endif; ?>
                    </div>
                    
                    <?php if (is_student()): ?>
                        <a href="<?= url('/dashboard') ?>" class="block py-2 hover:text-secondary transition-colors font-semibold">Dashboard</a>
                        <a href="<?= url('/my-courses') ?>" class="block py-2 hover:text-secondary transition-colors font-semibold">My Courses</a>
                        <a href="<?= url('/my-applications') ?>" class="block py-2 hover:text-secondary transition-colors font-semibold">My Applications</a>
                        <a href="<?= url('/my-portfolio') ?>" class="block py-2 hover:text-secondary transition-colors font-semibold">Portfolio</a>
                        <a href="<?= url('/my-certificates') ?>" class="block py-2 hover:text-secondary transition-colors font-semibold">Certificates</a>
                    <?php elseif (is_facilitator()): ?>
                        <a href="<?= url('/facilitator/dashboard') ?>" class="block py-2 hover:text-secondary transition-colors font-semibold">Dashboard</a>
                        <a href="<?= url('/facilitator/courses/create') ?>" class="block py-2 hover:text-secondary transition-colors font-semibold">My Courses</a>
                        <a href="<?= url('/facilitator/submissions') ?>" class="block py-2 hover:text-secondary transition-colors font-semibold">Submissions</a>
                        <a href="<?= url('/facilitator/students') ?>" class="block py-2 hover:text-secondary transition-colors font-semibold">Students</a>
                        <a href="<?= url('/my-certificates') ?>" class="block py-2 hover:text-secondary transition-colors font-semibold">Certificates</a>
                    <?php elseif (is_admin()): ?>
                        <a href="<?= url('/admin/dashboard') ?>" class="block py-2 hover:text-secondary transition-colors font-semibold">Admin Dashboard</a>
                        <a href="<?= url('/admin/applications') ?>" class="block py-2 hover:text-secondary transition-colors font-semibold">Applications</a>
                        <a href="<?= url('/admin/users') ?>" class="block py-2 hover:text-secondary transition-colors font-semibold">Users</a>
                        <a href="<?= url('/facilitator/dashboard') ?>" class="block py-2 hover:text-secondary transition-colors font-semibold">Facilitator View</a>
                    <?php endif; ?>
                    
                    <a href="<?= url('/profile') ?>" class="block py-2 hover:text-secondary transition-colors font-semibold">Profile Settings</a>
                    <a href="<?= url('/logout') ?>" class="block py-2 hover:text-secondary transition-colors font-semibold text-red-400">Logout</a>
                </div>
            </div>
        </div>
    </nav>
    
    <!-- Full-Width Programmes Mega Menu -->
    <div x-show="coursesDropdown" 
         x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 transform -translate-y-2"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 transform translate-y-0"
         x-transition:leave-end="opacity-0 transform -translate-y-2"
         class="absolute left-0 right-0 top-full bg-white shadow-2xl border-t border-gray-100 z-40"
         @mouseenter="coursesDropdown = true" 
         @mouseleave="coursesDropdown = false">
        
        <div class="container mx-auto px-6 py-8">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                
                <!-- Categories Section -->
                <div class="lg:col-span-1">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                        Browse by Category
                    </h3>
                    <div class="space-y-2">
                        <a href="<?= url('/programmes/category/ai-ml') ?>" 
                           class="flex items-center p-3 rounded-lg hover:bg-blue-50 hover:text-primary transition-colors group">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-primary group-hover:text-white transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                </svg>
                            </div>
                            <div>
                                <div class="font-semibold">AI & Machine Learning</div>
                                <div class="text-sm text-gray-500">5 programmes</div>
                            </div>
                        </a>
                        
                        <a href="<?= url('/programmes/category/development') ?>" 
                           class="flex items-center p-3 rounded-lg hover:bg-green-50 hover:text-green-700 transition-colors group">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-green-600 group-hover:text-white transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                                </svg>
                            </div>
                            <div>
                                <div class="font-semibold">Software Development</div>
                                <div class="text-sm text-gray-500">8 programmes</div>
                            </div>
                        </a>
                        
                        <a href="<?= url('/programmes/category/design') ?>" 
                           class="flex items-center p-3 rounded-lg hover:bg-purple-50 hover:text-purple-700 transition-colors group">
                            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-purple-600 group-hover:text-white transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM21 5a2 2 0 00-2-2h-4a2 2 0 00-2 2v12a4 4 0 004 4h4a2 2 0 002-2V5z"/>
                                </svg>
                            </div>
                            <div>
                                <div class="font-semibold">Design & Multimedia</div>
                                <div class="text-sm text-gray-500">6 programmes</div>
                            </div>
                        </a>
                        
                        <a href="<?= url('/programmes/category/business') ?>" 
                           class="flex items-center p-3 rounded-lg hover:bg-orange-50 hover:text-orange-700 transition-colors group">
                            <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-orange-600 group-hover:text-white transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V8a2 2 0 012-2V6"/>
                                </svg>
                            </div>
                            <div>
                                <div class="font-semibold">Business & Productivity</div>
                                <div class="text-sm text-gray-500">4 programmes</div>
                            </div>
                        </a>
                        
                        <a href="<?= url('/programmes/category/hardware') ?>" 
                           class="flex items-center p-3 rounded-lg hover:bg-red-50 hover:text-red-700 transition-colors group">
                            <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-red-600 group-hover:text-white transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <div class="font-semibold">Hardware & Repair</div>
                                <div class="text-sm text-gray-500">3 programmes</div>
                            </div>
                        </a>
                    </div>
                </div>
                
                <!-- Featured Programmes -->
                <div class="lg:col-span-2">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                        </svg>
                        Featured Programmes
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Sample Featured Programmes - These would be loaded from database -->
                        <a href="<?= url('/programmes/full-stack-web-development') ?>" 
                           class="block p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg hover:shadow-md transition-all duration-200 border border-blue-100 hover:border-blue-200">
                            <div class="flex items-start space-x-3">
                                <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-semibold text-gray-800 mb-1">Full-Stack Web Development</h4>
                                    <p class="text-sm text-gray-600 mb-2">Master both frontend and backend development with modern technologies</p>
                                    <div class="flex items-center justify-between text-xs">
                                        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full">20 weeks</span>
                                        <span class="text-primary font-semibold">GHS 3,500</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                        
                        <a href="<?= url('/programmes/ai-machine-learning') ?>" 
                           class="block p-4 bg-gradient-to-r from-purple-50 to-pink-50 rounded-lg hover:shadow-md transition-all duration-200 border border-purple-100 hover:border-purple-200">
                            <div class="flex items-start space-x-3">
                                <div class="w-12 h-12 bg-purple-500 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-semibold text-gray-800 mb-1">AI & Machine Learning</h4>
                                    <p class="text-sm text-gray-600 mb-2">Learn artificial intelligence and build intelligent applications</p>
                                    <div class="flex items-center justify-between text-xs">
                                        <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded-full">16 weeks</span>
                                        <span class="text-primary font-semibold">GHS 4,200</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                        
                        <a href="<?= url('/programmes/graphic-design') ?>" 
                           class="block p-4 bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg hover:shadow-md transition-all duration-200 border border-green-100 hover:border-green-200">
                            <div class="flex items-start space-x-3">
                                <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM21 5a2 2 0 00-2-2h-4a2 2 0 00-2 2v12a4 4 0 004 4h4a2 2 0 002-2V5z"/>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-semibold text-gray-800 mb-1">Graphic Design & Multimedia</h4>
                                    <p class="text-sm text-gray-600 mb-2">Create stunning visual content with professional design tools</p>
                                    <div class="flex items-center justify-between text-xs">
                                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full">12 weeks</span>
                                        <span class="text-primary font-semibold">GHS 3,200</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                        
                        <a href="<?= url('/programmes/digital-marketing') ?>" 
                           class="block p-4 bg-gradient-to-r from-orange-50 to-red-50 rounded-lg hover:shadow-md transition-all duration-200 border border-orange-100 hover:border-orange-200">
                            <div class="flex items-start space-x-3">
                                <div class="w-12 h-12 bg-orange-500 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-semibold text-gray-800 mb-1">Digital Marketing</h4>
                                    <p class="text-sm text-gray-600 mb-2">Master online marketing strategies and grow your business</p>
                                    <div class="flex items-center justify-between text-xs">
                                        <span class="bg-orange-100 text-orange-800 px-2 py-1 rounded-full">8 weeks</span>
                                        <span class="text-primary font-semibold">GHS 2,800</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                
                <!-- Quick Actions & Info -->
                <div class="lg:col-span-1">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        Quick Start
                    </h3>
                    
                    <div class="space-y-4">
                        <div class="bg-gradient-to-r from-secondary to-orange-600 rounded-lg p-4 text-white">
                            <h4 class="font-bold mb-2">🎉 Special Offer</h4>
                            <p class="text-sm mb-3">Get 50% off on all programmes this month!</p>
                            <a href="<?= url('/programmes') ?>" 
                               class="inline-block bg-white text-secondary px-4 py-2 rounded-lg text-sm font-semibold hover:bg-gray-100 transition-colors">
                                View All Programmes
                            </a>
                        </div>
                        
                        <div class="border border-gray-200 rounded-lg p-4">
                            <h4 class="font-semibold text-gray-800 mb-2">Need Help Choosing?</h4>
                            <p class="text-sm text-gray-600 mb-3">Our experts can help you find the perfect programme for your career goals.</p>
                            <a href="<?= url('/contact') ?>" 
                               class="inline-block bg-primary text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition-colors">
                                Get Free Consultation
                            </a>
                        </div>
                        
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h4 class="font-semibold text-gray-800 mb-2">Programme Benefits</h4>
                            <ul class="text-sm text-gray-600 space-y-1">
                                <li class="flex items-center">
                                    <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    Industry Certificates
                                </li>
                                <li class="flex items-center">
                                    <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    Hands-on Projects
                                </li>
                                <li class="flex items-center">
                                    <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    Expert Instructors
                                </li>
                                <li class="flex items-center">
                                    <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    Job Placement Support
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Bottom Action Bar -->
            <div class="mt-8 pt-6 border-t border-gray-200 flex items-center justify-between">
                <div class="flex items-center space-x-6 text-sm text-gray-600">
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-1 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                        </svg>
                        2,500+ Students
                    </span>
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-1 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        98% Success Rate
                    </span>
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-1 text-purple-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"/>
                        </svg>
                        26 Programmes
                    </span>
                </div>
                <a href="<?= url('/programmes') ?>" 
                   class="bg-primary text-white px-6 py-2 rounded-lg font-semibold hover:bg-blue-700 transition-colors flex items-center">
                    Browse All Programmes
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</header>
