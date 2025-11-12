-- Sample Data for Unified Platform Integration
-- Populates services, testimonials, and cross-promotional content

-- Insert sample services
INSERT INTO services (title, slug, description, short_description, category_id, price_range, duration, features, is_featured, status) VALUES
('E-commerce Website Development', 'ecommerce-website-development', 
'Complete e-commerce solution with payment integration, inventory management, and admin dashboard. Built with modern technologies for scalability and performance.',
'Professional e-commerce website with payment integration and admin dashboard',
1, 'GHS 5,000 - 15,000', '4-8 weeks', 
'["Payment Gateway Integration", "Inventory Management", "Admin Dashboard", "Mobile Responsive", "SEO Optimized", "SSL Security"]',
1, 'active'),

('Mobile App Development', 'mobile-app-development',
'Custom mobile applications for iOS and Android using React Native. From concept to app store deployment with ongoing support.',
'Cross-platform mobile apps for iOS and Android',
2, 'GHS 8,000 - 25,000', '6-12 weeks',
'["Cross-platform Development", "App Store Deployment", "Push Notifications", "Offline Support", "Analytics Integration", "Maintenance Support"]',
1, 'active'),

('AI Chatbot Integration', 'ai-chatbot-integration',
'Intelligent chatbots for customer service automation using natural language processing and machine learning.',
'Smart chatbots for automated customer service',
3, 'GHS 3,000 - 10,000', '3-6 weeks',
'["Natural Language Processing", "Multi-platform Integration", "Learning Capabilities", "Analytics Dashboard", "24/7 Support"]',
1, 'active'),

('Digital Marketing Campaign', 'digital-marketing-campaign',
'Complete digital marketing strategy including SEO, social media marketing, content creation, and paid advertising.',
'Comprehensive digital marketing strategy and execution',
4, 'GHS 2,000 - 8,000', '2-6 months',
'["SEO Optimization", "Social Media Management", "Content Creation", "Paid Advertising", "Analytics & Reporting", "Brand Strategy"]',
0, 'active'),

('IT Consulting & Strategy', 'it-consulting-strategy',
'Technology consulting services to help businesses optimize their IT infrastructure and digital transformation.',
'Expert IT consulting for digital transformation',
5, 'GHS 1,500 - 5,000', '2-4 weeks',
'["Technology Assessment", "Digital Strategy", "Infrastructure Planning", "Security Audit", "Implementation Roadmap", "Ongoing Support"]',
0, 'active');

-- Insert sample testimonials
INSERT INTO testimonials (uuid, type, content, client_name, client_position, client_company, rating, related_id, is_featured, status) VALUES
(UUID(), 'course', 'The Full-Stack Web Development course completely transformed my career. I went from knowing nothing about programming to building complete web applications. The hands-on projects and expert guidance made all the difference. Now I work as a software developer at a tech company!', 'Kwame Asante', 'Software Developer', 'TechGhana Ltd', 5, 1, 1, 'active'),

(UUID(), 'service', 'Nebatech built our e-commerce platform and exceeded all expectations. The team was professional, delivered on time, and provided excellent ongoing support. Our online sales increased by 300% in the first quarter!', 'Akosua Mensah', 'CEO', 'Fashion Forward Ghana', 5, 1, 1, 'active'),

(UUID(), 'course', 'I completed the AI & Machine Learning program and it opened up so many opportunities. The curriculum was comprehensive and the instructors were incredibly knowledgeable. I now work on AI projects for international clients.', 'Ibrahim Mohammed', 'AI Specialist', 'DataTech Solutions', 5, 2, 1, 'active'),

(UUID(), 'service', 'The mobile app Nebatech developed for our business has been a game-changer. Customer engagement increased significantly, and the app works flawlessly on both iOS and Android. Highly recommended!', 'Grace Osei', 'Marketing Director', 'HealthPlus Clinics', 5, 2, 1, 'active'),

(UUID(), 'course', 'The Digital Marketing course gave me practical skills I use every day. From SEO to social media strategy, everything was covered in detail. I started my own digital marketing agency after completing the program.', 'Samuel Adjei', 'Founder', 'Digital Boost Agency', 5, 3, 1, 'active'),

(UUID(), 'service', 'Nebatech''s AI chatbot solution reduced our customer service workload by 60% while improving response times. The implementation was smooth and the results were immediate.', 'Fatima Abdul', 'Operations Manager', 'Customer Care Plus', 4, 3, 1, 'active'),

(UUID(), 'general', 'Nebatech offers the perfect combination of learning and professional services. I started as a student in their web development program and later hired them to build my company''s website. Both experiences were excellent!', 'Michael Owusu', 'Entrepreneur', 'StartUp Ghana', 5, NULL, 1, 'active'),

(UUID(), 'course', 'The Graphic Design program helped me transition from a completely different field into creative work. The portfolio projects were real-world focused and the feedback was invaluable.', 'Ama Darko', 'Graphic Designer', 'Creative Studios', 4, 4, 0, 'active'),

(UUID(), 'service', 'Our digital marketing campaign with Nebatech resulted in a 250% increase in website traffic and 180% growth in leads. Their strategic approach and execution were outstanding.', 'Joseph Nkrumah', 'Business Owner', 'Local Eats Restaurant', 5, 4, 0, 'active'),

(UUID(), 'course', 'The cybersecurity course was comprehensive and practical. I learned to identify and prevent security threats, which helped me secure a position as a cybersecurity analyst.', 'Abena Ofosu', 'Cybersecurity Analyst', 'SecureNet Ghana', 5, 5, 0, 'active');

-- Insert cross-promotional content
INSERT INTO cross_promotions (uuid, title, message, cta_text, cta_url, target_section, target_user_type, display_type, color_scheme, priority, is_active) VALUES
(UUID(), 'Master Web Development', 'Want to build websites yourself? Join our comprehensive web development program and learn from industry experts.', 'Start Learning', '/programmes/web-development', 'corporate', 'visitor', 'banner', 'blue', 1, 1),

(UUID(), 'Need Professional Development?', 'Focus on your business while our experts handle your technical projects. Get professional results without the learning curve.', 'View Services', '/services', 'academy', 'student', 'sidebar', 'green', 2, 1),

(UUID(), 'Apply Your Skills', 'Ready to work on real projects? Join our freelance network and apply your newly learned skills on professional projects.', 'Join Network', '/services/freelance', 'academy', 'student', 'inline', 'purple', 3, 1),

(UUID(), 'Learn AI & Machine Learning', 'Interested in artificial intelligence? Master AI and ML with our hands-on training program designed for beginners.', 'Explore AI Course', '/programmes/ai-machine-learning', 'corporate', 'visitor', 'banner', 'purple', 4, 1),

(UUID(), 'Expand Your Business', 'Take your business to the next level with our professional services. From web development to digital marketing.', 'Explore Services', '/services', 'academy', 'student', 'sidebar', 'orange', 5, 1),

(UUID(), 'Student Success Stories', 'See how our students transformed their careers and started successful businesses after completing our programs.', 'Read Stories', '/success-stories', 'corporate', 'visitor', 'inline', 'green', 6, 1);

-- Update some courses to link with services
UPDATE courses SET related_service_id = 1, service_description = 'Need a professional e-commerce website built? Our experts can create a custom solution for your business.' WHERE title LIKE '%Web Development%' LIMIT 1;

UPDATE courses SET related_service_id = 2, service_description = 'Want a mobile app for your business? Let our team build a professional mobile application.' WHERE title LIKE '%Mobile%' OR title LIKE '%App%' LIMIT 1;

UPDATE courses SET related_service_id = 3, service_description = 'Need AI solutions for your business? Our AI experts can implement custom solutions.' WHERE title LIKE '%AI%' OR title LIKE '%Machine Learning%' LIMIT 1;

-- Update some services to link with courses  
UPDATE services SET related_course_id = 1, course_description = 'Want to learn web development yourself? Master the skills with our comprehensive training program.' WHERE slug = 'ecommerce-website-development';

UPDATE services SET related_course_id = 2, course_description = 'Interested in mobile app development? Learn to build apps with our hands-on course.' WHERE slug = 'mobile-app-development';

UPDATE services SET related_course_id = 3, course_description = 'Want to understand AI and machine learning? Start with our beginner-friendly course.' WHERE slug = 'ai-chatbot-integration';
