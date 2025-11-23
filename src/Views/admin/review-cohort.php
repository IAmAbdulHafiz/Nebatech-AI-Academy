<?php
$title = 'Review Cohort - ' . htmlspecialchars($cohort['name']);
ob_start();
include __DIR__ . '/../partials/admin-sidebar.php';
$sidebarContent = ob_get_clean();
ob_start();
?>

<!-- Page Header -->
<div class="mb-6">
    <div class="flex items-center gap-4 mb-4">
        <a href="<?= url('/admin/approvals') ?>" class="text-gray-600 hover:text-gray-800">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Review Cohort</h1>
            <p class="text-sm text-gray-600">Submitted for approval</p>
        </div>
    </div>
</div>

<!-- Error Messages -->
<?php if (isset($_GET['error'])): ?>
    <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
        <?php
        $errors = [
            'reason_required' => 'Please provide a reason for rejection',
            'approval_failed' => 'Failed to approve cohort',
            'rejection_failed' => 'Failed to reject cohort'
        ];
        echo $errors[$_GET['error']] ?? 'An error occurred';
        ?>
    </div>
<?php endif; ?>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Cohort Details Card -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-900"><?= htmlspecialchars($cohort['name']) ?></h2>
                <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-yellow-100 text-yellow-800 mt-2">
                    <i class="fas fa-clock mr-1"></i>Pending Approval
                </span>
            </div>
            <div class="p-6 space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Program</p>
                        <p class="font-semibold text-gray-900"><?= htmlspecialchars($cohort['program']) ?></p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Facilitator</p>
                        <p class="font-semibold text-gray-900">
                            <?= htmlspecialchars(($cohort['facilitator_first_name'] ?? '') . ' ' . ($cohort['facilitator_last_name'] ?? '')) ?>
                        </p>
                        <p class="text-sm text-gray-500"><?= htmlspecialchars($cohort['facilitator_email'] ?? 'No email') ?></p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Start Date</p>
                        <p class="font-semibold text-gray-900">
                            <i class="fas fa-calendar-start mr-1"></i>
                            <?= date('F d, Y', strtotime($cohort['start_date'])) ?>
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">End Date</p>
                        <p class="font-semibold text-gray-900">
                            <i class="fas fa-calendar-check mr-1"></i>
                            <?= $cohort['end_date'] ? date('F d, Y', strtotime($cohort['end_date'])) : 'Not set' ?>
                        </p>
                    </div>
                </div>

                <div>
                    <p class="text-sm text-gray-600 mb-1">Max Students</p>
                    <p class="font-semibold text-gray-900">
                        <i class="fas fa-user-graduate mr-1"></i>
                        <?= $cohort['max_students'] ?> students
                    </p>
                </div>

                <?php if (!empty($cohort['description'])): ?>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Description</p>
                        <p class="text-gray-800"><?= nl2br(htmlspecialchars($cohort['description'])) ?></p>
                    </div>
                <?php endif; ?>

                <div>
                    <p class="text-sm text-gray-600 mb-1">Submitted</p>
                    <p class="text-sm text-gray-700">
                        <i class="fas fa-clock mr-1"></i>
                        <?= date('F d, Y \a\t g:i A', strtotime($cohort['created_at'])) ?>
                    </p>
                </div>
            </div>
        </div>

        <!-- Courses in Cohort -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-bold text-gray-900">
                    <i class="fas fa-book mr-2"></i>
                    Courses in Cohort (<?= count($courses) ?>)
                </h2>
            </div>
            <div class="p-6">
                <?php if (empty($courses)): ?>
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-exclamation-triangle text-4xl mb-3 text-red-500"></i>
                        <p class="font-semibold text-red-600">No courses added!</p>
                        <p class="text-sm">This cohort has no courses. Consider rejecting it.</p>
                    </div>
                <?php else: ?>
                    <div class="space-y-3">
                        <?php foreach ($courses as $index => $course): ?>
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 mb-2">
                                            <span class="bg-purple-100 text-purple-800 text-xs font-bold px-2 py-1 rounded">
                                                #<?= $index + 1 ?>
                                            </span>
                                            <h3 class="font-bold text-gray-900"><?= htmlspecialchars($course['title']) ?></h3>
                                        </div>
                                        <div class="flex items-center gap-4 text-sm text-gray-600">
                                            <span>
                                                <i class="fas fa-signal mr-1"></i>
                                                <?= ucfirst($course['level']) ?>
                                            </span>
                                            <span>
                                                <i class="fas fa-clock mr-1"></i>
                                                <?= $course['duration_hours'] ?>h
                                            </span>
                                            <?php if (!empty($course['cohort_start_date'])): ?>
                                                <span>
                                                    <i class="fas fa-calendar mr-1"></i>
                                                    <?= date('M d', strtotime($course['cohort_start_date'])) ?> - <?= date('M d', strtotime($course['cohort_end_date'])) ?>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Approval History -->
        <?php if (!empty($history)): ?>
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-bold text-gray-900">
                        <i class="fas fa-history mr-2"></i>
                        Approval History
                    </h2>
                </div>
                <div class="p-6">
                    <div class="space-y-3">
                        <?php foreach ($history as $entry): ?>
                            <div class="flex items-start gap-3 pb-3 border-b border-gray-100 last:border-0">
                                <div class="flex-shrink-0 mt-1">
                                    <?php if ($entry['action'] === 'submitted'): ?>
                                        <i class="fas fa-paper-plane text-blue-600"></i>
                                    <?php elseif ($entry['action'] === 'approved'): ?>
                                        <i class="fas fa-check-circle text-green-600"></i>
                                    <?php elseif ($entry['action'] === 'rejected'): ?>
                                        <i class="fas fa-times-circle text-red-600"></i>
                                    <?php elseif ($entry['action'] === 'resubmitted'): ?>
                                        <i class="fas fa-redo text-orange-600"></i>
                                    <?php endif; ?>
                                </div>
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-900">
                                        <?= ucfirst($entry['action']) ?>
                                        <?php if ($entry['first_name']): ?>
                                            by <?= htmlspecialchars($entry['first_name'] . ' ' . $entry['last_name']) ?>
                                        <?php endif; ?>
                                    </p>
                                    <p class="text-sm text-gray-600"><?= date('M d, Y \a\t g:i A', strtotime($entry['created_at'])) ?></p>
                                    <?php if (!empty($entry['reason'])): ?>
                                        <p class="text-sm text-gray-700 mt-1 italic">"<?= htmlspecialchars($entry['reason']) ?>"</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Sidebar - Actions -->
    <div class="space-y-6">
        <!-- Approve Card -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-green-200 bg-green-50">
                <h3 class="font-bold text-green-900">
                    <i class="fas fa-check-circle mr-2"></i>
                    Approve Cohort
                </h3>
            </div>
            <div class="p-6">
                <p class="text-sm text-gray-600 mb-4">
                    Approving this cohort will allow the facilitator to invite students and start the cohort.
                </p>
                <form method="POST" action="<?= url('/admin/approvals/cohorts/' . $cohort['id'] . '/approve') ?>" 
                      onsubmit="return confirm('Are you sure you want to approve this cohort?')">
                    <?= csrf_field() ?>
                    <textarea name="reason" 
                              placeholder="Optional: Add a note for the facilitator" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg mb-3 text-sm"
                              rows="3"></textarea>
                    <button type="submit" 
                            class="w-full px-4 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium">
                        <i class="fas fa-check mr-2"></i>
                        Approve Cohort
                    </button>
                </form>
            </div>
        </div>

        <!-- Reject Card -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-red-200 bg-red-50">
                <h3 class="font-bold text-red-900">
                    <i class="fas fa-times-circle mr-2"></i>
                    Reject Cohort
                </h3>
            </div>
            <div class="p-6">
                <p class="text-sm text-gray-600 mb-4">
                    Provide feedback to help the facilitator improve their submission.
                </p>
                <form method="POST" action="<?= url('/admin/approvals/cohorts/' . $cohort['id'] . '/reject') ?>" 
                      onsubmit="return confirm('Are you sure you want to reject this cohort?')">
                    <?= csrf_field() ?>
                    <textarea name="reason" 
                              placeholder="Reason for rejection (required)" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg mb-3 text-sm"
                              rows="4"
                              required></textarea>
                    <button type="submit" 
                            class="w-full px-4 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-medium">
                        <i class="fas fa-times mr-2"></i>
                        Reject with Feedback
                    </button>
                </form>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="font-bold text-gray-900 mb-4">Quick Stats</h3>
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Courses</span>
                    <span class="font-semibold text-gray-900"><?= count($courses) ?></span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Max Students</span>
                    <span class="font-semibold text-gray-900"><?= $cohort['max_students'] ?></span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Duration</span>
                    <span class="font-semibold text-gray-900">
                        <?php
                        $start = new DateTime($cohort['start_date']);
                        $end = $cohort['end_date'] ? new DateTime($cohort['end_date']) : null;
                        if ($end) {
                            $diff = $start->diff($end);
                            echo $diff->days . ' days';
                        } else {
                            echo 'Not set';
                        }
                        ?>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/dashboard.php';
?>
