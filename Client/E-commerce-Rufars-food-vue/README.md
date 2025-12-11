# Rufars Foods - Vue.js E-commerce

This is a Vue.js conversion of the React e-commerce project for Rufars Foods, using the Options API.

## Features

- 🛍️ Full e-commerce functionality
- 🛒 Shopping cart with persistent state (Pinia)
- 📱 Responsive design
- 🎨 Same design as React version
- 🔄 Vue Router for navigation
- 💾 LocalStorage persistence for cart

## Tech Stack

- **Vue 3** - Progressive JavaScript framework
- **Vue Router** - Official router for Vue.js
- **Pinia** - State management (equivalent to Zustand in React)
- **Tailwind CSS** - Utility-first CSS framework
- **Lucide Vue** - Icon library
- **Vite** - Build tool

## Project Structure

```
src/
├── assets/          # Global styles
├── components/      # Reusable components
│   ├── ui/         # UI components (Button, etc.)
│   ├── Header.vue
│   ├── Footer.vue
│   ├── Hero.vue
│   └── ...
├── pages/          # Page components
│   ├── Home.vue
│   ├── Products.vue
│   ├── Cart.vue
│   └── ...
├── stores/         # Pinia stores
│   └── cart.js
├── router/         # Vue Router configuration
│   └── index.js
├── lib/            # Utility functions
│   └── utils.js
├── App.vue         # Root component
└── main.js         # Application entry point
```

## Getting Started

### Installation

```bash
cd Client/E-commerce-Rufars-food-vue
npm install
```

### Development

```bash
npm run dev
```

The application will be available at `http://localhost:5173`

### Build

```bash
npm run build
```

### Preview Production Build

```bash
npm run preview
```

## Key Differences from React Version

1. **State Management**: Uses Pinia instead of Zustand
2. **Syntax**: Vue Options API instead of React hooks
3. **Routing**: Vue Router instead of React Router
4. **Templates**: Vue template syntax instead of JSX
5. **Reactivity**: Vue's reactivity system instead of React's state

## Components Converted

- ✅ Header with cart count
- ✅ Footer
- ✅ Hero section
- ✅ Featured Products
- ✅ Benefits Section
- ✅ Product Card
- ✅ Product Listing with filters
- ✅ Shopping Cart
- ✅ Product Detail
- ✅ Login/Signup pages

## State Management

The cart state is managed using Pinia with localStorage persistence:

```javascript
// Using the cart store
import { useCartStore } from '@/stores/cart'

const cartStore = useCartStore()
cartStore.addItem(item)
cartStore.removeItem(id)
cartStore.updateQuantity(id, quantity)
```

## License

Same as the original React project.
