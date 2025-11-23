<?php
$title = 'Pending Approvals';
ob_start();
include __DIR__ . '/../partials/admin-sidebar.php';
$sidebarContent = ob_get_clean();
ob_start();
?>

<!-- Page Header -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-2">Pending Approvals</h1>
    <p class="text-gray-600">Review and approve facilitator submissions</p>
</div>

<!-- Success/Error Messages -->
<?php if (isset($_GET['success'])): ?>
    <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
        <?php
        $messages = [
            'cohort_approved' => '✅ Cohort approved successfully!',
            'cohort_rejected' => '❌ Cohort rejected with feedback sent to facilitator',
            'course_approved' => '✅ Course approved successfully!',
            'course_rejected' => '❌ Course rejected with feedback sent to facilitator'
        ];
        echo $messages[$_GET['success']] ?? 'Action completed successfully';
        ?>
    </div>
<?php endif; ?>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600">Pending Cohorts</p>
                <p class="text-3xl font-bold text-purple-600"><?= count($pendingCohorts) ?></p>
            </div>
            <div class="bg-purple-100 p-3 rounded-full">
                <i class="fas fa-users text-purple-600 text-2xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600">Pending Courses</p>
                <p class="text-3xl font-bold text-blue-600"><?= count($pendingCourses) ?></p>
            </div>
            <div class="bg-blue-100 p-3 rounded-full">
                <i class="fas fa-book text-blue-600 text-2xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600">Total Pending</p>
                <p class="text-3xl font-bold text-orange-600"><?= count($pendingCohorts) + count($pendingCourses) ?></p>
            </div>
            <div class="bg-orange-100 p-3 rounded-full">
                <i class="fas fa-clock text-orange-600 text-2xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Pending Cohorts -->
<div class="bg-white rounded-lg shadow mb-8">
    <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
        <h2 class="text-xl font-bold text-gray-900">
            <i class="fas fa-users text-purple-600 mr-2"></i>
            Pending Cohorts (<?= count($pendingCohorts) ?>)
        </h2>
        <?php if (!empty($pendingCohorts)): ?>
            <a href="<?= url('/admin/approvals/cohorts') ?>" class="text-purple-600 hover:text-purple-700 text-sm font-medium">
                View All →
            </a>
        <?php endif; ?>
    </div>
    <div class="p-6">
        <?php if (empty($pendingCohorts)): ?>
            <div class="text-center py-8 text-gray-500">
                <i class="fas fa-check-circle text-6xl mb-3"></i>
                <p class="text-lg">No pending cohorts</p>
                <p class="text-sm">All cohort submissions have been reviewed</p>
            </div>
        <?php else: ?>
            <div class="space-y-4">
                <?php foreach ($pendingCohorts as $cohort): ?>
                    <div class="border border-gray-200 rounded-lg p-4 hover:border-purple-300 transition">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <h3 class="font-bold text-gray-900 text-lg mb-1"><?= htmlspecialchars($cohort['name']) ?></h3>
                                <p class="text-sm text-gray-600 mb-2"><?= htmlspecialchars($cohort['program']) ?></p>
                                
                                <div class="flex items-center gap-4 text-sm text-gray-600 mb-3">
                                    <span>
                                        <i class="fas fa-chalkboard-teacher mr-1"></i>
                                        <?= htmlspecialchars($cohort['facilitator_first_name'] . ' ' . $cohort['facilitator_last_name']) ?>
                                    </span>
                                    <span>
                                        <i class="fas fa-calendar mr-1"></i>
                                        <?= date('M d, Y', strtotime($cohort['start_date'])) ?>
                                    </span>
                                    <span>
                                        <i class="fas fa-book mr-1"></i>
                                        <?= $cohort['course_count'] ?> courses
                                    </span>
                                    <span>
                                        <i class="fas fa-user-graduate mr-1"></i>
                                        Max: <?= $cohort['max_students'] ?>
                                    </span>
                                </div>

                                <?php if (!empty($cohort['description'])): ?>
                                    <p class="text-sm text-gray-700 line-clamp-2"><?= htmlspecialchars($cohort['description']) ?></p>
                                <?php endif; ?>
                            </div>

                            <div class="ml-4 flex flex-col gap-2">
                                <a href="<?= url('/admin/approvals/cohorts/' . $cohort['id']) ?>" 
                                   class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition text-sm font-medium text-center whitespace-nowrap">
                                    <i class="fas fa-eye mr-1"></i>Review
                                </a>
                                <form method="POST" action="<?= url('/admin/approvals/cohorts/' . $cohort['id'] . '/approve') ?>" 
                                      onsubmit="return confirm('Approve this cohort?')">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm font-medium">
                                        <i class="fas fa-check mr-1"></i>Quick Approve
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Pending Courses -->
<div class="bg-white rounded-lg shadow">
    <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
        <h2 class="text-xl font-bold text-gray-900">
            <i class="fas fa-book text-blue-600 mr-2"></i>
            Pending Courses (<?= count($pendingCourses) ?>)
        </h2>
        <?php if (!empty($pendingCourses)): ?>
            <a href="<?= url('/admin/approvals/courses') ?>" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                View All →
            </a>
        <?php endif; ?>
    </div>
    <div class="p-6">
        <?php if (empty($pendingCourses)): ?>
            <div class="text-center py-8 text-gray-500">
                <i class="fas fa-check-circle text-6xl mb-3"></i>
                <p class="text-lg">No pending courses</p>
                <p class="text-sm">All course submissions have been reviewed</p>
            </div>
        <?php else: ?>
            <div class="space-y-4">
                <?php foreach ($pendingCourses as $course): ?>
                    <div class="border border-gray-200 rounded-lg p-4 hover:border-blue-300 transition">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <h3 class="font-bold text-gray-900 text-lg mb-1"><?= htmlspecialchars($course['title']) ?></h3>
                                
                                <div class="flex items-center gap-4 text-sm text-gray-600 mb-3">
                                    <span>
                                        <i class="fas fa-user mr-1"></i>
                                        <?= htmlspecialchars($course['facilitator_first_name'] . ' ' . $course['facilitator_last_name']) ?>
                                    </span>
                                    <span>
                                        <i class="fas fa-signal mr-1"></i>
                                        <?= ucfirst($course['level']) ?>
                                    </span>
                                    <span>
                                        <i class="fas fa-clock mr-1"></i>
                                        <?= $course['duration_hours'] ?>h
                                    </span>
                                    <span>
                                        <i class="fas fa-tag mr-1"></i>
                                        <?= htmlspecialchars($course['category_name'] ?? 'Uncategorized') ?>
                                    </span>
                                </div>

                                <?php if (!empty($course['description'])): ?>
                                    <p class="text-sm text-gray-700 line-clamp-2"><?= htmlspecialchars($course['description']) ?></p>
                                <?php endif; ?>
                            </div>

                            <div class="ml-4 flex flex-col gap-2">
                                <a href="<?= url('/admin/approvals/courses/' . $course['id']) ?>" 
                                   class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm font-medium text-center whitespace-nowrap">
                                    <i class="fas fa-eye mr-1"></i>Review
                                </a>
                                <form method="POST" action="<?= url('/admin/approvals/courses/' . $course['id'] . '/approve') ?>" 
                                      onsubmit="return confirm('Approve this course?')">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm font-medium">
                                        <i class="fas fa-check mr-1"></i>Quick Approve
                                    </button>
                                </form>
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
?>
