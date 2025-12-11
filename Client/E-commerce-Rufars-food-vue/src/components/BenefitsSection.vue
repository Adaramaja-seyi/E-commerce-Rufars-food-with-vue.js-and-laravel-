<template>
  <section id="benefits" class="py-16 md:py-24 bg-background">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-12">
        <h2 class="text-3xl md:text-4xl font-bold text-foreground mb-4">
          Why Choose Rufars Foods?
        </h2>
        <p class="text-lg text-muted-foreground max-w-2xl mx-auto">
          We're committed to bringing you the finest superfoods with
          uncompromising quality
        </p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
        <div
          v-for="(benefit, index) in benefits"
          :key="index"
          class="bg-white rounded-lg p-6 text-center border border-border hover:shadow-lg transition"
        >
          <div class="flex justify-center mb-4">
            <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center">
              <component :is="benefit.icon" :size="24" class="text-primary" />
            </div>
          </div>
          <h3 class="text-lg font-semibold text-foreground mb-2">
            {{ benefit.title }}
          </h3>
          <p class="text-muted-foreground">{{ benefit.description }}</p>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import { Leaf, Heart, Zap, Award } from 'lucide-vue-next'

export default {
  name: 'BenefitsSection',
  
  components: {
    Leaf,
    Heart,
    Zap,
    Award
  },
  
  data() {
    return {
      benefits: [
        {
          icon: Leaf,
          title: "Natural & Organic",
          description: "No artificial additives, preservatives, or chemicals. Pure nature in every bite.",
        },
        {
          icon: Heart,
          title: "Nutrient-Rich",
          description: "Packed with vitamins, minerals, and antioxidants for optimal health.",
        },
        {
          icon: Zap,
          title: "Energy Boost",
          description: "Natural sugars and nutrients provide sustained energy throughout the day.",
        },
        {
          icon: Award,
          title: "Premium Quality",
          description: "Carefully sourced and quality-tested for the best taste and nutrition.",
        },
      ]
    }
  }
}
</script>
