<?php

namespace Nebatech\Models\Academic;

use Nebatech\Core\Model;
use Nebatech\Core\Database;

class Certificate extends Model
{
    protected string $table = 'certificates';
    protected string $primaryKey = 'id';

    /**
     * Create certificate
     */
    public static function create(array $data): ?int
    {
        // Generate UUID if not provided
        if (!isset($data['uuid'])) {
            $data['uuid'] = self::generateUuid();
        }

        try {
            return Database::insert('certificates', $data);
        } catch (\Exception $e) {
            error_log("Certificate creation failed: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Get user's certificates
     */
    public static function getUserCertificates(int $userId): array
    {
        $sql = "SELECT c.*, 
                       co.title as course_title,
                       cc.name as category_name,
                       cc.slug as category_slug,
                       co.level,
                       u.first_name,
                       u.last_name
                FROM " . 'certificates' . " c
                INNER JOIN courses co ON c.course_id = co.id
                LEFT JOIN course_categories cc ON co.category_id = cc.id
                INNER JOIN users u ON c.user_id = u.id
                WHERE c.user_id = :user_id
                ORDER BY c.issued_at DESC";

        return Database::fetchAll($sql, ['user_id' => $userId]);
    }

    /**
     * Get count of user's certificates
     */
    public static function getUserCertificatesCount(int $userId): int
    {
        $sql = "SELECT COUNT(*) as count FROM " . 'certificates' . " 
                WHERE user_id = :user_id";
        
        $result = Database::fetch($sql, ['user_id' => $userId]);
        return $result ? (int)$result['count'] : 0;
    }

    /**
     * Find by UUID
     */
    public static function findByUuid(string $uuid): ?array
    {
        $sql = "SELECT c.*, 
                       u.first_name,
                       u.last_name,
                       u.email,
                       co.title as course_title,
                       cc.name as category_name,
                       cc.slug as category_slug,
                       co.level,
                       co.duration_hours
                FROM " . 'certificates' . " c
                INNER JOIN users u ON c.user_id = u.id
                INNER JOIN courses co ON c.course_id = co.id
                LEFT JOIN course_categories cc ON co.category_id = cc.id
                WHERE c.uuid = :uuid
                LIMIT 1";

        return Database::fetch($sql, ['uuid' => $uuid]);
    }

    /**
     * Find by certificate number
     */
    public static function findByCertificateNumber(string $certificateNumber): ?array
    {
        $sql = "SELECT c.*, 
                       u.first_name,
                       u.last_name,
                       u.email,
                       co.title as course_title,
                       cc.name as category_name,
                       cc.slug as category_slug,
                       co.level,
                       co.duration_hours
                FROM " . 'certificates' . " c
                INNER JOIN users u ON c.user_id = u.id
                INNER JOIN courses co ON c.course_id = co.id
                LEFT JOIN course_categories cc ON co.category_id = cc.id
                WHERE c.certificate_number = :certificate_number
                LIMIT 1";

        return Database::fetch($sql, ['certificate_number' => $certificateNumber]);
    }

    /**
     * Find certificate for user and course
     */
    public static function findForUserAndCourse(int $userId, int $courseId): ?array
    {
        $sql = "SELECT c.*, 
                       co.title as course_title
                FROM " . 'certificates' . " c
                INNER JOIN courses co ON c.course_id = co.id
                WHERE c.user_id = :user_id AND c.course_id = :course_id
                LIMIT 1";

        return Database::fetch($sql, [
            'user_id' => $userId,
            'course_id' => $courseId
        ]);
    }

    /**
     * Verify certificate
     */
    public static function verify(string $identifier): ?array
    {
        // Check if it's a UUID or certificate number
        $isUuid = strlen($identifier) === 36 && strpos($identifier, '-') !== false;

        if ($isUuid) {
            $certificate = self::findByUuid($identifier);
        } else {
            $certificate = self::findByCertificateNumber($identifier);
        }

        // Only return if verified
        if ($certificate && $certificate['verified']) {
            return $certificate;
        }

        return null;
    }

    /**
     * Revoke certificate
     */
    public static function revoke(int $id): bool
    {
        $result = Database::update(
            'certificates',
            ['verified' => false],
            'id = :id',
            ['id' => $id]
        );

        return $result > 0;
    }

    /**
     * Restore certificate
     */
    public static function restore(int $id): bool
    {
        $result = Database::update(
            'certificates',
            ['verified' => true],
            'id = :id',
            ['id' => $id]
        );

        return $result > 0;
    }

    /**
     * Get statistics
     */
    public static function getStats(): array
    {
        $sql = "SELECT 
                    COUNT(*) as total_certificates,
                    COUNT(DISTINCT user_id) as unique_recipients,
                    COUNT(DISTINCT course_id) as courses_with_certificates
                FROM " . 'certificates';

        return Database::fetch($sql) ?? [
            'total_certificates' => 0,
            'unique_recipients' => 0,
            'courses_with_certificates' => 0
        ];
    }

    /**
     * Get recent certificates
     */
    public static function getRecentCertificates(int $limit = 10): array
    {
        $sql = "SELECT c.*, 
                       u.first_name,
                       u.last_name,
                       co.title as course_title
                FROM " . 'certificates' . " c
                INNER JOIN users u ON c.user_id = u.id
                INNER JOIN courses co ON c.course_id = co.id
                ORDER BY c.issued_at DESC
                LIMIT :limit";

        return Database::fetchAll($sql, ['limit' => $limit]);
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
}
