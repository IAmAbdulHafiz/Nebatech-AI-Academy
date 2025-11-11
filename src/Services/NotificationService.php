<?php

namespace Nebatech\Services;

use Nebatech\Models\Notification;

class NotificationService
{
    /**
     * Send application received notification
     */
    public function notifyApplicationReceived(int $userId, array $application): bool
    {
        return $this->createNotification([
            'user_id' => $userId,
            'type' => 'application_received',
            'title' => 'Application Received',
            'message' => "Your application for {$application['program']} has been received and is under review.",
            'data' => json_encode(['application_id' => $application['id']]),
            'action_url' => "/application/{$application['uuid']}"
        ]);
    }

    /**
     * Send application approved notification
     */
    public function notifyApplicationApproved(int $userId, array $application, ?array $course = null): bool
    {
        $message = "Congratulations! Your application for {$application['program']} has been approved.";
        if ($course) {
            $message .= " You've been enrolled in {$course['title']}.";
        }

        return $this->createNotification([
            'user_id' => $userId,
            'type' => 'application_approved',
            'title' => 'Application Approved',
            'message' => $message,
            'data' => json_encode([
                'application_id' => $application['id'],
                'course_id' => $course['id'] ?? null
            ]),
            'action_url' => '/dashboard'
        ]);
    }

    /**
     * Send application rejected notification
     */
    public function notifyApplicationRejected(int $userId, array $application, string $reason = ''): bool
    {
        $message = "Your application for {$application['program']} has been reviewed.";
        if ($reason) {
            $message .= " Reason: {$reason}";
        }

        return $this->createNotification([
            'user_id' => $userId,
            'type' => 'application_rejected',
            'title' => 'Application Status Update',
            'message' => $message,
            'data' => json_encode(['application_id' => $application['id']]),
            'action_url' => "/application/{$application['uuid']}"
        ]);
    }

    /**
     * Send info requested notification
     */
    public function notifyInfoRequested(int $userId, array $application, string $requestedInfo): bool
    {
        return $this->createNotification([
            'user_id' => $userId,
            'type' => 'info_requested',
            'title' => 'Additional Information Required',
            'message' => "We need more information about your application. {$requestedInfo}",
            'data' => json_encode(['application_id' => $application['id']]),
            'action_url' => "/application/{$application['uuid']}/update"
        ]);
    }

    /**
     * Send enrollment created notification
     */
    public function notifyEnrollmentCreated(int $userId, array $course): bool
    {
        return $this->createNotification([
            'user_id' => $userId,
            'type' => 'enrollment_created',
            'title' => 'Enrolled in Course',
            'message' => "You've been enrolled in {$course['title']}. Start learning now!",
            'data' => json_encode(['course_id' => $course['id']]),
            'action_url' => "/courses/{$course['slug']}"
        ]);
    }

    /**
     * Send cohort assignment notification
     */
    public function notifyCohortAssigned(int $userId, array $cohort, array $facilitator): bool
    {
        return $this->createNotification([
            'user_id' => $userId,
            'type' => 'cohort_assigned',
            'title' => 'Assigned to Cohort',
            'message' => "You've been assigned to {$cohort['name']}. Your facilitator is {$facilitator['first_name']} {$facilitator['last_name']}.",
            'data' => json_encode([
                'cohort_id' => $cohort['id'],
                'facilitator_id' => $facilitator['id']
            ]),
            'action_url' => '/dashboard'
        ]);
    }

    /**
     * Send cohort approved notification (for facilitators)
     */
    public function notifyCohortApproved(int $facilitatorId, array $cohort): bool
    {
        return $this->createNotification([
            'user_id' => $facilitatorId,
            'type' => 'cohort_approved',
            'title' => 'Cohort Approved',
            'message' => "Your cohort '{$cohort['name']}' has been approved by the admin.",
            'data' => json_encode(['cohort_id' => $cohort['id']]),
            'action_url' => '/facilitator/cohorts'
        ]);
    }

    /**
     * Send cohort rejected notification (for facilitators)
     */
    public function notifyCohortRejected(int $facilitatorId, array $cohort, string $reason = ''): bool
    {
        $message = "Your cohort '{$cohort['name']}' has been reviewed.";
        if ($reason) {
            $message .= " Reason: {$reason}";
        }

        return $this->createNotification([
            'user_id' => $facilitatorId,
            'type' => 'cohort_rejected',
            'title' => 'Cohort Status Update',
            'message' => $message,
            'data' => json_encode(['cohort_id' => $cohort['id']]),
            'action_url' => '/facilitator/cohorts'
        ]);
    }

    /**
     * Send assignment graded notification
     */
    public function notifyAssignmentGraded(int $userId, array $submission, array $assignment): bool
    {
        $score = $submission['facilitator_score'] ?? $submission['ai_score'] ?? 0;
        
        return $this->createNotification([
            'user_id' => $userId,
            'type' => 'assignment_graded',
            'title' => 'Assignment Graded',
            'message' => "Your submission for '{$assignment['title']}' has been graded. Score: {$score}%",
            'data' => json_encode([
                'submission_id' => $submission['id'],
                'assignment_id' => $assignment['id'],
                'score' => $score
            ]),
            'action_url' => "/submission/{$submission['uuid']}"
        ]);
    }

    /**
     * Send course published notification (for students enrolled)
     */
    public function notifyCoursePublished(int $userId, array $course): bool
    {
        return $this->createNotification([
            'user_id' => $userId,
            'type' => 'course_published',
            'title' => 'New Course Available',
            'message' => "A new course '{$course['title']}' is now available!",
            'data' => json_encode(['course_id' => $course['id']]),
            'action_url' => "/courses/{$course['slug']}"
        ]);
    }

    /**
     * Send certificate issued notification
     */
    public function notifyCertificateIssued(int $userId, array $certificate, array $course): bool
    {
        return $this->createNotification([
            'user_id' => $userId,
            'type' => 'certificate_issued',
            'title' => 'Certificate Issued',
            'message' => "Congratulations! Your certificate for '{$course['title']}' is ready.",
            'data' => json_encode([
                'certificate_id' => $certificate['id'],
                'course_id' => $course['id']
            ]),
            'action_url' => "/certificate/{$certificate['uuid']}"
        ]);
    }

    /**
     * Send submission received notification (for facilitators)
     */
    public function notifySubmissionReceived(int $facilitatorId, array $submission, array $assignment, array $student): bool
    {
        return $this->createNotification([
            'user_id' => $facilitatorId,
            'type' => 'submission_received',
            'title' => 'New Submission',
            'message' => "{$student['first_name']} {$student['last_name']} submitted '{$assignment['title']}'.",
            'data' => json_encode([
                'submission_id' => $submission['id'],
                'assignment_id' => $assignment['id'],
                'student_id' => $student['id']
            ]),
            'action_url' => "/facilitator/submissions/{$submission['id']}"
        ]);
    }

    /**
     * Send lesson completed notification
     */
    public function notifyLessonCompleted(int $userId, array $lesson, array $course): bool
    {
        return $this->createNotification([
            'user_id' => $userId,
            'type' => 'lesson_completed',
            'title' => 'Lesson Completed',
            'message' => "Great job! You completed '{$lesson['title']}' in {$course['title']}.",
            'data' => json_encode([
                'lesson_id' => $lesson['id'],
                'course_id' => $course['id']
            ]),
            'action_url' => "/courses/{$course['slug']}"
        ]);
    }

    /**
     * Send course completed notification
     */
    public function notifyCourseCompleted(int $userId, array $course): bool
    {
        return $this->createNotification([
            'user_id' => $userId,
            'type' => 'course_completed',
            'title' => 'Course Completed',
            'message' => "Congratulations! You've completed '{$course['title']}'. Your certificate is being prepared.",
            'data' => json_encode(['course_id' => $course['id']]),
            'action_url' => "/my-certificates"
        ]);
    }

    /**
     * Send system notification
     */
    public function notifySystem(int $userId, string $title, string $message, ?string $actionUrl = null): bool
    {
        return $this->createNotification([
            'user_id' => $userId,
            'type' => 'system',
            'title' => $title,
            'message' => $message,
            'action_url' => $actionUrl
        ]);
    }

    /**
     * Send announcement to multiple users
     */
    public function notifyAnnouncement(array $userIds, string $title, string $message, ?string $actionUrl = null): int
    {
        $count = 0;
        foreach ($userIds as $userId) {
            if ($this->createNotification([
                'user_id' => $userId,
                'type' => 'announcement',
                'title' => $title,
                'message' => $message,
                'action_url' => $actionUrl
            ])) {
                $count++;
            }
        }
        return $count;
    }

    /**
     * Create a notification
     */
    private function createNotification(array $data): bool
    {
        try {
            $id = Notification::create($data);
            return $id > 0;
        } catch (\Exception $e) {
            error_log("Failed to create notification: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get user notifications
     */
    public function getUserNotifications(int $userId, array $options = []): array
    {
        return Notification::getByUser($userId, $options);
    }

    /**
     * Get unread count
     */
    public function getUnreadCount(int $userId): int
    {
        return Notification::getUnreadCount($userId);
    }

    /**
     * Mark as read
     */
    public function markAsRead(int $notificationId): bool
    {
        return Notification::markAsRead($notificationId);
    }

    /**
     * Mark all as read
     */
    public function markAllAsRead(int $userId): bool
    {
        return Notification::markAllAsRead($userId);
    }

    /**
     * Delete notification
     */
    public function deleteNotification(int $notificationId): bool
    {
        return Notification::delete($notificationId);
    }

    /**
     * Delete all notifications for a user
     */
    public function deleteAllNotifications(int $userId): bool
    {
        return Notification::deleteAllForUser($userId);
    }
}
