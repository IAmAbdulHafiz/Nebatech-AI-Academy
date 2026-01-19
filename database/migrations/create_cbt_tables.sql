-- =====================================================
-- COMPETENCY-BASED TRAINING (CBT) DATABASE SCHEMA
-- Nebatech Software Solutions Ltd
-- Created: December 25, 2025
-- =====================================================

-- =====================================================
-- 1. LEARNING OBJECTIVES TABLE
-- Each lesson has 3-5 measurable learning objectives
-- =====================================================
CREATE TABLE IF NOT EXISTS learning_objectives (
    id INT AUTO_INCREMENT PRIMARY KEY,
    lesson_id INT NOT NULL,
    objective_number INT NOT NULL DEFAULT 1,
    objective_text TEXT NOT NULL,
    bloom_level ENUM('remember', 'understand', 'apply', 'analyze', 'evaluate', 'create') DEFAULT 'understand',
    is_assessable BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (lesson_id) REFERENCES lessons(id) ON DELETE CASCADE,
    INDEX idx_lesson_objectives (lesson_id),
    UNIQUE KEY unique_lesson_objective (lesson_id, objective_number)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 2. PRACTICAL EXERCISES TABLE
-- Hands-on tasks for each lesson
-- =====================================================
CREATE TABLE IF NOT EXISTS practicals (
    id INT AUTO_INCREMENT PRIMARY KEY,
    lesson_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    instructions TEXT NOT NULL,
    expected_outcome TEXT NOT NULL,
    starter_code TEXT NULL,
    solution_code TEXT NULL,
    hints JSON NULL,
    difficulty ENUM('beginner', 'intermediate', 'advanced') DEFAULT 'beginner',
    estimated_time_minutes INT DEFAULT 30,
    practical_type ENUM('coding', 'design', 'documentation', 'research', 'hands-on', 'project') DEFAULT 'coding',
    resources JSON NULL,
    rubric JSON NULL,
    max_points INT DEFAULT 100,
    passing_score INT DEFAULT 70,
    is_required BOOLEAN DEFAULT TRUE,
    status ENUM('draft', 'published', 'archived') DEFAULT 'published',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (lesson_id) REFERENCES lessons(id) ON DELETE CASCADE,
    INDEX idx_lesson_practicals (lesson_id),
    INDEX idx_practical_type (practical_type)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 3. PRACTICAL SUBMISSIONS TABLE
-- Student submissions for practicals
-- =====================================================
CREATE TABLE IF NOT EXISTS practical_submissions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    practical_id INT NOT NULL,
    user_id INT NOT NULL,
    enrollment_id INT NOT NULL,
    submission_content TEXT NOT NULL,
    submission_files JSON NULL,
    status ENUM('submitted', 'in_review', 'passed', 'failed', 'needs_revision') DEFAULT 'submitted',
    score INT NULL,
    feedback TEXT NULL,
    ai_feedback TEXT NULL,
    reviewed_by INT NULL,
    reviewed_at TIMESTAMP NULL,
    attempts INT DEFAULT 1,
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (practical_id) REFERENCES practicals(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (enrollment_id) REFERENCES enrollments(id) ON DELETE CASCADE,
    FOREIGN KEY (reviewed_by) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_user_practicals (user_id, practical_id),
    INDEX idx_enrollment_practicals (enrollment_id),
    INDEX idx_submission_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 4. QUIZZES TABLE
-- Quiz metadata for each lesson
-- =====================================================
CREATE TABLE IF NOT EXISTS quizzes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    lesson_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT NULL,
    quiz_type ENUM('knowledge_check', 'assessment', 'practice', 'certification') DEFAULT 'knowledge_check',
    time_limit_minutes INT NULL,
    max_attempts INT DEFAULT 3,
    passing_score INT DEFAULT 70,
    shuffle_questions BOOLEAN DEFAULT TRUE,
    shuffle_options BOOLEAN DEFAULT TRUE,
    show_correct_answers BOOLEAN DEFAULT TRUE,
    show_explanations BOOLEAN DEFAULT TRUE,
    is_required BOOLEAN DEFAULT TRUE,
    status ENUM('draft', 'published', 'archived') DEFAULT 'published',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (lesson_id) REFERENCES lessons(id) ON DELETE CASCADE,
    INDEX idx_lesson_quizzes (lesson_id),
    INDEX idx_quiz_type (quiz_type)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 5. QUIZ QUESTIONS TABLE
-- Individual questions for quizzes
-- =====================================================
CREATE TABLE IF NOT EXISTS quiz_questions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    quiz_id INT NOT NULL,
    question_number INT NOT NULL DEFAULT 1,
    question_text TEXT NOT NULL,
    question_type ENUM('multiple_choice', 'true_false', 'multiple_select', 'short_answer', 'code') DEFAULT 'multiple_choice',
    options JSON NULL,
    correct_answer JSON NOT NULL,
    explanation TEXT NULL,
    points INT DEFAULT 1,
    difficulty ENUM('easy', 'medium', 'hard') DEFAULT 'medium',
    code_language VARCHAR(50) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (quiz_id) REFERENCES quizzes(id) ON DELETE CASCADE,
    INDEX idx_quiz_questions (quiz_id),
    INDEX idx_question_type (question_type)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 6. QUIZ ATTEMPTS TABLE
-- Student quiz attempts and scores
-- =====================================================
CREATE TABLE IF NOT EXISTS quiz_attempts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    quiz_id INT NOT NULL,
    user_id INT NOT NULL,
    enrollment_id INT NOT NULL,
    attempt_number INT DEFAULT 1,
    answers JSON NOT NULL,
    score DECIMAL(5,2) NOT NULL DEFAULT 0,
    total_points INT NOT NULL DEFAULT 0,
    earned_points INT NOT NULL DEFAULT 0,
    passed BOOLEAN DEFAULT FALSE,
    time_taken_seconds INT NULL,
    started_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    completed_at TIMESTAMP NULL,
    reviewed_at TIMESTAMP NULL,
    FOREIGN KEY (quiz_id) REFERENCES quizzes(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (enrollment_id) REFERENCES enrollments(id) ON DELETE CASCADE,
    INDEX idx_user_quiz_attempts (user_id, quiz_id),
    INDEX idx_enrollment_attempts (enrollment_id),
    INDEX idx_attempt_score (score)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 7. MILESTONES TABLE
-- Competency checkpoints per module
-- =====================================================
CREATE TABLE IF NOT EXISTS milestones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    module_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    milestone_type ENUM('knowledge_check', 'practical_assessment', 'mini_project', 'peer_review', 'portfolio_piece') DEFAULT 'practical_assessment',
    requirements JSON NOT NULL,
    competencies JSON NOT NULL,
    instructions TEXT NOT NULL,
    rubric JSON NOT NULL,
    max_points INT DEFAULT 100,
    passing_score INT DEFAULT 70,
    estimated_hours DECIMAL(4,1) DEFAULT 2.0,
    is_required BOOLEAN DEFAULT TRUE,
    status ENUM('draft', 'published', 'archived') DEFAULT 'published',
    order_index INT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (module_id) REFERENCES modules(id) ON DELETE CASCADE,
    INDEX idx_module_milestones (module_id),
    INDEX idx_milestone_type (milestone_type)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 8. MILESTONE SUBMISSIONS TABLE
-- Student milestone submissions
-- =====================================================
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
    FOREIGN KEY (milestone_id) REFERENCES milestones(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (enrollment_id) REFERENCES enrollments(id) ON DELETE CASCADE,
    FOREIGN KEY (reviewed_by) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_user_milestones (user_id, milestone_id),
    INDEX idx_enrollment_milestones (enrollment_id),
    INDEX idx_milestone_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 9. COMPETENCIES TABLE
-- Master list of competencies per course
-- =====================================================
CREATE TABLE IF NOT EXISTS competencies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    course_id INT NOT NULL,
    competency_code VARCHAR(50) NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    category VARCHAR(100) NULL,
    level ENUM('foundational', 'intermediate', 'advanced', 'expert') DEFAULT 'foundational',
    is_core BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE,
    UNIQUE KEY unique_competency_code (course_id, competency_code),
    INDEX idx_course_competencies (course_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 10. STUDENT COMPETENCIES TABLE
-- Track student competency achievements
-- =====================================================
CREATE TABLE IF NOT EXISTS student_competencies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    competency_id INT NOT NULL,
    enrollment_id INT NOT NULL,
    proficiency_level ENUM('not_started', 'developing', 'competent', 'proficient', 'expert') DEFAULT 'not_started',
    evidence JSON NULL,
    assessed_at TIMESTAMP NULL,
    assessed_by INT NULL,
    notes TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (competency_id) REFERENCES competencies(id) ON DELETE CASCADE,
    FOREIGN KEY (enrollment_id) REFERENCES enrollments(id) ON DELETE CASCADE,
    FOREIGN KEY (assessed_by) REFERENCES users(id) ON DELETE SET NULL,
    UNIQUE KEY unique_student_competency (user_id, competency_id, enrollment_id),
    INDEX idx_student_competencies (user_id, enrollment_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 11. AI TUTOR INTERACTIONS TABLE
-- Enhanced AI tutor context tracking
-- =====================================================
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
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE SET NULL,
    FOREIGN KEY (module_id) REFERENCES modules(id) ON DELETE SET NULL,
    FOREIGN KEY (lesson_id) REFERENCES lessons(id) ON DELETE SET NULL,
    INDEX idx_user_sessions (user_id, session_id),
    INDEX idx_interaction_context (course_id, lesson_id),
    INDEX idx_interaction_type (interaction_type)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 12. CAPSTONE PROJECTS TABLE
-- Final course projects for portfolio
-- =====================================================
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
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE,
    INDEX idx_course_capstone (course_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 13. CAPSTONE SUBMISSIONS TABLE
-- Student capstone project submissions
-- =====================================================
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
    FOREIGN KEY (capstone_id) REFERENCES capstone_projects(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (enrollment_id) REFERENCES enrollments(id) ON DELETE CASCADE,
    FOREIGN KEY (reviewed_by) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_user_capstone (user_id, capstone_id),
    INDEX idx_capstone_status (status),
    INDEX idx_featured_capstones (is_featured, is_public)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 14. LESSON COMPETENCY MAPPING TABLE
-- Links lessons to specific competencies
-- =====================================================
CREATE TABLE IF NOT EXISTS lesson_competencies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    lesson_id INT NOT NULL,
    competency_id INT NOT NULL,
    coverage_level ENUM('introduces', 'reinforces', 'masters') DEFAULT 'introduces',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (lesson_id) REFERENCES lessons(id) ON DELETE CASCADE,
    FOREIGN KEY (competency_id) REFERENCES competencies(id) ON DELETE CASCADE,
    UNIQUE KEY unique_lesson_competency (lesson_id, competency_id),
    INDEX idx_competency_lessons (competency_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- UPDATE LESSONS TABLE - Add CBT fields
-- =====================================================
ALTER TABLE lessons 
    ADD COLUMN IF NOT EXISTS has_practical BOOLEAN DEFAULT FALSE AFTER content,
    ADD COLUMN IF NOT EXISTS has_quiz BOOLEAN DEFAULT FALSE AFTER has_practical,
    ADD COLUMN IF NOT EXISTS practical_id INT NULL AFTER has_quiz,
    ADD COLUMN IF NOT EXISTS quiz_id INT NULL AFTER practical_id,
    ADD COLUMN IF NOT EXISTS competency_summary TEXT NULL AFTER quiz_id;

-- =====================================================
-- UPDATE MODULES TABLE - Add milestone reference
-- =====================================================
ALTER TABLE modules
    ADD COLUMN IF NOT EXISTS has_milestone BOOLEAN DEFAULT FALSE AFTER description,
    ADD COLUMN IF NOT EXISTS milestone_id INT NULL AFTER has_milestone,
    ADD COLUMN IF NOT EXISTS competencies_covered JSON NULL AFTER milestone_id;

-- =====================================================
-- UPDATE COURSES TABLE - Add CBT tracking
-- =====================================================
ALTER TABLE courses
    ADD COLUMN IF NOT EXISTS is_cbt BOOLEAN DEFAULT TRUE AFTER status,
    ADD COLUMN IF NOT EXISTS total_competencies INT DEFAULT 0 AFTER is_cbt,
    ADD COLUMN IF NOT EXISTS has_capstone BOOLEAN DEFAULT FALSE AFTER total_competencies,
    ADD COLUMN IF NOT EXISTS capstone_id INT NULL AFTER has_capstone;

-- =====================================================
-- CREATE VIEWS FOR REPORTING
-- =====================================================

-- Student CBT Progress View
CREATE OR REPLACE VIEW v_student_cbt_progress AS
SELECT 
    e.user_id,
    e.course_id,
    e.id as enrollment_id,
    u.name as student_name,
    c.title as course_title,
    COUNT(DISTINCT lo.id) as total_objectives,
    COUNT(DISTINCT CASE WHEN lp.status = 'completed' THEN lo.id END) as completed_objectives,
    COUNT(DISTINCT p.id) as total_practicals,
    COUNT(DISTINCT CASE WHEN ps.status = 'passed' THEN p.id END) as passed_practicals,
    COUNT(DISTINCT q.id) as total_quizzes,
    COUNT(DISTINCT CASE WHEN qa.passed = 1 THEN q.id END) as passed_quizzes,
    COUNT(DISTINCT m.id) as total_milestones,
    COUNT(DISTINCT CASE WHEN ms.status = 'passed' THEN m.id END) as passed_milestones,
    COALESCE(AVG(qa.score), 0) as avg_quiz_score,
    COALESCE(AVG(ps.score), 0) as avg_practical_score
FROM enrollments e
JOIN users u ON e.user_id = u.id
JOIN courses c ON e.course_id = c.id
LEFT JOIN modules mod ON mod.course_id = c.id
LEFT JOIN lessons l ON l.module_id = mod.id
LEFT JOIN learning_objectives lo ON lo.lesson_id = l.id
LEFT JOIN lesson_progress lp ON lp.lesson_id = l.id AND lp.user_id = e.user_id
LEFT JOIN practicals p ON p.lesson_id = l.id
LEFT JOIN practical_submissions ps ON ps.practical_id = p.id AND ps.user_id = e.user_id
LEFT JOIN quizzes q ON q.lesson_id = l.id
LEFT JOIN quiz_attempts qa ON qa.quiz_id = q.id AND qa.user_id = e.user_id
LEFT JOIN milestones m ON m.module_id = mod.id
LEFT JOIN milestone_submissions ms ON ms.milestone_id = m.id AND ms.user_id = e.user_id
GROUP BY e.user_id, e.course_id, e.id, u.name, c.title;

-- Competency Achievement View
CREATE OR REPLACE VIEW v_competency_achievements AS
SELECT 
    sc.user_id,
    u.name as student_name,
    c.id as course_id,
    c.title as course_title,
    comp.competency_code,
    comp.title as competency_title,
    comp.level as competency_level,
    sc.proficiency_level,
    sc.assessed_at
FROM student_competencies sc
JOIN users u ON sc.user_id = u.id
JOIN competencies comp ON sc.competency_id = comp.id
JOIN courses c ON comp.course_id = c.id
ORDER BY sc.user_id, c.id, comp.competency_code;

-- =====================================================
-- SUCCESS MESSAGE
-- =====================================================
SELECT 'CBT Schema created successfully!' as message;
