-- Seeder: Public Website Data
-- Description: Seeds services, testimonials, and initial project data
-- Date: 2025-01-11

-- Insert Services
INSERT INTO services (uuid, title, slug, short_description, description, icon, features, pricing_info, is_active, order_index) VALUES
(UUID(), 'Mobile & Web Application Development', 'mobile-web-development', 
'We create custom mobile apps (Android/iOS) and web applications tailored to meet the needs of businesses and individuals.',
'<p>At Nebatech, we specialize in developing cutting-edge mobile and web applications that drive business growth and enhance user experiences. Our team of expert developers uses the latest technologies and frameworks to build scalable, secure, and high-performance applications.</p>
<h3>Our Development Services Include:</h3>
<ul>
<li>Custom Android and iOS mobile applications</li>
<li>Progressive Web Applications (PWA)</li>
<li>Cross-platform mobile development (React Native, Flutter)</li>
<li>Enterprise web applications</li>
<li>E-commerce platforms</li>
<li>API development and integration</li>
<li>Cloud-based solutions</li>
</ul>
<h3>Technologies We Use:</h3>
<p>React, React Native, Flutter, Node.js, PHP, Python, Laravel, Vue.js, Angular, MySQL, MongoDB, PostgreSQL, AWS, Azure</p>',
'📱', 
'["Custom mobile apps for Android and iOS", "Responsive web applications", "Cross-platform development", "API integration", "Cloud deployment", "Ongoing maintenance and support"]',
'Contact us for a custom quote based on your project requirements',
TRUE, 1),

(UUID(), 'Website Design & Development', 'website-design', 
'We design and develop responsive and visually appealing websites, ensuring that they are user-friendly and fully optimized.',
'<p>Your website is often the first impression potential customers have of your business. We create stunning, professional websites that not only look great but also perform exceptionally well.</p>
<h3>Our Website Services Include:</h3>
<ul>
<li>Custom website design</li>
<li>Responsive and mobile-friendly layouts</li>
<li>Content Management Systems (WordPress, custom CMS)</li>
<li>E-commerce websites with payment integration</li>
<li>SEO optimization</li>
<li>Website maintenance and updates</li>
<li>Website hosting and domain management</li>
</ul>
<h3>Why Choose Our Website Services:</h3>
<ul>
<li>Modern, clean designs that reflect your brand</li>
<li>Fast loading times and optimized performance</li>
<li>SEO-friendly structure</li>
<li>Secure and reliable</li>
<li>Easy to manage and update</li>
</ul>',
'🌐', 
'["Responsive design", "SEO optimized", "Content Management System", "E-commerce integration", "Fast loading times", "Security features"]',
'Starting from GHS 2,000 for basic websites',
TRUE, 2),

(UUID(), 'POS System Development', 'pos-system-development', 
'We develop custom Point of Sale (POS) systems to streamline your business transactions and inventory management.',
'<p>Our custom POS systems are designed to help businesses manage sales, inventory, and customer data efficiently. Whether you run a retail store, restaurant, or service business, we can create a POS solution tailored to your needs.</p>
<h3>POS Features:</h3>
<ul>
<li>Sales transaction processing</li>
<li>Inventory management and tracking</li>
<li>Customer management and loyalty programs</li>
<li>Multiple payment methods (cash, card, mobile money)</li>
<li>Receipt printing and email receipts</li>
<li>Real-time reporting and analytics</li>
<li>Multi-location support</li>
<li>Employee management and permissions</li>
<li>Barcode scanning</li>
</ul>
<h3>Industries We Serve:</h3>
<p>Retail stores, restaurants, pharmacies, supermarkets, salons, service businesses</p>',
'💳', 
'["Custom POS development", "Inventory tracking", "Sales reporting", "Multiple payment methods", "Cloud-based or offline", "Receipt printing"]',
'Starting from GHS 3,500',
TRUE, 3),

(UUID(), 'Inventory Management System', 'inventory-management-system', 
'Our inventory management systems help you keep track of your stock levels, orders, sales, and deliveries efficiently.',
'<p>Take control of your inventory with our comprehensive inventory management solutions. Our systems help you reduce costs, prevent stockouts, and optimize your supply chain.</p>
<h3>Key Features:</h3>
<ul>
<li>Real-time inventory tracking</li>
<li>Stock level alerts and notifications</li>
<li>Purchase order management</li>
<li>Supplier management</li>
<li>Barcode and QR code generation</li>
<li>Multi-warehouse support</li>
<li>Sales and purchase history</li>
<li>Detailed reporting and analytics</li>
<li>Integration with POS systems</li>
<li>Mobile app access</li>
</ul>
<h3>Benefits:</h3>
<ul>
<li>Reduce inventory costs</li>
<li>Prevent stockouts and overstocking</li>
<li>Improve order accuracy</li>
<li>Save time on manual tracking</li>
<li>Make data-driven decisions</li>
</ul>',
'📦', 
'["Real-time tracking", "Stock alerts", "Barcode support", "Multi-warehouse", "Reporting", "Mobile access"]',
'Starting from GHS 4,000',
TRUE, 4),

(UUID(), 'Network Installation & Troubleshooting', 'network-services', 
'Nebatech offers professional network setup, installation, and troubleshooting services to keep your systems running smoothly.',
'<p>A reliable network infrastructure is essential for any modern business. Our network specialists provide comprehensive network solutions to ensure your business stays connected and productive.</p>
<h3>Network Services:</h3>
<ul>
<li>Network design and planning</li>
<li>LAN/WAN setup and configuration</li>
<li>WiFi installation and optimization</li>
<li>Network security implementation</li>
<li>Firewall configuration</li>
<li>VPN setup for remote access</li>
<li>Network troubleshooting and maintenance</li>
<li>Server installation and configuration</li>
<li>Cable installation (Cat5e, Cat6, Fiber)</li>
<li>Network monitoring and management</li>
</ul>
<h3>We Serve:</h3>
<p>Offices, schools, hotels, hospitals, retail stores, and residential properties</p>',
'🔌', 
'["Network design", "WiFi installation", "Security setup", "Troubleshooting", "Server configuration", "24/7 support"]',
'Contact for quote based on project scope',
TRUE, 5),

(UUID(), 'CCTV Camera Installation', 'cctv-installation', 
'We provide security solutions with the installation of CCTV cameras to ensure the safety of homes, businesses, and other premises.',
'<p>Protect your property with our professional CCTV installation services. We offer complete security camera solutions with high-quality equipment and expert installation.</p>
<h3>CCTV Services:</h3>
<ul>
<li>Security assessment and consultation</li>
<li>HD and 4K camera installation</li>
<li>Indoor and outdoor cameras</li>
<li>Night vision cameras</li>
<li>Motion detection and alerts</li>
<li>Remote viewing via mobile app</li>
<li>DVR/NVR setup and configuration</li>
<li>Cloud storage options</li>
<li>Maintenance and support</li>
</ul>
<h3>Camera Types:</h3>
<ul>
<li>Dome cameras</li>
<li>Bullet cameras</li>
<li>PTZ (Pan-Tilt-Zoom) cameras</li>
<li>IP cameras</li>
<li>Wireless cameras</li>
</ul>
<h3>Applications:</h3>
<p>Homes, offices, retail stores, warehouses, schools, hotels, parking lots</p>',
'📹', 
'["HD/4K cameras", "Remote viewing", "Night vision", "Motion detection", "Cloud storage", "Professional installation"]',
'Starting from GHS 1,500 for basic setup',
TRUE, 6),

(UUID(), 'iPhone & Laptop Repairs', 'device-repairs', 
'Our expert technicians offer repair services for iPhones and laptops, including hardware and software issues.',
'<p>Is your iPhone or laptop giving you trouble? Our certified technicians can diagnose and repair a wide range of hardware and software issues quickly and affordably.</p>
<h3>iPhone Repair Services:</h3>
<ul>
<li>Screen replacement</li>
<li>Battery replacement</li>
<li>Camera repair</li>
<li>Charging port repair</li>
<li>Water damage repair</li>
<li>Software troubleshooting</li>
<li>Data recovery</li>
</ul>
<h3>Laptop Repair Services:</h3>
<ul>
<li>Screen replacement</li>
<li>Keyboard replacement</li>
<li>Battery replacement</li>
<li>Hard drive/SSD upgrade</li>
<li>RAM upgrade</li>
<li>Motherboard repair</li>
<li>Virus removal and software issues</li>
<li>Data recovery</li>
<li>Overheating issues</li>
</ul>
<h3>Brands We Service:</h3>
<p>Apple, HP, Dell, Lenovo, Acer, Asus, Toshiba, Samsung, and more</p>',
'🔧', 
'["iPhone repairs", "Laptop repairs", "Screen replacement", "Battery replacement", "Data recovery", "Quick turnaround"]',
'Varies by repair type - Free diagnosis',
TRUE, 7);

-- Insert Testimonials
INSERT INTO testimonials (uuid, type, content, client_name, client_position, client_company, rating, is_featured, status) VALUES
(UUID(), 'general', 'Nebatech\'s innovative approach has revolutionized our learning experience. Their methods feel personalized and genuinely impactful.', 'Alhaj Dr. Tanko Mohammed', 'Education Specialist', NULL, 5, TRUE, 'active'),

(UUID(), 'general', 'Their commitment to excellence has been a game-changer for our construction projects – we now work with renewed passion.', 'Hamdu', 'Construction Manager', NULL, 5, TRUE, 'active'),

(UUID(), 'general', 'Professional and reliable – they helped us streamline our operations in ways that truly make a difference.', 'Idris Issah Galadima', 'Business Owner', NULL, 5, TRUE, 'active'),

(UUID(), 'general', 'The creative solutions provided have enhanced our brand image significantly. Their service feels personal and innovative.', 'Gladys Utesy', 'Marketing Director', NULL, 5, TRUE, 'active'),

(UUID(), 'general', 'Their expert services have given our business a competitive edge. We feel supported every step of the way.', 'Mitchell Kowalski', 'CEO', NULL, 5, TRUE, 'active'),

(UUID(), 'general', 'Outstanding service and excellent support at every turn. We truly feel they care about our success.', 'Alhaji Issah Yakubu', 'Business Executive', NULL, 5, TRUE, 'active'),

(UUID(), 'general', 'Their dedication to quality has transformed our educational outreach, making every project feel unique and tailored.', 'Florence Pul', 'Education Coordinator', NULL, 5, FALSE, 'active'),

(UUID(), 'general', 'Efficiency and reliability are at the heart of their service – they consistently deliver beyond expectations.', 'Rafic Fuseini', 'Operations Manager', NULL, 5, FALSE, 'active'),

(UUID(), 'general', 'Their innovative solutions have greatly improved our lab operations, making work smoother and more enjoyable.', 'Carolyn Puobebe', 'Lab Director', NULL, 5, FALSE, 'active'),

(UUID(), 'general', 'Nebatech\'s expertise has empowered our educational vision and given us a new perspective on growth.', 'Hajia Zulfawu Abdulai', 'School Administrator', NULL, 5, FALSE, 'active'),

(UUID(), 'general', 'Their commitment to customer satisfaction is truly unmatched, making every interaction feel personal and thoughtful.', 'Hajia Fadila Abdulai', 'Business Owner', NULL, 5, FALSE, 'active'),

(UUID(), 'general', 'Incredible service and a genuine dedication to quality – they make every project feel uniquely cared for.', 'Hajia Fati Sumani', 'Entrepreneur', NULL, 5, FALSE, 'active'),

(UUID(), 'general', 'Their visionary approach has truly propelled our business forward, inspiring us to achieve new heights.', 'Waltrude Kurugu', 'Business Leader', NULL, 5, FALSE, 'active');

-- Insert Sample Projects
INSERT INTO projects (uuid, title, slug, description, client_name, category, technologies, completion_date, is_featured, is_active) VALUES
(UUID(), 'Corporate Website Development', 'corporate-website-development', 
'Developed several corporate websites for businesses, ensuring they are responsive and user-friendly with modern design principles.',
'Various Clients', 'Web Development', 
'["HTML", "CSS", "JavaScript", "PHP", "MySQL", "Tailwind CSS"]',
'2024-12-01', TRUE, TRUE),

(UUID(), 'E-commerce Platform', 'ecommerce-platform', 
'Developed e-commerce platforms with integrated payment gateways for online shopping, inventory management, and order tracking.',
'Retail Business', 'E-commerce', 
'["PHP", "Laravel", "MySQL", "Stripe", "PayPal", "Vue.js"]',
'2024-11-15', TRUE, TRUE),

(UUID(), 'Custom Mobile Applications', 'custom-mobile-apps', 
'Built Android and iOS apps tailored to specific business needs, providing seamless user experiences and robust functionality.',
'Multiple Clients', 'Mobile Development', 
'["React Native", "Flutter", "Firebase", "Node.js"]',
'2024-10-20', TRUE, TRUE),

(UUID(), 'POS System for Retail', 'pos-system-retail', 
'Designed and implemented Point of Sale (POS) systems for local businesses, ensuring efficient transactions and accurate stock management.',
'Local Retail Stores', 'POS Systems', 
'["PHP", "MySQL", "JavaScript", "Receipt Printing API"]',
'2024-09-30', FALSE, TRUE),

(UUID(), 'Inventory Management Solution', 'inventory-management-solution', 
'Developed inventory tracking solutions to help businesses manage their stock, sales, and orders effectively with real-time updates.',
'Wholesale Business', 'Inventory Management', 
'["PHP", "Laravel", "MySQL", "Barcode Scanner Integration"]',
'2024-08-15', FALSE, TRUE),

(UUID(), 'CCTV Security System', 'cctv-security-system', 
'Installed and set up CCTV systems for various clients, ensuring their homes and businesses are secure with remote monitoring capabilities.',
'Various Clients', 'Security Systems', 
'["IP Cameras", "DVR/NVR", "Mobile App Integration"]',
'2024-07-10', FALSE, TRUE),

(UUID(), 'Network Infrastructure Setup', 'network-infrastructure-setup', 
'Successfully completed the installation of network infrastructures for several businesses, ensuring reliable and secure internet connectivity.',
'Corporate Offices', 'Network Installation', 
'["Cat6 Cabling", "WiFi Access Points", "Firewall", "VPN"]',
'2024-06-20', FALSE, TRUE),

(UUID(), 'Barcode Generator System', 'barcode-generator-truandrew', 
'Developed a custom Barcode Generator system for Truandrew Natural Market to streamline product labeling and improve inventory management.',
'Truandrew Natural Market', 'Custom Software', 
'["PHP", "MySQL", "Barcode Generation Library", "PDF Export"]',
'2024-05-15', TRUE, TRUE),

(UUID(), 'AI-Based Business Solution', 'ai-business-solution', 
'Developed AI-based applications to help businesses integrate intelligent systems into their processes for enhanced efficiency and productivity.',
'Tech Startup', 'AI/ML', 
'["Python", "TensorFlow", "Flask", "MySQL", "OpenAI API"]',
'2024-04-10', TRUE, TRUE);
