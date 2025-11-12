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

    <!-- Category Filter -->
    <section class="py-8 bg-white border-b" x-data="{ activeCategory: '<?= $activeCategory ?? 'all' ?>' }">
        <div class="container mx-auto px-6">
            <div class="flex flex-wrap justify-center gap-3">
                <a href="<?= url('/programmes') ?>" 
                   :class="activeCategory === 'all' ? 'bg-primary text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'"
                   class="px-6 py-2 rounded-lg font-semibold transition-colors">
                    All Programmes
                </a>
                <a href="<?= url('/programmes/category/ai-ml') ?>" 
                   :class="activeCategory === 'ai-ml' ? 'bg-primary text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'"
                   class="px-6 py-2 rounded-lg font-semibold transition-colors">
                    AI & ML
                </a>
                <a href="<?= url('/programmes/category/development') ?>" 
                   :class="activeCategory === 'development' ? 'bg-primary text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'"
                   class="px-6 py-2 rounded-lg font-semibold transition-colors">
                    Development
                </a>
                <a href="<?= url('/programmes/category/design') ?>" 
                   :class="activeCategory === 'design' ? 'bg-primary text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'"
                   class="px-6 py-2 rounded-lg font-semibold transition-colors">
                    Design
                </a>
                <a href="<?= url('/programmes/category/business') ?>" 
                   :class="activeCategory === 'business' ? 'bg-primary text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'"
                   class="px-6 py-2 rounded-lg font-semibold transition-colors">
                    Business
                </a>
                <a href="<?= url('/programmes/category/hardware') ?>" 
                   :class="activeCategory === 'hardware' ? 'bg-primary text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'"
                   class="px-6 py-2 rounded-lg font-semibold transition-colors">
                    Hardware
                </a>
            </div>
        </div>
    </section>

    <!-- Programmes Grid -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-6">
            <?php if (empty($programmes)): ?>
                <div class="text-center py-12">
                    <p class="text-gray-600 text-lg">No programmes available in this category.</p>
                    <a href="<?= url('/programmes') ?>" class="text-primary hover:text-blue-700 font-semibold mt-4 inline-block">
                        View All Programmes
                    </a>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php foreach ($programmes as $programme): ?>
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-shadow">
                        <div class="h-48 bg-gradient-to-br from-primary to-blue-700 flex items-center justify-center text-white">
                            <div class="text-center">
                                <div class="text-5xl mb-2">📚</div>
                                <div class="text-sm font-semibold uppercase tracking-wide">Programme</div>
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold mb-2 text-gray-800"><?= htmlspecialchars($programme['title']) ?></h3>
                            <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                                <?= htmlspecialchars($programme['short_description'] ?? substr(strip_tags($programme['description']), 0, 120)) ?>...
                            </p>
                            
                            <div class="flex items-center justify-between mb-4 text-sm text-gray-600">
                                <div class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                    </svg>
                                    <span><?= number_format($programme['enrollment_count'] ?? 0) ?> enrolled</span>
                                </div>
                                <?php if (!empty($programme['first_name'])): ?>
                                <div class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    <span><?= htmlspecialchars($programme['first_name'] . ' ' . $programme['last_name']) ?></span>
                                </div>
                                <?php endif; ?>
                            </div>

                            <div class="border-t pt-4">
                                <a href="<?= url('/programmes/' . $programme['slug']) ?>" 
                                   class="block w-full bg-primary hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg transition-colors text-center">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Why Choose Our Programmes -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Why Choose Our Training Programmes?</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">Competency-based learning that prepares you for real-world success</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 max-w-6xl mx-auto">
                <div class="text-center">
                    <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold mb-2 text-gray-800">Hands-On Learning</h3>
                    <p class="text-gray-600 text-sm">Practical projects and real-world applications</p>
                </div>

                <div class="text-center">
                    <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold mb-2 text-gray-800">Certification</h3>
                    <p class="text-gray-600 text-sm">Industry-recognized certificates upon completion</p>
                </div>

                <div class="text-center">
                    <div class="bg-orange-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold mb-2 text-gray-800">Expert Instructors</h3>
                    <p class="text-gray-600 text-sm">Learn from experienced industry professionals</p>
                </div>

                <div class="text-center">
                    <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold mb-2 text-gray-800">Flexible Schedule</h3>
                    <p class="text-gray-600 text-sm">Learn at your own pace with flexible timing</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-gradient-to-r from-secondary to-orange-600 text-white">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-4xl font-bold mb-4">Ready to Start Learning?</h2>
            <p class="text-xl mb-8 max-w-2xl mx-auto">
                Join thousands of students who have transformed their careers with our training programmes.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="<?= url('/courses') ?>" class="bg-white text-secondary hover:bg-gray-100 font-bold px-8 py-3 rounded-lg transition-colors">
                        Browse Courses
                    </a>
                <?php else: ?>
                    <a href="<?= url('/register') ?>" class="bg-white text-secondary hover:bg-gray-100 font-bold px-8 py-3 rounded-lg transition-colors">
                        Create Free Account
                    </a>
                    <a href="<?= url('/login') ?>" class="bg-primary hover:bg-blue-700 text-white font-bold px-8 py-3 rounded-lg transition-colors">
                        Sign In
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <?php include __DIR__ . '/../../partials/footer.php'; ?>
</body>
</html>
