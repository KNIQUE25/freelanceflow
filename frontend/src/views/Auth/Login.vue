<template>
  <div class="w-full rounded-3xl border border-slate-200 bg-white p-6 shadow-xl shadow-slate-900/5 dark:border-slate-800 dark:bg-slate-900 sm:p-8">
    <div class="mb-8 text-center">
      <router-link to="/" class="mx-auto mb-5 inline-flex items-center gap-3" aria-label="FreelanceFlow home">
        <img src="/ff-logo.png" alt="FreelanceFlow" class="h-14 w-14 rounded-2xl object-contain" />
        <span class="text-xl font-black text-slate-900 dark:text-white">Freelance<span class="text-primary-600 dark:text-primary-400">Flow</span></span>
      </router-link>
      <h1 class="text-2xl font-black text-slate-900 dark:text-white">Welcome back</h1>
      <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Sign in to manage your freelance business.</p>
    </div>
    <form @submit.prevent="handleLogin" class="space-y-5">
      <div><label for="login-email" class="auth-label">Email</label><input id="login-email" v-model.trim="email" type="email" autocomplete="email" class="auth-input" required /></div>
      <div>
        <div class="mb-1.5 flex items-center justify-between"><label for="login-password" class="auth-label mb-0">Password</label><router-link to="/forgot-password" class="text-xs font-bold text-primary-600 hover:text-primary-700 dark:text-primary-400">Forgot password?</router-link></div>
        <div class="relative"><input id="login-password" v-model="password" :type="showPassword ? 'text' : 'password'" autocomplete="current-password" class="auth-input pr-12" required /><button type="button" class="password-toggle" :aria-label="showPassword ? 'Hide password' : 'Show password'" @click="showPassword = !showPassword"><svg v-if="!showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M2.5 12s3.5-6 9.5-6 9.5 6 9.5 6-3.5 6-9.5 6-9.5-6-9.5-6Z"/><circle cx="12" cy="12" r="2.5"/></svg><svg v-else xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="m3 3 18 18"/><path d="M10.6 5.1A10.7 10.7 0 0 1 12 5c6 0 9.5 7 9.5 7a17.8 17.8 0 0 1-3.1 3.9M6.2 6.3C3.7 8.2 2.5 12 2.5 12s3.5 6 9.5 6c1 0 1.9-.2 2.7-.5"/><path d="M9.9 9.9a3 3 0 0 0 4.2 4.2"/></svg></button></div>
      </div>
      <div v-if="error" class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-700 dark:border-red-900/60 dark:bg-red-950/40 dark:text-red-300">{{ error }}</div>
      <button type="submit" class="w-full rounded-xl bg-primary-600 px-4 py-3.5 text-sm font-bold text-white shadow-lg shadow-primary-600/20 transition hover:bg-primary-700 disabled:cursor-not-allowed disabled:opacity-60" :disabled="loading">{{ loading ? 'Signing in…' : 'Sign In' }}</button>
    </form>
    <p class="mt-6 text-center text-sm text-slate-600 dark:text-slate-400">Don't have an account? <router-link to="/register" class="font-bold text-primary-600 hover:underline dark:text-primary-400">Create one</router-link></p>
    <router-link to="/" class="mt-3 block text-center text-sm font-semibold text-slate-500 hover:text-primary-600 dark:text-slate-400 dark:hover:text-primary-400">← Back to home</router-link>
  </div>
</template>
<script setup>
import { ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'
const router = useRouter(); const route = useRoute(); const authStore = useAuthStore()
const email = ref(''); const password = ref(''); const showPassword = ref(false); const loading = ref(false); const error = ref('')
async function handleLogin() { loading.value = true; error.value = ''; const result = await authStore.loginUser({ email: email.value, password: password.value }); if (result.success) await router.push(route.query.redirect || '/dashboard'); else error.value = result.message; loading.value = false }
</script>
<style scoped>
.auth-label { @apply mb-1.5 block text-sm font-semibold text-slate-700 dark:text-slate-200; }
.auth-input { @apply w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-primary-500 focus:ring-4 focus:ring-primary-500/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:placeholder:text-slate-500; }
.password-toggle { @apply absolute right-0 top-0 grid h-full w-12 place-items-center text-slate-400 transition hover:text-primary-600 dark:text-slate-500 dark:hover:text-primary-400; }
</style>
