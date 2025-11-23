<?php
$title = 'Application Details';
ob_start();
include __DIR__ . '/../partials/admin-sidebar.php';
$sidebarContent = ob_get_clean();
ob_start();
?>

<!-- Page Header -->
<div class="mb-6">
    <div class="flex items-center gap-4 mb-4">
        <a href="<?= url('/admin/applications') ?>" class="text-gray-600 hover:text-primary">
            <i class="fas fa-arrow-left text-xl"></i>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Application Details</h1>
            <p class="text-gray-600">Review and take action on this application</p>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Applicant Information -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-bold text-gray-900">Applicant Information</h2>
            </div>
            <div class="p-6">
                <div class="flex items-start gap-4 mb-6">
                    <div class="w-16 h-16 bg-primary text-white rounded-full flex items-center justify-center font-bold text-2xl">
                        <?= strtoupper(substr($application['first_name'], 0, 1) . substr($application['last_name'], 0, 1)) ?>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-xl font-bold text-gray-900 mb-1">
                            <?= htmlspecialchars($application['first_name'] . ' ' . $application['last_name']) ?>
                        </h3>
                        <p class="text-gray-600 mb-2"><?= htmlspecialchars($application['email']) ?></p>
                        <?php if (!empty($application['phone'])): ?>
                            <p class="text-gray-600"><i class="fas fa-phone mr-2"></i><?= htmlspecialchars($application['phone']) ?></p>
                        <?php endif; ?>
                        <?php if (!empty($application['country'])): ?>
                            <p class="text-gray-600"><i class="fas fa-map-marker-alt mr-2"></i><?= htmlspecialchars($application['country']) ?></p>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Program Applied</label>
                        <p class="text-gray-900 font-semibold"><?= htmlspecialchars(ucwords(str_replace('-', ' ', $application['program']))) ?></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Application Date</label>
                        <p class="text-gray-900"><?= date('F d, Y', strtotime($application['created_at'])) ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Educational Background -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-bold text-gray-900">Educational Background</h2>
            </div>
            <div class="p-6">
                <p class="text-gray-700 whitespace-pre-wrap"><?= htmlspecialchars($application['educational_background']) ?></p>
            </div>
        </div>

        <!-- Motivation Statement -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-bold text-gray-900">Motivation Statement</h2>
            </div>
            <div class="p-6">
                <p class="text-gray-700 whitespace-pre-wrap"><?= htmlspecialchars($application['motivation_statement']) ?></p>
            </div>
        </div>

        <!-- Additional Information -->
        <?php if (!empty($application['referral_source'])): ?>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-bold text-gray-900">How They Found Us</h2>
            </div>
            <div class="p-6">
                <p class="text-gray-700"><?= htmlspecialchars($application['referral_source']) ?></p>
            </div>
        </div>
        <?php endif; ?>

        <!-- Documents -->
        <?php if (!empty($application['document_path'])): ?>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-bold text-gray-900">Supporting Documents</h2>
            </div>
            <div class="p-6">
                <a href="<?= htmlspecialchars($application['document_path']) ?>" target="_blank" 
                   class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                    <i class="fas fa-file-download mr-2"></i>Download Document
                </a>
            </div>
        </div>
        <?php endif; ?>

        <!-- Admin Notes -->
        <?php if (!empty($application['admin_notes'])): ?>
        <div class="bg-blue-50 rounded-lg border border-blue-200 p-6">
            <h3 class="font-bold text-blue-900 mb-2">
                <i class="fas fa-sticky-note mr-2"></i>Admin Notes
            </h3>
            <p class="text-blue-800 whitespace-pre-wrap"><?= htmlspecialchars($application['admin_notes']) ?></p>
            <?php if (!empty($application['reviewer_first_name'])): ?>
                <p class="text-sm text-blue-600 mt-2">
                    By <?= htmlspecialchars($application['reviewer_first_name'] . ' ' . $application['reviewer_last_name']) ?> 
                    on <?= date('M d, Y', strtotime($application['reviewed_at'])) ?>
                </p>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>

    <!-- Sidebar Actions -->
    <div class="space-y-6">
        <!-- Status Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="font-bold text-gray-900 mb-4">Application Status</h3>
            <?php
            $statusConfig = [
                'pending' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-700', 'border' => 'border-yellow-200'],
                'approved' => ['bg' => 'bg-green-100', 'text' => 'text-green-700', 'border' => 'border-green-200'],
                'rejected' => ['bg' => 'bg-red-100', 'text' => 'text-red-700', 'border' => 'border-red-200'],
                'info_requested' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-700', 'border' => 'border-blue-200']
            ];
            $config = $statusConfig[$application['status']] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-700', 'border' => 'border-gray-200'];
            ?>
            <div class="<?= $config['bg'] ?> <?= $config['border'] ?> border-2 rounded-lg p-4 text-center mb-4">
                <span class="text-2xl font-bold <?= $config['text'] ?>">
                    <?= ucfirst(str_replace('_', ' ', $application['status'])) ?>
                </span>
            </div>

            <?php if ($application['status'] === 'pending' || $application['status'] === 'info_requested'): ?>
                <!-- Action Buttons -->
                <div class="space-y-2">
                    <button onclick="approveApplication(<?= $application['id'] ?>)" 
                            class="w-full px-4 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium">
                        <i class="fas fa-check mr-2"></i>Approve Application
                    </button>
                    <button onclick="requestInfo(<?= $application['id'] ?>)" 
                            class="w-full px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                        <i class="fas fa-info-circle mr-2"></i>Request More Info
                    </button>
                    <button onclick="rejectApplication(<?= $application['id'] ?>)" 
                            class="w-full px-4 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-medium">
                        <i class="fas fa-times mr-2"></i>Reject Application
                    </button>
                </div>
            <?php endif; ?>
        </div>

        <!-- Quick Info -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="font-bold text-gray-900 mb-4">Quick Info</h3>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-600">Application ID</span>
                    <span class="font-medium text-gray-900">#<?= $application['id'] ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Submitted</span>
                    <span class="font-medium text-gray-900"><?= date('M d, Y', strtotime($application['created_at'])) ?></span>
                </div>
                <?php if (!empty($application['reviewed_at'])): ?>
                <div class="flex justify-between">
                    <span class="text-gray-600">Reviewed</span>
                    <span class="font-medium text-gray-900"><?= date('M d, Y', strtotime($application['reviewed_at'])) ?></span>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Action Modals -->
<div id="approveModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg max-w-2xl w-full p-6 max-h-[90vh] overflow-y-auto">
        <h3 class="text-xl font-bold text-gray-900 mb-4">
            <i class="fas fa-check-circle text-green-600 mr-2"></i>Approve Application
        </h3>
        <form id="approveForm" onsubmit="submitApproval(event)">
            <input type="hidden" id="approve_application_id" name="application_id">
            
            <!-- Course Selection -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Assign to Course <span class="text-red-500">*</span>
                </label>
                <select name="course_id" id="courseSelect" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary">
                    <option value="">Select a course</option>
                    <?php foreach ($courses as $course): ?>
                        <option value="<?= $course['id'] ?>">
                            <?= htmlspecialchars($course['title']) ?> 
                            <?php if (!empty($course['level'])): ?>
                                (<?= ucfirst($course['level']) ?>)
                            <?php endif; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <p class="mt-1 text-sm text-gray-500">Student will be automatically enrolled in this course</p>
            </div>

            <!-- Cohort Selection -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Assign to Cohort (Optional)
                </label>
                <select name="cohort_id" id="cohortSelect" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary">
                    <option value="">No cohort assignment</option>
                    <?php foreach ($cohorts as $cohort): ?>
                        <option value="<?= $cohort['id'] ?>" data-program="<?= $cohort['program'] ?>">
                            <?= htmlspecialchars($cohort['name']) ?> 
                            (<?= $cohort['student_count'] ?>/<?= $cohort['max_students'] ?> students)
                        </option>
                    <?php endforeach; ?>
                </select>
                <p class="mt-1 text-sm text-gray-500">Assign student to a learning cohort</p>
            </div>

            <!-- Welcome Message -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Welcome Message (Optional)
                </label>
                <textarea name="welcome_message" rows="3" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary" placeholder="Add a personalized welcome message for the student..."></textarea>
            </div>

            <!-- Admin Notes -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Admin Notes (Optional)
                </label>
                <textarea name="notes" rows="2" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary" placeholder="Internal notes (not visible to student)"></textarea>
            </div>

            <!-- Info Box -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                <div class="flex items-start gap-3">
                    <i class="fas fa-info-circle text-blue-600 mt-1"></i>
                    <div class="text-sm text-blue-800">
                        <p class="font-semibold mb-1">What happens next:</p>
                        <ul class="list-disc list-inside space-y-1">
                            <li>Student will be enrolled in the selected course</li>
                            <li>Approval email will be sent with login credentials</li>
                            <li>Welcome email will be sent with course access</li>
                            <li>If cohort selected, cohort assignment email will be sent</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex gap-3">
                <button type="submit" class="flex-1 px-4 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium">
                    <i class="fas fa-check mr-2"></i>Approve & Enroll
                </button>
                <button type="button" onclick="closeModal('approveModal')" class="flex-1 px-4 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-medium">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<div id="rejectModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg max-w-md w-full p-6">
        <h3 class="text-xl font-bold text-gray-900 mb-4">Reject Application</h3>
        <form id="rejectForm" onsubmit="submitRejection(event)">
            <input type="hidden" id="reject_application_id" name="application_id">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Reason (Optional)</label>
                <textarea name="notes" rows="4" class="w-full border border-gray-300 rounded-lg px-4 py-2" placeholder="Provide feedback to the applicant..."></textarea>
            </div>
            <div class="flex gap-3">
                <button type="submit" class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-medium">
                    Reject
                </button>
                <button type="button" onclick="closeModal('rejectModal')" class="flex-1 px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-medium">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<div id="infoModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg max-w-md w-full p-6">
        <h3 class="text-xl font-bold text-gray-900 mb-4">Request More Information</h3>
        <form id="infoForm" onsubmit="submitInfoRequest(event)">
            <input type="hidden" id="info_application_id" name="application_id">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">What information do you need? *</label>
                <textarea name="notes" rows="4" class="w-full border border-gray-300 rounded-lg px-4 py-2" required placeholder="Specify what additional information is needed..."></textarea>
            </div>
            <div class="flex gap-3">
                <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                    Send Request
                </button>
                <button type="button" onclick="closeModal('infoModal')" class="flex-1 px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-medium">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function approveApplication(id) {
    document.getElementById('approve_application_id').value = id;
    document.getElementById('approveModal').classList.remove('hidden');
}

function rejectApplication(id) {
    document.getElementById('reject_application_id').value = id;
    document.getElementById('rejectModal').classList.remove('hidden');
}

function requestInfo(id) {
    document.getElementById('info_application_id').value = id;
    document.getElementById('infoModal').classList.remove('hidden');
}

function closeModal(modalId) {
    document.getElementById(modalId).classList.add('hidden');
}

async function submitApproval(e) {
    e.preventDefault();
    const formData = new FormData(e.target);
    formData.append('_token', '<?= csrf_token() ?>');
    
    try {
        const response = await fetch('<?= url('/admin/applications/approve') ?>', {
            method: 'POST',
            body: formData
        });
        const data = await response.json();
        
        if (data.success) {
            showSuccess('Application approved successfully!');
            setTimeout(() => window.location.reload(), 1000);
        } else {
            showError('Error: ' + (data.error || 'Failed to approve application'));
        }
    } catch (error) {
        showError('Error: ' + error.message);
    }
}

async function submitRejection(e) {
    e.preventDefault();
    const formData = new FormData(e.target);
    formData.append('_token', '<?= csrf_token() ?>');
    
    try {
        const response = await fetch('<?= url('/admin/applications/reject') ?>', {
            method: 'POST',
            body: formData
        });
        const data = await response.json();
        
        if (data.success) {
            showSuccess('Application rejected');
            setTimeout(() => window.location.reload(), 1000);
        } else {
            showError('Error: ' + (data.error || 'Failed to reject application'));
        }
    } catch (error) {
        showError('Error: ' + error.message);
    }
}

async function submitInfoRequest(e) {
    e.preventDefault();
    const formData = new FormData(e.target);
    formData.append('_token', '<?= csrf_token() ?>');
    
    try {
        const response = await fetch('<?= url('/admin/applications/request-info') ?>', {
            method: 'POST',
            body: formData
        });
        const data = await response.json();
        
        if (data.success) {
            showSuccess('Information request sent!');
            setTimeout(() => window.location.reload(), 1000);
        } else {
            showError('Error: ' + (data.error || 'Failed to send request'));
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
