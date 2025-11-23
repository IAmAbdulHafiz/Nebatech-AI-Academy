-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 22, 2025 at 06:18 PM
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
  `user_id` int(10) UNSIGNED NOT NULL,
  `program` varchar(100) NOT NULL,
  `educational_background` text DEFAULT NULL,
  `motivation_statement` text DEFAULT NULL,
  `referral_source` varchar(100) DEFAULT NULL,
  `document_path` varchar(255) DEFAULT NULL,
  `status` enum('pending','approved','rejected','info_requested') DEFAULT 'pending',
  `reviewed_by` int(10) UNSIGNED DEFAULT NULL,
  `reviewed_at` timestamp NULL DEFAULT NULL,
  `admin_notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `due_date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `assignments`
--

INSERT INTO `assignments` (`id`, `uuid`, `lesson_id`, `title`, `description`, `instructions`, `rubric`, `max_score`, `due_date`, `created_at`, `updated_at`) VALUES
(1, '34415ef4-ae62-4f3d-8787-d1297343e915', 4, 'Contact Form Project', 'Build an HTML contact form', NULL, '[{\"criteria\":\"Functionality\",\"description\":\"Works as expected\",\"max_points\":40},{\"criteria\":\"Code Quality\",\"description\":\"Clean, organized code\",\"max_points\":30},{\"criteria\":\"Design\",\"description\":\"Professional appearance\",\"max_points\":30}]', 100, '2025-11-14 21:45:15', '2025-11-07 21:45:15', '2025-11-07 21:45:15'),
(2, '063f0f9c-d63e-4e92-b68c-3a7cef8ab20c', 9, 'Portfolio Website', 'Create a responsive portfolio', NULL, '[{\"criteria\":\"Functionality\",\"description\":\"Works as expected\",\"max_points\":40},{\"criteria\":\"Code Quality\",\"description\":\"Clean, organized code\",\"max_points\":30},{\"criteria\":\"Design\",\"description\":\"Professional appearance\",\"max_points\":30}]', 100, '2025-11-14 21:45:15', '2025-11-07 21:45:15', '2025-11-07 21:45:15'),
(3, '304c14a3-30ea-439e-b857-320de88423e3', 13, 'Calculator App', 'Build a JavaScript calculator', NULL, '[{\"criteria\":\"Functionality\",\"description\":\"Works as expected\",\"max_points\":40},{\"criteria\":\"Code Quality\",\"description\":\"Clean, organized code\",\"max_points\":30},{\"criteria\":\"Design\",\"description\":\"Professional appearance\",\"max_points\":30}]', 100, '2025-11-14 21:45:15', '2025-11-07 21:45:15', '2025-11-07 21:45:15');

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
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `color` varchar(7) DEFAULT '#002060',
  `icon` varchar(50) DEFAULT NULL,
  `order_index` int(10) UNSIGNED DEFAULT 0,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blog_categories`
--

INSERT INTO `blog_categories` (`id`, `name`, `slug`, `description`, `color`, `icon`, `order_index`, `status`, `created_at`, `updated_at`) VALUES
(1, 'AI & Machine Learning', 'ai-machine-learning', NULL, '#002060', NULL, 0, 'active', '2025-11-17 01:32:48', '2025-11-17 01:32:48'),
(2, 'Career Development', 'career-development', NULL, '#FF5722', NULL, 0, 'active', '2025-11-17 01:32:48', '2025-11-17 01:32:48'),
(3, 'Tutorials', 'tutorials', NULL, '#4CAF50', NULL, 0, 'active', '2025-11-17 01:32:48', '2025-11-17 01:32:48'),
(4, 'Industry News', 'industry-news', NULL, '#2196F3', NULL, 0, 'active', '2025-11-17 01:32:48', '2025-11-17 01:32:48'),
(5, 'Student Success', 'student-success', NULL, '#FF9800', NULL, 0, 'active', '2025-11-17 01:32:48', '2025-11-17 01:32:48'),
(6, 'Tech Skills', 'tech-skills', NULL, '#9C27B0', NULL, 0, 'active', '2025-11-17 01:32:48', '2025-11-17 01:32:48');

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

--
-- Dumping data for table `blog_comments`
--

INSERT INTO `blog_comments` (`id`, `post_id`, `user_id`, `parent_id`, `content`, `status`, `created_at`, `updated_at`) VALUES
(1, 5, 1, NULL, 'Great article! This really inspired me to start learning AI. Ghana is definitely leading the way in tech innovation.', 'approved', '2025-11-16 23:32:49', '2025-11-17 01:32:49'),
(2, 5, 1, NULL, 'I\'ve been following the AI scene in Africa for years, and it\'s amazing to see how far we\'ve come. Thanks for sharing!', 'approved', '2025-11-16 20:32:49', '2025-11-17 01:32:49'),
(3, 5, 1, NULL, 'As someone just starting in AI, this gives me so much hope. Can\'t wait to join the next cohort at Nebatech!', 'approved', '2025-11-16 01:32:49', '2025-11-17 01:32:49');

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
  `content` longtext NOT NULL,
  `featured_image` varchar(255) DEFAULT NULL,
  `author_id` int(10) UNSIGNED NOT NULL,
  `category_id` int(10) UNSIGNED DEFAULT NULL,
  `tags` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`tags`)),
  `read_time` int(10) UNSIGNED DEFAULT NULL COMMENT 'Estimated read time in minutes',
  `views` int(10) UNSIGNED DEFAULT 0,
  `is_featured` tinyint(1) DEFAULT 0,
  `status` enum('draft','published','archived') DEFAULT 'draft',
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blog_posts`
--

INSERT INTO `blog_posts` (`id`, `uuid`, `title`, `slug`, `excerpt`, `content`, `featured_image`, `author_id`, `category_id`, `tags`, `read_time`, `views`, `is_featured`, `status`, `published_at`, `created_at`, `updated_at`) VALUES
(1, '6f182d7f-c355-11f0-9f21-f48e38a80c71', 'The Future of AI in Africa: Why Ghana is Leading the Tech Revolution', 'future-of-ai-in-africa', 'Discover how Ghana is becoming a tech hub and why AI education is crucial for Africa\'s future.', '<h2>Ghana\'s Emerging Tech Ecosystem</h2>\n<p>Ghana is rapidly positioning itself as a leading technology hub in West Africa. With a growing number of tech startups, increased investment in digital infrastructure, and a young, tech-savvy population, the country is poised to lead Africa\'s AI revolution.</p>\n\n<h2>Why AI Education Matters</h2>\n<p>As artificial intelligence continues to transform industries globally, African nations have a unique opportunity to leapfrog traditional development models. By investing in AI education and skills training, Ghana can prepare its workforce for the jobs of tomorrow.</p>\n\n<h2>Nebatech\'s Role in the Revolution</h2>\n<p>At Nebatech AI Academy, we\'re committed to democratizing AI education. Our programs are designed specifically for African learners, addressing real-world challenges and opportunities in our local context.</p>\n\n<h3>Key Areas of Focus:</h3>\n<ul>\n<li><strong>Machine Learning Fundamentals:</strong> Building a strong foundation in ML algorithms and applications</li>\n<li><strong>Natural Language Processing:</strong> Enabling AI to understand and process African languages</li>\n<li><strong>Computer Vision:</strong> Solving visual recognition challenges in African contexts</li>\n<li><strong>Data Science:</strong> Extracting insights from Africa-specific datasets</li>\n</ul>\n\n<h2>Success Stories</h2>\n<p>Our students are already making an impact. From building agricultural AI solutions to creating healthcare diagnostics tools, they\'re proving that African innovation can compete globally.</p>\n\n<blockquote>\n\"The future of AI is not just in Silicon Valley ??? it\'s being written right here in Accra, Lagos, Nairobi, and across the continent.\" - Dr. Kwame Mensah, Tech Innovator\n</blockquote>\n\n<h2>Join the Movement</h2>\n<p>Whether you\'re a complete beginner or looking to advance your AI skills, there\'s never been a better time to start. The AI revolution is here ??? and Africa must be part of it.</p>', NULL, 1, 1, '[\"AI\", \"Ghana\", \"Africa\", \"Technology\", \"Innovation\", \"Future\"]', NULL, 1247, 1, 'published', '2025-11-17 01:32:48', '2025-11-17 01:32:48', '2025-11-17 01:32:48'),
(2, '6f1c35cf-c355-11f0-9f21-f48e38a80c71', 'Getting Started with Python for AI: A Beginner\'s Guide', 'getting-started-python-ai', 'Learn the fundamentals of Python programming and why it\'s the go-to language for AI development.', '<h2>Why Python for AI?</h2>\n<p>Python has become the de facto language for artificial intelligence and machine learning. Its simple syntax, extensive libraries, and strong community support make it ideal for both beginners and experts.</p>\n\n<h2>Essential Python Libraries for AI</h2>\n<ul>\n<li><strong>NumPy:</strong> Numerical computing with powerful array operations</li>\n<li><strong>Pandas:</strong> Data manipulation and analysis</li>\n<li><strong>Scikit-learn:</strong> Machine learning algorithms and tools</li>\n<li><strong>TensorFlow/PyTorch:</strong> Deep learning frameworks</li>\n<li><strong>Matplotlib/Seaborn:</strong> Data visualization</li>\n</ul>\n\n<h2>Your First Python AI Project</h2>\n<pre><code>\nimport numpy as np\nfrom sklearn.linear_model import LinearRegression\n\n# Sample data\nX = np.array([[1], [2], [3], [4], [5]])\ny = np.array([2, 4, 6, 8, 10])\n\n# Create and train model\nmodel = LinearRegression()\nmodel.fit(X, y)\n\n# Make prediction\nprediction = model.predict([[6]])\nprint(f\"Predicted value: {prediction[0]}\")\n</code></pre>\n\n<h2>Next Steps</h2>\n<p>This is just the beginning. Practice regularly, build projects, and join our community to accelerate your learning journey.</p>', NULL, 1, 3, '[\"Python\", \"Programming\", \"Tutorial\", \"Beginners\", \"AI\"]', NULL, 856, 0, 'published', '2025-11-15 01:32:48', '2025-11-15 01:32:48', '2025-11-17 01:32:48'),
(3, '6f1c4b0b-c355-11f0-9f21-f48e38a80c71', '10 Machine Learning Algorithms Every Data Scientist Should Know', '10-ml-algorithms-data-scientists', 'Master these fundamental machine learning algorithms to build powerful predictive models.', '<h2>Essential ML Algorithms</h2>\n<p>Machine learning offers a vast array of algorithms, but mastering these 10 will give you a solid foundation for most real-world problems.</p>\n\n<h3>1. Linear Regression</h3>\n<p>Perfect for predicting continuous values. Use cases: house price prediction, sales forecasting.</p>\n\n<h3>2. Logistic Regression</h3>\n<p>Despite its name, it\'s used for classification. Great for binary outcomes like spam detection.</p>\n\n<h3>3. Decision Trees</h3>\n<p>Intuitive and interpretable. Excellent for both classification and regression tasks.</p>\n\n<h3>4. Random Forests</h3>\n<p>An ensemble of decision trees that reduces overfitting and improves accuracy.</p>\n\n<h3>5. Support Vector Machines (SVM)</h3>\n<p>Powerful for classification, especially in high-dimensional spaces.</p>\n\n<h3>6. K-Nearest Neighbors (KNN)</h3>\n<p>Simple yet effective for both classification and regression.</p>\n\n<h3>7. Naive Bayes</h3>\n<p>Fast and efficient for text classification and spam filtering.</p>\n\n<h3>8. Neural Networks</h3>\n<p>The foundation of deep learning. Capable of learning complex patterns.</p>\n\n<h3>9. K-Means Clustering</h3>\n<p>Unsupervised learning for grouping similar data points.</p>\n\n<h3>10. Gradient Boosting (XGBoost/LightGBM)</h3>\n<p>State-of-the-art for structured data competitions and real-world applications.</p>\n\n<h2>How to Choose?</h2>\n<p>The best algorithm depends on your data, problem type, and constraints. Start simple, experiment, and iterate.</p>', NULL, 1, 3, '[\"Machine Learning\", \"Algorithms\", \"Data Science\", \"Tutorial\"]', NULL, 1092, 0, 'published', '2025-11-12 01:32:48', '2025-11-12 01:32:48', '2025-11-17 01:32:48'),
(4, '6f1c5fd7-c355-11f0-9f21-f48e38a80c71', 'From Zero to AI Engineer: A Realistic 6-Month Roadmap', 'zero-to-ai-engineer-roadmap', 'A practical, step-by-step guide to transition into an AI engineering career in just 6 months.', '<h2>The Reality Check</h2>\n<p>Becoming an AI engineer in 6 months is ambitious but achievable with focused effort. This roadmap is based on real students who successfully made the transition.</p>\n\n<h2>Month 1-2: Foundations</h2>\n<ul>\n<li>Learn Python programming (4-6 hours/day)</li>\n<li>Master NumPy, Pandas, Matplotlib</li>\n<li>Understand basic statistics and linear algebra</li>\n<li>Complete 3-5 beginner projects</li>\n</ul>\n\n<h2>Month 3-4: Machine Learning Core</h2>\n<ul>\n<li>Study ML algorithms and theory</li>\n<li>Learn Scikit-learn library</li>\n<li>Practice on Kaggle competitions</li>\n<li>Build 2-3 end-to-end ML projects</li>\n</ul>\n\n<h2>Month 5-6: Deep Learning & Specialization</h2>\n<ul>\n<li>Master TensorFlow or PyTorch</li>\n<li>Study neural networks and deep learning</li>\n<li>Choose a specialization (NLP, Computer Vision, etc.)</li>\n<li>Build portfolio projects showcasing your skills</li>\n</ul>\n\n<h2>Key Success Factors</h2>\n<ol>\n<li><strong>Consistency:</strong> Study daily, even if just 2-3 hours</li>\n<li><strong>Projects:</strong> Build real applications, not just tutorials</li>\n<li><strong>Community:</strong> Join study groups and forums</li>\n<li><strong>Feedback:</strong> Get code reviews from experienced developers</li>\n</ol>\n\n<p class=\"highlight\">Remember: It\'s not about being perfect ??? it\'s about consistent progress.</p>', NULL, 1, 2, '[\"Career\", \"Learning Path\", \"AI Engineer\", \"Roadmap\"]', NULL, 2341, 0, 'published', '2025-11-10 01:32:48', '2025-11-10 01:32:48', '2025-11-17 01:32:48'),
(5, '6f1c69eb-c355-11f0-9f21-f48e38a80c71', 'How I Landed My First AI Job Without a Computer Science Degree', 'first-ai-job-without-cs-degree', 'Real story from a Nebatech graduate who transitioned from teaching to AI engineering.', '<h2>My Background</h2>\n<p>I was a high school mathematics teacher with no formal computer science education. At 32, I decided to change careers ??? a decision that changed my life.</p>\n\n<h2>The Journey</h2>\n<p>I enrolled in Nebatech\'s AI Bootcamp while still teaching. Mornings were for students, evenings and weekends for coding. It wasn\'t easy, but it was worth it.</p>\n\n<h3>What Worked:</h3>\n<ul>\n<li><strong>Leveraging My Math Background:</strong> My teaching experience helped me understand ML algorithms quickly</li>\n<li><strong>Building Projects:</strong> I created an educational AI tool that got noticed</li>\n<li><strong>Networking:</strong> Attended every tech meetup in Accra</li>\n<li><strong>Contributing to Open Source:</strong> Showed my coding skills publicly</li>\n</ul>\n\n<h2>The Breakthrough</h2>\n<p>After 8 months of learning, I applied to 47 positions. Got 3 interviews. One job offer. That\'s all I needed.</p>\n\n<blockquote>\n\"They didn\'t care about my degree. They cared about what I could build and my ability to learn.\" - Ama Adjei, AI Engineer at TechCorp Ghana\n</blockquote>\n\n<h2>Advice for Career Changers</h2>\n<ol>\n<li>Your previous experience is valuable ??? use it</li>\n<li>Focus on practical skills over theory</li>\n<li>Build a portfolio that solves real problems</li>\n<li>Network authentically, not transactionally</li>\n<li>Be patient but persistent</li>\n</ol>', NULL, 1, 2, '[\"Career Change\", \"Success Story\", \"No Degree\", \"Inspiration\"]', NULL, 1876, 0, 'published', '2025-11-07 01:32:48', '2025-11-07 01:32:48', '2025-11-17 01:32:48'),
(6, '6f1c72e3-c355-11f0-9f21-f48e38a80c71', 'African AI Startups Raised $2.3B in 2024: What This Means for Tech Education', 'african-ai-startups-funding-2024', 'Record-breaking investment in African AI companies signals a massive opportunity for skilled professionals.', '<h2>The Investment Boom</h2>\n<p>2024 marked a historic year for African tech, with AI startups raising $2.3 billion across the continent. This represents a 145% increase from 2023.</p>\n\n<h2>Where the Money is Going</h2>\n<ul>\n<li><strong>Fintech AI:</strong> $780M (34%)</li>\n<li><strong>AgriTech:</strong> $450M (20%)</li>\n<li><strong>HealthTech:</strong> $380M (17%)</li>\n<li><strong>EdTech:</strong> $290M (13%)</li>\n<li><strong>Other:</strong> $370M (16%)</li>\n</ul>\n\n<h2>Job Market Impact</h2>\n<p>With increased funding comes increased hiring. We\'re seeing unprecedented demand for:</p>\n<ul>\n<li>Machine Learning Engineers</li>\n<li>Data Scientists</li>\n<li>AI Product Managers</li>\n<li>MLOps Engineers</li>\n</ul>\n\n<h3>Salary Ranges (Ghana, 2024):</h3>\n<ul>\n<li>Junior ML Engineer: GH??? 48,000 - 72,000/year</li>\n<li>Mid-level Data Scientist: GH??? 84,000 - 120,000/year</li>\n<li>Senior AI Engineer: GH??? 144,000 - 240,000+/year</li>\n</ul>\n\n<h2>The Skills Gap</h2>\n<p>Despite the investment boom, there\'s a critical shortage of AI talent. This is where quality education becomes crucial.</p>\n\n<p class=\"highlight\">Now is the perfect time to enter the AI field in Africa. The opportunities are real, and the timing couldn\'t be better.</p>', NULL, 1, 4, '[\"Investment\", \"Startups\", \"Africa\", \"Jobs\", \"Industry\"]', NULL, 945, 0, 'published', '2025-11-14 01:32:48', '2025-11-14 01:32:48', '2025-11-17 01:32:48'),
(7, '6f1c7f91-c355-11f0-9f21-f48e38a80c71', 'Meet Kwabena: From Unemployed Graduate to Lead AI Engineer at Jumia', 'student-success-kwabena-jumia', 'How one determined graduate used Nebatech training to land his dream job at one of Africa\'s largest e-commerce platforms.', '<h2>The Starting Point</h2>\n<p>Kwabena graduated with a degree in Business Administration in 2022. After 14 months of job hunting with no luck, he decided to pivot into tech.</p>\n\n<h2>The Transformation</h2>\n<p>\"I had no coding experience whatsoever,\" Kwabena recalls. \"But I knew AI was the future, and Nebatech\'s program was designed for people like me.\"</p>\n\n<h3>His Journey:</h3>\n<ul>\n<li><strong>Month 1-3:</strong> Intensive Python and ML fundamentals</li>\n<li><strong>Month 4-6:</strong> Built 5 portfolio projects including a recommendation system</li>\n<li><strong>Month 7:</strong> Applied to 23 positions, got 5 interviews</li>\n<li><strong>Month 8:</strong> Landed junior role at local startup</li>\n<li><strong>Month 18:</strong> Promoted to Lead AI Engineer at Jumia</li>\n</ul>\n\n<h2>The Secret Sauce</h2>\n<p>When asked about his rapid success, Kwabena emphasizes three things:</p>\n<ol>\n<li><strong>Consistent Practice:</strong> Coded every single day, even when motivated</li>\n<li><strong>Real Projects:</strong> Built solutions for actual problems, not just tutorials</li>\n<li><strong>Community Support:</strong> Active in Nebatech community, helping others learn</li>\n</ol>\n\n<blockquote>\n\"Nebatech didn\'t just teach me technical skills. They taught me how to think like an engineer and solve problems systematically.\" - Kwabena Osei\n</blockquote>\n\n<h2>His Advice</h2>\n<p>\"Don\'t wait for the perfect moment. Start today. The tech industry doesn\'t care where you came from ??? only where you\'re going and what you can build.\"</p>', NULL, 1, 5, '[\"Success Story\", \"Student\", \"Career Change\", \"Inspiration\"]', NULL, 1567, 0, 'published', '2025-11-16 01:32:48', '2025-11-16 01:32:48', '2025-11-17 01:32:48'),
(8, '6f1c85cc-c355-11f0-9f21-f48e38a80c71', '5 Data Science Projects to Build Your Portfolio in 2025', '5-data-science-projects-portfolio', 'Hands-on projects that will make your portfolio stand out to employers.', '<h2>Why Portfolio Projects Matter</h2>\n<p>In data science, your projects speak louder than your resume. Here are 5 project ideas that demonstrate real-world skills employers seek.</p>\n\n<h2>1. Predictive Analytics Dashboard</h2>\n<p><strong>Skills:</strong> Python, Pandas, Plotly, Machine Learning</p>\n<p>Build an interactive dashboard that predicts business metrics. Use real or synthetic data to forecast sales, customer churn, or inventory needs.</p>\n\n<h2>2. Natural Language Processing Application</h2>\n<p><strong>Skills:</strong> NLP, Sentiment Analysis, Text Classification</p>\n<p>Create a tool that analyzes social media sentiment or classifies customer feedback. Bonus: Train on African language data.</p>\n\n<h2>3. Computer Vision Solution</h2>\n<p><strong>Skills:</strong> CNN, Image Processing, TensorFlow/PyTorch</p>\n<p>Build an image classifier, object detector, or facial recognition system. Consider agricultural or healthcare applications relevant to Africa.</p>\n\n<h2>4. Recommendation Engine</h2>\n<p><strong>Skills:</strong> Collaborative Filtering, Content-Based Filtering</p>\n<p>Develop a product or content recommendation system. Show how you handle cold start problems and improve recommendations over time.</p>\n\n<h2>5. End-to-End ML Pipeline</h2>\n<p><strong>Skills:</strong> MLOps, Docker, FastAPI, Cloud Deployment</p>\n<p>Build a complete machine learning system from data collection to deployment. Include monitoring, versioning, and CI/CD.</p>\n\n<h2>Key Success Factors</h2>\n<ul>\n<li>Clean, well-documented code on GitHub</li>\n<li>Deployed application (not just notebooks)</li>\n<li>Clear README explaining your approach</li>\n<li>Blog post or video walkthrough</li>\n</ul>', NULL, 1, 6, '[\"Projects\", \"Portfolio\", \"Data Science\", \"Practical\"]', NULL, 721, 0, 'published', '2025-11-13 01:32:48', '2025-11-13 01:32:48', '2025-11-17 01:32:48'),
(9, '6f1c925f-c355-11f0-9f21-f48e38a80c71', 'Understanding Neural Networks: A Visual Guide', 'understanding-neural-networks-visual-guide', 'Break down the complexity of neural networks with intuitive visualizations and simple explanations.', '<h2>What Are Neural Networks?</h2>\n<p>Neural networks are computing systems inspired by biological neural networks in animal brains. They\'re the foundation of deep learning and modern AI.</p>\n\n<h2>Basic Structure</h2>\n<p>A neural network consists of layers of interconnected nodes (neurons):</p>\n<ul>\n<li><strong>Input Layer:</strong> Receives the initial data</li>\n<li><strong>Hidden Layers:</strong> Process and transform the data</li>\n<li><strong>Output Layer:</strong> Produces the final prediction</li>\n</ul>\n\n<h2>How They Learn</h2>\n<p>Neural networks learn through a process called backpropagation:</p>\n<ol>\n<li>Forward pass: Data flows through network, producing prediction</li>\n<li>Calculate error: Compare prediction with actual answer</li>\n<li>Backward pass: Adjust weights to reduce error</li>\n<li>Repeat thousands of times</li>\n</ol>\n\n<h2>Real-World Applications</h2>\n<ul>\n<li>Image recognition (identifying objects in photos)</li>\n<li>Speech recognition (converting speech to text)</li>\n<li>Language translation (Google Translate)</li>\n<li>Autonomous vehicles (self-driving cars)</li>\n<li>Medical diagnosis (detecting diseases from scans)</li>\n</ul>\n\n<p>Start simple, experiment often, and build intuition through practice.</p>', NULL, 1, 3, '[\"Neural Networks\", \"Deep Learning\", \"Tutorial\", \"Visualization\"]', NULL, 634, 0, 'published', '2025-11-11 01:32:48', '2025-11-11 01:32:48', '2025-11-17 01:32:48'),
(10, '6f1f260e-c355-11f0-9f21-f48e38a80c71', 'AI Ethics in Africa: Why It Matters More Than You Think', 'ai-ethics-africa-importance', 'Exploring the unique ethical challenges and opportunities of AI development in African contexts.', '<h2>The Ethics Gap</h2>\n<p>As AI rapidly advances in Africa, we must ensure it\'s developed and deployed responsibly. The stakes are too high to get it wrong.</p>\n\n<h2>Key Ethical Concerns</h2>\n\n<h3>1. Bias and Fairness</h3>\n<p>AI models trained on Western data may not work well for African populations. We need African data for African solutions.</p>\n\n<h3>2. Privacy and Data Rights</h3>\n<p>Who owns the data? How is it used? These questions are critical as AI systems collect more personal information.</p>\n\n<h3>3. Job Displacement</h3>\n<p>While AI creates jobs, it also eliminates others. How do we manage this transition fairly?</p>\n\n<h3>4. Accessibility</h3>\n<p>Ensuring AI benefits reach everyone, not just the wealthy or tech-savvy.</p>\n\n<h2>African Solutions</h2>\n<p>Rather than importing Western ethical frameworks wholesale, Africa has an opportunity to develop AI ethics grounded in our values:</p>\n<ul>\n<li><strong>Ubuntu Philosophy:</strong> \"I am because we are\" - community-centered AI</li>\n<li><strong>Inclusivity:</strong> Diverse languages, cultures, and contexts</li>\n<li><strong>Sustainability:</strong> Long-term thinking about AI\'s impact</li>\n</ul>\n\n<h2>What You Can Do</h2>\n<ol>\n<li>Question the data you use for training models</li>\n<li>Test your AI systems across diverse populations</li>\n<li>Be transparent about limitations and biases</li>\n<li>Involve communities affected by your AI</li>\n<li>Advocate for ethical AI policies</li>\n</ol>\n\n<p>The future of AI in Africa depends on choices we make today. Let\'s build responsibly.</p>', NULL, 1, 1, '[\"Ethics\", \"AI\", \"Africa\", \"Responsibility\", \"Society\"]', NULL, 489, 0, 'published', '2025-11-09 01:32:48', '2025-11-09 01:32:48', '2025-11-17 01:32:48');

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
  `verification_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cohorts`
--

CREATE TABLE `cohorts` (
  `id` int(10) UNSIGNED NOT NULL,
  `uuid` char(36) DEFAULT uuid(),
  `code` varchar(50) DEFAULT NULL,
  `program_id` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `program` varchar(100) NOT NULL,
  `facilitator_id` int(10) UNSIGNED DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `enrollment_deadline` date DEFAULT NULL,
  `max_students` int(10) UNSIGNED DEFAULT 30,
  `current_students` int(10) UNSIGNED DEFAULT 0,
  `lead_facilitator` int(10) UNSIGNED DEFAULT NULL,
  `assistant_facilitators` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`assistant_facilitators`)),
  `status` enum('upcoming','active','completed','cancelled') DEFAULT 'upcoming',
  `description` text DEFAULT NULL,
  `schedule` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cohorts`
--

INSERT INTO `cohorts` (`id`, `uuid`, `code`, `program_id`, `name`, `program`, `facilitator_id`, `start_date`, `end_date`, `enrollment_deadline`, `max_students`, `current_students`, `lead_facilitator`, `assistant_facilitators`, `status`, `description`, `schedule`, `created_at`, `updated_at`) VALUES
(1, '0c3bb484-bc57-11f0-acd9-f48e38a80c71', 'FE-JAN-2025', 1, 'Frontend Development - January 2025', '', NULL, '2025-01-15', '2025-04-15', '2025-01-10', 30, 0, 1, NULL, 'upcoming', 'Complete frontend development bootcamp covering HTML, CSS, JavaScript, and modern frameworks.', 'Monday-Wednesday-Friday, 6:00 PM - 8:00 PM (WAT)', '2025-11-08 03:56:32', '2025-11-08 03:56:32'),
(2, '0c42bef8-bc57-11f0-acd9-f48e38a80c71', 'FE-MAR-2025', 1, 'Frontend Development - March 2025', '', NULL, '2025-03-01', '2025-06-01', '2025-02-25', 30, 0, 1, NULL, 'upcoming', 'Complete frontend development bootcamp covering HTML, CSS, JavaScript, and modern frameworks.', 'Tuesday-Thursday, 7:00 PM - 9:00 PM (WAT)', '2025-11-08 03:56:32', '2025-11-08 03:56:32');

-- --------------------------------------------------------

--
-- Table structure for table `cohort_assignments`
--

CREATE TABLE `cohort_assignments` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `cohort_id` int(10) UNSIGNED NOT NULL,
  `assigned_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('active','completed','dropped','transferred') DEFAULT 'active',
  `completion_percentage` decimal(5,2) DEFAULT 0.00,
  `last_activity_at` timestamp NULL DEFAULT NULL,
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
  `category` varchar(100) DEFAULT NULL,
  `level` enum('beginner','intermediate','advanced') DEFAULT 'beginner',
  `duration_hours` int(10) UNSIGNED DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `facilitator_id` int(10) UNSIGNED DEFAULT NULL,
  `status` enum('draft','published','archived') DEFAULT 'draft',
  `ai_generated` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `uuid`, `title`, `slug`, `description`, `category`, `level`, `duration_hours`, `thumbnail`, `facilitator_id`, `status`, `ai_generated`, `created_at`, `updated_at`) VALUES
(1, '', 'Frontend Development Fundamentals', 'frontend-development-fundamentals-1', 'Master the essentials of modern frontend web development. Learn HTML5, CSS3, JavaScript, and React to build beautiful, responsive, and interactive websites. This comprehensive course takes you from zero to job-ready with hands-on projects and real-world examples.', 'frontend', 'beginner', 60, 'uploads/thumbnails/frontend-dev-course.jpg', 1, 'published', 0, '2025-11-07 21:34:06', '2025-11-08 05:26:59'),
(3, 'f91809bb-80fe-4e2c-b87f-57c770e26c4a', 'Backend Development with PHP & MySQL', 'backend-php-mysql', 'Master server-side development with PHP and MySQL. Build robust APIs, manage databases, and create scalable web applications.', 'Backend Development', 'intermediate', 100, NULL, 1, 'published', 0, '2025-11-08 05:31:55', '2025-11-08 05:31:55'),
(4, 'e10b7ada-4cfe-4f65-80b8-e8a418777234', 'Node.js & Express Backend Development', 'nodejs-express-backend', 'Build fast, scalable backend applications with Node.js and Express. Learn async programming, database integration, and API development.', 'Backend Development', 'intermediate', 80, NULL, 1, 'published', 0, '2025-11-08 05:31:55', '2025-11-08 05:31:55'),
(5, '302f01c6-b061-4798-b033-9e4860e6086a', 'Full Stack Web Development Bootcamp', 'fullstack-bootcamp', 'Become a full stack developer! Learn frontend (React) and backend (Node.js) development to build complete web applications from scratch.', 'Full Stack Development', 'intermediate', 160, NULL, 1, 'published', 0, '2025-11-08 05:31:55', '2025-11-08 05:31:55'),
(6, '470c24fb-9f2e-45d7-8ae4-072939874213', 'MERN Stack Development', 'mern-stack', 'Master the MERN stack (MongoDB, Express, React, Node.js) to build modern, scalable web applications with JavaScript.', 'Full Stack Development', 'advanced', 140, NULL, 1, 'published', 0, '2025-11-08 05:31:55', '2025-11-08 05:31:55'),
(7, '0e8f29f8-249a-4920-b70c-38f0b6c7d7eb', 'React Native Mobile Development', 'react-native-mobile', 'Build native mobile apps for iOS and Android using React Native. Learn to create beautiful, performant cross-platform applications.', 'Mobile Development', 'intermediate', 100, NULL, 1, 'published', 0, '2025-11-08 05:31:55', '2025-11-08 05:31:55'),
(8, '509cfc9c-2ccf-4386-9f97-c183e4860035', 'Flutter Mobile App Development', 'flutter-mobile-apps', 'Create beautiful, natively compiled applications for mobile, web, and desktop from a single codebase using Flutter and Dart.', 'Mobile Development', 'beginner', 120, NULL, 1, 'published', 0, '2025-11-08 05:31:56', '2025-11-08 05:31:56'),
(9, '3ad78b0c-b080-4ddb-832c-7747629a0083', 'Introduction to Machine Learning with Python', 'machine-learning-python', 'Start your AI journey! Learn machine learning fundamentals with Python, scikit-learn, and build your first ML models.', 'AI & Machine Learning', 'beginner', 100, NULL, 1, 'published', 0, '2025-11-08 05:31:56', '2025-11-08 05:31:56'),
(10, 'd29f93cc-1e4c-45d5-8363-295abb573ef7', 'Deep Learning & Neural Networks', 'deep-learning-neural-networks', 'Master deep learning with TensorFlow and Keras. Build neural networks for image recognition, NLP, and more.', 'AI & Machine Learning', 'advanced', 140, NULL, 1, 'published', 0, '2025-11-08 05:31:56', '2025-11-08 05:31:56'),
(11, 'e8c19696-d80d-4e55-a744-4fce6b4b60ce', 'Data Science Fundamentals', 'data-science-fundamentals', 'Learn data analysis, visualization, and statistical modeling. Master Python data science tools to extract insights from data.', 'Data Science', 'beginner', 120, NULL, 1, 'published', 0, '2025-11-08 05:31:56', '2025-11-08 05:31:56'),
(12, 'd3cedf17-2443-4c11-a8d8-24d01a12f911', 'Big Data Analytics with Apache Spark', 'big-data-spark', 'Process and analyze massive datasets with Apache Spark. Learn distributed computing for big data applications.', 'Data Science', 'advanced', 100, NULL, 1, 'published', 0, '2025-11-08 05:31:56', '2025-11-08 05:31:56'),
(13, '6d6239b9-6bc6-43c9-8233-b1738d633fe7', 'Ethical Hacking & Penetration Testing', 'ethical-hacking-pentest', 'Learn ethical hacking techniques to secure systems. Master penetration testing, vulnerability assessment, and security tools.', 'Cybersecurity', 'intermediate', 120, NULL, 1, 'published', 0, '2025-11-08 05:31:56', '2025-11-08 05:31:56'),
(14, '0aea8d1f-d085-48fd-90a2-caa9a30df2cd', 'Web Application Security', 'web-app-security', 'Secure your web applications! Learn about OWASP Top 10, secure coding practices, and how to protect against common attacks.', 'Cybersecurity', 'intermediate', 80, NULL, 1, 'published', 0, '2025-11-08 05:31:56', '2025-11-08 05:31:56'),
(15, '8c316aac-bd38-4c14-907a-2d102f95b1cc', 'AWS Cloud Practitioner Essentials', 'aws-cloud-practitioner', 'Master Amazon Web Services fundamentals. Learn cloud computing concepts and prepare for AWS certification.', 'Cloud Computing', 'beginner', 80, NULL, 1, 'published', 0, '2025-11-08 05:31:56', '2025-11-08 05:31:56'),
(16, '5136f5d1-b1f8-4b96-b4ff-e088f584dce0', 'Docker & Kubernetes DevOps', 'docker-kubernetes-devops', 'Master containerization and orchestration with Docker and Kubernetes. Build scalable, cloud-native applications.', 'Cloud Computing', 'intermediate', 100, NULL, 1, 'published', 0, '2025-11-08 05:31:56', '2025-11-08 05:31:56'),
(17, '62670e42-4b3c-4ed2-a1e6-6dfa760a2177', 'Vue.js Modern Frontend Development', 'vuejs-frontend', 'Build interactive user interfaces with Vue.js. Learn the progressive JavaScript framework that\'s easy to learn and powerful.', 'Frontend Development', 'intermediate', 80, NULL, 1, 'published', 0, '2025-11-08 05:31:56', '2025-11-08 05:31:56'),
(18, '99dc0739-b06e-4631-baed-5acefff7e94e', 'Angular Enterprise Applications', 'angular-enterprise', 'Build large-scale enterprise applications with Angular. Master TypeScript, RxJS, and Angular best practices.', 'Frontend Development', 'advanced', 120, NULL, 1, 'published', 0, '2025-11-08 05:31:56', '2025-11-08 05:31:56');

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
(13, 'General', 'general', 'General discussions about technology, learning, and community', '💌', 'blue', NULL, NULL, 1, 1, '2025-11-16 09:49:18', '2025-11-16 09:52:21'),
(14, 'Q&A', 'qa', 'Ask questions and get help from the community', '???', 'purple', NULL, NULL, 2, 1, '2025-11-16 09:49:18', '2025-11-16 09:52:11'),
(15, 'Career & Jobs', 'career-jobs', 'Career advice, job opportunities, and professional growth', '????', 'green', NULL, NULL, 3, 1, '2025-11-16 09:49:18', '2025-11-16 09:52:11'),
(16, 'Projects Showcase', 'projects-showcase', 'Share your projects and get feedback', '????', 'orange', NULL, NULL, 4, 1, '2025-11-16 09:49:18', '2025-11-16 09:52:11'),
(17, 'Resources', 'resources', 'Share useful learning resources, tools, and tutorials', '????', 'indigo', NULL, NULL, 5, 1, '2025-11-16 09:49:18', '2025-11-16 09:52:11'),
(18, 'Announcements', 'announcements', 'Official announcements and updates', '????', 'red', NULL, NULL, 6, 1, '2025-11-16 09:49:18', '2025-11-16 09:52:12');

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

--
-- Dumping data for table `discussion_posts`
--

INSERT INTO `discussion_posts` (`id`, `uuid`, `category_id`, `user_id`, `course_id`, `title`, `content`, `type`, `tags`, `is_pinned`, `is_locked`, `is_solved`, `views_count`, `likes_count`, `comments_count`, `created_at`, `updated_at`, `last_activity_at`) VALUES
(1, '1bd94e1e-4e79-4c3f-a211-eb18fc0151f8', 14, 1, NULL, 'What programming languagu is awesome for mobile apps development? ', 'I want to  dive into mobile app developments and I am not sure which language to learn.', 'question', '[\"Developers\",\"Coders\"]', 0, 0, 0, 0, 0, 0, '2025-11-16 14:18:56', '2025-11-16 13:18:56', '2025-11-16 14:18:56'),
(2, 'fce7d6a5-31a2-4a14-b97f-de75c00568fe', 14, 1, NULL, 'What programming languagu is awesome for mobile apps development? ', 'I want to  dive into mobile app developments and I am not sure which language to learn.', 'question', '[\"Developers\",\"Coders\"]', 0, 0, 0, 0, 0, 0, '2025-11-16 14:19:42', '2025-11-16 13:19:42', '2025-11-16 14:19:42');

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
-- Table structure for table `enrollments`
--

CREATE TABLE `enrollments` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `course_id` int(10) UNSIGNED NOT NULL,
  `status` enum('active','completed','dropped') DEFAULT 'active',
  `progress` decimal(5,2) DEFAULT 0.00,
  `enrolled_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `completed_at` timestamp NULL DEFAULT NULL
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
(1, 'f65c5864-d2a7-4436-85ab-f8612254034c', 11, 'Introduction to HTML', 'text', 'Content for Introduction to HTML lesson will be here...', 0, 30, NULL, 0, '2025-11-07 21:45:14', '2025-11-07 21:45:14'),
(2, '27db7d47-cec7-4954-892b-f0691765fdab', 11, 'HTML Document Structure', 'text', 'Content for HTML Document Structure lesson will be here...', 1, 45, NULL, 0, '2025-11-07 21:45:14', '2025-11-07 21:45:14'),
(3, '3b9c24dc-8624-491d-b0b9-f4c362f6a20b', 11, 'Forms and Input', 'text', 'Content for Forms and Input lesson will be here...', 2, 40, NULL, 0, '2025-11-07 21:45:14', '2025-11-07 21:45:14'),
(4, '9a682537-6306-4d3d-a619-4510f8a57090', 11, 'Practice: Contact Form', 'code', 'Content for Practice: Contact Form lesson will be here...', 3, 60, NULL, 0, '2025-11-07 21:45:15', '2025-11-07 21:45:15'),
(5, '5e02e113-9c6f-46e4-b93b-daae8364fa15', 12, 'CSS Basics', 'text', 'Content for CSS Basics lesson will be here...', 0, 45, NULL, 0, '2025-11-07 21:45:15', '2025-11-07 21:45:15'),
(6, '895c7b61-9134-47c7-8faa-e28d2fe9afad', 12, 'Flexbox Layout', 'text', 'Content for Flexbox Layout lesson will be here...', 1, 50, NULL, 0, '2025-11-07 21:45:15', '2025-11-07 21:45:15'),
(7, '0e6c238b-f4dd-4675-9141-2931f1d83186', 12, 'CSS Grid', 'text', 'Content for CSS Grid lesson will be here...', 2, 50, NULL, 0, '2025-11-07 21:45:15', '2025-11-07 21:45:15'),
(8, '96a0b3dd-f4e6-4116-81f2-d4ab30d8b108', 12, 'Responsive Design', 'text', 'Content for Responsive Design lesson will be here...', 3, 45, NULL, 0, '2025-11-07 21:45:15', '2025-11-07 21:45:15'),
(9, '12dce565-ae77-4aa9-bc39-77915db69127', 12, 'Project: Portfolio Page', 'project', 'Content for Project: Portfolio Page lesson will be here...', 4, 180, NULL, 0, '2025-11-07 21:45:15', '2025-11-07 21:45:15'),
(10, '015b93f0-19c1-4bac-a5f6-ba43eac2e8bb', 13, 'JS Variables & Types', 'text', 'Content for JS Variables & Types lesson will be here...', 0, 40, NULL, 0, '2025-11-07 21:45:15', '2025-11-07 21:45:15'),
(11, '30a9f053-0742-4895-bed9-55c5e7f742f6', 13, 'Functions & Control Flow', 'text', 'Content for Functions & Control Flow lesson will be here...', 1, 45, NULL, 0, '2025-11-07 21:45:15', '2025-11-07 21:45:15'),
(12, '3e5f35c1-c7af-4e51-8fb9-331c27e374d8', 13, 'DOM Manipulation', 'text', 'Content for DOM Manipulation lesson will be here...', 2, 50, NULL, 0, '2025-11-07 21:45:15', '2025-11-07 21:45:15'),
(13, 'b7339387-3b1d-41dc-a609-78f10e1bc980', 13, 'Project: Calculator', 'code', 'Content for Project: Calculator lesson will be here...', 3, 120, NULL, 0, '2025-11-07 21:45:15', '2025-11-07 21:45:15'),
(14, 'e1806b49-fe27-479a-9f92-6a4a40dc5332', 14, 'Lesson 1', 'text', 'Content will be generated...', 0, 45, NULL, 0, '2025-11-07 21:45:15', '2025-11-07 21:45:15'),
(15, '4fb5773a-8bdd-4591-8d2c-809e2941824c', 14, 'Lesson 2', 'text', 'Content will be generated...', 1, 45, NULL, 0, '2025-11-07 21:45:15', '2025-11-07 21:45:15'),
(16, '5717ca8c-aa4a-4425-837b-1609995244ee', 14, 'Lesson 3', 'text', 'Content will be generated...', 2, 45, NULL, 0, '2025-11-07 21:45:15', '2025-11-07 21:45:15'),
(17, '6117edd9-145a-41f0-8f1d-f76fcc414923', 14, 'Lesson 4', 'text', 'Content will be generated...', 3, 45, NULL, 0, '2025-11-07 21:45:16', '2025-11-07 21:45:16'),
(18, '7ebaa930-4ff3-4a80-bb72-7fed5fa3e67f', 14, 'Lesson 5', 'project', 'Content will be generated...', 4, 45, NULL, 0, '2025-11-07 21:45:16', '2025-11-07 21:45:16'),
(19, 'acf61903-483f-44fa-9987-2ef30171acbd', 15, 'Lesson 1', 'text', 'Content will be generated...', 0, 45, NULL, 0, '2025-11-07 21:45:16', '2025-11-07 21:45:16'),
(20, '4347b900-89ca-4deb-bb21-f24e69e2160f', 15, 'Lesson 2', 'text', 'Content will be generated...', 1, 45, NULL, 0, '2025-11-07 21:45:16', '2025-11-07 21:45:16'),
(21, '405fcf40-3abf-465d-8e88-e91e0eb67d50', 15, 'Lesson 3', 'text', 'Content will be generated...', 2, 45, NULL, 0, '2025-11-07 21:45:16', '2025-11-07 21:45:16'),
(22, 'a5013bbd-2687-4660-a6d3-37b500d78407', 15, 'Lesson 4', 'text', 'Content will be generated...', 3, 45, NULL, 0, '2025-11-07 21:45:16', '2025-11-07 21:45:16'),
(23, '1ab86d89-c382-4a86-b2e1-cad3ca843f1e', 15, 'Lesson 5', 'project', 'Content will be generated...', 4, 45, NULL, 0, '2025-11-07 21:45:16', '2025-11-07 21:45:16'),
(24, '82c4ba53-59d5-4bdc-b84e-af2a38e8d638', 16, 'Lesson 1', 'text', 'Content will be generated...', 0, 45, NULL, 0, '2025-11-07 21:45:16', '2025-11-07 21:45:16'),
(25, '7c3efb00-54db-4643-b728-f0496a8cc630', 16, 'Lesson 2', 'text', 'Content will be generated...', 1, 45, NULL, 0, '2025-11-07 21:45:16', '2025-11-07 21:45:16'),
(26, '6246f1b4-5848-4cd3-946e-1cda1a0ecbf7', 16, 'Lesson 3', 'text', 'Content will be generated...', 2, 45, NULL, 0, '2025-11-07 21:45:16', '2025-11-07 21:45:16'),
(27, '3c91e68d-246c-49fb-8aec-3cc025cd95bd', 16, 'Lesson 4', 'text', 'Content will be generated...', 3, 45, NULL, 0, '2025-11-07 21:45:16', '2025-11-07 21:45:16'),
(28, '51a77131-ecb2-4a02-b9ed-80972efa6bee', 16, 'Lesson 5', 'project', 'Content will be generated...', 4, 45, NULL, 0, '2025-11-07 21:45:16', '2025-11-07 21:45:16'),
(29, 'f6975e84-4870-433c-bda4-4bdb9d610a0f', 17, 'Lesson 1', 'text', 'Content will be generated...', 0, 45, NULL, 0, '2025-11-07 21:45:16', '2025-11-07 21:45:16'),
(30, 'e1f1e03b-5ce1-44b4-9e62-caeccda5151a', 17, 'Lesson 2', 'text', 'Content will be generated...', 1, 45, NULL, 0, '2025-11-07 21:45:16', '2025-11-07 21:45:16'),
(31, '2dc82e9f-9f6d-4cb0-b25c-6c0c42dfd9e3', 17, 'Lesson 3', 'text', 'Content will be generated...', 2, 45, NULL, 0, '2025-11-07 21:45:16', '2025-11-07 21:45:16'),
(32, 'c4b85ed7-ed5a-4eb7-b427-57514842339b', 17, 'Lesson 4', 'text', 'Content will be generated...', 3, 45, NULL, 0, '2025-11-07 21:45:16', '2025-11-07 21:45:16'),
(33, '9590b47f-20c7-4843-81c6-ce9376f924d3', 17, 'Lesson 5', 'project', 'Content will be generated...', 4, 45, NULL, 0, '2025-11-07 21:45:16', '2025-11-07 21:45:16'),
(34, '59b7b4f4-c2d1-4492-b56a-771d5bf26315', 18, 'Lesson 1', 'text', 'Content will be generated...', 0, 45, NULL, 0, '2025-11-07 21:45:16', '2025-11-07 21:45:16'),
(35, '19d50687-ae8d-4c0e-85d2-d41a3782f516', 18, 'Lesson 2', 'text', 'Content will be generated...', 1, 45, NULL, 0, '2025-11-07 21:45:16', '2025-11-07 21:45:16'),
(36, 'e5903d55-8a35-4760-a914-0e75efab2c04', 18, 'Lesson 3', 'project', 'Content will be generated...', 2, 45, NULL, 0, '2025-11-07 21:45:16', '2025-11-07 21:45:16');

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
(1, '', 1, 'HTML5 Fundamentals', 'Learn the building blocks of web development with HTML5. Master semantic markup, forms, and modern HTML features.', 0, NULL, '[\"Understand HTML document structure\", \"Create semantic HTML markup\", \"Build accessible web forms\", \"Use HTML5 multimedia elements\", \"Apply SEO best practices\"]', 'published', '2025-11-07 21:34:06', '2025-11-07 21:34:06'),
(3, '9ec681d2-fee7-4ee9-97c4-7126f03a4df1', 1, 'HTML5 Fundamentals', 'Learn HTML5 building blocks', 0, NULL, NULL, 'published', '2025-11-07 21:37:10', '2025-11-07 21:37:10'),
(4, 'c22e3fe9-920a-44d6-b41b-1886398f3c33', 1, 'CSS3 & Responsive Design', 'Style with CSS3 and responsive techniques', 1, NULL, NULL, 'published', '2025-11-07 21:37:10', '2025-11-07 21:37:10'),
(5, '6ee1688d-41ec-49d5-92d3-005e263d9117', 1, 'JavaScript Basics', 'Programming fundamentals', 2, NULL, NULL, 'published', '2025-11-07 21:37:10', '2025-11-07 21:37:10'),
(6, 'ffbac8c7-d8b3-448a-ac77-64d85472f7a7', 1, 'Advanced JavaScript', 'ES6+ and async programming', 3, NULL, NULL, 'published', '2025-11-07 21:37:10', '2025-11-07 21:37:10'),
(7, 'e231cfd4-5d44-4bf8-b2a9-29718df85978', 1, 'React Fundamentals', 'Build UIs with React', 4, NULL, NULL, 'published', '2025-11-07 21:37:11', '2025-11-07 21:37:11'),
(8, 'eb1a6b75-7cab-4ecb-90c3-64da71c95f62', 1, 'React Advanced', 'Advanced React patterns', 5, NULL, NULL, 'published', '2025-11-07 21:37:11', '2025-11-07 21:37:11'),
(9, 'f1610388-df1c-4469-89c8-1bce9663e392', 1, 'Git & GitHub', 'Version control mastery', 6, NULL, NULL, 'published', '2025-11-07 21:37:11', '2025-11-07 21:37:11'),
(10, '7504c7fe-c7bd-47c1-8297-480a25369c08', 1, 'Capstone Project', 'Build your portfolio project', 7, NULL, NULL, 'published', '2025-11-07 21:37:12', '2025-11-07 21:37:12'),
(11, '393d1bbe-261f-41ab-b9be-fee3399dd3a1', 1, 'HTML5 Fundamentals', 'Learn HTML5 building blocks', 0, NULL, NULL, 'published', '2025-11-07 21:45:13', '2025-11-07 21:45:13'),
(12, '73b513a1-4451-47b7-a31a-623bac837d9f', 1, 'CSS3 & Responsive Design', 'Style with CSS3 and responsive techniques', 1, NULL, NULL, 'published', '2025-11-07 21:45:13', '2025-11-07 21:45:13'),
(13, 'e1e50dff-d882-438a-ace3-c4b83c68fd07', 1, 'JavaScript Basics', 'Programming fundamentals', 2, NULL, NULL, 'published', '2025-11-07 21:45:13', '2025-11-07 21:45:13'),
(14, 'f94fa548-8d32-48ed-9998-2795df54b876', 1, 'Advanced JavaScript', 'ES6+ and async programming', 3, NULL, NULL, 'published', '2025-11-07 21:45:13', '2025-11-07 21:45:13'),
(15, '8146dceb-e6a5-4593-9f5c-1f7a85b84e57', 1, 'React Fundamentals', 'Build UIs with React', 4, NULL, NULL, 'published', '2025-11-07 21:45:14', '2025-11-07 21:45:14'),
(16, '2c6f2ec6-9eba-4eab-baa4-72d91bbc4e5a', 1, 'React Advanced', 'Advanced React patterns', 5, NULL, NULL, 'published', '2025-11-07 21:45:14', '2025-11-07 21:45:14'),
(17, '6b48589b-52e2-43a9-9e47-e828cd1a3028', 1, 'Git & GitHub', 'Version control mastery', 6, NULL, NULL, 'published', '2025-11-07 21:45:14', '2025-11-07 21:45:14'),
(18, 'd1f2d2ba-cadf-48d9-9a1c-703ce10ddaf5', 1, 'Capstone Project', 'Build your portfolio project', 7, NULL, NULL, 'published', '2025-11-07 21:45:14', '2025-11-07 21:45:14');

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

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `type` varchar(50) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text DEFAULT NULL,
  `link` varchar(500) DEFAULT NULL,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`data`)),
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `read_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `featured` tinyint(1) DEFAULT 0,
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

--
-- Dumping data for table `portfolio_settings`
--

INSERT INTO `portfolio_settings` (`id`, `user_id`, `bio`, `tagline`, `github_url`, `linkedin_url`, `twitter_url`, `website_url`, `is_public`, `show_badges`, `show_certificates`, `show_contact`, `theme`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 'default', '2025-11-08 01:16:15', '2025-11-08 01:16:15');

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
  `file_path` varchar(255) DEFAULT NULL,
  `ai_score` decimal(5,2) DEFAULT NULL,
  `ai_feedback` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`ai_feedback`)),
  `facilitator_score` decimal(5,2) DEFAULT NULL,
  `facilitator_feedback` text DEFAULT NULL,
  `status` enum('pending','graded','revision_needed','verified') DEFAULT 'pending',
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `graded_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `avatar` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive','suspended') DEFAULT 'active',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `uuid`, `email`, `password`, `first_name`, `last_name`, `role`, `avatar`, `status`, `email_verified_at`, `created_at`, `updated_at`) VALUES
(1, '', 'facilitator@nebatech.com', '$2y$12$WZLu1r07QMdp3YXz3wyrYukxo4MAJJ/YYFE/SWiug0x45gH0QAylK', 'Sarah', 'Johnson', 'facilitator', NULL, 'active', NULL, '2025-11-07 21:34:06', '2025-11-08 04:39:09'),
(2, 'd928d2fa-04b7-4f87-9cae-a18ac276b5d0', 'abdulhafiz@nebatech.com', '$2y$12$UuCE92xC42pU8Yjt7jC7YOuCfy5xRY3bDhzhOPWdipNL5SqtOKmOK', 'Abdul-Hafiz', 'Yussif', 'student', NULL, 'active', NULL, '2025-11-08 05:33:34', '2025-11-08 05:33:34'),
(3, 'a705d4ae-0dd3-4c1e-83c6-ea8fda685eac', 'admin@nebatech.com', '$2y$12$JG9DY51BfpWqz3EMk/S3y.HwsEYv/xT4WGLGFHFhRp1C027VCocwy', 'Admin', 'User', 'admin', NULL, 'active', '2025-11-08 06:39:50', '2025-11-08 05:39:50', '2025-11-08 05:39:50');

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

--
-- Dumping data for table `user_profiles`
--

INSERT INTO `user_profiles` (`id`, `user_id`, `bio`, `location`, `website`, `github_url`, `linkedin_url`, `twitter_handle`, `skills`, `interests`, `total_xp`, `current_streak`, `longest_streak`, `last_active_date`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, '2025-11-16', '2025-11-16 13:18:56', '2025-11-16 13:18:56');

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
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_action` (`action`),
  ADD KEY `idx_resource` (`resource_type`,`resource_id`),
  ADD KEY `idx_created_at` (`created_at`);

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uuid` (`uuid`),
  ADD KEY `reviewed_by` (`reviewed_by`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_program` (`program`);

--
-- Indexes for table `application_notes`
--
ALTER TABLE `application_notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`),
  ADD KEY `idx_application_id` (`application_id`);

--
-- Indexes for table `application_timeline`
--
ALTER TABLE `application_timeline`
  ADD PRIMARY KEY (`id`),
  ADD KEY `actor_id` (`actor_id`),
  ADD KEY `idx_application_id` (`application_id`),
  ADD KEY `idx_event_type` (`event_type`),
  ADD KEY `idx_created_at` (`created_at`);

--
-- Indexes for table `assignments`
--
ALTER TABLE `assignments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uuid` (`uuid`),
  ADD KEY `idx_lesson_id` (`lesson_id`);

--
-- Indexes for table `badges`
--
ALTER TABLE `badges`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `idx_category` (`category`),
  ADD KEY `idx_slug` (`slug`);

--
-- Indexes for table `blog_categories`
--
ALTER TABLE `blog_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `idx_slug` (`slug`),
  ADD KEY `idx_status` (`status`);

--
-- Indexes for table `blog_comments`
--
ALTER TABLE `blog_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_post_id` (`post_id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_parent_id` (`parent_id`),
  ADD KEY `idx_status` (`status`);

--
-- Indexes for table `blog_likes`
--
ALTER TABLE `blog_likes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_like` (`post_id`,`user_id`),
  ADD KEY `idx_post_id` (`post_id`),
  ADD KEY `idx_user_id` (`user_id`);

--
-- Indexes for table `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uuid` (`uuid`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `idx_slug` (`slug`),
  ADD KEY `idx_author_id` (`author_id`),
  ADD KEY `idx_category_id` (`category_id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_published_at` (`published_at`);
ALTER TABLE `blog_posts` ADD FULLTEXT KEY `idx_search` (`title`,`excerpt`,`content`);

--
-- Indexes for table `certificates`
--
ALTER TABLE `certificates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uuid` (`uuid`),
  ADD UNIQUE KEY `certificate_number` (`certificate_number`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_course_id` (`course_id`),
  ADD KEY `idx_certificate_number` (`certificate_number`);

--
-- Indexes for table `cohorts`
--
ALTER TABLE `cohorts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD KEY `facilitator_id` (`facilitator_id`),
  ADD KEY `idx_program` (`program`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_program_id` (`program_id`),
  ADD KEY `idx_code` (`code`);

--
-- Indexes for table `cohort_assignments`
--
ALTER TABLE `cohort_assignments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_assignment` (`user_id`,`cohort_id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_cohort_id` (`cohort_id`);

--
-- Indexes for table `community_events`
--
ALTER TABLE `community_events`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uuid` (`uuid`),
  ADD KEY `idx_organizer_id` (`organizer_id`),
  ADD KEY `idx_start_time` (`start_time`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_type` (`type`);

--
-- Indexes for table `community_resources`
--
ALTER TABLE `community_resources`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uuid` (`uuid`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_type` (`type`),
  ADD KEY `idx_created_at` (`created_at`);
ALTER TABLE `community_resources` ADD FULLTEXT KEY `idx_search` (`title`,`description`);

--
-- Indexes for table `contact_submissions`
--
ALTER TABLE `contact_submissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assigned_to` (`assigned_to`),
  ADD KEY `idx_email` (`email`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_created_at` (`created_at`);

--
-- Indexes for table `content_reports`
--
ALTER TABLE `content_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `moderator_id` (`moderator_id`),
  ADD KEY `idx_reporter_id` (`reporter_id`),
  ADD KEY `idx_reportable` (`reportable_type`,`reportable_id`),
  ADD KEY `idx_status` (`status`);

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
  ADD KEY `idx_category` (`category`);

--
-- Indexes for table `discussion_bookmarks`
--
ALTER TABLE `discussion_bookmarks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_bookmark` (`user_id`,`post_id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `idx_user_id` (`user_id`);

--
-- Indexes for table `discussion_categories`
--
ALTER TABLE `discussion_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `idx_slug` (`slug`),
  ADD KEY `idx_course_id` (`course_id`),
  ADD KEY `idx_parent_id` (`parent_id`);

--
-- Indexes for table `discussion_comments`
--
ALTER TABLE `discussion_comments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uuid` (`uuid`),
  ADD KEY `idx_post_id` (`post_id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_parent_id` (`parent_id`),
  ADD KEY `idx_created_at` (`created_at`);

--
-- Indexes for table `discussion_likes`
--
ALTER TABLE `discussion_likes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_like` (`user_id`,`likeable_type`,`likeable_id`),
  ADD KEY `idx_likeable` (`likeable_type`,`likeable_id`);

--
-- Indexes for table `discussion_posts`
--
ALTER TABLE `discussion_posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uuid` (`uuid`),
  ADD KEY `idx_category_id` (`category_id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_course_id` (`course_id`),
  ADD KEY `idx_type` (`type`),
  ADD KEY `idx_is_pinned` (`is_pinned`),
  ADD KEY `idx_created_at` (`created_at`),
  ADD KEY `idx_last_activity` (`last_activity_at`);
ALTER TABLE `discussion_posts` ADD FULLTEXT KEY `idx_search` (`title`,`content`);

--
-- Indexes for table `draft_posts`
--
ALTER TABLE `draft_posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_type` (`type`);

--
-- Indexes for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_enrollment` (`user_id`,`course_id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_course_id` (`course_id`),
  ADD KEY `idx_status` (`status`);

--
-- Indexes for table `event_rsvps`
--
ALTER TABLE `event_rsvps`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_rsvp` (`event_id`,`user_id`),
  ADD KEY `idx_event_id` (`event_id`),
  ADD KEY `idx_user_id` (`user_id`);

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
  ADD UNIQUE KEY `token` (`token`),
  ADD KEY `idx_email` (`email`),
  ADD KEY `idx_status` (`status`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_id` (`user_id`),
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
  ADD KEY `submission_id` (`submission_id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_featured` (`is_featured`),
  ADD KEY `idx_public` (`is_public`),
  ADD KEY `idx_display_order` (`display_order`);

--
-- Indexes for table `portfolio_settings`
--
ALTER TABLE `portfolio_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user` (`user_id`);

--
-- Indexes for table `submissions`
--
ALTER TABLE `submissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uuid` (`uuid`),
  ADD KEY `idx_assignment_id` (`assignment_id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_status` (`status`);

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
  ADD UNIQUE KEY `unique_user_badge` (`user_id`,`badge_id`),
  ADD KEY `badge_id` (`badge_id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_earned_at` (`earned_at`);

--
-- Indexes for table `user_follows`
--
ALTER TABLE `user_follows`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_follow` (`follower_id`,`following_id`),
  ADD KEY `idx_follower_id` (`follower_id`),
  ADD KEY `idx_following_id` (`following_id`);

--
-- Indexes for table `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD KEY `idx_total_xp` (`total_xp`),
  ADD KEY `idx_last_active` (`last_active_date`);

--
-- Indexes for table `xp_transactions`
--
ALTER TABLE `xp_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_action` (`action`),
  ADD KEY `idx_created_at` (`created_at`);

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `blog_likes`
--
ALTER TABLE `blog_likes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blog_posts`
--
ALTER TABLE `blog_posts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `certificates`
--
ALTER TABLE `certificates`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cohorts`
--
ALTER TABLE `cohorts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cohort_assignments`
--
ALTER TABLE `cohort_assignments`
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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `discussion_bookmarks`
--
ALTER TABLE `discussion_bookmarks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `discussion_categories`
--
ALTER TABLE `discussion_categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `draft_posts`
--
ALTER TABLE `draft_posts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `event_rsvps`
--
ALTER TABLE `event_rsvps`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lessons`
--
ALTER TABLE `lessons`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `newsletter_subscriptions`
--
ALTER TABLE `newsletter_subscriptions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `portfolios`
--
ALTER TABLE `portfolios`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `portfolio_settings`
--
ALTER TABLE `portfolio_settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `submissions`
--
ALTER TABLE `submissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
-- AUTO_INCREMENT for table `user_profiles`
--
ALTER TABLE `user_profiles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
-- Constraints for table `admin_action_logs`
--
ALTER TABLE `admin_action_logs`
  ADD CONSTRAINT `admin_action_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `applications`
--
ALTER TABLE `applications`
  ADD CONSTRAINT `applications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `applications_ibfk_2` FOREIGN KEY (`reviewed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `application_notes`
--
ALTER TABLE `application_notes`
  ADD CONSTRAINT `application_notes_ibfk_1` FOREIGN KEY (`application_id`) REFERENCES `applications` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `application_notes_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `application_notes_ibfk_3` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `application_timeline`
--
ALTER TABLE `application_timeline`
  ADD CONSTRAINT `application_timeline_ibfk_1` FOREIGN KEY (`application_id`) REFERENCES `applications` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `application_timeline_ibfk_2` FOREIGN KEY (`actor_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `assignments`
--
ALTER TABLE `assignments`
  ADD CONSTRAINT `assignments_ibfk_1` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `blog_comments`
--
ALTER TABLE `blog_comments`
  ADD CONSTRAINT `blog_comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `blog_posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `blog_comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `blog_comments_ibfk_3` FOREIGN KEY (`parent_id`) REFERENCES `blog_comments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `blog_likes`
--
ALTER TABLE `blog_likes`
  ADD CONSTRAINT `blog_likes_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `blog_posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `blog_likes_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD CONSTRAINT `blog_posts_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `blog_posts_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `blog_categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `certificates`
--
ALTER TABLE `certificates`
  ADD CONSTRAINT `certificates_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `certificates_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cohorts`
--
ALTER TABLE `cohorts`
  ADD CONSTRAINT `cohorts_ibfk_1` FOREIGN KEY (`facilitator_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `cohort_assignments`
--
ALTER TABLE `cohort_assignments`
  ADD CONSTRAINT `cohort_assignments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cohort_assignments_ibfk_2` FOREIGN KEY (`cohort_id`) REFERENCES `cohorts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `community_events`
--
ALTER TABLE `community_events`
  ADD CONSTRAINT `community_events_ibfk_1` FOREIGN KEY (`organizer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `community_resources`
--
ALTER TABLE `community_resources`
  ADD CONSTRAINT `community_resources_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `community_resources_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `discussion_categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `contact_submissions`
--
ALTER TABLE `contact_submissions`
  ADD CONSTRAINT `contact_submissions_ibfk_1` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `content_reports`
--
ALTER TABLE `content_reports`
  ADD CONSTRAINT `content_reports_ibfk_1` FOREIGN KEY (`reporter_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `content_reports_ibfk_2` FOREIGN KEY (`moderator_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`facilitator_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `discussion_bookmarks`
--
ALTER TABLE `discussion_bookmarks`
  ADD CONSTRAINT `discussion_bookmarks_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `discussion_bookmarks_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `discussion_posts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `discussion_categories`
--
ALTER TABLE `discussion_categories`
  ADD CONSTRAINT `discussion_categories_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `discussion_categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `discussion_categories_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `discussion_comments`
--
ALTER TABLE `discussion_comments`
  ADD CONSTRAINT `discussion_comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `discussion_posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `discussion_comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `discussion_comments_ibfk_3` FOREIGN KEY (`parent_id`) REFERENCES `discussion_comments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `discussion_likes`
--
ALTER TABLE `discussion_likes`
  ADD CONSTRAINT `discussion_likes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `discussion_posts`
--
ALTER TABLE `discussion_posts`
  ADD CONSTRAINT `discussion_posts_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `discussion_categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `discussion_posts_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `discussion_posts_ibfk_3` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `draft_posts`
--
ALTER TABLE `draft_posts`
  ADD CONSTRAINT `draft_posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD CONSTRAINT `enrollments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `enrollments_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `event_rsvps`
--
ALTER TABLE `event_rsvps`
  ADD CONSTRAINT `event_rsvps_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `community_events` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `event_rsvps_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lessons`
--
ALTER TABLE `lessons`
  ADD CONSTRAINT `lessons_ibfk_1` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `modules`
--
ALTER TABLE `modules`
  ADD CONSTRAINT `modules_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `portfolios`
--
ALTER TABLE `portfolios`
  ADD CONSTRAINT `portfolios_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `portfolios_ibfk_2` FOREIGN KEY (`submission_id`) REFERENCES `submissions` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `portfolio_items`
--
ALTER TABLE `portfolio_items`
  ADD CONSTRAINT `portfolio_items_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `portfolio_items_ibfk_2` FOREIGN KEY (`submission_id`) REFERENCES `submissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `portfolio_settings`
--
ALTER TABLE `portfolio_settings`
  ADD CONSTRAINT `portfolio_settings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `submissions`
--
ALTER TABLE `submissions`
  ADD CONSTRAINT `submissions_ibfk_1` FOREIGN KEY (`assignment_id`) REFERENCES `assignments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `submissions_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_badges`
--
ALTER TABLE `user_badges`
  ADD CONSTRAINT `user_badges_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_badges_ibfk_2` FOREIGN KEY (`badge_id`) REFERENCES `badges` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_follows`
--
ALTER TABLE `user_follows`
  ADD CONSTRAINT `user_follows_ibfk_1` FOREIGN KEY (`follower_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_follows_ibfk_2` FOREIGN KEY (`following_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD CONSTRAINT `user_profiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `xp_transactions`
--
ALTER TABLE `xp_transactions`
  ADD CONSTRAINT `xp_transactions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
