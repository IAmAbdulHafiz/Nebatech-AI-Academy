<?php

namespace Nebatech\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class CodeExecutionService
{
    private Client $client;
    private string $apiUrl;
    private ?string $apiKey;

    public function __construct()
    {
        $this->apiUrl = $_ENV['JUDGE0_API_URL'] ?? 'https://judge0-ce.p.rapidapi.com';
        $this->apiKey = $_ENV['JUDGE0_API_KEY'] ?? null;
        
        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];

        if ($this->apiKey) {
            $headers['X-RapidAPI-Key'] = $this->apiKey;
            $headers['X-RapidAPI-Host'] = 'judge0-ce.p.rapidapi.com';
        }

        $this->client = new Client([
            'base_uri' => $this->apiUrl,
            'headers' => $headers,
            'timeout' => 30
        ]);
    }

    /**
     * Execute code and return results
     */
    public function execute(string $code, int $languageId, ?string $stdin = null): array
    {
        try {
            // Submit code for execution
            $submissionToken = $this->submitCode($code, $languageId, $stdin);
            
            if (!$submissionToken) {
                return [
                    'success' => false,
                    'error' => 'Failed to submit code for execution'
                ];
            }

            // Wait for execution to complete and get results
            $result = $this->getSubmissionResult($submissionToken);
            
            return [
                'success' => true,
                'result' => $result
            ];

        } catch (GuzzleException $e) {
            error_log("Code execution error: " . $e->getMessage());
            return [
                'success' => false,
                'error' => 'Code execution service unavailable'
            ];
        }
    }

    /**
     * Submit code to Judge0
     */
    private function submitCode(string $code, int $languageId, ?string $stdin): ?string
    {
        try {
            $payload = [
                'source_code' => base64_encode($code),
                'language_id' => $languageId,
                'stdin' => $stdin ? base64_encode($stdin) : null
            ];

            $response = $this->client->post('/submissions', [
                'json' => $payload,
                'query' => ['base64_encoded' => 'true', 'wait' => 'false']
            ]);

            $data = json_decode($response->getBody()->getContents(), true);
            return $data['token'] ?? null;

        } catch (GuzzleException $e) {
            error_log("Code submission error: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Get submission result
     */
    private function getSubmissionResult(string $token, int $maxAttempts = 10): array
    {
        $attempt = 0;
        
        while ($attempt < $maxAttempts) {
            try {
                $response = $this->client->get("/submissions/{$token}", [
                    'query' => ['base64_encoded' => 'true']
                ]);

                $data = json_decode($response->getBody()->getContents(), true);
                
                // Check if execution is complete
                if (isset($data['status']['id']) && $data['status']['id'] > 2) {
                    return [
                        'status' => $data['status']['description'] ?? 'Unknown',
                        'stdout' => isset($data['stdout']) ? base64_decode($data['stdout']) : null,
                        'stderr' => isset($data['stderr']) ? base64_decode($data['stderr']) : null,
                        'compile_output' => isset($data['compile_output']) ? base64_decode($data['compile_output']) : null,
                        'time' => $data['time'] ?? null,
                        'memory' => $data['memory'] ?? null,
                        'exit_code' => $data['exit_code'] ?? null
                    ];
                }

                // Wait before next attempt
                sleep(1);
                $attempt++;

            } catch (GuzzleException $e) {
                error_log("Result fetch error: " . $e->getMessage());
                break;
            }
        }

        return [
            'status' => 'Timeout',
            'error' => 'Execution timed out'
        ];
    }

    /**
     * Run code with test cases
     */
    public function runTests(string $code, int $languageId, array $testCases): array
    {
        $results = [];
        $passed = 0;
        $failed = 0;

        foreach ($testCases as $index => $testCase) {
            $input = $testCase['input'] ?? null;
            $expectedOutput = trim($testCase['expected_output'] ?? '');

            $result = $this->execute($code, $languageId, $input);

            if ($result['success']) {
                $actualOutput = trim($result['result']['stdout'] ?? '');
                $isPass = $actualOutput === $expectedOutput;

                if ($isPass) {
                    $passed++;
                } else {
                    $failed++;
                }

                $results[] = [
                    'test_number' => $index + 1,
                    'input' => $input,
                    'expected' => $expectedOutput,
                    'actual' => $actualOutput,
                    'passed' => $isPass,
                    'status' => $result['result']['status'] ?? 'Unknown'
                ];
            } else {
                $failed++;
                $results[] = [
                    'test_number' => $index + 1,
                    'input' => $input,
                    'expected' => $expectedOutput,
                    'actual' => null,
                    'passed' => false,
                    'error' => $result['error'] ?? 'Execution failed'
                ];
            }
        }

        return [
            'total' => count($testCases),
            'passed' => $passed,
            'failed' => $failed,
            'results' => $results
        ];
    }

    /**
     * Get supported languages
     */
    public function getSupportedLanguages(): array
    {
        return [
            45 => 'Assembly (NASM 2.14.02)',
            46 => 'Bash (5.0.0)',
            47 => 'Basic (FBC 1.07.1)',
            75 => 'C (Clang 7.0.1)',
            76 => 'C++ (Clang 7.0.1)',
            48 => 'C (GCC 7.4.0)',
            52 => 'C++ (GCC 7.4.0)',
            49 => 'C (GCC 8.3.0)',
            53 => 'C++ (GCC 8.3.0)',
            50 => 'C (GCC 9.2.0)',
            54 => 'C++ (GCC 9.2.0)',
            86 => 'Clojure (1.10.1)',
            51 => 'C# (Mono 6.6.0.161)',
            77 => 'COBOL (GnuCOBOL 2.2)',
            55 => 'Common Lisp (SBCL 2.0.0)',
            56 => 'D (DMD 2.089.1)',
            57 => 'Elixir (1.9.4)',
            58 => 'Erlang (OTP 22.2)',
            44 => 'Executable',
            87 => 'F# (.NET Core SDK 3.1.202)',
            59 => 'Fortran (GFortran 9.2.0)',
            60 => 'Go (1.13.5)',
            88 => 'Groovy (3.0.3)',
            61 => 'Haskell (GHC 8.8.1)',
            62 => 'Java (OpenJDK 13.0.1)',
            63 => 'JavaScript (Node.js 12.14.0)',
            78 => 'Kotlin (1.3.70)',
            64 => 'Lua (5.3.5)',
            89 => 'Multi-file program',
            79 => 'Objective-C (Clang 7.0.1)',
            65 => 'OCaml (4.09.0)',
            66 => 'Octave (5.1.0)',
            67 => 'Pascal (FPC 3.0.4)',
            85 => 'Perl (5.28.1)',
            68 => 'PHP (7.4.1)',
            43 => 'Plain Text',
            69 => 'Prolog (GNU Prolog 1.4.5)',
            70 => 'Python (2.7.17)',
            71 => 'Python (3.8.1)',
            80 => 'R (4.0.0)',
            72 => 'Ruby (2.7.0)',
            73 => 'Rust (1.40.0)',
            81 => 'Scala (2.13.2)',
            82 => 'SQL (SQLite 3.27.2)',
            83 => 'Swift (5.2.3)',
            74 => 'TypeScript (3.7.4)',
            84 => 'Visual Basic.Net (vbnc 0.0.0.5943)'
        ];
    }

    /**
     * Get language ID by name
     */
    public function getLanguageId(string $languageName): ?int
    {
        $languageMap = [
            'javascript' => 63,
            'python' => 71,
            'python3' => 71,
            'python2' => 70,
            'java' => 62,
            'c' => 50,
            'cpp' => 54,
            'c++' => 54,
            'csharp' => 51,
            'c#' => 51,
            'php' => 68,
            'ruby' => 72,
            'go' => 60,
            'rust' => 73,
            'typescript' => 74,
            'swift' => 83,
            'kotlin' => 78,
            'r' => 80,
            'sql' => 82,
            'bash' => 46,
            'shell' => 46
        ];

        $key = strtolower($languageName);
        return $languageMap[$key] ?? null;
    }
}
