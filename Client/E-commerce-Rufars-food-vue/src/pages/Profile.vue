<template>
  <div class="min-h-screen bg-gray-50">
    <Header />
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <!-- Profile Header -->
      <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
        <div class="flex flex-col md:flex-row items-start md:items-center gap-6">
          <!-- Avatar -->
          <div class="relative">
            <div class="w-24 h-24 bg-primary rounded-full flex items-center justify-center text-3xl font-bold text-white">
              {{ userInitials }}
            </div>
            <button class="absolute bottom-0 right-0 w-8 h-8 bg-white rounded-full shadow-lg flex items-center justify-center border-2 border-gray-200 hover:bg-gray-50">
              <Camera :size="16" class="text-gray-600" />
            </button>
          </div>
          
          <!-- User Info -->
          <div class="flex-1">
            <h1 class="text-2xl font-bold text-gray-900">{{ user.name }}</h1>
            <p class="text-gray-600">{{ user.email }}</p>
            <div class="flex items-center gap-4 mt-2">
              <span class="text-sm text-gray-600 flex items-center gap-1">
                <Phone :size="14" />
                {{ user.phone }}
              </span>
              <span class="text-sm text-gray-600 flex items-center gap-1">
                <MapPin :size="14" />
                {{ user.location }}
              </span>
            </div>
          </div>
          
          <!-- Edit Button -->
          <button 
            @click="showEditModal = true"
            class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 flex items-center gap-2"
          >
            <Edit2 :size="16" />
            Edit Profile
          </button>
        </div>
      </div>

      <!-- Tabs -->
      <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6">
        <div class="border-b border-gray-200">
          <nav class="flex -mb-px">
            <button
              v-for="tab in tabs"
              :key="tab.id"
              @click="activeTab = tab.id"
              :class="[
                'flex items-center gap-2 px-6 py-4 text-sm font-medium border-b-2 transition-colors',
                activeTab === tab.id
                  ? 'border-primary text-primary'
                  : 'border-transparent text-gray-600 hover:text-gray-900 hover:border-gray-300'
              ]"
            >
              <component :is="tab.icon" :size="18" />
              {{ tab.label }}
            </button>
          </nav>
        </div>

        <!-- Tab Content -->
        <div class="p-6">
          <!-- Orders Tab -->
          <div v-if="activeTab === 'orders'">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Order History</h2>
            
            <div v-if="userOrders.length === 0" class="text-center py-12">
              <ShoppingBag :size="48" class="mx-auto text-gray-400 mb-4" />
              <p class="text-gray-600">No orders yet</p>
              <router-link to="/" class="inline-block mt-4 px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary/90">
                Start Shopping
              </router-link>
            </div>

            <div v-else class="space-y-4">
              <div
                v-for="order in userOrders"
                :key="order.id"
                class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow"
              >
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-4">
                  <div>
                    <h3 class="font-semibold text-gray-900">{{ order.orderNumber }}</h3>
                    <p class="text-sm text-gray-600">{{ formatDate(order.date) }}</p>
                  </div>
                  <div class="flex items-center gap-4">
                    <span
                      :class="[
                        'px-3 py-1 text-xs rounded-full font-medium',
                        order.status === 'delivered' ? 'bg-green-100 text-green-700' :
                        order.status === 'shipped' ? 'bg-blue-100 text-blue-700' :
                        order.status === 'processing' ? 'bg-yellow-100 text-yellow-700' :
                        'bg-gray-100 text-gray-700'
                      ]"
                    >
                      {{ order.status }}
                    </span>
                    <span class="font-semibold text-gray-900">₹{{ order.total.toFixed(2) }}</span>
                  </div>
                </div>
                
                <div class="space-y-2">
                  <div
                    v-for="item in order.items"
                    :key="item.id"
                    class="flex items-center gap-3"
                  >
                    <img :src="item.image" :alt="item.name" class="w-12 h-12 rounded-lg object-cover" />
                    <div class="flex-1">
                      <p class="text-sm font-medium text-gray-900">{{ item.name }}</p>
                      <p class="text-xs text-gray-600">Qty: {{ item.quantity }} × ₹{{ item.price }}</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Addresses Tab -->
          <div v-if="activeTab === 'addresses'">
            <div class="flex items-center justify-between mb-4">
              <h2 class="text-lg font-bold text-gray-900">Saved Addresses</h2>
              <button 
                @click="showAddressModal = true"
                class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 flex items-center gap-2"
              >
                <Plus :size="16" />
                Add Address
              </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div
                v-for="address in addresses"
                :key="address.id"
                class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow"
              >
                <div class="flex items-start justify-between mb-2">
                  <div>
                    <h3 class="font-semibold text-gray-900">{{ address.label }}</h3>
                    <span
                      v-if="address.isDefault"
                      class="inline-block px-2 py-1 text-xs bg-primary/10 text-primary rounded mt-1"
                    >
                      Default
                    </span>
                  </div>
                  <button class="p-1 hover:bg-gray-100 rounded">
                    <MoreVertical :size="16" class="text-gray-600" />
                  </button>
                </div>
                <p class="text-sm text-gray-600">{{ address.street }}</p>
                <p class="text-sm text-gray-600">{{ address.city }}, {{ address.state }} {{ address.zip }}</p>
                <p class="text-sm text-gray-600">{{ address.country }}</p>
              </div>
            </div>
          </div>

          <!-- Payment Methods Tab -->
          <div v-if="activeTab === 'payments'">
            <div class="flex items-center justify-between mb-4">
              <h2 class="text-lg font-bold text-gray-900">Payment Methods</h2>
              <button 
                @click="showPaymentModal = true"
                class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 flex items-center gap-2"
              >
                <Plus :size="16" />
                Add Payment Method
              </button>
            </div>

            <div class="space-y-4">
              <div
                v-for="payment in paymentMethods"
                :key="payment.id"
                class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow"
              >
                <div class="flex items-center justify-between">
                  <div class="flex items-center gap-3">
                    <div class="w-12 h-8 bg-gray-100 rounded flex items-center justify-center">
                      <CreditCard :size="20" class="text-gray-600" />
                    </div>
                    <div>
                      <p class="font-medium text-gray-900">{{ payment.type }}</p>
                      <p class="text-sm text-gray-600">•••• •••• •••• {{ payment.last4 }}</p>
                    </div>
                  </div>
                  <div class="flex items-center gap-2">
                    <span
                      v-if="payment.isDefault"
                      class="px-2 py-1 text-xs bg-primary/10 text-primary rounded"
                    >
                      Default
                    </span>
                    <button class="p-1 hover:bg-gray-100 rounded">
                      <MoreVertical :size="16" class="text-gray-600" />
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Settings Tab -->
          <div v-if="activeTab === 'settings'">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Account Settings</h2>
            
            <div class="space-y-6">
              <!-- Change Password -->
              <div class="border border-gray-200 rounded-lg p-4">
                <h3 class="font-semibold text-gray-900 mb-4">Change Password</h3>
                <div class="space-y-4">
                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Current Password</label>
                    <input
                      type="password"
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20"
                    />
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                    <input
                      type="password"
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20"
                    />
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Confirm New Password</label>
                    <input
                      type="password"
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20"
                    />
                  </div>
                  <button class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary/90">
                    Update Password
                  </button>
                </div>
              </div>

              <!-- Notifications -->
              <div class="border border-gray-200 rounded-lg p-4">
                <h3 class="font-semibold text-gray-900 mb-4">Notification Preferences</h3>
                <div class="space-y-3">
                  <label class="flex items-center gap-3">
                    <input type="checkbox" checked class="w-4 h-4 text-primary rounded" />
                    <span class="text-sm text-gray-700">Order updates</span>
                  </label>
                  <label class="flex items-center gap-3">
                    <input type="checkbox" checked class="w-4 h-4 text-primary rounded" />
                    <span class="text-sm text-gray-700">Promotional emails</span>
                  </label>
                  <label class="flex items-center gap-3">
                    <input type="checkbox" class="w-4 h-4 text-primary rounded" />
                    <span class="text-sm text-gray-700">SMS notifications</span>
                  </label>
                </div>
              </div>

              <!-- Delete Account -->
              <div class="border border-red-200 rounded-lg p-4 bg-red-50">
                <h3 class="font-semibold text-red-900 mb-2">Delete Account</h3>
                <p class="text-sm text-red-700 mb-4">Once you delete your account, there is no going back.</p>
                <button class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                  Delete Account
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Edit Profile Modal -->
    <div v-if="showEditModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
      <div class="bg-white rounded-xl p-6 max-w-md w-full">
        <h3 class="text-xl font-bold text-gray-900 mb-4">Edit Profile</h3>
        <div class="space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
            <input
              v-model="editForm.name"
              type="text"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20"
            />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
            <input
              v-model="editForm.email"
              type="email"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20"
            />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
            <input
              v-model="editForm.phone"
              type="tel"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20"
            />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Location</label>
            <input
              v-model="editForm.location"
              type="text"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20"
            />
          </div>
          <div class="flex gap-3 pt-4">
            <button 
              @click="showEditModal = false"
              class="flex-1 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50"
            >
              Cancel
            </button>
            <button 
              @click="saveProfile"
              class="flex-1 px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90"
            >
              Save Changes
            </button>
          </div>
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
  Camera,
  Phone,
  MapPin,
  Edit2,
  ShoppingBag,
  MapPinIcon,
  CreditCard,
  Settings,
  Plus,
  MoreVertical
} from 'lucide-vue-next'

export default {
  name: 'Profile',
  
  components: {
    Header,
    Footer,
    Camera,
    Phone,
    MapPin,
    Edit2,
    ShoppingBag,
    MapPinIcon,
    CreditCard,
    Settings,
    Plus,
    MoreVertical
  },
  
  data() {
    return {
      activeTab: 'orders',
      showEditModal: false,
      showAddressModal: false,
      showPaymentModal: false,
      
      tabs: [
        { id: 'orders', label: 'Orders', icon: 'ShoppingBag' },
        { id: 'addresses', label: 'Addresses', icon: 'MapPinIcon' },
        { id: 'payments', label: 'Payment Methods', icon: 'CreditCard' },
        { id: 'settings', label: 'Settings', icon: 'Settings' }
      ],
      
      user: {
        name: 'John Doe',
        email: 'john.doe@example.com',
        phone: '+1 (555) 123-4567',
        location: 'New York, USA'
      },
      
      editForm: {
        name: 'John Doe',
        email: 'john.doe@example.com',
        phone: '+1 (555) 123-4567',
        location: 'New York, USA'
      },
      
      userOrders: [
        {
          id: 1,
          orderNumber: 'ORD-2024-001',
          date: '2024-01-15',
          status: 'delivered',
          total: 2450,
          items: [
            { id: 1, name: 'Premium Almonds', quantity: 2, price: 599, image: 'https://images.unsplash.com/photo-1508747703725-719777637510?w=400' },
            { id: 2, name: 'Dried Apricots', quantity: 1, price: 450, image: 'https://images.unsplash.com/photo-1623065422902-30a2d299bbe4?w=400' }
          ]
        },
        {
          id: 2,
          orderNumber: 'ORD-2024-002',
          date: '2024-01-20',
          status: 'shipped',
          total: 1850,
          items: [
            { id: 3, name: 'Cashew Nuts', quantity: 1, price: 799, image: 'https://images.unsplash.com/photo-1585704032915-c3400ca199e7?w=400' }
          ]
        }
      ],
      
      addresses: [
        {
          id: 1,
          label: 'Home',
          street: '123 Main Street, Apt 4B',
          city: 'New York',
          state: 'NY',
          zip: '10001',
          country: 'USA',
          isDefault: true
        },
        {
          id: 2,
          label: 'Office',
          street: '456 Business Ave, Suite 200',
          city: 'New York',
          state: 'NY',
          zip: '10002',
          country: 'USA',
          isDefault: false
        }
      ],
      
      paymentMethods: [
        {
          id: 1,
          type: 'Visa',
          last4: '4242',
          isDefault: true
        },
        {
          id: 2,
          type: 'Mastercard',
          last4: '8888',
          isDefault: false
        }
      ]
    }
  },
  
  computed: {
    userInitials() {
      return this.user.name
        .split(' ')
        .map(n => n[0])
        .join('')
        .toUpperCase()
    }
  },
  
  methods: {
    formatDate(dateString) {
      const date = new Date(dateString)
      return date.toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' })
    },
    
    saveProfile() {
      this.user = { ...this.editForm }
      this.showEditModal = false
    }
  }
}
</script>
