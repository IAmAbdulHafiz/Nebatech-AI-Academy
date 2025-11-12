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
    </section>

    <!-- Services Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Our IT Services</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">Comprehensive technology solutions tailored to your business needs</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach (array_slice($featuredServices, 0, 6) as $service): ?>
                <div class="bg-gray-50 p-6 rounded-xl border-2 border-gray-100 hover:border-primary hover:shadow-xl transition-all">
                    <div class="text-5xl mb-4"><?= htmlspecialchars($service['icon'] ?? '💼') ?></div>
                    <h3 class="text-xl font-bold mb-3 text-gray-800"><?= htmlspecialchars($service['title']) ?></h3>
                    <p class="text-gray-600 mb-4"><?= htmlspecialchars($service['short_description']) ?></p>
                    <a href="<?= url('/services/' . $service['slug']) ?>" class="text-primary hover:text-blue-700 font-semibold inline-flex items-center">
                        Learn More 
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>

            <div class="text-center mt-12">
                <a href="<?= url('/services') ?>" class="inline-block bg-primary text-white font-bold px-8 py-3 rounded-lg hover:bg-blue-700 transition-colors">
                    View All Services
                </a>
            </div>
        </div>
    </section>

    <!-- Training Programmes Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Training Programmes</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">Enhance your skills with our competency-based training programs</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-2xl transition-shadow">
                    <div class="text-4xl mb-4">🤖</div>
                    <h3 class="text-xl font-bold mb-2 text-gray-800">AI & Machine Learning</h3>
                    <p class="text-gray-600 mb-4">Introduction to AI and Basic ML courses to get you started in artificial intelligence.</p>
                    <div class="text-sm text-gray-500 mb-4">From GHS 400 • 3-5 weeks</div>
                    <a href="<?= url('/programmes?category=ai-ml') ?>" class="text-primary hover:text-blue-700 font-semibold">View Courses →</a>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-2xl transition-shadow">
                    <div class="text-4xl mb-4">💻</div>
                    <h3 class="text-xl font-bold mb-2 text-gray-800">Software Development</h3>
                    <p class="text-gray-600 mb-4">Front-End, Back-End, and Database Management training for aspiring developers.</p>
                    <div class="text-sm text-gray-500 mb-4">From GHS 3,500 • 16-20 weeks</div>
                    <a href="<?= url('/programmes?category=development') ?>" class="text-primary hover:text-blue-700 font-semibold">View Courses →</a>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-2xl transition-shadow">
                    <div class="text-4xl mb-4">🎨</div>
                    <h3 class="text-xl font-bold mb-2 text-gray-800">Design & Multimedia</h3>
                    <p class="text-gray-600 mb-4">Graphic Design and Video Editing courses to unleash your creativity.</p>
                    <div class="text-sm text-gray-500 mb-4">From GHS 3,200 • 12 weeks</div>
                    <a href="<?= url('/programmes?category=design') ?>" class="text-primary hover:text-blue-700 font-semibold">View Courses →</a>
                </div>
            </div>

            <div class="text-center mt-12">
                <a href="<?= url('/programmes') ?>" class="inline-block bg-secondary text-white font-bold px-8 py-3 rounded-lg hover:bg-orange-600 transition-colors">
                    View All Programmes
                </a>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <?php if (!empty($testimonials)): ?>
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">What Our Clients Say</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">Trusted by businesses and individuals across Ghana</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach (array_slice($testimonials, 0, 6) as $testimonial): ?>
                <div class="bg-gray-50 p-6 rounded-xl border-2 border-gray-100">
                    <div class="flex items-center mb-4">
                        <?php for ($i = 0; $i < 5; $i++): ?>
                            <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        <?php endfor; ?>
                    </div>
                    <p class="text-gray-700 mb-4 italic">"<?= htmlspecialchars($testimonial['testimonial']) ?>"</p>
                    <div class="border-t pt-4">
                        <p class="font-bold text-gray-800"><?= htmlspecialchars($testimonial['client_name']) ?></p>
                        <?php if (!empty($testimonial['client_title'])): ?>
                            <p class="text-sm text-gray-600"><?= htmlspecialchars($testimonial['client_title']) ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- CTA Section -->
    <section class="py-16 bg-gradient-to-r from-primary to-blue-700 text-white">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-4xl font-bold mb-4">Ready to Get Started?</h2>
            <p class="text-xl mb-8 max-w-2xl mx-auto">
                Whether you need IT services or want to enhance your skills, we're here to help you succeed.
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
