<?php
require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

$pdo = new PDO(
    "mysql:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_NAME']}",
    $_ENV['DB_USER'],
    $_ENV['DB_PASSWORD'] ?? ''
);

echo "<h2>Courses Table Structure</h2>";
echo "<pre>";
$cols = $pdo->query("DESCRIBE courses")->fetchAll(PDO::FETCH_ASSOC);
foreach ($cols as $col) {
    echo $col['Field'] . " - " . $col['Type'] . "\n";
}
echo "</pre>";

echo "<h2>Courses with Current Module Count</h2>";
echo "<table border='1' cellpadding='5'>";
echo "<tr><th>ID</th><th>Title</th><th>Level</th><th>Expected Modules</th><th>Current Modules</th><th>Current Lessons</th></tr>";

$courses = $pdo->query("SELECT id, title, level, card_modules, card_duration FROM courses WHERE id <= 15 ORDER BY id")->fetchAll(PDO::FETCH_ASSOC);

foreach ($courses as $course) {
    $moduleCount = $pdo->query("SELECT COUNT(*) FROM modules WHERE course_id = {$course['id']}")->fetchColumn();
    $lessonCount = $pdo->query("SELECT COUNT(*) FROM lessons l JOIN modules m ON l.module_id = m.id WHERE m.course_id = {$course['id']}")->fetchColumn();
    echo "<tr>";
    echo "<td>{$course['id']}</td>";
    echo "<td>{$course['title']}</td>";
    echo "<td>{$course['level']}</td>";
    echo "<td>{$course['card_modules']}</td>";
    echo "<td>{$moduleCount}</td>";
    echo "<td>{$lessonCount}</td>";
    echo "</tr>";
}

echo "</table>";
