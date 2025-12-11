import { defineStore } from 'pinia'

export const useCartStore = defineStore('cart', {
  state: () => ({
    items: []
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
    addItem(item) {
      const existingItem = this.items.find(i => i.id === item.id)
      
      if (existingItem) {
        existingItem.quantity += item.quantity
      } else {
        this.items.push({ ...item })
      }
    },
    
    removeItem(id) {
      const index = this.items.findIndex(i => i.id === id)
      if (index > -1) {
        this.items.splice(index, 1)
      }
    },
    
    updateQuantity(id, quantity) {
      const item = this.items.find(i => i.id === id)
      if (item) {
        item.quantity = quantity
      }
    },
    
    clearCart() {
      this.items = []
    }
  },
  
  persist: {
    key: 'cart-storage',
    storage: localStorage,
  }
})
