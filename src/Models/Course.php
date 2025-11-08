<?php

namespace Nebatech\Models;

use Nebatech\Core\Model;
use Nebatech\Core\Database;

class Course extends Model
{
    protected string $table = 'courses';
    protected string $primaryKey = 'id';

    /**
     * Get all courses with optional filters
     */
    public static function getAll(array $filters = []): array
    {
        $sql = "SELECT c.*, 
                       u.first_name as facilitator_first_name,
                       u.last_name as facilitator_last_name,
                       (SELECT COUNT(*) FROM enrollments WHERE course_id = c.id) as enrollment_count
                FROM " . 'courses' . " c
                LEFT JOIN users u ON c.facilitator_id = u.id";
        
        $params = [];
        $conditions = [];

        if (!empty($filters['category'])) {
            $conditions[] = "c.category = :category";
            $params['category'] = $filters['category'];
        }

        if (!empty($filters['level'])) {
            $conditions[] = "c.level = :level";
            $params['level'] = $filters['level'];
        }

        if (!empty($filters['status'])) {
            $conditions[] = "c.status = :status";
            $params['status'] = $filters['status'];
        } else {
            // By default, only show published courses
            $conditions[] = "c.status = 'published'";
        }

        if (!empty($filters['facilitator_id'])) {
            $conditions[] = "c.facilitator_id = :facilitator_id";
            $params['facilitator_id'] = $filters['facilitator_id'];
        }

        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(' AND ', $conditions);
        }

        $sql .= " ORDER BY c.created_at DESC";

        if (!empty($filters['limit'])) {
            $sql .= " LIMIT " . (int)$filters['limit'];
            
            if (!empty($filters['offset'])) {
                $sql .= " OFFSET " . (int)$filters['offset'];
            }
        }

        return Database::fetchAll($sql, $params);
    }

    /**
     * Find course by slug
     */
    public static function findBySlug(string $slug): ?array
    {
        $sql = "SELECT c.*, 
                       u.first_name as facilitator_first_name,
                       u.last_name as facilitator_last_name,
                       u.avatar as facilitator_avatar,
                       (SELECT COUNT(*) FROM enrollments WHERE course_id = c.id) as enrollment_count
                FROM " . 'courses' . " c
                LEFT JOIN users u ON c.facilitator_id = u.id
                WHERE c.slug = :slug LIMIT 1";
        
        return Database::fetch($sql, ['slug' => $slug]);
    }

    /**
     * Find course by ID with details
     */
    public static function findById(int $id): ?array
    {
        $sql = "SELECT c.*, 
                       u.first_name as facilitator_first_name,
                       u.last_name as facilitator_last_name,
                       u.avatar as facilitator_avatar,
                       u.email as facilitator_email,
                       (SELECT COUNT(*) FROM enrollments WHERE course_id = c.id) as enrollment_count
                FROM " . 'courses' . " c
                LEFT JOIN users u ON c.facilitator_id = u.id
                WHERE c.id = :id LIMIT 1";
        
        return Database::fetch($sql, ['id' => $id]);
    }

    /**
     * Create a new course
     */
    public static function createCourse(array $data): ?int
    {
        // Generate UUID if not provided
        if (!isset($data['uuid'])) {
            $data['uuid'] = self::generateCourseUuid();
        }

        // Generate slug from title if not provided
        if (!isset($data['slug']) && isset($data['title'])) {
            $data['slug'] = self::generateSlug($data['title']);
        }

        // Set default status if not provided
        if (!isset($data['status'])) {
            $data['status'] = 'draft';
        }

        // Set default level if not provided
        if (!isset($data['level'])) {
            $data['level'] = 'beginner';
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
    public static function updateCourse(int $courseId, array $data): bool
    {
        // Remove fields that shouldn't be updated directly
        unset($data['id'], $data['uuid'], $data['created_at']);

        // Update slug if title changed
        if (isset($data['title']) && !isset($data['slug'])) {
            $data['slug'] = self::generateSlug($data['title']);
        }

        if (empty($data)) {
            return false;
        }

        $result = Database::update(
            'courses',
            $data,
            'id = :id',
            ['id' => $courseId]
        );

        return $result > 0;
    }

    /**
     * Delete course
     */
    public static function deleteCourse(int $courseId): bool
    {
        $result = Database::delete('courses', 'id = :id', ['id' => $courseId]);
        return $result > 0;
    }

    /**
     * Get courses by category
     */
    public static function getByCategory(string $category, int $limit = null): array
    {
        $filters = [
            'category' => $category,
            'status' => 'published'
        ];

        if ($limit) {
            $filters['limit'] = $limit;
        }

        return self::getAll($filters);
    }

    /**
     * Get courses by facilitator
     */
    public static function getByFacilitator(int $facilitatorId): array
    {
        return self::getAll(['facilitator_id' => $facilitatorId]);
    }

    /**
     * Search courses
     */
    public static function search(string $query, array $filters = []): array
    {
        $sql = "SELECT c.*, 
                       u.first_name as facilitator_first_name,
                       u.last_name as facilitator_last_name,
                       (SELECT COUNT(*) FROM enrollments WHERE course_id = c.id) as enrollment_count
                FROM " . 'courses' . " c
                LEFT JOIN users u ON c.facilitator_id = u.id
                WHERE (c.title LIKE :query OR c.description LIKE :query)";
        
        $params = ['query' => "%$query%"];

        if (!empty($filters['category'])) {
            $sql .= " AND c.category = :category";
            $params['category'] = $filters['category'];
        }

        if (!empty($filters['level'])) {
            $sql .= " AND c.level = :level";
            $params['level'] = $filters['level'];
        }

        $sql .= " AND c.status = 'published' ORDER BY c.created_at DESC";

        if (!empty($filters['limit'])) {
            $sql .= " LIMIT " . (int)$filters['limit'];
        }

        return Database::fetchAll($sql, $params);
    }

    /**
     * Get course statistics
     */
    public static function getStats(): array
    {
        $sql = "SELECT 
                    COUNT(*) as total,
                    SUM(CASE WHEN status = 'published' THEN 1 ELSE 0 END) as published,
                    SUM(CASE WHEN status = 'draft' THEN 1 ELSE 0 END) as draft,
                    SUM(CASE WHEN level = 'beginner' THEN 1 ELSE 0 END) as beginner,
                    SUM(CASE WHEN level = 'intermediate' THEN 1 ELSE 0 END) as intermediate,
                    SUM(CASE WHEN level = 'advanced' THEN 1 ELSE 0 END) as advanced,
                    (SELECT COUNT(*) FROM enrollments) as total_enrollments
                FROM " . 'courses';
        
        return Database::fetch($sql) ?? [
            'total' => 0,
            'published' => 0,
            'draft' => 0,
            'beginner' => 0,
            'intermediate' => 0,
            'advanced' => 0,
            'total_enrollments' => 0
        ];
    }

    /**
     * Get popular courses
     */
    public static function getPopular(int $limit = 10): array
    {
        $sql = "SELECT c.*, 
                       u.first_name as facilitator_first_name,
                       u.last_name as facilitator_last_name,
                       COUNT(e.id) as enrollment_count
                FROM " . 'courses' . " c
                LEFT JOIN users u ON c.facilitator_id = u.id
                LEFT JOIN enrollments e ON c.id = e.course_id
                WHERE c.status = 'published'
                GROUP BY c.id
                ORDER BY enrollment_count DESC
                LIMIT :limit";
        
        return Database::fetchAll($sql, ['limit' => $limit]);
    }

    /**
     * Check if slug exists
     */
    public static function slugExists(string $slug, ?int $excludeId = null): bool
    {
        $sql = "SELECT COUNT(*) as count FROM " . 'courses' . " WHERE slug = :slug";
        $params = ['slug' => $slug];

        if ($excludeId) {
            $sql .= " AND id != :id";
            $params['id'] = $excludeId;
        }

        $result = Database::fetch($sql, $params);
        return $result && $result['count'] > 0;
    }

    /**
     * Generate slug from title
     */
    protected static function generateSlug(string $title): string
    {
        $slug = strtolower($title);
        $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
        $slug = trim($slug, '-');

        // Ensure uniqueness
        $originalSlug = $slug;
        $counter = 1;
        while (self::slugExists($slug)) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Generate UUID v4 for courses
     */
    protected static function generateCourseUuid(): string
    {
        $data = random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
        
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    /**
     * Publish course
     */
    public static function publish(int $courseId): bool
    {
        return self::update($courseId, ['status' => 'published']);
    }

    /**
     * Archive course
     */
    public static function archive(int $courseId): bool
    {
        return self::update($courseId, ['status' => 'archived']);
    }
}
