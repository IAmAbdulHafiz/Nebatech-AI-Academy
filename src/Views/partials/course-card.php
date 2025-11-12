<?php
/**
 * Course Card Component
 * Displays a course in card format for search results and listings
 */

$course = $course ?? $item ?? [];
if (empty($course)) return;

$price = $course['price'] ?? 0;
$priceDisplay = $price == 0 ? 'Free' : 'GHS ' . number_format($price);
$thumbnail = $course['thumbnail'] ?? '';
$level = $course['level'] ?? 'beginner';
$duration = $course['duration'] ?? '';
$categoryName = $course['category_name'] ?? '';
?>

<div class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200">
    <!-- Course Image -->
    <div class="relative">
        <?php if (!empty($thumbnail)): ?>
            <img src="<?= asset($thumbnail) ?>" 
                 alt="<?= htmlspecialchars($course['title']) ?>"
                 class="w-full h-48 object-cover rounded-t-lg">
        <?php else: ?>
            <div class="w-full h-48 bg-gradient-to-br from-blue-400 to-blue-600 rounded-t-lg flex items-center justify-center">
                <i class="fas fa-graduation-cap text-4xl text-white"></i>
            </div>
        <?php endif; ?>
        
        <!-- Featured Badge -->
        <?php if (!empty($course['is_featured'])): ?>
            <span class="absolute top-3 left-3 bg-yellow-500 text-white px-2 py-1 rounded-full text-xs font-semibold">
                <i class="fas fa-star mr-1"></i>
                Featured
            </span>
        <?php endif; ?>
        
        <!-- Price Badge -->
        <span class="absolute top-3 right-3 bg-primary text-white px-3 py-1 rounded-full text-sm font-semibold">
            <?= $priceDisplay ?>
        </span>
    </div>
    
    <!-- Course Content -->
    <div class="p-6">
        <!-- Category -->
        <?php if (!empty($categoryName)): ?>
            <span class="inline-block bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full mb-2">
                <?= htmlspecialchars($categoryName) ?>
            </span>
        <?php endif; ?>
        
        <!-- Title -->
        <h3 class="text-lg font-semibold text-gray-900 mb-2 hover:text-primary transition-colors">
            <a href="<?= url('/programmes/' . $course['slug']) ?>">
                <?= htmlspecialchars($course['title']) ?>
            </a>
        </h3>
        
        <!-- Description -->
        <p class="text-gray-600 text-sm mb-4 line-clamp-3">
            <?= htmlspecialchars($course['short_description'] ?? substr(strip_tags($course['description'] ?? ''), 0, 120) . '...') ?>
        </p>
        
        <!-- Course Meta -->
        <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
            <?php if (!empty($duration)): ?>
                <span class="flex items-center">
                    <i class="fas fa-clock mr-1"></i>
                    <?= htmlspecialchars($duration) ?>
                </span>
            <?php endif; ?>
            
            <span class="flex items-center">
                <i class="fas fa-signal mr-1"></i>
                <?= ucfirst($level) ?>
            </span>
        </div>
        
        <!-- Action Button -->
        <a href="<?= url('/programmes/' . $course['slug']) ?>" 
           class="block w-full text-center bg-primary text-white py-2 px-4 rounded-lg font-medium hover:bg-blue-700 transition-colors">
            <i class="fas fa-play mr-2"></i>
            Start Learning
        </a>
    </div>
    
    <!-- Cross-Promotional Footer -->
    <div class="border-t border-gray-100 px-6 py-3 bg-green-50">
        <div class="flex items-center justify-between text-sm">
            <span class="text-green-700">
                <i class="fas fa-briefcase mr-1"></i>
                Need this built professionally?
            </span>
            <a href="<?= url('/services') ?>" class="text-green-600 hover:text-green-800 font-medium">
                View Services →
            </a>
        </div>
    </div>
</div>
