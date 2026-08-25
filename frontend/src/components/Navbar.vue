<template>
  <header class="sticky top-0 z-20 flex h-16 items-center justify-between border-b border-slate-200 bg-white/90 px-4 dark:border-slate-800 dark:bg-slate-900/90 backdrop-blur sm:px-6">
    <div class="flex items-center gap-3">
      <button class="rounded-xl border border-slate-200 p-2 text-slate-600 dark:border-slate-700 dark:text-slate-300 hover:bg-slate-50 lg:hidden" aria-label="Open menu" @click="$emit('menu')">☰</button>
      <div>
        <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Workspace</p>
        <h1 class="text-base font-black text-slate-900 dark:text-white sm:text-lg">{{ currentRoute }}</h1>
      </div>
    </div>

    <div class="flex items-center gap-2 sm:gap-4">
      <ThemeSwitcher />
      <router-link to="/notifications" class="relative rounded-xl p-2 text-slate-500 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800" aria-label="Notifications">
        <span class="text-xl">♢</span>
        <span v-if="unreadCount" class="absolute right-0 top-0 grid h-5 min-w-5 place-items-center rounded-full bg-red-500 px-1 text-[10px] font-bold text-white">{{ unreadCount }}</span>
      </router-link>
      <div class="hidden text-right sm:block">
        <div class="text-sm font-bold text-slate-800 dark:text-slate-100">{{ user?.name }}</div>
        <div class="text-xs text-slate-400">{{ user?.email }}</div>
      </div>
      <button class="rounded-xl border border-slate-200 px-3 py-2 text-xs font-bold text-slate-600 hover:bg-slate-50 dark:border-slate-700 dark:text-slate-200 dark:hover:bg-slate-800" @click="handleLogout">Logout</button>
    </div>
  </header>
</template>

<script setup>
import { computed, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useAuthStore } from '../stores/auth'
import { useNotificationsStore } from '../stores/notifications'
import ThemeSwitcher from './ThemeSwitcher.vue'

defineEmits(['menu'])

const route = useRoute()
const router = useRouter()
const authStore = useAuthStore()
const notificationsStore = useNotificationsStore()
const user = computed(() => authStore.user)
const unreadCount = computed(() => notificationsStore.unreadCount)
const currentRoute = computed(() => {
  const value = route.name || 'dashboard'
  return String(value).replace(/-/g, ' ').replace(/\b\w/g, c => c.toUpperCase())
})

onMounted(() => notificationsStore.fetchNotifications())

async function handleLogout() {
  await authStore.logout()
  router.push('/login')
}
</script>
