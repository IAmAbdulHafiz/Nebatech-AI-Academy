<?php

return [
    // OpenAI Configuration
    'openai' => [
        'api_key' => $_ENV['OPENAI_API_KEY'] ?? '',
        'model' => $_ENV['OPENAI_MODEL'] ?? 'gpt-4o-mini',
        'embedding_model' => $_ENV['OPENAI_EMBEDDING_MODEL'] ?? 'text-embedding-3-small',
        'max_tokens' => (int)($_ENV['OPENAI_MAX_TOKENS'] ?? 2000),
        'temperature' => (float)($_ENV['OPENAI_TEMPERATURE'] ?? 0.7),
        'endpoint' => 'https://api.openai.com/v1',
    ],
    
    // AI Tutor Settings
    'tutor' => [
        'enabled' => (bool)($_ENV['AI_TUTOR_ENABLED'] ?? true),
        'max_messages_per_session' => 50,
        'max_daily_requests' => (int)($_ENV['AI_DAILY_LIMIT'] ?? 100),
        'session_timeout_minutes' => 60,
        'cache_faq_hours' => 24,
        'models' => [
            'chat' => 'gpt-4o-mini',
            'code_review' => 'gpt-4o-mini',
            'practice' => 'gpt-4o-mini',
            'simple' => 'gpt-4o-mini',
        ],
    ],
    
    // Code Review Settings
    'code_review' => [
        'max_code_length' => 10000,
        'supported_languages' => [
            'python', 'javascript', 'php', 'java', 'cpp', 'c',
            'html', 'css', 'sql', 'typescript', 'ruby', 'go'
        ],
    ],
    
    // Practice Generation Settings
    'practice' => [
        'problems_per_lesson' => 5,
        'difficulty_weights' => [
            'easy' => 0.3,
            'medium' => 0.5,
            'hard' => 0.2,
        ],
    ],
    
    // Cost Management
    'costs' => [
        'gpt-4o' => ['input' => 0.005, 'output' => 0.015],
        'gpt-4o-mini' => ['input' => 0.00015, 'output' => 0.0006],
        'gpt-3.5-turbo' => ['input' => 0.0005, 'output' => 0.0015],
        'text-embedding-3-small' => ['input' => 0.00002, 'output' => 0],
    ],
    
    // Judge0 Code Execution
    'judge0' => [
        'api_key' => $_ENV['JUDGE0_API_KEY'] ?? '',
        'endpoint' => $_ENV['JUDGE0_ENDPOINT'] ?? 'https://judge0-ce.p.rapidapi.com',
    ],
];
