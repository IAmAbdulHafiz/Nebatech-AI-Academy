<?php

return [
    'api_key' => $_ENV['OPENAI_API_KEY'] ?? '',
    'model' => $_ENV['OPENAI_MODEL'] ?? 'gpt-4-turbo-preview',
    'max_tokens' => 2000,
    'temperature' => 0.7,
    
    'judge0' => [
        'api_key' => $_ENV['JUDGE0_API_KEY'] ?? '',
        'endpoint' => $_ENV['JUDGE0_ENDPOINT'] ?? 'https://judge0-ce.p.rapidapi.com',
    ],
];
