<?php
/**
 * Complete Curriculum Setup Script
 * Creates the correct number of modules based on card_modules field
 * with varying complexity based on course level
 */

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

$pdo = new PDO(
    "mysql:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_NAME']}",
    $_ENV['DB_USER'],
    $_ENV['DB_PASSWORD'] ?? ''
);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

echo "<h1>Complete Curriculum Setup</h1>";

// First, clear ALL existing modules and lessons for courses 1-15
echo "<p><em>Cleaning up existing modules and lessons...</em></p>";
$pdo->exec("DELETE FROM lessons WHERE module_id IN (SELECT id FROM modules WHERE course_id <= 15)");
$pdo->exec("DELETE FROM modules WHERE course_id <= 15");

// Course curriculum definitions - each course has its expected modules
$curriculums = [
    // Course 1: Frontend Development - 15 modules
    1 => [
        'title' => 'Frontend Development',
        'modules' => [
            ['title' => 'Introduction to Web Development', 'lessons' => ['What is Web Development?', 'How the Internet Works', 'Web Browsers and Rendering', 'Developer Tools Overview']],
            ['title' => 'HTML Fundamentals', 'lessons' => ['HTML Document Structure', 'Text Elements and Formatting', 'Links and Navigation', 'Images and Multimedia']],
            ['title' => 'HTML Forms and Tables', 'lessons' => ['Form Elements', 'Input Types and Validation', 'Tables and Data Display', 'Semantic HTML5']],
            ['title' => 'CSS Basics', 'lessons' => ['CSS Syntax and Selectors', 'Colors and Typography', 'Box Model', 'Units and Values']],
            ['title' => 'CSS Layout', 'lessons' => ['Display Property', 'Positioning', 'Float and Clear', 'Overflow and Visibility']],
            ['title' => 'Flexbox', 'lessons' => ['Flex Container Properties', 'Flex Item Properties', 'Flexbox Patterns', 'Real-world Flexbox Layouts']],
            ['title' => 'CSS Grid', 'lessons' => ['Grid Container Basics', 'Grid Lines and Areas', 'Grid Template Areas', 'Responsive Grid Layouts']],
            ['title' => 'Responsive Design', 'lessons' => ['Mobile-First Approach', 'Media Queries', 'Responsive Images', 'Viewport and Breakpoints']],
            ['title' => 'CSS Advanced Topics', 'lessons' => ['CSS Variables', 'Transitions', 'Animations', 'Transforms']],
            ['title' => 'JavaScript Fundamentals', 'lessons' => ['Variables and Data Types', 'Operators and Expressions', 'Control Flow', 'Functions']],
            ['title' => 'JavaScript DOM Manipulation', 'lessons' => ['Selecting Elements', 'Modifying Content', 'Event Handling', 'DOM Traversal']],
            ['title' => 'JavaScript Advanced Concepts', 'lessons' => ['Arrays and Objects', 'ES6+ Features', 'Async JavaScript', 'Error Handling']],
            ['title' => 'Frontend Frameworks Introduction', 'lessons' => ['Why Use Frameworks?', 'React Overview', 'Vue Overview', 'Choosing a Framework']],
            ['title' => 'Build Tools and Workflow', 'lessons' => ['Package Managers (npm/yarn)', 'Module Bundlers', 'Task Runners', 'Development Servers']],
            ['title' => 'Frontend Best Practices', 'lessons' => ['Code Organization', 'Performance Optimization', 'Accessibility (a11y)', 'SEO Basics for Frontend']]
        ]
    ],
    
    // Course 2: Backend Development - 18 modules
    2 => [
        'title' => 'Backend Development',
        'modules' => [
            ['title' => 'Introduction to Backend Development', 'lessons' => ['What is Backend Development?', 'Server Architecture Basics', 'Client-Server Model', 'HTTP Protocol']],
            ['title' => 'Backend Languages Overview', 'lessons' => ['PHP Introduction', 'Python for Backend', 'Node.js Overview', 'Choosing Your Stack']],
            ['title' => 'PHP Fundamentals', 'lessons' => ['PHP Syntax and Variables', 'Data Types', 'Operators', 'Control Structures']],
            ['title' => 'PHP Functions and Arrays', 'lessons' => ['Defining Functions', 'Parameters and Return Values', 'Array Operations', 'Array Functions']],
            ['title' => 'Object-Oriented PHP', 'lessons' => ['Classes and Objects', 'Properties and Methods', 'Inheritance', 'Interfaces and Traits']],
            ['title' => 'PHP and MySQL Basics', 'lessons' => ['Database Connection', 'PDO Introduction', 'Basic Queries', 'Prepared Statements']],
            ['title' => 'CRUD Operations', 'lessons' => ['Create Operations', 'Read Operations', 'Update Operations', 'Delete Operations']],
            ['title' => 'Database Security', 'lessons' => ['SQL Injection Prevention', 'Input Validation', 'Data Sanitization', 'Secure Password Handling']],
            ['title' => 'Session and Cookie Management', 'lessons' => ['Session Basics', 'Cookie Handling', 'Session Security', 'Remember Me Functionality']],
            ['title' => 'Authentication Systems', 'lessons' => ['User Registration', 'Login Systems', 'Password Reset', 'OAuth Basics']],
            ['title' => 'File Handling', 'lessons' => ['File Upload', 'File Validation', 'Image Processing', 'File Storage Strategies']],
            ['title' => 'REST API Fundamentals', 'lessons' => ['What is REST?', 'HTTP Methods', 'API Endpoints Design', 'Status Codes']],
            ['title' => 'Building APIs with PHP', 'lessons' => ['API Structure', 'JSON Response', 'Request Handling', 'API Versioning']],
            ['title' => 'API Authentication', 'lessons' => ['Token-Based Auth', 'JWT Implementation', 'API Keys', 'Rate Limiting']],
            ['title' => 'Error Handling and Logging', 'lessons' => ['Exception Handling', 'Custom Exceptions', 'Logging Strategies', 'Error Reporting']],
            ['title' => 'Testing Backend Code', 'lessons' => ['Unit Testing Basics', 'PHPUnit Introduction', 'Test-Driven Development', 'Integration Testing']],
            ['title' => 'Performance Optimization', 'lessons' => ['Caching Strategies', 'Query Optimization', 'Code Profiling', 'Memory Management']],
            ['title' => 'Deployment and DevOps', 'lessons' => ['Server Setup', 'Deployment Strategies', 'CI/CD Basics', 'Monitoring and Maintenance']]
        ]
    ],
    
    // Course 3: Full Stack Development - 25 modules
    3 => [
        'title' => 'Full Stack Development',
        'modules' => [
            ['title' => 'Full Stack Overview', 'lessons' => ['What is Full Stack?', 'The Modern Web Stack', 'Career Paths', 'Learning Roadmap']],
            ['title' => 'Development Environment', 'lessons' => ['IDE Setup', 'Version Control Basics', 'Terminal Commands', 'Docker Introduction']],
            ['title' => 'HTML5 Deep Dive', 'lessons' => ['Semantic Elements', 'Web APIs', 'Canvas and SVG', 'Web Components']],
            ['title' => 'Advanced CSS', 'lessons' => ['CSS Architecture', 'Preprocessors (SASS)', 'CSS-in-JS', 'Design Systems']],
            ['title' => 'JavaScript Mastery', 'lessons' => ['Advanced Functions', 'Closures and Scope', 'Prototypes', 'Design Patterns']],
            ['title' => 'TypeScript Fundamentals', 'lessons' => ['TypeScript Setup', 'Types and Interfaces', 'Generics', 'TypeScript with React']],
            ['title' => 'React.js Essentials', 'lessons' => ['React Setup', 'Components and JSX', 'Props and State', 'Lifecycle Methods']],
            ['title' => 'React Hooks', 'lessons' => ['useState and useEffect', 'Custom Hooks', 'useContext', 'useReducer']],
            ['title' => 'State Management', 'lessons' => ['Context API', 'Redux Basics', 'Redux Toolkit', 'Zustand and Alternatives']],
            ['title' => 'React Router', 'lessons' => ['Routing Basics', 'Dynamic Routes', 'Protected Routes', 'Navigation Patterns']],
            ['title' => 'Frontend Testing', 'lessons' => ['Jest Basics', 'React Testing Library', 'Component Testing', 'E2E with Cypress']],
            ['title' => 'Node.js Fundamentals', 'lessons' => ['Node.js Basics', 'Modules and npm', 'File System', 'Event Loop']],
            ['title' => 'Express.js Framework', 'lessons' => ['Express Setup', 'Routing', 'Middleware', 'Error Handling']],
            ['title' => 'MongoDB Basics', 'lessons' => ['NoSQL Concepts', 'MongoDB Setup', 'CRUD Operations', 'Mongoose ODM']],
            ['title' => 'MongoDB Advanced', 'lessons' => ['Aggregation Pipeline', 'Indexing', 'Data Modeling', 'Relationships']],
            ['title' => 'REST API with Node', 'lessons' => ['API Design', 'CRUD Endpoints', 'Validation', 'Documentation']],
            ['title' => 'Authentication and Authorization', 'lessons' => ['JWT Authentication', 'Passport.js', 'Role-Based Access', 'OAuth Integration']],
            ['title' => 'Real-time Features', 'lessons' => ['WebSockets', 'Socket.io', 'Real-time Notifications', 'Chat Implementation']],
            ['title' => 'GraphQL Introduction', 'lessons' => ['GraphQL vs REST', 'Schema Definition', 'Queries and Mutations', 'Apollo Client']],
            ['title' => 'Full Stack Project Planning', 'lessons' => ['Requirements Analysis', 'Architecture Design', 'Database Schema', 'API Planning']],
            ['title' => 'Building the Frontend', 'lessons' => ['Component Architecture', 'State Design', 'API Integration', 'UI/UX Implementation']],
            ['title' => 'Building the Backend', 'lessons' => ['Server Architecture', 'Database Implementation', 'Business Logic', 'API Development']],
            ['title' => 'Testing Full Stack Apps', 'lessons' => ['Testing Strategy', 'Unit Tests', 'Integration Tests', 'E2E Tests']],
            ['title' => 'Deployment Strategies', 'lessons' => ['Frontend Deployment', 'Backend Deployment', 'Database Hosting', 'Domain and SSL']],
            ['title' => 'Production Best Practices', 'lessons' => ['Security Hardening', 'Performance Optimization', 'Monitoring', 'Scaling Strategies']]
        ]
    ],
    
    // Course 4: Database Design & Administration - 12 modules
    4 => [
        'title' => 'Database Design & Administration',
        'modules' => [
            ['title' => 'Database Fundamentals', 'lessons' => ['What are Databases?', 'RDBMS vs NoSQL', 'Database History', 'Use Cases']],
            ['title' => 'Data Modeling Concepts', 'lessons' => ['Entities and Attributes', 'Relationships', 'ER Diagrams', 'Cardinality']],
            ['title' => 'SQL Basics', 'lessons' => ['SQL Introduction', 'SELECT Statements', 'WHERE Clauses', 'Sorting and Filtering']],
            ['title' => 'SQL Joins and Subqueries', 'lessons' => ['INNER JOIN', 'LEFT/RIGHT JOIN', 'Subqueries', 'Complex Queries']],
            ['title' => 'Advanced SQL', 'lessons' => ['Aggregate Functions', 'GROUP BY and HAVING', 'Window Functions', 'CTEs']],
            ['title' => 'Database Design', 'lessons' => ['Normalization Forms', '1NF to 3NF', 'Denormalization', 'Schema Design Patterns']],
            ['title' => 'Stored Procedures and Functions', 'lessons' => ['Creating Procedures', 'Parameters', 'Functions', 'Triggers']],
            ['title' => 'Indexing and Optimization', 'lessons' => ['Index Types', 'Creating Indexes', 'Query Plans', 'Performance Tuning']],
            ['title' => 'Transactions and Concurrency', 'lessons' => ['ACID Properties', 'Transaction Management', 'Locking', 'Deadlocks']],
            ['title' => 'Database Security', 'lessons' => ['User Management', 'Privileges', 'Encryption', 'Audit Logging']],
            ['title' => 'Backup and Recovery', 'lessons' => ['Backup Strategies', 'Point-in-Time Recovery', 'Disaster Recovery', 'High Availability']],
            ['title' => 'Database Administration', 'lessons' => ['Monitoring', 'Maintenance Tasks', 'Capacity Planning', 'Migration Strategies']]
        ]
    ],
    
    // Course 5: AI & Machine Learning - 30 modules
    5 => [
        'title' => 'AI & Machine Learning',
        'modules' => [
            ['title' => 'Introduction to AI', 'lessons' => ['What is AI?', 'History of AI', 'Types of AI', 'AI Applications']],
            ['title' => 'AI Ethics and Considerations', 'lessons' => ['Ethical AI', 'Bias in AI', 'Privacy Concerns', 'Responsible AI']],
            ['title' => 'Python for AI', 'lessons' => ['Python Setup', 'Python Basics Review', 'Data Structures', 'Control Flow']],
            ['title' => 'NumPy Fundamentals', 'lessons' => ['NumPy Arrays', 'Array Operations', 'Broadcasting', 'Linear Algebra']],
            ['title' => 'Pandas for Data Analysis', 'lessons' => ['DataFrames', 'Data Manipulation', 'Data Cleaning', 'GroupBy Operations']],
            ['title' => 'Data Visualization', 'lessons' => ['Matplotlib Basics', 'Seaborn', 'Plotly', 'Visualization Best Practices']],
            ['title' => 'Statistics for ML', 'lessons' => ['Descriptive Statistics', 'Probability', 'Distributions', 'Hypothesis Testing']],
            ['title' => 'Machine Learning Fundamentals', 'lessons' => ['What is ML?', 'Types of Learning', 'ML Workflow', 'Feature Engineering']],
            ['title' => 'Supervised Learning: Regression', 'lessons' => ['Linear Regression', 'Polynomial Regression', 'Regularization', 'Evaluation Metrics']],
            ['title' => 'Supervised Learning: Classification', 'lessons' => ['Logistic Regression', 'Decision Trees', 'Random Forests', 'SVM']],
            ['title' => 'Model Evaluation', 'lessons' => ['Train/Test Split', 'Cross-Validation', 'Confusion Matrix', 'ROC and AUC']],
            ['title' => 'Unsupervised Learning', 'lessons' => ['Clustering Algorithms', 'K-Means', 'Hierarchical Clustering', 'DBSCAN']],
            ['title' => 'Dimensionality Reduction', 'lessons' => ['PCA', 't-SNE', 'Feature Selection', 'Autoencoders']],
            ['title' => 'Ensemble Methods', 'lessons' => ['Bagging', 'Boosting', 'XGBoost', 'Stacking']],
            ['title' => 'Scikit-learn in Practice', 'lessons' => ['Pipeline Creation', 'Grid Search', 'Model Persistence', 'Best Practices']],
            ['title' => 'Introduction to Neural Networks', 'lessons' => ['Perceptrons', 'Activation Functions', 'Forward Propagation', 'Backpropagation']],
            ['title' => 'Deep Learning Fundamentals', 'lessons' => ['Deep Networks', 'Gradient Descent', 'Optimizers', 'Regularization']],
            ['title' => 'TensorFlow Basics', 'lessons' => ['TensorFlow Setup', 'Tensors', 'Building Models', 'Training Loops']],
            ['title' => 'Keras for Deep Learning', 'lessons' => ['Keras API', 'Sequential Models', 'Functional API', 'Callbacks']],
            ['title' => 'CNNs for Computer Vision', 'lessons' => ['Convolutions', 'Pooling', 'CNN Architectures', 'Image Classification']],
            ['title' => 'Advanced CNN Topics', 'lessons' => ['Transfer Learning', 'Object Detection', 'Image Segmentation', 'Data Augmentation']],
            ['title' => 'Recurrent Neural Networks', 'lessons' => ['RNN Basics', 'LSTM', 'GRU', 'Sequence Modeling']],
            ['title' => 'Natural Language Processing', 'lessons' => ['Text Preprocessing', 'Word Embeddings', 'Text Classification', 'Named Entity Recognition']],
            ['title' => 'Transformers and Attention', 'lessons' => ['Attention Mechanism', 'Transformer Architecture', 'BERT', 'GPT Models']],
            ['title' => 'Generative AI', 'lessons' => ['GANs', 'VAEs', 'Diffusion Models', 'Image Generation']],
            ['title' => 'Reinforcement Learning', 'lessons' => ['RL Basics', 'Q-Learning', 'Policy Gradient', 'Deep RL']],
            ['title' => 'MLOps Introduction', 'lessons' => ['ML Lifecycle', 'Model Versioning', 'Experiment Tracking', 'MLflow']],
            ['title' => 'Model Deployment', 'lessons' => ['Model Serving', 'API Creation', 'Docker for ML', 'Cloud Deployment']],
            ['title' => 'AI Project Management', 'lessons' => ['Project Planning', 'Data Strategy', 'Team Collaboration', 'Documentation']],
            ['title' => 'AI Capstone Project', 'lessons' => ['Project Selection', 'Implementation', 'Evaluation', 'Presentation']]
        ]
    ],
    
    // Course 6: Data Science - 28 modules
    6 => [
        'title' => 'Data Science',
        'modules' => [
            ['title' => 'Data Science Introduction', 'lessons' => ['What is Data Science?', 'Data Science Process', 'Career Paths', 'Tools Overview']],
            ['title' => 'Python Environment Setup', 'lessons' => ['Anaconda Installation', 'Jupyter Notebooks', 'Virtual Environments', 'Package Management']],
            ['title' => 'Python for Data Science', 'lessons' => ['Python Fundamentals', 'Functions', 'Object-Oriented Python', 'File I/O']],
            ['title' => 'NumPy for Data Science', 'lessons' => ['Array Creation', 'Array Operations', 'Mathematical Functions', 'Random Sampling']],
            ['title' => 'Pandas Fundamentals', 'lessons' => ['Series and DataFrames', 'Data Selection', 'Filtering', 'Sorting']],
            ['title' => 'Data Wrangling with Pandas', 'lessons' => ['Handling Missing Data', 'Data Transformation', 'Merging and Joining', 'Reshaping Data']],
            ['title' => 'Exploratory Data Analysis', 'lessons' => ['EDA Process', 'Summary Statistics', 'Distribution Analysis', 'Correlation Analysis']],
            ['title' => 'Data Cleaning', 'lessons' => ['Identifying Issues', 'Handling Outliers', 'Data Validation', 'Quality Assurance']],
            ['title' => 'Data Visualization with Matplotlib', 'lessons' => ['Basic Plots', 'Customization', 'Subplots', 'Saving Figures']],
            ['title' => 'Advanced Visualization with Seaborn', 'lessons' => ['Statistical Plots', 'Categorical Plots', 'Regression Plots', 'Heatmaps']],
            ['title' => 'Interactive Visualizations', 'lessons' => ['Plotly Basics', 'Interactive Charts', 'Dashboards', 'Geographic Plots']],
            ['title' => 'Descriptive Statistics', 'lessons' => ['Measures of Central Tendency', 'Measures of Spread', 'Percentiles', 'Data Summarization']],
            ['title' => 'Probability Theory', 'lessons' => ['Basic Probability', 'Conditional Probability', 'Bayes Theorem', 'Expected Value']],
            ['title' => 'Statistical Distributions', 'lessons' => ['Normal Distribution', 'Binomial Distribution', 'Poisson Distribution', 'Central Limit Theorem']],
            ['title' => 'Hypothesis Testing', 'lessons' => ['Null Hypothesis', 't-Tests', 'Chi-Square Tests', 'ANOVA']],
            ['title' => 'Regression Analysis', 'lessons' => ['Simple Linear Regression', 'Multiple Regression', 'Model Diagnostics', 'Interpretation']],
            ['title' => 'Machine Learning for Data Science', 'lessons' => ['ML Overview', 'Scikit-learn', 'Model Selection', 'Feature Engineering']],
            ['title' => 'Classification Problems', 'lessons' => ['Classification Algorithms', 'Model Evaluation', 'Imbalanced Classes', 'Multi-class Classification']],
            ['title' => 'Clustering Analysis', 'lessons' => ['Clustering Algorithms', 'K-Means', 'Hierarchical Clustering', 'Cluster Validation']],
            ['title' => 'Time Series Analysis', 'lessons' => ['Time Series Basics', 'Trend and Seasonality', 'ARIMA Models', 'Forecasting']],
            ['title' => 'SQL for Data Science', 'lessons' => ['SQL Basics', 'Joins and Subqueries', 'Aggregations', 'Window Functions']],
            ['title' => 'Big Data Fundamentals', 'lessons' => ['Big Data Concepts', 'Hadoop Ecosystem', 'Spark Basics', 'Data Lakes']],
            ['title' => 'Web Scraping', 'lessons' => ['HTML Basics', 'BeautifulSoup', 'Scrapy', 'API Data Collection']],
            ['title' => 'Data Ethics and Privacy', 'lessons' => ['Data Ethics', 'Privacy Laws', 'Anonymization', 'Responsible Data Use']],
            ['title' => 'Storytelling with Data', 'lessons' => ['Data Narratives', 'Visualization Principles', 'Presentation Skills', 'Executive Summaries']],
            ['title' => 'Business Intelligence', 'lessons' => ['BI Concepts', 'Dashboard Design', 'KPIs and Metrics', 'Reporting']],
            ['title' => 'Data Science Projects', 'lessons' => ['Project Lifecycle', 'Version Control', 'Documentation', 'Collaboration']],
            ['title' => 'Data Science Capstone', 'lessons' => ['Project Selection', 'Data Collection', 'Analysis and Modeling', 'Presentation']]
        ]
    ],
    
    // Course 7: Mobile App Development - 20 modules
    7 => [
        'title' => 'Mobile App Development',
        'modules' => [
            ['title' => 'Mobile Development Overview', 'lessons' => ['Mobile Platforms', 'Native vs Cross-Platform', 'Mobile Market', 'Development Approaches']],
            ['title' => 'Mobile UI/UX Principles', 'lessons' => ['Mobile Design Patterns', 'Touch Interfaces', 'Responsive Mobile Design', 'Accessibility']],
            ['title' => 'JavaScript for Mobile', 'lessons' => ['ES6+ Review', 'Async Programming', 'Modules', 'Modern JavaScript']],
            ['title' => 'React Native Setup', 'lessons' => ['Environment Setup', 'Expo vs CLI', 'Project Structure', 'Running on Devices']],
            ['title' => 'React Native Components', 'lessons' => ['Core Components', 'Styling', 'Layout with Flexbox', 'Custom Components']],
            ['title' => 'React Native Navigation', 'lessons' => ['Stack Navigator', 'Tab Navigator', 'Drawer Navigator', 'Deep Linking']],
            ['title' => 'State Management in Mobile', 'lessons' => ['Local State', 'Context API', 'Redux for Mobile', 'State Persistence']],
            ['title' => 'Networking and APIs', 'lessons' => ['Fetch API', 'Axios', 'API Integration', 'Offline Support']],
            ['title' => 'Local Storage', 'lessons' => ['AsyncStorage', 'SQLite', 'Realm', 'Data Caching']],
            ['title' => 'Camera and Media', 'lessons' => ['Camera Access', 'Photo Library', 'Video Recording', 'Image Manipulation']],
            ['title' => 'Location Services', 'lessons' => ['Geolocation', 'Maps Integration', 'Background Location', 'Geofencing']],
            ['title' => 'Push Notifications', 'lessons' => ['Notification Setup', 'Local Notifications', 'Remote Notifications', 'Notification Handling']],
            ['title' => 'Device Features', 'lessons' => ['Sensors', 'Haptics', 'Device Info', 'Permissions']],
            ['title' => 'Animation and Gestures', 'lessons' => ['Animated API', 'Gesture Handler', 'Reanimated', 'Micro-interactions']],
            ['title' => 'Authentication in Mobile', 'lessons' => ['Auth Flows', 'Secure Storage', 'Biometric Auth', 'OAuth in Mobile']],
            ['title' => 'Testing Mobile Apps', 'lessons' => ['Unit Testing', 'Component Testing', 'Integration Testing', 'E2E with Detox']],
            ['title' => 'Performance Optimization', 'lessons' => ['Performance Profiling', 'Memory Management', 'Bundle Optimization', 'Native Bridges']],
            ['title' => 'App Store Guidelines', 'lessons' => ['iOS Guidelines', 'Android Policies', 'App Review Process', 'Metadata Optimization']],
            ['title' => 'Building for Production', 'lessons' => ['Release Builds', 'Code Signing', 'Versioning', 'Over-the-Air Updates']],
            ['title' => 'Publishing Your App', 'lessons' => ['App Store Submission', 'Play Store Submission', 'Marketing', 'Post-Launch Support']]
        ]
    ],
    
    // Course 8: Cybersecurity - 22 modules
    8 => [
        'title' => 'Cybersecurity',
        'modules' => [
            ['title' => 'Introduction to Cybersecurity', 'lessons' => ['What is Cybersecurity?', 'Cyber Threats Landscape', 'Career Paths', 'Industry Certifications']],
            ['title' => 'Security Fundamentals', 'lessons' => ['CIA Triad', 'Security Principles', 'Defense in Depth', 'Zero Trust']],
            ['title' => 'Common Threats and Attacks', 'lessons' => ['Malware Types', 'Phishing', 'Social Engineering', 'Ransomware']],
            ['title' => 'Network Security Basics', 'lessons' => ['Network Architecture', 'Protocols', 'Firewalls', 'VPNs']],
            ['title' => 'Network Defense', 'lessons' => ['IDS/IPS', 'Network Monitoring', 'SIEM', 'Log Analysis']],
            ['title' => 'Wireless Security', 'lessons' => ['WiFi Security', 'Wireless Attacks', 'Securing Wireless Networks', 'Bluetooth Security']],
            ['title' => 'Operating System Security', 'lessons' => ['Windows Security', 'Linux Security', 'macOS Security', 'Hardening']],
            ['title' => 'Web Application Security', 'lessons' => ['OWASP Top 10', 'SQL Injection', 'XSS Attacks', 'CSRF']],
            ['title' => 'Cryptography Fundamentals', 'lessons' => ['Encryption Basics', 'Symmetric vs Asymmetric', 'Hashing', 'Digital Signatures']],
            ['title' => 'Applied Cryptography', 'lessons' => ['SSL/TLS', 'PKI', 'Certificate Management', 'Encryption Tools']],
            ['title' => 'Identity and Access Management', 'lessons' => ['Authentication', 'Authorization', 'MFA', 'SSO and Federation']],
            ['title' => 'Introduction to Pen Testing', 'lessons' => ['Pen Testing Methodology', 'Types of Testing', 'Legal Considerations', 'Reporting']],
            ['title' => 'Reconnaissance Techniques', 'lessons' => ['Passive Recon', 'Active Recon', 'OSINT', 'Footprinting']],
            ['title' => 'Vulnerability Assessment', 'lessons' => ['Vulnerability Scanning', 'Nessus', 'OpenVAS', 'Prioritization']],
            ['title' => 'Exploitation Basics', 'lessons' => ['Exploitation Framework', 'Metasploit', 'Post-Exploitation', 'Privilege Escalation']],
            ['title' => 'Security Operations Center', 'lessons' => ['SOC Overview', 'Incident Triage', 'Threat Hunting', 'Playbooks']],
            ['title' => 'Incident Response', 'lessons' => ['IR Process', 'Containment', 'Eradication', 'Recovery']],
            ['title' => 'Digital Forensics', 'lessons' => ['Forensic Principles', 'Evidence Collection', 'Analysis Tools', 'Chain of Custody']],
            ['title' => 'Security Policies', 'lessons' => ['Policy Development', 'Standards and Frameworks', 'Compliance', 'Governance']],
            ['title' => 'Risk Management', 'lessons' => ['Risk Assessment', 'Risk Analysis', 'Risk Mitigation', 'Business Continuity']],
            ['title' => 'Security Awareness', 'lessons' => ['Training Programs', 'Phishing Simulations', 'Culture Building', 'Metrics']],
            ['title' => 'Cloud Security', 'lessons' => ['Cloud Security Basics', 'Shared Responsibility', 'Cloud Compliance', 'Cloud Security Tools']]
        ]
    ],
    
    // Course 9: Cloud Computing - 26 modules
    9 => [
        'title' => 'Cloud Computing',
        'modules' => [
            ['title' => 'Cloud Computing Fundamentals', 'lessons' => ['What is Cloud Computing?', 'Cloud History', 'Benefits of Cloud', 'Cloud Challenges']],
            ['title' => 'Cloud Service Models', 'lessons' => ['IaaS', 'PaaS', 'SaaS', 'Serverless']],
            ['title' => 'Cloud Deployment Models', 'lessons' => ['Public Cloud', 'Private Cloud', 'Hybrid Cloud', 'Multi-Cloud']],
            ['title' => 'Major Cloud Providers', 'lessons' => ['AWS Overview', 'Azure Overview', 'GCP Overview', 'Provider Comparison']],
            ['title' => 'AWS Account Setup', 'lessons' => ['Account Creation', 'IAM Basics', 'Billing Setup', 'Console Navigation']],
            ['title' => 'AWS Compute Services', 'lessons' => ['EC2 Basics', 'Instance Types', 'AMIs', 'Auto Scaling']],
            ['title' => 'AWS Storage Services', 'lessons' => ['S3 Fundamentals', 'S3 Features', 'EBS', 'EFS']],
            ['title' => 'AWS Networking', 'lessons' => ['VPC Basics', 'Subnets', 'Security Groups', 'Route Tables']],
            ['title' => 'AWS Database Services', 'lessons' => ['RDS', 'DynamoDB', 'ElastiCache', 'Database Migration']],
            ['title' => 'AWS Security', 'lessons' => ['IAM Policies', 'Security Best Practices', 'KMS', 'CloudTrail']],
            ['title' => 'AWS Application Services', 'lessons' => ['Lambda', 'API Gateway', 'SQS', 'SNS']],
            ['title' => 'Infrastructure as Code', 'lessons' => ['IaC Concepts', 'CloudFormation', 'Terraform Basics', 'Template Design']],
            ['title' => 'DevOps Principles', 'lessons' => ['DevOps Culture', 'CI/CD Overview', 'Automation', 'Collaboration']],
            ['title' => 'Version Control with Git', 'lessons' => ['Git Basics', 'Branching Strategies', 'Pull Requests', 'Git Workflows']],
            ['title' => 'Docker Fundamentals', 'lessons' => ['Container Concepts', 'Docker Installation', 'Docker Commands', 'Dockerfiles']],
            ['title' => 'Docker Advanced', 'lessons' => ['Multi-stage Builds', 'Docker Compose', 'Networking', 'Volumes']],
            ['title' => 'Kubernetes Basics', 'lessons' => ['K8s Architecture', 'Pods', 'Services', 'Deployments']],
            ['title' => 'Kubernetes Advanced', 'lessons' => ['ConfigMaps and Secrets', 'Ingress', 'Helm', 'Monitoring']],
            ['title' => 'CI/CD Pipelines', 'lessons' => ['Pipeline Concepts', 'Jenkins', 'GitHub Actions', 'AWS CodePipeline']],
            ['title' => 'Monitoring and Logging', 'lessons' => ['CloudWatch', 'Logging Strategies', 'Alerting', 'Dashboards']],
            ['title' => 'Well-Architected Framework', 'lessons' => ['Operational Excellence', 'Security Pillar', 'Reliability', 'Performance']],
            ['title' => 'High Availability', 'lessons' => ['HA Concepts', 'Load Balancing', 'Fault Tolerance', 'Disaster Recovery']],
            ['title' => 'Cost Optimization', 'lessons' => ['Cost Analysis', 'Reserved Instances', 'Spot Instances', 'Right Sizing']],
            ['title' => 'Cloud Migration', 'lessons' => ['Migration Strategies', 'Assessment', 'Planning', 'Execution']],
            ['title' => 'Serverless Architecture', 'lessons' => ['Serverless Concepts', 'Function Design', 'Event-Driven', 'Best Practices']],
            ['title' => 'Cloud Capstone Project', 'lessons' => ['Project Planning', 'Architecture Design', 'Implementation', 'Documentation']]
        ]
    ],
    
    // Course 10: Networking Engineering - 10 modules
    10 => [
        'title' => 'Networking Engineering',
        'modules' => [
            ['title' => 'Networking Fundamentals', 'lessons' => ['What is Networking?', 'Network Types', 'Network Topologies', 'Network Components']],
            ['title' => 'OSI Model', 'lessons' => ['OSI Layers', 'Data Encapsulation', 'Layer Functions', 'Troubleshooting with OSI']],
            ['title' => 'TCP/IP Protocol Suite', 'lessons' => ['TCP/IP Model', 'TCP vs UDP', 'IP Protocol', 'ICMP']],
            ['title' => 'IP Addressing', 'lessons' => ['IPv4 Addressing', 'Address Classes', 'Private vs Public', 'CIDR Notation']],
            ['title' => 'Subnetting', 'lessons' => ['Subnetting Concepts', 'Subnet Calculations', 'VLSM', 'Subnetting Practice']],
            ['title' => 'IPv6 Fundamentals', 'lessons' => ['IPv6 Addressing', 'IPv6 Header', 'IPv6 Configuration', 'IPv4 to IPv6 Transition']],
            ['title' => 'Network Devices', 'lessons' => ['Hubs and Switches', 'Routers', 'Firewalls', 'Access Points']],
            ['title' => 'Switching and VLANs', 'lessons' => ['Switch Operation', 'VLAN Concepts', 'VLAN Configuration', 'Inter-VLAN Routing']],
            ['title' => 'Routing Fundamentals', 'lessons' => ['Static Routing', 'Dynamic Routing', 'Routing Protocols', 'Route Tables']],
            ['title' => 'Network Services', 'lessons' => ['DHCP', 'DNS', 'NAT/PAT', 'Network Troubleshooting']]
        ]
    ],
    
    // Course 11: Computer Hardware - 8 modules
    11 => [
        'title' => 'Computer Hardware',
        'modules' => [
            ['title' => 'Computer Components Overview', 'lessons' => ['PC Components', 'How Computers Work', 'Form Factors', 'Hardware vs Software']],
            ['title' => 'Processors (CPUs)', 'lessons' => ['CPU Architecture', 'CPU Specifications', 'Cores and Threads', 'Choosing a Processor']],
            ['title' => 'Memory and Storage', 'lessons' => ['RAM Types', 'Memory Specifications', 'Storage Types', 'SSD vs HDD']],
            ['title' => 'Motherboards and BIOS', 'lessons' => ['Motherboard Components', 'Form Factors', 'BIOS/UEFI', 'Chipsets']],
            ['title' => 'PC Assembly', 'lessons' => ['Component Selection', 'Assembly Process', 'Cable Management', 'First Boot']],
            ['title' => 'Operating System Installation', 'lessons' => ['BIOS Configuration', 'OS Installation', 'Driver Installation', 'Initial Setup']],
            ['title' => 'Troubleshooting', 'lessons' => ['Troubleshooting Methodology', 'Boot Issues', 'Hardware Failures', 'Diagnostic Tools']],
            ['title' => 'Maintenance and Upgrades', 'lessons' => ['Preventive Maintenance', 'Cleaning', 'Upgrading Components', 'Performance Tuning']]
        ]
    ],
    
    // Course 12: Digital Literacy - 8 modules
    12 => [
        'title' => 'Digital Literacy',
        'modules' => [
            ['title' => 'Computer Basics', 'lessons' => ['What is a Computer?', 'Desktop vs Laptop', 'Operating Systems', 'Basic Navigation']],
            ['title' => 'Keyboard and Mouse Skills', 'lessons' => ['Keyboard Layout', 'Typing Basics', 'Mouse Operations', 'Keyboard Shortcuts']],
            ['title' => 'File Management', 'lessons' => ['Files and Folders', 'Creating and Organizing', 'Copying and Moving', 'File Types']],
            ['title' => 'Internet Basics', 'lessons' => ['What is the Internet?', 'Web Browsers', 'Searching Online', 'Bookmarks']],
            ['title' => 'Email Essentials', 'lessons' => ['Email Basics', 'Composing Emails', 'Attachments', 'Email Etiquette']],
            ['title' => 'Online Safety', 'lessons' => ['Password Security', 'Recognizing Scams', 'Privacy Online', 'Safe Browsing']],
            ['title' => 'Productivity Basics', 'lessons' => ['Word Processing', 'Spreadsheet Basics', 'Presentation Basics', 'Cloud Storage']],
            ['title' => 'Digital Communication', 'lessons' => ['Video Calls', 'Instant Messaging', 'Social Media Basics', 'Online Collaboration']]
        ]
    ],
    
    // Course 13: Graphic Design & Digital Arts - 11 modules
    13 => [
        'title' => 'Graphic Design & Digital Arts',
        'modules' => [
            ['title' => 'Design Fundamentals', 'lessons' => ['What is Graphic Design?', 'Design History', 'Design Process', 'Design Thinking']],
            ['title' => 'Elements of Design', 'lessons' => ['Line', 'Shape', 'Color', 'Texture and Space']],
            ['title' => 'Principles of Design', 'lessons' => ['Balance', 'Contrast', 'Emphasis', 'Unity and Harmony']],
            ['title' => 'Color Theory', 'lessons' => ['Color Wheel', 'Color Harmonies', 'Color Psychology', 'Color in Design']],
            ['title' => 'Typography', 'lessons' => ['Typography Basics', 'Font Selection', 'Type Hierarchy', 'Typography in Design']],
            ['title' => 'Adobe Photoshop Basics', 'lessons' => ['Photoshop Interface', 'Tools Overview', 'Layers', 'Selection Tools']],
            ['title' => 'Photoshop Advanced', 'lessons' => ['Masks and Blending', 'Photo Retouching', 'Compositing', 'Effects and Filters']],
            ['title' => 'Adobe Illustrator Basics', 'lessons' => ['Illustrator Interface', 'Vector Basics', 'Drawing Tools', 'Paths and Shapes']],
            ['title' => 'Illustrator Advanced', 'lessons' => ['Pen Tool Mastery', 'Logo Design', 'Illustration Techniques', 'Print Preparation']],
            ['title' => 'Brand Identity Design', 'lessons' => ['Brand Strategy', 'Logo Design Process', 'Visual Identity', 'Brand Guidelines']],
            ['title' => 'Digital Design Projects', 'lessons' => ['Social Media Graphics', 'Web Graphics', 'Print Design', 'Portfolio Building']]
        ]
    ],
    
    // Course 14: Video Editing & Production - 10 modules
    14 => [
        'title' => 'Video Editing & Production',
        'modules' => [
            ['title' => 'Video Production Overview', 'lessons' => ['Video Production Process', 'Pre-Production', 'Production', 'Post-Production']],
            ['title' => 'Camera Basics', 'lessons' => ['Camera Types', 'Camera Settings', 'Composition', 'Lighting Basics']],
            ['title' => 'Audio for Video', 'lessons' => ['Audio Basics', 'Microphone Types', 'Recording Audio', 'Audio Quality']],
            ['title' => 'Premiere Pro Basics', 'lessons' => ['Interface Tour', 'Project Setup', 'Importing Media', 'Timeline Basics']],
            ['title' => 'Basic Video Editing', 'lessons' => ['Cutting and Trimming', 'Arranging Clips', 'Transitions', 'Basic Effects']],
            ['title' => 'Audio Editing', 'lessons' => ['Audio in Premiere', 'Levels and Mixing', 'Music and Sound Effects', 'Audio Effects']],
            ['title' => 'Color Correction', 'lessons' => ['Color Theory for Video', 'Lumetri Color', 'Color Correction', 'Color Grading']],
            ['title' => 'After Effects Introduction', 'lessons' => ['After Effects Interface', 'Compositions', 'Keyframes', 'Basic Animation']],
            ['title' => 'Motion Graphics', 'lessons' => ['Text Animation', 'Shape Animation', 'Lower Thirds', 'Titles and Credits']],
            ['title' => 'Export and Delivery', 'lessons' => ['Export Settings', 'Formats and Codecs', 'Platform Requirements', 'Publishing']]
        ]
    ],
    
    // Course 15: Microsoft Office Suite - 10 modules
    15 => [
        'title' => 'Microsoft Office Suite',
        'modules' => [
            ['title' => 'Microsoft Office Overview', 'lessons' => ['Office Applications', 'Office 365', 'Common Features', 'Keyboard Shortcuts']],
            ['title' => 'Word Basics', 'lessons' => ['Word Interface', 'Creating Documents', 'Text Formatting', 'Paragraph Formatting']],
            ['title' => 'Word Advanced', 'lessons' => ['Styles and Templates', 'Tables', 'Images and Graphics', 'Headers and Footers']],
            ['title' => 'Excel Basics', 'lessons' => ['Excel Interface', 'Cells and Ranges', 'Basic Formatting', 'Simple Formulas']],
            ['title' => 'Excel Formulas and Functions', 'lessons' => ['Common Functions', 'Logical Functions', 'Lookup Functions', 'Formula Troubleshooting']],
            ['title' => 'Excel Charts and Analysis', 'lessons' => ['Chart Types', 'Creating Charts', 'Data Analysis', 'Pivot Tables']],
            ['title' => 'PowerPoint Basics', 'lessons' => ['PowerPoint Interface', 'Creating Presentations', 'Slide Layouts', 'Themes and Design']],
            ['title' => 'PowerPoint Advanced', 'lessons' => ['Animations', 'Transitions', 'Multimedia', 'Presenting Skills']],
            ['title' => 'Outlook', 'lessons' => ['Email Management', 'Calendar', 'Contacts', 'Tasks']],
            ['title' => 'Microsoft Teams', 'lessons' => ['Teams Overview', 'Chat and Channels', 'Meetings', 'Collaboration']]
        ]
    ]
];

$totalModules = 0;
$totalLessons = 0;

foreach ($curriculums as $courseId => $courseData) {
    echo "<h2>Course {$courseId}: {$courseData['title']}</h2>";
    
    $moduleOrder = 1;
    foreach ($courseData['modules'] as $module) {
        // Generate UUID for module
        $moduleUuid = sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
        
        $stmt = $pdo->prepare("INSERT INTO modules (uuid, course_id, title, description, order_index, status, created_at) 
                               VALUES (?, ?, ?, ?, ?, 'published', NOW())");
        $stmt->execute([
            $moduleUuid,
            $courseId,
            $module['title'],
            "Learn about {$module['title']}",
            $moduleOrder
        ]);
        $moduleId = $pdo->lastInsertId();
        $totalModules++;
        
        echo "<p>Module: {$module['title']} (ID: {$moduleId})</p>";
        
        // Add lessons
        $lessonOrder = 1;
        foreach ($module['lessons'] as $lessonTitle) {
            // Generate UUID for lesson
            $lessonUuid = sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                mt_rand(0, 0xffff), mt_rand(0, 0xffff),
                mt_rand(0, 0xffff),
                mt_rand(0, 0x0fff) | 0x4000,
                mt_rand(0, 0x3fff) | 0x8000,
                mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
            );
            
            $lessonContent = "<h2>{$lessonTitle}</h2><p>This lesson covers {$lessonTitle} in the context of {$module['title']}.</p><p>Key learning objectives:</p><ul><li>Understand the fundamentals of {$lessonTitle}</li><li>Apply concepts in practical scenarios</li><li>Build hands-on skills</li></ul>";
            
            $stmt = $pdo->prepare("INSERT INTO lessons (uuid, module_id, title, type, content, duration_minutes, order_index, ai_generated, created_at)
                                   VALUES (?, ?, ?, 'text', ?, ?, ?, 0, NOW())");
            $stmt->execute([
                $lessonUuid,
                $moduleId,
                $lessonTitle,
                $lessonContent,
                rand(15, 45),
                $lessonOrder
            ]);
            $totalLessons++;
            
            echo "<p>&nbsp;&nbsp;- Lesson: {$lessonTitle}</p>";
            $lessonOrder++;
        }
        
        $moduleOrder++;
    }
}

echo "<hr><h2>Summary</h2>";
echo "<p><strong>Total Modules Created:</strong> {$totalModules}</p>";
echo "<p><strong>Total Lessons Created:</strong> {$totalLessons}</p>";
echo "<p style='color: green; font-weight: bold;'>✅ All courses have been populated with complete curriculum!</p>";
