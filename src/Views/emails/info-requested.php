<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Additional Information Required</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f3f4f6;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f3f4f6; padding: 40px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%); padding: 40px 30px; text-align: center;">
                            <div style="font-size: 50px; margin-bottom: 10px;">📋</div>
                            <h1 style="margin: 0; color: #ffffff; font-size: 28px; font-weight: 700;">Additional Information Needed</h1>
                        </td>
                    </tr>
                    
                    <!-- Content -->
                    <tr>
                        <td style="padding: 40px 30px;">
                            <p style="color: #374151; font-size: 16px; line-height: 1.6; margin: 0 0 15px 0;">Dear <strong><?= htmlspecialchars($name) ?></strong>,</p>
                            
                            <p style="color: #374151; font-size: 16px; line-height: 1.6; margin: 0 0 15px 0;">
                                Thank you for your application to our <strong style="color: #002060;"><?= htmlspecialchars($program) ?></strong> program.
                            </p>
                            
                            <p style="color: #374151; font-size: 16px; line-height: 1.6; margin: 0 0 25px 0;">
                                We're currently reviewing your application and need some additional information to complete the evaluation process.
                            </p>
                            
                            <!-- Request Box -->
                            <div style="background-color: #FEF3C7; border-left: 4px solid #F59E0B; padding: 20px; margin: 25px 0; border-radius: 6px;">
                                <p style="margin: 0 0 10px 0; color: #92400E; font-weight: 600; font-size: 14px;">📝 INFORMATION REQUESTED</p>
                                <div style="background-color: #ffffff; padding: 15px; border-radius: 4px; margin-top: 10px;">
                                    <p style="margin: 0; color: #374151; font-size: 14px; line-height: 1.6; white-space: pre-wrap;"><?= nl2br(htmlspecialchars($requested_info)) ?></p>
                                </div>
                            </div>
                            
                            <p style="color: #374151; font-size: 16px; line-height: 1.6; margin: 0 0 15px 0;">
                                <strong>How to provide this information:</strong>
                            </p>
                            
                            <ol style="color: #374151; font-size: 16px; line-height: 1.8; margin: 0 0 25px 0; padding-left: 20px;">
                                <li>Click the button below to access your application</li>
                                <li>Update your application with the requested information</li>
                                <li>Submit the updated application</li>
                            </ol>
                            
                            <div style="text-align: center; margin: 30px 0;">
                                <a href="<?= htmlspecialchars($application_url) ?>" style="display: inline-block; background-color: #FFA500; color: #ffffff; padding: 14px 32px; text-decoration: none; border-radius: 6px; font-weight: 600; font-size: 16px;">
                                    Update My Application
                                </a>
                            </div>
                            
                            <!-- Timeline Box -->
                            <div style="background-color: #EFF6FF; border-left: 4px solid #3B82F6; padding: 20px; margin: 25px 0; border-radius: 6px;">
                                <p style="margin: 0 0 10px 0; color: #1E40AF; font-weight: 600; font-size: 14px;">⏰ IMPORTANT TIMELINE</p>
                                <p style="margin: 0; color: #1E3A8A; font-size: 14px; line-height: 1.6;">
                                    Please provide the requested information within <strong>7 days</strong> to avoid delays in processing your application. If you need more time, please contact our admissions team.
                                </p>
                            </div>
                            
                            <p style="color: #374151; font-size: 16px; line-height: 1.6; margin: 0 0 15px 0;">
                                If you have any questions or need assistance, please reach out to us at <a href="mailto:admissions@nebatech.com" style="color: #FFA500; text-decoration: none;">admissions@nebatech.com</a>
                            </p>
                            
                            <p style="color: #374151; font-size: 16px; line-height: 1.6; margin: 25px 0 0 0;">
                                We look forward to receiving your updated information!<br><br>
                                Best regards,<br>
                                <strong style="color: #002060;">Nebatech AI Academy Admissions Team</strong>
                            </p>
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #F9FAFB; padding: 30px; text-align: center; border-top: 1px solid #E5E7EB;">
                            <p style="margin: 0 0 10px 0; color: #6B7280; font-size: 14px;">
                                © <?= date('Y') ?> Nebatech AI Academy. All rights reserved.
                            </p>
                            <p style="margin: 0; color: #9CA3AF; font-size: 12px;">
                                Learn by Doing, Master by Practicing
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
