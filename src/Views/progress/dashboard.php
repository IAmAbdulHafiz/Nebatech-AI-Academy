<?php
$title = 'My Progress';
ob_start();
include __DIR__ . '/../partials/student-sidebar.php';
$sidebarContent = ob_get_clean();
ob_start();

$streak = $data['streak'] ?? null;
$lessonStats = $data['lesson_stats'] ?? [];
$enrollmentStats = $data['enrollment_stats'] ?? [];
$recentActivity = $data['recent_activity'] ?? [];
$timeDistribution = $data['time_distribution'] ?? [];
$goals = $data['goals'] ?? [];
$insights = $data['insights'] ?? [];
?>

<div class="space-y-6">
    <!-- Page Header -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">My Learning Progress</h1>
                <p class="text-gray-600">Track your learning journey and achievements</p>
            </div>
            <a href="<?= url('/progress/bookmarks') ?>" 
               class="inline-flex items-center px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition font-semibold">
                <i class="fas fa-bookmark mr-2"></i>My Bookmarks
            </a>
        </div>
    </div>

    <!-- Learning Streak Card -->
    <?php if ($streak): ?>
    <div class="bg-gradient-to-r from-orange-500 to-red-500 rounded-lg shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold mb-2">
                    <i class="fas fa-fire mr-2"></i><?= $streak['current_streak_days'] ?> Day Streak!
                </h2>
                <p class="text-white">Keep learning every day to maintain your streak</p>
                <div class="mt-4 flex items-center gap-6">
                    <div>
                        <p class="text-sm text-white">Longest Streak</p>
                        <p class="text-2xl font-bold"><?= $streak['longest_streak_days'] ?> days</p>
                    </div>
                    <div>
                        <p class="text-sm text-white">Total Learning Days</p>
                        <p class="text-2xl font-bold"><?= $streak['total_learning_days'] ?> days</p>
                    </div>
                </div>
            </div>
            <div class="text-8xl opacity-20">
                <i class="fas fa-fire"></i>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Time -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-blue-100 rounded-lg">
                    <i class="fas fa-clock text-2xl text-blue-600"></i>
                </div>
            </div>
            <h3 class="text-gray-600 text-sm font-medium mb-1">Total Learning Time</h3>
            <p class="text-3xl font-bold text-gray-900">
                <?= round(($lessonStats['total_time_spent'] ?? 0) / 3600, 1) ?>h
            </p>
        </div>

        <!-- Lessons Completed -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-green-100 rounded-lg">
                    <i class="fas fa-check-circle text-2xl text-green-600"></i>
                </div>
            </div>
            <h3 class="text-gray-600 text-sm font-medium mb-1">Lessons Completed</h3>
            <p class="text-3xl font-bold text-gray-900">
                <?= $lessonStats['lessons_completed'] ?? 0 ?>
            </p>
        </div>

        <!-- Active Courses -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-purple-100 rounded-lg">
                    <i class="fas fa-book text-2xl text-purple-600"></i>
                </div>
            </div>
            <h3 class="text-gray-600 text-sm font-medium mb-1">Active Courses</h3>
            <p class="text-3xl font-bold text-gray-900">
                <?= $enrollmentStats['active_enrollments'] ?? 0 ?>
            </p>
        </div>

        <!-- Completion Rate -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-yellow-100 rounded-lg">
                    <i class="fas fa-chart-line text-2xl text-yellow-600"></i>
                </div>
            </div>
            <h3 class="text-gray-600 text-sm font-medium mb-1">Avg Completion</h3>
            <p class="text-3xl font-bold text-gray-900">
                <?= round($lessonStats['average_completion'] ?? 0, 1) ?>%
            </p>
        </div>
    </div>

    <!-- Insights Section -->
    <?php if (!empty($insights)): ?>
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4">
            <i class="fas fa-lightbulb text-yellow-500 mr-2"></i>Learning Insights
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <?php foreach ($insights as $insight): ?>
            <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-lg">
                <div class="p-3 bg-primary-100 rounded-lg">
                    <i class="fas fa-<?= $insight['icon'] ?> text-primary text-xl"></i>
                </div>
                <div class="flex-1">
                    <h3 class="font-semibold text-gray-900 mb-1"><?= htmlspecialchars($insight['title']) ?></h3>
                    <p class="text-2xl font-bold text-primary mb-1"><?= htmlspecialchars($insight['value']) ?></p>
                    <p class="text-sm text-gray-600"><?= htmlspecialchars($insight['description']) ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Activity -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">
                <i class="fas fa-history text-primary mr-2"></i>Recent Activity
            </h2>
            <?php if (empty($recentActivity)): ?>
                <p class="text-gray-500 text-center py-8">No recent activity</p>
            <?php else: ?>
                <div class="space-y-4">
                    <?php foreach ($recentActivity as $activity): ?>
                    <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                        <div class="p-2 bg-primary-100 rounded-lg">
                            <?php if ($activity['status'] === 'completed'): ?>
                                <i class="fas fa-check-circle text-green-600"></i>
                            <?php else: ?>
                                <i class="fas fa-book-open text-primary"></i>
                            <?php endif; ?>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-900"><?= htmlspecialchars($activity['lesson_title']) ?></h3>
                            <p class="text-sm text-gray-600"><?= htmlspecialchars($activity['course_title']) ?></p>
                            <p class="text-xs text-gray-500 mt-1">
                                <?= date('M d, Y g:i A', strtotime($activity['last_accessed_at'])) ?>
                            </p>
                        </div>
                        <a href="<?= url('/courses/' . $activity['course_slug'] . '/lesson/' . $activity['lesson_id']) ?>" 
                           class="text-primary hover:text-primary-dark">
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Time Distribution -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">
                <i class="fas fa-chart-pie text-primary mr-2"></i>Time by Course
            </h2>
            <?php if (empty($timeDistribution)): ?>
                <p class="text-gray-500 text-center py-8">No data available</p>
            <?php else: ?>
                <div class="space-y-4">
                    <?php 
                    $totalTime = array_sum(array_column($timeDistribution, 'time_spent'));
                    foreach ($timeDistribution as $course): 
                        $percentage = $totalTime > 0 ? ($course['time_spent'] / $totalTime) * 100 : 0;
                        $hours = round($course['time_spent'] / 3600, 1);
                    ?>
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-gray-900">
                                <?= htmlspecialchars($course['course_title']) ?>
                            </span>
                            <span class="text-sm text-gray-600"><?= $hours ?>h</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-primary h-2 rounded-full transition-all" 
                                 style="width: <?= $percentage ?>%"></div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Learning Goals -->
    <?php if (!empty($goals)): ?>
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold text-gray-900">
                <i class="fas fa-bullseye text-primary mr-2"></i>Learning Goals
            </h2>
            <button class="text-primary hover:text-primary-dark font-semibold text-sm">
                <i class="fas fa-plus mr-1"></i>Add Goal
            </button>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <?php foreach ($goals as $goal): 
                $progress = $goal['target_value'] > 0 ? ($goal['current_value'] / $goal['target_value']) * 100 : 0;
                $progress = min(100, $progress);
            ?>
            <div class="p-4 border border-gray-200 rounded-lg">
                <h3 class="font-semibold text-gray-900 mb-2"><?= htmlspecialchars($goal['title']) ?></h3>
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm text-gray-600">
                        <?= $goal['current_value'] ?> / <?= $goal['target_value'] ?> <?= $goal['unit'] ?>
                    </span>
                    <span class="text-sm font-bold text-primary"><?= round($progress, 1) ?>%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-primary h-2 rounded-full transition-all" 
                         style="width: <?= $progress ?>%"></div>
                </div>
                <p class="text-xs text-gray-500 mt-2">
                    Target: <?= date('M d, Y', strtotime($goal['target_date'])) ?>
                </p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/dashboard.php';
?>
