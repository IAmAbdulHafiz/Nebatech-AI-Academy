SET NAMES utf8mb4;
SET CHARACTER SET utf8mb4;

UPDATE discussion_categories SET icon = '💬' WHERE slug = 'general';
UPDATE discussion_categories SET icon = '❓' WHERE slug = 'qa';
UPDATE discussion_categories SET icon = '💼' WHERE slug = 'career-jobs';
UPDATE discussion_categories SET icon = '🚀' WHERE slug = 'projects-showcase';
UPDATE discussion_categories SET icon = '📚' WHERE slug = 'resources';
UPDATE discussion_categories SET icon = '📢' WHERE slug = 'announcements';

SELECT slug, name, icon FROM discussion_categories ORDER BY order_index;
