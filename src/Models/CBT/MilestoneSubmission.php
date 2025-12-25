<?php

namespace Nebatech\Models\CBT;

use Nebatech\Core\Database;
use PDO;

/**
 * Milestone Submission Model
 * Manages student milestone submissions
 */
class MilestoneSubmission
{
    /**
     * Create a new submission
     */
    public static function create(array $data): int
    {
        $db = Database::connect();
        $stmt = $db->prepare("
            INSERT INTO milestone_submissions (
                milestone_id, user_id, enrollment_id, submission_content,
                submission_files, submission_url, status, attempts
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $data['milestone_id'],
            $data['user_id'],
            $data['enrollment_id'],
            $data['submission_content'],
            json_encode($data['submission_files'] ?? []),
            $data['submission_url'] ?? null,
            $data['status'] ?? 'submitted',
            $data['attempts'] ?? 1
        ]);
        return (int)$db->lastInsertId();
    }

    /**
     * Find submission by ID
     */
    public static function findById(int $id): ?array
    {
        $db = Database::connect();
        $stmt = $db->prepare("
            SELECT ms.*, mi.title as milestone_title, mi.max_points, mi.passing_score
            FROM milestone_submissions ms
            JOIN milestones mi ON ms.milestone_id = mi.id
            WHERE ms.id = ?
        ");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result) {
            $result['submission_files'] = json_decode($result['submission_files'], true) ?: [];
            $result['competency_scores'] = json_decode($result['competency_scores'], true) ?: [];
        }
        
        return $result ?: null;
    }

    /**
     * Get user's submission for a milestone
     */
    public static function getByUserAndMilestone(int $userId, int $milestoneId): ?array
    {
        $db = Database::connect();
        $stmt = $db->prepare("
            SELECT * FROM milestone_submissions 
            WHERE user_id = ? AND milestone_id = ?
            ORDER BY submitted_at DESC LIMIT 1
        ");
        $stmt->execute([$userId, $milestoneId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result) {
            $result['submission_files'] = json_decode($result['submission_files'], true) ?: [];
            $result['competency_scores'] = json_decode($result['competency_scores'], true) ?: [];
        }
        
        return $result ?: null;
    }

    /**
     * Get all submissions for an enrollment
     */
    public static function getByEnrollment(int $enrollmentId): array
    {
        $db = Database::connect();
        $stmt = $db->prepare("
            SELECT ms.*, mi.title as milestone_title, m.title as module_title
            FROM milestone_submissions ms
            JOIN milestones mi ON ms.milestone_id = mi.id
            JOIN modules m ON mi.module_id = m.id
            WHERE ms.enrollment_id = ?
            ORDER BY ms.submitted_at DESC
        ");
        $stmt->execute([$enrollmentId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Grade a milestone submission
     */
    public static function grade(int $id, array $data): bool
    {
        $db = Database::connect();
        $stmt = $db->prepare("
            UPDATE milestone_submissions SET
                status = ?,
                score = ?,
                competency_scores = ?,
                feedback = ?,
                ai_feedback = ?,
                reviewed_by = ?,
                reviewed_at = NOW()
            WHERE id = ?
        ");
        return $stmt->execute([
            $data['status'],
            $data['score'],
            json_encode($data['competency_scores'] ?? []),
            $data['feedback'] ?? null,
            $data['ai_feedback'] ?? null,
            $data['reviewed_by'] ?? null,
            $id
        ]);
    }

    /**
     * Get pending submissions for review
     */
    public static function getPendingReviews(int $limit = 50): array
    {
        $db = Database::connect();
        $stmt = $db->prepare("
            SELECT ms.*, mi.title as milestone_title, u.name as student_name, 
                   c.title as course_title, m.title as module_title
            FROM milestone_submissions ms
            JOIN milestones mi ON ms.milestone_id = mi.id
            JOIN modules m ON mi.module_id = m.id
            JOIN courses c ON m.course_id = c.id
            JOIN users u ON ms.user_id = u.id
            WHERE ms.status = 'submitted'
            ORDER BY ms.submitted_at ASC
            LIMIT ?
        ");
        $stmt->execute([$limit]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Count passed milestones for enrollment
     */
    public static function countPassedByEnrollment(int $enrollmentId): int
    {
        $db = Database::connect();
        $stmt = $db->prepare("
            SELECT COUNT(DISTINCT milestone_id) FROM milestone_submissions 
            WHERE enrollment_id = ? AND status = 'passed'
        ");
        $stmt->execute([$enrollmentId]);
        return (int)$stmt->fetchColumn();
    }
}
