<?php
$title = $title ?? 'My Certificates';
?>

<!-- Page Header -->
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900 mb-2">My Certificates</h1>
    <p class="text-gray-600">View and manage your earned certificates</p>
</div>

<!-- Stats -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
        <div class="text-sm text-gray-600 mb-1">Total Certificates</div>
        <div class="text-2xl font-bold text-primary"><?= count($certificates ?? []) ?></div>
    </div>
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
        <div class="text-sm text-gray-600 mb-1">Courses Completed</div>
        <div class="text-2xl font-bold text-green-600"><?= count(array_filter($certificates ?? [], fn($c) => $c['type'] === 'course')) ?></div>
    </div>
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
        <div class="text-sm text-gray-600 mb-1">Achievements</div>
        <div class="text-2xl font-bold text-secondary"><?= count(array_filter($certificates ?? [], fn($c) => $c['type'] === 'achievement')) ?></div>
    </div>
</div>

<!-- Certificates Grid -->
<?php if (empty($certificates)): ?>
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
        <i class="fas fa-certificate text-6xl text-gray-300 mb-4"></i>
        <h3 class="text-xl font-bold text-gray-900 mb-2">No Certificates Yet</h3>
        <p class="text-gray-600 mb-6">Complete courses and assignments to earn certificates</p>
        <a href="<?= url('/my-courses') ?>" class="inline-block px-6 py-3 bg-primary text-white rounded-lg hover:bg-blue-700 transition font-medium">
            <i class="fas fa-book mr-2"></i>Browse My Courses
        </a>
    </div>
<?php else: ?>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($certificates as $certificate): ?>
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg transition">
                <!-- Certificate Preview -->
                <div class="aspect-video bg-gradient-to-br from-blue-600 to-blue-800 p-6 flex items-center justify-center relative">
                    <div class="text-center text-white">
                        <i class="fas fa-certificate text-5xl mb-3 opacity-90"></i>
                        <h3 class="font-bold text-lg"><?= htmlspecialchars($certificate['title'] ?? 'Certificate') ?></h3>
                    </div>
                    <!-- Decorative Elements -->
                    <div class="absolute top-0 left-0 w-full h-full opacity-10">
                        <div class="absolute top-4 left-4 w-16 h-16 border-4 border-white rounded-full"></div>
                        <div class="absolute bottom-4 right-4 w-20 h-20 border-4 border-white rounded-full"></div>
                    </div>
                </div>

                <!-- Certificate Info -->
                <div class="p-4">
                    <div class="mb-3">
                        <h4 class="font-semibold text-gray-900 mb-1"><?= htmlspecialchars($certificate['course_title'] ?? $certificate['title']) ?></h4>
                        <p class="text-sm text-gray-600">
                            <i class="fas fa-calendar mr-1"></i>
                            Issued: <?= date('F j, Y', strtotime($certificate['issued_at'] ?? $certificate['created_at'])) ?>
                        </p>
                    </div>

                    <?php if (!empty($certificate['verification_code'])): ?>
                    <div class="mb-3 p-2 bg-gray-50 rounded text-xs">
                        <span class="text-gray-600">Verification Code:</span>
                        <code class="text-primary font-mono"><?= htmlspecialchars($certificate['verification_code']) ?></code>
                    </div>
                    <?php endif; ?>

                    <!-- Actions -->
                    <div class="flex gap-2">
                        <?php if (!empty($certificate['file_path'])): ?>
                        <a href="<?= url('/certificates/' . $certificate['id'] . '/download') ?>" 
                           class="flex-1 text-center px-4 py-2 bg-primary text-white rounded hover:bg-blue-700 transition text-sm">
                            <i class="fas fa-download mr-1"></i>Download
                        </a>
                        <?php endif; ?>
                        <?php if (!empty($certificate['verification_code'])): ?>
                        <a href="<?= url('/certificates/verify/' . $certificate['verification_code']) ?>" 
                           target="_blank"
                           class="flex-1 text-center px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition text-sm">
                            <i class="fas fa-check-circle mr-1"></i>Verify
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
include __DIR__ . '/../layouts/student.php';
?>
