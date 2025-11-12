-- =====================================================
-- COURSE CATEGORIES SEEDER
-- Populates course_categories table with existing categories
-- =====================================================

-- Insert course categories that match existing hardcoded values
INSERT INTO `course_categories` (`name`, `slug`, `description`, `icon`, `color`, `sort_order`, `is_active`) VALUES
('Frontend Development', 'frontend', 'User interface and client-side development', 'code', '#3B82F6', 1, 1),
('Backend Development', 'backend', 'Server-side development and APIs', 'server', '#10B981', 2, 1),
('Full Stack Development', 'fullstack', 'Complete web application development', 'layers', '#8B5CF6', 3, 1),
('Mobile Development', 'mobile', 'iOS and Android application development', 'smartphone', '#F59E0B', 4, 1),
('AI & Machine Learning', 'ai', 'Artificial Intelligence and Machine Learning', 'brain', '#EF4444', 5, 1),
('Data Science', 'data-science', 'Data analysis and visualization', 'bar-chart', '#06B6D4', 6, 1),
('Cybersecurity', 'cybersecurity', 'Information security and ethical hacking', 'shield', '#DC2626', 7, 1),
('Cloud Computing', 'cloud', 'Cloud platforms and infrastructure', 'cloud', '#7C3AED', 8, 1),
('Database Administration', 'database', 'Database design and management', 'database', '#059669', 9, 1),
('Digital Literacy', 'digital-literacy', 'Basic computer and digital skills', 'monitor', '#6B7280', 10, 1);

-- Update existing courses to use category_id based on their current category values
UPDATE `courses` c 
JOIN `course_categories` cc ON c.category = cc.slug 
SET c.category_id = cc.id 
WHERE c.category IS NOT NULL;

-- Set default category for any courses without a matching category
UPDATE `courses` 
SET category_id = (SELECT id FROM course_categories WHERE slug = 'fullstack' LIMIT 1)
WHERE category_id IS NULL AND category IS NOT NULL;

COMMIT;
