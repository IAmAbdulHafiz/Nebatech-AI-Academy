-- Schema Improvements Migration
-- Date: November 11, 2025
-- Purpose: Add missing fields and expand ENUMs for better functionality

-- =====================================================
-- 1. ENROLLMENTS TABLE - Expand status options
-- =====================================================
ALTER TABLE `enrollments` 
MODIFY COLUMN `status` enum('active','suspended','completed','cancelled','dropped') DEFAULT 'active';

-- =====================================================
-- 2. SUBMISSIONS TABLE - Add graded_by field
-- =====================================================
ALTER TABLE `submissions` 
ADD COLUMN `graded_by` int(10) UNSIGNED DEFAULT NULL AFTER `facilitator_feedback`,
ADD KEY `idx_graded_by` (`graded_by`),
ADD CONSTRAINT `submissions_ibfk_3` FOREIGN KEY (`graded_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

-- =====================================================
-- 3. CERTIFICATES TABLE - Add revocation support
-- =====================================================
ALTER TABLE `certificates` 
ADD COLUMN `revoked_at` timestamp NULL DEFAULT NULL AFTER `verification_url`,
ADD COLUMN `revoked_by` int(10) UNSIGNED DEFAULT NULL AFTER `revoked_at`,
ADD COLUMN `revocation_reason` text DEFAULT NULL AFTER `revoked_by`,
ADD KEY `idx_revoked_at` (`revoked_at`),
ADD KEY `idx_revoked_by` (`revoked_by`),
ADD CONSTRAINT `certificates_ibfk_3` FOREIGN KEY (`revoked_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

-- =====================================================
-- 4. ACTIVITY_LOGS TABLE - Add index for better performance
-- =====================================================
ALTER TABLE `activity_logs`
ADD KEY `idx_entity` (`entity_type`, `entity_id`);

-- =====================================================
-- 5. STUDY_SESSIONS TABLE - Add course_id for better tracking
-- =====================================================
ALTER TABLE `study_sessions`
ADD COLUMN `course_id` int(10) UNSIGNED DEFAULT NULL AFTER `enrollment_id`,
ADD KEY `idx_course_id` (`course_id`),
ADD CONSTRAINT `study_sessions_ibfk_3` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE SET NULL;

-- =====================================================
-- 6. NOTIFICATIONS TABLE - Add priority field
-- =====================================================
ALTER TABLE `notifications`
ADD COLUMN `priority` enum('low','normal','high','urgent') DEFAULT 'normal' AFTER `type`,
ADD KEY `idx_priority` (`priority`);

-- =====================================================
-- 7. COHORT_SCHEDULES TABLE - Add attendees tracking
-- =====================================================
ALTER TABLE `cohort_schedules`
ADD COLUMN `max_attendees` int(10) UNSIGNED DEFAULT NULL AFTER `duration_minutes`,
ADD COLUMN `attendees_count` int(10) UNSIGNED DEFAULT 0 AFTER `max_attendees`;

-- =====================================================
-- 8. LEARNING_GOALS TABLE - Add reminder settings
-- =====================================================
ALTER TABLE `learning_goals`
ADD COLUMN `reminder_enabled` tinyint(1) DEFAULT 1 AFTER `status`,
ADD COLUMN `reminder_frequency` enum('daily','weekly','custom') DEFAULT 'daily' AFTER `reminder_enabled`;

-- =====================================================
-- 9. PORTFOLIOS TABLE - Add view count
-- =====================================================
ALTER TABLE `portfolios`
ADD COLUMN `view_count` int(10) UNSIGNED DEFAULT 0 AFTER `featured`,
ADD COLUMN `likes_count` int(10) UNSIGNED DEFAULT 0 AFTER `view_count`,
ADD KEY `idx_view_count` (`view_count`),
ADD KEY `idx_likes_count` (`likes_count`);

-- =====================================================
-- 10. COURSES TABLE - Add prerequisites support
-- =====================================================
ALTER TABLE `courses`
ADD COLUMN `prerequisites` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`prerequisites`)) AFTER `ai_generated`,
ADD COLUMN `learning_outcomes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`learning_outcomes`)) AFTER `prerequisites`,
ADD COLUMN `difficulty_score` decimal(3,1) DEFAULT NULL AFTER `level`,
ADD KEY `idx_difficulty_score` (`difficulty_score`);

COMMIT;
