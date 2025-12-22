<?php

namespace Nebatech\Controllers;

use Nebatech\Core\Controller;
use Nebatech\Models\Lesson;
use Nebatech\Models\Submission;
use Nebatech\Models\Assignment;
use Nebatech\Services\FeedbackService;

class CodeEditorController extends Controller
{
    /**
     * Show code editor for a lesson
     */
    public function index(array $params = [])
    {
        $this->requireAuth();
        $user = $this->getCurrentUser();
        
        $lessonId = isset($params['id']) ? (int) $params['id'] : null;
        
        $lesson = null;
        if ($lessonId) {
            $lesson = Lesson::findById($lessonId);
            if (!$lesson) {
                $_SESSION['error'] = 'Lesson not found.';
                header('Location: ' . url('/dashboard'));
                exit;
            }
        }
        
        echo $this->render('code-editor/index', [
            'title' => 'Code Editor',
            'user' => $user,
            'lesson' => $lesson
        ]);
    }
    
    /**
     * Show code editor for an assignment
     */
    public function assignment(array $params = [])
    {
        $assignmentId = (int) ($params['id'] ?? 0);
        if (!$assignmentId) {
            $_SESSION['error'] = 'Invalid assignment ID.';
            header('Location: ' . url('/dashboard'));
            exit;
        }

        $this->requireAuth();
        $user = $this->getCurrentUser();
        
        $assignment = Assignment::findById($assignmentId);
        if (!$assignment) {
            $_SESSION['error'] = 'Assignment not found.';
            header('Location: ' . url('/dashboard'));
            exit;
        }
        
        // Get the lesson
        $lesson = Lesson::findById($assignment['lesson_id']);
        
        // Check if user has already submitted
        $existingSubmission = Submission::getByUserAndAssignment($user['id'], $assignmentId);
        
        echo $this->render('code-editor/assignment', [
            'title' => 'Assignment: ' . $assignment['title'],
            'user' => $user,
            'assignment' => $assignment,
            'lesson' => $lesson,
            'submission' => $existingSubmission
        ]);
    }

    /**
     * Supported programming languages with Judge0 IDs
     */
    private function getSupportedLanguages(): array
    {
        return [
            'javascript' => ['name' => 'JavaScript (Node.js)', 'id' => 63],
            'python' => ['name' => 'Python 3', 'id' => 71],
            'java' => ['name' => 'Java', 'id' => 62],
            'cpp' => ['name' => 'C++', 'id' => 54],
            'c' => ['name' => 'C', 'id' => 50],
            'php' => ['name' => 'PHP', 'id' => 68],
            'ruby' => ['name' => 'Ruby', 'id' => 72],
            'go' => ['name' => 'Go', 'id' => 60],
            'rust' => ['name' => 'Rust', 'id' => 73],
            'typescript' => ['name' => 'TypeScript', 'id' => 74],
            'csharp' => ['name' => 'C#', 'id' => 51],
            'swift' => ['name' => 'Swift', 'id' => 83],
            'kotlin' => ['name' => 'Kotlin', 'id' => 78],
            'sql' => ['name' => 'SQL', 'id' => 82],
            'bash' => ['name' => 'Bash', 'id' => 46],
        ];
    }

    /**
     * Show code playground (free code editor)
     */
    public function playground()
    {
        $this->requireAuth();
        $user = $this->getCurrentUser();
        
        $languages = $this->getSupportedLanguages();
        
        echo $this->render('code/playground', [
            'title' => 'Code Playground',
            'pageTitle' => 'Code Playground',
            'user' => $user,
            'languages' => $languages
        ]);
    }

    /**
     * Execute code via Judge0 API
     */
    public function executeCode()
    {
        // Ensure JSON response even on errors
        header('Content-Type: application/json');
        
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                echo json_encode(['success' => false, 'error' => 'Invalid request method']);
                return;
            }
            
            // Check auth for API - return JSON error instead of redirect
            if (!isset($_SESSION['user_id'])) {
                http_response_code(401);
                echo json_encode(['success' => false, 'error' => 'Authentication required']);
                return;
            }
            
            $code = $_POST['code'] ?? '';
            $language = $_POST['language'] ?? 'javascript';
            $stdin = $_POST['stdin'] ?? '';
            
            if (empty($code)) {
                echo json_encode(['success' => false, 'error' => 'No code provided']);
                return;
            }
            
            $languages = $this->getSupportedLanguages();
            
            if (!isset($languages[$language])) {
                echo json_encode(['success' => false, 'error' => 'Unsupported language']);
                return;
            }
            
            $languageId = $languages[$language]['id'];
            
            // Get Judge0 API configuration - check multiple sources
            $apiKey = $_ENV['JUDGE0_API_KEY'] ?? $_SERVER['JUDGE0_API_KEY'] ?? getenv('JUDGE0_API_KEY') ?: '';
            $apiUrl = $_ENV['JUDGE0_API_URL'] ?? $_SERVER['JUDGE0_API_URL'] ?? getenv('JUDGE0_API_URL') ?: 'https://judge0-ce.p.rapidapi.com';
            $apiHost = $_ENV['JUDGE0_API_HOST'] ?? $_SERVER['JUDGE0_API_HOST'] ?? getenv('JUDGE0_API_HOST') ?: 'judge0-ce.p.rapidapi.com';
            
            // If no API key configured, use a simulated response for demo
            if (empty($apiKey)) {
                echo json_encode($this->simulateCodeExecution($code, $language, $stdin));
                return;
            }
            
            // Submit code to Judge0
            $submitUrl = $apiUrl . '/submissions?base64_encoded=true&wait=true';
            
            $payload = [
                'language_id' => $languageId,
                'source_code' => base64_encode($code),
                'stdin' => base64_encode($stdin)
            ];
            
            $ch = curl_init($submitUrl);
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => json_encode($payload),
                CURLOPT_HTTPHEADER => [
                    'Content-Type: application/json',
                    'X-RapidAPI-Key: ' . $apiKey,
                    'X-RapidAPI-Host: ' . $apiHost
                ],
                CURLOPT_TIMEOUT => 30
            ]);
            
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlError = curl_error($ch);
            curl_close($ch);
            
            if ($curlError) {
                echo json_encode(['success' => false, 'error' => 'Network error: ' . $curlError]);
                return;
            }
            
            if ($httpCode !== 200 && $httpCode !== 201) {
                echo json_encode(['success' => false, 'error' => 'Code execution service error (HTTP ' . $httpCode . ')']);
                return;
            }
            
            $result = json_decode($response, true);
            
            if (!$result) {
                echo json_encode(['success' => false, 'error' => 'Invalid response from execution service']);
                return;
            }
            
            // Decode base64 outputs
            $stdout = isset($result['stdout']) ? base64_decode($result['stdout']) : '';
            $stderr = isset($result['stderr']) ? base64_decode($result['stderr']) : '';
            $compileOutput = isset($result['compile_output']) ? base64_decode($result['compile_output']) : '';
            
            echo json_encode([
                'success' => true,
                'result' => [
                    'stdout' => $stdout,
                    'stderr' => $stderr,
                    'compile_output' => $compileOutput,
                    'status' => $result['status']['description'] ?? 'Unknown',
                    'time' => $result['time'] ?? null,
                    'memory' => $result['memory'] ?? null
                ]
            ]);
            
        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'error' => 'Execution failed: ' . $e->getMessage()]);
        } catch (\Error $e) {
            echo json_encode(['success' => false, 'error' => 'System error: ' . $e->getMessage()]);
        }
    }
    
    /**
     * Simulate code execution for demo/development purposes
     * Parses code and extracts output for realistic simulation
     */
    private function simulateCodeExecution(string $code, string $language, string $stdin): array
    {
        $startTime = microtime(true);
        $outputs = [];
        $error = '';
        
        switch ($language) {
            case 'javascript':
            case 'typescript':
                // Match all console.log statements
                preg_match_all('/console\.log\(([^)]+)\)/', $code, $matches);
                foreach ($matches[1] as $arg) {
                    $arg = trim($arg);
                    // Handle string literals
                    if (preg_match('/^["\'](.*)["\']\s*$/', $arg, $strMatch)) {
                        $outputs[] = $strMatch[1];
                    } elseif (preg_match('/^[\'"](.*)[\'"],\s*(.+)$/', $arg, $multiMatch)) {
                        $outputs[] = $multiMatch[1] . ' ' . trim($multiMatch[2]);
                    } else {
                        $outputs[] = '[' . $arg . ']';
                    }
                }
                break;
                
            case 'python':
                // Match all print statements
                preg_match_all('/print\(([^)]+)\)/', $code, $matches);
                foreach ($matches[1] as $arg) {
                    $arg = trim($arg);
                    if (preg_match('/^["\'](.*)["\']\s*$/', $arg, $strMatch)) {
                        $outputs[] = $strMatch[1];
                    } elseif (preg_match('/^f["\'](.*)["\']\s*$/', $arg, $fMatch)) {
                        $outputs[] = '[f-string: ' . $fMatch[1] . ']';
                    } else {
                        $outputs[] = '[' . $arg . ']';
                    }
                }
                break;
                
            case 'java':
                preg_match_all('/System\.out\.println?\(([^)]+)\)/', $code, $matches);
                foreach ($matches[1] as $arg) {
                    $arg = trim($arg);
                    if (preg_match('/^"(.*)"$/', $arg, $strMatch)) {
                        $outputs[] = $strMatch[1];
                    } else {
                        $outputs[] = '[' . $arg . ']';
                    }
                }
                break;
                
            case 'c':
            case 'cpp':
                // Match printf and cout
                preg_match_all('/printf\s*\(\s*"([^"]+)"/', $code, $printfMatches);
                foreach ($printfMatches[1] as $arg) {
                    $outputs[] = str_replace(['\\n', '\\t'], ["\n", "\t"], $arg);
                }
                preg_match_all('/cout\s*<<\s*"([^"]+)"/', $code, $coutMatches);
                foreach ($coutMatches[1] as $arg) {
                    $outputs[] = $arg;
                }
                if (strpos($code, 'endl') !== false && !empty($outputs)) {
                    $outputs[count($outputs) - 1] .= "\n";
                }
                break;
                
            case 'php':
                preg_match_all('/(?:echo|print)\s+["\']([^"\']+)["\']/', $code, $matches);
                foreach ($matches[1] as $arg) {
                    $outputs[] = $arg;
                }
                break;
                
            case 'ruby':
                preg_match_all('/puts\s+["\']([^"\']+)["\']/', $code, $matches);
                foreach ($matches[1] as $arg) {
                    $outputs[] = $arg;
                }
                break;
                
            case 'go':
                preg_match_all('/fmt\.Println\s*\(\s*"([^"]+)"/', $code, $matches);
                foreach ($matches[1] as $arg) {
                    $outputs[] = $arg;
                }
                break;
                
            case 'rust':
                preg_match_all('/println!\s*\(\s*"([^"]+)"/', $code, $matches);
                foreach ($matches[1] as $arg) {
                    $outputs[] = str_replace(['{}', '{:?}'], ['[value]', '[debug]'], $arg);
                }
                break;
                
            case 'csharp':
                preg_match_all('/Console\.WriteLine\s*\(\s*"([^"]+)"/', $code, $matches);
                foreach ($matches[1] as $arg) {
                    $outputs[] = $arg;
                }
                break;
                
            case 'swift':
            case 'kotlin':
                preg_match_all('/print(?:ln)?\s*\(\s*"([^"]+)"/', $code, $matches);
                foreach ($matches[1] as $arg) {
                    $outputs[] = $arg;
                }
                break;
                
            case 'bash':
                preg_match_all('/echo\s+["\']?([^"\';\n]+)["\']?/', $code, $matches);
                foreach ($matches[1] as $arg) {
                    $outputs[] = trim($arg);
                }
                break;
        }
        
        $output = !empty($outputs) ? implode("\n", $outputs) . "\n" : "[Program executed successfully]\n";
        $output .= "\n--- Simulated Output ---\nNote: Subscribe to Judge0 API on RapidAPI for real code execution.";
        
        $executionTime = round((microtime(true) - $startTime) * 1000, 2);
        
        return [
            'success' => true,
            'result' => [
                'stdout' => $output,
                'stderr' => $error,
                'compile_output' => '',
                'status' => 'Accepted',
                'time' => $executionTime / 1000,
                'memory' => rand(1000, 5000),
                'simulated' => true
            ]
        ];
    }
    
    /**
     * Save code submission
     */
    public function saveSubmission()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['success' => false, 'error' => 'Invalid request method'], 405);
            return;
        }
        
        $this->requireAuth();
        $user = $this->getCurrentUser();
        
        $assignmentId = (int)($_POST['assignment_id'] ?? 0);
        $code = $_POST['code'] ?? '';
        
        if (!$assignmentId || empty($code)) {
            $this->jsonResponse(['success' => false, 'error' => 'Missing required fields'], 400);
            return;
        }
        
        try {
            // Save code to file
            $filename = $this->saveCodeToFile($user['id'], $assignmentId, $code);
            
            // Check if submission exists
            $existing = Submission::getByUserAndAssignment($user['id'], $assignmentId);
            
            if ($existing) {
                // Update existing submission
                Submission::update($existing['id'], [
                    'file_path' => $filename,
                    'submitted_at' => date('Y-m-d H:i:s'),
                    'status' => 'pending'
                ]);
                $submissionId = $existing['id'];
            } else {
                // Create new submission
                $submissionId = Submission::createSubmission([
                    'assignment_id' => $assignmentId,
                    'user_id' => $user['id'],
                    'file_path' => $filename,
                    'submitted_at' => date('Y-m-d H:i:s'),
                    'status' => 'pending'
                ]);
            }
            
            $this->jsonResponse([
                'success' => true,
                'message' => 'Code saved successfully',
                'submission_id' => $submissionId
            ]);
        } catch (\Exception $e) {
            error_log('Submission save error: ' . $e->getMessage());
            $this->jsonResponse([
                'success' => false,
                'error' => 'Failed to save submission'
            ], 500);
        }
    }
    
    /**
     * Submit assignment for grading
     */
    public function submitAssignment()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['success' => false, 'error' => 'Invalid request method'], 405);
            return;
        }
        
        $this->requireAuth();
        $user = $this->getCurrentUser();
        
        $assignmentId = (int)($_POST['assignment_id'] ?? 0);
        $htmlCode = $_POST['html'] ?? '';
        $cssCode = $_POST['css'] ?? '';
        $jsCode = $_POST['js'] ?? '';
        
        if (!$assignmentId) {
            $this->jsonResponse(['success' => false, 'error' => 'Assignment ID is required'], 400);
            return;
        }
        
        try {
            // Combine all code
            $fullCode = $this->buildSubmissionHTML($htmlCode, $cssCode, $jsCode);
            
            // Save code to file
            $filename = $this->saveCodeToFile($user['id'], $assignmentId, $fullCode);
            
            // Check if submission exists
            $existing = Submission::getByUserAndAssignment($user['id'], $assignmentId);
            
            if ($existing) {
                // Update existing submission
                Submission::update($existing['id'], [
                    'file_path' => $filename,
                    'submitted_at' => date('Y-m-d H:i:s'),
                    'status' => 'submitted'
                ]);
                $submissionId = $existing['id'];
            } else {
                // Create new submission
                $submissionId = Submission::createSubmission([
                    'assignment_id' => $assignmentId,
                    'user_id' => $user['id'],
                    'file_path' => $filename,
                    'submitted_at' => date('Y-m-d H:i:s'),
                    'status' => 'submitted'
                ]);
            }
            
            // Trigger AI feedback generation
            $this->generateFeedbackAsync($submissionId);
            
            $_SESSION['success'] = 'Assignment submitted successfully! AI feedback is being generated.';
            
            $this->jsonResponse([
                'success' => true,
                'message' => 'Assignment submitted successfully. Generating AI feedback...',
                'submission_id' => $submissionId
            ]);
        } catch (\Exception $e) {
            error_log('Submission error: ' . $e->getMessage());
            $this->jsonResponse([
                'success' => false,
                'error' => 'Failed to submit assignment'
            ], 500);
        }
    }
    
    /**
     * Load saved code for an assignment
     */
    public function loadCode(array $params = [])
    {
        $assignmentId = (int) ($params['id'] ?? 0);
        if (!$assignmentId) {
            $this->jsonResponse([
                'success' => false,
                'error' => 'Invalid assignment ID'
            ], 400);
            return;
        }

        $this->requireAuth();
        $user = $this->getCurrentUser();
        
        $submission = Submission::getByUserAndAssignment($user['id'], $assignmentId);
        
        if (!$submission || !$submission['file_path']) {
            $this->jsonResponse([
                'success' => false,
                'error' => 'No saved code found'
            ], 404);
            return;
        }
        
        $filePath = __DIR__ . '/../../storage/submissions/' . $submission['file_path'];
        
        if (!file_exists($filePath)) {
            $this->jsonResponse([
                'success' => false,
                'error' => 'Code file not found'
            ], 404);
            return;
        }
        
        $code = file_get_contents($filePath);
        
        // Try to parse HTML/CSS/JS if it's a complete HTML document
        $parsed = $this->parseHTMLDocument($code);
        
        $this->jsonResponse([
            'success' => true,
            'code' => $code,
            'html' => $parsed['html'] ?? '',
            'css' => $parsed['css'] ?? '',
            'js' => $parsed['js'] ?? ''
        ]);
    }
    
    /**
     * Save code to file system
     */
    private function saveCodeToFile(int $userId, int $assignmentId, string $code): string
    {
        $uploadDir = __DIR__ . '/../../storage/submissions';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        $filename = "user_{$userId}_assignment_{$assignmentId}_" . time() . '.html';
        $filepath = $uploadDir . '/' . $filename;
        
        if (file_put_contents($filepath, $code) === false) {
            throw new \Exception('Failed to write code file');
        }
        
        return $filename;
    }
    
    /**
     * Build complete HTML document from separate HTML/CSS/JS
     */
    private function buildSubmissionHTML(string $html, string $css, string $js): string
    {
        return "<!DOCTYPE html>
<html lang=\"en\">
<head>
    <meta charset=\"UTF-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <title>Submission</title>
    <style>
{$css}
    </style>
</head>
<body>
{$html}
    <script>
{$js}
    </script>
</body>
</html>";
    }
    
    /**
     * Parse HTML document to extract HTML/CSS/JS sections
     */
    private function parseHTMLDocument(string $code): array
    {
        $result = ['html' => '', 'css' => '', 'js' => ''];
        
        // Extract CSS
        if (preg_match('/<style[^>]*>(.*?)<\/style>/is', $code, $cssMatches)) {
            $result['css'] = trim($cssMatches[1]);
        }
        
        // Extract JS
        if (preg_match('/<script[^>]*>(.*?)<\/script>/is', $code, $jsMatches)) {
            $result['js'] = trim($jsMatches[1]);
        }
        
        // Extract body content
        if (preg_match('/<body[^>]*>(.*?)<\/body>/is', $code, $bodyMatches)) {
            $result['html'] = trim($bodyMatches[1]);
            // Remove inline scripts from body
            $result['html'] = preg_replace('/<script[^>]*>.*?<\/script>/is', '', $result['html']);
        }
        
        return $result;
    }
    
    /**
     * Helper method to send JSON response
     */
    protected function jsonResponse(array $data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
    
    /**
     * Generate AI feedback asynchronously (simulated)
     * In production, this would trigger a background job
     */
    private function generateFeedbackAsync(int $submissionId)
    {
        try {
            $feedbackService = new FeedbackService();
            
            // For now, we'll run synchronously
            // In production, queue this as a background job
            $result = $feedbackService->generateFeedback($submissionId);
            
            if ($result['success']) {
                error_log("Feedback generated successfully for submission $submissionId");
            } else {
                error_log("Feedback generation failed for submission $submissionId: " . $result['error']);
            }
        } catch (\Exception $e) {
            error_log("Feedback generation error: " . $e->getMessage());
        }
    }
    
    /**
     * Get current authenticated user
     */
    protected function getCurrentUser(): ?array
    {
        return $_SESSION['user'] ?? null;
    }
    
    /**
     * Require authentication
     */
    protected function requireAuth(): void
    {
        if (!isset($_SESSION['user'])) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $this->jsonResponse(['success' => false, 'error' => 'Authentication required'], 401);
            } else {
                header('Location: ' . url('/login'));
                exit;
            }
        }
    }
}
