# 🚀 Quick Test Guide - CORS Fixed!

## ✅ Servers Status
- **Laravel Backend**: Running on `http://127.0.0.1:8000`
- **Vue Frontend**: Running on `http://localhost:5173`
- **CORS**: Configured and working

## 🧪 Test Registration (2 minutes)

### Step 1: Open Signup Page
```
URL: http://localhost:5173/signup-page
```

### Step 2: Fill Form
```
Name: John Doe
Email: john@example.com
Password: password123
Confirm Password: password123
```

### Step 3: Submit
- Click "Sign up" button
- **Expected Result**:
  - ✅ Green toast: "Registration successful! Please login."
  - ✅ Auto-redirect to login page after 1.5 seconds
  - ✅ NO CORS errors in console

### Step 4: Check Console (F12)
- Open DevTools
- Go to Console tab
- Should see: **No CORS errors** ✅
- Go to Network tab
- Should see: `POST /api/register` with status `200` or `201` ✅

---

## 🔐 Test Login (1 minute)

### Step 1: Login Page
```
URL: http://localhost:5173/login-page
(Should already be here after signup)
```

### Step 2: Enter Credentials
```
Email: john@example.com
Password: password123
```

### Step 3: Submit
- Click "Sign in" button
- **Expected Result**:
  - ✅ Green toast: "Welcome back, John Doe!"
  - ✅ Redirect to `/profile`
  - ✅ Profile shows real user data

---

## 👨‍💼 Test Admin Login (1 minute)

### Step 1: Logout (if logged in)
- Click profile menu → Logout

### Step 2: Login as Admin
```
URL: http://localhost:5173/login-page

Email: admin@rufarsfoods.com
Password: admin123
```

### Step 3: Submit
- Click "Sign in" button
- **Expected Result**:
  - ✅ Green toast: "Welcome back, Admin!"
  - ✅ Redirect to `/admin/dashboard`
  - ✅ Admin dashboard loads

---

## 🛒 Test Complete Flow (5 minutes)

### 1. Register New User
```
http://localhost:5173/signup-page
→ Fill form → Submit
→ See success toast
→ Redirect to login
```

### 2. Login
```
http://localhost:5173/login-page
→ Enter credentials → Submit
→ See welcome toast
→ Redirect to profile
```

### 3. Browse Products
```
Click "Products" in navigation
→ Browse available products
→ Click on a product
```

### 4. Add to Cart
```
On product detail page
→ Click "Add to Cart"
→ See success toast
→ Cart icon shows item count
```

### 5. Checkout
```
Click cart icon → View Cart
→ Click "Proceed to Checkout"
→ Form pre-fills with user data
→ Update shipping info if needed
→ Click "Pay"
→ See "Processing payment..." toast
→ See "Order placed successfully!" toast
→ Profile auto-updates with shipping info
```

### 6. Verify Profile Update
```
Go to Profile page
→ Check address fields
→ Should show updated shipping info
```

---

## 🐛 Quick Troubleshooting

### CORS Error Still Appears?
```bash
# 1. Hard refresh browser
Ctrl + Shift + R

# 2. Clear Laravel cache
cd Sever
php artisan config:clear

# 3. Restart Laravel server
Ctrl + C (stop)
php artisan serve (start)
```

### Registration Not Working?
```bash
# Check database connection
cd Sever
php artisan migrate:status

# Run migrations if needed
php artisan migrate

# Seed admin user
php artisan db:seed --class=AdminSeeder
```

### Toast Not Showing?
```bash
# Check Vue dev server
cd Client/E-commerce-Rufars-food-vue
npm run dev

# Check browser console for errors
F12 → Console tab
```

---

## 📊 Success Checklist

After testing, you should have:

- [x] Registered a new user successfully
- [x] Received success toast notification
- [x] Redirected to login page
- [x] Logged in successfully
- [x] Received welcome toast with name
- [x] Redirected to profile page
- [x] Profile shows real user data
- [x] No CORS errors in console
- [x] All API calls return 200/201 status

---

## 🎯 What to Look For

### ✅ Good Signs
- Green success toasts appear
- Smooth page transitions
- No console errors
- API calls succeed (200/201 status)
- Profile data loads correctly

### ❌ Bad Signs
- Red CORS errors in console
- API calls fail (0 status or 500 errors)
- No toast notifications
- Stuck on loading states
- Profile shows no data

---

## 📞 Need Help?

### Check These Files
1. `CORS-FIXED-SUMMARY.md` - Detailed fix explanation
2. `Sever/CORS-FIX.md` - Backend configuration details
3. `AUTH-FLOW.md` - Complete authentication flow
4. `QUICK-START.md` - Full testing guide

### Common Issues

**Issue**: CORS error still appears
**Solution**: Hard refresh browser (Ctrl+Shift+R)

**Issue**: 404 on API calls
**Solution**: Check Laravel server is running on port 8000

**Issue**: Toast not showing
**Solution**: Check Vue dev server is running

**Issue**: Login fails
**Solution**: Check database has users table and admin seeder ran

---

## 🎉 You're All Set!

Both servers are running and CORS is configured. Start testing at:

**Frontend**: http://localhost:5173
**Backend**: http://127.0.0.1:8000

Happy testing! 🚀
