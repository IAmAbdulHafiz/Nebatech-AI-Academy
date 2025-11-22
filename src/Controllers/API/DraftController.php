<?php

namespace Nebatech\Controllers\API;

use Nebatech\Core\Database;
use Nebatech\Core\Controller;

class DraftController extends Controller
{
    /**
     * Save a draft post
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
        
        $userId = $_SESSION['user_id'];
        
        // Parse JSON input
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Invalid JSON']);
            return;
        }
        
        // Validate required fields
        $title = trim($data['title'] ?? '');
        $content = trim($data['content'] ?? '');
        $type = trim($data['type'] ?? 'discussion'); // discussion, question, announcement
        
        if (empty($title) && empty($content)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Title or content required']);
            return;
        }
        
        // Optional fields
        $categoryId = !empty($data['category_id']) ? (int)$data['category_id'] : null;
        $tags = isset($data['tags']) && is_array($data['tags']) ? json_encode($data['tags']) : null;
        
        // Additional metadata (for various post types)
        $metadata = [
            'source' => $data['source'] ?? 'web',
            'draft_version' => $data['draft_version'] ?? 1
        ];
        
        try {
            // Check if draft already exists
            $existingDraft = Database::query(
                "SELECT id FROM draft_posts 
                 WHERE user_id = ? AND type = ? 
                 ORDER BY updated_at DESC LIMIT 1",
                [$userId, $type]
            );
            
            if (!empty($existingDraft)) {
                // Update existing draft
                Database::query(
                    "UPDATE draft_posts 
                     SET title = ?, content = ?, category_id = ?, tags = ?, 
                         metadata = ?, updated_at = NOW()
                     WHERE id = ?",
                    [
                        $title,
                        $content,
                        $categoryId,
                        $tags,
                        json_encode($metadata),
                        $existingDraft[0]['id']
                    ]
                );
                
                echo json_encode([
                    'success' => true,
                    'message' => 'Draft updated successfully',
                    'draft_id' => $existingDraft[0]['id']
                ]);
            } else {
                // Create new draft
                Database::query(
                    "INSERT INTO draft_posts 
                     (user_id, type, title, content, category_id, tags, metadata, created_at, updated_at)
                     VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), NOW())",
                    [
                        $userId,
                        $type,
                        $title,
                        $content,
                        $categoryId,
                        $tags,
                        json_encode($metadata)
                    ]
                );
                
                $draftId = Database::lastInsertId();
                
                echo json_encode([
                    'success' => true,
                    'message' => 'Draft saved successfully',
                    'draft_id' => $draftId
                ]);
            }
        } catch (\Exception $e) {
            error_log("Draft save error: " . $e->getMessage());
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Failed to save draft'
            ]);
        }
    }
    
    /**
     * Get user's drafts
     */
    public function list()
    {
        header('Content-Type: application/json');
        
        if (!isset($_SESSION['user_id'])) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Authentication required']);
            return;
        }
        
        $userId = $_SESSION['user_id'];
        $type = $_GET['type'] ?? null;
        
        try {
            $query = "SELECT * FROM draft_posts WHERE user_id = ?";
            $params = [$userId];
            
            if ($type) {
                $query .= " AND type = ?";
                $params[] = $type;
            }
            
            $query .= " ORDER BY updated_at DESC";
            
            $drafts = Database::query($query, $params);
            
            // Decode JSON fields
            foreach ($drafts as &$draft) {
                $draft['tags'] = json_decode($draft['tags'] ?? '[]', true);
                $draft['metadata'] = json_decode($draft['metadata'] ?? '{}', true);
            }
            
            echo json_encode([
                'success' => true,
                'drafts' => $drafts
            ]);
        } catch (\Exception $e) {
            error_log("Draft list error: " . $e->getMessage());
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Failed to retrieve drafts'
            ]);
        }
    }
    
    /**
     * Delete a draft
     */
    public function delete()
    {
        header('Content-Type: application/json');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'DELETE' && $_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Method not allowed']);
            return;
        }
        
        if (!isset($_SESSION['user_id'])) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Authentication required']);
            return;
        }
        
        $userId = $_SESSION['user_id'];
        $draftId = $_GET['id'] ?? $_POST['id'] ?? null;
        
        if (!$draftId) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Draft ID required']);
            return;
        }
        
        try {
            $result = Database::query(
                "DELETE FROM draft_posts WHERE id = ? AND user_id = ?",
                [$draftId, $userId]
            );
            
            echo json_encode([
                'success' => true,
                'message' => 'Draft deleted successfully'
            ]);
        } catch (\Exception $e) {
            error_log("Draft delete error: " . $e->getMessage());
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Failed to delete draft'
            ]);
        }
    }
}
