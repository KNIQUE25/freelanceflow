import { defineStore } from 'pinia'
import { login, logout, getUser, register, forgotPassword, resetPassword, resendVerification } from '../services/auth'

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null,
    isLoading: false,
    initialized: false,
  }),
  getters: {
    isAuthenticated: (state) => !!state.user,
    isEmailVerified: (state) => !!state.user?.email_verified_at,
  },
  actions: {
    async fetchUser() {
      if (this.initialized) return this.user
      try {
        const { user } = await getUser()
        this.user = user
        return user
      } catch {
        this.user = null
        return null
      } finally {
        this.initialized = true
      }
    },
    async login(credentials) {
      this.isLoading = true
      try {
        const { user } = await login(credentials)
        this.user = user
        return { success: true, user }
      } catch (error) {
        return { success: false, message: error.response?.data?.message || 'Login failed.' }
      } finally {
        this.isLoading = false
      }
    },
    async register(data) {
      this.isLoading = true
      try {
        const { user } = await register(data)
        this.user = user
        return { success: true, user }
      } catch (error) {
        return { success: false, message: error.response?.data?.message || 'Registration failed.' }
      } finally {
        this.isLoading = false
      }
    },
    async logout() {
      try { await logout() } finally { this.user = null }
    },
    async forgotPassword(email) {
      try {
        const response = await forgotPassword(email)
        return { success: true, message: response.message }
      } catch (error) {
        return { success: false, message: error.response?.data?.message || 'Failed to send reset link.' }
      }
    },
    async resetPassword(data) {
      try {
        const response = await resetPassword(data)
        return { success: true, message: response.message }
      } catch (error) {
        return { success: false, message: error.response?.data?.message || 'Failed to reset password.' }
      }
    },
    async resendVerification() {
      try {
        const response = await resendVerification()
        return { success: true, message: response.message }
      } catch (error) {
        return { success: false, message: error.response?.data?.message || 'Failed to resend verification.' }
      }
    },
  },
})
