<?php

/**
 * Frontend Development Course Seeder
 * 
 * Run this file to populate the database with a complete Frontend Development course
 * Usage: php database/seeders/frontend_course_seeder.php
 */

require_once __DIR__ . '/../../vendor/autoload.php';

use Nebatech\Core\Database;
use Nebatech\Models\User;
use Nebatech\Models\Course;
use Nebatech\Models\Module;
use Nebatech\Models\Lesson;
use Nebatech\Models\Assignment;

// Initialize database connection
Database::connect();

echo "Starting Frontend Development Course Seeder...\n\n";

// Step 1: Create or get facilitator user
echo "1. Creating facilitator user...\n";
$facilitatorEmail = 'facilitator@nebatech.com';
$facilitator = User::findByEmail($facilitatorEmail);

if (!$facilitator) {
    $facilitatorId = User::createUser([
        'first_name' => 'Sarah',
        'last_name' => 'Johnson',
        'email' => $facilitatorEmail,
        'password' => password_hash('Password123!', PASSWORD_BCRYPT, ['cost' => 12]),
        'role' => 'facilitator',
        'email_verified' => true
    ]);
    echo "   ✓ Facilitator created with ID: $facilitatorId\n";
} else {
    $facilitatorId = $facilitator['id'];
    echo "   ✓ Facilitator already exists with ID: $facilitatorId\n";
}

// Step 2: Create the course
echo "\n2. Creating Frontend Development course...\n";
$courseId = Course::createCourse([
    'title' => 'Frontend Development Fundamentals',
    'slug' => 'frontend-development-fundamentals',
    'description' => 'Master the essentials of modern frontend web development. Learn HTML5, CSS3, JavaScript, and React to build beautiful, responsive, and interactive websites. This comprehensive course takes you from zero to job-ready with hands-on projects and real-world examples.',
    'facilitator_id' => $facilitatorId,
    'category' => 'frontend',
    'level' => 'beginner',
    'duration_hours' => 60,
    'status' => 'published',
    'thumbnail' => 'uploads/thumbnails/frontend-dev-course.jpg'
]);
echo "   ✓ Course created with ID: $courseId\n";

// Step 3: Create modules
echo "\n3. Creating course modules...\n";
$modules = [
    [
        'title' => 'HTML5 Fundamentals',
        'description' => 'Learn the building blocks of web development with HTML5. Master semantic markup, forms, and modern HTML features.',
        'objectives' => json_encode([
            'Understand HTML document structure',
            'Create semantic HTML markup',
            'Build accessible web forms',
            'Use HTML5 multimedia elements',
            'Apply SEO best practices'
        ])
    ],
    [
        'title' => 'CSS3 & Responsive Design',
        'description' => 'Style beautiful websites with CSS3. Learn Flexbox, Grid, animations, and mobile-first responsive design.',
        'objectives' => json_encode([
            'Master CSS selectors and specificity',
            'Create flexible layouts with Flexbox and Grid',
            'Implement responsive design patterns',
            'Add animations and transitions',
            'Optimize CSS for performance'
        ])
    ],
    [
        'title' => 'JavaScript Basics',
        'description' => 'Get started with JavaScript programming. Learn variables, functions, control flow, and DOM manipulation.',
        'objectives' => json_encode([
            'Understand JavaScript fundamentals',
            'Work with variables and data types',
            'Write functions and control structures',
            'Manipulate the DOM',
            'Handle events and user interactions'
        ])
    ],
    [
        'title' => 'Advanced JavaScript',
        'description' => 'Deep dive into ES6+, async programming, API integration, and modern JavaScript patterns.',
        'objectives' => json_encode([
            'Master ES6+ features and syntax',
            'Understand asynchronous JavaScript',
            'Work with Fetch API and Promises',
            'Implement modern JavaScript patterns',
            'Debug and optimize JavaScript code'
        ])
    ],
    [
        'title' => 'React Fundamentals',
        'description' => 'Learn React.js to build dynamic user interfaces. Master components, props, state, and hooks.',
        'objectives' => json_encode([
            'Understand React core concepts',
            'Create functional components',
            'Manage state with hooks',
            'Handle props and component composition',
            'Build interactive UIs'
        ])
    ],
    [
        'title' => 'React Advanced Concepts',
        'description' => 'Master advanced React patterns, routing, state management, and performance optimization.',
        'objectives' => json_encode([
            'Implement React Router for navigation',
            'Manage global state effectively',
            'Optimize React performance',
            'Use Context API and custom hooks',
            'Test React components'
        ])
    ],
    [
        'title' => 'Version Control with Git',
        'description' => 'Master Git for version control. Learn branching, merging, and collaboration workflows.',
        'objectives' => json_encode([
            'Understand version control concepts',
            'Use Git commands effectively',
            'Manage branches and merges',
            'Collaborate with GitHub',
            'Follow Git best practices'
        ])
    ],
    [
        'title' => 'Final Capstone Project',
        'description' => 'Build a complete full-stack web application from scratch. Showcase all the skills you\'ve learned.',
        'objectives' => json_encode([
            'Plan and design a web application',
            'Implement frontend with React',
            'Deploy to production',
            'Present and document your project',
            'Build your developer portfolio'
        ])
    ]
];

$moduleIds = [];
foreach ($modules as $index => $moduleData) {
    $moduleId = Module::createModule([
        'course_id' => $courseId,
        'title' => $moduleData['title'],
        'description' => $moduleData['description'],
        'objectives' => $moduleData['objectives'],
        'status' => 'published',
        'order_index' => $index
    ]);
    $moduleIds[] = $moduleId;
    echo "   ✓ Module created: {$moduleData['title']} (ID: $moduleId)\n";
}

// Step 4: Create lessons for Module 1 (HTML5 Fundamentals)
echo "\n4. Creating lessons for Module 1: HTML5 Fundamentals...\n";
$htmlLessons = [
    [
        'title' => 'Introduction to HTML',
        'content' => '# Introduction to HTML

HTML (HyperText Markup Language) is the standard markup language for creating web pages.

## What is HTML?
HTML uses **tags** to mark up different parts of a webpage.

## Basic HTML Structure
```html
<!DOCTYPE html>
<html>
<head><title>My Page</title></head>
<body><h1>Hello World!</h1></body>
</html>
```',
        'type' => 'text',
        'duration_minutes' => 30,
        'resources' => json_encode([
            ['title' => 'MDN HTML Guide', 'url' => 'https://developer.mozilla.org/en-US/docs/Web/HTML', 'type' => 'article'],
            ['title' => 'HTML Tutorial - W3Schools', 'url' => 'https://www.w3schools.com/html/', 'type' => 'tutorial']
        ])
    ],
    [
        'title' => 'HTML Document Structure',
        'content' => 'Complete HTML5 semantic structure lesson content...',
        'type' => 'text',
        'duration_minutes' => 45,
        'resources' => json_encode([])
    ],
    [
        'title' => 'HTML Forms and Input',
        'content' => 'Complete forms lesson content...',
        'type' => 'text',
        'duration_minutes' => 40,
        'resources' => json_encode([])
    ],
    [
        'title' => 'Practice: Build a Contact Form',
        'content' => 'Complete practice exercise...',
        'type' => 'code',
        'duration_minutes' => 60,
        'resources' => json_encode([])
    ]
];

$contactFormLessonId = null;
foreach ($htmlLessons as $index => $lessonData) {
    $lessonId = Lesson::createLesson([
        'module_id' => $moduleIds[0],
        'title' => $lessonData['title'],
        'content' => $lessonData['content'],
        'type' => $lessonData['type'],
        'duration_minutes' => $lessonData['duration_minutes'],
        'resources' => $lessonData['resources'],
        'status' => 'published',
        'order_index' => $index,
        'ai_generated' => false
    ]);
    echo "   ✓ Lesson created: {$lessonData['title']} (ID: $lessonId)\n";
    
    if ($lessonData['title'] === 'Practice: Build a Contact Form') {
        $contactFormLessonId = $lessonId;
    }
}

// Step 5: Create assignment for HTML module
echo "\n5. Creating assignment for HTML module...\n";
if ($contactFormLessonId) {
    $assignmentId = Assignment::createAssignment([
        'lesson_id' => $contactFormLessonId,
        'title' => 'HTML Contact Form Project',
        'description' => 'Build a professional contact form using semantic HTML5 and form validation.',
        'instructions' => 'Create a contact form that includes all required fields, proper validation, and accessible markup. Test your form to ensure all validation works correctly.',
        'rubric' => json_encode([
            ['criteria' => 'HTML Structure', 'description' => 'Proper semantic HTML5 markup', 'max_points' => 20],
            ['criteria' => 'Form Elements', 'description' => 'All required fields included', 'max_points' => 25],
            ['criteria' => 'Validation', 'description' => 'Correct HTML5 validation attributes', 'max_points' => 25],
            ['criteria' => 'Accessibility', 'description' => 'Proper labels and ARIA attributes', 'max_points' => 20],
            ['criteria' => 'Code Quality', 'description' => 'Clean, well-formatted code', 'max_points' => 10]
        ]),
        'max_score' => 100,
        'due_date' => date('Y-m-d H:i:s', strtotime('+7 days'))
    ]);
    echo "   ✓ Assignment created: HTML Contact Form Project (ID: $assignmentId)\n";
}

// Step 6: Create lessons for Module 2 (CSS3 & Responsive Design)
echo "\n6. Creating lessons for Module 2: CSS3 & Responsive Design...\n";
$cssLessons = [
    ['title' => 'CSS Basics and Selectors', 'type' => 'text', 'duration' => 45],
    ['title' => 'Flexbox Layout', 'type' => 'text', 'duration' => 50],
    ['title' => 'CSS Grid Layout', 'type' => 'text', 'duration' => 50],
    ['title' => 'Responsive Design with Media Queries', 'type' => 'text', 'duration' => 45],
    ['title' => 'Project: Build a Responsive Portfolio Page', 'type' => 'project', 'duration' => 180]
];

$portfolioLessonId = null;
foreach ($cssLessons as $index => $lessonData) {
    $lessonId = Lesson::createLesson([
        'module_id' => $moduleIds[1],
        'title' => $lessonData['title'],
        'content' => 'Lesson content for ' . $lessonData['title'],
        'type' => $lessonData['type'],
        'duration_minutes' => $lessonData['duration'],
        'resources' => json_encode([]),
        'status' => 'published',
        'order_index' => $index,
        'ai_generated' => false
    ]);
    echo "   ✓ Lesson created: {$lessonData['title']} (ID: $lessonId)\n";
    
    if ($lessonData['title'] === 'Project: Build a Responsive Portfolio Page') {
        $portfolioLessonId = $lessonId;
    }
}

// Create CSS assignment
if ($portfolioLessonId) {
    $assignmentId = Assignment::createAssignment([
        'lesson_id' => $portfolioLessonId,
        'title' => 'Responsive Portfolio Website',
        'description' => 'Design and build a fully responsive personal portfolio website showcasing your skills.',
        'instructions' => 'Create a multi-section portfolio website with responsive design. Ensure it works perfectly on mobile, tablet, and desktop screens.',
        'rubric' => json_encode([
            ['criteria' => 'Responsive Design', 'description' => 'Works perfectly on all screen sizes', 'max_points' => 25],
            ['criteria' => 'Layout & Structure', 'description' => 'Proper use of Flexbox/Grid', 'max_points' => 20],
            ['criteria' => 'Design Quality', 'description' => 'Professional appearance and UX', 'max_points' => 20],
            ['criteria' => 'Code Quality', 'description' => 'Clean, organized CSS', 'max_points' => 15],
            ['criteria' => 'Content Completeness', 'description' => 'All required sections included', 'max_points' => 15],
            ['criteria' => 'Bonus Features', 'description' => 'Additional creative features', 'max_points' => 5]
        ]),
        'max_score' => 100,
        'due_date' => date('Y-m-d H:i:s', strtotime('+14 days'))
    ]);
    echo "   ✓ Assignment created: Responsive Portfolio Website (ID: $assignmentId)\n";
}

// Step 7: Create lessons for Module 3 (JavaScript Basics)
echo "\n7. Creating lessons for Module 3: JavaScript Basics...\n";
$jsBasicsLessons = [
    ['title' => 'JavaScript Introduction & Variables', 'type' => 'text', 'duration' => 40],
    ['title' => 'Functions and Control Flow', 'type' => 'text', 'duration' => 45],
    ['title' => 'DOM Manipulation', 'type' => 'text', 'duration' => 50],
    ['title' => 'Interactive Calculator Project', 'type' => 'code', 'duration' => 120]
];

$calculatorLessonId = null;
foreach ($jsBasicsLessons as $index => $lessonData) {
    $lessonId = Lesson::createLesson([
        'module_id' => $moduleIds[2],
        'title' => $lessonData['title'],
        'content' => 'Lesson content for ' . $lessonData['title'],
        'type' => $lessonData['type'],
        'duration_minutes' => $lessonData['duration'],
        'resources' => json_encode([]),
        'status' => 'published',
        'order_index' => $index,
        'ai_generated' => false
    ]);
    echo "   ✓ Lesson created: {$lessonData['title']} (ID: $lessonId)\n";
    
    if ($lessonData['title'] === 'Interactive Calculator Project') {
        $calculatorLessonId = $lessonId;
    }
}

// Create JavaScript assignment
if ($calculatorLessonId) {
    $assignmentId = Assignment::createAssignment([
        'lesson_id' => $calculatorLessonId,
        'title' => 'JavaScript Calculator Application',
        'description' => 'Build a fully functional calculator using JavaScript DOM manipulation.',
        'instructions' => 'Create an interactive calculator that handles basic arithmetic operations.',
        'rubric' => json_encode([
            ['criteria' => 'Functionality', 'description' => 'All basic operations work correctly', 'max_points' => 30],
            ['criteria' => 'DOM Manipulation', 'description' => 'Proper use of JavaScript DOM methods', 'max_points' => 25],
            ['criteria' => 'Code Organization', 'description' => 'Clean, well-structured code', 'max_points' => 20],
            ['criteria' => 'UI/UX', 'description' => 'User-friendly interface', 'max_points' => 15],
            ['criteria' => 'Error Handling', 'description' => 'Handles edge cases properly', 'max_points' => 10]
        ]),
        'max_score' => 100,
        'due_date' => date('Y-m-d H:i:s', strtotime('+10 days'))
    ]);
    echo "   ✓ Assignment created: JavaScript Calculator Application (ID: $assignmentId)\n";
}

// Step 8: Create placeholder lessons for remaining modules
echo "\n8. Creating placeholder lessons for remaining modules...\n";
$remainingModules = [
    ['index' => 3, 'name' => 'Advanced JavaScript', 'lessons' => 5],
    ['index' => 4, 'name' => 'React Fundamentals', 'lessons' => 6],
    ['index' => 5, 'name' => 'React Advanced Concepts', 'lessons' => 5],
    ['index' => 6, 'name' => 'Version Control with Git', 'lessons' => 4],
    ['index' => 7, 'name' => 'Final Capstone Project', 'lessons' => 3]
];

foreach ($remainingModules as $module) {
    echo "   Module: {$module['name']}\n";
    for ($i = 0; $i < $module['lessons']; $i++) {
        $lessonId = Lesson::createLesson([
            'module_id' => $moduleIds[$module['index']],
            'title' => "Lesson " . ($i + 1) . ": " . $module['name'],
            'content' => 'Content will be generated for this lesson.',
            'type' => ($i === $module['lessons'] - 1) ? 'project' : 'text',
            'duration_minutes' => ($i === $module['lessons'] - 1) ? 120 : 45,
            'resources' => json_encode([]),
            'status' => 'draft',
            'order_index' => $i,
            'ai_generated' => false
        ]);
        $lessonNum = $i + 1;
        echo "     ✓ Lesson $lessonNum created (ID: $lessonId)\n";
    }
}

// Final summary
echo "\n" . str_repeat("=", 50) . "\n";
echo "✅ SEEDING COMPLETED SUCCESSFULLY!\n";
echo str_repeat("=", 50) . "\n\n";

$stats = Database::fetchOne("
    SELECT 
        (SELECT COUNT(*) FROM modules WHERE course_id = :course_id) as modules_count,
        (SELECT COUNT(*) FROM lessons WHERE module_id IN (SELECT id FROM modules WHERE course_id = :course_id)) as lessons_count,
        (SELECT COUNT(*) FROM assignments WHERE lesson_id IN (SELECT id FROM lessons WHERE module_id IN (SELECT id FROM modules WHERE course_id = :course_id))) as assignments_count
    FROM DUAL
", ['course_id' => $courseId]);

echo "Course Summary:\n";
echo "  - Course ID: $courseId\n";
echo "  - Facilitator: Sarah Johnson (facilitator@nebatech.com)\n";
echo "  - Modules: {$stats['modules_count']}\n";
echo "  - Lessons: {$stats['lessons_count']}\n";
echo "  - Assignments: {$stats['assignments_count']}\n";
echo "  - Status: Published\n\n";

echo "You can now log in as the facilitator:\n";
echo "  Email: facilitator@nebatech.com\n";
echo "  Password: Password123!\n\n";

echo "Or view the course at: /courses/frontend-development-fundamentals\n\n";
