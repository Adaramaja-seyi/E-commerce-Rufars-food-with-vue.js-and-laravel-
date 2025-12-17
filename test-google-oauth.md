# Google OAuth Test Guide

## Current Configuration Status

✅ Backend routes configured
✅ AuthController has Google methods
✅ Frontend has Google login button
✅ Callback page exists
✅ Environment variables set

## Step-by-Step Testing

### 1. Start Both Servers

**Terminal 1 - Laravel Backend:**
```bash
cd Sever
php artisan serve
```
Should run on: http://127.0.0.1:8000

**Terminal 2 - Vue Frontend:**
```bash
cd Client/E-commerce-Rufars-food-vue
npm run dev
```
Should run on: http://localhost:5173

### 2. Test the Google OAuth Flow

1. **Open your browser** to: http://localhost:5173/login

2. **Open Developer Tools** (F12)
   - Go to Console tab
   - Go to Network tab

3. **Click "Sign in with Google"**

4. **Watch what happens:**
   - Should redirect to: `http://127.0.0.1:8000/api/auth/google`
   - Then redirect to Google's OAuth page
   - You select your Google account
   - Google redirects back to: `http://127.0.0.1:8000/api/auth/google/callback`
   - Laravel processes and redirects to: `http://localhost:5173/auth/google/callback?token=xxx`
   - Vue stores token and logs you in

### 3. What to Check

**In Browser Console:**
- ❌ `ERR_BLOCKED_BY_CLIENT` - **IGNORE THIS** (it's just ad blocker blocking Google analytics)
- ✅ Look for actual errors like:
  - `redirect_uri_mismatch`
  - `invalid_client`
  - `access_denied`

**In Network Tab:**
- Check the request to `/api/auth/google`
- Check the callback to `/api/auth/google/callback`
- Look for 4xx or 5xx errors

**In Laravel Logs:**
```bash
cd Sever
tail -f storage/logs/laravel.log
```

### 4. Common Issues & Solutions

#### Issue: "redirect_uri_mismatch"
**Solution:** 
- Go to Google Cloud Console
- Check Authorized redirect URIs
- Must be exactly: `http://127.0.0.1:8000/api/auth/google/callback`
- No trailing slash, use 127.0.0.1 not localhost

#### Issue: "invalid_client"
**Solution:**
- Check GOOGLE_CLIENT_ID in `.env`
- Check GOOGLE_CLIENT_SECRET in `.env`
- Run: `php artisan config:clear`

#### Issue: "This app isn't verified"
**Solution:**
- Click "Advanced"
- Click "Go to Rufars Food (unsafe)"
- This is normal for development

#### Issue: Stuck on callback page
**Solution:**
- Check browser console for errors
- Check if token is in URL
- Check Laravel logs for errors

### 5. Manual API Test

Test the redirect endpoint directly:

```bash
# Visit this in your browser:
http://127.0.0.1:8000/api/auth/google
```

Should redirect you to Google's OAuth page.

### 6. Verify Database

After successful login, check database:

```bash
cd Sever
php artisan tinker
```

```php
// Check if user was created
User::where('provider', 'google')->get();

// Check user details
$user = User::where('email', 'your-google-email@gmail.com')->first();
echo $user->google_id;
echo $user->avatar;
echo $user->email_verified_at;
```

## Expected Behavior

### First Time Google Login:
1. New user created in database
2. `google_id` stored
3. `avatar` URL stored
4. `provider` = 'google'
5. `email_verified_at` = now()
6. Random password generated
7. Token created
8. Redirected to frontend
9. Logged in successfully

### Existing User Google Login:
1. User found by email
2. `google_id` added/updated
3. `avatar` updated
4. `provider` = 'google'
5. Email auto-verified if not already
6. Token created
7. Redirected to frontend
8. Logged in successfully

## The ERR_BLOCKED_BY_CLIENT Error

**What it is:**
- Google tries to send analytics to `play.google.com/log`
- Your ad blocker blocks it
- This is NORMAL and HARMLESS

**What it's NOT:**
- ❌ Not blocking your authentication
- ❌ Not preventing login
- ❌ Not an error in your code

**How to verify it's not a problem:**
- If you can click Google button → see Google login page → get redirected back → logged in
- Then everything works! Ignore the console error.

## Quick Verification Checklist

- [ ] Laravel server running on http://127.0.0.1:8000
- [ ] Vue server running on http://localhost:5173
- [ ] Can access login page
- [ ] Google button visible
- [ ] Clicking button redirects to Google
- [ ] Can select Google account
- [ ] Redirects back to your app
- [ ] Shows loading message
- [ ] Logs you in successfully
- [ ] User data appears in database

## Need Help?

If something isn't working:

1. **Check Laravel logs:**
   ```bash
   tail -f Sever/storage/logs/laravel.log
   ```

2. **Check browser console** (ignore ERR_BLOCKED_BY_CLIENT)

3. **Check network tab** for actual HTTP errors

4. **Verify Google Console settings:**
   - Authorized redirect URIs
   - OAuth consent screen
   - Credentials are correct

5. **Clear config cache:**
   ```bash
   cd Sever
   php artisan config:clear
   php artisan cache:clear
   ```
