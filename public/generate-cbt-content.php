<?php
/**
 * CBT Content Generator
 * Generates competency-based training content for all lessons
 * 
 * This creates:
 * - Learning objectives (3-5 per lesson)
 * - Practical exercises (1 per lesson)
 * - Quizzes with questions (3-5 questions per lesson)
 * - Module milestones
 * - Course competencies
 */

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// Increase limits for large operation
set_time_limit(0);
ini_set('memory_limit', '512M');

echo "===========================================\n";
echo "  CBT CONTENT GENERATOR\n";
echo "  Nebatech AI Academy\n";
echo "===========================================\n\n";

try {
    $pdo = new PDO(
        'mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'],
        $_ENV['DB_USER'],
        $_ENV['DB_PASSWORD'],
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true
        ]
    );
    
    echo "[✓] Database connected\n\n";
    
    // Course-specific configurations for generating appropriate content
    $courseConfigs = [
        'frontend' => [
            'practical_type' => 'coding',
            'code_language' => 'html',
            'competency_prefix' => 'FE',
            'category' => 'Web Development'
        ],
        'backend' => [
            'practical_type' => 'coding',
            'code_language' => 'php',
            'competency_prefix' => 'BE',
            'category' => 'Web Development'
        ],
        'fullstack' => [
            'practical_type' => 'coding',
            'code_language' => 'javascript',
            'competency_prefix' => 'FS',
            'category' => 'Web Development'
        ],
        'mobile' => [
            'practical_type' => 'coding',
            'code_language' => 'dart',
            'competency_prefix' => 'MOB',
            'category' => 'Mobile Development'
        ],
        'ai' => [
            'practical_type' => 'coding',
            'code_language' => 'python',
            'competency_prefix' => 'AI',
            'category' => 'Artificial Intelligence'
        ],
        'data-science' => [
            'practical_type' => 'coding',
            'code_language' => 'python',
            'competency_prefix' => 'DS',
            'category' => 'Data Science'
        ],
        'cybersecurity' => [
            'practical_type' => 'hands-on',
            'code_language' => 'bash',
            'competency_prefix' => 'SEC',
            'category' => 'Cybersecurity'
        ],
        'cloud' => [
            'practical_type' => 'hands-on',
            'code_language' => 'yaml',
            'competency_prefix' => 'CLD',
            'category' => 'Cloud Computing'
        ],
        'database' => [
            'practical_type' => 'coding',
            'code_language' => 'sql',
            'competency_prefix' => 'DB',
            'category' => 'Database Management'
        ],
        'networking' => [
            'practical_type' => 'hands-on',
            'code_language' => null,
            'competency_prefix' => 'NET',
            'category' => 'Networking'
        ],
        'hardware' => [
            'practical_type' => 'hands-on',
            'code_language' => null,
            'competency_prefix' => 'HW',
            'category' => 'Hardware & Troubleshooting'
        ],
        'digital-literacy' => [
            'practical_type' => 'hands-on',
            'code_language' => null,
            'competency_prefix' => 'DL',
            'category' => 'Digital Literacy'
        ],
        'microsoft-office' => [
            'practical_type' => 'hands-on',
            'code_language' => null,
            'competency_prefix' => 'MO',
            'category' => 'Productivity Software'
        ],
        'graphic-design' => [
            'practical_type' => 'design',
            'code_language' => null,
            'competency_prefix' => 'GD',
            'category' => 'Graphic Design'
        ],
        'video-editing' => [
            'practical_type' => 'project',
            'code_language' => null,
            'competency_prefix' => 'VE',
            'category' => 'Video Production'
        ]
    ];

    // Bloom's taxonomy action verbs for different levels
    $bloomVerbs = [
        'remember' => ['identify', 'list', 'name', 'recognize', 'recall', 'define'],
        'understand' => ['describe', 'explain', 'summarize', 'interpret', 'classify', 'compare'],
        'apply' => ['implement', 'use', 'execute', 'demonstrate', 'apply', 'solve'],
        'analyze' => ['analyze', 'differentiate', 'examine', 'compare', 'contrast', 'debug'],
        'evaluate' => ['evaluate', 'assess', 'justify', 'critique', 'recommend', 'optimize'],
        'create' => ['create', 'design', 'develop', 'build', 'produce', 'construct']
    ];

    // Get all courses - main bundle courses that have modules
    $courses = $pdo->query("
        SELECT c.*, 
               (SELECT COUNT(*) FROM modules WHERE course_id = c.id) as module_count,
               (SELECT COUNT(*) FROM lessons l JOIN modules m ON l.module_id = m.id WHERE m.course_id = c.id) as lesson_count
        FROM courses c 
        WHERE c.is_bundle = 1 AND c.status = 'published'
        ORDER BY c.id
    ")->fetchAll(PDO::FETCH_ASSOC);
    
    echo "Found " . count($courses) . " courses to process\n\n";
    
    $stats = [
        'learning_objectives' => 0,
        'practicals' => 0,
        'quizzes' => 0,
        'quiz_questions' => 0,
        'milestones' => 0,
        'competencies' => 0
    ];
    
    foreach ($courses as $course) {
        $config = $courseConfigs[$course['slug']] ?? [
            'practical_type' => 'hands-on',
            'code_language' => null,
            'competency_prefix' => 'GEN',
            'category' => 'General'
        ];
        
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        echo "📚 Processing: {$course['title']}\n";
        echo "   Modules: {$course['module_count']} | Lessons: {$course['lesson_count']}\n";
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        
        // Generate course competencies
        $competencyCount = generateCourseCompetencies($pdo, $course, $config, $bloomVerbs);
        $stats['competencies'] += $competencyCount;
        echo "   [✓] Generated {$competencyCount} competencies\n";
        
        // Get modules for this course
        $modules = $pdo->prepare("
            SELECT * FROM modules 
            WHERE course_id = ? AND status = 'published'
            ORDER BY order_index
        ");
        $modules->execute([$course['id']]);
        $modules = $modules->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($modules as $moduleIndex => $module) {
            echo "\n   📁 Module " . ($moduleIndex + 1) . ": {$module['title']}\n";
            
            // Get lessons for this module
            $lessons = $pdo->prepare("
                SELECT * FROM lessons 
                WHERE module_id = ?
                ORDER BY order_index
            ");
            $lessons->execute([$module['id']]);
            $lessons = $lessons->fetchAll(PDO::FETCH_ASSOC);
            
            foreach ($lessons as $lessonIndex => $lesson) {
                // Generate learning objectives
                $objCount = generateLearningObjectives($pdo, $lesson, $config, $bloomVerbs);
                $stats['learning_objectives'] += $objCount;
                
                // Generate practical exercise
                $practicalId = generatePractical($pdo, $lesson, $config);
                if ($practicalId) $stats['practicals']++;
                
                // Generate quiz with questions
                $quizResult = generateQuiz($pdo, $lesson, $config);
                if ($quizResult) {
                    $stats['quizzes']++;
                    $stats['quiz_questions'] += $quizResult['question_count'];
                }
                
                // Update lesson flags
                $pdo->prepare("
                    UPDATE lessons SET has_practical = 1, has_quiz = 1 WHERE id = ?
                ")->execute([$lesson['id']]);
            }
            
            echo "      ✓ Processed " . count($lessons) . " lessons\n";
            
            // Generate module milestone
            $milestoneId = generateMilestone($pdo, $module, $config, count($lessons));
            if ($milestoneId) {
                $stats['milestones']++;
                $pdo->prepare("UPDATE modules SET has_milestone = 1 WHERE id = ?")->execute([$module['id']]);
            }
        }
        
        // Update course CBT flag
        $pdo->prepare("UPDATE courses SET is_cbt = 1, total_competencies = ? WHERE id = ?")
            ->execute([$competencyCount, $course['id']]);
        
        echo "\n   ✅ Course complete!\n\n";
    }
    
    echo "===========================================\n";
    echo "  CBT CONTENT GENERATION COMPLETE!\n";
    echo "===========================================\n";
    echo "  Learning Objectives: {$stats['learning_objectives']}\n";
    echo "  Practical Exercises: {$stats['practicals']}\n";
    echo "  Quizzes: {$stats['quizzes']}\n";
    echo "  Quiz Questions: {$stats['quiz_questions']}\n";
    echo "  Module Milestones: {$stats['milestones']}\n";
    echo "  Course Competencies: {$stats['competencies']}\n";
    echo "===========================================\n";
    
} catch (PDOException $e) {
    echo "[✗] Database error: " . $e->getMessage() . "\n";
    exit(1);
}

/**
 * Generate learning objectives for a lesson
 */
function generateLearningObjectives($pdo, $lesson, $config, $bloomVerbs) {
    // Check if objectives already exist
    $check = $pdo->prepare("SELECT COUNT(*) FROM learning_objectives WHERE lesson_id = ?");
    $check->execute([$lesson['id']]);
    if ($check->fetchColumn() > 0) {
        return 0; // Already has objectives
    }
    
    $lessonTitle = $lesson['title'];
    
    // Determine appropriate bloom levels based on lesson position
    $levels = ['understand', 'apply', 'apply', 'analyze'];
    if (strpos(strtolower($lessonTitle), 'introduction') !== false || 
        strpos(strtolower($lessonTitle), 'overview') !== false ||
        strpos(strtolower($lessonTitle), 'what is') !== false) {
        $levels = ['remember', 'understand', 'understand'];
    } elseif (strpos(strtolower($lessonTitle), 'advanced') !== false ||
              strpos(strtolower($lessonTitle), 'optimization') !== false ||
              strpos(strtolower($lessonTitle), 'best practices') !== false) {
        $levels = ['apply', 'analyze', 'evaluate', 'create'];
    }
    
    $objectives = [];
    $count = rand(3, 4);
    
    for ($i = 0; $i < $count; $i++) {
        $level = $levels[$i % count($levels)];
        $verb = $bloomVerbs[$level][array_rand($bloomVerbs[$level])];
        
        // Generate objective based on lesson title
        $objectives[] = [
            'text' => generateObjectiveText($verb, $lessonTitle, $config),
            'bloom_level' => $level,
            'is_assessable' => true
        ];
    }
    
    // Insert objectives
    $stmt = $pdo->prepare("
        INSERT INTO learning_objectives (lesson_id, objective_number, objective_text, bloom_level, is_assessable)
        VALUES (?, ?, ?, ?, ?)
    ");
    
    foreach ($objectives as $index => $obj) {
        $stmt->execute([
            $lesson['id'],
            $index + 1,
            $obj['text'],
            $obj['bloom_level'],
            $obj['is_assessable']
        ]);
    }
    
    return count($objectives);
}

/**
 * Generate objective text based on verb and lesson title
 */
function generateObjectiveText($verb, $lessonTitle, $config) {
    // Clean up lesson title for use in objective
    $topic = preg_replace('/^(Introduction to|Understanding|Working with|Building|Creating|Implementing)\s+/i', '', $lessonTitle);
    $topic = strtolower($topic);
    
    $templates = [
        "By the end of this lesson, learners will be able to {$verb} {$topic} concepts and principles.",
        "Learners will {$verb} the key aspects of {$topic} in practical scenarios.",
        "Students will {$verb} {$topic} techniques effectively in real-world applications.",
        "Upon completion, learners can {$verb} {$topic} requirements and best practices.",
        "Participants will {$verb} {$topic} components and their relationships."
    ];
    
    return $templates[array_rand($templates)];
}

/**
 * Generate practical exercise for a lesson
 */
function generatePractical($pdo, $lesson, $config) {
    // Check if practical already exists
    $check = $pdo->prepare("SELECT id FROM practicals WHERE lesson_id = ?");
    $check->execute([$lesson['id']]);
    if ($existing = $check->fetchColumn()) {
        return $existing; // Return existing ID
    }
    
    $lessonTitle = $lesson['title'];
    $practicalType = $config['practical_type'];
    $codeLanguage = $config['code_language'];
    
    // Determine difficulty based on lesson content
    $difficulty = 'beginner';
    if (strpos(strtolower($lessonTitle), 'advanced') !== false ||
        strpos(strtolower($lessonTitle), 'complex') !== false) {
        $difficulty = 'advanced';
    } elseif (strpos(strtolower($lessonTitle), 'intermediate') !== false ||
              strpos(strtolower($lessonTitle), 'building') !== false ||
              strpos(strtolower($lessonTitle), 'implementing') !== false) {
        $difficulty = 'intermediate';
    }
    
    $practical = generatePracticalContent($lessonTitle, $practicalType, $difficulty, $codeLanguage);
    
    // Map practical_type to exercise_type enum values
    $exerciseTypeMap = [
        'coding' => 'coding',
        'design' => 'design',
        'documentation' => 'written',
        'research' => 'research',
        'hands-on' => 'hands-on',
        'project' => 'project'
    ];
    $exerciseType = $exerciseTypeMap[$practicalType] ?? 'hands-on';
    
    $stmt = $pdo->prepare("
        INSERT INTO practicals (
            lesson_id, title, description, instructions, expected_outcome,
            starter_code, hints, difficulty, estimated_time_minutes,
            exercise_type, grading_rubric, max_points, passing_score, status
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'published')
    ");
    
    $stmt->execute([
        $lesson['id'],
        $practical['title'],
        $practical['description'],
        $practical['instructions'],
        $practical['expected_outcome'],
        $practical['starter_code'],
        json_encode($practical['hints']),
        $difficulty,
        $practical['time'],
        $exerciseType,
        json_encode($practical['rubric']),
        100,
        70
    ]);
    
    return $pdo->lastInsertId();
}

/**
 * Generate practical content based on lesson
 */
function generatePracticalContent($lessonTitle, $type, $difficulty, $codeLanguage) {
    $topic = preg_replace('/^(Introduction to|Understanding|Working with|Building|Creating|Implementing)\s+/i', '', $lessonTitle);
    
    $timeMap = ['beginner' => 20, 'intermediate' => 35, 'advanced' => 50];
    
    $content = [
        'title' => "Hands-on: {$topic}",
        'description' => "In this practical exercise, you will apply what you learned about {$topic}. This is a {$difficulty} level exercise designed to reinforce your understanding through hands-on practice.",
        'instructions' => generatePracticalInstructions($topic, $type, $difficulty),
        'expected_outcome' => "Upon successful completion, you should have a working demonstration of {$topic} concepts that you can add to your portfolio.",
        'starter_code' => $codeLanguage ? generateStarterCode($topic, $codeLanguage) : null,
        'hints' => [
            "Start by reviewing the lesson content on {$topic}.",
            "Break down the task into smaller steps.",
            "Test your work frequently as you progress.",
            "Don't hesitate to reference documentation when needed."
        ],
        'time' => $timeMap[$difficulty],
        'rubric' => [
            ['criterion' => 'Task Completion', 'weight' => 40, 'description' => 'All required tasks are completed correctly'],
            ['criterion' => 'Code/Work Quality', 'weight' => 25, 'description' => 'Work follows best practices and standards'],
            ['criterion' => 'Understanding Demonstrated', 'weight' => 25, 'description' => 'Solution shows clear understanding of concepts'],
            ['criterion' => 'Documentation', 'weight' => 10, 'description' => 'Work is properly documented/commented']
        ]
    ];
    
    return $content;
}

/**
 * Generate practical instructions
 */
function generatePracticalInstructions($topic, $type, $difficulty) {
    $stepCount = ['beginner' => 4, 'intermediate' => 6, 'advanced' => 8][$difficulty];
    
    $instructions = "## Exercise: {$topic}\n\n";
    $instructions .= "### Objective\n";
    $instructions .= "Complete the following tasks to demonstrate your understanding of {$topic}.\n\n";
    $instructions .= "### Tasks\n\n";
    
    $taskTemplates = [
        "1. **Setup**: Prepare your development environment for working with {$topic}.\n",
        "2. **Research**: Review the key concepts covered in the lesson about {$topic}.\n",
        "3. **Implementation**: Create a basic implementation demonstrating {$topic}.\n",
        "4. **Testing**: Verify your implementation works as expected.\n",
        "5. **Enhancement**: Add an additional feature to extend your implementation.\n",
        "6. **Optimization**: Review and optimize your solution for better performance.\n",
        "7. **Documentation**: Add comments and documentation to your work.\n",
        "8. **Review**: Compare your solution with best practices and make improvements.\n"
    ];
    
    for ($i = 0; $i < $stepCount; $i++) {
        $instructions .= $taskTemplates[$i];
    }
    
    $instructions .= "\n### Submission Requirements\n";
    $instructions .= "- Complete all required tasks\n";
    $instructions .= "- Submit your work with explanations of your approach\n";
    $instructions .= "- Include any relevant files or code\n";
    
    return $instructions;
}

/**
 * Generate starter code based on language
 */
function generateStarterCode($topic, $language) {
    $topicVar = preg_replace('/[^a-zA-Z0-9]/', '', $topic);
    
    $templates = [
        'html' => "<!DOCTYPE html>\n<html lang=\"en\">\n<head>\n    <meta charset=\"UTF-8\">\n    <title>{$topic}</title>\n</head>\n<body>\n    <!-- Your code here -->\n    <h1>{$topic}</h1>\n    \n</body>\n</html>",
        'css' => "/* {$topic} Styles */\n\n/* Add your styles below */\n\n",
        'javascript' => "// {$topic} Exercise\n\n// Your code here\nfunction main() {\n    console.log('Starting {$topic} exercise...');\n    \n    // TODO: Implement your solution\n}\n\nmain();",
        'php' => "<?php\n/**\n * {$topic} Exercise\n */\n\n// Your code here\nfunction main() {\n    echo \"Starting {$topic} exercise...\\n\";\n    \n    // TODO: Implement your solution\n}\n\nmain();",
        'python' => "# {$topic} Exercise\n\ndef main():\n    \"\"\"Main function for {$topic} exercise\"\"\"\n    print(\"Starting {$topic} exercise...\")\n    \n    # TODO: Implement your solution\n    pass\n\nif __name__ == \"__main__\":\n    main()",
        'sql' => "-- {$topic} Exercise\n\n-- Your SQL queries here\n\n-- Task 1: \n\n-- Task 2: \n",
        'dart' => "// {$topic} Exercise\n\nvoid main() {\n  print('Starting {$topic} exercise...');\n  \n  // TODO: Implement your solution\n}",
        'bash' => "#!/bin/bash\n# {$topic} Exercise\n\necho \"Starting {$topic} exercise...\"\n\n# TODO: Implement your solution\n",
        'yaml' => "# {$topic} Configuration\n\n# Your configuration here\n"
    ];
    
    return $templates[$language] ?? "// {$topic} Exercise\n\n// Your code here\n";
}

/**
 * Generate quiz with questions for a lesson
 */
function generateQuiz($pdo, $lesson, $config) {
    // Check if quiz already exists
    $check = $pdo->prepare("SELECT id FROM quizzes WHERE lesson_id = ?");
    $check->execute([$lesson['id']]);
    if ($existing = $check->fetchColumn()) {
        // Count existing questions
        $qCheck = $pdo->prepare("SELECT COUNT(*) FROM quiz_questions WHERE quiz_id = ?");
        $qCheck->execute([$existing]);
        return [
            'quiz_id' => $existing,
            'question_count' => $qCheck->fetchColumn()
        ];
    }
    
    $lessonTitle = $lesson['title'];
    
    // Create quiz - using correct column names from schema
    $stmt = $pdo->prepare("
        INSERT INTO quizzes (
            lesson_id, title, description, quiz_type, max_attempts,
            passing_score, shuffle_questions, shuffle_answers,
            show_correct_answers, show_explanations, status
        ) VALUES (?, ?, ?, 'lesson_quiz', 3, 70, 1, 1, 1, 1, 'published')
    ");
    
    $stmt->execute([
        $lesson['id'],
        "{$lessonTitle} - Knowledge Check",
        "Test your understanding of {$lessonTitle} with these questions."
    ]);
    
    $quizId = $pdo->lastInsertId();
    
    // Generate questions
    $questions = generateQuizQuestions($lessonTitle, $config);
    
    $qStmt = $pdo->prepare("
        INSERT INTO quiz_questions (
            quiz_id, question_number, question_text, question_type,
            options, correct_answer, explanation, points, difficulty
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");
    
    foreach ($questions as $index => $q) {
        $qStmt->execute([
            $quizId,
            $index + 1,
            $q['question'],
            $q['type'],
            json_encode($q['options']),
            json_encode($q['correct']),
            $q['explanation'],
            $q['points'],
            $q['difficulty']
        ]);
    }
    
    return [
        'quiz_id' => $quizId,
        'question_count' => count($questions)
    ];
}

/**
 * Generate quiz questions based on lesson topic
 */
function generateQuizQuestions($lessonTitle, $config) {
    $topic = preg_replace('/^(Introduction to|Understanding|Working with|Building|Creating|Implementing)\s+/i', '', $lessonTitle);
    
    $questions = [];
    
    // Question 1: Definition/Concept (Easy)
    $questions[] = [
        'question' => "What is the primary purpose of {$topic}?",
        'type' => 'multiple_choice',
        'options' => [
            "To provide a structured approach to implementing {$topic} solutions",
            "To replace all other technologies completely",
            "To make development slower but more secure",
            "None of the above"
        ],
        'correct' => "To provide a structured approach to implementing {$topic} solutions",
        'explanation' => "{$topic} is designed to provide efficient and structured solutions for specific technical challenges.",
        'points' => 1,
        'difficulty' => 'easy'
    ];
    
    // Question 2: True/False (Easy)
    $questions[] = [
        'question' => "True or False: Understanding {$topic} is essential for professional development in this field.",
        'type' => 'true_false',
        'options' => ['True', 'False'],
        'correct' => 'True',
        'explanation' => "{$topic} is a fundamental concept that professionals in this field should understand.",
        'points' => 1,
        'difficulty' => 'easy'
    ];
    
    // Question 3: Application (Medium)
    $questions[] = [
        'question' => "When implementing {$topic}, which of the following is a best practice?",
        'type' => 'multiple_choice',
        'options' => [
            "Following established standards and documentation",
            "Ignoring all conventions and creating your own approach",
            "Copying code without understanding it",
            "Avoiding testing until the final stage"
        ],
        'correct' => "Following established standards and documentation",
        'explanation' => "Best practices in {$topic} include following established standards, proper documentation, and thorough testing.",
        'points' => 2,
        'difficulty' => 'medium'
    ];
    
    // Question 4: Analysis (Medium)
    $questions[] = [
        'question' => "Which scenario would be most appropriate for applying {$topic} concepts?",
        'type' => 'multiple_choice',
        'options' => [
            "When you need a scalable and maintainable solution",
            "When you want the fastest possible implementation regardless of quality",
            "When working on a project with no requirements",
            "When documentation is not required"
        ],
        'correct' => "When you need a scalable and maintainable solution",
        'explanation' => "{$topic} concepts are best applied when building scalable, maintainable, and professional-grade solutions.",
        'points' => 2,
        'difficulty' => 'medium'
    ];
    
    // Question 5: Evaluation (Hard)
    $questions[] = [
        'question' => "What is the most important consideration when evaluating a {$topic} implementation?",
        'type' => 'multiple_choice',
        'options' => [
            "Whether it meets the requirements and follows best practices",
            "How quickly it was developed",
            "Whether it uses the newest technology",
            "How complex the code looks"
        ],
        'correct' => "Whether it meets the requirements and follows best practices",
        'explanation' => "Evaluating implementations should focus on meeting requirements, following best practices, and ensuring maintainability.",
        'points' => 3,
        'difficulty' => 'hard'
    ];
    
    return $questions;
}

/**
 * Generate milestone for a module
 */
function generateMilestone($pdo, $module, $config, $lessonCount) {
    // Check if milestone already exists
    $check = $pdo->prepare("SELECT id FROM milestones WHERE module_id = ?");
    $check->execute([$module['id']]);
    if ($existing = $check->fetchColumn()) {
        return $existing; // Return existing ID
    }
    
    $moduleTitle = $module['title'];
    
    $requirements = [
        'lessons_completed' => $lessonCount,
        'quizzes_passed' => $lessonCount,
        'practicals_passed' => max(1, intval($lessonCount * 0.75))
    ];
    
    $competencies = [
        "Demonstrate understanding of {$moduleTitle} concepts",
        "Apply {$moduleTitle} techniques in practical scenarios",
        "Analyze and evaluate {$moduleTitle} implementations"
    ];
    
    $rubric = [
        ['criterion' => 'Technical Accuracy', 'weight' => 30, 'description' => 'Solution is technically correct and functional'],
        ['criterion' => 'Best Practices', 'weight' => 25, 'description' => 'Follows industry best practices and standards'],
        ['criterion' => 'Problem Solving', 'weight' => 25, 'description' => 'Demonstrates effective problem-solving approach'],
        ['criterion' => 'Documentation', 'weight' => 10, 'description' => 'Work is properly documented'],
        ['criterion' => 'Presentation', 'weight' => 10, 'description' => 'Solution is well-organized and presentable']
    ];
    
    $instructions = "## Module Milestone: {$moduleTitle}\n\n";
    $instructions .= "### Overview\n";
    $instructions .= "This milestone assessment will evaluate your mastery of {$moduleTitle} concepts and skills.\n\n";
    $instructions .= "### Prerequisites\n";
    $instructions .= "Before attempting this milestone, ensure you have:\n";
    $instructions .= "- Completed all {$lessonCount} lessons in this module\n";
    $instructions .= "- Passed all knowledge check quizzes\n";
    $instructions .= "- Completed at least 75% of practical exercises\n\n";
    $instructions .= "### Assessment Tasks\n";
    $instructions .= "1. Complete the provided project scenario\n";
    $instructions .= "2. Document your approach and decisions\n";
    $instructions .= "3. Submit your solution for review\n";
    $instructions .= "4. Be prepared to explain your implementation\n\n";
    $instructions .= "### Passing Criteria\n";
    $instructions .= "- Minimum score of 70% required to pass\n";
    $instructions .= "- All core competencies must be demonstrated\n";
    
    // Build passing criteria text
    $passingCriteriaText = implode("\n", array_merge(
        $requirements,
        ["Minimum score: 70%", "All core competencies must be demonstrated"]
    ));
    
    $stmt = $pdo->prepare("
        INSERT INTO milestones (
            module_id, title, description, milestone_type, requirements,
            competencies_assessed, passing_criteria, passing_score,
            is_required, order_index, status
        ) VALUES (?, ?, ?, 'practical', ?, ?, ?, 70, 1, ?, 'published')
    ");
    
    $stmt->execute([
        $module['id'],
        "{$moduleTitle} - Milestone Assessment",
        "Demonstrate your mastery of {$moduleTitle} through this comprehensive assessment.",
        json_encode($requirements),
        json_encode($competencies),
        $passingCriteriaText,
        $module['order_index'] ?? 1
    ]);
    
    return $pdo->lastInsertId();
}

/**
 * Generate course competencies
 */
function generateCourseCompetencies($pdo, $course, $config, $bloomVerbs) {
    // Check if competencies already exist for this course
    $check = $pdo->prepare("SELECT COUNT(*) FROM competencies WHERE course_id = ?");
    $check->execute([$course['id']]);
    if ($check->fetchColumn() > 0) {
        return 0; // Already has competencies
    }
    
    $prefix = $config['competency_prefix'];
    $category = $config['category'];
    
    // Get modules to create competencies based on them
    $modules = $pdo->prepare("SELECT * FROM modules WHERE course_id = ? ORDER BY order_index");
    $modules->execute([$course['id']]);
    $modules = $modules->fetchAll(PDO::FETCH_ASSOC);
    
    $competencies = [];
    $codeNum = 1;
    
    // Core competencies for the course
    $coreCompetencies = [
        ['level' => 'foundational', 'suffix' => 'Fundamentals', 'desc' => 'Understand the core concepts and principles'],
        ['level' => 'intermediate', 'suffix' => 'Application', 'desc' => 'Apply techniques in practical scenarios'],
        ['level' => 'advanced', 'suffix' => 'Analysis', 'desc' => 'Analyze and evaluate implementations'],
        ['level' => 'expert', 'suffix' => 'Mastery', 'desc' => 'Create advanced solutions and teach others']
    ];
    
    foreach ($coreCompetencies as $core) {
        $competencies[] = [
            'code' => sprintf('%s-%03d', $prefix, $codeNum++),
            'title' => "{$course['title']} {$core['suffix']}",
            'description' => "{$core['desc']} of {$course['title']}",
            'category' => 'Core',
            'level' => $core['level'],
            'is_core' => true
        ];
    }
    
    // Module-specific competencies
    foreach ($modules as $module) {
        $competencies[] = [
            'code' => sprintf('%s-%03d', $prefix, $codeNum++),
            'title' => $module['title'],
            'description' => "Demonstrate competency in {$module['title']}",
            'category' => $category,
            'level' => 'intermediate',
            'is_core' => false
        ];
    }
    
    // Insert competencies
    $stmt = $pdo->prepare("
        INSERT INTO competencies (course_id, competency_code, title, description, category, level, is_core)
        VALUES (?, ?, ?, ?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE title = VALUES(title), description = VALUES(description)
    ");
    
    foreach ($competencies as $comp) {
        $stmt->execute([
            $course['id'],
            $comp['code'],
            $comp['title'],
            $comp['description'],
            $comp['category'],
            $comp['level'],
            $comp['is_core']
        ]);
    }
    
    return count($competencies);
}
