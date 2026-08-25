<template>
  <div class="min-h-screen bg-slate-50 px-4 py-6 transition-colors duration-300 dark:bg-slate-950 sm:px-6 sm:py-8">
    <header class="mx-auto mb-6 flex w-full max-w-2xl items-center justify-between">
      <router-link to="/" class="flex items-center gap-2.5" aria-label="FreelanceFlow home"><img src="/ff-logo.png" alt="FreelanceFlow" class="h-10 w-10 rounded-xl object-contain" /><span class="font-black text-slate-900 dark:text-white">Freelance<span class="text-primary-600 dark:text-primary-400">Flow</span></span></router-link>
      <ThemeSwitcher />
    </header>
    <main class="mx-auto flex w-full max-w-2xl items-center justify-center"><div class="w-full max-w-md"><router-view /></div></main>
  </div>
</template>
<script setup>import ThemeSwitcher from '@/components/ThemeSwitcher.vue'</script>
