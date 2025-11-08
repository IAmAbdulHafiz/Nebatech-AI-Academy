<?php require_once __DIR__ . '/../layouts/main.php'; ?>

<div class="min-h-screen bg-gray-50 py-8" x-data="portfolioManager()">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">
                    <i class="fas fa-briefcase text-purple-600"></i>
                    Manage Portfolio
                </h1>
                <p class="text-gray-600">Showcase your best work and achievements</p>
            </div>
            
            <a href="<?= url('/portfolio/' . $_SESSION['user']['email']) ?>" target="_blank" 
               class="px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                <i class="fas fa-external-link-alt mr-2"></i>
                View Public Portfolio
            </a>
        </div>

        <?php if (isset($_SESSION['flash_message'])): ?>
            <div class="mb-6 p-4 rounded-lg <?= $_SESSION['flash_type'] === 'success' ? 'bg-green-50 text-green-800 border border-green-200' : 'bg-red-50 text-red-800 border border-red-200' ?>">
                <i class="fas fa-<?= $_SESSION['flash_type'] === 'success' ? 'check-circle' : 'exclamation-circle' ?> mr-2"></i>
                <?= $_SESSION['flash_message'] ?>
            </div>
            <?php unset($_SESSION['flash_message'], $_SESSION['flash_type']); ?>
        <?php endif; ?>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-purple-600">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm mb-1">Portfolio Items</p>
                        <p class="text-3xl font-bold text-gray-900"><?= count($items) ?></p>
                    </div>
                    <i class="fas fa-code text-purple-600 text-3xl"></i>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-blue-600">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm mb-1">Certificates</p>
                        <p class="text-3xl font-bold text-gray-900"><?= count($certificates) ?></p>
                    </div>
                    <i class="fas fa-certificate text-blue-600 text-3xl"></i>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-yellow-600">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm mb-1">Badges Earned</p>
                        <p class="text-3xl font-bold text-gray-900"><?= $badge_stats['total_badges'] ?></p>
                    </div>
                    <i class="fas fa-trophy text-yellow-600 text-3xl"></i>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-green-600">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm mb-1">Total Points</p>
                        <p class="text-3xl font-bold text-gray-900"><?= $badge_stats['total_points'] ?></p>
                    </div>
                    <i class="fas fa-star text-green-600 text-3xl"></i>
                </div>
            </div>
        </div>

        <!-- Tabs -->
        <div class="bg-white rounded-xl shadow-sm mb-8">
            <div class="border-b border-gray-200">
                <nav class="flex -mb-px">
                    <button @click="activeTab = 'projects'" 
                            :class="activeTab === 'projects' ? 'border-purple-600 text-purple-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                            class="px-6 py-4 border-b-2 font-semibold transition">
                        <i class="fas fa-code mr-2"></i>Projects
                    </button>
                    <button @click="activeTab = 'certificates'" 
                            :class="activeTab === 'certificates' ? 'border-purple-600 text-purple-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                            class="px-6 py-4 border-b-2 font-semibold transition">
                        <i class="fas fa-certificate mr-2"></i>Certificates
                    </button>
                    <button @click="activeTab = 'badges'" 
                            :class="activeTab === 'badges' ? 'border-purple-600 text-purple-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                            class="px-6 py-4 border-b-2 font-semibold transition">
                        <i class="fas fa-trophy mr-2"></i>Badges
                    </button>
                    <button @click="activeTab = 'settings'" 
                            :class="activeTab === 'settings' ? 'border-purple-600 text-purple-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                            class="px-6 py-4 border-b-2 font-semibold transition">
                        <i class="fas fa-cog mr-2"></i>Settings
                    </button>
                </nav>
            </div>
            
            <!-- Projects Tab -->
            <div x-show="activeTab === 'projects'" class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold text-gray-900">Portfolio Projects</h2>
                    <button @click="showAddModal = true" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                        <i class="fas fa-plus mr-2"></i>Add Project
                    </button>
                </div>
                
                <?php if (!empty($items)): ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <?php foreach ($items as $item): ?>
                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200 hover:border-purple-300 transition">
                                <div class="flex justify-between items-start mb-3">
                                    <h3 class="font-bold text-gray-900"><?= htmlspecialchars($item['title']) ?></h3>
                                    <div class="flex gap-2">
                                        <?php if ($item['is_featured']): ?>
                                            <span class="text-yellow-500" title="Featured">
                                                <i class="fas fa-star"></i>
                                            </span>
                                        <?php endif; ?>
                                        <?php if (!$item['is_public']): ?>
                                            <span class="text-gray-400" title="Private">
                                                <i class="fas fa-lock"></i>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                
                                <p class="text-sm text-gray-600 mb-3 line-clamp-2">
                                    <?= htmlspecialchars($item['description'] ?? 'No description') ?>
                                </p>
                                
                                <div class="text-xs text-gray-500 mb-3">
                                    <i class="fas fa-book mr-1"></i>
                                    <?= htmlspecialchars($item['course_title']) ?>
                                </div>
                                
                                <div class="flex gap-2">
                                    <a href="<?= url('/portfolio/items/' . $item['id']) ?>" target="_blank"
                                       class="flex-1 text-center px-3 py-2 bg-purple-100 text-purple-700 rounded hover:bg-purple-200 transition text-sm">
                                        <i class="fas fa-eye mr-1"></i>View
                                    </a>
                                    <button onclick="editItem('<?= $item['id'] ?>')"
                                            class="flex-1 px-3 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition text-sm">
                                        <i class="fas fa-edit mr-1"></i>Edit
                                    </button>
                                    <button onclick="deleteItem('<?= $item['id'] ?>')"
                                            class="px-3 py-2 bg-red-100 text-red-700 rounded hover:bg-red-200 transition text-sm">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-12">
                        <i class="fas fa-folder-open text-gray-300 text-5xl mb-4"></i>
                        <p class="text-gray-600 mb-4">No projects in portfolio yet</p>
                        <button @click="showAddModal = true" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                            Add Your First Project
                        </button>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Certificates Tab -->
            <div x-show="activeTab === 'certificates'" class="p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Your Certificates</h2>
                
                <?php if (!empty($certificates)): ?>
                    <div class="space-y-4">
                        <?php foreach ($certificates as $cert): ?>
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-200">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-gradient-to-br from-purple-600 to-purple-800 rounded-lg flex items-center justify-center text-white text-xl">
                                        <i class="fas fa-certificate"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-gray-900"><?= htmlspecialchars($cert['course_title']) ?></h3>
                                        <p class="text-sm text-gray-600">
                                            Issued on <?= date('F j, Y', strtotime($cert['issue_date'])) ?>
                                        </p>
                                        <p class="text-xs text-gray-500 font-mono"><?= htmlspecialchars($cert['certificate_number']) ?></p>
                                    </div>
                                </div>
                                
                                <div class="flex gap-2">
                                    <?php if ($cert['pdf_path']): ?>
                                        <a href="<?= url('/certificates/' . $cert['id'] . '/download') ?>" 
                                           class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                                            <i class="fas fa-download mr-2"></i>Download PDF
                                        </a>
                                    <?php endif; ?>
                                    <a href="<?= url('/certificates/verify/' . $cert['verification_code']) ?>" target="_blank"
                                       class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                                        <i class="fas fa-check-circle mr-2"></i>Verify
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-12">
                        <i class="fas fa-certificate text-gray-300 text-5xl mb-4"></i>
                        <p class="text-gray-600 mb-2">No certificates yet</p>
                        <p class="text-sm text-gray-500">Complete courses to earn certificates</p>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Badges Tab -->
            <div x-show="activeTab === 'badges'" class="p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Achievement Badges</h2>
                
                <?php if (!empty($badges)): ?>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        <?php foreach ($badges as $badge): ?>
                            <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg p-4 text-center border-2 border-purple-200">
                                <div class="text-4xl mb-2">
                                    <i class="fas <?= htmlspecialchars($badge['icon']) ?> text-purple-600"></i>
                                </div>
                                <h3 class="font-bold text-gray-900 text-sm mb-1"><?= htmlspecialchars($badge['name']) ?></h3>
                                <p class="text-xs text-gray-600 mb-2"><?= htmlspecialchars($badge['description']) ?></p>
                                <div class="flex justify-between items-center text-xs">
                                    <span class="text-purple-600 font-semibold"><?= $badge['points'] ?> pts</span>
                                    <span class="text-gray-500"><?= date('M Y', strtotime($badge['earned_at'])) ?></span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-12">
                        <i class="fas fa-trophy text-gray-300 text-5xl mb-4"></i>
                        <p class="text-gray-600 mb-2">No badges earned yet</p>
                        <p class="text-sm text-gray-500">Complete lessons and assignments to earn badges</p>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Settings Tab -->
            <div x-show="activeTab === 'settings'" class="p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Portfolio Settings</h2>
                
                <form action="<?= url('/portfolio/settings') ?>" method="POST" class="space-y-6 max-w-2xl">
                    <!-- Bio -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Bio</label>
                        <textarea name="bio" rows="4" 
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                                  placeholder="Tell visitors about yourself..."><?= htmlspecialchars($settings['bio'] ?? '') ?></textarea>
                    </div>
                    
                    <!-- Tagline -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tagline</label>
                        <input type="text" name="tagline" 
                               value="<?= htmlspecialchars($settings['tagline'] ?? '') ?>"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                               placeholder="e.g., Aspiring Full-Stack Developer">
                    </div>
                    
                    <!-- Social Links -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fab fa-github mr-1"></i>GitHub URL
                            </label>
                            <input type="url" name="github_url" 
                                   value="<?= htmlspecialchars($settings['github_url'] ?? '') ?>"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                                   placeholder="https://github.com/username">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fab fa-linkedin mr-1"></i>LinkedIn URL
                            </label>
                            <input type="url" name="linkedin_url" 
                                   value="<?= htmlspecialchars($settings['linkedin_url'] ?? '') ?>"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                                   placeholder="https://linkedin.com/in/username">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fab fa-twitter mr-1"></i>Twitter URL
                            </label>
                            <input type="url" name="twitter_url" 
                                   value="<?= htmlspecialchars($settings['twitter_url'] ?? '') ?>"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                                   placeholder="https://twitter.com/username">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-globe mr-1"></i>Website URL
                            </label>
                            <input type="url" name="website_url" 
                                   value="<?= htmlspecialchars($settings['website_url'] ?? '') ?>"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                                   placeholder="https://yourwebsite.com">
                        </div>
                    </div>
                    
                    <!-- Privacy Settings -->
                    <div class="border-t pt-6">
                        <h3 class="font-semibold text-gray-900 mb-4">Privacy & Display</h3>
                        
                        <div class="space-y-3">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_public" <?= ($settings['is_public'] ?? true) ? 'checked' : '' ?>
                                       class="w-4 h-4 text-purple-600 rounded focus:ring-purple-500">
                                <span class="ml-3 text-gray-700">Make portfolio public</span>
                            </label>
                            
                            <label class="flex items-center">
                                <input type="checkbox" name="show_badges" <?= ($settings['show_badges'] ?? true) ? 'checked' : '' ?>
                                       class="w-4 h-4 text-purple-600 rounded focus:ring-purple-500">
                                <span class="ml-3 text-gray-700">Show badges</span>
                            </label>
                            
                            <label class="flex items-center">
                                <input type="checkbox" name="show_certificates" <?= ($settings['show_certificates'] ?? true) ? 'checked' : '' ?>
                                       class="w-4 h-4 text-purple-600 rounded focus:ring-purple-500">
                                <span class="ml-3 text-gray-700">Show certificates</span>
                            </label>
                            
                            <label class="flex items-center">
                                <input type="checkbox" name="show_contact" <?= ($settings['show_contact'] ?? true) ? 'checked' : '' ?>
                                       class="w-4 h-4 text-purple-600 rounded focus:ring-purple-500">
                                <span class="ml-3 text-gray-700">Show social links</span>
                            </label>
                        </div>
                    </div>
                    
                    <button type="submit" 
                            class="w-full px-6 py-3 bg-purple-600 text-white font-semibold rounded-lg hover:bg-purple-700 transition">
                        <i class="fas fa-save mr-2"></i>Save Settings
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Add Project Modal -->
    <div x-show="showAddModal" x-cloak 
         class="fixed inset-0 bg-black/50 flex items-center justify-center z-50"
         @click.self="showAddModal = false">
        <div class="bg-white rounded-xl max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto">
            <div class="p-6 border-b">
                <h3 class="text-xl font-bold">Add Project to Portfolio</h3>
            </div>
            
            <div class="p-6">
                <?php if (!empty($available_submissions)): ?>
                    <div class="space-y-4">
                        <?php foreach ($available_submissions as $submission): ?>
                            <div class="border border-gray-200 rounded-lg p-4 hover:border-purple-300 transition">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-gray-900"><?= htmlspecialchars($submission['assignment_title']) ?></h4>
                                        <p class="text-sm text-gray-600"><?= htmlspecialchars($submission['course_title']) ?> - <?= htmlspecialchars($submission['lesson_title']) ?></p>
                                        <div class="mt-2">
                                            <span class="text-sm font-semibold text-purple-600">
                                                Score: <?= round(($submission['score'] / $submission['max_score']) * 100) ?>%
                                            </span>
                                        </div>
                                    </div>
                                    <button onclick="addToPortfolio('<?= $submission['id'] ?>', '<?= htmlspecialchars($submission['assignment_title']) ?>')"
                                            class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                                        <i class="fas fa-plus mr-1"></i>Add
                                    </button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-12">
                        <i class="fas fa-info-circle text-gray-300 text-5xl mb-4"></i>
                        <p class="text-gray-600">No eligible submissions available</p>
                        <p class="text-sm text-gray-500">Complete and get graded assignments to add them to your portfolio</p>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="p-6 border-t">
                <button @click="showAddModal = false" 
                        class="w-full px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script>
function portfolioManager() {
    return {
        activeTab: 'projects',
        showAddModal: false
    }
}

function addToPortfolio(submissionId, title) {
    fetch('<?= url('/portfolio/items/add') ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `submission_id=${submissionId}&title=${encodeURIComponent(title)}&is_public=1`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Project added to portfolio!');
            location.reload();
        } else {
            alert('Error: ' + data.error);
        }
    });
}

function deleteItem(itemId) {
    if (!confirm('Remove this project from your portfolio?')) return;
    
    fetch('<?= url('/portfolio/items/delete') ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `item_id=${itemId}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Error: ' + data.error);
        }
    });
}
</script>

<style>
[x-cloak] { display: none !important; }
</style>
