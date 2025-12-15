import axios from "axios";

// Create axios instance with base configuration
const api = axios.create({
  baseURL: "http://127.0.0.1:8000/api",
  withCredentials: true,
  headers: {
    "Content-Type": "application/json",
    Accept: "application/json",
  },
});

// Request interceptor - runs before every request is sent
api.interceptors.request.use(
  (config) => {
    const token = localStorage.getItem("auth_token");
    if (token) {
      config.headers.Authorization = `Bearer ${token}`;
    }

    if (config.data instanceof FormData) {
      config.headers["Content-Type"] = "multipart/form-data";
    } else {
      config.headers["Content-Type"] = "application/json";
    }

    return config;
  },
  (error) => Promise.reject(error)
);

// Response interceptor - handle common errors
api.interceptors.response.use(
  (response) => {
    return response;
  },
  (error) => {
    if (error.response && error.response.status === 401) {
      localStorage.removeItem("auth_token");
      localStorage.removeItem("user");
      // Redirect to login on 401
      if (window.location.pathname !== '/login') {
        window.location.href = '/login';
      }
    }
    return Promise.reject(error);
  }
);

// API endpoints
export const authAPI = {
  // Register new user
  register: (data) =>
    api.post("/register", {
      name: data.name,
      email: data.email,
      password: data.password,
      password_confirmation: data.password_confirmation,
    }),

  // Login user
  login: (data) =>
    api.post("/login", {
      email: data.email,
      password: data.password,
    }),

  // Logout user
  logout: () => api.post("/logout"),

  // Get authenticated user
  getUser: () => api.get("/user"),

  // Forgot password
  forgotPassword: (email) => api.post("/forgot-password", { email }),

  // Reset password
  resetPassword: (data) =>
    api.post("/reset-password", {
      email: data.email,
      password: data.password,
      password_confirmation: data.password_confirmation,
      token: data.token,
    }),

  // Update user profile
  updateProfile: (data) => api.put("/user/profile", data),

  // Email verification
  verifyEmail: (token) => api.post("/email/verify", { token }),
  resendVerification: () => api.post("/email/resend"),
};

export const productsAPI = {
  // Get all products
  getAll: (params = {}) => api.get("/products", { params }),

  // Get single product
  getById: (id) => api.get(`/products/${id}`),

  // Get products by category
  getByCategory: (category) => api.get(`/products/category/${category}`),

  // Create product (Admin only)
  create: (data) => api.post("/products", data),

  // Update product (Admin only)
  update: (id, data) => api.put(`/products/${id}`, data),

  // Delete product (Admin only)
  delete: (id) => api.delete(`/products/${id}`),
};

export const cartAPI = {
  // Get cart items
  get: () => api.get("/cart"),

  // Add item to cart
  add: (productId, quantity = 1) =>
    api.post("/cart", {
      product_id: productId,
      quantity,
    }),

  // Update cart item quantity
  update: (itemId, quantity) => api.put(`/cart/${itemId}`, { quantity }),

  // Remove item from cart
  remove: (itemId) => api.delete(`/cart/${itemId}`),

  // Clear cart
  clear: () => api.delete("/cart"),
};

export const ordersAPI = {
  // Get user's orders
  getAll: () => api.get("/orders"),

  // Get single order
  getById: (id) => api.get(`/orders/${id}`),

  // Create order
  create: (data) => api.post("/orders", data),

  // Cancel order
  cancel: (id) => api.put(`/orders/${id}/cancel`),

  // Admin: Get all orders
  adminGetAll: () => api.get("/admin/orders"),

  // Admin: Update order status
  adminUpdateStatus: (id, status) =>
    api.put(`/admin/orders/${id}/status`, { status }),
};

export const addressAPI = {
  // Get all addresses
  getAll: () => api.get("/addresses"),

  // Get single address
  getById: (id) => api.get(`/addresses/${id}`),

  // Create address
  create: (data) => api.post("/addresses", data),

  // Update address
  update: (id, data) => api.put(`/addresses/${id}`, data),

  // Delete address
  delete: (id) => api.delete(`/addresses/${id}`),

  // Set default address
  setDefault: (id) => api.put(`/addresses/${id}/default`),
};

export const paymentMethodAPI = {
  // Get all payment methods
  getAll: () => api.get("/payment-methods"),

  // Get single payment method
  getById: (id) => api.get(`/payment-methods/${id}`),

  // Create payment method
  create: (data) => api.post("/payment-methods", data),

  // Update payment method
  update: (id, data) => api.put(`/payment-methods/${id}`, data),

  // Delete payment method
  delete: (id) => api.delete(`/payment-methods/${id}`),

  // Set default payment method
  setDefault: (id) => api.put(`/payment-methods/${id}/default`),
};

export default api;
