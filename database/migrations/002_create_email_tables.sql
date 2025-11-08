-- Email Queue Table
CREATE TABLE IF NOT EXISTS email_queue (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    type VARCHAR(50) NOT NULL COMMENT 'Email type: welcome, grade_notification, revision_request, etc.',
    recipient_email VARCHAR(255) NOT NULL,
    recipient_name VARCHAR(255) NOT NULL,
    subject VARCHAR(255) NULL,
    data JSON NULL COMMENT 'Email template data',
    status ENUM('pending', 'sent', 'failed') DEFAULT 'pending',
    attempts TINYINT UNSIGNED DEFAULT 0,
    error_message TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    sent_at TIMESTAMP NULL,
    INDEX idx_status (status),
    INDEX idx_type (type),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Notification Preferences Table
CREATE TABLE IF NOT EXISTS notification_preferences (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id CHAR(36) NOT NULL,
    email_enabled BOOLEAN DEFAULT TRUE,
    grades BOOLEAN DEFAULT TRUE,
    enrollment BOOLEAN DEFAULT TRUE,
    certificates BOOLEAN DEFAULT TRUE,
    announcements BOOLEAN DEFAULT TRUE,
    reminders BOOLEAN DEFAULT TRUE,
    marketing BOOLEAN DEFAULT FALSE,
    digest_frequency ENUM('immediate', 'daily', 'weekly') DEFAULT 'immediate',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_user (user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Add default notification preferences for existing users
INSERT INTO notification_preferences (user_id, email_enabled, grades, enrollment, certificates, announcements, reminders, marketing)
SELECT id, TRUE, TRUE, TRUE, TRUE, TRUE, TRUE, FALSE
FROM users
WHERE id NOT IN (SELECT user_id FROM notification_preferences);

-- Email Log Table (for tracking sent emails)
CREATE TABLE IF NOT EXISTS email_logs (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id CHAR(36) NULL,
    email_type VARCHAR(50) NOT NULL,
    recipient_email VARCHAR(255) NOT NULL,
    subject VARCHAR(255) NOT NULL,
    status ENUM('sent', 'failed') NOT NULL,
    error_message TEXT NULL,
    sent_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_user_id (user_id),
    INDEX idx_email_type (email_type),
    INDEX idx_sent_at (sent_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
