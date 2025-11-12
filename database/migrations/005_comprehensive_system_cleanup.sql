-- =====================================================
-- COMPREHENSIVE SYSTEM CLEANUP MIGRATION
-- Removes redundancies and standardizes schema
-- =====================================================

-- Create missing category tables
-- =====================================================

-- Blog categories table
CREATE TABLE `blog_categories` (
    `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL,
    `slug` varchar(255) NOT NULL,
    `description` text DEFAULT NULL,
    `color` varchar(50) DEFAULT NULL,
    `sort_order` int(11) DEFAULT 0,
    `is_active` tinyint(1) DEFAULT 1,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (`id`),
    UNIQUE KEY `slug` (`slug`),
    KEY `idx_active` (`is_active`),
    KEY `idx_sort` (`sort_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Project categories table
CREATE TABLE `project_categories` (
    `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL,
    `slug` varchar(255) NOT NULL,
    `description` text DEFAULT NULL,
    `color` varchar(50) DEFAULT NULL,
    `sort_order` int(11) DEFAULT 0,
    `is_active` tinyint(1) DEFAULT 1,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (`id`),
    UNIQUE KEY `slug` (`slug`),
    KEY `idx_active` (`is_active`),
    KEY `idx_sort` (`sort_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data migration: Create default categories
-- =====================================================

-- Insert default blog categories
INSERT INTO `blog_categories` (`name`, `slug`, `description`, `color`, `sort_order`) VALUES
('Technology', 'technology', 'Technology and innovation articles', '#3B82F6', 1),
('AI & Machine Learning', 'ai-ml', 'Artificial Intelligence and Machine Learning content', '#8B5CF6', 2),
('Software Development', 'development', 'Programming and software development', '#10B981', 3),
('Design', 'design', 'UI/UX and graphic design', '#F59E0B', 4),
('Career', 'career', 'Career development and opportunities', '#EF4444', 5),
('News', 'news', 'Company and industry news', '#6B7280', 6);

-- Insert default project categories  
INSERT INTO `project_categories` (`name`, `slug`, `description`, `color`, `sort_order`) VALUES
('Web Development', 'web-development', 'Web applications and websites', '#3B82F6', 1),
('Mobile Apps', 'mobile-apps', 'iOS and Android applications', '#8B5CF6', 2),
('AI Solutions', 'ai-solutions', 'Artificial Intelligence projects', '#10B981', 3),
('E-commerce', 'e-commerce', 'Online stores and marketplaces', '#F59E0B', 4),
('Enterprise Software', 'enterprise-software', 'Business and enterprise solutions', '#EF4444', 5),
('Consulting', 'consulting', 'Strategy and consulting projects', '#6B7280', 6);

-- Migrate existing category data
-- =====================================================

-- Add category_id columns
ALTER TABLE `blog_posts` ADD COLUMN `category_id` int(10) UNSIGNED DEFAULT NULL AFTER `category`;
ALTER TABLE `projects` ADD COLUMN `category_id` int(10) UNSIGNED DEFAULT NULL AFTER `category`;

-- Migrate blog post categories
UPDATE `blog_posts` bp 
JOIN `blog_categories` bc ON (
    LOWER(bp.category) = bc.slug OR 
    LOWER(bp.category) = LOWER(bc.name) OR
    (bp.category = 'tech' AND bc.slug = 'technology') OR
    (bp.category = 'ai' AND bc.slug = 'ai-ml') OR
    (bp.category = 'dev' AND bc.slug = 'development')
)
SET bp.category_id = bc.id
WHERE bp.category IS NOT NULL;

-- Set default category for unmapped blog posts
UPDATE `blog_posts` 
SET category_id = (SELECT id FROM blog_categories WHERE slug = 'technology' LIMIT 1)
WHERE category_id IS NULL AND category IS NOT NULL;

-- Migrate project categories
UPDATE `projects` p 
JOIN `project_categories` pc ON (
    LOWER(p.category) = pc.slug OR 
    LOWER(p.category) = LOWER(pc.name) OR
    (p.category = 'web' AND pc.slug = 'web-development') OR
    (p.category = 'mobile' AND pc.slug = 'mobile-apps') OR
    (p.category = 'ai' AND pc.slug = 'ai-solutions')
)
SET p.category_id = pc.id
WHERE p.category IS NOT NULL;

-- Set default category for unmapped projects
UPDATE `projects` 
SET category_id = (SELECT id FROM project_categories WHERE slug = 'web-development' LIMIT 1)
WHERE category_id IS NULL AND category IS NOT NULL;

-- Remove redundant fields
-- =====================================================

-- Remove duplicate contact_messages table (merge data first if needed)
INSERT INTO `contacts` (
    `uuid`, `name`, `email`, `phone`, `subject`, `message`, 
    `status`, `replied_at`, `created_at`
)
SELECT 
    `uuid`, `name`, `email`, `phone`, `subject`, `message`,
    `status`, `replied_at`, `created_at`
FROM `contact_messages`
WHERE NOT EXISTS (
    SELECT 1 FROM `contacts` c 
    WHERE c.email = contact_messages.email 
    AND c.created_at = contact_messages.created_at
);

DROP TABLE IF EXISTS `contact_messages`;

-- Remove redundant category varchar fields
ALTER TABLE `courses` DROP COLUMN `category`;
ALTER TABLE `blog_posts` DROP COLUMN `category`;  
ALTER TABLE `projects` DROP COLUMN `category`;

-- Remove redundant is_active from services (keep status enum)
ALTER TABLE `services` DROP COLUMN `is_active`;

-- Standardize UUID fields to char(36)
-- =====================================================
ALTER TABLE `blog_posts` MODIFY `uuid` char(36) NOT NULL;
ALTER TABLE `projects` MODIFY `uuid` char(36) NOT NULL;
ALTER TABLE `services` MODIFY `uuid` char(36) NOT NULL;
ALTER TABLE `testimonials` MODIFY `uuid` char(36) NOT NULL;
ALTER TABLE `service_requests` MODIFY `uuid` char(36) NOT NULL;

-- Add foreign key constraints
-- =====================================================
ALTER TABLE `courses` ADD CONSTRAINT `fk_courses_category` 
    FOREIGN KEY (`category_id`) REFERENCES `course_categories` (`id`) ON DELETE SET NULL;

ALTER TABLE `blog_posts` ADD CONSTRAINT `fk_blog_posts_category` 
    FOREIGN KEY (`category_id`) REFERENCES `blog_categories` (`id`) ON DELETE SET NULL;

ALTER TABLE `projects` ADD CONSTRAINT `fk_projects_category` 
    FOREIGN KEY (`category_id`) REFERENCES `project_categories` (`id`) ON DELETE SET NULL;

ALTER TABLE `services` ADD CONSTRAINT `fk_services_category` 
    FOREIGN KEY (`category_id`) REFERENCES `service_categories` (`id`) ON DELETE SET NULL;

-- Add indexes for performance
-- =====================================================
ALTER TABLE `blog_posts` ADD KEY `idx_category_id` (`category_id`);
ALTER TABLE `projects` ADD KEY `idx_category_id` (`category_id`);

-- Standardize naming conventions
-- =====================================================

-- Rename inconsistent boolean fields to is_* pattern
ALTER TABLE `portfolios` CHANGE `featured` `is_featured` tinyint(1) DEFAULT 0;

-- Update cross_promotions uuid field (missing from original schema)
ALTER TABLE `cross_promotions` ADD COLUMN `uuid` char(36) NOT NULL AFTER `id`;
UPDATE `cross_promotions` SET `uuid` = UUID() WHERE `uuid` = '';
ALTER TABLE `cross_promotions` ADD UNIQUE KEY `uuid` (`uuid`);

-- Clean up view definitions (remove incorrect table definitions)
-- =====================================================
-- These are handled by the view definitions at the end of schema.sql
-- Just ensure they're properly defined as views, not tables

-- Final data integrity checks
-- =====================================================

-- Ensure all courses have valid category_id
UPDATE `courses` 
SET category_id = (SELECT id FROM course_categories WHERE slug = 'ai-ml' LIMIT 1)
WHERE category_id IS NULL;

-- Ensure all services have valid category_id  
UPDATE `services` 
SET category_id = (SELECT id FROM service_categories WHERE slug = 'development' LIMIT 1)
WHERE category_id IS NULL;

-- Update any remaining NULL UUIDs
UPDATE `cross_promotions` SET `uuid` = UUID() WHERE `uuid` IS NULL OR `uuid` = '';
UPDATE `blog_categories` SET `uuid` = UUID() WHERE `uuid` IS NULL OR `uuid` = '';
UPDATE `project_categories` SET `uuid` = UUID() WHERE `uuid` IS NULL OR `uuid` = '';

COMMIT;
