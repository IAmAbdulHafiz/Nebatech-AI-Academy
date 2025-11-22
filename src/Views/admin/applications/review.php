<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Application - Nebatech AI Academy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <?php include __DIR__ . '/../../partials/header.php'; ?>

    <div class="max-w-7xl mx-auto px-4 py-8">
        <!-- Breadcrumb -->
        <div class="mb-6">
            <a href="<?= url('/admin/applications') ?>" class="text-purple-600 hover:text-purple-700">
                <i class="fas fa-arrow-left mr-2"></i>Back to Applications
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Application Header -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center">
                            <?php if ($application['avatar']): ?>
                                <img src="<?= url('/public/assets/images/' . $application['avatar']) ?>" 
                                     alt="<?= htmlspecialchars($application['first_name']) ?>"
                                     class="w-16 h-16 rounded-full mr-4">
                            <?php else: ?>
                                <div class="w-16 h-16 rounded-full bg-purple-100 flex items-center justify-center mr-4">
                                    <span class="text-purple-600 font-bold text-2xl">
                                        <?= strtoupper(substr($application['first_name'], 0, 1)) ?>
                                    </span>
                                </div>
                            <?php endif; ?>
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900">
                                    <?= htmlspecialchars($application['first_name'] . ' ' . $application['last_name']) ?>
                                </h1>
                                <p class="text-gray-600"><?= htmlspecialchars($application['email']) ?></p>
                            </div>
                        </div>
                        <?php
                        $statusColors = [
                            'pending' => 'bg-yellow-100 text-yellow-800',
                            'under_review' => 'bg-blue-100 text-blue-800',
                            'approved' => 'bg-green-100 text-green-800',
                            'rejected' => 'bg-red-100 text-red-800',
                            'waitlisted' => 'bg-purple-100 text-purple-800'
                        ];
                        $bgColor = $statusColors[$application['status']] ?? 'bg-gray-100 text-gray-800';
                        ?>
                        <span class="px-4 py-2 inline-flex text-sm leading-5 font-semibold rounded-full <?= $bgColor ?>">
                            <?= ucwords(str_replace('_', ' ', $application['status'])) ?>
                        </span>
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                        <div>
                            <p class="text-gray-500">Application ID</p>
                            <p class="font-mono text-xs"><?= $application['uuid'] ?></p>
                        </div>
                        <div>
                            <p class="text-gray-500">Submitted</p>
                            <p class="font-semibold"><?= date('M j, Y', strtotime($application['submitted_at'])) ?></p>
                        </div>
                        <div>
                            <p class="text-gray-500">Priority</p>
                            <p class="font-semibold <?= $application['priority'] === 'urgent' ? 'text-red-600' : '' ?>">
                                <?= ucfirst($application['priority']) ?>
                            </p>
                        </div>
                        <div>
                            <p class="text-gray-500">Program</p>
                            <p class="font-semibold"><?= htmlspecialchars($application['program_name']) ?></p>
                        </div>
                    </div>
                </div>

                <!-- Personal Information -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4 border-b pb-2">
                        <i class="fas fa-user text-purple-600 mr-2"></i>Personal Information
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Phone Number</label>
                            <p class="text-gray-900"><?= htmlspecialchars($application['phone']) ?></p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Country</label>
                            <p class="text-gray-900"><?= htmlspecialchars($application['country']) ?></p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">City</label>
                            <p class="text-gray-900"><?= htmlspecialchars($application['city'] ?: 'Not provided') ?></p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Employment Status</label>
                            <p class="text-gray-900"><?= htmlspecialchars($application['employment_status']) ?></p>
                        </div>
                    </div>
                </div>

                <!-- Background Information -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4 border-b pb-2">
                        <i class="fas fa-graduation-cap text-purple-600 mr-2"></i>Background Information
                    </h2>
                    
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-2">Educational Background</label>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-gray-900 whitespace-pre-wrap"><?= htmlspecialchars($application['educational_background']) ?></p>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-2">Motivation for Applying</label>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-gray-900 whitespace-pre-wrap"><?= htmlspecialchars($application['motivation']) ?></p>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-2">Career Goals</label>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-gray-900 whitespace-pre-wrap"><?= htmlspecialchars($application['goals']) ?></p>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-2">How did you hear about us?</label>
                            <p class="text-gray-900"><?= htmlspecialchars($application['referral_source']) ?></p>
                        </div>
                    </div>
                </div>

                <!-- Supporting Documents -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4 border-b pb-2">
                        <i class="fas fa-paperclip text-purple-600 mr-2"></i>Supporting Documents
                    </h2>
                    <div class="space-y-3">
                        <?php if ($application['id_document_path']): ?>
                            <a href="<?= url('/' . $application['id_document_path']) ?>" target="_blank"
                               class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                <div class="flex items-center">
                                    <i class="fas fa-id-card text-primary mr-3"></i>
                                    <span class="text-gray-900">ID Document</span>
                                </div>
                                <i class="fas fa-download text-gray-500"></i>
                            </a>
                        <?php endif; ?>

                        <?php if ($application['transcript_path']): ?>
                            <a href="<?= url('/' . $application['transcript_path']) ?>" target="_blank"
                               class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                <div class="flex items-center">
                                    <i class="fas fa-file-alt text-green-600 mr-3"></i>
                                    <span class="text-gray-900">Educational Transcript</span>
                                </div>
                                <i class="fas fa-download text-gray-500"></i>
                            </a>
                        <?php endif; ?>

                        <?php if ($application['resume_path']): ?>
                            <a href="<?= url('/' . $application['resume_path']) ?>" target="_blank"
                               class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                <div class="flex items-center">
                                    <i class="fas fa-file-pdf text-red-600 mr-3"></i>
                                    <span class="text-gray-900">Resume / CV</span>
                                </div>
                                <i class="fas fa-download text-gray-500"></i>
                            </a>
                        <?php endif; ?>

                        <?php if (!$application['id_document_path'] && !$application['transcript_path'] && !$application['resume_path']): ?>
                            <p class="text-gray-500 text-sm">No documents uploaded</p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Timeline -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4 border-b pb-2">
                        <i class="fas fa-history text-purple-600 mr-2"></i>Application Timeline
                    </h2>
                    <?php if (empty($timeline)): ?>
                        <p class="text-gray-500 text-sm">No timeline events yet</p>
                    <?php else: ?>
                        <div class="space-y-4">
                            <?php foreach ($timeline as $event): ?>
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center">
                                        <i class="fas fa-circle text-purple-600 text-xs"></i>
                                    </div>
                                    <div class="ml-4 flex-1">
                                        <div class="flex items-start justify-between">
                                            <div>
                                                <p class="font-semibold text-gray-900"><?= htmlspecialchars($event['event_type']) ?></p>
                                                <p class="text-sm text-gray-600"><?= htmlspecialchars($event['description']) ?></p>
                                                <?php if ($event['actor_id']): ?>
                                                    <p class="text-xs text-gray-500 mt-1">
                                                        by <?= htmlspecialchars($event['actor_role'] ?? 'System') ?>
                                                    </p>
                                                <?php endif; ?>
                                            </div>
                                            <span class="text-xs text-gray-500 whitespace-nowrap ml-4">
                                                <?= date('M j, g:i A', strtotime($event['created_at'])) ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Action Panel -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-lg p-6 sticky top-4 space-y-6">
                    <h2 class="text-xl font-bold text-gray-900 border-b pb-2">
                        <i class="fas fa-tasks text-purple-600 mr-2"></i>Review Actions
                    </h2>

                    <?php if ($application['status'] === 'approved'): ?>
                        <!-- Already Approved -->
                        <div class="bg-green-50 border-l-4 border-green-500 p-4">
                            <p class="text-sm text-green-800 font-semibold">
                                <i class="fas fa-check-circle mr-2"></i>Application Approved
                            </p>
                            <?php if ($application['cohort_name']): ?>
                                <p class="text-xs text-green-700 mt-1">
                                    Enrolled in: <?= htmlspecialchars($application['cohort_name']) ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    <?php elseif ($application['status'] === 'rejected'): ?>
                        <!-- Already Rejected -->
                        <div class="bg-red-50 border-l-4 border-red-500 p-4">
                            <p class="text-sm text-red-800 font-semibold">
                                <i class="fas fa-times-circle mr-2"></i>Application Rejected
                            </p>
                            <?php if ($application['rejection_reason']): ?>
                                <p class="text-xs text-red-700 mt-1">
                                    Reason: <?= htmlspecialchars($application['rejection_reason']) ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <!-- Review Form -->
                        <form id="reviewForm">
                            <input type="hidden" name="application_id" value="<?= $application['id'] ?>">

                            <!-- Approve Section -->
                            <div class="mb-6 pb-6 border-b">
                                <h3 class="font-semibold text-gray-900 mb-3 text-green-700">
                                    <i class="fas fa-check mr-2"></i>Approve Application
                                </h3>
                                
                                <div class="space-y-3">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                            Assign to Cohort *
                                        </label>
                                        <select name="cohort_id" id="cohortSelect" 
                                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 text-sm">
                                            <option value="">Select cohort...</option>
                                            <?php foreach ($cohorts as $cohort): ?>
                                                <option value="<?= $cohort['id'] ?>">
                                                    <?= htmlspecialchars($cohort['name']) ?> 
                                                    (<?= $cohort['current_students'] ?>/<?= $cohort['max_students'] ?>)
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <button type="button" onclick="approveApplication()"
                                            class="w-full px-4 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium">
                                        <i class="fas fa-check-circle mr-2"></i>Approve & Enroll
                                    </button>
                                </div>
                            </div>

                            <!-- Reject Section -->
                            <div class="mb-6 pb-6 border-b">
                                <h3 class="font-semibold text-gray-900 mb-3 text-red-700">
                                    <i class="fas fa-times mr-2"></i>Reject Application
                                </h3>
                                
                                <div class="space-y-3">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                            Rejection Reason *
                                        </label>
                                        <textarea name="rejection_reason" id="rejectionReason"
                                                  rows="3" placeholder="Explain why the application is being rejected..."
                                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 text-sm"></textarea>
                                    </div>

                                    <button type="button" onclick="rejectApplication()"
                                            class="w-full px-4 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-medium">
                                        <i class="fas fa-times-circle mr-2"></i>Reject Application
                                    </button>
                                </div>
                            </div>

                            <!-- Waitlist Section -->
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-3 text-purple-700">
                                    <i class="fas fa-list mr-2"></i>Other Actions
                                </h3>
                                
                                <button type="button" onclick="waitlistApplication()"
                                        class="w-full px-4 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition font-medium">
                                    <i class="fas fa-clock mr-2"></i>Move to Waitlist
                                </button>
                            </div>
                        </form>
                    <?php endif; ?>

                    <!-- Internal Notes -->
                    <div class="pt-6 border-t">
                        <h3 class="font-semibold text-gray-900 mb-3">
                            <i class="fas fa-sticky-note text-yellow-600 mr-2"></i>Internal Notes
                        </h3>
                        <textarea id="internalNotes" rows="4" placeholder="Add notes for internal use..."
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 text-sm"><?= htmlspecialchars($application['review_notes'] ?? '') ?></textarea>
                        <button onclick="saveNotes()" 
                                class="mt-2 w-full px-3 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition text-sm">
                            <i class="fas fa-save mr-2"></i>Save Notes
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        async function approveApplication() {
            const cohortId = document.getElementById('cohortSelect').value;
            
            if (!cohortId) {
                alert('Please select a cohort to assign the student to.');
                return;
            }

            if (!confirm('Are you sure you want to approve this application? The student will be enrolled and notified via email.')) {
                return;
            }

            try {
                const response = await fetch('<?= url('/admin/applications/approve') ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        application_id: <?= $application['id'] ?>,
                        cohort_id: cohortId
                    })
                });

                const data = await response.json();
                if (data.success) {
                    alert('Application approved successfully! The student has been enrolled.');
                    window.location.href = '<?= url('/admin/applications') ?>';
                } else {
                    alert('Error: ' + (data.message || 'Failed to approve application'));
                }
            } catch (error) {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            }
        }

        async function rejectApplication() {
            const reason = document.getElementById('rejectionReason').value.trim();
            
            if (!reason) {
                alert('Please provide a rejection reason.');
                return;
            }

            if (!confirm('Are you sure you want to reject this application? The applicant will be notified via email.')) {
                return;
            }

            try {
                const response = await fetch('<?= url('/admin/applications/reject') ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        application_id: <?= $application['id'] ?>,
                        reason: reason
                    })
                });

                const data = await response.json();
                if (data.success) {
                    alert('Application rejected. The applicant has been notified.');
                    window.location.href = '<?= url('/admin/applications') ?>';
                } else {
                    alert('Error: ' + (data.message || 'Failed to reject application'));
                }
            } catch (error) {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            }
        }

        async function waitlistApplication() {
            if (!confirm('Move this application to the waitlist?')) {
                return;
            }

            try {
                const response = await fetch('<?= url('/admin/applications/waitlist') ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        application_id: <?= $application['id'] ?>
                    })
                });

                const data = await response.json();
                if (data.success) {
                    alert('Application moved to waitlist.');
                    window.location.reload();
                } else {
                    alert('Error: ' + (data.message || 'Failed to update application'));
                }
            } catch (error) {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            }
        }

        async function saveNotes() {
            const notes = document.getElementById('internalNotes').value;
            const applicationId = '<?= $application['uuid'] ?>';
            
            try {
                const response = await fetch('/admin/applications/notes', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        application_id: applicationId,
                        notes: notes
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    alert('Notes saved successfully!');
                } else {
                    alert('Error: ' + (data.message || 'Failed to save notes'));
                }
            } catch (error) {
                console.error('Error:', error);
                alert('An error occurred while saving notes.');
            }
        }
    </script>

    <?php include __DIR__ . '/../../partials/footer.php'; ?>
</body>
</html>

