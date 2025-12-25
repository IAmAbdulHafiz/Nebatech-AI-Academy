<?php
/**
 * Run CBT Database Migration
 * Creates all tables needed for Competency-Based Training
 */

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

echo "===========================================\n";
echo "  CBT DATABASE MIGRATION\n";
echo "  Nebatech AI Academy\n";
echo "===========================================\n\n";

try {
    $pdo = new PDO(
        'mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'],
        $_ENV['DB_USER'],
        $_ENV['DB_PASSWORD'],
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    
    echo "[✓] Database connection successful\n\n";
    
    // Read and execute migration
    $sql = file_get_contents(__DIR__ . '/../database/migrations/create_cbt_tables.sql');
    
    // Split by semicolon but handle the case where semicolons might be in comments
    $statements = array_filter(array_map('trim', explode(';', $sql)));
    
    $successCount = 0;
    $errorCount = 0;
    
    foreach ($statements as $statement) {
        if (empty($statement) || $statement === '') continue;
        
        // Skip SELECT statements (they're just for messages)
        if (stripos(trim($statement), 'SELECT') === 0) {
            continue;
        }
        
        try {
            $pdo->exec($statement);
            
            // Extract table/view name for logging
            if (preg_match('/CREATE\s+TABLE\s+(?:IF\s+NOT\s+EXISTS\s+)?`?(\w+)`?/i', $statement, $matches)) {
                echo "[✓] Created table: {$matches[1]}\n";
            } elseif (preg_match('/CREATE\s+(?:OR\s+REPLACE\s+)?VIEW\s+`?(\w+)`?/i', $statement, $matches)) {
                echo "[✓] Created view: {$matches[1]}\n";
            } elseif (preg_match('/ALTER\s+TABLE\s+`?(\w+)`?/i', $statement, $matches)) {
                echo "[✓] Altered table: {$matches[1]}\n";
            }
            
            $successCount++;
        } catch (PDOException $e) {
            // Check if it's just a "column already exists" error
            if (strpos($e->getMessage(), 'Duplicate column') !== false) {
                echo "[~] Column already exists, skipping...\n";
            } else {
                echo "[!] Error: " . $e->getMessage() . "\n";
                $errorCount++;
            }
        }
    }
    
    echo "\n===========================================\n";
    echo "  MIGRATION COMPLETE\n";
    echo "  Successful: {$successCount}\n";
    echo "  Errors: {$errorCount}\n";
    echo "===========================================\n";
    
    // Verify tables were created
    echo "\nVerifying CBT tables...\n";
    $tables = [
        'learning_objectives',
        'practicals',
        'practical_submissions',
        'quizzes',
        'quiz_questions',
        'quiz_attempts',
        'milestones',
        'milestone_submissions',
        'competencies',
        'student_competencies',
        'ai_tutor_interactions',
        'capstone_projects',
        'capstone_submissions',
        'lesson_competencies'
    ];
    
    $verified = 0;
    foreach ($tables as $table) {
        $result = $pdo->query("SHOW TABLES LIKE '{$table}'")->rowCount();
        if ($result > 0) {
            echo "[✓] {$table}\n";
            $verified++;
        } else {
            echo "[✗] {$table} - NOT FOUND\n";
        }
    }
    
    echo "\nVerified {$verified}/" . count($tables) . " CBT tables\n";
    
} catch (PDOException $e) {
    echo "[✗] Database error: " . $e->getMessage() . "\n";
    exit(1);
}
