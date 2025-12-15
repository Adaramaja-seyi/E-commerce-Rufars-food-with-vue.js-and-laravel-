# 🔐 Google OAuth Setup Guide

## ✅ What's Already Implemented

### Backend:
- ✅ Laravel Socialite installed
- ✅ Database migration (google_id, avatar, provider columns)
- ✅ User model updated
- ✅ AuthController with Google OAuth methods
- ✅ API routes configured
- ✅ Auto-verification for Google users

### Frontend:
- ✅ Google button on Login page
- ✅ Google button on Signup page
- ✅ Callback page to handle OAuth response
- ✅ Router configured
- ✅ Cart sync after Google login

## 🚀 Setup Instructions

### Step 1: Create Google OAuth Credentials

1. **Go to Google Cloud Console**
   - Visit: https://console.cloud.google.com/

2. **Create a New Project** (or select existing)
   - Click "Select a project" → "New Project"
   - Name: "Rufars Food"
   - Click "Create"

3. **Enable Google+ API**
   - Go to "APIs & Services" → "Library"
   - Search for "Google+ API"
   - Click "Enable"

4. **Create OAuth Credentials**
   - Go to "APIs & Services" → "Credentials"
   - Click "Create Credentials" → "OAuth client ID"
   - Application type: "Web application"
   - Name: "Rufars Food Web"
   
5. **Configure OAuth Consent Screen** (if prompted)
   - User Type: "External"
   - App name: "Rufars Food"
   - User support email: your-email@gmail.com
   - Developer contact: your-email@gmail.com
   - Click "Save and Continue"
   - Scopes: Add email, profile, openid
   - Test users: Add your email
   - Click "Save and Continue"

6. **Add Authorized Redirect URIs**
   ```
   http://127.0.0.1:8000/api/auth/google/callback
   http://localhost:8000/api/auth/google/callback
   ```

7. **Copy Credentials**
   - Copy "Client ID"
   - Copy "Client Secret"

### Step 2: Update `.env` File

Open `Sever/.env` and update these lines:

```env
GOOGLE_CLIENT_ID=your-actual-client-id-here
GOOGLE_CLIENT_SECRET=your-actual-client-secret-here
GOOGLE_REDIRECT_URI=http://127.0.0.1:8000/api/auth/google/callback
```

### Step 3: Clear Config Cache

```bash
cd Sever
php artisan config:clear
php artisan cache:clear
```

### Step 4: Test It!

1. **Start servers:**
   ```bash
   # Terminal 1 - Laravel
   cd Sever
   php artisan serve

   # Terminal 2 - Vue
   cd Client/E-commerce-Rufars-food-vue
   npm run dev
   ```

2. **Test Login:**
   - Go to http://localhost:5173/login
   - Click "Sign in with Google"
   - Select your Google account
   - Should redirect back and log you in!

3. **Test Signup:**
   - Go to http://localhost:5173/signup
   - Click "Sign up with Google"
   - Select your Google account
   - Should create account and log you in!

## 🎯 How It Works

### User Flow:
```
1. User clicks "Sign in with Google"
   ↓
2. Redirects to: http://127.0.0.1:8000/api/auth/google
   ↓
3. Laravel redirects to Google OAuth
   ↓
4. User selects Google account
   ↓
5. Google redirects to: http://127.0.0.1:8000/api/auth/google/callback
   ↓
6. Laravel processes OAuth response
   ↓
7. Creates/updates user in database
   ↓
8. Generates auth token
   ↓
9. Redirects to: http://localhost:5173/auth/google/callback?token=xxx
   ↓
10. Vue app stores token
   ↓
11. Fetches user data
   ↓
12. Syncs cart
   ↓
13. Redirects to home page
   ↓
14. ✅ User is logged in!
```

### Backend Logic:
```php
// Check if user exists by email
if (user exists) {
    // Update with Google info
    - Add google_id
    - Add avatar
    - Set provider = 'google'
    - Auto-verify email
} else {
    // Create new user
    - Name from Google
    - Email from Google
    - google_id
    - avatar
    - provider = 'google'
    - email_verified_at = now()
    - Random password
}

// Generate token
// Redirect to frontend with token
```

## 📊 Database Changes

New columns in `users` table:
- `google_id` - Unique Google user ID
- `avatar` - Google profile picture URL
- `provider` - 'google', 'facebook', etc.

## 🔒 Security Features

- ✅ Email auto-verified for Google users
- ✅ Unique google_id prevents duplicates
- ✅ Existing users can link Google account
- ✅ Random password for Google-only users
- ✅ Stateless OAuth (no session required)

## 🎨 UI Features

- ✅ Google logo on buttons
- ✅ Loading state during OAuth
- ✅ Error handling
- ✅ Success toast notification
- ✅ Cart sync after login
- ✅ Redirect to intended page

## 🐛 Troubleshooting

### "redirect_uri_mismatch" Error
- Check that redirect URI in Google Console matches exactly:
  `http://127.0.0.1:8000/api/auth/google/callback`
- No trailing slash
- Use 127.0.0.1, not localhost

### "Access blocked: This app's request is invalid"
- Make sure OAuth consent screen is configured
- Add your email as a test user
- Enable Google+ API

### "Invalid credentials"
- Check GOOGLE_CLIENT_ID in `.env`
- Check GOOGLE_CLIENT_SECRET in `.env`
- Run `php artisan config:clear`

### User not logging in
- Check browser console for errors
- Check Laravel logs: `storage/logs/laravel.log`
- Verify callback route is working: visit http://127.0.0.1:8000/api/auth/google

### Avatar not showing
- Avatar URL is stored in database
- Display in profile: `<img :src="user.avatar" />`
- Add fallback for users without avatar

## 📝 Files Created/Modified

### Backend:
1. `Sever/.env` - Added Google OAuth config
2. `Sever/config/services.php` - Added Google service
3. `Sever/database/migrations/2025_12_13_082009_add_google_oauth_to_users_table.php` - Migration
4. `Sever/app/Models/User.php` - Added fillable fields
5. `Sever/app/Http/Controllers/AuthController.php` - Added OAuth methods
6. `Sever/routes/api.php` - Added OAuth routes
7. `Sever/composer.json` - Added laravel/socialite

### Frontend:
1. `Client/E-commerce-Rufars-food-vue/src/pages/Login.vue` - Updated Google button
2. `Client/E-commerce-Rufars-food-vue/src/pages/Signup.vue` - Updated Google button
3. `Client/E-commerce-Rufars-food-vue/src/pages/GoogleCallback.vue` - New callback page
4. `Client/E-commerce-Rufars-food-vue/src/router/index.js` - Added callback route

## 🎉 Benefits

- **Faster signup** - No password needed
- **Better UX** - One-click authentication
- **Auto-verified** - Google emails are trusted
- **Profile picture** - Avatar from Google
- **Secure** - OAuth 2.0 standard
- **Mobile-friendly** - Works on all devices

## 🚀 Next Steps

After setup:
1. Test with multiple Google accounts
2. Test existing user linking Google
3. Test new user creation
4. Display avatar in profile
5. Add Facebook/Twitter OAuth (same pattern)

## 📱 Production Deployment

When deploying to production:

1. **Update redirect URI in Google Console:**
   ```
   https://yourdomain.com/api/auth/google/callback
   ```

2. **Update `.env` on production:**
   ```env
   GOOGLE_REDIRECT_URI=https://yourdomain.com/api/auth/google/callback
   FRONTEND_URL=https://yourdomain.com
   ```

3. **Update OAuth consent screen:**
   - Change from "Testing" to "In production"
   - Add privacy policy URL
   - Add terms of service URL

4. **Update frontend redirect:**
   - Change hardcoded URL to use environment variable
   - Or use relative URL: `/api/auth/google`

## ✅ Status

**Implementation:** ✅ Complete
**Setup Required:** Google OAuth credentials
**Testing:** Ready after credentials added

Once you add the Google OAuth credentials, the system will work immediately!
