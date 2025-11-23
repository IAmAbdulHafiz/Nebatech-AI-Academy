<?php

namespace Nebatech\Models\Content;

use Nebatech\Core\Model;
use Nebatech\Core\Database;

class Project extends Model
{
    protected string $table = 'projects';
    protected string $primaryKey = 'id';
    
    protected $fillable = [
        'uuid',
        'title',
        'slug',
        'description',
        'client_name',
        'category_id',
        'technologies',
        'image',
        'gallery',
        'project_url',
        'completion_date',
        'is_featured',
        'is_active'
    ];

    /**
     * Get all active projects
     */
    public static function getAllActive(array $filters = []): array
    {
        $sql = "SELECT p.*, 
                       pc.name as category_name,
                       pc.slug as category_slug
                FROM projects p
                LEFT JOIN project_categories pc ON p.category_id = pc.id
                WHERE p.is_active = 1";
        
        $params = [];
        
        if (!empty($filters['category'])) {
            $sql .= " AND pc.slug = :category";
            $params['category'] = $filters['category'];
        }
        
        if (!empty($filters['category_id'])) {
            $sql .= " AND p.category_id = :category_id";
            $params['category_id'] = $filters['category_id'];
        }
        
        $sql .= " ORDER BY p.is_featured DESC, p.completion_date DESC";
        
        if (!empty($filters['limit'])) {
            $sql .= " LIMIT :limit";
            $params['limit'] = $filters['limit'];
        }
        
        return Database::fetchAll($sql, $params);
    }

    /**
     * Get featured projects
     */
    public static function getFeatured(int $limit = 6): array
    {
        $sql = "SELECT p.*, 
                       pc.name as category_name,
                       pc.slug as category_slug
                FROM projects p
                LEFT JOIN project_categories pc ON p.category_id = pc.id
                WHERE p.is_active = 1 AND p.is_featured = 1
                ORDER BY p.completion_date DESC
                LIMIT :limit";
        
        return Database::fetchAll($sql, ['limit' => $limit]);
    }

    /**
     * Get projects by category
     */
    public static function getByCategory(string $category, int $limit = null): array
    {
        $filters = ['category' => $category];
        if ($limit) {
            $filters['limit'] = $limit;
        }
        return self::getAllActive($filters);
    }
    
    /**
     * Get projects by category ID
     */
    public static function getByCategoryId(int $categoryId, int $limit = null): array
    {
        $filters = ['category_id' => $categoryId];
        if ($limit) {
            $filters['limit'] = $limit;
        }
        return self::getAllActive($filters);
    }

    /**
     * Find project by slug
     */
    public static function findBySlug(string $slug): ?array
    {
        $sql = "SELECT p.*, 
                       pc.name as category_name,
                       pc.slug as category_slug
                FROM projects p
                LEFT JOIN project_categories pc ON p.category_id = pc.id
                WHERE p.slug = :slug AND p.is_active = 1
                LIMIT 1";
        
        return Database::fetch($sql, ['slug' => $slug]);
    }
    
    /**
     * Create new project
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

        // Set defaults
        $data['is_active'] = $data['is_active'] ?? 1;
        $data['is_featured'] = $data['is_featured'] ?? 0;

        try {
            return Database::insert('projects', $data);
        } catch (\Exception $e) {
            error_log("Project creation failed: " . $e->getMessage());
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
        $sql = "SELECT COUNT(*) as count FROM projects WHERE slug = :slug";
        $params = ['slug' => $slug];

        if ($excludeId) {
            $sql .= " AND id != :id";
            $params['id'] = $excludeId;
        }

        $result = Database::fetch($sql, $params);
        return $result && $result['count'] > 0;
    }
}
