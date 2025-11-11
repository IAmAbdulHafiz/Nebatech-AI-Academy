<?php
$title = 'Application Details';
ob_start();
include __DIR__ . '/../partials/student-sidebar.php';
$sidebarContent = ob_get_clean();
ob_start();
?>

<!-- Page Header -->
<div class="mb-6">
    <div class="flex items-center gap-4 mb-4">
        <a href="<?= url('/my-applications') ?>" class="text-gray-600 hover:text-primary">
            <i class="fas fa-arrow-left text-xl"></i>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Application Details</h1>
            <p class="text-gray-600">View your application information</p>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Status Alert -->
        <?php if ($application['status'] === 'info_requested'): ?>
            <div class="bg-blue-50 border-l-4 border-blue-500 p-6 rounded-lg">
                <div class="flex items-start">
                    <i class="fas fa-info-circle text-blue-500 text-2xl mr-4 mt-1"></i>
                    <div class="flex-1">
                        <h3 class="font-bold text-blue-900 mb-2">Action Required</h3>
                        <p class="text-blue-800 mb-4"><?= htmlspecialchars($application['admin_notes']) ?></p>
                        <a href="<?= url('/application/' . $application['uuid'] . '/update') ?>" 
                           class="inline-block px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                            Update Application
                        </a>
                    </div>
                </div>
            </div>
        <?php elseif ($application['status'] === 'approved'): ?>
            <div class="bg-green-50 border-l-4 border-green-500 p-6 rounded-lg">
                <div class="flex items-start">
                    <i class="fas fa-check-circle text-green-500 text-2xl mr-4 mt-1"></i>
                    <div>
                        <h3 class="font-bold text-green-900 mb-2">Congratulations!</h3>
                        <p class="text-green-800">Your application has been approved. Check your email for enrollment details.</p>
                    </div>
                </div>
            </div>
        <?php elseif ($application['status'] === 'rejected'): ?>
            <div class="bg-red-50 border-l-4 border-red-500 p-6 rounded-lg">
                <div class="flex items-start">
                    <i class="fas fa-times-circle text-red-500 text-2xl mr-4 mt-1"></i>
                    <div>
                        <h3 class="font-bold text-red-900 mb-2">Application Not Approved</h3>
                        <p class="text-red-800">Unfortunately, your application was not approved at this time.</p>
                        <?php if (!empty($application['admin_notes'])): ?>
                            <p class="text-red-700 mt-2 text-sm"><?= htmlspecialchars($application['admin_notes']) ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Program Information -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-bold text-gray-900">Program Information</h2>
            </div>
            <div class="p-6">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Program</label>
                    <p class="text-lg font-semibold text-gray-900"><?= htmlspecialchars(ucwords(str_replace('-', ' ', $application['program']))) ?></p>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Application Date</label>
                    <p class="text-gray-900"><?= date('F d, Y', strtotime($application['created_at'])) ?></p>
                </div>
                <?php if (!empty($application['reviewed_at'])): ?>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Review Date</label>
                        <p class="text-gray-900"><?= date('F d, Y', strtotime($application['reviewed_at'])) ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Educational Background -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-bold text-gray-900">Educational Background</h2>
            </div>
            <div class="p-6">
                <p class="text-gray-700 whitespace-pre-wrap"><?= htmlspecialchars($application['educational_background']) ?></p>
            </div>
        </div>

        <!-- Motivation Statement -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-bold text-gray-900">Motivation Statement</h2>
            </div>
            <div class="p-6">
                <p class="text-gray-700 whitespace-pre-wrap"><?= htmlspecialchars($application['motivation_statement']) ?></p>
            </div>
        </div>

        <!-- Supporting Documents -->
        <?php if (!empty($application['document_path'])): ?>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-bold text-gray-900">Supporting Documents</h2>
            </div>
            <div class="p-6">
                <a href="<?= htmlspecialchars($application['document_path']) ?>" target="_blank" 
                   class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                    <i class="fas fa-file-download mr-2"></i>Download Document
                </a>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Status Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="font-bold text-gray-900 mb-4">Application Status</h3>
            <?php
            $statusConfig = [
                'pending' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-700', 'border' => 'border-yellow-200', 'icon' => 'fa-clock'],
                'approved' => ['bg' => 'bg-green-100', 'text' => 'text-green-700', 'border' => 'border-green-200', 'icon' => 'fa-check-circle'],
                'rejected' => ['bg' => 'bg-red-100', 'text' => 'text-red-700', 'border' => 'border-red-200', 'icon' => 'fa-times-circle'],
                'info_requested' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-700', 'border' => 'border-blue-200', 'icon' => 'fa-info-circle']
            ];
            $config = $statusConfig[$application['status']] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-700', 'border' => 'border-gray-200', 'icon' => 'fa-circle'];
            ?>
            <div class="<?= $config['bg'] ?> <?= $config['border'] ?> border-2 rounded-lg p-4 text-center">
                <i class="fas <?= $config['icon'] ?> text-3xl <?= $config['text'] ?> mb-2"></i>
                <p class="text-lg font-bold <?= $config['text'] ?>">
                    <?= ucfirst(str_replace('_', ' ', $application['status'])) ?>
                </p>
            </div>
        </div>

        <!-- Quick Info -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="font-bold text-gray-900 mb-4">Quick Info</h3>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-600">Application ID</span>
                    <span class="font-medium text-gray-900">#<?= $application['id'] ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Submitted</span>
                    <span class="font-medium text-gray-900"><?= date('M d, Y', strtotime($application['created_at'])) ?></span>
                </div>
                <?php if (!empty($application['referral_source'])): ?>
                <div class="flex justify-between">
                    <span class="text-gray-600">Referral</span>
                    <span class="font-medium text-gray-900"><?= htmlspecialchars($application['referral_source']) ?></span>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Actions -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="font-bold text-gray-900 mb-4">Actions</h3>
            <div class="space-y-2">
                <?php if ($application['status'] === 'info_requested'): ?>
                    <a href="<?= url('/application/' . $application['uuid'] . '/update') ?>" 
                       class="block w-full text-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                        <i class="fas fa-edit mr-2"></i>Update Application
                    </a>
                <?php endif; ?>
                <a href="<?= url('/my-applications') ?>" 
                   class="block w-full text-center px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-medium">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Applications
                </a>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/dashboard.php';
?>
