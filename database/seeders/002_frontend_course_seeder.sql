-- Frontend Development Course Seeder
-- Complete course with modules, lessons, and assignments

-- First, create a facilitator user if not exists
INSERT IGNORE INTO users (email, password, first_name, last_name, role, created_at)
VALUES ('facilitator@nebatech.com', '$2y$12$LQv3c1yduTi6jW.PFKEqKOHKIvVh9jhQjKLfqYJkJqQdGKQXdYmTO', 'Sarah', 'Johnson', 'facilitator', NOW());

SET @facilitator_id = (SELECT id FROM users WHERE email = 'facilitator@nebatech.com' LIMIT 1);

-- Create the Frontend Development Course
INSERT INTO courses (
    uuid,
    title, 
    slug, 
    description, 
    facilitator_id, 
    category, 
    level, 
    duration_hours, 
    status, 
    thumbnail,
    created_at
) VALUES (UUID(),
    'Frontend Development Fundamentals',
    'frontend-development-fundamentals',
    'Master the essentials of modern frontend web development. Learn HTML5, CSS3, JavaScript, and React to build beautiful, responsive, and interactive websites. This comprehensive course takes you from zero to job-ready with hands-on projects and real-world examples.',
    @facilitator_id,
    'frontend',
    'beginner',
    60,
    'published',
    'uploads/thumbnails/frontend-dev-course.jpg',
    NOW()
);

SET @course_id = LAST_INSERT_ID();

-- MODULE 1: HTML5 Fundamentals
INSERT INTO modules (uuid, course_id, title, description, objectives, status, order_index, created_at) VALUES (
    UUID(),
    @course_id,
    'HTML5 Fundamentals',
    'Learn the building blocks of web development with HTML5. Master semantic markup, forms, and modern HTML features.',
    '["Understand HTML document structure", "Create semantic HTML markup", "Build accessible web forms", "Use HTML5 multimedia elements", "Apply SEO best practices"]',
    'published',
    0,
    NOW()
);
SET @module1_id = LAST_INSERT_ID();

-- MODULE 2: CSS3 & Responsive Design
INSERT INTO modules (uuid, course_id, title, description, objectives, status, order_index, created_at) VALUES (
    UUID(),
    @course_id,
    'CSS3 & Responsive Design',
    'Style beautiful websites with CSS3. Learn Flexbox, Grid, animations, and mobile-first responsive design.',
    '["Master CSS selectors and specificity", "Create flexible layouts with Flexbox and Grid", "Implement responsive design patterns", "Add animations and transitions", "Optimize CSS for performance"]',
    'published',
    1,
    NOW()
);
SET @module2_id = LAST_INSERT_ID();

-- MODULE 3: JavaScript Basics
INSERT INTO modules (uuid, course_id, title, description, objectives, status, order_index, created_at) VALUES (
    UUID(),
    @course_id,
    'JavaScript Basics',
    'Get started with JavaScript programming. Learn variables, functions, control flow, and DOM manipulation.',
    '["Understand JavaScript fundamentals", "Work with variables and data types", "Write functions and control structures", "Manipulate the DOM", "Handle events and user interactions"]',
    'published',
    2,
    NOW()
);
SET @module3_id = LAST_INSERT_ID();

-- MODULE 4: Advanced JavaScript
INSERT INTO modules (uuid, course_id, title, description, objectives, status, order_index, created_at) VALUES (
    UUID(),
    @course_id,
    'Advanced JavaScript',
    'Deep dive into ES6+, async programming, API integration, and modern JavaScript patterns.',
    '["Master ES6+ features and syntax", "Understand asynchronous JavaScript", "Work with Fetch API and Promises", "Implement modern JavaScript patterns", "Debug and optimize JavaScript code"]',
    'published',
    3,
    NOW()
);
SET @module4_id = LAST_INSERT_ID();

-- MODULE 5: React Fundamentals
INSERT INTO modules (uuid, course_id, title, description, objectives, status, order_index, created_at) VALUES (
    UUID(),
    @course_id,
    'React Fundamentals',
    'Learn React.js to build dynamic user interfaces. Master components, props, state, and hooks.',
    '["Understand React core concepts", "Create functional components", "Manage state with hooks", "Handle props and component composition", "Build interactive UIs"]',
    'published',
    4,
    NOW()
);
SET @module5_id = LAST_INSERT_ID();

-- MODULE 6: React Advanced Concepts
INSERT INTO modules (uuid, course_id, title, description, objectives, status, order_index, created_at) VALUES (
    UUID(),
    @course_id,
    'React Advanced Concepts',
    'Master advanced React patterns, routing, state management, and performance optimization.',
    '["Implement React Router for navigation", "Manage global state effectively", "Optimize React performance", "Use Context API and custom hooks", "Test React components"]',
    'published',
    5,
    NOW()
);
SET @module6_id = LAST_INSERT_ID();

-- MODULE 7: Version Control with Git
INSERT INTO modules (uuid, course_id, title, description, objectives, status, order_index, created_at) VALUES (
    UUID(),
    @course_id,
    'Version Control with Git',
    'Master Git for version control. Learn branching, merging, and collaboration workflows.',
    '["Understand version control concepts", "Use Git commands effectively", "Manage branches and merges", "Collaborate with GitHub", "Follow Git best practices"]',
    'published',
    6,
    NOW()
);
SET @module7_id = LAST_INSERT_ID();

-- MODULE 8: Final Capstone Project
INSERT INTO modules (uuid, course_id, title, description, objectives, status, order_index, created_at) VALUES (
    UUID(),
    @course_id,
    'Final Capstone Project',
    'Build a complete full-stack web application from scratch. Showcase all the skills you\'ve learned.',
    '["Plan and design a web application", "Implement frontend with React", "Deploy to production", "Present and document your project", "Build your developer portfolio"]',
    'published',
    7,
    NOW()
);
SET @module8_id = LAST_INSERT_ID();

-- ===================================
-- LESSONS FOR MODULE 1: HTML5 Fundamentals
-- ===================================

INSERT INTO lessons (uuid, module_id, title, content, type, duration_minutes, resources, order_index, ai_generated, created_at) VALUES
(UUID(), @module1_id, 'Introduction to HTML', 
'# Introduction to HTML

HTML (HyperText Markup Language) is the standard markup language for creating web pages. It provides the structure and content of websites.

## What is HTML?

HTML uses **tags** to mark up different parts of a webpage. Tags are enclosed in angle brackets like `<tagname>`.

## Basic HTML Structure

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My First Webpage</title>
</head>
<body>
    <h1>Hello, World!</h1>
    <p>This is my first webpage.</p>
</body>
</html>
```

## Key Components:
- **DOCTYPE**: Declares the HTML version
- **html**: Root element
- **head**: Contains metadata
- **body**: Contains visible content

## Common HTML Tags:
- `<h1>` to `<h6>`: Headings
- `<p>`: Paragraphs
- `<a>`: Links
- `<img>`: Images
- `<div>`: Containers
- `<span>`: Inline containers',
'text', 30, 
'[{"title":"MDN HTML Guide","url":"https://developer.mozilla.org/en-US/docs/Web/HTML","type":"article"},{"title":"HTML Tutorial - W3Schools","url":"https://www.w3schools.com/html/","type":"tutorial"}]',
0, false, NOW()),

(UUID(), @module1_id, 'HTML Document Structure', 
'# HTML Document Structure

Understanding the structure of an HTML document is crucial for building valid, accessible webpages.

## The Head Section

The `<head>` contains metadata about the document:

```html
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Page description">
    <title>Page Title</title>
    <link rel="stylesheet" href="styles.css">
    <script src="script.js" defer></script>
</head>
```

### Important Meta Tags:
- **charset**: Character encoding
- **viewport**: Responsive design settings
- **description**: SEO description

## The Body Section

The `<body>` contains all visible content.

## Semantic HTML5 Elements

```html
<header>
    <nav>Navigation menu</nav>
</header>

<main>
    <article>
        <h1>Article Title</h1>
        <section>Content section</section>
    </article>
</main>

<aside>Sidebar content</aside>

<footer>Footer content</footer>
```

## Benefits of Semantic HTML:
✅ Better accessibility
✅ Improved SEO
✅ Easier maintenance
✅ Clearer structure',
'text', 45,
'[{"title":"HTML Semantic Elements","url":"https://www.w3schools.com/html/html5_semantic_elements.asp","type":"tutorial"}]',
1, false, NOW()),

(UUID(), @module1_id, 'HTML Forms and Input', 
'# HTML Forms and Input

Forms allow users to interact with your website by submitting data.

## Basic Form Structure

```html
<form action="/submit" method="POST">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" required>
    
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>
    
    <button type="submit">Submit</button>
</form>
```

## Input Types

HTML5 provides many input types:

```html
<input type="text">        <!-- Text input -->
<input type="email">       <!-- Email validation -->
<input type="password">    <!-- Hidden password -->
<input type="number">      <!-- Numeric input -->
<input type="date">        <!-- Date picker -->
<input type="checkbox">    <!-- Checkbox -->
<input type="radio">       <!-- Radio button -->
<input type="file">        <!-- File upload -->
```

## Form Validation

Use HTML5 validation attributes:

```html
<input type="text" required minlength="3" maxlength="50">
<input type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\\.[a-z]{2,}$">
<input type="number" min="0" max="100">
```

## Textarea and Select

```html
<textarea rows="4" cols="50">Default text</textarea>

<select name="country">
    <option value="ng">Nigeria</option>
    <option value="us">United States</option>
    <option value="uk">United Kingdom</option>
</select>
```',
'text', 40,
'[{"title":"HTML Forms Guide","url":"https://developer.mozilla.org/en-US/docs/Learn/Forms","type":"article"}]',
2, false, NOW()),

(UUID(), @module1_id, 'Practice: Build a Contact Form', 
'# Practice Exercise: Build a Contact Form

Create a fully functional contact form with validation.

## Requirements:
1. Form should include:
   - Name field (required, min 3 characters)
   - Email field (required, valid email)
   - Phone number (optional)
   - Subject dropdown (Support, Sales, General)
   - Message textarea (required, min 10 characters)
   - Submit button

2. Use proper labels and semantic HTML
3. Add placeholder text
4. Implement HTML5 validation
5. Style the form to be user-friendly

## Starter Code:

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Form</title>
</head>
<body>
    <h1>Contact Us</h1>
    <!-- Your form goes here -->
</body>
</html>
```

## Expected Output:
A clean, accessible contact form that validates user input before submission.

## Bonus Challenges:
- Add a "Terms & Conditions" checkbox
- Create a custom success message
- Make it responsive',
'code', 60,
'[{"title":"Form Best Practices","url":"https://www.smashingmagazine.com/2018/08/best-practices-for-mobile-form-design/","type":"article"}]',
3, false, NOW());

-- Create assignment for Module 1
INSERT INTO assignments (uuid, lesson_id, title, description, instructions, rubric, max_score, due_date, created_at) VALUES
(UUID(),
(SELECT id FROM lessons WHERE module_id = @module1_id AND title = 'Practice: Build a Contact Form' LIMIT 1),
'HTML Contact Form Project',
'Build a professional contact form using semantic HTML5 and form validation.',
'Create a contact form that includes all required fields, proper validation, and accessible markup. Test your form to ensure all validation works correctly.',
'[{"criteria":"HTML Structure","description":"Proper semantic HTML5 markup","max_points":20},{"criteria":"Form Elements","description":"All required fields included","max_points":25},{"criteria":"Validation","description":"Correct HTML5 validation attributes","max_points":25},{"criteria":"Accessibility","description":"Proper labels and ARIA attributes","max_points":20},{"criteria":"Code Quality","description":"Clean, well-formatted code","max_points":10}]',
100,
DATE_ADD(NOW(), INTERVAL 7 DAY),
NOW());

-- ===================================
-- LESSONS FOR MODULE 2: CSS3 & Responsive Design
-- ===================================

INSERT INTO lessons (uuid, module_id, title, content, type, duration_minutes, resources, order_index, ai_generated, created_at) VALUES
(UUID(), @module2_id, 'CSS Basics and Selectors',
'# CSS Basics and Selectors

CSS (Cascading Style Sheets) is used to style and layout web pages.

## Three Ways to Add CSS

### 1. Inline CSS
```html
<p style="color: blue;">Blue text</p>
```

### 2. Internal CSS
```html
<style>
    p { color: blue; }
</style>
```

### 3. External CSS (Recommended)
```html
<link rel="stylesheet" href="styles.css">
```

## CSS Selectors

```css
/* Element selector */
p {
    color: black;
}

/* Class selector */
.highlight {
    background-color: yellow;
}

/* ID selector */
#header {
    font-size: 24px;
}

/* Attribute selector */
input[type="text"] {
    border: 1px solid gray;
}

/* Pseudo-class */
a:hover {
    color: red;
}
```

## CSS Specificity

Specificity determines which styles are applied:
1. Inline styles (highest)
2. IDs
3. Classes, attributes, pseudo-classes
4. Elements (lowest)

## Common CSS Properties

```css
.box {
    /* Colors */
    color: #333;
    background-color: #f0f0f0;
    
    /* Typography */
    font-size: 16px;
    font-weight: bold;
    text-align: center;
    
    /* Box Model */
    padding: 20px;
    margin: 10px;
    border: 1px solid #ddd;
    
    /* Dimensions */
    width: 300px;
    height: 200px;
}
```',
'text', 45,
'[{"title":"CSS Selectors Reference","url":"https://developer.mozilla.org/en-US/docs/Web/CSS/CSS_Selectors","type":"article"}]',
0, false, NOW()),

(UUID(), @module2_id, 'Flexbox Layout',
'# Flexbox Layout

Flexbox is a powerful CSS layout system for creating flexible, responsive layouts.

## Container Properties

```css
.container {
    display: flex;
    
    /* Direction */
    flex-direction: row; /* row, column, row-reverse, column-reverse */
    
    /* Wrapping */
    flex-wrap: wrap; /* nowrap, wrap, wrap-reverse */
    
    /* Justify (main axis) */
    justify-content: center; /* flex-start, flex-end, center, space-between, space-around */
    
    /* Align (cross axis) */
    align-items: center; /* flex-start, flex-end, center, stretch, baseline */
    
    /* Gap */
    gap: 20px;
}
```

## Item Properties

```css
.item {
    /* Flexibility */
    flex: 1; /* flex-grow flex-shrink flex-basis */
    
    /* Individual alignment */
    align-self: center;
    
    /* Order */
    order: 2;
}
```

## Practical Example: Navigation Bar

```css
.navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem;
    background-color: #333;
}

.nav-links {
    display: flex;
    gap: 2rem;
    list-style: none;
}
```

## Common Flexbox Patterns

### Centered Content
```css
.center {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
}
```

### Equal Columns
```css
.columns {
    display: flex;
    gap: 20px;
}

.column {
    flex: 1;
}
```',
'text', 50,
'[{"title":"A Complete Guide to Flexbox","url":"https://css-tricks.com/snippets/css/a-guide-to-flexbox/","type":"article"}]',
1, false, NOW()),

(UUID(), @module2_id, 'CSS Grid Layout',
'# CSS Grid Layout

CSS Grid is a two-dimensional layout system perfect for complex layouts.

## Basic Grid Setup

```css
.grid-container {
    display: grid;
    
    /* Define columns */
    grid-template-columns: 200px 1fr 1fr; /* 3 columns */
    
    /* Define rows */
    grid-template-rows: auto 1fr auto; /* 3 rows */
    
    /* Gap between items */
    gap: 20px;
}
```

## Grid Template Areas

```css
.layout {
    display: grid;
    grid-template-areas:
        "header header header"
        "sidebar main main"
        "footer footer footer";
    grid-template-columns: 200px 1fr 1fr;
    gap: 10px;
}

.header { grid-area: header; }
.sidebar { grid-area: sidebar; }
.main { grid-area: main; }
.footer { grid-area: footer; }
```

## Responsive Grid

```css
.responsive-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
}
```

## Grid Item Placement

```css
.item {
    /* Start at column 1, span 2 columns */
    grid-column: 1 / 3;
    
    /* Start at row 2, span 1 row */
    grid-row: 2 / 3;
}
```

## Practical Example: Photo Gallery

```css
.gallery {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 15px;
    padding: 20px;
}

.gallery img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 8px;
}
```',
'text', 50,
'[{"title":"A Complete Guide to Grid","url":"https://css-tricks.com/snippets/css/complete-guide-grid/","type":"article"}]',
2, false, NOW()),

(UUID(), @module2_id, 'Responsive Design with Media Queries',
'# Responsive Design with Media Queries

Make your websites look great on all devices with responsive design techniques.

## Mobile-First Approach

Start with mobile styles, then add styles for larger screens:

```css
/* Mobile styles (default) */
.container {
    padding: 10px;
}

/* Tablet styles */
@media (min-width: 768px) {
    .container {
        padding: 20px;
    }
}

/* Desktop styles */
@media (min-width: 1024px) {
    .container {
        padding: 40px;
        max-width: 1200px;
        margin: 0 auto;
    }
}
```

## Common Breakpoints

```css
/* Extra small devices (phones) */
@media (max-width: 575px) { }

/* Small devices (tablets) */
@media (min-width: 576px) and (max-width: 767px) { }

/* Medium devices (tablets/small laptops) */
@media (min-width: 768px) and (max-width: 991px) { }

/* Large devices (desktops) */
@media (min-width: 992px) and (max-width: 1199px) { }

/* Extra large devices (large desktops) */
@media (min-width: 1200px) { }
```

## Responsive Typography

```css
:root {
    font-size: 14px;
}

@media (min-width: 768px) {
    :root {
        font-size: 16px;
    }
}

h1 {
    font-size: 2rem; /* Scales with root font size */
}
```

## Responsive Images

```css
img {
    max-width: 100%;
    height: auto;
}

/* Art direction */
picture {
    display: block;
}
```

## Flexbox Responsive Pattern

```css
.flex-container {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
}

.flex-item {
    flex: 1 1 300px; /* Grow, shrink, basis */
    min-width: 0;
}
```

## Grid Responsive Pattern

```css
.grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
}
```',
'text', 45,
'[{"title":"Responsive Web Design Basics","url":"https://web.dev/responsive-web-design-basics/","type":"article"}]',
3, false, NOW()),

(UUID(), @module2_id, 'Project: Build a Responsive Portfolio Page',
'# Project: Responsive Portfolio Page

Create a personal portfolio website that looks great on all devices.

## Requirements

### Layout:
1. **Header** with navigation
   - Logo/name
   - Navigation menu (Home, About, Projects, Contact)
   - Hamburger menu for mobile

2. **Hero Section**
   - Large heading with your name
   - Brief introduction
   - Call-to-action button

3. **About Section**
   - Profile picture
   - Bio paragraph
   - Skills list

4. **Projects Section**
   - Grid/card layout
   - At least 3 project cards
   - Each card has image, title, description

5. **Contact Section**
   - Contact form
   - Social media links

6. **Footer**
   - Copyright info
   - Additional links

### Technical Requirements:
- Use Flexbox OR Grid (or both)
- Mobile-first approach
- At least 2 media query breakpoints
- Smooth transitions and hover effects
- Valid HTML5 and CSS3
- Responsive images

## Design Tips:
- Use a consistent color scheme (2-3 colors)
- Choose readable fonts (Google Fonts)
- Adequate spacing and whitespace
- Clear visual hierarchy

## Bonus Features:
- Dark mode toggle
- Animated scrolling
- Image lightbox
- Loading animations',
'project', 180,
'[{"title":"Portfolio Inspiration","url":"https://www.awwwards.com/websites/portfolio/","type":"inspiration"},{"title":"Color Palette Generator","url":"https://coolors.co/","type":"tool"}]',
4, false, NOW());

-- Create assignment for Module 2
INSERT INTO assignments (uuid, lesson_id, title, description, instructions, rubric, max_score, due_date, created_at) VALUES
(UUID(),
(SELECT id FROM lessons WHERE module_id = @module2_id AND title = 'Project: Build a Responsive Portfolio Page' LIMIT 1),
'Responsive Portfolio Website',
'Design and build a fully responsive personal portfolio website showcasing your skills.',
'Create a multi-section portfolio website with responsive design. Ensure it works perfectly on mobile, tablet, and desktop screens. Use modern CSS techniques including Flexbox or Grid.',
'[{"criteria":"Responsive Design","description":"Works perfectly on all screen sizes","max_points":25},{"criteria":"Layout & Structure","description":"Proper use of Flexbox/Grid","max_points":20},{"criteria":"Design Quality","description":"Professional appearance and UX","max_points":20},{"criteria":"Code Quality","description":"Clean, organized CSS","max_points":15},{"criteria":"Content Completeness","description":"All required sections included","max_points":15},{"criteria":"Bonus Features","description":"Additional creative features","max_points":5}]',
100,
DATE_ADD(NOW(), INTERVAL 14 DAY),
NOW());

-- Continue with MODULE 3 lessons (JavaScript Basics) - abbreviated for space
INSERT INTO lessons (uuid, module_id, title, content, type, duration_minutes, resources, order_index, ai_generated, created_at) VALUES
(UUID(), @module3_id, 'JavaScript Introduction & Variables',
'# JavaScript Introduction

JavaScript is a programming language that makes websites interactive.

## Adding JavaScript to HTML

```html
<!-- Internal JavaScript -->
<script>
    console.log("Hello, JavaScript!");
</script>

<!-- External JavaScript -->
<script src="script.js"></script>
```

## Variables

```javascript
// var (old way - avoid)
var name = "John";

// let (can be reassigned)
let age = 25;
age = 26; // OK

// const (cannot be reassigned)
const PI = 3.14159;
// PI = 3.14; // Error!
```

## Data Types

```javascript
// String
let name = "Alice";
let message = ''Hello, World!'';

// Number
let age = 30;
let price = 19.99;

// Boolean
let isActive = true;
let hasPermission = false;

// Null
let emptyValue = null;

// Undefined
let notAssigned;
console.log(notAssigned); // undefined

// Array
let colors = ["red", "green", "blue"];

// Object
let person = {
    name: "John",
    age: 30,
    email: "john@example.com"
};
```

## Type Checking

```javascript
typeof "Hello" // "string"
typeof 42      // "number"
typeof true    // "boolean"
typeof []      // "object"
typeof {}      // "object"
```',
'text', 40,
'[{"title":"JavaScript Basics","url":"https://developer.mozilla.org/en-US/docs/Learn/Getting_started_with_the_web/JavaScript_basics","type":"article"}]',
0, false, NOW()),

(UUID(), @module3_id, 'Functions and Control Flow',
'# Functions and Control Flow

## Functions

```javascript
// Function declaration
function greet(name) {
    return `Hello, ${name}!`;
}

// Function expression
const add = function(a, b) {
    return a + b;
};

// Arrow function (ES6)
const multiply = (a, b) => a * b;

// Calling functions
console.log(greet("Alice"));
console.log(add(5, 3));
console.log(multiply(4, 6));
```

## Conditional Statements

```javascript
// if-else
let age = 18;
if (age >= 18) {
    console.log("Adult");
} else if (age >= 13) {
    console.log("Teenager");
} else {
    console.log("Child");
}

// Ternary operator
let status = age >= 18 ? "Adult" : "Minor";

// Switch statement
let day = "Monday";
switch(day) {
    case "Monday":
        console.log("Start of week");
        break;
    case "Friday":
        console.log("Almost weekend!");
        break;
    default:
        console.log("Regular day");
}
```

## Loops

```javascript
// for loop
for (let i = 0; i < 5; i++) {
    console.log(i);
}

// while loop
let count = 0;
while (count < 5) {
    console.log(count);
    count++;
}

// for...of (arrays)
let fruits = ["apple", "banana", "orange"];
for (let fruit of fruits) {
    console.log(fruit);
}

// forEach
fruits.forEach(fruit => {
    console.log(fruit);
});
```',
'text', 45,
'[{"title":"JavaScript Functions","url":"https://developer.mozilla.org/en-US/docs/Web/JavaScript/Guide/Functions","type":"article"}]',
1, false, NOW()),

(UUID(), @module3_id, 'DOM Manipulation',
'# DOM Manipulation

The Document Object Model (DOM) represents your HTML as a tree structure that JavaScript can interact with.

## Selecting Elements

```javascript
// By ID
let element = document.getElementById("myId");

// By class
let elements = document.getElementsByClassName("myClass");

// By tag name
let paragraphs = document.getElementsByTagName("p");

// Query selector (CSS selectors)
let first = document.querySelector(".myClass");
let all = document.querySelectorAll(".myClass");
```

## Modifying Content

```javascript
// Text content
element.textContent = "New text";

// HTML content
element.innerHTML = "<strong>Bold text</strong>";

// Attributes
element.setAttribute("class", "active");
element.getAttribute("id");
element.removeAttribute("disabled");
```

## Styling Elements

```javascript
element.style.color = "blue";
element.style.backgroundColor = "#f0f0f0";
element.style.fontSize = "18px";

// Add/remove classes
element.classList.add("active");
element.classList.remove("hidden");
element.classList.toggle("visible");
```

## Creating and Removing Elements

```javascript
// Create new element
let newDiv = document.createElement("div");
newDiv.textContent = "New content";
newDiv.classList.add("box");

// Append to parent
document.body.appendChild(newDiv);

// Remove element
element.remove();
```

## Event Handling

```javascript
// Click event
button.addEventListener("click", function() {
    alert("Button clicked!");
});

// Input event
input.addEventListener("input", (e) => {
    console.log(e.target.value);
});

// Form submit
form.addEventListener("submit", (e) => {
    e.preventDefault(); // Prevent page reload
    // Handle form data
});
```',
'text', 50,
'[{"title":"DOM Manipulation Guide","url":"https://developer.mozilla.org/en-US/docs/Learn/JavaScript/Client-side_web_APIs/Manipulating_documents","type":"article"}]',
2, false, NOW()),

(UUID(), @module3_id, 'Interactive Calculator Project',
'# Project: Build an Interactive Calculator

Create a functional calculator using HTML, CSS, and JavaScript.

## Requirements

### HTML Structure:
- Display screen for numbers
- Number buttons (0-9)
- Operator buttons (+, -, ×, ÷)
- Equals button
- Clear button
- Decimal point button

### Functionality:
1. Click numbers to build operand
2. Click operator to set operation
3. Click equals to calculate result
4. Clear button resets calculator
5. Handle decimal numbers
6. Prevent invalid operations
7. Display shows current input/result

### Technical Requirements:
```javascript
// Calculator state
let currentOperand = "";
let previousOperand = "";
let operation = null;

// Functions needed:
- clear()
- appendNumber(number)
- chooseOperation(op)
- compute()
- updateDisplay()
```

### CSS Styling:
- Grid layout for buttons
- Hover effects
- Active states
- Responsive design

## Bonus Features:
- Keyboard support
- Operation history
- Scientific functions
- Memory functions (M+, M-, MR, MC)
- Percentage calculation',
'code', 120,
'[{"title":"Calculator Tutorial","url":"https://www.youtube.com/watch?v=j59qQ7YWLxw","type":"video"}]',
3, false, NOW());

-- Create assignment for Module 3
INSERT INTO assignments (uuid, lesson_id, title, description, instructions, rubric, max_score, due_date, created_at) VALUES
(UUID(),
(SELECT id FROM lessons WHERE module_id = @module3_id AND title = 'Interactive Calculator Project' LIMIT 1),
'JavaScript Calculator Application',
'Build a fully functional calculator using JavaScript DOM manipulation.',
'Create an interactive calculator that handles basic arithmetic operations. Use event listeners for button clicks and update the display dynamically.',
'[{"criteria":"Functionality","description":"All basic operations work correctly","max_points":30},{"criteria":"DOM Manipulation","description":"Proper use of JavaScript DOM methods","max_points":25},{"criteria":"Code Organization","description":"Clean, well-structured code","max_points":20},{"criteria":"UI/UX","description":"User-friendly interface","max_points":15},{"criteria":"Error Handling","description":"Handles edge cases properly","max_points":10}]',
100,
DATE_ADD(NOW(), INTERVAL 10 DAY),
NOW());

-- MODULE 4: A few key lessons (abbreviated)
INSERT INTO lessons (uuid, module_id, title, content, type, duration_minutes, resources, order_index, ai_generated, created_at) VALUES
(UUID(), @module4_id, 'ES6+ Features',
'# Modern JavaScript (ES6+)

## Arrow Functions
```javascript
const add = (a, b) => a + b;
```

## Template Literals
```javascript
const name = "Alice";
console.log(`Hello, ${name}!`);
```

## Destructuring
```javascript
const [a, b] = [1, 2];
const {name, age} = person;
```

## Spread Operator
```javascript
const arr1 = [1, 2];
const arr2 = [...arr1, 3, 4];
```

## Async/Await
```javascript
async function fetchData() {
    const response = await fetch(url);
    const data = await response.json();
    return data;
}
```',
'text', 50,
'[]',
0, false, NOW()),

(UUID(), @module4_id, 'Fetch API and Promises',
'# Working with APIs

## Fetch API
```javascript
fetch("https://api.example.com/data")
    .then(response => response.json())
    .then(data => console.log(data))
    .catch(error => console.error(error));
```

## Async/Await Pattern
```javascript
async function getData() {
    try {
        const response = await fetch(url);
        const data = await response.json();
        console.log(data);
    } catch (error) {
        console.error("Error:", error);
    }
}
```',
'text', 45,
'[]',
1, false, NOW());

-- Success message
SELECT 'Frontend Development Course created successfully!' AS message,
       @course_id AS course_id,
       (SELECT COUNT(*) FROM modules WHERE course_id = @course_id) AS modules_count,
       (SELECT COUNT(*) FROM lessons WHERE module_id IN (SELECT id FROM modules WHERE course_id = @course_id)) AS lessons_count,
       (SELECT COUNT(*) FROM assignments WHERE lesson_id IN (SELECT id FROM lessons WHERE module_id IN (SELECT id FROM modules WHERE course_id = @course_id))) AS assignments_count;
