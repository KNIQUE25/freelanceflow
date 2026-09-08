<template>
  <div class="min-h-screen bg-gray-100 flex">

    <!-- Sidebar -->
    <aside
      class="w-64 bg-gray-900 text-white fixed inset-y-0 left-0 z-50
             transform transition-transform duration-300
             lg:translate-x-0"
      :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    >
      <!-- Logo -->
      <div class="h-16 flex items-center px-6 border-b border-gray-800">
        <h1 class="text-xl font-bold text-blue-400">
          FreelanceFlow
        </h1>
      </div>

      <!-- Admin label -->
      <div class="px-6 py-4 border-b border-gray-800">
        <p class="text-xs uppercase tracking-wider text-gray-400">
          Administration
        </p>

        <p class="mt-1 font-semibold">
          Admin Panel
        </p>
      </div>

      <!-- Navigation -->
      <nav class="p-4 space-y-1">

        <RouterLink
          to="/admin/dashboard"
          class="nav-link"
          :class="{ 'nav-active': isActive('/admin/dashboard') }"
        >
          <span>📊</span>
          <span>Dashboard</span>
        </RouterLink>

        <RouterLink
          to="/admin/users"
          class="nav-link"
          :class="{ 'nav-active': isActive('/admin/users') }"
        >
          <span>👥</span>
          <span>Users</span>
        </RouterLink>

        <RouterLink
          to="/admin/invoices"
          class="nav-link"
          :class="{ 'nav-active': isActive('/admin/invoices') }"
        >
          <span>🧾</span>
          <span>Invoices</span>
        </RouterLink>

        <RouterLink
          to="/admin/payments"
          class="nav-link"
          :class="{ 'nav-active': isActive('/admin/payments') }"
        >
          <span>💳</span>
          <span>Payments</span>
        </RouterLink>

        <RouterLink
          to="/admin/audit-logs"
          class="nav-link"
          :class="{ 'nav-active': isActive('/admin/audit-logs') }"
        >
          <span>📋</span>
          <span>Audit Logs</span>
        </RouterLink>

        <RouterLink
          to="/admin/errors"
          class="nav-link"
          :class="{ 'nav-active': isActive('/admin/errors') }"
        >
          <span>⚠️</span>
          <span>Error Logs</span>
        </RouterLink>

      </nav>

      <!-- Bottom -->
      <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-gray-800">

        <RouterLink
          to="/dashboard"
          class="nav-link"
        >
          <span>↩️</span>
          <span>Back to App</span>
        </RouterLink>

        <button
          @click="logout"
          :disabled="loggingOut"
          class="nav-link w-full text-left text-red-400 hover:bg-red-900/30"
        >
          <span>🚪</span>
          <span>
            {{ loggingOut ? 'Logging out...' : 'Logout' }}
          </span>
        </button>

      </div>
    </aside>

    <!-- Mobile overlay -->
    <div
      v-if="sidebarOpen"
      @click="sidebarOpen = false"
      class="fixed inset-0 bg-black/50 z-40 lg:hidden"
    ></div>

    <!-- Main -->
    <div class="flex-1 lg:ml-64 min-h-screen">

      <!-- Header -->
      <header
        class="h-16 bg-white border-b border-gray-200
               flex items-center justify-between px-4 lg:px-6
               sticky top-0 z-30"
      >

        <button
          @click="sidebarOpen = !sidebarOpen"
          class="lg:hidden text-gray-600 text-2xl"
        >
          ☰
        </button>

        <div class="hidden lg:block">
          <h2 class="font-semibold text-gray-800">
            Admin Panel
          </h2>
        </div>

        <!-- Admin user -->
        <div class="flex items-center gap-3 ml-auto">

          <div class="text-right hidden sm:block">
            <p class="text-sm font-semibold text-gray-800">
              {{ authStore.user?.name || 'Administrator' }}
            </p>

            <p class="text-xs text-gray-500">
              {{ authStore.user?.email }}
            </p>
          </div>

          <div
            class="w-10 h-10 rounded-full bg-blue-600
                   text-white flex items-center justify-center
                   font-bold"
          >
            {{ initials }}
          </div>

        </div>

      </header>

      <!-- Page content -->
      <main class="p-4 lg:p-6">
        <RouterView />
      </main>

    </div>

  </div>
</template>

<script setup>
import { computed, ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const route = useRoute()
const router = useRouter()
const authStore = useAuthStore()

const sidebarOpen = ref(false)
const loggingOut = ref(false)

const initials = computed(() => {
  const name = authStore.user?.name || 'Admin'

  return name
    .split(' ')
    .map(word => word.charAt(0))
    .join('')
    .substring(0, 2)
    .toUpperCase()
})

const isActive = (path) => {
  return route.path === path || route.path.startsWith(path + '/')
}

const logout = async () => {
  if (loggingOut.value) return

  loggingOut.value = true

  try {
    await authStore.logout()

    await router.push({
      name: 'login'
    })
  } catch (error) {
    console.error('Admin logout failed:', error)
  } finally {
    loggingOut.value = false
  }
}
</script>

<style scoped>
.nav-link {
  @apply flex items-center gap-3 px-4 py-3 rounded-lg
         text-gray-300 transition-colors duration-200
         hover:bg-gray-800 hover:text-white;
}

.nav-active {
  @apply bg-blue-600 text-white hover:bg-blue-600;
}
</style>