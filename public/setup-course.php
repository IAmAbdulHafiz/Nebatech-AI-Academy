<?php
/**
 * Setup Sample Course Content and Enrollment
 * This script creates modules, lessons, and enrolls a student for testing
 */

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/helpers.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

$db = Nebatech\Core\Database::connect();

echo "<h1>Course Setup Script</h1>";

// Get the Frontend Development course (id = 1)
$courseId = 1;
$stmt = $db->prepare("SELECT * FROM courses WHERE id = ?");
$stmt->execute([$courseId]);
$course = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$course) {
    die("Course not found!");
}

echo "<p>Setting up course: <strong>{$course['title']}</strong></p>";

// Check if modules already exist
$stmt = $db->prepare("SELECT COUNT(*) FROM modules WHERE course_id = ?");
$stmt->execute([$courseId]);
$moduleCount = $stmt->fetchColumn();

if ($moduleCount > 0) {
    echo "<p>Modules already exist for this course. Skipping module creation.</p>";
} else {
    // Create sample modules
    $modules = [
        [
            'title' => 'Introduction to Web Development',
            'description' => 'Learn the basics of web development, including how the web works and the tools you will use.',
            'order_index' => 1,
            'status' => 'published'
        ],
        [
            'title' => 'HTML Fundamentals',
            'description' => 'Master the building blocks of web pages with HTML5.',
            'order_index' => 2,
            'status' => 'published'
        ],
        [
            'title' => 'CSS Styling',
            'description' => 'Learn how to style your web pages with CSS3.',
            'order_index' => 3,
            'status' => 'published'
        ],
        [
            'title' => 'JavaScript Basics',
            'description' => 'Add interactivity to your websites with JavaScript.',
            'order_index' => 4,
            'status' => 'published'
        ]
    ];

    $moduleIds = [];
    foreach ($modules as $module) {
        $stmt = $db->prepare("INSERT INTO modules (uuid, course_id, title, description, order_index, status, created_at) 
                              VALUES (?, ?, ?, ?, ?, ?, NOW())");
        $uuid = sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
        $stmt->execute([$uuid, $courseId, $module['title'], $module['description'], $module['order_index'], $module['status']]);
        $moduleIds[] = $db->lastInsertId();
        echo "<p>Created module: {$module['title']}</p>";
    }

    // Create sample lessons for each module
    $lessonData = [
        // Module 1: Introduction to Web Development
        [
            ['title' => 'What is Web Development?', 'type' => 'text', 'content' => '<h2>Welcome to Web Development!</h2><p>Web development is the process of building and maintaining websites. It encompasses several different aspects, including web design, web publishing, web programming, and database management.</p><h3>Types of Web Development</h3><ul><li><strong>Frontend Development</strong> - What users see and interact with</li><li><strong>Backend Development</strong> - Server-side logic and databases</li><li><strong>Full Stack Development</strong> - Both frontend and backend</li></ul><p>In this course, you will focus on frontend development, learning HTML, CSS, and JavaScript to create beautiful and interactive websites.</p>', 'duration_minutes' => 15],
            ['title' => 'How the Web Works', 'type' => 'text', 'content' => '<h2>Understanding the Web</h2><p>The World Wide Web is a system of interlinked hypertext documents accessed via the Internet. When you type a URL in your browser:</p><ol><li>Your browser sends a request to a DNS server</li><li>The DNS server returns the IP address of the web server</li><li>Your browser sends an HTTP request to that IP address</li><li>The web server processes the request and sends back HTML, CSS, and JavaScript files</li><li>Your browser renders these files into the webpage you see</li></ol><h3>Key Concepts</h3><ul><li><strong>HTTP/HTTPS</strong> - Protocols for transferring data</li><li><strong>DNS</strong> - Domain Name System</li><li><strong>Server</strong> - A computer that hosts websites</li><li><strong>Client</strong> - Your browser</li></ul>', 'duration_minutes' => 20],
            ['title' => 'Setting Up Your Development Environment', 'type' => 'text', 'content' => '<h2>Getting Started</h2><p>Before we start coding, let\'s set up your development environment.</p><h3>Tools You\'ll Need</h3><ol><li><strong>Code Editor</strong> - We recommend Visual Studio Code (VS Code)</li><li><strong>Web Browser</strong> - Chrome, Firefox, or Edge with developer tools</li><li><strong>Terminal/Command Line</strong> - For running commands</li></ol><h3>Installing VS Code</h3><ol><li>Go to <a href="https://code.visualstudio.com">code.visualstudio.com</a></li><li>Download the version for your operating system</li><li>Run the installer and follow the prompts</li></ol><h3>Recommended Extensions</h3><ul><li>Live Server - Preview your pages in real-time</li><li>Prettier - Auto-format your code</li><li>HTML CSS Support - IntelliSense for CSS</li></ul>', 'duration_minutes' => 25]
        ],
        // Module 2: HTML Fundamentals
        [
            ['title' => 'HTML Document Structure', 'type' => 'text', 'content' => '<h2>The Anatomy of an HTML Document</h2><p>Every HTML document follows a basic structure:</p><pre><code>&lt;!DOCTYPE html&gt;\n&lt;html lang="en"&gt;\n&lt;head&gt;\n    &lt;meta charset="UTF-8"&gt;\n    &lt;meta name="viewport" content="width=device-width, initial-scale=1.0"&gt;\n    &lt;title&gt;My First Webpage&lt;/title&gt;\n&lt;/head&gt;\n&lt;body&gt;\n    &lt;h1&gt;Hello, World!&lt;/h1&gt;\n    &lt;p&gt;This is my first webpage.&lt;/p&gt;\n&lt;/body&gt;\n&lt;/html&gt;</code></pre><h3>Key Elements</h3><ul><li><code>&lt;!DOCTYPE html&gt;</code> - Declares this is HTML5</li><li><code>&lt;html&gt;</code> - Root element</li><li><code>&lt;head&gt;</code> - Contains metadata</li><li><code>&lt;body&gt;</code> - Contains visible content</li></ul>', 'duration_minutes' => 20],
            ['title' => 'Text and Headings', 'type' => 'text', 'content' => '<h2>Working with Text in HTML</h2><p>HTML provides various elements for structuring text content.</p><h3>Headings</h3><p>HTML has 6 levels of headings:</p><pre><code>&lt;h1&gt;Main Heading&lt;/h1&gt;\n&lt;h2&gt;Subheading&lt;/h2&gt;\n&lt;h3&gt;Sub-subheading&lt;/h3&gt;\n&lt;h4&gt;Fourth level&lt;/h4&gt;\n&lt;h5&gt;Fifth level&lt;/h5&gt;\n&lt;h6&gt;Sixth level&lt;/h6&gt;</code></pre><h3>Paragraphs and Line Breaks</h3><pre><code>&lt;p&gt;This is a paragraph.&lt;/p&gt;\n&lt;p&gt;This is another paragraph.&lt;br&gt;With a line break.&lt;/p&gt;</code></pre><h3>Text Formatting</h3><pre><code>&lt;strong&gt;Bold text&lt;/strong&gt;\n&lt;em&gt;Italic text&lt;/em&gt;\n&lt;mark&gt;Highlighted text&lt;/mark&gt;</code></pre>', 'duration_minutes' => 25],
            ['title' => 'Links and Images', 'type' => 'text', 'content' => '<h2>Adding Links and Images</h2><h3>Creating Links</h3><p>The anchor tag <code>&lt;a&gt;</code> creates hyperlinks:</p><pre><code>&lt;a href="https://example.com"&gt;Visit Example&lt;/a&gt;\n&lt;a href="about.html"&gt;About Page&lt;/a&gt;\n&lt;a href="#section"&gt;Jump to Section&lt;/a&gt;</code></pre><h3>Adding Images</h3><p>The <code>&lt;img&gt;</code> tag embeds images:</p><pre><code>&lt;img src="photo.jpg" alt="A description of the photo"&gt;\n&lt;img src="https://example.com/image.png" alt="External image"&gt;</code></pre><h3>Best Practices</h3><ul><li>Always include <code>alt</code> text for accessibility</li><li>Use descriptive file names</li><li>Optimize images for web</li></ul>', 'duration_minutes' => 20],
            ['title' => 'Lists and Tables', 'type' => 'text', 'content' => '<h2>Organizing Data with Lists and Tables</h2><h3>Unordered Lists</h3><pre><code>&lt;ul&gt;\n    &lt;li&gt;Item 1&lt;/li&gt;\n    &lt;li&gt;Item 2&lt;/li&gt;\n    &lt;li&gt;Item 3&lt;/li&gt;\n&lt;/ul&gt;</code></pre><h3>Ordered Lists</h3><pre><code>&lt;ol&gt;\n    &lt;li&gt;First step&lt;/li&gt;\n    &lt;li&gt;Second step&lt;/li&gt;\n    &lt;li&gt;Third step&lt;/li&gt;\n&lt;/ol&gt;</code></pre><h3>Tables</h3><pre><code>&lt;table&gt;\n    &lt;thead&gt;\n        &lt;tr&gt;\n            &lt;th&gt;Name&lt;/th&gt;\n            &lt;th&gt;Age&lt;/th&gt;\n        &lt;/tr&gt;\n    &lt;/thead&gt;\n    &lt;tbody&gt;\n        &lt;tr&gt;\n            &lt;td&gt;John&lt;/td&gt;\n            &lt;td&gt;25&lt;/td&gt;\n        &lt;/tr&gt;\n    &lt;/tbody&gt;\n&lt;/table&gt;</code></pre>', 'duration_minutes' => 30]
        ],
        // Module 3: CSS Styling
        [
            ['title' => 'Introduction to CSS', 'type' => 'text', 'content' => '<h2>What is CSS?</h2><p>CSS (Cascading Style Sheets) is used to style and layout web pages. It allows you to control colors, fonts, spacing, and much more.</p><h3>Three Ways to Add CSS</h3><ol><li><strong>Inline CSS</strong> - Using the style attribute</li><li><strong>Internal CSS</strong> - Using a &lt;style&gt; tag in the head</li><li><strong>External CSS</strong> - Using a separate .css file (recommended)</li></ol><h3>CSS Syntax</h3><pre><code>selector {\n    property: value;\n    another-property: value;\n}</code></pre><h3>Example</h3><pre><code>h1 {\n    color: blue;\n    font-size: 24px;\n    text-align: center;\n}</code></pre>', 'duration_minutes' => 20],
            ['title' => 'CSS Selectors', 'type' => 'text', 'content' => '<h2>Selecting Elements to Style</h2><h3>Basic Selectors</h3><pre><code>/* Element selector */\np { color: red; }\n\n/* Class selector */\n.highlight { background: yellow; }\n\n/* ID selector */\n#header { padding: 20px; }\n\n/* Universal selector */\n* { margin: 0; }</code></pre><h3>Combinators</h3><pre><code>/* Descendant */\ndiv p { color: blue; }\n\n/* Child */\ndiv > p { color: green; }\n\n/* Adjacent sibling */\nh1 + p { font-size: 18px; }</code></pre><h3>Pseudo-classes</h3><pre><code>a:hover { color: red; }\ninput:focus { border-color: blue; }\nli:first-child { font-weight: bold; }</code></pre>', 'duration_minutes' => 25],
            ['title' => 'Box Model and Layout', 'type' => 'text', 'content' => '<h2>Understanding the CSS Box Model</h2><p>Every element in CSS is a rectangular box. The box model describes how these boxes are sized and spaced.</p><h3>Box Model Components</h3><ul><li><strong>Content</strong> - The actual content (text, images)</li><li><strong>Padding</strong> - Space between content and border</li><li><strong>Border</strong> - The edge of the element</li><li><strong>Margin</strong> - Space outside the border</li></ul><h3>Example</h3><pre><code>.box {\n    width: 300px;\n    padding: 20px;\n    border: 2px solid black;\n    margin: 10px;\n}</code></pre><h3>Box-sizing</h3><pre><code>* {\n    box-sizing: border-box;\n}</code></pre><p>This makes width and height include padding and border.</p>', 'duration_minutes' => 30]
        ],
        // Module 4: JavaScript Basics
        [
            ['title' => 'Introduction to JavaScript', 'type' => 'text', 'content' => '<h2>What is JavaScript?</h2><p>JavaScript is a programming language that adds interactivity to your website. It can:</p><ul><li>Respond to user actions (clicks, input)</li><li>Modify HTML content dynamically</li><li>Validate forms</li><li>Create animations</li><li>Communicate with servers</li></ul><h3>Adding JavaScript to HTML</h3><pre><code>&lt;!-- Inline --&gt;\n&lt;button onclick="alert(\'Hello!\')"&gt;Click me&lt;/button&gt;\n\n&lt;!-- Internal --&gt;\n&lt;script&gt;\n    console.log("Hello, World!");\n&lt;/script&gt;\n\n&lt;!-- External (recommended) --&gt;\n&lt;script src="script.js"&gt;&lt;/script&gt;</code></pre>', 'duration_minutes' => 20],
            ['title' => 'Variables and Data Types', 'type' => 'text', 'content' => '<h2>Storing Data in JavaScript</h2><h3>Declaring Variables</h3><pre><code>// Modern way (recommended)\nlet name = "John";\nconst PI = 3.14159;\n\n// Old way (avoid)\nvar age = 25;</code></pre><h3>Data Types</h3><pre><code>// String\nlet greeting = "Hello";\n\n// Number\nlet count = 42;\nlet price = 19.99;\n\n// Boolean\nlet isActive = true;\n\n// Array\nlet colors = ["red", "green", "blue"];\n\n// Object\nlet person = {\n    name: "John",\n    age: 25\n};</code></pre><h3>Template Literals</h3><pre><code>let name = "World";\nconsole.log(`Hello, ${name}!`);</code></pre>', 'duration_minutes' => 25],
            ['title' => 'DOM Manipulation', 'type' => 'text', 'content' => '<h2>Interacting with the Page</h2><p>The DOM (Document Object Model) represents your HTML as a tree of objects that JavaScript can manipulate.</p><h3>Selecting Elements</h3><pre><code>// By ID\nconst header = document.getElementById("header");\n\n// By class (returns collection)\nconst items = document.getElementsByClassName("item");\n\n// Modern way (returns first match)\nconst button = document.querySelector(".btn");\n\n// Modern way (returns all matches)\nconst buttons = document.querySelectorAll(".btn");</code></pre><h3>Modifying Elements</h3><pre><code>// Change text\nelement.textContent = "New text";\n\n// Change HTML\nelement.innerHTML = "&lt;strong&gt;Bold text&lt;/strong&gt;";\n\n// Change styles\nelement.style.color = "red";\n\n// Add/remove classes\nelement.classList.add("active");\nelement.classList.remove("hidden");</code></pre>', 'duration_minutes' => 30],
            ['title' => 'Events and Interactivity', 'type' => 'text', 'content' => '<h2>Responding to User Actions</h2><h3>Adding Event Listeners</h3><pre><code>const button = document.querySelector("#myButton");\n\nbutton.addEventListener("click", function() {\n    alert("Button clicked!");\n});\n\n// Or with arrow function\nbutton.addEventListener("click", () => {\n    console.log("Clicked!");\n});</code></pre><h3>Common Events</h3><ul><li><code>click</code> - Mouse click</li><li><code>mouseover</code> - Mouse hover</li><li><code>keydown</code> - Key pressed</li><li><code>submit</code> - Form submitted</li><li><code>change</code> - Input value changed</li></ul><h3>Example: Toggle Class</h3><pre><code>const box = document.querySelector(".box");\n\nbox.addEventListener("click", () => {\n    box.classList.toggle("active");\n});</code></pre>', 'duration_minutes' => 30]
        ]
    ];

    $lessonOrder = 1;
    foreach ($moduleIds as $index => $moduleId) {
        foreach ($lessonData[$index] as $lesson) {
            $stmt = $db->prepare("INSERT INTO lessons (uuid, module_id, title, type, content, duration_minutes, order_index, created_at) 
                                  VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
            $uuid = sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                mt_rand(0, 0xffff), mt_rand(0, 0xffff),
                mt_rand(0, 0xffff),
                mt_rand(0, 0x0fff) | 0x4000,
                mt_rand(0, 0x3fff) | 0x8000,
                mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
            );
            $stmt->execute([$uuid, $moduleId, $lesson['title'], $lesson['type'], $lesson['content'], $lesson['duration_minutes'], $lessonOrder]);
            echo "<p>&nbsp;&nbsp;Created lesson: {$lesson['title']}</p>";
            $lessonOrder++;
        }
        $lessonOrder = 1; // Reset for next module
    }

    echo "<p><strong>Modules and lessons created successfully!</strong></p>";
}

// Now enroll the student (user_id = 10 based on the users list)
$studentId = 10;
$stmt = $db->prepare("SELECT * FROM enrollments WHERE user_id = ? AND course_id = ?");
$stmt->execute([$studentId, $courseId]);
$existingEnrollment = $stmt->fetch(PDO::FETCH_ASSOC);

if ($existingEnrollment) {
    echo "<p>Student is already enrolled in this course.</p>";
} else {
    // Create enrollment
    $stmt = $db->prepare("INSERT INTO enrollments (user_id, course_id, status, progress, enrolled_at) 
                          VALUES (?, ?, 'active', 0, NOW())");
    $stmt->execute([$studentId, $courseId]);
    echo "<p><strong>Student enrolled successfully!</strong></p>";
}

echo "<hr>";
echo "<h2>Next Steps:</h2>";
echo "<ol>";
echo "<li>Login as the student: <strong>student@gmail.com</strong></li>";
echo "<li>Go to <a href='/Nebatech-AI-Academy/public/my-courses'>My Courses</a></li>";
echo "<li>Click on the course to start learning</li>";
echo "</ol>";

echo "<p><a href='/Nebatech-AI-Academy/public/courses/frontend' class='btn'>View Course</a></p>";
