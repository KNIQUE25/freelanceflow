<template>
  <div class="max-w-md mx-auto bg-white p-8 rounded shadow-md">
    <!-- Logo -->
    <div class="flex justify-center mb-6">
      <img
        src="/ff-logo.png"
        alt="FreelanceFlow Logo"
        class="w-24 h-24 object-contain"
      />
    </div>

    <h2 class="text-2xl font-bold mb-4 text-center">Verify Your Email</h2>
    <p class="text-gray-600 mb-4 text-center">
      We sent a verification link to <strong>{{ user?.email }}</strong>.
      Please check your inbox and click the link to verify your account.
    </p>
    <p v-if="message" :class="['text-sm text-center', success ? 'text-green-600' : 'text-red-600']">
      {{ message }}
    </p>
    <div class="flex flex-col gap-2 mt-4">
      <button
        @click="resend"
        class="bg-primary-600 text-white px-4 py-2 rounded hover:bg-primary-700 transition"
        :disabled="loading"
      >
        {{ loading ? 'Sending...' : 'Resend Verification Email' }}
      </button>
      <button
        @click="handleLogout"
        class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300 transition"
      >
        Logout
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '../stores/auth'

const router = useRouter()
const authStore = useAuthStore()

const user = computed(() => authStore.user)
const loading = ref(false)
const message = ref('')
const success = ref(false)

async function resend() {
  loading.value = true
  message.value = ''
  const result = await authStore.resendVerification()
  success.value = result.success
  message.value = result.message
  loading.value = false
}

async function handleLogout() {
  await authStore.logout()
  router.push('/login')
}
</script>