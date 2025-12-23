<?php
require_once __DIR__ . '/../vendor/autoload.php';

$pdo = new PDO('mysql:host=localhost;dbname=nebatech_ai_academy', 'root', '');

echo "<h2>All Courses:</h2>";
$stmt = $pdo->query("SELECT id, title, status, parent_course_id, is_bundle FROM courses");
echo "<pre>";
print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
echo "</pre>";

echo "<h2>Published Main Courses (parent_course_id IS NULL):</h2>";
$stmt = $pdo->query("SELECT id, title, status, parent_course_id, is_bundle FROM courses WHERE status = 'published' AND parent_course_id IS NULL");
echo "<pre>";
print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
echo "</pre>";
