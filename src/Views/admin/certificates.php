<?php
$title = 'Certificate Management';
ob_start();
include __DIR__ . '/../partials/admin-sidebar.php';
$sidebarContent = ob_get_clean();
ob_start();
?>

<!-- Page Header -->
<div class="mb-6">
    <div class="flex items-center justify-between mb-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Certificate Management</h1>
            <p class="text-gray-600">Manage and oversee all issued certificates</p>
        </div>
        <a href="<?= url('/admin/certificates/issue') ?>" class="px-6 py-3 bg-primary text-white rounded-lg hover:bg-blue-700 transition font-medium">
            <i class="fas fa-plus mr-2"></i>Issue Certificate
        </a>
    </div>
</div>

<!-- Stats Overview -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
        <div class="text-sm text-gray-600 mb-1">Total Certificates</div>
        <div class="text-2xl font-bold text-gray-900"><?= $stats['total_certificates'] ?? 0 ?></div>
    </div>
    <div class="bg-green-50 rounded-lg border border-green-200 p-4">
        <div class="text-sm text-green-700 mb-1">Verified</div>
        <div class="text-2xl font-bold text-green-900"><?= $stats['verified'] ?? 0 ?></div>
    </div>
    <div class="bg-red-50 rounded-lg border border-red-200 p-4">
        <div class="text-sm text-red-700 mb-1">Revoked</div>
        <div class="text-2xl font-bold text-red-900"><?= $stats['revoked'] ?? 0 ?></div>
    </div>
</div>

<!-- Filters -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6">
    <form method="GET" class="flex flex-wrap gap-4">
        <!-- Status Filter -->
        <div class="flex-1 min-w-[200px]">
            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
            <select name="status" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary focus:border-transparent">
                <option value="">All Certificates</option>
                <option value="verified" <?= ($currentStatus ?? '') === 'verified' ? 'selected' : '' ?>>Verified</option>
                <option value="revoked" <?= ($currentStatus ?? '') === 'revoked' ? 'selected' : '' ?>>Revoked</option>
            </select>
        </div>

        <!-- Search -->
        <div class="flex-1 min-w-[200px]">
            <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
            <input type="text" name="search" value="<?= htmlspecialchars($currentSearch ?? '') ?>" 
                   placeholder="Search by name, email, or certificate number..." class="w-full border border-gray-300 rounded-lg px-4 py-2">
        </div>

        <!-- Actions -->
        <div class="flex items-end gap-2">
            <button type="submit" class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-blue-700 transition font-medium">
                <i class="fas fa-filter mr-2"></i>Filter
            </button>
            <a href="<?= url('/admin/certificates') ?>" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-medium">
                Clear
            </a>
        </div>
    </form>
</div>

<!-- Certificates Table -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Certificate #</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Recipient</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Issued</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <?php if (empty($certificates)): ?>
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <i class="fas fa-certificate text-4xl text-gray-300 mb-3"></i>
                            <p class="text-gray-500">No certificates found</p>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($certificates as $certificate): ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div class="font-mono text-sm text-gray-900"><?= htmlspecialchars($certificate['certificate_number']) ?></div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-primary text-white rounded-full flex items-center justify-center font-bold text-sm mr-3">
                                        <?= strtoupper(substr($certificate['first_name'], 0, 1) . substr($certificate['last_name'], 0, 1)) ?>
                                    </div>
                                    <div>
                                        <div class="font-semibold text-gray-900"><?= htmlspecialchars($certificate['first_name'] . ' ' . $certificate['last_name']) ?></div>
                                        <div class="text-sm text-gray-500"><?= htmlspecialchars($certificate['email']) ?></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900"><?= htmlspecialchars($certificate['course_title']) ?></div>
                                <div class="text-xs text-gray-500"><?= htmlspecialchars($certificate['category_name'] ?? 'Uncategorized') ?></div>
                            </td>
                            <td class="px-6 py-4">
                                <?php if ($certificate['verified']): ?>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                        <i class="fas fa-check-circle mr-1"></i>Verified
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">
                                        <i class="fas fa-times-circle mr-1"></i>Revoked
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                <?= date('M d, Y', strtotime($certificate['issued_at'])) ?>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex gap-2">
                                    <a href="<?= url('/admin/certificates/' . $certificate['id']) ?>" 
                                       class="inline-flex items-center px-3 py-1 bg-primary text-white rounded-lg hover:bg-blue-700 transition text-sm font-medium">
                                        <i class="fas fa-eye mr-1"></i>View
                                    </a>
                                    <?php if ($certificate['verified']): ?>
                                        <button onclick="revokeCertificate(<?= $certificate['id'] ?>, '<?= htmlspecialchars($certificate['certificate_number']) ?>')" 
                                                class="inline-flex items-center px-3 py-1 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-sm font-medium">
                                            <i class="fas fa-ban mr-1"></i>Revoke
                                        </button>
                                    <?php else: ?>
                                        <button onclick="restoreCertificate(<?= $certificate['id'] ?>, '<?= htmlspecialchars($certificate['certificate_number']) ?>')" 
                                                class="inline-flex items-center px-3 py-1 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm font-medium">
                                            <i class="fas fa-undo mr-1"></i>Restore
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
async function revokeCertificate(certificateId, certificateNumber) {
    const confirmed = await confirmAction(`Revoke certificate ${certificateNumber}? This will invalidate the certificate.`, {
        title: 'Revoke Certificate',
        confirmText: 'Revoke',
        type: 'danger'
    });
    
    if (!confirmed) return;

    fetch(`<?= url('/admin/certificates/') ?>${certificateId}/revoke`, {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `_token=<?= csrf_token() ?>`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showSuccess('Certificate revoked successfully');
            setTimeout(() => window.location.reload(), 1000);
        } else {
            showError('Error: ' + (data.error || 'Failed to revoke certificate'));
        }
    })
    .catch(error => {
        showError('An error occurred: ' + error.message);
    });
}

async function restoreCertificate(certificateId, certificateNumber) {
    const confirmed = await confirmAction(`Restore certificate ${certificateNumber}? This will make the certificate valid again.`, {
        title: 'Restore Certificate',
        confirmText: 'Restore',
        type: 'success'
    });
    
    if (!confirmed) return;

    fetch(`<?= url('/admin/certificates/') ?>${certificateId}/restore`, {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `_token=<?= csrf_token() ?>`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showSuccess('Certificate restored successfully');
            setTimeout(() => window.location.reload(), 1000);
        } else {
            showError('Error: ' + (data.error || 'Failed to restore certificate'));
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
