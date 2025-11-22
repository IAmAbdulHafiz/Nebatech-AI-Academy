<?php

namespace Nebatech\Models;

use Nebatech\Core\Model;

class UserProfile extends Model
{
    protected string $table = 'user_profiles';
    
    protected array $fillable = [
        'user_id',
        'bio',
        'location',
        'website',
        'github_url',
        'linkedin_url',
        'twitter_handle',
        'skills',
        'interests',
        'total_xp',
        'current_streak',
        'longest_streak',
        'last_active_date'
    ];

    /**
     * Get user information
     */
    public function user()
    {
        return $this->db->query(
            "SELECT u.* FROM users u 
             INNER JOIN {$this->table} up ON u.id = up.user_id 
             WHERE up.id = ?",
            [$this->id]
        )->fetch();
    }

    /**
     * Get or create profile for user
     */
    public static function getOrCreate(int $userId): ?self
    {
        $instance = new static();
        
        // Try to find existing profile
        $profile = $instance->db->query(
            "SELECT * FROM {$instance->table} WHERE user_id = ?",
            [$userId]
        )->fetch();

        if ($profile) {
            return $instance->hydrate($profile);
        }

        // Create new profile
        $profileId = $instance->db->insert($instance->table, [
            'user_id' => $userId,
            'total_xp' => 0,
            'current_streak' => 0,
            'longest_streak' => 0,
            'last_active_date' => date('Y-m-d')
        ]);

        return $instance->find($profileId);
    }

    /**
     * Add XP points
     */
    public function addXP(int $amount, string $action, string $description = ''): bool
    {
        // Update profile total XP
        $this->db->query(
            "UPDATE {$this->table} SET total_xp = total_xp + ? WHERE id = ?",
            [$amount, $this->id]
        );

        // Log the transaction
        $this->db->insert('xp_transactions', [
            'user_id' => $this->user_id,
            'amount' => $amount,
            'action' => $action,
            'description' => $description
        ]);

        return true;
    }

    /**
     * Update streak
     */
    public function updateStreak(): void
    {
        $lastActive = $this->last_active_date;
        $today = date('Y-m-d');
        
        if ($lastActive === $today) {
            return; // Already updated today
        }

        $yesterday = date('Y-m-d', strtotime('-1 day'));
        
        if ($lastActive === $yesterday) {
            // Continue streak
            $newStreak = $this->current_streak + 1;
            $longestStreak = max($this->longest_streak, $newStreak);
            
            $this->db->query(
                "UPDATE {$this->table} 
                 SET current_streak = ?, 
                     longest_streak = ?,
                     last_active_date = ?
                 WHERE id = ?",
                [$newStreak, $longestStreak, $today, $this->id]
            );

            // Award XP for streak
            $this->addXP(5, 'daily_login', "Day {$newStreak} streak");
            
            // Check for streak badges
            if ($newStreak === 7) {
                $this->awardBadge('7-day-streak');
            } elseif ($newStreak === 30) {
                $this->awardBadge('30-day-streak');
            }
        } else {
            // Streak broken, reset
            $this->db->query(
                "UPDATE {$this->table} 
                 SET current_streak = 1,
                     last_active_date = ?
                 WHERE id = ?",
                [$today, $this->id]
            );
        }
    }

    /**
     * Award a badge
     */
    public function awardBadge(string $badgeSlug): bool
    {
        // Check if badge exists
        $badge = $this->db->query(
            "SELECT * FROM badges WHERE slug = ?",
            [$badgeSlug]
        )->fetch();

        if (!$badge) {
            return false;
        }

        // Check if user already has badge
        $exists = $this->db->query(
            "SELECT id FROM user_badges WHERE user_id = ? AND badge_id = ?",
            [$this->user_id, $badge['id']]
        )->fetch();

        if ($exists) {
            return false;
        }

        // Award badge
        $this->db->insert('user_badges', [
            'user_id' => $this->user_id,
            'badge_id' => $badge['id']
        ]);

        // Add XP from badge
        if ($badge['xp_value'] > 0) {
            $this->addXP($badge['xp_value'], 'badge_earned', "Earned {$badge['name']} badge");
        }

        // Send notification
        $this->db->insert('notifications', [
            'user_id' => $this->user_id,
            'type' => 'badge_earned',
            'title' => 'New Badge Earned!',
            'message' => "You earned the '{$badge['name']}' badge!",
            'data' => json_encode(['badge_id' => $badge['id']])
        ]);

        return true;
    }

    /**
     * Get user's badges
     */
    public function getBadges(): array
    {
        return $this->db->query(
            "SELECT b.*, ub.earned_at 
             FROM badges b
             INNER JOIN user_badges ub ON b.id = ub.badge_id
             WHERE ub.user_id = ?
             ORDER BY ub.earned_at DESC",
            [$this->user_id]
        )->fetchAll();
    }

    /**
     * Get leaderboard
     */
    public static function getLeaderboard(string $period = 'all', int $limit = 10): array
    {
        $instance = new static();
        
        $sql = "SELECT up.*, u.first_name, u.last_name, u.avatar,
                       COUNT(DISTINCT ub.badge_id) as badges_count
                FROM {$instance->table} up
                INNER JOIN users u ON up.user_id = u.id
                LEFT JOIN user_badges ub ON up.user_id = ub.user_id";
        
        $params = [];
        
        if ($period === 'weekly') {
            $sql .= " LEFT JOIN xp_transactions xt ON up.user_id = xt.user_id
                      WHERE xt.created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)";
        } elseif ($period === 'monthly') {
            $sql .= " LEFT JOIN xp_transactions xt ON up.user_id = xt.user_id
                      WHERE xt.created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)";
        }
        
        $sql .= " GROUP BY up.id
                  ORDER BY up.total_xp DESC
                  LIMIT ?";
        
        $params[] = $limit;
        
        return $instance->db->query($sql, $params)->fetchAll();
    }
}
