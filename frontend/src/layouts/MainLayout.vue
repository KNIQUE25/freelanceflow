<template>
  <div class="min-h-screen bg-slate-50 dark:bg-slate-950 lg:flex">
    <Sidebar :open="sidebarOpen" @close="sidebarOpen = false" />
    <div class="min-w-0 flex-1">
      <Navbar @menu="sidebarOpen = !sidebarOpen" />
      <main class="min-h-[calc(100vh-64px)] p-4 sm:p-6 lg:p-8">
        <EmailVerificationNotice />
        <router-view />
      </main>
    </div>
    <div v-if="sidebarOpen" class="fixed inset-0 z-30 bg-slate-950/40 lg:hidden" @click="sidebarOpen = false"></div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import Navbar from '../components/Navbar.vue'
import Sidebar from '../components/Sidebar.vue'
import EmailVerificationNotice from '../components/EmailVerificationNotice.vue'

const sidebarOpen = ref(false)
</script>
