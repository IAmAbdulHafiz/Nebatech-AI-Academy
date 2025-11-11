<?php
$title = 'Manage Applications';
ob_start();
include __DIR__ . '/../partials/admin-sidebar.php';
$sidebarContent = ob_get_clean();
ob_start();
?>

<!-- Page Header -->
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900 mb-2">Applications</h1>
    <p class="text-gray-600">Review and manage student applications</p>
</div>

<!-- Stats Overview -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
        <div class="text-sm text-gray-600 mb-1">Total</div>
        <div class="text-2xl font-bold text-gray-900"><?= $stats['total'] ?></div>
    </div>
    <div class="bg-yellow-50 rounded-lg border border-yellow-200 p-4">
        <div class="text-sm text-yellow-700 mb-1">Pending</div>
        <div class="text-2xl font-bold text-yellow-900"><?= $stats['pending'] ?></div>
    </div>
    <div class="bg-green-50 rounded-lg border border-green-200 p-4">
        <div class="text-sm text-green-700 mb-1">Approved</div>
        <div class="text-2xl font-bold text-green-900"><?= $stats['approved'] ?></div>
    </div>
    <div class="bg-red-50 rounded-lg border border-red-200 p-4">
        <div class="text-sm text-red-700 mb-1">Rejected</div>
        <div class="text-2xl font-bold text-red-900"><?= $stats['rejected'] ?></div>
    </div>
</div>

<!-- Filters -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6">
    <form method="GET" class="flex flex-wrap gap-4">
        <!-- Status Filter -->
        <div class="flex-1 min-w-[200px]">
            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
            <select name="status" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary focus:border-transparent">
                <option value="">All Statuses</option>
                <option value="pending" <?= ($currentStatus ?? '') === 'pending' ? 'selected' : '' ?>>Pending</option>
                <option value="approved" <?= ($currentStatus ?? '') === 'approved' ? 'selected' : '' ?>>Approved</option>
                <option value="rejected" <?= ($currentStatus ?? '') === 'rejected' ? 'selected' : '' ?>>Rejected</option>
                <option value="info_requested" <?= ($currentStatus ?? '') === 'info_requested' ? 'selected' : '' ?>>Info Requested</option>
            </select>
        </div>

        <!-- Program Filter -->
        <div class="flex-1 min-w-[200px]">
            <label class="block text-sm font-medium text-gray-700 mb-2">Program</label>
            <select name="program" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary focus:border-transparent">
                <option value="">All Programs</option>
                <option value="frontend-development" <?= ($currentProgram ?? '') === 'frontend-development' ? 'selected' : '' ?>>Front-End Development</option>
                <option value="backend-development" <?= ($currentProgram ?? '') === 'backend-development' ? 'selected' : '' ?>>Back-End Development</option>
                <option value="fullstack-development" <?= ($currentProgram ?? '') === 'fullstack-development' ? 'selected' : '' ?>>Full-Stack Development</option>
                <option value="database-administration" <?= ($currentProgram ?? '') === 'database-administration' ? 'selected' : '' ?>>Database Administration</option>
                <option value="introduction-to-ai" <?= ($currentProgram ?? '') === 'introduction-to-ai' ? 'selected' : '' ?>>Introduction to AI</option>
                <option value="machine-learning-basics" <?= ($currentProgram ?? '') === 'machine-learning-basics' ? 'selected' : '' ?>>Machine Learning Basics</option>
            </select>
        </div>

        <!-- Actions -->
        <div class="flex items-end gap-2">
            <button type="submit" class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-blue-700 transition font-medium">
                <i class="fas fa-filter mr-2"></i>Filter
            </button>
            <a href="<?= url('/admin/applications') ?>" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-medium">
                Clear
            </a>
        </div>
    </form>
</div>

<!-- Applications Table -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Applicant</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Program</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Applied</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <?php if (empty($applications)): ?>
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <i class="fas fa-inbox text-4xl text-gray-300 mb-3"></i>
                            <p class="text-gray-500">No applications found</p>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($applications as $application): ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-primary text-white rounded-full flex items-center justify-center font-bold text-sm mr-3">
                                        <?= strtoupper(substr($application['first_name'], 0, 1) . substr($application['last_name'], 0, 1)) ?>
                                    </div>
                                    <div>
                                        <div class="font-semibold text-gray-900"><?= htmlspecialchars($application['first_name'] . ' ' . $application['last_name']) ?></div>
                                        <div class="text-sm text-gray-500"><?= htmlspecialchars($application['email']) ?></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-900"><?= htmlspecialchars(ucwords(str_replace('-', ' ', $application['program']))) ?></span>
                            </td>
                            <td class="px-6 py-4">
                                <?php
                                $statusConfig = [
                                    'pending' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-700', 'icon' => 'fa-clock'],
                                    'approved' => ['bg' => 'bg-green-100', 'text' => 'text-green-700', 'icon' => 'fa-check-circle'],
                                    'rejected' => ['bg' => 'bg-red-100', 'text' => 'text-red-700', 'icon' => 'fa-times-circle'],
                                    'info_requested' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-700', 'icon' => 'fa-info-circle']
                                ];
                                $config = $statusConfig[$application['status']] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-700', 'icon' => 'fa-circle'];
                                ?>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium <?= $config['bg'] ?> <?= $config['text'] ?>">
                                    <i class="fas <?= $config['icon'] ?> mr-1"></i>
                                    <?= ucfirst(str_replace('_', ' ', $application['status'])) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                <?= date('M d, Y', strtotime($application['created_at'])) ?>
                            </td>
                            <td class="px-6 py-4">
                                <a href="<?= url('/admin/applications/' . $application['id']) ?>" 
                                   class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-lg hover:bg-blue-700 transition text-sm font-medium">
                                    <i class="fas fa-eye mr-2"></i>Review
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/dashboard.php';
?>
