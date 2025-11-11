<?php
$title = ($portfolio[0]['first_name'] ?? 'Student') . '\'s Portfolio';
ob_start();
include __DIR__ . '/../partials/student-sidebar.php';
$sidebarContent = ob_get_clean();
ob_start();
?>

<!-- Profile Header -->
<div class="bg-gradient-to-r from-primary to-blue-700 rounded-lg shadow-lg p-8 text-white mb-8">
    <div class="flex items-start gap-6">
        <div class="w-24 h-24 bg-white text-primary rounded-full flex items-center justify-center text-3xl font-bold">
            <?php if (!empty($portfolio[0])): ?>
                <?= strtoupper(substr($portfolio[0]['first_name'], 0, 1) . substr($portfolio[0]['last_name'], 0, 1)) ?>
            <?php else: ?>
                <i class="fas fa-user"></i>
            <?php endif; ?>
        </div>
        <div class="flex-1">
            <?php if (!empty($portfolio[0])): ?>
                <h1 class="text-3xl font-bold mb-2"><?= htmlspecialchars($portfolio[0]['first_name'] . ' ' . $portfolio[0]['last_name']) ?></h1>
                <p class="text-blue-100 mb-4">Student at Nebatech AI Academy</p>
            <?php else: ?>
                <h1 class="text-3xl font-bold mb-2">Student Portfolio</h1>
            <?php endif; ?>
            
            <!-- Stats -->
            <div class="flex gap-6 text-sm">
                <div>
                    <span class="font-bold text-2xl"><?= $stats['public_projects'] ?></span>
                    <span class="text-blue-100 ml-1">Projects</span>
                </div>
                <?php if ($stats['featured_projects'] > 0): ?>
                <div>
                    <span class="font-bold text-2xl"><?= $stats['featured_projects'] ?></span>
                    <span class="text-blue-100 ml-1">Featured</span>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Projects Grid -->
<?php if (empty($portfolio)): ?>
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
        <i class="fas fa-folder-open text-6xl text-gray-300 mb-4"></i>
        <h3 class="text-xl font-bold text-gray-900 mb-2">No Public Projects</h3>
        <p class="text-gray-600">This student hasn't published any projects yet</p>
    </div>
<?php else: ?>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($portfolio as $project): ?>
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg transition group">
                <!-- Project Thumbnail -->
                <div class="h-48 bg-gradient-to-br from-primary to-blue-700 flex items-center justify-center relative overflow-hidden">
                    <?php if (!empty($project['thumbnail'])): ?>
                        <img src="<?= htmlspecialchars($project['thumbnail']) ?>" alt="<?= htmlspecialchars($project['title']) ?>" class="w-full h-full object-cover">
                    <?php else: ?>
                        <i class="fas fa-code text-white text-5xl opacity-50"></i>
                    <?php endif; ?>
                    <?php if ($project['featured']): ?>
                        <div class="absolute top-2 right-2 bg-secondary text-white px-3 py-1 rounded-full text-xs font-bold">
                            <i class="fas fa-star mr-1"></i>Featured
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($project['project_url'])): ?>
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 transition flex items-center justify-center opacity-0 group-hover:opacity-100">
                            <a href="<?= htmlspecialchars($project['project_url']) ?>" target="_blank" 
                               class="px-4 py-2 bg-white text-primary rounded-lg font-medium">
                                <i class="fas fa-external-link-alt mr-2"></i>View Live
                            </a>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Project Info -->
                <div class="p-4">
                    <h3 class="font-bold text-gray-900 text-lg mb-2 line-clamp-1"><?= htmlspecialchars($project['title']) ?></h3>
                    <p class="text-sm text-gray-600 mb-3 line-clamp-3"><?= htmlspecialchars($project['description']) ?></p>
                    
                    <!-- Course Info -->
                    <?php if (!empty($project['course_title'])): ?>
                        <p class="text-xs text-gray-500 mb-3">
                            <i class="fas fa-graduation-cap mr-1"></i>
                            <?= htmlspecialchars($project['course_title']) ?>
                        </p>
                    <?php endif; ?>

                    <!-- Technologies -->
                    <?php if (!empty($project['technologies'])): ?>
                        <?php $techs = json_decode($project['technologies'], true); ?>
                        <div class="flex flex-wrap gap-2">
                            <?php foreach ($techs as $tech): ?>
                                <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs font-medium"><?= htmlspecialchars($tech) ?></span>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<!-- Back Button -->
<div class="mt-8 text-center">
    <a href="<?= url('/showcase') ?>" class="inline-block px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-medium">
        <i class="fas fa-arrow-left mr-2"></i>Back to Showcase
    </a>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/dashboard.php';
?>
