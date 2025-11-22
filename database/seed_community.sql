-- ============================================================================
-- Community Platform Seed Data
-- Initial categories, badges, and default settings
-- ============================================================================

SET NAMES utf8mb4;
SET CHARACTER SET utf8mb4;

-- Delete existing data (in reverse order of foreign keys)
DELETE FROM discussion_categories;
DELETE FROM badges;

-- Insert Default Discussion Categories
INSERT INTO discussion_categories (name, slug, description, icon, color, order_index) VALUES
('General', 'general', 'General discussions about technology, learning, and community', '💬', 'blue', 1),
('Q&A', 'qa', 'Ask questions and get help from the community', '❓', 'purple', 2),
('Career & Jobs', 'career-jobs', 'Career advice, job opportunities, and professional growth', '💼', 'green', 3),
('Projects Showcase', 'projects-showcase', 'Share your projects and get feedback', '🚀', 'orange', 4),
('Resources', 'resources', 'Share useful learning resources, tools, and tutorials', '📚', 'indigo', 5),
('Announcements', 'announcements', 'Official announcements and updates', '📢', 'red', 6);

-- Insert Badges
INSERT INTO badges (name, slug, description, icon, color, type, xp_value, criteria) VALUES
-- Participation Badges
('New Member', 'new-member', 'Welcome to Nebatech AI Academy!', '👋', 'gray', 'participation', 10, '{"action": "signup", "count": 1}'),
('Active Learner', 'active-learner', 'Posted or commented 5 times', '🎓', 'blue', 'participation', 50, '{"action": "post_or_comment", "count": 5}'),
('Discussion Starter', 'discussion-starter', 'Created 10 discussion posts', '💬', 'purple', 'participation', 100, '{"action": "create_post", "count": 10}'),
('Helpful Peer', 'helpful-peer', 'Your answer was marked as solution 5 times', '✅', 'green', 'participation', 150, '{"action": "solution_marked", "count": 5}'),
('Community Champion', 'community-champion', 'Earned 1000 XP points', '🏆', 'gold', 'achievement', 200, '{"xp_threshold": 1000}'),

-- Achievement Badges
('First Post', 'first-post', 'Created your first discussion post', '🎯', 'blue', 'achievement', 20, '{"action": "create_post", "count": 1}'),
('First Comment', 'first-comment', 'Posted your first comment', '💭', 'blue', 'achievement', 10, '{"action": "create_comment", "count": 1}'),
('Early Bird', 'early-bird', 'Logged in before 7am (Ghana time)', '🌅', 'orange', 'achievement', 25, '{"login_time_before": "07:00"}'),
('Night Owl', 'night-owl', 'Active after 11pm (Ghana time)', '🦉', 'purple', 'achievement', 25, '{"active_time_after": "23:00"}'),
('7-Day Streak', '7-day-streak', 'Visited the platform 7 days in a row', '🔥', 'red', 'achievement', 100, '{"streak_days": 7}'),
('30-Day Streak', '30-day-streak', 'Visited the platform 30 days in a row', '⭐', 'gold', 'achievement', 500, '{"streak_days": 30}'),

-- Skill Badges
('Code Master', 'code-master', 'Completed 5 programming courses', '👨‍💻', 'green', 'skill', 150, '{"courses_completed_category": "programming", "count": 5}'),
('Data Scientist', 'data-scientist', 'Completed 3 data science courses', '📊', 'blue', 'skill', 150, '{"courses_completed_category": "data-science", "count": 3}'),
('AI Enthusiast', 'ai-enthusiast', 'Completed 3 AI/ML courses', '🤖', 'purple', 'skill', 150, '{"courses_completed_category": "ai-ml", "count": 3}'),
('Web Developer', 'web-developer', 'Completed 5 web development courses', '🌐', 'indigo', 'skill', 150, '{"courses_completed_category": "web-development", "count": 5}'),

-- Special Badges
('Founding Member', 'founding-member', 'One of the first 100 members', '👑', 'gold', 'special', 500, '{"user_id_less_than": 101}'),
('Beta Tester', 'beta-tester', 'Helped test new features', '🧪', 'pink', 'special', 100, '{"manual_award": true}'),
('Bug Hunter', 'bug-hunter', 'Reported 5 valid bugs', '🐛', 'red', 'special', 150, '{"bugs_reported": 5}'),
('Content Creator', 'content-creator', 'Created 10 high-quality resources', '✍️', 'orange', 'special', 200, '{"resources_created_approved": 10}'),
('Event Organizer', 'event-organizer', 'Organized 3 community events', '📅', 'purple', 'special', 150, '{"events_organized": 3}'),
('Mentor', 'mentor', 'Helped 10 different students', '👨‍🏫', 'blue', 'special', 300, '{"students_helped": 10}');

-- Create initial XP rules (stored as reference in documentation)
-- Post creation: +10 XP
-- Comment creation: +5 XP
-- Solution marked: +20 XP
-- Like received: +2 XP
-- Resource uploaded: +15 XP
-- Event RSVP: +5 XP
-- Event attendance: +10 XP
-- Course completion: +100 XP
-- Daily login: +5 XP
-- 7-day streak bonus: +50 XP

