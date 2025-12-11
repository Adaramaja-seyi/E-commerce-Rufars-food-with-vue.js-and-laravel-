<template>
  <footer class="bg-foreground text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
      <div class="grid md:grid-cols-4 gap-8 mb-8">
        <!-- Brand -->
        <div>
          <div class="flex items-center gap-2 mb-4">
            <div class="w-10 h-10 bg-accent rounded-lg flex items-center justify-center">
              <span class="text-foreground font-bold">RF</span>
            </div>
            <span class="font-bold text-lg">Rufars Foods</span>
          </div>
          <p class="text-white/70">
            Premium dried fruits and superfoods for a healthier lifestyle.
          </p>
        </div>

        <!-- Quick Links -->
        <div>
          <h3 class="font-semibold mb-4">Quick Links</h3>
          <ul class="space-y-2 text-white/70">
            <li>
              <router-link to="/" class="hover:text-white transition">
                Home
              </router-link>
            </li>
            <li>
              <router-link to="/products" class="hover:text-white transition">
                Shop
              </router-link>
            </li>
            <li>
              <a href="#" class="hover:text-white transition">
                About Us
              </a>
            </li>
            <li>
              <a href="#" class="hover:text-white transition">
                Contact
              </a>
            </li>
          </ul>
        </div>

        <!-- Customer Service -->
        <div>
          <h3 class="font-semibold mb-4">Customer Service</h3>
          <ul class="space-y-2 text-white/70">
            <li>
              <a href="#" class="hover:text-white transition">
                Shipping Info
              </a>
            </li>
            <li>
              <a href="#" class="hover:text-white transition">
                Returns
              </a>
            </li>
            <li>
              <a href="#" class="hover:text-white transition">
                FAQ
              </a>
            </li>
            <li>
              <a href="#" class="hover:text-white transition">
                Privacy Policy
              </a>
            </li>
          </ul>
        </div>

        <!-- Contact -->
        <div>
          <h3 class="font-semibold mb-4">Contact Us</h3>
          <ul class="space-y-3 text-white/70">
            <li class="flex items-center gap-2">
              <Mail :size="16" />
              <a
                href="mailto:info@rufarfoods.com"
                class="hover:text-white transition"
              >
                info@rufarfoods.com
              </a>
            </li>
            <li class="flex items-center gap-2">
              <Phone :size="16" />
              <a
                href="tel:+919876543210"
                class="hover:text-white transition"
              >
                +91 98765 43210
              </a>
            </li>
            <li class="flex items-start gap-2">
              <MapPin :size="16" class="mt-1" />
              <span>123 Food Street, Mumbai, India</span>
            </li>
          </ul>
        </div>
      </div>

      <div class="border-t border-white/20 pt-8 text-center text-white/70">
        <p>&copy; 2025 Rufars Foods. All rights reserved.</p>
      </div>
    </div>
  </footer>
</template>

<script>
import { Mail, Phone, MapPin } from 'lucide-vue-next'

export default {
  name: 'Footer',
  
  components: {
    Mail,
    Phone,
    MapPin
  }
}
</script>
