<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Your Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .container {
            background-color: #f9f9f9;
            border-radius: 10px;
            padding: 30px;
            border: 1px solid #e0e0e0;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #ff6b35;
            margin: 0;
        }
        .content {
            background-color: white;
            padding: 25px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .button {
            display: inline-block;
            padding: 12px 30px;
            background-color: #ff6b35;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
            font-weight: bold;
        }
        .button:hover {
            background-color: #e55a2b;
        }
        .footer {
            text-align: center;
            color: #666;
            font-size: 12px;
            margin-top: 20px;
        }
        .token-box {
            background-color: #f5f5f5;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
            word-break: break-all;
            font-family: monospace;
            font-size: 12px;
        }
        .warning {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 12px;
            margin: 15px 0;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🍕 Rufars Food</h1>
        </div>
        
        <div class="content">
            <h2>Hello {{ $user->name }}!</h2>
            
            <p>You are receiving this email because we received a password reset request for your account.</p>
            
            <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 30px; border-radius: 10px; text-align: center; margin: 25px 0;">
                <p style="color: white; margin: 0 0 10px 0; font-size: 14px; font-weight: bold;">YOUR RESET TOKEN</p>
                <p style="color: white; font-size: 36px; font-weight: bold; letter-spacing: 4px; margin: 0; font-family: 'Courier New', monospace;">
                    {{ $resetToken }}
                </p>
                <p style="color: rgba(255,255,255,0.8); margin: 10px 0 0 0; font-size: 12px;">
                    Copy this 8-character token and enter it in the reset form
                </p>
            </div>
            
            <div style="background-color: #f8f9fa; padding: 20px; border-radius: 8px; border-left: 4px solid #ff6b35; margin: 20px 0;">
                <p style="margin: 0; font-size: 14px; color: #333;">
                    <strong>📱 For Mobile Users:</strong><br>
                    Copy the token above and enter it in the password reset form on the website.
                </p>
            </div>
            
            <p style="text-align: center; margin: 25px 0;">
                <a href="{{ $resetUrl }}" class="button">Or Click Here to Reset</a>
            </p>
            
            <details style="margin: 20px 0;">
                <summary style="cursor: pointer; color: #666; font-size: 13px;">Show full reset link</summary>
                <div class="token-box" style="margin-top: 10px;">
                    {{ $resetUrl }}
                </div>
            </details>
            
            <div class="warning">
                <strong>⚠️ Security Notice:</strong> This reset token will expire in 24 hours.
            </div>
            
            <p style="color: #666; font-size: 14px;">
                If you did not request a password reset, no further action is required. Your password will remain unchanged.
            </p>
        </div>
        
        <div class="footer">
            <p>&copy; {{ date('Y') }} Rufars Food. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
