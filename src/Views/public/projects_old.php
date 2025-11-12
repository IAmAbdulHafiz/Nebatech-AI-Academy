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
    <?php include __DIR__ . '/../partials/header.php'; ?>
    
    <!-- Page Header -->
    <section class="bg-gradient-to-r from-primary to-blue-700 text-white py-16">
        <div class="container mx-auto px-6">
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="text-5xl font-bold mb-4"><?= htmlspecialchars($title) ?></h1>
                <p class="text-xl text-gray-200"><?= htmlspecialchars($description) ?></p>
            </div>
        </div>
    </section>

    <!-- Category Filter -->
    <?php if (!empty($categories)): ?>
    <section class="py-8 bg-white border-b" x-data="{ activeCategory: 'all' }">
        <div class="container mx-auto px-6">
            <div class="flex flex-wrap justify-center gap-3">
                <button @click="activeCategory = 'all'" 
                        :class="activeCategory === 'all' ? 'bg-primary text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'"
                        class="px-6 py-2 rounded-lg font-semibold transition-colors">
                    All Projects
                </button>
                <?php foreach ($categories as $category): ?>
                <button @click="activeCategory = '<?= htmlspecialchars($category) ?>'" 
                        :class="activeCategory === '<?= htmlspecialchars($category) ?>' ? 'bg-primary text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'"
                        class="px-6 py-2 rounded-lg font-semibold transition-colors">
                    <?= htmlspecialchars($category) ?>
                </button>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Projects Grid -->
    <section class="py-16 bg-gray-50" x-data="{ activeCategory: 'all' }">
        <div class="container mx-auto px-6">
            <?php if (empty($projects)): ?>
                <div class="text-center py-12">
                    <p class="text-gray-600 text-lg">No projects available at the moment.</p>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php foreach ($projects as $project): ?>
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-shadow"
                         x-show="activeCategory === 'all' || activeCategory === '<?= htmlspecialchars($project['category_slug'] ?? '') ?>'"
                         x-transition
                         data-category="<?= htmlspecialchars($project['category_slug'] ?? '') ?>">
                        <div class="h-48 bg-gradient-to-br from-primary to-blue-700 flex items-center justify-center text-white">
                            <div class="text-center p-6">
                                <div class="text-5xl mb-2">🚀</div>
                                <?php if ($project['is_featured']): ?>
                                    <span class="inline-block bg-secondary text-white text-xs font-bold px-3 py-1 rounded-full">
                                        Featured
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="p-6">
                            <?php if (!empty($project['category_name'])): ?>
                                <span class="inline-block bg-blue-100 text-primary text-xs font-semibold px-3 py-1 rounded-full mb-3">
                                    <?= htmlspecialchars($project['category_name']) ?>
                                </span>
                            <?php endif; ?>
                            
                            <h3 class="text-xl font-bold mb-2 text-gray-800"><?= htmlspecialchars($project['title']) ?></h3>
                            
                            <?php if (!empty($project['client_name'])): ?>
                                <p class="text-sm text-gray-600 mb-2">
                                    <span class="font-semibold">Client:</span> <?= htmlspecialchars($project['client_name']) ?>
                                </p>
                            <?php endif; ?>
                            
                            <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                                <?= htmlspecialchars($project['description']) ?>
                            </p>
                            
                            <?php if (!empty($project['technologies'])): ?>
                                <?php $technologies = json_decode($project['technologies'], true); ?>
                                <?php if (is_array($technologies)): ?>
                                    <div class="flex flex-wrap gap-2 mb-4">
                                        <?php foreach (array_slice($technologies, 0, 3) as $tech): ?>
                                            <span class="text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded">
                                                <?= htmlspecialchars($tech) ?>
                                            </span>
                                        <?php endforeach; ?>
                                        <?php if (count($technologies) > 3): ?>
                                            <span class="text-xs text-gray-500">+<?= count($technologies) - 3 ?> more</span>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                            
                            <?php if (!empty($project['completion_date'])): ?>
                                <p class="text-xs text-gray-500">
                                    Completed: <?= date('F Y', strtotime($project['completion_date'])) ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Project Types Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Types of Projects We Deliver</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">Comprehensive solutions across multiple domains</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
                <div class="bg-gray-50 p-6 rounded-xl border-2 border-gray-100">
                    <div class="text-4xl mb-3">🌐</div>
                    <h3 class="text-xl font-bold mb-2 text-gray-800">Website Development</h3>
                    <p class="text-gray-600 text-sm">Corporate websites, e-commerce platforms, and custom web applications</p>
                </div>

                <div class="bg-gray-50 p-6 rounded-xl border-2 border-gray-100">
                    <div class="text-4xl mb-3">📱</div>
                    <h3 class="text-xl font-bold mb-2 text-gray-800">Mobile Applications</h3>
                    <p class="text-gray-600 text-sm">Android and iOS apps with seamless user experiences</p>
                </div>

                <div class="bg-gray-50 p-6 rounded-xl border-2 border-gray-100">
                    <div class="text-4xl mb-3">💳</div>
                    <h3 class="text-xl font-bold mb-2 text-gray-800">POS Systems</h3>
                    <p class="text-gray-600 text-sm">Custom point of sale solutions for retail and service businesses</p>
                </div>

                <div class="bg-gray-50 p-6 rounded-xl border-2 border-gray-100">
                    <div class="text-4xl mb-3">📦</div>
                    <h3 class="text-xl font-bold mb-2 text-gray-800">Inventory Management</h3>
                    <p class="text-gray-600 text-sm">Real-time stock tracking and management systems</p>
                </div>

                <div class="bg-gray-50 p-6 rounded-xl border-2 border-gray-100">
                    <div class="text-4xl mb-3">🔌</div>
                    <h3 class="text-xl font-bold mb-2 text-gray-800">Network Infrastructure</h3>
                    <p class="text-gray-600 text-sm">Complete network setup and security implementations</p>
                </div>

                <div class="bg-gray-50 p-6 rounded-xl border-2 border-gray-100">
                    <div class="text-4xl mb-3">🤖</div>
                    <h3 class="text-xl font-bold mb-2 text-gray-800">AI Solutions</h3>
                    <p class="text-gray-600 text-sm">Intelligent systems for business automation and insights</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-gradient-to-r from-primary to-blue-700 text-white">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-4xl font-bold mb-4">Have a Project in Mind?</h2>
            <p class="text-xl mb-8 max-w-2xl mx-auto">
                Let's turn your ideas into reality. Contact us to discuss your project requirements.
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

    <?php include __DIR__ . '/../partials/footer.php'; ?>
</body>
</html>
