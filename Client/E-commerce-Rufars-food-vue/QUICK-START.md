# Quick Start Guide - Authentication System

## 🚀 What's New

Your authentication system now includes:
- ✅ Toast notifications for all user actions
- ✅ Role-based routing (Admin vs User)
- ✅ Automatic profile updates after checkout
- ✅ Real data from API (no mock data)
- ✅ Smart redirects based on user role
- ✅ Complete signup → login → profile flow

## 📦 Installation Complete

The following package has been installed:
- `vue-toastification@next` - Toast notification library

## 🎯 How to Test

### 1. Start the Development Server
```bash
cd Client/E-commerce-Rufars-food-vue
npm run dev
```

### 2. Test User Registration
1. Navigate to `http://localhost:5173/signup-page`
2. Fill in the registration form
3. Click "Sign up"
4. **Expected**: 
   - ✅ Green toast: "Registration successful! Please login."
   - ✅ Auto-redirect to login page after 1.5 seconds

### 3. Test User Login
1. Navigate to `http://localhost:5173/login-page`
2. Enter user credentials (non-admin)
3. Click "Sign in"
4. **Expected**:
   - ✅ Green toast: "Welcome back, {name}!"
   - ✅ Redirect to `/profile`
   - ✅ Profile shows real user data from API

### 4. Test Admin Login
1. Navigate to `http://localhost:5173/login-page`
2. Enter admin credentials (is_admin: true)
3. Click "Sign in"
4. **Expected**:
   - ✅ Green toast: "Welcome back, Admin!"
   - ✅ Redirect to `/admin/dashboard`
   - ✅ Admin header shows real admin data

### 5. Test Checkout Flow
1. Add items to cart
2. Navigate to `/checkout`
3. **Expected**: Form pre-fills with user data
4. Update shipping information
5. Click "Pay"
6. **Expected**:
   - ✅ Blue toast: "Processing payment..."
   - ✅ Green toast: "Order placed successfully!"
   - ✅ Profile automatically updated with shipping info
7. Go to `/profile`
8. **Expected**: Profile shows updated address

### 6. Test Profile Update
1. Navigate to `/profile`
2. Click "Edit Profile"
3. Update information
4. Click "Save Changes"
5. **Expected**:
   - ✅ Green toast: "Profile updated successfully!"
   - ✅ Changes persist on page refresh

## 🔑 Test Credentials

### Admin User
```
Email: admin@rufarsfoods.com
Password: admin123
```

### Regular User
```
Email: user@example.com
Password: password123
```

## 🎨 Toast Notification Types

### Success (Green)
- Login successful
- Registration successful
- Profile updated
- Order placed

### Error (Red)
- Login failed
- Validation errors
- API errors

### Info (Blue)
- Processing messages
- Coming soon features

### Warning (Orange)
- Important notices

## 📁 Key Files Modified

### Frontend
- `src/main.js` - Added toast plugin
- `src/plugins/toast.js` - Toast configuration (NEW)
- `src/stores/auth.js` - Enhanced with role-based logic
- `src/pages/Login.vue` - Added toasts and role redirects
- `src/pages/Signup.vue` - Added toasts and login redirect
- `src/pages/Profile.vue` - Added API data fetching
- `src/pages/Checkout.vue` - Added profile auto-update
- `src/pages/Admin.vue` - Added admin data fetching
- `src/router/index.js` - Enhanced route guards
- `src/api.js` - Added updateProfile endpoint
- `src/assets/global.css` - Added toast styles

### Documentation
- `AUTH-FLOW.md` - Complete authentication flow documentation
- `IMPLEMENTATION-SUMMARY.md` - Summary of changes
- `BACKEND-INTEGRATION.md` - Laravel backend integration guide
- `QUICK-START.md` - This file

## 🔧 Backend Setup Required

Your Laravel backend needs these endpoints:

```
POST   /api/register          - Register new user
POST   /api/login             - Login (returns user with is_admin)
POST   /api/logout            - Logout
GET    /api/user              - Get authenticated user
PUT    /api/user/profile      - Update user profile
POST   /api/forgot-password   - Send reset link
```

See `BACKEND-INTEGRATION.md` for complete backend setup.

## 🎭 User Flow Examples

### New User Flow
```
1. Visit /signup-page
2. Fill form → Submit
3. See success toast
4. Auto-redirect to /login-page
5. Login with credentials
6. See welcome toast
7. Redirect to /profile
8. Profile shows real data
```

### Admin Flow
```
1. Visit /login-page
2. Login with admin credentials
3. See welcome toast
4. Redirect to /admin/dashboard
5. Admin data loaded from API
6. All admin features available
```

### Checkout Flow
```
1. Add items to cart
2. Go to /checkout
3. Form pre-fills with user data
4. Update shipping info
5. Place order
6. Profile auto-updates
7. Next checkout pre-fills with new data
```

## 🐛 Troubleshooting

### Toast Not Showing
- Check browser console for errors
- Verify `vue-toastification` is installed
- Check `src/main.js` has toast plugin

### Login Not Redirecting
- Check user role in API response
- Verify `is_admin` field exists
- Check browser console for errors

### Profile Not Updating
- Check API endpoint `/api/user/profile`
- Verify token is being sent
- Check network tab for errors

### Admin Access Denied
- Verify user has `is_admin: true`
- Check route guards in `router/index.js`
- Verify backend returns correct user data

## 📚 Documentation

For detailed information, see:
- `AUTH-FLOW.md` - Complete authentication flow
- `BACKEND-INTEGRATION.md` - Laravel backend setup
- `IMPLEMENTATION-SUMMARY.md` - What was implemented

## 🎉 You're All Set!

Your authentication system is now complete with:
- Role-based routing
- Toast notifications
- Profile management
- Smart redirects
- Real API integration

Start the dev server and test it out! 🚀
