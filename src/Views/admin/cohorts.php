<?php
$title = 'Cohort Management';
ob_start();
include __DIR__ . '/../partials/admin-sidebar.php';
$sidebarContent = ob_get_clean();
ob_start();
?>

<!-- Page Header -->
<div class="mb-6">
    <div class="flex items-center justify-between mb-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Cohort Management</h1>
            <p class="text-gray-600">Manage learning cohorts and student assignments</p>
        </div>
        <a href="<?= url('/admin/cohorts/create') ?>" class="bg-primary hover:bg-primary-dark text-white px-6 py-3 rounded-lg font-semibold transition flex items-center gap-2">
            <i class="fas fa-plus"></i>
            Create New Cohort
        </a>
    </div>
</div>

<!-- Filters -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6">
    <form method="GET" action="<?= url('/admin/cohorts') ?>" class="flex flex-wrap gap-4">
        <!-- Status Filter -->
        <div class="flex-1 min-w-[200px]">
            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
            <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                <option value="">All Statuses</option>
                <option value="upcoming" <?= ($currentStatus === 'upcoming') ? 'selected' : '' ?>>Upcoming</option>
                <option value="active" <?= ($currentStatus === 'active') ? 'selected' : '' ?>>Active</option>
                <option value="completed" <?= ($currentStatus === 'completed') ? 'selected' : '' ?>>Completed</option>
            </select>
        </div>

        <!-- Program Filter -->
        <div class="flex-1 min-w-[200px]">
            <label class="block text-sm font-medium text-gray-700 mb-2">Program</label>
            <select name="program" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                <option value="">All Programs</option>
                <?php foreach ($programs as $slug => $program): ?>
                    <option value="<?= $slug ?>" <?= ($currentProgram === $slug) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($program['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Approval Status Filter -->
        <div class="flex-1 min-w-[200px]">
            <label class="block text-sm font-medium text-gray-700 mb-2">Approval Status</label>
            <select name="approval_status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                <option value="">All (Submitted)</option>
                <option value="pending_approval" <?= ($currentApprovalStatus === 'pending_approval') ? 'selected' : '' ?>>Pending Approval</option>
                <option value="approved" <?= ($currentApprovalStatus === 'approved') ? 'selected' : '' ?>>Approved</option>
                <option value="rejected" <?= ($currentApprovalStatus === 'rejected') ? 'selected' : '' ?>>Rejected</option>
            </select>
        </div>

        <!-- Actions -->
        <div class="flex items-end gap-2">
            <button type="submit" class="bg-primary hover:bg-primary-dark text-white px-6 py-2 rounded-lg font-semibold transition">
                <i class="fas fa-filter mr-2"></i>Filter
            </button>
            <a href="<?= url('/admin/cohorts') ?>" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2 rounded-lg font-semibold transition">
                Clear
            </a>
        </div>
    </form>
</div>

<!-- Cohorts Grid -->
<?php if (empty($cohorts)): ?>
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
        <div class="text-gray-400 mb-4">
            <i class="fas fa-user-friends text-6xl"></i>
        </div>
        <h3 class="text-xl font-bold text-gray-900 mb-2">No Cohorts Found</h3>
        <p class="text-gray-600 mb-6">Get started by creating your first cohort</p>
        <a href="<?= url('/admin/cohorts/create') ?>" class="inline-block bg-primary hover:bg-primary-dark text-white px-6 py-3 rounded-lg font-semibold transition">
            <i class="fas fa-plus mr-2"></i>Create Cohort
        </a>
    </div>
<?php else: ?>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($cohorts as $cohort): ?>
            <?php
            $statusColors = [
                'upcoming' => 'bg-blue-100 text-blue-800',
                'active' => 'bg-green-100 text-green-800',
                'completed' => 'bg-gray-100 text-gray-800'
            ];
            $statusColor = $statusColors[$cohort['status']] ?? 'bg-gray-100 text-gray-800';
            
            $approvalColors = [
                'pending_approval' => 'bg-yellow-100 text-yellow-800',
                'approved' => 'bg-green-100 text-green-800',
                'rejected' => 'bg-red-100 text-red-800'
            ];
            $approvalColor = $approvalColors[$cohort['approval_status']] ?? 'bg-gray-100 text-gray-800';
            $programInfo = $programs[$cohort['program']] ?? null;
            ?>
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition">
                <!-- Header -->
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-gray-900 mb-1">
                                <?= htmlspecialchars($cohort['name']) ?>
                            </h3>
                            <p class="text-sm text-gray-600">
                                <?= $programInfo ? htmlspecialchars($programInfo['name']) : htmlspecialchars(ucwords(str_replace('-', ' ', $cohort['program']))) ?>
                            </p>
                        </div>
                        <div class="flex flex-col gap-2">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold <?= $statusColor ?>">
                                <?= ucfirst($cohort['status']) ?>
                            </span>
                            <?php if (!empty($cohort['approval_status'])): ?>
                                <span class="px-3 py-1 rounded-full text-xs font-semibold <?= $approvalColor ?>">
                                    <?php if ($cohort['approval_status'] === 'pending_approval'): ?>
                                        <i class="fas fa-clock mr-1"></i>Pending
                                    <?php elseif ($cohort['approval_status'] === 'approved'): ?>
                                        <i class="fas fa-check mr-1"></i>Approved
                                    <?php elseif ($cohort['approval_status'] === 'rejected'): ?>
                                        <i class="fas fa-times mr-1"></i>Rejected
                                    <?php endif; ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Details -->
                <div class="p-6 space-y-3">
                    <!-- Facilitator -->
                    <?php if (!empty($cohort['facilitator_first_name'])): ?>
                        <div class="flex items-center gap-3 text-sm">
                            <i class="fas fa-chalkboard-teacher text-gray-400 w-5"></i>
                            <span class="text-gray-700">
                                <?= htmlspecialchars($cohort['facilitator_first_name'] . ' ' . $cohort['facilitator_last_name']) ?>
                            </span>
                        </div>
                    <?php endif; ?>

                    <!-- Students -->
                    <div class="flex items-center gap-3 text-sm">
                        <i class="fas fa-users text-gray-400 w-5"></i>
                        <span class="text-gray-700">
                            <?= (int)$cohort['student_count'] ?> / <?= (int)$cohort['max_students'] ?> Students
                        </span>
                    </div>

                    <!-- Start Date -->
                    <div class="flex items-center gap-3 text-sm">
                        <i class="fas fa-calendar text-gray-400 w-5"></i>
                        <span class="text-gray-700">
                            Starts: <?= date('M d, Y', strtotime($cohort['start_date'])) ?>
                        </span>
                    </div>

                    <!-- End Date -->
                    <?php if (!empty($cohort['end_date'])): ?>
                        <div class="flex items-center gap-3 text-sm">
                            <i class="fas fa-calendar-check text-gray-400 w-5"></i>
                            <span class="text-gray-700">
                                Ends: <?= date('M d, Y', strtotime($cohort['end_date'])) ?>
                            </span>
                        </div>
                    <?php endif; ?>

                    <!-- Progress Bar -->
                    <?php
                    $capacity = $cohort['max_students'] > 0 ? ($cohort['student_count'] / $cohort['max_students']) * 100 : 0;
                    $capacityColor = $capacity >= 90 ? 'bg-red-500' : ($capacity >= 70 ? 'bg-yellow-500' : 'bg-green-500');
                    ?>
                    <div class="pt-2">
                        <div class="flex items-center justify-between text-xs text-gray-600 mb-1">
                            <span>Capacity</span>
                            <span><?= number_format($capacity, 0) ?>%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="<?= $capacityColor ?> h-2 rounded-full transition-all" style="width: <?= $capacity ?>%"></div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex gap-2">
                    <a href="<?= url('/admin/cohorts/' . $cohort['id']) ?>" class="flex-1 text-center bg-primary hover:bg-primary-dark text-white px-4 py-2 rounded-lg font-semibold transition text-sm">
                        <i class="fas fa-eye mr-1"></i>View
                    </a>
                    <button onclick="deleteCohort(<?= $cohort['id'] ?>, '<?= htmlspecialchars($cohort['name']) ?>')" class="bg-red-100 hover:bg-red-200 text-red-700 px-4 py-2 rounded-lg font-semibold transition text-sm">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<script>
async function deleteCohort(cohortId, cohortName) {
    const confirmed = await confirmAction(`Are you sure you want to delete the cohort "${cohortName}"? This action cannot be undone.`, {
        title: 'Delete Cohort',
        confirmText: 'Delete',
        type: 'danger'
    });
    
    if (!confirmed) return;

    fetch('<?= url('/admin/cohorts/delete') ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `cohort_id=${cohortId}&_token=<?= csrf_token() ?>`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showSuccess('Cohort deleted successfully');
            setTimeout(() => window.location.reload(), 1000);
        } else {
            showError('Error: ' + (data.error || 'Failed to delete cohort'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showError('An error occurred while deleting the cohort');
    });
}
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/dashboard.php';
?>
