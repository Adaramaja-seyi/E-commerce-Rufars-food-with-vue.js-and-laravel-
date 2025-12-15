# Email Setup Guide

## Current Status
✅ Email templates created
✅ Mail classes implemented
✅ AuthController updated to send emails
⚠️ SMTP configuration needed

## Setup Instructions

### Option 1: Gmail (Recommended for Testing)

1. **Enable 2-Factor Authentication on your Gmail account**
   - Go to https://myaccount.google.com/security
   - Enable 2-Step Verification

2. **Generate App Password**
   - Go to https://myaccount.google.com/apppasswords
   - Select "Mail" and "Other (Custom name)"
   - Name it "Rufars Food App"
   - Copy the 16-character password

3. **Update `.env` file**
   ```env
   MAIL_MAILER=smtp
   MAIL_HOST=smtp.gmail.com
   MAIL_PORT=587
   MAIL_USERNAME=your-email@gmail.com
   MAIL_PASSWORD=your-16-char-app-password
   MAIL_ENCRYPTION=tls
   MAIL_FROM_ADDRESS="your-email@gmail.com"
   MAIL_FROM_NAME="Rufars Food"
   ```

4. **Restart Laravel server**
   ```bash
   php artisan config:clear
   php artisan cache:clear
   ```

### Option 2: Mailtrap (Best for Development)

1. **Sign up at https://mailtrap.io** (Free)

2. **Get SMTP credentials from your inbox**

3. **Update `.env` file**
   ```env
   MAIL_MAILER=smtp
   MAIL_HOST=sandbox.smtp.mailtrap.io
   MAIL_PORT=2525
   MAIL_USERNAME=your-mailtrap-username
   MAIL_PASSWORD=your-mailtrap-password
   MAIL_ENCRYPTION=tls
   MAIL_FROM_ADDRESS="noreply@rufarsfood.com"
   MAIL_FROM_NAME="Rufars Food"
   ```

### Option 3: SendGrid (Production Ready)

1. **Sign up at https://sendgrid.com** (Free tier: 100 emails/day)

2. **Create API Key**

3. **Update `.env` file**
   ```env
   MAIL_MAILER=smtp
   MAIL_HOST=smtp.sendgrid.net
   MAIL_PORT=587
   MAIL_USERNAME=apikey
   MAIL_PASSWORD=your-sendgrid-api-key
   MAIL_ENCRYPTION=tls
   MAIL_FROM_ADDRESS="noreply@rufarsfood.com"
   MAIL_FROM_NAME="Rufars Food"
   ```

### Option 4: Keep Testing Mode (Current)

If you want to continue testing without real emails:
```env
MAIL_MAILER=log
```
Emails will be logged to `storage/logs/laravel.log`

## Email Features Implemented

### 1. Email Verification
- Sent on user registration
- Contains verification link
- Beautiful HTML template with branding

### 2. Password Reset
- Sent when user requests password reset
- Contains reset link with token
- Expires in 24 hours
- Security warning included

## Testing

### Test Email Verification
1. Register a new user
2. Check your email inbox
3. Click the verification link
4. User should be verified

### Test Password Reset
1. Click "Forgot Password" on login page
2. Enter your email
3. Check your email inbox
4. Click the reset link
5. Enter new password

## Troubleshooting

### Emails not sending?
1. Check `.env` configuration
2. Clear config cache: `php artisan config:clear`
3. Check Laravel logs: `storage/logs/laravel.log`
4. Verify SMTP credentials are correct

### Gmail blocking emails?
- Make sure 2FA is enabled
- Use App Password, not regular password
- Check "Less secure app access" is OFF (use App Password instead)

### Emails going to spam?
- Use a verified domain email address
- Consider using a professional email service (SendGrid, Mailgun)
- Add SPF and DKIM records to your domain

## Production Recommendations

1. **Use a professional email service** (SendGrid, Mailgun, AWS SES)
2. **Remove testing tokens** from API responses
3. **Set up email queues** for better performance
4. **Add email templates** for order confirmations
5. **Implement email preferences** for users

## Current Implementation

✅ Verification emails sent on registration
✅ Password reset emails sent on request
✅ Resend verification email functionality
✅ Beautiful HTML email templates
✅ Error handling with logging
✅ Frontend URL configuration

## Next Steps

1. Update `.env` with your SMTP credentials
2. Test email sending
3. Remove `verification_token` and `reset_token` from API responses in production
4. Consider implementing email queues for better performance
