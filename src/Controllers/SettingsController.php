<?php

namespace Nebatech\Controllers;

use Nebatech\Core\Controller;
use Nebatech\Models\User;
use Nebatech\Models\UserPreference;

class SettingsController extends Controller
{
    /**
     * Display settings page
     */
    public function index()
    {
        $user = $this->getCurrentUser();
        
        if (!$user) {
            header('Location: ' . url('/login'));
            exit;
        }

        // Get user preferences
        $editorSettings = UserPreference::getEditorSettings($user['id']);
        
        echo $this->view('settings/index', [
            'title' => 'Settings',
            'user' => $user,
            'editorSettings' => $editorSettings
        ]);
    }

    /**
     * Update general settings
     */
    public function update()
    {
        header('Content-Type: application/json');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'error' => 'Invalid request method']);
            exit;
        }

        $user = $this->getCurrentUser();
        if (!$user) {
            echo json_encode(['success' => false, 'error' => 'Unauthorized']);
            exit;
        }

        try {
            $data = [];
            
            // Update email if provided
            if (isset($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $data['email'] = $_POST['email'];
            }
            
            // Update timezone if provided
            if (isset($_POST['timezone'])) {
                $data['timezone'] = $_POST['timezone'];
            }
            
            // Update language if provided
            if (isset($_POST['language'])) {
                $data['language'] = $_POST['language'];
            }
            
            // Update notification preferences
            if (isset($_POST['email_notifications'])) {
                $data['email_notifications'] = $_POST['email_notifications'] === 'true' ? 1 : 0;
            }
            
            if (isset($_POST['push_notifications'])) {
                $data['push_notifications'] = $_POST['push_notifications'] === 'true' ? 1 : 0;
            }
            
            if (isset($_POST['marketing_emails'])) {
                $data['marketing_emails'] = $_POST['marketing_emails'] === 'true' ? 1 : 0;
            }

            if (!empty($data)) {
                User::updateUser($user['id'], $data);
            }

            echo json_encode(['success' => true, 'message' => 'Settings updated successfully']);
        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
        exit;
    }

    /**
     * Update editor settings
     */
    public function updateEditor()
    {
        header('Content-Type: application/json');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'error' => 'Invalid request method']);
            exit;
        }

        $user = $this->getCurrentUser();
        if (!$user) {
            echo json_encode(['success' => false, 'error' => 'Unauthorized']);
            exit;
        }

        try {
            // Get JSON input
            $input = file_get_contents('php://input');
            $data = json_decode($input, true);

            if (!isset($data['editor_settings'])) {
                echo json_encode(['success' => false, 'error' => 'No editor settings provided']);
                exit;
            }

            $editorSettings = $data['editor_settings'];
            
            // Validate settings
            $validSettings = [
                'theme' => $editorSettings['theme'] ?? 'github-light',
                'fontSize' => (int)($editorSettings['fontSize'] ?? 14),
                'lineNumbers' => (bool)($editorSettings['lineNumbers'] ?? true),
                'lineWrapping' => (bool)($editorSettings['lineWrapping'] ?? false),
                'tabSize' => (int)($editorSettings['tabSize'] ?? 4),
                'indentWithTabs' => (bool)($editorSettings['indentWithTabs'] ?? false),
                'autoCloseBrackets' => (bool)($editorSettings['autoCloseBrackets'] ?? true),
                'language' => $editorSettings['language'] ?? 'auto',
                'keyMap' => $editorSettings['keyMap'] ?? 'default'
            ];

            // Save to database
            UserPreference::setEditorSettings($user['id'], $validSettings);

            echo json_encode([
                'success' => true,
                'message' => 'Editor settings updated successfully',
                'settings' => $validSettings
            ]);
        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
        exit;
    }

    /**
     * Change password
     */
    public function changePassword()
    {
        header('Content-Type: application/json');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'error' => 'Invalid request method']);
            exit;
        }

        $user = $this->getCurrentUser();
        if (!$user) {
            echo json_encode(['success' => false, 'error' => 'Unauthorized']);
            exit;
        }

        try {
            $currentPassword = $_POST['current_password'] ?? '';
            $newPassword = $_POST['new_password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            // Validate current password
            if (!password_verify($currentPassword, $user['password'])) {
                echo json_encode(['success' => false, 'error' => 'Current password is incorrect']);
                exit;
            }

            // Validate new password
            if (strlen($newPassword) < 8) {
                echo json_encode(['success' => false, 'error' => 'New password must be at least 8 characters']);
                exit;
            }

            if ($newPassword !== $confirmPassword) {
                echo json_encode(['success' => false, 'error' => 'Passwords do not match']);
                exit;
            }

            // Update password
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            User::updateUser($user['id'], ['password' => $hashedPassword]);

            echo json_encode(['success' => true, 'message' => 'Password changed successfully']);
        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
        exit;
    }

    /**
     * Delete account
     */
    public function deleteAccount()
    {
        header('Content-Type: application/json');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'error' => 'Invalid request method']);
            exit;
        }

        $user = $this->getCurrentUser();
        if (!$user) {
            echo json_encode(['success' => false, 'error' => 'Unauthorized']);
            exit;
        }

        try {
            $password = $_POST['password'] ?? '';

            // Verify password
            if (!password_verify($password, $user['password'])) {
                echo json_encode(['success' => false, 'error' => 'Password is incorrect']);
                exit;
            }

            // Delete user account
            User::delete($user['id']);

            // Clear session
            session_destroy();

            echo json_encode(['success' => true, 'message' => 'Account deleted successfully']);
        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
        exit;
    }
}
