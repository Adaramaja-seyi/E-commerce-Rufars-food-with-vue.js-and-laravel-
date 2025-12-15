<template>
  <div class="min-h-screen bg-background flex items-center justify-center px-4">
    <div class="max-w-md w-full">
      <!-- Loading State -->
      <div v-if="verifying" class="bg-white rounded-2xl p-8 border border-border shadow-sm text-center">
        <div class="w-16 h-16 border-4 border-primary border-t-transparent rounded-full animate-spin mx-auto mb-4"></div>
        <h2 class="text-xl font-bold text-foreground mb-2">Verifying Email...</h2>
        <p class="text-muted-foreground">Please wait while we verify your email address.</p>
      </div>

      <!-- Success State -->
      <div v-else-if="verified" class="bg-white rounded-2xl p-8 border border-border shadow-sm text-center">
        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
          <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
          </svg>
        </div>
        <h2 class="text-2xl font-bold text-foreground mb-2">Email Verified!</h2>
        <p class="text-muted-foreground mb-6">Your email has been successfully verified. You can now access all features.</p>
        <router-link to="/" class="inline-block px-6 py-3 bg-primary text-white rounded-xl hover:bg-primary/90 font-semibold">
          Go to Home
        </router-link>
      </div>

      <!-- Error State -->
      <div v-else-if="error" class="bg-white rounded-2xl p-8 border border-border shadow-sm text-center">
        <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
          <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </div>
        <h2 class="text-2xl font-bold text-foreground mb-2">Verification Failed</h2>
        <p class="text-muted-foreground mb-6">{{ errorMessage }}</p>
        <div class="space-y-3">
          <router-link to="/login-page" class="block px-6 py-3 bg-primary text-white rounded-xl hover:bg-primary/90 font-semibold">
            Go to Login
          </router-link>
          <button 
            @click="resendVerification"
            :disabled="resending"
            class="block w-full px-6 py-3 border-2 border-primary text-primary rounded-xl hover:bg-primary/5 font-semibold disabled:opacity-50"
          >
            {{ resending ? 'Sending...' : 'Resend Verification Email' }}
          </button>
        </div>
      </div>

      <!-- No Token State -->
      <div v-else class="bg-white rounded-2xl p-8 border border-border shadow-sm text-center">
        <h2 class="text-2xl font-bold text-foreground mb-2">Email Verification</h2>
        <p class="text-muted-foreground mb-6">Please check your email for the verification link.</p>
        <router-link to="/" class="inline-block px-6 py-3 bg-primary text-white rounded-xl hover:bg-primary/90 font-semibold">
          Go to Home
        </router-link>
      </div>
    </div>
  </div>
</template>

<script>
import { authAPI } from '@/api'
import { useToast } from 'vue-toastification'

export default {
  name: 'VerifyEmail',
  
  data() {
    return {
      verifying: false,
      verified: false,
      error: false,
      errorMessage: '',
      resending: false,
    }
  },
  
  async mounted() {
    const token = this.$route.query.token
    
    if (token) {
      await this.verifyEmail(token)
    }
  },
  
  methods: {
    async verifyEmail(token) {
      this.verifying = true
      this.error = false
      
      try {
        const response = await authAPI.verifyEmail(token)
        
        if (response.data.success) {
          this.verified = true
          
          // Update user in auth store if logged in
          const { useAuthStore } = await import('@/stores/auth')
          const authStore = useAuthStore()
          if (authStore.isAuthenticated) {
            await authStore.fetchUser()
          }
        } else {
          this.error = true
          this.errorMessage = response.data.message || 'Verification failed'
        }
      } catch (err) {
        this.error = true
        this.errorMessage = err.response?.data?.message || 'Invalid or expired verification link'
      } finally {
        this.verifying = false
      }
    },
    
    async resendVerification() {
      const toast = useToast()
      this.resending = true
      
      try {
        const response = await authAPI.resendVerification()
        
        if (response.data.success) {
          toast.success('Verification email sent! Check your inbox.')
          
          // For testing: show token in console
          if (response.data.verification_token) {
            console.log('Verification Token:', response.data.verification_token)
            console.log('Verification URL:', `${window.location.origin}/verify-email?token=${response.data.verification_token}`)
          }
        }
      } catch (err) {
        toast.error(err.response?.data?.message || 'Failed to resend verification email')
      } finally {
        this.resending = false
      }
    }
  }
}
</script>
