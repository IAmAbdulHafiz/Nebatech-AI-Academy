<?php

namespace Nebatech\Controllers\Public;

use Nebatech\Core\Controller;
use Nebatech\Core\Database;

class ServiceController extends Controller
{
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    /**
     * Display all services
     */
    public function index()
    {
        $stmt = $this->db->prepare("
            SELECT * FROM services 
            WHERE status = 'active' 
            ORDER BY order_index ASC
        ");
        $stmt->execute();
        $services = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $this->view('public/services/index', [
            'title' => 'Our IT Services',
            'description' => 'Discover innovative IT solutions tailored to meet your business needs',
            'services' => $services
        ]);
    }

    /**
     * Display a single service
     */
    public function show($slug)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM services 
            WHERE slug = ? AND status = 'active'
        ");
        $stmt->execute([$slug]);
        $service = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$service) {
            http_response_code(404);
            return $this->view('errors/404', ['title' => 'Service Not Found']);
        }

        // Decode JSON fields
        if (isset($service['features'])) {
            $service['features'] = json_decode($service['features'], true);
        }

        // Get related services
        $stmt = $this->db->prepare("
            SELECT * FROM services 
            WHERE slug != ? AND status = 'active' 
            ORDER BY RAND() 
            LIMIT 3
        ");
        $stmt->execute([$slug]);
        $relatedServices = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $this->view('public/services/show', [
            'title' => $service['title'],
            'description' => $service['short_description'],
            'service' => $service,
            'relatedServices' => $relatedServices
        ]);
    }

    /**
     * Display service request form
     */
    public function requestQuote()
    {
        // Get all services for dropdown
        $stmt = $this->db->prepare("
            SELECT id, title FROM services 
            WHERE status = 'active' 
            ORDER BY title ASC
        ");
        $stmt->execute();
        $services = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $this->view('public/request-quote', [
            'title' => 'Request a Quote',
            'description' => 'Get a personalized quote for your IT service needs',
            'services' => $services
        ]);
    }

    /**
     * Handle service request submission
     */
    public function submitRequest()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/request-quote');
            return;
        }

        // Validate input
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $company = trim($_POST['company'] ?? '');
        $serviceId = $_POST['service_id'] ?? null;
        $message = trim($_POST['message'] ?? '');

        $errors = [];

        if (empty($name)) {
            $errors[] = 'Name is required';
        }

        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Valid email is required';
        }

        if (empty($message)) {
            $errors[] = 'Message is required';
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['form_data'] = $_POST;
            redirect('/request-quote');
            return;
        }

        try {
            // Generate UUID
            $uuid = $this->generateUuid();

            // Insert service request
            $stmt = $this->db->prepare("
                INSERT INTO service_requests 
                (uuid, service_id, name, email, phone, company, message, status, created_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, 'pending', NOW())
            ");
            
            $stmt->execute([
                $uuid,
                $serviceId ?: null,
                $name,
                $email,
                $phone,
                $company,
                $message
            ]);

            // TODO: Send email notification to admin

            $_SESSION['success'] = 'Thank you for your request! We will contact you shortly.';
            redirect('/request-quote');

        } catch (\Exception $e) {
            error_log('Service request error: ' . $e->getMessage());
            $_SESSION['errors'] = ['An error occurred. Please try again later.'];
            $_SESSION['form_data'] = $_POST;
            redirect('/request-quote');
        }
    }

    /**
     * Generate UUID v4
     */
    private function generateUuid()
    {
        $data = random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
}
