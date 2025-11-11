<?php
$title = 'Certificate Details';
ob_start();
include __DIR__ . '/../partials/admin-sidebar.php';
$sidebarContent = ob_get_clean();
ob_start();
?>

<!-- Page Header -->
<div class="mb-6">
    <a href="<?= url('/admin/certificates') ?>" class="text-primary hover:text-blue-700 text-sm mb-2 inline-block">
        <i class="fas fa-arrow-left mr-2"></i>Back to Certificates
    </a>
    <h1 class="text-3xl font-bold text-gray-900 mb-2">Certificate Details</h1>
    <p class="text-gray-600">View certificate information and verification status</p>
</div>

<!-- Certificate Info -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Info -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Certificate Preview -->
        <div class="bg-gradient-to-br from-blue-600 to-blue-800 rounded-lg shadow-lg p-8 text-white">
            <div class="text-center">
                <div class="mb-4">
                    <i class="fas fa-certificate text-6xl opacity-80"></i>
                </div>
                <h2 class="text-3xl font-bold mb-2">Certificate of Completion</h2>
                <p class="text-blue-100 mb-6">This certifies that</p>
                <h3 class="text-4xl font-bold mb-6">
                    <?= htmlspecialchars($certificate['first_name'] . ' ' . $certificate['last_name']) ?>
                </h3>
                <p class="text-blue-100 mb-2">has successfully completed</p>
                <h4 class="text-2xl font-semibold mb-8">
                    <?= htmlspecialchars($certificate['course_title']) ?>
                </h4>
                <div class="flex justify-between items-end text-sm">
                    <div class="text-left">
                        <p class="text-blue-100">Certificate Number</p>
                        <p class="font-mono font-bold"><?= htmlspecialchars($certificate['certificate_number']) ?></p>
                    </div>
                    <div class="text-right">
                        <p class="text-blue-100">Issued On</p>
                        <p class="font-bold"><?= date('F d, Y', strtotime($certificate['issued_at'])) ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detailed Information -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-xl font-bold text-gray-900 mb-4">Certificate Information</h3>
            
            <div class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-medium text-gray-700">Certificate Number</label>
                        <p class="text-gray-900 mt-1 font-mono"><?= htmlspecialchars($certificate['certificate_number']) ?></p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">UUID</label>
                        <p class="text-gray-900 mt-1 font-mono text-xs"><?= htmlspecialchars($certificate['uuid']) ?></p>
                    </div>
                </div>

                <div class="border-t border-gray-200 pt-4">
                    <label class="text-sm font-medium text-gray-700">Recipient</label>
                    <p class="text-gray-900 mt-1"><?= htmlspecialchars($certificate['first_name'] . ' ' . $certificate['last_name']) ?></p>
                    <p class="text-gray-600 text-sm"><?= htmlspecialchars($certificate['email']) ?></p>
                </div>

                <div class="border-t border-gray-200 pt-4">
                    <label class="text-sm font-medium text-gray-700">Course</label>
                    <p class="text-gray-900 mt-1"><?= htmlspecialchars($certificate['course_title']) ?></p>
                    <div class="flex gap-4 mt-2">
                        <span class="text-sm text-gray-600">
                            <i class="fas fa-tag mr-1"></i><?= htmlspecialchars(ucwords($certificate['category'])) ?>
                        </span>
                        <span class="text-sm text-gray-600">
                            <i class="fas fa-signal mr-1"></i><?= ucfirst($certificate['level']) ?>
                        </span>
                        <span class="text-sm text-gray-600">
                            <i class="fas fa-clock mr-1"></i><?= $certificate['duration_hours'] ?> hours
                        </span>
                    </div>
                </div>

                <div class="border-t border-gray-200 pt-4">
                    <label class="text-sm font-medium text-gray-700">Issued Date</label>
                    <p class="text-gray-900 mt-1"><?= date('F d, Y \a\t g:i A', strtotime($certificate['issued_at'])) ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Status Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Status</h3>
            
            <div class="space-y-4">
                <div>
                    <label class="text-sm font-medium text-gray-700">Verification Status</label>
                    <div class="mt-2">
                        <?php if ($certificate['verified']): ?>
                            <span class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-medium bg-green-100 text-green-700">
                                <i class="fas fa-check-circle mr-2"></i>Verified
                            </span>
                        <?php else: ?>
                            <span class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-medium bg-red-100 text-red-700">
                                <i class="fas fa-times-circle mr-2"></i>Revoked
                            </span>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if ($certificate['verified']): ?>
                    <div class="pt-4 border-t border-gray-200">
                        <p class="text-sm text-gray-600 mb-3">This certificate is currently valid and can be verified publicly.</p>
                        <button onclick="revokeCertificate(<?= $certificate['id'] ?>, '<?= htmlspecialchars($certificate['certificate_number']) ?>')" 
                                class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-medium">
                            <i class="fas fa-ban mr-2"></i>Revoke Certificate
                        </button>
                    </div>
                <?php else: ?>
                    <div class="pt-4 border-t border-gray-200">
                        <p class="text-sm text-gray-600">This certificate has been revoked and is no longer valid.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Actions Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Actions</h3>
            
            <div class="space-y-2">
                <a href="<?= url('/certificate/' . $certificate['uuid']) ?>" target="_blank"
                   class="w-full inline-flex items-center justify-center px-4 py-2 bg-primary text-white rounded-lg hover:bg-blue-700 transition font-medium">
                    <i class="fas fa-external-link-alt mr-2"></i>View Public Certificate
                </a>
                <a href="<?= url('/verify-certificate?id=' . $certificate['certificate_number']) ?>" target="_blank"
                   class="w-full inline-flex items-center justify-center px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-medium">
                    <i class="fas fa-shield-alt mr-2"></i>Verify Certificate
                </a>
            </div>
        </div>

        <!-- Verification Info -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex">
                <i class="fas fa-info-circle text-blue-600 mt-1 mr-3"></i>
                <div class="text-sm text-blue-800">
                    <p class="font-medium mb-1">Public Verification</p>
                    <p>Anyone can verify this certificate using the certificate number or UUID on the public verification page.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
async function revokeCertificate(certificateId, certificateNumber) {
    const confirmed = await confirmAction(`Revoke certificate ${certificateNumber}? This action will invalidate the certificate and cannot be easily undone.`, {
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
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/dashboard.php';
?>
