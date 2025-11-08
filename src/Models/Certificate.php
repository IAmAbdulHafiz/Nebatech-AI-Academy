<?php

namespace Nebatech\Models;

use Nebatech\Core\Database;
use PDO;

class Certificate
{
    private static ?Database $db = null;
    
    private static function getDb(): Database
    {
        if (self::$db === null) {
            self::$db = Database::getInstance();
        }
        return self::$db;
    }
    
    /**
     * Generate unique certificate number
     */
    private static function generateCertificateNumber(): string
    {
        $year = date('Y');
        $random = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 8));
        return "NEBATECH-{$year}-{$random}";
    }
    
    /**
     * Generate unique verification code
     */
    private static function generateVerificationCode(): string
    {
        return strtoupper(bin2hex(random_bytes(16)));
    }
    
    /**
     * Create certificate for user
     */
    public static function create(string $userId, string $courseId, ?array $metadata = null): ?string
    {
        // Check if certificate already exists
        $existing = self::getByCourseAndUser($courseId, $userId);
        if ($existing) {
            return $existing['id']; // Already has certificate
        }
        
        $db = self::getDb();
        $certificateId = self::generateUUID();
        $certificateNumber = self::generateCertificateNumber();
        $verificationCode = self::generateVerificationCode();
        $issueDate = date('Y-m-d');
        
        $stmt = $db->prepare("
            INSERT INTO certificates (id, user_id, course_id, certificate_number, issue_date, verification_code, metadata)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        
        $success = $stmt->execute([
            $certificateId,
            $userId,
            $courseId,
            $certificateNumber,
            $issueDate,
            $verificationCode,
            $metadata ? json_encode($metadata) : null
        ]);
        
        return $success ? $certificateId : null;
    }
    
    /**
     * Update PDF path for certificate
     */
    public static function updatePdfPath(string $certificateId, string $pdfPath): bool
    {
        $db = self::getDb();
        $stmt = $db->prepare("UPDATE certificates SET pdf_path = ? WHERE id = ?");
        return $stmt->execute([$pdfPath, $certificateId]);
    }
    
    /**
     * Get certificate by ID
     */
    public static function findById(string $id): ?array
    {
        $db = self::getDb();
        $stmt = $db->prepare("
            SELECT c.*, u.first_name, u.last_name, u.email,
                   co.title as course_title, co.description as course_description
            FROM certificates c
            JOIN users u ON c.user_id = u.id
            JOIN courses co ON c.course_id = co.id
            WHERE c.id = ?
        ");
        $stmt->execute([$id]);
        $cert = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($cert && isset($cert['metadata'])) {
            $cert['metadata'] = json_decode($cert['metadata'], true);
        }
        
        return $cert ?: null;
    }
    
    /**
     * Get certificate by verification code
     */
    public static function findByVerificationCode(string $code): ?array
    {
        $db = self::getDb();
        $stmt = $db->prepare("
            SELECT c.*, u.first_name, u.last_name, u.email,
                   co.title as course_title, co.description as course_description
            FROM certificates c
            JOIN users u ON c.user_id = u.id
            JOIN courses co ON c.course_id = co.id
            WHERE c.verification_code = ?
        ");
        $stmt->execute([$code]);
        $cert = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($cert && isset($cert['metadata'])) {
            $cert['metadata'] = json_decode($cert['metadata'], true);
        }
        
        return $cert ?: null;
    }
    
    /**
     * Get certificate by certificate number
     */
    public static function findByCertificateNumber(string $number): ?array
    {
        $db = self::getDb();
        $stmt = $db->prepare("
            SELECT c.*, u.first_name, u.last_name, u.email,
                   co.title as course_title, co.description as course_description
            FROM certificates c
            JOIN users u ON c.user_id = u.id
            JOIN courses co ON c.course_id = co.id
            WHERE c.certificate_number = ?
        ");
        $stmt->execute([$number]);
        $cert = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($cert && isset($cert['metadata'])) {
            $cert['metadata'] = json_decode($cert['metadata'], true);
        }
        
        return $cert ?: null;
    }
    
    /**
     * Get all certificates for a user
     */
    public static function getUserCertificates(string $userId): array
    {
        $db = self::getDb();
        $stmt = $db->prepare("
            SELECT c.*, co.title as course_title, co.slug as course_slug
            FROM certificates c
            JOIN courses co ON c.course_id = co.id
            WHERE c.user_id = ?
            ORDER BY c.issue_date DESC
        ");
        $stmt->execute([$userId]);
        $certs = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($certs as &$cert) {
            if (isset($cert['metadata'])) {
                $cert['metadata'] = json_decode($cert['metadata'], true);
            }
        }
        
        return $certs;
    }
    
    /**
     * Get certificate by course and user
     */
    public static function getByCourseAndUser(string $courseId, string $userId): ?array
    {
        $db = self::getDb();
        $stmt = $db->prepare("
            SELECT c.*, co.title as course_title
            FROM certificates c
            JOIN courses co ON c.course_id = co.id
            WHERE c.course_id = ? AND c.user_id = ?
        ");
        $stmt->execute([$courseId, $userId]);
        $cert = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($cert && isset($cert['metadata'])) {
            $cert['metadata'] = json_decode($cert['metadata'], true);
        }
        
        return $cert ?: null;
    }
    
    /**
     * Check if user has certificate for course
     */
    public static function userHasCertificate(string $userId, string $courseId): bool
    {
        $db = self::getDb();
        $stmt = $db->prepare("
            SELECT COUNT(*) FROM certificates 
            WHERE user_id = ? AND course_id = ?
        ");
        $stmt->execute([$userId, $courseId]);
        return $stmt->fetchColumn() > 0;
    }
    
    /**
     * Get all certificates (admin)
     */
    public static function getAll(int $limit = 50, int $offset = 0): array
    {
        $db = self::getDb();
        $stmt = $db->prepare("
            SELECT c.*, 
                   u.first_name, u.last_name, u.email,
                   co.title as course_title
            FROM certificates c
            JOIN users u ON c.user_id = u.id
            JOIN courses co ON c.course_id = co.id
            ORDER BY c.created_at DESC
            LIMIT ? OFFSET ?
        ");
        $stmt->execute([$limit, $offset]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Get total certificate count
     */
    public static function getTotalCount(): int
    {
        $db = self::getDb();
        $stmt = $db->query("SELECT COUNT(*) FROM certificates");
        return (int)$stmt->fetchColumn();
    }
    
    /**
     * Generate UUID v4
     */
    private static function generateUUID(): string
    {
        $data = random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
    
    /**
     * Verify certificate authenticity
     */
    public static function verify(string $verificationCode): ?array
    {
        return self::findByVerificationCode($verificationCode);
    }
    
    /**
     * Get certificates issued in date range
     */
    public static function getByDateRange(string $startDate, string $endDate): array
    {
        $db = self::getDb();
        $stmt = $db->prepare("
            SELECT c.*, 
                   u.first_name, u.last_name,
                   co.title as course_title
            FROM certificates c
            JOIN users u ON c.user_id = u.id
            JOIN courses co ON c.course_id = co.id
            WHERE c.issue_date BETWEEN ? AND ?
            ORDER BY c.issue_date DESC
        ");
        $stmt->execute([$startDate, $endDate]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
