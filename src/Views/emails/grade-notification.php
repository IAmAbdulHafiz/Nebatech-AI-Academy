<?php
$content = <<<HTML
<h2>Your Assignment Has Been Graded! 📝</h2>

<p>Hi {$first_name},</p>

<p>Great news! Your facilitator has reviewed and graded your assignment submission.</p>

<div class="success-box">
    <h3>Assignment Details</h3>
    <p><strong>Course:</strong> {$course_title}</p>
    <p><strong>Assignment:</strong> {$assignment_title}</p>
    <p style="margin: 0;"><strong>Grade:</strong> {$grade_level}</p>
</div>

<div class="stats-grid">
    <div class="stat-item">
        <div class="stat-value">{$score}</div>
        <div class="stat-label">Points Earned</div>
    </div>
    <div class="stat-item">
        <div class="stat-value">{$max_score}</div>
        <div class="stat-label">Total Points</div>
    </div>
    <div class="stat-item">
        <div class="stat-value">{$percentage}%</div>
        <div class="stat-label">Score</div>
    </div>
</div>

HTML;

if (!empty($facilitator_comments)) {
    $content .= <<<HTML
<div class="info-box">
    <h3>💬 Facilitator Feedback</h3>
    <p style="margin: 0; white-space: pre-wrap;">{$facilitator_comments}</p>
</div>
HTML;
}

$content .= <<<HTML

<p>You can view your detailed feedback, including strengths and areas for improvement, by clicking the button below.</p>

<div style="text-align: center;">
    <a href="{$feedback_url}" class="button">View Detailed Feedback</a>
</div>

<div class="divider"></div>

<p><strong>Keep Up the Great Work!</strong></p>
<p>Every assignment you complete brings you one step closer to mastering AI development. Continue learning, coding, and building amazing projects!</p>

<p>
    <strong>The Nebatech Team</strong>
</p>
HTML;

include __DIR__ . '/layout.php';
?>
