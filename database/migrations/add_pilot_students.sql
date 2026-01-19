-- =====================================================
-- Add Pilot Test Students for Nebatech Software Solutions Ltd
-- Date: January 19, 2026
-- =====================================================

-- Password for all: admin123
-- Hash: $2y$10$Chwa7IQm4kWpoG1JyobL8e5JmPxoMAui0OPmapb0gMvixw/pugsr2

-- Generate UUIDs for each student
SET @uuid1 = UUID();
SET @uuid2 = UUID();
SET @uuid3 = UUID();

-- =====================================================
-- Insert Students
-- =====================================================

-- 1. Sae-ed Iddrisu - Full-Stack Development
INSERT INTO `users` (
    `uuid`, `email`, `password`, `first_name`, `last_name`, 
    `role`, `client_type`, `preferred_section`, `status`, 
    `email_verified_at`, `created_at`, `updated_at`
) VALUES (
    @uuid1,
    'iiddrisusaeed@gmail.com',
    '$2y$10$Chwa7IQm4kWpoG1JyobL8e5JmPxoMAui0OPmapb0gMvixw/pugsr2',
    'Sae-ed',
    'Iddrisu',
    'student',
    'student',
    'academy',
    'active',
    NOW(),
    NOW(),
    NOW()
);

SET @user1_id = LAST_INSERT_ID();

-- 2. Sam-un Abubakari - Full-Stack Development
INSERT INTO `users` (
    `uuid`, `email`, `password`, `first_name`, `last_name`, 
    `role`, `client_type`, `preferred_section`, `status`, 
    `email_verified_at`, `created_at`, `updated_at`
) VALUES (
    @uuid2,
    'shamunaabubakari80@gmail.com',
    '$2y$10$Chwa7IQm4kWpoG1JyobL8e5JmPxoMAui0OPmapb0gMvixw/pugsr2',
    'Sam-un',
    'Abubakari',
    'student',
    'student',
    'academy',
    'active',
    NOW(),
    NOW(),
    NOW()
);

SET @user2_id = LAST_INSERT_ID();

-- 3. Tahiru Falila - AI & Machine Learning
INSERT INTO `users` (
    `uuid`, `email`, `password`, `first_name`, `last_name`, 
    `role`, `client_type`, `preferred_section`, `status`, 
    `email_verified_at`, `created_at`, `updated_at`
) VALUES (
    @uuid3,
    'tahirufalila92@gmail.com',
    '$2y$10$Chwa7IQm4kWpoG1JyobL8e5JmPxoMAui0OPmapb0gMvixw/pugsr2',
    'Tahiru',
    'Falila',
    'student',
    'student',
    'academy',
    'active',
    NOW(),
    NOW(),
    NOW()
);

SET @user3_id = LAST_INSERT_ID();

-- =====================================================
-- Enroll Students in Their Programs
-- =====================================================

-- Course IDs:
-- Full Stack Development = 3
-- AI & Machine Learning = 5

-- Enroll Sae-ed Iddrisu in Full-Stack Development
INSERT INTO `enrollments` (`user_id`, `course_id`, `status`, `progress`, `enrolled_at`)
VALUES (@user1_id, 3, 'active', 0.00, NOW());

-- Enroll Sam-un Abubakari in Full-Stack Development
INSERT INTO `enrollments` (`user_id`, `course_id`, `status`, `progress`, `enrolled_at`)
VALUES (@user2_id, 3, 'active', 0.00, NOW());

-- Enroll Tahiru Falila in AI & Machine Learning
INSERT INTO `enrollments` (`user_id`, `course_id`, `status`, `progress`, `enrolled_at`)
VALUES (@user3_id, 5, 'active', 0.00, NOW());

-- =====================================================
-- Verification Query (Run after insert to verify)
-- =====================================================
-- SELECT u.id, u.first_name, u.last_name, u.email, c.title as course
-- FROM users u
-- JOIN enrollments e ON u.id = e.user_id
-- JOIN courses c ON e.course_id = c.id
-- WHERE u.email IN ('iiddrisusaeed@gmail.com', 'shamunaabubakari80@gmail.com', 'tahirufalila92@gmail.com');
