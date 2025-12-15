<template>
  <div class="min-h-screen bg-background">
    <Header v-if="!isAdmin && !isAuthPage" />
    <main>
      <router-view />
    </main>
    <Footer v-if="!isAdmin && !isHelp && !isAuthPage" />
  </div>
</template>

<script>
import { computed, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import { useCartStore } from '@/stores/cart'
import { useAuthStore } from '@/stores/auth'
import Header from './components/Header.vue'
import Footer from './components/Footer.vue'

export default {
  name: 'App',
  
  components: {
    Header,
    Footer
  },
  
  setup() {
    const route = useRoute()
    const cartStore = useCartStore()
    const authStore = useAuthStore()
    
    const isAdmin = computed(() => {
      return route.path.startsWith('/admin')
    })
    
    const isHelp = computed(() => {
      return route.path === '/help'
    })
    
    const isAuthPage = computed(() => {
      return route.path === '/login' || route.path === '/signup'
    })
    
    // Fetch cart on app mount if user is authenticated
    onMounted(async () => {
      if (authStore.isAuthenticated) {
        await cartStore.fetchCart()
      }
    })
    
    return {
      isAdmin,
      isHelp,
      isAuthPage
    }
  }
}
</script>
