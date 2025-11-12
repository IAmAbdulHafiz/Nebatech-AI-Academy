<?php

namespace Nebatech\Models\Content;

use Nebatech\Core\Model;
use Nebatech\Core\Database;

class ProjectCategory extends Model
{
    protected string $table = 'project_categories';
    protected string $primaryKey = 'id';

    /**
     * Get all active project categories
     */
    public static function getActive(): array
    {
        $sql = "SELECT * FROM project_categories WHERE is_active = 1 ORDER BY sort_order ASC, name ASC";
        return Database::fetchAll($sql);
    }

    /**
     * Find category by slug
     */
    public static function findBySlug(string $slug): ?array
    {
        $sql = "SELECT * FROM project_categories WHERE slug = :slug AND is_active = 1 LIMIT 1";
        return Database::fetch($sql, ['slug' => $slug]);
    }

    /**
     * Get category with project count
     */
    public static function getWithProjectCount(): array
    {
        $sql = "
            SELECT 
                pc.*,
                COUNT(p.id) as project_count
            FROM project_categories pc
            LEFT JOIN projects p ON pc.id = p.category_id AND p.is_active = 1
            WHERE pc.is_active = 1
            GROUP BY pc.id
            ORDER BY pc.sort_order ASC, pc.name ASC
        ";
        return Database::fetchAll($sql);
    }

    /**
     * Create new project category
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
            return Database::insert('project_categories', $data);
        } catch (\Exception $e) {
            error_log("Project category creation failed: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Update project category
     */
    public static function updateCategory(int $id, array $data): bool
    {
        // Update slug if name changed
        if (isset($data['name']) && !isset($data['slug'])) {
            $data['slug'] = self::generateSlug($data['name']);
        }

        $result = Database::update(
            'project_categories',
            $data,
            'id = :id',
            ['id' => $id]
        );

        return $result > 0;
    }

    /**
     * Delete project category
     */
    public static function deleteCategory(int $id): bool
    {
        // Check if category has projects
        $projectCount = Database::fetch(
            "SELECT COUNT(*) as count FROM projects WHERE category_id = :id",
            ['id' => $id]
        );

        if ($projectCount && $projectCount['count'] > 0) {
            // Don't delete if has projects, just deactivate
            return self::updateCategory($id, ['is_active' => 0]);
        }

        $result = Database::delete('project_categories', 'id = :id', ['id' => $id]);
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
