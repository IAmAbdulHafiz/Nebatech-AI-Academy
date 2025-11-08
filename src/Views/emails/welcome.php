<?php
$content = <<<HTML
<h2>Welcome to Nebatech AI Academy, {$first_name}! 🎉</h2>

<p>We're thrilled to have you join our community of aspiring AI developers and innovators. You've taken the first step towards mastering cutting-edge AI technologies!</p>

<div class="success-box">
    <h3>✓ Your Account is Ready</h3>
    <p style="margin: 0;"><strong>Email:</strong> {$email}</p>
</div>

<p><strong>What's Next?</strong></p>

<p>Here are some things you can do to get started:</p>

<div class="info-box">
    <h3>🎯 Explore Courses</h3>
    <p style="margin: 0;">Browse our comprehensive curriculum covering AI, machine learning, and web development.</p>
</div>

<div class="info-box">
    <h3>💻 Practice with Real Projects</h3>
    <p style="margin: 0;">Access our sandboxed coding environment to build and test your projects safely.</p>
</div>

<div class="info-box">
    <h3>🤖 AI-Powered Learning</h3>
    <p style="margin: 0;">Get instant feedback on your code from our AI teaching assistant.</p>
</div>

<div style="text-align: center;">
    <a href="{$dashboard_url}" class="button">Go to Dashboard</a>
    <a href="{$courses_url}" class="button" style="background: #28a745;">Browse Courses</a>
</div>

<div class="divider"></div>

<p><strong>Need Help?</strong></p>
<p>If you have any questions or need assistance, our support team is here to help. Reply to this email or visit our help center.</p>

<p>Happy learning!</p>

<p>
    <strong>The Nebatech Team</strong><br>
    <span style="color: #6c757d; font-size: 14px;">Building the future, one line of code at a time</span>
</p>
HTML;

include __DIR__ . '/layout.php';
?>
