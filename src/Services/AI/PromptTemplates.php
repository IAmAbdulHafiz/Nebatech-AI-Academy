<?php

namespace Nebatech\Services\AI;

/**
 * Prompt Templates for AI Tutor
 * Contains all structured prompts for different AI interactions
 */
class PromptTemplates
{
    /**
     * Build the main tutor system prompt
     */
    public function buildTutorPrompt(array $studentProfile, array $relevantContent, array $context): string
    {
        $lessonContext = '';
        if (!empty($relevantContent)) {
            $lessonContext = "\n\nRELEVANT COURSE CONTENT:\n" . implode("\n---\n", array_column($relevantContent, 'content'));
        }

        $studentContext = '';
        if (!empty($studentProfile)) {
            $style = $studentProfile['preferred_explanation_style'] ?? 'examples';
            $level = $studentProfile['preferred_difficulty'] ?? 'medium';
            $studentContext = "\n\nSTUDENT PREFERENCES:\n- Explanation style: {$style}\n- Current level: {$level}";
        }

        return <<<PROMPT
You are an expert AI tutor for Nebatech AI Academy, an online learning platform for programming and technology courses.

YOUR ROLE:
- Help students understand programming concepts clearly
- Provide guidance without giving away complete solutions
- Use the Socratic method when appropriate - ask guiding questions
- Encourage students to think critically and problem-solve
- Be patient, supportive, and encouraging
- Adapt your explanations to the student's level

GUIDELINES:
1. Keep responses concise but thorough (aim for 150-300 words unless more detail is needed)
2. Use code examples when helpful, always with syntax highlighting hints
3. Break down complex concepts into smaller, digestible parts
4. Relate new concepts to things the student already knows
5. When students make mistakes, guide them to discover the error themselves
6. Celebrate progress and maintain a positive, encouraging tone
7. If you don't know something, admit it honestly

FORMATTING:
- Use markdown for formatting
- Use ```language for code blocks
- Use **bold** for key terms
- Use bullet points for lists

{$studentContext}
{$lessonContext}

Remember: You're helping students learn, not just giving answers. Guide them to understanding!
PROMPT;
    }

    /**
     * System prompt for code review
     */
    public function getCodeReviewSystemPrompt(): string
    {
        return <<<PROMPT
You are an expert code reviewer for Nebatech AI Academy. Your role is to provide constructive, educational feedback on student code.

REVIEW STRUCTURE:
1. **Overall Assessment** - Brief summary (1-2 sentences)
2. **What's Working Well** - Highlight good practices (2-3 points)
3. **Areas for Improvement** - Specific issues with explanations (2-4 points)
4. **Code Quality Score** - Rate out of 100
5. **Suggestions** - Actionable improvements

GUIDELINES:
- Be encouraging but honest
- Explain WHY something is an issue, not just WHAT
- Suggest specific fixes with code examples when helpful
- Consider: correctness, readability, efficiency, best practices
- For beginners, focus on fundamentals; for advanced, mention optimization
- Always end with something positive or encouraging

FORMAT:
Use markdown with clear headings. Include code snippets for suggested improvements.
PROMPT;
    }

    /**
     * Build code review prompt
     */
    public function buildCodeReviewPrompt(string $code, string $language, ?array $lessonContext, array $context): string
    {
        $lessonInfo = '';
        if ($lessonContext) {
            $lessonInfo = "\n\nLESSON CONTEXT:\nThis code is for the lesson: \"{$lessonContext['title']}\"\nTopics covered: " . ($lessonContext['topics'] ?? 'General programming');
        }

        $assignmentInfo = '';
        if (!empty($context['assignment_description'])) {
            $assignmentInfo = "\n\nASSIGNMENT:\n" . $context['assignment_description'];
        }

        return <<<PROMPT
Please review the following {$language} code:

```{$language}
{$code}
```
{$lessonInfo}
{$assignmentInfo}

Provide a comprehensive code review following the structured format.
PROMPT;
    }

    /**
     * System prompt for practice generation
     */
    public function getPracticeSystemPrompt(): string
    {
        return <<<PROMPT
You are a practice problem generator for Nebatech AI Academy. Generate educational practice problems that help reinforce learning.

OUTPUT FORMAT (JSON):
{
    "problems": [
        {
            "type": "multiple_choice|coding|fill_blank|conceptual|debugging",
            "difficulty": "easy|medium|hard",
            "question": "The problem question",
            "language": "python|javascript|etc (for coding problems)",
            "options": ["A", "B", "C", "D"] (for multiple choice),
            "correct_answer": "The correct answer or expected output",
            "hint": "A helpful hint",
            "explanation": "Why this answer is correct"
        }
    ]
}

GUIDELINES:
- Generate 3-5 problems of varying types
- Problems should test understanding, not just memorization
- Include practical, real-world scenarios when possible
- Coding problems should be solvable in 5-15 minutes
- Provide clear, unambiguous questions
PROMPT;
    }

    /**
     * Build practice generation prompt
     */
    public function buildPracticePrompt(array $lessonContent, string $type, string $difficulty, array $studentProfile): string
    {
        $typeInstruction = match($type) {
            'coding' => 'Generate ONLY coding problems that require writing code.',
            'multiple_choice' => 'Generate ONLY multiple choice questions.',
            'conceptual' => 'Generate ONLY conceptual questions that test understanding.',
            'debugging' => 'Generate ONLY debugging problems with broken code to fix.',
            default => 'Generate a MIX of problem types (coding, multiple choice, conceptual).'
        };

        $difficultyGuide = match($difficulty) {
            'easy' => 'Problems should be straightforward and test basic understanding.',
            'hard' => 'Problems should be challenging and require deeper thinking or combining multiple concepts.',
            default => 'Problems should be moderately challenging, testing solid understanding.'
        };

        return <<<PROMPT
Generate practice problems for the following lesson:

LESSON: {$lessonContent['title']}
CONTENT:
{$lessonContent['content']}

REQUIREMENTS:
- {$typeInstruction}
- Difficulty: {$difficulty} - {$difficultyGuide}
- Generate 4 problems
- Problems should directly relate to the lesson content
- Include varied question styles

Return valid JSON only.
PROMPT;
    }

    /**
     * Build evaluation prompt for practice answers
     */
    public function buildEvaluationPrompt(array $problem, string $userAnswer): string
    {
        $problemType = $problem['type'] ?? 'general';
        $question = $problem['question'] ?? '';
        $correctAnswer = $problem['correct_answer'] ?? '';

        return <<<PROMPT
Evaluate this student's answer to a {$problemType} problem.

QUESTION:
{$question}

EXPECTED ANSWER/SOLUTION:
{$correctAnswer}

STUDENT'S ANSWER:
{$userAnswer}

EVALUATION CRITERIA:
1. Is the answer correct? (Be fair - accept equivalent correct answers)
2. Give a score from 0-100
3. Provide brief, encouraging feedback
4. If incorrect, explain the correct approach without being discouraging

FORMAT YOUR RESPONSE AS:
Correct/Incorrect: [Yes/No]
Score: [0-100]%
Feedback: [Your feedback here]
PROMPT;
    }

    /**
     * Get explanation system prompt based on style
     */
    public function getExplanationSystemPrompt(string $style): string
    {
        $styleGuide = match($style) {
            'simple' => 'Explain like I\'m 5. Use very simple language, analogies from everyday life, and avoid technical jargon.',
            'detailed' => 'Provide a comprehensive, in-depth explanation with technical details, covering edge cases and underlying principles.',
            'examples' => 'Focus heavily on practical examples. For each concept, provide 2-3 concrete examples showing how it works.',
            'analogies' => 'Explain using creative analogies and metaphors. Connect technical concepts to familiar real-world things.',
            'visual' => 'Describe in a way that could be visualized. Use ASCII diagrams where helpful.',
            default => 'Explain clearly and concisely with a balance of theory and examples.'
        };

        return <<<PROMPT
You are explaining programming concepts to a student. {$styleGuide}

GUIDELINES:
- Be clear and engaging
- Build from simple to complex
- Use code examples when appropriate
- Check for understanding with rhetorical questions
- Keep the explanation focused and relevant
PROMPT;
    }

    /**
     * Build explanation prompt
     */
    public function buildExplanationPrompt(string $concept, string $style, array $relevantContent): string
    {
        $context = '';
        if (!empty($relevantContent)) {
            $context = "\n\nFor reference, here's related course content:\n" . implode("\n", array_column($relevantContent, 'content'));
        }

        return <<<PROMPT
Please explain the following concept using the {$style} approach:

CONCEPT: {$concept}
{$context}

Provide a clear, helpful explanation.
PROMPT;
    }

    /**
     * Build recommendations prompt
     */
    public function buildRecommendationsPrompt(array $profile, array $recentProgress): string
    {
        $profileSummary = "Student has completed {$profile['total_practice_completed']} practice problems with an average score of {$profile['average_practice_score']}%.";
        
        $progressSummary = '';
        if (!empty($recentProgress)) {
            $courses = array_unique(array_column($recentProgress, 'course_title'));
            $progressSummary = "Recently working on: " . implode(', ', $courses);
        }

        return <<<PROMPT
Based on this student's learning profile, provide personalized recommendations:

PROFILE:
{$profileSummary}
Learning style: {$profile['learning_style']}
Preferred explanation style: {$profile['preferred_explanation_style']}

RECENT ACTIVITY:
{$progressSummary}

Provide 3-4 specific, actionable recommendations for:
1. What to study next
2. Skills to practice
3. Learning strategies to try
4. Motivation/encouragement

Keep recommendations concise and practical.
PROMPT;
    }

    /**
     * Build hint prompt for assignments
     */
    public function buildHintPrompt(array $assignment, string $studentCode, int $hintLevel): string
    {
        $hintInstruction = match($hintLevel) {
            1 => 'Give a VERY subtle hint. Just point in the right direction without revealing the solution.',
            2 => 'Give a moderate hint. Explain the concept they should apply.',
            3 => 'Give a strong hint. Show a similar example or pseudo-code approach.',
            default => 'Give a moderate hint.'
        };

        return <<<PROMPT
A student needs help with this assignment:

ASSIGNMENT:
{$assignment['description']}

STUDENT'S CURRENT CODE:
```
{$studentCode}
```

{$hintInstruction}

Remember: Help them learn, don't solve it for them. Guide them to discover the solution themselves.
PROMPT;
    }

    /**
     * Build quiz explanation prompt for wrong answers
     */
    public function buildQuizExplanationPrompt(array $question, string $userAnswer, string $correctAnswer): string
    {
        return <<<PROMPT
A student answered a quiz question incorrectly. Help them understand:

QUESTION:
{$question['question']}

STUDENT'S ANSWER: {$userAnswer}
CORRECT ANSWER: {$correctAnswer}

Provide a brief, encouraging explanation of:
1. Why the correct answer is right
2. Why their answer was incorrect (without being discouraging)
3. A quick tip to remember this concept

Keep it concise (3-4 sentences).
PROMPT;
    }

    /**
     * Build debugging help prompt
     */
    public function buildDebuggingPrompt(string $code, string $error, string $language): string
    {
        return <<<PROMPT
A student is debugging their {$language} code and encountered an error.

CODE:
```{$language}
{$code}
```

ERROR:
{$error}

Help them debug by:
1. Explaining what the error means in simple terms
2. Identifying the likely cause (line number if possible)
3. Suggesting how to investigate/fix it
4. Teaching them how to prevent this type of error

Guide them to the solution without just fixing the code for them.
PROMPT;
    }
}
