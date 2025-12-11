<template>
  <div>
    <Hero />
    <FeaturedProducts />
    <BenefitsSection />
  </div>
</template>

<script>
import Hero from '@/components/Hero.vue'
import FeaturedProducts from '@/components/FeaturedProducts.vue'
import BenefitsSection from '@/components/BenefitsSection.vue'

export default {
  name: 'Home',
  
  components: {
    Hero,
    FeaturedProducts,
    BenefitsSection
  }
}
</script>
