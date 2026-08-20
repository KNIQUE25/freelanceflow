<template>
  <div class="rounded-3xl bg-white p-8 text-center shadow-xl ring-1 ring-slate-200">
    <div class="mx-auto grid h-16 w-16 place-items-center rounded-full" :class="verified ? 'bg-emerald-100' : 'bg-red-100'"><span class="text-3xl">{{ verified ? '✓' : '!' }}</span></div>
    <h2 class="mt-5 text-2xl font-black" :class="verified ? 'text-emerald-700' : 'text-red-700'">{{ verified ? 'Email verified' : 'Verification failed' }}</h2>
    <p class="mt-2 text-sm text-slate-500">{{ verified ? 'Your FreelanceFlow account is ready to use.' : 'The verification link is invalid or has expired.' }}</p>
    <router-link :to="auth.isAuthenticated ? '/dashboard' : '/login'" class="mt-6 inline-flex rounded-xl bg-indigo-600 px-5 py-3 text-sm font-bold text-white">{{ auth.isAuthenticated ? 'Go to dashboard' : 'Go to login' }}</router-link>
  </div>
</template>
<script setup>
import { computed } from 'vue'
import { useRoute } from 'vue-router'
import { useAuthStore } from '../stores/auth'
const route = useRoute(); const auth = useAuthStore(); const verified = computed(() => route.query.verified !== '0')
</script>
