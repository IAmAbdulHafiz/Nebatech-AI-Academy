<?php

namespace Nebatech\Services\AI;

/**
 * OpenAI API Client
 * Handles communication with OpenAI API for chat completions and embeddings
 */
class OpenAIClient
{
    private string $apiKey;
    private string $endpoint;
    private array $config;
    private array $defaultOptions;

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
        $this->config = require dirname(__DIR__, 3) . '/config/ai.php';
        $this->endpoint = $this->config['openai']['endpoint'] ?? 'https://api.openai.com/v1';
        
        $this->defaultOptions = [
            'model' => $this->config['openai']['model'] ?? 'gpt-4-turbo-preview',
            'max_tokens' => $this->config['openai']['max_tokens'] ?? 2000,
            'temperature' => $this->config['openai']['temperature'] ?? 0.7,
        ];
    }

    /**
     * Send a chat completion request
     */
    public function chat(array $messages, array $options = []): array
    {
        $options = array_merge($this->defaultOptions, $options);
        
        $payload = [
            'model' => $options['model'],
            'messages' => $messages,
            'max_tokens' => $options['max_tokens'],
            'temperature' => $options['temperature'],
        ];

        // Add response format if specified (for JSON responses)
        if (!empty($options['response_format'])) {
            $payload['response_format'] = $options['response_format'];
        }

        $response = $this->request('chat/completions', $payload);

        if (!isset($response['choices'][0]['message']['content'])) {
            throw new \Exception('Invalid response from OpenAI API');
        }

        $content = $response['choices'][0]['message']['content'];
        $usage = $response['usage'] ?? [];
        
        $totalTokens = ($usage['prompt_tokens'] ?? 0) + ($usage['completion_tokens'] ?? 0);
        $cost = $this->calculateCost($options['model'], $usage);

        return [
            'content' => $content,
            'tokens' => $totalTokens,
            'prompt_tokens' => $usage['prompt_tokens'] ?? 0,
            'completion_tokens' => $usage['completion_tokens'] ?? 0,
            'cost' => $cost,
            'model' => $options['model'],
            'finish_reason' => $response['choices'][0]['finish_reason'] ?? null
        ];
    }

    /**
     * Generate embeddings for text
     */
    public function embeddings(string $text, string $model = null): array
    {
        $model = $model ?? $this->config['openai']['embedding_model'] ?? 'text-embedding-3-small';
        
        $response = $this->request('embeddings', [
            'model' => $model,
            'input' => $text
        ]);

        if (!isset($response['data'][0]['embedding'])) {
            throw new \Exception('Invalid embeddings response from OpenAI API');
        }

        return [
            'embedding' => $response['data'][0]['embedding'],
            'tokens' => $response['usage']['total_tokens'] ?? 0,
            'model' => $model
        ];
    }

    /**
     * Stream chat completion (for real-time responses)
     */
    public function chatStream(array $messages, callable $onChunk, array $options = []): array
    {
        $options = array_merge($this->defaultOptions, $options);
        $options['stream'] = true;

        $payload = [
            'model' => $options['model'],
            'messages' => $messages,
            'max_tokens' => $options['max_tokens'],
            'temperature' => $options['temperature'],
            'stream' => true
        ];

        $fullContent = '';
        $totalTokens = 0;

        $this->requestStream('chat/completions', $payload, function ($chunk) use (&$fullContent, $onChunk) {
            if (isset($chunk['choices'][0]['delta']['content'])) {
                $content = $chunk['choices'][0]['delta']['content'];
                $fullContent .= $content;
                $onChunk($content);
            }
        });

        // Estimate tokens for streaming (OpenAI doesn't provide exact count in stream)
        $totalTokens = $this->estimateTokens($messages, $fullContent);
        $cost = $this->calculateCost($options['model'], [
            'prompt_tokens' => $totalTokens / 2,
            'completion_tokens' => $totalTokens / 2
        ]);

        return [
            'content' => $fullContent,
            'tokens' => $totalTokens,
            'cost' => $cost,
            'model' => $options['model']
        ];
    }

    /**
     * Make a request to OpenAI API
     */
    private function request(string $endpoint, array $data): array
    {
        $url = $this->endpoint . '/' . $endpoint;
        
        $ch = curl_init($url);
        
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $this->apiKey
            ],
            CURLOPT_TIMEOUT => 120,
            CURLOPT_SSL_VERIFYPEER => true
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            throw new \Exception('cURL error: ' . $error);
        }

        $decoded = json_decode($response, true);

        if ($httpCode !== 200) {
            $errorMessage = $decoded['error']['message'] ?? 'Unknown API error';
            throw new \Exception('OpenAI API error (' . $httpCode . '): ' . $errorMessage);
        }

        return $decoded;
    }

    /**
     * Make a streaming request to OpenAI API
     */
    private function requestStream(string $endpoint, array $data, callable $onChunk): void
    {
        $url = $this->endpoint . '/' . $endpoint;
        
        $ch = curl_init($url);
        
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => false,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $this->apiKey,
                'Accept: text/event-stream'
            ],
            CURLOPT_TIMEOUT => 120,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_WRITEFUNCTION => function ($ch, $data) use ($onChunk) {
                $lines = explode("\n", $data);
                foreach ($lines as $line) {
                    if (str_starts_with($line, 'data: ')) {
                        $json = substr($line, 6);
                        if ($json !== '[DONE]') {
                            $chunk = json_decode($json, true);
                            if ($chunk) {
                                $onChunk($chunk);
                            }
                        }
                    }
                }
                return strlen($data);
            }
        ]);

        curl_exec($ch);
        curl_close($ch);
    }

    /**
     * Calculate cost based on model and token usage
     */
    private function calculateCost(string $model, array $usage): float
    {
        $costs = $this->config['costs'] ?? [];
        
        $modelCost = $costs[$model] ?? ['input' => 0.01, 'output' => 0.03];
        
        $promptCost = (($usage['prompt_tokens'] ?? 0) / 1000) * $modelCost['input'];
        $completionCost = (($usage['completion_tokens'] ?? 0) / 1000) * $modelCost['output'];
        
        return round($promptCost + $completionCost, 6);
    }

    /**
     * Estimate tokens for streaming responses
     */
    private function estimateTokens(array $messages, string $response): int
    {
        // Rough estimation: ~4 characters per token
        $promptLength = 0;
        foreach ($messages as $message) {
            $promptLength += strlen($message['content'] ?? '');
        }
        
        $responseLength = strlen($response);
        
        return (int) ceil(($promptLength + $responseLength) / 4);
    }

    /**
     * Check if API key is configured
     */
    public function isConfigured(): bool
    {
        return !empty($this->apiKey);
    }

    /**
     * Get available models
     */
    public function getModels(): array
    {
        try {
            $response = $this->request('models', []);
            return array_column($response['data'] ?? [], 'id');
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * Simple moderation check
     */
    public function moderate(string $text): array
    {
        $response = $this->request('moderations', [
            'input' => $text
        ]);

        $result = $response['results'][0] ?? [];
        
        return [
            'flagged' => $result['flagged'] ?? false,
            'categories' => $result['categories'] ?? [],
            'scores' => $result['category_scores'] ?? []
        ];
    }
}
