<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($post['title']) ?> - Nebatech AI Academy</title>
    
    <link rel="icon" type="image/x-icon" href="<?= asset('images/favicon.ico') ?>">
    <link href="<?= asset('css/main.css') ?>" rel="stylesheet">
    
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="<?= asset('js/theme-toggle.js') ?>"></script>
</head>
<body class="bg-gray-50 dark:bg-gray-900">
<?php include __DIR__ . '/../partials/header.php'; ?>

<div class="container mx-auto px-4 py-8">
    <!-- Breadcrumb -->
    <nav class="mb-6 text-sm">
        <ol class="flex items-center space-x-2 text-gray-600 dark:text-gray-400">
            <li><a href="/community" class="hover:text-primary">Community</a></li>
            <li><span>›</span></li>
            <li><a href="/community/category/<?= htmlspecialchars($post['category_slug']) ?>" class="hover:text-primary">
                <?= htmlspecialchars($post['category_name']) ?>
            </a></li>
            <li><span>›</span></li>
            <li class="text-gray-900 dark:text-white truncate max-w-xs"><?= htmlspecialchars($post['title']) ?></li>
        </ol>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2">
            <!-- Post Card -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                <!-- Post Header -->
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <?php if ($post['is_pinned']): ?>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200 mb-2 gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a1 1 0 011 1v1.323l3.954 1.582 1.599-.8a1 1 0 01.894 1.79l-1.233.616 1.738 5.42a1 1 0 01-.285 1.05A3.989 3.989 0 0115 15a3.989 3.989 0 01-2.667-1.019 1 1 0 01-.285-1.05l1.715-5.349L11 6.477V16h2a1 1 0 110 2H7a1 1 0 110-2h2V6.477L6.237 7.582l1.715 5.349a1 1 0 01-.285 1.05A3.989 3.989 0 015 15a3.989 3.989 0 01-2.667-1.019 1 1 0 01-.285-1.05l1.738-5.42-1.233-.617a1 1 0 01.894-1.788l1.599.799L9 4.323V3a1 1 0 011-1z"/></svg>
                                    Pinned
                                </span>
                            <?php endif; ?>
                            
                            <?php if ($post['is_solved']): ?>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 mb-2 ml-2 gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                    Solved
                                </span>
                            <?php endif; ?>

                            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                                <?= htmlspecialchars($post['title']) ?>
                            </h1>

                            <!-- Post Meta -->
                            <div class="flex items-center space-x-4 text-sm text-gray-600 dark:text-gray-400">
                                <div class="flex items-center space-x-2">
                                    <img src="<?= htmlspecialchars($post['author_avatar'] ?? 'https://ui-avatars.com/api/?name=' . urlencode($post['author_name'])) ?>" 
                                         alt="<?= htmlspecialchars($post['author_name']) ?>" 
                                         class="w-10 h-10 rounded-full">
                                    <div>
                                        <a href="/community/profile/<?= $post['author_id'] ?>" class="font-medium text-gray-900 dark:text-white hover:text-primary">
                                            <?= htmlspecialchars($post['author_name']) ?>
                                        </a>
                                        <div class="flex items-center space-x-2">
                                            <span><?= date('M j, Y', strtotime($post['created_at'])) ?></span>
                                            <span>•</span>
                                            <span class="flex items-center gap-1">
                                                <svg class="w-4 h-4 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"><path d="M11 3a1 1 0 10-2 0v1a1 1 0 102 0V3zM15.657 5.757a1 1 0 00-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707zM18 10a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zM5.05 6.464A1 1 0 106.464 5.05l-.707-.707a1 1 0 00-1.414 1.414l.707.707zM5 10a1 1 0 01-1 1H3a1 1 0 110-2h1a1 1 0 011 1zM8 16v-1h4v1a2 2 0 11-4 0zM12 14c.015-.34.208-.646.477-.859a4 4 0 10-4.954 0c.27.213.462.519.476.859h4.002z"/></svg>
                                                <?= number_format($post['author_xp'] ?? 0) ?> XP
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Post Type Badge -->
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium" 
                              style="background-color: <?= htmlspecialchars($post['category_color']) ?>20; color: <?= htmlspecialchars($post['category_color']) ?>;">
                            <?= htmlspecialchars($post['category_icon']) ?> <?= ucfirst($post['type']) ?>
                        </span>
                    </div>

                    <!-- Tags -->
                    <?php if (!empty($post['tags'])): 
                        $tags = is_string($post['tags']) ? json_decode($post['tags'], true) : $post['tags'];
                        if ($tags):
                    ?>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <?php foreach ($tags as $tag): ?>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                    #<?= htmlspecialchars($tag) ?>
                                </span>
                            <?php endforeach; ?>
                        </div>
                    <?php 
                        endif;
                    endif; 
                    ?>

                    <!-- Post Content -->
                    <div class="prose dark:prose-invert max-w-none mt-6">
                        <?= nl2br(htmlspecialchars($post['content'])) ?>
                    </div>
                </div>

                <!-- Post Actions -->
                <div class="px-6 py-4 bg-gray-50 dark:bg-gray-900 flex items-center justify-between">
                    <div class="flex items-center space-x-6">
                        <!-- Like Button -->
                        <button onclick="toggleLike('<?= $post['uuid'] ?>')" 
                                id="like-btn-<?= $post['uuid'] ?>"
                                class="flex items-center space-x-2 text-gray-600 dark:text-gray-400 hover:text-red-500 transition-colors">
                            <svg class="w-6 h-6" id="like-icon-<?= $post['uuid'] ?>" fill="<?= $post['user_liked'] ? 'currentColor' : 'none' ?>" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                            <span id="like-count-<?= $post['uuid'] ?>"><?= $post['likes_count'] ?></span>
                        </button>

                        <!-- Comments Count -->
                        <div class="flex items-center space-x-2 text-gray-600 dark:text-gray-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                            <span><?= $post['comments_count'] ?></span>
                        </div>

                        <!-- Views Count -->
                        <div class="flex items-center space-x-2 text-gray-600 dark:text-gray-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <span><?= $post['views_count'] ?></span>
                        </div>
                    </div>

                    <!-- Bookmark Button -->
                    <button class="flex items-center space-x-2 text-gray-600 dark:text-gray-400 hover:text-yellow-500 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>
                        <span>Save</span>
                    </button>
                </div>
            </div>

            <!-- Comments Section -->
            <div class="mt-8">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">
                    <?= $post['comments_count'] ?> <?= $post['comments_count'] == 1 ? 'Comment' : 'Comments' ?>
                </h2>

                <!-- Add Comment Form -->
                <?php if (isset($_SESSION['user_id'])): ?>
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-6">
                        <form id="comment-form" class="space-y-4">
                            <textarea id="comment-content" 
                                      rows="4" 
                                      class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-transparent resize-none" 
                                      placeholder="Share your thoughts..."></textarea>
                            <div class="flex justify-end">
                                <button type="submit" 
                                        class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark transition-colors font-medium">
                                    Post Comment
                                </button>
                            </div>
                        </form>
                    </div>
                <?php else: ?>
                    <div class="bg-blue-50 dark:bg-primary/90/20 border border-white/20 dark:border-primary/80 rounded-lg p-4 mb-6">
                        <p class="text-blue-800 dark:text-white/70">
                            <a href="/login" class="font-semibold hover:underline">Sign in</a> to join the discussion
                        </p>
                    </div>
                <?php endif; ?>

                <!-- Comments List -->
                <div id="comments-list" class="space-y-6">
                    <?php if (empty($comments)): ?>
                        <p class="text-center text-gray-500 dark:text-gray-400 py-8">
                            No comments yet. Be the first to share your thoughts!
                        </p>
                    <?php else: ?>
                        <?php foreach ($comments as $comment): ?>
                            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6 <?= $comment['is_solution'] ? 'border-green-500 border-2' : '' ?>">
                                <!-- Solution Badge -->
                                <?php if ($comment['is_solution']): ?>
                                    <div class="mb-4">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 gap-1">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                            Accepted Solution
                                        </span>
                                    </div>
                                <?php endif; ?>

                                <!-- Comment Header -->
                                <div class="flex items-start space-x-3 mb-4">
                                    <img src="<?= htmlspecialchars($comment['author_avatar'] ?? 'https://ui-avatars.com/api/?name=' . urlencode($comment['author_name'])) ?>" 
                                         alt="<?= htmlspecialchars($comment['author_name']) ?>" 
                                         class="w-10 h-10 rounded-full">
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <a href="/community/profile/<?= $comment['author_id'] ?>" 
                                                   class="font-medium text-gray-900 dark:text-white hover:text-primary">
                                                    <?= htmlspecialchars($comment['author_name']) ?>
                                                </a>
                                                <span class="mx-2 text-gray-400">•</span>
                                                <span class="text-sm text-gray-600 dark:text-gray-400">
                                                    <?= date('M j, Y \a\t g:i A', strtotime($comment['created_at'])) ?>
                                                </span>
                                                <?php if (isset($comment['author_xp'])): ?>
                                                    <span class="mx-2 text-gray-400">•</span>
                                                    <span class="text-sm text-gray-600 dark:text-gray-400 flex items-center gap-1">
                                                        <svg class="w-4 h-4 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"><path d="M11 3a1 1 0 10-2 0v1a1 1 0 102 0V3zM15.657 5.757a1 1 0 00-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707zM18 10a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zM5.05 6.464A1 1 0 106.464 5.05l-.707-.707a1 1 0 00-1.414 1.414l.707.707zM5 10a1 1 0 01-1 1H3a1 1 0 110-2h1a1 1 0 011 1zM8 16v-1h4v1a2 2 0 11-4 0zM12 14c.015-.34.208-.646.477-.859a4 4 0 10-4.954 0c.27.213.462.519.476.859h4.002z"/></svg>
                                                        <?= number_format($comment['author_xp']) ?> XP
                                                    </span>
                                                <?php endif; ?>
                                            </div>

                                            <!-- Mark as Solution Button (Post Author Only) -->
                                            <?php if (!$comment['is_solution'] && isset($_SESSION['user_id']) && $_SESSION['user_id'] == $post['author_id'] && !$post['is_solved']): ?>
                                                <button onclick="markSolution('<?= $comment['uuid'] ?>')" 
                                                        class="text-sm text-green-600 hover:text-green-700 dark:text-green-400 dark:hover:text-green-300 font-medium flex items-center gap-1">
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                                    Mark as Solution
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <!-- Comment Content -->
                                <div class="prose dark:prose-invert max-w-none ml-13">
                                    <?= nl2br(htmlspecialchars($comment['content'])) ?>
                                </div>

                                <!-- Comment Actions -->
                                <div class="mt-4 ml-13 flex items-center space-x-4">
                                    <button class="text-sm text-gray-600 dark:text-gray-400 hover:text-red-500 flex items-center space-x-1">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                                        <span><?= $comment['likes_count'] ?></span>
                                    </button>
                                    <button class="text-sm text-gray-600 dark:text-gray-400 hover:text-primary">
                                        Reply
                                    </button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Author Card -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="font-semibold text-gray-900 dark:text-white mb-4">About the Author</h3>
                <div class="flex items-center space-x-3 mb-4">
                    <img src="<?= htmlspecialchars($post['author_avatar'] ?? 'https://ui-avatars.com/api/?name=' . urlencode($post['author_name'])) ?>" 
                         alt="<?= htmlspecialchars($post['author_name']) ?>" 
                         class="w-16 h-16 rounded-full">
                    <div>
                        <a href="/community/profile/<?= $post['author_id'] ?>" 
                           class="font-medium text-gray-900 dark:text-white hover:text-primary">
                            <?= htmlspecialchars($post['author_name']) ?>
                        </a>
                        <p class="text-sm text-gray-600 dark:text-gray-400 flex items-center gap-1">
                            <svg class="w-4 h-4 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"><path d="M11 3a1 1 0 10-2 0v1a1 1 0 102 0V3zM15.657 5.757a1 1 0 00-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707zM18 10a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zM5.05 6.464A1 1 0 106.464 5.05l-.707-.707a1 1 0 00-1.414 1.414l.707.707zM5 10a1 1 0 01-1 1H3a1 1 0 110-2h1a1 1 0 011 1zM8 16v-1h4v1a2 2 0 11-4 0zM12 14c.015-.34.208-.646.477-.859a4 4 0 10-4.954 0c.27.213.462.519.476.859h4.002z"/></svg>
                            <?= number_format($post['author_xp'] ?? 0) ?> XP
                        </p>
                    </div>
                </div>
                <?php if (!empty($post['author_bio'])): ?>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                        <?= htmlspecialchars($post['author_bio']) ?>
                    </p>
                <?php endif; ?>
                <button class="w-full px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark transition-colors text-sm font-medium">
                    Follow
                </button>
            </div>

            <!-- Category Card -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Category</h3>
                <a href="/community/category/<?= htmlspecialchars($post['category_slug']) ?>" 
                   class="block p-4 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors border-2 border-transparent hover:border-primary">
                    <div class="flex items-center space-x-3">
                        <span class="text-3xl"><?= htmlspecialchars($post['category_icon']) ?></span>
                        <div>
                            <div class="font-medium text-gray-900 dark:text-white">
                                <?= htmlspecialchars($post['category_name']) ?>
                            </div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">
                                View all posts
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Related Posts -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Related Discussions</h3>
                <div class="space-y-3">
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Similar discussions will appear here
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Add comment submission
document.getElementById('comment-form')?.addEventListener('submit', async (e) => {
    e.preventDefault();
    const content = document.getElementById('comment-content').value.trim();
    
    if (!content) return;
    
    try {
        const response = await fetch('/community/post/<?= $post['uuid'] ?>/comment', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ content })
        });
        
        const data = await response.json();
        
        if (data.success) {
            // Reload page to show new comment
            location.reload();
        } else {
            alert(data.message || 'Failed to post comment');
        }
    } catch (error) {
        console.error('Error posting comment:', error);
        alert('Failed to post comment. Please try again.');
    }
});

// Toggle like
async function toggleLike(uuid) {
    try {
        const response = await fetch(`/community/post/${uuid}/like`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            }
        });
        
        const data = await response.json();
        
        if (data.success) {
            const icon = document.getElementById(`like-icon-${uuid}`);
            if (data.liked) {
                icon.setAttribute('fill', 'currentColor');
            } else {
                icon.setAttribute('fill', 'none');
            }
            document.getElementById(`like-count-${uuid}`).textContent = data.likes_count;
        }
    } catch (error) {
        console.error('Error toggling like:', error);
    }
}

// Mark as solution
async function markSolution(commentUuid) {
    if (!confirm('Mark this comment as the accepted solution?')) return;
    
    try {
        const response = await fetch('/community/post/<?= $post['uuid'] ?>/solution', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ comment_uuid: commentUuid })
        });
        
        const data = await response.json();
        
        if (data.success) {
            location.reload();
        } else {
            alert(data.message || 'Failed to mark solution');
        }
    } catch (error) {
        console.error('Error marking solution:', error);
        alert('Failed to mark solution. Please try again.');
    }
}
</script>

<?php include __DIR__ . '/../partials/footer.php'; ?>
</body>
</html>


