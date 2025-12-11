<template>
  <div class="space-y-6">
    <!-- Mobile Filter Toggle -->
    <div class="flex items-center justify-between md:hidden">
      <h2 class="text-xl font-bold text-foreground">Filter Products</h2>
      <Button
        variant="outline"
        @click="showFilters = !showFilters"
        class="flex items-center gap-2"
      >
        <Filter :size="16" />
        Filters
      </Button>
    </div>

    <!-- Filters -->
    <div :class="['space-y-6', showFilters ? 'block' : 'hidden md:block']">
      <!-- Category Filter -->
      <div class="bg-white rounded-xl p-6 border border-border">
        <h3 class="font-semibold text-foreground mb-4 text-lg">
          Category
        </h3>
        <div class="flex flex-wrap gap-3">
          <Button
            :variant="selectedCategory === null ? 'default' : 'outline'"
            @click="selectedCategory = null"
            :class="[
              'rounded-xl px-4 py-2',
              selectedCategory === null
                ? 'bg-primary text-white shadow-md'
                : 'border-primary text-primary hover:bg-primary/5'
            ]"
          >
            All Products
          </Button>
          <Button
            v-for="cat in categories"
            :key="cat"
            :variant="selectedCategory === cat ? 'default' : 'outline'"
            @click="selectedCategory = cat"
            :class="[
              'rounded-xl px-4 py-2',
              selectedCategory === cat
                ? 'bg-primary text-white shadow-md'
                : 'border-primary text-primary hover:bg-primary/5'
            ]"
          >
            {{ cat }}
          </Button>
        </div>
      </div>

      <!-- Sort Filter -->
      <div class="bg-white rounded-xl p-6 border border-border">
        <h3 class="font-semibold text-foreground mb-4 text-lg">
          Sort By
        </h3>
        <select
          v-model="sortBy"
          class="w-full px-4 py-3 border border-border rounded-xl bg-white text-foreground focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary"
        >
          <option value="featured">Featured</option>
          <option value="price-low">Price: Low to High</option>
          <option value="price-high">Price: High to Low</option>
          <option value="rating">Highest Rated</option>
        </select>
      </div>
    </div>

    <!-- Results Count -->
    <div class="flex items-center justify-between">
      <p class="text-muted-foreground">
        Showing {{ filteredProducts.length }} products
        <span v-if="selectedCategory"> in {{ selectedCategory }}</span>
      </p>
    </div>

    <!-- Products Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
      <ProductCard
        v-for="product in filteredProducts"
        :key="product.id"
        :product="product"
      />
    </div>

    <!-- No Results -->
    <div v-if="filteredProducts.length === 0" class="text-center py-16">
      <div class="w-24 h-24 bg-muted/20 rounded-full flex items-center justify-center mx-auto mb-6">
        <Filter :size="48" class="text-muted-foreground" />
      </div>
      <h3 class="text-xl font-semibold text-foreground mb-2">
        No products found
      </h3>
      <p class="text-muted-foreground mb-6">
        Try adjusting your filters to see more products.
      </p>
      <Button
        @click="clearFilters"
        class="bg-primary hover:bg-primary/90 text-white rounded-xl px-6 py-3"
      >
        Clear Filters
      </Button>
    </div>
  </div>
</template>

<script>
import { Filter } from 'lucide-vue-next'
import ProductCard from './ProductCard.vue'
import Button from './ui/Button.vue'
import { products } from '@/data/products'

export default {
  name: 'ProductListing',
  
  components: {
    Filter,
    ProductCard,
    Button
  },
  
  data() {
    return {
      selectedCategory: null,
      sortBy: 'featured',
      showFilters: false,
      categories: ['Dried Fruits', 'Nuts', 'Seeds', 'Superfoods'],
      allProducts: products
    }
  },
  
  computed: {
    filteredProducts() {
      let products = this.selectedCategory
        ? this.allProducts.filter(p => p.category === this.selectedCategory)
        : [...this.allProducts]
      
      if (this.sortBy === 'price-low') {
        products.sort((a, b) => a.price - b.price)
      } else if (this.sortBy === 'price-high') {
        products.sort((a, b) => b.price - a.price)
      } else if (this.sortBy === 'rating') {
        products.sort((a, b) => b.rating - a.rating)
      }
      
      return products
    }
  },
  
  methods: {
    clearFilters() {
      this.selectedCategory = null
      this.sortBy = 'featured'
    }
  }
}
</script>
