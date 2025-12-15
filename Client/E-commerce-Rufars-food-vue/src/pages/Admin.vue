<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <header class="bg-white border-b border-gray-200 sticky top-0 z-10">
      <div class="px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
          <!-- Left Side -->
          <div class="flex items-center gap-4">
            <button
              @click="mobileSidebarOpen = !mobileSidebarOpen"
              class="lg:hidden p-2 rounded-lg hover:bg-gray-100"
            >
              <Menu :size="24" />
            </button>

            <router-link
              to="/"
              class="hidden sm:flex items-center gap-2 px-3 py-2 text-sm text-gray-600 hover:text-primary hover:bg-gray-50 rounded-lg transition-colors"
            >
              <ExternalLink :size="16" />
             <h1 class="text-xl font-bold text-gray-900">Rufars Foods Admin</h1>
            </router-link>
            
          </div>

          <!-- Right Side -->
          <div class="flex items-center gap-3">
            <!-- Search Bar -->
            <div class="hidden md:flex relative">
              <input  
                v-model="headerSearch"
                type="text"
                placeholder="Search..."
                class="w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary"
              />
              <Search :size="18" class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400" />
            </div>

          

            <!-- Notifications -->
            <div class="relative">
              <button
                @click="showNotifications = !showNotifications"
                class="relative p-2 rounded-lg hover:bg-gray-100 transition-colors"
              >
                <Bell :size="20" class="text-gray-600" />
                <span
                  v-if="unreadNotifications > 0"
                  class="absolute top-1 right-1 w-4 h-4 bg-red-500 text-white text-xs rounded-full flex items-center justify-center"
                >
                  {{ unreadNotifications }}
                </span>
              </button>

              <!-- Notifications Dropdown -->
              <div
                v-if="showNotifications"
                class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg border border-gray-200 py-2"
              >
                <div class="px-4 py-2 border-b border-gray-200">
                  <h3 class="font-semibold text-gray-900">Notifications</h3>
                </div>
                <div class="max-h-96 overflow-y-auto">
                  <div
                    v-for="notification in notifications"
                    :key="notification.id"
                    :class="[
                      'px-4 py-3 hover:bg-gray-50 cursor-pointer border-b border-gray-100 last:border-0',
                      !notification.read && 'bg-blue-50'
                    ]"
                  >
                    <div class="flex items-start gap-3">
                      <div
                        :class="[
                          'w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0',
                          notification.type === 'order' ? 'bg-green-100' :
                          notification.type === 'stock' ? 'bg-orange-100' :
                          'bg-blue-100'
                        ]"
                      >
                        <ShoppingCart
                          v-if="notification.type === 'order'"
                          :size="16"
                          class="text-green-600"
                        />
                        <AlertTriangle
                          v-else-if="notification.type === 'stock'"
                          :size="16"
                          class="text-orange-600"
                        />
                        <Bell v-else :size="16" class="text-blue-600" />
                      </div>
                      <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900">{{ notification.title }}</p>
                        <p class="text-xs text-gray-600 mt-1">{{ notification.message }}</p>
                        <p class="text-xs text-gray-400 mt-1">{{ notification.time }}</p>
                      </div>
                      <div v-if="!notification.read" class="w-2 h-2 bg-blue-500 rounded-full flex-shrink-0 mt-2"></div>
                    </div>
                  </div>
                </div>
                <div class="px-4 py-2 border-t border-gray-200">
                  <button class="text-sm text-primary hover:text-primary/80 font-medium">
                    View all notifications
                  </button>
                </div>
              </div>
            </div>

            <!-- Profile Dropdown -->
            <div class="relative">
              <button
                @click="showProfileMenu = !showProfileMenu"
                class="flex items-center gap-2 p-1 rounded-lg hover:bg-gray-100 transition-colors"
              >
                <div class="w-8 h-8 bg-primary rounded-full flex items-center justify-center">
                  <span class="text-sm font-semibold text-white">A</span>
                </div>
                <ChevronDown :size="16" class="text-gray-600 hidden sm:block" />
              </button>

              <!-- Profile Menu Dropdown -->
              <div
                v-if="showProfileMenu"
                class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-lg border border-gray-200 py-2"
              >
                <div class="px-4 py-3 border-b border-gray-200">
                  <p class="text-sm font-semibold text-gray-900">Admin User</p>
                  <p class="text-xs text-gray-600">admin@rufarsfoods.com</p>
                </div>
                <div class="py-1">
                  <button 
                    @click="selectTab('profile')"
                    class="w-full px-4 py-2 text-left text-sm text-gray-700 hover:bg-gray-50 flex items-center gap-3"
                  >
                    <User :size="16" />
                    <span>Profile</span>
                  </button>
                  <button
                    @click="selectTab('settings')"
                    class="w-full px-4 py-2 text-left text-sm text-gray-700 hover:bg-gray-50 flex items-center gap-3"
                  >
                    <Settings :size="16" />
                    <span>Settings</span>
                  </button>
                  <router-link
                    to="/help"
                    class="w-full px-4 py-2 text-left text-sm text-gray-700 hover:bg-gray-50 flex items-center gap-3"
                  >
                    <HelpCircle :size="16" />
                    <span>Help & Support</span>
                  </router-link>
                </div>
                <div class="border-t border-gray-200 py-1">
                  <button
                    @click="handleLogout"
                    class="w-full px-4 py-2 text-left text-sm text-red-600 hover:bg-red-50 flex items-center gap-3"
                  >
                    <LogOut :size="16" />
                    <span>Logout</span>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </header>

    <div class="flex">
      <!-- Sidebar -->
      <aside
        :class="[
          'fixed lg:static inset-y-0 left-0 z-20 w-64 bg-white border-r border-gray-200 transform transition-transform duration-200 ease-in-out',
          mobileSidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'
        ]"
      >
        <nav class="p-4 space-y-2 mt-16 lg:mt-0">
          <button
            v-for="tab in tabs"
            :key="tab.id"
            @click="selectTab(tab.id)"
            :class="[
              'w-full flex items-center gap-3 px-4 py-3 rounded-lg text-left transition-colors',
              activeTab === tab.id
                ? 'bg-primary text-white'
                : 'text-gray-700 hover:bg-gray-100'
            ]"
          >
            <component :is="tab.icon" :size="20" />
            <span class="font-medium">{{ tab.label }}</span>
          </button>
        </nav>
      </aside>

      <!-- Overlay for mobile -->
      <div
        v-if="mobileSidebarOpen"
        @click="mobileSidebarOpen = false"
        class="fixed inset-0 bg-black bg-opacity-50 z-10 lg:hidden"
      ></div>

      <!-- Main Content -->
      <main class="flex-1 p-4 md:p-6">
        <!-- Dashboard Overview -->
        <div v-if="activeTab === 'dashboard'" class="space-y-6">
          <div>
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Dashboard Overview</h2>
            <p class="text-gray-600">Welcome back! Here's what's happening with your store today.</p>
          </div>

          <!-- Stats Cards -->
          <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
            <div class="bg-white rounded-xl p-6 border border-gray-200">
              <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                  <DollarSign :size="24" class="text-green-600" />
                </div>
              </div>
              <p class="text-sm text-gray-600 mb-1">Total Revenue</p>
              <p class="text-2xl font-bold text-gray-900">₹{{ stats.totalRevenue.toLocaleString() }}</p>
              <p class="text-xs text-green-600 mt-2">↑ 12.5% from last month</p>
            </div>

            <div class="bg-white rounded-xl p-6 border border-gray-200">
              <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                  <ShoppingCart :size="24" class="text-blue-600" />
                </div>
              </div>
              <p class="text-sm text-gray-600 mb-1">Total Orders</p>
              <p class="text-2xl font-bold text-gray-900">{{ stats.totalOrders }}</p>
              <p class="text-xs text-blue-600 mt-2">↑ 8.2% from last month</p>
            </div>

            <div class="bg-white rounded-xl p-6 border border-gray-200">
              <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                  <Package :size="24" class="text-purple-600" />
                </div>
              </div>
              <p class="text-sm text-gray-600 mb-1">Total Products</p>
              <p class="text-2xl font-bold text-gray-900">{{ stats.totalProducts }}</p>
            </div>

            <div class="bg-white rounded-xl p-6 border border-gray-200">
              <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                  <AlertTriangle :size="24" class="text-orange-600" />
                </div>
              </div>
              <p class="text-sm text-gray-600 mb-1">Low Stock Items</p>
              <p class="text-2xl font-bold text-gray-900">{{ stats.lowStockItems }}</p>
            </div>
          </div>

          <!-- Recent Orders & Low Stock -->
          <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
            <!-- Recent Orders -->
            <div class="bg-white rounded-xl p-6 border border-gray-200">
              <h3 class="text-lg font-bold text-gray-900 mb-4">Recent Orders</h3>
              <div class="space-y-4">
                <div
                  v-for="order in recentOrders"
                  :key="order.id"
                  class="flex items-center justify-between pb-4 border-b last:border-0 last:pb-0"
                >
                  <div class="flex-1">
                    <p class="font-medium text-gray-900">{{ order.orderNumber }}</p>
                    <p class="text-sm text-gray-600">{{ order.customer.name }}</p>
                  </div>
                  <div class="text-right">
                    <p class="font-semibold text-gray-900">₹{{ order.total.toFixed(2) }}</p>
                    <span
                      :class="[
                        'inline-block px-2 py-1 text-xs rounded-full mt-1',
                        order.status === 'delivered' ? 'bg-green-100 text-green-700' :
                        order.status === 'shipped' ? 'bg-blue-100 text-blue-700' :
                        order.status === 'processing' ? 'bg-yellow-100 text-yellow-700' :
                        'bg-gray-100 text-gray-700'
                      ]"
                    >
                      {{ order.status }}
                    </span>
                  </div>
                </div>
              </div>
            </div>

            <!-- Low Stock Alert -->
            <div class="bg-white rounded-xl p-6 border border-gray-200">
              <h3 class="text-lg font-bold text-gray-900 mb-4">Low Stock Alert</h3>
              <div class="space-y-4">
                <div
                  v-if="lowStockProducts.length === 0"
                  class="text-center py-8 text-gray-600"
                >
                  All products are well stocked! 🎉
                </div>
                <div
                  v-for="product in lowStockProducts"
                  :key="product.id"
                  class="flex items-center gap-4 pb-4 border-b last:border-0 last:pb-0"
                >
                  <img
                    :src="product.image"
                    :alt="product.name"
                    class="w-12 h-12 rounded-lg object-cover"
                  />
                  <div class="flex-1">
                    <p class="font-medium text-gray-900">{{ product.name }}</p>
                    <p class="text-sm text-gray-600">{{ product.sku }}</p>
                  </div>
                  <span class="px-2 py-1 text-xs bg-red-100 text-red-700 rounded-full">
                    {{ product.stock }} left
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Products View -->
        <div v-else-if="activeTab === 'products'" class="space-y-6">
          <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <h2 class="text-2xl font-bold text-gray-900">Products</h2>
            <button 
              @click="showProductModal = true; editingProduct = null"
              class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 flex items-center gap-2"
            >
              <Package :size="18" />
              Add Product
            </button>
          </div>

          <!-- Search and Filters -->
          <div class="bg-white rounded-xl p-4 border border-gray-200">
            <div class="flex flex-col md:flex-row gap-4">
              <div class="flex-1 relative">
                <input
                  v-model="productSearch"
                  type="text"
                  placeholder="Search by Product, SKU, Stock, or Status..."
                  class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary"
                />
                <Search :size="18" class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400" />
              </div>
              <select
                v-model="productStatusFilter"
                class="px-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary/20"
              >
                <option value="all">All Status</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
              </select>
            </div>
          </div>

          <!-- Desktop Table View -->
          <div class="hidden lg:block bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
              <table class="w-full min-w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                  <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase whitespace-nowrap">Product</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase whitespace-nowrap">SKU</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase whitespace-nowrap">Price</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase whitespace-nowrap">Stock</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase whitespace-nowrap">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase whitespace-nowrap">Actions</th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                  <tr v-for="product in filteredProducts" :key="product.id" class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="flex items-center gap-3">
                        <img :src="product.image" :alt="product.name" class="w-10 h-10 rounded-lg object-cover flex-shrink-0" />
                        <span class="font-medium text-gray-900">{{ product.name }}</span>
                      </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600 whitespace-nowrap">{{ product.sku }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">₹{{ product.price }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">{{ product.stock }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <span
                        :class="[
                          'px-2 py-1 text-xs rounded-full',
                          product.status === 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'
                        ]"
                      >
                        {{ product.status }}
                      </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="flex items-center gap-2">
                        <button
                          @click="editProduct(product)"
                          class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                          title="Edit Product"
                        >
                          <Edit2 :size="16" />
                        </button>
                        <button
                          @click="deleteProduct(product.id)"
                          class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                          title="Delete Product"
                        >
                          <Trash2 :size="16" />
                        </button>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

          <!-- Mobile Card View -->
          <div class="lg:hidden space-y-4">
            <div
              v-for="product in filteredProducts"
              :key="product.id"
              class="bg-white rounded-xl p-4 border border-gray-200"
            >
              <div class="flex items-start gap-3 mb-3">
                <img :src="product.image" :alt="product.name" class="w-16 h-16 rounded-lg object-cover flex-shrink-0" />
                <div class="flex-1 min-w-0">
                  <h3 class="font-medium text-gray-900 mb-1">{{ product.name }}</h3>
                  <p class="text-sm text-gray-600">{{ product.sku }}</p>
                </div>
                <span
                  :class="[
                    'px-2 py-1 text-xs rounded-full flex-shrink-0',
                    product.status === 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'
                  ]"
                >
                  {{ product.status }}
                </span>
              </div>
              <div class="grid grid-cols-2 gap-3 mb-3 text-sm">
                <div>
                  <span class="text-gray-600">Price:</span>
                  <span class="font-semibold text-gray-900 ml-1">₹{{ product.price }}</span>
                </div>
                <div>
                  <span class="text-gray-600">Stock:</span>
                  <span class="font-semibold text-gray-900 ml-1">{{ product.stock }}</span>
                </div>
              </div>
              <div class="flex gap-2 pt-3 border-t border-gray-200">
                <button
                  @click="editProduct(product)"
                  class="flex-1 px-3 py-2 text-sm text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors flex items-center justify-center gap-2"
                >
                  <Edit2 :size="16" />
                  Edit
                </button>
                <button
                  @click="deleteProduct(product.id)"
                  class="flex-1 px-3 py-2 text-sm text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-colors flex items-center justify-center gap-2"
                >
                  <Trash2 :size="16" />
                  Delete
                </button>
              </div>
            </div>
          </div>

          <!-- Add/Edit Product Modal -->
          <div v-if="showProductModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-xl p-6 max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto">
              <h3 class="text-xl font-bold text-gray-900 mb-4">
                {{ editingProduct ? 'Edit Product' : 'Add New Product' }}
              </h3>
              <div class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Product Name</label>
                    <input
                      v-model="productForm.name"
                      type="text"
                      placeholder="Enter product name"
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20"
                    />
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">SKU</label>
                    <input
                      v-model="productForm.sku"
                      type="text"
                      placeholder="Enter SKU"
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20"
                    />
                  </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Price (₹)</label>
                    <input
                      v-model.number="productForm.price"
                      type="number"
                      placeholder="Enter price"
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20"
                    />
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Stock</label>
                    <input
                      v-model.number="productForm.stock"
                      type="number"
                      placeholder="Enter stock quantity"
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20"
                    />
                  </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                    <select
                      v-model="productForm.category"
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20"
                    >
                      <option value="">Select category</option>
                      <option value="dried-fruits">Dried Fruits</option>
                      <option value="nuts">Nuts</option>
                      <option value="seeds">Seeds</option>
                      <option value="superfoods">Superfoods</option>
                    </select>
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select
                      v-model="productForm.status"
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20"
                    >
                      <option value="active">Active</option>
                      <option value="inactive">Inactive</option>
                    </select>
                  </div>
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Image URL</label>
                  <input
                    v-model="productForm.image"
                    type="text"
                    placeholder="Enter image URL"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20"
                  />
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Weight</label>
                  <input
                    v-model="productForm.weight"
                    type="text"
                    placeholder="e.g., 250g"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20"
                  />
                </div>
                <div class="flex gap-3 pt-4">
                  <button 
                    @click="showProductModal = false; resetProductForm()"
                    class="flex-1 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50"
                  >
                    Cancel
                  </button>
                  <button 
                    @click="saveProduct"
                    class="flex-1 px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90"
                  >
                    {{ editingProduct ? 'Update Product' : 'Add Product' }}
                  </button>
                </div>
              </div>
            </div>
          </div>

          <!-- Delete Confirmation Modal -->
          <div v-if="showDeleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-xl p-6 max-w-md w-full mx-4">
              <div class="flex items-center justify-center w-12 h-12 mx-auto mb-4 bg-red-100 rounded-full">
                <AlertTriangle :size="24" class="text-red-600" />
              </div>
              <h3 class="text-xl font-bold text-gray-900 text-center mb-2">Delete Product</h3>
              <p class="text-gray-600 text-center mb-6">
                Are you sure you want to delete this product? This action cannot be undone.
              </p>
              <div class="flex gap-3">
                <button 
                  @click="cancelDelete"
                  class="flex-1 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 font-medium"
                >
                  Cancel
                </button>
                <button 
                  @click="confirmDelete"
                  class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 font-medium"
                >
                  Delete
                </button>
              </div>
            </div>
          </div>
        </div>

        <!-- Orders View -->
        <div v-else-if="activeTab === 'orders'" class="space-y-6">
          <h2 class="text-2xl font-bold text-gray-900">Orders</h2>

          <!-- Search and Filters -->
          <div class="bg-white rounded-xl p-4 border border-gray-200">
            <div class="flex flex-col md:flex-row gap-4">
              <div class="flex-1 relative">
                <input
                  v-model="orderSearch"
                  type="text"
                  placeholder="Search by Order #, Customer name, or Email..."
                  class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary"
                />
                <Search :size="18" class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400" />
              </div>
              <select
                v-model="orderStatusFilter"
                class="px-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary/20"
              >
                <option value="all">All Status</option>
                <option value="pending">Pending</option>
                <option value="processing">Processing</option>
                <option value="shipped">Shipped</option>
                <option value="delivered">Delivered</option>
              </select>
            </div>
          </div>

          <!-- Desktop Table View -->
          <div class="hidden lg:block bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
              <table class="w-full min-w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                  <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase whitespace-nowrap">Order #</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase whitespace-nowrap">Customer</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase whitespace-nowrap">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase whitespace-nowrap">Total</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase whitespace-nowrap">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase whitespace-nowrap">Actions</th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                  <tr v-for="order in filteredOrders" :key="order.id" class="hover:bg-gray-50">
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">{{ order.orderNumber }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div>
                        <p class="text-sm font-medium text-gray-900">{{ order.customer.name }}</p>
                        <p class="text-xs text-gray-600">{{ order.customer.email }}</p>
                      </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600 whitespace-nowrap">{{ formatDate(order.createdAt) }}</td>
                    <td class="px-6 py-4 text-sm font-semibold text-gray-900 whitespace-nowrap">₹{{ order.total.toFixed(2) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <span
                        :class="[
                          'px-2 py-1 text-xs rounded-full',
                          order.status === 'delivered' ? 'bg-green-100 text-green-700' :
                          order.status === 'shipped' ? 'bg-blue-100 text-blue-700' :
                          order.status === 'processing' ? 'bg-yellow-100 text-yellow-700' :
                          'bg-gray-100 text-gray-700'
                        ]"
                      >
                        {{ order.status }}
                      </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <button
                        @click="viewOrder(order)"
                        class="px-3 py-1.5 text-sm text-primary hover:bg-primary/10 rounded-lg transition-colors flex items-center gap-1.5 font-medium"
                        title="View Order Details"
                      >
                        <Eye :size="16" />
                        View
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

          <!-- Mobile Card View -->
          <div class="lg:hidden space-y-4">
            <div
              v-for="order in filteredOrders"
              :key="order.id"
              class="bg-white rounded-xl p-4 border border-gray-200"
            >
              <div class="flex items-start justify-between mb-3">
                <div>
                  <h3 class="font-medium text-gray-900 mb-1">{{ order.orderNumber }}</h3>
                  <p class="text-sm text-gray-600">{{ order.customer.name }}</p>
                  <p class="text-xs text-gray-500">{{ order.customer.email }}</p>
                </div>
                <span
                  :class="[
                    'px-2 py-1 text-xs rounded-full flex-shrink-0',
                    order.status === 'delivered' ? 'bg-green-100 text-green-700' :
                    order.status === 'shipped' ? 'bg-blue-100 text-blue-700' :
                    order.status === 'processing' ? 'bg-yellow-100 text-yellow-700' :
                    'bg-gray-100 text-gray-700'
                  ]"
                >
                  {{ order.status }}
                </span>
              </div>
              <div class="grid grid-cols-2 gap-3 mb-3 text-sm">
                <div>
                  <span class="text-gray-600">Date:</span>
                  <span class="text-gray-900 ml-1">{{ formatDate(order.createdAt) }}</span>
                </div>
                <div>
                  <span class="text-gray-600">Total:</span>
                  <span class="font-semibold text-gray-900 ml-1">₹{{ order.total.toFixed(2) }}</span>
                </div>
              </div>
              <button
                @click="viewOrder(order)"
                class="w-full px-3 py-2 text-sm text-primary bg-primary/10 hover:bg-primary/20 rounded-lg transition-colors flex items-center justify-center gap-2"
              >
                <Eye :size="16" />
                View Details
              </button>
            </div>
          </div>

          <!-- Order Details Modal -->
          <div v-if="showOrderModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-xl p-6 max-w-3xl w-full mx-4 max-h-[90vh] overflow-y-auto">
              <div class="flex items-center justify-between mb-6">
                <h3 class="text-2xl font-bold text-gray-900">Order Details</h3>
                <button @click="showOrderModal = false" class="p-2 hover:bg-gray-100 rounded-lg">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                  </svg>
                </button>
              </div>

              <div v-if="selectedOrder" class="space-y-6">
                <!-- Order Info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-sm text-gray-600 mb-1">Order Number</p>
                    <p class="text-lg font-semibold text-gray-900">{{ selectedOrder.orderNumber }}</p>
                  </div>
                  <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-sm text-gray-600 mb-1">Order Date</p>
                    <p class="text-lg font-semibold text-gray-900">{{ formatDate(selectedOrder.createdAt) }}</p>
                  </div>
                  <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-sm text-gray-600 mb-1">Status</p>
                    <span
                      :class="[
                        'inline-block px-3 py-1 text-sm rounded-full font-medium',
                        selectedOrder.status === 'delivered' ? 'bg-green-100 text-green-700' :
                        selectedOrder.status === 'shipped' ? 'bg-blue-100 text-blue-700' :
                        selectedOrder.status === 'processing' ? 'bg-yellow-100 text-yellow-700' :
                        'bg-gray-100 text-gray-700'
                      ]"
                    >
                      {{ selectedOrder.status }}
                    </span>
                  </div>
                  <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-sm text-gray-600 mb-1">Total Amount</p>
                    <p class="text-lg font-semibold text-gray-900">₹{{ selectedOrder.total.toFixed(2) }}</p>
                  </div>
                </div>

                <!-- Customer Info -->
                <div class="border-t pt-6">
                  <h4 class="text-lg font-bold text-gray-900 mb-4">Customer Information</h4>
                  <div class="bg-gray-50 rounded-lg p-4 space-y-2">
                    <div class="flex items-center gap-2">
                      <User :size="16" class="text-gray-600" />
                      <span class="font-medium text-gray-900">{{ selectedOrder.customer.name }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                      <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                      </svg>
                      <span class="text-gray-700">{{ selectedOrder.customer.email }}</span>
                    </div>
                  </div>
                </div>

                <!-- Order Items (Mock Data) -->
                <div class="border-t pt-6">
                  <h4 class="text-lg font-bold text-gray-900 mb-4">Order Items</h4>
                  <div class="space-y-3">
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                      <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-gray-200 rounded-lg"></div>
                        <div>
                          <p class="font-medium text-gray-900">Sample Product</p>
                          <p class="text-sm text-gray-600">Qty: 2</p>
                        </div>
                      </div>
                      <p class="font-semibold text-gray-900">₹{{ (selectedOrder.total / 2).toFixed(2) }}</p>
                    </div>
                  </div>
                </div>

                <!-- Actions -->
                <div class="border-t pt-6 flex gap-3">
                  <button
                    @click="showOrderModal = false"
                    class="flex-1 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 font-medium"
                  >
                    Close
                  </button>
                  <button
                    class="flex-1 px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 font-medium"
                  >
                    Update Status
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Customers View -->
        <div v-else-if="activeTab === 'customers'" class="space-y-6">
          <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <h2 class="text-2xl font-bold text-gray-900">Customers</h2>
            <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
              <input
                v-model="customerSearch"
                type="text"
                placeholder="Search customers..."
                class="w-full sm:w-64 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20"
              />
              <button class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 whitespace-nowrap">
                Export
              </button>
            </div>
          </div>

          <!-- Customer Stats -->
          <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white rounded-xl p-6 border border-gray-200">
              <p class="text-sm text-gray-600 mb-1">Total Customers</p>
              <p class="text-2xl font-bold text-gray-900">{{ customers.length }}</p>
            </div>
            <div class="bg-white rounded-xl p-6 border border-gray-200">
              <p class="text-sm text-gray-600 mb-1">Active This Month</p>
              <p class="text-2xl font-bold text-gray-900">{{ activeCustomers }}</p>
            </div>
            <div class="bg-white rounded-xl p-6 border border-gray-200">
              <p class="text-sm text-gray-600 mb-1">Average Order Value</p>
              <p class="text-2xl font-bold text-gray-900">₹{{ averageOrderValue }}</p>
            </div>
          </div>

          <!-- Desktop Table View -->
          <div class="hidden lg:block bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
              <table class="w-full min-w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                  <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase whitespace-nowrap">Customer</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase whitespace-nowrap">Contact</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase whitespace-nowrap">Location</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase whitespace-nowrap">Orders</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase whitespace-nowrap">Join Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase whitespace-nowrap">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase whitespace-nowrap">Actions</th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                  <tr v-for="customer in filteredCustomers" :key="customer.id" class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center flex-shrink-0">
                          <span class="text-sm font-semibold text-primary">{{ customer.name.charAt(0) }}</span>
                        </div>
                        <span class="font-medium text-gray-900">{{ customer.name }}</span>
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="space-y-1">
                        <div class="flex items-center gap-2 text-sm text-gray-600">
                          <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                          </svg>
                          <span>{{ customer.email }}</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-gray-600">
                          <Phone :size="14" class="flex-shrink-0" />
                          <span>{{ customer.phone }}</span>
                        </div>
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="flex items-center gap-2 text-sm text-gray-600">
                        <MapPin :size="14" class="flex-shrink-0" />
                        <span>{{ customer.location }}</span>
                      </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">{{ customer.orders }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600 whitespace-nowrap">{{ formatDate(customer.joinDate) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <span
                        :class="[
                          'px-2 py-1 text-xs rounded-full',
                          customer.status === 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700'
                        ]"
                      >
                        {{ customer.status }}
                      </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="relative">
                        <button
                          @click="toggleCustomerActions(customer.id)"
                          class="p-2 hover:bg-gray-100 rounded-lg transition-colors"
                        >
                          <MoreVertical :size="16" class="text-gray-600" />
                        </button>
                        
                        <!-- Actions Dropdown -->
                        <div
                          v-if="showCustomerActions === customer.id"
                          class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-10"
                        >
                          <button
                            @click="viewCustomerDetails(customer)"
                            class="w-full px-4 py-2 text-left text-sm text-gray-700 hover:bg-gray-50 flex items-center gap-2"
                          >
                            <Eye :size="14" />
                            View Details
                          </button>
                          <button
                            @click="editCustomer(customer)"
                            class="w-full px-4 py-2 text-left text-sm text-gray-700 hover:bg-gray-50 flex items-center gap-2"
                          >
                            <Edit2 :size="14" />
                            Edit Customer
                          </button>
                          <button
                            @click="viewCustomerOrders(customer)"
                            class="w-full px-4 py-2 text-left text-sm text-gray-700 hover:bg-gray-50 flex items-center gap-2"
                          >
                            <ShoppingCart :size="14" />
                            View Orders
                          </button>
                          <button
                            @click="deleteCustomer(customer.id)"
                            class="w-full px-4 py-2 text-left text-sm text-red-600 hover:bg-red-50 flex items-center gap-2"
                          >
                            <Trash2 :size="14" />
                            Delete
                          </button>
                        </div>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

          <!-- Mobile Card View -->
          <div class="lg:hidden space-y-4">
            <div
              v-for="customer in filteredCustomers"
              :key="customer.id"
              class="bg-white rounded-xl p-4 border border-gray-200 relative"
            >
              <div class="flex items-start gap-3 mb-3">
                <div class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center flex-shrink-0">
                  <span class="text-lg font-semibold text-primary">{{ customer.name.charAt(0) }}</span>
                </div>
                <div class="flex-1 min-w-0">
                  <h3 class="font-medium text-gray-900 mb-1">{{ customer.name }}</h3>
                  <span
                    :class="[
                      'inline-block px-2 py-1 text-xs rounded-full',
                      customer.status === 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700'
                    ]"
                  >
                    {{ customer.status }}
                  </span>
                </div>
                <div class="relative flex-shrink-0">
                  <button
                    @click="toggleCustomerActions(customer.id)"
                    class="p-2 hover:bg-gray-100 rounded-lg transition-colors"
                  >
                    <MoreVertical :size="20" class="text-gray-600" />
                  </button>
                  
                  <!-- Mobile Actions Dropdown -->
                  <div
                    v-if="showCustomerActions === customer.id"
                    class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-20"
                  >
                    <button
                      @click="viewCustomerDetails(customer)"
                      class="w-full px-4 py-2 text-left text-sm text-gray-700 hover:bg-gray-50 flex items-center gap-2"
                    >
                      <Eye :size="14" />
                      View Details
                    </button>
                    <button
                      @click="editCustomer(customer)"
                      class="w-full px-4 py-2 text-left text-sm text-gray-700 hover:bg-gray-50 flex items-center gap-2"
                    >
                      <Edit2 :size="14" />
                      Edit Customer
                    </button>
                    <button
                      @click="viewCustomerOrders(customer)"
                      class="w-full px-4 py-2 text-left text-sm text-gray-700 hover:bg-gray-50 flex items-center gap-2"
                    >
                      <ShoppingCart :size="14" />
                      View Orders
                    </button>
                    <button
                      @click="deleteCustomer(customer.id)"
                      class="w-full px-4 py-2 text-left text-sm text-red-600 hover:bg-red-50 flex items-center gap-2"
                    >
                      <Trash2 :size="14" />
                      Delete
                    </button>
                  </div>
                </div>
              </div>
              <div class="space-y-2 text-sm mb-3">
                <div class="flex items-start gap-2 text-gray-600">
                  <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                  </svg>
                  <span class="break-all flex-1">{{ customer.email }}</span>
                </div>
                <div class="flex items-center gap-2 text-gray-600">
                  <Phone :size="16" class="flex-shrink-0" />
                  <span>{{ customer.phone }}</span>
                </div>
                <div class="flex items-start gap-2 text-gray-600">
                  <MapPin :size="16" class="flex-shrink-0 mt-0.5" />
                  <span class="flex-1">{{ customer.location }}</span>
                </div>
              </div>
              <div class="grid grid-cols-2 gap-3 pt-3 border-t border-gray-200 text-sm">
                <div>
                  <span class="text-gray-600">Orders:</span>
                  <span class="font-semibold text-gray-900 ml-1">{{ customer.orders }}</span>
                </div>
                <div>
                  <span class="text-gray-600">Joined:</span>
                  <span class="text-gray-900 ml-1 text-xs">{{ formatDate(customer.joinDate) }}</span>
                </div>
              </div>
            </div>
          </div>

          <!-- Customer Details Modal -->
          <div v-if="showCustomerModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-xl p-6 max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto">
              <div class="flex items-center justify-between mb-6">
                <h3 class="text-2xl font-bold text-gray-900">Customer Details</h3>
                <button @click="showCustomerModal = false" class="p-2 hover:bg-gray-100 rounded-lg">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                  </svg>
                </button>
              </div>

              <div v-if="selectedCustomer" class="space-y-6">
                <!-- Customer Info -->
                <div class="flex items-center gap-4 pb-6 border-b">
                  <div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center">
                    <span class="text-2xl font-bold text-primary">{{ selectedCustomer.name.charAt(0) }}</span>
                  </div>
                  <div>
                    <h4 class="text-xl font-bold text-gray-900">{{ selectedCustomer.name }}</h4>
                    <span
                      :class="[
                        'inline-block px-2 py-1 text-xs rounded-full mt-1',
                        selectedCustomer.status === 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700'
                      ]"
                    >
                      {{ selectedCustomer.status }}
                    </span>
                  </div>
                </div>

                <!-- Contact Information -->
                <div>
                  <h5 class="text-sm font-semibold text-gray-900 mb-3">Contact Information</h5>
                  <div class="space-y-3">
                    <div class="flex items-center gap-3 text-gray-700">
                      <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                      </svg>
                      <span>{{ selectedCustomer.email }}</span>
                    </div>
                    <div class="flex items-center gap-3 text-gray-700">
                      <Phone :size="20" class="text-gray-400" />
                      <span>{{ selectedCustomer.phone }}</span>
                    </div>
                    <div class="flex items-center gap-3 text-gray-700">
                      <MapPin :size="20" class="text-gray-400" />
                      <span>{{ selectedCustomer.location }}</span>
                    </div>
                  </div>
                </div>

                <!-- Order Statistics -->
                <div>
                  <h5 class="text-sm font-semibold text-gray-900 mb-3">Order Statistics</h5>
                  <div class="grid grid-cols-3 gap-4">
                    <div class="bg-gray-50 rounded-lg p-4">
                      <p class="text-sm text-gray-600 mb-1">Total Orders</p>
                      <p class="text-2xl font-bold text-gray-900">{{ selectedCustomer.orders }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                      <p class="text-sm text-gray-600 mb-1">Total Spent</p>
                      <p class="text-2xl font-bold text-gray-900">₹{{ selectedCustomer.totalSpent.toFixed(2) }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                      <p class="text-sm text-gray-600 mb-1">Join Date</p>
                      <p class="text-lg font-semibold text-gray-900">{{ formatDate(selectedCustomer.joinDate) }}</p>
                    </div>
                  </div>
                </div>

                <!-- Actions -->
                <div class="border-t pt-6 flex gap-3">
                  <button
                    @click="showCustomerModal = false"
                    class="flex-1 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 font-medium"
                  >
                    Close
                  </button>
                  <button
                    @click="editCustomer(selectedCustomer)"
                    class="flex-1 px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 font-medium"
                  >
                    Edit Customer
                  </button>
                </div>
              </div>
            </div>
          </div>

          <!-- Delete Customer Confirmation Modal -->
          <div v-if="showDeleteCustomerModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-xl p-6 max-w-md w-full mx-4">
              <div class="flex items-center justify-center w-12 h-12 mx-auto mb-4 bg-red-100 rounded-full">
                <AlertTriangle :size="24" class="text-red-600" />
              </div>
              <h3 class="text-xl font-bold text-gray-900 text-center mb-2">Delete Customer</h3>
              <p class="text-gray-600 text-center mb-6">
                Are you sure you want to delete this customer? This action cannot be undone.
              </p>
              <div class="flex gap-3">
                <button 
                  @click="cancelDeleteCustomer"
                  class="flex-1 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 font-medium"
                >
                  Cancel
                </button>
                <button 
                  @click="confirmDeleteCustomer"
                  class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 font-medium"
                >
                  Delete
                </button>
              </div>
            </div>
          </div>

          <!-- Edit Customer Modal -->
          <div v-if="showEditCustomerModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-xl p-6 max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto">
              <div class="flex items-center justify-between mb-6">
                <h3 class="text-2xl font-bold text-gray-900">Edit Customer</h3>
                <button @click="showEditCustomerModal = false" class="p-2 hover:bg-gray-100 rounded-lg">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                  </svg>
                </button>
              </div>

              <div v-if="editingCustomer" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                    <input
                      v-model="customerForm.name"
                      type="text"
                      placeholder="Enter full name"
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20"
                    />
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input
                      v-model="customerForm.email"
                      type="email"
                      placeholder="Enter email"
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20"
                    />
                  </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                    <input
                      v-model="customerForm.phone"
                      type="tel"
                      placeholder="Enter phone number"
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20"
                    />
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Location</label>
                    <input
                      v-model="customerForm.location"
                      type="text"
                      placeholder="Enter location"
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20"
                    />
                  </div>
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                  <select
                    v-model="customerForm.status"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20"
                  >
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                  </select>
                </div>
                <div class="flex gap-3 pt-4">
                  <button 
                    @click="showEditCustomerModal = false; resetCustomerForm()"
                    class="flex-1 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 font-medium"
                  >
                    Cancel
                  </button>
                  <button 
                    @click="saveCustomer"
                    class="flex-1 px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 font-medium"
                  >
                    Save Changes
                  </button>
                </div>
              </div>
            </div>
          </div>

          <!-- View Customer Orders Modal -->
          <div v-if="showCustomerOrdersModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-xl p-6 max-w-4xl w-full mx-4 max-h-[90vh] overflow-y-auto">
              <div class="flex items-center justify-between mb-6">
                <div>
                  <h3 class="text-2xl font-bold text-gray-900">Customer Orders</h3>
                  <p v-if="selectedCustomer" class="text-gray-600 mt-1">{{ selectedCustomer.name }} - {{ selectedCustomer.orders }} orders</p>
                </div>
                <button @click="showCustomerOrdersModal = false" class="p-2 hover:bg-gray-100 rounded-lg">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                  </svg>
                </button>
              </div>

              <div class="space-y-4">
                <!-- Desktop Orders List -->
                <div class="hidden md:block border border-gray-200 rounded-lg overflow-hidden">
                  <div class="overflow-x-auto">
                    <table class="w-full min-w-full">
                      <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                          <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase whitespace-nowrap">Order #</th>
                          <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase whitespace-nowrap">Date</th>
                          <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase whitespace-nowrap">Total</th>
                          <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase whitespace-nowrap">Status</th>
                          <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase whitespace-nowrap">Action</th>
                        </tr>
                      </thead>
                      <tbody class="divide-y divide-gray-200">
                        <tr v-for="order in customerOrders" :key="order.id" class="hover:bg-gray-50">
                          <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap">{{ order.orderNumber }}</td>
                          <td class="px-4 py-3 text-sm text-gray-600 whitespace-nowrap">{{ formatDate(order.createdAt) }}</td>
                          <td class="px-4 py-3 text-sm font-semibold text-gray-900 whitespace-nowrap">₹{{ order.total.toFixed(2) }}</td>
                          <td class="px-4 py-3 whitespace-nowrap">
                            <span
                              :class="[
                                'px-2 py-1 text-xs rounded-full',
                                order.status === 'delivered' ? 'bg-green-100 text-green-700' :
                                order.status === 'shipped' ? 'bg-blue-100 text-blue-700' :
                                order.status === 'processing' ? 'bg-yellow-100 text-yellow-700' :
                                'bg-gray-100 text-gray-700'
                              ]"
                            >
                              {{ order.status }}
                            </span>
                          </td>
                          <td class="px-4 py-3 whitespace-nowrap">
                            <button
                              @click="viewOrder(order)"
                              class="text-primary hover:text-primary/80 text-sm font-medium"
                            >
                              View
                            </button>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>

                <!-- Mobile Orders List -->
                <div class="md:hidden space-y-3">
                  <div
                    v-for="order in customerOrders"
                    :key="order.id"
                    class="border border-gray-200 rounded-lg p-3"
                  >
                    <div class="flex items-start justify-between mb-2">
                      <div>
                        <p class="font-medium text-gray-900">{{ order.orderNumber }}</p>
                        <p class="text-xs text-gray-600 mt-1">{{ formatDate(order.createdAt) }}</p>
                      </div>
                      <span
                        :class="[
                          'px-2 py-1 text-xs rounded-full flex-shrink-0',
                          order.status === 'delivered' ? 'bg-green-100 text-green-700' :
                          order.status === 'shipped' ? 'bg-blue-100 text-blue-700' :
                          order.status === 'processing' ? 'bg-yellow-100 text-yellow-700' :
                          'bg-gray-100 text-gray-700'
                        ]"
                      >
                        {{ order.status }}
                      </span>
                    </div>
                    <div class="flex items-center justify-between pt-2 border-t border-gray-100">
                      <span class="text-sm font-semibold text-gray-900">₹{{ order.total.toFixed(2) }}</span>
                      <button
                        @click="viewOrder(order)"
                        class="text-sm text-primary hover:text-primary/80 font-medium"
                      >
                        View Details
                      </button>
                    </div>
                  </div>
                </div>

                <!-- Summary -->
                <div v-if="selectedCustomer" class="bg-gray-50 rounded-lg p-4">
                  <div class="grid grid-cols-2 gap-4">
                    <div>
                      <p class="text-sm text-gray-600">Total Orders</p>
                      <p class="text-xl font-bold text-gray-900">{{ selectedCustomer.orders }}</p>
                    </div>
                    <div>
                      <p class="text-sm text-gray-600">Total Spent</p>
                      <p class="text-xl font-bold text-gray-900">₹{{ selectedCustomer.totalSpent.toFixed(2) }}</p>
                    </div>
                  </div>
                </div>

                <div class="flex justify-end pt-4">
                  <button
                    @click="showCustomerOrdersModal = false"
                    class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 font-medium"
                  >
                    Close
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Analytics View -->
        <div v-else-if="activeTab === 'analytics'" class="space-y-6">
          <h2 class="text-2xl font-bold text-gray-900">Analytics</h2>

          <!-- Time Period Selector -->
          <div class="flex gap-2">
            <button
              v-for="period in ['7d', '30d', '90d', '1y']"
              :key="period"
              @click="selectedPeriod = period"
              :class="[
                'px-4 py-2 rounded-lg text-sm font-medium transition-colors',
                selectedPeriod === period
                  ? 'bg-primary text-white'
                  : 'bg-white text-gray-700 border border-gray-300 hover:bg-gray-50'
              ]"
            >
              {{ period === '7d' ? 'Last 7 Days' : period === '30d' ? 'Last 30 Days' : period === '90d' ? 'Last 90 Days' : 'Last Year' }}
            </button>
          </div>

          <!-- Analytics Cards -->
          <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
            <div class="bg-white rounded-xl p-6 border border-gray-200">
              <p class="text-sm text-gray-600 mb-1">Revenue</p>
              <p class="text-2xl font-bold text-gray-900">₹{{ analyticsData.revenue.toLocaleString() }}</p>
              <p class="text-xs text-green-600 mt-2">↑ {{ analyticsData.revenueGrowth }}%</p>
            </div>
            <div class="bg-white rounded-xl p-6 border border-gray-200">
              <p class="text-sm text-gray-600 mb-1">Orders</p>
              <p class="text-2xl font-bold text-gray-900">{{ analyticsData.orders }}</p>
              <p class="text-xs text-green-600 mt-2">↑ {{ analyticsData.ordersGrowth }}%</p>
            </div>
            <div class="bg-white rounded-xl p-6 border border-gray-200">
              <p class="text-sm text-gray-600 mb-1">Conversion Rate</p>
              <p class="text-2xl font-bold text-gray-900">{{ analyticsData.conversionRate }}%</p>
              <p class="text-xs text-green-600 mt-2">↑ {{ analyticsData.conversionGrowth }}%</p>
            </div>
            <div class="bg-white rounded-xl p-6 border border-gray-200">
              <p class="text-sm text-gray-600 mb-1">Avg Order Value</p>
              <p class="text-2xl font-bold text-gray-900">₹{{ analyticsData.avgOrderValue }}</p>
              <p class="text-xs text-green-600 mt-2">↑ {{ analyticsData.avgOrderGrowth }}%</p>
            </div>
          </div>

          <!-- Charts -->
          <div class="grid grid-cols-1 gap-6">
            <!-- Monthly Sales Bar Chart -->
            <div class="bg-white rounded-xl p-6 border border-gray-200">
              <h3 class="text-lg font-bold text-gray-900 mb-4">Monthly Sales Comparison</h3>
              <div class="h-80">
                <canvas ref="monthlySalesChart"></canvas>
              </div>
            </div>
          </div>

          <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
            <!-- Revenue & Orders Trend Line Chart -->
            <div class="bg-white rounded-xl p-6 border border-gray-200">
              <h3 class="text-lg font-bold text-gray-900 mb-4">Revenue & Orders Trend</h3>
              <div class="h-80">
                <canvas ref="revenueOrdersChart"></canvas>
              </div>
            </div>

            <!-- Sales by Category Pie Chart -->
            <div class="bg-white rounded-xl p-6 border border-gray-200">
              <h3 class="text-lg font-bold text-gray-900 mb-4">Sales by Category</h3>
              <div class="h-80 flex items-center justify-center">
                <canvas ref="categoryPieChart"></canvas>
              </div>
            </div>
          </div>

          <!-- Top Selling Products -->
          <div class="bg-white rounded-xl p-6 border border-gray-200">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Top Selling Products</h3>
            <div class="space-y-3">
              <div v-for="(product, index) in topProducts" :key="product.id" class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg">
                <div class="flex items-center gap-3">
                  <span class="w-8 h-8 flex items-center justify-center bg-primary/10 text-primary font-bold rounded-lg text-sm">{{ index + 1 }}</span>
                  <img :src="product.image" :alt="product.name" class="w-12 h-12 rounded-lg object-cover" />
                  <div>
                    <p class="text-sm font-medium text-gray-900">{{ product.name }}</p>
                    <p class="text-xs text-gray-600">{{ product.category }}</p>
                  </div>
                </div>
                <div class="text-right">
                  <p class="text-sm font-semibold text-gray-900">{{ product.sales }} units sold</p>
                  <p class="text-xs text-gray-600">₹{{ (product.price * product.sales).toLocaleString() }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Categories View -->
        <div v-else-if="activeTab === 'categories'" class="space-y-6">
          <div>
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Category Management</h2>
            <p class="text-gray-600">Organize your products into categories</p>
          </div>

          <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <!-- Search Bar -->
            <div class="flex-1 w-full sm:max-w-md relative">
              <input
                v-model="categorySearch"
                type="text"
                placeholder="Search by category name..."
                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary"
              />
              <Search :size="18" class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400" />
            </div>
            
            <button @click="showCategoryDialog = true" class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 flex items-center gap-2">
              <Package :size="18" />
              Add Category
            </button>
          </div>

          <!-- Categories Grid -->
          <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            <div
              v-for="category in filteredCategories"
              :key="category.id"
              class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-shadow"
            >
              <div class="flex items-start justify-between mb-4">
                <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center">
                  <component :is="category.icon" :size="24" class="text-primary" />
                </div>
                <div class="relative">
                  <button 
                    @click="toggleCategoryMenu(category.id)"
                    class="p-2 hover:bg-gray-100 rounded-lg transition-colors"
                  >
                    <MoreVertical :size="16" class="text-gray-600" />
                  </button>
                  
                  <!-- Dropdown Menu -->
                  <div
                    v-if="activeCategoryMenu === category.id"
                    class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-10"
                  >
                    <button
                      @click="editCategory(category)"
                      class="w-full px-4 py-2 text-left text-sm text-gray-700 hover:bg-gray-50 flex items-center gap-3"
                    >
                      <Edit2 :size="16" />
                      <span>Edit Category</span>
                    </button>
                    <button
                      @click="deleteCategory(category.id)"
                      class="w-full px-4 py-2 text-left text-sm text-red-600 hover:bg-red-50 flex items-center gap-3"
                    >
                      <Trash2 :size="16" />
                      <span>Delete Category</span>
                    </button>
                  </div>
                </div>
              </div>
              <h3 class="text-lg font-bold text-gray-900 mb-2">{{ category.name }}</h3>
              <p class="text-sm text-gray-600 mb-4">{{ category.description }}</p>
              <div class="flex items-center justify-between text-sm">
                <span class="text-gray-600">{{ category.productCount }} products</span>
                <span
                  :class="[
                    'px-2 py-1 rounded-full text-xs',
                    category.status === 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700'
                  ]"
                >
                  {{ category.status }}
                </span>
              </div>
            </div>
          </div>

          <!-- Add/Edit Category Dialog -->
          <div v-if="showCategoryDialog" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-xl p-6 max-w-md w-full mx-4">
              <h3 class="text-xl font-bold text-gray-900 mb-4">
                {{ editingCategory ? 'Edit Category' : 'Add New Category' }}
              </h3>
              <div class="space-y-4">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Category Name</label>
                  <input
                    type="text"
                    :value="editingCategory ? editingCategory.name : ''"
                    placeholder="Enter category name"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20"
                  />
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                  <textarea
                    :value="editingCategory ? editingCategory.description : ''"
                    placeholder="Enter description"
                    rows="3"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20"
                  ></textarea>
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                  <select
                    :value="editingCategory ? editingCategory.status : 'active'"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20"
                  >
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                  </select>
                </div>
                <div class="flex gap-3">
                  <button 
                    @click="showCategoryDialog = false; editingCategory = null" 
                    class="flex-1 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50"
                  >
                    Cancel
                  </button>
                  <button 
                    @click="showCategoryDialog = false; editingCategory = null" 
                    class="flex-1 px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90"
                  >
                    {{ editingCategory ? 'Update Category' : 'Add Category' }}
                  </button>
                </div>
              </div>
            </div>
          </div>

          <!-- Delete Category Confirmation Modal -->
          <div v-if="showDeleteCategoryModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-xl p-6 max-w-md w-full mx-4">
              <div class="flex items-center justify-center w-12 h-12 mx-auto mb-4 bg-red-100 rounded-full">
                <AlertTriangle :size="24" class="text-red-600" />
              </div>
              <h3 class="text-xl font-bold text-gray-900 text-center mb-2">Delete Category</h3>
              <p class="text-gray-600 text-center mb-6">
                Are you sure you want to delete this category? This action cannot be undone.
              </p>
              <div class="flex gap-3">
                <button 
                  @click="cancelDeleteCategory"
                  class="flex-1 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 font-medium"
                >
                  Cancel
                </button>
                <button 
                  @click="confirmDeleteCategory"
                  class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 font-medium"
                >
                  Delete
                </button>
              </div>
            </div>
          </div>
        </div>

        <!-- Profile View -->
        <div v-else-if="activeTab === 'profile'" class="space-y-6">
          <h2 class="text-2xl font-bold text-gray-900 mb-6">Admin Profile</h2>

          <!-- Profile Card -->
          <div class="bg-white rounded-xl p-6 border border-gray-200">
            <div class="flex flex-col md:flex-row items-start md:items-center gap-6">
              <!-- Avatar -->
              <div class="relative">
                <div class="w-24 h-24 bg-primary rounded-full flex items-center justify-center text-3xl font-bold text-white">
                  A
                </div>
                <button class="absolute bottom-0 right-0 w-8 h-8 bg-white rounded-full shadow-lg flex items-center justify-center border-2 border-gray-200 hover:bg-gray-50">
                  <Edit2 :size="14" class="text-gray-600" />
                </button>
              </div>
              
              <!-- Admin Info -->
              <div class="flex-1">
                <h3 class="text-xl font-bold text-gray-900">Admin User</h3>
                <p class="text-gray-600">admin@rufarsfoods.com</p>
                <div class="flex items-center gap-4 mt-2">
                  <span class="text-sm text-gray-600 flex items-center gap-1">
                    <Phone :size="14" />
                    +1 (555) 123-4567
                  </span>
                  <span class="px-2 py-1 text-xs bg-primary/10 text-primary rounded-full">Administrator</span>
                </div>
              </div>
              
              <!-- Edit Button -->
              <button class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 flex items-center gap-2">
                <Edit2 :size="16" />
                Edit Profile
              </button>
            </div>
          </div>

          <!-- Profile Details -->
          <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Personal Information -->
            <div class="bg-white rounded-xl p-6 border border-gray-200">
              <h3 class="text-lg font-bold text-gray-900 mb-4">Personal Information</h3>
              <div class="space-y-4">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                  <input
                    type="text"
                    value="Admin User"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20"
                  />
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                  <input
                    type="email"
                    value="admin@rufarsfoods.com"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20"
                  />
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                  <input
                    type="tel"
                    value="+1 (555) 123-4567"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20"
                  />
                </div>
                <button class="w-full px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary/90">
                  Save Changes
                </button>
              </div>
            </div>

            <!-- Security -->
            <div class="bg-white rounded-xl p-6 border border-gray-200">
              <h3 class="text-lg font-bold text-gray-900 mb-4">Security</h3>
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
                <button class="w-full px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary/90">
                  Update Password
                </button>
              </div>
            </div>
          </div>

          <!-- Activity Log -->
          <div class="bg-white rounded-xl p-6 border border-gray-200">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Recent Activity</h3>
            <div class="space-y-3">
              <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-0">
                <div class="flex items-center gap-3">
                  <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                    <Package :size="16" class="text-green-600" />
                  </div>
                  <div>
                    <p class="text-sm font-medium text-gray-900">Added new product</p>
                    <p class="text-xs text-gray-600">Premium Almonds</p>
                  </div>
                </div>
                <span class="text-xs text-gray-500">2 hours ago</span>
              </div>
              <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-0">
                <div class="flex items-center gap-3">
                  <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                    <ShoppingCart :size="16" class="text-blue-600" />
                  </div>
                  <div>
                    <p class="text-sm font-medium text-gray-900">Updated order status</p>
                    <p class="text-xs text-gray-600">Order #ORD-2024-001</p>
                  </div>
                </div>
                <span class="text-xs text-gray-500">5 hours ago</span>
              </div>
              <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-0">
                <div class="flex items-center gap-3">
                  <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                    <Settings :size="16" class="text-purple-600" />
                  </div>
                  <div>
                    <p class="text-sm font-medium text-gray-900">Changed settings</p>
                    <p class="text-xs text-gray-600">Updated shipping rates</p>
                  </div>
                </div>
                <span class="text-xs text-gray-500">1 day ago</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Settings View -->
        <div v-else-if="activeTab === 'settings'" class="space-y-6">
          <h2 class="text-2xl font-bold text-gray-900">Settings</h2>

          <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
            <!-- Settings Navigation -->
            <div class="bg-white rounded-xl p-4 border border-gray-200 h-fit">
              <nav class="space-y-1">
                <button
                  v-for="setting in settingsTabs"
                  :key="setting.id"
                  @click="activeSettingsTab = setting.id"
                  :class="[
                    'w-full flex items-center gap-3 px-4 py-3 rounded-lg text-left transition-colors',
                    activeSettingsTab === setting.id
                      ? 'bg-primary/10 text-primary'
                      : 'text-gray-700 hover:bg-gray-50'
                  ]"
                >
                  <component :is="setting.icon" :size="20" />
                  <span class="font-medium">{{ setting.label }}</span>
                </button>
              </nav>
            </div>

            <!-- Settings Content -->
            <div class="xl:col-span-2 space-y-6">
              <!-- General Settings -->
              <div v-if="activeSettingsTab === 'general'" class="bg-white rounded-xl p-6 border border-gray-200">
                <h3 class="text-lg font-bold text-gray-900 mb-4">General Settings</h3>
                <div class="space-y-4">
                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Store Name</label>
                    <input
                      type="text"
                      value="Rufars Foods"
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20"
                    />
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Store Email</label>
                    <input
                      type="email"
                      value="contact@rufarsfoods.com"
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20"
                    />
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                    <input
                      type="tel"
                      value="+1 (555) 123-4567"
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20"
                    />
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Currency</label>
                    <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20">
                      <option>INR (₹)</option>
                      <option>USD ($)</option>
                      <option>EUR (€)</option>
                    </select>
                  </div>
                  <button class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary/90">
                    Save Changes
                  </button>
                </div>
              </div>

              <!-- Shipping Settings -->
              <div v-if="activeSettingsTab === 'shipping'" class="bg-white rounded-xl p-6 border border-gray-200">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Shipping Settings</h3>
                <div class="space-y-4">
                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Free Shipping Threshold</label>
                    <input
                      type="number"
                      value="1000"
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20"
                    />
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Standard Shipping Cost</label>
                    <input
                      type="number"
                      value="100"
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20"
                    />
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Estimated Delivery Time</label>
                    <input
                      type="text"
                      value="3-5 business days"
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20"
                    />
                  </div>
                  <button class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary/90">
                    Save Changes
                  </button>
                </div>
              </div>

              <!-- Payment Settings -->
              <div v-if="activeSettingsTab === 'payment'" class="bg-white rounded-xl p-6 border border-gray-200">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Payment Settings</h3>
                <div class="space-y-4">
                  <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                    <div>
                      <p class="font-medium text-gray-900">Credit/Debit Cards</p>
                      <p class="text-sm text-gray-600">Accept card payments</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                      <input type="checkbox" checked class="sr-only peer" />
                      <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                    </label>
                  </div>
                  <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                    <div>
                      <p class="font-medium text-gray-900">UPI Payments</p>
                      <p class="text-sm text-gray-600">Accept UPI payments</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                      <input type="checkbox" checked class="sr-only peer" />
                      <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                    </label>
                  </div>
                  <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                    <div>
                      <p class="font-medium text-gray-900">Cash on Delivery</p>
                      <p class="text-sm text-gray-600">Accept COD orders</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                      <input type="checkbox" class="sr-only peer" />
                      <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                    </label>
                  </div>
                </div>
              </div>

              <!-- Notifications Settings -->
              <div v-if="activeSettingsTab === 'notifications'" class="bg-white rounded-xl p-6 border border-gray-200">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Notification Settings</h3>
                <div class="space-y-4">
                  <div class="flex items-center justify-between">
                    <div>
                      <p class="font-medium text-gray-900">Order Notifications</p>
                      <p class="text-sm text-gray-600">Get notified about new orders</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                      <input type="checkbox" checked class="sr-only peer" />
                      <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                    </label>
                  </div>
                  <div class="flex items-center justify-between">
                    <div>
                      <p class="font-medium text-gray-900">Low Stock Alerts</p>
                      <p class="text-sm text-gray-600">Alert when products are low in stock</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                      <input type="checkbox" checked class="sr-only peer" />
                      <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                    </label>
                  </div>
                  <div class="flex items-center justify-between">
                    <div>
                      <p class="font-medium text-gray-900">Customer Messages</p>
                      <p class="text-sm text-gray-600">Notifications for customer inquiries</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                      <input type="checkbox" checked class="sr-only peer" />
                      <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                    </label>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>
</template>

<script>
import {
  LayoutDashboard,
  Package,
  ShoppingCart,
  Users,
  BarChart3,
  FolderTree,
  Settings,
  Menu,
  LogOut,
  DollarSign,
  AlertTriangle,
  Truck,
  CreditCard,
  Bell,
  Search,
  ExternalLink,
  User,
  ChevronDown,
  HelpCircle,
  Edit2,
  Trash2,
  Eye,
  Phone,
  MapPin,
  MoreVertical,
  X
} from 'lucide-vue-next'
import { products } from '@/data/products'
import {
  Chart as ChartJS,
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  BarElement,
  BarController,
  ArcElement,
  DoughnutController,
  LineController,
  Title,
  Tooltip,
  Legend
} from 'chart.js'

ChartJS.register(
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  BarElement,
  BarController,
  ArcElement,
  DoughnutController,
  LineController,
  Title,
  Tooltip,
  Legend
)

export default {
  name: 'Admin',
  
  components: {
    LayoutDashboard,
    Package,
    ShoppingCart,
    Users,
    BarChart3,
    FolderTree,
    Settings,
    Menu,
    LogOut,
    DollarSign,
    AlertTriangle,
    Truck,
    CreditCard,
    Bell,
    Search,
    ExternalLink,
    User,
    ChevronDown,
    HelpCircle,
    Edit2,
    Trash2,
    Eye,
    Phone,
    MapPin,
    MoreVertical,
    X
  },
  
  data() {
    return {
      activeTab: 'dashboard',
      mobileSidebarOpen: false,
      headerSearch: '',
      showNotifications: false,
      showProfileMenu: false,
      unreadNotifications: 3,
      showProductModal: false,
      showDeleteModal: false,
      showOrderModal: false,
      showCustomerModal: false,
      showDeleteCustomerModal: false,
      showEditCustomerModal: false,
      showCustomerOrdersModal: false,
      showCustomerActions: null,
      editingProduct: null,
      editingCustomer: null,
      deletingProductId: null,
      deletingCustomerId: null,
      selectedOrder: null,
      selectedCustomer: null,
      customerForm: {
        name: '',
        email: '',
        phone: '',
        location: '',
        status: 'active'
      },
      productSearch: '',
      productStatusFilter: 'all',
      orderSearch: '',
      orderStatusFilter: 'all',
      productForm: {
        name: '',
        sku: '',
        price: 0,
        stock: 0,
        category: '',
        status: 'active',
        image: '',
        weight: '250g'
      },
      notifications: [
        {
          id: 1,
          type: 'order',
          title: 'New Order Received',
          message: 'Order #ORD-2024-005 has been placed',
          time: '5 minutes ago',
          read: false
        },
        {
          id: 2,
          type: 'stock',
          title: 'Low Stock Alert',
          message: 'Dried Mango Slices is running low on stock',
          time: '1 hour ago',
          read: false
        },
        {
          id: 3,
          type: 'info',
          title: 'System Update',
          message: 'New features have been added to the dashboard',
          time: '2 hours ago',
          read: true
        },
        {
          id: 4,
          type: 'order',
          title: 'Order Shipped',
          message: 'Order #ORD-2024-003 has been shipped',
          time: '3 hours ago',
          read: true
        }
      ],
      tabs: [
        { id: 'dashboard', label: 'Dashboard', icon: 'LayoutDashboard' },
        { id: 'products', label: 'Products', icon: 'Package' },
        { id: 'orders', label: 'Orders', icon: 'ShoppingCart' },
        { id: 'customers', label: 'Customers', icon: 'Users' },
        { id: 'analytics', label: 'Analytics', icon: 'BarChart3' },
        { id: 'categories', label: 'Categories', icon: 'FolderTree' },
        { id: 'profile', label: 'Profile', icon: 'User' },
        { id: 'settings', label: 'Settings', icon: 'Settings' }
      ],
      products: products.map(p => ({
        id: p.id,
        name: p.name,
        sku: `RF-${p.category.substring(0, 3).toUpperCase()}-${p.id.padStart(3, '0')}`,
        category: p.category,
        price: p.price,
        stock: Math.floor(Math.random() * 50) + 5,
        status: 'active',
        image: p.image,
        weight: '250g'
      })),
      orders: [
        {
          id: 'o1',
          orderNumber: 'ORD-2024-001',
          customer: { name: 'Sarah Johnson', email: 'sarah.j@email.com' },
          createdAt: new Date(2024, 9, 28).toISOString(),
          total: 1497,
          status: 'delivered'
        },
        {
          id: 'o2',
          orderNumber: 'ORD-2024-002',
          customer: { name: 'Michael Chen', email: 'mchen@email.com' },
          createdAt: new Date(2024, 9, 29).toISOString(),
          total: 2397,
          status: 'shipped'
        },
        {
          id: 'o3',
          orderNumber: 'ORD-2024-003',
          customer: { name: 'Emma Wilson', email: 'emmaw@email.com' },
          createdAt: new Date(2024, 9, 30).toISOString(),
          total: 1897,
          status: 'processing'
        },
        {
          id: 'o4',
          orderNumber: 'ORD-2024-004',
          customer: { name: 'David Brown', email: 'dbrown@email.com' },
          createdAt: new Date(2024, 10, 1).toISOString(),
          total: 899,
          status: 'pending'
        }
      ],
      customers: [
        {
          id: 'c1',
          name: 'Sarah Johnson',
          email: 'sarah.j@email.com',
          phone: '+1 (555) 123-4567',
          location: 'New York, USA',
          orders: 12,
          totalSpent: 15847,
          status: 'active',
          joinDate: new Date(2023, 5, 15).toISOString()
        },
        {
          id: 'c2',
          name: 'Michael Chen',
          email: 'mchen@email.com',
          phone: '+1 (555) 234-5678',
          location: 'San Francisco, USA',
          orders: 8,
          totalSpent: 9234,
          status: 'active',
          joinDate: new Date(2023, 7, 22).toISOString()
        },
        {
          id: 'c3',
          name: 'Emma Wilson',
          email: 'emmaw@email.com',
          phone: '+1 (555) 345-6789',
          location: 'Los Angeles, USA',
          orders: 15,
          totalSpent: 18956,
          status: 'active',
          joinDate: new Date(2023, 3, 10).toISOString()
        },
        {
          id: 'c4',
          name: 'David Brown',
          email: 'dbrown@email.com',
          phone: '+1 (555) 456-7890',
          location: 'Chicago, USA',
          orders: 5,
          totalSpent: 6234,
          status: 'active',
          joinDate: new Date(2023, 9, 5).toISOString()
        },
        {
          id: 'c5',
          name: 'Lisa Anderson',
          email: 'lisa.a@email.com',
          phone: '+1 (555) 567-8901',
          location: 'Seattle, USA',
          orders: 3,
          totalSpent: 3456,
          status: 'inactive',
          joinDate: new Date(2024, 0, 18).toISOString()
        }
      ],
      customerSearch: '',
      selectedPeriod: '30d',
      analyticsData: {
        revenue: 48568,
        revenueGrowth: 12.5,
        orders: 127,
        ordersGrowth: 8.2,
        conversionRate: 3.4,
        conversionGrowth: 2.1,
        avgOrderValue: 1247,
        avgOrderGrowth: 5.3
      },
      categories: [
        {
          id: 'cat1',
          name: 'Dried Fruits',
          description: 'Premium dried fruits from around the world',
          productCount: 6,
          status: 'active',
          icon: 'Package'
        },
        {
          id: 'cat2',
          name: 'Nuts',
          description: 'Healthy and nutritious nuts',
          productCount: 6,
          status: 'active',
          icon: 'Package'
        },
        {
          id: 'cat3',
          name: 'Seeds',
          description: 'Superfood seeds packed with nutrients',
          productCount: 6,
          status: 'active',
          icon: 'Package'
        },
        {
          id: 'cat4',
          name: 'Superfoods',
          description: 'Exotic superfoods for optimal health',
          productCount: 4,
          status: 'active',
          icon: 'Package'
        }
      ],
      showCategoryDialog: false,
      categorySearch: '',
      activeCategoryMenu: null,
      editingCategory: null,
      showDeleteCategoryModal: false,
      categoryToDelete: null,
      activeSettingsTab: 'general',
      settingsTabs: [
        { id: 'general', label: 'General', icon: 'Settings' },
        { id: 'shipping', label: 'Shipping', icon: 'Truck' },
        { id: 'payment', label: 'Payment', icon: 'CreditCard' },
        { id: 'notifications', label: 'Notifications', icon: 'Bell' }
      ],
      monthlySalesChartInstance: null,
      revenueOrdersChartInstance: null,
      categoryPieChartInstance: null
    }
  },
  
  computed: {
    stats() {
      return {
        totalRevenue: this.orders.reduce((sum, o) => sum + o.total, 0),
        totalOrders: this.orders.length,
        totalProducts: this.products.length,
        lowStockItems: this.products.filter(p => p.stock <= 10).length
      }
    },
    
    recentOrders() {
      return this.orders.slice(0, 4)
    },
    
    lowStockProducts() {
      return this.products.filter(p => p.stock > 0 && p.stock <= 10).slice(0, 5)
    },
    
    activeTabLabel() {
      const tab = this.tabs.find(t => t.id === this.activeTab)
      return tab ? tab.label : ''
    },
    
    filteredProducts() {
      let filtered = this.products
      
      // Filter by status
      if (this.productStatusFilter !== 'all') {
        filtered = filtered.filter(p => p.status === this.productStatusFilter)
      }
      
      // Filter by search
      if (this.productSearch) {
        const search = this.productSearch.toLowerCase()
        filtered = filtered.filter(p => 
          p.name.toLowerCase().includes(search) ||
          p.sku.toLowerCase().includes(search) ||
          p.stock.toString().includes(search) ||
          p.status.toLowerCase().includes(search)
        )
      }
      
      return filtered
    },
    
    filteredOrders() {
      let filtered = this.orders
      
      // Filter by status
      if (this.orderStatusFilter !== 'all') {
        filtered = filtered.filter(o => o.status === this.orderStatusFilter)
      }
      
      // Filter by search
      if (this.orderSearch) {
        const search = this.orderSearch.toLowerCase()
        filtered = filtered.filter(o => 
          o.orderNumber.toLowerCase().includes(search) ||
          o.customer.name.toLowerCase().includes(search) ||
          o.customer.email.toLowerCase().includes(search)
        )
      }
      
      return filtered
    },
    
    filteredCustomers() {
      if (!this.customerSearch) return this.customers
      const search = this.customerSearch.toLowerCase()
      return this.customers.filter(c => 
        c.name.toLowerCase().includes(search) || 
        c.email.toLowerCase().includes(search)
      )
    },
    
    filteredCategories() {
      if (!this.categorySearch) return this.categories
      const search = this.categorySearch.toLowerCase()
      return this.categories.filter(c => 
        c.name.toLowerCase().includes(search) ||
        c.description.toLowerCase().includes(search)
      )
    },
    
    activeCustomers() {
      return this.customers.filter(c => c.status === 'active').length
    },
    
    averageOrderValue() {
      const total = this.customers.reduce((sum, c) => sum + c.totalSpent, 0)
      const orders = this.customers.reduce((sum, c) => sum + c.orders, 0)
      return orders > 0 ? Math.round(total / orders) : 0
    },
    
    topProducts() {
      return this.products
        .map(p => ({ ...p, sales: Math.floor(Math.random() * 100) + 20 }))
        .sort((a, b) => b.sales - a.sales)
        .slice(0, 5)
    },
    
    customerOrders() {
      // Filter orders for the selected customer
      if (!this.selectedCustomer) return []
      return this.orders.filter(o => o.customer.email === this.selectedCustomer.email)
    }
  },
  
  methods: {
    async loadAdminProfile() {
      const { useAuthStore } = await import('@/stores/auth')
      const authStore = useAuthStore()
      
      try {
        // Fetch fresh admin data from API
        await authStore.fetchUser()
        
        // Update admin profile display in header
        if (authStore.user) {
          // The user data is now updated from the API instead of mock data
          console.log('Admin profile loaded:', authStore.user)
        }
      } catch (error) {
        console.error('Failed to load admin profile:', error)
      }
    },
    
    selectTab(tabId) {
      this.activeTab = tabId
      this.mobileSidebarOpen = false
      
      // Initialize charts when analytics tab is selected
      if (tabId === 'analytics') {
        this.$nextTick(() => {
          this.initCharts()
        })
      }
    },
    
    formatDate(dateString) {
      const date = new Date(dateString)
      return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })
    },
    
    async handleLogout() {
      const { useAuthStore } = await import('@/stores/auth')
      const { useToast } = await import('vue-toastification')
      const authStore = useAuthStore()
      const toast = useToast()
      
      await authStore.logout()
      toast.success('Logged out successfully')
      this.$router.push('/login-page')
    },
    
    handleClickOutside(event) {
      // Close notifications dropdown if clicking outside
      if (this.showNotifications && !event.target.closest('.relative')) {
        this.showNotifications = false
      }
      // Close profile dropdown if clicking outside
      if (this.showProfileMenu && !event.target.closest('.relative')) {
        this.showProfileMenu = false
      }
      // Close customer actions dropdown if clicking outside
      if (this.showCustomerActions && !event.target.closest('.relative')) {
        this.showCustomerActions = null
      }
      // Close category menu dropdown if clicking outside
      if (this.activeCategoryMenu && !event.target.closest('.relative')) {
        this.activeCategoryMenu = null
      }
    },
    
    editProduct(product) {
      this.editingProduct = product
      this.productForm = {
        name: product.name,
        sku: product.sku,
        price: product.price,
        stock: product.stock,
        category: product.category,
        status: product.status,
        image: product.image,
        weight: product.weight
      }
      this.showProductModal = true
    },
    
    deleteProduct(productId) {
      this.deletingProductId = productId
      this.showDeleteModal = true
    },
    
    confirmDelete() {
      const index = this.products.findIndex(p => p.id === this.deletingProductId)
      if (index !== -1) {
        this.products.splice(index, 1)
      }
      this.showDeleteModal = false
      this.deletingProductId = null
    },
    
    cancelDelete() {
      this.showDeleteModal = false
      this.deletingProductId = null
    },
    
    saveProduct() {
      if (!this.productForm.name || !this.productForm.sku || !this.productForm.price) {
        alert('Please fill in all required fields')
        return
      }
      
      if (this.editingProduct) {
        // Update existing product
        const index = this.products.findIndex(p => p.id === this.editingProduct.id)
        if (index !== -1) {
          this.products[index] = {
            ...this.products[index],
            ...this.productForm
          }
          alert('Product updated successfully!')
        }
      } else {
        // Add new product
        const newProduct = {
          id: `p${this.products.length + 1}`,
          ...this.productForm
        }
        this.products.push(newProduct)
        alert('Product added successfully!')
      }
      
      this.showProductModal = false
      this.resetProductForm()
    },
    
    resetProductForm() {
      this.productForm = {
        name: '',
        sku: '',
        price: 0,
        stock: 0,
        category: '',
        status: 'active',
        image: '',
        weight: '250g'
      }
      this.editingProduct = null
    },
    
    viewOrder(order) {
      this.selectedOrder = order
      this.showOrderModal = true
    },
    
    toggleCustomerActions(customerId) {
      this.showCustomerActions = this.showCustomerActions === customerId ? null : customerId
    },
    
    viewCustomerDetails(customer) {
      this.selectedCustomer = customer
      this.showCustomerModal = true
      this.showCustomerActions = null
    },
    
    editCustomer(customer) {
      this.showCustomerActions = null
      this.showCustomerModal = false
      this.editingCustomer = customer
      this.customerForm = {
        name: customer.name,
        email: customer.email,
        phone: customer.phone,
        location: customer.location,
        status: customer.status
      }
      this.showEditCustomerModal = true
    },
    
    viewCustomerOrders(customer) {
      this.showCustomerActions = null
      this.selectedCustomer = customer
      this.showCustomerOrdersModal = true
    },
    
    saveCustomer() {
      if (!this.customerForm.name || !this.customerForm.email) {
        alert('Please fill in all required fields')
        return
      }
      
      if (this.editingCustomer) {
        const index = this.customers.findIndex(c => c.id === this.editingCustomer.id)
        if (index !== -1) {
          this.customers[index] = {
            ...this.customers[index],
            ...this.customerForm
          }
        }
      }
      
      this.showEditCustomerModal = false
      this.resetCustomerForm()
    },
    
    resetCustomerForm() {
      this.customerForm = {
        name: '',
        email: '',
        phone: '',
        location: '',
        status: 'active'
      }
      this.editingCustomer = null
    },
    
    deleteCustomer(customerId) {
      this.deletingCustomerId = customerId
      this.showDeleteCustomerModal = true
      this.showCustomerActions = null
    },
    
    confirmDeleteCustomer() {
      const index = this.customers.findIndex(c => c.id === this.deletingCustomerId)
      if (index !== -1) {
        this.customers.splice(index, 1)
      }
      this.showDeleteCustomerModal = false
      this.deletingCustomerId = null
    },
    
    cancelDeleteCustomer() {
      this.showDeleteCustomerModal = false
      this.deletingCustomerId = null
    },
    
    toggleCategoryMenu(categoryId) {
      this.activeCategoryMenu = this.activeCategoryMenu === categoryId ? null : categoryId
    },
    
    editCategory(category) {
      this.editingCategory = category
      this.activeCategoryMenu = null
      this.showCategoryDialog = true
    },
    

    
    deleteCategory(categoryId) {
      this.categoryToDelete = categoryId
      this.showDeleteCategoryModal = true
      this.activeCategoryMenu = null
    },
    
    confirmDeleteCategory() {
      const index = this.categories.findIndex(c => c.id === this.categoryToDelete)
      if (index !== -1) {
        this.categories.splice(index, 1)
      }
      this.showDeleteCategoryModal = false
      this.categoryToDelete = null
    },
    
    cancelDeleteCategory() {
      this.showDeleteCategoryModal = false
      this.categoryToDelete = null
    },
    
    initCharts() {
      console.log('initCharts called, activeTab:', this.activeTab)
      console.log('Refs available:', this.$refs)
      
      // Destroy existing chart instances first
      if (this.monthlySalesChartInstance) {
        this.monthlySalesChartInstance.destroy()
        this.monthlySalesChartInstance = null
      }
      if (this.revenueOrdersChartInstance) {
        this.revenueOrdersChartInstance.destroy()
        this.revenueOrdersChartInstance = null
      }
      if (this.categoryPieChartInstance) {
        this.categoryPieChartInstance.destroy()
        this.categoryPieChartInstance = null
      }
      
      // Use setTimeout to ensure DOM is fully rendered
      setTimeout(() => {
        try {
          console.log('Starting chart creation...')
          this.createMonthlySalesChart()
          this.createRevenueOrdersChart()
          this.createCategoryPieChart()
          console.log('Charts created successfully')
        } catch (error) {
          console.error('Error initializing charts:', error)
        }
      }, 100)
    },
    
    createMonthlySalesChart() {
      const canvas = this.$refs.monthlySalesChart
      console.log('Creating monthly sales chart, canvas:', canvas)
      if (!canvas) {
        console.warn('Monthly sales chart canvas not found')
        return
      }
      
      const ctx = canvas.getContext('2d')
      
      if (this.monthlySalesChartInstance) {
        this.monthlySalesChartInstance.destroy()
      }
      
      console.log('Initializing monthly sales chart...')
      this.monthlySalesChartInstance = new ChartJS(ctx, {
        type: 'bar',
        data: {
          labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov'],
          datasets: [{
            label: 'Revenue',
            data: [4200, 3800, 5100, 4500, 6200, 5800, 6800, 6500, 7300, 7900, 9200],
            backgroundColor: '#8B7355',
            borderRadius: 6
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              display: true,
              position: 'bottom'
            }
          },
          scales: {
            y: {
              beginAtZero: true,
              ticks: {
                callback: function(value) {
                  return '₹' + value.toLocaleString()
                }
              }
            }
          }
        }
      })
    },
    
    createRevenueOrdersChart() {
      const canvas = this.$refs.revenueOrdersChart
      if (!canvas) return
      
      const ctx = canvas.getContext('2d')
      
      if (this.revenueOrdersChartInstance) {
        this.revenueOrdersChartInstance.destroy()
      }
      
      this.revenueOrdersChartInstance = new ChartJS(ctx, {
        type: 'line',
        data: {
          labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov'],
          datasets: [
            {
              label: 'Revenue',
              data: [4200, 3800, 5100, 4500, 6200, 5800, 6800, 6500, 7300, 7900, 9200],
              borderColor: '#8B7355',
              backgroundColor: 'rgba(139, 115, 85, 0.1)',
              tension: 0.4,
              fill: true
            },
            {
              label: 'Orders',
              data: [142, 128, 173, 152, 198, 185, 215, 208, 234, 252, 294],
              borderColor: '#A89080',
              backgroundColor: 'rgba(168, 144, 128, 0.1)',
              tension: 0.4,
              fill: true
            }
          ]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              display: true,
              position: 'bottom'
            }
          },
          scales: {
            y: {
              beginAtZero: true
            }
          }
        }
      })
    },
    
    createCategoryPieChart() {
      const canvas = this.$refs.categoryPieChart
      if (!canvas) return
      
      const ctx = canvas.getContext('2d')
      
      if (this.categoryPieChartInstance) {
        this.categoryPieChartInstance.destroy()
      }
      
      this.categoryPieChartInstance = new ChartJS(ctx, {
        type: 'doughnut',
        data: {
          labels: ['Dried Fruits', 'Nuts', 'Seeds', 'Superfoods'],
          datasets: [{
            data: [39, 30, 16, 15],
            backgroundColor: [
              '#8B7355',
              '#A89080',
              '#C5ADA0',
              '#D9C7BA'
            ],
            borderWidth: 2,
            borderColor: '#ffffff'
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              display: true,
              position: 'right',
              labels: {
                generateLabels: function(chart) {
                  const data = chart.data
                  if (data.labels.length && data.datasets.length) {
                    return data.labels.map((label, i) => {
                      const value = data.datasets[0].data[i]
                      return {
                        text: `${label} ${value}%`,
                        fillStyle: data.datasets[0].backgroundColor[i],
                        hidden: false,
                        index: i
                      }
                    })
                  }
                  return []
                }
              }
            }
          }
        }
      })
    }
  },
  
  watch: {
    activeTab(newTab) {
      if (newTab === 'analytics') {
        this.$nextTick(() => {
          this.initCharts()
        })
      }
    }
  },
  
  async mounted() {
    // Fetch real admin profile data
    await this.loadAdminProfile()
    
    // Add click outside listener
    document.addEventListener('click', this.handleClickOutside)
    // Initialize charts if analytics tab is already active
    if (this.activeTab === 'analytics') {
      this.$nextTick(() => {
        this.initCharts()
      })
    }
  },
  
  beforeUnmount() {
    // Remove click outside listener
    document.removeEventListener('click', this.handleClickOutside)
    
    // Destroy chart instances
    if (this.monthlySalesChartInstance) {
      this.monthlySalesChartInstance.destroy()
    }
    if (this.revenueOrdersChartInstance) {
      this.revenueOrdersChartInstance.destroy()
    }
    if (this.categoryPieChartInstance) {
      this.categoryPieChartInstance.destroy()
    }
  }
}
</script>
``