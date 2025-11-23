<?php
/**
 * Service Card Component
 * Displays a service in card format for search results and listings
 */

$service = $service ?? $item ?? [];
if (empty($service)) return;

$priceRange = $service['price_range'] ?? '';
$duration = $service['duration'] ?? '';
$categoryName = $service['category_name'] ?? '';
$features = $service['features'] ?? '';

// Parse features if it's JSON
if (is_string($features)) {
    $features = json_decode($features, true) ?? [];
}
if (!is_array($features)) {
    $features = [];
}
?>

<div class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200">
    <!-- Service Header -->
    <div class="p-6 border-b border-gray-100">
        <div class="flex items-start justify-between mb-3">
            <div class="flex items-center space-x-2">
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-briefcase text-green-600"></i>
                </div>
                
                <!-- Category -->
                <?php if (!empty($categoryName)): ?>
                    <span class="inline-block bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                        <?= htmlspecialchars($categoryName) ?>
                    </span>
                <?php endif; ?>
            </div>
            
            <!-- Featured Badge -->
            <?php if (!empty($service['is_featured'])): ?>
                <span class="bg-yellow-500 text-white px-2 py-1 rounded-full text-xs font-semibold">
                    <i class="fas fa-star mr-1"></i>
                    Featured
                </span>
            <?php endif; ?>
        </div>
        
        <!-- Title -->
        <h3 class="text-lg font-semibold text-gray-900 mb-2 hover:text-primary transition-colors">
            <a href="<?= url('/services/' . $service['slug']) ?>">
                <?= htmlspecialchars($service['title']) ?>
            </a>
        </h3>
        
        <!-- Description -->
        <p class="text-gray-600 text-sm mb-4 line-clamp-3">
            <?= htmlspecialchars($service['short_description'] ?? substr(strip_tags($service['description'] ?? ''), 0, 120) . '...') ?>
        </p>
        
        <!-- Service Meta -->
        <div class="flex items-center justify-between text-sm text-gray-500">
            <?php if (!empty($duration)): ?>
                <span class="flex items-center">
                    <i class="fas fa-calendar mr-1"></i>
                    <?= htmlspecialchars($duration) ?>
                </span>
            <?php endif; ?>
            
            <?php if (!empty($priceRange)): ?>
                <span class="text-lg font-semibold text-primary">
                    <?= htmlspecialchars($priceRange) ?>
                </span>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Features -->
    <?php if (!empty($features)): ?>
        <div class="p-6 border-b border-gray-100">
            <h4 class="font-medium text-gray-900 mb-3">What's Included:</h4>
            <ul class="space-y-2">
                <?php foreach (array_slice($features, 0, 4) as $feature): ?>
                    <li class="flex items-center text-sm text-gray-600">
                        <i class="fas fa-check text-green-500 mr-2"></i>
                        <?= htmlspecialchars($feature) ?>
                    </li>
                <?php endforeach; ?>
                <?php if (count($features) > 4): ?>
                    <li class="text-sm text-gray-500">
                        <i class="fas fa-plus mr-2"></i>
                        +<?= count($features) - 4 ?> more features
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    <?php endif; ?>
    
    <!-- Actions -->
    <div class="p-6">
        <div class="flex flex-col sm:flex-row gap-3">
            <a href="<?= url('/services/' . $service['slug']) ?>" 
               class="flex-1 text-center bg-primary text-white py-2 px-4 rounded-lg font-medium hover:bg-blue-700 transition-colors">
                <i class="fas fa-eye mr-2"></i>
                View Details
            </a>
            <a href="<?= url('/contact?service=' . urlencode($service['title'])) ?>" 
               class="flex-1 text-center border border-primary text-primary py-2 px-4 rounded-lg font-medium hover:bg-blue-50 transition-colors">
                <i class="fas fa-envelope mr-2"></i>
                Get Quote
            </a>
        </div>
    </div>
    
    <!-- Cross-Promotional Footer -->
    <div class="border-t border-gray-100 px-6 py-3 bg-blue-50">
        <div class="flex items-center justify-between text-sm">
            <span class="text-blue-700">
                <i class="fas fa-graduation-cap mr-1"></i>
                Want to learn these skills?
            </span>
            <a href="<?= url('/programmes') ?>" class="text-blue-600 hover:text-blue-800 font-medium">
                Browse Training →
            </a>
        </div>
    </div>
</div>
