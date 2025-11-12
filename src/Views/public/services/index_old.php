<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?> - Nebatech</title>
    <meta name="description" content="<?= htmlspecialchars($description) ?>">
    <link href="<?= asset('css/main.css') ?>" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50">
    <?php include __DIR__ . '/../../partials/header.php'; ?>
    
    <!-- Page Header -->
    <section class="bg-gradient-to-r from-primary to-blue-700 text-white py-16">
        <div class="container mx-auto px-6">
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="text-5xl font-bold mb-4"><?= htmlspecialchars($title) ?></h1>
                <p class="text-xl text-gray-200"><?= htmlspecialchars($description) ?></p>
            </div>
        </div>
    </section>

    <!-- Services Grid -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6">
            <?php if (empty($services)): ?>
                <div class="text-center py-12">
                    <p class="text-gray-600 text-lg">No services available at the moment.</p>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php foreach ($services as $service): ?>
                    <div class="bg-white border-2 border-gray-100 rounded-xl p-6 hover:border-primary hover:shadow-xl transition-all">
                        <div class="text-5xl mb-4"><?= htmlspecialchars($service['icon'] ?? '💼') ?></div>
                        <h3 class="text-2xl font-bold mb-3 text-gray-800"><?= htmlspecialchars($service['title']) ?></h3>
                        <p class="text-gray-600 mb-4"><?= htmlspecialchars($service['short_description']) ?></p>
                        
                        <?php if (!empty($service['pricing_info'])): ?>
                            <div class="text-sm text-primary font-semibold mb-4">
                                💰 <?= htmlspecialchars($service['pricing_info']) ?>
                            </div>
                        <?php endif; ?>
                        
                        <a href="<?= url('/services/' . $service['slug']) ?>" 
                           class="inline-block bg-primary hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg transition-colors">
                            Learn More
                        </a>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Why Choose Our Services -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Why Choose Our Services?</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">Professional, reliable, and innovative IT solutions</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 max-w-6xl mx-auto">
                <div class="text-center">
                    <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold mb-2 text-gray-800">Quality Assured</h3>
                    <p class="text-gray-600 text-sm">High-quality solutions that meet industry standards</p>
                </div>

                <div class="text-center">
                    <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold mb-2 text-gray-800">Timely Delivery</h3>
                    <p class="text-gray-600 text-sm">Projects completed on time, every time</p>
                </div>

                <div class="text-center">
                    <div class="bg-orange-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold mb-2 text-gray-800">24/7 Support</h3>
                    <p class="text-gray-600 text-sm">Round-the-clock support for your peace of mind</p>
                </div>

                <div class="text-center">
                    <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold mb-2 text-gray-800">Affordable Pricing</h3>
                    <p class="text-gray-600 text-sm">Competitive rates without compromising quality</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-gradient-to-r from-primary to-blue-700 text-white">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-4xl font-bold mb-4">Ready to Get Started?</h2>
            <p class="text-xl mb-8 max-w-2xl mx-auto">
                Let's discuss your project requirements and provide you with a custom solution.
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

    <?php include __DIR__ . '/../../partials/footer.php'; ?>
</body>
</html>
