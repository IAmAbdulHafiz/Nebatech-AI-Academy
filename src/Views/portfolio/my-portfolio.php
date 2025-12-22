<?php
$title = 'My Portfolio';
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

<!-- Add Project Modal -->
<div id="addProjectModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <div class="p-6 border-b border-gray-200 flex items-center justify-between">
            <h3 class="text-xl font-bold text-gray-900">
                <i class="fas fa-plus-circle text-primary mr-2"></i>Add Project to Portfolio
            </h3>
            <button onclick="closeAddProjectModal()" class="text-gray-400 hover:text-gray-600 transition">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        
        <form id="addProjectForm" class="p-6">
            <!-- Available Submissions -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Select a Completed Project</label>
                <?php if (empty($available_submissions)): ?>
                    <div class="bg-gray-50 rounded-lg p-6 text-center">
                        <i class="fas fa-tasks text-4xl text-gray-300 mb-3"></i>
                        <p class="text-gray-600 mb-2">No eligible submissions found</p>
                        <p class="text-sm text-gray-500">Complete assignments with a score of 70% or higher to add them to your portfolio</p>
                    </div>
                <?php else: ?>
                    <div class="space-y-2 max-h-48 overflow-y-auto border border-gray-200 rounded-lg p-2">
                        <?php foreach ($available_submissions as $sub): ?>
                            <label class="flex items-center p-3 rounded-lg hover:bg-blue-50 cursor-pointer transition border border-transparent hover:border-blue-200">
                                <input type="radio" name="submission_id" value="<?= $sub['id'] ?>" class="w-4 h-4 text-primary focus:ring-primary" required>
                                <div class="ml-3 flex-1">
                                    <div class="font-medium text-gray-900"><?= htmlspecialchars($sub['assignment_title']) ?></div>
                                    <div class="text-sm text-gray-500">
                                        <?= htmlspecialchars($sub['course_title']) ?> • Score: <?= $sub['score'] ?>%
                                    </div>
                                </div>
                                <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-medium">
                                    <?= $sub['score'] ?>%
                                </span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Project Title -->
            <div class="mb-4">
                <label for="projectTitle" class="block text-sm font-medium text-gray-700 mb-2">Project Title *</label>
                <input type="text" id="projectTitle" name="title" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition"
                       placeholder="Enter a title for your project">
            </div>
            
            <!-- Description -->
            <div class="mb-4">
                <label for="projectDescription" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea id="projectDescription" name="description" rows="4"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition resize-none"
                          placeholder="Describe your project, what you learned, and what challenges you overcame..."></textarea>
            </div>
            
            <!-- Visibility Options -->
            <div class="flex gap-6 mb-6">
                <label class="flex items-center cursor-pointer">
                    <input type="checkbox" name="is_public" value="1" checked
                           class="w-4 h-4 text-primary focus:ring-primary rounded">
                    <span class="ml-2 text-sm text-gray-700">
                        <i class="fas fa-eye text-green-600 mr-1"></i>Make Public
                    </span>
                </label>
                <label class="flex items-center cursor-pointer">
                    <input type="checkbox" name="is_featured" value="1"
                           class="w-4 h-4 text-secondary focus:ring-secondary rounded">
                    <span class="ml-2 text-sm text-gray-700">
                        <i class="fas fa-star text-yellow-500 mr-1"></i>Feature This Project
                    </span>
                </label>
            </div>
            
            <!-- Actions -->
            <div class="flex gap-3 justify-end pt-4 border-t border-gray-200">
                <button type="button" onclick="closeAddProjectModal()" 
                        class="px-6 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition font-medium">
                    Cancel
                </button>
                <button type="submit" <?= empty($available_submissions) ? 'disabled' : '' ?>
                        class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-blue-700 transition font-medium disabled:opacity-50 disabled:cursor-not-allowed">
                    <i class="fas fa-plus mr-2"></i>Add to Portfolio
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Project Modal -->
<div id="editProjectModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <div class="p-6 border-b border-gray-200 flex items-center justify-between">
            <h3 class="text-xl font-bold text-gray-900">
                <i class="fas fa-edit text-primary mr-2"></i>Edit Project
            </h3>
            <button onclick="closeEditProjectModal()" class="text-gray-400 hover:text-gray-600 transition">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        
        <form id="editProjectForm" class="p-6">
            <input type="hidden" id="editItemId" name="item_id">
            
            <!-- Project Title -->
            <div class="mb-4">
                <label for="editProjectTitle" class="block text-sm font-medium text-gray-700 mb-2">Project Title *</label>
                <input type="text" id="editProjectTitle" name="title" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition"
                       placeholder="Enter a title for your project">
            </div>
            
            <!-- Description -->
            <div class="mb-4">
                <label for="editProjectDescription" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea id="editProjectDescription" name="description" rows="4"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition resize-none"
                          placeholder="Describe your project..."></textarea>
            </div>
            
            <!-- Visibility Options -->
            <div class="flex gap-6 mb-6">
                <label class="flex items-center cursor-pointer">
                    <input type="checkbox" id="editIsPublic" name="is_public" value="1"
                           class="w-4 h-4 text-primary focus:ring-primary rounded">
                    <span class="ml-2 text-sm text-gray-700">
                        <i class="fas fa-eye text-green-600 mr-1"></i>Make Public
                    </span>
                </label>
                <label class="flex items-center cursor-pointer">
                    <input type="checkbox" id="editIsFeatured" name="is_featured" value="1"
                           class="w-4 h-4 text-secondary focus:ring-secondary rounded">
                    <span class="ml-2 text-sm text-gray-700">
                        <i class="fas fa-star text-yellow-500 mr-1"></i>Feature This Project
                    </span>
                </label>
            </div>
            
            <!-- Actions -->
            <div class="flex gap-3 justify-end pt-4 border-t border-gray-200">
                <button type="button" onclick="closeEditProjectModal()" 
                        class="px-6 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition font-medium">
                    Cancel
                </button>
                <button type="submit" 
                        class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-blue-700 transition font-medium">
                    <i class="fas fa-save mr-2"></i>Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Portfolio data for editing
const portfolioData = <?= json_encode($portfolio) ?>;

function showAddProjectModal() {
    document.getElementById('addProjectModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeAddProjectModal() {
    document.getElementById('addProjectModal').classList.add('hidden');
    document.body.style.overflow = '';
    document.getElementById('addProjectForm').reset();
}

function editProject(id) {
    const project = portfolioData.find(p => p.id == id);
    if (!project) {
        showError('Project not found');
        return;
    }
    
    document.getElementById('editItemId').value = id;
    document.getElementById('editProjectTitle').value = project.title || '';
    document.getElementById('editProjectDescription').value = project.description || '';
    document.getElementById('editIsPublic').checked = project.is_public == 1 || project.is_visible == 1;
    document.getElementById('editIsFeatured').checked = project.is_featured == 1 || project.featured == 1;
    
    document.getElementById('editProjectModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeEditProjectModal() {
    document.getElementById('editProjectModal').classList.add('hidden');
    document.body.style.overflow = '';
    document.getElementById('editProjectForm').reset();
}

// Add Project Form Submit
document.getElementById('addProjectForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    try {
        const response = await fetch('<?= url('/portfolio/items/add') ?>', {
            method: 'POST',
            body: formData
        });
        const data = await response.json();
        
        if (data.success) {
            showSuccess('Project added to portfolio successfully!');
            closeAddProjectModal();
            setTimeout(() => window.location.reload(), 1000);
        } else {
            showError(data.error || 'Failed to add project');
        }
    } catch (error) {
        showError('Error: ' + error.message);
    }
});

// Edit Project Form Submit
document.getElementById('editProjectForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    try {
        const response = await fetch('<?= url('/portfolio/items/update') ?>', {
            method: 'POST',
            body: formData
        });
        const data = await response.json();
        
        if (data.success) {
            showSuccess('Project updated successfully!');
            closeEditProjectModal();
            setTimeout(() => window.location.reload(), 1000);
        } else {
            showError(data.error || 'Failed to update project');
        }
    } catch (error) {
        showError('Error: ' + error.message);
    }
});

async function deleteProject(id) {
    const confirmed = await confirmAction('Are you sure you want to delete this project?', {
        title: 'Delete Project',
        confirmText: 'Delete',
        type: 'danger'
    });
    
    if (!confirmed) return;
    
    try {
        const response = await fetch('<?= url('/portfolio/items/delete') ?>', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: 'item_id=' + id
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

// Close modals on escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeAddProjectModal();
        closeEditProjectModal();
    }
});

// Close modals on backdrop click
document.getElementById('addProjectModal').addEventListener('click', function(e) {
    if (e.target === this) closeAddProjectModal();
});
document.getElementById('editProjectModal').addEventListener('click', function(e) {
    if (e.target === this) closeEditProjectModal();
});
</script>
