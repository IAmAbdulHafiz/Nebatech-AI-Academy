<?php

namespace Nebatech\Controllers;

use Nebatech\Core\Database;
use Nebatech\Services\EmailService;
use PDO;

class CohortController
{
    private EmailService $emailService;
    
    public function __construct()
    {
        $this->requireAuth();
        $this->emailService = new EmailService();
    }

    /**
     * List all cohorts for the facilitator
     */
    public function index()
    {
        $this->requireRole('facilitator');
        $userId = $_SESSION['user']['id'];

        $db = Database::connect();
        
        $stmt = $db->prepare("
            SELECT c.*, 
                   (SELECT COUNT(*) FROM cohort_members cm WHERE cm.cohort_id = c.id) as member_count,
                   (SELECT COUNT(*) FROM cohort_courses cc WHERE cc.cohort_id = c.id) as course_count
            FROM cohorts c
            WHERE c.facilitator_id = ?
            ORDER BY c.created_at DESC
        ");
        $stmt->execute([$userId]);
        $cohorts = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $this->view('facilitator/cohorts', ['cohorts' => $cohorts]);
    }

    /**
     * Show create cohort form
     */
    public function create()
    {
        $this->requireRole('facilitator');
        
        $db = Database::connect();
        
        // Get facilitator's courses
        $stmt = $db->prepare("
            SELECT id, title, slug, level, status 
            FROM courses 
            WHERE facilitator_id = ? AND status = 'published'
            ORDER BY title
        ");
        $stmt->execute([$_SESSION['user']['id']]);
        $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $this->view('facilitator/create-cohort', ['courses' => $courses]);
    }

    /**
     * Store a new cohort
     */
    public function store()
    {
        $this->requireRole('facilitator');
        
        $name = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $program = trim($_POST['program'] ?? '');
        $startDate = $_POST['start_date'] ?? null;
        $endDate = $_POST['end_date'] ?? null;
        $maxStudents = intval($_POST['max_students'] ?? 30);
        $courseIds = $_POST['courses'] ?? [];

        if (empty($name) || empty($program)) {
            $_SESSION['error'] = 'Name and program are required';
            header('Location: ' . url('/facilitator/cohorts/create'));
            exit;
        }

        $db = Database::connect();
        
        try {
            $db->beginTransaction();

            // Create cohort
            $stmt = $db->prepare("
                INSERT INTO cohorts (name, description, program, facilitator_id, start_date, end_date, max_students, status, approval_status, created_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, 'upcoming', 'draft', NOW())
            ");
            $stmt->execute([
                $name,
                $description,
                $program,
                $_SESSION['user']['id'],
                $startDate,
                $endDate,
                $maxStudents
            ]);
            
            $cohortId = $db->lastInsertId();

            // Add courses to cohort
            if (!empty($courseIds)) {
                $insertStmt = $db->prepare("INSERT INTO cohort_courses (cohort_id, course_id) VALUES (?, ?)");
                foreach ($courseIds as $courseId) {
                    $insertStmt->execute([$cohortId, intval($courseId)]);
                }
            }

            $db->commit();

            $_SESSION['success'] = 'Cohort created successfully!';
            header('Location: ' . url('/facilitator/cohorts/' . $cohortId));
            exit;

        } catch (\Exception $e) {
            $db->rollBack();
            error_log("Failed to create cohort: " . $e->getMessage());
            $_SESSION['error'] = 'Failed to create cohort. Please try again.';
            header('Location: ' . url('/facilitator/cohorts/create'));
            exit;
        }
    }

    /**
     * View a single cohort
     */
    public function show(string $id)
    {
        $this->requireRole('facilitator');
        
        $db = Database::connect();
        
        // Get cohort details
        $stmt = $db->prepare("
            SELECT c.*, u.first_name as facilitator_first_name, u.last_name as facilitator_last_name
            FROM cohorts c
            JOIN users u ON c.facilitator_id = u.id
            WHERE c.id = ? AND c.facilitator_id = ?
        ");
        $stmt->execute([$id, $_SESSION['user']['id']]);
        $cohort = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$cohort) {
            http_response_code(404);
            return $this->view('errors/404');
        }

        // Get cohort courses
        $stmt = $db->prepare("
            SELECT c.id, c.title, c.slug, c.level, c.status, cc.created_at as added_at
            FROM courses c
            JOIN cohort_courses cc ON c.id = cc.course_id
            WHERE cc.cohort_id = ?
            ORDER BY cc.created_at
        ");
        $stmt->execute([$id]);
        $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Get cohort members (students)
        $stmt = $db->prepare("
            SELECT u.id, u.first_name, u.last_name, u.email, u.avatar, cm.status, cm.joined_at, cm.invited_at
            FROM users u
            JOIN cohort_members cm ON u.id = cm.user_id
            WHERE cm.cohort_id = ?
            ORDER BY cm.joined_at DESC
        ");
        $stmt->execute([$id]);
        $members = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Get pending invitations
        $stmt = $db->prepare("
            SELECT ci.*, u.first_name, u.last_name, u.email as user_email
            FROM cohort_invitations ci
            LEFT JOIN users u ON ci.user_id = u.id
            WHERE ci.cohort_id = ? AND ci.status = 'pending'
            ORDER BY ci.created_at DESC
        ");
        $stmt->execute([$id]);
        $invitations = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $this->view('facilitator/view-cohort', [
            'cohort' => $cohort,
            'courses' => $courses,
            'members' => $members,
            'invitations' => $invitations
        ]);
    }

    /**
     * Submit cohort for approval
     */
    public function submitForApproval()
    {
        $this->requireRole('facilitator');
        
        $cohortId = $_POST['cohort_id'] ?? null;

        if (!$cohortId) {
            return $this->jsonResponse(['success' => false, 'error' => 'Cohort ID required'], 400);
        }

        $db = Database::connect();
        
        // Verify ownership
        $stmt = $db->prepare("SELECT * FROM cohorts WHERE id = ? AND facilitator_id = ?");
        $stmt->execute([$cohortId, $_SESSION['user']['id']]);
        $cohort = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$cohort) {
            return $this->jsonResponse(['success' => false, 'error' => 'Cohort not found'], 404);
        }

        // Update status
        $stmt = $db->prepare("UPDATE cohorts SET approval_status = 'pending_approval', updated_at = NOW() WHERE id = ?");
        $stmt->execute([$cohortId]);

        return $this->jsonResponse(['success' => true, 'message' => 'Cohort submitted for approval']);
    }

    /**
     * Show student invitation form/modal data
     */
    public function inviteForm(string $cohortId)
    {
        $this->requireRole('facilitator');
        
        $db = Database::connect();
        
        // Verify ownership
        $stmt = $db->prepare("SELECT * FROM cohorts WHERE id = ? AND facilitator_id = ?");
        $stmt->execute([$cohortId, $_SESSION['user']['id']]);
        $cohort = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$cohort) {
            return $this->jsonResponse(['success' => false, 'error' => 'Cohort not found'], 404);
        }

        // Get existing students (users with role 'student' not already in this cohort)
        $stmt = $db->prepare("
            SELECT u.id, u.first_name, u.last_name, u.email
            FROM users u
            WHERE u.role = 'student'
            AND u.id NOT IN (
                SELECT user_id FROM cohort_members WHERE cohort_id = ?
            )
            AND u.id NOT IN (
                SELECT user_id FROM cohort_invitations WHERE cohort_id = ? AND status = 'pending'
            )
            ORDER BY u.first_name, u.last_name
            LIMIT 100
        ");
        $stmt->execute([$cohortId, $cohortId]);
        $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $this->jsonResponse([
            'success' => true,
            'cohort' => $cohort,
            'students' => $students
        ]);
    }

    /**
     * Send invitations to students
     */
    public function sendInvitations()
    {
        $this->requireRole('facilitator');
        
        $cohortId = $_POST['cohort_id'] ?? null;
        $inviteType = $_POST['invite_type'] ?? 'existing'; // 'existing' or 'email'
        $studentIds = $_POST['student_ids'] ?? [];
        $emails = $_POST['emails'] ?? '';

        if (!$cohortId) {
            return $this->jsonResponse(['success' => false, 'error' => 'Cohort ID required'], 400);
        }

        $db = Database::connect();
        
        // Verify ownership and approval status
        $stmt = $db->prepare("SELECT * FROM cohorts WHERE id = ? AND facilitator_id = ? AND approval_status = 'approved'");
        $stmt->execute([$cohortId, $_SESSION['user']['id']]);
        $cohort = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$cohort) {
            return $this->jsonResponse(['success' => false, 'error' => 'Cohort not found or not approved'], 404);
        }

        $invitedCount = 0;
        $errors = [];

        if ($inviteType === 'existing' && !empty($studentIds)) {
            // Invite existing students
            foreach ($studentIds as $studentId) {
                try {
                    $result = $this->inviteStudent($db, $cohort, intval($studentId));
                    if ($result['success']) {
                        $invitedCount++;
                    } else {
                        $errors[] = $result['error'];
                    }
                } catch (\Exception $e) {
                    $errors[] = "Failed to invite student ID {$studentId}";
                }
            }
        } elseif ($inviteType === 'email' && !empty($emails)) {
            // Invite by email
            $emailList = array_filter(array_map('trim', preg_split('/[\n,;]+/', $emails)));
            
            foreach ($emailList as $email) {
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $errors[] = "Invalid email: {$email}";
                    continue;
                }
                
                try {
                    $result = $this->inviteByEmail($db, $cohort, $email);
                    if ($result['success']) {
                        $invitedCount++;
                    } else {
                        $errors[] = $result['error'];
                    }
                } catch (\Exception $e) {
                    $errors[] = "Failed to invite {$email}";
                }
            }
        }

        return $this->jsonResponse([
            'success' => $invitedCount > 0,
            'message' => $invitedCount > 0 ? "{$invitedCount} invitation(s) sent successfully" : 'No invitations sent',
            'invited_count' => $invitedCount,
            'errors' => $errors
        ]);
    }

    /**
     * Invite an existing student
     */
    private function inviteStudent(PDO $db, array $cohort, int $userId): array
    {
        // Check if already a member or has pending invitation
        $stmt = $db->prepare("SELECT id FROM cohort_members WHERE cohort_id = ? AND user_id = ?");
        $stmt->execute([$cohort['id'], $userId]);
        if ($stmt->fetch()) {
            return ['success' => false, 'error' => 'Student is already a member'];
        }

        $stmt = $db->prepare("SELECT id FROM cohort_invitations WHERE cohort_id = ? AND user_id = ? AND status = 'pending'");
        $stmt->execute([$cohort['id'], $userId]);
        if ($stmt->fetch()) {
            return ['success' => false, 'error' => 'Invitation already sent'];
        }

        // Get user details
        $stmt = $db->prepare("SELECT id, email, first_name, last_name FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return ['success' => false, 'error' => 'User not found'];
        }

        // Generate invitation token
        $token = bin2hex(random_bytes(32));
        $expiresAt = date('Y-m-d H:i:s', strtotime('+7 days'));

        // Create invitation
        $stmt = $db->prepare("
            INSERT INTO cohort_invitations (cohort_id, user_id, email, token, status, expires_at, created_at)
            VALUES (?, ?, ?, ?, 'pending', ?, NOW())
        ");
        $stmt->execute([$cohort['id'], $userId, $user['email'], $token, $expiresAt]);

        // Send invitation email
        $this->sendInvitationEmail($user, $cohort, $token);

        // Create notification
        $this->createNotification(
            $userId,
            'cohort_invitation',
            "You've been invited to join the cohort: {$cohort['name']}",
            "/cohort/accept-invitation?token={$token}"
        );

        return ['success' => true];
    }

    /**
     * Invite by email (may be a new user)
     */
    private function inviteByEmail(PDO $db, array $cohort, string $email): array
    {
        // Check if email is already invited
        $stmt = $db->prepare("SELECT id FROM cohort_invitations WHERE cohort_id = ? AND email = ? AND status = 'pending'");
        $stmt->execute([$cohort['id'], $email]);
        if ($stmt->fetch()) {
            return ['success' => false, 'error' => "Already invited: {$email}"];
        }

        // Check if user exists
        $stmt = $db->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if already a member
        if ($existingUser) {
            $stmt = $db->prepare("SELECT id FROM cohort_members WHERE cohort_id = ? AND user_id = ?");
            $stmt->execute([$cohort['id'], $existingUser['id']]);
            if ($stmt->fetch()) {
                return ['success' => false, 'error' => "Already a member: {$email}"];
            }
        }

        // Generate invitation token
        $token = bin2hex(random_bytes(32));
        $expiresAt = date('Y-m-d H:i:s', strtotime('+7 days'));

        // Create invitation
        $stmt = $db->prepare("
            INSERT INTO cohort_invitations (cohort_id, user_id, email, token, status, expires_at, created_at)
            VALUES (?, ?, ?, ?, 'pending', ?, NOW())
        ");
        $stmt->execute([
            $cohort['id'],
            $existingUser['id'] ?? null,
            $email,
            $token,
            $expiresAt
        ]);

        // Send invitation email
        $userData = ['email' => $email, 'first_name' => 'Student'];
        if ($existingUser) {
            $stmt = $db->prepare("SELECT first_name, last_name, email FROM users WHERE id = ?");
            $stmt->execute([$existingUser['id']]);
            $userData = $stmt->fetch(PDO::FETCH_ASSOC) ?: $userData;
        }
        
        $this->sendInvitationEmail($userData, $cohort, $token);

        return ['success' => true];
    }

    /**
     * Send invitation email
     */
    private function sendInvitationEmail(array $user, array $cohort, string $token): void
    {
        try {
            $this->emailService->sendCohortInvitation($user, $cohort, $token);
        } catch (\Exception $e) {
            error_log("Failed to send cohort invitation email: " . $e->getMessage());
        }
    }

    /**
     * Accept invitation
     */
    public function acceptInvitation()
    {
        $token = $_GET['token'] ?? $_POST['token'] ?? null;

        if (!$token) {
            $_SESSION['error'] = 'Invalid invitation link';
            header('Location: ' . url('/login'));
            exit;
        }

        $db = Database::connect();
        
        // Find invitation
        $stmt = $db->prepare("
            SELECT ci.*, c.name as cohort_name, c.facilitator_id
            FROM cohort_invitations ci
            JOIN cohorts c ON ci.cohort_id = c.id
            WHERE ci.token = ? AND ci.status = 'pending' AND ci.expires_at > NOW()
        ");
        $stmt->execute([$token]);
        $invitation = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$invitation) {
            $_SESSION['error'] = 'Invitation expired or invalid';
            header('Location: ' . url('/login'));
            exit;
        }

        // If user is not logged in, redirect to login with return URL
        if (!isset($_SESSION['user'])) {
            $_SESSION['pending_invitation'] = $token;
            header('Location: ' . url('/login?redirect=' . urlencode('/cohort/accept-invitation?token=' . $token)));
            exit;
        }

        // Verify user email matches invitation
        $userId = $_SESSION['user']['id'];
        if ($invitation['email'] !== $_SESSION['user']['email'] && $invitation['user_id'] !== $userId) {
            $_SESSION['error'] = 'This invitation was sent to a different email address';
            header('Location: ' . url('/dashboard'));
            exit;
        }

        try {
            $db->beginTransaction();

            // Add user to cohort
            $stmt = $db->prepare("
                INSERT INTO cohort_members (cohort_id, user_id, status, joined_at, invited_at)
                VALUES (?, ?, 'active', NOW(), ?)
            ");
            $stmt->execute([$invitation['cohort_id'], $userId, $invitation['created_at']]);

            // Update invitation status
            $stmt = $db->prepare("UPDATE cohort_invitations SET status = 'accepted', accepted_at = NOW() WHERE id = ?");
            $stmt->execute([$invitation['id']]);

            // Enroll user in cohort courses
            $stmt = $db->prepare("
                SELECT course_id FROM cohort_courses WHERE cohort_id = ?
            ");
            $stmt->execute([$invitation['cohort_id']]);
            $courses = $stmt->fetchAll(PDO::FETCH_COLUMN);

            foreach ($courses as $courseId) {
                // Check if not already enrolled
                $checkStmt = $db->prepare("SELECT id FROM enrollments WHERE user_id = ? AND course_id = ?");
                $checkStmt->execute([$userId, $courseId]);
                if (!$checkStmt->fetch()) {
                    $enrollStmt = $db->prepare("
                        INSERT INTO enrollments (user_id, course_id, payment_status, payment_method, amount, enrolled_at, created_at)
                        VALUES (?, ?, 'completed', 'cohort_enrollment', 0, NOW(), NOW())
                    ");
                    $enrollStmt->execute([$userId, $courseId]);
                }
            }

            $db->commit();

            // Create notification for facilitator
            $this->createNotification(
                $invitation['facilitator_id'],
                'cohort_member_joined',
                "{$_SESSION['user']['first_name']} {$_SESSION['user']['last_name']} has joined your cohort: {$invitation['cohort_name']}",
                "/facilitator/cohorts/{$invitation['cohort_id']}"
            );

            $_SESSION['success'] = "You've joined the cohort: {$invitation['cohort_name']}!";
            header('Location: ' . url('/my-cohorts'));
            exit;

        } catch (\Exception $e) {
            $db->rollBack();
            error_log("Failed to accept invitation: " . $e->getMessage());
            $_SESSION['error'] = 'Failed to join cohort. Please try again.';
            header('Location: ' . url('/dashboard'));
            exit;
        }
    }

    /**
     * Decline invitation
     */
    public function declineInvitation()
    {
        $token = $_GET['token'] ?? $_POST['token'] ?? null;

        if (!$token) {
            return $this->jsonResponse(['success' => false, 'error' => 'Invalid token'], 400);
        }

        $db = Database::connect();
        
        $stmt = $db->prepare("UPDATE cohort_invitations SET status = 'declined' WHERE token = ? AND status = 'pending'");
        $stmt->execute([$token]);

        if ($stmt->rowCount() > 0) {
            return $this->jsonResponse(['success' => true, 'message' => 'Invitation declined']);
        }

        return $this->jsonResponse(['success' => false, 'error' => 'Invitation not found or already processed'], 404);
    }

    /**
     * Resend invitation
     */
    public function resendInvitation()
    {
        $this->requireRole('facilitator');
        
        $invitationId = $_POST['invitation_id'] ?? null;

        if (!$invitationId) {
            return $this->jsonResponse(['success' => false, 'error' => 'Invitation ID required'], 400);
        }

        $db = Database::connect();
        
        // Get invitation with cohort info
        $stmt = $db->prepare("
            SELECT ci.*, c.name as cohort_name, c.facilitator_id
            FROM cohort_invitations ci
            JOIN cohorts c ON ci.cohort_id = c.id
            WHERE ci.id = ? AND c.facilitator_id = ?
        ");
        $stmt->execute([$invitationId, $_SESSION['user']['id']]);
        $invitation = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$invitation) {
            return $this->jsonResponse(['success' => false, 'error' => 'Invitation not found'], 404);
        }

        // Generate new token and extend expiry
        $token = bin2hex(random_bytes(32));
        $expiresAt = date('Y-m-d H:i:s', strtotime('+7 days'));

        $stmt = $db->prepare("UPDATE cohort_invitations SET token = ?, expires_at = ?, status = 'pending' WHERE id = ?");
        $stmt->execute([$token, $expiresAt, $invitationId]);

        // Resend email
        $user = ['email' => $invitation['email'], 'first_name' => $invitation['first_name'] ?? 'Student'];
        $cohort = ['id' => $invitation['cohort_id'], 'name' => $invitation['cohort_name']];
        $this->sendInvitationEmail($user, $cohort, $token);

        return $this->jsonResponse(['success' => true, 'message' => 'Invitation resent']);
    }

    /**
     * Cancel invitation
     */
    public function cancelInvitation()
    {
        $this->requireRole('facilitator');
        
        $invitationId = $_POST['invitation_id'] ?? null;

        if (!$invitationId) {
            return $this->jsonResponse(['success' => false, 'error' => 'Invitation ID required'], 400);
        }

        $db = Database::connect();
        
        // Verify ownership
        $stmt = $db->prepare("
            SELECT ci.id FROM cohort_invitations ci
            JOIN cohorts c ON ci.cohort_id = c.id
            WHERE ci.id = ? AND c.facilitator_id = ?
        ");
        $stmt->execute([$invitationId, $_SESSION['user']['id']]);
        
        if (!$stmt->fetch()) {
            return $this->jsonResponse(['success' => false, 'error' => 'Invitation not found'], 404);
        }

        $stmt = $db->prepare("UPDATE cohort_invitations SET status = 'cancelled' WHERE id = ?");
        $stmt->execute([$invitationId]);

        return $this->jsonResponse(['success' => true, 'message' => 'Invitation cancelled']);
    }

    /**
     * Remove student from cohort
     */
    public function removeMember()
    {
        $this->requireRole('facilitator');
        
        $cohortId = $_POST['cohort_id'] ?? null;
        $userId = $_POST['user_id'] ?? null;

        if (!$cohortId || !$userId) {
            return $this->jsonResponse(['success' => false, 'error' => 'Missing required parameters'], 400);
        }

        $db = Database::connect();
        
        // Verify ownership
        $stmt = $db->prepare("SELECT id FROM cohorts WHERE id = ? AND facilitator_id = ?");
        $stmt->execute([$cohortId, $_SESSION['user']['id']]);
        
        if (!$stmt->fetch()) {
            return $this->jsonResponse(['success' => false, 'error' => 'Cohort not found'], 404);
        }

        // Remove member
        $stmt = $db->prepare("DELETE FROM cohort_members WHERE cohort_id = ? AND user_id = ?");
        $stmt->execute([$cohortId, $userId]);

        return $this->jsonResponse(['success' => true, 'message' => 'Member removed']);
    }

    /**
     * Add course to cohort
     */
    public function addCourse()
    {
        $this->requireRole('facilitator');
        
        $cohortId = $_POST['cohort_id'] ?? null;
        $courseId = $_POST['course_id'] ?? null;

        if (!$cohortId || !$courseId) {
            return $this->jsonResponse(['success' => false, 'error' => 'Missing required parameters'], 400);
        }

        $db = Database::connect();
        
        // Verify cohort ownership
        $stmt = $db->prepare("SELECT id FROM cohorts WHERE id = ? AND facilitator_id = ?");
        $stmt->execute([$cohortId, $_SESSION['user']['id']]);
        
        if (!$stmt->fetch()) {
            return $this->jsonResponse(['success' => false, 'error' => 'Cohort not found'], 404);
        }

        // Verify course ownership
        $stmt = $db->prepare("SELECT id FROM courses WHERE id = ? AND facilitator_id = ?");
        $stmt->execute([$courseId, $_SESSION['user']['id']]);
        
        if (!$stmt->fetch()) {
            return $this->jsonResponse(['success' => false, 'error' => 'Course not found'], 404);
        }

        // Check if already added
        $stmt = $db->prepare("SELECT id FROM cohort_courses WHERE cohort_id = ? AND course_id = ?");
        $stmt->execute([$cohortId, $courseId]);
        
        if ($stmt->fetch()) {
            return $this->jsonResponse(['success' => false, 'error' => 'Course already in cohort'], 400);
        }

        // Add course
        $stmt = $db->prepare("INSERT INTO cohort_courses (cohort_id, course_id, created_at) VALUES (?, ?, NOW())");
        $stmt->execute([$cohortId, $courseId]);

        return $this->jsonResponse(['success' => true, 'message' => 'Course added to cohort']);
    }

    /**
     * Remove course from cohort
     */
    public function removeCourse()
    {
        $this->requireRole('facilitator');
        
        $cohortId = $_POST['cohort_id'] ?? null;
        $courseId = $_POST['course_id'] ?? null;

        if (!$cohortId || !$courseId) {
            return $this->jsonResponse(['success' => false, 'error' => 'Missing required parameters'], 400);
        }

        $db = Database::connect();
        
        // Verify ownership
        $stmt = $db->prepare("SELECT id FROM cohorts WHERE id = ? AND facilitator_id = ?");
        $stmt->execute([$cohortId, $_SESSION['user']['id']]);
        
        if (!$stmt->fetch()) {
            return $this->jsonResponse(['success' => false, 'error' => 'Cohort not found'], 404);
        }

        // Remove course
        $stmt = $db->prepare("DELETE FROM cohort_courses WHERE cohort_id = ? AND course_id = ?");
        $stmt->execute([$cohortId, $courseId]);

        return $this->jsonResponse(['success' => true, 'message' => 'Course removed from cohort']);
    }

    /**
     * Create notification helper
     */
    private function createNotification(int $userId, string $type, string $message, string $link = null): void
    {
        try {
            $db = Database::connect();
            $stmt = $db->prepare("
                INSERT INTO notifications (user_id, type, message, link, created_at)
                VALUES (?, ?, ?, ?, NOW())
            ");
            $stmt->execute([$userId, $type, $message, $link]);
        } catch (\Exception $e) {
            error_log("Failed to create notification: " . $e->getMessage());
        }
    }

    /**
     * Render view helper
     */
    private function view(string $template, array $data = []): string
    {
        extract($data);
        ob_start();
        include __DIR__ . "/../Views/{$template}.php";
        $content = ob_get_clean();
        
        ob_start();
        include __DIR__ . '/../Views/layouts/dashboard.php';
        return ob_get_clean();
    }

    /**
     * JSON response helper
     */
    private function jsonResponse(array $data, int $statusCode = 200): string
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        return json_encode($data);
    }

    /**
     * Require authentication
     */
    protected function requireAuth(): void
    {
        if (!isset($_SESSION['user'])) {
            header('Location: ' . url('/login'));
            exit;
        }
    }

    /**
     * Require specific role
     */
    protected function requireRole(string $role): void
    {
        $this->requireAuth();
        if ($_SESSION['user']['role'] !== $role && $_SESSION['user']['role'] !== 'admin') {
            http_response_code(403);
            exit('Access denied');
        }
    }
}
