<?php 
$content = ob_start(); 
?>

<!-- Hero Section -->
<section class="bg-primary text-white py-24 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-10 left-10 w-72 h-72 bg-white rounded-full blur-3xl"></div>
        <div class="absolute bottom-10 right-10 w-96 h-96 bg-secondary rounded-full blur-3xl"></div>
    </div>
    <div class="container mx-auto px-6 relative z-10">
        <div class="max-w-4xl mx-auto text-center">
            <div class="inline-block bg-secondary/20 text-secondary px-4 py-2 rounded-full text-sm font-semibold mb-6">
                🚀 Trusted by 1000+ Businesses • Professional IT Solutions
            </div>
            <h1 class="text-5xl md:text-6xl font-bold mb-6 leading-tight">
                <?= htmlspecialchars($title) ?>
            </h1>
            <p class="text-xl md:text-2xl mb-4 text-gray-200">
                <?= htmlspecialchars($tagline) ?>
            </p>
            <p class="text-lg mb-8 text-gray-300 max-w-2xl mx-auto">
                From custom software development to professional IT training, we deliver cutting-edge technology solutions that drive business growth and empower individuals.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4 mb-8">
                <a href="<?= url('/services') ?>" class="bg-secondary hover:bg-orange-600 text-white font-bold text-lg px-10 py-4 rounded-lg transition-all transform hover:scale-105 shadow-lg">
                    Get Our Services
                </a>
                <a href="<?= url('/programmes') ?>" class="bg-white text-primary hover:bg-gray-100 font-semibold text-lg px-10 py-4 rounded-lg transition-colors border-2 border-white">
                    View Training Programs
                </a>
            </div>
            <div class="flex items-center justify-center gap-6 text-sm text-gray-300">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-secondary" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                    </svg>
                    <span><?= number_format($stats['students']) ?>+ Students Trained</span>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-secondary" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span><?= number_format($stats['projects']) ?>+ Projects Completed</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="py-12 bg-white border-b">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <div class="p-4">
                <div class="text-4xl font-bold text-primary mb-2"><?= number_format($stats['students']) ?>+</div>
                <div class="text-gray-600">Students Trained</div>
            </div>
            <div class="p-4">
                <div class="text-4xl font-bold text-primary mb-2"><?= number_format($stats['courses']) ?>+</div>
                <div class="text-gray-600">Training Programs</div>
            </div>
            <div class="p-4">
                <div class="text-4xl font-bold text-primary mb-2"><?= number_format($stats['projects']) ?>+</div>
                <div class="text-gray-600">Projects Completed</div>
            </div>
            <div class="p-4">
                <div class="text-4xl font-bold text-primary mb-2"><?= $stats['satisfaction'] ?>%</div>
                <div class="text-gray-600">Client Satisfaction</div>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Section -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-6">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-800 mb-4">Why Choose Nebatech?</h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">We combine innovation, expertise, and dedication to deliver exceptional results</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
            <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-3 text-gray-800">Innovation First</h3>
                <p class="text-gray-600">We stay ahead of technology trends to provide cutting-edge solutions that give you a competitive advantage.</p>
            </div>

            <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="w-16 h-16 bg-secondary/10 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-3 text-gray-800">Expert Team</h3>
                <p class="text-gray-600">Our skilled professionals bring years of experience and passion to every project we undertake.</p>
            </div>

            <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-3 text-gray-800">Results Driven</h3>
                <p class="text-gray-600">We focus on delivering measurable results that contribute to your business growth and success.</p>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-6">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-800 mb-4">Our IT Services</h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">Comprehensive technology solutions tailored to your business needs</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
            <?php foreach (array_slice($featuredServices, 0, 6) as $service): ?>
            <div class="bg-gray-50 p-6 rounded-xl hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center mb-4">
                    <span class="text-2xl"><?= $service['icon'] ?? '💻' ?></span>
                </div>
                <h3 class="text-xl font-bold mb-3 text-gray-800"><?= htmlspecialchars($service['title']) ?></h3>
                <p class="text-gray-600 mb-4"><?= htmlspecialchars($service['short_description']) ?></p>
                <a href="<?= url('/services/' . $service['slug']) ?>" class="text-primary font-semibold hover:text-blue-700 transition-colors">
                    Learn More →
                </a>
            </div>
            <?php endforeach; ?>
        </div>
        
        <div class="text-center mt-12">
            <a href="<?= url('/services') ?>" class="bg-primary hover:bg-blue-700 text-white font-bold px-8 py-3 rounded-lg transition-colors">
                View All Services
            </a>
        </div>
    </div>
</section>

<!-- Training Programs Section -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-6">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-800 mb-4">Training Programmes</h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">Competency-based training programs to advance your career</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
            <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-3 text-gray-800">AI & Machine Learning</h3>
                <p class="text-gray-600 mb-4">Master artificial intelligence and machine learning fundamentals with hands-on projects.</p>
                <div class="text-sm text-gray-500 mb-4">From GHS 400 • 3-20 weeks</div>
                <a href="<?= url('/programmes/category/ai-ml') ?>" class="text-primary font-semibold hover:text-blue-700 transition-colors">
                    Explore Programs →
                </a>
            </div>

            <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-3 text-gray-800">Software Development</h3>
                <p class="text-gray-600 mb-4">Learn frontend, backend, and full-stack development with modern technologies.</p>
                <div class="text-sm text-gray-500 mb-4">From GHS 3500 • 16-20 weeks</div>
                <a href="<?= url('/programmes/category/development') ?>" class="text-primary font-semibold hover:text-blue-700 transition-colors">
                    Explore Programs →
                </a>
            </div>

            <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300">
                <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM21 5a2 2 0 00-2-2h-4a2 2 0 00-2 2v12a4 4 0 004 4h4a2 2 0 002-2V5z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-3 text-gray-800">Design & Multimedia</h3>
                <p class="text-gray-600 mb-4">Create stunning graphics, videos, and digital content with professional tools.</p>
                <div class="text-sm text-gray-500 mb-4">From GHS 3200 • 8-12 weeks</div>
                <a href="<?= url('/programmes/category/design') ?>" class="text-primary font-semibold hover:text-blue-700 transition-colors">
                    Explore Programs →
                </a>
            </div>
        </div>
        
        <div class="text-center mt-12">
            <a href="<?= url('/programmes') ?>" class="bg-secondary hover:bg-orange-600 text-white font-bold px-8 py-3 rounded-lg transition-colors">
                View All Programs
            </a>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-6">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-800 mb-4">What Our Clients Say</h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">Don't just take our word for it - hear from our satisfied clients</p>
        </div>
        
        <?php if (!empty($testimonials) && is_array($testimonials)): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
            <?php foreach (array_slice($testimonials, 0, 6) as $testimonial): ?>
            <div class="bg-gray-50 p-6 rounded-xl">
                <div class="flex items-center mb-4">
                    <?php for ($i = 0; $i < 5; $i++): ?>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    <?php endfor; ?>
                </div>
                <p class="text-gray-600 mb-4 italic">"<?= htmlspecialchars($testimonial['content'] ?? $testimonial['message'] ?? 'Great service and excellent results!') ?>"</p>
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-primary rounded-full flex items-center justify-center text-white font-bold mr-3">
                        <?= strtoupper(substr($testimonial['client_name'] ?? $testimonial['name'] ?? 'C', 0, 1)) ?>
                    </div>
                    <div>
                        <div class="font-bold text-gray-800"><?= htmlspecialchars($testimonial['client_name'] ?? $testimonial['name'] ?? 'Satisfied Client') ?></div>
                        <div class="text-sm text-gray-500"><?= htmlspecialchars($testimonial['client_position'] ?? $testimonial['position'] ?? 'Client') ?></div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <!-- Fallback testimonials when no data is available -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
            <div class="bg-gray-50 p-6 rounded-xl">
                <div class="flex items-center mb-4">
                    <?php for ($i = 0; $i < 5; $i++): ?>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    <?php endfor; ?>
                </div>
                <p class="text-gray-600 mb-4 italic">"Nebatech delivered an excellent website for our business. Professional service and great results!"</p>
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-primary rounded-full flex items-center justify-center text-white font-bold mr-3">
                        A
                    </div>
                    <div>
                        <div class="font-bold text-gray-800">Ahmed Musah</div>
                        <div class="text-sm text-gray-500">Business Owner</div>
                    </div>
                </div>
            </div>
            
            <div class="bg-gray-50 p-6 rounded-xl">
                <div class="flex items-center mb-4">
                    <?php for ($i = 0; $i < 5; $i++): ?>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    <?php endfor; ?>
                </div>
                <p class="text-gray-600 mb-4 italic">"The training program was comprehensive and practical. I learned valuable skills that helped advance my career."</p>
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-primary rounded-full flex items-center justify-center text-white font-bold mr-3">
                        F
                    </div>
                    <div>
                        <div class="font-bold text-gray-800">Fatima Ibrahim</div>
                        <div class="text-sm text-gray-500">Graduate</div>
                    </div>
                </div>
            </div>
            
            <div class="bg-gray-50 p-6 rounded-xl">
                <div class="flex items-center mb-4">
                    <?php for ($i = 0; $i < 5; $i++): ?>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    <?php endfor; ?>
                </div>
                <p class="text-gray-600 mb-4 italic">"Outstanding technical support and innovative solutions. Nebatech exceeded our expectations in every way."</p>
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-primary rounded-full flex items-center justify-center text-white font-bold mr-3">
                        K
                    </div>
                    <div>
                        <div class="font-bold text-gray-800">Kwame Asante</div>
                        <div class="text-sm text-gray-500">IT Manager</div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- CTA Section -->
<section class="py-16 bg-primary text-white">
    <div class="container mx-auto px-6 text-center">
        <h2 class="text-4xl font-bold mb-4">Ready to Transform Your Business?</h2>
        <p class="text-xl mb-8 text-gray-200 max-w-2xl mx-auto">
            Let's discuss how our IT solutions and training programs can help you achieve your goals.
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
include __DIR__ . '/../layouts/main.php'; 
?>
