# Email Not Sending - Fix Guide

## ✅ What's Fixed
- Loading state now shows on "Send Reset Link" button
- Email system is fully implemented
- Beautiful email templates created

## ⚠️ Why Emails Aren't Being Received

Your `.env` file has **placeholder values** that need to be replaced with real credentials:

```env
MAIL_USERNAME=your-email@gmail.com    ← CHANGE THIS
MAIL_PASSWORD=your-app-password       ← CHANGE THIS
MAIL_FROM_ADDRESS="your-email@gmail.com"  ← CHANGE THIS
```

## 🚀 Quick Fix (Choose One Method)

### Method 1: Gmail (5 Minutes) ⭐ RECOMMENDED

#### Step 1: Get Gmail App Password
1. Go to your Google Account: https://myaccount.google.com
2. Click **Security** (left sidebar)
3. Enable **2-Step Verification** if not already enabled
4. Go back to Security
5. Click **App passwords** (search for it if you don't see it)
6. Select:
   - App: **Mail**
   - Device: **Other (Custom name)** → Type "Rufars Food"
7. Click **Generate**
8. **Copy the 16-character password** (looks like: `abcd efgh ijkl mnop`)

#### Step 2: Update `.env` File
Open `Sever/.env` and replace these lines:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-actual-email@gmail.com
MAIL_PASSWORD=abcdefghijklmnop
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="your-actual-email@gmail.com"
MAIL_FROM_NAME="Rufars Food"
```

**Important:** 
- Remove spaces from the app password (use: `abcdefghijklmnop` not `abcd efgh ijkl mnop`)
- Use your real Gmail address
- Don't use quotes around the password

#### Step 3: Clear Cache & Restart
```bash
cd Sever
php artisan config:clear
php artisan cache:clear
```

Then restart your Laravel server.

---

### Method 2: Mailtrap (Testing Only) 🧪

Perfect for testing without sending real emails!

1. **Sign up:** https://mailtrap.io (Free)
2. **Get credentials** from your inbox
3. **Update `.env`:**
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
4. **Clear cache:**
   ```bash
   cd Sever
   php artisan config:clear
   ```

All emails will appear in your Mailtrap inbox (not real inboxes).

---

## 🧪 Test Email Sending

### Option 1: Test via Registration
1. Register a new user with your email
2. Check your inbox for verification email
3. Should arrive within seconds

### Option 2: Test via Forgot Password
1. Go to login page
2. Click "Forgot password?"
3. Enter your email
4. Check inbox for reset link

### Option 3: Test via Artisan Command (Advanced)

Create a test command:
```bash
cd Sever
php artisan tinker
```

Then run:
```php
Mail::raw('Test email from Rufars Food', function($message) {
    $message->to('your-email@gmail.com')
            ->subject('Test Email');
});
```

---

## 🔍 Troubleshooting

### Emails Still Not Arriving?

#### 1. Check Laravel Logs
```bash
tail -f Sever/storage/logs/laravel.log
```

Look for email-related errors.

#### 2. Verify Config is Loaded
```bash
cd Sever
php artisan config:clear
php artisan config:cache
```

#### 3. Check Gmail Settings
- 2-Step Verification must be enabled
- Use App Password, NOT your regular Gmail password
- Check "Less secure app access" is OFF

#### 4. Check Spam Folder
Gmail might filter emails to spam initially.

#### 5. Test SMTP Connection
```bash
cd Sever
php artisan tinker
```

```php
try {
    Mail::raw('Test', function($msg) {
        $msg->to('test@example.com')->subject('Test');
    });
    echo "Email sent successfully!";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
```

---

## 📧 What Emails Are Sent?

1. **Email Verification** - Sent on registration
2. **Password Reset** - Sent when user clicks "Forgot password?"
3. **Resend Verification** - When user clicks resend button

---

## ✅ Current Status

- ✅ Email templates created (beautiful HTML)
- ✅ Mail classes implemented
- ✅ AuthController sends emails
- ✅ Loading states added
- ⚠️ **SMTP credentials need to be configured**

---

## 🎯 Next Steps

1. **Choose a method** (Gmail or Mailtrap)
2. **Update `.env`** with real credentials
3. **Clear cache:** `php artisan config:clear`
4. **Test** by registering a new user
5. **Check inbox** (or spam folder)

---

## 💡 Pro Tips

- **For Development:** Use Mailtrap (no real emails sent)
- **For Production:** Use SendGrid, Mailgun, or AWS SES
- **For Quick Testing:** Use Gmail with App Password
- **Remove Testing Tokens:** In production, remove `verification_token` and `reset_token` from API responses

---

## 🆘 Still Having Issues?

Check these common mistakes:

❌ Using regular Gmail password instead of App Password
❌ Not enabling 2-Step Verification
❌ Spaces in the app password
❌ Not clearing config cache
❌ Wrong email address in MAIL_USERNAME
❌ Quotes around password in .env file

✅ Use App Password (16 characters, no spaces)
✅ Enable 2-Step Verification first
✅ Clear cache after changing .env
✅ Use your actual Gmail address
✅ No quotes around password
