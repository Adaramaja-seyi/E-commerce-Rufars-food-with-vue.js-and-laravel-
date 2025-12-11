<template>
  <div class="min-h-screen bg-gray-50">
    <Header />
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
      <!-- Page Header -->
      <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">Help & Support</h1>
        <p class="text-lg text-gray-600 max-w-2xl mx-auto">
          We're here to help! Find answers to common questions or get in touch with our support team.
        </p>
      </div>

      <!-- Search Bar -->
      <div class="max-w-2xl mx-auto mb-12">
        <div class="relative">
          <input
            v-model="searchQuery"
            type="text"
            placeholder="Search for help..."
            class="w-full px-6 py-4 pl-12 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary shadow-sm"
          />
          <Search class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" />
        </div>
      </div>

      <!-- Quick Actions -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
        <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-shadow cursor-pointer">
          <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center mb-4">
            <MessageCircle :size="24" class="text-primary" />
          </div>
          <h3 class="text-lg font-bold text-gray-900 mb-2">Live Chat</h3>
          <p class="text-sm text-gray-600 mb-4">Chat with our support team in real-time</p>
          <button class="text-primary font-medium text-sm hover:underline">Start Chat →</button>
        </div>

        <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-shadow cursor-pointer">
          <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center mb-4">
            <Mail :size="24" class="text-primary" />
          </div>
          <h3 class="text-lg font-bold text-gray-900 mb-2">Email Support</h3>
          <p class="text-sm text-gray-600 mb-4">Send us an email and we'll respond within 24 hours</p>
          <a href="mailto:support@rufarsfoods.com" class="text-primary font-medium text-sm hover:underline">
            support@rufarsfoods.com →
          </a>
        </div>

        <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-shadow cursor-pointer">
          <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center mb-4">
            <Phone :size="24" class="text-primary" />
          </div>
          <h3 class="text-lg font-bold text-gray-900 mb-2">Phone Support</h3>
          <p class="text-sm text-gray-600 mb-4">Call us Monday-Friday, 9AM-6PM EST</p>
          <a href="tel:+15551234567" class="text-primary font-medium text-sm hover:underline">
            +1 (555) 123-4567 →
          </a>
        </div>
      </div>

      <!-- FAQ Section -->
      <div class="bg-white rounded-xl p-8 border border-gray-200 mb-12">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Frequently Asked Questions</h2>
        
        <div class="space-y-4">
          <div
            v-for="(faq, index) in filteredFaqs"
            :key="index"
            class="border border-gray-200 rounded-lg overflow-hidden"
          >
            <button
              @click="toggleFaq(index)"
              class="w-full flex items-center justify-between p-4 text-left hover:bg-gray-50 transition-colors"
            >
              <span class="font-semibold text-gray-900">{{ faq.question }}</span>
              <ChevronDown
                :class="['w-5 h-5 text-gray-600 transition-transform', activeFaq === index && 'transform rotate-180']"
              />
            </button>
            <div
              v-if="activeFaq === index"
              class="px-4 pb-4 text-gray-600"
            >
              {{ faq.answer }}
            </div>
          </div>
        </div>
      </div>

      <!-- Help Categories -->
      <div class="mb-12">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Browse by Category</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
          <div
            v-for="category in helpCategories"
            :key="category.id"
            class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-shadow cursor-pointer"
          >
            <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center mb-4">
              <component :is="category.icon" :size="24" class="text-primary" />
            </div>
            <h3 class="font-bold text-gray-900 mb-2">{{ category.title }}</h3>
            <p class="text-sm text-gray-600 mb-3">{{ category.description }}</p>
            <span class="text-primary text-sm font-medium">{{ category.articles }} articles →</span>
          </div>
        </div>
      </div>

      <!-- Contact Form -->
      <div class="bg-white rounded-xl p-8 border border-gray-200">
        <h2 class="text-2xl font-bold text-gray-900 mb-2">Still Need Help?</h2>
        <p class="text-gray-600 mb-6">Fill out the form below and our team will get back to you as soon as possible.</p>
        
        <form @submit.prevent="submitForm" class="space-y-6">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Name *</label>
              <input
                v-model="contactForm.name"
                type="text"
                required
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary"
                placeholder="Your name"
              />
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
              <input
                v-model="contactForm.email"
                type="email"
                required
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary"
                placeholder="your@email.com"
              />
            </div>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Subject *</label>
            <input
              v-model="contactForm.subject"
              type="text"
              required
              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary"
              placeholder="How can we help?"
            />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Category *</label>
            <select
              v-model="contactForm.category"
              required
              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary"
            >
              <option value="">Select a category</option>
              <option value="orders">Orders & Shipping</option>
              <option value="products">Products & Quality</option>
              <option value="account">Account & Billing</option>
              <option value="technical">Technical Issues</option>
              <option value="other">Other</option>
            </select>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Message *</label>
            <textarea
              v-model="contactForm.message"
              required
              rows="6"
              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary"
              placeholder="Please describe your issue in detail..."
            ></textarea>
          </div>

          <button
            type="submit"
            class="w-full md:w-auto px-8 py-3 bg-primary text-white rounded-lg hover:bg-primary/90 font-medium transition-colors"
          >
            Submit Request
          </button>
        </form>
      </div>

      <!-- Additional Resources -->
      <div class="mt-12 bg-primary/5 rounded-xl p-8 border border-primary/20">
        <div class="flex flex-col md:flex-row items-center justify-between gap-6">
          <div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Need Immediate Assistance?</h3>
            <p class="text-gray-600">Our support team is available 24/7 to help you with urgent matters.</p>
          </div>
          <button class="px-6 py-3 bg-primary text-white rounded-lg hover:bg-primary/90 font-medium whitespace-nowrap">
            Contact Support Now
          </button>
        </div>
      </div>
    </div>

    <Footer />
  </div>
</template>

<script>
import Header from '@/components/Header.vue'
import Footer from '@/components/Footer.vue'
import {
  Search,
  MessageCircle,
  Mail,
  Phone,
  ChevronDown,
  ShoppingBag,
  Package,
  CreditCard,
  Settings,
  HelpCircle,
  Truck
} from 'lucide-vue-next'

export default {
  name: 'Help',
  
  components: {
    Header,
    Footer,
    Search,
    MessageCircle,
    Mail,
    Phone,
    ChevronDown,
    ShoppingBag,
    Package,
    CreditCard,
    Settings,
    HelpCircle,
    Truck
  },
  
  data() {
    return {
      searchQuery: '',
      activeFaq: null,
      
      contactForm: {
        name: '',
        email: '',
        subject: '',
        category: '',
        message: ''
      },
      
      faqs: [
        {
          question: 'How do I track my order?',
          answer: 'You can track your order by logging into your account and visiting the Orders section. You will find tracking information for all your orders there. You will also receive tracking updates via email.',
          category: 'orders'
        },
        {
          question: 'What is your return policy?',
          answer: 'We offer a 30-day return policy for all unopened products. If you are not satisfied with your purchase, you can return it within 30 days for a full refund. Please contact our support team to initiate a return.',
          category: 'orders'
        },
        {
          question: 'How long does shipping take?',
          answer: 'Standard shipping typically takes 3-5 business days. Express shipping is available and takes 1-2 business days. International shipping times vary by location.',
          category: 'orders'
        },
        {
          question: 'Are your products organic?',
          answer: 'Yes, all our products are 100% organic and sourced from certified organic farms. We ensure the highest quality standards for all our dried fruits, nuts, and superfoods.',
          category: 'products'
        },
        {
          question: 'Do you offer bulk discounts?',
          answer: 'Yes, we offer discounts on bulk orders. Please contact our sales team at sales@rufarsfoods.com for bulk pricing information.',
          category: 'products'
        },
        {
          question: 'How do I update my payment information?',
          answer: 'You can update your payment information by logging into your account and navigating to Profile > Payment Methods. From there, you can add, edit, or remove payment methods.',
          category: 'account'
        },
        {
          question: 'What payment methods do you accept?',
          answer: 'We accept all major credit cards (Visa, Mastercard, American Express), debit cards, and PayPal. All transactions are secure and encrypted.',
          category: 'account'
        },
        {
          question: 'How do I cancel my order?',
          answer: 'Orders can be cancelled within 1 hour of placement. After that, the order is processed and cannot be cancelled. Please contact support immediately if you need to cancel an order.',
          category: 'orders'
        }
      ],
      
      helpCategories: [
        {
          id: 1,
          title: 'Orders & Shipping',
          description: 'Track orders, shipping info, and delivery',
          icon: 'Truck',
          articles: 12
        },
        {
          id: 2,
          title: 'Products',
          description: 'Product information and quality',
          icon: 'Package',
          articles: 8
        },
        {
          id: 3,
          title: 'Account & Billing',
          description: 'Manage your account and payments',
          icon: 'CreditCard',
          articles: 10
        },
        {
          id: 4,
          title: 'Technical Support',
          description: 'Website issues and troubleshooting',
          icon: 'Settings',
          articles: 6
        }
      ]
    }
  },
  
  computed: {
    filteredFaqs() {
      if (!this.searchQuery) return this.faqs
      
      const query = this.searchQuery.toLowerCase()
      return this.faqs.filter(faq => 
        faq.question.toLowerCase().includes(query) ||
        faq.answer.toLowerCase().includes(query)
      )
    }
  },
  
  methods: {
    toggleFaq(index) {
      this.activeFaq = this.activeFaq === index ? null : index
    },
    
    submitForm() {
      // Handle form submission
      alert('Thank you for contacting us! We will get back to you within 24 hours.')
      
      // Reset form
      this.contactForm = {
        name: '',
        email: '',
        subject: '',
        category: '',
        message: ''
      }
    }
  }
}
</script>
