<?php
$content = <<<HTML
<h2>You're Invited to Join a Cohort! 🎓</h2>

<p>Hi {$first_name},</p>

<p>You've been invited to join an exclusive learning cohort at Nebatech AI Academy!</p>

<div class="success-box">
    <h3>📚 Cohort: {$cohort_name}</h3>
    <p style="margin: 10px 0;">{$cohort_description}</p>
</div>

<p><strong>What you'll get:</strong></p>

<div class="info-box">
    <h3>🎯 Structured Learning Path</h3>
    <p style="margin: 0;">Follow a curated curriculum with courses hand-picked by your facilitator.</p>
</div>

<div class="info-box">
    <h3>👥 Community Support</h3>
    <p style="margin: 0;">Learn alongside other students in your cohort with peer support.</p>
</div>

<div class="info-box">
    <h3>👨‍🏫 Expert Guidance</h3>
    <p style="margin: 0;">Receive personalized feedback from experienced facilitators.</p>
</div>

<div style="text-align: center; margin: 30px 0;">
    <a href="{$accept_url}" class="button" style="background: #28a745; font-size: 18px; padding: 15px 40px;">Accept Invitation</a>
</div>

<p style="text-align: center; color: #6c757d; font-size: 14px;">
    Don't want to join? <a href="{$decline_url}" style="color: #dc3545;">Decline this invitation</a>
</p>

<div class="divider"></div>

<p style="color: #6c757d; font-size: 14px;">
    <strong>⏰ This invitation expires in {$expires_in}.</strong><br>
    If you have any questions, please contact the cohort facilitator or our support team.
</p>

<p>
    <strong>The Nebatech Team</strong><br>
    <span style="color: #6c757d; font-size: 14px;">Building the future, one line of code at a time</span>
</p>
HTML;

include __DIR__ . '/layout.php';
?>
