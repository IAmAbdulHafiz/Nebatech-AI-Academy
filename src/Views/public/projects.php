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
            <div class="inline-block bg-secondary/20 text-secondary px-4 py-2 rounded-full text-sm font-semibold mb-6">
                🚀 50+ Successful Projects • Trusted by Leading Businesses
            </div>
            <h1 class="text-5xl md:text-6xl font-bold mb-6 leading-tight">Our Projects</h1>
            <p class="text-xl md:text-2xl text-gray-200 max-w-2xl mx-auto">
                Discover the innovative technology solutions we have delivered for businesses across various industries
            </p>
        </div>
    </div>
</section>

<!-- Category Filter -->
<section class="py-8 bg-white border-b">
    <div class="container mx-auto px-6">
        <div class="flex flex-wrap justify-center gap-4" x-data="{ activeCategory: 'all' }">
            <button @click="activeCategory = 'all'" 
                    :class="activeCategory === 'all' ? 'bg-primary text-white shadow-lg' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                    class="px-6 py-3 rounded-full font-semibold transition-all duration-300">
                All Projects
            </button>
            <?php if (!empty($categories)): ?>
                <?php foreach ($categories as $category): ?>
                <button @click="activeCategory = '<?= htmlspecialchars($category['slug']) ?>'" 
                        :class="activeCategory === '<?= htmlspecialchars($category['slug']) ?>' ? 'bg-primary text-white shadow-lg' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                        class="px-6 py-3 rounded-full font-semibold transition-all duration-300">
                    <?= htmlspecialchars($category['name']) ?>
                </button>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Projects Grid -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-6">
        <?php if (!empty($projects)): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-7xl mx-auto">
            <?php foreach ($projects as $project): ?>
            <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 group"
                 x-show="activeCategory === 'all' || activeCategory === '<?= htmlspecialchars($project['category_slug'] ?? '') ?>'"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform scale-95"
                 x-transition:enter-end="opacity-100 transform scale-100">
                
                <!-- Project Image/Icon -->
                <div class="relative overflow-hidden rounded-t-xl">
                    <?php if (!empty($project['image_url'])): ?>
                    <img src="<?= htmlspecialchars($project['image_url']) ?>" 
                         alt="<?= htmlspecialchars($project['title']) ?>"
                         class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                    <?php else: ?>
                    <div class="w-full h-48 bg-gradient-to-br from-primary to-blue-700 flex items-center justify-center">
                        <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <?php endif; ?>
                    
                    <!-- Project Status Badge -->
                    <?php if ($project['is_featured']): ?>
                    <div class="absolute top-4 left-4">
                        <span class="bg-secondary text-white px-3 py-1 rounded-full text-xs font-semibold">
                            Featured
                        </span>
                    </div>
                    <?php endif; ?>
                    
                    <!-- Category Badge -->
                    <div class="absolute top-4 right-4">
                        <span class="bg-white/90 text-gray-800 px-3 py-1 rounded-full text-xs font-semibold">
                            <?= htmlspecialchars($project['category_name'] ?? 'Uncategorized') ?>
                        </span>
                    </div>
                </div>
                
                <!-- Project Content -->
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-3 group-hover:text-primary transition-colors">
                        <?= htmlspecialchars($project['title']) ?>
                    </h3>
                    
                    <p class="text-gray-600 mb-4 leading-relaxed">
                        <?= htmlspecialchars($project['short_description'] ?? substr(strip_tags($project['description']), 0, 120)) ?>...
                    </p>
                    
                    <!-- Client Info -->
                    <?php if (!empty($project['client_name'])): ?>
                    <div class="flex items-center mb-4">
                        <div class="w-8 h-8 bg-primary/10 rounded-full flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H3m2 0h4M9 7h6m-6 4h6m-6 4h6"/>
                            </svg>
                        </div>
                        <div>
                            <div class="font-semibold text-gray-800 text-sm"><?= htmlspecialchars($project['client_name']) ?></div>
                            <div class="text-xs text-gray-500">Client</div>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <!-- Technologies Used -->
                    <?php if (!empty($project['technologies_used'])): ?>
                        <?php $technologies = is_string($project['technologies_used']) ? json_decode($project['technologies_used'], true) : $project['technologies_used']; ?>
                        <?php if (is_array($technologies) && count($technologies) > 0): ?>
                        <div class="mb-4">
                            <div class="flex flex-wrap gap-2">
                                <?php foreach (array_slice($technologies, 0, 4) as $tech): ?>
                                <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs font-medium">
                                    <?= htmlspecialchars($tech) ?>
                                </span>
                                <?php endforeach; ?>
                                <?php if (count($technologies) > 4): ?>
                                <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs font-medium">
                                    +<?= count($technologies) - 4 ?> more
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endif; ?>
                    <?php endif; ?>
                    
                    <!-- Project Links -->
                    <div class="flex gap-3">
                        <?php if (!empty($project['demo_url'])): ?>
                        <a href="<?= htmlspecialchars($project['demo_url']) ?>" 
                           target="_blank" rel="noopener"
                           class="flex-1 bg-primary hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg transition-colors text-center text-sm">
                            View Demo
                        </a>
                        <?php endif; ?>
                        
                        <?php if (!empty($project['github_url'])): ?>
                        <a href="<?= htmlspecialchars($project['github_url']) ?>" 
                           target="_blank" rel="noopener"
                           class="bg-gray-800 hover:bg-gray-900 text-white font-semibold px-4 py-2 rounded-lg transition-colors text-sm">
                            <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 0C4.477 0 0 4.484 0 10.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0110 4.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.203 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.942.359.31.678.921.678 1.856 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0020 10.017C20 4.484 15.522 0 10 0z" clip-rule="evenodd"/>
                            </svg>
                            Code
                        </a>
                        <?php endif; ?>
                        
                        <?php if (empty($project['demo_url']) && empty($project['github_url'])): ?>
                        <a href="<?= url('/contact') ?>" 
                           class="flex-1 bg-secondary hover:bg-orange-600 text-white font-semibold px-4 py-2 rounded-lg transition-colors text-center text-sm">
                            Learn More
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="text-center py-16">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-800 mb-4">No Projects Available</h3>
            <p class="text-gray-600 mb-6">We're working on showcasing our latest projects. Check back soon!</p>
            <a href="<?= url('/contact') ?>" class="bg-primary hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg transition-colors">
                Discuss Your Project
            </a>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- Project Types Section -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-6">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-800 mb-4">Project Types We Excel At</h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                From web applications to mobile solutions, we deliver comprehensive technology projects
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
            <div class="bg-gray-50 p-8 rounded-xl hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                <div class="w-16 h-16 bg-blue-100 rounded-xl flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-4">Web Applications</h3>
                <p class="text-gray-600 mb-4">Custom web applications built with modern frameworks and technologies for optimal performance and user experience.</p>
                <ul class="space-y-2 text-sm text-gray-600">
                    <li class="flex items-center">
                        <span class="w-2 h-2 bg-blue-500 rounded-full mr-3"></span>
                        E-commerce Platforms
                    </li>
                    <li class="flex items-center">
                        <span class="w-2 h-2 bg-blue-500 rounded-full mr-3"></span>
                        Business Management Systems
                    </li>
                    <li class="flex items-center">
                        <span class="w-2 h-2 bg-blue-500 rounded-full mr-3"></span>
                        Learning Management Systems
                    </li>
                </ul>
            </div>

            <div class="bg-gray-50 p-8 rounded-xl hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                <div class="w-16 h-16 bg-green-100 rounded-xl flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-4">Mobile Applications</h3>
                <p class="text-gray-600 mb-4">Native and cross-platform mobile apps that provide seamless user experiences across all devices.</p>
                <ul class="space-y-2 text-sm text-gray-600">
                    <li class="flex items-center">
                        <span class="w-2 h-2 bg-green-500 rounded-full mr-3"></span>
                        iOS & Android Apps
                    </li>
                    <li class="flex items-center">
                        <span class="w-2 h-2 bg-green-500 rounded-full mr-3"></span>
                        Cross-Platform Solutions
                    </li>
                    <li class="flex items-center">
                        <span class="w-2 h-2 bg-green-500 rounded-full mr-3"></span>
                        Progressive Web Apps
                    </li>
                </ul>
            </div>

            <div class="bg-gray-50 p-8 rounded-xl hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                <div class="w-16 h-16 bg-purple-100 rounded-xl flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-4">Enterprise Systems</h3>
                <p class="text-gray-600 mb-4">Robust enterprise solutions that streamline business processes and improve operational efficiency.</p>
                <ul class="space-y-2 text-sm text-gray-600">
                    <li class="flex items-center">
                        <span class="w-2 h-2 bg-purple-500 rounded-full mr-3"></span>
                        POS & Inventory Systems
                    </li>
                    <li class="flex items-center">
                        <span class="w-2 h-2 bg-purple-500 rounded-full mr-3"></span>
                        CRM Solutions
                    </li>
                    <li class="flex items-center">
                        <span class="w-2 h-2 bg-purple-500 rounded-full mr-3"></span>
                        Custom Integrations
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Process Section -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-6">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-800 mb-4">Our Project Process</h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                A proven methodology that ensures successful project delivery every time
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-5 gap-8 max-w-6xl mx-auto">
            <div class="relative text-center">
                <div class="bg-primary text-white w-16 h-16 rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4">1</div>
                <h3 class="text-lg font-bold mb-2 text-gray-800">Discovery</h3>
                <p class="text-gray-600 text-sm">Understanding requirements and project scope</p>
                <div class="hidden md:block absolute top-8 left-full w-full h-0.5 bg-gray-300" style="width: calc(100% - 4rem);"></div>
            </div>

            <div class="relative text-center">
                <div class="bg-secondary text-white w-16 h-16 rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4">2</div>
                <h3 class="text-lg font-bold mb-2 text-gray-800">Design</h3>
                <p class="text-gray-600 text-sm">Creating wireframes and visual designs</p>
                <div class="hidden md:block absolute top-8 left-full w-full h-0.5 bg-gray-300" style="width: calc(100% - 4rem);"></div>
            </div>

            <div class="relative text-center">
                <div class="bg-green-500 text-white w-16 h-16 rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4">3</div>
                <h3 class="text-lg font-bold mb-2 text-gray-800">Development</h3>
                <p class="text-gray-600 text-sm">Building with modern technologies and best practices</p>
                <div class="hidden md:block absolute top-8 left-full w-full h-0.5 bg-gray-300" style="width: calc(100% - 4rem);"></div>
            </div>

            <div class="relative text-center">
                <div class="bg-purple-500 text-white w-16 h-16 rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4">4</div>
                <h3 class="text-lg font-bold mb-2 text-gray-800">Testing</h3>
                <p class="text-gray-600 text-sm">Rigorous testing for quality assurance</p>
                <div class="hidden md:block absolute top-8 left-full w-full h-0.5 bg-gray-300" style="width: calc(100% - 4rem);"></div>
            </div>

            <div class="text-center">
                <div class="bg-indigo-500 text-white w-16 h-16 rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4">5</div>
                <h3 class="text-lg font-bold mb-2 text-gray-800">Launch</h3>
                <p class="text-gray-600 text-sm">Deployment and ongoing support</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-16 bg-primary text-white">
    <div class="container mx-auto px-6 text-center">
        <h2 class="text-4xl font-bold mb-4">Ready to Start Your Project?</h2>
        <p class="text-xl mb-8 text-gray-200 max-w-2xl mx-auto">
            Let's discuss your project requirements and create a solution that exceeds your expectations.
        </p>
        <div class="flex flex-col sm:flex-row justify-center gap-4">
            <a href="<?= url('/request-quote') ?>" class="bg-secondary hover:bg-orange-600 text-white font-bold px-8 py-3 rounded-lg transition-colors">
                Start Your Project
            </a>
            <a href="<?= url('/contact') ?>" class="bg-white text-primary hover:bg-gray-100 font-bold px-8 py-3 rounded-lg transition-colors">
                Schedule Consultation
            </a>
        </div>
    </div>
</section>

<?php 
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php'; 
?>
