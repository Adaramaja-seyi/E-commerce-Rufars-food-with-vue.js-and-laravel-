<template>
  <div class="min-h-screen flex items-center justify-center bg-background">
    <div class="text-center">
      <div class="w-16 h-16 border-4 border-primary border-t-transparent rounded-full animate-spin mx-auto mb-4"></div>
      <p class="text-lg text-gray-600">{{ message }}</p>
    </div>
  </div>
</template>

<script>
import { useRouter, useRoute } from 'vue-router'
import { useAuthStore } from '@/stores/auth'
import { useCartStore } from '@/stores/cart'
import { useToast } from 'vue-toastification'
import { onMounted, ref } from 'vue'

export default {
  name: 'GoogleCallback',
  
  setup() {
    const router = useRouter()
    const route = useRoute()
    const authStore = useAuthStore()
    const cartStore = useCartStore()
    const toast = useToast()
    const message = ref('Completing Google sign in...')
    
    onMounted(async () => {
      const token = route.query.token
      const error = route.query.error
      const redirectParam = route.query.redirect
      
      if (error) {
        message.value = 'Authentication failed'
        toast.error('Google authentication failed. Please try again.')
        setTimeout(() => {
          router.push('/login')
        }, 2000)
        return
      }
      
      if (token) {
        try {
          // Store the token
          authStore.token = token
          localStorage.setItem('auth_token', token)
          
          // Fetch user data
          message.value = 'Loading your profile...'
          const result = await authStore.fetchUser()
          
          if (result.success) {
            // Sync cart
            message.value = 'Setting up your cart...'
            await cartStore.syncGuestCart()
            await cartStore.fetchCart()
            
            // Success!
            toast.success(`Welcome, ${result.user.name}!`)
            
            // Determine redirect: URL param > sessionStorage > home
            let redirectTo = redirectParam || sessionStorage.getItem('redirect_after_login') || '/'
            sessionStorage.removeItem('redirect_after_login')
            
            setTimeout(() => {
              router.push(redirectTo)
            }, 500)
          } else {
            throw new Error('Failed to fetch user data')
          }
        } catch (err) {
          console.error('Google callback error:', err)
          message.value = 'Authentication failed'
          toast.error('Failed to complete sign in. Please try again.')
          setTimeout(() => {
            router.push('/login')
          }, 2000)
        }
      } else {
        message.value = 'Invalid authentication response'
        toast.error('Invalid authentication response')
        setTimeout(() => {
          router.push('/login')
        }, 2000)
      }
    })
    
    return {
      message
    }
  }
}
</script>
