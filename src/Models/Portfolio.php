<?php

namespace Nebatech\Models;

use Nebatech\Core\Database;
use PDO;

class Portfolio
{
    private static ?Database $db = null;
    
    private static function getDb(): Database
    {
        if (self::$db === null) {
            self::$db = Database::getInstance();
        }
        return self::$db;
    }
    
    /**
     * Get user's portfolio settings
     */
    public static function getSettings(string $userId): ?array
    {
        $db = self::getDb();
        $stmt = $db->prepare("SELECT * FROM portfolio_settings WHERE user_id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }
    
    /**
     * Update or create portfolio settings
     */
    public static function updateSettings(string $userId, array $data): bool
    {
        $db = self::getDb();
        
        // Check if settings exist
        $existing = self::getSettings($userId);
        
        if ($existing) {
            // Update
            $fields = [];
            $params = [];
            
            $allowedFields = ['bio', 'tagline', 'github_url', 'linkedin_url', 'twitter_url', 
                            'website_url', 'is_public', 'show_badges', 'show_certificates', 
                            'show_contact', 'theme'];
            
            foreach ($allowedFields as $field) {
                if (array_key_exists($field, $data)) {
                    $fields[] = "$field = ?";
                    $params[] = $data[$field];
                }
            }
            
            if (empty($fields)) {
                return false;
            }
            
            $params[] = $userId;
            $sql = "UPDATE portfolio_settings SET " . implode(', ', $fields) . " WHERE user_id = ?";
            $stmt = $db->prepare($sql);
            return $stmt->execute($params);
            
        } else {
            // Create
            $stmt = $db->prepare("
                INSERT INTO portfolio_settings 
                (user_id, bio, tagline, github_url, linkedin_url, twitter_url, website_url, 
                 is_public, show_badges, show_certificates, show_contact, theme)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            
            return $stmt->execute([
                $userId,
                $data['bio'] ?? null,
                $data['tagline'] ?? null,
                $data['github_url'] ?? null,
                $data['linkedin_url'] ?? null,
                $data['twitter_url'] ?? null,
                $data['website_url'] ?? null,
                $data['is_public'] ?? true,
                $data['show_badges'] ?? true,
                $data['show_certificates'] ?? true,
                $data['show_contact'] ?? true,
                $data['theme'] ?? 'default'
            ]);
        }
    }
    
    /**
     * Get user's portfolio items
     */
    public static function getItems(string $userId, bool $publicOnly = false): array
    {
        $db = self::getDb();
        
        $sql = "
            SELECT pi.*, 
                   s.file_path, s.score, s.max_score, s.status,
                   a.title as assignment_title,
                   l.title as lesson_title,
                   c.title as course_title, c.slug as course_slug
            FROM portfolio_items pi
            JOIN submissions s ON pi.submission_id = s.id
            JOIN assignments a ON s.assignment_id = a.id
            JOIN lessons l ON a.lesson_id = l.id
            JOIN modules m ON l.module_id = m.id
            JOIN courses c ON m.course_id = c.id
            WHERE pi.user_id = ?
        ";
        
        if ($publicOnly) {
            $sql .= " AND pi.is_public = 1";
        }
        
        $sql .= " ORDER BY pi.display_order ASC, pi.created_at DESC";
        
        $stmt = $db->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Get portfolio item by ID
     */
    public static function getItemById(string $id): ?array
    {
        $db = self::getDb();
        $stmt = $db->prepare("
            SELECT pi.*, 
                   s.file_path, s.code, s.score, s.max_score,
                   a.title as assignment_title,
                   u.first_name, u.last_name
            FROM portfolio_items pi
            JOIN submissions s ON pi.submission_id = s.id
            JOIN assignments a ON s.assignment_id = a.id
            JOIN users u ON pi.user_id = u.id
            WHERE pi.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }
    
    /**
     * Add item to portfolio
     */
    public static function addItem(string $userId, string $submissionId, array $data = []): ?string
    {
        $db = self::getDb();
        $itemId = self::generateUUID();
        
        // Get max display order
        $stmt = $db->prepare("SELECT COALESCE(MAX(display_order), 0) + 1 FROM portfolio_items WHERE user_id = ?");
        $stmt->execute([$userId]);
        $displayOrder = $stmt->fetchColumn();
        
        $stmt = $db->prepare("
            INSERT INTO portfolio_items 
            (id, user_id, submission_id, title, description, thumbnail_path, 
             is_featured, is_public, display_order)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        
        $success = $stmt->execute([
            $itemId,
            $userId,
            $submissionId,
            $data['title'] ?? 'Untitled Project',
            $data['description'] ?? null,
            $data['thumbnail_path'] ?? null,
            $data['is_featured'] ?? false,
            $data['is_public'] ?? true,
            $displayOrder
        ]);
        
        return $success ? $itemId : null;
    }
    
    /**
     * Update portfolio item
     */
    public static function updateItem(string $itemId, array $data): bool
    {
        $db = self::getDb();
        
        $fields = [];
        $params = [];
        
        $allowedFields = ['title', 'description', 'thumbnail_path', 'is_featured', 
                         'is_public', 'display_order'];
        
        foreach ($allowedFields as $field) {
            if (array_key_exists($field, $data)) {
                $fields[] = "$field = ?";
                $params[] = $data[$field];
            }
        }
        
        if (empty($fields)) {
            return false;
        }
        
        $params[] = $itemId;
        $sql = "UPDATE portfolio_items SET " . implode(', ', $fields) . " WHERE id = ?";
        $stmt = $db->prepare($sql);
        return $stmt->execute($params);
    }
    
    /**
     * Delete portfolio item
     */
    public static function deleteItem(string $itemId): bool
    {
        $db = self::getDb();
        $stmt = $db->prepare("DELETE FROM portfolio_items WHERE id = ?");
        return $stmt->execute([$itemId]);
    }
    
    /**
     * Increment view count
     */
    public static function incrementViews(string $itemId): bool
    {
        $db = self::getDb();
        $stmt = $db->prepare("UPDATE portfolio_items SET views = views + 1 WHERE id = ?");
        return $stmt->execute([$itemId]);
    }
    
    /**
     * Get featured items
     */
    public static function getFeaturedItems(string $userId): array
    {
        $db = self::getDb();
        $stmt = $db->prepare("
            SELECT pi.*, s.score, s.max_score
            FROM portfolio_items pi
            JOIN submissions s ON pi.submission_id = s.id
            WHERE pi.user_id = ? AND pi.is_featured = 1 AND pi.is_public = 1
            ORDER BY pi.display_order ASC
            LIMIT 3
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Get complete portfolio data for user
     */
    public static function getCompletePortfolio(string $userId): array
    {
        $db = self::getDb();
        
        // Get user info
        $stmt = $db->prepare("SELECT id, first_name, last_name, email, avatar_url, created_at FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$user) {
            return [];
        }
        
        // Get settings
        $settings = self::getSettings($userId);
        
        // Get portfolio items
        $items = self::getItems($userId, true); // Public only
        
        // Get certificates
        $certificates = Certificate::getUserCertificates($userId);
        
        // Get badges
        $badges = Badge::getUserBadges($userId);
        $badgeStats = Badge::getUserStats($userId);
        
        return [
            'user' => $user,
            'settings' => $settings,
            'items' => $items,
            'certificates' => $certificates,
            'badges' => $badges,
            'badge_stats' => $badgeStats
        ];
    }
    
    /**
     * Check if submission is in portfolio
     */
    public static function hasSubmission(string $userId, string $submissionId): bool
    {
        $db = self::getDb();
        $stmt = $db->prepare("
            SELECT COUNT(*) FROM portfolio_items 
            WHERE user_id = ? AND submission_id = ?
        ");
        $stmt->execute([$userId, $submissionId]);
        return $stmt->fetchColumn() > 0;
    }
    
    /**
     * Generate UUID v4
     */
    private static function generateUUID(): string
    {
        $data = random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
}
