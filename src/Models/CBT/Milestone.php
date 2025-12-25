<?php

namespace Nebatech\Models\CBT;

use Nebatech\Core\Database;
use PDO;

/**
 * Milestone Model
 * Manages module competency checkpoints
 */
class Milestone
{
    /**
     * Create a new milestone
     */
    public static function create(array $data): int
    {
        $db = Database::connect();
        $stmt = $db->prepare("
            INSERT INTO milestones (
                module_id, title, description, milestone_type, requirements,
                competencies, instructions, rubric, max_points, passing_score,
                estimated_hours, is_required, status, order_index
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $data['module_id'],
            $data['title'],
            $data['description'],
            $data['milestone_type'] ?? 'practical_assessment',
            json_encode($data['requirements'] ?? []),
            json_encode($data['competencies'] ?? []),
            $data['instructions'],
            json_encode($data['rubric'] ?? []),
            $data['max_points'] ?? 100,
            $data['passing_score'] ?? 70,
            $data['estimated_hours'] ?? 2.0,
            $data['is_required'] ?? true,
            $data['status'] ?? 'published',
            $data['order_index'] ?? 1
        ]);
        return (int)$db->lastInsertId();
    }

    /**
     * Find milestone by ID
     */
    public static function findById(int $id): ?array
    {
        $db = Database::connect();
        $stmt = $db->prepare("SELECT * FROM milestones WHERE id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result) {
            $result['requirements'] = json_decode($result['requirements'], true) ?: [];
            $result['competencies'] = json_decode($result['competencies'], true) ?: [];
            $result['rubric'] = json_decode($result['rubric'], true) ?: [];
        }
        
        return $result ?: null;
    }

    /**
     * Get milestone by module ID
     */
    public static function getByModule(int $moduleId): ?array
    {
        $db = Database::connect();
        $stmt = $db->prepare("SELECT * FROM milestones WHERE module_id = ? AND status = 'published' LIMIT 1");
        $stmt->execute([$moduleId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result) {
            $result['requirements'] = json_decode($result['requirements'], true) ?: [];
            $result['competencies'] = json_decode($result['competencies'], true) ?: [];
            $result['rubric'] = json_decode($result['rubric'], true) ?: [];
        }
        
        return $result ?: null;
    }

    /**
     * Get all milestones for a course
     */
    public static function getByCourse(int $courseId): array
    {
        $db = Database::connect();
        $stmt = $db->prepare("
            SELECT mi.*, m.title as module_title, m.order_index as module_order
            FROM milestones mi
            JOIN modules m ON mi.module_id = m.id
            WHERE m.course_id = ? AND mi.status = 'published'
            ORDER BY m.order_index, mi.order_index
        ");
        $stmt->execute([$courseId]);
        $milestones = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($milestones as &$mi) {
            $mi['requirements'] = json_decode($mi['requirements'], true) ?: [];
            $mi['competencies'] = json_decode($mi['competencies'], true) ?: [];
            $mi['rubric'] = json_decode($mi['rubric'], true) ?: [];
        }
        
        return $milestones;
    }

    /**
     * Update milestone
     */
    public static function update(int $id, array $data): bool
    {
        $db = Database::connect();
        $fields = [];
        $values = [];
        
        foreach ($data as $key => $value) {
            if (in_array($key, ['requirements', 'competencies', 'rubric'])) {
                $value = json_encode($value);
            }
            $fields[] = "{$key} = ?";
            $values[] = $value;
        }
        
        $values[] = $id;
        $sql = "UPDATE milestones SET " . implode(', ', $fields) . " WHERE id = ?";
        $stmt = $db->prepare($sql);
        return $stmt->execute($values);
    }

    /**
     * Count milestones for a course
     */
    public static function countByCourse(int $courseId): int
    {
        $db = Database::connect();
        $stmt = $db->prepare("
            SELECT COUNT(*) FROM milestones mi
            JOIN modules m ON mi.module_id = m.id
            WHERE m.course_id = ? AND mi.status = 'published'
        ");
        $stmt->execute([$courseId]);
        return (int)$stmt->fetchColumn();
    }

    /**
     * Check if all prerequisites are met for a milestone
     */
    public static function checkPrerequisites(int $milestoneId, int $userId, int $enrollmentId): array
    {
        $milestone = self::findById($milestoneId);
        if (!$milestone) {
            return ['met' => false, 'reason' => 'Milestone not found'];
        }
        
        $requirements = $milestone['requirements'];
        $unmet = [];
        
        // Check lesson completion requirements
        if (!empty($requirements['lessons_completed'])) {
            $db = Database::connect();
            $stmt = $db->prepare("
                SELECT COUNT(*) FROM lesson_progress 
                WHERE enrollment_id = ? AND status = 'completed'
            ");
            $stmt->execute([$enrollmentId]);
            $completed = (int)$stmt->fetchColumn();
            
            if ($completed < $requirements['lessons_completed']) {
                $unmet[] = "Complete {$requirements['lessons_completed']} lessons (you have {$completed})";
            }
        }
        
        // Check quiz pass requirements
        if (!empty($requirements['quizzes_passed'])) {
            $passed = QuizAttempt::countPassedByEnrollment($enrollmentId);
            if ($passed < $requirements['quizzes_passed']) {
                $unmet[] = "Pass {$requirements['quizzes_passed']} quizzes (you have {$passed})";
            }
        }
        
        // Check practical completion requirements
        if (!empty($requirements['practicals_passed'])) {
            $passed = PracticalSubmission::countPassedByEnrollment($enrollmentId);
            if ($passed < $requirements['practicals_passed']) {
                $unmet[] = "Complete {$requirements['practicals_passed']} practicals (you have {$passed})";
            }
        }
        
        return [
            'met' => empty($unmet),
            'unmet_requirements' => $unmet
        ];
    }
}
