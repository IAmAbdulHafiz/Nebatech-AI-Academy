<?php
$title = 'Certificate - ' . htmlspecialchars($certificate['first_name'] . ' ' . $certificate['last_name']);
$verificationUrl = url('/verify-certificate?id=' . $certificate['certificate_number']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link href="<?= asset('css/main.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        @page {
            size: landscape;
            margin: 0;
        }
        
        @media print {
            html, body {
                width: 297mm;
                height: 210mm;
                margin: 0;
                padding: 0;
                background: white !important;
            }
            
            .no-print {
                display: none !important;
            }
            
            .certificate-container {
                width: 297mm !important;
                height: 210mm !important;
                max-width: none !important;
                margin: 0 !important;
                padding: 0 !important;
                page-break-after: avoid;
                page-break-inside: avoid;
            }
            
            .certificate-content {
                transform: none !important;
                box-shadow: none !important;
            }
        }
        
        @media screen {
            body {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            }
        }
        
        .signature-line {
            border-top: 2px solid #002060;
            width: 200px;
            margin: 0 auto;
        }
        
        .decorative-corner {
            position: absolute;
            width: 150px;
            height: 150px;
        }
        
        .corner-tl {
            top: 0;
            left: 0;
            border-top: 8px solid #002060;
            border-left: 8px solid #002060;
        }
        
        .corner-tr {
            top: 0;
            right: 0;
            border-top: 8px solid #FFA500;
            border-right: 8px solid #FFA500;
        }
        
        .corner-bl {
            bottom: 0;
            left: 0;
            border-bottom: 8px solid #FFA500;
            border-left: 8px solid #FFA500;
        }
        
        .corner-br {
            bottom: 0;
            right: 0;
            border-bottom: 8px solid #002060;
            border-right: 8px solid #002060;
        }
        
        .ornament {
            font-family: 'Playfair Display', serif;
            color: #002060;
        }
        
        .certificate-title {
            font-family: 'Playfair Display', serif;
            font-weight: 900;
            letter-spacing: 0.05em;
        }
        
        .recipient-name {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            color: #002060;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
        }
        
        .course-name {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            color: #FFA500;
        }
        
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 120px;
            font-weight: 900;
            color: rgba(0, 32, 96, 0.03);
            z-index: 0;
            pointer-events: none;
            font-family: 'Playfair Display', serif;
        }
    </style>
</head>
<body>
    <div class="min-h-screen flex items-center justify-center p-4 sm:p-8 no-print">
        <div class="certificate-container w-full max-w-7xl">
            <!-- Certificate in Landscape A4 -->
            <div class="certificate-content bg-white shadow-2xl relative" style="aspect-ratio: 297/210;">
                <!-- Watermark -->
                <div class="watermark">NEBATECH</div>
                
                <!-- Decorative Corners -->
                <div class="decorative-corner corner-tl"></div>
                <div class="decorative-corner corner-tr"></div>
                <div class="decorative-corner corner-bl"></div>
                <div class="decorative-corner corner-br"></div>
                
                <!-- Certificate Content -->
                <div class="relative z-10 h-full flex flex-col p-12">
                    <!-- Header -->
                    <div class="text-center mb-6">
                        <div class="flex items-center justify-center gap-4 mb-4">
                            <div class="w-16 h-16 rounded-full flex items-center justify-center" style="background: #002060;">
                                <span class="text-white font-bold text-3xl" style="font-family: 'Playfair Display', serif;">N</span>
                            </div>
                            <div class="text-left">
                                <h1 class="text-3xl font-bold" style="color: #002060; font-family: 'Playfair Display', serif;">NEBATECH</h1>
                                <p class="text-sm tracking-widest" style="color: #FFA500; font-weight: 600;">AI ACADEMY</p>
                            </div>
                        </div>
                        <div class="flex items-center justify-center gap-3 mb-2">
                            <div class="h-px w-24" style="background: #002060;"></div>
                            <span class="ornament text-2xl">❖</span>
                            <div class="h-px w-24" style="background: #002060;"></div>
                        </div>
                        <h2 class="certificate-title text-4xl" style="color: #002060;">CERTIFICATE OF COMPLETION</h2>
                        <div class="flex items-center justify-center gap-3 mt-2">
                            <div class="h-px w-24" style="background: #FFA500;"></div>
                            <span class="ornament text-2xl" style="color: #FFA500;">❖</span>
                            <div class="h-px w-24" style="background: #FFA500;"></div>
                        </div>
                    </div>

                    <!-- Body -->
                    <div class="flex-1 flex flex-col justify-center text-center px-8">
                        <p class="text-lg mb-4" style="color: #333; font-family: 'Inter', sans-serif; font-weight: 300;">This is to certify that</p>
                        
                        <h3 class="recipient-name text-5xl mb-6 px-8">
                            <?= htmlspecialchars($certificate['first_name'] . ' ' . $certificate['last_name']) ?>
                        </h3>
                        
                        <p class="text-lg mb-4" style="color: #333; font-family: 'Inter', sans-serif; font-weight: 300;">has successfully completed the course</p>
                        
                        <h4 class="course-name text-3xl mb-6 px-12">
                            <?= htmlspecialchars($certificate['course_title']) ?>
                        </h4>
                        
                        <div class="flex justify-center gap-12 text-sm mb-6" style="color: #666; font-family: 'Inter', sans-serif;">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-layer-group" style="color: #002060;"></i>
                                <span>Level: <strong><?= ucfirst($certificate['level']) ?></strong></span>
                            </div>
                            <div class="flex items-center gap-2">
                                <i class="fas fa-clock" style="color: #FFA500;"></i>
                                <span>Duration: <strong><?= $certificate['duration_hours'] ?> hours</strong></span>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="grid grid-cols-3 gap-8 items-end pt-6" style="border-top: 2px solid #002060;">
                        <!-- Date -->
                        <div class="text-center">
                            <div class="signature-line mb-2"></div>
                            <p class="text-xs" style="color: #666; font-family: 'Inter', sans-serif;">Issue Date</p>
                            <p class="font-bold text-sm" style="color: #002060;"><?= date('F d, Y', strtotime($certificate['issued_at'])) ?></p>
                        </div>
                        
                        <!-- Seal/Badge -->
                        <div class="text-center">
                            <?php if ($certificate['verified']): ?>
                                <div class="inline-flex flex-col items-center">
                                    <div class="w-20 h-20 rounded-full flex items-center justify-center mb-2" style="background: linear-gradient(135deg, #002060 0%, #FFA500 100%); box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
                                        <i class="fas fa-certificate text-white text-2xl"></i>
                                    </div>
                                    <p class="text-xs font-bold" style="color: #002060;">VERIFIED</p>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Certificate Number -->
                        <div class="text-center">
                            <div class="signature-line mb-2"></div>
                            <p class="text-xs" style="color: #666; font-family: 'Inter', sans-serif;">Certificate ID</p>
                            <p class="font-mono font-bold text-xs" style="color: #002060;"><?= htmlspecialchars($certificate['certificate_number']) ?></p>
                        </div>
                    </div>
                    
                    <!-- Verification URL (small) -->
                    <div class="text-center mt-4">
                        <p class="text-xs" style="color: #999; font-family: 'Inter', sans-serif;">
                            Verify at: <span class="font-mono"><?= $verificationUrl ?></span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="mt-8 flex gap-4 justify-center no-print">
                <?php if (isset($canPrint) && $canPrint): ?>
                    <button onclick="window.print()" class="px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        <i class="fas fa-print mr-2"></i>Print Certificate
                    </button>
                <?php endif; ?>
                <a href="<?= url('/verify-certificate?id=' . $certificate['certificate_number']) ?>" 
                   class="px-8 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    <i class="fas fa-shield-alt mr-2"></i>Verify Certificate
                </a>
                <a href="<?= url('/') ?>" 
                   class="px-8 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    <i class="fas fa-home mr-2"></i>Home
                </a>
            </div>

            <!-- Footer Info -->
            <div class="mt-6 text-center text-sm no-print">
                <p class="text-white font-medium">This is an official certificate issued by Nebatech AI Academy</p>
                <p class="mt-1 text-white">For inquiries, visit <a href="<?= url('/') ?>" class="text-yellow-300 hover:text-yellow-200 underline font-semibold">nebatech.com</a></p>
            </div>
        </div>
    </div>

    <!-- Print Version (Hidden on screen, shown when printing) -->
    <div class="print-only" style="display: none;">
        <div class="certificate-container" style="width: 297mm; height: 210mm; margin: 0; padding: 0;">
            <div class="certificate-content bg-white relative" style="width: 100%; height: 100%;">
                <!-- Watermark -->
                <div class="watermark">NEBATECH</div>
                
                <!-- Decorative Corners -->
                <div class="decorative-corner corner-tl"></div>
                <div class="decorative-corner corner-tr"></div>
                <div class="decorative-corner corner-bl"></div>
                <div class="decorative-corner corner-br"></div>
                
                <!-- Certificate Content -->
                <div class="relative z-10 h-full flex flex-col p-12">
                    <!-- Header -->
                    <div class="text-center mb-6">
                        <div class="flex items-center justify-center gap-4 mb-4">
                            <div class="w-16 h-16 rounded-full flex items-center justify-center" style="background: #002060;">
                                <span class="text-white font-bold text-3xl" style="font-family: 'Playfair Display', serif;">N</span>
                            </div>
                            <div class="text-left">
                                <h1 class="text-3xl font-bold" style="color: #002060; font-family: 'Playfair Display', serif;">NEBATECH</h1>
                                <p class="text-sm tracking-widest" style="color: #FFA500; font-weight: 600;">AI ACADEMY</p>
                            </div>
                        </div>
                        <div class="flex items-center justify-center gap-3 mb-2">
                            <div class="h-px w-24" style="background: #002060;"></div>
                            <span class="ornament text-2xl">❖</span>
                            <div class="h-px w-24" style="background: #002060;"></div>
                        </div>
                        <h2 class="certificate-title text-4xl" style="color: #002060;">CERTIFICATE OF COMPLETION</h2>
                        <div class="flex items-center justify-center gap-3 mt-2">
                            <div class="h-px w-24" style="background: #FFA500;"></div>
                            <span class="ornament text-2xl" style="color: #FFA500;">❖</span>
                            <div class="h-px w-24" style="background: #FFA500;"></div>
                        </div>
                    </div>

                    <!-- Body -->
                    <div class="flex-1 flex flex-col justify-center text-center px-8">
                        <p class="text-lg mb-4" style="color: #333; font-family: 'Inter', sans-serif; font-weight: 300;">This is to certify that</p>
                        
                        <h3 class="recipient-name text-5xl mb-6 px-8">
                            <?= htmlspecialchars($certificate['first_name'] . ' ' . $certificate['last_name']) ?>
                        </h3>
                        
                        <p class="text-lg mb-4" style="color: #333; font-family: 'Inter', sans-serif; font-weight: 300;">has successfully completed the course</p>
                        
                        <h4 class="course-name text-3xl mb-6 px-12">
                            <?= htmlspecialchars($certificate['course_title']) ?>
                        </h4>
                        
                        <div class="flex justify-center gap-12 text-sm mb-6" style="color: #666; font-family: 'Inter', sans-serif;">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-layer-group" style="color: #002060;"></i>
                                <span>Level: <strong><?= ucfirst($certificate['level']) ?></strong></span>
                            </div>
                            <div class="flex items-center gap-2">
                                <i class="fas fa-clock" style="color: #FFA500;"></i>
                                <span>Duration: <strong><?= $certificate['duration_hours'] ?> hours</strong></span>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="grid grid-cols-3 gap-8 items-end pt-6" style="border-top: 2px solid #002060;">
                        <!-- Date -->
                        <div class="text-center">
                            <div class="signature-line mb-2"></div>
                            <p class="text-xs" style="color: #666; font-family: 'Inter', sans-serif;">Issue Date</p>
                            <p class="font-bold text-sm" style="color: #002060;"><?= date('F d, Y', strtotime($certificate['issued_at'])) ?></p>
                        </div>
                        
                        <!-- Seal/Badge -->
                        <div class="text-center">
                            <?php if ($certificate['verified']): ?>
                                <div class="inline-flex flex-col items-center">
                                    <div class="w-20 h-20 rounded-full flex items-center justify-center mb-2" style="background: linear-gradient(135deg, #002060 0%, #FFA500 100%); box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
                                        <i class="fas fa-certificate text-white text-2xl"></i>
                                    </div>
                                    <p class="text-xs font-bold" style="color: #002060;">VERIFIED</p>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Certificate Number -->
                        <div class="text-center">
                            <div class="signature-line mb-2"></div>
                            <p class="text-xs" style="color: #666; font-family: 'Inter', sans-serif;">Certificate ID</p>
                            <p class="font-mono font-bold text-xs" style="color: #002060;"><?= htmlspecialchars($certificate['certificate_number']) ?></p>
                        </div>
                    </div>
                    
                    <!-- Verification URL (small) -->
                    <div class="text-center mt-4">
                        <p class="text-xs" style="color: #999; font-family: 'Inter', sans-serif;">
                            Verify at: <span class="font-mono"><?= $verificationUrl ?></span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @media print {
            .print-only {
                display: block !important;
            }
            .no-print {
                display: none !important;
            }
        }
    </style>

    <script>
        // Auto-print functionality (optional)
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('print') === 'true') {
            window.onload = function() {
                setTimeout(() => window.print(), 500);
            };
        }
    </script>
</body>
</html>
