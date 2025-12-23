<?php
/**
 * AI Tutor Test Page
 * Test the AI code review functionality
 */

session_start();

// Simulate a logged-in user for testing (you should be logged in normally)
if (!isset($_SESSION['user_id'])) {
    echo "<h2>You need to be logged in to test AI features</h2>";
    echo "<p>Please <a href='/Nebatech-AI-Academy/login'>log in</a> first, then come back here.</p>";
    exit;
}

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/helpers.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Tutor Test</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold mb-6">AI Code Review Test</h1>
        
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4">Test Code</h2>
            <textarea id="code" class="w-full h-40 p-3 border rounded font-mono text-sm">
function hello() {
    console.log("Hello World");
    var x = 1;
    return x
}
            </textarea>
            
            <button id="reviewBtn" class="mt-4 bg-violet-600 text-white px-6 py-2 rounded-lg hover:bg-violet-700">
                Request AI Review
            </button>
        </div>
        
        <div id="result" class="bg-white rounded-lg shadow p-6 hidden">
            <h2 class="text-xl font-semibold mb-4">Review Result</h2>
            <pre id="resultContent" class="bg-gray-100 p-4 rounded overflow-auto text-sm"></pre>
        </div>
        
        <div id="error" class="bg-red-100 border border-red-400 text-red-700 rounded-lg p-4 hidden">
            <h3 class="font-bold">Error</h3>
            <p id="errorContent"></p>
        </div>
    </div>
    
    <script>
        document.getElementById('reviewBtn').addEventListener('click', async function() {
            const code = document.getElementById('code').value;
            const resultDiv = document.getElementById('result');
            const errorDiv = document.getElementById('error');
            
            this.disabled = true;
            this.textContent = 'Reviewing...';
            
            resultDiv.classList.add('hidden');
            errorDiv.classList.add('hidden');
            
            try {
                const response = await fetch('/Nebatech-AI-Academy/api/ai/review-code', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        code: code,
                        language: 'javascript'
                    })
                });
                
                const data = await response.json();
                console.log('Response:', data);
                
                document.getElementById('resultContent').textContent = JSON.stringify(data, null, 2);
                resultDiv.classList.remove('hidden');
                
                if (!data.success) {
                    errorDiv.classList.remove('hidden');
                    document.getElementById('errorContent').textContent = data.error || 'Unknown error';
                }
            } catch (err) {
                console.error('Error:', err);
                errorDiv.classList.remove('hidden');
                document.getElementById('errorContent').textContent = err.message;
            } finally {
                this.disabled = false;
                this.textContent = 'Request AI Review';
            }
        });
    </script>
</body>
</html>
