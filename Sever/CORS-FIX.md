# CORS Fix Applied

## Changes Made

### 1. Updated `config/cors.php`
- Changed `allowed_origins` from `['*']` to specific frontend URLs
- Set `supports_credentials` to `true`
- Allowed origins:
  - `http://localhost:5173` (Vite dev server)
  - `http://127.0.0.1:5173`
  - `http://localhost:3000`

### 2. Updated `.env`
- Added `FRONTEND_URL=http://localhost:5173`
- Updated `APP_URL=http://127.0.0.1:8000`
- Added `SESSION_DOMAIN=localhost`
- Added `SANCTUM_STATEFUL_DOMAINS=localhost:5173,127.0.0.1:5173`

### 3. Updated `config/sanctum.php`
- Added `localhost:5173` and `127.0.0.1:5173` to stateful domains

### 4. Updated `bootstrap/app.php`
- Added CORS middleware to API routes

## Required Actions

### 1. Clear Laravel Cache
```bash
cd Sever
php artisan config:clear
php artisan cache:clear
php artisan route:clear
```

### 2. Restart Laravel Server
```bash
# Stop the current server (Ctrl+C)
# Then restart:
php artisan serve
```

### 3. Verify Frontend is Running
```bash
cd Client/E-commerce-Rufars-food-vue
npm run dev
```

## Testing

After restarting the server, try:

1. Go to `http://localhost:5173/signup-page`
2. Fill the registration form
3. Submit
4. **Expected**: No CORS error, successful registration

## Troubleshooting

### Still Getting CORS Error?

1. **Check Laravel server is running on port 8000**
   ```bash
   php artisan serve
   # Should show: Server running on [http://127.0.0.1:8000]
   ```

2. **Check Vue dev server is running on port 5173**
   ```bash
   npm run dev
   # Should show: Local: http://localhost:5173/
   ```

3. **Clear browser cache**
   - Open DevTools (F12)
   - Right-click refresh button
   - Select "Empty Cache and Hard Reload"

4. **Check .env file was saved**
   ```bash
   cat .env | grep FRONTEND_URL
   # Should show: FRONTEND_URL=http://localhost:5173
   ```

5. **Verify config cache is cleared**
   ```bash
   php artisan config:clear
   php artisan config:cache
   ```

### Alternative: Use Different Port

If port 8000 is busy, you can use a different port:

```bash
php artisan serve --port=8001
```

Then update the frontend API URL in `Client/E-commerce-Rufars-food-vue/src/api.js`:
```javascript
baseURL: "http://127.0.0.1:8001/api",
```

## What CORS Does

CORS (Cross-Origin Resource Sharing) allows your Vue frontend (running on `localhost:5173`) to make requests to your Laravel backend (running on `127.0.0.1:8000`).

Without proper CORS configuration, browsers block these requests for security reasons.

## Configuration Summary

### Frontend (Vue)
- Running on: `http://localhost:5173`
- API calls to: `http://127.0.0.1:8000/api`
- Credentials: `withCredentials: true`

### Backend (Laravel)
- Running on: `http://127.0.0.1:8000`
- Accepts requests from: `http://localhost:5173`
- Supports credentials: `true`
- CORS enabled for: `api/*` routes

## Next Steps

Once CORS is fixed, you should be able to:
- ✅ Register new users
- ✅ Login users
- ✅ Fetch user data
- ✅ Update profiles
- ✅ All API calls work without CORS errors
