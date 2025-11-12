<?php

namespace Nebatech\Models;

use Nebatech\Core\Model;
use Nebatech\Core\Database;
use Nebatech\Models\Notification;

class Course extends Model
{
    protected string $table = 'courses';
    protected string $primaryKey = 'id';

    /**
     * Get all courses with optional filters
     */
    public static function getAll(array $filters = []): array
    {
        $sql = "SELECT c.*, 
                       u.first_name as facilitator_first_name,
                       u.last_name as facilitator_last_name,
                       cc.name as category_name,
                       cc.slug as category_slug,
                       (SELECT COUNT(*) FROM enrollments WHERE course_id = c.id) as enrollment_count
                FROM " . 'courses' . " c
                LEFT JOIN users u ON c.facilitator_id = u.id
                LEFT JOIN course_categories cc ON c.category_id = cc.id";
        
        $params = [];
        $conditions = [];

        if (!empty($filters['category'])) {
            $conditions[] = "cc.slug = :category";
            $params['category'] = $filters['category'];
        }

        if (!empty($filters['category_id'])) {
            $conditions[] = "c.category_id = :category_id";
            $params['category_id'] = $filters['category_id'];
        }

        if (!empty($filters['level'])) {
            $conditions[] = "c.level = :level";
            $params['level'] = $filters['level'];
        }

        if (!empty($filters['status'])) {
            $conditions[] = "c.status = :status";
            $params['status'] = $filters['status'];
        } else {
            // By default, only show published courses
            $conditions[] = "c.status = 'published'";
        }

        if (!empty($filters['facilitator_id'])) {
            $conditions[] = "c.facilitator_id = :facilitator_id";
            $params['facilitator_id'] = $filters['facilitator_id'];
        }

        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(' AND ', $conditions);
        }

        $sql .= " ORDER BY c.created_at DESC";

        if (!empty($filters['limit'])) {
            $sql .= " LIMIT " . (int)$filters['limit'];
            
            if (!empty($filters['offset'])) {
                $sql .= " OFFSET " . (int)$filters['offset'];
            }
        }

        return Database::fetchAll($sql, $params);
    }

    /**
     * Find course by slug
     */
    public static function findBySlug(string $slug): ?array
    {
        $sql = "SELECT c.*, 
                       u.first_name as facilitator_first_name,
                       u.last_name as facilitator_last_name,
                       u.avatar as facilitator_avatar,
                       cc.name as category_name,
                       cc.slug as category_slug,
                       (SELECT COUNT(*) FROM enrollments WHERE course_id = c.id) as enrollment_count
                FROM " . 'courses' . " c
                LEFT JOIN users u ON c.facilitator_id = u.id
                LEFT JOIN course_categories cc ON c.category_id = cc.id
                WHERE c.slug = :slug LIMIT 1";
        
        return Database::fetch($sql, ['slug' => $slug]);
    }

    /**
     * Find course by ID with details
     */
    public static function findById(int $id): ?array
    {
        $sql = "SELECT c.*, 
                       u.first_name as facilitator_first_name,
                       u.last_name as facilitator_last_name,
                       u.avatar as facilitator_avatar,
                       u.email as facilitator_email,
                       cc.name as category_name,
                       cc.slug as category_slug,
                       (SELECT COUNT(*) FROM enrollments WHERE course_id = c.id) as enrollment_count
                FROM " . 'courses' . " c
                LEFT JOIN users u ON c.facilitator_id = u.id
                LEFT JOIN course_categories cc ON c.category_id = cc.id
                WHERE c.id = :id LIMIT 1";
        
        return Database::fetch($sql, ['id' => $id]);
    }

    /**
     * Create a new course
     */
    public static function create(array $data): ?int
    {
        // Generate UUID if not provided
        if (!isset($data['uuid'])) {
            $data['uuid'] = self::generateUuid();
        }

        // Generate slug from title if not provided
        if (!isset($data['slug']) && isset($data['title'])) {
            $data['slug'] = self::generateSlug($data['title']);
        }

        // Set default status if not provided
        if (!isset($data['status'])) {
            $data['status'] = 'draft';
        }

        // Set default level if not provided
        if (!isset($data['level'])) {
            $data['level'] = 'beginner';
        }

        try {
            return Database::insert('courses', $data);
        } catch (\Exception $e) {
            error_log("Course creation failed: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Update course
     */
    public static function updateById(int $courseId, array $data): bool
    {
        // Remove fields that shouldn't be updated directly
        unset($data['id'], $data['uuid'], $data['created_at']);

        // Update slug if title changed
        if (isset($data['title']) && !isset($data['slug'])) {
            $data['slug'] = self::generateSlug($data['title']);
        }

        if (empty($data)) {
            return false;
        }

        $result = Database::update(
            'courses',
            $data,
            'id = :id',
            ['id' => $courseId]
        );

        return $result > 0;
    }

    /**
     * Delete course
     */
    public static function deleteById(int $courseId): bool
    {
        $result = Database::delete('courses', 'id = :id', ['id' => $courseId]);
        return $result > 0;
    }

    /**
     * Get courses by category
     */
    public static function getByCategory(string $category, int $limit = null): array
    {
        $filters = [
            'category' => $category,
            'status' => 'published'
        ];

        if ($limit) {
            $filters['limit'] = $limit;
        }

        return self::getAll($filters);
    }

    /**
     * Get courses by category ID
     */
    public static function getByCategoryId(int $categoryId, int $limit = null): array
    {
        $filters = [
            'category_id' => $categoryId,
            'status' => 'published'
        ];

        if ($limit) {
            $filters['limit'] = $limit;
        }

        return self::getAll($filters);
    }

    /**
     * Get courses by facilitator with approval status filter
     */
    public static function getByFacilitator(int $facilitatorId, array $filters = []): array
    {
        $sql = "SELECT c.*, 
                       (SELECT COUNT(*) FROM enrollments WHERE course_id = c.id) as enrollment_count,
                       (SELECT COUNT(*) FROM modules WHERE course_id = c.id) as module_count
                FROM courses c
                WHERE c.facilitator_id = :facilitator_id";
        
        $params = ['facilitator_id' => $facilitatorId];

        if (!empty($filters['approval_status'])) {
            $sql .= " AND c.approval_status = :approval_status";
            $params['approval_status'] = $filters['approval_status'];
        }

        if (!empty($filters['status'])) {
            $sql .= " AND c.status = :status";
            $params['status'] = $filters['status'];
        }

        $sql .= " ORDER BY c.created_at DESC";

        return Database::fetchAll($sql, $params);
    }

    /**
     * Search courses
     */
    public static function search(string $query, array $filters = []): array
    {
        $sql = "SELECT c.*, 
                       u.first_name as facilitator_first_name,
                       u.last_name as facilitator_last_name,
                       cc.name as category_name,
                       cc.slug as category_slug,
                       (SELECT COUNT(*) FROM enrollments WHERE course_id = c.id) as enrollment_count
                FROM " . 'courses' . " c
                LEFT JOIN users u ON c.facilitator_id = u.id
                LEFT JOIN course_categories cc ON c.category_id = cc.id
                WHERE (c.title LIKE :query OR c.description LIKE :query OR cc.name LIKE :query)";
        
        $params = ['query' => "%$query%"];

        if (!empty($filters['category'])) {
            $sql .= " AND cc.slug = :category";
            $params['category'] = $filters['category'];
        }

        if (!empty($filters['category_id'])) {
            $sql .= " AND c.category_id = :category_id";
            $params['category_id'] = $filters['category_id'];
        }

        if (!empty($filters['level'])) {
            $sql .= " AND c.level = :level";
            $params['level'] = $filters['level'];
        }

        $sql .= " AND c.status = 'published' ORDER BY c.created_at DESC";

        if (!empty($filters['limit'])) {
            $sql .= " LIMIT " . (int)$filters['limit'];
        }

        return Database::fetchAll($sql, $params);
    }

    /**
     * Get course statistics
     */
    public static function getStats(): array
    {
        $sql = "SELECT 
                    COUNT(*) as total,
                    SUM(CASE WHEN status = 'published' THEN 1 ELSE 0 END) as published,
                    SUM(CASE WHEN status = 'draft' THEN 1 ELSE 0 END) as draft,
                    SUM(CASE WHEN level = 'beginner' THEN 1 ELSE 0 END) as beginner,
                    SUM(CASE WHEN level = 'intermediate' THEN 1 ELSE 0 END) as intermediate,
                    SUM(CASE WHEN level = 'advanced' THEN 1 ELSE 0 END) as advanced,
                    (SELECT COUNT(*) FROM enrollments) as total_enrollments
                FROM " . 'courses';
        
        return Database::fetch($sql) ?? [
            'total' => 0,
            'published' => 0,
            'draft' => 0,
            'beginner' => 0,
            'intermediate' => 0,
            'advanced' => 0,
            'total_enrollments' => 0
        ];
    }

    /**
     * Get popular courses
     */
    public static function getPopular(int $limit = 10): array
    {
        $sql = "SELECT c.*, 
                       u.first_name as facilitator_first_name,
                       u.last_name as facilitator_last_name,
                       cc.name as category_name,
                       cc.slug as category_slug,
                       COUNT(e.id) as enrollment_count
                FROM " . 'courses' . " c
                LEFT JOIN users u ON c.facilitator_id = u.id
                LEFT JOIN course_categories cc ON c.category_id = cc.id
                LEFT JOIN enrollments e ON c.id = e.course_id
                WHERE c.status = 'published'
                GROUP BY c.id
                ORDER BY enrollment_count DESC
                LIMIT :limit";
        
        return Database::fetchAll($sql, ['limit' => $limit]);
    }

    /**
     * Check if slug exists
     */
    public static function slugExists(string $slug, ?int $excludeId = null): bool
    {
        $sql = "SELECT COUNT(*) as count FROM " . 'courses' . " WHERE slug = :slug";
        $params = ['slug' => $slug];

        if ($excludeId) {
            $sql .= " AND id != :id";
            $params['id'] = $excludeId;
        }

        $result = Database::fetch($sql, $params);
        return $result && $result['count'] > 0;
    }

    /**
     * Generate slug from title
     */
    protected static function generateSlug(string $title): string
    {
        $slug = strtolower($title);
        $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
        $slug = trim($slug, '-');

        // Ensure uniqueness
        $originalSlug = $slug;
        $counter = 1;
        while (self::slugExists($slug)) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Generate UUID v4
     */
    protected static function generateUuid(): string
    {
        $data = random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
        
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    /**
     * Publish course
     */
    public static function publish(int $courseId): bool
    {
        return self::updateById($courseId, ['status' => 'published']);
    }

    /**
     * Archive course
     */
    public static function archive(int $courseId): bool
    {
        return self::updateById($courseId, ['status' => 'archived']);
    }

    /**
     * Get all cohorts teaching this course
     */
    public static function getCohorts(int $courseId): array
    {
        $sql = "SELECT co.*, cc.start_date as cohort_start_date, 
                       cc.end_date as cohort_end_date, cc.order_index,
                       u.first_name as facilitator_first_name,
                       u.last_name as facilitator_last_name,
                       (SELECT COUNT(*) FROM cohort_assignments WHERE cohort_id = co.id) as student_count
                FROM cohort_courses cc
                INNER JOIN cohorts co ON cc.cohort_id = co.id
                LEFT JOIN users u ON co.facilitator_id = u.id
                WHERE cc.course_id = :course_id
                ORDER BY co.start_date DESC";

        return Database::fetchAll($sql, ['course_id' => $courseId]);
    }

    /**
     * Get active cohorts for this course
     */
    public static function getActiveCohorts(int $courseId): array
    {
        $sql = "SELECT co.*, cc.start_date as cohort_start_date, 
                       cc.end_date as cohort_end_date,
                       u.first_name as facilitator_first_name,
                       u.last_name as facilitator_last_name,
                       (SELECT COUNT(*) FROM cohort_assignments WHERE cohort_id = co.id) as student_count
                FROM cohort_courses cc
                INNER JOIN cohorts co ON cc.cohort_id = co.id
                LEFT JOIN users u ON co.facilitator_id = u.id
                WHERE cc.course_id = :course_id AND co.status = 'active'
                ORDER BY co.start_date DESC";

        return Database::fetchAll($sql, ['course_id' => $courseId]);
    }

    /**
     * Get enrollments for this course
     */
    public static function getEnrollments(int $courseId, ?array $filters = []): array
    {
        $sql = "SELECT e.*, 
                       u.first_name, u.last_name, u.email, u.avatar,
                       co.name as cohort_name, co.id as cohort_id
                FROM enrollments e
                INNER JOIN users u ON e.user_id = u.id
                LEFT JOIN cohorts co ON e.cohort_id = co.id
                WHERE e.course_id = :course_id";
        
        $params = ['course_id' => $courseId];

        if (!empty($filters['status'])) {
            $sql .= " AND e.status = :status";
            $params['status'] = $filters['status'];
        }

        if (!empty($filters['cohort_id'])) {
            $sql .= " AND e.cohort_id = :cohort_id";
            $params['cohort_id'] = $filters['cohort_id'];
        }

        // Filter for self-paced (no cohort)
        if (isset($filters['self_paced']) && $filters['self_paced']) {
            $sql .= " AND e.cohort_id IS NULL";
        }

        $sql .= " ORDER BY e.enrolled_at DESC";

        return Database::fetchAll($sql, $params);
    }

    /**
     * Get course enrollment statistics
     */
    public static function getEnrollmentStats(int $courseId): array
    {
        $sql = "SELECT 
                    COUNT(*) as total_enrollments,
                    SUM(CASE WHEN status = 'active' THEN 1 ELSE 0 END) as active_enrollments,
                    SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) as completed_enrollments,
                    SUM(CASE WHEN cohort_id IS NULL THEN 1 ELSE 0 END) as self_paced_enrollments,
                    SUM(CASE WHEN cohort_id IS NOT NULL THEN 1 ELSE 0 END) as cohort_enrollments,
                    AVG(progress) as average_progress
                FROM enrollments
                WHERE course_id = :course_id";
        
        return Database::fetch($sql, ['course_id' => $courseId]) ?? [
            'total_enrollments' => 0,
            'active_enrollments' => 0,
            'completed_enrollments' => 0,
            'self_paced_enrollments' => 0,
            'cohort_enrollments' => 0,
            'average_progress' => 0
        ];
    }

    /**
     * Check if user is enrolled in course
     */
    public static function isUserEnrolled(int $courseId, int $userId): bool
    {
        $sql = "SELECT COUNT(*) as count FROM enrollments 
                WHERE course_id = :course_id AND user_id = :user_id";
        
        $result = Database::fetch($sql, [
            'course_id' => $courseId,
            'user_id' => $userId
        ]);

        return $result && $result['count'] > 0;
    }

    /**
     * Enroll user in course (self-paced)
     */
    public static function enrollUser(int $courseId, int $userId): ?int
    {
        // Check if already enrolled
        if (self::isUserEnrolled($courseId, $userId)) {
            return null;
        }

        try {
            return Database::insert('enrollments', [
                'user_id' => $userId,
                'course_id' => $courseId,
                'status' => 'active',
                'cohort_id' => null // Self-paced enrollment
            ]);
        } catch (\Exception $e) {
            error_log("Course enrollment failed: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Get user's enrollment in this course
     */
    public static function getUserEnrollment(int $courseId, int $userId): ?array
    {
        $sql = "SELECT e.*, co.name as cohort_name
                FROM enrollments e
                LEFT JOIN cohorts co ON e.cohort_id = co.id
                WHERE e.course_id = :course_id AND e.user_id = :user_id
                LIMIT 1";
        
        return Database::fetch($sql, [
            'course_id' => $courseId,
            'user_id' => $userId
        ]);
    }

    /**
     * Submit course for approval
     */
    public static function submitForApproval(int $courseId): bool
    {
        $result = self::updateById($courseId, [
            'approval_status' => 'pending_approval'
        ]);

        if ($result) {
            // Log approval history
            Database::insert('approval_history', [
                'entity_type' => 'course',
                'entity_id' => $courseId,
                'action' => 'submitted'
            ]);

            // Notify admins
            self::notifyAdminsOfPendingCourse($courseId);
        }

        return $result;
    }

    /**
     * Approve course
     */
    public static function approve(int $courseId, int $adminId, ?string $reason = null): bool
    {
        $result = self::updateById($courseId, [
            'approval_status' => 'approved',
            'status' => 'published', // Also publish the course
            'approved_by' => $adminId,
            'approved_at' => date('Y-m-d H:i:s')
        ]);

        if ($result) {
            // Log approval history
            Database::insert('approval_history', [
                'entity_type' => 'course',
                'entity_id' => $courseId,
                'action' => 'approved',
                'admin_id' => $adminId,
                'reason' => $reason
            ]);

            // Notify facilitator
            $course = self::findById($courseId);
            if ($course && $course['facilitator_id']) {
                Notification::create([
                    'user_id' => $course['facilitator_id'],
                    'type' => 'course_approved',
                    'title' => 'Course Approved',
                    'message' => "Your course '{$course['title']}' has been approved and published!",
                    'action_url' => '/facilitator/courses'
                ]);
            }
        }

        return $result;
    }

    /**
     * Reject course
     */
    public static function reject(int $courseId, int $adminId, string $reason): bool
    {
        $result = self::updateById($courseId, [
            'approval_status' => 'rejected',
            'rejection_reason' => $reason
        ]);

        if ($result) {
            // Log approval history
            Database::insert('approval_history', [
                'entity_type' => 'course',
                'entity_id' => $courseId,
                'action' => 'rejected',
                'admin_id' => $adminId,
                'reason' => $reason
            ]);

            // Notify facilitator
            $course = self::findById($courseId);
            if ($course && $course['facilitator_id']) {
                Notification::create([
                    'user_id' => $course['facilitator_id'],
                    'type' => 'course_rejected',
                    'title' => 'Course Needs Revision',
                    'message' => "Your course '{$course['title']}' needs revision: {$reason}",
                    'action_url' => '/facilitator/courses'
                ]);
            }
        }

        return $result;
    }

    /**
     * Get pending courses for approval
     */
    public static function getPendingApprovals(): array
    {
        $sql = "SELECT c.*, 
                       u.first_name as facilitator_first_name,
                       u.last_name as facilitator_last_name,
                       u.email as facilitator_email,
                       (SELECT COUNT(*) FROM modules WHERE course_id = c.id) as module_count
                FROM courses c
                LEFT JOIN users u ON c.facilitator_id = u.id
                WHERE c.approval_status = 'pending_approval'
                ORDER BY c.created_at ASC";
        
        return Database::fetchAll($sql);
    }

    /**
     * Notify admins of pending course
     */
    protected static function notifyAdminsOfPendingCourse(int $courseId): void
    {
        $course = self::findById($courseId);
        if (!$course) return;

        // Get all admins
        $admins = Database::fetchAll("SELECT id FROM users WHERE role = 'admin'");
        
        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin['id'],
                'type' => 'course_pending_approval',
                'title' => 'New Course Pending Approval',
                'message' => "Course '{$course['title']}' by {$course['facilitator_first_name']} {$course['facilitator_last_name']} needs approval",
                'action_url' => '/admin/approvals/courses'
            ]);
        }
    }

}
