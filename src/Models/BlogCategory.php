<?php

namespace Nebatech\Models;

use Nebatech\Core\Model;
use Nebatech\Core\Database;

class BlogCategory extends Model
{
    protected string $table = 'blog_categories';
    protected string $primaryKey = 'id';

    /**
     * Get all active blog categories
     */
    public static function getActive(): array
    {
        $sql = "SELECT * FROM blog_categories WHERE is_active = 1 ORDER BY sort_order ASC, name ASC";
        return Database::fetchAll($sql);
    }

    /**
     * Find category by slug
     */
    public static function findBySlug(string $slug): ?array
    {
        $sql = "SELECT * FROM blog_categories WHERE slug = :slug AND is_active = 1 LIMIT 1";
        return Database::fetch($sql, ['slug' => $slug]);
    }

    /**
     * Get category with post count
     */
    public static function getWithPostCount(): array
    {
        $sql = "
            SELECT 
                bc.*,
                COUNT(bp.id) as post_count
            FROM blog_categories bc
            LEFT JOIN blog_posts bp ON bc.id = bp.category_id AND bp.status = 'published'
            WHERE bc.is_active = 1
            GROUP BY bc.id
            ORDER BY bc.sort_order ASC, bc.name ASC
        ";
        return Database::fetchAll($sql);
    }

    /**
     * Create new blog category
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
            return Database::insert('blog_categories', $data);
        } catch (\Exception $e) {
            error_log("Blog category creation failed: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Update blog category
     */
    public static function updateCategory(int $id, array $data): bool
    {
        // Update slug if name changed
        if (isset($data['name']) && !isset($data['slug'])) {
            $data['slug'] = self::generateSlug($data['name']);
        }

        $result = Database::update(
            'blog_categories',
            $data,
            'id = :id',
            ['id' => $id]
        );

        return $result > 0;
    }

    /**
     * Delete blog category
     */
    public static function deleteCategory(int $id): bool
    {
        // Check if category has posts
        $postCount = Database::fetch(
            "SELECT COUNT(*) as count FROM blog_posts WHERE category_id = :id",
            ['id' => $id]
        );

        if ($postCount && $postCount['count'] > 0) {
            // Don't delete if has posts, just deactivate
            return self::updateCategory($id, ['is_active' => 0]);
        }

        $result = Database::delete('blog_categories', 'id = :id', ['id' => $id]);
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
