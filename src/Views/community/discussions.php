<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Discussions - Nebatech AI Academy</title>
    
    <link rel="icon" type="image/x-icon" href="<?= asset('images/favicon.ico') ?>">
    <link href="<?= asset('css/main.css') ?>" rel="stylesheet">
    
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="<?= asset('js/theme-toggle.js') ?>"></script>
</head>
<body class="bg-gray-50 dark:bg-gray-900">
<?php include __DIR__ . '/../partials/header.php'; ?>

<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8 flex items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2 flex items-center gap-3">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                </svg>
                All Discussions
            </h1>
            <p class="text-gray-600 dark:text-gray-400">
                Browse all community discussions and conversations
            </p>
        </div>
        <a href="<?= url('/community/create') ?>" 
           class="bg-primary hover:bg-primary-dark text-white font-semibold px-6 py-2 rounded-lg transition-colors whitespace-nowrap flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            Start Discussion
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- Filters Sidebar -->
        <div class="lg:col-span-1">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 sticky top-4">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Filters</h2>
                
                <!-- Category Filter -->
                <div class="mb-6">
                    <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Category</h3>
                    <div class="space-y-2">
                        <a href="<?= url('/community/discussions') ?>" 
                           class="block px-3 py-2 rounded-lg <?= !$categoryId ? 'bg-primary text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' ?> transition-colors">
                            All Categories
                        </a>
                        <?php foreach ($categories as $cat): ?>
                        <a href="<?= url('/community/discussions?category=' . $cat['id']) ?>" 
                           class="block px-3 py-2 rounded-lg <?= $categoryId == $cat['id'] ? 'bg-primary text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' ?> transition-colors">
                            <?= htmlspecialchars($cat['name']) ?>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Post Type Filter -->
                <div class="mb-6">
                    <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Post Type</h3>
                    <div class="space-y-2">
                        <a href="<?= url('/community/discussions') ?>" 
                           class="block px-3 py-2 rounded-lg <?= !$postType ? 'bg-primary text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' ?> transition-colors">
                            All Types
                        </a>
                        <a href="<?= url('/community/discussions?type=question') ?>" 
                           class="block px-3 py-2 rounded-lg <?= $postType == 'question' ? 'bg-primary text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' ?> transition-colors">
                            Questions
                        </a>
                        <a href="<?= url('/community/discussions?type=discussion') ?>" 
                           class="block px-3 py-2 rounded-lg <?= $postType == 'discussion' ? 'bg-primary text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' ?> transition-colors">
                            Discussions
                        </a>
                        <a href="<?= url('/community/discussions?type=project') ?>" 
                           class="block px-3 py-2 rounded-lg <?= $postType == 'project' ? 'bg-primary text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' ?> transition-colors">
                            Projects
                        </a>
                    </div>
                </div>

                <!-- Sort Options -->
                <div>
                    <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Sort By</h3>
                    <div class="space-y-2">
                        <a href="<?= url('/community/discussions?sort=recent') ?>" 
                           class="block px-3 py-2 rounded-lg <?= $sort == 'recent' ? 'bg-primary text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' ?> transition-colors">
                            Most Recent
                        </a>
                        <a href="<?= url('/community/discussions?sort=popular') ?>" 
                           class="block px-3 py-2 rounded-lg <?= $sort == 'popular' ? 'bg-primary text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' ?> transition-colors">
                            Most Popular
                        </a>
                        <a href="<?= url('/community/discussions?sort=trending') ?>" 
                           class="block px-3 py-2 rounded-lg <?= $sort == 'trending' ? 'bg-primary text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' ?> transition-colors">
                            Trending
                        </a>
                        <a href="<?= url('/community/discussions?sort=unanswered') ?>" 
                           class="block px-3 py-2 rounded-lg <?= $sort == 'unanswered' ? 'bg-primary text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' ?> transition-colors">
                            Unanswered
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Discussions List -->
        <div class="lg:col-span-3">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md divide-y divide-gray-200 dark:divide-gray-700">
                <?php if (empty($posts)): ?>
                <div class="p-12 text-center">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-400 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No discussions found</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">Be the first to start a conversation!</p>
                    <a href="<?= url('/community/create') ?>" 
                       class="inline-flex items-center gap-2 bg-primary text-white px-6 py-2 rounded-lg hover:bg-primary-dark transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Start Discussion
                    </a>
                </div>
                <?php else: ?>
                    <?php foreach ($posts as $post): ?>
                    <div class="p-6 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                        <div class="flex gap-4">
                            <!-- User Avatar -->
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 rounded-full bg-primary flex items-center justify-center text-white font-bold">
                                    <?= strtoupper(substr($post['first_name'], 0, 1) . substr($post['last_name'], 0, 1)) ?>
                                </div>
                            </div>

                            <!-- Post Content -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between gap-4 mb-2">
                                    <div>
                                        <a href="<?= url('/community/post/' . $post['uuid']) ?>" 
                                           class="text-lg font-semibold text-gray-900 dark:text-white hover:text-primary dark:hover:text-primary transition-colors">
                                            <?php if ($post['is_pinned']): ?>
                                                <svg class="w-5 h-5 inline text-yellow-500" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M16 12V4h1c.55 0 1-.45 1-1s-.45-1-1-1H7c-.55 0-1 .45-1 1s.45 1 1 1h1v8l-2 2v2h5.2v6h1.6v-6H18v-2l-2-2z"/>
                                                </svg>
                                            <?php endif; ?>
                                            <?= htmlspecialchars($post['title']) ?>
                                        </a>
                                        <div class="flex items-center gap-3 mt-1 text-sm text-gray-600 dark:text-gray-400">
                                            <span><?= htmlspecialchars($post['first_name'] . ' ' . $post['last_name']) ?></span>
                                            <span>•</span>
                                            <span><?= date('M j, Y', strtotime($post['created_at'])) ?></span>
                                            <span>•</span>
                                            <a href="<?= url('/community/category/' . $post['category_slug']) ?>" 
                                               class="px-2 py-1 rounded text-xs font-medium hover:opacity-80 transition-opacity"
                                               style="background-color: <?= htmlspecialchars($post['category_color']) ?>20; color: <?= htmlspecialchars($post['category_color']) ?>">
                                                <?= htmlspecialchars($post['category_name']) ?>
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Post Type Badge -->
                                    <div class="flex-shrink-0">
                                        <?php
                                        $typeColors = [
                                            'question' => 'bg-blue-100 text-blue-800 dark:bg-primary/90/30 dark:text-primary/80',
                                            'discussion' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400',
                                            'project' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                                            'resource' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
                                        ];
                                        $colorClass = $typeColors[$post['post_type']] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400';
                                        ?>
                                        <span class="px-3 py-1 rounded-full text-xs font-medium <?= $colorClass ?>">
                                            <?= ucfirst($post['post_type']) ?>
                                        </span>
                                    </div>
                                </div>

                                <!-- Post Excerpt -->
                                <?php if (!empty($post['content'])): ?>
                                <p class="text-gray-600 dark:text-gray-400 mb-3 line-clamp-2">
                                    <?= htmlspecialchars(substr(strip_tags($post['content']), 0, 200)) ?>...
                                </p>
                                <?php endif; ?>

                                <!-- Post Stats -->
                                <div class="flex items-center gap-4 text-sm text-gray-600 dark:text-gray-400">
                                    <div class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        <?= number_format($post['views_count']) ?>
                                    </div>
                                    <div class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                        </svg>
                                        <?= number_format($post['comments_count']) ?>
                                    </div>
                                    <div class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                        </svg>
                                        <?= number_format($post['likes_count']) ?>
                                    </div>
                                    <?php if ($post['is_solved']): ?>
                                    <div class="flex items-center gap-1 text-green-600 dark:text-green-400">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/>
                                        </svg>
                                        Solved
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- Pagination -->
            <?php if ($totalPages > 1): ?>
            <div class="mt-6 flex justify-center gap-2">
                <?php if ($page > 1): ?>
                <a href="<?= url('/community/discussions?page=' . ($page - 1)) ?>" 
                   class="px-4 py-2 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                    Previous
                </a>
                <?php endif; ?>

                <?php for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++): ?>
                <a href="<?= url('/community/discussions?page=' . $i) ?>" 
                   class="px-4 py-2 rounded-lg transition-colors <?= $i == $page ? 'bg-primary text-white' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' ?>">
                    <?= $i ?>
                </a>
                <?php endfor; ?>

                <?php if ($page < $totalPages): ?>
                <a href="<?= url('/community/discussions?page=' . ($page + 1)) ?>" 
                   class="px-4 py-2 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                    Next
                </a>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>

</body>
</html>


