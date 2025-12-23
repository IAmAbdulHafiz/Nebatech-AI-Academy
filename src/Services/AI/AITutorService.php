<?php

namespace Nebatech\Services\AI;

use Nebatech\Core\Database;

/**
 * Main AI Tutor Service
 * Orchestrates AI interactions for student learning
 */
class AITutorService
{
    private OpenAIClient $openai;
    private ContextManager $contextManager;
    private ContentRetriever $contentRetriever;
    private PromptTemplates $prompts;
    private array $config;

    public function __construct()
    {
        $this->config = require dirname(__DIR__, 3) . '/config/ai.php';
        
        $apiKey = $this->config['openai']['api_key'] ?? '';
        if (empty($apiKey)) {
            throw new \Exception('OpenAI API key not configured. Please set OPENAI_API_KEY in your .env file.');
        }
        
        $this->openai = new OpenAIClient($apiKey);
        $this->contextManager = new ContextManager();
        $this->contentRetriever = new ContentRetriever();
        $this->prompts = new PromptTemplates();
    }

    /**
     * Start a new conversation session
     */
    public function startSession(int $userId, array $context = []): array
    {
        $sessionId = $this->generateUuid();
        
        $conversationId = Database::insert('ai_conversations', [
            'uuid' => $sessionId,
            'user_id' => $userId,
            'lesson_id' => $context['lesson_id'] ?? null,
            'course_id' => $context['course_id'] ?? null,
            'module_id' => $context['module_id'] ?? null,
            'session_type' => $context['type'] ?? 'general',
            'status' => 'active'
        ]);

        // Update learning profile interaction count
        $this->updateLearningProfile($userId);

        return [
            'session_id' => $sessionId,
            'conversation_id' => $conversationId,
            'welcome_message' => $this->getWelcomeMessage($context)
        ];
    }

    /**
     * Send a message to the AI tutor
     */
    public function chat(int $userId, string $message, string $sessionId, array $context = []): array
    {
        // Check daily limit
        if (!$this->checkDailyLimit($userId)) {
            return [
                'success' => false,
                'error' => 'Daily AI interaction limit reached. Try again tomorrow!',
                'limit_reached' => true
            ];
        }

        // Get conversation
        $conversation = $this->getConversation($sessionId);
        if (!$conversation || $conversation['user_id'] !== $userId) {
            // Start new session if not found
            $session = $this->startSession($userId, $context);
            $sessionId = $session['session_id'];
            $conversation = $this->getConversation($sessionId);
        }

        // Check cache for similar questions
        $cachedAnswer = $this->checkCache($message, $context['lesson_id'] ?? null);
        if ($cachedAnswer) {
            $this->saveMessage($conversation['id'], 'user', $message);
            $this->saveMessage($conversation['id'], 'assistant', $cachedAnswer, 0);
            return [
                'success' => true,
                'response' => $cachedAnswer,
                'cached' => true,
                'session_id' => $sessionId
            ];
        }

        // Get student context for personalization
        $studentProfile = $this->contextManager->getStudentProfile($userId);
        
        // Get relevant course content (RAG)
        $relevantContent = $this->contentRetriever->retrieve($message, $context);
        
        // Build system prompt
        $systemPrompt = $this->prompts->buildTutorPrompt($studentProfile, $relevantContent, $context);
        
        // Get conversation history
        $history = $this->contextManager->getConversationHistory($conversation['id'], 10);
        
        // Prepare messages for API
        $messages = [
            ['role' => 'system', 'content' => $systemPrompt],
            ...$history,
            ['role' => 'user', 'content' => $message]
        ];

        try {
            // Call OpenAI
            $response = $this->openai->chat($messages, [
                'model' => $this->config['tutor']['models']['chat'],
                'max_tokens' => $this->config['openai']['max_tokens'],
                'temperature' => $this->config['openai']['temperature']
            ]);

            // Save messages
            $this->saveMessage($conversation['id'], 'user', $message);
            $this->saveMessage($conversation['id'], 'assistant', $response['content'], $response['tokens']);

            // Update usage tracking
            $this->trackUsage($userId, $response['tokens'], $response['cost']);

            // Cache if appropriate
            $this->cacheIfAppropriate($message, $response['content'], $context);

            // Generate follow-up suggestions
            $suggestions = $this->generateSuggestions($response['content'], $context);

            return [
                'success' => true,
                'response' => $response['content'],
                'session_id' => $sessionId,
                'suggestions' => $suggestions,
                'tokens_used' => $response['tokens']
            ];

        } catch (\Exception $e) {
            error_log("AI Tutor Error: " . $e->getMessage());
            return [
                'success' => false,
                'error' => 'Sorry, I encountered an error. Please try again.',
                'session_id' => $sessionId
            ];
        }
    }

    /**
     * Review student code with AI feedback
     */
    public function reviewCode(int $userId, string $code, string $language, array $context = []): array
    {
        if (!$this->checkDailyLimit($userId)) {
            return ['success' => false, 'error' => 'Daily limit reached'];
        }

        $maxLength = $this->config['code_review']['max_code_length'];
        if (strlen($code) > $maxLength) {
            return ['success' => false, 'error' => "Code too long. Maximum {$maxLength} characters."];
        }

        $supportedLanguages = $this->config['code_review']['supported_languages'];
        if (!in_array(strtolower($language), $supportedLanguages)) {
            return ['success' => false, 'error' => "Language '{$language}' not supported for review."];
        }

        // Get lesson context if available
        $lessonContext = null;
        if (!empty($context['lesson_id'])) {
            $lessonContext = $this->contentRetriever->getLessonContent($context['lesson_id']);
        }

        $prompt = $this->prompts->buildCodeReviewPrompt($code, $language, $lessonContext, $context);

        // Demo mode - return mock response if API key is empty or demo mode is enabled
        if (empty($this->config['openai']['api_key']) || ($_ENV['AI_DEMO_MODE'] ?? false) === 'true') {
            return $this->getMockCodeReview($code, $language);
        }

        try {
            $response = $this->openai->chat([
                ['role' => 'system', 'content' => $this->prompts->getCodeReviewSystemPrompt()],
                ['role' => 'user', 'content' => $prompt]
            ], [
                'model' => $this->config['tutor']['models']['code_review'],
                'max_tokens' => 1500,
                'temperature' => 0.3
            ]);

            // Parse structured feedback
            $feedback = $this->parseCodeReviewResponse($response['content']);

            // Save code review
            $reviewId = Database::insert('ai_code_reviews', [
                'uuid' => $this->generateUuid(),
                'user_id' => $userId,
                'lesson_id' => $context['lesson_id'] ?? null,
                'assignment_id' => $context['assignment_id'] ?? null,
                'language' => $language,
                'original_code' => $code,
                'feedback' => $response['content'],
                'score' => $feedback['score'] ?? null,
                'issues_found' => json_encode($feedback['issues'] ?? []),
                'improvements' => json_encode($feedback['improvements'] ?? [])
            ]);

            $this->trackUsage($userId, $response['tokens'], $response['cost']);

            return [
                'success' => true,
                'review_id' => $reviewId,
                'review' => $feedback,
                'feedback' => $feedback,
                'raw_response' => $response['content']
            ];

        } catch (\Exception $e) {
            error_log("Code Review Error: " . $e->getMessage() . " | Trace: " . $e->getTraceAsString());
            return ['success' => false, 'error' => 'Failed to review code: ' . $e->getMessage()];
        }
    }

    /**
     * Generate practice problems for a lesson
     */
    public function generatePractice(int $userId, int $lessonId, string $type = 'mixed', string $difficulty = 'adaptive'): array
    {
        if (!$this->checkDailyLimit($userId)) {
            return ['success' => false, 'error' => 'Daily limit reached'];
        }

        // Get lesson content
        $lessonContent = $this->contentRetriever->getLessonContent($lessonId);
        if (!$lessonContent) {
            return ['success' => false, 'error' => 'Lesson not found'];
        }

        // Get student profile for adaptive difficulty
        $studentProfile = $this->contextManager->getStudentProfile($userId);
        if ($difficulty === 'adaptive') {
            $difficulty = $this->calculateAdaptiveDifficulty($userId, $lessonId);
        }

        $prompt = $this->prompts->buildPracticePrompt($lessonContent, $type, $difficulty, $studentProfile);

        try {
            $response = $this->openai->chat([
                ['role' => 'system', 'content' => $this->prompts->getPracticeSystemPrompt()],
                ['role' => 'user', 'content' => $prompt]
            ], [
                'model' => $this->config['tutor']['models']['practice'],
                'max_tokens' => 2000,
                'temperature' => 0.8,
                'response_format' => ['type' => 'json_object']
            ]);

            $problems = json_decode($response['content'], true);
            
            // Save problems to database
            $savedProblems = [];
            foreach ($problems['problems'] ?? [] as $problem) {
                $problemId = Database::insert('ai_practice_problems', [
                    'uuid' => $this->generateUuid(),
                    'lesson_id' => $lessonId,
                    'user_id' => $userId,
                    'problem_type' => $problem['type'] ?? 'conceptual',
                    'difficulty' => $problem['difficulty'] ?? $difficulty,
                    'language' => $problem['language'] ?? null,
                    'problem_content' => json_encode($problem)
                ]);
                $problem['id'] = $problemId;
                $savedProblems[] = $problem;
            }

            $this->trackUsage($userId, $response['tokens'], $response['cost']);

            return [
                'success' => true,
                'problems' => $savedProblems,
                'lesson_title' => $lessonContent['title']
            ];

        } catch (\Exception $e) {
            error_log("Practice Generation Error: " . $e->getMessage());
            return ['success' => false, 'error' => 'Failed to generate practice problems.'];
        }
    }

    /**
     * Submit and evaluate practice problem answer
     */
    public function submitPracticeAnswer(int $userId, int $problemId, string $answer): array
    {
        $problem = Database::fetch(
            "SELECT * FROM ai_practice_problems WHERE id = ? AND user_id = ?",
            [$problemId, $userId]
        );

        if (!$problem) {
            return ['success' => false, 'error' => 'Problem not found'];
        }

        $problemContent = json_decode($problem['problem_content'], true);
        
        $prompt = $this->prompts->buildEvaluationPrompt($problemContent, $answer);

        try {
            $response = $this->openai->chat([
                ['role' => 'user', 'content' => $prompt]
            ], [
                'model' => $this->config['tutor']['models']['simple'],
                'max_tokens' => 500,
                'temperature' => 0.3
            ]);

            $evaluation = $this->parseEvaluationResponse($response['content']);

            // Update problem record
            Database::update('ai_practice_problems', $problemId, [
                'user_answer' => $answer,
                'ai_feedback' => $response['content'],
                'score' => $evaluation['score'],
                'is_correct' => $evaluation['is_correct'] ? 1 : 0,
                'answered_at' => date('Y-m-d H:i:s')
            ]);

            // Update learning profile
            $this->updateLearningProfileAfterPractice($userId, $evaluation);

            $this->trackUsage($userId, $response['tokens'], $response['cost']);

            return [
                'success' => true,
                'is_correct' => $evaluation['is_correct'],
                'score' => $evaluation['score'],
                'feedback' => $evaluation['feedback'],
                'explanation' => $evaluation['explanation'] ?? null
            ];

        } catch (\Exception $e) {
            error_log("Practice Evaluation Error: " . $e->getMessage());
            return ['success' => false, 'error' => 'Failed to evaluate answer.'];
        }
    }

    /**
     * Get AI-powered learning recommendations
     */
    public function getRecommendations(int $userId): array
    {
        $profile = $this->contextManager->getStudentProfile($userId);
        $recentProgress = $this->contextManager->getRecentProgress($userId);
        
        $prompt = $this->prompts->buildRecommendationsPrompt($profile, $recentProgress);

        try {
            $response = $this->openai->chat([
                ['role' => 'user', 'content' => $prompt]
            ], [
                'model' => $this->config['tutor']['models']['simple'],
                'max_tokens' => 800,
                'temperature' => 0.7
            ]);

            $this->trackUsage($userId, $response['tokens'], $response['cost']);

            return [
                'success' => true,
                'recommendations' => $response['content']
            ];

        } catch (\Exception $e) {
            return ['success' => false, 'error' => 'Failed to get recommendations.'];
        }
    }

    /**
     * Explain a concept in different ways
     */
    public function explainConcept(int $userId, string $concept, string $style = 'simple', array $context = []): array
    {
        if (!$this->checkDailyLimit($userId)) {
            return ['success' => false, 'error' => 'Daily limit reached'];
        }

        $relevantContent = $this->contentRetriever->retrieve($concept, $context);
        $prompt = $this->prompts->buildExplanationPrompt($concept, $style, $relevantContent);

        try {
            $response = $this->openai->chat([
                ['role' => 'system', 'content' => $this->prompts->getExplanationSystemPrompt($style)],
                ['role' => 'user', 'content' => $prompt]
            ], [
                'model' => $this->config['tutor']['models']['chat'],
                'max_tokens' => 1000,
                'temperature' => 0.7
            ]);

            $this->trackUsage($userId, $response['tokens'], $response['cost']);

            return [
                'success' => true,
                'explanation' => $response['content'],
                'style' => $style
            ];

        } catch (\Exception $e) {
            return ['success' => false, 'error' => 'Failed to explain concept.'];
        }
    }

    /**
     * End a conversation session
     */
    public function endSession(string $sessionId, int $userId): array
    {
        $conversation = $this->getConversation($sessionId);
        if (!$conversation || $conversation['user_id'] !== $userId) {
            return ['success' => false, 'error' => 'Session not found'];
        }

        // Generate summary if there are messages
        $summary = null;
        if ($conversation['message_count'] > 2) {
            $history = $this->contextManager->getConversationHistory($conversation['id'], 20);
            $summary = $this->generateSessionSummary($history);
        }

        Database::update('ai_conversations', $conversation['id'], [
            'status' => 'ended',
            'ended_at' => date('Y-m-d H:i:s'),
            'summary' => $summary
        ]);

        return [
            'success' => true,
            'summary' => $summary
        ];
    }

    // ========== Private Helper Methods ==========

    private function getConversation(string $sessionId): ?array
    {
        return Database::fetch(
            "SELECT * FROM ai_conversations WHERE uuid = ? AND status = 'active'",
            [$sessionId]
        );
    }

    private function saveMessage(int $conversationId, string $role, string $content, int $tokens = 0): void
    {
        Database::insert('ai_messages', [
            'uuid' => $this->generateUuid(),
            'conversation_id' => $conversationId,
            'role' => $role,
            'content' => $content,
            'tokens_used' => $tokens
        ]);

        // Update conversation stats
        Database::execute(
            "UPDATE ai_conversations SET message_count = message_count + 1, total_tokens = total_tokens + ? WHERE id = ?",
            [$tokens, $conversationId]
        );
    }

    private function checkDailyLimit(int $userId): bool
    {
        $today = date('Y-m-d');
        $usage = Database::fetch(
            "SELECT request_count FROM ai_usage_logs WHERE user_id = ? AND date = ?",
            [$userId, $today]
        );

        $limit = $this->config['tutor']['max_daily_requests'];
        return !$usage || $usage['request_count'] < $limit;
    }

    private function trackUsage(int $userId, int $tokens, float $cost): void
    {
        $today = date('Y-m-d');
        
        Database::execute(
            "INSERT INTO ai_usage_logs (user_id, date, request_count, tokens_used, estimated_cost)
             VALUES (?, ?, 1, ?, ?)
             ON DUPLICATE KEY UPDATE 
                request_count = request_count + 1,
                tokens_used = tokens_used + VALUES(tokens_used),
                estimated_cost = estimated_cost + VALUES(estimated_cost)",
            [$userId, $today, $tokens, $cost]
        );
    }

    private function checkCache(string $question, ?int $lessonId): ?string
    {
        $hash = hash('sha256', strtolower(trim($question)));
        
        $cached = Database::fetch(
            "SELECT answer FROM ai_faq_cache 
             WHERE question_hash = ? AND (lesson_id = ? OR lesson_id IS NULL)
             AND (expires_at IS NULL OR expires_at > NOW())",
            [$hash, $lessonId]
        );

        if ($cached) {
            Database::execute(
                "UPDATE ai_faq_cache SET hit_count = hit_count + 1, last_used_at = NOW() WHERE question_hash = ?",
                [$hash]
            );
            return $cached['answer'];
        }

        return null;
    }

    private function cacheIfAppropriate(string $question, string $answer, array $context): void
    {
        // Only cache general questions without personal context
        if (strlen($question) < 20 || strlen($answer) < 50) {
            return;
        }

        $hash = hash('sha256', strtolower(trim($question)));
        $cacheHours = $this->config['tutor']['cache_faq_hours'];
        
        Database::execute(
            "INSERT IGNORE INTO ai_faq_cache (question_hash, question, answer, lesson_id, course_id, expires_at)
             VALUES (?, ?, ?, ?, ?, DATE_ADD(NOW(), INTERVAL ? HOUR))",
            [$hash, $question, $answer, $context['lesson_id'] ?? null, $context['course_id'] ?? null, $cacheHours]
        );
    }

    private function updateLearningProfile(int $userId): void
    {
        Database::execute(
            "INSERT INTO ai_learning_profiles (user_id, total_ai_interactions, last_interaction_at)
             VALUES (?, 1, NOW())
             ON DUPLICATE KEY UPDATE 
                total_ai_interactions = total_ai_interactions + 1,
                last_interaction_at = NOW()",
            [$userId]
        );
    }

    private function updateLearningProfileAfterPractice(int $userId, array $evaluation): void
    {
        $score = $evaluation['score'] ?? 0;
        
        Database::execute(
            "UPDATE ai_learning_profiles 
             SET total_practice_completed = total_practice_completed + 1,
                 average_practice_score = (average_practice_score * total_practice_completed + ?) / (total_practice_completed + 1)
             WHERE user_id = ?",
            [$score, $userId]
        );
    }

    private function calculateAdaptiveDifficulty(int $userId, int $lessonId): string
    {
        $recentScores = Database::fetchAll(
            "SELECT score FROM ai_practice_problems 
             WHERE user_id = ? AND lesson_id = ? AND score IS NOT NULL
             ORDER BY created_at DESC LIMIT 5",
            [$userId, $lessonId]
        );

        if (empty($recentScores)) {
            return 'medium';
        }

        $avgScore = array_sum(array_column($recentScores, 'score')) / count($recentScores);

        if ($avgScore >= 80) return 'hard';
        if ($avgScore >= 50) return 'medium';
        return 'easy';
    }

    private function generateSuggestions(string $response, array $context): array
    {
        $suggestions = [];
        
        if (!empty($context['lesson_id'])) {
            $suggestions[] = ['type' => 'practice', 'text' => 'Practice this concept', 'action' => 'generate_practice'];
        }
        
        $suggestions[] = ['type' => 'explain', 'text' => 'Explain differently', 'action' => 'explain_simple'];
        $suggestions[] = ['type' => 'example', 'text' => 'Show me an example', 'action' => 'show_example'];
        
        return $suggestions;
    }

    private function generateSessionSummary(array $history): string
    {
        $conversationText = '';
        foreach ($history as $msg) {
            $conversationText .= "{$msg['role']}: {$msg['content']}\n";
        }

        try {
            $response = $this->openai->chat([
                ['role' => 'user', 'content' => "Summarize this learning session in 2-3 sentences:\n\n{$conversationText}"]
            ], [
                'model' => $this->config['tutor']['models']['simple'],
                'max_tokens' => 150
            ]);

            return $response['content'];
        } catch (\Exception $e) {
            return 'Session completed.';
        }
    }

    private function getWelcomeMessage(array $context): string
    {
        if (!empty($context['lesson_id'])) {
            return "Hi! I'm your AI tutor. I'm here to help you understand this lesson. Feel free to ask me any questions about the concepts, request examples, or get help with the code exercises!";
        }
        
        return "Hello! I'm your AI learning assistant. I can help you with course content, review your code, generate practice problems, or explain concepts in different ways. How can I help you today?";
    }

    private function parseCodeReviewResponse(string $response): array
    {
        // Try to extract structured data from response
        $feedback = [
            'score' => 75,
            'issues' => [],
            'suggestions' => [],
            'improvements' => [],
            'summary' => ''
        ];

        // Extract score if mentioned
        if (preg_match('/(\d+)\/100|score[:\s]+(\d+)/i', $response, $matches)) {
            $feedback['score'] = (int)($matches[1] ?? $matches[2]);
        }

        // Try to parse the response for structured sections
        $lines = explode("\n", $response);
        $currentSection = 'summary';
        $summaryParts = [];
        
        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line)) continue;
            
            // Detect section headers
            if (preg_match('/^(issues?|problems?|errors?)[:\s]*/i', $line)) {
                $currentSection = 'issues';
                continue;
            }
            if (preg_match('/^(suggestions?|recommendations?|improvements?)[:\s]*/i', $line)) {
                $currentSection = 'suggestions';
                continue;
            }
            if (preg_match('/^(summary|overview)[:\s]*/i', $line)) {
                $currentSection = 'summary';
                continue;
            }
            
            // Handle bullet points
            if (preg_match('/^[-*•]\s*(.+)$/', $line, $matches)) {
                $item = trim($matches[1]);
                if ($currentSection === 'issues') {
                    $feedback['issues'][] = [
                        'message' => $item,
                        'severity' => stripos($item, 'error') !== false ? 'error' : 'warning'
                    ];
                } elseif ($currentSection === 'suggestions') {
                    $feedback['suggestions'][] = $item;
                } else {
                    $summaryParts[] = $item;
                }
            } else {
                // Regular text
                if ($currentSection === 'summary' || empty($feedback['summary'])) {
                    $summaryParts[] = $line;
                }
            }
        }
        
        // Build summary from first few lines if not explicitly set
        $feedback['summary'] = implode(' ', array_slice($summaryParts, 0, 3));
        if (strlen($feedback['summary']) > 200) {
            $feedback['summary'] = substr($feedback['summary'], 0, 200) . '...';
        }
        
        // If no summary extracted, use first part of response
        if (empty($feedback['summary'])) {
            $feedback['summary'] = substr($response, 0, 200) . (strlen($response) > 200 ? '...' : '');
        }

        return $feedback;
    }

    private function parseEvaluationResponse(string $response): array
    {
        $isCorrect = stripos($response, 'correct') !== false && stripos($response, 'incorrect') === false;
        
        // Extract score
        $score = 0;
        if (preg_match('/(\d+)%|(\d+)\/100/i', $response, $matches)) {
            $score = (int)($matches[1] ?? $matches[2]);
        } elseif ($isCorrect) {
            $score = 100;
        }

        return [
            'is_correct' => $isCorrect,
            'score' => $score,
            'feedback' => $response
        ];
    }

    private function generateUuid(): string
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }

    /**
     * Generate mock code review for demo/testing purposes
     */
    private function getMockCodeReview(string $code, string $language): array
    {
        $issues = [];
        $suggestions = [];
        $score = 75;

        // Basic code analysis
        $lines = explode("\n", $code);
        $lineCount = count($lines);

        // Check for common issues
        if (stripos($code, 'var ') !== false && in_array($language, ['javascript', 'typescript'])) {
            $issues[] = [
                'message' => 'Use of "var" keyword detected',
                'severity' => 'warning',
                'suggestion' => 'Consider using "let" or "const" instead of "var" for better scoping'
            ];
            $score -= 5;
        }

        if (stripos($code, 'console.log') !== false) {
            $issues[] = [
                'message' => 'Console.log statement found',
                'severity' => 'info',
                'suggestion' => 'Remember to remove debug statements before production'
            ];
        }

        if (preg_match('/return\s+\w+\s*$/m', $code)) {
            $issues[] = [
                'message' => 'Missing semicolon after return statement',
                'severity' => 'warning',
                'suggestion' => 'Add semicolon for consistency'
            ];
            $score -= 3;
        }

        // Add suggestions based on language
        $suggestions[] = 'Consider adding comments to explain complex logic';
        $suggestions[] = 'Good use of functions for code organization';
        
        if ($lineCount < 10) {
            $suggestions[] = 'Code is concise and readable';
            $score += 5;
        }

        $score = max(0, min(100, $score));

        $summary = "Code review completed. Found " . count($issues) . " potential issue(s). ";
        $summary .= $score >= 80 ? "Overall, the code quality is good!" : "Some improvements could be made.";

        return [
            'success' => true,
            'review_id' => 'demo-' . time(),
            'review' => [
                'score' => $score,
                'summary' => $summary,
                'issues' => $issues,
                'suggestions' => $suggestions,
                'improvements' => $suggestions
            ],
            'feedback' => [
                'score' => $score,
                'summary' => $summary,
                'issues' => $issues,
                'suggestions' => $suggestions
            ],
            'raw_response' => "[DEMO MODE] This is a simulated code review. Add OpenAI credits to enable AI-powered reviews.",
            'demo_mode' => true
        ];
    }
}
