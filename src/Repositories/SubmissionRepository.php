<?php

namespace Nebatech\Repositories;

use Nebatech\Core\Database;

class SubmissionRepository
{
    /**
     * Find submission by ID
     */
    public function find(int $id): ?array
    {
        return Database::fetch(
            'SELECT s.*, a.title as assignment_title, a.lesson_id,
                    u.first_name, u.last_name, u.email
             FROM submissions s
             JOIN assignments a ON s.assignment_id = a.id
             JOIN users u ON s.user_id = u.id
             WHERE s.id = :id',
            ['id' => $id]
        );
    }

    /**
     * Find submission by user and assignment
     */
    public function findByUserAndAssignment(int $userId, int $assignmentId): ?array
    {
        return Database::fetch(
            'SELECT * FROM submissions 
             WHERE user_id = :user_id AND assignment_id = :assignment_id
             ORDER BY submitted_at DESC LIMIT 1',
            ['user_id' => $userId, 'assignment_id' => $assignmentId]
        );
    }

    /**
     * Get all submissions for a user
     */
    public function getByUser(int $userId, array $filters = []): array
    {
        $sql = 'SELECT s.*, a.title as assignment_title, c.title as course_title
                FROM submissions s
                JOIN assignments a ON s.assignment_id = a.id
                JOIN lessons l ON a.lesson_id = l.id
                JOIN modules m ON l.module_id = m.id
                JOIN courses c ON m.course_id = c.id
                WHERE s.user_id = :user_id';
        
        $params = ['user_id' => $userId];

        if (!empty($filters['status'])) {
            $sql .= ' AND s.status = :status';
            $params['status'] = $filters['status'];
        }

        $sql .= ' ORDER BY s.submitted_at DESC';

        return Database::fetchAll($sql, $params);
    }

    /**
     * Get all submissions for an assignment
     */
    public function getByAssignment(int $assignmentId): array
    {
        return Database::fetchAll(
            'SELECT s.*, u.first_name, u.last_name, u.email
             FROM submissions s
             JOIN users u ON s.user_id = u.id
             WHERE s.assignment_id = :assignment_id
             ORDER BY s.submitted_at DESC',
            ['assignment_id' => $assignmentId]
        );
    }

    /**
     * Get pending submissions for a facilitator
     */
    public function getPendingForFacilitator(int $facilitatorId): array
    {
        return Database::fetchAll(
            'SELECT s.*, a.title as assignment_title, c.title as course_title,
                    u.first_name, u.last_name, u.email
             FROM submissions s
             JOIN assignments a ON s.assignment_id = a.id
             JOIN lessons l ON a.lesson_id = l.id
             JOIN modules m ON l.module_id = m.id
             JOIN courses c ON m.course_id = c.id
             JOIN users u ON s.user_id = u.id
             WHERE c.facilitator_id = :facilitator_id 
             AND s.status = "pending"
             ORDER BY s.submitted_at ASC',
            ['facilitator_id' => $facilitatorId]
        );
    }

    /**
     * Create new submission
     */
    public function create(array $data): int
    {
        $data['submitted_at'] = $data['submitted_at'] ?? date('Y-m-d H:i:s');
        $data['status'] = $data['status'] ?? 'pending';

        return Database::insert('submissions', $data);
    }

    /**
     * Update submission
     */
    public function update(int $id, array $data): bool
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        return Database::update('submissions', $data, 'id = :id', ['id' => $id]) > 0;
    }

    /**
     * Grade submission
     */
    public function grade(int $id, array $gradeData): bool
    {
        $data = [
            'facilitator_score' => $gradeData['score'],
            'facilitator_feedback' => $gradeData['feedback'] ?? null,
            'graded_by' => $gradeData['graded_by'],
            'graded_at' => date('Y-m-d H:i:s'),
            'status' => $gradeData['status'] ?? 'graded',
            'updated_at' => date('Y-m-d H:i:s')
        ];

        return Database::update('submissions', $data, 'id = :id', ['id' => $id]) > 0;
    }

    /**
     * Request revision
     */
    public function requestRevision(int $id, string $feedback, int $gradedBy): bool
    {
        return $this->update($id, [
            'status' => 'revision_needed',
            'facilitator_feedback' => $feedback,
            'graded_by' => $gradedBy,
            'graded_at' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Get submission statistics for a user
     */
    public function getStatistics(int $userId): array
    {
        $stats = Database::fetch(
            'SELECT 
                COUNT(*) as total_submissions,
                SUM(CASE WHEN status = "verified" THEN 1 ELSE 0 END) as verified_count,
                SUM(CASE WHEN status = "pending" THEN 1 ELSE 0 END) as pending_count,
                AVG(facilitator_score) as average_score
             FROM submissions
             WHERE user_id = :user_id',
            ['user_id' => $userId]
        );

        return $stats ?: [
            'total_submissions' => 0,
            'verified_count' => 0,
            'pending_count' => 0,
            'average_score' => 0
        ];
    }

    /**
     * Delete submission
     */
    public function delete(int $id): bool
    {
        return Database::delete('submissions', 'id = :id', ['id' => $id]) > 0;
    }
}
