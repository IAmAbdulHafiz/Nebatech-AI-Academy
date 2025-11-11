<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Nebatech AI Academy</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f3f4f6;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f3f4f6; padding: 40px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #002060 0%, #003080 100%); padding: 40px 30px; text-align: center;">
                            <div style="font-size: 60px; margin-bottom: 10px;">🚀</div>
                            <h1 style="margin: 0; color: #ffffff; font-size: 32px; font-weight: 700;">Welcome to Nebatech!</h1>
                            <p style="margin: 10px 0 0 0; color: #FFA500; font-size: 16px; font-weight: 500;">Your Learning Journey Starts Now</p>
                        </td>
                    </tr>
                    
                    <!-- Content -->
                    <tr>
                        <td style="padding: 40px 30px;">
                            <p style="color: #374151; font-size: 16px; line-height: 1.6; margin: 0 0 15px 0;">Dear <strong><?= htmlspecialchars($name) ?></strong>,</p>
                            
                            <p style="color: #374151; font-size: 18px; line-height: 1.6; margin: 0 0 15px 0; font-weight: 600; color: #002060;">
                                Welcome to Nebatech AI Academy! We're thrilled to have you join our learning community. 🎉
                            </p>
                            
                            <p style="color: #374151; font-size: 16px; line-height: 1.6; margin: 0 0 25px 0;">
                                You're now enrolled in <strong style="color: #002060;"><?= htmlspecialchars($course_name) ?></strong>, and we can't wait to see what you'll build!
                            </p>
                            
                            <!-- Course Access Box -->
                            <div style="background: linear-gradient(135deg, #10B981 0%, #059669 100%); padding: 30px; margin: 25px 0; border-radius: 8px; text-align: center;">
                                <h3 style="margin: 0 0 15px 0; color: #ffffff; font-size: 20px;">🎓 Your Course is Ready!</h3>
                                <p style="margin: 0 0 20px 0; color: #ffffff; font-size: 14px;">
                                    Access your learning materials, projects, and assignments now
                                </p>
                                <a href="<?= htmlspecialchars($course_url) ?>" style="display: inline-block; background-color: #FFA500; color: #ffffff; padding: 14px 32px; text-decoration: none; border-radius: 6px; font-weight: 600; font-size: 16px;">
                                    Start Learning Now
                                </a>
                            </div>
                            
                            <?php if (isset($cohort) && $cohort): ?>
                            <!-- Cohort Information -->
                            <div style="background-color: #DBEAFE; border-left: 4px solid #3B82F6; padding: 20px; margin: 25px 0; border-radius: 6px;">
                                <p style="margin: 0 0 10px 0; color: #1E40AF; font-weight: 600; font-size: 14px;">👥 YOUR LEARNING COHORT</p>
                                <p style="margin: 0; color: #1E3A8A; font-size: 14px;">
                                    <strong>Cohort:</strong> <?= htmlspecialchars($cohort['name']) ?><br>
                                    <strong>Start Date:</strong> <?= date('F d, Y', strtotime($cohort['start_date'])) ?><br>
                                    <?php if (isset($cohort['facilitator_name'])): ?>
                                    <strong>Facilitator:</strong> <?= htmlspecialchars($cohort['facilitator_name']) ?>
                                    <?php endif; ?>
                                </p>
                            </div>
                            <?php endif; ?>
                            
                            <h3 style="color: #002060; font-size: 20px; margin: 30px 0 15px 0;">🎯 Quick Start Guide</h3>
                            
                            <div style="background-color: #F9FAFB; padding: 20px; border-radius: 8px; margin-bottom: 20px;">
                                <table width="100%" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td style="padding: 10px 0; border-bottom: 1px solid #E5E7EB;">
                                            <div style="display: flex; align-items: start;">
                                                <div style="background-color: #002060; color: white; width: 30px; height: 30px; border-radius: 50%; text-align: center; line-height: 30px; font-weight: bold; margin-right: 15px;">1</div>
                                                <div>
                                                    <strong style="color: #002060; font-size: 15px;">Complete Your Profile</strong>
                                                    <p style="margin: 5px 0 0 0; color: #6B7280; font-size: 14px;">Add your photo and preferences</p>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 10px 0; border-bottom: 1px solid #E5E7EB;">
                                            <div style="display: flex; align-items: start;">
                                                <div style="background-color: #002060; color: white; width: 30px; height: 30px; border-radius: 50%; text-align: center; line-height: 30px; font-weight: bold; margin-right: 15px;">2</div>
                                                <div>
                                                    <strong style="color: #002060; font-size: 15px;">Explore Your Dashboard</strong>
                                                    <p style="margin: 5px 0 0 0; color: #6B7280; font-size: 14px;">Familiarize yourself with the platform</p>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 10px 0; border-bottom: 1px solid #E5E7EB;">
                                            <div style="display: flex; align-items: start;">
                                                <div style="background-color: #002060; color: white; width: 30px; height: 30px; border-radius: 50%; text-align: center; line-height: 30px; font-weight: bold; margin-right: 15px;">3</div>
                                                <div>
                                                    <strong style="color: #002060; font-size: 15px;">Start Your First Lesson</strong>
                                                    <p style="margin: 5px 0 0 0; color: #6B7280; font-size: 14px;">Begin with Module 1 and follow the path</p>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 10px 0;">
                                            <div style="display: flex; align-items: start;">
                                                <div style="background-color: #002060; color: white; width: 30px; height: 30px; border-radius: 50%; text-align: center; line-height: 30px; font-weight: bold; margin-right: 15px;">4</div>
                                                <div>
                                                    <strong style="color: #002060; font-size: 15px;">Join the Community</strong>
                                                    <p style="margin: 5px 0 0 0; color: #6B7280; font-size: 14px;">Connect with peers and facilitators</p>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            
                            <!-- Features Box -->
                            <div style="background-color: #FEF3C7; border-left: 4px solid #FFA500; padding: 20px; margin: 25px 0; border-radius: 6px;">
                                <p style="margin: 0 0 10px 0; color: #92400E; font-weight: 600; font-size: 14px;">✨ PLATFORM FEATURES</p>
                                <ul style="margin: 10px 0 0 0; padding-left: 20px; color: #78350F; font-size: 14px; line-height: 1.8;">
                                    <li><strong>AI-Powered Learning:</strong> Personalized content and feedback</li>
                                    <li><strong>Hands-On Projects:</strong> Build real-world applications</li>
                                    <li><strong>Code Playground:</strong> Practice coding in your browser</li>
                                    <li><strong>Live Support:</strong> Get help from facilitators and peers</li>
                                    <li><strong>Digital Portfolio:</strong> Showcase your work</li>
                                    <li><strong>Certificates:</strong> Earn verified credentials</li>
                                </ul>
                            </div>
                            
                            <div style="text-align: center; margin: 30px 0;">
                                <a href="<?= htmlspecialchars($dashboard_url) ?>" style="display: inline-block; background-color: #002060; color: #ffffff; padding: 14px 32px; text-decoration: none; border-radius: 6px; font-weight: 600; font-size: 16px;">
                                    Go to Dashboard
                                </a>
                            </div>
                            
                            <p style="color: #374151; font-size: 16px; line-height: 1.6; margin: 0 0 15px 0;">
                                <strong>Need Help?</strong><br>
                                Our support team is here for you at <a href="mailto:<?= htmlspecialchars($support_email) ?>" style="color: #FFA500; text-decoration: none;"><?= htmlspecialchars($support_email) ?></a>
                            </p>
                            
                            <p style="color: #374151; font-size: 16px; line-height: 1.6; margin: 25px 0 0 0;">
                                Let's make this learning journey amazing together!<br><br>
                                Happy Learning! 🎓<br>
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
