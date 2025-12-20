/**
 * Facilitator Cohort Management JavaScript
 * Shared functions for cohort approval workflow
 */

// Store cohort data for modal
let currentCohortId = null;
let currentCohortName = null;

/**
 * Get CSRF token from meta tag or session
 */
function getCsrfToken() {
    // Try to get from meta tag first
    const metaTag = document.querySelector('meta[name="csrf-token"]');
    if (metaTag) {
        return metaTag.getAttribute('content');
    }
    
    // Fallback: try to get from hidden input in any form
    const hiddenInput = document.querySelector('input[name="_token"]');
    if (hiddenInput) {
        return hiddenInput.value;
    }
    
    return '';
}

/**
 * Show success notification
 */
function showSuccessNotification(message) {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg z-50 flex items-center gap-3 animate-slide-in';
    notification.innerHTML = `
        <i class="fas fa-check-circle text-2xl"></i>
        <div>
            <p class="font-semibold">Success!</p>
            <p class="text-sm">${message}</p>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Remove after 3 seconds
    setTimeout(() => {
        notification.style.opacity = '0';
        notification.style.transform = 'translateX(100%)';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

/**
 * Show error notification
 */
function showErrorNotification(message) {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = 'fixed top-4 right-4 bg-red-500 text-white px-6 py-4 rounded-lg shadow-lg z-50 flex items-center gap-3 animate-slide-in';
    notification.innerHTML = `
        <i class="fas fa-exclamation-circle text-2xl"></i>
        <div>
            <p class="font-semibold">Error</p>
            <p class="text-sm">${message}</p>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Remove after 4 seconds
    setTimeout(() => {
        notification.style.opacity = '0';
        notification.style.transform = 'translateX(100%)';
        setTimeout(() => notification.remove(), 300);
    }, 4000);
}

/**
 * Open submit approval modal
 */
function submitForApproval(cohortId, cohortName) {
    currentCohortId = cohortId;
    currentCohortName = cohortName;
    
    // Update modal content
    document.getElementById('modalCohortName').textContent = cohortName;
    
    // Show modal
    document.getElementById('submitApprovalModal').classList.remove('hidden');
}

/**
 * Close submit modal
 */
function closeSubmitModal() {
    document.getElementById('submitApprovalModal').classList.add('hidden');
    currentCohortId = null;
    currentCohortName = null;
}

/**
 * Confirm and submit cohort for approval
 */
function confirmSubmitForApproval() {
    if (!currentCohortId) {
        showErrorNotification('Cohort ID is missing. Please try again.');
        return;
    }
    
    // Store cohort ID before closing modal (which sets it to null)
    const cohortIdToSubmit = currentCohortId;
    const cohortNameToSubmit = currentCohortName;
    
    // Close modal
    closeSubmitModal();
    
    // Show loading state on all submit buttons for this cohort
    const originalButtons = document.querySelectorAll(`button[onclick*="submitForApproval(${cohortIdToSubmit}"]`);
    originalButtons.forEach(btn => {
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Submitting...';
    });

    const csrfToken = getCsrfToken();
    const formData = new URLSearchParams({
        cohort_id: cohortIdToSubmit,
        _token: csrfToken
    });

    fetch('/facilitator/cohorts/submit-approval', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showSuccessNotification('Cohort submitted for approval! You will be notified once an admin reviews it.');
            setTimeout(() => location.reload(), 1500);
        } else {
            showErrorNotification(data.error || 'Failed to submit cohort');
            // Restore buttons
            originalButtons.forEach(btn => {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-paper-plane mr-2"></i>Submit';
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showErrorNotification('An error occurred. Please try again.');
        // Restore buttons
        originalButtons.forEach(btn => {
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-paper-plane mr-2"></i>Submit';
        });
    });
}

/**
 * Invite students to cohort
 */
function inviteStudents(cohortId) {
    // Show invitation modal
    showInviteModal(cohortId);
}

/**
 * Show invitation modal and load data
 */
function showInviteModal(cohortId) {
    // Create modal if it doesn't exist
    let modal = document.getElementById('inviteModal');
    if (!modal) {
        modal = document.createElement('div');
        modal.id = 'inviteModal';
        modal.className = 'fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden';
        modal.innerHTML = `
            <div class="bg-white rounded-xl max-w-2xl w-full mx-4 max-h-[90vh] overflow-hidden flex flex-col">
                <div class="p-6 border-b flex justify-between items-center">
                    <h2 class="text-xl font-bold text-gray-900">Invite Students</h2>
                    <button onclick="closeInviteModal()" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                <div class="p-6 overflow-y-auto flex-1" id="inviteModalContent">
                    <div class="text-center py-8">
                        <i class="fas fa-spinner fa-spin text-4xl text-primary"></i>
                        <p class="mt-4 text-gray-600">Loading students...</p>
                    </div>
                </div>
            </div>
        `;
        document.body.appendChild(modal);
    }
    
    modal.classList.remove('hidden');
    
    // Load data
    fetch('/facilitator/cohorts/' + cohortId + '/invite')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                renderInviteForm(cohortId, data.students);
            } else {
                document.getElementById('inviteModalContent').innerHTML = `
                    <div class="text-center py-8 text-red-600">
                        <i class="fas fa-exclamation-circle text-4xl"></i>
                        <p class="mt-4">${data.error || 'Failed to load data'}</p>
                    </div>
                `;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('inviteModalContent').innerHTML = `
                <div class="text-center py-8 text-red-600">
                    <i class="fas fa-exclamation-circle text-4xl"></i>
                    <p class="mt-4">An error occurred. Please try again.</p>
                </div>
            `;
        });
}

/**
 * Render the invitation form
 */
function renderInviteForm(cohortId, students) {
    const content = document.getElementById('inviteModalContent');
    
    content.innerHTML = `
        <div x-data="{ inviteType: 'existing' }">
            <!-- Tab Selection -->
            <div class="flex border-b mb-4">
                <button @click="inviteType = 'existing'" 
                        :class="inviteType === 'existing' ? 'border-primary text-primary' : 'border-transparent text-gray-500'"
                        class="px-4 py-2 font-medium border-b-2 transition">
                    <i class="fas fa-users mr-2"></i>Existing Students
                </button>
                <button @click="inviteType = 'email'" 
                        :class="inviteType === 'email' ? 'border-primary text-primary' : 'border-transparent text-gray-500'"
                        class="px-4 py-2 font-medium border-b-2 transition">
                    <i class="fas fa-envelope mr-2"></i>Invite by Email
                </button>
            </div>
            
            <form id="inviteForm" onsubmit="submitInvitations(event, ${cohortId})">
                <input type="hidden" name="cohort_id" value="${cohortId}">
                <input type="hidden" name="invite_type" x-model="inviteType">
                <input type="hidden" name="_token" value="${getCsrfToken()}">
                
                <!-- Existing Students Tab -->
                <div x-show="inviteType === 'existing'">
                    <p class="text-sm text-gray-600 mb-4">Select students from the list below:</p>
                    <div class="max-h-60 overflow-y-auto border rounded-lg p-2 space-y-2">
                        ${students.length > 0 ? students.map(s => `
                            <label class="flex items-center p-2 hover:bg-gray-50 rounded cursor-pointer">
                                <input type="checkbox" name="student_ids[]" value="${s.id}" class="mr-3 w-4 h-4 text-primary">
                                <span class="flex-1">
                                    <strong>${escapeHtml(s.first_name)} ${escapeHtml(s.last_name)}</strong>
                                    <span class="text-sm text-gray-500 block">${escapeHtml(s.email)}</span>
                                </span>
                            </label>
                        `).join('') : '<p class="text-center text-gray-500 py-4">No students available to invite</p>'}
                    </div>
                    ${students.length > 0 ? `
                        <div class="mt-2 flex justify-between text-sm">
                            <button type="button" onclick="selectAllStudents(true)" class="text-primary hover:underline">Select All</button>
                            <button type="button" onclick="selectAllStudents(false)" class="text-gray-500 hover:underline">Deselect All</button>
                        </div>
                    ` : ''}
                </div>
                
                <!-- Email Invitation Tab -->
                <div x-show="inviteType === 'email'">
                    <p class="text-sm text-gray-600 mb-4">Enter email addresses (one per line or comma-separated):</p>
                    <textarea name="emails" rows="6" 
                              class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-primary focus:border-transparent"
                              placeholder="student1@email.com&#10;student2@email.com&#10;student3@email.com"></textarea>
                    <p class="text-xs text-gray-500 mt-2">
                        <i class="fas fa-info-circle mr-1"></i>
                        New users will receive an invitation to register. Existing users will be invited directly.
                    </p>
                </div>
                
                <!-- Actions -->
                <div class="flex justify-end gap-3 mt-6 pt-4 border-t">
                    <button type="button" onclick="closeInviteModal()" class="px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">
                        Cancel
                    </button>
                    <button type="submit" id="sendInviteBtn" class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-blue-700">
                        <i class="fas fa-paper-plane mr-2"></i>Send Invitations
                    </button>
                </div>
            </form>
        </div>
    `;
}

/**
 * Select/deselect all students
 */
function selectAllStudents(select) {
    document.querySelectorAll('#inviteForm input[name="student_ids[]"]').forEach(cb => {
        cb.checked = select;
    });
}

/**
 * Submit invitations
 */
function submitInvitations(event, cohortId) {
    event.preventDefault();
    
    const form = event.target;
    const btn = document.getElementById('sendInviteBtn');
    const originalText = btn.innerHTML;
    
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Sending...';
    
    const formData = new FormData(form);
    
    fetch('/facilitator/cohorts/invite', {
        method: 'POST',
        body: new URLSearchParams(formData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            closeInviteModal();
            showSuccessNotification(data.message);
            setTimeout(() => location.reload(), 1500);
        } else {
            showErrorNotification(data.error || 'Failed to send invitations');
            if (data.errors && data.errors.length > 0) {
                console.log('Errors:', data.errors);
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showErrorNotification('An error occurred. Please try again.');
    })
    .finally(() => {
        btn.disabled = false;
        btn.innerHTML = originalText;
    });
}

/**
 * Close invite modal
 */
function closeInviteModal() {
    const modal = document.getElementById('inviteModal');
    if (modal) {
        modal.classList.add('hidden');
    }
}

/**
 * Escape HTML helper
 */
function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

/**
 * Open add course modal
 */
function openAddCourseModal() {
    document.getElementById('addCourseModal').classList.remove('hidden');
}

/**
 * Close add course modal
 */
function closeAddCourseModal() {
    document.getElementById('addCourseModal').classList.add('hidden');
    document.getElementById('addCourseForm').reset();
}

/**
 * Submit add course form
 */
function submitAddCourse(event) {
    event.preventDefault();
    
    const form = event.target;
    const formData = new FormData(form);
    
    // Get cohort ID from URL
    const pathParts = window.location.pathname.split('/');
    const cohortId = pathParts[pathParts.length - 1];
    
    const csrfToken = getCsrfToken();
    
    const params = new URLSearchParams({
        cohort_id: cohortId,
        course_id: formData.get('course_id'),
        start_date: formData.get('start_date') || '',
        end_date: formData.get('end_date') || '',
        _token: csrfToken
    });

    // Disable submit button
    const submitBtn = form.querySelector('button[type="submit"]');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Adding...';

    fetch('/facilitator/cohorts/add-course', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: params
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showSuccessNotification('Course added successfully!');
            closeAddCourseModal();
            setTimeout(() => location.reload(), 1000);
        } else {
            showErrorNotification(data.error || 'Failed to add course');
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-plus mr-2"></i>Add Course';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showErrorNotification('An error occurred. Please try again.');
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<i class="fas fa-plus mr-2"></i>Add Course';
    });
}

/**
 * Remove course from cohort
 */
function removeCourseFromCohort(cohortId, courseId, courseName) {
    if (!confirm(`Remove "${courseName}" from this cohort?`)) {
        return;
    }

    const csrfToken = getCsrfToken();

    fetch('/facilitator/cohorts/remove-course', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            cohort_id: cohortId,
            course_id: courseId,
            _token: csrfToken
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showSuccessNotification('Course removed successfully');
            setTimeout(() => location.reload(), 1000);
        } else {
            showErrorNotification(data.error || 'Failed to remove course');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showErrorNotification('An error occurred. Please try again.');
    });
}
