# Authentication Flow Diagram

## Complete User Journey

```
┌─────────────────────────────────────────────────────────────────────┐
│                         NEW USER REGISTRATION                        │
└─────────────────────────────────────────────────────────────────────┘

    /signup-page
         │
         ├─► Fill Form (Name, Email, Password, Confirm)
         │
         ├─► Click "Sign up"
         │
         ├─► API: POST /api/register
         │
         ├─► Success?
         │   ├─► YES: 🟢 Toast: "Registration successful! Please login."
         │   │        └─► Redirect to /login-page (1.5s delay)
         │   │
         │   └─► NO:  🔴 Toast: Error message
         │            └─► Stay on signup page
         │
         ▼
    /login-page


┌─────────────────────────────────────────────────────────────────────┐
│                            USER LOGIN                                │
└─────────────────────────────────────────────────────────────────────┘

    /login-page
         │
         ├─► Enter Email & Password
         │
         ├─► Click "Sign in"
         │
         ├─► API: POST /api/login
         │
         ├─► Success?
         │   ├─► YES: 🟢 Toast: "Welcome back, {name}!"
         │   │        │
         │   │        ├─► Sync Guest Cart
         │   │        ├─► Fetch User Cart
         │   │        │
         │   │        ├─► Check User Role
         │   │        │   │
         │   │        │   ├─► is_admin = true
         │   │        │   │   └─► Redirect to /admin/dashboard
         │   │        │   │       └─► Load Admin Profile from API
         │   │        │   │
         │   │        │   └─► is_admin = false
         │   │        │       └─► Check Redirect Query
         │   │        │           ├─► Has redirect? → Go to redirect URL
         │   │        │           └─► No redirect? → Go to /profile
         │   │        │               └─► Load User Profile from API
         │   │
         │   └─► NO:  🔴 Toast: "Login failed"
         │            └─► Stay on login page
         │
         ▼
    /profile or /admin/dashboard


┌─────────────────────────────────────────────────────────────────────┐
│                         USER PROFILE PAGE                            │
└─────────────────────────────────────────────────────────────────────┘

    /profile
         │
         ├─► On Mount: API: GET /api/user
         │   └─► Load Real User Data (not mock)
         │
         ├─► Display User Info
         │   ├─► Name, Email, Phone
         │   ├─► Address, City, State, Pincode
         │   ├─► Order History
         │   ├─► Saved Addresses
         │   └─► Payment Methods
         │
         ├─► Click "Edit Profile"
         │   │
         │   ├─► Show Edit Modal
         │   ├─► Update Fields
         │   ├─► Click "Save Changes"
         │   │
         │   ├─► API: PUT /api/user/profile
         │   │
         │   └─► Success?
         │       ├─► YES: 🟢 Toast: "Profile updated successfully!"
         │       │        └─► Update Local State
         │       │
         │       └─► NO:  🔴 Toast: Error message
         │
         ▼
    Continue Shopping


┌─────────────────────────────────────────────────────────────────────┐
│                         CHECKOUT FLOW                                │
└─────────────────────────────────────────────────────────────────────┘

    Add Items to Cart
         │
         ├─► Click "Checkout"
         │
         ├─► Authenticated?
         │   ├─► NO:  Redirect to /login-page?redirect=/checkout
         │   │        └─► After login → Back to /checkout
         │   │
         │   └─► YES: Continue to checkout
         │
         ▼
    /checkout
         │
         ├─► On Mount: Pre-fill Form with User Data
         │   ├─► Name (from user.name)
         │   ├─► Email (from user.email)
         │   ├─► Phone (from user.phone)
         │   └─► Address (from user.address, city, state, pincode)
         │
         ├─► User Updates Shipping Info (if needed)
         │
         ├─► Select Payment Method
         │
         ├─► Click "Pay"
         │
         ├─► 🔵 Toast: "Processing payment..."
         │
         ├─► Simulate Payment (3 seconds)
         │
         ├─► API: PUT /api/user/profile
         │   └─► Auto-update profile with shipping info
         │
         ├─► Clear Cart
         │
         ├─► Generate Order ID
         │
         ├─► 🟢 Toast: "Order placed successfully!"
         │
         └─► Show Order Success Page
             └─► Profile now has updated shipping info


┌─────────────────────────────────────────────────────────────────────┐
│                         ADMIN DASHBOARD                              │
└─────────────────────────────────────────────────────────────────────┘

    /admin/dashboard
         │
         ├─► On Mount: API: GET /api/user
         │   └─► Load Real Admin Data (not mock)
         │
         ├─► Display Admin Header
         │   ├─► Admin Name
         │   ├─► Admin Email
         │   └─► Admin Avatar
         │
         ├─► Dashboard Features
         │   ├─► View Statistics
         │   ├─► Manage Products
         │   ├─► Manage Orders
         │   ├─► Manage Customers
         │   └─► View Analytics
         │
         ├─► Click "Logout"
         │   │
         │   ├─► API: POST /api/logout
         │   ├─► Clear Auth Store
         │   ├─► 🟢 Toast: "Logged out successfully"
         │   └─► Redirect to /login-page
         │
         ▼
    /login-page


┌─────────────────────────────────────────────────────────────────────┐
│                         ROUTE PROTECTION                             │
└─────────────────────────────────────────────────────────────────────┘

    Router Navigation Guard
         │
         ├─► Check Route Meta
         │
         ├─► requiresAuth?
         │   ├─► YES: Is Authenticated?
         │   │        ├─► YES: Continue
         │   │        └─► NO:  Redirect to /login-page?redirect={current}
         │   │
         │   └─► NO:  Continue
         │
         ├─► requiresAdmin?
         │   ├─► YES: Is Admin?
         │   │        ├─► YES: Continue
         │   │        └─► NO:  Redirect to / (home)
         │   │
         │   └─► NO:  Continue
         │
         ├─► guest (login/signup)?
         │   ├─► YES: Is Authenticated?
         │   │        ├─► YES: Is Admin?
         │   │        │        ├─► YES: Redirect to /admin/dashboard
         │   │        │        └─► NO:  Redirect to / (home)
         │   │        │
         │   │        └─► NO:  Continue
         │   │
         │   └─► NO:  Continue
         │
         └─► Allow Navigation


┌─────────────────────────────────────────────────────────────────────┐
│                         TOAST NOTIFICATIONS                          │
└─────────────────────────────────────────────────────────────────────┘

    🟢 Success (Green)
         ├─► "Welcome back, {name}!"
         ├─► "Registration successful! Please login."
         ├─► "Profile updated successfully!"
         ├─► "Order placed successfully!"
         └─► "Logged out successfully"

    🔴 Error (Red)
         ├─► "Login failed. Please try again."
         ├─► "Please fill in all fields"
         ├─► "Passwords do not match"
         ├─► "Password must be at least 6 characters"
         └─► "Failed to update profile"

    🔵 Info (Blue)
         ├─► "Processing payment..."
         ├─► "Google login coming soon!"
         └─► "Loading..."

    🟠 Warning (Orange)
         ├─► "Low stock alert"
         └─► "Important notice"


┌─────────────────────────────────────────────────────────────────────┐
│                         DATA FLOW                                    │
└─────────────────────────────────────────────────────────────────────┘

    API Response (Login)
         │
         ├─► { success: true, token: "...", user: {...} }
         │
         ├─► Store in Auth Store
         │   ├─► state.token = token
         │   └─► state.user = user
         │
         ├─► Store in localStorage
         │   ├─► localStorage.setItem('auth_token', token)
         │   └─► localStorage.setItem('user', JSON.stringify(user))
         │
         ├─► Set Axios Header
         │   └─► Authorization: Bearer {token}
         │
         └─► All Future API Calls Include Token


    Profile Update Flow
         │
         ├─► User edits profile OR completes checkout
         │
         ├─► API: PUT /api/user/profile
         │   └─► { name, email, phone, address, city, state, pincode }
         │
         ├─► Backend Updates Database
         │
         ├─► Backend Returns Updated User
         │
         ├─► Update Auth Store
         │   └─► state.user = updatedUser
         │
         ├─► Update localStorage
         │   └─► localStorage.setItem('user', JSON.stringify(updatedUser))
         │
         └─► UI Reflects Changes Immediately


┌─────────────────────────────────────────────────────────────────────┐
│                         SECURITY FLOW                                │
└─────────────────────────────────────────────────────────────────────┘

    Request Interceptor
         │
         ├─► Get token from localStorage
         │
         ├─► Add to request headers
         │   └─► Authorization: Bearer {token}
         │
         └─► Send request


    Response Interceptor
         │
         ├─► Check response status
         │
         ├─► 401 Unauthorized?
         │   ├─► YES: Clear localStorage
         │   │        Clear Auth Store
         │   │        Redirect to /login-page
         │   │
         │   └─► NO:  Return response
         │
         └─► Continue


┌─────────────────────────────────────────────────────────────────────┐
│                         STATE MANAGEMENT                             │
└─────────────────────────────────────────────────────────────────────┘

    Auth Store (Pinia)
         │
         ├─► State
         │   ├─► user: { id, name, email, is_admin, ... }
         │   ├─► token: "Bearer token string"
         │   ├─► loading: boolean
         │   └─► error: string | null
         │
         ├─► Getters
         │   ├─► isAuthenticated: !!token
         │   └─► isAdmin: user?.is_admin || false
         │
         └─► Actions
             ├─► register(data)
             ├─► login(data)
             ├─► logout()
             ├─► fetchUser()
             ├─► updateProfile(data)
             └─► forgotPassword(email)


    Cart Store (Pinia)
         │
         ├─► State
         │   ├─► items: []
         │   └─► loading: boolean
         │
         └─► Actions
             ├─► fetchCart()
             ├─► syncGuestCart()
             ├─► addItem(product, quantity)
             ├─► updateQuantity(itemId, quantity)
             ├─► removeItem(itemId)
             └─► clearCart()
```

## Key Points

### 1. Registration Flow
- User signs up → Success toast → Redirect to login
- No auto-login for security

### 2. Login Flow
- User logs in → Welcome toast → Role-based redirect
- Admin → Dashboard | User → Profile

### 3. Profile Management
- Real data from API (no mock)
- Edit and save with toast feedback
- Auto-update after checkout

### 4. Checkout Flow
- Pre-fill with user data
- Update profile automatically
- Clear cart on success

### 5. Route Protection
- Guest routes redirect authenticated users
- Auth routes redirect unauthenticated users
- Admin routes block non-admin users

### 6. Toast Notifications
- Success, Error, Info, Warning
- 3-second timeout
- Top-right position
- Max 3 toasts at once

### 7. Security
- JWT token in localStorage
- Token in all API requests
- Auto-logout on 401
- Role-based access control
