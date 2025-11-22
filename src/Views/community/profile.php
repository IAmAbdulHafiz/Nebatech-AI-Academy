<?php
$isOwnProfile = isset($_SESSION['user_id']) && $_SESSION['user_id'] == $user['id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?> - Nebatech AI Academy</title>
    
    <link rel="icon" type="image/x-icon" href="<?= asset('images/favicon.ico') ?>">
    <link href="<?= asset('css/main.css') ?>" rel="stylesheet">
    
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="<?= asset('js/theme-toggle.js') ?>"></script>
</head>
<body class="bg-gray-50 dark:bg-gray-900">
<?php include __DIR__ . '/../partials/header.php'; ?>

<div class="container mx-auto px-4 py-8">
    <!-- Profile Header -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden mb-8">
        <!-- Cover Image -->
        <div class="h-48 bg-gradient-to-r from-primary via-blue-600 to-purple-600"></div>
        
        <!-- Profile Info -->
        <div class="px-8 pb-8">
            <div class="flex flex-col md:flex-row items-center md:items-end -mt-20 md:-mt-16">
                <!-- Avatar -->
                <img src="<?= htmlspecialchars($user['avatar'] ?? 'https://ui-avatars.com/api/?name=' . urlencode($user['first_name'] . ' ' . $user['last_name']) . '&size=200') ?>" 
                     alt="<?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?>"
                     class="w-32 h-32 rounded-full border-4 border-white dark:border-gray-800 shadow-lg">
                
                <!-- User Info -->
                <div class="mt-4 md:mt-0 md:ml-6 flex-1 text-center md:text-left">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                        <?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?>
                    </h1>
                    
                    <?php if ($profile['bio']): ?>
                        <p class="text-gray-600 dark:text-gray-400 mt-2">
                            <?= htmlspecialchars($profile['bio']) ?>
                        </p>
                    <?php endif; ?>
                    
                    <!-- Stats Row -->
                    <div class="flex justify-center md:justify-start items-center space-x-6 mt-4">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-primary"><?= number_format($profile['total_xp']) ?></div>
                            <div class="text-sm text-gray-600 dark:text-gray-400 flex items-center justify-center gap-1">
                                <svg class="w-4 h-4 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"><path d="M11 3a1 1 0 10-2 0v1a1 1 0 102 0V3zM15.657 5.757a1 1 0 00-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707zM18 10a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zM5.05 6.464A1 1 0 106.464 5.05l-.707-.707a1 1 0 00-1.414 1.414l.707.707zM5 10a1 1 0 01-1 1H3a1 1 0 110-2h1a1 1 0 011 1zM8 16v-1h4v1a2 2 0 11-4 0zM12 14c.015-.34.208-.646.477-.859a4 4 0 10-4.954 0c.27.213.462.519.476.859h4.002z"/></svg>
                                XP
                            </div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-gray-900 dark:text-white"><?= count($badges) ?></div>
                            <div class="text-sm text-gray-600 dark:text-gray-400 flex items-center justify-center gap-1">
                                <svg class="w-4 h-4 text-purple-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/></svg>
                                Badges
                            </div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-gray-900 dark:text-white"><?= count($posts) ?></div>
                            <div class="text-sm text-gray-600 dark:text-gray-400 flex items-center justify-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                Posts
                            </div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-gray-900 dark:text-white"><?= $profile['current_streak'] ?></div>
                            <div class="text-sm text-gray-600 dark:text-gray-400 flex items-center justify-center gap-1">
                                <svg class="w-4 h-4 text-orange-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 23a7.5 7.5 0 01-5.138-12.963C8.204 8.774 11.5 6.5 11 1.5c6 4 9 8 3 14 1 0 2.5 0 5-2.47.27.773.5 1.604.5 2.47A7.5 7.5 0 0112 23z"/></svg>
                                Streak
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="mt-4 md:mt-0 flex space-x-3">
                    <?php if ($isOwnProfile): ?>
                        <a href="/community/profile/<?= $user['id'] ?>/edit" 
                           class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark transition-colors font-medium flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            Edit Profile
                        </a>
                    <?php else: ?>
                        <button onclick="followUser(<?= $user['id'] ?>)" 
                                id="follow-btn"
                                class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark transition-colors font-medium flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Follow
                        </button>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Additional Info -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                <?php if ($profile['location']): ?>
                    <div class="flex items-center space-x-2 text-gray-600 dark:text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span><?= htmlspecialchars($profile['location']) ?></span>
                    </div>
                <?php endif; ?>
                
                <div class="flex items-center space-x-2 text-gray-600 dark:text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span>Joined <?= date('M Y', strtotime($user['created_at'])) ?></span>
                </div>
                
                <?php if ($profile['last_active_date']): ?>
                    <div class="flex items-center space-x-2 text-gray-600 dark:text-gray-400">
                        <span>🟢</span>
                        <span>Active <?= date('M j', strtotime($profile['last_active_date'])) ?></span>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Skills & Interests -->
            <?php 
            $skills = $profile['skills'] ? (is_string($profile['skills']) ? json_decode($profile['skills'], true) : $profile['skills']) : [];
            $interests = $profile['interests'] ? (is_string($profile['interests']) ? json_decode($profile['interests'], true) : $profile['interests']) : [];
            ?>
            
            <?php if (!empty($skills) || !empty($interests)): ?>
                <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <?php if (!empty($skills)): ?>
                        <div class="mb-4">
                            <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Skills</h3>
                            <div class="flex flex-wrap gap-2">
                                <?php foreach ($skills as $skill): ?>
                                    <span class="px-3 py-1 bg-blue-100 dark:bg-primary/90 text-blue-800 dark:text-white/70 rounded-full text-sm">
                                        <?= htmlspecialchars($skill) ?>
                                    </span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($interests)): ?>
                        <div>
                            <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Interests</h3>
                            <div class="flex flex-wrap gap-2">
                                <?php foreach ($interests as $interest): ?>
                                    <span class="px-3 py-1 bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200 rounded-full text-sm">
                                        <?= htmlspecialchars($interest) ?>
                                    </span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Earned Badges -->
            <?php if (!empty($badges)): ?>
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6 text-purple-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/></svg>
                        Earned Badges
                    </h2>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                        <?php foreach ($badges as $badge): ?>
                            <div class="text-center p-4 rounded-lg bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors">
                                <div class="text-4xl mb-2"><?= htmlspecialchars($badge['icon']) ?></div>
                                <div class="font-medium text-sm text-gray-900 dark:text-white"><?= htmlspecialchars($badge['name']) ?></div>
                                <div class="text-xs text-gray-600 dark:text-gray-400 mt-1">
                                    <?= date('M j, Y', strtotime($badge['earned_at'])) ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Recent Posts -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Recent Posts
                </h2>
                <?php if (empty($posts)): ?>
                    <p class="text-center text-gray-500 dark:text-gray-400 py-8">No posts yet</p>
                <?php else: ?>
                    <div class="space-y-4">
                        <?php foreach ($posts as $post): ?>
                            <a href="/community/post/<?= $post['uuid'] ?>" 
                               class="block p-4 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors border border-gray-200 dark:border-gray-700">
                                <h3 class="font-semibold text-gray-900 dark:text-white mb-2">
                                    <?= htmlspecialchars($post['title']) ?>
                                </h3>
                                <div class="flex items-center space-x-4 text-sm text-gray-600 dark:text-gray-400">
                                    <span><?= htmlspecialchars($post['category_name']) ?></span>
                                    <span>•</span>
                                    <span><?= date('M j, Y', strtotime($post['created_at'])) ?></span>
                                    <span>•</span>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                                        <?= $post['comments_count'] ?>
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                                        <?= $post['likes_count'] ?>
                                    </span>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Enrolled Courses -->
            <?php if (!empty($courses)): ?>
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6 text-primary/90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        Enrolled Courses
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <?php foreach ($courses as $course): ?>
                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                                <h3 class="font-semibold text-gray-900 dark:text-white mb-2">
                                    <?= htmlspecialchars($course['title']) ?>
                                </h3>
                                <div class="mb-2">
                                    <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400 mb-1">
                                        <span>Progress</span>
                                        <span><?= $course['progress'] ?>%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                        <div class="bg-primary h-2 rounded-full" style="width: <?= $course['progress'] ?>%"></div>
                                    </div>
                                </div>
                                <span class="inline-flex px-2 py-1 bg-<?= $course['status'] === 'completed' ? 'green' : 'blue' ?>-100 text-<?= $course['status'] === 'completed' ? 'green' : 'blue' ?>-800 rounded-full text-xs">
                                    <?= ucfirst($course['status']) ?>
                                </span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Activity Stats -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    Activity
                </h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 dark:text-gray-400">Current Streak</span>
                        <span class="font-semibold text-orange-500 flex items-center gap-1">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 23a7.5 7.5 0 01-5.138-12.963C8.204 8.774 11.5 6.5 11 1.5c6 4 9 8 3 14 1 0 2.5 0 5-2.47.27.773.5 1.604.5 2.47A7.5 7.5 0 0112 23z"/></svg>
                            <?= $profile['current_streak'] ?> days
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 dark:text-gray-400">Longest Streak</span>
                        <span class="font-semibold text-gray-900 dark:text-white"><?= $profile['longest_streak'] ?> days</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 dark:text-gray-400">Total XP</span>
                        <span class="font-semibold text-yellow-500 flex items-center gap-1">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M11 3a1 1 0 10-2 0v1a1 1 0 102 0V3zM15.657 5.757a1 1 0 00-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707zM18 10a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zM5.05 6.464A1 1 0 106.464 5.05l-.707-.707a1 1 0 00-1.414 1.414l.707.707zM5 10a1 1 0 01-1 1H3a1 1 0 110-2h1a1 1 0 011 1zM8 16v-1h4v1a2 2 0 11-4 0zM12 14c.015-.34.208-.646.477-.859a4 4 0 10-4.954 0c.27.213.462.519.476.859h4.002z"/></svg>
                            <?= number_format($profile['total_xp']) ?>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Social Links -->
            <?php 
            $socialLinks = $profile['social_links'] ? (is_string($profile['social_links']) ? json_decode($profile['social_links'], true) : $profile['social_links']) : [];
            ?>
            <?php if (!empty($socialLinks)): ?>
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                        Links
                    </h3>
                    <div class="space-y-2">
                        <?php foreach ($socialLinks as $platform => $url): ?>
                            <a href="<?= htmlspecialchars($url) ?>" 
                               target="_blank"
                               class="flex items-center space-x-2 text-gray-700 dark:text-gray-300 hover:text-primary">
                                <span><?= ucfirst($platform) ?></span>
                                <span>↗</span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>
</body>
</html>

<script>
async function followUser(userId) {
    try {
        const response = await fetch(`/community/profile/${userId}/follow`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' }
        });
        
        const data = await response.json();
        if (data.success) {
            const btn = document.getElementById('follow-btn');
            btn.textContent = data.following ? 'Following' : 'Follow';
            btn.classList.toggle('bg-gray-500');
        }
    } catch (error) {
        console.error('Error:', error);
    }
}
</script>


