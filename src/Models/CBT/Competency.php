<?php

namespace Nebatech\Models\CBT;

use Nebatech\Core\Database;
use PDO;

/**
 * Competency Model
 * Manages course competencies
 */
class Competency
{
    /**
     * Create a new competency
     */
    public static function create(array $data): int
    {
        $db = Database::connect();
        $stmt = $db->prepare("
            INSERT INTO competencies (
                course_id, competency_code, title, description, category, level, is_core
            ) VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $data['course_id'],
            $data['competency_code'],
            $data['title'],
            $data['description'],
            $data['category'] ?? null,
            $data['level'] ?? 'foundational',
            $data['is_core'] ?? true
        ]);
        return (int)$db->lastInsertId();
    }

    /**
     * Bulk create competencies for a course
     */
    public static function bulkCreate(int $courseId, array $competencies): int
    {
        $db = Database::connect();
        $count = 0;
        
        foreach ($competencies as $comp) {
            $stmt = $db->prepare("
                INSERT INTO competencies (course_id, competency_code, title, description, category, level, is_core)
                VALUES (?, ?, ?, ?, ?, ?, ?)
                ON DUPLICATE KEY UPDATE title = VALUES(title), description = VALUES(description)
            ");
            $stmt->execute([
                $courseId,
                $comp['code'],
                $comp['title'],
                $comp['description'],
                $comp['category'] ?? null,
                $comp['level'] ?? 'foundational',
                $comp['is_core'] ?? true
            ]);
            $count++;
        }
        
        return $count;
    }

    /**
     * Find competency by ID
     */
    public static function findById(int $id): ?array
    {
        $db = Database::connect();
        $stmt = $db->prepare("SELECT * FROM competencies WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    /**
     * Get all competencies for a course
     */
    public static function getByCourse(int $courseId): array
    {
        $db = Database::connect();
        $stmt = $db->prepare("
            SELECT * FROM competencies 
            WHERE course_id = ? 
            ORDER BY level, category, competency_code
        ");
        $stmt->execute([$courseId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get competencies by category
     */
    public static function getByCategory(int $courseId, string $category): array
    {
        $db = Database::connect();
        $stmt = $db->prepare("
            SELECT * FROM competencies 
            WHERE course_id = ? AND category = ?
            ORDER BY competency_code
        ");
        $stmt->execute([$courseId, $category]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get core competencies only
     */
    public static function getCoreCompetencies(int $courseId): array
    {
        $db = Database::connect();
        $stmt = $db->prepare("
            SELECT * FROM competencies 
            WHERE course_id = ? AND is_core = 1
            ORDER BY level, competency_code
        ");
        $stmt->execute([$courseId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Count competencies for a course
     */
    public static function countByCourse(int $courseId): int
    {
        $db = Database::connect();
        $stmt = $db->prepare("SELECT COUNT(*) FROM competencies WHERE course_id = ?");
        $stmt->execute([$courseId]);
        return (int)$stmt->fetchColumn();
    }

    /**
     * Link competency to lesson
     */
    public static function linkToLesson(int $competencyId, int $lessonId, string $coverageLevel = 'introduces'): bool
    {
        $db = Database::connect();
        $stmt = $db->prepare("
            INSERT INTO lesson_competencies (lesson_id, competency_id, coverage_level)
            VALUES (?, ?, ?)
            ON DUPLICATE KEY UPDATE coverage_level = VALUES(coverage_level)
        ");
        return $stmt->execute([$lessonId, $competencyId, $coverageLevel]);
    }

    /**
     * Get lessons that cover a competency
     */
    public static function getLessons(int $competencyId): array
    {
        $db = Database::connect();
        $stmt = $db->prepare("
            SELECT l.*, lc.coverage_level, m.title as module_title
            FROM lesson_competencies lc
            JOIN lessons l ON lc.lesson_id = l.id
            JOIN modules m ON l.module_id = m.id
            WHERE lc.competency_id = ?
            ORDER BY m.order_index, l.order_index
        ");
        $stmt->execute([$competencyId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
