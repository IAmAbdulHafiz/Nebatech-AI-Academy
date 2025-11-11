<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Explore our comprehensive tech courses in Frontend, Backend, Full Stack, Mobile Development, AI, Data Science, Cloud Computing, and Cybersecurity.">
    <meta name="keywords" content="Tech Courses, Programming, Web Development, Mobile Development, AI, Data Science, Cloud Computing, Cybersecurity">
    <title>All Courses - Nebatech AI Academy</title>
    
    <!-- Tailwind CSS -->
    <link href="<?= asset('css/main.css') ?>" rel="stylesheet">
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-white">
    <?php include __DIR__ . '/../partials/header.php'; ?>

    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-blue-600 to-purple-600 text-white py-20">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6">
                    Explore Our Courses
                </h1>
                <p class="text-xl md:text-2xl text-blue-100 mb-8">
                    Choose from our comprehensive range of tech courses designed to take you from beginner to professional
                </p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="<?= url('/register') ?>" class="bg-white text-blue-600 px-8 py-4 rounded-lg font-semibold hover:bg-blue-50 transition inline-flex items-center">
                        <i class="fas fa-user-plus mr-2"></i>Get Started Free
                    </a>
                    <a href="<?= url('/apply') ?>" class="bg-blue-700 text-white px-8 py-4 rounded-lg font-semibold hover:bg-blue-800 transition inline-flex items-center border-2 border-blue-500">
                        <i class="fas fa-file-alt mr-2"></i>Apply Now
                    </a>
                </div>

                <!-- Quick Stats -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-12">
                    <div>
                        <div class="text-3xl font-bold">50+</div>
                        <div class="text-blue-200 text-sm">Courses</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold">10,000+</div>
                        <div class="text-blue-200 text-sm">Students</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold">500+</div>
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

    <!-- Course Categories -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Course Categories</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Discover the perfect learning path for your career goals
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Frontend Development -->
                <a href="<?= url('/courses/frontend') ?>" class="group bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-blue-500">
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-6 text-white">
                        <div class="w-16 h-16 bg-white/20 rounded-lg flex items-center justify-center mb-4">
                            <i class="fas fa-code text-3xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold mb-2">Frontend Development</h3>
                        <p class="text-blue-100">Build stunning user interfaces with HTML, CSS, JavaScript, React, and Vue</p>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-between text-sm text-gray-600 mb-4">
                            <span><i class="fas fa-book mr-2"></i>15+ Courses</span>
                            <span><i class="fas fa-clock mr-2"></i>200+ Hours</span>
                        </div>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="bg-orange-100 text-orange-700 px-2 py-1 rounded text-xs font-medium">HTML/CSS</span>
                            <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-xs font-medium">JavaScript</span>
                            <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs font-medium">React</span>
                        </div>
                        <div class="text-blue-600 font-semibold group-hover:translate-x-2 transition-transform inline-flex items-center">
                            Explore Courses <i class="fas fa-arrow-right ml-2"></i>
                        </div>
                    </div>
                </a>

                <!-- Backend Development -->
                <a href="<?= url('/courses/backend') ?>" class="group bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-green-500">
                    <div class="bg-gradient-to-br from-green-500 to-green-600 p-6 text-white">
                        <div class="w-16 h-16 bg-white/20 rounded-lg flex items-center justify-center mb-4">
                            <i class="fas fa-server text-3xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold mb-2">Backend Development</h3>
                        <p class="text-green-100">Master server-side programming with Node.js, Python, PHP, and databases</p>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-between text-sm text-gray-600 mb-4">
                            <span><i class="fas fa-book mr-2"></i>12+ Courses</span>
                            <span><i class="fas fa-clock mr-2"></i>180+ Hours</span>
                        </div>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-medium">Node.js</span>
                            <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs font-medium">Python</span>
                            <span class="bg-purple-100 text-purple-700 px-2 py-1 rounded text-xs font-medium">PHP</span>
                        </div>
                        <div class="text-green-600 font-semibold group-hover:translate-x-2 transition-transform inline-flex items-center">
                            Explore Courses <i class="fas fa-arrow-right ml-2"></i>
                        </div>
                    </div>
                </a>

                <!-- Full Stack Development -->
                <a href="<?= url('/courses/fullstack') ?>" class="group bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-purple-500">
                    <div class="bg-gradient-to-br from-purple-500 to-purple-600 p-6 text-white">
                        <div class="w-16 h-16 bg-white/20 rounded-lg flex items-center justify-center mb-4">
                            <i class="fas fa-layer-group text-3xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold mb-2">Full Stack Development</h3>
                        <p class="text-purple-100">Become a complete developer mastering both frontend and backend</p>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-between text-sm text-gray-600 mb-4">
                            <span><i class="fas fa-book mr-2"></i>10+ Courses</span>
                            <span><i class="fas fa-clock mr-2"></i>300+ Hours</span>
                        </div>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs font-medium">MERN</span>
                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-medium">MEAN</span>
                            <span class="bg-purple-100 text-purple-700 px-2 py-1 rounded text-xs font-medium">LAMP</span>
                        </div>
                        <div class="text-purple-600 font-semibold group-hover:translate-x-2 transition-transform inline-flex items-center">
                            Explore Courses <i class="fas fa-arrow-right ml-2"></i>
                        </div>
                    </div>
                </a>

                <!-- Mobile Development -->
                <a href="<?= url('/courses/mobile') ?>" class="group bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-pink-500">
                    <div class="bg-gradient-to-br from-pink-500 to-pink-600 p-6 text-white">
                        <div class="w-16 h-16 bg-white/20 rounded-lg flex items-center justify-center mb-4">
                            <i class="fas fa-mobile-alt text-3xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold mb-2">Mobile Development</h3>
                        <p class="text-pink-100">Build native and cross-platform mobile apps with React Native and Flutter</p>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-between text-sm text-gray-600 mb-4">
                            <span><i class="fas fa-book mr-2"></i>8+ Courses</span>
                            <span><i class="fas fa-clock mr-2"></i>150+ Hours</span>
                        </div>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs font-medium">React Native</span>
                            <span class="bg-cyan-100 text-cyan-700 px-2 py-1 rounded text-xs font-medium">Flutter</span>
                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-medium">Swift</span>
                        </div>
                        <div class="text-pink-600 font-semibold group-hover:translate-x-2 transition-transform inline-flex items-center">
                            Explore Courses <i class="fas fa-arrow-right ml-2"></i>
                        </div>
                    </div>
                </a>

                <!-- AI & Machine Learning -->
                <a href="<?= url('/courses/ai') ?>" class="group bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-indigo-500">
                    <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 p-6 text-white">
                        <div class="w-16 h-16 bg-white/20 rounded-lg flex items-center justify-center mb-4">
                            <i class="fas fa-brain text-3xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold mb-2">AI & Machine Learning</h3>
                        <p class="text-indigo-100">Master artificial intelligence, deep learning, and neural networks</p>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-between text-sm text-gray-600 mb-4">
                            <span><i class="fas fa-book mr-2"></i>10+ Courses</span>
                            <span><i class="fas fa-clock mr-2"></i>200+ Hours</span>
                        </div>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-xs font-medium">Python</span>
                            <span class="bg-orange-100 text-orange-700 px-2 py-1 rounded text-xs font-medium">TensorFlow</span>
                            <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs font-medium">PyTorch</span>
                        </div>
                        <div class="text-indigo-600 font-semibold group-hover:translate-x-2 transition-transform inline-flex items-center">
                            Explore Courses <i class="fas fa-arrow-right ml-2"></i>
                        </div>
                    </div>
                </a>

                <!-- Data Science -->
                <a href="<?= url('/courses/data-science') ?>" class="group bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-teal-500">
                    <div class="bg-gradient-to-br from-teal-500 to-teal-600 p-6 text-white">
                        <div class="w-16 h-16 bg-white/20 rounded-lg flex items-center justify-center mb-4">
                            <i class="fas fa-chart-line text-3xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold mb-2">Data Science</h3>
                        <p class="text-teal-100">Analyze data, build models, and extract insights with Python and R</p>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-between text-sm text-gray-600 mb-4">
                            <span><i class="fas fa-book mr-2"></i>9+ Courses</span>
                            <span><i class="fas fa-clock mr-2"></i>170+ Hours</span>
                        </div>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs font-medium">Python</span>
                            <span class="bg-purple-100 text-purple-700 px-2 py-1 rounded text-xs font-medium">Pandas</span>
                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-medium">SQL</span>
                        </div>
                        <div class="text-teal-600 font-semibold group-hover:translate-x-2 transition-transform inline-flex items-center">
                            Explore Courses <i class="fas fa-arrow-right ml-2"></i>
                        </div>
                    </div>
                </a>

                <!-- Cloud Computing -->
                <a href="<?= url('/courses/cloud') ?>" class="group bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-cyan-500">
                    <div class="bg-gradient-to-br from-cyan-500 to-cyan-600 p-6 text-white">
                        <div class="w-16 h-16 bg-white/20 rounded-lg flex items-center justify-center mb-4">
                            <i class="fas fa-cloud text-3xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold mb-2">Cloud Computing</h3>
                        <p class="text-cyan-100">Master AWS, Azure, Google Cloud, and modern DevOps practices</p>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-between text-sm text-gray-600 mb-4">
                            <span><i class="fas fa-book mr-2"></i>11+ Courses</span>
                            <span><i class="fas fa-clock mr-2"></i>190+ Hours</span>
                        </div>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="bg-orange-100 text-orange-700 px-2 py-1 rounded text-xs font-medium">AWS</span>
                            <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs font-medium">Azure</span>
                            <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs font-medium">GCP</span>
                        </div>
                        <div class="text-cyan-600 font-semibold group-hover:translate-x-2 transition-transform inline-flex items-center">
                            Explore Courses <i class="fas fa-arrow-right ml-2"></i>
                        </div>
                    </div>
                </a>

                <!-- Cybersecurity -->
                <a href="<?= url('/courses/cybersecurity') ?>" class="group bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-red-500">
                    <div class="bg-gradient-to-br from-red-500 to-red-600 p-6 text-white">
                        <div class="w-16 h-16 bg-white/20 rounded-lg flex items-center justify-center mb-4">
                            <i class="fas fa-shield-alt text-3xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold mb-2">Cybersecurity</h3>
                        <p class="text-red-100">Protect systems and networks with ethical hacking and security practices</p>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-between text-sm text-gray-600 mb-4">
                            <span><i class="fas fa-book mr-2"></i>7+ Courses</span>
                            <span><i class="fas fa-clock mr-2"></i>140+ Hours</span>
                        </div>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs font-medium">Ethical Hacking</span>
                            <span class="bg-orange-100 text-orange-700 px-2 py-1 rounded text-xs font-medium">Penetration Testing</span>
                            <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-xs font-medium">Network Security</span>
                        </div>
                        <div class="text-red-600 font-semibold group-hover:translate-x-2 transition-transform inline-flex items-center">
                            Explore Courses <i class="fas fa-arrow-right ml-2"></i>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="bg-gradient-to-r from-blue-600 to-purple-600 text-white py-16">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Ready to Start Your Learning Journey?</h2>
            <p class="text-xl text-blue-100 mb-8 max-w-2xl mx-auto">
                Join thousands of students already learning with Nebatech AI Academy
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="<?= url('/register') ?>" class="bg-white text-blue-600 px-8 py-4 rounded-lg font-semibold hover:bg-blue-50 transition inline-flex items-center">
                    <i class="fas fa-user-plus mr-2"></i>Create Free Account
                </a>
                <a href="<?= url('/apply') ?>" class="bg-blue-700 text-white px-8 py-4 rounded-lg font-semibold hover:bg-blue-800 transition inline-flex items-center border-2 border-blue-500">
                    <i class="fas fa-file-alt mr-2"></i>Apply for Program
                </a>
            </div>
        </div>
    </section>

    <?php include __DIR__ . '/../partials/footer.php'; ?>
</body>
</html>
