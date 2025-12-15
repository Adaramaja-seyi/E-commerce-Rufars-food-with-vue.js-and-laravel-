# Quick Email Setup - Choose Your Method

## 🚀 FASTEST: Gmail (5 minutes)

1. **Get App Password:**
   - Go to: https://myaccount.google.com/apppasswords
   - Create password for "Mail"
   - Copy the 16-character code

2. **Update `Sever/.env`:**
   ```env
   MAIL_MAILER=smtp
   MAIL_HOST=smtp.gmail.com
   MAIL_PORT=587
   MAIL_USERNAME=your-email@gmail.com
   MAIL_PASSWORD=xxxx-xxxx-xxxx-xxxx
   MAIL_ENCRYPTION=tls
   MAIL_FROM_ADDRESS="your-email@gmail.com"
   MAIL_FROM_NAME="Rufars Food"
   ```

3. **Restart server:**
   ```bash
   cd Sever
   php artisan config:clear
   ```

## 🧪 BEST FOR TESTING: Mailtrap (3 minutes)

1. **Sign up:** https://mailtrap.io (Free)
2. **Copy credentials** from your inbox
3. **Update `Sever/.env`:**
   ```env
   MAIL_MAILER=smtp
   MAIL_HOST=sandbox.smtp.mailtrap.io
   MAIL_PORT=2525
   MAIL_USERNAME=your-username
   MAIL_PASSWORD=your-password
   MAIL_ENCRYPTION=tls
   MAIL_FROM_ADDRESS="noreply@rufarsfood.com"
   MAIL_FROM_NAME="Rufars Food"
   ```

## ✅ What's Already Done

- ✅ Email templates created (beautiful HTML)
- ✅ Verification emails configured
- ✅ Password reset emails configured
- ✅ Error handling implemented
- ✅ Logging enabled

## 🎯 What You Need to Do

**Just update these 5 lines in `Sever/.env`:**
```env
MAIL_MAILER=smtp          # Change from 'log' to 'smtp'
MAIL_HOST=                # Your SMTP host
MAIL_USERNAME=            # Your email/username
MAIL_PASSWORD=            # Your password/app password
MAIL_FROM_ADDRESS=        # Your from email
```

Then restart: `php artisan config:clear`

## 🧪 Test It

1. Register a new user → Check email
2. Request password reset → Check email
3. Both should arrive within seconds!

## ⚠️ Current Status

Right now emails are being **logged** to `storage/logs/laravel.log` instead of sent.
Once you update the `.env` file, real emails will be sent!
