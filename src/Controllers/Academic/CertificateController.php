<?php

namespace Nebatech\Controllers\Academic;

use Nebatech\Core\Controller;
use Nebatech\Services\CertificateService;
use Nebatech\Middleware\AuthMiddleware;

class CertificateController extends Controller
{
    private CertificateService $certificateService;

    public function __construct()
    {
        $this->certificateService = new CertificateService();
    }

    /**
     * Show user's certificates
     */
    public function myCertificates(): void
    {
        $userId = AuthMiddleware::userId();
        $user = \Nebatech\Models\User::findById($userId);
        $certificates = $this->certificateService->getUserCertificates($userId);

        echo $this->view('certificates/my-certificates', [
            'certificates' => $certificates,
            'user' => $user
        ]);
    }

    /**
     * View single certificate
     */
    public function viewCertificate(string $uuid): void
    {
        $certificate = $this->certificateService->verifyCertificate($uuid);

        if (!$certificate) {
            echo $this->view('certificates/not-found');
            return;
        }

        // Check if user is logged in and get their role
        $isAuthenticated = isset($_SESSION['user_id']);
        $userRole = $_SESSION['user_data']['role'] ?? null;
        $canPrint = $isAuthenticated && in_array($userRole, ['admin', 'facilitator']);

        echo $this->view('certificates/view', [
            'certificate' => $certificate,
            'canPrint' => $canPrint,
            'isAuthenticated' => $isAuthenticated
        ]);
    }

    /**
     * Verify certificate (public page)
     */
    public function verify(): void
    {
        $identifier = $_GET['id'] ?? '';

        if (empty($identifier)) {
            echo $this->view('certificates/verify-form');
            return;
        }

        $certificate = $this->certificateService->verifyCertificate($identifier);

        echo $this->view('certificates/verify-result', [
            'certificate' => $certificate,
            'identifier' => $identifier
        ]);
    }

    /**
     * Issue certificate (admin/system action)
     */
    public function issue(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['error' => 'Invalid request method'], 405);
            return;
        }

        $userId = (int)($_POST['user_id'] ?? 0);
        $courseId = (int)($_POST['course_id'] ?? 0);

        if (!$userId || !$courseId) {
            $this->jsonResponse(['error' => 'User ID and Course ID required'], 400);
            return;
        }

        $certificate = $this->certificateService->issueCertificate($userId, $courseId);

        if ($certificate) {
            // Send certificate email to user
            try {
                $user = \Nebatech\Models\User::findById($userId);
                $course = \Nebatech\Models\Course::findById($courseId);
                
                if ($user && $course) {
                    $emailService = new \Nebatech\Services\EmailService();
                    $emailService->sendCertificateIssued($user, $certificate, $course);
                }
            } catch (\Exception $e) {
                error_log("Failed to send certificate email: " . $e->getMessage());
            }

            $this->jsonResponse([
                'success' => true,
                'message' => 'Certificate issued successfully',
                'certificate' => $certificate
            ]);
        } else {
            $this->jsonResponse([
                'error' => 'Failed to issue certificate. User may not have completed the course.'
            ], 400);
        }
    }

    /**
     * Download certificate as PDF
     */
    public function download(string $uuid): void
    {
        $certificate = $this->certificateService->verifyCertificate($uuid);

        if (!$certificate) {
            $this->redirect('/certificates?error=not_found');
            return;
        }

        // Check if user owns this certificate
        $userId = AuthMiddleware::userId();
        if ($certificate['user_id'] !== $userId) {
            $this->redirect('/certificates?error=unauthorized');
            return;
        }

        // Generate and download PDF certificate
        try {
            $user = \Nebatech\Models\User::findById($userId);
            $course = \Nebatech\Models\Course::findById($certificate['course_id']);
            
            if ($user && $course) {
                $pdfService = new \Nebatech\Services\PDFService();
                $pdfService->downloadCertificate($certificate, $user, $course);
                exit;
            }
        } catch (\Exception $e) {
            error_log("Failed to generate PDF certificate: " . $e->getMessage());
        }
        
        // If PDF generation fails, redirect to view page
        $this->redirect('/certificate/' . $uuid);
    }

    /**
     * JSON response helper
     */
    protected function jsonResponse(array $data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}
