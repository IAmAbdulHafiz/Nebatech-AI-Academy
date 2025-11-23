<?php
/**
 * Unified Search Results Page
 * Shows search results across courses, services, and blog posts
 */

$hasResults = !empty($results['total_count']);
$showFilters = !empty($query) || !empty(array_filter($filters));

$content = ob_start();
?>

<div class="min-h-screen bg-gray-50">
    <!-- Search Header -->
    <div class="bg-white border-b border-gray-200">
        <div class="container mx-auto px-6 py-8">
            <div class="max-w-4xl mx-auto">
                <!-- Search Form -->
                <form method="GET" action="<?= url('/search') ?>" class="mb-6">
                    <div class="relative">
                        <input type="text" 
                               name="q" 
                               value="<?= htmlspecialchars($query) ?>"
                               placeholder="<?= htmlspecialchars($searchPlaceholder) ?>"
                               class="w-full px-6 py-4 pl-12 text-lg border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                               autocomplete="off"
                               x-data="searchAutocomplete()"
                               @input="getSuggestions($event.target.value)"
                               @focus="showSuggestions = true"
                               @blur="setTimeout(() => showSuggestions = false, 200)">
                        <svg class="w-6 h-6 absolute left-4 top-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        
                        <!-- Search Suggestions Dropdown -->
                        <div x-show="showSuggestions && suggestions.length > 0" 
                             x-cloak
                             class="absolute top-full left-0 right-0 bg-white border border-gray-200 rounded-lg shadow-lg mt-1 z-50">
                            <template x-for="suggestion in suggestions" :key="suggestion">
                                <div class="px-4 py-2 hover:bg-gray-50 cursor-pointer border-b border-gray-100 last:border-b-0"
                                     @click="document.querySelector('input[name=q]').value = suggestion; document.querySelector('form').submit();"
                                     x-text="suggestion">
                                </div>
                            </template>
                        </div>
                    </div>
                    
                    <!-- Preserve existing filters -->
                    <?php foreach ($filters as $key => $value): ?>
                        <?php if (!empty($value)): ?>
                            <input type="hidden" name="<?= htmlspecialchars($key) ?>" value="<?= htmlspecialchars($value) ?>">
                        <?php endif; ?>
                    <?php endforeach; ?>
                </form>
                
                <!-- Search Stats -->
                <?php if (!empty($query)): ?>
                    <div class="flex items-center justify-between">
                        <p class="text-gray-600">
                            <?php if ($hasResults): ?>
                                Found <strong><?= number_format($results['total_count']) ?></strong> results for "<strong><?= htmlspecialchars($query) ?></strong>"
                            <?php else: ?>
                                No results found for "<strong><?= htmlspecialchars($query) ?></strong>"
                            <?php endif; ?>
                        </p>
                        
                        <?php if ($hasResults): ?>
                            <div class="flex items-center space-x-4 text-sm">
                                <span class="text-gray-500">Sort by:</span>
                                <select class="border border-gray-300 rounded px-3 py-1 text-sm" onchange="updateSort(this.value)">
                                    <option value="relevance">Relevance</option>
                                    <option value="newest">Newest First</option>
                                    <option value="popular">Most Popular</option>
                                    <option value="title">Title A-Z</option>
                                </select>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <div class="container mx-auto px-6 py-8">
        <div class="max-w-6xl mx-auto">
            <?php if ($hasResults): ?>
                <div class="flex gap-8">
                    <!-- Filters Sidebar -->
                    <div class="w-64 flex-shrink-0">
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 sticky top-6">
                            <h3 class="font-semibold text-gray-900 mb-4">Filter Results</h3>
                            
                            <!-- Content Type Filter -->
                            <div class="mb-6">
                                <h4 class="font-medium text-gray-700 mb-2">Content Type</h4>
                                <div class="space-y-2">
                                    <label class="flex items-center">
                                        <input type="checkbox" class="rounded border-gray-300 text-primary" 
                                               <?= empty($filters['type']) || $filters['type'] === 'course' ? 'checked' : '' ?>
                                               onchange="toggleFilter('type', 'course', this.checked)">
                                        <span class="ml-2 text-sm">Training Programs (<?= count($results['courses']) ?>)</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" class="rounded border-gray-300 text-primary"
                                               <?= empty($filters['type']) || $filters['type'] === 'service' ? 'checked' : '' ?>
                                               onchange="toggleFilter('type', 'service', this.checked)">
                                        <span class="ml-2 text-sm">Services (<?= count($results['services']) ?>)</span>
                                    </label>
                                    <?php if (!empty($results['blog_posts'])): ?>
                                        <label class="flex items-center">
                                            <input type="checkbox" class="rounded border-gray-300 text-primary"
                                                   <?= empty($filters['type']) || $filters['type'] === 'blog' ? 'checked' : '' ?>
                                                   onchange="toggleFilter('type', 'blog', this.checked)">
                                            <span class="ml-2 text-sm">Blog Posts (<?= count($results['blog_posts']) ?>)</span>
                                        </label>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <!-- Featured Content -->
                            <div class="mb-6">
                                <label class="flex items-center">
                                    <input type="checkbox" class="rounded border-gray-300 text-primary"
                                           <?= !empty($filters['featured']) ? 'checked' : '' ?>
                                           onchange="toggleFilter('featured', '1', this.checked)">
                                    <span class="ml-2 text-sm font-medium text-gray-700">Featured Only</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Results -->
                    <div class="flex-1">
                        <!-- Results Tabs -->
                        <div class="flex space-x-1 mb-6" x-data="{ activeTab: 'all' }">
                            <button @click="activeTab = 'all'" 
                                    :class="activeTab === 'all' ? 'bg-primary text-white' : 'bg-white text-gray-700 hover:bg-gray-50'"
                                    class="px-4 py-2 rounded-lg font-medium transition-colors">
                                All Results (<?= $results['total_count'] ?>)
                            </button>
                            <?php if (!empty($results['courses'])): ?>
                                <button @click="activeTab = 'courses'"
                                        :class="activeTab === 'courses' ? 'bg-primary text-white' : 'bg-white text-gray-700 hover:bg-gray-50'"
                                        class="px-4 py-2 rounded-lg font-medium transition-colors">
                                    Training (<?= count($results['courses']) ?>)
                                </button>
                            <?php endif; ?>
                            <?php if (!empty($results['services'])): ?>
                                <button @click="activeTab = 'services'"
                                        :class="activeTab === 'services' ? 'bg-primary text-white' : 'bg-white text-gray-700 hover:bg-gray-50'"
                                        class="px-4 py-2 rounded-lg font-medium transition-colors">
                                    Services (<?= count($results['services']) ?>)
                                </button>
                            <?php endif; ?>
                        </div>
                        
                        <!-- All Results -->
                        <div x-show="activeTab === 'all'" class="space-y-8">
                            <?php if (!empty($results['all'])): ?>
                                <?php foreach ($results['all'] as $item): ?>
                                    <?php include __DIR__ . '/../partials/search-result-item.php'; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Course Results -->
                        <div x-show="activeTab === 'courses'" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <?php foreach ($results['courses'] as $course): ?>
                                <?php include __DIR__ . '/../partials/course-card.php'; ?>
                            <?php endforeach; ?>
                        </div>
                        
                        <!-- Service Results -->
                        <div x-show="activeTab === 'services'" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <?php foreach ($results['services'] as $service): ?>
                                <?php include __DIR__ . '/../partials/service-card.php'; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                
            <?php else: ?>
                <!-- No Results -->
                <div class="text-center py-12">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">No results found</h3>
                    <p class="text-gray-600 mb-6">Try adjusting your search terms or browse our popular content below.</p>
                    
                    <!-- Popular Content -->
                    <div class="max-w-4xl mx-auto">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">Popular Content</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <?php 
                            $popularContent = array_merge(
                                array_slice($results['courses'] ?? [], 0, 3),
                                array_slice($results['services'] ?? [], 0, 3)
                            );
                            foreach ($popularContent as $item): 
                            ?>
                                <?php include __DIR__ . '/../partials/search-result-item.php'; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Cross-Promotional Content -->
<?php if ($hasResults): ?>
    <div class="bg-gray-100 py-12">
        <div class="container mx-auto px-6">
            <?php include __DIR__ . '/../partials/cross-promotion.php'; ?>
        </div>
    </div>
<?php endif; ?>

<script>
function searchAutocomplete() {
    return {
        suggestions: [],
        showSuggestions: false,
        
        async getSuggestions(query) {
            if (query.length < 2) {
                this.suggestions = [];
                return;
            }
            
            try {
                const response = await fetch(`<?= url('/search/suggestions') ?>?q=${encodeURIComponent(query)}`);
                this.suggestions = await response.json();
            } catch (error) {
                console.error('Error fetching suggestions:', error);
                this.suggestions = [];
            }
        }
    }
}

function toggleFilter(filterName, filterValue, checked) {
    const url = new URL(window.location);
    if (checked) {
        url.searchParams.set(filterName, filterValue);
    } else {
        url.searchParams.delete(filterName);
    }
    window.location = url.toString();
}

function updateSort(sortBy) {
    const url = new URL(window.location);
    url.searchParams.set('sort', sortBy);
    window.location = url.toString();
}
</script>

<?php 
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php'; 
?>
