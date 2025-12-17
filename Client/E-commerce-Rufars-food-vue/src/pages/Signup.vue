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
          Create your account
        </h2>
      </div>
      <div class="bg-white rounded-2xl p-8 border border-border shadow-sm">
        <form @submit.prevent="handleSignup" class="space-y-6">
          <div>
            <label for="name" class="block text-sm font-medium text-foreground mb-2">
              Full Name
            </label>
            <input
              id="name"
              v-model="name"
              type="text"
              required
              class="w-full px-4 py-3 border border-border rounded-xl bg-white text-foreground focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary"
              placeholder="Enter your name"
            />
          </div>
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
            <label for="password" class="block text-sm font-medium text-foreground mb-2">
              Password
            </label>
            <input
              id="password"
              v-model="password"
              type="password"
              required
              class="w-full px-4 py-3 border border-border rounded-xl bg-white text-foreground focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary"
              placeholder="Create a password"
            />
          </div>
          
          <div>
            <label for="confirmPassword" class="block text-sm font-medium text-foreground mb-2">
              Confirm Password
            </label>
            <input
              id="confirmPassword"
              v-model="confirmPassword"
              type="password"
              required
              class="w-full px-4 py-3 border border-border rounded-xl bg-white text-foreground focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary"
              placeholder="Confirm your password"
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
            {{ loading ? 'Creating account...' : 'Sign up' }}
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
            @click="handleGoogleSignup"
            type="button"
            class="mt-4 w-full flex items-center justify-center gap-3 px-4 py-3 border border-border rounded-xl bg-white hover:bg-gray-50 transition-colors"
          >
            <svg class="w-5 h-5" viewBox="0 0 24 24">
              <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
              <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
              <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
              <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
            </svg>
            <span class="text-foreground font-medium">Sign up with Google</span>
          </button>
        </div>
        
        <div class="mt-6 text-center">
          <router-link 
            :to="{ name: 'Login', query: $route.query }" 
            class="text-primary hover:text-primary/80"
          >
            Already have an account? Sign in
          </router-link>
        </div>
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
  name: 'Signup',
  
  components: {
    Button
  },
  
  data() {
    return {
      name: '',
      email: '',
      password: '',
      confirmPassword: '',
      loading: false,
      error: ''
    }
  },
  
  setup() {
    const router = useRouter()
    const authStore = useAuthStore()
    const toast = useToast()
    return { router, authStore, toast }
  },
  
  methods: {
    async handleSignup() {
      this.loading = true
      this.error = ''
      
      try {
        // Basic validation
        if (!this.name || !this.email || !this.password) {
          this.error = 'Please fill in all fields'
          this.toast.error('Please fill in all fields')
          this.loading = false
          return
        }
        
        if (this.password.length < 6) {
          this.error = 'Password must be at least 6 characters'
          this.toast.error('Password must be at least 6 characters')
          this.loading = false
          return
        }
        
        if (this.password !== this.confirmPassword) {
          this.error = 'Passwords do not match'
          this.toast.error('Passwords do not match')
          this.loading = false
          return
        }
        
        // Call API
        const result = await this.authStore.register({
          name: this.name,
          email: this.email,
          password: this.password,
          password_confirmation: this.confirmPassword
        })
        
        if (result.success) {
          // Show success toast
          this.toast.success(result.message || 'Registration successful! Please login.')
          
          // Redirect to login page with redirect query preserved
          setTimeout(() => {
            this.router.push({ name: 'Login', query: this.$route.query })
          }, 1500)
        } else {
          this.error = result.error || 'Signup failed. Please try again.'
          this.toast.error(result.error || 'Signup failed. Please try again.')
        }
      } catch (err) {
        this.error = 'Signup failed. Please try again.'
        this.toast.error('Signup failed. Please try again.')
      } finally {
        this.loading = false
      }
    },
    
    handleGoogleSignup() {
      // Preserve redirect query for Google OAuth
      const redirect = this.$route.query.redirect
      
      // Store in sessionStorage as backup
      if (redirect) {
        sessionStorage.setItem('redirect_after_login', redirect)
      }
      
      // Pass redirect to backend
      const googleUrl = redirect 
        ? `http://127.0.0.1:8000/api/auth/google?redirect=${encodeURIComponent(redirect)}`
        : 'http://127.0.0.1:8000/api/auth/google'
      window.location.href = googleUrl
    }
  }
}
</script>
