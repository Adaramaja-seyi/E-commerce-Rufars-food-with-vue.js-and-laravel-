<template>
  <div class="min-h-screen flex items-center justify-center bg-background py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
      <!-- Logo -->
      <div class="flex justify-center">
        <router-link to="/" class="flex items-center gap-2">
          <div class="w-12 h-12 bg-gradient-to-br from-primary to-primary-light rounded-xl flex items-center justify-center shadow-lg">
            <span class="text-white font-bold text-xl">RF</span>
          </div>
          <span class="font-bold text-2xl text-foreground">
            Rufars Foods
          </span>
        </router-link>
      </div>
      
      <div>
        <h2 class="mt-6 text-center text-3xl font-bold text-foreground">
          Sign in to your account
        </h2>
      </div>
      <div class="bg-white rounded-2xl p-8 border border-border shadow-sm">
        <form @submit.prevent="handleLogin" class="space-y-6">
          <div>
            <label for="email" class="block text-sm font-medium text-foreground mb-2">
              Email address
            </label>
            <input
              id="email"
              v-model="email"
              type="email"
              required
              class="w-full px-4 py-3 border border-border rounded-xl bg-white text-foreground focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary"
              placeholder="Enter your email"
            />
          </div>
          <div>
            <div class="flex items-center justify-between mb-2">
              <label for="password" class="block text-sm font-medium text-foreground">
                Password
              </label>
              <button
                type="button"
                @click="showForgotPassword = true"
                class="text-sm text-primary hover:text-primary/80"
              >
                Forgot password?
              </button>
            </div>
            <input
              id="password"
              v-model="password"
              type="password"
              required
              class="w-full px-4 py-3 border border-border rounded-xl bg-white text-foreground focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary"
              placeholder="Enter your password"
            />
          </div>
          
          <div v-if="error" class="p-3 bg-red-50 border border-red-200 rounded-xl">
            <p class="text-red-600 text-sm">{{ error }}</p>
          </div>
          
          <Button
            type="submit"
            :disabled="loading"
            class="w-full bg-primary hover:bg-primary/90 text-white rounded-xl py-3 text-lg font-semibold disabled:opacity-50"
          >
            {{ loading ? 'Signing in...' : 'Sign in' }}
          </Button>
        </form>
        
        <div class="mt-6">
          <div class="relative">
            <div class="absolute inset-0 flex items-center">
              <div class="w-full border-t border-border"></div>
            </div>
            <div class="relative flex justify-center text-sm">
              <span class="px-2 bg-white text-gray-500">Or continue with</span>
            </div>
          </div>
          
          <button
            @click="handleGoogleLogin"
            type="button"
            class="mt-4 w-full flex items-center justify-center gap-3 px-4 py-3 border border-border rounded-xl bg-white hover:bg-gray-50 transition-colors"
          >
            <svg class="w-5 h-5" viewBox="0 0 24 24">
              <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
              <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
              <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
              <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
            </svg>
            <span class="text-foreground font-medium">Sign in with Google</span>
          </button>
        </div>
        
        <div class="mt-6 text-center">
          <router-link to="/signup" class="text-primary hover:text-primary/80">
            Don't have an account? Sign up
          </router-link>
        </div>
      </div>
    </div>
    
    <!-- Forgot Password Modal -->
    <div v-if="showForgotPassword" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
      <div class="bg-white rounded-xl p-6 max-w-md w-full">
        <h3 class="text-xl font-bold text-gray-900 mb-4">Reset Password</h3>
        <p class="text-gray-600 mb-4">Enter your email address and we'll send you a link to reset your password.</p>
        
        <form @submit.prevent="handleForgotPassword">
          <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Email address</label>
            <input
              v-model="resetEmail"
              type="email"
              required
              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary"
              placeholder="Enter your email"
            />
          </div>
          
          <div v-if="resetSuccess" class="mb-4 p-3 bg-green-50 border border-green-200 rounded-lg">
            <p class="text-green-600 text-sm">Password reset link sent! Check your email.</p>
          </div>
          
          <div class="flex gap-3">
            <button
              type="button"
              @click="showForgotPassword = false; resetEmail = ''; resetSuccess = false"
              class="flex-1 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50"
            >
              Cancel
            </button>
            <button
              type="submit"
              class="flex-1 px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90"
            >
              Send Reset Link
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import { useRouter } from 'vue-router'
import Button from '@/components/ui/Button.vue'

export default {
  name: 'Login',
  
  components: {
    Button
  },
  
  data() {
    return {
      email: '',
      password: '',
      loading: false,
      error: '',
      showForgotPassword: false,
      resetEmail: '',
      resetSuccess: false
    }
  },
  
  setup() {
    const router = useRouter()
    return { router }
  },
  
  methods: {
    async handleLogin() {
      this.loading = true
      this.error = ''
      
      try {
        // Simulate login API call
        await new Promise(resolve => setTimeout(resolve, 1000))
        
        // Basic validation
        if (!this.email || !this.password) {
          this.error = 'Please fill in all fields'
          this.loading = false
          return
        }
        
        // Store user info in localStorage (simple auth simulation)
        localStorage.setItem('user', JSON.stringify({
          email: this.email,
          loggedIn: true
        }))
        
        // Redirect to checkout
        this.router.push('/checkout')
      } catch (err) {
        this.error = 'Login failed. Please try again.'
        this.loading = false
      }
    },
    
    async handleGoogleLogin() {
      this.loading = true
      this.error = ''
      
      try {
        // Simulate Google OAuth
        await new Promise(resolve => setTimeout(resolve, 1000))
        
        // Store user info in localStorage
        localStorage.setItem('user', JSON.stringify({
          email: 'user@gmail.com',
          loggedIn: true,
          provider: 'google'
        }))
        
        // Redirect to checkout
        this.router.push('/checkout')
      } catch (err) {
        this.error = 'Google login failed. Please try again.'
        this.loading = false
      }
    },
    
    async handleForgotPassword() {
      try {
        // Simulate password reset API call
        await new Promise(resolve => setTimeout(resolve, 1000))
        this.resetSuccess = true
        
        // Auto close after 3 seconds
        setTimeout(() => {
          this.showForgotPassword = false
          this.resetEmail = ''
          this.resetSuccess = false
        }, 3000)
      } catch (err) {
        this.error = 'Failed to send reset link. Please try again.'
      }
    }
  }
}
</script>
