<template>
  <div class="min-h-screen bg-background">
    <Header v-if="!isAdmin" />
    <main>
      <router-view />
    </main>
    <Footer v-if="!isAdmin" />
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
    
    return {
      isAdmin
    }
  }
}
</script>
