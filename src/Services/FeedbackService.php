<?php

namespace Nebatech\Services;

use Nebatech\Models\Submission;
use Nebatech\Models\Assignment;

class FeedbackService
{
    private AIService $aiService;

    public function __construct()
    {
        $this->aiService = new AIService();
    }

    /**
     * Generate comprehensive feedback for a code submission
     * 
     * @param int $submissionId The submission ID to review
     * @return array Feedback results with score and detailed analysis
     */
    public function generateFeedback(int $submissionId): array
    {
        try {
            // Get submission details
            $submission = Submission::findById($submissionId);
            if (!$submission) {
                throw new \Exception('Submission not found');
            }

            // Get assignment details
            $assignment = Assignment::findById($submission['assignment_id']);
            if (!$assignment) {
                throw new \Exception('Assignment not found');
            }

            // Load the submitted code
            $code = $this->loadSubmissionCode($submission['file_path']);
            if (!$code) {
                throw new \Exception('Could not load submission code');
            }

            // Parse the code to extract HTML, CSS, and JavaScript
            $parsedCode = $this->parseCodeFile($code);

            // Validate code syntax and quality
            $validationResults = $this->validateCode($parsedCode);

            // Generate AI feedback using rubric
            $rubric = is_string($assignment['rubric']) 
                ? json_decode($assignment['rubric'], true) 
                : $assignment['rubric'];

            $aiReview = $this->aiService->reviewCode(
                $code,
                'html', // Primary language
                $rubric ?? [],
                $assignment['description']
            );

            // Combine validation and AI feedback
            $feedback = $this->compileFeedback(
                $aiReview,
                $validationResults,
                $assignment['max_score']
            );

            // Update submission with feedback
            $this->updateSubmission($submissionId, $feedback);

            return [
                'success' => true,
                'feedback' => $feedback
            ];

        } catch (\Exception $e) {
            error_log('Feedback generation failed: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Generate feedback for multiple submissions (batch processing)
     * 
     * @param array $submissionIds Array of submission IDs
     * @return array Results for each submission
     */
    public function generateBatchFeedback(array $submissionIds): array
    {
        $results = [];
        foreach ($submissionIds as $submissionId) {
            $results[$submissionId] = $this->generateFeedback($submissionId);
        }
        return $results;
    }

    /**
     * Load code from submission file
     */
    private function loadSubmissionCode(string $filePath): ?string
    {
        $fullPath = __DIR__ . '/../../storage/submissions/' . $filePath;
        
        if (!file_exists($fullPath)) {
            return null;
        }

        return file_get_contents($fullPath);
    }

    /**
     * Parse HTML file to extract separate HTML, CSS, and JS sections
     */
    private function parseCodeFile(string $code): array
    {
        $result = [
            'html' => '',
            'css' => '',
            'js' => '',
            'full' => $code
        ];

        // Extract CSS from style tags
        if (preg_match('/<style[^>]*>(.*?)<\/style>/is', $code, $cssMatches)) {
            $result['css'] = trim($cssMatches[1]);
        }

        // Extract JavaScript from script tags
        if (preg_match('/<script[^>]*>(.*?)<\/script>/is', $code, $jsMatches)) {
            $result['js'] = trim($jsMatches[1]);
        }

        // Extract body content
        if (preg_match('/<body[^>]*>(.*?)<\/body>/is', $code, $bodyMatches)) {
            $html = trim($bodyMatches[1]);
            // Remove inline scripts from HTML
            $html = preg_replace('/<script[^>]*>.*?<\/script>/is', '', $html);
            $result['html'] = $html;
        }

        return $result;
    }

    /**
     * Validate code for syntax errors and quality issues
     */
    private function validateCode(array $parsedCode): array
    {
        $issues = [];

        // HTML validation
        $htmlIssues = $this->validateHTML($parsedCode['html']);
        if (!empty($htmlIssues)) {
            $issues['html'] = $htmlIssues;
        }

        // CSS validation
        $cssIssues = $this->validateCSS($parsedCode['css']);
        if (!empty($cssIssues)) {
            $issues['css'] = $cssIssues;
        }

        // JavaScript validation
        $jsIssues = $this->validateJavaScript($parsedCode['js']);
        if (!empty($jsIssues)) {
            $issues['javascript'] = $jsIssues;
        }

        return [
            'has_issues' => !empty($issues),
            'issues' => $issues,
            'summary' => $this->createValidationSummary($issues)
        ];
    }

    /**
     * Validate HTML structure and common issues
     */
    private function validateHTML(string $html): array
    {
        $issues = [];

        if (empty(trim($html))) {
            $issues[] = [
                'severity' => 'error',
                'message' => 'HTML content is empty'
            ];
            return $issues;
        }

        // Check for common HTML issues
        $checks = [
            ['pattern' => '/<img(?![^>]*alt=)/i', 'message' => 'Image tags should have alt attributes for accessibility', 'severity' => 'warning'],
            ['pattern' => '/<a(?![^>]*href=)/i', 'message' => 'Anchor tags should have href attributes', 'severity' => 'warning'],
            ['pattern' => '/style\s*=\s*["\'][^"\']*["\']/i', 'message' => 'Inline styles detected - consider using external CSS', 'severity' => 'info'],
            ['pattern' => '/<font/i', 'message' => 'Deprecated <font> tag detected - use CSS instead', 'severity' => 'warning'],
            ['pattern' => '/<center/i', 'message' => 'Deprecated <center> tag detected - use CSS text-align instead', 'severity' => 'warning'],
        ];

        foreach ($checks as $check) {
            if (preg_match($check['pattern'], $html)) {
                $issues[] = [
                    'severity' => $check['severity'],
                    'message' => $check['message']
                ];
            }
        }

        return $issues;
    }

    /**
     * Validate CSS for common issues
     */
    private function validateCSS(string $css): array
    {
        $issues = [];

        if (empty(trim($css))) {
            $issues[] = [
                'severity' => 'info',
                'message' => 'No CSS styles provided'
            ];
            return $issues;
        }

        // Check for syntax errors (basic)
        $braceCount = substr_count($css, '{') - substr_count($css, '}');
        if ($braceCount !== 0) {
            $issues[] = [
                'severity' => 'error',
                'message' => 'CSS has mismatched curly braces'
            ];
        }

        // Check for common issues
        $checks = [
            ['pattern' => '/!important/i', 'message' => 'Excessive use of !important detected - consider refactoring specificity', 'severity' => 'info'],
            ['pattern' => '/\*\s*\{/', 'message' => 'Universal selector (*) can impact performance', 'severity' => 'info'],
        ];

        foreach ($checks as $check) {
            if (preg_match($check['pattern'], $css)) {
                $issues[] = [
                    'severity' => $check['severity'],
                    'message' => $check['message']
                ];
            }
        }

        return $issues;
    }

    /**
     * Validate JavaScript for common issues
     */
    private function validateJavaScript(string $js): array
    {
        $issues = [];

        if (empty(trim($js))) {
            $issues[] = [
                'severity' => 'info',
                'message' => 'No JavaScript code provided'
            ];
            return $issues;
        }

        // Basic syntax checks
        $parenCount = substr_count($js, '(') - substr_count($js, ')');
        if ($parenCount !== 0) {
            $issues[] = [
                'severity' => 'error',
                'message' => 'JavaScript has mismatched parentheses'
            ];
        }

        $braceCount = substr_count($js, '{') - substr_count($js, '}');
        if ($braceCount !== 0) {
            $issues[] = [
                'severity' => 'error',
                'message' => 'JavaScript has mismatched curly braces'
            ];
        }

        $bracketCount = substr_count($js, '[') - substr_count($js, ']');
        if ($bracketCount !== 0) {
            $issues[] = [
                'severity' => 'error',
                'message' => 'JavaScript has mismatched brackets'
            ];
        }

        // Check for common issues
        $checks = [
            ['pattern' => '/var\s+\w+/i', 'message' => 'Consider using let or const instead of var', 'severity' => 'info'],
            ['pattern' => '/==(?!=)/i', 'message' => 'Consider using strict equality (===) instead of loose equality (==)', 'severity' => 'info'],
            ['pattern' => '/console\.log/i', 'message' => 'Console.log statements found - remove before production', 'severity' => 'info'],
            ['pattern' => '/eval\s*\(/i', 'message' => 'eval() is dangerous and should be avoided', 'severity' => 'warning'],
        ];

        foreach ($checks as $check) {
            if (preg_match($check['pattern'], $js)) {
                $issues[] = [
                    'severity' => $check['severity'],
                    'message' => $check['message']
                ];
            }
        }

        return $issues;
    }

    /**
     * Create validation summary from issues
     */
    private function createValidationSummary(array $issues): string
    {
        if (empty($issues)) {
            return 'No validation issues found. Great work!';
        }

        $errorCount = 0;
        $warningCount = 0;
        $infoCount = 0;

        foreach ($issues as $category => $categoryIssues) {
            foreach ($categoryIssues as $issue) {
                switch ($issue['severity']) {
                    case 'error':
                        $errorCount++;
                        break;
                    case 'warning':
                        $warningCount++;
                        break;
                    case 'info':
                        $infoCount++;
                        break;
                }
            }
        }

        $parts = [];
        if ($errorCount > 0) {
            $parts[] = "$errorCount error" . ($errorCount > 1 ? 's' : '');
        }
        if ($warningCount > 0) {
            $parts[] = "$warningCount warning" . ($warningCount > 1 ? 's' : '');
        }
        if ($infoCount > 0) {
            $parts[] = "$infoCount info message" . ($infoCount > 1 ? 's' : '');
        }

        return 'Found ' . implode(', ', $parts);
    }

    /**
     * Compile final feedback from AI review and validation
     */
    private function compileFeedback(
        array $aiReview,
        array $validationResults,
        int $maxScore
    ): array {
        // Extract AI score and adjust based on validation
        $baseScore = $aiReview['score'] ?? 0;
        $adjustedScore = $this->adjustScoreForValidation($baseScore, $validationResults, $maxScore);

        // Compile all feedback sections
        $feedback = [
            'score' => $adjustedScore,
            'max_score' => $maxScore,
            'percentage' => round(($adjustedScore / $maxScore) * 100, 1),
            'ai_feedback' => [
                'overall_feedback' => $aiReview['feedback'] ?? '',
                'strengths' => $aiReview['strengths'] ?? [],
                'improvements' => $aiReview['improvements'] ?? [],
                'suggestions' => $aiReview['suggestions'] ?? []
            ],
            'validation' => [
                'has_issues' => $validationResults['has_issues'],
                'summary' => $validationResults['summary'],
                'issues' => $validationResults['issues']
            ],
            'generated_at' => date('Y-m-d H:i:s'),
            'grade_level' => $this->getGradeLevel($adjustedScore, $maxScore)
        ];

        return $feedback;
    }

    /**
     * Adjust score based on validation issues
     */
    private function adjustScoreForValidation(
        int $baseScore,
        array $validationResults,
        int $maxScore
    ): int {
        if (!$validationResults['has_issues']) {
            return $baseScore;
        }

        $deduction = 0;
        foreach ($validationResults['issues'] as $category => $issues) {
            foreach ($issues as $issue) {
                switch ($issue['severity']) {
                    case 'error':
                        $deduction += 3; // Major errors: -3 points each
                        break;
                    case 'warning':
                        $deduction += 1; // Warnings: -1 point each
                        break;
                    case 'info':
                        $deduction += 0; // Info messages don't deduct points
                        break;
                }
            }
        }

        // Apply deduction but don't go below 0
        $adjustedScore = max(0, $baseScore - $deduction);

        // Don't exceed max score
        return min($adjustedScore, $maxScore);
    }

    /**
     * Get grade level based on score
     */
    private function getGradeLevel(int $score, int $maxScore): string
    {
        $percentage = ($score / $maxScore) * 100;

        if ($percentage >= 90) {
            return 'A (Excellent)';
        } elseif ($percentage >= 80) {
            return 'B (Good)';
        } elseif ($percentage >= 70) {
            return 'C (Satisfactory)';
        } elseif ($percentage >= 60) {
            return 'D (Needs Improvement)';
        } else {
            return 'F (Incomplete)';
        }
    }

    /**
     * Update submission with generated feedback
     */
    private function updateSubmission(int $submissionId, array $feedback): void
    {
        Submission::update($submissionId, [
            'score' => $feedback['score'],
            'ai_feedback' => json_encode($feedback),
            'status' => 'graded',
            'graded_at' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Regenerate feedback for a submission (e.g., after code update)
     */
    public function regenerateFeedback(int $submissionId): array
    {
        // Mark submission as pending review
        Submission::update($submissionId, [
            'status' => 'pending',
            'ai_feedback' => null,
            'score' => null,
            'graded_at' => null
        ]);

        // Generate fresh feedback
        return $this->generateFeedback($submissionId);
    }

    /**
     * Get detailed feedback for display
     */
    public function getFeedbackDetails(int $submissionId): ?array
    {
        $submission = Submission::findById($submissionId);
        
        if (!$submission || !$submission['ai_feedback']) {
            return null;
        }

        $feedback = is_string($submission['ai_feedback']) 
            ? json_decode($submission['ai_feedback'], true)
            : $submission['ai_feedback'];

        return $feedback;
    }
}
