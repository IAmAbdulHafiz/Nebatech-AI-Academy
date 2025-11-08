<?php

namespace Nebatech\Models;

use Nebatech\Core\Model;
use Nebatech\Core\Database;

class Submission extends Model
{
    protected string $table = 'submissions';
    protected string $primaryKey = 'id';

    /**
     * Create a new submission
     */
    public static function createSubmission(array $data): ?int
    {
        // Generate UUID if not provided
        if (!isset($data['uuid'])) {
            $data['uuid'] = self::generateSubmissionUuid();
        }

        // Set default status if not provided
        if (!isset($data['status'])) {
            $data['status'] = 'pending';
        }

        // Encode AI feedback as JSON if it's an array
        if (isset($data['ai_feedback']) && is_array($data['ai_feedback'])) {
            $data['ai_feedback'] = json_encode($data['ai_feedback']);
        }

        try {
            return Database::insert('submissions', $data);
        } catch (\Exception $e) {
            error_log("Submission creation failed: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Get submissions by assignment
     */
    public static function getByAssignment(int $assignmentId, ?string $status = null): array
    {
        $sql = "SELECT s.*, 
                       u.first_name,
                       u.last_name,
                       u.email,
                       u.avatar
                FROM " . 'submissions' . " s
                INNER JOIN users u ON s.user_id = u.id
                WHERE s.assignment_id = :assignment_id";
        
        $params = ['assignment_id' => $assignmentId];

        if ($status) {
            $sql .= " AND s.status = :status";
            $params['status'] = $status;
        }

        $sql .= " ORDER BY s.submitted_at DESC";

        $submissions = Database::fetchAll($sql, $params);

        // Decode JSON feedback
        foreach ($submissions as &$submission) {
            if ($submission['ai_feedback']) {
                $submission['ai_feedback'] = json_decode($submission['ai_feedback'], true);
            }
        }

        return $submissions;
    }

    /**
     * Get submissions by user
     */
    public static function getByUser(int $userId, ?string $status = null): array
    {
        $sql = "SELECT s.*, 
                       a.title as assignment_title,
                       a.max_score,
                       l.title as lesson_title,
                       m.title as module_title,
                       c.title as course_title
                FROM " . 'submissions' . " s
                INNER JOIN assignments a ON s.assignment_id = a.id
                INNER JOIN lessons l ON a.lesson_id = l.id
                INNER JOIN modules m ON l.module_id = m.id
                INNER JOIN courses c ON m.course_id = c.id
                WHERE s.user_id = :user_id";
        
        $params = ['user_id' => $userId];

        if ($status) {
            $sql .= " AND s.status = :status";
            $params['status'] = $status;
        }

        $sql .= " ORDER BY s.submitted_at DESC";

        return Database::fetchAll($sql, $params);
    }

    /**
     * Get submission by ID
     */
    public static function findById(int $id): ?array
    {
        $sql = "SELECT s.*, 
                       u.first_name,
                       u.last_name,
                       u.email,
                       a.title as assignment_title,
                       a.max_score,
                       a.rubric,
                       l.title as lesson_title,
                       m.title as module_title,
                       c.title as course_title
                FROM " . 'submissions' . " s
                INNER JOIN users u ON s.user_id = u.id
                INNER JOIN assignments a ON s.assignment_id = a.id
                INNER JOIN lessons l ON a.lesson_id = l.id
                INNER JOIN modules m ON l.module_id = m.id
                INNER JOIN courses c ON m.course_id = c.id
                WHERE s.id = :id
                LIMIT 1";
        
        $submission = Database::fetch($sql, ['id' => $id]);

        if ($submission) {
            if ($submission['ai_feedback']) {
                $submission['ai_feedback'] = json_decode($submission['ai_feedback'], true);
            }
            if ($submission['rubric']) {
                $submission['rubric'] = json_decode($submission['rubric'], true);
            }
        }

        return $submission;
    }

    /**
     * Get submission by user and assignment
     */
    public static function getByUserAndAssignment(int $userId, int $assignmentId): ?array
    {
        $sql = "SELECT * FROM " . 'submissions' . " 
                WHERE user_id = :user_id AND assignment_id = :assignment_id
                ORDER BY submitted_at DESC
                LIMIT 1";
        
        $submission = Database::fetch($sql, [
            'user_id' => $userId,
            'assignment_id' => $assignmentId
        ]);
        
        if ($submission && $submission['ai_feedback']) {
            $submission['ai_feedback'] = json_decode($submission['ai_feedback'], true);
        }
        
        return $submission;
    }

    /**
     * Check if user has submitted assignment
     */
    public static function hasSubmitted(int $userId, int $assignmentId): bool
    {
        $sql = "SELECT COUNT(*) as count FROM " . 'submissions' . " 
                WHERE user_id = :user_id AND assignment_id = :assignment_id";
        
        $result = Database::fetch($sql, [
            'user_id' => $userId,
            'assignment_id' => $assignmentId
        ]);

        return $result && $result['count'] > 0;
    }

    /**
     * Get submissions for facilitator review
     */
    public static function getForFacilitator(
        array $courseIds, 
        ?string $status = 'all', 
        ?int $courseId = null
    ): array {
        if (empty($courseIds)) {
            return [];
        }

        $placeholders = implode(',', array_fill(0, count($courseIds), '?'));
        
        $sql = "SELECT s.*, 
                       u.first_name,
                       u.last_name,
                       u.email,
                       u.avatar,
                       a.title as assignment_title,
                       a.max_score,
                       l.title as lesson_title,
                       m.title as module_title,
                       c.id as course_id,
                       c.title as course_title
                FROM " . 'submissions' . " s
                INNER JOIN users u ON s.user_id = u.id
                INNER JOIN assignments a ON s.assignment_id = a.id
                INNER JOIN lessons l ON a.lesson_id = l.id
                INNER JOIN modules m ON l.module_id = m.id
                INNER JOIN courses c ON m.course_id = c.id
                WHERE c.id IN ($placeholders)";
        
        $params = $courseIds;

        if ($status && $status !== 'all') {
            $sql .= " AND s.status = ?";
            $params[] = $status;
        }
        
        if ($courseId) {
            $sql .= " AND c.id = ?";
            $params[] = $courseId;
        }

        $sql .= " ORDER BY s.submitted_at DESC";

        $submissions = Database::fetchAll($sql, $params);

        // Decode JSON feedback
        foreach ($submissions as &$submission) {
            if ($submission['ai_feedback']) {
                $submission['ai_feedback'] = json_decode($submission['ai_feedback'], true);
            }
        }

        return $submissions;
    }

    /**
     * Get user submission for assignment
     */
    public static function getUserSubmission(int $userId, int $assignmentId): ?array
    {
        $sql = "SELECT * FROM " . 'submissions' . " 
                WHERE user_id = :user_id AND assignment_id = :assignment_id
                ORDER BY submitted_at DESC
                LIMIT 1";
        
        $submission = Database::fetch($sql, [
            'user_id' => $userId,
            'assignment_id' => $assignmentId
        ]);

        if ($submission && $submission['ai_feedback']) {
            $submission['ai_feedback'] = json_decode($submission['ai_feedback'], true);
        }

        return $submission;
    }

    /**
     * Update submission with AI feedback
     */
    public static function updateAIFeedback(int $submissionId, float $score, array $feedback): bool
    {
        $data = [
            'ai_score' => $score,
            'ai_feedback' => json_encode($feedback)
        ];

        $result = Database::update(
            'submissions',
            $data,
            'id = :id',
            ['id' => $submissionId]
        );

        return $result > 0;
    }

    /**
     * Update submission with facilitator feedback
     */
    public static function updateFacilitatorFeedback(int $submissionId, float $score, string $feedback, string $status = 'graded'): bool
    {
        $data = [
            'facilitator_score' => $score,
            'facilitator_feedback' => $feedback,
            'status' => $status,
            'graded_at' => date('Y-m-d H:i:s')
        ];

        $result = Database::update(
            'submissions',
            $data,
            'id = :id',
            ['id' => $submissionId]
        );

        return $result > 0;
    }

    /**
     * Verify submission (final approval)
     */
    public static function verify(int $submissionId): bool
    {
        $data = [
            'status' => 'verified',
            'graded_at' => date('Y-m-d H:i:s')
        ];

        $result = Database::update(
            'submissions',
            $data,
            'id = :id',
            ['id' => $submissionId]
        );

        return $result > 0;
    }

    /**
     * Request revision
     */
    public static function requestRevision(int $submissionId, string $feedback): bool
    {
        $data = [
            'status' => 'revision_needed',
            'facilitator_feedback' => $feedback
        ];

        $result = Database::update(
            'submissions',
            $data,
            'id = :id',
            ['id' => $submissionId]
        );

        return $result > 0;
    }

    /**
     * Get submission statistics
     */
    public static function getStats(): array
    {
        $sql = "SELECT 
                    COUNT(*) as total,
                    SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
                    SUM(CASE WHEN status = 'graded' THEN 1 ELSE 0 END) as graded,
                    SUM(CASE WHEN status = 'verified' THEN 1 ELSE 0 END) as verified,
                    SUM(CASE WHEN status = 'revision_needed' THEN 1 ELSE 0 END) as revision_needed,
                    AVG(facilitator_score) as average_score
                FROM " . 'submissions';
        
        return Database::fetch($sql) ?? [
            'total' => 0,
            'pending' => 0,
            'graded' => 0,
            'verified' => 0,
            'revision_needed' => 0,
            'average_score' => 0
        ];
    }

    /**
     * Get pending submissions (for facilitator review)
     */
    public static function getPendingSubmissions(int $limit = 10): array
    {
        $sql = "SELECT s.*, 
                       u.first_name,
                       u.last_name,
                       a.title as assignment_title,
                       c.title as course_title
                FROM " . 'submissions' . " s
                INNER JOIN users u ON s.user_id = u.id
                INNER JOIN assignments a ON s.assignment_id = a.id
                INNER JOIN lessons l ON a.lesson_id = l.id
                INNER JOIN modules m ON l.module_id = m.id
                INNER JOIN courses c ON m.course_id = c.id
                WHERE s.status = 'pending'
                ORDER BY s.submitted_at ASC
                LIMIT :limit";
        
        return Database::fetchAll($sql, ['limit' => $limit]);
    }

    /**
     * Delete submission
     */
    public static function deleteSubmission(int $submissionId): bool
    {
        $result = Database::delete('submissions', 'id = :id', ['id' => $submissionId]);
        return $result > 0;
    }

    /**
     * Generate UUID v4
     */
    protected static function generateSubmissionUuid(): string
    {
        $data = random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
        
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
}
