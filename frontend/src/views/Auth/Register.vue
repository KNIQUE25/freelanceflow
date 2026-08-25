<template>
  <div class="w-full rounded-3xl border border-slate-200 bg-white p-6 shadow-xl shadow-slate-900/5 dark:border-slate-800 dark:bg-slate-900 sm:p-8">
    <div class="mb-7 text-center">
      <router-link to="/" class="mx-auto mb-4 inline-flex items-center gap-3" aria-label="FreelanceFlow home">
        <img src="/ff-logo.png" alt="FreelanceFlow" class="h-14 w-14 rounded-2xl object-contain" />
        <span class="text-xl font-black text-slate-900 dark:text-white">Freelance<span class="text-primary-600 dark:text-primary-400">Flow</span></span>
      </router-link>
      <h1 class="text-2xl font-black text-slate-900 dark:text-white">Create your account</h1>
      <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Start managing clients, invoices and payments.</p>
    </div>
    <form @submit.prevent="handleRegister" class="space-y-4">
      <div>
        <label for="name" class="mb-1.5 block text-sm font-semibold text-slate-700 dark:text-slate-200">Full name</label>
        <input id="name" v-model.trim="name" type="text" autocomplete="name" class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-primary-500 focus:ring-4 focus:ring-primary-500/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:placeholder:text-slate-500" required />
      </div>
      <div>
        <label for="email" class="mb-1.5 block text-sm font-semibold text-slate-700 dark:text-slate-200">Email</label>
        <input id="email" v-model.trim="email" type="email" autocomplete="email" class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-primary-500 focus:ring-4 focus:ring-primary-500/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:placeholder:text-slate-500" required />
      </div>
      <PasswordField id="password" label="Password" v-model="password" :show="showPassword" @toggle="showPassword = !showPassword" />
      <PasswordField id="password_confirmation" label="Confirm password" v-model="password_confirmation" :show="showConfirmation" @toggle="showConfirmation = !showConfirmation" />
      <div v-if="error" class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-700 dark:border-red-900/60 dark:bg-red-950/40 dark:text-red-300">{{ error }}</div>
      <button type="submit" class="w-full rounded-xl bg-primary-600 px-4 py-3.5 text-sm font-bold text-white shadow-lg shadow-primary-600/20 transition hover:bg-primary-700 disabled:cursor-not-allowed disabled:opacity-60" :disabled="loading">
        {{ loading ? 'Creating account…' : 'Create Account' }}
      </button>
    </form>
    <p class="mt-6 text-center text-sm text-slate-600 dark:text-slate-400">
      Already have an account? <router-link to="/login" class="font-bold text-primary-600 hover:underline dark:text-primary-400">Sign in</router-link>
    </p>
    <router-link to="/" class="mt-3 block text-center text-sm font-semibold text-slate-500 hover:text-primary-600 dark:text-slate-400 dark:hover:text-primary-400">← Back to home</router-link>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'
import PasswordField from '@/components/PasswordField.vue'

const router = useRouter()
const authStore = useAuthStore()

const name = ref('')
const email = ref('')
const password = ref('')
const password_confirmation = ref('')
const showPassword = ref(false)
const showConfirmation = ref(false)
const loading = ref(false)
const error = ref('')

async function handleRegister() {
  if (password.value !== password_confirmation.value) {
    error.value = 'Passwords do not match.'
    return
  }

  loading.value = true
  error.value = ''

  const result = await authStore.register({
    name: name.value,
    email: email.value,
    password: password.value,
    password_confirmation: password_confirmation.value,
  })

  if (result.success) {
    await router.push('/dashboard')
  } else {
    error.value = result.message
  }

  loading.value = false
}
</script>