<?php
$title = 'My Courses';
ob_start();
include __DIR__ . '/../partials/student-sidebar.php';
$sidebarContent = ob_get_clean();
ob_start();
?>

<!-- Page Header -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-2">My Courses</h1>
    <p class="text-gray-600">Continue your learning journey</p>
</div>

<!-- Courses Grid -->
<?php if (empty($courses)): ?>
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
        <i class="fas fa-book-open text-6xl text-gray-300 mb-4"></i>
        <h3 class="text-xl font-bold text-gray-900 mb-2">No Enrolled Courses</h3>
        <p class="text-gray-600 mb-6">You haven't enrolled in any courses yet. Browse our catalog to get started!</p>
        <a href="<?= url('/courses') ?>" class="inline-block px-6 py-3 bg-primary text-white rounded-lg hover:bg-blue-700 transition font-medium">
            <i class="fas fa-search mr-2"></i>Browse Courses
        </a>
    </div>
<?php else: ?>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($courses as $course): ?>
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg transition">
                <!-- Course Image/Thumbnail -->
                <div class="h-48 bg-gradient-to-br from-primary to-blue-700 flex items-center justify-center relative">
                    <?php if (!empty($course['thumbnail'])): ?>
                        <img src="<?= htmlspecialchars($course['thumbnail']) ?>" alt="<?= htmlspecialchars($course['title']) ?>" class="w-full h-full object-cover">
                    <?php else: ?>
                        <i class="fas fa-graduation-cap text-white text-6xl opacity-50"></i>
                    <?php endif; ?>
                    
                    <!-- Status Badge -->
                    <?php
                    $statusConfig = [
                        'active' => ['bg' => 'bg-green-500', 'text' => 'Active'],
                        'completed' => ['bg' => 'bg-blue-500', 'text' => 'Completed'],
                        'paused' => ['bg' => 'bg-yellow-500', 'text' => 'Paused']
                    ];
                    $config = $statusConfig[$course['status']] ?? ['bg' => 'bg-gray-500', 'text' => 'Enrolled'];
                    ?>
                    <div class="absolute top-3 right-3 flex gap-2">
                        <div class="<?= $config['bg'] ?> text-white px-3 py-1 rounded-full text-xs font-bold">
                            <?= $config['text'] ?>
                        </div>
                        <?php if (!empty($course['cohort_id'])): ?>
                            <div class="bg-purple-500 text-white px-3 py-1 rounded-full text-xs font-bold" title="Cohort-based learning">
                                <i class="fas fa-users mr-1"></i>Cohort
                            </div>
                        <?php else: ?>
                            <div class="bg-indigo-500 text-white px-3 py-1 rounded-full text-xs font-bold" title="Self-paced learning">
                                <i class="fas fa-user mr-1"></i>Self-Paced
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Course Info -->
                <div class="p-6">
                    <h3 class="font-bold text-gray-900 text-xl mb-2 line-clamp-2"><?= htmlspecialchars($course['title']) ?></h3>
                    
                    <?php if (!empty($course['cohort_name'])): ?>
                        <div class="flex items-center gap-2 mb-2 text-sm">
                            <i class="fas fa-users text-purple-600"></i>
                            <span class="text-purple-700 font-medium"><?= htmlspecialchars($course['cohort_name']) ?></span>
                        </div>
                    <?php endif; ?>
                    
                    <p class="text-sm text-gray-600 mb-4 line-clamp-2"><?= htmlspecialchars($course['description'] ?? 'No description available') ?></p>
                    
                    <!-- Progress Bar -->
                    <div class="mb-4">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-gray-700">Progress</span>
                            <span class="text-sm font-bold text-primary"><?= number_format($course['progress'], 0) ?>%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-primary h-2 rounded-full transition-all" style="width: <?= $course['progress'] ?>%"></div>
                        </div>
                    </div>

                    <!-- Course Meta -->
                    <div class="flex items-center justify-between text-sm text-gray-500 mb-4 pb-4 border-b border-gray-200">
                        <div class="flex items-center">
                            <i class="fas fa-clock mr-1"></i>
                            <span><?= $course['duration_hours'] ?? 'N/A' ?> hours</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-signal mr-1"></i>
                            <span><?= ucfirst($course['level']) ?></span>
                        </div>
                        <?php if (isset($course['bookmarked_count']) && $course['bookmarked_count'] > 0): ?>
                        <div class="flex items-center">
                            <a href="<?= url('/progress/bookmarks?course=' . $course['id']) ?>" 
                               class="flex items-center text-yellow-600 hover:text-yellow-700 transition"
                               title="View bookmarked lessons">
                                <i class="fas fa-bookmark mr-1"></i>
                                <span><?= $course['bookmarked_count'] ?></span>
                            </a>
                        </div>
                        <?php endif; ?>
                    </div>

                    <!-- Action Button -->
                    <a href="<?= url('/courses/' . $course['slug']) ?>" 
                       class="block w-full text-center px-4 py-3 bg-primary text-white rounded-lg hover:bg-blue-700 transition font-medium">
                        <?php if ($course['progress'] > 0): ?>
                            <i class="fas fa-play mr-2"></i>Continue Learning
                        <?php else: ?>
                            <i class="fas fa-rocket mr-2"></i>Start Course
                        <?php endif; ?>
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Stats Summary -->
    <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
        <?php
        $totalCourses = count($courses);
        $activeCourses = count(array_filter($courses, fn($c) => $c['status'] === 'active'));
        $completedCourses = count(array_filter($courses, fn($c) => $c['status'] === 'completed'));
        $avgProgress = $totalCourses > 0 ? array_sum(array_column($courses, 'progress')) / $totalCourses : 0;
        ?>
        
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 text-center">
            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
                <i class="fas fa-book text-blue-600 text-xl"></i>
            </div>
            <div class="text-3xl font-bold text-gray-900 mb-1"><?= $totalCourses ?></div>
            <div class="text-sm text-gray-600">Total Courses</div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 text-center">
            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                <i class="fas fa-check-circle text-green-600 text-xl"></i>
            </div>
            <div class="text-3xl font-bold text-gray-900 mb-1"><?= $completedCourses ?></div>
            <div class="text-sm text-gray-600">Completed</div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 text-center">
            <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-3">
                <i class="fas fa-chart-line text-secondary text-xl"></i>
            </div>
            <div class="text-3xl font-bold text-gray-900 mb-1"><?= number_format($avgProgress, 0) ?>%</div>
            <div class="text-sm text-gray-600">Avg Progress</div>
        </div>
    </div>
<?php endif; ?>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/dashboard.php';
?>
