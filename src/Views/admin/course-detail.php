<?php
$title = htmlspecialchars($course['title']);
ob_start();
include __DIR__ . '/../partials/admin-sidebar.php';
$sidebarContent = ob_get_clean();
ob_start();
?>

<!-- Page Header -->
<div class="mb-6">
    <div class="flex items-center justify-between mb-4">
        <div>
            <a href="<?= url('/admin/courses') ?>" class="text-primary hover:text-blue-700 text-sm mb-2 inline-block">
                <i class="fas fa-arrow-left mr-2"></i>Back to Courses
            </a>
            <h1 class="text-3xl font-bold text-gray-900"><?= htmlspecialchars($course['title']) ?></h1>
            <p class="text-gray-600"><?= htmlspecialchars($course['category_name'] ?? 'Uncategorized') ?> • <?= $course['duration_hours'] ?> hours</p>
        </div>
        <div class="flex gap-2">
            <?php if ($course['status'] === 'draft'): ?>
                <button onclick="approveCourse(<?= $course['id'] ?>)" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium">
                    <i class="fas fa-check mr-2"></i>Approve & Publish
                </button>
            <?php elseif ($course['status'] === 'published'): ?>
                <button onclick="unpublishCourse(<?= $course['id'] ?>)" class="px-6 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition font-medium">
                    <i class="fas fa-eye-slash mr-2"></i>Unpublish
                </button>
            <?php endif; ?>
            <button onclick="deleteCourse(<?= $course['id'] ?>, '<?= htmlspecialchars($course['title']) ?>')" class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-medium">
                <i class="fas fa-trash mr-2"></i>Delete
            </button>
        </div>
    </div>
</div>

<!-- Course Info -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <!-- Main Info -->
    <div class="lg:col-span-2 bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Course Information</h2>
        
        <?php if ($course['thumbnail']): ?>
            <img src="<?= url('/' . $course['thumbnail']) ?>" alt="" class="w-full h-48 object-cover rounded-lg mb-4">
        <?php endif; ?>
        
        <div class="space-y-4">
            <div>
                <label class="text-sm font-medium text-gray-700">Description</label>
                <p class="text-gray-900 mt-1"><?= nl2br(htmlspecialchars($course['description'])) ?></p>
            </div>
            
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="text-sm font-medium text-gray-700">Level</label>
                    <p class="text-gray-900 mt-1"><?= ucfirst($course['level']) ?></p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-700">Duration</label>
                    <p class="text-gray-900 mt-1"><?= $course['duration_hours'] ?> hours</p>
                </div>
            </div>
            
            <div>
                <label class="text-sm font-medium text-gray-700">Facilitator</label>
                <p class="text-gray-900 mt-1">
                    <?php if (!empty($course['facilitator_first_name'])): ?>
                        <?= htmlspecialchars($course['facilitator_first_name'] . ' ' . $course['facilitator_last_name']) ?>
                    <?php else: ?>
                        <span class="text-gray-400">No facilitator assigned</span>
                    <?php endif; ?>
                </p>
            </div>
        </div>
    </div>

    <!-- Stats -->
    <div class="space-y-4">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Statistics</h3>
            <?php 
            $enrollmentStats = \Nebatech\Models\Course::getEnrollmentStats($course['id']);
            ?>
            <div class="space-y-3">
                <div>
                    <div class="text-sm text-gray-600">Total Enrollments</div>
                    <div class="text-2xl font-bold text-gray-900"><?= $enrollmentStats['total_enrollments'] ?? 0 ?></div>
                </div>
                <div class="border-t border-gray-200 pt-3">
                    <div class="text-xs text-gray-500 mb-2">Enrollment Types</div>
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-sm text-purple-600"><i class="fas fa-users mr-1"></i>Cohort-based</span>
                        <span class="font-bold text-gray-900"><?= $enrollmentStats['cohort_enrollments'] ?? 0 ?></span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-indigo-600"><i class="fas fa-user mr-1"></i>Self-paced</span>
                        <span class="font-bold text-gray-900"><?= $enrollmentStats['self_paced_enrollments'] ?? 0 ?></span>
                    </div>
                </div>
                <div class="border-t border-gray-200 pt-3">
                    <div class="text-sm text-gray-600">Modules</div>
                    <div class="text-2xl font-bold text-gray-900"><?= count($modules) ?></div>
                </div>
                <div>
                    <div class="text-sm text-gray-600">Total Lessons</div>
                    <div class="text-2xl font-bold text-gray-900">
                        <?= array_sum(array_map(fn($m) => count($m['lessons']), $modules)) ?>
                    </div>
                </div>
                <div>
                    <div class="text-sm text-gray-600">Avg Progress</div>
                    <div class="text-2xl font-bold text-gray-900"><?= number_format($enrollmentStats['average_progress'] ?? 0, 0) ?>%</div>
                </div>
                <div>
                    <div class="text-sm text-gray-600">Status</div>
                    <div class="text-lg font-bold <?= $course['status'] === 'published' ? 'text-green-600' : 'text-yellow-600' ?>">
                        <?= ucfirst($course['status']) ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cohorts Teaching This Course -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Active Cohorts</h3>
            <?php 
            $activeCohorts = \Nebatech\Models\Course::getActiveCohorts($course['id']);
            if (empty($activeCohorts)): 
            ?>
                <p class="text-sm text-gray-500 text-center py-4">No active cohorts</p>
            <?php else: ?>
                <div class="space-y-2">
                    <?php foreach ($activeCohorts as $cohort): ?>
                        <a href="<?= url('/admin/cohorts/' . $cohort['id']) ?>" 
                           class="block p-3 bg-purple-50 hover:bg-purple-100 rounded-lg border border-purple-200 transition">
                            <div class="font-semibold text-gray-900 text-sm"><?= htmlspecialchars($cohort['name']) ?></div>
                            <div class="text-xs text-gray-600 mt-1">
                                <i class="fas fa-users mr-1"></i><?= $cohort['student_count'] ?> students
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Course Content -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
    <h2 class="text-xl font-bold text-gray-900 mb-4">Course Content</h2>
    
    <?php if (empty($modules)): ?>
        <p class="text-gray-500 text-center py-8">No modules added yet</p>
    <?php else: ?>
        <div class="space-y-4">
            <?php foreach ($modules as $index => $module): ?>
                <div class="border border-gray-200 rounded-lg">
                    <div class="p-4 bg-gray-50 border-b border-gray-200">
                        <h3 class="font-semibold text-gray-900">
                            Module <?= $index + 1 ?>: <?= htmlspecialchars($module['title']) ?>
                        </h3>
                        <?php if ($module['description']): ?>
                            <p class="text-sm text-gray-600 mt-1"><?= htmlspecialchars($module['description']) ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="p-4">
                        <?php if (empty($module['lessons'])): ?>
                            <p class="text-sm text-gray-500">No lessons in this module</p>
                        <?php else: ?>
                            <ul class="space-y-2">
                                <?php foreach ($module['lessons'] as $lessonIndex => $lesson): ?>
                                    <li class="flex items-center text-sm">
                                        <i class="fas fa-book-open text-primary mr-3"></i>
                                        <span class="text-gray-900"><?= htmlspecialchars($lesson['title']) ?></span>
                                        <span class="ml-auto text-gray-500"><?= ucfirst($lesson['type']) ?></span>
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

<!-- Enrollments -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
    <h2 class="text-xl font-bold text-gray-900 mb-4">Enrolled Students (<?= count($enrollments) ?>)</h2>
    
    <?php if (empty($enrollments)): ?>
        <p class="text-gray-500 text-center py-8">No students enrolled yet</p>
    <?php else: ?>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Student</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Progress</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Enrolled</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php foreach ($enrollments as $enrollment): ?>
                        <tr>
                            <td class="px-4 py-3">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-primary text-white rounded-full flex items-center justify-center font-bold text-xs mr-2">
                                        <?= strtoupper(substr($enrollment['first_name'], 0, 1) . substr($enrollment['last_name'], 0, 1)) ?>
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">
                                            <?= htmlspecialchars($enrollment['first_name'] . ' ' . $enrollment['last_name']) ?>
                                        </div>
                                        <div class="text-xs text-gray-500"><?= htmlspecialchars($enrollment['email']) ?></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <?php if (!empty($enrollment['cohort_id'])): ?>
                                    <span class="px-2 py-1 text-xs rounded-full bg-purple-100 text-purple-700" title="<?= htmlspecialchars($enrollment['cohort_name'] ?? 'Cohort') ?>">
                                        <i class="fas fa-users mr-1"></i>Cohort
                                    </span>
                                <?php else: ?>
                                    <span class="px-2 py-1 text-xs rounded-full bg-indigo-100 text-indigo-700">
                                        <i class="fas fa-user mr-1"></i>Self-paced
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center">
                                    <div class="w-full bg-gray-200 rounded-full h-2 mr-2">
                                        <div class="bg-primary h-2 rounded-full" style="width: <?= $enrollment['progress'] ?>%"></div>
                                    </div>
                                    <span class="text-sm text-gray-600"><?= number_format($enrollment['progress'], 0) ?>%</span>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 text-xs rounded-full <?= $enrollment['status'] === 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' ?>">
                                    <?= ucfirst($enrollment['status']) ?>
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-500">
                                <?= date('M d, Y', strtotime($enrollment['enrolled_at'])) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<script>
async function approveCourse(courseId) {
    const confirmed = await confirmAction('Approve and publish this course? It will be visible to all students.', {
        title: 'Approve Course',
        confirmText: 'Approve',
        type: 'success'
    });
    
    if (!confirmed) return;

    fetch(`<?= url('/admin/courses/') ?>${courseId}/approve`, {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `_token=<?= csrf_token() ?>`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showSuccess('Course approved and published successfully');
            setTimeout(() => window.location.reload(), 1000);
        } else {
            showError('Error: ' + (data.error || 'Failed to approve course'));
        }
    })
    .catch(error => {
        showError('An error occurred: ' + error.message);
    });
}

async function unpublishCourse(courseId) {
    const confirmed = await confirmAction('Unpublish this course? It will no longer be visible to students.', {
        title: 'Unpublish Course',
        confirmText: 'Unpublish',
        type: 'warning'
    });
    
    if (!confirmed) return;

    fetch(`<?= url('/admin/courses/') ?>${courseId}/unpublish`, {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `_token=<?= csrf_token() ?>`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showSuccess('Course unpublished successfully');
            setTimeout(() => window.location.reload(), 1000);
        } else {
            showError('Error: ' + (data.error || 'Failed to unpublish course'));
        }
    })
    .catch(error => {
        showError('An error occurred: ' + error.message);
    });
}

async function deleteCourse(courseId, courseName) {
    const confirmed = await confirmAction(`Delete "${courseName}"? This action cannot be undone.`, {
        title: 'Delete Course',
        confirmText: 'Delete',
        type: 'danger'
    });
    
    if (!confirmed) return;

    fetch(`<?= url('/admin/courses/') ?>${courseId}/delete`, {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `_token=<?= csrf_token() ?>`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showSuccess('Course deleted successfully');
            setTimeout(() => window.location.href = '<?= url('/admin/courses') ?>', 1000);
        } else {
            showError('Error: ' + (data.error || 'Failed to delete course'));
        }
    })
    .catch(error => {
        showError('An error occurred: ' + error.message);
    });
}
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/dashboard.php';
?>
