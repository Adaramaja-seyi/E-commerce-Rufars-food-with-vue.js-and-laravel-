import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from '@/stores/auth'
import Home from '../pages/Home.vue'
import Products from '../pages/Products.vue'
import ProductDetail from '../pages/ProductDetail.vue'
import Cart from '../pages/Cart.vue'
import Checkout from '../pages/Checkout.vue'
import Admin from '../pages/Admin.vue'
import Login from '../pages/Login.vue'
import Signup from '../pages/Signup.vue'
import Profile from '../pages/Profile.vue'
import Help from '../pages/Help.vue'
import VerifyEmail from '../pages/VerifyEmail.vue'

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home
  },
  {
    path: '/products',
    name: 'Products',
    component: Products
  },
  {
    path: '/product/:id',
    name: 'ProductDetail',
    component: ProductDetail
  },
  {
    path: '/cart',
    name: 'Cart',
    component: Cart
  },
  {
    path: '/checkout',
    name: 'Checkout',
    component: Checkout,
    meta: { requiresAuth: true }
  },
  {
    path: '/admin/:pathMatch(.*)*',
    name: 'Admin',
    component: Admin,
    meta: { requiresAuth: true, requiresAdmin: true }
  },
  {
    path: '/login-page',
    name: 'Login',
    component: Login,
    meta: { guest: true }
  },
  {
    path: '/signup-page',
    name: 'Signup',
    component: Signup,
    meta: { guest: true }
  },
  {
    path: '/profile',
    name: 'Profile',
    component: Profile,
    meta: { requiresAuth: true }
  },
  {
    path: '/help',
    name: 'Help',
    component: Help
  },
  {
    path: '/verify-email',
    name: 'VerifyEmail',
    component: VerifyEmail
  },
  {
    path: '/auth/google/callback',
    name: 'GoogleCallback',
    component: () => import('@/pages/GoogleCallback.vue')
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

// Navigation guards
router.beforeEach((to, from, next) => {
  const authStore = useAuthStore()

  // Check if route requires authentication
  if (to.meta.requiresAuth && !authStore.isAuthenticated) {
    next({ name: 'Login', query: { redirect: to.fullPath } })
    return
  }

  // Check if route requires admin
  if (to.meta.requiresAdmin && !authStore.isAdmin) {
    // Non-admin trying to access admin routes
    next({ name: 'Home' })
    return
  }

  // Redirect authenticated users away from guest-only pages
  if (to.meta.guest && authStore.isAuthenticated) {
    // If admin, redirect to admin dashboard
    if (authStore.isAdmin) {
      next({ name: 'Admin' })
    } else {
      next({ name: 'Home' })
    }
    return
  }

  next()
})

export default router
