<template>
  <div class="bg-white rounded-2xl overflow-hidden border border-border hover:shadow-xl transition-all duration-300 cursor-pointer h-full flex flex-col group">
    <!-- Image -->
    <div class="relative h-56 bg-background overflow-hidden">
      <router-link :to="`/product/${product.id}`">
        <img
          :src="product.image || '/placeholder.svg'"
          :alt="product.name"
          class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
        />
      </router-link>

      <!-- Category Badge -->
      <div class="absolute top-3 left-3 bg-secondary/90 text-white px-3 py-1 rounded-full text-xs font-semibold backdrop-blur-sm">
        {{ product.category }}
      </div>

      <!-- Wishlist Button -->
      <button class="absolute top-3 right-3 p-2 bg-white/90 backdrop-blur-sm rounded-full hover:bg-white transition-colors shadow-sm">
        <Heart :size="16" class="text-muted-foreground hover:text-red-500" />
      </button>
    </div>

    <!-- Content -->
    <div class="p-5 flex-1 flex flex-col">
      <router-link :to="`/product/${product.id}`">
        <h3 class="font-bold text-lg text-foreground mb-2 line-clamp-2 hover:text-primary transition-colors">
          {{ product.name }}
        </h3>
      </router-link>

      <!-- Description -->
      <p v-if="product.description" class="text-sm text-muted-foreground mb-3 line-clamp-2">
        {{ product.description }}
      </p>

      <!-- Nutritional Info -->
      <div v-if="product.nutritionalInfo" class="flex items-center gap-4 mb-3 text-xs text-muted-foreground">
        <div class="flex items-center gap-1">
          <Leaf :size="12" class="text-secondary" />
          <span>{{ product.nutritionalInfo.calories }} cal</span>
        </div>
        <div class="flex items-center gap-1">
          <span class="w-2 h-2 bg-primary rounded-full"></span>
          <span>{{ product.nutritionalInfo.protein }} protein</span>
        </div>
        <div class="flex items-center gap-1">
          <span class="w-2 h-2 bg-accent rounded-full"></span>
          <span>{{ product.nutritionalInfo.fiber }} fiber</span>
        </div>
      </div>

      <!-- Rating -->
      <div class="flex items-center gap-2 mb-4">
        <div class="flex items-center">
          <Star
            v-for="i in 5"
            :key="i"
            :size="16"
            :class="i <= Math.floor(product.rating) ? 'fill-yellow-400 text-yellow-400' : 'text-gray-300'"
          />
        </div>
        <span class="text-sm text-muted-foreground">
          {{ product.rating }} ({{ product.reviews }} reviews)
        </span>
      </div>

      <!-- Price and Button -->
      <div class="mt-auto flex items-center justify-between">
        <div>
          <span class="text-2xl font-bold text-primary">
            ₹{{ product.price }}
          </span>
          <span class="text-sm text-muted-foreground ml-1">/pack</span>
        </div>
        <Button
          size="sm"
          class="bg-primary hover:bg-primary/90 text-white rounded-xl px-4 py-2 shadow-sm hover:shadow-md transition-all duration-200"
          @click="handleAddToCart"
        >
          <ShoppingCart :size="16" class="mr-2" />
          Add
        </Button>
      </div>
    </div>
  </div>
</template>

<script>
import { Star, ShoppingCart, Heart, Leaf } from 'lucide-vue-next'
import Button from './ui/Button.vue'
import { useCartStore } from '@/stores/cart'

export default {
  name: 'ProductCard',
  
  components: {
    Star,
    ShoppingCart,
    Heart,
    Leaf,
    Button
  },
  
  props: {
    product: {
      type: Object,
      required: true
    }
  },
  
  methods: {
    handleAddToCart() {
      const cartStore = useCartStore()
      cartStore.addItem({
        id: this.product.id,
        name: this.product.name,
        price: this.product.price,
        image: this.product.image,
        quantity: 1
      })
    }
  }
}
</script>
