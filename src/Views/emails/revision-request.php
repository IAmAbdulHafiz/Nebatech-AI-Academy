<?php
$content = <<<HTML
<h2>Revision Requested for Your Assignment 🔄</h2>

<p>Hi {$first_name},</p>

<p>Your facilitator has reviewed your assignment and is requesting revisions before final approval.</p>

<div class="warning-box">
    <h3>Assignment Details</h3>
    <p><strong>Course:</strong> {$course_title}</p>
    <p style="margin: 0;"><strong>Assignment:</strong> {$assignment_title}</p>
</div>

<div class="info-box">
    <h3>📋 Revision Notes</h3>
    <p style="margin: 0; white-space: pre-wrap;">{$facilitator_comments}</p>
</div>

<p><strong>What You Should Do:</strong></p>

<ol style="color: #555; margin-left: 20px;">
    <li>Review the detailed feedback provided by your facilitator</li>
    <li>Make the necessary changes to your code</li>
    <li>Test your changes thoroughly</li>
    <li>Resubmit your assignment when ready</li>
</ol>

<div style="text-align: center;">
    <a href="{$feedback_url}" class="button">View Detailed Feedback</a>
    <a href="{$assignment_url}" class="button" style="background: #28a745;">Revise & Resubmit</a>
</div>

<div class="divider"></div>

<p><strong>Don't Get Discouraged!</strong></p>
<p>Revisions are a normal part of the learning process. They help you understand concepts more deeply and improve your coding skills. Your facilitator is here to help you succeed!</p>

<p>
    <strong>The Nebatech Team</strong>
</p>
HTML;

include __DIR__ . '/layout.php';
?>
