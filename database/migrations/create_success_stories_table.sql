-- Create success stories table for student testimonials
CREATE TABLE IF NOT EXISTS `success_stories` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `role` VARCHAR(255) DEFAULT NULL COMMENT 'Current job title/role',
    `course_completed` VARCHAR(255) DEFAULT NULL COMMENT 'Course or program completed',
    `current_position` VARCHAR(255) DEFAULT NULL COMMENT 'Current company or situation',
    `testimonial` TEXT NOT NULL COMMENT 'The success story content',
    `status` ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    `admin_notes` TEXT DEFAULT NULL COMMENT 'Notes from admin during review',
    `reviewed_by` INT DEFAULT NULL COMMENT 'Admin user who reviewed',
    `reviewed_at` DATETIME DEFAULT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`reviewed_by`) REFERENCES `users`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Add indexes for common queries
CREATE INDEX idx_success_stories_status ON success_stories(status);
CREATE INDEX idx_success_stories_user_id ON success_stories(user_id);
CREATE INDEX idx_success_stories_created_at ON success_stories(created_at);
