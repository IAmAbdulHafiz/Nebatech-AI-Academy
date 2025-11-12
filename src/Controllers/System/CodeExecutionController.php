<?php

namespace Nebatech\Controllers\System;

use Nebatech\Core\Controller;
use Nebatech\Services\CodeExecutionService;
use Nebatech\Middleware\AuthMiddleware;

class CodeExecutionController extends Controller
{
    private CodeExecutionService $codeExecutionService;

    public function __construct()
    {
        $this->codeExecutionService = new CodeExecutionService();
    }

    /**
     * Execute code
     */
    public function execute(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['error' => 'Invalid request method'], 405);
            return;
        }

        // Get input
        $code = $_POST['code'] ?? '';
        $language = $_POST['language'] ?? '';
        $stdin = $_POST['stdin'] ?? null;

        if (empty($code) || empty($language)) {
            $this->jsonResponse(['error' => 'Code and language are required'], 400);
            return;
        }

        // Get language ID
        $languageId = $this->codeExecutionService->getLanguageId($language);
        
        if (!$languageId) {
            $this->jsonResponse(['error' => 'Unsupported language'], 400);
            return;
        }

        // Execute code
        $result = $this->codeExecutionService->execute($code, $languageId, $stdin);

        $this->jsonResponse($result);
    }

    /**
     * Run tests for code submission
     */
    public function runTests(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['error' => 'Invalid request method'], 405);
            return;
        }

        // Get input
        $code = $_POST['code'] ?? '';
        $language = $_POST['language'] ?? '';
        $testCases = json_decode($_POST['test_cases'] ?? '[]', true);

        if (empty($code) || empty($language) || empty($testCases)) {
            $this->jsonResponse(['error' => 'Code, language, and test cases are required'], 400);
            return;
        }

        // Get language ID
        $languageId = $this->codeExecutionService->getLanguageId($language);
        
        if (!$languageId) {
            $this->jsonResponse(['error' => 'Unsupported language'], 400);
            return;
        }

        // Run tests
        $result = $this->codeExecutionService->runTests($code, $languageId, $testCases);

        $this->jsonResponse([
            'success' => true,
            'results' => $result
        ]);
    }

    /**
     * Get supported languages
     */
    public function getSupportedLanguages(): void
    {
        $languages = $this->codeExecutionService->getSupportedLanguages();
        
        $this->jsonResponse([
            'success' => true,
            'languages' => $languages
        ]);
    }

    /**
     * Code playground page
     */
    public function playground(): void
    {
        try {
            $userId = AuthMiddleware::userId();
            $user = \Nebatech\Models\User::findById($userId);
            echo $this->view('code/playground', [
                'languages' => $this->getCommonLanguages(),
                'user' => $user
            ]);
        } catch (\Exception $e) {
            error_log("Error in playground: " . $e->getMessage());
            $userId = AuthMiddleware::userId();
            $user = \Nebatech\Models\User::findById($userId);
            echo $this->view('code/playground', [
                'languages' => $this->getCommonLanguages(),
                'user' => $user ?? []
            ]);
        }
    }

    /**
     * Get common programming languages for UI
     */
    private function getCommonLanguages(): array
    {
        return [
            'javascript' => 'JavaScript (Node.js)',
            'python' => 'Python 3',
            'java' => 'Java',
            'cpp' => 'C++',
            'c' => 'C',
            'csharp' => 'C#',
            'php' => 'PHP',
            'ruby' => 'Ruby',
            'go' => 'Go',
            'rust' => 'Rust',
            'typescript' => 'TypeScript',
            'swift' => 'Swift',
            'kotlin' => 'Kotlin',
            'r' => 'R',
            'sql' => 'SQL',
            'bash' => 'Bash'
        ];
    }

    /**
     * JSON response helper
     */
    protected function jsonResponse(array $data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}
