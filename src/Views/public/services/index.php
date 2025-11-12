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
            <h1 class="text-5xl md:text-6xl font-bold mb-6 leading-tight">Our IT Services</h1>
            <p class="text-xl md:text-2xl text-gray-200 max-w-2xl mx-auto">
                Comprehensive technology solutions designed to drive your business forward
            </p>
        </div>
    </div>
</section>

<!-- Services Grid -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-6">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-800 mb-4">Professional IT Solutions</h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                From custom software development to infrastructure setup, we deliver excellence in every project
            </p>
            <div class="w-24 h-1 bg-secondary mx-auto mt-6"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-7xl mx-auto">
            <?php foreach ($services as $service): ?>
            <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 group">
                <div class="p-8">
                    <!-- Service Icon -->
                    <div class="w-16 h-16 bg-primary/10 rounded-xl flex items-center justify-center mb-6 group-hover:bg-primary/20 transition-colors">
                        <span class="text-3xl"><?= $service['icon'] ?? '💻' ?></span>
                    </div>
                    
                    <!-- Service Title -->
                    <h3 class="text-xl font-bold text-gray-800 mb-4 group-hover:text-primary transition-colors">
                        <?= htmlspecialchars($service['title']) ?>
                    </h3>
                    
                    <!-- Service Description -->
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        <?= htmlspecialchars($service['short_description']) ?>
                    </p>
                    
                    <!-- Features List -->
                    <?php if (!empty($service['features'])): ?>
                        <?php $features = is_string($service['features']) ? json_decode($service['features'], true) : $service['features']; ?>
                        <?php if (is_array($features) && count($features) > 0): ?>
                        <ul class="space-y-2 mb-6">
                            <?php foreach (array_slice($features, 0, 3) as $feature): ?>
                            <li class="flex items-center text-sm text-gray-600">
                                <svg class="w-4 h-4 text-green-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <?= htmlspecialchars($feature) ?>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                        <?php endif; ?>
                    <?php endif; ?>
                    
                    <!-- Pricing -->
                    <?php if (!empty($service['pricing_info'])): ?>
                    <div class="mb-6">
                        <span class="text-2xl font-bold text-primary"><?= htmlspecialchars($service['pricing_info']) ?></span>
                    </div>
                    <?php endif; ?>
                    
                    <!-- CTA Button -->
                    <div class="flex gap-3">
                        <a href="<?= url('/services/' . $service['slug']) ?>" 
                           class="flex-1 bg-primary hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg transition-colors text-center">
                            Learn More
                        </a>
                        <a href="<?= url('/request-quote') ?>?service=<?= urlencode($service['title']) ?>" 
                           class="bg-secondary hover:bg-orange-600 text-white font-semibold px-4 py-3 rounded-lg transition-colors">
                            Quote
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Why Choose Our Services -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-6">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-800 mb-4">Why Choose Our Services?</h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                We combine technical expertise with business understanding to deliver solutions that work
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 max-w-6xl mx-auto">
            <div class="text-center">
                <div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800 mb-2">Quality Assured</h3>
                <p class="text-gray-600 text-sm">Rigorous testing and quality control in every project</p>
            </div>

            <div class="text-center">
                <div class="w-16 h-16 bg-secondary/10 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800 mb-2">On-Time Delivery</h3>
                <p class="text-gray-600 text-sm">Meeting deadlines with consistent project delivery</p>
            </div>

            <div class="text-center">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800 mb-2">24/7 Support</h3>
                <p class="text-gray-600 text-sm">Ongoing maintenance and technical support</p>
            </div>

            <div class="text-center">
                <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800 mb-2">Scalable Solutions</h3>
                <p class="text-gray-600 text-sm">Built to grow with your business needs</p>
            </div>
        </div>
    </div>
</section>

<!-- Process Section -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-6">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-800 mb-4">Our Process</h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                A proven methodology that ensures successful project delivery
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 max-w-6xl mx-auto">
            <div class="relative">
                <div class="text-center">
                    <div class="bg-primary text-white w-16 h-16 rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4">1</div>
                    <h3 class="text-xl font-bold mb-3 text-gray-800">Discovery</h3>
                    <p class="text-gray-600">Understanding your requirements and business goals</p>
                </div>
                <div class="hidden md:block absolute top-8 left-full w-full h-0.5 bg-gray-300" style="width: calc(100% - 4rem);"></div>
            </div>

            <div class="relative">
                <div class="text-center">
                    <div class="bg-secondary text-white w-16 h-16 rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4">2</div>
                    <h3 class="text-xl font-bold mb-3 text-gray-800">Planning</h3>
                    <p class="text-gray-600">Creating detailed project roadmap and timeline</p>
                </div>
                <div class="hidden md:block absolute top-8 left-full w-full h-0.5 bg-gray-300" style="width: calc(100% - 4rem);"></div>
            </div>

            <div class="relative">
                <div class="text-center">
                    <div class="bg-green-500 text-white w-16 h-16 rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4">3</div>
                    <h3 class="text-xl font-bold mb-3 text-gray-800">Development</h3>
                    <p class="text-gray-600">Building and testing your solution with regular updates</p>
                </div>
                <div class="hidden md:block absolute top-8 left-full w-full h-0.5 bg-gray-300" style="width: calc(100% - 4rem);"></div>
            </div>

            <div class="text-center">
                <div class="bg-purple-500 text-white w-16 h-16 rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4">4</div>
                <h3 class="text-xl font-bold mb-3 text-gray-800">Delivery</h3>
                <p class="text-gray-600">Deployment, training, and ongoing support</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-16 bg-primary text-white">
    <div class="container mx-auto px-6 text-center">
        <h2 class="text-4xl font-bold mb-4">Ready to Get Started?</h2>
        <p class="text-xl mb-8 text-gray-200 max-w-2xl mx-auto">
            Let's discuss your project requirements and create a solution that drives results.
        </p>
        <div class="flex flex-col sm:flex-row justify-center gap-4">
            <a href="<?= url('/request-quote') ?>" class="bg-secondary hover:bg-orange-600 text-white font-bold px-8 py-3 rounded-lg transition-colors">
                Request a Quote
            </a>
            <a href="<?= url('/contact') ?>" class="bg-white text-primary hover:bg-gray-100 font-bold px-8 py-3 rounded-lg transition-colors">
                Contact Us
            </a>
        </div>
    </div>
</section>

<?php 
$content = ob_get_clean();
include __DIR__ . '/../../layouts/main.php'; 
?>
