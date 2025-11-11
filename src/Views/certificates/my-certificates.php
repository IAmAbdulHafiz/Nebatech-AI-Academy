<?php
$title = 'My Certificates';
ob_start();
// Dynamically load sidebar based on user role
$sidebarFile = match($user['role']) {
    'admin' => 'admin-sidebar.php',
    'facilitator' => 'facilitator-sidebar.php',
    default => 'student-sidebar.php'
};
include __DIR__ . '/../partials/' . $sidebarFile;
$sidebarContent = ob_get_clean();
ob_start();
?>

<!-- Page Header -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-2">My Certificates</h1>
    <p class="text-gray-600">View and download your earned certificates</p>
</div>

<!-- Certificates Grid -->
<?php if (empty($certificates)): ?>
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
        <i class="fas fa-certificate text-6xl text-gray-300 mb-4"></i>
        <h3 class="text-xl font-bold text-gray-900 mb-2">No Certificates Yet</h3>
        <p class="text-gray-600 mb-6">Complete courses to earn industry-recognized certificates</p>
        <a href="<?= url('/courses') ?>" class="inline-block px-6 py-3 bg-primary text-white rounded-lg hover:bg-blue-700 transition font-medium">
            <i class="fas fa-search mr-2"></i>Browse Courses
        </a>
    </div>
<?php else: ?>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($certificates as $certificate): ?>
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg transition">
                <!-- Certificate Preview -->
                <div class="h-48 bg-gradient-to-br from-primary via-blue-700 to-purple-700 p-6 flex flex-col justify-between text-white relative overflow-hidden">
                    <div class="absolute inset-0 opacity-10">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-white rounded-full -mr-16 -mt-16"></div>
                        <div class="absolute bottom-0 left-0 w-40 h-40 bg-white rounded-full -ml-20 -mb-20"></div>
                    </div>
                    <div class="relative z-10">
                        <i class="fas fa-award text-4xl mb-2 text-secondary"></i>
                        <h3 class="font-bold text-lg line-clamp-2"><?= htmlspecialchars($certificate['course_title']) ?></h3>
                    </div>
                    <div class="relative z-10">
                        <p class="text-sm opacity-90">Certificate of Completion</p>
                    </div>
                </div>

                <!-- Certificate Info -->
                <div class="p-4">
                    <div class="mb-4">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm text-gray-500">Issued On</span>
                            <span class="font-medium text-gray-900"><?= date('M d, Y', strtotime($certificate['issued_at'])) ?></span>
                        </div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm text-gray-500">Certificate ID</span>
                            <span class="font-mono text-xs text-gray-900"><?= htmlspecialchars($certificate['certificate_number']) ?></span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">Status</span>
                            <?php if ($certificate['verified']): ?>
                                <span class="inline-flex items-center px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">
                                    <i class="fas fa-check-circle mr-1"></i>Verified
                                </span>
                            <?php else: ?>
                                <span class="inline-flex items-center px-2 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-medium">
                                    <i class="fas fa-times-circle mr-1"></i>Revoked
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="space-y-2">
                        <a href="<?= url('/certificate/' . $certificate['uuid']) ?>" target="_blank"
                           class="block w-full text-center px-4 py-2 bg-primary text-white rounded-lg hover:bg-blue-700 transition font-medium">
                            <i class="fas fa-eye mr-2"></i>View Certificate
                        </a>
                        <a href="<?= url('/certificate/' . $certificate['uuid'] . '/download') ?>" 
                           class="block w-full text-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium">
                            <i class="fas fa-download mr-2"></i>Download PDF
                        </a>
                        <button onclick="shareCertificate('<?= $certificate['uuid'] ?>')" 
                                class="w-full px-4 py-2 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition font-medium">
                            <i class="fab fa-linkedin mr-2"></i>Share on LinkedIn
                        </button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<script>
function shareCertificate(uuid) {
    const url = '<?= url('/certificate/') ?>' + uuid;
    const linkedInUrl = `https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(url)}`;
    window.open(linkedInUrl, '_blank', 'width=600,height=600');
}
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/dashboard.php';
?>
