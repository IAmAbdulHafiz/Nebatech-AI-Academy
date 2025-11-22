<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard - Nebatech AI Academy</title>
    
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
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2 flex items-center gap-3">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
            </svg>
            Community Leaderboard
        </h1>
        <p class="text-gray-600 dark:text-gray-400">
            Top contributors and active community members
        </p>
    </div>

    <!-- Time Period Filter -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4 mb-6">
        <div class="flex flex-wrap gap-3">
            <button onclick="filterLeaderboard('daily')" 
                    id="filter-daily"
                    class="filter-btn px-6 py-2 rounded-lg font-medium transition-colors bg-primary text-white">
                Today
            </button>
            <button onclick="filterLeaderboard('weekly')" 
                    id="filter-weekly"
                    class="filter-btn px-6 py-2 rounded-lg font-medium transition-colors bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-300 dark:hover:bg-gray-600">
                This Week
            </button>
            <button onclick="filterLeaderboard('monthly')" 
                    id="filter-monthly"
                    class="filter-btn px-6 py-2 rounded-lg font-medium transition-colors bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-300 dark:hover:bg-gray-600">
                This Month
            </button>
            <button onclick="filterLeaderboard('all-time')" 
                    id="filter-all-time"
                    class="filter-btn px-6 py-2 rounded-lg font-medium transition-colors bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-300 dark:hover:bg-gray-600">
                All Time
            </button>
        </div>
    </div>

    <!-- Top 3 Podium -->
    <?php if (count($leaderboard) >= 3): ?>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- 2nd Place -->
        <div class="bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 rounded-lg p-6 text-center order-2 md:order-1 transform md:translate-y-8">
            <div class="flex justify-center mb-4">
                <div class="relative">
                    <div class="w-20 h-20 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center text-2xl font-bold text-gray-700 dark:text-gray-300">
                        <?= strtoupper(substr($leaderboard[1]['name'], 0, 2)) ?>
                    </div>
                    <div class="absolute -bottom-2 -right-2 w-10 h-10 bg-gray-400 rounded-full flex items-center justify-center text-white font-bold text-lg shadow-lg">
                        2
                    </div>
                </div>
            </div>
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-1">
                <?= htmlspecialchars($leaderboard[1]['name']) ?>
            </h3>
            <div class="flex items-center justify-center gap-2 text-yellow-600 dark:text-yellow-500 font-bold text-2xl">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M13 2L3 14h8l-1 8 10-12h-8l1-8z"/>
                </svg>
                <?= number_format($leaderboard[1]['total_xp']) ?> XP
            </div>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">
                <?= $leaderboard[1]['post_count'] ?> posts · <?= $leaderboard[1]['comment_count'] ?> comments
            </p>
        </div>

        <!-- 1st Place -->
        <div class="bg-gradient-to-br from-yellow-100 to-yellow-200 dark:from-yellow-900 dark:to-yellow-800 rounded-lg p-6 text-center order-1 md:order-2 shadow-xl">
            <div class="flex justify-center mb-4">
                <div class="relative">
                    <div class="w-24 h-24 rounded-full bg-yellow-300 dark:bg-yellow-600 flex items-center justify-center text-3xl font-bold text-yellow-900 dark:text-yellow-100">
                        <?= strtoupper(substr($leaderboard[0]['name'], 0, 2)) ?>
                    </div>
                    <div class="absolute -bottom-2 -right-2 w-12 h-12 bg-yellow-500 rounded-full flex items-center justify-center text-white font-bold text-xl shadow-lg">
                        <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2l2.4 7.4h7.6l-6 4.6 2.3 7-6.3-4.6-6.3 4.6 2.3-7-6-4.6h7.6z"/>
                        </svg>
                    </div>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-1">
                <?= htmlspecialchars($leaderboard[0]['name']) ?>
            </h3>
            <div class="flex items-center justify-center gap-2 text-yellow-600 dark:text-yellow-500 font-bold text-3xl">
                <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M13 2L3 14h8l-1 8 10-12h-8l1-8z"/>
                </svg>
                <?= number_format($leaderboard[0]['total_xp']) ?> XP
            </div>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">
                <?= $leaderboard[0]['post_count'] ?> posts · <?= $leaderboard[0]['comment_count'] ?> comments
            </p>
        </div>

        <!-- 3rd Place -->
        <div class="bg-gradient-to-br from-orange-100 to-orange-200 dark:from-orange-900 dark:to-orange-800 rounded-lg p-6 text-center order-3 transform md:translate-y-8">
            <div class="flex justify-center mb-4">
                <div class="relative">
                    <div class="w-20 h-20 rounded-full bg-orange-300 dark:bg-orange-600 flex items-center justify-center text-2xl font-bold text-orange-900 dark:text-orange-100">
                        <?= strtoupper(substr($leaderboard[2]['name'], 0, 2)) ?>
                    </div>
                    <div class="absolute -bottom-2 -right-2 w-10 h-10 bg-orange-500 rounded-full flex items-center justify-center text-white font-bold text-lg shadow-lg">
                        3
                    </div>
                </div>
            </div>
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-1">
                <?= htmlspecialchars($leaderboard[2]['name']) ?>
            </h3>
            <div class="flex items-center justify-center gap-2 text-yellow-600 dark:text-yellow-500 font-bold text-2xl">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M13 2L3 14h8l-1 8 10-12h-8l1-8z"/>
                </svg>
                <?= number_format($leaderboard[2]['total_xp']) ?> XP
            </div>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">
                <?= $leaderboard[2]['post_count'] ?> posts · <?= $leaderboard[2]['comment_count'] ?> comments
            </p>
        </div>
    </div>
    <?php endif; ?>

    <!-- Full Leaderboard Table -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Full Rankings</h2>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Rank
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            User
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            XP Points
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Posts
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Comments
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Badges
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    <?php foreach ($leaderboard as $index => $user): ?>
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <?php if ($index === 0): ?>
                                    <span class="text-2xl">🥇</span>
                                <?php elseif ($index === 1): ?>
                                    <span class="text-2xl">🥈</span>
                                <?php elseif ($index === 2): ?>
                                    <span class="text-2xl">🥉</span>
                                <?php else: ?>
                                    <span class="text-lg font-semibold text-gray-600 dark:text-gray-400">#<?= $index + 1 ?></span>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-full bg-primary flex items-center justify-center text-white font-bold">
                                        <?= strtoupper(substr($user['name'], 0, 2)) ?>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <a href="<?= url('/community/profile/' . $user['user_id']) ?>" 
                                       class="text-sm font-medium text-gray-900 dark:text-white hover:text-primary dark:hover:text-primary">
                                        <?= htmlspecialchars($user['name']) ?>
                                    </a>
                                    <?php if (!empty($user['title'])): ?>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            <?= htmlspecialchars($user['title']) ?>
                                        </p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-2 text-yellow-600 dark:text-yellow-500 font-bold">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M13 2L3 14h8l-1 8 10-12h-8l1-8z"/>
                                </svg>
                                <?= number_format($user['total_xp']) ?>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                                </svg>
                                <?= $user['post_count'] ?>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                </svg>
                                <?= $user['comment_count'] ?>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                </svg>
                                <?= $user['badge_count'] ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    
                    <?php if (empty($leaderboard)): ?>
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="text-gray-500 dark:text-gray-400">
                                <svg class="w-16 h-16 mx-auto mb-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                                <p class="text-lg font-medium">No rankings yet</p>
                                <p class="text-sm mt-2">Be the first to earn XP points!</p>
                            </div>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- XP Point Information -->
    <div class="mt-8 bg-blue-50 dark:bg-primary/90/20 rounded-lg p-6">
        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
            <svg class="w-6 h-6 text-primary dark:text-primary/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            How to Earn XP Points
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <div class="flex items-start gap-3">
                <div class="flex-shrink-0 w-8 h-8 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                    <span class="text-green-600 dark:text-green-400 font-bold">+10</span>
                </div>
                <div>
                    <p class="font-medium text-gray-900 dark:text-white">Create a Post</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Share your knowledge</p>
                </div>
            </div>
            <div class="flex items-start gap-3">
                <div class="flex-shrink-0 w-8 h-8 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                    <span class="text-green-600 dark:text-green-400 font-bold">+5</span>
                </div>
                <div>
                    <p class="font-medium text-gray-900 dark:text-white">Write a Comment</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Engage in discussions</p>
                </div>
            </div>
            <div class="flex items-start gap-3">
                <div class="flex-shrink-0 w-8 h-8 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                    <span class="text-green-600 dark:text-green-400 font-bold">+20</span>
                </div>
                <div>
                    <p class="font-medium text-gray-900 dark:text-white">Helpful Answer</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Get marked as solution</p>
                </div>
            </div>
            <div class="flex items-start gap-3">
                <div class="flex-shrink-0 w-8 h-8 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                    <span class="text-green-600 dark:text-green-400 font-bold">+2</span>
                </div>
                <div>
                    <p class="font-medium text-gray-900 dark:text-white">Receive a Like</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Quality content</p>
                </div>
            </div>
            <div class="flex items-start gap-3">
                <div class="flex-shrink-0 w-8 h-8 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                    <span class="text-green-600 dark:text-green-400 font-bold">+15</span>
                </div>
                <div>
                    <p class="font-medium text-gray-900 dark:text-white">Share a Resource</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Upload helpful files</p>
                </div>
            </div>
            <div class="flex items-start gap-3">
                <div class="flex-shrink-0 w-8 h-8 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                    <span class="text-green-600 dark:text-green-400 font-bold">+50</span>
                </div>
                <div>
                    <p class="font-medium text-gray-900 dark:text-white">Earn a Badge</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Achieve milestones</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>

<script>
function filterLeaderboard(period) {
    // Update button states
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.classList.remove('bg-primary', 'text-white');
        btn.classList.add('bg-gray-200', 'dark:bg-gray-700', 'text-gray-700', 'dark:text-gray-300');
    });
    
    const activeBtn = document.getElementById(`filter-${period}`);
    activeBtn.classList.remove('bg-gray-200', 'dark:bg-gray-700', 'text-gray-700', 'dark:text-gray-300');
    activeBtn.classList.add('bg-primary', 'text-white');
    
    // Reload page with period filter
    window.location.href = `<?= url('/community/leaderboard') ?>?period=${period}`;
}
</script>

</body>
</html>


