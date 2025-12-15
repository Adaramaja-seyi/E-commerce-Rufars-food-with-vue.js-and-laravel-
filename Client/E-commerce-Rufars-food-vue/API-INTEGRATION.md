# API Integration Guide

## Overview
The frontend Vue.js application is now fully integrated with the Laravel backend API.

## Backend Setup
1. Make sure Laravel server is running:
   ```bash
   cd Sever
   php artisan serve
   ```
   Server should be running at: `http://127.0.0.1:8000`

2. Database should be seeded with products:
   ```bash
   php artisan migrate:fresh --seed
   ```

## Frontend Setup
1. Make sure frontend dev server is running:
   ```bash
   cd Client/E-commerce-Rufars-food-vue
   npm run dev
   ```

## Features Implemented

### 1. Authentication System
- **Registration**: Users can create accounts via `/signup-page`
- **Login**: Users can login via `/login-page`
- **Logout**: Authenticated users can logout from the header
- **Forgot Password**: Password reset functionality (UI ready, email sending needs SMTP config)
- **Token-based Auth**: Uses Laravel Sanctum for API authentication
- **Persistent Sessions**: Auth token stored in localStorage

### 2. Protected Routes
- `/profile` - Requires authentication
- `/checkout` - Requires authentication
- `/admin/*` - Requires authentication + admin role
- Redirects to login page with return URL if not authenticated

### 3. Cart Management
- **Guest Cart**: Uses localStorage for non-authenticated users
- **User Cart**: Uses API for authenticated users (stored in database)
- **Cart Sync**: Automatically syncs guest cart to user cart on login/signup
- **Real-time Updates**: Cart count updates in header

### 4. Header Navigation
- Shows Login/Signup buttons for guests
- Shows "Welcome, [Name]" and Logout button for authenticated users
- Responsive design for mobile and desktop

### 5. API Services
All API calls are centralized in `/src/api/`:
- `axios.js` - Axios instance with interceptors
- `auth.js` - Authentication endpoints
- `products.js` - Product CRUD operations
- `cart.js` - Cart management
- `orders.js` - Order management

### 6. State Management
Using Pinia stores:
- `auth.js` - User authentication state
- `cart.js` - Shopping cart state (with API integration)

## API Endpoints Used

### Authentication
- `POST /api/register` - User registration
- `POST /api/login` - User login
- `POST /api/logout` - User logout
- `GET /api/user` - Get authenticated user
- `POST /api/forgot-password` - Send password reset link

### Products
- `GET /api/products` - Get all products
- `GET /api/products/{id}` - Get single product
- `POST /api/products` - Create product (admin only)
- `PUT /api/products/{id}` - Update product (admin only)
- `DELETE /api/products/{id}` - Delete product (admin only)

### Cart
- `GET /api/cart` - Get user cart
- `POST /api/cart` - Add item to cart
- `PUT /api/cart/{id}` - Update cart item
- `DELETE /api/cart/{id}` - Remove cart item
- `DELETE /api/cart` - Clear cart

### Orders
- `GET /api/orders` - Get user orders
- `POST /api/orders` - Create order
- `GET /api/orders/{id}` - Get order details

## Testing the Integration

### Test Authentication Flow
1. Go to `/signup-page`
2. Create a new account
3. You should be automatically logged in and redirected to home
4. Header should show "Welcome, [Your Name]" and Logout button
5. Click Logout - should return to guest state

### Test Cart Sync
1. As a guest, add items to cart
2. Login or signup
3. Guest cart items should be synced to your user account
4. Cart should persist across sessions

### Test Protected Routes
1. Try to access `/profile` without logging in
2. Should redirect to `/login-page?redirect=/profile`
3. After login, should redirect back to `/profile`

### Test Admin Access
1. Login as admin user (set `is_admin = 1` in database)
2. Access `/admin` - should work
3. Login as regular user
4. Try to access `/admin` - should redirect to home

## Next Steps

### To Complete Full Integration:
1. **Update Product Pages**: Fetch products from API instead of local data
2. **Update Checkout**: Integrate order creation with API
3. **Update Profile**: Fetch and update user data via API
4. **Update Admin Panel**: Connect to product management API
5. **Add Loading States**: Show loading indicators during API calls
6. **Error Handling**: Improve error messages and handling
7. **Email Configuration**: Set up SMTP for password reset emails

### Product Integration Example:
```javascript
// In Products.vue or Home.vue
import { productsAPI } from '@/api'

async mounted() {
  try {
    const response = await productsAPI.getProducts()
    this.products = response.data.products
  } catch (error) {
    console.error('Failed to fetch products:', error)
  }
}
```

## Troubleshooting

### CORS Issues
If you see CORS errors, check:
- `Sever/config/cors.php` - Should allow `http://localhost:5173`
- Laravel server is running
- Frontend is running on correct port

### Authentication Not Working
- Check browser console for errors
- Verify token is stored in localStorage
- Check API responses in Network tab
- Ensure database has users table with `is_admin` column

### Cart Not Syncing
- Check if user is authenticated
- Verify cart API endpoints are working
- Check browser console for errors
- Ensure cart_items table exists in database

## Environment Variables
Make sure these are set in `Sever/.env`:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3307
DB_DATABASE=rufars-foods
DB_USERNAME=root
DB_PASSWORD=

SANCTUM_STATEFUL_DOMAINS=localhost:5173
SESSION_DOMAIN=localhost
```
