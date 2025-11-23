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
 * Invite students to cohort (placeholder)
 */
function inviteStudents(cohortId) {
    // TODO: Implement student invitation modal
    alert('Student invitation feature coming soon!\n\nFor now, students can be assigned by admins.');
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
