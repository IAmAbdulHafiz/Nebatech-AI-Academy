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

echo "<h2>Checking Course 1 - Frontend Development</h2>";

// Get course
$course = $pdo->query("SELECT id, title, slug FROM courses WHERE id = 1")->fetch(PDO::FETCH_ASSOC);
echo "<p>Course: {$course['title']} (ID: {$course['id']}, Slug: {$course['slug']})</p>";

// Get first module
$module = $pdo->query("SELECT id, title FROM modules WHERE course_id = 1 ORDER BY order_index LIMIT 1")->fetch(PDO::FETCH_ASSOC);
echo "<p>First Module: {$module['title']} (ID: {$module['id']})</p>";

// Get first lesson
$lesson = $pdo->query("SELECT id, title FROM lessons WHERE module_id = {$module['id']} ORDER BY order_index LIMIT 1")->fetch(PDO::FETCH_ASSOC);
echo "<p>First Lesson: {$lesson['title']} (ID: {$lesson['id']})</p>";

echo "<h3>Expected URL for Start Course:</h3>";
echo "<code>/courses/{$course['slug']}/lesson/{$lesson['id']}</code>";

echo "<h3>Test Links:</h3>";
echo "<ul>";
echo "<li><a href='/Nebatech-AI-Academy/courses/{$course['slug']}/learn'>Learn Page</a></li>";
echo "<li><a href='/Nebatech-AI-Academy/courses/{$course['slug']}/lesson/{$lesson['id']}'>First Lesson</a></li>";
echo "</ul>";

echo "<h3>Checking Enrollment for User ID 10:</h3>";
$enrollment = $pdo->query("SELECT * FROM enrollments WHERE user_id = 10 AND course_id = 1")->fetch(PDO::FETCH_ASSOC);
if ($enrollment) {
    echo "<p style='color:green'>✅ Enrolled! Status: {$enrollment['status']}</p>";
} else {
    echo "<p style='color:red'>❌ Not enrolled in Course 1</p>";
}
