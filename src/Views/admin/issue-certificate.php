<?php
$title = 'Issue Certificate';
ob_start();
include __DIR__ . '/../partials/admin-sidebar.php';
$sidebarContent = ob_get_clean();
ob_start();
?>

<!-- Page Header -->
<div class="mb-6">
    <a href="<?= url('/admin/certificates') ?>" class="text-primary hover:text-blue-700 text-sm mb-2 inline-block">
        <i class="fas fa-arrow-left mr-2"></i>Back to Certificates
    </a>
    <h1 class="text-3xl font-bold text-gray-900 mb-2">Issue Certificate</h1>
    <p class="text-gray-600">Manually issue a certificate to a student</p>
</div>

<!-- Issue Form -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 max-w-2xl">
    <form id="issueCertificateForm" class="space-y-6">
        <!-- Student Selection -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Student <span class="text-red-500">*</span>
            </label>
            <select name="user_id" id="user_id" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary focus:border-transparent">
                <option value="">Select a student...</option>
                <?php foreach ($students as $student): ?>
                    <option value="<?= $student['id'] ?>">
                        <?= htmlspecialchars($student['first_name'] . ' ' . $student['last_name']) ?> 
                        (<?= htmlspecialchars($student['email']) ?>)
                    </option>
                <?php endforeach; ?>
            </select>
            <p class="text-sm text-gray-500 mt-1">Select the student who will receive the certificate</p>
        </div>

        <!-- Course Selection -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Course <span class="text-red-500">*</span>
            </label>
            <select name="course_id" id="course_id" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary focus:border-transparent">
                <option value="">Select a course...</option>
                <?php foreach ($courses as $course): ?>
                    <option value="<?= $course['id'] ?>">
                        <?= htmlspecialchars($course['title']) ?> 
                        (<?= htmlspecialchars($course['category_name'] ?? 'Uncategorized') ?>)
                    </option>
                <?php endforeach; ?>
            </select>
            <p class="text-sm text-gray-500 mt-1">Select the course for which the certificate will be issued</p>
        </div>

        <!-- Info Box -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex">
                <i class="fas fa-info-circle text-blue-600 mt-1 mr-3"></i>
                <div class="text-sm text-blue-800">
                    <p class="font-medium mb-1">Certificate Issuance Requirements:</p>
                    <ul class="list-disc list-inside space-y-1">
                        <li>Student must be enrolled in the selected course</li>
                        <li>A unique certificate number will be automatically generated</li>
                        <li>Certificate will be immediately verified and valid</li>
                        <li>Student will receive an email notification (if configured)</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-3">
            <button type="submit" class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-blue-700 transition font-medium">
                <i class="fas fa-certificate mr-2"></i>Issue Certificate
            </button>
            <a href="<?= url('/admin/certificates') ?>" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-medium">
                Cancel
            </a>
        </div>
    </form>
</div>

<script>
document.getElementById('issueCertificateForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const userId = formData.get('user_id');
    const courseId = formData.get('course_id');
    
    if (!userId || !courseId) {
        showError('Please select both a student and a course');
        return;
    }
    
    const confirmed = await confirmAction('Issue certificate to this student for the selected course?', {
        title: 'Issue Certificate',
        confirmText: 'Issue',
        type: 'success'
    });
    
    if (!confirmed) return;
    
    // Disable submit button
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Issuing...';
    
    const params = new URLSearchParams(formData);
    params.append('_token', '<?= csrf_token() ?>');
    
    fetch('<?= url('/admin/certificates/issue') ?>', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: params
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showSuccess('Certificate issued successfully');
            setTimeout(() => {
                window.location.href = '<?= url('/admin/certificates') ?>';
            }, 1500);
        } else {
            showError('Error: ' + (data.error || 'Failed to issue certificate'));
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        }
    })
    .catch(error => {
        showError('An error occurred: ' + error.message);
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    });
});
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/dashboard.php';
?>
