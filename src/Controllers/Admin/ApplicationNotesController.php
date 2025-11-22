<?php

namespace Nebatech\Controllers\Admin;

use Nebatech\Core\Database;
use Nebatech\Core\Controller;

class ApplicationNotesController extends Controller
{
    /**
     * Save admin notes for an application
     */
    public function save()
    {
        header('Content-Type: application/json');
        
        // Require POST method
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Method not allowed']);
            return;
        }
        
        // Check authentication
        if (!isset($_SESSION['user_id'])) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Authentication required']);
            return;
        }
        
        // Check admin role (adjust based on your role system)
        $userRole = $_SESSION['role'] ?? 'student';
        if (!in_array($userRole, ['admin', 'instructor', 'staff'])) {
            http_response_code(403);
            echo json_encode(['success' => false, 'message' => 'Insufficient permissions']);
            return;
        }
        
        $adminId = $_SESSION['user_id'];
        
        // Parse JSON input
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Invalid JSON']);
            return;
        }
        
        // Validate required fields
        $applicationId = trim($data['application_id'] ?? '');
        $notes = trim($data['notes'] ?? '');
        
        if (empty($applicationId)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Application ID required']);
            return;
        }
        
        try {
            // Verify application exists
            $application = Database::query(
                "SELECT id FROM applications WHERE uuid = ?",
                [$applicationId]
            );
            
            if (empty($application)) {
                http_response_code(404);
                echo json_encode(['success' => false, 'message' => 'Application not found']);
                return;
            }
            
            $appId = $application[0]['id'];
            
            // Check if notes already exist
            $existingNotes = Database::query(
                "SELECT id FROM application_notes WHERE application_id = ?",
                [$appId]
            );
            
            if (!empty($existingNotes)) {
                // Update existing notes
                Database::query(
                    "UPDATE application_notes 
                     SET notes = ?, updated_by = ?, updated_at = NOW()
                     WHERE application_id = ?",
                    [$notes, $adminId, $appId]
                );
                
                echo json_encode([
                    'success' => true,
                    'message' => 'Notes updated successfully',
                    'note_id' => $existingNotes[0]['id']
                ]);
            } else {
                // Create new notes record
                Database::query(
                    "INSERT INTO application_notes 
                     (application_id, notes, created_by, created_at, updated_at)
                     VALUES (?, ?, ?, NOW(), NOW())",
                    [$appId, $notes, $adminId]
                );
                
                $noteId = Database::lastInsertId();
                
                echo json_encode([
                    'success' => true,
                    'message' => 'Notes saved successfully',
                    'note_id' => $noteId
                ]);
            }
            
            // Log the action
            $this->logAdminAction($adminId, 'update_application_notes', $appId);
            
        } catch (\Exception $e) {
            error_log("Application notes save error: " . $e->getMessage());
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Failed to save notes'
            ]);
        }
    }
    
    /**
     * Get notes for an application
     */
    public function get()
    {
        header('Content-Type: application/json');
        
        if (!isset($_SESSION['user_id'])) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Authentication required']);
            return;
        }
        
        // Check admin role
        $userRole = $_SESSION['role'] ?? 'student';
        if (!in_array($userRole, ['admin', 'instructor', 'staff'])) {
            http_response_code(403);
            echo json_encode(['success' => false, 'message' => 'Insufficient permissions']);
            return;
        }
        
        $applicationId = $_GET['application_id'] ?? '';
        
        if (empty($applicationId)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Application ID required']);
            return;
        }
        
        try {
            $notes = Database::query(
                "SELECT n.*, 
                        u1.first_name as created_by_first_name, 
                        u1.last_name as created_by_last_name,
                        u2.first_name as updated_by_first_name, 
                        u2.last_name as updated_by_last_name
                 FROM application_notes n
                 LEFT JOIN users u1 ON n.created_by = u1.id
                 LEFT JOIN users u2 ON n.updated_by = u2.id
                 INNER JOIN applications a ON n.application_id = a.id
                 WHERE a.uuid = ?",
                [$applicationId]
            );
            
            if (!empty($notes)) {
                echo json_encode([
                    'success' => true,
                    'notes' => $notes[0]
                ]);
            } else {
                echo json_encode([
                    'success' => true,
                    'notes' => null
                ]);
            }
        } catch (\Exception $e) {
            error_log("Application notes get error: " . $e->getMessage());
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Failed to retrieve notes'
            ]);
        }
    }
    
    /**
     * Log admin action for audit trail
     */
    private function logAdminAction($userId, $action, $applicationId)
    {
        try {
            Database::query(
                "INSERT INTO admin_action_logs 
                 (user_id, action, resource_type, resource_id, ip_address, user_agent, created_at)
                 VALUES (?, ?, 'application', ?, ?, ?, NOW())",
                [
                    $userId,
                    $action,
                    $applicationId,
                    $_SERVER['REMOTE_ADDR'] ?? null,
                    $_SERVER['HTTP_USER_AGENT'] ?? null
                ]
            );
        } catch (\Exception $e) {
            // Log error but don't fail the main operation
            error_log("Failed to log admin action: " . $e->getMessage());
        }
    }
}
