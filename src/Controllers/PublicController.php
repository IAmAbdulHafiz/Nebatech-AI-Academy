<?php

namespace Nebatech\Controllers;

use Nebatech\Core\Controller;
use Nebatech\Core\Database;

class PublicController extends Controller
{
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    /**
     * Display the homepage
     */
    public function home()
    {
        // Get featured services
        $stmt = $this->db->prepare("
            SELECT * FROM services 
            WHERE status = 'active' 
            ORDER BY order_index ASC 
            LIMIT 4
        ");
        $stmt->execute();
        $featuredServices = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // Get featured testimonials
        $stmt = $this->db->prepare("
            SELECT * FROM testimonials 
            WHERE status = 'active' AND is_featured = 1 
            ORDER BY created_at DESC 
            LIMIT 6
        ");
        $stmt->execute();
        $testimonials = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // Get stats
        $stats = [
            'students' => $this->getStudentCount(),
            'courses' => $this->getCourseCount(),
            'projects' => $this->getProjectCount(),
            'satisfaction' => 98
        ];

        return $this->view('public/home', [
            'title' => 'Nebatech Software Solution Ltd',
            'tagline' => 'Empowering businesses and individuals with cutting-edge technology solutions',
            'featuredServices' => $featuredServices,
            'testimonials' => $testimonials,
            'stats' => $stats
        ]);
    }

    /**
     * Display the about page
     */
    public function about()
    {
        return $this->view('public/about', [
            'title' => 'About Us',
            'description' => 'Learn about Nebatech Software Solution Ltd - our story, mission, vision, and team'
        ]);
    }

    /**
     * Display the projects portfolio page
     */
    public function projects()
    {
        // Get all projects
        $stmt = $this->db->prepare("
            SELECT p.*, pc.name as category_name, pc.slug as category_slug 
            FROM projects p
            LEFT JOIN project_categories pc ON p.category_id = pc.id
            WHERE p.is_active = 1 
            ORDER BY p.is_featured DESC, p.completion_date DESC
        ");
        $stmt->execute();
        $projects = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // Get unique categories
        $stmt = $this->db->prepare("
            SELECT DISTINCT pc.name, pc.slug FROM projects p
            JOIN project_categories pc ON p.category_id = pc.id
            WHERE p.is_active = 1 AND pc.is_active = 1
        ");
        $stmt->execute();
        $categories = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $this->view('public/projects', [
            'title' => 'Our Projects',
            'description' => 'Discover the innovative technology solutions we have delivered for businesses',
            'projects' => $projects,
            'categories' => $categories
        ]);
    }

    /**
     * Display the FAQ page
     */
    public function faq()
    {
        $faqs = [
            [
                'category' => 'Services',
                'questions' => [
                    [
                        'question' => 'What services does Nebatech Software Solution Ltd offer?',
                        'answer' => 'We offer Mobile & Web Application Development, Website Design & Development, Network Installation & Troubleshooting, CCTV Camera Installation, iPhone & Laptop Repairs, and Competency-Based Training Programs in AI, Development, and more.'
                    ],
                    [
                        'question' => 'How can I get started with Nebatech for a website or mobile app project?',
                        'answer' => 'You can get started by contacting us through our contact form, calling us at 024 763 6080, or emailing info@nebatech.com. We\'ll schedule a consultation to discuss your project requirements.'
                    ],
                    [
                        'question' => 'What is the cost of mobile or web application development?',
                        'answer' => 'The cost varies depending on the complexity, features, and timeline of your project. Contact us for a free quote tailored to your specific needs.'
                    ],
                    [
                        'question' => 'Do you provide custom software development solutions?',
                        'answer' => 'Yes, we specialize in custom software development tailored to meet your specific business needs and requirements.'
                    ]
                ]
            ],
            [
                'category' => 'Training Programmes',
                'questions' => [
                    [
                        'question' => 'What are competency-based training programs, and who can enroll?',
                        'answer' => 'Our competency-based training programs focus on practical skills and real-world applications. Anyone interested in developing IT skills can enroll, from beginners to professionals looking to upskill.'
                    ],
                    [
                        'question' => 'What types of IT training does Nebatech offer?',
                        'answer' => 'We offer training in AI & Machine Learning, Front-End Development, Back-End Development, Database Management, Microsoft Office, Video Editing, Graphic Design, Digital Literacy, and Hardware Repair.'
                    ],
                    [
                        'question' => 'How long does it take to complete a training program?',
                        'answer' => 'Program duration varies from 3 weeks to 20 weeks depending on the course. Each program page shows the specific duration and schedule.'
                    ]
                ]
            ],
            [
                'category' => 'General',
                'questions' => [
                    [
                        'question' => 'Do you provide support and maintenance after my project is completed?',
                        'answer' => 'Yes, we offer ongoing support and maintenance packages to ensure your systems continue to run smoothly after project completion.'
                    ],
                    [
                        'question' => 'What kind of businesses can benefit from Nebatech\'s services?',
                        'answer' => 'We work with businesses of all sizes across various industries including retail, education, healthcare, construction, and more. Our solutions are tailored to meet each client\'s unique needs.'
                    ],
                    [
                        'question' => 'How does Nebatech ensure the security of my data during project development?',
                        'answer' => 'We follow industry best practices for data security including encryption, secure coding practices, regular security audits, and compliance with data protection regulations.'
                    ],
                    [
                        'question' => 'How can I contact Nebatech for support or inquiries?',
                        'answer' => 'You can reach us by phone at 024 763 6080 or 020 678 9600, email us at info@nebatech.com, or visit our office in Choggu Yapalsi, Tamale, Northern Ghana.'
                    ]
                ]
            ]
        ];

        return $this->view('public/faq', [
            'title' => 'Frequently Asked Questions',
            'description' => 'Find answers to common questions about Nebatech and our services',
            'faqs' => $faqs
        ]);
    }

    /**
     * Helper method to get student count
     */
    private function getStudentCount()
    {
        $stmt = $this->db->query("SELECT COUNT(*) FROM users WHERE role = 'student'");
        return $stmt->fetchColumn();
    }

    /**
     * Helper method to get course count
     */
    private function getCourseCount()
    {
        $stmt = $this->db->query("SELECT COUNT(*) FROM courses WHERE status = 'published'");
        return $stmt->fetchColumn();
    }

    /**
     * Helper method to get project count
     */
    private function getProjectCount()
    {
        $stmt = $this->db->query("SELECT COUNT(*) FROM projects WHERE is_active = 1");
        return $stmt->fetchColumn() ?: 50; // Default to 50 if table doesn't exist yet
    }
}
