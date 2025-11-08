<?php
$content = <<<HTML
<h2>Password Reset Request 🔐</h2>

<p>Hi {$first_name},</p>

<p>We received a request to reset your password for your Nebatech AI Academy account.</p>

<div class="info-box">
    <h3>Reset Your Password</h3>
    <p style="margin: 0;">Click the button below to create a new password. This link will expire in <strong>{$expires_in}</strong>.</p>
</div>

<div style="text-align: center;">
    <a href="{$reset_url}" class="button">Reset Password</a>
</div>

<div class="warning-box">
    <h3>⚠️ Security Notice</h3>
    <p style="margin: 0;">If you didn't request a password reset, please ignore this email. Your password will remain unchanged.</p>
</div>

<p><strong>Tips for a Strong Password:</strong></p>

<ul style="color: #555; margin-left: 20px;">
    <li>Use at least 8 characters</li>
    <li>Include uppercase and lowercase letters</li>
    <li>Add numbers and special characters</li>
    <li>Avoid common words or personal information</li>
</ul>

<div class="divider"></div>

<p style="color: #6c757d; font-size: 13px;">
    <strong>Can't click the button?</strong><br>
    Copy and paste this link into your browser:<br>
    <span style="word-break: break-all;">{$reset_url}</span>
</p>

<p>
    <strong>The Nebatech Security Team</strong>
</p>
HTML;

include __DIR__ . '/layout.php';
?>
