<template>
  <div class="bg-white p-8 rounded shadow-md">
    <h2 class="text-2xl font-bold mb-6 text-center">Forgot Password</h2>
    <p class="text-sm text-gray-600 mb-4 text-center">Enter your email and we'll send you a reset link.</p>
    <form @submit.prevent="handleSubmit">
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Email</label>
        <input v-model="email" type="email" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required />
      </div>
      <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition" :disabled="loading">
        {{ loading ? 'Sending...' : 'Send Reset Link' }}
      </button>
      <p v-if="message" :class="['text-sm mt-2', success ? 'text-green-600' : 'text-red-600']">{{ message }}</p>
    </form>
    <p class="mt-4 text-sm text-center">
      <router-link to="/login" class="text-blue-600 hover:underline">Back to Login</router-link>
    </p>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useAuthStore } from '../stores/auth'

const authStore = useAuthStore()
const email = ref('')
const loading = ref(false)
const message = ref('')
const success = ref(false)

async function handleSubmit() {
  loading.value = true
  message.value = ''
  const result = await authStore.forgotPassword(email.value)
  success.value = result.success
  message.value = result.message
  loading.value = false
}
</script>