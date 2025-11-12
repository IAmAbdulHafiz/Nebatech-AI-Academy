<?php
/**
 * Cross-Promotional Content Component
 * Shows relevant promotional content based on user context and current section
 */

use Nebatech\Services\UserContextService;

$currentSection = UserContextService::getCurrentSection();
$userContext = UserContextService::getUserContext();
$promotionalContent = UserContextService::getCrossPromotionalContent($currentSection, $userContext);

if (empty($promotionalContent)) {
    return;
}
?>

<?php foreach ($promotionalContent as $content): ?>
    <?php if ($content['type'] === 'banner'): ?>
        <!-- Banner Promotion -->
        <div class="bg-gradient-to-r from-<?= $content['color'] ?>-500 to-<?= $content['color'] ?>-600 text-white py-3 px-6 rounded-lg mb-6">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <h4 class="font-bold text-lg mb-1"><?= htmlspecialchars($content['title']) ?></h4>
                    <p class="text-<?= $content['color'] ?>-100"><?= htmlspecialchars($content['message']) ?></p>
                </div>
                <div class="ml-4">
                    <a href="<?= $content['url'] ?>" 
                       class="bg-white text-<?= $content['color'] ?>-600 px-4 py-2 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                        <?= htmlspecialchars($content['cta']) ?>
                    </a>
                </div>
            </div>
        </div>
    
    <?php elseif ($content['type'] === 'sidebar'): ?>
        <!-- Sidebar Promotion -->
        <div class="bg-<?= $content['color'] ?>-50 border border-<?= $content['color'] ?>-200 rounded-lg p-4 mb-4">
            <h4 class="font-semibold text-<?= $content['color'] ?>-800 mb-2"><?= htmlspecialchars($content['title']) ?></h4>
            <p class="text-<?= $content['color'] ?>-700 text-sm mb-3"><?= htmlspecialchars($content['message']) ?></p>
            <a href="<?= $content['url'] ?>" 
               class="inline-block bg-<?= $content['color'] ?>-600 text-white px-3 py-2 rounded text-sm font-semibold hover:bg-<?= $content['color'] ?>-700 transition-colors">
                <?= htmlspecialchars($content['cta']) ?>
            </a>
        </div>
    
    <?php elseif ($content['type'] === 'inline'): ?>
        <!-- Inline Promotion -->
        <div class="border-l-4 border-<?= $content['color'] ?>-500 bg-<?= $content['color'] ?>-50 p-4 mb-4">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="w-5 h-5 text-<?= $content['color'] ?>-500 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3 flex-1">
                    <h4 class="font-medium text-<?= $content['color'] ?>-800"><?= htmlspecialchars($content['title']) ?></h4>
                    <p class="text-<?= $content['color'] ?>-700 text-sm mt-1"><?= htmlspecialchars($content['message']) ?></p>
                    <div class="mt-2">
                        <a href="<?= $content['url'] ?>" 
                           class="text-<?= $content['color'] ?>-600 hover:text-<?= $content['color'] ?>-800 font-medium text-sm">
                            <?= htmlspecialchars($content['cta']) ?> →
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php endforeach; ?>

<?php if ($currentSection === 'academy' && $userContext === 'student'): ?>
    <!-- Special Academy Student Promotion -->
    <div class="bg-gradient-to-r from-purple-500 to-pink-500 text-white rounded-lg p-4 mb-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="ml-3 flex-1">
                <h4 class="font-bold">Ready for Real Projects?</h4>
                <p class="text-purple-100 text-sm">Apply your skills on professional projects and earn while you learn.</p>
            </div>
            <div class="ml-4">
                <a href="<?= url('/services/freelance') ?>" 
                   class="bg-white text-purple-600 px-3 py-2 rounded font-semibold text-sm hover:bg-gray-100 transition-colors">
                    View Opportunities
                </a>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php if ($currentSection === 'corporate' && $userContext === 'visitor'): ?>
    <!-- Corporate Visitor Promotion -->
    <div class="bg-gradient-to-r from-green-500 to-blue-500 text-white rounded-lg p-4 mb-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                </svg>
            </div>
            <div class="ml-3 flex-1">
                <h4 class="font-bold">Want to Learn These Skills?</h4>
                <p class="text-green-100 text-sm">Join our training programs and master the technologies we use in our projects.</p>
            </div>
            <div class="ml-4">
                <a href="<?= url('/programmes') ?>" 
                   class="bg-white text-green-600 px-3 py-2 rounded font-semibold text-sm hover:bg-gray-100 transition-colors">
                    Start Learning
                </a>
            </div>
        </div>
    </div>
<?php endif; ?>
