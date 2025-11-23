<?php

namespace Nebatech\Models\Business;

use Nebatech\Core\Model;
use Nebatech\Core\Database;

class Service extends Model
{
    protected string $table = 'services';
    protected string $primaryKey = 'id';
    
    protected $fillable = [
        'uuid',
        'title',
        'slug',
        'short_description',
        'description',
        'category_id',
        'price_range',
        'duration',
        'icon',
        'image',
        'features',
        'related_course_id',
        'course_description',
        'is_featured',
        'status',
        'pricing_info',
        'order_index'
    ];

    /**
     * Get all active services
     */
    public static function getAllActive(array $filters = []): array
    {
        $sql = "SELECT s.*, 
                       sc.name as category_name,
                       sc.slug as category_slug
                FROM services s
                LEFT JOIN service_categories sc ON s.category_id = sc.id
                WHERE s.status = 'active'";
        
        $params = [];
        
        if (!empty($filters['category'])) {
            $sql .= " AND sc.slug = :category";
            $params['category'] = $filters['category'];
        }
        
        if (!empty($filters['category_id'])) {
            $sql .= " AND s.category_id = :category_id";
            $params['category_id'] = $filters['category_id'];
        }
        
        if (!empty($filters['featured'])) {
            $sql .= " AND s.is_featured = 1";
        }
        
        $sql .= " ORDER BY s.order_index ASC, s.title ASC";
        
        if (!empty($filters['limit'])) {
            $sql .= " LIMIT :limit";
            $params['limit'] = $filters['limit'];
        }
        
        return Database::fetchAll($sql, $params);
    }

    /**
     * Get service by slug
     */
    public static function getBySlug(string $slug): ?array
    {
        $sql = "SELECT s.*, 
                       sc.name as category_name,
                       sc.slug as category_slug
                FROM services s
                LEFT JOIN service_categories sc ON s.category_id = sc.id
                WHERE s.slug = :slug AND s.status = 'active'
                LIMIT 1";
        
        return Database::fetch($sql, ['slug' => $slug]);
    }

    /**
     * Get featured services
     */
    public static function getFeatured(int $limit = 4): array
    {
        return self::getAllActive(['featured' => true, 'limit' => $limit]);
    }
    
    /**
     * Get services by category
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
     * Get services by category ID
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
     * Find service by ID
     */
    public static function findById(int $id): ?array
    {
        $sql = "SELECT s.*, 
                       sc.name as category_name,
                       sc.slug as category_slug
                FROM services s
                LEFT JOIN service_categories sc ON s.category_id = sc.id
                WHERE s.id = :id
                LIMIT 1";
        
        return Database::fetch($sql, ['id' => $id]);
    }
    
    /**
     * Create new service
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
        $data['status'] = $data['status'] ?? 'active';
        $data['is_featured'] = $data['is_featured'] ?? 0;
        $data['order_index'] = $data['order_index'] ?? 0;

        try {
            return Database::insert('services', $data);
        } catch (\Exception $e) {
            error_log("Service creation failed: " . $e->getMessage());
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
        $sql = "SELECT COUNT(*) as count FROM services WHERE slug = :slug";
        $params = ['slug' => $slug];

        if ($excludeId) {
            $sql .= " AND id != :id";
            $params['id'] = $excludeId;
        }

        $result = Database::fetch($sql, $params);
        return $result && $result['count'] > 0;
    }
}
