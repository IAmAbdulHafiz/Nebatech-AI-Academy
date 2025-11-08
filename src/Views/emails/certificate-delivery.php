<?php
$content = <<<HTML
<h2>Your Certificate is Ready! 🏆</h2>

<p>Hi {$first_name},</p>

<p>Congratulations on completing <strong>{$course_title}</strong>! We're proud of your hard work and dedication.</p>

<div class="success-box">
    <h3>✓ Certificate of Completion</h3>
    <p style="margin: 0;">Your official certificate is attached to this email and has been added to your portfolio.</p>
</div>

<div class="stats-grid">
    <div class="stat-item">
        <div class="stat-value">✓</div>
        <div class="stat-label">Course Completed</div>
    </div>
    <div class="stat-item">
        <div class="stat-value">🏆</div>
        <div class="stat-label">Certificate Earned</div>
    </div>
    <div class="stat-item">
        <div class="stat-value">⭐</div>
        <div class="stat-label">Badge Unlocked</div>
    </div>
</div>

<p><strong>What You Can Do Now:</strong></p>

<div class="info-box">
    <h3>📁 Add to Your Portfolio</h3>
    <p style="margin: 0;">Your certificate and course projects are now visible on your public portfolio. Share it with potential employers!</p>
</div>

<div class="info-box">
    <h3>🔗 Share Your Achievement</h3>
    <p style="margin: 0;">Show off your accomplishment on LinkedIn, Twitter, and other social platforms.</p>
</div>

<div class="info-box">
    <h3>📚 Continue Learning</h3>
    <p style="margin: 0;">Explore our other courses to expand your skills and earn more certificates.</p>
</div>

<div style="text-align: center;">
    <a href="{$portfolio_url}" class="button">View Your Portfolio</a>
    <a href="{$dashboard_url}" class="button" style="background: #28a745;">Explore More Courses</a>
</div>

<div class="divider"></div>

<p><strong>You're Building Something Amazing!</strong></p>

<p>Each certificate you earn represents real skills that employers value. Keep learning, keep building, and keep growing your career in AI development.</p>

<p>We can't wait to see what you accomplish next!</p>

<p>
    <strong>The Nebatech Team</strong><br>
    <span style="color: #6c757d; font-size: 14px;">Celebrating your success!</span>
</p>
HTML;

include __DIR__ . '/layout.php';
?>
