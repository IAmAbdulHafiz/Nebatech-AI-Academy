<!-- Hero Section -->
    <section class="relative bg-gradient-to-br from-pink-900 via-pink-700 to-pink-600 text-white py-20 overflow-hidden">
        <!-- Digital Horizon Background -->
        <div class="absolute inset-0 overflow-hidden">
            <!-- Horizon Glow Effect -->
            <div class="absolute bottom-0 left-0 right-0 h-96 bg-gradient-to-t from-pink-500/30 via-pink-400/10 to-transparent"></div>
            <div class="absolute top-0 left-0 right-0 h-96 bg-gradient-to-b from-pink-800/50 via-transparent to-transparent"></div>
            
            <!-- Geometric Light Beams -->
            <div class="absolute inset-0">
                <div class="absolute top-0 left-1/4 w-1 h-full bg-gradient-to-b from-pink-400/40 via-pink-400/20 to-transparent transform -skew-x-12 animate-pulse" style="animation-duration: 3s;"></div>
                <div class="absolute top-0 right-1/3 w-1 h-full bg-gradient-to-b from-pink-300/30 via-pink-300/10 to-transparent transform skew-x-12 animate-pulse" style="animation-duration: 4s; animation-delay: 1s;"></div>
                <div class="absolute top-0 left-2/3 w-0.5 h-full bg-gradient-to-b from-pink-400/30 via-transparent to-transparent transform -skew-x-6 animate-pulse" style="animation-duration: 5s; animation-delay: 2s;"></div>
            </div>
            
            <!-- Dynamic Glowing Orbs -->
            <div class="absolute top-20 left-10 w-96 h-96 bg-pink-500/40 rounded-full blur-3xl animate-pulse" style="animation-duration: 6s;"></div>
            <div class="absolute bottom-10 right-10 w-[500px] h-[500px] bg-pink-400/30 rounded-full blur-3xl animate-pulse" style="animation-duration: 8s; animation-delay: 1s;"></div>
            
            <!-- Mobile Dev Icons Floating -->
            <div class="absolute top-1/4 left-[10%] opacity-20 animate-float" style="animation-duration: 6s;">
                <i class="fas fa-mobile-alt text-6xl text-pink-300"></i>
            </div>
            <div class="absolute top-1/3 right-[15%] opacity-20 animate-float" style="animation-duration: 7s; animation-delay: 1s;">
                <i class="fab fa-apple text-6xl text-pink-200"></i>
            </div>
            <div class="absolute bottom-1/4 left-[20%] opacity-20 animate-float" style="animation-duration: 8s; animation-delay: 2s;">
                <i class="fab fa-android text-6xl text-pink-300"></i>
            </div>
            <div class="absolute bottom-1/3 right-[12%] opacity-20 animate-float" style="animation-duration: 6.5s; animation-delay: 0.5s;">
                <i class="fab fa-react text-6xl text-pink-200"></i>
            </div>
        </div>
        
        <!-- Content -->
        <div class="container mx-auto px-4 relative z-10">
            <div class="max-w-4xl mx-auto text-center">
                <div class="inline-block bg-pink-800/60 backdrop-blur-sm text-pink-100 px-4 py-2 rounded-full text-sm font-semibold mb-6 border border-pink-400/30">
                    <i class="fas fa-mobile-alt mr-2"></i>Mobile Development
                </div>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6">
                    Master Mobile App Development
                </h1>
                <p class="text-xl md:text-2xl text-pink-100 mb-8">
                    Build native iOS and Android apps, or create cross-platform solutions with React Native and Flutter
                </p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="#courses" class="bg-white text-pink-600 px-8 py-4 rounded-lg font-semibold hover:bg-pink-50 transition inline-flex items-center shadow-lg hover:shadow-xl">
                        <i class="fas fa-rocket mr-2"></i>Browse Courses
                    </a>
                    <a href="<?= url('/register') ?>" class="bg-pink-800/60 backdrop-blur-sm text-white px-8 py-4 rounded-lg font-semibold hover:bg-pink-800 transition inline-flex items-center border-2 border-pink-400/50 shadow-lg">
                        <i class="fas fa-user-plus mr-2"></i>Get Started Free
                    </a>
                </div>

                <!-- Quick Stats -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-12">
                    <div class="backdrop-blur-sm bg-white/10 rounded-lg p-4 border border-pink-400/20">
                        <div class="text-3xl font-bold">20+</div>
                        <div class="text-pink-200 text-sm">Modules</div>
                    </div>
                    <div class="backdrop-blur-sm bg-white/10 rounded-lg p-4 border border-pink-400/20">
                        <div class="text-3xl font-bold">7,400+</div>
                        <div class="text-pink-200 text-sm">Students</div>
                    </div>
                    <div class="backdrop-blur-sm bg-white/10 rounded-lg p-4 border border-pink-400/20">
                        <div class="text-3xl font-bold">280+</div>
                        <div class="text-pink-200 text-sm">Hours Content</div>
                    </div>
                    <div class="backdrop-blur-sm bg-white/10 rounded-lg p-4 border border-pink-400/20">
                        <div class="text-3xl font-bold">96%</div>
                        <div class="text-pink-200 text-sm">Success Rate</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Learning Path -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Your Mobile Development Path</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Choose your path: native development or cross-platform solutions
                </p>
            </div>

            <div class="max-w-5xl mx-auto">
                <div class="space-y-8">
                    <!-- Path 1: iOS Native -->
                    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-gray-800">
                        <div class="flex items-start gap-4">
                            <div class="bg-gray-800 text-white w-12 h-12 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fab fa-apple"></i>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    <h3 class="text-xl font-bold text-gray-900">iOS Development</h3>
                                    <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm font-semibold">6-12 months</span>
                                </div>
                                <p class="text-gray-600 mb-4">Build native iPhone and iPad applications</p>
                                <div class="flex flex-wrap gap-2">
                                    <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-lg text-sm font-medium">Swift</span>
                                    <span class="bg-blue-100 text-primary px-3 py-1 rounded-lg text-sm font-medium">SwiftUI</span>
                                    <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-lg text-sm font-medium">UIKit</span>
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-lg text-sm font-medium">Core Data</span>
                                    <span class="bg-pink-100 text-pink-700 px-3 py-1 rounded-lg text-sm font-medium">Xcode</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Path 2: Android Native -->
                    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-600">
                        <div class="flex items-start gap-4">
                            <div class="bg-green-600 text-white w-12 h-12 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fab fa-android"></i>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    <h3 class="text-xl font-bold text-gray-900">Android Development</h3>
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-semibold">6-12 months</span>
                                </div>
                                <p class="text-gray-600 mb-4">Build native Android applications</p>
                                <div class="flex flex-wrap gap-2">
                                    <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-lg text-sm font-medium">Kotlin</span>
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-lg text-sm font-medium">Jetpack Compose</span>
                                    <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-lg text-sm font-medium">Java</span>
                                    <span class="bg-blue-100 text-primary px-3 py-1 rounded-lg text-sm font-medium">Android Studio</span>
                                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-lg text-sm font-medium">Material Design</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Path 3: React Native -->
                    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-primary/90">
                        <div class="flex items-start gap-4">
                            <div class="bg-primary/90 text-white w-12 h-12 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fab fa-react"></i>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    <h3 class="text-xl font-bold text-gray-900">React Native</h3>
                                    <span class="bg-blue-100 text-primary px-3 py-1 rounded-full text-sm font-semibold">4-8 months</span>
                                </div>
                                <p class="text-gray-600 mb-4">Build cross-platform apps with JavaScript</p>
                                <div class="flex flex-wrap gap-2">
                                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-lg text-sm font-medium">JavaScript</span>
                                    <span class="bg-blue-100 text-primary px-3 py-1 rounded-lg text-sm font-medium">React</span>
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-lg text-sm font-medium">Expo</span>
                                    <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-lg text-sm font-medium">Redux</span>
                                    <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-lg text-sm font-medium">Native Modules</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Path 4: Flutter -->
                    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-white/30">
                        <div class="flex items-start gap-4">
                            <div class="bg-blue-400 text-white w-12 h-12 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-mobile-alt"></i>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    <h3 class="text-xl font-bold text-gray-900">Flutter Development</h3>
                                    <span class="bg-blue-100 text-primary px-3 py-1 rounded-full text-sm font-semibold">4-8 months</span>
                                </div>
                                <p class="text-gray-600 mb-4">Build beautiful cross-platform apps with Dart</p>
                                <div class="flex flex-wrap gap-2">
                                    <span class="bg-blue-100 text-primary px-3 py-1 rounded-lg text-sm font-medium">Dart</span>
                                    <span class="bg-teal-100 text-teal-700 px-3 py-1 rounded-lg text-sm font-medium">Flutter Widgets</span>
                                    <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-lg text-sm font-medium">Material Design</span>
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-lg text-sm font-medium">State Management</span>
                                    <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-lg text-sm font-medium">Firebase</span>
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
                    Master the skills needed to build professional mobile applications
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
                <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-primary/90">
                    <div class="text-primary text-4xl mb-4">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">UI/UX Design</h3>
                    <p class="text-gray-600">Create beautiful, intuitive mobile interfaces that users love.</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-green-500">
                    <div class="text-green-600 text-4xl mb-4">
                        <i class="fas fa-link"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">API Integration</h3>
                    <p class="text-gray-600">Connect mobile apps to backend services and third-party APIs.</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-purple-500">
                    <div class="text-purple-600 text-4xl mb-4">
                        <i class="fas fa-database"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Local Storage</h3>
                    <p class="text-gray-600">Implement offline functionality and data persistence.</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-orange-500">
                    <div class="text-orange-600 text-4xl mb-4">
                        <i class="fas fa-bell"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Push Notifications</h3>
                    <p class="text-gray-600">Engage users with timely notifications and updates.</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-red-500">
                    <div class="text-red-600 text-4xl mb-4">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Authentication</h3>
                    <p class="text-gray-600">Implement secure login, registration, and user management.</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-yellow-500">
                    <div class="text-yellow-600 text-4xl mb-4">
                        <i class="fas fa-rocket"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">App Deployment</h3>
                    <p class="text-gray-600">Publish apps to App Store and Google Play Store.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Courses Listing -->
    <section id="courses" class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <!-- Bundle Pricing Banner -->
            <div class="max-w-4xl mx-auto mb-12">
                <div class="bg-gradient-to-r from-pink-600 to-pink-700 rounded-2xl p-8 text-white shadow-xl">
                    <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                        <div class="flex-1 text-center md:text-left">
                            <h3 class="text-2xl md:text-3xl font-bold mb-2">Complete Mobile Development Track Bundle</h3>
                            <p class="text-pink-100 mb-3">Get all 6 courses + certifications + lifetime access</p>
                            <div class="flex items-center gap-4 justify-center md:justify-start">
                                <span class="text-lg line-through text-pink-200">GHS 17,360</span>
                                <span class="bg-yellow-400 text-gray-900 px-4 py-1 rounded-full font-bold text-sm">Save 28%</span>
                            </div>
                        </div>
                        <div class="text-center">
                            <div class="text-5xl font-bold mb-2">GHS 12,500</div>
                            <a href="<?= url('/courses/mobile/enroll') ?>" class="inline-block bg-white text-pink-600 px-8 py-3 rounded-lg font-bold hover:bg-pink-50 transition shadow-lg">
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
                    <div class="bg-gray-900 h-48 flex items-center justify-center">
                        <i class="fab fa-apple text-white text-8xl"></i>
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
                        <h3 class="text-xl font-bold text-gray-900 mb-2">iOS Development with Swift</h3>
                        <p class="text-gray-600 mb-4">Build native iOS apps with Swift, SwiftUI, and UIKit.</p>
                        <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                            <span><i class="fas fa-clock mr-1"></i>85 hours</span>
                            <span><i class="fas fa-book mr-1"></i>102 lessons</span>
                            <span><i class="fas fa-users mr-1"></i>4.2K</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="text-2xl font-bold text-teal-600">GHS 2,750</div>
                            <a href="#" class="bg-teal-600 text-white px-6 py-2 rounded-lg hover:bg-teal-700 transition font-semibold">
                                Enroll Now
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Course 2 -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                    <div class="bg-green-600 h-48 flex items-center justify-center">
                        <i class="fab fa-android text-white text-8xl"></i>
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
                                <span class="text-gray-600 text-sm ml-1">(3,120)</span>
                            </span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Android with Kotlin</h3>
                        <p class="text-gray-600 mb-4">Master Android development with Kotlin and Jetpack Compose.</p>
                        <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                            <span><i class="fas fa-clock mr-1"></i>90 hours</span>
                            <span><i class="fas fa-book mr-1"></i>112 lessons</span>
                            <span><i class="fas fa-users mr-1"></i>5.6K</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="text-2xl font-bold text-teal-600">GHS 2,750</div>
                            <a href="#" class="bg-teal-600 text-white px-6 py-2 rounded-lg hover:bg-teal-700 transition font-semibold">
                                Enroll Now
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Course 3 -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                    <div class="bg-primary/90 h-48 flex items-center justify-center">
                        <i class="fab fa-react text-white text-8xl"></i>
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
                                <span class="text-gray-600 text-sm ml-1">(4,890)</span>
                            </span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">React Native Complete</h3>
                        <p class="text-gray-600 mb-4">Build cross-platform apps with React Native and Expo.</p>
                        <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                            <span><i class="fas fa-clock mr-1"></i>95 hours</span>
                            <span><i class="fas fa-book mr-1"></i>118 lessons</span>
                            <span><i class="fas fa-users mr-1"></i>8.2K</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="text-2xl font-bold text-teal-600">GHS 3,150</div>
                            <a href="#" class="bg-teal-600 text-white px-6 py-2 rounded-lg hover:bg-teal-700 transition font-semibold">
                                Enroll Now
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Course 4 -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                    <div class="bg-blue-400 h-48 flex items-center justify-center">
                        <div class="text-white text-6xl font-bold">Flutter</div>
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
                                <span class="text-gray-600 text-sm ml-1">(3,650)</span>
                            </span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Flutter & Dart Mastery</h3>
                        <p class="text-gray-600 mb-4">Create beautiful cross-platform apps with Flutter and Dart.</p>
                        <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                            <span><i class="fas fa-clock mr-1"></i>88 hours</span>
                            <span><i class="fas fa-book mr-1"></i>108 lessons</span>
                            <span><i class="fas fa-users mr-1"></i>6.4K</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="text-2xl font-bold text-teal-600">GHS 3,150</div>
                            <a href="#" class="bg-teal-600 text-white px-6 py-2 rounded-lg hover:bg-teal-700 transition font-semibold">
                                Enroll Now
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Course 5 -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                    <div class="bg-orange-500 h-48 flex items-center justify-center">
                        <i class="fas fa-fire text-white text-8xl"></i>
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
                                <span class="text-gray-600 text-sm ml-1">(2,180)</span>
                            </span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Firebase for Mobile Apps</h3>
                        <p class="text-gray-600 mb-4">Integrate Firebase services into your mobile applications.</p>
                        <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                            <span><i class="fas fa-clock mr-1"></i>45 hours</span>
                            <span><i class="fas fa-book mr-1"></i>56 lessons</span>
                            <span><i class="fas fa-users mr-1"></i>3.8K</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="text-2xl font-bold text-teal-600">GHS 2,510</div>
                            <a href="#" class="bg-teal-600 text-white px-6 py-2 rounded-lg hover:bg-teal-700 transition font-semibold">
                                Enroll Now
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Course 6 -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                    <div class="bg-purple-600 h-48 flex items-center justify-center">
                        <i class="fas fa-rocket text-white text-8xl"></i>
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
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Publishing to App Stores</h3>
                        <p class="text-gray-600 mb-4">Deploy your apps to Apple App Store and Google Play Store.</p>
                        <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                            <span><i class="fas fa-clock mr-1"></i>30 hours</span>
                            <span><i class="fas fa-book mr-1"></i>38 lessons</span>
                            <span><i class="fas fa-users mr-1"></i>2.6K</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="text-2xl font-bold text-teal-600">GHS 3,050</div>
                            <a href="#" class="bg-teal-600 text-white px-6 py-2 rounded-lg hover:bg-teal-700 transition font-semibold">
                                Enroll Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-12">
                <a href="<?= url('/courses') ?>" class="inline-flex items-center text-teal-600 hover:text-teal-700 font-semibold">
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
                            Mobile developers are in high demand as mobile usage continues to grow. Work at:
                        </p>
                        
                        <div class="space-y-4">
                            <div class="flex items-start gap-4">
                                <div class="bg-green-100 text-green-600 w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 mb-1">Mobile-First Companies</h4>
                                    <p class="text-gray-600">Instagram, TikTok, Uber, Airbnb, and more</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-4">
                                <div class="bg-green-100 text-green-600 w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 mb-1">App Startups</h4>
                                    <p class="text-gray-600">Build the next big mobile application</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-4">
                                <div class="bg-green-100 text-green-600 w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 mb-1">Enterprise</h4>
                                    <p class="text-gray-600">Build mobile solutions for large organizations</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-4">
                                <div class="bg-green-100 text-green-600 w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 mb-1">Freelance</h4>
                                    <p class="text-gray-600">Build apps for clients worldwide</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-teal-50 rounded-lg p-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">Average Salaries</h3>
                        <div class="space-y-6">
                            <div>
                                <div class="flex justify-between items-center mb-2">
                                    <span class="font-semibold text-gray-900">Junior Mobile Developer</span>
                                    <span class="font-bold text-teal-600">$50K - $70K</span>
                                </div>
                                <div class="bg-gray-200 h-2 rounded-full overflow-hidden">
                                    <div class="bg-green-500 h-full rounded-full" style="width: 45%"></div>
                                </div>
                            </div>
                            
                            <div>
                                <div class="flex justify-between items-center mb-2">
                                    <span class="font-semibold text-gray-900">Mid-Level Mobile Developer</span>
                                    <span class="font-bold text-teal-600">$70K - $100K</span>
                                </div>
                                <div class="bg-gray-200 h-2 rounded-full overflow-hidden">
                                    <div class="bg-primary/90 h-full rounded-full" style="width: 65%"></div>
                                </div>
                            </div>
                            
                            <div>
                                <div class="flex justify-between items-center mb-2">
                                    <span class="font-semibold text-gray-900">Senior Mobile Developer</span>
                                    <span class="font-bold text-teal-600">$100K - $150K</span>
                                </div>
                                <div class="bg-gray-200 h-2 rounded-full overflow-hidden">
                                    <div class="bg-purple-500 h-full rounded-full" style="width: 85%"></div>
                                </div>
                            </div>
                            
                            <div>
                                <div class="flex justify-between items-center mb-2">
                                    <span class="font-semibold text-gray-900">Mobile Architect</span>
                                    <span class="font-bold text-teal-600">$150K+</span>
                                </div>
                                <div class="bg-gray-200 h-2 rounded-full overflow-hidden">
                                    <div class="bg-red-500 h-full rounded-full" style="width: 100%"></div>
                                </div>
                            </div>
                        </div>
                        
                        <p class="text-sm text-gray-600 mt-6">
                            <i class="fas fa-info-circle mr-1"></i>
                            Mobile developers with native and cross-platform skills earn more
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="bg-teal-600 text-white py-16">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Ready to Build Amazing Mobile Apps?</h2>
            <p class="text-xl text-teal-100 mb-8 max-w-2xl mx-auto">
                Join thousands of students creating mobile applications for iOS and Android
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="<?= url('/register') ?>" class="bg-white text-teal-600 px-8 py-4 rounded-lg font-semibold hover:bg-teal-50 transition inline-flex items-center">
                    <i class="fas fa-rocket mr-2"></i>Get Started Free
                </a>
                <a href="<?= url('/contact') ?>" class="bg-teal-700 text-white px-8 py-4 rounded-lg font-semibold hover:bg-teal-800 transition inline-flex items-center border-2 border-teal-500">
                    <i class="fas fa-comment mr-2"></i>Talk to an Advisor
                </a>
            </div>
        </div>
    </section>


