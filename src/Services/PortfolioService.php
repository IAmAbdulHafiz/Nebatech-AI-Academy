<?php

namespace Nebatech\Services;

use Nebatech\Core\Database;

class PortfolioService
{
    /**
     * Create portfolio entry from submission
     */
    public function createFromSubmission(int $userId, int $submissionId, array $data): ?int
    {
        // Get submission details
        $submission = $this->getSubmissionDetails($submissionId);
        
        if (!$submission || $submission['user_id'] !== $userId) {
            return null;
        }

        // Only verified submissions can be added to portfolio
        if ($submission['status'] !== 'verified') {
            return null;
        }

        $portfolioData = [
            'user_id' => $userId,
            'submission_id' => $submissionId,
            'title' => $data['title'] ?? $submission['assignment_title'],
            'description' => $data['description'] ?? '',
            'project_url' => $data['project_url'] ?? null,
            'thumbnail' => $data['thumbnail'] ?? null,
            'technologies' => json_encode($data['technologies'] ?? []),
            'is_public' => $data['is_public'] ?? true,
            'featured' => false
        ];

        try {
            return Database::insert('portfolios', $portfolioData);
        } catch (\Exception $e) {
            error_log("Portfolio creation failed: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Get user's portfolio
     */
    public function getUserPortfolio(int $userId, bool $publicOnly = false): array
    {
        $sql = "SELECT p.*, 
                       s.content as submission_content,
                       s.file_path,
                       a.title as assignment_title,
                       l.title as lesson_title,
                       c.title as course_title
                FROM portfolios p
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
     * Get public portfolios (for showcase)
     */
    public function getPublicPortfolios(int $limit = 20): array
    {
        $sql = "SELECT p.*, 
                       u.first_name,
                       u.last_name,
                       u.avatar,
                       c.title as course_title
                FROM portfolios p
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
    public function getFeaturedPortfolios(int $limit = 10): array
    {
        $sql = "SELECT p.*, 
                       u.first_name,
                       u.last_name,
                       u.avatar,
                       c.title as course_title
                FROM portfolios p
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
     * Update portfolio entry
     */
    public function update(int $portfolioId, int $userId, array $data): bool
    {
        // Verify ownership
        $portfolio = $this->findById($portfolioId);
        if (!$portfolio || $portfolio['user_id'] !== $userId) {
            return false;
        }

        // Remove fields that shouldn't be updated
        unset($data['id'], $data['user_id'], $data['submission_id'], $data['created_at']);

        // Handle technologies JSON
        if (isset($data['technologies']) && is_array($data['technologies'])) {
            $data['technologies'] = json_encode($data['technologies']);
        }

        if (empty($data)) {
            return false;
        }

        $result = Database::update('portfolios', $data, 'id = :id', ['id' => $portfolioId]);
        return $result > 0;
    }

    /**
     * Delete portfolio entry
     */
    public function delete(int $portfolioId, int $userId): bool
    {
        // Verify ownership
        $portfolio = $this->findById($portfolioId);
        if (!$portfolio || $portfolio['user_id'] !== $userId) {
            return false;
        }

        $result = Database::delete('portfolios', 'id = :id', ['id' => $portfolioId]);
        return $result > 0;
    }

    /**
     * Toggle featured status (admin only)
     */
    public function toggleFeatured(int $portfolioId): bool
    {
        $portfolio = $this->findById($portfolioId);
        if (!$portfolio) {
            return false;
        }

        $newStatus = !$portfolio['featured'];
        $result = Database::update(
            'portfolios',
            ['featured' => $newStatus],
            'id = :id',
            ['id' => $portfolioId]
        );

        return $result > 0;
    }

    /**
     * Find portfolio by ID
     */
    public function findById(int $id): ?array
    {
        $sql = "SELECT p.*, 
                       u.first_name,
                       u.last_name,
                       s.content as submission_content,
                       s.file_path,
                       a.title as assignment_title
                FROM portfolios p
                INNER JOIN users u ON p.user_id = u.id
                LEFT JOIN submissions s ON p.submission_id = s.id
                LEFT JOIN assignments a ON s.assignment_id = a.id
                WHERE p.id = :id
                LIMIT 1";

        return Database::fetch($sql, ['id' => $id]);
    }

    /**
     * Get submission details
     */
    private function getSubmissionDetails(int $submissionId): ?array
    {
        $sql = "SELECT s.*, 
                       a.title as assignment_title,
                       l.title as lesson_title
                FROM submissions s
                INNER JOIN assignments a ON s.assignment_id = a.id
                INNER JOIN lessons l ON a.lesson_id = l.id
                WHERE s.id = :id
                LIMIT 1";

        return Database::fetch($sql, ['id' => $submissionId]);
    }

    /**
     * Get portfolio statistics for user
     */
    public function getUserStats(int $userId): array
    {
        $sql = "SELECT 
                    COUNT(*) as total_projects,
                    SUM(CASE WHEN is_public = 1 THEN 1 ELSE 0 END) as public_projects,
                    SUM(CASE WHEN featured = 1 THEN 1 ELSE 0 END) as featured_projects
                FROM portfolios
                WHERE user_id = :user_id";

        return Database::fetch($sql, ['user_id' => $userId]) ?? [
            'total_projects' => 0,
            'public_projects' => 0,
            'featured_projects' => 0
        ];
    }
}
