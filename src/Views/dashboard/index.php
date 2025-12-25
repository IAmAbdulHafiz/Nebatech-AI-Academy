<?php
/**
 * Student Dashboard View
 * 
 * Variables available:
 * - $user: Current user data
 * - $enrolledCount: Total enrolled courses
 * - $activeCount: Active courses
 * - $completedCount: Completed courses
 * - $certificatesCount: Earned certificates
 * - $learningHours: Total learning hours
 * - $recentCourses: Array of recent/in-progress courses
 * - $pendingCount: Number of pending submissions
 * - $upcomingDeadlines: Array of upcoming assignment deadlines
 * - $streak: Learning streak data (current, longest, last_activity)
 * - $recentActivity: Array of recent activities
 * - $resumeLesson: Last accessed lesson for quick resume
 * - $recommendedCourses: Array of recommended courses
 */

// Set defaults for variables that might not be set
$enrolledCount = $enrolledCount ?? 0;
$activeCount = $activeCount ?? 0;
$completedCount = $completedCount ?? 0;
$certificatesCount = $certificatesCount ?? 0;
$learningHours = $learningHours ?? 0;
$recentCourses = $recentCourses ?? [];
$pendingCount = $pendingCount ?? 0;
$upcomingDeadlines = $upcomingDeadlines ?? [];
$streak = $streak ?? ['current' => 0, 'longest' => 0, 'last_activity' => null];
$recentActivity = $recentActivity ?? [];
$resumeLesson = $resumeLesson ?? null;
$recommendedCourses = $recommendedCourses ?? [];
?>

<!-- Welcome Section with Quick Resume -->
<div class="bg-gradient-to-r from-blue-600 via-blue-700 to-purple-600 rounded-2xl shadow-xl p-8 text-white mb-8 relative overflow-hidden">
    <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/2"></div>
    <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/5 rounded-full translate-y-1/2 -translate-x-1/2"></div>
    
    <div class="relative z-10 flex items-center justify-between flex-wrap gap-6">
        <div class="flex-1">
            <h1 class="text-3xl font-bold mb-2">Welcome back, <?= htmlspecialchars($user['first_name']) ?>! 👋</h1>
            <p class="text-white/80 text-lg">Continue your learning journey and achieve your goals</p>
            
            <?php if ($resumeLesson): ?>
            <div class="mt-6 flex items-center gap-4 bg-white/10 backdrop-blur rounded-xl p-4 max-w-xl">
                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-play text-xl"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs text-white/70 uppercase tracking-wide">Continue where you left off</p>
                    <p class="font-semibold truncate"><?= htmlspecialchars($resumeLesson['lesson_title']) ?></p>
                    <p class="text-sm text-white/70 truncate"><?= htmlspecialchars($resumeLesson['course_title']) ?></p>
                </div>
                <a href="<?= url('/courses/' . $resumeLesson['course_slug'] . '/lesson/' . $resumeLesson['lesson_id']) ?>" 
                   class="bg-white text-blue-600 px-5 py-2.5 rounded-lg font-semibold hover:bg-blue-50 transition flex-shrink-0">
                    Resume
                </a>
            </div>
            <?php endif; ?>
        </div>
        
        <div class="hidden lg:block">
            <div class="relative">
                <i class="fas fa-graduation-cap text-8xl text-white/20"></i>
                <?php if ($streak['current'] > 0): ?>
                <div class="absolute -top-2 -right-2 bg-orange-500 rounded-full px-3 py-1 text-sm font-bold shadow-lg flex items-center gap-1">
                    <i class="fas fa-fire"></i> <?= $streak['current'] ?> day streak!
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Quick Stats -->
<div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
    <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100 hover:shadow-md transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-medium">Enrolled Courses</p>
                <p class="text-3xl font-bold text-primary mt-1"><?= $enrolledCount ?></p>
            </div>
            <div class="bg-blue-100 rounded-xl p-3">
                <i class="fas fa-book text-primary text-xl"></i>
            </div>
        </div>
        <div class="mt-3 pt-3 border-t border-gray-100">
            <a href="<?= url('/my-courses') ?>" class="text-sm text-primary hover:underline font-medium">
                View all <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100 hover:shadow-md transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-medium">In Progress</p>
                <p class="text-3xl font-bold text-yellow-600 mt-1"><?= $activeCount ?></p>
            </div>
            <div class="bg-yellow-100 rounded-xl p-3">
                <i class="fas fa-spinner text-yellow-600 text-xl"></i>
            </div>
        </div>
        <div class="mt-3 pt-3 border-t border-gray-100">
            <span class="text-sm text-gray-500">Active learning</span>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100 hover:shadow-md transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-medium">Completed</p>
                <p class="text-3xl font-bold text-green-600 mt-1"><?= $completedCount ?></p>
            </div>
            <div class="bg-green-100 rounded-xl p-3">
                <i class="fas fa-check-circle text-green-600 text-xl"></i>
            </div>
        </div>
        <div class="mt-3 pt-3 border-t border-gray-100">
            <span class="text-sm text-green-600 font-medium">
                <?= $enrolledCount > 0 ? round(($completedCount / $enrolledCount) * 100) : 0 ?>% completion rate
            </span>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100 hover:shadow-md transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-medium">Certificates</p>
                <p class="text-3xl font-bold text-purple-600 mt-1"><?= $certificatesCount ?></p>
            </div>
            <div class="bg-purple-100 rounded-xl p-3">
                <i class="fas fa-award text-purple-600 text-xl"></i>
            </div>
        </div>
        <div class="mt-3 pt-3 border-t border-gray-100">
            <a href="<?= url('/my-certificates') ?>" class="text-sm text-purple-600 hover:underline font-medium">
                View certificates <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100 hover:shadow-md transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-medium">Learning Hours</p>
                <p class="text-3xl font-bold text-orange-600 mt-1"><?= $learningHours ?></p>
            </div>
            <div class="bg-orange-100 rounded-xl p-3">
                <i class="fas fa-clock text-orange-600 text-xl"></i>
            </div>
        </div>
        <div class="mt-3 pt-3 border-t border-gray-100">
            <span class="text-sm text-gray-500">Total time invested</span>
        </div>
    </div>
</div>

<div class="grid lg:grid-cols-3 gap-8">
    <!-- Main Content Column -->
    <div class="lg:col-span-2 space-y-6">
        
        <!-- Continue Learning Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                    <i class="fas fa-book-reader text-primary"></i>
                    Continue Learning
                </h2>
                <a href="<?= url('/my-courses') ?>" class="text-sm text-primary hover:underline font-medium">
                    View all courses
                </a>
            </div>
            <div class="p-6">
                <?php if (!empty($recentCourses)): ?>
                <div class="space-y-4">
                    <?php foreach ($recentCourses as $course): ?>
                    <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition group">
                        <div class="w-20 h-20 rounded-lg overflow-hidden flex-shrink-0 bg-gradient-to-br from-blue-500 to-purple-600">
                            <?php if (!empty($course['thumbnail'])): ?>
                            <img src="<?= htmlspecialchars($course['thumbnail']) ?>" alt="" class="w-full h-full object-cover">
                            <?php else: ?>
                            <div class="w-full h-full flex items-center justify-center">
                                <i class="fas fa-book text-white text-2xl"></i>
                            </div>
                            <?php endif; ?>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="font-semibold text-gray-900 truncate group-hover:text-primary transition">
                                <?= htmlspecialchars($course['title']) ?>
                            </h3>
                            <div class="flex items-center gap-4 mt-2">
                                <div class="flex-1 bg-gray-200 rounded-full h-2 max-w-xs">
                                    <div class="bg-gradient-to-r from-primary to-blue-400 h-2 rounded-full transition-all" 
                                         style="width: <?= min($course['progress'], 100) ?>%"></div>
                                </div>
                                <span class="text-sm font-medium text-gray-600"><?= round($course['progress']) ?>%</span>
                            </div>
                            <p class="text-sm text-gray-500 mt-1">
                                <?php if ($course['status'] === 'completed'): ?>
                                <span class="text-green-600"><i class="fas fa-check-circle mr-1"></i>Completed</span>
                                <?php else: ?>
                                <span class="text-blue-600"><i class="fas fa-play-circle mr-1"></i>In Progress</span>
                                <?php endif; ?>
                            </p>
                        </div>
                        <a href="<?= url('/courses/' . $course['slug'] . '/learn') ?>" 
                           class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary/90 transition flex-shrink-0 opacity-0 group-hover:opacity-100">
                            Continue <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php else: ?>
                <div class="text-center py-12">
                    <div class="w-20 h-20 bg-blue-100 rounded-full mx-auto flex items-center justify-center mb-4">
                        <i class="fas fa-book-open text-4xl text-primary"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">No courses yet</h3>
                    <p class="text-gray-600 mb-6">Start your learning journey by enrolling in a course</p>
                    <a href="<?= url('/courses') ?>" class="inline-block bg-primary text-white px-6 py-3 rounded-lg font-semibold hover:bg-primary/90 transition">
                        <i class="fas fa-compass mr-2"></i>Browse Courses
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Recommended Courses Section -->
        <?php if (!empty($recommendedCourses)): ?>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                    <i class="fas fa-star text-yellow-500"></i>
                    Recommended for You
                </h2>
                <a href="<?= url('/courses') ?>" class="text-sm text-primary hover:underline font-medium">
                    Browse all
                </a>
            </div>
            <div class="p-6">
                <div class="grid md:grid-cols-2 gap-5">
                    <?php foreach ($recommendedCourses as $course): 
                        $colorFrom = $course['card_color_from'] ?? 'from-blue-600';
                        $colorTo = $course['card_color_to'] ?? 'to-blue-700';
                        $cardIcon = $course['card_icon'] ?? 'fas fa-book';
                    ?>
                    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group flex flex-col">
                        <!-- Card Header with Gradient -->
                        <div class="h-36 bg-gradient-to-br <?= $colorFrom ?> <?= $colorTo ?> relative p-4 flex flex-col justify-between">
                            <!-- Badges Row -->
                            <div class="flex items-start justify-between">
                                <?php if (!empty($course['is_new'])): ?>
                                <span class="bg-yellow-400 text-yellow-900 text-xs font-bold px-2 py-1 rounded-full shadow-sm">
                                    NEW
                                </span>
                                <?php elseif (!empty($course['category_name'])): ?>
                                <span class="bg-white/20 backdrop-blur-sm text-white text-xs font-medium px-2 py-1 rounded-full">
                                    <?= htmlspecialchars($course['category_name']) ?>
                                </span>
                                <?php else: ?>
                                <span></span>
                                <?php endif; ?>
                                
                                <?php if (!empty($course['level'])): ?>
                                <span class="bg-white/20 backdrop-blur-sm text-white text-xs px-2 py-1 rounded-full capitalize">
                                    <?= htmlspecialchars($course['level']) ?>
                                </span>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Icon -->
                            <div class="flex items-end justify-between">
                                <div class="w-14 h-14 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                                    <i class="<?= htmlspecialchars($cardIcon) ?> text-white text-2xl"></i>
                                </div>
                                <?php if (!empty($course['card_modules'])): ?>
                                <span class="text-white/80 text-xs">
                                    <?= (int)$course['card_modules'] ?> modules
                                </span>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Decorative circles -->
                            <div class="absolute -top-6 -right-6 w-24 h-24 bg-white/10 rounded-full"></div>
                            <div class="absolute -bottom-8 -left-8 w-32 h-32 bg-white/5 rounded-full"></div>
                        </div>
                        
                        <!-- Card Body -->
                        <div class="p-4 flex-1 flex flex-col">
                            <h3 class="font-bold text-gray-900 mb-2 group-hover:text-primary transition line-clamp-2 text-base">
                                <?= htmlspecialchars($course['title']) ?>
                            </h3>
                            
                            <?php if (!empty($course['hero_subtitle'])): ?>
                            <p class="text-sm text-gray-500 mb-3 line-clamp-2 flex-1">
                                <?= htmlspecialchars(substr($course['hero_subtitle'], 0, 80)) ?>...
                            </p>
                            <?php endif; ?>
                            
                            <!-- Stats Row -->
                            <div class="flex items-center gap-3 text-xs text-gray-500 mb-3 flex-wrap">
                                <?php if (!empty($course['rating']) && $course['rating'] > 0): ?>
                                <span class="flex items-center gap-1">
                                    <i class="fas fa-star text-yellow-400"></i>
                                    <span class="font-medium text-gray-700"><?= number_format((float)$course['rating'], 1) ?></span>
                                    <?php if (!empty($course['review_count'])): ?>
                                    <span>(<?= number_format((int)$course['review_count']) ?>)</span>
                                    <?php endif; ?>
                                </span>
                                <?php endif; ?>
                                
                                <span class="flex items-center gap-1">
                                    <i class="fas fa-users text-gray-400"></i>
                                    <?= number_format((int)($course['enrollment_count'] ?? 0)) ?>
                                </span>
                                
                                <?php if (!empty($course['duration_hours']) || !empty($course['card_duration'])): ?>
                                <span class="flex items-center gap-1">
                                    <i class="fas fa-clock text-gray-400"></i>
                                    <?= $course['card_duration'] ?? ($course['duration_hours'] . 'h') ?>
                                </span>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Price & CTA -->
                            <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                                <?php if (!empty($course['price']) && $course['price'] > 0): ?>
                                <div class="flex items-baseline gap-2">
                                    <span class="text-lg font-bold text-gray-900">GH₵<?= number_format((float)$course['price']) ?></span>
                                    <?php if (!empty($course['original_price']) && $course['original_price'] > $course['price']): ?>
                                    <span class="text-xs text-gray-400 line-through">GH₵<?= number_format((float)$course['original_price']) ?></span>
                                    <?php endif; ?>
                                </div>
                                <?php else: ?>
                                <span class="text-lg font-bold text-green-600">Free</span>
                                <?php endif; ?>
                                
                                <a href="<?= url('/courses/' . $course['slug']) ?>" 
                                   class="bg-primary/10 text-primary px-4 py-2 rounded-lg text-sm font-semibold hover:bg-primary hover:text-white transition-all">
                                    Enroll
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php else: ?>
        <!-- Static Recommended Courses (Fallback) -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                    <i class="fas fa-star text-yellow-500"></i>
                    Explore Our Programs
                </h2>
                <a href="<?= url('/courses') ?>" class="text-sm text-primary hover:underline font-medium">
                    Browse all
                </a>
            </div>
            <div class="p-6">
                <div class="grid md:grid-cols-2 gap-4">
                    <div class="border border-gray-200 rounded-xl overflow-hidden hover:shadow-lg transition">
                        <div class="h-32 bg-gradient-to-br from-primary to-blue-600 flex items-center justify-center">
                            <i class="fas fa-code text-white text-4xl"></i>
                        </div>
                        <div class="p-4">
                            <h3 class="font-bold text-gray-900 mb-2">Frontend Development</h3>
                            <p class="text-sm text-gray-500 mb-3">HTML, CSS, JavaScript & React</p>
                            <a href="<?= url('/courses') ?>" class="block w-full text-center bg-gray-100 text-gray-700 py-2 rounded-lg font-medium hover:bg-primary hover:text-white transition">
                                Explore
                            </a>
                        </div>
                    </div>
                    <div class="border border-gray-200 rounded-xl overflow-hidden hover:shadow-lg transition">
                        <div class="h-32 bg-gradient-to-br from-green-500 to-green-700 flex items-center justify-center">
                            <i class="fas fa-server text-white text-4xl"></i>
                        </div>
                        <div class="p-4">
                            <h3 class="font-bold text-gray-900 mb-2">Backend Development</h3>
                            <p class="text-sm text-gray-500 mb-3">PHP, Node.js, Python & Databases</p>
                            <a href="<?= url('/courses') ?>" class="block w-full text-center bg-gray-100 text-gray-700 py-2 rounded-lg font-medium hover:bg-primary hover:text-white transition">
                                Explore
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Recent Activity -->
        <?php if (!empty($recentActivity)): ?>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-100">
                <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                    <i class="fas fa-history text-gray-400"></i>
                    Recent Activity
                </h2>
            </div>
            <div class="divide-y divide-gray-100">
                <?php foreach ($recentActivity as $activity): ?>
                <div class="p-4 flex items-center gap-4 hover:bg-gray-50 transition">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0
                        <?php 
                        $colorClass = match($activity['color'] ?? 'blue') {
                            'green' => 'bg-green-100 text-green-600',
                            'yellow' => 'bg-yellow-100 text-yellow-600',
                            'purple' => 'bg-purple-100 text-purple-600',
                            default => 'bg-blue-100 text-blue-600'
                        };
                        echo $colorClass;
                        ?>">
                        <i class="fas <?= $activity['icon'] ?? 'fa-circle' ?>"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">
                            <?= htmlspecialchars($activity['title']) ?>
                        </p>
                        <p class="text-xs text-gray-500 truncate">
                            <?= htmlspecialchars($activity['course']) ?>
                            <?php if ($activity['type'] === 'submission' && !empty($activity['score'])): ?>
                            <span class="text-green-600 ml-2">Score: <?= $activity['score'] ?>%</span>
                            <?php endif; ?>
                        </p>
                    </div>
                    <div class="text-xs text-gray-400 flex-shrink-0">
                        <?= date('M d, g:i a', strtotime($activity['date'])) ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Sidebar Column -->
    <div class="space-y-6">
        
        <!-- Profile Card -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="text-center">
                <div class="w-20 h-20 bg-gradient-to-br from-primary to-purple-600 rounded-full mx-auto flex items-center justify-center text-white text-2xl font-bold mb-4 ring-4 ring-primary/20">
                    <?php if (!empty($user['avatar'])): ?>
                    <img src="<?= htmlspecialchars(avatar_url($user['avatar'])) ?>" alt="" class="w-full h-full rounded-full object-cover">
                    <?php else: ?>
                    <?= strtoupper(substr($user['first_name'], 0, 1) . substr($user['last_name'], 0, 1)) ?>
                    <?php endif; ?>
                </div>
                <h3 class="font-bold text-gray-900 text-lg"><?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?></h3>
                <p class="text-sm text-gray-500 mt-1"><?= htmlspecialchars($user['email']) ?></p>
                <span class="inline-block mt-3 px-3 py-1 bg-blue-100 text-blue-700 text-xs font-medium rounded-full">
                    <i class="fas fa-user-graduate mr-1"></i>Student
                </span>
                <div class="mt-4 pt-4 border-t border-gray-100">
                    <a href="<?= url('/profile') ?>" class="text-primary font-medium text-sm hover:underline">
                        <i class="fas fa-edit mr-1"></i>Edit Profile
                    </a>
                </div>
            </div>
        </div>

        <!-- Learning Streak -->
        <div class="bg-gradient-to-br from-orange-500 to-red-500 rounded-xl shadow-sm p-6 text-white">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-bold text-lg">Learning Streak</h3>
                <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center">
                    <i class="fas fa-fire text-2xl"></i>
                </div>
            </div>
            <div class="text-center py-4">
                <p class="text-5xl font-bold mb-2"><?= $streak['current'] ?></p>
                <p class="text-white/80">days in a row</p>
            </div>
            <div class="flex items-center justify-between text-sm mt-4 pt-4 border-t border-white/20">
                <div>
                    <p class="text-white/70">Longest Streak</p>
                    <p class="font-semibold"><?= $streak['longest'] ?> days</p>
                </div>
                <div class="text-right">
                    <p class="text-white/70">Last Active</p>
                    <p class="font-semibold">
                        <?= $streak['last_activity'] ? date('M d', strtotime($streak['last_activity'])) : 'Never' ?>
                    </p>
                </div>
            </div>
            <?php if ($streak['current'] === 0): ?>
            <p class="text-center text-white/80 text-sm mt-4">
                <i class="fas fa-lightbulb mr-1"></i>Complete a lesson today to start your streak!
            </p>
            <?php endif; ?>
        </div>

        <!-- Upcoming Deadlines -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="p-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="font-bold text-gray-900 flex items-center gap-2">
                    <i class="fas fa-calendar-alt text-red-500"></i>
                    Upcoming Deadlines
                </h3>
                <?php if ($pendingCount > 0): ?>
                <span class="bg-red-100 text-red-600 text-xs font-bold px-2 py-1 rounded-full">
                    <?= $pendingCount ?> pending
                </span>
                <?php endif; ?>
            </div>
            <div class="p-4">
                <?php if (!empty($upcomingDeadlines)): ?>
                <div class="space-y-3">
                    <?php foreach ($upcomingDeadlines as $deadline): ?>
                    <?php 
                    $dueDate = new DateTime($deadline['due_date']);
                    $now = new DateTime();
                    $diff = $now->diff($dueDate);
                    $isUrgent = $diff->days <= 2;
                    ?>
                    <div class="flex items-start gap-3 p-3 rounded-lg <?= $isUrgent ? 'bg-red-50 border border-red-200' : 'bg-gray-50' ?>">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0 <?= $isUrgent ? 'bg-red-200 text-red-600' : 'bg-gray-200 text-gray-600' ?>">
                            <i class="fas fa-tasks text-sm"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">
                                <?= htmlspecialchars($deadline['assignment_title']) ?>
                            </p>
                            <p class="text-xs text-gray-500 truncate">
                                <?= htmlspecialchars($deadline['course_title']) ?>
                            </p>
                            <p class="text-xs mt-1 <?= $isUrgent ? 'text-red-600 font-semibold' : 'text-gray-500' ?>">
                                <i class="fas fa-clock mr-1"></i>
                                Due: <?= date('M d, Y', strtotime($deadline['due_date'])) ?>
                                <?php if ($diff->days === 0): ?>
                                <span class="text-red-600 font-bold ml-1">(Today!)</span>
                                <?php elseif ($diff->days === 1): ?>
                                <span class="text-red-600 font-bold ml-1">(Tomorrow)</span>
                                <?php elseif ($isUrgent): ?>
                                <span class="ml-1">(<?= $diff->days ?> days left)</span>
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php else: ?>
                <div class="text-center py-6">
                    <div class="w-12 h-12 bg-green-100 rounded-full mx-auto flex items-center justify-center mb-3">
                        <i class="fas fa-check text-green-600 text-xl"></i>
                    </div>
                    <p class="text-sm text-gray-600">No upcoming deadlines!</p>
                    <p class="text-xs text-gray-400 mt-1">You're all caught up</p>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <h3 class="font-bold text-gray-900 mb-4">Quick Actions</h3>
            <div class="space-y-2">
                <a href="<?= url('/courses') ?>" class="flex items-center gap-3 p-3 bg-blue-50 text-primary rounded-lg hover:bg-blue-100 transition">
                    <i class="fas fa-compass w-5"></i>
                    <span class="font-medium">Browse Courses</span>
                </a>
                <a href="<?= url('/my-courses') ?>" class="flex items-center gap-3 p-3 bg-green-50 text-green-700 rounded-lg hover:bg-green-100 transition">
                    <i class="fas fa-book w-5"></i>
                    <span class="font-medium">My Courses</span>
                </a>
                <a href="<?= url('/my-certificates') ?>" class="flex items-center gap-3 p-3 bg-purple-50 text-purple-700 rounded-lg hover:bg-purple-100 transition">
                    <i class="fas fa-award w-5"></i>
                    <span class="font-medium">Certificates</span>
                </a>
                <a href="<?= url('/my-portfolio') ?>" class="flex items-center gap-3 p-3 bg-indigo-50 text-indigo-700 rounded-lg hover:bg-indigo-100 transition">
                    <i class="fas fa-briefcase w-5"></i>
                    <span class="font-medium">My Portfolio</span>
                </a>
                <a href="<?= url('/playground') ?>" class="flex items-center gap-3 p-3 bg-yellow-50 text-yellow-700 rounded-lg hover:bg-yellow-100 transition">
                    <i class="fas fa-code w-5"></i>
                    <span class="font-medium">Code Playground</span>
                </a>
            </div>
        </div>

        <!-- Progress Overview Chart -->
        <?php if ($enrolledCount > 0): ?>
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <h3 class="font-bold text-gray-900 mb-4">Progress Overview</h3>
            <div class="relative">
                <canvas id="progressChart" width="200" height="200"></canvas>
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="text-center">
                        <p class="text-3xl font-bold text-gray-900">
                            <?= $enrolledCount > 0 ? round(($completedCount / $enrolledCount) * 100) : 0 ?>%
                        </p>
                        <p class="text-xs text-gray-500">Complete</p>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-3 gap-2 mt-4 text-center">
                <div class="p-2 bg-blue-50 rounded-lg">
                    <p class="text-lg font-bold text-blue-600"><?= $activeCount ?></p>
                    <p class="text-xs text-gray-500">Active</p>
                </div>
                <div class="p-2 bg-green-50 rounded-lg">
                    <p class="text-lg font-bold text-green-600"><?= $completedCount ?></p>
                    <p class="text-xs text-gray-500">Done</p>
                </div>
                <div class="p-2 bg-purple-50 rounded-lg">
                    <p class="text-lg font-bold text-purple-600"><?= $certificatesCount ?></p>
                    <p class="text-xs text-gray-500">Certs</p>
                </div>
            </div>
        </div>
        
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('progressChart');
            if (ctx && typeof Chart !== 'undefined') {
                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Completed', 'In Progress', 'Not Started'],
                        datasets: [{
                            data: [<?= $completedCount ?>, <?= $activeCount ?>, <?= max(0, $enrolledCount - $completedCount - $activeCount) ?>],
                            backgroundColor: ['#10B981', '#3B82F6', '#E5E7EB'],
                            borderWidth: 0,
                            cutout: '75%'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: {
                                display: false
                            }
                        }
                    }
                });
            }
        });
        </script>
        <?php endif; ?>
    </div>
</div>

<!-- Search Functionality Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('input[placeholder*="Search"]');
    if (searchInput) {
        let searchTimeout;
        searchInput.addEventListener('input', function(e) {
            clearTimeout(searchTimeout);
            const query = e.target.value.trim();
            
            if (query.length >= 2) {
                searchTimeout = setTimeout(() => {
                    window.location.href = '<?= url('/courses') ?>?search=' + encodeURIComponent(query);
                }, 500);
            }
        });
        
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                const query = e.target.value.trim();
                if (query) {
                    window.location.href = '<?= url('/courses') ?>?search=' + encodeURIComponent(query);
                }
            }
        });
    }
});
</script>


