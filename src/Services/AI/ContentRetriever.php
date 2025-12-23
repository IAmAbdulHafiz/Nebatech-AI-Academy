<?php

namespace Nebatech\Services\AI;

use Nebatech\Core\Database;

/**
 * Content Retriever for RAG (Retrieval Augmented Generation)
 * Retrieves relevant course content to provide context to AI responses
 */
class ContentRetriever
{
    private array $config;

    public function __construct()
    {
        $this->config = require dirname(__DIR__, 3) . '/config/ai.php';
    }

    /**
     * Retrieve relevant content based on query and context
     */
    public function retrieve(string $query, array $context = [], int $limit = 3): array
    {
        $results = [];

        // If we have specific lesson context, prioritize that
        if (!empty($context['lesson_id'])) {
            $lessonContent = $this->getLessonContent($context['lesson_id']);
            if ($lessonContent) {
                $results[] = [
                    'type' => 'lesson',
                    'id' => $context['lesson_id'],
                    'title' => $lessonContent['title'],
                    'content' => $this->truncateContent($lessonContent['content'], 2000),
                    'relevance' => 1.0
                ];
            }
        }

        // If we have module context, get related lessons
        if (!empty($context['module_id'])) {
            $moduleLessons = $this->getModuleLessons($context['module_id'], $context['lesson_id'] ?? null);
            foreach (array_slice($moduleLessons, 0, 2) as $lesson) {
                $results[] = [
                    'type' => 'related_lesson',
                    'id' => $lesson['id'],
                    'title' => $lesson['title'],
                    'content' => $this->truncateContent($lesson['content'], 1000),
                    'relevance' => 0.8
                ];
            }
        }

        // If we have course context, get course description and objectives
        if (!empty($context['course_id'])) {
            $courseInfo = $this->getCourseInfo($context['course_id']);
            if ($courseInfo) {
                $results[] = [
                    'type' => 'course_info',
                    'id' => $context['course_id'],
                    'title' => $courseInfo['title'],
                    'content' => $courseInfo['description'] . "\n\nLearning Objectives:\n" . ($courseInfo['learning_objectives'] ?? ''),
                    'relevance' => 0.6
                ];
            }
        }

        // Keyword-based search if we don't have enough context
        if (count($results) < $limit) {
            $keywordResults = $this->searchByKeywords($query, $limit - count($results), $context);
            $results = array_merge($results, $keywordResults);
        }

        // Sort by relevance
        usort($results, fn($a, $b) => $b['relevance'] <=> $a['relevance']);

        return array_slice($results, 0, $limit);
    }

    /**
     * Get full lesson content
     */
    public function getLessonContent(int $lessonId): ?array
    {
        $lesson = Database::fetch(
            "SELECT l.*, m.title as module_title, c.title as course_title
             FROM lessons l
             JOIN modules m ON l.module_id = m.id
             JOIN courses c ON m.course_id = c.id
             WHERE l.id = ?",
            [$lessonId]
        );

        if (!$lesson) {
            return null;
        }

        // Get topics/tags from lesson content
        $topics = $this->extractTopics($lesson['content'] ?? '');

        return [
            'id' => $lesson['id'],
            'title' => $lesson['title'],
            'content' => $lesson['content'] ?? '',
            'type' => $lesson['type'],
            'module_title' => $lesson['module_title'],
            'course_title' => $lesson['course_title'],
            'topics' => $topics
        ];
    }

    /**
     * Get lessons in the same module
     */
    public function getModuleLessons(int $moduleId, ?int $excludeLessonId = null): array
    {
        $params = [$moduleId];
        $excludeClause = '';
        
        if ($excludeLessonId) {
            $excludeClause = 'AND l.id != ?';
            $params[] = $excludeLessonId;
        }

        return Database::fetchAll(
            "SELECT l.id, l.title, l.content, l.type
             FROM lessons l
             WHERE l.module_id = ? {$excludeClause}
             ORDER BY l.order_index ASC",
            $params
        );
    }

    /**
     * Get course information
     */
    public function getCourseInfo(int $courseId): ?array
    {
        return Database::fetch(
            "SELECT id, title, description, learning_objectives, technologies, skills_gained
             FROM courses
             WHERE id = ?",
            [$courseId]
        );
    }

    /**
     * Get module information with all lessons summary
     */
    public function getModuleInfo(int $moduleId): ?array
    {
        $module = Database::fetch(
            "SELECT m.*, c.title as course_title
             FROM modules m
             JOIN courses c ON m.course_id = c.id
             WHERE m.id = ?",
            [$moduleId]
        );

        if (!$module) {
            return null;
        }

        $lessons = Database::fetchAll(
            "SELECT id, title, type FROM lessons WHERE module_id = ? ORDER BY order_index",
            [$moduleId]
        );

        $module['lessons'] = $lessons;
        return $module;
    }

    /**
     * Search content by keywords
     */
    private function searchByKeywords(string $query, int $limit, array $context = []): array
    {
        // Extract keywords from query
        $keywords = $this->extractKeywords($query);
        
        if (empty($keywords)) {
            return [];
        }

        // Build search conditions
        $conditions = [];
        $params = [];
        
        foreach ($keywords as $keyword) {
            $conditions[] = "(l.title LIKE ? OR l.content LIKE ?)";
            $params[] = "%{$keyword}%";
            $params[] = "%{$keyword}%";
        }

        $whereClause = implode(' OR ', $conditions);
        
        // Limit to enrolled courses if user context available
        $courseFilter = '';
        if (!empty($context['user_id'])) {
            $courseFilter = "AND c.id IN (SELECT course_id FROM enrollments WHERE user_id = ?)";
            $params[] = $context['user_id'];
        }

        $results = Database::fetchAll(
            "SELECT l.id, l.title, l.content, 
                    m.title as module_title, c.title as course_title
             FROM lessons l
             JOIN modules m ON l.module_id = m.id
             JOIN courses c ON m.course_id = c.id
             WHERE ({$whereClause}) {$courseFilter}
             LIMIT ?",
            [...$params, $limit]
        );

        return array_map(function ($row) {
            return [
                'type' => 'search_result',
                'id' => $row['id'],
                'title' => $row['title'],
                'content' => $this->truncateContent($row['content'], 500),
                'relevance' => 0.5
            ];
        }, $results);
    }

    /**
     * Get assignment details for context
     */
    public function getAssignmentContent(int $assignmentId): ?array
    {
        $assignment = Database::fetch(
            "SELECT a.*, l.title as lesson_title, m.title as module_title, c.title as course_title
             FROM assignments a
             JOIN lessons l ON a.lesson_id = l.id
             JOIN modules m ON l.module_id = m.id
             JOIN courses c ON m.course_id = c.id
             WHERE a.id = ?",
            [$assignmentId]
        );

        return $assignment ?: null;
    }

    /**
     * Get FAQ entries related to topic
     */
    public function getRelatedFAQs(string $topic, int $limit = 3): array
    {
        return Database::fetchAll(
            "SELECT question, answer FROM ai_faq_cache
             WHERE question LIKE ? OR answer LIKE ?
             ORDER BY hit_count DESC
             LIMIT ?",
            ["%{$topic}%", "%{$topic}%", $limit]
        );
    }

    /**
     * Extract keywords from query for search
     */
    private function extractKeywords(string $query): array
    {
        // Common stop words to filter out
        $stopWords = [
            'the', 'a', 'an', 'is', 'are', 'was', 'were', 'be', 'been', 'being',
            'have', 'has', 'had', 'do', 'does', 'did', 'will', 'would', 'could',
            'should', 'may', 'might', 'can', 'i', 'me', 'my', 'you', 'your',
            'we', 'our', 'they', 'their', 'this', 'that', 'these', 'those',
            'what', 'which', 'who', 'how', 'when', 'where', 'why', 'in', 'on',
            'at', 'to', 'for', 'of', 'with', 'about', 'into', 'through', 'and',
            'or', 'but', 'if', 'then', 'else', 'so', 'than', 'too', 'very',
            'just', 'also', 'now', 'here', 'there', 'all', 'any', 'both',
            'each', 'few', 'more', 'most', 'other', 'some', 'such', 'no', 'not',
            'only', 'same', 'please', 'help', 'need', 'want', 'know', 'understand',
            'explain', 'tell', 'show'
        ];

        // Clean and split query
        $words = preg_split('/\s+/', strtolower(trim($query)));
        
        // Filter out stop words and short words
        $keywords = array_filter($words, function ($word) use ($stopWords) {
            $word = preg_replace('/[^a-z0-9]/', '', $word);
            return strlen($word) >= 3 && !in_array($word, $stopWords);
        });

        return array_values(array_unique($keywords));
    }

    /**
     * Extract topics from lesson content
     */
    private function extractTopics(string $content): array
    {
        // Simple extraction based on headings and emphasized text
        $topics = [];

        // Extract from markdown headings
        preg_match_all('/^#+\s*(.+)$/m', $content, $headings);
        if (!empty($headings[1])) {
            $topics = array_merge($topics, $headings[1]);
        }

        // Extract from bold text
        preg_match_all('/\*\*([^*]+)\*\*/', $content, $bold);
        if (!empty($bold[1])) {
            $topics = array_merge($topics, array_slice($bold[1], 0, 5));
        }

        return array_slice(array_unique($topics), 0, 10);
    }

    /**
     * Truncate content to specified length
     */
    private function truncateContent(string $content, int $maxLength): string
    {
        // Strip HTML tags first
        $content = strip_tags($content);
        
        if (strlen($content) <= $maxLength) {
            return $content;
        }

        // Truncate at word boundary
        $truncated = substr($content, 0, $maxLength);
        $lastSpace = strrpos($truncated, ' ');
        
        if ($lastSpace !== false) {
            $truncated = substr($truncated, 0, $lastSpace);
        }

        return $truncated . '...';
    }

    /**
     * Build context string for AI prompt
     */
    public function buildContextString(array $retrievedContent): string
    {
        if (empty($retrievedContent)) {
            return '';
        }

        $contextParts = [];
        
        foreach ($retrievedContent as $item) {
            $contextParts[] = sprintf(
                "--- %s: %s ---\n%s",
                strtoupper($item['type']),
                $item['title'],
                $item['content']
            );
        }

        return implode("\n\n", $contextParts);
    }
}
