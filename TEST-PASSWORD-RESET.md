# 🧪 Test Password Reset with Token

## Quick Test Guide

### Prerequisites
✅ Laravel server running: `php artisan serve`
✅ Vue app running: `npm run dev`
✅ Email configured in `.env`

### Test Steps

#### 1. Go to Login Page
```
http://localhost:5173/login
```

#### 2. Click "Forgot password?"
- Button is below the password field

#### 3. Enter Email
```
oluwaseyiadaramaja@gmail.com
```
(or any registered email)

#### 4. Click "Send Reset Token"
- Button shows "Sending..." while processing
- Success message appears

#### 5. Check Your Email
Look for email with subject: **"Reset Your Password"**

You'll see a large purple box with an 8-character token like:
```
┌─────────────────────────────┐
│  YOUR RESET TOKEN           │
│                             │
│      ABC12345               │
│                             │
└─────────────────────────────┘
```

#### 6. Copy the Token
- Copy the 8 characters (e.g., `ABC12345`)
- The token modal should appear automatically

#### 7. Enter Token in Modal
- Paste or type the 8-character token
- It will auto-convert to uppercase
- Enter new password (min 6 characters)
- Confirm password

#### 8. Click "Reset Password"
- Button shows "Resetting..." while processing
- Success message: "Password reset successfully!"
- Modal closes automatically

#### 9. Login with New Password
- Use the new password you just set
- Should login successfully

## 🎯 Expected Behavior

### Email Modal
- ✅ Opens when clicking "Forgot password?"
- ✅ Has email input field
- ✅ "Send Reset Token" button
- ✅ Shows loading state while sending
- ✅ Shows success message when sent

### Token Modal
- ✅ Appears automatically after email sent
- ✅ Has token input (8 characters, uppercase, monospace)
- ✅ Has new password field
- ✅ Has confirm password field
- ✅ "Reset Password" button
- ✅ Shows loading state while resetting
- ✅ Validates passwords match
- ✅ Validates password length (min 6)

### Email
- ✅ Arrives within seconds
- ✅ Shows 8-character token prominently
- ✅ Has purple gradient background
- ✅ Easy to read on mobile
- ✅ Includes instructions
- ✅ Has backup link (collapsible)

## 🐛 Troubleshooting

### Email Not Arriving?
1. Check spam folder
2. Verify `.env` MAIL settings
3. Run: `php artisan config:clear`
4. Check `storage/logs/laravel.log` for errors

### Token Not Working?
1. Make sure you copied all 8 characters
2. Token is case-insensitive (auto-uppercase)
3. Check if token expired (24 hours)
4. Try requesting a new token

### Modal Not Appearing?
1. Check browser console for errors
2. Make sure email was sent successfully
3. Try refreshing the page

### Password Not Resetting?
1. Ensure passwords match
2. Password must be at least 6 characters
3. Check network tab for API errors
4. Verify token is correct

## 📱 Mobile Testing

### On Mobile Device:
1. Open email app on phone
2. Find reset email
3. Long-press token to copy
4. Open browser on phone
5. Go to `http://your-computer-ip:5173/login`
6. Click "Forgot password?"
7. Enter email
8. Paste token in modal
9. Set new password
10. Done!

## ✅ Success Indicators

- ✅ Email received with token
- ✅ Token modal appears
- ✅ Token input accepts 8 characters
- ✅ Password validation works
- ✅ Success toast appears
- ✅ Can login with new password

## 🎉 You're Done!

The token-based password reset is working perfectly. Users can now reset their passwords by:
1. Requesting a reset token via email
2. Copying the 8-character token from email
3. Entering it in the modal with new password
4. Logging in with new password

No page navigation, no clicking email links - just copy, paste, and reset!
