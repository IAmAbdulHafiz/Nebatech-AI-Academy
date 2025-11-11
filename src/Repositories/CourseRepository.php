<?php

namespace Nebatech\Repositories;

use Nebatech\Core\Database;

class CourseRepository
{
    /**
     * Find course by ID
     */
    public function findById(int $id): ?array
    {
        $sql = "SELECT c.*, 
                       u.first_name as facilitator_first_name,
                       u.last_name as facilitator_last_name,
                       u.email as facilitator_email
                FROM courses c
                LEFT JOIN users u ON c.facilitator_id = u.id
                WHERE c.id = :id
                LIMIT 1";
        
        return Database::fetch($sql, ['id' => $id]);
    }

    /**
     * Find course by slug
     */
    public function findBySlug(string $slug): ?array
    {
        $sql = "SELECT c.*, 
                       u.first_name as facilitator_first_name,
                       u.last_name as facilitator_last_name,
                       u.email as facilitator_email
                FROM courses c
                LEFT JOIN users u ON c.facilitator_id = u.id
                WHERE c.slug = :slug
                LIMIT 1";
        
        return Database::fetch($sql, ['slug' => $slug]);
    }

    /**
     * Get all courses with optional filters
     */
    public function getAll(array $filters = []): array
    {
        $sql = "SELECT c.*, 
                       u.first_name as facilitator_first_name,
                       u.last_name as facilitator_last_name,
                       (SELECT COUNT(*) FROM enrollments WHERE course_id = c.id) as enrollment_count
                FROM courses c
                LEFT JOIN users u ON c.facilitator_id = u.id
                WHERE 1=1";
        
        $params = [];

        if (!empty($filters['status'])) {
            $sql .= " AND c.status = :status";
            $params['status'] = $filters['status'];
        }

        if (!empty($filters['category'])) {
            $sql .= " AND c.category = :category";
            $params['category'] = $filters['category'];
        }

        if (!empty($filters['level'])) {
            $sql .= " AND c.level = :level";
            $params['level'] = $filters['level'];
        }

        if (!empty($filters['facilitator_id'])) {
            $sql .= " AND c.facilitator_id = :facilitator_id";
            $params['facilitator_id'] = $filters['facilitator_id'];
        }
        
        if (!empty($filters['approval_status'])) {
            $sql .= " AND c.approval_status = :approval_status";
            $params['approval_status'] = $filters['approval_status'];
        }

        if (!empty($filters['search'])) {
            $sql .= " AND (c.title LIKE :search OR c.description LIKE :search)";
            $params['search'] = '%' . $filters['search'] . '%';
        }

        $sql .= " ORDER BY c.created_at DESC";

        if (!empty($filters['limit'])) {
            $sql .= " LIMIT " . (int)$filters['limit'];
        }

        return Database::fetchAll($sql, $params);
    }

    /**
     * Get courses by facilitator
     */
    public function getByFacilitator(int $facilitatorId, array $filters = []): array
    {
        $filters['facilitator_id'] = $facilitatorId;
        return $this->getAll($filters);
    }

    /**
     * Publish course
     */
    public function publish(int $id): bool
    {
        return $this->update($id, ['status' => 'published']);
    }

    /**
     * Get pending courses for approval
     */
    public function getPendingApprovals(): array
    {
        return $this->getAll(['approval_status' => 'pending_approval']);
    }

    /**
     * Create new course
     */
    public function create(array $data): ?int
    {
        if (!isset($data['uuid'])) {
            $data['uuid'] = $this->generateUuid();
        }

        if (!isset($data['slug']) && isset($data['title'])) {
            $data['slug'] = $this->generateSlug($data['title']);
        }

        try {
            return Database::insert('courses', $data);
        } catch (\Exception $e) {
            error_log("Course creation failed: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Update course
     */
    public function update(int $id, array $data): bool
    {
        unset($data['id'], $data['uuid'], $data['created_at']);

        if (empty($data)) {
            return false;
        }

        $result = Database::update('courses', $data, 'id = :id', ['id' => $id]);
        return $result > 0;
    }

    /**
     * Delete course
     */
    public function delete(int $id): bool
    {
        $result = Database::delete('courses', 'id = :id', ['id' => $id]);
        return $result > 0;
    }

    /**
     * Get course modules
     */
    public function getModules(int $courseId): array
    {
        $sql = "SELECT * FROM modules 
                WHERE course_id = :course_id 
                ORDER BY order_index ASC";
        
        return Database::fetchAll($sql, ['course_id' => $courseId]);
    }

    /**
     * Get course with modules and lessons
     */
    public function getWithContent(int $courseId): ?array
    {
        $course = $this->findById($courseId);
        
        if (!$course) {
            return null;
        }

        // Get modules
        $modules = $this->getModules($courseId);
        
        // Get lessons for each module
        foreach ($modules as &$module) {
            $sql = "SELECT * FROM lessons 
                    WHERE module_id = :module_id 
                    ORDER BY order_index ASC";
            $module['lessons'] = Database::fetchAll($sql, ['module_id' => $module['id']]);
        }

        $course['modules'] = $modules;
        
        return $course;
    }

    /**
     * Count courses
     */
    public function count(array $filters = []): int
    {
        $sql = "SELECT COUNT(*) as count FROM courses WHERE 1=1";
        $params = [];

        if (!empty($filters['status'])) {
            $sql .= " AND status = :status";
            $params['status'] = $filters['status'];
        }

        if (!empty($filters['category'])) {
            $sql .= " AND category = :category";
            $params['category'] = $filters['category'];
        }

        $result = Database::fetch($sql, $params);
        return $result ? (int)$result['count'] : 0;
    }

    /**
     * Generate slug from title
     */
    private function generateSlug(string $title): string
    {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
        
        // Check if slug exists and make it unique
        $originalSlug = $slug;
        $counter = 1;
        
        while ($this->slugExists($slug)) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
        
        return $slug;
    }

    /**
     * Check if slug exists
     */
    private function slugExists(string $slug): bool
    {
        $sql = "SELECT COUNT(*) as count FROM courses WHERE slug = :slug";
        $result = Database::fetch($sql, ['slug' => $slug]);
        return $result && $result['count'] > 0;
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
