<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Received</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f3f4f6;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f3f4f6; padding: 40px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #002060 0%, #003080 100%); padding: 40px 30px; text-align: center;">
                            <h1 style="margin: 0; color: #ffffff; font-size: 28px; font-weight: 700;">Nebatech AI Academy</h1>
                            <p style="margin: 10px 0 0 0; color: #FFA500; font-size: 14px; font-weight: 500;">Learn by Doing, Master by Practicing</p>
                        </td>
                    </tr>
                    
                    <!-- Content -->
                    <tr>
                        <td style="padding: 40px 30px;">
                            <div style="text-align: center; margin-bottom: 30px;">
                                <div style="display: inline-block; background-color: #10B981; color: white; width: 60px; height: 60px; border-radius: 50%; line-height: 60px; font-size: 30px;">
                                    ✓
                                </div>
                            </div>
                            
                            <h2 style="color: #002060; font-size: 24px; margin: 0 0 20px 0; text-align: center;">Application Received!</h2>
                            
                            <p style="color: #374151; font-size: 16px; line-height: 1.6; margin: 0 0 15px 0;">Dear <strong><?= htmlspecialchars($name) ?></strong>,</p>
                            
                            <p style="color: #374151; font-size: 16px; line-height: 1.6; margin: 0 0 15px 0;">
                                Thank you for applying to our <strong style="color: #002060;"><?= htmlspecialchars($program) ?></strong> program at Nebatech AI Academy.
                            </p>
                            
                            <p style="color: #374151; font-size: 16px; line-height: 1.6; margin: 0 0 15px 0;">
                                Your application has been successfully received and is currently under review by our admissions team. We carefully evaluate each application to ensure the best fit for our programs.
                            </p>
                            
                            <!-- Info Box -->
                            <div style="background-color: #F3F4F6; border-left: 4px solid #FFA500; padding: 20px; margin: 25px 0; border-radius: 6px;">
                                <p style="margin: 0 0 10px 0; color: #002060; font-weight: 600; font-size: 14px;">APPLICATION DETAILS</p>
                                <p style="margin: 0; color: #6B7280; font-size: 14px;">
                                    <strong>Application ID:</strong> <?= htmlspecialchars($application_id) ?><br>
                                    <strong>Program:</strong> <?= htmlspecialchars($program) ?><br>
                                    <strong>Status:</strong> Under Review
                                </p>
                            </div>
                            
                            <p style="color: #374151; font-size: 16px; line-height: 1.6; margin: 0 0 15px 0;">
                                <strong>What happens next?</strong>
                            </p>
                            
                            <ul style="color: #374151; font-size: 16px; line-height: 1.8; margin: 0 0 25px 0; padding-left: 20px;">
                                <li>Our admissions team will review your application within <strong>3-5 business days</strong></li>
                                <li>You'll receive an email notification with our decision</li>
                                <li>If approved, you'll get immediate access to your learning dashboard</li>
                            </ul>
                            
                            <p style="color: #374151; font-size: 16px; line-height: 1.6; margin: 0 0 15px 0;">
                                If you have any questions, feel free to reach out to our support team at <a href="mailto:admissions@nebatech.com" style="color: #FFA500; text-decoration: none;">admissions@nebatech.com</a>
                            </p>
                            
                            <p style="color: #374151; font-size: 16px; line-height: 1.6; margin: 25px 0 0 0;">
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
                                Empowering learners with hands-on IT skills for the future of work.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
