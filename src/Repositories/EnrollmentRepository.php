<?php

namespace Nebatech\Repositories;

use Nebatech\Core\Database;

class EnrollmentRepository
{
    /**
     * Find enrollment by ID
     */
    public function find(int $id): ?array
    {
        return Database::fetch(
            'SELECT * FROM enrollments WHERE id = :id',
            ['id' => $id]
        );
    }

    /**
     * Find enrollment by user and course
     */
    public function findByUserAndCourse(int $userId, int $courseId): ?array
    {
        return Database::fetch(
            'SELECT * FROM enrollments WHERE user_id = :user_id AND course_id = :course_id',
            ['user_id' => $userId, 'course_id' => $courseId]
        );
    }

    /**
     * Get all enrollments for a user
     */
    public function getByUser(int $userId, array $filters = []): array
    {
        $sql = 'SELECT e.*, c.title as course_title, c.slug as course_slug, 
                       cc.name as category_name, cc.slug as category_slug
                FROM enrollments e
                JOIN courses c ON e.course_id = c.id
                LEFT JOIN course_categories cc ON c.category_id = cc.id
                WHERE e.user_id = :user_id';
        
        $params = ['user_id' => $userId];

        if (!empty($filters['status'])) {
            $sql .= ' AND e.status = :status';
            $params['status'] = $filters['status'];
        }

        $sql .= ' ORDER BY e.enrolled_at DESC';

        return Database::fetchAll($sql, $params);
    }

    /**
     * Get all enrollments for a course
     */
    public function getByCourse(int $courseId): array
    {
        return Database::fetchAll(
            'SELECT e.*, u.first_name, u.last_name, u.email
             FROM enrollments e
             JOIN users u ON e.user_id = u.id
             WHERE e.course_id = :course_id
             ORDER BY e.enrolled_at DESC',
            ['course_id' => $courseId]
        );
    }

    /**
     * Create new enrollment
     */
    public function create(array $data): int
    {
        $data['enrolled_at'] = $data['enrolled_at'] ?? date('Y-m-d H:i:s');
        $data['progress'] = $data['progress'] ?? 0;
        $data['status'] = $data['status'] ?? 'active';

        return Database::insert('enrollments', $data);
    }

    /**
     * Update enrollment
     */
    public function update(int $id, array $data): bool
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        return Database::update('enrollments', $data, 'id = :id', ['id' => $id]) > 0;
    }

    /**
     * Update enrollment progress
     */
    public function updateProgress(int $id, float $progress): bool
    {
        return $this->update($id, ['progress' => $progress]);
    }

    /**
     * Mark enrollment as completed
     */
    public function markCompleted(int $id): bool
    {
        return $this->update($id, [
            'status' => 'completed',
            'completed_at' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Get enrollment statistics
     */
    public function getStatistics(int $userId): array
    {
        $stats = Database::fetch(
            'SELECT 
                COUNT(*) as total_enrollments,
                SUM(CASE WHEN status = "completed" THEN 1 ELSE 0 END) as completed_count,
                SUM(CASE WHEN status = "active" THEN 1 ELSE 0 END) as active_count,
                AVG(progress) as average_progress
             FROM enrollments
             WHERE user_id = :user_id',
            ['user_id' => $userId]
        );

        return $stats ?: [
            'total_enrollments' => 0,
            'completed_count' => 0,
            'active_count' => 0,
            'average_progress' => 0
        ];
    }

    /**
     * Delete enrollment
     */
    public function delete(int $id): bool
    {
        return Database::delete('enrollments', 'id = :id', ['id' => $id]) > 0;
    }
}
