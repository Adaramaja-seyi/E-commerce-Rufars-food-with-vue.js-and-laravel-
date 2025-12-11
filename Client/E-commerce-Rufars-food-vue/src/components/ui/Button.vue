<template>
  <button
    :class="buttonClasses"
    :disabled="disabled"
    @click="$emit('click', $event)"
  >
    <slot />
  </button>
</template>

<script>
import { cn } from '@/lib/utils'

export default {
  name: 'Button',
  
  props: {
    variant: {
      type: String,
      default: 'default',
      validator: (value) => ['default', 'outline', 'ghost', 'destructive', 'secondary'].includes(value)
    },
    size: {
      type: String,
      default: 'default',
      validator: (value) => ['default', 'sm', 'lg', 'icon'].includes(value)
    },
    disabled: {
      type: Boolean,
      default: false
    }
  },
  
  emits: ['click'],
  
  computed: {
    buttonClasses() {
      const baseClasses = 'inline-flex items-center justify-center rounded-md font-medium transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50'
      
      const variants = {
        default: 'bg-primary text-primary-foreground hover:bg-primary/90',
        outline: 'border border-input bg-background hover:bg-accent hover:text-accent-foreground',
        ghost: 'hover:bg-accent hover:text-accent-foreground',
        destructive: 'bg-destructive text-destructive-foreground hover:bg-destructive/90',
        secondary: 'bg-secondary text-secondary-foreground hover:bg-secondary/80'
      }
      
      const sizes = {
        default: 'h-10 px-4 py-2',
        sm: 'h-9 rounded-md px-3',
        lg: 'h-11 rounded-md px-8',
        icon: 'h-10 w-10'
      }
      
      return cn(
        baseClasses,
        variants[this.variant],
        sizes[this.size]
      )
    }
  }
}
</script>
