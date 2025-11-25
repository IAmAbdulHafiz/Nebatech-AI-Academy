<!-- Hero Section -->
    <?php
    // Determine color scheme based on course level
    $colorFrom = 'from-blue-900';
    $colorVia = 'via-blue-700';
    $colorTo = 'to-blue-600';
    $colorLight = 'blue-400';
    $colorPrimary = 'blue-500';
    $buttonColor = 'blue-600';
    
    if (!empty($course['level'])) {
        switch ($course['level']) {
            case 'beginner':
                $colorFrom = 'from-green-900';
                $colorVia = 'via-green-700';
                $colorTo = 'to-green-600';
                $colorLight = 'green-400';
                $colorPrimary = 'green-500';
                $buttonColor = 'green-600';
                break;
            case 'intermediate':
                $colorFrom = 'from-purple-900';
                $colorVia = 'via-purple-700';
                $colorTo = 'to-purple-600';
                $colorLight = 'purple-400';
                $colorPrimary = 'purple-500';
                $buttonColor = 'purple-600';
                break;
            case 'advanced':
                $colorFrom = 'from-red-900';
                $colorVia = 'via-red-700';
                $colorTo = 'to-red-600';
                $colorLight = 'red-400';
                $colorPrimary = 'red-500';
                $buttonColor = 'red-600';
                break;
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
            
            <!-- Floating Icons -->
            <div class="absolute top-1/4 left-[10%] opacity-20 animate-float" style="animation-duration: 6s;">
                <i class="fas fa-book text-6xl text-white/80"></i>
            </div>
            <div class="absolute top-1/3 right-[15%] opacity-20 animate-float" style="animation-duration: 7s; animation-delay: 1s;">
                <i class="fas fa-graduation-cap text-6xl text-white/70"></i>
            </div>
            <div class="absolute bottom-1/4 left-[20%] opacity-20 animate-float" style="animation-duration: 8s; animation-delay: 2s;">
                <i class="fas fa-code text-6xl text-white/80"></i>
            </div>
            <div class="absolute bottom-1/3 right-[12%] opacity-20 animate-float" style="animation-duration: 6.5s; animation-delay: 0.5s;">
                <i class="fas fa-laptop-code text-6xl text-white/70"></i>
            </div>
        </div>
        
        <!-- Content -->
        <div class="container mx-auto px-4 relative z-10">
            <div class="max-w-4xl mx-auto text-center">
                <div class="inline-block bg-white/20 backdrop-blur-sm text-white px-4 py-2 rounded-full text-sm font-semibold mb-6 border border-white/30">
                    <i class="fas fa-book mr-2"></i><?= ucfirst($course['level'] ?? 'Course') ?> Level
                </div>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6">
                    <?= htmlspecialchars($course['title']) ?>
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
                        <a href="#enroll" class="bg-white text-<?= $buttonColor ?> px-8 py-4 rounded-lg font-semibold hover:bg-gray-100 transition inline-flex items-center shadow-lg hover:shadow-xl">
                            <i class="fas fa-rocket mr-2"></i>Enroll Now
                        </a>
                    <?php endif; ?>
                    <a href="<?= url('/register') ?>" class="bg-white/20 backdrop-blur-sm text-white px-8 py-4 rounded-lg font-semibold hover:bg-white/30 transition inline-flex items-center border-2 border-white/50 shadow-lg">
                        <i class="fas fa-user-plus mr-2"></i>Get Started Free
                    </a>
                </div>

                <!-- Quick Stats -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-12">
                    <div class="backdrop-blur-sm bg-white/10 rounded-lg p-4 border border-white/20">
                        <div class="text-3xl font-bold"><?= count($modules) ?>+</div>
                        <div class="text-white/70 text-sm">Modules</div>
                    </div>
                    <div class="backdrop-blur-sm bg-white/10 rounded-lg p-4 border border-white/20">
                        <div class="text-3xl font-bold"><?= !empty($course['duration_hours']) ? $course['duration_hours'] : '20' ?>+</div>
                        <div class="text-white/70 text-sm">Hours Content</div>
                    </div>
                    <div class="backdrop-blur-sm bg-white/10 rounded-lg p-4 border border-white/20">
                        <div class="text-3xl font-bold">GHS <?= isset($course['price']) ? number_format($course['price'], 0) : '4,485' ?></div>
                        <div class="text-white/70 text-sm">Course Fee</div>
                    </div>
                    <div class="backdrop-blur-sm bg-white/10 rounded-lg p-4 border border-white/20">
                        <div class="text-3xl font-bold"><i class="fas fa-certificate"></i></div>
                        <div class="text-white/70 text-sm">Certificate</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Learning Path -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Your Learning Path</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Follow our structured curriculum designed to take you from beginner to expert
                </p>
            </div>

            <div class="max-w-5xl mx-auto">
                <?php if (empty($modules)): ?>
                    <div class="bg-white rounded-lg shadow-md p-8 text-center">
                        <i class="fas fa-book-open text-6xl text-gray-300 mb-4"></i>
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Comprehensive Curriculum Coming Soon</h3>
                        <p class="text-gray-600 mb-6">We're preparing detailed learning modules for this course. Enroll now to get notified!</p>
                        <a href="#enroll" class="inline-flex items-center bg-primary text-white px-8 py-3 rounded-lg font-semibold hover:bg-primary/80 transition">
                            <i class="fas fa-bell mr-2"></i>Get Notified
                        </a>
                    </div>
                <?php else: ?>
                    <div class="space-y-8">
                        <?php 
                        $levelColors = [
                            'beginner' => ['border' => 'border-green-500', 'bg' => 'bg-green-100', 'text' => 'text-green-600', 'badge-bg' => 'bg-green-100', 'badge-text' => 'text-green-700'],
                            'intermediate' => ['border' => 'border-blue-500', 'bg' => 'bg-blue-100', 'text' => 'text-blue-600', 'badge-bg' => 'bg-blue-100', 'badge-text' => 'text-blue-700'],
                            'advanced' => ['border' => 'border-purple-500', 'bg' => 'bg-purple-100', 'text' => 'text-purple-600', 'badge-bg' => 'bg-purple-100', 'badge-text' => 'text-purple-700'],
                        ];
                        
                        foreach ($modules as $index => $module):
                            // Determine level based on module order or default
                            $moduleLevel = 'intermediate';
                            if ($index < count($modules) / 3) {
                                $moduleLevel = 'beginner';
                            } elseif ($index >= 2 * count($modules) / 3) {
                                $moduleLevel = 'advanced';
                            }
                            $colors = $levelColors[$moduleLevel];
                        ?>
                        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 <?= $colors['border'] ?>">
                            <div class="flex items-start gap-4">
                                <div class="<?= $colors['bg'] ?> <?= $colors['text'] ?> w-12 h-12 rounded-full flex items-center justify-center font-bold flex-shrink-0">
                                    <?= $index + 1 ?>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-2">
                                        <h3 class="text-xl font-bold text-gray-900"><?= htmlspecialchars($module['title']) ?></h3>
                                        <span class="<?= $colors['badge-bg'] ?> <?= $colors['badge-text'] ?> px-3 py-1 rounded-full text-sm font-semibold capitalize"><?= $moduleLevel ?></span>
                                    </div>
                                    <?php if (!empty($module['description'])): ?>
                                    <p class="text-gray-600 mb-4"><?= htmlspecialchars($module['description']) ?></p>
                                    <?php endif; ?>
                                    
                                    <?php if (!empty($module['lessons'])): ?>
                                    <div class="flex flex-wrap gap-2">
                                        <?php foreach (array_slice($module['lessons'], 0, 5) as $lesson): ?>
                                        <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-lg text-sm font-medium">
                                            <?= htmlspecialchars($lesson['title']) ?>
                                        </span>
                                        <?php endforeach; ?>
                                        <?php if (count($module['lessons']) > 5): ?>
                                        <span class="text-gray-500 text-sm px-3 py-1">
                                            +<?= count($module['lessons']) - 5 ?> more topics
                                        </span>
                                        <?php endif; ?>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Skills You'll Gain -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Skills You'll Gain</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Develop in-demand skills that employers are looking for
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
                <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-blue-600">
                    <div class="text-blue-600 text-4xl mb-4">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Expert Knowledge</h3>
                    <p class="text-gray-600">Master core concepts and advanced techniques in <?= htmlspecialchars($course['title']) ?>.</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-green-500">
                    <div class="text-green-600 text-4xl mb-4">
                        <i class="fas fa-project-diagram"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Practical Projects</h3>
                    <p class="text-gray-600">Build real-world projects to strengthen your portfolio and showcase your abilities.</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-purple-500">
                    <div class="text-purple-600 text-4xl mb-4">
                        <i class="fas fa-tools"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Industry Tools</h3>
                    <p class="text-gray-600">Learn the latest tools and technologies used by professionals in the field.</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-yellow-500">
                    <div class="text-yellow-600 text-4xl mb-4">
                        <i class="fas fa-tachometer-alt"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Best Practices</h3>
                    <p class="text-gray-600">Apply industry standards and best practices for professional-quality work.</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-red-500">
                    <div class="text-red-600 text-4xl mb-4">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Problem Solving</h3>
                    <p class="text-gray-600">Develop critical thinking and problem-solving skills through challenges.</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-orange-500">
                    <div class="text-orange-600 text-4xl mb-4">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Collaboration</h3>
                    <p class="text-gray-600">Work effectively in teams using modern collaboration tools and workflows.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Course Details Section -->
    <section id="enroll" class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <div class="grid lg:grid-cols-3 gap-8">
                    <!-- Course Information -->
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 mb-8">
                            <h2 class="text-2xl font-bold text-gray-900 mb-6">
                                <i class="fas fa-info-circle text-primary mr-2"></i>
                                Course Information
                            </h2>
                            
                            <?php if (!empty($course['learning_objectives'])): ?>
                            <div class="mb-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-3">What You'll Learn:</h3>
                                <div class="prose max-w-none text-gray-700">
                                    <?= nl2br(htmlspecialchars($course['learning_objectives'])) ?>
                                </div>
                            </div>
                            <?php endif; ?>

                            <div class="grid md:grid-cols-2 gap-6 mt-6">
                                <div class="flex items-start gap-3">
                                    <i class="fas fa-check-circle text-green-500 text-xl mt-1"></i>
                                    <div>
                                        <h4 class="font-semibold text-gray-900">Lifetime Access</h4>
                                        <p class="text-sm text-gray-600">Learn at your own pace, forever</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-3">
                                    <i class="fas fa-check-circle text-green-500 text-xl mt-1"></i>
                                    <div>
                                        <h4 class="font-semibold text-gray-900">Mobile Friendly</h4>
                                        <p class="text-sm text-gray-600">Access on any device, anywhere</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-3">
                                    <i class="fas fa-check-circle text-green-500 text-xl mt-1"></i>
                                    <div>
                                        <h4 class="font-semibold text-gray-900">Certificate</h4>
                                        <p class="text-sm text-gray-600">Earn upon course completion</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-3">
                                    <i class="fas fa-check-circle text-green-500 text-xl mt-1"></i>
                                    <div>
                                        <h4 class="font-semibold text-gray-900">AI Assistance</h4>
                                        <p class="text-sm text-gray-600">Get personalized help</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="lg:col-span-1">
                        <!-- Enroll Card -->
                        <div id="enroll" class="bg-white rounded-xl shadow-xl border-2 border-primary/20 p-8 sticky top-24">
                            <div class="text-center mb-6 pb-6 border-b border-gray-200">
                                <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-primary to-primary/70 rounded-full mb-4">
                                    <i class="fas fa-graduation-cap text-white text-2xl"></i>
                                </div>
                                <div class="text-5xl font-bold bg-gradient-to-r from-primary to-primary/80 bg-clip-text text-transparent mb-2">
                                    GHS <?= isset($course['price']) ? number_format($course['price'], 0) : '4,485' ?>
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
                                <a href="<?= url('/register') ?>" 
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

                            <!-- Share Course -->
                            <div class="mt-6 pt-6 border-t border-gray-200">
                                <p class="text-sm font-semibold text-gray-700 mb-3 text-center">Share this course:</p>
                                <div class="flex gap-2">
                                    <a href="#" class="flex-1 bg-blue-600 text-white text-center py-3 rounded-lg hover:bg-blue-700 transition">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                    <a href="#" class="flex-1 bg-sky-500 text-white text-center py-3 rounded-lg hover:bg-sky-600 transition">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                    <a href="#" class="flex-1 bg-blue-700 text-white text-center py-3 rounded-lg hover:bg-blue-800 transition">
                                        <i class="fab fa-linkedin-in"></i>
                                    </a>
                                    <a href="#" class="flex-1 bg-green-600 text-white text-center py-3 rounded-lg hover:bg-green-700 transition">
                                        <i class="fab fa-whatsapp"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Related Courses -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Continue Your Learning Journey</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">Expand your skills with these related courses</p>
            </div>

            <?php if (!empty($relatedCourses)): ?>
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
                    <?php if (!empty($relatedCourse['thumbnail'])): ?>
                    <div class="aspect-video bg-gradient-to-br <?= $cardColor['bg'] ?> overflow-hidden relative">
                        <img src="<?= asset($relatedCourse['thumbnail']) ?>" 
                             alt="<?= htmlspecialchars($relatedCourse['title']) ?>"
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                    </div>
                    <?php else: ?>
                    <div class="aspect-video bg-gradient-to-br <?= $cardColor['bg'] ?> flex items-center justify-center relative overflow-hidden">
                        <i class="fas fa-book text-white text-6xl opacity-30 group-hover:scale-110 transition-transform duration-500"></i>
                        <div class="absolute inset-0">
                            <div class="absolute top-0 left-1/4 w-1 h-full bg-white/20 transform -skew-x-12"></div>
                            <div class="absolute top-0 right-1/4 w-1 h-full bg-white/10 transform skew-x-12"></div>
                        </div>
                    </div>
                    <?php endif; ?>

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
                            <span class="text-lg font-bold text-primary">GHS <?= isset($relatedCourse['price']) ? number_format($relatedCourse['price'], 0) : '4,485' ?></span>
                            <span class="text-primary font-semibold group-hover:translate-x-1 transition-transform inline-flex items-center">
                                View Course <i class="fas fa-arrow-right ml-2"></i>
                            </span>
                        </div>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <div class="text-center py-12">
                <i class="fas fa-graduation-cap text-6xl text-gray-300 mb-4"></i>
                <p class="text-gray-500 mb-6">Explore more courses to expand your knowledge</p>
            </div>
            <?php endif; ?>

            <div class="max-w-6xl mx-auto text-center">
                <a href="<?= url('/courses') ?>" 
                   class="inline-flex items-center text-primary hover:text-primary/80 font-semibold transition text-lg">
                    View All Courses
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
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

    <!-- CTA Section -->
    <section class="bg-gradient-to-r from-primary to-primary/80 text-white py-16">
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
                    <a href="<?= url('/register') ?>" class="bg-white text-primary px-8 py-4 rounded-lg font-semibold hover:bg-gray-100 transition inline-flex items-center shadow-lg">
                        <i class="fas fa-rocket mr-2"></i>Enroll Now
                    </a>
                <?php endif; ?>
                <a href="<?= url('/contact') ?>" class="bg-white/20 backdrop-blur-sm text-white px-8 py-4 rounded-lg font-semibold hover:bg-white/30 transition inline-flex items-center border-2 border-white/50">
                    <i class="fas fa-comment mr-2"></i>Talk to an Advisor
                </a>
            </div>
        </div>
    </section>


