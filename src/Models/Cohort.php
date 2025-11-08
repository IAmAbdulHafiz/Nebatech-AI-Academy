<?php

namespace Nebatech\Models;

use Nebatech\Core\Database;
use PDO;

class Cohort
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Get all cohorts with program and facilitator info
     */
    public function getAll($filters = [])
    {
        $where = [];
        $params = [];
        
        if (!empty($filters['status'])) {
            $where[] = "co.status = ?";
            $params[] = $filters['status'];
        }
        
        if (!empty($filters['program_id'])) {
            $where[] = "co.program_id = ?";
            $params[] = $filters['program_id'];
        }
        
        $whereClause = !empty($where) ? 'WHERE ' . implode(' AND ', $where) : '';
        
        $sql = "SELECT co.*, 
                       c.title as program_name, c.slug as program_slug,
                       u.first_name as facilitator_first_name, 
                       u.last_name as facilitator_last_name
                FROM cohorts co
                JOIN courses c ON co.program_id = c.id
                LEFT JOIN users u ON co.lead_facilitator = u.id
                $whereClause
                ORDER BY co.start_date DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get cohort by ID
     */
    public function findById($id)
    {
        $sql = "SELECT co.*, 
                       c.title as program_name, c.slug as program_slug, c.description as program_description,
                       u.first_name as facilitator_first_name, 
                       u.last_name as facilitator_last_name,
                       u.email as facilitator_email
                FROM cohorts co
                JOIN courses c ON co.program_id = c.id
                LEFT JOIN users u ON co.lead_facilitator = u.id
                WHERE co.id = ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        
        $cohort = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($cohort && $cohort['assistant_facilitators']) {
            $cohort['assistant_facilitators'] = json_decode($cohort['assistant_facilitators'], true);
        }
        
        return $cohort;
    }

    /**
     * Get available cohorts for a program (open for enrollment)
     */
    public function getAvailableForProgram($programId)
    {
        $sql = "SELECT co.*, 
                       (co.max_students - co.current_students) as available_seats
                FROM cohorts co
                WHERE co.program_id = ? 
                  AND co.status IN ('upcoming', 'active')
                  AND co.current_students < co.max_students
                  AND (co.enrollment_deadline IS NULL OR co.enrollment_deadline >= CURDATE())
                ORDER BY co.start_date ASC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$programId]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get cohort members
     */
    public function getMembers($cohortId)
    {
        $sql = "SELECT ca.*, 
                       u.first_name, u.last_name, u.email, u.avatar,
                       u.created_at as member_since
                FROM cohort_assignments ca
                JOIN users u ON ca.user_id = u.id
                WHERE ca.cohort_id = ? AND ca.status = 'active'
                ORDER BY ca.assigned_at DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$cohortId]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get user's cohorts
     */
    public function getUserCohorts($userId)
    {
        $sql = "SELECT co.*, ca.status as assignment_status, ca.completion_percentage,
                       c.title as program_name,
                       u.first_name as facilitator_first_name, 
                       u.last_name as facilitator_last_name
                FROM cohort_assignments ca
                JOIN cohorts co ON ca.cohort_id = co.id
                JOIN courses c ON co.program_id = c.id
                LEFT JOIN users u ON co.lead_facilitator = u.id
                WHERE ca.user_id = ?
                ORDER BY co.start_date DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Create new cohort
     */
    public function create($data)
    {
        $sql = "INSERT INTO cohorts (
                    name, code, program_id, start_date, end_date, 
                    enrollment_deadline, max_students, lead_facilitator, 
                    assistant_facilitators, status, description, schedule
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            $data['name'],
            $data['code'],
            $data['program_id'],
            $data['start_date'],
            $data['end_date'] ?? null,
            $data['enrollment_deadline'] ?? null,
            $data['max_students'] ?? 30,
            $data['lead_facilitator'] ?? null,
            isset($data['assistant_facilitators']) ? json_encode($data['assistant_facilitators']) : null,
            $data['status'] ?? 'upcoming',
            $data['description'] ?? null,
            $data['schedule'] ?? null
        ]);
        
        return $this->db->lastInsertId();
    }

    /**
     * Update cohort
     */
    public function update($cohortId, $data)
    {
        $fields = [];
        $params = [];
        
        $allowedFields = [
            'name', 'code', 'start_date', 'end_date', 'enrollment_deadline',
            'max_students', 'lead_facilitator', 'assistant_facilitators',
            'status', 'description', 'schedule'
        ];
        
        foreach ($allowedFields as $field) {
            if (isset($data[$field])) {
                $fields[] = "$field = ?";
                if ($field === 'assistant_facilitators' && is_array($data[$field])) {
                    $params[] = json_encode($data[$field]);
                } else {
                    $params[] = $data[$field];
                }
            }
        }
        
        if (empty($fields)) {
            return false;
        }
        
        $params[] = $cohortId;
        $sql = "UPDATE cohorts SET " . implode(', ', $fields) . " WHERE id = ?";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    /**
     * Assign user to cohort
     */
    public function assignUser($cohortId, $userId)
    {
        $sql = "INSERT INTO cohort_assignments (cohort_id, user_id, status, assigned_at)
                VALUES (?, ?, 'active', NOW())
                ON DUPLICATE KEY UPDATE status = 'active'";
        
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([$cohortId, $userId]);
        
        // Update cohort count
        $this->updateStudentCount($cohortId);
        
        return $result;
    }

    /**
     * Remove user from cohort
     */
    public function removeUser($cohortId, $userId)
    {
        $sql = "UPDATE cohort_assignments 
                SET status = 'dropped' 
                WHERE cohort_id = ? AND user_id = ?";
        
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([$cohortId, $userId]);
        
        // Update cohort count
        $this->updateStudentCount($cohortId);
        
        return $result;
    }

    /**
     * Update student count for cohort
     */
    public function updateStudentCount($cohortId)
    {
        $sql = "UPDATE cohorts 
                SET current_students = (
                    SELECT COUNT(*) FROM cohort_assignments 
                    WHERE cohort_id = ? AND status = 'active'
                )
                WHERE id = ?";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$cohortId, $cohortId]);
    }

    /**
     * Check if cohort is full
     */
    public function isFull($cohortId)
    {
        $sql = "SELECT current_students >= max_students as is_full 
                FROM cohorts WHERE id = ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$cohortId]);
        
        return (bool) $stmt->fetchColumn();
    }

    /**
     * Get cohort statistics
     */
    public function getStatistics($cohortId)
    {
        $cohort = $this->findById($cohortId);
        
        $sql = "SELECT 
                    COUNT(*) as total_students,
                    AVG(completion_percentage) as avg_completion,
                    SUM(CASE WHEN status = 'active' THEN 1 ELSE 0 END) as active_students,
                    SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) as completed_students,
                    SUM(CASE WHEN status = 'dropped' THEN 1 ELSE 0 END) as dropped_students
                FROM cohort_assignments
                WHERE cohort_id = ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$cohortId]);
        
        $stats = $stmt->fetch(PDO::FETCH_ASSOC);
        $stats['cohort_info'] = $cohort;
        
        return $stats;
    }

    /**
     * Get upcoming cohorts
     */
    public function getUpcoming($limit = 5)
    {
        $sql = "SELECT co.*, 
                       c.title as program_name,
                       (co.max_students - co.current_students) as available_seats
                FROM cohorts co
                JOIN courses c ON co.program_id = c.id
                WHERE co.status = 'upcoming' 
                  AND co.start_date > CURDATE()
                ORDER BY co.start_date ASC
                LIMIT ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$limit]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Update cohort progress for a user
     */
    public function updateUserProgress($cohortId, $userId, $completionPercentage)
    {
        $sql = "UPDATE cohort_assignments 
                SET completion_percentage = ?,
                    last_activity_at = NOW()
                WHERE cohort_id = ? AND user_id = ?";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$completionPercentage, $cohortId, $userId]);
    }

    /**
     * Get cohort by code
     */
    public function findByCode($code)
    {
        $sql = "SELECT co.*, c.title as program_name
                FROM cohorts co
                JOIN courses c ON co.program_id = c.id
                WHERE co.code = ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$code]);
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Delete cohort (only if no students assigned)
     */
    public function delete($cohortId)
    {
        // Check if cohort has students
        $sql = "SELECT COUNT(*) FROM cohort_assignments WHERE cohort_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$cohortId]);
        
        if ($stmt->fetchColumn() > 0) {
            return false; // Cannot delete cohort with students
        }
        
        $sql = "DELETE FROM cohorts WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$cohortId]);
    }
}
