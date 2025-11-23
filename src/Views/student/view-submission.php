<?php
$title = 'My Submission';
ob_start();
include __DIR__ . '/../partials/student-sidebar.php';
$sidebarContent = ob_get_clean();
ob_start();
?>

<div x-data="submissionView()">
    <!-- Page Header -->
    <div class="mb-6">
        <div class="flex items-center gap-4 mb-4">
            <a href="<?= url('/my-courses') ?>" class="text-gray-600 hover:text-gray-800">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-800">My Submission</h1>
                <p class="text-sm text-gray-600"><?= htmlspecialchars($submission['assignment_title']) ?></p>
            </div>
        </div>
    </div>

    <!-- Status Banner -->
    <div class="mb-6">
        <?php
        $statusConfig = [
            'pending' => [
                'bg' => 'bg-yellow-50 border-yellow-200',
                'icon' => 'fa-clock text-yellow-600',
                'text' => 'text-yellow-800',
                'title' => 'Pending Review',
                'message' => 'Your submission is waiting for facilitator review.'
            ],
            'graded' => [
                'bg' => 'bg-blue-50 border-blue-200',
                'icon' => 'fa-check-circle text-blue-600',
                'text' => 'text-blue-800',
                'title' => 'Graded',
                'message' => 'Your submission has been graded by the facilitator.'
            ],
            'verified' => [
                'bg' => 'bg-green-50 border-green-200',
                'icon' => 'fa-check-double text-green-600',
                'text' => 'text-green-800',
                'title' => 'Verified',
                'message' => 'Your submission has been verified and approved for your portfolio!'
            ],
            'revision_needed' => [
                'bg' => 'bg-red-50 border-red-200',
                'icon' => 'fa-redo text-red-600',
                'text' => 'text-red-800',
                'title' => 'Revision Needed',
                'message' => 'Please review the feedback and resubmit your work.'
            ]
        ];
        $config = $statusConfig[$submission['status']];
        ?>
        <div class="<?= $config['bg'] ?> border rounded-lg p-4">
            <div class="flex items-start gap-3">
                <i class="fas <?= $config['icon'] ?> mt-1"></i>
                <div class="flex-1">
                    <p class="font-semibold <?= $config['text'] ?>"><?= $config['title'] ?></p>
                    <p class="text-sm <?= $config['text'] ?>"><?= $config['message'] ?></p>
                </div>
                <?php if ($submission['status'] === 'revision_needed'): ?>
                    <a href="<?= url('/submission/' . $submission['id'] . '/update') ?>" 
                       class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-sm font-medium">
                        Update Submission
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Submission Content -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Your Submission</h2>
                
                <?php if ($submission['content_type'] === 'code'): ?>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Code</label>
                        <pre class="bg-gray-900 text-gray-100 p-4 rounded-lg overflow-x-auto"><code><?= htmlspecialchars($submission['content'] ?? '') ?></code></pre>
                    </div>
                <?php elseif ($submission['content_type'] === 'file'): ?>
                    <div class="border-2 border-gray-200 rounded-lg p-8 text-center">
                        <i class="fas fa-file-download text-4xl text-gray-400 mb-4"></i>
                        <p class="text-gray-600 mb-2">File Submission</p>
                        <?php if ($submission['file_name']): ?>
                            <p class="text-sm text-gray-500 mb-4">
                                <i class="fas fa-file mr-1"></i><?= htmlspecialchars($submission['file_name']) ?>
                                <?php if ($submission['file_size']): ?>
                                    (<?= number_format($submission['file_size'] / 1024, 2) ?> KB)
                                <?php endif; ?>
                            </p>
                        <?php endif; ?>
                        <a href="<?= url('/submission/' . $submission['id'] . '/download') ?>" 
                           class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark">
                            <i class="fas fa-download mr-2"></i>Download File
                        </a>
                        <?php if ($submission['content']): ?>
                            <div class="mt-4 pt-4 border-t border-gray-200 text-left">
                                <p class="text-sm font-medium text-gray-700 mb-2">Description:</p>
                                <p class="text-gray-600"><?= nl2br(htmlspecialchars($submission['content'])) ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <div class="prose max-w-none">
                        <?= nl2br(htmlspecialchars($submission['content'] ?? '')) ?>
                    </div>
                <?php endif; ?>

                <?php if ($submission['repository_url']): ?>
                    <div class="mt-4 p-4 bg-gray-50 rounded-lg">
                        <p class="text-sm font-medium text-gray-700 mb-2">Repository/Project URL:</p>
                        <a href="<?= htmlspecialchars($submission['repository_url']) ?>" target="_blank" 
                           class="text-primary hover:underline break-all">
                            <?= htmlspecialchars($submission['repository_url']) ?>
                            <i class="fas fa-external-link-alt text-xs ml-1"></i>
                        </a>
                    </div>
                <?php endif; ?>
            </div>

            <!-- AI Feedback -->
            <?php if (!empty($submission['ai_feedback'])): ?>
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                    <div class="flex items-center gap-2 mb-4">
                        <i class="fas fa-robot text-blue-600 text-xl"></i>
                        <h2 class="text-lg font-semibold text-gray-800">AI Feedback</h2>
                        <?php if ($submission['ai_score']): ?>
                            <span class="ml-auto text-2xl font-bold text-blue-600"><?= number_format($submission['ai_score'], 1) ?>%</span>
                        <?php endif; ?>
                    </div>
                    <div class="space-y-3">
                        <?php if (is_array($submission['ai_feedback'])): ?>
                            <?php foreach ($submission['ai_feedback'] as $key => $value): ?>
                                <div>
                                    <p class="font-medium text-gray-700"><?= ucwords(str_replace('_', ' ', $key)) ?>:</p>
                                    <p class="text-gray-600"><?= is_array($value) ? implode(', ', $value) : htmlspecialchars($value) ?></p>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="text-gray-600"><?= htmlspecialchars($submission['ai_feedback']) ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Facilitator Feedback -->
            <?php if ($submission['facilitator_feedback']): ?>
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center gap-2 mb-4">
                        <i class="fas fa-user-tie text-primary text-xl"></i>
                        <h2 class="text-lg font-semibold text-gray-800">Facilitator Feedback</h2>
                        <?php if ($submission['facilitator_score']): ?>
                            <span class="ml-auto text-2xl font-bold text-primary"><?= number_format($submission['facilitator_score'], 1) ?>%</span>
                        <?php endif; ?>
                    </div>
                    <div class="prose max-w-none">
                        <?= nl2br(htmlspecialchars($submission['facilitator_feedback'])) ?>
                    </div>
                    <?php if ($submission['graded_at']): ?>
                        <p class="text-xs text-gray-500 mt-4">
                            Graded on <?= date('M d, Y \a\t g:i A', strtotime($submission['graded_at'])) ?>
                        </p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            
            <!-- Submission Info -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Submission Info</h3>
                <div class="space-y-3 text-sm">
                    <div>
                        <p class="text-gray-600">Course</p>
                        <p class="font-medium text-gray-800"><?= htmlspecialchars($submission['course_title']) ?></p>
                    </div>
                    <div>
                        <p class="text-gray-600">Module</p>
                        <p class="font-medium text-gray-800"><?= htmlspecialchars($submission['module_title']) ?></p>
                    </div>
                    <div>
                        <p class="text-gray-600">Lesson</p>
                        <p class="font-medium text-gray-800"><?= htmlspecialchars($submission['lesson_title']) ?></p>
                    </div>
                    <div>
                        <p class="text-gray-600">Submitted</p>
                        <p class="font-medium text-gray-800"><?= date('M d, Y \a\t g:i A', strtotime($submission['submitted_at'])) ?></p>
                    </div>
                    <?php if ($submission['max_score']): ?>
                        <div>
                            <p class="text-gray-600">Max Score</p>
                            <p class="font-medium text-gray-800"><?= $submission['max_score'] ?> points</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Actions -->
            <?php if ($submission['status'] === 'verified'): ?>
                <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-green-800 mb-2">
                        <i class="fas fa-trophy mr-2"></i>Verified!
                    </h3>
                    <p class="text-sm text-green-700 mb-4">
                        This submission has been verified and can be added to your portfolio.
                    </p>
                    <?php if ($inPortfolio): ?>
                        <div class="mb-3 p-3 bg-white rounded-lg border border-green-300">
                            <p class="text-sm text-green-800 flex items-center">
                                <i class="fas fa-check-circle mr-2"></i>
                                Already in your portfolio
                            </p>
                        </div>
                        <a href="<?= url('/my-portfolio') ?>" 
                           class="block w-full text-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                            View Portfolio
                        </a>
                    <?php else: ?>
                        <button @click="showPortfolioModal = true" 
                                class="block w-full text-center px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark transition mb-2">
                            <i class="fas fa-plus mr-2"></i>Add to Portfolio
                        </button>
                        <a href="<?= url('/my-portfolio') ?>" 
                           class="block w-full text-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                            View Portfolio
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

        </div>
    </div>

    <!-- Add to Portfolio Modal -->
    <div x-show="showPortfolioModal" 
         x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center p-4" 
         aria-labelledby="modal-title" 
         role="dialog" 
         aria-modal="true">
        
        <!-- Transparent Background overlay -->
        <div x-show="showPortfolioModal" 
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="showPortfolioModal = false"
             class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm transition-opacity" 
             aria-hidden="true"></div>

        <!-- Modal panel -->
        <div x-show="showPortfolioModal"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             class="relative bg-white rounded-lg text-left overflow-hidden shadow-2xl transform transition-all w-full max-w-md z-10">
                
                <form @submit.prevent="addToPortfolio">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-primary bg-opacity-10 sm:mx-0 sm:h-10 sm:w-10">
                                <i class="fas fa-briefcase text-primary text-xl"></i>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left flex-1">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    Add to Portfolio
                                </h3>
                                <div class="mt-4 space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                            Project Title
                                        </label>
                                        <input type="text" 
                                               x-model="portfolioData.title" 
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                               placeholder="<?= htmlspecialchars($submission['assignment_title']) ?>"
                                               required>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                            Description
                                        </label>
                                        <textarea x-model="portfolioData.description" 
                                                  rows="3"
                                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                                  placeholder="Describe your project..."></textarea>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                            Project URL (optional)
                                        </label>
                                        <input type="url" 
                                               x-model="portfolioData.project_url" 
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                               placeholder="https://...">
                                    </div>

                                    <div>
                                        <label class="flex items-center">
                                            <input type="checkbox" 
                                                   x-model="portfolioData.is_public" 
                                                   class="rounded border-gray-300 text-primary focus:ring-primary">
                                            <span class="ml-2 text-sm text-gray-700">Make this project public</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" 
                                :disabled="isSubmitting"
                                class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-primary text-base font-medium text-white hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary sm:ml-3 sm:w-auto sm:text-sm disabled:opacity-50">
                            <span x-show="!isSubmitting">Add to Portfolio</span>
                            <span x-show="isSubmitting">Adding...</span>
                        </button>
                        <button type="button" 
                                @click="showPortfolioModal = false"
                                class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </form>
        </div>
    </div>

    <script>
        function submissionView() {
            return {
                showPortfolioModal: false,
                isSubmitting: false,
                portfolioData: {
                    title: '<?= addslashes($submission['assignment_title']) ?>',
                    description: '',
                    project_url: '<?= addslashes($submission['repository_url'] ?? '') ?>',
                    is_public: true
                },

                async addToPortfolio() {
                    if (this.isSubmitting) return;
                    
                    this.isSubmitting = true;

                    try {
                        const formData = new FormData();
                        formData.append('submission_id', <?= $submission['id'] ?>);
                        formData.append('title', this.portfolioData.title);
                        formData.append('description', this.portfolioData.description);
                        formData.append('project_url', this.portfolioData.project_url);
                        formData.append('is_public', this.portfolioData.is_public ? '1' : '0');
                        formData.append('_token', '<?= csrf_token() ?>');

                        const response = await fetch('<?= url('/portfolio/create') ?>', {
                            method: 'POST',
                            body: formData
                        });

                        const data = await response.json();

                        if (data.success) {
                            // Show success message
                            if (typeof showSuccess === 'function') {
                                showSuccess('Project added to portfolio successfully!');
                            } else {
                                alert('Project added to portfolio successfully!');
                            }
                            
                            // Reload page to update UI
                            setTimeout(() => {
                                window.location.reload();
                            }, 1000);
                        } else {
                            throw new Error(data.error || 'Failed to add to portfolio');
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        if (typeof showError === 'function') {
                            showError(error.message || 'An error occurred while adding to portfolio');
                        } else {
                            alert(error.message || 'An error occurred while adding to portfolio');
                        }
                    } finally {
                        this.isSubmitting = false;
                    }
                }
            }
        }
    </script>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/dashboard.php';
?>
