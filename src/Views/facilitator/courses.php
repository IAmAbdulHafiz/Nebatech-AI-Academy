<?php
$title = 'My Courses';
ob_start();
include __DIR__ . '/../partials/facilitator-sidebar.php';
$sidebarContent = ob_get_clean();
ob_start();
?>
        <!-- Header Section -->
        <div class="bg-gradient-to-r from-green-600 to-teal-600 rounded-lg shadow-lg p-8 text-white mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold mb-2">My Courses</h1>
                    <p class="text-green-100">Manage and create your courses</p>
                </div>
                <a href="<?= url('/facilitator/courses/create') ?>" class="bg-white text-green-600 px-6 py-3 rounded-lg font-semibold hover:bg-green-50 transition inline-flex items-center">
                    <i class="fas fa-plus mr-2"></i>Create New Course
                </a>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Total Courses</p>
                        <p class="text-3xl font-bold text-blue-600"><?= $stats['total_courses'] ?></p>
                    </div>
                    <div class="bg-blue-100 rounded-full p-3">
                        <i class="fas fa-book text-blue-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Published</p>
                        <p class="text-3xl font-bold text-green-600"><?= $stats['published_courses'] ?></p>
                    </div>
                    <div class="bg-green-100 rounded-full p-3">
                        <i class="fas fa-check-circle text-green-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Drafts</p>
                        <p class="text-3xl font-bold text-orange-600"><?= $stats['draft_courses'] ?></p>
                    </div>
                    <div class="bg-orange-100 rounded-full p-3">
                        <i class="fas fa-edit text-orange-600 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Courses List -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-900">All Courses</h2>
            </div>
            <div class="p-6">
                <?php if (empty($courses)): ?>
                    <div class="text-center py-12">
                        <i class="fas fa-book-open text-6xl text-gray-300 mb-4"></i>
                        <p class="text-gray-600 mb-4">You haven't created any courses yet</p>
                        <a href="<?= url('/facilitator/courses/create') ?>" class="inline-block bg-green-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-700 transition">
                            <i class="fas fa-plus mr-2"></i>Create Your First Course
                        </a>
                    </div>
                <?php else: ?>
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <?php foreach ($courses as $course): ?>
                            <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition">
                                <?php if ($course['thumbnail']): ?>
                                    <img src="<?= url('/' . $course['thumbnail']) ?>" alt="<?= htmlspecialchars($course['title']) ?>" class="w-full h-48 object-cover">
                                <?php else: ?>
                                    <div class="w-full h-48 bg-gradient-to-br from-green-400 to-teal-500 flex items-center justify-center">
                                        <i class="fas fa-book text-white text-6xl opacity-50"></i>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="p-6">
                                    <div class="flex items-center justify-between mb-3">
                                        <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full <?= $course['status'] === 'published' ? 'bg-green-100 text-green-800' : 'bg-orange-100 text-orange-800' ?>">
                                            <?= ucfirst($course['status']) ?>
                                        </span>
                                        <span class="text-xs text-gray-500">
                                            <i class="fas fa-clock mr-1"></i><?= $course['duration_hours'] ?>h
                                        </span>
                                    </div>
                                    
                                    <h3 class="font-bold text-gray-900 mb-2 text-lg"><?= htmlspecialchars($course['title']) ?></h3>
                                    <p class="text-gray-600 text-sm mb-4 line-clamp-2"><?= htmlspecialchars(substr($course['description'], 0, 100)) ?>...</p>
                                    
                                    <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                                        <span class="inline-flex items-center">
                                            <i class="fas fa-tag mr-1"></i><?= ucfirst($course['category']) ?>
                                        </span>
                                        <span class="inline-flex items-center">
                                            <i class="fas fa-signal mr-1"></i><?= ucfirst($course['level']) ?>
                                        </span>
                                    </div>
                                    
                                    <div class="flex gap-2">
                                        <a href="<?= url('/facilitator/courses/' . $course['id'] . '/edit') ?>" class="flex-1 bg-green-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-green-700 transition text-center">
                                            <i class="fas fa-edit mr-1"></i>Edit
                                        </a>
                                        <a href="<?= url('/courses/' . $course['slug']) ?>" target="_blank" class="flex-1 bg-gray-200 text-gray-700 px-4 py-2 rounded-lg font-semibold hover:bg-gray-300 transition text-center">
                                            <i class="fas fa-eye mr-1"></i>View
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/dashboard.php';
