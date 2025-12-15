import { createApp } from 'vue'
import { createPinia } from 'pinia'
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate'
import App from './App.vue'
import router from './router'
import toast from './plugins/toast'
import { useAuthStore } from './stores/auth'
import { useCartStore } from './stores/cart'
import './assets/global.css'

const pinia = createPinia()
pinia.use(piniaPluginPersistedstate)

const app = createApp(App)

app.use(pinia)
app.use(router)
app.use(toast)

// Initialize auth and cart state
const authStore = useAuthStore()
const cartStore = useCartStore()

// Fetch user data if token exists
if (authStore.token) {
  authStore.fetchUser().then(() => {
    // Sync guest cart if user just logged in
    cartStore.syncGuestCart()
    // Fetch cart from API
    cartStore.fetchCart()
  })
} else {
  // Load guest cart from localStorage
  cartStore.fetchCart()
}

app.mount('#app')
