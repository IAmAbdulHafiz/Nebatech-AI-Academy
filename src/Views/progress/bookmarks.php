<?php
$title = 'Bookmarked Lessons';
ob_start();
include __DIR__ . '/../partials/student-sidebar.php';
$sidebarContent = ob_get_clean();
ob_start();
?>

<div class="space-y-6">
    <!-- Page Header -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">
                    <i class="fas fa-bookmark text-yellow-500 mr-2"></i>Bookmarked Lessons
                </h1>
                <p class="text-gray-600">Quick access to your saved lessons</p>
                <?php if (isset($filteredCourseId) && $filteredCourseId): ?>
                <div class="mt-2 inline-flex items-center px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm">
                    <i class="fas fa-filter mr-2"></i>
                    Filtered by course
                    <a href="<?= url('/progress/bookmarks') ?>" class="ml-2 text-blue-900 hover:text-blue-800">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
                <?php endif; ?>
            </div>
            <a href="<?= url('/progress/dashboard') ?>" 
               class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark transition font-semibold">
                <i class="fas fa-chart-line mr-2"></i>Progress Dashboard
            </a>
        </div>
    </div>

    <!-- Bookmarks Grid -->
    <?php if (empty($bookmarks)): ?>
        <div class="bg-white rounded-lg shadow p-12 text-center">
            <i class="fas fa-bookmark text-6xl text-gray-300 mb-4"></i>
            <h3 class="text-xl font-bold text-gray-700 mb-2">No Bookmarks Yet</h3>
            <p class="text-gray-600 mb-6">Start bookmarking lessons to save them for quick access</p>
            <a href="<?= url('/my-courses') ?>" 
               class="inline-flex items-center px-6 py-3 bg-primary text-white rounded-lg hover:bg-primary-dark transition font-semibold">
                <i class="fas fa-book mr-2"></i>Browse My Courses
            </a>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($bookmarks as $bookmark): ?>
            <div class="bg-white rounded-lg shadow hover:shadow-lg transition overflow-hidden">
                <!-- Course Badge -->
                <div class="bg-gradient-to-r from-primary to-primary-dark p-4">
                    <p class="text-white text-sm font-semibold">
                        <i class="fas fa-book mr-1"></i>
                        <?= htmlspecialchars($bookmark['course_title']) ?>
                    </p>
                </div>

                <!-- Lesson Content -->
                <div class="p-6">
                    <div class="flex items-start justify-between mb-3">
                        <h3 class="text-lg font-bold text-gray-900 flex-1">
                            <?= htmlspecialchars($bookmark['lesson_title']) ?>
                        </h3>
                        <i class="fas fa-bookmark text-yellow-500 text-xl"></i>
                    </div>

                    <p class="text-sm text-gray-600 mb-4">
                        <i class="fas fa-folder mr-1"></i>
                        <?= htmlspecialchars($bookmark['module_title']) ?>
                    </p>

                    <!-- Progress Info -->
                    <div class="flex items-center gap-4 mb-4 text-sm text-gray-600">
                        <?php if ($bookmark['status'] === 'completed'): ?>
                            <span class="inline-flex items-center text-green-600">
                                <i class="fas fa-check-circle mr-1"></i>Completed
                            </span>
                        <?php elseif ($bookmark['status'] === 'in_progress'): ?>
                            <span class="inline-flex items-center text-blue-600">
                                <i class="fas fa-spinner mr-1"></i>In Progress
                            </span>
                        <?php endif; ?>

                        <?php if ($bookmark['time_spent_seconds'] > 0): ?>
                            <span>
                                <i class="fas fa-clock mr-1"></i>
                                <?= gmdate('H:i:s', $bookmark['time_spent_seconds']) ?>
                            </span>
                        <?php endif; ?>
                    </div>

                    <!-- Notes Preview -->
                    <?php if (!empty($bookmark['notes'])): ?>
                    <div class="bg-gray-50 rounded-lg p-3 mb-4">
                        <p class="text-xs text-gray-600 mb-1">
                            <i class="fas fa-sticky-note mr-1"></i>Your Notes:
                        </p>
                        <p class="text-sm text-gray-700 line-clamp-2">
                            <?= htmlspecialchars(substr($bookmark['notes'], 0, 100)) ?>
                            <?= strlen($bookmark['notes']) > 100 ? '...' : '' ?>
                        </p>
                    </div>
                    <?php endif; ?>

                    <!-- Action Button -->
                    <a href="<?= url('/courses/' . $bookmark['course_slug'] . '/lesson/' . $bookmark['lesson_id']) ?>" 
                       class="block w-full text-center px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark transition font-semibold">
                        <i class="fas fa-play-circle mr-2"></i>Continue Learning
                    </a>
                </div>

                <!-- Last Accessed -->
                <div class="px-6 py-3 bg-gray-50 border-t border-gray-200">
                    <p class="text-xs text-gray-500">
                        <i class="fas fa-history mr-1"></i>
                        Last accessed: <?= date('M d, Y', strtotime($bookmark['last_accessed_at'])) ?>
                    </p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/dashboard.php';
?>
