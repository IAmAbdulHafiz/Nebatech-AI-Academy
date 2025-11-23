<?php
$title = 'Create Cohort';
ob_start();
include __DIR__ . '/../partials/facilitator-sidebar.php';
$sidebarContent = ob_get_clean();
ob_start();
?>

<!-- Page Header -->
<div class="mb-8">
    <div class="flex items-center gap-4 mb-4">
        <a href="<?= url('/facilitator/cohorts') ?>" class="text-gray-600 hover:text-gray-800">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Create New Cohort</h1>
            <p class="text-gray-600">Create a cohort and submit for admin approval</p>
        </div>
    </div>
</div>

<!-- Success Messages -->
<?php if (isset($_SESSION['success'])): ?>
    <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center gap-3">
        <i class="fas fa-check-circle text-green-600"></i>
        <span><?= htmlspecialchars($_SESSION['success']) ?></span>
    </div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<!-- Error Messages -->
<?php if (isset($_GET['error'])): ?>
    <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
        <?php
        $errors = [
            'missing_fields' => 'Please fill in all required fields',
            'creation_failed' => 'Failed to create cohort. Please try again.'
        ];
        echo $errors[$_GET['error']] ?? 'An error occurred';
        ?>
    </div>
<?php endif; ?>

<!-- Create Cohort Form -->
<form method="POST" action="<?= url('/facilitator/cohorts/create') ?>" class="max-w-4xl">
    <?= csrf_field() ?>
    <div class="bg-white rounded-lg shadow p-8 space-y-6">
        <!-- Basic Information -->
        <div>
            <h2 class="text-xl font-bold text-gray-900 mb-4">Basic Information</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Cohort Name -->
                <div class="md:col-span-2">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Cohort Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           required
                           placeholder="e.g., Full Stack Bootcamp - Q1 2025"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    <p class="text-sm text-gray-500 mt-1">Choose a descriptive name for your cohort</p>
                </div>

                <!-- Program -->
                <div>
                    <label for="program" class="block text-sm font-medium text-gray-700 mb-2">
                        Program <span class="text-red-500">*</span>
                    </label>
                    <select id="program" 
                            name="program" 
                            required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <option value="">Select a program</option>
                        <?php foreach ($programs as $key => $program): ?>
                            <option value="<?= htmlspecialchars($key) ?>"><?= htmlspecialchars($program['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Max Students -->
                <div>
                    <label for="max_students" class="block text-sm font-medium text-gray-700 mb-2">
                        Maximum Students
                    </label>
                    <input type="number" 
                           id="max_students" 
                           name="max_students" 
                           min="1"
                           max="100"
                           placeholder="30"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    <p class="text-sm text-gray-500 mt-1">Leave empty for unlimited</p>
                </div>

                <!-- Start Date -->
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">
                        Start Date <span class="text-red-500">*</span>
                    </label>
                    <input type="date" 
                           id="start_date" 
                           name="start_date" 
                           required
                           min="<?= date('Y-m-d') ?>"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>

                <!-- End Date -->
                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">
                        End Date
                    </label>
                    <input type="date" 
                           id="end_date" 
                           name="end_date"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    <p class="text-sm text-gray-500 mt-1">Optional</p>
                </div>

                <!-- Description -->
                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Description
                    </label>
                    <textarea id="description" 
                              name="description" 
                              rows="4"
                              placeholder="Describe your cohort, learning objectives, and what students can expect..."
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"></textarea>
                </div>
            </div>
        </div>

        <!-- Course Selection -->
        <div class="border-t border-gray-200 pt-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">
                <i class="fas fa-book text-purple-600 mr-2"></i>
                Select Courses
            </h2>
            <p class="text-sm text-gray-600 mb-4">
                Choose which of your approved courses will be part of this cohort. You can add more courses later.
            </p>

            <?php if (empty($courses)): ?>
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <div class="flex items-start gap-3">
                        <i class="fas fa-exclamation-triangle text-yellow-600 mt-1"></i>
                        <div class="flex-1">
                            <p class="font-semibold text-yellow-900">No Approved Courses</p>
                            <p class="text-sm text-yellow-700 mb-3">You don't have any approved courses yet. Create and get courses approved before creating a cohort.</p>
                            <div class="flex gap-2">
                                <button onclick="openCreateCourseModal()" class="inline-flex items-center px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition font-medium text-sm">
                                    <i class="fas fa-plus mr-2"></i>Create Course Now
                                </button>
                                <a href="<?= url('/facilitator/courses/create') ?>" class="inline-flex items-center px-4 py-2 bg-white text-yellow-800 border border-yellow-300 rounded-lg hover:bg-yellow-50 transition font-medium text-sm">
                                    Go to Full Form
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="space-y-3">
                    <?php foreach ($courses as $course): ?>
                        <label class="flex items-start gap-3 p-4 border border-gray-200 rounded-lg hover:border-purple-300 hover:bg-purple-50 cursor-pointer transition">
                            <input type="checkbox" 
                                   name="course_ids[]" 
                                   value="<?= $course['id'] ?>"
                                   class="mt-1 w-5 h-5 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-900"><?= htmlspecialchars($course['title']) ?></h3>
                                <div class="flex items-center gap-4 text-sm text-gray-600 mt-1">
                                    <span>
                                        <i class="fas fa-signal mr-1"></i>
                                        <?= ucfirst($course['level']) ?>
                                    </span>
                                    <span>
                                        <i class="fas fa-clock mr-1"></i>
                                        <?= $course['duration_hours'] ?>h
                                    </span>
                                    <?php if (!empty($course['module_count'])): ?>
                                        <span>
                                            <i class="fas fa-folder mr-1"></i>
                                            <?= $course['module_count'] ?> modules
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </label>
                    <?php endforeach; ?>
                </div>
                <p class="text-sm text-gray-500 mt-3">
                    <i class="fas fa-info-circle mr-1"></i>
                    You can add or remove courses after creating the cohort (before submitting for approval)
                </p>
            <?php endif; ?>
        </div>

        <!-- Important Notice -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex items-start gap-3">
                <i class="fas fa-info-circle text-blue-600 mt-1"></i>
                <div class="text-sm text-blue-900">
                    <p class="font-semibold mb-1">What happens next?</p>
                    <ul class="list-disc list-inside space-y-1 text-blue-800">
                        <li>Your cohort will be created as a <strong>draft</strong></li>
                        <li>You can edit details and add/remove courses</li>
                        <li>When ready, submit for admin approval</li>
                        <li>Once approved, you can invite students to join</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-between pt-6 border-t border-gray-200">
            <a href="<?= url('/facilitator/cohorts') ?>" class="px-6 py-3 text-gray-700 hover:text-gray-900 font-medium">
                <i class="fas fa-times mr-2"></i>Cancel
            </a>
            <button type="submit" 
                    class="px-8 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition font-medium shadow-lg hover:shadow-xl">
                <i class="fas fa-plus mr-2"></i>Create Cohort
            </button>
        </div>
    </div>
</form>

<!-- Create Course Modal -->
<div id="createCourseModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4" onclick="closeCreateCourseModal(event)">
    <div class="bg-white rounded-lg shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto" onclick="event.stopPropagation()">
        <!-- Modal Header -->
        <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-900">
                <i class="fas fa-book text-green-600 mr-2"></i>Create New Course
            </h2>
            <button onclick="closeCreateCourseModal()" class="text-gray-400 hover:text-gray-600 transition">
                <i class="fas fa-times text-2xl"></i>
            </button>
        </div>

        <!-- Modal Body -->
        <form id="createCourseForm" method="POST" action="<?= url('/facilitator/courses/create') ?>" class="p-6 space-y-4">
            <input type="hidden" name="redirect_to" value="<?= url('/facilitator/cohorts/create') ?>">
            
            <!-- Course Title -->
            <div>
                <label for="modal_title" class="block text-sm font-semibold text-gray-700 mb-2">
                    Course Title <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="modal_title" 
                       name="title" 
                       required 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                       placeholder="e.g., Complete Front-End Development Bootcamp">
            </div>

            <!-- Category -->
            <div>
                <label for="modal_category" class="block text-sm font-semibold text-gray-700 mb-2">
                    Category <span class="text-red-500">*</span>
                </label>
                <select id="modal_category" 
                        name="category" 
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    <option value="">Select a category</option>
                    <option value="frontend">Frontend Development</option>
                    <option value="backend">Backend Development</option>
                    <option value="fullstack">Full Stack Development</option>
                    <option value="mobile">Mobile Development</option>
                    <option value="ai">AI & Machine Learning</option>
                    <option value="data-science">Data Science</option>
                    <option value="cybersecurity">Cybersecurity</option>
                    <option value="cloud">Cloud Computing</option>
                    <option value="database">Database Administration</option>
                    <option value="digital-literacy">Digital Literacy</option>
                </select>
            </div>

            <!-- Level -->
            <div>
                <label for="modal_level" class="block text-sm font-semibold text-gray-700 mb-2">
                    Difficulty Level <span class="text-red-500">*</span>
                </label>
                <select id="modal_level" 
                        name="level" 
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    <option value="beginner">Beginner</option>
                    <option value="intermediate">Intermediate</option>
                    <option value="advanced">Advanced</option>
                </select>
            </div>

            <!-- Duration -->
            <div>
                <label for="modal_duration_hours" class="block text-sm font-semibold text-gray-700 mb-2">
                    Estimated Duration (Hours) <span class="text-red-500">*</span>
                </label>
                <input type="number" 
                       id="modal_duration_hours" 
                       name="duration_hours" 
                       required 
                       min="1"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                       placeholder="e.g., 40">
            </div>

            <!-- Description -->
            <div>
                <label for="modal_description" class="block text-sm font-semibold text-gray-700 mb-2">
                    Course Description <span class="text-red-500">*</span>
                </label>
                <textarea id="modal_description" 
                          name="description" 
                          required 
                          rows="4"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                          placeholder="Provide a detailed description of what students will learn..."></textarea>
            </div>

            <!-- Status (hidden, always draft) -->
            <input type="hidden" name="status" value="draft">

            <!-- Info Notice -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                <div class="flex items-start gap-2">
                    <i class="fas fa-info-circle text-blue-600 mt-0.5"></i>
                    <p class="text-sm text-blue-800">
                        Course will be created as <strong>draft</strong> and submitted for admin approval. You can add modules and content after creation.
                    </p>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
                <button type="button" 
                        onclick="closeCreateCourseModal()"
                        class="px-6 py-2 text-gray-700 hover:text-gray-900 font-medium transition">
                    Cancel
                </button>
                <button type="submit" 
                        class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium shadow-lg hover:shadow-xl">
                    <i class="fas fa-plus mr-2"></i>Create Course
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Date Validation Script -->
<script>
// Date validation
document.getElementById('start_date').addEventListener('change', function() {
    const startDate = this.value;
    const endDateInput = document.getElementById('end_date');
    if (startDate) {
        endDateInput.min = startDate;
    }
});

document.getElementById('end_date').addEventListener('change', function() {
    const endDate = this.value;
    const startDate = document.getElementById('start_date').value;
    if (endDate && startDate && endDate < startDate) {
        alert('End date cannot be before start date');
        this.value = '';
    }
});

// Modal functions
function openCreateCourseModal() {
    document.getElementById('createCourseModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeCreateCourseModal(event) {
    if (!event || event.target.id === 'createCourseModal') {
        document.getElementById('createCourseModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
        document.getElementById('createCourseForm').reset();
    }
}

// Close modal on Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeCreateCourseModal();
    }
});
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/dashboard.php';
?>
