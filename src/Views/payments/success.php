<!-- Payment Success Page -->
<div class="bg-gray-50 min-h-screen py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-2xl mx-auto">
            <?php if ($status === 'completed'): ?>
            <!-- Payment Successful -->
            <div class="bg-white rounded-xl shadow-lg p-8 text-center">
                <div class="mb-6">
                    <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-check text-4xl text-green-500"></i>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Payment Successful!</h1>
                    <p class="text-gray-600">Your enrollment has been confirmed.</p>
                </div>

                <!-- Transaction Details -->
                <div class="bg-gray-50 rounded-lg p-6 mb-6 text-left">
                    <h3 class="font-semibold text-gray-900 mb-4">Transaction Details</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Reference:</span>
                            <span class="font-mono text-sm"><?= htmlspecialchars($reference ?? 'N/A') ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Course:</span>
                            <span class="font-medium"><?= htmlspecialchars($course['title'] ?? 'N/A') ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Amount:</span>
                            <span class="font-bold text-green-600"><?= $currency ?? 'GH₵' ?> <?= number_format($amount ?? 0, 2) ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Date:</span>
                            <span><?= date('M d, Y h:i A') ?></span>
                        </div>
                    </div>
                </div>

                <!-- Next Steps -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-6 text-left">
                    <h3 class="font-semibold text-blue-900 mb-3">
                        <i class="fas fa-info-circle mr-2"></i>What's Next?
                    </h3>
                    <ul class="space-y-2 text-blue-800">
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-blue-500 mt-1 mr-2"></i>
                            <span>A confirmation email has been sent to your email address</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-blue-500 mt-1 mr-2"></i>
                            <span>You can now access the course from your dashboard</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-blue-500 mt-1 mr-2"></i>
                            <span>Start learning at your own pace with AI-powered support</span>
                        </li>
                    </ul>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="<?= url('/dashboard/courses') ?>" 
                       class="flex-1 bg-primary hover:bg-blue-700 text-white font-bold py-4 px-6 rounded-lg transition flex items-center justify-center">
                        <i class="fas fa-play-circle mr-2"></i>Start Learning Now
                    </a>
                    <a href="<?= url('/courses') ?>" 
                       class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-4 px-6 rounded-lg transition flex items-center justify-center">
                        <i class="fas fa-search mr-2"></i>Browse More Courses
                    </a>
                </div>
            </div>

            <?php elseif ($status === 'pending'): ?>
            <!-- Payment Processing -->
            <div class="bg-white rounded-xl shadow-lg p-8 text-center" id="pendingCard">
                <div class="mb-6">
                    <div class="w-20 h-20 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-clock text-4xl text-yellow-500 animate-pulse"></i>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Payment Processing</h1>
                    <p class="text-gray-600">Please wait while we verify your payment...</p>
                </div>

                <!-- Status Check Progress -->
                <div class="bg-gray-50 rounded-lg p-6 mb-6">
                    <div class="flex items-center justify-center gap-3 mb-4">
                        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-primary"></div>
                        <span class="text-gray-700" id="statusMessage">Checking payment status...</span>
                    </div>
                    <p class="text-sm text-gray-500">
                        Reference: <span class="font-mono"><?= htmlspecialchars($reference ?? 'N/A') ?></span>
                    </p>
                </div>

                <!-- Mobile Money Instructions -->
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 mb-6 text-left">
                    <h3 class="font-semibold text-yellow-900 mb-3">
                        <i class="fas fa-mobile-alt mr-2"></i>For Mobile Money Payments
                    </h3>
                    <ol class="list-decimal list-inside space-y-2 text-yellow-800">
                        <li>Check your phone for a payment prompt</li>
                        <li>Enter your Mobile Money PIN to authorize</li>
                        <li>Wait for confirmation SMS</li>
                        <li>This page will update automatically</li>
                    </ol>
                </div>

                <!-- Manual Check Button -->
                <div class="flex flex-col gap-4">
                    <button onclick="checkPaymentStatus()" 
                            class="bg-primary hover:bg-blue-700 text-white font-bold py-4 px-6 rounded-lg transition flex items-center justify-center">
                        <i class="fas fa-sync-alt mr-2"></i>Check Status Now
                    </button>
                    <a href="<?= url('/dashboard') ?>" 
                       class="text-gray-600 hover:text-gray-900 text-sm">
                        Go to Dashboard →
                    </a>
                </div>
            </div>

            <!-- Success Card (Hidden, shown after confirmation) -->
            <div class="hidden bg-white rounded-xl shadow-lg p-8 text-center" id="successCard">
                <div class="mb-6">
                    <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-check text-4xl text-green-500"></i>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Payment Confirmed!</h1>
                    <p class="text-gray-600">Your enrollment is now active.</p>
                </div>
                <a href="<?= url('/dashboard/courses') ?>" 
                   class="inline-block bg-primary hover:bg-blue-700 text-white font-bold py-4 px-8 rounded-lg transition">
                    <i class="fas fa-play-circle mr-2"></i>Start Learning Now
                </a>
            </div>

            <?php else: ?>
            <!-- Payment Failed -->
            <div class="bg-white rounded-xl shadow-lg p-8 text-center">
                <div class="mb-6">
                    <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-times text-4xl text-red-500"></i>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Payment Failed</h1>
                    <p class="text-gray-600"><?= htmlspecialchars($message ?? 'Your payment could not be processed.') ?></p>
                </div>

                <!-- Error Details -->
                <?php if (!empty($error)): ?>
                <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6 text-left">
                    <p class="text-red-800"><strong>Error:</strong> <?= htmlspecialchars($error) ?></p>
                </div>
                <?php endif; ?>

                <!-- Retry Options -->
                <div class="bg-gray-50 rounded-lg p-6 mb-6 text-left">
                    <h3 class="font-semibold text-gray-900 mb-3">What can you do?</h3>
                    <ul class="space-y-2 text-gray-700">
                        <li class="flex items-start">
                            <i class="fas fa-check text-primary mt-1 mr-2"></i>
                            <span>Make sure you have sufficient balance</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-primary mt-1 mr-2"></i>
                            <span>Check your network connection</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-primary mt-1 mr-2"></i>
                            <span>Try a different payment method</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-primary mt-1 mr-2"></i>
                            <span>Contact support if the problem persists</span>
                        </li>
                    </ul>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4">
                    <?php if (!empty($courseSlug)): ?>
                    <a href="<?= url('/courses/' . $courseSlug . '/enroll') ?>" 
                       class="flex-1 bg-primary hover:bg-blue-700 text-white font-bold py-4 px-6 rounded-lg transition flex items-center justify-center">
                        <i class="fas fa-redo mr-2"></i>Try Again
                    </a>
                    <?php endif; ?>
                    <a href="<?= url('/contact') ?>" 
                       class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-4 px-6 rounded-lg transition flex items-center justify-center">
                        <i class="fas fa-headset mr-2"></i>Contact Support
                    </a>
                </div>
            </div>
            <?php endif; ?>

            <!-- Need Help? -->
            <div class="mt-8 text-center">
                <p class="text-gray-500">
                    Need help? <a href="<?= url('/contact') ?>" class="text-primary hover:underline">Contact our support team</a>
                </p>
            </div>
        </div>
    </div>
</div>

<?php if ($status === 'pending'): ?>
<script>
const reference = '<?= htmlspecialchars($reference ?? '') ?>';
let checkCount = 0;
const maxChecks = 30; // Stop after 30 checks (5 minutes)

async function checkPaymentStatus() {
    if (checkCount >= maxChecks) {
        document.getElementById('statusMessage').textContent = 'Taking longer than expected. Please check your dashboard.';
        return;
    }
    
    checkCount++;
    
    try {
        const response = await fetch(`/api/payments/status?ref=${reference}`);
        const data = await response.json();
        
        if (data.status === 'completed') {
            // Payment confirmed
            document.getElementById('pendingCard').classList.add('hidden');
            document.getElementById('successCard').classList.remove('hidden');
            return;
        } else if (data.status === 'failed') {
            // Payment failed - reload page to show error
            window.location.reload();
            return;
        }
        
        // Still pending - update message and continue checking
        document.getElementById('statusMessage').textContent = `Still processing... (Check ${checkCount})`;
        
        // Schedule next check in 10 seconds
        setTimeout(checkPaymentStatus, 10000);
    } catch (error) {
        console.error('Error checking status:', error);
        document.getElementById('statusMessage').textContent = 'Connection error. Retrying...';
        setTimeout(checkPaymentStatus, 15000);
    }
}

// Start checking after 5 seconds
setTimeout(checkPaymentStatus, 5000);
</script>
<?php endif; ?>
