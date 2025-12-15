<template>
  <div class="min-h-screen bg-background">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <!-- Empty Cart -->
      <div v-if="items.length === 0" class="text-center py-12">
        <div class="w-24 h-24 bg-muted/20 rounded-full flex items-center justify-center mx-auto mb-6">
          <ShoppingBag :size="48" class="text-muted-foreground" />
        </div>
        <h1 class="text-3xl md:text-4xl font-bold text-foreground mb-4">
          Your Cart is Empty
        </h1>
        <p class="text-lg text-muted-foreground mb-8 max-w-md mx-auto">
          Looks like you haven't added any superfoods to your cart yet.
          Start exploring our premium collection!
        </p>
        <router-link to="/products">
          <Button class="bg-primary hover:bg-primary/90 text-white rounded-xl px-8 py-4 text-lg font-semibold shadow-lg hover:shadow-xl transition-all duration-300">
            Start Shopping
          </Button>
        </router-link>
      </div>

      <!-- Cart with Items -->
      <div v-else>
        <!-- Header -->
        <div class="flex items-center gap-4 mb-8">
          <router-link
            to="/products"
            class="flex items-center gap-2 text-muted-foreground hover:text-primary transition-colors"
          >
            <ArrowLeft :size="20" />
            <span class="hidden sm:inline">Continue Shopping</span>
          </router-link>
          <h1 class="text-3xl md:text-4xl font-bold text-foreground">
            Shopping Cart
          </h1>
        </div>

        <div class="grid lg:grid-cols-3 gap-8">
          <!-- Cart Items -->
          <div class="lg:col-span-2 space-y-4">
            <div
              v-for="item in items"
              :key="item.id"
              class="bg-white rounded-2xl p-6 border border-border shadow-sm hover:shadow-md transition-all duration-200"
            >
              <div class="flex gap-4">
                <div class="relative">
                  <img
                    :src="item.image || '/placeholder.svg'"
                    :alt="item.name"
                    class="w-20 h-20 sm:w-24 sm:h-24 object-cover rounded-xl"
                  />
                  <div class="absolute -top-2 -right-2 bg-secondary text-white text-xs font-bold rounded-full w-6 h-6 flex items-center justify-center">
                    {{ item.quantity }}
                  </div>
                </div>

                <div class="flex-1 min-w-0">
                  <h3 class="font-bold text-lg text-foreground mb-1 line-clamp-2">
                    {{ item.name }}
                  </h3>
                  <p class="text-primary font-bold text-xl mb-3">
                    ₹{{ item.price }}
                  </p>

                  <!-- Quantity Controls -->
                  <div class="flex items-center gap-3">
                    <div class="flex items-center gap-2 bg-background rounded-xl p-1">
                      <button
                        @click="updateQuantity(item.id, Math.max(1, item.quantity - 1))"
                        class="p-2 hover:bg-muted rounded-lg transition-colors"
                        :disabled="item.quantity <= 1"
                      >
                        <Minus :size="16" />
                      </button>
                      <span class="px-3 py-1 font-semibold min-w-[2rem] text-center">
                        {{ item.quantity }}
                      </span>
                      <button
                        @click="updateQuantity(item.id, item.quantity + 1)"
                        class="p-2 hover:bg-muted rounded-lg transition-colors"
                      >
                        <Plus :size="16" />
                      </button>
                    </div>

                    <div class="text-right">
                      <p class="text-sm text-muted-foreground">Total</p>
                      <p class="font-bold text-lg text-primary">
                        ₹{{ item.price * item.quantity }}
                      </p>
                    </div>
                  </div>
                </div>

                <button
                  @click="removeItem(item.id)"
                  class="p-3 text-destructive hover:bg-destructive/10 rounded-xl transition-colors self-start"
                >
                  <Trash2 :size="20" />
                </button>
              </div>
            </div>
          </div>

          <!-- Order Summary -->
          <div class="bg-white rounded-2xl p-6 border border-border shadow-sm h-fit sticky top-8">
            <h2 class="text-2xl font-bold text-foreground mb-6">
              Order Summary
            </h2>

            <div class="space-y-4 mb-6 pb-6 border-b border-border">
              <div class="flex justify-between">
                <span class="text-muted-foreground">Subtotal</span>
                <span class="font-semibold">₹{{ subtotal }}</span>
              </div>
              <div class="flex justify-between">
                <span class="text-muted-foreground">Shipping</span>
                <span class="font-semibold">
                  <span v-if="shipping === 0" class="text-secondary font-bold">Free</span>
                  <span v-else>₹{{ shipping }}</span>
                </span>
              </div>
              <div class="flex justify-between">
                <span class="text-muted-foreground">Tax (18%)</span>
                <span class="font-semibold">₹{{ tax }}</span>
              </div>
            </div>

            <div class="flex justify-between mb-6">
              <span class="text-xl font-bold text-foreground">Total</span>
              <span class="text-3xl font-bold text-primary">₹{{ total }}</span>
            </div>

            <!-- Free Shipping Banner -->
            <div v-if="subtotal < 1000" class="bg-secondary/10 border border-secondary/20 rounded-xl p-4 mb-6">
              <p class="text-sm text-secondary font-medium text-center">
                Add ₹{{ 1000 - subtotal }} more for free shipping!
              </p>
            </div>

            <div class="space-y-3">
              <Button 
                @click="proceedToCheckout"
                class="w-full bg-primary hover:bg-primary/90 text-white rounded-xl py-4 text-lg font-semibold shadow-lg hover:shadow-xl transition-all duration-300"
              >
                Proceed to Checkout
              </Button>
              <router-link to="/products" class="w-full">
                <Button
                  variant="outline"
                  class="w-full border-2 border-primary text-primary hover:bg-primary/5 bg-transparent rounded-xl py-3 font-semibold"
                >
                  Continue Shopping
                </Button>
              </router-link>
            </div>

            <!-- Security Badge -->
            <div class="mt-6 pt-6 border-t border-border">
              <div class="flex items-center justify-center gap-2 text-sm text-muted-foreground">
                <div class="w-4 h-4 bg-secondary rounded-full flex items-center justify-center">
                  <div class="w-2 h-2 bg-white rounded-full"></div>
                </div>
                <span>Secure Checkout</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { Trash2, Plus, Minus, ArrowLeft, ShoppingBag } from 'lucide-vue-next'
import Button from '@/components/ui/Button.vue'
import { useCartStore } from '@/stores/cart'
import { useAuthStore } from '@/stores/auth'
import { useToast } from 'vue-toastification'

export default {
  name: 'Cart',
  
  components: {
    Trash2,
    Plus,
    Minus,
    ArrowLeft,
    ShoppingBag,
    Button
  },
  
  computed: {
    items() {
      const cartStore = useCartStore()
      return cartStore.items
    },
    
    subtotal() {
      return this.items.reduce((sum, item) => sum + item.price * item.quantity, 0)
    },
    
    shipping() {
      return this.subtotal > 1000 ? 0 : 100
    },
    
    tax() {
      return Math.round(this.subtotal * 0.18)
    },
    
    total() {
      return this.subtotal + this.shipping + this.tax
    }
  },
  
  methods: {
    removeItem(id) {
      const cartStore = useCartStore()
      cartStore.removeItem(id)
    },
    
    updateQuantity(id, quantity) {
      const cartStore = useCartStore()
      cartStore.updateQuantity(id, quantity)
    },
    
    proceedToCheckout() {
      const authStore = useAuthStore()
      const toast = useToast()
      
      // Check if cart is empty
      if (this.items.length === 0) {
        toast.error('Your cart is empty')
        return
      }
      
      // Check if user is authenticated
      if (!authStore.isAuthenticated) {
        toast.info('Please login to proceed to checkout')
        this.$router.push({ name: 'Login', query: { redirect: '/checkout' } })
        return
      }
      
      // Proceed to checkout
      this.$router.push({ name: 'Checkout' })
    }
  }
}
</script>
