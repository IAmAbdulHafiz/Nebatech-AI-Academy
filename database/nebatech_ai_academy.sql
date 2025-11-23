-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 23, 2025 at 06:43 AM
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

--
-- Dumping data for table `assignments`
--

INSERT INTO `assignments` (`id`, `uuid`, `lesson_id`, `title`, `description`, `instructions`, `rubric`, `max_score`, `ai_feedback_enabled`, `due_date`, `created_at`, `updated_at`) VALUES
(1, '5dfa60cc-bfcd-11f0-af10-48ba4e5c5cd8', 4, 'HTML Contact Form Project', 'Build a professional contact form using semantic HTML5 and form validation.', 'Create a contact form that includes all required fields, proper validation, and accessible markup. Test your form to ensure all validation works correctly.', '[{\"criteria\":\"HTML Structure\",\"description\":\"Proper semantic HTML5 markup\",\"max_points\":20},{\"criteria\":\"Form Elements\",\"description\":\"All required fields included\",\"max_points\":25},{\"criteria\":\"Validation\",\"description\":\"Correct HTML5 validation attributes\",\"max_points\":25},{\"criteria\":\"Accessibility\",\"description\":\"Proper labels and ARIA attributes\",\"max_points\":20},{\"criteria\":\"Code Quality\",\"description\":\"Clean, well-formatted code\",\"max_points\":10}]', 100, 1, '2025-11-19 13:42:01', '2025-11-12 13:42:01', '2025-11-12 13:42:01'),
(2, '5e16896c-bfcd-11f0-af10-48ba4e5c5cd8', 9, 'Responsive Portfolio Website', 'Design and build a fully responsive personal portfolio website showcasing your skills.', 'Create a multi-section portfolio website with responsive design. Ensure it works perfectly on mobile, tablet, and desktop screens. Use modern CSS techniques including Flexbox or Grid.', '[{\"criteria\":\"Responsive Design\",\"description\":\"Works perfectly on all screen sizes\",\"max_points\":25},{\"criteria\":\"Layout & Structure\",\"description\":\"Proper use of Flexbox/Grid\",\"max_points\":20},{\"criteria\":\"Design Quality\",\"description\":\"Professional appearance and UX\",\"max_points\":20},{\"criteria\":\"Code Quality\",\"description\":\"Clean, organized CSS\",\"max_points\":15},{\"criteria\":\"Content Completeness\",\"description\":\"All required sections included\",\"max_points\":15},{\"criteria\":\"Bonus Features\",\"description\":\"Additional creative features\",\"max_points\":5}]', 100, 1, '2025-11-26 13:42:01', '2025-11-12 13:42:01', '2025-11-12 13:42:01'),
(3, '5e382bbe-bfcd-11f0-af10-48ba4e5c5cd8', 13, 'JavaScript Calculator Application', 'Build a fully functional calculator using JavaScript DOM manipulation.', 'Create an interactive calculator that handles basic arithmetic operations. Use event listeners for button clicks and update the display dynamically.', '[{\"criteria\":\"Functionality\",\"description\":\"All basic operations work correctly\",\"max_points\":30},{\"criteria\":\"DOM Manipulation\",\"description\":\"Proper use of JavaScript DOM methods\",\"max_points\":25},{\"criteria\":\"Code Organization\",\"description\":\"Clean, well-structured code\",\"max_points\":20},{\"criteria\":\"UI/UX\",\"description\":\"User-friendly interface\",\"max_points\":15},{\"criteria\":\"Error Handling\",\"description\":\"Handles edge cases properly\",\"max_points\":10}]', 100, 1, '2025-11-22 13:42:01', '2025-11-12 13:42:01', '2025-11-12 13:42:01');

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

--
-- Dumping data for table `certificates`
--

INSERT INTO `certificates` (`id`, `uuid`, `user_id`, `course_id`, `certificate_number`, `issued_at`, `verified`, `verification_url`, `revoked_at`, `revoked_by`, `revocation_reason`) VALUES
(1, '285851e5-01a1-4583-9bf9-6f344f70c056', 10, 1, 'NEBA-2025-E3D281EA', '2025-11-12 17:25:37', 0, NULL, '2025-11-12 22:16:36', 11, 'Revoked by admin');

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
  `rejection_reason` text DEFAULT NULL,
  `approved_by` int(10) UNSIGNED DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `ai_generated` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `uuid`, `title`, `slug`, `description`, `category_id`, `related_service_id`, `service_description`, `level`, `duration_hours`, `thumbnail`, `facilitator_id`, `status`, `approval_status`, `availability`, `rejection_reason`, `approved_by`, `approved_at`, `ai_generated`, `created_at`, `updated_at`) VALUES
(1, '5d2636e9-bfcd-11f0-af10-48ba4e5c5cd8', 'Frontend Development Fundamentals', 'frontend-development-fundamentals', 'Master the essentials of modern frontend web development. Learn HTML5, CSS3, JavaScript, and React to build beautiful, responsive, and interactive websites. This comprehensive course takes you from zero to job-ready with hands-on projects and real-world examples.', 3, NULL, NULL, 'beginner', 60, 'uploads/thumbnails/frontend-dev-course.jpg', 1, 'published', 'draft', 'both', NULL, NULL, NULL, 0, '2025-11-12 13:42:00', '2025-11-12 14:45:23'),
(2, '985cc90b-395f-4edf-a46e-d2eb6e5d0a70', 'Complete FullStack', 'complete-fullstack', 'Greatnow about my lessons, I think we can do better. Currently my lessons are just text based, and it doesn\'t even look professional, so I want you to redesign the structure of my lessons for me, and its display just like modern learning management systems. Brainstorm and think harder on this', 3, NULL, NULL, 'intermediate', 18, NULL, 1, 'published', 'draft', 'both', NULL, NULL, NULL, 0, '2025-11-12 21:26:01', '2025-11-12 21:26:01');

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
(1, 10, 1, 'active', 0.00, '2025-11-12 17:14:40', NULL, NULL);

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

--
-- Dumping data for table `lessons`
--

INSERT INTO `lessons` (`id`, `uuid`, `module_id`, `title`, `type`, `content`, `order_index`, `duration_minutes`, `resources`, `ai_generated`, `created_at`, `updated_at`) VALUES
(1, '5de3d228-bfcd-11f0-af10-48ba4e5c5cd8', 1, 'Introduction to HTML', 'text', '# Introduction to HTML\r\n\r\nHTML (HyperText Markup Language) is the standard markup language for creating web pages. It provides the structure and content of websites.\r\n\r\n## What is HTML?\r\n\r\nHTML uses **tags** to mark up different parts of a webpage. Tags are enclosed in angle brackets like `<tagname>`.\r\n\r\n## Basic HTML Structure\r\n\r\n```html\r\n<!DOCTYPE html>\r\n<html lang=\"en\">\r\n<head>\r\n    <meta charset=\"UTF-8\">\r\n    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">\r\n    <title>My First Webpage</title>\r\n</head>\r\n<body>\r\n    <h1>Hello, World!</h1>\r\n    <p>This is my first webpage.</p>\r\n</body>\r\n</html>\r\n```\r\n\r\n## Key Components:\r\n- **DOCTYPE**: Declares the HTML version\r\n- **html**: Root element\r\n- **head**: Contains metadata\r\n- **body**: Contains visible content\r\n\r\n## Common HTML Tags:\r\n- `<h1>` to `<h6>`: Headings\r\n- `<p>`: Paragraphs\r\n- `<a>`: Links\r\n- `<img>`: Images\r\n- `<div>`: Containers\r\n- `<span>`: Inline containers', 0, 30, '[{\"title\":\"MDN HTML Guide\",\"url\":\"https://developer.mozilla.org/en-US/docs/Web/HTML\",\"type\":\"article\"},{\"title\":\"HTML Tutorial - W3Schools\",\"url\":\"https://www.w3schools.com/html/\",\"type\":\"tutorial\"}]', 0, '2025-11-12 13:42:01', '2025-11-12 13:42:01'),
(2, '5de7bf72-bfcd-11f0-af10-48ba4e5c5cd8', 1, 'HTML Document Structure', 'text', '# HTML Document Structure\r\n\r\nUnderstanding the structure of an HTML document is crucial for building valid, accessible webpages.\r\n\r\n## The Head Section\r\n\r\nThe `<head>` contains metadata about the document:\r\n\r\n```html\r\n<head>\r\n    <meta charset=\"UTF-8\">\r\n    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">\r\n    <meta name=\"description\" content=\"Page description\">\r\n    <title>Page Title</title>\r\n    <link rel=\"stylesheet\" href=\"styles.css\">\r\n    <script src=\"script.js\" defer></script>\r\n</head>\r\n```\r\n\r\n### Important Meta Tags:\r\n- **charset**: Character encoding\r\n- **viewport**: Responsive design settings\r\n- **description**: SEO description\r\n\r\n## The Body Section\r\n\r\nThe `<body>` contains all visible content.\r\n\r\n## Semantic HTML5 Elements\r\n\r\n```html\r\n<header>\r\n    <nav>Navigation menu</nav>\r\n</header>\r\n\r\n<main>\r\n    <article>\r\n        <h1>Article Title</h1>\r\n        <section>Content section</section>\r\n    </article>\r\n</main>\r\n\r\n<aside>Sidebar content</aside>\r\n\r\n<footer>Footer content</footer>\r\n```\r\n\r\n## Benefits of Semantic HTML:\r\n✅ Better accessibility\r\n✅ Improved SEO\r\n✅ Easier maintenance\r\n✅ Clearer structure', 1, 45, '[{\"title\":\"HTML Semantic Elements\",\"url\":\"https://www.w3schools.com/html/html5_semantic_elements.asp\",\"type\":\"tutorial\"}]', 0, '2025-11-12 13:42:01', '2025-11-12 13:42:01'),
(3, '5de7c1be-bfcd-11f0-af10-48ba4e5c5cd8', 1, 'HTML Forms and Input', 'text', '# HTML Forms and Input\r\n\r\nForms allow users to interact with your website by submitting data.\r\n\r\n## Basic Form Structure\r\n\r\n```html\r\n<form action=\"/submit\" method=\"POST\">\r\n    <label for=\"name\">Name:</label>\r\n    <input type=\"text\" id=\"name\" name=\"name\" required>\r\n    \r\n    <label for=\"email\">Email:</label>\r\n    <input type=\"email\" id=\"email\" name=\"email\" required>\r\n    \r\n    <button type=\"submit\">Submit</button>\r\n</form>\r\n```\r\n\r\n## Input Types\r\n\r\nHTML5 provides many input types:\r\n\r\n```html\r\n<input type=\"text\">        <!-- Text input -->\r\n<input type=\"email\">       <!-- Email validation -->\r\n<input type=\"password\">    <!-- Hidden password -->\r\n<input type=\"number\">      <!-- Numeric input -->\r\n<input type=\"date\">        <!-- Date picker -->\r\n<input type=\"checkbox\">    <!-- Checkbox -->\r\n<input type=\"radio\">       <!-- Radio button -->\r\n<input type=\"file\">        <!-- File upload -->\r\n```\r\n\r\n## Form Validation\r\n\r\nUse HTML5 validation attributes:\r\n\r\n```html\r\n<input type=\"text\" required minlength=\"3\" maxlength=\"50\">\r\n<input type=\"email\" pattern=\"[a-z0-9._%+-]+@[a-z0-9.-]+\\.[a-z]{2,}$\">\r\n<input type=\"number\" min=\"0\" max=\"100\">\r\n```\r\n\r\n## Textarea and Select\r\n\r\n```html\r\n<textarea rows=\"4\" cols=\"50\">Default text</textarea>\r\n\r\n<select name=\"country\">\r\n    <option value=\"ng\">Nigeria</option>\r\n    <option value=\"us\">United States</option>\r\n    <option value=\"uk\">United Kingdom</option>\r\n</select>\r\n```', 2, 40, '[{\"title\":\"HTML Forms Guide\",\"url\":\"https://developer.mozilla.org/en-US/docs/Learn/Forms\",\"type\":\"article\"}]', 0, '2025-11-12 13:42:01', '2025-11-12 13:42:01'),
(4, '5de7c33a-bfcd-11f0-af10-48ba4e5c5cd8', 1, 'Practice: Build a Contact Form', 'code', '# Practice Exercise: Build a Contact Form\r\n\r\nCreate a fully functional contact form with validation.\r\n\r\n## Requirements:\r\n1. Form should include:\r\n   - Name field (required, min 3 characters)\r\n   - Email field (required, valid email)\r\n   - Phone number (optional)\r\n   - Subject dropdown (Support, Sales, General)\r\n   - Message textarea (required, min 10 characters)\r\n   - Submit button\r\n\r\n2. Use proper labels and semantic HTML\r\n3. Add placeholder text\r\n4. Implement HTML5 validation\r\n5. Style the form to be user-friendly\r\n\r\n## Starter Code:\r\n\r\n```html\r\n<!DOCTYPE html>\r\n<html lang=\"en\">\r\n<head>\r\n    <meta charset=\"UTF-8\">\r\n    <title>Contact Form</title>\r\n</head>\r\n<body>\r\n    <h1>Contact Us</h1>\r\n    <!-- Your form goes here -->\r\n</body>\r\n</html>\r\n```\r\n\r\n## Expected Output:\r\nA clean, accessible contact form that validates user input before submission.\r\n\r\n## Bonus Challenges:\r\n- Add a \"Terms & Conditions\" checkbox\r\n- Create a custom success message\r\n- Make it responsive', 3, 60, '[{\"title\":\"Form Best Practices\",\"url\":\"https://www.smashingmagazine.com/2018/08/best-practices-for-mobile-form-design/\",\"type\":\"article\"}]', 0, '2025-11-12 13:42:01', '2025-11-12 13:42:01'),
(5, '5e0305ac-bfcd-11f0-af10-48ba4e5c5cd8', 2, 'CSS Basics and Selectors', 'text', '# CSS Basics and Selectors\r\n\r\nCSS (Cascading Style Sheets) is used to style and layout web pages.\r\n\r\n## Three Ways to Add CSS\r\n\r\n### 1. Inline CSS\r\n```html\r\n<p style=\"color: blue;\">Blue text</p>\r\n```\r\n\r\n### 2. Internal CSS\r\n```html\r\n<style>\r\n    p { color: blue; }\r\n</style>\r\n```\r\n\r\n### 3. External CSS (Recommended)\r\n```html\r\n<link rel=\"stylesheet\" href=\"styles.css\">\r\n```\r\n\r\n## CSS Selectors\r\n\r\n```css\r\n/* Element selector */\r\np {\r\n    color: black;\r\n}\r\n\r\n/* Class selector */\r\n.highlight {\r\n    background-color: yellow;\r\n}\r\n\r\n/* ID selector */\r\n#header {\r\n    font-size: 24px;\r\n}\r\n\r\n/* Attribute selector */\r\ninput[type=\"text\"] {\r\n    border: 1px solid gray;\r\n}\r\n\r\n/* Pseudo-class */\r\na:hover {\r\n    color: red;\r\n}\r\n```\r\n\r\n## CSS Specificity\r\n\r\nSpecificity determines which styles are applied:\r\n1. Inline styles (highest)\r\n2. IDs\r\n3. Classes, attributes, pseudo-classes\r\n4. Elements (lowest)\r\n\r\n## Common CSS Properties\r\n\r\n```css\r\n.box {\r\n    /* Colors */\r\n    color: #333;\r\n    background-color: #f0f0f0;\r\n    \r\n    /* Typography */\r\n    font-size: 16px;\r\n    font-weight: bold;\r\n    text-align: center;\r\n    \r\n    /* Box Model */\r\n    padding: 20px;\r\n    margin: 10px;\r\n    border: 1px solid #ddd;\r\n    \r\n    /* Dimensions */\r\n    width: 300px;\r\n    height: 200px;\r\n}\r\n```', 0, 45, '[{\"title\":\"CSS Selectors Reference\",\"url\":\"https://developer.mozilla.org/en-US/docs/Web/CSS/CSS_Selectors\",\"type\":\"article\"}]', 0, '2025-11-12 13:42:01', '2025-11-12 13:42:01'),
(6, '5e0abbc6-bfcd-11f0-af10-48ba4e5c5cd8', 2, 'Flexbox Layout', 'text', '# Flexbox Layout\r\n\r\nFlexbox is a powerful CSS layout system for creating flexible, responsive layouts.\r\n\r\n## Container Properties\r\n\r\n```css\r\n.container {\r\n    display: flex;\r\n    \r\n    /* Direction */\r\n    flex-direction: row; /* row, column, row-reverse, column-reverse */\r\n    \r\n    /* Wrapping */\r\n    flex-wrap: wrap; /* nowrap, wrap, wrap-reverse */\r\n    \r\n    /* Justify (main axis) */\r\n    justify-content: center; /* flex-start, flex-end, center, space-between, space-around */\r\n    \r\n    /* Align (cross axis) */\r\n    align-items: center; /* flex-start, flex-end, center, stretch, baseline */\r\n    \r\n    /* Gap */\r\n    gap: 20px;\r\n}\r\n```\r\n\r\n## Item Properties\r\n\r\n```css\r\n.item {\r\n    /* Flexibility */\r\n    flex: 1; /* flex-grow flex-shrink flex-basis */\r\n    \r\n    /* Individual alignment */\r\n    align-self: center;\r\n    \r\n    /* Order */\r\n    order: 2;\r\n}\r\n```\r\n\r\n## Practical Example: Navigation Bar\r\n\r\n```css\r\n.navbar {\r\n    display: flex;\r\n    justify-content: space-between;\r\n    align-items: center;\r\n    padding: 1rem;\r\n    background-color: #333;\r\n}\r\n\r\n.nav-links {\r\n    display: flex;\r\n    gap: 2rem;\r\n    list-style: none;\r\n}\r\n```\r\n\r\n## Common Flexbox Patterns\r\n\r\n### Centered Content\r\n```css\r\n.center {\r\n    display: flex;\r\n    justify-content: center;\r\n    align-items: center;\r\n    min-height: 100vh;\r\n}\r\n```\r\n\r\n### Equal Columns\r\n```css\r\n.columns {\r\n    display: flex;\r\n    gap: 20px;\r\n}\r\n\r\n.column {\r\n    flex: 1;\r\n}\r\n```', 1, 50, '[{\"title\":\"A Complete Guide to Flexbox\",\"url\":\"https://css-tricks.com/snippets/css/a-guide-to-flexbox/\",\"type\":\"article\"}]', 0, '2025-11-12 13:42:01', '2025-11-12 13:42:01'),
(7, '5e0abd70-bfcd-11f0-af10-48ba4e5c5cd8', 2, 'CSS Grid Layout', 'text', '# CSS Grid Layout\r\n\r\nCSS Grid is a two-dimensional layout system perfect for complex layouts.\r\n\r\n## Basic Grid Setup\r\n\r\n```css\r\n.grid-container {\r\n    display: grid;\r\n    \r\n    /* Define columns */\r\n    grid-template-columns: 200px 1fr 1fr; /* 3 columns */\r\n    \r\n    /* Define rows */\r\n    grid-template-rows: auto 1fr auto; /* 3 rows */\r\n    \r\n    /* Gap between items */\r\n    gap: 20px;\r\n}\r\n```\r\n\r\n## Grid Template Areas\r\n\r\n```css\r\n.layout {\r\n    display: grid;\r\n    grid-template-areas:\r\n        \"header header header\"\r\n        \"sidebar main main\"\r\n        \"footer footer footer\";\r\n    grid-template-columns: 200px 1fr 1fr;\r\n    gap: 10px;\r\n}\r\n\r\n.header { grid-area: header; }\r\n.sidebar { grid-area: sidebar; }\r\n.main { grid-area: main; }\r\n.footer { grid-area: footer; }\r\n```\r\n\r\n## Responsive Grid\r\n\r\n```css\r\n.responsive-grid {\r\n    display: grid;\r\n    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));\r\n    gap: 20px;\r\n}\r\n```\r\n\r\n## Grid Item Placement\r\n\r\n```css\r\n.item {\r\n    /* Start at column 1, span 2 columns */\r\n    grid-column: 1 / 3;\r\n    \r\n    /* Start at row 2, span 1 row */\r\n    grid-row: 2 / 3;\r\n}\r\n```\r\n\r\n## Practical Example: Photo Gallery\r\n\r\n```css\r\n.gallery {\r\n    display: grid;\r\n    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));\r\n    gap: 15px;\r\n    padding: 20px;\r\n}\r\n\r\n.gallery img {\r\n    width: 100%;\r\n    height: 200px;\r\n    object-fit: cover;\r\n    border-radius: 8px;\r\n}\r\n```', 2, 50, '[{\"title\":\"A Complete Guide to Grid\",\"url\":\"https://css-tricks.com/snippets/css/complete-guide-grid/\",\"type\":\"article\"}]', 0, '2025-11-12 13:42:01', '2025-11-12 13:42:01'),
(8, '5e0abe4b-bfcd-11f0-af10-48ba4e5c5cd8', 2, 'Responsive Design with Media Queries', 'text', '# Responsive Design with Media Queries\r\n\r\nMake your websites look great on all devices with responsive design techniques.\r\n\r\n## Mobile-First Approach\r\n\r\nStart with mobile styles, then add styles for larger screens:\r\n\r\n```css\r\n/* Mobile styles (default) */\r\n.container {\r\n    padding: 10px;\r\n}\r\n\r\n/* Tablet styles */\r\n@media (min-width: 768px) {\r\n    .container {\r\n        padding: 20px;\r\n    }\r\n}\r\n\r\n/* Desktop styles */\r\n@media (min-width: 1024px) {\r\n    .container {\r\n        padding: 40px;\r\n        max-width: 1200px;\r\n        margin: 0 auto;\r\n    }\r\n}\r\n```\r\n\r\n## Common Breakpoints\r\n\r\n```css\r\n/* Extra small devices (phones) */\r\n@media (max-width: 575px) { }\r\n\r\n/* Small devices (tablets) */\r\n@media (min-width: 576px) and (max-width: 767px) { }\r\n\r\n/* Medium devices (tablets/small laptops) */\r\n@media (min-width: 768px) and (max-width: 991px) { }\r\n\r\n/* Large devices (desktops) */\r\n@media (min-width: 992px) and (max-width: 1199px) { }\r\n\r\n/* Extra large devices (large desktops) */\r\n@media (min-width: 1200px) { }\r\n```\r\n\r\n## Responsive Typography\r\n\r\n```css\r\n:root {\r\n    font-size: 14px;\r\n}\r\n\r\n@media (min-width: 768px) {\r\n    :root {\r\n        font-size: 16px;\r\n    }\r\n}\r\n\r\nh1 {\r\n    font-size: 2rem; /* Scales with root font size */\r\n}\r\n```\r\n\r\n## Responsive Images\r\n\r\n```css\r\nimg {\r\n    max-width: 100%;\r\n    height: auto;\r\n}\r\n\r\n/* Art direction */\r\npicture {\r\n    display: block;\r\n}\r\n```\r\n\r\n## Flexbox Responsive Pattern\r\n\r\n```css\r\n.flex-container {\r\n    display: flex;\r\n    flex-wrap: wrap;\r\n    gap: 20px;\r\n}\r\n\r\n.flex-item {\r\n    flex: 1 1 300px; /* Grow, shrink, basis */\r\n    min-width: 0;\r\n}\r\n```\r\n\r\n## Grid Responsive Pattern\r\n\r\n```css\r\n.grid {\r\n    display: grid;\r\n    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));\r\n    gap: 20px;\r\n}\r\n```', 3, 45, '[{\"title\":\"Responsive Web Design Basics\",\"url\":\"https://web.dev/responsive-web-design-basics/\",\"type\":\"article\"}]', 0, '2025-11-12 13:42:01', '2025-11-12 13:42:01'),
(9, '5e0abf3b-bfcd-11f0-af10-48ba4e5c5cd8', 2, 'Project: Build a Responsive Portfolio Page', 'project', '# Project: Responsive Portfolio Page\r\n\r\nCreate a personal portfolio website that looks great on all devices.\r\n\r\n## Requirements\r\n\r\n### Layout:\r\n1. **Header** with navigation\r\n   - Logo/name\r\n   - Navigation menu (Home, About, Projects, Contact)\r\n   - Hamburger menu for mobile\r\n\r\n2. **Hero Section**\r\n   - Large heading with your name\r\n   - Brief introduction\r\n   - Call-to-action button\r\n\r\n3. **About Section**\r\n   - Profile picture\r\n   - Bio paragraph\r\n   - Skills list\r\n\r\n4. **Projects Section**\r\n   - Grid/card layout\r\n   - At least 3 project cards\r\n   - Each card has image, title, description\r\n\r\n5. **Contact Section**\r\n   - Contact form\r\n   - Social media links\r\n\r\n6. **Footer**\r\n   - Copyright info\r\n   - Additional links\r\n\r\n### Technical Requirements:\r\n- Use Flexbox OR Grid (or both)\r\n- Mobile-first approach\r\n- At least 2 media query breakpoints\r\n- Smooth transitions and hover effects\r\n- Valid HTML5 and CSS3\r\n- Responsive images\r\n\r\n## Design Tips:\r\n- Use a consistent color scheme (2-3 colors)\r\n- Choose readable fonts (Google Fonts)\r\n- Adequate spacing and whitespace\r\n- Clear visual hierarchy\r\n\r\n## Bonus Features:\r\n- Dark mode toggle\r\n- Animated scrolling\r\n- Image lightbox\r\n- Loading animations', 4, 180, '[{\"title\":\"Portfolio Inspiration\",\"url\":\"https://www.awwwards.com/websites/portfolio/\",\"type\":\"inspiration\"},{\"title\":\"Color Palette Generator\",\"url\":\"https://coolors.co/\",\"type\":\"tool\"}]', 0, '2025-11-12 13:42:01', '2025-11-12 13:42:01'),
(10, '5e28cc3e-bfcd-11f0-af10-48ba4e5c5cd8', 3, 'JavaScript Introduction & Variables', 'text', '# JavaScript Introduction\r\n\r\nJavaScript is a programming language that makes websites interactive.\r\n\r\n## Adding JavaScript to HTML\r\n\r\n```html\r\n<!-- Internal JavaScript -->\r\n<script>\r\n    console.log(\"Hello, JavaScript!\");\r\n</script>\r\n\r\n<!-- External JavaScript -->\r\n<script src=\"script.js\"></script>\r\n```\r\n\r\n## Variables\r\n\r\n```javascript\r\n// var (old way - avoid)\r\nvar name = \"John\";\r\n\r\n// let (can be reassigned)\r\nlet age = 25;\r\nage = 26; // OK\r\n\r\n// const (cannot be reassigned)\r\nconst PI = 3.14159;\r\n// PI = 3.14; // Error!\r\n```\r\n\r\n## Data Types\r\n\r\n```javascript\r\n// String\r\nlet name = \"Alice\";\r\nlet message = \'Hello, World!\';\r\n\r\n// Number\r\nlet age = 30;\r\nlet price = 19.99;\r\n\r\n// Boolean\r\nlet isActive = true;\r\nlet hasPermission = false;\r\n\r\n// Null\r\nlet emptyValue = null;\r\n\r\n// Undefined\r\nlet notAssigned;\r\nconsole.log(notAssigned); // undefined\r\n\r\n// Array\r\nlet colors = [\"red\", \"green\", \"blue\"];\r\n\r\n// Object\r\nlet person = {\r\n    name: \"John\",\r\n    age: 30,\r\n    email: \"john@example.com\"\r\n};\r\n```\r\n\r\n## Type Checking\r\n\r\n```javascript\r\ntypeof \"Hello\" // \"string\"\r\ntypeof 42      // \"number\"\r\ntypeof true    // \"boolean\"\r\ntypeof []      // \"object\"\r\ntypeof {}      // \"object\"\r\n```', 0, 40, '[{\"title\":\"JavaScript Basics\",\"url\":\"https://developer.mozilla.org/en-US/docs/Learn/Getting_started_with_the_web/JavaScript_basics\",\"type\":\"article\"}]', 0, '2025-11-12 13:42:01', '2025-11-12 13:42:01'),
(11, '5e2f1c96-bfcd-11f0-af10-48ba4e5c5cd8', 3, 'Functions and Control Flow', 'text', '# Functions and Control Flow\r\n\r\n## Functions\r\n\r\n```javascript\r\n// Function declaration\r\nfunction greet(name) {\r\n    return `Hello, ${name}!`;\r\n}\r\n\r\n// Function expression\r\nconst add = function(a, b) {\r\n    return a + b;\r\n};\r\n\r\n// Arrow function (ES6)\r\nconst multiply = (a, b) => a * b;\r\n\r\n// Calling functions\r\nconsole.log(greet(\"Alice\"));\r\nconsole.log(add(5, 3));\r\nconsole.log(multiply(4, 6));\r\n```\r\n\r\n## Conditional Statements\r\n\r\n```javascript\r\n// if-else\r\nlet age = 18;\r\nif (age >= 18) {\r\n    console.log(\"Adult\");\r\n} else if (age >= 13) {\r\n    console.log(\"Teenager\");\r\n} else {\r\n    console.log(\"Child\");\r\n}\r\n\r\n// Ternary operator\r\nlet status = age >= 18 ? \"Adult\" : \"Minor\";\r\n\r\n// Switch statement\r\nlet day = \"Monday\";\r\nswitch(day) {\r\n    case \"Monday\":\r\n        console.log(\"Start of week\");\r\n        break;\r\n    case \"Friday\":\r\n        console.log(\"Almost weekend!\");\r\n        break;\r\n    default:\r\n        console.log(\"Regular day\");\r\n}\r\n```\r\n\r\n## Loops\r\n\r\n```javascript\r\n// for loop\r\nfor (let i = 0; i < 5; i++) {\r\n    console.log(i);\r\n}\r\n\r\n// while loop\r\nlet count = 0;\r\nwhile (count < 5) {\r\n    console.log(count);\r\n    count++;\r\n}\r\n\r\n// for...of (arrays)\r\nlet fruits = [\"apple\", \"banana\", \"orange\"];\r\nfor (let fruit of fruits) {\r\n    console.log(fruit);\r\n}\r\n\r\n// forEach\r\nfruits.forEach(fruit => {\r\n    console.log(fruit);\r\n});\r\n```', 1, 45, '[{\"title\":\"JavaScript Functions\",\"url\":\"https://developer.mozilla.org/en-US/docs/Web/JavaScript/Guide/Functions\",\"type\":\"article\"}]', 0, '2025-11-12 13:42:01', '2025-11-12 13:42:01'),
(12, '5e2f1e58-bfcd-11f0-af10-48ba4e5c5cd8', 3, 'DOM Manipulation', 'text', '# DOM Manipulation\r\n\r\nThe Document Object Model (DOM) represents your HTML as a tree structure that JavaScript can interact with.\r\n\r\n## Selecting Elements\r\n\r\n```javascript\r\n// By ID\r\nlet element = document.getElementById(\"myId\");\r\n\r\n// By class\r\nlet elements = document.getElementsByClassName(\"myClass\");\r\n\r\n// By tag name\r\nlet paragraphs = document.getElementsByTagName(\"p\");\r\n\r\n// Query selector (CSS selectors)\r\nlet first = document.querySelector(\".myClass\");\r\nlet all = document.querySelectorAll(\".myClass\");\r\n```\r\n\r\n## Modifying Content\r\n\r\n```javascript\r\n// Text content\r\nelement.textContent = \"New text\";\r\n\r\n// HTML content\r\nelement.innerHTML = \"<strong>Bold text</strong>\";\r\n\r\n// Attributes\r\nelement.setAttribute(\"class\", \"active\");\r\nelement.getAttribute(\"id\");\r\nelement.removeAttribute(\"disabled\");\r\n```\r\n\r\n## Styling Elements\r\n\r\n```javascript\r\nelement.style.color = \"blue\";\r\nelement.style.backgroundColor = \"#f0f0f0\";\r\nelement.style.fontSize = \"18px\";\r\n\r\n// Add/remove classes\r\nelement.classList.add(\"active\");\r\nelement.classList.remove(\"hidden\");\r\nelement.classList.toggle(\"visible\");\r\n```\r\n\r\n## Creating and Removing Elements\r\n\r\n```javascript\r\n// Create new element\r\nlet newDiv = document.createElement(\"div\");\r\nnewDiv.textContent = \"New content\";\r\nnewDiv.classList.add(\"box\");\r\n\r\n// Append to parent\r\ndocument.body.appendChild(newDiv);\r\n\r\n// Remove element\r\nelement.remove();\r\n```\r\n\r\n## Event Handling\r\n\r\n```javascript\r\n// Click event\r\nbutton.addEventListener(\"click\", function() {\r\n    alert(\"Button clicked!\");\r\n});\r\n\r\n// Input event\r\ninput.addEventListener(\"input\", (e) => {\r\n    console.log(e.target.value);\r\n});\r\n\r\n// Form submit\r\nform.addEventListener(\"submit\", (e) => {\r\n    e.preventDefault(); // Prevent page reload\r\n    // Handle form data\r\n});\r\n```', 2, 50, '[{\"title\":\"DOM Manipulation Guide\",\"url\":\"https://developer.mozilla.org/en-US/docs/Learn/JavaScript/Client-side_web_APIs/Manipulating_documents\",\"type\":\"article\"}]', 0, '2025-11-12 13:42:01', '2025-11-12 13:42:01'),
(13, '5e2f1fcf-bfcd-11f0-af10-48ba4e5c5cd8', 3, 'Interactive Calculator Project', 'code', '# Project: Build an Interactive Calculator\r\n\r\nCreate a functional calculator using HTML, CSS, and JavaScript.\r\n\r\n## Requirements\r\n\r\n### HTML Structure:\r\n- Display screen for numbers\r\n- Number buttons (0-9)\r\n- Operator buttons (+, -, ×, ÷)\r\n- Equals button\r\n- Clear button\r\n- Decimal point button\r\n\r\n### Functionality:\r\n1. Click numbers to build operand\r\n2. Click operator to set operation\r\n3. Click equals to calculate result\r\n4. Clear button resets calculator\r\n5. Handle decimal numbers\r\n6. Prevent invalid operations\r\n7. Display shows current input/result\r\n\r\n### Technical Requirements:\r\n```javascript\r\n// Calculator state\r\nlet currentOperand = \"\";\r\nlet previousOperand = \"\";\r\nlet operation = null;\r\n\r\n// Functions needed:\r\n- clear()\r\n- appendNumber(number)\r\n- chooseOperation(op)\r\n- compute()\r\n- updateDisplay()\r\n```\r\n\r\n### CSS Styling:\r\n- Grid layout for buttons\r\n- Hover effects\r\n- Active states\r\n- Responsive design\r\n\r\n## Bonus Features:\r\n- Keyboard support\r\n- Operation history\r\n- Scientific functions\r\n- Memory functions (M+, M-, MR, MC)\r\n- Percentage calculation', 3, 120, '[{\"title\":\"Calculator Tutorial\",\"url\":\"https://www.youtube.com/watch?v=j59qQ7YWLxw\",\"type\":\"video\"}]', 0, '2025-11-12 13:42:01', '2025-11-12 13:42:01'),
(14, '5e448e96-bfcd-11f0-af10-48ba4e5c5cd8', 4, 'ES6+ Features', 'text', '# Modern JavaScript (ES6+)\r\n\r\n## Arrow Functions\r\n```javascript\r\nconst add = (a, b) => a + b;\r\n```\r\n\r\n## Template Literals\r\n```javascript\r\nconst name = \"Alice\";\r\nconsole.log(`Hello, ${name}!`);\r\n```\r\n\r\n## Destructuring\r\n```javascript\r\nconst [a, b] = [1, 2];\r\nconst {name, age} = person;\r\n```\r\n\r\n## Spread Operator\r\n```javascript\r\nconst arr1 = [1, 2];\r\nconst arr2 = [...arr1, 3, 4];\r\n```\r\n\r\n## Async/Await\r\n```javascript\r\nasync function fetchData() {\r\n    const response = await fetch(url);\r\n    const data = await response.json();\r\n    return data;\r\n}\r\n```', 0, 50, '[]', 0, '2025-11-12 13:42:01', '2025-11-12 13:42:01'),
(15, '5e499637-bfcd-11f0-af10-48ba4e5c5cd8', 4, 'Fetch API and Promises', 'text', '# Working with APIs\r\n\r\n## Fetch API\r\n```javascript\r\nfetch(\"https://api.example.com/data\")\r\n    .then(response => response.json())\r\n    .then(data => console.log(data))\r\n    .catch(error => console.error(error));\r\n```\r\n\r\n## Async/Await Pattern\r\n```javascript\r\nasync function getData() {\r\n    try {\r\n        const response = await fetch(url);\r\n        const data = await response.json();\r\n        console.log(data);\r\n    } catch (error) {\r\n        console.error(\"Error:\", error);\r\n    }\r\n}\r\n```', 1, 45, '[]', 0, '2025-11-12 13:42:01', '2025-11-12 13:42:01');

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

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`id`, `uuid`, `course_id`, `title`, `description`, `order_index`, `content`, `objectives`, `status`, `created_at`, `updated_at`) VALUES
(1, '5d4d732d-bfcd-11f0-af10-48ba4e5c5cd8', 1, 'HTML5 Fundamentals', 'Learn the building blocks of web development with HTML5. Master semantic markup, forms, and modern HTML features.', 0, NULL, '[\"Understand HTML document structure\", \"Create semantic HTML markup\", \"Build accessible web forms\", \"Use HTML5 multimedia elements\", \"Apply SEO best practices\"]', 'published', '2025-11-12 13:42:00', '2025-11-12 13:42:00'),
(2, '5d7257ac-bfcd-11f0-af10-48ba4e5c5cd8', 1, 'CSS3 & Responsive Design', 'Style beautiful websites with CSS3. Learn Flexbox, Grid, animations, and mobile-first responsive design.', 1, NULL, '[\"Master CSS selectors and specificity\", \"Create flexible layouts with Flexbox and Grid\", \"Implement responsive design patterns\", \"Add animations and transitions\", \"Optimize CSS for performance\"]', 'published', '2025-11-12 13:42:00', '2025-11-12 13:42:00'),
(3, '5d88847f-bfcd-11f0-af10-48ba4e5c5cd8', 1, 'JavaScript Basics', 'Get started with JavaScript programming. Learn variables, functions, control flow, and DOM manipulation.', 2, NULL, '[\"Understand JavaScript fundamentals\", \"Work with variables and data types\", \"Write functions and control structures\", \"Manipulate the DOM\", \"Handle events and user interactions\"]', 'published', '2025-11-12 13:42:00', '2025-11-12 13:42:00'),
(4, '5d962ae9-bfcd-11f0-af10-48ba4e5c5cd8', 1, 'Advanced JavaScript', 'Deep dive into ES6+, async programming, API integration, and modern JavaScript patterns.', 3, NULL, '[\"Master ES6+ features and syntax\", \"Understand asynchronous JavaScript\", \"Work with Fetch API and Promises\", \"Implement modern JavaScript patterns\", \"Debug and optimize JavaScript code\"]', 'published', '2025-11-12 13:42:00', '2025-11-12 13:42:00'),
(5, '5dab4364-bfcd-11f0-af10-48ba4e5c5cd8', 1, 'React Fundamentals', 'Learn React.js to build dynamic user interfaces. Master components, props, state, and hooks.', 4, NULL, '[\"Understand React core concepts\", \"Create functional components\", \"Manage state with hooks\", \"Handle props and component composition\", \"Build interactive UIs\"]', 'published', '2025-11-12 13:42:00', '2025-11-12 13:42:00'),
(6, '5db7a95c-bfcd-11f0-af10-48ba4e5c5cd8', 1, 'React Advanced Concepts', 'Master advanced React patterns, routing, state management, and performance optimization.', 5, NULL, '[\"Implement React Router for navigation\", \"Manage global state effectively\", \"Optimize React performance\", \"Use Context API and custom hooks\", \"Test React components\"]', 'published', '2025-11-12 13:42:01', '2025-11-12 13:42:01'),
(7, '5dbf754b-bfcd-11f0-af10-48ba4e5c5cd8', 1, 'Version Control with Git', 'Master Git for version control. Learn branching, merging, and collaboration workflows.', 6, NULL, '[\"Understand version control concepts\", \"Use Git commands effectively\", \"Manage branches and merges\", \"Collaborate with GitHub\", \"Follow Git best practices\"]', 'published', '2025-11-12 13:42:01', '2025-11-12 13:42:01'),
(8, '5dc8d87e-bfcd-11f0-af10-48ba4e5c5cd8', 1, 'Final Capstone Project', 'Build a complete full-stack web application from scratch. Showcase all the skills you\'ve learned.', 7, NULL, '[\"Plan and design a web application\", \"Implement frontend with React\", \"Deploy to production\", \"Present and document your project\", \"Build your developer portfolio\"]', 'published', '2025-11-12 13:42:01', '2025-11-12 13:42:01'),
(9, 'f406fdea-256e-4f5a-8eeb-b47d9ab2fb57', 2, 'M1', 'Never Mind', 0, NULL, NULL, 'draft', '2025-11-12 21:33:16', '2025-11-12 21:33:16');

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
(11, '494d41ba-a5e8-4450-bc82-1743a2616357', 'admin@gmail.com', '$2y$12$m6VwmXATAyGZ6svEcaZ0uO3gXkvd/Ogsj7PPxTKRnlrcG4sUVPLv.', 'Admin', 'Admin', 'admin', 'student', NULL, 'academy', NULL, 'active', NULL, '2025-11-10 09:32:14', '2025-11-12 13:48:47', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'UTC', 'en', 1, 0, 0);

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
  ADD KEY `fk_courses_category` (`category_id`);

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

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
  ADD CONSTRAINT `fk_courses_category` FOREIGN KEY (`category_id`) REFERENCES `course_categories` (`id`) ON DELETE SET NULL;

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
