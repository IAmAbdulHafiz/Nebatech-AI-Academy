<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?> - Nebatech AI Academy</title>
    <link href="<?= asset('css/main.css') ?>" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50">
    <?php include __DIR__ . '/../partials/header.php'; ?>
    
    <!-- Hero Section -->
    <section class="bg-primary text-white py-24 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-10 left-10 w-72 h-72 bg-white rounded-full blur-3xl"></div>
            <div class="absolute bottom-10 right-10 w-96 h-96 bg-secondary rounded-full blur-3xl"></div>
        </div>
        <div class="container mx-auto px-6 relative z-10">
            <div class="max-w-4xl mx-auto text-center">
                <div class="inline-block bg-secondary/20 text-secondary px-4 py-2 rounded-full text-sm font-semibold mb-6">
                    🚀 100% Free to Start • No Credit Card Required
                </div>
                <h1 class="text-5xl md:text-6xl font-bold mb-6 leading-tight"><?= htmlspecialchars($title) ?></h1>
                <p class="text-xl md:text-2xl mb-4 text-gray-200"><?= htmlspecialchars($tagline) ?></p>
                <p class="text-lg mb-8 text-gray-300 max-w-2xl mx-auto">
                    Master in-demand IT skills through AI-powered, hands-on learning. Build real projects, get instant feedback, and earn verified certificates.
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-4 mb-8">
                    <a href="<?= url('/register') ?>" class="bg-secondary hover:bg-orange-600 text-white font-bold text-lg px-10 py-4 rounded-lg transition-all transform hover:scale-105 shadow-lg">
                        Start Learning Free
                    </a>
                    <a href="<?= url('/courses') ?>" class="bg-white text-primary hover:bg-gray-100 font-semibold text-lg px-10 py-4 rounded-lg transition-colors border-2 border-white">
                        Explore Courses
                    </a>
                </div>
                <div class="flex items-center justify-center gap-6 text-sm text-gray-300">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-secondary" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                        </svg>
                        <span>10,000+ Active Students</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-secondary" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span>Industry-Recognized Certificates</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-12 bg-white border-b">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div class="p-4">
                    <div class="text-4xl font-bold text-primary mb-2">10,000+</div>
                    <div class="text-gray-600">Active Students</div>
                </div>
                <div class="p-4">
                    <div class="text-4xl font-bold text-primary mb-2">50+</div>
                    <div class="text-gray-600">Expert Courses</div>
                </div>
                <div class="p-4">
                    <div class="text-4xl font-bold text-primary mb-2">95%</div>
                    <div class="text-gray-600">Completion Rate</div>
                </div>
                <div class="p-4">
                    <div class="text-4xl font-bold text-primary mb-2">500+</div>
                    <div class="text-gray-600">Projects Built</div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">How It Works</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">Start your journey to mastering IT skills in 4 simple steps</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 max-w-6xl mx-auto">
                <!-- Step 1 -->
                <div class="relative">
                    <div class="text-center">
                        <div class="bg-primary text-white w-16 h-16 rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4">1</div>
                        <h3 class="text-xl font-bold mb-3 text-gray-800">Sign Up Free</h3>
                        <p class="text-gray-600">Create your account in seconds. No credit card required.</p>
                    </div>
                    <div class="hidden md:block absolute top-8 left-full w-full h-0.5 bg-gray-300" style="width: calc(100% - 4rem);"></div>
                </div>

                <!-- Step 2 -->
                <div class="relative">
                    <div class="text-center">
                        <div class="bg-primary text-white w-16 h-16 rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4">2</div>
                        <h3 class="text-xl font-bold mb-3 text-gray-800">Choose Your Path</h3>
                        <p class="text-gray-600">Select courses aligned with your career goals and skill level.</p>
                    </div>
                    <div class="hidden md:block absolute top-8 left-full w-full h-0.5 bg-gray-300" style="width: calc(100% - 4rem);"></div>
                </div>

                <!-- Step 3 -->
                <div class="relative">
                    <div class="text-center">
                        <div class="bg-primary text-white w-16 h-16 rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4">3</div>
                        <h3 class="text-xl font-bold mb-3 text-gray-800">Learn & Practice</h3>
                        <p class="text-gray-600">Build real projects with AI-powered feedback and guidance.</p>
                    </div>
                    <div class="hidden md:block absolute top-8 left-full w-full h-0.5 bg-gray-300" style="width: calc(100% - 4rem);"></div>
                </div>

                <!-- Step 4 -->
                <div class="text-center">
                    <div class="bg-secondary text-white w-16 h-16 rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4">4</div>
                    <h3 class="text-xl font-bold mb-3 text-gray-800">Get Certified</h3>
                    <p class="text-gray-600">Earn industry-recognized certificates to boost your career.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- AI Features Highlight -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Powered by Advanced AI Technology</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">Experience next-generation learning with our AI-driven platform</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- AI Feature 1 -->
                <div class="bg-blue-50 p-6 rounded-xl border-2 border-blue-100 hover:border-primary transition-colors">
                    <div class="text-primary text-4xl mb-4">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold mb-2 text-gray-800">AI Tutor 24/7</h3>
                    <p class="text-gray-600 text-sm">Get instant help and explanations whenever you're stuck.</p>
                </div>

                <!-- AI Feature 2 -->
                <div class="bg-orange-50 p-6 rounded-xl border-2 border-orange-100 hover:border-secondary transition-colors">
                    <div class="text-secondary text-4xl mb-4">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold mb-2 text-gray-800">Code Review AI</h3>
                    <p class="text-gray-600 text-sm">Automated code analysis with detailed improvement suggestions.</p>
                </div>

                <!-- AI Feature 3 -->
                <div class="bg-green-50 p-6 rounded-xl border-2 border-green-100 hover:border-green-600 transition-colors">
                    <div class="text-green-600 text-4xl mb-4">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold mb-2 text-gray-800">Adaptive Learning</h3>
                    <p class="text-gray-600 text-sm">Personalized paths that adjust to your learning pace and style.</p>
                </div>

                <!-- AI Feature 4 -->
                <div class="bg-purple-50 p-6 rounded-xl border-2 border-purple-100 hover:border-purple-600 transition-colors">
                    <div class="text-purple-600 text-4xl mb-4">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold mb-2 text-gray-800">Smart Grading</h3>
                    <p class="text-gray-600 text-sm">Instant project evaluation with comprehensive feedback.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Why Choose Nebatech AI Academy?</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">Everything you need to master IT skills and advance your career</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="card text-center hover:shadow-xl transition-shadow">
                    <div class="text-primary text-5xl mb-4">
                        <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-800">Comprehensive Curriculum</h3>
                    <p class="text-gray-600">From beginner to advanced - complete learning paths designed by industry experts.</p>
                </div>

                <!-- Feature 2 -->
                <div class="card text-center hover:shadow-xl transition-shadow">
                    <div class="text-secondary text-5xl mb-4">
                        <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-800">Hands-On Projects</h3>
                    <p class="text-gray-600">Build real-world projects and create a portfolio that showcases your skills.</p>
                </div>

                <!-- Feature 3 -->
                <div class="card text-center hover:shadow-xl transition-shadow">
                    <div class="text-green-600 text-5xl mb-4">
                        <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-800">Verified Certificates</h3>
                    <p class="text-gray-600">Earn industry-recognized certificates upon completing competency-based programs.</p>
                </div>

                <!-- Feature 4 -->
                <div class="card text-center hover:shadow-xl transition-shadow">
                    <div class="text-purple-600 text-5xl mb-4">
                        <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-800">Learn at Your Pace</h3>
                    <p class="text-gray-600">Self-paced learning with lifetime access to all course materials.</p>
                </div>

                <!-- Feature 5 -->
                <div class="card text-center hover:shadow-xl transition-shadow">
                    <div class="text-blue-600 text-5xl mb-4">
                        <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-800">Community Support</h3>
                    <p class="text-gray-600">Join a vibrant community of learners and get help from peers and mentors.</p>
                </div>

                <!-- Feature 6 -->
                <div class="card text-center hover:shadow-xl transition-shadow">
                    <div class="text-red-600 text-5xl mb-4">
                        <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-800">Career Services</h3>
                    <p class="text-gray-600">Resume building, interview prep, and job placement assistance included.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Technologies Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Technologies You'll Master</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">Learn the most in-demand technologies powering modern applications</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-8 items-center">
                <div class="text-center p-4 hover:bg-gray-50 rounded-lg transition-colors">
                    <div class="text-6xl mb-2">⚛️</div>
                    <div class="font-semibold text-gray-700">React</div>
                </div>
                <div class="text-center p-4 hover:bg-gray-50 rounded-lg transition-colors">
                    <div class="text-6xl mb-2">🟢</div>
                    <div class="font-semibold text-gray-700">Node.js</div>
                </div>
                <div class="text-center p-4 hover:bg-gray-50 rounded-lg transition-colors">
                    <div class="text-6xl mb-2">🐍</div>
                    <div class="font-semibold text-gray-700">Python</div>
                </div>
                <div class="text-center p-4 hover:bg-gray-50 rounded-lg transition-colors">
                    <div class="text-6xl mb-2">🐘</div>
                    <div class="font-semibold text-gray-700">PHP</div>
                </div>
                <div class="text-center p-4 hover:bg-gray-50 rounded-lg transition-colors">
                    <div class="text-6xl mb-2">🗄️</div>
                    <div class="font-semibold text-gray-700">MySQL</div>
                </div>
                <div class="text-center p-4 hover:bg-gray-50 rounded-lg transition-colors">
                    <div class="text-6xl mb-2">☁️</div>
                    <div class="font-semibold text-gray-700">AWS</div>
                </div>
                <div class="text-center p-4 hover:bg-gray-50 rounded-lg transition-colors">
                    <div class="text-6xl mb-2">🎨</div>
                    <div class="font-semibold text-gray-700">Tailwind</div>
                </div>
                <div class="text-center p-4 hover:bg-gray-50 rounded-lg transition-colors">
                    <div class="text-6xl mb-2">📱</div>
                    <div class="font-semibold text-gray-700">JavaScript</div>
                </div>
                <div class="text-center p-4 hover:bg-gray-50 rounded-lg transition-colors">
                    <div class="text-6xl mb-2">🔧</div>
                    <div class="font-semibold text-gray-700">Git</div>
                </div>
                <div class="text-center p-4 hover:bg-gray-50 rounded-lg transition-colors">
                    <div class="text-6xl mb-2">🐳</div>
                    <div class="font-semibold text-gray-700">Docker</div>
                </div>
                <div class="text-center p-4 hover:bg-gray-50 rounded-lg transition-colors">
                    <div class="text-6xl mb-2">📊</div>
                    <div class="font-semibold text-gray-700">MongoDB</div>
                </div>
                <div class="text-center p-4 hover:bg-gray-50 rounded-lg transition-colors">
                    <div class="text-6xl mb-2">🤖</div>
                    <div class="font-semibold text-gray-700">AI/ML</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Course Categories Section -->
    <section class="py-16 bg-white" x-data="{ selectedCategory: 'all' }">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Explore Our Course Categories</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">Filter by category to find the perfect learning path for you</p>
            </div>

            <!-- Category Filter Tabs -->
            <div class="flex flex-wrap justify-center gap-4 mb-12">
                <button @click="selectedCategory = 'all'" 
                        :class="selectedCategory === 'all' ? 'bg-primary text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'"
                        class="px-6 py-3 rounded-lg font-semibold transition-colors">
                    All Courses
                </button>
                <button @click="selectedCategory = 'frontend'" 
                        :class="selectedCategory === 'frontend' ? 'bg-primary text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'"
                        class="px-6 py-3 rounded-lg font-semibold transition-colors">
                    Frontend
                </button>
                <button @click="selectedCategory = 'backend'" 
                        :class="selectedCategory === 'backend' ? 'bg-primary text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'"
                        class="px-6 py-3 rounded-lg font-semibold transition-colors">
                    Backend
                </button>
                <button @click="selectedCategory = 'ai'" 
                        :class="selectedCategory === 'ai' ? 'bg-primary text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'"
                        class="px-6 py-3 rounded-lg font-semibold transition-colors">
                    AI & ML
                </button>
                <button @click="selectedCategory = 'mobile'" 
                        :class="selectedCategory === 'mobile' ? 'bg-primary text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'"
                        class="px-6 py-3 rounded-lg font-semibold transition-colors">
                    Mobile Dev
                </button>
                <button @click="selectedCategory = 'security'" 
                        :class="selectedCategory === 'security' ? 'bg-primary text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'"
                        class="px-6 py-3 rounded-lg font-semibold transition-colors">
                    Cybersecurity
                </button>
            </div>

            <!-- Category Stats -->
            <div class="grid grid-cols-2 md:grid-cols-6 gap-4 max-w-5xl mx-auto">
                <div class="bg-blue-50 p-6 rounded-xl text-center border-2 border-blue-100" 
                     x-show="selectedCategory === 'all' || selectedCategory === 'frontend'" 
                     x-transition>
                    <div class="text-3xl font-bold text-primary mb-2">15+</div>
                    <div class="text-sm text-gray-600 font-semibold">Frontend</div>
                </div>
                <div class="bg-green-50 p-6 rounded-xl text-center border-2 border-green-100" 
                     x-show="selectedCategory === 'all' || selectedCategory === 'backend'" 
                     x-transition>
                    <div class="text-3xl font-bold text-green-600 mb-2">12+</div>
                    <div class="text-sm text-gray-600 font-semibold">Backend</div>
                </div>
                <div class="bg-orange-50 p-6 rounded-xl text-center border-2 border-orange-100" 
                     x-show="selectedCategory === 'all' || selectedCategory === 'ai'" 
                     x-transition>
                    <div class="text-3xl font-bold text-secondary mb-2">8+</div>
                    <div class="text-sm text-gray-600 font-semibold">AI & ML</div>
                </div>
                <div class="bg-purple-50 p-6 rounded-xl text-center border-2 border-purple-100" 
                     x-show="selectedCategory === 'all' || selectedCategory === 'mobile'" 
                     x-transition>
                    <div class="text-3xl font-bold text-purple-600 mb-2">10+</div>
                    <div class="text-sm text-gray-600 font-semibold">Mobile</div>
                </div>
                <div class="bg-red-50 p-6 rounded-xl text-center border-2 border-red-100" 
                     x-show="selectedCategory === 'all' || selectedCategory === 'security'" 
                     x-transition>
                    <div class="text-3xl font-bold text-red-600 mb-2">6+</div>
                    <div class="text-sm text-gray-600 font-semibold">Security</div>
                </div>
                <div class="bg-yellow-50 p-6 rounded-xl text-center border-2 border-yellow-100" 
                     x-show="selectedCategory === 'all'" 
                     x-transition>
                    <div class="text-3xl font-bold text-yellow-600 mb-2">50+</div>
                    <div class="text-sm text-gray-600 font-semibold">Total</div>
                </div>
            </div>

            <div class="text-center mt-12">
                <a href="<?= url('/courses') ?>" class="inline-block bg-primary text-white font-bold px-8 py-3 rounded-lg hover:bg-blue-700 transition-colors">
                    Browse All Categories
                </a>
            </div>
        </div>
    </section>

    <!-- Instructors/Facilitators Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Learn from Expert Instructors</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">Industry professionals with years of real-world experience</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                <!-- Instructor 1 -->
                <div class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all transform hover:-translate-y-2">
                    <div class="h-48 bg-blue-100 flex items-center justify-center">
                        <div class="w-32 h-32 bg-primary text-white rounded-full flex items-center justify-center text-4xl font-bold">
                            JD
                        </div>
                    </div>
                    <div class="p-6 text-center">
                        <h3 class="text-xl font-bold mb-1 text-gray-800">John Doe</h3>
                        <p class="text-primary font-semibold text-sm mb-3">Senior Full Stack Developer</p>
                        <p class="text-gray-600 text-sm mb-4">10+ years at Google & Meta. Expert in React, Node.js, and system design.</p>
                        <div class="flex justify-center gap-3">
                            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-semibold">JavaScript</span>
                            <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-semibold">React</span>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <div class="flex justify-around text-center">
                                <div>
                                    <div class="font-bold text-primary">15</div>
                                    <div class="text-xs text-gray-500">Courses</div>
                                </div>
                                <div>
                                    <div class="font-bold text-primary">5,000+</div>
                                    <div class="text-xs text-gray-500">Students</div>
                                </div>
                                <div>
                                    <div class="font-bold text-primary">4.9</div>
                                    <div class="text-xs text-gray-500">Rating</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Instructor 2 -->
                <div class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all transform hover:-translate-y-2">
                    <div class="h-48 bg-green-100 flex items-center justify-center">
                        <div class="w-32 h-32 bg-green-600 text-white rounded-full flex items-center justify-center text-4xl font-bold">
                            SA
                        </div>
                    </div>
                    <div class="p-6 text-center">
                        <h3 class="text-xl font-bold mb-1 text-gray-800">Sarah Anderson</h3>
                        <p class="text-green-600 font-semibold text-sm mb-3">AI/ML Research Scientist</p>
                        <p class="text-gray-600 text-sm mb-4">PhD in AI. Former researcher at MIT. Specializes in deep learning and NLP.</p>
                        <div class="flex justify-center gap-3">
                            <span class="bg-orange-100 text-orange-800 px-3 py-1 rounded-full text-xs font-semibold">Python</span>
                            <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-xs font-semibold">AI/ML</span>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <div class="flex justify-around text-center">
                                <div>
                                    <div class="font-bold text-green-600">8</div>
                                    <div class="text-xs text-gray-500">Courses</div>
                                </div>
                                <div>
                                    <div class="font-bold text-green-600">3,200+</div>
                                    <div class="text-xs text-gray-500">Students</div>
                                </div>
                                <div>
                                    <div class="font-bold text-green-600">5.0</div>
                                    <div class="text-xs text-gray-500">Rating</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Instructor 3 -->
                <div class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all transform hover:-translate-y-2">
                    <div class="h-48 bg-orange-100 flex items-center justify-center">
                        <div class="w-32 h-32 bg-secondary text-white rounded-full flex items-center justify-center text-4xl font-bold">
                            MK
                        </div>
                    </div>
                    <div class="p-6 text-center">
                        <h3 class="text-xl font-bold mb-1 text-gray-800">Michael Kim</h3>
                        <p class="text-secondary font-semibold text-sm mb-3">Cybersecurity Expert</p>
                        <p class="text-gray-600 text-sm mb-4">15+ years in security. CISSP certified. Worked with Fortune 500 companies.</p>
                        <div class="flex justify-center gap-3">
                            <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-xs font-semibold">Security</span>
                            <span class="bg-gray-200 text-gray-800 px-3 py-1 rounded-full text-xs font-semibold">Linux</span>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <div class="flex justify-around text-center">
                                <div>
                                    <div class="font-bold text-secondary">12</div>
                                    <div class="text-xs text-gray-500">Courses</div>
                                </div>
                                <div>
                                    <div class="font-bold text-secondary">4,500+</div>
                                    <div class="text-xs text-gray-500">Students</div>
                                </div>
                                <div>
                                    <div class="font-bold text-secondary">4.8</div>
                                    <div class="text-xs text-gray-500">Rating</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-12">
                <p class="text-gray-600 mb-4">All instructors are vetted professionals with proven industry experience</p>
            </div>
        </div>
    </section>

    <!-- Popular Courses Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Popular Courses</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">Start your journey with our most popular learning paths</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Course Card 1 -->
                <div class="card hover:shadow-2xl transition-all transform hover:-translate-y-1">
                    <div class="bg-primary h-40 rounded-t-lg -mt-6 -mx-6 mb-4 flex items-center justify-center">
                        <svg class="w-20 h-20 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                        </svg>
                    </div>
                    <div class="flex items-center gap-2 mb-3">
                        <span class="bg-green-100 text-green-800 text-xs font-semibold px-3 py-1 rounded-full">Beginner</span>
                        <span class="text-gray-500 text-sm">⏱️ 12 weeks</span>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Front-End Development</h3>
                    <p class="text-gray-600 mb-4">Master HTML, CSS, JavaScript, and modern frameworks like React. Build responsive, interactive websites.</p>
                    <div class="flex items-center justify-between mb-4 text-sm text-gray-600">
                        <div class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                            </svg>
                            <span>2,345 students</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <span class="text-yellow-500">★★★★★</span>
                            <span>4.8</span>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-2xl font-bold text-primary">Free</span>
                        <a href="<?= url('/courses/frontend') ?>" class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors font-semibold">
                            Start Now →
                        </a>
                    </div>
                </div>

                <!-- Course Card 2 -->
                <div class="card hover:shadow-2xl transition-all transform hover:-translate-y-1">
                    <div class="bg-green-600 h-40 rounded-t-lg -mt-6 -mx-6 mb-4 flex items-center justify-center">
                        <svg class="w-20 h-20 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/>
                        </svg>
                    </div>
                    <div class="flex items-center gap-2 mb-3">
                        <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-3 py-1 rounded-full">Intermediate</span>
                        <span class="text-gray-500 text-sm">⏱️ 16 weeks</span>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Back-End Development</h3>
                    <p class="text-gray-600 mb-4">Build robust server-side applications with PHP, Node.js, and databases. Master APIs and authentication.</p>
                    <div class="flex items-center justify-between mb-4 text-sm text-gray-600">
                        <div class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                            </svg>
                            <span>1,892 students</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <span class="text-yellow-500">★★★★★</span>
                            <span>4.9</span>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-2xl font-bold text-green-600">Free</span>
                        <a href="<?= url('/courses/backend') ?>" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition-colors font-semibold">
                            Start Now →
                        </a>
                    </div>
                </div>

                <!-- Course Card 3 -->
                <div class="card hover:shadow-2xl transition-all transform hover:-translate-y-1 border-2 border-secondary">
                    <div class="bg-secondary h-40 rounded-t-lg -mt-6 -mx-6 mb-4 flex items-center justify-center relative overflow-hidden">
                        <div class="absolute top-2 right-2 bg-white text-secondary text-xs font-bold px-3 py-1 rounded-full">POPULAR</div>
                        <svg class="w-20 h-20 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                        </svg>
                    </div>
                    <div class="flex items-center gap-2 mb-3">
                        <span class="bg-green-100 text-green-800 text-xs font-semibold px-3 py-1 rounded-full">Beginner</span>
                        <span class="text-gray-500 text-sm">⏱️ 10 weeks</span>
                    </div>
                    <h3 class="text-xl font-bold mb-2">AI & Machine Learning</h3>
                    <p class="text-gray-600 mb-4">Introduction to AI concepts and practical machine learning applications. Build intelligent systems.</p>
                    <div class="flex items-center justify-between mb-4 text-sm text-gray-600">
                        <div class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                            </svg>
                            <span>3,567 students</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <span class="text-yellow-500">★★★★★</span>
                            <span>5.0</span>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-2xl font-bold text-secondary">Free</span>
                        <a href="<?= url('/courses/ai') ?>" class="bg-secondary text-white px-6 py-2 rounded-lg hover:bg-orange-600 transition-colors font-semibold">
                            Start Now →
                        </a>
                    </div>
                </div>
            </div>

            <div class="text-center mt-12">
                <a href="<?= url('/courses') ?>" class="inline-block bg-primary text-white font-bold text-lg px-10 py-4 rounded-lg hover:bg-blue-700 transition-colors">
                    View All 50+ Courses
                </a>
            </div>
        </div>
    </section>

    <!-- Platform Demo/Video Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6">
            <div class="max-w-5xl mx-auto">
                <div class="text-center mb-12">
                    <h2 class="text-4xl font-bold text-gray-800 mb-4">See How It Works</h2>
                    <p class="text-xl text-gray-600">Watch a quick 2-minute overview of our AI-powered learning platform</p>
                </div>
                
                <div class="relative bg-gray-900 rounded-2xl overflow-hidden shadow-2xl" style="padding-bottom: 56.25%;">
                    <!-- Placeholder for video - Replace with actual video embed -->
                    <div class="absolute inset-0 flex items-center justify-center bg-primary">
                        <div class="text-center text-white">
                            <svg class="w-24 h-24 mx-auto mb-4 opacity-80" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/>
                            </svg>
                            <p class="text-xl font-semibold">Platform Demo Video</p>
                            <p class="text-sm opacity-75 mt-2">Click to watch how students learn and succeed</p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-primary mb-2">2 min</div>
                        <div class="text-gray-600">Quick Overview</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-primary mb-2">100%</div>
                        <div class="text-gray-600">Hands-On Learning</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-primary mb-2">AI-Powered</div>
                        <div class="text-gray-600">Instant Feedback</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Student Project Gallery -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Projects Built by Our Students</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">Real projects from real students - see what you'll build</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Project 1 -->
                <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all transform hover:-translate-y-2">
                    <div class="h-48 bg-blue-100 flex items-center justify-center">
                        <svg class="w-20 h-20 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">E-Commerce Website</h3>
                        <p class="text-gray-600 mb-4 text-sm">Full-stack shopping platform with cart, payments, and admin panel</p>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-500">By Sarah M.</span>
                            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-semibold">Frontend</span>
                        </div>
                    </div>
                </div>

                <!-- Project 2 -->
                <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all transform hover:-translate-y-2">
                    <div class="h-48 bg-green-100 flex items-center justify-center">
                        <svg class="w-20 h-20 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/>
                        </svg>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">REST API Service</h3>
                        <p class="text-gray-600 mb-4 text-sm">Scalable API with authentication, database, and documentation</p>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-500">By David K.</span>
                            <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-semibold">Backend</span>
                        </div>
                    </div>
                </div>

                <!-- Project 3 -->
                <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all transform hover:-translate-y-2">
                    <div class="h-48 bg-orange-100 flex items-center justify-center">
                        <svg class="w-20 h-20 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                        </svg>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">AI Chatbot</h3>
                        <p class="text-gray-600 mb-4 text-sm">Intelligent chatbot using NLP and machine learning models</p>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-500">By Aisha N.</span>
                            <span class="bg-orange-100 text-orange-800 px-3 py-1 rounded-full text-xs font-semibold">AI/ML</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-12">
                <p class="text-gray-600 mb-4">Every student builds a complete portfolio of 5-10 projects</p>
                <a href="<?= url('/register') ?>" class="inline-block bg-secondary text-white font-bold px-8 py-3 rounded-lg hover:bg-orange-600 transition-colors">
                    Start Building Your Portfolio
                </a>
            </div>
        </div>
    </section>

    <!-- Comparison Table -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Why Choose Nebatech Over Traditional Learning?</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">See how we compare to traditional education and bootcamps</p>
            </div>

            <div class="max-w-5xl mx-auto overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="text-left p-4 font-bold text-gray-800 border-b-2">Feature</th>
                            <th class="text-center p-4 font-bold text-primary border-b-2">Nebatech AI Academy</th>
                            <th class="text-center p-4 font-bold text-gray-600 border-b-2">Traditional University</th>
                            <th class="text-center p-4 font-bold text-gray-600 border-b-2">Coding Bootcamps</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-4 font-semibold">Cost</td>
                            <td class="p-4 text-center"><span class="text-green-600 font-bold">FREE</span></td>
                            <td class="p-4 text-center text-gray-600">$20,000 - $100,000</td>
                            <td class="p-4 text-center text-gray-600">$10,000 - $20,000</td>
                        </tr>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-4 font-semibold">Duration</td>
                            <td class="p-4 text-center"><span class="text-green-600 font-bold">10-16 weeks</span></td>
                            <td class="p-4 text-center text-gray-600">2-4 years</td>
                            <td class="p-4 text-center text-gray-600">12-24 weeks</td>
                        </tr>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-4 font-semibold">AI-Powered Learning</td>
                            <td class="p-4 text-center"><span class="text-green-600 text-2xl">✓</span></td>
                            <td class="p-4 text-center"><span class="text-red-500 text-2xl">✗</span></td>
                            <td class="p-4 text-center"><span class="text-red-500 text-2xl">✗</span></td>
                        </tr>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-4 font-semibold">24/7 Support</td>
                            <td class="p-4 text-center"><span class="text-green-600 text-2xl">✓</span></td>
                            <td class="p-4 text-center"><span class="text-red-500 text-2xl">✗</span></td>
                            <td class="p-4 text-center"><span class="text-yellow-500 text-2xl">~</span></td>
                        </tr>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-4 font-semibold">Hands-On Projects</td>
                            <td class="p-4 text-center"><span class="text-green-600 font-bold">10+ Projects</span></td>
                            <td class="p-4 text-center text-gray-600">2-3 Projects</td>
                            <td class="p-4 text-center text-gray-600">3-5 Projects</td>
                        </tr>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-4 font-semibold">Job Assistance</td>
                            <td class="p-4 text-center"><span class="text-green-600 text-2xl">✓</span></td>
                            <td class="p-4 text-center"><span class="text-yellow-500 text-2xl">~</span></td>
                            <td class="p-4 text-center"><span class="text-green-600 text-2xl">✓</span></td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="p-4 font-semibold">Learn at Your Pace</td>
                            <td class="p-4 text-center"><span class="text-green-600 text-2xl">✓</span></td>
                            <td class="p-4 text-center"><span class="text-red-500 text-2xl">✗</span></td>
                            <td class="p-4 text-center"><span class="text-red-500 text-2xl">✗</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="text-center mt-12">
                <a href="<?= url('/register') ?>" class="inline-block bg-primary text-white font-bold text-lg px-10 py-4 rounded-lg hover:bg-blue-700 transition-colors">
                    Get Started for Free
                </a>
            </div>
        </div>
    </section>

    <!-- Learning Outcomes Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">What You'll Achieve</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">Guaranteed learning outcomes backed by our competency-based curriculum</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
                <div class="bg-white p-6 rounded-xl shadow-lg">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                        <span class="text-2xl">💼</span>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Career-Ready Skills</h3>
                    <p class="text-gray-600">Master the exact skills employers are looking for in 2025</p>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-lg">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-4">
                        <span class="text-2xl">📊</span>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Portfolio of Projects</h3>
                    <p class="text-gray-600">Build 5-10 production-ready projects to showcase your abilities</p>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-lg">
                    <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center mb-4">
                        <span class="text-2xl">🎓</span>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Verified Certificate</h3>
                    <p class="text-gray-600">Industry-recognized certification to boost your resume</p>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-lg">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mb-4">
                        <span class="text-2xl">🚀</span>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Job-Ready in Weeks</h3>
                    <p class="text-gray-600">Go from beginner to employable in 10-16 weeks</p>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-lg">
                    <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center mb-4">
                        <span class="text-2xl">🤝</span>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Network & Community</h3>
                    <p class="text-gray-600">Connect with 10,000+ learners and industry professionals</p>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-lg">
                    <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center mb-4">
                        <span class="text-2xl">♾️</span>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Lifetime Access</h3>
                    <p class="text-gray-600">Keep learning with free updates and new content forever</p>
                </div>
            </div>

            <div class="text-center mt-12 bg-blue-50 p-8 rounded-2xl max-w-3xl mx-auto border-2 border-blue-100">
                <h3 class="text-2xl font-bold text-gray-800 mb-4">Our Guarantee</h3>
                <p class="text-gray-700 text-lg">
                    If you complete the curriculum and don't feel job-ready, we'll work with you personally until you do. 
                    Your success is our success.
                </p>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Student Success Stories</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">See how our students transformed their careers through hands-on learning</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Testimonial 1 -->
                <div class="bg-gray-50 p-8 rounded-xl shadow-lg hover:shadow-xl transition-shadow">
                    <div class="flex items-center mb-4">
                        <div class="w-16 h-16 bg-primary text-white rounded-full flex items-center justify-center text-2xl font-bold mr-4">
                            AS
                        </div>
                        <div>
                            <div class="font-bold text-gray-800">Amara Sesay</div>
                            <div class="text-sm text-gray-600">Frontend Developer</div>
                            <div class="text-yellow-500 text-sm">★★★★★</div>
                        </div>
                    </div>
                    <p class="text-gray-700 italic mb-4">
                        "The hands-on projects and AI feedback helped me land my dream job as a Frontend Developer. The learning path was clear and practical!"
                    </p>
                    <div class="text-sm text-gray-500">
                        Completed: Front-End Development • Now at TechCorp
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="bg-gray-50 p-8 rounded-xl shadow-lg hover:shadow-xl transition-shadow">
                    <div class="flex items-center mb-4">
                        <div class="w-16 h-16 bg-secondary text-white rounded-full flex items-center justify-center text-2xl font-bold mr-4">
                            CO
                        </div>
                        <div>
                            <div class="font-bold text-gray-800">Chidi Okonkwo</div>
                            <div class="text-sm text-gray-600">Full Stack Developer</div>
                            <div class="text-yellow-500 text-sm">★★★★★</div>
                        </div>
                    </div>
                    <p class="text-gray-700 italic mb-4">
                        "From zero coding experience to building full-stack applications in 6 months. The AI tutor was like having a mentor 24/7!"
                    </p>
                    <div class="text-sm text-gray-500">
                        Completed: Full Stack Program • Freelancing Successfully
                    </div>
                </div>

                <!-- Testimonial 3 -->
                <div class="bg-gray-50 p-8 rounded-xl shadow-lg hover:shadow-xl transition-shadow">
                    <div class="flex items-center mb-4">
                        <div class="w-16 h-16 bg-green-600 text-white rounded-full flex items-center justify-center text-2xl font-bold mr-4">
                            FK
                        </div>
                        <div>
                            <div class="font-bold text-gray-800">Fatima Kamara</div>
                            <div class="text-sm text-gray-600">AI/ML Engineer</div>
                            <div class="text-yellow-500 text-sm">★★★★★</div>
                        </div>
                    </div>
                    <p class="text-gray-700 italic mb-4">
                        "The AI & ML course gave me the practical skills I needed. The projects in my portfolio helped me get hired at a leading AI company!"
                    </p>
                    <div class="text-sm text-gray-500">
                        Completed: AI & Machine Learning • Now at AI Innovations
                    </div>
                </div>
            </div>

            <div class="text-center mt-12">
                <p class="text-gray-600 mb-4">Join 10,000+ successful graduates</p>
                <a href="<?= url('/register') ?>" class="inline-block bg-secondary text-white font-bold px-8 py-3 rounded-lg hover:bg-orange-600 transition-colors">
                    Start Your Success Story
                </a>
            </div>
        </div>
    </section>

    <!-- Trust Badges Section -->
    <section class="py-12 bg-gray-50 border-y">
        <div class="container mx-auto px-6">
            <div class="text-center mb-8">
                <h3 class="text-2xl font-bold text-gray-800 mb-2">Trusted by Leading Organizations</h3>
                <p class="text-gray-600">Our students work at top companies worldwide</p>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-5 gap-8 items-center opacity-60">
                <div class="text-center font-bold text-gray-700 text-xl">Microsoft</div>
                <div class="text-center font-bold text-gray-700 text-xl">Google</div>
                <div class="text-center font-bold text-gray-700 text-xl">Amazon</div>
                <div class="text-center font-bold text-gray-700 text-xl">Meta</div>
                <div class="text-center font-bold text-gray-700 text-xl">Apple</div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6 max-w-4xl">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Frequently Asked Questions</h2>
                <p class="text-xl text-gray-600">Everything you need to know about Nebatech AI Academy</p>
            </div>

            <div class="space-y-4" x-data="{ openFaq: null }">
                <!-- FAQ 1 -->
                <div class="border border-gray-200 rounded-lg overflow-hidden">
                    <button @click="openFaq = openFaq === 1 ? null : 1" class="w-full px-6 py-4 text-left bg-gray-50 hover:bg-gray-100 transition-colors flex justify-between items-center">
                        <span class="font-semibold text-gray-800">Is Nebatech AI Academy really free?</span>
                        <svg class="w-5 h-5 transition-transform" :class="{ 'rotate-180': openFaq === 1 }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="openFaq === 1" x-collapse class="px-6 py-4 bg-white">
                        <p class="text-gray-600">Yes! All our core courses are 100% free to access. You can learn at your own pace, complete projects, and earn certificates without any cost. We believe quality education should be accessible to everyone.</p>
                    </div>
                </div>

                <!-- FAQ 2 -->
                <div class="border border-gray-200 rounded-lg overflow-hidden">
                    <button @click="openFaq = openFaq === 2 ? null : 2" class="w-full px-6 py-4 text-left bg-gray-50 hover:bg-gray-100 transition-colors flex justify-between items-center">
                        <span class="font-semibold text-gray-800">Do I need prior programming experience?</span>
                        <svg class="w-5 h-5 transition-transform" :class="{ 'rotate-180': openFaq === 2 }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="openFaq === 2" x-collapse class="px-6 py-4 bg-white">
                        <p class="text-gray-600">No! We have courses for complete beginners. Our AI-powered platform adapts to your learning pace and provides personalized guidance. Start from zero and build your skills step by step.</p>
                    </div>
                </div>

                <!-- FAQ 3 -->
                <div class="border border-gray-200 rounded-lg overflow-hidden">
                    <button @click="openFaq = openFaq === 3 ? null : 3" class="w-full px-6 py-4 text-left bg-gray-50 hover:bg-gray-100 transition-colors flex justify-between items-center">
                        <span class="font-semibold text-gray-800">How long does it take to complete a course?</span>
                        <svg class="w-5 h-5 transition-transform" :class="{ 'rotate-180': openFaq === 3 }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="openFaq === 3" x-collapse class="px-6 py-4 bg-white">
                        <p class="text-gray-600">It depends on the course and your pace. Most courses take 10-16 weeks if you study 10-15 hours per week. However, you have lifetime access, so you can learn as quickly or slowly as you need.</p>
                    </div>
                </div>

                <!-- FAQ 4 -->
                <div class="border border-gray-200 rounded-lg overflow-hidden">
                    <button @click="openFaq = openFaq === 4 ? null : 4" class="w-full px-6 py-4 text-left bg-gray-50 hover:bg-gray-100 transition-colors flex justify-between items-center">
                        <span class="font-semibold text-gray-800">Will I get a certificate?</span>
                        <svg class="w-5 h-5 transition-transform" :class="{ 'rotate-180': openFaq === 4 }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="openFaq === 4" x-collapse class="px-6 py-4 bg-white">
                        <p class="text-gray-600">Yes! Upon completing a course and passing all competency-based assessments, you'll receive a verified digital certificate that you can share on LinkedIn, add to your resume, and showcase in your portfolio.</p>
                    </div>
                </div>

                <!-- FAQ 5 -->
                <div class="border border-gray-200 rounded-lg overflow-hidden">
                    <button @click="openFaq = openFaq === 5 ? null : 5" class="w-full px-6 py-4 text-left bg-gray-50 hover:bg-gray-100 transition-colors flex justify-between items-center">
                        <span class="font-semibold text-gray-800">What makes the AI features special?</span>
                        <svg class="w-5 h-5 transition-transform" :class="{ 'rotate-180': openFaq === 5 }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="openFaq === 5" x-collapse class="px-6 py-4 bg-white">
                        <p class="text-gray-600">Our AI provides instant code review, personalized learning paths, 24/7 tutoring, and adaptive difficulty. It's like having an expert mentor available anytime you need help, giving you detailed feedback on your projects.</p>
                    </div>
                </div>

                <!-- FAQ 6 -->
                <div class="border border-gray-200 rounded-lg overflow-hidden">
                    <button @click="openFaq = openFaq === 6 ? null : 6" class="w-full px-6 py-4 text-left bg-gray-50 hover:bg-gray-100 transition-colors flex justify-between items-center">
                        <span class="font-semibold text-gray-800">Do you offer job placement assistance?</span>
                        <svg class="w-5 h-5 transition-transform" :class="{ 'rotate-180': openFaq === 6 }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="openFaq === 6" x-collapse class="px-6 py-4 bg-white">
                        <p class="text-gray-600">Yes! We provide resume building, portfolio review, interview preparation, and connections to our partner companies. Many of our students have landed jobs at top tech companies after completing their courses.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Blog/Resources Preview Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Latest from Our Blog & Resources</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">Stay updated with industry insights, tutorials, and career advice</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Blog Post 1 -->
                <article class="bg-gray-50 rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all transform hover:-translate-y-1">
                    <div class="h-48 bg-blue-100 flex items-center justify-center">
                        <svg class="w-16 h-16 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div class="p-6">
                        <div class="text-xs text-primary font-semibold mb-2">TUTORIAL • 5 MIN READ</div>
                        <h3 class="text-xl font-bold mb-3 text-gray-800">10 JavaScript Tips Every Developer Should Know in 2025</h3>
                        <p class="text-gray-600 mb-4 text-sm">Master these modern JavaScript techniques to write cleaner, more efficient code...</p>
                        <a href="<?= url('/blog/javascript-tips-2025') ?>" class="text-primary font-semibold hover:text-blue-700 inline-flex items-center">
                            Read More
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </article>

                <!-- Blog Post 2 -->
                <article class="bg-gray-50 rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all transform hover:-translate-y-1">
                    <div class="h-48 bg-green-100 flex items-center justify-center">
                        <svg class="w-16 h-16 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div class="p-6">
                        <div class="text-xs text-green-600 font-semibold mb-2">CAREER ADVICE • 8 MIN READ</div>
                        <h3 class="text-xl font-bold mb-3 text-gray-800">How to Land Your First Tech Job Without a Degree</h3>
                        <p class="text-gray-600 mb-4 text-sm">A comprehensive guide to breaking into tech with portfolio projects and networking...</p>
                        <a href="<?= url('/blog/first-tech-job-without-degree') ?>" class="text-green-600 font-semibold hover:text-green-700 inline-flex items-center">
                            Read More
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </article>

                <!-- Blog Post 3 -->
                <article class="bg-gray-50 rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all transform hover:-translate-y-1">
                    <div class="h-48 bg-orange-100 flex items-center justify-center">
                        <svg class="w-16 h-16 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                        </svg>
                    </div>
                    <div class="p-6">
                        <div class="text-xs text-secondary font-semibold mb-2">AI & MACHINE LEARNING • 10 MIN READ</div>
                        <h3 class="text-xl font-bold mb-3 text-gray-800">Getting Started with AI: A Beginner's Roadmap</h3>
                        <p class="text-gray-600 mb-4 text-sm">Learn the fundamentals of artificial intelligence and machine learning from scratch...</p>
                        <a href="<?= url('/blog/ai-beginners-roadmap') ?>" class="text-secondary font-semibold hover:text-orange-600 inline-flex items-center">
                            Read More
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </article>
            </div>

            <div class="text-center mt-12">
                <a href="<?= url('/blog') ?>" class="inline-block bg-gray-800 text-white font-bold px-8 py-3 rounded-lg hover:bg-gray-900 transition-colors">
                    View All Articles
                </a>
            </div>
        </div>
    </section>

    <!-- Live Activity Feed Section -->
    <section class="py-16 bg-gray-50" x-data="{ activities: [
        { name: 'Sarah M.', action: 'just enrolled in', course: 'Full Stack Development', time: '2 mins ago', color: 'blue' },
        { name: 'Ahmed K.', action: 'completed', course: 'Python Programming', time: '5 mins ago', color: 'green' },
        { name: 'Grace L.', action: 'just started', course: 'AI & Machine Learning', time: '8 mins ago', color: 'orange' },
        { name: 'Ibrahim N.', action: 'earned certificate in', course: 'React Development', time: '12 mins ago', color: 'blue' },
        { name: 'Fatima A.', action: 'just enrolled in', course: 'Cybersecurity Basics', time: '15 mins ago', color: 'red' }
    ] }">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Join Our Active Learning Community</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">See what students are learning right now</p>
            </div>

            <div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-xl p-8">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-gray-800">🔴 Live Activity</h3>
                    <span class="text-sm text-gray-500">Updated in real-time</span>
                </div>

                <div class="space-y-4">
                    <template x-for="(activity, index) in activities" :key="index">
                        <div class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors animate-fade-in" 
                             :style="'animation-delay: ' + (index * 0.1) + 's'">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center text-white font-bold mr-4"
                                 :class="{
                                     'bg-blue-500': activity.color === 'blue',
                                     'bg-green-500': activity.color === 'green',
                                     'bg-orange-500': activity.color === 'orange',
                                     'bg-red-500': activity.color === 'red'
                                 }"
                                 x-text="activity.name.split(' ')[0][0] + activity.name.split(' ')[1][0]">
                            </div>
                            <div class="flex-1">
                                <p class="text-gray-800">
                                    <span class="font-semibold" x-text="activity.name"></span>
                                    <span x-text="' ' + activity.action + ' '"></span>
                                    <span class="font-semibold text-primary" x-text="activity.course"></span>
                                </p>
                                <p class="text-xs text-gray-500" x-text="activity.time"></p>
                            </div>
                            <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    </template>
                </div>

                <div class="mt-8 text-center bg-blue-50 p-6 rounded-lg border-2 border-blue-100">
                    <p class="text-gray-700 font-semibold mb-2">🎉 <span class="text-primary">127 students</span> enrolled in courses today</p>
                    <p class="text-sm text-gray-600">Be part of our growing community of learners</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-6 max-w-2xl">
            <div class="bg-white p-8 rounded-2xl shadow-lg text-center">
                <div class="text-5xl mb-4">📧</div>
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Stay Updated with Free Learning Resources</h2>
                <p class="text-gray-600 mb-6">Get weekly tips, new courses, and exclusive content delivered to your inbox</p>
                <form class="flex flex-col sm:flex-row gap-4">
                    <input type="email" placeholder="Enter your email address" class="flex-1 px-6 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" required>
                    <button type="submit" class="bg-primary text-white font-bold px-8 py-3 rounded-lg hover:bg-blue-700 transition-colors whitespace-nowrap">
                        Subscribe Free
                    </button>
                </form>
                <p class="text-xs text-gray-500 mt-4">No spam, unsubscribe anytime. Join 25,000+ subscribers.</p>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-primary text-white">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-4xl font-bold mb-4">Ready to Start Your Learning Journey?</h2>
            <p class="text-xl mb-8">Join thousands of students transforming their careers with hands-on IT skills.</p>
            <a href="<?= url('/register') ?>" class="bg-secondary hover:bg-orange-600 text-white font-bold text-lg px-12 py-4 rounded-lg transition-all transform hover:scale-105 inline-block shadow-xl">
                Enroll Now - It's Free!
            </a>
        </div>
    </section>

    <!-- Back to Top Button -->
    <div x-data="{ showButton: false }" 
         @scroll.window="showButton = window.pageYOffset > 300"
         x-show="showButton"
         x-transition
         class="fixed bottom-8 right-8 z-50">
        <button @click="window.scrollTo({ top: 0, behavior: 'smooth' })" 
                class="bg-primary text-white p-4 rounded-full shadow-2xl hover:bg-blue-700 transition-all transform hover:scale-110"
                aria-label="Back to top">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
            </svg>
        </button>
    </div>

    <style>
        /* Smooth scroll behavior */
        html {
            scroll-behavior: smooth;
        }

        /* Fade-in animation for activity feed */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.5s ease-out forwards;
        }

        /* Hover effects for cards */
        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        /* Loading skeleton for images (future use) */
        .skeleton {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
        }

        @keyframes loading {
            0% {
                background-position: 200% 0;
            }
            100% {
                background-position: -200% 0;
            }
        }

        /* Pulse animation for live indicators */
        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.5;
            }
        }

        .animate-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
    </style>

    <?php include __DIR__ . '/../partials/footer.php'; ?>
</body>
</html>
