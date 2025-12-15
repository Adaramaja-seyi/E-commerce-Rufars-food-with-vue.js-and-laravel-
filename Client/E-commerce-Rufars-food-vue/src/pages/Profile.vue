<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Loading State -->
    <div v-if="loading" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <div class="flex items-center justify-center h-64">
        <div class="w-12 h-12 border-4 border-primary border-t-transparent rounded-full animate-spin"></div>
      </div>
    </div>

    <!-- Profile Content -->
    <div v-else class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <!-- Profile Header -->
      <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
        <div class="flex flex-col md:flex-row items-start md:items-center gap-6">
          <!-- Avatar -->
          <div class="relative">
            <div class="w-24 h-24 bg-primary rounded-full flex items-center justify-center text-3xl font-bold text-white">
              {{ userInitials }}
            </div>
          </div>
          
          <!-- User Info -->
          <div class="flex-1">
            <h1 class="text-2xl font-bold text-gray-900">{{ user.name || 'User' }}</h1>
            <div class="flex items-center gap-2">
              <p class="text-gray-600">{{ user.email }}</p>
              <span 
                v-if="user.email_verified"
                class="px-2 py-0.5 text-xs bg-green-100 text-green-700 rounded-full flex items-center gap-1"
              >
                <Check :size="12" />
                Verified
              </span>
            </div>
            <div class="flex items-center gap-4 mt-2">
              <span v-if="user.phone" class="text-sm text-gray-600 flex items-center gap-1">
                <Phone :size="14" />
                {{ user.phone }}
              </span>
              <span v-if="user.city" class="text-sm text-gray-600 flex items-center gap-1">
                <MapPin :size="14" />
                {{ user.city }}, {{ user.state }}
              </span>
            </div>
          </div>
          
          <!-- Edit Button -->
          <button 
            @click="openEditModal"
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
          <nav class="flex -mb-px overflow-x-auto">
            <button
              v-for="tab in tabs"
              :key="tab.id"
              @click="activeTab = tab.id"
              :class="[
                'flex items-center gap-2 px-6 py-4 text-sm font-medium border-b-2 transition-colors whitespace-nowrap',
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
            
            <div v-if="loadingOrders" class="text-center py-12">
              <div class="w-8 h-8 border-4 border-primary border-t-transparent rounded-full animate-spin mx-auto"></div>
            </div>

            <div v-else-if="userOrders.length === 0" class="text-center py-12">
              <ShoppingBag :size="48" class="mx-auto text-gray-400 mb-4" />
              <p class="text-gray-600">No orders yet</p>
              <router-link to="/products" class="inline-block mt-4 px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary/90">
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
                    <h3 class="font-semibold text-gray-900">#{{ order.id }}</h3>
                    <p class="text-sm text-gray-600">{{ formatDate(order.created_at) }}</p>
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
                    <span class="font-semibold text-gray-900">₹{{ parseFloat(order.total).toFixed(2) }}</span>
                  </div>
                </div>
                
                <div v-if="order.items && order.items.length" class="space-y-2">
                  <div
                    v-for="item in order.items"
                    :key="item.id"
                    class="flex items-center gap-3"
                  >
                    <img :src="item.product?.image || '/placeholder.svg'" :alt="item.product?.name" class="w-12 h-12 rounded-lg object-cover" />
                    <div class="flex-1">
                      <p class="text-sm font-medium text-gray-900">{{ item.product?.name }}</p>
                      <p class="text-xs text-gray-600">Qty: {{ item.quantity }} × ₹{{ parseFloat(item.price).toFixed(2) }}</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Payment History Tab -->
          <div v-if="activeTab === 'payment-history'">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Payment History</h2>
            
            <div v-if="loadingOrders" class="text-center py-12">
              <div class="w-8 h-8 border-4 border-primary border-t-transparent rounded-full animate-spin mx-auto"></div>
            </div>

            <div v-else-if="userOrders.length === 0" class="text-center py-12">
              <Receipt :size="48" class="mx-auto text-gray-400 mb-4" />
              <p class="text-gray-600">No payment history yet</p>
            </div>

            <div v-else class="space-y-4">
              <div
                v-for="order in userOrders"
                :key="order.id"
                class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow"
              >
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-3">
                  <div>
                    <h3 class="font-semibold text-gray-900">{{ order.order_number || `#${order.id}` }}</h3>
                    <p class="text-sm text-gray-600">{{ formatDate(order.created_at) }}</p>
                  </div>
                  <div class="flex items-center gap-4">
                    <span
                      :class="[
                        'px-3 py-1 text-xs rounded-full font-medium',
                        order.payment_status === 'paid' ? 'bg-green-100 text-green-700' :
                        order.payment_status === 'pending' ? 'bg-yellow-100 text-yellow-700' :
                        order.payment_status === 'failed' ? 'bg-red-100 text-red-700' :
                        'bg-gray-100 text-gray-700'
                      ]"
                    >
                      {{ order.payment_status }}
                    </span>
                    <span class="font-semibold text-gray-900">₹{{ parseFloat(order.total).toFixed(2) }}</span>
                  </div>
                </div>
                
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                  <div>
                    <p class="text-gray-600">Payment Method</p>
                    <p class="font-medium text-gray-900 capitalize">{{ order.payment_method }}</p>
                  </div>
                  <div>
                    <p class="text-gray-600">Order Status</p>
                    <p class="font-medium text-gray-900 capitalize">{{ order.status }}</p>
                  </div>
                  <div>
                    <p class="text-gray-600">Items</p>
                    <p class="font-medium text-gray-900">{{ order.items?.length || 0 }} item(s)</p>
                  </div>
                  <div>
                    <p class="text-gray-600">Transaction ID</p>
                    <p class="font-medium text-gray-900 text-xs">{{ order.order_number || `TXN-${order.id}` }}</p>
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
                @click="openAddressModal()"
                class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 flex items-center gap-2"
              >
                <Plus :size="16" />
                Add Address
              </button>
            </div>

            <div v-if="loadingAddresses" class="text-center py-12">
              <div class="w-8 h-8 border-4 border-primary border-t-transparent rounded-full animate-spin mx-auto"></div>
            </div>

            <div v-else-if="addresses.length === 0" class="text-center py-12">
              <MapPinIcon :size="48" class="mx-auto text-gray-400 mb-4" />
              <p class="text-gray-600">No saved addresses</p>
            </div>

            <div v-else class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div
                v-for="address in addresses"
                :key="address.id"
                class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow relative"
              >
                <div class="flex items-start justify-between mb-2">
                  <div>
                    <h3 class="font-semibold text-gray-900">{{ address.label || 'Address' }}</h3>
                    <span
                      v-if="address.is_default"
                      class="inline-block px-2 py-1 text-xs bg-primary/10 text-primary rounded mt-1"
                    >
                      Default
                    </span>
                  </div>
                  <div class="relative">
                    <button 
                      @click="toggleAddressMenu(address.id)"
                      class="p-1 hover:bg-gray-100 rounded"
                    >
                      <MoreVertical :size="16" class="text-gray-600" />
                    </button>
                    <div
                      v-if="activeAddressMenu === address.id"
                      class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-2 z-10"
                    >
                      <button
                        @click="openAddressModal(address)"
                        class="w-full px-4 py-2 text-left text-sm text-gray-700 hover:bg-gray-50 flex items-center gap-2"
                      >
                        <Edit2 :size="14" />
                        Edit
                      </button>
                      <button
                        v-if="!address.is_default"
                        @click="setDefaultAddress(address.id)"
                        class="w-full px-4 py-2 text-left text-sm text-gray-700 hover:bg-gray-50 flex items-center gap-2"
                      >
                        <Check :size="14" />
                        Set as Default
                      </button>
                      <button
                        @click="deleteAddress(address.id)"
                        class="w-full px-4 py-2 text-left text-sm text-red-600 hover:bg-red-50 flex items-center gap-2"
                      >
                        <Trash2 :size="14" />
                        Delete
                      </button>
                    </div>
                  </div>
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
                @click="openPaymentModal()"
                class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 flex items-center gap-2"
              >
                <Plus :size="16" />
                Add Payment Method
              </button>
            </div>

            <div v-if="loadingPayments" class="text-center py-12">
              <div class="w-8 h-8 border-4 border-primary border-t-transparent rounded-full animate-spin mx-auto"></div>
            </div>

            <div v-else-if="paymentMethods.length === 0" class="text-center py-12">
              <CreditCard :size="48" class="mx-auto text-gray-400 mb-4" />
              <p class="text-gray-600">No payment methods saved</p>
            </div>

            <div v-else class="space-y-4">
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
                      v-if="payment.is_default"
                      class="px-2 py-1 text-xs bg-primary/10 text-primary rounded"
                    >
                      Default
                    </span>
                    <div class="relative">
                      <button 
                        @click="togglePaymentMenu(payment.id)"
                        class="p-1 hover:bg-gray-100 rounded"
                      >
                        <MoreVertical :size="16" class="text-gray-600" />
                      </button>
                      <div
                        v-if="activePaymentMenu === payment.id"
                        class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-2 z-10"
                      >
                        <button
                          @click="openPaymentModal(payment)"
                          class="w-full px-4 py-2 text-left text-sm text-gray-700 hover:bg-gray-50 flex items-center gap-2"
                        >
                          <Edit2 :size="14" />
                          Edit
                        </button>
                        <button
                          v-if="!payment.is_default"
                          @click="setDefaultPayment(payment.id)"
                          class="w-full px-4 py-2 text-left text-sm text-gray-700 hover:bg-gray-50 flex items-center gap-2"
                        >
                          <Check :size="14" />
                          Set as Default
                        </button>
                        <button
                          @click="deletePayment(payment.id)"
                          class="w-full px-4 py-2 text-left text-sm text-red-600 hover:bg-red-50 flex items-center gap-2"
                        >
                          <Trash2 :size="14" />
                          Delete
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Payment History Tab -->
          <div v-if="activeTab === 'payment-history'">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Payment History</h2>
            
            <div v-if="loadingOrders" class="text-center py-12">
              <div class="w-8 h-8 border-4 border-primary border-t-transparent rounded-full animate-spin mx-auto"></div>
            </div>

            <div v-else-if="userOrders.length === 0" class="text-center py-12">
              <Receipt :size="48" class="mx-auto text-gray-400 mb-4" />
              <p class="text-gray-600">No payment history yet</p>
            </div>

            <div v-else class="space-y-4">
              <div
                v-for="order in userOrders"
                :key="order.id"
                class="border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow"
              >
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-4">
                  <div>
                    <h3 class="font-semibold text-gray-900 text-lg">{{ order.order_number }}</h3>
                    <p class="text-sm text-gray-600">{{ formatDate(order.created_at) }}</p>
                  </div>
                  <div class="flex items-center gap-4">
                    <span
                      :class="[
                        'px-3 py-1 text-xs rounded-full font-medium',
                        order.payment_status === 'paid' ? 'bg-green-100 text-green-700' :
                        order.payment_status === 'pending' ? 'bg-yellow-100 text-yellow-700' :
                        order.payment_status === 'failed' ? 'bg-red-100 text-red-700' :
                        'bg-gray-100 text-gray-700'
                      ]"
                    >
                      {{ order.payment_status }}
                    </span>
                    <span class="font-semibold text-gray-900 text-xl">₹{{ parseFloat(order.total).toFixed(2) }}</span>
                  </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-gray-50 rounded-lg p-4">
                  <div>
                    <p class="text-xs text-gray-500 mb-1">Payment Method</p>
                    <p class="font-medium text-gray-900 capitalize">{{ order.payment_method }}</p>
                  </div>
                  <div>
                    <p class="text-xs text-gray-500 mb-1">Order Status</p>
                    <p class="font-medium text-gray-900 capitalize">{{ order.status }}</p>
                  </div>
                  <div>
                    <p class="text-xs text-gray-500 mb-1">Items</p>
                    <p class="font-medium text-gray-900">{{ order.items?.length || 0 }} item(s)</p>
                  </div>
                  <div>
                    <p class="text-xs text-gray-500 mb-1">Transaction Date</p>
                    <p class="font-medium text-gray-900">{{ formatDate(order.created_at) }}</p>
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
                      v-model="passwordForm.current"
                      type="password"
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20"
                    />
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                    <input
                      v-model="passwordForm.new"
                      type="password"
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20"
                    />
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Confirm New Password</label>
                    <input
                      v-model="passwordForm.confirm"
                      type="password"
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20"
                    />
                  </div>
                  <button 
                    @click="changePassword"
                    :disabled="loadingPassword"
                    class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 disabled:opacity-50"
                  >
                    {{ loadingPassword ? 'Updating...' : 'Update Password' }}
                  </button>
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
      <div class="bg-white rounded-xl p-6 max-w-md w-full max-h-[90vh] overflow-y-auto">
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
            <label class="block text-sm font-medium text-gray-700 mb-2">Address</label>
            <input
              v-model="editForm.address"
              type="text"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20"
            />
          </div>
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">City</label>
              <input
                v-model="editForm.city"
                type="text"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20"
              />
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">State</label>
              <input
                v-model="editForm.state"
                type="text"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20"
              />
            </div>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Pincode</label>
            <input
              v-model="editForm.pincode"
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
              :disabled="loadingSave"
              class="flex-1 px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 disabled:opacity-50"
            >
              {{ loadingSave ? 'Saving...' : 'Save Changes' }}
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Address Modal -->
    <div v-if="showAddressModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
      <div class="bg-white rounded-xl p-6 max-w-md w-full max-h-[90vh] overflow-y-auto">
        <h3 class="text-xl font-bold text-gray-900 mb-4">
          {{ editingAddress ? 'Edit Address' : 'Add New Address' }}
        </h3>
        <div class="space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Label</label>
            <input
              v-model="addressForm.label"
              type="text"
              placeholder="e.g., Home, Office"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20"
            />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Street Address</label>
            <input
              v-model="addressForm.street"
              type="text"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20"
            />
          </div>
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">City</label>
              <input
                v-model="addressForm.city"
                type="text"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20"
              />
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">State</label>
              <input
                v-model="addressForm.state"
                type="text"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20"
              />
            </div>
          </div>
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">ZIP Code</label>
              <input
                v-model="addressForm.zip"
                type="text"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20"
              />
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Country</label>
              <input
                v-model="addressForm.country"
                type="text"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20"
              />
            </div>
          </div>
          <div class="flex items-center gap-2">
            <input
              v-model="addressForm.is_default"
              type="checkbox"
              id="defaultAddress"
              class="w-4 h-4 text-primary rounded"
            />
            <label for="defaultAddress" class="text-sm text-gray-700">Set as default address</label>
          </div>
          <div class="flex gap-3 pt-4">
            <button 
              @click="closeAddressModal"
              class="flex-1 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50"
            >
              Cancel
            </button>
            <button 
              @click="saveAddress"
              :disabled="loadingSave"
              class="flex-1 px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 disabled:opacity-50"
            >
              {{ loadingSave ? 'Saving...' : 'Save Address' }}
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Payment Method Modal -->
    <div v-if="showPaymentModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
      <div class="bg-white rounded-xl p-6 max-w-md w-full max-h-[90vh] overflow-y-auto">
        <h3 class="text-xl font-bold text-gray-900 mb-4">
          {{ editingPayment ? 'Edit Payment Method' : 'Add Payment Method' }}
        </h3>
        <div class="space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Card Type</label>
            <select
              v-model="paymentForm.type"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20"
            >
              <option value="Visa">Visa</option>
              <option value="Mastercard">Mastercard</option>
              <option value="American Express">American Express</option>
              <option value="Discover">Discover</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Card Number</label>
            <input
              v-model="paymentForm.card_number"
              type="text"
              placeholder="1234 5678 9012 3456"
              maxlength="19"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20"
            />
          </div>
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Expiry Date</label>
              <input
                v-model="paymentForm.expiry"
                type="text"
                placeholder="MM/YY"
                maxlength="5"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20"
              />
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">CVV</label>
              <input
                v-model="paymentForm.cvv"
                type="text"
                placeholder="123"
                maxlength="4"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20"
              />
            </div>
          </div>
          <div class="flex items-center gap-2">
            <input
              v-model="paymentForm.is_default"
              type="checkbox"
              id="defaultPayment"
              class="w-4 h-4 text-primary rounded"
            />
            <label for="defaultPayment" class="text-sm text-gray-700">Set as default payment method</label>
          </div>
          <div class="flex gap-3 pt-4">
            <button 
              @click="closePaymentModal"
              class="flex-1 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50"
            >
              Cancel
            </button>
            <button 
              @click="savePayment"
              :disabled="loadingSave"
              class="flex-1 px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 disabled:opacity-50"
            >
              {{ loadingSave ? 'Saving...' : 'Save Payment Method' }}
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>


<script>
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
  MoreVertical,
  Check,
  Trash2,
  Receipt
} from 'lucide-vue-next'
import { useAuthStore } from '@/stores/auth'
import { ordersAPI, addressAPI, paymentMethodAPI } from '@/api'
import { useToast } from 'vue-toastification'

export default {
  name: 'Profile',
  
  components: {
    Camera,
    Phone,
    MapPin,
    Edit2,
    ShoppingBag,
    MapPinIcon,
    CreditCard,
    Settings,
    Plus,
    Receipt,
    MoreVertical,
    Check,
    Trash2
  },
  
  data() {
    return {
      activeTab: 'orders',
      loading: true,
      loadingOrders: false,
      loadingAddresses: false,
      loadingPayments: false,
      loadingSave: false,
      loadingPassword: false,
      
      showEditModal: false,
      showAddressModal: false,
      showPaymentModal: false,
      
      activeAddressMenu: null,
      activePaymentMenu: null,
      
      editingAddress: null,
      editingPayment: null,
      
      tabs: [
        { id: 'orders', label: 'Orders', icon: 'ShoppingBag' },
        { id: 'payment-history', label: 'Payment History', icon: 'Receipt' },
        { id: 'addresses', label: 'Addresses', icon: 'MapPinIcon' },
        { id: 'payments', label: 'Payment Methods', icon: 'CreditCard' },
        { id: 'settings', label: 'Settings', icon: 'Settings' }
      ],
      
      user: {},
      userOrders: [],
      addresses: [],
      paymentMethods: [],
      
      editForm: {
        name: '',
        email: '',
        phone: '',
        address: '',
        city: '',
        state: '',
        pincode: ''
      },
      
      addressForm: {
        label: '',
        street: '',
        city: '',
        state: '',
        zip: '',
        country: 'India',
        is_default: false
      },
      
      paymentForm: {
        type: 'Visa',
        card_number: '',
        expiry: '',
        cvv: '',
        is_default: false
      },
      
      passwordForm: {
        current: '',
        new: '',
        confirm: ''
      }
    }
  },
  
  computed: {
    userInitials() {
      if (!this.user.name) return 'U'
      return this.user.name
        .split(' ')
        .map(n => n[0])
        .join('')
        .toUpperCase()
    }
  },
  
  async mounted() {
    await this.loadUserData()
  },

  
  methods: {
    async loadUserData() {
      const authStore = useAuthStore()
      const toast = useToast()
      
      this.loading = true
      
      try {
        // Fetch user profile
        const result = await authStore.fetchUser()
        
        if (result.success) {
          this.user = { ...authStore.user }
          this.editForm = { ...authStore.user }
        } else {
          this.user = { ...authStore.user }
          this.editForm = { ...authStore.user }
        }
        
        // Load orders, addresses, and payment methods
        await Promise.all([
          this.loadOrders(),
          this.loadAddresses(),
          this.loadPaymentMethods()
        ])
      } catch (error) {
        console.error('Failed to load user data:', error)
        toast.error('Failed to load profile data')
      } finally {
        this.loading = false
      }
    },
    
    async loadOrders() {
      this.loadingOrders = true
      const toast = useToast()
      
      try {
        const response = await ordersAPI.getAll()
        if (response.data.success) {
          this.userOrders = response.data.orders || []
        } else {
          // If not successful but no error thrown, just set empty array
          this.userOrders = []
        }
      } catch (error) {
        console.error('Failed to load orders:', error)
        // Only show error if it's not a 404 (no orders found)
        if (error.response?.status !== 404) {
          toast.error('Failed to load orders')
        }
        this.userOrders = []
      } finally {
        this.loadingOrders = false
      }
    },
    
    async loadAddresses() {
      this.loadingAddresses = true
      const toast = useToast()
      
      try {
        const response = await addressAPI.getAll()
        if (response.data.success) {
          this.addresses = response.data.addresses || []
        }
      } catch (error) {
        console.error('Failed to load addresses:', error)
        // Don't show error toast for addresses as they might not exist yet
      } finally {
        this.loadingAddresses = false
      }
    },
    
    async loadPaymentMethods() {
      this.loadingPayments = true
      const toast = useToast()
      
      try {
        const response = await paymentMethodAPI.getAll()
        if (response.data.success) {
          this.paymentMethods = response.data.payment_methods || []
        }
      } catch (error) {
        console.error('Failed to load payment methods:', error)
        // Don't show error toast for payment methods as they might not exist yet
      } finally {
        this.loadingPayments = false
      }
    },

    
    formatDate(dateString) {
      const date = new Date(dateString)
      return date.toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' })
    },
    
    // Profile Methods
    openEditModal() {
      this.editForm = { ...this.user }
      this.showEditModal = true
    },
    
    async saveProfile() {
      const authStore = useAuthStore()
      const toast = useToast()
      
      this.loadingSave = true
      
      try {
        const result = await authStore.updateProfile(this.editForm)
        
        if (result.success) {
          this.user = { ...this.editForm }
          this.showEditModal = false
          toast.success('Profile updated successfully!')
          
          // Reload addresses to show the synced profile address
          await this.loadAddresses()
        } else {
          toast.error(result.error || 'Failed to update profile')
        }
      } catch (error) {
        console.error('Failed to update profile:', error)
        toast.error('Failed to update profile')
      } finally {
        this.loadingSave = false
      }
    },
    
    // Address Methods
    toggleAddressMenu(id) {
      this.activeAddressMenu = this.activeAddressMenu === id ? null : id
      this.activePaymentMenu = null
    },
    
    openAddressModal(address = null) {
      this.editingAddress = address
      if (address) {
        this.addressForm = { ...address }
      } else {
        this.addressForm = {
          label: '',
          street: '',
          city: '',
          state: '',
          zip: '',
          country: 'India',
          is_default: false
        }
      }
      this.showAddressModal = true
      this.activeAddressMenu = null
    },
    
    closeAddressModal() {
      this.showAddressModal = false
      this.editingAddress = null
    },
    
    async saveAddress() {
      const toast = useToast()
      this.loadingSave = true
      
      try {
        let response
        if (this.editingAddress) {
          response = await addressAPI.update(this.editingAddress.id, this.addressForm)
        } else {
          response = await addressAPI.create(this.addressForm)
        }
        
        if (response.data.success) {
          toast.success(this.editingAddress ? 'Address updated!' : 'Address added!')
          this.closeAddressModal()
          await this.loadAddresses()
        } else {
          toast.error(response.data.message || 'Failed to save address')
        }
      } catch (error) {
        console.error('Failed to save address:', error)
        toast.error('Failed to save address')
      } finally {
        this.loadingSave = false
      }
    },
    
    async setDefaultAddress(id) {
      const toast = useToast()
      
      try {
        const response = await addressAPI.setDefault(id)
        if (response.data.success) {
          toast.success('Default address updated!')
          await this.loadAddresses()
        }
      } catch (error) {
        console.error('Failed to set default address:', error)
        toast.error('Failed to set default address')
      }
      this.activeAddressMenu = null
    },
    
    async deleteAddress(id) {
      const toast = useToast()
      
      if (!confirm('Are you sure you want to delete this address?')) {
        this.activeAddressMenu = null
        return
      }
      
      try {
        const response = await addressAPI.delete(id)
        if (response.data.success) {
          toast.success('Address deleted!')
          await this.loadAddresses()
        }
      } catch (error) {
        console.error('Failed to delete address:', error)
        toast.error('Failed to delete address')
      }
      this.activeAddressMenu = null
    },

    
    // Payment Methods
    togglePaymentMenu(id) {
      this.activePaymentMenu = this.activePaymentMenu === id ? null : id
      this.activeAddressMenu = null
    },
    
    openPaymentModal(payment = null) {
      this.editingPayment = payment
      if (payment) {
        this.paymentForm = {
          type: payment.type,
          card_number: '•••• •••• •••• ' + payment.last4,
          expiry: payment.expiry || '',
          cvv: '',
          is_default: payment.is_default
        }
      } else {
        this.paymentForm = {
          type: 'Visa',
          card_number: '',
          expiry: '',
          cvv: '',
          is_default: false
        }
      }
      this.showPaymentModal = true
      this.activePaymentMenu = null
    },
    
    closePaymentModal() {
      this.showPaymentModal = false
      this.editingPayment = null
    },
    
    async savePayment() {
      const toast = useToast()
      this.loadingSave = true
      
      try {
        // Extract last 4 digits
        const last4 = this.paymentForm.card_number.replace(/\s/g, '').slice(-4)
        
        const data = {
          type: this.paymentForm.type,
          last4: last4,
          expiry: this.paymentForm.expiry,
          is_default: this.paymentForm.is_default
        }
        
        let response
        if (this.editingPayment) {
          response = await paymentMethodAPI.update(this.editingPayment.id, data)
        } else {
          response = await paymentMethodAPI.create(data)
        }
        
        if (response.data.success) {
          toast.success(this.editingPayment ? 'Payment method updated!' : 'Payment method added!')
          this.closePaymentModal()
          await this.loadPaymentMethods()
        } else {
          toast.error(response.data.message || 'Failed to save payment method')
        }
      } catch (error) {
        console.error('Failed to save payment method:', error)
        toast.error('Failed to save payment method')
      } finally {
        this.loadingSave = false
      }
    },
    
    async setDefaultPayment(id) {
      const toast = useToast()
      
      try {
        const response = await paymentMethodAPI.setDefault(id)
        if (response.data.success) {
          toast.success('Default payment method updated!')
          await this.loadPaymentMethods()
        }
      } catch (error) {
        console.error('Failed to set default payment method:', error)
        toast.error('Failed to set default payment method')
      }
      this.activePaymentMenu = null
    },
    
    async deletePayment(id) {
      const toast = useToast()
      
      if (!confirm('Are you sure you want to delete this payment method?')) {
        this.activePaymentMenu = null
        return
      }
      
      try {
        const response = await paymentMethodAPI.delete(id)
        if (response.data.success) {
          toast.success('Payment method deleted!')
          await this.loadPaymentMethods()
        }
      } catch (error) {
        console.error('Failed to delete payment method:', error)
        toast.error('Failed to delete payment method')
      }
      this.activePaymentMenu = null
    },
    
    // Password Change
    async changePassword() {
      const toast = useToast()
      
      if (!this.passwordForm.current || !this.passwordForm.new || !this.passwordForm.confirm) {
        toast.error('Please fill in all password fields')
        return
      }
      
      if (this.passwordForm.new !== this.passwordForm.confirm) {
        toast.error('New passwords do not match')
        return
      }
      
      if (this.passwordForm.new.length < 6) {
        toast.error('Password must be at least 6 characters')
        return
      }
      
      this.loadingPassword = true
      
      try {
        const authStore = useAuthStore()
        // You'll need to add this method to auth store
        toast.info('Password change feature coming soon!')
        
        // Reset form
        this.passwordForm = {
          current: '',
          new: '',
          confirm: ''
        }
      } catch (error) {
        console.error('Failed to change password:', error)
        toast.error('Failed to change password')
      } finally {
        this.loadingPassword = false
      }
    }
  }
}
</script>
