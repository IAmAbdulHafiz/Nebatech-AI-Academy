<?php
/**
 * Admin Moderation Dashboard
 */

$pageTitle = 'Admin Dashboard - Community';
?>

<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">🛡️ Moderation Dashboard</h1>
        <p class="text-gray-600 dark:text-gray-400">
            Manage community content, users, and reports
        </p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Total Posts</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1"><?= number_format($stats['total_posts'] ?? 0) ?></p>
                </div>
                <div class="text-4xl">📝</div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Pending Reports</p>
                    <p class="text-2xl font-bold text-red-600 mt-1"><?= number_format($stats['pending_reports'] ?? 0) ?></p>
                </div>
                <div class="text-4xl">🚨</div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Active Users</p>
                    <p class="text-2xl font-bold text-green-600 mt-1"><?= number_format($stats['active_users'] ?? 0) ?></p>
                </div>
                <div class="text-4xl">👥</div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Total Resources</p>
                    <p class="text-2xl font-bold text-primary mt-1"><?= number_format($stats['total_resources'] ?? 0) ?></p>
                </div>
                <div class="text-4xl">📚</div>
            </div>
        </div>
    </div>

    <!-- Tabs -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden mb-8">
        <div class="border-b border-gray-200 dark:border-gray-700">
            <nav class="flex space-x-8 px-6" aria-label="Tabs">
                <button onclick="switchTab('reports')" 
                        class="tab-button py-4 px-1 border-b-2 font-medium text-sm whitespace-nowrap border-primary text-primary" 
                        data-tab="reports">
                    🚨 Reports (<?= count($reports) ?>)
                </button>
                <button onclick="switchTab('posts')" 
                        class="tab-button py-4 px-1 border-b-2 font-medium text-sm whitespace-nowrap border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300" 
                        data-tab="posts">
                    📝 Recent Posts
                </button>
                <button onclick="switchTab('users')" 
                        class="tab-button py-4 px-1 border-b-2 font-medium text-sm whitespace-nowrap border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300" 
                        data-tab="users">
                    👥 Users
                </button>
                <button onclick="switchTab('categories')" 
                        class="tab-button py-4 px-1 border-b-2 font-medium text-sm whitespace-nowrap border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300" 
                        data-tab="categories">
                    🏷️ Categories
                </button>
            </nav>
        </div>

        <!-- Tab Panels -->
        <div class="p-6">
            <!-- Reports Tab -->
            <div id="reports-tab" class="tab-content">
                <?php if (empty($reports)): ?>
                    <div class="text-center py-12">
                        <p class="text-gray-500 dark:text-gray-400">✅ No pending reports</p>
                    </div>
                <?php else: ?>
                    <div class="space-y-4">
                        <?php foreach ($reports as $report): ?>
                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-2 mb-2">
                                            <span class="px-2 py-1 bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 rounded-full text-xs font-medium">
                                                <?= ucfirst($report['reportable_type']) ?>
                                            </span>
                                            <span class="text-sm text-gray-600 dark:text-gray-400">
                                                Reported by <?= htmlspecialchars($report['reporter_name']) ?>
                                            </span>
                                            <span class="text-sm text-gray-400">
                                                • <?= date('M j, Y g:i A', strtotime($report['created_at'])) ?>
                                            </span>
                                        </div>
                                        
                                        <h4 class="font-semibold text-gray-900 dark:text-white mb-2">
                                            Reason: <?= htmlspecialchars($report['reason']) ?>
                                        </h4>
                                        
                                        <p class="text-gray-700 dark:text-gray-300 text-sm mb-3">
                                            <?= htmlspecialchars($report['description']) ?>
                                        </p>
                                        
                                        <div class="flex items-center space-x-3">
                                            <a href="<?= $report['content_link'] ?>" 
                                               target="_blank"
                                               class="text-sm text-primary hover:underline">
                                                View Content →
                                            </a>
                                        </div>
                                    </div>
                                    
                                    <div class="flex flex-col space-y-2 ml-4">
                                        <button onclick="handleReport(<?= $report['id'] ?>, 'resolved')" 
                                                class="px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600 text-sm">
                                            ✓ Resolve
                                        </button>
                                        <button onclick="handleReport(<?= $report['id'] ?>, 'dismissed')" 
                                                class="px-3 py-1 bg-gray-500 text-white rounded hover:bg-gray-600 text-sm">
                                            ✗ Dismiss
                                        </button>
                                        <button onclick="openReportModal(<?= $report['id'] ?>)" 
                                                class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 text-sm">
                                            🚫 Remove Content
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Posts Tab -->
            <div id="posts-tab" class="tab-content hidden">
                <div class="space-y-4">
                    <?php foreach ($recentPosts ?? [] as $post): ?>
                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 flex items-start justify-between">
                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-900 dark:text-white mb-1">
                                    <a href="/community/post/<?= $post['uuid'] ?>" class="hover:text-primary">
                                        <?= htmlspecialchars($post['title']) ?>
                                    </a>
                                </h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">
                                    By <?= htmlspecialchars($post['author_name']) ?> • <?= date('M j, Y', strtotime($post['created_at'])) ?>
                                </p>
                                <div class="flex items-center space-x-4 text-sm text-gray-600 dark:text-gray-400">
                                    <span>💬 <?= $post['comments_count'] ?></span>
                                    <span>❤️ <?= $post['likes_count'] ?></span>
                                    <span>👁️ <?= $post['views_count'] ?></span>
                                </div>
                            </div>
                            <div class="flex space-x-2">
                                <button onclick="togglePin(<?= $post['id'] ?>, <?= $post['is_pinned'] ? 'false' : 'true' ?>)" 
                                        class="px-3 py-1 <?= $post['is_pinned'] ? 'bg-yellow-500' : 'bg-gray-500' ?> text-white rounded hover:opacity-80 text-sm">
                                    📌 <?= $post['is_pinned'] ? 'Unpin' : 'Pin' ?>
                                </button>
                                <button onclick="deletePost(<?= $post['id'] ?>)" 
                                        class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 text-sm">
                                    🗑️ Delete
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Users Tab -->
            <div id="users-tab" class="tab-content hidden">
                <div class="space-y-4">
                    <?php foreach ($topUsers ?? [] as $user): ?>
                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <img src="<?= htmlspecialchars($user['avatar'] ?? 'https://ui-avatars.com/api/?name=' . urlencode($user['name'])) ?>" 
                                     alt="<?= htmlspecialchars($user['name']) ?>"
                                     class="w-12 h-12 rounded-full">
                                <div>
                                    <h4 class="font-semibold text-gray-900 dark:text-white">
                                        <?= htmlspecialchars($user['name']) ?>
                                    </h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        ⚡ <?= number_format($user['total_xp']) ?> XP • 
                                        📝 <?= $user['posts_count'] ?> posts • 
                                        💬 <?= $user['comments_count'] ?> comments
                                    </p>
                                </div>
                            </div>
                            <div class="flex space-x-2">
                                <button onclick="viewUserActivity(<?= $user['id'] ?>)" 
                                        class="px-3 py-1 bg-primary/90 text-white rounded hover:bg-primary text-sm">
                                    View Activity
                                </button>
                                <button onclick="moderateUser(<?= $user['id'] ?>)" 
                                        class="px-3 py-1 bg-orange-500 text-white rounded hover:bg-orange-600 text-sm">
                                    Moderate
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Categories Tab -->
            <div id="categories-tab" class="tab-content hidden">
                <div class="mb-4">
                    <button onclick="openCategoryModal()" 
                            class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark transition-colors">
                        ➕ Add Category
                    </button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <?php foreach ($categories ?? [] as $category): ?>
                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                            <div class="flex items-start justify-between">
                                <div class="flex items-center space-x-3">
                                    <span class="text-3xl"><?= htmlspecialchars($category['icon']) ?></span>
                                    <div>
                                        <h4 class="font-semibold text-gray-900 dark:text-white">
                                            <?= htmlspecialchars($category['name']) ?>
                                        </h4>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            <?= $category['posts_count'] ?? 0 ?> posts
                                        </p>
                                    </div>
                                </div>
                                <div class="flex space-x-2">
                                    <button onclick="editCategory(<?= $category['id'] ?>)" 
                                            class="text-primary/90 hover:text-primary">
                                        ✏️
                                    </button>
                                    <button onclick="toggleCategory(<?= $category['id'] ?>, <?= $category['is_active'] ? 'false' : 'true' ?>)" 
                                            class="text-<?= $category['is_active'] ? 'green' : 'gray' ?>-500">
                                        <?= $category['is_active'] ? '✓' : '✗' ?>
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function switchTab(tabName) {
    // Hide all tabs
    document.querySelectorAll('.tab-content').forEach(tab => {
        tab.classList.add('hidden');
    });
    
    // Remove active state from all buttons
    document.querySelectorAll('.tab-button').forEach(btn => {
        btn.classList.remove('border-primary', 'text-primary');
        btn.classList.add('border-transparent', 'text-gray-500');
    });
    
    // Show selected tab
    document.getElementById(tabName + '-tab').classList.remove('hidden');
    
    // Activate button
    const activeBtn = document.querySelector(`[data-tab="${tabName}"]`);
    activeBtn.classList.remove('border-transparent', 'text-gray-500');
    activeBtn.classList.add('border-primary', 'text-primary');
}

async function handleReport(reportId, action) {
    if (!confirm(`Are you sure you want to ${action} this report?`)) return;
    
    try {
        const response = await fetch('/admin/community/reports/handle', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ report_id: reportId, action })
        });
        
        const data = await response.json();
        if (data.success) {
            location.reload();
        } else {
            alert(data.message || 'Action failed');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Failed to handle report');
    }
}

async function togglePin(postId, pinned) {
    try {
        const response = await fetch('/admin/community/posts/pin', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ post_id: postId, is_pinned: pinned })
        });
        
        const data = await response.json();
        if (data.success) {
            location.reload();
        }
    } catch (error) {
        console.error('Error:', error);
    }
}

async function deletePost(postId) {
    if (!confirm('Are you sure you want to delete this post? This action cannot be undone.')) return;
    
    try {
        const response = await fetch('/admin/community/posts/delete', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ post_id: postId })
        });
        
        const data = await response.json();
        if (data.success) {
            location.reload();
        }
    } catch (error) {
        console.error('Error:', error);
    }
}

function viewUserActivity(userId) {
    window.location.href = `/admin/community/users/${userId}/activity`;
}

function moderateUser(userId) {
    window.location.href = `/admin/community/users/${userId}/moderate`;
}

function toggleCategory(categoryId, isActive) {
    // Implement category toggle
    console.log('Toggle category:', categoryId, isActive);
}

function openCategoryModal() {
    // Implement category creation modal
    alert('Category creation modal - to be implemented');
}

function editCategory(categoryId) {
    // Implement category edit modal
    console.log('Edit category:', categoryId);
}
</script>


