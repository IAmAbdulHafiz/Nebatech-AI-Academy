<!-- Enrollment Page - Hubtel Payment Integration -->
<div class="bg-gray-50 min-h-screen py-12">
    <div class="container mx-auto px-4">
        <!-- Progress Steps -->
        <div class="max-w-4xl mx-auto mb-8">
            <div class="flex items-center justify-between">
                <div class="flex flex-col items-center flex-1">
                    <div class="w-10 h-10 bg-primary text-white rounded-full flex items-center justify-center font-bold mb-2">
                        <i class="fas fa-check"></i>
                    </div>
                    <span class="text-sm font-semibold text-primary">Course Selection</span>
                </div>
                <div class="flex-1 h-1 bg-primary"></div>
                <div class="flex flex-col items-center flex-1">
                    <div class="w-10 h-10 bg-primary text-white rounded-full flex items-center justify-center font-bold mb-2">
                        2
                    </div>
                    <span class="text-sm font-semibold text-primary">Checkout</span>
                </div>
                <div class="flex-1 h-1 bg-gray-300"></div>
                <div class="flex flex-col items-center flex-1">
                    <div class="w-10 h-10 bg-gray-300 text-gray-600 rounded-full flex items-center justify-center font-bold mb-2">
                        3
                    </div>
                    <span class="text-sm text-gray-500">Start Learning</span>
                </div>
            </div>
        </div>

        <div class="max-w-6xl mx-auto grid lg:grid-cols-3 gap-8">
            <!-- Left Column: Course Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-lg p-6 sticky top-24">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Order Summary</h3>
                    
                    <!-- Course Image -->
                    <div class="relative mb-4 rounded-lg overflow-hidden">
                        <div class="bg-gradient-to-br <?= htmlspecialchars($course['card_color_from'] ?? 'from-blue-500') ?> <?= htmlspecialchars($course['card_color_to'] ?? 'to-blue-700') ?> p-8 text-white text-center">
                            <i class="<?= htmlspecialchars($course['card_icon'] ?? 'fas fa-laptop-code') ?> text-5xl mb-3"></i>
                            <h4 class="text-lg font-bold"><?= htmlspecialchars($course['title']) ?></h4>
                        </div>
                    </div>

                    <!-- Course Details -->
                    <div class="space-y-3 mb-6">
                        <div class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-signal w-5"></i>
                            <span class="ml-2"><?= htmlspecialchars($course['level'] ?? 'All Levels') ?></span>
                        </div>
                        <div class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-clock w-5"></i>
                            <span class="ml-2"><?= htmlspecialchars($course['card_duration'] ?? '8 weeks') ?></span>
                        </div>
                        <div class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-book w-5"></i>
                            <span class="ml-2"><?= htmlspecialchars($course['card_modules'] ?? '10') ?> modules</span>
                        </div>
                        <?php if (!empty($course['rating'])): ?>
                        <div class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-star text-yellow-400 w-5"></i>
                            <span class="ml-2"><?= number_format($course['rating'], 1) ?> (<?= number_format($course['review_count'] ?? 0) ?> reviews)</span>
                        </div>
                        <?php endif; ?>
                    </div>

                    <!-- Pricing -->
                    <div class="border-t pt-4 mb-4">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-gray-600">Course Price:</span>
                            <span class="text-2xl font-bold text-primary"><?= $currency ?? 'GH₵' ?> <?= number_format($course['price'], 2) ?></span>
                        </div>
                    </div>

                    <!-- What's Included -->
                    <div class="border-t pt-4">
                        <h4 class="font-semibold text-gray-900 mb-3">What's Included:</h4>
                        <ul class="space-y-2 text-sm text-gray-600">
                            <li class="flex items-start">
                                <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
                                <span>Lifetime access to course materials</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
                                <span>AI-powered personalized learning</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
                                <span>Human mentor support</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
                                <span>Hands-on projects & assignments</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
                                <span>Certificate of completion</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
                                <span>Community access</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Payment Methods Accepted -->
                    <div class="border-t pt-4 mt-4">
                        <h4 class="font-semibold text-gray-900 mb-3">We Accept:</h4>
                        <div class="flex flex-wrap gap-3">
                            <div class="flex items-center gap-1 text-xs text-gray-600 bg-gray-100 px-2 py-1 rounded">
                                <i class="fas fa-mobile-alt text-yellow-500"></i>
                                <span>MTN MoMo</span>
                            </div>
                            <div class="flex items-center gap-1 text-xs text-gray-600 bg-gray-100 px-2 py-1 rounded">
                                <i class="fas fa-mobile-alt text-red-500"></i>
                                <span>Vodafone Cash</span>
                            </div>
                            <div class="flex items-center gap-1 text-xs text-gray-600 bg-gray-100 px-2 py-1 rounded">
                                <i class="fas fa-mobile-alt text-blue-500"></i>
                                <span>AirtelTigo</span>
                            </div>
                            <div class="flex items-center gap-1 text-xs text-gray-600 bg-gray-100 px-2 py-1 rounded">
                                <i class="fab fa-cc-visa text-blue-600"></i>
                                <span>Visa</span>
                            </div>
                            <div class="flex items-center gap-1 text-xs text-gray-600 bg-gray-100 px-2 py-1 rounded">
                                <i class="fab fa-cc-mastercard text-orange-500"></i>
                                <span>Mastercard</span>
                            </div>
                            <div class="flex items-center gap-1 text-xs text-gray-600 bg-gray-100 px-2 py-1 rounded">
                                <i class="fas fa-qrcode text-green-600"></i>
                                <span>GhQR</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Checkout Form -->
            <div class="lg:col-span-2">
                <?php if (!empty($pendingEnrollment)): ?>
                <!-- Pending Payment Notice -->
                <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6 mb-6">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0">
                            <i class="fas fa-clock text-yellow-500 text-2xl"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-semibold text-yellow-800 mb-2">Pending Payment</h3>
                            <p class="text-yellow-700 text-sm mb-3">
                                You have a pending enrollment from <?= date('M d, Y h:i A', strtotime($pendingEnrollment['created_at'])) ?>.
                            </p>
                            <div class="flex gap-3">
                                <a href="<?= url('/payments/status?ref=' . $pendingEnrollment['transaction_id']) ?>" 
                                   class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                                    Check Payment Status
                                </a>
                                <span class="text-yellow-600 text-sm self-center">or continue with a new payment below</span>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <div class="bg-white rounded-xl shadow-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Complete Your Enrollment</h2>
                    <p class="text-gray-600 mb-6">Enter your details below and you'll be redirected to our secure payment page.</p>

                    <form id="enrollmentForm" method="POST" action="<?= url('/courses/' . $course['slug'] . '/enroll') ?>">
                        <?= csrf_field() ?>
                        
                        <!-- Student Information -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <i class="fas fa-user-circle text-primary mr-2"></i>
                                Your Information
                            </h3>
                            <div class="grid md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Full Name *</label>
                                    <input type="text" name="full_name" required
                                           value="<?= htmlspecialchars(($_SESSION['user']['first_name'] ?? '') . ' ' . ($_SESSION['user']['last_name'] ?? '')) ?>"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                           placeholder="Enter your full name">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Email Address *</label>
                                    <input type="email" name="email" required
                                           value="<?= htmlspecialchars($_SESSION['user']['email'] ?? '') ?>"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-gray-50"
                                           readonly>
                                    <p class="text-xs text-gray-500 mt-1">Receipt will be sent to this email</p>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number *</label>
                                    <input type="tel" name="phone" required
                                           value="<?= htmlspecialchars($_SESSION['user']['phone'] ?? '') ?>"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                           placeholder="e.g. 024 123 4567">
                                    <p class="text-xs text-gray-500 mt-1">For payment verification via Mobile Money</p>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Info -->
                        <div class="mb-8 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <i class="fas fa-shield-alt text-green-500 mr-2"></i>
                                Secure Payment via Hubtel
                            </h3>
                            <p class="text-gray-600 mb-4">
                                After clicking "Proceed to Payment", you will be redirected to Hubtel's secure payment page 
                                where you can choose your preferred payment method:
                            </p>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                <div class="bg-white rounded-lg p-3 text-center shadow-sm">
                                    <i class="fas fa-mobile-alt text-2xl text-primary mb-2"></i>
                                    <p class="text-xs text-gray-600">Mobile Money</p>
                                </div>
                                <div class="bg-white rounded-lg p-3 text-center shadow-sm">
                                    <i class="fas fa-credit-card text-2xl text-primary mb-2"></i>
                                    <p class="text-xs text-gray-600">Bank Card</p>
                                </div>
                                <div class="bg-white rounded-lg p-3 text-center shadow-sm">
                                    <i class="fas fa-wallet text-2xl text-primary mb-2"></i>
                                    <p class="text-xs text-gray-600">Digital Wallet</p>
                                </div>
                                <div class="bg-white rounded-lg p-3 text-center shadow-sm">
                                    <i class="fas fa-qrcode text-2xl text-primary mb-2"></i>
                                    <p class="text-xs text-gray-600">Ghana QR</p>
                                </div>
                            </div>
                        </div>

                        <!-- Terms and Conditions -->
                        <div class="mb-6">
                            <label class="flex items-start cursor-pointer">
                                <input type="checkbox" name="terms" required class="mt-1 mr-3 w-5 h-5 text-primary border-gray-300 rounded focus:ring-primary">
                                <span class="text-sm text-gray-700">
                                    I agree to the <a href="<?= url('/terms') ?>" class="text-primary hover:underline" target="_blank">Terms & Conditions</a> 
                                    and <a href="<?= url('/privacy') ?>" class="text-primary hover:underline" target="_blank">Privacy Policy</a>. 
                                    I understand that upon successful payment, I will gain immediate access to the course materials.
                                </span>
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex gap-4">
                            <a href="<?= url('/courses/' . $course['slug']) ?>" 
                               class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-4 px-6 rounded-lg transition text-center">
                                <i class="fas fa-arrow-left mr-2"></i>Back to Course
                            </a>
                            <button type="submit" id="submitBtn"
                                    class="flex-1 bg-gradient-to-r from-primary to-blue-600 hover:from-blue-700 hover:to-blue-800 text-white font-bold py-4 px-6 rounded-lg transition shadow-lg hover:shadow-xl flex items-center justify-center">
                                <i class="fas fa-lock mr-2"></i>
                                <span>Proceed to Payment</span>
                                <i class="fas fa-arrow-right ml-2"></i>
                            </button>
                        </div>
                    </form>

                    <!-- Security Badge -->
                    <div class="mt-6 flex items-center justify-center gap-4 text-sm text-gray-500">
                        <i class="fas fa-shield-alt text-green-500"></i>
                        <span>Secure 256-bit SSL encryption</span>
                        <span>•</span>
                        <span>Powered by Hubtel</span>
                    </div>
                </div>

                <!-- Trust Badges -->
                <div class="mt-8 bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 text-center">Why Choose Nebatech AI Academy?</h3>
                    <div class="grid md:grid-cols-3 gap-6">
                        <div class="text-center">
                            <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-certificate text-2xl text-primary"></i>
                            </div>
                            <h4 class="font-semibold text-gray-900 mb-2">Certified Learning</h4>
                            <p class="text-sm text-gray-600">Get industry-recognized certificates</p>
                        </div>
                        <div class="text-center">
                            <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-users text-2xl text-green-600"></i>
                            </div>
                            <h4 class="font-semibold text-gray-900 mb-2">5,000+ Students</h4>
                            <p class="text-sm text-gray-600">Join our growing community</p>
                        </div>
                        <div class="text-center">
                            <div class="bg-yellow-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-headset text-2xl text-yellow-600"></i>
                            </div>
                            <h4 class="font-semibold text-gray-900 mb-2">24/7 Support</h4>
                            <p class="text-sm text-gray-600">Get help whenever you need it</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Processing Overlay -->
<div id="processingOverlay" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white rounded-xl p-8 max-w-md mx-4 text-center">
        <div class="animate-spin rounded-full h-16 w-16 border-b-2 border-primary mx-auto mb-4"></div>
        <h3 class="text-xl font-bold text-gray-900 mb-2">Preparing Checkout...</h3>
        <p class="text-gray-600">Please wait while we redirect you to the secure payment page.</p>
    </div>
</div>

<script>
document.getElementById('enrollmentForm').addEventListener('submit', function(e) {
    // Show processing overlay
    document.getElementById('processingOverlay').classList.remove('hidden');
    
    // Disable submit button to prevent double submission
    const submitBtn = document.getElementById('submitBtn');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Processing...';
});
</script>
