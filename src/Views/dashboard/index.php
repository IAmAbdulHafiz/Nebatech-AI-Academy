<!-- Welcome Section -->
        <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg shadow-lg p-8 text-white mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold mb-2">Welcome back, <?= htmlspecialchars($user['first_name']) ?>!</h1>
                    <p class="text-blue-100">Continue your learning journey</p>
                </div>
                <div class="hidden md:block">
                    <i class="fas fa-graduation-cap text-6xl opacity-20"></i>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="grid md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Enrolled Courses</p>
                        <p class="text-3xl font-bold text-blue-600">0</p>
                    </div>
                    <div class="bg-blue-100 rounded-full p-3">
                        <i class="fas fa-book text-blue-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Completed</p>
                        <p class="text-3xl font-bold text-green-600">0</p>
                    </div>
                    <div class="bg-green-100 rounded-full p-3">
                        <i class="fas fa-check-circle text-green-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Certificates</p>
                        <p class="text-3xl font-bold text-purple-600">0</p>
                    </div>
                    <div class="bg-purple-100 rounded-full p-3">
                        <i class="fas fa-certificate text-purple-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Learning Hours</p>
                        <p class="text-3xl font-bold text-orange-600">0</p>
                    </div>
                    <div class="bg-orange-100 rounded-full p-3">
                        <i class="fas fa-clock text-orange-600 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="md:col-span-2 space-y-6">
                <!-- Continue Learning -->
                <div class="bg-white rounded-lg shadow">
                    <div class="p-6 border-b border-gray-200">
                        <h2 class="text-xl font-bold text-gray-900">Continue Learning</h2>
                    </div>
                    <div class="p-6">
                        <div class="text-center py-12">
                            <i class="fas fa-book-open text-6xl text-gray-300 mb-4"></i>
                            <p class="text-gray-600 mb-4">You haven't enrolled in any courses yet</p>
                            <a href="<?= url('/courses') ?>" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                                Browse Courses
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Recommended Courses -->
                <div class="bg-white rounded-lg shadow">
                    <div class="p-6 border-b border-gray-200">
                        <h2 class="text-xl font-bold text-gray-900">Recommended for You</h2>
                    </div>
                    <div class="p-6">
                        <div class="grid md:grid-cols-2 gap-6">
                            <!-- Sample Course Card -->
                            <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-md transition">
                                <div class="bg-blue-600 h-32 flex items-center justify-center">
                                    <i class="fas fa-code text-white text-4xl"></i>
                                </div>
                                <div class="p-4">
                                    <h3 class="font-bold text-gray-900 mb-2">Frontend Development</h3>
                                    <p class="text-sm text-gray-600 mb-3">15+ courses • 5,000+ students</p>
                                    <a href="<?= url('/courses/frontend') ?>" class="text-blue-600 font-semibold text-sm hover:underline">
                                        Explore →
                                    </a>
                                </div>
                            </div>

                            <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-md transition">
                                <div class="bg-green-600 h-32 flex items-center justify-center">
                                    <i class="fas fa-server text-white text-4xl"></i>
                                </div>
                                <div class="p-4">
                                    <h3 class="font-bold text-gray-900 mb-2">Backend Development</h3>
                                    <p class="text-sm text-gray-600 mb-3">18+ courses • 6,500+ students</p>
                                    <a href="<?= url('/courses/backend') ?>" class="text-green-600 font-semibold text-sm hover:underline">
                                        Explore →
                                    </a>
                                </div>
                            </div>

                            <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-md transition">
                                <div class="bg-purple-600 h-32 flex items-center justify-center">
                                    <i class="fas fa-layer-group text-white text-4xl"></i>
                                </div>
                                <div class="p-4">
                                    <h3 class="font-bold text-gray-900 mb-2">Full Stack Development</h3>
                                    <p class="text-sm text-gray-600 mb-3">25+ courses • 8,200+ students</p>
                                    <a href="<?= url('/courses/fullstack') ?>" class="text-purple-600 font-semibold text-sm hover:underline">
                                        Explore →
                                    </a>
                                </div>
                            </div>

                            <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-md transition">
                                <div class="bg-indigo-600 h-32 flex items-center justify-center">
                                    <i class="fas fa-brain text-white text-4xl"></i>
                                </div>
                                <div class="p-4">
                                    <h3 class="font-bold text-gray-900 mb-2">AI & Machine Learning</h3>
                                    <p class="text-sm text-gray-600 mb-3">30+ courses • 12,000+ students</p>
                                    <a href="<?= url('/courses/ai') ?>" class="text-indigo-600 font-semibold text-sm hover:underline">
                                        Explore →
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Profile Card -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="text-center">
                        <div class="w-20 h-20 bg-blue-600 rounded-full mx-auto flex items-center justify-center text-white text-2xl font-bold mb-3">
                            <?= strtoupper(substr($user['first_name'], 0, 1) . substr($user['last_name'], 0, 1)) ?>
                        </div>
                        <h3 class="font-bold text-gray-900"><?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?></h3>
                        <p class="text-sm text-gray-600"><?= htmlspecialchars($user['email']) ?></p>
                        <p class="text-xs text-gray-500 mt-2">
                            <i class="fas fa-user-circle mr-1"></i>
                            <?= ucfirst($user['role']) ?>
                        </p>
                        <a href="<?= url('/profile') ?>" class="mt-4 inline-block text-blue-600 font-semibold text-sm hover:underline">
                            Edit Profile
                        </a>
                    </div>
                </div>

                <!-- Learning Streak -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="font-bold text-gray-900 mb-4">Learning Streak</h3>
                    <div class="text-center">
                        <div class="inline-block bg-orange-100 rounded-full p-4 mb-3">
                            <i class="fas fa-fire text-orange-600 text-3xl"></i>
                        </div>
                        <p class="text-4xl font-bold text-gray-900 mb-2">0</p>
                        <p class="text-sm text-gray-600">days streak</p>
                    </div>
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <p class="text-xs text-gray-600 text-center">Complete a lesson today to start your streak!</p>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="font-bold text-gray-900 mb-4">Quick Actions</h3>
                    <div class="space-y-2">
                        <a href="<?= url('/courses') ?>" class="block w-full text-left px-4 py-3 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition">
                            <i class="fas fa-search mr-2"></i>Browse Courses
                        </a>
                        <a href="<?= url('/my-courses') ?>" class="block w-full text-left px-4 py-3 bg-green-50 text-green-700 rounded-lg hover:bg-green-100 transition">
                            <i class="fas fa-book mr-2"></i>My Courses
                        </a>
                        <a href="<?= url('/certificates') ?>" class="block w-full text-left px-4 py-3 bg-purple-50 text-purple-700 rounded-lg hover:bg-purple-100 transition">
                            <i class="fas fa-certificate mr-2"></i>Certificates
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
