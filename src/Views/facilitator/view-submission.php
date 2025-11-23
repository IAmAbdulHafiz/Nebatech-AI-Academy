<?php
$title = 'Review Submission';
ob_start();
include __DIR__ . '/../partials/facilitator-sidebar.php';
$sidebarContent = ob_get_clean();
ob_start();
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/codemirror.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/theme/monokai.min.css">

<div x-data="submissionReview()">
<!-- Page Header -->
<div class="mb-6">
    <div class="flex items-center gap-4">
        <a href="<?= url('/facilitator/submissions') ?>" class="text-gray-600 hover:text-gray-800">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Review Submission</h1>
            <p class="text-sm text-gray-600"><?= htmlspecialchars($assignment['title'] ?? '') ?></p>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    
                    <!-- Main Content - Submission Details -->
                    <div class="lg:col-span-2 space-y-6">
                        
                        <!-- Student Info -->
                        <div class="bg-white rounded-lg shadow p-6">
                            <h2 class="text-lg font-semibold text-gray-800 mb-4">Student Information</h2>
                            <div class="flex items-center gap-4">
                                <div class="h-16 w-16 flex-shrink-0">
                                    <?php if ($student['avatar']): ?>
                                        <img class="h-16 w-16 rounded-full object-cover" src="<?= url('/' . $student['avatar']) ?>" alt="">
                                    <?php else: ?>
                                        <div class="h-16 w-16 rounded-full bg-primary text-white flex items-center justify-center font-semibold text-xl">
                                            <?= strtoupper(substr($student['first_name'], 0, 1) . substr($student['last_name'], 0, 1)) ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <h3 class="text-xl font-semibold text-gray-800">
                                        <?= htmlspecialchars($student['first_name'] . ' ' . $student['last_name']) ?>
                                    </h3>
                                    <p class="text-gray-600"><?= htmlspecialchars($student['email']) ?></p>
                                    <a href="<?= url('/facilitator/students/' . $student['id']) ?>" class="text-sm text-primary hover:underline">
                                        View Student Profile <i class="fas fa-external-link-alt text-xs"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Submission Content -->
                        <div class="bg-white rounded-lg shadow p-6">
                            <h2 class="text-lg font-semibold text-gray-800 mb-4">Submission Content</h2>
                            
                            <?php if ($submission['content_type'] === 'code'): ?>
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Code Submission</label>
                                    <textarea id="codeEditor" data-code-editor data-language="javascript" readonly class="w-full h-96 font-mono text-sm"><?= htmlspecialchars($submission['content'] ?? '') ?></textarea>
                                </div>
                            <?php elseif ($submission['content_type'] === 'file'): ?>
                                <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center">
                                    <i class="fas fa-file-download text-4xl text-gray-400 mb-4"></i>
                                    <p class="text-gray-600 mb-2">File Submission</p>
                                    <?php if ($submission['file_name']): ?>
                                        <p class="text-sm text-gray-500 mb-2">
                                            <i class="fas fa-file mr-1"></i><?= htmlspecialchars($submission['file_name']) ?>
                                            <?php if ($submission['file_size']): ?>
                                                (<?= number_format($submission['file_size'] / 1024, 2) ?> KB)
                                            <?php endif; ?>
                                        </p>
                                    <?php endif; ?>
                                    <a href="<?= url('/submission/' . $submission['id'] . '/download') ?>" class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark">
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
                                    <p class="text-sm font-medium text-gray-700 mb-2">Repository URL:</p>
                                    <a href="<?= htmlspecialchars($submission['repository_url']) ?>" target="_blank" class="text-primary hover:underline break-all">
                                        <?= htmlspecialchars($submission['repository_url']) ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- AI Feedback (if available) -->
                        <?php if (!empty($submission['ai_feedback'])): ?>
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                                <div class="flex items-center gap-2 mb-4">
                                    <i class="fas fa-robot text-blue-600 text-xl"></i>
                                    <h2 class="text-lg font-semibold text-gray-800">AI Analysis</h2>
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

                        <!-- Grading Form -->
                        <div class="bg-white rounded-lg shadow p-6">
                            <h2 class="text-lg font-semibold text-gray-800 mb-4">Grade Submission</h2>
                            
                            <form @submit.prevent="submitGrade" class="space-y-4">
                                <input type="hidden" name="submission_id" value="<?= $submission['id'] ?>">
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Score (out of <?= $assignment['max_score'] ?? 100 ?>)
                                    </label>
                                    <input type="number" x-model="score" min="0" max="<?= $assignment['max_score'] ?? 100 ?>" step="0.1" 
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" 
                                           required>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Feedback</label>
                                    <textarea x-model="feedback" rows="6" 
                                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" 
                                              placeholder="Provide detailed feedback to help the student improve..." 
                                              required></textarea>
                                </div>

                                <div class="flex gap-3">
                                    <button type="submit" @click="action = 'grade'" 
                                            class="flex-1 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                        <i class="fas fa-check mr-2"></i>Grade Submission
                                    </button>
                                    <button type="submit" @click="action = 'verify'" 
                                            class="flex-1 px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                                        <i class="fas fa-check-double mr-2"></i>Grade & Verify
                                    </button>
                                    <button type="submit" @click="action = 'request_revision'" 
                                            class="flex-1 px-6 py-3 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition">
                                        <i class="fas fa-redo mr-2"></i>Request Revision
                                    </button>
                                </div>
                            </form>
                        </div>

                    </div>

                    <!-- Sidebar - Assignment Details & Rubric -->
                    <div class="space-y-6">
                        
                        <!-- Submission Status -->
                        <div class="bg-white rounded-lg shadow p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Submission Status</h3>
                            <div class="space-y-3">
                                <div>
                                    <p class="text-sm text-gray-600">Status</p>
                                    <?php
                                    $statusColors = [
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'graded' => 'bg-blue-100 text-blue-800',
                                        'verified' => 'bg-green-100 text-green-800',
                                        'revision_needed' => 'bg-red-100 text-red-800'
                                    ];
                                    $statusColor = $statusColors[$submission['status']] ?? 'bg-gray-100 text-gray-800';
                                    ?>
                                    <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full <?= $statusColor ?>">
                                        <?= ucwords(str_replace('_', ' ', $submission['status'])) ?>
                                    </span>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Submitted</p>
                                    <p class="font-medium"><?= date('M d, Y \a\t g:i A', strtotime($submission['submitted_at'])) ?></p>
                                </div>
                                <?php if ($submission['graded_at']): ?>
                                    <div>
                                        <p class="text-sm text-gray-600">Graded</p>
                                        <p class="font-medium"><?= date('M d, Y \a\t g:i A', strtotime($submission['graded_at'])) ?></p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Assignment Details -->
                        <div class="bg-white rounded-lg shadow p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Assignment Details</h3>
                            <div class="space-y-3">
                                <div>
                                    <p class="text-sm text-gray-600">Course</p>
                                    <p class="font-medium"><?= htmlspecialchars($submission['course_title']) ?></p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Module</p>
                                    <p class="font-medium"><?= htmlspecialchars($submission['module_title']) ?></p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Lesson</p>
                                    <p class="font-medium"><?= htmlspecialchars($submission['lesson_title']) ?></p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Max Score</p>
                                    <p class="font-medium"><?= $assignment['max_score'] ?? 100 ?> points</p>
                                </div>
                            </div>
                        </div>

                        <!-- Rubric -->
                        <?php if (!empty($assignment['rubric'])): ?>
                            <div class="bg-white rounded-lg shadow p-6">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">Grading Rubric</h3>
                                <div class="space-y-3">
                                    <?php 
                                    $rubric = is_string($assignment['rubric']) ? json_decode($assignment['rubric'], true) : $assignment['rubric'];
                                    if (is_array($rubric)):
                                        foreach ($rubric as $criterion => $description):
                                    ?>
                                        <div class="border-l-4 border-primary pl-3">
                                            <p class="font-medium text-gray-800"><?= htmlspecialchars($criterion) ?></p>
                                            <p class="text-sm text-gray-600"><?= htmlspecialchars($description) ?></p>
                                        </div>
                                    <?php 
                                        endforeach;
                                    endif;
                                    ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Previous Feedback -->
                        <?php if ($submission['facilitator_feedback']): ?>
                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-6">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">Previous Feedback</h3>
                                <div class="space-y-2">
                                    <?php if ($submission['facilitator_score']): ?>
                                        <div>
                                            <p class="text-sm text-gray-600">Score</p>
                                            <p class="text-2xl font-bold text-primary"><?= number_format($submission['facilitator_score'], 1) ?>%</p>
                                        </div>
                                    <?php endif; ?>
                                    <div>
                                        <p class="text-sm text-gray-600">Feedback</p>
                                        <p class="text-gray-800"><?= nl2br(htmlspecialchars($submission['facilitator_feedback'])) ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>

            </main>
        </div>
    </div>

    <script>
        function submissionReview() {
            return {
                sidebarOpen: true,
                score: <?= $submission['facilitator_score'] ?? 0 ?>,
                feedback: '<?= addslashes($submission['facilitator_feedback'] ?? '') ?>',
                action: 'grade',
                
                async submitGrade() {
                    try {
                        const formData = new FormData();
                        formData.append('submission_id', <?= $submission['id'] ?>);
                        formData.append('score', this.score);
                        formData.append('feedback', this.feedback);
                        formData.append('action', this.action);
                        formData.append('_token', '<?= csrf_token() ?>');
                        
                        const response = await fetch('<?= url('/facilitator/submissions/grade') ?>', {
                            method: 'POST',
                            body: formData
                        });
                        
                        const data = await response.json();
                        
                        if (data.success) {
                            showSuccess('Submission graded successfully!');
                            setTimeout(() => window.location.href = '<?= url('/facilitator/submissions') ?>', 1000);
                        } else {
                            showError('Error: ' + (data.error || 'Failed to grade submission'));
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        showError('An error occurred while grading the submission');
                    }
                }
            }
        }

        // Code editor is automatically initialized by codeEditorSimple.js
    </script>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/dashboard.php';
?>
