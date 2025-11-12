<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?> - Nebatech</title>
    <meta name="description" content="<?= htmlspecialchars($description) ?>">
    <link href="<?= asset('css/main.css') ?>" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50">
    <?php include __DIR__ . '/../../partials/header.php'; ?>
    
    <!-- Programme Header -->
    <section class="bg-gradient-to-r from-primary to-blue-700 text-white py-12">
        <div class="container mx-auto px-6">
            <div class="max-w-6xl mx-auto">
                <div class="flex items-center gap-4 mb-4">
                    <a href="<?= url('/programmes') ?>" class="text-gray-200 hover:text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                    </a>
                    <h1 class="text-3xl md:text-4xl font-bold"><?= htmlspecialchars($programme['title']) ?></h1>
                </div>
                
                <div class="flex flex-wrap items-center gap-6 text-sm">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        <span><?= number_format($programme['enrollment_count']) ?> students enrolled</span>
                    </div>
                    <?php if (!empty($programme['first_name'])): ?>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span>By <?= htmlspecialchars($programme['first_name'] . ' ' . $programme['last_name']) ?></span>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Programme Content -->
    <section class="py-12 bg-white">
        <div class="container mx-auto px-6">
            <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2">
                    <div class="prose prose-lg max-w-none mb-8">
                        <?= $programme['description'] ?>
                    </div>

                    <!-- Curriculum -->
                    <?php if (!empty($modules)): ?>
                    <div class="mt-12">
                        <h2 class="text-3xl font-bold text-gray-800 mb-6">Course Curriculum</h2>
                        <div class="space-y-4">
                            <?php foreach ($modules as $index => $module): ?>
                            <div class="border-2 border-gray-200 rounded-lg overflow-hidden" x-data="{ open: <?= $index === 0 ? 'true' : 'false' ?> }">
                                <button @click="open = !open" class="w-full flex items-center justify-between p-4 bg-gray-50 hover:bg-gray-100 transition-colors">
                                    <div class="flex items-center gap-3">
                                        <span class="bg-primary text-white w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold">
                                            <?= $index + 1 ?>
                                        </span>
                                        <span class="font-bold text-gray-800"><?= htmlspecialchars($module['title']) ?></span>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <span class="text-sm text-gray-600"><?= $module['lesson_count'] ?> lessons</span>
                                        <svg class="w-5 h-5 text-gray-600 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </div>
                                </button>
                                <div x-show="open" x-collapse class="border-t border-gray-200">
                                    <div class="p-4 bg-white">
                                        <?php if (!empty($module['description'])): ?>
                                            <p class="text-gray-600 mb-4"><?= htmlspecialchars($module['description']) ?></p>
                                        <?php endif; ?>
                                        <?php if (!empty($module['lessons'])): ?>
                                            <ul class="space-y-2">
                                                <?php foreach ($module['lessons'] as $lesson): ?>
                                                <li class="flex items-center gap-3 text-gray-700">
                                                    <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                    <span><?= htmlspecialchars($lesson['title']) ?></span>
                                                    <?php if (!empty($lesson['duration'])): ?>
                                                        <span class="text-sm text-gray-500">(<?= $lesson['duration'] ?> min)</span>
                                                    <?php endif; ?>
                                                </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <div class="sticky top-6">
                        <div class="bg-white border-2 border-gray-200 rounded-xl p-6 shadow-lg">
                            <div class="text-center mb-6">
                                <div class="text-5xl mb-4">📚</div>
                                <h3 class="text-2xl font-bold text-gray-800 mb-2">Enroll Now</h3>
                                <p class="text-gray-600">Start your learning journey today</p>
                            </div>

                            <?php if ($isEnrolled): ?>
                                <a href="<?= url('/courses/' . $programme['slug']) ?>" 
                                   class="block w-full bg-green-600 hover:bg-green-700 text-white font-bold px-6 py-3 rounded-lg transition-colors text-center mb-4">
                                    Continue Learning
                                </a>
                                <p class="text-center text-sm text-gray-600">You are enrolled in this programme</p>
                            <?php else: ?>
                                <?php if (isset($_SESSION['user_id'])): ?>
                                    <form action="<?= url('/programmes/' . $programme['id'] . '/enroll') ?>" method="POST">
                                        <button type="submit" 
                                                class="block w-full bg-primary hover:bg-blue-700 text-white font-bold px-6 py-3 rounded-lg transition-colors text-center mb-4">
                                            Enroll Now
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <a href="<?= url('/register') ?>" 
                                       class="block w-full bg-primary hover:bg-blue-700 text-white font-bold px-6 py-3 rounded-lg transition-colors text-center mb-4">
                                        Create Account to Enroll
                                    </a>
                                    <p class="text-center text-sm text-gray-600 mb-2">Already have an account?</p>
                                    <a href="<?= url('/login') ?>" class="block text-center text-primary hover:text-blue-700 font-semibold">
                                        Sign In
                                    </a>
                                <?php endif; ?>
                            <?php endif; ?>

                            <div class="mt-6 pt-6 border-t border-gray-200 space-y-3 text-sm">
                                <div class="flex items-center gap-3">
                                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span class="text-gray-700">Self-paced learning</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                    </svg>
                                    <span class="text-gray-700">Certificate upon completion</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                    <span class="text-gray-700">Lifetime access</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                                    </svg>
                                    <span class="text-gray-700">Expert support</span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 bg-blue-50 border-2 border-blue-200 rounded-xl p-6">
                            <h4 class="font-bold text-gray-800 mb-2">Need Help?</h4>
                            <p class="text-sm text-gray-600 mb-4">Have questions about this programme?</p>
                            <a href="<?= url('/contact') ?>" class="text-primary hover:text-blue-700 font-semibold text-sm">
                                Contact Us →
                            </a>
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
            <div class="max-w-6xl mx-auto">
                <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">Related Programmes</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <?php foreach ($relatedProgrammes as $related): ?>
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-shadow">
                        <div class="h-32 bg-gradient-to-br from-primary to-blue-700 flex items-center justify-center text-white">
                            <div class="text-4xl">📚</div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-lg font-bold mb-2 text-gray-800"><?= htmlspecialchars($related['title']) ?></h3>
                            <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                <?= htmlspecialchars(substr(strip_tags($related['description']), 0, 100)) ?>...
                            </p>
                            <a href="<?= url('/programmes/' . $related['slug']) ?>" 
                               class="text-primary hover:text-blue-700 font-semibold inline-flex items-center">
                                View Programme 
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <?php include __DIR__ . '/../../partials/footer.php'; ?>
</body>
</html>
