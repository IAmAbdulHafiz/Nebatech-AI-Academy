<?php
$title = 'Update Application';
ob_start();
include __DIR__ . '/../partials/student-sidebar.php';
$sidebarContent = ob_get_clean();
ob_start();
?>

<!-- Page Header -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-2">Update Your Application</h1>
    <p class="text-gray-600">Provide the requested information to continue your application</p>
</div>

<!-- Admin Notes Alert -->
<?php if (!empty($application['admin_notes'])): ?>
    <div class="max-w-3xl mb-6 bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg">
        <div class="flex items-start">
            <i class="fas fa-info-circle text-blue-500 mr-3 mt-1"></i>
            <div>
                <h3 class="font-bold text-blue-900 mb-2">Admin Feedback</h3>
                <p class="text-blue-800"><?= nl2br(htmlspecialchars($application['admin_notes'])) ?></p>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- Error/Success Messages -->
<?php if (isset($_GET['error'])): ?>
    <div class="max-w-3xl mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
        <div class="flex items-center">
            <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
            <p class="text-red-700">
                <?php
                $errors = [
                    'missing_fields' => 'Please fill in all required fields.',
                    'education_too_short' => 'Educational background must be at least 50 characters.',
                    'motivation_too_short' => 'Motivation statement must be at least 100 characters.',
                    'invalid_document' => 'Invalid document. Please upload PDF, DOC, or image files (max 5MB).',
                    'update_failed' => 'Failed to update application. Please try again.',
                    'cannot_update' => 'This application cannot be updated at this time.'
                ];
                echo $errors[$_GET['error']] ?? 'An error occurred. Please try again.';
                ?>
            </p>
        </div>
    </div>
<?php endif; ?>

<!-- Application Form -->
<div class="max-w-3xl">
    <form action="<?= url('/application/' . $application['uuid'] . '/update') ?>" method="POST" enctype="multipart/form-data" class="space-y-6" x-data="applicationForm()" @submit="validateForm">
        <?= csrf_field() ?>
        <!-- Program Info (Read-only) -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Program</h2>
            <div class="bg-gray-50 rounded-lg p-4">
                <p class="text-gray-700 font-medium">
                    <?= htmlspecialchars($programs[$application['program']]['name'] ?? $application['program']) ?>
                </p>
                <p class="text-sm text-gray-500 mt-1">This cannot be changed after submission</p>
            </div>
        </div>

        <!-- Educational Background -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Educational Background</h2>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Tell us about your education *</label>
                <textarea name="educational_background" required rows="5" minlength="50"
                          x-model="education"
                          @input="educationLength = $el.value.length"
                          class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary focus:border-transparent"
                          placeholder="Include your highest level of education, relevant courses, certifications, etc."><?= htmlspecialchars($application['educational_background'] ?? '') ?></textarea>
                <p class="text-sm mt-1" :class="educationLength >= 50 ? 'text-green-600' : 'text-gray-500'">
                    <span x-text="educationLength"></span>/50 characters minimum
                </p>
            </div>
        </div>

        <!-- Motivation Statement -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Why Do You Want to Join?</h2>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Motivation Statement *</label>
                <textarea name="motivation_statement" required rows="6" minlength="100"
                          x-model="motivation"
                          @input="motivationLength = $el.value.length"
                          class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary focus:border-transparent"
                          placeholder="Tell us why you want to join this program, your career goals, and what you hope to achieve..."><?= htmlspecialchars($application['motivation_statement'] ?? '') ?></textarea>
                <p class="text-sm mt-1" :class="motivationLength >= 100 ? 'text-green-600' : 'text-gray-500'">
                    <span x-text="motivationLength"></span>/100 characters minimum. Be specific about your goals.
                </p>
            </div>
        </div>

        <!-- Additional Information -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Additional Information</h2>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">How did you hear about us?</label>
                <select name="referral_source" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary focus:border-transparent">
                    <option value="">Select an option...</option>
                    <option value="Google Search" <?= ($application['referral_source'] ?? '') === 'Google Search' ? 'selected' : '' ?>>Google Search</option>
                    <option value="Social Media" <?= ($application['referral_source'] ?? '') === 'Social Media' ? 'selected' : '' ?>>Social Media (Facebook, Twitter, LinkedIn)</option>
                    <option value="Friend/Family" <?= ($application['referral_source'] ?? '') === 'Friend/Family' ? 'selected' : '' ?>>Friend or Family Referral</option>
                    <option value="Advertisement" <?= ($application['referral_source'] ?? '') === 'Advertisement' ? 'selected' : '' ?>>Online Advertisement</option>
                    <option value="Blog/Article" <?= ($application['referral_source'] ?? '') === 'Blog/Article' ? 'selected' : '' ?>>Blog or Article</option>
                    <option value="Other" <?= ($application['referral_source'] ?? '') === 'Other' ? 'selected' : '' ?>>Other</option>
                </select>
            </div>

            <?php if (!empty($application['document_path'])): ?>
                <div class="mb-4 bg-gray-50 rounded-lg p-4">
                    <p class="text-sm text-gray-700 mb-2">
                        <i class="fas fa-file mr-2"></i>Current Document: 
                        <a href="<?= url($application['document_path']) ?>" target="_blank" class="text-primary hover:underline">
                            View Document
                        </a>
                    </p>
                </div>
            <?php endif; ?>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <?= !empty($application['document_path']) ? 'Replace Document (Optional)' : 'Upload Document (Optional)' ?>
                </label>
                <input type="file" name="document" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" 
                       class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary focus:border-transparent">
                <p class="text-sm text-gray-500 mt-1">Upload resume, certificates, or transcripts (Max 5MB, PDF/DOC/Image)</p>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex gap-4">
            <button type="submit" class="flex-1 px-6 py-3 bg-primary text-white rounded-lg hover:bg-blue-700 transition font-medium text-lg">
                <i class="fas fa-save mr-2"></i>Update Application
            </button>
            <a href="<?= url('/application/' . $application['uuid']) ?>" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-medium text-lg">
                Cancel
            </a>
        </div>
    </form>
</div>

<!-- Info Box -->
<div class="max-w-3xl mt-8">
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
        <h3 class="font-bold text-blue-900 mb-2">
            <i class="fas fa-info-circle mr-2"></i>What Happens Next?
        </h3>
        <ul class="text-sm text-blue-800 space-y-2">
            <li><i class="fas fa-check mr-2"></i>Your updated application will be reviewed again</li>
            <li><i class="fas fa-check mr-2"></i>You'll receive an email notification about the status</li>
            <li><i class="fas fa-check mr-2"></i>Make sure to address all the feedback provided by the admin</li>
            <li><i class="fas fa-check mr-2"></i>You can track your application status in your dashboard</li>
        </ul>
    </div>
</div>

<script>
function applicationForm() {
    return {
        education: <?= json_encode($application['educational_background'] ?? '') ?>,
        motivation: <?= json_encode($application['motivation_statement'] ?? '') ?>,
        educationLength: <?= strlen($application['educational_background'] ?? '') ?>,
        motivationLength: <?= strlen($application['motivation_statement'] ?? '') ?>,
        
        validateForm(e) {
            if (this.educationLength < 50) {
                e.preventDefault();
                alert('Educational background must be at least 50 characters long.');
                return false;
            }
            
            if (this.motivationLength < 100) {
                e.preventDefault();
                alert('Motivation statement must be at least 100 characters long.');
                return false;
            }
            
            return true;
        }
    };
}
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/dashboard.php';
?>
