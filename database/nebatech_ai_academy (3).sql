-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 20, 2025 at 07:42 PM
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
  `facilitator_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `uuid`, `title`, `slug`, `description`, `category_id`, `related_service_id`, `service_description`, `level`, `duration_hours`, `thumbnail`, `facilitator_id`, `status`, `approval_status`, `availability`, `is_bundle`, `parent_course_id`, `rejection_reason`, `approved_by`, `approved_at`, `ai_generated`, `created_at`, `updated_at`, `enrollment_count`, `rating`, `card_color_from`, `card_color_to`, `card_modules`, `card_features`, `card_duration`, `card_icon`, `instructor_name`, `review_count`, `is_new`, `category`, `price`, `facilitator_name`) VALUES
(3, '944c57ba-dd80-11f0-ab86-f48e38a80c71', 'HTML & CSS Fundamentals', 'html-css-fundamentals', 'Learn the building blocks of web development with HTML5 and CSS3.', NULL, NULL, NULL, 'beginner', 40, NULL, NULL, 'published', 'draft', 'both', 0, 22, NULL, NULL, NULL, 0, '2025-12-20 08:48:01', '2025-12-20 09:02:15', 3500, 4.70, 'from-orange-500', 'to-orange-600', 8, 'Hands-on projects', '40 hours', 'fas fa-code', 'Nebatech Team', 2845, 0, 'Development', 590.00, 'Sarah Chen'),
(4, '944f3395-dd80-11f0-ab86-f48e38a80c71', 'JavaScript Essentials', 'javascript-essentials', 'Master JavaScript from basics to advanced concepts and ES6+ features.', NULL, NULL, NULL, 'beginner', 60, NULL, NULL, 'published', 'draft', 'both', 0, 22, NULL, NULL, NULL, 0, '2025-12-20 08:48:01', '2025-12-20 09:02:15', 5200, 4.80, 'from-yellow-500', 'to-yellow-600', 12, 'Interactive coding', '60 hours', 'fab fa-js', 'Nebatech Team', 4321, 0, 'Development', 950.00, 'Sarah Chen'),
(5, '944f37b2-dd80-11f0-ab86-f48e38a80c71', 'React.js Complete Guide', 'react-js-complete-guide', 'Build powerful web applications with React, Hooks, and modern patterns.', NULL, NULL, NULL, 'intermediate', 80, NULL, NULL, 'published', 'draft', 'both', 0, 22, NULL, NULL, NULL, 0, '2025-12-20 08:48:01', '2025-12-20 09:02:15', 4800, 4.90, 'from-cyan-500', 'to-blue-600', 15, 'Real-world projects', '80 hours', 'fab fa-react', 'Nebatech Team', 3567, 0, 'Development', 1550.00, 'Sarah Chen'),
(6, '944f39b6-dd80-11f0-ab86-f48e38a80c71', 'Vue.js Mastery', 'vue-js-mastery', 'Learn Vue 3, Composition API, Vuex, and build modern SPAs.', NULL, NULL, NULL, 'intermediate', 70, NULL, NULL, 'published', 'draft', 'both', 0, 22, NULL, NULL, NULL, 0, '2025-12-20 08:48:01', '2025-12-20 09:02:15', 3200, 4.60, 'from-green-500', 'to-green-600', 14, 'Build SPAs', '70 hours', 'fab fa-vuejs', 'Nebatech Team', 1940, 0, 'Development', 1430.00, 'Sarah Chen'),
(7, '944f3e77-dd80-11f0-ab86-f48e38a80c71', 'Tailwind CSS Fundamentals', 'tailwind-css-fundamentals', 'Build modern UIs rapidly with utility-first CSS framework.', NULL, NULL, NULL, 'beginner', 35, NULL, NULL, 'published', 'draft', 'both', 0, 22, NULL, NULL, NULL, 0, '2025-12-20 08:48:01', '2025-12-20 09:02:15', 2800, 4.70, 'from-teal-500', 'to-cyan-600', 7, 'Utility-first CSS', '35 hours', 'fas fa-palette', 'Nebatech Team', 2145, 0, 'Development', 710.00, 'Sarah Chen'),
(8, '944f405a-dd80-11f0-ab86-f48e38a80c71', 'Next.js Full Course', 'next-js-full-course', 'Build production-ready React apps with SSR, SSG, and API routes.', NULL, NULL, NULL, 'advanced', 90, NULL, NULL, 'published', 'draft', 'both', 0, 22, NULL, NULL, NULL, 0, '2025-12-20 08:48:01', '2025-12-20 09:02:15', 2500, 4.90, 'from-gray-800', 'to-black', 18, 'Production-ready apps', '90 hours', 'fas fa-layer-group', 'Nebatech Team', 1680, 0, 'Development', 1790.00, 'Sarah Chen'),
(9, '945f36dc-dd80-11f0-ab86-f48e38a80c71', 'Node.js Fundamentals', 'node-js-fundamentals', 'Build scalable server-side applications with Node.js and Express.', NULL, NULL, NULL, 'beginner', 50, NULL, NULL, 'published', 'draft', 'both', 0, 23, NULL, NULL, NULL, 0, '2025-12-20 08:48:01', '2025-12-20 09:02:15', 4200, 4.70, 'from-green-600', 'to-green-700', 10, 'RESTful APIs', '50 hours', 'fab fa-node-js', 'Nebatech Team', 3145, 0, 'Development', 890.00, 'Michael Roberts'),
(10, '945f5c15-dd80-11f0-ab86-f48e38a80c71', 'Python Backend Development', 'python-backend-development', 'Master Python, Django, and Flask for web development.', NULL, NULL, NULL, 'beginner', 60, NULL, NULL, 'published', 'draft', 'both', 0, 23, NULL, NULL, NULL, 0, '2025-12-20 08:48:01', '2025-12-20 09:02:15', 5100, 4.80, 'from-blue-600', 'to-indigo-700', 12, 'Web frameworks', '60 hours', 'fab fa-python', 'Nebatech Team', 4235, 0, 'Development', 1050.00, 'Michael Roberts'),
(11, '945f605e-dd80-11f0-ab86-f48e38a80c71', 'PHP & Laravel Mastery', 'php-laravel-mastery', 'Build robust web applications with PHP and Laravel framework.', NULL, NULL, NULL, 'intermediate', 70, NULL, NULL, 'published', 'draft', 'both', 0, 23, NULL, NULL, NULL, 0, '2025-12-20 08:48:01', '2025-12-20 09:02:15', 3800, 4.60, 'from-purple-600', 'to-pink-600', 14, 'MVC architecture', '70 hours', 'fab fa-php', 'Nebatech Team', 2987, 0, 'Development', 1180.00, 'Michael Roberts'),
(12, '945f649f-dd80-11f0-ab86-f48e38a80c71', 'RESTful API Development', 'restful-api-development', 'Design and build scalable REST APIs with best practices.', NULL, NULL, NULL, 'intermediate', 45, NULL, NULL, 'published', 'draft', 'both', 0, 23, NULL, NULL, NULL, 0, '2025-12-20 08:48:01', '2025-12-20 09:02:15', 3500, 4.70, 'from-orange-600', 'to-red-600', 9, 'API design patterns', '45 hours', 'fas fa-server', 'Nebatech Team', 2654, 0, 'Development', 780.00, 'Michael Roberts'),
(13, '945f6822-dd80-11f0-ab86-f48e38a80c71', 'GraphQL Complete Guide', 'graphql-complete-guide', 'Master GraphQL for modern API development.', NULL, NULL, NULL, 'advanced', 40, NULL, NULL, 'published', 'draft', 'both', 0, 23, NULL, NULL, NULL, 0, '2025-12-20 08:48:01', '2025-12-20 09:02:15', 2200, 4.80, 'from-pink-600', 'to-purple-700', 8, 'Modern APIs', '40 hours', 'fas fa-project-diagram', 'Nebatech Team', 1876, 0, 'Development', 950.00, 'Michael Roberts'),
(14, '945f7139-dd80-11f0-ab86-f48e38a80c71', 'Microservices Architecture', 'microservices-architecture', 'Build and deploy microservices with Docker and Kubernetes.', NULL, NULL, NULL, 'advanced', 80, NULL, NULL, 'published', 'draft', 'both', 0, 23, NULL, NULL, NULL, 0, '2025-12-20 08:48:01', '2025-12-20 09:02:15', 1900, 4.90, 'from-indigo-700', 'to-blue-800', 16, 'Cloud-native apps', '80 hours', 'fas fa-cubes', 'Nebatech Team', 1543, 0, 'Development', 1850.00, 'Michael Roberts'),
(15, '946b112b-dd80-11f0-ab86-f48e38a80c71', 'SQL Mastery', 'sql-mastery', 'Master SQL from basics to advanced queries and optimization.', NULL, NULL, NULL, 'beginner', 45, NULL, NULL, 'published', 'draft', 'both', 0, 24, NULL, NULL, NULL, 0, '2025-12-20 08:48:01', '2025-12-20 09:02:15', 4500, 4.70, 'from-blue-600', 'to-blue-700', 9, 'Query optimization', '45 hours', 'fas fa-database', 'Nebatech Team', 3421, 0, 'Development', 720.00, 'Emily Davis'),
(16, '946d40b1-dd80-11f0-ab86-f48e38a80c71', 'MySQL Administration', 'mysql-administration', 'Learn MySQL database administration, performance tuning, and security.', NULL, NULL, NULL, 'intermediate', 50, NULL, NULL, 'published', 'draft', 'both', 0, 24, NULL, NULL, NULL, 0, '2025-12-20 08:48:01', '2025-12-20 09:02:15', 2800, 4.60, 'from-orange-600', 'to-orange-700', 10, 'Performance tuning', '50 hours', 'fas fa-cog', 'Nebatech Team', 2145, 0, 'Development', 850.00, 'Emily Davis'),
(17, '946d455f-dd80-11f0-ab86-f48e38a80c71', 'MongoDB Complete Guide', 'mongodb-complete-guide', 'Master NoSQL with MongoDB for modern applications.', NULL, NULL, NULL, 'intermediate', 40, NULL, NULL, 'published', 'draft', 'both', 0, 24, NULL, NULL, NULL, 0, '2025-12-20 08:48:01', '2025-12-20 09:02:15', 3200, 4.80, 'from-green-600', 'to-green-700', 8, 'NoSQL design', '40 hours', 'fas fa-leaf', 'Nebatech Team', 2567, 0, 'Development', 950.00, 'Emily Davis'),
(18, '946d4919-dd80-11f0-ab86-f48e38a80c71', 'PostgreSQL Advanced', 'postgresql-advanced', 'Advanced PostgreSQL features and performance optimization.', NULL, NULL, NULL, 'advanced', 35, NULL, NULL, 'published', 'draft', 'both', 0, 24, NULL, NULL, NULL, 0, '2025-12-20 08:48:01', '2025-12-20 09:02:15', 1800, 4.70, 'from-blue-700', 'to-indigo-800', 7, 'Advanced features', '35 hours', 'fas fa-elephant', 'Nebatech Team', 1432, 0, 'Development', 780.00, 'Emily Davis'),
(19, '9476eaa5-dd80-11f0-ab86-f48e38a80c71', 'Computer Basics', 'computer-basics', 'Essential computer skills for beginners.', NULL, NULL, NULL, 'beginner', 20, NULL, NULL, 'published', 'draft', 'both', 0, 25, NULL, NULL, NULL, 0, '2025-12-20 08:48:02', '2025-12-20 09:02:15', 5200, 4.50, 'from-blue-500', 'to-blue-600', 4, 'Hands-on practice', '20 hours', 'fas fa-desktop', 'Nebatech Team', 4123, 0, 'Office Skills', 350.00, 'Jessica Turner'),
(20, '947711d1-dd80-11f0-ab86-f48e38a80c71', 'Internet & Email Skills', 'internet-email-skills', 'Master web browsing, email, and online safety.', NULL, NULL, NULL, 'beginner', 15, NULL, NULL, 'published', 'draft', 'both', 0, 25, NULL, NULL, NULL, 0, '2025-12-20 08:48:02', '2025-12-20 09:02:15', 4800, 4.60, 'from-green-500', 'to-green-600', 3, 'Online safety', '15 hours', 'fas fa-globe', 'Nebatech Team', 3845, 0, 'Office Skills', 290.00, 'Jessica Turner'),
(21, '9477160f-dd80-11f0-ab86-f48e38a80c71', 'Digital Communication', 'digital-communication', 'Effective digital communication and collaboration tools.', NULL, NULL, NULL, 'beginner', 18, NULL, NULL, 'published', 'draft', 'both', 0, 25, NULL, NULL, NULL, 0, '2025-12-20 08:48:02', '2025-12-20 09:02:15', 3900, 4.70, 'from-purple-500', 'to-purple-600', 4, 'Collaboration tools', '18 hours', 'fas fa-comments', 'Nebatech Team', 3124, 0, 'Office Skills', 330.00, 'Jessica Turner'),
(22, '8669331e-dd82-11f0-ab86-f48e38a80c71', 'Frontend Development', 'frontend-development', 'Master the art of building stunning, responsive user interfaces. Learn HTML, CSS, JavaScript, React, Vue, and modern frontend technologies.', NULL, NULL, NULL, 'beginner', 325, NULL, NULL, 'published', 'draft', 'both', 1, NULL, NULL, NULL, NULL, 0, '2025-12-20 09:01:57', '2025-12-20 09:01:57', 0, 0.00, 'from-blue-600', 'to-blue-800', 10, 'Hands-on Projects', NULL, 'fas fa-code', 'Nebatech Team', 0, 0, 'Development', 4999.00, NULL),
(23, '866b2b18-dd82-11f0-ab86-f48e38a80c71', 'Backend Development', 'backend-development', 'Build powerful server-side applications. Master Node.js, Python, PHP, APIs, and microservices architecture.', NULL, NULL, NULL, 'beginner', 345, NULL, NULL, 'published', 'draft', 'both', 1, NULL, NULL, NULL, NULL, 0, '2025-12-20 09:01:57', '2025-12-20 09:01:57', 0, 0.00, 'from-green-600', 'to-green-800', 10, 'Hands-on Projects', NULL, 'fas fa-server', 'Nebatech Team', 0, 0, 'Development', 5499.00, NULL),
(24, '866b3276-dd82-11f0-ab86-f48e38a80c71', 'Database Development', 'database-development', 'Master database design, SQL, NoSQL, and database administration for modern applications.', NULL, NULL, NULL, 'beginner', 170, NULL, NULL, 'published', 'draft', 'both', 1, NULL, NULL, NULL, NULL, 0, '2025-12-20 09:01:57', '2025-12-20 09:01:57', 0, 0.00, 'from-orange-500', 'to-orange-700', 10, 'Hands-on Projects', NULL, 'fas fa-database', 'Nebatech Team', 0, 0, 'Development', 2999.00, NULL),
(25, '866b35e5-dd82-11f0-ab86-f48e38a80c71', 'Digital Literacy', 'digital-literacy', 'Essential computer and internet skills for the modern digital world.', NULL, NULL, NULL, 'beginner', 53, NULL, NULL, 'published', 'draft', 'both', 1, NULL, NULL, NULL, NULL, 0, '2025-12-20 09:01:57', '2025-12-20 09:01:57', 0, 0.00, 'from-purple-500', 'to-purple-700', 10, 'Hands-on Projects', NULL, 'fas fa-laptop', 'Nebatech Team', 0, 0, 'Office Skills', 899.00, NULL),
(34, 'eff306dc-dd84-11f0-ab86-f48e38a80c71', 'Full-Stack Development', 'fullstack-development', 'Complete web development from front-end to back-end. Master both client and server-side technologies.', NULL, NULL, NULL, 'intermediate', 120, NULL, NULL, 'published', 'draft', 'both', 1, NULL, NULL, NULL, NULL, 0, '2025-12-20 09:19:13', '2025-12-20 09:24:16', 0, 0.00, 'from-purple-500', 'to-purple-700', 10, 'Complete Full-Stack Skills', NULL, 'M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1', 'Nebatech Team', 0, 0, 'Web Development', 1800.00, NULL),
(35, 'eff5ac5a-dd84-11f0-ab86-f48e38a80c71', 'Introduction to AI', 'introduction-to-ai', 'Understand AI fundamentals and practical applications. Start your journey into artificial intelligence.', NULL, NULL, NULL, 'beginner', 60, NULL, NULL, 'published', 'draft', 'both', 1, NULL, NULL, NULL, NULL, 0, '2025-12-20 09:19:13', '2025-12-20 09:24:16', 0, 0.00, 'from-pink-500', 'to-pink-700', 10, 'AI Fundamentals', NULL, 'M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 ', 'Nebatech Team', 0, 0, 'Artificial Intelligence', 1800.00, NULL),
(36, 'eff5b084-dd84-11f0-ab86-f48e38a80c71', 'Machine Learning', 'machine-learning', 'Learn ML algorithms and build predictive models. From theory to practical implementation.', NULL, NULL, NULL, 'intermediate', 80, NULL, NULL, 'published', 'draft', 'both', 1, NULL, NULL, NULL, NULL, 0, '2025-12-20 09:19:13', '2025-12-20 09:24:16', 0, 0.00, 'from-red-500', 'to-red-700', 10, 'ML Algorithms & Models', NULL, 'M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2', 'Nebatech Team', 0, 0, 'Artificial Intelligence', 2200.00, NULL),
(37, 'eff5b3ff-dd84-11f0-ab86-f48e38a80c71', 'Microsoft Office Mastery', 'microsoft-office', 'Master Word, Excel, PowerPoint, and Outlook. Essential productivity skills for the workplace.', NULL, NULL, NULL, 'beginner', 40, NULL, NULL, 'published', 'draft', 'both', 1, NULL, NULL, NULL, NULL, 0, '2025-12-20 09:19:13', '2025-12-20 09:24:16', 0, 0.00, 'from-cyan-500', 'to-cyan-700', 10, 'Office Suite Skills', NULL, 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V', 'Nebatech Team', 0, 0, 'Productivity', 800.00, NULL),
(38, 'eff5b6cf-dd84-11f0-ab86-f48e38a80c71', 'Mobile App Development', 'mobile-development', 'Build native and cross-platform mobile applications. Create apps for iOS and Android.', NULL, NULL, NULL, 'intermediate', 90, NULL, NULL, 'published', 'draft', 'both', 1, NULL, NULL, NULL, NULL, 0, '2025-12-20 09:19:13', '2025-12-20 09:24:16', 0, 0.00, 'from-indigo-500', 'to-indigo-700', 10, 'Cross-Platform Apps', NULL, 'M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z', 'Nebatech Team', 0, 0, 'Mobile Development', 2300.00, NULL),
(39, 'eff5b818-dd84-11f0-ab86-f48e38a80c71', 'Cybersecurity Fundamentals', 'cybersecurity', 'Learn security principles and ethical hacking. Protect systems and networks from threats.', NULL, NULL, NULL, 'intermediate', 70, NULL, NULL, 'published', 'draft', 'both', 1, NULL, NULL, NULL, NULL, 0, '2025-12-20 09:19:13', '2025-12-20 09:24:16', 0, 0.00, 'from-rose-500', 'to-rose-700', 10, 'Security & Ethical Hacking', NULL, 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003', 'Nebatech Team', 0, 0, 'Security', 2000.00, NULL),
(40, 'eff5ba07-dd84-11f0-ab86-f48e38a80c71', 'Cloud Computing', 'cloud-computing', 'Master AWS, Azure, and cloud architecture. Deploy and manage scalable cloud solutions.', NULL, NULL, NULL, 'intermediate', 75, NULL, NULL, 'published', 'draft', 'both', 1, NULL, NULL, NULL, NULL, 0, '2025-12-20 09:19:13', '2025-12-20 09:24:16', 0, 0.00, 'from-sky-500', 'to-sky-700', 10, 'Cloud Architecture', NULL, 'M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z', 'Nebatech Team', 0, 0, 'Cloud', 2100.00, NULL),
(41, 'eff5bd0d-dd84-11f0-ab86-f48e38a80c71', 'Data Science', 'data-science', 'Analyze data and build insights with Python. Transform raw data into actionable intelligence.', NULL, NULL, NULL, 'intermediate', 100, NULL, NULL, 'published', 'draft', 'both', 1, NULL, NULL, NULL, NULL, 0, '2025-12-20 09:19:13', '2025-12-20 09:24:16', 0, 0.00, 'from-violet-500', 'to-violet-700', 10, 'Data Analysis & Visualization', NULL, 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10', 'Nebatech Team', 0, 0, 'Data', 1900.00, NULL),
(42, 'ffc82be9-dd84-11f0-ab86-f48e38a80c71', 'AI Fundamentals & History', 'ai-fundamentals-history', 'Learn the history, evolution, and core concepts of artificial intelligence.', NULL, NULL, NULL, 'beginner', 12, NULL, NULL, 'published', 'draft', 'both', 0, 35, NULL, NULL, NULL, 0, '2025-12-20 09:19:40', '2025-12-20 09:24:16', 0, 0.00, 'from-pink-400', 'to-pink-600', 10, 'Hands-on Projects', NULL, 'fas fa-book', 'Nebatech Team', 0, 0, 'Artificial Intelligence', 400.00, NULL),
(43, 'ffccf7b1-dd84-11f0-ab86-f48e38a80c71', 'Python for AI', 'python-for-ai', 'Master Python programming specifically for AI and machine learning applications.', NULL, NULL, NULL, 'beginner', 18, NULL, NULL, 'published', 'draft', 'both', 0, 35, NULL, NULL, NULL, 0, '2025-12-20 09:19:40', '2025-12-20 09:24:16', 0, 0.00, 'from-pink-400', 'to-pink-600', 10, 'Hands-on Projects', NULL, 'fas fa-book', 'Nebatech Team', 0, 0, 'Artificial Intelligence', 500.00, NULL),
(44, 'ffccf9ad-dd84-11f0-ab86-f48e38a80c71', 'AI Tools & Platforms', 'ai-tools-platforms', 'Explore popular AI tools, platforms, and services like ChatGPT, DALL-E, and more.', NULL, NULL, NULL, 'beginner', 10, NULL, NULL, 'published', 'draft', 'both', 0, 35, NULL, NULL, NULL, 0, '2025-12-20 09:19:40', '2025-12-20 09:24:16', 0, 0.00, 'from-pink-400', 'to-pink-600', 10, 'Hands-on Projects', NULL, 'fas fa-book', 'Nebatech Team', 0, 0, 'Artificial Intelligence', 350.00, NULL),
(45, 'ffccfac0-dd84-11f0-ab86-f48e38a80c71', 'AI Ethics & Responsible AI', 'ai-ethics-responsible', 'Understand ethical considerations and responsible AI development practices.', NULL, NULL, NULL, 'beginner', 8, NULL, NULL, 'published', 'draft', 'both', 0, 35, NULL, NULL, NULL, 0, '2025-12-20 09:19:40', '2025-12-20 09:24:16', 0, 0.00, 'from-pink-400', 'to-pink-600', 10, 'Hands-on Projects', NULL, 'fas fa-book', 'Nebatech Team', 0, 0, 'Artificial Intelligence', 300.00, NULL),
(46, 'ffccfbbc-dd84-11f0-ab86-f48e38a80c71', 'AI in Business', 'ai-in-business', 'Apply AI concepts to solve real-world business problems and improve efficiency.', NULL, NULL, NULL, 'beginner', 12, NULL, NULL, 'published', 'draft', 'both', 0, 35, NULL, NULL, NULL, 0, '2025-12-20 09:19:40', '2025-12-20 09:24:16', 0, 0.00, 'from-pink-400', 'to-pink-600', 10, 'Hands-on Projects', NULL, 'fas fa-book', 'Nebatech Team', 0, 0, 'Artificial Intelligence', 450.00, NULL),
(47, '08dc4a98-dd85-11f0-ab86-f48e38a80c71', 'Supervised Learning', 'supervised-learning', 'Master classification and regression algorithms including decision trees and SVMs.', NULL, NULL, NULL, 'intermediate', 16, NULL, NULL, 'published', 'draft', 'both', 0, 36, NULL, NULL, NULL, 0, '2025-12-20 09:19:55', '2025-12-20 09:24:16', 0, 0.00, 'from-red-400', 'to-red-600', 10, 'Hands-on Projects', NULL, 'fas fa-book', 'Nebatech Team', 0, 0, 'Artificial Intelligence', 500.00, NULL),
(48, '08de6d40-dd85-11f0-ab86-f48e38a80c71', 'Unsupervised Learning', 'unsupervised-learning', 'Learn clustering, dimensionality reduction, and pattern discovery techniques.', NULL, NULL, NULL, 'intermediate', 14, NULL, NULL, 'published', 'draft', 'both', 0, 36, NULL, NULL, NULL, 0, '2025-12-20 09:19:55', '2025-12-20 09:24:16', 0, 0.00, 'from-red-400', 'to-red-600', 10, 'Hands-on Projects', NULL, 'fas fa-book', 'Nebatech Team', 0, 0, 'Artificial Intelligence', 500.00, NULL),
(49, '08de74d7-dd85-11f0-ab86-f48e38a80c71', 'Deep Learning Fundamentals', 'deep-learning-fundamentals', 'Introduction to neural networks, TensorFlow, and Keras frameworks.', NULL, NULL, NULL, 'intermediate', 20, NULL, NULL, 'published', 'draft', 'both', 0, 36, NULL, NULL, NULL, 0, '2025-12-20 09:19:55', '2025-12-20 09:24:16', 0, 0.00, 'from-red-400', 'to-red-600', 10, 'Hands-on Projects', NULL, 'fas fa-book', 'Nebatech Team', 0, 0, 'Artificial Intelligence', 600.00, NULL),
(50, '08de78ec-dd85-11f0-ab86-f48e38a80c71', 'Model Training & Evaluation', 'model-training-evaluation', 'Learn to train, validate, and evaluate machine learning models effectively.', NULL, NULL, NULL, 'intermediate', 12, NULL, NULL, 'published', 'draft', 'both', 0, 36, NULL, NULL, NULL, 0, '2025-12-20 09:19:55', '2025-12-20 09:24:16', 0, 0.00, 'from-red-400', 'to-red-600', 10, 'Hands-on Projects', NULL, 'fas fa-book', 'Nebatech Team', 0, 0, 'Artificial Intelligence', 450.00, NULL),
(51, '08de7ccc-dd85-11f0-ab86-f48e38a80c71', 'ML Project Deployment', 'ml-project-deployment', 'Deploy machine learning models to production using Flask, Docker, and cloud services.', NULL, NULL, NULL, 'intermediate', 18, NULL, NULL, 'published', 'draft', 'both', 0, 36, NULL, NULL, NULL, 0, '2025-12-20 09:19:55', '2025-12-20 09:24:16', 0, 0.00, 'from-red-400', 'to-red-600', 10, 'Hands-on Projects', NULL, 'fas fa-book', 'Nebatech Team', 0, 0, 'Artificial Intelligence', 550.00, NULL),
(52, '2c2eadda-dd85-11f0-ab86-f48e38a80c71', 'Microsoft Word Mastery', 'microsoft-word', 'Create professional documents, reports, and publications with Word.', NULL, NULL, NULL, 'beginner', 10, NULL, NULL, 'published', 'draft', 'both', 0, 37, NULL, NULL, NULL, 0, '2025-12-20 09:20:54', '2025-12-20 09:24:16', 0, 0.00, 'from-cyan-400', 'to-cyan-600', 10, 'Hands-on Projects', NULL, 'fas fa-book', 'Nebatech Team', 0, 0, 'Productivity', 200.00, NULL),
(53, '2c3174db-dd85-11f0-ab86-f48e38a80c71', 'Microsoft Excel Complete', 'microsoft-excel', 'Master spreadsheets, formulas, pivot tables, and data analysis in Excel.', NULL, NULL, NULL, 'beginner', 14, NULL, NULL, 'published', 'draft', 'both', 0, 37, NULL, NULL, NULL, 0, '2025-12-20 09:20:54', '2025-12-20 09:24:16', 0, 0.00, 'from-cyan-400', 'to-cyan-600', 10, 'Hands-on Projects', NULL, 'fas fa-book', 'Nebatech Team', 0, 0, 'Productivity', 250.00, NULL),
(54, '2c3176d4-dd85-11f0-ab86-f48e38a80c71', 'Microsoft PowerPoint Pro', 'microsoft-powerpoint', 'Design stunning presentations with animations and multimedia.', NULL, NULL, NULL, 'beginner', 8, NULL, NULL, 'published', 'draft', 'both', 0, 37, NULL, NULL, NULL, 0, '2025-12-20 09:20:54', '2025-12-20 09:24:16', 0, 0.00, 'from-cyan-400', 'to-cyan-600', 10, 'Hands-on Projects', NULL, 'fas fa-book', 'Nebatech Team', 0, 0, 'Productivity', 180.00, NULL),
(55, '2c317823-dd85-11f0-ab86-f48e38a80c71', 'Microsoft Outlook & Teams', 'microsoft-outlook-teams', 'Master email management, calendars, and team collaboration.', NULL, NULL, NULL, 'beginner', 6, NULL, NULL, 'published', 'draft', 'both', 0, 37, NULL, NULL, NULL, 0, '2025-12-20 09:20:54', '2025-12-20 09:24:16', 0, 0.00, 'from-cyan-400', 'to-cyan-600', 10, 'Hands-on Projects', NULL, 'fas fa-book', 'Nebatech Team', 0, 0, 'Productivity', 150.00, NULL),
(56, '2c31792c-dd85-11f0-ab86-f48e38a80c71', 'Office 365 Cloud Features', 'office-365-cloud', 'Leverage cloud storage, sharing, and collaboration in Office 365.', NULL, NULL, NULL, 'beginner', 5, NULL, NULL, 'published', 'draft', 'both', 0, 37, NULL, NULL, NULL, 0, '2025-12-20 09:20:54', '2025-12-20 09:24:16', 0, 0.00, 'from-cyan-400', 'to-cyan-600', 10, 'Hands-on Projects', NULL, 'fas fa-book', 'Nebatech Team', 0, 0, 'Productivity', 120.00, NULL),
(57, '33d6c997-dd85-11f0-ab86-f48e38a80c71', 'React Native Essentials', 'react-native-essentials', 'Build cross-platform mobile apps with React Native and JavaScript.', NULL, NULL, NULL, 'intermediate', 22, NULL, NULL, 'published', 'draft', 'both', 0, 38, NULL, NULL, NULL, 0, '2025-12-20 09:21:07', '2025-12-20 09:24:16', 0, 0.00, 'from-indigo-400', 'to-indigo-600', 10, 'Hands-on Projects', NULL, 'fas fa-book', 'Nebatech Team', 0, 0, 'Mobile Development', 550.00, NULL),
(58, '33d8c94d-dd85-11f0-ab86-f48e38a80c71', 'Flutter Development', 'flutter-development', 'Create beautiful native apps for iOS and Android with Flutter and Dart.', NULL, NULL, NULL, 'intermediate', 24, NULL, NULL, 'published', 'draft', 'both', 0, 38, NULL, NULL, NULL, 0, '2025-12-20 09:21:07', '2025-12-20 09:24:16', 0, 0.00, 'from-indigo-400', 'to-indigo-600', 10, 'Hands-on Projects', NULL, 'fas fa-book', 'Nebatech Team', 0, 0, 'Mobile Development', 600.00, NULL),
(59, '33d8cb31-dd85-11f0-ab86-f48e38a80c71', 'Mobile UI/UX Design', 'mobile-ui-ux', 'Design intuitive and engaging mobile user interfaces and experiences.', NULL, NULL, NULL, 'intermediate', 14, NULL, NULL, 'published', 'draft', 'both', 0, 38, NULL, NULL, NULL, 0, '2025-12-20 09:21:07', '2025-12-20 09:24:16', 0, 0.00, 'from-indigo-400', 'to-indigo-600', 10, 'Hands-on Projects', NULL, 'fas fa-book', 'Nebatech Team', 0, 0, 'Mobile Development', 400.00, NULL),
(60, '33d8cc3b-dd85-11f0-ab86-f48e38a80c71', 'Mobile App APIs', 'mobile-app-apis', 'Integrate REST APIs, authentication, and real-time features in mobile apps.', NULL, NULL, NULL, 'intermediate', 16, NULL, NULL, 'published', 'draft', 'both', 0, 38, NULL, NULL, NULL, 0, '2025-12-20 09:21:07', '2025-12-20 09:24:16', 0, 0.00, 'from-indigo-400', 'to-indigo-600', 10, 'Hands-on Projects', NULL, 'fas fa-book', 'Nebatech Team', 0, 0, 'Mobile Development', 450.00, NULL),
(61, '33d8cd36-dd85-11f0-ab86-f48e38a80c71', 'App Store Deployment', 'app-store-deployment', 'Publish apps to Google Play Store and Apple App Store successfully.', NULL, NULL, NULL, 'intermediate', 10, NULL, NULL, 'published', 'draft', 'both', 0, 38, NULL, NULL, NULL, 0, '2025-12-20 09:21:07', '2025-12-20 09:24:16', 0, 0.00, 'from-indigo-400', 'to-indigo-600', 10, 'Hands-on Projects', NULL, 'fas fa-book', 'Nebatech Team', 0, 0, 'Mobile Development', 350.00, NULL),
(62, '3a71667d-dd85-11f0-ab86-f48e38a80c71', 'Network Security Basics', 'network-security-basics', 'Understand network vulnerabilities, firewalls, and intrusion detection.', NULL, NULL, NULL, 'intermediate', 14, NULL, NULL, 'published', 'draft', 'both', 0, 39, NULL, NULL, NULL, 0, '2025-12-20 09:21:18', '2025-12-20 09:24:16', 0, 0.00, 'from-rose-400', 'to-rose-600', 10, 'Hands-on Projects', NULL, 'fas fa-book', 'Nebatech Team', 0, 0, 'Security', 450.00, NULL),
(63, '3a7315cc-dd85-11f0-ab86-f48e38a80c71', 'Ethical Hacking', 'ethical-hacking', 'Learn penetration testing techniques and vulnerability assessment.', NULL, NULL, NULL, 'intermediate', 18, NULL, NULL, 'published', 'draft', 'both', 0, 39, NULL, NULL, NULL, 0, '2025-12-20 09:21:18', '2025-12-20 09:24:16', 0, 0.00, 'from-rose-400', 'to-rose-600', 10, 'Hands-on Projects', NULL, 'fas fa-book', 'Nebatech Team', 0, 0, 'Security', 550.00, NULL),
(64, '3a731783-dd85-11f0-ab86-f48e38a80c71', 'Cryptography Fundamentals', 'cryptography-fundamentals', 'Master encryption, hashing, and secure communication protocols.', NULL, NULL, NULL, 'intermediate', 12, NULL, NULL, 'published', 'draft', 'both', 0, 39, NULL, NULL, NULL, 0, '2025-12-20 09:21:18', '2025-12-20 09:24:16', 0, 0.00, 'from-rose-400', 'to-rose-600', 10, 'Hands-on Projects', NULL, 'fas fa-book', 'Nebatech Team', 0, 0, 'Security', 400.00, NULL),
(65, '3a731870-dd85-11f0-ab86-f48e38a80c71', 'Security Tools & Techniques', 'security-tools', 'Hands-on experience with Kali Linux, Wireshark, and security tools.', NULL, NULL, NULL, 'intermediate', 16, NULL, NULL, 'published', 'draft', 'both', 0, 39, NULL, NULL, NULL, 0, '2025-12-20 09:21:18', '2025-12-20 09:24:16', 0, 0.00, 'from-rose-400', 'to-rose-600', 10, 'Hands-on Projects', NULL, 'fas fa-book', 'Nebatech Team', 0, 0, 'Security', 500.00, NULL),
(66, '3a731ac8-dd85-11f0-ab86-f48e38a80c71', 'Incident Response', 'incident-response', 'Learn to detect, respond to, and recover from security incidents.', NULL, NULL, NULL, 'intermediate', 10, NULL, NULL, 'published', 'draft', 'both', 0, 39, NULL, NULL, NULL, 0, '2025-12-20 09:21:18', '2025-12-20 09:24:16', 0, 0.00, 'from-rose-400', 'to-rose-600', 10, 'Hands-on Projects', NULL, 'fas fa-book', 'Nebatech Team', 0, 0, 'Security', 400.00, NULL),
(67, '448e81cf-dd85-11f0-ab86-f48e38a80c71', 'AWS Fundamentals', 'aws-fundamentals', 'Learn Amazon Web Services: EC2, S3, Lambda, and core services.', NULL, NULL, NULL, 'intermediate', 18, NULL, NULL, 'published', 'draft', 'both', 0, 40, NULL, NULL, NULL, 0, '2025-12-20 09:21:35', '2025-12-20 09:24:16', 0, 0.00, 'from-sky-400', 'to-sky-600', 10, 'Hands-on Projects', NULL, 'fas fa-book', 'Nebatech Team', 0, 0, 'Cloud', 550.00, NULL),
(68, '44919b4f-dd85-11f0-ab86-f48e38a80c71', 'Azure Essentials', 'azure-essentials', 'Master Microsoft Azure cloud services and infrastructure.', NULL, NULL, NULL, 'intermediate', 16, NULL, NULL, 'published', 'draft', 'both', 0, 40, NULL, NULL, NULL, 0, '2025-12-20 09:21:35', '2025-12-20 09:24:16', 0, 0.00, 'from-sky-400', 'to-sky-600', 10, 'Hands-on Projects', NULL, 'fas fa-book', 'Nebatech Team', 0, 0, 'Cloud', 500.00, NULL),
(69, '44919da5-dd85-11f0-ab86-f48e38a80c71', 'Docker & Containers', 'docker-containers', 'Containerize applications with Docker for consistent deployments.', NULL, NULL, NULL, 'intermediate', 14, NULL, NULL, 'published', 'draft', 'both', 0, 40, NULL, NULL, NULL, 0, '2025-12-20 09:21:35', '2025-12-20 09:24:16', 0, 0.00, 'from-sky-400', 'to-sky-600', 10, 'Hands-on Projects', NULL, 'fas fa-book', 'Nebatech Team', 0, 0, 'Cloud', 450.00, NULL),
(70, '44919ed3-dd85-11f0-ab86-f48e38a80c71', 'Kubernetes Orchestration', 'kubernetes-orchestration', 'Manage containerized applications at scale with Kubernetes.', NULL, NULL, NULL, 'intermediate', 16, NULL, NULL, 'published', 'draft', 'both', 0, 40, NULL, NULL, NULL, 0, '2025-12-20 09:21:35', '2025-12-20 09:24:16', 0, 0.00, 'from-sky-400', 'to-sky-600', 10, 'Hands-on Projects', NULL, 'fas fa-book', 'Nebatech Team', 0, 0, 'Cloud', 550.00, NULL),
(71, '44919fd4-dd85-11f0-ab86-f48e38a80c71', 'Cloud Architecture Design', 'cloud-architecture', 'Design scalable, secure, and cost-effective cloud solutions.', NULL, NULL, NULL, 'intermediate', 14, NULL, NULL, 'published', 'draft', 'both', 0, 40, NULL, NULL, NULL, 0, '2025-12-20 09:21:35', '2025-12-20 09:24:16', 0, 0.00, 'from-sky-400', 'to-sky-600', 10, 'Hands-on Projects', NULL, 'fas fa-book', 'Nebatech Team', 0, 0, 'Cloud', 500.00, NULL),
(72, '4b703fb5-dd85-11f0-ab86-f48e38a80c71', 'Python for Data Science', 'python-data-science', 'Master Python programming for data analysis and manipulation.', NULL, NULL, NULL, 'intermediate', 20, NULL, NULL, 'published', 'draft', 'both', 0, 41, NULL, NULL, NULL, 0, '2025-12-20 09:21:46', '2025-12-20 09:24:16', 0, 0.00, 'from-violet-400', 'to-violet-600', 10, 'Hands-on Projects', NULL, 'fas fa-book', 'Nebatech Team', 0, 0, 'Data', 500.00, NULL),
(73, '4b71dccb-dd85-11f0-ab86-f48e38a80c71', 'Pandas & NumPy Mastery', 'pandas-numpy', 'Data manipulation and numerical computing with Pandas and NumPy.', NULL, NULL, NULL, 'intermediate', 16, NULL, NULL, 'published', 'draft', 'both', 0, 41, NULL, NULL, NULL, 0, '2025-12-20 09:21:46', '2025-12-20 09:24:16', 0, 0.00, 'from-violet-400', 'to-violet-600', 10, 'Hands-on Projects', NULL, 'fas fa-book', 'Nebatech Team', 0, 0, 'Data', 450.00, NULL),
(74, '4b71de7a-dd85-11f0-ab86-f48e38a80c71', 'Data Visualization', 'data-visualization', 'Create compelling visualizations with Matplotlib, Seaborn, and Plotly.', NULL, NULL, NULL, 'intermediate', 14, NULL, NULL, 'published', 'draft', 'both', 0, 41, NULL, NULL, NULL, 0, '2025-12-20 09:21:46', '2025-12-20 09:24:16', 0, 0.00, 'from-violet-400', 'to-violet-600', 10, 'Hands-on Projects', NULL, 'fas fa-book', 'Nebatech Team', 0, 0, 'Data', 400.00, NULL),
(75, '4b71df76-dd85-11f0-ab86-f48e38a80c71', 'Statistics for Data Science', 'statistics-data-science', 'Statistical analysis, hypothesis testing, and probability theory.', NULL, NULL, NULL, 'intermediate', 18, NULL, NULL, 'published', 'draft', 'both', 0, 41, NULL, NULL, NULL, 0, '2025-12-20 09:21:46', '2025-12-20 09:24:16', 0, 0.00, 'from-violet-400', 'to-violet-600', 10, 'Hands-on Projects', NULL, 'fas fa-book', 'Nebatech Team', 0, 0, 'Data', 500.00, NULL),
(76, '4b71e06f-dd85-11f0-ab86-f48e38a80c71', 'Data Science Projects', 'data-science-projects', 'Build real-world data science projects for your portfolio.', NULL, NULL, NULL, 'intermediate', 22, NULL, NULL, 'published', 'draft', 'both', 0, 41, NULL, NULL, NULL, 0, '2025-12-20 09:21:46', '2025-12-20 09:24:16', 0, 0.00, 'from-violet-400', 'to-violet-600', 10, 'Hands-on Projects', NULL, 'fas fa-book', 'Nebatech Team', 0, 0, 'Data', 550.00, NULL),
(77, '57aa400e-dd85-11f0-ab86-f48e38a80c71', 'Git & Version Control', 'git-version-control', 'Master Git, GitHub, and collaborative development workflows.', NULL, NULL, NULL, 'intermediate', 10, NULL, NULL, 'published', 'draft', 'both', 0, 34, NULL, NULL, NULL, 0, '2025-12-20 09:22:07', '2025-12-20 09:24:16', 0, 0.00, 'from-purple-400', 'to-purple-600', 10, 'Hands-on Projects', NULL, 'fas fa-book', 'Nebatech Team', 0, 0, 'Web Development', 300.00, NULL),
(78, '57ab82ef-dd85-11f0-ab86-f48e38a80c71', 'RESTful API Design', 'restful-api-design', 'Design and build scalable RESTful APIs with best practices.', NULL, NULL, NULL, 'intermediate', 14, NULL, NULL, 'published', 'draft', 'both', 0, 34, NULL, NULL, NULL, 0, '2025-12-20 09:22:07', '2025-12-20 09:24:16', 0, 0.00, 'from-purple-400', 'to-purple-600', 10, 'Hands-on Projects', NULL, 'fas fa-book', 'Nebatech Team', 0, 0, 'Web Development', 450.00, NULL),
(79, '57ab84cd-dd85-11f0-ab86-f48e38a80c71', 'Authentication & Security', 'auth-security', 'Implement secure authentication, authorization, and JWT tokens.', NULL, NULL, NULL, 'intermediate', 12, NULL, NULL, 'published', 'draft', 'both', 0, 34, NULL, NULL, NULL, 0, '2025-12-20 09:22:07', '2025-12-20 09:24:16', 0, 0.00, 'from-purple-400', 'to-purple-600', 10, 'Hands-on Projects', NULL, 'fas fa-book', 'Nebatech Team', 0, 0, 'Web Development', 400.00, NULL),
(80, '57ab85ca-dd85-11f0-ab86-f48e38a80c71', 'DevOps Essentials', 'devops-essentials', 'CI/CD pipelines, deployment automation, and DevOps practices.', NULL, NULL, NULL, 'intermediate', 16, NULL, NULL, 'published', 'draft', 'both', 0, 34, NULL, NULL, NULL, 0, '2025-12-20 09:22:07', '2025-12-20 09:24:16', 0, 0.00, 'from-purple-400', 'to-purple-600', 10, 'Hands-on Projects', NULL, 'fas fa-book', 'Nebatech Team', 0, 0, 'Web Development', 500.00, NULL),
(81, '57b0e745-dd85-11f0-ab86-f48e38a80c71', 'Full-Stack Capstone Project', 'fullstack-capstone', 'Build a complete full-stack application from scratch.', NULL, NULL, NULL, 'intermediate', 24, NULL, NULL, 'published', 'draft', 'both', 0, 34, NULL, NULL, NULL, 0, '2025-12-20 09:22:07', '2025-12-20 09:24:16', 0, 0.00, 'from-purple-400', 'to-purple-600', 10, 'Hands-on Projects', NULL, 'fas fa-book', 'Nebatech Team', 0, 0, 'Web Development', 600.00, NULL),
(92, '6df68f70-dd85-11f0-ab86-f48e38a80c71', 'Online Safety & Privacy', 'online-safety-privacy', 'Protect yourself from scams, phishing, and online threats.', NULL, NULL, NULL, 'beginner', 6, NULL, NULL, 'published', 'draft', 'both', 0, 25, NULL, NULL, NULL, 0, '2025-12-20 09:22:44', '2025-12-20 09:24:16', 0, 0.00, 'from-teal-400', 'to-teal-600', 10, 'Hands-on Projects', NULL, 'fas fa-book', 'Nebatech Team', 0, 0, 'Fundamentals', 150.00, NULL),
(93, '6df6a23c-dd85-11f0-ab86-f48e38a80c71', 'Digital Tools for Productivity', 'digital-productivity-tools', 'Use cloud storage, video conferencing, and productivity tools.', NULL, NULL, NULL, 'beginner', 8, NULL, NULL, 'published', 'draft', 'both', 0, 25, NULL, NULL, NULL, 0, '2025-12-20 09:22:44', '2025-12-20 09:24:16', 0, 0.00, 'from-teal-400', 'to-teal-600', 10, 'Hands-on Projects', NULL, 'fas fa-book', 'Nebatech Team', 0, 0, 'Fundamentals', 180.00, NULL);

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
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(10, '494d41ba-a5e8-4450-bc82-1743a2616356', 'student@gmail.com', '$2y$12$m6VwmXATAyGZ6svEcaZ0uO3gXkvd/Ogsj7PPxTKRnlrcG4sUVPLv.', 'Facilitator', 'Facilitator', 'student', 'student', NULL, 'academy', NULL, 'active', NULL, '2025-11-10 09:32:14', '2025-11-12 13:48:47', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'UTC', 'en', 1, 0, 0),
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
-- Indexes for table `portfolio_settings`
--
ALTER TABLE `portfolio_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
-- AUTO_INCREMENT for table `learning_streaks`
--
ALTER TABLE `learning_streaks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lessons`
--
ALTER TABLE `lessons`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `lesson_progress`
--
ALTER TABLE `lesson_progress`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
-- AUTO_INCREMENT for table `portfolio_settings`
--
ALTER TABLE `portfolio_settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

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
