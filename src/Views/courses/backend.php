<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Master Backend Development with PHP, Node.js, Python, databases, APIs, and server-side technologies. Build scalable backend systems.">
    <meta name="keywords" content="Backend Development, PHP, Node.js, Python, Databases, APIs, Server-Side, RESTful">
    <title>Backend Development Courses - Nebatech AI Academy</title>
    
    <link href="<?= asset('css/main.css') ?>" rel="stylesheet">
    <!-- Alpine.js Collapse Plugin (must load before Alpine core) -->
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <!-- Alpine.js Core -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-white">
    <?php include __DIR__ . '/../partials/header.php'; ?>

    <!-- Hero Section -->
    <section class="bg-green-600 text-white py-20">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                <div class="inline-block bg-green-700 text-green-100 px-4 py-2 rounded-full text-sm font-semibold mb-6">
                    <i class="fas fa-server mr-2"></i>Backend Development
                </div>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6">
                    Master Backend Development
                </h1>
                <p class="text-xl md:text-2xl text-green-100 mb-8">
                    Build powerful server-side applications, APIs, and databases with PHP, Node.js, Python, and modern backend technologies
                </p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="#courses" class="bg-white text-green-600 px-8 py-4 rounded-lg font-semibold hover:bg-green-50 transition inline-flex items-center">
                        <i class="fas fa-rocket mr-2"></i>Browse Courses
                    </a>
                    <a href="<?= url('/register') ?>" class="bg-green-700 text-white px-8 py-4 rounded-lg font-semibold hover:bg-green-800 transition inline-flex items-center border-2 border-green-500">
                        <i class="fas fa-user-plus mr-2"></i>Get Started Free
                    </a>
                </div>

                <!-- Quick Stats -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-12">
                    <div>
                        <div class="text-3xl font-bold">18+</div>
                        <div class="text-green-200 text-sm">Courses</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold">6,500+</div>
                        <div class="text-green-200 text-sm">Students</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold">250+</div>
                        <div class="text-green-200 text-sm">Hours Content</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold">97%</div>
                        <div class="text-green-200 text-sm">Success Rate</div>
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
                    Follow our structured curriculum from beginner to expert backend developer
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
                                <p class="text-gray-600 mb-4">Learn server-side programming fundamentals</p>
                                <div class="flex flex-wrap gap-2">
                                    <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-lg text-sm font-medium">PHP Basics</span>
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-lg text-sm font-medium">Node.js Intro</span>
                                    <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-lg text-sm font-medium">SQL & MySQL</span>
                                    <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-lg text-sm font-medium">HTTP & APIs</span>
                                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-lg text-sm font-medium">RESTful Design</span>
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
                                <p class="text-gray-600 mb-4">Build scalable applications with frameworks</p>
                                <div class="flex flex-wrap gap-2">
                                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-lg text-sm font-medium">Laravel</span>
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-lg text-sm font-medium">Express.js</span>
                                    <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-lg text-sm font-medium">Django</span>
                                    <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-lg text-sm font-medium">MongoDB</span>
                                    <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-lg text-sm font-medium">PostgreSQL</span>
                                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-lg text-sm font-medium">Authentication</span>
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
                                <p class="text-gray-600 mb-4">Master architecture and DevOps practices</p>
                                <div class="flex flex-wrap gap-2">
                                    <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-lg text-sm font-medium">Microservices</span>
                                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-lg text-sm font-medium">Docker</span>
                                    <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-lg text-sm font-medium">GraphQL</span>
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-lg text-sm font-medium">Redis</span>
                                    <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-lg text-sm font-medium">Message Queues</span>
                                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-lg text-sm font-medium">System Design</span>
                                    <span class="bg-pink-100 text-pink-700 px-3 py-1 rounded-lg text-sm font-medium">Performance Tuning</span>
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
                    Develop critical backend skills for building modern applications
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
                <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-purple-500">
                    <div class="text-purple-600 text-4xl mb-4">
                        <i class="fas fa-database"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Database Design</h3>
                    <p class="text-gray-600">Design efficient database schemas, write optimized queries, and manage data effectively.</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-green-500">
                    <div class="text-green-600 text-4xl mb-4">
                        <i class="fas fa-exchange-alt"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">API Development</h3>
                    <p class="text-gray-600">Build RESTful and GraphQL APIs that power web and mobile applications.</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-blue-500">
                    <div class="text-blue-600 text-4xl mb-4">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Security</h3>
                    <p class="text-gray-600">Implement authentication, authorization, encryption, and protect against vulnerabilities.</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-red-500">
                    <div class="text-red-600 text-4xl mb-4">
                        <i class="fas fa-tachometer-alt"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Performance</h3>
                    <p class="text-gray-600">Optimize server performance, implement caching, and scale applications efficiently.</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-orange-500">
                    <div class="text-orange-600 text-4xl mb-4">
                        <i class="fas fa-tools"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">DevOps</h3>
                    <p class="text-gray-600">Deploy applications, set up CI/CD pipelines, and manage server infrastructure.</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-yellow-500">
                    <div class="text-yellow-600 text-4xl mb-4">
                        <i class="fas fa-project-diagram"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Architecture</h3>
                    <p class="text-gray-600">Design scalable system architectures and choose the right tools for the job.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Courses Listing -->
    <section id="courses" class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Backend Development Courses</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Choose from our comprehensive selection of backend courses
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-7xl mx-auto">
                <!-- Course 1 -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                    <div class="bg-purple-600 h-48 flex items-center justify-center">
                        <i class="fab fa-php text-white text-8xl"></i>
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
                                <span class="text-gray-600 text-sm ml-1">(2,890)</span>
                            </span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">PHP Programming Complete</h3>
                        <p class="text-gray-600 mb-4">Learn PHP from basics to advanced including OOP and modern practices.</p>
                        <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                            <span><i class="fas fa-clock mr-1"></i>55 hours</span>
                            <span><i class="fas fa-book mr-1"></i>68 lessons</span>
                            <span><i class="fas fa-users mr-1"></i>4.2K</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="text-2xl font-bold text-green-600">$69</div>
                            <a href="#" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition font-semibold">
                                Enroll Now
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Course 2 -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                    <div class="bg-green-600 h-48 flex items-center justify-center">
                        <i class="fab fa-node-js text-white text-8xl"></i>
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
                                <span class="text-gray-600 text-sm ml-1">(3,450)</span>
                            </span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Node.js & Express.js</h3>
                        <p class="text-gray-600 mb-4">Build scalable backend applications with Node.js and Express framework.</p>
                        <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                            <span><i class="fas fa-clock mr-1"></i>70 hours</span>
                            <span><i class="fas fa-book mr-1"></i>85 lessons</span>
                            <span><i class="fas fa-users mr-1"></i>5.8K</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="text-2xl font-bold text-green-600">$99</div>
                            <a href="#" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition font-semibold">
                                Enroll Now
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Course 3 -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                    <div class="bg-red-600 h-48 flex items-center justify-center">
                        <i class="fab fa-laravel text-white text-8xl"></i>
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
                                <span class="text-gray-600 text-sm ml-1">(2,680)</span>
                            </span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Laravel Mastery</h3>
                        <p class="text-gray-600 mb-4">Master Laravel framework for building modern PHP applications.</p>
                        <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                            <span><i class="fas fa-clock mr-1"></i>85 hours</span>
                            <span><i class="fas fa-book mr-1"></i>102 lessons</span>
                            <span><i class="fas fa-users mr-1"></i>4.5K</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="text-2xl font-bold text-green-600">$139</div>
                            <a href="#" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition font-semibold">
                                Enroll Now
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Course 4 -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                    <div class="bg-blue-600 h-48 flex items-center justify-center">
                        <i class="fas fa-database text-white text-8xl"></i>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-semibold">Beginner</span>
                            <span class="text-yellow-500">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                                <span class="text-gray-600 text-sm ml-1">(3,120)</span>
                            </span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">SQL & Database Design</h3>
                        <p class="text-gray-600 mb-4">Master SQL, MySQL, PostgreSQL, and database design principles.</p>
                        <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                            <span><i class="fas fa-clock mr-1"></i>45 hours</span>
                            <span><i class="fas fa-book mr-1"></i>52 lessons</span>
                            <span><i class="fas fa-users mr-1"></i>6.1K</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="text-2xl font-bold text-green-600">$79</div>
                            <a href="#" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition font-semibold">
                                Enroll Now
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Course 5 -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                    <div class="bg-pink-600 h-48 flex items-center justify-center">
                        <i class="fas fa-project-diagram text-white text-8xl"></i>
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
                                <span class="text-gray-600 text-sm ml-1">(1,890)</span>
                            </span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">RESTful API Development</h3>
                        <p class="text-gray-600 mb-4">Design and build professional REST APIs with best practices.</p>
                        <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                            <span><i class="fas fa-clock mr-1"></i>50 hours</span>
                            <span><i class="fas fa-book mr-1"></i>60 lessons</span>
                            <span><i class="fas fa-users mr-1"></i>3.4K</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="text-2xl font-bold text-green-600">$89</div>
                            <a href="#" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition font-semibold">
                                Enroll Now
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Course 6 -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                    <div class="bg-blue-800 h-48 flex items-center justify-center">
                        <i class="fab fa-docker text-white text-8xl"></i>
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
                                <span class="text-gray-600 text-sm ml-1">(1,540)</span>
                            </span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Microservices Architecture</h3>
                        <p class="text-gray-600 mb-4">Build scalable microservices with Docker, Kubernetes, and more.</p>
                        <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                            <span><i class="fas fa-clock mr-1"></i>95 hours</span>
                            <span><i class="fas fa-book mr-1"></i>115 lessons</span>
                            <span><i class="fas fa-users mr-1"></i>2.1K</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="text-2xl font-bold text-green-600">$159</div>
                            <a href="#" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition font-semibold">
                                Enroll Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-12">
                <a href="<?= url('/courses') ?>" class="inline-flex items-center text-green-600 hover:text-green-700 font-semibold">
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
                            Backend developers are the backbone of tech companies. Our graduates work at:
                        </p>
                        
                        <div class="space-y-4">
                            <div class="flex items-start gap-4">
                                <div class="bg-green-100 text-green-600 w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 mb-1">Enterprise Companies</h4>
                                    <p class="text-gray-600">Banks, healthcare, e-commerce platforms</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-4">
                                <div class="bg-green-100 text-green-600 w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 mb-1">Tech Startups</h4>
                                    <p class="text-gray-600">Building scalable systems for rapid growth</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-4">
                                <div class="bg-green-100 text-green-600 w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 mb-1">SaaS Companies</h4>
                                    <p class="text-gray-600">Developing cloud-based software solutions</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-4">
                                <div class="bg-green-100 text-green-600 w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 mb-1">Consulting</h4>
                                    <p class="text-gray-600">Backend architecture and optimization</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-green-50 rounded-lg p-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">Average Salaries</h3>
                        <div class="space-y-6">
                            <div>
                                <div class="flex justify-between items-center mb-2">
                                    <span class="font-semibold text-gray-900">Junior Backend Developer</span>
                                    <span class="font-bold text-green-600">$50K - $70K</span>
                                </div>
                                <div class="bg-gray-200 h-2 rounded-full overflow-hidden">
                                    <div class="bg-green-500 h-full rounded-full" style="width: 45%"></div>
                                </div>
                            </div>
                            
                            <div>
                                <div class="flex justify-between items-center mb-2">
                                    <span class="font-semibold text-gray-900">Mid-Level Backend Developer</span>
                                    <span class="font-bold text-green-600">$70K - $105K</span>
                                </div>
                                <div class="bg-gray-200 h-2 rounded-full overflow-hidden">
                                    <div class="bg-blue-500 h-full rounded-full" style="width: 65%"></div>
                                </div>
                            </div>
                            
                            <div>
                                <div class="flex justify-between items-center mb-2">
                                    <span class="font-semibold text-gray-900">Senior Backend Developer</span>
                                    <span class="font-bold text-green-600">$105K - $155K</span>
                                </div>
                                <div class="bg-gray-200 h-2 rounded-full overflow-hidden">
                                    <div class="bg-purple-500 h-full rounded-full" style="width: 85%"></div>
                                </div>
                            </div>
                            
                            <div>
                                <div class="flex justify-between items-center mb-2">
                                    <span class="font-semibold text-gray-900">Backend Architect</span>
                                    <span class="font-bold text-green-600">$155K+</span>
                                </div>
                                <div class="bg-gray-200 h-2 rounded-full overflow-hidden">
                                    <div class="bg-red-500 h-full rounded-full" style="width: 100%"></div>
                                </div>
                            </div>
                        </div>
                        
                        <p class="text-sm text-gray-600 mt-6">
                            <i class="fas fa-info-circle mr-1"></i>
                            Backend roles often command higher salaries due to system complexity
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="bg-green-600 text-white py-16">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Ready to Start Your Backend Journey?</h2>
            <p class="text-xl text-green-100 mb-8 max-w-2xl mx-auto">
                Join thousands of students mastering backend development with Nebatech AI Academy
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="<?= url('/register') ?>" class="bg-white text-green-600 px-8 py-4 rounded-lg font-semibold hover:bg-green-50 transition inline-flex items-center">
                    <i class="fas fa-rocket mr-2"></i>Get Started Free
                </a>
                <a href="<?= url('/contact') ?>" class="bg-green-700 text-white px-8 py-4 rounded-lg font-semibold hover:bg-green-800 transition inline-flex items-center border-2 border-green-500">
                    <i class="fas fa-comment mr-2"></i>Talk to an Advisor
                </a>
            </div>
        </div>
    </section>

    <?php include __DIR__ . '/../partials/footer.php'; ?>
</body>
</html>
