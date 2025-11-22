<!-- Hero Section -->
    <section class="relative bg-gradient-to-br from-purple-900 via-purple-700 to-purple-600 text-white py-20 overflow-hidden">
        <!-- Digital Horizon Background -->
        <div class="absolute inset-0 overflow-hidden">
            <!-- Horizon Glow Effect -->
            <div class="absolute bottom-0 left-0 right-0 h-96 bg-gradient-to-t from-purple-500/30 via-purple-400/10 to-transparent"></div>
            <div class="absolute top-0 left-0 right-0 h-96 bg-gradient-to-b from-purple-800/50 via-transparent to-transparent"></div>
            
            <!-- Geometric Light Beams -->
            <div class="absolute inset-0">
                <div class="absolute top-0 left-1/4 w-1 h-full bg-gradient-to-b from-purple-400/40 via-purple-400/20 to-transparent transform -skew-x-12 animate-pulse" style="animation-duration: 3s;"></div>
                <div class="absolute top-0 right-1/3 w-1 h-full bg-gradient-to-b from-purple-300/30 via-purple-300/10 to-transparent transform skew-x-12 animate-pulse" style="animation-duration: 4s; animation-delay: 1s;"></div>
                <div class="absolute top-0 left-2/3 w-0.5 h-full bg-gradient-to-b from-purple-400/30 via-transparent to-transparent transform -skew-x-6 animate-pulse" style="animation-duration: 5s; animation-delay: 2s;"></div>
            </div>
            
            <!-- Dynamic Glowing Orbs -->
            <div class="absolute top-20 left-10 w-96 h-96 bg-purple-500/40 rounded-full blur-3xl animate-pulse" style="animation-duration: 6s;"></div>
            <div class="absolute bottom-10 right-10 w-[500px] h-[500px] bg-purple-400/30 rounded-full blur-3xl animate-pulse" style="animation-duration: 8s; animation-delay: 1s;"></div>
            
            <!-- Full Stack Icons Floating -->
            <div class="absolute top-1/4 left-[10%] opacity-20 animate-float" style="animation-duration: 6s;">
                <i class="fas fa-layer-group text-6xl text-purple-300"></i>
            </div>
            <div class="absolute top-1/3 right-[15%] opacity-20 animate-float" style="animation-duration: 7s; animation-delay: 1s;">
                <i class="fas fa-code text-6xl text-purple-200"></i>
            </div>
            <div class="absolute bottom-1/4 left-[20%] opacity-20 animate-float" style="animation-duration: 8s; animation-delay: 2s;">
                <i class="fas fa-server text-6xl text-purple-300"></i>
            </div>
            <div class="absolute bottom-1/3 right-[12%] opacity-20 animate-float" style="animation-duration: 6.5s; animation-delay: 0.5s;">
                <i class="fas fa-database text-6xl text-purple-200"></i>
            </div>
        </div>
        
        <!-- Content -->
        <div class="container mx-auto px-4 relative z-10">
            <div class="max-w-4xl mx-auto text-center">
                <div class="inline-block bg-purple-800/60 backdrop-blur-sm text-purple-100 px-4 py-2 rounded-full text-sm font-semibold mb-6 border border-purple-400/30">
                    <i class="fas fa-layer-group mr-2"></i>Full Stack Development
                </div>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6">
                    Master Full Stack Development
                </h1>
                <p class="text-xl md:text-2xl text-purple-100 mb-8">
                    Become a complete developer by mastering both frontend and backend technologies - from UI to database
                </p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="#courses" class="bg-white text-purple-600 px-8 py-4 rounded-lg font-semibold hover:bg-purple-50 transition inline-flex items-center shadow-lg hover:shadow-xl">
                        <i class="fas fa-rocket mr-2"></i>Browse Courses
                    </a>
                    <a href="<?= url('/register') ?>" class="bg-purple-800/60 backdrop-blur-sm text-white px-8 py-4 rounded-lg font-semibold hover:bg-purple-800 transition inline-flex items-center border-2 border-purple-400/50 shadow-lg">
                        <i class="fas fa-user-plus mr-2"></i>Get Started Free
                    </a>
                </div>

                <!-- Quick Stats -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-12">
                    <div class="backdrop-blur-sm bg-white/10 rounded-lg p-4 border border-purple-400/20">
                        <div class="text-3xl font-bold">25+</div>
                        <div class="text-purple-200 text-sm">Modules</div>
                    </div>
                    <div class="backdrop-blur-sm bg-white/10 rounded-lg p-4 border border-purple-400/20">
                        <div class="text-3xl font-bold">8,200+</div>
                        <div class="text-purple-200 text-sm">Students</div>
                    </div>
                    <div class="backdrop-blur-sm bg-white/10 rounded-lg p-4 border border-purple-400/20">
                        <div class="text-3xl font-bold">350+</div>
                        <div class="text-purple-200 text-sm">Hours Content</div>
                    </div>
                    <div class="backdrop-blur-sm bg-white/10 rounded-lg p-4 border border-purple-400/20">
                        <div class="text-3xl font-bold">98%</div>
                        <div class="text-purple-200 text-sm">Success Rate</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Learning Path -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Your Full Stack Learning Path</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Master frontend, backend, and everything in between to become a complete developer
                </p>
            </div>

            <div class="max-w-5xl mx-auto">
                <div class="space-y-8">
                    <!-- Level 1: Frontend Foundation -->
                    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-primary/90">
                        <div class="flex items-start gap-4">
                            <div class="bg-blue-100 text-primary w-12 h-12 rounded-full flex items-center justify-center font-bold flex-shrink-0">
                                1
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    <h3 class="text-xl font-bold text-gray-900">Frontend Foundation</h3>
                                    <span class="bg-blue-100 text-primary px-3 py-1 rounded-full text-sm font-semibold">3-6 months</span>
                                </div>
                                <p class="text-gray-600 mb-4">Build stunning user interfaces and responsive designs</p>
                                <div class="flex flex-wrap gap-2">
                                    <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-lg text-sm font-medium">HTML5 & CSS3</span>
                                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-lg text-sm font-medium">JavaScript ES6+</span>
                                    <span class="bg-blue-100 text-primary px-3 py-1 rounded-lg text-sm font-medium">React.js</span>
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-lg text-sm font-medium">Tailwind CSS</span>
                                    <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-lg text-sm font-medium">Responsive Design</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Level 2: Backend Foundation -->
                    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
                        <div class="flex items-start gap-4">
                            <div class="bg-green-100 text-green-600 w-12 h-12 rounded-full flex items-center justify-center font-bold flex-shrink-0">
                                2
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    <h3 class="text-xl font-bold text-gray-900">Backend Foundation</h3>
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-semibold">4-8 months</span>
                                </div>
                                <p class="text-gray-600 mb-4">Build robust server-side applications and APIs</p>
                                <div class="flex flex-wrap gap-2">
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-lg text-sm font-medium">Node.js</span>
                                    <span class="bg-blue-100 text-primary px-3 py-1 rounded-lg text-sm font-medium">Express.js</span>
                                    <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-lg text-sm font-medium">MongoDB</span>
                                    <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-lg text-sm font-medium">SQL & PostgreSQL</span>
                                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-lg text-sm font-medium">RESTful APIs</span>
                                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-lg text-sm font-medium">Authentication</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Level 3: Full Stack Integration -->
                    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-purple-500">
                        <div class="flex items-start gap-4">
                            <div class="bg-purple-100 text-purple-600 w-12 h-12 rounded-full flex items-center justify-center font-bold flex-shrink-0">
                                3
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    <h3 class="text-xl font-bold text-gray-900">Full Stack Integration</h3>
                                    <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-sm font-semibold">6-12 months</span>
                                </div>
                                <p class="text-gray-600 mb-4">Connect frontend and backend into complete applications</p>
                                <div class="flex flex-wrap gap-2">
                                    <span class="bg-blue-100 text-primary px-3 py-1 rounded-lg text-sm font-medium">MERN Stack</span>
                                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-lg text-sm font-medium">MEAN Stack</span>
                                    <span class="bg-black text-white px-3 py-1 rounded-lg text-sm font-medium">Next.js</span>
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-lg text-sm font-medium">GraphQL</span>
                                    <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-lg text-sm font-medium">WebSockets</span>
                                    <span class="bg-teal-100 text-teal-700 px-3 py-1 rounded-lg text-sm font-medium">State Management</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Level 4: DevOps & Deployment -->
                    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-red-500">
                        <div class="flex items-start gap-4">
                            <div class="bg-red-100 text-red-600 w-12 h-12 rounded-full flex items-center justify-center font-bold flex-shrink-0">
                                4
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    <h3 class="text-xl font-bold text-gray-900">DevOps & Deployment</h3>
                                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm font-semibold">3-6 months</span>
                                </div>
                                <p class="text-gray-600 mb-4">Deploy and manage production applications</p>
                                <div class="flex flex-wrap gap-2">
                                    <span class="bg-blue-100 text-primary px-3 py-1 rounded-lg text-sm font-medium">Docker</span>
                                    <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-lg text-sm font-medium">AWS</span>
                                    <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-lg text-sm font-medium">CI/CD</span>
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-lg text-sm font-medium">Nginx</span>
                                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-lg text-sm font-medium">Testing</span>
                                    <span class="bg-pink-100 text-pink-700 px-3 py-1 rounded-lg text-sm font-medium">Monitoring</span>
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
                    Become a versatile developer with skills across the entire development stack
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
                <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-primary/90">
                    <div class="text-primary text-4xl mb-4">
                        <i class="fas fa-laptop-code"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Frontend Development</h3>
                    <p class="text-gray-600">Create beautiful, responsive UIs with modern frameworks and best practices.</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-green-500">
                    <div class="text-green-600 text-4xl mb-4">
                        <i class="fas fa-server"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Backend Development</h3>
                    <p class="text-gray-600">Build scalable server-side applications, APIs, and handle business logic.</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-purple-500">
                    <div class="text-purple-600 text-4xl mb-4">
                        <i class="fas fa-database"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Database Management</h3>
                    <p class="text-gray-600">Design schemas, write queries, and work with SQL and NoSQL databases.</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-orange-500">
                    <div class="text-orange-600 text-4xl mb-4">
                        <i class="fas fa-cloud"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Cloud Deployment</h3>
                    <p class="text-gray-600">Deploy applications to cloud platforms like AWS, Heroku, and Vercel.</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-red-500">
                    <div class="text-red-600 text-4xl mb-4">
                        <i class="fas fa-vial"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Testing & QA</h3>
                    <p class="text-gray-600">Write unit, integration, and E2E tests to ensure code quality.</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-yellow-500">
                    <div class="text-yellow-600 text-4xl mb-4">
                        <i class="fas fa-tools"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">DevOps Practices</h3>
                    <p class="text-gray-600">Set up CI/CD pipelines, containerization, and automation.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Courses Listing -->
    <section id="courses" class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <!-- Bundle Pricing Banner -->
            <div class="max-w-4xl mx-auto mb-12">
                <div class="bg-gradient-to-r from-purple-600 to-purple-700 rounded-2xl p-8 text-white shadow-xl">
                    <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                        <div class="flex-1 text-center md:text-left">
                            <h3 class="text-2xl md:text-3xl font-bold mb-2">Complete Full Stack Track Bundle</h3>
                            <p class="text-purple-100 mb-3">Get all 6 courses + certifications + lifetime access</p>
                            <div class="flex items-center gap-4 justify-center md:justify-start">
                                <span class="text-lg line-through text-purple-200">GHS 12,840</span>
                                <span class="bg-yellow-400 text-gray-900 px-4 py-1 rounded-full font-bold text-sm">Save 35%</span>
                            </div>
                        </div>
                        <div class="text-center">
                            <div class="text-5xl font-bold mb-2">GHS 8,300</div>
                            <a href="<?= url('/courses/fullstack/enroll') ?>" class="inline-block bg-white text-purple-600 px-8 py-3 rounded-lg font-bold hover:bg-purple-50 transition shadow-lg">
                                Enroll in Bundle
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Individual Courses</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Or choose individual courses - each sold separately
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-7xl mx-auto">
                <!-- Course 1 -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                    <div class="bg-primary h-48 flex items-center justify-center">
                        <div class="text-white text-center">
                            <i class="fas fa-layer-group text-6xl mb-2"></i>
                            <div class="text-xl font-bold">MERN Stack</div>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="bg-blue-100 text-primary px-3 py-1 rounded-full text-sm font-semibold">Intermediate</span>
                            <span class="text-yellow-500">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <span class="text-gray-600 text-sm ml-1">(4,250)</span>
                            </span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Complete MERN Stack Developer</h3>
                        <p class="text-gray-600 mb-4">Master MongoDB, Express, React, and Node.js to build full-stack apps.</p>
                        <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                            <span><i class="fas fa-clock mr-1"></i>120 hours</span>
                            <span><i class="fas fa-book mr-1"></i>145 lessons</span>
                            <span><i class="fas fa-users mr-1"></i>7.8K</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="text-2xl font-bold text-purple-600">GHS 2,150</div>
                            <a href="#" class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700 transition font-semibold">
                                Enroll Now
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Course 2 -->
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
                                <span class="text-gray-600 text-sm ml-1">(3,180)</span>
                            </span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Next.js Full Stack Mastery</h3>
                        <p class="text-gray-600 mb-4">Build production-ready full-stack apps with Next.js, React, and APIs.</p>
                        <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                            <span><i class="fas fa-clock mr-1"></i>100 hours</span>
                            <span><i class="fas fa-book mr-1"></i>125 lessons</span>
                            <span><i class="fas fa-users mr-1"></i>5.2K</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="text-2xl font-bold text-purple-600">GHS 2,030</div>
                            <a href="#" class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700 transition font-semibold">
                                Enroll Now
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Course 3 -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                    <div class="bg-red-600 h-48 flex items-center justify-center">
                        <div class="text-white text-center">
                            <i class="fab fa-angular text-6xl mb-2"></i>
                            <div class="text-xl font-bold">MEAN Stack</div>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="bg-blue-100 text-primary px-3 py-1 rounded-full text-sm font-semibold">Intermediate</span>
                            <span class="text-yellow-500">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                                <span class="text-gray-600 text-sm ml-1">(2,670)</span>
                            </span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">MEAN Stack Development</h3>
                        <p class="text-gray-600 mb-4">Build enterprise apps with MongoDB, Express, Angular, and Node.js.</p>
                        <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                            <span><i class="fas fa-clock mr-1"></i>110 hours</span>
                            <span><i class="fas fa-book mr-1"></i>135 lessons</span>
                            <span><i class="fas fa-users mr-1"></i>4.1K</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="text-2xl font-bold text-purple-600">GHS 1,910</div>
                            <a href="#" class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700 transition font-semibold">
                                Enroll Now
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Course 4 -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                    <div class="bg-pink-600 h-48 flex items-center justify-center">
                        <i class="fas fa-project-diagram text-white text-8xl"></i>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="bg-blue-100 text-primary px-3 py-1 rounded-full text-sm font-semibold">Intermediate</span>
                            <span class="text-yellow-500">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <span class="text-gray-600 text-sm ml-1">(2,340)</span>
                            </span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">GraphQL Full Stack</h3>
                        <p class="text-gray-600 mb-4">Build modern APIs with GraphQL, Apollo, React, and Node.js.</p>
                        <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                            <span><i class="fas fa-clock mr-1"></i>75 hours</span>
                            <span><i class="fas fa-book mr-1"></i>92 lessons</span>
                            <span><i class="fas fa-users mr-1"></i>3.6K</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="text-2xl font-bold text-purple-600">GHS 1,550</div>
                            <a href="#" class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700 transition font-semibold">
                                Enroll Now
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Course 5 -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                    <div class="bg-primary/80 h-48 flex items-center justify-center">
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
                                <span class="text-gray-600 text-sm ml-1">(1,890)</span>
                            </span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Full Stack DevOps</h3>
                        <p class="text-gray-600 mb-4">Deploy full-stack apps with Docker, CI/CD, and cloud platforms.</p>
                        <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                            <span><i class="fas fa-clock mr-1"></i>65 hours</span>
                            <span><i class="fas fa-book mr-1"></i>78 lessons</span>
                            <span><i class="fas fa-users mr-1"></i>2.8K</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="text-2xl font-bold text-purple-600">GHS 1,790</div>
                            <a href="#" class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700 transition font-semibold">
                                Enroll Now
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Course 6 -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                    <div class="bg-teal-600 h-48 flex items-center justify-center">
                        <i class="fas fa-laptop-code text-white text-8xl"></i>
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
                                <span class="text-gray-600 text-sm ml-1">(3,540)</span>
                            </span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Full Stack Bootcamp</h3>
                        <p class="text-gray-600 mb-4">Complete beginner to full-stack developer bootcamp program.</p>
                        <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                            <span><i class="fas fa-clock mr-1"></i>200 hours</span>
                            <span><i class="fas fa-book mr-1"></i>240 lessons</span>
                            <span><i class="fas fa-users mr-1"></i>9.2K</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="text-2xl font-bold text-purple-600">GHS 2,990</div>
                            <a href="#" class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700 transition font-semibold">
                                Enroll Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-12">
                <a href="<?= url('/courses') ?>" class="inline-flex items-center text-purple-600 hover:text-purple-700 font-semibold">
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
                            Full-stack developers are the most versatile and in-demand professionals. Work at:
                        </p>
                        
                        <div class="space-y-4">
                            <div class="flex items-start gap-4">
                                <div class="bg-green-100 text-green-600 w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 mb-1">Tech Companies</h4>
                                    <p class="text-gray-600">Build products from frontend to backend</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-4">
                                <div class="bg-green-100 text-green-600 w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 mb-1">Startups</h4>
                                    <p class="text-gray-600">Be the founding engineer building MVPs</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-4">
                                <div class="bg-green-100 text-green-600 w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 mb-1">Freelancing</h4>
                                    <p class="text-gray-600">Build complete solutions for clients</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-4">
                                <div class="bg-green-100 text-green-600 w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 mb-1">Your Own Business</h4>
                                    <p class="text-gray-600">Launch your own SaaS products</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-purple-50 rounded-lg p-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">Average Salaries</h3>
                        <div class="space-y-6">
                            <div>
                                <div class="flex justify-between items-center mb-2">
                                    <span class="font-semibold text-gray-900">Junior Full Stack Dev</span>
                                    <span class="font-bold text-purple-600">$55K - $75K</span>
                                </div>
                                <div class="bg-gray-200 h-2 rounded-full overflow-hidden">
                                    <div class="bg-green-500 h-full rounded-full" style="width: 50%"></div>
                                </div>
                            </div>
                            
                            <div>
                                <div class="flex justify-between items-center mb-2">
                                    <span class="font-semibold text-gray-900">Mid-Level Full Stack Dev</span>
                                    <span class="font-bold text-purple-600">$75K - $110K</span>
                                </div>
                                <div class="bg-gray-200 h-2 rounded-full overflow-hidden">
                                    <div class="bg-primary/90 h-full rounded-full" style="width: 70%"></div>
                                </div>
                            </div>
                            
                            <div>
                                <div class="flex justify-between items-center mb-2">
                                    <span class="font-semibold text-gray-900">Senior Full Stack Dev</span>
                                    <span class="font-bold text-purple-600">$110K - $165K</span>
                                </div>
                                <div class="bg-gray-200 h-2 rounded-full overflow-hidden">
                                    <div class="bg-purple-500 h-full rounded-full" style="width: 90%"></div>
                                </div>
                            </div>
                            
                            <div>
                                <div class="flex justify-between items-center mb-2">
                                    <span class="font-semibold text-gray-900">Lead Full Stack Architect</span>
                                    <span class="font-bold text-purple-600">$165K+</span>
                                </div>
                                <div class="bg-gray-200 h-2 rounded-full overflow-hidden">
                                    <div class="bg-red-500 h-full rounded-full" style="width: 100%"></div>
                                </div>
                            </div>
                        </div>
                        
                        <p class="text-sm text-gray-600 mt-6">
                            <i class="fas fa-info-circle mr-1"></i>
                            Full-stack developers command premium salaries due to versatility
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="bg-purple-600 text-white py-16">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Ready to Become a Full Stack Developer?</h2>
            <p class="text-xl text-purple-100 mb-8 max-w-2xl mx-auto">
                Join thousands of students building complete applications from frontend to backend
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="<?= url('/register') ?>" class="bg-white text-purple-600 px-8 py-4 rounded-lg font-semibold hover:bg-purple-50 transition inline-flex items-center">
                    <i class="fas fa-rocket mr-2"></i>Get Started Free
                </a>
                <a href="<?= url('/contact') ?>" class="bg-purple-700 text-white px-8 py-4 rounded-lg font-semibold hover:bg-purple-800 transition inline-flex items-center border-2 border-purple-500">
                    <i class="fas fa-comment mr-2"></i>Talk to an Advisor
                </a>
            </div>
        </div>
    </section>


