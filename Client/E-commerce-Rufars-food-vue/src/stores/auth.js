import { defineStore } from 'pinia'
import { authAPI } from '@/api.js'

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: JSON.parse(localStorage.getItem('user')) || null,
    token: localStorage.getItem('auth_token') || null,
    loading: false,
    error: null,
  }),

  getters: {
    isAuthenticated: (state) => !!state.token,
    isAdmin: (state) => state.user?.is_admin || false,
  },

  actions: {
    async register(data) {
      this.loading = true
      this.error = null

      try {
        const response = await authAPI.register(data)
        
        if (response.data.success) {
          // Don't auto-login after registration, redirect to login
          return { success: true, message: 'Registration successful! Please login.' }
        }
      } catch (error) {
        this.error = error.response?.data?.message || 'Registration failed'
        return { success: false, error: this.error }
      } finally {
        this.loading = false
      }
    },

    async login(data) {
      this.loading = true
      this.error = null

      try {
        const response = await authAPI.login(data)
        
        if (response.data.success) {
          this.token = response.data.token
          this.user = response.data.user
          
          localStorage.setItem('auth_token', this.token)
          localStorage.setItem('user', JSON.stringify(this.user))
          
          return { 
            success: true, 
            user: this.user,
            isAdmin: this.isAdmin 
          }
        }
      } catch (error) {
        this.error = error.response?.data?.message || 'Login failed'
        return { success: false, error: this.error }
      } finally {
        this.loading = false
      }
    },

    async logout() {
      try {
        if (this.token) {
          await authAPI.logout()
        }
      } catch (error) {
        console.error('Logout error:', error)
      } finally {
        this.token = null
        this.user = null
        localStorage.removeItem('auth_token')
        localStorage.removeItem('user')
      }
    },

    async fetchUser() {
      if (!this.token) return

      try {
        const response = await authAPI.getUser()
        if (response.data.success) {
          this.user = response.data.user
          localStorage.setItem('user', JSON.stringify(this.user))
          return { success: true, user: this.user }
        }
      } catch (error) {
        console.error('Fetch user error:', error)
        this.logout()
        return { success: false }
      }
    },

    async updateProfile(data) {
      this.loading = true
      this.error = null

      try {
        const response = await authAPI.updateProfile(data)
        if (response.data.success) {
          this.user = response.data.user
          localStorage.setItem('user', JSON.stringify(this.user))
          return { success: true, message: 'Profile updated successfully' }
        }
      } catch (error) {
        this.error = error.response?.data?.message || 'Failed to update profile'
        return { success: false, error: this.error }
      } finally {
        this.loading = false
      }
    },

    async forgotPassword(email) {
      this.loading = true
      this.error = null

      try {
        const response = await authAPI.forgotPassword(email)
        return { success: true, message: response.data.message }
      } catch (error) {
        this.error = error.response?.data?.message || 'Failed to send reset link'
        return { success: false, error: this.error }
      } finally {
        this.loading = false
      }
    },

    async resetPassword(data) {
      this.loading = true
      this.error = null

      try {
        const response = await authAPI.resetPassword(data)
        return { success: true, message: response.data.message }
      } catch (error) {
        this.error = error.response?.data?.message || 'Failed to reset password'
        return { success: false, error: this.error }
      } finally {
        this.loading = false
      }
    },
  },
})
