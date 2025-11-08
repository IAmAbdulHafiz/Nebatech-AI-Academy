-- Badges Table
CREATE TABLE IF NOT EXISTS badges (
    id CHAR(36) PRIMARY KEY DEFAULT (UUID()),
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL UNIQUE,
    description TEXT NOT NULL,
    icon VARCHAR(255) NULL COMMENT 'Font Awesome icon class or image path',
    category ENUM('course_completion', 'assignment_quality', 'streak', 'special') NOT NULL,
    criteria JSON NOT NULL COMMENT 'Requirements to earn badge',
    points INT UNSIGNED DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_category (category),
    INDEX idx_slug (slug)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- User Badges (Earned Achievements)
CREATE TABLE IF NOT EXISTS user_badges (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    badge_id CHAR(36) NOT NULL,
    earned_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    metadata JSON NULL COMMENT 'Additional data about earning (course_id, score, etc.)',
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (badge_id) REFERENCES badges(id) ON DELETE CASCADE,
    UNIQUE KEY unique_user_badge (user_id, badge_id),
    INDEX idx_user_id (user_id),
    INDEX idx_earned_at (earned_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Certificates Table
CREATE TABLE IF NOT EXISTS certificates (
    id CHAR(36) PRIMARY KEY DEFAULT (UUID()),
    user_id INT UNSIGNED NOT NULL,
    course_id INT UNSIGNED NOT NULL,
    certificate_number VARCHAR(50) NOT NULL UNIQUE,
    issue_date DATE NOT NULL,
    pdf_path VARCHAR(255) NULL,
    verification_code VARCHAR(100) NOT NULL UNIQUE,
    metadata JSON NULL COMMENT 'Completion details (final_score, completion_date, etc.)',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE,
    INDEX idx_user_id (user_id),
    INDEX idx_course_id (course_id),
    INDEX idx_verification_code (verification_code),
    INDEX idx_certificate_number (certificate_number)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Portfolio Items (Featured Projects)
CREATE TABLE IF NOT EXISTS portfolio_items (
    id CHAR(36) PRIMARY KEY DEFAULT (UUID()),
    user_id INT UNSIGNED NOT NULL,
    submission_id INT UNSIGNED NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT NULL,
    thumbnail_path VARCHAR(255) NULL,
    is_featured BOOLEAN DEFAULT FALSE,
    is_public BOOLEAN DEFAULT TRUE,
    display_order INT UNSIGNED DEFAULT 0,
    views INT UNSIGNED DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (submission_id) REFERENCES submissions(id) ON DELETE CASCADE,
    INDEX idx_user_id (user_id),
    INDEX idx_featured (is_featured),
    INDEX idx_public (is_public),
    INDEX idx_display_order (display_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Portfolio Settings
CREATE TABLE IF NOT EXISTS portfolio_settings (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    bio TEXT NULL,
    tagline VARCHAR(255) NULL,
    github_url VARCHAR(255) NULL,
    linkedin_url VARCHAR(255) NULL,
    twitter_url VARCHAR(255) NULL,
    website_url VARCHAR(255) NULL,
    is_public BOOLEAN DEFAULT TRUE,
    show_badges BOOLEAN DEFAULT TRUE,
    show_certificates BOOLEAN DEFAULT TRUE,
    show_contact BOOLEAN DEFAULT TRUE,
    theme VARCHAR(50) DEFAULT 'default',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_user (user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert Default Badges
INSERT INTO badges (id, name, slug, description, icon, category, criteria, points) VALUES
(UUID(), 'First Steps', 'first-steps', 'Completed your first lesson', 'fa-baby-carriage', 'special', '{"type": "lesson_completion", "count": 1}', 10),
(UUID(), 'Code Warrior', 'code-warrior', 'Submitted your first assignment', 'fa-code', 'special', '{"type": "assignment_submission", "count": 1}', 20),
(UUID(), 'Perfect Score', 'perfect-score', 'Achieved 100% on an assignment', 'fa-star', 'assignment_quality', '{"type": "perfect_score", "score": 100}', 50),
(UUID(), 'HTML Master', 'html-master', 'Completed HTML Fundamentals module', 'fa-file-code', 'course_completion', '{"type": "module_completion", "module_slug": "html-fundamentals"}', 100),
(UUID(), 'CSS Expert', 'css-expert', 'Completed CSS Styling module', 'fa-paint-brush', 'course_completion', '{"type": "module_completion", "module_slug": "css-styling"}', 100),
(UUID(), 'JavaScript Ninja', 'javascript-ninja', 'Completed JavaScript Basics module', 'fa-bolt', 'course_completion', '{"type": "module_completion", "module_slug": "javascript-basics"}', 100),
(UUID(), 'Course Completer', 'course-completer', 'Completed your first course', 'fa-graduation-cap', 'course_completion', '{"type": "course_completion", "count": 1}', 200),
(UUID(), 'Overachiever', 'overachiever', 'Completed 3 courses', 'fa-trophy', 'course_completion', '{"type": "course_completion", "count": 3}', 500),
(UUID(), 'Streak Master', 'streak-master', 'Maintained a 7-day learning streak', 'fa-fire', 'streak', '{"type": "streak", "days": 7}', 150),
(UUID(), 'Dedication', 'dedication', 'Maintained a 30-day learning streak', 'fa-calendar-check', 'streak', '{"type": "streak", "days": 30}', 300),
(UUID(), 'High Achiever', 'high-achiever', 'Maintained 90%+ average across 5 assignments', 'fa-chart-line', 'assignment_quality', '{"type": "high_average", "average": 90, "count": 5}', 250),
(UUID(), 'Early Bird', 'early-bird', 'Submitted 5 assignments before deadline', 'fa-clock', 'special', '{"type": "early_submission", "count": 5}', 100);

-- Create default portfolio settings for existing users
INSERT INTO portfolio_settings (user_id, is_public, show_badges, show_certificates, show_contact)
SELECT id, TRUE, TRUE, TRUE, TRUE
FROM users
WHERE id NOT IN (SELECT user_id FROM portfolio_settings);
