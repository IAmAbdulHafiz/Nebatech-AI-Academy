<?php
$title = 'Admin Dashboard';
ob_start();
include __DIR__ . '/../partials/admin-sidebar.php';
$sidebarContent = ob_get_clean();
ob_start();
?>

<!-- Page Header -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-2">Admin Dashboard</h1>
    <p class="text-gray-600">Manage applications, users, and system settings</p>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Applications -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-file-alt text-blue-600 text-xl"></i>
            </div>
            <span class="text-sm font-medium text-gray-500">Total</span>
        </div>
        <h3 class="text-3xl font-bold text-gray-900 mb-1"><?= number_format($stats['applications']['total']) ?></h3>
        <p class="text-sm text-gray-600">Applications</p>
    </div>

    <!-- Pending Applications -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-clock text-yellow-600 text-xl"></i>
            </div>
            <span class="text-sm font-medium text-gray-500">Pending</span>
        </div>
        <h3 class="text-3xl font-bold text-gray-900 mb-1"><?= number_format($stats['applications']['pending']) ?></h3>
        <p class="text-sm text-gray-600">Need Review</p>
        <?php if ($stats['applications']['pending'] > 0): ?>
            <a href="<?= url('/admin/applications?status=pending') ?>" class="text-sm text-yellow-600 hover:text-yellow-700 font-medium mt-2 inline-block">
                Review Now →
            </a>
        <?php endif; ?>
    </div>

    <!-- Total Users -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-users text-green-600 text-xl"></i>
            </div>
            <span class="text-sm font-medium text-gray-500">Active</span>
        </div>
        <h3 class="text-3xl font-bold text-gray-900 mb-1"><?= number_format($stats['total_users']) ?></h3>
        <p class="text-sm text-gray-600">Total Users</p>
        <div class="flex items-center gap-4 mt-2 text-xs text-gray-500">
            <span><?= $stats['total_students'] ?> Students</span>
            <span><?= $stats['total_facilitators'] ?> Facilitators</span>
        </div>
    </div>

    <!-- Published Courses -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-book text-purple-600 text-xl"></i>
            </div>
            <span class="text-sm font-medium text-gray-500">Live</span>
        </div>
        <h3 class="text-3xl font-bold text-gray-900 mb-1"><?= number_format($stats['published_courses']) ?></h3>
        <p class="text-sm text-gray-600">Published Courses</p>
        <p class="text-xs text-gray-500 mt-2"><?= $stats['total_courses'] ?> total courses</p>
    </div>
</div>

<!-- Main Content Grid -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Recent Applications -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <h2 class="text-lg font-bold text-gray-900">Recent Applications</h2>
                <a href="<?= url('/admin/applications') ?>" class="text-sm text-primary hover:text-blue-700 font-medium">
                    View All →
                </a>
            </div>
            <div class="divide-y divide-gray-200">
                <?php if (empty($recentApplications)): ?>
                    <div class="px-6 py-12 text-center">
                        <i class="fas fa-inbox text-4xl text-gray-300 mb-3"></i>
                        <p class="text-gray-500">No applications yet</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($recentApplications as $application): ?>
                        <div class="px-6 py-4 hover:bg-gray-50 transition">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-2">
                                        <h3 class="font-semibold text-gray-900">
                                            <?= htmlspecialchars($application['first_name'] . ' ' . $application['last_name']) ?>
                                        </h3>
                                        <?php
                                        $statusColors = [
                                            'pending' => 'bg-yellow-100 text-yellow-700',
                                            'approved' => 'bg-green-100 text-green-700',
                                            'rejected' => 'bg-red-100 text-red-700',
                                            'info_requested' => 'bg-blue-100 text-blue-700'
                                        ];
                                        $statusColor = $statusColors[$application['status']] ?? 'bg-gray-100 text-gray-700';
                                        ?>
                                        <span class="<?= $statusColor ?> px-2 py-1 rounded-full text-xs font-medium">
                                            <?= ucfirst(str_replace('_', ' ', $application['status'])) ?>
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-600 mb-1">
                                        <i class="fas fa-graduation-cap mr-1 text-gray-400"></i>
                                        <?= htmlspecialchars($application['program']) ?>
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        <i class="fas fa-clock mr-1"></i>
                                        Applied <?= date('M d, Y', strtotime($application['created_at'])) ?>
                                    </p>
                                </div>
                                <a href="<?= url('/admin/applications/' . $application['id']) ?>" 
                                   class="ml-4 px-4 py-2 bg-primary text-white rounded-lg hover:bg-blue-700 transition text-sm font-medium">
                                    Review
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Quick Actions & Stats -->
    <div class="space-y-6">
        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="font-bold text-gray-900 mb-4">Quick Actions</h3>
            <div class="space-y-2">
                <a href="<?= url('/admin/applications?status=pending') ?>" 
                   class="block w-full text-left px-4 py-3 bg-yellow-50 text-yellow-700 rounded-lg hover:bg-yellow-100 transition">
                    <i class="fas fa-clock mr-2"></i>
                    Review Applications
                    <?php if ($stats['applications']['pending'] > 0): ?>
                        <span class="float-right bg-yellow-200 text-yellow-800 px-2 py-1 rounded-full text-xs font-bold">
                            <?= $stats['applications']['pending'] ?>
                        </span>
                    <?php endif; ?>
                </a>
                <a href="<?= url('/admin/cohorts') ?>" 
                   class="block w-full text-left px-4 py-3 bg-purple-50 text-purple-700 rounded-lg hover:bg-purple-100 transition">
                    <i class="fas fa-user-friends mr-2"></i>Manage Cohorts
                </a>
                <a href="<?= url('/admin/enrollments') ?>" 
                   class="block w-full text-left px-4 py-3 bg-green-50 text-green-700 rounded-lg hover:bg-green-100 transition">
                    <i class="fas fa-graduation-cap mr-2"></i>Manage Enrollments
                </a>
                <a href="<?= url('/admin/users') ?>" 
                   class="block w-full text-left px-4 py-3 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition">
                    <i class="fas fa-users mr-2"></i>Manage Users
                </a>
            </div>
        </div>

        <!-- Application Stats Chart -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="font-bold text-gray-900 mb-4">Application Status</h3>
            <div class="space-y-3">
                <div>
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-sm text-gray-600">Pending</span>
                        <span class="text-sm font-semibold text-gray-900"><?= $stats['applications']['pending'] ?></span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-yellow-500 h-2 rounded-full" style="width: <?= $stats['applications']['total'] > 0 ? ($stats['applications']['pending'] / $stats['applications']['total'] * 100) : 0 ?>%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-sm text-gray-600">Approved</span>
                        <span class="text-sm font-semibold text-gray-900"><?= $stats['applications']['approved'] ?></span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-green-500 h-2 rounded-full" style="width: <?= $stats['applications']['total'] > 0 ? ($stats['applications']['approved'] / $stats['applications']['total'] * 100) : 0 ?>%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-sm text-gray-600">Rejected</span>
                        <span class="text-sm font-semibold text-gray-900"><?= $stats['applications']['rejected'] ?></span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-red-500 h-2 rounded-full" style="width: <?= $stats['applications']['total'] > 0 ? ($stats['applications']['rejected'] / $stats['applications']['total'] * 100) : 0 ?>%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-sm text-gray-600">Info Requested</span>
                        <span class="text-sm font-semibold text-gray-900"><?= $stats['applications']['info_requested'] ?></span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-500 h-2 rounded-full" style="width: <?= $stats['applications']['total'] > 0 ? ($stats['applications']['info_requested'] / $stats['applications']['total'] * 100) : 0 ?>%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- System Health -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="font-bold text-gray-900 mb-4">System Health</h3>
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Database</span>
                    <span class="flex items-center text-sm text-green-600">
                        <i class="fas fa-check-circle mr-1"></i>Online
                    </span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">AI Service</span>
                    <span class="flex items-center text-sm text-green-600">
                        <i class="fas fa-check-circle mr-1"></i>Active
                    </span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Code Execution</span>
                    <span class="flex items-center text-sm text-green-600">
                        <i class="fas fa-check-circle mr-1"></i>Ready
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/dashboard.php';
?>
