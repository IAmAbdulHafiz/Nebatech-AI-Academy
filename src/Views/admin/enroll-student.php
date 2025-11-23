<?php
$title = 'Manual Enrollment';
ob_start();
include __DIR__ . '/../partials/admin-sidebar.php';
$sidebarContent = ob_get_clean();
ob_start();
?>

<div class="mb-6">
    <div class="flex items-center gap-4 mb-4">
        <a href="<?= url('/admin/enrollments') ?>" class="text-gray-600 hover:text-primary">
            <i class="fas fa-arrow-left text-xl"></i>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Manual Enrollment</h1>
            <p class="text-gray-600">Enroll a student in a course</p>
        </div>
    </div>
</div>

<div class="max-w-2xl">
    <form id="enrollForm" onsubmit="submitEnrollment(event)" class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 space-y-6">
        <!-- Student Selection -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Select Student <span class="text-red-500">*</span>
            </label>
            <select name="user_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary">
                <option value="">Choose a student</option>
                <?php foreach ($students as $student): ?>
                    <option value="<?= $student['id'] ?>">
                        <?= htmlspecialchars($student['first_name'] . ' ' . $student['last_name']) ?> 
                        (<?= htmlspecialchars($student['email']) ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Course Selection -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Select Course <span class="text-red-500">*</span>
            </label>
            <select name="course_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary">
                <option value="">Choose a course</option>
                <?php foreach ($courses as $course): ?>
                    <option value="<?= $course['id'] ?>">
                        <?= htmlspecialchars($course['title']) ?>
                        <?php if (!empty($course['level'])): ?>
                            (<?= ucfirst($course['level']) ?>)
                        <?php endif; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Cohort Selection -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Assign to Cohort (Optional)
            </label>
            <select name="cohort_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary">
                <option value="">No cohort assignment</option>
                <?php foreach ($cohorts as $cohort): ?>
                    <option value="<?= $cohort['id'] ?>">
                        <?= htmlspecialchars($cohort['name']) ?> 
                        (<?= $cohort['student_count'] ?>/<?= $cohort['max_students'] ?> students)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Info Box -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex items-start gap-3">
                <i class="fas fa-info-circle text-blue-600 mt-1"></i>
                <div class="text-sm text-blue-800">
                    <p class="font-semibold mb-1">What happens next:</p>
                    <ul class="list-disc list-inside space-y-1">
                        <li>Student will be enrolled in the selected course</li>
                        <li>Welcome email will be sent to the student</li>
                        <li>Student will get immediate access to course materials</li>
                        <li>If cohort selected, student will be assigned to that cohort</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex gap-3">
            <button type="submit" class="flex-1 px-6 py-3 bg-primary hover:bg-primary-dark text-white rounded-lg font-semibold transition">
                <i class="fas fa-user-plus mr-2"></i>Enroll Student
            </button>
            <a href="<?= url('/admin/enrollments') ?>" class="flex-1 text-center px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg font-semibold transition">
                Cancel
            </a>
        </div>
    </form>
</div>

<script>
async function submitEnrollment(e) {
    e.preventDefault();
    const formData = new FormData(e.target);
    formData.append('_token', '<?= csrf_token() ?>');
    
    try {
        const response = await fetch('<?= url('/admin/enrollments/create') ?>', {
            method: 'POST',
            body: formData
        });
        const data = await response.json();
        
        if (data.success) {
            showSuccess('Student enrolled successfully!');
            setTimeout(() => window.location.href = '<?= url('/admin/enrollments') ?>', 1000);
        } else {
            showError('Error: ' + (data.error || 'Failed to enroll student'));
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
