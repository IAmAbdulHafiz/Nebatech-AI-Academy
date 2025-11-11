<?php
$title = 'Facilitator Dashboard';
ob_start();
include __DIR__ . '/../partials/facilitator-sidebar.php';
$sidebarContent = ob_get_clean();
ob_start();
?>
        <!-- Welcome Section -->
        <div class="bg-gradient-to-r from-green-600 to-teal-600 rounded-lg shadow-lg p-8 text-white mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold mb-2">Welcome, <?= htmlspecialchars($user['first_name']) ?>!</h1>
                    <p class="text-green-100">Facilitator Dashboard</p>
                </div>
                <div class="hidden md:block">
                    <i class="fas fa-chalkboard-teacher text-6xl opacity-20"></i>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="grid md:grid-cols-4 gap-6 mb-8">
            <a href="<?= url('/facilitator/courses/create') ?>" class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Total Courses</p>
                        <p class="text-3xl font-bold text-blue-600"><?= $stats['total_courses'] ?></p>
                    </div>
                    <div class="bg-blue-100 rounded-full p-3">
                        <i class="fas fa-book text-blue-600 text-xl"></i>
                    </div>
                </div>
            </a>

            <a href="<?= url('/facilitator/submissions') ?>" class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Pending Reviews</p>
                        <p class="text-3xl font-bold text-orange-600"><?= $stats['pending_submissions'] ?></p>
                    </div>
                    <div class="bg-orange-100 rounded-full p-3">
                        <i class="fas fa-tasks text-orange-600 text-xl"></i>
                    </div>
                </div>
            </a>

            <a href="<?= url('/facilitator/students') ?>" class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">My Students</p>
                        <p class="text-3xl font-bold text-green-600">-</p>
                    </div>
                    <div class="bg-green-100 rounded-full p-3">
                        <i class="fas fa-user-graduate text-green-600 text-xl"></i>
                    </div>
                </div>
            </a>

            <a href="<?= url('/facilitator/cohorts') ?>" class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">My Cohorts</p>
                        <p class="text-3xl font-bold text-purple-600">-</p>
                    </div>
                    <div class="bg-purple-100 rounded-full p-3">
                        <i class="fas fa-user-friends text-purple-600 text-xl"></i>
                    </div>
                </div>
            </a>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="md:col-span-2 space-y-6">
                <!-- My Courses -->
                <div class="bg-white rounded-lg shadow">
                    <div class="p-6 border-b border-gray-200 flex items-center justify-between">
                        <h2 class="text-xl font-bold text-gray-900">My Courses</h2>
                        <a href="<?= url('/facilitator/courses/create') ?>" class="bg-green-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-green-700 transition inline-flex items-center">
                            <i class="fas fa-plus mr-2"></i>Create Course
                        </a>
                    </div>
                    <div class="p-6">
                        <?php if (empty($courses)): ?>
                            <div class="text-center py-12">
                                <i class="fas fa-book-open text-6xl text-gray-300 mb-4"></i>
                                <p class="text-gray-600 mb-4">You haven't created any courses yet</p>
                                <a href="<?= url('/facilitator/courses/create') ?>" class="inline-block bg-green-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-700 transition">
                                    Create Your First Course
                                </a>
                            </div>
                        <?php else: ?>
                            <div class="space-y-4">
                                <?php foreach ($courses as $course): ?>
                                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition">
                                        <div class="flex items-start justify-between">
                                            <div class="flex-1">
                                                <div class="flex items-center gap-3 mb-2">
                                                    <h3 class="font-bold text-gray-900"><?= htmlspecialchars($course['title']) ?></h3>
                                                    <?php if ($course['status'] === 'published'): ?>
                                                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">Published</span>
                                                    <?php elseif ($course['status'] === 'draft'): ?>
                                                        <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold">Draft</span>
                                                    <?php endif; ?>
                                                </div>
                                                <p class="text-sm text-gray-600 mb-3 line-clamp-2"><?= htmlspecialchars($course['description']) ?></p>
                                                <div class="flex items-center gap-4 text-xs text-gray-500">
                                                    <span><i class="fas fa-layer-group mr-1"></i><?= ucfirst($course['category']) ?></span>
                                                    <span><i class="fas fa-signal mr-1"></i><?= ucfirst($course['level']) ?></span>
                                                    <span><i class="fas fa-clock mr-1"></i><?= $course['duration_hours'] ?> hours</span>
                                                    <span><i class="fas fa-users mr-1"></i><?= $course['enrollment_count'] ?? 0 ?> students</span>
                                                </div>
                                            </div>
                                            <div class="flex gap-2 ml-4">
                                                <a href="<?= url('/facilitator/courses/' . $course['id'] . '/edit') ?>" class="bg-blue-100 text-blue-700 px-3 py-2 rounded hover:bg-blue-200 transition" title="Edit Course">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="<?= url('/courses/' . $course['slug']) ?>" class="bg-gray-100 text-gray-700 px-3 py-2 rounded hover:bg-gray-200 transition" title="View Course" target="_blank">
                                                    <i class="fas fa-external-link-alt"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Pending Submissions -->
                <?php if (!empty($pendingSubmissions)): ?>
                <div class="bg-white rounded-lg shadow">
                    <div class="p-6 border-b border-gray-200">
                        <h2 class="text-xl font-bold text-gray-900">Pending Reviews</h2>
                    </div>
                    <div class="p-6">
                        <div class="space-y-3">
                            <?php foreach (array_slice($pendingSubmissions, 0, 5) as $submission): ?>
                                <div class="flex items-center justify-between p-3 bg-orange-50 rounded-lg">
                                    <div>
                                        <p class="font-semibold text-gray-900"><?= htmlspecialchars($submission['first_name'] . ' ' . $submission['last_name']) ?></p>
                                        <p class="text-sm text-gray-600"><?= htmlspecialchars($submission['assignment_title']) ?></p>
                                        <p class="text-xs text-gray-500"><?= date('M d, Y', strtotime($submission['submitted_at'])) ?></p>
                                    </div>
                                    <a href="<?= url('/facilitator/submissions/' . $submission['id']) ?>" class="bg-orange-600 text-white px-4 py-2 rounded hover:bg-orange-700 transition text-sm">
                                        Review
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Quick Actions -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="font-bold text-gray-900 mb-4">Quick Actions</h3>
                    <div class="space-y-2">
                        <a href="<?= url('/facilitator/courses/create') ?>" class="block w-full text-left px-4 py-3 bg-green-50 text-green-700 rounded-lg hover:bg-green-100 transition">
                            <i class="fas fa-plus-circle mr-2"></i>Create New Course
                        </a>
                        <a href="<?= url('/facilitator/courses') ?>" class="block w-full text-left px-4 py-3 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition">
                            <i class="fas fa-book mr-2"></i>Manage Courses
                        </a>
                        <a href="<?= url('/facilitator/submissions') ?>" class="block w-full text-left px-4 py-3 bg-orange-50 text-orange-700 rounded-lg hover:bg-orange-100 transition">
                            <i class="fas fa-tasks mr-2"></i>Review Submissions
                        </a>
                        <a href="<?= url('/facilitator/students') ?>" class="block w-full text-left px-4 py-3 bg-purple-50 text-purple-700 rounded-lg hover:bg-purple-100 transition">
                            <i class="fas fa-users mr-2"></i>My Students
                        </a>
                    </div>
                </div>

                <!-- AI Tools -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="font-bold text-gray-900 mb-4">
                        <i class="fas fa-robot text-blue-600 mr-2"></i>AI Tools
                    </h3>
                    <p class="text-sm text-gray-600 mb-4">Use AI to accelerate course creation</p>
                    <div class="space-y-2">
                        <button onclick="showAICourseOutlineModal()" class="block w-full text-left px-4 py-3 bg-gradient-to-r from-blue-50 to-purple-50 text-blue-700 rounded-lg hover:from-blue-100 hover:to-purple-100 transition">
                            <i class="fas fa-magic mr-2"></i>Generate Course Outline
                        </button>
                        <button onclick="showAILessonModal()" class="block w-full text-left px-4 py-3 bg-gradient-to-r from-blue-50 to-purple-50 text-purple-700 rounded-lg hover:from-blue-100 hover:to-purple-100 transition">
                            <i class="fas fa-file-alt mr-2"></i>Create Lesson Content
                        </button>
                        <button onclick="showAIProjectModal()" class="block w-full text-left px-4 py-3 bg-gradient-to-r from-blue-50 to-purple-50 text-indigo-700 rounded-lg hover:from-blue-100 hover:to-purple-100 transition">
                            <i class="fas fa-lightbulb mr-2"></i>Generate Project Ideas
                        </button>
                    </div>
                </div>

                <!-- Help & Resources -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="font-bold text-gray-900 mb-4">Help & Resources</h3>
                    <div class="space-y-3">
                        <a href="#" class="flex items-center text-sm text-gray-700 hover:text-blue-600">
                            <i class="fas fa-book-reader mr-2 text-gray-400"></i>
                            Facilitator Guide
                        </a>
                        <a href="#" class="flex items-center text-sm text-gray-700 hover:text-blue-600">
                            <i class="fas fa-video mr-2 text-gray-400"></i>
                            Video Tutorials
                        </a>
                        <a href="#" class="flex items-center text-sm text-gray-700 hover:text-blue-600">
                            <i class="fas fa-question-circle mr-2 text-gray-400"></i>
                            FAQs
                        </a>
                        <a href="#" class="flex items-center text-sm text-gray-700 hover:text-blue-600">
                            <i class="fas fa-headset mr-2 text-gray-400"></i>
                            Contact Support
                        </a>
                    </div>
                </div>
            </div>
        </div>

<!-- AI Modals -->
<?php include __DIR__ . '/../partials/ai-modals.php'; ?>

<script src="<?= asset('js/ai-generator.js') ?>"></script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/dashboard.php';
?>
