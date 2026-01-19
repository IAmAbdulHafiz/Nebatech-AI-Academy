<?php
$title = 'Manage Success Stories';
ob_start();
include __DIR__ . '/../partials/admin-sidebar.php';
$sidebarContent = ob_get_clean();
ob_start();
?>

<!-- Page Header -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-2">Success Stories</h1>
    <p class="text-gray-600">Review and manage student testimonials</p>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600">Total</p>
                <p class="text-3xl font-bold text-gray-800"><?= $counts['total'] ?? 0 ?></p>
            </div>
            <div class="bg-gray-100 p-3 rounded-full">
                <i class="fas fa-star text-gray-600 text-2xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6 <?= $currentStatus === 'pending' ? 'ring-2 ring-yellow-400' : '' ?>">
        <a href="<?= url('/admin/success-stories?status=pending') ?>">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Pending Review</p>
                    <p class="text-3xl font-bold text-yellow-600"><?= $counts['pending'] ?? 0 ?></p>
                </div>
                <div class="bg-yellow-100 p-3 rounded-full">
                    <i class="fas fa-clock text-yellow-600 text-2xl"></i>
                </div>
            </div>
        </a>
    </div>

    <div class="bg-white rounded-lg shadow p-6 <?= $currentStatus === 'approved' ? 'ring-2 ring-green-400' : '' ?>">
        <a href="<?= url('/admin/success-stories?status=approved') ?>">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Approved</p>
                    <p class="text-3xl font-bold text-green-600"><?= $counts['approved'] ?? 0 ?></p>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <i class="fas fa-check-circle text-green-600 text-2xl"></i>
                </div>
            </div>
        </a>
    </div>

    <div class="bg-white rounded-lg shadow p-6 <?= $currentStatus === 'rejected' ? 'ring-2 ring-red-400' : '' ?>">
        <a href="<?= url('/admin/success-stories?status=rejected') ?>">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Rejected</p>
                    <p class="text-3xl font-bold text-red-600"><?= $counts['rejected'] ?? 0 ?></p>
                </div>
                <div class="bg-red-100 p-3 rounded-full">
                    <i class="fas fa-times-circle text-red-600 text-2xl"></i>
                </div>
            </div>
        </a>
    </div>
</div>

<!-- Filter Tabs -->
<div class="flex items-center gap-2 mb-6">
    <a href="<?= url('/admin/success-stories') ?>" 
       class="px-4 py-2 rounded-lg <?= $currentStatus === 'all' ? 'bg-primary text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' ?>">
        All Stories
    </a>
    <a href="<?= url('/admin/success-stories?status=pending') ?>" 
       class="px-4 py-2 rounded-lg <?= $currentStatus === 'pending' ? 'bg-yellow-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' ?>">
        Pending (<?= $counts['pending'] ?? 0 ?>)
    </a>
    <a href="<?= url('/admin/success-stories?status=approved') ?>" 
       class="px-4 py-2 rounded-lg <?= $currentStatus === 'approved' ? 'bg-green-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' ?>">
        Approved
    </a>
    <a href="<?= url('/admin/success-stories?status=rejected') ?>" 
       class="px-4 py-2 rounded-lg <?= $currentStatus === 'rejected' ? 'bg-red-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' ?>">
        Rejected
    </a>
</div>

<!-- Stories List -->
<div class="bg-white rounded-lg shadow">
    <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-xl font-bold text-gray-900">
            <i class="fas fa-quote-left text-primary mr-2"></i>
            <?= ucfirst($currentStatus) ?> Stories (<?= count($stories) ?>)
        </h2>
    </div>
    <div class="p-6">
        <?php if (empty($stories)): ?>
            <div class="text-center py-12 text-gray-500">
                <i class="fas fa-inbox text-6xl mb-4"></i>
                <p class="text-lg">No <?= $currentStatus === 'all' ? '' : $currentStatus ?> stories found</p>
                <p class="text-sm mt-2">Stories submitted by students will appear here</p>
            </div>
        <?php else: ?>
            <div class="space-y-6">
                <?php foreach ($stories as $story): ?>
                    <div class="border border-gray-200 rounded-lg p-6 hover:border-primary/50 transition" id="story-<?= $story['id'] ?>">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <!-- Header -->
                                <div class="flex items-center gap-4 mb-4">
                                    <div class="w-12 h-12 bg-primary text-white rounded-full flex items-center justify-center text-lg font-bold">
                                        <?= strtoupper(substr($story['name'], 0, 1) . substr(explode(' ', $story['name'])[1] ?? '', 0, 1)) ?>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-gray-900"><?= htmlspecialchars($story['name']) ?></h3>
                                        <p class="text-sm text-gray-600"><?= htmlspecialchars($story['email']) ?></p>
                                    </div>
                                    
                                    <!-- Status Badge -->
                                    <span class="ml-auto px-3 py-1 rounded-full text-sm font-medium
                                        <?php if ($story['status'] === 'pending'): ?>
                                            bg-yellow-100 text-yellow-800
                                        <?php elseif ($story['status'] === 'approved'): ?>
                                            bg-green-100 text-green-800
                                        <?php else: ?>
                                            bg-red-100 text-red-800
                                        <?php endif; ?>
                                    ">
                                        <?= ucfirst($story['status']) ?>
                                    </span>
                                </div>

                                <!-- Story Details -->
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4 text-sm">
                                    <?php if (!empty($story['role'])): ?>
                                    <div>
                                        <span class="text-gray-500">Role:</span>
                                        <span class="font-medium text-gray-800 ml-1"><?= htmlspecialchars($story['role']) ?></span>
                                    </div>
                                    <?php endif; ?>
                                    <?php if (!empty($story['course_completed'])): ?>
                                    <div>
                                        <span class="text-gray-500">Course:</span>
                                        <span class="font-medium text-gray-800 ml-1"><?= htmlspecialchars($story['course_completed']) ?></span>
                                    </div>
                                    <?php endif; ?>
                                    <?php if (!empty($story['current_position'])): ?>
                                    <div>
                                        <span class="text-gray-500">Position:</span>
                                        <span class="font-medium text-gray-800 ml-1"><?= htmlspecialchars($story['current_position']) ?></span>
                                    </div>
                                    <?php endif; ?>
                                </div>

                                <!-- Testimonial -->
                                <div class="bg-gray-50 rounded-lg p-4 mb-4">
                                    <p class="text-gray-700 italic">"<?= htmlspecialchars($story['testimonial']) ?>"</p>
                                </div>

                                <!-- Meta -->
                                <div class="text-sm text-gray-500">
                                    <i class="fas fa-calendar mr-1"></i>
                                    Submitted: <?= date('M j, Y \a\t g:i A', strtotime($story['created_at'])) ?>
                                    <?php if ($story['reviewed_at']): ?>
                                        <span class="mx-2">|</span>
                                        <i class="fas fa-user-check mr-1"></i>
                                        Reviewed: <?= date('M j, Y', strtotime($story['reviewed_at'])) ?>
                                    <?php endif; ?>
                                </div>

                                <?php if (!empty($story['admin_notes'])): ?>
                                <div class="mt-3 text-sm bg-blue-50 text-blue-800 px-3 py-2 rounded">
                                    <i class="fas fa-sticky-note mr-1"></i>
                                    Admin Notes: <?= htmlspecialchars($story['admin_notes']) ?>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Actions -->
                        <?php if ($story['status'] === 'pending'): ?>
                        <div class="flex items-center gap-3 mt-4 pt-4 border-t border-gray-200">
                            <button 
                                onclick="approveStory(<?= $story['id'] ?>)"
                                class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition"
                            >
                                <i class="fas fa-check mr-2"></i>
                                Approve
                            </button>
                            <button 
                                onclick="showRejectModal(<?= $story['id'] ?>)"
                                class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition"
                            >
                                <i class="fas fa-times mr-2"></i>
                                Reject
                            </button>
                        </div>
                        <?php else: ?>
                        <div class="flex items-center gap-3 mt-4 pt-4 border-t border-gray-200">
                            <?php if ($story['status'] === 'rejected'): ?>
                            <button 
                                onclick="approveStory(<?= $story['id'] ?>)"
                                class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition"
                            >
                                <i class="fas fa-check mr-2"></i>
                                Approve Instead
                            </button>
                            <?php endif; ?>
                            <button 
                                onclick="deleteStory(<?= $story['id'] ?>)"
                                class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition"
                            >
                                <i class="fas fa-trash mr-2"></i>
                                Delete
                            </button>
                        </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="fixed inset-0 bg-black/50 z-50 hidden flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4 p-6">
        <h3 class="text-xl font-bold text-gray-900 mb-4">Reject Story</h3>
        <form id="rejectForm">
            <input type="hidden" name="story_id" id="rejectStoryId">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Reason for rejection (optional)</label>
                <textarea 
                    name="admin_notes" 
                    id="rejectNotes"
                    rows="3" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                    placeholder="This feedback will not be shown to the user..."
                ></textarea>
            </div>
            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeRejectModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                    Confirm Rejection
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function approveStory(id) {
    if (!confirm('Are you sure you want to approve this story? It will be visible on the homepage.')) return;
    
    fetch('/admin/success-stories/approve', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'story_id=' + id
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert(data.message || 'Error approving story');
        }
    })
    .catch(err => alert('Error: ' + err.message));
}

function showRejectModal(id) {
    document.getElementById('rejectStoryId').value = id;
    document.getElementById('rejectModal').classList.remove('hidden');
}

function closeRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
    document.getElementById('rejectNotes').value = '';
}

document.getElementById('rejectForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch('/admin/success-stories/reject', {
        method: 'POST',
        body: new URLSearchParams(formData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert(data.message || 'Error rejecting story');
        }
    })
    .catch(err => alert('Error: ' + err.message));
});

function deleteStory(id) {
    if (!confirm('Are you sure you want to permanently delete this story?')) return;
    
    fetch('/admin/success-stories/delete', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'story_id=' + id
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('story-' + id).remove();
        } else {
            alert(data.message || 'Error deleting story');
        }
    })
    .catch(err => alert('Error: ' + err.message));
}

// Close modal on background click
document.getElementById('rejectModal').addEventListener('click', function(e) {
    if (e.target === this) closeRejectModal();
});
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/admin.php';
?>
