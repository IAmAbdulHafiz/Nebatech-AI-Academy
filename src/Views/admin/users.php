<?php
$title = 'Manage Users';

// Ensure we're loading the correct sidebar for admin context
// Even if admin can access facilitator routes, this is an admin-only page
ob_start();
include __DIR__ . '/../partials/admin-sidebar.php';
$sidebarContent = ob_get_clean();
ob_start();
?>

<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900 mb-2">Manage Users</h1>
    <p class="text-gray-600">View and manage all platform users</p>
</div>

<!-- Filters -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6">
    <form method="GET" class="flex flex-wrap gap-4">
        <div class="flex-1 min-w-[200px]">
            <select name="role" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                <option value="">All Roles</option>
                <option value="student" <?= ($currentRole ?? '') === 'student' ? 'selected' : '' ?>>Students</option>
                <option value="facilitator" <?= ($currentRole ?? '') === 'facilitator' ? 'selected' : '' ?>>Facilitators</option>
                <option value="admin" <?= ($currentRole ?? '') === 'admin' ? 'selected' : '' ?>>Admins</option>
            </select>
        </div>
        <div class="flex-1 min-w-[200px]">
            <select name="status" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                <option value="">All Statuses</option>
                <option value="active" <?= ($currentStatus ?? '') === 'active' ? 'selected' : '' ?>>Active</option>
                <option value="inactive" <?= ($currentStatus ?? '') === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                <option value="suspended" <?= ($currentStatus ?? '') === 'suspended' ? 'selected' : '' ?>>Suspended</option>
            </select>
        </div>
        <div class="flex-1 min-w-[200px]">
            <input type="text" name="search" value="<?= htmlspecialchars($currentSearch ?? '') ?>" 
                   placeholder="Search users..." class="w-full border border-gray-300 rounded-lg px-4 py-2">
        </div>
        <button type="submit" class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-blue-700 transition font-medium">
            <i class="fas fa-filter mr-2"></i>Filter
        </button>
        <a href="<?= url('/admin/users') ?>" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-medium">Clear</a>
    </form>
</div>

<!-- Users Table -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Role</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Joined</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <?php if (empty($users)): ?>
                    <tr><td colspan="5" class="px-6 py-12 text-center text-gray-500">No users found</td></tr>
                <?php else: ?>
                    <?php foreach ($users as $userRow): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-primary text-white rounded-full flex items-center justify-center font-bold mr-3">
                                        <?= strtoupper(substr($userRow['first_name'], 0, 1) . substr($userRow['last_name'], 0, 1)) ?>
                                    </div>
                                    <div>
                                        <div class="font-semibold text-gray-900"><?= htmlspecialchars($userRow['first_name'] . ' ' . $userRow['last_name']) ?></div>
                                        <div class="text-sm text-gray-500"><?= htmlspecialchars($userRow['email']) ?></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4"><span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-medium"><?= ucfirst($userRow['role']) ?></span></td>
                            <td class="px-6 py-4">
                                <?php
                                $statusColors = ['active' => 'bg-green-100 text-green-700', 'inactive' => 'bg-gray-100 text-gray-700', 'suspended' => 'bg-red-100 text-red-700'];
                                ?>
                                <span class="px-3 py-1 <?= $statusColors[$userRow['status']] ?> rounded-full text-xs font-medium"><?= ucfirst($userRow['status']) ?></span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500"><?= date('M d, Y', strtotime($userRow['created_at'])) ?></td>
                            <td class="px-6 py-4">
                                <select onchange="updateUserStatus(<?= $userRow['id'] ?>, this.value)" class="border border-gray-300 rounded px-3 py-1 text-sm">
                                    <option value="">Actions...</option>
                                    <option value="active">Set Active</option>
                                    <option value="inactive">Set Inactive</option>
                                    <option value="suspended">Suspend</option>
                                </select>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
async function updateUserStatus(userId, status) {
    if (!status) return;
    
    const confirmed = await confirmAction('Update user status to ' + status + '?', {
        title: 'Update User Status',
        confirmText: 'Update',
        type: 'info'
    });
    
    if (!confirmed) return;
    
    try {
        const response = await fetch('<?= url('/admin/users/update-status') ?>', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `user_id=${userId}&status=${status}&_token=<?= csrf_token() ?>`
        });
        const data = await response.json();
        
        if (data.success) {
            showSuccess('User status updated');
            setTimeout(() => window.location.reload(), 1000);
        } else {
            showError('Error: ' + (data.error || 'Failed to update status'));
        }
    } catch (error) {
        showError('Error: ' + error.message);
    }
}
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/dashboard.php';
?>
