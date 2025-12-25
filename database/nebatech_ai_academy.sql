-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 25, 2025 at 01:13 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nebatech_ai_academy`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `action` varchar(100) NOT NULL,
  `entity_type` varchar(50) DEFAULT NULL,
  `entity_id` int(10) UNSIGNED DEFAULT NULL,
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`metadata`)),
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_action_logs`
--

CREATE TABLE `admin_action_logs` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `action` varchar(100) NOT NULL,
  `resource_type` varchar(50) DEFAULT NULL,
  `resource_id` int(10) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` varchar(500) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ai_code_reviews`
--

CREATE TABLE `ai_code_reviews` (
  `id` int(10) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `lesson_id` int(10) UNSIGNED DEFAULT NULL,
  `assignment_id` int(10) UNSIGNED DEFAULT NULL,
  `language` varchar(50) NOT NULL,
  `original_code` text NOT NULL,
  `reviewed_code` text DEFAULT NULL,
  `feedback` text NOT NULL,
  `score` decimal(5,2) DEFAULT NULL,
  `issues_found` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`issues_found`)),
  `improvements` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`improvements`)),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ai_content_embeddings`
--

CREATE TABLE `ai_content_embeddings` (
  `id` int(10) UNSIGNED NOT NULL,
  `content_type` enum('lesson','module','course','assignment','faq') NOT NULL,
  `content_id` int(10) UNSIGNED NOT NULL,
  `chunk_index` int(10) UNSIGNED DEFAULT 0,
  `content_text` text NOT NULL,
  `embedding` blob DEFAULT NULL,
  `embedding_model` varchar(50) DEFAULT 'text-embedding-3-small',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ai_conversations`
--

CREATE TABLE `ai_conversations` (
  `id` int(10) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `lesson_id` int(10) UNSIGNED DEFAULT NULL,
  `course_id` int(10) UNSIGNED DEFAULT NULL,
  `module_id` int(10) UNSIGNED DEFAULT NULL,
  `session_type` enum('lesson_help','code_review','practice','general') DEFAULT 'general',
  `title` varchar(255) DEFAULT NULL,
  `status` enum('active','ended','archived') DEFAULT 'active',
  `total_tokens` int(10) UNSIGNED DEFAULT 0,
  `message_count` int(10) UNSIGNED DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ended_at` timestamp NULL DEFAULT NULL,
  `summary` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ai_faq_cache`
--

CREATE TABLE `ai_faq_cache` (
  `id` int(10) UNSIGNED NOT NULL,
  `question_hash` varchar(64) NOT NULL,
  `question` text NOT NULL,
  `answer` text NOT NULL,
  `lesson_id` int(10) UNSIGNED DEFAULT NULL,
  `course_id` int(10) UNSIGNED DEFAULT NULL,
  `hit_count` int(10) UNSIGNED DEFAULT 1,
  `last_used_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `expires_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ai_learning_profiles`
--

CREATE TABLE `ai_learning_profiles` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `learning_style` enum('visual','reading','kinesthetic','mixed') DEFAULT 'mixed',
  `preferred_explanation_style` enum('detailed','concise','examples','analogies') DEFAULT 'examples',
  `average_session_length_minutes` int(10) UNSIGNED DEFAULT 30,
  `preferred_difficulty` enum('easy','medium','hard','adaptive') DEFAULT 'adaptive',
  `strengths` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`strengths`)),
  `weaknesses` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`weaknesses`)),
  `topics_mastered` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`topics_mastered`)),
  `topics_struggling` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`topics_struggling`)),
  `total_ai_interactions` int(10) UNSIGNED DEFAULT 0,
  `total_practice_completed` int(10) UNSIGNED DEFAULT 0,
  `average_practice_score` decimal(5,2) DEFAULT 0.00,
  `last_interaction_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ai_messages`
--

CREATE TABLE `ai_messages` (
  `id` int(10) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `conversation_id` int(10) UNSIGNED NOT NULL,
  `role` enum('user','assistant','system') NOT NULL,
  `content` text NOT NULL,
  `tokens_used` int(10) UNSIGNED DEFAULT 0,
  `model` varchar(50) DEFAULT 'gpt-4-turbo-preview',
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`metadata`)),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ai_practice_problems`
--

CREATE TABLE `ai_practice_problems` (
  `id` int(10) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `lesson_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `problem_type` enum('multiple_choice','coding','fill_blank','conceptual','debugging') NOT NULL,
  `difficulty` enum('easy','medium','hard') DEFAULT 'medium',
  `language` varchar(50) DEFAULT NULL,
  `problem_content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`problem_content`)),
  `expected_output` text DEFAULT NULL,
  `user_answer` text DEFAULT NULL,
  `ai_feedback` text DEFAULT NULL,
  `score` decimal(5,2) DEFAULT NULL,
  `is_correct` tinyint(1) DEFAULT NULL,
  `time_spent_seconds` int(10) UNSIGNED DEFAULT 0,
  `attempts` int(10) UNSIGNED DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `answered_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ai_tutor_conversations`
--

CREATE TABLE `ai_tutor_conversations` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `session_id` varchar(100) NOT NULL,
  `lesson_id` int(11) DEFAULT NULL,
  `practical_id` int(11) DEFAULT NULL,
  `quiz_id` int(11) DEFAULT NULL,
  `context_type` enum('general','lesson_help','practical_hint','code_review','quiz_explanation','competency_coaching') DEFAULT 'general',
  `messages` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`messages`)),
  `ai_model` varchar(50) DEFAULT 'gpt-4',
  `tokens_used` int(11) DEFAULT 0,
  `feedback_rating` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ai_tutor_hints`
--

CREATE TABLE `ai_tutor_hints` (
  `id` int(11) NOT NULL,
  `practical_id` int(11) NOT NULL,
  `hint_level` int(11) NOT NULL DEFAULT 1,
  `hint_text` text NOT NULL,
  `reveals_solution` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ai_usage_logs`
--

CREATE TABLE `ai_usage_logs` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `request_count` int(10) UNSIGNED DEFAULT 0,
  `tokens_used` int(10) UNSIGNED DEFAULT 0,
  `estimated_cost` decimal(10,4) DEFAULT 0.0000
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `id` int(10) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `program` varchar(100) NOT NULL,
  `educational_background` text NOT NULL,
  `motivation_statement` text NOT NULL,
  `referral_source` varchar(100) DEFAULT NULL,
  `document_path` varchar(255) DEFAULT NULL,
  `status` enum('pending','approved','rejected','info_requested') DEFAULT 'pending',
  `admin_notes` text DEFAULT NULL,
  `reviewed_by` int(10) UNSIGNED DEFAULT NULL,
  `reviewed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`id`, `uuid`, `user_id`, `first_name`, `last_name`, `email`, `phone`, `country`, `program`, `educational_background`, `motivation_statement`, `referral_source`, `document_path`, `status`, `admin_notes`, `reviewed_by`, `reviewed_at`, `created_at`, `updated_at`) VALUES
(1, 'f6256372-9db7-4e57-9bf4-4235473e2fe0', 10, 'Facilitator', 'Facilitator', 'student@gmail.com', NULL, NULL, 'introduction-to-ai', 'Greatnothingnothingnothingnothingnothingnothing to have', 'nothingnothingnothingnothingnothingnothingnothingnothingnothingnothingnothingnothingnothingnothingnothing', 'Social Media', '/storage/uploads/applications/app_10_1762963994.png', 'approved', NULL, 11, '2025-11-12 17:15:06', '2025-11-12 16:13:14', '2025-11-12 16:15:06');

-- --------------------------------------------------------

--
-- Table structure for table `application_notes`
--

CREATE TABLE `application_notes` (
  `id` int(10) UNSIGNED NOT NULL,
  `application_id` int(10) UNSIGNED NOT NULL,
  `notes` longtext DEFAULT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `application_timeline`
--

CREATE TABLE `application_timeline` (
  `id` int(10) UNSIGNED NOT NULL,
  `application_id` int(10) UNSIGNED NOT NULL,
  `event_type` varchar(100) NOT NULL COMMENT 'submitted, reviewed, approved, rejected, waitlisted, enrolled, etc.',
  `description` text DEFAULT NULL,
  `actor_id` int(10) UNSIGNED DEFAULT NULL COMMENT 'User who triggered this event',
  `actor_role` varchar(50) DEFAULT NULL COMMENT 'student, admin, facilitator, system',
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Additional event data' CHECK (json_valid(`metadata`)),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `approval_history`
--

CREATE TABLE `approval_history` (
  `id` int(10) UNSIGNED NOT NULL,
  `entity_type` enum('course','cohort') NOT NULL,
  `entity_id` int(10) UNSIGNED NOT NULL,
  `action` enum('submitted','approved','rejected','resubmitted') NOT NULL,
  `admin_id` int(10) UNSIGNED DEFAULT NULL,
  `reason` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assignments`
--

CREATE TABLE `assignments` (
  `id` int(10) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `lesson_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `instructions` longtext DEFAULT NULL,
  `rubric` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`rubric`)),
  `max_score` int(10) UNSIGNED DEFAULT 100,
  `ai_feedback_enabled` tinyint(1) DEFAULT 1,
  `due_date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `badges`
--

CREATE TABLE `badges` (
  `id` char(36) NOT NULL DEFAULT uuid(),
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `icon` varchar(255) DEFAULT NULL COMMENT 'Font Awesome icon class or image path',
  `category` enum('course_completion','assignment_quality','streak','special') NOT NULL,
  `criteria` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL COMMENT 'Requirements to earn badge' CHECK (json_valid(`criteria`)),
  `points` int(10) UNSIGNED DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blog_categories`
--

CREATE TABLE `blog_categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `color` varchar(50) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blog_categories`
--

INSERT INTO `blog_categories` (`id`, `name`, `slug`, `description`, `color`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Technology', 'technology', 'Technology and innovation articles', '#3B82F6', 1, 1, '2025-11-12 14:42:44', '2025-11-12 14:42:44'),
(2, 'AI & Machine Learning', 'ai-ml', 'Artificial Intelligence and Machine Learning content', '#8B5CF6', 2, 1, '2025-11-12 14:42:44', '2025-11-12 14:42:44'),
(3, 'Software Development', 'development', 'Programming and software development', '#10B981', 3, 1, '2025-11-12 14:42:44', '2025-11-12 14:42:44'),
(4, 'Design', 'design', 'UI/UX and graphic design', '#F59E0B', 4, 1, '2025-11-12 14:42:44', '2025-11-12 14:42:44'),
(5, 'Career', 'career', 'Career development and opportunities', '#EF4444', 5, 1, '2025-11-12 14:42:44', '2025-11-12 14:42:44'),
(6, 'News', 'news', 'Company and industry news', '#6B7280', 6, 1, '2025-11-12 14:42:44', '2025-11-12 14:42:44');

-- --------------------------------------------------------

--
-- Table structure for table `blog_comments`
--

CREATE TABLE `blog_comments` (
  `id` int(10) UNSIGNED NOT NULL,
  `post_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `parent_id` int(10) UNSIGNED DEFAULT NULL COMMENT 'For nested replies',
  `content` text NOT NULL,
  `status` enum('pending','approved','spam','deleted') DEFAULT 'approved',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blog_likes`
--

CREATE TABLE `blog_likes` (
  `id` int(10) UNSIGNED NOT NULL,
  `post_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blog_posts`
--

CREATE TABLE `blog_posts` (
  `id` int(10) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `excerpt` text DEFAULT NULL,
  `content` text DEFAULT NULL,
  `featured_image` varchar(255) DEFAULT NULL,
  `author_id` int(10) UNSIGNED DEFAULT NULL,
  `category_id` int(10) UNSIGNED DEFAULT NULL,
  `tags` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`tags`)),
  `status` enum('draft','published','archived') DEFAULT 'draft',
  `published_at` timestamp NULL DEFAULT NULL,
  `views` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `icon`, `created_at`) VALUES
(1, 'Artificial Intelligence', 'ai', 'AI and Machine Learning courses', NULL, '2025-12-20 07:17:04'),
(2, 'Web Development', 'web-dev', 'Web development and programming', NULL, '2025-12-20 07:17:04'),
(3, 'Data Science', 'data-science', 'Data analysis and visualization', NULL, '2025-12-20 07:17:04'),
(4, 'Cloud Computing', 'cloud', 'Cloud platforms and services', NULL, '2025-12-20 07:17:04'),
(5, 'Cybersecurity', 'security', 'Security and ethical hacking', NULL, '2025-12-20 07:17:04'),
(6, 'Mobile Development', 'mobile', 'iOS and Android development', NULL, '2025-12-20 07:17:04');

-- --------------------------------------------------------

--
-- Table structure for table `certificates`
--

CREATE TABLE `certificates` (
  `id` int(10) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `course_id` int(10) UNSIGNED NOT NULL,
  `certificate_number` varchar(100) NOT NULL,
  `issued_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `verified` tinyint(1) DEFAULT 0,
  `verification_url` varchar(255) DEFAULT NULL,
  `revoked_at` timestamp NULL DEFAULT NULL,
  `revoked_by` int(10) UNSIGNED DEFAULT NULL,
  `revocation_reason` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cohorts`
--

CREATE TABLE `cohorts` (
  `id` int(10) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `name` varchar(255) NOT NULL,
  `program` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `facilitator_id` int(10) UNSIGNED DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `max_students` int(10) UNSIGNED DEFAULT 30,
  `status` enum('upcoming','active','completed') DEFAULT 'upcoming',
  `approval_status` enum('draft','pending_approval','approved','rejected') DEFAULT 'draft',
  `rejection_reason` text DEFAULT NULL,
  `approved_by` int(10) UNSIGNED DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `course_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cohort_assignments`
--

CREATE TABLE `cohort_assignments` (
  `id` int(10) UNSIGNED NOT NULL,
  `cohort_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `assigned_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cohort_assignment_deadlines`
--

CREATE TABLE `cohort_assignment_deadlines` (
  `id` int(10) UNSIGNED NOT NULL,
  `cohort_id` int(10) UNSIGNED NOT NULL,
  `assignment_id` int(10) UNSIGNED NOT NULL,
  `due_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cohort_courses`
--

CREATE TABLE `cohort_courses` (
  `id` int(10) UNSIGNED NOT NULL,
  `cohort_id` int(10) UNSIGNED NOT NULL,
  `course_id` int(10) UNSIGNED NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `order_index` int(10) UNSIGNED DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cohort_invitations`
--

CREATE TABLE `cohort_invitations` (
  `id` int(10) UNSIGNED NOT NULL,
  `cohort_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `invited_by` int(10) UNSIGNED NOT NULL,
  `status` enum('pending','accepted','declined') DEFAULT 'pending',
  `message` text DEFAULT NULL,
  `invited_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `responded_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cohort_schedules`
--

CREATE TABLE `cohort_schedules` (
  `id` int(10) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `cohort_id` int(10) UNSIGNED NOT NULL,
  `course_id` int(10) UNSIGNED DEFAULT NULL,
  `lesson_id` int(10) UNSIGNED DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `event_type` enum('live_session','workshop','office_hours','project_review','exam','other') DEFAULT 'live_session',
  `scheduled_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `duration_minutes` int(10) UNSIGNED DEFAULT 60,
  `meeting_link` varchar(500) DEFAULT NULL,
  `recording_link` varchar(500) DEFAULT NULL,
  `status` enum('scheduled','in_progress','completed','cancelled') DEFAULT 'scheduled',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `community_events`
--

CREATE TABLE `community_events` (
  `id` int(10) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `organizer_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `type` enum('webinar','workshop','hackathon','meetup','live_session') NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `timezone` varchar(50) DEFAULT 'Africa/Accra',
  `location` varchar(255) DEFAULT NULL,
  `meeting_url` varchar(500) DEFAULT NULL,
  `max_attendees` int(10) UNSIGNED DEFAULT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `tags` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`tags`)),
  `is_featured` tinyint(1) DEFAULT 0,
  `status` enum('upcoming','ongoing','completed','cancelled') DEFAULT 'upcoming',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `community_resources`
--

CREATE TABLE `community_resources` (
  `id` int(10) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `category_id` int(10) UNSIGNED DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `type` enum('file','link','video','article') NOT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `url` varchar(500) DEFAULT NULL,
  `file_size` bigint(20) UNSIGNED DEFAULT NULL,
  `file_type` varchar(100) DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `tags` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`tags`)),
  `downloads_count` int(10) UNSIGNED DEFAULT 0,
  `views_count` int(10) UNSIGNED DEFAULT 0,
  `is_approved` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `competencies`
--

CREATE TABLE `competencies` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `module_id` int(11) DEFAULT NULL,
  `competency_code` varchar(50) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `level` enum('foundational','intermediate','advanced','expert') DEFAULT 'foundational',
  `assessment_criteria` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`assessment_criteria`)),
  `industry_alignment` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(10) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `status` enum('new','read','replied','archived') DEFAULT 'new',
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `replied_at` timestamp NULL DEFAULT NULL,
  `replied_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact_submissions`
--

CREATE TABLE `contact_submissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `status` enum('new','in_progress','resolved','archived') DEFAULT 'new',
  `assigned_to` int(10) UNSIGNED DEFAULT NULL,
  `admin_notes` text DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` varchar(500) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `content_reports`
--

CREATE TABLE `content_reports` (
  `id` int(10) UNSIGNED NOT NULL,
  `reporter_id` int(10) UNSIGNED NOT NULL,
  `reportable_type` enum('post','comment','user','resource') NOT NULL,
  `reportable_id` int(10) UNSIGNED NOT NULL,
  `reason` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `status` enum('pending','reviewed','resolved','dismissed') DEFAULT 'pending',
  `moderator_id` int(10) UNSIGNED DEFAULT NULL,
  `moderator_notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `resolved_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(10) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `learning_objectives` text DEFAULT NULL,
  `technologies` text DEFAULT NULL,
  `skills_gained` text DEFAULT NULL,
  `floating_icons` text DEFAULT NULL,
  `hero_subtitle` varchar(500) DEFAULT NULL,
  `category_id` int(10) UNSIGNED DEFAULT NULL,
  `related_service_id` int(10) UNSIGNED DEFAULT NULL,
  `service_description` text DEFAULT NULL,
  `level` enum('beginner','intermediate','advanced') DEFAULT 'beginner',
  `duration_hours` int(10) UNSIGNED DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `facilitator_id` int(10) UNSIGNED DEFAULT NULL,
  `status` enum('draft','published','archived') DEFAULT 'draft',
  `approval_status` enum('draft','pending_approval','approved','rejected') DEFAULT 'draft',
  `availability` enum('both','cohort_only','self_paced') DEFAULT 'both',
  `is_bundle` tinyint(1) DEFAULT 0,
  `parent_course_id` int(10) UNSIGNED DEFAULT NULL,
  `rejection_reason` text DEFAULT NULL,
  `approved_by` int(10) UNSIGNED DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `ai_generated` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `enrollment_count` int(10) UNSIGNED DEFAULT 0,
  `success_rate` int(11) DEFAULT 95,
  `rating` decimal(3,2) DEFAULT 0.00,
  `card_color_from` varchar(50) DEFAULT 'from-primary',
  `card_color_to` varchar(50) DEFAULT 'to-blue-700',
  `card_modules` int(11) DEFAULT 10,
  `card_features` varchar(255) DEFAULT 'Hands-on Projects',
  `card_duration` varchar(50) DEFAULT NULL,
  `card_icon` varchar(100) DEFAULT 'fas fa-book',
  `instructor_name` varchar(100) DEFAULT 'Nebatech Team',
  `review_count` int(11) DEFAULT 0,
  `is_new` tinyint(1) DEFAULT 0,
  `category` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT 0.00,
  `original_price` decimal(10,2) DEFAULT NULL,
  `facilitator_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `uuid`, `title`, `slug`, `description`, `learning_objectives`, `technologies`, `skills_gained`, `floating_icons`, `hero_subtitle`, `category_id`, `related_service_id`, `service_description`, `level`, `duration_hours`, `thumbnail`, `facilitator_id`, `status`, `approval_status`, `availability`, `is_bundle`, `parent_course_id`, `rejection_reason`, `approved_by`, `approved_at`, `ai_generated`, `created_at`, `updated_at`, `enrollment_count`, `success_rate`, `rating`, `card_color_from`, `card_color_to`, `card_modules`, `card_features`, `card_duration`, `card_icon`, `instructor_name`, `review_count`, `is_new`, `category`, `price`, `original_price`, `facilitator_name`) VALUES
(1, '4bfc78a7-df2e-11f0-8b36-f48e38a80c71', 'Frontend Development', 'frontend', 'Master Frontend Development - Build stunning, responsive user interfaces with HTML, CSS, JavaScript, and modern frameworks like React and Vue. Follow our structured curriculum from beginner to advanced frontend developer. Learn UI/UX Design, Responsive Design, Modern Frameworks (React, Vue, Angular, Next.js), Performance Optimization, Testing, and Version Control. Career outcomes include positions at Tech Giants, Startups, Agencies, or Freelancing with salaries ranging from  to +.', NULL, '[{\"level\":\"beginner\",\"duration\":\"3-6 months\",\"title\":\"Beginner Level\",\"description\":\"Master the fundamentals of web development\",\"skills\":[\"HTML5\",\"CSS3\",\"JavaScript Basics\",\"Responsive Design\",\"Git and GitHub\"]},{\"level\":\"intermediate\",\"duration\":\"4-8 months\",\"title\":\"Intermediate Level\",\"description\":\"Build dynamic applications with modern JavaScript\",\"skills\":[\"ES6+\",\"TypeScript\",\"Tailwind CSS\",\"Sass/SCSS\",\"Webpack\",\"API Integration\"]},{\"level\":\"advanced\",\"duration\":\"6-12 months\",\"title\":\"Advanced Level\",\"description\":\"Master modern frameworks and advanced concepts\",\"skills\":[\"React.js\",\"Vue.js\",\"Angular\",\"Next.js\",\"State Management\",\"Testing\",\"Performance Optimization\"]}]', '[{\"icon\":\"fas fa-paint-brush\",\"title\":\"UI/UX Design\",\"description\":\"Create beautiful, user-friendly interfaces with modern design principles and accessibility standards.\",\"color\":\"blue\"},{\"icon\":\"fas fa-mobile-alt\",\"title\":\"Responsive Design\",\"description\":\"Build websites that work seamlessly across all devices and screen sizes.\",\"color\":\"green\"},{\"icon\":\"fab fa-react\",\"title\":\"Modern Frameworks\",\"description\":\"Master React, Vue, and Angular to build scalable single-page applications.\",\"color\":\"purple\"},{\"icon\":\"fas fa-tachometer-alt\",\"title\":\"Performance\",\"description\":\"Optimize web applications for speed, efficiency, and excellent user experience.\",\"color\":\"yellow\"},{\"icon\":\"fas fa-vial\",\"title\":\"Testing\",\"description\":\"Write unit, integration, and end-to-end tests to ensure code quality.\",\"color\":\"red\"},{\"icon\":\"fas fa-code-branch\",\"title\":\"Version Control\",\"description\":\"Collaborate effectively using Git, GitHub, and modern development workflows.\",\"color\":\"orange\"}]', '[\"fas fa-code\",\"fab fa-react\",\"fab fa-html5\",\"fab fa-css3-alt\"]', 'Build stunning, responsive user interfaces with HTML, CSS, JavaScript, and modern frameworks like React and Vue', NULL, NULL, NULL, 'beginner', 200, NULL, NULL, 'published', 'approved', 'both', 1, NULL, NULL, NULL, NULL, 0, '2025-12-22 12:03:58', '2025-12-22 17:49:31', 4, 95, 4.80, 'from-blue-600', 'to-blue-700', 15, 'React, Vue, JavaScript, Tailwind CSS, Next.js', '12-24 months', 'fas fa-code', 'Nebatech Team', 4, 1, 'Web Development', 3800.00, 7020.00, 'Nebatech Team'),
(2, '18b64b78-df2f-11f0-8b36-f48e38a80c71', 'Backend Development', 'backend', 'Master Backend Development - Build powerful server-side applications, APIs, and databases with PHP, Node.js, Python, and modern backend technologies. Learn Database Design, API Development, Security, Performance Optimization, DevOps, and System Architecture. Technologies covered include PHP, Node.js, Express.js, Laravel, Django, SQL, MySQL, PostgreSQL, MongoDB, Docker, GraphQL, Redis, and Microservices. Career outcomes include positions at Tech Companies, Enterprises, or Freelancing with salaries ranging from  to +.', NULL, '[{\"level\":\"beginner\",\"duration\":\"3-6 months\",\"title\":\"Beginner Level\",\"description\":\"Learn programming fundamentals and web basics\",\"skills\":[\"Python Basics\",\"Node.js\",\"HTTP/REST\",\"SQL Fundamentals\",\"Git\"]},{\"level\":\"intermediate\",\"duration\":\"4-8 months\",\"title\":\"Intermediate Level\",\"description\":\"Build robust server applications\",\"skills\":[\"Express.js\",\"Django\",\"PostgreSQL\",\"MongoDB\",\"Authentication\",\"API Design\"]},{\"level\":\"advanced\",\"duration\":\"6-12 months\",\"title\":\"Advanced Level\",\"description\":\"Master advanced backend patterns\",\"skills\":[\"Microservices\",\"Docker\",\"Redis\",\"GraphQL\",\"Cloud Deployment\",\"Security\"]}]', '[{\"icon\":\"fas fa-server\",\"title\":\"Server Architecture\",\"description\":\"Design scalable and maintainable server-side applications.\",\"color\":\"blue\"},{\"icon\":\"fas fa-database\",\"title\":\"Database Design\",\"description\":\"Master SQL and NoSQL databases for efficient data management.\",\"color\":\"green\"},{\"icon\":\"fas fa-lock\",\"title\":\"Security\",\"description\":\"Implement authentication, authorization, and security best practices.\",\"color\":\"purple\"},{\"icon\":\"fas fa-plug\",\"title\":\"API Development\",\"description\":\"Build RESTful and GraphQL APIs that power modern applications.\",\"color\":\"yellow\"},{\"icon\":\"fas fa-cloud\",\"title\":\"Cloud Services\",\"description\":\"Deploy and manage applications on cloud platforms.\",\"color\":\"red\"},{\"icon\":\"fas fa-cogs\",\"title\":\"DevOps\",\"description\":\"Implement CI/CD pipelines and containerization.\",\"color\":\"orange\"}]', '[\"fas fa-server\",\"fab fa-node-js\",\"fab fa-python\",\"fas fa-database\"]', 'Master server-side development with Node.js, Python, databases, and API design', NULL, NULL, NULL, 'beginner', 250, NULL, NULL, 'published', 'approved', 'both', 1, NULL, NULL, NULL, NULL, 0, '2025-12-22 12:09:41', '2025-12-22 17:49:32', 3, 94, 4.70, 'from-green-600', 'to-green-700', 18, 'PHP, Laravel, Node.js, Express, MongoDB, Docker', '12-24 months', 'fas fa-server', 'Nebatech Team', 2, 1, 'Web Development', 4850.00, 8900.00, 'Nebatech Team'),
(3, '416648bf-df2f-11f0-8b36-f48e38a80c71', 'Full Stack Development', 'fullstack', 'Master Full Stack Development - Become a complete developer by mastering both frontend and backend technologies - from UI to database. Learn Frontend Development (HTML5, CSS3, JavaScript, React, Tailwind CSS), Backend Development (Node.js, Express.js, MongoDB, PostgreSQL, REST APIs), Full Stack Integration (MERN Stack, MEAN Stack, Next.js, GraphQL, WebSockets), and DevOps & Deployment (Docker, AWS, CI/CD, Nginx, Testing, Monitoring). Career outcomes include Senior Developer, Tech Lead, or CTO positions with salaries ranging from  to +.', NULL, '[{\"level\":\"beginner\",\"duration\":\"4-8 months\",\"title\":\"Foundation Level\",\"description\":\"Master core web development skills\",\"skills\":[\"HTML5/CSS3\",\"JavaScript\",\"Python\",\"SQL\",\"Git\",\"Command Line\"]},{\"level\":\"intermediate\",\"duration\":\"6-10 months\",\"title\":\"Application Level\",\"description\":\"Build complete web applications\",\"skills\":[\"React.js\",\"Node.js\",\"Express\",\"MongoDB\",\"REST APIs\",\"Authentication\"]},{\"level\":\"advanced\",\"duration\":\"8-12 months\",\"title\":\"Professional Level\",\"description\":\"Master production-ready development\",\"skills\":[\"Next.js\",\"TypeScript\",\"Docker\",\"AWS/Cloud\",\"Testing\",\"CI/CD\"]}]', '[{\"icon\":\"fas fa-layer-group\",\"title\":\"Full Stack Architecture\",\"description\":\"Design and build complete web applications from frontend to backend.\",\"color\":\"blue\"},{\"icon\":\"fas fa-code\",\"title\":\"Modern JavaScript\",\"description\":\"Master ES6+, TypeScript, and modern JavaScript ecosystem.\",\"color\":\"green\"},{\"icon\":\"fas fa-database\",\"title\":\"Database Management\",\"description\":\"Work with SQL and NoSQL databases efficiently.\",\"color\":\"purple\"},{\"icon\":\"fas fa-cloud\",\"title\":\"Cloud Deployment\",\"description\":\"Deploy applications to cloud platforms like AWS and Vercel.\",\"color\":\"yellow\"},{\"icon\":\"fas fa-shield-alt\",\"title\":\"Security\",\"description\":\"Implement secure authentication and protect against vulnerabilities.\",\"color\":\"red\"},{\"icon\":\"fas fa-rocket\",\"title\":\"Performance\",\"description\":\"Optimize applications for speed and scalability.\",\"color\":\"orange\"}]', '[\"fas fa-code\",\"fab fa-react\",\"fab fa-node-js\",\"fas fa-database\"]', 'Become a complete developer mastering both frontend and backend technologies', NULL, NULL, NULL, 'beginner', 350, NULL, NULL, 'published', 'approved', 'both', 1, NULL, NULL, NULL, NULL, 0, '2025-12-22 12:10:50', '2025-12-22 17:49:32', 4, 96, 4.90, 'from-purple-600', 'to-purple-700', 25, 'MERN, MEAN, Next.js, GraphQL, Docker, AWS', '18-36 months', 'fas fa-layer-group', 'Nebatech Team', 5, 1, 'Web Development', 8300.00, 15000.00, 'Nebatech Team'),
(4, '93374d90-df2f-11f0-8b36-f48e38a80c71', 'Database Design & Administration', 'database', 'Master Database Design & Administration - Learn to design, implement, and manage robust databases with SQL, MySQL, PostgreSQL, and MongoDB. Skills include Database Concepts, SQL, Data Modeling, Query Optimization, Indexing, NoSQL, and Database Administration.', NULL, '[{\"level\":\"beginner\",\"duration\":\"1-2 months\",\"title\":\"SQL Basics\",\"description\":\"Learn database fundamentals\",\"skills\":[\"SQL Syntax\",\"CRUD Operations\",\"Data Types\",\"Basic Queries\",\"Filtering\"]},{\"level\":\"intermediate\",\"duration\":\"2-3 months\",\"title\":\"Advanced SQL\",\"description\":\"Master complex queries\",\"skills\":[\"Joins\",\"Subqueries\",\"Aggregations\",\"Indexes\",\"Stored Procedures\"]},{\"level\":\"advanced\",\"duration\":\"2-3 months\",\"title\":\"Database Admin\",\"description\":\"Manage production databases\",\"skills\":[\"Normalization\",\"Optimization\",\"Backup/Recovery\",\"Security\",\"Replication\"]}]', '[{\"icon\":\"fas fa-database\",\"title\":\"Database Design\",\"description\":\"Create normalized, efficient database schemas.\",\"color\":\"blue\"},{\"icon\":\"fas fa-code\",\"title\":\"SQL Mastery\",\"description\":\"Write complex queries with confidence.\",\"color\":\"green\"},{\"icon\":\"fas fa-tachometer-alt\",\"title\":\"Optimization\",\"description\":\"Tune databases for maximum performance.\",\"color\":\"purple\"},{\"icon\":\"fas fa-shield-alt\",\"title\":\"Security\",\"description\":\"Protect data with proper security measures.\",\"color\":\"yellow\"},{\"icon\":\"fas fa-sync\",\"title\":\"Replication\",\"description\":\"Set up high-availability database systems.\",\"color\":\"red\"},{\"icon\":\"fas fa-tools\",\"title\":\"Administration\",\"description\":\"Manage and maintain production databases.\",\"color\":\"orange\"}]', '[\"fas fa-database\",\"fas fa-table\",\"fas fa-server\",\"fas fa-key\"]', 'Design efficient databases and master SQL for data-driven applications', NULL, NULL, NULL, 'beginner', 40, NULL, NULL, 'published', 'approved', 'both', 1, NULL, NULL, NULL, NULL, 0, '2025-12-22 12:13:07', '2025-12-22 17:50:01', 2, 96, 4.60, 'from-indigo-600', 'to-indigo-700', 12, 'SQL, MySQL, PostgreSQL, MongoDB, Data Modeling', '5-10 months', 'fas fa-database', 'Nebatech Team', 1, 1, 'Data & Database', 2520.00, 4500.00, 'Nebatech Team'),
(5, '9cb4dbd5-df2f-11f0-8b36-f48e38a80c71', 'AI & Machine Learning', 'ai', 'Master AI & Machine Learning - Build intelligent applications with Machine Learning, Deep Learning, NLP, and Computer Vision. Learn Python, NumPy, Pandas, Statistics, Linear Algebra, TensorFlow, PyTorch, and deploy AI models to production.', NULL, '[{\"level\":\"beginner\",\"duration\":\"3-5 months\",\"title\":\"Foundation\",\"description\":\"Learn Python and ML basics\",\"skills\":[\"Python\",\"NumPy\",\"Pandas\",\"Data Visualization\",\"Statistics\"]},{\"level\":\"intermediate\",\"duration\":\"4-6 months\",\"title\":\"Core ML\",\"description\":\"Master machine learning algorithms\",\"skills\":[\"Scikit-learn\",\"Supervised Learning\",\"Unsupervised Learning\",\"Feature Engineering\",\"Model Evaluation\"]},{\"level\":\"advanced\",\"duration\":\"6-9 months\",\"title\":\"Deep Learning\",\"description\":\"Build neural networks and AI systems\",\"skills\":[\"TensorFlow\",\"PyTorch\",\"CNNs\",\"RNNs\",\"NLP\",\"Computer Vision\"]}]', '[{\"icon\":\"fas fa-brain\",\"title\":\"Machine Learning\",\"description\":\"Build predictive models using various ML algorithms.\",\"color\":\"blue\"},{\"icon\":\"fas fa-robot\",\"title\":\"Deep Learning\",\"description\":\"Create neural networks for complex AI tasks.\",\"color\":\"green\"},{\"icon\":\"fas fa-language\",\"title\":\"NLP\",\"description\":\"Process and understand human language.\",\"color\":\"purple\"},{\"icon\":\"fas fa-eye\",\"title\":\"Computer Vision\",\"description\":\"Analyze and understand images and videos.\",\"color\":\"yellow\"},{\"icon\":\"fas fa-chart-line\",\"title\":\"Data Analysis\",\"description\":\"Extract insights from complex datasets.\",\"color\":\"red\"},{\"icon\":\"fas fa-project-diagram\",\"title\":\"ML Ops\",\"description\":\"Deploy and maintain ML models in production.\",\"color\":\"orange\"}]', '[\"fas fa-brain\",\"fas fa-robot\",\"fab fa-python\",\"fas fa-network-wired\"]', 'Master artificial intelligence and machine learning to build intelligent systems', NULL, NULL, NULL, 'beginner', 400, NULL, NULL, 'published', 'approved', 'both', 1, NULL, NULL, NULL, NULL, 0, '2025-12-22 12:13:23', '2025-12-22 17:49:33', 6, 93, 4.90, 'from-indigo-600', 'to-indigo-700', 30, 'Python, TensorFlow, PyTorch, NLP, Computer Vision', '12-24 months', 'fas fa-brain', 'Nebatech Team', 6, 1, 'AI & Data Science', 6900.00, 12000.00, 'Nebatech Team'),
(6, 'a50cddd0-df2f-11f0-8b36-f48e38a80c71', 'Data Science', 'data-science', 'Master Data Science - Extract insights from data with Python, statistics, machine learning, and visualization tools. Learn Python, SQL, Statistics, Pandas, NumPy, Matplotlib, Seaborn, Scikit-learn, and build predictive models.', NULL, '[{\"level\":\"beginner\",\"duration\":\"2-4 months\",\"title\":\"Data Foundations\",\"description\":\"Learn data manipulation basics\",\"skills\":[\"Python\",\"SQL\",\"Excel\",\"Statistics\",\"Data Cleaning\"]},{\"level\":\"intermediate\",\"duration\":\"4-6 months\",\"title\":\"Analysis and Viz\",\"description\":\"Master analysis and visualization\",\"skills\":[\"Pandas\",\"Matplotlib\",\"Seaborn\",\"Tableau\",\"Statistical Analysis\",\"Hypothesis Testing\"]},{\"level\":\"advanced\",\"duration\":\"5-8 months\",\"title\":\"Advanced Analytics\",\"description\":\"Apply advanced techniques\",\"skills\":[\"Machine Learning\",\"Big Data\",\"Spark\",\"A/B Testing\",\"Predictive Modeling\",\"Business Intelligence\"]}]', '[{\"icon\":\"fas fa-chart-bar\",\"title\":\"Data Visualization\",\"description\":\"Create compelling visualizations that tell data stories.\",\"color\":\"blue\"},{\"icon\":\"fas fa-calculator\",\"title\":\"Statistical Analysis\",\"description\":\"Apply statistical methods to extract insights.\",\"color\":\"green\"},{\"icon\":\"fas fa-database\",\"title\":\"Data Management\",\"description\":\"Handle large datasets efficiently.\",\"color\":\"purple\"},{\"icon\":\"fas fa-lightbulb\",\"title\":\"Business Intelligence\",\"description\":\"Transform data into business decisions.\",\"color\":\"yellow\"},{\"icon\":\"fab fa-python\",\"title\":\"Python for Data\",\"description\":\"Master Python data science libraries.\",\"color\":\"red\"},{\"icon\":\"fas fa-cogs\",\"title\":\"ETL Processes\",\"description\":\"Build data pipelines and workflows.\",\"color\":\"orange\"}]', '[\"fas fa-chart-line\",\"fas fa-database\",\"fab fa-python\",\"fas fa-calculator\"]', 'Transform data into actionable insights with statistical analysis and visualization', NULL, NULL, NULL, 'beginner', 380, NULL, NULL, 'published', 'approved', 'both', 1, NULL, NULL, NULL, NULL, 0, '2025-12-22 12:13:37', '2025-12-22 17:30:51', 2, 94, 4.80, 'from-cyan-600', 'to-cyan-700', 28, 'Python, SQL, Pandas, Matplotlib, Scikit-learn', '12-24 months', 'fas fa-chart-bar', 'Nebatech Team', 1, 1, 'AI & Data Science', 9200.00, 15000.00, 'Nebatech Team'),
(7, 'ab52e769-df2f-11f0-8b36-f48e38a80c71', 'Mobile App Development', 'mobile', 'Master Mobile App Development - Build native iOS and Android apps, or create cross-platform solutions with React Native and Flutter. Learn Swift, SwiftUI, Kotlin, Android SDK, React Native, Flutter, and publish to app stores.', NULL, '[{\"level\":\"beginner\",\"duration\":\"2-4 months\",\"title\":\"Mobile Basics\",\"description\":\"Learn mobile development fundamentals\",\"skills\":[\"JavaScript\",\"React Native Basics\",\"UI Components\",\"Navigation\",\"Styling\"]},{\"level\":\"intermediate\",\"duration\":\"3-5 months\",\"title\":\"App Development\",\"description\":\"Build complete mobile apps\",\"skills\":[\"State Management\",\"APIs\",\"Local Storage\",\"Push Notifications\",\"Device Features\"]},{\"level\":\"advanced\",\"duration\":\"4-6 months\",\"title\":\"Production Apps\",\"description\":\"Master production deployment\",\"skills\":[\"Performance Optimization\",\"Testing\",\"App Store Publishing\",\"CI/CD\",\"Analytics\"]}]', '[{\"icon\":\"fas fa-mobile-alt\",\"title\":\"Cross-Platform Dev\",\"description\":\"Build apps that work on both iOS and Android.\",\"color\":\"blue\"},{\"icon\":\"fab fa-react\",\"title\":\"React Native\",\"description\":\"Master the popular cross-platform framework.\",\"color\":\"green\"},{\"icon\":\"fas fa-compass\",\"title\":\"Navigation\",\"description\":\"Implement complex navigation patterns.\",\"color\":\"purple\"},{\"icon\":\"fas fa-bell\",\"title\":\"Push Notifications\",\"description\":\"Engage users with timely notifications.\",\"color\":\"yellow\"},{\"icon\":\"fas fa-store\",\"title\":\"App Publishing\",\"description\":\"Launch apps to App Store and Play Store.\",\"color\":\"red\"},{\"icon\":\"fas fa-tachometer-alt\",\"title\":\"Performance\",\"description\":\"Optimize apps for smooth user experience.\",\"color\":\"orange\"}]', '[\"fas fa-mobile-alt\",\"fab fa-react\",\"fab fa-apple\",\"fab fa-android\"]', 'Build native and cross-platform mobile applications for iOS and Android', NULL, NULL, NULL, 'beginner', 280, NULL, NULL, 'published', 'approved', 'both', 1, NULL, NULL, NULL, NULL, 0, '2025-12-22 12:13:47', '2025-12-22 17:49:33', 3, 92, 4.70, 'from-pink-600', 'to-pink-700', 20, 'Swift, Kotlin, React Native, Flutter, Firebase', '12-24 months', 'fas fa-mobile-alt', 'Nebatech Team', 3, 1, 'Mobile Development', 12500.00, 18000.00, 'Nebatech Team'),
(8, 'b90423ea-df2f-11f0-8b36-f48e38a80c71', 'Cybersecurity', 'cybersecurity', 'Master Cybersecurity - Protect systems and data with ethical hacking, penetration testing, and advanced security techniques. Learn Network Security, Linux, TCP/IP, Ethical Hacking, Penetration Testing, OSINT, and Security Operations.', NULL, '[{\"level\":\"beginner\",\"duration\":\"2-4 months\",\"title\":\"Security Fundamentals\",\"description\":\"Learn security basics\",\"skills\":[\"Networking Basics\",\"Linux\",\"Security Concepts\",\"Cryptography\",\"Risk Assessment\"]},{\"level\":\"intermediate\",\"duration\":\"3-5 months\",\"title\":\"Offensive Security\",\"description\":\"Master penetration testing\",\"skills\":[\"Kali Linux\",\"Vulnerability Assessment\",\"Web App Security\",\"Network Attacks\",\"Social Engineering\"]},{\"level\":\"advanced\",\"duration\":\"4-6 months\",\"title\":\"Advanced Security\",\"description\":\"Advanced attack and defense\",\"skills\":[\"Malware Analysis\",\"Incident Response\",\"Forensics\",\"Cloud Security\",\"Red Team Ops\"]}]', '[{\"icon\":\"fas fa-shield-alt\",\"title\":\"Network Security\",\"description\":\"Secure networks from various attack vectors.\",\"color\":\"blue\"},{\"icon\":\"fas fa-user-secret\",\"title\":\"Ethical Hacking\",\"description\":\"Think like a hacker to protect systems.\",\"color\":\"green\"},{\"icon\":\"fas fa-bug\",\"title\":\"Vulnerability Testing\",\"description\":\"Identify and remediate security weaknesses.\",\"color\":\"purple\"},{\"icon\":\"fas fa-lock\",\"title\":\"Cryptography\",\"description\":\"Implement encryption and secure communications.\",\"color\":\"yellow\"},{\"icon\":\"fas fa-search\",\"title\":\"Forensics\",\"description\":\"Investigate security incidents and breaches.\",\"color\":\"red\"},{\"icon\":\"fas fa-cloud\",\"title\":\"Cloud Security\",\"description\":\"Secure cloud infrastructure and applications.\",\"color\":\"orange\"}]', '[\"fas fa-shield-alt\",\"fas fa-lock\",\"fas fa-user-secret\",\"fas fa-bug\"]', 'Protect systems and networks from cyber threats with ethical hacking skills', NULL, NULL, NULL, 'beginner', 320, NULL, NULL, 'published', 'approved', 'both', 1, NULL, NULL, NULL, NULL, 0, '2025-12-22 12:14:10', '2025-12-22 17:49:50', 2, 91, 4.80, 'from-red-600', 'to-red-700', 22, 'Ethical Hacking, Penetration Testing, Linux, OSINT', '12-24 months', 'fas fa-shield-alt', 'Nebatech Team', 2, 1, 'Security', 15500.00, 22000.00, 'Nebatech Team'),
(9, 'e15dd2eb-df2f-11f0-8b36-f48e38a80c71', 'Cloud Computing', 'cloud', 'Master Cloud Computing - Build, deploy, and manage applications on AWS, Azure, and Google Cloud Platform. Learn cloud fundamentals, compute, storage, networking, databases, serverless, DevOps, and cloud architecture.', NULL, '[{\"level\":\"beginner\",\"duration\":\"2-3 months\",\"title\":\"Cloud Basics\",\"description\":\"Understand cloud fundamentals\",\"skills\":[\"Cloud Concepts\",\"AWS Basics\",\"Virtual Machines\",\"Storage\",\"Networking\"]},{\"level\":\"intermediate\",\"duration\":\"3-5 months\",\"title\":\"Cloud Architecture\",\"description\":\"Design cloud solutions\",\"skills\":[\"EC2\",\"S3\",\"RDS\",\"Lambda\",\"IAM\",\"VPC\"]},{\"level\":\"advanced\",\"duration\":\"4-6 months\",\"title\":\"DevOps and Scale\",\"description\":\"Master production cloud ops\",\"skills\":[\"Kubernetes\",\"Terraform\",\"CI/CD\",\"Monitoring\",\"Cost Optimization\",\"Multi-Cloud\"]}]', '[{\"icon\":\"fab fa-aws\",\"title\":\"AWS Mastery\",\"description\":\"Build and deploy on Amazon Web Services.\",\"color\":\"blue\"},{\"icon\":\"fas fa-cubes\",\"title\":\"Containerization\",\"description\":\"Master Docker and Kubernetes.\",\"color\":\"green\"},{\"icon\":\"fas fa-network-wired\",\"title\":\"Cloud Networking\",\"description\":\"Design secure cloud network architectures.\",\"color\":\"purple\"},{\"icon\":\"fas fa-infinity\",\"title\":\"DevOps\",\"description\":\"Implement CI/CD and infrastructure as code.\",\"color\":\"yellow\"},{\"icon\":\"fas fa-chart-line\",\"title\":\"Monitoring\",\"description\":\"Monitor and optimize cloud resources.\",\"color\":\"red\"},{\"icon\":\"fas fa-dollar-sign\",\"title\":\"Cost Management\",\"description\":\"Optimize cloud spending and resources.\",\"color\":\"orange\"}]', '[\"fab fa-aws\",\"fab fa-docker\",\"fas fa-cloud\",\"fas fa-server\"]', 'Master cloud platforms and build scalable infrastructure on AWS, Azure, and GCP', NULL, NULL, NULL, 'beginner', 360, NULL, NULL, 'published', 'approved', 'both', 1, NULL, NULL, NULL, NULL, 0, '2025-12-22 12:15:18', '2025-12-22 17:47:45', 2, 93, 4.70, 'from-sky-600', 'to-sky-700', 26, 'AWS, Azure, GCP, Docker, Kubernetes, Terraform', '12-24 months', 'fas fa-cloud', 'Nebatech Team', 4, 1, 'Cloud & DevOps', 13500.00, 20000.00, 'Nebatech Team'),
(10, 'e927d763-df2f-11f0-8b36-f48e38a80c71', 'Networking Engineering', 'networking', 'Master Networking Engineering - Learn to design, configure, and manage enterprise networks with Cisco, routing, switching, and security. Skills include TCP/IP, Subnetting, VLANs, Routing Protocols, Network Security, and Troubleshooting.', NULL, '[{\"level\":\"beginner\",\"duration\":\"1-2 months\",\"title\":\"Network Basics\",\"description\":\"Understand networking fundamentals\",\"skills\":[\"OSI Model\",\"TCP/IP\",\"IP Addressing\",\"Subnetting\",\"Network Devices\"]},{\"level\":\"intermediate\",\"duration\":\"2-3 months\",\"title\":\"Network Config\",\"description\":\"Configure network equipment\",\"skills\":[\"Routing\",\"Switching\",\"VLANs\",\"DHCP\",\"DNS\",\"Firewalls\"]},{\"level\":\"advanced\",\"duration\":\"2-3 months\",\"title\":\"Enterprise Networks\",\"description\":\"Design enterprise solutions\",\"skills\":[\"WAN Technologies\",\"VPNs\",\"Network Security\",\"Troubleshooting\",\"Wireless Networks\"]}]', '[{\"icon\":\"fas fa-network-wired\",\"title\":\"Network Design\",\"description\":\"Design efficient and secure network topologies.\",\"color\":\"blue\"},{\"icon\":\"fas fa-router\",\"title\":\"Routing\",\"description\":\"Configure routers and routing protocols.\",\"color\":\"green\"},{\"icon\":\"fas fa-project-diagram\",\"title\":\"Switching\",\"description\":\"Manage switches and VLANs.\",\"color\":\"purple\"},{\"icon\":\"fas fa-shield-alt\",\"title\":\"Network Security\",\"description\":\"Implement firewalls and security policies.\",\"color\":\"yellow\"},{\"icon\":\"fas fa-wifi\",\"title\":\"Wireless\",\"description\":\"Deploy and manage wireless networks.\",\"color\":\"red\"},{\"icon\":\"fas fa-tools\",\"title\":\"Troubleshooting\",\"description\":\"Diagnose and resolve network issues.\",\"color\":\"orange\"}]', '[\"fas fa-network-wired\",\"fas fa-server\",\"fas fa-wifi\",\"fas fa-shield-alt\"]', 'Build and manage computer networks with industry-standard protocols', NULL, NULL, NULL, 'beginner', 35, NULL, NULL, 'published', 'approved', 'both', 1, NULL, NULL, NULL, NULL, 0, '2025-12-22 12:15:31', '2025-12-22 17:47:45', 1, 94, 4.50, 'from-cyan-600', 'to-cyan-700', 10, 'Cisco, TCP/IP, VLANs, Routing, Network Security', '5-10 months', 'fas fa-network-wired', 'Nebatech Team', 1, 0, 'Infrastructure', 3190.00, 5500.00, 'Nebatech Team'),
(11, 'f1264376-df2f-11f0-8b36-f48e38a80c71', 'Computer Hardware', 'hardware', 'Master Computer Hardware - Learn to build, repair, and maintain computer systems from components to complete workstations. Skills include PC Components, CPU, RAM, Storage, Motherboards, System Building, Troubleshooting, and Repairs.', NULL, '[{\"level\":\"beginner\",\"duration\":\"1-2 months\",\"title\":\"Hardware Basics\",\"description\":\"Learn component fundamentals\",\"skills\":[\"Computer Components\",\"Motherboards\",\"CPUs\",\"RAM\",\"Storage Devices\"]},{\"level\":\"intermediate\",\"duration\":\"1-2 months\",\"title\":\"Assembly\",\"description\":\"Build and upgrade computers\",\"skills\":[\"PC Assembly\",\"BIOS/UEFI\",\"Peripheral Devices\",\"Power Supply\",\"Cooling Systems\"]},{\"level\":\"advanced\",\"duration\":\"1-2 months\",\"title\":\"Troubleshooting\",\"description\":\"Diagnose and repair systems\",\"skills\":[\"Diagnostics\",\"Hardware Repair\",\"Preventive Maintenance\",\"Data Recovery\",\"Performance Tuning\"]}]', '[{\"icon\":\"fas fa-microchip\",\"title\":\"Components\",\"description\":\"Understand all computer hardware components.\",\"color\":\"blue\"},{\"icon\":\"fas fa-tools\",\"title\":\"Assembly\",\"description\":\"Build computers from scratch.\",\"color\":\"green\"},{\"icon\":\"fas fa-wrench\",\"title\":\"Repair\",\"description\":\"Diagnose and fix hardware issues.\",\"color\":\"purple\"},{\"icon\":\"fas fa-hdd\",\"title\":\"Storage\",\"description\":\"Manage storage devices and data.\",\"color\":\"yellow\"},{\"icon\":\"fas fa-bolt\",\"title\":\"Power Systems\",\"description\":\"Understand power requirements and UPS.\",\"color\":\"red\"},{\"icon\":\"fas fa-thermometer-half\",\"title\":\"Cooling\",\"description\":\"Implement proper cooling solutions.\",\"color\":\"orange\"}]', '[\"fas fa-microchip\",\"fas fa-memory\",\"fas fa-hdd\",\"fas fa-desktop\"]', 'Understand computer hardware components and troubleshoot system issues', NULL, NULL, NULL, 'beginner', 25, NULL, NULL, 'published', 'approved', 'both', 1, NULL, NULL, NULL, NULL, 0, '2025-12-22 12:15:45', '2025-12-22 17:30:51', 4, 97, 4.60, 'from-gray-600', 'to-gray-700', 8, 'PC Building, Troubleshooting, BIOS, Hardware Repairs', '3-6 months', 'fas fa-microchip', 'Nebatech Team', 3, 0, 'Infrastructure', 1560.00, 2800.00, 'Nebatech Team'),
(12, '7ed8684c-df30-11f0-8b36-f48e38a80c71', 'Digital Literacy', 'digital-literacy', 'Master Digital Literacy - Learn essential computer skills, internet safety, and digital tools for the modern workplace. Skills include Computer Basics, Windows/Mac OS, File Management, Internet, Email, Online Safety, and Productivity Tools.', NULL, '[{\"level\":\"beginner\",\"duration\":\"2-4 weeks\",\"title\":\"Computer Basics\",\"description\":\"Learn fundamental computer skills\",\"skills\":[\"Computer Operations\",\"File Management\",\"Internet Basics\",\"Email\",\"Web Browsing\"]},{\"level\":\"intermediate\",\"duration\":\"2-4 weeks\",\"title\":\"Productivity\",\"description\":\"Master productivity tools\",\"skills\":[\"Word Processing\",\"Spreadsheets\",\"Presentations\",\"Cloud Storage\",\"Online Collaboration\"]},{\"level\":\"advanced\",\"duration\":\"2-4 weeks\",\"title\":\"Digital Citizenship\",\"description\":\"Navigate the digital world safely\",\"skills\":[\"Online Safety\",\"Privacy\",\"Digital Communication\",\"Social Media\",\"Information Literacy\"]}]', '[{\"icon\":\"fas fa-desktop\",\"title\":\"Computer Skills\",\"description\":\"Operate computers with confidence.\",\"color\":\"blue\"},{\"icon\":\"fas fa-globe\",\"title\":\"Internet\",\"description\":\"Navigate the web safely and effectively.\",\"color\":\"green\"},{\"icon\":\"fas fa-envelope\",\"title\":\"Communication\",\"description\":\"Use email and digital communication tools.\",\"color\":\"purple\"},{\"icon\":\"fas fa-shield-alt\",\"title\":\"Online Safety\",\"description\":\"Protect yourself from online threats.\",\"color\":\"yellow\"},{\"icon\":\"fas fa-cloud\",\"title\":\"Cloud Services\",\"description\":\"Use cloud storage and online tools.\",\"color\":\"red\"},{\"icon\":\"fas fa-users\",\"title\":\"Collaboration\",\"description\":\"Work with others using digital tools.\",\"color\":\"orange\"}]', '[\"fas fa-desktop\",\"fas fa-keyboard\",\"fas fa-mouse-pointer\",\"fas fa-globe\"]', 'Master essential computer skills for the digital age', NULL, NULL, NULL, 'beginner', 20, NULL, NULL, 'published', 'approved', 'both', 1, NULL, NULL, NULL, NULL, 0, '2025-12-22 12:19:42', '2025-12-22 17:47:45', 2, 98, 4.90, 'from-teal-600', 'to-teal-700', 8, 'Computer Basics, Internet Safety, Productivity Tools', '5-9 months', 'fas fa-book', 'Nebatech Team', 3, 0, 'Digital Skills', 1200.00, 2000.00, 'Nebatech Team'),
(13, '89ad1002-df30-11f0-8b36-f48e38a80c71', 'Graphic Design & Digital Arts', 'graphic-design', 'Master Graphic Design & Digital Arts - Learn professional graphic design, branding, and digital illustration with industry tools. Skills include Design Basics, Adobe Photoshop, Illustrator, Color Theory, Brand Identity, Logo Design, and Typography.', NULL, '[{\"level\":\"beginner\",\"duration\":\"1-2 months\",\"title\":\"Design Basics\",\"description\":\"Learn design fundamentals\",\"skills\":[\"Color Theory\",\"Typography\",\"Composition\",\"Design Principles\",\"Canva\"]},{\"level\":\"intermediate\",\"duration\":\"2-3 months\",\"title\":\"Adobe Suite\",\"description\":\"Master professional tools\",\"skills\":[\"Photoshop\",\"Illustrator\",\"Brand Design\",\"Logo Creation\",\"Print Design\"]},{\"level\":\"advanced\",\"duration\":\"2-3 months\",\"title\":\"Professional Design\",\"description\":\"Create professional-grade work\",\"skills\":[\"UI Design\",\"Motion Graphics\",\"3D Basics\",\"Portfolio Building\",\"Client Work\"]}]', '[{\"icon\":\"fas fa-palette\",\"title\":\"Color Theory\",\"description\":\"Master color selection and harmony.\",\"color\":\"blue\"},{\"icon\":\"fas fa-font\",\"title\":\"Typography\",\"description\":\"Use fonts effectively in designs.\",\"color\":\"green\"},{\"icon\":\"fab fa-adobe\",\"title\":\"Adobe Tools\",\"description\":\"Create with Photoshop and Illustrator.\",\"color\":\"purple\"},{\"icon\":\"fas fa-vector-square\",\"title\":\"Vector Graphics\",\"description\":\"Design scalable vector artwork.\",\"color\":\"yellow\"},{\"icon\":\"fas fa-id-card\",\"title\":\"Branding\",\"description\":\"Create cohesive brand identities.\",\"color\":\"red\"},{\"icon\":\"fas fa-print\",\"title\":\"Print Design\",\"description\":\"Design for print and digital media.\",\"color\":\"orange\"}]', '[\"fas fa-palette\",\"fas fa-pen-nib\",\"fab fa-adobe\",\"fas fa-bezier-curve\"]', 'Create stunning visual designs with industry-standard tools and techniques', NULL, NULL, NULL, 'beginner', 38, NULL, NULL, 'published', 'approved', 'both', 1, NULL, NULL, NULL, NULL, 0, '2025-12-22 12:20:00', '2025-12-22 17:30:51', 4, 95, 4.70, 'from-amber-600', 'to-amber-700', 11, 'Photoshop, Illustrator, Branding, Logo Design', '5-10 months', 'fas fa-palette', 'Nebatech Team', 3, 0, 'Creative & Design', 1980.00, 3500.00, 'Nebatech Team'),
(14, '919915e7-df30-11f0-8b36-f48e38a80c71', 'Video Editing & Production', 'video-editing', 'Master Video Editing & Production - Learn professional video editing, motion graphics, and content creation with industry-standard tools. Skills include Adobe Premiere, After Effects, Color Grading, Audio Editing, Motion Graphics, and Visual Effects.', NULL, '[{\"level\":\"beginner\",\"duration\":\"1-2 months\",\"title\":\"Editing Basics\",\"description\":\"Learn video editing fundamentals\",\"skills\":[\"Video Concepts\",\"Basic Cuts\",\"Timeline Editing\",\"Audio Sync\",\"Export Settings\"]},{\"level\":\"intermediate\",\"duration\":\"2-3 months\",\"title\":\"Professional Editing\",\"description\":\"Master professional techniques\",\"skills\":[\"Adobe Premiere Pro\",\"Color Correction\",\"Transitions\",\"Effects\",\"Audio Editing\"]},{\"level\":\"advanced\",\"duration\":\"2-3 months\",\"title\":\"Advanced Production\",\"description\":\"Create broadcast-quality content\",\"skills\":[\"Motion Graphics\",\"Green Screen\",\"Color Grading\",\"Sound Design\",\"Workflow Optimization\"]}]', '[{\"icon\":\"fas fa-video\",\"title\":\"Video Editing\",\"description\":\"Edit videos with professional software.\",\"color\":\"blue\"},{\"icon\":\"fas fa-film\",\"title\":\"Storytelling\",\"description\":\"Tell compelling stories through video.\",\"color\":\"green\"},{\"icon\":\"fas fa-adjust\",\"title\":\"Color Grading\",\"description\":\"Create cinematic color looks.\",\"color\":\"purple\"},{\"icon\":\"fas fa-music\",\"title\":\"Audio\",\"description\":\"Mix and master audio for video.\",\"color\":\"yellow\"},{\"icon\":\"fas fa-magic\",\"title\":\"Effects\",\"description\":\"Add visual effects and motion graphics.\",\"color\":\"red\"},{\"icon\":\"fas fa-share-square\",\"title\":\"Publishing\",\"description\":\"Export and publish for various platforms.\",\"color\":\"orange\"}]', '[\"fas fa-video\",\"fas fa-film\",\"fas fa-cut\",\"fab fa-youtube\"]', 'Edit professional videos with modern techniques and software', NULL, NULL, NULL, 'beginner', 35, NULL, NULL, 'published', 'approved', 'both', 1, NULL, NULL, NULL, NULL, 0, '2025-12-22 12:20:14', '2025-12-22 17:30:51', 5, 94, 4.60, 'from-rose-600', 'to-rose-700', 10, 'Adobe Premiere, After Effects, Motion Graphics', '5-10 months', 'fas fa-video', 'Nebatech Team', 4, 0, 'Creative & Design', 1790.00, 3200.00, 'Nebatech Team'),
(15, '9abb2e6d-df30-11f0-8b36-f48e38a80c71', 'Microsoft Office Suite', 'microsoft-office', 'Master Microsoft Office Suite - Excel, Word, PowerPoint, and Outlook - from basics to advanced productivity techniques. Skills include Word, Excel Formulas, Pivot Tables, PowerPoint Presentations, and Outlook Email Management.', NULL, '[{\"level\":\"beginner\",\"duration\":\"2-3 weeks\",\"title\":\"Office Basics\",\"description\":\"Learn essential Office skills\",\"skills\":[\"Word Basics\",\"Excel Basics\",\"PowerPoint Basics\",\"Outlook\",\"OneDrive\"]},{\"level\":\"intermediate\",\"duration\":\"3-4 weeks\",\"title\":\"Intermediate Skills\",\"description\":\"Master productivity features\",\"skills\":[\"Advanced Word\",\"Formulas and Functions\",\"Presentation Design\",\"Email Management\",\"Collaboration\"]},{\"level\":\"advanced\",\"duration\":\"3-4 weeks\",\"title\":\"Power User\",\"description\":\"Become an Office power user\",\"skills\":[\"Macros\",\"Pivot Tables\",\"Mail Merge\",\"Templates\",\"Integration\"]}]', '[{\"icon\":\"fas fa-file-word\",\"title\":\"Word Processing\",\"description\":\"Create professional documents with Word.\",\"color\":\"blue\"},{\"icon\":\"fas fa-file-excel\",\"title\":\"Spreadsheets\",\"description\":\"Analyze data with Excel formulas and charts.\",\"color\":\"green\"},{\"icon\":\"fas fa-file-powerpoint\",\"title\":\"Presentations\",\"description\":\"Design impactful presentations.\",\"color\":\"purple\"},{\"icon\":\"fas fa-envelope\",\"title\":\"Email\",\"description\":\"Manage professional communications.\",\"color\":\"yellow\"},{\"icon\":\"fas fa-users\",\"title\":\"Collaboration\",\"description\":\"Work together with Teams and SharePoint.\",\"color\":\"red\"},{\"icon\":\"fas fa-chart-pie\",\"title\":\"Data Analysis\",\"description\":\"Create reports and analyze business data.\",\"color\":\"orange\"}]', '[\"fab fa-microsoft\",\"fas fa-file-word\",\"fas fa-file-excel\",\"fas fa-file-powerpoint\"]', 'Master Microsoft Office suite for professional productivity', NULL, NULL, NULL, 'beginner', 30, NULL, NULL, 'published', 'approved', 'both', 1, NULL, NULL, NULL, NULL, 0, '2025-12-22 12:20:29', '2025-12-22 17:30:51', 8, 97, 4.80, 'from-blue-600', 'to-blue-700', 10, 'Excel, Word, PowerPoint, Outlook, VBA Macros', '4-6 months', 'fas fa-file-alt', 'Nebatech Team', 6, 0, 'Digital Skills', 2280.00, 3800.00, 'Nebatech Team'),
(16, '8648ae1e-df37-11f0-8b36-f48e38a80c71', 'HTML & CSS Fundamentals', 'html-css-fundamentals', 'Learn the building blocks of web development with HTML5 and CSS3.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'beginner', 40, NULL, NULL, 'published', 'approved', 'both', 0, 1, NULL, NULL, NULL, 0, '2025-12-22 13:10:01', '2025-12-22 17:16:18', 71, 95, 4.90, 'from-orange-500', 'to-orange-600', 45, 'Hands-on Projects', NULL, 'fab fa-html5', 'Nebatech Team', 52, 0, NULL, 590.00, NULL, NULL),
(17, '864f0087-df37-11f0-8b36-f48e38a80c71', 'JavaScript Essentials', 'javascript-essentials', 'Master JavaScript from basics to advanced concepts and ES6+ features.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'beginner', 60, NULL, NULL, 'published', 'approved', 'both', 0, 1, NULL, NULL, NULL, 0, '2025-12-22 13:10:01', '2025-12-22 17:16:18', 48, 95, 4.50, 'from-yellow-400', 'to-yellow-500', 65, 'Hands-on Projects', NULL, 'fab fa-js', 'Nebatech Team', 24, 0, NULL, 950.00, NULL, NULL),
(18, '864f042a-df37-11f0-8b36-f48e38a80c71', 'React.js Complete Guide', 'react-js-complete-guide', 'Build powerful web applications with React, Hooks, and modern patterns.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'intermediate', 80, NULL, NULL, 'published', 'approved', 'both', 0, 1, NULL, NULL, NULL, 0, '2025-12-22 13:10:01', '2025-12-22 17:16:18', 67, 95, 4.40, 'from-blue-500', 'to-blue-600', 95, 'Hands-on Projects', NULL, 'fab fa-react', 'Nebatech Team', 48, 0, NULL, 1550.00, NULL, NULL),
(19, '864f0675-df37-11f0-8b36-f48e38a80c71', 'Vue.js Mastery', 'vue-js-mastery', 'Learn Vue 3, Composition API, Vuex, and build modern SPAs.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'intermediate', 70, NULL, NULL, 'published', 'approved', 'both', 0, 1, NULL, NULL, NULL, 0, '2025-12-22 13:10:01', '2025-12-22 17:16:18', 61, 95, 4.50, 'from-green-500', 'to-green-600', 82, 'Hands-on Projects', NULL, 'fab fa-vuejs', 'Nebatech Team', 50, 0, NULL, 1430.00, NULL, NULL),
(20, '864f08e9-df37-11f0-8b36-f48e38a80c71', 'Tailwind CSS Fundamentals', 'tailwind-css-fundamentals', 'Build modern UIs rapidly with utility-first CSS framework.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'intermediate', 35, NULL, NULL, 'published', 'approved', 'both', 0, 1, NULL, NULL, NULL, 0, '2025-12-22 13:10:01', '2025-12-22 17:16:18', 37, 95, 4.70, 'from-blue-600', 'to-blue-700', 42, 'Hands-on Projects', NULL, 'fas fa-wind', 'Nebatech Team', 51, 0, NULL, 710.00, NULL, NULL),
(21, '864f0cab-df37-11f0-8b36-f48e38a80c71', 'Next.js Full Course', 'next-js-full-course', 'Build production-ready React apps with SSR, SSG, and API routes.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'advanced', 90, NULL, NULL, 'published', 'approved', 'both', 0, 1, NULL, NULL, NULL, 0, '2025-12-22 13:10:01', '2025-12-22 17:16:18', 24, 95, 4.80, 'from-gray-800', 'to-black', 110, 'Hands-on Projects', NULL, 'fas fa-server', 'Nebatech Team', 50, 0, NULL, 1790.00, NULL, NULL),
(22, '8654622d-df37-11f0-8b36-f48e38a80c71', 'Node.js Fundamentals', 'nodejs-fundamentals', 'Learn server-side JavaScript with Node.js and build REST APIs.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'beginner', 50, NULL, NULL, 'published', 'approved', 'both', 0, 2, NULL, NULL, NULL, 0, '2025-12-22 13:10:01', '2025-12-22 17:16:18', 76, 95, 4.30, 'from-green-600', 'to-green-700', 55, 'Hands-on Projects', NULL, 'fab fa-node-js', 'Nebatech Team', 15, 0, NULL, 890.00, NULL, NULL),
(23, '86547f21-df37-11f0-8b36-f48e38a80c71', 'Python for Backend', 'python-backend', 'Master Python programming for web development and automation.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'beginner', 60, NULL, NULL, 'published', 'approved', 'both', 0, 2, NULL, NULL, NULL, 0, '2025-12-22 13:10:01', '2025-12-22 17:16:18', 54, 95, 4.80, 'from-blue-500', 'to-yellow-500', 60, 'Hands-on Projects', NULL, 'fab fa-python', 'Nebatech Team', 54, 0, NULL, 950.00, NULL, NULL),
(24, '8654861c-df37-11f0-8b36-f48e38a80c71', 'Express.js & MongoDB', 'express-mongodb', 'Build full-stack applications with Express.js and MongoDB.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'intermediate', 55, NULL, NULL, 'published', 'approved', 'both', 0, 2, NULL, NULL, NULL, 0, '2025-12-22 13:10:01', '2025-12-22 17:16:18', 91, 95, 4.80, 'from-green-500', 'to-gray-700', 65, 'Hands-on Projects', NULL, 'fas fa-database', 'Nebatech Team', 37, 0, NULL, 1100.00, NULL, NULL),
(25, '86548a71-df37-11f0-8b36-f48e38a80c71', 'Django Web Framework', 'django-web-framework', 'Build robust web applications with Django and Python.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'intermediate', 70, NULL, NULL, 'published', 'approved', 'both', 0, 2, NULL, NULL, NULL, 0, '2025-12-22 13:10:01', '2025-12-22 17:16:18', 36, 95, 4.50, 'from-green-800', 'to-green-600', 80, 'Hands-on Projects', NULL, 'fab fa-python', 'Nebatech Team', 27, 0, NULL, 1350.00, NULL, NULL),
(26, '86548dc1-df37-11f0-8b36-f48e38a80c71', 'PostgreSQL & SQL Mastery', 'postgresql-sql-mastery', 'Master relational databases with PostgreSQL and advanced SQL.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'intermediate', 45, NULL, NULL, 'published', 'approved', 'both', 0, 2, NULL, NULL, NULL, 0, '2025-12-22 13:10:01', '2025-12-22 17:16:18', 66, 95, 4.80, 'from-blue-700', 'to-blue-500', 50, 'Hands-on Projects', NULL, 'fas fa-database', 'Nebatech Team', 37, 0, NULL, 780.00, NULL, NULL),
(27, '8654926a-df37-11f0-8b36-f48e38a80c71', 'API Design & GraphQL', 'api-design-graphql', 'Design RESTful APIs and build GraphQL services.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'advanced', 65, NULL, NULL, 'published', 'approved', 'both', 0, 2, NULL, NULL, NULL, 0, '2025-12-22 13:10:01', '2025-12-22 17:16:18', 32, 95, 4.40, 'from-pink-600', 'to-purple-600', 75, 'Hands-on Projects', NULL, 'fas fa-project-diagram', 'Nebatech Team', 18, 0, NULL, 1280.00, NULL, NULL),
(28, '865ce07e-df37-11f0-8b36-f48e38a80c71', 'Web Development Foundations', 'web-dev-foundations', 'Learn HTML, CSS, and JavaScript fundamentals for web development.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'beginner', 50, NULL, NULL, 'published', 'approved', 'both', 0, 3, NULL, NULL, NULL, 0, '2025-12-22 13:10:01', '2025-12-22 17:16:18', 55, 95, 4.70, 'from-blue-500', 'to-blue-600', 55, 'Hands-on Projects', NULL, 'fas fa-code', 'Nebatech Team', 26, 0, NULL, 850.00, NULL, NULL),
(29, '865d0a91-df37-11f0-8b36-f48e38a80c71', 'React & Node.js Stack', 'react-nodejs-stack', 'Build full-stack applications with React and Node.js.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'intermediate', 80, NULL, NULL, 'published', 'approved', 'both', 0, 3, NULL, NULL, NULL, 0, '2025-12-22 13:10:01', '2025-12-22 17:16:18', 59, 95, 4.60, 'from-blue-600', 'to-green-600', 90, 'Hands-on Projects', NULL, 'fab fa-react', 'Nebatech Team', 47, 0, NULL, 1650.00, NULL, NULL),
(30, '865d12f2-df37-11f0-8b36-f48e38a80c71', 'Database Integration', 'database-integration', 'Connect applications to SQL and NoSQL databases.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'intermediate', 45, NULL, NULL, 'published', 'approved', 'both', 0, 3, NULL, NULL, NULL, 0, '2025-12-22 13:10:01', '2025-12-22 17:16:18', 52, 95, 4.80, 'from-purple-600', 'to-purple-700', 50, 'Hands-on Projects', NULL, 'fas fa-database', 'Nebatech Team', 43, 0, NULL, 890.00, NULL, NULL),
(31, '865d19db-df37-11f0-8b36-f48e38a80c71', 'Authentication & Security', 'authentication-security', 'Implement secure user authentication and authorization.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'intermediate', 40, NULL, NULL, 'published', 'approved', 'both', 0, 3, NULL, NULL, NULL, 0, '2025-12-22 13:10:01', '2025-12-22 17:16:18', 23, 95, 4.40, 'from-red-600', 'to-red-700', 45, 'Hands-on Projects', NULL, 'fas fa-shield-alt', 'Nebatech Team', 48, 0, NULL, 780.00, NULL, NULL),
(32, '865d23e5-df37-11f0-8b36-f48e38a80c71', 'Deployment & DevOps', 'deployment-devops', 'Deploy applications to cloud platforms with CI/CD.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'advanced', 55, NULL, NULL, 'published', 'approved', 'both', 0, 3, NULL, NULL, NULL, 0, '2025-12-22 13:10:01', '2025-12-22 17:16:18', 44, 95, 4.40, 'from-orange-600', 'to-orange-700', 60, 'Hands-on Projects', NULL, 'fas fa-cloud-upload-alt', 'Nebatech Team', 19, 0, NULL, 1100.00, NULL, NULL),
(33, '865d2b5a-df37-11f0-8b36-f48e38a80c71', 'Full Stack Project', 'fullstack-project', 'Build a complete full-stack application from scratch.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'advanced', 80, NULL, NULL, 'published', 'approved', 'both', 0, 3, NULL, NULL, NULL, 0, '2025-12-22 13:10:01', '2025-12-22 17:16:18', 45, 95, 4.90, 'from-indigo-600', 'to-indigo-700', 25, 'Hands-on Projects', NULL, 'fas fa-laptop-code', 'Nebatech Team', 58, 0, NULL, 1550.00, NULL, NULL),
(34, '8668c689-df37-11f0-8b36-f48e38a80c71', 'Python for AI', 'python-for-ai', 'Master Python programming for AI and machine learning.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'beginner', 50, NULL, NULL, 'published', 'approved', 'both', 0, 5, NULL, NULL, NULL, 0, '2025-12-22 13:10:01', '2025-12-22 17:16:18', 93, 95, 4.70, 'from-blue-500', 'to-yellow-500', 55, 'Hands-on Projects', NULL, 'fab fa-python', 'Nebatech Team', 43, 0, NULL, 890.00, NULL, NULL),
(35, '866918c7-df37-11f0-8b36-f48e38a80c71', 'Machine Learning Fundamentals', 'ml-fundamentals', 'Learn core ML algorithms and scikit-learn library.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'intermediate', 70, NULL, NULL, 'published', 'approved', 'both', 0, 5, NULL, NULL, NULL, 0, '2025-12-22 13:10:01', '2025-12-22 17:16:18', 41, 95, 4.50, 'from-green-600', 'to-green-700', 80, 'Hands-on Projects', NULL, 'fas fa-brain', 'Nebatech Team', 53, 0, NULL, 1350.00, NULL, NULL),
(36, '86691cf9-df37-11f0-8b36-f48e38a80c71', 'Deep Learning with TensorFlow', 'deep-learning-tensorflow', 'Build neural networks with TensorFlow and Keras.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'intermediate', 80, NULL, NULL, 'published', 'approved', 'both', 0, 5, NULL, NULL, NULL, 0, '2025-12-22 13:10:01', '2025-12-22 17:16:18', 50, 95, 4.50, 'from-orange-600', 'to-orange-700', 90, 'Hands-on Projects', NULL, 'fas fa-network-wired', 'Nebatech Team', 24, 0, NULL, 1550.00, NULL, NULL),
(37, '866920db-df37-11f0-8b36-f48e38a80c71', 'Natural Language Processing', 'nlp-course', 'Process and understand human language with NLP.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'advanced', 65, NULL, NULL, 'published', 'approved', 'both', 0, 5, NULL, NULL, NULL, 0, '2025-12-22 13:10:01', '2025-12-22 17:16:18', 65, 95, 4.90, 'from-purple-600', 'to-purple-700', 70, 'Hands-on Projects', NULL, 'fas fa-language', 'Nebatech Team', 23, 0, NULL, 1280.00, NULL, NULL),
(38, '866923cd-df37-11f0-8b36-f48e38a80c71', 'Computer Vision', 'computer-vision', 'Build image recognition and object detection systems.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'advanced', 70, NULL, NULL, 'published', 'approved', 'both', 0, 5, NULL, NULL, NULL, 0, '2025-12-22 13:10:01', '2025-12-22 17:16:18', 47, 95, 4.80, 'from-blue-700', 'to-blue-800', 75, 'Hands-on Projects', NULL, 'fas fa-eye', 'Nebatech Team', 32, 0, NULL, 1380.00, NULL, NULL),
(39, '866926d7-df37-11f0-8b36-f48e38a80c71', 'AI Project Portfolio', 'ai-project-portfolio', 'Build production-ready AI projects for your portfolio.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'advanced', 65, NULL, NULL, 'published', 'approved', 'both', 0, 5, NULL, NULL, NULL, 0, '2025-12-22 13:10:01', '2025-12-22 17:16:18', 66, 95, 4.60, 'from-red-600', 'to-red-700', 30, 'Hands-on Projects', NULL, 'fas fa-robot', 'Nebatech Team', 13, 0, NULL, 1250.00, NULL, NULL);
INSERT INTO `courses` (`id`, `uuid`, `title`, `slug`, `description`, `learning_objectives`, `technologies`, `skills_gained`, `floating_icons`, `hero_subtitle`, `category_id`, `related_service_id`, `service_description`, `level`, `duration_hours`, `thumbnail`, `facilitator_id`, `status`, `approval_status`, `availability`, `is_bundle`, `parent_course_id`, `rejection_reason`, `approved_by`, `approved_at`, `ai_generated`, `created_at`, `updated_at`, `enrollment_count`, `success_rate`, `rating`, `card_color_from`, `card_color_to`, `card_modules`, `card_features`, `card_duration`, `card_icon`, `instructor_name`, `review_count`, `is_new`, `category`, `price`, `original_price`, `facilitator_name`) VALUES
(40, '86713704-df37-11f0-8b36-f48e38a80c71', 'Python for Data Science', 'python-data-science', 'Master Python, NumPy, and Pandas for data analysis.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'beginner', 55, NULL, NULL, 'published', 'approved', 'both', 0, 6, NULL, NULL, NULL, 0, '2025-12-22 13:10:02', '2025-12-22 17:16:18', 74, 95, 4.40, 'from-blue-500', 'to-blue-600', 60, 'Hands-on Projects', NULL, 'fab fa-python', 'Nebatech Team', 47, 0, NULL, 950.00, NULL, NULL),
(41, '86761e1f-df37-11f0-8b36-f48e38a80c71', 'Statistics & Probability', 'statistics-probability', 'Learn statistical methods for data analysis.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'beginner', 45, NULL, NULL, 'published', 'approved', 'both', 0, 6, NULL, NULL, NULL, 0, '2025-12-22 13:10:02', '2025-12-22 17:16:18', 42, 95, 4.40, 'from-green-600', 'to-green-700', 50, 'Hands-on Projects', NULL, 'fas fa-calculator', 'Nebatech Team', 11, 0, NULL, 780.00, NULL, NULL),
(42, '867621f9-df37-11f0-8b36-f48e38a80c71', 'Data Visualization', 'data-visualization', 'Create compelling visualizations with Matplotlib and Seaborn.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'intermediate', 40, NULL, NULL, 'published', 'approved', 'both', 0, 6, NULL, NULL, NULL, 0, '2025-12-22 13:10:02', '2025-12-22 17:16:18', 67, 95, 4.80, 'from-purple-600', 'to-purple-700', 45, 'Hands-on Projects', NULL, 'fas fa-chart-bar', 'Nebatech Team', 47, 0, NULL, 720.00, NULL, NULL),
(43, '867623bd-df37-11f0-8b36-f48e38a80c71', 'SQL for Data Analysis', 'sql-data-analysis', 'Query and analyze data with advanced SQL.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'intermediate', 50, NULL, NULL, 'published', 'approved', 'both', 0, 6, NULL, NULL, NULL, 0, '2025-12-22 13:10:02', '2025-12-22 17:16:18', 22, 95, 4.80, 'from-blue-700', 'to-blue-800', 55, 'Hands-on Projects', NULL, 'fas fa-database', 'Nebatech Team', 31, 0, NULL, 890.00, NULL, NULL),
(44, '86762655-df37-11f0-8b36-f48e38a80c71', 'Machine Learning for Data Science', 'ml-data-science', 'Apply ML algorithms to solve data problems.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'advanced', 75, NULL, NULL, 'published', 'approved', 'both', 0, 6, NULL, NULL, NULL, 0, '2025-12-22 13:10:02', '2025-12-22 17:16:18', 58, 95, 4.30, 'from-orange-600', 'to-orange-700', 85, 'Hands-on Projects', NULL, 'fas fa-brain', 'Nebatech Team', 55, 0, NULL, 1450.00, NULL, NULL),
(45, '86762930-df37-11f0-8b36-f48e38a80c71', 'Big Data with Spark', 'big-data-spark', 'Process large datasets with Apache Spark.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'advanced', 60, NULL, NULL, 'published', 'approved', 'both', 0, 6, NULL, NULL, NULL, 0, '2025-12-22 13:10:02', '2025-12-22 17:16:18', 44, 95, 4.80, 'from-red-600', 'to-red-700', 65, 'Hands-on Projects', NULL, 'fas fa-fire', 'Nebatech Team', 24, 0, NULL, 1180.00, NULL, NULL),
(46, '867d1678-df37-11f0-8b36-f48e38a80c71', 'React Native Fundamentals', 'react-native-fundamentals', 'Build cross-platform mobile apps with React Native.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'beginner', 55, NULL, NULL, 'published', 'approved', 'both', 0, 7, NULL, NULL, NULL, 0, '2025-12-22 13:10:02', '2025-12-22 17:16:18', 95, 95, 4.80, 'from-blue-500', 'to-blue-600', 60, 'Hands-on Projects', NULL, 'fab fa-react', 'Nebatech Team', 24, 0, NULL, 980.00, NULL, NULL),
(47, '867f6e54-df37-11f0-8b36-f48e38a80c71', 'Mobile UI/UX Design', 'mobile-ui-ux', 'Design beautiful and intuitive mobile interfaces.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'beginner', 40, NULL, NULL, 'published', 'approved', 'both', 0, 7, NULL, NULL, NULL, 0, '2025-12-22 13:10:02', '2025-12-22 17:16:18', 21, 95, 4.40, 'from-pink-500', 'to-pink-600', 45, 'Hands-on Projects', NULL, 'fas fa-mobile-alt', 'Nebatech Team', 55, 0, NULL, 720.00, NULL, NULL),
(48, '867f7085-df37-11f0-8b36-f48e38a80c71', 'State Management & APIs', 'state-management-apis', 'Manage app state and integrate with backend APIs.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'intermediate', 50, NULL, NULL, 'published', 'approved', 'both', 0, 7, NULL, NULL, NULL, 0, '2025-12-22 13:10:02', '2025-12-22 17:16:18', 96, 95, 4.30, 'from-green-600', 'to-green-700', 55, 'Hands-on Projects', NULL, 'fas fa-sync', 'Nebatech Team', 32, 0, NULL, 920.00, NULL, NULL),
(49, '867f7171-df37-11f0-8b36-f48e38a80c71', 'Native Device Features', 'native-device-features', 'Access camera, GPS, notifications, and more.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'intermediate', 45, NULL, NULL, 'published', 'approved', 'both', 0, 7, NULL, NULL, NULL, 0, '2025-12-22 13:10:02', '2025-12-22 17:16:18', 26, 95, 4.30, 'from-purple-600', 'to-purple-700', 50, 'Hands-on Projects', NULL, 'fas fa-camera', 'Nebatech Team', 11, 0, NULL, 850.00, NULL, NULL),
(50, '867f7251-df37-11f0-8b36-f48e38a80c71', 'App Store Deployment', 'app-store-deployment', 'Publish apps to iOS App Store and Google Play.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'advanced', 35, NULL, NULL, 'published', 'approved', 'both', 0, 7, NULL, NULL, NULL, 0, '2025-12-22 13:10:02', '2025-12-22 17:16:18', 94, 95, 4.70, 'from-gray-700', 'to-gray-800', 40, 'Hands-on Projects', NULL, 'fas fa-store', 'Nebatech Team', 25, 0, NULL, 680.00, NULL, NULL),
(51, '867f73c8-df37-11f0-8b36-f48e38a80c71', 'Mobile App Project', 'mobile-app-project', 'Build a complete mobile app from scratch.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'advanced', 55, NULL, NULL, 'published', 'approved', 'both', 0, 7, NULL, NULL, NULL, 0, '2025-12-22 13:10:02', '2025-12-22 17:16:18', 73, 95, 4.50, 'from-indigo-600', 'to-indigo-700', 30, 'Hands-on Projects', NULL, 'fas fa-mobile', 'Nebatech Team', 11, 0, NULL, 1050.00, NULL, NULL),
(52, '868c5450-df37-11f0-8b36-f48e38a80c71', 'Networking & Security Basics', 'networking-security-basics', 'Learn networking fundamentals and security concepts.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'beginner', 50, NULL, NULL, 'published', 'approved', 'both', 0, 8, NULL, NULL, NULL, 0, '2025-12-22 13:10:02', '2025-12-22 17:16:18', 92, 95, 4.60, 'from-blue-600', 'to-blue-700', 55, 'Hands-on Projects', NULL, 'fas fa-network-wired', 'Nebatech Team', 37, 0, NULL, 890.00, NULL, NULL),
(53, '868c6a6a-df37-11f0-8b36-f48e38a80c71', 'Linux Administration', 'linux-administration', 'Master Linux for security professionals.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'beginner', 45, NULL, NULL, 'published', 'approved', 'both', 0, 8, NULL, NULL, NULL, 0, '2025-12-22 13:10:02', '2025-12-22 17:16:18', 49, 95, 4.40, 'from-gray-700', 'to-gray-800', 50, 'Hands-on Projects', NULL, 'fab fa-linux', 'Nebatech Team', 10, 0, NULL, 780.00, NULL, NULL),
(54, '868c6c3a-df37-11f0-8b36-f48e38a80c71', 'Ethical Hacking', 'ethical-hacking', 'Learn penetration testing and ethical hacking techniques.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'intermediate', 70, NULL, NULL, 'published', 'approved', 'both', 0, 8, NULL, NULL, NULL, 0, '2025-12-22 13:10:02', '2025-12-22 17:16:18', 47, 95, 4.70, 'from-green-600', 'to-green-700', 80, 'Hands-on Projects', NULL, 'fas fa-user-secret', 'Nebatech Team', 32, 0, NULL, 1380.00, NULL, NULL),
(55, '868c6e55-df37-11f0-8b36-f48e38a80c71', 'Web Application Security', 'web-app-security', 'Secure web applications from common vulnerabilities.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'intermediate', 55, NULL, NULL, 'published', 'approved', 'both', 0, 8, NULL, NULL, NULL, 0, '2025-12-22 13:10:02', '2025-12-22 17:16:18', 34, 95, 4.60, 'from-red-600', 'to-red-700', 60, 'Hands-on Projects', NULL, 'fas fa-shield-alt', 'Nebatech Team', 22, 0, NULL, 1050.00, NULL, NULL),
(56, '868c6fc8-df37-11f0-8b36-f48e38a80c71', 'Incident Response & Forensics', 'incident-response-forensics', 'Investigate security incidents and perform forensics.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'advanced', 60, NULL, NULL, 'published', 'approved', 'both', 0, 8, NULL, NULL, NULL, 0, '2025-12-22 13:10:02', '2025-12-22 17:16:18', 64, 95, 4.30, 'from-purple-600', 'to-purple-700', 65, 'Hands-on Projects', NULL, 'fas fa-search', 'Nebatech Team', 33, 0, NULL, 1180.00, NULL, NULL),
(57, '868c70ac-df37-11f0-8b36-f48e38a80c71', 'Security Certifications Prep', 'security-cert-prep', 'Prepare for CompTIA Security+, CEH, and more.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'advanced', 40, NULL, NULL, 'published', 'approved', 'both', 0, 8, NULL, NULL, NULL, 0, '2025-12-22 13:10:02', '2025-12-22 17:16:18', 38, 95, 4.80, 'from-yellow-600', 'to-yellow-700', 45, 'Hands-on Projects', NULL, 'fas fa-certificate', 'Nebatech Team', 21, 0, NULL, 750.00, NULL, NULL),
(58, '8692fcb1-df37-11f0-8b36-f48e38a80c71', 'Cloud Fundamentals', 'cloud-fundamentals', 'Understand cloud computing concepts and services.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'beginner', 40, NULL, NULL, 'published', 'approved', 'both', 0, 9, NULL, NULL, NULL, 0, '2025-12-22 13:10:02', '2025-12-22 17:16:18', 81, 95, 4.40, 'from-blue-500', 'to-blue-600', 45, 'Hands-on Projects', NULL, 'fas fa-cloud', 'Nebatech Team', 33, 0, NULL, 720.00, NULL, NULL),
(59, '869312c6-df37-11f0-8b36-f48e38a80c71', 'AWS Core Services', 'aws-core-services', 'Master essential AWS services like EC2, S3, RDS.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'intermediate', 65, NULL, NULL, 'published', 'approved', 'both', 0, 9, NULL, NULL, NULL, 0, '2025-12-22 13:10:02', '2025-12-22 17:16:18', 88, 95, 4.80, 'from-orange-500', 'to-orange-600', 75, 'Hands-on Projects', NULL, 'fab fa-aws', 'Nebatech Team', 52, 0, NULL, 1280.00, NULL, NULL),
(60, '869314a2-df37-11f0-8b36-f48e38a80c71', 'Docker & Containers', 'docker-containers', 'Containerize applications with Docker.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'intermediate', 50, NULL, NULL, 'published', 'approved', 'both', 0, 9, NULL, NULL, NULL, 0, '2025-12-22 13:10:02', '2025-12-22 17:16:18', 67, 95, 4.60, 'from-blue-600', 'to-blue-700', 55, 'Hands-on Projects', NULL, 'fab fa-docker', 'Nebatech Team', 32, 0, NULL, 950.00, NULL, NULL),
(61, '8693161a-df37-11f0-8b36-f48e38a80c71', 'Kubernetes Orchestration', 'kubernetes-orchestration', 'Orchestrate containers at scale with Kubernetes.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'advanced', 60, NULL, NULL, 'published', 'approved', 'both', 0, 9, NULL, NULL, NULL, 0, '2025-12-22 13:10:02', '2025-12-22 17:16:18', 92, 95, 4.40, 'from-blue-700', 'to-blue-800', 65, 'Hands-on Projects', NULL, 'fas fa-dharmachakra', 'Nebatech Team', 16, 0, NULL, 1180.00, NULL, NULL),
(62, '869316ea-df37-11f0-8b36-f48e38a80c71', 'Infrastructure as Code', 'infrastructure-as-code', 'Manage infrastructure with Terraform and CloudFormation.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'advanced', 55, NULL, NULL, 'published', 'approved', 'both', 0, 9, NULL, NULL, NULL, 0, '2025-12-22 13:10:02', '2025-12-22 17:16:18', 30, 95, 4.50, 'from-purple-600', 'to-purple-700', 60, 'Hands-on Projects', NULL, 'fas fa-code', 'Nebatech Team', 54, 0, NULL, 1080.00, NULL, NULL),
(63, '869317af-df37-11f0-8b36-f48e38a80c71', 'Cloud Architecture & Design', 'cloud-architecture-design', 'Design scalable and resilient cloud solutions.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'advanced', 50, NULL, NULL, 'published', 'approved', 'both', 0, 9, NULL, NULL, NULL, 0, '2025-12-22 13:10:02', '2025-12-22 17:16:18', 73, 95, 4.70, 'from-green-600', 'to-green-700', 55, 'Hands-on Projects', NULL, 'fas fa-sitemap', 'Nebatech Team', 27, 0, NULL, 980.00, NULL, NULL),
(64, '869680a2-df37-11f0-8b36-f48e38a80c71', 'SQL Fundamentals', 'sql-fundamentals', 'Learn SQL basics for querying and managing data.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'beginner', 30, NULL, NULL, 'published', 'approved', 'both', 0, 4, NULL, NULL, NULL, 0, '2025-12-22 13:10:02', '2025-12-22 17:16:18', 78, 95, 4.70, 'from-blue-500', 'to-blue-600', 35, 'Hands-on Projects', NULL, 'fas fa-database', 'Nebatech Team', 53, 0, NULL, 520.00, NULL, NULL),
(65, '869695f3-df37-11f0-8b36-f48e38a80c71', 'Database Design Principles', 'database-design-principles', 'Design normalized and efficient database schemas.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'intermediate', 35, NULL, NULL, 'published', 'approved', 'both', 0, 4, NULL, NULL, NULL, 0, '2025-12-22 13:10:02', '2025-12-22 17:16:18', 58, 95, 4.80, 'from-green-600', 'to-green-700', 40, 'Hands-on Projects', NULL, 'fas fa-project-diagram', 'Nebatech Team', 40, 0, NULL, 620.00, NULL, NULL),
(66, '86969722-df37-11f0-8b36-f48e38a80c71', 'MySQL Administration', 'mysql-administration', 'Manage and optimize MySQL databases.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'intermediate', 40, NULL, NULL, 'published', 'approved', 'both', 0, 4, NULL, NULL, NULL, 0, '2025-12-22 13:10:02', '2025-12-22 17:16:18', 66, 95, 4.40, 'from-blue-700', 'to-blue-800', 45, 'Hands-on Projects', NULL, 'fas fa-server', 'Nebatech Team', 52, 0, NULL, 720.00, NULL, NULL),
(67, '869697f8-df37-11f0-8b36-f48e38a80c71', 'MongoDB NoSQL', 'mongodb-nosql', 'Work with document databases using MongoDB.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'intermediate', 35, NULL, NULL, 'published', 'approved', 'both', 0, 4, NULL, NULL, NULL, 0, '2025-12-22 13:10:02', '2025-12-22 17:16:18', 92, 95, 4.90, 'from-green-500', 'to-green-600', 40, 'Hands-on Projects', NULL, 'fas fa-leaf', 'Nebatech Team', 11, 0, NULL, 650.00, NULL, NULL),
(68, '869d2671-df37-11f0-8b36-f48e38a80c71', 'Network Fundamentals', 'network-fundamentals', 'Learn OSI model, TCP/IP, and networking basics.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'beginner', 30, NULL, NULL, 'published', 'approved', 'both', 0, 10, NULL, NULL, NULL, 0, '2025-12-22 13:10:02', '2025-12-22 17:16:18', 46, 95, 4.60, 'from-blue-500', 'to-blue-600', 35, 'Hands-on Projects', NULL, 'fas fa-network-wired', 'Nebatech Team', 53, 0, NULL, 520.00, NULL, NULL),
(69, '869d395b-df37-11f0-8b36-f48e38a80c71', 'Router & Switch Configuration', 'router-switch-config', 'Configure Cisco routers and switches.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'intermediate', 40, NULL, NULL, 'published', 'approved', 'both', 0, 10, NULL, NULL, NULL, 0, '2025-12-22 13:10:02', '2025-12-22 17:16:18', 67, 95, 4.50, 'from-blue-700', 'to-blue-800', 45, 'Hands-on Projects', NULL, 'fas fa-server', 'Nebatech Team', 17, 0, NULL, 720.00, NULL, NULL),
(70, '869d3a8e-df37-11f0-8b36-f48e38a80c71', 'Network Security Basics', 'network-security-basics', 'Implement firewalls and security policies.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'intermediate', 35, NULL, NULL, 'published', 'approved', 'both', 0, 10, NULL, NULL, NULL, 0, '2025-12-22 13:10:02', '2025-12-22 17:16:18', 64, 95, 4.50, 'from-red-600', 'to-red-700', 40, 'Hands-on Projects', NULL, 'fas fa-shield-alt', 'Nebatech Team', 20, 0, NULL, 650.00, NULL, NULL),
(71, '86a25915-df37-11f0-8b36-f48e38a80c71', 'Computer Components', 'computer-components', 'Understand CPUs, RAM, storage, and peripherals.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'beginner', 20, NULL, NULL, 'published', 'approved', 'both', 0, 11, NULL, NULL, NULL, 0, '2025-12-22 13:10:02', '2025-12-22 17:16:18', 92, 95, 4.90, 'from-gray-600', 'to-gray-700', 25, 'Hands-on Projects', NULL, 'fas fa-microchip', 'Nebatech Team', 53, 0, NULL, 350.00, NULL, NULL),
(72, '86a595d5-df37-11f0-8b36-f48e38a80c71', 'PC Assembly & Building', 'pc-assembly-building', 'Build computers from scratch.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'intermediate', 25, NULL, NULL, 'published', 'approved', 'both', 0, 11, NULL, NULL, NULL, 0, '2025-12-22 13:10:02', '2025-12-22 17:16:18', 67, 95, 4.50, 'from-blue-600', 'to-blue-700', 30, 'Hands-on Projects', NULL, 'fas fa-desktop', 'Nebatech Team', 59, 0, NULL, 450.00, NULL, NULL),
(73, '86a59811-df37-11f0-8b36-f48e38a80c71', 'Hardware Troubleshooting', 'hardware-troubleshooting', 'Diagnose and repair hardware issues.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'intermediate', 30, NULL, NULL, 'published', 'approved', 'both', 0, 11, NULL, NULL, NULL, 0, '2025-12-22 13:10:02', '2025-12-22 17:16:18', 89, 95, 4.50, 'from-red-600', 'to-red-700', 35, 'Hands-on Projects', NULL, 'fas fa-tools', 'Nebatech Team', 26, 0, NULL, 520.00, NULL, NULL),
(74, '86aad7f1-df37-11f0-8b36-f48e38a80c71', 'Computer Basics', 'computer-basics', 'Learn to use a computer and operating systems.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'beginner', 15, NULL, NULL, 'published', 'approved', 'both', 0, 12, NULL, NULL, NULL, 0, '2025-12-22 13:10:02', '2025-12-22 17:16:18', 57, 95, 4.50, 'from-blue-500', 'to-blue-600', 20, 'Hands-on Projects', NULL, 'fas fa-desktop', 'Nebatech Team', 34, 0, NULL, 250.00, NULL, NULL),
(75, '86ad5d15-df37-11f0-8b36-f48e38a80c71', 'Internet & Email', 'internet-email', 'Browse the web and use email effectively.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'beginner', 12, NULL, NULL, 'published', 'approved', 'both', 0, 12, NULL, NULL, NULL, 0, '2025-12-22 13:10:02', '2025-12-22 17:16:18', 44, 95, 4.40, 'from-green-500', 'to-green-600', 15, 'Hands-on Projects', NULL, 'fas fa-globe', 'Nebatech Team', 35, 0, NULL, 200.00, NULL, NULL),
(76, '86ad6001-df37-11f0-8b36-f48e38a80c71', 'Online Safety & Privacy', 'online-safety-privacy', 'Stay safe online and protect your privacy.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'beginner', 15, NULL, NULL, 'published', 'approved', 'both', 0, 12, NULL, NULL, NULL, 0, '2025-12-22 13:10:02', '2025-12-22 17:16:18', 40, 95, 4.80, 'from-red-600', 'to-red-700', 18, 'Hands-on Projects', NULL, 'fas fa-shield-alt', 'Nebatech Team', 11, 0, NULL, 280.00, NULL, NULL),
(77, '86b34df1-df37-11f0-8b36-f48e38a80c71', 'Design Fundamentals', 'design-fundamentals', 'Learn color theory, typography, and composition.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'beginner', 25, NULL, NULL, 'published', 'approved', 'both', 0, 13, NULL, NULL, NULL, 0, '2025-12-22 13:10:02', '2025-12-22 17:16:18', 92, 95, 4.50, 'from-pink-500', 'to-pink-600', 30, 'Hands-on Projects', NULL, 'fas fa-palette', 'Nebatech Team', 28, 0, NULL, 420.00, NULL, NULL),
(78, '86b35e78-df37-11f0-8b36-f48e38a80c71', 'Adobe Photoshop Mastery', 'photoshop-mastery', 'Master photo editing and manipulation.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'intermediate', 40, NULL, NULL, 'published', 'approved', 'both', 0, 13, NULL, NULL, NULL, 0, '2025-12-22 13:10:02', '2025-12-22 17:16:18', 64, 95, 4.70, 'from-blue-600', 'to-blue-700', 48, 'Hands-on Projects', NULL, 'fab fa-adobe', 'Nebatech Team', 50, 0, NULL, 750.00, NULL, NULL),
(79, '86b36074-df37-11f0-8b36-f48e38a80c71', 'Adobe Illustrator', 'adobe-illustrator', 'Create vector graphics and illustrations.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'intermediate', 35, NULL, NULL, 'published', 'approved', 'both', 0, 13, NULL, NULL, NULL, 0, '2025-12-22 13:10:02', '2025-12-22 17:16:18', 97, 95, 4.60, 'from-orange-500', 'to-orange-600', 42, 'Hands-on Projects', NULL, 'fas fa-bezier-curve', 'Nebatech Team', 20, 0, NULL, 680.00, NULL, NULL),
(80, '86b3622d-df37-11f0-8b36-f48e38a80c71', 'Brand Identity Design', 'brand-identity-design', 'Design logos and complete brand identities.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'advanced', 30, NULL, NULL, 'published', 'approved', 'both', 0, 13, NULL, NULL, NULL, 0, '2025-12-22 13:10:02', '2025-12-22 17:16:18', 81, 95, 4.40, 'from-purple-600', 'to-purple-700', 35, 'Hands-on Projects', NULL, 'fas fa-id-card', 'Nebatech Team', 48, 0, NULL, 580.00, NULL, NULL),
(81, '86b9e8d2-df37-11f0-8b36-f48e38a80c71', 'Video Editing Basics', 'video-editing-basics', 'Learn video editing fundamentals and workflows.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'beginner', 25, NULL, NULL, 'published', 'approved', 'both', 0, 14, NULL, NULL, NULL, 0, '2025-12-22 13:10:02', '2025-12-22 17:16:18', 39, 95, 4.80, 'from-red-500', 'to-red-600', 30, 'Hands-on Projects', NULL, 'fas fa-video', 'Nebatech Team', 45, 0, NULL, 420.00, NULL, NULL),
(82, '86b9fab1-df37-11f0-8b36-f48e38a80c71', 'Adobe Premiere Pro', 'adobe-premiere-pro', 'Edit videos professionally with Premiere Pro.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'intermediate', 45, NULL, NULL, 'published', 'approved', 'both', 0, 14, NULL, NULL, NULL, 0, '2025-12-22 13:10:02', '2025-12-22 17:16:18', 91, 95, 4.50, 'from-purple-600', 'to-purple-700', 52, 'Hands-on Projects', NULL, 'fab fa-adobe', 'Nebatech Team', 54, 0, NULL, 850.00, NULL, NULL),
(83, '86b9fbe4-df37-11f0-8b36-f48e38a80c71', 'Color Grading & Effects', 'color-grading-effects', 'Master color correction and visual effects.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'intermediate', 35, NULL, NULL, 'published', 'approved', 'both', 0, 14, NULL, NULL, NULL, 0, '2025-12-22 13:10:02', '2025-12-22 17:16:18', 61, 95, 4.80, 'from-blue-600', 'to-blue-700', 40, 'Hands-on Projects', NULL, 'fas fa-adjust', 'Nebatech Team', 10, 0, NULL, 680.00, NULL, NULL),
(84, '86b9fcd3-df37-11f0-8b36-f48e38a80c71', 'Motion Graphics & After Effects', 'motion-graphics', 'Create stunning motion graphics and animations.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'advanced', 50, NULL, NULL, 'published', 'approved', 'both', 0, 14, NULL, NULL, NULL, 0, '2025-12-22 13:10:02', '2025-12-22 17:16:18', 47, 95, 4.70, 'from-indigo-600', 'to-indigo-700', 58, 'Hands-on Projects', NULL, 'fas fa-magic', 'Nebatech Team', 23, 0, NULL, 980.00, NULL, NULL),
(85, '86bf37ec-df37-11f0-8b36-f48e38a80c71', 'Microsoft Word Mastery', 'microsoft-word-mastery', 'Create professional documents with Word.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'beginner', 20, NULL, NULL, 'published', 'approved', 'both', 0, 15, NULL, NULL, NULL, 0, '2025-12-22 13:10:02', '2025-12-22 17:16:18', 48, 95, 4.90, 'from-blue-600', 'to-blue-700', 25, 'Hands-on Projects', NULL, 'fas fa-file-word', 'Nebatech Team', 55, 0, NULL, 350.00, NULL, NULL),
(86, '86bf4e9f-df37-11f0-8b36-f48e38a80c71', 'Microsoft Excel Complete', 'microsoft-excel-complete', 'Master spreadsheets, formulas, and data analysis.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'intermediate', 40, NULL, NULL, 'published', 'approved', 'both', 0, 15, NULL, NULL, NULL, 0, '2025-12-22 13:10:02', '2025-12-22 17:16:18', 63, 95, 4.30, 'from-green-600', 'to-green-700', 48, 'Hands-on Projects', NULL, 'fas fa-file-excel', 'Nebatech Team', 31, 0, NULL, 750.00, NULL, NULL),
(87, '86bf4fda-df37-11f0-8b36-f48e38a80c71', 'Microsoft PowerPoint', 'microsoft-powerpoint', 'Design impactful presentations.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'beginner', 18, NULL, NULL, 'published', 'approved', 'both', 0, 15, NULL, NULL, NULL, 0, '2025-12-22 13:10:02', '2025-12-22 17:16:18', 31, 95, 4.50, 'from-orange-600', 'to-orange-700', 22, 'Hands-on Projects', NULL, 'fas fa-file-powerpoint', 'Nebatech Team', 40, 0, NULL, 320.00, NULL, NULL),
(88, '86bf5138-df37-11f0-8b36-f48e38a80c71', 'Microsoft Outlook & Teams', 'microsoft-outlook-teams', 'Manage email and collaborate with Teams.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'beginner', 15, NULL, NULL, 'published', 'approved', 'both', 0, 15, NULL, NULL, NULL, 0, '2025-12-22 13:10:02', '2025-12-22 17:16:18', 86, 95, 4.50, 'from-blue-500', 'to-blue-600', 18, 'Hands-on Projects', NULL, 'fas fa-envelope', 'Nebatech Team', 17, 0, NULL, 280.00, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `course_categories`
--

CREATE TABLE `course_categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `color` varchar(50) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course_categories`
--

INSERT INTO `course_categories` (`id`, `name`, `slug`, `description`, `icon`, `color`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Frontend Development', 'frontend', 'User interface and client-side development', 'code', '#3B82F6', 1, 1, '2025-11-12 14:48:10', '2025-11-12 14:48:10'),
(2, 'Backend Development', 'backend', 'Server-side development and APIs', 'server', '#10B981', 2, 1, '2025-11-12 14:48:10', '2025-11-12 14:48:10'),
(3, 'Full Stack Development', 'fullstack', 'Complete web application development', 'layers', '#8B5CF6', 3, 1, '2025-11-12 14:48:10', '2025-11-12 14:48:10'),
(4, 'Mobile Development', 'mobile', 'iOS and Android application development', 'smartphone', '#F59E0B', 4, 1, '2025-11-12 14:48:10', '2025-11-12 14:48:10'),
(5, 'AI & Machine Learning', 'ai', 'Artificial Intelligence and Machine Learning', 'brain', '#EF4444', 5, 1, '2025-11-12 14:48:10', '2025-11-12 14:48:10'),
(6, 'Data Science', 'data-science', 'Data analysis and visualization', 'bar-chart', '#06B6D4', 6, 1, '2025-11-12 14:48:10', '2025-11-12 14:48:10'),
(7, 'Cybersecurity', 'cybersecurity', 'Information security and ethical hacking', 'shield', '#DC2626', 7, 1, '2025-11-12 14:48:10', '2025-11-12 14:48:10'),
(8, 'Cloud Computing', 'cloud', 'Cloud platforms and infrastructure', 'cloud', '#7C3AED', 8, 1, '2025-11-12 14:48:10', '2025-11-12 14:48:10'),
(9, 'Database Administration', 'database', 'Database design and management', 'database', '#059669', 9, 1, '2025-11-12 14:48:10', '2025-11-12 14:48:10'),
(10, 'Digital Literacy', 'digital-literacy', 'Basic computer and digital skills', 'monitor', '#6B7280', 10, 1, '2025-11-12 14:48:10', '2025-11-12 14:48:10');

-- --------------------------------------------------------

--
-- Stand-in structure for view `course_progress_summary`
-- (See below for the actual view)
--
CREATE TABLE `course_progress_summary` (
`enrollment_id` int(10) unsigned
,`user_id` int(10) unsigned
,`course_id` int(10) unsigned
,`course_title` varchar(255)
,`total_lessons` bigint(21)
,`completed_lessons` bigint(21)
,`total_modules` bigint(21)
,`overall_progress_percentage` decimal(26,2)
,`total_time_spent_seconds` decimal(32,0)
,`last_activity` timestamp
,`resume_lesson_id` bigint(10) unsigned
);

-- --------------------------------------------------------

--
-- Table structure for table `cross_promotions`
--

CREATE TABLE `cross_promotions` (
  `id` int(10) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `cta_text` varchar(100) NOT NULL,
  `cta_url` varchar(255) NOT NULL,
  `target_section` enum('academy','corporate','both') NOT NULL,
  `target_user_type` enum('visitor','student','client','all') NOT NULL,
  `display_type` enum('banner','sidebar','modal','inline') NOT NULL,
  `color_scheme` varchar(50) DEFAULT 'blue',
  `priority` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `discussion_bookmarks`
--

CREATE TABLE `discussion_bookmarks` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `post_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `discussion_categories`
--

CREATE TABLE `discussion_categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `color` varchar(20) DEFAULT NULL,
  `parent_id` int(10) UNSIGNED DEFAULT NULL,
  `course_id` int(10) UNSIGNED DEFAULT NULL,
  `order_index` int(10) UNSIGNED DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `discussion_categories`
--

INSERT INTO `discussion_categories` (`id`, `name`, `slug`, `description`, `icon`, `color`, `parent_id`, `course_id`, `order_index`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'General', 'general', 'General discussions about tech, learning, and the academy', '', 'blue', NULL, NULL, 1, 1, '2025-11-23 01:16:23', '2025-11-23 01:16:23'),
(2, 'Q&A', 'qa', 'Ask and answer technical questions', '', 'purple', NULL, NULL, 2, 1, '2025-11-23 01:16:23', '2025-11-23 01:16:23'),
(3, 'Career & Jobs', 'career-jobs', 'Career advice, job opportunities, and networking', '', 'green', NULL, NULL, 3, 1, '2025-11-23 01:16:23', '2025-11-23 01:16:23'),
(4, 'Projects Showcase', 'projects-showcase', 'Share your projects and get feedback', '', 'orange', NULL, NULL, 4, 1, '2025-11-23 01:16:23', '2025-11-23 01:16:23'),
(5, 'Resources', 'resources', 'Share useful learning resources, tutorials, and tools', '', 'indigo', NULL, NULL, 5, 1, '2025-11-23 01:16:23', '2025-11-23 01:16:23'),
(6, 'Announcements', 'announcements', 'Official announcements from the academy', '', 'red', NULL, NULL, 6, 1, '2025-11-23 01:16:23', '2025-11-23 01:16:23');

-- --------------------------------------------------------

--
-- Table structure for table `discussion_comments`
--

CREATE TABLE `discussion_comments` (
  `id` int(10) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `post_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `parent_id` int(10) UNSIGNED DEFAULT NULL,
  `content` text NOT NULL,
  `is_solution` tinyint(1) DEFAULT 0,
  `likes_count` int(10) UNSIGNED DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `discussion_likes`
--

CREATE TABLE `discussion_likes` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `likeable_type` enum('post','comment') NOT NULL,
  `likeable_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `discussion_posts`
--

CREATE TABLE `discussion_posts` (
  `id` int(10) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `course_id` int(10) UNSIGNED DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `type` enum('question','discussion','announcement','resource','project') DEFAULT 'discussion',
  `tags` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`tags`)),
  `is_pinned` tinyint(1) DEFAULT 0,
  `is_locked` tinyint(1) DEFAULT 0,
  `is_solved` tinyint(1) DEFAULT 0,
  `views_count` int(10) UNSIGNED DEFAULT 0,
  `likes_count` int(10) UNSIGNED DEFAULT 0,
  `comments_count` int(10) UNSIGNED DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `last_activity_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `draft_posts`
--

CREATE TABLE `draft_posts` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `type` enum('discussion','blog','question','resource') NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `category_id` int(10) UNSIGNED DEFAULT NULL,
  `tags` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`tags`)),
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Additional draft data' CHECK (json_valid(`metadata`)),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `email_logs`
--

CREATE TABLE `email_logs` (
  `id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL COMMENT 'Type of email (application_received, application_approved, etc.)',
  `recipient` varchar(255) NOT NULL COMMENT 'Email recipient',
  `status` enum('sent','failed') DEFAULT 'sent' COMMENT 'Delivery status',
  `error_message` text DEFAULT NULL COMMENT 'Error message if failed',
  `sent_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'When email was sent'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Tracks all email notifications sent by the system';

--
-- Dumping data for table `email_logs`
--

INSERT INTO `email_logs` (`id`, `type`, `recipient`, `status`, `error_message`, `sent_at`) VALUES
(1, 'welcome_new_user', 'facilitator@gmail.com', 'sent', NULL, '2025-11-10 10:32:32'),
(2, 'email_verification', 'facilitator@gmail.com', 'sent', NULL, '2025-11-10 10:32:37'),
(3, 'application_approved', 'student@gmail.com', 'failed', 'SMTP Error: Could not connect to SMTP host. Failed to connect to server', '2025-11-12 17:14:53'),
(4, 'welcome', 'student@gmail.com', 'failed', 'SMTP Error: Could not connect to SMTP host. Failed to connect to server', '2025-11-12 17:15:05'),
(5, 'certificate_issued', 'student@gmail.com', 'sent', NULL, '2025-11-12 17:25:44');

-- --------------------------------------------------------

--
-- Table structure for table `email_verifications`
--

CREATE TABLE `email_verifications` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `token` varchar(64) NOT NULL,
  `expires_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `verified_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `email_verifications`
--

INSERT INTO `email_verifications` (`id`, `user_id`, `token`, `expires_at`, `verified_at`, `created_at`) VALUES
(1, 1, 'fd1c627b749145faba2567a50ca987d65f4abde5f01e85bd2707827c04572c31', '2025-11-11 10:32:32', NULL, '2025-11-10 09:32:32');

-- --------------------------------------------------------

--
-- Table structure for table `enrollments`
--

CREATE TABLE `enrollments` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `course_id` int(10) UNSIGNED NOT NULL,
  `status` enum('active','suspended','completed','cancelled','dropped') DEFAULT 'active',
  `progress` decimal(5,2) DEFAULT 0.00,
  `enrolled_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `completed_at` timestamp NULL DEFAULT NULL,
  `cohort_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `enrollments`
--

INSERT INTO `enrollments` (`id`, `user_id`, `course_id`, `status`, `progress`, `enrolled_at`, `completed_at`, `cohort_id`) VALUES
(3, 10, 1, 'active', 0.00, '2025-12-24 15:55:45', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `event_rsvps`
--

CREATE TABLE `event_rsvps` (
  `id` int(10) UNSIGNED NOT NULL,
  `event_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `status` enum('going','maybe','not_going') DEFAULT 'going',
  `attended` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `learning_goals`
--

CREATE TABLE `learning_goals` (
  `id` int(10) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `goal_type` enum('daily_time','weekly_lessons','course_completion','skill_mastery','custom') NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `target_value` decimal(10,2) NOT NULL,
  `current_value` decimal(10,2) DEFAULT 0.00,
  `unit` varchar(50) DEFAULT NULL,
  `start_date` date NOT NULL,
  `target_date` date NOT NULL,
  `completed_date` date DEFAULT NULL,
  `status` enum('active','completed','abandoned','paused') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `learning_objectives`
--

CREATE TABLE `learning_objectives` (
  `id` int(11) NOT NULL,
  `lesson_id` int(11) NOT NULL,
  `objective_number` int(11) NOT NULL DEFAULT 1,
  `objective_text` text NOT NULL,
  `bloom_level` enum('remember','understand','apply','analyze','evaluate','create') DEFAULT 'understand',
  `is_key_competency` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `learning_streaks`
--

CREATE TABLE `learning_streaks` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `current_streak_days` int(10) UNSIGNED DEFAULT 0,
  `longest_streak_days` int(10) UNSIGNED DEFAULT 0,
  `total_learning_days` int(10) UNSIGNED DEFAULT 0,
  `last_activity_date` date DEFAULT NULL,
  `streak_start_date` date DEFAULT NULL,
  `total_lessons_completed` int(10) UNSIGNED DEFAULT 0,
  `total_time_spent_seconds` bigint(20) UNSIGNED DEFAULT 0,
  `average_daily_minutes` decimal(8,2) DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lessons`
--

CREATE TABLE `lessons` (
  `id` int(10) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `module_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `type` enum('text','video','code','quiz','project') DEFAULT 'text',
  `content` longtext DEFAULT NULL,
  `order_index` int(10) UNSIGNED DEFAULT 0,
  `duration_minutes` int(10) UNSIGNED DEFAULT NULL,
  `resources` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`resources`)),
  `ai_generated` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `has_practical` tinyint(1) DEFAULT 0,
  `has_quiz` tinyint(1) DEFAULT 0,
  `competency_weight` int(11) DEFAULT 1,
  `estimated_time_minutes` int(11) DEFAULT 30
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lessons`
--

INSERT INTO `lessons` (`id`, `uuid`, `module_id`, `title`, `type`, `content`, `order_index`, `duration_minutes`, `resources`, `ai_generated`, `created_at`, `updated_at`, `has_practical`, `has_quiz`, `competency_weight`, `estimated_time_minutes`) VALUES
(3255, 'cd343936-3959-4ee1-ba1c-c9ea93b02a90', 833, 'What is Web Development?', 'text', '<h2>What is Web Development?</h2><p>This lesson covers What is Web Development? in the context of Introduction to Web Development.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of What is Web Development?</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 22, NULL, 0, '2025-12-24 17:05:07', '2025-12-24 17:05:07', 0, 0, 1, 30),
(3256, '146e356f-c9f8-4c7b-a102-3ee12a348aeb', 833, 'How the Internet Works', 'text', '<h2>How the Internet Works</h2><p>This lesson covers How the Internet Works in the context of Introduction to Web Development.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of How the Internet Works</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 30, NULL, 0, '2025-12-24 17:05:07', '2025-12-24 17:05:07', 0, 0, 1, 30),
(3257, 'bcaf440b-4e16-41fe-a8a1-a5f49caa90ea', 833, 'Web Browsers and Rendering', 'text', '<h2>Web Browsers and Rendering</h2><p>This lesson covers Web Browsers and Rendering in the context of Introduction to Web Development.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Web Browsers and Rendering</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 28, NULL, 0, '2025-12-24 17:05:07', '2025-12-24 17:05:07', 0, 0, 1, 30),
(3258, '350fe5d2-8afe-46ae-a0d7-0a0e233222d8', 833, 'Developer Tools Overview', 'text', '<h2>Developer Tools Overview</h2><p>This lesson covers Developer Tools Overview in the context of Introduction to Web Development.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Developer Tools Overview</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 34, NULL, 0, '2025-12-24 17:05:07', '2025-12-24 17:05:07', 0, 0, 1, 30),
(3259, '6e02ba7c-86b5-48d8-9c9a-258549518790', 834, 'HTML Document Structure', 'text', '<h2>HTML Document Structure</h2><p>This lesson covers HTML Document Structure in the context of HTML Fundamentals.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of HTML Document Structure</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 39, NULL, 0, '2025-12-24 17:05:07', '2025-12-24 17:05:07', 0, 0, 1, 30),
(3260, '5b833627-8808-460b-9fa3-fdf990a47dfa', 834, 'Text Elements and Formatting', 'text', '<h2>Text Elements and Formatting</h2><p>This lesson covers Text Elements and Formatting in the context of HTML Fundamentals.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Text Elements and Formatting</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 17, NULL, 0, '2025-12-24 17:05:08', '2025-12-24 17:05:08', 0, 0, 1, 30),
(3261, '051de8ca-8826-45ab-b730-b5bf7ba8d152', 834, 'Links and Navigation', 'text', '<h2>Links and Navigation</h2><p>This lesson covers Links and Navigation in the context of HTML Fundamentals.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Links and Navigation</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 39, NULL, 0, '2025-12-24 17:05:08', '2025-12-24 17:05:08', 0, 0, 1, 30),
(3262, '27637efd-6b2d-4d65-b049-ab6217412cf6', 834, 'Images and Multimedia', 'text', '<h2>Images and Multimedia</h2><p>This lesson covers Images and Multimedia in the context of HTML Fundamentals.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Images and Multimedia</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 17, NULL, 0, '2025-12-24 17:05:08', '2025-12-24 17:05:08', 0, 0, 1, 30),
(3263, '94a8db12-53ab-42bc-9b60-ddd86028b687', 835, 'Form Elements', 'text', '<h2>Form Elements</h2><p>This lesson covers Form Elements in the context of HTML Forms and Tables.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Form Elements</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 16, NULL, 0, '2025-12-24 17:05:08', '2025-12-24 17:05:08', 0, 0, 1, 30),
(3264, 'e6f0af90-a144-4e25-82d8-4bf1dcd58972', 835, 'Input Types and Validation', 'text', '<h2>Input Types and Validation</h2><p>This lesson covers Input Types and Validation in the context of HTML Forms and Tables.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Input Types and Validation</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 44, NULL, 0, '2025-12-24 17:05:08', '2025-12-24 17:05:08', 0, 0, 1, 30),
(3265, 'e8c1c190-1e3b-47fb-a9ad-508009c2273c', 835, 'Tables and Data Display', 'text', '<h2>Tables and Data Display</h2><p>This lesson covers Tables and Data Display in the context of HTML Forms and Tables.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Tables and Data Display</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 34, NULL, 0, '2025-12-24 17:05:08', '2025-12-24 17:05:08', 0, 0, 1, 30),
(3266, '5b5dccc6-458a-4ed4-809c-2b854e051962', 835, 'Semantic HTML5', 'text', '<h2>Semantic HTML5</h2><p>This lesson covers Semantic HTML5 in the context of HTML Forms and Tables.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Semantic HTML5</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 32, NULL, 0, '2025-12-24 17:05:08', '2025-12-24 17:05:08', 0, 0, 1, 30),
(3267, 'd1de160d-6aa5-413e-b076-9f6977ef76af', 836, 'CSS Syntax and Selectors', 'text', '<h2>CSS Syntax and Selectors</h2><p>This lesson covers CSS Syntax and Selectors in the context of CSS Basics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of CSS Syntax and Selectors</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 22, NULL, 0, '2025-12-24 17:05:08', '2025-12-24 17:05:08', 0, 0, 1, 30),
(3268, 'b1c38022-a7e1-486b-81c2-4dc531c4613b', 836, 'Colors and Typography', 'text', '<h2>Colors and Typography</h2><p>This lesson covers Colors and Typography in the context of CSS Basics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Colors and Typography</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 24, NULL, 0, '2025-12-24 17:05:08', '2025-12-24 17:05:08', 0, 0, 1, 30),
(3269, '06904b36-4a0d-470a-acff-de3d8bc0eee0', 836, 'Box Model', 'text', '<h2>Box Model</h2><p>This lesson covers Box Model in the context of CSS Basics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Box Model</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 20, NULL, 0, '2025-12-24 17:05:08', '2025-12-24 17:05:08', 0, 0, 1, 30),
(3270, '12555919-d93c-4d14-8698-4561b154f850', 836, 'Units and Values', 'text', '<h2>Units and Values</h2><p>This lesson covers Units and Values in the context of CSS Basics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Units and Values</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 23, NULL, 0, '2025-12-24 17:05:08', '2025-12-24 17:05:08', 0, 0, 1, 30),
(3271, '805770d7-3859-4e76-a82c-62759cadbf7d', 837, 'Display Property', 'text', '<h2>Display Property</h2><p>This lesson covers Display Property in the context of CSS Layout.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Display Property</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 23, NULL, 0, '2025-12-24 17:05:08', '2025-12-24 17:05:08', 0, 0, 1, 30),
(3272, '947a8b17-d7c5-4ed2-ba28-3141cf5798f7', 837, 'Positioning', 'text', '<h2>Positioning</h2><p>This lesson covers Positioning in the context of CSS Layout.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Positioning</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 33, NULL, 0, '2025-12-24 17:05:08', '2025-12-24 17:05:08', 0, 0, 1, 30),
(3273, '02623a47-c436-4a3e-b9a1-c6ccebabceaa', 837, 'Float and Clear', 'text', '<h2>Float and Clear</h2><p>This lesson covers Float and Clear in the context of CSS Layout.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Float and Clear</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 43, NULL, 0, '2025-12-24 17:05:08', '2025-12-24 17:05:08', 0, 0, 1, 30),
(3274, '74e9317b-63b0-4470-8d6f-d03cf97371da', 837, 'Overflow and Visibility', 'text', '<h2>Overflow and Visibility</h2><p>This lesson covers Overflow and Visibility in the context of CSS Layout.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Overflow and Visibility</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 19, NULL, 0, '2025-12-24 17:05:09', '2025-12-24 17:05:09', 0, 0, 1, 30),
(3275, '92d3aa72-50ca-4cc5-a3ef-4fe5d7256a15', 838, 'Flex Container Properties', 'text', '<h2>Flex Container Properties</h2><p>This lesson covers Flex Container Properties in the context of Flexbox.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Flex Container Properties</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 44, NULL, 0, '2025-12-24 17:05:09', '2025-12-24 17:05:09', 0, 0, 1, 30),
(3276, '58b95556-2226-4b55-b00b-f0dc6396bb30', 838, 'Flex Item Properties', 'text', '<h2>Flex Item Properties</h2><p>This lesson covers Flex Item Properties in the context of Flexbox.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Flex Item Properties</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 33, NULL, 0, '2025-12-24 17:05:09', '2025-12-24 17:05:09', 0, 0, 1, 30),
(3277, 'd9e0fd0b-d309-4bd7-932d-2b04a06213f5', 838, 'Flexbox Patterns', 'text', '<h2>Flexbox Patterns</h2><p>This lesson covers Flexbox Patterns in the context of Flexbox.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Flexbox Patterns</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 16, NULL, 0, '2025-12-24 17:05:09', '2025-12-24 17:05:09', 0, 0, 1, 30),
(3278, 'd641a3d8-a368-48e4-9fb9-8aad43cbcd83', 838, 'Real-world Flexbox Layouts', 'text', '<h2>Real-world Flexbox Layouts</h2><p>This lesson covers Real-world Flexbox Layouts in the context of Flexbox.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Real-world Flexbox Layouts</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 17, NULL, 0, '2025-12-24 17:05:09', '2025-12-24 17:05:09', 0, 0, 1, 30),
(3279, '28e03dd6-edb3-45b0-b953-981fb1264457', 839, 'Grid Container Basics', 'text', '<h2>Grid Container Basics</h2><p>This lesson covers Grid Container Basics in the context of CSS Grid.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Grid Container Basics</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 45, NULL, 0, '2025-12-24 17:05:09', '2025-12-24 17:05:09', 0, 0, 1, 30),
(3280, '56c6f065-88d0-4499-9e05-ee312079c1fb', 839, 'Grid Lines and Areas', 'text', '<h2>Grid Lines and Areas</h2><p>This lesson covers Grid Lines and Areas in the context of CSS Grid.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Grid Lines and Areas</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 16, NULL, 0, '2025-12-24 17:05:10', '2025-12-24 17:05:10', 0, 0, 1, 30),
(3281, '1abcbd3c-1d03-4356-bf09-dc79e2a25874', 839, 'Grid Template Areas', 'text', '<h2>Grid Template Areas</h2><p>This lesson covers Grid Template Areas in the context of CSS Grid.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Grid Template Areas</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 44, NULL, 0, '2025-12-24 17:05:10', '2025-12-24 17:05:10', 0, 0, 1, 30),
(3282, '190f2b88-6b7a-43d9-a0dc-33e3dc288050', 839, 'Responsive Grid Layouts', 'text', '<h2>Responsive Grid Layouts</h2><p>This lesson covers Responsive Grid Layouts in the context of CSS Grid.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Responsive Grid Layouts</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 34, NULL, 0, '2025-12-24 17:05:10', '2025-12-24 17:05:10', 0, 0, 1, 30),
(3283, 'f48ca325-681e-4f0a-a11d-8752aa9f5169', 840, 'Mobile-First Approach', 'text', '<h2>Mobile-First Approach</h2><p>This lesson covers Mobile-First Approach in the context of Responsive Design.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Mobile-First Approach</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 43, NULL, 0, '2025-12-24 17:05:10', '2025-12-24 17:05:10', 0, 0, 1, 30),
(3284, '04a50242-f220-4b52-9c35-d6d058afcfe5', 840, 'Media Queries', 'text', '<h2>Media Queries</h2><p>This lesson covers Media Queries in the context of Responsive Design.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Media Queries</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 16, NULL, 0, '2025-12-24 17:05:10', '2025-12-24 17:05:10', 0, 0, 1, 30),
(3285, '0fd291c2-22b6-4fc3-87ff-d2b6f1f6d9d6', 840, 'Responsive Images', 'text', '<h2>Responsive Images</h2><p>This lesson covers Responsive Images in the context of Responsive Design.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Responsive Images</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 36, NULL, 0, '2025-12-24 17:05:10', '2025-12-24 17:05:10', 0, 0, 1, 30),
(3286, '4696488b-3b74-4a7a-a092-584ef014c80d', 840, 'Viewport and Breakpoints', 'text', '<h2>Viewport and Breakpoints</h2><p>This lesson covers Viewport and Breakpoints in the context of Responsive Design.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Viewport and Breakpoints</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 24, NULL, 0, '2025-12-24 17:05:10', '2025-12-24 17:05:10', 0, 0, 1, 30),
(3287, 'a65994b6-fe01-436b-8bb1-75eec6623cd9', 841, 'CSS Variables', 'text', '<h2>CSS Variables</h2><p>This lesson covers CSS Variables in the context of CSS Advanced Topics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of CSS Variables</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 42, NULL, 0, '2025-12-24 17:05:10', '2025-12-24 17:05:10', 0, 0, 1, 30),
(3288, 'e155f212-4cf4-48e7-9991-0b7ac63be9b3', 841, 'Transitions', 'text', '<h2>Transitions</h2><p>This lesson covers Transitions in the context of CSS Advanced Topics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Transitions</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 38, NULL, 0, '2025-12-24 17:05:10', '2025-12-24 17:05:10', 0, 0, 1, 30),
(3289, 'cf1a308f-7cf8-4f8e-a5b9-46fb4d51f89d', 841, 'Animations', 'text', '<h2>Animations</h2><p>This lesson covers Animations in the context of CSS Advanced Topics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Animations</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 16, NULL, 0, '2025-12-24 17:05:10', '2025-12-24 17:05:10', 0, 0, 1, 30),
(3290, '85c279fb-9a40-4ec9-a653-48740f8ca27d', 841, 'Transforms', 'text', '<h2>Transforms</h2><p>This lesson covers Transforms in the context of CSS Advanced Topics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Transforms</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 44, NULL, 0, '2025-12-24 17:05:10', '2025-12-24 17:05:10', 0, 0, 1, 30),
(3291, 'c915f663-0269-4f38-8d8a-9fe6db15bf2a', 842, 'Variables and Data Types', 'text', '<h2>Variables and Data Types</h2><p>This lesson covers Variables and Data Types in the context of JavaScript Fundamentals.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Variables and Data Types</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 21, NULL, 0, '2025-12-24 17:05:11', '2025-12-24 17:05:11', 0, 0, 1, 30),
(3292, 'a1e684fc-0031-45ee-a64e-8bb8759c0079', 842, 'Operators and Expressions', 'text', '<h2>Operators and Expressions</h2><p>This lesson covers Operators and Expressions in the context of JavaScript Fundamentals.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Operators and Expressions</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 27, NULL, 0, '2025-12-24 17:05:11', '2025-12-24 17:05:11', 0, 0, 1, 30),
(3293, '58bd3619-f242-4395-9750-e72b1c212fec', 842, 'Control Flow', 'text', '<h2>Control Flow</h2><p>This lesson covers Control Flow in the context of JavaScript Fundamentals.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Control Flow</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 45, NULL, 0, '2025-12-24 17:05:11', '2025-12-24 17:05:11', 0, 0, 1, 30),
(3294, 'f2547414-1f39-46b3-9c92-f5957ed5ec4c', 842, 'Functions', 'text', '<h2>Functions</h2><p>This lesson covers Functions in the context of JavaScript Fundamentals.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Functions</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 40, NULL, 0, '2025-12-24 17:05:11', '2025-12-24 17:05:11', 0, 0, 1, 30),
(3295, '21ccb1ff-5075-46fb-bcb4-e7613bfbd961', 843, 'Selecting Elements', 'text', '<h2>Selecting Elements</h2><p>This lesson covers Selecting Elements in the context of JavaScript DOM Manipulation.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Selecting Elements</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 27, NULL, 0, '2025-12-24 17:05:11', '2025-12-24 17:05:11', 0, 0, 1, 30),
(3296, 'a77bf503-df6d-4b00-b133-d2f99c16d5ba', 843, 'Modifying Content', 'text', '<h2>Modifying Content</h2><p>This lesson covers Modifying Content in the context of JavaScript DOM Manipulation.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Modifying Content</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 31, NULL, 0, '2025-12-24 17:05:11', '2025-12-24 17:05:11', 0, 0, 1, 30),
(3297, 'b0d38930-314f-4d75-99c0-34243e0679b6', 843, 'Event Handling', 'text', '<h2>Event Handling</h2><p>This lesson covers Event Handling in the context of JavaScript DOM Manipulation.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Event Handling</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 18, NULL, 0, '2025-12-24 17:05:11', '2025-12-24 17:05:11', 0, 0, 1, 30),
(3298, '232a6bbc-0088-472a-8ab0-4afce173a30d', 843, 'DOM Traversal', 'text', '<h2>DOM Traversal</h2><p>This lesson covers DOM Traversal in the context of JavaScript DOM Manipulation.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of DOM Traversal</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 31, NULL, 0, '2025-12-24 17:05:11', '2025-12-24 17:05:11', 0, 0, 1, 30),
(3299, 'cef573b0-1caf-4ef8-bd2f-f1e98d15ebf6', 844, 'Arrays and Objects', 'text', '<h2>Arrays and Objects</h2><p>This lesson covers Arrays and Objects in the context of JavaScript Advanced Concepts.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Arrays and Objects</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 32, NULL, 0, '2025-12-24 17:05:12', '2025-12-24 17:05:12', 0, 0, 1, 30),
(3300, '3a03c9d8-ecba-4582-9154-bea85863e33e', 844, 'ES6+ Features', 'text', '<h2>ES6+ Features</h2><p>This lesson covers ES6+ Features in the context of JavaScript Advanced Concepts.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of ES6+ Features</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 18, NULL, 0, '2025-12-24 17:05:12', '2025-12-24 17:05:12', 0, 0, 1, 30),
(3301, '46091f3e-de04-4d98-ba90-7d809316e8e4', 844, 'Async JavaScript', 'text', '<h2>Async JavaScript</h2><p>This lesson covers Async JavaScript in the context of JavaScript Advanced Concepts.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Async JavaScript</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 33, NULL, 0, '2025-12-24 17:05:12', '2025-12-24 17:05:12', 0, 0, 1, 30),
(3302, '5c00de8e-6682-4b50-bd01-43181511411a', 844, 'Error Handling', 'text', '<h2>Error Handling</h2><p>This lesson covers Error Handling in the context of JavaScript Advanced Concepts.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Error Handling</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 26, NULL, 0, '2025-12-24 17:05:12', '2025-12-24 17:05:12', 0, 0, 1, 30),
(3303, '3b7ebf14-ea73-464b-bd86-576d46d40606', 845, 'Why Use Frameworks?', 'text', '<h2>Why Use Frameworks?</h2><p>This lesson covers Why Use Frameworks? in the context of Frontend Frameworks Introduction.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Why Use Frameworks?</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 31, NULL, 0, '2025-12-24 17:05:12', '2025-12-24 17:05:12', 0, 0, 1, 30),
(3304, '14f8f3ad-7866-47d1-98b8-6c901701c182', 845, 'React Overview', 'text', '<h2>React Overview</h2><p>This lesson covers React Overview in the context of Frontend Frameworks Introduction.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of React Overview</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 21, NULL, 0, '2025-12-24 17:05:12', '2025-12-24 17:05:12', 0, 0, 1, 30),
(3305, '86fd66ee-db05-4489-908e-8069fcf23220', 845, 'Vue Overview', 'text', '<h2>Vue Overview</h2><p>This lesson covers Vue Overview in the context of Frontend Frameworks Introduction.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Vue Overview</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 29, NULL, 0, '2025-12-24 17:05:12', '2025-12-24 17:05:12', 0, 0, 1, 30),
(3306, 'be7961f0-7334-495c-b0a9-e84f243472ab', 845, 'Choosing a Framework', 'text', '<h2>Choosing a Framework</h2><p>This lesson covers Choosing a Framework in the context of Frontend Frameworks Introduction.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Choosing a Framework</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 31, NULL, 0, '2025-12-24 17:05:12', '2025-12-24 17:05:12', 0, 0, 1, 30),
(3307, '39d26f20-8e65-47bb-9b98-03c7ab3bd5cd', 846, 'Package Managers (npm/yarn)', 'text', '<h2>Package Managers (npm/yarn)</h2><p>This lesson covers Package Managers (npm/yarn) in the context of Build Tools and Workflow.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Package Managers (npm/yarn)</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 39, NULL, 0, '2025-12-24 17:05:12', '2025-12-24 17:05:12', 0, 0, 1, 30),
(3308, '6773e718-05dd-4098-b85f-ddd59bfbcc25', 846, 'Module Bundlers', 'text', '<h2>Module Bundlers</h2><p>This lesson covers Module Bundlers in the context of Build Tools and Workflow.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Module Bundlers</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 38, NULL, 0, '2025-12-24 17:05:12', '2025-12-24 17:05:12', 0, 0, 1, 30),
(3309, '32a1a834-05e7-4ebe-a5bb-b35a0e3daa7b', 846, 'Task Runners', 'text', '<h2>Task Runners</h2><p>This lesson covers Task Runners in the context of Build Tools and Workflow.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Task Runners</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 42, NULL, 0, '2025-12-24 17:05:12', '2025-12-24 17:05:12', 0, 0, 1, 30),
(3310, '16b43ec1-21d6-4587-a284-bacdca5c64b0', 846, 'Development Servers', 'text', '<h2>Development Servers</h2><p>This lesson covers Development Servers in the context of Build Tools and Workflow.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Development Servers</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 15, NULL, 0, '2025-12-24 17:05:12', '2025-12-24 17:05:12', 0, 0, 1, 30),
(3311, '7b20caed-00f3-4662-87c4-30089a2d7a49', 847, 'Code Organization', 'text', '<h2>Code Organization</h2><p>This lesson covers Code Organization in the context of Frontend Best Practices.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Code Organization</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 40, NULL, 0, '2025-12-24 17:05:13', '2025-12-24 17:05:13', 0, 0, 1, 30),
(3312, '1c800315-a842-441f-86bf-b19e8843d001', 847, 'Performance Optimization', 'text', '<h2>Performance Optimization</h2><p>This lesson covers Performance Optimization in the context of Frontend Best Practices.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Performance Optimization</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 35, NULL, 0, '2025-12-24 17:05:13', '2025-12-24 17:05:13', 0, 0, 1, 30),
(3313, 'e66d5553-0fa9-491b-bc3e-87792af8ebb3', 847, 'Accessibility (a11y)', 'text', '<h2>Accessibility (a11y)</h2><p>This lesson covers Accessibility (a11y) in the context of Frontend Best Practices.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Accessibility (a11y)</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 26, NULL, 0, '2025-12-24 17:05:13', '2025-12-24 17:05:13', 0, 0, 1, 30),
(3314, '1da84d79-64bd-4a34-bbcd-20a1b6573594', 847, 'SEO Basics for Frontend', 'text', '<h2>SEO Basics for Frontend</h2><p>This lesson covers SEO Basics for Frontend in the context of Frontend Best Practices.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of SEO Basics for Frontend</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 32, NULL, 0, '2025-12-24 17:05:13', '2025-12-24 17:05:13', 0, 0, 1, 30),
(3315, '0df4376e-1361-4165-bc09-75882fe88706', 848, 'What is Backend Development?', 'text', '<h2>What is Backend Development?</h2><p>This lesson covers What is Backend Development? in the context of Introduction to Backend Development.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of What is Backend Development?</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 44, NULL, 0, '2025-12-24 17:05:13', '2025-12-24 17:05:13', 0, 0, 1, 30),
(3316, '1a31c5ce-680f-4e56-9b61-29bbf46a3bb7', 848, 'Server Architecture Basics', 'text', '<h2>Server Architecture Basics</h2><p>This lesson covers Server Architecture Basics in the context of Introduction to Backend Development.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Server Architecture Basics</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 42, NULL, 0, '2025-12-24 17:05:13', '2025-12-24 17:05:13', 0, 0, 1, 30),
(3317, '32fb76c1-360f-4c20-9c8b-b140d1120363', 848, 'Client-Server Model', 'text', '<h2>Client-Server Model</h2><p>This lesson covers Client-Server Model in the context of Introduction to Backend Development.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Client-Server Model</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 18, NULL, 0, '2025-12-24 17:05:13', '2025-12-24 17:05:13', 0, 0, 1, 30),
(3318, '43f3f49b-4d04-46ec-9130-9292231c53fa', 848, 'HTTP Protocol', 'text', '<h2>HTTP Protocol</h2><p>This lesson covers HTTP Protocol in the context of Introduction to Backend Development.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of HTTP Protocol</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 38, NULL, 0, '2025-12-24 17:05:13', '2025-12-24 17:05:13', 0, 0, 1, 30),
(3319, 'c4df8c0b-66ec-4f23-bcd1-0df5f65334a6', 849, 'PHP Introduction', 'text', '<h2>PHP Introduction</h2><p>This lesson covers PHP Introduction in the context of Backend Languages Overview.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of PHP Introduction</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 23, NULL, 0, '2025-12-24 17:05:13', '2025-12-24 17:05:13', 0, 0, 1, 30),
(3320, '10a7a456-d555-44fa-9806-510e363f8061', 849, 'Python for Backend', 'text', '<h2>Python for Backend</h2><p>This lesson covers Python for Backend in the context of Backend Languages Overview.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Python for Backend</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 19, NULL, 0, '2025-12-24 17:05:13', '2025-12-24 17:05:13', 0, 0, 1, 30),
(3321, '5fecfb6d-8ab8-4671-8c81-c49034363c23', 849, 'Node.js Overview', 'text', '<h2>Node.js Overview</h2><p>This lesson covers Node.js Overview in the context of Backend Languages Overview.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Node.js Overview</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 19, NULL, 0, '2025-12-24 17:05:13', '2025-12-24 17:05:13', 0, 0, 1, 30),
(3322, 'fd2c464f-e497-4050-9e94-8621a8af7399', 849, 'Choosing Your Stack', 'text', '<h2>Choosing Your Stack</h2><p>This lesson covers Choosing Your Stack in the context of Backend Languages Overview.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Choosing Your Stack</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 44, NULL, 0, '2025-12-24 17:05:13', '2025-12-24 17:05:13', 0, 0, 1, 30),
(3323, 'eaf06c73-ebae-4c05-8129-a0495a4de5ea', 850, 'PHP Syntax and Variables', 'text', '<h2>PHP Syntax and Variables</h2><p>This lesson covers PHP Syntax and Variables in the context of PHP Fundamentals.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of PHP Syntax and Variables</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 37, NULL, 0, '2025-12-24 17:05:13', '2025-12-24 17:05:13', 0, 0, 1, 30),
(3324, 'da643b63-bb51-4c2a-9773-7da585f44b7c', 850, 'Data Types', 'text', '<h2>Data Types</h2><p>This lesson covers Data Types in the context of PHP Fundamentals.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Data Types</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 18, NULL, 0, '2025-12-24 17:05:13', '2025-12-24 17:05:13', 0, 0, 1, 30),
(3325, '370ccc14-a601-496a-b58b-646931ac85ed', 850, 'Operators', 'text', '<h2>Operators</h2><p>This lesson covers Operators in the context of PHP Fundamentals.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Operators</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 40, NULL, 0, '2025-12-24 17:05:13', '2025-12-24 17:05:13', 0, 0, 1, 30),
(3326, '2e4d319d-a3d1-40b5-a5db-dd97794ff59e', 850, 'Control Structures', 'text', '<h2>Control Structures</h2><p>This lesson covers Control Structures in the context of PHP Fundamentals.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Control Structures</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 36, NULL, 0, '2025-12-24 17:05:13', '2025-12-24 17:05:13', 0, 0, 1, 30),
(3327, '6a2b074d-68ff-4a8e-bc5a-c3b65eb01f09', 851, 'Defining Functions', 'text', '<h2>Defining Functions</h2><p>This lesson covers Defining Functions in the context of PHP Functions and Arrays.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Defining Functions</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 38, NULL, 0, '2025-12-24 17:05:14', '2025-12-24 17:05:14', 0, 0, 1, 30),
(3328, '521ece31-c2e3-4976-bb6e-442c7dc5769b', 851, 'Parameters and Return Values', 'text', '<h2>Parameters and Return Values</h2><p>This lesson covers Parameters and Return Values in the context of PHP Functions and Arrays.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Parameters and Return Values</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 17, NULL, 0, '2025-12-24 17:05:14', '2025-12-24 17:05:14', 0, 0, 1, 30),
(3329, '8f866f63-8f46-4592-8b88-431974bb5592', 851, 'Array Operations', 'text', '<h2>Array Operations</h2><p>This lesson covers Array Operations in the context of PHP Functions and Arrays.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Array Operations</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 33, NULL, 0, '2025-12-24 17:05:14', '2025-12-24 17:05:14', 0, 0, 1, 30),
(3330, 'ce2815d0-618c-416c-b85d-d056cb98e796', 851, 'Array Functions', 'text', '<h2>Array Functions</h2><p>This lesson covers Array Functions in the context of PHP Functions and Arrays.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Array Functions</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 17, NULL, 0, '2025-12-24 17:05:14', '2025-12-24 17:05:14', 0, 0, 1, 30),
(3331, '04d9fa91-d658-40e9-aba2-46899fd53977', 852, 'Classes and Objects', 'text', '<h2>Classes and Objects</h2><p>This lesson covers Classes and Objects in the context of Object-Oriented PHP.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Classes and Objects</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 36, NULL, 0, '2025-12-24 17:05:14', '2025-12-24 17:05:14', 0, 0, 1, 30),
(3332, '9f11b81d-39fd-4b9d-bf8f-53ca6174d5e1', 852, 'Properties and Methods', 'text', '<h2>Properties and Methods</h2><p>This lesson covers Properties and Methods in the context of Object-Oriented PHP.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Properties and Methods</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 39, NULL, 0, '2025-12-24 17:05:14', '2025-12-24 17:05:14', 0, 0, 1, 30),
(3333, 'a93d8471-0000-493e-aa50-2bb953eaa0ba', 852, 'Inheritance', 'text', '<h2>Inheritance</h2><p>This lesson covers Inheritance in the context of Object-Oriented PHP.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Inheritance</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 35, NULL, 0, '2025-12-24 17:05:14', '2025-12-24 17:05:14', 0, 0, 1, 30),
(3334, '00cbe076-34d4-4eae-8c62-485908a09067', 852, 'Interfaces and Traits', 'text', '<h2>Interfaces and Traits</h2><p>This lesson covers Interfaces and Traits in the context of Object-Oriented PHP.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Interfaces and Traits</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 29, NULL, 0, '2025-12-24 17:05:14', '2025-12-24 17:05:14', 0, 0, 1, 30),
(3335, 'f43a5a70-2a86-46db-85c6-24aa239710bb', 853, 'Database Connection', 'text', '<h2>Database Connection</h2><p>This lesson covers Database Connection in the context of PHP and MySQL Basics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Database Connection</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 30, NULL, 0, '2025-12-24 17:05:14', '2025-12-24 17:05:14', 0, 0, 1, 30),
(3336, '2568fda7-fdbc-4bce-9d54-26922ee5d746', 853, 'PDO Introduction', 'text', '<h2>PDO Introduction</h2><p>This lesson covers PDO Introduction in the context of PHP and MySQL Basics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of PDO Introduction</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 15, NULL, 0, '2025-12-24 17:05:14', '2025-12-24 17:05:14', 0, 0, 1, 30),
(3337, 'b7d61a36-d014-49c3-bfa9-2855a8807fa5', 853, 'Basic Queries', 'text', '<h2>Basic Queries</h2><p>This lesson covers Basic Queries in the context of PHP and MySQL Basics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Basic Queries</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 29, NULL, 0, '2025-12-24 17:05:14', '2025-12-24 17:05:14', 0, 0, 1, 30),
(3338, '518f4b51-c062-44cd-b21c-6d9cc25623f9', 853, 'Prepared Statements', 'text', '<h2>Prepared Statements</h2><p>This lesson covers Prepared Statements in the context of PHP and MySQL Basics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Prepared Statements</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 29, NULL, 0, '2025-12-24 17:05:14', '2025-12-24 17:05:14', 0, 0, 1, 30),
(3339, 'a7d0700c-1620-45dc-be44-b77392820efe', 854, 'Create Operations', 'text', '<h2>Create Operations</h2><p>This lesson covers Create Operations in the context of CRUD Operations.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Create Operations</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 18, NULL, 0, '2025-12-24 17:05:14', '2025-12-24 17:05:14', 0, 0, 1, 30),
(3340, 'df6ba036-f53c-4a3a-a97d-3bdd4993f5dd', 854, 'Read Operations', 'text', '<h2>Read Operations</h2><p>This lesson covers Read Operations in the context of CRUD Operations.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Read Operations</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 30, NULL, 0, '2025-12-24 17:05:14', '2025-12-24 17:05:14', 0, 0, 1, 30),
(3341, '143bacc2-7520-46a0-9ed2-6ea1ad3f47c3', 854, 'Update Operations', 'text', '<h2>Update Operations</h2><p>This lesson covers Update Operations in the context of CRUD Operations.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Update Operations</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 40, NULL, 0, '2025-12-24 17:05:14', '2025-12-24 17:05:14', 0, 0, 1, 30),
(3342, 'be2833c8-7b75-487d-9160-6869e909c942', 854, 'Delete Operations', 'text', '<h2>Delete Operations</h2><p>This lesson covers Delete Operations in the context of CRUD Operations.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Delete Operations</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 20, NULL, 0, '2025-12-24 17:05:14', '2025-12-24 17:05:14', 0, 0, 1, 30),
(3343, 'b4d2d3dd-aeb7-46dc-996e-211e66751536', 855, 'SQL Injection Prevention', 'text', '<h2>SQL Injection Prevention</h2><p>This lesson covers SQL Injection Prevention in the context of Database Security.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of SQL Injection Prevention</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 32, NULL, 0, '2025-12-24 17:05:15', '2025-12-24 17:05:15', 0, 0, 1, 30),
(3344, '0091018c-90f8-4495-82d9-e557e4db7f6a', 855, 'Input Validation', 'text', '<h2>Input Validation</h2><p>This lesson covers Input Validation in the context of Database Security.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Input Validation</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 32, NULL, 0, '2025-12-24 17:05:15', '2025-12-24 17:05:15', 0, 0, 1, 30),
(3345, '0274149a-70fd-4f61-9070-8e43c4d61745', 855, 'Data Sanitization', 'text', '<h2>Data Sanitization</h2><p>This lesson covers Data Sanitization in the context of Database Security.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Data Sanitization</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 28, NULL, 0, '2025-12-24 17:05:15', '2025-12-24 17:05:15', 0, 0, 1, 30),
(3346, '0bfd25e1-0e74-41cb-910c-d7b610151ff5', 855, 'Secure Password Handling', 'text', '<h2>Secure Password Handling</h2><p>This lesson covers Secure Password Handling in the context of Database Security.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Secure Password Handling</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 36, NULL, 0, '2025-12-24 17:05:15', '2025-12-24 17:05:15', 0, 0, 1, 30),
(3347, '2436e407-fd4a-4c98-83d5-0054612e8b13', 856, 'Session Basics', 'text', '<h2>Session Basics</h2><p>This lesson covers Session Basics in the context of Session and Cookie Management.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Session Basics</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 34, NULL, 0, '2025-12-24 17:05:15', '2025-12-24 17:05:15', 0, 0, 1, 30),
(3348, '0b468920-e500-44d7-ab9f-060187771f38', 856, 'Cookie Handling', 'text', '<h2>Cookie Handling</h2><p>This lesson covers Cookie Handling in the context of Session and Cookie Management.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Cookie Handling</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 23, NULL, 0, '2025-12-24 17:05:15', '2025-12-24 17:05:15', 0, 0, 1, 30),
(3349, '4cef10db-c0f3-4935-b983-e2e93c1b03aa', 856, 'Session Security', 'text', '<h2>Session Security</h2><p>This lesson covers Session Security in the context of Session and Cookie Management.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Session Security</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 42, NULL, 0, '2025-12-24 17:05:15', '2025-12-24 17:05:15', 0, 0, 1, 30),
(3350, '99bb22e2-1f41-4a0e-989b-35bbf9f7a5d6', 856, 'Remember Me Functionality', 'text', '<h2>Remember Me Functionality</h2><p>This lesson covers Remember Me Functionality in the context of Session and Cookie Management.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Remember Me Functionality</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 22, NULL, 0, '2025-12-24 17:05:15', '2025-12-24 17:05:15', 0, 0, 1, 30),
(3351, '435d48b2-5862-404e-9f42-93dcf93e7996', 857, 'User Registration', 'text', '<h2>User Registration</h2><p>This lesson covers User Registration in the context of Authentication Systems.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of User Registration</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 40, NULL, 0, '2025-12-24 17:05:15', '2025-12-24 17:05:15', 0, 0, 1, 30),
(3352, '063d04e8-8b74-4434-aaec-eac3ad12ecbe', 857, 'Login Systems', 'text', '<h2>Login Systems</h2><p>This lesson covers Login Systems in the context of Authentication Systems.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Login Systems</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 17, NULL, 0, '2025-12-24 17:05:15', '2025-12-24 17:05:15', 0, 0, 1, 30),
(3353, 'd95f9863-0df1-48ea-9835-1e38244a88d6', 857, 'Password Reset', 'text', '<h2>Password Reset</h2><p>This lesson covers Password Reset in the context of Authentication Systems.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Password Reset</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 42, NULL, 0, '2025-12-24 17:05:15', '2025-12-24 17:05:15', 0, 0, 1, 30),
(3354, 'bfd17f3f-7165-4eb3-a630-930af7165796', 857, 'OAuth Basics', 'text', '<h2>OAuth Basics</h2><p>This lesson covers OAuth Basics in the context of Authentication Systems.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of OAuth Basics</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 45, NULL, 0, '2025-12-24 17:05:15', '2025-12-24 17:05:15', 0, 0, 1, 30),
(3355, '1198954d-ed91-4197-8a21-5e4e46b5b692', 858, 'File Upload', 'text', '<h2>File Upload</h2><p>This lesson covers File Upload in the context of File Handling.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of File Upload</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 44, NULL, 0, '2025-12-24 17:05:16', '2025-12-24 17:05:16', 0, 0, 1, 30),
(3356, 'b5196422-1850-47c0-b750-d71d0d7ba61d', 858, 'File Validation', 'text', '<h2>File Validation</h2><p>This lesson covers File Validation in the context of File Handling.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of File Validation</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 19, NULL, 0, '2025-12-24 17:05:16', '2025-12-24 17:05:16', 0, 0, 1, 30),
(3357, '5cd45d18-a32f-4d61-8644-53308d5489d3', 858, 'Image Processing', 'text', '<h2>Image Processing</h2><p>This lesson covers Image Processing in the context of File Handling.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Image Processing</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 45, NULL, 0, '2025-12-24 17:05:16', '2025-12-24 17:05:16', 0, 0, 1, 30),
(3358, 'ed222e49-8772-4519-b01e-af33eb36908c', 858, 'File Storage Strategies', 'text', '<h2>File Storage Strategies</h2><p>This lesson covers File Storage Strategies in the context of File Handling.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of File Storage Strategies</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 28, NULL, 0, '2025-12-24 17:05:16', '2025-12-24 17:05:16', 0, 0, 1, 30),
(3359, '9029a568-f188-4868-96c9-3b759a2a26c2', 859, 'What is REST?', 'text', '<h2>What is REST?</h2><p>This lesson covers What is REST? in the context of REST API Fundamentals.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of What is REST?</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 30, NULL, 0, '2025-12-24 17:05:16', '2025-12-24 17:05:16', 0, 0, 1, 30),
(3360, 'de5751d7-2f74-4561-a412-36673547213b', 859, 'HTTP Methods', 'text', '<h2>HTTP Methods</h2><p>This lesson covers HTTP Methods in the context of REST API Fundamentals.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of HTTP Methods</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 32, NULL, 0, '2025-12-24 17:05:16', '2025-12-24 17:05:16', 0, 0, 1, 30),
(3361, 'bc4e9e4a-fb78-4d1e-be47-278785c99ca9', 859, 'API Endpoints Design', 'text', '<h2>API Endpoints Design</h2><p>This lesson covers API Endpoints Design in the context of REST API Fundamentals.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of API Endpoints Design</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 33, NULL, 0, '2025-12-24 17:05:16', '2025-12-24 17:05:16', 0, 0, 1, 30),
(3362, '9fb7b99f-e406-4558-8598-d192c5f7d899', 859, 'Status Codes', 'text', '<h2>Status Codes</h2><p>This lesson covers Status Codes in the context of REST API Fundamentals.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Status Codes</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 39, NULL, 0, '2025-12-24 17:05:16', '2025-12-24 17:05:16', 0, 0, 1, 30),
(3363, '2f252ad5-bc27-4990-a0b9-0bdb4264a7e4', 860, 'API Structure', 'text', '<h2>API Structure</h2><p>This lesson covers API Structure in the context of Building APIs with PHP.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of API Structure</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 19, NULL, 0, '2025-12-24 17:05:16', '2025-12-24 17:05:16', 0, 0, 1, 30),
(3364, '645ca6f4-5620-4a3e-90fe-1cd4a005a76a', 860, 'JSON Response', 'text', '<h2>JSON Response</h2><p>This lesson covers JSON Response in the context of Building APIs with PHP.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of JSON Response</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 32, NULL, 0, '2025-12-24 17:05:16', '2025-12-24 17:05:16', 0, 0, 1, 30),
(3365, '30ba3f8d-3593-4b59-a48f-98652c6e709d', 860, 'Request Handling', 'text', '<h2>Request Handling</h2><p>This lesson covers Request Handling in the context of Building APIs with PHP.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Request Handling</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 39, NULL, 0, '2025-12-24 17:05:16', '2025-12-24 17:05:16', 0, 0, 1, 30);
INSERT INTO `lessons` (`id`, `uuid`, `module_id`, `title`, `type`, `content`, `order_index`, `duration_minutes`, `resources`, `ai_generated`, `created_at`, `updated_at`, `has_practical`, `has_quiz`, `competency_weight`, `estimated_time_minutes`) VALUES
(3366, 'b9b7fbf0-217a-49ce-9c82-e0e0a38ff9e2', 860, 'API Versioning', 'text', '<h2>API Versioning</h2><p>This lesson covers API Versioning in the context of Building APIs with PHP.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of API Versioning</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 41, NULL, 0, '2025-12-24 17:05:16', '2025-12-24 17:05:16', 0, 0, 1, 30),
(3367, '7c5619bd-10c2-41b7-a7d3-e06b60f565f1', 861, 'Token-Based Auth', 'text', '<h2>Token-Based Auth</h2><p>This lesson covers Token-Based Auth in the context of API Authentication.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Token-Based Auth</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 41, NULL, 0, '2025-12-24 17:05:17', '2025-12-24 17:05:17', 0, 0, 1, 30),
(3368, '9c096b69-c9c2-4f9a-8f75-905067b80943', 861, 'JWT Implementation', 'text', '<h2>JWT Implementation</h2><p>This lesson covers JWT Implementation in the context of API Authentication.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of JWT Implementation</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 33, NULL, 0, '2025-12-24 17:05:17', '2025-12-24 17:05:17', 0, 0, 1, 30),
(3369, '3d3d0f22-adb5-4b76-a63e-fd412087dfc5', 861, 'API Keys', 'text', '<h2>API Keys</h2><p>This lesson covers API Keys in the context of API Authentication.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of API Keys</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 38, NULL, 0, '2025-12-24 17:05:17', '2025-12-24 17:05:17', 0, 0, 1, 30),
(3370, '7786a7c4-0993-4932-a148-88e77ec2c2a1', 861, 'Rate Limiting', 'text', '<h2>Rate Limiting</h2><p>This lesson covers Rate Limiting in the context of API Authentication.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Rate Limiting</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 16, NULL, 0, '2025-12-24 17:05:17', '2025-12-24 17:05:17', 0, 0, 1, 30),
(3371, '0e0336a1-cfbd-4c56-81d1-2242eda85ac9', 862, 'Exception Handling', 'text', '<h2>Exception Handling</h2><p>This lesson covers Exception Handling in the context of Error Handling and Logging.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Exception Handling</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 21, NULL, 0, '2025-12-24 17:05:17', '2025-12-24 17:05:17', 0, 0, 1, 30),
(3372, '286f9ef5-ab40-4dfb-a88c-8fdaf5c3354d', 862, 'Custom Exceptions', 'text', '<h2>Custom Exceptions</h2><p>This lesson covers Custom Exceptions in the context of Error Handling and Logging.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Custom Exceptions</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 16, NULL, 0, '2025-12-24 17:05:17', '2025-12-24 17:05:17', 0, 0, 1, 30),
(3373, '74d37a8a-6a30-47e0-a350-1b0d915cbceb', 862, 'Logging Strategies', 'text', '<h2>Logging Strategies</h2><p>This lesson covers Logging Strategies in the context of Error Handling and Logging.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Logging Strategies</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 23, NULL, 0, '2025-12-24 17:05:17', '2025-12-24 17:05:17', 0, 0, 1, 30),
(3374, '8f602aa4-389e-4046-be84-d32b617ebd2c', 862, 'Error Reporting', 'text', '<h2>Error Reporting</h2><p>This lesson covers Error Reporting in the context of Error Handling and Logging.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Error Reporting</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 31, NULL, 0, '2025-12-24 17:05:17', '2025-12-24 17:05:17', 0, 0, 1, 30),
(3375, '057e11aa-e974-4f7e-b0d8-b68d79cdbc0d', 863, 'Unit Testing Basics', 'text', '<h2>Unit Testing Basics</h2><p>This lesson covers Unit Testing Basics in the context of Testing Backend Code.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Unit Testing Basics</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 36, NULL, 0, '2025-12-24 17:05:17', '2025-12-24 17:05:17', 0, 0, 1, 30),
(3376, '3c24922b-cddb-49e4-8285-dc8954534580', 863, 'PHPUnit Introduction', 'text', '<h2>PHPUnit Introduction</h2><p>This lesson covers PHPUnit Introduction in the context of Testing Backend Code.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of PHPUnit Introduction</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 33, NULL, 0, '2025-12-24 17:05:17', '2025-12-24 17:05:17', 0, 0, 1, 30),
(3377, '9472f0ae-57fd-48ca-a5c6-9019647afc3c', 863, 'Test-Driven Development', 'text', '<h2>Test-Driven Development</h2><p>This lesson covers Test-Driven Development in the context of Testing Backend Code.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Test-Driven Development</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 39, NULL, 0, '2025-12-24 17:05:17', '2025-12-24 17:05:17', 0, 0, 1, 30),
(3378, '1de74b26-dbcb-4d76-a840-4e0a75fb6695', 863, 'Integration Testing', 'text', '<h2>Integration Testing</h2><p>This lesson covers Integration Testing in the context of Testing Backend Code.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Integration Testing</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 45, NULL, 0, '2025-12-24 17:05:17', '2025-12-24 17:05:17', 0, 0, 1, 30),
(3379, 'cdb05551-81eb-45d7-b3ef-11597aae4d38', 864, 'Caching Strategies', 'text', '<h2>Caching Strategies</h2><p>This lesson covers Caching Strategies in the context of Performance Optimization.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Caching Strategies</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 31, NULL, 0, '2025-12-24 17:05:17', '2025-12-24 17:05:17', 0, 0, 1, 30),
(3380, '01bd6c3e-4696-4317-883a-c8663485a8fb', 864, 'Query Optimization', 'text', '<h2>Query Optimization</h2><p>This lesson covers Query Optimization in the context of Performance Optimization.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Query Optimization</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 28, NULL, 0, '2025-12-24 17:05:17', '2025-12-24 17:05:17', 0, 0, 1, 30),
(3381, '0a1ecb67-79bd-488a-9113-dddf75be8e32', 864, 'Code Profiling', 'text', '<h2>Code Profiling</h2><p>This lesson covers Code Profiling in the context of Performance Optimization.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Code Profiling</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 36, NULL, 0, '2025-12-24 17:05:17', '2025-12-24 17:05:17', 0, 0, 1, 30),
(3382, '457e80cd-87d6-4600-ae8f-ee55ea6bcd95', 864, 'Memory Management', 'text', '<h2>Memory Management</h2><p>This lesson covers Memory Management in the context of Performance Optimization.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Memory Management</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 35, NULL, 0, '2025-12-24 17:05:18', '2025-12-24 17:05:18', 0, 0, 1, 30),
(3383, '4cca3f07-b561-49fb-afc2-ba39e49d43cc', 865, 'Server Setup', 'text', '<h2>Server Setup</h2><p>This lesson covers Server Setup in the context of Deployment and DevOps.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Server Setup</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 25, NULL, 0, '2025-12-24 17:05:18', '2025-12-24 17:05:18', 0, 0, 1, 30),
(3384, 'c8cf446f-d321-4cec-8e79-44f04fffc535', 865, 'Deployment Strategies', 'text', '<h2>Deployment Strategies</h2><p>This lesson covers Deployment Strategies in the context of Deployment and DevOps.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Deployment Strategies</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 17, NULL, 0, '2025-12-24 17:05:18', '2025-12-24 17:05:18', 0, 0, 1, 30),
(3385, '953a4698-0dcc-4428-809c-b153acc96d70', 865, 'CI/CD Basics', 'text', '<h2>CI/CD Basics</h2><p>This lesson covers CI/CD Basics in the context of Deployment and DevOps.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of CI/CD Basics</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 41, NULL, 0, '2025-12-24 17:05:18', '2025-12-24 17:05:18', 0, 0, 1, 30),
(3386, 'cd6ac1e6-ed0e-4a5d-8c79-d9a0e7e838f5', 865, 'Monitoring and Maintenance', 'text', '<h2>Monitoring and Maintenance</h2><p>This lesson covers Monitoring and Maintenance in the context of Deployment and DevOps.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Monitoring and Maintenance</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 37, NULL, 0, '2025-12-24 17:05:18', '2025-12-24 17:05:18', 0, 0, 1, 30),
(3387, '56cc8ea5-f34d-45b0-885b-8138519d83bc', 866, 'What is Full Stack?', 'text', '<h2>What is Full Stack?</h2><p>This lesson covers What is Full Stack? in the context of Full Stack Overview.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of What is Full Stack?</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 22, NULL, 0, '2025-12-24 17:05:18', '2025-12-24 17:05:18', 0, 0, 1, 30),
(3388, 'cd226aec-44fd-421c-9726-4fa864f8ea6f', 866, 'The Modern Web Stack', 'text', '<h2>The Modern Web Stack</h2><p>This lesson covers The Modern Web Stack in the context of Full Stack Overview.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of The Modern Web Stack</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 31, NULL, 0, '2025-12-24 17:05:18', '2025-12-24 17:05:18', 0, 0, 1, 30),
(3389, 'd080d020-6f42-4fbd-b551-7bd30b3544cb', 866, 'Career Paths', 'text', '<h2>Career Paths</h2><p>This lesson covers Career Paths in the context of Full Stack Overview.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Career Paths</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 29, NULL, 0, '2025-12-24 17:05:18', '2025-12-24 17:05:18', 0, 0, 1, 30),
(3390, 'eea4b753-eb97-4dd2-b595-87bd9bd946a7', 866, 'Learning Roadmap', 'text', '<h2>Learning Roadmap</h2><p>This lesson covers Learning Roadmap in the context of Full Stack Overview.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Learning Roadmap</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 41, NULL, 0, '2025-12-24 17:05:18', '2025-12-24 17:05:18', 0, 0, 1, 30),
(3391, '0ef311fe-68cc-4fa0-8adc-05dcf93b935d', 867, 'IDE Setup', 'text', '<h2>IDE Setup</h2><p>This lesson covers IDE Setup in the context of Development Environment.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of IDE Setup</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 25, NULL, 0, '2025-12-24 17:05:19', '2025-12-24 17:05:19', 0, 0, 1, 30),
(3392, '0869dd08-8a38-48f0-a2c5-25751d2c24d7', 867, 'Version Control Basics', 'text', '<h2>Version Control Basics</h2><p>This lesson covers Version Control Basics in the context of Development Environment.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Version Control Basics</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 41, NULL, 0, '2025-12-24 17:05:19', '2025-12-24 17:05:19', 0, 0, 1, 30),
(3393, 'd62d3c54-a915-4f8a-8455-520d2d09313d', 867, 'Terminal Commands', 'text', '<h2>Terminal Commands</h2><p>This lesson covers Terminal Commands in the context of Development Environment.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Terminal Commands</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 17, NULL, 0, '2025-12-24 17:05:19', '2025-12-24 17:05:19', 0, 0, 1, 30),
(3394, 'dd055b27-ff9c-4738-bf09-5561c2027485', 867, 'Docker Introduction', 'text', '<h2>Docker Introduction</h2><p>This lesson covers Docker Introduction in the context of Development Environment.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Docker Introduction</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 29, NULL, 0, '2025-12-24 17:05:19', '2025-12-24 17:05:19', 0, 0, 1, 30),
(3395, '79bfaf69-5ef3-4d5d-9fb5-1ad51dff36cf', 868, 'Semantic Elements', 'text', '<h2>Semantic Elements</h2><p>This lesson covers Semantic Elements in the context of HTML5 Deep Dive.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Semantic Elements</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 19, NULL, 0, '2025-12-24 17:05:19', '2025-12-24 17:05:19', 0, 0, 1, 30),
(3396, '9c81a437-6cd3-4e09-a811-c03a67f1a867', 868, 'Web APIs', 'text', '<h2>Web APIs</h2><p>This lesson covers Web APIs in the context of HTML5 Deep Dive.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Web APIs</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 28, NULL, 0, '2025-12-24 17:05:19', '2025-12-24 17:05:19', 0, 0, 1, 30),
(3397, 'a4bebe0f-0708-4025-825f-18d9ac3bac48', 868, 'Canvas and SVG', 'text', '<h2>Canvas and SVG</h2><p>This lesson covers Canvas and SVG in the context of HTML5 Deep Dive.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Canvas and SVG</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 35, NULL, 0, '2025-12-24 17:05:19', '2025-12-24 17:05:19', 0, 0, 1, 30),
(3398, '95eb3315-ca11-4006-b892-aace2e5cc093', 868, 'Web Components', 'text', '<h2>Web Components</h2><p>This lesson covers Web Components in the context of HTML5 Deep Dive.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Web Components</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 27, NULL, 0, '2025-12-24 17:05:19', '2025-12-24 17:05:19', 0, 0, 1, 30),
(3399, 'a7f26ad1-7b5d-4334-a019-7d0e45c2ac83', 869, 'CSS Architecture', 'text', '<h2>CSS Architecture</h2><p>This lesson covers CSS Architecture in the context of Advanced CSS.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of CSS Architecture</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 42, NULL, 0, '2025-12-24 17:05:20', '2025-12-24 17:05:20', 0, 0, 1, 30),
(3400, '661a1113-73c0-412a-aaed-d317b129fbc3', 869, 'Preprocessors (SASS)', 'text', '<h2>Preprocessors (SASS)</h2><p>This lesson covers Preprocessors (SASS) in the context of Advanced CSS.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Preprocessors (SASS)</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 21, NULL, 0, '2025-12-24 17:05:20', '2025-12-24 17:05:20', 0, 0, 1, 30),
(3401, '3745920e-cf01-4eb5-8860-b85bbb437485', 869, 'CSS-in-JS', 'text', '<h2>CSS-in-JS</h2><p>This lesson covers CSS-in-JS in the context of Advanced CSS.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of CSS-in-JS</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 34, NULL, 0, '2025-12-24 17:05:20', '2025-12-24 17:05:20', 0, 0, 1, 30),
(3402, '69967fa1-220b-46e0-a8db-4337e321f26c', 869, 'Design Systems', 'text', '<h2>Design Systems</h2><p>This lesson covers Design Systems in the context of Advanced CSS.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Design Systems</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 18, NULL, 0, '2025-12-24 17:05:20', '2025-12-24 17:05:20', 0, 0, 1, 30),
(3403, '45ffc9c8-5f29-4e54-8c79-93161f105389', 870, 'Advanced Functions', 'text', '<h2>Advanced Functions</h2><p>This lesson covers Advanced Functions in the context of JavaScript Mastery.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Advanced Functions</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 45, NULL, 0, '2025-12-24 17:05:20', '2025-12-24 17:05:20', 0, 0, 1, 30),
(3404, '2a7c35ad-3591-42f9-a118-394d71b9967a', 870, 'Closures and Scope', 'text', '<h2>Closures and Scope</h2><p>This lesson covers Closures and Scope in the context of JavaScript Mastery.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Closures and Scope</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 16, NULL, 0, '2025-12-24 17:05:20', '2025-12-24 17:05:20', 0, 0, 1, 30),
(3405, '695c162f-1047-4ded-ab5c-72c256176759', 870, 'Prototypes', 'text', '<h2>Prototypes</h2><p>This lesson covers Prototypes in the context of JavaScript Mastery.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Prototypes</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 22, NULL, 0, '2025-12-24 17:05:20', '2025-12-24 17:05:20', 0, 0, 1, 30),
(3406, '11fe5b77-007e-4e41-9bff-40bc671f092b', 870, 'Design Patterns', 'text', '<h2>Design Patterns</h2><p>This lesson covers Design Patterns in the context of JavaScript Mastery.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Design Patterns</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 45, NULL, 0, '2025-12-24 17:05:20', '2025-12-24 17:05:20', 0, 0, 1, 30),
(3407, '5dec2299-541a-4e03-8360-882b0caf8129', 871, 'TypeScript Setup', 'text', '<h2>TypeScript Setup</h2><p>This lesson covers TypeScript Setup in the context of TypeScript Fundamentals.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of TypeScript Setup</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 22, NULL, 0, '2025-12-24 17:05:20', '2025-12-24 17:05:20', 0, 0, 1, 30),
(3408, '6bba2695-a233-44ba-bd5e-4815564343ee', 871, 'Types and Interfaces', 'text', '<h2>Types and Interfaces</h2><p>This lesson covers Types and Interfaces in the context of TypeScript Fundamentals.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Types and Interfaces</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 19, NULL, 0, '2025-12-24 17:05:20', '2025-12-24 17:05:20', 0, 0, 1, 30),
(3409, '2dbb66be-52fc-42e2-a75a-de8ce7f815ac', 871, 'Generics', 'text', '<h2>Generics</h2><p>This lesson covers Generics in the context of TypeScript Fundamentals.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Generics</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 42, NULL, 0, '2025-12-24 17:05:20', '2025-12-24 17:05:20', 0, 0, 1, 30),
(3410, '43e70754-acd0-4af5-90a8-bbc8b183f639', 871, 'TypeScript with React', 'text', '<h2>TypeScript with React</h2><p>This lesson covers TypeScript with React in the context of TypeScript Fundamentals.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of TypeScript with React</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 39, NULL, 0, '2025-12-24 17:05:20', '2025-12-24 17:05:20', 0, 0, 1, 30),
(3411, 'ef96483f-584b-41e7-84f4-b6c4f903c90d', 872, 'React Setup', 'text', '<h2>React Setup</h2><p>This lesson covers React Setup in the context of React.js Essentials.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of React Setup</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 37, NULL, 0, '2025-12-24 17:05:20', '2025-12-24 17:05:20', 0, 0, 1, 30),
(3412, 'ae483996-df43-45ac-bd4d-37451768a390', 872, 'Components and JSX', 'text', '<h2>Components and JSX</h2><p>This lesson covers Components and JSX in the context of React.js Essentials.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Components and JSX</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 15, NULL, 0, '2025-12-24 17:05:20', '2025-12-24 17:05:20', 0, 0, 1, 30),
(3413, '7f09a455-1d1e-42de-8024-7ece700d401b', 872, 'Props and State', 'text', '<h2>Props and State</h2><p>This lesson covers Props and State in the context of React.js Essentials.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Props and State</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 42, NULL, 0, '2025-12-24 17:05:20', '2025-12-24 17:05:20', 0, 0, 1, 30),
(3414, 'a369b8c8-5f6a-41a7-af18-2010c72551e2', 872, 'Lifecycle Methods', 'text', '<h2>Lifecycle Methods</h2><p>This lesson covers Lifecycle Methods in the context of React.js Essentials.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Lifecycle Methods</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 33, NULL, 0, '2025-12-24 17:05:21', '2025-12-24 17:05:21', 0, 0, 1, 30),
(3415, 'fce8eb1b-55ae-4876-b249-5177fab5bf0f', 873, 'useState and useEffect', 'text', '<h2>useState and useEffect</h2><p>This lesson covers useState and useEffect in the context of React Hooks.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of useState and useEffect</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 25, NULL, 0, '2025-12-24 17:05:21', '2025-12-24 17:05:21', 0, 0, 1, 30),
(3416, '1525dc6c-f328-4435-a81d-c6f4767159f8', 873, 'Custom Hooks', 'text', '<h2>Custom Hooks</h2><p>This lesson covers Custom Hooks in the context of React Hooks.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Custom Hooks</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 32, NULL, 0, '2025-12-24 17:05:21', '2025-12-24 17:05:21', 0, 0, 1, 30),
(3417, '98e6efd5-7056-4cfc-9408-d1a7952f34e7', 873, 'useContext', 'text', '<h2>useContext</h2><p>This lesson covers useContext in the context of React Hooks.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of useContext</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 22, NULL, 0, '2025-12-24 17:05:21', '2025-12-24 17:05:21', 0, 0, 1, 30),
(3418, '6aa0f91f-6345-46cf-9b97-e645a937a896', 873, 'useReducer', 'text', '<h2>useReducer</h2><p>This lesson covers useReducer in the context of React Hooks.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of useReducer</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 25, NULL, 0, '2025-12-24 17:05:21', '2025-12-24 17:05:21', 0, 0, 1, 30),
(3419, '5453bce9-d810-49e2-81bb-84696b41683d', 874, 'Context API', 'text', '<h2>Context API</h2><p>This lesson covers Context API in the context of State Management.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Context API</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 21, NULL, 0, '2025-12-24 17:05:21', '2025-12-24 17:05:21', 0, 0, 1, 30),
(3420, '46e4a436-6432-485d-aef3-42b825e69233', 874, 'Redux Basics', 'text', '<h2>Redux Basics</h2><p>This lesson covers Redux Basics in the context of State Management.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Redux Basics</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 25, NULL, 0, '2025-12-24 17:05:21', '2025-12-24 17:05:21', 0, 0, 1, 30),
(3421, '7cad6d42-daa8-4fc6-8ceb-599c2672a521', 874, 'Redux Toolkit', 'text', '<h2>Redux Toolkit</h2><p>This lesson covers Redux Toolkit in the context of State Management.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Redux Toolkit</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 15, NULL, 0, '2025-12-24 17:05:21', '2025-12-24 17:05:21', 0, 0, 1, 30),
(3422, '94355727-3fed-4602-9a88-59f2f9f52576', 874, 'Zustand and Alternatives', 'text', '<h2>Zustand and Alternatives</h2><p>This lesson covers Zustand and Alternatives in the context of State Management.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Zustand and Alternatives</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 32, NULL, 0, '2025-12-24 17:05:21', '2025-12-24 17:05:21', 0, 0, 1, 30),
(3423, '310409b2-6339-4c49-8e50-6d5eb519f24a', 875, 'Routing Basics', 'text', '<h2>Routing Basics</h2><p>This lesson covers Routing Basics in the context of React Router.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Routing Basics</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 16, NULL, 0, '2025-12-24 17:05:21', '2025-12-24 17:05:21', 0, 0, 1, 30),
(3424, '792a9bdb-26f3-4580-87ad-dbd950c4131d', 875, 'Dynamic Routes', 'text', '<h2>Dynamic Routes</h2><p>This lesson covers Dynamic Routes in the context of React Router.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Dynamic Routes</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 25, NULL, 0, '2025-12-24 17:05:21', '2025-12-24 17:05:21', 0, 0, 1, 30),
(3425, 'eb194fd1-8af7-4653-b152-5ceabf384c02', 875, 'Protected Routes', 'text', '<h2>Protected Routes</h2><p>This lesson covers Protected Routes in the context of React Router.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Protected Routes</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 19, NULL, 0, '2025-12-24 17:05:21', '2025-12-24 17:05:21', 0, 0, 1, 30),
(3426, '1007cd5b-c55f-4d76-b097-024607122990', 875, 'Navigation Patterns', 'text', '<h2>Navigation Patterns</h2><p>This lesson covers Navigation Patterns in the context of React Router.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Navigation Patterns</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 39, NULL, 0, '2025-12-24 17:05:21', '2025-12-24 17:05:21', 0, 0, 1, 30),
(3427, '70ae455c-ce75-44cd-8642-cd47aab897fc', 876, 'Jest Basics', 'text', '<h2>Jest Basics</h2><p>This lesson covers Jest Basics in the context of Frontend Testing.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Jest Basics</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 20, NULL, 0, '2025-12-24 17:05:21', '2025-12-24 17:05:21', 0, 0, 1, 30),
(3428, '4231283e-f688-4511-a7ec-63433e7c5841', 876, 'React Testing Library', 'text', '<h2>React Testing Library</h2><p>This lesson covers React Testing Library in the context of Frontend Testing.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of React Testing Library</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 18, NULL, 0, '2025-12-24 17:05:22', '2025-12-24 17:05:22', 0, 0, 1, 30),
(3429, '68f61c08-0aee-428e-9d2f-1d6fab0587e4', 876, 'Component Testing', 'text', '<h2>Component Testing</h2><p>This lesson covers Component Testing in the context of Frontend Testing.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Component Testing</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 33, NULL, 0, '2025-12-24 17:05:22', '2025-12-24 17:05:22', 0, 0, 1, 30),
(3430, 'd331fea4-a542-4f68-ac21-e9fab2ef7e6b', 876, 'E2E with Cypress', 'text', '<h2>E2E with Cypress</h2><p>This lesson covers E2E with Cypress in the context of Frontend Testing.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of E2E with Cypress</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 41, NULL, 0, '2025-12-24 17:05:22', '2025-12-24 17:05:22', 0, 0, 1, 30),
(3431, '3fbda742-e38c-4f70-b048-6049c31d6223', 877, 'Node.js Basics', 'text', '<h2>Node.js Basics</h2><p>This lesson covers Node.js Basics in the context of Node.js Fundamentals.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Node.js Basics</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 26, NULL, 0, '2025-12-24 17:05:22', '2025-12-24 17:05:22', 0, 0, 1, 30),
(3432, 'a20820dc-4518-48f6-bf1f-aba1254a101d', 877, 'Modules and npm', 'text', '<h2>Modules and npm</h2><p>This lesson covers Modules and npm in the context of Node.js Fundamentals.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Modules and npm</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 15, NULL, 0, '2025-12-24 17:05:22', '2025-12-24 17:05:22', 0, 0, 1, 30),
(3433, '489c2ed5-d019-4ebf-b870-e1a39d2235d4', 877, 'File System', 'text', '<h2>File System</h2><p>This lesson covers File System in the context of Node.js Fundamentals.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of File System</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 39, NULL, 0, '2025-12-24 17:05:22', '2025-12-24 17:05:22', 0, 0, 1, 30),
(3434, '8fd3689d-4202-4f40-a4b7-2642fd98f7bd', 877, 'Event Loop', 'text', '<h2>Event Loop</h2><p>This lesson covers Event Loop in the context of Node.js Fundamentals.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Event Loop</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 21, NULL, 0, '2025-12-24 17:05:22', '2025-12-24 17:05:22', 0, 0, 1, 30),
(3435, 'abf39b34-d757-4a1c-ae62-fbb450820e8f', 878, 'Express Setup', 'text', '<h2>Express Setup</h2><p>This lesson covers Express Setup in the context of Express.js Framework.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Express Setup</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 42, NULL, 0, '2025-12-24 17:05:22', '2025-12-24 17:05:22', 0, 0, 1, 30),
(3436, 'd7914f04-b40c-4b16-ba05-ef06dad57abd', 878, 'Routing', 'text', '<h2>Routing</h2><p>This lesson covers Routing in the context of Express.js Framework.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Routing</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 27, NULL, 0, '2025-12-24 17:05:22', '2025-12-24 17:05:22', 0, 0, 1, 30),
(3437, 'baad8dd0-8fd7-4de0-a26d-50dc51518298', 878, 'Middleware', 'text', '<h2>Middleware</h2><p>This lesson covers Middleware in the context of Express.js Framework.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Middleware</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 22, NULL, 0, '2025-12-24 17:05:22', '2025-12-24 17:05:22', 0, 0, 1, 30),
(3438, '39d3b241-b535-46b5-8170-5343e8d51ff1', 878, 'Error Handling', 'text', '<h2>Error Handling</h2><p>This lesson covers Error Handling in the context of Express.js Framework.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Error Handling</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 27, NULL, 0, '2025-12-24 17:05:22', '2025-12-24 17:05:22', 0, 0, 1, 30),
(3439, '46719ffe-2631-4974-a334-c2ff06f08958', 879, 'NoSQL Concepts', 'text', '<h2>NoSQL Concepts</h2><p>This lesson covers NoSQL Concepts in the context of MongoDB Basics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of NoSQL Concepts</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 23, NULL, 0, '2025-12-24 17:05:22', '2025-12-24 17:05:22', 0, 0, 1, 30),
(3440, '615dbd8e-0459-40e7-a445-7d38c12f5df6', 879, 'MongoDB Setup', 'text', '<h2>MongoDB Setup</h2><p>This lesson covers MongoDB Setup in the context of MongoDB Basics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of MongoDB Setup</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 39, NULL, 0, '2025-12-24 17:05:23', '2025-12-24 17:05:23', 0, 0, 1, 30),
(3441, '6504724a-fd9d-4259-acfd-a405af327e39', 879, 'CRUD Operations', 'text', '<h2>CRUD Operations</h2><p>This lesson covers CRUD Operations in the context of MongoDB Basics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of CRUD Operations</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 34, NULL, 0, '2025-12-24 17:05:23', '2025-12-24 17:05:23', 0, 0, 1, 30),
(3442, '7e9152f6-442d-446e-b4a9-163b0e4b5942', 879, 'Mongoose ODM', 'text', '<h2>Mongoose ODM</h2><p>This lesson covers Mongoose ODM in the context of MongoDB Basics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Mongoose ODM</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 20, NULL, 0, '2025-12-24 17:05:23', '2025-12-24 17:05:23', 0, 0, 1, 30),
(3443, 'f4865769-97fe-4e7d-8e75-f354aaedf5b0', 880, 'Aggregation Pipeline', 'text', '<h2>Aggregation Pipeline</h2><p>This lesson covers Aggregation Pipeline in the context of MongoDB Advanced.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Aggregation Pipeline</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 45, NULL, 0, '2025-12-24 17:05:23', '2025-12-24 17:05:23', 0, 0, 1, 30),
(3444, 'da289edc-6e4d-4ad0-bdaf-b258fdbcd18d', 880, 'Indexing', 'text', '<h2>Indexing</h2><p>This lesson covers Indexing in the context of MongoDB Advanced.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Indexing</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 17, NULL, 0, '2025-12-24 17:05:23', '2025-12-24 17:05:23', 0, 0, 1, 30),
(3445, '84dd653a-572e-411b-82f4-78cebdc1c3f0', 880, 'Data Modeling', 'text', '<h2>Data Modeling</h2><p>This lesson covers Data Modeling in the context of MongoDB Advanced.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Data Modeling</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 30, NULL, 0, '2025-12-24 17:05:23', '2025-12-24 17:05:23', 0, 0, 1, 30),
(3446, 'abf0c3a2-9de3-44a7-8968-bca2e9a2192e', 880, 'Relationships', 'text', '<h2>Relationships</h2><p>This lesson covers Relationships in the context of MongoDB Advanced.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Relationships</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 38, NULL, 0, '2025-12-24 17:05:23', '2025-12-24 17:05:23', 0, 0, 1, 30),
(3447, '49b8df2a-3011-4ef2-a549-84d6562f6d13', 881, 'API Design', 'text', '<h2>API Design</h2><p>This lesson covers API Design in the context of REST API with Node.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of API Design</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 17, NULL, 0, '2025-12-24 17:05:23', '2025-12-24 17:05:23', 0, 0, 1, 30),
(3448, '05dd2e2d-323a-41e1-aca7-da4846a4fec9', 881, 'CRUD Endpoints', 'text', '<h2>CRUD Endpoints</h2><p>This lesson covers CRUD Endpoints in the context of REST API with Node.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of CRUD Endpoints</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 16, NULL, 0, '2025-12-24 17:05:23', '2025-12-24 17:05:23', 0, 0, 1, 30),
(3449, 'c260ebbf-80ae-42ce-83ac-f1553974027d', 881, 'Validation', 'text', '<h2>Validation</h2><p>This lesson covers Validation in the context of REST API with Node.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Validation</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 36, NULL, 0, '2025-12-24 17:05:23', '2025-12-24 17:05:23', 0, 0, 1, 30),
(3450, 'f17863a2-162f-4a1d-ad6f-7d035dacd082', 881, 'Documentation', 'text', '<h2>Documentation</h2><p>This lesson covers Documentation in the context of REST API with Node.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Documentation</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 16, NULL, 0, '2025-12-24 17:05:23', '2025-12-24 17:05:23', 0, 0, 1, 30),
(3451, 'e1d8a77d-fbbf-4286-b3f1-3b6254277542', 882, 'JWT Authentication', 'text', '<h2>JWT Authentication</h2><p>This lesson covers JWT Authentication in the context of Authentication and Authorization.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of JWT Authentication</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 27, NULL, 0, '2025-12-24 17:05:23', '2025-12-24 17:05:23', 0, 0, 1, 30),
(3452, 'd9af8137-b5cd-4391-984e-1f4f941fdb4d', 882, 'Passport.js', 'text', '<h2>Passport.js</h2><p>This lesson covers Passport.js in the context of Authentication and Authorization.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Passport.js</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 16, NULL, 0, '2025-12-24 17:05:24', '2025-12-24 17:05:24', 0, 0, 1, 30),
(3453, '7c7046bc-062d-4062-9896-b449f42f09ff', 882, 'Role-Based Access', 'text', '<h2>Role-Based Access</h2><p>This lesson covers Role-Based Access in the context of Authentication and Authorization.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Role-Based Access</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 15, NULL, 0, '2025-12-24 17:05:24', '2025-12-24 17:05:24', 0, 0, 1, 30),
(3454, '129ccc5e-b4a2-404e-8811-184ce397e56f', 882, 'OAuth Integration', 'text', '<h2>OAuth Integration</h2><p>This lesson covers OAuth Integration in the context of Authentication and Authorization.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of OAuth Integration</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 30, NULL, 0, '2025-12-24 17:05:24', '2025-12-24 17:05:24', 0, 0, 1, 30),
(3455, '4b0e9a6b-0de5-49e7-bb99-25cf3d227c04', 883, 'WebSockets', 'text', '<h2>WebSockets</h2><p>This lesson covers WebSockets in the context of Real-time Features.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of WebSockets</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 19, NULL, 0, '2025-12-24 17:05:24', '2025-12-24 17:05:24', 0, 0, 1, 30),
(3456, '9585d441-7a8a-47b0-8893-f6765c6f70a0', 883, 'Socket.io', 'text', '<h2>Socket.io</h2><p>This lesson covers Socket.io in the context of Real-time Features.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Socket.io</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 41, NULL, 0, '2025-12-24 17:05:24', '2025-12-24 17:05:24', 0, 0, 1, 30),
(3457, '92165a6b-627c-45f8-9f3e-cdc488b5ef00', 883, 'Real-time Notifications', 'text', '<h2>Real-time Notifications</h2><p>This lesson covers Real-time Notifications in the context of Real-time Features.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Real-time Notifications</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 26, NULL, 0, '2025-12-24 17:05:24', '2025-12-24 17:05:24', 0, 0, 1, 30),
(3458, 'c3133fc6-01e4-4cad-8b2e-32a1f192873a', 883, 'Chat Implementation', 'text', '<h2>Chat Implementation</h2><p>This lesson covers Chat Implementation in the context of Real-time Features.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Chat Implementation</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 17, NULL, 0, '2025-12-24 17:05:24', '2025-12-24 17:05:24', 0, 0, 1, 30),
(3459, '1375daec-34d9-46c9-b2a5-4753ce043680', 884, 'GraphQL vs REST', 'text', '<h2>GraphQL vs REST</h2><p>This lesson covers GraphQL vs REST in the context of GraphQL Introduction.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of GraphQL vs REST</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 29, NULL, 0, '2025-12-24 17:05:24', '2025-12-24 17:05:24', 0, 0, 1, 30),
(3460, 'cbbed19e-c11b-44c5-868c-7b2f4357fe6b', 884, 'Schema Definition', 'text', '<h2>Schema Definition</h2><p>This lesson covers Schema Definition in the context of GraphQL Introduction.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Schema Definition</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 38, NULL, 0, '2025-12-24 17:05:24', '2025-12-24 17:05:24', 0, 0, 1, 30),
(3461, '5bb418c0-f56e-40f8-9230-03c212970364', 884, 'Queries and Mutations', 'text', '<h2>Queries and Mutations</h2><p>This lesson covers Queries and Mutations in the context of GraphQL Introduction.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Queries and Mutations</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 21, NULL, 0, '2025-12-24 17:05:24', '2025-12-24 17:05:24', 0, 0, 1, 30),
(3462, '69b350fd-6ccc-4fdd-bf94-89db2d993b99', 884, 'Apollo Client', 'text', '<h2>Apollo Client</h2><p>This lesson covers Apollo Client in the context of GraphQL Introduction.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Apollo Client</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 31, NULL, 0, '2025-12-24 17:05:24', '2025-12-24 17:05:24', 0, 0, 1, 30),
(3463, 'a559154b-a0ba-4af4-8683-57072a1c4dab', 885, 'Requirements Analysis', 'text', '<h2>Requirements Analysis</h2><p>This lesson covers Requirements Analysis in the context of Full Stack Project Planning.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Requirements Analysis</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 43, NULL, 0, '2025-12-24 17:05:24', '2025-12-24 17:05:24', 0, 0, 1, 30),
(3464, '52be418a-85cd-46d0-9bfe-f3d940ee0a74', 885, 'Architecture Design', 'text', '<h2>Architecture Design</h2><p>This lesson covers Architecture Design in the context of Full Stack Project Planning.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Architecture Design</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 20, NULL, 0, '2025-12-24 17:05:24', '2025-12-24 17:05:24', 0, 0, 1, 30),
(3465, '799011d4-233a-4b17-afee-230fddc4232f', 885, 'Database Schema', 'text', '<h2>Database Schema</h2><p>This lesson covers Database Schema in the context of Full Stack Project Planning.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Database Schema</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 17, NULL, 0, '2025-12-24 17:05:25', '2025-12-24 17:05:25', 0, 0, 1, 30),
(3466, '1c86d500-4c42-4a8b-9b62-3ac42f76a9ee', 885, 'API Planning', 'text', '<h2>API Planning</h2><p>This lesson covers API Planning in the context of Full Stack Project Planning.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of API Planning</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 30, NULL, 0, '2025-12-24 17:05:25', '2025-12-24 17:05:25', 0, 0, 1, 30),
(3467, 'b7cfc9c6-7afd-4e0a-9237-95deabd5617e', 886, 'Component Architecture', 'text', '<h2>Component Architecture</h2><p>This lesson covers Component Architecture in the context of Building the Frontend.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Component Architecture</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 19, NULL, 0, '2025-12-24 17:05:25', '2025-12-24 17:05:25', 0, 0, 1, 30),
(3468, '3de63809-238a-4384-963d-6b6bd22ac33b', 886, 'State Design', 'text', '<h2>State Design</h2><p>This lesson covers State Design in the context of Building the Frontend.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of State Design</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 38, NULL, 0, '2025-12-24 17:05:25', '2025-12-24 17:05:25', 0, 0, 1, 30),
(3469, '81409714-74d4-4558-8b09-a30028560616', 886, 'API Integration', 'text', '<h2>API Integration</h2><p>This lesson covers API Integration in the context of Building the Frontend.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of API Integration</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 45, NULL, 0, '2025-12-24 17:05:25', '2025-12-24 17:05:25', 0, 0, 1, 30),
(3470, '11d2cf58-e086-427c-84e6-45b850a51530', 886, 'UI/UX Implementation', 'text', '<h2>UI/UX Implementation</h2><p>This lesson covers UI/UX Implementation in the context of Building the Frontend.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of UI/UX Implementation</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 32, NULL, 0, '2025-12-24 17:05:25', '2025-12-24 17:05:25', 0, 0, 1, 30),
(3471, '50ed9a85-722a-4156-a96d-b8b1b6754dd0', 887, 'Server Architecture', 'text', '<h2>Server Architecture</h2><p>This lesson covers Server Architecture in the context of Building the Backend.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Server Architecture</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 41, NULL, 0, '2025-12-24 17:05:25', '2025-12-24 17:05:25', 0, 0, 1, 30),
(3472, 'bbb43675-b368-4376-bd6a-374483e00325', 887, 'Database Implementation', 'text', '<h2>Database Implementation</h2><p>This lesson covers Database Implementation in the context of Building the Backend.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Database Implementation</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 20, NULL, 0, '2025-12-24 17:05:25', '2025-12-24 17:05:25', 0, 0, 1, 30),
(3473, '639c3312-85af-47d1-a0f9-1129b0ff88cd', 887, 'Business Logic', 'text', '<h2>Business Logic</h2><p>This lesson covers Business Logic in the context of Building the Backend.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Business Logic</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 29, NULL, 0, '2025-12-24 17:05:25', '2025-12-24 17:05:25', 0, 0, 1, 30),
(3474, '25884660-6315-4241-986f-4b04fdcdc117', 887, 'API Development', 'text', '<h2>API Development</h2><p>This lesson covers API Development in the context of Building the Backend.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of API Development</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 29, NULL, 0, '2025-12-24 17:05:25', '2025-12-24 17:05:25', 0, 0, 1, 30),
(3475, '21e4ea8b-fe98-4b3d-bd47-f1a2627bf83d', 888, 'Testing Strategy', 'text', '<h2>Testing Strategy</h2><p>This lesson covers Testing Strategy in the context of Testing Full Stack Apps.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Testing Strategy</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 30, NULL, 0, '2025-12-24 17:05:25', '2025-12-24 17:05:25', 0, 0, 1, 30),
(3476, '4e40ece8-2a34-47f1-adc5-64b8a4e71b9a', 888, 'Unit Tests', 'text', '<h2>Unit Tests</h2><p>This lesson covers Unit Tests in the context of Testing Full Stack Apps.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Unit Tests</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 26, NULL, 0, '2025-12-24 17:05:25', '2025-12-24 17:05:25', 0, 0, 1, 30),
(3477, '7b920a08-155b-4c69-9cd7-487ed8e282ca', 888, 'Integration Tests', 'text', '<h2>Integration Tests</h2><p>This lesson covers Integration Tests in the context of Testing Full Stack Apps.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Integration Tests</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 29, NULL, 0, '2025-12-24 17:05:25', '2025-12-24 17:05:25', 0, 0, 1, 30),
(3478, '601363bb-41e9-41bb-a730-6d80928b7bce', 888, 'E2E Tests', 'text', '<h2>E2E Tests</h2><p>This lesson covers E2E Tests in the context of Testing Full Stack Apps.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of E2E Tests</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 44, NULL, 0, '2025-12-24 17:05:25', '2025-12-24 17:05:25', 0, 0, 1, 30),
(3479, 'da48d791-8b5b-4feb-bba7-b458fe3a76c9', 889, 'Frontend Deployment', 'text', '<h2>Frontend Deployment</h2><p>This lesson covers Frontend Deployment in the context of Deployment Strategies.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Frontend Deployment</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 45, NULL, 0, '2025-12-24 17:05:26', '2025-12-24 17:05:26', 0, 0, 1, 30);
INSERT INTO `lessons` (`id`, `uuid`, `module_id`, `title`, `type`, `content`, `order_index`, `duration_minutes`, `resources`, `ai_generated`, `created_at`, `updated_at`, `has_practical`, `has_quiz`, `competency_weight`, `estimated_time_minutes`) VALUES
(3480, '9070b07f-f92b-4ef1-8b6d-bbaeb633e0e7', 889, 'Backend Deployment', 'text', '<h2>Backend Deployment</h2><p>This lesson covers Backend Deployment in the context of Deployment Strategies.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Backend Deployment</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 16, NULL, 0, '2025-12-24 17:05:26', '2025-12-24 17:05:26', 0, 0, 1, 30),
(3481, '7950bedd-0c0e-4421-a764-da7c8c38f3d8', 889, 'Database Hosting', 'text', '<h2>Database Hosting</h2><p>This lesson covers Database Hosting in the context of Deployment Strategies.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Database Hosting</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 28, NULL, 0, '2025-12-24 17:05:26', '2025-12-24 17:05:26', 0, 0, 1, 30),
(3482, '8a762109-fc7f-4522-9807-2d4083b40f96', 889, 'Domain and SSL', 'text', '<h2>Domain and SSL</h2><p>This lesson covers Domain and SSL in the context of Deployment Strategies.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Domain and SSL</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 19, NULL, 0, '2025-12-24 17:05:26', '2025-12-24 17:05:26', 0, 0, 1, 30),
(3483, '9e3f717a-c9f0-48c8-98f9-12bc8662d402', 890, 'Security Hardening', 'text', '<h2>Security Hardening</h2><p>This lesson covers Security Hardening in the context of Production Best Practices.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Security Hardening</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 32, NULL, 0, '2025-12-24 17:05:26', '2025-12-24 17:05:26', 0, 0, 1, 30),
(3484, '3b302330-72d4-4222-9194-14002a223a38', 890, 'Performance Optimization', 'text', '<h2>Performance Optimization</h2><p>This lesson covers Performance Optimization in the context of Production Best Practices.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Performance Optimization</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 36, NULL, 0, '2025-12-24 17:05:26', '2025-12-24 17:05:26', 0, 0, 1, 30),
(3485, '13dc7c12-72f2-40ad-9886-dce9db79eee2', 890, 'Monitoring', 'text', '<h2>Monitoring</h2><p>This lesson covers Monitoring in the context of Production Best Practices.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Monitoring</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 37, NULL, 0, '2025-12-24 17:05:26', '2025-12-24 17:05:26', 0, 0, 1, 30),
(3486, 'e8807432-a027-49ac-be7e-02f019e4ac8c', 890, 'Scaling Strategies', 'text', '<h2>Scaling Strategies</h2><p>This lesson covers Scaling Strategies in the context of Production Best Practices.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Scaling Strategies</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 19, NULL, 0, '2025-12-24 17:05:27', '2025-12-24 17:05:27', 0, 0, 1, 30),
(3487, '1763e8fc-7a24-411b-bbdd-dcf218df37a4', 891, 'What are Databases?', 'text', '<h2>What are Databases?</h2><p>This lesson covers What are Databases? in the context of Database Fundamentals.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of What are Databases?</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 35, NULL, 0, '2025-12-24 17:05:27', '2025-12-24 17:05:27', 0, 0, 1, 30),
(3488, '2764e90f-abef-4047-85a5-7dc332d3a81d', 891, 'RDBMS vs NoSQL', 'text', '<h2>RDBMS vs NoSQL</h2><p>This lesson covers RDBMS vs NoSQL in the context of Database Fundamentals.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of RDBMS vs NoSQL</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 32, NULL, 0, '2025-12-24 17:05:27', '2025-12-24 17:05:27', 0, 0, 1, 30),
(3489, '47c7bd2d-a59d-44e4-88b3-661db1228aae', 891, 'Database History', 'text', '<h2>Database History</h2><p>This lesson covers Database History in the context of Database Fundamentals.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Database History</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 37, NULL, 0, '2025-12-24 17:05:27', '2025-12-24 17:05:27', 0, 0, 1, 30),
(3490, 'f1c46159-4cf8-43cb-9022-9ca452142ea9', 891, 'Use Cases', 'text', '<h2>Use Cases</h2><p>This lesson covers Use Cases in the context of Database Fundamentals.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Use Cases</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 18, NULL, 0, '2025-12-24 17:05:27', '2025-12-24 17:05:27', 0, 0, 1, 30),
(3491, '60b4c676-33aa-4fcb-bac6-367ba9594970', 892, 'Entities and Attributes', 'text', '<h2>Entities and Attributes</h2><p>This lesson covers Entities and Attributes in the context of Data Modeling Concepts.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Entities and Attributes</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 15, NULL, 0, '2025-12-24 17:05:27', '2025-12-24 17:05:27', 0, 0, 1, 30),
(3492, '06c35d8c-0590-402d-b1ff-2739417a682b', 892, 'Relationships', 'text', '<h2>Relationships</h2><p>This lesson covers Relationships in the context of Data Modeling Concepts.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Relationships</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 18, NULL, 0, '2025-12-24 17:05:27', '2025-12-24 17:05:27', 0, 0, 1, 30),
(3493, '73894f5a-a028-4e01-a80b-5bfba3758d6f', 892, 'ER Diagrams', 'text', '<h2>ER Diagrams</h2><p>This lesson covers ER Diagrams in the context of Data Modeling Concepts.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of ER Diagrams</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 15, NULL, 0, '2025-12-24 17:05:27', '2025-12-24 17:05:27', 0, 0, 1, 30),
(3494, '473d1ccd-8e91-44d7-b5a9-1896b17d7ed0', 892, 'Cardinality', 'text', '<h2>Cardinality</h2><p>This lesson covers Cardinality in the context of Data Modeling Concepts.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Cardinality</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 16, NULL, 0, '2025-12-24 17:05:27', '2025-12-24 17:05:27', 0, 0, 1, 30),
(3495, '49cfbdf6-d78d-4004-b8f3-fc5ac8b1dec8', 893, 'SQL Introduction', 'text', '<h2>SQL Introduction</h2><p>This lesson covers SQL Introduction in the context of SQL Basics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of SQL Introduction</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 18, NULL, 0, '2025-12-24 17:05:28', '2025-12-24 17:05:28', 0, 0, 1, 30),
(3496, '2405b35b-473b-493d-bc8b-af29a45a095c', 893, 'SELECT Statements', 'text', '<h2>SELECT Statements</h2><p>This lesson covers SELECT Statements in the context of SQL Basics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of SELECT Statements</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 23, NULL, 0, '2025-12-24 17:05:28', '2025-12-24 17:05:28', 0, 0, 1, 30),
(3497, '28992764-a29c-4524-b57a-db2c93f572b3', 893, 'WHERE Clauses', 'text', '<h2>WHERE Clauses</h2><p>This lesson covers WHERE Clauses in the context of SQL Basics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of WHERE Clauses</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 26, NULL, 0, '2025-12-24 17:05:28', '2025-12-24 17:05:28', 0, 0, 1, 30),
(3498, '6cd5f4f1-126e-4da2-83cd-6654899e87da', 893, 'Sorting and Filtering', 'text', '<h2>Sorting and Filtering</h2><p>This lesson covers Sorting and Filtering in the context of SQL Basics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Sorting and Filtering</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 36, NULL, 0, '2025-12-24 17:05:28', '2025-12-24 17:05:28', 0, 0, 1, 30),
(3499, '3c9afd85-bd41-4433-8fae-4124dad94a10', 894, 'INNER JOIN', 'text', '<h2>INNER JOIN</h2><p>This lesson covers INNER JOIN in the context of SQL Joins and Subqueries.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of INNER JOIN</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 21, NULL, 0, '2025-12-24 17:05:28', '2025-12-24 17:05:28', 0, 0, 1, 30),
(3500, 'b84ade7f-0c01-4d2d-a2db-711b07884d10', 894, 'LEFT/RIGHT JOIN', 'text', '<h2>LEFT/RIGHT JOIN</h2><p>This lesson covers LEFT/RIGHT JOIN in the context of SQL Joins and Subqueries.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of LEFT/RIGHT JOIN</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 27, NULL, 0, '2025-12-24 17:05:28', '2025-12-24 17:05:28', 0, 0, 1, 30),
(3501, 'c338f05d-9ec4-4339-b0e0-90877c432f1c', 894, 'Subqueries', 'text', '<h2>Subqueries</h2><p>This lesson covers Subqueries in the context of SQL Joins and Subqueries.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Subqueries</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 29, NULL, 0, '2025-12-24 17:05:28', '2025-12-24 17:05:28', 0, 0, 1, 30),
(3502, '0bccaa20-ba7d-4d03-9528-14abaa27ff3d', 894, 'Complex Queries', 'text', '<h2>Complex Queries</h2><p>This lesson covers Complex Queries in the context of SQL Joins and Subqueries.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Complex Queries</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 19, NULL, 0, '2025-12-24 17:05:28', '2025-12-24 17:05:28', 0, 0, 1, 30),
(3503, '7d047413-4784-4d1c-86f3-fb29d99521a5', 895, 'Aggregate Functions', 'text', '<h2>Aggregate Functions</h2><p>This lesson covers Aggregate Functions in the context of Advanced SQL.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Aggregate Functions</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 36, NULL, 0, '2025-12-24 17:05:29', '2025-12-24 17:05:29', 0, 0, 1, 30),
(3504, 'f7b1f9b2-b6a9-427a-8900-e3105a9782da', 895, 'GROUP BY and HAVING', 'text', '<h2>GROUP BY and HAVING</h2><p>This lesson covers GROUP BY and HAVING in the context of Advanced SQL.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of GROUP BY and HAVING</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 24, NULL, 0, '2025-12-24 17:05:29', '2025-12-24 17:05:29', 0, 0, 1, 30),
(3505, '0a3f7e76-66a8-4513-a37b-b6b1853ec590', 895, 'Window Functions', 'text', '<h2>Window Functions</h2><p>This lesson covers Window Functions in the context of Advanced SQL.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Window Functions</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 19, NULL, 0, '2025-12-24 17:05:29', '2025-12-24 17:05:29', 0, 0, 1, 30),
(3506, 'caf511d5-f8e2-47bd-9568-eb9d84b2a264', 895, 'CTEs', 'text', '<h2>CTEs</h2><p>This lesson covers CTEs in the context of Advanced SQL.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of CTEs</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 43, NULL, 0, '2025-12-24 17:05:29', '2025-12-24 17:05:29', 0, 0, 1, 30),
(3507, '34beb9d1-4831-4922-b763-e63f7bc798c3', 896, 'Normalization Forms', 'text', '<h2>Normalization Forms</h2><p>This lesson covers Normalization Forms in the context of Database Design.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Normalization Forms</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 41, NULL, 0, '2025-12-24 17:05:29', '2025-12-24 17:05:29', 0, 0, 1, 30),
(3508, '4ae82bb9-252f-4f3b-88f6-a87da812d2aa', 896, '1NF to 3NF', 'text', '<h2>1NF to 3NF</h2><p>This lesson covers 1NF to 3NF in the context of Database Design.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of 1NF to 3NF</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 19, NULL, 0, '2025-12-24 17:05:29', '2025-12-24 17:05:29', 0, 0, 1, 30),
(3509, '12e06e84-25b6-4723-8dc2-cf4cfd585275', 896, 'Denormalization', 'text', '<h2>Denormalization</h2><p>This lesson covers Denormalization in the context of Database Design.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Denormalization</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 38, NULL, 0, '2025-12-24 17:05:29', '2025-12-24 17:05:29', 0, 0, 1, 30),
(3510, 'a8fe8682-c682-4f5c-943e-a6e5f721de9b', 896, 'Schema Design Patterns', 'text', '<h2>Schema Design Patterns</h2><p>This lesson covers Schema Design Patterns in the context of Database Design.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Schema Design Patterns</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 34, NULL, 0, '2025-12-24 17:05:29', '2025-12-24 17:05:29', 0, 0, 1, 30),
(3511, '1bbdb968-662a-4b46-bba5-954ebed7d5c5', 897, 'Creating Procedures', 'text', '<h2>Creating Procedures</h2><p>This lesson covers Creating Procedures in the context of Stored Procedures and Functions.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Creating Procedures</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 31, NULL, 0, '2025-12-24 17:05:29', '2025-12-24 17:05:29', 0, 0, 1, 30),
(3512, '21e26bed-e1cc-47e6-ba0b-6b3a8d14f061', 897, 'Parameters', 'text', '<h2>Parameters</h2><p>This lesson covers Parameters in the context of Stored Procedures and Functions.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Parameters</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 18, NULL, 0, '2025-12-24 17:05:29', '2025-12-24 17:05:29', 0, 0, 1, 30),
(3513, 'd6020b2a-6ceb-408f-884e-8abebe0485b6', 897, 'Functions', 'text', '<h2>Functions</h2><p>This lesson covers Functions in the context of Stored Procedures and Functions.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Functions</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 20, NULL, 0, '2025-12-24 17:05:29', '2025-12-24 17:05:29', 0, 0, 1, 30),
(3514, 'c966cadc-0c0d-4a23-b145-00a0a945a736', 897, 'Triggers', 'text', '<h2>Triggers</h2><p>This lesson covers Triggers in the context of Stored Procedures and Functions.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Triggers</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 38, NULL, 0, '2025-12-24 17:05:29', '2025-12-24 17:05:29', 0, 0, 1, 30),
(3515, '542ecc39-dc21-4135-955f-794854914fec', 898, 'Index Types', 'text', '<h2>Index Types</h2><p>This lesson covers Index Types in the context of Indexing and Optimization.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Index Types</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 44, NULL, 0, '2025-12-24 17:05:30', '2025-12-24 17:05:30', 0, 0, 1, 30),
(3516, '357b9215-e68c-4938-9220-8b7323be04da', 898, 'Creating Indexes', 'text', '<h2>Creating Indexes</h2><p>This lesson covers Creating Indexes in the context of Indexing and Optimization.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Creating Indexes</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 31, NULL, 0, '2025-12-24 17:05:30', '2025-12-24 17:05:30', 0, 0, 1, 30),
(3517, 'd4fa383a-6940-475a-bdd4-d5c2f9f3e655', 898, 'Query Plans', 'text', '<h2>Query Plans</h2><p>This lesson covers Query Plans in the context of Indexing and Optimization.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Query Plans</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 34, NULL, 0, '2025-12-24 17:05:30', '2025-12-24 17:05:30', 0, 0, 1, 30),
(3518, '31ffd273-fac1-4e38-a40e-f453eb39d54b', 898, 'Performance Tuning', 'text', '<h2>Performance Tuning</h2><p>This lesson covers Performance Tuning in the context of Indexing and Optimization.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Performance Tuning</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 22, NULL, 0, '2025-12-24 17:05:30', '2025-12-24 17:05:30', 0, 0, 1, 30),
(3519, '0e92c450-1410-4279-bc1f-4156bdfdb7d5', 899, 'ACID Properties', 'text', '<h2>ACID Properties</h2><p>This lesson covers ACID Properties in the context of Transactions and Concurrency.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of ACID Properties</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 37, NULL, 0, '2025-12-24 17:05:30', '2025-12-24 17:05:30', 0, 0, 1, 30),
(3520, '950e8827-899c-412e-92da-d508d221a965', 899, 'Transaction Management', 'text', '<h2>Transaction Management</h2><p>This lesson covers Transaction Management in the context of Transactions and Concurrency.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Transaction Management</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 18, NULL, 0, '2025-12-24 17:05:30', '2025-12-24 17:05:30', 0, 0, 1, 30),
(3521, '4e7d5807-16d6-41bc-bccb-eb0b8cac6590', 899, 'Locking', 'text', '<h2>Locking</h2><p>This lesson covers Locking in the context of Transactions and Concurrency.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Locking</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 34, NULL, 0, '2025-12-24 17:05:30', '2025-12-24 17:05:30', 0, 0, 1, 30),
(3522, '6c3e89b6-280c-4b1b-b581-2c8f36c70d45', 899, 'Deadlocks', 'text', '<h2>Deadlocks</h2><p>This lesson covers Deadlocks in the context of Transactions and Concurrency.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Deadlocks</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 21, NULL, 0, '2025-12-24 17:05:30', '2025-12-24 17:05:30', 0, 0, 1, 30),
(3523, 'db9a9ba2-4c4c-4214-b413-82583498af1d', 900, 'User Management', 'text', '<h2>User Management</h2><p>This lesson covers User Management in the context of Database Security.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of User Management</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 23, NULL, 0, '2025-12-24 17:05:30', '2025-12-24 17:05:30', 0, 0, 1, 30),
(3524, '53b84dc6-a36f-4920-9973-82b8115732db', 900, 'Privileges', 'text', '<h2>Privileges</h2><p>This lesson covers Privileges in the context of Database Security.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Privileges</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 37, NULL, 0, '2025-12-24 17:05:30', '2025-12-24 17:05:30', 0, 0, 1, 30),
(3525, '0a77dcb3-1e77-4c9f-82e8-2a07660fce89', 900, 'Encryption', 'text', '<h2>Encryption</h2><p>This lesson covers Encryption in the context of Database Security.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Encryption</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 25, NULL, 0, '2025-12-24 17:05:30', '2025-12-24 17:05:30', 0, 0, 1, 30),
(3526, '13747725-b352-44fd-a7a6-bda55430b031', 900, 'Audit Logging', 'text', '<h2>Audit Logging</h2><p>This lesson covers Audit Logging in the context of Database Security.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Audit Logging</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 38, NULL, 0, '2025-12-24 17:05:30', '2025-12-24 17:05:30', 0, 0, 1, 30),
(3527, '16505a52-0e20-4c9e-be1b-83b1ede7211a', 901, 'Backup Strategies', 'text', '<h2>Backup Strategies</h2><p>This lesson covers Backup Strategies in the context of Backup and Recovery.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Backup Strategies</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 31, NULL, 0, '2025-12-24 17:05:30', '2025-12-24 17:05:30', 0, 0, 1, 30),
(3528, '6ae5c12a-7df4-40fa-927f-362e47c59f2d', 901, 'Point-in-Time Recovery', 'text', '<h2>Point-in-Time Recovery</h2><p>This lesson covers Point-in-Time Recovery in the context of Backup and Recovery.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Point-in-Time Recovery</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 30, NULL, 0, '2025-12-24 17:05:30', '2025-12-24 17:05:30', 0, 0, 1, 30),
(3529, '5059d33d-9458-4a82-b13f-427c20b32e0c', 901, 'Disaster Recovery', 'text', '<h2>Disaster Recovery</h2><p>This lesson covers Disaster Recovery in the context of Backup and Recovery.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Disaster Recovery</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 38, NULL, 0, '2025-12-24 17:05:30', '2025-12-24 17:05:30', 0, 0, 1, 30),
(3530, '269eac62-5649-401a-b01b-a5c4f3744836', 901, 'High Availability', 'text', '<h2>High Availability</h2><p>This lesson covers High Availability in the context of Backup and Recovery.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of High Availability</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 32, NULL, 0, '2025-12-24 17:05:30', '2025-12-24 17:05:30', 0, 0, 1, 30),
(3531, 'd65ae05f-fbc1-46a0-a04a-36cf36aef1e4', 902, 'Monitoring', 'text', '<h2>Monitoring</h2><p>This lesson covers Monitoring in the context of Database Administration.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Monitoring</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 42, NULL, 0, '2025-12-24 17:05:30', '2025-12-24 17:05:30', 0, 0, 1, 30),
(3532, 'b4d47ac0-5b17-48c2-835b-1d2663a20ac5', 902, 'Maintenance Tasks', 'text', '<h2>Maintenance Tasks</h2><p>This lesson covers Maintenance Tasks in the context of Database Administration.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Maintenance Tasks</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 37, NULL, 0, '2025-12-24 17:05:31', '2025-12-24 17:05:31', 0, 0, 1, 30),
(3533, 'ee8e1c3f-a895-4cd7-8fe3-09bf984618a2', 902, 'Capacity Planning', 'text', '<h2>Capacity Planning</h2><p>This lesson covers Capacity Planning in the context of Database Administration.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Capacity Planning</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 15, NULL, 0, '2025-12-24 17:05:31', '2025-12-24 17:05:31', 0, 0, 1, 30),
(3534, '015b5e81-cad7-45c9-9777-228cc560db6b', 902, 'Migration Strategies', 'text', '<h2>Migration Strategies</h2><p>This lesson covers Migration Strategies in the context of Database Administration.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Migration Strategies</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 40, NULL, 0, '2025-12-24 17:05:31', '2025-12-24 17:05:31', 0, 0, 1, 30),
(3535, '55f78a49-9fcc-48b9-8633-9cc32df5cdeb', 903, 'What is AI?', 'text', '<h2>What is AI?</h2><p>This lesson covers What is AI? in the context of Introduction to AI.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of What is AI?</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 41, NULL, 0, '2025-12-24 17:05:31', '2025-12-24 17:05:31', 0, 0, 1, 30),
(3536, 'd72cf17a-9b4b-4bf7-935c-43a33a8f7d91', 903, 'History of AI', 'text', '<h2>History of AI</h2><p>This lesson covers History of AI in the context of Introduction to AI.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of History of AI</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 15, NULL, 0, '2025-12-24 17:05:31', '2025-12-24 17:05:31', 0, 0, 1, 30),
(3537, 'f4554805-d8b2-4738-913b-29e3a5537bd9', 903, 'Types of AI', 'text', '<h2>Types of AI</h2><p>This lesson covers Types of AI in the context of Introduction to AI.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Types of AI</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 22, NULL, 0, '2025-12-24 17:05:31', '2025-12-24 17:05:31', 0, 0, 1, 30),
(3538, '0020e0fa-96d4-4e8a-b262-5adb36e125d7', 903, 'AI Applications', 'text', '<h2>AI Applications</h2><p>This lesson covers AI Applications in the context of Introduction to AI.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of AI Applications</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 31, NULL, 0, '2025-12-24 17:05:31', '2025-12-24 17:05:31', 0, 0, 1, 30),
(3539, '114e0ede-5df2-4d64-a39d-1ca455647dd7', 904, 'Ethical AI', 'text', '<h2>Ethical AI</h2><p>This lesson covers Ethical AI in the context of AI Ethics and Considerations.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Ethical AI</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 22, NULL, 0, '2025-12-24 17:05:31', '2025-12-24 17:05:31', 0, 0, 1, 30),
(3540, '45a28302-1f8c-4d05-b482-5861cf23fbfa', 904, 'Bias in AI', 'text', '<h2>Bias in AI</h2><p>This lesson covers Bias in AI in the context of AI Ethics and Considerations.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Bias in AI</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 23, NULL, 0, '2025-12-24 17:05:31', '2025-12-24 17:05:31', 0, 0, 1, 30),
(3541, '38dbdd6a-0a1f-44c5-9005-37afc07f2f6f', 904, 'Privacy Concerns', 'text', '<h2>Privacy Concerns</h2><p>This lesson covers Privacy Concerns in the context of AI Ethics and Considerations.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Privacy Concerns</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 19, NULL, 0, '2025-12-24 17:05:31', '2025-12-24 17:05:31', 0, 0, 1, 30),
(3542, '3ef2afe4-a70c-4574-adbe-8041be546475', 904, 'Responsible AI', 'text', '<h2>Responsible AI</h2><p>This lesson covers Responsible AI in the context of AI Ethics and Considerations.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Responsible AI</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 24, NULL, 0, '2025-12-24 17:05:31', '2025-12-24 17:05:31', 0, 0, 1, 30),
(3543, '9b7049c6-6927-48d0-9e30-657cb837cec3', 905, 'Python Setup', 'text', '<h2>Python Setup</h2><p>This lesson covers Python Setup in the context of Python for AI.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Python Setup</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 24, NULL, 0, '2025-12-24 17:05:32', '2025-12-24 17:05:32', 0, 0, 1, 30),
(3544, '99a5a0d1-c36f-456e-8e1e-9b6e94733dd9', 905, 'Python Basics Review', 'text', '<h2>Python Basics Review</h2><p>This lesson covers Python Basics Review in the context of Python for AI.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Python Basics Review</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 24, NULL, 0, '2025-12-24 17:05:32', '2025-12-24 17:05:32', 0, 0, 1, 30),
(3545, 'ae2b3dec-3e49-447e-a916-17cb189a3bc2', 905, 'Data Structures', 'text', '<h2>Data Structures</h2><p>This lesson covers Data Structures in the context of Python for AI.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Data Structures</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 19, NULL, 0, '2025-12-24 17:05:32', '2025-12-24 17:05:32', 0, 0, 1, 30),
(3546, '0fd18c91-69c8-475a-bdcb-28ef6ad14678', 905, 'Control Flow', 'text', '<h2>Control Flow</h2><p>This lesson covers Control Flow in the context of Python for AI.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Control Flow</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 41, NULL, 0, '2025-12-24 17:05:32', '2025-12-24 17:05:32', 0, 0, 1, 30),
(3547, '55d753df-66f7-498c-a60e-4b9f9638560e', 906, 'NumPy Arrays', 'text', '<h2>NumPy Arrays</h2><p>This lesson covers NumPy Arrays in the context of NumPy Fundamentals.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of NumPy Arrays</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 45, NULL, 0, '2025-12-24 17:05:32', '2025-12-24 17:05:32', 0, 0, 1, 30),
(3548, 'a259074e-eb09-430c-b2d9-a6f4569ab4f2', 906, 'Array Operations', 'text', '<h2>Array Operations</h2><p>This lesson covers Array Operations in the context of NumPy Fundamentals.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Array Operations</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 32, NULL, 0, '2025-12-24 17:05:32', '2025-12-24 17:05:32', 0, 0, 1, 30),
(3549, 'ce954a98-4e56-4783-8cd7-1bca9c62ae78', 906, 'Broadcasting', 'text', '<h2>Broadcasting</h2><p>This lesson covers Broadcasting in the context of NumPy Fundamentals.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Broadcasting</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 23, NULL, 0, '2025-12-24 17:05:32', '2025-12-24 17:05:32', 0, 0, 1, 30),
(3550, '70b86c03-5bf8-4d58-a43c-628fe18f7b77', 906, 'Linear Algebra', 'text', '<h2>Linear Algebra</h2><p>This lesson covers Linear Algebra in the context of NumPy Fundamentals.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Linear Algebra</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 36, NULL, 0, '2025-12-24 17:05:32', '2025-12-24 17:05:32', 0, 0, 1, 30),
(3551, '9d40b46d-eb6f-4063-ac72-660e680cd6de', 907, 'DataFrames', 'text', '<h2>DataFrames</h2><p>This lesson covers DataFrames in the context of Pandas for Data Analysis.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of DataFrames</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 37, NULL, 0, '2025-12-24 17:05:32', '2025-12-24 17:05:32', 0, 0, 1, 30),
(3552, 'e90ce114-f27d-4637-8fe4-7d894d9cbb82', 907, 'Data Manipulation', 'text', '<h2>Data Manipulation</h2><p>This lesson covers Data Manipulation in the context of Pandas for Data Analysis.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Data Manipulation</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 32, NULL, 0, '2025-12-24 17:05:32', '2025-12-24 17:05:32', 0, 0, 1, 30),
(3553, '15cbd72a-6a55-4e75-9605-edf948ec4dfc', 907, 'Data Cleaning', 'text', '<h2>Data Cleaning</h2><p>This lesson covers Data Cleaning in the context of Pandas for Data Analysis.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Data Cleaning</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 44, NULL, 0, '2025-12-24 17:05:32', '2025-12-24 17:05:32', 0, 0, 1, 30),
(3554, '7006e810-c321-464a-9c7d-5e1940860f0a', 907, 'GroupBy Operations', 'text', '<h2>GroupBy Operations</h2><p>This lesson covers GroupBy Operations in the context of Pandas for Data Analysis.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of GroupBy Operations</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 20, NULL, 0, '2025-12-24 17:05:32', '2025-12-24 17:05:32', 0, 0, 1, 30),
(3555, 'e92e9f69-9765-4e2e-bf58-d2aab23c3822', 908, 'Matplotlib Basics', 'text', '<h2>Matplotlib Basics</h2><p>This lesson covers Matplotlib Basics in the context of Data Visualization.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Matplotlib Basics</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 29, NULL, 0, '2025-12-24 17:05:32', '2025-12-24 17:05:32', 0, 0, 1, 30),
(3556, 'cb2ec95b-4a5c-40e0-8f53-0e3aad793091', 908, 'Seaborn', 'text', '<h2>Seaborn</h2><p>This lesson covers Seaborn in the context of Data Visualization.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Seaborn</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 17, NULL, 0, '2025-12-24 17:05:33', '2025-12-24 17:05:33', 0, 0, 1, 30),
(3557, 'c1131808-f5f7-4b7f-aaab-f8edda5bb220', 908, 'Plotly', 'text', '<h2>Plotly</h2><p>This lesson covers Plotly in the context of Data Visualization.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Plotly</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 18, NULL, 0, '2025-12-24 17:05:33', '2025-12-24 17:05:33', 0, 0, 1, 30),
(3558, '579c1516-c1ff-42bd-bd8b-df3c939ff7a6', 908, 'Visualization Best Practices', 'text', '<h2>Visualization Best Practices</h2><p>This lesson covers Visualization Best Practices in the context of Data Visualization.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Visualization Best Practices</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 30, NULL, 0, '2025-12-24 17:05:33', '2025-12-24 17:05:33', 0, 0, 1, 30),
(3559, '09a406c5-91a7-4a3f-8577-34607ac4f2a9', 909, 'Descriptive Statistics', 'text', '<h2>Descriptive Statistics</h2><p>This lesson covers Descriptive Statistics in the context of Statistics for ML.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Descriptive Statistics</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 31, NULL, 0, '2025-12-24 17:05:33', '2025-12-24 17:05:33', 0, 0, 1, 30),
(3560, 'c5b52555-a30c-4115-a5a0-ff66350f3cda', 909, 'Probability', 'text', '<h2>Probability</h2><p>This lesson covers Probability in the context of Statistics for ML.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Probability</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 27, NULL, 0, '2025-12-24 17:05:33', '2025-12-24 17:05:33', 0, 0, 1, 30),
(3561, '3a484380-248c-4390-aa68-0eca892a954c', 909, 'Distributions', 'text', '<h2>Distributions</h2><p>This lesson covers Distributions in the context of Statistics for ML.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Distributions</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 19, NULL, 0, '2025-12-24 17:05:33', '2025-12-24 17:05:33', 0, 0, 1, 30),
(3562, '95c3656e-7ba3-4ce2-9c8a-774d9c60d73f', 909, 'Hypothesis Testing', 'text', '<h2>Hypothesis Testing</h2><p>This lesson covers Hypothesis Testing in the context of Statistics for ML.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Hypothesis Testing</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 41, NULL, 0, '2025-12-24 17:05:33', '2025-12-24 17:05:33', 0, 0, 1, 30),
(3563, '2c798ea8-9a8d-4aeb-bd75-6371ffdca2ad', 910, 'What is ML?', 'text', '<h2>What is ML?</h2><p>This lesson covers What is ML? in the context of Machine Learning Fundamentals.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of What is ML?</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 28, NULL, 0, '2025-12-24 17:05:33', '2025-12-24 17:05:33', 0, 0, 1, 30),
(3564, 'd50420c0-05d0-4970-b8d2-2cd428ae3410', 910, 'Types of Learning', 'text', '<h2>Types of Learning</h2><p>This lesson covers Types of Learning in the context of Machine Learning Fundamentals.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Types of Learning</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 23, NULL, 0, '2025-12-24 17:05:33', '2025-12-24 17:05:33', 0, 0, 1, 30),
(3565, 'b9fbd607-0b94-4785-a6c0-bd20180453ed', 910, 'ML Workflow', 'text', '<h2>ML Workflow</h2><p>This lesson covers ML Workflow in the context of Machine Learning Fundamentals.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of ML Workflow</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 15, NULL, 0, '2025-12-24 17:05:33', '2025-12-24 17:05:33', 0, 0, 1, 30),
(3566, '807463cc-fb43-464c-90f2-b0570af6684b', 910, 'Feature Engineering', 'text', '<h2>Feature Engineering</h2><p>This lesson covers Feature Engineering in the context of Machine Learning Fundamentals.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Feature Engineering</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 18, NULL, 0, '2025-12-24 17:05:33', '2025-12-24 17:05:33', 0, 0, 1, 30),
(3567, '7f900a23-c041-4ffe-a29f-7f85f8859adb', 911, 'Linear Regression', 'text', '<h2>Linear Regression</h2><p>This lesson covers Linear Regression in the context of Supervised Learning: Regression.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Linear Regression</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 42, NULL, 0, '2025-12-24 17:05:33', '2025-12-24 17:05:33', 0, 0, 1, 30),
(3568, '774ca278-31aa-4459-b4bc-181285d22822', 911, 'Polynomial Regression', 'text', '<h2>Polynomial Regression</h2><p>This lesson covers Polynomial Regression in the context of Supervised Learning: Regression.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Polynomial Regression</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 28, NULL, 0, '2025-12-24 17:05:33', '2025-12-24 17:05:33', 0, 0, 1, 30),
(3569, '8e86ef33-37d4-4534-9c7c-0fd760621d6b', 911, 'Regularization', 'text', '<h2>Regularization</h2><p>This lesson covers Regularization in the context of Supervised Learning: Regression.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Regularization</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 23, NULL, 0, '2025-12-24 17:05:33', '2025-12-24 17:05:33', 0, 0, 1, 30),
(3570, '553ec84a-a6f1-4d91-adf4-487968c5a4b1', 911, 'Evaluation Metrics', 'text', '<h2>Evaluation Metrics</h2><p>This lesson covers Evaluation Metrics in the context of Supervised Learning: Regression.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Evaluation Metrics</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 30, NULL, 0, '2025-12-24 17:05:33', '2025-12-24 17:05:33', 0, 0, 1, 30),
(3571, '393df710-3825-47ff-97da-ef882f21a291', 912, 'Logistic Regression', 'text', '<h2>Logistic Regression</h2><p>This lesson covers Logistic Regression in the context of Supervised Learning: Classification.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Logistic Regression</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 37, NULL, 0, '2025-12-24 17:05:34', '2025-12-24 17:05:34', 0, 0, 1, 30),
(3572, '1e0e37e6-f0e9-4dc8-8f66-6e78715aa8ae', 912, 'Decision Trees', 'text', '<h2>Decision Trees</h2><p>This lesson covers Decision Trees in the context of Supervised Learning: Classification.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Decision Trees</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 25, NULL, 0, '2025-12-24 17:05:34', '2025-12-24 17:05:34', 0, 0, 1, 30),
(3573, '8da9c49b-693e-43ab-852f-4624a2134e0e', 912, 'Random Forests', 'text', '<h2>Random Forests</h2><p>This lesson covers Random Forests in the context of Supervised Learning: Classification.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Random Forests</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 35, NULL, 0, '2025-12-24 17:05:34', '2025-12-24 17:05:34', 0, 0, 1, 30),
(3574, '783fa400-defa-4342-9af2-bec371fbf134', 912, 'SVM', 'text', '<h2>SVM</h2><p>This lesson covers SVM in the context of Supervised Learning: Classification.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of SVM</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 21, NULL, 0, '2025-12-24 17:05:34', '2025-12-24 17:05:34', 0, 0, 1, 30),
(3575, 'a38053a1-99ae-497f-9f7f-ada07138c6a7', 913, 'Train/Test Split', 'text', '<h2>Train/Test Split</h2><p>This lesson covers Train/Test Split in the context of Model Evaluation.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Train/Test Split</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 23, NULL, 0, '2025-12-24 17:05:34', '2025-12-24 17:05:34', 0, 0, 1, 30),
(3576, '728ce615-34ef-456d-966e-8eaa3067fbef', 913, 'Cross-Validation', 'text', '<h2>Cross-Validation</h2><p>This lesson covers Cross-Validation in the context of Model Evaluation.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Cross-Validation</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 24, NULL, 0, '2025-12-24 17:05:34', '2025-12-24 17:05:34', 0, 0, 1, 30),
(3577, '3c9ee6e7-254a-47b2-a707-3912165c1e0b', 913, 'Confusion Matrix', 'text', '<h2>Confusion Matrix</h2><p>This lesson covers Confusion Matrix in the context of Model Evaluation.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Confusion Matrix</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 39, NULL, 0, '2025-12-24 17:05:34', '2025-12-24 17:05:34', 0, 0, 1, 30),
(3578, 'e5461d15-b4f9-4692-b937-675456709236', 913, 'ROC and AUC', 'text', '<h2>ROC and AUC</h2><p>This lesson covers ROC and AUC in the context of Model Evaluation.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of ROC and AUC</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 38, NULL, 0, '2025-12-24 17:05:34', '2025-12-24 17:05:34', 0, 0, 1, 30),
(3579, '927e3fa5-9bd7-4337-a9fa-b5e431ec7bbf', 914, 'Clustering Algorithms', 'text', '<h2>Clustering Algorithms</h2><p>This lesson covers Clustering Algorithms in the context of Unsupervised Learning.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Clustering Algorithms</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 18, NULL, 0, '2025-12-24 17:05:34', '2025-12-24 17:05:34', 0, 0, 1, 30),
(3580, '953af0df-e3a1-44dc-8409-e4257c77c07f', 914, 'K-Means', 'text', '<h2>K-Means</h2><p>This lesson covers K-Means in the context of Unsupervised Learning.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of K-Means</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 33, NULL, 0, '2025-12-24 17:05:34', '2025-12-24 17:05:34', 0, 0, 1, 30),
(3581, 'd6169a1a-7119-49dd-b32d-8e59298b6820', 914, 'Hierarchical Clustering', 'text', '<h2>Hierarchical Clustering</h2><p>This lesson covers Hierarchical Clustering in the context of Unsupervised Learning.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Hierarchical Clustering</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 18, NULL, 0, '2025-12-24 17:05:34', '2025-12-24 17:05:34', 0, 0, 1, 30),
(3582, '62160036-9dd5-430a-95f0-d44a2b67cc39', 914, 'DBSCAN', 'text', '<h2>DBSCAN</h2><p>This lesson covers DBSCAN in the context of Unsupervised Learning.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of DBSCAN</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 24, NULL, 0, '2025-12-24 17:05:34', '2025-12-24 17:05:34', 0, 0, 1, 30),
(3583, 'bcf73c4d-1a47-4060-9681-6f2e0244d3d1', 915, 'PCA', 'text', '<h2>PCA</h2><p>This lesson covers PCA in the context of Dimensionality Reduction.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of PCA</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 28, NULL, 0, '2025-12-24 17:05:34', '2025-12-24 17:05:34', 0, 0, 1, 30),
(3584, '8d250da9-bc09-4cdb-99ae-afcb94433046', 915, 't-SNE', 'text', '<h2>t-SNE</h2><p>This lesson covers t-SNE in the context of Dimensionality Reduction.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of t-SNE</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 15, NULL, 0, '2025-12-24 17:05:34', '2025-12-24 17:05:34', 0, 0, 1, 30),
(3585, '30129802-ad0d-436e-a768-7ec66922135f', 915, 'Feature Selection', 'text', '<h2>Feature Selection</h2><p>This lesson covers Feature Selection in the context of Dimensionality Reduction.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Feature Selection</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 18, NULL, 0, '2025-12-24 17:05:35', '2025-12-24 17:05:35', 0, 0, 1, 30),
(3586, 'de632561-92bc-42e4-86c7-bc46fe231534', 915, 'Autoencoders', 'text', '<h2>Autoencoders</h2><p>This lesson covers Autoencoders in the context of Dimensionality Reduction.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Autoencoders</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 19, NULL, 0, '2025-12-24 17:05:35', '2025-12-24 17:05:35', 0, 0, 1, 30),
(3587, '4f79eb0b-2508-4ce2-9ed2-d2614b690623', 916, 'Bagging', 'text', '<h2>Bagging</h2><p>This lesson covers Bagging in the context of Ensemble Methods.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Bagging</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 34, NULL, 0, '2025-12-24 17:05:35', '2025-12-24 17:05:35', 0, 0, 1, 30),
(3588, 'bc9415b2-8a3f-48e1-a83f-e9af2917e233', 916, 'Boosting', 'text', '<h2>Boosting</h2><p>This lesson covers Boosting in the context of Ensemble Methods.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Boosting</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 28, NULL, 0, '2025-12-24 17:05:35', '2025-12-24 17:05:35', 0, 0, 1, 30),
(3589, '1bda962d-ca9b-450f-829a-65393ff902cd', 916, 'XGBoost', 'text', '<h2>XGBoost</h2><p>This lesson covers XGBoost in the context of Ensemble Methods.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of XGBoost</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 24, NULL, 0, '2025-12-24 17:05:35', '2025-12-24 17:05:35', 0, 0, 1, 30),
(3590, 'd7dcd7c7-c914-422a-b618-c66268f0f677', 916, 'Stacking', 'text', '<h2>Stacking</h2><p>This lesson covers Stacking in the context of Ensemble Methods.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Stacking</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 30, NULL, 0, '2025-12-24 17:05:35', '2025-12-24 17:05:35', 0, 0, 1, 30),
(3591, 'ef8f545e-11ef-43b9-ad04-637c0724eeff', 917, 'Pipeline Creation', 'text', '<h2>Pipeline Creation</h2><p>This lesson covers Pipeline Creation in the context of Scikit-learn in Practice.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Pipeline Creation</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 23, NULL, 0, '2025-12-24 17:05:35', '2025-12-24 17:05:35', 0, 0, 1, 30),
(3592, 'f32cf791-07e6-49f6-b158-4a71f8cfbdbd', 917, 'Grid Search', 'text', '<h2>Grid Search</h2><p>This lesson covers Grid Search in the context of Scikit-learn in Practice.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Grid Search</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 31, NULL, 0, '2025-12-24 17:05:35', '2025-12-24 17:05:35', 0, 0, 1, 30),
(3593, 'e03ecbee-de96-44b3-b42b-9749810fdb43', 917, 'Model Persistence', 'text', '<h2>Model Persistence</h2><p>This lesson covers Model Persistence in the context of Scikit-learn in Practice.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Model Persistence</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 44, NULL, 0, '2025-12-24 17:05:35', '2025-12-24 17:05:35', 0, 0, 1, 30),
(3594, '4250f370-8b29-4c4c-9db3-f5b6cb6ef825', 917, 'Best Practices', 'text', '<h2>Best Practices</h2><p>This lesson covers Best Practices in the context of Scikit-learn in Practice.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Best Practices</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 21, NULL, 0, '2025-12-24 17:05:35', '2025-12-24 17:05:35', 0, 0, 1, 30);
INSERT INTO `lessons` (`id`, `uuid`, `module_id`, `title`, `type`, `content`, `order_index`, `duration_minutes`, `resources`, `ai_generated`, `created_at`, `updated_at`, `has_practical`, `has_quiz`, `competency_weight`, `estimated_time_minutes`) VALUES
(3595, '3252121c-eb36-42b1-affd-6e5c9d029632', 918, 'Perceptrons', 'text', '<h2>Perceptrons</h2><p>This lesson covers Perceptrons in the context of Introduction to Neural Networks.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Perceptrons</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 45, NULL, 0, '2025-12-24 17:05:35', '2025-12-24 17:05:35', 0, 0, 1, 30),
(3596, '306b828c-5aba-4837-8fe9-219326fa0a20', 918, 'Activation Functions', 'text', '<h2>Activation Functions</h2><p>This lesson covers Activation Functions in the context of Introduction to Neural Networks.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Activation Functions</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 38, NULL, 0, '2025-12-24 17:05:35', '2025-12-24 17:05:35', 0, 0, 1, 30),
(3597, 'b81225a5-0462-45aa-8c91-5aa118023450', 918, 'Forward Propagation', 'text', '<h2>Forward Propagation</h2><p>This lesson covers Forward Propagation in the context of Introduction to Neural Networks.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Forward Propagation</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 33, NULL, 0, '2025-12-24 17:05:36', '2025-12-24 17:05:36', 0, 0, 1, 30),
(3598, '58a7896e-d5ce-442c-b891-8bb69f3883db', 918, 'Backpropagation', 'text', '<h2>Backpropagation</h2><p>This lesson covers Backpropagation in the context of Introduction to Neural Networks.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Backpropagation</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 21, NULL, 0, '2025-12-24 17:05:36', '2025-12-24 17:05:36', 0, 0, 1, 30),
(3599, '2ccd84fe-76d6-4792-b5fe-6ee318ceb81d', 919, 'Deep Networks', 'text', '<h2>Deep Networks</h2><p>This lesson covers Deep Networks in the context of Deep Learning Fundamentals.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Deep Networks</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 15, NULL, 0, '2025-12-24 17:05:36', '2025-12-24 17:05:36', 0, 0, 1, 30),
(3600, '767d89a6-2f0a-47f9-8619-9749469bc635', 919, 'Gradient Descent', 'text', '<h2>Gradient Descent</h2><p>This lesson covers Gradient Descent in the context of Deep Learning Fundamentals.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Gradient Descent</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 42, NULL, 0, '2025-12-24 17:05:36', '2025-12-24 17:05:36', 0, 0, 1, 30),
(3601, 'ce7d4534-0936-48f7-ac7f-719fb06150de', 919, 'Optimizers', 'text', '<h2>Optimizers</h2><p>This lesson covers Optimizers in the context of Deep Learning Fundamentals.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Optimizers</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 33, NULL, 0, '2025-12-24 17:05:36', '2025-12-24 17:05:36', 0, 0, 1, 30),
(3602, 'fb7d01e6-3260-45fd-ae03-35ee63152d16', 919, 'Regularization', 'text', '<h2>Regularization</h2><p>This lesson covers Regularization in the context of Deep Learning Fundamentals.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Regularization</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 41, NULL, 0, '2025-12-24 17:05:37', '2025-12-24 17:05:37', 0, 0, 1, 30),
(3603, '04b254fb-f3d8-48fa-b4a7-3067951efbc4', 920, 'TensorFlow Setup', 'text', '<h2>TensorFlow Setup</h2><p>This lesson covers TensorFlow Setup in the context of TensorFlow Basics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of TensorFlow Setup</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 45, NULL, 0, '2025-12-24 17:05:37', '2025-12-24 17:05:37', 0, 0, 1, 30),
(3604, '4260df96-af4a-4962-bef1-c9130d5cd3b5', 920, 'Tensors', 'text', '<h2>Tensors</h2><p>This lesson covers Tensors in the context of TensorFlow Basics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Tensors</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 21, NULL, 0, '2025-12-24 17:05:37', '2025-12-24 17:05:37', 0, 0, 1, 30),
(3605, '06e5eba1-f7d9-4f68-89c9-340d38a48cca', 920, 'Building Models', 'text', '<h2>Building Models</h2><p>This lesson covers Building Models in the context of TensorFlow Basics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Building Models</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 19, NULL, 0, '2025-12-24 17:05:37', '2025-12-24 17:05:37', 0, 0, 1, 30),
(3606, 'd4410f50-15b7-4dd5-85a7-256a849d136e', 920, 'Training Loops', 'text', '<h2>Training Loops</h2><p>This lesson covers Training Loops in the context of TensorFlow Basics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Training Loops</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 31, NULL, 0, '2025-12-24 17:05:37', '2025-12-24 17:05:37', 0, 0, 1, 30),
(3607, '1677205a-81a1-4862-beb8-7fbc9bdf2d36', 921, 'Keras API', 'text', '<h2>Keras API</h2><p>This lesson covers Keras API in the context of Keras for Deep Learning.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Keras API</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 19, NULL, 0, '2025-12-24 17:05:37', '2025-12-24 17:05:37', 0, 0, 1, 30),
(3608, 'fd5fd86a-5d6d-472e-82b9-25823533cbbd', 921, 'Sequential Models', 'text', '<h2>Sequential Models</h2><p>This lesson covers Sequential Models in the context of Keras for Deep Learning.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Sequential Models</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 34, NULL, 0, '2025-12-24 17:05:37', '2025-12-24 17:05:37', 0, 0, 1, 30),
(3609, 'a904fa39-bcf0-44a0-baae-cc8823309568', 921, 'Functional API', 'text', '<h2>Functional API</h2><p>This lesson covers Functional API in the context of Keras for Deep Learning.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Functional API</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 18, NULL, 0, '2025-12-24 17:05:37', '2025-12-24 17:05:37', 0, 0, 1, 30),
(3610, '18b952e3-5374-4601-b738-2035f96caade', 921, 'Callbacks', 'text', '<h2>Callbacks</h2><p>This lesson covers Callbacks in the context of Keras for Deep Learning.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Callbacks</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 39, NULL, 0, '2025-12-24 17:05:37', '2025-12-24 17:05:37', 0, 0, 1, 30),
(3611, '7fc07ed3-0a8f-4e87-8508-7583914e4562', 922, 'Convolutions', 'text', '<h2>Convolutions</h2><p>This lesson covers Convolutions in the context of CNNs for Computer Vision.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Convolutions</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 37, NULL, 0, '2025-12-24 17:05:38', '2025-12-24 17:05:38', 0, 0, 1, 30),
(3612, '56fed184-c84d-4939-b839-756817a420f9', 922, 'Pooling', 'text', '<h2>Pooling</h2><p>This lesson covers Pooling in the context of CNNs for Computer Vision.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Pooling</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 25, NULL, 0, '2025-12-24 17:05:38', '2025-12-24 17:05:38', 0, 0, 1, 30),
(3613, '3b46acd4-5463-42be-89a7-b08732587557', 922, 'CNN Architectures', 'text', '<h2>CNN Architectures</h2><p>This lesson covers CNN Architectures in the context of CNNs for Computer Vision.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of CNN Architectures</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 33, NULL, 0, '2025-12-24 17:05:38', '2025-12-24 17:05:38', 0, 0, 1, 30),
(3614, '8b2f1b00-9af5-48f2-8222-f32df77e032e', 922, 'Image Classification', 'text', '<h2>Image Classification</h2><p>This lesson covers Image Classification in the context of CNNs for Computer Vision.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Image Classification</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 26, NULL, 0, '2025-12-24 17:05:38', '2025-12-24 17:05:38', 0, 0, 1, 30),
(3615, '250b8c46-1c0c-4702-899a-ff6dd093a0c1', 923, 'Transfer Learning', 'text', '<h2>Transfer Learning</h2><p>This lesson covers Transfer Learning in the context of Advanced CNN Topics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Transfer Learning</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 35, NULL, 0, '2025-12-24 17:05:38', '2025-12-24 17:05:38', 0, 0, 1, 30),
(3616, '3678d0b0-eaac-4ed8-bd17-01114904499e', 923, 'Object Detection', 'text', '<h2>Object Detection</h2><p>This lesson covers Object Detection in the context of Advanced CNN Topics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Object Detection</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 40, NULL, 0, '2025-12-24 17:05:38', '2025-12-24 17:05:38', 0, 0, 1, 30),
(3617, 'a8a1681f-e0ec-42a5-9869-6910e8bf87d9', 923, 'Image Segmentation', 'text', '<h2>Image Segmentation</h2><p>This lesson covers Image Segmentation in the context of Advanced CNN Topics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Image Segmentation</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 15, NULL, 0, '2025-12-24 17:05:38', '2025-12-24 17:05:38', 0, 0, 1, 30),
(3618, '757c8ff3-91d3-4e4d-866a-1fbc64072365', 923, 'Data Augmentation', 'text', '<h2>Data Augmentation</h2><p>This lesson covers Data Augmentation in the context of Advanced CNN Topics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Data Augmentation</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 21, NULL, 0, '2025-12-24 17:05:38', '2025-12-24 17:05:38', 0, 0, 1, 30),
(3619, '9ba3819e-6e4a-4c35-91e3-71eeaa772470', 924, 'RNN Basics', 'text', '<h2>RNN Basics</h2><p>This lesson covers RNN Basics in the context of Recurrent Neural Networks.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of RNN Basics</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 24, NULL, 0, '2025-12-24 17:05:38', '2025-12-24 17:05:38', 0, 0, 1, 30),
(3620, '1aeb1713-0b24-4967-8a6f-d45a687e1f53', 924, 'LSTM', 'text', '<h2>LSTM</h2><p>This lesson covers LSTM in the context of Recurrent Neural Networks.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of LSTM</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 41, NULL, 0, '2025-12-24 17:05:38', '2025-12-24 17:05:38', 0, 0, 1, 30),
(3621, '7e0c83d9-9a25-45cf-874b-298f5e4ee323', 924, 'GRU', 'text', '<h2>GRU</h2><p>This lesson covers GRU in the context of Recurrent Neural Networks.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of GRU</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 19, NULL, 0, '2025-12-24 17:05:38', '2025-12-24 17:05:38', 0, 0, 1, 30),
(3622, '0bd8e9a0-b23f-4f11-862d-321680007a7c', 924, 'Sequence Modeling', 'text', '<h2>Sequence Modeling</h2><p>This lesson covers Sequence Modeling in the context of Recurrent Neural Networks.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Sequence Modeling</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 32, NULL, 0, '2025-12-24 17:05:38', '2025-12-24 17:05:38', 0, 0, 1, 30),
(3623, 'a4026a35-0765-422d-95d6-8fae725f3e15', 925, 'Text Preprocessing', 'text', '<h2>Text Preprocessing</h2><p>This lesson covers Text Preprocessing in the context of Natural Language Processing.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Text Preprocessing</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 32, NULL, 0, '2025-12-24 17:05:38', '2025-12-24 17:05:38', 0, 0, 1, 30),
(3624, '0c2cce96-2576-45e2-bf52-60825ba4e784', 925, 'Word Embeddings', 'text', '<h2>Word Embeddings</h2><p>This lesson covers Word Embeddings in the context of Natural Language Processing.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Word Embeddings</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 21, NULL, 0, '2025-12-24 17:05:39', '2025-12-24 17:05:39', 0, 0, 1, 30),
(3625, '7c5a7d13-d721-4b31-ab7e-98a7b1cdfa46', 925, 'Text Classification', 'text', '<h2>Text Classification</h2><p>This lesson covers Text Classification in the context of Natural Language Processing.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Text Classification</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 23, NULL, 0, '2025-12-24 17:05:39', '2025-12-24 17:05:39', 0, 0, 1, 30),
(3626, '4128d849-76e3-44d7-a182-b960d6ba306a', 925, 'Named Entity Recognition', 'text', '<h2>Named Entity Recognition</h2><p>This lesson covers Named Entity Recognition in the context of Natural Language Processing.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Named Entity Recognition</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 26, NULL, 0, '2025-12-24 17:05:39', '2025-12-24 17:05:39', 0, 0, 1, 30),
(3627, 'ae1aa502-9167-415a-9cf5-c2c95f067a78', 926, 'Attention Mechanism', 'text', '<h2>Attention Mechanism</h2><p>This lesson covers Attention Mechanism in the context of Transformers and Attention.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Attention Mechanism</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 39, NULL, 0, '2025-12-24 17:05:39', '2025-12-24 17:05:39', 0, 0, 1, 30),
(3628, 'd9427500-b8a5-4aa7-a695-bd3ffe9d24cf', 926, 'Transformer Architecture', 'text', '<h2>Transformer Architecture</h2><p>This lesson covers Transformer Architecture in the context of Transformers and Attention.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Transformer Architecture</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 41, NULL, 0, '2025-12-24 17:05:39', '2025-12-24 17:05:39', 0, 0, 1, 30),
(3629, 'd17d2c09-4564-4f0f-a8e6-f3f9ce17d492', 926, 'BERT', 'text', '<h2>BERT</h2><p>This lesson covers BERT in the context of Transformers and Attention.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of BERT</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 32, NULL, 0, '2025-12-24 17:05:39', '2025-12-24 17:05:39', 0, 0, 1, 30),
(3630, 'f2180254-9233-4904-8809-4c4464a79764', 926, 'GPT Models', 'text', '<h2>GPT Models</h2><p>This lesson covers GPT Models in the context of Transformers and Attention.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of GPT Models</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 33, NULL, 0, '2025-12-24 17:05:39', '2025-12-24 17:05:39', 0, 0, 1, 30),
(3631, 'b6446298-eed8-4416-b6ce-cbbb8f3029b7', 927, 'GANs', 'text', '<h2>GANs</h2><p>This lesson covers GANs in the context of Generative AI.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of GANs</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 44, NULL, 0, '2025-12-24 17:05:39', '2025-12-24 17:05:39', 0, 0, 1, 30),
(3632, '52bf4ce9-e779-42c1-9e51-4712d5bde8e5', 927, 'VAEs', 'text', '<h2>VAEs</h2><p>This lesson covers VAEs in the context of Generative AI.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of VAEs</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 41, NULL, 0, '2025-12-24 17:05:39', '2025-12-24 17:05:39', 0, 0, 1, 30),
(3633, '771de1e2-1afa-47a5-940f-b3360e569c65', 927, 'Diffusion Models', 'text', '<h2>Diffusion Models</h2><p>This lesson covers Diffusion Models in the context of Generative AI.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Diffusion Models</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 27, NULL, 0, '2025-12-24 17:05:39', '2025-12-24 17:05:39', 0, 0, 1, 30),
(3634, 'd84a34ef-c865-411a-b0f0-68304a92f687', 927, 'Image Generation', 'text', '<h2>Image Generation</h2><p>This lesson covers Image Generation in the context of Generative AI.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Image Generation</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 27, NULL, 0, '2025-12-24 17:05:39', '2025-12-24 17:05:39', 0, 0, 1, 30),
(3635, '88c3428c-872d-4717-9266-46ca04af7135', 928, 'RL Basics', 'text', '<h2>RL Basics</h2><p>This lesson covers RL Basics in the context of Reinforcement Learning.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of RL Basics</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 31, NULL, 0, '2025-12-24 17:05:39', '2025-12-24 17:05:39', 0, 0, 1, 30),
(3636, '87fc8b4c-1482-4592-aa5c-4590b1e5618e', 928, 'Q-Learning', 'text', '<h2>Q-Learning</h2><p>This lesson covers Q-Learning in the context of Reinforcement Learning.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Q-Learning</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 25, NULL, 0, '2025-12-24 17:05:39', '2025-12-24 17:05:39', 0, 0, 1, 30),
(3637, 'c3a553c4-22fd-41c9-8072-929fff72d467', 928, 'Policy Gradient', 'text', '<h2>Policy Gradient</h2><p>This lesson covers Policy Gradient in the context of Reinforcement Learning.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Policy Gradient</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 33, NULL, 0, '2025-12-24 17:05:39', '2025-12-24 17:05:39', 0, 0, 1, 30),
(3638, 'ce1e6553-a125-4864-88b5-a445b021ecaf', 928, 'Deep RL', 'text', '<h2>Deep RL</h2><p>This lesson covers Deep RL in the context of Reinforcement Learning.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Deep RL</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 16, NULL, 0, '2025-12-24 17:05:39', '2025-12-24 17:05:39', 0, 0, 1, 30),
(3639, '4a79d00a-4b62-4816-89f7-b924bdd4feed', 929, 'ML Lifecycle', 'text', '<h2>ML Lifecycle</h2><p>This lesson covers ML Lifecycle in the context of MLOps Introduction.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of ML Lifecycle</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 40, NULL, 0, '2025-12-24 17:05:40', '2025-12-24 17:05:40', 0, 0, 1, 30),
(3640, 'c0c1db03-71f3-4248-ac95-380484231650', 929, 'Model Versioning', 'text', '<h2>Model Versioning</h2><p>This lesson covers Model Versioning in the context of MLOps Introduction.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Model Versioning</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 15, NULL, 0, '2025-12-24 17:05:40', '2025-12-24 17:05:40', 0, 0, 1, 30),
(3641, 'ed4bbfb9-3850-42db-ad4b-8ea3b5f764da', 929, 'Experiment Tracking', 'text', '<h2>Experiment Tracking</h2><p>This lesson covers Experiment Tracking in the context of MLOps Introduction.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Experiment Tracking</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 29, NULL, 0, '2025-12-24 17:05:40', '2025-12-24 17:05:40', 0, 0, 1, 30),
(3642, '21afb48f-283e-48b6-b601-267da4ed774a', 929, 'MLflow', 'text', '<h2>MLflow</h2><p>This lesson covers MLflow in the context of MLOps Introduction.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of MLflow</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 22, NULL, 0, '2025-12-24 17:05:40', '2025-12-24 17:05:40', 0, 0, 1, 30),
(3643, '8371df30-f89c-41e3-9c82-5622b31f51b5', 930, 'Model Serving', 'text', '<h2>Model Serving</h2><p>This lesson covers Model Serving in the context of Model Deployment.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Model Serving</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 35, NULL, 0, '2025-12-24 17:05:40', '2025-12-24 17:05:40', 0, 0, 1, 30),
(3644, '1ee8c043-7d6c-4e39-9184-f5e90eacebcc', 930, 'API Creation', 'text', '<h2>API Creation</h2><p>This lesson covers API Creation in the context of Model Deployment.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of API Creation</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 22, NULL, 0, '2025-12-24 17:05:40', '2025-12-24 17:05:40', 0, 0, 1, 30),
(3645, '20b48527-67ea-4267-871c-e389851df1ea', 930, 'Docker for ML', 'text', '<h2>Docker for ML</h2><p>This lesson covers Docker for ML in the context of Model Deployment.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Docker for ML</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 44, NULL, 0, '2025-12-24 17:05:40', '2025-12-24 17:05:40', 0, 0, 1, 30),
(3646, '7f3b74cd-3653-4a72-a585-a382f24c0635', 930, 'Cloud Deployment', 'text', '<h2>Cloud Deployment</h2><p>This lesson covers Cloud Deployment in the context of Model Deployment.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Cloud Deployment</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 26, NULL, 0, '2025-12-24 17:05:40', '2025-12-24 17:05:40', 0, 0, 1, 30),
(3647, '58f6470a-ee96-4115-b4e5-4f437932cb1d', 931, 'Project Planning', 'text', '<h2>Project Planning</h2><p>This lesson covers Project Planning in the context of AI Project Management.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Project Planning</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 17, NULL, 0, '2025-12-24 17:05:41', '2025-12-24 17:05:41', 0, 0, 1, 30),
(3648, 'ad6f9314-8922-4730-9546-c9a2b5557c5f', 931, 'Data Strategy', 'text', '<h2>Data Strategy</h2><p>This lesson covers Data Strategy in the context of AI Project Management.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Data Strategy</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 33, NULL, 0, '2025-12-24 17:05:41', '2025-12-24 17:05:41', 0, 0, 1, 30),
(3649, '248c39c4-6507-458b-940f-8cae70692b6e', 931, 'Team Collaboration', 'text', '<h2>Team Collaboration</h2><p>This lesson covers Team Collaboration in the context of AI Project Management.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Team Collaboration</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 20, NULL, 0, '2025-12-24 17:05:41', '2025-12-24 17:05:41', 0, 0, 1, 30),
(3650, '751796fc-b454-49b4-9c68-8c960ce19332', 931, 'Documentation', 'text', '<h2>Documentation</h2><p>This lesson covers Documentation in the context of AI Project Management.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Documentation</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 36, NULL, 0, '2025-12-24 17:05:41', '2025-12-24 17:05:41', 0, 0, 1, 30),
(3651, 'f337ea58-a7c6-4242-8286-6a6933ce9322', 932, 'Project Selection', 'text', '<h2>Project Selection</h2><p>This lesson covers Project Selection in the context of AI Capstone Project.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Project Selection</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 22, NULL, 0, '2025-12-24 17:05:41', '2025-12-24 17:05:41', 0, 0, 1, 30),
(3652, '1d8acfdd-c023-4025-aa88-51a6ee47ba93', 932, 'Implementation', 'text', '<h2>Implementation</h2><p>This lesson covers Implementation in the context of AI Capstone Project.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Implementation</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 41, NULL, 0, '2025-12-24 17:05:41', '2025-12-24 17:05:41', 0, 0, 1, 30),
(3653, '598b0b60-79c7-435a-b142-ce96e545d235', 932, 'Evaluation', 'text', '<h2>Evaluation</h2><p>This lesson covers Evaluation in the context of AI Capstone Project.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Evaluation</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 42, NULL, 0, '2025-12-24 17:05:41', '2025-12-24 17:05:41', 0, 0, 1, 30),
(3654, 'a90b6ed9-6aa9-4272-bd11-d47ddbc7ddf5', 932, 'Presentation', 'text', '<h2>Presentation</h2><p>This lesson covers Presentation in the context of AI Capstone Project.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Presentation</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 40, NULL, 0, '2025-12-24 17:05:41', '2025-12-24 17:05:41', 0, 0, 1, 30),
(3655, 'f60f39b1-15db-4748-ae4e-9eaa341e4139', 933, 'What is Data Science?', 'text', '<h2>What is Data Science?</h2><p>This lesson covers What is Data Science? in the context of Data Science Introduction.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of What is Data Science?</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 17, NULL, 0, '2025-12-24 17:05:41', '2025-12-24 17:05:41', 0, 0, 1, 30),
(3656, 'bff0fe81-41e8-4d9a-a53f-58bd5142675f', 933, 'Data Science Process', 'text', '<h2>Data Science Process</h2><p>This lesson covers Data Science Process in the context of Data Science Introduction.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Data Science Process</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 41, NULL, 0, '2025-12-24 17:05:41', '2025-12-24 17:05:41', 0, 0, 1, 30),
(3657, 'fd3e729d-46f3-43f3-9328-505a0b5f768c', 933, 'Career Paths', 'text', '<h2>Career Paths</h2><p>This lesson covers Career Paths in the context of Data Science Introduction.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Career Paths</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 29, NULL, 0, '2025-12-24 17:05:41', '2025-12-24 17:05:41', 0, 0, 1, 30),
(3658, '13cd780f-0aa2-4e6d-aa39-78a419602030', 933, 'Tools Overview', 'text', '<h2>Tools Overview</h2><p>This lesson covers Tools Overview in the context of Data Science Introduction.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Tools Overview</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 20, NULL, 0, '2025-12-24 17:05:41', '2025-12-24 17:05:41', 0, 0, 1, 30),
(3659, '86f5f20d-a09f-4a26-9583-d427ac7efc64', 934, 'Anaconda Installation', 'text', '<h2>Anaconda Installation</h2><p>This lesson covers Anaconda Installation in the context of Python Environment Setup.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Anaconda Installation</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 19, NULL, 0, '2025-12-24 17:05:42', '2025-12-24 17:05:42', 0, 0, 1, 30),
(3660, '7e3fa1cd-b08c-4bf7-92d9-b258d229a03f', 934, 'Jupyter Notebooks', 'text', '<h2>Jupyter Notebooks</h2><p>This lesson covers Jupyter Notebooks in the context of Python Environment Setup.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Jupyter Notebooks</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 31, NULL, 0, '2025-12-24 17:05:42', '2025-12-24 17:05:42', 0, 0, 1, 30),
(3661, '7a241b9d-9744-4d9b-abf7-638005d4fa8a', 934, 'Virtual Environments', 'text', '<h2>Virtual Environments</h2><p>This lesson covers Virtual Environments in the context of Python Environment Setup.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Virtual Environments</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 43, NULL, 0, '2025-12-24 17:05:42', '2025-12-24 17:05:42', 0, 0, 1, 30),
(3662, 'aefda9d0-e382-41a4-9f3f-e034434ca273', 934, 'Package Management', 'text', '<h2>Package Management</h2><p>This lesson covers Package Management in the context of Python Environment Setup.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Package Management</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 34, NULL, 0, '2025-12-24 17:05:42', '2025-12-24 17:05:42', 0, 0, 1, 30),
(3663, 'db873f06-28cb-42e7-8977-f0e1604ef05e', 935, 'Python Fundamentals', 'text', '<h2>Python Fundamentals</h2><p>This lesson covers Python Fundamentals in the context of Python for Data Science.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Python Fundamentals</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 37, NULL, 0, '2025-12-24 17:05:42', '2025-12-24 17:05:42', 0, 0, 1, 30),
(3664, '8f6957fd-a31f-451e-aefe-67aa6a951d47', 935, 'Functions', 'text', '<h2>Functions</h2><p>This lesson covers Functions in the context of Python for Data Science.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Functions</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 30, NULL, 0, '2025-12-24 17:05:42', '2025-12-24 17:05:42', 0, 0, 1, 30),
(3665, '13943198-ff12-42c7-bf31-8d4a51c1f01d', 935, 'Object-Oriented Python', 'text', '<h2>Object-Oriented Python</h2><p>This lesson covers Object-Oriented Python in the context of Python for Data Science.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Object-Oriented Python</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 43, NULL, 0, '2025-12-24 17:05:42', '2025-12-24 17:05:42', 0, 0, 1, 30),
(3666, 'be275cac-9ce7-45ce-a353-9479c0ca3d81', 935, 'File I/O', 'text', '<h2>File I/O</h2><p>This lesson covers File I/O in the context of Python for Data Science.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of File I/O</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 19, NULL, 0, '2025-12-24 17:05:42', '2025-12-24 17:05:42', 0, 0, 1, 30),
(3667, 'db018afa-0381-40b4-b81c-200af5996238', 936, 'Array Creation', 'text', '<h2>Array Creation</h2><p>This lesson covers Array Creation in the context of NumPy for Data Science.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Array Creation</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 39, NULL, 0, '2025-12-24 17:05:42', '2025-12-24 17:05:42', 0, 0, 1, 30),
(3668, '05c31d16-e5d4-4ffe-ad57-9870fca44a4a', 936, 'Array Operations', 'text', '<h2>Array Operations</h2><p>This lesson covers Array Operations in the context of NumPy for Data Science.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Array Operations</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 21, NULL, 0, '2025-12-24 17:05:42', '2025-12-24 17:05:42', 0, 0, 1, 30),
(3669, '30f39639-75b9-4dd3-9b08-3f40ed2d79f2', 936, 'Mathematical Functions', 'text', '<h2>Mathematical Functions</h2><p>This lesson covers Mathematical Functions in the context of NumPy for Data Science.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Mathematical Functions</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 33, NULL, 0, '2025-12-24 17:05:42', '2025-12-24 17:05:42', 0, 0, 1, 30),
(3670, 'd536575d-39fe-4034-a4f1-3d2cd79a0ee1', 936, 'Random Sampling', 'text', '<h2>Random Sampling</h2><p>This lesson covers Random Sampling in the context of NumPy for Data Science.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Random Sampling</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 37, NULL, 0, '2025-12-24 17:05:43', '2025-12-24 17:05:43', 0, 0, 1, 30),
(3671, '1d7e7f41-4624-4bc0-84b8-d75fff6b5daa', 937, 'Series and DataFrames', 'text', '<h2>Series and DataFrames</h2><p>This lesson covers Series and DataFrames in the context of Pandas Fundamentals.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Series and DataFrames</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 38, NULL, 0, '2025-12-24 17:05:43', '2025-12-24 17:05:43', 0, 0, 1, 30),
(3672, 'fea63c16-26e7-4d3c-97da-9e31ef52b7d1', 937, 'Data Selection', 'text', '<h2>Data Selection</h2><p>This lesson covers Data Selection in the context of Pandas Fundamentals.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Data Selection</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 35, NULL, 0, '2025-12-24 17:05:43', '2025-12-24 17:05:43', 0, 0, 1, 30),
(3673, '0810bf21-562c-4d9c-ae18-c65e8adcd92e', 937, 'Filtering', 'text', '<h2>Filtering</h2><p>This lesson covers Filtering in the context of Pandas Fundamentals.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Filtering</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 40, NULL, 0, '2025-12-24 17:05:43', '2025-12-24 17:05:43', 0, 0, 1, 30),
(3674, '5d0dda3e-ce89-4d49-8b7f-fc2cfb5d05fc', 937, 'Sorting', 'text', '<h2>Sorting</h2><p>This lesson covers Sorting in the context of Pandas Fundamentals.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Sorting</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 38, NULL, 0, '2025-12-24 17:05:43', '2025-12-24 17:05:43', 0, 0, 1, 30),
(3675, '69e51c4c-8294-4fa4-8fdf-5651eb0100a1', 938, 'Handling Missing Data', 'text', '<h2>Handling Missing Data</h2><p>This lesson covers Handling Missing Data in the context of Data Wrangling with Pandas.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Handling Missing Data</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 38, NULL, 0, '2025-12-24 17:05:43', '2025-12-24 17:05:43', 0, 0, 1, 30),
(3676, 'f52b9397-c412-40e4-afe2-102cb856347f', 938, 'Data Transformation', 'text', '<h2>Data Transformation</h2><p>This lesson covers Data Transformation in the context of Data Wrangling with Pandas.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Data Transformation</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 26, NULL, 0, '2025-12-24 17:05:43', '2025-12-24 17:05:43', 0, 0, 1, 30),
(3677, 'f19f9320-cff5-4e79-bc0a-fa174d6b2f26', 938, 'Merging and Joining', 'text', '<h2>Merging and Joining</h2><p>This lesson covers Merging and Joining in the context of Data Wrangling with Pandas.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Merging and Joining</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 25, NULL, 0, '2025-12-24 17:05:43', '2025-12-24 17:05:43', 0, 0, 1, 30),
(3678, '42aa2322-c1f0-4fb8-983c-0485bde1733a', 938, 'Reshaping Data', 'text', '<h2>Reshaping Data</h2><p>This lesson covers Reshaping Data in the context of Data Wrangling with Pandas.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Reshaping Data</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 33, NULL, 0, '2025-12-24 17:05:43', '2025-12-24 17:05:43', 0, 0, 1, 30),
(3679, 'df1029e5-0e88-49cf-a276-917e01442a9e', 939, 'EDA Process', 'text', '<h2>EDA Process</h2><p>This lesson covers EDA Process in the context of Exploratory Data Analysis.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of EDA Process</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 23, NULL, 0, '2025-12-24 17:05:43', '2025-12-24 17:05:43', 0, 0, 1, 30),
(3680, 'aa40fccc-e4e0-4549-9d53-3f26700e24f7', 939, 'Summary Statistics', 'text', '<h2>Summary Statistics</h2><p>This lesson covers Summary Statistics in the context of Exploratory Data Analysis.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Summary Statistics</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 22, NULL, 0, '2025-12-24 17:05:43', '2025-12-24 17:05:43', 0, 0, 1, 30),
(3681, '84ac7568-f757-4f2b-b87d-2a54c7315fa7', 939, 'Distribution Analysis', 'text', '<h2>Distribution Analysis</h2><p>This lesson covers Distribution Analysis in the context of Exploratory Data Analysis.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Distribution Analysis</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 29, NULL, 0, '2025-12-24 17:05:44', '2025-12-24 17:05:44', 0, 0, 1, 30),
(3682, '438bbfd4-79d1-4be5-9e4c-20df46b73ce3', 939, 'Correlation Analysis', 'text', '<h2>Correlation Analysis</h2><p>This lesson covers Correlation Analysis in the context of Exploratory Data Analysis.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Correlation Analysis</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 23, NULL, 0, '2025-12-24 17:05:44', '2025-12-24 17:05:44', 0, 0, 1, 30),
(3683, '1ce008b3-135a-4c1a-ae01-4808a138c0f0', 940, 'Identifying Issues', 'text', '<h2>Identifying Issues</h2><p>This lesson covers Identifying Issues in the context of Data Cleaning.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Identifying Issues</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 30, NULL, 0, '2025-12-24 17:05:44', '2025-12-24 17:05:44', 0, 0, 1, 30),
(3684, '22ece730-f96e-469c-9c32-9c012dde8c2a', 940, 'Handling Outliers', 'text', '<h2>Handling Outliers</h2><p>This lesson covers Handling Outliers in the context of Data Cleaning.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Handling Outliers</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 17, NULL, 0, '2025-12-24 17:05:44', '2025-12-24 17:05:44', 0, 0, 1, 30),
(3685, '18b9d4ba-5dbc-470a-ad24-9fcd2b6d7e5b', 940, 'Data Validation', 'text', '<h2>Data Validation</h2><p>This lesson covers Data Validation in the context of Data Cleaning.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Data Validation</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 40, NULL, 0, '2025-12-24 17:05:44', '2025-12-24 17:05:44', 0, 0, 1, 30),
(3686, '1be72187-035d-4456-ae04-532c9afa2db0', 940, 'Quality Assurance', 'text', '<h2>Quality Assurance</h2><p>This lesson covers Quality Assurance in the context of Data Cleaning.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Quality Assurance</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 26, NULL, 0, '2025-12-24 17:05:44', '2025-12-24 17:05:44', 0, 0, 1, 30),
(3687, '58ce92bc-54d0-4563-b36c-0d85c2a402c2', 941, 'Basic Plots', 'text', '<h2>Basic Plots</h2><p>This lesson covers Basic Plots in the context of Data Visualization with Matplotlib.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Basic Plots</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 17, NULL, 0, '2025-12-24 17:05:44', '2025-12-24 17:05:44', 0, 0, 1, 30),
(3688, 'a1ceb2b4-c033-40b3-a666-d53f102f5a08', 941, 'Customization', 'text', '<h2>Customization</h2><p>This lesson covers Customization in the context of Data Visualization with Matplotlib.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Customization</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 41, NULL, 0, '2025-12-24 17:05:45', '2025-12-24 17:05:45', 0, 0, 1, 30),
(3689, 'a5f222ac-6f96-43a6-ad89-bcf4dbfed5f8', 941, 'Subplots', 'text', '<h2>Subplots</h2><p>This lesson covers Subplots in the context of Data Visualization with Matplotlib.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Subplots</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 39, NULL, 0, '2025-12-24 17:05:45', '2025-12-24 17:05:45', 0, 0, 1, 30),
(3690, 'ec5e4d46-9663-4e86-9776-16844659a094', 941, 'Saving Figures', 'text', '<h2>Saving Figures</h2><p>This lesson covers Saving Figures in the context of Data Visualization with Matplotlib.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Saving Figures</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 34, NULL, 0, '2025-12-24 17:05:45', '2025-12-24 17:05:45', 0, 0, 1, 30),
(3691, 'b5bfb8b4-bd74-4635-8f40-64e228573b01', 942, 'Statistical Plots', 'text', '<h2>Statistical Plots</h2><p>This lesson covers Statistical Plots in the context of Advanced Visualization with Seaborn.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Statistical Plots</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 40, NULL, 0, '2025-12-24 17:05:45', '2025-12-24 17:05:45', 0, 0, 1, 30),
(3692, '8e7678a5-bd01-43cf-a88c-ec9bae06b5af', 942, 'Categorical Plots', 'text', '<h2>Categorical Plots</h2><p>This lesson covers Categorical Plots in the context of Advanced Visualization with Seaborn.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Categorical Plots</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 19, NULL, 0, '2025-12-24 17:05:45', '2025-12-24 17:05:45', 0, 0, 1, 30),
(3693, 'e74b0ef9-ddc1-43be-a69b-8eb49962509b', 942, 'Regression Plots', 'text', '<h2>Regression Plots</h2><p>This lesson covers Regression Plots in the context of Advanced Visualization with Seaborn.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Regression Plots</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 23, NULL, 0, '2025-12-24 17:05:45', '2025-12-24 17:05:45', 0, 0, 1, 30),
(3694, 'ed270efa-9fc1-4c84-b07d-8ed69a643778', 942, 'Heatmaps', 'text', '<h2>Heatmaps</h2><p>This lesson covers Heatmaps in the context of Advanced Visualization with Seaborn.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Heatmaps</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 33, NULL, 0, '2025-12-24 17:05:45', '2025-12-24 17:05:45', 0, 0, 1, 30),
(3695, 'af48159a-485e-4650-bd13-fc7cd9d25e46', 943, 'Plotly Basics', 'text', '<h2>Plotly Basics</h2><p>This lesson covers Plotly Basics in the context of Interactive Visualizations.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Plotly Basics</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 43, NULL, 0, '2025-12-24 17:05:45', '2025-12-24 17:05:45', 0, 0, 1, 30),
(3696, '2b6265b2-2be1-48b2-8a7f-1e9bf6babe00', 943, 'Interactive Charts', 'text', '<h2>Interactive Charts</h2><p>This lesson covers Interactive Charts in the context of Interactive Visualizations.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Interactive Charts</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 31, NULL, 0, '2025-12-24 17:05:45', '2025-12-24 17:05:45', 0, 0, 1, 30),
(3697, '96154893-f817-4d82-ba51-731dd3e7df92', 943, 'Dashboards', 'text', '<h2>Dashboards</h2><p>This lesson covers Dashboards in the context of Interactive Visualizations.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Dashboards</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 15, NULL, 0, '2025-12-24 17:05:45', '2025-12-24 17:05:45', 0, 0, 1, 30),
(3698, '8615c9d9-acb0-446a-955f-10ed7c44b12a', 943, 'Geographic Plots', 'text', '<h2>Geographic Plots</h2><p>This lesson covers Geographic Plots in the context of Interactive Visualizations.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Geographic Plots</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 41, NULL, 0, '2025-12-24 17:05:45', '2025-12-24 17:05:45', 0, 0, 1, 30),
(3699, '7e766864-9182-4ab1-8b2f-bc7e311b94b9', 944, 'Measures of Central Tendency', 'text', '<h2>Measures of Central Tendency</h2><p>This lesson covers Measures of Central Tendency in the context of Descriptive Statistics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Measures of Central Tendency</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 24, NULL, 0, '2025-12-24 17:05:46', '2025-12-24 17:05:46', 0, 0, 1, 30),
(3700, '9c7520bd-8333-4737-b9ee-bfbbe1dc804c', 944, 'Measures of Spread', 'text', '<h2>Measures of Spread</h2><p>This lesson covers Measures of Spread in the context of Descriptive Statistics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Measures of Spread</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 32, NULL, 0, '2025-12-24 17:05:46', '2025-12-24 17:05:46', 0, 0, 1, 30),
(3701, '093f6fc1-6e2d-4a82-af3f-74e622faed62', 944, 'Percentiles', 'text', '<h2>Percentiles</h2><p>This lesson covers Percentiles in the context of Descriptive Statistics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Percentiles</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 30, NULL, 0, '2025-12-24 17:05:46', '2025-12-24 17:05:46', 0, 0, 1, 30),
(3702, 'e6ec6e06-1842-4370-8335-be72075e9c85', 944, 'Data Summarization', 'text', '<h2>Data Summarization</h2><p>This lesson covers Data Summarization in the context of Descriptive Statistics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Data Summarization</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 31, NULL, 0, '2025-12-24 17:05:46', '2025-12-24 17:05:46', 0, 0, 1, 30),
(3703, '5ea0f8c9-dbfa-4815-8700-7c278f5ed4b2', 945, 'Basic Probability', 'text', '<h2>Basic Probability</h2><p>This lesson covers Basic Probability in the context of Probability Theory.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Basic Probability</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 28, NULL, 0, '2025-12-24 17:05:46', '2025-12-24 17:05:46', 0, 0, 1, 30),
(3704, '504e8744-5f54-41f5-9c42-afc0a4383989', 945, 'Conditional Probability', 'text', '<h2>Conditional Probability</h2><p>This lesson covers Conditional Probability in the context of Probability Theory.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Conditional Probability</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 21, NULL, 0, '2025-12-24 17:05:46', '2025-12-24 17:05:46', 0, 0, 1, 30),
(3705, '8a064990-e9bd-4aa4-90e0-8f41be25f316', 945, 'Bayes Theorem', 'text', '<h2>Bayes Theorem</h2><p>This lesson covers Bayes Theorem in the context of Probability Theory.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Bayes Theorem</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 22, NULL, 0, '2025-12-24 17:05:46', '2025-12-24 17:05:46', 0, 0, 1, 30),
(3706, '109bd6fe-3c3e-484a-9aad-3e4ebce6e635', 945, 'Expected Value', 'text', '<h2>Expected Value</h2><p>This lesson covers Expected Value in the context of Probability Theory.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Expected Value</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 24, NULL, 0, '2025-12-24 17:05:46', '2025-12-24 17:05:46', 0, 0, 1, 30),
(3707, '28f2cad4-b62f-443f-a25b-c0753ea499dd', 946, 'Normal Distribution', 'text', '<h2>Normal Distribution</h2><p>This lesson covers Normal Distribution in the context of Statistical Distributions.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Normal Distribution</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 28, NULL, 0, '2025-12-24 17:05:46', '2025-12-24 17:05:46', 0, 0, 1, 30),
(3708, '64fa41da-b784-4345-9875-7fe94b6b84e0', 946, 'Binomial Distribution', 'text', '<h2>Binomial Distribution</h2><p>This lesson covers Binomial Distribution in the context of Statistical Distributions.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Binomial Distribution</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 45, NULL, 0, '2025-12-24 17:05:46', '2025-12-24 17:05:46', 0, 0, 1, 30);
INSERT INTO `lessons` (`id`, `uuid`, `module_id`, `title`, `type`, `content`, `order_index`, `duration_minutes`, `resources`, `ai_generated`, `created_at`, `updated_at`, `has_practical`, `has_quiz`, `competency_weight`, `estimated_time_minutes`) VALUES
(3709, '58a0111e-c33a-4ad0-b744-116a5ec2b843', 946, 'Poisson Distribution', 'text', '<h2>Poisson Distribution</h2><p>This lesson covers Poisson Distribution in the context of Statistical Distributions.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Poisson Distribution</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 37, NULL, 0, '2025-12-24 17:05:46', '2025-12-24 17:05:46', 0, 0, 1, 30),
(3710, '89abd90a-8147-4503-9e8f-9cff37e052f7', 946, 'Central Limit Theorem', 'text', '<h2>Central Limit Theorem</h2><p>This lesson covers Central Limit Theorem in the context of Statistical Distributions.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Central Limit Theorem</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 26, NULL, 0, '2025-12-24 17:05:46', '2025-12-24 17:05:46', 0, 0, 1, 30),
(3711, '9c96052c-363c-4ea6-8e70-72c2c777afe2', 947, 'Null Hypothesis', 'text', '<h2>Null Hypothesis</h2><p>This lesson covers Null Hypothesis in the context of Hypothesis Testing.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Null Hypothesis</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 34, NULL, 0, '2025-12-24 17:05:47', '2025-12-24 17:05:47', 0, 0, 1, 30),
(3712, '6597d624-402c-4beb-8603-fb256be2935c', 947, 't-Tests', 'text', '<h2>t-Tests</h2><p>This lesson covers t-Tests in the context of Hypothesis Testing.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of t-Tests</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 40, NULL, 0, '2025-12-24 17:05:47', '2025-12-24 17:05:47', 0, 0, 1, 30),
(3713, 'b1299c24-e8b9-43ab-a569-de559be42be1', 947, 'Chi-Square Tests', 'text', '<h2>Chi-Square Tests</h2><p>This lesson covers Chi-Square Tests in the context of Hypothesis Testing.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Chi-Square Tests</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 27, NULL, 0, '2025-12-24 17:05:47', '2025-12-24 17:05:47', 0, 0, 1, 30),
(3714, '6252a2d2-6d64-4464-879d-fe7345e6b742', 947, 'ANOVA', 'text', '<h2>ANOVA</h2><p>This lesson covers ANOVA in the context of Hypothesis Testing.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of ANOVA</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 25, NULL, 0, '2025-12-24 17:05:47', '2025-12-24 17:05:47', 0, 0, 1, 30),
(3715, 'e5f3f4be-6b59-4828-bfdd-3c972f4c4910', 948, 'Simple Linear Regression', 'text', '<h2>Simple Linear Regression</h2><p>This lesson covers Simple Linear Regression in the context of Regression Analysis.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Simple Linear Regression</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 33, NULL, 0, '2025-12-24 17:05:47', '2025-12-24 17:05:47', 0, 0, 1, 30),
(3716, '7e325b9a-d9e2-4bdf-9e1a-af535c76ef8c', 948, 'Multiple Regression', 'text', '<h2>Multiple Regression</h2><p>This lesson covers Multiple Regression in the context of Regression Analysis.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Multiple Regression</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 39, NULL, 0, '2025-12-24 17:05:47', '2025-12-24 17:05:47', 0, 0, 1, 30),
(3717, '134fe2d8-158e-4827-93dc-632d8aaa3fa3', 948, 'Model Diagnostics', 'text', '<h2>Model Diagnostics</h2><p>This lesson covers Model Diagnostics in the context of Regression Analysis.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Model Diagnostics</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 33, NULL, 0, '2025-12-24 17:05:47', '2025-12-24 17:05:47', 0, 0, 1, 30),
(3718, '98596990-c627-4856-8c28-1a2133ce9a67', 948, 'Interpretation', 'text', '<h2>Interpretation</h2><p>This lesson covers Interpretation in the context of Regression Analysis.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Interpretation</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 19, NULL, 0, '2025-12-24 17:05:47', '2025-12-24 17:05:47', 0, 0, 1, 30),
(3719, '529f21f4-7efb-4a54-9836-7a946b54de63', 949, 'ML Overview', 'text', '<h2>ML Overview</h2><p>This lesson covers ML Overview in the context of Machine Learning for Data Science.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of ML Overview</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 31, NULL, 0, '2025-12-24 17:05:47', '2025-12-24 17:05:47', 0, 0, 1, 30),
(3720, 'e4a282e4-9e3b-47a2-bbad-17438bc8fc94', 949, 'Scikit-learn', 'text', '<h2>Scikit-learn</h2><p>This lesson covers Scikit-learn in the context of Machine Learning for Data Science.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Scikit-learn</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 24, NULL, 0, '2025-12-24 17:05:47', '2025-12-24 17:05:47', 0, 0, 1, 30),
(3721, '671be132-2d98-4a49-89f1-1d29fcab1ffb', 949, 'Model Selection', 'text', '<h2>Model Selection</h2><p>This lesson covers Model Selection in the context of Machine Learning for Data Science.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Model Selection</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 45, NULL, 0, '2025-12-24 17:05:47', '2025-12-24 17:05:47', 0, 0, 1, 30),
(3722, '2615ff46-0ae2-4cba-ae67-07bc4595b753', 949, 'Feature Engineering', 'text', '<h2>Feature Engineering</h2><p>This lesson covers Feature Engineering in the context of Machine Learning for Data Science.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Feature Engineering</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 25, NULL, 0, '2025-12-24 17:05:48', '2025-12-24 17:05:48', 0, 0, 1, 30),
(3723, '265f4785-44f6-4360-9df5-b55fdf297f9e', 950, 'Classification Algorithms', 'text', '<h2>Classification Algorithms</h2><p>This lesson covers Classification Algorithms in the context of Classification Problems.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Classification Algorithms</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 22, NULL, 0, '2025-12-24 17:05:48', '2025-12-24 17:05:48', 0, 0, 1, 30),
(3724, '6d932cbb-d942-4147-83e7-3f6352f19960', 950, 'Model Evaluation', 'text', '<h2>Model Evaluation</h2><p>This lesson covers Model Evaluation in the context of Classification Problems.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Model Evaluation</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 27, NULL, 0, '2025-12-24 17:05:48', '2025-12-24 17:05:48', 0, 0, 1, 30),
(3725, '0303c92a-6c0b-4ea5-a707-06f486e9c7ec', 950, 'Imbalanced Classes', 'text', '<h2>Imbalanced Classes</h2><p>This lesson covers Imbalanced Classes in the context of Classification Problems.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Imbalanced Classes</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 19, NULL, 0, '2025-12-24 17:05:48', '2025-12-24 17:05:48', 0, 0, 1, 30),
(3726, '300d2080-3d86-4598-b2b9-3a51e40485b5', 950, 'Multi-class Classification', 'text', '<h2>Multi-class Classification</h2><p>This lesson covers Multi-class Classification in the context of Classification Problems.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Multi-class Classification</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 30, NULL, 0, '2025-12-24 17:05:48', '2025-12-24 17:05:48', 0, 0, 1, 30),
(3727, '0ebc3c20-ffae-4c16-bb7f-8ccd42eae7ab', 951, 'Clustering Algorithms', 'text', '<h2>Clustering Algorithms</h2><p>This lesson covers Clustering Algorithms in the context of Clustering Analysis.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Clustering Algorithms</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 19, NULL, 0, '2025-12-24 17:05:48', '2025-12-24 17:05:48', 0, 0, 1, 30),
(3728, '4f31c3ee-9f1d-43d1-9670-0cfd33582c2d', 951, 'K-Means', 'text', '<h2>K-Means</h2><p>This lesson covers K-Means in the context of Clustering Analysis.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of K-Means</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 26, NULL, 0, '2025-12-24 17:05:48', '2025-12-24 17:05:48', 0, 0, 1, 30),
(3729, 'bea01c13-9214-4a41-b89a-856df913e85d', 951, 'Hierarchical Clustering', 'text', '<h2>Hierarchical Clustering</h2><p>This lesson covers Hierarchical Clustering in the context of Clustering Analysis.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Hierarchical Clustering</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 22, NULL, 0, '2025-12-24 17:05:48', '2025-12-24 17:05:48', 0, 0, 1, 30),
(3730, '3628d984-ecb2-46c4-8ac8-258d9d26dd48', 951, 'Cluster Validation', 'text', '<h2>Cluster Validation</h2><p>This lesson covers Cluster Validation in the context of Clustering Analysis.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Cluster Validation</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 18, NULL, 0, '2025-12-24 17:05:48', '2025-12-24 17:05:48', 0, 0, 1, 30),
(3731, '0e2879a9-39a4-4d17-8535-272fdeadd799', 952, 'Time Series Basics', 'text', '<h2>Time Series Basics</h2><p>This lesson covers Time Series Basics in the context of Time Series Analysis.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Time Series Basics</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 38, NULL, 0, '2025-12-24 17:05:48', '2025-12-24 17:05:48', 0, 0, 1, 30),
(3732, '049caa8a-aafb-4e7b-8121-44517c7fe6a7', 952, 'Trend and Seasonality', 'text', '<h2>Trend and Seasonality</h2><p>This lesson covers Trend and Seasonality in the context of Time Series Analysis.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Trend and Seasonality</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 33, NULL, 0, '2025-12-24 17:05:48', '2025-12-24 17:05:48', 0, 0, 1, 30),
(3733, '9361fbe5-d214-4ff2-953b-5ff1108c1eb8', 952, 'ARIMA Models', 'text', '<h2>ARIMA Models</h2><p>This lesson covers ARIMA Models in the context of Time Series Analysis.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of ARIMA Models</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 27, NULL, 0, '2025-12-24 17:05:48', '2025-12-24 17:05:48', 0, 0, 1, 30),
(3734, 'e15a9db8-6497-441b-894f-21298bc04d4f', 952, 'Forecasting', 'text', '<h2>Forecasting</h2><p>This lesson covers Forecasting in the context of Time Series Analysis.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Forecasting</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 35, NULL, 0, '2025-12-24 17:05:48', '2025-12-24 17:05:48', 0, 0, 1, 30),
(3735, '8adf8342-229c-4cda-b3bc-d991e55e728e', 953, 'SQL Basics', 'text', '<h2>SQL Basics</h2><p>This lesson covers SQL Basics in the context of SQL for Data Science.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of SQL Basics</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 35, NULL, 0, '2025-12-24 17:05:49', '2025-12-24 17:05:49', 0, 0, 1, 30),
(3736, '716e5cda-1ca1-495b-b017-78ad999de6fa', 953, 'Joins and Subqueries', 'text', '<h2>Joins and Subqueries</h2><p>This lesson covers Joins and Subqueries in the context of SQL for Data Science.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Joins and Subqueries</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 27, NULL, 0, '2025-12-24 17:05:49', '2025-12-24 17:05:49', 0, 0, 1, 30),
(3737, 'c1d2b35d-92ce-49ef-98e4-43e4e30b52f1', 953, 'Aggregations', 'text', '<h2>Aggregations</h2><p>This lesson covers Aggregations in the context of SQL for Data Science.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Aggregations</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 44, NULL, 0, '2025-12-24 17:05:49', '2025-12-24 17:05:49', 0, 0, 1, 30),
(3738, 'eec8494d-5443-4229-8e36-71bda7f8e9b7', 953, 'Window Functions', 'text', '<h2>Window Functions</h2><p>This lesson covers Window Functions in the context of SQL for Data Science.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Window Functions</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 43, NULL, 0, '2025-12-24 17:05:49', '2025-12-24 17:05:49', 0, 0, 1, 30),
(3739, '8f8e0d2f-00e8-47a3-a5d1-d73afa7c45bf', 954, 'Big Data Concepts', 'text', '<h2>Big Data Concepts</h2><p>This lesson covers Big Data Concepts in the context of Big Data Fundamentals.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Big Data Concepts</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 26, NULL, 0, '2025-12-24 17:05:49', '2025-12-24 17:05:49', 0, 0, 1, 30),
(3740, '77f18380-70e5-47aa-afa6-ac97cb51a180', 954, 'Hadoop Ecosystem', 'text', '<h2>Hadoop Ecosystem</h2><p>This lesson covers Hadoop Ecosystem in the context of Big Data Fundamentals.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Hadoop Ecosystem</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 36, NULL, 0, '2025-12-24 17:05:49', '2025-12-24 17:05:49', 0, 0, 1, 30),
(3741, 'd301391c-bd26-455f-8b50-549208e7e541', 954, 'Spark Basics', 'text', '<h2>Spark Basics</h2><p>This lesson covers Spark Basics in the context of Big Data Fundamentals.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Spark Basics</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 20, NULL, 0, '2025-12-24 17:05:49', '2025-12-24 17:05:49', 0, 0, 1, 30),
(3742, 'c6581578-bc32-460b-a20b-f6e85b7f13b4', 954, 'Data Lakes', 'text', '<h2>Data Lakes</h2><p>This lesson covers Data Lakes in the context of Big Data Fundamentals.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Data Lakes</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 16, NULL, 0, '2025-12-24 17:05:49', '2025-12-24 17:05:49', 0, 0, 1, 30),
(3743, '1d92be9a-3d61-460e-a807-6be6906f6749', 955, 'HTML Basics', 'text', '<h2>HTML Basics</h2><p>This lesson covers HTML Basics in the context of Web Scraping.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of HTML Basics</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 16, NULL, 0, '2025-12-24 17:05:49', '2025-12-24 17:05:49', 0, 0, 1, 30),
(3744, 'a9f6aff7-8fba-4b0e-98c1-6b8bcc916744', 955, 'BeautifulSoup', 'text', '<h2>BeautifulSoup</h2><p>This lesson covers BeautifulSoup in the context of Web Scraping.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of BeautifulSoup</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 27, NULL, 0, '2025-12-24 17:05:49', '2025-12-24 17:05:49', 0, 0, 1, 30),
(3745, '1248d6dd-ca83-4251-875b-bc2ccf69d665', 955, 'Scrapy', 'text', '<h2>Scrapy</h2><p>This lesson covers Scrapy in the context of Web Scraping.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Scrapy</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 15, NULL, 0, '2025-12-24 17:05:49', '2025-12-24 17:05:49', 0, 0, 1, 30),
(3746, '954e949d-4101-44ee-89dc-8589ea4f5c4a', 955, 'API Data Collection', 'text', '<h2>API Data Collection</h2><p>This lesson covers API Data Collection in the context of Web Scraping.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of API Data Collection</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 17, NULL, 0, '2025-12-24 17:05:49', '2025-12-24 17:05:49', 0, 0, 1, 30),
(3747, 'ccc96c78-cccc-4d28-b636-db59c99ba70c', 956, 'Data Ethics', 'text', '<h2>Data Ethics</h2><p>This lesson covers Data Ethics in the context of Data Ethics and Privacy.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Data Ethics</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 26, NULL, 0, '2025-12-24 17:05:49', '2025-12-24 17:05:49', 0, 0, 1, 30),
(3748, 'bb54e12a-5099-4868-b6ce-d77a7df3c5e1', 956, 'Privacy Laws', 'text', '<h2>Privacy Laws</h2><p>This lesson covers Privacy Laws in the context of Data Ethics and Privacy.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Privacy Laws</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 25, NULL, 0, '2025-12-24 17:05:49', '2025-12-24 17:05:49', 0, 0, 1, 30),
(3749, '2bebe805-147b-420a-b1aa-a2ad18a55306', 956, 'Anonymization', 'text', '<h2>Anonymization</h2><p>This lesson covers Anonymization in the context of Data Ethics and Privacy.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Anonymization</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 17, NULL, 0, '2025-12-24 17:05:49', '2025-12-24 17:05:49', 0, 0, 1, 30),
(3750, 'b1027f3b-042d-442b-a8f4-fbec0a29971a', 956, 'Responsible Data Use', 'text', '<h2>Responsible Data Use</h2><p>This lesson covers Responsible Data Use in the context of Data Ethics and Privacy.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Responsible Data Use</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 28, NULL, 0, '2025-12-24 17:05:50', '2025-12-24 17:05:50', 0, 0, 1, 30),
(3751, '8c9655b7-54cf-4965-ac65-4a9f85507c06', 957, 'Data Narratives', 'text', '<h2>Data Narratives</h2><p>This lesson covers Data Narratives in the context of Storytelling with Data.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Data Narratives</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 36, NULL, 0, '2025-12-24 17:05:50', '2025-12-24 17:05:50', 0, 0, 1, 30),
(3752, 'c429b5dc-55fd-421e-b00a-640b9ef8b53c', 957, 'Visualization Principles', 'text', '<h2>Visualization Principles</h2><p>This lesson covers Visualization Principles in the context of Storytelling with Data.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Visualization Principles</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 40, NULL, 0, '2025-12-24 17:05:50', '2025-12-24 17:05:50', 0, 0, 1, 30),
(3753, '9471f2de-74b4-45ea-a528-cb83373b3177', 957, 'Presentation Skills', 'text', '<h2>Presentation Skills</h2><p>This lesson covers Presentation Skills in the context of Storytelling with Data.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Presentation Skills</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 24, NULL, 0, '2025-12-24 17:05:50', '2025-12-24 17:05:50', 0, 0, 1, 30),
(3754, 'e7ec6332-fddc-4f4f-bf81-b67b4745d328', 957, 'Executive Summaries', 'text', '<h2>Executive Summaries</h2><p>This lesson covers Executive Summaries in the context of Storytelling with Data.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Executive Summaries</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 15, NULL, 0, '2025-12-24 17:05:52', '2025-12-24 17:05:52', 0, 0, 1, 30),
(3755, '91c22ec4-b661-4834-886c-d28caffa57f7', 958, 'BI Concepts', 'text', '<h2>BI Concepts</h2><p>This lesson covers BI Concepts in the context of Business Intelligence.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of BI Concepts</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 27, NULL, 0, '2025-12-24 17:05:54', '2025-12-24 17:05:54', 0, 0, 1, 30),
(3756, 'd01ae39b-1bf7-4584-ba36-10faeb7fed8b', 958, 'Dashboard Design', 'text', '<h2>Dashboard Design</h2><p>This lesson covers Dashboard Design in the context of Business Intelligence.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Dashboard Design</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 33, NULL, 0, '2025-12-24 17:05:54', '2025-12-24 17:05:54', 0, 0, 1, 30),
(3757, '659f1dc5-1fc4-466d-9d41-9e9e246f88dc', 958, 'KPIs and Metrics', 'text', '<h2>KPIs and Metrics</h2><p>This lesson covers KPIs and Metrics in the context of Business Intelligence.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of KPIs and Metrics</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 26, NULL, 0, '2025-12-24 17:05:54', '2025-12-24 17:05:54', 0, 0, 1, 30),
(3758, '37416937-15eb-4622-ba33-ef8eea826271', 958, 'Reporting', 'text', '<h2>Reporting</h2><p>This lesson covers Reporting in the context of Business Intelligence.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Reporting</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 29, NULL, 0, '2025-12-24 17:05:54', '2025-12-24 17:05:54', 0, 0, 1, 30),
(3759, 'fbd40172-5263-478e-aa6c-2ad2ffc9d2f1', 959, 'Project Lifecycle', 'text', '<h2>Project Lifecycle</h2><p>This lesson covers Project Lifecycle in the context of Data Science Projects.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Project Lifecycle</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 37, NULL, 0, '2025-12-24 17:05:54', '2025-12-24 17:05:54', 0, 0, 1, 30),
(3760, 'dc293a80-3deb-41d3-9214-1abbe9b62715', 959, 'Version Control', 'text', '<h2>Version Control</h2><p>This lesson covers Version Control in the context of Data Science Projects.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Version Control</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 45, NULL, 0, '2025-12-24 17:05:55', '2025-12-24 17:05:55', 0, 0, 1, 30),
(3761, '49e503c2-9362-4cd8-aab9-f228b0a16189', 959, 'Documentation', 'text', '<h2>Documentation</h2><p>This lesson covers Documentation in the context of Data Science Projects.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Documentation</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 17, NULL, 0, '2025-12-24 17:05:55', '2025-12-24 17:05:55', 0, 0, 1, 30),
(3762, '36f7ec4a-1474-4a64-909e-2cf6aa392a8d', 959, 'Collaboration', 'text', '<h2>Collaboration</h2><p>This lesson covers Collaboration in the context of Data Science Projects.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Collaboration</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 32, NULL, 0, '2025-12-24 17:05:55', '2025-12-24 17:05:55', 0, 0, 1, 30),
(3763, '252ed556-0ecb-47b4-bcf6-a8fa6b96f25a', 960, 'Project Selection', 'text', '<h2>Project Selection</h2><p>This lesson covers Project Selection in the context of Data Science Capstone.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Project Selection</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 30, NULL, 0, '2025-12-24 17:05:55', '2025-12-24 17:05:55', 0, 0, 1, 30),
(3764, 'eb2ff03b-be32-4c0d-834b-7c1b0333d220', 960, 'Data Collection', 'text', '<h2>Data Collection</h2><p>This lesson covers Data Collection in the context of Data Science Capstone.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Data Collection</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 37, NULL, 0, '2025-12-24 17:05:55', '2025-12-24 17:05:55', 0, 0, 1, 30),
(3765, '73497108-1349-4c93-becf-42c1e04617df', 960, 'Analysis and Modeling', 'text', '<h2>Analysis and Modeling</h2><p>This lesson covers Analysis and Modeling in the context of Data Science Capstone.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Analysis and Modeling</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 36, NULL, 0, '2025-12-24 17:05:55', '2025-12-24 17:05:55', 0, 0, 1, 30),
(3766, '907df11d-b8db-4927-88ec-caa55d35ec4f', 960, 'Presentation', 'text', '<h2>Presentation</h2><p>This lesson covers Presentation in the context of Data Science Capstone.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Presentation</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 37, NULL, 0, '2025-12-24 17:05:55', '2025-12-24 17:05:55', 0, 0, 1, 30),
(3767, 'c0ca5a15-c7c0-4b0e-a24f-21c47830ea23', 961, 'Mobile Platforms', 'text', '<h2>Mobile Platforms</h2><p>This lesson covers Mobile Platforms in the context of Mobile Development Overview.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Mobile Platforms</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 34, NULL, 0, '2025-12-24 17:05:56', '2025-12-24 17:05:56', 0, 0, 1, 30),
(3768, '8af922b0-8dbc-496d-a57b-f9f12a330812', 961, 'Native vs Cross-Platform', 'text', '<h2>Native vs Cross-Platform</h2><p>This lesson covers Native vs Cross-Platform in the context of Mobile Development Overview.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Native vs Cross-Platform</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 36, NULL, 0, '2025-12-24 17:05:56', '2025-12-24 17:05:56', 0, 0, 1, 30),
(3769, '8c1d10a9-5a88-46ea-b3ed-629f42d283b6', 961, 'Mobile Market', 'text', '<h2>Mobile Market</h2><p>This lesson covers Mobile Market in the context of Mobile Development Overview.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Mobile Market</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 30, NULL, 0, '2025-12-24 17:05:56', '2025-12-24 17:05:56', 0, 0, 1, 30),
(3770, '4e22caec-8d96-4aa2-bf84-b7556edf4ab6', 961, 'Development Approaches', 'text', '<h2>Development Approaches</h2><p>This lesson covers Development Approaches in the context of Mobile Development Overview.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Development Approaches</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 23, NULL, 0, '2025-12-24 17:05:56', '2025-12-24 17:05:56', 0, 0, 1, 30),
(3771, '973237d4-2131-45a2-813a-f99fd9607810', 962, 'Mobile Design Patterns', 'text', '<h2>Mobile Design Patterns</h2><p>This lesson covers Mobile Design Patterns in the context of Mobile UI/UX Principles.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Mobile Design Patterns</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 15, NULL, 0, '2025-12-24 17:05:57', '2025-12-24 17:05:57', 0, 0, 1, 30),
(3772, 'ffdf94a4-2cb7-4ad5-8333-7b10db058a8b', 962, 'Touch Interfaces', 'text', '<h2>Touch Interfaces</h2><p>This lesson covers Touch Interfaces in the context of Mobile UI/UX Principles.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Touch Interfaces</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 41, NULL, 0, '2025-12-24 17:05:57', '2025-12-24 17:05:57', 0, 0, 1, 30),
(3773, '193f608b-b689-4264-866f-a9c311fdc18f', 962, 'Responsive Mobile Design', 'text', '<h2>Responsive Mobile Design</h2><p>This lesson covers Responsive Mobile Design in the context of Mobile UI/UX Principles.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Responsive Mobile Design</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 16, NULL, 0, '2025-12-24 17:05:57', '2025-12-24 17:05:57', 0, 0, 1, 30),
(3774, 'e98184fb-9262-4cc2-8635-71702c374f74', 962, 'Accessibility', 'text', '<h2>Accessibility</h2><p>This lesson covers Accessibility in the context of Mobile UI/UX Principles.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Accessibility</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 41, NULL, 0, '2025-12-24 17:05:57', '2025-12-24 17:05:57', 0, 0, 1, 30),
(3775, '035c9cd9-fda8-4e8b-9378-1df2a1a896f4', 963, 'ES6+ Review', 'text', '<h2>ES6+ Review</h2><p>This lesson covers ES6+ Review in the context of JavaScript for Mobile.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of ES6+ Review</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 38, NULL, 0, '2025-12-24 17:05:57', '2025-12-24 17:05:57', 0, 0, 1, 30),
(3776, 'd978171b-731b-4a85-93ec-41df7ead60c7', 963, 'Async Programming', 'text', '<h2>Async Programming</h2><p>This lesson covers Async Programming in the context of JavaScript for Mobile.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Async Programming</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 44, NULL, 0, '2025-12-24 17:05:57', '2025-12-24 17:05:57', 0, 0, 1, 30),
(3777, 'fa82cbdc-049f-4367-bd59-6a8c7888ac11', 963, 'Modules', 'text', '<h2>Modules</h2><p>This lesson covers Modules in the context of JavaScript for Mobile.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Modules</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 42, NULL, 0, '2025-12-24 17:05:57', '2025-12-24 17:05:57', 0, 0, 1, 30),
(3778, 'e21f8743-a3a4-48b0-9c37-7d8966ed487c', 963, 'Modern JavaScript', 'text', '<h2>Modern JavaScript</h2><p>This lesson covers Modern JavaScript in the context of JavaScript for Mobile.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Modern JavaScript</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 31, NULL, 0, '2025-12-24 17:05:57', '2025-12-24 17:05:57', 0, 0, 1, 30),
(3779, '56c2cbac-d884-4788-89c2-c97ba9464539', 964, 'Environment Setup', 'text', '<h2>Environment Setup</h2><p>This lesson covers Environment Setup in the context of React Native Setup.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Environment Setup</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 26, NULL, 0, '2025-12-24 17:05:57', '2025-12-24 17:05:57', 0, 0, 1, 30),
(3780, '1d9231d3-5391-4aa1-9cc6-520b2f1cb374', 964, 'Expo vs CLI', 'text', '<h2>Expo vs CLI</h2><p>This lesson covers Expo vs CLI in the context of React Native Setup.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Expo vs CLI</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 21, NULL, 0, '2025-12-24 17:05:58', '2025-12-24 17:05:58', 0, 0, 1, 30),
(3781, 'f2e35ec8-92fd-42a1-9f72-ef800f7fb495', 964, 'Project Structure', 'text', '<h2>Project Structure</h2><p>This lesson covers Project Structure in the context of React Native Setup.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Project Structure</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 23, NULL, 0, '2025-12-24 17:05:58', '2025-12-24 17:05:58', 0, 0, 1, 30),
(3782, '77b36478-12dc-4efb-836d-33b90fbb19f7', 964, 'Running on Devices', 'text', '<h2>Running on Devices</h2><p>This lesson covers Running on Devices in the context of React Native Setup.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Running on Devices</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 20, NULL, 0, '2025-12-24 17:05:58', '2025-12-24 17:05:58', 0, 0, 1, 30),
(3783, '77e96066-428f-4f06-921b-cb012dd3c92d', 965, 'Core Components', 'text', '<h2>Core Components</h2><p>This lesson covers Core Components in the context of React Native Components.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Core Components</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 45, NULL, 0, '2025-12-24 17:05:58', '2025-12-24 17:05:58', 0, 0, 1, 30),
(3784, 'a4e637ec-ad3c-428c-ad6a-2865d4b1374e', 965, 'Styling', 'text', '<h2>Styling</h2><p>This lesson covers Styling in the context of React Native Components.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Styling</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 38, NULL, 0, '2025-12-24 17:05:58', '2025-12-24 17:05:58', 0, 0, 1, 30),
(3785, '733057ae-4941-47ac-bda1-40c1a760f59f', 965, 'Layout with Flexbox', 'text', '<h2>Layout with Flexbox</h2><p>This lesson covers Layout with Flexbox in the context of React Native Components.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Layout with Flexbox</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 31, NULL, 0, '2025-12-24 17:05:58', '2025-12-24 17:05:58', 0, 0, 1, 30),
(3786, '65c1e939-de99-435e-8cea-20d849242618', 965, 'Custom Components', 'text', '<h2>Custom Components</h2><p>This lesson covers Custom Components in the context of React Native Components.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Custom Components</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 23, NULL, 0, '2025-12-24 17:05:58', '2025-12-24 17:05:58', 0, 0, 1, 30),
(3787, 'e19323b7-4d07-4e3b-8325-0417fce4d841', 966, 'Stack Navigator', 'text', '<h2>Stack Navigator</h2><p>This lesson covers Stack Navigator in the context of React Native Navigation.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Stack Navigator</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 42, NULL, 0, '2025-12-24 17:05:58', '2025-12-24 17:05:58', 0, 0, 1, 30),
(3788, '6ae7cda6-7947-424d-811c-51c45618aecb', 966, 'Tab Navigator', 'text', '<h2>Tab Navigator</h2><p>This lesson covers Tab Navigator in the context of React Native Navigation.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Tab Navigator</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 35, NULL, 0, '2025-12-24 17:05:58', '2025-12-24 17:05:58', 0, 0, 1, 30),
(3789, '04f58006-c47c-4e55-ac07-f386ee271919', 966, 'Drawer Navigator', 'text', '<h2>Drawer Navigator</h2><p>This lesson covers Drawer Navigator in the context of React Native Navigation.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Drawer Navigator</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 34, NULL, 0, '2025-12-24 17:05:58', '2025-12-24 17:05:58', 0, 0, 1, 30),
(3790, '24a674fe-3cbc-47ee-8b1c-17f84753962a', 966, 'Deep Linking', 'text', '<h2>Deep Linking</h2><p>This lesson covers Deep Linking in the context of React Native Navigation.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Deep Linking</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 15, NULL, 0, '2025-12-24 17:05:58', '2025-12-24 17:05:58', 0, 0, 1, 30),
(3791, '5a189cbb-9413-4da1-b3a3-65c74be5404a', 967, 'Local State', 'text', '<h2>Local State</h2><p>This lesson covers Local State in the context of State Management in Mobile.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Local State</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 43, NULL, 0, '2025-12-24 17:05:59', '2025-12-24 17:05:59', 0, 0, 1, 30),
(3792, 'f85c52b0-2f8c-47ff-a31b-75d085a1df95', 967, 'Context API', 'text', '<h2>Context API</h2><p>This lesson covers Context API in the context of State Management in Mobile.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Context API</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 21, NULL, 0, '2025-12-24 17:05:59', '2025-12-24 17:05:59', 0, 0, 1, 30),
(3793, '362b2e27-2afe-4e4c-bd72-b8cfb6a40ac9', 967, 'Redux for Mobile', 'text', '<h2>Redux for Mobile</h2><p>This lesson covers Redux for Mobile in the context of State Management in Mobile.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Redux for Mobile</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 24, NULL, 0, '2025-12-24 17:05:59', '2025-12-24 17:05:59', 0, 0, 1, 30),
(3794, '9279ffc3-3dfc-4d05-952f-e5785eedb5c7', 967, 'State Persistence', 'text', '<h2>State Persistence</h2><p>This lesson covers State Persistence in the context of State Management in Mobile.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of State Persistence</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 38, NULL, 0, '2025-12-24 17:05:59', '2025-12-24 17:05:59', 0, 0, 1, 30),
(3795, 'c52553b4-5f82-4fa6-a746-09d7e36bbd88', 968, 'Fetch API', 'text', '<h2>Fetch API</h2><p>This lesson covers Fetch API in the context of Networking and APIs.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Fetch API</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 33, NULL, 0, '2025-12-24 17:05:59', '2025-12-24 17:05:59', 0, 0, 1, 30),
(3796, '987d3821-3e06-413a-9ef4-b5a52d04154e', 968, 'Axios', 'text', '<h2>Axios</h2><p>This lesson covers Axios in the context of Networking and APIs.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Axios</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 19, NULL, 0, '2025-12-24 17:05:59', '2025-12-24 17:05:59', 0, 0, 1, 30),
(3797, '861556b2-fe48-44eb-81fd-93dc10948b0a', 968, 'API Integration', 'text', '<h2>API Integration</h2><p>This lesson covers API Integration in the context of Networking and APIs.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of API Integration</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 19, NULL, 0, '2025-12-24 17:06:00', '2025-12-24 17:06:00', 0, 0, 1, 30),
(3798, 'ea21610d-881f-4228-a8c5-912981e7642f', 968, 'Offline Support', 'text', '<h2>Offline Support</h2><p>This lesson covers Offline Support in the context of Networking and APIs.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Offline Support</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 33, NULL, 0, '2025-12-24 17:06:00', '2025-12-24 17:06:00', 0, 0, 1, 30),
(3799, '5aaa101b-ecb9-43ac-a716-bc015086d6c9', 969, 'AsyncStorage', 'text', '<h2>AsyncStorage</h2><p>This lesson covers AsyncStorage in the context of Local Storage.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of AsyncStorage</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 17, NULL, 0, '2025-12-24 17:06:00', '2025-12-24 17:06:00', 0, 0, 1, 30),
(3800, '261afea1-3f27-4406-913e-c8afa1498f60', 969, 'SQLite', 'text', '<h2>SQLite</h2><p>This lesson covers SQLite in the context of Local Storage.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of SQLite</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 20, NULL, 0, '2025-12-24 17:06:01', '2025-12-24 17:06:01', 0, 0, 1, 30),
(3801, 'b7cf85e9-dc1c-4435-94fa-f3dc8732b591', 969, 'Realm', 'text', '<h2>Realm</h2><p>This lesson covers Realm in the context of Local Storage.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Realm</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 45, NULL, 0, '2025-12-24 17:06:01', '2025-12-24 17:06:01', 0, 0, 1, 30),
(3802, '58cbaada-2643-4dee-948e-d03ea1bd17ec', 969, 'Data Caching', 'text', '<h2>Data Caching</h2><p>This lesson covers Data Caching in the context of Local Storage.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Data Caching</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 44, NULL, 0, '2025-12-24 17:06:01', '2025-12-24 17:06:01', 0, 0, 1, 30),
(3803, '0762b5de-5baa-4a1a-add2-e40bcdda07e4', 970, 'Camera Access', 'text', '<h2>Camera Access</h2><p>This lesson covers Camera Access in the context of Camera and Media.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Camera Access</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 38, NULL, 0, '2025-12-24 17:06:02', '2025-12-24 17:06:02', 0, 0, 1, 30),
(3804, 'e046e829-d547-4308-921f-cf396af5b5a3', 970, 'Photo Library', 'text', '<h2>Photo Library</h2><p>This lesson covers Photo Library in the context of Camera and Media.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Photo Library</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 33, NULL, 0, '2025-12-24 17:06:02', '2025-12-24 17:06:02', 0, 0, 1, 30),
(3805, '117ad4ea-0147-45c3-941a-bdaf9b931c91', 970, 'Video Recording', 'text', '<h2>Video Recording</h2><p>This lesson covers Video Recording in the context of Camera and Media.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Video Recording</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 24, NULL, 0, '2025-12-24 17:06:03', '2025-12-24 17:06:03', 0, 0, 1, 30),
(3806, '7f4cb425-d647-441f-99c1-8dcfa760f2ae', 970, 'Image Manipulation', 'text', '<h2>Image Manipulation</h2><p>This lesson covers Image Manipulation in the context of Camera and Media.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Image Manipulation</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 25, NULL, 0, '2025-12-24 17:06:03', '2025-12-24 17:06:03', 0, 0, 1, 30),
(3807, '413b3f1b-4ff9-4755-905c-c651411cb5c7', 971, 'Geolocation', 'text', '<h2>Geolocation</h2><p>This lesson covers Geolocation in the context of Location Services.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Geolocation</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 44, NULL, 0, '2025-12-24 17:06:04', '2025-12-24 17:06:04', 0, 0, 1, 30),
(3808, 'b64e77d0-11b0-461a-9633-322353750118', 971, 'Maps Integration', 'text', '<h2>Maps Integration</h2><p>This lesson covers Maps Integration in the context of Location Services.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Maps Integration</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 39, NULL, 0, '2025-12-24 17:06:04', '2025-12-24 17:06:04', 0, 0, 1, 30),
(3809, '6f718af5-3b38-42a7-acc5-ba9fe74bc94a', 971, 'Background Location', 'text', '<h2>Background Location</h2><p>This lesson covers Background Location in the context of Location Services.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Background Location</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 33, NULL, 0, '2025-12-24 17:06:04', '2025-12-24 17:06:04', 0, 0, 1, 30),
(3810, 'e703d0fe-e52c-477b-9067-7c5cddcf3948', 971, 'Geofencing', 'text', '<h2>Geofencing</h2><p>This lesson covers Geofencing in the context of Location Services.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Geofencing</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 20, NULL, 0, '2025-12-24 17:06:04', '2025-12-24 17:06:04', 0, 0, 1, 30),
(3811, 'c3122edc-a8ba-439a-b66f-f4959c5b8449', 972, 'Notification Setup', 'text', '<h2>Notification Setup</h2><p>This lesson covers Notification Setup in the context of Push Notifications.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Notification Setup</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 21, NULL, 0, '2025-12-24 17:06:05', '2025-12-24 17:06:05', 0, 0, 1, 30),
(3812, '8fd67378-b48f-4909-b718-27fd6a19bb07', 972, 'Local Notifications', 'text', '<h2>Local Notifications</h2><p>This lesson covers Local Notifications in the context of Push Notifications.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Local Notifications</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 29, NULL, 0, '2025-12-24 17:06:05', '2025-12-24 17:06:05', 0, 0, 1, 30),
(3813, 'fc0fd37d-fc90-456b-afa3-d5d6130023c1', 972, 'Remote Notifications', 'text', '<h2>Remote Notifications</h2><p>This lesson covers Remote Notifications in the context of Push Notifications.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Remote Notifications</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 16, NULL, 0, '2025-12-24 17:06:05', '2025-12-24 17:06:05', 0, 0, 1, 30),
(3814, '71d07043-1499-4524-a554-a8088d6e82ee', 972, 'Notification Handling', 'text', '<h2>Notification Handling</h2><p>This lesson covers Notification Handling in the context of Push Notifications.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Notification Handling</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 40, NULL, 0, '2025-12-24 17:06:05', '2025-12-24 17:06:05', 0, 0, 1, 30),
(3815, '4735b716-e8ff-49c7-80ff-e32324847e3c', 973, 'Sensors', 'text', '<h2>Sensors</h2><p>This lesson covers Sensors in the context of Device Features.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Sensors</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 45, NULL, 0, '2025-12-24 17:06:05', '2025-12-24 17:06:05', 0, 0, 1, 30),
(3816, '3a351bdb-d778-420a-b5cb-1a38b05f0212', 973, 'Haptics', 'text', '<h2>Haptics</h2><p>This lesson covers Haptics in the context of Device Features.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Haptics</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 18, NULL, 0, '2025-12-24 17:06:06', '2025-12-24 17:06:06', 0, 0, 1, 30),
(3817, '10244ba8-3dfe-47fe-8d4c-0fe4b0955fb7', 973, 'Device Info', 'text', '<h2>Device Info</h2><p>This lesson covers Device Info in the context of Device Features.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Device Info</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 26, NULL, 0, '2025-12-24 17:06:06', '2025-12-24 17:06:06', 0, 0, 1, 30),
(3818, 'f0642813-cde1-43e5-9103-01d9f82f9529', 973, 'Permissions', 'text', '<h2>Permissions</h2><p>This lesson covers Permissions in the context of Device Features.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Permissions</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 35, NULL, 0, '2025-12-24 17:06:06', '2025-12-24 17:06:06', 0, 0, 1, 30),
(3819, 'da326dfa-1781-404c-913e-48686446bee4', 974, 'Animated API', 'text', '<h2>Animated API</h2><p>This lesson covers Animated API in the context of Animation and Gestures.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Animated API</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 19, NULL, 0, '2025-12-24 17:06:06', '2025-12-24 17:06:06', 0, 0, 1, 30),
(3820, 'd6660d42-1659-4488-bc46-b07842ebbc4c', 974, 'Gesture Handler', 'text', '<h2>Gesture Handler</h2><p>This lesson covers Gesture Handler in the context of Animation and Gestures.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Gesture Handler</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 15, NULL, 0, '2025-12-24 17:06:06', '2025-12-24 17:06:06', 0, 0, 1, 30),
(3821, '363d8880-2bf7-4dd5-a1c6-d17b788388ac', 974, 'Reanimated', 'text', '<h2>Reanimated</h2><p>This lesson covers Reanimated in the context of Animation and Gestures.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Reanimated</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 29, NULL, 0, '2025-12-24 17:06:07', '2025-12-24 17:06:07', 0, 0, 1, 30),
(3822, '9110a5b0-cd4f-4833-9f78-cb5fd7c8d921', 974, 'Micro-interactions', 'text', '<h2>Micro-interactions</h2><p>This lesson covers Micro-interactions in the context of Animation and Gestures.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Micro-interactions</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 23, NULL, 0, '2025-12-24 17:06:07', '2025-12-24 17:06:07', 0, 0, 1, 30);
INSERT INTO `lessons` (`id`, `uuid`, `module_id`, `title`, `type`, `content`, `order_index`, `duration_minutes`, `resources`, `ai_generated`, `created_at`, `updated_at`, `has_practical`, `has_quiz`, `competency_weight`, `estimated_time_minutes`) VALUES
(3823, 'c40f617f-925f-4310-9f20-0638b40698b5', 975, 'Auth Flows', 'text', '<h2>Auth Flows</h2><p>This lesson covers Auth Flows in the context of Authentication in Mobile.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Auth Flows</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 22, NULL, 0, '2025-12-24 17:06:09', '2025-12-24 17:06:09', 0, 0, 1, 30),
(3824, 'c2b9c765-9324-44c0-8e5c-59a079ccb357', 975, 'Secure Storage', 'text', '<h2>Secure Storage</h2><p>This lesson covers Secure Storage in the context of Authentication in Mobile.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Secure Storage</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 26, NULL, 0, '2025-12-24 17:06:10', '2025-12-24 17:06:10', 0, 0, 1, 30),
(3825, '8cf3c52f-7f65-443a-bd05-b1e5d3975524', 975, 'Biometric Auth', 'text', '<h2>Biometric Auth</h2><p>This lesson covers Biometric Auth in the context of Authentication in Mobile.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Biometric Auth</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 31, NULL, 0, '2025-12-24 17:06:12', '2025-12-24 17:06:12', 0, 0, 1, 30),
(3826, 'f4485ff5-87da-4e95-ad6c-356597abd5c6', 975, 'OAuth in Mobile', 'text', '<h2>OAuth in Mobile</h2><p>This lesson covers OAuth in Mobile in the context of Authentication in Mobile.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of OAuth in Mobile</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 29, NULL, 0, '2025-12-24 17:06:12', '2025-12-24 17:06:12', 0, 0, 1, 30),
(3827, '76aeacf2-5710-446f-a00e-6d9641489214', 976, 'Unit Testing', 'text', '<h2>Unit Testing</h2><p>This lesson covers Unit Testing in the context of Testing Mobile Apps.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Unit Testing</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 32, NULL, 0, '2025-12-24 17:06:13', '2025-12-24 17:06:13', 0, 0, 1, 30),
(3828, '4d5a3d11-a5fe-4ad6-9c6c-edf09e2e9190', 976, 'Component Testing', 'text', '<h2>Component Testing</h2><p>This lesson covers Component Testing in the context of Testing Mobile Apps.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Component Testing</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 19, NULL, 0, '2025-12-24 17:06:13', '2025-12-24 17:06:13', 0, 0, 1, 30),
(3829, '6740cf3f-9ff7-4c44-8b1a-0d2f04c3f46a', 976, 'Integration Testing', 'text', '<h2>Integration Testing</h2><p>This lesson covers Integration Testing in the context of Testing Mobile Apps.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Integration Testing</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 28, NULL, 0, '2025-12-24 17:06:15', '2025-12-24 17:06:15', 0, 0, 1, 30),
(3830, 'a18a6e16-567d-4978-aad3-2feadfc1859c', 976, 'E2E with Detox', 'text', '<h2>E2E with Detox</h2><p>This lesson covers E2E with Detox in the context of Testing Mobile Apps.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of E2E with Detox</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 33, NULL, 0, '2025-12-24 17:06:15', '2025-12-24 17:06:15', 0, 0, 1, 30),
(3831, '759e3788-461d-424b-b852-cd0ad63acfdd', 977, 'Performance Profiling', 'text', '<h2>Performance Profiling</h2><p>This lesson covers Performance Profiling in the context of Performance Optimization.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Performance Profiling</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 33, NULL, 0, '2025-12-24 17:06:15', '2025-12-24 17:06:15', 0, 0, 1, 30),
(3832, '68ca4b9c-3ac0-46d7-8357-da4a4af63d94', 977, 'Memory Management', 'text', '<h2>Memory Management</h2><p>This lesson covers Memory Management in the context of Performance Optimization.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Memory Management</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 29, NULL, 0, '2025-12-24 17:06:16', '2025-12-24 17:06:16', 0, 0, 1, 30),
(3833, 'a75c5c20-5896-4730-b674-044d0f1325d5', 977, 'Bundle Optimization', 'text', '<h2>Bundle Optimization</h2><p>This lesson covers Bundle Optimization in the context of Performance Optimization.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Bundle Optimization</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 34, NULL, 0, '2025-12-24 17:06:16', '2025-12-24 17:06:16', 0, 0, 1, 30),
(3834, 'b850dab5-e4fc-42c2-b9b7-22f2c57beae1', 977, 'Native Bridges', 'text', '<h2>Native Bridges</h2><p>This lesson covers Native Bridges in the context of Performance Optimization.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Native Bridges</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 41, NULL, 0, '2025-12-24 17:06:16', '2025-12-24 17:06:16', 0, 0, 1, 30),
(3835, 'f257bcc2-ccbb-46ed-9cfd-90b49470780d', 978, 'iOS Guidelines', 'text', '<h2>iOS Guidelines</h2><p>This lesson covers iOS Guidelines in the context of App Store Guidelines.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of iOS Guidelines</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 45, NULL, 0, '2025-12-24 17:06:17', '2025-12-24 17:06:17', 0, 0, 1, 30),
(3836, '5ce35040-62bc-445c-9bbc-00f6b0f05f30', 978, 'Android Policies', 'text', '<h2>Android Policies</h2><p>This lesson covers Android Policies in the context of App Store Guidelines.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Android Policies</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 25, NULL, 0, '2025-12-24 17:06:17', '2025-12-24 17:06:17', 0, 0, 1, 30),
(3837, 'ded1f065-b29e-43f2-aca6-758121965916', 978, 'App Review Process', 'text', '<h2>App Review Process</h2><p>This lesson covers App Review Process in the context of App Store Guidelines.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of App Review Process</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 42, NULL, 0, '2025-12-24 17:06:17', '2025-12-24 17:06:17', 0, 0, 1, 30),
(3838, 'c5217c03-111c-40da-bf9b-b79dee97a0e1', 978, 'Metadata Optimization', 'text', '<h2>Metadata Optimization</h2><p>This lesson covers Metadata Optimization in the context of App Store Guidelines.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Metadata Optimization</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 39, NULL, 0, '2025-12-24 17:06:17', '2025-12-24 17:06:17', 0, 0, 1, 30),
(3839, 'ed67a08d-3f99-4a7b-be23-d8bc9ec3e61b', 979, 'Release Builds', 'text', '<h2>Release Builds</h2><p>This lesson covers Release Builds in the context of Building for Production.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Release Builds</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 19, NULL, 0, '2025-12-24 17:06:18', '2025-12-24 17:06:18', 0, 0, 1, 30),
(3840, '1cc2bbef-b54d-453a-afcd-70c15be233e0', 979, 'Code Signing', 'text', '<h2>Code Signing</h2><p>This lesson covers Code Signing in the context of Building for Production.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Code Signing</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 18, NULL, 0, '2025-12-24 17:06:18', '2025-12-24 17:06:18', 0, 0, 1, 30),
(3841, 'a6baa5b4-b03c-4ced-9f88-980a9835bb50', 979, 'Versioning', 'text', '<h2>Versioning</h2><p>This lesson covers Versioning in the context of Building for Production.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Versioning</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 20, NULL, 0, '2025-12-24 17:06:18', '2025-12-24 17:06:18', 0, 0, 1, 30),
(3842, '2b6995a2-81b1-4644-a172-fbe82fe37e5b', 979, 'Over-the-Air Updates', 'text', '<h2>Over-the-Air Updates</h2><p>This lesson covers Over-the-Air Updates in the context of Building for Production.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Over-the-Air Updates</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 38, NULL, 0, '2025-12-24 17:06:18', '2025-12-24 17:06:18', 0, 0, 1, 30),
(3843, 'd0770f9e-576a-4160-883c-42a5b9743234', 980, 'App Store Submission', 'text', '<h2>App Store Submission</h2><p>This lesson covers App Store Submission in the context of Publishing Your App.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of App Store Submission</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 38, NULL, 0, '2025-12-24 17:06:19', '2025-12-24 17:06:19', 0, 0, 1, 30),
(3844, '570cb0f5-9144-4341-97fc-5cd012540989', 980, 'Play Store Submission', 'text', '<h2>Play Store Submission</h2><p>This lesson covers Play Store Submission in the context of Publishing Your App.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Play Store Submission</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 15, NULL, 0, '2025-12-24 17:06:19', '2025-12-24 17:06:19', 0, 0, 1, 30),
(3845, '91aa2f74-73e2-4f0e-ac2d-fced09848c8b', 980, 'Marketing', 'text', '<h2>Marketing</h2><p>This lesson covers Marketing in the context of Publishing Your App.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Marketing</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 36, NULL, 0, '2025-12-24 17:06:19', '2025-12-24 17:06:19', 0, 0, 1, 30),
(3846, '3e759d7f-8262-4828-8cf1-92b40526f054', 980, 'Post-Launch Support', 'text', '<h2>Post-Launch Support</h2><p>This lesson covers Post-Launch Support in the context of Publishing Your App.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Post-Launch Support</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 34, NULL, 0, '2025-12-24 17:06:19', '2025-12-24 17:06:19', 0, 0, 1, 30),
(3847, '36b83a33-0aea-4c1a-996f-546c212435e4', 981, 'What is Cybersecurity?', 'text', '<h2>What is Cybersecurity?</h2><p>This lesson covers What is Cybersecurity? in the context of Introduction to Cybersecurity.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of What is Cybersecurity?</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 36, NULL, 0, '2025-12-24 17:06:20', '2025-12-24 17:06:20', 0, 0, 1, 30),
(3848, '344992da-0176-4c4c-8df5-e4ad7e0327cb', 981, 'Cyber Threats Landscape', 'text', '<h2>Cyber Threats Landscape</h2><p>This lesson covers Cyber Threats Landscape in the context of Introduction to Cybersecurity.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Cyber Threats Landscape</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 28, NULL, 0, '2025-12-24 17:06:20', '2025-12-24 17:06:20', 0, 0, 1, 30),
(3849, 'b4571d50-a7ab-4a6b-ab41-08e2465eb12e', 981, 'Career Paths', 'text', '<h2>Career Paths</h2><p>This lesson covers Career Paths in the context of Introduction to Cybersecurity.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Career Paths</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 28, NULL, 0, '2025-12-24 17:06:20', '2025-12-24 17:06:20', 0, 0, 1, 30),
(3850, '57b2668d-50af-4b6d-971e-baa1a88b263a', 981, 'Industry Certifications', 'text', '<h2>Industry Certifications</h2><p>This lesson covers Industry Certifications in the context of Introduction to Cybersecurity.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Industry Certifications</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 39, NULL, 0, '2025-12-24 17:06:20', '2025-12-24 17:06:20', 0, 0, 1, 30),
(3851, 'd9668e9c-54f7-44ce-b2a0-eb790b17a4ac', 982, 'CIA Triad', 'text', '<h2>CIA Triad</h2><p>This lesson covers CIA Triad in the context of Security Fundamentals.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of CIA Triad</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 41, NULL, 0, '2025-12-24 17:06:20', '2025-12-24 17:06:20', 0, 0, 1, 30),
(3852, '38c50e46-a362-49b5-9458-4d727f71f1c1', 982, 'Security Principles', 'text', '<h2>Security Principles</h2><p>This lesson covers Security Principles in the context of Security Fundamentals.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Security Principles</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 20, NULL, 0, '2025-12-24 17:06:21', '2025-12-24 17:06:21', 0, 0, 1, 30),
(3853, 'cafd8816-0fd9-44b9-a1aa-de2ebba837a8', 982, 'Defense in Depth', 'text', '<h2>Defense in Depth</h2><p>This lesson covers Defense in Depth in the context of Security Fundamentals.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Defense in Depth</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 22, NULL, 0, '2025-12-24 17:06:21', '2025-12-24 17:06:21', 0, 0, 1, 30),
(3854, '88e25e38-1812-4dc2-a766-f4462cb4105d', 982, 'Zero Trust', 'text', '<h2>Zero Trust</h2><p>This lesson covers Zero Trust in the context of Security Fundamentals.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Zero Trust</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 31, NULL, 0, '2025-12-24 17:06:22', '2025-12-24 17:06:22', 0, 0, 1, 30),
(3855, 'ce51960a-0d10-4469-81f8-a53ed9188aa3', 983, 'Malware Types', 'text', '<h2>Malware Types</h2><p>This lesson covers Malware Types in the context of Common Threats and Attacks.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Malware Types</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 25, NULL, 0, '2025-12-24 17:06:22', '2025-12-24 17:06:22', 0, 0, 1, 30),
(3856, '675b7505-241e-4b25-9361-6c2743d15519', 983, 'Phishing', 'text', '<h2>Phishing</h2><p>This lesson covers Phishing in the context of Common Threats and Attacks.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Phishing</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 25, NULL, 0, '2025-12-24 17:06:22', '2025-12-24 17:06:22', 0, 0, 1, 30),
(3857, 'b5489b76-aa9b-4246-959a-59f7bc1ae5f9', 983, 'Social Engineering', 'text', '<h2>Social Engineering</h2><p>This lesson covers Social Engineering in the context of Common Threats and Attacks.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Social Engineering</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 23, NULL, 0, '2025-12-24 17:06:23', '2025-12-24 17:06:23', 0, 0, 1, 30),
(3858, '914d1b1c-e72f-406d-92fa-8edb30745344', 983, 'Ransomware', 'text', '<h2>Ransomware</h2><p>This lesson covers Ransomware in the context of Common Threats and Attacks.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Ransomware</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 33, NULL, 0, '2025-12-24 17:06:23', '2025-12-24 17:06:23', 0, 0, 1, 30),
(3859, '1706fd3c-4bf5-4e4f-a6ea-dbeb1b285e7e', 984, 'Network Architecture', 'text', '<h2>Network Architecture</h2><p>This lesson covers Network Architecture in the context of Network Security Basics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Network Architecture</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 44, NULL, 0, '2025-12-24 17:06:24', '2025-12-24 17:06:24', 0, 0, 1, 30),
(3860, '7b75ee81-b410-46f6-8435-ff9c67e079d0', 984, 'Protocols', 'text', '<h2>Protocols</h2><p>This lesson covers Protocols in the context of Network Security Basics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Protocols</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 34, NULL, 0, '2025-12-24 17:06:24', '2025-12-24 17:06:24', 0, 0, 1, 30),
(3861, 'd738bbe0-02cc-4989-9161-a9a6062dcac0', 984, 'Firewalls', 'text', '<h2>Firewalls</h2><p>This lesson covers Firewalls in the context of Network Security Basics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Firewalls</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 31, NULL, 0, '2025-12-24 17:06:24', '2025-12-24 17:06:24', 0, 0, 1, 30),
(3862, '21fcf938-b1f9-42c2-ba63-ec5f4e996c68', 984, 'VPNs', 'text', '<h2>VPNs</h2><p>This lesson covers VPNs in the context of Network Security Basics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of VPNs</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 37, NULL, 0, '2025-12-24 17:06:24', '2025-12-24 17:06:24', 0, 0, 1, 30),
(3863, '8d8837ed-6e3b-4324-a1e1-e28742756011', 985, 'IDS/IPS', 'text', '<h2>IDS/IPS</h2><p>This lesson covers IDS/IPS in the context of Network Defense.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of IDS/IPS</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 44, NULL, 0, '2025-12-24 17:06:26', '2025-12-24 17:06:26', 0, 0, 1, 30),
(3864, 'aacfa834-aa15-4c1c-a5be-ad41ee79f714', 985, 'Network Monitoring', 'text', '<h2>Network Monitoring</h2><p>This lesson covers Network Monitoring in the context of Network Defense.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Network Monitoring</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 17, NULL, 0, '2025-12-24 17:06:26', '2025-12-24 17:06:26', 0, 0, 1, 30),
(3865, '74b1bb0f-6289-4e67-9a08-1115d374d4a2', 985, 'SIEM', 'text', '<h2>SIEM</h2><p>This lesson covers SIEM in the context of Network Defense.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of SIEM</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 23, NULL, 0, '2025-12-24 17:06:26', '2025-12-24 17:06:26', 0, 0, 1, 30),
(3866, '356a6d81-c2ad-43ef-90c6-1c981df7f2e7', 985, 'Log Analysis', 'text', '<h2>Log Analysis</h2><p>This lesson covers Log Analysis in the context of Network Defense.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Log Analysis</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 16, NULL, 0, '2025-12-24 17:06:27', '2025-12-24 17:06:27', 0, 0, 1, 30),
(3867, 'eddc2cd2-f5d4-4b31-ac34-985990945e8d', 986, 'WiFi Security', 'text', '<h2>WiFi Security</h2><p>This lesson covers WiFi Security in the context of Wireless Security.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of WiFi Security</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 22, NULL, 0, '2025-12-24 17:06:28', '2025-12-24 17:06:28', 0, 0, 1, 30),
(3868, '7cb9376c-3875-499b-9f0a-370c77426f93', 986, 'Wireless Attacks', 'text', '<h2>Wireless Attacks</h2><p>This lesson covers Wireless Attacks in the context of Wireless Security.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Wireless Attacks</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 24, NULL, 0, '2025-12-24 17:06:29', '2025-12-24 17:06:29', 0, 0, 1, 30),
(3869, '6c20f650-c45e-4519-98aa-74d299410d41', 986, 'Securing Wireless Networks', 'text', '<h2>Securing Wireless Networks</h2><p>This lesson covers Securing Wireless Networks in the context of Wireless Security.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Securing Wireless Networks</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 25, NULL, 0, '2025-12-24 17:06:29', '2025-12-24 17:06:29', 0, 0, 1, 30),
(3870, '6cdb8d13-fc4f-4c55-bc91-ca0382c0d9f5', 986, 'Bluetooth Security', 'text', '<h2>Bluetooth Security</h2><p>This lesson covers Bluetooth Security in the context of Wireless Security.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Bluetooth Security</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 20, NULL, 0, '2025-12-24 17:06:30', '2025-12-24 17:06:30', 0, 0, 1, 30),
(3871, '6cf204c3-763d-4d9b-979a-95ffb130c13b', 987, 'Windows Security', 'text', '<h2>Windows Security</h2><p>This lesson covers Windows Security in the context of Operating System Security.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Windows Security</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 32, NULL, 0, '2025-12-24 17:06:30', '2025-12-24 17:06:30', 0, 0, 1, 30),
(3872, '8b4d0993-8734-44f7-ab56-0451929912ac', 987, 'Linux Security', 'text', '<h2>Linux Security</h2><p>This lesson covers Linux Security in the context of Operating System Security.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Linux Security</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 40, NULL, 0, '2025-12-24 17:06:31', '2025-12-24 17:06:31', 0, 0, 1, 30),
(3873, 'f781598e-2909-4179-8f6f-145ec88c1aa5', 987, 'macOS Security', 'text', '<h2>macOS Security</h2><p>This lesson covers macOS Security in the context of Operating System Security.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of macOS Security</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 27, NULL, 0, '2025-12-24 17:06:31', '2025-12-24 17:06:31', 0, 0, 1, 30),
(3874, '330ca499-0203-4768-aa62-464b26ec218f', 987, 'Hardening', 'text', '<h2>Hardening</h2><p>This lesson covers Hardening in the context of Operating System Security.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Hardening</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 18, NULL, 0, '2025-12-24 17:06:31', '2025-12-24 17:06:31', 0, 0, 1, 30),
(3875, 'a8c948ac-38c9-44ec-b159-9210b3b9b5c6', 988, 'OWASP Top 10', 'text', '<h2>OWASP Top 10</h2><p>This lesson covers OWASP Top 10 in the context of Web Application Security.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of OWASP Top 10</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 17, NULL, 0, '2025-12-24 17:06:32', '2025-12-24 17:06:32', 0, 0, 1, 30),
(3876, 'bd0a9ce1-57d7-4f0d-886b-8f851003e08d', 988, 'SQL Injection', 'text', '<h2>SQL Injection</h2><p>This lesson covers SQL Injection in the context of Web Application Security.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of SQL Injection</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 31, NULL, 0, '2025-12-24 17:06:33', '2025-12-24 17:06:33', 0, 0, 1, 30),
(3877, '09e3531f-3f4b-41fc-abac-454627d4a164', 988, 'XSS Attacks', 'text', '<h2>XSS Attacks</h2><p>This lesson covers XSS Attacks in the context of Web Application Security.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of XSS Attacks</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 43, NULL, 0, '2025-12-24 17:06:34', '2025-12-24 17:06:34', 0, 0, 1, 30),
(3878, '92eec1a9-1305-4b4b-a16e-6af0f8664e2f', 988, 'CSRF', 'text', '<h2>CSRF</h2><p>This lesson covers CSRF in the context of Web Application Security.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of CSRF</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 23, NULL, 0, '2025-12-24 17:06:34', '2025-12-24 17:06:34', 0, 0, 1, 30),
(3879, '72c293e5-bc97-4e32-a7b2-5f256cafeafc', 989, 'Encryption Basics', 'text', '<h2>Encryption Basics</h2><p>This lesson covers Encryption Basics in the context of Cryptography Fundamentals.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Encryption Basics</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 22, NULL, 0, '2025-12-24 17:06:34', '2025-12-24 17:06:34', 0, 0, 1, 30),
(3880, '28ca62ef-406a-42a3-9c6e-f924a0424d8c', 989, 'Symmetric vs Asymmetric', 'text', '<h2>Symmetric vs Asymmetric</h2><p>This lesson covers Symmetric vs Asymmetric in the context of Cryptography Fundamentals.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Symmetric vs Asymmetric</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 31, NULL, 0, '2025-12-24 17:06:35', '2025-12-24 17:06:35', 0, 0, 1, 30),
(3881, '694c9e2b-2158-493a-bb4e-f42e8d92f822', 989, 'Hashing', 'text', '<h2>Hashing</h2><p>This lesson covers Hashing in the context of Cryptography Fundamentals.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Hashing</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 33, NULL, 0, '2025-12-24 17:06:35', '2025-12-24 17:06:35', 0, 0, 1, 30),
(3882, '9078ab3b-9418-48a1-93b1-73d74a7388fb', 989, 'Digital Signatures', 'text', '<h2>Digital Signatures</h2><p>This lesson covers Digital Signatures in the context of Cryptography Fundamentals.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Digital Signatures</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 40, NULL, 0, '2025-12-24 17:06:35', '2025-12-24 17:06:35', 0, 0, 1, 30),
(3883, '87d1f732-c649-45b9-b70d-f8e4b476f60a', 990, 'SSL/TLS', 'text', '<h2>SSL/TLS</h2><p>This lesson covers SSL/TLS in the context of Applied Cryptography.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of SSL/TLS</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 42, NULL, 0, '2025-12-24 17:06:36', '2025-12-24 17:06:36', 0, 0, 1, 30),
(3884, 'dd30c027-c4cc-482d-8468-ba499b56299f', 990, 'PKI', 'text', '<h2>PKI</h2><p>This lesson covers PKI in the context of Applied Cryptography.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of PKI</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 30, NULL, 0, '2025-12-24 17:06:36', '2025-12-24 17:06:36', 0, 0, 1, 30),
(3885, 'cdf6701c-34b9-4ddc-8755-6f63662a1eb7', 990, 'Certificate Management', 'text', '<h2>Certificate Management</h2><p>This lesson covers Certificate Management in the context of Applied Cryptography.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Certificate Management</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 36, NULL, 0, '2025-12-24 17:06:37', '2025-12-24 17:06:37', 0, 0, 1, 30),
(3886, '7d413c0e-c967-452e-bf1f-d3138367cea0', 990, 'Encryption Tools', 'text', '<h2>Encryption Tools</h2><p>This lesson covers Encryption Tools in the context of Applied Cryptography.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Encryption Tools</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 30, NULL, 0, '2025-12-24 17:06:37', '2025-12-24 17:06:37', 0, 0, 1, 30),
(3887, 'cafad7af-ca95-4561-a715-87b0ec878ae3', 991, 'Authentication', 'text', '<h2>Authentication</h2><p>This lesson covers Authentication in the context of Identity and Access Management.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Authentication</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 36, NULL, 0, '2025-12-24 17:06:37', '2025-12-24 17:06:37', 0, 0, 1, 30),
(3888, '225121d9-f3c8-4cb3-ab20-909cec485f87', 991, 'Authorization', 'text', '<h2>Authorization</h2><p>This lesson covers Authorization in the context of Identity and Access Management.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Authorization</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 44, NULL, 0, '2025-12-24 17:06:37', '2025-12-24 17:06:37', 0, 0, 1, 30),
(3889, '607cdcb2-a221-48d7-ace5-a2d01d5ea58e', 991, 'MFA', 'text', '<h2>MFA</h2><p>This lesson covers MFA in the context of Identity and Access Management.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of MFA</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 42, NULL, 0, '2025-12-24 17:06:38', '2025-12-24 17:06:38', 0, 0, 1, 30),
(3890, '20bf1537-14b1-4c3f-9845-c79ed916fbe8', 991, 'SSO and Federation', 'text', '<h2>SSO and Federation</h2><p>This lesson covers SSO and Federation in the context of Identity and Access Management.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of SSO and Federation</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 44, NULL, 0, '2025-12-24 17:06:38', '2025-12-24 17:06:38', 0, 0, 1, 30),
(3891, '84c65574-2614-40d9-ad7a-ccbe94a19d31', 992, 'Pen Testing Methodology', 'text', '<h2>Pen Testing Methodology</h2><p>This lesson covers Pen Testing Methodology in the context of Introduction to Pen Testing.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Pen Testing Methodology</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 35, NULL, 0, '2025-12-24 17:06:38', '2025-12-24 17:06:38', 0, 0, 1, 30),
(3892, 'be8d55b5-7a1e-4b0c-868a-eb18c2d16ca3', 992, 'Types of Testing', 'text', '<h2>Types of Testing</h2><p>This lesson covers Types of Testing in the context of Introduction to Pen Testing.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Types of Testing</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 41, NULL, 0, '2025-12-24 17:06:38', '2025-12-24 17:06:38', 0, 0, 1, 30),
(3893, '57ee1c1b-42d9-43f3-852b-8863e82ab738', 992, 'Legal Considerations', 'text', '<h2>Legal Considerations</h2><p>This lesson covers Legal Considerations in the context of Introduction to Pen Testing.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Legal Considerations</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 24, NULL, 0, '2025-12-24 17:06:38', '2025-12-24 17:06:38', 0, 0, 1, 30),
(3894, 'e3cb8853-b6ee-4923-bd25-1fec5e7cf1c4', 992, 'Reporting', 'text', '<h2>Reporting</h2><p>This lesson covers Reporting in the context of Introduction to Pen Testing.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Reporting</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 33, NULL, 0, '2025-12-24 17:06:39', '2025-12-24 17:06:39', 0, 0, 1, 30),
(3895, 'cdf6d7a5-8ac1-423d-8060-54d1f0128490', 993, 'Passive Recon', 'text', '<h2>Passive Recon</h2><p>This lesson covers Passive Recon in the context of Reconnaissance Techniques.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Passive Recon</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 22, NULL, 0, '2025-12-24 17:06:39', '2025-12-24 17:06:39', 0, 0, 1, 30),
(3896, 'b4ee56ea-eb14-4542-a7a5-02abc855b754', 993, 'Active Recon', 'text', '<h2>Active Recon</h2><p>This lesson covers Active Recon in the context of Reconnaissance Techniques.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Active Recon</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 21, NULL, 0, '2025-12-24 17:06:40', '2025-12-24 17:06:40', 0, 0, 1, 30),
(3897, '8b7eb7ad-0d5d-4c68-81a4-bee0e392074e', 993, 'OSINT', 'text', '<h2>OSINT</h2><p>This lesson covers OSINT in the context of Reconnaissance Techniques.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of OSINT</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 28, NULL, 0, '2025-12-24 17:06:40', '2025-12-24 17:06:40', 0, 0, 1, 30),
(3898, '18b0beef-01bd-425d-aa1e-7028f3e60e74', 993, 'Footprinting', 'text', '<h2>Footprinting</h2><p>This lesson covers Footprinting in the context of Reconnaissance Techniques.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Footprinting</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 23, NULL, 0, '2025-12-24 17:06:40', '2025-12-24 17:06:40', 0, 0, 1, 30),
(3899, '6947e9a8-f1e5-4c12-bff6-cda2520b8236', 994, 'Vulnerability Scanning', 'text', '<h2>Vulnerability Scanning</h2><p>This lesson covers Vulnerability Scanning in the context of Vulnerability Assessment.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Vulnerability Scanning</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 19, NULL, 0, '2025-12-24 17:06:40', '2025-12-24 17:06:40', 0, 0, 1, 30),
(3900, 'e583856f-44bf-4430-bb17-980115a4ec0f', 994, 'Nessus', 'text', '<h2>Nessus</h2><p>This lesson covers Nessus in the context of Vulnerability Assessment.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Nessus</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 23, NULL, 0, '2025-12-24 17:06:40', '2025-12-24 17:06:40', 0, 0, 1, 30),
(3901, 'b8976157-8275-4223-b362-392f8bfcf98c', 994, 'OpenVAS', 'text', '<h2>OpenVAS</h2><p>This lesson covers OpenVAS in the context of Vulnerability Assessment.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of OpenVAS</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 42, NULL, 0, '2025-12-24 17:06:41', '2025-12-24 17:06:41', 0, 0, 1, 30),
(3902, '8bc8f1c1-3cd4-48ee-bafd-64be7d1e2a8e', 994, 'Prioritization', 'text', '<h2>Prioritization</h2><p>This lesson covers Prioritization in the context of Vulnerability Assessment.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Prioritization</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 42, NULL, 0, '2025-12-24 17:06:41', '2025-12-24 17:06:41', 0, 0, 1, 30),
(3903, '50dc2b4f-b5d7-49de-9480-f783e419c3c4', 995, 'Exploitation Framework', 'text', '<h2>Exploitation Framework</h2><p>This lesson covers Exploitation Framework in the context of Exploitation Basics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Exploitation Framework</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 31, NULL, 0, '2025-12-24 17:06:42', '2025-12-24 17:06:42', 0, 0, 1, 30),
(3904, '0ead0423-30e2-4695-a081-b0adbf886044', 995, 'Metasploit', 'text', '<h2>Metasploit</h2><p>This lesson covers Metasploit in the context of Exploitation Basics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Metasploit</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 37, NULL, 0, '2025-12-24 17:06:42', '2025-12-24 17:06:42', 0, 0, 1, 30),
(3905, '0a255b7f-f9a5-4e86-b665-af31faf2717d', 995, 'Post-Exploitation', 'text', '<h2>Post-Exploitation</h2><p>This lesson covers Post-Exploitation in the context of Exploitation Basics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Post-Exploitation</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 26, NULL, 0, '2025-12-24 17:06:42', '2025-12-24 17:06:42', 0, 0, 1, 30),
(3906, '7e3302ee-f107-4026-876b-911246c38675', 995, 'Privilege Escalation', 'text', '<h2>Privilege Escalation</h2><p>This lesson covers Privilege Escalation in the context of Exploitation Basics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Privilege Escalation</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 32, NULL, 0, '2025-12-24 17:06:43', '2025-12-24 17:06:43', 0, 0, 1, 30),
(3907, 'aa4bd2d9-ba27-4c3b-b9b0-96e5811d84c5', 996, 'SOC Overview', 'text', '<h2>SOC Overview</h2><p>This lesson covers SOC Overview in the context of Security Operations Center.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of SOC Overview</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 44, NULL, 0, '2025-12-24 17:06:43', '2025-12-24 17:06:43', 0, 0, 1, 30),
(3908, 'cfe2a1cb-72dc-4a97-a0cf-be995b268a07', 996, 'Incident Triage', 'text', '<h2>Incident Triage</h2><p>This lesson covers Incident Triage in the context of Security Operations Center.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Incident Triage</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 34, NULL, 0, '2025-12-24 17:06:44', '2025-12-24 17:06:44', 0, 0, 1, 30),
(3909, '9ccc46c1-59ec-47fa-b04c-1749cf73e23f', 996, 'Threat Hunting', 'text', '<h2>Threat Hunting</h2><p>This lesson covers Threat Hunting in the context of Security Operations Center.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Threat Hunting</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 42, NULL, 0, '2025-12-24 17:06:44', '2025-12-24 17:06:44', 0, 0, 1, 30),
(3910, 'dda9919b-9862-4240-9adf-545384662e85', 996, 'Playbooks', 'text', '<h2>Playbooks</h2><p>This lesson covers Playbooks in the context of Security Operations Center.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Playbooks</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 26, NULL, 0, '2025-12-24 17:06:44', '2025-12-24 17:06:44', 0, 0, 1, 30),
(3911, 'b107dd86-26e3-40e6-a17e-6773d9d9d778', 997, 'IR Process', 'text', '<h2>IR Process</h2><p>This lesson covers IR Process in the context of Incident Response.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of IR Process</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 32, NULL, 0, '2025-12-24 17:06:44', '2025-12-24 17:06:44', 0, 0, 1, 30),
(3912, '1e8b74d9-9ec7-4cd4-b3ba-37b18ac4f4d7', 997, 'Containment', 'text', '<h2>Containment</h2><p>This lesson covers Containment in the context of Incident Response.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Containment</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 25, NULL, 0, '2025-12-24 17:06:45', '2025-12-24 17:06:45', 0, 0, 1, 30),
(3913, 'fae1e6e7-9bcd-466c-9a21-5011bdf5280e', 997, 'Eradication', 'text', '<h2>Eradication</h2><p>This lesson covers Eradication in the context of Incident Response.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Eradication</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 44, NULL, 0, '2025-12-24 17:06:45', '2025-12-24 17:06:45', 0, 0, 1, 30),
(3914, '6c9bfb79-b269-47a2-a8ec-2574311c8ba2', 997, 'Recovery', 'text', '<h2>Recovery</h2><p>This lesson covers Recovery in the context of Incident Response.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Recovery</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 34, NULL, 0, '2025-12-24 17:06:46', '2025-12-24 17:06:46', 0, 0, 1, 30),
(3915, '3dd2cfab-8b9a-4b04-9ed8-1953d56d504b', 998, 'Forensic Principles', 'text', '<h2>Forensic Principles</h2><p>This lesson covers Forensic Principles in the context of Digital Forensics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Forensic Principles</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 24, NULL, 0, '2025-12-24 17:06:47', '2025-12-24 17:06:47', 0, 0, 1, 30),
(3916, '7e491c58-1e05-48a9-97ea-1387c1ac8e03', 998, 'Evidence Collection', 'text', '<h2>Evidence Collection</h2><p>This lesson covers Evidence Collection in the context of Digital Forensics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Evidence Collection</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 24, NULL, 0, '2025-12-24 17:06:47', '2025-12-24 17:06:47', 0, 0, 1, 30),
(3917, 'a8d6890d-8553-4dec-bb32-cff5d9355120', 998, 'Analysis Tools', 'text', '<h2>Analysis Tools</h2><p>This lesson covers Analysis Tools in the context of Digital Forensics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Analysis Tools</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 15, NULL, 0, '2025-12-24 17:06:47', '2025-12-24 17:06:47', 0, 0, 1, 30),
(3918, '581040df-e936-4ab9-a02c-eb47c5f9f7e1', 998, 'Chain of Custody', 'text', '<h2>Chain of Custody</h2><p>This lesson covers Chain of Custody in the context of Digital Forensics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Chain of Custody</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 40, NULL, 0, '2025-12-24 17:06:47', '2025-12-24 17:06:47', 0, 0, 1, 30),
(3919, 'e7198f76-6521-4c14-99c2-ce5ab4844ddc', 999, 'Policy Development', 'text', '<h2>Policy Development</h2><p>This lesson covers Policy Development in the context of Security Policies.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Policy Development</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 21, NULL, 0, '2025-12-24 17:06:48', '2025-12-24 17:06:48', 0, 0, 1, 30),
(3920, '38d6880c-3d66-4082-b549-ab590d7d084b', 999, 'Standards and Frameworks', 'text', '<h2>Standards and Frameworks</h2><p>This lesson covers Standards and Frameworks in the context of Security Policies.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Standards and Frameworks</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 16, NULL, 0, '2025-12-24 17:06:48', '2025-12-24 17:06:48', 0, 0, 1, 30),
(3921, 'bbbb56f7-46c1-4a77-9ac5-d5a899224148', 999, 'Compliance', 'text', '<h2>Compliance</h2><p>This lesson covers Compliance in the context of Security Policies.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Compliance</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 19, NULL, 0, '2025-12-24 17:06:48', '2025-12-24 17:06:48', 0, 0, 1, 30),
(3922, 'e38abc05-6b2e-4d3f-b97c-f7f56032f984', 999, 'Governance', 'text', '<h2>Governance</h2><p>This lesson covers Governance in the context of Security Policies.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Governance</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 25, NULL, 0, '2025-12-24 17:06:48', '2025-12-24 17:06:48', 0, 0, 1, 30),
(3923, 'd059c065-d7d9-4265-8595-77a9af062216', 1000, 'Risk Assessment', 'text', '<h2>Risk Assessment</h2><p>This lesson covers Risk Assessment in the context of Risk Management.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Risk Assessment</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 24, NULL, 0, '2025-12-24 17:06:48', '2025-12-24 17:06:48', 0, 0, 1, 30),
(3924, 'e7e5bd8d-77d9-47b1-bf49-acb6b8192900', 1000, 'Risk Analysis', 'text', '<h2>Risk Analysis</h2><p>This lesson covers Risk Analysis in the context of Risk Management.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Risk Analysis</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 44, NULL, 0, '2025-12-24 17:06:48', '2025-12-24 17:06:48', 0, 0, 1, 30),
(3925, 'f06a4f98-e72e-41fd-933c-98743a630ce7', 1000, 'Risk Mitigation', 'text', '<h2>Risk Mitigation</h2><p>This lesson covers Risk Mitigation in the context of Risk Management.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Risk Mitigation</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 27, NULL, 0, '2025-12-24 17:06:48', '2025-12-24 17:06:48', 0, 0, 1, 30),
(3926, '59e1d54d-53a0-41ba-a799-402a40dc890d', 1000, 'Business Continuity', 'text', '<h2>Business Continuity</h2><p>This lesson covers Business Continuity in the context of Risk Management.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Business Continuity</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 18, NULL, 0, '2025-12-24 17:06:49', '2025-12-24 17:06:49', 0, 0, 1, 30),
(3927, '76921fcd-54a1-4c2e-b1a4-0237f45b344f', 1001, 'Training Programs', 'text', '<h2>Training Programs</h2><p>This lesson covers Training Programs in the context of Security Awareness.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Training Programs</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 19, NULL, 0, '2025-12-24 17:06:49', '2025-12-24 17:06:49', 0, 0, 1, 30),
(3928, '9401c614-5e97-4fe4-b6fa-89f5e43a387f', 1001, 'Phishing Simulations', 'text', '<h2>Phishing Simulations</h2><p>This lesson covers Phishing Simulations in the context of Security Awareness.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Phishing Simulations</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 45, NULL, 0, '2025-12-24 17:06:49', '2025-12-24 17:06:49', 0, 0, 1, 30),
(3929, 'fb4f804c-2ea2-4840-a6b3-38e1d67a3f32', 1001, 'Culture Building', 'text', '<h2>Culture Building</h2><p>This lesson covers Culture Building in the context of Security Awareness.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Culture Building</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 41, NULL, 0, '2025-12-24 17:06:49', '2025-12-24 17:06:49', 0, 0, 1, 30),
(3930, 'b2c92560-d119-4e5f-992f-7926544608c9', 1001, 'Metrics', 'text', '<h2>Metrics</h2><p>This lesson covers Metrics in the context of Security Awareness.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Metrics</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 45, NULL, 0, '2025-12-24 17:06:49', '2025-12-24 17:06:49', 0, 0, 1, 30),
(3931, 'b60a5a89-a57b-439c-955c-144c7d67c2b6', 1002, 'Cloud Security Basics', 'text', '<h2>Cloud Security Basics</h2><p>This lesson covers Cloud Security Basics in the context of Cloud Security.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Cloud Security Basics</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 20, NULL, 0, '2025-12-24 17:06:50', '2025-12-24 17:06:50', 0, 0, 1, 30),
(3932, '2b5b59b1-b418-4788-9cbb-fcc1c9191970', 1002, 'Shared Responsibility', 'text', '<h2>Shared Responsibility</h2><p>This lesson covers Shared Responsibility in the context of Cloud Security.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Shared Responsibility</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 29, NULL, 0, '2025-12-24 17:06:51', '2025-12-24 17:06:51', 0, 0, 1, 30),
(3933, '26266c2a-eacc-493e-871b-40486ecfd724', 1002, 'Cloud Compliance', 'text', '<h2>Cloud Compliance</h2><p>This lesson covers Cloud Compliance in the context of Cloud Security.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Cloud Compliance</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 36, NULL, 0, '2025-12-24 17:06:53', '2025-12-24 17:06:53', 0, 0, 1, 30),
(3934, '6ac702f3-4380-4750-bbdb-ba8d0ee2ffc4', 1002, 'Cloud Security Tools', 'text', '<h2>Cloud Security Tools</h2><p>This lesson covers Cloud Security Tools in the context of Cloud Security.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Cloud Security Tools</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 37, NULL, 0, '2025-12-24 17:06:54', '2025-12-24 17:06:54', 0, 0, 1, 30),
(3935, 'a1f59d58-ce2a-475c-b3ac-b2ae07e60f26', 1003, 'What is Cloud Computing?', 'text', '<h2>What is Cloud Computing?</h2><p>This lesson covers What is Cloud Computing? in the context of Cloud Computing Fundamentals.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of What is Cloud Computing?</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 21, NULL, 0, '2025-12-24 17:06:54', '2025-12-24 17:06:54', 0, 0, 1, 30),
(3936, '7db63468-afd0-489d-b57b-f6e25123b48f', 1003, 'Cloud History', 'text', '<h2>Cloud History</h2><p>This lesson covers Cloud History in the context of Cloud Computing Fundamentals.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Cloud History</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 20, NULL, 0, '2025-12-24 17:06:54', '2025-12-24 17:06:54', 0, 0, 1, 30);
INSERT INTO `lessons` (`id`, `uuid`, `module_id`, `title`, `type`, `content`, `order_index`, `duration_minutes`, `resources`, `ai_generated`, `created_at`, `updated_at`, `has_practical`, `has_quiz`, `competency_weight`, `estimated_time_minutes`) VALUES
(3937, 'ca6a926f-d581-4f19-a01b-fff10d270032', 1003, 'Benefits of Cloud', 'text', '<h2>Benefits of Cloud</h2><p>This lesson covers Benefits of Cloud in the context of Cloud Computing Fundamentals.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Benefits of Cloud</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 21, NULL, 0, '2025-12-24 17:06:54', '2025-12-24 17:06:54', 0, 0, 1, 30),
(3938, '527251c8-ada0-4acc-a072-743f966f232e', 1003, 'Cloud Challenges', 'text', '<h2>Cloud Challenges</h2><p>This lesson covers Cloud Challenges in the context of Cloud Computing Fundamentals.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Cloud Challenges</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 36, NULL, 0, '2025-12-24 17:06:55', '2025-12-24 17:06:55', 0, 0, 1, 30),
(3939, '246f2db5-1fbc-4f2c-bfe5-73933d5ac309', 1004, 'IaaS', 'text', '<h2>IaaS</h2><p>This lesson covers IaaS in the context of Cloud Service Models.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of IaaS</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 16, NULL, 0, '2025-12-24 17:06:55', '2025-12-24 17:06:55', 0, 0, 1, 30),
(3940, 'ae799726-77cb-4d01-bde5-ec1fed4e6185', 1004, 'PaaS', 'text', '<h2>PaaS</h2><p>This lesson covers PaaS in the context of Cloud Service Models.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of PaaS</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 28, NULL, 0, '2025-12-24 17:06:55', '2025-12-24 17:06:55', 0, 0, 1, 30),
(3941, '7f570495-643e-49f0-b6b2-a61bfeb7ec8c', 1004, 'SaaS', 'text', '<h2>SaaS</h2><p>This lesson covers SaaS in the context of Cloud Service Models.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of SaaS</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 38, NULL, 0, '2025-12-24 17:06:55', '2025-12-24 17:06:55', 0, 0, 1, 30),
(3942, '959efab3-5c93-4201-bae9-fb185a66cdc4', 1004, 'Serverless', 'text', '<h2>Serverless</h2><p>This lesson covers Serverless in the context of Cloud Service Models.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Serverless</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 30, NULL, 0, '2025-12-24 17:06:56', '2025-12-24 17:06:56', 0, 0, 1, 30),
(3943, '7c83beb0-3d62-441b-bbdf-fe9b066bf2de', 1005, 'Public Cloud', 'text', '<h2>Public Cloud</h2><p>This lesson covers Public Cloud in the context of Cloud Deployment Models.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Public Cloud</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 15, NULL, 0, '2025-12-24 17:06:57', '2025-12-24 17:06:57', 0, 0, 1, 30),
(3944, 'b45e8d09-9a62-4c14-87a3-a4f5a142fd96', 1005, 'Private Cloud', 'text', '<h2>Private Cloud</h2><p>This lesson covers Private Cloud in the context of Cloud Deployment Models.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Private Cloud</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 28, NULL, 0, '2025-12-24 17:06:58', '2025-12-24 17:06:58', 0, 0, 1, 30),
(3945, 'ee2a2e4e-ca5d-4beb-9cde-b3c22e0ab753', 1005, 'Hybrid Cloud', 'text', '<h2>Hybrid Cloud</h2><p>This lesson covers Hybrid Cloud in the context of Cloud Deployment Models.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Hybrid Cloud</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 25, NULL, 0, '2025-12-24 17:06:58', '2025-12-24 17:06:58', 0, 0, 1, 30),
(3946, '83758e35-7776-4654-8106-f891a55eb62d', 1005, 'Multi-Cloud', 'text', '<h2>Multi-Cloud</h2><p>This lesson covers Multi-Cloud in the context of Cloud Deployment Models.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Multi-Cloud</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 39, NULL, 0, '2025-12-24 17:06:58', '2025-12-24 17:06:58', 0, 0, 1, 30),
(3947, '167a6784-5c13-4a4a-999d-de838e01b2e3', 1006, 'AWS Overview', 'text', '<h2>AWS Overview</h2><p>This lesson covers AWS Overview in the context of Major Cloud Providers.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of AWS Overview</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 36, NULL, 0, '2025-12-24 17:06:59', '2025-12-24 17:06:59', 0, 0, 1, 30),
(3948, '7c0f0ab5-b3e7-4489-8133-1e1bddc1b268', 1006, 'Azure Overview', 'text', '<h2>Azure Overview</h2><p>This lesson covers Azure Overview in the context of Major Cloud Providers.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Azure Overview</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 22, NULL, 0, '2025-12-24 17:06:59', '2025-12-24 17:06:59', 0, 0, 1, 30),
(3949, '87202b6f-9dad-41f8-b56e-4b2f40b2cd40', 1006, 'GCP Overview', 'text', '<h2>GCP Overview</h2><p>This lesson covers GCP Overview in the context of Major Cloud Providers.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of GCP Overview</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 26, NULL, 0, '2025-12-24 17:07:00', '2025-12-24 17:07:00', 0, 0, 1, 30),
(3950, '0ad5075a-536d-4e9a-91ef-1b8d89acf7bb', 1006, 'Provider Comparison', 'text', '<h2>Provider Comparison</h2><p>This lesson covers Provider Comparison in the context of Major Cloud Providers.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Provider Comparison</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 29, NULL, 0, '2025-12-24 17:07:00', '2025-12-24 17:07:00', 0, 0, 1, 30),
(3951, 'c08466f3-2c12-46cf-a899-d3b45319d80c', 1007, 'Account Creation', 'text', '<h2>Account Creation</h2><p>This lesson covers Account Creation in the context of AWS Account Setup.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Account Creation</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 16, NULL, 0, '2025-12-24 17:07:01', '2025-12-24 17:07:01', 0, 0, 1, 30),
(3952, '57a40e7b-e3c3-481a-a302-6911153f9178', 1007, 'IAM Basics', 'text', '<h2>IAM Basics</h2><p>This lesson covers IAM Basics in the context of AWS Account Setup.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of IAM Basics</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 16, NULL, 0, '2025-12-24 17:07:01', '2025-12-24 17:07:01', 0, 0, 1, 30),
(3953, 'b51aef6d-b780-4907-a994-6802a1f782f5', 1007, 'Billing Setup', 'text', '<h2>Billing Setup</h2><p>This lesson covers Billing Setup in the context of AWS Account Setup.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Billing Setup</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 38, NULL, 0, '2025-12-24 17:07:01', '2025-12-24 17:07:01', 0, 0, 1, 30),
(3954, '58abb70b-dc1d-4ff2-b552-02d9770d64ca', 1007, 'Console Navigation', 'text', '<h2>Console Navigation</h2><p>This lesson covers Console Navigation in the context of AWS Account Setup.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Console Navigation</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 38, NULL, 0, '2025-12-24 17:07:01', '2025-12-24 17:07:01', 0, 0, 1, 30),
(3955, '708ff035-6b2c-4a14-b879-b730ae0c3929', 1008, 'EC2 Basics', 'text', '<h2>EC2 Basics</h2><p>This lesson covers EC2 Basics in the context of AWS Compute Services.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of EC2 Basics</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 32, NULL, 0, '2025-12-24 17:07:02', '2025-12-24 17:07:02', 0, 0, 1, 30),
(3956, '4383422a-c590-4402-9e92-c5eb160c14ef', 1008, 'Instance Types', 'text', '<h2>Instance Types</h2><p>This lesson covers Instance Types in the context of AWS Compute Services.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Instance Types</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 30, NULL, 0, '2025-12-24 17:07:02', '2025-12-24 17:07:02', 0, 0, 1, 30),
(3957, 'e1628523-172e-417b-99a6-9fdbd1319e0f', 1008, 'AMIs', 'text', '<h2>AMIs</h2><p>This lesson covers AMIs in the context of AWS Compute Services.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of AMIs</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 38, NULL, 0, '2025-12-24 17:07:02', '2025-12-24 17:07:02', 0, 0, 1, 30),
(3958, '6e6ab699-4350-46f5-8389-46c0cbc689cb', 1008, 'Auto Scaling', 'text', '<h2>Auto Scaling</h2><p>This lesson covers Auto Scaling in the context of AWS Compute Services.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Auto Scaling</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 18, NULL, 0, '2025-12-24 17:07:02', '2025-12-24 17:07:02', 0, 0, 1, 30),
(3959, '9fbc1617-cc01-4e86-b994-f7aabed032cb', 1009, 'S3 Fundamentals', 'text', '<h2>S3 Fundamentals</h2><p>This lesson covers S3 Fundamentals in the context of AWS Storage Services.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of S3 Fundamentals</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 21, NULL, 0, '2025-12-24 17:07:03', '2025-12-24 17:07:03', 0, 0, 1, 30),
(3960, 'ef4ddfdf-7239-431c-81f2-ff536d5de9bd', 1009, 'S3 Features', 'text', '<h2>S3 Features</h2><p>This lesson covers S3 Features in the context of AWS Storage Services.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of S3 Features</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 16, NULL, 0, '2025-12-24 17:07:03', '2025-12-24 17:07:03', 0, 0, 1, 30),
(3961, 'ddacdf89-47c9-4f2b-b956-a9f6a9bcd628', 1009, 'EBS', 'text', '<h2>EBS</h2><p>This lesson covers EBS in the context of AWS Storage Services.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of EBS</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 21, NULL, 0, '2025-12-24 17:07:04', '2025-12-24 17:07:04', 0, 0, 1, 30),
(3962, '83e86b23-5c88-43f6-be3f-2dcf804d3937', 1009, 'EFS', 'text', '<h2>EFS</h2><p>This lesson covers EFS in the context of AWS Storage Services.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of EFS</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 23, NULL, 0, '2025-12-24 17:07:04', '2025-12-24 17:07:04', 0, 0, 1, 30),
(3963, '6852db31-0d15-496f-b91f-d41c82a4fed0', 1010, 'VPC Basics', 'text', '<h2>VPC Basics</h2><p>This lesson covers VPC Basics in the context of AWS Networking.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of VPC Basics</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 26, NULL, 0, '2025-12-24 17:07:05', '2025-12-24 17:07:05', 0, 0, 1, 30),
(3964, '5c588962-039e-48a6-9a5d-7bbab4b1a83f', 1010, 'Subnets', 'text', '<h2>Subnets</h2><p>This lesson covers Subnets in the context of AWS Networking.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Subnets</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 22, NULL, 0, '2025-12-24 17:07:05', '2025-12-24 17:07:05', 0, 0, 1, 30),
(3965, 'e1feb0f1-e5de-469e-9764-44c4fd1a00c6', 1010, 'Security Groups', 'text', '<h2>Security Groups</h2><p>This lesson covers Security Groups in the context of AWS Networking.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Security Groups</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 18, NULL, 0, '2025-12-24 17:07:05', '2025-12-24 17:07:05', 0, 0, 1, 30),
(3966, '4c274694-87cb-4f07-b3ea-248cdc22efda', 1010, 'Route Tables', 'text', '<h2>Route Tables</h2><p>This lesson covers Route Tables in the context of AWS Networking.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Route Tables</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 23, NULL, 0, '2025-12-24 17:07:05', '2025-12-24 17:07:05', 0, 0, 1, 30),
(3967, '3213de90-b9b0-4dba-b2e0-3f38c4926b94', 1011, 'RDS', 'text', '<h2>RDS</h2><p>This lesson covers RDS in the context of AWS Database Services.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of RDS</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 26, NULL, 0, '2025-12-24 17:07:05', '2025-12-24 17:07:05', 0, 0, 1, 30),
(3968, '81f00404-ff46-4364-a718-91b30d3b4bd9', 1011, 'DynamoDB', 'text', '<h2>DynamoDB</h2><p>This lesson covers DynamoDB in the context of AWS Database Services.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of DynamoDB</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 18, NULL, 0, '2025-12-24 17:07:05', '2025-12-24 17:07:05', 0, 0, 1, 30),
(3969, '16d3d1d2-7534-4831-bf19-e8602ca14930', 1011, 'ElastiCache', 'text', '<h2>ElastiCache</h2><p>This lesson covers ElastiCache in the context of AWS Database Services.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of ElastiCache</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 18, NULL, 0, '2025-12-24 17:07:05', '2025-12-24 17:07:05', 0, 0, 1, 30),
(3970, '7875dd40-ce3d-4fe2-915c-2889c081db57', 1011, 'Database Migration', 'text', '<h2>Database Migration</h2><p>This lesson covers Database Migration in the context of AWS Database Services.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Database Migration</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 19, NULL, 0, '2025-12-24 17:07:06', '2025-12-24 17:07:06', 0, 0, 1, 30),
(3971, 'f654a1ec-1c7b-4b01-8305-698aa98e91a3', 1012, 'IAM Policies', 'text', '<h2>IAM Policies</h2><p>This lesson covers IAM Policies in the context of AWS Security.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of IAM Policies</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 36, NULL, 0, '2025-12-24 17:07:06', '2025-12-24 17:07:06', 0, 0, 1, 30),
(3972, '75e0882a-6baf-49bc-b6c4-4976313a0836', 1012, 'Security Best Practices', 'text', '<h2>Security Best Practices</h2><p>This lesson covers Security Best Practices in the context of AWS Security.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Security Best Practices</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 23, NULL, 0, '2025-12-24 17:07:06', '2025-12-24 17:07:06', 0, 0, 1, 30),
(3973, 'd5ec6c2b-2efe-481e-8144-26effb9bd4c8', 1012, 'KMS', 'text', '<h2>KMS</h2><p>This lesson covers KMS in the context of AWS Security.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of KMS</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 18, NULL, 0, '2025-12-24 17:07:06', '2025-12-24 17:07:06', 0, 0, 1, 30),
(3974, 'c6f5457d-f35d-4437-96f9-9c835b704adf', 1012, 'CloudTrail', 'text', '<h2>CloudTrail</h2><p>This lesson covers CloudTrail in the context of AWS Security.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of CloudTrail</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 32, NULL, 0, '2025-12-24 17:07:06', '2025-12-24 17:07:06', 0, 0, 1, 30),
(3975, '78655dc8-62a1-4cb9-a64a-e0da6ecf992d', 1013, 'Lambda', 'text', '<h2>Lambda</h2><p>This lesson covers Lambda in the context of AWS Application Services.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Lambda</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 20, NULL, 0, '2025-12-24 17:07:06', '2025-12-24 17:07:06', 0, 0, 1, 30),
(3976, '94b9c97a-9d7a-4ce7-9e9d-164f7d7306ef', 1013, 'API Gateway', 'text', '<h2>API Gateway</h2><p>This lesson covers API Gateway in the context of AWS Application Services.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of API Gateway</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 24, NULL, 0, '2025-12-24 17:07:06', '2025-12-24 17:07:06', 0, 0, 1, 30),
(3977, '2a95647a-fbe4-4072-9f73-6e4fd2a96ae5', 1013, 'SQS', 'text', '<h2>SQS</h2><p>This lesson covers SQS in the context of AWS Application Services.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of SQS</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 16, NULL, 0, '2025-12-24 17:07:07', '2025-12-24 17:07:07', 0, 0, 1, 30),
(3978, '43dfbb97-45f4-45ef-b3d2-9b58006c3421', 1013, 'SNS', 'text', '<h2>SNS</h2><p>This lesson covers SNS in the context of AWS Application Services.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of SNS</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 43, NULL, 0, '2025-12-24 17:07:07', '2025-12-24 17:07:07', 0, 0, 1, 30),
(3979, 'e018a509-89fb-490f-bbf7-4f956d103881', 1014, 'IaC Concepts', 'text', '<h2>IaC Concepts</h2><p>This lesson covers IaC Concepts in the context of Infrastructure as Code.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of IaC Concepts</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 24, NULL, 0, '2025-12-24 17:07:07', '2025-12-24 17:07:07', 0, 0, 1, 30),
(3980, 'c88755de-48d8-435d-b63f-bb8eb6ccf3a6', 1014, 'CloudFormation', 'text', '<h2>CloudFormation</h2><p>This lesson covers CloudFormation in the context of Infrastructure as Code.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of CloudFormation</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 45, NULL, 0, '2025-12-24 17:07:07', '2025-12-24 17:07:07', 0, 0, 1, 30),
(3981, '3c4cd617-f3e7-4129-9965-117ad4b133d7', 1014, 'Terraform Basics', 'text', '<h2>Terraform Basics</h2><p>This lesson covers Terraform Basics in the context of Infrastructure as Code.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Terraform Basics</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 23, NULL, 0, '2025-12-24 17:07:07', '2025-12-24 17:07:07', 0, 0, 1, 30),
(3982, '7a5e8f0a-1a1a-44f9-83a8-d444621a234b', 1014, 'Template Design', 'text', '<h2>Template Design</h2><p>This lesson covers Template Design in the context of Infrastructure as Code.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Template Design</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 38, NULL, 0, '2025-12-24 17:07:08', '2025-12-24 17:07:08', 0, 0, 1, 30),
(3983, '3ee6d4b8-0a87-4582-888b-c9b20b39ffea', 1015, 'DevOps Culture', 'text', '<h2>DevOps Culture</h2><p>This lesson covers DevOps Culture in the context of DevOps Principles.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of DevOps Culture</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 26, NULL, 0, '2025-12-24 17:07:08', '2025-12-24 17:07:08', 0, 0, 1, 30),
(3984, 'e09deb3b-dccc-4bf6-b057-ea4a543edc59', 1015, 'CI/CD Overview', 'text', '<h2>CI/CD Overview</h2><p>This lesson covers CI/CD Overview in the context of DevOps Principles.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of CI/CD Overview</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 24, NULL, 0, '2025-12-24 17:07:08', '2025-12-24 17:07:08', 0, 0, 1, 30),
(3985, 'c170ff18-54cc-40d0-b37a-0354ee590855', 1015, 'Automation', 'text', '<h2>Automation</h2><p>This lesson covers Automation in the context of DevOps Principles.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Automation</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 31, NULL, 0, '2025-12-24 17:07:08', '2025-12-24 17:07:08', 0, 0, 1, 30),
(3986, '6910bc5c-99d1-49a4-80e5-142db06ea875', 1015, 'Collaboration', 'text', '<h2>Collaboration</h2><p>This lesson covers Collaboration in the context of DevOps Principles.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Collaboration</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 29, NULL, 0, '2025-12-24 17:07:09', '2025-12-24 17:07:09', 0, 0, 1, 30),
(3987, '5860bae7-77d5-4673-a3be-663471841de3', 1016, 'Git Basics', 'text', '<h2>Git Basics</h2><p>This lesson covers Git Basics in the context of Version Control with Git.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Git Basics</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 34, NULL, 0, '2025-12-24 17:07:09', '2025-12-24 17:07:09', 0, 0, 1, 30),
(3988, 'd0146f78-ac1c-418d-a7aa-11729146ef41', 1016, 'Branching Strategies', 'text', '<h2>Branching Strategies</h2><p>This lesson covers Branching Strategies in the context of Version Control with Git.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Branching Strategies</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 31, NULL, 0, '2025-12-24 17:07:09', '2025-12-24 17:07:09', 0, 0, 1, 30),
(3989, '96786b52-35f7-4aaa-8b53-69989dc55285', 1016, 'Pull Requests', 'text', '<h2>Pull Requests</h2><p>This lesson covers Pull Requests in the context of Version Control with Git.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Pull Requests</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 20, NULL, 0, '2025-12-24 17:07:09', '2025-12-24 17:07:09', 0, 0, 1, 30),
(3990, '53d27d1b-3800-44d6-8fde-c4f963b5440a', 1016, 'Git Workflows', 'text', '<h2>Git Workflows</h2><p>This lesson covers Git Workflows in the context of Version Control with Git.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Git Workflows</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 42, NULL, 0, '2025-12-24 17:07:09', '2025-12-24 17:07:09', 0, 0, 1, 30),
(3991, 'd73762a8-11b4-4ec6-aacd-1205930ee59f', 1017, 'Container Concepts', 'text', '<h2>Container Concepts</h2><p>This lesson covers Container Concepts in the context of Docker Fundamentals.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Container Concepts</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 15, NULL, 0, '2025-12-24 17:07:10', '2025-12-24 17:07:10', 0, 0, 1, 30),
(3992, '23b6550b-2d14-4360-b83a-446fdb110925', 1017, 'Docker Installation', 'text', '<h2>Docker Installation</h2><p>This lesson covers Docker Installation in the context of Docker Fundamentals.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Docker Installation</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 43, NULL, 0, '2025-12-24 17:07:10', '2025-12-24 17:07:10', 0, 0, 1, 30),
(3993, '550933e3-2fad-4ca3-8c30-3ea35c7639e5', 1017, 'Docker Commands', 'text', '<h2>Docker Commands</h2><p>This lesson covers Docker Commands in the context of Docker Fundamentals.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Docker Commands</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 27, NULL, 0, '2025-12-24 17:07:10', '2025-12-24 17:07:10', 0, 0, 1, 30),
(3994, '8f0e4b71-a631-48fc-8706-500fdce6a965', 1017, 'Dockerfiles', 'text', '<h2>Dockerfiles</h2><p>This lesson covers Dockerfiles in the context of Docker Fundamentals.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Dockerfiles</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 18, NULL, 0, '2025-12-24 17:07:10', '2025-12-24 17:07:10', 0, 0, 1, 30),
(3995, '53dc0c9a-eb7b-436a-bad2-2e978f4bd9e1', 1018, 'Multi-stage Builds', 'text', '<h2>Multi-stage Builds</h2><p>This lesson covers Multi-stage Builds in the context of Docker Advanced.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Multi-stage Builds</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 25, NULL, 0, '2025-12-24 17:07:10', '2025-12-24 17:07:10', 0, 0, 1, 30),
(3996, '987f425f-ea70-4ab8-baf1-ce42f700ed73', 1018, 'Docker Compose', 'text', '<h2>Docker Compose</h2><p>This lesson covers Docker Compose in the context of Docker Advanced.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Docker Compose</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 36, NULL, 0, '2025-12-24 17:07:10', '2025-12-24 17:07:10', 0, 0, 1, 30),
(3997, '5e5f6e8c-65a0-4d40-b294-6b0632389346', 1018, 'Networking', 'text', '<h2>Networking</h2><p>This lesson covers Networking in the context of Docker Advanced.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Networking</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 43, NULL, 0, '2025-12-24 17:07:11', '2025-12-24 17:07:11', 0, 0, 1, 30),
(3998, 'd252b691-515e-41aa-9a48-b3e14d19dd59', 1018, 'Volumes', 'text', '<h2>Volumes</h2><p>This lesson covers Volumes in the context of Docker Advanced.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Volumes</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 34, NULL, 0, '2025-12-24 17:07:11', '2025-12-24 17:07:11', 0, 0, 1, 30),
(3999, 'd07385c0-71f4-48e9-81b6-a8a246b6c4b5', 1019, 'K8s Architecture', 'text', '<h2>K8s Architecture</h2><p>This lesson covers K8s Architecture in the context of Kubernetes Basics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of K8s Architecture</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 23, NULL, 0, '2025-12-24 17:07:11', '2025-12-24 17:07:11', 0, 0, 1, 30),
(4000, 'e2015417-98fd-4b97-aa0e-39ce3e8f3622', 1019, 'Pods', 'text', '<h2>Pods</h2><p>This lesson covers Pods in the context of Kubernetes Basics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Pods</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 20, NULL, 0, '2025-12-24 17:07:11', '2025-12-24 17:07:11', 0, 0, 1, 30),
(4001, 'f16ea1f7-62ed-4c31-8bd3-40515e64d81f', 1019, 'Services', 'text', '<h2>Services</h2><p>This lesson covers Services in the context of Kubernetes Basics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Services</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 17, NULL, 0, '2025-12-24 17:07:11', '2025-12-24 17:07:11', 0, 0, 1, 30),
(4002, '797406ab-f130-4f04-9e3e-ecafc162a066', 1019, 'Deployments', 'text', '<h2>Deployments</h2><p>This lesson covers Deployments in the context of Kubernetes Basics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Deployments</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 26, NULL, 0, '2025-12-24 17:07:12', '2025-12-24 17:07:12', 0, 0, 1, 30),
(4003, '740c101d-5e99-4de3-8ee4-59c12f801411', 1020, 'ConfigMaps and Secrets', 'text', '<h2>ConfigMaps and Secrets</h2><p>This lesson covers ConfigMaps and Secrets in the context of Kubernetes Advanced.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of ConfigMaps and Secrets</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 29, NULL, 0, '2025-12-24 17:07:12', '2025-12-24 17:07:12', 0, 0, 1, 30),
(4004, 'bad76432-2951-4f2b-8e67-57cc444cb4f5', 1020, 'Ingress', 'text', '<h2>Ingress</h2><p>This lesson covers Ingress in the context of Kubernetes Advanced.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Ingress</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 43, NULL, 0, '2025-12-24 17:07:12', '2025-12-24 17:07:12', 0, 0, 1, 30),
(4005, '6850c8ab-ae8e-4bb7-afbb-53b2254a1f62', 1020, 'Helm', 'text', '<h2>Helm</h2><p>This lesson covers Helm in the context of Kubernetes Advanced.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Helm</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 15, NULL, 0, '2025-12-24 17:07:12', '2025-12-24 17:07:12', 0, 0, 1, 30),
(4006, 'baae7b65-2961-4cb2-9131-1b38448dc42f', 1020, 'Monitoring', 'text', '<h2>Monitoring</h2><p>This lesson covers Monitoring in the context of Kubernetes Advanced.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Monitoring</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 32, NULL, 0, '2025-12-24 17:07:12', '2025-12-24 17:07:12', 0, 0, 1, 30),
(4007, 'd3021a9f-290a-408e-910f-5dbba0c7a79b', 1021, 'Pipeline Concepts', 'text', '<h2>Pipeline Concepts</h2><p>This lesson covers Pipeline Concepts in the context of CI/CD Pipelines.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Pipeline Concepts</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 42, NULL, 0, '2025-12-24 17:07:13', '2025-12-24 17:07:13', 0, 0, 1, 30),
(4008, 'aa2f990e-6bc6-4b03-97dd-e69d0b1153f1', 1021, 'Jenkins', 'text', '<h2>Jenkins</h2><p>This lesson covers Jenkins in the context of CI/CD Pipelines.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Jenkins</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 30, NULL, 0, '2025-12-24 17:07:13', '2025-12-24 17:07:13', 0, 0, 1, 30),
(4009, '389501de-5227-45fb-8aa9-fae61c5d1f10', 1021, 'GitHub Actions', 'text', '<h2>GitHub Actions</h2><p>This lesson covers GitHub Actions in the context of CI/CD Pipelines.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of GitHub Actions</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 20, NULL, 0, '2025-12-24 17:07:13', '2025-12-24 17:07:13', 0, 0, 1, 30),
(4010, 'e52c5060-0361-4825-88c7-d04b5a3ef8c9', 1021, 'AWS CodePipeline', 'text', '<h2>AWS CodePipeline</h2><p>This lesson covers AWS CodePipeline in the context of CI/CD Pipelines.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of AWS CodePipeline</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 30, NULL, 0, '2025-12-24 17:07:13', '2025-12-24 17:07:13', 0, 0, 1, 30),
(4011, 'fd979bbd-6a24-4538-ab98-28b6bbf364f7', 1022, 'CloudWatch', 'text', '<h2>CloudWatch</h2><p>This lesson covers CloudWatch in the context of Monitoring and Logging.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of CloudWatch</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 22, NULL, 0, '2025-12-24 17:07:13', '2025-12-24 17:07:13', 0, 0, 1, 30),
(4012, '04b7279d-26ff-4842-9d23-440f924c4b9c', 1022, 'Logging Strategies', 'text', '<h2>Logging Strategies</h2><p>This lesson covers Logging Strategies in the context of Monitoring and Logging.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Logging Strategies</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 21, NULL, 0, '2025-12-24 17:07:13', '2025-12-24 17:07:13', 0, 0, 1, 30),
(4013, '62bb9564-f846-4ffc-b37d-02754503b900', 1022, 'Alerting', 'text', '<h2>Alerting</h2><p>This lesson covers Alerting in the context of Monitoring and Logging.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Alerting</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 26, NULL, 0, '2025-12-24 17:07:13', '2025-12-24 17:07:13', 0, 0, 1, 30),
(4014, 'cbaa273f-0aef-4f2c-a6c8-bf1d1da9a06b', 1022, 'Dashboards', 'text', '<h2>Dashboards</h2><p>This lesson covers Dashboards in the context of Monitoring and Logging.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Dashboards</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 17, NULL, 0, '2025-12-24 17:07:14', '2025-12-24 17:07:14', 0, 0, 1, 30),
(4015, 'cb85f490-7a66-463e-891e-7b47f69bb3d2', 1023, 'Operational Excellence', 'text', '<h2>Operational Excellence</h2><p>This lesson covers Operational Excellence in the context of Well-Architected Framework.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Operational Excellence</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 38, NULL, 0, '2025-12-24 17:07:14', '2025-12-24 17:07:14', 0, 0, 1, 30),
(4016, 'b04e6091-c591-4087-a785-30f4fad338f4', 1023, 'Security Pillar', 'text', '<h2>Security Pillar</h2><p>This lesson covers Security Pillar in the context of Well-Architected Framework.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Security Pillar</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 30, NULL, 0, '2025-12-24 17:07:14', '2025-12-24 17:07:14', 0, 0, 1, 30),
(4017, 'd92f5b7d-6666-43a8-81af-d0c46776c637', 1023, 'Reliability', 'text', '<h2>Reliability</h2><p>This lesson covers Reliability in the context of Well-Architected Framework.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Reliability</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 37, NULL, 0, '2025-12-24 17:07:14', '2025-12-24 17:07:14', 0, 0, 1, 30),
(4018, '5cd95294-e156-4f06-bb0c-192deed91b90', 1023, 'Performance', 'text', '<h2>Performance</h2><p>This lesson covers Performance in the context of Well-Architected Framework.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Performance</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 39, NULL, 0, '2025-12-24 17:07:14', '2025-12-24 17:07:14', 0, 0, 1, 30),
(4019, '5b41c86d-5ff1-4f40-b3f6-d6f4abafac79', 1024, 'HA Concepts', 'text', '<h2>HA Concepts</h2><p>This lesson covers HA Concepts in the context of High Availability.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of HA Concepts</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 21, NULL, 0, '2025-12-24 17:07:14', '2025-12-24 17:07:14', 0, 0, 1, 30),
(4020, '495c6001-8d80-4118-926e-8d2e99c24d75', 1024, 'Load Balancing', 'text', '<h2>Load Balancing</h2><p>This lesson covers Load Balancing in the context of High Availability.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Load Balancing</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 38, NULL, 0, '2025-12-24 17:07:14', '2025-12-24 17:07:14', 0, 0, 1, 30),
(4021, '57db336d-4c29-4e9d-9430-77bfddc5a7f7', 1024, 'Fault Tolerance', 'text', '<h2>Fault Tolerance</h2><p>This lesson covers Fault Tolerance in the context of High Availability.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Fault Tolerance</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 20, NULL, 0, '2025-12-24 17:07:14', '2025-12-24 17:07:14', 0, 0, 1, 30),
(4022, '5336b230-d6b3-4271-8e7d-058a83866cdd', 1024, 'Disaster Recovery', 'text', '<h2>Disaster Recovery</h2><p>This lesson covers Disaster Recovery in the context of High Availability.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Disaster Recovery</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 15, NULL, 0, '2025-12-24 17:07:14', '2025-12-24 17:07:14', 0, 0, 1, 30),
(4023, '10f2d83b-4bd0-44f6-81d8-6ea2725b3245', 1025, 'Cost Analysis', 'text', '<h2>Cost Analysis</h2><p>This lesson covers Cost Analysis in the context of Cost Optimization.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Cost Analysis</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 22, NULL, 0, '2025-12-24 17:07:15', '2025-12-24 17:07:15', 0, 0, 1, 30),
(4024, '5f15f01a-2500-43b4-abc8-b881020a36b6', 1025, 'Reserved Instances', 'text', '<h2>Reserved Instances</h2><p>This lesson covers Reserved Instances in the context of Cost Optimization.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Reserved Instances</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 45, NULL, 0, '2025-12-24 17:07:15', '2025-12-24 17:07:15', 0, 0, 1, 30),
(4025, '4f4768fa-42df-46c0-8458-109177f9c76e', 1025, 'Spot Instances', 'text', '<h2>Spot Instances</h2><p>This lesson covers Spot Instances in the context of Cost Optimization.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Spot Instances</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 18, NULL, 0, '2025-12-24 17:07:15', '2025-12-24 17:07:15', 0, 0, 1, 30),
(4026, '3854a507-3453-4a4f-bd94-0f8aaef12a15', 1025, 'Right Sizing', 'text', '<h2>Right Sizing</h2><p>This lesson covers Right Sizing in the context of Cost Optimization.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Right Sizing</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 35, NULL, 0, '2025-12-24 17:07:15', '2025-12-24 17:07:15', 0, 0, 1, 30),
(4027, '1d67ddbb-1cac-477a-9e07-371276b867d8', 1026, 'Migration Strategies', 'text', '<h2>Migration Strategies</h2><p>This lesson covers Migration Strategies in the context of Cloud Migration.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Migration Strategies</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 31, NULL, 0, '2025-12-24 17:07:15', '2025-12-24 17:07:15', 0, 0, 1, 30),
(4028, '76447818-d541-4285-a5c8-8703024bb761', 1026, 'Assessment', 'text', '<h2>Assessment</h2><p>This lesson covers Assessment in the context of Cloud Migration.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Assessment</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 28, NULL, 0, '2025-12-24 17:07:16', '2025-12-24 17:07:16', 0, 0, 1, 30),
(4029, '80d641ff-cb52-4e2d-a075-d0f82049f22e', 1026, 'Planning', 'text', '<h2>Planning</h2><p>This lesson covers Planning in the context of Cloud Migration.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Planning</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 26, NULL, 0, '2025-12-24 17:07:16', '2025-12-24 17:07:16', 0, 0, 1, 30),
(4030, 'd84e2f97-833b-4efd-89ab-0b9d7a8d6e2b', 1026, 'Execution', 'text', '<h2>Execution</h2><p>This lesson covers Execution in the context of Cloud Migration.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Execution</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 38, NULL, 0, '2025-12-24 17:07:16', '2025-12-24 17:07:16', 0, 0, 1, 30),
(4031, 'c4101627-beb0-4180-bf1f-1d819922ea0d', 1027, 'Serverless Concepts', 'text', '<h2>Serverless Concepts</h2><p>This lesson covers Serverless Concepts in the context of Serverless Architecture.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Serverless Concepts</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 22, NULL, 0, '2025-12-24 17:07:17', '2025-12-24 17:07:17', 0, 0, 1, 30),
(4032, '32a9e20d-8f50-4db5-9ef3-9e05e4a023c2', 1027, 'Function Design', 'text', '<h2>Function Design</h2><p>This lesson covers Function Design in the context of Serverless Architecture.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Function Design</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 41, NULL, 0, '2025-12-24 17:07:17', '2025-12-24 17:07:17', 0, 0, 1, 30),
(4033, '2cb45ccd-7b84-4c2b-b1e8-b7706eca6f4d', 1027, 'Event-Driven', 'text', '<h2>Event-Driven</h2><p>This lesson covers Event-Driven in the context of Serverless Architecture.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Event-Driven</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 24, NULL, 0, '2025-12-24 17:07:17', '2025-12-24 17:07:17', 0, 0, 1, 30),
(4034, '84537a7f-fb86-493b-923e-32b9f7fbe4ba', 1027, 'Best Practices', 'text', '<h2>Best Practices</h2><p>This lesson covers Best Practices in the context of Serverless Architecture.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Best Practices</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 23, NULL, 0, '2025-12-24 17:07:17', '2025-12-24 17:07:17', 0, 0, 1, 30),
(4035, 'bc13b42f-24e4-46b2-8d0b-d1909f4a590b', 1028, 'Project Planning', 'text', '<h2>Project Planning</h2><p>This lesson covers Project Planning in the context of Cloud Capstone Project.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Project Planning</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 31, NULL, 0, '2025-12-24 17:07:18', '2025-12-24 17:07:18', 0, 0, 1, 30),
(4036, '99119626-40cd-405e-b260-1df2ae56111c', 1028, 'Architecture Design', 'text', '<h2>Architecture Design</h2><p>This lesson covers Architecture Design in the context of Cloud Capstone Project.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Architecture Design</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 31, NULL, 0, '2025-12-24 17:07:18', '2025-12-24 17:07:18', 0, 0, 1, 30),
(4037, '43b051ca-c37f-4c5a-83da-45dcc1bcc4b7', 1028, 'Implementation', 'text', '<h2>Implementation</h2><p>This lesson covers Implementation in the context of Cloud Capstone Project.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Implementation</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 16, NULL, 0, '2025-12-24 17:07:18', '2025-12-24 17:07:18', 0, 0, 1, 30),
(4038, '10e0389a-6133-4c36-8dad-dbfcfe327f6d', 1028, 'Documentation', 'text', '<h2>Documentation</h2><p>This lesson covers Documentation in the context of Cloud Capstone Project.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Documentation</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 30, NULL, 0, '2025-12-24 17:07:19', '2025-12-24 17:07:19', 0, 0, 1, 30),
(4039, '04b00f71-c753-4a05-82a8-82f559615488', 1029, 'What is Networking?', 'text', '<h2>What is Networking?</h2><p>This lesson covers What is Networking? in the context of Networking Fundamentals.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of What is Networking?</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 23, NULL, 0, '2025-12-24 17:07:19', '2025-12-24 17:07:19', 0, 0, 1, 30),
(4040, '206325f2-31e8-4ea0-9a07-1e0483c11651', 1029, 'Network Types', 'text', '<h2>Network Types</h2><p>This lesson covers Network Types in the context of Networking Fundamentals.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Network Types</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 42, NULL, 0, '2025-12-24 17:07:20', '2025-12-24 17:07:20', 0, 0, 1, 30),
(4041, 'e6b26af4-7880-4c2f-ac0d-6b23111d577c', 1029, 'Network Topologies', 'text', '<h2>Network Topologies</h2><p>This lesson covers Network Topologies in the context of Networking Fundamentals.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Network Topologies</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 42, NULL, 0, '2025-12-24 17:07:20', '2025-12-24 17:07:20', 0, 0, 1, 30),
(4042, '1f44c85a-ef36-4579-8a98-886be1d57ddf', 1029, 'Network Components', 'text', '<h2>Network Components</h2><p>This lesson covers Network Components in the context of Networking Fundamentals.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Network Components</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 35, NULL, 0, '2025-12-24 17:07:20', '2025-12-24 17:07:20', 0, 0, 1, 30),
(4043, 'b3738761-74f2-4df8-9aed-00db6cf87c41', 1030, 'OSI Layers', 'text', '<h2>OSI Layers</h2><p>This lesson covers OSI Layers in the context of OSI Model.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of OSI Layers</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 31, NULL, 0, '2025-12-24 17:07:20', '2025-12-24 17:07:20', 0, 0, 1, 30),
(4044, '57e90654-42fa-44c8-b1cb-a7f3c2b79c9e', 1030, 'Data Encapsulation', 'text', '<h2>Data Encapsulation</h2><p>This lesson covers Data Encapsulation in the context of OSI Model.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Data Encapsulation</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 36, NULL, 0, '2025-12-24 17:07:20', '2025-12-24 17:07:20', 0, 0, 1, 30),
(4045, '9469b102-ae0e-42ff-9800-2fc3ed1fd33c', 1030, 'Layer Functions', 'text', '<h2>Layer Functions</h2><p>This lesson covers Layer Functions in the context of OSI Model.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Layer Functions</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 27, NULL, 0, '2025-12-24 17:07:20', '2025-12-24 17:07:20', 0, 0, 1, 30),
(4046, 'e12c2c14-bfb7-4656-8427-e028c55e487e', 1030, 'Troubleshooting with OSI', 'text', '<h2>Troubleshooting with OSI</h2><p>This lesson covers Troubleshooting with OSI in the context of OSI Model.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Troubleshooting with OSI</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 16, NULL, 0, '2025-12-24 17:07:20', '2025-12-24 17:07:20', 0, 0, 1, 30),
(4047, '5cc1e720-1e0f-422f-8d32-093bcaf4e0ed', 1031, 'TCP/IP Model', 'text', '<h2>TCP/IP Model</h2><p>This lesson covers TCP/IP Model in the context of TCP/IP Protocol Suite.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of TCP/IP Model</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 41, NULL, 0, '2025-12-24 17:07:21', '2025-12-24 17:07:21', 0, 0, 1, 30),
(4048, '2dbef846-e0af-4c92-95ff-b94c07984300', 1031, 'TCP vs UDP', 'text', '<h2>TCP vs UDP</h2><p>This lesson covers TCP vs UDP in the context of TCP/IP Protocol Suite.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of TCP vs UDP</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 22, NULL, 0, '2025-12-24 17:07:21', '2025-12-24 17:07:21', 0, 0, 1, 30),
(4049, 'c57d9b9c-b782-4562-a07b-0df42f024f91', 1031, 'IP Protocol', 'text', '<h2>IP Protocol</h2><p>This lesson covers IP Protocol in the context of TCP/IP Protocol Suite.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of IP Protocol</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 19, NULL, 0, '2025-12-24 17:07:21', '2025-12-24 17:07:21', 0, 0, 1, 30),
(4050, '7a7633ce-ec07-447d-8c79-d8c28e6374c1', 1031, 'ICMP', 'text', '<h2>ICMP</h2><p>This lesson covers ICMP in the context of TCP/IP Protocol Suite.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of ICMP</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 33, NULL, 0, '2025-12-24 17:07:22', '2025-12-24 17:07:22', 0, 0, 1, 30),
(4051, '3a6f0609-e7e5-4911-b920-5423074b36fd', 1032, 'IPv4 Addressing', 'text', '<h2>IPv4 Addressing</h2><p>This lesson covers IPv4 Addressing in the context of IP Addressing.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of IPv4 Addressing</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 24, NULL, 0, '2025-12-24 17:07:22', '2025-12-24 17:07:22', 0, 0, 1, 30),
(4052, 'f110d948-558f-4fb3-aa52-1b293688b184', 1032, 'Address Classes', 'text', '<h2>Address Classes</h2><p>This lesson covers Address Classes in the context of IP Addressing.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Address Classes</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 39, NULL, 0, '2025-12-24 17:07:23', '2025-12-24 17:07:23', 0, 0, 1, 30),
(4053, 'e2a4c1ac-67df-49d6-8758-2c794a5f7aa7', 1032, 'Private vs Public', 'text', '<h2>Private vs Public</h2><p>This lesson covers Private vs Public in the context of IP Addressing.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Private vs Public</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 29, NULL, 0, '2025-12-24 17:07:23', '2025-12-24 17:07:23', 0, 0, 1, 30);
INSERT INTO `lessons` (`id`, `uuid`, `module_id`, `title`, `type`, `content`, `order_index`, `duration_minutes`, `resources`, `ai_generated`, `created_at`, `updated_at`, `has_practical`, `has_quiz`, `competency_weight`, `estimated_time_minutes`) VALUES
(4054, 'e8a6be37-839a-4344-b1e5-4560e8e48d86', 1032, 'CIDR Notation', 'text', '<h2>CIDR Notation</h2><p>This lesson covers CIDR Notation in the context of IP Addressing.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of CIDR Notation</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 31, NULL, 0, '2025-12-24 17:07:24', '2025-12-24 17:07:24', 0, 0, 1, 30),
(4055, 'c6d69284-bac3-49b5-8c3c-eff21dba7edb', 1033, 'Subnetting Concepts', 'text', '<h2>Subnetting Concepts</h2><p>This lesson covers Subnetting Concepts in the context of Subnetting.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Subnetting Concepts</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 43, NULL, 0, '2025-12-24 17:07:25', '2025-12-24 17:07:25', 0, 0, 1, 30),
(4056, 'c79c0b60-2a8e-4dd4-9c5f-d87efd04582c', 1033, 'Subnet Calculations', 'text', '<h2>Subnet Calculations</h2><p>This lesson covers Subnet Calculations in the context of Subnetting.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Subnet Calculations</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 34, NULL, 0, '2025-12-24 17:07:26', '2025-12-24 17:07:26', 0, 0, 1, 30),
(4057, '5eef2dd7-1201-492d-82e6-5b623ed301df', 1033, 'VLSM', 'text', '<h2>VLSM</h2><p>This lesson covers VLSM in the context of Subnetting.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of VLSM</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 32, NULL, 0, '2025-12-24 17:07:26', '2025-12-24 17:07:26', 0, 0, 1, 30),
(4058, '69338c17-ccdd-401b-9b47-b0aa7b6a3945', 1033, 'Subnetting Practice', 'text', '<h2>Subnetting Practice</h2><p>This lesson covers Subnetting Practice in the context of Subnetting.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Subnetting Practice</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 34, NULL, 0, '2025-12-24 17:07:26', '2025-12-24 17:07:26', 0, 0, 1, 30),
(4059, 'b802e0cb-cb84-4213-8c0e-b598de3aa941', 1034, 'IPv6 Addressing', 'text', '<h2>IPv6 Addressing</h2><p>This lesson covers IPv6 Addressing in the context of IPv6 Fundamentals.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of IPv6 Addressing</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 23, NULL, 0, '2025-12-24 17:07:27', '2025-12-24 17:07:27', 0, 0, 1, 30),
(4060, '9f8ddbb8-1ad8-43a4-a959-708462d8d508', 1034, 'IPv6 Header', 'text', '<h2>IPv6 Header</h2><p>This lesson covers IPv6 Header in the context of IPv6 Fundamentals.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of IPv6 Header</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 25, NULL, 0, '2025-12-24 17:07:27', '2025-12-24 17:07:27', 0, 0, 1, 30),
(4061, '031ac780-77c0-44c1-8f24-82fc1ea82a5e', 1034, 'IPv6 Configuration', 'text', '<h2>IPv6 Configuration</h2><p>This lesson covers IPv6 Configuration in the context of IPv6 Fundamentals.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of IPv6 Configuration</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 21, NULL, 0, '2025-12-24 17:07:27', '2025-12-24 17:07:27', 0, 0, 1, 30),
(4062, '94c9ac00-244f-4f79-b3ba-7341f9573de6', 1034, 'IPv4 to IPv6 Transition', 'text', '<h2>IPv4 to IPv6 Transition</h2><p>This lesson covers IPv4 to IPv6 Transition in the context of IPv6 Fundamentals.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of IPv4 to IPv6 Transition</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 21, NULL, 0, '2025-12-24 17:07:27', '2025-12-24 17:07:27', 0, 0, 1, 30),
(4063, '113a6d6b-fe73-4db6-8fb2-1a901369f29c', 1035, 'Hubs and Switches', 'text', '<h2>Hubs and Switches</h2><p>This lesson covers Hubs and Switches in the context of Network Devices.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Hubs and Switches</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 41, NULL, 0, '2025-12-24 17:07:28', '2025-12-24 17:07:28', 0, 0, 1, 30),
(4064, 'ffa45ff5-661d-4ea6-9289-30b80e9fb30f', 1035, 'Routers', 'text', '<h2>Routers</h2><p>This lesson covers Routers in the context of Network Devices.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Routers</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 40, NULL, 0, '2025-12-24 17:07:28', '2025-12-24 17:07:28', 0, 0, 1, 30),
(4065, '851c5c8d-ae9a-4b80-8a5e-acd254efc29f', 1035, 'Firewalls', 'text', '<h2>Firewalls</h2><p>This lesson covers Firewalls in the context of Network Devices.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Firewalls</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 45, NULL, 0, '2025-12-24 17:07:28', '2025-12-24 17:07:28', 0, 0, 1, 30),
(4066, '0d853a42-8455-4433-bbb8-4dba8731142b', 1035, 'Access Points', 'text', '<h2>Access Points</h2><p>This lesson covers Access Points in the context of Network Devices.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Access Points</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 34, NULL, 0, '2025-12-24 17:07:29', '2025-12-24 17:07:29', 0, 0, 1, 30),
(4067, 'f61b2651-c406-4b0b-9ca3-8e2d30da1b93', 1036, 'Switch Operation', 'text', '<h2>Switch Operation</h2><p>This lesson covers Switch Operation in the context of Switching and VLANs.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Switch Operation</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 44, NULL, 0, '2025-12-24 17:07:29', '2025-12-24 17:07:29', 0, 0, 1, 30),
(4068, '8e04ce8c-0421-46d1-b7df-82cae400d4c3', 1036, 'VLAN Concepts', 'text', '<h2>VLAN Concepts</h2><p>This lesson covers VLAN Concepts in the context of Switching and VLANs.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of VLAN Concepts</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 33, NULL, 0, '2025-12-24 17:07:29', '2025-12-24 17:07:29', 0, 0, 1, 30),
(4069, '280dd6f1-2c58-4eff-9874-d0f917962573', 1036, 'VLAN Configuration', 'text', '<h2>VLAN Configuration</h2><p>This lesson covers VLAN Configuration in the context of Switching and VLANs.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of VLAN Configuration</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 40, NULL, 0, '2025-12-24 17:07:29', '2025-12-24 17:07:29', 0, 0, 1, 30),
(4070, '643782a0-db80-4465-82ba-b779d09f1a23', 1036, 'Inter-VLAN Routing', 'text', '<h2>Inter-VLAN Routing</h2><p>This lesson covers Inter-VLAN Routing in the context of Switching and VLANs.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Inter-VLAN Routing</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 27, NULL, 0, '2025-12-24 17:07:29', '2025-12-24 17:07:29', 0, 0, 1, 30),
(4071, '36c79ab5-9adc-4692-a983-c6fe2552c933', 1037, 'Static Routing', 'text', '<h2>Static Routing</h2><p>This lesson covers Static Routing in the context of Routing Fundamentals.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Static Routing</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 37, NULL, 0, '2025-12-24 17:07:29', '2025-12-24 17:07:29', 0, 0, 1, 30),
(4072, '8531f5c3-313e-4e75-a23b-8986d9c81b6f', 1037, 'Dynamic Routing', 'text', '<h2>Dynamic Routing</h2><p>This lesson covers Dynamic Routing in the context of Routing Fundamentals.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Dynamic Routing</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 29, NULL, 0, '2025-12-24 17:07:29', '2025-12-24 17:07:29', 0, 0, 1, 30),
(4073, '186654d1-6f20-46ac-a58e-aed7703f3a72', 1037, 'Routing Protocols', 'text', '<h2>Routing Protocols</h2><p>This lesson covers Routing Protocols in the context of Routing Fundamentals.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Routing Protocols</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 39, NULL, 0, '2025-12-24 17:07:30', '2025-12-24 17:07:30', 0, 0, 1, 30),
(4074, 'bdae6afb-fe60-4c09-9f03-b833d0b32d13', 1037, 'Route Tables', 'text', '<h2>Route Tables</h2><p>This lesson covers Route Tables in the context of Routing Fundamentals.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Route Tables</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 41, NULL, 0, '2025-12-24 17:07:30', '2025-12-24 17:07:30', 0, 0, 1, 30),
(4075, '2439c176-c9f1-472b-a14c-48659ccdee44', 1038, 'DHCP', 'text', '<h2>DHCP</h2><p>This lesson covers DHCP in the context of Network Services.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of DHCP</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 26, NULL, 0, '2025-12-24 17:07:31', '2025-12-24 17:07:31', 0, 0, 1, 30),
(4076, '985b7743-55cf-47e1-9cd3-c3b013b6c24d', 1038, 'DNS', 'text', '<h2>DNS</h2><p>This lesson covers DNS in the context of Network Services.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of DNS</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 31, NULL, 0, '2025-12-24 17:07:31', '2025-12-24 17:07:31', 0, 0, 1, 30),
(4077, '6af1f744-102d-4994-b5a0-db833fd9e228', 1038, 'NAT/PAT', 'text', '<h2>NAT/PAT</h2><p>This lesson covers NAT/PAT in the context of Network Services.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of NAT/PAT</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 19, NULL, 0, '2025-12-24 17:07:31', '2025-12-24 17:07:31', 0, 0, 1, 30),
(4078, 'd1c2c557-5878-4e1e-8391-ea7a2f96a1d3', 1038, 'Network Troubleshooting', 'text', '<h2>Network Troubleshooting</h2><p>This lesson covers Network Troubleshooting in the context of Network Services.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Network Troubleshooting</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 27, NULL, 0, '2025-12-24 17:07:31', '2025-12-24 17:07:31', 0, 0, 1, 30),
(4079, '6412b06d-86ad-41c8-8c36-6a670f72f788', 1039, 'PC Components', 'text', '<h2>PC Components</h2><p>This lesson covers PC Components in the context of Computer Components Overview.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of PC Components</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 30, NULL, 0, '2025-12-24 17:07:32', '2025-12-24 17:07:32', 0, 0, 1, 30),
(4080, '31d69c15-2528-4b48-8ddf-371eaf4d212b', 1039, 'How Computers Work', 'text', '<h2>How Computers Work</h2><p>This lesson covers How Computers Work in the context of Computer Components Overview.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of How Computers Work</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 32, NULL, 0, '2025-12-24 17:07:32', '2025-12-24 17:07:32', 0, 0, 1, 30),
(4081, '30f66cc7-c4ba-4585-9956-1523e646f792', 1039, 'Form Factors', 'text', '<h2>Form Factors</h2><p>This lesson covers Form Factors in the context of Computer Components Overview.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Form Factors</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 23, NULL, 0, '2025-12-24 17:07:32', '2025-12-24 17:07:32', 0, 0, 1, 30),
(4082, '92b66e07-ca16-41b1-aeee-3aa1e37db000', 1039, 'Hardware vs Software', 'text', '<h2>Hardware vs Software</h2><p>This lesson covers Hardware vs Software in the context of Computer Components Overview.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Hardware vs Software</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 31, NULL, 0, '2025-12-24 17:07:32', '2025-12-24 17:07:32', 0, 0, 1, 30),
(4083, 'eed16698-8446-4fab-b401-020bbdb089a4', 1040, 'CPU Architecture', 'text', '<h2>CPU Architecture</h2><p>This lesson covers CPU Architecture in the context of Processors (CPUs).</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of CPU Architecture</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 25, NULL, 0, '2025-12-24 17:07:33', '2025-12-24 17:07:33', 0, 0, 1, 30),
(4084, 'fb0b0151-47d2-4be0-9232-2d2e821a5bf0', 1040, 'CPU Specifications', 'text', '<h2>CPU Specifications</h2><p>This lesson covers CPU Specifications in the context of Processors (CPUs).</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of CPU Specifications</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 35, NULL, 0, '2025-12-24 17:07:33', '2025-12-24 17:07:33', 0, 0, 1, 30),
(4085, '45b01f23-b3ab-4cd1-bc35-509c093c728e', 1040, 'Cores and Threads', 'text', '<h2>Cores and Threads</h2><p>This lesson covers Cores and Threads in the context of Processors (CPUs).</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Cores and Threads</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 21, NULL, 0, '2025-12-24 17:07:33', '2025-12-24 17:07:33', 0, 0, 1, 30),
(4086, 'b0abb543-40d8-4246-9a91-9e0c352ee619', 1040, 'Choosing a Processor', 'text', '<h2>Choosing a Processor</h2><p>This lesson covers Choosing a Processor in the context of Processors (CPUs).</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Choosing a Processor</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 34, NULL, 0, '2025-12-24 17:07:33', '2025-12-24 17:07:33', 0, 0, 1, 30),
(4087, '3941f036-a3da-4ccb-803b-9205660a0551', 1041, 'RAM Types', 'text', '<h2>RAM Types</h2><p>This lesson covers RAM Types in the context of Memory and Storage.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of RAM Types</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 44, NULL, 0, '2025-12-24 17:07:33', '2025-12-24 17:07:33', 0, 0, 1, 30),
(4088, '9683ced7-b494-4914-bd94-f233ad3a9f05', 1041, 'Memory Specifications', 'text', '<h2>Memory Specifications</h2><p>This lesson covers Memory Specifications in the context of Memory and Storage.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Memory Specifications</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 38, NULL, 0, '2025-12-24 17:07:34', '2025-12-24 17:07:34', 0, 0, 1, 30),
(4089, '027fa3be-c7f0-4ef4-a6e0-7c04d898d88b', 1041, 'Storage Types', 'text', '<h2>Storage Types</h2><p>This lesson covers Storage Types in the context of Memory and Storage.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Storage Types</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 32, NULL, 0, '2025-12-24 17:07:34', '2025-12-24 17:07:34', 0, 0, 1, 30),
(4090, 'd521348c-2afd-485e-b736-3913cb6f68f2', 1041, 'SSD vs HDD', 'text', '<h2>SSD vs HDD</h2><p>This lesson covers SSD vs HDD in the context of Memory and Storage.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of SSD vs HDD</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 33, NULL, 0, '2025-12-24 17:07:34', '2025-12-24 17:07:34', 0, 0, 1, 30),
(4091, '72197ace-c302-4c1e-8a16-320f1545f3fe', 1042, 'Motherboard Components', 'text', '<h2>Motherboard Components</h2><p>This lesson covers Motherboard Components in the context of Motherboards and BIOS.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Motherboard Components</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 28, NULL, 0, '2025-12-24 17:07:34', '2025-12-24 17:07:34', 0, 0, 1, 30),
(4092, '5e4d3856-f1ba-482a-8cd7-ca551eb8547c', 1042, 'Form Factors', 'text', '<h2>Form Factors</h2><p>This lesson covers Form Factors in the context of Motherboards and BIOS.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Form Factors</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 26, NULL, 0, '2025-12-24 17:07:34', '2025-12-24 17:07:34', 0, 0, 1, 30),
(4093, 'c3f1df4a-f775-4955-b212-79ee63847b5d', 1042, 'BIOS/UEFI', 'text', '<h2>BIOS/UEFI</h2><p>This lesson covers BIOS/UEFI in the context of Motherboards and BIOS.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of BIOS/UEFI</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 40, NULL, 0, '2025-12-24 17:07:35', '2025-12-24 17:07:35', 0, 0, 1, 30),
(4094, 'b854398a-9496-4750-9f08-f84419e6c859', 1042, 'Chipsets', 'text', '<h2>Chipsets</h2><p>This lesson covers Chipsets in the context of Motherboards and BIOS.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Chipsets</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 32, NULL, 0, '2025-12-24 17:07:35', '2025-12-24 17:07:35', 0, 0, 1, 30),
(4095, '69b2f712-2b15-4ec0-bf6a-2d71bfd0bac7', 1043, 'Component Selection', 'text', '<h2>Component Selection</h2><p>This lesson covers Component Selection in the context of PC Assembly.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Component Selection</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 29, NULL, 0, '2025-12-24 17:07:35', '2025-12-24 17:07:35', 0, 0, 1, 30),
(4096, '3731d4de-e16c-4613-94ea-d09c663ccef6', 1043, 'Assembly Process', 'text', '<h2>Assembly Process</h2><p>This lesson covers Assembly Process in the context of PC Assembly.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Assembly Process</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 43, NULL, 0, '2025-12-24 17:07:35', '2025-12-24 17:07:35', 0, 0, 1, 30),
(4097, '774506e4-d06f-4cb1-ae76-1fcd9ccbff01', 1043, 'Cable Management', 'text', '<h2>Cable Management</h2><p>This lesson covers Cable Management in the context of PC Assembly.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Cable Management</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 36, NULL, 0, '2025-12-24 17:07:36', '2025-12-24 17:07:36', 0, 0, 1, 30),
(4098, '989d3973-af20-4491-9f1a-46858f5550fd', 1043, 'First Boot', 'text', '<h2>First Boot</h2><p>This lesson covers First Boot in the context of PC Assembly.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of First Boot</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 25, NULL, 0, '2025-12-24 17:07:36', '2025-12-24 17:07:36', 0, 0, 1, 30),
(4099, '3393b111-d13a-42d8-aa45-e36e5e55e9ac', 1044, 'BIOS Configuration', 'text', '<h2>BIOS Configuration</h2><p>This lesson covers BIOS Configuration in the context of Operating System Installation.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of BIOS Configuration</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 31, NULL, 0, '2025-12-24 17:07:37', '2025-12-24 17:07:37', 0, 0, 1, 30),
(4100, 'f29e4c68-b279-4341-8170-a6d861bcf11a', 1044, 'OS Installation', 'text', '<h2>OS Installation</h2><p>This lesson covers OS Installation in the context of Operating System Installation.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of OS Installation</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 22, NULL, 0, '2025-12-24 17:07:37', '2025-12-24 17:07:37', 0, 0, 1, 30),
(4101, '1df62cf0-50bf-47c3-864f-1f5f7cd87131', 1044, 'Driver Installation', 'text', '<h2>Driver Installation</h2><p>This lesson covers Driver Installation in the context of Operating System Installation.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Driver Installation</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 37, NULL, 0, '2025-12-24 17:07:37', '2025-12-24 17:07:37', 0, 0, 1, 30),
(4102, 'c365edfc-f10f-4ad0-aa05-98847b1fe9fe', 1044, 'Initial Setup', 'text', '<h2>Initial Setup</h2><p>This lesson covers Initial Setup in the context of Operating System Installation.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Initial Setup</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 28, NULL, 0, '2025-12-24 17:07:37', '2025-12-24 17:07:37', 0, 0, 1, 30),
(4103, 'ef3a0822-3e90-420a-89d6-9ef45b216516', 1045, 'Troubleshooting Methodology', 'text', '<h2>Troubleshooting Methodology</h2><p>This lesson covers Troubleshooting Methodology in the context of Troubleshooting.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Troubleshooting Methodology</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 42, NULL, 0, '2025-12-24 17:07:37', '2025-12-24 17:07:37', 0, 0, 1, 30),
(4104, 'db20b56f-3cc1-436f-aa78-2c3b98a1a1c7', 1045, 'Boot Issues', 'text', '<h2>Boot Issues</h2><p>This lesson covers Boot Issues in the context of Troubleshooting.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Boot Issues</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 26, NULL, 0, '2025-12-24 17:07:37', '2025-12-24 17:07:37', 0, 0, 1, 30),
(4105, '0aae64cd-6087-4675-834c-06966284b6e9', 1045, 'Hardware Failures', 'text', '<h2>Hardware Failures</h2><p>This lesson covers Hardware Failures in the context of Troubleshooting.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Hardware Failures</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 35, NULL, 0, '2025-12-24 17:07:38', '2025-12-24 17:07:38', 0, 0, 1, 30),
(4106, '8244d811-c6e1-4db4-8f49-19aca13de5d2', 1045, 'Diagnostic Tools', 'text', '<h2>Diagnostic Tools</h2><p>This lesson covers Diagnostic Tools in the context of Troubleshooting.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Diagnostic Tools</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 42, NULL, 0, '2025-12-24 17:07:38', '2025-12-24 17:07:38', 0, 0, 1, 30),
(4107, '292c9b3a-b7cd-4b97-ad46-747f0fed616d', 1046, 'Preventive Maintenance', 'text', '<h2>Preventive Maintenance</h2><p>This lesson covers Preventive Maintenance in the context of Maintenance and Upgrades.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Preventive Maintenance</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 21, NULL, 0, '2025-12-24 17:07:39', '2025-12-24 17:07:39', 0, 0, 1, 30),
(4108, 'aeb24a73-0391-4af1-84f1-dc2fd2ce7255', 1046, 'Cleaning', 'text', '<h2>Cleaning</h2><p>This lesson covers Cleaning in the context of Maintenance and Upgrades.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Cleaning</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 39, NULL, 0, '2025-12-24 17:07:39', '2025-12-24 17:07:39', 0, 0, 1, 30),
(4109, 'ed9e31d7-dcdf-4512-9e46-d36863adaa52', 1046, 'Upgrading Components', 'text', '<h2>Upgrading Components</h2><p>This lesson covers Upgrading Components in the context of Maintenance and Upgrades.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Upgrading Components</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 21, NULL, 0, '2025-12-24 17:07:40', '2025-12-24 17:07:40', 0, 0, 1, 30),
(4110, '5094b4a0-2724-4788-9087-a68c2a74eda3', 1046, 'Performance Tuning', 'text', '<h2>Performance Tuning</h2><p>This lesson covers Performance Tuning in the context of Maintenance and Upgrades.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Performance Tuning</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 37, NULL, 0, '2025-12-24 17:07:40', '2025-12-24 17:07:40', 0, 0, 1, 30),
(4111, '8752f489-b622-43d7-a819-11469e4b04b5', 1047, 'What is a Computer?', 'text', '<h2>What is a Computer?</h2><p>This lesson covers What is a Computer? in the context of Computer Basics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of What is a Computer?</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 29, NULL, 0, '2025-12-24 17:07:41', '2025-12-24 17:07:41', 0, 0, 1, 30),
(4112, '8b9cc07c-6f47-42d0-b2b1-49e28e5fa67e', 1047, 'Desktop vs Laptop', 'text', '<h2>Desktop vs Laptop</h2><p>This lesson covers Desktop vs Laptop in the context of Computer Basics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Desktop vs Laptop</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 40, NULL, 0, '2025-12-24 17:07:41', '2025-12-24 17:07:41', 0, 0, 1, 30),
(4113, 'f18146aa-6e84-427c-8757-b6ade848b2ee', 1047, 'Operating Systems', 'text', '<h2>Operating Systems</h2><p>This lesson covers Operating Systems in the context of Computer Basics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Operating Systems</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 43, NULL, 0, '2025-12-24 17:07:42', '2025-12-24 17:07:42', 0, 0, 1, 30),
(4114, '45a95de3-1e99-4d33-b489-7c34efeedf7b', 1047, 'Basic Navigation', 'text', '<h2>Basic Navigation</h2><p>This lesson covers Basic Navigation in the context of Computer Basics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Basic Navigation</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 37, NULL, 0, '2025-12-24 17:07:42', '2025-12-24 17:07:42', 0, 0, 1, 30),
(4115, 'd8ddf7b5-909d-4478-8121-88c9fd58b49f', 1048, 'Keyboard Layout', 'text', '<h2>Keyboard Layout</h2><p>This lesson covers Keyboard Layout in the context of Keyboard and Mouse Skills.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Keyboard Layout</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 24, NULL, 0, '2025-12-24 17:07:43', '2025-12-24 17:07:43', 0, 0, 1, 30),
(4116, '6268617a-4a89-477d-9e03-7a0d95e46b1b', 1048, 'Typing Basics', 'text', '<h2>Typing Basics</h2><p>This lesson covers Typing Basics in the context of Keyboard and Mouse Skills.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Typing Basics</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 29, NULL, 0, '2025-12-24 17:07:44', '2025-12-24 17:07:44', 0, 0, 1, 30),
(4117, 'cc50eb44-2539-4fad-a4f3-ff43f94e3b34', 1048, 'Mouse Operations', 'text', '<h2>Mouse Operations</h2><p>This lesson covers Mouse Operations in the context of Keyboard and Mouse Skills.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Mouse Operations</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 17, NULL, 0, '2025-12-24 17:07:44', '2025-12-24 17:07:44', 0, 0, 1, 30),
(4118, 'baeb2218-251b-4e3d-9599-3ee58176fb94', 1048, 'Keyboard Shortcuts', 'text', '<h2>Keyboard Shortcuts</h2><p>This lesson covers Keyboard Shortcuts in the context of Keyboard and Mouse Skills.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Keyboard Shortcuts</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 41, NULL, 0, '2025-12-24 17:07:44', '2025-12-24 17:07:44', 0, 0, 1, 30),
(4119, '8682dc2d-9306-47d7-8716-d871667def95', 1049, 'Files and Folders', 'text', '<h2>Files and Folders</h2><p>This lesson covers Files and Folders in the context of File Management.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Files and Folders</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 41, NULL, 0, '2025-12-24 17:07:44', '2025-12-24 17:07:44', 0, 0, 1, 30),
(4120, 'ebcf1635-ca81-464f-8306-f634a0c0940f', 1049, 'Creating and Organizing', 'text', '<h2>Creating and Organizing</h2><p>This lesson covers Creating and Organizing in the context of File Management.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Creating and Organizing</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 32, NULL, 0, '2025-12-24 17:07:45', '2025-12-24 17:07:45', 0, 0, 1, 30),
(4121, '129ba86f-57b3-42f3-b639-8d2bbd60c87c', 1049, 'Copying and Moving', 'text', '<h2>Copying and Moving</h2><p>This lesson covers Copying and Moving in the context of File Management.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Copying and Moving</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 28, NULL, 0, '2025-12-24 17:07:45', '2025-12-24 17:07:45', 0, 0, 1, 30),
(4122, 'fa807079-934a-4656-8ffa-218361351152', 1049, 'File Types', 'text', '<h2>File Types</h2><p>This lesson covers File Types in the context of File Management.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of File Types</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 29, NULL, 0, '2025-12-24 17:07:45', '2025-12-24 17:07:45', 0, 0, 1, 30),
(4123, '663b5a98-2b0b-4474-b837-2d09ae5ebeb6', 1050, 'What is the Internet?', 'text', '<h2>What is the Internet?</h2><p>This lesson covers What is the Internet? in the context of Internet Basics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of What is the Internet?</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 39, NULL, 0, '2025-12-24 17:07:45', '2025-12-24 17:07:45', 0, 0, 1, 30),
(4124, '7bc3fb6e-4f76-4c11-b25f-b92be7264439', 1050, 'Web Browsers', 'text', '<h2>Web Browsers</h2><p>This lesson covers Web Browsers in the context of Internet Basics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Web Browsers</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 39, NULL, 0, '2025-12-24 17:07:45', '2025-12-24 17:07:45', 0, 0, 1, 30),
(4125, 'a3399c2b-8243-402c-a242-bc8db5919f19', 1050, 'Searching Online', 'text', '<h2>Searching Online</h2><p>This lesson covers Searching Online in the context of Internet Basics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Searching Online</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 15, NULL, 0, '2025-12-24 17:07:46', '2025-12-24 17:07:46', 0, 0, 1, 30),
(4126, 'd4718ee3-6610-4518-bd78-82ceceda91c0', 1050, 'Bookmarks', 'text', '<h2>Bookmarks</h2><p>This lesson covers Bookmarks in the context of Internet Basics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Bookmarks</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 30, NULL, 0, '2025-12-24 17:07:46', '2025-12-24 17:07:46', 0, 0, 1, 30),
(4127, '00eed3e8-4fd9-4d9a-a79a-d00eea960910', 1051, 'Email Basics', 'text', '<h2>Email Basics</h2><p>This lesson covers Email Basics in the context of Email Essentials.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Email Basics</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 35, NULL, 0, '2025-12-24 17:07:46', '2025-12-24 17:07:46', 0, 0, 1, 30),
(4128, '7b8b3771-24e1-469c-a2e2-ef9b24cef674', 1051, 'Composing Emails', 'text', '<h2>Composing Emails</h2><p>This lesson covers Composing Emails in the context of Email Essentials.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Composing Emails</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 32, NULL, 0, '2025-12-24 17:07:46', '2025-12-24 17:07:46', 0, 0, 1, 30),
(4129, '0876142c-3e91-499b-a449-3faac7b764a7', 1051, 'Attachments', 'text', '<h2>Attachments</h2><p>This lesson covers Attachments in the context of Email Essentials.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Attachments</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 33, NULL, 0, '2025-12-24 17:07:46', '2025-12-24 17:07:46', 0, 0, 1, 30),
(4130, '43e1240f-bde5-4c5e-90f3-dac02bdb9262', 1051, 'Email Etiquette', 'text', '<h2>Email Etiquette</h2><p>This lesson covers Email Etiquette in the context of Email Essentials.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Email Etiquette</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 35, NULL, 0, '2025-12-24 17:07:46', '2025-12-24 17:07:46', 0, 0, 1, 30),
(4131, '9d32d507-0596-4c24-bcfc-6336dd86b5e7', 1052, 'Password Security', 'text', '<h2>Password Security</h2><p>This lesson covers Password Security in the context of Online Safety.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Password Security</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 24, NULL, 0, '2025-12-24 17:07:47', '2025-12-24 17:07:47', 0, 0, 1, 30),
(4132, 'b57d4b9e-77a8-4c2a-a3cf-8784e1ed8089', 1052, 'Recognizing Scams', 'text', '<h2>Recognizing Scams</h2><p>This lesson covers Recognizing Scams in the context of Online Safety.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Recognizing Scams</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 33, NULL, 0, '2025-12-24 17:07:47', '2025-12-24 17:07:47', 0, 0, 1, 30),
(4133, '2c2a1cd8-3953-4517-ad14-8219d9b43203', 1052, 'Privacy Online', 'text', '<h2>Privacy Online</h2><p>This lesson covers Privacy Online in the context of Online Safety.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Privacy Online</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 28, NULL, 0, '2025-12-24 17:07:47', '2025-12-24 17:07:47', 0, 0, 1, 30),
(4134, '9f607f1a-06a6-4461-92de-cdd64e51b91d', 1052, 'Safe Browsing', 'text', '<h2>Safe Browsing</h2><p>This lesson covers Safe Browsing in the context of Online Safety.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Safe Browsing</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 20, NULL, 0, '2025-12-24 17:07:47', '2025-12-24 17:07:47', 0, 0, 1, 30),
(4135, '46096b15-04e4-4feb-99ae-d6f74de14e4d', 1053, 'Word Processing', 'text', '<h2>Word Processing</h2><p>This lesson covers Word Processing in the context of Productivity Basics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Word Processing</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 31, NULL, 0, '2025-12-24 17:07:48', '2025-12-24 17:07:48', 0, 0, 1, 30),
(4136, 'de80f2fc-d1cf-435e-b948-311aec21c78a', 1053, 'Spreadsheet Basics', 'text', '<h2>Spreadsheet Basics</h2><p>This lesson covers Spreadsheet Basics in the context of Productivity Basics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Spreadsheet Basics</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 35, NULL, 0, '2025-12-24 17:07:48', '2025-12-24 17:07:48', 0, 0, 1, 30),
(4137, 'bcee1a1a-8be8-4d18-8fc1-6e0cbb5339cc', 1053, 'Presentation Basics', 'text', '<h2>Presentation Basics</h2><p>This lesson covers Presentation Basics in the context of Productivity Basics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Presentation Basics</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 39, NULL, 0, '2025-12-24 17:07:48', '2025-12-24 17:07:48', 0, 0, 1, 30),
(4138, '2be00ab5-c7b4-468d-927d-16f2af22b261', 1053, 'Cloud Storage', 'text', '<h2>Cloud Storage</h2><p>This lesson covers Cloud Storage in the context of Productivity Basics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Cloud Storage</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 34, NULL, 0, '2025-12-24 17:07:48', '2025-12-24 17:07:48', 0, 0, 1, 30),
(4139, 'c321ac20-b321-4e38-9f7e-503849c0ea56', 1054, 'Video Calls', 'text', '<h2>Video Calls</h2><p>This lesson covers Video Calls in the context of Digital Communication.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Video Calls</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 25, NULL, 0, '2025-12-24 17:07:48', '2025-12-24 17:07:48', 0, 0, 1, 30),
(4140, 'ee9381e4-922f-42cc-ace4-81483beadbe1', 1054, 'Instant Messaging', 'text', '<h2>Instant Messaging</h2><p>This lesson covers Instant Messaging in the context of Digital Communication.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Instant Messaging</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 21, NULL, 0, '2025-12-24 17:07:48', '2025-12-24 17:07:48', 0, 0, 1, 30),
(4141, '9211f11a-aa56-457f-aaca-aa27c2737925', 1054, 'Social Media Basics', 'text', '<h2>Social Media Basics</h2><p>This lesson covers Social Media Basics in the context of Digital Communication.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Social Media Basics</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 35, NULL, 0, '2025-12-24 17:07:49', '2025-12-24 17:07:49', 0, 0, 1, 30),
(4142, '2de0da30-b779-4f84-97e6-32ab64d2d0d3', 1054, 'Online Collaboration', 'text', '<h2>Online Collaboration</h2><p>This lesson covers Online Collaboration in the context of Digital Communication.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Online Collaboration</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 21, NULL, 0, '2025-12-24 17:07:49', '2025-12-24 17:07:49', 0, 0, 1, 30),
(4143, '0f7e4ded-913b-4d56-abf4-d78f2bd07b0a', 1055, 'What is Graphic Design?', 'text', '<h2>What is Graphic Design?</h2><p>This lesson covers What is Graphic Design? in the context of Design Fundamentals.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of What is Graphic Design?</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 21, NULL, 0, '2025-12-24 17:07:49', '2025-12-24 17:07:49', 0, 0, 1, 30),
(4144, '37f37d89-1206-4f0b-8fff-44575d593d23', 1055, 'Design History', 'text', '<h2>Design History</h2><p>This lesson covers Design History in the context of Design Fundamentals.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Design History</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 20, NULL, 0, '2025-12-24 17:07:49', '2025-12-24 17:07:49', 0, 0, 1, 30),
(4145, 'bb955117-5e5e-4add-bf9d-87e94348a329', 1055, 'Design Process', 'text', '<h2>Design Process</h2><p>This lesson covers Design Process in the context of Design Fundamentals.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Design Process</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 25, NULL, 0, '2025-12-24 17:07:49', '2025-12-24 17:07:49', 0, 0, 1, 30),
(4146, 'a68e45e4-21c1-452f-818d-c11e5bc5911a', 1055, 'Design Thinking', 'text', '<h2>Design Thinking</h2><p>This lesson covers Design Thinking in the context of Design Fundamentals.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Design Thinking</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 17, NULL, 0, '2025-12-24 17:07:49', '2025-12-24 17:07:49', 0, 0, 1, 30),
(4147, '0a1c8382-001f-434a-b246-f62c587718b6', 1056, 'Line', 'text', '<h2>Line</h2><p>This lesson covers Line in the context of Elements of Design.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Line</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 31, NULL, 0, '2025-12-24 17:07:50', '2025-12-24 17:07:50', 0, 0, 1, 30),
(4148, '8a6eecd6-a1ad-470e-9135-cd699a10861c', 1056, 'Shape', 'text', '<h2>Shape</h2><p>This lesson covers Shape in the context of Elements of Design.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Shape</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 43, NULL, 0, '2025-12-24 17:07:50', '2025-12-24 17:07:50', 0, 0, 1, 30),
(4149, 'ce5f4298-4de5-4a5f-91d9-b433e23029c5', 1056, 'Color', 'text', '<h2>Color</h2><p>This lesson covers Color in the context of Elements of Design.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Color</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 42, NULL, 0, '2025-12-24 17:07:50', '2025-12-24 17:07:50', 0, 0, 1, 30),
(4150, '19faf775-6425-426d-866b-b8e42524518d', 1056, 'Texture and Space', 'text', '<h2>Texture and Space</h2><p>This lesson covers Texture and Space in the context of Elements of Design.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Texture and Space</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 37, NULL, 0, '2025-12-24 17:07:50', '2025-12-24 17:07:50', 0, 0, 1, 30),
(4151, '969c2a6d-aae1-419f-ae89-1cac820a8a00', 1057, 'Balance', 'text', '<h2>Balance</h2><p>This lesson covers Balance in the context of Principles of Design.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Balance</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 15, NULL, 0, '2025-12-24 17:07:50', '2025-12-24 17:07:50', 0, 0, 1, 30),
(4152, '020ddc2d-042e-42fa-9642-3e3863802907', 1057, 'Contrast', 'text', '<h2>Contrast</h2><p>This lesson covers Contrast in the context of Principles of Design.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Contrast</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 37, NULL, 0, '2025-12-24 17:07:50', '2025-12-24 17:07:50', 0, 0, 1, 30),
(4153, '747a96e8-8c5b-44f7-a080-441b61c4ec81', 1057, 'Emphasis', 'text', '<h2>Emphasis</h2><p>This lesson covers Emphasis in the context of Principles of Design.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Emphasis</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 25, NULL, 0, '2025-12-24 17:07:52', '2025-12-24 17:07:52', 0, 0, 1, 30),
(4154, 'd73cfd6c-07c6-4777-9f33-dc3a3851480e', 1057, 'Unity and Harmony', 'text', '<h2>Unity and Harmony</h2><p>This lesson covers Unity and Harmony in the context of Principles of Design.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Unity and Harmony</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 37, NULL, 0, '2025-12-24 17:07:53', '2025-12-24 17:07:53', 0, 0, 1, 30),
(4155, '66bd1c1d-e3d4-4f45-a983-2ad659bca5bb', 1058, 'Color Wheel', 'text', '<h2>Color Wheel</h2><p>This lesson covers Color Wheel in the context of Color Theory.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Color Wheel</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 29, NULL, 0, '2025-12-24 17:07:53', '2025-12-24 17:07:53', 0, 0, 1, 30),
(4156, '038a3b10-d269-4343-ab15-f8efc2363e62', 1058, 'Color Harmonies', 'text', '<h2>Color Harmonies</h2><p>This lesson covers Color Harmonies in the context of Color Theory.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Color Harmonies</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 22, NULL, 0, '2025-12-24 17:07:53', '2025-12-24 17:07:53', 0, 0, 1, 30),
(4157, '12785675-936b-4705-b361-d7fab20e7b89', 1058, 'Color Psychology', 'text', '<h2>Color Psychology</h2><p>This lesson covers Color Psychology in the context of Color Theory.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Color Psychology</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 44, NULL, 0, '2025-12-24 17:07:54', '2025-12-24 17:07:54', 0, 0, 1, 30),
(4158, '91441b5c-0865-474c-9c64-62b66a2ef1fd', 1058, 'Color in Design', 'text', '<h2>Color in Design</h2><p>This lesson covers Color in Design in the context of Color Theory.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Color in Design</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 22, NULL, 0, '2025-12-24 17:07:54', '2025-12-24 17:07:54', 0, 0, 1, 30),
(4159, '3b652f97-4daa-4ded-886d-461c7075c70f', 1059, 'Typography Basics', 'text', '<h2>Typography Basics</h2><p>This lesson covers Typography Basics in the context of Typography.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Typography Basics</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 28, NULL, 0, '2025-12-24 17:07:54', '2025-12-24 17:07:54', 0, 0, 1, 30),
(4160, 'a33f382f-788d-49c9-9b60-29eb15448cee', 1059, 'Font Selection', 'text', '<h2>Font Selection</h2><p>This lesson covers Font Selection in the context of Typography.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Font Selection</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 30, NULL, 0, '2025-12-24 17:07:54', '2025-12-24 17:07:54', 0, 0, 1, 30),
(4161, '214c5aeb-796e-4d21-8934-10876e00667a', 1059, 'Type Hierarchy', 'text', '<h2>Type Hierarchy</h2><p>This lesson covers Type Hierarchy in the context of Typography.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Type Hierarchy</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 23, NULL, 0, '2025-12-24 17:07:54', '2025-12-24 17:07:54', 0, 0, 1, 30),
(4162, 'fc1b3816-20b8-4166-b645-d7937d8aa24a', 1059, 'Typography in Design', 'text', '<h2>Typography in Design</h2><p>This lesson covers Typography in Design in the context of Typography.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Typography in Design</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 40, NULL, 0, '2025-12-24 17:07:54', '2025-12-24 17:07:54', 0, 0, 1, 30),
(4163, 'd2eff991-978b-42e7-8314-6de439620390', 1060, 'Photoshop Interface', 'text', '<h2>Photoshop Interface</h2><p>This lesson covers Photoshop Interface in the context of Adobe Photoshop Basics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Photoshop Interface</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 17, NULL, 0, '2025-12-24 17:07:55', '2025-12-24 17:07:55', 0, 0, 1, 30),
(4164, '8571e977-3cc4-4814-8b39-cfdeca4acecb', 1060, 'Tools Overview', 'text', '<h2>Tools Overview</h2><p>This lesson covers Tools Overview in the context of Adobe Photoshop Basics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Tools Overview</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 38, NULL, 0, '2025-12-24 17:07:55', '2025-12-24 17:07:55', 0, 0, 1, 30),
(4165, '66562a3e-6bee-49b2-8349-ebc967ca0aa4', 1060, 'Layers', 'text', '<h2>Layers</h2><p>This lesson covers Layers in the context of Adobe Photoshop Basics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Layers</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 27, NULL, 0, '2025-12-24 17:07:55', '2025-12-24 17:07:55', 0, 0, 1, 30),
(4166, '49a4e554-a3f4-4a7f-96db-d80538d36197', 1060, 'Selection Tools', 'text', '<h2>Selection Tools</h2><p>This lesson covers Selection Tools in the context of Adobe Photoshop Basics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Selection Tools</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 42, NULL, 0, '2025-12-24 17:07:55', '2025-12-24 17:07:55', 0, 0, 1, 30),
(4167, 'f5e04eb5-29e0-4488-bb8a-a08f68bb5edf', 1061, 'Masks and Blending', 'text', '<h2>Masks and Blending</h2><p>This lesson covers Masks and Blending in the context of Photoshop Advanced.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Masks and Blending</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 23, NULL, 0, '2025-12-24 17:07:55', '2025-12-24 17:07:55', 0, 0, 1, 30),
(4168, '6b6ed55b-8f9d-4a9c-a326-4fe2eed1fbcc', 1061, 'Photo Retouching', 'text', '<h2>Photo Retouching</h2><p>This lesson covers Photo Retouching in the context of Photoshop Advanced.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Photo Retouching</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 40, NULL, 0, '2025-12-24 17:07:55', '2025-12-24 17:07:55', 0, 0, 1, 30);
INSERT INTO `lessons` (`id`, `uuid`, `module_id`, `title`, `type`, `content`, `order_index`, `duration_minutes`, `resources`, `ai_generated`, `created_at`, `updated_at`, `has_practical`, `has_quiz`, `competency_weight`, `estimated_time_minutes`) VALUES
(4169, 'a0a8da7d-158d-48c6-ae12-790783c51544', 1061, 'Compositing', 'text', '<h2>Compositing</h2><p>This lesson covers Compositing in the context of Photoshop Advanced.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Compositing</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 31, NULL, 0, '2025-12-24 17:07:56', '2025-12-24 17:07:56', 0, 0, 1, 30),
(4170, '2d5a937f-24bb-402e-bead-e8db9562f904', 1061, 'Effects and Filters', 'text', '<h2>Effects and Filters</h2><p>This lesson covers Effects and Filters in the context of Photoshop Advanced.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Effects and Filters</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 36, NULL, 0, '2025-12-24 17:07:56', '2025-12-24 17:07:56', 0, 0, 1, 30),
(4171, '81249a08-48ad-4af4-99f2-c6d6ec9d851c', 1062, 'Illustrator Interface', 'text', '<h2>Illustrator Interface</h2><p>This lesson covers Illustrator Interface in the context of Adobe Illustrator Basics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Illustrator Interface</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 34, NULL, 0, '2025-12-24 17:07:56', '2025-12-24 17:07:56', 0, 0, 1, 30),
(4172, '9b7d5eb0-15bb-4107-8206-94c44a785717', 1062, 'Vector Basics', 'text', '<h2>Vector Basics</h2><p>This lesson covers Vector Basics in the context of Adobe Illustrator Basics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Vector Basics</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 20, NULL, 0, '2025-12-24 17:07:56', '2025-12-24 17:07:56', 0, 0, 1, 30),
(4173, 'ae47a199-aadc-4578-966f-9de0e4ccd726', 1062, 'Drawing Tools', 'text', '<h2>Drawing Tools</h2><p>This lesson covers Drawing Tools in the context of Adobe Illustrator Basics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Drawing Tools</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 28, NULL, 0, '2025-12-24 17:07:56', '2025-12-24 17:07:56', 0, 0, 1, 30),
(4174, '317d93ec-da93-4deb-b854-7696f0db22de', 1062, 'Paths and Shapes', 'text', '<h2>Paths and Shapes</h2><p>This lesson covers Paths and Shapes in the context of Adobe Illustrator Basics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Paths and Shapes</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 33, NULL, 0, '2025-12-24 17:07:56', '2025-12-24 17:07:56', 0, 0, 1, 30),
(4175, '78c4a0fa-f6d8-4e5c-92d7-99b8913c21b3', 1063, 'Pen Tool Mastery', 'text', '<h2>Pen Tool Mastery</h2><p>This lesson covers Pen Tool Mastery in the context of Illustrator Advanced.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Pen Tool Mastery</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 17, NULL, 0, '2025-12-24 17:07:57', '2025-12-24 17:07:57', 0, 0, 1, 30),
(4176, '160a6d6b-e749-4a70-ba80-02896728bc69', 1063, 'Logo Design', 'text', '<h2>Logo Design</h2><p>This lesson covers Logo Design in the context of Illustrator Advanced.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Logo Design</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 26, NULL, 0, '2025-12-24 17:07:57', '2025-12-24 17:07:57', 0, 0, 1, 30),
(4177, '91f3ec94-c8eb-4744-874a-a5f3bb0185ee', 1063, 'Illustration Techniques', 'text', '<h2>Illustration Techniques</h2><p>This lesson covers Illustration Techniques in the context of Illustrator Advanced.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Illustration Techniques</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 22, NULL, 0, '2025-12-24 17:07:57', '2025-12-24 17:07:57', 0, 0, 1, 30),
(4178, '05617fd5-179a-46a0-ab7f-0761b03a0dd3', 1063, 'Print Preparation', 'text', '<h2>Print Preparation</h2><p>This lesson covers Print Preparation in the context of Illustrator Advanced.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Print Preparation</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 38, NULL, 0, '2025-12-24 17:07:57', '2025-12-24 17:07:57', 0, 0, 1, 30),
(4179, '2fd6d444-e4fb-4c64-a164-2a9ab2505a2a', 1064, 'Brand Strategy', 'text', '<h2>Brand Strategy</h2><p>This lesson covers Brand Strategy in the context of Brand Identity Design.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Brand Strategy</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 32, NULL, 0, '2025-12-24 17:07:57', '2025-12-24 17:07:57', 0, 0, 1, 30),
(4180, '050e5eae-6353-4a66-b7ee-71a4afcecb70', 1064, 'Logo Design Process', 'text', '<h2>Logo Design Process</h2><p>This lesson covers Logo Design Process in the context of Brand Identity Design.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Logo Design Process</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 25, NULL, 0, '2025-12-24 17:07:58', '2025-12-24 17:07:58', 0, 0, 1, 30),
(4181, 'f12d50f7-ea8e-4a29-9e67-3e1d0a1783f6', 1064, 'Visual Identity', 'text', '<h2>Visual Identity</h2><p>This lesson covers Visual Identity in the context of Brand Identity Design.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Visual Identity</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 30, NULL, 0, '2025-12-24 17:07:58', '2025-12-24 17:07:58', 0, 0, 1, 30),
(4182, '5f131099-5b72-4a89-99df-6bb4a3af59fd', 1064, 'Brand Guidelines', 'text', '<h2>Brand Guidelines</h2><p>This lesson covers Brand Guidelines in the context of Brand Identity Design.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Brand Guidelines</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 23, NULL, 0, '2025-12-24 17:07:58', '2025-12-24 17:07:58', 0, 0, 1, 30),
(4183, '303a957b-989e-40db-b85e-62dcb0cbc2d7', 1065, 'Social Media Graphics', 'text', '<h2>Social Media Graphics</h2><p>This lesson covers Social Media Graphics in the context of Digital Design Projects.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Social Media Graphics</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 44, NULL, 0, '2025-12-24 17:07:58', '2025-12-24 17:07:58', 0, 0, 1, 30),
(4184, 'ecf7ad79-c6bf-44df-bad9-1add594a27e0', 1065, 'Web Graphics', 'text', '<h2>Web Graphics</h2><p>This lesson covers Web Graphics in the context of Digital Design Projects.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Web Graphics</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 38, NULL, 0, '2025-12-24 17:07:58', '2025-12-24 17:07:58', 0, 0, 1, 30),
(4185, '641ecc90-eec8-4617-a7a2-dca7445a1013', 1065, 'Print Design', 'text', '<h2>Print Design</h2><p>This lesson covers Print Design in the context of Digital Design Projects.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Print Design</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 33, NULL, 0, '2025-12-24 17:07:58', '2025-12-24 17:07:58', 0, 0, 1, 30),
(4186, '5bcf3dfb-18cd-4281-ba43-0ab1dfbb5d46', 1065, 'Portfolio Building', 'text', '<h2>Portfolio Building</h2><p>This lesson covers Portfolio Building in the context of Digital Design Projects.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Portfolio Building</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 17, NULL, 0, '2025-12-24 17:07:58', '2025-12-24 17:07:58', 0, 0, 1, 30),
(4187, '6c717acc-36f7-4942-8e82-513dce837014', 1066, 'Video Production Process', 'text', '<h2>Video Production Process</h2><p>This lesson covers Video Production Process in the context of Video Production Overview.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Video Production Process</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 15, NULL, 0, '2025-12-24 17:07:58', '2025-12-24 17:07:58', 0, 0, 1, 30),
(4188, '328d9144-a88a-45f4-b986-c53a8c4668d3', 1066, 'Pre-Production', 'text', '<h2>Pre-Production</h2><p>This lesson covers Pre-Production in the context of Video Production Overview.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Pre-Production</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 41, NULL, 0, '2025-12-24 17:07:58', '2025-12-24 17:07:58', 0, 0, 1, 30),
(4189, '2ce11d76-f558-4235-9380-1261a8c749bd', 1066, 'Production', 'text', '<h2>Production</h2><p>This lesson covers Production in the context of Video Production Overview.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Production</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 44, NULL, 0, '2025-12-24 17:07:59', '2025-12-24 17:07:59', 0, 0, 1, 30),
(4190, '8d510e77-f9f7-4578-aa49-ea1b857508ef', 1066, 'Post-Production', 'text', '<h2>Post-Production</h2><p>This lesson covers Post-Production in the context of Video Production Overview.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Post-Production</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 44, NULL, 0, '2025-12-24 17:07:59', '2025-12-24 17:07:59', 0, 0, 1, 30),
(4191, '655fc9c7-1173-495b-8846-201947ed4524', 1067, 'Camera Types', 'text', '<h2>Camera Types</h2><p>This lesson covers Camera Types in the context of Camera Basics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Camera Types</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 28, NULL, 0, '2025-12-24 17:07:59', '2025-12-24 17:07:59', 0, 0, 1, 30),
(4192, 'f8911c28-a9ab-4e05-92cd-1f646a366b92', 1067, 'Camera Settings', 'text', '<h2>Camera Settings</h2><p>This lesson covers Camera Settings in the context of Camera Basics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Camera Settings</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 37, NULL, 0, '2025-12-24 17:07:59', '2025-12-24 17:07:59', 0, 0, 1, 30),
(4193, 'c74d7e1e-ec3b-4a52-a94b-bfaf83cf0e70', 1067, 'Composition', 'text', '<h2>Composition</h2><p>This lesson covers Composition in the context of Camera Basics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Composition</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 22, NULL, 0, '2025-12-24 17:07:59', '2025-12-24 17:07:59', 0, 0, 1, 30),
(4194, '6b1429a5-20c8-4054-b018-d9caabdd69e9', 1067, 'Lighting Basics', 'text', '<h2>Lighting Basics</h2><p>This lesson covers Lighting Basics in the context of Camera Basics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Lighting Basics</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 22, NULL, 0, '2025-12-24 17:07:59', '2025-12-24 17:07:59', 0, 0, 1, 30),
(4195, '10f80b6c-e0ce-42df-9200-2df46f06eecc', 1068, 'Audio Basics', 'text', '<h2>Audio Basics</h2><p>This lesson covers Audio Basics in the context of Audio for Video.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Audio Basics</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 38, NULL, 0, '2025-12-24 17:07:59', '2025-12-24 17:07:59', 0, 0, 1, 30),
(4196, '885f5233-3168-4631-9dd9-8d666eebf0e3', 1068, 'Microphone Types', 'text', '<h2>Microphone Types</h2><p>This lesson covers Microphone Types in the context of Audio for Video.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Microphone Types</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 35, NULL, 0, '2025-12-24 17:07:59', '2025-12-24 17:07:59', 0, 0, 1, 30),
(4197, '4982da94-b0db-494c-a3b7-5d81895da985', 1068, 'Recording Audio', 'text', '<h2>Recording Audio</h2><p>This lesson covers Recording Audio in the context of Audio for Video.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Recording Audio</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 34, NULL, 0, '2025-12-24 17:07:59', '2025-12-24 17:07:59', 0, 0, 1, 30),
(4198, '8716d420-6931-4472-b4be-800f507511bc', 1068, 'Audio Quality', 'text', '<h2>Audio Quality</h2><p>This lesson covers Audio Quality in the context of Audio for Video.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Audio Quality</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 38, NULL, 0, '2025-12-24 17:08:01', '2025-12-24 17:08:01', 0, 0, 1, 30),
(4199, 'da170d28-6d07-49a9-a0b4-5aae430703e1', 1069, 'Interface Tour', 'text', '<h2>Interface Tour</h2><p>This lesson covers Interface Tour in the context of Premiere Pro Basics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Interface Tour</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 19, NULL, 0, '2025-12-24 17:08:02', '2025-12-24 17:08:02', 0, 0, 1, 30),
(4200, '7756215b-399e-4509-854d-e79b8fdfab76', 1069, 'Project Setup', 'text', '<h2>Project Setup</h2><p>This lesson covers Project Setup in the context of Premiere Pro Basics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Project Setup</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 17, NULL, 0, '2025-12-24 17:08:02', '2025-12-24 17:08:02', 0, 0, 1, 30),
(4201, 'b34305b2-cf30-4b3d-85f1-9c78c533bd0d', 1069, 'Importing Media', 'text', '<h2>Importing Media</h2><p>This lesson covers Importing Media in the context of Premiere Pro Basics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Importing Media</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 18, NULL, 0, '2025-12-24 17:08:03', '2025-12-24 17:08:03', 0, 0, 1, 30),
(4202, 'b2ee41db-0e2e-4081-804d-d778cf11cb93', 1069, 'Timeline Basics', 'text', '<h2>Timeline Basics</h2><p>This lesson covers Timeline Basics in the context of Premiere Pro Basics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Timeline Basics</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 36, NULL, 0, '2025-12-24 17:08:03', '2025-12-24 17:08:03', 0, 0, 1, 30),
(4203, '8011e522-9f64-48cc-9c9b-2c986f35f998', 1070, 'Cutting and Trimming', 'text', '<h2>Cutting and Trimming</h2><p>This lesson covers Cutting and Trimming in the context of Basic Video Editing.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Cutting and Trimming</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 31, NULL, 0, '2025-12-24 17:08:03', '2025-12-24 17:08:03', 0, 0, 1, 30),
(4204, 'e399af35-24c9-42d7-bd2f-9735fb5236a2', 1070, 'Arranging Clips', 'text', '<h2>Arranging Clips</h2><p>This lesson covers Arranging Clips in the context of Basic Video Editing.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Arranging Clips</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 36, NULL, 0, '2025-12-24 17:08:04', '2025-12-24 17:08:04', 0, 0, 1, 30),
(4205, 'e06cd89c-5e8c-4a73-b8fa-779b526415cf', 1070, 'Transitions', 'text', '<h2>Transitions</h2><p>This lesson covers Transitions in the context of Basic Video Editing.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Transitions</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 24, NULL, 0, '2025-12-24 17:08:04', '2025-12-24 17:08:04', 0, 0, 1, 30),
(4206, '2a44b814-d7dc-4ddc-8e6a-8472243d40a3', 1070, 'Basic Effects', 'text', '<h2>Basic Effects</h2><p>This lesson covers Basic Effects in the context of Basic Video Editing.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Basic Effects</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 31, NULL, 0, '2025-12-24 17:08:04', '2025-12-24 17:08:04', 0, 0, 1, 30),
(4207, '6db8dd11-3592-4f83-8284-332f80b38da2', 1071, 'Audio in Premiere', 'text', '<h2>Audio in Premiere</h2><p>This lesson covers Audio in Premiere in the context of Audio Editing.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Audio in Premiere</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 32, NULL, 0, '2025-12-24 17:08:05', '2025-12-24 17:08:05', 0, 0, 1, 30),
(4208, '7b1adfd9-1097-4d49-8b4b-a49d770f6e11', 1071, 'Levels and Mixing', 'text', '<h2>Levels and Mixing</h2><p>This lesson covers Levels and Mixing in the context of Audio Editing.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Levels and Mixing</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 29, NULL, 0, '2025-12-24 17:08:05', '2025-12-24 17:08:05', 0, 0, 1, 30),
(4209, '1b1444e0-b07e-41e7-8dcd-b99bea8c86b7', 1071, 'Music and Sound Effects', 'text', '<h2>Music and Sound Effects</h2><p>This lesson covers Music and Sound Effects in the context of Audio Editing.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Music and Sound Effects</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 33, NULL, 0, '2025-12-24 17:08:06', '2025-12-24 17:08:06', 0, 0, 1, 30),
(4210, 'f22d33f3-52d2-4389-8e4e-4a0dc460dbf0', 1071, 'Audio Effects', 'text', '<h2>Audio Effects</h2><p>This lesson covers Audio Effects in the context of Audio Editing.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Audio Effects</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 25, NULL, 0, '2025-12-24 17:08:07', '2025-12-24 17:08:07', 0, 0, 1, 30),
(4211, 'b00f0ec3-dfbc-485c-b63a-582c11337fbc', 1072, 'Color Theory for Video', 'text', '<h2>Color Theory for Video</h2><p>This lesson covers Color Theory for Video in the context of Color Correction.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Color Theory for Video</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 43, NULL, 0, '2025-12-24 17:08:07', '2025-12-24 17:08:07', 0, 0, 1, 30),
(4212, 'c5a08f1f-280a-4c32-8d1a-41b7b398d1bc', 1072, 'Lumetri Color', 'text', '<h2>Lumetri Color</h2><p>This lesson covers Lumetri Color in the context of Color Correction.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Lumetri Color</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 28, NULL, 0, '2025-12-24 17:08:08', '2025-12-24 17:08:08', 0, 0, 1, 30),
(4213, 'c2aad063-42b6-4ce0-a85f-6c0145831099', 1072, 'Color Correction', 'text', '<h2>Color Correction</h2><p>This lesson covers Color Correction in the context of Color Correction.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Color Correction</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 37, NULL, 0, '2025-12-24 17:08:08', '2025-12-24 17:08:08', 0, 0, 1, 30),
(4214, 'a7fdf662-2399-4b55-a369-cac06351dbcc', 1072, 'Color Grading', 'text', '<h2>Color Grading</h2><p>This lesson covers Color Grading in the context of Color Correction.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Color Grading</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 25, NULL, 0, '2025-12-24 17:08:09', '2025-12-24 17:08:09', 0, 0, 1, 30),
(4215, '02688ce9-5ba1-49e5-ac6c-bb11e1eb3d3f', 1073, 'After Effects Interface', 'text', '<h2>After Effects Interface</h2><p>This lesson covers After Effects Interface in the context of After Effects Introduction.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of After Effects Interface</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 29, NULL, 0, '2025-12-24 17:08:10', '2025-12-24 17:08:10', 0, 0, 1, 30),
(4216, '4ed0e0e9-e48c-48e1-be7f-c6de46090eec', 1073, 'Compositions', 'text', '<h2>Compositions</h2><p>This lesson covers Compositions in the context of After Effects Introduction.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Compositions</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 33, NULL, 0, '2025-12-24 17:08:11', '2025-12-24 17:08:11', 0, 0, 1, 30),
(4217, '07901f20-0db8-4bd6-aa3d-d4935bfd0b77', 1073, 'Keyframes', 'text', '<h2>Keyframes</h2><p>This lesson covers Keyframes in the context of After Effects Introduction.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Keyframes</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 43, NULL, 0, '2025-12-24 17:08:11', '2025-12-24 17:08:11', 0, 0, 1, 30),
(4218, '5215ec61-2982-4023-85ae-a0d5650d5f7e', 1073, 'Basic Animation', 'text', '<h2>Basic Animation</h2><p>This lesson covers Basic Animation in the context of After Effects Introduction.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Basic Animation</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 42, NULL, 0, '2025-12-24 17:08:12', '2025-12-24 17:08:12', 0, 0, 1, 30),
(4219, '21f9815e-52a7-48bb-8513-c7cebdd21005', 1074, 'Text Animation', 'text', '<h2>Text Animation</h2><p>This lesson covers Text Animation in the context of Motion Graphics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Text Animation</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 15, NULL, 0, '2025-12-24 17:08:13', '2025-12-24 17:08:13', 0, 0, 1, 30),
(4220, '1c8c6146-f9d3-4857-a9a5-33304509c7f4', 1074, 'Shape Animation', 'text', '<h2>Shape Animation</h2><p>This lesson covers Shape Animation in the context of Motion Graphics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Shape Animation</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 15, NULL, 0, '2025-12-24 17:08:13', '2025-12-24 17:08:13', 0, 0, 1, 30),
(4221, '6bb67d2f-44a1-4404-86f6-3cb9ba98d4de', 1074, 'Lower Thirds', 'text', '<h2>Lower Thirds</h2><p>This lesson covers Lower Thirds in the context of Motion Graphics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Lower Thirds</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 34, NULL, 0, '2025-12-24 17:08:14', '2025-12-24 17:08:14', 0, 0, 1, 30),
(4222, '3c1b0c8a-a1b8-4603-9fc2-4872355da8dd', 1074, 'Titles and Credits', 'text', '<h2>Titles and Credits</h2><p>This lesson covers Titles and Credits in the context of Motion Graphics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Titles and Credits</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 34, NULL, 0, '2025-12-24 17:08:14', '2025-12-24 17:08:14', 0, 0, 1, 30),
(4223, '4886fdc7-57d4-46bb-a26c-9e70468d2ac1', 1075, 'Export Settings', 'text', '<h2>Export Settings</h2><p>This lesson covers Export Settings in the context of Export and Delivery.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Export Settings</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 23, NULL, 0, '2025-12-24 17:08:15', '2025-12-24 17:08:15', 0, 0, 1, 30),
(4224, '6796fac8-0024-4d44-9eed-5c11d900d946', 1075, 'Formats and Codecs', 'text', '<h2>Formats and Codecs</h2><p>This lesson covers Formats and Codecs in the context of Export and Delivery.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Formats and Codecs</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 34, NULL, 0, '2025-12-24 17:08:15', '2025-12-24 17:08:15', 0, 0, 1, 30),
(4225, 'eb3e1acd-506e-42fe-a310-608243e6cd4d', 1075, 'Platform Requirements', 'text', '<h2>Platform Requirements</h2><p>This lesson covers Platform Requirements in the context of Export and Delivery.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Platform Requirements</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 20, NULL, 0, '2025-12-24 17:08:15', '2025-12-24 17:08:15', 0, 0, 1, 30),
(4226, 'e73a74d4-c2f8-46d8-a713-812d75295a3c', 1075, 'Publishing', 'text', '<h2>Publishing</h2><p>This lesson covers Publishing in the context of Export and Delivery.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Publishing</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 29, NULL, 0, '2025-12-24 17:08:16', '2025-12-24 17:08:16', 0, 0, 1, 30),
(4227, '1365abc9-0b0f-477f-9275-ebe7e91d5ff5', 1076, 'Office Applications', 'text', '<h2>Office Applications</h2><p>This lesson covers Office Applications in the context of Microsoft Office Overview.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Office Applications</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 37, NULL, 0, '2025-12-24 17:08:17', '2025-12-24 17:08:17', 0, 0, 1, 30),
(4228, '46e96815-42bc-47be-bd31-2fb9ac0ae0b3', 1076, 'Office 365', 'text', '<h2>Office 365</h2><p>This lesson covers Office 365 in the context of Microsoft Office Overview.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Office 365</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 41, NULL, 0, '2025-12-24 17:08:17', '2025-12-24 17:08:17', 0, 0, 1, 30),
(4229, '7c1ef98a-9851-49a7-98db-f88133d12a81', 1076, 'Common Features', 'text', '<h2>Common Features</h2><p>This lesson covers Common Features in the context of Microsoft Office Overview.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Common Features</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 26, NULL, 0, '2025-12-24 17:08:17', '2025-12-24 17:08:17', 0, 0, 1, 30),
(4230, '3d99ab3a-7b9b-4f32-925e-d0bc3e57b26e', 1076, 'Keyboard Shortcuts', 'text', '<h2>Keyboard Shortcuts</h2><p>This lesson covers Keyboard Shortcuts in the context of Microsoft Office Overview.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Keyboard Shortcuts</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 37, NULL, 0, '2025-12-24 17:08:18', '2025-12-24 17:08:18', 0, 0, 1, 30),
(4231, '1fdb47ea-1cb8-44bf-b5a2-b275cf7aa39e', 1077, 'Word Interface', 'text', '<h2>Word Interface</h2><p>This lesson covers Word Interface in the context of Word Basics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Word Interface</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 30, NULL, 0, '2025-12-24 17:08:18', '2025-12-24 17:08:18', 0, 0, 1, 30),
(4232, '969864a4-b18c-413e-927f-9ffaf40ab33d', 1077, 'Creating Documents', 'text', '<h2>Creating Documents</h2><p>This lesson covers Creating Documents in the context of Word Basics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Creating Documents</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 41, NULL, 0, '2025-12-24 17:08:18', '2025-12-24 17:08:18', 0, 0, 1, 30),
(4233, '041c8741-e214-40e0-baee-f0e414d07f98', 1077, 'Text Formatting', 'text', '<h2>Text Formatting</h2><p>This lesson covers Text Formatting in the context of Word Basics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Text Formatting</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 27, NULL, 0, '2025-12-24 17:08:18', '2025-12-24 17:08:18', 0, 0, 1, 30),
(4234, '8d5aaa17-e23e-4c2f-8aa4-6bbfe7a2f54b', 1077, 'Paragraph Formatting', 'text', '<h2>Paragraph Formatting</h2><p>This lesson covers Paragraph Formatting in the context of Word Basics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Paragraph Formatting</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 18, NULL, 0, '2025-12-24 17:08:19', '2025-12-24 17:08:19', 0, 0, 1, 30),
(4235, 'cf885417-7a14-470c-ba67-62ce69f75e87', 1078, 'Styles and Templates', 'text', '<h2>Styles and Templates</h2><p>This lesson covers Styles and Templates in the context of Word Advanced.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Styles and Templates</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 40, NULL, 0, '2025-12-24 17:08:19', '2025-12-24 17:08:19', 0, 0, 1, 30),
(4236, 'c2717b71-9dc3-464e-99fc-342289fffb6c', 1078, 'Tables', 'text', '<h2>Tables</h2><p>This lesson covers Tables in the context of Word Advanced.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Tables</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 21, NULL, 0, '2025-12-24 17:08:19', '2025-12-24 17:08:19', 0, 0, 1, 30),
(4237, '201055ba-6beb-47a9-a50d-aaf539ca81b5', 1078, 'Images and Graphics', 'text', '<h2>Images and Graphics</h2><p>This lesson covers Images and Graphics in the context of Word Advanced.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Images and Graphics</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 42, NULL, 0, '2025-12-24 17:08:20', '2025-12-24 17:08:20', 0, 0, 1, 30),
(4238, 'f8ab2f8d-2373-48a8-a089-429639e71304', 1078, 'Headers and Footers', 'text', '<h2>Headers and Footers</h2><p>This lesson covers Headers and Footers in the context of Word Advanced.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Headers and Footers</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 18, NULL, 0, '2025-12-24 17:08:20', '2025-12-24 17:08:20', 0, 0, 1, 30),
(4239, 'ca6d0bae-ec3f-44e0-a17e-3a5480809908', 1079, 'Excel Interface', 'text', '<h2>Excel Interface</h2><p>This lesson covers Excel Interface in the context of Excel Basics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Excel Interface</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 32, NULL, 0, '2025-12-24 17:08:20', '2025-12-24 17:08:20', 0, 0, 1, 30),
(4240, '1ff9d4c2-8d60-45eb-9bbb-01f347cc8cc3', 1079, 'Cells and Ranges', 'text', '<h2>Cells and Ranges</h2><p>This lesson covers Cells and Ranges in the context of Excel Basics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Cells and Ranges</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 28, NULL, 0, '2025-12-24 17:08:20', '2025-12-24 17:08:20', 0, 0, 1, 30),
(4241, '69c6357b-37f8-4d28-a11b-af51763f9f13', 1079, 'Basic Formatting', 'text', '<h2>Basic Formatting</h2><p>This lesson covers Basic Formatting in the context of Excel Basics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Basic Formatting</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 35, NULL, 0, '2025-12-24 17:08:20', '2025-12-24 17:08:20', 0, 0, 1, 30),
(4242, '6d5fc553-18b0-4e7e-a301-ee0ee8010337', 1079, 'Simple Formulas', 'text', '<h2>Simple Formulas</h2><p>This lesson covers Simple Formulas in the context of Excel Basics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Simple Formulas</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 30, NULL, 0, '2025-12-24 17:08:20', '2025-12-24 17:08:20', 0, 0, 1, 30),
(4243, '41c641b4-ed59-4f75-96a3-554758806565', 1080, 'Common Functions', 'text', '<h2>Common Functions</h2><p>This lesson covers Common Functions in the context of Excel Formulas and Functions.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Common Functions</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 27, NULL, 0, '2025-12-24 17:08:21', '2025-12-24 17:08:21', 0, 0, 1, 30),
(4244, 'c93bbd35-4ef7-406d-b315-966b51d0e589', 1080, 'Logical Functions', 'text', '<h2>Logical Functions</h2><p>This lesson covers Logical Functions in the context of Excel Formulas and Functions.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Logical Functions</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 42, NULL, 0, '2025-12-24 17:08:21', '2025-12-24 17:08:21', 0, 0, 1, 30),
(4245, '66bb8666-617f-4b5d-ba1f-a175f30378f0', 1080, 'Lookup Functions', 'text', '<h2>Lookup Functions</h2><p>This lesson covers Lookup Functions in the context of Excel Formulas and Functions.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Lookup Functions</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 20, NULL, 0, '2025-12-24 17:08:22', '2025-12-24 17:08:22', 0, 0, 1, 30),
(4246, 'e7a8a66d-1a01-4417-b835-5f5cf558696c', 1080, 'Formula Troubleshooting', 'text', '<h2>Formula Troubleshooting</h2><p>This lesson covers Formula Troubleshooting in the context of Excel Formulas and Functions.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Formula Troubleshooting</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 33, NULL, 0, '2025-12-24 17:08:22', '2025-12-24 17:08:22', 0, 0, 1, 30),
(4247, 'e2c87194-ad05-4f1c-af61-0de9018337ce', 1081, 'Chart Types', 'text', '<h2>Chart Types</h2><p>This lesson covers Chart Types in the context of Excel Charts and Analysis.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Chart Types</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 38, NULL, 0, '2025-12-24 17:08:23', '2025-12-24 17:08:23', 0, 0, 1, 30),
(4248, '9026cfca-8c07-4c82-a272-c48b96c0b71e', 1081, 'Creating Charts', 'text', '<h2>Creating Charts</h2><p>This lesson covers Creating Charts in the context of Excel Charts and Analysis.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Creating Charts</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 26, NULL, 0, '2025-12-24 17:08:23', '2025-12-24 17:08:23', 0, 0, 1, 30),
(4249, '59f417e7-3e53-4e4b-97f4-4f2c0ea30609', 1081, 'Data Analysis', 'text', '<h2>Data Analysis</h2><p>This lesson covers Data Analysis in the context of Excel Charts and Analysis.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Data Analysis</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 19, NULL, 0, '2025-12-24 17:08:23', '2025-12-24 17:08:23', 0, 0, 1, 30),
(4250, 'bb0d2586-88a4-487c-a361-b947275b744a', 1081, 'Pivot Tables', 'text', '<h2>Pivot Tables</h2><p>This lesson covers Pivot Tables in the context of Excel Charts and Analysis.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Pivot Tables</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 20, NULL, 0, '2025-12-24 17:08:23', '2025-12-24 17:08:23', 0, 0, 1, 30),
(4251, '18066138-0d99-4641-8ef0-f8aca6431bad', 1082, 'PowerPoint Interface', 'text', '<h2>PowerPoint Interface</h2><p>This lesson covers PowerPoint Interface in the context of PowerPoint Basics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of PowerPoint Interface</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 25, NULL, 0, '2025-12-24 17:08:24', '2025-12-24 17:08:24', 0, 0, 1, 30),
(4252, '40df1750-f8fe-406c-9750-a2986412ba6f', 1082, 'Creating Presentations', 'text', '<h2>Creating Presentations</h2><p>This lesson covers Creating Presentations in the context of PowerPoint Basics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Creating Presentations</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 43, NULL, 0, '2025-12-24 17:08:24', '2025-12-24 17:08:24', 0, 0, 1, 30),
(4253, 'a139f52f-79fd-4eba-a27a-64ec057063d4', 1082, 'Slide Layouts', 'text', '<h2>Slide Layouts</h2><p>This lesson covers Slide Layouts in the context of PowerPoint Basics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Slide Layouts</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 33, NULL, 0, '2025-12-24 17:08:24', '2025-12-24 17:08:24', 0, 0, 1, 30),
(4254, '7856ac4e-bb4d-4013-bca8-7dbcab0e1085', 1082, 'Themes and Design', 'text', '<h2>Themes and Design</h2><p>This lesson covers Themes and Design in the context of PowerPoint Basics.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Themes and Design</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 35, NULL, 0, '2025-12-24 17:08:24', '2025-12-24 17:08:24', 0, 0, 1, 30),
(4255, 'a1dfcb78-0392-4076-babc-736397feca90', 1083, 'Animations', 'text', '<h2>Animations</h2><p>This lesson covers Animations in the context of PowerPoint Advanced.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Animations</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 45, NULL, 0, '2025-12-24 17:08:24', '2025-12-24 17:08:24', 0, 0, 1, 30),
(4256, '3c124e30-e25b-4aae-9a5b-91a284d60a49', 1083, 'Transitions', 'text', '<h2>Transitions</h2><p>This lesson covers Transitions in the context of PowerPoint Advanced.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Transitions</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 25, NULL, 0, '2025-12-24 17:08:25', '2025-12-24 17:08:25', 0, 0, 1, 30),
(4257, '0b7c0f19-7cc4-4c33-a343-add63047adec', 1083, 'Multimedia', 'text', '<h2>Multimedia</h2><p>This lesson covers Multimedia in the context of PowerPoint Advanced.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Multimedia</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 28, NULL, 0, '2025-12-24 17:08:25', '2025-12-24 17:08:25', 0, 0, 1, 30),
(4258, '21a6c9c8-6e9f-448e-9435-f26ea3c303e1', 1083, 'Presenting Skills', 'text', '<h2>Presenting Skills</h2><p>This lesson covers Presenting Skills in the context of PowerPoint Advanced.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Presenting Skills</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 38, NULL, 0, '2025-12-24 17:08:25', '2025-12-24 17:08:25', 0, 0, 1, 30),
(4259, '38abf799-9066-4207-a216-68c2530069f6', 1084, 'Email Management', 'text', '<h2>Email Management</h2><p>This lesson covers Email Management in the context of Outlook.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Email Management</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 18, NULL, 0, '2025-12-24 17:08:25', '2025-12-24 17:08:25', 0, 0, 1, 30),
(4260, 'e639d96b-b0f3-44c6-a391-59ac3c747f0c', 1084, 'Calendar', 'text', '<h2>Calendar</h2><p>This lesson covers Calendar in the context of Outlook.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Calendar</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 20, NULL, 0, '2025-12-24 17:08:25', '2025-12-24 17:08:25', 0, 0, 1, 30),
(4261, '5396c17b-1218-4ed6-9b00-42676c622ac5', 1084, 'Contacts', 'text', '<h2>Contacts</h2><p>This lesson covers Contacts in the context of Outlook.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Contacts</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 36, NULL, 0, '2025-12-24 17:08:26', '2025-12-24 17:08:26', 0, 0, 1, 30),
(4262, '224ae8d8-7358-43a7-9d19-53aa273be16c', 1084, 'Tasks', 'text', '<h2>Tasks</h2><p>This lesson covers Tasks in the context of Outlook.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Tasks</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 32, NULL, 0, '2025-12-24 17:08:26', '2025-12-24 17:08:26', 0, 0, 1, 30),
(4263, '9a19b0c5-cd15-4658-a7eb-90fb6fbca668', 1085, 'Teams Overview', 'text', '<h2>Teams Overview</h2><p>This lesson covers Teams Overview in the context of Microsoft Teams.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Teams Overview</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 1, 45, NULL, 0, '2025-12-24 17:08:26', '2025-12-24 17:08:26', 0, 0, 1, 30),
(4264, '3ae7312f-0769-442b-a679-703eda16cac3', 1085, 'Chat and Channels', 'text', '<h2>Chat and Channels</h2><p>This lesson covers Chat and Channels in the context of Microsoft Teams.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Chat and Channels</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 2, 29, NULL, 0, '2025-12-24 17:08:26', '2025-12-24 17:08:26', 0, 0, 1, 30),
(4265, 'e6216eb4-ce7e-4cbb-b03d-42e6e2b67035', 1085, 'Meetings', 'text', '<h2>Meetings</h2><p>This lesson covers Meetings in the context of Microsoft Teams.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Meetings</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 3, 33, NULL, 0, '2025-12-24 17:08:26', '2025-12-24 17:08:26', 0, 0, 1, 30),
(4266, 'a98a8fb2-506b-432f-a2b3-9647922c1a85', 1085, 'Collaboration', 'text', '<h2>Collaboration</h2><p>This lesson covers Collaboration in the context of Microsoft Teams.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of Collaboration</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>', 4, 20, NULL, 0, '2025-12-24 17:08:27', '2025-12-24 17:08:27', 0, 0, 1, 30);

-- --------------------------------------------------------

--
-- Table structure for table `lesson_progress`
--

CREATE TABLE `lesson_progress` (
  `id` int(10) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `lesson_id` int(10) UNSIGNED NOT NULL,
  `enrollment_id` int(10) UNSIGNED NOT NULL,
  `status` enum('not_started','in_progress','completed','reviewed') DEFAULT 'not_started',
  `completion_percentage` decimal(5,2) DEFAULT 0.00,
  `time_spent_seconds` int(10) UNSIGNED DEFAULT 0,
  `last_position` varchar(255) DEFAULT NULL,
  `interactions_count` int(10) UNSIGNED DEFAULT 0,
  `revisit_count` int(10) UNSIGNED DEFAULT 0,
  `first_accessed_at` timestamp NULL DEFAULT NULL,
  `last_accessed_at` timestamp NULL DEFAULT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `bookmarked` tinyint(1) DEFAULT 0,
  `quiz_score` decimal(5,2) DEFAULT NULL,
  `attempts_count` int(10) UNSIGNED DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lesson_progress`
--

INSERT INTO `lesson_progress` (`id`, `uuid`, `user_id`, `lesson_id`, `enrollment_id`, `status`, `completion_percentage`, `time_spent_seconds`, `last_position`, `interactions_count`, `revisit_count`, `first_accessed_at`, `last_accessed_at`, `completed_at`, `notes`, `bookmarked`, `quiz_score`, `attempts_count`, `created_at`, `updated_at`) VALUES
(8, 'b1063ba5-9694-4a2c-b9ce-f919506400ec', 10, 3255, 3, 'in_progress', 0.00, 10, NULL, 0, 0, '2025-12-24 18:13:44', '2025-12-24 18:13:55', NULL, NULL, 0, NULL, 0, '2025-12-24 17:13:44', '2025-12-24 17:13:55'),
(9, 'a35eb2bb-54ac-4af8-ac45-893a3d4e9542', 10, 3256, 3, 'in_progress', 0.00, 12, NULL, 0, 0, '2025-12-24 18:13:55', '2025-12-24 18:14:08', NULL, NULL, 0, NULL, 0, '2025-12-24 17:13:55', '2025-12-24 17:14:08'),
(10, '5291d12e-099d-483f-97bd-cebe5ccbc443', 10, 3275, 3, 'in_progress', 0.00, 15, NULL, 0, 0, '2025-12-24 18:14:08', '2025-12-24 18:14:24', NULL, NULL, 0, NULL, 0, '2025-12-24 17:14:08', '2025-12-24 17:14:24'),
(11, '6d3b4053-b734-43d1-bcd4-c97bc4a56115', 10, 3310, 3, 'in_progress', 0.00, 7, NULL, 0, 0, '2025-12-24 18:14:24', '2025-12-24 18:14:31', NULL, NULL, 0, NULL, 0, '2025-12-24 17:14:24', '2025-12-24 17:14:31'),
(12, 'ae37578e-7b23-4188-b5f0-d341a6ab4b34', 10, 3314, 3, 'in_progress', 0.00, 47, NULL, 0, 0, '2025-12-24 18:14:32', '2025-12-24 18:15:19', NULL, NULL, 0, NULL, 0, '2025-12-24 17:14:32', '2025-12-24 17:15:19'),
(13, '9d282d55-4422-4c27-8e4b-b7deb89a7ac8', 10, 3282, 3, 'in_progress', 0.00, 15, NULL, 0, 0, '2025-12-24 18:15:19', '2025-12-24 18:15:35', NULL, NULL, 0, NULL, 0, '2025-12-24 17:15:19', '2025-12-24 17:15:35'),
(14, 'aae3c02f-8fc8-400c-af28-4b2bcc876a59', 10, 3274, 3, 'in_progress', 0.00, 2757, NULL, 0, 0, '2025-12-24 18:15:35', '2025-12-24 19:01:50', NULL, NULL, 0, NULL, 0, '2025-12-24 17:15:35', '2025-12-24 18:01:50');

-- --------------------------------------------------------

--
-- Table structure for table `milestones`
--

CREATE TABLE `milestones` (
  `id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `milestone_type` enum('quiz','project','practical','portfolio','peer_review') DEFAULT 'project',
  `requirements` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`requirements`)),
  `competencies_assessed` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`competencies_assessed`)),
  `passing_criteria` text DEFAULT NULL,
  `passing_score` int(11) DEFAULT 70,
  `badge_name` varchar(100) DEFAULT NULL,
  `badge_icon` varchar(100) DEFAULT NULL,
  `certificate_template` varchar(255) DEFAULT NULL,
  `is_required` tinyint(1) DEFAULT 1,
  `order_index` int(11) DEFAULT 0,
  `status` enum('draft','published','archived') DEFAULT 'published',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `milestone_completions`
--

CREATE TABLE `milestone_completions` (
  `id` int(11) NOT NULL,
  `milestone_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `enrollment_id` int(11) DEFAULT NULL,
  `submission_content` text DEFAULT NULL,
  `submission_files` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`submission_files`)),
  `score` int(11) DEFAULT NULL,
  `feedback` text DEFAULT NULL,
  `status` enum('not_started','in_progress','submitted','passed','failed','revision_needed') DEFAULT 'not_started',
  `attempts` int(11) DEFAULT 0,
  `completed_at` timestamp NULL DEFAULT NULL,
  `reviewed_by` int(11) DEFAULT NULL,
  `reviewed_at` timestamp NULL DEFAULT NULL,
  `badge_awarded` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE `modules` (
  `id` int(10) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `course_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `order_index` int(10) UNSIGNED DEFAULT 0,
  `content` longtext DEFAULT NULL,
  `objectives` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`objectives`)),
  `status` enum('draft','published') DEFAULT 'draft',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `has_milestone` tinyint(1) DEFAULT 0,
  `competency_focus` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`id`, `uuid`, `course_id`, `title`, `description`, `order_index`, `content`, `objectives`, `status`, `created_at`, `updated_at`, `has_milestone`, `competency_focus`) VALUES
(833, '7721829c-5d5a-40d7-a478-1ed8febd1001', 1, 'Introduction to Web Development', 'Learn about Introduction to Web Development', 1, NULL, NULL, 'published', '2025-12-24 17:05:07', '2025-12-24 17:05:07', 0, NULL),
(834, 'dafb7485-e736-4b18-a579-77a4dd79e8c2', 1, 'HTML Fundamentals', 'Learn about HTML Fundamentals', 2, NULL, NULL, 'published', '2025-12-24 17:05:07', '2025-12-24 17:05:07', 0, NULL),
(835, '789ba6bc-15a5-4c84-b18b-3ff6bc3f4bf6', 1, 'HTML Forms and Tables', 'Learn about HTML Forms and Tables', 3, NULL, NULL, 'published', '2025-12-24 17:05:08', '2025-12-24 17:05:08', 0, NULL),
(836, '1e96e1b4-696f-4c92-a3dc-f407ee87334b', 1, 'CSS Basics', 'Learn about CSS Basics', 4, NULL, NULL, 'published', '2025-12-24 17:05:08', '2025-12-24 17:05:08', 0, NULL),
(837, '4231b1c6-30cc-49cb-aef3-73a88e2f9f6e', 1, 'CSS Layout', 'Learn about CSS Layout', 5, NULL, NULL, 'published', '2025-12-24 17:05:08', '2025-12-24 17:05:08', 0, NULL),
(838, '48b38fd5-331a-4209-be06-696b809c0f2f', 1, 'Flexbox', 'Learn about Flexbox', 6, NULL, NULL, 'published', '2025-12-24 17:05:09', '2025-12-24 17:05:09', 0, NULL),
(839, 'ba25dcde-4e9c-4300-a1bd-804e139aab1c', 1, 'CSS Grid', 'Learn about CSS Grid', 7, NULL, NULL, 'published', '2025-12-24 17:05:09', '2025-12-24 17:05:09', 0, NULL),
(840, '2b3fbe4c-9043-4444-8f08-97ffec5fe099', 1, 'Responsive Design', 'Learn about Responsive Design', 8, NULL, NULL, 'published', '2025-12-24 17:05:10', '2025-12-24 17:05:10', 0, NULL),
(841, '6431c1f3-90bd-480a-bbc7-2bc0ff6b325c', 1, 'CSS Advanced Topics', 'Learn about CSS Advanced Topics', 9, NULL, NULL, 'published', '2025-12-24 17:05:10', '2025-12-24 17:05:10', 0, NULL),
(842, 'f663cd0f-ae41-4b19-af36-6083abd0f43d', 1, 'JavaScript Fundamentals', 'Learn about JavaScript Fundamentals', 10, NULL, NULL, 'published', '2025-12-24 17:05:11', '2025-12-24 17:05:11', 0, NULL),
(843, 'af5d9bb3-1127-4ee1-8d0e-f27187606233', 1, 'JavaScript DOM Manipulation', 'Learn about JavaScript DOM Manipulation', 11, NULL, NULL, 'published', '2025-12-24 17:05:11', '2025-12-24 17:05:11', 0, NULL),
(844, '561f540e-6f63-4b92-ad72-2403bd7b2a6e', 1, 'JavaScript Advanced Concepts', 'Learn about JavaScript Advanced Concepts', 12, NULL, NULL, 'published', '2025-12-24 17:05:11', '2025-12-24 17:05:11', 0, NULL),
(845, 'ed555de7-1957-4d34-b158-7d900ad77a4f', 1, 'Frontend Frameworks Introduction', 'Learn about Frontend Frameworks Introduction', 13, NULL, NULL, 'published', '2025-12-24 17:05:12', '2025-12-24 17:05:12', 0, NULL),
(846, 'c8afb0cb-4ebd-434e-9269-d32d1ded0e09', 1, 'Build Tools and Workflow', 'Learn about Build Tools and Workflow', 14, NULL, NULL, 'published', '2025-12-24 17:05:12', '2025-12-24 17:05:12', 0, NULL),
(847, 'f217bd61-17b6-43b8-beec-e4eeb3004b3e', 1, 'Frontend Best Practices', 'Learn about Frontend Best Practices', 15, NULL, NULL, 'published', '2025-12-24 17:05:12', '2025-12-24 17:05:12', 0, NULL),
(848, '0107fc98-e03e-4557-9c65-6f93e2ab1749', 2, 'Introduction to Backend Development', 'Learn about Introduction to Backend Development', 1, NULL, NULL, 'published', '2025-12-24 17:05:13', '2025-12-24 17:05:13', 0, NULL),
(849, '732b9d5b-3687-44ea-a2bd-a1bf97d4de0c', 2, 'Backend Languages Overview', 'Learn about Backend Languages Overview', 2, NULL, NULL, 'published', '2025-12-24 17:05:13', '2025-12-24 17:05:13', 0, NULL),
(850, '13b34720-033f-4be4-94fa-09b028cd432e', 2, 'PHP Fundamentals', 'Learn about PHP Fundamentals', 3, NULL, NULL, 'published', '2025-12-24 17:05:13', '2025-12-24 17:05:13', 0, NULL),
(851, '2fd99c29-3221-42bc-8ab1-f393f8919ef4', 2, 'PHP Functions and Arrays', 'Learn about PHP Functions and Arrays', 4, NULL, NULL, 'published', '2025-12-24 17:05:13', '2025-12-24 17:05:13', 0, NULL),
(852, '75ef82b3-a72f-439d-976c-c6534cd62c78', 2, 'Object-Oriented PHP', 'Learn about Object-Oriented PHP', 5, NULL, NULL, 'published', '2025-12-24 17:05:14', '2025-12-24 17:05:14', 0, NULL),
(853, '7ee4eaca-1f3f-4deb-8545-92e32cf9326b', 2, 'PHP and MySQL Basics', 'Learn about PHP and MySQL Basics', 6, NULL, NULL, 'published', '2025-12-24 17:05:14', '2025-12-24 17:05:14', 0, NULL),
(854, '8167121e-f09e-445a-bc37-bc5b92bac928', 2, 'CRUD Operations', 'Learn about CRUD Operations', 7, NULL, NULL, 'published', '2025-12-24 17:05:14', '2025-12-24 17:05:14', 0, NULL),
(855, 'a58f56a6-075f-462d-8c8a-69c64002491a', 2, 'Database Security', 'Learn about Database Security', 8, NULL, NULL, 'published', '2025-12-24 17:05:15', '2025-12-24 17:05:15', 0, NULL),
(856, 'b8a01f88-1d21-4a0e-87f1-f5f839b2eff2', 2, 'Session and Cookie Management', 'Learn about Session and Cookie Management', 9, NULL, NULL, 'published', '2025-12-24 17:05:15', '2025-12-24 17:05:15', 0, NULL),
(857, 'e713ae29-5679-447a-87b6-55153c98b741', 2, 'Authentication Systems', 'Learn about Authentication Systems', 10, NULL, NULL, 'published', '2025-12-24 17:05:15', '2025-12-24 17:05:15', 0, NULL),
(858, '72376be3-cc4d-47f7-8e56-365775d1c931', 2, 'File Handling', 'Learn about File Handling', 11, NULL, NULL, 'published', '2025-12-24 17:05:15', '2025-12-24 17:05:15', 0, NULL),
(859, '7d587c7a-7358-43ee-ac25-09e0bb887bf5', 2, 'REST API Fundamentals', 'Learn about REST API Fundamentals', 12, NULL, NULL, 'published', '2025-12-24 17:05:16', '2025-12-24 17:05:16', 0, NULL),
(860, '7876a8f8-65ad-4ccd-8e66-0224da569c9b', 2, 'Building APIs with PHP', 'Learn about Building APIs with PHP', 13, NULL, NULL, 'published', '2025-12-24 17:05:16', '2025-12-24 17:05:16', 0, NULL),
(861, '2c007f33-643f-4423-b6a0-7dd50fae18b4', 2, 'API Authentication', 'Learn about API Authentication', 14, NULL, NULL, 'published', '2025-12-24 17:05:17', '2025-12-24 17:05:17', 0, NULL),
(862, '409a30f7-feeb-4589-ba56-b222178e07ff', 2, 'Error Handling and Logging', 'Learn about Error Handling and Logging', 15, NULL, NULL, 'published', '2025-12-24 17:05:17', '2025-12-24 17:05:17', 0, NULL),
(863, '953f016d-f7e4-49d8-ae21-8f16aaf5712a', 2, 'Testing Backend Code', 'Learn about Testing Backend Code', 16, NULL, NULL, 'published', '2025-12-24 17:05:17', '2025-12-24 17:05:17', 0, NULL),
(864, '51738cec-dd4c-4973-bbb1-243900d88ad5', 2, 'Performance Optimization', 'Learn about Performance Optimization', 17, NULL, NULL, 'published', '2025-12-24 17:05:17', '2025-12-24 17:05:17', 0, NULL),
(865, 'e27d27d6-9a2f-4a85-8e87-9a50ec0a30d7', 2, 'Deployment and DevOps', 'Learn about Deployment and DevOps', 18, NULL, NULL, 'published', '2025-12-24 17:05:18', '2025-12-24 17:05:18', 0, NULL),
(866, '9e6b8a01-87a4-48de-90b2-b2fe221ce44b', 3, 'Full Stack Overview', 'Learn about Full Stack Overview', 1, NULL, NULL, 'published', '2025-12-24 17:05:18', '2025-12-24 17:05:18', 0, NULL),
(867, 'f4d200d1-423c-49e4-ae32-08596fe1fac1', 3, 'Development Environment', 'Learn about Development Environment', 2, NULL, NULL, 'published', '2025-12-24 17:05:19', '2025-12-24 17:05:19', 0, NULL),
(868, '7e4e184a-0b7c-43cc-a75f-af7c122996a4', 3, 'HTML5 Deep Dive', 'Learn about HTML5 Deep Dive', 3, NULL, NULL, 'published', '2025-12-24 17:05:19', '2025-12-24 17:05:19', 0, NULL),
(869, '8f2c6798-1a58-4915-aa77-f8133f05a8f8', 3, 'Advanced CSS', 'Learn about Advanced CSS', 4, NULL, NULL, 'published', '2025-12-24 17:05:19', '2025-12-24 17:05:19', 0, NULL),
(870, '8991d0b1-0728-4137-bfcd-90f0810085fb', 3, 'JavaScript Mastery', 'Learn about JavaScript Mastery', 5, NULL, NULL, 'published', '2025-12-24 17:05:20', '2025-12-24 17:05:20', 0, NULL),
(871, 'd89e5633-de56-441a-82af-87521b42b1e6', 3, 'TypeScript Fundamentals', 'Learn about TypeScript Fundamentals', 6, NULL, NULL, 'published', '2025-12-24 17:05:20', '2025-12-24 17:05:20', 0, NULL),
(872, 'edc73108-1c42-48ee-bb57-3b3ff477778f', 3, 'React.js Essentials', 'Learn about React.js Essentials', 7, NULL, NULL, 'published', '2025-12-24 17:05:20', '2025-12-24 17:05:20', 0, NULL),
(873, '9d5a85a5-eb08-439a-a7e3-bc01f017e994', 3, 'React Hooks', 'Learn about React Hooks', 8, NULL, NULL, 'published', '2025-12-24 17:05:21', '2025-12-24 17:05:21', 0, NULL),
(874, '90fe74f0-a703-45c7-a4ce-0bce738423db', 3, 'State Management', 'Learn about State Management', 9, NULL, NULL, 'published', '2025-12-24 17:05:21', '2025-12-24 17:05:21', 0, NULL),
(875, '53f4df59-b0fb-4172-9c88-2f992f7fb644', 3, 'React Router', 'Learn about React Router', 10, NULL, NULL, 'published', '2025-12-24 17:05:21', '2025-12-24 17:05:21', 0, NULL),
(876, 'de8ef61f-b4ee-40c4-a06c-a50c69d1708f', 3, 'Frontend Testing', 'Learn about Frontend Testing', 11, NULL, NULL, 'published', '2025-12-24 17:05:21', '2025-12-24 17:05:21', 0, NULL),
(877, '67391d7f-0cea-4a05-88ce-39caf03c33c1', 3, 'Node.js Fundamentals', 'Learn about Node.js Fundamentals', 12, NULL, NULL, 'published', '2025-12-24 17:05:22', '2025-12-24 17:05:22', 0, NULL),
(878, 'edf055a9-a7a7-4ac7-9807-fedd6c3285ba', 3, 'Express.js Framework', 'Learn about Express.js Framework', 13, NULL, NULL, 'published', '2025-12-24 17:05:22', '2025-12-24 17:05:22', 0, NULL),
(879, '10e953dd-86af-46ee-8b48-1097bb743393', 3, 'MongoDB Basics', 'Learn about MongoDB Basics', 14, NULL, NULL, 'published', '2025-12-24 17:05:22', '2025-12-24 17:05:22', 0, NULL),
(880, '5f517b8d-9bc1-4917-8317-7fccf6ca7fa0', 3, 'MongoDB Advanced', 'Learn about MongoDB Advanced', 15, NULL, NULL, 'published', '2025-12-24 17:05:23', '2025-12-24 17:05:23', 0, NULL),
(881, '14060297-605a-4292-84c8-42b01893e117', 3, 'REST API with Node', 'Learn about REST API with Node', 16, NULL, NULL, 'published', '2025-12-24 17:05:23', '2025-12-24 17:05:23', 0, NULL),
(882, 'a7b71ab1-4aad-42a6-b410-829e7623c1fa', 3, 'Authentication and Authorization', 'Learn about Authentication and Authorization', 17, NULL, NULL, 'published', '2025-12-24 17:05:23', '2025-12-24 17:05:23', 0, NULL),
(883, 'd56025f6-1d58-4b4f-ad52-02576e9d6e8f', 3, 'Real-time Features', 'Learn about Real-time Features', 18, NULL, NULL, 'published', '2025-12-24 17:05:24', '2025-12-24 17:05:24', 0, NULL),
(884, '5bb68fbf-d865-46a0-bc62-05535aeaf00d', 3, 'GraphQL Introduction', 'Learn about GraphQL Introduction', 19, NULL, NULL, 'published', '2025-12-24 17:05:24', '2025-12-24 17:05:24', 0, NULL),
(885, '8a727055-ad2b-4cf2-94be-a9fa44c9649e', 3, 'Full Stack Project Planning', 'Learn about Full Stack Project Planning', 20, NULL, NULL, 'published', '2025-12-24 17:05:24', '2025-12-24 17:05:24', 0, NULL),
(886, '3dd55e43-77c1-42e8-adbe-44c800af42e8', 3, 'Building the Frontend', 'Learn about Building the Frontend', 21, NULL, NULL, 'published', '2025-12-24 17:05:25', '2025-12-24 17:05:25', 0, NULL),
(887, '88f50875-bd65-4f49-9e70-166ce2fbb8a9', 3, 'Building the Backend', 'Learn about Building the Backend', 22, NULL, NULL, 'published', '2025-12-24 17:05:25', '2025-12-24 17:05:25', 0, NULL),
(888, '387de001-a78f-4f34-a1be-bb6ed0cafe1a', 3, 'Testing Full Stack Apps', 'Learn about Testing Full Stack Apps', 23, NULL, NULL, 'published', '2025-12-24 17:05:25', '2025-12-24 17:05:25', 0, NULL),
(889, 'd65557ac-7547-46fb-8c0d-520b11730d27', 3, 'Deployment Strategies', 'Learn about Deployment Strategies', 24, NULL, NULL, 'published', '2025-12-24 17:05:26', '2025-12-24 17:05:26', 0, NULL),
(890, '54ff3ebc-fa5a-477f-8a1e-2a4a3f47628d', 3, 'Production Best Practices', 'Learn about Production Best Practices', 25, NULL, NULL, 'published', '2025-12-24 17:05:26', '2025-12-24 17:05:26', 0, NULL),
(891, 'c65d77af-1d48-438f-8696-8ede1553b9e4', 4, 'Database Fundamentals', 'Learn about Database Fundamentals', 1, NULL, NULL, 'published', '2025-12-24 17:05:27', '2025-12-24 17:05:27', 0, NULL),
(892, '99905dec-986f-4c1c-a22b-26d80ae7e0ae', 4, 'Data Modeling Concepts', 'Learn about Data Modeling Concepts', 2, NULL, NULL, 'published', '2025-12-24 17:05:27', '2025-12-24 17:05:27', 0, NULL),
(893, 'a3ab5b91-a435-4c19-9cf6-fc0139ec5000', 4, 'SQL Basics', 'Learn about SQL Basics', 3, NULL, NULL, 'published', '2025-12-24 17:05:27', '2025-12-24 17:05:27', 0, NULL),
(894, '5cb32c3c-d2ef-4c23-94f4-ff459a069c2a', 4, 'SQL Joins and Subqueries', 'Learn about SQL Joins and Subqueries', 4, NULL, NULL, 'published', '2025-12-24 17:05:28', '2025-12-24 17:05:28', 0, NULL),
(895, 'ce4b4868-05dc-4e0f-ac3d-2e5120acc16a', 4, 'Advanced SQL', 'Learn about Advanced SQL', 5, NULL, NULL, 'published', '2025-12-24 17:05:28', '2025-12-24 17:05:28', 0, NULL),
(896, 'f8a2e215-1913-417b-a964-7d03f8cfbdd4', 4, 'Database Design', 'Learn about Database Design', 6, NULL, NULL, 'published', '2025-12-24 17:05:29', '2025-12-24 17:05:29', 0, NULL),
(897, '851d00b3-4f0d-4f62-bdda-57b64ef86c32', 4, 'Stored Procedures and Functions', 'Learn about Stored Procedures and Functions', 7, NULL, NULL, 'published', '2025-12-24 17:05:29', '2025-12-24 17:05:29', 0, NULL),
(898, '2a9816ca-0e1c-414e-9c88-21c77488321e', 4, 'Indexing and Optimization', 'Learn about Indexing and Optimization', 8, NULL, NULL, 'published', '2025-12-24 17:05:29', '2025-12-24 17:05:29', 0, NULL),
(899, '9d0bae92-1e6e-4a8a-9ae8-6f053cea801a', 4, 'Transactions and Concurrency', 'Learn about Transactions and Concurrency', 9, NULL, NULL, 'published', '2025-12-24 17:05:30', '2025-12-24 17:05:30', 0, NULL),
(900, '7b27b1c5-4a94-4a91-8265-445bc54023a5', 4, 'Database Security', 'Learn about Database Security', 10, NULL, NULL, 'published', '2025-12-24 17:05:30', '2025-12-24 17:05:30', 0, NULL),
(901, '6fc92290-d6d0-4779-a285-1ce8b3cab26e', 4, 'Backup and Recovery', 'Learn about Backup and Recovery', 11, NULL, NULL, 'published', '2025-12-24 17:05:30', '2025-12-24 17:05:30', 0, NULL),
(902, '920c960e-1d48-4b5f-8a8a-2a4ef3a8de5c', 4, 'Database Administration', 'Learn about Database Administration', 12, NULL, NULL, 'published', '2025-12-24 17:05:30', '2025-12-24 17:05:30', 0, NULL),
(903, '25d54ca3-2654-4064-b410-f83a26299bf7', 5, 'Introduction to AI', 'Learn about Introduction to AI', 1, NULL, NULL, 'published', '2025-12-24 17:05:31', '2025-12-24 17:05:31', 0, NULL),
(904, 'bb5e6239-9565-41fa-933c-6229682cc123', 5, 'AI Ethics and Considerations', 'Learn about AI Ethics and Considerations', 2, NULL, NULL, 'published', '2025-12-24 17:05:31', '2025-12-24 17:05:31', 0, NULL),
(905, '02890646-7f01-461e-9d65-45f35e67cbae', 5, 'Python for AI', 'Learn about Python for AI', 3, NULL, NULL, 'published', '2025-12-24 17:05:31', '2025-12-24 17:05:31', 0, NULL),
(906, '2cb0bb59-b198-4b35-833d-28be3bd693dd', 5, 'NumPy Fundamentals', 'Learn about NumPy Fundamentals', 4, NULL, NULL, 'published', '2025-12-24 17:05:32', '2025-12-24 17:05:32', 0, NULL),
(907, '548118eb-3e6f-4eb7-9b67-0cf1b44e5f72', 5, 'Pandas for Data Analysis', 'Learn about Pandas for Data Analysis', 5, NULL, NULL, 'published', '2025-12-24 17:05:32', '2025-12-24 17:05:32', 0, NULL),
(908, 'f123e0e2-0c77-4347-89d4-cbded9a17177', 5, 'Data Visualization', 'Learn about Data Visualization', 6, NULL, NULL, 'published', '2025-12-24 17:05:32', '2025-12-24 17:05:32', 0, NULL),
(909, '9b5947b1-f827-4148-bd46-a276c96ed98b', 5, 'Statistics for ML', 'Learn about Statistics for ML', 7, NULL, NULL, 'published', '2025-12-24 17:05:33', '2025-12-24 17:05:33', 0, NULL),
(910, 'b2a6a07d-6c78-4a5f-9bc4-93f22f52582d', 5, 'Machine Learning Fundamentals', 'Learn about Machine Learning Fundamentals', 8, NULL, NULL, 'published', '2025-12-24 17:05:33', '2025-12-24 17:05:33', 0, NULL),
(911, 'fa57c5e9-df56-425f-be29-1d13aa821b90', 5, 'Supervised Learning: Regression', 'Learn about Supervised Learning: Regression', 9, NULL, NULL, 'published', '2025-12-24 17:05:33', '2025-12-24 17:05:33', 0, NULL),
(912, 'e95b1f72-e35b-43c9-9793-ec33c12d785d', 5, 'Supervised Learning: Classification', 'Learn about Supervised Learning: Classification', 10, NULL, NULL, 'published', '2025-12-24 17:05:34', '2025-12-24 17:05:34', 0, NULL),
(913, '289dafc1-8ae1-4306-945f-47a956b0b2d8', 5, 'Model Evaluation', 'Learn about Model Evaluation', 11, NULL, NULL, 'published', '2025-12-24 17:05:34', '2025-12-24 17:05:34', 0, NULL),
(914, '9b11c083-5a41-4eb0-a3f4-752ddaf55b1a', 5, 'Unsupervised Learning', 'Learn about Unsupervised Learning', 12, NULL, NULL, 'published', '2025-12-24 17:05:34', '2025-12-24 17:05:34', 0, NULL),
(915, '3e6e3938-e82b-490b-9a11-736bd4f630e0', 5, 'Dimensionality Reduction', 'Learn about Dimensionality Reduction', 13, NULL, NULL, 'published', '2025-12-24 17:05:34', '2025-12-24 17:05:34', 0, NULL),
(916, 'efbb5154-7cda-4b04-8e9b-8ad0e327a4c0', 5, 'Ensemble Methods', 'Learn about Ensemble Methods', 14, NULL, NULL, 'published', '2025-12-24 17:05:35', '2025-12-24 17:05:35', 0, NULL),
(917, '45ca75d0-9fa8-4f20-a2d3-a85014c10907', 5, 'Scikit-learn in Practice', 'Learn about Scikit-learn in Practice', 15, NULL, NULL, 'published', '2025-12-24 17:05:35', '2025-12-24 17:05:35', 0, NULL),
(918, '81085bd9-fd3b-4d3e-be95-82e7bf3e1089', 5, 'Introduction to Neural Networks', 'Learn about Introduction to Neural Networks', 16, NULL, NULL, 'published', '2025-12-24 17:05:35', '2025-12-24 17:05:35', 0, NULL),
(919, '546108d9-5e37-48da-bfc0-15d7ad37b3d3', 5, 'Deep Learning Fundamentals', 'Learn about Deep Learning Fundamentals', 17, NULL, NULL, 'published', '2025-12-24 17:05:36', '2025-12-24 17:05:36', 0, NULL),
(920, '53b41d26-d8d0-42ed-a057-c0923a68ced7', 5, 'TensorFlow Basics', 'Learn about TensorFlow Basics', 18, NULL, NULL, 'published', '2025-12-24 17:05:37', '2025-12-24 17:05:37', 0, NULL),
(921, '6591628a-8ca6-48f5-bde9-cc24dad010f2', 5, 'Keras for Deep Learning', 'Learn about Keras for Deep Learning', 19, NULL, NULL, 'published', '2025-12-24 17:05:37', '2025-12-24 17:05:37', 0, NULL),
(922, '6253a2e0-be37-4c28-939f-3ee7df6c7e3b', 5, 'CNNs for Computer Vision', 'Learn about CNNs for Computer Vision', 20, NULL, NULL, 'published', '2025-12-24 17:05:38', '2025-12-24 17:05:38', 0, NULL),
(923, '089ec520-608a-466a-9850-827d049c58bb', 5, 'Advanced CNN Topics', 'Learn about Advanced CNN Topics', 21, NULL, NULL, 'published', '2025-12-24 17:05:38', '2025-12-24 17:05:38', 0, NULL),
(924, '4a5f0f8e-4266-45ef-bb78-605983c9b85e', 5, 'Recurrent Neural Networks', 'Learn about Recurrent Neural Networks', 22, NULL, NULL, 'published', '2025-12-24 17:05:38', '2025-12-24 17:05:38', 0, NULL),
(925, 'ab31ce6f-3986-45c8-90f4-116f59a62d6d', 5, 'Natural Language Processing', 'Learn about Natural Language Processing', 23, NULL, NULL, 'published', '2025-12-24 17:05:38', '2025-12-24 17:05:38', 0, NULL),
(926, 'cb7c74ec-e7eb-482b-8e56-6375f0d45fb1', 5, 'Transformers and Attention', 'Learn about Transformers and Attention', 24, NULL, NULL, 'published', '2025-12-24 17:05:39', '2025-12-24 17:05:39', 0, NULL),
(927, '6f4494fb-ce8d-4040-8d0b-983000cb82ae', 5, 'Generative AI', 'Learn about Generative AI', 25, NULL, NULL, 'published', '2025-12-24 17:05:39', '2025-12-24 17:05:39', 0, NULL),
(928, '58c40245-f4f3-4230-a4de-b4f2f8188726', 5, 'Reinforcement Learning', 'Learn about Reinforcement Learning', 26, NULL, NULL, 'published', '2025-12-24 17:05:39', '2025-12-24 17:05:39', 0, NULL),
(929, 'c7ee0cc2-c27c-4601-975f-1f594d955ef9', 5, 'MLOps Introduction', 'Learn about MLOps Introduction', 27, NULL, NULL, 'published', '2025-12-24 17:05:40', '2025-12-24 17:05:40', 0, NULL),
(930, '3e40e0b7-c4c0-48b3-bba1-85e13d583c7f', 5, 'Model Deployment', 'Learn about Model Deployment', 28, NULL, NULL, 'published', '2025-12-24 17:05:40', '2025-12-24 17:05:40', 0, NULL),
(931, 'b19f995b-dfee-4e9b-a3bd-b86b147be31c', 5, 'AI Project Management', 'Learn about AI Project Management', 29, NULL, NULL, 'published', '2025-12-24 17:05:40', '2025-12-24 17:05:40', 0, NULL),
(932, 'c0da140d-8ae8-448e-82bb-6a34aca75961', 5, 'AI Capstone Project', 'Learn about AI Capstone Project', 30, NULL, NULL, 'published', '2025-12-24 17:05:41', '2025-12-24 17:05:41', 0, NULL),
(933, '97a84bb9-5c37-46d5-805c-e1cfcb47dcc1', 6, 'Data Science Introduction', 'Learn about Data Science Introduction', 1, NULL, NULL, 'published', '2025-12-24 17:05:41', '2025-12-24 17:05:41', 0, NULL),
(934, 'df8b0483-a624-44a3-a532-f296742bf369', 6, 'Python Environment Setup', 'Learn about Python Environment Setup', 2, NULL, NULL, 'published', '2025-12-24 17:05:42', '2025-12-24 17:05:42', 0, NULL),
(935, 'ad9b0c01-0525-44b2-bc7b-1d3df0160c4d', 6, 'Python for Data Science', 'Learn about Python for Data Science', 3, NULL, NULL, 'published', '2025-12-24 17:05:42', '2025-12-24 17:05:42', 0, NULL),
(936, 'c8bbdadf-d0e2-4230-a9c5-ac5086c8ea82', 6, 'NumPy for Data Science', 'Learn about NumPy for Data Science', 4, NULL, NULL, 'published', '2025-12-24 17:05:42', '2025-12-24 17:05:42', 0, NULL),
(937, 'baa65010-e9a6-48b2-b33b-2a3b566ca0ed', 6, 'Pandas Fundamentals', 'Learn about Pandas Fundamentals', 5, NULL, NULL, 'published', '2025-12-24 17:05:43', '2025-12-24 17:05:43', 0, NULL),
(938, '4b66ce69-a947-4c0e-be50-940b470a6cc1', 6, 'Data Wrangling with Pandas', 'Learn about Data Wrangling with Pandas', 6, NULL, NULL, 'published', '2025-12-24 17:05:43', '2025-12-24 17:05:43', 0, NULL),
(939, 'b0e27544-52c6-48ef-94fd-d9eb20f2056a', 6, 'Exploratory Data Analysis', 'Learn about Exploratory Data Analysis', 7, NULL, NULL, 'published', '2025-12-24 17:05:43', '2025-12-24 17:05:43', 0, NULL),
(940, '53db2ddb-902f-454e-85e3-9af8497300e4', 6, 'Data Cleaning', 'Learn about Data Cleaning', 8, NULL, NULL, 'published', '2025-12-24 17:05:44', '2025-12-24 17:05:44', 0, NULL),
(941, '0e34789c-c64b-4184-902c-fc7398e519f8', 6, 'Data Visualization with Matplotlib', 'Learn about Data Visualization with Matplotlib', 9, NULL, NULL, 'published', '2025-12-24 17:05:44', '2025-12-24 17:05:44', 0, NULL),
(942, '954d5f2d-5482-4e13-9e66-1edaff508a8b', 6, 'Advanced Visualization with Seaborn', 'Learn about Advanced Visualization with Seaborn', 10, NULL, NULL, 'published', '2025-12-24 17:05:45', '2025-12-24 17:05:45', 0, NULL),
(943, '885bb15c-9f1e-41cd-8316-7365e0f71d3a', 6, 'Interactive Visualizations', 'Learn about Interactive Visualizations', 11, NULL, NULL, 'published', '2025-12-24 17:05:45', '2025-12-24 17:05:45', 0, NULL),
(944, 'f3b15dce-a721-4f65-92a5-a622b212b02c', 6, 'Descriptive Statistics', 'Learn about Descriptive Statistics', 12, NULL, NULL, 'published', '2025-12-24 17:05:46', '2025-12-24 17:05:46', 0, NULL),
(945, 'c2ff787f-1674-4612-9a63-52dc0365eb3c', 6, 'Probability Theory', 'Learn about Probability Theory', 13, NULL, NULL, 'published', '2025-12-24 17:05:46', '2025-12-24 17:05:46', 0, NULL),
(946, 'ae98dc7a-ff6f-4d81-9215-ac9b066143f7', 6, 'Statistical Distributions', 'Learn about Statistical Distributions', 14, NULL, NULL, 'published', '2025-12-24 17:05:46', '2025-12-24 17:05:46', 0, NULL),
(947, 'fdcaf227-1840-4275-aba1-39aaa6ba8a60', 6, 'Hypothesis Testing', 'Learn about Hypothesis Testing', 15, NULL, NULL, 'published', '2025-12-24 17:05:46', '2025-12-24 17:05:46', 0, NULL),
(948, '467c4892-7d69-4c17-9fbd-8f46c63ca643', 6, 'Regression Analysis', 'Learn about Regression Analysis', 16, NULL, NULL, 'published', '2025-12-24 17:05:47', '2025-12-24 17:05:47', 0, NULL),
(949, 'f105ca75-0e99-4a08-bb49-3b909bfc5bd5', 6, 'Machine Learning for Data Science', 'Learn about Machine Learning for Data Science', 17, NULL, NULL, 'published', '2025-12-24 17:05:47', '2025-12-24 17:05:47', 0, NULL),
(950, 'dc384d4f-4218-46d5-ac0b-b4e2ba0ce5ca', 6, 'Classification Problems', 'Learn about Classification Problems', 18, NULL, NULL, 'published', '2025-12-24 17:05:48', '2025-12-24 17:05:48', 0, NULL),
(951, '53c7114b-fbbc-466b-a6db-0f6b794a70bf', 6, 'Clustering Analysis', 'Learn about Clustering Analysis', 19, NULL, NULL, 'published', '2025-12-24 17:05:48', '2025-12-24 17:05:48', 0, NULL),
(952, '3caf629e-d363-43a4-a312-645d83ae7a28', 6, 'Time Series Analysis', 'Learn about Time Series Analysis', 20, NULL, NULL, 'published', '2025-12-24 17:05:48', '2025-12-24 17:05:48', 0, NULL),
(953, '48bcabe9-73c8-4637-8050-a8698b34d75a', 6, 'SQL for Data Science', 'Learn about SQL for Data Science', 21, NULL, NULL, 'published', '2025-12-24 17:05:48', '2025-12-24 17:05:48', 0, NULL),
(954, 'b8c13d4f-c1e8-404a-b525-70e0d20ba1f9', 6, 'Big Data Fundamentals', 'Learn about Big Data Fundamentals', 22, NULL, NULL, 'published', '2025-12-24 17:05:49', '2025-12-24 17:05:49', 0, NULL),
(955, '3cdecfda-8139-492a-9940-58b99a564c39', 6, 'Web Scraping', 'Learn about Web Scraping', 23, NULL, NULL, 'published', '2025-12-24 17:05:49', '2025-12-24 17:05:49', 0, NULL),
(956, 'ed216855-f0c7-4303-bcd0-24cdfcc1f053', 6, 'Data Ethics and Privacy', 'Learn about Data Ethics and Privacy', 24, NULL, NULL, 'published', '2025-12-24 17:05:49', '2025-12-24 17:05:49', 0, NULL),
(957, '2c121900-8606-4354-bed0-4416772ce9d4', 6, 'Storytelling with Data', 'Learn about Storytelling with Data', 25, NULL, NULL, 'published', '2025-12-24 17:05:50', '2025-12-24 17:05:50', 0, NULL),
(958, '69654bb2-da8c-404d-8f66-fe497721aff6', 6, 'Business Intelligence', 'Learn about Business Intelligence', 26, NULL, NULL, 'published', '2025-12-24 17:05:53', '2025-12-24 17:05:53', 0, NULL),
(959, 'fbde2061-d619-4e08-95a6-431b3942ce0e', 6, 'Data Science Projects', 'Learn about Data Science Projects', 27, NULL, NULL, 'published', '2025-12-24 17:05:54', '2025-12-24 17:05:54', 0, NULL),
(960, '55c89ac8-d7ef-4412-8f29-58cb00c9b007', 6, 'Data Science Capstone', 'Learn about Data Science Capstone', 28, NULL, NULL, 'published', '2025-12-24 17:05:55', '2025-12-24 17:05:55', 0, NULL),
(961, 'b697c035-fcd6-4b6f-a351-5bef12f389d8', 7, 'Mobile Development Overview', 'Learn about Mobile Development Overview', 1, NULL, NULL, 'published', '2025-12-24 17:05:56', '2025-12-24 17:05:56', 0, NULL),
(962, 'd499be6a-215f-4be9-8368-ca83b8fb340e', 7, 'Mobile UI/UX Principles', 'Learn about Mobile UI/UX Principles', 2, NULL, NULL, 'published', '2025-12-24 17:05:56', '2025-12-24 17:05:56', 0, NULL),
(963, '5d1fdab3-c628-4306-8ca1-fbbbf53e0a5a', 7, 'JavaScript for Mobile', 'Learn about JavaScript for Mobile', 3, NULL, NULL, 'published', '2025-12-24 17:05:57', '2025-12-24 17:05:57', 0, NULL),
(964, '27848546-32f0-443c-81c1-92b6d62cf621', 7, 'React Native Setup', 'Learn about React Native Setup', 4, NULL, NULL, 'published', '2025-12-24 17:05:57', '2025-12-24 17:05:57', 0, NULL),
(965, '174f78a7-31d8-47bb-8622-b771b3f76aa1', 7, 'React Native Components', 'Learn about React Native Components', 5, NULL, NULL, 'published', '2025-12-24 17:05:58', '2025-12-24 17:05:58', 0, NULL),
(966, 'b265ab28-786b-473b-8649-002383cd8547', 7, 'React Native Navigation', 'Learn about React Native Navigation', 6, NULL, NULL, 'published', '2025-12-24 17:05:58', '2025-12-24 17:05:58', 0, NULL),
(967, '6d7c81c7-c0c3-4955-9b08-2695cb685fa2', 7, 'State Management in Mobile', 'Learn about State Management in Mobile', 7, NULL, NULL, 'published', '2025-12-24 17:05:58', '2025-12-24 17:05:58', 0, NULL),
(968, '478afecd-05a5-4153-a837-c4e0c68f1cc0', 7, 'Networking and APIs', 'Learn about Networking and APIs', 8, NULL, NULL, 'published', '2025-12-24 17:05:59', '2025-12-24 17:05:59', 0, NULL),
(969, '87632c2e-8df8-477e-94d3-5138275b5fbd', 7, 'Local Storage', 'Learn about Local Storage', 9, NULL, NULL, 'published', '2025-12-24 17:06:00', '2025-12-24 17:06:00', 0, NULL),
(970, '43a56f7d-7739-405a-b99c-9771d8e683da', 7, 'Camera and Media', 'Learn about Camera and Media', 10, NULL, NULL, 'published', '2025-12-24 17:06:02', '2025-12-24 17:06:02', 0, NULL),
(971, '6ccadb55-a013-4038-865b-5e15d0f157ea', 7, 'Location Services', 'Learn about Location Services', 11, NULL, NULL, 'published', '2025-12-24 17:06:04', '2025-12-24 17:06:04', 0, NULL),
(972, 'dba381c1-362a-4eda-b942-2d24112d95bb', 7, 'Push Notifications', 'Learn about Push Notifications', 12, NULL, NULL, 'published', '2025-12-24 17:06:04', '2025-12-24 17:06:04', 0, NULL),
(973, '0c378c90-a56e-41b0-bfbe-fcfb3c0f22e4', 7, 'Device Features', 'Learn about Device Features', 13, NULL, NULL, 'published', '2025-12-24 17:06:05', '2025-12-24 17:06:05', 0, NULL),
(974, '0b05ad3e-992e-4e6e-885a-1a26ecdf7a5a', 7, 'Animation and Gestures', 'Learn about Animation and Gestures', 14, NULL, NULL, 'published', '2025-12-24 17:06:06', '2025-12-24 17:06:06', 0, NULL),
(975, '9d15ba0b-d156-41e2-beb6-d810743ef70d', 7, 'Authentication in Mobile', 'Learn about Authentication in Mobile', 15, NULL, NULL, 'published', '2025-12-24 17:06:08', '2025-12-24 17:06:08', 0, NULL),
(976, '9baf90fc-6345-49d9-bd4d-559bdc43b23c', 7, 'Testing Mobile Apps', 'Learn about Testing Mobile Apps', 16, NULL, NULL, 'published', '2025-12-24 17:06:12', '2025-12-24 17:06:12', 0, NULL),
(977, 'f0f4efa4-e310-4b52-834c-905118487792', 7, 'Performance Optimization', 'Learn about Performance Optimization', 17, NULL, NULL, 'published', '2025-12-24 17:06:15', '2025-12-24 17:06:15', 0, NULL),
(978, 'f906cadf-8ab1-4503-9944-57798efe4b1d', 7, 'App Store Guidelines', 'Learn about App Store Guidelines', 18, NULL, NULL, 'published', '2025-12-24 17:06:16', '2025-12-24 17:06:16', 0, NULL),
(979, '4ebb3c43-3af1-4974-8fad-c057d0fff879', 7, 'Building for Production', 'Learn about Building for Production', 19, NULL, NULL, 'published', '2025-12-24 17:06:18', '2025-12-24 17:06:18', 0, NULL),
(980, '800ddbce-d267-4b01-a50d-2b5e682952dc', 7, 'Publishing Your App', 'Learn about Publishing Your App', 20, NULL, NULL, 'published', '2025-12-24 17:06:19', '2025-12-24 17:06:19', 0, NULL),
(981, '5fd56c59-d0be-442d-a69b-f0b3340056ed', 8, 'Introduction to Cybersecurity', 'Learn about Introduction to Cybersecurity', 1, NULL, NULL, 'published', '2025-12-24 17:06:19', '2025-12-24 17:06:19', 0, NULL),
(982, '9c33de65-8d6c-4d20-beda-55f9e498c0ae', 8, 'Security Fundamentals', 'Learn about Security Fundamentals', 2, NULL, NULL, 'published', '2025-12-24 17:06:20', '2025-12-24 17:06:20', 0, NULL),
(983, 'bfae0c0e-544b-4155-86b0-63cdfd4b4034', 8, 'Common Threats and Attacks', 'Learn about Common Threats and Attacks', 3, NULL, NULL, 'published', '2025-12-24 17:06:22', '2025-12-24 17:06:22', 0, NULL),
(984, 'f9bd1167-1131-4401-9360-cd14ae7c7c80', 8, 'Network Security Basics', 'Learn about Network Security Basics', 4, NULL, NULL, 'published', '2025-12-24 17:06:23', '2025-12-24 17:06:23', 0, NULL),
(985, '20268faf-23c8-43e1-be32-b85b3bc0e8ac', 8, 'Network Defense', 'Learn about Network Defense', 5, NULL, NULL, 'published', '2025-12-24 17:06:25', '2025-12-24 17:06:25', 0, NULL),
(986, '93ba987a-070f-4d4e-9d1d-42d7ac891fa6', 8, 'Wireless Security', 'Learn about Wireless Security', 6, NULL, NULL, 'published', '2025-12-24 17:06:28', '2025-12-24 17:06:28', 0, NULL),
(987, 'aacc6e8d-b9a0-401d-88d2-d2e61a0b97c5', 8, 'Operating System Security', 'Learn about Operating System Security', 7, NULL, NULL, 'published', '2025-12-24 17:06:30', '2025-12-24 17:06:30', 0, NULL),
(988, '382e388c-aa39-4555-8309-aba70056258e', 8, 'Web Application Security', 'Learn about Web Application Security', 8, NULL, NULL, 'published', '2025-12-24 17:06:32', '2025-12-24 17:06:32', 0, NULL),
(989, 'b1e27128-256e-4f8a-ae59-7d2a708032b4', 8, 'Cryptography Fundamentals', 'Learn about Cryptography Fundamentals', 9, NULL, NULL, 'published', '2025-12-24 17:06:34', '2025-12-24 17:06:34', 0, NULL),
(990, '482ed899-0e99-4b22-87d4-b5eb26db715e', 8, 'Applied Cryptography', 'Learn about Applied Cryptography', 10, NULL, NULL, 'published', '2025-12-24 17:06:36', '2025-12-24 17:06:36', 0, NULL),
(991, '22095375-78af-4571-9a9b-b1e4d3398f98', 8, 'Identity and Access Management', 'Learn about Identity and Access Management', 11, NULL, NULL, 'published', '2025-12-24 17:06:37', '2025-12-24 17:06:37', 0, NULL),
(992, '94c88ed2-3ac2-45c2-9c7c-fedae1302127', 8, 'Introduction to Pen Testing', 'Learn about Introduction to Pen Testing', 12, NULL, NULL, 'published', '2025-12-24 17:06:38', '2025-12-24 17:06:38', 0, NULL),
(993, '0bba085f-7c51-4e13-9d57-ead40cfda5c8', 8, 'Reconnaissance Techniques', 'Learn about Reconnaissance Techniques', 13, NULL, NULL, 'published', '2025-12-24 17:06:39', '2025-12-24 17:06:39', 0, NULL),
(994, 'd3c9e5c5-2f95-43ec-9640-9b703dd42618', 8, 'Vulnerability Assessment', 'Learn about Vulnerability Assessment', 14, NULL, NULL, 'published', '2025-12-24 17:06:40', '2025-12-24 17:06:40', 0, NULL),
(995, '070965f4-599e-40a2-a7fc-554c89425adb', 8, 'Exploitation Basics', 'Learn about Exploitation Basics', 15, NULL, NULL, 'published', '2025-12-24 17:06:41', '2025-12-24 17:06:41', 0, NULL),
(996, 'bf1f8979-c337-4d55-8987-0d88d915001f', 8, 'Security Operations Center', 'Learn about Security Operations Center', 16, NULL, NULL, 'published', '2025-12-24 17:06:43', '2025-12-24 17:06:43', 0, NULL),
(997, 'ef3daf8f-dd08-403e-b160-0211c63c751b', 8, 'Incident Response', 'Learn about Incident Response', 17, NULL, NULL, 'published', '2025-12-24 17:06:44', '2025-12-24 17:06:44', 0, NULL),
(998, 'bdd83351-4a68-4158-a957-17c14398e55f', 8, 'Digital Forensics', 'Learn about Digital Forensics', 18, NULL, NULL, 'published', '2025-12-24 17:06:47', '2025-12-24 17:06:47', 0, NULL),
(999, '969d0430-4927-4e4d-b50a-7d6ee7ceec02', 8, 'Security Policies', 'Learn about Security Policies', 19, NULL, NULL, 'published', '2025-12-24 17:06:47', '2025-12-24 17:06:47', 0, NULL),
(1000, '7b51620d-8687-49ec-8d46-6d921c169053', 8, 'Risk Management', 'Learn about Risk Management', 20, NULL, NULL, 'published', '2025-12-24 17:06:48', '2025-12-24 17:06:48', 0, NULL),
(1001, '4f380437-bdb4-4d31-8b09-30da4c7f96f9', 8, 'Security Awareness', 'Learn about Security Awareness', 21, NULL, NULL, 'published', '2025-12-24 17:06:49', '2025-12-24 17:06:49', 0, NULL),
(1002, '57646e6e-d14c-424f-8aee-a05c08d026c0', 8, 'Cloud Security', 'Learn about Cloud Security', 22, NULL, NULL, 'published', '2025-12-24 17:06:50', '2025-12-24 17:06:50', 0, NULL),
(1003, '96ad7f36-d268-4040-a936-62ea6fee5586', 9, 'Cloud Computing Fundamentals', 'Learn about Cloud Computing Fundamentals', 1, NULL, NULL, 'published', '2025-12-24 17:06:54', '2025-12-24 17:06:54', 0, NULL),
(1004, 'a1a3c975-1e00-4347-894a-898a93cbcedb', 9, 'Cloud Service Models', 'Learn about Cloud Service Models', 2, NULL, NULL, 'published', '2025-12-24 17:06:55', '2025-12-24 17:06:55', 0, NULL),
(1005, '0b26b051-2552-4cfe-a5b0-e8bce2f0a6a8', 9, 'Cloud Deployment Models', 'Learn about Cloud Deployment Models', 3, NULL, NULL, 'published', '2025-12-24 17:06:57', '2025-12-24 17:06:57', 0, NULL),
(1006, '43f7ac45-6c40-43c2-b60a-f65e63206cb5', 9, 'Major Cloud Providers', 'Learn about Major Cloud Providers', 4, NULL, NULL, 'published', '2025-12-24 17:06:58', '2025-12-24 17:06:58', 0, NULL),
(1007, '370d3464-8e69-4186-80ee-ba3fcca5d8b0', 9, 'AWS Account Setup', 'Learn about AWS Account Setup', 5, NULL, NULL, 'published', '2025-12-24 17:07:01', '2025-12-24 17:07:01', 0, NULL),
(1008, 'c7f4ddf6-7099-4033-9e9e-5b1bb81613bb', 9, 'AWS Compute Services', 'Learn about AWS Compute Services', 6, NULL, NULL, 'published', '2025-12-24 17:07:02', '2025-12-24 17:07:02', 0, NULL),
(1009, 'e16298bc-6f5d-411c-97f4-2dd70552344f', 9, 'AWS Storage Services', 'Learn about AWS Storage Services', 7, NULL, NULL, 'published', '2025-12-24 17:07:03', '2025-12-24 17:07:03', 0, NULL),
(1010, '0004de10-f538-4cc9-9b90-5de55b6813bc', 9, 'AWS Networking', 'Learn about AWS Networking', 8, NULL, NULL, 'published', '2025-12-24 17:07:04', '2025-12-24 17:07:04', 0, NULL),
(1011, '5ad4e591-bca2-4773-86fc-279245a39409', 9, 'AWS Database Services', 'Learn about AWS Database Services', 9, NULL, NULL, 'published', '2025-12-24 17:07:05', '2025-12-24 17:07:05', 0, NULL),
(1012, '990c3711-7b87-4a41-9b57-22ebb66a8cc0', 9, 'AWS Security', 'Learn about AWS Security', 10, NULL, NULL, 'published', '2025-12-24 17:07:06', '2025-12-24 17:07:06', 0, NULL),
(1013, '146768df-9604-428b-96bc-6409ab07e84c', 9, 'AWS Application Services', 'Learn about AWS Application Services', 11, NULL, NULL, 'published', '2025-12-24 17:07:06', '2025-12-24 17:07:06', 0, NULL),
(1014, 'b50dabb1-14a5-4d03-8e98-2b12b36a698a', 9, 'Infrastructure as Code', 'Learn about Infrastructure as Code', 12, NULL, NULL, 'published', '2025-12-24 17:07:07', '2025-12-24 17:07:07', 0, NULL),
(1015, 'dda2e778-1c1d-4395-a573-770626bfc867', 9, 'DevOps Principles', 'Learn about DevOps Principles', 13, NULL, NULL, 'published', '2025-12-24 17:07:08', '2025-12-24 17:07:08', 0, NULL),
(1016, '901395c6-b490-4635-947e-fc41f6ccce8d', 9, 'Version Control with Git', 'Learn about Version Control with Git', 14, NULL, NULL, 'published', '2025-12-24 17:07:09', '2025-12-24 17:07:09', 0, NULL),
(1017, '1fcf1256-78b3-43f4-802b-a982791c4684', 9, 'Docker Fundamentals', 'Learn about Docker Fundamentals', 15, NULL, NULL, 'published', '2025-12-24 17:07:09', '2025-12-24 17:07:09', 0, NULL),
(1018, '8c62e2e7-0b5f-4d5c-b7a8-df5c41b01b63', 9, 'Docker Advanced', 'Learn about Docker Advanced', 16, NULL, NULL, 'published', '2025-12-24 17:07:10', '2025-12-24 17:07:10', 0, NULL),
(1019, '8886a170-a7bf-49c7-89f5-40e31c23e3a6', 9, 'Kubernetes Basics', 'Learn about Kubernetes Basics', 17, NULL, NULL, 'published', '2025-12-24 17:07:11', '2025-12-24 17:07:11', 0, NULL),
(1020, '0d9b19a4-7902-4995-b283-c8260a03629c', 9, 'Kubernetes Advanced', 'Learn about Kubernetes Advanced', 18, NULL, NULL, 'published', '2025-12-24 17:07:12', '2025-12-24 17:07:12', 0, NULL),
(1021, 'da7e7fd6-d749-4cdd-9ee5-4466e0c7f51e', 9, 'CI/CD Pipelines', 'Learn about CI/CD Pipelines', 19, NULL, NULL, 'published', '2025-12-24 17:07:12', '2025-12-24 17:07:12', 0, NULL),
(1022, '206f7760-d051-4265-88cc-8d03c8856c39', 9, 'Monitoring and Logging', 'Learn about Monitoring and Logging', 20, NULL, NULL, 'published', '2025-12-24 17:07:13', '2025-12-24 17:07:13', 0, NULL),
(1023, '8564a954-f6b6-488e-a24b-08760f329f1b', 9, 'Well-Architected Framework', 'Learn about Well-Architected Framework', 21, NULL, NULL, 'published', '2025-12-24 17:07:14', '2025-12-24 17:07:14', 0, NULL),
(1024, 'c1a4ae8a-e8d1-4ae6-9eab-2ad9ad49b877', 9, 'High Availability', 'Learn about High Availability', 22, NULL, NULL, 'published', '2025-12-24 17:07:14', '2025-12-24 17:07:14', 0, NULL),
(1025, '733900e8-7bc3-4ee5-bc03-697f9e4363e6', 9, 'Cost Optimization', 'Learn about Cost Optimization', 23, NULL, NULL, 'published', '2025-12-24 17:07:14', '2025-12-24 17:07:14', 0, NULL),
(1026, 'f1697cbb-78ba-4f94-b8dc-282e77f78baf', 9, 'Cloud Migration', 'Learn about Cloud Migration', 24, NULL, NULL, 'published', '2025-12-24 17:07:15', '2025-12-24 17:07:15', 0, NULL),
(1027, '518904a7-a1f1-4a6e-88e1-507140e984ec', 9, 'Serverless Architecture', 'Learn about Serverless Architecture', 25, NULL, NULL, 'published', '2025-12-24 17:07:16', '2025-12-24 17:07:16', 0, NULL),
(1028, '1661614c-c42b-4b9a-be14-6bd6d56bf100', 9, 'Cloud Capstone Project', 'Learn about Cloud Capstone Project', 26, NULL, NULL, 'published', '2025-12-24 17:07:17', '2025-12-24 17:07:17', 0, NULL),
(1029, '720f0609-9c59-4608-8e69-64d045d7a6a8', 10, 'Networking Fundamentals', 'Learn about Networking Fundamentals', 1, NULL, NULL, 'published', '2025-12-24 17:07:19', '2025-12-24 17:07:19', 0, NULL),
(1030, 'ea6b92d0-18ab-4a17-b414-0e48f0671cea', 10, 'OSI Model', 'Learn about OSI Model', 2, NULL, NULL, 'published', '2025-12-24 17:07:20', '2025-12-24 17:07:20', 0, NULL),
(1031, 'f7005cd5-73a0-4115-acd2-0576f09044a9', 10, 'TCP/IP Protocol Suite', 'Learn about TCP/IP Protocol Suite', 3, NULL, NULL, 'published', '2025-12-24 17:07:21', '2025-12-24 17:07:21', 0, NULL),
(1032, 'b3b0443e-0038-4577-9408-2dcdafbf0dc9', 10, 'IP Addressing', 'Learn about IP Addressing', 4, NULL, NULL, 'published', '2025-12-24 17:07:22', '2025-12-24 17:07:22', 0, NULL),
(1033, 'aa2d7b26-3673-4c95-94af-b92e268248a7', 10, 'Subnetting', 'Learn about Subnetting', 5, NULL, NULL, 'published', '2025-12-24 17:07:25', '2025-12-24 17:07:25', 0, NULL),
(1034, 'd79cf681-d83e-40cb-9b94-ca468340241f', 10, 'IPv6 Fundamentals', 'Learn about IPv6 Fundamentals', 6, NULL, NULL, 'published', '2025-12-24 17:07:27', '2025-12-24 17:07:27', 0, NULL),
(1035, '43e628b6-121a-49ec-bded-e270cea08184', 10, 'Network Devices', 'Learn about Network Devices', 7, NULL, NULL, 'published', '2025-12-24 17:07:28', '2025-12-24 17:07:28', 0, NULL),
(1036, '5fb86c9f-e723-451a-a0a4-0e87826a2c47', 10, 'Switching and VLANs', 'Learn about Switching and VLANs', 8, NULL, NULL, 'published', '2025-12-24 17:07:29', '2025-12-24 17:07:29', 0, NULL),
(1037, '917b61c7-700a-4f22-b568-ac2169320611', 10, 'Routing Fundamentals', 'Learn about Routing Fundamentals', 9, NULL, NULL, 'published', '2025-12-24 17:07:29', '2025-12-24 17:07:29', 0, NULL),
(1038, '0fc36b5e-f94b-47af-b5bb-173f84a59ea0', 10, 'Network Services', 'Learn about Network Services', 10, NULL, NULL, 'published', '2025-12-24 17:07:30', '2025-12-24 17:07:30', 0, NULL),
(1039, '3146e301-e6f4-4f73-8ee8-fd7c3d634440', 11, 'Computer Components Overview', 'Learn about Computer Components Overview', 1, NULL, NULL, 'published', '2025-12-24 17:07:31', '2025-12-24 17:07:31', 0, NULL),
(1040, 'df47ade3-2345-4d64-80fd-7d66c11402fb', 11, 'Processors (CPUs)', 'Learn about Processors (CPUs)', 2, NULL, NULL, 'published', '2025-12-24 17:07:32', '2025-12-24 17:07:32', 0, NULL),
(1041, 'ab75b8c4-f011-45ba-8bd9-174311d6c74e', 11, 'Memory and Storage', 'Learn about Memory and Storage', 3, NULL, NULL, 'published', '2025-12-24 17:07:33', '2025-12-24 17:07:33', 0, NULL),
(1042, 'de5bec19-c4a7-4930-adae-549923ea6a41', 11, 'Motherboards and BIOS', 'Learn about Motherboards and BIOS', 4, NULL, NULL, 'published', '2025-12-24 17:07:34', '2025-12-24 17:07:34', 0, NULL),
(1043, 'ab96e152-8b0c-4f2c-a4c4-513931bdd069', 11, 'PC Assembly', 'Learn about PC Assembly', 5, NULL, NULL, 'published', '2025-12-24 17:07:35', '2025-12-24 17:07:35', 0, NULL),
(1044, '971dc30b-d7ec-4860-9950-559685a864e8', 11, 'Operating System Installation', 'Learn about Operating System Installation', 6, NULL, NULL, 'published', '2025-12-24 17:07:36', '2025-12-24 17:07:36', 0, NULL),
(1045, 'e22104cc-9eb6-49b0-ab61-26c6632a42a4', 11, 'Troubleshooting', 'Learn about Troubleshooting', 7, NULL, NULL, 'published', '2025-12-24 17:07:37', '2025-12-24 17:07:37', 0, NULL),
(1046, '87d1f10f-8327-4261-989b-36c477de4d07', 11, 'Maintenance and Upgrades', 'Learn about Maintenance and Upgrades', 8, NULL, NULL, 'published', '2025-12-24 17:07:38', '2025-12-24 17:07:38', 0, NULL),
(1047, '70d4ed8c-7faf-4cba-b1ab-9cc64085a17f', 12, 'Computer Basics', 'Learn about Computer Basics', 1, NULL, NULL, 'published', '2025-12-24 17:07:40', '2025-12-24 17:07:40', 0, NULL),
(1048, 'ef5f16bd-e47b-48eb-950e-1cf8440d6e5b', 12, 'Keyboard and Mouse Skills', 'Learn about Keyboard and Mouse Skills', 2, NULL, NULL, 'published', '2025-12-24 17:07:43', '2025-12-24 17:07:43', 0, NULL),
(1049, '8f697815-8d6d-4001-ae47-d805ffe752a9', 12, 'File Management', 'Learn about File Management', 3, NULL, NULL, 'published', '2025-12-24 17:07:44', '2025-12-24 17:07:44', 0, NULL),
(1050, 'c1c8b61a-e7e2-485b-b7b2-97e76010c3fe', 12, 'Internet Basics', 'Learn about Internet Basics', 4, NULL, NULL, 'published', '2025-12-24 17:07:45', '2025-12-24 17:07:45', 0, NULL),
(1051, 'd10ea9dd-7944-47b0-81a9-fdcd35e2a7c8', 12, 'Email Essentials', 'Learn about Email Essentials', 5, NULL, NULL, 'published', '2025-12-24 17:07:46', '2025-12-24 17:07:46', 0, NULL),
(1052, '38042a90-7160-43ed-9e3e-603587eb6a8f', 12, 'Online Safety', 'Learn about Online Safety', 6, NULL, NULL, 'published', '2025-12-24 17:07:47', '2025-12-24 17:07:47', 0, NULL),
(1053, '1eeb62c2-318e-434c-9ab1-1f99b3fd9b4b', 12, 'Productivity Basics', 'Learn about Productivity Basics', 7, NULL, NULL, 'published', '2025-12-24 17:07:47', '2025-12-24 17:07:47', 0, NULL),
(1054, 'fb5693ce-67de-49a5-aa8c-f442e5484693', 12, 'Digital Communication', 'Learn about Digital Communication', 8, NULL, NULL, 'published', '2025-12-24 17:07:48', '2025-12-24 17:07:48', 0, NULL),
(1055, '21a9173e-fb7d-4226-a2dd-708d5f7536bb', 13, 'Design Fundamentals', 'Learn about Design Fundamentals', 1, NULL, NULL, 'published', '2025-12-24 17:07:49', '2025-12-24 17:07:49', 0, NULL),
(1056, '1367ed32-e299-47fe-a7a0-131623aa55b0', 13, 'Elements of Design', 'Learn about Elements of Design', 2, NULL, NULL, 'published', '2025-12-24 17:07:49', '2025-12-24 17:07:49', 0, NULL),
(1057, 'daefe98e-4274-4bd9-baa1-e3814381f168', 13, 'Principles of Design', 'Learn about Principles of Design', 3, NULL, NULL, 'published', '2025-12-24 17:07:50', '2025-12-24 17:07:50', 0, NULL),
(1058, '96d3918c-6878-4abd-bde6-05b5e5cc6822', 13, 'Color Theory', 'Learn about Color Theory', 4, NULL, NULL, 'published', '2025-12-24 17:07:53', '2025-12-24 17:07:53', 0, NULL),
(1059, 'a72a3a76-d2d5-421f-9d65-b1d6b49b52a3', 13, 'Typography', 'Learn about Typography', 5, NULL, NULL, 'published', '2025-12-24 17:07:54', '2025-12-24 17:07:54', 0, NULL),
(1060, '3c4cf309-45ee-4f15-8222-7d7a7b3f39d8', 13, 'Adobe Photoshop Basics', 'Learn about Adobe Photoshop Basics', 6, NULL, NULL, 'published', '2025-12-24 17:07:55', '2025-12-24 17:07:55', 0, NULL),
(1061, 'ccee5480-9da6-4193-b8ad-fe629d78ddbd', 13, 'Photoshop Advanced', 'Learn about Photoshop Advanced', 7, NULL, NULL, 'published', '2025-12-24 17:07:55', '2025-12-24 17:07:55', 0, NULL),
(1062, '4bc69118-897f-4fc3-8341-f7b76a778de8', 13, 'Adobe Illustrator Basics', 'Learn about Adobe Illustrator Basics', 8, NULL, NULL, 'published', '2025-12-24 17:07:56', '2025-12-24 17:07:56', 0, NULL),
(1063, 'c6a54749-662c-45fa-8fa1-0a234a27c0a8', 13, 'Illustrator Advanced', 'Learn about Illustrator Advanced', 9, NULL, NULL, 'published', '2025-12-24 17:07:57', '2025-12-24 17:07:57', 0, NULL),
(1064, '090a2b40-8a22-4629-9038-9dda652e4fae', 13, 'Brand Identity Design', 'Learn about Brand Identity Design', 10, NULL, NULL, 'published', '2025-12-24 17:07:57', '2025-12-24 17:07:57', 0, NULL),
(1065, 'b6dffd48-5f39-4a88-a49f-a412e836eea4', 13, 'Digital Design Projects', 'Learn about Digital Design Projects', 11, NULL, NULL, 'published', '2025-12-24 17:07:58', '2025-12-24 17:07:58', 0, NULL),
(1066, '7458b14b-b515-49f0-8fd1-d7aa9fc72576', 14, 'Video Production Overview', 'Learn about Video Production Overview', 1, NULL, NULL, 'published', '2025-12-24 17:07:58', '2025-12-24 17:07:58', 0, NULL),
(1067, 'a6bfb0ef-287a-44cc-b540-6f4cf5b2928d', 14, 'Camera Basics', 'Learn about Camera Basics', 2, NULL, NULL, 'published', '2025-12-24 17:07:59', '2025-12-24 17:07:59', 0, NULL),
(1068, '11768059-7886-41f9-a21a-18b012b5323b', 14, 'Audio for Video', 'Learn about Audio for Video', 3, NULL, NULL, 'published', '2025-12-24 17:07:59', '2025-12-24 17:07:59', 0, NULL),
(1069, '20b1bfc9-a564-4391-82b5-59243fee46e8', 14, 'Premiere Pro Basics', 'Learn about Premiere Pro Basics', 4, NULL, NULL, 'published', '2025-12-24 17:08:01', '2025-12-24 17:08:01', 0, NULL),
(1070, '4c279560-8e46-4c03-a3a5-efcd856406ca', 14, 'Basic Video Editing', 'Learn about Basic Video Editing', 5, NULL, NULL, 'published', '2025-12-24 17:08:03', '2025-12-24 17:08:03', 0, NULL),
(1071, '0bc33c82-5ff9-4252-9286-32b43b356b2c', 14, 'Audio Editing', 'Learn about Audio Editing', 6, NULL, NULL, 'published', '2025-12-24 17:08:05', '2025-12-24 17:08:05', 0, NULL),
(1072, 'bf2f8e34-5269-4a76-92b7-e0bcf00f877a', 14, 'Color Correction', 'Learn about Color Correction', 7, NULL, NULL, 'published', '2025-12-24 17:08:07', '2025-12-24 17:08:07', 0, NULL),
(1073, 'ba970769-d315-44c0-9dad-723af7800057', 14, 'After Effects Introduction', 'Learn about After Effects Introduction', 8, NULL, NULL, 'published', '2025-12-24 17:08:10', '2025-12-24 17:08:10', 0, NULL),
(1074, 'ce61594b-006c-4ae0-96cf-c3361bcaf288', 14, 'Motion Graphics', 'Learn about Motion Graphics', 9, NULL, NULL, 'published', '2025-12-24 17:08:13', '2025-12-24 17:08:13', 0, NULL),
(1075, '38955cca-6717-44af-917b-81efd77e8a11', 14, 'Export and Delivery', 'Learn about Export and Delivery', 10, NULL, NULL, 'published', '2025-12-24 17:08:14', '2025-12-24 17:08:14', 0, NULL),
(1076, 'ed8408de-98ef-49e3-a127-8fcdb19eee3e', 15, 'Microsoft Office Overview', 'Learn about Microsoft Office Overview', 1, NULL, NULL, 'published', '2025-12-24 17:08:16', '2025-12-24 17:08:16', 0, NULL),
(1077, '28451754-04e2-46a6-ab54-33c3d33ef835', 15, 'Word Basics', 'Learn about Word Basics', 2, NULL, NULL, 'published', '2025-12-24 17:08:18', '2025-12-24 17:08:18', 0, NULL),
(1078, '3f0ebb51-e484-4f8f-aa9a-01ac41bfbfdd', 15, 'Word Advanced', 'Learn about Word Advanced', 3, NULL, NULL, 'published', '2025-12-24 17:08:19', '2025-12-24 17:08:19', 0, NULL),
(1079, 'bdc3806f-114e-4bdd-9366-fbff30afba94', 15, 'Excel Basics', 'Learn about Excel Basics', 4, NULL, NULL, 'published', '2025-12-24 17:08:20', '2025-12-24 17:08:20', 0, NULL),
(1080, 'a9b396a9-41c2-46e1-8838-e6372f343ea3', 15, 'Excel Formulas and Functions', 'Learn about Excel Formulas and Functions', 5, NULL, NULL, 'published', '2025-12-24 17:08:21', '2025-12-24 17:08:21', 0, NULL),
(1081, 'df53cac3-3caf-4bfb-b133-76780cb1cabe', 15, 'Excel Charts and Analysis', 'Learn about Excel Charts and Analysis', 6, NULL, NULL, 'published', '2025-12-24 17:08:22', '2025-12-24 17:08:22', 0, NULL),
(1082, '14b392b9-b14f-44b7-b28c-2f3908f84477', 15, 'PowerPoint Basics', 'Learn about PowerPoint Basics', 7, NULL, NULL, 'published', '2025-12-24 17:08:24', '2025-12-24 17:08:24', 0, NULL),
(1083, '80094d04-593b-49f4-a998-c595992856a2', 15, 'PowerPoint Advanced', 'Learn about PowerPoint Advanced', 8, NULL, NULL, 'published', '2025-12-24 17:08:24', '2025-12-24 17:08:24', 0, NULL),
(1084, '894566ad-06d5-4dd8-965b-c6bc0b04c40a', 15, 'Outlook', 'Learn about Outlook', 9, NULL, NULL, 'published', '2025-12-24 17:08:25', '2025-12-24 17:08:25', 0, NULL),
(1085, '0822374e-c4b4-4ef6-a40e-97c96a363ea7', 15, 'Microsoft Teams', 'Learn about Microsoft Teams', 10, NULL, NULL, 'published', '2025-12-24 17:08:26', '2025-12-24 17:08:26', 0, NULL);

-- --------------------------------------------------------

--
-- Stand-in structure for view `module_progress_view`
-- (See below for the actual view)
--
CREATE TABLE `module_progress_view` (
`enrollment_id` int(10) unsigned
,`user_id` int(10) unsigned
,`course_id` int(10) unsigned
,`module_id` int(10) unsigned
,`module_title` varchar(255)
,`order_index` int(10) unsigned
,`total_lessons` bigint(21)
,`completed_lessons` bigint(21)
,`module_progress_percentage` decimal(26,2)
,`total_time_spent_seconds` decimal(32,0)
);

-- --------------------------------------------------------

--
-- Table structure for table `newsletter_subscriptions`
--

CREATE TABLE `newsletter_subscriptions` (
  `id` int(10) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `status` enum('active','unsubscribed','bounced') DEFAULT 'active',
  `token` char(64) NOT NULL COMMENT 'Unsubscribe token',
  `source` varchar(50) DEFAULT 'website',
  `subscribed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `unsubscribed_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `newsletter_subscriptions`
--

INSERT INTO `newsletter_subscriptions` (`id`, `email`, `name`, `status`, `token`, `source`, `subscribed_at`, `unsubscribed_at`) VALUES
(1, 'test@example.com', 'Test User', 'active', '5603b1cebd9dc56be8e7a85d0e0acee92d805093926ecfbd7046f0c2f5fa78eb', 'website', '2025-11-23 01:17:06', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(10) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `type` varchar(50) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`data`)),
  `action_url` varchar(255) DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `uuid`, `user_id`, `type`, `title`, `message`, `data`, `action_url`, `is_read`, `read_at`, `created_at`) VALUES
(1, '6c198536-8ed4-4810-a08c-1f6c1330a3a4', 10, 'application_received', 'Application Received', 'Your application for introduction-to-ai has been received and is under review.', '{\"application_id\":1}', '/application/f6256372-9db7-4e57-9bf4-4235473e2fe0', 0, NULL, '2025-11-12 16:13:14'),
(2, 'e04420ee-54b8-4c61-ab2b-2e380bb51171', 10, 'application_approved', 'Application Approved', 'Congratulations! Your application for introduction-to-ai has been approved. You\'ve been enrolled in Frontend Development Fundamentals.', '{\"application_id\":1,\"course_id\":1}', '/dashboard', 0, NULL, '2025-11-12 16:15:06'),
(3, 'badf9855-2b77-4e21-9151-4a70c4e7a8d2', 10, 'enrollment_created', 'Enrolled in Course', 'You\'ve been enrolled in Frontend Development Fundamentals. Start learning now!', '{\"course_id\":1}', '/courses/frontend-development-fundamentals', 0, NULL, '2025-11-12 16:15:06');

-- --------------------------------------------------------

--
-- Table structure for table `portfolios`
--

CREATE TABLE `portfolios` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `submission_id` int(10) UNSIGNED DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `project_url` varchar(255) DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `technologies` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`technologies`)),
  `is_public` tinyint(1) DEFAULT 1,
  `is_featured` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `portfolio_items`
--

CREATE TABLE `portfolio_items` (
  `id` char(36) NOT NULL DEFAULT uuid(),
  `user_id` int(10) UNSIGNED NOT NULL,
  `submission_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `thumbnail_path` varchar(255) DEFAULT NULL,
  `is_featured` tinyint(1) DEFAULT 0,
  `is_public` tinyint(1) DEFAULT 1,
  `display_order` int(10) UNSIGNED DEFAULT 0,
  `views` int(10) UNSIGNED DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `portfolio_projects`
--

CREATE TABLE `portfolio_projects` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `requirements` text NOT NULL,
  `learning_outcomes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`learning_outcomes`)),
  `rubric` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`rubric`)),
  `estimated_hours` int(11) DEFAULT 20,
  `difficulty` enum('beginner','intermediate','advanced') DEFAULT 'intermediate',
  `technologies` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`technologies`)),
  `resources` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`resources`)),
  `status` enum('draft','published','archived') DEFAULT 'published',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `portfolio_settings`
--

CREATE TABLE `portfolio_settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `bio` text DEFAULT NULL,
  `tagline` varchar(255) DEFAULT NULL,
  `github_url` varchar(255) DEFAULT NULL,
  `linkedin_url` varchar(255) DEFAULT NULL,
  `twitter_url` varchar(255) DEFAULT NULL,
  `website_url` varchar(255) DEFAULT NULL,
  `is_public` tinyint(1) DEFAULT 1,
  `show_badges` tinyint(1) DEFAULT 1,
  `show_certificates` tinyint(1) DEFAULT 1,
  `show_contact` tinyint(1) DEFAULT 1,
  `theme` varchar(50) DEFAULT 'default',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `portfolio_submissions`
--

CREATE TABLE `portfolio_submissions` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `enrollment_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `repository_url` varchar(500) DEFAULT NULL,
  `live_demo_url` varchar(500) DEFAULT NULL,
  `submission_files` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`submission_files`)),
  `technologies_used` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`technologies_used`)),
  `reflection` text DEFAULT NULL,
  `score` int(11) DEFAULT NULL,
  `feedback` text DEFAULT NULL,
  `status` enum('draft','submitted','in_review','approved','revision_needed','featured') DEFAULT 'draft',
  `is_public` tinyint(1) DEFAULT 0,
  `submitted_at` timestamp NULL DEFAULT NULL,
  `reviewed_at` timestamp NULL DEFAULT NULL,
  `reviewed_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `practicals`
--

CREATE TABLE `practicals` (
  `id` int(11) NOT NULL,
  `lesson_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `instructions` text NOT NULL,
  `expected_outcome` text DEFAULT NULL,
  `starter_code` text DEFAULT NULL,
  `solution_code` text DEFAULT NULL,
  `hints` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`hints`)),
  `difficulty` enum('beginner','intermediate','advanced') DEFAULT 'beginner',
  `estimated_time_minutes` int(11) DEFAULT 30,
  `exercise_type` enum('coding','design','written','project','research','hands-on') DEFAULT 'coding',
  `grading_rubric` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`grading_rubric`)),
  `max_points` int(11) DEFAULT 100,
  `passing_score` int(11) DEFAULT 70,
  `allow_ai_hints` tinyint(1) DEFAULT 1,
  `status` enum('draft','published','archived') DEFAULT 'published',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `practical_submissions`
--

CREATE TABLE `practical_submissions` (
  `id` int(11) NOT NULL,
  `practical_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `enrollment_id` int(11) DEFAULT NULL,
  `submitted_code` text DEFAULT NULL,
  `submitted_content` text DEFAULT NULL,
  `file_attachments` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`file_attachments`)),
  `ai_feedback` text DEFAULT NULL,
  `facilitator_feedback` text DEFAULT NULL,
  `score` int(11) DEFAULT NULL,
  `status` enum('draft','submitted','in_review','graded','revision_needed') DEFAULT 'draft',
  `attempts` int(11) DEFAULT 1,
  `time_spent_minutes` int(11) DEFAULT NULL,
  `submitted_at` timestamp NULL DEFAULT NULL,
  `graded_at` timestamp NULL DEFAULT NULL,
  `graded_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(10) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `client_name` varchar(255) DEFAULT NULL,
  `category_id` int(10) UNSIGNED DEFAULT NULL,
  `technologies` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`technologies`)),
  `image` varchar(255) DEFAULT NULL,
  `gallery` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`gallery`)),
  `project_url` varchar(255) DEFAULT NULL,
  `completion_date` date DEFAULT NULL,
  `is_featured` tinyint(1) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `uuid`, `title`, `slug`, `description`, `client_name`, `category_id`, `technologies`, `image`, `gallery`, `project_url`, `completion_date`, `is_featured`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'a3b04713-bfc7-11f0-af10-48ba4e5c5cd8', 'Corporate Website Development', 'corporate-website-development', 'Developed several corporate websites for businesses, ensuring they are responsive and user-friendly with modern design principles.', 'Various Clients', 1, '[\"HTML\", \"CSS\", \"JavaScript\", \"PHP\", \"MySQL\", \"Tailwind CSS\"]', NULL, NULL, NULL, '2024-12-01', 1, 1, '2025-11-12 13:01:01', '2025-11-12 14:42:44'),
(2, 'a3b102ef-bfc7-11f0-af10-48ba4e5c5cd8', 'E-commerce Platform', 'ecommerce-platform', 'Developed e-commerce platforms with integrated payment gateways for online shopping, inventory management, and order tracking.', 'Retail Business', 4, '[\"PHP\", \"Laravel\", \"MySQL\", \"Stripe\", \"PayPal\", \"Vue.js\"]', NULL, NULL, NULL, '2024-11-15', 1, 1, '2025-11-12 13:01:01', '2025-11-12 14:42:44'),
(3, 'a3b105d0-bfc7-11f0-af10-48ba4e5c5cd8', 'Custom Mobile Applications', 'custom-mobile-apps', 'Built Android and iOS apps tailored to specific business needs, providing seamless user experiences and robust functionality.', 'Multiple Clients', 1, '[\"React Native\", \"Flutter\", \"Firebase\", \"Node.js\"]', NULL, NULL, NULL, '2024-10-20', 1, 1, '2025-11-12 13:01:01', '2025-11-12 14:42:45'),
(4, 'a3b10782-bfc7-11f0-af10-48ba4e5c5cd8', 'POS System for Retail', 'pos-system-retail', 'Designed and implemented Point of Sale (POS) systems for local businesses, ensuring efficient transactions and accurate stock management.', 'Local Retail Stores', 1, '[\"PHP\", \"MySQL\", \"JavaScript\", \"Receipt Printing API\"]', NULL, NULL, NULL, '2024-09-30', 0, 1, '2025-11-12 13:01:01', '2025-11-12 14:42:45'),
(5, 'a3b10979-bfc7-11f0-af10-48ba4e5c5cd8', 'Inventory Management Solution', 'inventory-management-solution', 'Developed inventory tracking solutions to help businesses manage their stock, sales, and orders effectively with real-time updates.', 'Wholesale Business', 1, '[\"PHP\", \"Laravel\", \"MySQL\", \"Barcode Scanner Integration\"]', NULL, NULL, NULL, '2024-08-15', 0, 1, '2025-11-12 13:01:01', '2025-11-12 14:42:45'),
(6, 'a3b10b3b-bfc7-11f0-af10-48ba4e5c5cd8', 'CCTV Security System', 'cctv-security-system', 'Installed and set up CCTV systems for various clients, ensuring their homes and businesses are secure with remote monitoring capabilities.', 'Various Clients', 1, '[\"IP Cameras\", \"DVR/NVR\", \"Mobile App Integration\"]', NULL, NULL, NULL, '2024-07-10', 0, 1, '2025-11-12 13:01:01', '2025-11-12 14:42:45'),
(7, 'a3b10cba-bfc7-11f0-af10-48ba4e5c5cd8', 'Network Infrastructure Setup', 'network-infrastructure-setup', 'Successfully completed the installation of network infrastructures for several businesses, ensuring reliable and secure internet connectivity.', 'Corporate Offices', 1, '[\"Cat6 Cabling\", \"WiFi Access Points\", \"Firewall\", \"VPN\"]', NULL, NULL, NULL, '2024-06-20', 0, 1, '2025-11-12 13:01:01', '2025-11-12 14:42:45'),
(8, 'a3b10dc4-bfc7-11f0-af10-48ba4e5c5cd8', 'Barcode Generator System', 'barcode-generator-truandrew', 'Developed a custom Barcode Generator system for Truandrew Natural Market to streamline product labeling and improve inventory management.', 'Truandrew Natural Market', 1, '[\"PHP\", \"MySQL\", \"Barcode Generation Library\", \"PDF Export\"]', NULL, NULL, NULL, '2024-05-15', 1, 1, '2025-11-12 13:01:01', '2025-11-12 14:42:45'),
(9, 'a3b10eb4-bfc7-11f0-af10-48ba4e5c5cd8', 'AI-Based Business Solution', 'ai-business-solution', 'Developed AI-based applications to help businesses integrate intelligent systems into their processes for enhanced efficiency and productivity.', 'Tech Startup', 1, '[\"Python\", \"TensorFlow\", \"Flask\", \"MySQL\", \"OpenAI API\"]', NULL, NULL, NULL, '2024-04-10', 1, 1, '2025-11-12 13:01:01', '2025-11-12 14:42:45');

-- --------------------------------------------------------

--
-- Table structure for table `project_categories`
--

CREATE TABLE `project_categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `color` varchar(50) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `project_categories`
--

INSERT INTO `project_categories` (`id`, `name`, `slug`, `description`, `color`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Web Development', 'web-development', 'Web applications and websites', '#3B82F6', 1, 1, '2025-11-12 14:42:44', '2025-11-12 14:42:44'),
(2, 'Mobile Apps', 'mobile-apps', 'iOS and Android applications', '#8B5CF6', 2, 1, '2025-11-12 14:42:44', '2025-11-12 14:42:44'),
(3, 'AI Solutions', 'ai-solutions', 'Artificial Intelligence projects', '#10B981', 3, 1, '2025-11-12 14:42:44', '2025-11-12 14:42:44'),
(4, 'E-commerce', 'e-commerce', 'Online stores and marketplaces', '#F59E0B', 4, 1, '2025-11-12 14:42:44', '2025-11-12 14:42:44'),
(5, 'Enterprise Software', 'enterprise-software', 'Business and enterprise solutions', '#EF4444', 5, 1, '2025-11-12 14:42:44', '2025-11-12 14:42:44'),
(6, 'Consulting', 'consulting', 'Strategy and consulting projects', '#6B7280', 6, 1, '2025-11-12 14:42:44', '2025-11-12 14:42:44');

-- --------------------------------------------------------

--
-- Table structure for table `quizzes`
--

CREATE TABLE `quizzes` (
  `id` int(11) NOT NULL,
  `lesson_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `quiz_type` enum('lesson_quiz','module_assessment','milestone_test','final_exam') DEFAULT 'lesson_quiz',
  `time_limit_minutes` int(11) DEFAULT 15,
  `max_attempts` int(11) DEFAULT 3,
  `passing_score` int(11) DEFAULT 70,
  `shuffle_questions` tinyint(1) DEFAULT 1,
  `shuffle_answers` tinyint(1) DEFAULT 1,
  `show_correct_answers` tinyint(1) DEFAULT 1,
  `show_explanations` tinyint(1) DEFAULT 1,
  `allow_review` tinyint(1) DEFAULT 1,
  `status` enum('draft','published','archived') DEFAULT 'published',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quiz_attempts`
--

CREATE TABLE `quiz_attempts` (
  `id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `enrollment_id` int(11) DEFAULT NULL,
  `attempt_number` int(11) DEFAULT 1,
  `answers` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`answers`)),
  `score` int(11) DEFAULT NULL,
  `percentage` decimal(5,2) DEFAULT NULL,
  `passed` tinyint(1) DEFAULT 0,
  `time_taken_seconds` int(11) DEFAULT NULL,
  `started_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quiz_questions`
--

CREATE TABLE `quiz_questions` (
  `id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `question_number` int(11) NOT NULL DEFAULT 1,
  `question_type` enum('multiple_choice','true_false','multiple_select','short_answer','code_output','fill_blank') DEFAULT 'multiple_choice',
  `question_text` text NOT NULL,
  `question_code` text DEFAULT NULL,
  `options` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`options`)),
  `correct_answer` text NOT NULL,
  `explanation` text DEFAULT NULL,
  `points` int(11) DEFAULT 1,
  `difficulty` enum('easy','medium','hard') DEFAULT 'medium',
  `tags` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`tags`)),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `remember_tokens`
--

CREATE TABLE `remember_tokens` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `token` varchar(64) NOT NULL,
  `expires_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(10) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `short_description` text DEFAULT NULL,
  `category_id` int(10) UNSIGNED DEFAULT NULL,
  `price_range` varchar(100) DEFAULT NULL,
  `duration` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `features` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`features`)),
  `related_course_id` int(10) UNSIGNED DEFAULT NULL,
  `course_description` text DEFAULT NULL,
  `is_featured` tinyint(1) DEFAULT 0,
  `status` enum('active','inactive','draft') DEFAULT 'active',
  `pricing_info` text DEFAULT NULL,
  `order_index` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `uuid`, `title`, `slug`, `short_description`, `category_id`, `price_range`, `duration`, `description`, `icon`, `image`, `features`, `related_course_id`, `course_description`, `is_featured`, `status`, `pricing_info`, `order_index`, `created_at`, `updated_at`) VALUES
(4, 'a39fa181-bfc7-11f0-af10-48ba4e5c5cd8', 'Mobile & Web Application Development', 'mobile-web-development', 'We create custom mobile apps (Android/iOS) and web applications tailored to meet the needs of businesses and individuals.', NULL, NULL, NULL, '<p>At Nebatech, we specialize in developing cutting-edge mobile and web applications that drive business growth and enhance user experiences. Our team of expert developers uses the latest technologies and frameworks to build scalable, secure, and high-performance applications.</p>\r\n<h3>Our Development Services Include:</h3>\r\n<ul>\r\n<li>Custom Android and iOS mobile applications</li>\r\n<li>Progressive Web Applications (PWA)</li>\r\n<li>Cross-platform mobile development (React Native, Flutter)</li>\r\n<li>Enterprise web applications</li>\r\n<li>E-commerce platforms</li>\r\n<li>API development and integration</li>\r\n<li>Cloud-based solutions</li>\r\n</ul>\r\n<h3>Technologies We Use:</h3>\r\n<p>React, React Native, Flutter, Node.js, PHP, Python, Laravel, Vue.js, Angular, MySQL, MongoDB, PostgreSQL, AWS, Azure</p>', '📱', NULL, '[\"Custom mobile apps for Android and iOS\", \"Responsive web applications\", \"Cross-platform development\", \"API integration\", \"Cloud deployment\", \"Ongoing maintenance and support\"]', NULL, NULL, 0, 'active', 'Contact us for a custom quote based on your project requirements', 1, '2025-11-12 13:01:01', '2025-11-12 13:01:01'),
(5, 'a39fc459-bfc7-11f0-af10-48ba4e5c5cd8', 'Website Design & Development', 'website-design', 'We design and develop responsive and visually appealing websites, ensuring that they are user-friendly and fully optimized.', NULL, NULL, NULL, '<p>Your website is often the first impression potential customers have of your business. We create stunning, professional websites that not only look great but also perform exceptionally well.</p>\r\n<h3>Our Website Services Include:</h3>\r\n<ul>\r\n<li>Custom website design</li>\r\n<li>Responsive and mobile-friendly layouts</li>\r\n<li>Content Management Systems (WordPress, custom CMS)</li>\r\n<li>E-commerce websites with payment integration</li>\r\n<li>SEO optimization</li>\r\n<li>Website maintenance and updates</li>\r\n<li>Website hosting and domain management</li>\r\n</ul>\r\n<h3>Why Choose Our Website Services:</h3>\r\n<ul>\r\n<li>Modern, clean designs that reflect your brand</li>\r\n<li>Fast loading times and optimized performance</li>\r\n<li>SEO-friendly structure</li>\r\n<li>Secure and reliable</li>\r\n<li>Easy to manage and update</li>\r\n</ul>', '🌐', NULL, '[\"Responsive design\", \"SEO optimized\", \"Content Management System\", \"E-commerce integration\", \"Fast loading times\", \"Security features\"]', NULL, NULL, 0, 'active', 'Starting from GHS 2,000 for basic websites', 2, '2025-11-12 13:01:01', '2025-11-12 13:01:01'),
(6, 'a39fc6b6-bfc7-11f0-af10-48ba4e5c5cd8', 'POS System Development', 'pos-system-development', 'We develop custom Point of Sale (POS) systems to streamline your business transactions and inventory management.', NULL, NULL, NULL, '<p>Our custom POS systems are designed to help businesses manage sales, inventory, and customer data efficiently. Whether you run a retail store, restaurant, or service business, we can create a POS solution tailored to your needs.</p>\r\n<h3>POS Features:</h3>\r\n<ul>\r\n<li>Sales transaction processing</li>\r\n<li>Inventory management and tracking</li>\r\n<li>Customer management and loyalty programs</li>\r\n<li>Multiple payment methods (cash, card, mobile money)</li>\r\n<li>Receipt printing and email receipts</li>\r\n<li>Real-time reporting and analytics</li>\r\n<li>Multi-location support</li>\r\n<li>Employee management and permissions</li>\r\n<li>Barcode scanning</li>\r\n</ul>\r\n<h3>Industries We Serve:</h3>\r\n<p>Retail stores, restaurants, pharmacies, supermarkets, salons, service businesses</p>', '💳', NULL, '[\"Custom POS development\", \"Inventory tracking\", \"Sales reporting\", \"Multiple payment methods\", \"Cloud-based or offline\", \"Receipt printing\"]', NULL, NULL, 0, 'active', 'Starting from GHS 3,500', 3, '2025-11-12 13:01:01', '2025-11-12 13:01:01'),
(7, 'a39fc858-bfc7-11f0-af10-48ba4e5c5cd8', 'Inventory Management System', 'inventory-management-system', 'Our inventory management systems help you keep track of your stock levels, orders, sales, and deliveries efficiently.', NULL, NULL, NULL, '<p>Take control of your inventory with our comprehensive inventory management solutions. Our systems help you reduce costs, prevent stockouts, and optimize your supply chain.</p>\r\n<h3>Key Features:</h3>\r\n<ul>\r\n<li>Real-time inventory tracking</li>\r\n<li>Stock level alerts and notifications</li>\r\n<li>Purchase order management</li>\r\n<li>Supplier management</li>\r\n<li>Barcode and QR code generation</li>\r\n<li>Multi-warehouse support</li>\r\n<li>Sales and purchase history</li>\r\n<li>Detailed reporting and analytics</li>\r\n<li>Integration with POS systems</li>\r\n<li>Mobile app access</li>\r\n</ul>\r\n<h3>Benefits:</h3>\r\n<ul>\r\n<li>Reduce inventory costs</li>\r\n<li>Prevent stockouts and overstocking</li>\r\n<li>Improve order accuracy</li>\r\n<li>Save time on manual tracking</li>\r\n<li>Make data-driven decisions</li>\r\n</ul>', '📦', NULL, '[\"Real-time tracking\", \"Stock alerts\", \"Barcode support\", \"Multi-warehouse\", \"Reporting\", \"Mobile access\"]', NULL, NULL, 0, 'active', 'Starting from GHS 4,000', 4, '2025-11-12 13:01:01', '2025-11-12 13:01:01'),
(8, 'a39fc9f0-bfc7-11f0-af10-48ba4e5c5cd8', 'Network Installation & Troubleshooting', 'network-services', 'Nebatech offers professional network setup, installation, and troubleshooting services to keep your systems running smoothly.', NULL, NULL, NULL, '<p>A reliable network infrastructure is essential for any modern business. Our network specialists provide comprehensive network solutions to ensure your business stays connected and productive.</p>\r\n<h3>Network Services:</h3>\r\n<ul>\r\n<li>Network design and planning</li>\r\n<li>LAN/WAN setup and configuration</li>\r\n<li>WiFi installation and optimization</li>\r\n<li>Network security implementation</li>\r\n<li>Firewall configuration</li>\r\n<li>VPN setup for remote access</li>\r\n<li>Network troubleshooting and maintenance</li>\r\n<li>Server installation and configuration</li>\r\n<li>Cable installation (Cat5e, Cat6, Fiber)</li>\r\n<li>Network monitoring and management</li>\r\n</ul>\r\n<h3>We Serve:</h3>\r\n<p>Offices, schools, hotels, hospitals, retail stores, and residential properties</p>', '🔌', NULL, '[\"Network design\", \"WiFi installation\", \"Security setup\", \"Troubleshooting\", \"Server configuration\", \"24/7 support\"]', NULL, NULL, 0, 'active', 'Contact for quote based on project scope', 5, '2025-11-12 13:01:01', '2025-11-12 13:01:01'),
(9, 'a39fcb9a-bfc7-11f0-af10-48ba4e5c5cd8', 'CCTV Camera Installation', 'cctv-installation', 'We provide security solutions with the installation of CCTV cameras to ensure the safety of homes, businesses, and other premises.', NULL, NULL, NULL, '<p>Protect your property with our professional CCTV installation services. We offer complete security camera solutions with high-quality equipment and expert installation.</p>\r\n<h3>CCTV Services:</h3>\r\n<ul>\r\n<li>Security assessment and consultation</li>\r\n<li>HD and 4K camera installation</li>\r\n<li>Indoor and outdoor cameras</li>\r\n<li>Night vision cameras</li>\r\n<li>Motion detection and alerts</li>\r\n<li>Remote viewing via mobile app</li>\r\n<li>DVR/NVR setup and configuration</li>\r\n<li>Cloud storage options</li>\r\n<li>Maintenance and support</li>\r\n</ul>\r\n<h3>Camera Types:</h3>\r\n<ul>\r\n<li>Dome cameras</li>\r\n<li>Bullet cameras</li>\r\n<li>PTZ (Pan-Tilt-Zoom) cameras</li>\r\n<li>IP cameras</li>\r\n<li>Wireless cameras</li>\r\n</ul>\r\n<h3>Applications:</h3>\r\n<p>Homes, offices, retail stores, warehouses, schools, hotels, parking lots</p>', '📹', NULL, '[\"HD/4K cameras\", \"Remote viewing\", \"Night vision\", \"Motion detection\", \"Cloud storage\", \"Professional installation\"]', NULL, NULL, 0, 'active', 'Starting from GHS 1,500 for basic setup', 6, '2025-11-12 13:01:01', '2025-11-12 13:01:01'),
(10, 'a39fcd3a-bfc7-11f0-af10-48ba4e5c5cd8', 'iPhone & Laptop Repairs', 'device-repairs', 'Our expert technicians offer repair services for iPhones and laptops, including hardware and software issues.', NULL, NULL, NULL, '<p>Is your iPhone or laptop giving you trouble? Our certified technicians can diagnose and repair a wide range of hardware and software issues quickly and affordably.</p>\r\n<h3>iPhone Repair Services:</h3>\r\n<ul>\r\n<li>Screen replacement</li>\r\n<li>Battery replacement</li>\r\n<li>Camera repair</li>\r\n<li>Charging port repair</li>\r\n<li>Water damage repair</li>\r\n<li>Software troubleshooting</li>\r\n<li>Data recovery</li>\r\n</ul>\r\n<h3>Laptop Repair Services:</h3>\r\n<ul>\r\n<li>Screen replacement</li>\r\n<li>Keyboard replacement</li>\r\n<li>Battery replacement</li>\r\n<li>Hard drive/SSD upgrade</li>\r\n<li>RAM upgrade</li>\r\n<li>Motherboard repair</li>\r\n<li>Virus removal and software issues</li>\r\n<li>Data recovery</li>\r\n<li>Overheating issues</li>\r\n</ul>\r\n<h3>Brands We Service:</h3>\r\n<p>Apple, HP, Dell, Lenovo, Acer, Asus, Toshiba, Samsung, and more</p>', '🔧', NULL, '[\"iPhone repairs\", \"Laptop repairs\", \"Screen replacement\", \"Battery replacement\", \"Data recovery\", \"Quick turnaround\"]', NULL, NULL, 0, 'active', 'Varies by repair type - Free diagnosis', 7, '2025-11-12 13:01:01', '2025-11-12 13:01:01');

-- --------------------------------------------------------

--
-- Table structure for table `service_categories`
--

CREATE TABLE `service_categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `color` varchar(50) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service_categories`
--

INSERT INTO `service_categories` (`id`, `name`, `slug`, `description`, `icon`, `color`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Web Development', 'web-development', 'Custom websites and web applications', 'code', 'blue', 1, 1, '2025-11-12 12:11:02', '2025-11-12 12:11:02'),
(2, 'Mobile Development', 'mobile-development', 'iOS and Android mobile applications', 'mobile-alt', 'green', 2, 1, '2025-11-12 12:11:02', '2025-11-12 12:11:02'),
(3, 'AI & Machine Learning', 'ai-ml', 'Artificial intelligence and machine learning solutions', 'brain', 'purple', 3, 1, '2025-11-12 12:11:02', '2025-11-12 12:11:02'),
(4, 'Digital Marketing', 'digital-marketing', 'Online marketing and SEO services', 'bullhorn', 'orange', 4, 1, '2025-11-12 12:11:02', '2025-11-12 12:11:02'),
(5, 'Consulting', 'consulting', 'Technology consulting and strategy', 'handshake', 'gray', 5, 1, '2025-11-12 12:11:02', '2025-11-12 12:11:02');

-- --------------------------------------------------------

--
-- Table structure for table `service_requests`
--

CREATE TABLE `service_requests` (
  `id` int(10) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `service_id` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `status` enum('pending','contacted','in_progress','completed','cancelled') DEFAULT 'pending',
  `assigned_to` int(10) UNSIGNED DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_competencies`
--

CREATE TABLE `student_competencies` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `competency_id` int(11) NOT NULL,
  `enrollment_id` int(11) DEFAULT NULL,
  `proficiency_level` enum('not_started','developing','competent','proficient','expert') DEFAULT 'not_started',
  `evidence` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`evidence`)),
  `assessed_at` timestamp NULL DEFAULT NULL,
  `assessed_by` int(11) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `study_sessions`
--

CREATE TABLE `study_sessions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `enrollment_id` int(10) UNSIGNED DEFAULT NULL,
  `session_start` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `session_end` timestamp NULL DEFAULT NULL,
  `duration_seconds` int(10) UNSIGNED DEFAULT 0,
  `lessons_viewed` int(10) UNSIGNED DEFAULT 0,
  `assignments_submitted` int(10) UNSIGNED DEFAULT 0,
  `interactions_count` int(10) UNSIGNED DEFAULT 0,
  `device_type` varchar(50) DEFAULT NULL,
  `browser` varchar(100) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `submissions`
--

CREATE TABLE `submissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `assignment_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `content` longtext DEFAULT NULL,
  `content_type` enum('text','code','file','url') DEFAULT 'text',
  `file_path` varchar(255) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `file_size` int(10) UNSIGNED DEFAULT NULL,
  `repository_url` varchar(500) DEFAULT NULL,
  `ai_score` decimal(5,2) DEFAULT NULL,
  `ai_feedback` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`ai_feedback`)),
  `facilitator_score` decimal(5,2) DEFAULT NULL,
  `facilitator_feedback` text DEFAULT NULL,
  `graded_by` int(10) UNSIGNED DEFAULT NULL,
  `status` enum('pending','graded','revision_needed','verified') DEFAULT 'pending',
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `graded_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` int(10) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `type` enum('service','course','general') NOT NULL,
  `content` text NOT NULL,
  `client_name` varchar(255) NOT NULL,
  `client_position` varchar(255) DEFAULT NULL,
  `client_company` varchar(255) DEFAULT NULL,
  `client_image` varchar(255) DEFAULT NULL,
  `rating` int(11) DEFAULT 5,
  `is_featured` tinyint(1) DEFAULT 0,
  `related_id` int(10) UNSIGNED DEFAULT NULL,
  `status` enum('active','inactive','pending') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `uuid`, `type`, `content`, `client_name`, `client_position`, `client_company`, `client_image`, `rating`, `is_featured`, `related_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'ccbf2730-bfca-11f0-af10-48ba4e5c5cd8', 'general', 'Nebatech\'s innovative approach has revolutionized our learning experience. Their methods feel personalized and genuinely impactful.', 'Alhaj Dr. Tanko Mohammed', 'Education Specialist', NULL, NULL, 5, 1, NULL, 'active', '2025-11-12 13:23:38', '2025-11-12 13:23:38'),
(2, 'ccc061f7-bfca-11f0-af10-48ba4e5c5cd8', 'general', 'Their commitment to excellence has been a game-changer for our construction projects – we now work with renewed passion.', 'Hamdu', 'Construction Manager', NULL, NULL, 5, 1, NULL, 'active', '2025-11-12 13:23:38', '2025-11-12 13:23:38'),
(3, 'ccc06562-bfca-11f0-af10-48ba4e5c5cd8', 'general', 'Professional and reliable – they helped us streamline our operations in ways that truly make a difference.', 'Idris Issah Galadima', 'Business Owner', NULL, NULL, 5, 1, NULL, 'active', '2025-11-12 13:23:38', '2025-11-12 13:23:38'),
(4, 'ccc06750-bfca-11f0-af10-48ba4e5c5cd8', 'general', 'The creative solutions provided have enhanced our brand image significantly. Their service feels personal and innovative.', 'Gladys Utesy', 'Marketing Director', NULL, NULL, 5, 1, NULL, 'active', '2025-11-12 13:23:38', '2025-11-12 13:23:38'),
(5, 'ccc06922-bfca-11f0-af10-48ba4e5c5cd8', 'general', 'Their expert services have given our business a competitive edge. We feel supported every step of the way.', 'Mitchell Kowalski', 'CEO', NULL, NULL, 5, 1, NULL, 'active', '2025-11-12 13:23:38', '2025-11-12 13:23:38'),
(6, 'ccc06aee-bfca-11f0-af10-48ba4e5c5cd8', 'general', 'Outstanding service and excellent support at every turn. We truly feel they care about our success.', 'Alhaji Issah Yakubu', 'Business Executive', NULL, NULL, 5, 1, NULL, 'active', '2025-11-12 13:23:38', '2025-11-12 13:23:38'),
(7, 'ccc06ca1-bfca-11f0-af10-48ba4e5c5cd8', 'general', 'Their dedication to quality has transformed our educational outreach, making every project feel unique and tailored.', 'Florence Pul', 'Education Coordinator', NULL, NULL, 5, 0, NULL, 'active', '2025-11-12 13:23:38', '2025-11-12 13:23:38'),
(8, 'ccc06e37-bfca-11f0-af10-48ba4e5c5cd8', 'general', 'Efficiency and reliability are at the heart of their service – they consistently deliver beyond expectations.', 'Rafic Fuseini', 'Operations Manager', NULL, NULL, 5, 0, NULL, 'active', '2025-11-12 13:23:38', '2025-11-12 13:23:38'),
(9, 'ccc06fea-bfca-11f0-af10-48ba4e5c5cd8', 'general', 'Their innovative solutions have greatly improved our lab operations, making work smoother and more enjoyable.', 'Carolyn Puobebe', 'Lab Director', NULL, NULL, 5, 0, NULL, 'active', '2025-11-12 13:23:38', '2025-11-12 13:23:38'),
(10, 'ccc07196-bfca-11f0-af10-48ba4e5c5cd8', 'general', 'Nebatech\'s expertise has empowered our educational vision and given us a new perspective on growth.', 'Hajia Zulfawu Abdulai', 'School Administrator', NULL, NULL, 5, 0, NULL, 'active', '2025-11-12 13:23:38', '2025-11-12 13:23:38'),
(11, 'ccc07321-bfca-11f0-af10-48ba4e5c5cd8', 'general', 'Their commitment to customer satisfaction is truly unmatched, making every interaction feel personal and thoughtful.', 'Hajia Fadila Abdulai', 'Business Owner', NULL, NULL, 5, 0, NULL, 'active', '2025-11-12 13:23:38', '2025-11-12 13:23:38'),
(12, 'ccc074c1-bfca-11f0-af10-48ba4e5c5cd8', 'general', 'Incredible service and a genuine dedication to quality – they make every project feel uniquely cared for.', 'Hajia Fati Sumani', 'Entrepreneur', NULL, NULL, 5, 0, NULL, 'active', '2025-11-12 13:23:38', '2025-11-12 13:23:38'),
(13, 'ccc0766f-bfca-11f0-af10-48ba4e5c5cd8', 'general', 'Their visionary approach has truly propelled our business forward, inspiring us to achieve new heights.', 'Waltrude Kurugu', 'Business Leader', NULL, NULL, 5, 0, NULL, 'active', '2025-11-12 13:23:38', '2025-11-12 13:23:38');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `role` enum('student','facilitator','admin') DEFAULT 'student',
  `client_type` enum('student','client','both') DEFAULT 'student',
  `corporate_interests` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`corporate_interests`)),
  `preferred_section` enum('academy','corporate','both') DEFAULT 'academy',
  `avatar` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive','suspended') DEFAULT 'active',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `phone` varchar(20) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `github` varchar(100) DEFAULT NULL,
  `linkedin` varchar(100) DEFAULT NULL,
  `twitter` varchar(100) DEFAULT NULL,
  `timezone` varchar(50) DEFAULT 'UTC',
  `language` varchar(10) DEFAULT 'en',
  `email_notifications` tinyint(1) DEFAULT 1,
  `push_notifications` tinyint(1) DEFAULT 0,
  `marketing_emails` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `uuid`, `email`, `password`, `first_name`, `last_name`, `role`, `client_type`, `corporate_interests`, `preferred_section`, `avatar`, `status`, `email_verified_at`, `created_at`, `updated_at`, `phone`, `bio`, `location`, `website`, `github`, `linkedin`, `twitter`, `timezone`, `language`, `email_notifications`, `push_notifications`, `marketing_emails`) VALUES
(1, '494d41ba-a5e8-4450-bc82-1743a2616355', 'facilitator@gmail.com', '$2y$12$m6VwmXATAyGZ6svEcaZ0uO3gXkvd/Ogsj7PPxTKRnlrcG4sUVPLv.', 'Facilitator', 'Facilitator', 'facilitator', 'student', NULL, 'academy', NULL, 'active', NULL, '2025-11-10 09:32:14', '2025-11-12 13:48:47', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'UTC', 'en', 1, 0, 0),
(10, '494d41ba-a5e8-4450-bc82-1743a2616356', 'student@gmail.com', '$2y$12$m6VwmXATAyGZ6svEcaZ0uO3gXkvd/Ogsj7PPxTKRnlrcG4sUVPLv.', 'Student', 'Student', 'student', 'student', NULL, 'academy', 'uploads/avatars/avatar_10_1766512104.png', 'active', NULL, '2025-11-10 09:32:14', '2025-12-23 17:48:24', '', '', '', '', '', '', '', 'UTC', 'en', 1, 0, 0),
(11, '494d41ba-a5e8-4450-bc82-1743a2616357', 'admin@gmail.com', '$2y$12$m6VwmXATAyGZ6svEcaZ0uO3gXkvd/Ogsj7PPxTKRnlrcG4sUVPLv.', 'Admin', 'Admin', 'admin', 'student', NULL, 'academy', NULL, 'active', NULL, '2025-11-10 09:32:14', '2025-11-12 13:48:47', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'UTC', 'en', 1, 0, 0),
(12, '336ce5cc-defd-4935-b876-7af6c1cd8853', 'imabdulhafiz.yussif@gmail.com', '$2y$12$h5A8rMsJh74WCjLDrv7IrulVkw0MpDwrxNeubDhWwOiYJCnJ5CCUC', 'Abdul-Hafiz', 'Yussif', 'student', 'student', NULL, 'academy', NULL, 'active', NULL, '2025-12-20 07:09:19', '2025-12-20 07:09:19', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'UTC', 'en', 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_badges`
--

CREATE TABLE `user_badges` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `badge_id` char(36) NOT NULL,
  `earned_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Additional data about earning (course_id, score, etc.)' CHECK (json_valid(`metadata`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_follows`
--

CREATE TABLE `user_follows` (
  `id` int(10) UNSIGNED NOT NULL,
  `follower_id` int(10) UNSIGNED NOT NULL,
  `following_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_preferences`
--

CREATE TABLE `user_preferences` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `preference_key` varchar(100) NOT NULL,
  `preference_value` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_profiles`
--

CREATE TABLE `user_profiles` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `bio` text DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `github_url` varchar(255) DEFAULT NULL,
  `linkedin_url` varchar(255) DEFAULT NULL,
  `twitter_handle` varchar(100) DEFAULT NULL,
  `skills` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`skills`)),
  `interests` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`interests`)),
  `total_xp` int(10) UNSIGNED DEFAULT 0,
  `current_streak` int(10) UNSIGNED DEFAULT 0,
  `longest_streak` int(10) UNSIGNED DEFAULT 0,
  `last_active_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `xp_transactions`
--

CREATE TABLE `xp_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `amount` int(11) NOT NULL,
  `action` varchar(100) NOT NULL,
  `entity_type` varchar(50) DEFAULT NULL,
  `entity_id` int(10) UNSIGNED DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure for view `course_progress_summary`
--
DROP TABLE IF EXISTS `course_progress_summary`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `course_progress_summary`  AS SELECT `e`.`id` AS `enrollment_id`, `e`.`user_id` AS `user_id`, `e`.`course_id` AS `course_id`, `c`.`title` AS `course_title`, count(distinct `l`.`id`) AS `total_lessons`, count(distinct case when `lp`.`status` = 'completed' then `l`.`id` end) AS `completed_lessons`, count(distinct `m`.`id`) AS `total_modules`, round(count(distinct case when `lp`.`status` = 'completed' then `l`.`id` end) * 100.0 / nullif(count(distinct `l`.`id`),0),2) AS `overall_progress_percentage`, sum(coalesce(`lp`.`time_spent_seconds`,0)) AS `total_time_spent_seconds`, max(`lp`.`last_accessed_at`) AS `last_activity`, min(case when `lp`.`status` = 'in_progress' then `l`.`id` end) AS `resume_lesson_id` FROM ((((`enrollments` `e` join `courses` `c` on(`e`.`course_id` = `c`.`id`)) left join `modules` `m` on(`c`.`id` = `m`.`course_id`)) left join `lessons` `l` on(`m`.`id` = `l`.`module_id`)) left join `lesson_progress` `lp` on(`l`.`id` = `lp`.`lesson_id` and `e`.`user_id` = `lp`.`user_id`)) GROUP BY `e`.`id`, `e`.`user_id`, `e`.`course_id`, `c`.`title` ;

-- --------------------------------------------------------

--
-- Structure for view `module_progress_view`
--
DROP TABLE IF EXISTS `module_progress_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `module_progress_view`  AS SELECT `e`.`id` AS `enrollment_id`, `e`.`user_id` AS `user_id`, `e`.`course_id` AS `course_id`, `m`.`id` AS `module_id`, `m`.`title` AS `module_title`, `m`.`order_index` AS `order_index`, count(distinct `l`.`id`) AS `total_lessons`, count(distinct case when `lp`.`status` = 'completed' then `l`.`id` end) AS `completed_lessons`, round(count(distinct case when `lp`.`status` = 'completed' then `l`.`id` end) * 100.0 / nullif(count(distinct `l`.`id`),0),2) AS `module_progress_percentage`, sum(coalesce(`lp`.`time_spent_seconds`,0)) AS `total_time_spent_seconds` FROM ((((`enrollments` `e` join `courses` `c` on(`e`.`course_id` = `c`.`id`)) join `modules` `m` on(`c`.`id` = `m`.`course_id`)) left join `lessons` `l` on(`m`.`id` = `l`.`module_id`)) left join `lesson_progress` `lp` on(`l`.`id` = `lp`.`lesson_id` and `e`.`user_id` = `lp`.`user_id`)) GROUP BY `e`.`id`, `e`.`user_id`, `e`.`course_id`, `m`.`id`, `m`.`title`, `m`.`order_index` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_action` (`action`),
  ADD KEY `idx_created_at` (`created_at`);

--
-- Indexes for table `admin_action_logs`
--
ALTER TABLE `admin_action_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user` (`user_id`),
  ADD KEY `idx_resource` (`resource_type`,`resource_id`);

--
-- Indexes for table `ai_code_reviews`
--
ALTER TABLE `ai_code_reviews`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uuid` (`uuid`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_lesson_id` (`lesson_id`),
  ADD KEY `idx_language` (`language`);

--
-- Indexes for table `ai_content_embeddings`
--
ALTER TABLE `ai_content_embeddings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_content_chunk` (`content_type`,`content_id`,`chunk_index`),
  ADD KEY `idx_content_type` (`content_type`),
  ADD KEY `idx_content_id` (`content_id`);

--
-- Indexes for table `ai_conversations`
--
ALTER TABLE `ai_conversations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uuid` (`uuid`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_lesson_id` (`lesson_id`),
  ADD KEY `idx_course_id` (`course_id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_created_at` (`created_at`),
  ADD KEY `module_id` (`module_id`);

--
-- Indexes for table `ai_faq_cache`
--
ALTER TABLE `ai_faq_cache`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `question_hash` (`question_hash`),
  ADD KEY `idx_question_hash` (`question_hash`),
  ADD KEY `idx_lesson_id` (`lesson_id`),
  ADD KEY `idx_hit_count` (`hit_count`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `ai_learning_profiles`
--
ALTER TABLE `ai_learning_profiles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `ai_messages`
--
ALTER TABLE `ai_messages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uuid` (`uuid`),
  ADD KEY `idx_conversation_id` (`conversation_id`),
  ADD KEY `idx_role` (`role`),
  ADD KEY `idx_created_at` (`created_at`);

--
-- Indexes for table `ai_practice_problems`
--
ALTER TABLE `ai_practice_problems`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uuid` (`uuid`),
  ADD KEY `idx_lesson_id` (`lesson_id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_problem_type` (`problem_type`),
  ADD KEY `idx_difficulty` (`difficulty`);

--
-- Indexes for table `ai_tutor_conversations`
--
ALTER TABLE `ai_tutor_conversations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_conversations` (`user_id`),
  ADD KEY `idx_session` (`session_id`),
  ADD KEY `idx_context_type` (`context_type`);

--
-- Indexes for table `ai_tutor_hints`
--
ALTER TABLE `ai_tutor_hints`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_practical_hint_level` (`practical_id`,`hint_level`),
  ADD KEY `idx_practical_hints` (`practical_id`);

--
-- Indexes for table `ai_usage_logs`
--
ALTER TABLE `ai_usage_logs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user_date` (`user_id`,`date`),
  ADD KEY `idx_date` (`date`);

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uuid` (`uuid`),
  ADD KEY `reviewed_by` (`reviewed_by`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_program` (`program`),
  ADD KEY `idx_created_at` (`created_at`);

--
-- Indexes for table `application_notes`
--
ALTER TABLE `application_notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_application` (`application_id`);

--
-- Indexes for table `application_timeline`
--
ALTER TABLE `application_timeline`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_application` (`application_id`),
  ADD KEY `idx_actor` (`actor_id`);

--
-- Indexes for table `approval_history`
--
ALTER TABLE `approval_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_entity` (`entity_type`,`entity_id`),
  ADD KEY `idx_admin` (`admin_id`),
  ADD KEY `idx_created` (`created_at`);

--
-- Indexes for table `assignments`
--
ALTER TABLE `assignments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uuid` (`uuid`),
  ADD KEY `idx_lesson_id` (`lesson_id`),
  ADD KEY `idx_ai_feedback_enabled` (`ai_feedback_enabled`);

--
-- Indexes for table `badges`
--
ALTER TABLE `badges`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `blog_categories`
--
ALTER TABLE `blog_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `idx_active` (`is_active`),
  ADD KEY `idx_sort` (`sort_order`);

--
-- Indexes for table `blog_comments`
--
ALTER TABLE `blog_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_post` (`post_id`),
  ADD KEY `idx_user` (`user_id`),
  ADD KEY `idx_parent` (`parent_id`);

--
-- Indexes for table `blog_likes`
--
ALTER TABLE `blog_likes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_like` (`post_id`,`user_id`),
  ADD KEY `idx_user` (`user_id`);

--
-- Indexes for table `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uuid` (`uuid`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `author_id` (`author_id`),
  ADD KEY `idx_slug` (`slug`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_published` (`published_at`),
  ADD KEY `idx_category_id` (`category_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `certificates`
--
ALTER TABLE `certificates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uuid` (`uuid`),
  ADD UNIQUE KEY `certificate_number` (`certificate_number`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_course_id` (`course_id`),
  ADD KEY `idx_certificate_number` (`certificate_number`),
  ADD KEY `idx_revoked_at` (`revoked_at`),
  ADD KEY `idx_revoked_by` (`revoked_by`);

--
-- Indexes for table `cohorts`
--
ALTER TABLE `cohorts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uuid` (`uuid`),
  ADD KEY `idx_facilitator_id` (`facilitator_id`),
  ADD KEY `idx_program` (`program`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_start_date` (`start_date`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `fk_cohorts_approved_by` (`approved_by`),
  ADD KEY `idx_approval_status` (`approval_status`),
  ADD KEY `idx_facilitator_approval` (`facilitator_id`,`approval_status`);

--
-- Indexes for table `cohort_assignments`
--
ALTER TABLE `cohort_assignments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_cohort_assignment` (`cohort_id`,`user_id`),
  ADD KEY `idx_cohort_id` (`cohort_id`),
  ADD KEY `idx_user_id` (`user_id`);

--
-- Indexes for table `cohort_assignment_deadlines`
--
ALTER TABLE `cohort_assignment_deadlines`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_cohort_assignment` (`cohort_id`,`assignment_id`),
  ADD KEY `idx_cohort_id` (`cohort_id`),
  ADD KEY `idx_assignment_id` (`assignment_id`),
  ADD KEY `idx_due_date` (`due_date`);

--
-- Indexes for table `cohort_courses`
--
ALTER TABLE `cohort_courses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_cohort_course` (`cohort_id`,`course_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `cohort_invitations`
--
ALTER TABLE `cohort_invitations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_cohort_user_invitation` (`cohort_id`,`user_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `invited_by` (`invited_by`);

--
-- Indexes for table `cohort_schedules`
--
ALTER TABLE `cohort_schedules`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uuid` (`uuid`),
  ADD KEY `lesson_id` (`lesson_id`),
  ADD KEY `idx_cohort_id` (`cohort_id`),
  ADD KEY `idx_course_id` (`course_id`),
  ADD KEY `idx_scheduled_at` (`scheduled_at`),
  ADD KEY `idx_status` (`status`);

--
-- Indexes for table `community_events`
--
ALTER TABLE `community_events`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uuid` (`uuid`),
  ADD KEY `idx_organizer` (`organizer_id`),
  ADD KEY `idx_status` (`status`);

--
-- Indexes for table `community_resources`
--
ALTER TABLE `community_resources`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uuid` (`uuid`),
  ADD KEY `idx_user` (`user_id`);

--
-- Indexes for table `competencies`
--
ALTER TABLE `competencies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_competency_code` (`course_id`,`competency_code`),
  ADD KEY `idx_course_competencies` (`course_id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uuid` (`uuid`),
  ADD KEY `email` (`email`),
  ADD KEY `status` (`status`),
  ADD KEY `created_at` (`created_at`);

--
-- Indexes for table `contact_submissions`
--
ALTER TABLE `contact_submissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_assigned` (`assigned_to`);

--
-- Indexes for table `content_reports`
--
ALTER TABLE `content_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_reporter` (`reporter_id`),
  ADD KEY `idx_reportable` (`reportable_type`,`reportable_id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uuid` (`uuid`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `facilitator_id` (`facilitator_id`),
  ADD KEY `idx_slug` (`slug`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `fk_courses_approved_by` (`approved_by`),
  ADD KEY `idx_approval_status` (`approval_status`),
  ADD KEY `idx_facilitator_approval` (`facilitator_id`,`approval_status`),
  ADD KEY `fk_courses_category` (`category_id`),
  ADD KEY `fk_parent_course` (`parent_course_id`);

--
-- Indexes for table `course_categories`
--
ALTER TABLE `course_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `cross_promotions`
--
ALTER TABLE `cross_promotions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uuid` (`uuid`),
  ADD KEY `idx_target_section` (`target_section`),
  ADD KEY `idx_target_user` (`target_user_type`),
  ADD KEY `idx_active` (`is_active`),
  ADD KEY `idx_priority` (`priority`);

--
-- Indexes for table `discussion_bookmarks`
--
ALTER TABLE `discussion_bookmarks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_bookmark` (`user_id`,`post_id`);

--
-- Indexes for table `discussion_categories`
--
ALTER TABLE `discussion_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `discussion_comments`
--
ALTER TABLE `discussion_comments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uuid` (`uuid`),
  ADD KEY `idx_post` (`post_id`),
  ADD KEY `idx_user` (`user_id`);

--
-- Indexes for table `discussion_likes`
--
ALTER TABLE `discussion_likes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_like` (`user_id`,`likeable_type`,`likeable_id`);

--
-- Indexes for table `discussion_posts`
--
ALTER TABLE `discussion_posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uuid` (`uuid`),
  ADD KEY `idx_category` (`category_id`),
  ADD KEY `idx_user` (`user_id`);

--
-- Indexes for table `draft_posts`
--
ALTER TABLE `draft_posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user` (`user_id`),
  ADD KEY `idx_type` (`type`);

--
-- Indexes for table `email_logs`
--
ALTER TABLE `email_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_type` (`type`),
  ADD KEY `idx_recipient` (`recipient`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_sent_at` (`sent_at`);

--
-- Indexes for table `email_verifications`
--
ALTER TABLE `email_verifications`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `expires_at` (`expires_at`);

--
-- Indexes for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_enrollment` (`user_id`,`course_id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_course_id` (`course_id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `cohort_id` (`cohort_id`);

--
-- Indexes for table `event_rsvps`
--
ALTER TABLE `event_rsvps`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_rsvp` (`event_id`,`user_id`);

--
-- Indexes for table `learning_goals`
--
ALTER TABLE `learning_goals`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uuid` (`uuid`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_target_date` (`target_date`);

--
-- Indexes for table `learning_objectives`
--
ALTER TABLE `learning_objectives`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_lesson_objective` (`lesson_id`,`objective_number`),
  ADD KEY `idx_lesson_objectives` (`lesson_id`);

--
-- Indexes for table `learning_streaks`
--
ALTER TABLE `learning_streaks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user_streak` (`user_id`),
  ADD KEY `idx_current_streak` (`current_streak_days`),
  ADD KEY `idx_last_activity` (`last_activity_date`);

--
-- Indexes for table `lessons`
--
ALTER TABLE `lessons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uuid` (`uuid`),
  ADD KEY `idx_module_id` (`module_id`),
  ADD KEY `idx_type` (`type`),
  ADD KEY `idx_order` (`order_index`);

--
-- Indexes for table `lesson_progress`
--
ALTER TABLE `lesson_progress`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uuid` (`uuid`),
  ADD UNIQUE KEY `unique_user_lesson` (`user_id`,`lesson_id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_lesson_id` (`lesson_id`),
  ADD KEY `idx_enrollment_id` (`enrollment_id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_last_accessed` (`last_accessed_at`),
  ADD KEY `idx_bookmarked` (`bookmarked`);

--
-- Indexes for table `milestones`
--
ALTER TABLE `milestones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_module_milestones` (`module_id`);

--
-- Indexes for table `milestone_completions`
--
ALTER TABLE `milestone_completions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user_milestone` (`user_id`,`milestone_id`),
  ADD KEY `idx_milestone_completions` (`milestone_id`,`user_id`);

--
-- Indexes for table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uuid` (`uuid`),
  ADD KEY `idx_course_id` (`course_id`),
  ADD KEY `idx_order` (`order_index`);

--
-- Indexes for table `newsletter_subscriptions`
--
ALTER TABLE `newsletter_subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `token` (`token`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uuid` (`uuid`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_type` (`type`),
  ADD KEY `idx_is_read` (`is_read`),
  ADD KEY `idx_created_at` (`created_at`);

--
-- Indexes for table `portfolios`
--
ALTER TABLE `portfolios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `submission_id` (`submission_id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_is_public` (`is_public`);

--
-- Indexes for table `portfolio_items`
--
ALTER TABLE `portfolio_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user` (`user_id`);

--
-- Indexes for table `portfolio_projects`
--
ALTER TABLE `portfolio_projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_course_portfolio` (`course_id`);

--
-- Indexes for table `portfolio_settings`
--
ALTER TABLE `portfolio_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `portfolio_submissions`
--
ALTER TABLE `portfolio_submissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_project_submissions` (`project_id`,`user_id`),
  ADD KEY `idx_user_portfolio` (`user_id`);

--
-- Indexes for table `practicals`
--
ALTER TABLE `practicals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_lesson_practicals` (`lesson_id`),
  ADD KEY `idx_practical_type` (`exercise_type`);

--
-- Indexes for table `practical_submissions`
--
ALTER TABLE `practical_submissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_practical_submissions` (`practical_id`,`user_id`),
  ADD KEY `idx_user_submissions` (`user_id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uuid` (`uuid`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `idx_slug` (`slug`),
  ADD KEY `idx_featured` (`is_featured`),
  ADD KEY `idx_active` (`is_active`),
  ADD KEY `idx_category_id` (`category_id`);

--
-- Indexes for table `project_categories`
--
ALTER TABLE `project_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `idx_active` (`is_active`),
  ADD KEY `idx_sort` (`sort_order`);

--
-- Indexes for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_lesson_quiz` (`lesson_id`),
  ADD KEY `idx_quiz_type` (`quiz_type`);

--
-- Indexes for table `quiz_attempts`
--
ALTER TABLE `quiz_attempts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_quiz_attempts` (`quiz_id`,`user_id`),
  ADD KEY `idx_user_quiz_attempts` (`user_id`);

--
-- Indexes for table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_quiz_questions` (`quiz_id`),
  ADD KEY `idx_question_type` (`question_type`);

--
-- Indexes for table `remember_tokens`
--
ALTER TABLE `remember_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `expires_at` (`expires_at`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uuid` (`uuid`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `idx_slug` (`slug`),
  ADD KEY `idx_order` (`order_index`),
  ADD KEY `idx_category` (`category_id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_featured` (`is_featured`);

--
-- Indexes for table `service_categories`
--
ALTER TABLE `service_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `service_requests`
--
ALTER TABLE `service_requests`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uuid` (`uuid`),
  ADD KEY `service_id` (`service_id`),
  ADD KEY `assigned_to` (`assigned_to`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_created` (`created_at`);

--
-- Indexes for table `student_competencies`
--
ALTER TABLE `student_competencies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_student_competency` (`user_id`,`competency_id`),
  ADD KEY `idx_student_competencies` (`user_id`);

--
-- Indexes for table `study_sessions`
--
ALTER TABLE `study_sessions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uuid` (`uuid`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_enrollment_id` (`enrollment_id`),
  ADD KEY `idx_session_start` (`session_start`),
  ADD KEY `idx_duration` (`duration_seconds`);

--
-- Indexes for table `submissions`
--
ALTER TABLE `submissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uuid` (`uuid`),
  ADD KEY `idx_assignment_id` (`assignment_id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_content_type` (`content_type`),
  ADD KEY `idx_graded_by` (`graded_by`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uuid` (`uuid`),
  ADD KEY `idx_type` (`type`),
  ADD KEY `idx_featured` (`is_featured`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_related` (`related_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uuid` (`uuid`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_email` (`email`),
  ADD KEY `idx_role` (`role`),
  ADD KEY `idx_status` (`status`);

--
-- Indexes for table `user_badges`
--
ALTER TABLE `user_badges`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user_badge` (`user_id`,`badge_id`);

--
-- Indexes for table `user_follows`
--
ALTER TABLE `user_follows`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_follow` (`follower_id`,`following_id`);

--
-- Indexes for table `user_preferences`
--
ALTER TABLE `user_preferences`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user_preference` (`user_id`,`preference_key`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_preference_key` (`preference_key`);

--
-- Indexes for table `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `xp_transactions`
--
ALTER TABLE `xp_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_action_logs`
--
ALTER TABLE `admin_action_logs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ai_code_reviews`
--
ALTER TABLE `ai_code_reviews`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ai_content_embeddings`
--
ALTER TABLE `ai_content_embeddings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ai_conversations`
--
ALTER TABLE `ai_conversations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ai_faq_cache`
--
ALTER TABLE `ai_faq_cache`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ai_learning_profiles`
--
ALTER TABLE `ai_learning_profiles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ai_messages`
--
ALTER TABLE `ai_messages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ai_practice_problems`
--
ALTER TABLE `ai_practice_problems`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ai_tutor_conversations`
--
ALTER TABLE `ai_tutor_conversations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ai_tutor_hints`
--
ALTER TABLE `ai_tutor_hints`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ai_usage_logs`
--
ALTER TABLE `ai_usage_logs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `application_notes`
--
ALTER TABLE `application_notes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `application_timeline`
--
ALTER TABLE `application_timeline`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `approval_history`
--
ALTER TABLE `approval_history`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assignments`
--
ALTER TABLE `assignments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `blog_categories`
--
ALTER TABLE `blog_categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `blog_comments`
--
ALTER TABLE `blog_comments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blog_likes`
--
ALTER TABLE `blog_likes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blog_posts`
--
ALTER TABLE `blog_posts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `certificates`
--
ALTER TABLE `certificates`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cohorts`
--
ALTER TABLE `cohorts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cohort_assignments`
--
ALTER TABLE `cohort_assignments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cohort_assignment_deadlines`
--
ALTER TABLE `cohort_assignment_deadlines`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cohort_courses`
--
ALTER TABLE `cohort_courses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cohort_invitations`
--
ALTER TABLE `cohort_invitations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cohort_schedules`
--
ALTER TABLE `cohort_schedules`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `community_events`
--
ALTER TABLE `community_events`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `community_resources`
--
ALTER TABLE `community_resources`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `competencies`
--
ALTER TABLE `competencies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contact_submissions`
--
ALTER TABLE `contact_submissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `content_reports`
--
ALTER TABLE `content_reports`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `course_categories`
--
ALTER TABLE `course_categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `cross_promotions`
--
ALTER TABLE `cross_promotions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `discussion_bookmarks`
--
ALTER TABLE `discussion_bookmarks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `discussion_categories`
--
ALTER TABLE `discussion_categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `discussion_comments`
--
ALTER TABLE `discussion_comments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `discussion_likes`
--
ALTER TABLE `discussion_likes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `discussion_posts`
--
ALTER TABLE `discussion_posts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `draft_posts`
--
ALTER TABLE `draft_posts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `email_logs`
--
ALTER TABLE `email_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `email_verifications`
--
ALTER TABLE `email_verifications`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `event_rsvps`
--
ALTER TABLE `event_rsvps`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `learning_goals`
--
ALTER TABLE `learning_goals`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `learning_objectives`
--
ALTER TABLE `learning_objectives`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `learning_streaks`
--
ALTER TABLE `learning_streaks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lessons`
--
ALTER TABLE `lessons`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4267;

--
-- AUTO_INCREMENT for table `lesson_progress`
--
ALTER TABLE `lesson_progress`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `milestones`
--
ALTER TABLE `milestones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `milestone_completions`
--
ALTER TABLE `milestone_completions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1086;

--
-- AUTO_INCREMENT for table `newsletter_subscriptions`
--
ALTER TABLE `newsletter_subscriptions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `portfolios`
--
ALTER TABLE `portfolios`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `portfolio_projects`
--
ALTER TABLE `portfolio_projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `portfolio_settings`
--
ALTER TABLE `portfolio_settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `portfolio_submissions`
--
ALTER TABLE `portfolio_submissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `practicals`
--
ALTER TABLE `practicals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `practical_submissions`
--
ALTER TABLE `practical_submissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `project_categories`
--
ALTER TABLE `project_categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quiz_attempts`
--
ALTER TABLE `quiz_attempts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `remember_tokens`
--
ALTER TABLE `remember_tokens`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `service_categories`
--
ALTER TABLE `service_categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `service_requests`
--
ALTER TABLE `service_requests`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student_competencies`
--
ALTER TABLE `student_competencies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `study_sessions`
--
ALTER TABLE `study_sessions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `submissions`
--
ALTER TABLE `submissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `user_badges`
--
ALTER TABLE `user_badges`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_follows`
--
ALTER TABLE `user_follows`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_preferences`
--
ALTER TABLE `user_preferences`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_profiles`
--
ALTER TABLE `user_profiles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `xp_transactions`
--
ALTER TABLE `xp_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `ai_code_reviews`
--
ALTER TABLE `ai_code_reviews`
  ADD CONSTRAINT `ai_code_reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ai_code_reviews_ibfk_2` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `ai_conversations`
--
ALTER TABLE `ai_conversations`
  ADD CONSTRAINT `ai_conversations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ai_conversations_ibfk_2` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ai_conversations_ibfk_3` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ai_conversations_ibfk_4` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `ai_faq_cache`
--
ALTER TABLE `ai_faq_cache`
  ADD CONSTRAINT `ai_faq_cache_ibfk_1` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ai_faq_cache_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `ai_learning_profiles`
--
ALTER TABLE `ai_learning_profiles`
  ADD CONSTRAINT `ai_learning_profiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ai_messages`
--
ALTER TABLE `ai_messages`
  ADD CONSTRAINT `ai_messages_ibfk_1` FOREIGN KEY (`conversation_id`) REFERENCES `ai_conversations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ai_practice_problems`
--
ALTER TABLE `ai_practice_problems`
  ADD CONSTRAINT `ai_practice_problems_ibfk_1` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ai_practice_problems_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ai_usage_logs`
--
ALTER TABLE `ai_usage_logs`
  ADD CONSTRAINT `ai_usage_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `applications`
--
ALTER TABLE `applications`
  ADD CONSTRAINT `applications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `applications_ibfk_2` FOREIGN KEY (`reviewed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `approval_history`
--
ALTER TABLE `approval_history`
  ADD CONSTRAINT `approval_history_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `assignments`
--
ALTER TABLE `assignments`
  ADD CONSTRAINT `assignments_ibfk_1` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD CONSTRAINT `blog_posts_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_blog_posts_category` FOREIGN KEY (`category_id`) REFERENCES `blog_categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `certificates`
--
ALTER TABLE `certificates`
  ADD CONSTRAINT `certificates_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `certificates_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `certificates_ibfk_3` FOREIGN KEY (`revoked_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `cohorts`
--
ALTER TABLE `cohorts`
  ADD CONSTRAINT `cohorts_ibfk_1` FOREIGN KEY (`facilitator_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `cohorts_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_cohorts_approved_by` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `cohort_assignments`
--
ALTER TABLE `cohort_assignments`
  ADD CONSTRAINT `cohort_assignments_ibfk_1` FOREIGN KEY (`cohort_id`) REFERENCES `cohorts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cohort_assignments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cohort_assignment_deadlines`
--
ALTER TABLE `cohort_assignment_deadlines`
  ADD CONSTRAINT `cohort_assignment_deadlines_ibfk_1` FOREIGN KEY (`cohort_id`) REFERENCES `cohorts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cohort_assignment_deadlines_ibfk_2` FOREIGN KEY (`assignment_id`) REFERENCES `assignments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cohort_courses`
--
ALTER TABLE `cohort_courses`
  ADD CONSTRAINT `cohort_courses_ibfk_1` FOREIGN KEY (`cohort_id`) REFERENCES `cohorts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cohort_courses_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cohort_invitations`
--
ALTER TABLE `cohort_invitations`
  ADD CONSTRAINT `cohort_invitations_ibfk_1` FOREIGN KEY (`cohort_id`) REFERENCES `cohorts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cohort_invitations_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cohort_invitations_ibfk_3` FOREIGN KEY (`invited_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cohort_schedules`
--
ALTER TABLE `cohort_schedules`
  ADD CONSTRAINT `cohort_schedules_ibfk_1` FOREIGN KEY (`cohort_id`) REFERENCES `cohorts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cohort_schedules_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `cohort_schedules_ibfk_3` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`facilitator_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_courses_approved_by` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_courses_category` FOREIGN KEY (`category_id`) REFERENCES `course_categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_parent_course` FOREIGN KEY (`parent_course_id`) REFERENCES `courses` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD CONSTRAINT `enrollments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `enrollments_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `enrollments_ibfk_3` FOREIGN KEY (`cohort_id`) REFERENCES `cohorts` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `learning_goals`
--
ALTER TABLE `learning_goals`
  ADD CONSTRAINT `learning_goals_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `learning_streaks`
--
ALTER TABLE `learning_streaks`
  ADD CONSTRAINT `learning_streaks_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lessons`
--
ALTER TABLE `lessons`
  ADD CONSTRAINT `lessons_ibfk_1` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lesson_progress`
--
ALTER TABLE `lesson_progress`
  ADD CONSTRAINT `lesson_progress_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `lesson_progress_ibfk_2` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `lesson_progress_ibfk_3` FOREIGN KEY (`enrollment_id`) REFERENCES `enrollments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `modules`
--
ALTER TABLE `modules`
  ADD CONSTRAINT `modules_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `portfolios`
--
ALTER TABLE `portfolios`
  ADD CONSTRAINT `portfolios_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `portfolios_ibfk_2` FOREIGN KEY (`submission_id`) REFERENCES `submissions` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `fk_projects_category` FOREIGN KEY (`category_id`) REFERENCES `project_categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `fk_services_category` FOREIGN KEY (`category_id`) REFERENCES `service_categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `service_requests`
--
ALTER TABLE `service_requests`
  ADD CONSTRAINT `service_requests_ibfk_1` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `service_requests_ibfk_2` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `study_sessions`
--
ALTER TABLE `study_sessions`
  ADD CONSTRAINT `study_sessions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `study_sessions_ibfk_2` FOREIGN KEY (`enrollment_id`) REFERENCES `enrollments` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `submissions`
--
ALTER TABLE `submissions`
  ADD CONSTRAINT `submissions_ibfk_1` FOREIGN KEY (`assignment_id`) REFERENCES `assignments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `submissions_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `submissions_ibfk_3` FOREIGN KEY (`graded_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `user_preferences`
--
ALTER TABLE `user_preferences`
  ADD CONSTRAINT `user_preferences_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
