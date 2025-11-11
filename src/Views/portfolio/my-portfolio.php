<?php
$title = 'My Portfolio';
ob_start();
include __DIR__ . '/../partials/student-sidebar.php';
$sidebarContent = ob_get_clean();
ob_start();
?>

<!-- Page Header -->
<div class="mb-6 flex items-center justify-between">
    <div>
        <h1 class="text-3xl font-bold text-gray-900 mb-2">My Portfolio</h1>
        <p class="text-gray-600">Showcase your best work to potential employers</p>
    </div>
    <button onclick="showAddProjectModal()" class="px-6 py-3 bg-primary text-white rounded-lg hover:bg-blue-700 transition font-medium">
        <i class="fas fa-plus mr-2"></i>Add Project
    </button>
</div>

<!-- Stats -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
        <div class="text-sm text-gray-600 mb-1">Total Projects</div>
        <div class="text-2xl font-bold text-primary"><?= $stats['total_projects'] ?></div>
    </div>
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
        <div class="text-sm text-gray-600 mb-1">Public Projects</div>
        <div class="text-2xl font-bold text-green-600"><?= $stats['public_projects'] ?></div>
    </div>
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
        <div class="text-sm text-gray-600 mb-1">Featured</div>
        <div class="text-2xl font-bold text-secondary"><?= $stats['featured_projects'] ?></div>
    </div>
</div>

<!-- Portfolio Grid -->
<?php if (empty($portfolio)): ?>
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
        <i class="fas fa-briefcase text-6xl text-gray-300 mb-4"></i>
        <h3 class="text-xl font-bold text-gray-900 mb-2">No Projects Yet</h3>
        <p class="text-gray-600 mb-6">Start building your portfolio by adding your completed projects</p>
        <button onclick="showAddProjectModal()" class="px-6 py-3 bg-primary text-white rounded-lg hover:bg-blue-700 transition font-medium">
            <i class="fas fa-plus mr-2"></i>Add Your First Project
        </button>
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
                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 transition flex items-center justify-center opacity-0 group-hover:opacity-100">
                        <a href="<?= url('/portfolio/project/' . $project['id']) ?>" class="px-4 py-2 bg-white text-primary rounded-lg font-medium">
                            View Project
                        </a>
                    </div>
                </div>

                <!-- Project Info -->
                <div class="p-4">
                    <div class="flex items-start justify-between mb-2">
                        <h3 class="font-bold text-gray-900 text-lg line-clamp-1"><?= htmlspecialchars($project['title']) ?></h3>
                        <span class="<?= $project['is_public'] ? 'text-green-600' : 'text-gray-400' ?>" title="<?= $project['is_public'] ? 'Public' : 'Private' ?>">
                            <i class="fas fa-<?= $project['is_public'] ? 'eye' : 'eye-slash' ?>"></i>
                        </span>
                    </div>
                    <p class="text-sm text-gray-600 mb-3 line-clamp-2"><?= htmlspecialchars($project['description']) ?></p>
                    
                    <!-- Technologies -->
                    <?php if (!empty($project['technologies'])): ?>
                        <?php $techs = json_decode($project['technologies'], true); ?>
                        <div class="flex flex-wrap gap-2 mb-3">
                            <?php foreach (array_slice($techs, 0, 3) as $tech): ?>
                                <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs font-medium"><?= htmlspecialchars($tech) ?></span>
                            <?php endforeach; ?>
                            <?php if (count($techs) > 3): ?>
                                <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs font-medium">+<?= count($techs) - 3 ?></span>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <!-- Actions -->
                    <div class="flex gap-2 pt-3 border-t border-gray-200">
                        <button onclick="editProject(<?= $project['id'] ?>)" class="flex-1 px-3 py-2 bg-blue-50 text-blue-700 rounded hover:bg-blue-100 transition text-sm font-medium">
                            <i class="fas fa-edit mr-1"></i>Edit
                        </button>
                        <button onclick="deleteProject(<?= $project['id'] ?>)" class="flex-1 px-3 py-2 bg-red-50 text-red-700 rounded hover:bg-red-100 transition text-sm font-medium">
                            <i class="fas fa-trash mr-1"></i>Delete
                        </button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<script>
function showAddProjectModal() {
    showInfo('Add Project Modal - To be implemented');
}

function editProject(id) {
    showInfo('Edit Project ' + id + ' - To be implemented');
}

async function deleteProject(id) {
    const confirmed = await confirmAction('Are you sure you want to delete this project?', {
        title: 'Delete Project',
        confirmText: 'Delete',
        type: 'danger'
    });
    
    if (!confirmed) return;
    
    try {
        const response = await fetch('<?= url('/portfolio/delete') ?>', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: 'portfolio_id=' + id
        });
        const data = await response.json();
        
        if (data.success) {
            showSuccess('Project deleted successfully');
            setTimeout(() => window.location.reload(), 1000);
        } else {
            showError('Error: ' + (data.error || 'Failed to delete project'));
        }
    } catch (error) {
        showError('Error: ' + error.message);
    }
}
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/dashboard.php';
?>
