<?php
$title = 'Student Showcase';
ob_start();
include __DIR__ . '/../partials/student-sidebar.php';
$sidebarContent = ob_get_clean();
ob_start();
?>

<!-- Page Header -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-2">Student Showcase</h1>
    <p class="text-gray-600">Explore amazing projects built by our students</p>
</div>

<!-- Featured Projects -->
<?php if (!empty($featured)): ?>
<div class="mb-8">
    <h2 class="text-2xl font-bold text-gray-900 mb-4">
        <i class="fas fa-star text-secondary mr-2"></i>Featured Projects
    </h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($featured as $project): ?>
            <div class="bg-white rounded-lg shadow-sm border-2 border-secondary overflow-hidden hover:shadow-xl transition group">
                <!-- Project Thumbnail -->
                <div class="h-56 bg-gradient-to-br from-secondary to-orange-600 flex items-center justify-center relative overflow-hidden">
                    <?php if (!empty($project['thumbnail'])): ?>
                        <img src="<?= htmlspecialchars($project['thumbnail']) ?>" alt="<?= htmlspecialchars($project['title']) ?>" class="w-full h-full object-cover">
                    <?php else: ?>
                        <i class="fas fa-code text-white text-6xl opacity-50"></i>
                    <?php endif; ?>
                    <div class="absolute top-3 right-3 bg-white text-secondary px-3 py-1 rounded-full text-xs font-bold shadow-lg">
                        <i class="fas fa-star mr-1"></i>Featured
                    </div>
                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition flex items-center justify-center opacity-0 group-hover:opacity-100">
                        <a href="<?= url('/portfolio/' . $project['user_id']) ?>" class="px-6 py-3 bg-white text-primary rounded-lg font-bold shadow-lg">
                            View Portfolio
                        </a>
                    </div>
                </div>

                <!-- Project Info -->
                <div class="p-6">
                    <h3 class="font-bold text-gray-900 text-xl mb-2 line-clamp-1"><?= htmlspecialchars($project['title']) ?></h3>
                    <p class="text-sm text-gray-600 mb-3 line-clamp-2"><?= htmlspecialchars($project['description']) ?></p>
                    
                    <!-- Student Info -->
                    <div class="flex items-center gap-3 mb-4 pb-4 border-b border-gray-200">
                        <div class="w-10 h-10 bg-primary text-white rounded-full flex items-center justify-center font-bold">
                            <?= strtoupper(substr($project['first_name'], 0, 1) . substr($project['last_name'], 0, 1)) ?>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900"><?= htmlspecialchars($project['first_name'] . ' ' . $project['last_name']) ?></p>
                            <?php if (!empty($project['course_title'])): ?>
                                <p class="text-xs text-gray-500"><?= htmlspecialchars($project['course_title']) ?></p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Technologies -->
                    <?php if (!empty($project['technologies'])): ?>
                        <?php $techs = json_decode($project['technologies'], true); ?>
                        <div class="flex flex-wrap gap-2">
                            <?php foreach (array_slice($techs, 0, 4) as $tech): ?>
                                <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs font-medium"><?= htmlspecialchars($tech) ?></span>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<!-- All Projects -->
<div>
    <h2 class="text-2xl font-bold text-gray-900 mb-4">All Projects</h2>
    
    <?php if (empty($portfolios)): ?>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
            <i class="fas fa-folder-open text-6xl text-gray-300 mb-4"></i>
            <h3 class="text-xl font-bold text-gray-900 mb-2">No Projects Yet</h3>
            <p class="text-gray-600">Be the first to showcase your work!</p>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <?php foreach ($portfolios as $project): ?>
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg transition group">
                    <!-- Project Thumbnail -->
                    <div class="h-48 bg-gradient-to-br from-primary to-blue-700 flex items-center justify-center relative overflow-hidden">
                        <?php if (!empty($project['thumbnail'])): ?>
                            <img src="<?= htmlspecialchars($project['thumbnail']) ?>" alt="<?= htmlspecialchars($project['title']) ?>" class="w-full h-full object-cover">
                        <?php else: ?>
                            <i class="fas fa-code text-white text-5xl opacity-50"></i>
                        <?php endif; ?>
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 transition flex items-center justify-center opacity-0 group-hover:opacity-100">
                            <a href="<?= url('/portfolio/' . $project['user_id']) ?>" class="px-4 py-2 bg-white text-primary rounded-lg font-medium">
                                View
                            </a>
                        </div>
                    </div>

                    <!-- Project Info -->
                    <div class="p-4">
                        <h3 class="font-bold text-gray-900 mb-1 line-clamp-1"><?= htmlspecialchars($project['title']) ?></h3>
                        <p class="text-xs text-gray-500 mb-2">
                            by <?= htmlspecialchars($project['first_name'] . ' ' . $project['last_name']) ?>
                        </p>
                        <p class="text-sm text-gray-600 line-clamp-2 mb-3"><?= htmlspecialchars($project['description']) ?></p>
                        
                        <!-- Technologies -->
                        <?php if (!empty($project['technologies'])): ?>
                            <?php $techs = json_decode($project['technologies'], true); ?>
                            <div class="flex flex-wrap gap-1">
                                <?php foreach (array_slice($techs, 0, 3) as $tech): ?>
                                    <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs"><?= htmlspecialchars($tech) ?></span>
                                <?php endforeach; ?>
                                <?php if (count($techs) > 3): ?>
                                    <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs">+<?= count($techs) - 3 ?></span>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/dashboard.php';
?>
