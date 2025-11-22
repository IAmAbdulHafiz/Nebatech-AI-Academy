<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($post['title'] ?? 'Article') ?> - Nebatech AI Academy Blog</title>
    <link href="<?= asset('css/main.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50 dark:bg-gray-900">
    <?php include __DIR__ . '/../partials/header.php'; ?>

    <!-- Article Header -->
    <article class="py-12">
        <div class="max-w-4xl mx-auto px-6">
            <!-- Breadcrumb -->
            <nav class="mb-8 text-sm">
                <a href="<?= url('/') ?>" class="text-primary hover:underline">Home</a>
                <span class="mx-2 text-gray-400">/</span>
                <a href="<?= url('/blog') ?>" class="text-primary hover:underline">Blog</a>
                <span class="mx-2 text-gray-400">/</span>
                <span class="text-gray-600 dark:text-gray-400"><?= htmlspecialchars($post['title'] ?? 'Article') ?></span>
            </nav>

            <!-- Category Badge -->
            <?php if (isset($post['category'])): ?>
            <div class="mb-4">
                <span class="inline-block bg-primary text-white px-4 py-1 rounded-full text-sm font-semibold">
                    <?= htmlspecialchars($post['category']) ?>
                </span>
            </div>
            <?php endif; ?>

            <!-- Title -->
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-6">
                <?= htmlspecialchars($post['title'] ?? 'Article Title') ?>
            </h1>

            <!-- Meta Info -->
            <div class="flex flex-wrap items-center gap-6 mb-8 text-gray-600 dark:text-gray-400">
                <div class="flex items-center gap-2">
                    <img src="<?= $post['author_avatar'] ?? asset('images/default-avatar.png') ?>" 
                         alt="<?= htmlspecialchars($post['author_name'] ?? 'Author') ?>" 
                         class="w-10 h-10 rounded-full">
                    <span class="font-medium"><?= htmlspecialchars($post['author_name'] ?? 'Admin') ?></span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="far fa-calendar text-primary"></i>
                    <span><?= date('F j, Y', strtotime($post['published_at'] ?? 'now')) ?></span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="far fa-clock text-primary"></i>
                    <span><?= $post['read_time'] ?? 5 ?> min read</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="far fa-eye text-primary"></i>
                    <span><?= number_format($post['views'] ?? 0) ?> views</span>
                </div>
            </div>

            <!-- Featured Image -->
            <?php if (isset($post['featured_image'])): ?>
            <div class="mb-12 rounded-2xl overflow-hidden">
                <img src="<?= $post['featured_image'] ?>" 
                     alt="<?= htmlspecialchars($post['title']) ?>" 
                     class="w-full h-auto">
            </div>
            <?php endif; ?>

            <!-- Article Content -->
            <div class="prose prose-lg dark:prose-invert max-w-none mb-12">
                <?= $post['content'] ?? '<p>Content coming soon...</p>' ?>
            </div>

            <!-- Tags -->
            <?php if (isset($post['tags']) && !empty($post['tags'])): ?>
            <div class="mb-12">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Tags</h3>
                <div class="flex flex-wrap gap-2">
                    <?php foreach ($post['tags'] as $tag): ?>
                    <a href="<?= url('/blog?tag=' . urlencode($tag)) ?>" 
                       class="bg-gray-200 dark:bg-gray-700 hover:bg-primary hover:text-white px-4 py-2 rounded-lg text-sm transition-colors">
                        #<?= htmlspecialchars($tag) ?>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- Share Buttons -->
            <div class="border-t border-b border-gray-200 dark:border-gray-700 py-8 mb-12">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Share this article</h3>
                <div class="flex gap-4">
                    <a href="https://twitter.com/intent/tweet?url=<?= urlencode(url('/blog/' . ($post['slug'] ?? ''))) ?>&text=<?= urlencode($post['title'] ?? '') ?>" 
                       target="_blank"
                       class="flex items-center gap-2 bg-[#1DA1F2] hover:bg-[#1a8cd8] text-white px-6 py-3 rounded-lg transition-colors">
                        <i class="fab fa-twitter"></i>
                        <span>Twitter</span>
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode(url('/blog/' . ($post['slug'] ?? ''))) ?>" 
                       target="_blank"
                       class="flex items-center gap-2 bg-[#4267B2] hover:bg-[#365899] text-white px-6 py-3 rounded-lg transition-colors">
                        <i class="fab fa-facebook"></i>
                        <span>Facebook</span>
                    </a>
                    <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?= urlencode(url('/blog/' . ($post['slug'] ?? ''))) ?>" 
                       target="_blank"
                       class="flex items-center gap-2 bg-[#0077B5] hover:bg-[#006399] text-white px-6 py-3 rounded-lg transition-colors">
                        <i class="fab fa-linkedin"></i>
                        <span>LinkedIn</span>
                    </a>
                    <button onclick="copyToClipboard('<?= url('/blog/' . ($post['slug'] ?? '')) ?>')"
                            class="flex items-center gap-2 bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg transition-colors">
                        <i class="fas fa-link"></i>
                        <span>Copy Link</span>
                    </button>
                </div>
            </div>

            <!-- Author Bio -->
            <div class="bg-gray-100 dark:bg-gray-800 rounded-2xl p-8 mb-12">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">About the Author</h3>
                <div class="flex items-start gap-6">
                    <img src="<?= $post['author_avatar'] ?? asset('images/default-avatar.png') ?>" 
                         alt="<?= htmlspecialchars($post['author_name'] ?? 'Author') ?>" 
                         class="w-24 h-24 rounded-full flex-shrink-0">
                    <div>
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                            <?= htmlspecialchars($post['author_name'] ?? 'Admin') ?>
                        </h4>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">
                            <?= htmlspecialchars($post['author_bio'] ?? 'Content creator and tech educator at Nebatech AI Academy.') ?>
                        </p>
                        <div class="flex gap-4">
                            <?php if (isset($post['author_twitter'])): ?>
                            <a href="<?= $post['author_twitter'] ?>" target="_blank" class="text-primary hover:text-primary/80">
                                <i class="fab fa-twitter text-xl"></i>
                            </a>
                            <?php endif; ?>
                            <?php if (isset($post['author_linkedin'])): ?>
                            <a href="<?= $post['author_linkedin'] ?>" target="_blank" class="text-primary hover:text-primary/80">
                                <i class="fab fa-linkedin text-xl"></i>
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Comments Section -->
            <div id="comments" class="mb-12">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">
                    Comments (<?= count($comments ?? []) ?>)
                </h3>

                <!-- Comment Form -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 mb-8 shadow-md">
                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Leave a Comment</h4>
                    <form action="<?= url('/blog/comment') ?>" method="POST">
                        <input type="hidden" name="post_id" value="<?= $post['id'] ?? '' ?>">
                        <textarea name="content" rows="4" 
                                  class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-primary focus:border-transparent" 
                                  placeholder="Share your thoughts..." required></textarea>
                        <button type="submit" 
                                class="mt-4 bg-primary hover:bg-primary/90 text-white px-6 py-3 rounded-lg font-semibold transition-colors">
                            Post Comment
                        </button>
                    </form>
                </div>

                <!-- Comments List -->
                <?php if (!empty($comments)): ?>
                    <?php foreach ($comments as $comment): ?>
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 mb-4 shadow-md">
                        <div class="flex items-start gap-4">
                            <img src="<?= $comment['avatar'] ?? asset('images/default-avatar.png') ?>" 
                                 alt="<?= htmlspecialchars($comment['name']) ?>" 
                                 class="w-12 h-12 rounded-full flex-shrink-0">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="font-semibold text-gray-900 dark:text-white">
                                        <?= htmlspecialchars($comment['name']) ?>
                                    </span>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">
                                        <?= date('M j, Y', strtotime($comment['created_at'])) ?>
                                    </span>
                                </div>
                                <p class="text-gray-700 dark:text-gray-300">
                                    <?= nl2br(htmlspecialchars($comment['content'])) ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                <div class="text-center py-12 text-gray-500 dark:text-gray-400">
                    <i class="far fa-comments text-4xl mb-4"></i>
                    <p>No comments yet. Be the first to comment!</p>
                </div>
                <?php endif; ?>
            </div>

            <!-- Related Articles -->
            <?php if (!empty($relatedPosts)): ?>
            <div class="border-t border-gray-200 dark:border-gray-700 pt-12">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-8">Related Articles</h3>
                <div class="grid md:grid-cols-3 gap-6">
                    <?php foreach (array_slice($relatedPosts, 0, 3) as $related): ?>
                    <a href="<?= url('/blog/' . $related['slug']) ?>" 
                       class="group bg-white dark:bg-gray-800 rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-shadow">
                        <img src="<?= $related['featured_image'] ?? asset('images/blog-placeholder.jpg') ?>" 
                             alt="<?= htmlspecialchars($related['title']) ?>" 
                             class="w-full h-48 object-cover group-hover:scale-105 transition-transform">
                        <div class="p-4">
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-2 group-hover:text-primary transition-colors">
                                <?= htmlspecialchars($related['title']) ?>
                            </h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                <?= date('F j, Y', strtotime($related['published_at'])) ?>
                            </p>
                        </div>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </article>

    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                alert('Link copied to clipboard!');
            }).catch(err => {
                console.error('Failed to copy:', err);
            });
        }
    </script>

    <?php include __DIR__ . '/../partials/footer.php'; ?>
</body>
</html>
