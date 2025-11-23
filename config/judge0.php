<?php

/**
 * Judge0 Code Execution Configuration
 */

return [
    // Judge0 API Configuration
    'api_key' => $_ENV['JUDGE0_API_KEY'] ?? null,
    'api_url' => $_ENV['JUDGE0_API_URL'] ?? 'https://judge0-ce.p.rapidapi.com',
    
    // Timeout settings (in seconds)
    'timeout' => 30,
    'max_wait_time' => 10,
    
    // Resource limits
    'max_cpu_time' => 5,        // seconds
    'max_memory' => 128000,     // KB (128 MB)
    'max_file_size' => 1024,    // KB (1 MB)
    
    // Supported languages mapping
    'languages' => [
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
    ],
    
    // Common language configurations
    'language_configs' => [
        'javascript' => [
            'name' => 'JavaScript (Node.js 12.14.0)',
            'extension' => 'js',
            'template' => "// Write your JavaScript code here\n\n"
        ],
        'python' => [
            'name' => 'Python 3.8.1',
            'extension' => 'py',
            'template' => "# Write your Python code here\n\n"
        ],
        'java' => [
            'name' => 'Java (OpenJDK 13.0.1)',
            'extension' => 'java',
            'template' => "public class Main {\n    public static void main(String[] args) {\n        // Write your Java code here\n    }\n}\n"
        ],
        'cpp' => [
            'name' => 'C++ (GCC 9.2.0)',
            'extension' => 'cpp',
            'template' => "#include <iostream>\nusing namespace std;\n\nint main() {\n    // Write your C++ code here\n    return 0;\n}\n"
        ],
        'c' => [
            'name' => 'C (GCC 9.2.0)',
            'extension' => 'c',
            'template' => "#include <stdio.h>\n\nint main() {\n    // Write your C code here\n    return 0;\n}\n"
        ],
        'php' => [
            'name' => 'PHP 7.4.1',
            'extension' => 'php',
            'template' => "<?php\n// Write your PHP code here\n?>\n"
        ]
    ],
    
    // Security settings
    'enable_network' => false,
    'enable_file_system' => false,
    'max_processes' => 30,
    
    // Fallback configuration (if Judge0 is unavailable)
    'fallback_enabled' => true,
    'fallback_message' => 'Code execution service is temporarily unavailable. Please try again later.'
];
