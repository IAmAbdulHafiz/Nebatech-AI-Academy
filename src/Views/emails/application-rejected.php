<?php
$content = <<<HTML
<h2>Application Status Update</h2>

<p>Hi {$first_name},</p>

<p>Thank you for your interest in <strong>{$program}</strong> at Nebatech AI Academy.</p>

<div class="warning-box">
    <p style="margin: 0;">After careful consideration, we're unable to offer you admission to the program at this time.</p>
</div>

HTML;

if (!empty($rejection_reason)) {
    $content .= <<<HTML
<div class="info-box">
    <h3>Feedback</h3>
    <p style="margin: 0; white-space: pre-wrap;">{$rejection_reason}</p>
</div>
HTML;
}

$content .= <<<HTML

<p><strong>Don't Be Discouraged!</strong></p>

<p>This decision doesn't reflect on your potential as a developer. We encourage you to:</p>

<ul style="color: #555; margin-left: 20px;">
    <li>Continue building your skills through online resources and practice</li>
    <li>Work on personal projects to strengthen your portfolio</li>
    <li>Reapply when you feel ready (we welcome future applications)</li>
</ul>

<div class="info-box">
    <h3>📚 Free Learning Resources</h3>
    <p style="margin: 0;">While you're not enrolled in the full program, we encourage you to explore free learning resources available online to continue your development journey.</p>
</div>

<p><strong>Alternative Learning Paths:</strong></p>

<ul style="color: #555; margin-left: 20px;">
    <li>FreeCodeCamp - Web Development Certification</li>
    <li>Coursera - AI & Machine Learning Courses</li>
    <li>YouTube - Programming Tutorials</li>
    <li>GitHub - Open Source Projects</li>
</ul>

<div class="divider"></div>

<p>Thank you again for your interest in Nebatech AI Academy. We wish you the best in your learning journey and hope to see you apply again in the future.</p>

<p>
    <strong>The Nebatech Admissions Team</strong>
</p>
HTML;

include __DIR__ . '/layout.php';
?>
