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
          <router-link :to="{name:'Signup'}" class="text-primary hover:text-primary/80">
            Don't have an account? Sign up
          </router-link>
        </div>
      </div>
    </div>
    
    <!-- Forgot Password Modal -->
    <div v-if="showForgotPassword" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
      <div class="bg-white rounded-xl p-6 max-w-md w-full">
        <h3 class="text-xl font-bold text-gray-900 mb-4">Reset Password</h3>
        <p class="text-gray-600 mb-4">Enter your email address and we'll send you a token to reset your password.</p>
        
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
            <p class="text-green-600 text-sm">✅ Reset token sent! Check your email. A form will appear shortly.</p>
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
              :disabled="resetLoading"
              class="flex-1 px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 disabled:opacity-50 disabled:cursor-not-allowed"
            >
              {{ resetLoading ? 'Sending...' : 'Send Reset Token' }}
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- Reset Password Token Modal -->
    <div v-if="showTokenModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
      <div class="bg-white rounded-xl p-6 max-w-md w-full">
        <h3 class="text-xl font-bold text-gray-900 mb-4">Enter Reset Token</h3>
        <p class="text-gray-600 mb-4">Check your email for the reset token and enter it below along with your new password.</p>
        
        <form @submit.prevent="handleResetPassword">
          <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Reset Token</label>
            <input
              v-model="resetToken"
              type="text"
              required
              maxlength="8"
              class="w-full px-4 py-3 border-2 border-primary/30 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary font-mono text-2xl tracking-widest text-center uppercase"
              placeholder="XXXXXXXX"
              @input="resetToken = resetToken.toUpperCase()"
            />
            <p class="text-xs text-gray-500 mt-1 text-center">📧 Enter the 8-character token from your email</p>
          </div>

          <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
            <input
              v-model="newPassword"
              type="password"
              required
              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary"
              placeholder="Enter new password"
            />
          </div>

          <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
            <input
              v-model="confirmPassword"
              type="password"
              required
              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary"
              placeholder="Confirm new password"
            />
          </div>
          
          <div class="flex gap-3">
            <button
              type="button"
              @click="closeTokenModal"
              class="flex-1 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50"
            >
              Cancel
            </button>
            <button
              type="submit"
              :disabled="tokenLoading"
              class="flex-1 px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 disabled:opacity-50 disabled:cursor-not-allowed"
            >
              {{ tokenLoading ? 'Resetting...' : 'Reset Password' }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'
import { useToast } from 'vue-toastification'
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
      resetSuccess: false,
      resetLoading: false,
      showTokenModal: false,
      resetToken: '',
      newPassword: '',
      confirmPassword: '',
      tokenLoading: false
    }
  },
  
  setup() {
    const router = useRouter()
    const authStore = useAuthStore()
    const toast = useToast()
    return { router, authStore, toast }
  },
  
  methods: {
    async handleLogin() {
      this.loading = true
      this.error = ''
      
      try {
        // Basic validation
        if (!this.email || !this.password) {
          this.error = 'Please fill in all fields'
          this.toast.error('Please fill in all fields')
          this.loading = false
          return
        }
        
        // Call API
        const result = await this.authStore.login({
          email: this.email,
          password: this.password
        })
        
        if (result.success) {
          // Show success toast
          this.toast.success(`Welcome back, ${result.user.name}!`)
          
          // Import cart store dynamically
          const { useCartStore } = await import('@/stores/cart')
          const cartStore = useCartStore()
          
          // Sync guest cart and fetch user cart
          await cartStore.syncGuestCart()
          await cartStore.fetchCart()
          
          // Role-based redirect
          if (result.isAdmin) {
            // Admin goes to admin dashboard
            this.router.push('/admin/dashboard')
          } else {
            // User goes to intended page, profile, or home
            const redirect = this.$route.query.redirect
            if (redirect) {
              this.router.push(redirect)
            } else if (redirect === '/checkout') {
              this.router.push('/checkout')
            } else {
              this.router.push('/profile')
            }
          }
        } else {
          this.error = result.error || 'Login failed. Please try again.'
          this.toast.error(result.error || 'Login failed. Please try again.')
        }
      } catch (err) {
        this.error = 'Login failed. Please try again.'
        this.toast.error('Login failed. Please try again.')
      } finally {
        this.loading = false
      }
    },
    
    handleGoogleLogin() {
      // Redirect to backend Google OAuth
      window.location.href = 'http://127.0.0.1:8000/api/auth/google'
    },
    
    async handleForgotPassword() {
      if (!this.resetEmail) {
        this.error = 'Please enter your email'
        this.toast.error('Please enter your email')
        return
      }

      this.resetLoading = true

      try {
        const result = await this.authStore.forgotPassword(this.resetEmail)
        
        if (result.success) {
          this.resetSuccess = true
          this.toast.success('Reset token sent! Check your email and enter the token below.')
          
          // Show token modal after 2 seconds
          setTimeout(() => {
            this.showForgotPassword = false
            this.showTokenModal = true
            this.resetSuccess = false
          }, 2000)
        } else {
          this.error = result.error
          this.toast.error(result.error)
        }
      } catch (err) {
        this.error = 'Failed to send reset link. Please try again.'
        this.toast.error('Failed to send reset link. Please try again.')
      } finally {
        this.resetLoading = false
      }
    },

    async handleResetPassword() {
      if (!this.resetToken || !this.newPassword || !this.confirmPassword) {
        this.toast.error('Please fill in all fields')
        return
      }

      if (this.newPassword !== this.confirmPassword) {
        this.toast.error('Passwords do not match')
        return
      }

      if (this.newPassword.length < 6) {
        this.toast.error('Password must be at least 6 characters')
        return
      }

      this.tokenLoading = true

      try {
        const response = await this.authStore.resetPassword({
          email: this.resetEmail,
          token: this.resetToken,
          password: this.newPassword,
          password_confirmation: this.confirmPassword
        })

        if (response.success) {
          this.toast.success('Password reset successfully! You can now login.')
          this.showTokenModal = false
          this.resetEmail = ''
          this.resetToken = ''
          this.newPassword = ''
          this.confirmPassword = ''
        } else {
          this.toast.error(response.error || 'Failed to reset password')
        }
      } catch (err) {
        this.toast.error('Failed to reset password. Please try again.')
      } finally {
        this.tokenLoading = false
      }
    },

    closeTokenModal() {
      this.showTokenModal = false
      this.resetToken = ''
      this.newPassword = ''
      this.confirmPassword = ''
    }
  }
}
</script>
