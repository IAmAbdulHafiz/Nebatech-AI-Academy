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
                🎓 Competency-Based Learning • Industry-Recognized Certificates
            </div>
            <h1 class="text-5xl md:text-6xl font-bold mb-6 leading-tight">Training Programmes</h1>
            <p class="text-xl md:text-2xl text-gray-200 max-w-2xl mx-auto">
                Enhance your skills with our specialized training programs and advance your career today
            </p>
        </div>
    </div>
</section>

<!-- Category Filter -->
<section class="py-8 bg-white border-b">
    <div class="container mx-auto px-6">
        <div class="flex flex-wrap justify-center gap-4" x-data="{ activeCategory: '<?= $selectedCategory ?? 'all' ?>' }">
            <?php foreach ($categories as $key => $label): ?>
            <a href="<?= $key === 'all' ? url('/programmes') : url('/programmes/category/' . $key) ?>" 
               class="px-6 py-3 rounded-full font-semibold transition-all duration-300 <?= ($selectedCategory ?? 'all') === $key ? 'bg-primary text-white shadow-lg' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' ?>">
                <?= htmlspecialchars($label) ?>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Programs Grid -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-6">
        <?php if (!empty($programmes)): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-7xl mx-auto">
            <?php foreach ($programmes as $programme): ?>
            <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 group">
                <!-- Program Header -->
                <div class="p-6 pb-4">
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center group-hover:bg-primary/20 transition-colors">
                            <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        <?php if (!empty($programme['difficulty_level'])): ?>
                        <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">
                            <?= htmlspecialchars($programme['difficulty_level']) ?>
                        </span>
                        <?php endif; ?>
                    </div>
                    
                    <h3 class="text-xl font-bold text-gray-800 mb-3 group-hover:text-primary transition-colors">
                        <?= htmlspecialchars($programme['title']) ?>
                    </h3>
                    
                    <p class="text-gray-600 mb-4 leading-relaxed">
                        <?= htmlspecialchars($programme['short_description'] ?? substr(strip_tags($programme['description']), 0, 120)) ?>...
                    </p>
                </div>
                
                <!-- Program Stats -->
                <div class="px-6 pb-4">
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div class="flex items-center text-gray-600">
                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <?= htmlspecialchars($programme['duration'] ?? '12 weeks') ?>
                        </div>
                        <div class="flex items-center text-gray-600">
                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            <?= number_format($programme['enrollment_count'] ?? 0) ?> enrolled
                        </div>
                    </div>
                </div>
                
                <!-- Program Footer -->
                <div class="px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <?php if (!empty($programme['price'])): ?>
                            <div class="text-2xl font-bold text-primary">
                                GHS <?= number_format($programme['price']) ?>
                            </div>
                            <?php endif; ?>
                            <div class="text-sm text-gray-500">
                                <?php if (!empty($programme['first_name']) && !empty($programme['last_name'])): ?>
                                by <?= htmlspecialchars($programme['first_name'] . ' ' . $programme['last_name']) ?>
                                <?php endif; ?>
                            </div>
                        </div>
                        <a href="<?= url('/programmes/' . $programme['slug']) ?>" 
                           class="bg-primary hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg transition-colors flex-shrink-0">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="text-center py-16">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-800 mb-4">No Programs Available</h3>
            <p class="text-gray-600 mb-6">We're working on adding more training programs. Check back soon!</p>
            <a href="<?= url('/contact') ?>" class="bg-primary hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg transition-colors">
                Contact Us for Updates
            </a>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- Why Choose Our Programs -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-6">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-800 mb-4">Why Choose Our Training Programs?</h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Competency-based learning designed for real-world application
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 max-w-6xl mx-auto">
            <div class="text-center">
                <div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800 mb-2">Hands-On Learning</h3>
                <p class="text-gray-600 text-sm">Practical projects and real-world applications</p>
            </div>

            <div class="text-center">
                <div class="w-16 h-16 bg-secondary/10 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800 mb-2">Certified Programs</h3>
                <p class="text-gray-600 text-sm">Industry-recognized certificates upon completion</p>
            </div>

            <div class="text-center">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800 mb-2">Expert Instructors</h3>
                <p class="text-gray-600 text-sm">Learn from industry professionals</p>
            </div>

            <div class="text-center">
                <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800 mb-2">Career Support</h3>
                <p class="text-gray-600 text-sm">Job placement assistance and career guidance</p>
            </div>
        </div>
    </div>
</section>

<!-- Learning Path -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-6">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-800 mb-4">Your Learning Journey</h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                A structured approach to skill development and career advancement
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 max-w-6xl mx-auto">
            <div class="relative">
                <div class="text-center">
                    <div class="bg-primary text-white w-16 h-16 rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4">1</div>
                    <h3 class="text-xl font-bold mb-3 text-gray-800">Choose Program</h3>
                    <p class="text-gray-600">Select the training program that matches your career goals</p>
                </div>
                <div class="hidden md:block absolute top-8 left-full w-full h-0.5 bg-gray-300" style="width: calc(100% - 4rem);"></div>
            </div>

            <div class="relative">
                <div class="text-center">
                    <div class="bg-secondary text-white w-16 h-16 rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4">2</div>
                    <h3 class="text-xl font-bold mb-3 text-gray-800">Learn & Practice</h3>
                    <p class="text-gray-600">Engage in hands-on learning with real-world projects</p>
                </div>
                <div class="hidden md:block absolute top-8 left-full w-full h-0.5 bg-gray-300" style="width: calc(100% - 4rem);"></div>
            </div>

            <div class="relative">
                <div class="text-center">
                    <div class="bg-green-500 text-white w-16 h-16 rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4">3</div>
                    <h3 class="text-xl font-bold mb-3 text-gray-800">Build Portfolio</h3>
                    <p class="text-gray-600">Create impressive projects to showcase your skills</p>
                </div>
                <div class="hidden md:block absolute top-8 left-full w-full h-0.5 bg-gray-300" style="width: calc(100% - 4rem);"></div>
            </div>

            <div class="text-center">
                <div class="bg-purple-500 text-white w-16 h-16 rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4">4</div>
                <h3 class="text-xl font-bold mb-3 text-gray-800">Get Certified</h3>
                <p class="text-gray-600">Earn industry-recognized certification and advance your career</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-16 bg-primary text-white">
    <div class="container mx-auto px-6 text-center">
        <h2 class="text-4xl font-bold mb-4">Ready to Start Learning?</h2>
        <p class="text-xl mb-8 text-gray-200 max-w-2xl mx-auto">
            Join thousands of students who have transformed their careers with our training programs.
        </p>
        <div class="flex flex-col sm:flex-row justify-center gap-4">
            <a href="<?= url('/register') ?>" class="bg-secondary hover:bg-orange-600 text-white font-bold px-8 py-3 rounded-lg transition-colors">
                Enroll Now
            </a>
            <a href="<?= url('/contact') ?>" class="bg-white text-primary hover:bg-gray-100 font-bold px-8 py-3 rounded-lg transition-colors">
                Get More Info
            </a>
        </div>
    </div>
</section>

<?php 
$content = ob_get_clean();
include __DIR__ . '/../../layouts/main.php'; 
?>
