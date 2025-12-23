<?php
require_once __DIR__ . '/../vendor/autoload.php';

echo "<h2>Avatar Upload Debug</h2>";

// Check directory
$uploadDir = dirname(__DIR__) . '/public/uploads/avatars/';
echo "<p><strong>Upload Directory:</strong> " . $uploadDir . "</p>";
echo "<p><strong>Directory Exists:</strong> " . (is_dir($uploadDir) ? 'Yes' : 'No') . "</p>";
echo "<p><strong>Directory Writable:</strong> " . (is_writable($uploadDir) ? 'Yes' : 'No') . "</p>";

// Check for uploaded files
echo "<h3>Files in avatars folder:</h3>";
if (is_dir($uploadDir)) {
    $files = scandir($uploadDir);
    echo "<pre>";
    print_r($files);
    echo "</pre>";
} else {
    echo "<p>Directory does not exist!</p>";
}

// Test base_url function
require_once __DIR__ . '/../src/helpers.php';
echo "<h3>URL Functions Test:</h3>";
echo "<p><strong>base_url():</strong> " . base_url() . "</p>";
echo "<p><strong>base_url('uploads/avatars/test.jpg'):</strong> " . base_url('uploads/avatars/test.jpg') . "</p>";
echo "<p><strong>avatar_url('uploads/avatars/test.jpg'):</strong> " . avatar_url('uploads/avatars/test.jpg') . "</p>";
echo "<p><strong>avatar_url(null):</strong> " . avatar_url(null) . "</p>";

// Check if avatar is in database for user 10
$pdo = new PDO('mysql:host=localhost;dbname=nebatech_ai_academy', 'root', '');
$stmt = $pdo->prepare("SELECT id, first_name, avatar FROM users WHERE id = 10");
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);
echo "<h3>User 10 Avatar in DB:</h3>";
echo "<pre>";
print_r($user);
echo "</pre>";

if (!empty($user['avatar'])) {
    echo "<p><strong>Avatar URL generated:</strong> " . avatar_url($user['avatar']) . "</p>";
    echo "<p><strong>Full file path:</strong> " . dirname(__DIR__) . '/public/' . ltrim($user['avatar'], '/') . "</p>";
    echo "<p><strong>File exists:</strong> " . (file_exists(dirname(__DIR__) . '/public/' . ltrim($user['avatar'], '/')) ? 'Yes' : 'No') . "</p>";
}
