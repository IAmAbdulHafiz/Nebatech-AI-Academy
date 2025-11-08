-- Migration to update submissions table for facilitator verification workflow
-- Run this after initial schema setup

-- Add facilitator_comments column (alias for facilitator_feedback)
ALTER TABLE submissions 
    ADD COLUMN IF NOT EXISTS facilitator_comments TEXT AFTER facilitator_feedback;

-- Add score column (combines AI and manual scores)
ALTER TABLE submissions 
    ADD COLUMN IF NOT EXISTS score INT UNSIGNED AFTER ai_feedback;

-- Update status enum to include new statuses
ALTER TABLE submissions 
    MODIFY COLUMN status ENUM('pending', 'submitted', 'graded', 'revision_requested', 'verified') DEFAULT 'pending';

-- Add index for faster queries
ALTER TABLE submissions 
    ADD INDEX IF NOT EXISTS idx_score (score);

-- Migrate existing data if needed
UPDATE submissions 
SET facilitator_comments = facilitator_feedback 
WHERE facilitator_feedback IS NOT NULL AND facilitator_comments IS NULL;

UPDATE submissions 
SET score = COALESCE(facilitator_score, ai_score)
WHERE score IS NULL;
