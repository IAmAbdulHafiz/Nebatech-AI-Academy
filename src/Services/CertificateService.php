<?php

namespace Nebatech\Services;

use Mpdf\Mpdf;
use Nebatech\Models\Certificate;
use Nebatech\Models\User;
use Nebatech\Models\Course;

class CertificateService
{
    private string $storagePath;
    
    public function __construct()
    {
        $this->storagePath = __DIR__ . '/../../storage/certificates';
        
        // Create storage directory if it doesn't exist
        if (!is_dir($this->storagePath)) {
            mkdir($this->storagePath, 0755, true);
        }
    }
    
    /**
     * Generate PDF certificate
     */
    public function generateCertificate(string $certificateId): ?string
    {
        $certificate = Certificate::findById($certificateId);
        
        if (!$certificate) {
            return null;
        }
        
        try {
            // Create mPDF instance
            $mpdf = new Mpdf([
                'mode' => 'utf-8',
                'format' => [297, 210], // A4 landscape
                'orientation' => 'L',
                'margin_top' => 0,
                'margin_bottom' => 0,
                'margin_left' => 0,
                'margin_right' => 0
            ]);
            
            // Generate HTML content
            $html = $this->getCertificateHTML($certificate);
            
            // Write HTML to PDF
            $mpdf->WriteHTML($html);
            
            // Generate filename
            $filename = $this->generateFilename($certificate);
            $filepath = $this->storagePath . '/' . $filename;
            
            // Save PDF
            $mpdf->Output($filepath, 'F');
            
            // Update certificate record with PDF path
            Certificate::updatePdfPath($certificateId, $filename);
            
            return $filename;
            
        } catch (\Exception $e) {
            error_log("Certificate generation error: " . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Get certificate HTML template
     */
    private function getCertificateHTML(array $certificate): string
    {
        $fullName = $certificate['first_name'] . ' ' . $certificate['last_name'];
        $courseName = $certificate['course_title'];
        $issueDate = date('F j, Y', strtotime($certificate['issue_date']));
        $certificateNumber = $certificate['certificate_number'];
        $verificationUrl = url('/certificates/verify/' . $certificate['verification_code']);
        
        // Calculate completion details
        $metadata = $certificate['metadata'] ?? [];
        $finalScore = $metadata['final_score'] ?? 'N/A';
        $completionDate = $metadata['completion_date'] ?? $issueDate;
        
        return <<<HTML
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        @page {
            margin: 0;
        }
        body {
            font-family: 'Georgia', serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .certificate {
            width: 297mm;
            height: 210mm;
            position: relative;
            background: white;
            padding: 0;
            margin: 0;
        }
        .border-frame {
            position: absolute;
            top: 15mm;
            left: 15mm;
            right: 15mm;
            bottom: 15mm;
            border: 3px solid #667eea;
            border-radius: 10px;
        }
        .inner-border {
            position: absolute;
            top: 18mm;
            left: 18mm;
            right: 18mm;
            bottom: 18mm;
            border: 1px solid #667eea;
            border-radius: 8px;
        }
        .content {
            position: absolute;
            top: 30mm;
            left: 30mm;
            right: 30mm;
            bottom: 30mm;
            text-align: center;
        }
        .logo {
            font-size: 28px;
            color: #667eea;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .certificate-title {
            font-size: 48px;
            color: #333;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 4px;
            margin-bottom: 20px;
        }
        .presented-to {
            font-size: 18px;
            color: #666;
            margin-bottom: 15px;
        }
        .recipient-name {
            font-size: 42px;
            color: #667eea;
            font-weight: bold;
            margin-bottom: 25px;
            border-bottom: 2px solid #667eea;
            padding-bottom: 10px;
            display: inline-block;
        }
        .description {
            font-size: 16px;
            color: #555;
            line-height: 1.8;
            margin-bottom: 25px;
        }
        .course-name {
            font-size: 24px;
            color: #764ba2;
            font-weight: bold;
            margin-bottom: 30px;
        }
        .footer {
            position: absolute;
            bottom: 30mm;
            left: 30mm;
            right: 30mm;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }
        .signature-block {
            text-align: center;
            width: 30%;
        }
        .signature-line {
            border-top: 2px solid #333;
            margin-top: 40px;
            padding-top: 5px;
            font-size: 14px;
            color: #555;
        }
        .certificate-meta {
            font-size: 11px;
            color: #999;
            position: absolute;
            bottom: 20mm;
            left: 30mm;
            right: 30mm;
            text-align: center;
        }
        .seal {
            position: absolute;
            bottom: 35mm;
            left: 35mm;
            width: 70px;
            height: 70px;
            border: 3px solid #667eea;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: white;
        }
        .seal-inner {
            width: 60px;
            height: 60px;
            border: 2px solid #764ba2;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            color: #667eea;
            font-weight: bold;
            text-align: center;
            line-height: 1.2;
        }
        .achievement-badge {
            position: absolute;
            top: 25mm;
            right: 30mm;
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 28px;
        }
    </style>
</head>
<body>
    <div class="certificate">
        <div class="border-frame"></div>
        <div class="inner-border"></div>
        
        <div class="achievement-badge">★</div>
        
        <div class="content">
            <div class="logo">🎓 NEBATECH AI ACADEMY</div>
            
            <div class="certificate-title">Certificate of Completion</div>
            
            <div class="presented-to">This is to certify that</div>
            
            <div class="recipient-name">{$fullName}</div>
            
            <div class="description">
                has successfully completed the requirements and demonstrated proficiency in
            </div>
            
            <div class="course-name">{$courseName}</div>
            
            <div class="description">
                Awarded on {$issueDate}
            </div>
        </div>
        
        <div class="seal">
            <div class="seal-inner">
                OFFICIAL<br>SEAL
            </div>
        </div>
        
        <div class="footer">
            <div class="signature-block">
                <div class="signature-line">
                    <strong>Director</strong><br>
                    Nebatech AI Academy
                </div>
            </div>
            
            <div class="signature-block">
                <div class="signature-line">
                    <strong>Date of Issue</strong><br>
                    {$issueDate}
                </div>
            </div>
            
            <div class="signature-block">
                <div class="signature-line">
                    <strong>Certificate ID</strong><br>
                    {$certificateNumber}
                </div>
            </div>
        </div>
        
        <div class="certificate-meta">
            Verify this certificate at: {$verificationUrl}<br>
            Verification Code: {$certificate['verification_code']}
        </div>
    </div>
</body>
</html>
HTML;
    }
    
    /**
     * Generate filename for certificate
     */
    private function generateFilename(array $certificate): string
    {
        $safeName = preg_replace('/[^a-zA-Z0-9-_]/', '_', $certificate['certificate_number']);
        return $safeName . '.pdf';
    }
    
    /**
     * Get certificate file path
     */
    public function getCertificatePath(string $filename): string
    {
        return $this->storagePath . '/' . $filename;
    }
    
    /**
     * Check if certificate PDF exists
     */
    public function certificateExists(string $filename): bool
    {
        return file_exists($this->getCertificatePath($filename));
    }
    
    /**
     * Download certificate
     */
    public function downloadCertificate(string $filename): void
    {
        $filepath = $this->getCertificatePath($filename);
        
        if (!file_exists($filepath)) {
            http_response_code(404);
            echo "Certificate not found";
            return;
        }
        
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . basename($filename) . '"');
        header('Content-Length: ' . filesize($filepath));
        header('Cache-Control: private, max-age=0, must-revalidate');
        header('Pragma: public');
        
        readfile($filepath);
        exit;
    }
    
    /**
     * Display certificate in browser
     */
    public function displayCertificate(string $filename): void
    {
        $filepath = $this->getCertificatePath($filename);
        
        if (!file_exists($filepath)) {
            http_response_code(404);
            echo "Certificate not found";
            return;
        }
        
        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="' . basename($filename) . '"');
        header('Content-Length: ' . filesize($filepath));
        header('Cache-Control: private, max-age=0, must-revalidate');
        header('Pragma: public');
        
        readfile($filepath);
        exit;
    }
    
    /**
     * Delete certificate file
     */
    public function deleteCertificate(string $filename): bool
    {
        $filepath = $this->getCertificatePath($filename);
        
        if (file_exists($filepath)) {
            return unlink($filepath);
        }
        
        return false;
    }
}
