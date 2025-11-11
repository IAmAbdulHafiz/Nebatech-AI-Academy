<?php

namespace Nebatech\Models;

use Nebatech\Core\Model;
use Nebatech\Core\Database;
use Nebatech\Models\Notification;

class Cohort extends Model
{
    protected string $table = 'cohorts';
    protected string $primaryKey = 'id';

    /**
     * Create a new cohort
     */
    public static function create(array $data): ?int
    {
        try {
            // Generate UUID if not provided
            if (!isset($data['uuid'])) {
                $data['uuid'] = self::generateUUID();
            }
            
            return Database::insert('cohorts', $data);
        } catch (\Exception $e) {
            error_log("Cohort creation failed: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Get all cohorts with optional filters
     */
    public static function getAll(array $filters = []): array
    {
        $sql = "SELECT c.*, 
                       u.first_name as facilitator_first_name,
                       u.last_name as facilitator_last_name,
                       (SELECT COUNT(*) FROM cohort_assignments WHERE cohort_id = c.id) as student_count
                FROM " . 'cohorts' . " c
                LEFT JOIN users u ON c.facilitator_id = u.id
                WHERE 1=1";
        
        $params = [];

        if (!empty($filters['status'])) {
            $sql .= " AND c.status = :status";
            $params['status'] = $filters['status'];
        }

        if (!empty($filters['program'])) {
            $sql .= " AND c.program = :program";
            $params['program'] = $filters['program'];
        }

        if (!empty($filters['facilitator_id'])) {
            $sql .= " AND c.facilitator_id = :facilitator_id";
            $params['facilitator_id'] = $filters['facilitator_id'];
        }

        if (!empty($filters['approval_status'])) {
            $sql .= " AND c.approval_status = :approval_status";
            $params['approval_status'] = $filters['approval_status'];
        }

        $sql .= " ORDER BY c.start_date DESC";

        return Database::fetchAll($sql, $params);
    }

    /**
     * Get cohort by ID
     */
    public static function findById(int $id): ?array
    {
        $sql = "SELECT c.*, 
                       u.first_name as facilitator_first_name,
                       u.last_name as facilitator_last_name,
                       (SELECT COUNT(*) FROM cohort_assignments WHERE cohort_id = c.id) as student_count
                FROM " . 'cohorts' . " c
                LEFT JOIN users u ON c.facilitator_id = u.id
                WHERE c.id = :id
                LIMIT 1";
        
        return Database::fetch($sql, ['id' => $id]);
    }

    /**
     * Update cohort
     */
    public static function updateById(int $id, array $data): bool
    {
        unset($data['id'], $data['created_at']);

        if (empty($data)) {
            return false;
        }

        $result = Database::update('cohorts', $data, 'id = :id', ['id' => $id]);
        return $result > 0;
    }

    /**
     * Delete cohort
     */
    public static function deleteById(int $id): bool
    {
        $result = Database::delete('cohorts', 'id = :id', ['id' => $id]);
        return $result > 0;
    }

    /**
     * Assign student to cohort
     */
    public static function assignStudent(int $cohortId, int $userId): bool
    {
        // Check if cohort is full
        $cohort = self::findById($cohortId);
        if (!$cohort) {
            return false;
        }

        if ($cohort['student_count'] >= $cohort['max_students']) {
            return false;
        }

        // Check if already assigned
        if (self::isStudentAssigned($cohortId, $userId)) {
            return true;
        }

        try {
            $assignmentId = Database::insert('cohort_assignments', [
                'user_id' => $userId,
                'cohort_id' => $cohortId
            ]);

            return $assignmentId !== null;
        } catch (\Exception $e) {
            error_log("Cohort assignment failed: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Remove student from cohort
     */
    public static function removeStudent(int $cohortId, int $userId): bool
    {
        $result = Database::delete(
            'cohort_assignments',
            'cohort_id = :cohort_id AND user_id = :user_id',
            ['cohort_id' => $cohortId, 'user_id' => $userId]
        );

        return $result > 0;
    }

    /**
     * Check if student is assigned to cohort
     */
    public static function isStudentAssigned(int $cohortId, int $userId): bool
    {
        $sql = "SELECT COUNT(*) as count FROM cohort_assignments 
                WHERE cohort_id = :cohort_id AND user_id = :user_id";
        
        $result = Database::fetch($sql, [
            'cohort_id' => $cohortId,
            'user_id' => $userId
        ]);

        return $result && $result['count'] > 0;
    }

    /**
     * Get students in cohort
     */
    public static function getStudents(int $cohortId): array
    {
        $sql = "SELECT u.*, ca.assigned_at
                FROM cohort_assignments ca
                INNER JOIN users u ON ca.user_id = u.id
                WHERE ca.cohort_id = :cohort_id
                ORDER BY ca.assigned_at DESC";

        return Database::fetchAll($sql, ['cohort_id' => $cohortId]);
    }

    /**
     * Get user's cohorts
     */
    public static function getUserCohorts(int $userId): array
    {
        $sql = "SELECT c.*, 
                       u.first_name as facilitator_first_name,
                       u.last_name as facilitator_last_name,
                       ca.assigned_at
                FROM cohort_assignments ca
                INNER JOIN cohorts c ON ca.cohort_id = c.id
                LEFT JOIN users u ON c.facilitator_id = u.id
                WHERE ca.user_id = :user_id
                ORDER BY c.start_date DESC";

        return Database::fetchAll($sql, ['user_id' => $userId]);
    }

    /**
     * Get active cohorts
     */
    public static function getActiveCohorts(): array
    {
        return self::getAll(['status' => 'active']);
    }

    /**
     * Update cohort status
     */
    public static function updateStatus(int $id, string $status): bool
    {
        if (!in_array($status, ['upcoming', 'active', 'completed'])) {
            return false;
        }

        return self::updateById($id, ['status' => $status]);
    }

    /**
     * Add course to cohort
     */
    public static function addCourse(int $cohortId, int $courseId, ?string $startDate = null, ?string $endDate = null, int $orderIndex = 0): bool
    {
        // Check if already added
        if (self::hasCourse($cohortId, $courseId)) {
            return true;
        }

        try {
            $data = [
                'cohort_id' => $cohortId,
                'course_id' => $courseId,
                'order_index' => $orderIndex
            ];

            if ($startDate) {
                $data['start_date'] = $startDate;
            }
            if ($endDate) {
                $data['end_date'] = $endDate;
            }

            $id = Database::insert('cohort_courses', $data);
            return $id !== null;
        } catch (\Exception $e) {
            error_log("Failed to add course to cohort: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Remove course from cohort
     */
    public static function removeCourse(int $cohortId, int $courseId): bool
    {
        $result = Database::delete(
            'cohort_courses',
            'cohort_id = :cohort_id AND course_id = :course_id',
            ['cohort_id' => $cohortId, 'course_id' => $courseId]
        );

        return $result > 0;
    }

    /**
     * Check if cohort has a specific course
     */
    public static function hasCourse(int $cohortId, int $courseId): bool
    {
        $sql = "SELECT COUNT(*) as count FROM cohort_courses 
                WHERE cohort_id = :cohort_id AND course_id = :course_id";
        
        $result = Database::fetch($sql, [
            'cohort_id' => $cohortId,
            'course_id' => $courseId
        ]);

        return $result && $result['count'] > 0;
    }

    /**
     * Get all courses in a cohort
     */
    public static function getCourses(int $cohortId): array
    {
        $sql = "SELECT c.*, cc.start_date as cohort_start_date, 
                       cc.end_date as cohort_end_date, cc.order_index,
                       u.first_name as facilitator_first_name,
                       u.last_name as facilitator_last_name
                FROM cohort_courses cc
                INNER JOIN courses c ON cc.course_id = c.id
                LEFT JOIN users u ON c.facilitator_id = u.id
                WHERE cc.cohort_id = :cohort_id
                ORDER BY cc.order_index ASC, cc.start_date ASC";

        return Database::fetchAll($sql, ['cohort_id' => $cohortId]);
    }

    /**
     * Enroll student in all cohort courses
     */
    public static function enrollStudentInCourses(int $cohortId, int $userId): array
    {
        $courses = self::getCourses($cohortId);
        $results = [
            'success' => [],
            'failed' => [],
            'already_enrolled' => []
        ];

        foreach ($courses as $course) {
            // Check if already enrolled
            $existingEnrollment = Database::fetch(
                "SELECT id FROM enrollments WHERE user_id = :user_id AND course_id = :course_id",
                ['user_id' => $userId, 'course_id' => $course['id']]
            );

            if ($existingEnrollment) {
                // Update to link with cohort if not already linked
                Database::update(
                    'enrollments',
                    ['cohort_id' => $cohortId],
                    'id = :id',
                    ['id' => $existingEnrollment['id']]
                );
                $results['already_enrolled'][] = $course['id'];
            } else {
                // Create new enrollment with cohort link
                try {
                    $enrollmentId = Database::insert('enrollments', [
                        'user_id' => $userId,
                        'course_id' => $course['id'],
                        'cohort_id' => $cohortId,
                        'status' => 'active'
                    ]);

                    if ($enrollmentId) {
                        $results['success'][] = $course['id'];
                    } else {
                        $results['failed'][] = $course['id'];
                    }
                } catch (\Exception $e) {
                    error_log("Enrollment failed for course {$course['id']}: " . $e->getMessage());
                    $results['failed'][] = $course['id'];
                }
            }
        }

        return $results;
    }

    /**
     * Get cohort schedule/events
     */
    public static function getSchedule(int $cohortId, ?array $filters = []): array
    {
        $sql = "SELECT cs.*, 
                       c.title as course_title,
                       l.title as lesson_title
                FROM cohort_schedules cs
                LEFT JOIN courses c ON cs.course_id = c.id
                LEFT JOIN lessons l ON cs.lesson_id = l.id
                WHERE cs.cohort_id = :cohort_id";
        
        $params = ['cohort_id' => $cohortId];

        if (!empty($filters['status'])) {
            $sql .= " AND cs.status = :status";
            $params['status'] = $filters['status'];
        }

        if (!empty($filters['event_type'])) {
            $sql .= " AND cs.event_type = :event_type";
            $params['event_type'] = $filters['event_type'];
        }

        if (!empty($filters['from_date'])) {
            $sql .= " AND cs.scheduled_at >= :from_date";
            $params['from_date'] = $filters['from_date'];
        }

        if (!empty($filters['to_date'])) {
            $sql .= " AND cs.scheduled_at <= :to_date";
            $params['to_date'] = $filters['to_date'];
        }

        $sql .= " ORDER BY cs.scheduled_at ASC";

        return Database::fetchAll($sql, $params);
    }

    /**
     * Create schedule event for cohort
     */
    public static function createScheduleEvent(array $data): ?int
    {
        if (!isset($data['uuid'])) {
            $data['uuid'] = self::generateUUID();
        }

        try {
            return Database::insert('cohort_schedules', $data);
        } catch (\Exception $e) {
            error_log("Failed to create schedule event: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Get cohort statistics
     */
    public static function getStats(int $cohortId): array
    {
        $sql = "SELECT 
                    (SELECT COUNT(*) FROM cohort_assignments WHERE cohort_id = :cohort_id) as total_students,
                    (SELECT COUNT(*) FROM cohort_courses WHERE cohort_id = :cohort_id) as total_courses,
                    (SELECT COUNT(*) FROM cohort_schedules WHERE cohort_id = :cohort_id AND status = 'scheduled') as upcoming_events,
                    (SELECT COUNT(*) FROM cohort_schedules WHERE cohort_id = :cohort_id AND status = 'completed') as completed_events";
        
        return Database::fetch($sql, ['cohort_id' => $cohortId]) ?? [
            'total_students' => 0,
            'total_courses' => 0,
            'upcoming_events' => 0,
            'completed_events' => 0
        ];
    }

    /**
     * Submit cohort for approval
     */
    public static function submitForApproval(int $cohortId): bool
    {
        $result = self::updateById($cohortId, [
            'approval_status' => 'pending_approval'
        ]);

        if ($result) {
            // Log approval history
            Database::insert('approval_history', [
                'entity_type' => 'cohort',
                'entity_id' => $cohortId,
                'action' => 'submitted'
            ]);

            // Notify admins
            self::notifyAdminsOfPendingCohort($cohortId);
        }

        return $result;
    }

    /**
     * Approve cohort
     */
    public static function approve(int $cohortId, int $adminId, ?string $reason = null): bool
    {
        $result = self::updateById($cohortId, [
            'approval_status' => 'approved',
            'approved_by' => $adminId,
            'approved_at' => date('Y-m-d H:i:s')
        ]);

        if ($result) {
            // Log approval history
            Database::insert('approval_history', [
                'entity_type' => 'cohort',
                'entity_id' => $cohortId,
                'action' => 'approved',
                'admin_id' => $adminId,
                'reason' => $reason
            ]);

            // Notify facilitator
            $cohort = self::findById($cohortId);
            if ($cohort && $cohort['facilitator_id']) {
                Notification::create([
                    'user_id' => $cohort['facilitator_id'],
                    'type' => 'cohort_approved',
                    'title' => 'Cohort Approved',
                    'message' => "Your cohort '{$cohort['name']}' has been approved!",
                    'action_url' => '/facilitator/cohorts/' . $cohortId
                ]);
            }
        }

        return $result;
    }

    /**
     * Reject cohort
     */
    public static function reject(int $cohortId, int $adminId, string $reason): bool
    {
        $result = self::updateById($cohortId, [
            'approval_status' => 'rejected',
            'rejection_reason' => $reason
        ]);

        if ($result) {
            // Log approval history
            Database::insert('approval_history', [
                'entity_type' => 'cohort',
                'entity_id' => $cohortId,
                'action' => 'rejected',
                'admin_id' => $adminId,
                'reason' => $reason
            ]);

            // Notify facilitator
            $cohort = self::findById($cohortId);
            if ($cohort && $cohort['facilitator_id']) {
                Notification::create([
                    'user_id' => $cohort['facilitator_id'],
                    'type' => 'cohort_rejected',
                    'title' => 'Cohort Needs Revision',
                    'message' => "Your cohort '{$cohort['name']}' needs revision: {$reason}",
                    'action_url' => '/facilitator/cohorts/' . $cohortId
                ]);
            }
        }

        return $result;
    }

    /**
     * Get pending cohorts for approval
     */
    public static function getPendingApprovals(): array
    {
        $sql = "SELECT c.*, 
                       u.first_name as facilitator_first_name,
                       u.last_name as facilitator_last_name,
                       u.email as facilitator_email,
                       (SELECT COUNT(*) FROM cohort_courses WHERE cohort_id = c.id) as course_count
                FROM cohorts c
                LEFT JOIN users u ON c.facilitator_id = u.id
                WHERE c.approval_status = 'pending_approval'
                ORDER BY c.created_at ASC";
        
        return Database::fetchAll($sql);
    }

    /**
     * Notify admins of pending cohort
     */
    protected static function notifyAdminsOfPendingCohort(int $cohortId): void
    {
        $cohort = self::findById($cohortId);
        if (!$cohort) return;

        // Get all admins
        $admins = Database::fetchAll("SELECT id FROM users WHERE role = 'admin'");
        
        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin['id'],
                'type' => 'cohort_pending_approval',
                'title' => 'New Cohort Pending Approval',
                'message' => "Cohort '{$cohort['name']}' by {$cohort['facilitator_first_name']} {$cohort['facilitator_last_name']} needs approval",
                'action_url' => '/admin/approvals/cohorts'
            ]);
        }
    }

    /**
     * Generate UUID v4
     */
    protected static function generateUUID(): string
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff)
        );
    }
}
