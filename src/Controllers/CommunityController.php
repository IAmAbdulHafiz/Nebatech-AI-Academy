<?php

namespace Nebatech\Controllers;

use Nebatech\Core\Controller;
use Nebatech\Core\Database;
use Nebatech\Models\DiscussionPost;
use Nebatech\Models\UserProfile;

class CommunityController extends Controller
{
    /**
     * Community home page
     */
    public function index()
    {
        // Get categories
        $categories = Database::fetchAll(
            "SELECT dc.*, COUNT(dp.id) as posts_count
             FROM discussion_categories dc
             LEFT JOIN discussion_posts dp ON dc.id = dp.category_id
             WHERE dc.is_active = TRUE AND dc.parent_id IS NULL
             GROUP BY dc.id
             ORDER BY dc.order_index ASC"
        );

        // Get trending posts
        $trendingPosts = DiscussionPost::getTrending(5);

        // Get recent posts
        $recentPosts = Database::fetchAll(
            "SELECT dp.*, u.first_name, u.last_name, u.avatar,
                    dc.name as category_name, dc.color as category_color,
                    dc.slug as category_slug
             FROM discussion_posts dp
             INNER JOIN users u ON dp.user_id = u.id
             INNER JOIN discussion_categories dc ON dp.category_id = dc.id
             ORDER BY dp.is_pinned DESC, dp.last_activity_at DESC
             LIMIT 20"
        );

        // Get leaderboard
        $leaderboard = UserProfile::getLeaderboard('weekly', 5);

        // Get active users
        $activeUsers = Database::fetchAll(
            "SELECT u.id, u.first_name, u.last_name, u.avatar, up.total_xp
             FROM users u
             INNER JOIN user_profiles up ON u.id = up.user_id
             WHERE up.last_active_date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
             ORDER BY up.last_active_date DESC
             LIMIT 10"
        );

        // Get upcoming events
        $upcomingEvents = Database::fetchAll(
            "SELECT * FROM community_events
             WHERE status = 'upcoming' AND start_time > NOW()
             ORDER BY start_time ASC
             LIMIT 3"
        );

        // Stats
        $stats = [
            'total_posts' => Database::fetch("SELECT COUNT(*) as count FROM discussion_posts")['count'],
            'total_members' => Database::fetch("SELECT COUNT(*) as count FROM users WHERE status = 'active'")['count'],
            'active_discussions' => Database::fetch("SELECT COUNT(*) as count FROM discussion_posts WHERE last_activity_at >= DATE_SUB(NOW(), INTERVAL 24 HOUR)")['count']
        ];

        return $this->view('community/index', compact(
            'categories',
            'trendingPosts',
            'recentPosts',
            'leaderboard',
            'activeUsers',
            'upcomingEvents',
            'stats'
        ));
    }

    /**
     * Show category posts
     */
    public function category(string $slug)
    {
        $category = Database::fetch(
            "SELECT * FROM discussion_categories WHERE slug = ?",
            [$slug]
        );

        if (!$category) {
            $this->redirect('/community');
            return;
        }

        $posts = Database::fetchAll(
            "SELECT dp.*, u.first_name, u.last_name, u.avatar, u.role,
                    up.total_xp
             FROM discussion_posts dp
             INNER JOIN users u ON dp.user_id = u.id
             LEFT JOIN user_profiles up ON u.id = up.user_id
             WHERE dp.category_id = ?
             ORDER BY dp.is_pinned DESC, dp.last_activity_at DESC
             LIMIT 50",
            [$category['id']]
        );

        return $this->view('community/category', compact('category', 'posts'));
    }

    /**
     * Show single post
     */
    public function show(string $uuid)
    {
        $userId = $_SESSION['user_id'] ?? null;
        
        $post = Database::fetch(
            "SELECT dp.*, u.first_name, u.last_name, u.avatar, u.role,
                    up.total_xp, up.bio,
                    dc.name as category_name, dc.slug as category_slug, 
                    dc.color as category_color, dc.icon as category_icon,
                    " . ($userId ? "(SELECT COUNT(*) FROM discussion_likes 
                         WHERE likeable_type = 'post' AND likeable_id = dp.id 
                         AND user_id = ?) as user_liked" : "0 as user_liked") . "
             FROM discussion_posts dp
             INNER JOIN users u ON dp.user_id = u.id
             LEFT JOIN user_profiles up ON u.id = up.user_id
             INNER JOIN discussion_categories dc ON dp.category_id = dc.id
             WHERE dp.uuid = ?",
            $userId ? [$userId, $uuid] : [$uuid]
        );

        if (!$post) {
            $this->redirect('/community');
            return;
        }

        // Add author info to post
        $post['author_id'] = $post['user_id'];
        $post['author_name'] = $post['first_name'] . ' ' . $post['last_name'];
        $post['author_avatar'] = $post['avatar'];
        $post['author_xp'] = $post['total_xp'];
        $post['author_bio'] = $post['bio'];

        // Increment view count
        $postModel = new DiscussionPost();
        $postRecord = $postModel->findBy('uuid', $uuid);
        if ($postRecord) {
            Database::execute(
                "UPDATE discussion_posts SET views_count = views_count + 1 WHERE uuid = ?",
                [$uuid]
            );
        }

        // Get comments
        $comments = Database::fetchAll(
            "SELECT dc.*, u.first_name, u.last_name, u.avatar, u.role,
                    up.total_xp,
                    (SELECT COUNT(*) FROM discussion_likes 
                     WHERE likeable_type = 'comment' AND likeable_id = dc.id) as likes_count
             FROM discussion_comments dc
             INNER JOIN users u ON dc.user_id = u.id
             LEFT JOIN user_profiles up ON u.id = up.user_id
             WHERE dc.post_id = ?
             ORDER BY dc.is_solution DESC, dc.created_at ASC",
            [$postModel->id]
        );

        // Add author info to comments
        foreach ($comments as &$comment) {
            $comment['author_id'] = $comment['user_id'];
            $comment['author_name'] = $comment['first_name'] . ' ' . $comment['last_name'];
            $comment['author_avatar'] = $comment['avatar'];
            $comment['author_xp'] = $comment['total_xp'];
        }

        return $this->view('community/post', compact('post', 'comments'));
    }

    /**
     * Create post form
     */
    public function create()
    {
        if (!$this->isAuthenticated()) {
            $this->redirect('/login');
            return;
        }

        $categories = Database::fetchAll(
            "SELECT * FROM discussion_categories 
             WHERE is_active = TRUE 
             ORDER BY order_index ASC"
        );

        return $this->view('community/create', compact('categories'));
    }

    /**
     * Store new post
     */
    public function store()
    {
        if (!$this->isAuthenticated()) {
            $this->jsonResponse(['error' => 'Unauthorized'], 401);
            return;
        }

        try {
            // Get JSON input
            $input = json_decode(file_get_contents('php://input'), true);
            
            // Fallback to $_POST if JSON is not available
            if (!$input) {
                $input = $_POST;
            }

            $data = [
                'category_id' => $input['category_id'] ?? null,
                'user_id' => $_SESSION['user_id'],
                'title' => $input['title'] ?? '',
                'content' => $input['content'] ?? '',
                'post_type' => $input['type'] ?? 'discussion',
                'tags' => isset($input['tags']) ? (is_array($input['tags']) ? $input['tags'] : explode(',', $input['tags'])) : []
            ];

            $post = DiscussionPost::createPost($data);

            if ($post) {
                $this->jsonResponse([
                    'success' => true,
                    'redirect' => url("/community/post/{$post->uuid}")
                ]);
            } else {
                $this->jsonResponse(['error' => 'Failed to create post'], 500);
            }
        } catch (\Exception $e) {
            error_log("Error creating post: " . $e->getMessage());
            $this->jsonResponse(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Add comment to post
     */
    public function addComment(string $uuid)
    {
        if (!$this->isAuthenticated()) {
            $this->jsonResponse(['error' => 'Unauthorized'], 401);
            return;
        }

        $post = new DiscussionPost();
        $post = $post->where('uuid', $uuid)->first();

        if (!$post) {
            $this->jsonResponse(['error' => 'Post not found'], 404);
            return;
        }

        $content = $_POST['content'] ?? '';
        $parentId = $_POST['parent_id'] ?? null;

        if (empty($content)) {
            $this->jsonResponse(['error' => 'Content is required'], 400);
            return;
        }

        $comment = $post->addComment($_SESSION['user_id'], $content, $parentId);

        if ($comment) {
            $this->jsonResponse([
                'success' => true,
                'comment' => $comment
            ]);
        } else {
            $this->jsonResponse(['error' => 'Failed to add comment'], 500);
        }
    }

    /**
     * Toggle like on post
     */
    public function toggleLike(string $uuid)
    {
        if (!$this->isAuthenticated()) {
            $this->jsonResponse(['error' => 'Unauthorized'], 401);
            return;
        }

        $post = new DiscussionPost();
        $post = $post->where('uuid', $uuid)->first();

        if (!$post) {
            $this->jsonResponse(['error' => 'Post not found'], 404);
            return;
        }

        $liked = $post->toggleLike($_SESSION['user_id']);

        $this->jsonResponse([
            'success' => true,
            'liked' => $liked,
            'likes_count' => $post->likes_count + ($liked ? 1 : -1)
        ]);
    }

    /**
     * Search posts
     */
    public function search()
    {
        $query = $_GET['q'] ?? '';
        $categoryId = $_GET['category'] ?? null;

        if (empty($query)) {
            $this->jsonResponse(['results' => []]);
            return;
        }

        $results = DiscussionPost::search($query, $categoryId);

        $this->jsonResponse(['results' => $results]);
    }

    /**
     * User profile
     */
    public function profile(string $userId)
    {
        $user = Database::fetch(
            "SELECT u.*, up.*
             FROM users u
             LEFT JOIN user_profiles up ON u.id = up.user_id
             WHERE u.id = ?",
            [$userId]
        );

        if (!$user) {
            $this->redirect('/community');
            return;
        }

        // Get user's posts
        $posts = Database::fetchAll(
            "SELECT dp.*, dc.name as category_name, dc.slug as category_slug
             FROM discussion_posts dp
             INNER JOIN discussion_categories dc ON dp.category_id = dc.id
             WHERE dp.user_id = ?
             ORDER BY dp.created_at DESC
             LIMIT 20",
            [$userId]
        );

        // Get user's badges
        $profile = UserProfile::getOrCreate($userId);
        $badges = $profile->getBadges();

        // Get enrolled courses
        $courses = Database::fetchAll(
            "SELECT c.*, e.progress, e.status
             FROM courses c
             INNER JOIN enrollments e ON c.id = e.course_id
             WHERE e.user_id = ?
             ORDER BY e.enrolled_at DESC",
            [$userId]
        );

        return $this->view('community/profile', compact('user', 'posts', 'badges', 'courses'));
    }

    /**
     * Mark comment as solution
     */
    public function markSolution($uuid)
    {
        if (!$this->isAuthenticated()) {
            $this->jsonResponse(['success' => false, 'message' => 'Please sign in']);
            return;
        }

        // Get post
        $post = Database::fetch(
            "SELECT * FROM discussion_posts WHERE uuid = ?",
            [$uuid]
        );

        if (!$post) {
            $this->jsonResponse(['success' => false, 'message' => 'Post not found']);
            return;
        }

        // Check if user is post author
        if ($post['user_id'] != $_SESSION['user_id']) {
            $this->jsonResponse(['success' => false, 'message' => 'Only post author can mark solution']);
            return;
        }

        // Get comment UUID from request
        $input = json_decode(file_get_contents('php://input'), true);
        $commentUuid = $input['comment_uuid'] ?? null;

        if (!$commentUuid) {
            $this->jsonResponse(['success' => false, 'message' => 'Comment not specified']);
            return;
        }

        // Mark as solution
        $discussionPost = new DiscussionPost();
        $result = $discussionPost->markSolved($commentUuid);

        if ($result) {
            $this->jsonResponse(['success' => true]);
        } else {
            $this->jsonResponse(['success' => false, 'message' => 'Failed to mark solution']);
        }
    }

    /**
     * Leaderboard
     */
    public function leaderboard()
    {
        $period = $_GET['period'] ?? 'all';
        $leaderboard = UserProfile::getLeaderboard($period, 50);

        return $this->view('community/leaderboard', compact('leaderboard', 'period'));
    }

    /**
     * All discussions
     */
    public function discussions()
    {
        $page = $_GET['page'] ?? 1;
        $perPage = 20;
        $offset = ($page - 1) * $perPage;

        // Get filter parameters
        $categoryId = $_GET['category'] ?? null;
        $postType = $_GET['type'] ?? null;
        $sort = $_GET['sort'] ?? 'recent';

        // Build query
        $where = [];
        $params = [];

        if ($categoryId) {
            $where[] = "dp.category_id = ?";
            $params[] = $categoryId;
        }

        if ($postType) {
            $where[] = "dp.post_type = ?";
            $params[] = $postType;
        }

        $whereClause = $where ? 'WHERE ' . implode(' AND ', $where) : '';

        // Sorting
        $orderBy = match($sort) {
            'popular' => 'dp.likes_count DESC, dp.views_count DESC',
            'trending' => '(dp.likes_count + dp.comments_count * 2) DESC',
            'unanswered' => 'dp.comments_count ASC, dp.created_at DESC',
            default => 'dp.is_pinned DESC, dp.last_activity_at DESC'
        };

        // Get posts
        $posts = Database::fetchAll(
            "SELECT dp.*, u.first_name, u.last_name, u.avatar,
                    dc.name as category_name, dc.color as category_color,
                    dc.slug as category_slug
             FROM discussion_posts dp
             INNER JOIN users u ON dp.user_id = u.id
             INNER JOIN discussion_categories dc ON dp.category_id = dc.id
             $whereClause
             ORDER BY $orderBy
             LIMIT $perPage OFFSET $offset",
            $params
        );

        // Get total count
        $total = Database::fetch(
            "SELECT COUNT(*) as count
             FROM discussion_posts dp
             $whereClause",
            $params
        )['count'];

        // Get categories for filter
        $categories = Database::fetchAll(
            "SELECT * FROM discussion_categories 
             WHERE is_active = TRUE 
             ORDER BY order_index ASC"
        );

        $totalPages = ceil($total / $perPage);

        return $this->view('community/discussions', compact(
            'posts', 'categories', 'page', 'totalPages', 'categoryId', 'postType', 'sort'
        ));
    }

    /**
     * Community guidelines
     */
    public function guidelines()
    {
        return $this->view('community/guidelines');
    }
}


