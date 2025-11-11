<?php
$title = 'My Applications';
ob_start();
include __DIR__ . '/../partials/student-sidebar.php';
$sidebarContent = ob_get_clean();
ob_start();
?>

<!-- Page Header -->
<div class="mb-6 flex items-center justify-between">
    <div>
        <h1 class="text-3xl font-bold text-gray-900 mb-2">My Applications</h1>
        <p class="text-gray-600">Track the status of your program applications</p>
    </div>
    <a href="<?= url('/apply') ?>" class="px-6 py-3 bg-primary text-white rounded-lg hover:bg-blue-700 transition font-medium">
        <i class="fas fa-plus mr-2"></i>New Application
    </a>
</div>

<!-- Applications List -->
<?php if (empty($applications)): ?>
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
        <i class="fas fa-file-alt text-6xl text-gray-300 mb-4"></i>
        <h3 class="text-xl font-bold text-gray-900 mb-2">No Applications Yet</h3>
        <p class="text-gray-600 mb-6">You haven't submitted any applications. Start your learning journey today!</p>
        <a href="<?= url('/apply') ?>" class="inline-block px-6 py-3 bg-primary text-white rounded-lg hover:bg-blue-700 transition font-medium">
            <i class="fas fa-paper-plane mr-2"></i>Apply for a Program
        </a>
    </div>
<?php else: ?>
    <div class="space-y-4">
        <?php foreach ($applications as $application): ?>
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-3">
                            <h3 class="text-xl font-bold text-gray-900">
                                <?= htmlspecialchars(ucwords(str_replace('-', ' ', $application['program']))) ?>
                            </h3>
                            <?php
                            $statusConfig = [
                                'pending' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-700', 'icon' => 'fa-clock'],
                                'approved' => ['bg' => 'bg-green-100', 'text' => 'text-green-700', 'icon' => 'fa-check-circle'],
                                'rejected' => ['bg' => 'bg-red-100', 'text' => 'text-red-700', 'icon' => 'fa-times-circle'],
                                'info_requested' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-700', 'icon' => 'fa-info-circle']
                            ];
                            $config = $statusConfig[$application['status']] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-700', 'icon' => 'fa-circle'];
                            ?>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium <?= $config['bg'] ?> <?= $config['text'] ?>">
                                <i class="fas <?= $config['icon'] ?> mr-2"></i>
                                <?= ucfirst(str_replace('_', ' ', $application['status'])) ?>
                            </span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                            <div>
                                <span class="text-sm text-gray-500">Applied On</span>
                                <p class="font-medium text-gray-900"><?= date('M d, Y', strtotime($application['created_at'])) ?></p>
                            </div>
                            <?php if (!empty($application['reviewed_at'])): ?>
                            <div>
                                <span class="text-sm text-gray-500">Reviewed On</span>
                                <p class="font-medium text-gray-900"><?= date('M d, Y', strtotime($application['reviewed_at'])) ?></p>
                            </div>
                            <?php endif; ?>
                            <div>
                                <span class="text-sm text-gray-500">Application ID</span>
                                <p class="font-medium text-gray-900">#<?= $application['id'] ?></p>
                            </div>
                        </div>

                        <?php if (!empty($application['admin_notes']) && $application['status'] === 'info_requested'): ?>
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                                <p class="text-sm font-medium text-blue-900 mb-1">
                                    <i class="fas fa-info-circle mr-2"></i>Action Required
                                </p>
                                <p class="text-sm text-blue-800"><?= htmlspecialchars($application['admin_notes']) ?></p>
                            </div>
                        <?php endif; ?>

                        <?php if ($application['status'] === 'approved'): ?>
                            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                <p class="text-sm font-medium text-green-900">
                                    <i class="fas fa-check-circle mr-2"></i>
                                    Congratulations! Your application has been approved. Check your email for next steps.
                                </p>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="ml-6 flex flex-col gap-2">
                        <a href="<?= url('/application/' . $application['uuid']) ?>" 
                           class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-blue-700 transition text-sm font-medium text-center">
                            <i class="fas fa-eye mr-2"></i>View Details
                        </a>
                        <?php if ($application['status'] === 'info_requested'): ?>
                            <a href="<?= url('/application/' . $application['uuid'] . '/update') ?>" 
                               class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm font-medium text-center">
                                <i class="fas fa-edit mr-2"></i>Update
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/dashboard.php';
?>
