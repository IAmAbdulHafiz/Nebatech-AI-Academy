<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Community - Nebatech AI Academy</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= asset('images/favicon.ico') ?>">
    
    <!-- Tailwind CSS -->
    <link href="<?= asset('css/main.css') ?>" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="<?= asset('js/theme-toggle.js') ?>"></script>
</head>
<body class="bg-gray-50 dark:bg-gray-900">
<?php include __DIR__ . '/../partials/header.php'; ?>

<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <!-- Community Hero -->
    <section class="relative bg-gradient-to-br from-primary via-primary/90 to-primary/80 text-white py-20 overflow-hidden">
        <!-- Digital Horizon Background -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <!-- Animated Glowing Orbs -->
            <div class="absolute top-20 left-10 w-72 h-72 bg-primary/40 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse"></div>
            <div class="absolute top-40 right-10 w-72 h-72 bg-primary/50 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse" style="animation-delay: 2s;"></div>
            <div class="absolute bottom-20 left-1/2 w-72 h-72 bg-primary/60 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse" style="animation-delay: 4s;"></div>
            
            <!-- Geometric Light Beams -->
            <div class="absolute top-0 left-1/4 w-px h-full bg-gradient-to-b from-transparent via-white/20 to-transparent animate-pulse" style="animation-duration: 3s;"></div>
            <div class="absolute top-0 right-1/3 w-px h-full bg-gradient-to-b from-transparent via-white/20 to-transparent animate-pulse" style="animation-duration: 5s; animation-delay: 1s;"></div>
            
            <!-- Floating Icons -->
            <div class="absolute top-24 left-1/4 text-white/20 animate-float" style="animation-duration: 6s;">
                <i class="fas fa-users text-4xl"></i>
            </div>
            <div class="absolute top-32 right-1/4 text-white/20 animate-float" style="animation-duration: 8s; animation-delay: 1s;">
                <i class="fas fa-comments text-3xl"></i>
            </div>
            <div class="absolute bottom-32 left-1/3 text-white/20 animate-float" style="animation-duration: 7s; animation-delay: 2s;">
                <i class="fas fa-heart text-3xl"></i>
            </div>
            <div class="absolute top-1/2 left-12 text-white/20 animate-float" style="animation-duration: 9s;">
                <i class="fas fa-globe text-4xl"></i>
            </div>
            <div class="absolute bottom-24 right-16 text-white/20 animate-float" style="animation-duration: 8s; animation-delay: 3s;">
                <i class="fas fa-handshake text-3xl"></i>
            </div>
        </div>
        
        <div class="container mx-auto px-6 text-center relative z-10">
            <div class="inline-block bg-white/10 backdrop-blur-sm px-6 py-2 rounded-full text-white text-sm font-semibold mb-6 border border-white/30">
                <i class="fas fa-users mr-2"></i>Active Learning Community
            </div>
            
            <h1 class="text-4xl md:text-6xl font-bold mb-6">
                Join Our Active Learning Community
            </h1>
            
            <p class="text-xl md:text-2xl text-white/90 max-w-3xl mx-auto mb-8">
                Connect with <?= number_format($stats['total_members']) ?>+ students, share resources, and grow together in a vibrant tech community 🌍
            </p>
            
            <!-- Stats Grid -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-12">
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/20">
                    <div class="text-4xl font-bold mb-2"><?= number_format($stats['total_members']) ?>+</div>
                    <div class="text-white/90">Active Members</div>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/20">
                    <div class="text-4xl font-bold mb-2"><?= number_format($stats['total_posts']) ?>+</div>
                    <div class="text-white/90">Discussions</div>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/20">
                    <div class="text-4xl font-bold mb-2">50+</div>
                    <div class="text-white/90">Study Groups</div>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/20">
                    <div class="text-4xl font-bold mb-2">24/7</div>
                    <div class="text-white/90">Active Support</div>
                </div>
            </div>
        </div>
    </section>

    <div class="container mx-auto px-6 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Search & Create Post -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                    <div class="flex flex-col sm:flex-row gap-4">
                        <input type="text" 
                               placeholder="Search discussions..." 
                               class="flex-1 px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white"
                               id="communitySearch">
                        <a href="<?= url('/community/create') ?>" 
                           class="bg-secondary hover:bg-orange-600 text-white font-bold px-6 py-3 rounded-lg transition-colors whitespace-nowrap text-center flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            Start Discussion
                        </a>
                    </div>
                </div>

                <!-- Categories Grid -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/></svg>
                        Browse Categories
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <?php 
                        $categoryIcons = [
                            'general' => '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>',
                            'qa' => '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
                            'career-jobs' => '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>',
                            'projects-showcase' => '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>',
                            'resources' => '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>',
                            'announcements' => '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>'
                        ];
                        
                        foreach ($categories as $category): 
                            $icon = $categoryIcons[$category['slug']] ?? '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/></svg>';
                        ?>
                            <a href="<?= url("/community/category/{$category['slug']}") ?>" 
                               class="group flex items-start gap-4 p-4 border-2 border-gray-200 dark:border-gray-700 rounded-lg hover:border-<?= $category['color'] ?>-500 hover:bg-<?= $category['color'] ?>-50 dark:hover:bg-<?= $category['color'] ?>-900/20 transition-all">
                                <div class="flex-shrink-0 w-16 h-16 bg-<?= $category['color'] ?>-100 dark:bg-<?= $category['color'] ?>-900/30 rounded-lg flex items-center justify-center text-<?= $category['color'] ?>-600 dark:text-<?= $category['color'] ?>-400 group-hover:bg-<?= $category['color'] ?>-200 dark:group-hover:bg-<?= $category['color'] ?>-900/50 transition-colors">
                                    <?= $icon ?>
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-bold text-gray-900 dark:text-white group-hover:text-<?= $category['color'] ?>-600 mb-1">
                                        <?= htmlspecialchars($category['name']) ?>
                                    </h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-2"><?= htmlspecialchars($category['description']) ?></p>
                                    <div class="text-xs text-gray-500">
                                        <?= number_format($category['posts_count']) ?> discussions
                                    </div>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Trending Posts -->
                <?php if (!empty($trendingPosts)): ?>
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                        <svg class="w-7 h-7 text-orange-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 23a7.5 7.5 0 01-5.138-12.963C8.204 8.774 11.5 6.5 11 1.5c6 4 9 8 3 14 1 0 2.5 0 5-2.47.27.773.5 1.604.5 2.47A7.5 7.5 0 0112 23z"/></svg>
                        Trending This Week
                    </h2>
                    <div class="space-y-3">
                        <?php foreach ($trendingPosts as $post): ?>
                            <a href="<?= url("/community/post/{$post['uuid']}") ?>" 
                               class="block p-4 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <div class="flex items-start justify-between gap-4">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 mb-2">
                                            <span class="inline-block px-2 py-1 text-xs font-semibold rounded" style="background-color: <?= $post['category_color'] ?>33; color: <?= $post['category_color'] ?>">
                                                <?= htmlspecialchars($post['category_name']) ?>
                                            </span>
                                            <?php if ($post['is_solved']): ?>
                                                <span class="text-green-600 text-xs flex items-center gap-1">
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                                    Solved
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                        <h3 class="font-semibold text-gray-900 dark:text-white mb-1">
                                            <?= htmlspecialchars($post['title']) ?>
                                        </h3>
                                        <div class="flex items-center gap-4 text-sm text-gray-600 dark:text-gray-400">
                                            <span class="flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                                <?= number_format($post['views_count']) ?>
                                            </span>
                                            <span class="flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                                                <?= number_format($post['comments_count']) ?>
                                            </span>
                                            <span class="flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                                                <?= number_format($post['likes_count']) ?>
                                            </span>
                                        </div>
                                    </div>
                                    <img src="<?= $post['avatar'] ?? '/assets/images/default-avatar.png' ?>" 
                                         alt="<?= htmlspecialchars($post['first_name']) ?>" 
                                         class="w-10 h-10 rounded-full">
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Recent Discussions -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                        Recent Discussions
                    </h2>
                    <div class="space-y-4">
                        <?php foreach ($recentPosts as $post): ?>
                            <div class="flex gap-4 p-4 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <img src="<?= $post['avatar'] ?? '/assets/images/default-avatar.png' ?>" 
                                     alt="<?= htmlspecialchars($post['first_name']) ?>" 
                                     class="w-12 h-12 rounded-full flex-shrink-0">
                                
                                <div class="flex-1 min-w-0">
                                    <a href="<?= url("/community/post/{$post['uuid']}") ?>" 
                                       class="block hover:text-primary">
                                        <div class="flex items-center gap-2 mb-1">
                                            <?php if ($post['is_pinned']): ?>
                                                <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a1 1 0 011 1v1.323l3.954 1.582 1.599-.8a1 1 0 01.894 1.79l-1.233.616 1.738 5.42a1 1 0 01-.285 1.05A3.989 3.989 0 0115 15a3.989 3.989 0 01-2.667-1.019 1 1 0 01-.285-1.05l1.715-5.349L11 6.477V16h2a1 1 0 110 2H7a1 1 0 110-2h2V6.477L6.237 7.582l1.715 5.349a1 1 0 01-.285 1.05A3.989 3.989 0 015 15a3.989 3.989 0 01-2.667-1.019 1 1 0 01-.285-1.05l1.738-5.42-1.233-.617a1 1 0 01.894-1.788l1.599.799L9 4.323V3a1 1 0 011-1z"/></svg>
                                            <?php endif; ?>
                                            <h3 class="font-semibold text-gray-900 dark:text-white truncate">
                                                <?= htmlspecialchars($post['title']) ?>
                                            </h3>
                                        </div>
                                    </a>
                                    
                                    <div class="flex items-center gap-3 text-sm text-gray-600 dark:text-gray-400 mb-2">
                                        <span><?= htmlspecialchars($post['first_name'] . ' ' . $post['last_name']) ?></span>
                                        <span>•</span>
                                        <span><?= date('M j, Y', strtotime($post['created_at'])) ?></span>
                                        <span class="inline-block px-2 py-0.5 text-xs rounded" style="background-color: <?= $post['category_color'] ?>33; color: <?= $post['category_color'] ?>">
                                            <?= htmlspecialchars($post['category_name']) ?>
                                        </span>
                                    </div>
                                    
                                    <div class="flex items-center gap-4 text-sm text-gray-500 dark:text-gray-400">
                                        <span class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            <?= number_format($post['views_count']) ?>
                                        </span>
                                        <span class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                                            <?= number_format($post['comments_count']) ?>
                                        </span>
                                        <span class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                                            <?= number_format($post['likes_count']) ?>
                                        </span>
                                        <?php if ($post['is_solved']): ?>
                                            <span class="text-green-600 flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                                Solved
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="mt-6 text-center">
                        <a href="<?= url('/community/discussions') ?>" 
                           class="text-primary hover:text-primary font-semibold">
                            View All Discussions →
                        </a>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Leaderboard -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                            <svg class="w-6 h-6 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            Top Contributors
                        </h3>
                        <a href="<?= url('/community/leaderboard') ?>" class="text-sm text-primary hover:underline">View All</a>
                    </div>
                    <div class="space-y-3">
                        <?php foreach ($leaderboard as $index => $user): ?>
                            <div class="flex items-center gap-3">
                                <div class="text-2xl font-bold <?= $index === 0 ? 'text-yellow-500' : ($index === 1 ? 'text-gray-400' : ($index === 2 ? 'text-orange-600' : 'text-gray-500')) ?>">
                                    #<?= $index + 1 ?>
                                </div>
                                <img src="<?= $user['avatar'] ?? '/assets/images/default-avatar.png' ?>" 
                                     alt="<?= htmlspecialchars($user['first_name']) ?>" 
                                     class="w-10 h-10 rounded-full">
                                <div class="flex-1 min-w-0">
                                    <div class="font-semibold text-gray-900 dark:text-white truncate">
                                        <?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?>
                                    </div>
                                    <div class="text-sm text-gray-600 dark:text-gray-400 flex items-center gap-2">
                                        <span class="flex items-center gap-1">
                                            <svg class="w-4 h-4 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"><path d="M11 3a1 1 0 10-2 0v1a1 1 0 102 0V3zM15.657 5.757a1 1 0 00-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707zM18 10a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zM5.05 6.464A1 1 0 106.464 5.05l-.707-.707a1 1 0 00-1.414 1.414l.707.707zM5 10a1 1 0 01-1 1H3a1 1 0 110-2h1a1 1 0 011 1zM8 16v-1h4v1a2 2 0 11-4 0zM12 14c.015-.34.208-.646.477-.859a4 4 0 10-4.954 0c.27.213.462.519.476.859h4.002z"/></svg>
                                            <?= number_format($user['total_xp']) ?> XP
                                        </span>
                                        •
                                        <span class="flex items-center gap-1">
                                            <svg class="w-4 h-4 text-purple-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/></svg>
                                            <?= $user['badges_count'] ?> badges
                                        </span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Upcoming Events -->
                <?php if (!empty($upcomingEvents)): ?>
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6 text-primary/90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Upcoming Events
                    </h3>
                    <div class="space-y-4">
                        <?php foreach ($upcomingEvents as $event): ?>
                            <div class="p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
                                <h4 class="font-semibold text-gray-900 dark:text-white mb-2">
                                    <?= htmlspecialchars($event['title']) ?>
                                </h4>
                                <div class="text-sm text-gray-600 dark:text-gray-400 space-y-1">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        <?= date('M j, Y', strtotime($event['start_time'])) ?>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        <?= date('g:i A', strtotime($event['start_time'])) ?>
                                    </div>
                                </div>
                                <a href="<?= url("/community/events/{$event['uuid']}") ?>" 
                                   class="mt-2 inline-block text-primary hover:underline text-sm font-semibold">
                                    Learn More →
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Active Users -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        Active This Week
                    </h3>
                    <div class="flex flex-wrap gap-2">
                        <?php foreach ($activeUsers as $user): ?>
                            <a href="<?= url("/community/profile/{$user['id']}") ?>" 
                               class="relative group" 
                               title="<?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?> (<?= number_format($user['total_xp']) ?> XP)">
                                <img src="<?= $user['avatar'] ?? '/assets/images/default-avatar.png' ?>" 
                                     alt="<?= htmlspecialchars($user['first_name']) ?>" 
                                     class="w-10 h-10 rounded-full border-2 border-green-500 hover:scale-110 transition-transform">
                                <div class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 rounded-full border-2 border-white dark:border-gray-800"></div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Community Guidelines -->
                <div class="bg-gradient-to-br from-blue-50 to-purple-50 dark:from-blue-900/20 dark:to-purple-900/20 rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-3 flex items-center gap-2">
                        <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        Community Guidelines
                    </h3>
                    <ul class="text-sm text-gray-700 dark:text-gray-300 space-y-2">
                        <li class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            <span>Be respectful and supportive</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            <span>Share knowledge and help others</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            <span>Give constructive feedback</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-red-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                            <span>No spam or self-promotion</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-red-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                            <span>No harassment or hate speech</span>
                        </li>
                    </ul>
                    <a href="<?= url('/community/guidelines') ?>" 
                       class="mt-3 inline-block text-primary hover:underline text-sm font-semibold">
                        Read Full Guidelines →
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Search functionality
document.getElementById('communitySearch')?.addEventListener('input', function(e) {
    const query = e.target.value;
    if (query.length >= 3) {
        // Implement search (AJAX call to /community/search)
        console.log('Searching for:', query);
    }
});
</script>

<?php include __DIR__ . '/../partials/footer.php'; ?>
</body>
</html>
