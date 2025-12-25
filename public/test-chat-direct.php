<?php
/**
 * Direct test of the AI Tutor chat - bypassing router
 */
header('Content-Type: application/json');

try {
    session_start();
    
    // Load autoload and dotenv
    require_once __DIR__ . '/../vendor/autoload.php';
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
    $dotenv->load();
    
    // Check session
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['success' => false, 'error' => 'Not logged in', 'session' => $_SESSION]);
        exit;
    }
    
    // Get input
    $input = json_decode(file_get_contents('php://input'), true) ?? [];
    $message = $input['message'] ?? 'Hello, test message';
    $persona = $input['persona'] ?? 'mentor';
    
    // Build context from the request
    $context = [
        'lesson_id' => !empty($input['lesson_id']) ? (int)$input['lesson_id'] : null,
        'practical_id' => !empty($input['practical_id']) ? (int)$input['practical_id'] : null,
        'quiz_id' => !empty($input['quiz_id']) ? (int)$input['quiz_id'] : null,
        'course_id' => !empty($input['course_id']) ? (int)$input['course_id'] : null
    ];
    
    // Create service
    $service = new \Nebatech\Services\AITutorService();
    
    // Call API
    $response = $service->askQuestion(
        $_SESSION['user_id'],
        $message,
        $context,
        $persona
    );
    
    echo json_encode($response);
    
} catch (\Throwable $e) {
    echo json_encode([
        'success' => false, 
        'error' => $e->getMessage(),
        'file' => $e->getFile(),
        'line' => $e->getLine()
    ]);
}
