-- Insert individual/sub-courses for each bundle
-- Frontend Development (parent_course_id = 1)
INSERT INTO courses (uuid, title, slug, description, level, duration_hours, price, status, approval_status, is_bundle, parent_course_id, card_color_from, card_color_to, card_modules, enrollment_count, review_count, rating, card_icon) VALUES
(UUID(), 'HTML & CSS Fundamentals', 'html-css-fundamentals', 'Learn the building blocks of web development with HTML5 and CSS3.', 'beginner', 40, 590.00, 'published', 'approved', 0, 1, 'from-orange-500', 'to-orange-600', 45, 3500, 2450, 5.00, 'fab fa-html5'),
(UUID(), 'JavaScript Essentials', 'javascript-essentials', 'Master JavaScript from basics to advanced concepts and ES6+ features.', 'beginner', 60, 950.00, 'published', 'approved', 0, 1, 'from-yellow-400', 'to-yellow-500', 65, 5200, 3120, 5.00, 'fab fa-js'),
(UUID(), 'React.js Complete Guide', 'react-js-complete-guide', 'Build powerful web applications with React, Hooks, and modern patterns.', 'intermediate', 80, 1550.00, 'published', 'approved', 0, 1, 'from-blue-500', 'to-blue-600', 95, 4800, 2890, 5.00, 'fab fa-react'),
(UUID(), 'Vue.js Mastery', 'vue-js-mastery', 'Learn Vue 3, Composition API, Vuex, and build modern SPAs.', 'intermediate', 70, 1430.00, 'published', 'approved', 0, 1, 'from-green-500', 'to-green-600', 82, 3200, 1940, 4.50, 'fab fa-vuejs'),
(UUID(), 'Tailwind CSS Fundamentals', 'tailwind-css-fundamentals', 'Build modern UIs rapidly with utility-first CSS framework.', 'intermediate', 35, 710.00, 'published', 'approved', 0, 1, 'from-blue-600', 'to-blue-700', 42, 2800, 2150, 5.00, 'fas fa-wind'),
(UUID(), 'Next.js Full Course', 'next-js-full-course', 'Build production-ready React apps with SSR, SSG, and API routes.', 'advanced', 90, 1790.00, 'published', 'approved', 0, 1, 'from-gray-800', 'to-black', 110, 2500, 1680, 5.00, 'fas fa-server');

-- Backend Development (parent_course_id = 2)
INSERT INTO courses (uuid, title, slug, description, level, duration_hours, price, status, approval_status, is_bundle, parent_course_id, card_color_from, card_color_to, card_modules, enrollment_count, review_count, rating, card_icon) VALUES
(UUID(), 'Node.js Fundamentals', 'nodejs-fundamentals', 'Learn server-side JavaScript with Node.js and build REST APIs.', 'beginner', 50, 890.00, 'published', 'approved', 0, 2, 'from-green-600', 'to-green-700', 55, 4200, 2800, 5.00, 'fab fa-node-js'),
(UUID(), 'Python for Backend', 'python-backend', 'Master Python programming for web development and automation.', 'beginner', 60, 950.00, 'published', 'approved', 0, 2, 'from-blue-500', 'to-yellow-500', 60, 5100, 3200, 5.00, 'fab fa-python'),
(UUID(), 'Express.js & MongoDB', 'express-mongodb', 'Build full-stack applications with Express.js and MongoDB.', 'intermediate', 55, 1100.00, 'published', 'approved', 0, 2, 'from-green-500', 'to-gray-700', 65, 3800, 2400, 4.80, 'fas fa-database'),
(UUID(), 'Django Web Framework', 'django-web-framework', 'Build robust web applications with Django and Python.', 'intermediate', 70, 1350.00, 'published', 'approved', 0, 2, 'from-green-800', 'to-green-600', 80, 3400, 2100, 4.90, 'fab fa-python'),
(UUID(), 'PostgreSQL & SQL Mastery', 'postgresql-sql-mastery', 'Master relational databases with PostgreSQL and advanced SQL.', 'intermediate', 45, 780.00, 'published', 'approved', 0, 2, 'from-blue-700', 'to-blue-500', 50, 2900, 1800, 4.70, 'fas fa-database'),
(UUID(), 'API Design & GraphQL', 'api-design-graphql', 'Design RESTful APIs and build GraphQL services.', 'advanced', 65, 1280.00, 'published', 'approved', 0, 2, 'from-pink-600', 'to-purple-600', 75, 2600, 1650, 4.80, 'fas fa-project-diagram');

-- Full Stack Development (parent_course_id = 3)
INSERT INTO courses (uuid, title, slug, description, level, duration_hours, price, status, approval_status, is_bundle, parent_course_id, card_color_from, card_color_to, card_modules, enrollment_count, review_count, rating, card_icon) VALUES
(UUID(), 'Web Development Foundations', 'web-dev-foundations', 'Learn HTML, CSS, and JavaScript fundamentals for web development.', 'beginner', 50, 850.00, 'published', 'approved', 0, 3, 'from-blue-500', 'to-blue-600', 55, 5500, 3400, 5.00, 'fas fa-code'),
(UUID(), 'React & Node.js Stack', 'react-nodejs-stack', 'Build full-stack applications with React and Node.js.', 'intermediate', 80, 1650.00, 'published', 'approved', 0, 3, 'from-blue-600', 'to-green-600', 90, 4200, 2700, 4.90, 'fab fa-react'),
(UUID(), 'Database Integration', 'database-integration', 'Connect applications to SQL and NoSQL databases.', 'intermediate', 45, 890.00, 'published', 'approved', 0, 3, 'from-purple-600', 'to-purple-700', 50, 3100, 1900, 4.80, 'fas fa-database'),
(UUID(), 'Authentication & Security', 'authentication-security', 'Implement secure user authentication and authorization.', 'intermediate', 40, 780.00, 'published', 'approved', 0, 3, 'from-red-600', 'to-red-700', 45, 2800, 1750, 4.90, 'fas fa-shield-alt'),
(UUID(), 'Deployment & DevOps', 'deployment-devops', 'Deploy applications to cloud platforms with CI/CD.', 'advanced', 55, 1100.00, 'published', 'approved', 0, 3, 'from-orange-600', 'to-orange-700', 60, 2400, 1500, 4.70, 'fas fa-cloud-upload-alt'),
(UUID(), 'Full Stack Project', 'fullstack-project', 'Build a complete full-stack application from scratch.', 'advanced', 80, 1550.00, 'published', 'approved', 0, 3, 'from-indigo-600', 'to-indigo-700', 25, 3200, 2100, 5.00, 'fas fa-laptop-code');

-- AI & Machine Learning (parent_course_id = 5)
INSERT INTO courses (uuid, title, slug, description, level, duration_hours, price, status, approval_status, is_bundle, parent_course_id, card_color_from, card_color_to, card_modules, enrollment_count, review_count, rating, card_icon) VALUES
(UUID(), 'Python for AI', 'python-for-ai', 'Master Python programming for AI and machine learning.', 'beginner', 50, 890.00, 'published', 'approved', 0, 5, 'from-blue-500', 'to-yellow-500', 55, 6200, 4100, 5.00, 'fab fa-python'),
(UUID(), 'Machine Learning Fundamentals', 'ml-fundamentals', 'Learn core ML algorithms and scikit-learn library.', 'intermediate', 70, 1350.00, 'published', 'approved', 0, 5, 'from-green-600', 'to-green-700', 80, 5100, 3200, 4.90, 'fas fa-brain'),
(UUID(), 'Deep Learning with TensorFlow', 'deep-learning-tensorflow', 'Build neural networks with TensorFlow and Keras.', 'intermediate', 80, 1550.00, 'published', 'approved', 0, 5, 'from-orange-600', 'to-orange-700', 90, 4500, 2800, 4.80, 'fas fa-network-wired'),
(UUID(), 'Natural Language Processing', 'nlp-course', 'Process and understand human language with NLP.', 'advanced', 65, 1280.00, 'published', 'approved', 0, 5, 'from-purple-600', 'to-purple-700', 70, 3200, 1950, 4.70, 'fas fa-language'),
(UUID(), 'Computer Vision', 'computer-vision', 'Build image recognition and object detection systems.', 'advanced', 70, 1380.00, 'published', 'approved', 0, 5, 'from-blue-700', 'to-blue-800', 75, 3400, 2100, 4.80, 'fas fa-eye'),
(UUID(), 'AI Project Portfolio', 'ai-project-portfolio', 'Build production-ready AI projects for your portfolio.', 'advanced', 65, 1250.00, 'published', 'approved', 0, 5, 'from-red-600', 'to-red-700', 30, 2800, 1800, 5.00, 'fas fa-robot');

-- Data Science (parent_course_id = 6)
INSERT INTO courses (uuid, title, slug, description, level, duration_hours, price, status, approval_status, is_bundle, parent_course_id, card_color_from, card_color_to, card_modules, enrollment_count, review_count, rating, card_icon) VALUES
(UUID(), 'Python for Data Science', 'python-data-science', 'Master Python, NumPy, and Pandas for data analysis.', 'beginner', 55, 950.00, 'published', 'approved', 0, 6, 'from-blue-500', 'to-blue-600', 60, 5800, 3600, 5.00, 'fab fa-python'),
(UUID(), 'Statistics & Probability', 'statistics-probability', 'Learn statistical methods for data analysis.', 'beginner', 45, 780.00, 'published', 'approved', 0, 6, 'from-green-600', 'to-green-700', 50, 4200, 2600, 4.80, 'fas fa-calculator'),
(UUID(), 'Data Visualization', 'data-visualization', 'Create compelling visualizations with Matplotlib and Seaborn.', 'intermediate', 40, 720.00, 'published', 'approved', 0, 6, 'from-purple-600', 'to-purple-700', 45, 4500, 2800, 4.90, 'fas fa-chart-bar'),
(UUID(), 'SQL for Data Analysis', 'sql-data-analysis', 'Query and analyze data with advanced SQL.', 'intermediate', 50, 890.00, 'published', 'approved', 0, 6, 'from-blue-700', 'to-blue-800', 55, 3900, 2400, 4.70, 'fas fa-database'),
(UUID(), 'Machine Learning for Data Science', 'ml-data-science', 'Apply ML algorithms to solve data problems.', 'advanced', 75, 1450.00, 'published', 'approved', 0, 6, 'from-orange-600', 'to-orange-700', 85, 4100, 2600, 4.80, 'fas fa-brain'),
(UUID(), 'Big Data with Spark', 'big-data-spark', 'Process large datasets with Apache Spark.', 'advanced', 60, 1180.00, 'published', 'approved', 0, 6, 'from-red-600', 'to-red-700', 65, 2700, 1700, 4.60, 'fas fa-fire');

-- Mobile App Development (parent_course_id = 7)
INSERT INTO courses (uuid, title, slug, description, level, duration_hours, price, status, approval_status, is_bundle, parent_course_id, card_color_from, card_color_to, card_modules, enrollment_count, review_count, rating, card_icon) VALUES
(UUID(), 'React Native Fundamentals', 'react-native-fundamentals', 'Build cross-platform mobile apps with React Native.', 'beginner', 55, 980.00, 'published', 'approved', 0, 7, 'from-blue-500', 'to-blue-600', 60, 4200, 2700, 5.00, 'fab fa-react'),
(UUID(), 'Mobile UI/UX Design', 'mobile-ui-ux', 'Design beautiful and intuitive mobile interfaces.', 'beginner', 40, 720.00, 'published', 'approved', 0, 7, 'from-pink-500', 'to-pink-600', 45, 3100, 1900, 4.80, 'fas fa-mobile-alt'),
(UUID(), 'State Management & APIs', 'state-management-apis', 'Manage app state and integrate with backend APIs.', 'intermediate', 50, 920.00, 'published', 'approved', 0, 7, 'from-green-600', 'to-green-700', 55, 2800, 1750, 4.70, 'fas fa-sync'),
(UUID(), 'Native Device Features', 'native-device-features', 'Access camera, GPS, notifications, and more.', 'intermediate', 45, 850.00, 'published', 'approved', 0, 7, 'from-purple-600', 'to-purple-700', 50, 2500, 1600, 4.80, 'fas fa-camera'),
(UUID(), 'App Store Deployment', 'app-store-deployment', 'Publish apps to iOS App Store and Google Play.', 'advanced', 35, 680.00, 'published', 'approved', 0, 7, 'from-gray-700', 'to-gray-800', 40, 2200, 1400, 4.60, 'fas fa-store'),
(UUID(), 'Mobile App Project', 'mobile-app-project', 'Build a complete mobile app from scratch.', 'advanced', 55, 1050.00, 'published', 'approved', 0, 7, 'from-indigo-600', 'to-indigo-700', 30, 2900, 1850, 5.00, 'fas fa-mobile');

-- Cybersecurity (parent_course_id = 8)
INSERT INTO courses (uuid, title, slug, description, level, duration_hours, price, status, approval_status, is_bundle, parent_course_id, card_color_from, card_color_to, card_modules, enrollment_count, review_count, rating, card_icon) VALUES
(UUID(), 'Networking & Security Basics', 'networking-security-basics', 'Learn networking fundamentals and security concepts.', 'beginner', 50, 890.00, 'published', 'approved', 0, 8, 'from-blue-600', 'to-blue-700', 55, 4500, 2900, 5.00, 'fas fa-network-wired'),
(UUID(), 'Linux Administration', 'linux-administration', 'Master Linux for security professionals.', 'beginner', 45, 780.00, 'published', 'approved', 0, 8, 'from-gray-700', 'to-gray-800', 50, 3800, 2400, 4.80, 'fab fa-linux'),
(UUID(), 'Ethical Hacking', 'ethical-hacking', 'Learn penetration testing and ethical hacking techniques.', 'intermediate', 70, 1380.00, 'published', 'approved', 0, 8, 'from-green-600', 'to-green-700', 80, 5200, 3300, 5.00, 'fas fa-user-secret'),
(UUID(), 'Web Application Security', 'web-app-security', 'Secure web applications from common vulnerabilities.', 'intermediate', 55, 1050.00, 'published', 'approved', 0, 8, 'from-red-600', 'to-red-700', 60, 3900, 2500, 4.90, 'fas fa-shield-alt'),
(UUID(), 'Incident Response & Forensics', 'incident-response-forensics', 'Investigate security incidents and perform forensics.', 'advanced', 60, 1180.00, 'published', 'approved', 0, 8, 'from-purple-600', 'to-purple-700', 65, 2800, 1750, 4.70, 'fas fa-search'),
(UUID(), 'Security Certifications Prep', 'security-cert-prep', 'Prepare for CompTIA Security+, CEH, and more.', 'advanced', 40, 750.00, 'published', 'approved', 0, 8, 'from-yellow-600', 'to-yellow-700', 45, 3200, 2100, 4.80, 'fas fa-certificate');

-- Cloud Computing (parent_course_id = 9)
INSERT INTO courses (uuid, title, slug, description, level, duration_hours, price, status, approval_status, is_bundle, parent_course_id, card_color_from, card_color_to, card_modules, enrollment_count, review_count, rating, card_icon) VALUES
(UUID(), 'Cloud Fundamentals', 'cloud-fundamentals', 'Understand cloud computing concepts and services.', 'beginner', 40, 720.00, 'published', 'approved', 0, 9, 'from-blue-500', 'to-blue-600', 45, 5100, 3200, 5.00, 'fas fa-cloud'),
(UUID(), 'AWS Core Services', 'aws-core-services', 'Master essential AWS services like EC2, S3, RDS.', 'intermediate', 65, 1280.00, 'published', 'approved', 0, 9, 'from-orange-500', 'to-orange-600', 75, 4800, 3100, 4.90, 'fab fa-aws'),
(UUID(), 'Docker & Containers', 'docker-containers', 'Containerize applications with Docker.', 'intermediate', 50, 950.00, 'published', 'approved', 0, 9, 'from-blue-600', 'to-blue-700', 55, 4200, 2700, 5.00, 'fab fa-docker'),
(UUID(), 'Kubernetes Orchestration', 'kubernetes-orchestration', 'Orchestrate containers at scale with Kubernetes.', 'advanced', 60, 1180.00, 'published', 'approved', 0, 9, 'from-blue-700', 'to-blue-800', 65, 3500, 2200, 4.80, 'fas fa-dharmachakra'),
(UUID(), 'Infrastructure as Code', 'infrastructure-as-code', 'Manage infrastructure with Terraform and CloudFormation.', 'advanced', 55, 1080.00, 'published', 'approved', 0, 9, 'from-purple-600', 'to-purple-700', 60, 2900, 1850, 4.70, 'fas fa-code'),
(UUID(), 'Cloud Architecture & Design', 'cloud-architecture-design', 'Design scalable and resilient cloud solutions.', 'advanced', 50, 980.00, 'published', 'approved', 0, 9, 'from-green-600', 'to-green-700', 55, 2600, 1650, 4.80, 'fas fa-sitemap');

-- Database Design & Administration (parent_course_id = 4)
INSERT INTO courses (uuid, title, slug, description, level, duration_hours, price, status, approval_status, is_bundle, parent_course_id, card_color_from, card_color_to, card_modules, enrollment_count, review_count, rating, card_icon) VALUES
(UUID(), 'SQL Fundamentals', 'sql-fundamentals', 'Learn SQL basics for querying and managing data.', 'beginner', 30, 520.00, 'published', 'approved', 0, 4, 'from-blue-500', 'to-blue-600', 35, 4200, 2700, 5.00, 'fas fa-database'),
(UUID(), 'Database Design Principles', 'database-design-principles', 'Design normalized and efficient database schemas.', 'intermediate', 35, 620.00, 'published', 'approved', 0, 4, 'from-green-600', 'to-green-700', 40, 3100, 1950, 4.80, 'fas fa-project-diagram'),
(UUID(), 'MySQL Administration', 'mysql-administration', 'Manage and optimize MySQL databases.', 'intermediate', 40, 720.00, 'published', 'approved', 0, 4, 'from-blue-700', 'to-blue-800', 45, 2800, 1750, 4.70, 'fas fa-server'),
(UUID(), 'MongoDB NoSQL', 'mongodb-nosql', 'Work with document databases using MongoDB.', 'intermediate', 35, 650.00, 'published', 'approved', 0, 4, 'from-green-500', 'to-green-600', 40, 2600, 1650, 4.80, 'fas fa-leaf');

-- Networking Engineering (parent_course_id = 10)
INSERT INTO courses (uuid, title, slug, description, level, duration_hours, price, status, approval_status, is_bundle, parent_course_id, card_color_from, card_color_to, card_modules, enrollment_count, review_count, rating, card_icon) VALUES
(UUID(), 'Network Fundamentals', 'network-fundamentals', 'Learn OSI model, TCP/IP, and networking basics.', 'beginner', 30, 520.00, 'published', 'approved', 0, 10, 'from-blue-500', 'to-blue-600', 35, 3200, 2050, 5.00, 'fas fa-network-wired'),
(UUID(), 'Router & Switch Configuration', 'router-switch-config', 'Configure Cisco routers and switches.', 'intermediate', 40, 720.00, 'published', 'approved', 0, 10, 'from-blue-700', 'to-blue-800', 45, 2500, 1600, 4.80, 'fas fa-server'),
(UUID(), 'Network Security Basics', 'network-security-basics', 'Implement firewalls and security policies.', 'intermediate', 35, 650.00, 'published', 'approved', 0, 10, 'from-red-600', 'to-red-700', 40, 2800, 1800, 4.90, 'fas fa-shield-alt');

-- Computer Hardware (parent_course_id = 11)
INSERT INTO courses (uuid, title, slug, description, level, duration_hours, price, status, approval_status, is_bundle, parent_course_id, card_color_from, card_color_to, card_modules, enrollment_count, review_count, rating, card_icon) VALUES
(UUID(), 'Computer Components', 'computer-components', 'Understand CPUs, RAM, storage, and peripherals.', 'beginner', 20, 350.00, 'published', 'approved', 0, 11, 'from-gray-600', 'to-gray-700', 25, 3800, 2450, 5.00, 'fas fa-microchip'),
(UUID(), 'PC Assembly & Building', 'pc-assembly-building', 'Build computers from scratch.', 'intermediate', 25, 450.00, 'published', 'approved', 0, 11, 'from-blue-600', 'to-blue-700', 30, 3200, 2100, 4.90, 'fas fa-desktop'),
(UUID(), 'Hardware Troubleshooting', 'hardware-troubleshooting', 'Diagnose and repair hardware issues.', 'intermediate', 30, 520.00, 'published', 'approved', 0, 11, 'from-red-600', 'to-red-700', 35, 2900, 1850, 4.80, 'fas fa-tools');

-- Digital Literacy (parent_course_id = 12)
INSERT INTO courses (uuid, title, slug, description, level, duration_hours, price, status, approval_status, is_bundle, parent_course_id, card_color_from, card_color_to, card_modules, enrollment_count, review_count, rating, card_icon) VALUES
(UUID(), 'Computer Basics', 'computer-basics', 'Learn to use a computer and operating systems.', 'beginner', 15, 250.00, 'published', 'approved', 0, 12, 'from-blue-500', 'to-blue-600', 20, 5200, 3400, 5.00, 'fas fa-desktop'),
(UUID(), 'Internet & Email', 'internet-email', 'Browse the web and use email effectively.', 'beginner', 12, 200.00, 'published', 'approved', 0, 12, 'from-green-500', 'to-green-600', 15, 4800, 3100, 4.90, 'fas fa-globe'),
(UUID(), 'Online Safety & Privacy', 'online-safety-privacy', 'Stay safe online and protect your privacy.', 'beginner', 15, 280.00, 'published', 'approved', 0, 12, 'from-red-600', 'to-red-700', 18, 4200, 2700, 5.00, 'fas fa-shield-alt');

-- Graphic Design & Digital Arts (parent_course_id = 13)
INSERT INTO courses (uuid, title, slug, description, level, duration_hours, price, status, approval_status, is_bundle, parent_course_id, card_color_from, card_color_to, card_modules, enrollment_count, review_count, rating, card_icon) VALUES
(UUID(), 'Design Fundamentals', 'design-fundamentals', 'Learn color theory, typography, and composition.', 'beginner', 25, 420.00, 'published', 'approved', 0, 13, 'from-pink-500', 'to-pink-600', 30, 3400, 2200, 5.00, 'fas fa-palette'),
(UUID(), 'Adobe Photoshop Mastery', 'photoshop-mastery', 'Master photo editing and manipulation.', 'intermediate', 40, 750.00, 'published', 'approved', 0, 13, 'from-blue-600', 'to-blue-700', 48, 3800, 2450, 4.90, 'fab fa-adobe'),
(UUID(), 'Adobe Illustrator', 'adobe-illustrator', 'Create vector graphics and illustrations.', 'intermediate', 35, 680.00, 'published', 'approved', 0, 13, 'from-orange-500', 'to-orange-600', 42, 3200, 2050, 4.80, 'fas fa-bezier-curve'),
(UUID(), 'Brand Identity Design', 'brand-identity-design', 'Design logos and complete brand identities.', 'advanced', 30, 580.00, 'published', 'approved', 0, 13, 'from-purple-600', 'to-purple-700', 35, 2600, 1700, 4.90, 'fas fa-id-card');

-- Video Editing & Production (parent_course_id = 14)
INSERT INTO courses (uuid, title, slug, description, level, duration_hours, price, status, approval_status, is_bundle, parent_course_id, card_color_from, card_color_to, card_modules, enrollment_count, review_count, rating, card_icon) VALUES
(UUID(), 'Video Editing Basics', 'video-editing-basics', 'Learn video editing fundamentals and workflows.', 'beginner', 25, 420.00, 'published', 'approved', 0, 14, 'from-red-500', 'to-red-600', 30, 3600, 2350, 5.00, 'fas fa-video'),
(UUID(), 'Adobe Premiere Pro', 'adobe-premiere-pro', 'Edit videos professionally with Premiere Pro.', 'intermediate', 45, 850.00, 'published', 'approved', 0, 14, 'from-purple-600', 'to-purple-700', 52, 3900, 2500, 4.90, 'fab fa-adobe'),
(UUID(), 'Color Grading & Effects', 'color-grading-effects', 'Master color correction and visual effects.', 'intermediate', 35, 680.00, 'published', 'approved', 0, 14, 'from-blue-600', 'to-blue-700', 40, 2800, 1800, 4.80, 'fas fa-adjust'),
(UUID(), 'Motion Graphics & After Effects', 'motion-graphics', 'Create stunning motion graphics and animations.', 'advanced', 50, 980.00, 'published', 'approved', 0, 14, 'from-indigo-600', 'to-indigo-700', 58, 2400, 1550, 4.70, 'fas fa-magic');

-- Microsoft Office Suite (parent_course_id = 15)
INSERT INTO courses (uuid, title, slug, description, level, duration_hours, price, status, approval_status, is_bundle, parent_course_id, card_color_from, card_color_to, card_modules, enrollment_count, review_count, rating, card_icon) VALUES
(UUID(), 'Microsoft Word Mastery', 'microsoft-word-mastery', 'Create professional documents with Word.', 'beginner', 20, 350.00, 'published', 'approved', 0, 15, 'from-blue-600', 'to-blue-700', 25, 4500, 2900, 5.00, 'fas fa-file-word'),
(UUID(), 'Microsoft Excel Complete', 'microsoft-excel-complete', 'Master spreadsheets, formulas, and data analysis.', 'intermediate', 40, 750.00, 'published', 'approved', 0, 15, 'from-green-600', 'to-green-700', 48, 5200, 3400, 5.00, 'fas fa-file-excel'),
(UUID(), 'Microsoft PowerPoint', 'microsoft-powerpoint', 'Design impactful presentations.', 'beginner', 18, 320.00, 'published', 'approved', 0, 15, 'from-orange-600', 'to-orange-700', 22, 3800, 2450, 4.90, 'fas fa-file-powerpoint'),
(UUID(), 'Microsoft Outlook & Teams', 'microsoft-outlook-teams', 'Manage email and collaborate with Teams.', 'beginner', 15, 280.00, 'published', 'approved', 0, 15, 'from-blue-500', 'to-blue-600', 18, 3200, 2050, 4.80, 'fas fa-envelope');
