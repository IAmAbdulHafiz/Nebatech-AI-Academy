<!-- Hero Section -->
<?php
// Parse JSON fields
$floatingIcons = !empty($course['floating_icons']) ? json_decode($course['floating_icons'], true) : ['fas fa-book', 'fas fa-graduation-cap', 'fas fa-code', 'fas fa-laptop-code'];
$technologies = !empty($course['technologies']) ? json_decode($course['technologies'], true) : [];
$skillsGained = !empty($course['skills_gained']) ? json_decode($course['skills_gained'], true) : [];

// Determine color scheme based on course or use default blue
$colorFrom = 'from-blue-900';
$colorVia = 'via-blue-700';
$colorTo = 'to-blue-600';
$colorLight = 'blue-400';
$colorPrimary = 'blue-500';
$buttonColor = 'blue-600';
$accentColor = 'primary';

// Use card colors if set
if (!empty($course['card_color_from'])) {
    // Extract color name from class (e.g., 'from-purple-600' -> 'purple')
    preg_match('/from-(\w+)-\d+/', $course['card_color_from'], $matches);
    if (!empty($matches[1])) {
        $baseColor = $matches[1];
        $colorFrom = "from-{$baseColor}-900";
        $colorVia = "via-{$baseColor}-700";
        $colorTo = "to-{$baseColor}-600";
        $colorLight = "{$baseColor}-400";
        $colorPrimary = "{$baseColor}-500";
        $buttonColor = "{$baseColor}-600";
        $accentColor = $baseColor;
    }
}
?>
<section class="relative bg-gradient-to-br <?= $colorFrom ?> <?= $colorVia ?> <?= $colorTo ?> text-white py-20 overflow-hidden">
    <!-- Digital Horizon Background -->
    <div class="absolute inset-0 overflow-hidden">
        <!-- Horizon Glow Effect -->
        <div class="absolute bottom-0 left-0 right-0 h-96 bg-gradient-to-t from-<?= $colorPrimary ?>/30 via-<?= $colorLight ?>/10 to-transparent"></div>
        <div class="absolute top-0 left-0 right-0 h-96 bg-gradient-to-b from-<?= $colorFrom ?>/50 via-transparent to-transparent"></div>
        
        <!-- Geometric Light Beams -->
        <div class="absolute inset-0">
            <div class="absolute top-0 left-1/4 w-1 h-full bg-gradient-to-b from-<?= $colorLight ?>/40 via-<?= $colorLight ?>/20 to-transparent transform -skew-x-12 animate-pulse" style="animation-duration: 3s;"></div>
            <div class="absolute top-0 right-1/3 w-1 h-full bg-gradient-to-b from-<?= $colorLight ?>/30 via-<?= $colorLight ?>/10 to-transparent transform skew-x-12 animate-pulse" style="animation-duration: 4s; animation-delay: 1s;"></div>
            <div class="absolute top-0 left-2/3 w-0.5 h-full bg-gradient-to-b from-<?= $colorLight ?>/30 via-transparent to-transparent transform -skew-x-6 animate-pulse" style="animation-duration: 5s; animation-delay: 2s;"></div>
        </div>
        
        <!-- Dynamic Glowing Orbs -->
        <div class="absolute top-20 left-10 w-96 h-96 bg-<?= $colorPrimary ?>/40 rounded-full blur-3xl animate-pulse" style="animation-duration: 6s;"></div>
        <div class="absolute bottom-10 right-10 w-[500px] h-[500px] bg-<?= $colorLight ?>/30 rounded-full blur-3xl animate-pulse" style="animation-duration: 8s; animation-delay: 1s;"></div>
        
        <!-- Floating Icons from Database -->
        <?php 
        $positions = [
            ['top' => 'top-1/4', 'side' => 'left-[10%]', 'duration' => '6s', 'delay' => '0s'],
            ['top' => 'top-1/3', 'side' => 'right-[15%]', 'duration' => '7s', 'delay' => '1s'],
            ['top' => 'bottom-1/4', 'side' => 'left-[20%]', 'duration' => '8s', 'delay' => '2s'],
            ['top' => 'bottom-1/3', 'side' => 'right-[12%]', 'duration' => '6.5s', 'delay' => '0.5s'],
        ];
        foreach ($floatingIcons as $index => $icon): 
            if ($index >= 4) break;
            $pos = $positions[$index];
        ?>
        <div class="absolute <?= $pos['top'] ?> <?= $pos['side'] ?> opacity-20 animate-float" style="animation-duration: <?= $pos['duration'] ?>; animation-delay: <?= $pos['delay'] ?>;">
            <i class="<?= htmlspecialchars($icon) ?> text-6xl text-white/80"></i>
        </div>
        <?php endforeach; ?>
    </div>
    
    <!-- Content -->
    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-4xl mx-auto text-center">
            <div class="inline-block bg-white/20 backdrop-blur-sm text-white px-4 py-2 rounded-full text-sm font-semibold mb-6 border border-white/30">
                <i class="fas fa-book mr-2"></i><?= htmlspecialchars($course['title']) ?>
            </div>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6">
                Master <?= htmlspecialchars($course['title']) ?>
            </h1>
            <p class="text-xl md:text-2xl text-white/90 mb-8">
                <?= htmlspecialchars($course['description'] ?? 'Enhance your skills with this comprehensive course') ?>
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <?php if ($isEnrolled): ?>
                    <a href="<?= url('/dashboard') ?>" class="bg-white text-<?= $buttonColor ?> px-8 py-4 rounded-lg font-semibold hover:bg-gray-100 transition inline-flex items-center shadow-lg hover:shadow-xl">
                        <i class="fas fa-arrow-right mr-2"></i>Continue Learning
                    </a>
                <?php else: ?>
                    <a href="#courses" class="bg-white text-primary px-8 py-4 rounded-lg font-semibold hover:bg-blue-50 transition inline-flex items-center shadow-lg hover:shadow-xl">
                        <i class="fas fa-rocket mr-2"></i>Browse Courses
                    </a>
                <?php endif; ?>
                <a href="<?= url('/register') ?>" class="bg-white/20 backdrop-blur-sm text-white px-8 py-4 rounded-lg font-semibold hover:bg-white/30 transition inline-flex items-center border-2 border-white/50 shadow-lg">
                    <i class="fas fa-user-plus mr-2"></i>Get Started Free
                </a>
            </div>

            <!-- Quick Stats -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-12">
                <div class="backdrop-blur-sm bg-white/10 rounded-lg p-4 border border-white/20">
                    <div class="text-3xl font-bold"><?= $course['card_modules'] ?? count($modules ?? []) ?>+</div>
                    <div class="text-white/70 text-sm">Modules</div>
                </div>
                <div class="backdrop-blur-sm bg-white/10 rounded-lg p-4 border border-white/20">
                    <div class="text-3xl font-bold"><?= number_format($course['enrollment_count'] ?? 0) ?>+</div>
                    <div class="text-white/70 text-sm">Students</div>
                </div>
                <div class="backdrop-blur-sm bg-white/10 rounded-lg p-4 border border-white/20">
                    <div class="text-3xl font-bold"><?= $course['duration_hours'] ?? '20' ?>+</div>
                    <div class="text-white/70 text-sm">Hours Content</div>
                </div>
                <div class="backdrop-blur-sm bg-white/10 rounded-lg p-4 border border-white/20">
                    <div class="text-3xl font-bold"><?= $course['success_rate'] ?? 95 ?>%</div>
                    <div class="text-white/70 text-sm">Success Rate</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Learning Path -->
<?php if (!empty($technologies)): ?>
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Your Learning Path</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Follow our structured curriculum from beginner to advanced <?= strtolower(htmlspecialchars($course['title'])) ?>
            </p>
        </div>

        <div class="max-w-5xl mx-auto">
            <div class="space-y-8">
                <?php 
                $levelColors = [
                    'beginner' => ['border' => 'border-green-500', 'bg' => 'bg-green-100', 'text' => 'text-green-600', 'badge-bg' => 'bg-green-100', 'badge-text' => 'text-green-700'],
                    'intermediate' => ['border' => 'border-blue-500', 'bg' => 'bg-blue-100', 'text' => 'text-blue-600', 'badge-bg' => 'bg-blue-100', 'badge-text' => 'text-blue-700'],
                    'advanced' => ['border' => 'border-purple-500', 'bg' => 'bg-purple-100', 'text' => 'text-purple-600', 'badge-bg' => 'bg-purple-100', 'badge-text' => 'text-purple-700'],
                ];
                $skillColors = [
                    ['bg' => 'bg-orange-100', 'text' => 'text-orange-700'],
                    ['bg' => 'bg-blue-100', 'text' => 'text-blue-700'],
                    ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-700'],
                    ['bg' => 'bg-purple-100', 'text' => 'text-purple-700'],
                    ['bg' => 'bg-pink-100', 'text' => 'text-pink-700'],
                    ['bg' => 'bg-green-100', 'text' => 'text-green-700'],
                    ['bg' => 'bg-red-100', 'text' => 'text-red-700'],
                    ['bg' => 'bg-teal-100', 'text' => 'text-teal-700'],
                ];
                
                foreach ($technologies as $index => $level):
                    $levelKey = $level['level'] ?? 'intermediate';
                    $colors = $levelColors[$levelKey] ?? $levelColors['intermediate'];
                ?>
                <div class="bg-white rounded-lg shadow-md p-6 border-l-4 <?= $colors['border'] ?>">
                    <div class="flex items-start gap-4">
                        <div class="<?= $colors['bg'] ?> <?= $colors['text'] ?> w-12 h-12 rounded-full flex items-center justify-center font-bold flex-shrink-0">
                            <?= $index + 1 ?>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-2">
                                <h3 class="text-xl font-bold text-gray-900"><?= htmlspecialchars($level['title'] ?? ucfirst($levelKey) . ' Level') ?></h3>
                                <span class="<?= $colors['badge-bg'] ?> <?= $colors['badge-text'] ?> px-3 py-1 rounded-full text-sm font-semibold"><?= htmlspecialchars($level['duration'] ?? '3-6 months') ?></span>
                            </div>
                            <p class="text-gray-600 mb-4"><?= htmlspecialchars($level['description'] ?? '') ?></p>
                            <?php if (!empty($level['skills'])): ?>
                            <div class="flex flex-wrap gap-2">
                                <?php foreach ($level['skills'] as $skillIndex => $skill): 
                                    $skillColor = $skillColors[$skillIndex % count($skillColors)];
                                ?>
                                <span class="<?= $skillColor['bg'] ?> <?= $skillColor['text'] ?> px-3 py-1 rounded-lg text-sm font-medium"><?= htmlspecialchars($skill) ?></span>
                                <?php endforeach; ?>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Skills You'll Gain -->
<?php if (!empty($skillsGained)): ?>
<section class="py-16">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Skills You'll Gain</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Develop in-demand skills that employers are looking for
            </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
            <?php 
            $borderColors = [
                'blue' => 'border-blue-500',
                'green' => 'border-green-500',
                'purple' => 'border-purple-500',
                'yellow' => 'border-yellow-500',
                'red' => 'border-red-500',
                'orange' => 'border-orange-500',
            ];
            $textColors = [
                'blue' => 'text-blue-600',
                'green' => 'text-green-600',
                'purple' => 'text-purple-600',
                'yellow' => 'text-yellow-600',
                'red' => 'text-red-600',
                'orange' => 'text-orange-600',
            ];
            
            foreach ($skillsGained as $skill): 
                $color = $skill['color'] ?? 'blue';
                $borderClass = $borderColors[$color] ?? 'border-blue-500';
                $textClass = $textColors[$color] ?? 'text-blue-600';
            ?>
            <div class="bg-white p-6 rounded-lg shadow-md border-t-4 <?= $borderClass ?>">
                <div class="<?= $textClass ?> text-4xl mb-4">
                    <i class="<?= htmlspecialchars($skill['icon'] ?? 'fas fa-check') ?>"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2"><?= htmlspecialchars($skill['title'] ?? '') ?></h3>
                <p class="text-gray-600"><?= htmlspecialchars($skill['description'] ?? '') ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Courses Listing / Bundle Pricing -->
<section id="courses" class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <!-- Bundle Pricing Banner -->
        <?php if (!empty($course['is_bundle'])): ?>
        <div class="max-w-4xl mx-auto mb-12">
            <div class="bg-gradient-to-r <?= $course['card_color_from'] ?? 'from-blue-600' ?> <?= $course['card_color_to'] ?? 'to-blue-700' ?> rounded-2xl p-8 text-white shadow-xl">
                <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                    <div class="flex-1 text-center md:text-left">
                        <h3 class="text-2xl md:text-3xl font-bold mb-2">Complete <?= htmlspecialchars($course['title']) ?> Bundle</h3>
                        <p class="text-white/90 mb-3">Get all courses + certifications + lifetime access</p>
                        <?php if (!empty($course['original_price']) && $course['original_price'] > $course['price']): 
                            $savings = $course['original_price'] - $course['price'];
                            $savingsPercent = round(($savings / $course['original_price']) * 100);
                        ?>
                        <div class="flex items-center gap-4 justify-center md:justify-start">
                            <span class="text-lg line-through text-white/70">GHS <?= number_format($course['original_price']) ?></span>
                            <span class="bg-green-500 text-white px-4 py-1 rounded-full font-bold text-sm">Save <?= $savingsPercent ?>%</span>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="text-center">
                        <div class="text-5xl font-bold mb-2">GHS <?= number_format($course['price'] ?? 0) ?></div>
                        <a href="<?= url('/courses/' . $course['slug'] . '/enroll') ?>" class="inline-block bg-white text-primary px-8 py-3 rounded-lg font-bold hover:bg-blue-50 transition shadow-lg">
                            Enroll in Bundle
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php if (!empty($subCourses)): ?>
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Individual Courses</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Or choose individual courses - each sold separately
            </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-7xl mx-auto">
            <?php foreach ($subCourses as $subCourse): ?>
            <?php 
                // Extract solid background color from gradient class (e.g., "from-orange-500" -> "bg-orange-500")
                $bgColor = 'bg-blue-500';
                if (!empty($subCourse['card_color_from'])) {
                    $bgColor = str_replace('from-', 'bg-', $subCourse['card_color_from']);
                }
            ?>
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                <div class="<?= $bgColor ?> h-48 flex items-center justify-center">
                    <?php if (!empty($subCourse['card_icon'])): ?>
                    <i class="<?= htmlspecialchars($subCourse['card_icon']) ?> text-white text-8xl"></i>
                    <?php else: ?>
                    <i class="fas fa-book text-white text-8xl opacity-80"></i>
                    <?php endif; ?>
                </div>
                <div class="p-6">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="bg-<?= $subCourse['level'] === 'beginner' ? 'green' : ($subCourse['level'] === 'intermediate' ? 'blue' : 'purple') ?>-100 text-<?= $subCourse['level'] === 'beginner' ? 'green' : ($subCourse['level'] === 'intermediate' ? 'blue' : 'purple') ?>-700 px-3 py-1 rounded-full text-sm font-semibold"><?= ucfirst($subCourse['level'] ?? 'Beginner') ?></span>
                        <span class="text-yellow-500">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <span class="text-gray-600 text-sm ml-1">(<?= number_format($subCourse['review_count'] ?? 0) ?>)</span>
                        </span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2"><?= htmlspecialchars($subCourse['title']) ?></h3>
                    <p class="text-gray-600 mb-4"><?= htmlspecialchars($subCourse['description'] ?? '') ?></p>
                    <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                        <span><i class="fas fa-clock mr-1"></i><?= $subCourse['duration_hours'] ?? '20' ?> hours</span>
                        <span><i class="fas fa-book mr-1"></i><?= $subCourse['card_modules'] ?? '10' ?> lessons</span>
                        <span><i class="fas fa-users mr-1"></i><?= number_format($subCourse['enrollment_count'] ?? 0) ?></span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="text-2xl font-bold text-primary">GHS <?= number_format($subCourse['price'] ?? 0) ?></div>
                        <a href="<?= url('/courses/' . $subCourse['slug'] . '/enroll') ?>" class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-primary/70 transition font-semibold">
                            Enroll Now
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php elseif (empty($modules)): ?>
        <!-- Show enrollment card if no modules/sub-courses -->
        <div class="max-w-xl mx-auto">
            <div class="bg-white rounded-xl shadow-xl border-2 border-primary/20 p-8">
                <div class="text-center mb-6 pb-6 border-b border-gray-200">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-primary to-primary/70 rounded-full mb-4">
                        <i class="fas fa-graduation-cap text-white text-2xl"></i>
                    </div>
                    <div class="text-5xl font-bold bg-gradient-to-r from-primary to-primary/80 bg-clip-text text-transparent mb-2">
                        GHS <?= number_format($course['price'] ?? 0) ?>
                    </div>
                    <p class="text-sm text-gray-600">One-time payment • Lifetime access</p>
                </div>

                <?php if ($isEnrolled): ?>
                    <a href="<?= url('/dashboard') ?>" 
                       class="block w-full bg-gradient-to-r from-green-500 to-green-600 text-white text-center px-6 py-4 rounded-lg font-bold hover:from-green-600 hover:to-green-700 transition mb-4 shadow-lg hover:shadow-xl">
                        <i class="fas fa-arrow-right mr-2"></i>
                        Continue Learning
                    </a>
                <?php else: ?>
                    <a href="<?= url('/courses/' . $course['slug'] . '/enroll') ?>" 
                       class="block w-full bg-gradient-to-r from-primary to-primary/80 text-white text-center px-6 py-4 rounded-lg font-bold hover:from-primary/90 hover:to-primary transition mb-4 shadow-lg hover:shadow-xl">
                        <i class="fas fa-user-plus mr-2"></i>
                        Enroll Now
                    </a>
                <?php endif; ?>

                <!-- Course Features -->
                <div class="space-y-4 pt-6 border-t border-gray-200">
                    <h3 class="font-bold text-gray-900 mb-4 text-center">This course includes:</h3>
                    
                    <div class="flex items-start gap-3 text-sm text-gray-700">
                        <div class="flex-shrink-0 w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-infinity text-purple-600"></i>
                        </div>
                        <div class="flex-1">
                            <div class="font-semibold text-gray-900">Lifetime Access</div>
                            <div class="text-xs text-gray-500">Learn at your own pace</div>
                        </div>
                    </div>
                    
                    <div class="flex items-start gap-3 text-sm text-gray-700">
                        <div class="flex-shrink-0 w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-mobile-alt text-green-600"></i>
                        </div>
                        <div class="flex-1">
                            <div class="font-semibold text-gray-900">Mobile Friendly</div>
                            <div class="text-xs text-gray-500">Access on any device</div>
                        </div>
                    </div>
                    
                    <div class="flex items-start gap-3 text-sm text-gray-700">
                        <div class="flex-shrink-0 w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-certificate text-yellow-600"></i>
                        </div>
                        <div class="flex-1">
                            <div class="font-semibold text-gray-900">Certificate</div>
                            <div class="text-xs text-gray-500">Upon completion</div>
                        </div>
                    </div>
                    
                    <div class="flex items-start gap-3 text-sm text-gray-700">
                        <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-robot text-blue-600"></i>
                        </div>
                        <div class="flex-1">
                            <div class="font-semibold text-gray-900">AI Assistance</div>
                            <div class="text-xs text-gray-500">Personalized feedback</div>
                        </div>
                    </div>
                    
                    <div class="flex items-start gap-3 text-sm text-gray-700">
                        <div class="flex-shrink-0 w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-code text-red-600"></i>
                        </div>
                        <div class="flex-1">
                            <div class="font-semibold text-gray-900">Projects</div>
                            <div class="text-xs text-gray-500">Hands-on practice</div>
                        </div>
                    </div>
                    
                    <div class="flex items-start gap-3 text-sm text-gray-700">
                        <div class="flex-shrink-0 w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-users text-orange-600"></i>
                        </div>
                        <div class="flex-1">
                            <div class="font-semibold text-gray-900">Community</div>
                            <div class="text-xs text-gray-500">Connect with peers</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- Career Outcomes -->
<section class="py-16">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">Career Outcomes</h2>
                    <p class="text-xl text-gray-600 mb-8">
                        Professionals with skills in <?= htmlspecialchars($course['title']) ?> are in high demand across industries. Our graduates work at:
                    </p>
                    
                    <div class="space-y-4">
                        <div class="flex items-start gap-4">
                            <div class="bg-green-100 text-green-600 w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-check"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 mb-1">Tech Companies</h4>
                                <p class="text-gray-600">Leading technology companies and innovative startups</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-4">
                            <div class="bg-green-100 text-green-600 w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-check"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 mb-1">Enterprises</h4>
                                <p class="text-gray-600">Fortune 500 companies and global organizations</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-4">
                            <div class="bg-green-100 text-green-600 w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-check"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 mb-1">Agencies</h4>
                                <p class="text-gray-600">Digital agencies and consulting firms worldwide</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-4">
                            <div class="bg-green-100 text-green-600 w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-check"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 mb-1">Freelancing</h4>
                                <p class="text-gray-600">Work independently with clients around the globe</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-blue-50 to-purple-50 rounded-lg p-8">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Career Growth</h3>
                    <div class="space-y-6">
                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <span class="font-semibold text-gray-900">Entry Level</span>
                                <span class="font-bold text-primary">Starting Career</span>
                            </div>
                            <div class="bg-gray-200 h-2 rounded-full overflow-hidden">
                                <div class="bg-green-500 h-full rounded-full" style="width: 40%"></div>
                            </div>
                        </div>
                        
                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <span class="font-semibold text-gray-900">Mid-Level</span>
                                <span class="font-bold text-primary">Growing Skills</span>
                            </div>
                            <div class="bg-gray-200 h-2 rounded-full overflow-hidden">
                                <div class="bg-blue-500 h-full rounded-full" style="width: 60%"></div>
                            </div>
                        </div>
                        
                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <span class="font-semibold text-gray-900">Senior Level</span>
                                <span class="font-bold text-primary">Expert Status</span>
                            </div>
                            <div class="bg-gray-200 h-2 rounded-full overflow-hidden">
                                <div class="bg-purple-500 h-full rounded-full" style="width: 80%"></div>
                            </div>
                        </div>
                        
                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <span class="font-semibold text-gray-900">Leadership</span>
                                <span class="font-bold text-primary">Industry Leader</span>
                            </div>
                            <div class="bg-gray-200 h-2 rounded-full overflow-hidden">
                                <div class="bg-red-500 h-full rounded-full" style="width: 100%"></div>
                            </div>
                        </div>
                    </div>
                    
                    <p class="text-sm text-gray-600 mt-6">
                        <i class="fas fa-info-circle mr-1"></i>
                        Career progression depends on continuous learning and hands-on experience
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Courses -->
<?php if (!empty($relatedCourses)): ?>
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Continue Your Learning Journey</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">Expand your skills with these related courses</p>
        </div>

        <div class="max-w-6xl mx-auto grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-8">
            <?php 
            $cardColors = [
                ['bg' => 'from-blue-500 to-blue-600', 'badge' => 'bg-blue-100 text-blue-700'],
                ['bg' => 'from-purple-500 to-purple-600', 'badge' => 'bg-purple-100 text-purple-700'],
                ['bg' => 'from-green-500 to-green-600', 'badge' => 'bg-green-100 text-green-700'],
            ];
            $colorIndex = 0;
            foreach (array_slice($relatedCourses, 0, 3) as $relatedCourse): 
                $cardColor = $cardColors[$colorIndex % count($cardColors)];
                $colorIndex++;
            ?>
            <a href="<?= url('/courses/' . $relatedCourse['slug']) ?>" 
               class="group bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 border border-gray-100">
                <!-- Course Image/Banner -->
                <div class="aspect-video bg-gradient-to-br <?= $relatedCourse['card_color_from'] ?? $cardColor['bg'] ?> <?= $relatedCourse['card_color_to'] ?? '' ?> flex items-center justify-center relative overflow-hidden">
                    <i class="fas fa-book text-white text-6xl opacity-30 group-hover:scale-110 transition-transform duration-500"></i>
                    <div class="absolute inset-0">
                        <div class="absolute top-0 left-1/4 w-1 h-full bg-white/20 transform -skew-x-12"></div>
                        <div class="absolute top-0 right-1/4 w-1 h-full bg-white/10 transform skew-x-12"></div>
                    </div>
                </div>

                <!-- Course Info -->
                <div class="p-6">
                    <div class="flex items-center justify-between mb-3">
                        <?php if (!empty($relatedCourse['level'])): ?>
                        <span class="inline-block text-xs font-bold <?= $cardColor['badge'] ?> px-3 py-1 rounded-full">
                            <?= ucfirst(htmlspecialchars($relatedCourse['level'])) ?>
                        </span>
                        <?php endif; ?>
                        
                        <?php if (!empty($relatedCourse['duration_hours'])): ?>
                        <span class="text-sm text-gray-500 flex items-center">
                            <i class="fas fa-clock mr-1"></i><?= htmlspecialchars($relatedCourse['duration_hours']) ?>h
                        </span>
                        <?php endif; ?>
                    </div>

                    <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-primary transition line-clamp-2 min-h-[3.5rem]">
                        <?= htmlspecialchars($relatedCourse['title']) ?>
                    </h3>

                    <?php if (!empty($relatedCourse['description'])): ?>
                    <p class="text-gray-600 text-sm mb-4 line-clamp-2 min-h-[2.5rem]">
                        <?= htmlspecialchars($relatedCourse['description']) ?>
                    </p>
                    <?php endif; ?>

                    <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                        <span class="text-lg font-bold text-primary">GHS <?= isset($relatedCourse['price']) ? number_format($relatedCourse['price'], 0) : '0' ?></span>
                        <span class="text-primary font-semibold group-hover:translate-x-1 transition-transform inline-flex items-center">
                            View Course <i class="fas fa-arrow-right ml-2"></i>
                        </span>
                    </div>
                </div>
            </a>
            <?php endforeach; ?>
        </div>

        <div class="max-w-6xl mx-auto text-center">
            <a href="<?= url('/courses') ?>" 
               class="inline-flex items-center text-primary hover:text-primary/80 font-semibold transition text-lg">
                View All Courses
                <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- CTA Section -->
<section class="bg-gradient-to-r <?= $course['card_color_from'] ?? 'from-primary' ?> <?= $course['card_color_to'] ?? 'to-primary/80' ?> text-white py-16">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-4">Ready to Start Your Learning Journey?</h2>
        <p class="text-xl text-white/90 mb-8 max-w-2xl mx-auto">
            Join thousands of students mastering <?= htmlspecialchars($course['title']) ?> with Nebatech AI Academy
        </p>
        <div class="flex flex-wrap justify-center gap-4">
            <?php if ($isEnrolled): ?>
                <a href="<?= url('/dashboard') ?>" class="bg-white text-primary px-8 py-4 rounded-lg font-semibold hover:bg-gray-100 transition inline-flex items-center shadow-lg">
                    <i class="fas fa-arrow-right mr-2"></i>Continue Learning
                </a>
            <?php else: ?>
                <a href="<?= url('/courses/' . $course['slug'] . '/enroll') ?>" class="bg-white text-primary px-8 py-4 rounded-lg font-semibold hover:bg-gray-100 transition inline-flex items-center shadow-lg">
                    <i class="fas fa-rocket mr-2"></i>Enroll Now
                </a>
            <?php endif; ?>
            <a href="<?= url('/contact') ?>" class="bg-white/20 backdrop-blur-sm text-white px-8 py-4 rounded-lg font-semibold hover:bg-white/30 transition inline-flex items-center border-2 border-white/50">
                <i class="fas fa-comment mr-2"></i>Talk to an Advisor
            </a>
        </div>
    </div>
</section>


