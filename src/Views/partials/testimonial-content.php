<?php
/**
 * Testimonial Content Component
 * Displays testimonial content for list layout
 */

$isService = $testimonial['type'] === 'service';
$isCourse = $testimonial['type'] === 'course';
$rating = (int)($testimonial['rating'] ?? 5);
$hasRelatedContent = !empty($testimonial['related_title']);
?>

<div class="flex items-start space-x-4">
    <!-- Avatar -->
    <div class="flex-shrink-0">
        <?php if (!empty($testimonial['client_image'])): ?>
            <img src="<?= asset($testimonial['client_image']) ?>" 
                 alt="<?= htmlspecialchars($testimonial['client_name']) ?>"
                 class="w-16 h-16 rounded-full object-cover">
        <?php else: ?>
            <div class="w-16 h-16 bg-primary rounded-full flex items-center justify-center">
                <span class="text-white font-semibold text-xl">
                    <?= strtoupper(substr($testimonial['client_name'], 0, 1)) ?>
                </span>
            </div>
        <?php endif; ?>
    </div>
    
    <!-- Content -->
    <div class="flex-1">
        <!-- Header -->
        <div class="flex items-start justify-between mb-3">
            <div>
                <h4 class="font-semibold text-gray-900 text-lg"><?= htmlspecialchars($testimonial['client_name']) ?></h4>
                <?php if (!empty($testimonial['client_position'])): ?>
                    <p class="text-gray-600">
                        <?= htmlspecialchars($testimonial['client_position']) ?>
                        <?php if (!empty($testimonial['client_company'])): ?>
                            at <?= htmlspecialchars($testimonial['client_company']) ?>
                        <?php endif; ?>
                    </p>
                <?php endif; ?>
            </div>
            
            <!-- Type Badge -->
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                         <?= $isCourse ? 'bg-blue-100 text-blue-800' : ($isService ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800') ?>">
                <?php if ($isCourse): ?>
                    <i class="fas fa-graduation-cap mr-1"></i>
                    Student Success
                <?php elseif ($isService): ?>
                    <i class="fas fa-briefcase mr-1"></i>
                    Client Success
                <?php else: ?>
                    <i class="fas fa-user mr-1"></i>
                    Community Member
                <?php endif; ?>
            </span>
        </div>
        
        <!-- Rating -->
        <div class="flex items-center mb-4">
            <?php for ($i = 1; $i <= 5; $i++): ?>
                <svg class="w-5 h-5 <?= $i <= $rating ? 'text-yellow-400' : 'text-gray-300' ?>" 
                     fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
            <?php endfor; ?>
            <span class="ml-2 text-gray-600"><?= $rating ?>/5</span>
        </div>
        
        <!-- Testimonial Text -->
        <blockquote class="text-gray-700 text-lg leading-relaxed mb-4">
            "<?= htmlspecialchars($testimonial['content']) ?>"
        </blockquote>
        
        <!-- Related Content -->
        <?php if ($hasRelatedContent): ?>
            <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                <span class="text-sm text-gray-500">
                    <?= $isCourse ? 'Completed Program:' : 'Project:' ?>
                </span>
                <a href="<?= $isCourse ? url('/programmes/' . $testimonial['related_slug']) : url('/services/' . $testimonial['related_slug']) ?>" 
                   class="text-primary hover:text-blue-700 font-medium">
                    <?= htmlspecialchars($testimonial['related_title']) ?>
                    <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>
