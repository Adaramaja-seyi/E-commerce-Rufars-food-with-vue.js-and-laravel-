<template>
  <div class="py-8 md:py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="mb-8">
        <h1 class="text-3xl md:text-4xl font-bold text-foreground mb-4">
          Our Superfood Collection
        </h1>
        <p class="text-lg text-muted-foreground">
          Discover our premium range of dried fruits, nuts, and seeds
        </p>
      </div>
      <ProductListing />
    </div>
  </div>
</template>

<script>
import ProductListing from '@/components/ProductListing.vue'

export default {
  name: 'Products',
  components: {
    ProductListing
  }
}
</script>
/q