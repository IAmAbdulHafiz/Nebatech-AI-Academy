<?php
$title = 'Cohort Details - ' . htmlspecialchars($cohort['name']);
ob_start();
include __DIR__ . '/../partials/admin-sidebar.php';
$sidebarContent = ob_get_clean();
ob_start();

$statusColors = [
    'upcoming' => 'bg-blue-100 text-blue-800',
    'active' => 'bg-green-100 text-green-800',
    'completed' => 'bg-gray-100 text-gray-800'
];
$statusColor = $statusColors[$cohort['status']] ?? 'bg-gray-100 text-gray-800';
$programInfo = $programs[$cohort['program']] ?? null;
?>

<!-- Page Header -->
<div class="mb-6">
    <div class="flex items-center gap-4 mb-4">
        <a href="<?= url('/admin/cohorts') ?>" class="text-gray-600 hover:text-primary">
            <i class="fas fa-arrow-left text-xl"></i>
        </a>
        <div class="flex-1">
            <div class="flex items-center gap-3 mb-2">
                <h1 class="text-3xl font-bold text-gray-900"><?= htmlspecialchars($cohort['name']) ?></h1>
                <span class="px-3 py-1 rounded-full text-sm font-semibold <?= $statusColor ?>">
                    <?= ucfirst($cohort['status']) ?>
                </span>
                <?php
                $approvalColors = [
                    'pending_approval' => 'bg-yellow-100 text-yellow-800',
                    'approved' => 'bg-green-100 text-green-800',
                    'rejected' => 'bg-red-100 text-red-800',
                    'draft' => 'bg-gray-100 text-gray-800'
                ];
                $approvalColor = $approvalColors[$cohort['approval_status']] ?? 'bg-gray-100 text-gray-800';
                ?>
                <?php if (!empty($cohort['approval_status'])): ?>
                    <span class="px-3 py-1 rounded-full text-sm font-semibold <?= $approvalColor ?>">
                        <?php if ($cohort['approval_status'] === 'pending_approval'): ?>
                            <i class="fas fa-clock mr-1"></i>Pending Approval
                        <?php elseif ($cohort['approval_status'] === 'approved'): ?>
                            <i class="fas fa-check mr-1"></i>Approved
                        <?php elseif ($cohort['approval_status'] === 'rejected'): ?>
                            <i class="fas fa-times mr-1"></i>Rejected
                        <?php elseif ($cohort['approval_status'] === 'draft'): ?>
                            <i class="fas fa-file mr-1"></i>Draft
                        <?php endif; ?>
                    </span>
                <?php endif; ?>
            </div>
            <p class="text-gray-600">
                <?= $programInfo ? htmlspecialchars($programInfo['name']) : htmlspecialchars(ucwords(str_replace('-', ' ', $cohort['program']))) ?>
            </p>
        </div>
    </div>
</div>

<!-- Approval Actions Banner -->
<?php if (isset($cohort['approval_status']) && $cohort['approval_status'] === 'pending_approval'): ?>
    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
        <div class="flex items-start justify-between">
            <div class="flex items-start gap-3">
                <i class="fas fa-clock text-yellow-600 text-xl mt-1"></i>
                <div>
                    <h3 class="font-bold text-yellow-900 mb-1">Pending Your Approval</h3>
                    <p class="text-sm text-yellow-800">This cohort has been submitted by the facilitator and is awaiting your review.</p>
                </div>
            </div>
            <div class="flex gap-2">
                <button onclick="approveCohort(<?= $cohort['id'] ?>, '<?= htmlspecialchars($cohort['name']) ?>')"
                        class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium whitespace-nowrap">
                    <i class="fas fa-check mr-2"></i>Approve
                </button>
                <button onclick="rejectCohort(<?= $cohort['id'] ?>, '<?= htmlspecialchars($cohort['name']) ?>')"
                        class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-medium whitespace-nowrap">
                    <i class="fas fa-times mr-2"></i>Reject
                </button>
            </div>
        </div>
    </div>
<?php elseif (isset($cohort['approval_status']) && $cohort['approval_status'] === 'rejected'): ?>
    <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
        <div class="flex items-start gap-3">
            <i class="fas fa-exclamation-triangle text-red-600 text-xl mt-1"></i>
            <div class="flex-1">
                <h3 class="font-bold text-red-900 mb-1">Rejected</h3>
                <p class="text-sm text-red-800 mb-2">This cohort was rejected and sent back to the facilitator for revision.</p>
                <?php if (!empty($cohort['rejection_reason'])): ?>
                    <div class="bg-red-100 rounded p-3 mt-2">
                        <p class="text-sm font-semibold text-red-900 mb-1">Rejection Reason:</p>
                        <p class="text-sm text-red-800"><?= htmlspecialchars($cohort['rejection_reason']) ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php elseif (isset($cohort['approval_status']) && $cohort['approval_status'] === 'approved'): ?>
    <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
        <div class="flex items-start gap-3">
            <i class="fas fa-check-circle text-green-600 text-xl mt-1"></i>
            <div>
                <h3 class="font-bold text-green-900 mb-1">Approved</h3>
                <p class="text-sm text-green-800">This cohort has been approved and is now active.</p>
                <?php if (!empty($cohort['approved_at'])): ?>
                    <p class="text-xs text-green-700 mt-1">Approved on <?= date('M d, Y', strtotime($cohort['approved_at'])) ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php endif; ?>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Cohort Information -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <h2 class="text-lg font-bold text-gray-900">Cohort Information</h2>
                <button onclick="toggleEditForm()" class="text-primary hover:text-primary-dark font-semibold text-sm">
                    <i class="fas fa-edit mr-1"></i>Edit
                </button>
            </div>
            
            <!-- View Mode -->
            <div id="viewMode" class="p-6 space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Facilitator</label>
                        <p class="text-gray-900">
                            <?= !empty($cohort['facilitator_first_name']) ? htmlspecialchars($cohort['facilitator_first_name'] . ' ' . $cohort['facilitator_last_name']) : 'Not assigned' ?>
                        </p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Students</label>
                        <p class="text-gray-900"><?= (int)$cohort['student_count'] ?> / <?= (int)$cohort['max_students'] ?></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                        <p class="text-gray-900"><?= date('F d, Y', strtotime($cohort['start_date'])) ?></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                        <p class="text-gray-900">
                            <?= !empty($cohort['end_date']) ? date('F d, Y', strtotime($cohort['end_date'])) : 'Not set' ?>
                        </p>
                    </div>
                </div>
                <?php if (!empty($cohort['description'])): ?>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <p class="text-gray-700"><?= nl2br(htmlspecialchars($cohort['description'])) ?></p>
                </div>
                <?php endif; ?>
            </div>

            <!-- Edit Mode -->
            <form id="editMode" method="POST" action="<?= url('/admin/cohorts/' . $cohort['id'] . '/edit') ?>" class="p-6 space-y-4 hidden">
                <?= csrf_field() ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cohort Name</label>
                        <input type="text" name="name" value="<?= htmlspecialchars($cohort['name']) ?>" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Program</label>
                        <select name="program" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary">
                            <?php foreach ($programs as $slug => $program): ?>
                                <option value="<?= $slug ?>" <?= $cohort['program'] === $slug ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($program['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Facilitator</label>
                        <select name="facilitator_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary">
                            <option value="">Not assigned</option>
                            <?php foreach ($facilitators as $facilitator): ?>
                                <option value="<?= $facilitator['id'] ?>" <?= $cohort['facilitator_id'] == $facilitator['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($facilitator['first_name'] . ' ' . $facilitator['last_name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary">
                            <option value="upcoming" <?= $cohort['status'] === 'upcoming' ? 'selected' : '' ?>>Upcoming</option>
                            <option value="active" <?= $cohort['status'] === 'active' ? 'selected' : '' ?>>Active</option>
                            <option value="completed" <?= $cohort['status'] === 'completed' ? 'selected' : '' ?>>Completed</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Start Date</label>
                        <input type="date" name="start_date" value="<?= date('Y-m-d', strtotime($cohort['start_date'])) ?>" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">End Date</label>
                        <input type="date" name="end_date" value="<?= !empty($cohort['end_date']) ? date('Y-m-d', strtotime($cohort['end_date'])) : '' ?>"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Max Students</label>
                        <input type="number" name="max_students" value="<?= (int)$cohort['max_students'] ?>" min="1" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea name="description" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary"><?= htmlspecialchars($cohort['description'] ?? '') ?></textarea>
                </div>
                <div class="flex gap-3">
                    <button type="submit" class="bg-primary hover:bg-primary-dark text-white px-6 py-2 rounded-lg font-semibold transition">
                        Save Changes
                    </button>
                    <button type="button" onclick="toggleEditForm()" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2 rounded-lg font-semibold transition">
                        Cancel
                    </button>
                </div>
            </form>
        </div>

        <!-- Courses in Cohort -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <h2 class="text-lg font-bold text-gray-900">Courses in Cohort</h2>
                <button onclick="showAddCourseModal()" class="text-primary hover:text-primary-dark font-semibold text-sm">
                    <i class="fas fa-plus mr-1"></i>Add Course
                </button>
            </div>
            <div class="p-6">
                <?php 
                $cohortCourses = \Nebatech\Models\Cohort::getCourses($cohort['id']);
                if (empty($cohortCourses)): 
                ?>
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-book text-4xl mb-3"></i>
                        <p>No courses added to this cohort yet</p>
                    </div>
                <?php else: ?>
                    <div class="space-y-3">
                        <?php foreach ($cohortCourses as $course): ?>
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-200">
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-900"><?= htmlspecialchars($course['title']) ?></h3>
                                    <div class="flex items-center gap-4 mt-1 text-sm text-gray-600">
                                        <?php if (!empty($course['cohort_start_date'])): ?>
                                            <span><i class="fas fa-calendar mr-1"></i><?= date('M d', strtotime($course['cohort_start_date'])) ?> - <?= date('M d, Y', strtotime($course['cohort_end_date'])) ?></span>
                                        <?php endif; ?>
                                        <span><i class="fas fa-signal mr-1"></i><?= ucfirst($course['level']) ?></span>
                                        <span><i class="fas fa-clock mr-1"></i><?= $course['duration_hours'] ?>h</span>
                                    </div>
                                </div>
                                <button onclick="removeCourseFromCohort(<?= $course['id'] ?>, '<?= htmlspecialchars($course['title']) ?>')" 
                                    class="text-red-600 hover:text-red-800 font-semibold text-sm ml-4">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Students List -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-bold text-gray-900">Students (<?= count($students) ?>)</h2>
            </div>
            <div class="p-6">
                <?php if (empty($students)): ?>
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-users text-4xl mb-3"></i>
                        <p>No students assigned yet</p>
                    </div>
                <?php else: ?>
                    <div class="space-y-3">
                        <?php foreach ($students as $student): ?>
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-primary text-white rounded-full flex items-center justify-center font-bold">
                                        <?= strtoupper(substr($student['first_name'], 0, 1) . substr($student['last_name'], 0, 1)) ?>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900">
                                            <?= htmlspecialchars($student['first_name'] . ' ' . $student['last_name']) ?>
                                        </p>
                                        <p class="text-sm text-gray-600"><?= htmlspecialchars($student['email']) ?></p>
                                    </div>
                                </div>
                                <button onclick="removeStudent(<?= $student['id'] ?>, '<?= htmlspecialchars($student['first_name']) ?>')" 
                                    class="text-red-600 hover:text-red-800 font-semibold text-sm">
                                    <i class="fas fa-times"></i> Remove
                                </button>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Add Student -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="font-bold text-gray-900">Add Student</h3>
            </div>
            <div class="p-6">
                <form onsubmit="addStudent(event)">
                    <select id="studentSelect" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary mb-3">
                        <option value="">Select a student</option>
                        <?php foreach ($availableStudents as $student): ?>
                            <option value="<?= $student['id'] ?>">
                                <?= htmlspecialchars($student['first_name'] . ' ' . $student['last_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" class="w-full bg-primary hover:bg-primary-dark text-white px-4 py-2 rounded-lg font-semibold transition">
                        <i class="fas fa-plus mr-2"></i>Add to Cohort
                    </button>
                </form>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="font-bold text-gray-900 mb-4">Quick Stats</h3>
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-600">Total Students:</span>
                    <span class="font-bold text-gray-900"><?= count($students) ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Available Slots:</span>
                    <span class="font-bold text-gray-900"><?= max(0, $cohort['max_students'] - count($students)) ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Capacity:</span>
                    <span class="font-bold text-gray-900">
                        <?= $cohort['max_students'] > 0 ? number_format((count($students) / $cohort['max_students']) * 100, 0) : 0 ?>%
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function toggleEditForm() {
    document.getElementById('viewMode').classList.toggle('hidden');
    document.getElementById('editMode').classList.toggle('hidden');
}

function addStudent(event) {
    event.preventDefault();
    const studentId = document.getElementById('studentSelect').value;
    
    if (!studentId) {
        showWarning('Please select a student');
        return;
    }

    fetch('<?= url('/admin/cohorts/assign-student') ?>', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `cohort_id=<?= $cohort['id'] ?>&user_id=${studentId}&_token=<?= csrf_token() ?>`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showSuccess('Student added successfully');
            setTimeout(() => window.location.reload(), 1000);
        } else {
            showError('Error: ' + (data.error || 'Failed to add student'));
        }
    })
    .catch(error => {
        showError('An error occurred: ' + error.message);
    });
}

async function removeStudent(userId, firstName) {
    const confirmed = await confirmAction(`Remove ${firstName} from this cohort?`, {
        title: 'Remove Student',
        confirmText: 'Remove',
        type: 'danger'
    });
    
    if (!confirmed) return;

    fetch('<?= url('/admin/cohorts/remove-student') ?>', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `cohort_id=<?= $cohort['id'] ?>&user_id=${userId}&_token=<?= csrf_token() ?>`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showSuccess('Student removed successfully');
            setTimeout(() => window.location.reload(), 1000);
        } else {
            showError('Error: ' + (data.error || 'Failed to remove student'));
        }
    })
    .catch(error => {
        showError('An error occurred: ' + error.message);
    });
}

let addCourseModal = null;

function showAddCourseModal() {
    // Fetch available courses
    fetch('<?= url('/admin/cohorts/available-courses') ?>?cohort_id=<?= $cohort['id'] ?>')
        .then(response => response.json())
        .then(data => {
            if (!data.success || !data.courses || data.courses.length === 0) {
                showWarning('No available courses to add. All published courses are already in this cohort.');
                return;
            }

            // Create modal HTML
            const modalHTML = `
                <div id="addCourseModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                    <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto">
                        <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                            <h3 class="text-xl font-bold text-gray-900">Add Course to Cohort</h3>
                            <button onclick="closeAddCourseModal()" class="text-gray-400 hover:text-gray-600">
                                <i class="fas fa-times text-xl"></i>
                            </button>
                        </div>
                        <form id="addCourseForm" class="p-6 space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Select Course *</label>
                                <select id="courseSelect" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary">
                                    <option value="">Choose a course...</option>
                                    ${data.courses.map(course => `
                                        <option value="${course.id}" data-duration="${course.duration_hours}">
                                            ${course.title} (${course.level} - ${course.duration_hours}h)
                                        </option>
                                    `).join('')}
                                </select>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Start Date</label>
                                    <input type="date" id="courseStartDate" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary">
                                    <p class="text-xs text-gray-500 mt-1">Optional: When this course starts in the cohort</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">End Date</label>
                                    <input type="date" id="courseEndDate" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary">
                                    <p class="text-xs text-gray-500 mt-1">Optional: When this course ends in the cohort</p>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Order/Sequence</label>
                                <input type="number" id="courseOrder" min="0" value="0" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary">
                                <p class="text-xs text-gray-500 mt-1">Order in which this course appears (0 = first)</p>
                            </div>
                            <div class="flex gap-3 pt-4">
                                <button type="submit" class="flex-1 bg-primary hover:bg-primary-dark text-white px-6 py-3 rounded-lg font-semibold transition">
                                    <i class="fas fa-plus mr-2"></i>Add Course
                                </button>
                                <button type="button" onclick="closeAddCourseModal()" class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg font-semibold transition">
                                    Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            `;

            // Add modal to page
            document.body.insertAdjacentHTML('beforeend', modalHTML);
            addCourseModal = document.getElementById('addCourseModal');

            // Handle form submission
            document.getElementById('addCourseForm').addEventListener('submit', handleAddCourse);
        })
        .catch(error => {
            showError('Failed to load available courses: ' + error.message);
        });
}

function closeAddCourseModal() {
    if (addCourseModal) {
        addCourseModal.remove();
        addCourseModal = null;
    }
}

function handleAddCourse(event) {
    event.preventDefault();
    
    const courseId = document.getElementById('courseSelect').value;
    const startDate = document.getElementById('courseStartDate').value;
    const endDate = document.getElementById('courseEndDate').value;
    const orderIndex = document.getElementById('courseOrder').value;

    if (!courseId) {
        showWarning('Please select a course');
        return;
    }

    // Build form data
    const formData = new URLSearchParams();
    formData.append('cohort_id', '<?= $cohort['id'] ?>');
    formData.append('course_id', courseId);
    if (startDate) formData.append('start_date', startDate);
    if (endDate) formData.append('end_date', endDate);
    formData.append('order_index', orderIndex);
    formData.append('_token', '<?= csrf_token() ?>');

    fetch('<?= url('/admin/cohorts/add-course') ?>', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showSuccess('Course added to cohort successfully');
            closeAddCourseModal();
            setTimeout(() => window.location.reload(), 1000);
        } else {
            showError('Error: ' + (data.error || 'Failed to add course'));
        }
    })
    .catch(error => {
        showError('An error occurred: ' + error.message);
    });
}

async function removeCourseFromCohort(courseId, courseName) {
    const confirmed = await confirmAction(`Remove "${courseName}" from this cohort?`, {
        title: 'Remove Course',
        confirmText: 'Remove',
        type: 'danger'
    });
    
    if (!confirmed) return;

    fetch('<?= url('/admin/cohorts/remove-course') ?>', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `cohort_id=<?= $cohort['id'] ?>&course_id=${courseId}&_token=<?= csrf_token() ?>`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showSuccess('Course removed from cohort successfully');
            setTimeout(() => window.location.reload(), 1000);
        } else {
            showError('Error: ' + (data.error || 'Failed to remove course'));
        }
    })
    .catch(error => {
        showError('An error occurred: ' + error.message);
    });
}

// Approve cohort
async function approveCohort(cohortId, cohortName) {
    const confirmed = await confirmAction(`Are you sure you want to approve the cohort "${cohortName}"?`, {
        title: 'Approve Cohort',
        confirmText: 'Approve',
        type: 'success'
    });
    
    if (!confirmed) return;

    fetch('<?= url('/admin/cohorts/approve') ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `cohort_id=${cohortId}&_token=<?= csrf_token() ?>`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showSuccess('Cohort approved successfully');
            setTimeout(() => window.location.reload(), 1000);
        } else {
            showError('Error: ' + (data.error || 'Failed to approve cohort'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showError('An error occurred while approving the cohort');
    });
}

// Reject cohort
async function rejectCohort(cohortId, cohortName) {
    const reason = await promptInput('Please provide a reason for rejecting this cohort:', {
        title: `Reject Cohort: ${cohortName}`,
        confirmText: 'Reject',
        type: 'danger',
        placeholder: 'Enter rejection reason...',
        required: true
    });
    
    if (!reason) return;

    fetch('<?= url('/admin/cohorts/reject') ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `cohort_id=${cohortId}&reason=${encodeURIComponent(reason)}&_token=<?= csrf_token() ?>`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showSuccess('Cohort rejected successfully');
            setTimeout(() => window.location.reload(), 1000);
        } else {
            showError('Error: ' + (data.error || 'Failed to reject cohort'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showError('An error occurred while rejecting the cohort');
    });
}
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/dashboard.php';
?>
