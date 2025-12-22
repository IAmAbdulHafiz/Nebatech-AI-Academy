-- Update Frontend course with rich content
UPDATE courses SET 
    hero_subtitle = 'Build stunning, responsive user interfaces with HTML, CSS, JavaScript, and modern frameworks like React and Vue',
    technologies = '[{"level":"beginner","duration":"3-6 months","title":"Beginner Level","description":"Master the fundamentals of web development","skills":["HTML5","CSS3","JavaScript Basics","Responsive Design","Git and GitHub"]},{"level":"intermediate","duration":"4-8 months","title":"Intermediate Level","description":"Build dynamic applications with modern JavaScript","skills":["ES6+","TypeScript","Tailwind CSS","Sass/SCSS","Webpack","API Integration"]},{"level":"advanced","duration":"6-12 months","title":"Advanced Level","description":"Master modern frameworks and advanced concepts","skills":["React.js","Vue.js","Angular","Next.js","State Management","Testing","Performance Optimization"]}]',
    skills_gained = '[{"icon":"fas fa-paint-brush","title":"UI/UX Design","description":"Create beautiful, user-friendly interfaces with modern design principles and accessibility standards.","color":"blue"},{"icon":"fas fa-mobile-alt","title":"Responsive Design","description":"Build websites that work seamlessly across all devices and screen sizes.","color":"green"},{"icon":"fab fa-react","title":"Modern Frameworks","description":"Master React, Vue, and Angular to build scalable single-page applications.","color":"purple"},{"icon":"fas fa-tachometer-alt","title":"Performance","description":"Optimize web applications for speed, efficiency, and excellent user experience.","color":"yellow"},{"icon":"fas fa-vial","title":"Testing","description":"Write unit, integration, and end-to-end tests to ensure code quality.","color":"red"},{"icon":"fas fa-code-branch","title":"Version Control","description":"Collaborate effectively using Git, GitHub, and modern development workflows.","color":"orange"}]',
    floating_icons = '["fas fa-code","fab fa-react","fab fa-html5","fab fa-css3-alt"]',
    original_price = 7020.00,
    success_rate = 95
WHERE slug = 'frontend';

-- Update Backend course with rich content
UPDATE courses SET 
    hero_subtitle = 'Master server-side development with Node.js, Python, databases, and API design',
    technologies = '[{"level":"beginner","duration":"3-6 months","title":"Beginner Level","description":"Learn programming fundamentals and web basics","skills":["Python Basics","Node.js","HTTP/REST","SQL Fundamentals","Git"]},{"level":"intermediate","duration":"4-8 months","title":"Intermediate Level","description":"Build robust server applications","skills":["Express.js","Django","PostgreSQL","MongoDB","Authentication","API Design"]},{"level":"advanced","duration":"6-12 months","title":"Advanced Level","description":"Master advanced backend patterns","skills":["Microservices","Docker","Redis","GraphQL","Cloud Deployment","Security"]}]',
    skills_gained = '[{"icon":"fas fa-server","title":"Server Architecture","description":"Design scalable and maintainable server-side applications.","color":"blue"},{"icon":"fas fa-database","title":"Database Design","description":"Master SQL and NoSQL databases for efficient data management.","color":"green"},{"icon":"fas fa-lock","title":"Security","description":"Implement authentication, authorization, and security best practices.","color":"purple"},{"icon":"fas fa-plug","title":"API Development","description":"Build RESTful and GraphQL APIs that power modern applications.","color":"yellow"},{"icon":"fas fa-cloud","title":"Cloud Services","description":"Deploy and manage applications on cloud platforms.","color":"red"},{"icon":"fas fa-cogs","title":"DevOps","description":"Implement CI/CD pipelines and containerization.","color":"orange"}]',
    floating_icons = '["fas fa-server","fab fa-node-js","fab fa-python","fas fa-database"]',
    original_price = 8900.00,
    success_rate = 94
WHERE slug = 'backend';

-- Update Full Stack course with rich content
UPDATE courses SET 
    hero_subtitle = 'Become a complete developer mastering both frontend and backend technologies',
    technologies = '[{"level":"beginner","duration":"4-8 months","title":"Foundation Level","description":"Master core web development skills","skills":["HTML5/CSS3","JavaScript","Python","SQL","Git","Command Line"]},{"level":"intermediate","duration":"6-10 months","title":"Application Level","description":"Build complete web applications","skills":["React.js","Node.js","Express","MongoDB","REST APIs","Authentication"]},{"level":"advanced","duration":"8-12 months","title":"Professional Level","description":"Master production-ready development","skills":["Next.js","TypeScript","Docker","AWS/Cloud","Testing","CI/CD"]}]',
    skills_gained = '[{"icon":"fas fa-layer-group","title":"Full Stack Architecture","description":"Design and build complete web applications from frontend to backend.","color":"blue"},{"icon":"fas fa-code","title":"Modern JavaScript","description":"Master ES6+, TypeScript, and modern JavaScript ecosystem.","color":"green"},{"icon":"fas fa-database","title":"Database Management","description":"Work with SQL and NoSQL databases efficiently.","color":"purple"},{"icon":"fas fa-cloud","title":"Cloud Deployment","description":"Deploy applications to cloud platforms like AWS and Vercel.","color":"yellow"},{"icon":"fas fa-shield-alt","title":"Security","description":"Implement secure authentication and protect against vulnerabilities.","color":"red"},{"icon":"fas fa-rocket","title":"Performance","description":"Optimize applications for speed and scalability.","color":"orange"}]',
    floating_icons = '["fas fa-code","fab fa-react","fab fa-node-js","fas fa-database"]',
    original_price = 15000.00,
    success_rate = 96
WHERE slug = 'fullstack';

-- Update AI course
UPDATE courses SET 
    hero_subtitle = 'Master artificial intelligence and machine learning to build intelligent systems',
    technologies = '[{"level":"beginner","duration":"3-5 months","title":"Foundation","description":"Learn Python and ML basics","skills":["Python","NumPy","Pandas","Data Visualization","Statistics"]},{"level":"intermediate","duration":"4-6 months","title":"Core ML","description":"Master machine learning algorithms","skills":["Scikit-learn","Supervised Learning","Unsupervised Learning","Feature Engineering","Model Evaluation"]},{"level":"advanced","duration":"6-9 months","title":"Deep Learning","description":"Build neural networks and AI systems","skills":["TensorFlow","PyTorch","CNNs","RNNs","NLP","Computer Vision"]}]',
    skills_gained = '[{"icon":"fas fa-brain","title":"Machine Learning","description":"Build predictive models using various ML algorithms.","color":"blue"},{"icon":"fas fa-robot","title":"Deep Learning","description":"Create neural networks for complex AI tasks.","color":"green"},{"icon":"fas fa-language","title":"NLP","description":"Process and understand human language.","color":"purple"},{"icon":"fas fa-eye","title":"Computer Vision","description":"Analyze and understand images and videos.","color":"yellow"},{"icon":"fas fa-chart-line","title":"Data Analysis","description":"Extract insights from complex datasets.","color":"red"},{"icon":"fas fa-project-diagram","title":"ML Ops","description":"Deploy and maintain ML models in production.","color":"orange"}]',
    floating_icons = '["fas fa-brain","fas fa-robot","fab fa-python","fas fa-network-wired"]',
    original_price = 12000.00,
    success_rate = 93
WHERE slug = 'ai';

-- Update Data Science course
UPDATE courses SET 
    hero_subtitle = 'Transform data into actionable insights with statistical analysis and visualization',
    technologies = '[{"level":"beginner","duration":"2-4 months","title":"Data Foundations","description":"Learn data manipulation basics","skills":["Python","SQL","Excel","Statistics","Data Cleaning"]},{"level":"intermediate","duration":"4-6 months","title":"Analysis and Viz","description":"Master analysis and visualization","skills":["Pandas","Matplotlib","Seaborn","Tableau","Statistical Analysis","Hypothesis Testing"]},{"level":"advanced","duration":"5-8 months","title":"Advanced Analytics","description":"Apply advanced techniques","skills":["Machine Learning","Big Data","Spark","A/B Testing","Predictive Modeling","Business Intelligence"]}]',
    skills_gained = '[{"icon":"fas fa-chart-bar","title":"Data Visualization","description":"Create compelling visualizations that tell data stories.","color":"blue"},{"icon":"fas fa-calculator","title":"Statistical Analysis","description":"Apply statistical methods to extract insights.","color":"green"},{"icon":"fas fa-database","title":"Data Management","description":"Handle large datasets efficiently.","color":"purple"},{"icon":"fas fa-lightbulb","title":"Business Intelligence","description":"Transform data into business decisions.","color":"yellow"},{"icon":"fab fa-python","title":"Python for Data","description":"Master Python data science libraries.","color":"red"},{"icon":"fas fa-cogs","title":"ETL Processes","description":"Build data pipelines and workflows.","color":"orange"}]',
    floating_icons = '["fas fa-chart-line","fas fa-database","fab fa-python","fas fa-calculator"]',
    original_price = 15000.00,
    success_rate = 94
WHERE slug = 'data-science';

-- Update Mobile Development course
UPDATE courses SET 
    hero_subtitle = 'Build native and cross-platform mobile applications for iOS and Android',
    technologies = '[{"level":"beginner","duration":"2-4 months","title":"Mobile Basics","description":"Learn mobile development fundamentals","skills":["JavaScript","React Native Basics","UI Components","Navigation","Styling"]},{"level":"intermediate","duration":"3-5 months","title":"App Development","description":"Build complete mobile apps","skills":["State Management","APIs","Local Storage","Push Notifications","Device Features"]},{"level":"advanced","duration":"4-6 months","title":"Production Apps","description":"Master production deployment","skills":["Performance Optimization","Testing","App Store Publishing","CI/CD","Analytics"]}]',
    skills_gained = '[{"icon":"fas fa-mobile-alt","title":"Cross-Platform Dev","description":"Build apps that work on both iOS and Android.","color":"blue"},{"icon":"fab fa-react","title":"React Native","description":"Master the popular cross-platform framework.","color":"green"},{"icon":"fas fa-compass","title":"Navigation","description":"Implement complex navigation patterns.","color":"purple"},{"icon":"fas fa-bell","title":"Push Notifications","description":"Engage users with timely notifications.","color":"yellow"},{"icon":"fas fa-store","title":"App Publishing","description":"Launch apps to App Store and Play Store.","color":"red"},{"icon":"fas fa-tachometer-alt","title":"Performance","description":"Optimize apps for smooth user experience.","color":"orange"}]',
    floating_icons = '["fas fa-mobile-alt","fab fa-react","fab fa-apple","fab fa-android"]',
    original_price = 18000.00,
    success_rate = 92
WHERE slug = 'mobile';

-- Update Cybersecurity course
UPDATE courses SET 
    hero_subtitle = 'Protect systems and networks from cyber threats with ethical hacking skills',
    technologies = '[{"level":"beginner","duration":"2-4 months","title":"Security Fundamentals","description":"Learn security basics","skills":["Networking Basics","Linux","Security Concepts","Cryptography","Risk Assessment"]},{"level":"intermediate","duration":"3-5 months","title":"Offensive Security","description":"Master penetration testing","skills":["Kali Linux","Vulnerability Assessment","Web App Security","Network Attacks","Social Engineering"]},{"level":"advanced","duration":"4-6 months","title":"Advanced Security","description":"Advanced attack and defense","skills":["Malware Analysis","Incident Response","Forensics","Cloud Security","Red Team Ops"]}]',
    skills_gained = '[{"icon":"fas fa-shield-alt","title":"Network Security","description":"Secure networks from various attack vectors.","color":"blue"},{"icon":"fas fa-user-secret","title":"Ethical Hacking","description":"Think like a hacker to protect systems.","color":"green"},{"icon":"fas fa-bug","title":"Vulnerability Testing","description":"Identify and remediate security weaknesses.","color":"purple"},{"icon":"fas fa-lock","title":"Cryptography","description":"Implement encryption and secure communications.","color":"yellow"},{"icon":"fas fa-search","title":"Forensics","description":"Investigate security incidents and breaches.","color":"red"},{"icon":"fas fa-cloud","title":"Cloud Security","description":"Secure cloud infrastructure and applications.","color":"orange"}]',
    floating_icons = '["fas fa-shield-alt","fas fa-lock","fas fa-user-secret","fas fa-bug"]',
    original_price = 22000.00,
    success_rate = 91
WHERE slug = 'cybersecurity';

-- Update Cloud Computing course
UPDATE courses SET 
    hero_subtitle = 'Master cloud platforms and build scalable infrastructure on AWS, Azure, and GCP',
    technologies = '[{"level":"beginner","duration":"2-3 months","title":"Cloud Basics","description":"Understand cloud fundamentals","skills":["Cloud Concepts","AWS Basics","Virtual Machines","Storage","Networking"]},{"level":"intermediate","duration":"3-5 months","title":"Cloud Architecture","description":"Design cloud solutions","skills":["EC2","S3","RDS","Lambda","IAM","VPC"]},{"level":"advanced","duration":"4-6 months","title":"DevOps and Scale","description":"Master production cloud ops","skills":["Kubernetes","Terraform","CI/CD","Monitoring","Cost Optimization","Multi-Cloud"]}]',
    skills_gained = '[{"icon":"fab fa-aws","title":"AWS Mastery","description":"Build and deploy on Amazon Web Services.","color":"blue"},{"icon":"fas fa-cubes","title":"Containerization","description":"Master Docker and Kubernetes.","color":"green"},{"icon":"fas fa-network-wired","title":"Cloud Networking","description":"Design secure cloud network architectures.","color":"purple"},{"icon":"fas fa-infinity","title":"DevOps","description":"Implement CI/CD and infrastructure as code.","color":"yellow"},{"icon":"fas fa-chart-line","title":"Monitoring","description":"Monitor and optimize cloud resources.","color":"red"},{"icon":"fas fa-dollar-sign","title":"Cost Management","description":"Optimize cloud spending and resources.","color":"orange"}]',
    floating_icons = '["fab fa-aws","fab fa-docker","fas fa-cloud","fas fa-server"]',
    original_price = 20000.00,
    success_rate = 93
WHERE slug = 'cloud';

-- Update Database course
UPDATE courses SET 
    hero_subtitle = 'Design efficient databases and master SQL for data-driven applications',
    technologies = '[{"level":"beginner","duration":"1-2 months","title":"SQL Basics","description":"Learn database fundamentals","skills":["SQL Syntax","CRUD Operations","Data Types","Basic Queries","Filtering"]},{"level":"intermediate","duration":"2-3 months","title":"Advanced SQL","description":"Master complex queries","skills":["Joins","Subqueries","Aggregations","Indexes","Stored Procedures"]},{"level":"advanced","duration":"2-3 months","title":"Database Admin","description":"Manage production databases","skills":["Normalization","Optimization","Backup/Recovery","Security","Replication"]}]',
    skills_gained = '[{"icon":"fas fa-database","title":"Database Design","description":"Create normalized, efficient database schemas.","color":"blue"},{"icon":"fas fa-code","title":"SQL Mastery","description":"Write complex queries with confidence.","color":"green"},{"icon":"fas fa-tachometer-alt","title":"Optimization","description":"Tune databases for maximum performance.","color":"purple"},{"icon":"fas fa-shield-alt","title":"Security","description":"Protect data with proper security measures.","color":"yellow"},{"icon":"fas fa-sync","title":"Replication","description":"Set up high-availability database systems.","color":"red"},{"icon":"fas fa-tools","title":"Administration","description":"Manage and maintain production databases.","color":"orange"}]',
    floating_icons = '["fas fa-database","fas fa-table","fas fa-server","fas fa-key"]',
    original_price = 4500.00,
    success_rate = 96
WHERE slug = 'database';

-- Update Networking course
UPDATE courses SET 
    hero_subtitle = 'Build and manage computer networks with industry-standard protocols',
    technologies = '[{"level":"beginner","duration":"1-2 months","title":"Network Basics","description":"Understand networking fundamentals","skills":["OSI Model","TCP/IP","IP Addressing","Subnetting","Network Devices"]},{"level":"intermediate","duration":"2-3 months","title":"Network Config","description":"Configure network equipment","skills":["Routing","Switching","VLANs","DHCP","DNS","Firewalls"]},{"level":"advanced","duration":"2-3 months","title":"Enterprise Networks","description":"Design enterprise solutions","skills":["WAN Technologies","VPNs","Network Security","Troubleshooting","Wireless Networks"]}]',
    skills_gained = '[{"icon":"fas fa-network-wired","title":"Network Design","description":"Design efficient and secure network topologies.","color":"blue"},{"icon":"fas fa-router","title":"Routing","description":"Configure routers and routing protocols.","color":"green"},{"icon":"fas fa-project-diagram","title":"Switching","description":"Manage switches and VLANs.","color":"purple"},{"icon":"fas fa-shield-alt","title":"Network Security","description":"Implement firewalls and security policies.","color":"yellow"},{"icon":"fas fa-wifi","title":"Wireless","description":"Deploy and manage wireless networks.","color":"red"},{"icon":"fas fa-tools","title":"Troubleshooting","description":"Diagnose and resolve network issues.","color":"orange"}]',
    floating_icons = '["fas fa-network-wired","fas fa-server","fas fa-wifi","fas fa-shield-alt"]',
    original_price = 5500.00,
    success_rate = 94
WHERE slug = 'networking';

-- Update Hardware course
UPDATE courses SET 
    hero_subtitle = 'Understand computer hardware components and troubleshoot system issues',
    technologies = '[{"level":"beginner","duration":"1-2 months","title":"Hardware Basics","description":"Learn component fundamentals","skills":["Computer Components","Motherboards","CPUs","RAM","Storage Devices"]},{"level":"intermediate","duration":"1-2 months","title":"Assembly","description":"Build and upgrade computers","skills":["PC Assembly","BIOS/UEFI","Peripheral Devices","Power Supply","Cooling Systems"]},{"level":"advanced","duration":"1-2 months","title":"Troubleshooting","description":"Diagnose and repair systems","skills":["Diagnostics","Hardware Repair","Preventive Maintenance","Data Recovery","Performance Tuning"]}]',
    skills_gained = '[{"icon":"fas fa-microchip","title":"Components","description":"Understand all computer hardware components.","color":"blue"},{"icon":"fas fa-tools","title":"Assembly","description":"Build computers from scratch.","color":"green"},{"icon":"fas fa-wrench","title":"Repair","description":"Diagnose and fix hardware issues.","color":"purple"},{"icon":"fas fa-hdd","title":"Storage","description":"Manage storage devices and data.","color":"yellow"},{"icon":"fas fa-bolt","title":"Power Systems","description":"Understand power requirements and UPS.","color":"red"},{"icon":"fas fa-thermometer-half","title":"Cooling","description":"Implement proper cooling solutions.","color":"orange"}]',
    floating_icons = '["fas fa-microchip","fas fa-memory","fas fa-hdd","fas fa-desktop"]',
    original_price = 2800.00,
    success_rate = 97
WHERE slug = 'hardware';

-- Update Digital Literacy course
UPDATE courses SET 
    hero_subtitle = 'Master essential computer skills for the digital age',
    technologies = '[{"level":"beginner","duration":"2-4 weeks","title":"Computer Basics","description":"Learn fundamental computer skills","skills":["Computer Operations","File Management","Internet Basics","Email","Web Browsing"]},{"level":"intermediate","duration":"2-4 weeks","title":"Productivity","description":"Master productivity tools","skills":["Word Processing","Spreadsheets","Presentations","Cloud Storage","Online Collaboration"]},{"level":"advanced","duration":"2-4 weeks","title":"Digital Citizenship","description":"Navigate the digital world safely","skills":["Online Safety","Privacy","Digital Communication","Social Media","Information Literacy"]}]',
    skills_gained = '[{"icon":"fas fa-desktop","title":"Computer Skills","description":"Operate computers with confidence.","color":"blue"},{"icon":"fas fa-globe","title":"Internet","description":"Navigate the web safely and effectively.","color":"green"},{"icon":"fas fa-envelope","title":"Communication","description":"Use email and digital communication tools.","color":"purple"},{"icon":"fas fa-shield-alt","title":"Online Safety","description":"Protect yourself from online threats.","color":"yellow"},{"icon":"fas fa-cloud","title":"Cloud Services","description":"Use cloud storage and online tools.","color":"red"},{"icon":"fas fa-users","title":"Collaboration","description":"Work with others using digital tools.","color":"orange"}]',
    floating_icons = '["fas fa-desktop","fas fa-keyboard","fas fa-mouse-pointer","fas fa-globe"]',
    original_price = 2000.00,
    success_rate = 98
WHERE slug = 'digital-literacy';

-- Update Graphic Design course
UPDATE courses SET 
    hero_subtitle = 'Create stunning visual designs with industry-standard tools and techniques',
    technologies = '[{"level":"beginner","duration":"1-2 months","title":"Design Basics","description":"Learn design fundamentals","skills":["Color Theory","Typography","Composition","Design Principles","Canva"]},{"level":"intermediate","duration":"2-3 months","title":"Adobe Suite","description":"Master professional tools","skills":["Photoshop","Illustrator","Brand Design","Logo Creation","Print Design"]},{"level":"advanced","duration":"2-3 months","title":"Professional Design","description":"Create professional-grade work","skills":["UI Design","Motion Graphics","3D Basics","Portfolio Building","Client Work"]}]',
    skills_gained = '[{"icon":"fas fa-palette","title":"Color Theory","description":"Master color selection and harmony.","color":"blue"},{"icon":"fas fa-font","title":"Typography","description":"Use fonts effectively in designs.","color":"green"},{"icon":"fab fa-adobe","title":"Adobe Tools","description":"Create with Photoshop and Illustrator.","color":"purple"},{"icon":"fas fa-vector-square","title":"Vector Graphics","description":"Design scalable vector artwork.","color":"yellow"},{"icon":"fas fa-id-card","title":"Branding","description":"Create cohesive brand identities.","color":"red"},{"icon":"fas fa-print","title":"Print Design","description":"Design for print and digital media.","color":"orange"}]',
    floating_icons = '["fas fa-palette","fas fa-pen-nib","fab fa-adobe","fas fa-bezier-curve"]',
    original_price = 3500.00,
    success_rate = 95
WHERE slug = 'graphic-design';

-- Update Video Editing course
UPDATE courses SET 
    hero_subtitle = 'Edit professional videos with modern techniques and software',
    technologies = '[{"level":"beginner","duration":"1-2 months","title":"Editing Basics","description":"Learn video editing fundamentals","skills":["Video Concepts","Basic Cuts","Timeline Editing","Audio Sync","Export Settings"]},{"level":"intermediate","duration":"2-3 months","title":"Professional Editing","description":"Master professional techniques","skills":["Adobe Premiere Pro","Color Correction","Transitions","Effects","Audio Editing"]},{"level":"advanced","duration":"2-3 months","title":"Advanced Production","description":"Create broadcast-quality content","skills":["Motion Graphics","Green Screen","Color Grading","Sound Design","Workflow Optimization"]}]',
    skills_gained = '[{"icon":"fas fa-video","title":"Video Editing","description":"Edit videos with professional software.","color":"blue"},{"icon":"fas fa-film","title":"Storytelling","description":"Tell compelling stories through video.","color":"green"},{"icon":"fas fa-adjust","title":"Color Grading","description":"Create cinematic color looks.","color":"purple"},{"icon":"fas fa-music","title":"Audio","description":"Mix and master audio for video.","color":"yellow"},{"icon":"fas fa-magic","title":"Effects","description":"Add visual effects and motion graphics.","color":"red"},{"icon":"fas fa-share-square","title":"Publishing","description":"Export and publish for various platforms.","color":"orange"}]',
    floating_icons = '["fas fa-video","fas fa-film","fas fa-cut","fab fa-youtube"]',
    original_price = 3200.00,
    success_rate = 94
WHERE slug = 'video-editing';

-- Update Microsoft Office course
UPDATE courses SET 
    hero_subtitle = 'Master Microsoft Office suite for professional productivity',
    technologies = '[{"level":"beginner","duration":"2-3 weeks","title":"Office Basics","description":"Learn essential Office skills","skills":["Word Basics","Excel Basics","PowerPoint Basics","Outlook","OneDrive"]},{"level":"intermediate","duration":"3-4 weeks","title":"Intermediate Skills","description":"Master productivity features","skills":["Advanced Word","Formulas and Functions","Presentation Design","Email Management","Collaboration"]},{"level":"advanced","duration":"3-4 weeks","title":"Power User","description":"Become an Office power user","skills":["Macros","Pivot Tables","Mail Merge","Templates","Integration"]}]',
    skills_gained = '[{"icon":"fas fa-file-word","title":"Word Processing","description":"Create professional documents with Word.","color":"blue"},{"icon":"fas fa-file-excel","title":"Spreadsheets","description":"Analyze data with Excel formulas and charts.","color":"green"},{"icon":"fas fa-file-powerpoint","title":"Presentations","description":"Design impactful presentations.","color":"purple"},{"icon":"fas fa-envelope","title":"Email","description":"Manage professional communications.","color":"yellow"},{"icon":"fas fa-users","title":"Collaboration","description":"Work together with Teams and SharePoint.","color":"red"},{"icon":"fas fa-chart-pie","title":"Data Analysis","description":"Create reports and analyze business data.","color":"orange"}]',
    floating_icons = '["fab fa-microsoft","fas fa-file-word","fas fa-file-excel","fas fa-file-powerpoint"]',
    original_price = 3800.00,
    success_rate = 97
WHERE slug = 'microsoft-office';
