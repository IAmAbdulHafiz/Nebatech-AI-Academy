<?php

namespace Nebatech\Models\CBT;

use Nebatech\Core\Database;
use PDO;

/**
 * Student Competency Model
 * Tracks student competency achievements
 */
class StudentCompetency
{
    /**
     * Update or create student competency record
     */
    public static function updateProficiency(array $data): bool
    {
        $db = Database::connect();
        $stmt = $db->prepare("
            INSERT INTO student_competencies (
                user_id, competency_id, enrollment_id, proficiency_level, 
                evidence, assessed_at, assessed_by, notes
            ) VALUES (?, ?, ?, ?, ?, NOW(), ?, ?)
            ON DUPLICATE KEY UPDATE 
                proficiency_level = VALUES(proficiency_level),
                evidence = VALUES(evidence),
                assessed_at = NOW(),
                assessed_by = VALUES(assessed_by),
                notes = VALUES(notes)
        ");
        return $stmt->execute([
            $data['user_id'],
            $data['competency_id'],
            $data['enrollment_id'],
            $data['proficiency_level'] ?? 'developing',
            json_encode($data['evidence'] ?? []),
            $data['assessed_by'] ?? null,
            $data['notes'] ?? null
        ]);
    }

    /**
     * Get student's competency for a specific competency
     */
    public static function get(int $userId, int $competencyId, int $enrollmentId): ?array
    {
        $db = Database::connect();
        $stmt = $db->prepare("
            SELECT sc.*, c.title as competency_title, c.competency_code
            FROM student_competencies sc
            JOIN competencies c ON sc.competency_id = c.id
            WHERE sc.user_id = ? AND sc.competency_id = ? AND sc.enrollment_id = ?
        ");
        $stmt->execute([$userId, $competencyId, $enrollmentId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result) {
            $result['evidence'] = json_decode($result['evidence'], true) ?: [];
        }
        
        return $result ?: null;
    }

    /**
     * Get all competencies for a student in a course
     */
    public static function getByEnrollment(int $enrollmentId): array
    {
        $db = Database::connect();
        $stmt = $db->prepare("
            SELECT sc.*, c.title as competency_title, c.competency_code, 
                   c.category, c.level as competency_level
            FROM student_competencies sc
            JOIN competencies c ON sc.competency_id = c.id
            WHERE sc.enrollment_id = ?
            ORDER BY c.category, c.competency_code
        ");
        $stmt->execute([$enrollmentId]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($results as &$r) {
            $r['evidence'] = json_decode($r['evidence'], true) ?: [];
        }
        
        return $results;
    }

    /**
     * Get competency summary for a student in a course
     */
    public static function getSummary(int $userId, int $courseId, int $enrollmentId): array
    {
        $db = Database::connect();
        
        // Get all competencies for course
        $allCompetencies = Competency::getByCourse($courseId);
        
        // Get student's achievements
        $stmt = $db->prepare("
            SELECT sc.competency_id, sc.proficiency_level
            FROM student_competencies sc
            JOIN competencies c ON sc.competency_id = c.id
            WHERE sc.user_id = ? AND sc.enrollment_id = ? AND c.course_id = ?
        ");
        $stmt->execute([$userId, $enrollmentId, $courseId]);
        $achievements = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $achievements[$row['competency_id']] = $row['proficiency_level'];
        }
        
        $summary = [
            'total' => count($allCompetencies),
            'not_started' => 0,
            'developing' => 0,
            'competent' => 0,
            'proficient' => 0,
            'expert' => 0,
            'competencies' => []
        ];
        
        foreach ($allCompetencies as $comp) {
            $level = $achievements[$comp['id']] ?? 'not_started';
            $summary[$level]++;
            $summary['competencies'][] = [
                'id' => $comp['id'],
                'code' => $comp['competency_code'],
                'title' => $comp['title'],
                'category' => $comp['category'],
                'level' => $comp['level'],
                'proficiency' => $level
            ];
        }
        
        // Calculate percentage
        $achieved = $summary['competent'] + $summary['proficient'] + $summary['expert'];
        $summary['achievement_percentage'] = $summary['total'] > 0 
            ? round(($achieved / $summary['total']) * 100, 1) 
            : 0;
        
        return $summary;
    }

    /**
     * Add evidence to a competency
     */
    public static function addEvidence(int $userId, int $competencyId, int $enrollmentId, array $evidence): bool
    {
        $existing = self::get($userId, $competencyId, $enrollmentId);
        $existingEvidence = $existing ? $existing['evidence'] : [];
        
        $existingEvidence[] = array_merge($evidence, [
            'added_at' => date('Y-m-d H:i:s')
        ]);
        
        $db = Database::connect();
        $stmt = $db->prepare("
            UPDATE student_competencies 
            SET evidence = ?
            WHERE user_id = ? AND competency_id = ? AND enrollment_id = ?
        ");
        return $stmt->execute([
            json_encode($existingEvidence),
            $userId,
            $competencyId,
            $enrollmentId
        ]);
    }

    /**
     * Calculate proficiency level based on evidence
     */
    public static function calculateProficiency(int $userId, int $competencyId, int $enrollmentId): string
    {
        $existing = self::get($userId, $competencyId, $enrollmentId);
        if (!$existing) return 'not_started';
        
        $evidence = $existing['evidence'];
        $passedAssessments = 0;
        $totalScore = 0;
        $count = 0;
        
        foreach ($evidence as $e) {
            if (!empty($e['passed'])) {
                $passedAssessments++;
            }
            if (isset($e['score'])) {
                $totalScore += $e['score'];
                $count++;
            }
        }
        
        $avgScore = $count > 0 ? $totalScore / $count : 0;
        
        // Determine proficiency level
        if ($passedAssessments >= 5 && $avgScore >= 95) return 'expert';
        if ($passedAssessments >= 3 && $avgScore >= 85) return 'proficient';
        if ($passedAssessments >= 2 && $avgScore >= 70) return 'competent';
        if ($passedAssessments >= 1) return 'developing';
        
        return 'not_started';
    }
}
