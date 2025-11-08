<?php
/**
 * Test script to generate AI feedback for a sample submission
 * 
 * Usage: php test_feedback.php
 */

// Autoload
require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/../../config/bootstrap.php';

use Nebatech\Services\FeedbackService;
use Nebatech\Models\Submission;

echo "=== AI Feedback System Test ===\n\n";

// Get a submission to test with
echo "Looking for submissions...\n";
$db = Nebatech\Core\Database::getInstance();
$submissions = $db->query("SELECT * FROM submissions WHERE status = 'submitted' LIMIT 1")->fetchAll();

if (empty($submissions)) {
    echo "No submissions found with 'submitted' status.\n";
    echo "Creating a test submission...\n\n";
    
    // Create a test HTML file
    $testCode = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .form-container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }
        input, textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }
        button {
            background-color: #007bff;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Contact Us</h1>
        <form id="contactForm">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="message">Message:</label>
                <textarea id="message" name="message" rows="5" required></textarea>
            </div>
            <button type="submit">Send Message</button>
        </form>
        <div id="result" style="margin-top: 20px;"></div>
    </div>
    
    <script>
        document.getElementById('contactForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const message = document.getElementById('message').value;
            
            console.log('Form submitted!');
            console.log('Name:', name);
            console.log('Email:', email);
            console.log('Message:', message);
            
            document.getElementById('result').innerHTML = 
                '<p style="color: green; font-weight: bold;">Message sent successfully!</p>';
            
            // Reset form
            this.reset();
        });
    </script>
</body>
</html>
HTML;

    // Save to file
    $testDir = __DIR__ . '/../../storage/submissions';
    if (!is_dir($testDir)) {
        mkdir($testDir, 0755, true);
    }
    $testFile = 'test_user_1_assignment_1_' . time() . '.html';
    file_put_contents($testDir . '/' . $testFile, $testCode);
    
    // Create test submission
    $submissionId = Submission::create([
        'assignment_id' => 1, // Assuming assignment 1 exists
        'user_id' => 1, // Assuming user 1 exists
        'file_path' => $testFile,
        'submitted_at' => date('Y-m-d H:i:s'),
        'status' => 'submitted'
    ]);
    
    if (!$submissionId) {
        echo "Failed to create test submission.\n";
        echo "Make sure assignment_id=1 and user_id=1 exist in your database.\n";
        exit(1);
    }
    
    echo "Created test submission with ID: $submissionId\n\n";
    $submission = Submission::findById($submissionId);
} else {
    $submission = $submissions[0];
    $submissionId = $submission['id'];
    echo "Found submission ID: $submissionId\n";
    echo "Assignment: " . $submission['assignment_title'] . "\n";
    echo "Student: " . $submission['first_name'] . " " . $submission['last_name'] . "\n\n";
}

// Generate feedback
echo "Generating AI feedback...\n";
echo "This may take 10-20 seconds...\n\n";

$feedbackService = new FeedbackService();
$result = $feedbackService->generateFeedback($submissionId);

if (!$result['success']) {
    echo "ERROR: " . $result['error'] . "\n";
    exit(1);
}

$feedback = $result['feedback'];

// Display results
echo "=== FEEDBACK GENERATED ===\n\n";
echo "Score: {$feedback['score']}/{$feedback['max_score']} ({$feedback['percentage']}%)\n";
echo "Grade: {$feedback['grade_level']}\n";
echo "Generated: {$feedback['generated_at']}\n\n";

echo "=== AI FEEDBACK ===\n";
echo wordwrap($feedback['ai_feedback']['overall_feedback'], 80) . "\n\n";

if (!empty($feedback['ai_feedback']['strengths'])) {
    echo "Strengths:\n";
    foreach ($feedback['ai_feedback']['strengths'] as $i => $strength) {
        echo "  " . ($i + 1) . ". " . wordwrap($strength, 76, "\n     ") . "\n";
    }
    echo "\n";
}

if (!empty($feedback['ai_feedback']['improvements'])) {
    echo "Areas for Improvement:\n";
    foreach ($feedback['ai_feedback']['improvements'] as $i => $improvement) {
        echo "  " . ($i + 1) . ". " . wordwrap($improvement, 76, "\n     ") . "\n";
    }
    echo "\n";
}

if (!empty($feedback['ai_feedback']['suggestions'])) {
    echo "Suggestions:\n";
    foreach ($feedback['ai_feedback']['suggestions'] as $i => $suggestion) {
        echo "  " . ($i + 1) . ". " . wordwrap($suggestion, 76, "\n     ") . "\n";
    }
    echo "\n";
}

echo "=== CODE VALIDATION ===\n";
echo $feedback['validation']['summary'] . "\n\n";

if ($feedback['validation']['has_issues']) {
    foreach ($feedback['validation']['issues'] as $category => $issues) {
        echo ucfirst($category) . " Issues:\n";
        foreach ($issues as $issue) {
            $icon = $issue['severity'] === 'error' ? '✗' : ($issue['severity'] === 'warning' ? '⚠' : 'ℹ');
            echo "  $icon [{$issue['severity']}] {$issue['message']}\n";
        }
        echo "\n";
    }
}

echo "=== TEST COMPLETE ===\n";
echo "View feedback at: " . url('/submissions/' . $submissionId . '/feedback') . "\n";
