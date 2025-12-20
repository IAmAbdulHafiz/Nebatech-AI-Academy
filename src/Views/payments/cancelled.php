<!-- Payment Cancelled Page -->
<div class="bg-gray-50 min-h-screen py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-2xl mx-auto">
            <div class="bg-white rounded-xl shadow-lg p-8 text-center">
                <div class="mb-6">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-times-circle text-4xl text-gray-400"></i>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Payment Cancelled</h1>
                    <p class="text-gray-600">You cancelled the payment process.</p>
                </div>

                <!-- Course Info (if available) -->
                <?php if (!empty($course)): ?>
                <div class="bg-gray-50 rounded-lg p-6 mb-6 text-left">
                    <div class="flex items-start gap-4">
                        <div class="bg-gradient-to-br <?= htmlspecialchars($course['card_color_from'] ?? 'from-blue-500') ?> <?= htmlspecialchars($course['card_color_to'] ?? 'to-blue-700') ?> w-16 h-16 rounded-lg flex items-center justify-center text-white flex-shrink-0">
                            <i class="<?= htmlspecialchars($course['card_icon'] ?? 'fas fa-laptop-code') ?> text-2xl"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-900"><?= htmlspecialchars($course['title']) ?></h3>
                            <p class="text-sm text-gray-600 mb-2"><?= htmlspecialchars($course['level'] ?? 'All Levels') ?></p>
                            <p class="text-lg font-bold text-primary"><?= $currency ?? 'GH₵' ?> <?= number_format($course['price'], 2) ?></p>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Encouragement Message -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-6 text-left">
                    <h3 class="font-semibold text-blue-900 mb-3">
                        <i class="fas fa-lightbulb mr-2"></i>Don't Miss Out!
                    </h3>
                    <p class="text-blue-800 mb-4">
                        This course will help you master in-demand AI skills and advance your career. 
                        Complete your enrollment to get started today!
                    </p>
                    <ul class="space-y-2 text-blue-800">
                        <li class="flex items-start">
                            <i class="fas fa-check text-blue-500 mt-1 mr-2"></i>
                            <span>Lifetime access to course materials</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-blue-500 mt-1 mr-2"></i>
                            <span>AI-powered personalized learning</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-blue-500 mt-1 mr-2"></i>
                            <span>Industry-recognized certificate</span>
                        </li>
                    </ul>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4">
                    <?php if (!empty($course)): ?>
                    <a href="<?= url('/courses/' . $course['slug'] . '/enroll') ?>" 
                       class="flex-1 bg-primary hover:bg-blue-700 text-white font-bold py-4 px-6 rounded-lg transition flex items-center justify-center">
                        <i class="fas fa-redo mr-2"></i>Complete Enrollment
                    </a>
                    <a href="<?= url('/courses/' . $course['slug']) ?>" 
                       class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-4 px-6 rounded-lg transition flex items-center justify-center">
                        <i class="fas fa-arrow-left mr-2"></i>Back to Course
                    </a>
                    <?php else: ?>
                    <a href="<?= url('/courses') ?>" 
                       class="flex-1 bg-primary hover:bg-blue-700 text-white font-bold py-4 px-6 rounded-lg transition flex items-center justify-center">
                        <i class="fas fa-search mr-2"></i>Browse Courses
                    </a>
                    <a href="<?= url('/dashboard') ?>" 
                       class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-4 px-6 rounded-lg transition flex items-center justify-center">
                        <i class="fas fa-home mr-2"></i>Go to Dashboard
                    </a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Have Questions? -->
            <div class="mt-8 bg-white rounded-xl shadow-lg p-6">
                <h3 class="font-semibold text-gray-900 mb-4 text-center">Have Questions?</h3>
                <div class="grid md:grid-cols-2 gap-4">
                    <a href="<?= url('/faq') ?>" class="flex items-center gap-3 p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                        <i class="fas fa-question-circle text-2xl text-primary"></i>
                        <div>
                            <h4 class="font-medium text-gray-900">FAQ</h4>
                            <p class="text-sm text-gray-600">Find answers to common questions</p>
                        </div>
                    </a>
                    <a href="<?= url('/contact') ?>" class="flex items-center gap-3 p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                        <i class="fas fa-headset text-2xl text-primary"></i>
                        <div>
                            <h4 class="font-medium text-gray-900">Contact Support</h4>
                            <p class="text-sm text-gray-600">We're here to help</p>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Security Notice -->
            <div class="mt-6 text-center text-sm text-gray-500">
                <i class="fas fa-shield-alt text-green-500 mr-1"></i>
                Your payment information is never stored on our servers.
            </div>
        </div>
    </div>
</div>
