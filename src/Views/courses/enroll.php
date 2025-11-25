<!-- Enrollment Page -->
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
                    <span class="text-sm font-semibold text-primary">Payment</span>
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
                        <div class="bg-gradient-to-br <?= htmlspecialchars($course['card_color_from']) ?> <?= htmlspecialchars($course['card_color_to']) ?> p-8 text-white text-center">
                            <i class="<?= htmlspecialchars($course['card_icon']) ?> text-5xl mb-3"></i>
                            <h4 class="text-lg font-bold"><?= htmlspecialchars($course['title']) ?></h4>
                        </div>
                    </div>

                    <!-- Course Details -->
                    <div class="space-y-3 mb-6">
                        <div class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-signal w-5"></i>
                            <span class="ml-2"><?= htmlspecialchars($course['level']) ?></span>
                        </div>
                        <div class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-clock w-5"></i>
                            <span class="ml-2"><?= htmlspecialchars($course['card_duration']) ?></span>
                        </div>
                        <div class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-book w-5"></i>
                            <span class="ml-2"><?= htmlspecialchars($course['card_modules']) ?> modules</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-star text-yellow-400 w-5"></i>
                            <span class="ml-2"><?= number_format($course['rating'], 1) ?> (<?= number_format($course['review_count']) ?> reviews)</span>
                        </div>
                    </div>

                    <!-- Pricing -->
                    <div class="border-t pt-4 mb-4">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-gray-600">Course Price:</span>
                            <span class="text-2xl font-bold text-primary">GHS <?= number_format($course['price'], 2) ?></span>
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
                </div>
            </div>

            <!-- Right Column: Payment Form -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Complete Your Enrollment</h2>

                    <form id="enrollmentForm" method="POST" action="<?= url('/courses/' . $course['slug'] . '/enroll') ?>">
                        <!-- Student Information -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <i class="fas fa-user-circle text-primary mr-2"></i>
                                Student Information
                            </h3>
                            <div class="grid md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Full Name *</label>
                                    <input type="text" name="full_name" required
                                           value="<?= htmlspecialchars($_SESSION['user']['name'] ?? '') ?>"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                           placeholder="John Doe">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Email Address *</label>
                                    <input type="email" name="email" required
                                           value="<?= htmlspecialchars($_SESSION['user']['email'] ?? '') ?>"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                           placeholder="john@example.com">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number *</label>
                                    <input type="tel" name="phone" required
                                           value="<?= htmlspecialchars($_SESSION['user']['phone'] ?? '') ?>"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                           placeholder="+233 24 123 4567">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Location</label>
                                    <input type="text" name="location"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                           placeholder="Accra, Ghana">
                                </div>
                            </div>
                        </div>

                        <!-- Payment Method Selection -->
                        <div class="mb-8" x-data="{ paymentMethod: 'mobile_money' }">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <i class="fas fa-credit-card text-primary mr-2"></i>
                                Payment Method
                            </h3>

                            <!-- Payment Method Options -->
                            <div class="grid md:grid-cols-3 gap-4 mb-6">
                                <!-- Mobile Money -->
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="payment_method" value="mobile_money" 
                                           x-model="paymentMethod" class="peer sr-only">
                                    <div class="border-2 border-gray-300 rounded-lg p-4 peer-checked:border-primary peer-checked:bg-blue-50 hover:border-primary transition">
                                        <div class="flex flex-col items-center text-center">
                                            <i class="fas fa-mobile-alt text-3xl text-primary mb-2"></i>
                                            <span class="font-semibold text-gray-900">Mobile Money</span>
                                            <span class="text-xs text-gray-500 mt-1">MTN, Vodafone, AirtelTigo</span>
                                        </div>
                                    </div>
                                </label>

                                <!-- Card Payment -->
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="payment_method" value="card" 
                                           x-model="paymentMethod" class="peer sr-only">
                                    <div class="border-2 border-gray-300 rounded-lg p-4 peer-checked:border-primary peer-checked:bg-blue-50 hover:border-primary transition">
                                        <div class="flex flex-col items-center text-center">
                                            <i class="fas fa-credit-card text-3xl text-primary mb-2"></i>
                                            <span class="font-semibold text-gray-900">Card Payment</span>
                                            <span class="text-xs text-gray-500 mt-1">Visa, Mastercard</span>
                                        </div>
                                    </div>
                                </label>

                                <!-- Bank Transfer -->
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="payment_method" value="bank_transfer" 
                                           x-model="paymentMethod" class="peer sr-only">
                                    <div class="border-2 border-gray-300 rounded-lg p-4 peer-checked:border-primary peer-checked:bg-blue-50 hover:border-primary transition">
                                        <div class="flex flex-col items-center text-center">
                                            <i class="fas fa-university text-3xl text-primary mb-2"></i>
                                            <span class="font-semibold text-gray-900">Bank Transfer</span>
                                            <span class="text-xs text-gray-500 mt-1">Direct bank deposit</span>
                                        </div>
                                    </div>
                                </label>
                            </div>

                            <!-- Mobile Money Details -->
                            <div x-show="paymentMethod === 'mobile_money'" x-transition class="bg-gray-50 rounded-lg p-6">
                                <h4 class="font-semibold text-gray-900 mb-4">Mobile Money Details</h4>
                                <div class="grid md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Network *</label>
                                        <select name="momo_network" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                                            <option value="">Select Network</option>
                                            <option value="mtn">MTN Mobile Money</option>
                                            <option value="vodafone">Vodafone Cash</option>
                                            <option value="airteltigo">AirtelTigo Money</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Mobile Number *</label>
                                        <input type="tel" name="momo_number" required
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                               placeholder="024 123 4567">
                                    </div>
                                </div>
                                <p class="text-sm text-gray-600 mt-4">
                                    <i class="fas fa-info-circle text-primary mr-1"></i>
                                    You will receive a prompt on your phone to authorize the payment.
                                </p>
                            </div>

                            <!-- Card Payment Details -->
                            <div x-show="paymentMethod === 'card'" x-transition class="bg-gray-50 rounded-lg p-6">
                                <h4 class="font-semibold text-gray-900 mb-4">Card Details</h4>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Card Number *</label>
                                        <input type="text" name="card_number" required
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                               placeholder="1234 5678 9012 3456">
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Expiry Date *</label>
                                            <input type="text" name="card_expiry" required
                                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                                   placeholder="MM/YY">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">CVV *</label>
                                            <input type="text" name="card_cvv" required
                                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                                   placeholder="123">
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3 mt-4 text-gray-500">
                                    <i class="fab fa-cc-visa text-3xl"></i>
                                    <i class="fab fa-cc-mastercard text-3xl"></i>
                                    <span class="text-sm">Secured by SSL encryption</span>
                                </div>
                            </div>

                            <!-- Bank Transfer Details -->
                            <div x-show="paymentMethod === 'bank_transfer'" x-transition class="bg-gray-50 rounded-lg p-6">
                                <h4 class="font-semibold text-gray-900 mb-4">Bank Transfer Instructions</h4>
                                <div class="bg-white border border-gray-200 rounded-lg p-4 mb-4">
                                    <p class="text-sm text-gray-600 mb-3">Please transfer <strong class="text-primary">GHS <?= number_format($course['price'], 2) ?></strong> to:</p>
                                    <div class="space-y-2 text-sm">
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Bank Name:</span>
                                            <span class="font-semibold">Access Bank Ghana</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Account Name:</span>
                                            <span class="font-semibold">Nebatech AI Academy</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Account Number:</span>
                                            <span class="font-semibold">1234567890</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Branch:</span>
                                            <span class="font-semibold">Tamale Branch</span>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Transaction Reference *</label>
                                    <input type="text" name="bank_reference" required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                           placeholder="Enter bank transaction reference">
                                    <p class="text-xs text-gray-500 mt-1">Your enrollment will be activated after verification (1-2 business days)</p>
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
                            <button type="submit" 
                                    class="flex-1 bg-gradient-to-r from-primary to-blue-600 hover:from-blue-700 hover:to-blue-800 text-white font-bold py-4 px-6 rounded-lg transition shadow-lg hover:shadow-xl">
                                <i class="fas fa-lock mr-2"></i>Complete Enrollment
                            </button>
                        </div>
                    </form>

                    <!-- Security Badge -->
                    <div class="mt-6 flex items-center justify-center gap-4 text-sm text-gray-500">
                        <i class="fas fa-shield-alt text-green-500"></i>
                        <span>Secure 256-bit SSL encryption</span>
                        <span>•</span>
                        <span>Money-back guarantee</span>
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
        <h3 class="text-xl font-bold text-gray-900 mb-2">Processing Payment...</h3>
        <p class="text-gray-600">Please wait while we process your enrollment. Do not close this window.</p>
    </div>
</div>

<script>
document.getElementById('enrollmentForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Show processing overlay
    document.getElementById('processingOverlay').classList.remove('hidden');
    
    // Submit form after short delay (simulate processing)
    setTimeout(() => {
        this.submit();
    }, 1000);
});
</script>
