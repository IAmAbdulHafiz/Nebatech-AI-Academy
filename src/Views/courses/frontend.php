<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Master Frontend Development with HTML, CSS, JavaScript, React, Vue, and modern web technologies. Build stunning user interfaces and responsive web applications.">
    <meta name="keywords" content="Frontend Development, HTML, CSS, JavaScript, React, Vue, Angular, Web Development, UI/UX">
    <title>Frontend Development Courses - Nebatech AI Academy</title>
    
    <!-- Tailwind CSS -->
    <link href="<?= asset('css/main.css') ?>" rel="stylesheet">
    
    <!-- Alpine.js -->
    <!-- Alpine.js Collapse Plugin (must load before Alpine core) -->
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <!-- Alpine.js Core -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-white">
    <?php include __DIR__ . '/../partials/header.php'; ?>

    <!-- Hero Section -->
    <section class="bg-blue-600 text-white py-20">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                <div class="inline-block bg-blue-700 text-blue-100 px-4 py-2 rounded-full text-sm font-semibold mb-6">
                    <i class="fas fa-code mr-2"></i>Frontend Development
                </div>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6">
                    Master Frontend Development
                </h1>
                <p class="text-xl md:text-2xl text-blue-100 mb-8">
                    Build stunning, responsive user interfaces with HTML, CSS, JavaScript, and modern frameworks like React and Vue
                </p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="#courses" class="bg-white text-blue-600 px-8 py-4 rounded-lg font-semibold hover:bg-blue-50 transition inline-flex items-center">
                        <i class="fas fa-rocket mr-2"></i>Browse Courses
                    </a>
                    <a href="<?= url('/register') ?>" class="bg-blue-700 text-white px-8 py-4 rounded-lg font-semibold hover:bg-blue-800 transition inline-flex items-center border-2 border-blue-500">
                        <i class="fas fa-user-plus mr-2"></i>Get Started Free
                    </a>
                </div>

                <!-- Quick Stats -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-12">
                    <div>
                        <div class="text-3xl font-bold">15+</div>
                        <div class="text-blue-200 text-sm">Courses</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold">5,000+</div>
                        <div class="text-blue-200 text-sm">Students</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold">200+</div>
                        <div class="text-blue-200 text-sm">Hours Content</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold">95%</div>
                        <div class="text-blue-200 text-sm">Success Rate</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Learning Path -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Your Learning Path</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Follow our structured curriculum from beginner to advanced frontend developer
                </p>
            </div>

            <div class="max-w-5xl mx-auto">
                <div class="space-y-8">
                    <!-- Level 1: Beginner -->
                    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
                        <div class="flex items-start gap-4">
                            <div class="bg-green-100 text-green-600 w-12 h-12 rounded-full flex items-center justify-center font-bold flex-shrink-0">
                                1
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    <h3 class="text-xl font-bold text-gray-900">Beginner Level</h3>
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-semibold">3-6 months</span>
                                </div>
                                <p class="text-gray-600 mb-4">Master the fundamentals of web development</p>
                                <div class="flex flex-wrap gap-2">
                                    <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-lg text-sm font-medium">HTML5</span>
                                    <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-lg text-sm font-medium">CSS3</span>
                                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-lg text-sm font-medium">JavaScript Basics</span>
                                    <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-lg text-sm font-medium">Responsive Design</span>
                                    <span class="bg-pink-100 text-pink-700 px-3 py-1 rounded-lg text-sm font-medium">Git & GitHub</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Level 2: Intermediate -->
                    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
                        <div class="flex items-start gap-4">
                            <div class="bg-blue-100 text-blue-600 w-12 h-12 rounded-full flex items-center justify-center font-bold flex-shrink-0">
                                2
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    <h3 class="text-xl font-bold text-gray-900">Intermediate Level</h3>
                                    <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-semibold">4-8 months</span>
                                </div>
                                <p class="text-gray-600 mb-4">Build dynamic applications with modern JavaScript</p>
                                <div class="flex flex-wrap gap-2">
                                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-lg text-sm font-medium">ES6+</span>
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-lg text-sm font-medium">TypeScript</span>
                                    <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-lg text-sm font-medium">Tailwind CSS</span>
                                    <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-lg text-sm font-medium">Sass/SCSS</span>
                                    <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-lg text-sm font-medium">Webpack</span>
                                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-lg text-sm font-medium">API Integration</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Level 3: Advanced -->
                    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-purple-500">
                        <div class="flex items-start gap-4">
                            <div class="bg-purple-100 text-purple-600 w-12 h-12 rounded-full flex items-center justify-center font-bold flex-shrink-0">
                                3
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    <h3 class="text-xl font-bold text-gray-900">Advanced Level</h3>
                                    <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-sm font-semibold">6-12 months</span>
                                </div>
                                <p class="text-gray-600 mb-4">Master modern frameworks and advanced concepts</p>
                                <div class="flex flex-wrap gap-2">
                                    <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-lg text-sm font-medium">React.js</span>
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-lg text-sm font-medium">Vue.js</span>
                                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-lg text-sm font-medium">Angular</span>
                                    <span class="bg-black text-white px-3 py-1 rounded-lg text-sm font-medium">Next.js</span>
                                    <span class="bg-teal-100 text-teal-700 px-3 py-1 rounded-lg text-sm font-medium">State Management</span>
                                    <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-lg text-sm font-medium">Testing</span>
                                    <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-lg text-sm font-medium">Performance Optimization</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Skills You'll Gain -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Skills You'll Gain</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Develop in-demand skills that employers are looking for
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
                <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-blue-500">
                    <div class="text-blue-600 text-4xl mb-4">
                        <i class="fas fa-paint-brush"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">UI/UX Design</h3>
                    <p class="text-gray-600">Create beautiful, user-friendly interfaces with modern design principles and accessibility standards.</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-green-500">
                    <div class="text-green-600 text-4xl mb-4">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Responsive Design</h3>
                    <p class="text-gray-600">Build websites that work seamlessly across all devices and screen sizes.</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-purple-500">
                    <div class="text-purple-600 text-4xl mb-4">
                        <i class="fab fa-react"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Modern Frameworks</h3>
                    <p class="text-gray-600">Master React, Vue, and Angular to build scalable single-page applications.</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-yellow-500">
                    <div class="text-yellow-600 text-4xl mb-4">
                        <i class="fas fa-tachometer-alt"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Performance</h3>
                    <p class="text-gray-600">Optimize web applications for speed, efficiency, and excellent user experience.</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-red-500">
                    <div class="text-red-600 text-4xl mb-4">
                        <i class="fas fa-vial"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Testing</h3>
                    <p class="text-gray-600">Write unit, integration, and end-to-end tests to ensure code quality.</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-orange-500">
                    <div class="text-orange-600 text-4xl mb-4">
                        <i class="fas fa-code-branch"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Version Control</h3>
                    <p class="text-gray-600">Collaborate effectively using Git, GitHub, and modern development workflows.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Courses Listing -->
    <section id="courses" class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Frontend Development Courses</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Choose from our comprehensive selection of frontend courses
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-7xl mx-auto">
                <!-- Course 1 -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                    <div class="bg-orange-500 h-48 flex items-center justify-center">
                        <i class="fab fa-html5 text-white text-8xl"></i>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-semibold">Beginner</span>
                            <span class="text-yellow-500">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <span class="text-gray-600 text-sm ml-1">(2,450)</span>
                            </span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">HTML & CSS Fundamentals</h3>
                        <p class="text-gray-600 mb-4">Learn the building blocks of web development with HTML5 and CSS3.</p>
                        <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                            <span><i class="fas fa-clock mr-1"></i>40 hours</span>
                            <span><i class="fas fa-book mr-1"></i>45 lessons</span>
                            <span><i class="fas fa-users mr-1"></i>3.5K</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="text-2xl font-bold text-blue-600">$49</div>
                            <a href="#" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition font-semibold">
                                Enroll Now
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Course 2 -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                    <div class="bg-yellow-400 h-48 flex items-center justify-center">
                        <i class="fab fa-js text-gray-900 text-8xl"></i>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-semibold">Beginner</span>
                            <span class="text-yellow-500">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <span class="text-gray-600 text-sm ml-1">(3,120)</span>
                            </span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">JavaScript Essentials</h3>
                        <p class="text-gray-600 mb-4">Master JavaScript from basics to advanced concepts and ES6+ features.</p>
                        <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                            <span><i class="fas fa-clock mr-1"></i>60 hours</span>
                            <span><i class="fas fa-book mr-1"></i>65 lessons</span>
                            <span><i class="fas fa-users mr-1"></i>5.2K</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="text-2xl font-bold text-blue-600">$79</div>
                            <a href="#" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition font-semibold">
                                Enroll Now
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Course 3 -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                    <div class="bg-blue-500 h-48 flex items-center justify-center">
                        <i class="fab fa-react text-white text-8xl"></i>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-semibold">Intermediate</span>
                            <span class="text-yellow-500">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <span class="text-gray-600 text-sm ml-1">(2,890)</span>
                            </span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">React.js Complete Guide</h3>
                        <p class="text-gray-600 mb-4">Build powerful web applications with React, Hooks, and modern patterns.</p>
                        <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                            <span><i class="fas fa-clock mr-1"></i>80 hours</span>
                            <span><i class="fas fa-book mr-1"></i>95 lessons</span>
                            <span><i class="fas fa-users mr-1"></i>4.8K</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="text-2xl font-bold text-blue-600">$129</div>
                            <a href="#" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition font-semibold">
                                Enroll Now
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Course 4 -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                    <div class="bg-green-500 h-48 flex items-center justify-center">
                        <i class="fab fa-vuejs text-white text-8xl"></i>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-semibold">Intermediate</span>
                            <span class="text-yellow-500">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                                <span class="text-gray-600 text-sm ml-1">(1,940)</span>
                            </span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Vue.js Mastery</h3>
                        <p class="text-gray-600 mb-4">Learn Vue 3, Composition API, Vuex, and build modern SPAs.</p>
                        <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                            <span><i class="fas fa-clock mr-1"></i>70 hours</span>
                            <span><i class="fas fa-book mr-1"></i>82 lessons</span>
                            <span><i class="fas fa-users mr-1"></i>3.2K</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="text-2xl font-bold text-blue-600">$119</div>
                            <a href="#" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition font-semibold">
                                Enroll Now
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Course 5 -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                    <div class="bg-blue-600 h-48 flex items-center justify-center">
                        <i class="fas fa-wind text-white text-8xl"></i>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-semibold">Intermediate</span>
                            <span class="text-yellow-500">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <span class="text-gray-600 text-sm ml-1">(2,150)</span>
                            </span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Tailwind CSS Fundamentals</h3>
                        <p class="text-gray-600 mb-4">Build modern UIs rapidly with utility-first CSS framework.</p>
                        <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                            <span><i class="fas fa-clock mr-1"></i>35 hours</span>
                            <span><i class="fas fa-book mr-1"></i>42 lessons</span>
                            <span><i class="fas fa-users mr-1"></i>2.8K</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="text-2xl font-bold text-blue-600">$59</div>
                            <a href="#" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition font-semibold">
                                Enroll Now
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Course 6 -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                    <div class="bg-black h-48 flex items-center justify-center">
                        <div class="text-white text-6xl font-bold">Next.js</div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-sm font-semibold">Advanced</span>
                            <span class="text-yellow-500">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <span class="text-gray-600 text-sm ml-1">(1,680)</span>
                            </span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Next.js Full Course</h3>
                        <p class="text-gray-600 mb-4">Build production-ready React apps with SSR, SSG, and API routes.</p>
                        <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                            <span><i class="fas fa-clock mr-1"></i>90 hours</span>
                            <span><i class="fas fa-book mr-1"></i>110 lessons</span>
                            <span><i class="fas fa-users mr-1"></i>2.5K</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="text-2xl font-bold text-blue-600">$149</div>
                            <a href="#" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition font-semibold">
                                Enroll Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-12">
                <a href="<?= url('/courses') ?>" class="inline-flex items-center text-blue-600 hover:text-blue-700 font-semibold">
                    View All Courses <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Career Outcomes -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <div class="grid md:grid-cols-2 gap-12 items-center">
                    <div>
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">Career Outcomes</h2>
                        <p class="text-xl text-gray-600 mb-8">
                            Frontend developers are in high demand across industries. Our graduates work at:
                        </p>
                        
                        <div class="space-y-4">
                            <div class="flex items-start gap-4">
                                <div class="bg-green-100 text-green-600 w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 mb-1">Tech Giants</h4>
                                    <p class="text-gray-600">Google, Facebook, Microsoft, Amazon, Apple</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-4">
                                <div class="bg-green-100 text-green-600 w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 mb-1">Startups</h4>
                                    <p class="text-gray-600">Fast-growing companies building innovative products</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-4">
                                <div class="bg-green-100 text-green-600 w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 mb-1">Agencies</h4>
                                    <p class="text-gray-600">Digital agencies creating websites for clients</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-4">
                                <div class="bg-green-100 text-green-600 w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 mb-1">Freelancing</h4>
                                    <p class="text-gray-600">Work independently with clients worldwide</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-blue-50 rounded-lg p-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">Average Salaries</h3>
                        <div class="space-y-6">
                            <div>
                                <div class="flex justify-between items-center mb-2">
                                    <span class="font-semibold text-gray-900">Junior Frontend Developer</span>
                                    <span class="font-bold text-blue-600">$45K - $65K</span>
                                </div>
                                <div class="bg-gray-200 h-2 rounded-full overflow-hidden">
                                    <div class="bg-green-500 h-full rounded-full" style="width: 40%"></div>
                                </div>
                            </div>
                            
                            <div>
                                <div class="flex justify-between items-center mb-2">
                                    <span class="font-semibold text-gray-900">Mid-Level Frontend Developer</span>
                                    <span class="font-bold text-blue-600">$65K - $95K</span>
                                </div>
                                <div class="bg-gray-200 h-2 rounded-full overflow-hidden">
                                    <div class="bg-blue-500 h-full rounded-full" style="width: 60%"></div>
                                </div>
                            </div>
                            
                            <div>
                                <div class="flex justify-between items-center mb-2">
                                    <span class="font-semibold text-gray-900">Senior Frontend Developer</span>
                                    <span class="font-bold text-blue-600">$95K - $140K</span>
                                </div>
                                <div class="bg-gray-200 h-2 rounded-full overflow-hidden">
                                    <div class="bg-purple-500 h-full rounded-full" style="width: 80%"></div>
                                </div>
                            </div>
                            
                            <div>
                                <div class="flex justify-between items-center mb-2">
                                    <span class="font-semibold text-gray-900">Lead/Principal Frontend Dev</span>
                                    <span class="font-bold text-blue-600">$140K+</span>
                                </div>
                                <div class="bg-gray-200 h-2 rounded-full overflow-hidden">
                                    <div class="bg-red-500 h-full rounded-full" style="width: 100%"></div>
                                </div>
                            </div>
                        </div>
                        
                        <p class="text-sm text-gray-600 mt-6">
                            <i class="fas fa-info-circle mr-1"></i>
                            Salaries vary by location, experience, and company size
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="bg-blue-600 text-white py-16">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Ready to Start Your Frontend Journey?</h2>
            <p class="text-xl text-blue-100 mb-8 max-w-2xl mx-auto">
                Join thousands of students learning frontend development with Nebatech AI Academy
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="<?= url('/register') ?>" class="bg-white text-blue-600 px-8 py-4 rounded-lg font-semibold hover:bg-blue-50 transition inline-flex items-center">
                    <i class="fas fa-rocket mr-2"></i>Get Started Free
                </a>
                <a href="<?= url('/contact') ?>" class="bg-blue-700 text-white px-8 py-4 rounded-lg font-semibold hover:bg-blue-800 transition inline-flex items-center border-2 border-blue-500">
                    <i class="fas fa-comment mr-2"></i>Talk to an Advisor
                </a>
            </div>
        </div>
    </section>

    <?php include __DIR__ . '/../partials/footer.php'; ?>
</body>
</html>
