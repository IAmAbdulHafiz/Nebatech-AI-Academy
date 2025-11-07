<!-- Top Banner (Promotional) -->
<div class="bg-secondary text-white py-2 text-center text-sm">
    <p>🎉 <strong>New Year Special:</strong> All premium courses FREE until Dec 31st! <a href="<?= url('/register') ?>" class="underline font-semibold ml-2">Join Now</a></p>
</div>

<!-- Sticky Header -->
<header class="bg-primary text-white shadow-lg sticky top-0 z-50" x-data="{ 
    mobileMenuOpen: false, 
    coursesDropdown: false, 
    searchOpen: false,
    userDropdown: false,
    isLoggedIn: false,
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
                    <span class="text-secondary">AI</span>
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
                
                <!-- Courses Mega Menu -->
                <div class="relative" @mouseenter="coursesDropdown = true" @mouseleave="coursesDropdown = false">
                    <button class="hover:text-secondary transition-colors font-semibold flex items-center">
                        Courses
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    
                    <!-- Dropdown Mega Menu -->
                    <div x-show="coursesDropdown" 
                         x-transition
                         class="absolute left-0 mt-2 w-96 bg-white text-gray-800 rounded-lg shadow-2xl p-6 z-50">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <h4 class="font-bold text-primary mb-3">Development</h4>
                                <a href="<?= url('/courses/frontend') ?>" class="block py-2 hover:text-secondary">Frontend Development</a>
                                <a href="<?= url('/courses/backend') ?>" class="block py-2 hover:text-secondary">Backend Development</a>
                                <a href="<?= url('/courses/fullstack') ?>" class="block py-2 hover:text-secondary">Full Stack</a>
                                <a href="<?= url('/courses/mobile') ?>" class="block py-2 hover:text-secondary">Mobile Development</a>
                            </div>
                            <div>
                                <h4 class="font-bold text-primary mb-3">Advanced</h4>
                                <a href="<?= url('/courses/ai') ?>" class="block py-2 hover:text-secondary">AI & Machine Learning</a>
                                <a href="<?= url('/courses/data-science') ?>" class="block py-2 hover:text-secondary">Data Science</a>
                                <a href="<?= url('/courses/cybersecurity') ?>" class="block py-2 hover:text-secondary">Cybersecurity</a>
                                <a href="<?= url('/courses/cloud') ?>" class="block py-2 hover:text-secondary">Cloud Computing</a>
                            </div>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <a href="<?= url('/courses') ?>" class="text-primary font-semibold hover:text-blue-700">View All Courses →</a>
                        </div>
                    </div>
                </div>

                <a href="<?= url('/about') ?>" class="hover:text-secondary transition-colors font-semibold">About</a>
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
                <button x-show="isLoggedIn" class="hidden md:block relative text-white hover:text-secondary">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">3</span>
                </button>

                <!-- User Dropdown (when logged in) -->
                <div x-show="isLoggedIn" class="hidden md:block relative" @mouseenter="userDropdown = true" @mouseleave="userDropdown = false">
                    <button class="flex items-center space-x-2">
                        <div class="w-8 h-8 bg-secondary rounded-full flex items-center justify-center font-bold">
                            JD
                        </div>
                    </button>
                    <div x-show="userDropdown" 
                         x-transition
                         class="absolute right-0 mt-2 w-56 bg-white text-gray-800 rounded-lg shadow-2xl py-2 z-50">
                        <div class="px-4 py-2 border-b border-gray-200">
                            <p class="font-semibold">John Doe</p>
                            <p class="text-sm text-gray-500">john@example.com</p>
                        </div>
                        <a href="<?= url('/dashboard') ?>" class="block px-4 py-2 hover:bg-gray-100">Dashboard</a>
                        <a href="<?= url('/my-courses') ?>" class="block px-4 py-2 hover:bg-gray-100">My Courses</a>
                        <a href="<?= url('/profile') ?>" class="block px-4 py-2 hover:bg-gray-100">Profile Settings</a>
                        <a href="<?= url('/certificates') ?>" class="block px-4 py-2 hover:bg-gray-100">Certificates</a>
                        <div class="border-t border-gray-200 mt-2"></div>
                        <a href="<?= url('/logout') ?>" class="block px-4 py-2 hover:bg-gray-100 text-red-600">Logout</a>
                    </div>
                </div>

                <!-- Auth Buttons (when not logged in) -->
                <div x-show="!isLoggedIn" class="hidden md:flex items-center space-x-3">
                    <a href="<?= url('/login') ?>" class="text-white hover:text-secondary font-semibold transition-colors">
                        Login
                    </a>
                    <a href="<?= url('/register') ?>" class="bg-secondary hover:bg-orange-600 text-white font-bold px-5 py-2 rounded-lg transition-colors">
                        Sign Up Free
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden text-white">
                    <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg x-show="mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Search Bar -->
        <div x-show="searchOpen" x-collapse class="lg:hidden mt-4">
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
        <div x-show="mobileMenuOpen" x-collapse class="lg:hidden mt-4 pb-4 border-t border-blue-600 pt-4">
            <div class="space-y-2">
                <a href="<?= url('/') ?>" class="block py-2 hover:text-secondary transition-colors font-semibold">Home</a>
                
                <!-- Mobile Courses Submenu -->
                <div x-data="{ open: false }">
                    <button @click="open = !open" class="w-full text-left py-2 hover:text-secondary transition-colors font-semibold flex justify-between items-center">
                        Courses
                        <svg class="w-4 h-4" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open" x-collapse class="pl-4 space-y-2 mt-2">
                        <a href="<?= url('/courses/frontend') ?>" class="block py-1 text-gray-300 hover:text-secondary">Frontend Development</a>
                        <a href="<?= url('/courses/backend') ?>" class="block py-1 text-gray-300 hover:text-secondary">Backend Development</a>
                        <a href="<?= url('/courses/ai') ?>" class="block py-1 text-gray-300 hover:text-secondary">AI & Machine Learning</a>
                        <a href="<?= url('/courses') ?>" class="block py-1 text-secondary font-semibold">View All →</a>
                    </div>
                </div>

                <a href="<?= url('/about') ?>" class="block py-2 hover:text-secondary transition-colors font-semibold">About</a>
                <a href="<?= url('/blog') ?>" class="block py-2 hover:text-secondary transition-colors font-semibold">Blog</a>
                <a href="<?= url('/contact') ?>" class="block py-2 hover:text-secondary transition-colors font-semibold">Contact</a>
                <a href="<?= url('/support') ?>" class="block py-2 hover:text-secondary transition-colors font-semibold">Help & Support</a>
                
                <div class="border-t border-blue-600 pt-4 mt-4 space-y-2">
                    <a href="<?= url('/login') ?>" class="block py-2 hover:text-secondary transition-colors font-semibold">Login</a>
                    <a href="<?= url('/register') ?>" class="block bg-secondary hover:bg-orange-600 text-white font-bold px-4 py-3 rounded-lg text-center transition-colors">
                        Sign Up Free
                    </a>
                </div>
            </div>
        </div>
    </nav>
</header>
