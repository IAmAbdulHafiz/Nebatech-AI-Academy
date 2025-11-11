<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Status Update</title>
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
                            <h2 style="color: #002060; font-size: 24px; margin: 0 0 20px 0;">Application Status Update</h2>
                            
                            <p style="color: #374151; font-size: 16px; line-height: 1.6; margin: 0 0 15px 0;">Dear <strong><?= htmlspecialchars($name) ?></strong>,</p>
                            
                            <p style="color: #374151; font-size: 16px; line-height: 1.6; margin: 0 0 15px 0;">
                                Thank you for your interest in our <strong style="color: #002060;"><?= htmlspecialchars($program) ?></strong> program at Nebatech AI Academy.
                            </p>
                            
                            <p style="color: #374151; font-size: 16px; line-height: 1.6; margin: 0 0 15px 0;">
                                After careful review of your application, we regret to inform you that we are unable to offer you admission to this program at this time.
                            </p>
                            
                            <?php if (!empty($reason)): ?>
                            <!-- Reason Box -->
                            <div style="background-color: #FEF2F2; border-left: 4px solid #EF4444; padding: 20px; margin: 25px 0; border-radius: 6px;">
                                <p style="margin: 0 0 10px 0; color: #991B1B; font-weight: 600; font-size: 14px;">FEEDBACK</p>
                                <p style="margin: 0; color: #7F1D1D; font-size: 14px; line-height: 1.6;">
                                    <?= nl2br(htmlspecialchars($reason)) ?>
                                </p>
                            </div>
                            <?php endif; ?>
                            
                            <p style="color: #374151; font-size: 16px; line-height: 1.6; margin: 0 0 15px 0;">
                                Please know that this decision does not reflect on your potential or abilities. We receive many qualified applications and must make difficult choices based on program capacity and specific requirements.
                            </p>
                            
                            <!-- Encouragement Box -->
                            <div style="background-color: #DBEAFE; border-left: 4px solid #3B82F6; padding: 20px; margin: 25px 0; border-radius: 6px;">
                                <p style="margin: 0 0 10px 0; color: #1E40AF; font-weight: 600; font-size: 14px;">💪 DON'T GIVE UP!</p>
                                <p style="margin: 0; color: #1E3A8A; font-size: 14px; line-height: 1.6;">
                                    We encourage you to:
                                </p>
                                <ul style="margin: 10px 0 0 0; padding-left: 20px; color: #1E3A8A; font-size: 14px; line-height: 1.6;">
                                    <li>Reapply in the future (we welcome reapplications)</li>
                                    <li>Explore our other programs that might be a better fit</li>
                                    <li>Check out our free resources and blog posts</li>
                                    <li>Connect with us on social media for learning tips</li>
                                </ul>
                            </div>
                            
                            <div style="text-align: center; margin: 30px 0;">
                                <a href="<?= htmlspecialchars($apply_url) ?>" style="display: inline-block; background-color: #FFA500; color: #ffffff; padding: 14px 32px; text-decoration: none; border-radius: 6px; font-weight: 600; font-size: 16px;">
                                    Explore Other Programs
                                </a>
                            </div>
                            
                            <p style="color: #374151; font-size: 16px; line-height: 1.6; margin: 0 0 15px 0;">
                                If you have any questions about this decision or would like guidance on alternative paths, please don't hesitate to contact us at <a href="mailto:admissions@nebatech.com" style="color: #FFA500; text-decoration: none;">admissions@nebatech.com</a>
                            </p>
                            
                            <p style="color: #374151; font-size: 16px; line-height: 1.6; margin: 25px 0 0 0;">
                                We wish you all the best in your educational journey.<br><br>
                                Sincerely,<br>
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
