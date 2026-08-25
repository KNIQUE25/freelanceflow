<template>
  <label class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-700 shadow-sm dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200">
    <span aria-hidden="true">{{ icon }}</span>
    <select :value="themeStore.theme" aria-label="Theme" class="bg-transparent outline-none dark:bg-slate-900" @change="changeTheme"><option value="system">System</option><option value="light">Light</option><option value="dark">Dark</option></select>
  </label>
</template>
<script setup>
import { computed } from 'vue'; import { useThemeStore } from '@/stores/theme'; const themeStore=useThemeStore(); const icon=computed(()=>themeStore.theme==='dark'?'🌙':themeStore.theme==='light'?'☀️':'🖥️'); const changeTheme=e=>themeStore.setTheme(e.target.value)
</script>
