<?php

namespace Nebatech\Models;

use Nebatech\Core\Model;
use Nebatech\Core\Database;

class Portfolio extends Model
{
    protected string $table = 'portfolios';
    protected string $primaryKey = 'id';

    /**
     * Create portfolio entry
     */
    public static function create(array $data): ?int
    {
        // Encode technologies if array
        if (isset($data['technologies']) && is_array($data['technologies'])) {
            $data['technologies'] = json_encode($data['technologies']);
        }

        try {
            return Database::insert('portfolios', $data);
        } catch (\Exception $e) {
            error_log("Portfolio creation failed: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Get user's portfolio
     */
    public static function getUserPortfolio(int $userId, bool $publicOnly = false): array
    {
        $sql = "SELECT p.*, 
                       s.content as submission_content,
                       s.file_path,
                       a.title as assignment_title,
                       l.title as lesson_title,
                       c.title as course_title
                FROM " . 'portfolios' . " p
                LEFT JOIN submissions s ON p.submission_id = s.id
                LEFT JOIN assignments a ON s.assignment_id = a.id
                LEFT JOIN lessons l ON a.lesson_id = l.id
                LEFT JOIN modules m ON l.module_id = m.id
                LEFT JOIN courses c ON m.course_id = c.id
                WHERE p.user_id = :user_id";

        $params = ['user_id' => $userId];

        if ($publicOnly) {
            $sql .= " AND p.is_public = 1";
        }

        $sql .= " ORDER BY p.featured DESC, p.created_at DESC";

        return Database::fetchAll($sql, $params);
    }

    /**
     * Get public portfolios
     */
    public static function getPublicPortfolios(int $limit = 20): array
    {
        $sql = "SELECT p.*, 
                       u.first_name,
                       u.last_name,
                       u.avatar,
                       c.title as course_title
                FROM " . 'portfolios' . " p
                INNER JOIN users u ON p.user_id = u.id
                LEFT JOIN submissions s ON p.submission_id = s.id
                LEFT JOIN assignments a ON s.assignment_id = a.id
                LEFT JOIN lessons l ON a.lesson_id = l.id
                LEFT JOIN modules m ON l.module_id = m.id
                LEFT JOIN courses c ON m.course_id = c.id
                WHERE p.is_public = 1
                ORDER BY p.featured DESC, p.created_at DESC
                LIMIT :limit";

        return Database::fetchAll($sql, ['limit' => $limit]);
    }

    /**
     * Get featured portfolios
     */
    public static function getFeaturedPortfolios(int $limit = 10): array
    {
        $sql = "SELECT p.*, 
                       u.first_name,
                       u.last_name,
                       u.avatar,
                       c.title as course_title
                FROM " . 'portfolios' . " p
                INNER JOIN users u ON p.user_id = u.id
                LEFT JOIN submissions s ON p.submission_id = s.id
                LEFT JOIN assignments a ON s.assignment_id = a.id
                LEFT JOIN lessons l ON a.lesson_id = l.id
                LEFT JOIN modules m ON l.module_id = m.id
                LEFT JOIN courses c ON m.course_id = c.id
                WHERE p.is_public = 1 AND p.featured = 1
                ORDER BY p.created_at DESC
                LIMIT :limit";

        return Database::fetchAll($sql, ['limit' => $limit]);
    }

    /**
     * Find by ID
     */
    public static function findById(int $id): ?array
    {
        $sql = "SELECT p.*, 
                       u.first_name,
                       u.last_name,
                       s.content as submission_content,
                       s.file_path,
                       a.title as assignment_title
                FROM " . 'portfolios' . " p
                INNER JOIN users u ON p.user_id = u.id
                LEFT JOIN submissions s ON p.submission_id = s.id
                LEFT JOIN assignments a ON s.assignment_id = a.id
                WHERE p.id = :id
                LIMIT 1";

        return Database::fetch($sql, ['id' => $id]);
    }

    /**
     * Update portfolio
     */
    public static function updateById(int $id, array $data): bool
    {
        unset($data['id'], $data['user_id'], $data['submission_id'], $data['created_at']);

        // Encode technologies if array
        if (isset($data['technologies']) && is_array($data['technologies'])) {
            $data['technologies'] = json_encode($data['technologies']);
        }

        if (empty($data)) {
            return false;
        }

        $result = Database::update('portfolios', $data, 'id = :id', ['id' => $id]);
        return $result > 0;
    }

    /**
     * Delete portfolio
     */
    public static function deleteById(int $id): bool
    {
        $result = Database::delete('portfolios', 'id = :id', ['id' => $id]);
        return $result > 0;
    }

    /**
     * Toggle featured status
     */
    public static function toggleFeatured(int $id): bool
    {
        $portfolio = self::findById($id);
        if (!$portfolio) {
            return false;
        }

        $newStatus = !$portfolio['featured'];
        return self::updateById($id, ['featured' => $newStatus]);
    }

    /**
     * Get statistics
     */
    public static function getStats(int $userId): array
    {
        $sql = "SELECT 
                    COUNT(*) as total_projects,
                    SUM(CASE WHEN is_public = 1 THEN 1 ELSE 0 END) as public_projects,
                    SUM(CASE WHEN featured = 1 THEN 1 ELSE 0 END) as featured_projects
                FROM " . 'portfolios' . "
                WHERE user_id = :user_id";

        return Database::fetch($sql, ['user_id' => $userId]) ?? [
            'total_projects' => 0,
            'public_projects' => 0,
            'featured_projects' => 0
        ];
    }

    /**
     * Check if submission is already in portfolio
     */
    public static function submissionInPortfolio(int $submissionId): bool
    {
        $sql = "SELECT COUNT(*) as count FROM " . 'portfolios' . " 
                WHERE submission_id = :submission_id";
        
        $result = Database::fetch($sql, ['submission_id' => $submissionId]);
        return $result && $result['count'] > 0;
    }
}
