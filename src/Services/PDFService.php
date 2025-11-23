<?php

namespace Nebatech\Services;

use TCPDF;

class PDFService
{
    /**
     * Generate certificate PDF
     */
    public function generateCertificate(array $certificate, array $user, array $course): string
    {
        // Create new PDF document
        $pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);

        // Set document information
        $pdf->SetCreator('Nebatech AI Academy');
        $pdf->SetAuthor('Nebatech AI Academy');
        $pdf->SetTitle('Certificate of Completion');
        $pdf->SetSubject('Certificate');

        // Remove default header/footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        // Set margins
        $pdf->SetMargins(15, 15, 15);
        $pdf->SetAutoPageBreak(false, 0);

        // Add a page
        $pdf->AddPage();

        // Set colors
        $brandColor = [0, 32, 96]; // #002060
        $accentColor = [255, 165, 0]; // #FFA500

        // Draw border
        $pdf->SetLineStyle(['width' => 2, 'color' => $brandColor]);
        $pdf->Rect(10, 10, 277, 190, 'D');
        
        $pdf->SetLineStyle(['width' => 1, 'color' => $accentColor]);
        $pdf->Rect(12, 12, 273, 186, 'D');

        // Add logo/header area with background
        $pdf->SetFillColor($brandColor[0], $brandColor[1], $brandColor[2]);
        $pdf->Rect(15, 15, 267, 30, 'F');

        // Title
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFont('helvetica', 'B', 32);
        $pdf->SetXY(15, 22);
        $pdf->Cell(267, 15, 'CERTIFICATE OF COMPLETION', 0, 1, 'C');

        // Subtitle
        $pdf->SetFont('helvetica', '', 12);
        $pdf->SetXY(15, 35);
        $pdf->Cell(267, 8, 'Nebatech AI Academy', 0, 1, 'C');

        // Main content area
        $pdf->SetTextColor(0, 0, 0);
        
        // "This is to certify that"
        $pdf->SetFont('helvetica', '', 14);
        $pdf->SetXY(15, 60);
        $pdf->Cell(267, 10, 'This is to certify that', 0, 1, 'C');

        // Student name
        $pdf->SetFont('helvetica', 'B', 24);
        $pdf->SetTextColor($brandColor[0], $brandColor[1], $brandColor[2]);
        $pdf->SetXY(15, 72);
        $studentName = $user['first_name'] . ' ' . $user['last_name'];
        $pdf->Cell(267, 12, strtoupper($studentName), 0, 1, 'C');

        // Underline for name
        $pdf->SetLineStyle(['width' => 0.5, 'color' => $accentColor]);
        $nameWidth = $pdf->GetStringWidth(strtoupper($studentName)) + 20;
        $nameX = (297 - $nameWidth) / 2;
        $pdf->Line($nameX, 85, $nameX + $nameWidth, 85);

        // "has successfully completed"
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', '', 14);
        $pdf->SetXY(15, 92);
        $pdf->Cell(267, 10, 'has successfully completed the course', 0, 1, 'C');

        // Course name
        $pdf->SetFont('helvetica', 'B', 20);
        $pdf->SetTextColor($brandColor[0], $brandColor[1], $brandColor[2]);
        $pdf->SetXY(15, 105);
        $pdf->MultiCell(267, 10, $course['title'], 0, 'C', false, 1);

        // Course details
        $pdf->SetFont('helvetica', '', 11);
        $pdf->SetTextColor(80, 80, 80);
        $pdf->SetXY(15, 125);
        $courseDetails = '';
        if (!empty($course['duration_hours'])) {
            $courseDetails .= 'Duration: ' . $course['duration_hours'] . ' hours';
        }
        if (!empty($course['level'])) {
            $courseDetails .= ($courseDetails ? ' | ' : '') . 'Level: ' . ucfirst($course['level']);
        }
        if ($courseDetails) {
            $pdf->Cell(267, 8, $courseDetails, 0, 1, 'C');
        }

        // Date and certificate number
        $pdf->SetFont('helvetica', '', 10);
        $pdf->SetTextColor(0, 0, 0);
        
        // Date issued
        $pdf->SetXY(40, 155);
        $pdf->Cell(80, 8, 'Date Issued:', 0, 0, 'L');
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(60, 8, date('F d, Y', strtotime($certificate['issued_at'])), 0, 1, 'L');

        // Certificate number
        $pdf->SetFont('helvetica', '', 10);
        $pdf->SetXY(177, 155);
        $pdf->Cell(80, 8, 'Certificate No:', 0, 0, 'R');
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(0, 8, $certificate['certificate_number'], 0, 1, 'R');

        // Signature line
        $pdf->SetLineStyle(['width' => 0.5, 'color' => [0, 0, 0]]);
        $pdf->Line(100, 175, 180, 175);
        
        $pdf->SetFont('helvetica', '', 9);
        $pdf->SetXY(100, 176);
        $pdf->Cell(80, 6, 'Authorized Signature', 0, 1, 'C');

        // Footer - Verification URL
        $pdf->SetFont('helvetica', '', 8);
        $pdf->SetTextColor(100, 100, 100);
        $pdf->SetXY(15, 188);
        $verifyUrl = url('/verify-certificate?id=' . $certificate['certificate_number']);
        $pdf->Cell(267, 6, 'Verify this certificate at: ' . $verifyUrl, 0, 1, 'C');

        // Tagline
        $pdf->SetFont('helvetica', 'I', 9);
        $pdf->SetTextColor($accentColor[0], $accentColor[1], $accentColor[2]);
        $pdf->SetXY(15, 193);
        $pdf->Cell(267, 6, 'Learn by Doing, Master by Practicing', 0, 1, 'C');

        // Generate PDF file path
        $uploadDir = __DIR__ . '/../../storage/uploads/certificates/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $filename = 'certificate_' . $certificate['uuid'] . '.pdf';
        $filepath = $uploadDir . $filename;

        // Save PDF to file
        $pdf->Output($filepath, 'F');

        return $filepath;
    }

    /**
     * Generate and output certificate PDF for download
     */
    public function downloadCertificate(array $certificate, array $user, array $course): void
    {
        $filepath = $this->generateCertificate($certificate, $user, $course);
        
        if (file_exists($filepath)) {
            $filename = 'Certificate_' . $user['last_name'] . '_' . $certificate['certificate_number'] . '.pdf';
            
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            header('Content-Length: ' . filesize($filepath));
            header('Cache-Control: private, max-age=0, must-revalidate');
            header('Pragma: public');
            
            readfile($filepath);
            exit;
        }
    }

    /**
     * Get certificate PDF path
     */
    public function getCertificatePath(string $uuid): ?string
    {
        $uploadDir = __DIR__ . '/../../storage/uploads/certificates/';
        $filename = 'certificate_' . $uuid . '.pdf';
        $filepath = $uploadDir . $filename;

        return file_exists($filepath) ? $filepath : null;
    }
}
