<?php
/**
 * Create complete modules and lessons for all 15 main courses
 */
require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

$db = Nebatech\Core\Database::connect();

// Course curriculum data for courses 2-15 (course 1 already has content)
$coursesCurriculum = [
    // Course 2: Backend Development
    2 => [
        'modules' => [
            [
                'title' => 'Introduction to Backend Development',
                'description' => 'Understanding server-side programming concepts',
                'lessons' => [
                    ['title' => 'What is Backend Development?', 'duration' => 15, 'content' => '<h2>Backend Development Overview</h2><p>Backend development refers to server-side development that focuses on databases, scripting, and website architecture. Backend developers write code that communicates between the database and the browser.</p><h3>Key Responsibilities</h3><ul><li>Server-side logic and database integration</li><li>API development and maintenance</li><li>Security implementation</li><li>Performance optimization</li></ul>'],
                    ['title' => 'Server Architecture Basics', 'duration' => 20, 'content' => '<h2>Understanding Server Architecture</h2><p>Learn about client-server model, request-response cycle, and how web servers handle requests.</p><h3>Components</h3><ul><li>Web servers (Apache, Nginx)</li><li>Application servers</li><li>Database servers</li><li>Load balancers</li></ul>'],
                    ['title' => 'Backend Languages Overview', 'duration' => 25, 'content' => '<h2>Popular Backend Languages</h2><p>Explore different backend programming languages and their use cases.</p><h3>Languages</h3><ul><li>PHP - WordPress, Laravel</li><li>Python - Django, Flask</li><li>JavaScript - Node.js, Express</li><li>Java - Spring Boot</li><li>Ruby - Ruby on Rails</li></ul>'],
                ]
            ],
            [
                'title' => 'PHP Fundamentals',
                'description' => 'Core PHP programming for web development',
                'lessons' => [
                    ['title' => 'PHP Syntax and Variables', 'duration' => 25, 'content' => '<h2>PHP Basics</h2><p>PHP is a server-side scripting language designed for web development.</p><pre><code>&lt;?php\n$name = "John";\n$age = 25;\necho "Hello, " . $name;\n?&gt;</code></pre>'],
                    ['title' => 'Control Structures', 'duration' => 30, 'content' => '<h2>PHP Control Structures</h2><p>Learn about if-else, switch, loops, and conditional expressions in PHP.</p>'],
                    ['title' => 'Functions and Arrays', 'duration' => 35, 'content' => '<h2>Functions and Arrays</h2><p>Creating reusable functions and working with arrays in PHP.</p>'],
                    ['title' => 'Object-Oriented PHP', 'duration' => 40, 'content' => '<h2>OOP in PHP</h2><p>Classes, objects, inheritance, and interfaces in PHP.</p>'],
                ]
            ],
            [
                'title' => 'Database Integration',
                'description' => 'Connecting PHP with MySQL databases',
                'lessons' => [
                    ['title' => 'Introduction to MySQL', 'duration' => 25, 'content' => '<h2>MySQL Database</h2><p>Understanding relational databases and SQL basics.</p>'],
                    ['title' => 'CRUD Operations', 'duration' => 35, 'content' => '<h2>CRUD with PHP & MySQL</h2><p>Create, Read, Update, Delete operations using PDO.</p>'],
                    ['title' => 'Database Security', 'duration' => 30, 'content' => '<h2>Securing Database Operations</h2><p>Prepared statements, input validation, and SQL injection prevention.</p>'],
                ]
            ],
            [
                'title' => 'API Development',
                'description' => 'Building RESTful APIs',
                'lessons' => [
                    ['title' => 'REST API Fundamentals', 'duration' => 30, 'content' => '<h2>RESTful API Design</h2><p>Understanding REST principles and HTTP methods.</p>'],
                    ['title' => 'Building APIs with PHP', 'duration' => 40, 'content' => '<h2>Creating REST APIs</h2><p>Build your own API endpoints with proper routing.</p>'],
                    ['title' => 'API Authentication', 'duration' => 35, 'content' => '<h2>Securing APIs</h2><p>JWT tokens, API keys, and OAuth implementation.</p>'],
                ]
            ],
        ]
    ],
    
    // Course 3: Full Stack Development
    3 => [
        'modules' => [
            [
                'title' => 'Full Stack Overview',
                'description' => 'Understanding the complete web development stack',
                'lessons' => [
                    ['title' => 'What is Full Stack Development?', 'duration' => 20, 'content' => '<h2>Full Stack Development</h2><p>Full stack development combines frontend and backend skills to build complete web applications.</p>'],
                    ['title' => 'The Modern Web Stack', 'duration' => 25, 'content' => '<h2>Modern Tech Stacks</h2><p>LAMP, MEAN, MERN, and other popular stacks explained.</p>'],
                    ['title' => 'Development Environment Setup', 'duration' => 30, 'content' => '<h2>Setting Up Your Environment</h2><p>Installing and configuring tools for full stack development.</p>'],
                ]
            ],
            [
                'title' => 'Frontend Technologies',
                'description' => 'Modern frontend frameworks and tools',
                'lessons' => [
                    ['title' => 'React.js Essentials', 'duration' => 40, 'content' => '<h2>React.js</h2><p>Component-based UI development with React.</p>'],
                    ['title' => 'State Management', 'duration' => 35, 'content' => '<h2>Managing Application State</h2><p>Redux, Context API, and state management patterns.</p>'],
                    ['title' => 'Frontend Build Tools', 'duration' => 30, 'content' => '<h2>Build Tools</h2><p>Webpack, Vite, and modern build processes.</p>'],
                ]
            ],
            [
                'title' => 'Backend with Node.js',
                'description' => 'Server-side JavaScript development',
                'lessons' => [
                    ['title' => 'Node.js Fundamentals', 'duration' => 35, 'content' => '<h2>Node.js</h2><p>Server-side JavaScript runtime and core modules.</p>'],
                    ['title' => 'Express.js Framework', 'duration' => 40, 'content' => '<h2>Express.js</h2><p>Building web servers and APIs with Express.</p>'],
                    ['title' => 'MongoDB Integration', 'duration' => 35, 'content' => '<h2>MongoDB</h2><p>NoSQL database integration with Mongoose.</p>'],
                ]
            ],
            [
                'title' => 'Full Stack Project',
                'description' => 'Building a complete application',
                'lessons' => [
                    ['title' => 'Project Planning', 'duration' => 25, 'content' => '<h2>Planning Your Project</h2><p>Requirements gathering and architecture design.</p>'],
                    ['title' => 'Building the Frontend', 'duration' => 60, 'content' => '<h2>Frontend Implementation</h2><p>Building React components and UI.</p>'],
                    ['title' => 'Building the Backend', 'duration' => 60, 'content' => '<h2>Backend Implementation</h2><p>Creating API endpoints and database models.</p>'],
                    ['title' => 'Deployment', 'duration' => 40, 'content' => '<h2>Deploying Your Application</h2><p>Deploying to cloud platforms.</p>'],
                ]
            ],
        ]
    ],
    
    // Course 4: Database Design & Administration
    4 => [
        'modules' => [
            [
                'title' => 'Database Fundamentals',
                'description' => 'Core database concepts and theory',
                'lessons' => [
                    ['title' => 'Introduction to Databases', 'duration' => 20, 'content' => '<h2>Database Basics</h2><p>Understanding what databases are and why we need them.</p>'],
                    ['title' => 'Relational vs NoSQL', 'duration' => 25, 'content' => '<h2>Database Types</h2><p>Comparing relational and NoSQL databases.</p>'],
                    ['title' => 'Data Modeling Concepts', 'duration' => 30, 'content' => '<h2>Data Modeling</h2><p>Entities, relationships, and data modeling principles.</p>'],
                ]
            ],
            [
                'title' => 'SQL Mastery',
                'description' => 'Structured Query Language deep dive',
                'lessons' => [
                    ['title' => 'SQL Basics', 'duration' => 30, 'content' => '<h2>SQL Fundamentals</h2><p>SELECT, INSERT, UPDATE, DELETE statements.</p>'],
                    ['title' => 'Advanced Queries', 'duration' => 40, 'content' => '<h2>Advanced SQL</h2><p>JOINs, subqueries, and aggregate functions.</p>'],
                    ['title' => 'Stored Procedures & Triggers', 'duration' => 35, 'content' => '<h2>Database Programming</h2><p>Creating stored procedures and triggers.</p>'],
                    ['title' => 'Query Optimization', 'duration' => 35, 'content' => '<h2>Performance Optimization</h2><p>Indexes, execution plans, and query optimization.</p>'],
                ]
            ],
            [
                'title' => 'Database Design',
                'description' => 'Designing efficient database schemas',
                'lessons' => [
                    ['title' => 'Normalization', 'duration' => 35, 'content' => '<h2>Database Normalization</h2><p>1NF, 2NF, 3NF, and BCNF explained.</p>'],
                    ['title' => 'ER Diagrams', 'duration' => 30, 'content' => '<h2>Entity-Relationship Diagrams</h2><p>Visual database design techniques.</p>'],
                    ['title' => 'Schema Design Best Practices', 'duration' => 30, 'content' => '<h2>Best Practices</h2><p>Designing scalable and maintainable schemas.</p>'],
                ]
            ],
            [
                'title' => 'Database Administration',
                'description' => 'Managing and maintaining databases',
                'lessons' => [
                    ['title' => 'Backup and Recovery', 'duration' => 30, 'content' => '<h2>Backup Strategies</h2><p>Full, incremental, and differential backups.</p>'],
                    ['title' => 'Security and Access Control', 'duration' => 35, 'content' => '<h2>Database Security</h2><p>User management, roles, and permissions.</p>'],
                    ['title' => 'Monitoring and Maintenance', 'duration' => 30, 'content' => '<h2>Database Maintenance</h2><p>Performance monitoring and maintenance tasks.</p>'],
                ]
            ],
        ]
    ],
    
    // Course 5: AI & Machine Learning
    5 => [
        'modules' => [
            [
                'title' => 'Introduction to AI',
                'description' => 'Foundations of Artificial Intelligence',
                'lessons' => [
                    ['title' => 'What is Artificial Intelligence?', 'duration' => 20, 'content' => '<h2>AI Overview</h2><p>Understanding AI, its history, and current applications.</p>'],
                    ['title' => 'Types of AI', 'duration' => 25, 'content' => '<h2>AI Categories</h2><p>Narrow AI, General AI, and Super AI explained.</p>'],
                    ['title' => 'AI Ethics and Considerations', 'duration' => 20, 'content' => '<h2>Ethical AI</h2><p>Bias, fairness, and responsible AI development.</p>'],
                ]
            ],
            [
                'title' => 'Python for AI',
                'description' => 'Python programming for AI applications',
                'lessons' => [
                    ['title' => 'Python Basics Review', 'duration' => 30, 'content' => '<h2>Python Refresher</h2><p>Essential Python for AI development.</p>'],
                    ['title' => 'NumPy and Pandas', 'duration' => 40, 'content' => '<h2>Data Libraries</h2><p>Working with numerical data and dataframes.</p>'],
                    ['title' => 'Data Visualization', 'duration' => 35, 'content' => '<h2>Matplotlib & Seaborn</h2><p>Visualizing data for AI insights.</p>'],
                ]
            ],
            [
                'title' => 'Machine Learning Fundamentals',
                'description' => 'Core ML concepts and algorithms',
                'lessons' => [
                    ['title' => 'Supervised Learning', 'duration' => 40, 'content' => '<h2>Supervised Learning</h2><p>Classification and regression algorithms.</p>'],
                    ['title' => 'Unsupervised Learning', 'duration' => 35, 'content' => '<h2>Unsupervised Learning</h2><p>Clustering and dimensionality reduction.</p>'],
                    ['title' => 'Model Evaluation', 'duration' => 30, 'content' => '<h2>Evaluating Models</h2><p>Metrics, cross-validation, and model selection.</p>'],
                    ['title' => 'Scikit-learn in Practice', 'duration' => 45, 'content' => '<h2>Scikit-learn</h2><p>Building ML models with scikit-learn.</p>'],
                ]
            ],
            [
                'title' => 'Deep Learning',
                'description' => 'Neural networks and deep learning',
                'lessons' => [
                    ['title' => 'Neural Networks Basics', 'duration' => 40, 'content' => '<h2>Neural Networks</h2><p>Perceptrons, activation functions, and backpropagation.</p>'],
                    ['title' => 'TensorFlow & Keras', 'duration' => 45, 'content' => '<h2>Deep Learning Frameworks</h2><p>Building neural networks with TensorFlow.</p>'],
                    ['title' => 'CNNs for Computer Vision', 'duration' => 45, 'content' => '<h2>Convolutional Neural Networks</h2><p>Image recognition and computer vision.</p>'],
                    ['title' => 'NLP and Transformers', 'duration' => 50, 'content' => '<h2>Natural Language Processing</h2><p>Text processing and transformer models.</p>'],
                ]
            ],
        ]
    ],
    
    // Course 6: Data Science
    6 => [
        'modules' => [
            [
                'title' => 'Data Science Foundations',
                'description' => 'Introduction to data science methodology',
                'lessons' => [
                    ['title' => 'What is Data Science?', 'duration' => 20, 'content' => '<h2>Data Science Overview</h2><p>The data science lifecycle and its applications.</p>'],
                    ['title' => 'The Data Science Process', 'duration' => 25, 'content' => '<h2>CRISP-DM Process</h2><p>Data mining and analysis methodology.</p>'],
                    ['title' => 'Tools and Environment Setup', 'duration' => 30, 'content' => '<h2>Data Science Tools</h2><p>Jupyter, Python, R, and essential libraries.</p>'],
                ]
            ],
            [
                'title' => 'Data Analysis with Python',
                'description' => 'Exploratory data analysis techniques',
                'lessons' => [
                    ['title' => 'Pandas Deep Dive', 'duration' => 45, 'content' => '<h2>Pandas Mastery</h2><p>Advanced dataframe operations and manipulation.</p>'],
                    ['title' => 'Data Cleaning', 'duration' => 40, 'content' => '<h2>Data Wrangling</h2><p>Handling missing values, outliers, and data quality.</p>'],
                    ['title' => 'Exploratory Data Analysis', 'duration' => 45, 'content' => '<h2>EDA Techniques</h2><p>Statistical analysis and pattern discovery.</p>'],
                ]
            ],
            [
                'title' => 'Statistics for Data Science',
                'description' => 'Statistical methods and inference',
                'lessons' => [
                    ['title' => 'Descriptive Statistics', 'duration' => 35, 'content' => '<h2>Descriptive Stats</h2><p>Mean, median, mode, variance, and distributions.</p>'],
                    ['title' => 'Probability Theory', 'duration' => 40, 'content' => '<h2>Probability</h2><p>Probability distributions and Bayes theorem.</p>'],
                    ['title' => 'Hypothesis Testing', 'duration' => 40, 'content' => '<h2>Statistical Testing</h2><p>t-tests, chi-square, ANOVA, and p-values.</p>'],
                ]
            ],
            [
                'title' => 'Data Visualization',
                'description' => 'Creating impactful visualizations',
                'lessons' => [
                    ['title' => 'Visualization Principles', 'duration' => 25, 'content' => '<h2>Design Principles</h2><p>Effective data visualization guidelines.</p>'],
                    ['title' => 'Matplotlib & Seaborn', 'duration' => 40, 'content' => '<h2>Python Visualization</h2><p>Creating charts and plots with Python.</p>'],
                    ['title' => 'Interactive Dashboards', 'duration' => 45, 'content' => '<h2>Plotly & Dash</h2><p>Building interactive visualizations.</p>'],
                ]
            ],
        ]
    ],
    
    // Course 7: Mobile App Development
    7 => [
        'modules' => [
            [
                'title' => 'Mobile Development Basics',
                'description' => 'Introduction to mobile app development',
                'lessons' => [
                    ['title' => 'Mobile Platforms Overview', 'duration' => 20, 'content' => '<h2>Mobile Platforms</h2><p>iOS, Android, and cross-platform development options.</p>'],
                    ['title' => 'Native vs Cross-Platform', 'duration' => 25, 'content' => '<h2>Development Approaches</h2><p>Choosing the right approach for your app.</p>'],
                    ['title' => 'Mobile UI/UX Principles', 'duration' => 30, 'content' => '<h2>Mobile Design</h2><p>Designing for touch interfaces and small screens.</p>'],
                ]
            ],
            [
                'title' => 'React Native Fundamentals',
                'description' => 'Building apps with React Native',
                'lessons' => [
                    ['title' => 'React Native Setup', 'duration' => 30, 'content' => '<h2>Getting Started</h2><p>Setting up your React Native development environment.</p>'],
                    ['title' => 'Components and Styling', 'duration' => 40, 'content' => '<h2>React Native UI</h2><p>Core components and StyleSheet API.</p>'],
                    ['title' => 'Navigation', 'duration' => 35, 'content' => '<h2>App Navigation</h2><p>React Navigation for multi-screen apps.</p>'],
                    ['title' => 'State Management', 'duration' => 40, 'content' => '<h2>Managing State</h2><p>Context, Redux, and state patterns.</p>'],
                ]
            ],
            [
                'title' => 'Native Features',
                'description' => 'Accessing device capabilities',
                'lessons' => [
                    ['title' => 'Camera and Media', 'duration' => 35, 'content' => '<h2>Media Access</h2><p>Using camera, gallery, and media libraries.</p>'],
                    ['title' => 'Location Services', 'duration' => 30, 'content' => '<h2>Geolocation</h2><p>GPS, maps, and location-based features.</p>'],
                    ['title' => 'Push Notifications', 'duration' => 35, 'content' => '<h2>Notifications</h2><p>Implementing push notifications.</p>'],
                    ['title' => 'Local Storage', 'duration' => 30, 'content' => '<h2>Data Persistence</h2><p>AsyncStorage, SQLite, and Realm.</p>'],
                ]
            ],
            [
                'title' => 'App Deployment',
                'description' => 'Publishing to app stores',
                'lessons' => [
                    ['title' => 'App Store Guidelines', 'duration' => 25, 'content' => '<h2>Store Requirements</h2><p>Apple and Google store guidelines.</p>'],
                    ['title' => 'Building for Production', 'duration' => 35, 'content' => '<h2>Production Builds</h2><p>Creating release builds and signing.</p>'],
                    ['title' => 'Publishing Your App', 'duration' => 30, 'content' => '<h2>Store Submission</h2><p>Submitting to App Store and Play Store.</p>'],
                ]
            ],
        ]
    ],
    
    // Course 8: Cybersecurity
    8 => [
        'modules' => [
            [
                'title' => 'Cybersecurity Fundamentals',
                'description' => 'Core security concepts and principles',
                'lessons' => [
                    ['title' => 'Introduction to Cybersecurity', 'duration' => 20, 'content' => '<h2>Cybersecurity Overview</h2><p>Understanding threats, vulnerabilities, and security principles.</p>'],
                    ['title' => 'CIA Triad', 'duration' => 25, 'content' => '<h2>Security Principles</h2><p>Confidentiality, Integrity, and Availability.</p>'],
                    ['title' => 'Common Threats', 'duration' => 30, 'content' => '<h2>Threat Landscape</h2><p>Malware, phishing, ransomware, and social engineering.</p>'],
                ]
            ],
            [
                'title' => 'Network Security',
                'description' => 'Securing network infrastructure',
                'lessons' => [
                    ['title' => 'Network Security Basics', 'duration' => 35, 'content' => '<h2>Network Security</h2><p>Firewalls, VPNs, and network segmentation.</p>'],
                    ['title' => 'Intrusion Detection', 'duration' => 35, 'content' => '<h2>IDS/IPS Systems</h2><p>Detecting and preventing network intrusions.</p>'],
                    ['title' => 'Wireless Security', 'duration' => 30, 'content' => '<h2>WiFi Security</h2><p>WPA3, wireless threats, and best practices.</p>'],
                ]
            ],
            [
                'title' => 'Ethical Hacking',
                'description' => 'Penetration testing fundamentals',
                'lessons' => [
                    ['title' => 'Introduction to Pen Testing', 'duration' => 30, 'content' => '<h2>Ethical Hacking</h2><p>Legal and ethical considerations for pen testing.</p>'],
                    ['title' => 'Reconnaissance Techniques', 'duration' => 40, 'content' => '<h2>Information Gathering</h2><p>OSINT and reconnaissance methodologies.</p>'],
                    ['title' => 'Vulnerability Assessment', 'duration' => 45, 'content' => '<h2>Finding Vulnerabilities</h2><p>Scanning and vulnerability assessment tools.</p>'],
                    ['title' => 'Exploitation Basics', 'duration' => 45, 'content' => '<h2>Exploitation</h2><p>Understanding exploits and proof of concepts.</p>'],
                ]
            ],
            [
                'title' => 'Security Operations',
                'description' => 'Managing security in organizations',
                'lessons' => [
                    ['title' => 'Security Policies', 'duration' => 25, 'content' => '<h2>Security Governance</h2><p>Creating and implementing security policies.</p>'],
                    ['title' => 'Incident Response', 'duration' => 40, 'content' => '<h2>IR Process</h2><p>Detecting, responding, and recovering from incidents.</p>'],
                    ['title' => 'Security Awareness', 'duration' => 25, 'content' => '<h2>Human Factor</h2><p>Training and security awareness programs.</p>'],
                ]
            ],
        ]
    ],
    
    // Course 9: Cloud Computing
    9 => [
        'modules' => [
            [
                'title' => 'Cloud Computing Basics',
                'description' => 'Introduction to cloud technologies',
                'lessons' => [
                    ['title' => 'What is Cloud Computing?', 'duration' => 20, 'content' => '<h2>Cloud Overview</h2><p>Understanding cloud computing models and benefits.</p>'],
                    ['title' => 'Cloud Service Models', 'duration' => 25, 'content' => '<h2>IaaS, PaaS, SaaS</h2><p>Infrastructure, Platform, and Software as a Service.</p>'],
                    ['title' => 'Major Cloud Providers', 'duration' => 25, 'content' => '<h2>Cloud Providers</h2><p>AWS, Azure, Google Cloud comparison.</p>'],
                ]
            ],
            [
                'title' => 'AWS Fundamentals',
                'description' => 'Amazon Web Services core services',
                'lessons' => [
                    ['title' => 'AWS Account Setup', 'duration' => 20, 'content' => '<h2>Getting Started</h2><p>Creating and configuring your AWS account.</p>'],
                    ['title' => 'EC2 and Compute', 'duration' => 40, 'content' => '<h2>EC2 Instances</h2><p>Virtual machines and compute resources.</p>'],
                    ['title' => 'S3 Storage', 'duration' => 35, 'content' => '<h2>Object Storage</h2><p>S3 buckets, policies, and lifecycle.</p>'],
                    ['title' => 'RDS Databases', 'duration' => 35, 'content' => '<h2>Managed Databases</h2><p>Relational Database Service configuration.</p>'],
                ]
            ],
            [
                'title' => 'DevOps and CI/CD',
                'description' => 'Continuous integration and deployment',
                'lessons' => [
                    ['title' => 'DevOps Principles', 'duration' => 25, 'content' => '<h2>DevOps Culture</h2><p>DevOps practices and principles.</p>'],
                    ['title' => 'Docker Containers', 'duration' => 45, 'content' => '<h2>Containerization</h2><p>Docker images, containers, and registries.</p>'],
                    ['title' => 'Kubernetes Basics', 'duration' => 50, 'content' => '<h2>Container Orchestration</h2><p>Kubernetes pods, services, and deployments.</p>'],
                    ['title' => 'CI/CD Pipelines', 'duration' => 40, 'content' => '<h2>Automation</h2><p>Building CI/CD pipelines with GitHub Actions.</p>'],
                ]
            ],
            [
                'title' => 'Cloud Architecture',
                'description' => 'Designing cloud solutions',
                'lessons' => [
                    ['title' => 'Well-Architected Framework', 'duration' => 30, 'content' => '<h2>Best Practices</h2><p>AWS Well-Architected Framework pillars.</p>'],
                    ['title' => 'High Availability', 'duration' => 35, 'content' => '<h2>HA Design</h2><p>Designing for fault tolerance and high availability.</p>'],
                    ['title' => 'Cost Optimization', 'duration' => 30, 'content' => '<h2>Cloud Costs</h2><p>Managing and optimizing cloud spending.</p>'],
                ]
            ],
        ]
    ],
    
    // Course 10: Networking Engineering
    10 => [
        'modules' => [
            [
                'title' => 'Networking Fundamentals',
                'description' => 'Core networking concepts',
                'lessons' => [
                    ['title' => 'Introduction to Networking', 'duration' => 20, 'content' => '<h2>Network Basics</h2><p>What is a network and how data travels.</p>'],
                    ['title' => 'OSI Model', 'duration' => 35, 'content' => '<h2>OSI Layers</h2><p>Understanding the 7 layers of the OSI model.</p>'],
                    ['title' => 'TCP/IP Protocol Suite', 'duration' => 35, 'content' => '<h2>TCP/IP</h2><p>Internet protocol fundamentals.</p>'],
                ]
            ],
            [
                'title' => 'IP Addressing',
                'description' => 'IP addressing and subnetting',
                'lessons' => [
                    ['title' => 'IPv4 Addressing', 'duration' => 30, 'content' => '<h2>IPv4</h2><p>IP address classes, private vs public addresses.</p>'],
                    ['title' => 'Subnetting', 'duration' => 45, 'content' => '<h2>Subnet Mastery</h2><p>Subnet masks, CIDR, and calculations.</p>'],
                    ['title' => 'IPv6 Fundamentals', 'duration' => 30, 'content' => '<h2>IPv6</h2><p>Next generation IP addressing.</p>'],
                ]
            ],
            [
                'title' => 'Network Devices',
                'description' => 'Switches, routers, and configuration',
                'lessons' => [
                    ['title' => 'Network Hardware', 'duration' => 25, 'content' => '<h2>Network Devices</h2><p>Hubs, switches, routers, and firewalls.</p>'],
                    ['title' => 'Switch Configuration', 'duration' => 40, 'content' => '<h2>Layer 2 Switching</h2><p>VLANs, trunking, and switch management.</p>'],
                    ['title' => 'Router Configuration', 'duration' => 45, 'content' => '<h2>Routing</h2><p>Static and dynamic routing configuration.</p>'],
                ]
            ],
            [
                'title' => 'Network Services',
                'description' => 'Essential network services',
                'lessons' => [
                    ['title' => 'DHCP and DNS', 'duration' => 35, 'content' => '<h2>Core Services</h2><p>Dynamic addressing and name resolution.</p>'],
                    ['title' => 'NAT and PAT', 'duration' => 30, 'content' => '<h2>Address Translation</h2><p>Network and port address translation.</p>'],
                    ['title' => 'Network Troubleshooting', 'duration' => 40, 'content' => '<h2>Troubleshooting</h2><p>Tools and techniques for network issues.</p>'],
                ]
            ],
        ]
    ],
    
    // Course 11: Computer Hardware
    11 => [
        'modules' => [
            [
                'title' => 'Computer Components',
                'description' => 'Understanding PC hardware',
                'lessons' => [
                    ['title' => 'PC Components Overview', 'duration' => 25, 'content' => '<h2>Hardware Components</h2><p>CPU, RAM, storage, and motherboard basics.</p>'],
                    ['title' => 'Processors Deep Dive', 'duration' => 35, 'content' => '<h2>CPUs</h2><p>CPU architecture, cores, threads, and specifications.</p>'],
                    ['title' => 'Memory and Storage', 'duration' => 35, 'content' => '<h2>RAM & Storage</h2><p>DDR memory, SSDs, HDDs, and NVMe.</p>'],
                ]
            ],
            [
                'title' => 'PC Assembly',
                'description' => 'Building a computer from scratch',
                'lessons' => [
                    ['title' => 'Component Selection', 'duration' => 30, 'content' => '<h2>Choosing Parts</h2><p>Compatibility and building a parts list.</p>'],
                    ['title' => 'Assembly Process', 'duration' => 50, 'content' => '<h2>Building the PC</h2><p>Step-by-step PC assembly guide.</p>'],
                    ['title' => 'BIOS and OS Installation', 'duration' => 35, 'content' => '<h2>Initial Setup</h2><p>BIOS configuration and OS installation.</p>'],
                ]
            ],
            [
                'title' => 'Troubleshooting',
                'description' => 'Diagnosing hardware problems',
                'lessons' => [
                    ['title' => 'Troubleshooting Methodology', 'duration' => 25, 'content' => '<h2>Problem Solving</h2><p>Systematic approach to troubleshooting.</p>'],
                    ['title' => 'Common Hardware Issues', 'duration' => 40, 'content' => '<h2>Common Problems</h2><p>Boot failures, overheating, and failures.</p>'],
                    ['title' => 'Diagnostic Tools', 'duration' => 30, 'content' => '<h2>Hardware Diagnostics</h2><p>Using diagnostic software and tools.</p>'],
                ]
            ],
            [
                'title' => 'Maintenance and Upgrades',
                'description' => 'Keeping systems running',
                'lessons' => [
                    ['title' => 'Preventive Maintenance', 'duration' => 25, 'content' => '<h2>Maintenance</h2><p>Cleaning, thermal paste, and care.</p>'],
                    ['title' => 'Upgrading Components', 'duration' => 35, 'content' => '<h2>Upgrades</h2><p>RAM, storage, and GPU upgrades.</p>'],
                    ['title' => 'Performance Optimization', 'duration' => 30, 'content' => '<h2>Optimization</h2><p>Overclocking and performance tuning.</p>'],
                ]
            ],
        ]
    ],
    
    // Course 12: Digital Literacy
    12 => [
        'modules' => [
            [
                'title' => 'Computer Basics',
                'description' => 'Getting started with computers',
                'lessons' => [
                    ['title' => 'What is a Computer?', 'duration' => 15, 'content' => '<h2>Computer Basics</h2><p>Understanding computers and their components.</p>'],
                    ['title' => 'Operating System Basics', 'duration' => 20, 'content' => '<h2>Using Windows/Mac</h2><p>Desktop, files, and basic operations.</p>'],
                    ['title' => 'Keyboard and Mouse Skills', 'duration' => 20, 'content' => '<h2>Input Devices</h2><p>Typing, shortcuts, and mouse techniques.</p>'],
                ]
            ],
            [
                'title' => 'Internet and Email',
                'description' => 'Using the internet safely',
                'lessons' => [
                    ['title' => 'Introduction to the Internet', 'duration' => 15, 'content' => '<h2>Internet Basics</h2><p>What is the internet and how to access it.</p>'],
                    ['title' => 'Web Browsing', 'duration' => 20, 'content' => '<h2>Using Web Browsers</h2><p>Searching, bookmarks, and browsing tips.</p>'],
                    ['title' => 'Email Essentials', 'duration' => 25, 'content' => '<h2>Email Skills</h2><p>Creating, sending, and managing emails.</p>'],
                ]
            ],
            [
                'title' => 'Online Safety',
                'description' => 'Staying safe online',
                'lessons' => [
                    ['title' => 'Password Security', 'duration' => 20, 'content' => '<h2>Strong Passwords</h2><p>Creating and managing secure passwords.</p>'],
                    ['title' => 'Recognizing Scams', 'duration' => 25, 'content' => '<h2>Online Threats</h2><p>Identifying phishing and online scams.</p>'],
                    ['title' => 'Privacy Settings', 'duration' => 20, 'content' => '<h2>Protecting Privacy</h2><p>Managing privacy on social media and websites.</p>'],
                ]
            ],
            [
                'title' => 'Productivity Tools',
                'description' => 'Essential digital tools',
                'lessons' => [
                    ['title' => 'Word Processing', 'duration' => 25, 'content' => '<h2>Document Creation</h2><p>Creating and formatting documents.</p>'],
                    ['title' => 'Spreadsheets Basics', 'duration' => 30, 'content' => '<h2>Spreadsheet Skills</h2><p>Basic calculations and data organization.</p>'],
                    ['title' => 'Cloud Storage', 'duration' => 20, 'content' => '<h2>Cloud Services</h2><p>Google Drive, OneDrive, and file sharing.</p>'],
                ]
            ],
        ]
    ],
    
    // Course 13: Graphic Design & Digital Arts
    13 => [
        'modules' => [
            [
                'title' => 'Design Fundamentals',
                'description' => 'Core design principles',
                'lessons' => [
                    ['title' => 'Elements of Design', 'duration' => 25, 'content' => '<h2>Design Elements</h2><p>Line, shape, color, texture, and space.</p>'],
                    ['title' => 'Principles of Design', 'duration' => 30, 'content' => '<h2>Design Principles</h2><p>Balance, contrast, hierarchy, and unity.</p>'],
                    ['title' => 'Color Theory', 'duration' => 35, 'content' => '<h2>Understanding Color</h2><p>Color wheel, schemes, and psychology.</p>'],
                    ['title' => 'Typography Basics', 'duration' => 30, 'content' => '<h2>Typography</h2><p>Fonts, pairing, and text design.</p>'],
                ]
            ],
            [
                'title' => 'Adobe Photoshop',
                'description' => 'Photo editing and manipulation',
                'lessons' => [
                    ['title' => 'Photoshop Interface', 'duration' => 25, 'content' => '<h2>Getting Started</h2><p>Workspace, tools, and panels.</p>'],
                    ['title' => 'Layers and Masks', 'duration' => 40, 'content' => '<h2>Working with Layers</h2><p>Layer management and masking techniques.</p>'],
                    ['title' => 'Photo Retouching', 'duration' => 45, 'content' => '<h2>Image Editing</h2><p>Healing, cloning, and enhancement tools.</p>'],
                    ['title' => 'Photo Compositing', 'duration' => 45, 'content' => '<h2>Compositing</h2><p>Combining images and creative effects.</p>'],
                ]
            ],
            [
                'title' => 'Adobe Illustrator',
                'description' => 'Vector graphics design',
                'lessons' => [
                    ['title' => 'Illustrator Basics', 'duration' => 30, 'content' => '<h2>Vector Graphics</h2><p>Understanding vectors and the interface.</p>'],
                    ['title' => 'Drawing Tools', 'duration' => 40, 'content' => '<h2>Creating Shapes</h2><p>Pen tool, shapes, and pathfinder.</p>'],
                    ['title' => 'Logo Design', 'duration' => 45, 'content' => '<h2>Logo Creation</h2><p>Designing professional logos.</p>'],
                ]
            ],
            [
                'title' => 'Brand Identity',
                'description' => 'Creating brand visuals',
                'lessons' => [
                    ['title' => 'Brand Strategy', 'duration' => 30, 'content' => '<h2>Branding Basics</h2><p>Understanding brand identity and strategy.</p>'],
                    ['title' => 'Logo and Visual Identity', 'duration' => 40, 'content' => '<h2>Visual Branding</h2><p>Creating cohesive brand visuals.</p>'],
                    ['title' => 'Brand Guidelines', 'duration' => 35, 'content' => '<h2>Style Guides</h2><p>Creating brand style guidelines.</p>'],
                ]
            ],
        ]
    ],
    
    // Course 14: Video Editing & Production
    14 => [
        'modules' => [
            [
                'title' => 'Video Production Basics',
                'description' => 'Introduction to video production',
                'lessons' => [
                    ['title' => 'Video Production Overview', 'duration' => 20, 'content' => '<h2>Getting Started</h2><p>Understanding the video production workflow.</p>'],
                    ['title' => 'Camera Basics', 'duration' => 30, 'content' => '<h2>Filming Techniques</h2><p>Composition, lighting, and camera settings.</p>'],
                    ['title' => 'Audio for Video', 'duration' => 25, 'content' => '<h2>Sound Recording</h2><p>Capturing quality audio for video.</p>'],
                ]
            ],
            [
                'title' => 'Adobe Premiere Pro',
                'description' => 'Professional video editing',
                'lessons' => [
                    ['title' => 'Premiere Pro Interface', 'duration' => 25, 'content' => '<h2>Getting Started</h2><p>Workspace, panels, and project setup.</p>'],
                    ['title' => 'Basic Editing', 'duration' => 40, 'content' => '<h2>Editing Fundamentals</h2><p>Cutting, trimming, and sequencing clips.</p>'],
                    ['title' => 'Transitions and Effects', 'duration' => 35, 'content' => '<h2>Adding Effects</h2><p>Transitions, filters, and visual effects.</p>'],
                    ['title' => 'Audio Editing', 'duration' => 30, 'content' => '<h2>Audio in Premiere</h2><p>Audio mixing, levels, and effects.</p>'],
                ]
            ],
            [
                'title' => 'Color Grading',
                'description' => 'Professional color correction',
                'lessons' => [
                    ['title' => 'Color Theory for Video', 'duration' => 25, 'content' => '<h2>Color in Video</h2><p>Understanding color in cinematography.</p>'],
                    ['title' => 'Color Correction', 'duration' => 40, 'content' => '<h2>Correcting Footage</h2><p>White balance, exposure, and correction.</p>'],
                    ['title' => 'Creative Color Grading', 'duration' => 40, 'content' => '<h2>Color Looks</h2><p>Creating cinematic color grades.</p>'],
                ]
            ],
            [
                'title' => 'Motion Graphics',
                'description' => 'After Effects basics',
                'lessons' => [
                    ['title' => 'After Effects Introduction', 'duration' => 30, 'content' => '<h2>Getting Started</h2><p>After Effects interface and workflow.</p>'],
                    ['title' => 'Animation Basics', 'duration' => 45, 'content' => '<h2>Keyframe Animation</h2><p>Creating animations with keyframes.</p>'],
                    ['title' => 'Text and Titles', 'duration' => 35, 'content' => '<h2>Motion Typography</h2><p>Animated text and title sequences.</p>'],
                    ['title' => 'Exporting and Rendering', 'duration' => 25, 'content' => '<h2>Final Output</h2><p>Export settings and rendering workflows.</p>'],
                ]
            ],
        ]
    ],
    
    // Course 15: Microsoft Office Suite
    15 => [
        'modules' => [
            [
                'title' => 'Microsoft Word',
                'description' => 'Document creation and formatting',
                'lessons' => [
                    ['title' => 'Word Interface', 'duration' => 15, 'content' => '<h2>Getting Started</h2><p>Word interface, ribbon, and navigation.</p>'],
                    ['title' => 'Document Formatting', 'duration' => 30, 'content' => '<h2>Formatting</h2><p>Fonts, paragraphs, styles, and themes.</p>'],
                    ['title' => 'Tables and Graphics', 'duration' => 30, 'content' => '<h2>Visual Elements</h2><p>Adding tables, images, and shapes.</p>'],
                    ['title' => 'Advanced Features', 'duration' => 35, 'content' => '<h2>Advanced Word</h2><p>Mail merge, templates, and collaboration.</p>'],
                ]
            ],
            [
                'title' => 'Microsoft Excel',
                'description' => 'Spreadsheets and data analysis',
                'lessons' => [
                    ['title' => 'Excel Basics', 'duration' => 25, 'content' => '<h2>Getting Started</h2><p>Cells, ranges, and basic operations.</p>'],
                    ['title' => 'Formulas and Functions', 'duration' => 45, 'content' => '<h2>Calculations</h2><p>Essential formulas: SUM, IF, VLOOKUP.</p>'],
                    ['title' => 'Charts and Graphs', 'duration' => 35, 'content' => '<h2>Data Visualization</h2><p>Creating charts and visual data.</p>'],
                    ['title' => 'Pivot Tables', 'duration' => 40, 'content' => '<h2>Data Analysis</h2><p>Pivot tables and data summarization.</p>'],
                ]
            ],
            [
                'title' => 'Microsoft PowerPoint',
                'description' => 'Creating presentations',
                'lessons' => [
                    ['title' => 'PowerPoint Basics', 'duration' => 20, 'content' => '<h2>Getting Started</h2><p>Slides, layouts, and themes.</p>'],
                    ['title' => 'Design Principles', 'duration' => 30, 'content' => '<h2>Effective Slides</h2><p>Creating professional presentations.</p>'],
                    ['title' => 'Animations and Transitions', 'duration' => 25, 'content' => '<h2>Adding Motion</h2><p>Animations, transitions, and timing.</p>'],
                    ['title' => 'Presenting Effectively', 'duration' => 25, 'content' => '<h2>Delivery Skills</h2><p>Presenter view and presentation tips.</p>'],
                ]
            ],
            [
                'title' => 'Microsoft Outlook & Teams',
                'description' => 'Communication and collaboration',
                'lessons' => [
                    ['title' => 'Outlook Email', 'duration' => 25, 'content' => '<h2>Email Management</h2><p>Inbox, folders, rules, and organization.</p>'],
                    ['title' => 'Calendar and Scheduling', 'duration' => 25, 'content' => '<h2>Time Management</h2><p>Calendar, meetings, and scheduling.</p>'],
                    ['title' => 'Microsoft Teams Basics', 'duration' => 30, 'content' => '<h2>Team Collaboration</h2><p>Teams, channels, and messaging.</p>'],
                    ['title' => 'Teams Meetings', 'duration' => 25, 'content' => '<h2>Virtual Meetings</h2><p>Video calls, screen sharing, and recording.</p>'],
                ]
            ],
        ]
    ],
];

// Insert modules and lessons
$totalModules = 0;
$totalLessons = 0;

// First, clean up any previously inserted modules/lessons for courses 2-15
$db->exec("DELETE FROM lessons WHERE module_id IN (SELECT id FROM modules WHERE course_id BETWEEN 2 AND 15)");
$db->exec("DELETE FROM modules WHERE course_id BETWEEN 2 AND 15");
echo "<p><em>Cleaned up any existing modules/lessons for courses 2-15</em></p>";

foreach ($coursesCurriculum as $courseId => $curriculum) {
    echo "<h2>Course $courseId</h2>";
    
    $orderIndex = 1;
    foreach ($curriculum['modules'] as $moduleData) {
        // Generate UUID for module
        $moduleUuid = sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
        
        // Insert module
        $stmt = $db->prepare("INSERT INTO modules (uuid, course_id, title, description, order_index, status, created_at) VALUES (?, ?, ?, ?, ?, 'published', NOW())");
        $stmt->execute([$moduleUuid, $courseId, $moduleData['title'], $moduleData['description'], $orderIndex]);
        $moduleId = $db->lastInsertId();
        $totalModules++;
        
        echo "<p>Module: {$moduleData['title']} (ID: $moduleId)</p>";
        
        // Insert lessons
        $lessonOrder = 1;
        foreach ($moduleData['lessons'] as $lessonData) {
            $uuid = sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                mt_rand(0, 0xffff), mt_rand(0, 0xffff),
                mt_rand(0, 0xffff),
                mt_rand(0, 0x0fff) | 0x4000,
                mt_rand(0, 0x3fff) | 0x8000,
                mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
            );
            
            $stmt = $db->prepare("INSERT INTO lessons (uuid, module_id, title, type, content, duration_minutes, order_index, ai_generated, created_at) VALUES (?, ?, ?, 'text', ?, ?, ?, 0, NOW())");
            $stmt->execute([
                $uuid,
                $moduleId, 
                $lessonData['title'], 
                $lessonData['content'],
                $lessonData['duration'],
                $lessonOrder
            ]);
            $totalLessons++;
            $lessonOrder++;
            
            echo "<p>&nbsp;&nbsp;- Lesson: {$lessonData['title']}</p>";
        }
        
        $orderIndex++;
    }
}

echo "<hr>";
echo "<h2>Summary</h2>";
echo "<p><strong>Total Modules Created:</strong> $totalModules</p>";
echo "<p><strong>Total Lessons Created:</strong> $totalLessons</p>";
echo "<p style='color: green; font-weight: bold;'>✅ All courses have been populated with modules and lessons!</p>";
