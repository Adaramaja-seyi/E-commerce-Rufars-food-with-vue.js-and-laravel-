# Google Redirect URI Mismatch - Complete Fix

## Current Configuration (Verified)

✅ Laravel is sending: `http://127.0.0.1:8000/api/auth/google/callback`
✅ Client ID: `409005949290-gmc9b526i1ng7rkut4vl3iq4iil69pli.apps.googleusercontent.com`

## Step-by-Step Fix

### 1. Go to Google Cloud Console

Visit: https://console.cloud.google.com/apis/credentials

### 2. Find Your OAuth Client

Look for the client with ID starting with: `409005949290-gmc9b526i1ng7rkut4vl3iq4iil69pli`

### 3. Click on it to Edit

### 4. Check "Authorized redirect URIs" Section

You need to have **EXACTLY** this URI (copy and paste it):

```
http://127.0.0.1:8000/api/auth/google/callback
```

### 5. Common Mistakes to Avoid

❌ **Wrong:** `http://localhost:8000/api/auth/google/callback` (localhost instead of 127.0.0.1)
❌ **Wrong:** `http://127.0.0.1:8000/api/auth/google/callback/` (trailing slash)
❌ **Wrong:** `http://127.0.0.1/api/auth/google/callback` (missing port)
❌ **Wrong:** `https://127.0.0.1:8000/api/auth/google/callback` (https instead of http)
❌ **Wrong:** `http://127.0.0.1:8000/auth/google/callback` (missing /api)

✅ **Correct:** `http://127.0.0.1:8000/api/auth/google/callback`

### 6. Save and Wait

- Click "SAVE" button
- Wait 2-3 minutes for Google to propagate changes
- Clear your browser cache or use incognito mode

## Alternative: Check What Google Sees

When you get the error, Google shows you the mismatch. Look for:

```
Request Details
redirect_uri: [what Laravel sent]

Authorized redirect URIs
[what you have in Google Console]
```

These must match EXACTLY.

## If Still Not Working - Try This

### Option A: Use localhost instead

1. **Change your .env:**
   ```env
   APP_URL=http://localhost:8000
   GOOGLE_REDIRECT_URI=http://localhost:8000/api/auth/google/callback
   ```

2. **Add to Google Console:**
   ```
   http://localhost:8000/api/auth/google/callback
   ```

3. **Update Login.vue to use localhost:**
   Change line 315 from:
   ```javascript
   : 'http://127.0.0.1:8000/api/auth/google'
   ```
   To:
   ```javascript
   : 'http://localhost:8000/api/auth/google'
   ```

4. **Clear config:**
   ```bash
   cd Sever
   php artisan config:clear
   ```

5. **Restart Laravel server:**
   ```bash
   php artisan serve --host=localhost
   ```

### Option B: Add Both URIs

In Google Console, add BOTH:
```
http://127.0.0.1:8000/api/auth/google/callback
http://localhost:8000/api/auth/google/callback
```

This way it works with either.

## Verify Your Google Console Setup

Your OAuth client should have:

**Application type:** Web application

**Authorized JavaScript origins:**
```
http://localhost:5173
http://127.0.0.1:8000
http://localhost:8000
```

**Authorized redirect URIs:**
```
http://127.0.0.1:8000/api/auth/google/callback
http://localhost:8000/api/auth/google/callback
```

## Test After Changes

1. **Wait 2-3 minutes** after saving in Google Console
2. **Clear browser cache** or use incognito
3. **Restart Laravel server:**
   ```bash
   cd Sever
   php artisan serve
   ```
4. **Try again:**
   - Go to http://localhost:5173/login
   - Click "Sign in with Google"

## Debug: Check What's Being Sent

Visit this URL directly in your browser:
```
http://127.0.0.1:8000/api/auth/google
```

It will redirect to Google. Look at the URL - it should contain:
```
redirect_uri=http%3A%2F%2F127.0.0.1%3A8000%2Fapi%2Fauth%2Fgoogle%2Fcallback
```

(That's the URL-encoded version of `http://127.0.0.1:8000/api/auth/google/callback`)

Copy that exact URI and make sure it's in your Google Console.

## Still Having Issues?

Take a screenshot of:
1. The Google error page (showing the redirect URI mismatch details)
2. Your Google Console "Authorized redirect URIs" section

This will help identify the exact mismatch.
