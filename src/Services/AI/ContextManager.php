<?php

namespace Nebatech\Services\AI;

use Nebatech\Core\Database;

/**
 * Context Manager for AI Tutor
 * Manages conversation context, student profiles, and learning history
 */
class ContextManager
{
    /**
     * Get student's learning profile
     */
    public function getStudentProfile(int $userId): array
    {
        $profile = Database::fetch(
            "SELECT * FROM ai_learning_profiles WHERE user_id = ?",
            [$userId]
        );

        if (!$profile) {
            // Create default profile
            $this->createDefaultProfile($userId);
            $profile = [
                'user_id' => $userId,
                'learning_style' => 'mixed',
                'preferred_explanation_style' => 'examples',
                'preferred_difficulty' => 'adaptive',
                'total_ai_interactions' => 0,
                'total_practice_completed' => 0,
                'average_practice_score' => 0,
                'strengths' => [],
                'weaknesses' => [],
                'topics_mastered' => [],
                'topics_struggling' => []
            ];
        } else {
            // Decode JSON fields
            $profile['strengths'] = json_decode($profile['strengths'] ?? '[]', true) ?: [];
            $profile['weaknesses'] = json_decode($profile['weaknesses'] ?? '[]', true) ?: [];
            $profile['topics_mastered'] = json_decode($profile['topics_mastered'] ?? '[]', true) ?: [];
            $profile['topics_struggling'] = json_decode($profile['topics_struggling'] ?? '[]', true) ?: [];
        }

        // Enrich with enrollment data
        $enrollmentStats = $this->getEnrollmentStats($userId);
        $profile = array_merge($profile, $enrollmentStats);

        return $profile;
    }

    /**
     * Create default learning profile for new user
     */
    private function createDefaultProfile(int $userId): void
    {
        Database::insert('ai_learning_profiles', [
            'user_id' => $userId,
            'learning_style' => 'mixed',
            'preferred_explanation_style' => 'examples',
            'preferred_difficulty' => 'adaptive'
        ]);
    }

    /**
     * Update student's learning profile
     */
    public function updateProfile(int $userId, array $updates): bool
    {
        $allowedFields = [
            'learning_style', 'preferred_explanation_style', 
            'preferred_difficulty', 'strengths', 'weaknesses',
            'topics_mastered', 'topics_struggling'
        ];

        $data = [];
        foreach ($updates as $key => $value) {
            if (in_array($key, $allowedFields)) {
                // JSON encode arrays
                if (is_array($value)) {
                    $data[$key] = json_encode($value);
                } else {
                    $data[$key] = $value;
                }
            }
        }

        if (empty($data)) {
            return false;
        }

        $profile = Database::fetch(
            "SELECT id FROM ai_learning_profiles WHERE user_id = ?",
            [$userId]
        );

        if ($profile) {
            return Database::update('ai_learning_profiles', $profile['id'], $data);
        } else {
            $data['user_id'] = $userId;
            return Database::insert('ai_learning_profiles', $data) > 0;
        }
    }

    /**
     * Get conversation history for a session
     */
    public function getConversationHistory(int $conversationId, int $limit = 10): array
    {
        $messages = Database::fetchAll(
            "SELECT role, content FROM ai_messages 
             WHERE conversation_id = ?
             ORDER BY created_at ASC
             LIMIT ?",
            [$conversationId, $limit]
        );

        return array_map(function ($msg) {
            return [
                'role' => $msg['role'],
                'content' => $msg['content']
            ];
        }, $messages);
    }

    /**
     * Get user's recent conversations
     */
    public function getRecentConversations(int $userId, int $limit = 10): array
    {
        return Database::fetchAll(
            "SELECT c.*, 
                    l.title as lesson_title,
                    co.title as course_title
             FROM ai_conversations c
             LEFT JOIN lessons l ON c.lesson_id = l.id
             LEFT JOIN courses co ON c.course_id = co.id
             WHERE c.user_id = ?
             ORDER BY c.updated_at DESC
             LIMIT ?",
            [$userId, $limit]
        );
    }

    /**
     * Get conversation by session ID
     */
    public function getConversation(string $sessionId): ?array
    {
        return Database::fetch(
            "SELECT * FROM ai_conversations WHERE uuid = ?",
            [$sessionId]
        );
    }

    /**
     * Get recent learning progress for context
     */
    public function getRecentProgress(int $userId, int $days = 7): array
    {
        $progress = Database::fetchAll(
            "SELECT lp.*, 
                    l.title as lesson_title,
                    m.title as module_title,
                    c.title as course_title
             FROM lesson_progress lp
             JOIN lessons l ON lp.lesson_id = l.id
             JOIN modules m ON l.module_id = m.id
             JOIN courses c ON m.course_id = c.id
             WHERE lp.user_id = ? 
               AND lp.last_accessed_at >= DATE_SUB(NOW(), INTERVAL ? DAY)
             ORDER BY lp.last_accessed_at DESC
             LIMIT 20",
            [$userId, $days]
        );

        return $progress ?: [];
    }

    /**
     * Get enrollment statistics for context
     */
    private function getEnrollmentStats(int $userId): array
    {
        $stats = Database::fetch(
            "SELECT 
                COUNT(*) as total_enrollments,
                SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) as completed_courses,
                SUM(CASE WHEN status = 'active' THEN 1 ELSE 0 END) as active_courses,
                AVG(progress) as average_progress
             FROM enrollments
             WHERE user_id = ?",
            [$userId]
        );

        return [
            'total_enrollments' => (int)($stats['total_enrollments'] ?? 0),
            'completed_courses' => (int)($stats['completed_courses'] ?? 0),
            'active_courses' => (int)($stats['active_courses'] ?? 0),
            'average_progress' => round((float)($stats['average_progress'] ?? 0), 1)
        ];
    }

    /**
     * Get current lesson context for a user
     */
    public function getCurrentLessonContext(int $userId): ?array
    {
        $lastLesson = Database::fetch(
            "SELECT lp.*, 
                    l.title as lesson_title, l.content as lesson_content, l.type as lesson_type,
                    m.title as module_title, m.id as module_id,
                    c.title as course_title, c.id as course_id
             FROM lesson_progress lp
             JOIN lessons l ON lp.lesson_id = l.id
             JOIN modules m ON l.module_id = m.id
             JOIN courses c ON m.course_id = c.id
             WHERE lp.user_id = ?
             ORDER BY lp.last_accessed_at DESC
             LIMIT 1",
            [$userId]
        );

        return $lastLesson ?: null;
    }

    /**
     * Get user's performance in specific topic/course
     */
    public function getTopicPerformance(int $userId, int $courseId): array
    {
        // Get quiz/assignment performance
        $quizPerformance = Database::fetchAll(
            "SELECT 
                l.title as lesson_title,
                qs.score,
                qs.created_at
             FROM quiz_submissions qs
             JOIN lessons l ON qs.lesson_id = l.id
             JOIN modules m ON l.module_id = m.id
             WHERE qs.user_id = ? AND m.course_id = ?
             ORDER BY qs.created_at DESC
             LIMIT 10",
            [$userId, $courseId]
        );

        // Get practice performance
        $practicePerformance = Database::fetchAll(
            "SELECT 
                p.difficulty,
                p.problem_type,
                p.score,
                p.is_correct
             FROM ai_practice_problems p
             JOIN lessons l ON p.lesson_id = l.id
             JOIN modules m ON l.module_id = m.id
             WHERE p.user_id = ? AND m.course_id = ? AND p.score IS NOT NULL
             ORDER BY p.created_at DESC
             LIMIT 20",
            [$userId, $courseId]
        );

        return [
            'quizzes' => $quizPerformance,
            'practice' => $practicePerformance,
            'average_quiz_score' => $this->calculateAverage($quizPerformance, 'score'),
            'average_practice_score' => $this->calculateAverage($practicePerformance, 'score')
        ];
    }

    /**
     * Detect learning style based on interaction patterns
     */
    public function detectLearningStyle(int $userId): string
    {
        // Analyze interaction patterns
        $interactions = Database::fetch(
            "SELECT 
                COUNT(CASE WHEN m.content LIKE '%example%' OR m.content LIKE '%show me%' THEN 1 END) as example_requests,
                COUNT(CASE WHEN m.content LIKE '%explain%' OR m.content LIKE '%why%' THEN 1 END) as explanation_requests,
                COUNT(CASE WHEN m.content LIKE '%code%' OR m.content LIKE '%practice%' THEN 1 END) as practice_requests,
                COUNT(*) as total_messages
             FROM ai_messages m
             JOIN ai_conversations c ON m.conversation_id = c.id
             WHERE c.user_id = ? AND m.role = 'user'",
            [$userId]
        );

        if (!$interactions || $interactions['total_messages'] < 10) {
            return 'mixed'; // Not enough data
        }

        $total = $interactions['total_messages'];
        $exampleRatio = $interactions['example_requests'] / $total;
        $explanationRatio = $interactions['explanation_requests'] / $total;
        $practiceRatio = $interactions['practice_requests'] / $total;

        if ($practiceRatio > 0.4) return 'kinesthetic';
        if ($exampleRatio > 0.3) return 'visual';
        if ($explanationRatio > 0.3) return 'reading';
        
        return 'mixed';
    }

    /**
     * Get struggling topics based on practice performance
     */
    public function identifyStrugglingTopics(int $userId): array
    {
        $struggles = Database::fetchAll(
            "SELECT 
                l.title as lesson_title,
                m.title as module_title,
                AVG(p.score) as avg_score,
                COUNT(*) as attempts
             FROM ai_practice_problems p
             JOIN lessons l ON p.lesson_id = l.id
             JOIN modules m ON l.module_id = m.id
             WHERE p.user_id = ? AND p.score IS NOT NULL
             GROUP BY p.lesson_id
             HAVING avg_score < 60 AND attempts >= 2
             ORDER BY avg_score ASC
             LIMIT 5",
            [$userId]
        );

        return $struggles ?: [];
    }

    /**
     * Get mastered topics based on consistent high performance
     */
    public function identifyMasteredTopics(int $userId): array
    {
        $mastered = Database::fetchAll(
            "SELECT 
                l.title as lesson_title,
                m.title as module_title,
                AVG(p.score) as avg_score,
                COUNT(*) as attempts
             FROM ai_practice_problems p
             JOIN lessons l ON p.lesson_id = l.id
             JOIN modules m ON l.module_id = m.id
             WHERE p.user_id = ? AND p.score IS NOT NULL
             GROUP BY p.lesson_id
             HAVING avg_score >= 85 AND attempts >= 3
             ORDER BY avg_score DESC
             LIMIT 10",
            [$userId]
        );

        return $mastered ?: [];
    }

    /**
     * Get usage statistics for a user
     */
    public function getUsageStats(int $userId, int $days = 30): array
    {
        $stats = Database::fetch(
            "SELECT 
                SUM(request_count) as total_requests,
                SUM(tokens_used) as total_tokens,
                SUM(estimated_cost) as total_cost,
                AVG(request_count) as avg_daily_requests
             FROM ai_usage_logs
             WHERE user_id = ? AND date >= DATE_SUB(CURDATE(), INTERVAL ? DAY)",
            [$userId, $days]
        );

        return [
            'total_requests' => (int)($stats['total_requests'] ?? 0),
            'total_tokens' => (int)($stats['total_tokens'] ?? 0),
            'estimated_cost' => round((float)($stats['total_cost'] ?? 0), 4),
            'avg_daily_requests' => round((float)($stats['avg_daily_requests'] ?? 0), 1)
        ];
    }

    /**
     * Calculate average from array
     */
    private function calculateAverage(array $items, string $field): float
    {
        if (empty($items)) return 0;
        
        $sum = array_sum(array_column($items, $field));
        return round($sum / count($items), 1);
    }
}
