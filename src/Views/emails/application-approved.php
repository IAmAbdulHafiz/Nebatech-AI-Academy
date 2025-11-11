<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Approved</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f3f4f6;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f3f4f6; padding: 40px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #10B981 0%, #059669 100%); padding: 40px 30px; text-align: center;">
                            <div style="font-size: 60px; margin-bottom: 10px;">🎉</div>
                            <h1 style="margin: 0; color: #ffffff; font-size: 32px; font-weight: 700;">Congratulations!</h1>
                            <p style="margin: 10px 0 0 0; color: #ffffff; font-size: 16px;">You've Been Accepted</p>
                        </td>
                    </tr>
                    
                    <!-- Content -->
                    <tr>
                        <td style="padding: 40px 30px;">
                            <p style="color: #374151; font-size: 16px; line-height: 1.6; margin: 0 0 15px 0;">Dear <strong><?= htmlspecialchars($name) ?></strong>,</p>
                            
                            <p style="color: #374151; font-size: 16px; line-height: 1.6; margin: 0 0 15px 0;">
                                We're absolutely thrilled to inform you that your application for <strong style="color: #002060;"><?= htmlspecialchars($program) ?></strong> has been <strong style="color: #10B981;">APPROVED</strong>! 🚀
                            </p>
                            
                            <p style="color: #374151; font-size: 16px; line-height: 1.6; margin: 0 0 25px 0;">
                                Welcome to Nebatech AI Academy! You're now part of a community of passionate learners committed to mastering practical IT skills.
                            </p>
                            
                            <!-- Login Credentials Box -->
                            <div style="background: linear-gradient(135deg, #002060 0%, #003080 100%); padding: 30px; margin: 25px 0; border-radius: 8px;">
                                <h3 style="margin: 0 0 20px 0; color: #FFA500; font-size: 18px; text-align: center;">🔐 Your Login Credentials</h3>
                                
                                <div style="background-color: rgba(255, 255, 255, 0.1); padding: 20px; border-radius: 6px; margin-bottom: 20px;">
                                    <p style="margin: 0 0 10px 0; color: #ffffff; font-size: 14px;">
                                        <strong>Email:</strong><br>
                                        <span style="font-size: 16px; color: #FFA500;"><?= htmlspecialchars($email) ?></span>
                                    </p>
                                    <?php if (isset($temporary_password) && $temporary_password): ?>
                                    <p style="margin: 15px 0 0 0; color: #ffffff; font-size: 14px;">
                                        <strong>Temporary Password:</strong><br>
                                        <span style="font-size: 16px; color: #FFA500; font-family: monospace;"><?= htmlspecialchars($temporary_password) ?></span>
                                    </p>
                                    <p style="margin: 10px 0 0 0; color: #FCD34D; font-size: 12px;">
                                        ⚠️ Please change your password after first login
                                    </p>
                                    <?php endif; ?>
                                </div>
                                
                                <div style="text-align: center;">
                                    <a href="<?= htmlspecialchars($login_url) ?>" style="display: inline-block; background-color: #FFA500; color: #ffffff; padding: 14px 32px; text-decoration: none; border-radius: 6px; font-weight: 600; font-size: 16px;">
                                        Login to Your Dashboard
                                    </a>
                                </div>
                            </div>
                            
                            <?php if (isset($cohort) && $cohort): ?>
                            <!-- Cohort Information -->
                            <div style="background-color: #FEF3C7; border-left: 4px solid #FFA500; padding: 20px; margin: 25px 0; border-radius: 6px;">
                                <p style="margin: 0 0 10px 0; color: #002060; font-weight: 600; font-size: 14px;">👥 YOUR COHORT</p>
                                <p style="margin: 0; color: #374151; font-size: 14px;">
                                    <strong>Cohort Name:</strong> <?= htmlspecialchars($cohort['name']) ?><br>
                                    <strong>Start Date:</strong> <?= date('F d, Y', strtotime($cohort['start_date'])) ?><br>
                                    <?php if (isset($cohort['facilitator_name'])): ?>
                                    <strong>Facilitator:</strong> <?= htmlspecialchars($cohort['facilitator_name']) ?>
                                    <?php endif; ?>
                                </p>
                            </div>
                            <?php endif; ?>
                            
                            <h3 style="color: #002060; font-size: 18px; margin: 30px 0 15px 0;">🎯 What's Next?</h3>
                            
                            <ol style="color: #374151; font-size: 16px; line-height: 1.8; margin: 0 0 25px 0; padding-left: 20px;">
                                <li><strong>Login</strong> to your dashboard using the credentials above</li>
                                <li><strong>Complete your profile</strong> and set up your learning preferences</li>
                                <li><strong>Explore your course</strong> modules and learning path</li>
                                <li><strong>Join your cohort</strong> and connect with fellow learners</li>
                                <li><strong>Start learning</strong> with hands-on projects and assignments</li>
                            </ol>
                            
                            <div style="background-color: #EFF6FF; border-left: 4px solid #3B82F6; padding: 20px; margin: 25px 0; border-radius: 6px;">
                                <p style="margin: 0; color: #1E40AF; font-size: 14px; line-height: 1.6;">
                                    <strong>💡 Pro Tip:</strong> Our platform uses AI-powered learning to personalize your experience. The more you engage, the better your learning journey becomes!
                                </p>
                            </div>
                            
                            <p style="color: #374151; font-size: 16px; line-height: 1.6; margin: 0 0 15px 0;">
                                Need help getting started? Our support team is here for you at <a href="mailto:support@nebatech.com" style="color: #FFA500; text-decoration: none;">support@nebatech.com</a>
                            </p>
                            
                            <p style="color: #374151; font-size: 16px; line-height: 1.6; margin: 25px 0 0 0;">
                                We're excited to be part of your learning journey!<br><br>
                                Best regards,<br>
                                <strong style="color: #002060;">The Nebatech AI Academy Team</strong>
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
