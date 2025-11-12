<?php

namespace Nebatech\Models;

use Nebatech\Core\Model;
use Nebatech\Core\Database;

class BlogPost extends Model
{
    protected string $table = 'blog_posts';
    protected string $primaryKey = 'id';
    
    protected $fillable = [
        'uuid',
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'author_id',
        'category_id',
        'tags',
        'status',
        'published_at',
        'views'
    ];

    /**
     * Get all published posts
     */
    public static function getAllPublished(array $filters = []): array
    {
        $sql = "SELECT bp.*, 
                       bc.name as category_name,
                       bc.slug as category_slug,
                       u.first_name as author_first_name,
                       u.last_name as author_last_name
                FROM blog_posts bp
                LEFT JOIN blog_categories bc ON bp.category_id = bc.id
                LEFT JOIN users u ON bp.author_id = u.id
                WHERE bp.status = 'published'";
        
        $params = [];
        
        if (!empty($filters['category'])) {
            $sql .= " AND bc.slug = :category";
            $params['category'] = $filters['category'];
        }
        
        if (!empty($filters['limit'])) {
            $sql .= " ORDER BY bp.published_at DESC LIMIT :limit";
            $params['limit'] = $filters['limit'];
        } else {
            $sql .= " ORDER BY bp.published_at DESC";
        }
        
        return Database::fetchAll($sql, $params);
    }

    /**
     * Get post by slug
     */
    public static function getBySlug(string $slug): ?array
    {
        $sql = "SELECT bp.*, 
                       bc.name as category_name,
                       bc.slug as category_slug,
                       u.first_name as author_first_name,
                       u.last_name as author_last_name,
                       u.avatar as author_avatar
                FROM blog_posts bp
                LEFT JOIN blog_categories bc ON bp.category_id = bc.id
                LEFT JOIN users u ON bp.author_id = u.id
                WHERE bp.slug = :slug AND bp.status = 'published'
                LIMIT 1";
        
        return Database::fetch($sql, ['slug' => $slug]);
    }

    /**
     * Get posts by category
     */
    public static function getByCategory(string $category, int $limit = null): array
    {
        $filters = ['category' => $category];
        if ($limit) {
            $filters['limit'] = $limit;
        }
        return self::getAllPublished($filters);
    }
    
    /**
     * Get posts by category ID
     */
    public static function getByCategoryId(int $categoryId, int $limit = null): array
    {
        $sql = "SELECT bp.*, 
                       bc.name as category_name,
                       bc.slug as category_slug,
                       u.first_name as author_first_name,
                       u.last_name as author_last_name
                FROM blog_posts bp
                LEFT JOIN blog_categories bc ON bp.category_id = bc.id
                LEFT JOIN users u ON bp.author_id = u.id
                WHERE bp.status = 'published' AND bp.category_id = :category_id
                ORDER BY bp.published_at DESC";
        
        $params = ['category_id' => $categoryId];
        
        if ($limit) {
            $sql .= " LIMIT :limit";
            $params['limit'] = $limit;
        }
        
        return Database::fetchAll($sql, $params);
    }

    /**
     * Get recent posts
     */
    public static function getRecent(int $limit = 5): array
    {
        return self::getAllPublished(['limit' => $limit]);
    }

    /**
     * Increment view count
     */
    public static function incrementViews(int $id): bool
    {
        $sql = "UPDATE blog_posts SET views = views + 1 WHERE id = :id";
        $result = Database::query($sql, ['id' => $id]);
        return $result->rowCount() > 0;
    }

    /**
     * Create new blog post
     */
    public static function create(array $data): ?int
    {
        // Generate UUID if not provided
        if (!isset($data['uuid'])) {
            $data['uuid'] = self::generateUuid();
        }

        // Generate slug from title if not provided
        if (!isset($data['slug']) && isset($data['title'])) {
            $data['slug'] = self::generateSlug($data['title']);
        }

        // Set default status if not provided
        if (!isset($data['status'])) {
            $data['status'] = 'draft';
        }

        try {
            return Database::insert('blog_posts', $data);
        } catch (\Exception $e) {
            error_log("Blog post creation failed: " . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Generate UUID v4
     */
    protected static function generateUuid(): string
    {
        $data = random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
        
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
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
     * Check if slug exists
     */
    public static function slugExists(string $slug, ?int $excludeId = null): bool
    {
        $sql = "SELECT COUNT(*) as count FROM blog_posts WHERE slug = :slug";
        $params = ['slug' => $slug];

        if ($excludeId) {
            $sql .= " AND id != :id";
            $params['id'] = $excludeId;
        }

        $result = Database::fetch($sql, $params);
        return $result && $result['count'] > 0;
    }
}
