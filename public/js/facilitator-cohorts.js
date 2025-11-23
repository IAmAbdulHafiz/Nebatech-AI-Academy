/**
 * Facilitator Cohort Management JavaScript
 * Shared functions for cohort approval workflow
 */

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
 * Submit cohort for approval
 */
function submitForApproval(cohortId, cohortName) {
    if (!confirm(`Submit "${cohortName}" for admin approval?\n\nMake sure you've added all necessary courses before submitting.`)) {
        return;
    }

    // Show loading state
    const originalButtons = document.querySelectorAll(`button[onclick*="submitForApproval(${cohortId}"]`);
    originalButtons.forEach(btn => {
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Submitting...';
    });

    const csrfToken = getCsrfToken();
    const formData = new URLSearchParams({
        cohort_id: cohortId,
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
            alert('✅ Cohort submitted for approval!\n\nYou will be notified once an admin reviews it.');
            location.reload();
        } else {
            alert('❌ ' + (data.error || 'Failed to submit cohort'));
            // Restore buttons
            originalButtons.forEach(btn => {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-paper-plane mr-2"></i>Submit';
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred. Please try again.');
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
 * Add course to cohort
 */
function addCourseToCohort(cohortId) {
    // TODO: Implement add course modal
    alert('Add course feature - to be implemented with modal');
}

/**
 * Remove course from cohort
 */
function removeCourseFromCohort(cohortId, courseId, courseName) {
    if (!confirm(`Remove "${courseName}" from this cohort?`)) {
        return;
    }

    fetch('/facilitator/cohorts/remove-course', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            cohort_id: cohortId,
            course_id: courseId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Course removed successfully');
            location.reload();
        } else {
            alert('Error: ' + (data.error || 'Failed to remove course'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred. Please try again.');
    });
}
