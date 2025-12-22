<section class="relative bg-gradient-to-br from-primary via-blue-700 to-blue-900 text-white py-20 overflow-hidden mb-16">
    <!-- Digital Horizon Background -->
    <div class="absolute inset-0 overflow-hidden">
        <!-- Horizon Glow Effect -->
        <div class="absolute bottom-0 left-0 right-0 h-96 bg-gradient-to-t from-secondary/30 via-secondary/10 to-transparent"></div>
        <div class="absolute top-0 left-0 right-0 h-96 bg-gradient-to-b from-primary/50 via-transparent to-transparent"></div>
        
        <!-- Geometric Light Beams -->
        <div class="absolute inset-0">
            <div class="absolute top-0 left-1/4 w-1 h-full bg-gradient-to-b from-secondary/40 via-secondary/20 to-transparent transform -skew-x-12 animate-pulse" style="animation-duration: 3s;"></div>
            <div class="absolute top-0 right-1/3 w-1 h-full bg-gradient-to-b from-blue-400/30 via-blue-400/10 to-transparent transform skew-x-12 animate-pulse" style="animation-duration: 4s; animation-delay: 1s;"></div>
            <div class="absolute top-0 left-2/3 w-0.5 h-full bg-gradient-to-b from-secondary/30 via-transparent to-transparent transform -skew-x-6 animate-pulse" style="animation-duration: 5s; animation-delay: 2s;"></div>
        </div>
        
        <!-- Dynamic Glowing Orbs -->
        <div class="absolute top-20 left-10 w-96 h-96 bg-primary/40 rounded-full blur-3xl animate-pulse" style="animation-duration: 6s;"></div>
        <div class="absolute bottom-10 right-10 w-[500px] h-[500px] bg-secondary/30 rounded-full blur-3xl animate-pulse" style="animation-duration: 8s; animation-delay: 1s;"></div>
        <div class="absolute top-1/3 right-1/4 w-64 h-64 bg-primary/20 rounded-full blur-2xl animate-pulse" style="animation-duration: 7s; animation-delay: 2s;"></div>
        
        <!-- Floating Tech Icons -->
        <div class="absolute top-1/4 left-[8%] opacity-20 animate-float" style="animation-duration: 6s;">
            <i class="fas fa-code text-6xl text-white/80"></i>
        </div>
        <div class="absolute top-1/3 right-[10%] opacity-20 animate-float" style="animation-duration: 7s; animation-delay: 1s;">
            <i class="fas fa-laptop-code text-6xl text-white/70"></i>
        </div>
        <div class="absolute bottom-1/4 left-[15%] opacity-20 animate-float" style="animation-duration: 8s; animation-delay: 2s;">
            <i class="fas fa-graduation-cap text-6xl text-secondary"></i>
        </div>
        <div class="absolute bottom-1/3 right-[18%] opacity-20 animate-float" style="animation-duration: 6.5s; animation-delay: 0.5s;">
            <i class="fas fa-brain text-6xl text-white/80"></i>
        </div>
        <div class="absolute top-[45%] left-[25%] opacity-20 animate-float" style="animation-duration: 7.5s; animation-delay: 1.5s;">
            <i class="fas fa-server text-6xl text-white/70"></i>
        </div>
    </div>
    
    <!-- Content -->
    <div class="container mx-auto px-4 relative z-10">
        <div class="text-center max-w-4xl mx-auto">
            <div class="inline-block bg-white/20 backdrop-blur-sm text-white px-4 py-2 rounded-full text-sm font-semibold mb-6 border border-white/30">
                <i class="fas fa-book-open mr-2"></i>All Courses
            </div>
            <h1 class="text-5xl md:text-6xl font-bold mb-6">
                Explore Our Courses
            </h1>
            <p class="text-xl md:text-2xl text-white/90 mb-8 max-w-3xl mx-auto">
                Master in-demand tech skills with our comprehensive, AI-powered courses designed to get you job-ready.
            </p>
            
            <!-- Stats -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-12">
                <div class="backdrop-blur-sm bg-white/10 rounded-lg p-4 border border-white/20">
                    <div class="text-3xl font-bold"><?= count($allCategories ?? []) ?></div>
                    <div class="text-white/70 text-sm">Course Tracks</div>
                </div>
                <div class="backdrop-blur-sm bg-white/10 rounded-lg p-4 border border-white/20">
                    <div class="text-3xl font-bold"><?= number_format($totalEnrollments ?? 0) ?>+</div>
                    <div class="text-white/70 text-sm">Enrollments</div>
                </div>
                <div class="backdrop-blur-sm bg-white/10 rounded-lg p-4 border border-white/20">
                    <div class="text-3xl font-bold"><?= $totalCourses ?? 0 ?></div>
                    <div class="text-white/70 text-sm">Courses</div>
                </div>
                <div class="backdrop-blur-sm bg-white/10 rounded-lg p-4 border border-white/20">
                    <?php 
                    $displayRating = ($avgRating ?? 0) > 0 ? number_format($avgRating, 1) : 'New';
                    ?>
                    <div class="text-3xl font-bold"><?= $displayRating ?></div>
                    <div class="text-white/70 text-sm">Avg Rating</div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="container mx-auto px-4 py-12">
    <!-- Results Info -->
    <div class="text-center text-gray-600 mb-8">
        <p class="text-lg">
            Showing <span class="font-bold text-gray-900"><?= count($courses) ?></span> 
            <?= count($courses) === 1 ? 'course bundle' : 'course bundles' ?>
        </p>
    </div>

    <!-- Course Grid -->
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php if (!empty($courses)): ?>
            <?php foreach ($courses as $course): ?>
        <?php 
        // Default card styling if not set
        $cardColorFrom = $course['card_color_from'] ?? 'from-primary';
        $cardColorTo = $course['card_color_to'] ?? 'to-blue-700';
        $cardIcon = $course['card_icon'] ?? 'fas fa-book';
        
        // Level styling
        $level = $course['level'] ?? 'beginner';
        $levelColors = [
            'beginner' => 'bg-green-100 text-green-700',
            'intermediate' => 'bg-blue-100 text-blue-700',
            'advanced' => 'bg-purple-100 text-purple-700'
        ];
        $levelColor = $levelColors[$level] ?? $levelColors['beginner'];
        
        // Truncate description to ~150 characters
        $shortDescription = $course['description'] ?? '';
        if (strlen($shortDescription) > 150) {
            $shortDescription = substr($shortDescription, 0, 150) . '...';
        }
        
        // Calculate savings for bundles
        $originalPrice = $course['original_price'] ?? null;
        $currentPrice = $course['price'] ?? 0;
        $savingsPercent = 0;
        if ($originalPrice && $originalPrice > $currentPrice) {
            $savingsPercent = round((($originalPrice - $currentPrice) / $originalPrice) * 100);
        }
        
        // Rating display
        $rating = $course['rating'] ?? 0;
        $reviewCount = $course['review_count'] ?? 0;
        $hasReviews = $reviewCount > 0;
        ?>
        <div class="group bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden relative transform hover:-translate-y-1">
            <!-- Level Badge (Top Left) -->
            <div class="absolute top-4 left-4 z-10 <?= $levelColor ?> text-xs font-bold px-3 py-1 rounded-full shadow-lg">
                <i class="fas fa-signal mr-1"></i><?= ucfirst($level) ?>
            </div>
            
            <!-- Bundle/Savings Badge (Top Right) -->
            <?php if (!empty($course['is_bundle']) && $savingsPercent > 0): ?>
            <div class="absolute top-4 right-4 z-10 bg-gradient-to-r from-green-500 to-green-600 text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg animate-pulse">
                <i class="fas fa-tag mr-1"></i>SAVE <?= $savingsPercent ?>%
            </div>
            <?php elseif (!empty($course['is_bundle'])): ?>
            <div class="absolute top-4 right-4 z-10 bg-yellow-400 text-yellow-900 text-xs font-bold px-3 py-1 rounded-full shadow-lg">
                <i class="fas fa-layer-group mr-1"></i>BUNDLE
            </div>
            <?php endif; ?>
            
            <!-- Enrollment Badge -->
            <?php if (!empty($course['is_enrolled'])): ?>
            <div class="absolute top-14 left-4 z-10 bg-gradient-to-r from-green-500 to-green-600 text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg">
                <i class="fas fa-check-circle mr-1"></i>ENROLLED
            </div>
            <?php endif; ?>
            
            <a href="<?= url('/courses/' . $course['slug']) ?>" class="block relative overflow-hidden">
                <!-- Card Header with Gradient -->
                <div class="bg-gradient-to-br <?= $cardColorFrom ?> <?= $cardColorTo ?> p-8 relative group-hover:brightness-110 transition-all duration-300">
                    <!-- Hover Overlay -->
                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-all duration-300 flex items-center justify-center">
                        <span class="opacity-0 group-hover:opacity-100 transition-opacity duration-300 bg-white text-gray-800 px-4 py-2 rounded-lg font-semibold shadow-lg">
                            <i class="fas fa-eye mr-2"></i>View Details
                        </span>
                    </div>
                    
                    <div class="w-16 h-16 bg-white rounded-lg flex items-center justify-center mb-4 shadow-md">
                        <i class="<?= htmlspecialchars($cardIcon) ?> text-3xl text-gray-700"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-2"><?= htmlspecialchars($course['title']) ?></h3>
                    <p class="text-white/90 text-sm"><?= htmlspecialchars($shortDescription) ?></p>
                    
                    <!-- Rating and Enrollment -->
                    <div class="flex items-center gap-4 mt-4 text-white/90 text-sm">
                        <div class="flex items-center gap-1">
                            <?php if ($hasReviews): ?>
                                <!-- Visual Stars -->
                                <?php 
                                $fullStars = floor($rating);
                                $halfStar = ($rating - $fullStars) >= 0.5;
                                $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
                                ?>
                                <div class="flex text-yellow-300">
                                    <?php for ($s = 0; $s < $fullStars; $s++): ?>
                                        <i class="fas fa-star"></i>
                                    <?php endfor; ?>
                                    <?php if ($halfStar): ?>
                                        <i class="fas fa-star-half-alt"></i>
                                    <?php endif; ?>
                                    <?php for ($s = 0; $s < $emptyStars; $s++): ?>
                                        <i class="far fa-star"></i>
                                    <?php endfor; ?>
                                </div>
                                <span class="font-semibold ml-1"><?= number_format($rating, 1) ?></span>
                                <span class="text-white/70">(<?= number_format($reviewCount) ?>)</span>
                            <?php else: ?>
                                <span class="bg-white/20 px-2 py-0.5 rounded text-xs font-medium">
                                    <i class="fas fa-sparkles mr-1"></i>New Course
                                </span>
                            <?php endif; ?>
                        </div>
                        <div class="flex items-center gap-1">
                            <i class="fas fa-users"></i>
                            <span><?= number_format($course['enrollment_count'] ?? 0) ?> enrolled</span>
                        </div>
                    </div>
                </div>
            </a>
            
            <div class="p-6">
                <!-- Facilitator & AI Tutor -->
                <div class="mb-4 pb-4 border-b border-gray-200">
                    <div class="flex items-center gap-2 mb-2">
                        <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                            <i class="fas fa-robot text-white text-sm"></i>
                        </div>
                        <div class="flex-1">
                            <div class="text-xs text-gray-500">AI-Powered Learning</div>
                            <div class="font-semibold text-gray-900 text-sm">Nebatech AI Tutor</div>
                        </div>
                    </div>
                    <?php if (!empty($course['facilitator_name'])): ?>
                    <div class="flex items-center gap-2 mt-2">
                        <div class="w-8 h-8 bg-gradient-to-br from-primary to-primary/70 rounded-full flex items-center justify-center text-white font-bold text-xs">
                            <?= strtoupper(substr($course['facilitator_name'], 0, 1)) ?>
                        </div>
                        <div class="flex-1">
                            <div class="text-xs text-gray-500">Mentor & Facilitator</div>
                            <div class="font-semibold text-gray-900 text-sm"><?= htmlspecialchars($course['facilitator_name']) ?></div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Course Features -->
                <ul class="space-y-2 text-gray-600 dark:text-gray-400 text-sm mb-4">
                    <?php if (!empty($course['sub_course_count'])): ?>
                    <li class="flex items-center">
                        <i class="fas fa-check-circle text-green-500 mr-2"></i>
                        <?= $course['sub_course_count'] ?> Individual Courses Included
                    </li>
                    <?php endif; ?>
                    <li class="flex items-center">
                        <i class="fas fa-check-circle text-green-500 mr-2"></i>
                        <?= htmlspecialchars($course['card_features'] ?? 'Hands-on Projects & Exercises') ?>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check-circle text-green-500 mr-2"></i>
                        <?= $course['duration_hours'] ?? '20' ?>+ Hours of Content
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check-circle text-green-500 mr-2"></i>
                        Certificate of Completion
                    </li>
                </ul>
                
                <!-- Price and CTA -->
                <div class="flex items-center justify-between">
                    <div>
                        <?php if ($originalPrice && $originalPrice > $currentPrice): ?>
                            <span class="text-sm text-gray-400 line-through">GHS <?= number_format($originalPrice, 0) ?></span>
                        <?php endif; ?>
                        <span class="text-2xl font-bold text-primary block">GHS <?= number_format($currentPrice, 0) ?></span>
                        <div class="text-xs text-gray-500">One-time payment</div>
                    </div>
                    <?php if (!empty($course['is_enrolled'])): ?>
                        <a href="<?= url('/courses/' . $course['slug'] . '/learn') ?>" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg font-semibold transition-all flex items-center shadow-md hover:shadow-lg">
                            <i class="fas fa-play-circle mr-2"></i>Continue
                        </a>
                    <?php else: ?>
                        <a href="<?= url('/courses/' . $course['slug']) ?>" class="bg-primary hover:bg-primary/90 text-white px-4 py-2 rounded-lg font-semibold transition-all flex items-center shadow-md hover:shadow-lg group-hover:scale-105">
                            View Course <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
            <?php endforeach; ?>
        <?php else: ?>
            <!-- Empty State -->
            <div class="col-span-full text-center py-16">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-graduation-cap text-5xl text-gray-300"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">No courses available yet</h3>
                <p class="text-gray-600 mb-6">We're working on adding new courses. Check back soon!</p>
                <a href="<?= url('/') ?>" class="inline-block bg-primary text-white px-6 py-3 rounded-lg font-semibold hover:bg-primary/90 transition">
                    <i class="fas fa-home mr-2"></i>Go to Homepage
                </a>
            </div>
        <?php endif; ?>
    </div>

    <!-- Pagination -->
    <?php if (($totalPages ?? 1) > 1): ?>
    <div class="mt-12 flex justify-center">
        <nav class="flex items-center gap-2">
            <?php if ($currentPage > 1): ?>
                <a href="<?= url('/courses?' . http_build_query(array_merge($_GET, ['page' => $currentPage - 1]))) ?>" 
                   class="px-4 py-2 rounded-lg bg-white border-2 border-gray-300 text-gray-700 font-semibold hover:bg-gray-50 transition">
                    <i class="fas fa-chevron-left"></i>
                </a>
            <?php else: ?>
                <span class="px-4 py-2 rounded-lg bg-gray-100 border-2 border-gray-200 text-gray-400 font-semibold cursor-not-allowed">
                    <i class="fas fa-chevron-left"></i>
                </span>
            <?php endif; ?>

            <?php
            $startPage = max(1, $currentPage - 2);
            $endPage = min($totalPages, $currentPage + 2);
            
            if ($startPage > 1): ?>
                <a href="<?= url('/courses?' . http_build_query(array_merge($_GET, ['page' => 1]))) ?>" 
                   class="px-4 py-2 rounded-lg bg-white border-2 border-gray-300 text-gray-700 font-semibold hover:bg-gray-50 transition">1</a>
                <?php if ($startPage > 2): ?>
                    <span class="px-2 text-gray-500">...</span>
                <?php endif; ?>
            <?php endif; ?>

            <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                <?php if ($i == $currentPage): ?>
                    <span class="px-4 py-2 rounded-lg bg-primary text-white font-bold border-2 border-primary"><?= $i ?></span>
                <?php else: ?>
                    <a href="<?= url('/courses?' . http_build_query(array_merge($_GET, ['page' => $i]))) ?>" 
                       class="px-4 py-2 rounded-lg bg-white border-2 border-gray-300 text-gray-700 font-semibold hover:bg-gray-50 transition"><?= $i ?></a>
                <?php endif; ?>
            <?php endfor; ?>

            <?php if ($endPage < $totalPages): ?>
                <?php if ($endPage < $totalPages - 1): ?>
                    <span class="px-2 text-gray-500">...</span>
                <?php endif; ?>
                <a href="<?= url('/courses?' . http_build_query(array_merge($_GET, ['page' => $totalPages]))) ?>" 
                   class="px-4 py-2 rounded-lg bg-white border-2 border-gray-300 text-gray-700 font-semibold hover:bg-gray-50 transition"><?= $totalPages ?></a>
            <?php endif; ?>

            <?php if ($currentPage < $totalPages): ?>
                <a href="<?= url('/courses?' . http_build_query(array_merge($_GET, ['page' => $currentPage + 1]))) ?>" 
                   class="px-4 py-2 rounded-lg bg-white border-2 border-gray-300 text-gray-700 font-semibold hover:bg-gray-50 transition">
                    <i class="fas fa-chevron-right"></i>
                </a>
            <?php else: ?>
                <span class="px-4 py-2 rounded-lg bg-gray-100 border-2 border-gray-200 text-gray-400 font-semibold cursor-not-allowed">
                    <i class="fas fa-chevron-right"></i>
                </span>
            <?php endif; ?>
        </nav>
    </div>
    <?php endif; ?>

    <!-- FAQ Section -->
    <section class="py-16 bg-gray-50 rounded-2xl mt-16">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Frequently Asked Questions</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Everything you need to know about our courses
            </p>
        </div>

        <div class="max-w-4xl mx-auto space-y-4">
            <details class="bg-white rounded-lg shadow-md group">
                <summary class="flex items-center justify-between cursor-pointer p-6 font-semibold text-gray-900 text-lg hover:text-primary transition">
                    <span><i class="fas fa-question-circle text-primary mr-3"></i>How much do courses cost?</span>
                    <i class="fas fa-chevron-down group-open:rotate-180 transition-transform"></i>
                </summary>
                <div class="px-6 pb-6 text-gray-700">
                    Course prices range from GHS 590 to GHS 15,500 depending on the complexity and number of courses in the track. Bundle packages offer significant savings (up to 46% off) and give you lifetime access to all materials, updates, AI tutoring, and mentorship support. We also offer flexible payment plans.
                </div>
            </details>

            <details class="bg-white rounded-lg shadow-md group">
                <summary class="flex items-center justify-between cursor-pointer p-6 font-semibold text-gray-900 text-lg hover:text-primary transition">
                    <span><i class="fas fa-question-circle text-primary mr-3"></i>Do I get a certificate?</span>
                    <i class="fas fa-chevron-down group-open:rotate-180 transition-transform"></i>
                </summary>
                <div class="px-6 pb-6 text-gray-700">
                    Absolutely! Upon completing any course, you'll receive a verified certificate that you can share on LinkedIn, add to your resume, or showcase in your portfolio.
                </div>
            </details>

            <details class="bg-white rounded-lg shadow-md group">
                <summary class="flex items-center justify-between cursor-pointer p-6 font-semibold text-gray-900 text-lg hover:text-primary transition">
                    <span><i class="fas fa-question-circle text-primary mr-3"></i>What support do I get?</span>
                    <i class="fas fa-chevron-down group-open:rotate-180 transition-transform"></i>
                </summary>
                <div class="px-6 pb-6 text-gray-700">
                    Every course includes 24/7 AI-powered tutoring for personalized help. You'll also have access to dedicated mentors and facilitators who provide guidance, code reviews, and career advice. Plus, join our community forum to connect with fellow students.
                </div>
            </details>

            <details class="bg-white rounded-lg shadow-md group">
                <summary class="flex items-center justify-between cursor-pointer p-6 font-semibold text-gray-900 text-lg hover:text-primary transition">
                    <span><i class="fas fa-question-circle text-primary mr-3"></i>How long do I have access to the courses?</span>
                    <i class="fas fa-chevron-down group-open:rotate-180 transition-transform"></i>
                </summary>
                <div class="px-6 pb-6 text-gray-700">
                    Once you enroll, you have lifetime access to the course. Learn at your own pace, revisit lessons anytime, and access new content updates as they're released - all at no additional cost.
                </div>
            </details>

            <details class="bg-white rounded-lg shadow-md group">
                <summary class="flex items-center justify-between cursor-pointer p-6 font-semibold text-gray-900 text-lg hover:text-primary transition">
                    <span><i class="fas fa-question-circle text-primary mr-3"></i>What are the prerequisites?</span>
                    <i class="fas fa-chevron-down group-open:rotate-180 transition-transform"></i>
                </summary>
                <div class="px-6 pb-6 text-gray-700">
                    Most beginner courses have no prerequisites - just bring your enthusiasm to learn! For intermediate and advanced courses, we recommend completing the prerequisite courses listed in the course details.
                </div>
            </details>

            <details class="bg-white rounded-lg shadow-md group">
                <summary class="flex items-center justify-between cursor-pointer p-6 font-semibold text-gray-900 text-lg hover:text-primary transition">
                    <span><i class="fas fa-question-circle text-primary mr-3"></i>Can I access courses on mobile devices?</span>
                    <i class="fas fa-chevron-down group-open:rotate-180 transition-transform"></i>
                </summary>
                <div class="px-6 pb-6 text-gray-700">
                    Yes! Our platform is fully responsive and works seamlessly on smartphones, tablets, and desktops. Learn anywhere, anytime, on any device.
                </div>
            </details>
        </div>
    </section>

    <!-- CTA Section -->
    <div class="mt-16 bg-gradient-to-r from-primary to-secondary rounded-2xl p-12 text-center text-white relative overflow-hidden">
        <!-- Background decoration -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 right-0 w-64 h-64 bg-white rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-white rounded-full blur-3xl"></div>
        </div>
        
        <div class="relative z-10">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Ready to Transform Your Career?</h2>
            <p class="text-xl mb-8 opacity-90 max-w-2xl mx-auto">Join thousands of students mastering tech skills with AI-powered learning and expert mentorship</p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="<?= url('/register') ?>" class="bg-white text-primary px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    <i class="fas fa-rocket mr-2"></i>Get Started Free
                </a>
                <a href="<?= url('/contact') ?>" class="bg-transparent border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-primary transition">
                    <i class="fas fa-comments mr-2"></i>Talk to an Advisor
                </a>
            </div>
            <div class="flex flex-wrap justify-center gap-6 mt-8 text-sm opacity-90">
                <span><i class="fas fa-shield-alt mr-2"></i>30-day money-back guarantee</span>
                <span><i class="fas fa-infinity mr-2"></i>Lifetime access</span>
                <span><i class="fas fa-robot mr-2"></i>AI tutor included</span>
                <span><i class="fas fa-user-tie mr-2"></i>Expert mentors</span>
            </div>
        </div>
    </div>
</div>


