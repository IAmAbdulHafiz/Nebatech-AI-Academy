<?php

namespace Nebatech\Services;

use Nebatech\Core\Database;

/**
 * Testimonial Service
 * Manages unified testimonials across courses and services
 */
class TestimonialService
{
    
    /**
     * Get testimonials by type and context
     */
    public function getTestimonials(array $filters = []): array
    {
        $sql = "
            SELECT 
                t.*,
                CASE 
                    WHEN t.type = 'course' THEN c.title
                    WHEN t.type = 'service' THEN s.title
                    ELSE NULL
                END as related_title,
                CASE 
                    WHEN t.type = 'course' THEN c.slug
                    WHEN t.type = 'service' THEN s.slug
                    ELSE NULL
                END as related_slug
            FROM testimonials t
            LEFT JOIN courses c ON t.type = 'course' AND t.related_id = c.id
            LEFT JOIN services s ON t.type = 'service' AND t.related_id = s.id
            WHERE t.status = 'active'
        ";
        
        $params = [];
        
        // Filter by type
        if (!empty($filters['type'])) {
            $sql .= " AND t.type = :type";
            $params['type'] = $filters['type'];
        }
        
        // Filter by featured
        if (!empty($filters['featured'])) {
            $sql .= " AND t.is_featured = 1";
        }
        
        // Filter by related content
        if (!empty($filters['related_id']) && !empty($filters['related_type'])) {
            $sql .= " AND t.related_id = :related_id AND t.type = :related_type";
            $params['related_id'] = $filters['related_id'];
            $params['related_type'] = $filters['related_type'];
        }
        
        // Filter by rating
        if (!empty($filters['min_rating'])) {
            $sql .= " AND t.rating >= :min_rating";
            $params['min_rating'] = $filters['min_rating'];
        }
        
        $sql .= " ORDER BY t.is_featured DESC, t.rating DESC, t.created_at DESC";
        
        // Add limit
        $limit = $filters['limit'] ?? 10;
        $sql .= " LIMIT :limit";
        $params['limit'] = $limit;
        
        return Database::query($sql, $params)->fetchAll();
    }
    
    /**
     * Get featured testimonials for homepage
     */
    public function getFeaturedTestimonials(int $limit = 6): array
    {
        return $this->getTestimonials([
            'featured' => true,
            'min_rating' => 4,
            'limit' => $limit
        ]);
    }
    
    /**
     * Get testimonials for specific content
     */
    public function getContentTestimonials(string $type, int $relatedId, int $limit = 5): array
    {
        return $this->getTestimonials([
            'related_type' => $type,
            'related_id' => $relatedId,
            'limit' => $limit
        ]);
    }
    
    /**
     * Get mixed testimonials (both courses and services)
     */
    public function getMixedTestimonials(int $limit = 8): array
    {
        $courseTestimonials = $this->getTestimonials([
            'type' => 'course',
            'featured' => true,
            'limit' => ceil($limit / 2)
        ]);
        
        $serviceTestimonials = $this->getTestimonials([
            'type' => 'service', 
            'featured' => true,
            'limit' => floor($limit / 2)
        ]);
        
        // Merge and shuffle for variety
        $mixed = array_merge($courseTestimonials, $serviceTestimonials);
        shuffle($mixed);
        
        return array_slice($mixed, 0, $limit);
    }
    
    /**
     * Get testimonials by category
     */
    public function getTestimonialsByCategory(string $category, int $limit = 6): array
    {
        $sql = "
            SELECT DISTINCT t.*, 
                CASE 
                    WHEN t.type = 'course' THEN c.title
                    WHEN t.type = 'service' THEN s.title
                    ELSE NULL
                END as related_title
            FROM testimonials t
            LEFT JOIN courses c ON t.type = 'course' AND t.related_id = c.id
            LEFT JOIN course_categories cc ON c.category_id = cc.id
            LEFT JOIN services s ON t.type = 'service' AND t.related_id = s.id
            LEFT JOIN service_categories sc ON s.category_id = sc.id
            WHERE t.status = 'active'
            AND (cc.slug = :category OR sc.slug = :category2)
            ORDER BY t.is_featured DESC, t.rating DESC, t.created_at DESC
            LIMIT :limit
        ";
        
        return Database::query($sql, [
            'category' => $category,
            'category2' => $category,
            'limit' => $limit
        ])->fetchAll();
    }
    
    /**
     * Create new testimonial
     */
    public function createTestimonial(array $data): bool
    {
        $sql = "
            INSERT INTO testimonials (
                type, content, client_name, client_position, client_company, 
                client_image, rating, related_id, status
            ) VALUES (
                :type, :content, :client_name, :client_position, :client_company,
                :client_image, :rating, :related_id, :status
            )
        ";
        
        $params = [
            'type' => $data['type'],
            'content' => $data['content'],
            'client_name' => $data['client_name'],
            'client_position' => $data['client_position'] ?? null,
            'client_company' => $data['client_company'] ?? null,
            'client_image' => $data['client_image'] ?? null,
            'rating' => $data['rating'] ?? 5,
            'related_id' => $data['related_id'] ?? null,
            'status' => $data['status'] ?? 'pending'
        ];
        
        return Database::query($sql, $params)->rowCount() > 0;
    }
    
    /**
     * Get testimonial statistics
     */
    public function getTestimonialStats(): array
    {
        $sql = "
            SELECT 
                COUNT(*) as total_testimonials,
                AVG(rating) as average_rating,
                COUNT(CASE WHEN type = 'course' THEN 1 END) as course_testimonials,
                COUNT(CASE WHEN type = 'service' THEN 1 END) as service_testimonials,
                COUNT(CASE WHEN is_featured = 1 THEN 1 END) as featured_testimonials
            FROM testimonials 
            WHERE status = 'active'
        ";
        
        return Database::query($sql)->fetch();
    }
    
    /**
     * Get success stories (testimonials with journey narrative)
     */
    public function getSuccessStories(int $limit = 4): array
    {
        // Get testimonials that span both academy and corporate sections
        $sql = "
            SELECT t.*, 
                c.title as course_title, c.slug as course_slug,
                s.title as service_title, s.slug as service_slug
            FROM testimonials t
            LEFT JOIN courses c ON t.type = 'course' AND t.related_id = c.id
            LEFT JOIN services s ON t.type = 'service' AND t.related_id = s.id
            WHERE t.status = 'active' 
            AND t.is_featured = 1
            AND LENGTH(t.content) > 200
            ORDER BY t.rating DESC, t.created_at DESC
            LIMIT :limit
        ";
        
        return Database::query($sql, ['limit' => $limit])->fetchAll();
    }
}
