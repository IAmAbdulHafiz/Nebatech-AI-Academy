<?php

namespace Nebatech\Models;

use Nebatech\Core\Model;

class DiscussionPost extends Model
{
    protected string $table = 'discussion_posts';
    
    protected array $fillable = [
        'uuid',
        'category_id',
        'user_id',
        'course_id',
        'title',
        'content',
        'type',
        'tags',
        'is_pinned',
        'is_locked',
        'is_solved'
    ];

    /**
     * Get post author
     */
    public function author()
    {
        return $this->db->query(
            "SELECT u.id, u.first_name, u.last_name, u.avatar, u.role,
                    up.total_xp, up.bio
             FROM users u
             LEFT JOIN user_profiles up ON u.id = up.user_id
             WHERE u.id = ?",
            [$this->user_id]
        )->fetch();
    }

    /**
     * Get post category
     */
    public function category()
    {
        return $this->db->query(
            "SELECT * FROM discussion_categories WHERE id = ?",
            [$this->category_id]
        )->fetch();
    }

    /**
     * Get comments
     */
    public function comments(int $limit = null)
    {
        $sql = "SELECT dc.*, u.first_name, u.last_name, u.avatar, u.role,
                       up.total_xp
                FROM discussion_comments dc
                INNER JOIN users u ON dc.user_id = u.id
                LEFT JOIN user_profiles up ON u.id = up.user_id
                WHERE dc.post_id = ?
                ORDER BY dc.is_solution DESC, dc.created_at ASC";
        
        if ($limit) {
            $sql .= " LIMIT ?";
            return $this->db->query($sql, [$this->id, $limit])->fetchAll();
        }
        
        return $this->db->query($sql, [$this->id])->fetchAll();
    }

    /**
     * Create new post
     */
    public static function createPost(array $data): ?self
    {
        $instance = new static();
        
        $data['uuid'] = $instance->generateUUID();
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['last_activity_at'] = date('Y-m-d H:i:s');
        
        if (isset($data['tags']) && is_array($data['tags'])) {
            $data['tags'] = json_encode($data['tags']);
        }
        
        $postId = $instance->db->insert($instance->table, $data);
        
        if ($postId) {
            // Award XP
            $profile = UserProfile::getOrCreate($data['user_id']);
            $profile->addXP(10, 'create_post', 'Created discussion post');
            
            // Check for first post badge
            $postCount = $instance->db->query(
                "SELECT COUNT(*) as count FROM {$instance->table} WHERE user_id = ?",
                [$data['user_id']]
            )->fetch()['count'];
            
            if ($postCount == 1) {
                $profile->awardBadge('first-post');
            }
            
            return $instance->find($postId);
        }
        
        return null;
    }

    /**
     * Add comment
     */
    public function addComment(int $userId, string $content, ?int $parentId = null): ?array
    {
        $commentId = $this->db->insert('discussion_comments', [
            'uuid' => $this->generateUUID(),
            'post_id' => $this->id,
            'user_id' => $userId,
            'parent_id' => $parentId,
            'content' => $content
        ]);
        
        if ($commentId) {
            // Update post comment count and activity
            $this->db->query(
                "UPDATE {$this->table} 
                 SET comments_count = comments_count + 1,
                     last_activity_at = NOW()
                 WHERE id = ?",
                [$this->id]
            );
            
            // Award XP
            $profile = UserProfile::getOrCreate($userId);
            $profile->addXP(5, 'create_comment', 'Posted a comment');
            
            // Check for first comment badge
            $commentCount = $this->db->query(
                "SELECT COUNT(*) as count FROM discussion_comments WHERE user_id = ?",
                [$userId]
            )->fetch()['count'];
            
            if ($commentCount == 1) {
                $profile->awardBadge('first-comment');
            }
            
            // Notify post author (if not commenting on own post)
            if ($this->user_id != $userId) {
                $this->db->insert('notifications', [
                    'user_id' => $this->user_id,
                    'type' => 'comment_added',
                    'title' => 'New comment on your post',
                    'message' => "Someone commented on: {$this->title}",
                    'link' => "/community/post/{$this->uuid}#comment-{$commentId}"
                ]);
            }
            
            return $this->db->query(
                "SELECT * FROM discussion_comments WHERE id = ?",
                [$commentId]
            )->fetch();
        }
        
        return null;
    }

    /**
     * Toggle like
     */
    public function toggleLike(int $userId): bool
    {
        $existing = $this->db->query(
            "SELECT id FROM discussion_likes 
             WHERE user_id = ? AND likeable_type = 'post' AND likeable_id = ?",
            [$userId, $this->id]
        )->fetch();
        
        if ($existing) {
            // Unlike
            $this->db->delete('discussion_likes', $existing['id']);
            $this->db->query(
                "UPDATE {$this->table} SET likes_count = likes_count - 1 WHERE id = ?",
                [$this->id]
            );
            return false;
        } else {
            // Like
            $this->db->insert('discussion_likes', [
                'user_id' => $userId,
                'likeable_type' => 'post',
                'likeable_id' => $this->id
            ]);
            $this->db->query(
                "UPDATE {$this->table} SET likes_count = likes_count + 1 WHERE id = ?",
                [$this->id]
            );
            
            // Award XP to post author
            if ($this->user_id != $userId) {
                $profile = UserProfile::getOrCreate($this->user_id);
                $profile->addXP(2, 'like_received', 'Post liked');
            }
            
            return true;
        }
    }

    /**
     * Mark as solved
     */
    public function markSolved(int $commentId): bool
    {
        // Mark comment as solution
        $this->db->query(
            "UPDATE discussion_comments SET is_solution = TRUE WHERE id = ?",
            [$commentId]
        );
        
        // Mark post as solved
        $this->db->query(
            "UPDATE {$this->table} SET is_solved = TRUE WHERE id = ?",
            [$this->id]
        );
        
        // Award XP to comment author
        $comment = $this->db->query(
            "SELECT user_id FROM discussion_comments WHERE id = ?",
            [$commentId]
        )->fetch();
        
        if ($comment) {
            $profile = UserProfile::getOrCreate($comment['user_id']);
            $profile->addXP(20, 'solution_marked', 'Answer marked as solution');
            
            // Check for helpful peer badge
            $solutionCount = $this->db->query(
                "SELECT COUNT(*) as count FROM discussion_comments 
                 WHERE user_id = ? AND is_solution = TRUE",
                [$comment['user_id']]
            )->fetch()['count'];
            
            if ($solutionCount >= 5) {
                $profile->awardBadge('helpful-peer');
            }
        }
        
        return true;
    }

    /**
     * Increment view count
     */
    public function incrementViews(): void
    {
        $this->db->query(
            "UPDATE {$this->table} SET views_count = views_count + 1 WHERE id = ?",
            [$this->id]
        );
    }

    /**
     * Get trending posts
     */
    public static function getTrending(int $limit = 10): array
    {
        $instance = new static();
        
        return $instance->db->query(
            "SELECT dp.*, u.first_name, u.last_name, u.avatar,
                    dc.name as category_name, dc.color as category_color,
                    (dp.likes_count * 3 + dp.comments_count * 2 + dp.views_count) as trending_score
             FROM {$instance->table} dp
             INNER JOIN users u ON dp.user_id = u.id
             INNER JOIN discussion_categories dc ON dp.category_id = dc.id
             WHERE dp.created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)
             ORDER BY trending_score DESC
             LIMIT ?",
            [$limit]
        )->fetchAll();
    }

    /**
     * Search posts
     */
    public static function search(string $query, ?int $categoryId = null): array
    {
        $instance = new static();
        
        $sql = "SELECT dp.*, u.first_name, u.last_name, u.avatar,
                       dc.name as category_name, dc.color as category_color
                FROM {$instance->table} dp
                INNER JOIN users u ON dp.user_id = u.id
                INNER JOIN discussion_categories dc ON dp.category_id = dc.id
                WHERE MATCH(dp.title, dp.content) AGAINST(? IN NATURAL LANGUAGE MODE)";
        
        $params = [$query];
        
        if ($categoryId) {
            $sql .= " AND dp.category_id = ?";
            $params[] = $categoryId;
        }
        
        $sql .= " ORDER BY dp.last_activity_at DESC LIMIT 50";
        
        return $instance->db->query($sql, $params)->fetchAll();
    }
}
