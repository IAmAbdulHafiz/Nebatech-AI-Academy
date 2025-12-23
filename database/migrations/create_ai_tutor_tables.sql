-- AI Tutor System Database Schema
-- Run this migration to set up AI conversation tracking

-- Store AI conversation sessions
CREATE TABLE IF NOT EXISTS ai_conversations (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    uuid CHAR(36) NOT NULL UNIQUE,
    user_id INT UNSIGNED NOT NULL,
    lesson_id INT UNSIGNED NULL,
    course_id INT UNSIGNED NULL,
    module_id INT UNSIGNED NULL,
    session_type ENUM('lesson_help', 'code_review', 'practice', 'general') DEFAULT 'general',
    title VARCHAR(255) NULL,
    status ENUM('active', 'ended', 'archived') DEFAULT 'active',
    total_tokens INT UNSIGNED DEFAULT 0,
    message_count INT UNSIGNED DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    ended_at TIMESTAMP NULL,
    summary TEXT NULL,
    
    INDEX idx_user_id (user_id),
    INDEX idx_lesson_id (lesson_id),
    INDEX idx_course_id (course_id),
    INDEX idx_status (status),
    INDEX idx_created_at (created_at),
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (lesson_id) REFERENCES lessons(id) ON DELETE SET NULL,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE SET NULL,
    FOREIGN KEY (module_id) REFERENCES modules(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Store individual messages in conversations
CREATE TABLE IF NOT EXISTS ai_messages (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    uuid CHAR(36) NOT NULL UNIQUE,
    conversation_id INT UNSIGNED NOT NULL,
    role ENUM('user', 'assistant', 'system') NOT NULL,
    content TEXT NOT NULL,
    tokens_used INT UNSIGNED DEFAULT 0,
    model VARCHAR(50) DEFAULT 'gpt-4-turbo-preview',
    metadata JSON NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    INDEX idx_conversation_id (conversation_id),
    INDEX idx_role (role),
    INDEX idx_created_at (created_at),
    
    FOREIGN KEY (conversation_id) REFERENCES ai_conversations(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Track AI-generated practice problems
CREATE TABLE IF NOT EXISTS ai_practice_problems (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    uuid CHAR(36) NOT NULL UNIQUE,
    lesson_id INT UNSIGNED NOT NULL,
    user_id INT UNSIGNED NOT NULL,
    problem_type ENUM('multiple_choice', 'coding', 'fill_blank', 'conceptual', 'debugging') NOT NULL,
    difficulty ENUM('easy', 'medium', 'hard') DEFAULT 'medium',
    language VARCHAR(50) NULL,
    problem_content JSON NOT NULL,
    expected_output TEXT NULL,
    user_answer TEXT NULL,
    ai_feedback TEXT NULL,
    score DECIMAL(5,2) NULL,
    is_correct TINYINT(1) DEFAULT NULL,
    time_spent_seconds INT UNSIGNED DEFAULT 0,
    attempts INT UNSIGNED DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    answered_at TIMESTAMP NULL,
    
    INDEX idx_lesson_id (lesson_id),
    INDEX idx_user_id (user_id),
    INDEX idx_problem_type (problem_type),
    INDEX idx_difficulty (difficulty),
    
    FOREIGN KEY (lesson_id) REFERENCES lessons(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Store code review sessions
CREATE TABLE IF NOT EXISTS ai_code_reviews (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    uuid CHAR(36) NOT NULL UNIQUE,
    user_id INT UNSIGNED NOT NULL,
    lesson_id INT UNSIGNED NULL,
    assignment_id INT UNSIGNED NULL,
    language VARCHAR(50) NOT NULL,
    original_code TEXT NOT NULL,
    reviewed_code TEXT NULL,
    feedback TEXT NOT NULL,
    score DECIMAL(5,2) NULL,
    issues_found JSON NULL,
    improvements JSON NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    INDEX idx_user_id (user_id),
    INDEX idx_lesson_id (lesson_id),
    INDEX idx_language (language),
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (lesson_id) REFERENCES lessons(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Cache frequently asked questions and answers
CREATE TABLE IF NOT EXISTS ai_faq_cache (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    question_hash VARCHAR(64) NOT NULL UNIQUE,
    question TEXT NOT NULL,
    answer TEXT NOT NULL,
    lesson_id INT UNSIGNED NULL,
    course_id INT UNSIGNED NULL,
    hit_count INT UNSIGNED DEFAULT 1,
    last_used_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    expires_at TIMESTAMP NULL,
    
    INDEX idx_question_hash (question_hash),
    INDEX idx_lesson_id (lesson_id),
    INDEX idx_hit_count (hit_count),
    
    FOREIGN KEY (lesson_id) REFERENCES lessons(id) ON DELETE SET NULL,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Track student learning patterns for personalization
CREATE TABLE IF NOT EXISTS ai_learning_profiles (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL UNIQUE,
    learning_style ENUM('visual', 'reading', 'kinesthetic', 'mixed') DEFAULT 'mixed',
    preferred_explanation_style ENUM('detailed', 'concise', 'examples', 'analogies') DEFAULT 'examples',
    average_session_length_minutes INT UNSIGNED DEFAULT 30,
    preferred_difficulty ENUM('easy', 'medium', 'hard', 'adaptive') DEFAULT 'adaptive',
    strengths JSON NULL,
    weaknesses JSON NULL,
    topics_mastered JSON NULL,
    topics_struggling JSON NULL,
    total_ai_interactions INT UNSIGNED DEFAULT 0,
    total_practice_completed INT UNSIGNED DEFAULT 0,
    average_practice_score DECIMAL(5,2) DEFAULT 0,
    last_interaction_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Daily usage tracking for cost management
CREATE TABLE IF NOT EXISTS ai_usage_logs (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    date DATE NOT NULL,
    request_count INT UNSIGNED DEFAULT 0,
    tokens_used INT UNSIGNED DEFAULT 0,
    estimated_cost DECIMAL(10,4) DEFAULT 0,
    
    UNIQUE KEY unique_user_date (user_id, date),
    INDEX idx_date (date),
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Content embeddings for RAG (Retrieval Augmented Generation)
CREATE TABLE IF NOT EXISTS ai_content_embeddings (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    content_type ENUM('lesson', 'module', 'course', 'assignment', 'faq') NOT NULL,
    content_id INT UNSIGNED NOT NULL,
    chunk_index INT UNSIGNED DEFAULT 0,
    content_text TEXT NOT NULL,
    embedding BLOB NULL,
    embedding_model VARCHAR(50) DEFAULT 'text-embedding-3-small',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    UNIQUE KEY unique_content_chunk (content_type, content_id, chunk_index),
    INDEX idx_content_type (content_type),
    INDEX idx_content_id (content_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
