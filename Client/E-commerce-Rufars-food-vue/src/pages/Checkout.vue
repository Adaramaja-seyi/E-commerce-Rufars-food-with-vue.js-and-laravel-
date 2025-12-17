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
                    @click="paymentMethod = 'paystack'"
                    :class="[
                      'p-4 rounded-xl border-2 transition-all',
                      paymentMethod === 'paystack'
                        ? 'border-primary bg-primary/5'
                        : 'border-border hover:border-primary/50'
                    ]"
                  >
                    <div class="flex items-center gap-2">
                      <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M20.5 12c0 4.7-3.8 8.5-8.5 8.5S3.5 16.7 3.5 12 7.3 3.5 12 3.5s8.5 3.8 8.5 8.5z"/>
                        <path fill="white" d="M12 7v10M7 12h10"/>
                      </svg>
                      <span class="font-medium">Paystack</span>
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
                  This is a demonstration checkout. Card payments are simulated. Paystack integration is ready for production use.
                </p>
              </div>

              <!-- Card Payment Form -->
              <div v-if="paymentMethod === 'card'" class="space-y-4">
                <div>
                  <label class="block text-sm font-medium text-foreground mb-2">
                    Cardholder Name *
                  </label>
                  <input
                    v-model="cardData.cardholderName"
                    type="text"
                    placeholder="Enter name on card"
                    class="w-full px-4 py-3 border border-border rounded-xl bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary"
                  />
                  <p v-if="cardholderNameError" class="text-xs text-red-600 mt-1">
                    {{ cardholderNameError }}
                  </p>
                </div>
                
                <div>
                  <label class="block text-sm font-medium text-foreground mb-2">
                    Card Number *
                  </label>
                  <div class="relative">
                    <input
                      v-model="cardData.cardNumber"
                      type="text"
                      placeholder="1234 5678 9012 3456"
                      maxlength="19"
                      @input="formatCardNumber"
                      class="w-full px-4 py-3 border border-border rounded-xl bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary"
                    />
                    <div v-if="detectedCardType" class="absolute right-3 top-1/2 -translate-y-1/2">
                      <span class="text-sm font-medium text-primary">{{ detectedCardType }}</span>
                    </div>
                  </div>
                  <p class="text-xs text-muted-foreground mt-1">
                    Demo: Use 4242 4242 4242 4242 (Visa) or 5555 5555 5555 4444 (Mastercard)
                  </p>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                  <div>
                    <label class="block text-sm font-medium text-foreground mb-2">
                      Expiry Date *
                    </label>
                    <input
                      v-model="cardData.expiryDate"
                      type="text"
                      placeholder="MM/YY"
                      maxlength="5"
                      @input="formatExpiryDate"
                      class="w-full px-4 py-3 border border-border rounded-xl bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary"
                    />
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-foreground mb-2">
                      CVV *
                    </label>
                    <input
                      v-model="cardData.cvv"
                      type="text"
                      placeholder="123"
                      maxlength="4"
                      @input="formatCVV"
                      class="w-full px-4 py-3 border border-border rounded-xl bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary"
                    />
                  </div>
                </div>
              </div>

              <!-- Paystack Payment -->
              <div v-if="paymentMethod === 'paystack'" class="space-y-4">
                <div class="bg-gradient-to-br from-primary/5 to-secondary/5 rounded-xl p-6 border border-primary/20">
                  <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 bg-primary rounded-xl flex items-center justify-center">
                      <svg class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M20.5 12c0 4.7-3.8 8.5-8.5 8.5S3.5 16.7 3.5 12 7.3 3.5 12 3.5s8.5 3.8 8.5 8.5z"/>
                      </svg>
                    </div>
                    <div>
                      <h4 class="font-bold text-foreground">Paystack Payment</h4>
                      <p class="text-sm text-muted-foreground">Secure payment gateway</p>
                    </div>
                  </div>
                  
                  <div class="space-y-3 mb-4">
                    <div class="flex items-center gap-2 text-sm text-foreground">
                      <svg class="w-4 h-4 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                      </svg>
                      <span>Pay with card, bank transfer, or mobile money</span>
                    </div>
                    <div class="flex items-center gap-2 text-sm text-foreground">
                      <svg class="w-4 h-4 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                      </svg>
                      <span>Secure and encrypted transactions</span>
                    </div>
                    <div class="flex items-center gap-2 text-sm text-foreground">
                      <svg class="w-4 h-4 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                      </svg>
                      <span>Instant payment confirmation</span>
                    </div>
                  </div>
                  
                  <div class="bg-white/50 rounded-lg p-4">
                    <p class="text-sm text-muted-foreground">
                      <strong class="text-foreground">Demo Mode:</strong> When you click "Pay", you'll be redirected to Paystack's secure payment page. In production, this will process real payments.
                    </p>
                  </div>
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
import { useToast } from 'vue-toastification'

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
      cardData: {
        cardholderName: '',
        cardNumber: '',
        expiryDate: '',
        cvv: ''
      },
      paymentMethod: 'card',
      isProcessing: false,
      orderPlaced: false,
      orderId: '',
      detectedCardType: '',
      cardholderNameError: ''
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
  
  async mounted() {
    // Pre-fill form with user data if logged in
    const { useAuthStore } = await import('@/stores/auth')
    const authStore = useAuthStore()
    
    // Fetch latest user data from server
    if (authStore.isAuthenticated) {
      await authStore.fetchUser()
      
      if (authStore.user) {
        this.formData.firstName = authStore.user.name?.split(' ')[0] || ''
        this.formData.lastName = authStore.user.name?.split(' ').slice(1).join(' ') || ''
        this.formData.email = authStore.user.email || ''
        this.formData.phone = authStore.user.phone || ''
        this.formData.address = authStore.user.address || ''
        this.formData.city = authStore.user.city || ''
        this.formData.state = authStore.user.state || ''
        this.formData.pincode = authStore.user.pincode || ''
        
        // Pre-fill cardholder name with user's full name
        this.cardData.cardholderName = authStore.user.name || ''
      }
    }
  },
  
  methods: {
    detectCardType(cardNumber) {
      const number = cardNumber.replace(/\s/g, '')
      
      // Visa: starts with 4
      if (/^4/.test(number)) {
        return 'Visa'
      }
      // Mastercard: starts with 51-55 or 2221-2720
      if (/^5[1-5]/.test(number) || /^2(2[2-9][0-9]|[3-6][0-9]{2}|7[0-1][0-9]|720)/.test(number)) {
        return 'Mastercard'
      }
      // American Express: starts with 34 or 37
      if (/^3[47]/.test(number)) {
        return 'American Express'
      }
      // Discover: starts with 6011, 622126-622925, 644-649, or 65
      if (/^6011|^622[1-9]|^64[4-9]|^65/.test(number)) {
        return 'Discover'
      }
      
      return ''
    },
    
    formatCardNumber(event) {
      let value = event.target.value.replace(/\s/g, '')
      value = value.replace(/\D/g, '')
      const parts = value.match(/.{1,4}/g)
      this.cardData.cardNumber = parts ? parts.join(' ') : value
      
      // Detect card type
      this.detectedCardType = this.detectCardType(value)
    },
    
    formatExpiryDate(event) {
      let value = event.target.value.replace(/\D/g, '')
      if (value.length >= 2) {
        value = value.slice(0, 2) + '/' + value.slice(2, 4)
      }
      this.cardData.expiryDate = value
    },
    
    formatCVV(event) {
      this.cardData.cvv = event.target.value.replace(/\D/g, '')
    },
    
    validateCardholderName() {
      const fullName = `${this.formData.firstName} ${this.formData.lastName}`.trim().toLowerCase()
      const cardholderName = this.cardData.cardholderName.trim().toLowerCase()
      
      if (!cardholderName) {
        this.cardholderNameError = 'Cardholder name is required'
        return false
      }
      
      // Check if names match (allow some flexibility)
      if (cardholderName !== fullName) {
        // Check if cardholder name contains at least first or last name
        const firstName = this.formData.firstName.toLowerCase()
        const lastName = this.formData.lastName.toLowerCase()
        
        if (!cardholderName.includes(firstName) && !cardholderName.includes(lastName)) {
          this.cardholderNameError = `Cardholder name should match your name: ${this.formData.firstName} ${this.formData.lastName}`
          return false
        }
      }
      
      this.cardholderNameError = ''
      return true
    },
    
    validatePaymentDetails() {
      if (this.paymentMethod === 'card') {
        // Validate cardholder name
        if (!this.validateCardholderName()) {
          return this.cardholderNameError
        }
        
        const cardNumber = this.cardData.cardNumber.replace(/\s/g, '')
        if (!cardNumber || cardNumber.length < 13) {
          return 'Please enter a valid card number'
        }
        if (!this.detectedCardType) {
          return 'Please enter a valid card number from a supported card type'
        }
        if (!this.cardData.expiryDate || this.cardData.expiryDate.length !== 5) {
          return 'Please enter a valid expiry date (MM/YY)'
        }
        if (!this.cardData.cvv || this.cardData.cvv.length < 3) {
          return 'Please enter a valid CVV'
        }
      } else if (this.paymentMethod === 'paystack') {
        // Paystack validation - no additional fields needed
        // Payment will be processed through Paystack popup
        return null
      }
      return null
    },
    
    initializePaystack() {
      const toast = useToast()
      
      // Check if PaystackPop is loaded
      if (typeof window.PaystackPop === 'undefined') {
        toast.error('Paystack is not loaded. Please refresh the page and try again.')
        this.isProcessing = false
        console.error('PaystackPop is not defined. Make sure the Paystack script is loaded in index.html')
        return
      }
      
      try {
        // Convert amount to kobo (Paystack uses kobo, 1 Naira = 100 kobo)
        const amountInKobo = this.total * 100
        
        const handler = window.PaystackPop.setup({
          key: import.meta.env.VITE_PAYSTACK_PUBLIC_KEY || 'pk_test_4830c11209bb97f1390dfe6694a96b93b1839aa1',
          email: this.formData.email,
          amount: amountInKobo,
          currency: 'NGN',
          ref: 'RUF_' + Math.floor((Math.random() * 1000000000) + 1),
          metadata: {
            custom_fields: [
              {
                display_name: "Customer Name",
                variable_name: "customer_name",
                value: `${this.formData.firstName} ${this.formData.lastName}`
              },
              {
                display_name: "Phone Number",
                variable_name: "phone_number",
                value: this.formData.phone
              }
            ]
          },
          callback: (response) => {
            // Payment successful
            toast.success('Payment successful! Processing your order...')
            this.createOrder(response.reference)
          },
          onClose: () => {
            // Payment cancelled
            toast.warning('Payment cancelled')
            this.isProcessing = false
          }
        })
        
        handler.openIframe()
      } catch (error) {
        console.error('Paystack initialization error:', error)
        toast.error('Failed to initialize payment. Please try again.')
        this.isProcessing = false
      }
    },
    
    async createOrder(paymentReference = null) {
      const { useToast } = await import('vue-toastification')
      const { useAuthStore } = await import('@/stores/auth')
      const { ordersAPI } = await import('@/api')
      const toast = useToast()
      const authStore = useAuthStore()
      
      try {
        // Update user profile with shipping information
        if (authStore.isAuthenticated) {
          const profileData = {
            name: `${this.formData.firstName} ${this.formData.lastName}`,
            email: this.formData.email,
            phone: this.formData.phone,
            address: this.formData.address,
            city: this.formData.city,
            state: this.formData.state,
            pincode: this.formData.pincode
          }
          
          await authStore.updateProfile(profileData)
        }
        
        // Create order
        const orderData = {
          shipping_address: {
            name: `${this.formData.firstName} ${this.formData.lastName}`,
            email: this.formData.email,
            phone: this.formData.phone,
            address: this.formData.address,
            city: this.formData.city,
            state: this.formData.state,
            pincode: this.formData.pincode
          },
          payment_method: this.paymentMethod,
          payment_reference: paymentReference,
          notes: ''
        }
        
        const response = await ordersAPI.create(orderData)
        
        if (response.data.success) {
          this.orderId = response.data.data.id
          
          // Clear cart
          const cartStore = useCartStore()
          await cartStore.clearCart()
          
          // Show success
          this.orderPlaced = true
          toast.success('Order placed successfully!')
        } else {
          toast.error(response.data.message || 'Failed to create order')
        }
      } catch (error) {
        console.error('Order creation error:', error)
        toast.error(error.response?.data?.message || 'Failed to create order. Please try again.')
      } finally {
        this.isProcessing = false
      }
    },
    
    async handleSubmit() {
      const { useToast } = await import('vue-toastification')
      const toast = useToast()
      
      this.isProcessing = true
      
      try {
        // Validate form
        if (!this.formData.firstName || !this.formData.lastName || !this.formData.email || 
            !this.formData.phone || !this.formData.address || !this.formData.city || 
            !this.formData.state || !this.formData.pincode) {
          toast.error('Please fill in all required fields')
          this.isProcessing = false
          return
        }
        
        // Validate payment details
        const paymentError = this.validatePaymentDetails()
        if (paymentError) {
          toast.error(paymentError)
          this.isProcessing = false
          return
        }
        
        // Handle Paystack payment
        if (this.paymentMethod === 'paystack') {
          toast.info('Opening Paystack payment...')
          this.initializePaystack()
          return
        }
        
        // Handle card payment (demo mode)
        toast.info('Processing payment...')
        await this.createOrder()
        
      } catch (error) {
        console.error('Checkout error:', error)
        toast.error(error.response?.data?.message || 'Failed to process order. Please try again.')
        this.isProcessing = false
      }
    }
  }
}
</script>
