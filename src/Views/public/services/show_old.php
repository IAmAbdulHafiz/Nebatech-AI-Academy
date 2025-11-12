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
            <div class="max-w-4xl mx-auto">
                <div class="flex items-center gap-4 mb-4">
                    <a href="<?= url('/services') ?>" class="text-gray-200 hover:text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                    </a>
                    <h1 class="text-4xl md:text-5xl font-bold"><?= htmlspecialchars($service['title']) ?></h1>
                </div>
                <p class="text-xl text-gray-200"><?= htmlspecialchars($service['short_description']) ?></p>
            </div>
        </div>
    </section>

    <!-- Service Details -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6">
            <div class="max-w-4xl mx-auto">
                <div class="prose prose-lg max-w-none">
                    <?= $service['description'] ?>
                </div>

                <?php if (!empty($service['features'])): ?>
                <div class="mt-12">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6">Key Features</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <?php foreach ($service['features'] as $feature): ?>
                        <div class="flex items-start gap-3 bg-gray-50 p-4 rounded-lg">
                            <svg class="w-6 h-6 text-green-600 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span class="text-gray-700"><?= htmlspecialchars($feature) ?></span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <?php if (!empty($service['pricing_info'])): ?>
                <div class="mt-12 bg-blue-50 border-2 border-blue-200 rounded-xl p-8">
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Pricing Information</h3>
                    <p class="text-lg text-gray-700"><?= htmlspecialchars($service['pricing_info']) ?></p>
                    <p class="text-sm text-gray-600 mt-2">Contact us for a detailed quote tailored to your specific requirements.</p>
                </div>
                <?php endif; ?>

                <!-- CTA Buttons -->
                <div class="mt-12 flex flex-col sm:flex-row gap-4">
                    <a href="<?= url('/request-quote') ?>?service=<?= urlencode($service['slug']) ?>" 
                       class="bg-primary hover:bg-blue-700 text-white font-bold px-8 py-3 rounded-lg transition-colors text-center">
                        Request a Quote
                    </a>
                    <a href="<?= url('/contact') ?>" 
                       class="bg-secondary hover:bg-orange-600 text-white font-bold px-8 py-3 rounded-lg transition-colors text-center">
                        Contact Us
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Related Services -->
    <?php if (!empty($relatedServices)): ?>
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="max-w-6xl mx-auto">
                <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">Related Services</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <?php foreach ($relatedServices as $related): ?>
                    <div class="bg-white border-2 border-gray-100 rounded-xl p-6 hover:border-primary hover:shadow-xl transition-all">
                        <div class="text-4xl mb-3"><?= htmlspecialchars($related['icon'] ?? '💼') ?></div>
                        <h3 class="text-xl font-bold mb-2 text-gray-800"><?= htmlspecialchars($related['title']) ?></h3>
                        <p class="text-gray-600 text-sm mb-4"><?= htmlspecialchars(substr($related['short_description'], 0, 100)) ?>...</p>
                        <a href="<?= url('/services/' . $related['slug']) ?>" 
                           class="text-primary hover:text-blue-700 font-semibold inline-flex items-center">
                            Learn More 
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <?php include __DIR__ . '/../../partials/footer.php'; ?>
</body>
</html>
