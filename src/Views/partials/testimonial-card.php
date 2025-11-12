<?php
/**
 * Testimonial Card Component
 * Individual testimonial card for grid/carousel layouts
 */

$isService = $testimonial['type'] === 'service';
$isCourse = $testimonial['type'] === 'course';
$rating = (int)($testimonial['rating'] ?? 5);
$hasRelatedContent = !empty($testimonial['related_title']);
?>

<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 h-full flex flex-col hover:shadow-md transition-shadow duration-200">
    <!-- Header -->
    <div class="flex items-start justify-between mb-4">
        <div class="flex items-center space-x-3">
            <!-- Avatar -->
            <?php if (!empty($testimonial['client_image'])): ?>
                <img src="<?= asset($testimonial['client_image']) ?>" 
                     alt="<?= htmlspecialchars($testimonial['client_name']) ?>"
                     class="w-12 h-12 rounded-full object-cover">
            <?php else: ?>
                <div class="w-12 h-12 bg-primary rounded-full flex items-center justify-center">
                    <span class="text-white font-semibold text-lg">
                        <?= strtoupper(substr($testimonial['client_name'], 0, 1)) ?>
                    </span>
                </div>
            <?php endif; ?>
            
            <!-- Client Info -->
            <div>
                <h4 class="font-semibold text-gray-900"><?= htmlspecialchars($testimonial['client_name']) ?></h4>
                <?php if (!empty($testimonial['client_position'])): ?>
                    <p class="text-sm text-gray-600">
                        <?= htmlspecialchars($testimonial['client_position']) ?>
                        <?php if (!empty($testimonial['client_company'])): ?>
                            at <?= htmlspecialchars($testimonial['client_company']) ?>
                        <?php endif; ?>
                    </p>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Type Badge -->
        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                     <?= $isCourse ? 'bg-blue-100 text-blue-800' : ($isService ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800') ?>">
            <?php if ($isCourse): ?>
                <i class="fas fa-graduation-cap mr-1"></i>
                Student
            <?php elseif ($isService): ?>
                <i class="fas fa-briefcase mr-1"></i>
                Client
            <?php else: ?>
                <i class="fas fa-user mr-1"></i>
                Community
            <?php endif; ?>
        </span>
    </div>
    
    <!-- Rating -->
    <div class="flex items-center mb-3">
        <?php for ($i = 1; $i <= 5; $i++): ?>
            <svg class="w-4 h-4 <?= $i <= $rating ? 'text-yellow-400' : 'text-gray-300' ?>" 
                 fill="currentColor" viewBox="0 0 20 20">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
            </svg>
        <?php endfor; ?>
        <span class="ml-2 text-sm text-gray-600"><?= $rating ?>/5</span>
    </div>
    
    <!-- Testimonial Content -->
    <div class="flex-1">
        <blockquote class="text-gray-700 leading-relaxed">
            "<?= htmlspecialchars($testimonial['content']) ?>"
        </blockquote>
    </div>
    
    <!-- Related Content Link -->
    <?php if ($hasRelatedContent): ?>
        <div class="mt-4 pt-4 border-t border-gray-100">
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-500">
                    <?= $isCourse ? 'Completed:' : 'Project:' ?>
                </span>
                <a href="<?= $isCourse ? url('/programmes/' . $testimonial['related_slug']) : url('/services/' . $testimonial['related_slug']) ?>" 
                   class="text-sm font-medium text-primary hover:text-blue-700 transition-colors">
                    <?= htmlspecialchars($testimonial['related_title']) ?>
                    <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>
    <?php endif; ?>
    
    <!-- Cross-Promotional Footer -->
    <?php if ($isCourse): ?>
        <div class="mt-4 pt-3 border-t border-gray-100">
            <div class="flex items-center justify-between text-sm">
                <span class="text-gray-600">Need professional development?</span>
                <a href="<?= url('/services') ?>" class="text-green-600 hover:text-green-700 font-medium">
                    Our Services →
                </a>
            </div>
        </div>
    <?php elseif ($isService): ?>
        <div class="mt-4 pt-3 border-t border-gray-100">
            <div class="flex items-center justify-between text-sm">
                <span class="text-gray-600">Want to learn these skills?</span>
                <a href="<?= url('/programmes') ?>" class="text-blue-600 hover:text-blue-700 font-medium">
                    Start Learning →
                </a>
            </div>
        </div>
    <?php endif; ?>
</div>
