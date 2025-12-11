<template>
  <section class="py-16 md:py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-12">
        <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-foreground mb-4">
          Featured Superfoods
        </h2>
        <p class="text-lg md:text-xl text-muted-foreground max-w-3xl mx-auto leading-relaxed">
          Handpicked selections of our most popular superfoods, carefully
          sourced for maximum nutrition and flavor
        </p>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8 mb-12">
        <ProductCard
          v-for="product in products"
          :key="product.id"
          :product="product"
        />
      </div>

      <div class="text-center">
        <router-link to="/products">
          <Button class="bg-primary hover:bg-primary/90 text-white rounded-xl px-8 py-4 text-lg font-semibold shadow-lg hover:shadow-xl transition-all duration-300">
            View All Products
          </Button>
        </router-link>
      </div>
    </div>
  </section>
</template>

<script>
import ProductCard from './ProductCard.vue'
import Button from './ui/Button.vue'
import { products } from '@/data/products'

export default {
  name: 'FeaturedProducts',
  
  components: {
    ProductCard,
    Button
  },
  
  data() {
    return {
      products: products.slice(0, 4) // Show first 4 products as featured
    }
  }
}
</script>
