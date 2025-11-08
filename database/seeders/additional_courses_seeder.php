<?php

/**
 * Additional Courses Seeder
 * Seeds multiple courses across different categories
 */

require_once __DIR__ . '/../../vendor/autoload.php';

use Nebatech\Core\Database;
use Nebatech\Models\Course;
use Nebatech\Models\User;

// Initialize database connection
Database::connect();

echo "Starting additional courses seeding...\n\n";

// Get facilitator user
$facilitator = User::findByEmail('facilitator@nebatech.com');
if (!$facilitator) {
    echo "Error: Facilitator user not found. Please run user seeder first.\n";
    exit(1);
}

$facilitatorId = $facilitator['id'];

// Define courses to seed
$courses = [
    // Backend Development
    [
        'facilitator_id' => $facilitatorId,
        'title' => 'Backend Development with PHP & MySQL',
        'slug' => 'backend-php-mysql',
        'description' => 'Master server-side development with PHP and MySQL. Build robust APIs, manage databases, and create scalable web applications.',
        'category' => 'Backend Development',
        'level' => 'intermediate',
        'duration_hours' => 100,
        'status' => 'published'
    ],
    [
        'facilitator_id' => $facilitatorId,
        'title' => 'Node.js & Express Backend Development',
        'slug' => 'nodejs-express-backend',
        'description' => 'Build fast, scalable backend applications with Node.js and Express. Learn async programming, database integration, and API development.',
        'category' => 'Backend Development',
        'level' => 'intermediate',
        'duration_hours' => 80,
        'status' => 'published'
    ],
    
    // Full Stack Development
    [
        'facilitator_id' => $facilitatorId,
        'title' => 'Full Stack Web Development Bootcamp',
        'slug' => 'fullstack-bootcamp',
        'description' => 'Become a full stack developer! Learn frontend (React) and backend (Node.js) development to build complete web applications from scratch.',
        'category' => 'Full Stack Development',
        'level' => 'intermediate',
        'duration_hours' => 160,
        'status' => 'published'
    ],
    [
        'facilitator_id' => $facilitatorId,
        'title' => 'MERN Stack Development',
        'slug' => 'mern-stack',
        'description' => 'Master the MERN stack (MongoDB, Express, React, Node.js) to build modern, scalable web applications with JavaScript.',
        'category' => 'Full Stack Development',
        'level' => 'advanced',
        'duration_hours' => 140,
        'status' => 'published'
    ],
    
    // Mobile Development
    [
        'facilitator_id' => $facilitatorId,
        'title' => 'React Native Mobile Development',
        'slug' => 'react-native-mobile',
        'description' => 'Build native mobile apps for iOS and Android using React Native. Learn to create beautiful, performant cross-platform applications.',
        'category' => 'Mobile Development',
        'level' => 'intermediate',
        'duration_hours' => 100,
        'status' => 'published'
    ],
    [
        'facilitator_id' => $facilitatorId,
        'title' => 'Flutter Mobile App Development',
        'slug' => 'flutter-mobile-apps',
        'description' => 'Create beautiful, natively compiled applications for mobile, web, and desktop from a single codebase using Flutter and Dart.',
        'category' => 'Mobile Development',
        'level' => 'beginner',
        'duration_hours' => 120,
        'status' => 'published'
    ],
    
    // AI & Machine Learning
    [
        'facilitator_id' => $facilitatorId,
        'title' => 'Introduction to Machine Learning with Python',
        'slug' => 'machine-learning-python',
        'description' => 'Start your AI journey! Learn machine learning fundamentals with Python, scikit-learn, and build your first ML models.',
        'category' => 'AI & Machine Learning',
        'level' => 'beginner',
        'duration_hours' => 100,
        'status' => 'published'
    ],
    [
        'facilitator_id' => $facilitatorId,
        'title' => 'Deep Learning & Neural Networks',
        'slug' => 'deep-learning-neural-networks',
        'description' => 'Master deep learning with TensorFlow and Keras. Build neural networks for image recognition, NLP, and more.',
        'category' => 'AI & Machine Learning',
        'level' => 'advanced',
        'duration_hours' => 140,
        'status' => 'published'
    ],
    
    // Data Science
    [
        'facilitator_id' => $facilitatorId,
        'title' => 'Data Science Fundamentals',
        'slug' => 'data-science-fundamentals',
        'description' => 'Learn data analysis, visualization, and statistical modeling. Master Python data science tools to extract insights from data.',
        'category' => 'Data Science',
        'level' => 'beginner',
        'duration_hours' => 120,
        'status' => 'published'
    ],
    [
        'facilitator_id' => $facilitatorId,
        'title' => 'Big Data Analytics with Apache Spark',
        'slug' => 'big-data-spark',
        'description' => 'Process and analyze massive datasets with Apache Spark. Learn distributed computing for big data applications.',
        'category' => 'Data Science',
        'level' => 'advanced',
        'duration_hours' => 100,
        'status' => 'published'
    ],
    
    // Cybersecurity
    [
        'facilitator_id' => $facilitatorId,
        'title' => 'Ethical Hacking & Penetration Testing',
        'slug' => 'ethical-hacking-pentest',
        'description' => 'Learn ethical hacking techniques to secure systems. Master penetration testing, vulnerability assessment, and security tools.',
        'category' => 'Cybersecurity',
        'level' => 'intermediate',
        'duration_hours' => 120,
        'status' => 'published'
    ],
    [
        'facilitator_id' => $facilitatorId,
        'title' => 'Web Application Security',
        'slug' => 'web-app-security',
        'description' => 'Secure your web applications! Learn about OWASP Top 10, secure coding practices, and how to protect against common attacks.',
        'category' => 'Cybersecurity',
        'level' => 'intermediate',
        'duration_hours' => 80,
        'status' => 'published'
    ],
    
    // Cloud Computing
    [
        'facilitator_id' => $facilitatorId,
        'title' => 'AWS Cloud Practitioner Essentials',
        'slug' => 'aws-cloud-practitioner',
        'description' => 'Master Amazon Web Services fundamentals. Learn cloud computing concepts and prepare for AWS certification.',
        'category' => 'Cloud Computing',
        'level' => 'beginner',
        'duration_hours' => 80,
        'status' => 'published'
    ],
    [
        'facilitator_id' => $facilitatorId,
        'title' => 'Docker & Kubernetes DevOps',
        'slug' => 'docker-kubernetes-devops',
        'description' => 'Master containerization and orchestration with Docker and Kubernetes. Build scalable, cloud-native applications.',
        'category' => 'Cloud Computing',
        'level' => 'intermediate',
        'duration_hours' => 100,
        'status' => 'published'
    ],
    
    // Additional Frontend Courses
    [
        'facilitator_id' => $facilitatorId,
        'title' => 'Vue.js Modern Frontend Development',
        'slug' => 'vuejs-frontend',
        'description' => 'Build interactive user interfaces with Vue.js. Learn the progressive JavaScript framework that\'s easy to learn and powerful.',
        'category' => 'Frontend Development',
        'level' => 'intermediate',
        'duration_hours' => 80,
        'status' => 'published'
    ],
    [
        'facilitator_id' => $facilitatorId,
        'title' => 'Angular Enterprise Applications',
        'slug' => 'angular-enterprise',
        'description' => 'Build large-scale enterprise applications with Angular. Master TypeScript, RxJS, and Angular best practices.',
        'category' => 'Frontend Development',
        'level' => 'advanced',
        'duration_hours' => 120,
        'status' => 'published'
    ],
];

// Seed each course
$successCount = 0;
$errorCount = 0;

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

foreach ($courses as $courseData) {
    try {
        echo "Attempting to create: {$courseData['title']}...\n";
        $courseId = Course::createCourse($courseData);
        
        if ($courseId) {
            echo "✓ Created course: {$courseData['title']} (ID: $courseId)\n";
            $successCount++;
        } else {
            // Check for any error log
            $lastError = error_get_last();
            echo "✗ Failed to create course: {$courseData['title']} (returned null/false)\n";
            if ($lastError) {
                echo "  Last error: " . $lastError['message'] . "\n";
            }
            $errorCount++;
        }
    } catch (Exception $e) {
        echo "✗ Error creating course '{$courseData['title']}': " . $e->getMessage() . "\n";
        echo "  Stack trace: " . $e->getTraceAsString() . "\n";
        $errorCount++;
    }
    echo "\n";
}

echo "\n";
echo "=================================\n";
echo "Seeding completed!\n";
echo "Successful: $successCount courses\n";
echo "Failed: $errorCount courses\n";
echo "=================================\n";
