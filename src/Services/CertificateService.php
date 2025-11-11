<?php

namespace Nebatech\Services;

use Nebatech\Core\Database;

class CertificateService
{
    /**
     * Issue certificate for course completion
     */
    public function issueCertificate(int $userId, int $courseId): ?array
    {
        // Check if user has completed the course
        if (!$this->hasCompletedCourse($userId, $courseId)) {
            return null;
        }

        // Check if certificate already exists
        $existing = $this->findCertificate($userId, $courseId);
        if ($existing) {
            return $existing;
        }

        // Generate certificate number
        $certificateNumber = $this->generateCertificateNumber($userId, $courseId);
        
        // Generate UUID
        $uuid = $this->generateUuid();

        // Generate verification URL
        $verificationUrl = $this->generateVerificationUrl($uuid);

        $data = [
            'uuid' => $uuid,
            'user_id' => $userId,
            'course_id' => $courseId,
            'certificate_number' => $certificateNumber,
            'issued_at' => date('Y-m-d H:i:s'),
            'verified' => true,
            'verification_url' => $verificationUrl
        ];

        try {
            $certificateId = Database::insert('certificates', $data);
            
            if ($certificateId) {
                return $this->findById($certificateId);
            }

            return null;
        } catch (\Exception $e) {
            error_log("Certificate issuance failed: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Get user's certificates
     */
    public function getUserCertificates(int $userId): array
    {
        $sql = "SELECT c.*, 
                       co.title as course_title,
                       co.category,
                       co.level,
                       u.first_name,
                       u.last_name
                FROM certificates c
                INNER JOIN courses co ON c.course_id = co.id
                INNER JOIN users u ON c.user_id = u.id
                WHERE c.user_id = :user_id
                ORDER BY c.issued_at DESC";

        return Database::fetchAll($sql, ['user_id' => $userId]);
    }

    /**
     * Verify certificate by number or UUID
     */
    public function verifyCertificate(string $identifier): ?array
    {
        // Check if it's a UUID or certificate number
        $isUuid = strlen($identifier) === 36 && strpos($identifier, '-') !== false;

        if ($isUuid) {
            $sql = "SELECT c.*, 
                           u.first_name,
                           u.last_name,
                           u.email,
                           co.title as course_title,
                           co.category,
                           co.level,
                           co.duration_hours
                    FROM certificates c
                    INNER JOIN users u ON c.user_id = u.id
                    INNER JOIN courses co ON c.course_id = co.id
                    WHERE c.uuid = :identifier AND c.verified = 1
                    LIMIT 1";
        } else {
            $sql = "SELECT c.*, 
                           u.first_name,
                           u.last_name,
                           u.email,
                           co.title as course_title,
                           co.category,
                           co.level,
                           co.duration_hours
                    FROM certificates c
                    INNER JOIN users u ON c.user_id = u.id
                    INNER JOIN courses co ON c.course_id = co.id
                    WHERE c.certificate_number = :identifier AND c.verified = 1
                    LIMIT 1";
        }

        return Database::fetch($sql, ['identifier' => $identifier]);
    }

    /**
     * Find certificate by ID
     */
    public function findById(int $id): ?array
    {
        $sql = "SELECT c.*, 
                       u.first_name,
                       u.last_name,
                       co.title as course_title,
                       co.category,
                       co.level
                FROM certificates c
                INNER JOIN users u ON c.user_id = u.id
                INNER JOIN courses co ON c.course_id = co.id
                WHERE c.id = :id
                LIMIT 1";

        return Database::fetch($sql, ['id' => $id]);
    }

    /**
     * Find certificate for user and course
     */
    public function findCertificate(int $userId, int $courseId): ?array
    {
        $sql = "SELECT c.*, 
                       co.title as course_title
                FROM certificates c
                INNER JOIN courses co ON c.course_id = co.id
                WHERE c.user_id = :user_id AND c.course_id = :course_id
                LIMIT 1";

        return Database::fetch($sql, [
            'user_id' => $userId,
            'course_id' => $courseId
        ]);
    }

    /**
     * Check if user has completed course
     */
    private function hasCompletedCourse(int $userId, int $courseId): bool
    {
        $sql = "SELECT COUNT(*) as count 
                FROM enrollments 
                WHERE user_id = :user_id 
                AND course_id = :course_id 
                AND status = 'completed'
                AND progress >= 100";

        $result = Database::fetch($sql, [
            'user_id' => $userId,
            'course_id' => $courseId
        ]);

        return $result && $result['count'] > 0;
    }

    /**
     * Generate certificate number
     */
    private function generateCertificateNumber(int $userId, int $courseId): string
    {
        $year = date('Y');
        $month = date('m');
        
        // Format: NEBA-YYYY-MM-USERID-COURSEID-RANDOM
        $random = strtoupper(substr(md5(uniqid()), 0, 4));
        
        return sprintf(
            'NEBA-%s-%s-%04d-%04d-%s',
            $year,
            $month,
            $userId,
            $courseId,
            $random
        );
    }

    /**
     * Generate verification URL
     */
    private function generateVerificationUrl(string $uuid): string
    {
        $baseUrl = $_ENV['APP_URL'] ?? 'http://localhost';
        return $baseUrl . '/verify-certificate/' . $uuid;
    }

    /**
     * Generate UUID v4
     */
    private function generateUuid(): string
    {
        $data = random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
        
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    /**
     * Get certificate statistics
     */
    public function getStats(): array
    {
        $sql = "SELECT 
                    COUNT(*) as total_certificates,
                    COUNT(DISTINCT user_id) as unique_recipients,
                    COUNT(DISTINCT course_id) as courses_with_certificates
                FROM certificates";

        return Database::fetch($sql) ?? [
            'total_certificates' => 0,
            'unique_recipients' => 0,
            'courses_with_certificates' => 0
        ];
    }

    /**
     * Get recent certificates
     */
    public function getRecentCertificates(int $limit = 10): array
    {
        $sql = "SELECT c.*, 
                       u.first_name,
                       u.last_name,
                       co.title as course_title
                FROM certificates c
                INNER JOIN users u ON c.user_id = u.id
                INNER JOIN courses co ON c.course_id = co.id
                ORDER BY c.issued_at DESC
                LIMIT :limit";

        return Database::fetchAll($sql, ['limit' => $limit]);
    }

    /**
     * Revoke certificate (admin only)
     */
    public function revokeCertificate(int $certificateId): bool
    {
        $result = Database::update(
            'certificates',
            ['verified' => false],
            'id = :id',
            ['id' => $certificateId]
        );

        return $result > 0;
    }

    /**
     * Restore certificate (admin only)
     */
    public function restoreCertificate(int $certificateId): bool
    {
        $result = Database::update(
            'certificates',
            ['verified' => true],
            'id = :id',
            ['id' => $certificateId]
        );

        return $result > 0;
    }
}
