<template>
  <div class="min-h-screen bg-background">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <!-- Header -->
      <div class="flex items-center gap-4 mb-8">
        <router-link
          to="/products"
          class="flex items-center gap-2 text-muted-foreground hover:text-primary transition-colors"
        >
          <ArrowLeft :size="20" />
          <span class="hidden sm:inline">Back to Products</span>
        </router-link>
      </div>

      <div class="grid lg:grid-cols-2 gap-8 lg:gap-12 mb-12">
        <!-- Image -->
        <div class="space-y-4">
          <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-border">
            <img
              :src="product.image || '/placeholder.svg'"
              :alt="product.name"
              class="w-full h-80 sm:h-96 lg:h-[500px] object-cover"
            />
          </div>

          <!-- Action Buttons -->
          <div class="flex gap-3">
            <Button
              variant="outline"
              class="flex-1 border-2 border-primary text-primary hover:bg-primary/5 rounded-xl py-3"
            >
              <Heart :size="20" class="mr-2" />
              Add to Wishlist
            </Button>
            <Button
              variant="outline"
              class="flex-1 border-2 border-primary text-primary hover:bg-primary/5 rounded-xl py-3"
            >
              <Share2 :size="20" class="mr-2" />
              Share
            </Button>
          </div>
        </div>

        <!-- Details -->
        <div class="space-y-6">
          <div>
            <div class="inline-block bg-secondary/10 text-secondary px-4 py-2 rounded-xl text-sm font-semibold mb-4">
              {{ product.category }}
            </div>
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-foreground mb-4 leading-tight">
              {{ product.name }}
            </h1>
            <p class="text-lg text-muted-foreground leading-relaxed">
              {{ product.description }}
            </p>
          </div>

          <!-- Rating -->
          <div class="flex items-center gap-4">
            <div class="flex items-center gap-1">
              <Star
                v-for="i in 5"
                :key="i"
                :size="20"
                :class="i <= Math.floor(product.rating) ? 'fill-yellow-400 text-yellow-400' : 'text-gray-300'"
              />
            </div>
            <span class="text-muted-foreground">
              {{ product.rating }} ({{ product.reviews }} reviews)
            </span>
          </div>

          <!-- Price -->
          <div class="flex items-center gap-4">
            <span class="text-4xl md:text-5xl font-bold text-primary">
              ₹{{ product.price }}
            </span>
            <span class="text-lg text-muted-foreground">/pack</span>
          </div>

          <!-- Quantity Selector -->
          <div class="space-y-4">
            <span class="text-lg font-semibold text-foreground">
              Quantity:
            </span>
            <div class="flex items-center gap-4">
              <div class="flex items-center bg-background rounded-xl border border-border">
                <button
                  @click="quantity = Math.max(1, quantity - 1)"
                  class="p-3 hover:bg-muted transition-colors rounded-l-xl"
                  :disabled="quantity <= 1"
                >
                  <Minus :size="20" />
                </button>
                <span class="px-6 py-3 font-bold text-lg min-w-[3rem] text-center">
                  {{ quantity }}
                </span>
                <button
                  @click="quantity++"
                  class="p-3 hover:bg-muted transition-colors rounded-r-xl"
                >
                  <Plus :size="20" />
                </button>
              </div>
              <div class="text-right">
                <p class="text-sm text-muted-foreground">Total</p>
                <p class="text-2xl font-bold text-primary">
                  ₹{{ product.price * quantity }}
                </p>
              </div>
            </div>
          </div>

          <!-- Add to Cart Button -->
          <Button
            @click="handleAddToCart"
            class="w-full bg-primary hover:bg-primary/90 text-white rounded-xl py-4 text-lg font-semibold shadow-lg hover:shadow-xl transition-all duration-300"
          >
            <ShoppingCart :size="24" class="mr-3" />
            Add to Cart
          </Button>

          <!-- Trust Badges -->
          <div class="grid grid-cols-3 gap-4 pt-6 border-t border-border">
            <div class="text-center">
              <div class="w-12 h-12 bg-secondary/10 rounded-xl flex items-center justify-center mx-auto mb-2">
                <Truck :size="24" class="text-secondary" />
              </div>
              <p class="text-sm font-medium text-foreground">Free Shipping</p>
              <p class="text-xs text-muted-foreground">Over ₹1000</p>
            </div>
            <div class="text-center">
              <div class="w-12 h-12 bg-secondary/10 rounded-xl flex items-center justify-center mx-auto mb-2">
                <Shield :size="24" class="text-secondary" />
              </div>
              <p class="text-sm font-medium text-foreground">100% Natural</p>
              <p class="text-xs text-muted-foreground">No Preservatives</p>
            </div>
            <div class="text-center">
              <div class="w-12 h-12 bg-secondary/10 rounded-xl flex items-center justify-center mx-auto mb-2">
                <Leaf :size="24" class="text-secondary" />
              </div>
              <p class="text-sm font-medium text-foreground">Organic</p>
              <p class="text-xs text-muted-foreground">Certified</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Tabs Section -->
      <div class="bg-white rounded-2xl border border-border overflow-hidden">
        <!-- Tab Headers -->
        <div class="flex border-b border-border">
          <button
            v-for="tab in tabs"
            :key="tab.id"
            @click="activeTab = tab.id"
            :class="[
              'flex-1 px-6 py-4 font-semibold transition-colors',
              activeTab === tab.id
                ? 'bg-primary text-white'
                : 'text-muted-foreground hover:bg-muted/50'
            ]"
          >
            {{ tab.label }}
          </button>
        </div>

        <!-- Tab Content -->
        <div class="p-6 md:p-8">
          <!-- Nutrition Tab -->
          <div v-if="activeTab === 'nutrition'" class="space-y-6">
            <!-- Description -->
            <div class="mb-8">
              <h3 class="text-2xl font-bold text-foreground mb-4">
                Product Description
              </h3>
              <p class="text-muted-foreground leading-relaxed text-lg">
                {{ product.description }}
              </p>
            </div>

            <!-- Nutritional Information Table -->
            <div>
              <h3 class="text-2xl font-bold text-foreground mb-4">
                Nutritional Information
              </h3>
              <p class="text-muted-foreground mb-6">
                Per {{ product.nutritionalInfo?.servingSize || '100g' }} serving
              </p>
              
              <div class="overflow-x-auto">
                <table class="w-full border border-border">
                  <thead>
                    <tr class="bg-muted/30">
                      <th class="text-left py-3 px-4 font-semibold text-foreground border-b border-border">Nutrient</th>
                      <th class="text-right py-3 px-4 font-semibold text-foreground border-b border-border">Amount</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(value, key) in nutritionDisplay" :key="key" class="border-b border-border hover:bg-muted/10">
                      <td class="py-3 px-4 text-foreground">{{ formatNutrientName(key) }}</td>
                      <td class="py-3 px-4 text-right font-medium text-foreground">{{ value }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <!-- Benefits Tab -->
          <div v-if="activeTab === 'benefits'" class="space-y-6">
            <h3 class="text-2xl font-bold text-foreground mb-6">
              Health Benefits
            </h3>
            
            <div class="space-y-4">
              <div class="flex items-start gap-4 p-4 bg-muted/10 rounded-xl">
                <div class="w-10 h-10 bg-secondary/20 rounded-full flex items-center justify-center flex-shrink-0">
                  <Leaf :size="20" class="text-secondary" />
                </div>
                <div>
                  <h4 class="font-semibold text-foreground mb-2">Rich in Nutrients</h4>
                  <p class="text-muted-foreground">Packed with essential vitamins, minerals, and antioxidants to support your overall health and wellness.</p>
                </div>
              </div>

              <div class="flex items-start gap-4 p-4 bg-muted/10 rounded-xl">
                <div class="w-10 h-10 bg-secondary/20 rounded-full flex items-center justify-center flex-shrink-0">
                  <Heart :size="20" class="text-secondary" />
                </div>
                <div>
                  <h4 class="font-semibold text-foreground mb-2">Heart Health</h4>
                  <p class="text-muted-foreground">Contains healthy fats and fiber that support cardiovascular health and help maintain healthy cholesterol levels.</p>
                </div>
              </div>

              <div class="flex items-start gap-4 p-4 bg-muted/10 rounded-xl">
                <div class="w-10 h-10 bg-secondary/20 rounded-full flex items-center justify-center flex-shrink-0">
                  <Shield :size="20" class="text-secondary" />
                </div>
                <div>
                  <h4 class="font-semibold text-foreground mb-2">Immune Support</h4>
                  <p class="text-muted-foreground">High in antioxidants and vitamins that help strengthen your immune system and protect against oxidative stress.</p>
                </div>
              </div>

              <div class="flex items-start gap-4 p-4 bg-muted/10 rounded-xl">
                <div class="w-10 h-10 bg-secondary/20 rounded-full flex items-center justify-center flex-shrink-0">
                  <Star :size="20" class="text-secondary" />
                </div>
                <div>
                  <h4 class="font-semibold text-foreground mb-2">Energy Boost</h4>
                  <p class="text-muted-foreground">Natural source of energy from healthy carbohydrates and proteins, perfect for pre or post-workout snacking.</p>
                </div>
              </div>
            </div>

            <!-- Customer Reviews Section -->
            <div class="mt-8 pt-8 border-t border-border">
              <div class="flex items-center justify-between mb-6">
                <h3 class="text-2xl font-bold text-foreground">
                  Customer Reviews
                </h3>
                <div class="flex items-center gap-2">
                  <div class="flex items-center">
                    <Star
                      v-for="i in 5"
                      :key="i"
                      :size="20"
                      :class="i <= Math.floor(product.rating) ? 'fill-yellow-400 text-yellow-400' : 'text-gray-300'"
                    />
                  </div>
                  <span class="text-lg font-semibold text-foreground">
                    {{ product.rating }} out of 5
                  </span>
                </div>
              </div>
              
              <p class="text-muted-foreground text-center py-8">
                Based on {{ product.reviews }} customer reviews
              </p>
              
              <div class="text-center">
                <Button class="bg-primary hover:bg-primary/90 text-white rounded-xl px-6 py-3">
                  Write a Review
                </Button>
              </div>
            </div>
          </div>

          <!-- Details Tab -->
          <div v-if="activeTab === 'details'" class="space-y-6">
            <h3 class="text-2xl font-bold text-foreground mb-6">
              Product Details
            </h3>
            
            <div class="overflow-x-auto">
              <table class="w-full border border-border">
                <tbody>
                  <tr class="border-b border-border hover:bg-muted/10">
                    <td class="py-4 px-4 font-semibold text-foreground bg-muted/20 w-1/3">Ingredients</td>
                    <td class="py-4 px-4 text-foreground">{{ productIngredients }}</td>
                  </tr>
                  <tr class="border-b border-border hover:bg-muted/10">
                    <td class="py-4 px-4 font-semibold text-foreground bg-muted/20">Storage Instructions</td>
                    <td class="py-4 px-4 text-foreground">Store in a cool, dry place away from direct sunlight</td>
                  </tr>
                  <tr class="border-b border-border hover:bg-muted/10">
                    <td class="py-4 px-4 font-semibold text-foreground bg-muted/20">Shelf Life</td>
                    <td class="py-4 px-4 text-foreground">12-18 months from date of manufacture</td>
                  </tr>
                  <tr class="border-b border-border hover:bg-muted/10">
                    <td class="py-4 px-4 font-semibold text-foreground bg-muted/20">Origin</td>
                    <td class="py-4 px-4 text-foreground">{{ productOrigin }}</td>
                  </tr>
                  <tr class="border-b border-border hover:bg-muted/10">
                    <td class="py-4 px-4 font-semibold text-foreground bg-muted/20">Certifications</td>
                    <td class="py-4 px-4 text-foreground">100% Organic, Non-GMO, Gluten-Free</td>
                  </tr>
                  <tr class="hover:bg-muted/10">
                    <td class="py-4 px-4 font-semibold text-foreground bg-muted/20">Package Size</td>
                    <td class="py-4 px-4 text-foreground">250g / 500g / 1kg available</td>
                  </tr>
                </tbody>
              </table>
            </div>

            <!-- Additional Info -->
            <div class="mt-6 p-4 bg-secondary/10 rounded-xl">
              <h4 class="font-semibold text-foreground mb-2 flex items-center gap-2">
                <Shield :size="20" class="text-secondary" />
                Quality Guarantee
              </h4>
              <p class="text-muted-foreground">
                All our products are carefully selected and tested to ensure the highest quality standards. 
                We source directly from trusted suppliers and maintain strict quality control throughout the process.
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { Star, ShoppingCart, Minus, Plus, Heart, Share2, Truck, Shield, Leaf, ArrowLeft } from 'lucide-vue-next'
import Button from '@/components/ui/Button.vue'
import { useCartStore } from '@/stores/cart'
import { products } from '@/data/products'

export default {
  name: 'ProductDetail',
  
  components: {
    Star,
    ShoppingCart,
    Minus,
    Plus,
    Heart,
    Share2,
    Truck,
    Shield,
    Leaf,
    ArrowLeft,
    Button
  },
  
  data() {
    return {
      quantity: 1,
      activeTab: 'nutrition',
      tabs: [
        { id: 'nutrition', label: 'Nutrition' },
        { id: 'benefits', label: 'Benefits' },
        { id: 'details', label: 'Details' }
      ]
    }
  },
  
  computed: {
    product() {
      const id = this.$route.params.id
      return products.find(p => p.id === id) || products[0]
    },
    
    nutritionDisplay() {
      if (!this.product.nutritionalInfo) return {}
      const info = { ...this.product.nutritionalInfo }
      delete info.servingSize
      return info
    },
    
    productIngredients() {
      const categoryIngredients = {
        'Dried Fruits': `100% Organic ${this.product.name}`,
        'Nuts': `100% Raw ${this.product.name}`,
        'Seeds': `100% Natural ${this.product.name}`,
        'Superfoods': `100% Organic ${this.product.name}`
      }
      return categoryIngredients[this.product.category] || `100% ${this.product.name}`
    },
    
    productOrigin() {
      const origins = {
        'Dried Fruits': 'California, USA / India',
        'Nuts': 'California, USA / Mediterranean',
        'Seeds': 'USA / South America',
        'Superfoods': 'South America / Asia'
      }
      return origins[this.product.category] || 'Various Premium Sources'
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
        quantity: this.quantity
      })
      this.quantity = 1
    },
    
    formatNutrientName(key) {
      const names = {
        calories: 'Calories',
        protein: 'Protein',
        fiber: 'Dietary Fiber',
        vitaminC: 'Vitamin C',
        vitaminA: 'Vitamin A',
        vitaminE: 'Vitamin E',
        vitaminB6: 'Vitamin B6',
        calcium: 'Calcium',
        magnesium: 'Magnesium',
        zinc: 'Zinc',
        selenium: 'Selenium',
        potassium: 'Potassium',
        omega3: 'Omega-3 Fatty Acids',
        monounsaturatedFat: 'Monounsaturated Fat',
        antioxidants: 'Antioxidants'
      }
      return names[key] || key.charAt(0).toUpperCase() + key.slice(1)
    }
  }
}
</script>
