<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $subject ?? 'Nebatech AI Academy' ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #333333;
            background-color: #f4f4f7;
        }
        
        .email-wrapper {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
        }
        
        .email-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 40px 30px;
            text-align: center;
        }
        
        .email-header h1 {
            color: #ffffff;
            font-size: 24px;
            margin-bottom: 10px;
        }
        
        .email-header p {
            color: #e0e7ff;
            font-size: 14px;
        }
        
        .email-body {
            padding: 40px 30px;
        }
        
        .email-content h2 {
            color: #667eea;
            font-size: 22px;
            margin-bottom: 20px;
        }
        
        .email-content p {
            margin-bottom: 15px;
            color: #555555;
        }
        
        .button {
            display: inline-block;
            padding: 14px 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            margin: 20px 0;
            transition: transform 0.2s;
        }
        
        .button:hover {
            transform: translateY(-2px);
        }
        
        .info-box {
            background-color: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 15px 20px;
            margin: 20px 0;
            border-radius: 4px;
        }
        
        .info-box h3 {
            color: #667eea;
            font-size: 16px;
            margin-bottom: 10px;
        }
        
        .success-box {
            background-color: #d4edda;
            border-left: 4px solid #28a745;
            padding: 15px 20px;
            margin: 20px 0;
            border-radius: 4px;
            color: #155724;
        }
        
        .warning-box {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px 20px;
            margin: 20px 0;
            border-radius: 4px;
            color: #856404;
        }
        
        .stats-grid {
            display: table;
            width: 100%;
            margin: 20px 0;
        }
        
        .stat-item {
            display: table-cell;
            text-align: center;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 8px;
        }
        
        .stat-item + .stat-item {
            padding-left: 20px;
        }
        
        .stat-value {
            font-size: 28px;
            font-weight: bold;
            color: #667eea;
        }
        
        .stat-label {
            font-size: 12px;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .email-footer {
            background-color: #f8f9fa;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e9ecef;
        }
        
        .email-footer p {
            color: #6c757d;
            font-size: 13px;
            margin-bottom: 10px;
        }
        
        .social-links {
            margin: 20px 0;
        }
        
        .social-links a {
            display: inline-block;
            margin: 0 10px;
            color: #667eea;
            text-decoration: none;
        }
        
        .divider {
            height: 1px;
            background-color: #e9ecef;
            margin: 30px 0;
        }
        
        @media only screen and (max-width: 600px) {
            .email-header,
            .email-body,
            .email-footer {
                padding: 20px !important;
            }
            
            .button {
                display: block;
                text-align: center;
            }
            
            .stat-item {
                display: block;
                margin-bottom: 15px;
            }
            
            .stat-item + .stat-item {
                padding-left: 15px;
            }
        }
    </style>
</head>
<body>
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f4f4f7; padding: 20px 0;">
        <tr>
            <td align="center">
                <div class="email-wrapper">
                    <!-- Header -->
                    <div class="email-header">
                        <h1>🎓 Nebatech AI Academy</h1>
                        <p>Empowering the Next Generation of AI Developers</p>
                    </div>
                    
                    <!-- Body -->
                    <div class="email-body">
                        <div class="email-content">
                            <?= $content ?? '' ?>
                        </div>
                    </div>
                    
                    <!-- Footer -->
                    <div class="email-footer">
                        <p><strong>Nebatech AI Academy</strong></p>
                        <p>Building Future AI Leaders</p>
                        
                        <div class="social-links">
                            <a href="#">Twitter</a> | 
                            <a href="#">LinkedIn</a> | 
                            <a href="#">GitHub</a>
                        </div>
                        
                        <p style="font-size: 11px; color: #999;">
                            You're receiving this email because you're a member of Nebatech AI Academy.<br>
                            <a href="<?= url('/settings/notifications') ?>" style="color: #667eea;">Manage email preferences</a>
                        </p>
                    </div>
                </div>
            </td>
        </tr>
    </table>
</body>
</html>
