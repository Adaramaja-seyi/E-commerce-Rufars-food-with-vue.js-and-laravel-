<template>
  <div class="min-h-screen bg-background">
    <!-- Empty Cart State -->
    <div v-if="cartItems.length === 0 && !orderPlaced" class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
      <div class="text-center">
        <h1 class="text-3xl md:text-4xl font-bold text-foreground mb-4">
          Checkout
        </h1>
        <p class="text-lg text-muted-foreground mb-8">
          Your cart is empty. Add some superfoods to continue!
        </p>
        <router-link to="/products">
          <Button class="bg-primary hover:bg-primary/90 text-white rounded-xl px-8 py-4 text-lg font-semibold">
            Start Shopping
          </Button>
        </router-link>
      </div>
    </div>

    <!-- Order Success State -->
    <div v-else-if="orderPlaced" class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
      <div class="bg-white rounded-2xl p-8 border border-border shadow-lg text-center">
        <div class="w-20 h-20 bg-secondary/10 rounded-full flex items-center justify-center mx-auto mb-6">
          <CheckCircle :size="40" class="text-secondary" />
        </div>
        <h1 class="text-3xl md:text-4xl font-bold text-foreground mb-4">
          Order Placed Successfully!
        </h1>
        <p class="text-lg text-muted-foreground mb-8 max-w-md mx-auto">
          Thank you for choosing Rufars Foods! Your order is confirmed and will be processed shortly.
        </p>

        <div class="bg-background rounded-xl p-6 mb-8 text-left">
          <h3 class="font-bold text-foreground mb-4">Order Details</h3>
          <div class="space-y-2 text-sm">
            <div class="flex justify-between">
              <span class="text-muted-foreground">Order ID:</span>
              <span class="font-semibold">#RUF{{ orderId }}</span>
            </div>
            <div class="flex justify-between">
              <span class="text-muted-foreground">Total Amount:</span>
              <span class="font-semibold text-primary">₹{{ total }}</span>
            </div>
            <div class="flex justify-between">
              <span class="text-muted-foreground">Payment Method:</span>
              <span class="font-semibold capitalize">{{ paymentMethod }}</span>
            </div>
            <div class="flex justify-between">
              <span class="text-muted-foreground">Estimated Delivery:</span>
              <span class="font-semibold">3-5 business days</span>
            </div>
          </div>
        </div>

        <div class="space-y-3">
          <router-link to="/">
            <Button class="w-full bg-primary hover:bg-primary/90 text-white rounded-xl py-4 text-lg font-semibold">
              Back to Home
            </Button>
          </router-link>
          <router-link to="/products">
            <Button variant="outline" class="w-full border-2 border-primary text-primary hover:bg-primary/5 bg-transparent rounded-xl py-3 font-semibold">
              Continue Shopping
            </Button>
          </router-link>
        </div>
      </div>
    </div>

    <!-- Checkout Form -->
    <div v-else class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <!-- Header -->
      <div class="flex items-center gap-4 mb-8">
        <router-link to="/cart" class="flex items-center gap-2 text-muted-foreground hover:text-primary transition-colors">
          <ArrowLeft :size="20" />
          <span class="hidden sm:inline">Back to Cart</span>
        </router-link>
        <h1 class="text-3xl md:text-4xl font-bold text-foreground">
          Checkout
        </h1>
      </div>

      <div class="grid lg:grid-cols-3 gap-8">
        <!-- Checkout Form -->
        <div class="lg:col-span-2 space-y-6">
          <form @submit.prevent="handleSubmit" class="space-y-6">
            <!-- Shipping Information -->
            <div class="bg-white rounded-2xl p-6 border border-border shadow-sm">
              <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 bg-primary/10 rounded-xl flex items-center justify-center">
                  <Truck :size="20" class="text-primary" />
                </div>
                <h2 class="text-2xl font-bold text-foreground">
                  Shipping Information
                </h2>
              </div>

              <div class="grid sm:grid-cols-2 gap-4">
                <div>
                  <label class="block text-sm font-medium text-foreground mb-2">
                    First Name *
                  </label>
                  <input
                    v-model="formData.firstName"
                    type="text"
                    placeholder="Enter your first name"
                    required
                    class="w-full px-4 py-3 border border-border rounded-xl bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary"
                  />
                </div>
                <div>
                  <label class="block text-sm font-medium text-foreground mb-2">
                    Last Name *
                  </label>
                  <input
                    v-model="formData.lastName"
                    type="text"
                    placeholder="Enter your last name"
                    required
                    class="w-full px-4 py-3 border border-border rounded-xl bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary"
                  />
                </div>
                <div class="sm:col-span-2">
                  <label class="block text-sm font-medium text-foreground mb-2">
                    Email Address *
                  </label>
                  <input
                    v-model="formData.email"
                    type="email"
                    placeholder="Enter your email address"
                    required
                    class="w-full px-4 py-3 border border-border rounded-xl bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary"
                  />
                </div>
                <div class="sm:col-span-2">
                  <label class="block text-sm font-medium text-foreground mb-2">
                    Phone Number *
                  </label>
                  <input
                    v-model="formData.phone"
                    type="tel"
                    placeholder="Enter your phone number"
                    required
                    class="w-full px-4 py-3 border border-border rounded-xl bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary"
                  />
                </div>
                <div class="sm:col-span-2">
                  <label class="block text-sm font-medium text-foreground mb-2">
                    Address *
                  </label>
                  <input
                    v-model="formData.address"
                    type="text"
                    placeholder="Enter your complete address"
                    required
                    class="w-full px-4 py-3 border border-border rounded-xl bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary"
                  />
                </div>
                <div>
                  <label class="block text-sm font-medium text-foreground mb-2">
                    City *
                  </label>
                  <input
                    v-model="formData.city"
                    type="text"
                    placeholder="Enter your city"
                    required
                    class="w-full px-4 py-3 border border-border rounded-xl bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary"
                  />
                </div>
                <div>
                  <label class="block text-sm font-medium text-foreground mb-2">
                    State *
                  </label>
                  <input
                    v-model="formData.state"
                    type="text"
                    placeholder="Enter your state"
                    required
                    class="w-full px-4 py-3 border border-border rounded-xl bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary"
                  />
                </div>
                <div>
                  <label class="block text-sm font-medium text-foreground mb-2">
                    Pincode *
                  </label>
                  <input
                    v-model="formData.pincode"
                    type="text"
                    placeholder="Enter your pincode"
                    required
                    class="w-full px-4 py-3 border border-border rounded-xl bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary"
                  />
                </div>
              </div>
            </div>

            <!-- Payment Information -->
            <div class="bg-white rounded-2xl p-6 border border-border shadow-sm">
              <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 bg-primary/10 rounded-xl flex items-center justify-center">
                  <CreditCard :size="20" class="text-primary" />
                </div>
                <h2 class="text-2xl font-bold text-foreground">
                  Payment Information
                </h2>
              </div>

              <!-- Payment Method Selection -->
              <div class="mb-6">
                <label class="block text-sm font-medium text-foreground mb-3">
                  Payment Method
                </label>
                <div class="grid grid-cols-2 gap-3">
                  <button
                    type="button"
                    @click="paymentMethod = 'card'"
                    :class="[
                      'p-4 rounded-xl border-2 transition-all',
                      paymentMethod === 'card'
                        ? 'border-primary bg-primary/5'
                        : 'border-border hover:border-primary/50'
                    ]"
                  >
                    <div class="flex items-center gap-2">
                      <CreditCard :size="20" />
                      <span class="font-medium">Card</span>
                    </div>
                  </button>
                  <button
                    type="button"
                    @click="paymentMethod = 'upi'"
                    :class="[
                      'p-4 rounded-xl border-2 transition-all',
                      paymentMethod === 'upi'
                        ? 'border-primary bg-primary/5'
                        : 'border-border hover:border-primary/50'
                    ]"
                  >
                    <div class="flex items-center gap-2">
                      <div class="w-5 h-5 bg-primary rounded"></div>
                      <span class="font-medium">UPI</span>
                    </div>
                  </button>
                </div>
              </div>

              <!-- Demo Payment Notice -->
              <div class="bg-secondary/10 border border-secondary/20 rounded-xl p-4 mb-6">
                <div class="flex items-center gap-2 mb-2">
                  <Shield :size="16" class="text-secondary" />
                  <span class="text-sm font-medium text-secondary">
                    Secure Demo Checkout
                  </span>
                </div>
                <p class="text-sm text-muted-foreground">
                  This is a demonstration checkout. In production, we'll integrate with Razorpay or PayPal for secure payments.
                </p>
              </div>

              <!-- Card Payment Form -->
              <div v-if="paymentMethod === 'card'" class="space-y-4">
                <div>
                  <label class="block text-sm font-medium text-foreground mb-2">
                    Card Number
                  </label>
                  <input
                    type="text"
                    placeholder="1234 5678 9012 3456"
                    value="4242 4242 4242 4242"
                    class="w-full px-4 py-3 border border-border rounded-xl bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary"
                  />
                </div>
                <div class="grid grid-cols-2 gap-4">
                  <div>
                    <label class="block text-sm font-medium text-foreground mb-2">
                      Expiry Date
                    </label>
                    <input
                      type="text"
                      placeholder="MM/YY"
                      value="12/25"
                      class="w-full px-4 py-3 border border-border rounded-xl bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary"
                    />
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-foreground mb-2">
                      CVV
                    </label>
                    <input
                      type="text"
                      placeholder="123"
                      value="123"
                      class="w-full px-4 py-3 border border-border rounded-xl bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary"
                    />
                  </div>
                </div>
              </div>

              <!-- UPI Payment -->
              <div v-if="paymentMethod === 'upi'" class="space-y-4">
                <div>
                  <label class="block text-sm font-medium text-foreground mb-2">
                    UPI ID
                  </label>
                  <input
                    type="text"
                    placeholder="yourname@paytm"
                    class="w-full px-4 py-3 border border-border rounded-xl bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary"
                  />
                </div>
                <div class="bg-background rounded-xl p-4">
                  <p class="text-sm text-muted-foreground">
                    You'll be redirected to your UPI app to complete the payment.
                  </p>
                </div>
              </div>
            </div>

            <!-- Security Notice -->
            <div class="bg-background rounded-xl p-4 flex items-center gap-3">
              <Lock :size="20" class="text-secondary" />
              <p class="text-sm text-muted-foreground">
                Your payment information is encrypted and secure. We never store your card details.
              </p>
            </div>

            <Button
              type="submit"
              :disabled="isProcessing"
              class="w-full bg-primary hover:bg-primary/90 text-white rounded-xl py-4 text-lg font-semibold shadow-lg hover:shadow-xl transition-all duration-300 disabled:opacity-50"
            >
              <div v-if="isProcessing" class="flex items-center gap-2 justify-center">
                <div class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
                Processing Payment...
              </div>
              <span v-else>Pay ₹{{ total }}</span>
            </Button>
          </form>
        </div>

        <!-- Order Summary -->
        <div class="bg-white rounded-2xl p-6 border border-border shadow-sm h-fit sticky top-8">
          <h2 class="text-2xl font-bold text-foreground mb-6">
            Order Summary
          </h2>

          <div class="space-y-3 mb-6 pb-6 border-b border-border max-h-64 overflow-y-auto">
            <div v-for="item in cartItems" :key="item.id" class="flex items-center gap-3">
              <img
                :src="item.image || '/placeholder.svg'"
                :alt="item.name"
                class="w-12 h-12 object-cover rounded-lg"
              />
              <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-foreground line-clamp-1">
                  {{ item.name }}
                </p>
                <p class="text-xs text-muted-foreground">
                  Qty: {{ item.quantity }}
                </p>
              </div>
              <span class="font-semibold text-sm">
                ₹{{ item.price * item.quantity }}
              </span>
            </div>
          </div>

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

          <!-- Security Badge -->
          <div class="flex items-center justify-center gap-2 text-sm text-muted-foreground pt-4 border-t border-border">
            <Lock :size="16" class="text-secondary" />
            <span>Secure SSL Encrypted</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ArrowLeft, CreditCard, Shield, Truck, CheckCircle, Lock } from 'lucide-vue-next'
import Button from '@/components/ui/Button.vue'
import { useCartStore } from '@/stores/cart'

export default {
  name: 'Checkout',
  
  components: {
    ArrowLeft,
    CreditCard,
    Shield,
    Truck,
    CheckCircle,
    Lock,
    Button
  },
  
  data() {
    return {
      formData: {
        firstName: '',
        lastName: '',
        email: '',
        phone: '',
        address: '',
        city: '',
        state: '',
        pincode: ''
      },
      paymentMethod: 'card',
      isProcessing: false,
      orderPlaced: false,
      orderId: ''
    }
  },
  
  computed: {
    cartItems() {
      const cartStore = useCartStore()
      return cartStore.items
    },
    
    subtotal() {
      return this.cartItems.reduce((sum, item) => sum + item.price * item.quantity, 0)
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
    async handleSubmit() {
      this.isProcessing = true
      
      // Simulate payment processing
      await new Promise(resolve => setTimeout(resolve, 3000))
      
      // Generate order ID
      this.orderId = Date.now().toString().slice(-8)
      
      // Clear cart
      const cartStore = useCartStore()
      cartStore.clearCart()
      
      // Show success
      this.orderPlaced = true
      this.isProcessing = false
    }
  }
}
</script>
