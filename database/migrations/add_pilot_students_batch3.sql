-- =====================================================
-- Pilot Students Batch 3 - Add and Enroll
-- Created: 2026-01-20
-- Description: Add one student for pilot testing
-- =====================================================

-- Student: Yussif Faduila
-- Program: Back-End Development
-- Email: yussiffaduila02@gmail.com

-- Generate UUID for the student
SET @uuid1 = UUID();

-- Insert Student 1: Yussif Faduila
INSERT INTO `users` (
    `uuid`, `email`, `password`, `first_name`, `last_name`, 
    `role`, `client_type`, `preferred_section`, `status`, 
    `email_verified_at`, `created_at`, `updated_at`
) VALUES (
    @uuid1,
    'yussiffaduila02@gmail.com',
    '$2y$10$Chwa7IQm4kWpoG1JyobL8e5JmPxoMAui0OPmapb0gMvixw/pugsr2', -- Password: admin123
    'Yussif',
    'Faduila',
    'student',
    'student',
    'academy',
    'active',
    NOW(),
    NOW(),
    NOW()
);

-- Get the user_id for enrollment
SET @user1_id = LAST_INSERT_ID();

-- Enroll Yussif Faduila in Back-End Development (course_id = 2)
INSERT INTO `enrollments` (`user_id`, `course_id`, `status`, `progress`, `enrolled_at`) 
VALUES (
    @user1_id,
    2, -- Back-End Development
    'active',
    0.00,
    NOW()
);

-- =====================================================
-- Summary:
-- 1 student added
-- 1 enrollment created
-- All students verified and enrolled in respective programs
-- =====================================================
