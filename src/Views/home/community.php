<!DOCTYPE html>
<html lang="en" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" 
      :class="{ 'dark': darkMode }" 
      @darkmode-toggle.window="darkMode = $event.detail; localStorage.setItem('darkMode', darkMode)">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Community - Nebatech AI Academy</title>
    <link rel="stylesheet" href="<?= asset('css/main.css') ?>">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-gray-50 dark:bg-gray-900 transition-colors duration-200">
    <?php include __DIR__ . '/../partials/header.php'; ?>

    <!-- Hero Section -->
    <section class="relative bg-gradient-to-br from-primary via-primary/90 to-primary/80 text-white py-20 overflow-hidden">
        <!-- Digital Horizon Background -->
        <div class="absolute inset-0 overflow-hidden">
            <!-- Horizon Glow Effect -->
            <div class="absolute bottom-0 left-0 right-0 h-96 bg-gradient-to-t from-blue-500/30 via-blue-400/10 to-transparent"></div>
            <div class="absolute top-0 left-0 right-0 h-96 bg-gradient-to-b from-indigo-800/50 via-transparent to-transparent"></div>
            
            <!-- Geometric Light Beams -->
            <div class="absolute inset-0">
                <div class="absolute top-0 left-1/4 w-1 h-full bg-gradient-to-b from-blue-400/40 via-blue-400/20 to-transparent transform -skew-x-12 animate-pulse" style="animation-duration: 3s;"></div>
                <div class="absolute top-0 right-1/3 w-1 h-full bg-gradient-to-b from-indigo-300/30 via-indigo-300/10 to-transparent transform skew-x-12 animate-pulse" style="animation-duration: 4s; animation-delay: 1s;"></div>
                <div class="absolute top-0 left-2/3 w-0.5 h-full bg-gradient-to-b from-blue-400/30 via-transparent to-transparent transform -skew-x-6 animate-pulse" style="animation-duration: 5s; animation-delay: 2s;"></div>
            </div>
            
            <!-- Dynamic Glowing Orbs -->
            <div class="absolute top-20 left-10 w-96 h-96 bg-primary/90/40 rounded-full blur-3xl animate-pulse" style="animation-duration: 6s;"></div>
            <div class="absolute bottom-10 right-10 w-[500px] h-[500px] bg-indigo-400/30 rounded-full blur-3xl animate-pulse" style="animation-duration: 8s; animation-delay: 1s;"></div>
            <div class="absolute top-1/3 right-1/4 w-64 h-64 bg-primary/90/20 rounded-full blur-2xl animate-pulse" style="animation-duration: 7s; animation-delay: 2s;"></div>
            
            <!-- Floating Community Icons -->
            <div class="absolute top-1/4 left-[10%] opacity-20 animate-float" style="animation-duration: 6s;">
                <i class="fas fa-users text-6xl text-white/80"></i>
            </div>
            <div class="absolute top-1/3 right-[12%] opacity-20 animate-float" style="animation-duration: 7s; animation-delay: 1s;">
                <i class="fas fa-comments text-6xl text-indigo-200"></i>
            </div>
            <div class="absolute bottom-1/4 left-[18%] opacity-20 animate-float" style="animation-duration: 8s; animation-delay: 2s;">
                <i class="fas fa-heart text-6xl text-white/80"></i>
            </div>
            <div class="absolute bottom-1/3 right-[15%] opacity-20 animate-float" style="animation-duration: 6.5s; animation-delay: 0.5s;">
                <i class="fas fa-globe text-6xl text-indigo-200"></i>
            </div>
            <div class="absolute top-[45%] left-[25%] opacity-20 animate-float" style="animation-duration: 7.5s; animation-delay: 1.5s;">
                <i class="fas fa-handshake text-6xl text-white/70"></i>
            </div>
        </div>
        
        <!-- Content -->
        <div class="container mx-auto px-6 text-center relative z-10">
            <div class="max-w-4xl mx-auto">
                <div class="inline-block bg-primary/80/60 backdrop-blur-sm px-6 py-2 rounded-full text-white text-sm font-semibold mb-6 border border-white/30/30">
                    <i class="fas fa-users mr-2"></i>Active Learning Community
                </div>
                <h1 class="text-4xl md:text-6xl font-bold mb-6">
                    Join Our Active Learning Community
                </h1>
                <p class="text-xl md:text-2xl text-white/90 max-w-3xl mx-auto mb-8">
                    Connect with thousands of students, share resources, and grow together in a vibrant tech community 🌍
                </p>
                
                <!-- Stats -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-12">
                    <div class="backdrop-blur-sm bg-white/10 rounded-lg p-4 border border-white/30/20">
                        <div class="text-3xl font-bold">10,000+</div>
                        <div class="text-white/70 text-sm">Active Members</div>
                    </div>
                    <div class="backdrop-blur-sm bg-white/10 rounded-lg p-4 border border-white/30/20">
                        <div class="text-3xl font-bold">500+</div>
                        <div class="text-white/70 text-sm">Daily Posts</div>
                    </div>
                    <div class="backdrop-blur-sm bg-white/10 rounded-lg p-4 border border-white/30/20">
                        <div class="text-3xl font-bold">50+</div>
                        <div class="text-white/70 text-sm">Study Groups</div>
                    </div>
                    <div class="backdrop-blur-sm bg-white/10 rounded-lg p-4 border border-white/30/20">
                        <div class="text-3xl font-bold">24/7</div>
                        <div class="text-white/70 text-sm">Support Available</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Live Activity Feed Section -->
    <section class="py-16 bg-gray-50 dark:bg-gray-800">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-800 dark:text-gray-200 mb-4">🔴 Live Activity Feed</h2>
                <p class="text-xl text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">See what students are learning right now in our community</p>
            </div>

            <div class="max-w-4xl mx-auto bg-white dark:bg-gray-700 rounded-2xl shadow-xl p-8">
                <div class="flex items-center justify-between mb-6 border-b border-gray-200 dark:border-gray-600 pb-4">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-gray-200 flex items-center">
                        <span class="w-3 h-3 bg-red-500 rounded-full mr-2 animate-pulse"></span>
                        Live Activity
                    </h3>
                    <span class="text-sm text-gray-500 dark:text-gray-400">Updated in real-time</span>
                </div>

                <div class="space-y-4 max-h-[600px] overflow-y-auto">
                    <?php if (!empty($activities)): ?>
                        <?php 
                        $colors = ['blue', 'green', 'orange', 'red', 'purple'];
                        foreach ($activities as $index => $activity): 
                            $color = $colors[$index % count($colors)];
                            $firstName = htmlspecialchars($activity['first_name'] ?? 'Student');
                            $lastName = htmlspecialchars($activity['last_name'] ?? 'User');
                            $initials = strtoupper(substr($firstName, 0, 1) . substr($lastName, 0, 1));
                        ?>
                        <div class="flex items-center p-4 bg-gray-50 dark:bg-gray-600 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-500 transition-colors animate-fade-in" 
                             style="animation-delay: <?= $index * 0.1 ?>s">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center text-white font-bold mr-4 flex-shrink-0 bg-<?= $color ?>-500">
                                <?= $initials ?>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-gray-800 dark:text-gray-200">
                                    <span class="font-semibold"><?= $firstName ?> <?= substr($lastName, 0, 1) ?>.</span>
                                    <span> <?= htmlspecialchars($activity['action_text']) ?> </span>
                                    <span class="font-semibold text-primary"><?= htmlspecialchars($activity['course_title'] ?? 'a course') ?></span>
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400"><?= htmlspecialchars($activity['time_ago']) ?></p>
                            </div>
                            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                            <p class="text-lg">No recent activity to display</p>
                            <p class="text-sm mt-2">Be the first to start learning!</p>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="mt-8 text-center bg-blue-50 dark:bg-primary/90/20 p-6 rounded-lg border-2 border-white/10 dark:border-primary/80">
                    <p class="text-gray-700 dark:text-gray-300 font-semibold mb-2">🎉 <span class="text-primary"><?= $todayEnrollments ?> students</span> enrolled in courses today</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Be part of our growing community of learners</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Community Stats Section -->
    <section class="py-16 bg-white dark:bg-gray-900">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-800 dark:text-gray-200 mb-4">Community at a Glance</h2>
                <p class="text-xl text-gray-600 dark:text-gray-400">Real-time statistics from our learning community</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Stat 1 -->
                <div class="bg-gradient-to-br from-primary/90 to-primary text-white rounded-xl shadow-lg p-8 text-center transform hover:scale-105 transition-transform">
                    <div class="text-5xl font-bold mb-2"><?= number_format($stats['totalStudents']) ?></div>
                    <div class="text-lg opacity-90">Active Students</div>
                    <div class="text-sm opacity-75 mt-2">Growing community</div>
                </div>

                <!-- Stat 2 -->
                <div class="bg-gradient-to-br from-green-500 to-green-600 text-white rounded-xl shadow-lg p-8 text-center transform hover:scale-105 transition-transform">
                    <div class="text-5xl font-bold mb-2"><?= number_format($stats['certificatesIssued']) ?></div>
                    <div class="text-lg opacity-90">Certificates Earned</div>
                    <div class="text-sm opacity-75 mt-2">Achievements unlocked</div>
                </div>

                <!-- Stat 3 -->
                <div class="bg-gradient-to-br from-orange-500 to-orange-600 text-white rounded-xl shadow-lg p-8 text-center transform hover:scale-105 transition-transform">
                    <div class="text-5xl font-bold mb-2"><?= number_format($stats['totalEnrollments']) ?></div>
                    <div class="text-lg opacity-90">Course Enrollments</div>
                    <div class="text-sm opacity-75 mt-2">Learning journeys</div>
                </div>

                <!-- Stat 4 -->
                <div class="bg-gradient-to-br from-purple-500 to-purple-600 text-white rounded-xl shadow-lg p-8 text-center transform hover:scale-105 transition-transform">
                    <div class="text-5xl font-bold mb-2"><?= $stats['totalCourses'] ?></div>
                    <div class="text-lg opacity-90">Active Courses</div>
                    <div class="text-sm opacity-75 mt-2">Available to learn</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Popular Courses in Community -->
    <section class="py-16 bg-gray-50 dark:bg-gray-800">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-800 dark:text-gray-200 mb-4">What the Community is Learning</h2>
                <p class="text-xl text-gray-600 dark:text-gray-400">Most popular courses this week</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
                <!-- Course 1 -->
                <div class="bg-white dark:bg-gray-700 rounded-xl shadow-lg overflow-hidden transform hover:scale-105 transition-transform">
                    <div class="bg-primary/90 p-6 text-white">
                        <div class="text-4xl mb-2">💻</div>
                        <h3 class="text-2xl font-bold">Full Stack Development</h3>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <span class="text-yellow-400 mr-2">⭐⭐⭐⭐⭐</span>
                            <span class="text-gray-600 dark:text-gray-400">4.9 (2,847 reviews)</span>
                        </div>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">🔥 1,234 students enrolled this week</p>
                        <a href="<?= url('/courses/full-stack-development') ?>" class="block text-center bg-primary hover:bg-primary/70 text-white font-bold py-3 rounded-lg transition-colors">
                            View Course
                        </a>
                    </div>
                </div>

                <!-- Course 2 -->
                <div class="bg-white dark:bg-gray-700 rounded-xl shadow-lg overflow-hidden transform hover:scale-105 transition-transform">
                    <div class="bg-green-500 p-6 text-white">
                        <div class="text-4xl mb-2">🐍</div>
                        <h3 class="text-2xl font-bold">Python Programming</h3>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <span class="text-yellow-400 mr-2">⭐⭐⭐⭐⭐</span>
                            <span class="text-gray-600 dark:text-gray-400">4.8 (3,156 reviews)</span>
                        </div>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">🔥 987 students enrolled this week</p>
                        <a href="<?= url('/courses/python-programming') ?>" class="block text-center bg-green-500 hover:bg-green-600 text-white font-bold py-3 rounded-lg transition-colors">
                            View Course
                        </a>
                    </div>
                </div>

                <!-- Course 3 -->
                <div class="bg-white dark:bg-gray-700 rounded-xl shadow-lg overflow-hidden transform hover:scale-105 transition-transform">
                    <div class="bg-orange-500 p-6 text-white">
                        <div class="text-4xl mb-2">🤖</div>
                        <h3 class="text-2xl font-bold">AI & Machine Learning</h3>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <span class="text-yellow-400 mr-2">⭐⭐⭐⭐⭐</span>
                            <span class="text-gray-600 dark:text-gray-400">4.9 (1,923 reviews)</span>
                        </div>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">🔥 856 students enrolled this week</p>
                        <a href="<?= url('/courses/ai-machine-learning') ?>" class="block text-center bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 rounded-lg transition-colors">
                            View Course
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Community Features -->
    <section class="py-16 bg-white dark:bg-gray-900">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-800 dark:text-gray-200 mb-4">Community Benefits</h2>
                <p class="text-xl text-gray-600 dark:text-gray-400">Why thousands of students love learning with us</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
                <!-- Feature 1 -->
                <div class="text-center p-8 bg-gray-50 dark:bg-gray-800 rounded-xl">
                    <div class="text-5xl mb-4">💬</div>
                    <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-3">Peer Support</h3>
                    <p class="text-gray-600 dark:text-gray-400">Connect with fellow students, share knowledge, and solve problems together</p>
                </div>

                <!-- Feature 2 -->
                <div class="text-center p-8 bg-gray-50 dark:bg-gray-800 rounded-xl">
                    <div class="text-5xl mb-4">🏆</div>
                    <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-3">Friendly Competition</h3>
                    <p class="text-gray-600 dark:text-gray-400">Track your progress on leaderboards and celebrate achievements</p>
                </div>

                <!-- Feature 3 -->
                <div class="text-center p-8 bg-gray-50 dark:bg-gray-800 rounded-xl">
                    <div class="text-5xl mb-4">👥</div>
                    <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-3">Study Groups</h3>
                    <p class="text-gray-600 dark:text-gray-400">Join or create study groups to learn collaboratively</p>
                </div>

                <!-- Feature 4 -->
                <div class="text-center p-8 bg-gray-50 dark:bg-gray-800 rounded-xl">
                    <div class="text-5xl mb-4">📅</div>
                    <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-3">Live Events</h3>
                    <p class="text-gray-600 dark:text-gray-400">Attend workshops, webinars, and coding challenges</p>
                </div>

                <!-- Feature 5 -->
                <div class="text-center p-8 bg-gray-50 dark:bg-gray-800 rounded-xl">
                    <div class="text-5xl mb-4">🎓</div>
                    <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-3">Expert Mentorship</h3>
                    <p class="text-gray-600 dark:text-gray-400">Get guidance from industry professionals and instructors</p>
                </div>

                <!-- Feature 6 -->
                <div class="text-center p-8 bg-gray-50 dark:bg-gray-800 rounded-xl">
                    <div class="text-5xl mb-4">🌟</div>
                    <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-3">Showcase Projects</h3>
                    <p class="text-gray-600 dark:text-gray-400">Share your work and get feedback from the community</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-gradient-to-br from-primary to-blue-900 text-white">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-4xl font-bold mb-4">Ready to Join Our Community?</h2>
            <p class="text-xl mb-8 max-w-2xl mx-auto">Start learning with thousands of motivated students today. It's completely free!</p>
            <a href="<?= url('/register') ?>" class="bg-secondary hover:bg-orange-600 text-white font-bold text-lg px-12 py-4 rounded-lg transition-all transform hover:scale-105 inline-block shadow-xl">
                Join Community Free
            </a>
            <p class="mt-4 text-sm opacity-90">No credit card required • Cancel anytime • Join 15,847 students</p>
        </div>
    </section>

    <?php include __DIR__ . '/../partials/footer.php'; ?>
</body>
</html>


