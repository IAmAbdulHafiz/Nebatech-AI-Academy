<?php
/**
 * Community Resource Model
 * Handles file/link sharing in community
 */

namespace Nebatech\Models;

use Nebatech\Core\Model;

class CommunityResource extends Model
{
    protected $table = 'community_resources';

    /**
     * Get resource author
     */
    public function author()
    {
        return $this->db->query(
            "SELECT u.*, up.total_xp, up.bio
             FROM users u
             LEFT JOIN user_profiles up ON u.id = up.user_id
             WHERE u.id = ?",
            [$this->user_id]
        )->fetch();
    }

    /**
     * Get resource category
     */
    public function category()
    {
        return $this->db->query(
            "SELECT * FROM discussion_categories WHERE id = ?",
            [$this->category_id]
        )->fetch();
    }

    /**
     * Create new resource
     */
    public static function createResource($data)
    {
        $db = static::getDatabase();
        
        // Generate UUID
        $uuid = sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );

        // Encode tags if array
        if (isset($data['tags']) && is_array($data['tags'])) {
            $data['tags'] = json_encode($data['tags']);
        }

        // Insert resource
        $db->query(
            "INSERT INTO community_resources 
             (uuid, user_id, category_id, title, description, type, url, file_path, 
              file_size, file_type, thumbnail, tags, is_approved) 
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
            [
                $uuid,
                $data['user_id'],
                $data['category_id'],
                $data['title'],
                $data['description'],
                $data['type'],
                $data['url'] ?? null,
                $data['file_path'] ?? null,
                $data['file_size'] ?? null,
                $data['file_type'] ?? null,
                $data['thumbnail'] ?? null,
                $data['tags'] ?? null,
                true // Auto-approve for now
            ]
        );

        // Award XP
        $profile = UserProfile::getOrCreate($data['user_id']);
        $profile->addXP(15, 'resource_shared', 'Shared a resource');

        // Check for Content Creator badge (10 approved resources)
        $resourceCount = $db->query(
            "SELECT COUNT(*) as count FROM community_resources 
             WHERE user_id = ? AND is_approved = TRUE",
            [$data['user_id']]
        )->fetch()['count'];

        if ($resourceCount >= 10) {
            $profile->awardBadge('content-creator');
        }

        return $uuid;
    }

    /**
     * Increment download count
     */
    public function incrementDownloads()
    {
        $this->db->query(
            "UPDATE community_resources 
             SET downloads_count = downloads_count + 1 
             WHERE id = ?",
            [$this->id]
        );
    }

    /**
     * Increment view count
     */
    public function incrementViews()
    {
        $this->db->query(
            "UPDATE community_resources 
             SET views_count = views_count + 1 
             WHERE id = ?",
            [$this->id]
        );
    }

    /**
     * Get popular resources
     */
    public static function getPopular($limit = 10)
    {
        $db = static::getDatabase();
        
        return $db->query(
            "SELECT cr.*, u.first_name, u.last_name, u.avatar,
                    dc.name as category_name, dc.color as category_color,
                    (cr.downloads_count * 3 + cr.views_count) as popularity_score
             FROM community_resources cr
             INNER JOIN users u ON cr.user_id = u.id
             INNER JOIN discussion_categories dc ON cr.category_id = dc.id
             WHERE cr.is_approved = TRUE
             ORDER BY popularity_score DESC, cr.created_at DESC
             LIMIT ?",
            [$limit]
        )->fetchAll();
    }

    /**
     * Search resources
     */
    public static function search($query, $type = null, $categoryId = null)
    {
        $db = static::getDatabase();
        
        $sql = "SELECT cr.*, u.first_name, u.last_name, u.avatar,
                       dc.name as category_name, dc.color as category_color
                FROM community_resources cr
                INNER JOIN users u ON cr.user_id = u.id
                INNER JOIN discussion_categories dc ON cr.category_id = dc.id
                WHERE cr.is_approved = TRUE
                AND (cr.title LIKE ? OR cr.description LIKE ?)";
        
        $params = ["%$query%", "%$query%"];
        
        if ($type) {
            $sql .= " AND cr.type = ?";
            $params[] = $type;
        }
        
        if ($categoryId) {
            $sql .= " AND cr.category_id = ?";
            $params[] = $categoryId;
        }
        
        $sql .= " ORDER BY cr.created_at DESC LIMIT 50";
        
        return $db->query($sql, $params)->fetchAll();
    }
}
