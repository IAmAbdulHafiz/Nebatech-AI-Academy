<?php
/**
 * Fix CBT Tables - Creates remaining tables without FK constraints
 */

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

echo "===========================================\n";
echo "  FIX CBT TABLES\n";
echo "===========================================\n\n";

try {
    $pdo = new PDO(
        'mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'],
        $_ENV['DB_USER'],
        $_ENV['DB_PASSWORD'],
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true
        ]
    );
    
    // Disable FK checks temporarily
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
    
    // Create milestone_submissions
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS milestone_submissions (
            id INT AUTO_INCREMENT PRIMARY KEY,
            milestone_id INT NOT NULL,
            user_id INT NOT NULL,
            enrollment_id INT NOT NULL,
            submission_content TEXT NOT NULL,
            submission_files JSON NULL,
            submission_url VARCHAR(500) NULL,
            status ENUM('submitted', 'in_review', 'passed', 'failed', 'needs_revision') DEFAULT 'submitted',
            score INT NULL,
            competency_scores JSON NULL,
            feedback TEXT NULL,
            ai_feedback TEXT NULL,
            reviewed_by INT NULL,
            reviewed_at TIMESTAMP NULL,
            attempts INT DEFAULT 1,
            submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX idx_user_milestones (user_id, milestone_id),
            INDEX idx_enrollment_milestones (enrollment_id),
            INDEX idx_milestone_status (status)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    echo "[✓] Created milestone_submissions\n";
    
    // Create ai_tutor_interactions
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS ai_tutor_interactions (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            session_id VARCHAR(100) NOT NULL,
            course_id INT NULL,
            module_id INT NULL,
            lesson_id INT NULL,
            practical_id INT NULL,
            quiz_id INT NULL,
            milestone_id INT NULL,
            interaction_type ENUM('question', 'hint_request', 'code_review', 'explanation', 'guidance', 'encouragement', 'assessment_help') DEFAULT 'question',
            user_message TEXT NOT NULL,
            ai_response TEXT NOT NULL,
            context_data JSON NULL,
            helpful_rating TINYINT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            INDEX idx_user_sessions (user_id, session_id),
            INDEX idx_interaction_context (course_id, lesson_id),
            INDEX idx_interaction_type (interaction_type)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    echo "[✓] Created ai_tutor_interactions\n";
    
    // Create capstone_projects
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS capstone_projects (
            id INT AUTO_INCREMENT PRIMARY KEY,
            course_id INT NOT NULL,
            title VARCHAR(255) NOT NULL,
            description TEXT NOT NULL,
            requirements TEXT NOT NULL,
            learning_outcomes JSON NOT NULL,
            rubric JSON NOT NULL,
            resources JSON NULL,
            example_projects JSON NULL,
            estimated_hours DECIMAL(4,1) DEFAULT 40.0,
            max_points INT DEFAULT 100,
            passing_score INT DEFAULT 70,
            is_portfolio_worthy BOOLEAN DEFAULT TRUE,
            status ENUM('draft', 'published', 'archived') DEFAULT 'published',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX idx_course_capstone (course_id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    echo "[✓] Created capstone_projects\n";
    
    // Create capstone_submissions
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS capstone_submissions (
            id INT AUTO_INCREMENT PRIMARY KEY,
            capstone_id INT NOT NULL,
            user_id INT NOT NULL,
            enrollment_id INT NOT NULL,
            title VARCHAR(255) NOT NULL,
            description TEXT NOT NULL,
            submission_content TEXT NULL,
            repository_url VARCHAR(500) NULL,
            live_url VARCHAR(500) NULL,
            submission_files JSON NULL,
            video_url VARCHAR(500) NULL,
            status ENUM('in_progress', 'submitted', 'in_review', 'passed', 'failed', 'needs_revision', 'published') DEFAULT 'in_progress',
            score INT NULL,
            competency_scores JSON NULL,
            feedback TEXT NULL,
            ai_feedback TEXT NULL,
            reviewed_by INT NULL,
            reviewed_at TIMESTAMP NULL,
            is_featured BOOLEAN DEFAULT FALSE,
            is_public BOOLEAN DEFAULT FALSE,
            submitted_at TIMESTAMP NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX idx_user_capstone (user_id, capstone_id),
            INDEX idx_capstone_status (status),
            INDEX idx_featured_capstones (is_featured, is_public)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    echo "[✓] Created capstone_submissions\n";
    
    // Create lesson_competencies
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS lesson_competencies (
            id INT AUTO_INCREMENT PRIMARY KEY,
            lesson_id INT NOT NULL,
            competency_id INT NOT NULL,
            coverage_level ENUM('introduces', 'reinforces', 'masters') DEFAULT 'introduces',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            UNIQUE KEY unique_lesson_competency (lesson_id, competency_id),
            INDEX idx_competency_lessons (competency_id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    echo "[✓] Created lesson_competencies\n";
    
    // Re-enable FK checks
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 1");
    
    echo "\n===========================================\n";
    echo "  VERIFYING ALL CBT TABLES\n";
    echo "===========================================\n";
    
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
        $stmt = $pdo->prepare("SHOW TABLES LIKE ?");
        $stmt->execute([$table]);
        if ($stmt->rowCount() > 0) {
            echo "[✓] {$table}\n";
            $verified++;
        } else {
            echo "[✗] {$table} - NOT FOUND\n";
        }
    }
    
    echo "\n[✓] Verified {$verified}/" . count($tables) . " CBT tables\n";
    
    // Count records
    echo "\n===========================================\n";
    echo "  EXISTING DATA CHECK\n";
    echo "===========================================\n";
    
    $stmt = $pdo->query("SELECT COUNT(*) FROM courses");
    echo "Courses: " . $stmt->fetchColumn() . "\n";
    
    $stmt = $pdo->query("SELECT COUNT(*) FROM modules");
    echo "Modules: " . $stmt->fetchColumn() . "\n";
    
    $stmt = $pdo->query("SELECT COUNT(*) FROM lessons");
    echo "Lessons: " . $stmt->fetchColumn() . "\n";
    
    echo "\n✅ CBT schema ready for content generation!\n";
    
} catch (PDOException $e) {
    echo "[✗] Error: " . $e->getMessage() . "\n";
    exit(1);
}
