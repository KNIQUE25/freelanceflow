<template>
  <aside
    class="fixed inset-y-0 left-0 z-40 flex w-72 -translate-x-full flex-col bg-white text-slate-900 shadow-2xl transition-transform duration-200 dark:bg-slate-950 dark:text-white lg:sticky lg:top-0 lg:h-screen lg:w-64 lg:translate-x-0 lg:shadow-none"
    :class="open ? 'translate-x-0' : ''"
  >
    <div class="flex items-center justify-between border-b border-slate-200 px-5 py-5 dark:border-white/10">
      <router-link to="/dashboard" class="flex items-center gap-3" @click="close">
        <img src="/ff-logo.png" alt="FreelanceFlow" class="h-10 w-10 rounded-xl object-contain" />
        <div>
          <div class="font-black text-slate-900 dark:text-white">FreelanceFlow</div>
          <div class="text-xs text-slate-500 dark:text-slate-400">Invoicing made simple</div>
        </div>
      </router-link>
      <button
        class="rounded-lg p-2 text-slate-500 hover:bg-slate-100 dark:text-slate-400 dark:hover:bg-white/10 lg:hidden"
        aria-label="Close menu"
        @click="close"
      >✕</button>
    </div>

    <nav class="flex-1 space-y-1 overflow-y-auto p-4">
      <router-link
        v-for="item in menu"
        :key="item.to"
        :to="item.to"
        class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-100 hover:text-slate-900 dark:text-slate-300 dark:hover:bg-white/10 dark:hover:text-white"
        active-class="bg-primary-600 text-white shadow-lg shadow-primary-950/30"
        @click="close"
      >
        <span class="w-6 text-center">{{ item.icon }}</span>
        <span>{{ item.label }}</span>
      </router-link>
    </nav>

    <div class="border-t border-slate-200 p-4 text-xs text-slate-500 dark:border-white/10 dark:text-slate-500">
      © {{ year }} FreelanceFlow
    </div>
  </aside>
</template>

<script setup>
defineProps({ open: Boolean })
const emit = defineEmits(['close'])
const year = new Date().getFullYear()
const menu = [
  { to: '/dashboard', label: 'Dashboard', icon: '▦' },
  { to: '/clients', label: 'Clients', icon: '◉' },
  { to: '/invoices', label: 'Invoices', icon: '▤' },
  { to: '/payments', label: 'Payments', icon: '◆' },
  { to: '/reports', label: 'Reports', icon: '◒' },
  { to: '/notifications', label: 'Notifications', icon: '◌' },
  { to: '/profile', label: 'Profile', icon: '◎' },
  { to: '/settings', label: 'Business Settings', icon: '⚙' },
]
const close = () => emit('close')
</script>