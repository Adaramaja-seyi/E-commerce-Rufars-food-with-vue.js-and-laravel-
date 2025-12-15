# Authentication Flow Documentation

## Overview
This document describes the complete authentication flow with role-based routing, toast notifications, and profile updates.

## Features Implemented

### 1. Toast Notifications
- **Library**: vue-toastification
- **Location**: Integrated in `src/plugins/toast.js` and `src/main.js`
- **Usage**: Shows success/error messages for:
  - Login success/failure
  - Signup success/failure
  - Profile updates
  - Order placement
  - Logout

### 2. User Registration Flow
1. User fills signup form at `/signup-page`
2. Form validation (all fields required, password min 6 chars, passwords match)
3. API call to register endpoint
4. **Success**: 
   - Toast notification: "Registration successful! Please login."
   - Redirect to `/login-page` after 1.5 seconds
5. **Error**: 
   - Toast notification with error message
   - Error displayed on form

### 3. User Login Flow
1. User fills login form at `/login-page`
2. Form validation (email and password required)
3. API call to login endpoint
4. **Success**:
   - Toast notification: "Welcome back, {name}!"
   - Sync guest cart with user cart
   - **Role-based redirect**:
     - **Admin** (`is_admin: true`): Redirect to `/admin/dashboard`
     - **User** (`is_admin: false`): 
       - If `redirect` query param exists: Go to that page
       - If coming from checkout: Go to `/checkout`
       - Otherwise: Go to `/profile`
5. **Error**:
   - Toast notification with error message
   - Error displayed on form

### 4. Role-Based Routing

#### Router Guards (`src/router/index.js`)
- **Guest-only routes** (`/login-page`, `/signup-page`):
  - Authenticated users redirected to:
    - Admin → `/admin/dashboard`
    - User → `/` (home)
    
- **Auth-required routes** (`/checkout`, `/profile`):
  - Unauthenticated users redirected to `/login-page` with redirect query
  
- **Admin-only routes** (`/admin/*`):
  - Non-admin users redirected to `/` (home)
  - Requires both authentication AND `is_admin: true`

### 5. Profile Management

#### User Profile (`/profile`)
- **On Mount**:
  - Fetches fresh user data from API
  - Updates local state with real data
  - Replaces mock data with actual user information
  
- **Edit Profile**:
  - Modal form for editing user details
  - API call to update profile
  - Toast notification on success/error
  - Local state updated immediately
  
- **Profile Fields**:
  - Name
  - Email
  - Phone
  - Location/Address
  - City, State, Pincode

#### Admin Profile (`/admin/*`)
- **On Mount**:
  - Fetches fresh admin data from API
  - Updates admin profile display in header
  - Replaces mock admin data with real data
  
- **Logout**:
  - Clears auth store
  - Toast notification: "Logged out successfully"
  - Redirects to `/login-page`

### 6. Checkout Flow with Profile Update

#### Checkout Process (`/checkout`)
1. **Pre-fill Form**:
   - If user is logged in, form auto-fills with user data
   - Name, email, phone, address, city, state, pincode
   
2. **Order Submission**:
   - Validates all required fields
   - Toast: "Processing payment..."
   - Simulates payment processing (3 seconds)
   - **Updates user profile** with shipping information
   - Clears cart
   - Generates order ID
   - Toast: "Order placed successfully!"
   - Shows order success page
   
3. **Profile Update After Checkout**:
   - Automatically updates user profile with:
     - Full name (firstName + lastName)
     - Email
     - Phone
     - Complete address
     - City, State, Pincode
   - User profile is immediately updated for future orders

### 7. Auth Store (`src/stores/auth.js`)

#### State
```javascript
{
  user: null,           // User object from API
  token: null,          // JWT token
  loading: false,       // Loading state
  error: null          // Error message
}
```

#### Getters
- `isAuthenticated`: Returns true if token exists
- `isAdmin`: Returns true if user.is_admin is true

#### Actions
- `register(data)`: Register new user, returns success message
- `login(data)`: Login user, returns user and isAdmin flag
- `logout()`: Clear auth state and localStorage
- `fetchUser()`: Fetch fresh user data from API
- `updateProfile(data)`: Update user profile
- `forgotPassword(email)`: Send password reset link

### 8. API Endpoints (`src/api.js`)

#### Auth Endpoints
- `POST /api/register`: Register new user
- `POST /api/login`: Login user
- `POST /api/logout`: Logout user
- `GET /api/user`: Get authenticated user
- `PUT /api/user/profile`: Update user profile
- `POST /api/forgot-password`: Send reset link
- `POST /api/reset-password`: Reset password

### 9. Toast Notification Types

#### Success (Green)
- Login successful
- Registration successful
- Profile updated
- Order placed
- Logout successful

#### Error (Red)
- Login failed
- Registration failed
- Validation errors
- API errors
- Profile update failed

#### Info (Blue)
- Google login coming soon
- Processing messages

#### Warning (Orange)
- Low stock alerts
- Important notices

## User Flow Examples

### New User Registration
1. Visit `/signup-page`
2. Fill form: Name, Email, Password, Confirm Password
3. Click "Sign up"
4. See toast: "Registration successful! Please login."
5. Auto-redirect to `/login-page` after 1.5s
6. Login with credentials
7. See toast: "Welcome back, {name}!"
8. Redirect to `/profile`

### Admin Login
1. Visit `/login-page`
2. Enter admin credentials (email with `is_admin: true`)
3. Click "Sign in"
4. See toast: "Welcome back, Admin!"
5. Redirect to `/admin/dashboard`
6. Admin profile loaded from API (not mock data)

### User Checkout
1. Add items to cart
2. Click "Checkout"
3. If not logged in: Redirect to `/login-page?redirect=/checkout`
4. After login: Redirect to `/checkout`
5. Form pre-filled with user data
6. Fill/update shipping information
7. Click "Pay"
8. See toast: "Processing payment..."
9. Profile automatically updated with shipping info
10. See toast: "Order placed successfully!"
11. Cart cleared
12. Order success page shown

### Profile Update After Order
1. User completes checkout
2. Shipping information saved to profile
3. Next time user visits `/profile`:
   - Fresh data loaded from API
   - Shows updated address, phone, etc.
4. Next checkout:
   - Form pre-filled with updated information
   - No need to re-enter details

## Security Features

1. **JWT Token**: Stored in localStorage, sent with every API request
2. **Route Guards**: Protect admin and auth-required routes
3. **401 Handling**: Auto-logout and redirect to login on unauthorized
4. **Role Verification**: Server-side check for admin routes
5. **CSRF Protection**: Laravel Sanctum integration

## Testing Checklist

- [ ] New user can register successfully
- [ ] Registration shows success toast
- [ ] User redirected to login after signup
- [ ] User can login with correct credentials
- [ ] Login shows welcome toast with user name
- [ ] Regular user redirected to profile after login
- [ ] Admin redirected to admin dashboard after login
- [ ] Profile page shows real user data (not mock)
- [ ] Profile can be edited and saved
- [ ] Profile update shows success toast
- [ ] Checkout form pre-fills with user data
- [ ] Order completion updates user profile
- [ ] Updated profile data persists
- [ ] Logout clears auth state
- [ ] Logout shows success toast
- [ ] Protected routes redirect to login
- [ ] Admin routes blocked for regular users
- [ ] Toast notifications appear and disappear correctly
- [ ] Error messages show in toasts and forms

## Configuration

### Toast Settings (`src/plugins/toast.js`)
```javascript
{
  position: 'top-right',
  timeout: 3000,
  closeOnClick: true,
  pauseOnHover: true,
  maxToasts: 3
}
```

### Custom Toast Styles (`src/assets/global.css`)
- Success: #10b981 (green)
- Error: #ef4444 (red)
- Warning: #f59e0b (orange)
- Info: #3b82f6 (blue)
- Border radius: 12px
- Box shadow: Tailwind shadow-lg

## Future Enhancements

1. **Email Verification**: Verify email after registration
2. **Password Reset**: Complete forgot password flow
3. **OAuth**: Google/Facebook login integration
4. **2FA**: Two-factor authentication
5. **Session Management**: Active sessions list
6. **Profile Picture**: Upload and display avatar
7. **Order History**: Fetch real orders from API
8. **Address Book**: Multiple saved addresses
9. **Payment Methods**: Save payment methods securely
10. **Notifications**: Real-time notifications for orders
