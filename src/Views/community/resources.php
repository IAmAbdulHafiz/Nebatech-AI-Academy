<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resource Library - Nebatech AI Academy</title>
    
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
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2 flex items-center gap-3">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                Resource Library
            </h1>
            <p class="text-gray-600 dark:text-gray-400">
                Share and discover learning resources curated by the community
            </p>
        </div>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="/community/resources/create" 
               class="px-6 py-3 bg-primary text-white rounded-lg hover:bg-primary-dark transition-colors font-medium flex items-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                <span>Share Resource</span>
            </a>
        <?php endif; ?>
    </div>

    <!-- Filters -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Search -->
            <div class="md:col-span-2">
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" 
                           id="resource-search"
                           placeholder="Search resources..."
                           class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary">
                </div>
            </div>

            <!-- Type Filter -->
            <select id="type-filter" 
                    class="px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                <option value="">All Types</option>
                <option value="file">Files</option>
                <option value="link">Links</option>
                <option value="video">Videos</option>
                <option value="article">Articles</option>
            </select>

            <!-- Category Filter -->
            <select id="category-filter"
                    class="px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                <option value="">All Categories</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['icon'] . ' ' . $cat['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Resources Grid -->
        <div class="lg:col-span-2">
            <div id="resources-grid" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <?php foreach ($resources as $resource): ?>
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-md transition-shadow overflow-hidden">
                        <!-- Thumbnail -->
                        <div class="relative h-48 bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                            <?php if ($resource['thumbnail']): ?>
                                <img src="<?= htmlspecialchars($resource['thumbnail']) ?>" 
                                     alt="<?= htmlspecialchars($resource['title']) ?>"
                                     class="w-full h-full object-cover">
                            <?php else: ?>
                                <?php 
                                $typeIcons = [
                                    'file' => '<svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>',
                                    'video' => '<svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>',
                                    'article' => '<svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>',
                                    'link' => '<svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>'
                                ];
                                echo $typeIcons[$resource['type']] ?? $typeIcons['file'];
                                ?>
                            <?php endif; ?>
                            
                            <!-- Type Badge -->
                            <span class="absolute top-3 right-3 px-2 py-1 bg-white/90 dark:bg-gray-800/90 rounded-full text-xs font-medium">
                                <?= ucfirst($resource['type']) ?>
                            </span>
                        </div>

                        <!-- Content -->
                        <div class="p-4">
                            <h3 class="font-semibold text-gray-900 dark:text-white mb-2 line-clamp-2">
                                <a href="/community/resources/<?= $resource['uuid'] ?>" class="hover:text-primary">
                                    <?= htmlspecialchars($resource['title']) ?>
                                </a>
                            </h3>
                            
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-3 line-clamp-2">
                                <?= htmlspecialchars($resource['description']) ?>
                            </p>

                            <!-- Tags -->
                            <?php if ($resource['tags']): 
                                $tags = is_string($resource['tags']) ? json_decode($resource['tags'], true) : $resource['tags'];
                                if ($tags && is_array($tags)):
                            ?>
                                <div class="flex flex-wrap gap-1 mb-3">
                                    <?php foreach (array_slice($tags, 0, 3) as $tag): ?>
                                        <span class="px-2 py-0.5 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded text-xs">
                                            #<?= htmlspecialchars($tag) ?>
                                        </span>
                                    <?php endforeach; ?>
                                </div>
                            <?php 
                                endif;
                            endif; 
                            ?>

                            <!-- Meta -->
                            <div class="flex items-center justify-between text-sm text-gray-600 dark:text-gray-400 pt-3 border-t border-gray-200 dark:border-gray-700">
                                <div class="flex items-center space-x-3">
                                    <span class="flex items-center space-x-1">
                                        <span>📥</span>
                                        <span><?= number_format($resource['downloads_count']) ?></span>
                                    </span>
                                    <span class="flex items-center space-x-1">
                                        <span>👁️</span>
                                        <span><?= number_format($resource['views_count']) ?></span>
                                    </span>
                                </div>
                                <span class="text-xs"><?= date('M j', strtotime($resource['created_at'])) ?></span>
                            </div>

                            <!-- Author -->
                            <div class="flex items-center space-x-2 mt-3 pt-3 border-t border-gray-200 dark:border-gray-700">
                                <img src="<?= htmlspecialchars($resource['avatar'] ?? 'https://ui-avatars.com/api/?name=' . urlencode($resource['first_name'])) ?>" 
                                     alt="<?= htmlspecialchars($resource['first_name']) ?>"
                                     class="w-6 h-6 rounded-full">
                                <span class="text-sm text-gray-700 dark:text-gray-300">
                                    <?= htmlspecialchars($resource['first_name'] . ' ' . $resource['last_name']) ?>
                                </span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <?php if (empty($resources)): ?>
                <div class="text-center py-12">
                    <p class="text-gray-500 dark:text-gray-400 text-lg mb-4">No resources found</p>
                    <a href="/community/resources/create" class="text-primary hover:underline">
                        Be the first to share a resource!
                    </a>
                </div>
            <?php endif; ?>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Stats -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="font-semibold text-gray-900 dark:text-white mb-4">📊 Library Stats</h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 dark:text-gray-400">Total Resources</span>
                        <span class="font-semibold text-gray-900 dark:text-white"><?= count($resources) ?></span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 dark:text-gray-400">Contributors</span>
                        <span class="font-semibold text-gray-900 dark:text-white"><?= count(array_unique(array_column($resources, 'user_id'))) ?></span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 dark:text-gray-400">Total Downloads</span>
                        <span class="font-semibold text-gray-900 dark:text-white"><?= number_format(array_sum(array_column($resources, 'downloads_count'))) ?></span>
                    </div>
                </div>
            </div>

            <!-- Trending Resources -->
            <?php if (!empty($trendingResources)): ?>
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-orange-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 23a7.5 7.5 0 01-5.138-12.963C8.204 8.774 11.5 6.5 11 1.5c6 4 9 8 3 14 1 0 2.5 0 5-2.47.27.773.5 1.604.5 2.47A7.5 7.5 0 0112 23z"/></svg>
                        Trending
                    </h3>
                    <div class="space-y-3">
                        <?php foreach ($trendingResources as $tr): ?>
                            <a href="/community/resources/<?= $tr['uuid'] ?>" 
                               class="block p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <div class="font-medium text-gray-900 dark:text-white text-sm line-clamp-1 mb-1">
                                    <?= htmlspecialchars($tr['title']) ?>
                                </div>
                                <div class="text-xs text-gray-600 dark:text-gray-400 flex items-center space-x-2">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                        <?= number_format($tr['downloads_count']) ?>
                                    </span>
                                    <span>•</span>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        <?= number_format($tr['views_count']) ?>
                                    </span>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Upload Guidelines -->
            <div class="bg-gradient-to-br from-blue-50 to-purple-50 dark:from-blue-900/20 dark:to-purple-900/20 rounded-lg p-6 border border-white/20 dark:border-primary/80">
                <h3 class="font-semibold text-gray-900 dark:text-white mb-3 flex items-center gap-2">
                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Guidelines
                </h3>
                <ul class="space-y-2 text-sm text-gray-700 dark:text-gray-300">
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-green-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        <span>Share high-quality, relevant resources</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-green-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        <span>Provide clear descriptions</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-green-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        <span>Tag appropriately</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-red-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                        <span>No copyrighted material</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>
</body>
</html>

<script>
// Filter functionality
let debounceTimer;

document.getElementById('resource-search')?.addEventListener('input', function(e) {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(() => {
        filterResources();
    }, 500);
});

document.getElementById('type-filter')?.addEventListener('change', filterResources);
document.getElementById('category-filter')?.addEventListener('change', filterResources);

function filterResources() {
    const search = document.getElementById('resource-search').value;
    const type = document.getElementById('type-filter').value;
    const category = document.getElementById('category-filter').value;
    
    const params = new URLSearchParams();
    if (search) params.set('search', search);
    if (type) params.set('type', type);
    if (category) params.set('category', category);
    
    window.location.href = '/community/resources?' + params.toString();
}
</script>

