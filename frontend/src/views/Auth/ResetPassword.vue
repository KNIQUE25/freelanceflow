<template>
  <div class="bg-white p-8 rounded shadow-md">
    <h2 class="text-2xl font-bold mb-6 text-center">Reset Password</h2>
    <form @submit.prevent="handleSubmit">
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Email</label>
        <input v-model="email" type="email" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500" required />
      </div>
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">New Password</label>
        <input v-model="password" type="password" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500" required />
      </div>
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Confirm Password</label>
        <input v-model="password_confirmation" type="password" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500" required />
      </div>
      <button type="submit" class="w-full bg-primary-600 text-white py-2 rounded hover:bg-primary-700 transition" :disabled="loading">
        {{ loading ? 'Resetting...' : 'Reset Password' }}
      </button>
      <p v-if="message" :class="['text-sm mt-2', success ? 'text-green-600' : 'text-red-600']">{{ message }}</p>
    </form>
    <p class="mt-4 text-sm text-center">
      <router-link to="/login" class="text-primary-600 hover:underline">Back to Login</router-link>
    </p>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useAuthStore } from '../../stores/auth'

const route = useRoute()
const router = useRouter()
const authStore = useAuthStore()

const email = ref('')
const password = ref('')
const password_confirmation = ref('')
const loading = ref(false)
const message = ref('')
const success = ref(false)

onMounted(() => {
  if (route.query.email) {
    email.value = route.query.email
  }
})

async function handleSubmit() {
  loading.value = true
  message.value = ''
  const result = await authStore.resetPassword({
    email: email.value,
    password: password.value,
    password_confirmation: password_confirmation.value,
    token: route.params.token || route.query.token,
  })
  success.value = result.success
  message.value = result.message
  loading.value = false
  if (result.success) {
    setTimeout(() => {
      router.push('/login')
    }, 2000)
  }
}
</script>