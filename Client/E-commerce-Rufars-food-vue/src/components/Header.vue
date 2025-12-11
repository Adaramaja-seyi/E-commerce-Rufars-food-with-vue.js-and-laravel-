<template>
  <header class="sticky top-0 z-50 bg-background/95 backdrop-blur-sm border-b border-border">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-16">
        <!-- Logo -->
        <router-link to="/" class="flex items-center gap-2 flex-shrink-0">
          <div class="w-10 h-10 bg-gradient-to-br from-primary to-primary-light rounded-xl flex items-center justify-center shadow-sm">
            <span class="text-white font-bold text-lg">RF</span>
          </div>
          <span class="font-bold text-lg text-foreground hidden sm:inline">
            Rufars Foods
          </span>
        </router-link>

        <!-- Desktop Navigation -->
        <nav class="hidden md:flex items-center gap-8">
          <router-link
            to="/"
            class="text-foreground hover:text-primary transition-colors duration-200 font-medium"
          >
            Home
          </router-link>
          <router-link
            to="/products"
            class="text-foreground hover:text-primary transition-colors duration-200 font-medium"
          >
            Shop
          </router-link>
          <router-link
            to="/admin"
            class="text-foreground hover:text-primary transition-colors duration-200 text-sm font-medium"
          >
            Admin
          </router-link>
        </nav>

        <!-- Right Side Icons -->
        <div class="flex items-center gap-3">
          <!-- Search Icon - Mobile -->
          <button
            class="md:hidden p-2 text-foreground hover:text-primary transition-colors"
            @click="isSearchOpen = !isSearchOpen"
          >
            <Search :size="20" />
          </button>

          <!-- Profile Icon -->
          <router-link
            to="/profile"
            class="p-2 text-foreground hover:text-primary transition-colors"
            title="My Profile"
          >
            <User :size="24" />
          </router-link>

          <!-- Cart Icon -->
          <router-link
            to="/cart"
            class="relative p-2 text-foreground hover:text-primary transition-colors"
          >
            <ShoppingCart :size="24" />
            <span
              v-if="cartCount > 0"
              class="absolute -top-1 -right-1 bg-secondary text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center shadow-sm"
            >
              {{ cartCount }}
            </span>
          </router-link>

          <!-- Mobile Menu Button -->
          <button
            class="md:hidden p-2 text-foreground hover:text-primary transition-colors"
            @click="isOpen = !isOpen"
          >
            <X v-if="isOpen" :size="24" />
            <Menu v-else :size="24" />
          </button>
        </div>
      </div>

      <!-- Mobile Search -->
      <div v-if="isSearchOpen" class="md:hidden pb-4">
        <div class="relative">
          <input
            type="text"
            placeholder="Search products..."
            class="w-full px-4 py-3 pl-10 bg-input border border-border rounded-lg text-foreground placeholder-muted-foreground focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary"
          />
          <Search class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-muted-foreground" />
        </div>
      </div>

      <!-- Mobile Navigation -->
      <nav v-if="isOpen" class="md:hidden pb-4 border-t border-border pt-4">
        <div class="flex flex-col gap-3">
          <router-link
            to="/"
            class="text-foreground hover:text-primary transition-colors py-2 px-3 rounded-lg hover:bg-accent/10 font-medium"
            @click="isOpen = false"
          >
            Home
          </router-link>
          <router-link
            to="/products"
            class="text-foreground hover:text-primary transition-colors py-2 px-3 rounded-lg hover:bg-accent/10 font-medium"
            @click="isOpen = false"
          >
            Shop All Products
          </router-link>
          <router-link
            to="/admin"
            class="text-foreground hover:text-primary transition-colors py-2 px-3 rounded-lg hover:bg-accent/10 font-medium"
            @click="isOpen = false"
          >
            Admin Dashboard
          </router-link>
        </div>
      </nav>
    </div>
  </header>
</template>

<script>
import { ShoppingCart, Menu, X, Search, User } from 'lucide-vue-next'
import { useCartStore } from '@/stores/cart'

export default {
  name: 'Header',
  
  components: {
    ShoppingCart,
    Menu,
    X,
    Search,
    User
  },
  
  data() {
    return {
      isOpen: false,
      isSearchOpen: false
    }
  },
  
  computed: {
    cartCount() {
      const cartStore = useCartStore()
      return cartStore.cartCount
    }
  }
}
</script>
