<template>
  <header class="bg-white px-4 py-3 shadow-sm dark:bg-slate-900 sm:px-6">
    <div class="flex items-center justify-between">
      <div class="flex items-center gap-3">
        <button
          class="text-slate-500 lg:hidden"
          @click="$emit('toggle-sidebar')"
          aria-label="Toggle menu"
        >
          <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
        <h1 class="text-base font-black text-slate-900 dark:text-white sm:text-lg">{{ currentRoute }}</h1>
      </div>

      <div class="flex items-center gap-4">
        <router-link to="/notifications" class="relative text-slate-500 hover:text-primary-600 dark:text-slate-400 dark:hover:text-primary-400">
          <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
          <span v-if="unreadCount" class="absolute right-0 top-0 grid h-5 min-w-5 place-items-center rounded-full bg-red-500 px-1 text-[10px] font-bold text-white">{{ unreadCount }}</span>
        </router-link>

        <div class="text-sm font-bold text-slate-800 dark:text-slate-100">{{ user?.name }}</div>
        <button
          class="rounded-lg bg-slate-100 px-3 py-1.5 text-sm font-semibold text-slate-700 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700"
          @click="handleLogout"
        >
          Logout
        </button>
      </div>
    </div>
  </header>
</template>

<script setup>
import { computed } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useAuthStore } from '../stores/auth'
import { useNotificationsStore } from '../stores/notifications'

defineEmits(['toggle-sidebar'])

const route = useRoute()
const router = useRouter()
const authStore = useAuthStore()
const notificationsStore = useNotificationsStore()

const user = computed(() => authStore.user)
const unreadCount = computed(() => notificationsStore.unreadCount)

const currentRoute = computed(() => {
  const name = route.name
  if (!name) return 'Dashboard'
  return name.charAt(0).toUpperCase() + name.slice(1).replace(/-/g, ' ')
})

const handleLogout = async () => {
  await authStore.logout()
  router.push('/login')
}
</script>