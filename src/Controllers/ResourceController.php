<?php

namespace Nebatech\Controllers;

use Nebatech\Core\Controller;
use Nebatech\Core\Database;
use Nebatech\Models\CommunityResource;

class ResourceController extends Controller
{
    /**
     * List all resources
     */
    public function index()
    {
        $filters = [
            'search' => $_GET['search'] ?? null,
            'type' => $_GET['type'] ?? null,
            'category' => $_GET['category'] ?? null,
            'limit' => 50
        ];

        $resources = CommunityResource::getResources($filters);
        $trendingResources = CommunityResource::getTrending(5);

        $categories = Database::fetchAll(
            "SELECT * FROM discussion_categories WHERE is_active = TRUE ORDER BY order_index ASC"
        );

        return $this->view('community/resources', compact('resources', 'trendingResources', 'categories'));
    }

    /**
     * Show single resource
     */
    public function show($uuid)
    {
        $resource = Database::fetch(
            "SELECT cr.*, u.first_name, u.last_name, u.avatar,
                    dc.name as category_name, dc.color as category_color,
                    up.total_xp, up.bio
             FROM community_resources cr
             INNER JOIN users u ON cr.user_id = u.id
             LEFT JOIN discussion_categories dc ON cr.category_id = dc.id
             LEFT JOIN user_profiles up ON u.id = up.user_id
             WHERE cr.uuid = ?",
            [$uuid]
        );

        if (!$resource) {
            $this->redirect('/community/resources');
            return;
        }

        // Increment views
        $resourceModel = new CommunityResource();
        $resourceModel = $resourceModel->where('uuid', $uuid)->first();
        $resourceModel->incrementViews();

        return $this->view('community/resource-detail', compact('resource'));
    }

    /**
     * Create resource form
     */
    public function create()
    {
        if (!$this->isAuthenticated()) {
            $this->redirect('/login');
            return;
        }

        $categories = Database::fetchAll(
            "SELECT * FROM discussion_categories WHERE is_active = TRUE ORDER BY order_index ASC"
        );

        return $this->view('community/resource-create', compact('categories'));
    }

    /**
     * Store new resource
     */
    public function store()
    {
        if (!$this->isAuthenticated()) {
            $this->jsonResponse(['success' => false, 'message' => 'Please sign in']);
            return;
        }

        $input = json_decode(file_get_contents('php://input'), true);

        // Handle file upload if present
        $filePath = null;
        $fileSize = null;
        $fileType = null;

        if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../../storage/uploads/resources/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $fileName = uniqid() . '_' . basename($_FILES['file']['name']);
            $filePath = 'storage/uploads/resources/' . $fileName;
            $fileSize = $_FILES['file']['size'];
            $fileType = $_FILES['file']['type'];

            move_uploaded_file($_FILES['file']['tmp_name'], $uploadDir . $fileName);
        }

        $data = [
            'user_id' => $_SESSION['user_id'],
            'category_id' => $input['category_id'],
            'title' => $input['title'],
            'description' => $input['description'],
            'type' => $input['type'],
            'file_path' => $filePath,
            'url' => $input['url'] ?? null,
            'file_size' => $fileSize,
            'file_type' => $fileType,
            'tags' => $input['tags'] ?? []
        ];

        $uuid = CommunityResource::createResource($data);

        $this->jsonResponse([
            'success' => true,
            'redirect' => '/community/resources/' . $uuid
        ]);
    }

    /**
     * Download resource
     */
    public function download($uuid)
    {
        $resource = Database::fetch(
            "SELECT * FROM community_resources WHERE uuid = ?",
            [$uuid]
        );

        if (!$resource || !$resource['file_path']) {
            $this->redirect('/community/resources');
            return;
        }

        // Increment download count
        $resourceModel = new CommunityResource();
        $resourceModel = $resourceModel->where('uuid', $uuid)->first();
        $resourceModel->incrementDownloads();

        // Serve file
        $filePath = __DIR__ . '/../../' . $resource['file_path'];
        if (file_exists($filePath)) {
            header('Content-Type: ' . ($resource['file_type'] ?? 'application/octet-stream'));
            header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
            header('Content-Length: ' . filesize($filePath));
            readfile($filePath);
            exit;
        }

        $this->redirect('/community/resources/' . $uuid);
    }
}
