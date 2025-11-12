<?php 
$content = ob_start(); 
?>

<!-- Hero Section -->
<section class="bg-primary text-white py-20 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-10 left-10 w-72 h-72 bg-white rounded-full blur-3xl"></div>
        <div class="absolute bottom-10 right-10 w-96 h-96 bg-secondary rounded-full blur-3xl"></div>
    </div>
    <div class="container mx-auto px-6 relative z-10">
        <div class="max-w-4xl mx-auto text-center">
            <!-- Breadcrumb -->
            <nav class="mb-8">
                <ol class="flex items-center justify-center space-x-2 text-sm text-gray-300">
                    <li><a href="<?= url('/') ?>" class="hover:text-white transition-colors">Home</a></li>
                    <li><span class="mx-2">/</span></li>
                    <li><a href="<?= url('/services') ?>" class="hover:text-white transition-colors">Services</a></li>
                    <li><span class="mx-2">/</span></li>
                    <li class="text-secondary"><?= htmlspecialchars($service['title']) ?></li>
                </ol>
            </nav>
            
            <h1 class="text-4xl md:text-5xl font-bold mb-6 leading-tight">
                <?= htmlspecialchars($service['title']) ?>
            </h1>
            <p class="text-xl text-gray-200 max-w-2xl mx-auto">
                <?= htmlspecialchars($service['short_description']) ?>
            </p>
        </div>
    </div>
</section>

<!-- Service Details -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-6">
        <div class="max-w-6xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                <!-- Main Content -->
                <div class="lg:col-span-2">
                    <div class="prose prose-lg max-w-none">
                        <?= $service['description'] ?>
                    </div>
                    
                    <!-- Key Features -->
                    <?php if (!empty($service['features'])): ?>
                        <?php $features = is_string($service['features']) ? json_decode($service['features'], true) : $service['features']; ?>
                        <?php if (is_array($features) && count($features) > 0): ?>
                        <div class="mt-12">
                            <h3 class="text-2xl font-bold text-gray-800 mb-6">Key Features</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <?php foreach ($features as $feature): ?>
                                <div class="flex items-start space-x-3">
                                    <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                        <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <span class="text-gray-700"><?= htmlspecialchars($feature) ?></span>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
                
                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <div class="bg-gray-50 rounded-xl p-8 sticky top-8">
                        <!-- Service Icon -->
                        <div class="w-16 h-16 bg-primary/10 rounded-xl flex items-center justify-center mb-6">
                            <span class="text-3xl"><?= $service['icon'] ?? '💻' ?></span>
                        </div>
                        
                        <!-- Pricing -->
                        <?php if (!empty($service['pricing_info'])): ?>
                        <div class="mb-6">
                            <h4 class="text-lg font-bold text-gray-800 mb-2">Pricing</h4>
                            <div class="text-3xl font-bold text-primary mb-2">
                                <?= htmlspecialchars($service['pricing_info']) ?>
                            </div>
                            <p class="text-sm text-gray-600">Custom quotes available for enterprise solutions</p>
                        </div>
                        <?php endif; ?>
                        
                        <!-- CTA Buttons -->
                        <div class="space-y-3">
                            <a href="<?= url('/request-quote') ?>?service=<?= urlencode($service['title']) ?>" 
                               class="w-full bg-secondary hover:bg-orange-600 text-white font-bold py-3 px-6 rounded-lg transition-colors text-center block">
                                Get Quote
                            </a>
                            <a href="<?= url('/contact') ?>" 
                               class="w-full bg-primary hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors text-center block">
                                Contact Us
                            </a>
                        </div>
                        
                        <!-- Contact Info -->
                        <div class="mt-8 pt-8 border-t border-gray-200">
                            <h4 class="text-lg font-bold text-gray-800 mb-4">Need Help?</h4>
                            <div class="space-y-3 text-sm">
                                <div class="flex items-center space-x-3">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                    <div>
                                        <div class="text-gray-700">024 763 6080</div>
                                        <div class="text-gray-700">020 678 9600</div>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    <span class="text-gray-700">info@nebatech.com</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Services -->
<?php if (!empty($relatedServices)): ?>
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-6">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-800 mb-4">Related Services</h2>
            <p class="text-lg text-gray-600">Explore our other professional IT solutions</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
            <?php foreach ($relatedServices as $relatedService): ?>
            <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="p-6">
                    <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center mb-4">
                        <span class="text-2xl"><?= $relatedService['icon'] ?? '💻' ?></span>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 mb-3">
                        <?= htmlspecialchars($relatedService['title']) ?>
                    </h3>
                    <p class="text-gray-600 mb-4 text-sm">
                        <?= htmlspecialchars(substr($relatedService['short_description'], 0, 100)) ?>...
                    </p>
                    <a href="<?= url('/services/' . $relatedService['slug']) ?>" 
                       class="text-primary font-semibold hover:text-blue-700 transition-colors text-sm">
                        Learn More →
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- FAQ Section -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-6">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Frequently Asked Questions</h2>
                <p class="text-lg text-gray-600">Common questions about this service</p>
            </div>
            
            <div class="space-y-4" x-data="{ openFaq: null }">
                <div class="border border-gray-200 rounded-lg">
                    <button @click="openFaq = openFaq === 1 ? null : 1" 
                            class="w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50 transition-colors">
                        <span class="font-semibold text-gray-800">How long does the project take?</span>
                        <svg class="w-5 h-5 text-gray-500 transform transition-transform" 
                             :class="openFaq === 1 ? 'rotate-180' : ''" 
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="openFaq === 1" x-collapse class="px-6 pb-4">
                        <p class="text-gray-600">Project timelines vary based on complexity and requirements. We provide detailed timelines during the planning phase and keep you updated throughout the development process.</p>
                    </div>
                </div>
                
                <div class="border border-gray-200 rounded-lg">
                    <button @click="openFaq = openFaq === 2 ? null : 2" 
                            class="w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50 transition-colors">
                        <span class="font-semibold text-gray-800">Do you provide ongoing support?</span>
                        <svg class="w-5 h-5 text-gray-500 transform transition-transform" 
                             :class="openFaq === 2 ? 'rotate-180' : ''" 
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="openFaq === 2" x-collapse class="px-6 pb-4">
                        <p class="text-gray-600">Yes, we offer comprehensive maintenance and support packages to ensure your solution continues to perform optimally. Our support includes updates, bug fixes, and technical assistance.</p>
                    </div>
                </div>
                
                <div class="border border-gray-200 rounded-lg">
                    <button @click="openFaq = openFaq === 3 ? null : 3" 
                            class="w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50 transition-colors">
                        <span class="font-semibold text-gray-800">Can you work with our existing systems?</span>
                        <svg class="w-5 h-5 text-gray-500 transform transition-transform" 
                             :class="openFaq === 3 ? 'rotate-180' : ''" 
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="openFaq === 3" x-collapse class="px-6 pb-4">
                        <p class="text-gray-600">Absolutely! We specialize in integrating new solutions with existing systems. We conduct thorough assessments to ensure seamless integration without disrupting your current operations.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-16 bg-primary text-white">
    <div class="container mx-auto px-6 text-center">
        <h2 class="text-3xl font-bold mb-4">Ready to Get Started?</h2>
        <p class="text-lg mb-8 text-gray-200 max-w-2xl mx-auto">
            Let's discuss how this service can benefit your business. Get a free consultation today.
        </p>
        <div class="flex flex-col sm:flex-row justify-center gap-4">
            <a href="<?= url('/request-quote') ?>?service=<?= urlencode($service['title']) ?>" 
               class="bg-secondary hover:bg-orange-600 text-white font-bold px-8 py-3 rounded-lg transition-colors">
                Get Free Quote
            </a>
            <a href="<?= url('/contact') ?>" 
               class="bg-white text-primary hover:bg-gray-100 font-bold px-8 py-3 rounded-lg transition-colors">
                Schedule Consultation
            </a>
        </div>
    </div>
</section>

<?php 
$content = ob_get_clean();
include __DIR__ . '/../../layouts/main.php'; 
?>
