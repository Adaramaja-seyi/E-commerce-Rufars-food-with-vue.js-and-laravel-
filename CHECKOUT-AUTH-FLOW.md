# Checkout Authentication Flow

## Overview
Implemented authentication check and user data pre-fill for the checkout process.

## Changes Made

### 1. Cart.vue - Proceed to Checkout Button
**Updated:** Changed from hardcoded link to dynamic authentication check

**Before:**
```vue
<router-link to="/signup" class="w-full">
  <Button>Proceed to Checkout</Button>
</router-link>
```

**After:**
```vue
<Button @click="proceedToCheckout">
  Proceed to Checkout
</Button>
```

**New Method:**
```javascript
proceedToCheckout() {
  // Check if cart is empty
  if (this.items.length === 0) {
    toast.error('Your cart is empty')
    return
  }
  
  // Check if user is authenticated
  if (!authStore.isAuthenticated) {
    toast.info('Please login to proceed to checkout')
    this.$router.push({ name: 'Login', query: { redirect: '/checkout' } })
    return
  }
  
  // Proceed to checkout
  this.$router.push({ name: 'Checkout' })
}
```

### 2. Checkout.vue - User Data Pre-fill
**Updated:** Enhanced mounted hook to fetch and pre-fill user data

**Changes:**
- Fetches latest user data from server on page load
- Pre-fills all form fields with user profile data
- Only fills fields that have data in the database
- Empty fields remain empty for user to fill

**Pre-filled Fields:**
- First Name (from user.name)
- Last Name (from user.name)
- Email (from user.email)
- Phone (from user.phone)
- Address (from user.address)
- City (from user.city)
- State (from user.state)
- Pincode (from user.pincode)

### 3. Router - Route Protection
**Already Configured:** Checkout route has authentication guard

```javascript
{
  path: '/checkout',
  name: 'Checkout',
  component: Checkout,
  meta: { requiresAuth: true }
}
```

## User Flow

### For Unauthenticated Users:
1. User adds items to cart
2. Clicks "Proceed to Checkout"
3. System checks authentication
4. Shows toast: "Please login to proceed to checkout"
5. Redirects to login page with redirect query: `/login-page?redirect=/checkout`
6. After successful login, user is redirected back to checkout
7. Checkout form is pre-filled with user data

### For Authenticated Users:
1. User adds items to cart
2. Clicks "Proceed to Checkout"
3. System checks authentication (passes)
4. Redirects directly to checkout page
5. Checkout form is automatically pre-filled with:
   - User's name (split into first/last)
   - Email address
   - Phone number (if available)
   - Shipping address (if available)
   - City, State, Pincode (if available)
6. User can edit any field or fill in missing information
7. User completes checkout

## Benefits

1. **Seamless UX**: Users don't need to re-enter information they've already provided
2. **Security**: Only authenticated users can access checkout
3. **Smart Redirect**: After login, users are taken directly to checkout
4. **Flexible**: Empty fields allow users to add new information
5. **Up-to-date**: Fetches latest user data from server on page load

## Testing Steps

### Test 1: Unauthenticated User
1. Logout if logged in
2. Add items to cart
3. Click "Proceed to Checkout"
4. Verify redirect to login page
5. Login with credentials
6. Verify redirect back to checkout
7. Verify form is pre-filled with user data

### Test 2: Authenticated User
1. Login to the application
2. Update profile with address information
3. Add items to cart
4. Click "Proceed to Checkout"
5. Verify direct navigation to checkout
6. Verify all available user data is pre-filled
7. Verify empty fields can be filled manually

### Test 3: Empty Cart
1. Clear cart
2. Click "Proceed to Checkout"
3. Verify error toast: "Your cart is empty"
4. Verify no navigation occurs

## Files Modified

- `Client/E-commerce-Rufars-food-vue/src/pages/Cart.vue`
- `Client/E-commerce-Rufars-food-vue/src/pages/Checkout.vue`
