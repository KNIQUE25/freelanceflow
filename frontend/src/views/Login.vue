<template>
  <div class="bg-white p-8 rounded shadow-md">
    <h2 class="text-2xl font-bold mb-6 text-center">Login</h2>
    <form @submit.prevent="handleLogin">
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Email</label>
        <input v-model="email" type="email" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500" required />
      </div>
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Password</label>
        <input v-model="password" type="password" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500" required />
      </div>
      <div class="flex justify-end mb-4">
        <router-link to="/forgot-password" class="text-sm text-primary-600 hover:underline">Forgot password?</router-link>
      </div>
      <button type="submit" class="w-full bg-primary-600 text-white py-2 rounded hover:bg-primary-700 transition" :disabled="loading">
        {{ loading ? 'Logging in...' : 'Login' }}
      </button>
      <p v-if="error" class="text-red-600 text-sm mt-2">{{ error }}</p>
    </form>
    <p class="mt-4 text-sm text-center">
      Don't have an account? <router-link to="/register" class="text-primary-600 hover:underline">Register</router-link>
    </p>
    <p class="mt-4 text-sm text-center">
      <router-link to="/" class="text-primary-600 hover:underline">← Back to Home</router-link>
    </p>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '../stores/auth'

const router = useRouter()
const authStore = useAuthStore()

const email = ref('')
const password = ref('')
const loading = ref(false)
const error = ref('')

async function handleLogin() {
  loading.value = true
  error.value = ''
  const result = await authStore.login({ email: email.value, password: password.value })
  if (result.success) {
    router.push('/dashboard')
  } else {
    error.value = result.message
  }
  loading.value = false
}
</script>