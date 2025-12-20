-- Create cohort_members table for tracking students in cohorts
-- Run this migration to add the cohort_members table

CREATE TABLE IF NOT EXISTS `cohort_members` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `cohort_id` INT UNSIGNED NOT NULL,
    `user_id` INT UNSIGNED NOT NULL,
    `status` ENUM('active', 'inactive', 'completed', 'removed') NOT NULL DEFAULT 'active',
    `invited_at` DATETIME NULL,
    `joined_at` DATETIME NULL,
    `completed_at` DATETIME NULL,
    `removed_at` DATETIME NULL,
    `notes` TEXT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `unique_cohort_user` (`cohort_id`, `user_id`),
    KEY `idx_cohort_id` (`cohort_id`),
    KEY `idx_user_id` (`user_id`),
    KEY `idx_status` (`status`),
    CONSTRAINT `cohort_members_cohort_fk` FOREIGN KEY (`cohort_id`) REFERENCES `cohorts` (`id`) ON DELETE CASCADE,
    CONSTRAINT `cohort_members_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Add missing columns to cohort_invitations if they don't exist
ALTER TABLE `cohort_invitations` 
    ADD COLUMN IF NOT EXISTS `token` VARCHAR(64) NULL AFTER `email`,
    ADD COLUMN IF NOT EXISTS `expires_at` DATETIME NULL AFTER `status`,
    ADD COLUMN IF NOT EXISTS `accepted_at` DATETIME NULL AFTER `expires_at`;

-- Add index on token for faster lookups
CREATE INDEX IF NOT EXISTS `idx_invitation_token` ON `cohort_invitations` (`token`);

-- Update cohort_invitations status enum if needed
ALTER TABLE `cohort_invitations` 
    MODIFY COLUMN `status` ENUM('pending', 'accepted', 'declined', 'expired', 'cancelled') NOT NULL DEFAULT 'pending';
