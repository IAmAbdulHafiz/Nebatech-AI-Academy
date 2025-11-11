<?php
$title = 'Enrollment Management';
ob_start();
include __DIR__ . '/../partials/admin-sidebar.php';
$sidebarContent = ob_get_clean();
ob_start();
?>

<div class="mb-6">
    <div class="flex items-center justify-between mb-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Enrollment Management</h1>
            <p class="text-gray-600">Manage student course enrollments</p>
        </div>
        <a href="<?= url('/admin/enrollments/create') ?>" class="bg-primary hover:bg-primary-dark text-white px-6 py-3 rounded-lg font-semibold transition">
            <i class="fas fa-plus mr-2"></i>Manual Enrollment
        </a>
    </div>
</div>

<!-- Filters -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6">
    <form method="GET" class="flex flex-wrap gap-4">
        <div class="flex-1 min-w-[200px]">
            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
            <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                <option value="">All Statuses</option>
                <option value="active" <?= ($currentStatus === 'active') ? 'selected' : '' ?>>Active</option>
                <option value="suspended" <?= ($currentStatus === 'suspended') ? 'selected' : '' ?>>Suspended</option>
                <option value="completed" <?= ($currentStatus === 'completed') ? 'selected' : '' ?>>Completed</option>
                <option value="cancelled" <?= ($currentStatus === 'cancelled') ? 'selected' : '' ?>>Cancelled</option>
                <option value="dropped" <?= ($currentStatus === 'dropped') ? 'selected' : '' ?>>Dropped</option>
            </select>
        </div>
        <div class="flex-1 min-w-[200px]">
            <label class="block text-sm font-medium text-gray-700 mb-2">Course</label>
            <select name="course_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                <option value="">All Courses</option>
                <?php foreach ($courses as $course): ?>
                    <option value="<?= $course['id'] ?>" <?= ($currentCourseId == $course['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($course['title']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="flex items-end gap-2">
            <button type="submit" class="bg-primary hover:bg-primary-dark text-white px-6 py-2 rounded-lg font-semibold transition">
                <i class="fas fa-filter mr-2"></i>Filter
            </button>
            <a href="<?= url('/admin/enrollments') ?>" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2 rounded-lg font-semibold transition">Clear</a>
        </div>
    </form>
</div>

<!-- Enrollments Table -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Student</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Course</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Progress</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Enrolled</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            <?php if (empty($enrollments)): ?>
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                        <i class="fas fa-inbox text-4xl mb-3"></i>
                        <p>No enrollments found</p>
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($enrollments as $enrollment): ?>
                    <?php
                    $statusColors = [
                        'active' => 'bg-green-100 text-green-800',
                        'suspended' => 'bg-yellow-100 text-yellow-800',
                        'completed' => 'bg-blue-100 text-blue-800',
                        'cancelled' => 'bg-red-100 text-red-800',
                        'dropped' => 'bg-gray-100 text-gray-800'
                    ];
                    $statusColor = $statusColors[$enrollment['status']] ?? 'bg-gray-100 text-gray-800';
                    ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-primary text-white rounded-full flex items-center justify-center font-bold text-sm">
                                    <?= strtoupper(substr($enrollment['first_name'], 0, 1) . substr($enrollment['last_name'], 0, 1)) ?>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900"><?= htmlspecialchars($enrollment['first_name'] . ' ' . $enrollment['last_name']) ?></p>
                                    <p class="text-sm text-gray-600"><?= htmlspecialchars($enrollment['email']) ?></p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="font-medium text-gray-900"><?= htmlspecialchars($enrollment['course_title']) ?></p>
                        </td>
                        <td class="px-6 py-4">
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-primary h-2 rounded-full" style="width: <?= $enrollment['progress'] ?>%"></div>
                            </div>
                            <p class="text-xs text-gray-600 mt-1"><?= number_format($enrollment['progress'], 0) ?>%</p>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold <?= $statusColor ?>">
                                <?= ucfirst($enrollment['status']) ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            <?= date('M d, Y', strtotime($enrollment['enrolled_at'])) ?>
                        </td>
                        <td class="px-6 py-4">
                            <select onchange="updateEnrollmentStatus(<?= $enrollment['id'] ?>, this.value)" class="text-sm border border-gray-300 rounded px-2 py-1">
                                <option value="">Change Status...</option>
                                <option value="active">Active</option>
                                <option value="suspended">Suspended</option>
                                <option value="completed">Completed</option>
                                <option value="cancelled">Cancelled</option>
                                <option value="dropped">Dropped</option>
                            </select>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script>
async function updateEnrollmentStatus(enrollmentId, status) {
    if (!status) return;
    
    const confirmed = await confirmAction(`Change enrollment status to "${status}"?`, {
        title: 'Update Enrollment Status',
        confirmText: 'Update',
        type: 'info'
    });
    
    if (!confirmed) return;

    fetch('<?= url('/admin/enrollments/update-status') ?>', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `enrollment_id=${enrollmentId}&status=${status}&_token=<?= csrf_token() ?>`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showSuccess('Status updated successfully');
            setTimeout(() => window.location.reload(), 1000);
        } else {
            showError('Error: ' + (data.error || 'Failed to update status'));
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
