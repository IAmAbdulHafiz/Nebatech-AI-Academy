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
                    <li><a href="<?= url('/programmes') ?>" class="hover:text-white transition-colors">Programmes</a></li>
                    <li><span class="mx-2">/</span></li>
                    <li class="text-secondary"><?= htmlspecialchars($programme['title']) ?></li>
                </ol>
            </nav>
            
            <h1 class="text-4xl md:text-5xl font-bold mb-6 leading-tight">
                <?= htmlspecialchars($programme['title']) ?>
            </h1>
            <p class="text-xl text-gray-200 max-w-2xl mx-auto">
                <?= htmlspecialchars($programme['short_description'] ?? substr(strip_tags($programme['description']), 0, 160)) ?>
            </p>
        </div>
    </div>
</section>

<!-- Programme Details -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-6">
        <div class="max-w-6xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                <!-- Main Content -->
                <div class="lg:col-span-2">
                    <div class="prose prose-lg max-w-none">
                        <?= $programme['description'] ?>
                    </div>
                    
                    <!-- Course Modules -->
                    <?php if (!empty($modules)): ?>
                    <div class="mt-12">
                        <h3 class="text-2xl font-bold text-gray-800 mb-6">Course Curriculum</h3>
                        <div class="space-y-4">
                            <?php foreach ($modules as $index => $module): ?>
                            <div class="border border-gray-200 rounded-lg">
                                <div class="p-6">
                                    <div class="flex items-center justify-between mb-3">
                                        <h4 class="text-lg font-bold text-gray-800">
                                            Module <?= $index + 1 ?>: <?= htmlspecialchars($module['title']) ?>
                                        </h4>
                                        <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm">
                                            <?= $module['lesson_count'] ?? 0 ?> lessons
                                        </span>
                                    </div>
                                    <p class="text-gray-600"><?= htmlspecialchars($module['description']) ?></p>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
                
                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <div class="bg-gray-50 rounded-xl p-8 sticky top-8">
                        <!-- Programme Stats -->
                        <div class="mb-6">
                            <div class="grid grid-cols-2 gap-4 text-center">
                                <div>
                                    <div class="text-2xl font-bold text-primary"><?= htmlspecialchars($programme['duration'] ?? '12 weeks') ?></div>
                                    <div class="text-sm text-gray-600">Duration</div>
                                </div>
                                <div>
                                    <div class="text-2xl font-bold text-primary"><?= number_format($programme['enrollment_count'] ?? 0) ?></div>
                                    <div class="text-sm text-gray-600">Enrolled</div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Pricing -->
                        <?php if (!empty($programme['price'])): ?>
                        <div class="mb-6">
                            <h4 class="text-lg font-bold text-gray-800 mb-2">Programme Fee</h4>
                            <div class="text-3xl font-bold text-primary mb-2">
                                GHS <?= number_format($programme['price']) ?>
                            </div>
                            <p class="text-sm text-gray-600">One-time payment • Certificate included</p>
                        </div>
                        <?php endif; ?>
                        
                        <!-- Instructor -->
                        <?php if (!empty($programme['first_name']) && !empty($programme['last_name'])): ?>
                        <div class="mb-6">
                            <h4 class="text-lg font-bold text-gray-800 mb-3">Instructor</h4>
                            <div class="flex items-center space-x-3">
                                <div class="w-12 h-12 bg-primary rounded-full flex items-center justify-center text-white font-bold">
                                    <?= strtoupper(substr($programme['first_name'], 0, 1) . substr($programme['last_name'], 0, 1)) ?>
                                </div>
                                <div>
                                    <div class="font-semibold text-gray-800">
                                        <?= htmlspecialchars($programme['first_name'] . ' ' . $programme['last_name']) ?>
                                    </div>
                                    <div class="text-sm text-gray-600">Expert Instructor</div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <!-- Enrollment Status -->
                        <?php if (isset($isEnrolled) && $isEnrolled): ?>
                        <div class="mb-6 p-4 bg-green-100 border border-green-300 rounded-lg">
                            <div class="flex items-center text-green-800">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span class="font-semibold">Already Enrolled</span>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <!-- CTA Buttons -->
                        <div class="space-y-3">
                            <?php if (!isset($isEnrolled) || !$isEnrolled): ?>
                            <a href="<?= url('/programmes/' . $programme['id'] . '/enroll') ?>" 
                               class="w-full bg-secondary hover:bg-orange-600 text-white font-bold py-3 px-6 rounded-lg transition-colors text-center block">
                                Enroll Now
                            </a>
                            <?php else: ?>
                            <a href="<?= url('/dashboard') ?>" 
                               class="w-full bg-primary hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition-colors text-center block">
                                Continue Learning
                            </a>
                            <?php endif; ?>
                            
                            <a href="<?= url('/contact') ?>" 
                               class="w-full bg-white border-2 border-primary text-primary hover:bg-primary hover:text-white font-semibold py-3 px-6 rounded-lg transition-colors text-center block">
                                Ask Questions
                            </a>
                        </div>
                        
                        <!-- Programme Features -->
                        <div class="mt-8 pt-8 border-t border-gray-200">
                            <h4 class="text-lg font-bold text-gray-800 mb-4">What You'll Get</h4>
                            <div class="space-y-3 text-sm">
                                <div class="flex items-center space-x-3">
                                    <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="text-gray-700">Hands-on Projects</span>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="text-gray-700">Industry Certificate</span>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="text-gray-700">Expert Support</span>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="text-gray-700">Lifetime Access</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Programmes -->
<?php if (!empty($relatedProgrammes)): ?>
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-6">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-800 mb-4">Related Programmes</h2>
            <p class="text-lg text-gray-600">Explore other training programs that might interest you</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
            <?php foreach ($relatedProgrammes as $relatedProgramme): ?>
            <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-3">
                        <?= htmlspecialchars($relatedProgramme['title']) ?>
                    </h3>
                    <p class="text-gray-600 mb-4 text-sm">
                        <?= htmlspecialchars(substr($relatedProgramme['short_description'] ?? strip_tags($relatedProgramme['description']), 0, 100)) ?>...
                    </p>
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-500">
                            <?= htmlspecialchars($relatedProgramme['duration'] ?? '12 weeks') ?>
                        </div>
                        <a href="<?= url('/programmes/' . $relatedProgramme['slug']) ?>" 
                           class="text-primary font-semibold hover:text-blue-700 transition-colors text-sm">
                            Learn More →
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- CTA Section -->
<section class="py-16 bg-primary text-white">
    <div class="container mx-auto px-6 text-center">
        <h2 class="text-3xl font-bold mb-4">Ready to Start Learning?</h2>
        <p class="text-lg mb-8 text-gray-200 max-w-2xl mx-auto">
            Join thousands of students who have transformed their careers with our training programs.
        </p>
        <div class="flex flex-col sm:flex-row justify-center gap-4">
            <?php if (!isset($isEnrolled) || !$isEnrolled): ?>
            <a href="<?= url('/programmes/' . $programme['id'] . '/enroll') ?>" 
               class="bg-secondary hover:bg-orange-600 text-white font-bold px-8 py-3 rounded-lg transition-colors">
                Enroll in This Programme
            </a>
            <?php endif; ?>
            <a href="<?= url('/programmes') ?>" 
               class="bg-white text-primary hover:bg-gray-100 font-bold px-8 py-3 rounded-lg transition-colors">
                View All Programmes
            </a>
        </div>
    </div>
</section>

<?php 
$content = ob_get_clean();
include __DIR__ . '/../../layouts/main.php'; 
?>
