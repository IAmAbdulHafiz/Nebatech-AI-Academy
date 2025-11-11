<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verification Result - Nebatech AI Academy</title>
    <link href="<?= asset('css/main.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100">
    <!-- Simple Header -->
    <nav class="bg-white shadow-sm border-b border-gray-200">
        <div class="container mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <a href="<?= url('/') ?>" class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center">
                        <span class="text-white font-bold text-xl">N</span>
                    </div>
                    <span class="text-xl font-bold text-gray-900">Nebatech AI Academy</span>
                </a>
                <a href="<?= url('/') ?>" class="text-gray-600 hover:text-blue-600 transition">
                    <i class="fas fa-home mr-2"></i>Home
                </a>
            </div>
        </div>
    </nav>
    
    <div class="container mx-auto px-4 py-16">
        <div class="max-w-2xl mx-auto">
            <?php if ($certificate): ?>
                <!-- Valid Certificate -->
                <div class="bg-green-50 border-2 border-green-500 rounded-lg p-8 mb-6">
                    <div class="text-center mb-6">
                        <i class="fas fa-check-circle text-green-500 text-6xl mb-4"></i>
                        <h1 class="text-3xl font-bold text-green-900 mb-2">Certificate Verified!</h1>
                        <p class="text-green-700">This is a valid certificate issued by Nebatech AI Academy</p>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Certificate Details</h2>
                    
                    <div class="space-y-4">
                        <div class="grid grid-cols-3 gap-4 pb-4 border-b border-gray-200">
                            <span class="text-gray-600">Recipient</span>
                            <span class="col-span-2 font-semibold text-gray-900"><?= htmlspecialchars($certificate['first_name'] . ' ' . $certificate['last_name']) ?></span>
                        </div>
                        <div class="grid grid-cols-3 gap-4 pb-4 border-b border-gray-200">
                            <span class="text-gray-600">Course</span>
                            <span class="col-span-2 font-semibold text-gray-900"><?= htmlspecialchars($certificate['course_title']) ?></span>
                        </div>
                        <div class="grid grid-cols-3 gap-4 pb-4 border-b border-gray-200">
                            <span class="text-gray-600">Level</span>
                            <span class="col-span-2 font-semibold text-gray-900"><?= ucfirst($certificate['level']) ?></span>
                        </div>
                        <div class="grid grid-cols-3 gap-4 pb-4 border-b border-gray-200">
                            <span class="text-gray-600">Duration</span>
                            <span class="col-span-2 font-semibold text-gray-900"><?= $certificate['duration_hours'] ?> hours</span>
                        </div>
                        <div class="grid grid-cols-3 gap-4 pb-4 border-b border-gray-200">
                            <span class="text-gray-600">Issue Date</span>
                            <span class="col-span-2 font-semibold text-gray-900"><?= date('F d, Y', strtotime($certificate['issued_at'])) ?></span>
                        </div>
                        <div class="grid grid-cols-3 gap-4">
                            <span class="text-gray-600">Certificate ID</span>
                            <span class="col-span-2 font-mono text-sm font-semibold text-gray-900"><?= htmlspecialchars($certificate['certificate_number']) ?></span>
                        </div>
                    </div>

                    <div class="mt-8 flex gap-4">
                        <a href="<?= url('/certificate/' . $certificate['uuid']) ?>" target="_blank"
                           class="flex-1 text-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                            <i class="fas fa-eye mr-2"></i>View Certificate
                        </a>
                        <a href="<?= url('/verify-certificate') ?>" 
                           class="flex-1 text-center px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-medium">
                            Verify Another
                        </a>
                    </div>
                </div>
            <?php else: ?>
                <!-- Invalid Certificate -->
                <div class="bg-red-50 border-2 border-red-500 rounded-lg p-8 mb-6">
                    <div class="text-center mb-6">
                        <i class="fas fa-times-circle text-red-500 text-6xl mb-4"></i>
                        <h1 class="text-3xl font-bold text-red-900 mb-2">Certificate Not Found</h1>
                        <p class="text-red-700">The certificate ID you entered could not be verified</p>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-lg p-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Possible Reasons</h2>
                    <ul class="space-y-2 text-gray-600 mb-6">
                        <li><i class="fas fa-circle text-xs mr-2"></i>The certificate number was entered incorrectly</li>
                        <li><i class="fas fa-circle text-xs mr-2"></i>The certificate has been revoked</li>
                        <li><i class="fas fa-circle text-xs mr-2"></i>The certificate does not exist in our system</li>
                    </ul>

                    <div class="flex gap-4">
                        <a href="<?= url('/verify-certificate') ?>" 
                           class="flex-1 text-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                            <i class="fas fa-redo mr-2"></i>Try Again
                        </a>
                        <a href="<?= url('/contact') ?>" 
                           class="flex-1 text-center px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-medium">
                            <i class="fas fa-envelope mr-2"></i>Contact Support
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Simple Footer -->
    <footer class="bg-white border-t border-gray-200 mt-16">
        <div class="container mx-auto px-4 py-8">
            <div class="text-center text-gray-600">
                <p>&copy; <?= date('Y') ?> Nebatech AI Academy. All rights reserved.</p>
                <p class="mt-2 text-sm">
                    <a href="<?= url('/') ?>" class="text-blue-600 hover:underline">Home</a> • 
                    <a href="<?= url('/contact') ?>" class="text-blue-600 hover:underline">Contact</a>
                </p>
            </div>
        </div>
    </footer>
</body>
</html>
