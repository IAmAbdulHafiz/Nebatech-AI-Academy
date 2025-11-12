<?php

namespace Nebatech\Models;

use Nebatech\Core\Model;
use Nebatech\Core\Database;

class CourseCategory extends Model
{
    protected string $table = 'course_categories';
    protected string $primaryKey = 'id';

    /**
     * Get all active course categories
     */
    public static function getActive(): array
    {
        $sql = "SELECT * FROM course_categories WHERE is_active = 1 ORDER BY sort_order ASC, name ASC";
        return Database::fetchAll($sql);
    }

    /**
     * Find category by slug
     */
    public static function findBySlug(string $slug): ?array
    {
        $sql = "SELECT * FROM course_categories WHERE slug = :slug AND is_active = 1 LIMIT 1";
        return Database::fetch($sql, ['slug' => $slug]);
    }

    /**
     * Get category with course count
     */
    public static function getWithCourseCount(): array
    {
        $sql = "
            SELECT 
                cc.*,
                COUNT(c.id) as course_count
            FROM course_categories cc
            LEFT JOIN courses c ON cc.id = c.category_id AND c.status = 'published'
            WHERE cc.is_active = 1
            GROUP BY cc.id
            ORDER BY cc.sort_order ASC, cc.name ASC
        ";
        return Database::fetchAll($sql);
    }

    /**
     * Create new course category
     */
    public static function create(array $data): ?int
    {
        // Generate slug if not provided
        if (!isset($data['slug']) && isset($data['name'])) {
            $data['slug'] = self::generateSlug($data['name']);
        }

        // Set defaults
        $data['is_active'] = $data['is_active'] ?? 1;
        $data['sort_order'] = $data['sort_order'] ?? 0;

        try {
            return Database::insert('course_categories', $data);
        } catch (\Exception $e) {
            error_log("Course category creation failed: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Update course category
     */
    public static function updateCategory(int $id, array $data): bool
    {
        // Update slug if name changed
        if (isset($data['name']) && !isset($data['slug'])) {
            $data['slug'] = self::generateSlug($data['name']);
        }

        $result = Database::update(
            'course_categories',
            $data,
            'id = :id',
            ['id' => $id]
        );

        return $result > 0;
    }

    /**
     * Delete course category
     */
    public static function deleteCategory(int $id): bool
    {
        // Check if category has courses
        $courseCount = Database::fetch(
            "SELECT COUNT(*) as count FROM courses WHERE category_id = :id",
            ['id' => $id]
        );

        if ($courseCount && $courseCount['count'] > 0) {
            // Don't delete if has courses, just deactivate
                return self::updateCategory($id, ['is_active' => 0]);
        }

        $result = Database::delete('course_categories', 'id = :id', ['id' => $id]);
        return $result > 0;
    }

    /**
     * Generate URL-friendly slug
     */
    private static function generateSlug(string $name): string
    {
        $slug = strtolower(trim($name));
        $slug = preg_replace('/[^a-z0-9-]/', '-', $slug);
        $slug = preg_replace('/-+/', '-', $slug);
        return trim($slug, '-');
    }
}
