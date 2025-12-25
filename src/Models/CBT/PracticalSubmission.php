<?php

namespace Nebatech\Models\CBT;

use Nebatech\Core\Database;
use PDO;

/**
 * Practical Submission Model
 * Manages student submissions for practicals
 */
class PracticalSubmission
{
    /**
     * Create a new submission
     */
    public static function create(array $data): int
    {
        $db = Database::connect();
        $stmt = $db->prepare("
            INSERT INTO practical_submissions (
                practical_id, user_id, enrollment_id, submission_content, 
                submission_files, status, attempts
            ) VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $data['practical_id'],
            $data['user_id'],
            $data['enrollment_id'],
            $data['submission_content'],
            json_encode($data['submission_files'] ?? []),
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
            SELECT ps.*, p.title as practical_title, p.max_points, p.passing_score
            FROM practical_submissions ps
            JOIN practicals p ON ps.practical_id = p.id
            WHERE ps.id = ?
        ");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result) {
            $result['submission_files'] = json_decode($result['submission_files'], true) ?: [];
        }
        
        return $result ?: null;
    }

    /**
     * Get user's submission for a practical
     */
    public static function getByUserAndPractical(int $userId, int $practicalId): ?array
    {
        $db = Database::connect();
        $stmt = $db->prepare("
            SELECT * FROM practical_submissions 
            WHERE user_id = ? AND practical_id = ?
            ORDER BY submitted_at DESC LIMIT 1
        ");
        $stmt->execute([$userId, $practicalId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result) {
            $result['submission_files'] = json_decode($result['submission_files'], true) ?: [];
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
            SELECT ps.*, p.title as practical_title, p.lesson_id
            FROM practical_submissions ps
            JOIN practicals p ON ps.practical_id = p.id
            WHERE ps.enrollment_id = ?
            ORDER BY ps.submitted_at DESC
        ");
        $stmt->execute([$enrollmentId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Update submission (for grading)
     */
    public static function grade(int $id, array $data): bool
    {
        $db = Database::connect();
        $stmt = $db->prepare("
            UPDATE practical_submissions SET
                status = ?,
                score = ?,
                feedback = ?,
                ai_feedback = ?,
                reviewed_by = ?,
                reviewed_at = NOW()
            WHERE id = ?
        ");
        return $stmt->execute([
            $data['status'],
            $data['score'],
            $data['feedback'] ?? null,
            $data['ai_feedback'] ?? null,
            $data['reviewed_by'] ?? null,
            $id
        ]);
    }

    /**
     * Resubmit (increment attempts)
     */
    public static function resubmit(int $id, string $content, ?array $files = null): bool
    {
        $db = Database::connect();
        $stmt = $db->prepare("
            UPDATE practical_submissions SET
                submission_content = ?,
                submission_files = ?,
                status = 'submitted',
                attempts = attempts + 1,
                submitted_at = NOW()
            WHERE id = ?
        ");
        return $stmt->execute([
            $content,
            json_encode($files ?? []),
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
            SELECT ps.*, p.title as practical_title, u.name as student_name, c.title as course_title
            FROM practical_submissions ps
            JOIN practicals p ON ps.practical_id = p.id
            JOIN users u ON ps.user_id = u.id
            JOIN lessons l ON p.lesson_id = l.id
            JOIN modules m ON l.module_id = m.id
            JOIN courses c ON m.course_id = c.id
            WHERE ps.status = 'submitted'
            ORDER BY ps.submitted_at ASC
            LIMIT ?
        ");
        $stmt->execute([$limit]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Count passed practicals for enrollment
     */
    public static function countPassedByEnrollment(int $enrollmentId): int
    {
        $db = Database::connect();
        $stmt = $db->prepare("
            SELECT COUNT(DISTINCT practical_id) FROM practical_submissions 
            WHERE enrollment_id = ? AND status = 'passed'
        ");
        $stmt->execute([$enrollmentId]);
        return (int)$stmt->fetchColumn();
    }
}
