<?php

namespace Nebatech\Services;

use Nebatech\Core\Database;

/**
 * Unified Search Service
 * Searches across courses, services, and other content
 */
class UnifiedSearchService
{
    /**
     * Perform unified search across all content types
     */
    public function search(string $query, array $filters = []): array
    {
        $query = trim($query);
        if (empty($query)) {
            return $this->getPopularContent($filters);
        }
        
        $results = [
            'courses' => $this->searchCourses($query, $filters),
            'services' => $this->searchServices($query, $filters),
            'blog_posts' => $this->searchBlogPosts($query, $filters),
            'total_count' => 0
        ];
        
        $results['total_count'] = count($results['courses']) + count($results['services']) + count($results['blog_posts']);
        
        // Add relevance scoring and sorting
        $results = $this->scoreAndSortResults($results, $query);
        
        return $results;
    }
    
    /**
     * Search courses
     */
    private function searchCourses(string $query, array $filters): array
    {
        $sql = "
            SELECT 
                c.id,
                c.title,
                c.slug,
                c.description,
                c.thumbnail,
                c.level,
                c.duration_hours,
                c.status,
                cat.name as category_name,
                cat.slug as category_slug,
                'course' as content_type
            FROM courses c
            LEFT JOIN course_categories cat ON c.category_id = cat.id
            WHERE c.status = 'published'
            AND (
                c.title LIKE :query1 
                OR c.description LIKE :query2 
                OR cat.name LIKE :query3
            )
        ";
        
        $params = [
            'query1' => "%{$query}%",
            'query2' => "%{$query}%", 
            'query3' => "%{$query}%"
        ];
        
        // Add category filter
        if (!empty($filters['category'])) {
            $sql .= " AND cat.slug = :category";
            $params['category'] = $filters['category'];
        }
        
        // Add level filter
        if (!empty($filters['level'])) {
            $sql .= " AND c.level = :level";
            $params['level'] = $filters['level'];
        }
        
        $sql .= " ORDER BY c.title ASC LIMIT 20";
        
        return Database::query($sql, $params)->fetchAll();
    }
    
    /**
     * Search services
     */
    private function searchServices(string $query, array $filters): array
    {
        $sql = "
            SELECT 
                s.id,
                s.title,
                s.slug,
                s.description,
                s.short_description,
                s.duration,
                s.price_range,
                s.features,
                s.is_featured,
                cat.name as category_name,
                'service' as content_type,
                s.created_at
            FROM services s
            LEFT JOIN service_categories cat ON s.category_id = cat.id
            WHERE s.status = 'active'
            AND (
                s.title LIKE :query1 
                OR s.description LIKE :query2 
                OR s.short_description LIKE :query3
                OR cat.name LIKE :query4
            )
        ";
        
        $params = [
            'query1' => "%{$query}%",
            'query2' => "%{$query}%",
            'query3' => "%{$query}%",
            'query4' => "%{$query}%"
        ];
        
        // Add category filter
        if (!empty($filters['service_category'])) {
            $sql .= " AND cat.slug = :service_category";
            $params['service_category'] = $filters['service_category'];
        }
        
        $sql .= " ORDER BY s.is_featured DESC, s.title ASC LIMIT 20";
        
        return Database::query($sql, $params)->fetchAll();
    }
    
    /**
     * Search blog posts
     */
    private function searchBlogPosts(string $query, array $filters): array
    {
        $sql = "
            SELECT 
                id,
                title,
                slug,
                excerpt as short_description,
                content as description,
                featured_image as thumbnail,
                'blog_post' as content_type,
                created_at
            FROM blog_posts
            WHERE status = 'published'
            AND (
                title LIKE :query1 
                OR content LIKE :query2 
                OR excerpt LIKE :query3
                OR tags LIKE :query4
            )
            ORDER BY created_at DESC
            LIMIT 10
        ";
        
        $params = [
            'query1' => "%{$query}%",
            'query2' => "%{$query}%",
            'query3' => "%{$query}%",
            'query4' => "%{$query}%"
        ];
        
        try {
            return Database::query($sql, $params)->fetchAll();
        } catch (Exception $e) {
            // Blog table might not exist yet
            return [];
        }
    }
    
    /**
     * Get popular content when no search query
     */
    private function getPopularContent(array $filters): array
    {
        return [
            'courses' => $this->getPopularCourses($filters),
            'services' => $this->getPopularServices($filters),
            'blog_posts' => [],
            'total_count' => 0
        ];
    }
    
    /**
     * Get popular courses
     */
    private function getPopularCourses(array $filters): array
    {
        $sql = "
            SELECT 
                c.id,
                c.title,
                c.slug,
                c.description,
                c.duration_hours as duration,
                c.level,
                c.thumbnail,
                cat.name as category_name,
                'course' as content_type,
                c.created_at,
                COUNT(e.id) as enrollment_count
            FROM courses c
            LEFT JOIN course_categories cat ON c.category_id = cat.id
            LEFT JOIN enrollments e ON c.id = e.course_id
            WHERE c.status = 'published'
        ";
        
        $params = [];
        
        if (!empty($filters['category'])) {
            $sql .= " AND cat.slug = :category";
            $params['category'] = $filters['category'];
        }
        
        $sql .= " 
            GROUP BY c.id 
            ORDER BY c.is_featured DESC, enrollment_count DESC, c.created_at DESC 
            LIMIT 12
        ";
        
        return Database::query($sql, $params)->fetchAll();
    }
    
    /**
     * Get popular services
     */
    private function getPopularServices(array $filters): array
    {
        $sql = "
            SELECT 
                s.id,
                s.title,
                s.slug,
                s.description,
                s.short_description,
                s.duration,
                s.price_range,
                s.features,
                s.is_featured,
                cat.name as category_name,
                'service' as content_type,
                s.created_at
            FROM services s
            LEFT JOIN service_categories cat ON s.category_id = cat.id
            WHERE s.status = 'active'
        ";
        
        $params = [];
        
        if (!empty($filters['service_category'])) {
            $sql .= " AND cat.slug = :service_category";
            $params['service_category'] = $filters['service_category'];
        }
        
        $sql .= " ORDER BY s.is_featured DESC, s.created_at DESC LIMIT 8";
        
        return Database::query($sql, $params)->fetchAll();
    }
    
    /**
     * Score and sort results by relevance
     */
    private function scoreAndSortResults(array $results, string $query): array
    {
        $scoredResults = [];
        
        foreach (['courses', 'services', 'blog_posts'] as $type) {
            foreach ($results[$type] as $item) {
                $score = $this->calculateRelevanceScore($item, $query);
                $item['relevance_score'] = $score;
                $scoredResults[] = $item;
            }
        }
        
        // Sort by relevance score
        usort($scoredResults, function($a, $b) {
            if ($a['relevance_score'] == $b['relevance_score']) {
                return $b['is_featured'] <=> $a['is_featured'];
            }
            return $b['relevance_score'] <=> $a['relevance_score'];
        });
        
        // Reorganize by type but maintain relevance order
        $organized = ['courses' => [], 'services' => [], 'blog_posts' => [], 'all' => $scoredResults];
        
        foreach ($scoredResults as $item) {
            $type = $item['content_type'] === 'blog_post' ? 'blog_posts' : $item['content_type'] . 's';
            $organized[$type][] = $item;
        }
        
        $organized['total_count'] = count($scoredResults);
        
        return $organized;
    }
    
    /**
     * Calculate relevance score for search results
     */
    private function calculateRelevanceScore(array $item, string $query): float
    {
        $score = 0;
        $queryLower = strtolower($query);
        
        // Title match (highest weight)
        if (stripos($item['title'], $query) !== false) {
            $score += 10;
            if (stripos($item['title'], $query) === 0) {
                $score += 5; // Starts with query
            }
        }
        
        // Category match
        if (!empty($item['category_name']) && stripos($item['category_name'], $query) !== false) {
            $score += 8;
        }
        
        // Short description match
        if (!empty($item['short_description']) && stripos($item['short_description'], $query) !== false) {
            $score += 5;
        }
        
        // Description match
        if (!empty($item['description']) && stripos($item['description'], $query) !== false) {
            $score += 3;
        }
        
        // Featured content bonus
        if (!empty($item['is_featured'])) {
            $score += 2;
        }
        
        // Content type bonus (courses slightly higher for educational platform)
        if ($item['content_type'] === 'course') {
            $score += 1;
        }
        
        return $score;
    }
    
    /**
     * Get search suggestions
     */
    public function getSuggestions(string $query): array
    {
        if (strlen($query) < 2) {
            return [];
        }
        
        $suggestions = [];
        
        // Course titles
        $sql = "SELECT DISTINCT title FROM courses WHERE title LIKE :query AND status = 'published' LIMIT 5";
        $courseSuggestions = Database::query($sql, ['query' => "%{$query}%"])->fetchAll();
        
        // Service titles  
        $sql = "SELECT DISTINCT title FROM services WHERE title LIKE :query AND status = 'active' LIMIT 5";
        $serviceSuggestions = Database::query($sql, ['query' => "%{$query}%"])->fetchAll();
        
        // Category names
        $sql = "SELECT DISTINCT name as title FROM course_categories WHERE name LIKE :query LIMIT 3";
        $categorySuggestions = Database::query($sql, ['query' => "%{$query}%"])->fetchAll();
        
        $suggestions = array_merge(
            array_column($courseSuggestions, 'title'),
            array_column($serviceSuggestions, 'title'),
            array_column($categorySuggestions, 'title')
        );
        
        return array_unique(array_slice($suggestions, 0, 8));
    }
    
    /**
     * Get related content for cross-promotion
     */
    public function getRelatedContent(string $contentType, int $contentId): array
    {
        if ($contentType === 'course') {
            return $this->getRelatedServices($contentId);
        } elseif ($contentType === 'service') {
            return $this->getRelatedCourses($contentId);
        }
        
        return [];
    }
    
    /**
     * Get services related to a course
     */
    private function getRelatedServices(int $courseId): array
    {
        $sql = "
            SELECT s.*, sc.name as category_name FROM services s
            LEFT JOIN service_categories sc ON s.category_id = sc.id
            INNER JOIN courses c ON (
                s.related_course_id = c.id 
                OR s.category_id = c.category_id
            )
            WHERE c.id = :course_id AND s.status = 'active'
            LIMIT 3
        ";
        
        return Database::query($sql, ['course_id' => $courseId])->fetchAll();
    }
    
    /**
     * Get courses related to a service
     */
    private function getRelatedCourses(int $serviceId): array
    {
        $sql = "
            SELECT c.*, cc.name as category_name FROM courses c
            LEFT JOIN course_categories cc ON c.category_id = cc.id
            INNER JOIN services s ON (
                c.related_service_id = s.id 
                OR c.category_id = s.category_id
            )
            WHERE s.id = :service_id AND c.status = 'published'
            LIMIT 3
        ";
        
        return Database::query($sql, ['service_id' => $serviceId])->fetchAll();
    }
}
