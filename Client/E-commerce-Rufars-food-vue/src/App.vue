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
import { computed } from 'vue'
import { useRoute } from 'vue-router'
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
    
    const isAdmin = computed(() => {
      return route.path.startsWith('/admin')
    })
    
    const isHelp = computed(() => {
      return route.path === '/help'
    })
    
    const isAuthPage = computed(() => {
      return route.path === '/login' || route.path === '/signup'
    })
    
    return {
      isAdmin,
      isHelp,
      isAuthPage
    }
  }
}
</script>
