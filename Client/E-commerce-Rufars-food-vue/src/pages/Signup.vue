<template>
  <div class="min-h-screen flex items-center justify-center bg-background py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
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
        <div class="mt-6 text-center">
          <router-link to="/login" class="text-primary hover:text-primary/80">
            Already have an account? Sign in
          </router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { useRouter } from 'vue-router'
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
      loading: false,
      error: ''
    }
  },
  
  setup() {
    const router = useRouter()
    return { router }
  },
  
  methods: {
    async handleSignup() {
      this.loading = true
      this.error = ''
      
      try {
        // Simulate signup API call
        await new Promise(resolve => setTimeout(resolve, 1000))
        
        // Basic validation
        if (!this.name || !this.email || !this.password) {
          this.error = 'Please fill in all fields'
          this.loading = false
          return
        }
        
        if (this.password.length < 6) {
          this.error = 'Password must be at least 6 characters'
          this.loading = false
          return
        }
        
        // Store user info in localStorage (simple auth simulation)
        localStorage.setItem('user', JSON.stringify({
          name: this.name,
          email: this.email,
          loggedIn: true
        }))
        
        // Redirect to checkout
        this.router.push('/checkout')
      } catch (err) {
        this.error = 'Signup failed. Please try again.'
        this.loading = false
      }
    }
  }
}
</script>
