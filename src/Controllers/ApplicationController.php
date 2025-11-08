<?php

namespace Nebatech\Controllers;

use Nebatech\Core\Controller;
use Nebatech\Models\Application;
use Nebatech\Models\Cohort;
use Nebatech\Services\EmailService;

class ApplicationController extends Controller
{
    private $applicationModel;
    private $cohortModel;
    private $emailService;

    public function __construct()
    {
        parent::__construct();
        $this->applicationModel = new Application();
        $this->cohortModel = new Cohort();
        $this->emailService = new EmailService();
    }

    /**
     * Show application form for a program
     */
    public function apply($programSlug)
    {
        if (!$this->isAuthenticated()) {
            $this->redirect('/login?redirect=/apply/' . $programSlug);
            return;
        }

        // Get program details
        $program = $this->db->query(
            "SELECT * FROM courses WHERE slug = ?",
            [$programSlug]
        )->fetch();

        if (!$program) {
            $this->setFlashMessage('error', 'Program not found');
            $this->redirect('/courses');
            return;
        }

        // Check if user already applied
        $userId = $_SESSION['user_id'];
        if ($this->applicationModel->hasApplied($userId, $program['id'])) {
            $this->setFlashMessage('info', 'You have already applied for this program');
            $this->redirect('/dashboard');
            return;
        }

        // Get available cohorts
        $cohorts = $this->cohortModel->getAvailableForProgram($program['id']);

        $this->render('applications/apply', [
            'program' => $program,
            'cohorts' => $cohorts,
            'user' => $this->getCurrentUser()
        ]);
    }

    /**
     * Submit application
     */
    public function submit()
    {
        if (!$this->isAuthenticated()) {
            return $this->json(['success' => false, 'message' => 'Authentication required'], 401);
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->json(['success' => false, 'message' => 'Invalid request method'], 405);
        }

        $userId = $_SESSION['user_id'];
        $programId = $_POST['program_id'] ?? null;

        if (!$programId) {
            return $this->json(['success' => false, 'message' => 'Program ID is required'], 400);
        }

        // Check if already applied
        if ($this->applicationModel->hasApplied($userId, $programId)) {
            return $this->json(['success' => false, 'message' => 'You have already applied for this program'], 400);
        }

        // Handle file uploads
        $uploads = $this->handleFileUploads();

        // Create application
        try {
            $applicationId = $this->applicationModel->create($userId, $programId, [
                'motivation' => $_POST['motivation'] ?? null,
                'educational_background' => $_POST['educational_background'] ?? null,
                'employment_status' => $_POST['employment_status'] ?? null,
                'goals' => $_POST['goals'] ?? null,
                'referral_source' => $_POST['referral_source'] ?? null,
                'phone' => $_POST['phone'] ?? null,
                'country' => $_POST['country'] ?? null,
                'city' => $_POST['city'] ?? null,
                'id_document_path' => $uploads['id_document'] ?? null,
                'transcript_path' => $uploads['transcript'] ?? null,
                'resume_path' => $uploads['resume'] ?? null,
                'status' => 'pending',
                'priority' => 'normal'
            ]);

            // Get application details for email
            $application = $this->applicationModel->findById($applicationId);

            // Send confirmation email
            $this->emailService->send(
                $application['email'],
                'Application Received - Nebatech AI Academy',
                'emails/application-received',
                [
                    'firstName' => $application['first_name'],
                    'lastName' => $application['last_name'],
                    'programName' => $application['program_name'],
                    'applicationUuid' => $application['uuid'],
                    'submittedAt' => $application['submitted_at']
                ]
            );

            $this->setFlashMessage('success', 'Your application has been submitted successfully!');
            return $this->json([
                'success' => true,
                'message' => 'Application submitted successfully',
                'application_id' => $applicationId,
                'redirect' => url('/applications/' . $application['uuid'])
            ]);

        } catch (\Exception $e) {
            error_log('Application submission error: ' . $e->getMessage());
            return $this->json([
                'success' => false,
                'message' => 'Failed to submit application. Please try again.'
            ], 500);
        }
    }

    /**
     * View application details
     */
    public function view(array $params = [])
    {
        $uuid = $params['uuid'] ?? '';
        if (empty($uuid)) {
            $this->setFlashMessage('error', 'Invalid application ID');
            $this->redirect('/dashboard');
            return;
        }

        if (!$this->isAuthenticated()) {
            $this->redirect('/login');
            return;
        }

        $application = $this->applicationModel->findByUuid($uuid);

        if (!$application) {
            $this->setFlashMessage('error', 'Application not found');
            $this->redirect('/dashboard');
            return;
        }

        // Check permissions (user must own this application or be admin)
        if ($application['user_id'] != $_SESSION['user_id'] && $_SESSION['role'] !== 'admin') {
            $this->setFlashMessage('error', 'Access denied');
            $this->redirect('/dashboard');
            return;
        }

        // Get timeline
        $timeline = $this->applicationModel->getTimeline($application['id']);

        $this->render('applications/view', [
            'application' => $application,
            'timeline' => $timeline
        ]);
    }

    /**
     * User's applications dashboard
     */
    public function myApplications()
    {
        if (!$this->isAuthenticated()) {
            $this->redirect('/login');
            return;
        }

        $userId = $_SESSION['user_id'];
        $applications = $this->applicationModel->getUserApplications($userId);

        $this->render('applications/my-applications', [
            'applications' => $applications
        ]);
    }

    /**
     * Handle file uploads
     */
    private function handleFileUploads()
    {
        $uploads = [];
        $uploadDir = __DIR__ . '/../../storage/uploads/applications/';

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $fields = ['id_document', 'transcript', 'resume'];

        foreach ($fields as $field) {
            if (isset($_FILES[$field]) && $_FILES[$field]['error'] === UPLOAD_ERR_OK) {
                $file = $_FILES[$field];
                $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                $filename = uniqid() . '_' . time() . '.' . $ext;
                $destination = $uploadDir . $filename;

                if (move_uploaded_file($file['tmp_name'], $destination)) {
                    $uploads[$field] = 'uploads/applications/' . $filename;
                }
            }
        }

        return $uploads;
    }

    /**
     * Admin: Applications dashboard
     */
    public function adminDashboard()
    {
        if (!$this->isAuthenticated() || $_SESSION['role'] !== 'admin') {
            $this->setFlashMessage('error', 'Access denied');
            $this->redirect('/dashboard');
            return;
        }

        // Get filter parameters
        $filters = [
            'status' => $_GET['status'] ?? '',
            'priority' => $_GET['priority'] ?? '',
            'program_id' => $_GET['program_id'] ?? '',
            'search' => $_GET['search'] ?? ''
        ];

        // Get applications with pagination
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 20;
        $offset = ($page - 1) * $limit;

        $applications = $this->applicationModel->getAll($filters, $limit, $offset);
        $total = $this->applicationModel->getTotalCount($filters);
        $totalPages = ceil($total / $limit);

        // Get statistics
        $stats = $this->applicationModel->getStatistics();

        // Get available programs
        $programs = $this->db->query("SELECT id, title FROM courses WHERE status = 'published' ORDER BY title")->fetchAll();

        $this->render('admin/applications/dashboard', [
            'applications' => $applications,
            'stats' => $stats,
            'programs' => $programs,
            'filters' => $filters,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'total' => $total
        ]);
    }

    /**
     * Admin: Review application
     */
    public function review(array $params = [])
    {
        $id = (int) ($params['id'] ?? 0);
        if (!$id) {
            $this->setFlashMessage('error', 'Invalid application ID');
            $this->redirect('/admin/applications');
            return;
        }

        if (!$this->isAuthenticated() || $_SESSION['role'] !== 'admin') {
            $this->setFlashMessage('error', 'Access denied');
            $this->redirect('/dashboard');
            return;
        }

        $application = $this->applicationModel->findById($id);

        if (!$application) {
            $this->setFlashMessage('error', 'Application not found');
            $this->redirect('/admin/applications');
            return;
        }

        // Get available cohorts for this program
        $cohorts = $this->cohortModel->getAvailableForProgram($application['program_id']);

        // Get timeline
        $timeline = $this->applicationModel->getTimeline($id);

        // Get facilitators
        $facilitators = $this->db->query(
            "SELECT id, first_name, last_name, email FROM users WHERE role = 'facilitator' ORDER BY first_name"
        )->fetchAll();

        $this->render('admin/applications/review', [
            'application' => $application,
            'cohorts' => $cohorts,
            'facilitators' => $facilitators,
            'timeline' => $timeline
        ]);
    }

    /**
     * Admin: Approve application
     */
    public function approve()
    {
        if (!$this->isAuthenticated() || $_SESSION['role'] !== 'admin') {
            return $this->json(['success' => false, 'message' => 'Access denied'], 403);
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->json(['success' => false, 'message' => 'Invalid request method'], 405);
        }

        $applicationId = $_POST['application_id'] ?? null;
        $cohortId = $_POST['cohort_id'] ?? null;
        $facilitatorId = $_POST['facilitator_id'] ?? null;
        $notes = $_POST['notes'] ?? null;

        if (!$applicationId || !$cohortId) {
            return $this->json(['success' => false, 'message' => 'Missing required fields'], 400);
        }

        try {
            $reviewerId = $_SESSION['user_id'];

            // Approve and enroll
            $this->applicationModel->approve($applicationId, $reviewerId, $cohortId, $facilitatorId, $notes);

            // Get application details for email
            $application = $this->applicationModel->findById($applicationId);
            $cohort = $this->cohortModel->findById($cohortId);

            // Send approval email
            $this->emailService->send(
                $application['email'],
                'Application Approved! - Nebatech AI Academy',
                'emails/application-approved',
                [
                    'firstName' => $application['first_name'],
                    'lastName' => $application['last_name'],
                    'programName' => $application['program_name'],
                    'programSlug' => $application['program_slug'],
                    'cohortName' => $cohort['name'],
                    'cohortCode' => $cohort['code'],
                    'startDate' => $cohort['start_date'],
                    'schedule' => $cohort['schedule'] ?? '',
                    'facilitatorName' => $cohort['facilitator_first_name'] . ' ' . $cohort['facilitator_last_name']
                ]
            );

            return $this->json([
                'success' => true,
                'message' => 'Application approved and student enrolled successfully'
            ]);

        } catch (\Exception $e) {
            error_log('Application approval error: ' . $e->getMessage());
            return $this->json([
                'success' => false,
                'message' => 'Failed to approve application: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Admin: Reject application
     */
    public function reject()
    {
        if (!$this->isAuthenticated() || $_SESSION['role'] !== 'admin') {
            return $this->json(['success' => false, 'message' => 'Access denied'], 403);
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->json(['success' => false, 'message' => 'Invalid request method'], 405);
        }

        $applicationId = $_POST['application_id'] ?? null;
        $reason = $_POST['reason'] ?? null;
        $notes = $_POST['notes'] ?? null;

        if (!$applicationId || !$reason) {
            return $this->json(['success' => false, 'message' => 'Missing required fields'], 400);
        }

        try {
            $reviewerId = $_SESSION['user_id'];

            // Reject application
            $this->applicationModel->reject($applicationId, $reviewerId, $reason, $notes);

            // Get application details for email
            $application = $this->applicationModel->findById($applicationId);

            // Send rejection email
            $this->emailService->send(
                $application['email'],
                'Application Status Update - Nebatech AI Academy',
                'emails/application-rejected',
                [
                    'firstName' => $application['first_name'],
                    'lastName' => $application['last_name'],
                    'programName' => $application['program_name'],
                    'reason' => $reason
                ]
            );

            return $this->json([
                'success' => true,
                'message' => 'Application rejected and notification sent'
            ]);

        } catch (\Exception $e) {
            error_log('Application rejection error: ' . $e->getMessage());
            return $this->json([
                'success' => false,
                'message' => 'Failed to reject application'
            ], 500);
        }
    }

    /**
     * Admin: Waitlist application
     */
    public function waitlist()
    {
        if (!$this->isAuthenticated() || $_SESSION['role'] !== 'admin') {
            return $this->json(['success' => false, 'message' => 'Access denied'], 403);
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->json(['success' => false, 'message' => 'Invalid request method'], 405);
        }

        $applicationId = $_POST['application_id'] ?? null;
        $notes = $_POST['notes'] ?? null;

        if (!$applicationId) {
            return $this->json(['success' => false, 'message' => 'Application ID is required'], 400);
        }

        try {
            $reviewerId = $_SESSION['user_id'];
            $this->applicationModel->waitlist($applicationId, $reviewerId, $notes);

            return $this->json([
                'success' => true,
                'message' => 'Application moved to waitlist'
            ]);

        } catch (\Exception $e) {
            error_log('Application waitlist error: ' . $e->getMessage());
            return $this->json([
                'success' => false,
                'message' => 'Failed to waitlist application'
            ], 500);
        }
    }

    /**
     * Admin: Update priority
     */
    public function updatePriority()
    {
        if (!$this->isAuthenticated() || $_SESSION['role'] !== 'admin') {
            return $this->json(['success' => false, 'message' => 'Access denied'], 403);
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->json(['success' => false, 'message' => 'Invalid request method'], 405);
        }

        $applicationId = $_POST['application_id'] ?? null;
        $priority = $_POST['priority'] ?? null;

        if (!$applicationId || !$priority) {
            return $this->json(['success' => false, 'message' => 'Missing required fields'], 400);
        }

        try {
            $this->applicationModel->updatePriority($applicationId, $priority);

            return $this->json([
                'success' => true,
                'message' => 'Priority updated successfully'
            ]);

        } catch (\Exception $e) {
            return $this->json([
                'success' => false,
                'message' => 'Failed to update priority'
            ], 500);
        }
    }
}
