<?php
/**
 * Related Content Component
 * Shows related training programs on service pages and related services on course pages
 */

use Nebatech\Services\UnifiedSearchService;

// Component parameters
$contentType = $contentType ?? 'course'; // 'course' or 'service'
$contentId = $contentId ?? null;
$showTitle = $showTitle ?? true;

if (!$contentId) {
    return;
}

$searchService = new UnifiedSearchService();
$relatedContent = $searchService->getRelatedContent($contentType, $contentId);

if (empty($relatedContent)) {
    return;
}

$isShowingServices = $contentType === 'course';
$sectionTitle = $isShowingServices ? 'Need Professional Development?' : 'Learn These Skills Yourself';
$sectionSubtitle = $isShowingServices 
    ? 'Let our experts handle your project while you focus on learning'
    : 'Master the skills with our hands-on training programs';
$ctaText = $isShowingServices ? 'View Our Services' : 'Start Learning';
$ctaUrl = $isShowingServices ? url('/services') : url('/programmes');
$iconClass = $isShowingServices ? 'fas fa-briefcase' : 'fas fa-graduation-cap';
$colorScheme = $isShowingServices ? 'green' : 'blue';
?>

<section class="py-12 bg-<?= $colorScheme ?>-50 border-t border-<?= $colorScheme ?>-100">
    <div class="container mx-auto px-6">
        <?php if ($showTitle): ?>
            <div class="text-center mb-8">
                <h3 class="text-2xl font-bold text-gray-900 mb-2 flex items-center justify-center">
                    <i class="<?= $iconClass ?> text-<?= $colorScheme ?>-600 mr-3"></i>
                    <?= htmlspecialchars($sectionTitle) ?>
                </h3>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    <?= htmlspecialchars($sectionSubtitle) ?>
                </p>
            </div>
        <?php endif; ?>
        
        <div class="grid grid-cols-1 md:grid-cols-<?= min(count($relatedContent), 3) ?> gap-6 mb-8">
            <?php foreach (array_slice($relatedContent, 0, 3) as $item): ?>
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200">
                    <!-- Header -->
                    <div class="p-6">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex items-center space-x-2">
                                <div class="w-10 h-10 bg-<?= $colorScheme ?>-100 rounded-lg flex items-center justify-center">
                                    <i class="<?= $iconClass ?> text-<?= $colorScheme ?>-600"></i>
                                </div>
                                <span class="text-sm font-medium text-<?= $colorScheme ?>-700">
                                    <?= $isShowingServices ? 'Professional Service' : 'Training Program' ?>
                                </span>
                            </div>
                            
                            <?php if ($isShowingServices && !empty($item['price_range'])): ?>
                                <span class="text-sm font-semibold text-gray-700">
                                    <?= htmlspecialchars($item['price_range']) ?>
                                </span>
                            <?php elseif (!$isShowingServices && !empty($item['price'])): ?>
                                <span class="text-sm font-semibold text-gray-700">
                                    <?= $item['price'] == 0 ? 'Free' : 'GHS ' . number_format($item['price']) ?>
                                </span>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Title -->
                        <h4 class="text-lg font-semibold text-gray-900 mb-2">
                            <?= htmlspecialchars($item['title']) ?>
                        </h4>
                        
                        <!-- Description -->
                        <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                            <?= htmlspecialchars($item['short_description'] ?? substr(strip_tags($item['description'] ?? ''), 0, 120) . '...') ?>
                        </p>
                        
                        <!-- Meta Info -->
                        <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                            <?php if (!empty($item['duration'])): ?>
                                <span class="flex items-center">
                                    <i class="fas fa-clock mr-1"></i>
                                    <?= htmlspecialchars($item['duration']) ?>
                                </span>
                            <?php endif; ?>
                            
                            <?php if (!$isShowingServices && !empty($item['level'])): ?>
                                <span class="flex items-center">
                                    <i class="fas fa-signal mr-1"></i>
                                    <?= ucfirst($item['level']) ?>
                                </span>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Features -->
                        <?php if ($isShowingServices && !empty($item['features'])): ?>
                            <?php $features = is_string($item['features']) ? json_decode($item['features'], true) : $item['features']; ?>
                            <?php if (is_array($features) && !empty($features)): ?>
                                <ul class="text-sm text-gray-600 mb-4 space-y-1">
                                    <?php foreach (array_slice($features, 0, 3) as $feature): ?>
                                        <li class="flex items-center">
                                            <i class="fas fa-check text-green-500 mr-2"></i>
                                            <?= htmlspecialchars($feature) ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        <?php endif; ?>
                        
                        <!-- Action Button -->
                        <a href="<?= $isShowingServices ? url('/services/' . $item['slug']) : url('/programmes/' . $item['slug']) ?>" 
                           class="block w-full text-center bg-<?= $colorScheme ?>-600 text-white py-2 px-4 rounded-lg font-medium hover:bg-<?= $colorScheme ?>-700 transition-colors">
                            <?= $isShowingServices ? 'Get Quote' : 'Learn More' ?>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Call to Action -->
        <div class="text-center">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 max-w-2xl mx-auto">
                <h4 class="text-lg font-semibold text-gray-900 mb-2">
                    <?= $isShowingServices ? 'Ready to Get Professional Help?' : 'Ready to Start Learning?' ?>
                </h4>
                <p class="text-gray-600 mb-4">
                    <?= $isShowingServices 
                        ? 'Get a custom quote for your project and let our experts handle the technical details.'
                        : 'Join thousands of students who have mastered these skills through our comprehensive programs.' ?>
                </p>
                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    <a href="<?= $ctaUrl ?>" 
                       class="bg-<?= $colorScheme ?>-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-<?= $colorScheme ?>-700 transition-colors">
                        <i class="<?= $iconClass ?> mr-2"></i>
                        <?= $ctaText ?>
                    </a>
                    <?php if ($isShowingServices): ?>
                        <a href="<?= url('/contact') ?>" 
                           class="border border-<?= $colorScheme ?>-600 text-<?= $colorScheme ?>-600 px-6 py-3 rounded-lg font-semibold hover:bg-<?= $colorScheme ?>-50 transition-colors">
                            <i class="fas fa-phone mr-2"></i>
                            Contact Us
                        </a>
                    <?php else: ?>
                        <a href="<?= url('/about') ?>" 
                           class="border border-<?= $colorScheme ?>-600 text-<?= $colorScheme ?>-600 px-6 py-3 rounded-lg font-semibold hover:bg-<?= $colorScheme ?>-50 transition-colors">
                            <i class="fas fa-info-circle mr-2"></i>
                            Learn More
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
