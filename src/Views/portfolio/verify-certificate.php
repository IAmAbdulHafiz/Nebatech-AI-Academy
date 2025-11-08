<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Certificate - Nebatech AI Academy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center px-4 py-12">
        <div class="max-w-2xl w-full">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-gray-900 mb-2">
                    <i class="fas fa-certificate text-purple-600"></i>
                    Certificate Verification
                </h1>
                <p class="text-gray-600">Verify the authenticity of a Nebatech AI Academy certificate</p>
            </div>
            
            <?php if ($certificate): ?>
                <!-- Valid Certificate -->
                <div class="bg-white rounded-xl shadow-lg p-8 border-2 border-green-500">
                    <div class="text-center mb-6">
                        <div class="inline-flex items-center justify-center w-20 h-20 bg-green-100 rounded-full mb-4">
                            <i class="fas fa-check-circle text-green-600 text-4xl"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-green-600 mb-2">Certificate Verified ✓</h2>
                        <p class="text-gray-600">This is an authentic certificate issued by Nebatech AI Academy</p>
                    </div>
                    
                    <div class="space-y-6">
                        <!-- Student Info -->
                        <div class="bg-gradient-to-r from-purple-600 to-purple-800 text-white rounded-lg p-6">
                            <h3 class="text-lg font-semibold mb-4">Certificate Holder</h3>
                            <p class="text-2xl font-bold mb-2">
                                <?= htmlspecialchars($certificate['first_name'] . ' ' . $certificate['last_name']) ?>
                            </p>
                            <p class="text-purple-100">
                                <i class="fas fa-envelope mr-2"></i>
                                <?= htmlspecialchars($certificate['email']) ?>
                            </p>
                        </div>
                        
                        <!-- Course Info -->
                        <div class="border-2 border-gray-200 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Course Completed</h3>
                            <p class="text-xl font-bold text-gray-900 mb-2">
                                <?= htmlspecialchars($certificate['course_title']) ?>
                            </p>
                            <?php if ($certificate['course_description']): ?>
                                <p class="text-gray-600 text-sm">
                                    <?= htmlspecialchars($certificate['course_description']) ?>
                                </p>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Certificate Details -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-sm text-gray-600 mb-1">Certificate Number</p>
                                <p class="font-mono font-semibold text-gray-900">
                                    <?= htmlspecialchars($certificate['certificate_number']) ?>
                                </p>
                            </div>
                            
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-sm text-gray-600 mb-1">Issue Date</p>
                                <p class="font-semibold text-gray-900">
                                    <?= date('F j, Y', strtotime($certificate['issue_date'])) ?>
                                </p>
                            </div>
                            
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-sm text-gray-600 mb-1">Verification Code</p>
                                <p class="font-mono text-sm font-semibold text-gray-900">
                                    <?= htmlspecialchars($certificate['verification_code']) ?>
                                </p>
                            </div>
                            
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-sm text-gray-600 mb-1">Status</p>
                                <p class="font-semibold text-green-600">
                                    <i class="fas fa-check-circle mr-1"></i>Valid & Authentic
                                </p>
                            </div>
                        </div>
                        
                        <?php if (isset($certificate['metadata']) && !empty($certificate['metadata'])): ?>
                            <div class="bg-blue-50 border-l-4 border-blue-500 p-4">
                                <h4 class="font-semibold text-blue-900 mb-2">
                                    <i class="fas fa-info-circle mr-2"></i>Completion Details
                                </h4>
                                <?php if (isset($certificate['metadata']['final_score'])): ?>
                                    <p class="text-blue-800 text-sm">
                                        Final Score: <strong><?= $certificate['metadata']['final_score'] ?>%</strong>
                                    </p>
                                <?php endif; ?>
                                <?php if (isset($certificate['metadata']['completion_date'])): ?>
                                    <p class="text-blue-800 text-sm">
                                        Completed: <?= date('F j, Y', strtotime($certificate['metadata']['completion_date'])) ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="mt-8 pt-6 border-t border-gray-200 text-center">
                        <p class="text-sm text-gray-600 mb-4">
                            This certificate can be independently verified at any time using the verification code above.
                        </p>
                        <div class="flex flex-wrap gap-3 justify-center">
                            <a href="<?= url('/portfolio/' . $certificate['email']) ?>" 
                               class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                                <i class="fas fa-user mr-2"></i>View Portfolio
                            </a>
                            <a href="<?= url('/') ?>" 
                               class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                                <i class="fas fa-home mr-2"></i>Home
                            </a>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <!-- Invalid Certificate -->
                <div class="bg-white rounded-xl shadow-lg p-8 border-2 border-red-500">
                    <div class="text-center">
                        <div class="inline-flex items-center justify-center w-20 h-20 bg-red-100 rounded-full mb-4">
                            <i class="fas fa-times-circle text-red-600 text-4xl"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-red-600 mb-4">Certificate Not Found</h2>
                        <p class="text-gray-600 mb-6">
                            The verification code you entered does not match any certificate in our system. 
                            This could mean:
                        </p>
                        
                        <div class="text-left bg-gray-50 rounded-lg p-6 mb-6">
                            <ul class="space-y-2 text-gray-700">
                                <li class="flex items-start">
                                    <i class="fas fa-exclamation-triangle text-yellow-500 mr-3 mt-1"></i>
                                    <span>The verification code was entered incorrectly</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-exclamation-triangle text-yellow-500 mr-3 mt-1"></i>
                                    <span>The certificate has been revoked or expired</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-exclamation-triangle text-yellow-500 mr-3 mt-1"></i>
                                    <span>This is not an authentic Nebatech AI Academy certificate</span>
                                </li>
                            </ul>
                        </div>
                        
                        <p class="text-sm text-gray-600 mb-6">
                            If you believe this is an error, please contact our support team with the verification code.
                        </p>
                        
                        <div class="flex flex-wrap gap-3 justify-center">
                            <a href="<?= url('/contact') ?>" 
                               class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                                <i class="fas fa-envelope mr-2"></i>Contact Support
                            </a>
                            <a href="<?= url('/') ?>" 
                               class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                                <i class="fas fa-home mr-2"></i>Home
                            </a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            
            <!-- Security Note -->
            <div class="mt-8 text-center">
                <div class="inline-flex items-center gap-2 text-sm text-gray-600 bg-white rounded-lg px-4 py-3 shadow">
                    <i class="fas fa-shield-alt text-purple-600"></i>
                    <span>All Nebatech AI Academy certificates are digitally verified and tamper-proof</span>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
