-- =====================================================
-- Add Additional Pilot Test Students for Nebatech Software Solutions Ltd
-- Date: January 20, 2026
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

-- 1. Mohammed Nakia Tunteiya - Cyber Security
INSERT INTO `users` (
    `uuid`, `email`, `password`, `first_name`, `last_name`, 
    `role`, `client_type`, `preferred_section`, `status`, 
    `email_verified_at`, `created_at`, `updated_at`
) VALUES (
    @uuid1,
    'mohammednakia231@gmail.com',
    '$2y$10$Chwa7IQm4kWpoG1JyobL8e5JmPxoMAui0OPmapb0gMvixw/pugsr2',
    'Mohammed Nakia',
    'Tunteiya',
    'student',
    'student',
    'academy',
    'active',
    NOW(),
    NOW(),
    NOW()
);

SET @user1_id = LAST_INSERT_ID();

-- 2. Abdul Nasir Saida Mariam - Full-Stack Development
INSERT INTO `users` (
    `uuid`, `email`, `password`, `first_name`, `last_name`, 
    `role`, `client_type`, `preferred_section`, `status`, 
    `email_verified_at`, `created_at`, `updated_at`
) VALUES (
    @uuid2,
    'saidamariamabdulnasir@gmail.com',
    '$2y$10$Chwa7IQm4kWpoG1JyobL8e5JmPxoMAui0OPmapb0gMvixw/pugsr2',
    'Abdul Nasir Saida',
    'Mariam',
    'student',
    'student',
    'academy',
    'active',
    NOW(),
    NOW(),
    NOW()
);

SET @user2_id = LAST_INSERT_ID();

-- 3. Wumpini Mashoud - Cyber Security
INSERT INTO `users` (
    `uuid`, `email`, `password`, `first_name`, `last_name`, 
    `role`, `client_type`, `preferred_section`, `status`, 
    `email_verified_at`, `created_at`, `updated_at`
) VALUES (
    @uuid3,
    'wumpinimashoud83@gmail.com',
    '$2y$10$Chwa7IQm4kWpoG1JyobL8e5JmPxoMAui0OPmapb0gMvixw/pugsr2',
    'Wumpini',
    'Mashoud',
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
-- Cybersecurity = 8

-- Enroll Mohammed Nakia Tunteiya in Cyber Security
INSERT INTO `enrollments` (`user_id`, `course_id`, `status`, `progress`, `enrolled_at`)
VALUES (@user1_id, 8, 'active', 0.00, NOW());

-- Enroll Abdul Nasir Saida Mariam in Full-Stack Development
INSERT INTO `enrollments` (`user_id`, `course_id`, `status`, `progress`, `enrolled_at`)
VALUES (@user2_id, 3, 'active', 0.00, NOW());

-- Enroll Wumpini Mashoud in Cyber Security
INSERT INTO `enrollments` (`user_id`, `course_id`, `status`, `progress`, `enrolled_at`)
VALUES (@user3_id, 8, 'active', 0.00, NOW());

-- =====================================================
-- Verification Query (Run after insert to verify)
-- =====================================================
-- SELECT u.id, u.first_name, u.last_name, u.email, c.title as course
-- FROM users u
-- JOIN enrollments e ON u.id = e.user_id
-- JOIN courses c ON e.course_id = c.id
-- WHERE u.email IN ('mohammednakia231@gmail.com', 'saidamariamabdulnasir@gmail.com', 'wumpinimashoud83@gmail.com');
