<?php
$title = 'Submit Assignment';
ob_start();
include __DIR__ . '/../partials/student-sidebar.php';
$sidebarContent = ob_get_clean();
ob_start();
?>

<div x-data="submissionForm()">
    <!-- Page Header -->
    <div class="mb-6">
        <div class="flex items-center gap-4 mb-4">
            <a href="<?= url('/courses/' . $assignment['course_slug']) ?>" class="text-gray-600 hover:text-gray-800">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Submit Assignment</h1>
                <p class="text-sm text-gray-600"><?= htmlspecialchars($assignment['title']) ?></p>
            </div>
        </div>

        <?php if ($existingSubmission): ?>
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <div class="flex items-start gap-3">
                    <i class="fas fa-info-circle text-yellow-600 mt-1"></i>
                    <div>
                        <p class="font-semibold text-yellow-800">Previous Submission Found</p>
                        <p class="text-sm text-yellow-700">
                            <?php if ($existingSubmission['status'] === 'revision_needed'): ?>
                                Your submission needs revision. You can update it below.
                            <?php else: ?>
                                You have already submitted this assignment. Status: 
                                <span class="font-semibold"><?= ucwords(str_replace('_', ' ', $existingSubmission['status'])) ?></span>
                            <?php endif; ?>
                        </p>
                        <a href="<?= url('/submission/' . $existingSubmission['id']) ?>" class="text-sm text-yellow-800 hover:underline">
                            View your submission →
                        </a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Assignment Details -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Assignment Details</h2>
        <div class="prose max-w-none mb-4">
            <?= $assignment['description'] ?>
        </div>
        <?php if ($assignment['max_score']): ?>
            <p class="text-sm text-gray-600">
                <i class="fas fa-star text-yellow-500 mr-1"></i>
                Maximum Score: <span class="font-semibold"><?= $assignment['max_score'] ?> points</span>
            </p>
        <?php endif; ?>
    </div>

    <!-- Submission Form -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Your Submission</h2>

        <form action="<?= url('/assignment/submit') ?>" method="POST" enctype="multipart/form-data" @submit="validateForm">
            <?= csrf_field() ?>
            <input type="hidden" name="assignment_id" value="<?= $assignment['id'] ?>">

            <!-- Submission Type Selector -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-3">Submission Type</label>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <button type="button" @click="submissionType = 'text'" 
                            :class="submissionType === 'text' ? 'border-primary bg-primary-50' : 'border-gray-300'"
                            class="p-4 border-2 rounded-lg text-center hover:border-primary transition">
                        <i class="fas fa-align-left text-2xl mb-2" :class="submissionType === 'text' ? 'text-primary' : 'text-gray-400'"></i>
                        <p class="font-medium text-sm">Text</p>
                    </button>
                    <button type="button" @click="submissionType = 'code'" 
                            :class="submissionType === 'code' ? 'border-primary bg-primary-50' : 'border-gray-300'"
                            class="p-4 border-2 rounded-lg text-center hover:border-primary transition">
                        <i class="fas fa-code text-2xl mb-2" :class="submissionType === 'code' ? 'text-primary' : 'text-gray-400'"></i>
                        <p class="font-medium text-sm">Code</p>
                    </button>
                    <button type="button" @click="submissionType = 'file'" 
                            :class="submissionType === 'file' ? 'border-primary bg-primary-50' : 'border-gray-300'"
                            class="p-4 border-2 rounded-lg text-center hover:border-primary transition">
                        <i class="fas fa-file-upload text-2xl mb-2" :class="submissionType === 'file' ? 'text-primary' : 'text-gray-400'"></i>
                        <p class="font-medium text-sm">File</p>
                    </button>
                    <button type="button" @click="submissionType = 'url'" 
                            :class="submissionType === 'url' ? 'border-primary bg-primary-50' : 'border-gray-300'"
                            class="p-4 border-2 rounded-lg text-center hover:border-primary transition">
                        <i class="fas fa-link text-2xl mb-2" :class="submissionType === 'url' ? 'text-primary' : 'text-gray-400'"></i>
                        <p class="font-medium text-sm">URL</p>
                    </button>
                </div>
                <input type="hidden" name="content_type" :value="submissionType">
            </div>

            <!-- Text Submission -->
            <div x-show="submissionType === 'text'" class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Your Answer</label>
                <textarea name="content" rows="10" 
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                          placeholder="Enter your answer here..."></textarea>
                <p class="text-xs text-gray-500 mt-1">You can use plain text or markdown formatting.</p>
            </div>

            <!-- Code Submission -->
            <div x-show="submissionType === 'code'" class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Your Code</label>
                <textarea name="code" id="codeSubmissionEditor" data-code-editor data-language="javascript" rows="15" 
                          class="w-full font-mono text-sm"
                          placeholder="Paste your code here..."></textarea>
                <p class="text-xs text-gray-500 mt-2">
                    <i class="fas fa-info-circle mr-1"></i>
                    Use <kbd class="px-2 py-1 bg-gray-100 rounded text-xs">Ctrl+Space</kbd> for autocomplete, 
                    <kbd class="px-2 py-1 bg-gray-100 rounded text-xs">Ctrl+F</kbd> to search, 
                    <kbd class="px-2 py-1 bg-gray-100 rounded text-xs">F11</kbd> for fullscreen
                </p>
                
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Repository URL (Optional)</label>
                    <input type="url" name="repository_url" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                           placeholder="https://github.com/username/repository">
                    <p class="text-xs text-gray-500 mt-1">Link to your GitHub, GitLab, or other repository.</p>
                </div>
            </div>

            <!-- File Submission -->
            <div x-show="submissionType === 'file'" class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Upload File</label>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center">
                    <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-4"></i>
                    <input type="file" name="file" id="fileInput" class="hidden" @change="handleFileSelect">
                    <label for="fileInput" class="cursor-pointer">
                        <span class="text-primary hover:text-primary-dark font-medium">Choose a file</span>
                        <span class="text-gray-600"> or drag and drop</span>
                    </label>
                    <p class="text-xs text-gray-500 mt-2">
                        Max file size: 10MB<br>
                        Supported: PDF, DOC, DOCX, ZIP, Images, Code files
                    </p>
                    <p x-show="fileName" class="mt-4 text-sm font-medium text-gray-700">
                        Selected: <span x-text="fileName"></span>
                    </p>
                </div>

                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Description (Optional)</label>
                    <textarea name="description" rows="4" 
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                              placeholder="Describe your submission..."></textarea>
                </div>
            </div>

            <!-- URL Submission -->
            <div x-show="submissionType === 'url'" class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Project URL</label>
                <input type="url" name="url" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                       placeholder="https://your-project.com">
                <p class="text-xs text-gray-500 mt-1">Link to your live project, demo, or hosted application.</p>

                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea name="description" rows="6" 
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                              placeholder="Describe your project..."></textarea>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex gap-4">
                <button type="submit" 
                        class="flex-1 px-6 py-3 bg-primary text-white rounded-lg hover:bg-primary-dark transition font-semibold">
                    <i class="fas fa-paper-plane mr-2"></i>Submit Assignment
                </button>
                <a href="<?= url('/courses/' . $assignment['course_slug']) ?>" 
                   class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-semibold">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
function submissionForm() {
    return {
        submissionType: 'text',
        fileName: '',
        
        handleFileSelect(event) {
            const file = event.target.files[0];
            if (file) {
                this.fileName = file.name;
            }
        },
        
        validateForm(event) {
            // Basic validation
            const form = event.target;
            const type = this.submissionType;
            
            if (type === 'text' && !form.content.value.trim()) {
                showWarning('Please enter your answer');
                event.preventDefault();
                return false;
            }
            
            if (type === 'code' && !form.code.value.trim() && !form.repository_url.value.trim()) {
                showWarning('Please provide code or repository URL');
                event.preventDefault();
                return false;
            }
            
            if (type === 'file' && !form.file.files.length) {
                showWarning('Please select a file to upload');
                event.preventDefault();
                return false;
            }
            
            if (type === 'url' && !form.url.value.trim()) {
                showWarning('Please enter a URL');
                event.preventDefault();
                return false;
            }
            
            return true;
        }
    }
}
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/dashboard.php';
?>
