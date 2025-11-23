<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cohort Assignment</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f3f4f6;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f3f4f6; padding: 40px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #8B5CF6 0%, #7C3AED 100%); padding: 40px 30px; text-align: center;">
                            <div style="font-size: 60px; margin-bottom: 10px;">👥</div>
                            <h1 style="margin: 0; color: #ffffff; font-size: 28px; font-weight: 700;">You've Been Assigned to a Cohort!</h1>
                        </td>
                    </tr>
                    
                    <!-- Content -->
                    <tr>
                        <td style="padding: 40px 30px;">
                            <p style="color: #374151; font-size: 16px; line-height: 1.6; margin: 0 0 15px 0;">Dear <strong><?= htmlspecialchars($name) ?></strong>,</p>
                            
                            <p style="color: #374151; font-size: 16px; line-height: 1.6; margin: 0 0 15px 0;">
                                Great news! You've been assigned to a learning cohort for your <strong style="color: #002060;"><?= htmlspecialchars($program) ?></strong> program.
                            </p>
                            
                            <p style="color: #374151; font-size: 16px; line-height: 1.6; margin: 0 0 25px 0;">
                                Learning in a cohort means you'll have a dedicated group of peers and a facilitator to guide you through your journey. This collaborative environment will enhance your learning experience!
                            </p>
                            
                            <!-- Cohort Details Box -->
                            <div style="background: linear-gradient(135deg, #002060 0%, #003080 100%); padding: 30px; margin: 25px 0; border-radius: 8px;">
                                <h3 style="margin: 0 0 20px 0; color: #FFA500; font-size: 18px; text-align: center;">📚 Your Cohort Details</h3>
                                
                                <div style="background-color: rgba(255, 255, 255, 0.1); padding: 20px; border-radius: 6px;">
                                    <table width="100%" cellpadding="8" cellspacing="0">
                                        <tr>
                                            <td style="color: #FFA500; font-weight: 600; font-size: 14px; width: 40%;">Cohort Name:</td>
                                            <td style="color: #ffffff; font-size: 16px;"><?= htmlspecialchars($cohort_name) ?></td>
                                        </tr>
                                        <tr>
                                            <td style="color: #FFA500; font-weight: 600; font-size: 14px;">Program:</td>
                                            <td style="color: #ffffff; font-size: 16px;"><?= htmlspecialchars($program) ?></td>
                                        </tr>
                                        <tr>
                                            <td style="color: #FFA500; font-weight: 600; font-size: 14px;">Start Date:</td>
                                            <td style="color: #ffffff; font-size: 16px;"><?= htmlspecialchars($start_date) ?></td>
                                        </tr>
                                        <tr>
                                            <td style="color: #FFA500; font-weight: 600; font-size: 14px;">Your Facilitator:</td>
                                            <td style="color: #ffffff; font-size: 16px;"><?= htmlspecialchars($facilitator_name) ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            
                            <h3 style="color: #002060; font-size: 20px; margin: 30px 0 15px 0;">🎯 What This Means for You</h3>
                            
                            <div style="background-color: #F9FAFB; padding: 20px; border-radius: 8px; margin-bottom: 20px;">
                                <div style="margin-bottom: 15px;">
                                    <div style="display: flex; align-items: start;">
                                        <div style="color: #10B981; font-size: 24px; margin-right: 15px;">✓</div>
                                        <div>
                                            <strong style="color: #002060; font-size: 15px;">Structured Learning Path</strong>
                                            <p style="margin: 5px 0 0 0; color: #6B7280; font-size: 14px;">Follow a carefully designed curriculum with your cohort</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div style="margin-bottom: 15px;">
                                    <div style="display: flex; align-items: start;">
                                        <div style="color: #10B981; font-size: 24px; margin-right: 15px;">✓</div>
                                        <div>
                                            <strong style="color: #002060; font-size: 15px;">Dedicated Facilitator Support</strong>
                                            <p style="margin: 5px 0 0 0; color: #6B7280; font-size: 14px;">Get personalized guidance from <?= htmlspecialchars($facilitator_name) ?></p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div style="margin-bottom: 15px;">
                                    <div style="display: flex; align-items: start;">
                                        <div style="color: #10B981; font-size: 24px; margin-right: 15px;">✓</div>
                                        <div>
                                            <strong style="color: #002060; font-size: 15px;">Peer Collaboration</strong>
                                            <p style="margin: 5px 0 0 0; color: #6B7280; font-size: 14px;">Learn together, share knowledge, and build connections</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div>
                                    <div style="display: flex; align-items: start;">
                                        <div style="color: #10B981; font-size: 24px; margin-right: 15px;">✓</div>
                                        <div>
                                            <strong style="color: #002060; font-size: 15px;">Scheduled Sessions</strong>
                                            <p style="margin: 5px 0 0 0; color: #6B7280; font-size: 14px;">Participate in live sessions and group activities</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Next Steps Box -->
                            <div style="background-color: #DBEAFE; border-left: 4px solid #3B82F6; padding: 20px; margin: 25px 0; border-radius: 6px;">
                                <p style="margin: 0 0 10px 0; color: #1E40AF; font-weight: 600; font-size: 14px;">📅 NEXT STEPS</p>
                                <ol style="margin: 10px 0 0 0; padding-left: 20px; color: #1E3A8A; font-size: 14px; line-height: 1.8;">
                                    <li>Check your dashboard for cohort details and schedule</li>
                                    <li>Introduce yourself to your cohort members</li>
                                    <li>Mark your calendar for the start date</li>
                                    <li>Prepare any required materials or software</li>
                                    <li>Join the cohort communication channel</li>
                                </ol>
                            </div>
                            
                            <div style="text-align: center; margin: 30px 0;">
                                <a href="<?= htmlspecialchars($dashboard_url) ?>" style="display: inline-block; background-color: #FFA500; color: #ffffff; padding: 14px 32px; text-decoration: none; border-radius: 6px; font-weight: 600; font-size: 16px;">
                                    View Cohort Details
                                </a>
                            </div>
                            
                            <!-- Tips Box -->
                            <div style="background-color: #FEF3C7; border-left: 4px solid #FFA500; padding: 20px; margin: 25px 0; border-radius: 6px;">
                                <p style="margin: 0 0 10px 0; color: #92400E; font-weight: 600; font-size: 14px;">💡 PRO TIPS FOR SUCCESS</p>
                                <ul style="margin: 10px 0 0 0; padding-left: 20px; color: #78350F; font-size: 14px; line-height: 1.8;">
                                    <li>Attend all scheduled cohort sessions</li>
                                    <li>Actively participate in discussions</li>
                                    <li>Help your peers when they're stuck</li>
                                    <li>Don't hesitate to ask questions</li>
                                    <li>Share your projects and get feedback</li>
                                </ul>
                            </div>
                            
                            <p style="color: #374151; font-size: 16px; line-height: 1.6; margin: 0 0 15px 0;">
                                We're excited to see you grow and succeed with your cohort. Remember, learning together makes everyone stronger!
                            </p>
                            
                            <p style="color: #374151; font-size: 16px; line-height: 1.6; margin: 25px 0 0 0;">
                                See you in the cohort!<br><br>
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
