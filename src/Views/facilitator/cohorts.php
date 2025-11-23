<?php
$title = 'My Cohorts';
ob_start();
include __DIR__ . '/../partials/facilitator-sidebar.php';
$sidebarContent = ob_get_clean();
ob_start();
?>

<!-- Page Header -->
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">My Cohorts</h1>
            <p class="text-gray-600">Create and manage your student cohorts</p>
        </div>
        <a href="<?= url('/facilitator/cohorts/create') ?>" 
           class="px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition font-medium shadow-lg hover:shadow-xl">
            <i class="fas fa-plus mr-2"></i>Create Cohort
        </a>
    </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600">Drafts</p>
                <p class="text-2xl font-bold text-gray-800"><?= count($drafts) ?></p>
            </div>
            <div class="bg-gray-100 p-3 rounded-full">
                <i class="fas fa-file-alt text-gray-600 text-xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600">Pending</p>
                <p class="text-2xl font-bold text-yellow-600"><?= count($pending) ?></p>
            </div>
            <div class="bg-yellow-100 p-3 rounded-full">
                <i class="fas fa-clock text-yellow-600 text-xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600">Approved</p>
                <p class="text-2xl font-bold text-green-600"><?= count($approved) ?></p>
            </div>
            <div class="bg-green-100 p-3 rounded-full">
                <i class="fas fa-check-circle text-green-600 text-xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600">Needs Revision</p>
                <p class="text-2xl font-bold text-red-600"><?= count($rejected) ?></p>
            </div>
            <div class="bg-red-100 p-3 rounded-full">
                <i class="fas fa-exclamation-circle text-red-600 text-xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Tabs -->
<div class="bg-white rounded-lg shadow mb-6" x-data="{ activeTab: 'drafts' }">
    <div class="border-b border-gray-200">
        <nav class="flex -mb-px">
            <button @click="activeTab = 'drafts'" 
                    :class="activeTab === 'drafts' ? 'border-purple-500 text-purple-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                    class="px-6 py-4 border-b-2 font-medium text-sm transition">
                <i class="fas fa-file-alt mr-2"></i>
                Drafts (<?= count($drafts) ?>)
            </button>
            <button @click="activeTab = 'pending'" 
                    :class="activeTab === 'pending' ? 'border-yellow-500 text-yellow-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                    class="px-6 py-4 border-b-2 font-medium text-sm transition">
                <i class="fas fa-clock mr-2"></i>
                Pending (<?= count($pending) ?>)
            </button>
            <button @click="activeTab = 'approved'" 
                    :class="activeTab === 'approved' ? 'border-green-500 text-green-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                    class="px-6 py-4 border-b-2 font-medium text-sm transition">
                <i class="fas fa-check-circle mr-2"></i>
                Approved (<?= count($approved) ?>)
            </button>
            <button @click="activeTab = 'rejected'" 
                    :class="activeTab === 'rejected' ? 'border-red-500 text-red-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                    class="px-6 py-4 border-b-2 font-medium text-sm transition">
                <i class="fas fa-exclamation-circle mr-2"></i>
                Needs Revision (<?= count($rejected) ?>)
            </button>
        </nav>
    </div>

    <!-- Drafts Tab -->
    <div x-show="activeTab === 'drafts'" class="p-6">
        <?php if (empty($drafts)): ?>
            <div class="text-center py-12 text-gray-500">
                <i class="fas fa-file-alt text-6xl mb-4"></i>
                <p class="text-lg font-semibold">No Draft Cohorts</p>
                <p class="text-sm">Create a new cohort to get started</p>
            </div>
        <?php else: ?>
            <div class="space-y-4">
                <?php foreach ($drafts as $cohort): ?>
                    <?php include __DIR__ . '/_cohort-card.php'; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Pending Tab -->
    <div x-show="activeTab === 'pending'" class="p-6">
        <?php if (empty($pending)): ?>
            <div class="text-center py-12 text-gray-500">
                <i class="fas fa-clock text-6xl mb-4"></i>
                <p class="text-lg font-semibold">No Pending Cohorts</p>
                <p class="text-sm">Cohorts awaiting admin approval will appear here</p>
            </div>
        <?php else: ?>
            <div class="space-y-4">
                <?php foreach ($pending as $cohort): ?>
                    <?php include __DIR__ . '/_cohort-card.php'; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Approved Tab -->
    <div x-show="activeTab === 'approved'" class="p-6">
        <?php if (empty($approved)): ?>
            <div class="text-center py-12 text-gray-500">
                <i class="fas fa-check-circle text-6xl mb-4"></i>
                <p class="text-lg font-semibold">No Approved Cohorts</p>
                <p class="text-sm">Approved cohorts will appear here</p>
            </div>
        <?php else: ?>
            <div class="space-y-4">
                <?php foreach ($approved as $cohort): ?>
                    <?php include __DIR__ . '/_cohort-card.php'; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Rejected Tab -->
    <div x-show="activeTab === 'rejected'" class="p-6">
        <?php if (empty($rejected)): ?>
            <div class="text-center py-12 text-gray-500">
                <i class="fas fa-check-double text-6xl mb-4 text-green-500"></i>
                <p class="text-lg font-semibold text-green-600">All Clear!</p>
                <p class="text-sm">No cohorts need revision</p>
            </div>
        <?php else: ?>
            <div class="space-y-4">
                <?php foreach ($rejected as $cohort): ?>
                    <?php include __DIR__ . '/_cohort-card.php'; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Submit for Approval Modal -->
<div id="submitApprovalModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg max-w-md w-full p-6">
        <h3 class="text-xl font-bold text-gray-900 mb-4">
            <i class="fas fa-paper-plane text-blue-600 mr-2"></i>Submit for Approval
        </h3>
        
        <p class="text-gray-700 mb-4">
            You're about to submit <strong id="modalCohortName"></strong> for admin approval.
        </p>

        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
            <div class="flex items-start gap-3">
                <i class="fas fa-info-circle text-blue-600 mt-1"></i>
                <div class="text-sm text-blue-800">
                    <p class="font-semibold mb-1">Before submitting, make sure:</p>
                    <ul class="list-disc list-inside space-y-1">
                        <li>All necessary courses have been added</li>
                        <li>Cohort details are complete and accurate</li>
                        <li>Start and end dates are correct</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="flex gap-3">
            <button type="button" onclick="confirmSubmitForApproval()" 
                    class="flex-1 px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                <i class="fas fa-check mr-2"></i>Submit
            </button>
            <button type="button" onclick="closeSubmitModal()" 
                    class="flex-1 px-4 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-medium">
                Cancel
            </button>
        </div>
    </div>
</div>

<style>
@keyframes slide-in {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

.animate-slide-in {
    animation: slide-in 0.3s ease-out;
    transition: all 0.3s ease-out;
}
</style>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/dashboard.php';
?>
