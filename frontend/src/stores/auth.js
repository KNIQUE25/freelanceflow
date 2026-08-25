import { defineStore } from 'pinia'
import { register, login, logout, getUser, forgotPassword, resetPassword, resendVerification } from '@/services/auth'

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
        async registerUser(data) {
            this.isLoading = true
            try {
                const response = await register(data)
                this.user = response.user
                return { success: true, data: response }
            } catch (error) {
                return { success: false, message: this.getErrorMessage(error), errors: error.response?.data?.errors || {} }
            } finally {
                this.isLoading = false
            }
        },

        async loginUser(data) {
            this.isLoading = true
            try {
                const response = await login(data)
                this.user = response.user
                return { success: true, data: response }
            } catch (error) {
                console.error('LOGIN ERROR:', error.response || error)
                return { success: false, message: this.getErrorMessage(error), errors: error.response?.data?.errors || {} }
            } finally {
                this.isLoading = false
            }
        },

        async fetchUser() {
            try {
                const response = await getUser()
                this.user = response.user
                return { success: true, data: response.user }
            } catch (error) {
                this.user = null
                return { success: false, message: this.getErrorMessage(error) }
            } finally {
                this.initialized = true
            }
        },

        async logoutUser() {
            this.isLoading = true
            try {
                await logout()
                this.user = null
                return { success: true }
            } catch (error) {
                return { success: false, message: this.getErrorMessage(error) }
            } finally {
                this.isLoading = false
            }
        },

        async forgotPassword(email) {
            this.isLoading = true
            try {
                const response = await forgotPassword(email)
                return { success: true, message: response.message || 'Password reset link sent.' }
            } catch (error) {
                return { success: false, message: this.getErrorMessage(error) }
            } finally {
                this.isLoading = false
            }
        },

        async resetPassword(data) {
            this.isLoading = true
            try {
                const response = await resetPassword(data)
                return { success: true, message: response.message || 'Password reset successfully.' }
            } catch (error) {
                return { success: false, message: this.getErrorMessage(error) }
            } finally {
                this.isLoading = false
            }
        },

        async resendVerification() {
            try {
                const response = await resendVerification()
                return { success: true, message: response.message }
            } catch (error) {
                return { success: false, message: this.getErrorMessage(error) }
            }
        },

        async register(data) {
            return this.registerUser(data)
        },

        async login(data) {
            return this.loginUser(data)
        },

        async logout() {
            return this.logoutUser()
        },

        getErrorMessage(error) {
            const response = error?.response
            if (!response) return 'Unable to connect to the server.'
            if (response.status === 419) return 'Your session expired. Please try again.'
            if (response.status === 422) {
                const errors = response.data?.errors
                if (errors) {
                    const firstError = Object.values(errors)[0]
                    if (Array.isArray(firstError)) return firstError[0]
                }
                return response.data?.message || 'Please check your input.'
            }
            if (response.status === 401) return 'Invalid email or password.'
            if (response.status === 403) return 'You are not authorized to perform this action.'
            if (response.status >= 500) return 'Server error. Please try again later.'
            return response.data?.message || 'Something went wrong. Please try again.'
        },
    },
})