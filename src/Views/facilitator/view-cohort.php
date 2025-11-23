<?php
$title = 'Cohort Details';
ob_start();
include __DIR__ . '/../partials/facilitator-sidebar.php';
$sidebarContent = ob_get_clean();
ob_start();
?>
<div x-data="{ searchQuery: '' }">
<!-- Page Header -->
<div class="mb-6">
    <div class="flex items-center gap-4">
        <a href="<?= url('/facilitator/cohorts') ?>" class="text-gray-600 hover:text-gray-800">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-800"><?= htmlspecialchars($cohort['name']) ?></h1>
            <p class="text-sm text-gray-600"><?= htmlspecialchars($cohort['program']) ?></p>
        </div>
    </div>
</div>

<!-- Approval Status Banner -->
<?php if (isset($cohort['approval_status'])): ?>
    <?php if ($cohort['approval_status'] === 'draft'): ?>
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
            <div class="flex items-start justify-between">
                <div class="flex items-start gap-3">
                    <i class="fas fa-info-circle text-blue-600 text-xl mt-1"></i>
                    <div>
                        <h3 class="font-bold text-blue-900 mb-1">Draft Cohort</h3>
                        <p class="text-sm text-blue-800">This cohort is in draft mode. Add courses and submit for admin approval when ready.</p>
                    </div>
                </div>
                <button onclick="submitForApproval(<?= $cohort['id'] ?>, '<?= htmlspecialchars($cohort['name']) ?>')"
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium whitespace-nowrap">
                    <i class="fas fa-paper-plane mr-2"></i>Submit for Approval
                </button>
            </div>
        </div>
    <?php elseif ($cohort['approval_status'] === 'pending_approval'): ?>
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
            <div class="flex items-start gap-3">
                <i class="fas fa-clock text-yellow-600 text-xl mt-1"></i>
                <div>
                    <h3 class="font-bold text-yellow-900 mb-1">Pending Admin Approval</h3>
                    <p class="text-sm text-yellow-800">Your cohort has been submitted and is awaiting admin review. You'll be notified once it's approved.</p>
                </div>
            </div>
        </div>
    <?php elseif ($cohort['approval_status'] === 'rejected'): ?>
        <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
            <div class="flex items-start justify-between">
                <div class="flex items-start gap-3">
                    <i class="fas fa-exclamation-triangle text-red-600 text-xl mt-1"></i>
                    <div>
                        <h3 class="font-bold text-red-900 mb-1">Needs Revision</h3>
                        <p class="text-sm text-red-800 mb-2">Your cohort was reviewed and needs some changes before approval.</p>
                        <?php if (!empty($cohort['rejection_reason'])): ?>
                            <div class="bg-red-100 rounded p-3 mt-2">
                                <p class="text-sm font-semibold text-red-900 mb-1">Admin Feedback:</p>
                                <p class="text-sm text-red-800"><?= htmlspecialchars($cohort['rejection_reason']) ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <button onclick="submitForApproval(<?= $cohort['id'] ?>, '<?= htmlspecialchars($cohort['name']) ?>')"
                        class="px-6 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition font-medium whitespace-nowrap">
                    <i class="fas fa-redo mr-2"></i>Resubmit
                </button>
            </div>
        </div>
    <?php elseif ($cohort['approval_status'] === 'approved'): ?>
        <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
            <div class="flex items-start justify-between">
                <div class="flex items-start gap-3">
                    <i class="fas fa-check-circle text-green-600 text-xl mt-1"></i>
                    <div>
                        <h3 class="font-bold text-green-900 mb-1">Approved & Active</h3>
                        <p class="text-sm text-green-800">This cohort has been approved! You can now invite students to join.</p>
                    </div>
                </div>
                <button onclick="inviteStudents(<?= $cohort['id'] ?>)"
                        class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium whitespace-nowrap">
                    <i class="fas fa-user-plus mr-2"></i>Invite Students
                </button>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>

<!-- Cohort Info Card -->
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Status</p>
                            <?php
                            $statusColors = [
                                'upcoming' => 'bg-yellow-100 text-yellow-800',
                                'active' => 'bg-green-100 text-green-800',
                                'completed' => 'bg-gray-100 text-gray-800'
                            ];
                            $statusColor = $statusColors[$cohort['status']] ?? 'bg-gray-100 text-gray-800';
                            ?>
                            <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full <?= $statusColor ?>">
                                <?= ucfirst($cohort['status']) ?>
                            </span>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Students</p>
                            <p class="text-2xl font-bold text-primary">
                                <?= $cohort['student_count'] ?> / <?= $cohort['max_students'] ?>
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Start Date</p>
                            <p class="font-semibold text-gray-800">
                                <?= date('M d, Y', strtotime($cohort['start_date'])) ?>
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 mb-1">End Date</p>
                            <p class="font-semibold text-gray-800">
                                <?= $cohort['end_date'] ? date('M d, Y', strtotime($cohort['end_date'])) : 'Not set' ?>
                            </p>
                        </div>
                    </div>
                    <?php if ($cohort['description']): ?>
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <p class="text-sm text-gray-600 mb-1">Description</p>
                            <p class="text-gray-800"><?= nl2br(htmlspecialchars($cohort['description'])) ?></p>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Courses in Cohort -->
                <div class="bg-white rounded-lg shadow mb-6">
                    <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                        <h2 class="text-lg font-bold text-gray-900">Courses in Cohort</h2>
                        <?php if (in_array($cohort['approval_status'], ['draft', 'rejected'])): ?>
                            <button onclick="openAddCourseModal()" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition text-sm font-medium">
                                <i class="fas fa-plus mr-2"></i>Add Course
                            </button>
                        <?php endif; ?>
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
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <?php foreach ($cohortCourses as $course): ?>
                                    <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                                        <h3 class="font-semibold text-gray-900 mb-2"><?= htmlspecialchars($course['title']) ?></h3>
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center gap-4 text-sm text-gray-600">
                                                <?php if (!empty($course['cohort_start_date'])): ?>
                                                    <span><i class="fas fa-calendar mr-1"></i><?= date('M d', strtotime($course['cohort_start_date'])) ?> - <?= date('M d, Y', strtotime($course['cohort_end_date'])) ?></span>
                                                <?php endif; ?>
                                                <span><i class="fas fa-signal mr-1"></i><?= ucfirst($course['level']) ?></span>
                                                <span><i class="fas fa-clock mr-1"></i><?= $course['duration_hours'] ?>h</span>
                                            </div>
                                            <?php if (in_array($cohort['approval_status'], ['draft', 'rejected'])): ?>
                                                <button onclick="removeCourseFromCohort(<?= $cohort['id'] ?>, <?= $course['id'] ?>, '<?= htmlspecialchars($course['title']) ?>')" 
                                                        class="text-red-600 hover:text-red-800 transition text-sm">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                    <?php
                    $avgProgress = !empty($students) ? array_sum(array_column($students, 'total_progress')) / count($students) : 0;
                    $totalEnrollments = !empty($students) ? array_sum(array_map(fn($s) => count($s['enrollments']), $students)) : 0;
                    ?>
                    
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Total Students</p>
                                <p class="text-2xl font-bold text-blue-600"><?= count($students) ?></p>
                            </div>
                            <div class="bg-blue-100 p-3 rounded-full">
                                <i class="fas fa-user-graduate text-blue-600 text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Avg Progress</p>
                                <p class="text-2xl font-bold text-green-600"><?= number_format($avgProgress, 1) ?>%</p>
                            </div>
                            <div class="bg-green-100 p-3 rounded-full">
                                <i class="fas fa-chart-line text-green-600 text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Enrollments</p>
                                <p class="text-2xl font-bold text-purple-600"><?= $totalEnrollments ?></p>
                            </div>
                            <div class="bg-purple-100 p-3 rounded-full">
                                <i class="fas fa-book text-purple-600 text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Capacity</p>
                                <p class="text-2xl font-bold text-orange-600">
                                    <?= round(($cohort['student_count'] / $cohort['max_students']) * 100) ?>%
                                </p>
                            </div>
                            <div class="bg-orange-100 p-3 rounded-full">
                                <i class="fas fa-users text-orange-600 text-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Search -->
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <div class="relative">
                        <input type="text" x-model="searchQuery" 
                               placeholder="Search students by name or email..." 
                               class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
                </div>

                <!-- Students List -->
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-800">Cohort Students</h2>
                    </div>
                    
                    <?php if (empty($students)): ?>
                        <div class="p-12 text-center">
                            <i class="fas fa-user-graduate text-gray-400 text-6xl mb-4"></i>
                            <h3 class="text-xl font-semibold text-gray-700 mb-2">No Students Yet</h3>
                            <p class="text-gray-600">This cohort doesn't have any students assigned yet.</p>
                        </div>
                    <?php else: ?>
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-50 border-b">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Enrolled Courses</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Progress</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Joined</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <?php foreach ($students as $student): ?>
                                        <tr class="hover:bg-gray-50" 
                                            x-show="searchQuery === '' || 
                                                    '<?= strtolower($student['first_name'] . ' ' . $student['last_name'] . ' ' . $student['email']) ?>'.includes(searchQuery.toLowerCase())">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="h-10 w-10 flex-shrink-0">
                                                        <?php if ($student['avatar']): ?>
                                                            <img class="h-10 w-10 rounded-full object-cover" src="<?= url('/' . $student['avatar']) ?>" alt="">
                                                        <?php else: ?>
                                                            <div class="h-10 w-10 rounded-full bg-primary text-white flex items-center justify-center font-semibold">
                                                                <?= strtoupper(substr($student['first_name'], 0, 1) . substr($student['last_name'], 0, 1)) ?>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            <?= htmlspecialchars($student['first_name'] . ' ' . $student['last_name']) ?>
                                                        </div>
                                                        <div class="text-sm text-gray-500"><?= htmlspecialchars($student['email']) ?></div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="text-sm text-gray-900"><?= count($student['enrollments']) ?> courses</span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="w-24 bg-gray-200 rounded-full h-2 mr-2">
                                                        <div class="bg-primary h-2 rounded-full" 
                                                             style="width: <?= min(100, $student['total_progress']) ?>%"></div>
                                                    </div>
                                                    <span class="text-sm font-medium text-gray-900"><?= number_format($student['total_progress'], 1) ?>%</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <?= !empty($student['enrolled_at']) ? date('M d, Y', strtotime($student['enrolled_at'])) : 'N/A' ?>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="<?= url('/facilitator/students/' . $student['id']) ?>" class="text-primary hover:text-primary-dark">
                                                    <i class="fas fa-eye mr-1"></i>View
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>

</div>

<!-- Add Course Modal -->
<div id="addCourseModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg max-w-2xl w-full p-6 max-h-[90vh] overflow-y-auto">
        <h3 class="text-xl font-bold text-gray-900 mb-4">
            <i class="fas fa-book text-purple-600 mr-2"></i>Add Course to Cohort
        </h3>
        
        <form id="addCourseForm" onsubmit="submitAddCourse(event)">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Select Course *</label>
                <select id="courseSelect" name="course_id" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-600">
                    <option value="">Choose a course...</option>
                    <?php if (!empty($availableCourses)): ?>
                        <?php foreach ($availableCourses as $course): ?>
                            <option value="<?= $course['id'] ?>">
                                <?= htmlspecialchars($course['title']) ?> (<?= ucfirst($course['level']) ?>)
                            </option>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <option value="" disabled>No approved courses available</option>
                    <?php endif; ?>
                </select>
                <?php if (empty($availableCourses)): ?>
                    <p class="mt-2 text-sm text-gray-600">
                        <i class="fas fa-info-circle mr-1"></i>
                        You need to have approved and published courses to add them to a cohort.
                    </p>
                <?php endif; ?>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Start Date</label>
                    <input type="date" name="start_date" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-600">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">End Date</label>
                    <input type="date" name="end_date" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-600">
                </div>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="flex-1 px-4 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition font-medium">
                    <i class="fas fa-plus mr-2"></i>Add Course
                </button>
                <button type="button" onclick="closeAddCourseModal()" class="flex-1 px-4 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-medium">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Submit for Approval Modal -->
<div id="submitApprovalModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg max-w-md w-full p-6">
        <h3 class="text-xl font-bold text-gray-900 mb-4">
            <i class="fas fa-paper-plane text-blue-600 mr-2"></i>Submit for Approval
        </h3>
        
        <p class="text-gray-700 mb-4">
            You're about to submit <strong id="modalCohortName"></strong> for admin approval.
        </p>

        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
            <div class="flex items-start gap-3">
                <i class="fas fa-info-circle text-blue-600 mt-1"></i>
                <div class="text-sm text-blue-800">
                    <p class="font-semibold mb-1">Before submitting, make sure:</p>
                    <ul class="list-disc list-inside space-y-1">
                        <li>All necessary courses have been added</li>
                        <li>Cohort details are complete and accurate</li>
                        <li>Start and end dates are correct</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="flex gap-3">
            <button type="button" onclick="confirmSubmitForApproval()" 
                    class="flex-1 px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                <i class="fas fa-check mr-2"></i>Submit
            </button>
            <button type="button" onclick="closeSubmitModal()" 
                    class="flex-1 px-4 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-medium">
                Cancel
            </button>
        </div>
    </div>
</div>

<style>
@keyframes slide-in {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

.animate-slide-in {
    animation: slide-in 0.3s ease-out;
    transition: all 0.3s ease-out;
}
</style>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/dashboard.php';
?>
