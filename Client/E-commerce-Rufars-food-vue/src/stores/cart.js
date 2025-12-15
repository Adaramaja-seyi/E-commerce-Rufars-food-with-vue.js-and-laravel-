import { defineStore } from 'pinia'
import { cartAPI } from '@/api.js'
import { useAuthStore } from './auth'

export const useCartStore = defineStore('cart', {
  state: () => ({
    items: [],
    loading: false,
    error: null,
  }),
  
  getters: {
    cartCount: (state) => {
      return state.items.reduce((sum, item) => sum + item.quantity, 0)
    },
    
    cartTotal: (state) => {
      return state.items.reduce((sum, item) => sum + (item.price * item.quantity), 0)
    }
  },
  
  actions: {
    // Fetch cart from API (for authenticated users)
    async fetchCart() {
      const authStore = useAuthStore()
      if (!authStore.isAuthenticated) {
        // Load from localStorage for guest users
        const localCart = localStorage.getItem('guest-cart')
        this.items = localCart ? JSON.parse(localCart) : []
        return
      }

      this.loading = true
      this.error = null

      try {
        const response = await cartAPI.get()
        if (response.data.success) {
          // Transform backend cart items to frontend format
          const backendItems = response.data.cart.items || []
          this.items = backendItems.map(item => ({
            id: item.product.id,
            cartItemId: item.id, // Store the cart_item id for updates/deletes
            name: item.product.name,
            price: parseFloat(item.product.price),
            image: item.product.image,
            quantity: item.quantity,
            category: item.product.category,
            description: item.product.description,
          }))
        }
      } catch (error) {
        console.error('Fetch cart error:', error)
        this.error = error.response?.data?.message || 'Failed to fetch cart'
      } finally {
        this.loading = false
      }
    },

    // Add item to cart
    async addItem(item) {
      const authStore = useAuthStore()
      
      // For guest users, use localStorage
      if (!authStore.isAuthenticated) {
        const existingItem = this.items.find(i => i.id === item.id)
        
        if (existingItem) {
          existingItem.quantity += item.quantity
        } else {
          this.items.push({ ...item })
        }
        
        localStorage.setItem('guest-cart', JSON.stringify(this.items))
        return { success: true }
      }

      // For authenticated users, use API
      this.loading = true
      this.error = null

      try {
        const response = await cartAPI.add(item.id, item.quantity)

        if (response.data.success) {
          await this.fetchCart()
          return { success: true }
        }
      } catch (error) {
        console.error('Add to cart error:', error)
        this.error = error.response?.data?.message || 'Failed to add item to cart'
        return { success: false, error: this.error }
      } finally {
        this.loading = false
      }
    },
    
    // Remove item from cart
    async removeItem(id) {
      const authStore = useAuthStore()
      
      // For guest users, use localStorage
      if (!authStore.isAuthenticated) {
        const index = this.items.findIndex(i => i.id === id)
        if (index > -1) {
          this.items.splice(index, 1)
        }
        localStorage.setItem('guest-cart', JSON.stringify(this.items))
        return { success: true }
      }

      // For authenticated users, use API
      // Find the cart item by product id to get the cartItemId
      const cartItem = this.items.find(i => i.id === id)
      if (!cartItem) {
        return { success: false, error: 'Item not found in cart' }
      }

      this.loading = true
      this.error = null

      try {
        const response = await cartAPI.remove(cartItem.cartItemId)
        
        if (response.data.success) {
          await this.fetchCart()
          return { success: true }
        }
      } catch (error) {
        console.error('Remove from cart error:', error)
        this.error = error.response?.data?.message || 'Failed to remove item'
        return { success: false, error: this.error }
      } finally {
        this.loading = false
      }
    },
    
    // Update item quantity
    async updateQuantity(id, quantity) {
      const authStore = useAuthStore()
      
      // For guest users, use localStorage
      if (!authStore.isAuthenticated) {
        const item = this.items.find(i => i.id === id)
        if (item) {
          item.quantity = quantity
        }
        localStorage.setItem('guest-cart', JSON.stringify(this.items))
        return { success: true }
      }

      // For authenticated users, use API
      // Find the cart item by product id to get the cartItemId
      const cartItem = this.items.find(i => i.id === id)
      if (!cartItem) {
        return { success: false, error: 'Item not found in cart' }
      }

      this.loading = true
      this.error = null

      try {
        const response = await cartAPI.update(cartItem.cartItemId, quantity)
        
        if (response.data.success) {
          await this.fetchCart()
          return { success: true }
        }
      } catch (error) {
        console.error('Update quantity error:', error)
        this.error = error.response?.data?.message || 'Failed to update quantity'
        return { success: false, error: this.error }
      } finally {
        this.loading = false
      }
    },
    
    // Clear cart
    async clearCart() {
      const authStore = useAuthStore()
      
      // For guest users, use localStorage
      if (!authStore.isAuthenticated) {
        this.items = []
        localStorage.removeItem('guest-cart')
        return { success: true }
      }

      // For authenticated users, use API
      this.loading = true
      this.error = null

      try {
        const response = await cartAPI.clear()
        
        if (response.data.success) {
          this.items = []
          return { success: true }
        }
      } catch (error) {
        console.error('Clear cart error:', error)
        this.error = error.response?.data?.message || 'Failed to clear cart'
        return { success: false, error: this.error }
      } finally {
        this.loading = false
      }
    },

    // Sync guest cart to authenticated user cart
    async syncGuestCart() {
      const guestCart = localStorage.getItem('guest-cart')
      if (!guestCart) return

      const items = JSON.parse(guestCart)
      
      for (const item of items) {
        await this.addItem(item)
      }

      localStorage.removeItem('guest-cart')
    }
  },
})
