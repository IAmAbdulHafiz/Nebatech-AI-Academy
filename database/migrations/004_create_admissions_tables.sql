-- Applications Table (Student Applications for Programs)
CREATE TABLE IF NOT EXISTS applications (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    uuid CHAR(36) NOT NULL UNIQUE DEFAULT (UUID()),
    user_id INT UNSIGNED NOT NULL,
    program_id INT UNSIGNED NOT NULL COMMENT 'Course/Program they are applying for',
    
    -- Application Details
    motivation TEXT NULL COMMENT 'Why they want to join this program',
    educational_background TEXT NULL COMMENT 'Previous education and experience',
    employment_status VARCHAR(100) NULL COMMENT 'Student, Employed, Unemployed, etc.',
    goals TEXT NULL COMMENT 'Career goals and expectations',
    referral_source VARCHAR(100) NULL COMMENT 'How they heard about us',
    
    -- Contact & Background
    phone VARCHAR(20) NULL,
    country VARCHAR(100) NULL,
    city VARCHAR(100) NULL,
    
    -- Document Uploads (Optional)
    id_document_path VARCHAR(255) NULL,
    transcript_path VARCHAR(255) NULL,
    resume_path VARCHAR(255) NULL,
    
    -- Application Status
    status ENUM('pending', 'under_review', 'approved', 'rejected', 'waitlisted') DEFAULT 'pending',
    priority ENUM('low', 'normal', 'high', 'urgent') DEFAULT 'normal',
    
    -- Review Details
    reviewed_by INT UNSIGNED NULL COMMENT 'Admin/facilitator who reviewed',
    reviewed_at TIMESTAMP NULL,
    review_notes TEXT NULL COMMENT 'Internal notes from reviewer',
    rejection_reason TEXT NULL COMMENT 'Reason for rejection (sent to applicant)',
    
    -- Enrollment Details (After Approval)
    enrolled_at TIMESTAMP NULL,
    cohort_id INT UNSIGNED NULL,
    assigned_facilitator INT UNSIGNED NULL,
    
    -- Timestamps
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    -- Foreign Keys
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (program_id) REFERENCES courses(id) ON DELETE CASCADE,
    FOREIGN KEY (reviewed_by) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (cohort_id) REFERENCES cohorts(id) ON DELETE SET NULL,
    FOREIGN KEY (assigned_facilitator) REFERENCES users(id) ON DELETE SET NULL,
    
    -- Indexes
    INDEX idx_user_id (user_id),
    INDEX idx_program_id (program_id),
    INDEX idx_status (status),
    INDEX idx_priority (priority),
    INDEX idx_submitted_at (submitted_at),
    INDEX idx_reviewed_by (reviewed_by),
    INDEX idx_cohort_id (cohort_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Alter existing cohorts table to add missing columns
ALTER TABLE cohorts 
    ADD COLUMN IF NOT EXISTS uuid CHAR(36) DEFAULT (UUID()) AFTER id,
    ADD COLUMN IF NOT EXISTS code VARCHAR(50) UNIQUE AFTER uuid,
    ADD COLUMN IF NOT EXISTS program_id INT UNSIGNED AFTER code,
    ADD COLUMN IF NOT EXISTS enrollment_deadline DATE NULL AFTER end_date,
    ADD COLUMN IF NOT EXISTS current_students INT UNSIGNED DEFAULT 0 AFTER max_students,
    ADD COLUMN IF NOT EXISTS lead_facilitator INT UNSIGNED NULL AFTER current_students,
    ADD COLUMN IF NOT EXISTS assistant_facilitators JSON NULL AFTER lead_facilitator,
    ADD COLUMN IF NOT EXISTS description TEXT NULL AFTER status,
    ADD COLUMN IF NOT EXISTS schedule VARCHAR(255) NULL AFTER description,
    MODIFY COLUMN status ENUM('upcoming', 'active', 'completed', 'cancelled') DEFAULT 'upcoming';

-- Add foreign keys if they don't exist
ALTER TABLE cohorts 
    ADD INDEX IF NOT EXISTS idx_program_id (program_id),
    ADD INDEX IF NOT EXISTS idx_code (code);

-- Alter cohort_assignments to add missing columns
ALTER TABLE cohort_assignments 
    ADD COLUMN IF NOT EXISTS status ENUM('active', 'completed', 'dropped', 'transferred') DEFAULT 'active' AFTER assigned_at,
    ADD COLUMN IF NOT EXISTS completion_percentage DECIMAL(5,2) DEFAULT 0.00 AFTER status,
    ADD COLUMN IF NOT EXISTS last_activity_at TIMESTAMP NULL AFTER completion_percentage,
    ADD COLUMN IF NOT EXISTS created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP AFTER last_activity_at,
    ADD COLUMN IF NOT EXISTS updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP AFTER created_at;

-- Application Timeline (Activity Log for Each Application)
CREATE TABLE IF NOT EXISTS application_timeline (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    application_id INT UNSIGNED NOT NULL,
    
    -- Event Details
    event_type VARCHAR(100) NOT NULL COMMENT 'submitted, reviewed, approved, rejected, waitlisted, enrolled, etc.',
    description TEXT NULL,
    
    -- Who Did It
    actor_id INT UNSIGNED NULL COMMENT 'User who triggered this event',
    actor_role VARCHAR(50) NULL COMMENT 'student, admin, facilitator, system',
    
    -- Additional Data
    metadata JSON NULL COMMENT 'Additional event data',
    
    -- Timestamp
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    -- Foreign Keys
    FOREIGN KEY (application_id) REFERENCES applications(id) ON DELETE CASCADE,
    FOREIGN KEY (actor_id) REFERENCES users(id) ON DELETE SET NULL,
    
    -- Indexes
    INDEX idx_application_id (application_id),
    INDEX idx_event_type (event_type),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Update existing cohorts with codes if they don't have them
UPDATE cohorts 
SET code = CONCAT('COH-', YEAR(start_date), '-', LPAD(id, 4, '0'))
WHERE code IS NULL OR code = '';

-- Insert Sample Cohorts for Testing (only if they don't exist)
INSERT INTO cohorts (name, code, program_id, start_date, end_date, enrollment_deadline, max_students, status, description, schedule, lead_facilitator) 
SELECT 
    'Frontend Development - January 2025',
    'FE-JAN-2025',
    c.id,
    '2025-01-15',
    '2025-04-15',
    '2025-01-10',
    30,
    'upcoming',
    'Complete frontend development bootcamp covering HTML, CSS, JavaScript, and modern frameworks.',
    'Monday-Wednesday-Friday, 6:00 PM - 8:00 PM (WAT)',
    (SELECT id FROM users WHERE role = 'facilitator' LIMIT 1)
FROM courses c
WHERE c.slug = 'frontend-development-fundamentals' 
  AND NOT EXISTS (SELECT 1 FROM cohorts WHERE code = 'FE-JAN-2025')
LIMIT 1;

INSERT INTO cohorts (name, code, program_id, start_date, end_date, enrollment_deadline, max_students, status, description, schedule, lead_facilitator)
SELECT 
    'Frontend Development - March 2025',
    'FE-MAR-2025',
    c.id,
    '2025-03-01',
    '2025-06-01',
    '2025-02-25',
    30,
    'upcoming',
    'Complete frontend development bootcamp covering HTML, CSS, JavaScript, and modern frameworks.',
    'Tuesday-Thursday, 7:00 PM - 9:00 PM (WAT)',
    (SELECT id FROM users WHERE role = 'facilitator' LIMIT 1)
FROM courses c
WHERE c.slug = 'frontend-development-fundamentals'
  AND NOT EXISTS (SELECT 1 FROM cohorts WHERE code = 'FE-MAR-2025')
LIMIT 1;
