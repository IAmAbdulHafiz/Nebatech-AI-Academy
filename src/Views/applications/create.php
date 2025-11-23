<?php
$title = 'Apply for Program';
ob_start();
include __DIR__ . '/../partials/student-sidebar.php';
$sidebarContent = ob_get_clean();
ob_start();
?>

<!-- Page Header -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-2">Apply for a Program</h1>
    <p class="text-gray-600">Start your learning journey with Nebatech AI Academy</p>
</div>

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
                    'submission_failed' => 'Failed to submit application. Please try again.'
                ];
                echo $errors[$_GET['error']] ?? 'An error occurred. Please try again.';
                ?>
            </p>
        </div>
    </div>
<?php endif; ?>

<!-- Application Form -->
<div class="max-w-3xl">
    <form action="<?= url('/apply') ?>" method="POST" enctype="multipart/form-data" class="space-y-6" x-data="applicationForm()" @submit="validateForm">
        <?= csrf_field() ?>
        <!-- Program Selection -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Select Your Program</h2>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Program *</label>
                <select name="program" required class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary focus:border-transparent">
                    <option value="">Choose a program...</option>
                    <?php foreach ($programs as $key => $programData): ?>
                        <option value="<?= $key ?>" <?= ($program ?? '') === $key ? 'selected' : '' ?>>
                            <?= htmlspecialchars($programData['name']) ?> (<?= $programData['duration_weeks'] ?> weeks)
                        </option>
                    <?php endforeach; ?>
                </select>
                <p class="text-sm text-gray-500 mt-1">Select the program you want to enroll in</p>
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
                          placeholder="Include your highest level of education, relevant courses, certifications, etc."></textarea>
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
                          placeholder="Tell us why you want to join this program, your career goals, and what you hope to achieve..."></textarea>
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
                    <option value="Google Search">Google Search</option>
                    <option value="Social Media">Social Media (Facebook, Twitter, LinkedIn)</option>
                    <option value="Friend/Family">Friend or Family Referral</option>
                    <option value="Advertisement">Online Advertisement</option>
                    <option value="Blog/Article">Blog or Article</option>
                    <option value="Other">Other</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Supporting Documents (Optional)</label>
                <input type="file" name="document" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" 
                       class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary focus:border-transparent">
                <p class="text-sm text-gray-500 mt-1">Upload resume, certificates, or transcripts (Max 5MB, PDF/DOC/Image)</p>
            </div>
        </div>

        <!-- Terms and Conditions -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-start gap-3">
                <input type="checkbox" id="terms" name="terms" required class="mt-1">
                <label for="terms" class="text-sm text-gray-700">
                    I agree to the <a href="<?= url('/terms') ?>" class="text-primary hover:underline" target="_blank">Terms and Conditions</a> 
                    and <a href="<?= url('/privacy') ?>" class="text-primary hover:underline" target="_blank">Privacy Policy</a>. 
                    I understand that my application will be reviewed by the admissions team.
                </label>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex gap-4">
            <button type="submit" class="flex-1 px-6 py-3 bg-primary text-white rounded-lg hover:bg-blue-700 transition font-medium text-lg">
                <i class="fas fa-paper-plane mr-2"></i>Submit Application
            </button>
            <a href="<?= url('/dashboard') ?>" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-medium text-lg">
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
            <li><i class="fas fa-check mr-2"></i>Your application will be reviewed within 2-3 business days</li>
            <li><i class="fas fa-check mr-2"></i>You'll receive an email notification about your application status</li>
            <li><i class="fas fa-check mr-2"></i>If approved, you'll get immediate access to your program</li>
            <li><i class="fas fa-check mr-2"></i>You can track your application status in your dashboard</li>
        </ul>
    </div>
</div>

<script>
function applicationForm() {
    return {
        education: '',
        motivation: '',
        educationLength: 0,
        motivationLength: 0,
        
        validateForm(e) {
            if (this.educationLength < 50) {
                e.preventDefault();
                showWarning('Educational background must be at least 50 characters long.');
                return false;
            }
            
            if (this.motivationLength < 100) {
                e.preventDefault();
                showWarning('Motivation statement must be at least 100 characters long.');
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
