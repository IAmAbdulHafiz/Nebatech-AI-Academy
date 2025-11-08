<?php
$content = <<<HTML
<h2>Enrollment Confirmed! 🎓</h2>

<p>Hi {$first_name},</p>

<p>Congratulations! You've been successfully enrolled in <strong>{$course_title}</strong>.</p>

<div class="success-box">
    <h3>✓ You're All Set!</h3>
    <p style="margin: 0;">You now have full access to all course materials, assignments, and resources.</p>
</div>

<div class="info-box">
    <h3>About This Course</h3>
    <p style="margin: 0;">{$course_description}</p>
</div>

<p><strong>Ready to Begin?</strong></p>

<p>Here's what you can do now:</p>

<ul style="color: #555; margin-left: 20px;">
    <li>Explore the course curriculum and modules</li>
    <li>Watch video lessons at your own pace</li>
    <li>Complete interactive coding assignments</li>
    <li>Get AI-powered feedback on your work</li>
    <li>Build real-world projects for your portfolio</li>
</ul>

<div style="text-align: center;">
    <a href="{$course_url}" class="button">Start Learning Now</a>
    <a href="{$dashboard_url}" class="button" style="background: #6c757d;">View Dashboard</a>
</div>

<div class="divider"></div>

<p><strong>Tips for Success:</strong></p>

<div class="info-box">
    <p style="margin: 0;"><strong>⏰ Set aside dedicated time</strong> for learning each day</p>
</div>

<div class="info-box">
    <p style="margin: 0;"><strong>💪 Practice consistently</strong> - coding is a skill built through repetition</p>
</div>

<div class="info-box">
    <p style="margin: 0;"><strong>❓ Ask questions</strong> - your facilitators are here to help</p>
</div>

<p>We're excited to see what you'll build!</p>

<p>
    <strong>The Nebatech Team</strong>
</p>
HTML;

include __DIR__ . '/layout.php';
?>
