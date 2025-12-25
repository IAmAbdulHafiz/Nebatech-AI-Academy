<?php

namespace Nebatech\Services;

use OpenAI;
use PDO;

/**
 * AI Tutor Service - Context-aware intelligent tutoring
 * 
 * Unlike the general AIService which generates content,
 * this service focuses on interactive tutoring:
 * - Answering student questions in context of their current lesson
 * - Providing hints for practicals without giving away solutions
 * - Explaining concepts based on student's progress
 * - Offering Socratic questioning to deepen understanding
 */
class AITutorService
{
    private $client;
    private $model;
    private PDO $pdo;

    // Tutor personality configurations
    private const TUTOR_PERSONAS = [
        'mentor' => [
            'name' => 'Abdul-Hafiz',
            'style' => 'Supportive and encouraging mentor who guides through questions',
            'approach' => 'Uses Socratic method, asks guiding questions, celebrates progress'
        ],
        'expert' => [
            'name' => 'Dr. Neba',
            'style' => 'Industry expert who shares real-world insights',
            'approach' => 'Provides practical examples, industry standards, best practices'
        ],
        'peer' => [
            'name' => 'Abubakari',
            'style' => 'Friendly peer tutor who explains things simply',
            'approach' => 'Uses analogies, simple language, relatable examples'
        ]
    ];

    public function __construct()
    {
        $config = require __DIR__ . '/../../config/ai.php';
        
        $apiKey = $config['openai']['api_key'] ?? '';
        if (empty($apiKey)) {
            throw new \Exception('OpenAI API key is not configured.');
        }

        $this->client = OpenAI::client($apiKey);
        $this->model = $config['openai']['model'] ?? 'gpt-4o-mini';
        
        // Database connection
        $dbConfig = require __DIR__ . '/../../config/database.php';
        $this->pdo = new PDO(
            "mysql:host={$dbConfig['host']};dbname={$dbConfig['database']};charset=utf8mb4",
            $dbConfig['username'],
            $dbConfig['password'],
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
    }

    /**
     * Get AI tutor response for a student question
     * 
     * @param int $userId Student ID
     * @param string $question Student's question
     * @param array $context Context information (lesson_id, practical_id, quiz_id, etc.)
     * @param string $persona Tutor persona (mentor, expert, peer)
     * @return array Response with answer, follow-up suggestions, and metadata
     */
    public function askQuestion(int $userId, string $question, array $context = [], string $persona = 'mentor'): array
    {
        // Build comprehensive context
        $contextInfo = $this->buildLearningContext($userId, $context);
        
        // Get conversation history for continuity
        $history = $this->getConversationHistory($userId, $context['lesson_id'] ?? null, 5);
        
        // Build the system prompt with context
        $systemPrompt = $this->buildTutorSystemPrompt($contextInfo, $persona);
        
        // Build messages array
        $messages = [['role' => 'system', 'content' => $systemPrompt]];
        
        // Add conversation history
        foreach ($history as $msg) {
            $messages[] = ['role' => $msg['role'], 'content' => $msg['content']];
        }
        
        // Add current question
        $messages[] = ['role' => 'user', 'content' => $question];
        
        try {
            $response = $this->client->chat()->create([
                'model' => $this->model,
                'messages' => $messages,
                'max_tokens' => 1500,
                'temperature' => 0.7
            ]);

            $answer = $response->choices[0]->message->content;
            
            // Log the interaction
            $interactionId = $this->logInteraction($userId, $question, $answer, $context, $persona);
            
            return [
                'success' => true,
                'answer' => $answer,
                'tutor_name' => self::TUTOR_PERSONAS[$persona]['name'],
                'interaction_id' => $interactionId,
                'follow_up_suggestions' => $this->generateFollowUpSuggestions($question, $contextInfo),
                'related_resources' => $this->getRelatedResources($context)
            ];
        } catch (\Exception $e) {
            error_log('AI Tutor Error: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => 'I apologize, but I encountered an issue. Please try again.',
                'tutor_name' => self::TUTOR_PERSONAS[$persona]['name']
            ];
        }
    }

    /**
     * Get a hint for a practical exercise
     * 
     * @param int $userId Student ID
     * @param int $practicalId Practical exercise ID
     * @param int $hintLevel How many hints already given (1-3)
     * @return array Hint with guidance level
     */
    public function getHint(int $userId, int $practicalId, int $hintLevel = 1): array
    {
        $practical = $this->getPracticalDetails($practicalId);
        if (!$practical) {
            return ['success' => false, 'error' => 'Practical not found'];
        }

        $lesson = $this->getLessonDetails($practical['lesson_id']);
        
        // Get student's current attempt/progress
        $submission = $this->getLatestSubmission($userId, $practicalId);
        
        $systemPrompt = "You are a helpful programming tutor. The student is working on a practical exercise.

## Exercise Details
Title: {$practical['title']}
Description: {$practical['description']}
Difficulty: {$practical['difficulty']}

## Instructions
{$practical['instructions']}

## Expected Outcome
{$practical['expected_outcome']}

## Current Hint Level: {$hintLevel}/3

IMPORTANT GUIDELINES:
- At level 1: Give a conceptual hint that points in the right direction WITHOUT code
- At level 2: Give a more specific hint that mentions relevant concepts/functions WITHOUT code
- At level 3: Provide pseudo-code or a partial code structure, but still NOT the complete solution

Your goal is to help the student learn by guiding their thinking, not by solving it for them.
Use Socratic questioning when appropriate.";

        $userPrompt = "I need a hint for this exercise.";
        if ($submission && !empty($submission['submitted_code'])) {
            $userPrompt .= "\n\nHere's what I've tried so far:\n```\n{$submission['submitted_code']}\n```";
        }

        try {
            $response = $this->client->chat()->create([
                'model' => $this->model,
                'messages' => [
                    ['role' => 'system', 'content' => $systemPrompt],
                    ['role' => 'user', 'content' => $userPrompt]
                ],
                'max_tokens' => 800,
                'temperature' => 0.6
            ]);

            $hint = $response->choices[0]->message->content;
            
            // Log hint usage
            $this->logHintUsage($userId, $practicalId, $hintLevel);
            
            return [
                'success' => true,
                'hint' => $hint,
                'hint_level' => $hintLevel,
                'max_hints' => 3,
                'hints_remaining' => 3 - $hintLevel
            ];
        } catch (\Exception $e) {
            return ['success' => false, 'error' => 'Unable to generate hint'];
        }
    }

    /**
     * Explain a concept from the current lesson
     * 
     * @param int $userId Student ID
     * @param int $lessonId Lesson ID
     * @param string $concept The concept to explain
     * @param string $depth How deep the explanation should go (brief, standard, detailed)
     * @return array Explanation with examples
     */
    public function explainConcept(int $userId, int $lessonId, string $concept, string $depth = 'standard'): array
    {
        $lesson = $this->getLessonDetails($lessonId);
        $module = $this->getModuleDetails($lesson['module_id'] ?? 0);
        $course = $this->getCourseDetails($module['course_id'] ?? 0);
        $objectives = $this->getLearningObjectives($lessonId);
        
        $depthInstructions = [
            'brief' => 'Provide a concise 2-3 sentence explanation suitable for a quick refresh.',
            'standard' => 'Provide a clear explanation with one practical example. About 150-200 words.',
            'detailed' => 'Provide a comprehensive explanation with multiple examples, edge cases, and how it connects to related concepts. Include a code example if relevant.'
        ];

        $systemPrompt = "You are an expert tutor for {$course['title']}.

## Current Context
Course: {$course['title']}
Module: {$module['title']}
Lesson: {$lesson['title']}

## Learning Objectives for this Lesson
" . implode("\n", array_map(fn($o) => "- {$o['objective_text']}", $objectives)) . "

## Instructions
{$depthInstructions[$depth]}

Make the explanation:
1. Clear and beginner-friendly
2. Connected to what the student is learning
3. Practical with real-world relevance
4. Encouraging and supportive";

        try {
            $response = $this->client->chat()->create([
                'model' => $this->model,
                'messages' => [
                    ['role' => 'system', 'content' => $systemPrompt],
                    ['role' => 'user', 'content' => "Please explain: {$concept}"]
                ],
                'max_tokens' => 1200,
                'temperature' => 0.7
            ]);

            return [
                'success' => true,
                'explanation' => $response->choices[0]->message->content,
                'depth' => $depth,
                'lesson_context' => $lesson['title'],
                'related_objectives' => $objectives
            ];
        } catch (\Exception $e) {
            return ['success' => false, 'error' => 'Unable to generate explanation'];
        }
    }

    /**
     * Get study recommendations based on student progress
     * 
     * @param int $userId Student ID
     * @param int $courseId Course ID
     * @return array Personalized study recommendations
     */
    public function getStudyRecommendations(int $userId, int $courseId): array
    {
        // Get student's progress data
        $progress = $this->getStudentProgress($userId, $courseId);
        $weakAreas = $this->identifyWeakAreas($userId, $courseId);
        $recentActivity = $this->getRecentActivity($userId, $courseId);
        
        $course = $this->getCourseDetails($courseId);

        $systemPrompt = "You are a learning advisor for the {$course['title']} course.

Based on the student's progress data, provide personalized study recommendations.

## Student Progress
- Completed Lessons: {$progress['lessons_completed']} / {$progress['total_lessons']}
- Quiz Average: {$progress['quiz_average']}%
- Practicals Completed: {$progress['practicals_completed']}
- Current Streak: {$progress['study_streak']} days

## Areas Needing Attention
" . implode("\n", array_map(fn($a) => "- {$a['topic']}: {$a['reason']}", $weakAreas)) . "

## Recent Activity
{$recentActivity}

Provide:
1. What to focus on next (be specific)
2. Estimated time needed
3. Tips for improvement in weak areas
4. Encouragement based on their progress

Keep recommendations actionable and motivating.";

        try {
            $response = $this->client->chat()->create([
                'model' => $this->model,
                'messages' => [
                    ['role' => 'system', 'content' => $systemPrompt],
                    ['role' => 'user', 'content' => 'What should I focus on next in my studies?']
                ],
                'max_tokens' => 800,
                'temperature' => 0.7
            ]);

            return [
                'success' => true,
                'recommendations' => $response->choices[0]->message->content,
                'progress_summary' => $progress,
                'focus_areas' => $weakAreas
            ];
        } catch (\Exception $e) {
            return ['success' => false, 'error' => 'Unable to generate recommendations'];
        }
    }

    /**
     * Review and provide feedback on quiz answers
     * 
     * @param int $userId Student ID
     * @param int $quizAttemptId Quiz attempt ID
     * @return array Personalized feedback on performance
     */
    public function reviewQuizAttempt(int $userId, int $quizAttemptId): array
    {
        $attempt = $this->getQuizAttemptDetails($quizAttemptId);
        if (!$attempt || $attempt['user_id'] !== $userId) {
            return ['success' => false, 'error' => 'Quiz attempt not found'];
        }

        $quiz = $this->getQuizDetails($attempt['quiz_id']);
        $answers = $this->getAttemptAnswers($quizAttemptId);
        
        // Build analysis of incorrect answers
        $incorrectAnalysis = [];
        foreach ($answers as $ans) {
            if (!$ans['is_correct']) {
                $incorrectAnalysis[] = [
                    'question' => $ans['question_text'],
                    'student_answer' => $ans['student_answer'],
                    'correct_answer' => $ans['correct_answer'],
                    'topic' => $ans['topic'] ?? 'General'
                ];
            }
        }

        $systemPrompt = "You are a supportive quiz reviewer. The student just completed a quiz and you're providing personalized feedback.

## Quiz Details
Title: {$quiz['title']}
Score: {$attempt['score']}%
Passed: " . ($attempt['score'] >= $quiz['passing_score'] ? 'Yes' : 'Not yet') . "

## Incorrect Answers Analysis
" . json_encode($incorrectAnalysis, JSON_PRETTY_PRINT) . "

Provide:
1. Encouraging opening based on their score
2. Brief explanation for each incorrect answer (why the correct answer is right)
3. Pattern analysis (any topics they should review?)
4. Specific next steps for improvement
5. Motivating closing

Be supportive - focus on learning, not failure.";

        try {
            $response = $this->client->chat()->create([
                'model' => $this->model,
                'messages' => [
                    ['role' => 'system', 'content' => $systemPrompt],
                    ['role' => 'user', 'content' => 'Please review my quiz results and help me understand what I got wrong.']
                ],
                'max_tokens' => 1200,
                'temperature' => 0.7
            ]);

            return [
                'success' => true,
                'feedback' => $response->choices[0]->message->content,
                'score' => $attempt['score'],
                'passed' => $attempt['score'] >= $quiz['passing_score'],
                'topics_to_review' => array_unique(array_column($incorrectAnalysis, 'topic'))
            ];
        } catch (\Exception $e) {
            return ['success' => false, 'error' => 'Unable to generate feedback'];
        }
    }

    // ==================== PRIVATE HELPER METHODS ====================

    /**
     * Build comprehensive learning context for the AI
     */
    private function buildLearningContext(int $userId, array $context): array
    {
        $result = ['user_id' => $userId];

        // Get lesson context
        if (!empty($context['lesson_id'])) {
            $lesson = $this->getLessonDetails($context['lesson_id']);
            $result['lesson'] = $lesson;
            
            if ($lesson) {
                $result['module'] = $this->getModuleDetails($lesson['module_id']);
                $result['objectives'] = $this->getLearningObjectives($context['lesson_id']);
                
                if ($result['module']) {
                    $result['course'] = $this->getCourseDetails($result['module']['course_id']);
                }
            }
        }

        // Get practical context
        if (!empty($context['practical_id'])) {
            $result['practical'] = $this->getPracticalDetails($context['practical_id']);
        }

        // Get quiz context
        if (!empty($context['quiz_id'])) {
            $result['quiz'] = $this->getQuizDetails($context['quiz_id']);
        }

        // Get student progress in this course
        if (!empty($result['course'])) {
            $result['student_progress'] = $this->getStudentProgress($userId, $result['course']['id']);
        }

        return $result;
    }

    /**
     * Build the system prompt for the tutor
     */
    private function buildTutorSystemPrompt(array $context, string $persona): string
    {
        $personaConfig = self::TUTOR_PERSONAS[$persona];
        
        $prompt = "You are {$personaConfig['name']}, an AI tutor for Nebatech AI Academy.

## Your Personality
Style: {$personaConfig['style']}
Approach: {$personaConfig['approach']}

## Current Learning Context\n";

        if (!empty($context['course'])) {
            $prompt .= "Course: {$context['course']['title']} ({$context['course']['level']} level)\n";
        }
        if (!empty($context['module'])) {
            $prompt .= "Module: {$context['module']['title']}\n";
        }
        if (!empty($context['lesson'])) {
            $prompt .= "Current Lesson: {$context['lesson']['title']}\n";
            
            // Add lesson content summary if available
            if (!empty($context['lesson']['content'])) {
                $contentPreview = substr(strip_tags($context['lesson']['content']), 0, 500);
                $prompt .= "Lesson Content Preview: {$contentPreview}...\n";
            }
        }
        if (!empty($context['objectives'])) {
            $prompt .= "\nLearning Objectives:\n";
            foreach ($context['objectives'] as $obj) {
                $prompt .= "- {$obj['objective_text']}\n";
            }
        }
        if (!empty($context['practical'])) {
            $prompt .= "\nCurrent Practical: {$context['practical']['title']}\n";
        }
        if (!empty($context['student_progress'])) {
            $progress = $context['student_progress'];
            $prompt .= "\nStudent Progress: {$progress['lessons_completed']}/{$progress['total_lessons']} lessons, {$progress['quiz_average']}% quiz average\n";
        }

        $prompt .= "\n## Guidelines
1. Always respond in context of what the student is currently learning
2. Be encouraging but honest - praise effort and progress
3. Use the Socratic method when appropriate - guide with questions
4. Never give direct answers to assignments - guide toward solutions
5. If asked about something outside the current context, briefly answer but guide back to the lesson
6. Use examples and analogies that relate to the course material
7. Keep responses conversational and approachable
8. Format responses with markdown for readability when helpful";

        return $prompt;
    }

    /**
     * Get conversation history for context continuity
     */
    private function getConversationHistory(int $userId, ?int $lessonId, int $limit = 5): array
    {
        $sql = "SELECT user_message, ai_response FROM ai_tutor_interactions 
                WHERE user_id = ? " . ($lessonId ? "AND lesson_id = ?" : "") . "
                ORDER BY created_at DESC LIMIT " . (int)$limit;
        
        $params = $lessonId ? [$userId, $lessonId] : [$userId];
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        
        $history = array_reverse($stmt->fetchAll(PDO::FETCH_ASSOC));
        
        // Format for OpenAI messages
        $messages = [];
        foreach ($history as $h) {
            if (!empty($h['user_message'])) {
                $messages[] = ['role' => 'user', 'content' => $h['user_message']];
            }
            if (!empty($h['ai_response'])) {
                $messages[] = ['role' => 'assistant', 'content' => $h['ai_response']];
            }
        }
        
        return $messages;
    }

    /**
     * Log interaction for analytics and history
     */
    private function logInteraction(int $userId, string $question, string $answer, array $context, string $persona): int
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO ai_tutor_interactions (
                user_id, course_id, module_id, lesson_id, practical_id, quiz_id,
                interaction_type, user_message, ai_response,
                context_data, created_at
            ) VALUES (?, ?, ?, ?, ?, ?, 'question', ?, ?, ?, NOW())
        ");
        
        $stmt->execute([
            $userId,
            $context['course_id'] ?? null,
            $context['module_id'] ?? null,
            $context['lesson_id'] ?? null,
            $context['practical_id'] ?? null,
            $context['quiz_id'] ?? null,
            $question,
            $answer,
            json_encode($context)
        ]);
        
        return (int)$this->pdo->lastInsertId();
    }

    /**
     * Log hint usage for analytics
     */
    private function logHintUsage(int $userId, int $practicalId, int $hintLevel): void
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO ai_tutor_interactions (
                user_id, practical_id, interaction_type, 
                user_message, ai_response, created_at
            ) VALUES (?, ?, 'hint_request', ?, ?, NOW())
        ");
        
        $stmt->execute([
            $userId,
            $practicalId,
            "Requested hint level {$hintLevel}",
            "Hint provided at level {$hintLevel}"
        ]);
    }

    /**
     * Generate follow-up question suggestions
     */
    private function generateFollowUpSuggestions(string $question, array $context): array
    {
        $suggestions = [];
        
        // Based on the lesson context
        if (!empty($context['objectives'])) {
            foreach (array_slice($context['objectives'], 0, 2) as $obj) {
                $suggestions[] = "Can you explain more about " . strtolower(preg_replace('/^By the end of this lesson, learners will be able to /i', '', $obj['objective_text']));
            }
        }
        
        // Common follow-ups
        $suggestions[] = "Can you give me a practical example?";
        $suggestions[] = "How does this relate to what we learned before?";
        $suggestions[] = "What are common mistakes to avoid?";
        
        return array_slice($suggestions, 0, 3);
    }

    /**
     * Get related resources for the current context
     */
    private function getRelatedResources(array $context): array
    {
        if (empty($context['lesson_id'])) {
            return [];
        }

        // Get lesson resources
        $stmt = $this->pdo->prepare("SELECT resources FROM lessons WHERE id = ?");
        $stmt->execute([$context['lesson_id']]);
        $lesson = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $lesson && $lesson['resources'] ? json_decode($lesson['resources'], true) : [];
    }

    // Database helper methods
    private function getLessonDetails(int $lessonId): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM lessons WHERE id = ?");
        $stmt->execute([$lessonId]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    private function getModuleDetails(int $moduleId): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM modules WHERE id = ?");
        $stmt->execute([$moduleId]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    private function getCourseDetails(int $courseId): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM courses WHERE id = ?");
        $stmt->execute([$courseId]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    private function getLearningObjectives(int $lessonId): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM learning_objectives WHERE lesson_id = ? ORDER BY objective_number");
        $stmt->execute([$lessonId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function getPracticalDetails(int $practicalId): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM practicals WHERE id = ?");
        $stmt->execute([$practicalId]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    private function getQuizDetails(int $quizId): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM quizzes WHERE id = ?");
        $stmt->execute([$quizId]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    private function getLatestSubmission(int $userId, int $practicalId): ?array
    {
        $stmt = $this->pdo->prepare("
            SELECT * FROM practical_submissions 
            WHERE user_id = ? AND practical_id = ? 
            ORDER BY created_at DESC LIMIT 1
        ");
        $stmt->execute([$userId, $practicalId]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    private function getStudentProgress(int $userId, int $courseId): array
    {
        // Get total lessons in course
        $stmt = $this->pdo->prepare("
            SELECT COUNT(*) as total FROM lessons l
            JOIN modules m ON l.module_id = m.id
            WHERE m.course_id = ?
        ");
        $stmt->execute([$courseId]);
        $total = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        // Get completed lessons
        $stmt = $this->pdo->prepare("
            SELECT COUNT(*) as completed FROM lesson_progress lp
            JOIN lessons l ON lp.lesson_id = l.id
            JOIN modules m ON l.module_id = m.id
            WHERE lp.user_id = ? AND m.course_id = ? AND lp.status = 'completed'
        ");
        $stmt->execute([$userId, $courseId]);
        $completed = $stmt->fetch(PDO::FETCH_ASSOC)['completed'] ?? 0;

        // Get quiz average
        $stmt = $this->pdo->prepare("
            SELECT AVG(qa.score) as avg_score FROM quiz_attempts qa
            JOIN quizzes q ON qa.quiz_id = q.id
            JOIN lessons l ON q.lesson_id = l.id
            JOIN modules m ON l.module_id = m.id
            WHERE qa.user_id = ? AND m.course_id = ?
        ");
        $stmt->execute([$userId, $courseId]);
        $quizAvg = $stmt->fetch(PDO::FETCH_ASSOC)['avg_score'] ?? 0;

        // Get practicals completed
        $stmt = $this->pdo->prepare("
            SELECT COUNT(*) as completed FROM practical_submissions ps
            JOIN practicals p ON ps.practical_id = p.id
            JOIN lessons l ON p.lesson_id = l.id
            JOIN modules m ON l.module_id = m.id
            WHERE ps.user_id = ? AND m.course_id = ? AND ps.status = 'approved'
        ");
        $stmt->execute([$userId, $courseId]);
        $practicalsCompleted = $stmt->fetch(PDO::FETCH_ASSOC)['completed'] ?? 0;

        return [
            'total_lessons' => $total,
            'lessons_completed' => $completed,
            'completion_percentage' => $total > 0 ? round(($completed / $total) * 100) : 0,
            'quiz_average' => round($quizAvg),
            'practicals_completed' => $practicalsCompleted,
            'study_streak' => $this->getStudyStreak($userId, $courseId)
        ];
    }

    private function getStudyStreak(int $userId, int $courseId): int
    {
        // Simplified streak calculation
        $stmt = $this->pdo->prepare("
            SELECT DATEDIFF(NOW(), MAX(created_at)) as days_since 
            FROM lesson_progress WHERE user_id = ?
        ");
        $stmt->execute([$userId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result && $result['days_since'] <= 1 ? 1 : 0;
    }

    private function identifyWeakAreas(int $userId, int $courseId): array
    {
        // Find topics where quiz scores are below average
        $stmt = $this->pdo->prepare("
            SELECT l.title as topic, AVG(qa.score) as avg_score
            FROM quiz_attempts qa
            JOIN quizzes q ON qa.quiz_id = q.id
            JOIN lessons l ON q.lesson_id = l.id
            JOIN modules m ON l.module_id = m.id
            WHERE qa.user_id = ? AND m.course_id = ?
            GROUP BY l.id
            HAVING avg_score < 70
            ORDER BY avg_score ASC
            LIMIT 3
        ");
        $stmt->execute([$userId, $courseId]);
        $lowScores = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $weakAreas = [];
        foreach ($lowScores as $score) {
            $weakAreas[] = [
                'topic' => $score['topic'],
                'reason' => "Quiz average: {$score['avg_score']}%"
            ];
        }

        return $weakAreas;
    }

    private function getRecentActivity(int $userId, int $courseId): string
    {
        $stmt = $this->pdo->prepare("
            SELECT l.title, lp.updated_at
            FROM lesson_progress lp
            JOIN lessons l ON lp.lesson_id = l.id
            JOIN modules m ON l.module_id = m.id
            WHERE lp.user_id = ? AND m.course_id = ?
            ORDER BY lp.updated_at DESC
            LIMIT 5
        ");
        $stmt->execute([$userId, $courseId]);
        $activity = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $lines = [];
        foreach ($activity as $a) {
            $lines[] = "- {$a['title']} (accessed {$a['updated_at']})";
        }

        return implode("\n", $lines) ?: "No recent activity";
    }

    private function getQuizAttemptDetails(int $attemptId): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM quiz_attempts WHERE id = ?");
        $stmt->execute([$attemptId]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    private function getAttemptAnswers(int $attemptId): array
    {
        // Get the attempt with its stored answers JSON
        $stmt = $this->pdo->prepare("
            SELECT qa.answers, qa.quiz_id 
            FROM quiz_attempts qa
            WHERE qa.id = ?
        ");
        $stmt->execute([$attemptId]);
        $attempt = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$attempt || empty($attempt['answers'])) {
            return [];
        }
        
        // Parse the JSON answers
        $answersJson = json_decode($attempt['answers'], true) ?? [];
        
        // Get quiz questions to match with answers
        $stmt = $this->pdo->prepare("
            SELECT id, question_number, question_text, correct_answer, options
            FROM quiz_questions 
            WHERE quiz_id = ?
            ORDER BY question_number
        ");
        $stmt->execute([$attempt['quiz_id']]);
        $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Build the answer details with question info
        $results = [];
        foreach ($answersJson as $index => $answerDetail) {
            $question = $questions[$index] ?? null;
            if (!$question) continue;
            
            $results[] = [
                'question_id' => $answerDetail['question_id'] ?? ($question['id'] ?? null),
                'question_text' => $question['question_text'],
                'student_answer' => $answerDetail['selected_answer'] ?? 'No answer',
                'correct_answer' => $answerDetail['correct_answer'] ?? $question['correct_answer'],
                'is_correct' => $answerDetail['is_correct'] ?? false,
                'topic' => 'General' // Could be derived from question tags if available
            ];
        }
        
        return $results;
    }
}
