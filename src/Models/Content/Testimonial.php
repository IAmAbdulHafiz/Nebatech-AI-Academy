<?php

namespace Nebatech\Models\Content;

use Nebatech\Core\Model;
use Nebatech\Core\Database;

class Testimonial extends Model
{
    protected string $table = 'testimonials';
    protected string $primaryKey = 'id';
    
    protected $fillable = [
        'uuid',
        'type',
        'content',
        'client_name',
        'client_position',
        'client_company',
        'client_image',
        'rating',
        'is_featured',
        'related_id',
        'status'
    ];

    /**
     * Get all active testimonials
     */
    public static function getAllActive(array $filters = []): array
    {
        $sql = "SELECT * FROM testimonials WHERE status = 'active'";
        $params = [];
        
        if (!empty($filters['type'])) {
            $sql .= " AND type = :type";
            $params['type'] = $filters['type'];
        }
        
        if (!empty($filters['featured'])) {
            $sql .= " AND is_featured = 1";
        }
        
        $sql .= " ORDER BY created_at DESC";
        
        if (!empty($filters['limit'])) {
            $sql .= " LIMIT :limit";
            $params['limit'] = $filters['limit'];
        }
        
        return Database::fetchAll($sql, $params);
    }

    /**
     * Get featured testimonials
     */
    public static function getFeatured(int $limit = 6): array
    {
        return self::getAllActive(['featured' => true, 'limit' => $limit]);
    }

    /**
     * Get random testimonials
     */
    public static function getRandom(int $limit = 3): array
    {
        $sql = "SELECT * FROM testimonials 
                WHERE status = 'active' 
                ORDER BY RAND() 
                LIMIT :limit";
        
        return Database::fetchAll($sql, ['limit' => $limit]);
    }
    
    /**
     * Get testimonials by type
     */
    public static function getByType(string $type, int $limit = null): array
    {
        $filters = ['type' => $type];
        if ($limit) {
            $filters['limit'] = $limit;
        }
        return self::getAllActive($filters);
    }
    
    /**
     * Create new testimonial
     */
    public static function create(array $data): ?int
    {
        // Generate UUID if not provided
        if (!isset($data['uuid'])) {
            $data['uuid'] = self::generateUuid();
        }

        // Set defaults
        $data['status'] = $data['status'] ?? 'pending';
        $data['type'] = $data['type'] ?? 'general';
        $data['rating'] = $data['rating'] ?? 5;
        $data['is_featured'] = $data['is_featured'] ?? 0;

        try {
            return Database::insert('testimonials', $data);
        } catch (\Exception $e) {
            error_log("Testimonial creation failed: " . $e->getMessage());
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
}
