<!-- Hero Section -->
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
        <div class="absolute top-1/3 right-1/4 w-64 h-64 bg-primary/90/20 rounded-full blur-2xl animate-pulse" style="animation-duration: 7s; animation-delay: 2s;"></div>
        
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
            <div class="inline-block bg-primary/80/60 backdrop-blur-sm text-white/90 px-4 py-2 rounded-full text-sm font-semibold mb-6 border border-white/30/30">
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
                <div class="backdrop-blur-sm bg-white/10 rounded-lg p-4 border border-white/30/20">
                    <div class="text-3xl font-bold"><?= count($allCategories ?? []) ?></div>
                    <div class="text-white/70 text-sm">Course Tracks</div>
                </div>
                <div class="backdrop-blur-sm bg-white/10 rounded-lg p-4 border border-white/30/20">
                    <div class="text-3xl font-bold"><?= number_format($totalEnrollments ?? 0) ?>+</div>
                    <div class="text-white/70 text-sm">Enrollments</div>
                </div>
                <div class="backdrop-blur-sm bg-white/10 rounded-lg p-4 border border-white/30/20">
                    <div class="text-3xl font-bold"><?= $totalCourses ?? 0 ?></div>
                    <div class="text-white/70 text-sm">Courses</div>
                </div>
                <div class="backdrop-blur-sm bg-white/10 rounded-lg p-4 border border-white/30/20">
                    <div class="text-3xl font-bold"><?= number_format($avgRating ?? 4.7, 1) ?></div>
                    <div class="text-white/70 text-sm">Avg Rating</div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="container mx-auto px-4 py-12">
    <!-- Search and Filter Section -->
    <div class="mb-12">
        <!-- Search Bar -->
        <div class="max-w-3xl mx-auto mb-8">
            <form method="GET" action="<?= url('/courses') ?>" class="relative">
                <input type="text" 
                       name="search" 
                       value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"
                       placeholder="Search courses by name, skill, or topic..." 
                       class="w-full px-6 py-4 pr-32 rounded-lg border-2 border-gray-300 focus:border-primary focus:outline-none text-gray-900 shadow-lg">
                <button type="submit" 
                        class="absolute right-2 top-2 bg-primary text-white px-6 py-2 rounded-lg hover:bg-primary/90 transition font-semibold">
                    <i class="fas fa-search mr-2"></i>Search
                </button>
            </form>
        </div>

        <!-- Category Tabs -->
        <div class="mb-8">
            <div class="flex flex-wrap justify-center gap-3">
                <a href="<?= url('/courses') ?>" 
                   class="px-6 py-3 rounded-lg font-semibold transition <?= empty($_GET['category']) ? 'bg-primary text-white' : 'bg-white text-gray-700 hover:bg-gray-100' ?> shadow-md">
                    <i class="fas fa-th mr-2"></i>All Courses
                </a>
                <?php foreach ($allCategories ?? [] as $cat): ?>
                <a href="<?= url('/courses?category=' . urlencode($cat['slug'])) ?>" 
                   class="px-6 py-3 rounded-lg font-semibold transition <?= ($_GET['category'] ?? '') === $cat['slug'] ? 'bg-primary text-white' : 'bg-white text-gray-700 hover:bg-gray-100' ?> shadow-md">
                    <?= htmlspecialchars($cat['name']) ?>
                </a>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Filters Row -->
        <div class="flex flex-wrap justify-center gap-4 mb-8">
            <!-- Level Filter -->
            <div class="relative">
                <select name="level" 
                        onchange="window.location.href='<?= url('/courses') ?>?' + new URLSearchParams({...Object.fromEntries(new URLSearchParams(window.location.search)), level: this.value}).toString()"
                        class="px-6 py-3 pr-10 rounded-lg border-2 border-gray-300 focus:border-primary focus:outline-none text-gray-700 font-semibold bg-white shadow-md appearance-none cursor-pointer">
                    <option value="">All Levels</option>
                    <option value="beginner" <?= ($_GET['level'] ?? '') === 'beginner' ? 'selected' : '' ?>>Beginner</option>
                    <option value="intermediate" <?= ($_GET['level'] ?? '') === 'intermediate' ? 'selected' : '' ?>>Intermediate</option>
                    <option value="advanced" <?= ($_GET['level'] ?? '') === 'advanced' ? 'selected' : '' ?>>Advanced</option>
                </select>
                <i class="fas fa-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none text-gray-500"></i>
            </div>

            <!-- Sort Filter -->
            <div class="relative">
                <select name="sort" 
                        onchange="window.location.href='<?= url('/courses') ?>?' + new URLSearchParams({...Object.fromEntries(new URLSearchParams(window.location.search)), sort: this.value}).toString()"
                        class="px-6 py-3 pr-10 rounded-lg border-2 border-gray-300 focus:border-primary focus:outline-none text-gray-700 font-semibold bg-white shadow-md appearance-none cursor-pointer">
                    <option value="">Sort By</option>
                    <option value="popular" <?= ($_GET['sort'] ?? '') === 'popular' ? 'selected' : '' ?>>Most Popular</option>
                    <option value="rating" <?= ($_GET['sort'] ?? '') === 'rating' ? 'selected' : '' ?>>Highest Rated</option>
                    <option value="newest" <?= ($_GET['sort'] ?? '') === 'newest' ? 'selected' : '' ?>>Newest First</option>
                    <option value="title" <?= ($_GET['sort'] ?? '') === 'title' ? 'selected' : '' ?>>A to Z</option>
                </select>
                <i class="fas fa-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none text-gray-500"></i>
            </div>

            <!-- Clear Filters -->
            <?php if (!empty($_GET['search']) || !empty($_GET['category']) || !empty($_GET['level']) || !empty($_GET['sort'])): ?>
            <a href="<?= url('/courses') ?>" 
               class="px-6 py-3 rounded-lg font-semibold bg-red-500 text-white hover:bg-red-600 transition shadow-md">
                <i class="fas fa-times mr-2"></i>Clear Filters
            </a>
            <?php endif; ?>
        </div>

        <!-- Results Info -->
        <div class="text-center text-gray-600 mb-8">
            <p class="text-lg">
                Showing <span class="font-bold text-gray-900"><?= count($courses) ?></span> 
                <?= count($courses) === 1 ? 'course' : 'courses' ?>
                <?php if (!empty($_GET['search'])): ?>
                    for "<span class="font-bold text-primary"><?= htmlspecialchars($_GET['search']) ?></span>"
                <?php endif; ?>
            </p>
        </div>
    </div>

    <!-- Course Categories -->
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php if (!empty($courses)): ?>
            <?php foreach ($courses as $course): ?>
        <!-- <?= htmlspecialchars($course['title']) ?> -->
        <div class="group bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden relative">
            <!-- Enrollment Badge -->
            <?php if (!empty($course['is_enrolled'])): ?>
            <div class="absolute top-4 left-4 z-10 bg-gradient-to-r from-green-500 to-green-600 text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg">
                <i class="fas fa-check-circle mr-1"></i>ENROLLED
            </div>
            <?php endif; ?>
            
            <!-- New Badge -->
            <?php if (!empty($course['is_new'])): ?>
            <div class="absolute top-4 right-4 z-10 bg-gradient-to-r from-yellow-400 to-orange-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg">
                <i class="fas fa-star mr-1"></i>NEW
            </div>
            <?php endif; ?>
            
            <?php 
            // Default card styling if not set
            $cardColorFrom = $course['card_color_from'] ?? 'from-primary';
            $cardColorTo = $course['card_color_to'] ?? 'to-blue-700';
            $cardIcon = $course['card_icon'] ?? 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253';
            ?>
            <a href="<?= url('/courses/' . $course['slug']) ?>" class="block">
            <div class="bg-gradient-to-br <?= $cardColorFrom ?> <?= $cardColorTo ?> p-8 relative">
                <?php if (!empty($course['is_bundle'])): ?>
                <div class="absolute top-4 right-4 bg-yellow-400 text-yellow-900 text-xs font-bold px-3 py-1 rounded-full shadow-lg">
                    <i class="fas fa-layer-group mr-1"></i> BUNDLE
                </div>
                <?php endif; ?>
                <div class="w-16 h-16 bg-white rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?= $cardIcon ?>"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-white mb-2"><?= htmlspecialchars($course['title']) ?></h3>
                <p class="text-white/90 text-sm"><?= htmlspecialchars($course['description']) ?></p>
                
                <!-- Rating and Enrollment -->
                <div class="flex items-center gap-4 mt-4 text-white/90 text-sm">
                    <div class="flex items-center gap-1">
                        <i class="fas fa-star text-yellow-300"></i>
                        <span class="font-semibold"><?= number_format($course['rating'] ?? 4.5, 1) ?></span>
                        <span class="text-white/70">(<?= number_format($course['review_count'] ?? 0) ?>)</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <i class="fas fa-users"></i>
                        <span><?= number_format($course['enrollment_count'] ?? 0) ?>+ enrolled</span>
                    </div>
                </div>
            </div>
            </a>
            <div class="p-6">
                <!-- Facilitator & AI Tutor -->
                <div class="mb-4 pb-4 border-b border-gray-200">
                    <div class="flex items-center gap-2 mb-2">
                        <i class="fas fa-robot text-primary text-lg"></i>
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

                <ul class="space-y-2 text-gray-600 dark:text-gray-400 text-sm mb-4">
                    <?php if (!empty($course['sub_course_count'])): ?>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <?= $course['sub_course_count'] ?> Individual Courses
                    </li>
                    <?php endif; ?>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <?= htmlspecialchars($course['card_features'] ?? 'Hands-on Projects') ?>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <?= $course['duration_hours'] ?? '20' ?>+ Hours Content
                    </li>
                </ul>
                <div class="flex items-center justify-between text-sm">
                    <div>
                        <span class="text-2xl font-bold text-primary">GHS <?= isset($course['price']) ? number_format($course['price'], 0) : '749' ?></span>
                        <div class="text-xs text-gray-500 mt-1">One-time payment</div>
                    </div>
                    <?php if (!empty($course['is_enrolled'])): ?>
                        <a href="<?= url('/courses/' . $course['slug'] . '/learn') ?>" class="text-green-600 font-semibold group-hover:translate-x-1 transition-transform flex items-center">
                            <i class="fas fa-play-circle mr-1"></i>Continue Learning →
                        </a>
                    <?php else: ?>
                        <a href="<?= url('/courses/' . $course['slug']) ?>" class="text-primary font-semibold group-hover:translate-x-1 transition-transform flex items-center">
                            Learn More <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-span-full text-center py-16">
                <i class="fas fa-search text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">No courses found</h3>
                <p class="text-gray-600 mb-6">Try adjusting your search or filters</p>
                <a href="<?= url('/courses') ?>" class="inline-block bg-primary text-white px-6 py-3 rounded-lg font-semibold hover:bg-primary/90 transition">
                    View All Courses
                </a>
            </div>
        <?php endif; ?>
    </div>

    <!-- Pagination -->
    <?php if (($totalPages ?? 1) > 1): ?>
    <div class="mt-12 flex justify-center">
        <nav class="flex items-center gap-2">
            <!-- Previous Button -->
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

            <!-- Page Numbers -->
            <?php
            $startPage = max(1, $currentPage - 2);
            $endPage = min($totalPages, $currentPage + 2);
            
            if ($startPage > 1): ?>
                <a href="<?= url('/courses?' . http_build_query(array_merge($_GET, ['page' => 1]))) ?>" 
                   class="px-4 py-2 rounded-lg bg-white border-2 border-gray-300 text-gray-700 font-semibold hover:bg-gray-50 transition">
                    1
                </a>
                <?php if ($startPage > 2): ?>
                    <span class="px-2 text-gray-500">...</span>
                <?php endif; ?>
            <?php endif; ?>

            <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                <?php if ($i == $currentPage): ?>
                    <span class="px-4 py-2 rounded-lg bg-primary text-white font-bold border-2 border-primary">
                        <?= $i ?>
                    </span>
                <?php else: ?>
                    <a href="<?= url('/courses?' . http_build_query(array_merge($_GET, ['page' => $i]))) ?>" 
                       class="px-4 py-2 rounded-lg bg-white border-2 border-gray-300 text-gray-700 font-semibold hover:bg-gray-50 transition">
                        <?= $i ?>
                    </a>
                <?php endif; ?>
            <?php endfor; ?>

            <?php if ($endPage < $totalPages): ?>
                <?php if ($endPage < $totalPages - 1): ?>
                    <span class="px-2 text-gray-500">...</span>
                <?php endif; ?>
                <a href="<?= url('/courses?' . http_build_query(array_merge($_GET, ['page' => $totalPages]))) ?>" 
                   class="px-4 py-2 rounded-lg bg-white border-2 border-gray-300 text-gray-700 font-semibold hover:bg-gray-50 transition">
                    <?= $totalPages ?>
                </a>
            <?php endif; ?>

            <!-- Next Button -->
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
            <!-- FAQ Item 1 -->
            <details class="bg-white rounded-lg shadow-md group">
                <summary class="flex items-center justify-between cursor-pointer p-6 font-semibold text-gray-900 text-lg hover:text-primary transition">
                    <span><i class="fas fa-question-circle text-primary mr-3"></i>How much do courses cost?</span>
                    <i class="fas fa-chevron-down group-open:rotate-180 transition-transform"></i>
                </summary>
                <div class="px-6 pb-6 text-gray-700">
                    Course prices range from GHS 1,485 to GHS 15,500 depending on the complexity and number of courses in the track. Bundle packages offer significant savings (up to 46% off) and give you lifetime access to all materials, updates, AI tutoring, and mentorship support. We also offer flexible payment plans.
                </div>
            </details>

            <!-- FAQ Item 2 -->
            <details class="bg-white rounded-lg shadow-md group">
                <summary class="flex items-center justify-between cursor-pointer p-6 font-semibold text-gray-900 text-lg hover:text-primary transition">
                    <span><i class="fas fa-question-circle text-primary mr-3"></i>Do I get a certificate?</span>
                    <i class="fas fa-chevron-down group-open:rotate-180 transition-transform"></i>
                </summary>
                <div class="px-6 pb-6 text-gray-700">
                    Absolutely! Upon completing any course, you'll receive a verified certificate that you can share on LinkedIn, add to your resume, or showcase in your portfolio.
                </div>
            </details>

            <!-- FAQ Item 3 -->
            <details class="bg-white rounded-lg shadow-md group">
                <summary class="flex items-center justify-between cursor-pointer p-6 font-semibold text-gray-900 text-lg hover:text-primary transition">
                    <span><i class="fas fa-question-circle text-primary mr-3"></i>What support do I get?</span>
                    <i class="fas fa-chevron-down group-open:rotate-180 transition-transform"></i>
                </summary>
                <div class="px-6 pb-6 text-gray-700">
                    Every course includes 24/7 AI-powered tutoring for personalized help. You'll also have access to dedicated mentors and facilitators who provide guidance, code reviews, and career advice. Plus, join our community forum to connect with fellow students.
                </div>
            </details>

            <!-- FAQ Item 4 -->
            <details class="bg-white rounded-lg shadow-md group">
                <summary class="flex items-center justify-between cursor-pointer p-6 font-semibold text-gray-900 text-lg hover:text-primary transition">
                    <span><i class="fas fa-question-circle text-primary mr-3"></i>How long do I have access to the courses?</span>
                    <i class="fas fa-chevron-down group-open:rotate-180 transition-transform"></i>
                </summary>
                <div class="px-6 pb-6 text-gray-700">
                    Once you enroll, you have lifetime access to the course. Learn at your own pace, revisit lessons anytime, and access new content updates as they're released - all at no additional cost.
                </div>
            </details>

            <!-- FAQ Item 5 -->
            <details class="bg-white rounded-lg shadow-md group">
                <summary class="flex items-center justify-between cursor-pointer p-6 font-semibold text-gray-900 text-lg hover:text-primary transition">
                    <span><i class="fas fa-question-circle text-primary mr-3"></i>What are the prerequisites?</span>
                    <i class="fas fa-chevron-down group-open:rotate-180 transition-transform"></i>
                </summary>
                <div class="px-6 pb-6 text-gray-700">
                    Most beginner courses have no prerequisites - just bring your enthusiasm to learn! For intermediate and advanced courses, we recommend completing the prerequisite courses listed in the course details.
                </div>
            </details>

            <!-- FAQ Item 6 -->
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
    <div class="mt-16 bg-gradient-to-r from-primary to-secondary rounded-2xl p-12 text-center text-white">
        <h2 class="text-3xl font-bold mb-4">Ready to Transform Your Career?</h2>
        <p class="text-xl mb-8 opacity-90">Join thousands of students mastering tech skills with AI-powered learning and expert mentorship</p>
        <div class="flex justify-center gap-4">
            <a href="<?= url('/register') ?>" class="bg-white text-primary px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">
                Browse All Courses
            </a>
            <a href="<?= url('/contact') ?>" class="bg-transparent border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-primary transition">
                Talk to an Advisor
            </a>
        </div>
        <p class="text-sm mt-6 opacity-75">
            <i class="fas fa-shield-alt mr-2"></i>30-day money-back guarantee • Lifetime access • AI tutor + mentors
        </p>
    </div>
</div>


