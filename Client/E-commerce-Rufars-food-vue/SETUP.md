# Setup Guide

## Quick Start

1. **Install Dependencies**
   ```bash
   cd Client/E-commerce-Rufars-food-vue
   npm install
   ```

2. **Run Development Server**
   ```bash
   npm run dev
   ```

3. **Open Browser**
   Navigate to `http://localhost:5173`

## What's Included

### Pages
- **Home** (`/`) - Hero, Featured Products, Benefits
- **Products** (`/products`) - Product listing with filters
- **Product Detail** (`/product/:id`) - Individual product page
- **Cart** (`/cart`) - Shopping cart with checkout
- **Login** (`/login`) - Login page
- **Signup** (`/signup`) - Registration page
- **Admin** (`/admin/*`) - Admin dashboard (placeholder)
- **Checkout** (`/checkout`) - Checkout page (placeholder)

### Features Implemented
- ✅ Responsive navigation with mobile menu
- ✅ Shopping cart with add/remove/update quantity
- ✅ Cart persistence using localStorage
- ✅ Product filtering by category
- ✅ Product sorting (price, rating)
- ✅ Product detail view
- ✅ Same design and styling as React version
- ✅ All icons using Lucide Vue

### State Management
- **Pinia Store** for cart management
- **Persisted State** using pinia-plugin-persistedstate
- Cart data saved to localStorage automatically

## Project Conversion Notes

This Vue.js project is a complete conversion of the React project using:
- **Options API** (not Composition API)
- **Pinia** instead of Zustand
- **Vue Router** instead of React Router
- **Lucide Vue** instead of Lucide React

All components maintain the same design, functionality, and user experience as the original React version.

## Troubleshooting

### Port Already in Use
If port 5173 is already in use, Vite will automatically try the next available port.

### Module Not Found
Make sure you've run `npm install` in the project directory.

### Styles Not Loading
Ensure Tailwind CSS is properly configured in `postcss.config.js` and imported in `src/assets/global.css`.
