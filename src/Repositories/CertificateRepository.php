<?php

namespace Nebatech\Repositories;

use Nebatech\Core\Database;

class CertificateRepository
{
    /**
     * Find certificate by ID
     */
    public function find(int $id): ?array
    {
        return Database::fetch(
            'SELECT c.*, u.first_name, u.last_name, u.email,
                    co.title as course_title, co.slug as course_slug
             FROM certificates c
             JOIN users u ON c.user_id = u.id
             JOIN courses co ON c.course_id = co.id
             WHERE c.id = :id',
            ['id' => $id]
        );
    }

    /**
     * Find certificate by UUID
     */
    public function findByUuid(string $uuid): ?array
    {
        return Database::fetch(
            'SELECT c.*, u.first_name, u.last_name, u.email,
                    co.title as course_title, co.slug as course_slug, 
                    cc.name as category_name, cc.slug as category_slug
             FROM certificates c
             JOIN users u ON c.user_id = u.id
             JOIN courses co ON c.course_id = co.id
             LEFT JOIN course_categories cc ON co.category_id = cc.id
             WHERE c.uuid = :uuid',
            ['uuid' => $uuid]
        );
    }

    /**
     * Find certificate by certificate number
     */
    public function findByCertificateNumber(string $certificateNumber): ?array
    {
        return Database::fetch(
            'SELECT c.*, u.first_name, u.last_name, u.email,
                    co.title as course_title
             FROM certificates c
             JOIN users u ON c.user_id = u.id
             JOIN courses co ON c.course_id = co.id
             WHERE c.certificate_number = :certificate_number',
            ['certificate_number' => $certificateNumber]
        );
    }

    /**
     * Get all certificates for a user
     */
    public function getByUser(int $userId): array
    {
        return Database::fetchAll(
            'SELECT c.*, co.title as course_title, co.slug as course_slug, 
                    cc.name as category_name, cc.slug as category_slug
             FROM certificates c
             JOIN courses co ON c.course_id = co.id
             LEFT JOIN course_categories cc ON co.category_id = cc.id
             WHERE c.user_id = :user_id
             ORDER BY c.issued_at DESC',
            ['user_id' => $userId]
        );
    }

    /**
     * Get all certificates for a course
     */
    public function getByCourse(int $courseId): array
    {
        return Database::fetchAll(
            'SELECT c.*, u.first_name, u.last_name, u.email
             FROM certificates c
             JOIN users u ON c.user_id = u.id
             WHERE c.course_id = :course_id
             ORDER BY c.issued_at DESC',
            ['course_id' => $courseId]
        );
    }

    /**
     * Check if user has certificate for course
     */
    public function userHasCertificate(int $userId, int $courseId): bool
    {
        $result = Database::fetch(
            'SELECT id FROM certificates 
             WHERE user_id = :user_id AND course_id = :course_id',
            ['user_id' => $userId, 'course_id' => $courseId]
        );

        return $result !== null;
    }

    /**
     * Create new certificate
     */
    public function create(array $data): int
    {
        // Generate UUID if not provided
        if (empty($data['uuid'])) {
            $data['uuid'] = $this->generateUuid();
        }

        // Generate certificate number if not provided
        if (empty($data['certificate_number'])) {
            $data['certificate_number'] = $this->generateCertificateNumber();
        }

        $data['issued_at'] = $data['issued_at'] ?? date('Y-m-d H:i:s');

        return Database::insert('certificates', $data);
    }

    /**
     * Update certificate
     */
    public function update(int $id, array $data): bool
    {
        return Database::update('certificates', $data, 'id = :id', ['id' => $id]) > 0;
    }

    /**
     * Revoke certificate
     */
    public function revoke(int $id, int $revokedBy, string $reason = null): bool
    {
        return $this->update($id, [
            'verified' => 0,
            'revoked_at' => date('Y-m-d H:i:s'),
            'revoked_by' => $revokedBy,
            'revocation_reason' => $reason
        ]);
    }

    /**
     * Restore revoked certificate
     */
    public function restore(int $id): bool
    {
        return $this->update($id, [
            'verified' => 1,
            'revoked_at' => null,
            'revoked_by' => null,
            'revocation_reason' => null
        ]);
    }

    /**
     * Get certificate statistics
     */
    public function getStatistics(): array
    {
        $stats = Database::fetch(
            'SELECT 
                COUNT(*) as total_certificates,
                COUNT(DISTINCT user_id) as unique_users,
                COUNT(DISTINCT course_id) as unique_courses
             FROM certificates'
        );

        return $stats ?: [
            'total_certificates' => 0,
            'unique_users' => 0,
            'unique_courses' => 0
        ];
    }

    /**
     * Delete certificate
     */
    public function delete(int $id): bool
    {
        return Database::delete('certificates', 'id = :id', ['id' => $id]) > 0;
    }

    /**
     * Generate unique UUID
     */
    private function generateUuid(): string
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff)
        );
    }

    /**
     * Generate unique certificate number
     */
    private function generateCertificateNumber(): string
    {
        $year = date('Y');
        $random = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 8));
        
        return "NEBA-{$year}-{$random}";
    }
}
