<?php
/**
 * Debug script to check routes and lesson data
 */

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

$pdo = new PDO(
    "mysql:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_NAME']}",
    $_ENV['DB_USER'],
    $_ENV['DB_PASSWORD'] ?? ''
);

echo "=== Checking Course 1 - Frontend Development ===\n";

// Get course
$course = $pdo->query("SELECT id, title, slug FROM courses WHERE id = 1")->fetch(PDO::FETCH_ASSOC);
echo "Course: {$course['title']} (ID: {$course['id']}, Slug: {$course['slug']})\n";

// Get first module
$module = $pdo->query("SELECT id, title FROM modules WHERE course_id = 1 ORDER BY order_index LIMIT 1")->fetch(PDO::FETCH_ASSOC);
echo "First Module: {$module['title']} (ID: {$module['id']})\n";

// Get first lesson
$lesson = $pdo->query("SELECT id, title FROM lessons WHERE module_id = {$module['id']} ORDER BY order_index LIMIT 1")->fetch(PDO::FETCH_ASSOC);
echo "First Lesson: {$lesson['title']} (ID: {$lesson['id']})\n";

echo "\n=== Expected URL for Start Course ===\n";
echo "/courses/{$course['slug']}/lesson/{$lesson['id']}\n";

echo "\n=== Checking Enrollment for User ID 10 ===\n";
$enrollment = $pdo->query("SELECT * FROM enrollments WHERE user_id = 10 AND course_id = 1")->fetch(PDO::FETCH_ASSOC);
if ($enrollment) {
    echo "ENROLLED! Status: {$enrollment['status']}\n";
} else {
    echo "NOT enrolled in Course 1\n";
}
