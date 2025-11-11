<?php
$title = 'Dashboard';
ob_start();
include __DIR__ . '/../partials/student-sidebar.php';
$sidebarContent = ob_get_clean();
ob_start();
?>
<!-- Welcome Section -->
<div class="bg-gradient-to-r from-primary to-blue-700 rounded-lg shadow-lg p-8 text-white mb-8">
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
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-book text-primary text-xl"></i>
            </div>
        </div>
        <p class="text-gray-600 text-sm mb-1">Enrolled Courses</p>
        <p class="text-3xl font-bold text-gray-900"><?= $enrolledCount ?? 0 ?></p>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-check-circle text-green-600 text-xl"></i>
            </div>
        </div>
        <p class="text-gray-600 text-sm mb-1">Completed</p>
        <p class="text-3xl font-bold text-gray-900"><?= $completedCount ?? 0 ?></p>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-certificate text-purple-600 text-xl"></i>
            </div>
        </div>
        <p class="text-gray-600 text-sm mb-1">Certificates</p>
        <p class="text-3xl font-bold text-gray-900"><?= $certificatesCount ?? 0 ?></p>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-clock text-secondary text-xl"></i>
            </div>
        </div>
        <p class="text-gray-600 text-sm mb-1">Learning Hours</p>
        <p class="text-3xl font-bold text-gray-900"><?= $learningHours ?? 0 ?></p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Continue Learning -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-900">Continue Learning</h2>
            </div>
            <div class="p-6">
                <?php if (empty($recentCourses)): ?>
                    <div class="text-center py-12">
                        <i class="fas fa-book-open text-6xl text-gray-300 mb-4"></i>
                        <p class="text-gray-600 mb-4">You haven't enrolled in any courses yet</p>
                        <a href="<?= url('/courses') ?>" class="inline-block bg-primary text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                            <i class="fas fa-search mr-2"></i>Browse Courses
                        </a>
                    </div>
                <?php else: ?>
                    <div class="space-y-4">
                        <?php foreach ($recentCourses as $course): ?>
                            <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition">
                                <div class="flex items-center justify-between mb-3">
                                    <h3 class="font-bold text-gray-900"><?= htmlspecialchars($course['title']) ?></h3>
                                    <span class="text-sm font-medium <?= $course['status'] === 'completed' ? 'text-green-600' : 'text-blue-600' ?>">
                                        <?= ucfirst($course['status']) ?>
                                    </span>
                                </div>
                                <div class="mb-3">
                                    <div class="flex items-center justify-between text-sm text-gray-600 mb-1">
                                        <span>Progress</span>
                                        <span class="font-medium"><?= number_format($course['progress'], 0) ?>%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-primary h-2 rounded-full transition-all" style="width: <?= $course['progress'] ?>%"></div>
                                    </div>
                                </div>
                                <a href="<?= url('/courses/' . $course['slug']) ?>" class="text-primary font-semibold text-sm hover:underline inline-flex items-center">
                                    Continue Learning <i class="fas fa-arrow-right ml-2 text-xs"></i>
                                </a>
                            </div>
                        <?php endforeach; ?>
                        <a href="<?= url('/my-courses') ?>" class="block text-center text-primary font-semibold hover:underline mt-4">
                            View All Courses <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Recommended Courses -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-900">Recommended for You</h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Sample Course Card -->
                    <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition group">
                        <div class="bg-gradient-to-br from-primary to-blue-700 h-32 flex items-center justify-center">
                            <i class="fas fa-code text-white text-4xl"></i>
                        </div>
                        <div class="p-4">
                            <h3 class="font-bold text-gray-900 mb-2">Frontend Development</h3>
                            <p class="text-sm text-gray-600 mb-3">15+ courses • 5,000+ students</p>
                            <a href="<?= url('/courses/frontend') ?>" class="text-primary font-semibold text-sm hover:underline inline-flex items-center">
                                Explore <i class="fas fa-arrow-right ml-2 text-xs"></i>
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
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="text-center">
                <?php if (!empty($user['avatar'])): ?>
                    <img src="<?= htmlspecialchars($user['avatar']) ?>" alt="Profile" class="w-20 h-20 rounded-full mx-auto object-cover mb-3">
                <?php else: ?>
                    <div class="w-20 h-20 bg-gradient-to-br from-primary to-blue-700 rounded-full mx-auto flex items-center justify-center text-white text-2xl font-bold mb-3">
                        <?= strtoupper(substr($user['first_name'], 0, 1) . substr($user['last_name'], 0, 1)) ?>
                    </div>
                <?php endif; ?>
                <h3 class="font-bold text-gray-900"><?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?></h3>
                <p class="text-sm text-gray-600"><?= htmlspecialchars($user['email']) ?></p>
                <span class="inline-block px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-medium mt-2">
                    <i class="fas fa-user-circle mr-1"></i><?= ucfirst($user['role']) ?>
                </span>
                <a href="<?= url('/profile') ?>" class="mt-4 inline-block text-primary font-semibold text-sm hover:underline">
                    <i class="fas fa-edit mr-1"></i>Edit Profile
                </a>
            </div>
        </div>

        <!-- Learning Streak -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="font-bold text-gray-900 mb-4">Learning Streak</h3>
            <div class="text-center">
                <div class="inline-block bg-orange-100 rounded-full p-4 mb-3">
                    <i class="fas fa-fire text-secondary text-3xl"></i>
                </div>
                <p class="text-4xl font-bold text-gray-900 mb-2">0</p>
                <p class="text-sm text-gray-600">days streak</p>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-200">
                <p class="text-xs text-gray-600 text-center">Complete a lesson today to start your streak!</p>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="font-bold text-gray-900 mb-4">Quick Actions</h3>
            <div class="space-y-2">
                <a href="<?= url('/courses') ?>" class="block w-full text-left px-4 py-3 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition font-medium">
                    <i class="fas fa-search mr-2"></i>Browse Courses
                </a>
                <a href="<?= url('/my-courses') ?>" class="block w-full text-left px-4 py-3 bg-green-50 text-green-700 rounded-lg hover:bg-green-100 transition font-medium">
                    <i class="fas fa-book mr-2"></i>My Courses
                </a>
                <a href="<?= url('/my-certificates') ?>" class="block w-full text-left px-4 py-3 bg-purple-50 text-purple-700 rounded-lg hover:bg-purple-100 transition font-medium">
                    <i class="fas fa-certificate mr-2"></i>My Certificates
                </a>
                <a href="<?= url('/apply') ?>" class="block w-full text-left px-4 py-3 bg-orange-50 text-orange-700 rounded-lg hover:bg-orange-100 transition font-medium">
                    <i class="fas fa-file-alt mr-2"></i>Apply for Program
                </a>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/dashboard.php';
?>
