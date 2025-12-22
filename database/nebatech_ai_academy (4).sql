-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 22, 2025 at 10:07 PM
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
(10, '494d41ba-a5e8-4450-bc82-1743a2616356', 'student@gmail.com', '$2y$12$m6VwmXATAyGZ6svEcaZ0uO3gXkvd/Ogsj7PPxTKRnlrcG4sUVPLv.', 'Student', 'Student', 'student', 'student', NULL, 'academy', NULL, 'active', NULL, '2025-11-10 09:32:14', '2025-12-22 20:55:13', '', '', '', '', '', '', '', 'UTC', 'en', 1, 0, 0),
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
