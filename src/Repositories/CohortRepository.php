<?php

namespace Nebatech\Repositories;

use Nebatech\Core\Database;

class CohortRepository
{
    /**
     * Find cohort by ID
     */
    public function find(int $id): ?array
    {
        return Database::fetch(
            'SELECT c.*, u.first_name as facilitator_first_name, u.last_name as facilitator_last_name, u.email as facilitator_email,
                    (SELECT COUNT(*) FROM cohort_assignments WHERE cohort_id = c.id) as student_count,
                    (SELECT COUNT(*) FROM cohort_courses WHERE cohort_id = c.id) as course_count
             FROM cohorts c
             LEFT JOIN users u ON c.facilitator_id = u.id
             WHERE c.id = :id',
            ['id' => $id]
        );
    }

    /**
     * Get all cohorts with filters
     */
    public function getAll(array $filters = []): array
    {
        $sql = 'SELECT c.*, u.first_name as facilitator_first_name, u.last_name as facilitator_last_name, u.email as facilitator_email,
                       (SELECT COUNT(*) FROM cohort_assignments WHERE cohort_id = c.id) as student_count,
                       (SELECT COUNT(*) FROM cohort_courses WHERE cohort_id = c.id) as course_count
                FROM cohorts c
                LEFT JOIN users u ON c.facilitator_id = u.id
                WHERE 1=1';
        
        $params = [];

        if (!empty($filters['status'])) {
            $sql .= ' AND c.status = :status';
            $params['status'] = $filters['status'];
        }

        if (!empty($filters['program'])) {
            $sql .= ' AND c.program = :program';
            $params['program'] = $filters['program'];
        }

        if (!empty($filters['facilitator_id'])) {
            $sql .= ' AND c.facilitator_id = :facilitator_id';
            $params['facilitator_id'] = $filters['facilitator_id'];
        }

        if (!empty($filters['approval_status'])) {
            $sql .= ' AND c.approval_status = :approval_status';
            $params['approval_status'] = $filters['approval_status'];
        }
        
        // Exclude draft cohorts (for admin view)
        if (!empty($filters['exclude_draft'])) {
            $sql .= ' AND c.approval_status != \'draft\'';
        }

        $sql .= ' ORDER BY c.start_date DESC';

        return Database::fetchAll($sql, $params);
    }

    /**
     * Get cohorts for a facilitator
     */
    public function getByFacilitator(int $facilitatorId): array
    {
        return $this->getAll(['facilitator_id' => $facilitatorId]);
    }

    /**
     * Get cohorts for a student
     */
    public function getByStudent(int $studentId): array
    {
        return Database::fetchAll(
            'SELECT c.*, u.first_name as facilitator_first_name, u.last_name as facilitator_last_name, u.email as facilitator_email,
                    (SELECT COUNT(*) FROM cohort_assignments WHERE cohort_id = c.id) as student_count,
                    (SELECT COUNT(*) FROM cohort_courses WHERE cohort_id = c.id) as course_count
             FROM cohorts c
             JOIN cohort_assignments cs ON c.id = cs.cohort_id
             LEFT JOIN users u ON c.facilitator_id = u.id
             WHERE cs.user_id = :student_id
             ORDER BY c.start_date DESC',
            ['student_id' => $studentId]
        );
    }

    /**
     * Get students in a cohort
     */
    public function getStudents(int $cohortId): array
    {
        return Database::fetchAll(
            'SELECT u.*, cs.assigned_at as enrolled_at
             FROM users u
             JOIN cohort_assignments cs ON u.id = cs.user_id
             WHERE cs.cohort_id = :cohort_id
             ORDER BY cs.assigned_at DESC',
            ['cohort_id' => $cohortId]
        );
    }

    /**
     * Get courses in a cohort
     */
    public function getCourses(int $cohortId): array
    {
        return Database::fetchAll(
            'SELECT c.*, cc.start_date as cohort_start_date, cc.end_date as cohort_end_date
             FROM courses c
             JOIN cohort_courses cc ON c.id = cc.course_id
             WHERE cc.cohort_id = :cohort_id
             ORDER BY cc.order_index ASC',
            ['cohort_id' => $cohortId]
        );
    }

    /**
     * Create new cohort
     */
    public function create(array $data): int
    {
        if (!isset($data['uuid'])) {
            $data['uuid'] = $this->generateUuid();
        }

        $data['created_at'] = date('Y-m-d H:i:s');
        $data['status'] = $data['status'] ?? 'upcoming';

        return Database::insert('cohorts', $data);
    }

    /**
     * Update cohort
     */
    public function update(int $id, array $data): bool
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        return Database::update('cohorts', $data, 'id = :id', ['id' => $id]) > 0;
    }

    /**
     * Add student to cohort
     */
    public function addStudent(int $cohortId, int $studentId): bool
    {
        try {
            Database::insert('cohort_assignments', [
                'cohort_id' => $cohortId,
                'user_id' => $studentId,
                'assigned_at' => date('Y-m-d H:i:s')
            ]);
            return true;
        } catch (\Exception $e) {
            error_log('Failed to add student to cohort: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Remove student from cohort
     */
    public function removeStudent(int $cohortId, int $studentId): bool
    {
        return Database::delete(
            'cohort_assignments',
            'cohort_id = :cohort_id AND user_id = :user_id',
            ['cohort_id' => $cohortId, 'user_id' => $studentId]
        ) > 0;
    }

    /**
     * Add course to cohort
     */
    public function addCourse(int $cohortId, int $courseId, array $data = []): bool
    {
        try {
            Database::insert('cohort_courses', [
                'cohort_id' => $cohortId,
                'course_id' => $courseId,
                'start_date' => $data['start_date'] ?? null,
                'end_date' => $data['end_date'] ?? null,
                'order_index' => $data['order_index'] ?? 0
            ]);
            return true;
        } catch (\Exception $e) {
            error_log('Failed to add course to cohort: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Remove course from cohort
     */
    public function removeCourse(int $cohortId, int $courseId): bool
    {
        return Database::delete(
            'cohort_courses',
            'cohort_id = :cohort_id AND course_id = :course_id',
            ['cohort_id' => $cohortId, 'course_id' => $courseId]
        ) > 0;
    }

    /**
     * Delete cohort
     */
    public function delete(int $id): bool
    {
        // Delete related records first
        Database::delete('cohort_assignments', 'cohort_id = :cohort_id', ['cohort_id' => $id]);
        Database::delete('cohort_courses', 'cohort_id = :cohort_id', ['cohort_id' => $id]);
        
        return Database::delete('cohorts', 'id = :id', ['id' => $id]) > 0;
    }

    /**
     * Generate UUID v4
     */
    private function generateUuid(): string
    {
        $data = random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
}
