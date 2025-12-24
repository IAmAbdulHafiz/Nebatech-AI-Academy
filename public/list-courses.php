<?php
/**
 * List all courses in database
 */
require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

$db = Nebatech\Core\Database::connect();

echo "<h2>All Courses in Database</h2>";
$stmt = $db->query("SELECT id, title, slug, category FROM courses ORDER BY id");
$courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<pre>";
foreach ($courses as $course) {
    echo "{$course['id']}: {$course['title']} ({$course['slug']}) - {$course['category']}\n";
}
echo "</pre>";

echo "<h2>Existing Modules</h2>";
$stmt = $db->query("SELECT m.id, m.title, m.course_id, c.title as course_title FROM modules m JOIN courses c ON m.course_id = c.id ORDER BY m.course_id, m.order_index");
$modules = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo "<pre>";
foreach ($modules as $m) {
    echo "Course {$m['course_id']} ({$m['course_title']}): Module {$m['id']} - {$m['title']}\n";
}
echo "</pre>";
