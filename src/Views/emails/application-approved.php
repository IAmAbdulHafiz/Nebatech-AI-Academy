<?php
$content = <<<HTML
<h2>Application Approved! 🎉</h2>

<p>Hi {$first_name},</p>

<p>We're excited to inform you that your application to <strong>{$program}</strong> has been approved!</p>

<div class="success-box">
    <h3>✓ Welcome to Nebatech AI Academy!</h3>
    <p style="margin: 0;">You're now part of an elite community of aspiring AI developers and innovators.</p>
</div>

<p><strong>What Happens Next?</strong></p>

<ol style="color: #555; margin-left: 20px;">
    <li><strong>Access Your Dashboard:</strong> Log in to explore available courses</li>
    <li><strong>Enroll in Courses:</strong> Start with our foundational courses or jump into advanced topics</li>
    <li><strong>Meet Your Cohort:</strong> Connect with fellow students and facilitators</li>
    <li><strong>Begin Your Journey:</strong> Start learning and building amazing AI projects</li>
</ol>

<div style="text-align: center;">
    <a href="{$dashboard_url}" class="button">Go to Dashboard</a>
    <a href="{$courses_url}" class="button" style="background: #28a745;">Browse Courses</a>
</div>

<div class="divider"></div>

<div class="info-box">
    <h3>📚 What You'll Learn</h3>
    <ul style="margin: 10px 0 0 20px;">
        <li>AI & Machine Learning fundamentals</li>
        <li>Modern web development with AI integration</li>
        <li>Real-world project experience</li>
        <li>Industry best practices and tools</li>
    </ul>
</div>

<div class="info-box">
    <h3>🌟 Program Benefits</h3>
    <ul style="margin: 10px 0 0 20px;">
        <li>Expert facilitator guidance</li>
        <li>AI-powered code feedback</li>
        <li>Professional certificates</li>
        <li>Portfolio-ready projects</li>
    </ul>
</div>

<p><strong>We Can't Wait to See What You'll Build!</strong></p>

<p>Your journey to becoming an AI developer starts now. If you have any questions, our team is here to support you every step of the way.</p>

<p>
    <strong>The Nebatech Team</strong><br>
    <span style="color: #6c757d; font-size: 14px;">Welcome to the future of AI education</span>
</p>
HTML;

include __DIR__ . '/layout.php';
?>
