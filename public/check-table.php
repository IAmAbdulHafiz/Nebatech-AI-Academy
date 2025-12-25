<?php
require_once __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

$pdo = new PDO('mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);

// Check all CBT tables
$tables = ['practicals', 'quizzes', 'quiz_questions', 'learning_objectives', 'milestones', 'ai_tutor_interactions', 'lessons', 'modules', 'courses'];

foreach ($tables as $table) {
    echo "\n{$table} table structure:\n";
    try {
        $result = $pdo->query("DESCRIBE {$table}");
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            echo "  {$row['Field']} - {$row['Type']}\n";
        }
    } catch (PDOException $e) {
        echo "  ERROR: " . $e->getMessage() . "\n";
    }
}

// Add missing columns
echo "\n=== Adding missing columns ===\n";

$alterations = [
    "ALTER TABLE practicals ADD COLUMN practical_type ENUM('coding', 'design', 'documentation', 'research', 'hands-on', 'project') DEFAULT 'coding'",
    "ALTER TABLE practicals ADD COLUMN starter_code TEXT NULL",
    "ALTER TABLE practicals ADD COLUMN solution_code TEXT NULL",
    "ALTER TABLE practicals ADD COLUMN hints JSON NULL",
    "ALTER TABLE practicals ADD COLUMN resources JSON NULL",
    "ALTER TABLE practicals ADD COLUMN rubric JSON NULL",
    "ALTER TABLE practicals ADD COLUMN is_required BOOLEAN DEFAULT TRUE",
    "ALTER TABLE practicals ADD COLUMN status ENUM('draft', 'published', 'archived') DEFAULT 'published'",
    "ALTER TABLE lessons ADD COLUMN has_practical BOOLEAN DEFAULT FALSE",
    "ALTER TABLE lessons ADD COLUMN has_quiz BOOLEAN DEFAULT FALSE",
    "ALTER TABLE lessons ADD COLUMN practical_id INT NULL",
    "ALTER TABLE lessons ADD COLUMN quiz_id INT NULL",
    "ALTER TABLE lessons ADD COLUMN competency_summary TEXT NULL",
    "ALTER TABLE modules ADD COLUMN has_milestone BOOLEAN DEFAULT FALSE",
    "ALTER TABLE modules ADD COLUMN milestone_id INT NULL",
    "ALTER TABLE modules ADD COLUMN competencies_covered JSON NULL",
    "ALTER TABLE courses ADD COLUMN is_cbt BOOLEAN DEFAULT TRUE",
    "ALTER TABLE courses ADD COLUMN total_competencies INT DEFAULT 0",
    "ALTER TABLE courses ADD COLUMN has_capstone BOOLEAN DEFAULT FALSE",
    "ALTER TABLE courses ADD COLUMN capstone_id INT NULL"
];

foreach ($alterations as $sql) {
    try {
        $pdo->exec($sql);
        echo "✓ $sql\n";
    } catch (PDOException $e) {
        if (strpos($e->getMessage(), 'Duplicate column') !== false) {
            echo "- Already exists: " . explode(' ', $sql)[4] . "\n";
        } else {
            echo "Error: " . $e->getMessage() . "\n";
        }
    }
}

echo "\n✅ Schema synchronization complete!\n";
