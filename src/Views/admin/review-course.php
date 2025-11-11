<?php
$title = 'Review Course - ' . htmlspecialchars($course['title']);
ob_start();
include __DIR__ . '/../partials/admin-sidebar.php';
$sidebarContent = ob_get_clean();
ob_start();
?>

<!-- Page Header -->
<div class="mb-6">
    <div class="flex items-center gap-4 mb-4">
        <a href="<?= url('/admin/approvals') ?>" class="text-gray-600 hover:text-gray-800">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Review Course</h1>
            <p class="text-sm text-gray-600">Submitted for approval</p>
        </div>
    </div>
</div>

<!-- Error Messages -->
<?php if (isset($_GET['error'])): ?>
    <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
        <?php
        $errors = [
            'reason_required' => 'Please provide a reason for rejection',
            'approval_failed' => 'Failed to approve course',
            'rejection_failed' => 'Failed to reject course'
        ];
        echo $errors[$_GET['error']] ?? 'An error occurred';
        ?>
    </div>
<?php endif; ?>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Course Details Card -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-900"><?= htmlspecialchars($course['title']) ?></h2>
                <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-yellow-100 text-yellow-800 mt-2">
                    <i class="fas fa-clock mr-1"></i>Pending Approval
                </span>
            </div>
            <div class="p-6 space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Facilitator</p>
                        <p class="font-semibold text-gray-900">
                            <?= htmlspecialchars(($course['facilitator_first_name'] ?? '') . ' ' . ($course['facilitator_last_name'] ?? '')) ?>
                        </p>
                        <p class="text-sm text-gray-500"><?= htmlspecialchars($course['facilitator_email'] ?? 'No email') ?></p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Category</p>
                        <p class="font-semibold text-gray-900"><?= ucfirst($course['category']) ?></p>
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Level</p>
                        <p class="font-semibold text-gray-900">
                            <i class="fas fa-signal mr-1"></i>
                            <?= ucfirst($course['level']) ?>
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Duration</p>
                        <p class="font-semibold text-gray-900">
                            <i class="fas fa-clock mr-1"></i>
                            <?= $course['duration_hours'] ?> hours
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Modules</p>
                        <p class="font-semibold text-gray-900">
                            <i class="fas fa-folder mr-1"></i>
                            <?= count($modules) ?> modules
                        </p>
                    </div>
                </div>

                <?php if (!empty($course['description'])): ?>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Description</p>
                        <p class="text-gray-800"><?= nl2br(htmlspecialchars($course['description'])) ?></p>
                    </div>
                <?php endif; ?>

                <?php if (!empty($course['learning_objectives'])): ?>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Learning Objectives</p>
                        <p class="text-gray-800"><?= nl2br(htmlspecialchars($course['learning_objectives'])) ?></p>
                    </div>
                <?php endif; ?>

                <div>
                    <p class="text-sm text-gray-600 mb-1">Submitted</p>
                    <p class="text-sm text-gray-700">
                        <i class="fas fa-clock mr-1"></i>
                        <?= date('F d, Y \a\t g:i A', strtotime($course['created_at'])) ?>
                    </p>
                </div>
            </div>
        </div>

        <!-- Course Content -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-bold text-gray-900">
                    <i class="fas fa-book-open mr-2"></i>
                    Course Content (<?= count($modules) ?> Modules)
                </h2>
            </div>
            <div class="p-6">
                <?php if (empty($modules)): ?>
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-exclamation-triangle text-4xl mb-3 text-red-500"></i>
                        <p class="font-semibold text-red-600">No content added!</p>
                        <p class="text-sm">This course has no modules or lessons. Consider rejecting it.</p>
                    </div>
                <?php else: ?>
                    <div class="space-y-4">
                        <?php foreach ($modules as $index => $module): ?>
                            <div class="border border-gray-200 rounded-lg">
                                <div class="bg-gray-50 px-4 py-3 border-b border-gray-200">
                                    <div class="flex items-center gap-2">
                                        <span class="bg-purple-100 text-purple-800 text-xs font-bold px-2 py-1 rounded">
                                            Module <?= $index + 1 ?>
                                        </span>
                                        <h3 class="font-bold text-gray-900"><?= htmlspecialchars($module['title']) ?></h3>
                                    </div>
                                    <?php if (!empty($module['description'])): ?>
                                        <p class="text-sm text-gray-600 mt-1"><?= htmlspecialchars($module['description']) ?></p>
                                    <?php endif; ?>
                                </div>
                                <div class="p-4">
                                    <?php
                                    $lessons = \Nebatech\Models\Lesson::getByModule($module['id']);
                                    if (empty($lessons)):
                                    ?>
                                        <p class="text-sm text-gray-500 italic">No lessons in this module</p>
                                    <?php else: ?>
                                        <ul class="space-y-2">
                                            <?php foreach ($lessons as $lesson): ?>
                                                <li class="flex items-start gap-2 text-sm">
                                                    <i class="fas fa-file-alt text-gray-400 mt-1"></i>
                                                    <span class="text-gray-700"><?= htmlspecialchars($lesson['title']) ?></span>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Approval History -->
        <?php if (!empty($history)): ?>
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-bold text-gray-900">
                        <i class="fas fa-history mr-2"></i>
                        Approval History
                    </h2>
                </div>
                <div class="p-6">
                    <div class="space-y-3">
                        <?php foreach ($history as $entry): ?>
                            <div class="flex items-start gap-3 pb-3 border-b border-gray-100 last:border-0">
                                <div class="flex-shrink-0 mt-1">
                                    <?php if ($entry['action'] === 'submitted'): ?>
                                        <i class="fas fa-paper-plane text-blue-600"></i>
                                    <?php elseif ($entry['action'] === 'approved'): ?>
                                        <i class="fas fa-check-circle text-green-600"></i>
                                    <?php elseif ($entry['action'] === 'rejected'): ?>
                                        <i class="fas fa-times-circle text-red-600"></i>
                                    <?php elseif ($entry['action'] === 'resubmitted'): ?>
                                        <i class="fas fa-redo text-orange-600"></i>
                                    <?php endif; ?>
                                </div>
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-900">
                                        <?= ucfirst($entry['action']) ?>
                                        <?php if ($entry['first_name']): ?>
                                            by <?= htmlspecialchars($entry['first_name'] . ' ' . $entry['last_name']) ?>
                                        <?php endif; ?>
                                    </p>
                                    <p class="text-sm text-gray-600"><?= date('M d, Y \a\t g:i A', strtotime($entry['created_at'])) ?></p>
                                    <?php if (!empty($entry['reason'])): ?>
                                        <p class="text-sm text-gray-700 mt-1 italic">"<?= htmlspecialchars($entry['reason']) ?>"</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Sidebar - Actions -->
    <div class="space-y-6">
        <!-- Approve Card -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-green-200 bg-green-50">
                <h3 class="font-bold text-green-900">
                    <i class="fas fa-check-circle mr-2"></i>
                    Approve Course
                </h3>
            </div>
            <div class="p-6">
                <p class="text-sm text-gray-600 mb-4">
                    Approving this course will publish it and make it available to students.
                </p>
                <form method="POST" action="<?= url('/admin/approvals/courses/' . $course['id'] . '/approve') ?>" 
                      onsubmit="return confirm('Are you sure you want to approve and publish this course?')">
                    <?= csrf_field() ?>
                    <textarea name="reason" 
                              placeholder="Optional: Add a note for the facilitator" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg mb-3 text-sm"
                              rows="3"></textarea>
                    <button type="submit" 
                            class="w-full px-4 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium">
                        <i class="fas fa-check mr-2"></i>
                        Approve & Publish
                    </button>
                </form>
            </div>
        </div>

        <!-- Reject Card -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-red-200 bg-red-50">
                <h3 class="font-bold text-red-900">
                    <i class="fas fa-times-circle mr-2"></i>
                    Reject Course
                </h3>
            </div>
            <div class="p-6">
                <p class="text-sm text-gray-600 mb-4">
                    Provide feedback to help the facilitator improve their course.
                </p>
                <form method="POST" action="<?= url('/admin/approvals/courses/' . $course['id'] . '/reject') ?>" 
                      onsubmit="return confirm('Are you sure you want to reject this course?')">
                    <?= csrf_field() ?>
                    <textarea name="reason" 
                              placeholder="Reason for rejection (required)" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg mb-3 text-sm"
                              rows="4"
                              required></textarea>
                    <button type="submit" 
                            class="w-full px-4 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-medium">
                        <i class="fas fa-times mr-2"></i>
                        Reject with Feedback
                    </button>
                </form>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="font-bold text-gray-900 mb-4">Quick Stats</h3>
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Modules</span>
                    <span class="font-semibold text-gray-900"><?= count($modules) ?></span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Total Lessons</span>
                    <span class="font-semibold text-gray-900">
                        <?php
                        $totalLessons = 0;
                        foreach ($modules as $module) {
                            $totalLessons += count(\Nebatech\Models\Lesson::getByModule($module['id']));
                        }
                        echo $totalLessons;
                        ?>
                    </span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Duration</span>
                    <span class="font-semibold text-gray-900"><?= $course['duration_hours'] ?>h</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Level</span>
                    <span class="font-semibold text-gray-900"><?= ucfirst($course['level']) ?></span>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/dashboard.php';
?>
