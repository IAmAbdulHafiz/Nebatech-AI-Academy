<?php

namespace Nebatech\Services;

use OpenAI;

/**
 * AI Service for content generation and code review using OpenAI API
 */
class AIService
{
    private $client;
    private $model;
    private $maxTokens;
    private $temperature;

    public function __construct()
    {
        $config = require dirname(__DIR__, 2) . '/config/ai.php';
        
        $apiKey = $config['api_key'];
        if (empty($apiKey)) {
            throw new \Exception('OpenAI API key is not configured. Please set OPENAI_API_KEY in your environment.');
        }

        $this->client = OpenAI::client($apiKey);
        $this->model = $config['model'] ?? 'gpt-4-turbo-preview';
        $this->maxTokens = $config['max_tokens'] ?? 2000;
        $this->temperature = $config['temperature'] ?? 0.7;
    }

    /**
     * Generate course outline based on topic and level
     * 
     * @param string $topic The course topic
     * @param string $level The difficulty level (beginner, intermediate, advanced)
     * @param string $category The course category
     * @param int $durationHours Expected course duration in hours
     * @return array Array of modules with titles, descriptions, and objectives
     */
    public function generateCourseOutline(string $topic, string $level = 'beginner', string $category = '', int $durationHours = 40): array
    {
        $prompt = $this->buildCourseOutlinePrompt($topic, $level, $category, $durationHours);
        
        try {
            $response = $this->client->chat()->create([
                'model' => $this->model,
                'messages' => [
                    ['role' => 'system', 'content' => 'You are an expert curriculum designer for online tech education. Generate structured, practical course outlines in JSON format.'],
                    ['role' => 'user', 'content' => $prompt],
                ],
                'max_tokens' => $this->maxTokens,
                'temperature' => $this->temperature,
                'response_format' => ['type' => 'json_object']
            ]);

            $content = $response->choices[0]->message->content;
            $data = json_decode($content, true);
            
            return $data['modules'] ?? [];
        } catch (\Exception $e) {
            error_log('AI Course Outline Generation Error: ' . $e->getMessage());
            throw new \Exception('Failed to generate course outline. Please try again.');
        }
    }

    /**
     * Generate lesson content for a specific topic
     * 
     * @param string $topic The lesson topic
     * @param array $objectives Learning objectives for the lesson
     * @param string $lessonType Type of lesson (text, video, code, quiz, project)
     * @param string $level Difficulty level
     * @return array Lesson content including content, resources, and exercises
     */
    public function generateLessonContent(string $topic, array $objectives = [], string $lessonType = 'text', string $level = 'beginner'): array
    {
        $prompt = $this->buildLessonContentPrompt($topic, $objectives, $lessonType, $level);
        
        try {
            $response = $this->client->chat()->create([
                'model' => $this->model,
                'messages' => [
                    ['role' => 'system', 'content' => 'You are an expert instructional designer creating engaging, practical lesson content for tech education. Return structured JSON.'],
                    ['role' => 'user', 'content' => $prompt],
                ],
                'max_tokens' => $this->maxTokens,
                'temperature' => $this->temperature,
                'response_format' => ['type' => 'json_object']
            ]);

            $content = $response->choices[0]->message->content;
            $data = json_decode($content, true);
            
            return [
                'content' => $data['content'] ?? '',
                'resources' => $data['resources'] ?? [],
                'exercises' => $data['exercises'] ?? [],
                'duration_minutes' => $data['duration_minutes'] ?? 30,
                'key_points' => $data['key_points'] ?? []
            ];
        } catch (\Exception $e) {
            error_log('AI Lesson Content Generation Error: ' . $e->getMessage());
            throw new \Exception('Failed to generate lesson content. Please try again.');
        }
    }

    /**
     * Generate project brief/assignment
     * 
     * @param string $topic The project topic
     * @param string $level Difficulty level
     * @param array $skills Skills to be assessed
     * @param int $estimatedHours Estimated completion time
     * @return array Project brief with instructions, requirements, and rubric
     */
    public function generateProjectBrief(string $topic, string $level = 'intermediate', array $skills = [], int $estimatedHours = 8): array
    {
        $prompt = $this->buildProjectBriefPrompt($topic, $level, $skills, $estimatedHours);
        
        try {
            $response = $this->client->chat()->create([
                'model' => $this->model,
                'messages' => [
                    ['role' => 'system', 'content' => 'You are an expert at designing practical coding projects and assessments. Create realistic, industry-relevant project briefs in JSON format.'],
                    ['role' => 'user', 'content' => $prompt],
                ],
                'max_tokens' => $this->maxTokens,
                'temperature' => $this->temperature,
                'response_format' => ['type' => 'json_object']
            ]);

            $content = $response->choices[0]->message->content;
            $data = json_decode($content, true);
            
            return [
                'title' => $data['title'] ?? $topic,
                'description' => $data['description'] ?? '',
                'instructions' => $data['instructions'] ?? '',
                'requirements' => $data['requirements'] ?? [],
                'rubric' => $data['rubric'] ?? [],
                'starter_code' => $data['starter_code'] ?? '',
                'expected_deliverables' => $data['expected_deliverables'] ?? [],
                'max_score' => $data['max_score'] ?? 100
            ];
        } catch (\Exception $e) {
            error_log('AI Project Brief Generation Error: ' . $e->getMessage());
            throw new \Exception('Failed to generate project brief. Please try again.');
        }
    }

    /**
     * Evaluate a submission (text or code) and provide feedback
     * 
     * @param string $content The submitted content
     * @param string $assignmentDescription Assignment context
     * @param array $rubric Assessment rubric
     * @return array Feedback with score and comments
     */
    public function evaluateSubmission(string $content, string $assignmentDescription = '', array $rubric = []): array
    {
        $prompt = $this->buildSubmissionEvaluationPrompt($content, $assignmentDescription, $rubric);
        
        try {
            $response = $this->client->chat()->create([
                'model' => $this->model,
                'messages' => [
                    ['role' => 'system', 'content' => 'You are an expert instructor providing constructive feedback on student submissions. Evaluate the work fairly and provide actionable feedback in JSON format.'],
                    ['role' => 'user', 'content' => $prompt],
                ],
                'max_tokens' => $this->maxTokens,
                'temperature' => 0.5,
                'response_format' => ['type' => 'json_object']
            ]);

            $content = $response->choices[0]->message->content;
            $data = json_decode($content, true);
            
            return [
                'score' => $data['score'] ?? 0,
                'feedback' => $data['feedback'] ?? '',
                'strengths' => $data['strengths'] ?? [],
                'areas_for_improvement' => $data['areas_for_improvement'] ?? [],
                'suggestions' => $data['suggestions'] ?? []
            ];
        } catch (\Exception $e) {
            error_log('AI Submission Evaluation Error: ' . $e->getMessage());
            return [
                'score' => 0,
                'feedback' => 'Unable to generate AI feedback at this time.',
                'strengths' => [],
                'areas_for_improvement' => [],
                'suggestions' => []
            ];
        }
    }

    /**
     * Review code submission and provide feedback
     * 
     * @param string $code The submitted code
     * @param string $language Programming language
     * @param array $rubric Assessment rubric
     * @param string $assignmentDescription Assignment context
     * @return array Feedback with score, comments, and suggestions
     */
    public function reviewCode(string $code, string $language, array $rubric = [], string $assignmentDescription = ''): array
    {
        $prompt = $this->buildCodeReviewPrompt($code, $language, $rubric, $assignmentDescription);
        
        try {
            $response = $this->client->chat()->create([
                'model' => $this->model,
                'messages' => [
                    ['role' => 'system', 'content' => 'You are an expert code reviewer and programming instructor. Provide constructive, detailed feedback on student code submissions in JSON format.'],
                    ['role' => 'user', 'content' => $prompt],
                ],
                'max_tokens' => $this->maxTokens,
                'temperature' => 0.5, // Lower temperature for more consistent reviews
                'response_format' => ['type' => 'json_object']
            ]);

            $content = $response->choices[0]->message->content;
            $data = json_decode($content, true);
            
            return [
                'score' => $data['score'] ?? 0,
                'feedback' => $data['feedback'] ?? '',
                'strengths' => $data['strengths'] ?? [],
                'areas_for_improvement' => $data['areas_for_improvement'] ?? [],
                'suggestions' => $data['suggestions'] ?? [],
                'code_quality' => $data['code_quality'] ?? [],
                'rubric_scores' => $data['rubric_scores'] ?? []
            ];
        } catch (\Exception $e) {
            error_log('AI Code Review Error: ' . $e->getMessage());
            throw new \Exception('Failed to review code. Please try again.');
        }
    }

    /**
     * Generate quiz questions for a topic
     * 
     * @param string $topic The quiz topic
     * @param int $questionCount Number of questions to generate
     * @param string $difficulty Difficulty level
     * @param array $questionTypes Types of questions (multiple_choice, true_false, code_completion, short_answer)
     * @return array Quiz questions with answers
     */
    public function generateQuizQuestions(string $topic, int $questionCount = 5, string $difficulty = 'beginner', array $questionTypes = ['multiple_choice']): array
    {
        $prompt = $this->buildQuizPrompt($topic, $questionCount, $difficulty, $questionTypes);
        
        try {
            $response = $this->client->chat()->create([
                'model' => $this->model,
                'messages' => [
                    ['role' => 'system', 'content' => 'You are an expert at creating effective assessment questions for tech education. Generate clear, fair quiz questions in JSON format.'],
                    ['role' => 'user', 'content' => $prompt],
                ],
                'max_tokens' => $this->maxTokens,
                'temperature' => $this->temperature,
                'response_format' => ['type' => 'json_object']
            ]);

            $content = $response->choices[0]->message->content;
            $data = json_decode($content, true);
            
            return $data['questions'] ?? [];
        } catch (\Exception $e) {
            error_log('AI Quiz Generation Error: ' . $e->getMessage());
            throw new \Exception('Failed to generate quiz questions. Please try again.');
        }
    }

    /**
     * Build prompt for course outline generation
     */
    private function buildCourseOutlinePrompt(string $topic, string $level, string $category, int $durationHours): string
    {
        return <<<PROMPT
Generate a comprehensive course outline for the following:

Topic: {$topic}
Level: {$level}
Category: {$category}
Duration: {$durationHours} hours

Please provide a structured course outline with 6-10 modules. For each module, include:
- title: Clear, descriptive module title
- description: Brief overview of what students will learn
- objectives: Array of 3-5 specific learning objectives
- estimated_hours: Time to complete this module
- order_index: Sequential ordering (0, 1, 2, etc.)

Return the data in JSON format with this structure:
{
  "modules": [
    {
      "title": "Module Title",
      "description": "Module description",
      "objectives": ["Objective 1", "Objective 2"],
      "estimated_hours": 4,
      "order_index": 0
    }
  ]
}

Make the course practical, hands-on, and aligned with industry standards. Ensure logical progression from fundamentals to advanced topics.
PROMPT;
    }

    /**
     * Build prompt for lesson content generation
     */
    private function buildLessonContentPrompt(string $topic, array $objectives, string $lessonType, string $level): string
    {
        $objectivesText = !empty($objectives) ? implode("\n- ", $objectives) : "Cover the fundamentals";
        
        return <<<PROMPT
Generate comprehensive lesson content for the following:

Topic: {$topic}
Level: {$level}
Lesson Type: {$lessonType}
Learning Objectives:
- {$objectivesText}

Please provide detailed lesson content including:
- content: Main lesson content in Markdown format (explanations, examples, code snippets if applicable)
- resources: Array of useful resources (articles, documentation, videos) with title and url
- exercises: Array of practice exercises with title and description
- duration_minutes: Estimated time to complete this lesson
- key_points: Array of key takeaways

Return the data in JSON format with this structure:
{
  "content": "Detailed lesson content in Markdown...",
  "resources": [
    {"title": "Resource Title", "url": "https://example.com", "type": "article"}
  ],
  "exercises": [
    {"title": "Exercise Title", "description": "Exercise description"}
  ],
  "duration_minutes": 45,
  "key_points": ["Key point 1", "Key point 2"]
}

Make the content engaging, practical, and include real-world examples.
PROMPT;
    }

    /**
     * Build prompt for project brief generation
     */
    private function buildProjectBriefPrompt(string $topic, string $level, array $skills, int $estimatedHours): string
    {
        $skillsText = !empty($skills) ? implode(", ", $skills) : "various programming skills";
        
        return <<<PROMPT
Generate a practical project brief for the following:

Topic: {$topic}
Level: {$level}
Skills to Assess: {$skillsText}
Estimated Hours: {$estimatedHours}

Please provide a complete project brief including:
- title: Engaging project title
- description: Overview of what students will build
- instructions: Step-by-step guidance
- requirements: Array of specific functional requirements
- rubric: Assessment criteria with criteria name, description, and max_points
- starter_code: Basic code template (if applicable)
- expected_deliverables: What students should submit
- max_score: Total points (typically 100)

Return the data in JSON format with this structure:
{
  "title": "Project Title",
  "description": "Project overview...",
  "instructions": "Detailed instructions...",
  "requirements": ["Requirement 1", "Requirement 2"],
  "rubric": [
    {"criteria": "Functionality", "description": "Code works as expected", "max_points": 30},
    {"criteria": "Code Quality", "description": "Clean, readable code", "max_points": 25}
  ],
  "starter_code": "// Starter code here",
  "expected_deliverables": ["Source code files", "README.md"],
  "max_score": 100
}

Make the project realistic, industry-relevant, and appropriate for the skill level.
PROMPT;
    }

    /**
     * Build prompt for code review
     */
    private function buildCodeReviewPrompt(string $code, string $language, array $rubric, string $assignmentDescription): string
    {
        $rubricText = !empty($rubric) ? json_encode($rubric, JSON_PRETTY_PRINT) : "Standard code quality criteria";
        $contextText = !empty($assignmentDescription) ? "Assignment Context:\n{$assignmentDescription}\n\n" : "";
        
        return <<<PROMPT
Review the following {$language} code submission:

{$contextText}Code:
```{$language}
{$code}
```

Assessment Rubric:
{$rubricText}

Please provide a comprehensive code review including:
- score: Overall score out of 100
- feedback: Detailed summary of the submission
- strengths: Array of what the student did well
- areas_for_improvement: Array of specific areas needing improvement
- suggestions: Array of actionable suggestions for improvement
- code_quality: Object with scores for readability, efficiency, best_practices (each out of 10)
- rubric_scores: Scores for each rubric criterion

Return the data in JSON format with this structure:
{
  "score": 85,
  "feedback": "Overall feedback...",
  "strengths": ["Strength 1", "Strength 2"],
  "areas_for_improvement": ["Area 1", "Area 2"],
  "suggestions": ["Suggestion 1", "Suggestion 2"],
  "code_quality": {
    "readability": 8,
    "efficiency": 7,
    "best_practices": 9
  },
  "rubric_scores": [
    {"criteria": "Functionality", "score": 28, "max_points": 30}
  ]
}

Be constructive, specific, and educational in your feedback.
PROMPT;
    }

    /**
     * Build prompt for quiz generation
     */
    private function buildQuizPrompt(string $topic, int $questionCount, string $difficulty, array $questionTypes): string
    {
        $typesText = implode(", ", $questionTypes);
        
        return <<<PROMPT
Generate {$questionCount} quiz questions for the following:

Topic: {$topic}
Difficulty: {$difficulty}
Question Types: {$typesText}

For each question, include:
- type: Question type (multiple_choice, true_false, code_completion, short_answer)
- question: The question text
- options: Array of answer options (for multiple_choice)
- correct_answer: The correct answer
- explanation: Why this is the correct answer
- points: Points for this question

Return the data in JSON format with this structure:
{
  "questions": [
    {
      "type": "multiple_choice",
      "question": "Question text?",
      "options": ["Option A", "Option B", "Option C", "Option D"],
      "correct_answer": "Option B",
      "explanation": "Explanation of the correct answer",
      "points": 10
    }
  ]
}

Make questions clear, fair, and testing understanding rather than memorization.
PROMPT;
    }

    /**
     * Build prompt for submission evaluation
     */
    private function buildSubmissionEvaluationPrompt(string $content, string $assignmentDescription, array $rubric): string
    {
        $rubricText = !empty($rubric) ? json_encode($rubric, JSON_PRETTY_PRINT) : "Standard assessment criteria";
        $contextText = !empty($assignmentDescription) ? "Assignment Description:\n{$assignmentDescription}\n\n" : "";
        
        return <<<PROMPT
Evaluate the following student submission:

{$contextText}Submission Content:
{$content}

Assessment Rubric:
{$rubricText}

Please provide a comprehensive evaluation including:
- score: Overall score out of 100
- feedback: Detailed summary of the submission quality
- strengths: Array of what the student did well
- areas_for_improvement: Array of specific areas needing improvement
- suggestions: Array of actionable suggestions for improvement

Return the data in JSON format with this structure:
{
  "score": 85,
  "feedback": "Overall feedback on the submission...",
  "strengths": ["Strength 1", "Strength 2"],
  "areas_for_improvement": ["Area 1", "Area 2"],
  "suggestions": ["Suggestion 1", "Suggestion 2"]
}

Be constructive, specific, and educational in your feedback. Focus on helping the student learn and improve.
PROMPT;
    }
}
