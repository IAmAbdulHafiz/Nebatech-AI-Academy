<?php
// Cohort card partial - displays a single cohort with status-specific actions
$approvalStatusColors = [
    'draft' => 'bg-gray-100 text-gray-800',
    'pending_approval' => 'bg-yellow-100 text-yellow-800',
    'approved' => 'bg-green-100 text-green-800',
    'rejected' => 'bg-red-100 text-red-800'
];
$approvalStatusColor = $approvalStatusColors[$cohort['approval_status']] ?? 'bg-gray-100 text-gray-800';
?>

<div class="border border-gray-200 rounded-lg p-6 hover:border-purple-300 hover:shadow-md transition">
    <div class="flex items-start justify-between mb-4">
        <div class="flex-1">
            <h3 class="text-xl font-bold text-gray-900 mb-2"><?= htmlspecialchars($cohort['name']) ?></h3>
            <p class="text-sm text-gray-600 mb-2">
                <i class="fas fa-graduation-cap mr-1"></i>
                <?= htmlspecialchars($cohort['program']) ?>
            </p>
        </div>
        <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full <?= $approvalStatusColor ?>">
            <?php
            $statusLabels = [
                'draft' => 'Draft',
                'pending_approval' => 'Pending',
                'approved' => 'Approved',
                'rejected' => 'Needs Revision'
            ];
            echo $statusLabels[$cohort['approval_status']] ?? 'Unknown';
            ?>
        </span>
    </div>

    <!-- Cohort Details -->
    <div class="grid grid-cols-2 gap-4 mb-4 text-sm">
        <div>
            <p class="text-gray-600">Start Date</p>
            <p class="font-semibold text-gray-900"><?= date('M d, Y', strtotime($cohort['start_date'])) ?></p>
        </div>
        <div>
            <p class="text-gray-600">Students</p>
            <p class="font-semibold text-gray-900"><?= $cohort['student_count'] ?> / <?= $cohort['max_students'] ?></p>
        </div>
    </div>

    <?php if (!empty($cohort['description'])): ?>
        <p class="text-sm text-gray-700 mb-4 line-clamp-2"><?= htmlspecialchars($cohort['description']) ?></p>
    <?php endif; ?>

    <!-- Rejection Reason (if rejected) -->
    <?php if ($cohort['approval_status'] === 'rejected' && !empty($cohort['rejection_reason'])): ?>
        <div class="bg-red-50 border border-red-200 rounded-lg p-3 mb-4">
            <p class="text-sm font-semibold text-red-900 mb-1">
                <i class="fas fa-exclamation-triangle mr-1"></i>
                Admin Feedback:
            </p>
            <p class="text-sm text-red-800"><?= htmlspecialchars($cohort['rejection_reason']) ?></p>
        </div>
    <?php endif; ?>

    <!-- Actions based on status -->
    <div class="flex items-center gap-2">
        <a href="<?= url('/facilitator/cohorts/' . $cohort['id']) ?>" 
           class="flex-1 px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition text-center text-sm font-medium">
            <i class="fas fa-eye mr-1"></i>View Details
        </a>

        <?php if ($cohort['approval_status'] === 'draft'): ?>
            <button onclick="submitForApproval(<?= $cohort['id'] ?>, '<?= htmlspecialchars($cohort['name']) ?>')"
                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm font-medium">
                <i class="fas fa-paper-plane mr-1"></i>Submit
            </button>
        <?php elseif ($cohort['approval_status'] === 'rejected'): ?>
            <button onclick="submitForApproval(<?= $cohort['id'] ?>, '<?= htmlspecialchars($cohort['name']) ?>')"
                    class="px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition text-sm font-medium">
                <i class="fas fa-redo mr-1"></i>Resubmit
            </button>
        <?php elseif ($cohort['approval_status'] === 'approved'): ?>
            <button onclick="inviteStudents(<?= $cohort['id'] ?>)"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm font-medium">
                <i class="fas fa-user-plus mr-1"></i>Invite
            </button>
        <?php endif; ?>
    </div>
</div>
