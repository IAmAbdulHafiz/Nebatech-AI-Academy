<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= htmlspecialchars($course['description'] ?? '') ?>">
    <title><?= htmlspecialchars($title ?? 'Course Details') ?></title>
    
    <!-- Tailwind CSS -->
    <link href="<?= asset('css/main.css') ?>" rel="stylesheet">
    
    <!-- Alpine.js Collapse Plugin (must load before Alpine core) -->
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <!-- Alpine.js Core -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <?php include __DIR__ . '/../partials/header.php'; ?>

    <!-- Course Header -->
    <section class="bg-gradient-to-br from-purple-600 to-blue-600 text-white py-16">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                <!-- Breadcrumb -->
                <nav class="mb-6 text-sm">
                    <a href="<?= url('/') ?>" class="text-purple-200 hover:text-white transition">Home</a>
                    <span class="mx-2 text-purple-300">/</span>
                    <a href="<?= url('/courses') ?>" class="text-purple-200 hover:text-white transition">Courses</a>
                    <span class="mx-2 text-purple-300">/</span>
                    <span class="text-white"><?= htmlspecialchars($course['title']) ?></span>
                </nav>

                <!-- Category Badge -->
                <div class="mb-4">
                    <span class="inline-block bg-white/20 backdrop-blur-sm text-white px-4 py-2 rounded-full text-sm font-semibold">
                        <i class="fas fa-tag mr-2"></i><?= htmlspecialchars($course['category'] ?? 'General') ?>
                    </span>
                </div>

                <!-- Course Title -->
                <h1 class="text-4xl md:text-5xl font-bold mb-4">
                    <?= htmlspecialchars($course['title']) ?>
                </h1>

                <!-- Course Description -->
                <p class="text-xl text-purple-100 mb-6">
                    <?= htmlspecialchars($course['description'] ?? '') ?>
                </p>

                <!-- Course Meta -->
                <div class="flex flex-wrap gap-6 text-sm">
                    <?php if (!empty($course['level'])): ?>
                    <div class="flex items-center">
                        <i class="fas fa-signal mr-2 text-purple-300"></i>
                        <span class="capitalize"><?= htmlspecialchars($course['level']) ?></span>
                    </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($course['duration_hours'])): ?>
                    <div class="flex items-center">
                        <i class="fas fa-clock mr-2 text-purple-300"></i>
                        <span><?= htmlspecialchars($course['duration_hours']) ?> hours</span>
                    </div>
                    <?php endif; ?>
                    
                    <div class="flex items-center">
                        <i class="fas fa-book mr-2 text-purple-300"></i>
                        <span><?= count($modules) ?> Modules</span>
                    </div>

                    <?php if (!empty($course['status']) && $course['status'] === 'published'): ?>
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-2 text-green-300"></i>
                        <span>Published</span>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Enroll Button -->
                <div class="mt-8">
                    <?php if ($isEnrolled): ?>
                        <a href="<?= url('/dashboard') ?>" 
                           class="inline-flex items-center bg-green-500 text-white px-8 py-4 rounded-lg font-semibold hover:bg-green-600 transition shadow-lg">
                            <i class="fas fa-check-circle mr-2"></i>
                            You're Enrolled - Continue Learning
                        </a>
                    <?php else: ?>
                        <a href="<?= url('/register') ?>" 
                           class="inline-flex items-center bg-white text-purple-600 px-8 py-4 rounded-lg font-semibold hover:bg-purple-50 transition shadow-lg">
                            <i class="fas fa-rocket mr-2"></i>
                            Enroll Now - Start Learning
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Course Content -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <div class="grid lg:grid-cols-3 gap-8">
                    <!-- Main Content -->
                    <div class="lg:col-span-2">
                        <!-- What You'll Learn -->
                        <?php if (!empty($course['learning_objectives'])): ?>
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 mb-8">
                            <h2 class="text-2xl font-bold text-gray-900 mb-6">
                                <i class="fas fa-lightbulb text-yellow-500 mr-2"></i>
                                What You'll Learn
                            </h2>
                            <div class="prose max-w-none text-gray-700">
                                <?= nl2br(htmlspecialchars($course['learning_objectives'])) ?>
                            </div>
                        </div>
                        <?php endif; ?>

                        <!-- Course Curriculum -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
                            <h2 class="text-2xl font-bold text-gray-900 mb-6">
                                <i class="fas fa-list text-purple-600 mr-2"></i>
                                Course Curriculum
                            </h2>

                            <?php if (empty($modules)): ?>
                                <div class="text-center py-8 text-gray-500">
                                    <i class="fas fa-book-open text-4xl mb-4 opacity-50"></i>
                                    <p>Course modules are being prepared. Check back soon!</p>
                                </div>
                            <?php else: ?>
                                <div class="space-y-4" x-data="{ openModule: 0 }">
                                    <?php foreach ($modules as $index => $module): ?>
                                    <div class="border border-gray-200 rounded-lg overflow-hidden">
                                        <!-- Module Header -->
                                        <button @click="openModule = openModule === <?= $index ?> ? -1 : <?= $index ?>"
                                                class="w-full flex items-center justify-between p-5 bg-gray-50 hover:bg-gray-100 transition">
                                            <div class="flex items-center gap-4 text-left">
                                                <div class="flex-shrink-0 w-10 h-10 bg-purple-100 text-purple-600 rounded-lg flex items-center justify-center font-bold">
                                                    <?= $index + 1 ?>
                                                </div>
                                                <div>
                                                    <h3 class="font-semibold text-gray-900">
                                                        <?= htmlspecialchars($module['title']) ?>
                                                    </h3>
                                                    <?php if (!empty($module['description'])): ?>
                                                    <p class="text-sm text-gray-600 mt-1">
                                                        <?= htmlspecialchars(substr($module['description'], 0, 100)) ?>
                                                        <?= strlen($module['description']) > 100 ? '...' : '' ?>
                                                    </p>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <div class="flex items-center gap-4">
                                                <?php 
                                                $lessonCount = 0;
                                                if (!empty($module['lessons'])) {
                                                    $lessonCount = count($module['lessons']);
                                                }
                                                ?>
                                                <span class="text-sm text-gray-500">
                                                    <?= $lessonCount ?> lesson<?= $lessonCount !== 1 ? 's' : '' ?>
                                                </span>
                                                <i class="fas fa-chevron-down transition-transform"
                                                   :class="{ 'rotate-180': openModule === <?= $index ?> }"></i>
                                            </div>
                                        </button>

                                        <!-- Module Lessons -->
                                        <div x-show="openModule === <?= $index ?>" 
                                             x-collapse
                                             class="bg-white">
                                            <?php if (!empty($module['lessons'])): ?>
                                                <ul class="divide-y divide-gray-100">
                                                    <?php foreach ($module['lessons'] as $lesson): ?>
                                                    <li class="p-4 hover:bg-gray-50 transition">
                                                        <div class="flex items-center gap-3">
                                                            <?php
                                                            $iconClass = 'fa-file-alt';
                                                            $iconColor = 'text-blue-500';
                                                            
                                                            if (!empty($lesson['type'])) {
                                                                switch ($lesson['type']) {
                                                                    case 'video':
                                                                        $iconClass = 'fa-play-circle';
                                                                        $iconColor = 'text-red-500';
                                                                        break;
                                                                    case 'quiz':
                                                                        $iconClass = 'fa-question-circle';
                                                                        $iconColor = 'text-purple-500';
                                                                        break;
                                                                    case 'assignment':
                                                                        $iconClass = 'fa-code';
                                                                        $iconColor = 'text-green-500';
                                                                        break;
                                                                }
                                                            }
                                                            ?>
                                                            <i class="fas <?= $iconClass ?> <?= $iconColor ?>"></i>
                                                            <span class="text-gray-700"><?= htmlspecialchars($lesson['title']) ?></span>
                                                            
                                                            <?php if (!empty($lesson['duration'])): ?>
                                                            <span class="ml-auto text-sm text-gray-500">
                                                                <i class="fas fa-clock mr-1"></i>
                                                                <?= htmlspecialchars($lesson['duration']) ?>
                                                            </span>
                                                            <?php endif; ?>
                                                        </div>
                                                    </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            <?php else: ?>
                                                <p class="p-4 text-sm text-gray-500 italic">
                                                    Lessons coming soon...
                                                </p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="lg:col-span-1">
                        <!-- Enroll Card -->
                        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6 sticky top-24">
                            <div class="text-center mb-6">
                                <div class="text-4xl font-bold text-purple-600 mb-2">
                                    Free
                                </div>
                                <p class="text-sm text-gray-600">Full access to all content</p>
                            </div>

                            <?php if ($isEnrolled): ?>
                                <a href="<?= url('/dashboard') ?>" 
                                   class="block w-full bg-green-500 text-white text-center px-6 py-3 rounded-lg font-semibold hover:bg-green-600 transition mb-4">
                                    <i class="fas fa-arrow-right mr-2"></i>
                                    Continue Learning
                                </a>
                            <?php else: ?>
                                <a href="<?= url('/register') ?>" 
                                   class="block w-full bg-purple-600 text-white text-center px-6 py-3 rounded-lg font-semibold hover:bg-purple-700 transition mb-4">
                                    <i class="fas fa-user-plus mr-2"></i>
                                    Enroll Now
                                </a>
                            <?php endif; ?>

                            <!-- Course Features -->
                            <div class="space-y-3 pt-6 border-t border-gray-200">
                                <h3 class="font-semibold text-gray-900 mb-4">This course includes:</h3>
                                
                                <div class="flex items-center gap-3 text-sm text-gray-700">
                                    <i class="fas fa-infinity text-purple-500"></i>
                                    <span>Lifetime access</span>
                                </div>
                                
                                <div class="flex items-center gap-3 text-sm text-gray-700">
                                    <i class="fas fa-mobile-alt text-purple-500"></i>
                                    <span>Mobile friendly</span>
                                </div>
                                
                                <div class="flex items-center gap-3 text-sm text-gray-700">
                                    <i class="fas fa-certificate text-purple-500"></i>
                                    <span>Certificate of completion</span>
                                </div>
                                
                                <div class="flex items-center gap-3 text-sm text-gray-700">
                                    <i class="fas fa-robot text-purple-500"></i>
                                    <span>AI-powered feedback</span>
                                </div>
                                
                                <div class="flex items-center gap-3 text-sm text-gray-700">
                                    <i class="fas fa-code text-purple-500"></i>
                                    <span>Hands-on projects</span>
                                </div>
                                
                                <div class="flex items-center gap-3 text-sm text-gray-700">
                                    <i class="fas fa-users text-purple-500"></i>
                                    <span>Community support</span>
                                </div>
                            </div>

                            <!-- Share Course -->
                            <div class="mt-6 pt-6 border-t border-gray-200">
                                <p class="text-sm font-semibold text-gray-700 mb-3">Share this course:</p>
                                <div class="flex gap-2">
                                    <a href="#" class="flex-1 bg-blue-600 text-white text-center py-2 rounded hover:bg-blue-700 transition">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                    <a href="#" class="flex-1 bg-sky-500 text-white text-center py-2 rounded hover:bg-sky-600 transition">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                    <a href="#" class="flex-1 bg-blue-700 text-white text-center py-2 rounded hover:bg-blue-800 transition">
                                        <i class="fab fa-linkedin-in"></i>
                                    </a>
                                    <a href="#" class="flex-1 bg-green-600 text-white text-center py-2 rounded hover:bg-green-700 transition">
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
    <section class="py-16 bg-gray-100">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">More Courses You Might Like</h2>
                <p class="text-gray-600">Expand your skills with these related courses</p>
            </div>

            <?php if (!empty($relatedCourses)): ?>
            <div class="max-w-6xl mx-auto grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-8">
                <?php foreach (array_slice($relatedCourses, 0, 3) as $relatedCourse): ?>
                <a href="<?= url('/courses/' . $relatedCourse['slug']) ?>" 
                   class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg transition group">
                    <!-- Course Image -->
                    <?php if (!empty($relatedCourse['thumbnail'])): ?>
                    <div class="aspect-video bg-gradient-to-br from-purple-500 to-blue-500 overflow-hidden">
                        <img src="<?= asset($relatedCourse['thumbnail']) ?>" 
                             alt="<?= htmlspecialchars($relatedCourse['title']) ?>"
                             class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                    </div>
                    <?php else: ?>
                    <div class="aspect-video bg-gradient-to-br from-purple-500 to-blue-500 flex items-center justify-center">
                        <i class="fas fa-book text-white text-5xl opacity-50"></i>
                    </div>
                    <?php endif; ?>

                    <!-- Course Info -->
                    <div class="p-6">
                        <!-- Category -->
                        <?php if (!empty($relatedCourse['category'])): ?>
                        <span class="inline-block text-xs font-semibold text-purple-600 bg-purple-100 px-3 py-1 rounded-full mb-3">
                            <?= htmlspecialchars($relatedCourse['category']) ?>
                        </span>
                        <?php endif; ?>

                        <!-- Title -->
                        <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-purple-600 transition line-clamp-2">
                            <?= htmlspecialchars($relatedCourse['title']) ?>
                        </h3>

                        <!-- Description -->
                        <?php if (!empty($relatedCourse['description'])): ?>
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                            <?= htmlspecialchars($relatedCourse['description']) ?>
                        </p>
                        <?php endif; ?>

                        <!-- Meta Info -->
                        <div class="flex items-center gap-4 text-sm text-gray-500">
                            <?php if (!empty($relatedCourse['level'])): ?>
                            <span class="flex items-center gap-1">
                                <i class="fas fa-signal text-xs"></i>
                                <span class="capitalize"><?= htmlspecialchars($relatedCourse['level']) ?></span>
                            </span>
                            <?php endif; ?>
                            
                            <?php if (!empty($relatedCourse['duration_hours'])): ?>
                            <span class="flex items-center gap-1">
                                <i class="fas fa-clock text-xs"></i>
                                <span><?= htmlspecialchars($relatedCourse['duration_hours']) ?> hrs</span>
                            </span>
                            <?php endif; ?>
                        </div>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <div class="max-w-6xl mx-auto text-center">
                <a href="<?= url('/courses') ?>" 
                   class="inline-flex items-center text-purple-600 hover:text-purple-700 font-semibold transition">
                    Browse All Courses
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </section>

    <?php include __DIR__ . '/../partials/footer.php'; ?>
</body>
</html>
