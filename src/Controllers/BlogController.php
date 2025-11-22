<?php

namespace Nebatech\Controllers;

use Nebatech\Core\Controller;
use Nebatech\Core\Database;

class BlogController extends Controller
{
    public function index()
    {
        // Get filter parameters
        $category = $_GET['category'] ?? 'all';
        $tag = $_GET['tag'] ?? null;
        $search = $_GET['search'] ?? null;
        
        // Build query
        $query = "SELECT bp.*, bc.name as category_name, bc.slug as category_slug,
                         u.first_name, u.last_name, u.avatar as author_avatar
                  FROM blog_posts bp
                  LEFT JOIN blog_categories bc ON bp.category_id = bc.id
                  LEFT JOIN users u ON bp.author_id = u.id
                  WHERE bp.status = 'published'";
        
        $params = [];
        
        if ($category !== 'all') {
            $query .= " AND bc.slug = ?";
            $params[] = $category;
        }
        
        if ($tag) {
            $query .= " AND JSON_CONTAINS(bp.tags, ?)";
            $params[] = json_encode($tag);
        }
        
        if ($search) {
            $query .= " AND (bp.title LIKE ? OR bp.excerpt LIKE ? OR bp.content LIKE ?)";
            $searchTerm = "%{$search}%";
            $params[] = $searchTerm;
            $params[] = $searchTerm;
            $params[] = $searchTerm;
        }
        
        $query .= " ORDER BY bp.published_at DESC LIMIT 50";
        
        $posts = Database::fetchAll($query, $params);
        
        // Process posts
        foreach ($posts as &$post) {
            $post['author_name'] = $post['first_name'] . ' ' . $post['last_name'];
            if ($post['tags']) {
                $post['tags'] = json_decode($post['tags'], true);
            }
        }
        
        // Get categories
        $categories = Database::fetchAll(
            "SELECT * FROM blog_categories WHERE status = 'active' ORDER BY order_index ASC"
        );
        
        // Get featured post
        $featuredPost = Database::fetch(
            "SELECT bp.*, bc.name as category_name,
                    u.first_name, u.last_name, u.avatar as author_avatar
             FROM blog_posts bp
             LEFT JOIN blog_categories bc ON bp.category_id = bc.id
             LEFT JOIN users u ON bp.author_id = u.id
             WHERE bp.status = 'published' AND bp.is_featured = 1
             ORDER BY bp.published_at DESC LIMIT 1"
        );
        
        if ($featuredPost) {
            $featuredPost['author_name'] = $featuredPost['first_name'] . ' ' . $featuredPost['last_name'];
        }
        
        echo $this->view('blog.index', [
            'title' => 'Blog & Resources',
            'posts' => $posts,
            'categories' => $categories,
            'featuredPost' => $featuredPost,
            'currentCategory' => $category
        ]);
    }

    public function show($params)
    {
        $slug = $params['slug'] ?? '';
        
        if (empty($slug)) {
            header('Location: ' . url('/blog'));
            exit;
        }
        
        // Get post
        $post = Database::fetch(
            "SELECT bp.*, bc.name as category, bc.slug as category_slug,
                    u.first_name, u.last_name, u.avatar as author_avatar
             FROM blog_posts bp
             LEFT JOIN blog_categories bc ON bp.category_id = bc.id
             LEFT JOIN users u ON bp.author_id = u.id
             WHERE bp.slug = ? AND bp.status = 'published'",
            [$slug]
        );
        
        if (!$post) {
            header('Location: ' . url('/blog'));
            exit;
        }
        
        // Increment views
        Database::query(
            "UPDATE blog_posts SET views = views + 1 WHERE id = ?",
            [$post['id']]
        );
        
        // Process post data
        $post['author_name'] = $post['first_name'] . ' ' . $post['last_name'];
        if ($post['tags']) {
            $post['tags'] = json_decode($post['tags'], true);
        }
        
        // Get comments
        $comments = Database::fetchAll(
            "SELECT bc.*, u.first_name, u.last_name, u.avatar
             FROM blog_comments bc
             INNER JOIN users u ON bc.user_id = u.id
             WHERE bc.post_id = ? AND bc.status = 'approved' AND bc.parent_id IS NULL
             ORDER BY bc.created_at DESC",
            [$post['id']]
        );
        
        foreach ($comments as &$comment) {
            $comment['name'] = $comment['first_name'] . ' ' . $comment['last_name'];
        }
        
        // Get related posts
        $relatedPosts = Database::fetchAll(
            "SELECT id, title, slug, featured_image, published_at
             FROM blog_posts
             WHERE category_id = ? AND id != ? AND status = 'published'
             ORDER BY published_at DESC LIMIT 3",
            [$post['category_id'], $post['id']]
        );
        
        echo $this->view('blog.show', [
            'title' => $post['title'],
            'post' => $post,
            'comments' => $comments,
            'relatedPosts' => $relatedPosts
        ]);
    }
    
    public function comment()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . url('/blog'));
            exit;
        }
        
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'You must be logged in to comment';
            header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? url('/blog')));
            exit;
        }
        
        $postId = $_POST['post_id'] ?? null;
        $content = trim($_POST['content'] ?? '');
        $parentId = $_POST['parent_id'] ?? null;
        
        if (empty($postId) || empty($content)) {
            $_SESSION['error'] = 'All fields are required';
            header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? url('/blog')));
            exit;
        }
        
        // Insert comment
        Database::query(
            "INSERT INTO blog_comments (post_id, user_id, parent_id, content, status, created_at)
             VALUES (?, ?, ?, ?, 'approved', NOW())",
            [$postId, $_SESSION['user_id'], $parentId, $content]
        );
        
        $_SESSION['success'] = 'Comment posted successfully!';
        header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? url('/blog')));
        exit;
    }
}
