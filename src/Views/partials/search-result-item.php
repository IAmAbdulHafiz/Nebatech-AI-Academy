<?php
/**
 * Search Result Item Partial
 * Displays a unified search result item (course, service, or blog post)
 */

$contentType = $item['content_type'] ?? 'unknown';
$isService = $contentType === 'service';
$isCourse = $contentType === 'course';
$isBlog = $contentType === 'blog_post';

// Determine URLs and icons
$itemUrl = '';
$icon = 'fas fa-file';
$badgeColor = 'gray';
$badgeText = 'Content';

if ($isCourse) {
    $itemUrl = url('/programmes/' . $item['slug']);
    $icon = 'fas fa-graduation-cap';
    $badgeColor = 'blue';
    $badgeText = 'Training Program';
} elseif ($isService) {
    $itemUrl = url('/services/' . $item['slug']);
    $icon = 'fas fa-briefcase';
    $badgeColor = 'green';
    $badgeText = 'Service';
} elseif ($isBlog) {
    $itemUrl = url('/blog/' . $item['slug']);
    $icon = 'fas fa-blog';
    $badgeColor = 'purple';
    $badgeText = 'Blog Post';
}

$thumbnail = $item['thumbnail'] ?? '';
$price = '';
if ($isCourse && !empty($item['price'])) {
    $price = $item['price'] == 0 ? 'Free' : 'GHS ' . number_format($item['price']);
} elseif ($isService && !empty($item['price_range'])) {
    $price = $item['price_range'];
}
?>

<div class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200 mb-6">
    <div class="flex p-6">
        <!-- Thumbnail -->
        <div class="flex-shrink-0 mr-4">
            <?php if (!empty($thumbnail)): ?>
                <img src="<?= asset($thumbnail) ?>" 
                     alt="<?= htmlspecialchars($item['title']) ?>"
                     class="w-20 h-20 object-cover rounded-lg">
            <?php else: ?>
                <div class="w-20 h-20 bg-gray-100 rounded-lg flex items-center justify-center">
                    <i class="<?= $icon ?> text-2xl text-gray-400"></i>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Content -->
        <div class="flex-1 min-w-0">
            <div class="flex items-start justify-between mb-2">
                <div class="flex items-center space-x-2">
                    <!-- Content Type Badge -->
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-<?= $badgeColor ?>-100 text-<?= $badgeColor ?>-800">
                        <i class="<?= $icon ?> mr-1"></i>
                        <?= $badgeText ?>
                    </span>
                    
                    <!-- Featured Badge -->
                    <?php if (!empty($item['is_featured'])): ?>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                            <i class="fas fa-star mr-1"></i>
                            Featured
                        </span>
                    <?php endif; ?>
                    
                    <!-- Category -->
                    <?php if (!empty($item['category_name'])): ?>
                        <span class="text-xs text-gray-500">
                            <?= htmlspecialchars($item['category_name']) ?>
                        </span>
                    <?php endif; ?>
                </div>
                
                <!-- Price -->
                <?php if (!empty($price)): ?>
                    <span class="text-lg font-semibold text-primary">
                        <?= htmlspecialchars($price) ?>
                    </span>
                <?php endif; ?>
            </div>
            
            <!-- Title -->
            <h3 class="text-lg font-semibold text-gray-900 mb-2 hover:text-primary transition-colors">
                <a href="<?= $itemUrl ?>" class="block">
                    <?= htmlspecialchars($item['title']) ?>
                </a>
            </h3>
            
            <!-- Description -->
            <p class="text-gray-600 text-sm mb-3 line-clamp-2">
                <?= htmlspecialchars($item['short_description'] ?? substr(strip_tags($item['description'] ?? ''), 0, 150) . '...') ?>
            </p>
            
            <!-- Meta Information -->
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4 text-sm text-gray-500">
                    <?php if ($isCourse): ?>
                        <?php if (!empty($item['duration'])): ?>
                            <span class="flex items-center">
                                <i class="fas fa-clock mr-1"></i>
                                <?= htmlspecialchars($item['duration']) ?>
                            </span>
                        <?php endif; ?>
                        
                        <?php if (!empty($item['level'])): ?>
                            <span class="flex items-center">
                                <i class="fas fa-signal mr-1"></i>
                                <?= ucfirst($item['level']) ?>
                            </span>
                        <?php endif; ?>
                        
                    <?php elseif ($isService): ?>
                        <?php if (!empty($item['duration'])): ?>
                            <span class="flex items-center">
                                <i class="fas fa-calendar mr-1"></i>
                                <?= htmlspecialchars($item['duration']) ?>
                            </span>
                        <?php endif; ?>
                        
                    <?php elseif ($isBlog): ?>
                        <span class="flex items-center">
                            <i class="fas fa-calendar mr-1"></i>
                            <?= date('M j, Y', strtotime($item['created_at'])) ?>
                        </span>
                    <?php endif; ?>
                </div>
                
                <!-- Action Button -->
                <a href="<?= $itemUrl ?>" 
                   class="inline-flex items-center px-4 py-2 bg-primary text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                    <?php if ($isCourse): ?>
                        <i class="fas fa-play mr-2"></i>
                        Start Learning
                    <?php elseif ($isService): ?>
                        <i class="fas fa-arrow-right mr-2"></i>
                        Learn More
                    <?php else: ?>
                        <i class="fas fa-eye mr-2"></i>
                        Read More
                    <?php endif; ?>
                </a>
            </div>
        </div>
    </div>
    
    <!-- Cross-Promotional Footer -->
    <?php if ($isCourse && $userContext === 'visitor'): ?>
        <div class="border-t border-gray-100 px-6 py-3 bg-blue-50">
            <div class="flex items-center justify-between text-sm">
                <span class="text-blue-700">
                    <i class="fas fa-lightbulb mr-1"></i>
                    Need this built professionally?
                </span>
                <a href="<?= url('/services') ?>" class="text-blue-600 hover:text-blue-800 font-medium">
                    View Our Services →
                </a>
            </div>
        </div>
    <?php elseif ($isService && $userContext === 'visitor'): ?>
        <div class="border-t border-gray-100 px-6 py-3 bg-green-50">
            <div class="flex items-center justify-between text-sm">
                <span class="text-green-700">
                    <i class="fas fa-graduation-cap mr-1"></i>
                    Want to learn these skills?
                </span>
                <a href="<?= url('/programmes') ?>" class="text-green-600 hover:text-green-800 font-medium">
                    Browse Training →
                </a>
            </div>
        </div>
    <?php endif; ?>
</div>
