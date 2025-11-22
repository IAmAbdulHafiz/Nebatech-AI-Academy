<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-primary via-blue-700 to-blue-900 text-white py-20 overflow-hidden mb-16">
    <!-- Digital Horizon Background -->
    <div class="absolute inset-0 overflow-hidden">
        <!-- Horizon Glow Effect -->
        <div class="absolute bottom-0 left-0 right-0 h-96 bg-gradient-to-t from-secondary/30 via-secondary/10 to-transparent"></div>
        <div class="absolute top-0 left-0 right-0 h-96 bg-gradient-to-b from-primary/50 via-transparent to-transparent"></div>
        
        <!-- Geometric Light Beams -->
        <div class="absolute inset-0">
            <div class="absolute top-0 left-1/4 w-1 h-full bg-gradient-to-b from-secondary/40 via-secondary/20 to-transparent transform -skew-x-12 animate-pulse" style="animation-duration: 3s;"></div>
            <div class="absolute top-0 right-1/3 w-1 h-full bg-gradient-to-b from-blue-400/30 via-blue-400/10 to-transparent transform skew-x-12 animate-pulse" style="animation-duration: 4s; animation-delay: 1s;"></div>
            <div class="absolute top-0 left-2/3 w-0.5 h-full bg-gradient-to-b from-secondary/30 via-transparent to-transparent transform -skew-x-6 animate-pulse" style="animation-duration: 5s; animation-delay: 2s;"></div>
        </div>
        
        <!-- Dynamic Glowing Orbs -->
        <div class="absolute top-20 left-10 w-96 h-96 bg-primary/40 rounded-full blur-3xl animate-pulse" style="animation-duration: 6s;"></div>
        <div class="absolute bottom-10 right-10 w-[500px] h-[500px] bg-secondary/30 rounded-full blur-3xl animate-pulse" style="animation-duration: 8s; animation-delay: 1s;"></div>
        <div class="absolute top-1/3 right-1/4 w-64 h-64 bg-primary/90/20 rounded-full blur-2xl animate-pulse" style="animation-duration: 7s; animation-delay: 2s;"></div>
        
        <!-- Floating Tech Icons -->
        <div class="absolute top-1/4 left-[8%] opacity-20 animate-float" style="animation-duration: 6s;">
            <i class="fas fa-code text-6xl text-white/80"></i>
        </div>
        <div class="absolute top-1/3 right-[10%] opacity-20 animate-float" style="animation-duration: 7s; animation-delay: 1s;">
            <i class="fas fa-laptop-code text-6xl text-white/70"></i>
        </div>
        <div class="absolute bottom-1/4 left-[15%] opacity-20 animate-float" style="animation-duration: 8s; animation-delay: 2s;">
            <i class="fas fa-graduation-cap text-6xl text-secondary"></i>
        </div>
        <div class="absolute bottom-1/3 right-[18%] opacity-20 animate-float" style="animation-duration: 6.5s; animation-delay: 0.5s;">
            <i class="fas fa-brain text-6xl text-white/80"></i>
        </div>
        <div class="absolute top-[45%] left-[25%] opacity-20 animate-float" style="animation-duration: 7.5s; animation-delay: 1.5s;">
            <i class="fas fa-server text-6xl text-white/70"></i>
        </div>
    </div>
    
    <!-- Content -->
    <div class="container mx-auto px-4 relative z-10">
        <div class="text-center max-w-4xl mx-auto">
            <div class="inline-block bg-primary/80/60 backdrop-blur-sm text-white/90 px-4 py-2 rounded-full text-sm font-semibold mb-6 border border-white/30/30">
                <i class="fas fa-book-open mr-2"></i>All Courses
            </div>
            <h1 class="text-5xl md:text-6xl font-bold mb-6">
                Explore Our Courses
            </h1>
            <p class="text-xl md:text-2xl text-white/90 mb-8 max-w-3xl mx-auto">
                Master in-demand tech skills with our comprehensive, AI-powered courses designed to get you job-ready.
            </p>
            
            <!-- Stats -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-12">
                <div class="backdrop-blur-sm bg-white/10 rounded-lg p-4 border border-white/30/20">
                    <div class="text-3xl font-bold">8</div>
                    <div class="text-white/70 text-sm">Course Tracks</div>
                </div>
                <div class="backdrop-blur-sm bg-white/10 rounded-lg p-4 border border-white/30/20">
                    <div class="text-3xl font-bold">50,000+</div>
                    <div class="text-white/70 text-sm">Students</div>
                </div>
                <div class="backdrop-blur-sm bg-white/10 rounded-lg p-4 border border-white/30/20">
                    <div class="text-3xl font-bold">200+</div>
                    <div class="text-white/70 text-sm">Modules</div>
                </div>
                <div class="backdrop-blur-sm bg-white/10 rounded-lg p-4 border border-white/30/20">
                    <div class="text-3xl font-bold">97%</div>
                    <div class="text-white/70 text-sm">Success Rate</div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="container mx-auto px-4 py-12">
    <!-- Course Categories -->
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
        <!-- Frontend Development -->
        <a href="<?= url('/courses/frontend') ?>" class="group bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden">
            <div class="bg-gradient-to-br from-primary/90 to-primary p-8">
                <div class="w-16 h-16 bg-white rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-white mb-2">Frontend Development</h3>
                <p class="text-white/90">Build stunning, responsive user interfaces</p>
            </div>
            <div class="p-6">
                <ul class="space-y-2 text-gray-600 dark:text-gray-400 text-sm mb-4">
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        15+ Modules
                    </li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        React, Vue, Angular
                    </li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        200+ Hours Content
                    </li>
                </ul>
                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-500 dark:text-gray-400">13-26 months</span>
                    <span class="text-primary font-semibold group-hover:translate-x-1 transition-transform">Learn More →</span>
                </div>
            </div>
        </a>

        <!-- Backend Development -->
        <a href="<?= url('/courses/backend') ?>" class="group bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden">
            <div class="bg-gradient-to-br from-green-500 to-green-600 p-8">
                <div class="w-16 h-16 bg-white rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-white mb-2">Backend Development</h3>
                <p class="text-green-100">Build powerful server-side applications</p>
            </div>
            <div class="p-6">
                <ul class="space-y-2 text-gray-600 dark:text-gray-400 text-sm mb-4">
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        18+ Modules
                    </li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        PHP, Node.js, Python
                    </li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        250+ Hours Content
                    </li>
                </ul>
                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-500 dark:text-gray-400">13-26 months</span>
                    <span class="text-primary font-semibold group-hover:translate-x-1 transition-transform">Learn More →</span>
                </div>
            </div>
        </a>

        <!-- Full Stack Development -->
        <a href="<?= url('/courses/fullstack') ?>" class="group bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden">
            <div class="bg-gradient-to-br from-purple-500 to-purple-600 p-8">
                <div class="w-16 h-16 bg-white rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-white mb-2">Full Stack Development</h3>
                <p class="text-purple-100">Master frontend & backend</p>
            </div>
            <div class="p-6">
                <ul class="space-y-2 text-gray-600 dark:text-gray-400 text-sm mb-4">
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        25+ Modules
                    </li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Frontend & Backend
                    </li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        350+ Hours Content
                    </li>
                </ul>
                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-500 dark:text-gray-400">13-26 months</span>
                    <span class="text-primary font-semibold group-hover:translate-x-1 transition-transform">Learn More →</span>
                </div>
            </div>
        </a>

        <!-- AI & Machine Learning -->
        <a href="<?= url('/courses/ai') ?>" class="group bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden">
            <div class="bg-gradient-to-br from-pink-500 to-pink-600 p-8">
                <div class="w-16 h-16 bg-white rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-white mb-2">AI & Machine Learning</h3>
                <p class="text-pink-100">Build intelligent applications</p>
            </div>
            <div class="p-6">
                <ul class="space-y-2 text-gray-600 dark:text-gray-400 text-sm mb-4">
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        30+ Modules
                    </li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Deep Learning & NLP
                    </li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        400+ Hours Content
                    </li>
                </ul>
                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-500 dark:text-gray-400">15-30 months</span>
                    <span class="text-primary font-semibold group-hover:translate-x-1 transition-transform">Learn More →</span>
                </div>
            </div>
        </a>

        <!-- Data Science -->
        <a href="<?= url('/courses/data-science') ?>" class="group bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden">
            <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 p-8">
                <div class="w-16 h-16 bg-white rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-white mb-2">Data Science</h3>
                <p class="text-indigo-100">Extract insights from data</p>
            </div>
            <div class="p-6">
                <ul class="space-y-2 text-gray-600 dark:text-gray-400 text-sm mb-4">
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        28+ Modules
                    </li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Python, Statistics, ML
                    </li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        380+ Hours Content
                    </li>
                </ul>
                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-500 dark:text-gray-400">13-26 months</span>
                    <span class="text-primary font-semibold group-hover:translate-x-1 transition-transform">Learn More →</span>
                </div>
            </div>
        </a>

        <!-- Mobile Development -->
        <a href="<?= url('/courses/mobile') ?>" class="group bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden">
            <div class="bg-gradient-to-br from-orange-500 to-orange-600 p-8">
                <div class="w-16 h-16 bg-white rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-white mb-2">Mobile Development</h3>
                <p class="text-orange-100">Build native iOS and Android apps</p>
            </div>
            <div class="p-6">
                <ul class="space-y-2 text-gray-600 dark:text-gray-400 text-sm mb-4">
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        20+ Modules
                    </li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        React Native, Flutter
                    </li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        280+ Hours Content
                    </li>
                </ul>
                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-500 dark:text-gray-400">4-12 months</span>
                    <span class="text-primary font-semibold group-hover:translate-x-1 transition-transform">Learn More →</span>
                </div>
            </div>
        </a>

        <!-- Cloud Computing -->
        <a href="<?= url('/courses/cloud') ?>" class="group bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden">
            <div class="bg-gradient-to-br from-cyan-500 to-cyan-600 p-8">
                <div class="w-16 h-16 bg-white rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-white mb-2">Cloud Computing</h3>
                <p class="text-cyan-100">Deploy and manage applications</p>
            </div>
            <div class="p-6">
                <ul class="space-y-2 text-gray-600 dark:text-gray-400 text-sm mb-4">
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        26+ Modules
                    </li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        AWS, Azure, GCP
                    </li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        360+ Hours Content
                    </li>
                </ul>
                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-500 dark:text-gray-400">12-24 months</span>
                    <span class="text-primary font-semibold group-hover:translate-x-1 transition-transform">Learn More →</span>
                </div>
            </div>
        </a>

        <!-- Cybersecurity -->
        <a href="<?= url('/courses/cybersecurity') ?>" class="group bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden">
            <div class="bg-gradient-to-br from-red-500 to-red-600 p-8">
                <div class="w-16 h-16 bg-white rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-white mb-2">Cybersecurity</h3>
                <p class="text-red-100">Protect systems and data</p>
            </div>
            <div class="p-6">
                <ul class="space-y-2 text-gray-600 dark:text-gray-400 text-sm mb-4">
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        22+ Modules
                    </li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Ethical Hacking & Defense
                    </li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        320+ Hours Content
                    </li>
                </ul>
                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-500 dark:text-gray-400">15-30 months</span>
                    <span class="text-primary font-semibold group-hover:translate-x-1 transition-transform">Learn More →</span>
                </div>
            </div>
        </a>
    </div>

    <!-- CTA Section -->
    <div class="mt-16 bg-gradient-to-r from-primary to-secondary rounded-2xl p-12 text-center text-white">
        <h2 class="text-3xl font-bold mb-4">Ready to Start Your Learning Journey?</h2>
        <p class="text-xl mb-8 opacity-90">Join thousands of students mastering tech skills with AI-powered learning</p>
        <div class="flex justify-center gap-4">
            <a href="<?= url('/register') ?>" class="bg-white text-primary px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">
                Get Started Free
            </a>
            <a href="<?= url('/contact') ?>" class="bg-transparent border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-primary transition">
                Contact Us
            </a>
        </div>
    </div>
</div>


