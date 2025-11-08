<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Received</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f7fa;">
    <table role="presentation" style="width: 100%; border-collapse: collapse;">
        <tr>
            <td align="center" style="padding: 40px 0;">
                <table role="presentation" style="width: 600px; border-collapse: collapse; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 40px 30px; text-align: center;">
                            <h1 style="margin: 0; color: #ffffff; font-size: 28px; font-weight: 600;">
                                Application Received!
                            </h1>
                            <p style="margin: 10px 0 0 0; color: #e0e7ff; font-size: 16px;">
                                Thank you for your interest in Nebatech AI Academy
                            </p>
                        </td>
                    </tr>
                    
                    <!-- Success Icon -->
                    <tr>
                        <td style="padding: 30px; text-align: center;">
                            <div style="width: 80px; height: 80px; margin: 0 auto; background-color: #10b981; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center;">
                                <span style="color: white; font-size: 40px;">✓</span>
                            </div>
                        </td>
                    </tr>
                    
                    <!-- Content -->
                    <tr>
                        <td style="padding: 0 40px 30px 40px;">
                            <p style="margin: 0 0 20px 0; color: #1f2937; font-size: 16px; line-height: 1.6;">
                                Dear <strong><?= htmlspecialchars($firstName . ' ' . $lastName) ?></strong>,
                            </p>
                            
                            <p style="margin: 0 0 20px 0; color: #4b5563; font-size: 15px; line-height: 1.6;">
                                We have successfully received your application for the <strong><?= htmlspecialchars($programName) ?></strong> program. 
                                Your application is now under review by our admissions team.
                            </p>
                            
                            <!-- Application Details Box -->
                            <div style="background-color: #f9fafb; border-left: 4px solid #667eea; padding: 20px; margin: 25px 0; border-radius: 4px;">
                                <h3 style="margin: 0 0 15px 0; color: #1f2937; font-size: 16px;">Application Details</h3>
                                <table style="width: 100%; border-collapse: collapse;">
                                    <tr>
                                        <td style="padding: 8px 0; color: #6b7280; font-size: 14px;">Application ID:</td>
                                        <td style="padding: 8px 0; color: #1f2937; font-size: 14px; text-align: right; font-family: monospace;">
                                            <strong><?= htmlspecialchars($applicationUuid) ?></strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 8px 0; color: #6b7280; font-size: 14px;">Program:</td>
                                        <td style="padding: 8px 0; color: #1f2937; font-size: 14px; text-align: right;">
                                            <strong><?= htmlspecialchars($programName) ?></strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 8px 0; color: #6b7280; font-size: 14px;">Submitted:</td>
                                        <td style="padding: 8px 0; color: #1f2937; font-size: 14px; text-align: right;">
                                            <strong><?= date('F j, Y', strtotime($submittedAt)) ?></strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 8px 0; color: #6b7280; font-size: 14px;">Status:</td>
                                        <td style="padding: 8px 0; text-align: right;">
                                            <span style="background-color: #fef3c7; color: #92400e; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600;">
                                                PENDING REVIEW
                                            </span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            
                            <!-- What Happens Next -->
                            <div style="background-color: #eff6ff; border-radius: 8px; padding: 20px; margin: 25px 0;">
                                <h3 style="margin: 0 0 15px 0; color: #1e40af; font-size: 16px;">📋 What Happens Next?</h3>
                                <ul style="margin: 0; padding-left: 20px; color: #1e3a8a;">
                                    <li style="margin-bottom: 10px; font-size: 14px; line-height: 1.5;">
                                        Our admissions team will review your application within <strong>3-5 business days</strong>
                                    </li>
                                    <li style="margin-bottom: 10px; font-size: 14px; line-height: 1.5;">
                                        You will receive an email notification once a decision has been made
                                    </li>
                                    <li style="margin-bottom: 10px; font-size: 14px; line-height: 1.5;">
                                        You can check your application status anytime in your student dashboard
                                    </li>
                                    <li style="margin-bottom: 0; font-size: 14px; line-height: 1.5;">
                                        If you have any questions, feel free to contact our support team
                                    </li>
                                </ul>
                            </div>
                            
                            <p style="margin: 25px 0 0 0; color: #4b5563; font-size: 14px; line-height: 1.6;">
                                Please keep this email for your records. You can use the Application ID above to track your application status.
                            </p>
                        </td>
                    </tr>
                    
                    <!-- Action Button -->
                    <tr>
                        <td style="padding: 0 40px 40px 40px; text-align: center;">
                            <a href="<?= url('/dashboard') ?>" style="display: inline-block; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #ffffff; text-decoration: none; padding: 14px 32px; border-radius: 6px; font-weight: 600; font-size: 15px;">
                                View Dashboard
                            </a>
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f9fafb; padding: 30px; text-align: center; border-top: 1px solid #e5e7eb;">
                            <p style="margin: 0 0 10px 0; color: #6b7280; font-size: 13px;">
                                Need help? Contact us at <a href="mailto:admissions@nebatech.com" style="color: #667eea; text-decoration: none;">admissions@nebatech.com</a>
                            </p>
                            <p style="margin: 0 0 15px 0; color: #9ca3af; font-size: 12px;">
                                Nebatech AI Academy &copy; <?= date('Y') ?>. All rights reserved.
                            </p>
                            <p style="margin: 0; color: #9ca3af; font-size: 11px;">
                                Empowering Africa with AI-Driven Education
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
