<?php

namespace Nebatech\Models;

use Nebatech\Core\Database;
use PDO;

class Badge
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
     * Get all badges
     */
    public static function getAll(): array
    {
        $db = self::getDb();
        $stmt = $db->query("
            SELECT * FROM badges 
            ORDER BY category, points DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Get badge by ID
     */
    public static function findById(string $id): ?array
    {
        $db = self::getDb();
        $stmt = $db->prepare("SELECT * FROM badges WHERE id = ?");
        $stmt->execute([$id]);
        $badge = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($badge && isset($badge['criteria'])) {
            $badge['criteria'] = json_decode($badge['criteria'], true);
        }
        
        return $badge ?: null;
    }
    
    /**
     * Get badge by slug
     */
    public static function findBySlug(string $slug): ?array
    {
        $db = self::getDb();
        $stmt = $db->prepare("SELECT * FROM badges WHERE slug = ?");
        $stmt->execute([$slug]);
        $badge = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($badge && isset($badge['criteria'])) {
            $badge['criteria'] = json_decode($badge['criteria'], true);
        }
        
        return $badge ?: null;
    }
    
    /**
     * Get badges by category
     */
    public static function getByCategory(string $category): array
    {
        $db = self::getDb();
        $stmt = $db->prepare("
            SELECT * FROM badges 
            WHERE category = ?
            ORDER BY points DESC
        ");
        $stmt->execute([$category]);
        $badges = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($badges as &$badge) {
            if (isset($badge['criteria'])) {
                $badge['criteria'] = json_decode($badge['criteria'], true);
            }
        }
        
        return $badges;
    }
    
    /**
     * Get user's earned badges
     */
    public static function getUserBadges(string $userId): array
    {
        $db = self::getDb();
        $stmt = $db->prepare("
            SELECT b.*, ub.earned_at, ub.metadata
            FROM user_badges ub
            JOIN badges b ON ub.badge_id = b.id
            WHERE ub.user_id = ?
            ORDER BY ub.earned_at DESC
        ");
        $stmt->execute([$userId]);
        $badges = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($badges as &$badge) {
            if (isset($badge['criteria'])) {
                $badge['criteria'] = json_decode($badge['criteria'], true);
            }
            if (isset($badge['metadata'])) {
                $badge['metadata'] = json_decode($badge['metadata'], true);
            }
        }
        
        return $badges;
    }
    
    /**
     * Check if user has badge
     */
    public static function userHasBadge(string $userId, string $badgeId): bool
    {
        $db = self::getDb();
        $stmt = $db->prepare("
            SELECT COUNT(*) FROM user_badges 
            WHERE user_id = ? AND badge_id = ?
        ");
        $stmt->execute([$userId, $badgeId]);
        return $stmt->fetchColumn() > 0;
    }
    
    /**
     * Award badge to user
     */
    public static function awardBadge(string $userId, string $badgeId, ?array $metadata = null): bool
    {
        // Check if already earned
        if (self::userHasBadge($userId, $badgeId)) {
            return false; // Already has badge
        }
        
        $db = self::getDb();
        $stmt = $db->prepare("
            INSERT INTO user_badges (user_id, badge_id, metadata, earned_at)
            VALUES (?, ?, ?, NOW())
        ");
        
        return $stmt->execute([
            $userId,
            $badgeId,
            $metadata ? json_encode($metadata) : null
        ]);
    }
    
    /**
     * Get user's badge statistics
     */
    public static function getUserStats(string $userId): array
    {
        $db = self::getDb();
        
        // Total badges earned
        $stmt = $db->prepare("
            SELECT COUNT(*) as total_badges, SUM(b.points) as total_points
            FROM user_badges ub
            JOIN badges b ON ub.badge_id = b.id
            WHERE ub.user_id = ?
        ");
        $stmt->execute([$userId]);
        $stats = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Badges by category
        $stmt = $db->prepare("
            SELECT b.category, COUNT(*) as count
            FROM user_badges ub
            JOIN badges b ON ub.badge_id = b.id
            WHERE ub.user_id = ?
            GROUP BY b.category
        ");
        $stmt->execute([$userId]);
        $byCategory = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return [
            'total_badges' => (int)$stats['total_badges'],
            'total_points' => (int)$stats['total_points'],
            'by_category' => $byCategory
        ];
    }
    
    /**
     * Get all available badges with user's earned status
     */
    public static function getAllWithUserStatus(string $userId): array
    {
        $db = self::getDb();
        $stmt = $db->prepare("
            SELECT 
                b.*,
                CASE WHEN ub.id IS NOT NULL THEN 1 ELSE 0 END as earned,
                ub.earned_at
            FROM badges b
            LEFT JOIN user_badges ub ON b.id = ub.badge_id AND ub.user_id = ?
            ORDER BY b.category, b.points DESC
        ");
        $stmt->execute([$userId]);
        $badges = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($badges as &$badge) {
            if (isset($badge['criteria'])) {
                $badge['criteria'] = json_decode($badge['criteria'], true);
            }
            $badge['earned'] = (bool)$badge['earned'];
        }
        
        return $badges;
    }
    
    /**
     * Check and award badges based on user activity
     */
    public static function checkAndAwardBadges(string $userId): array
    {
        $awarded = [];
        
        // Check for "First Steps" - completed first lesson
        $firstSteps = self::findBySlug('first-steps');
        if ($firstSteps && !self::userHasBadge($userId, $firstSteps['id'])) {
            $db = self::getDb();
            $stmt = $db->prepare("
                SELECT COUNT(*) FROM lesson_progress 
                WHERE user_id = ? AND completed = 1
            ");
            $stmt->execute([$userId]);
            if ($stmt->fetchColumn() > 0) {
                if (self::awardBadge($userId, $firstSteps['id'])) {
                    $awarded[] = $firstSteps;
                }
            }
        }
        
        // Check for "Code Warrior" - first assignment submission
        $codeWarrior = self::findBySlug('code-warrior');
        if ($codeWarrior && !self::userHasBadge($userId, $codeWarrior['id'])) {
            $db = self::getDb();
            $stmt = $db->prepare("
                SELECT COUNT(*) FROM submissions 
                WHERE user_id = ?
            ");
            $stmt->execute([$userId]);
            if ($stmt->fetchColumn() > 0) {
                if (self::awardBadge($userId, $codeWarrior['id'])) {
                    $awarded[] = $codeWarrior;
                }
            }
        }
        
        // Check for "Perfect Score" - 100% on assignment
        $perfectScore = self::findBySlug('perfect-score');
        if ($perfectScore && !self::userHasBadge($userId, $perfectScore['id'])) {
            $db = self::getDb();
            $stmt = $db->prepare("
                SELECT id, assignment_id FROM submissions 
                WHERE user_id = ? AND score >= max_score AND status = 'graded'
                LIMIT 1
            ");
            $stmt->execute([$userId]);
            $submission = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($submission) {
                if (self::awardBadge($userId, $perfectScore['id'], ['submission_id' => $submission['id']])) {
                    $awarded[] = $perfectScore;
                }
            }
        }
        
        // Check for "Course Completer" - first course completion
        $courseCompleter = self::findBySlug('course-completer');
        if ($courseCompleter && !self::userHasBadge($userId, $courseCompleter['id'])) {
            $db = self::getDb();
            $stmt = $db->prepare("
                SELECT COUNT(*) FROM certificates 
                WHERE user_id = ?
            ");
            $stmt->execute([$userId]);
            if ($stmt->fetchColumn() > 0) {
                if (self::awardBadge($userId, $courseCompleter['id'])) {
                    $awarded[] = $courseCompleter;
                }
            }
        }
        
        return $awarded;
    }
}
