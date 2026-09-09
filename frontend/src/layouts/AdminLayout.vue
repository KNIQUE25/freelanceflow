<template>
  <div class="min-h-screen bg-slate-100 dark:bg-slate-950">

    <!-- Mobile Header -->
    <header
      class="sticky top-0 z-40 flex h-16 items-center justify-between
             border-b border-slate-200 bg-white px-4
             dark:border-slate-800 dark:bg-slate-900
             lg:hidden"
    >

      <button
        @click="sidebarOpen = true"
        class="rounded-lg p-2 text-slate-600 hover:bg-slate-100
               dark:text-slate-300 dark:hover:bg-slate-800"
      >
        ☰
      </button>

      <div class="flex items-center gap-2">

        <img
          src="/ff-logo.png"
          alt="FreelanceFlow"
          class="h-9 w-9 rounded-lg"
        />

        <span class="font-black text-slate-900 dark:text-white">
          Freelance<span class="text-primary-600">Flow</span>
        </span>

      </div>

      <button
        @click="handleLogout"
        class="text-sm font-bold text-red-600"
      >
        Logout
      </button>

    </header>


    <!-- Overlay -->
    <div
      v-if="sidebarOpen"
      @click="sidebarOpen = false"
      class="fixed inset-0 z-40 bg-black/50 lg:hidden"
    ></div>


    <!-- Sidebar -->
    <aside
      :class="[
        'fixed inset-y-0 left-0 z-50 w-64 transform',
        'border-r border-slate-200 bg-white',
        'dark:border-slate-800 dark:bg-slate-900',
        'transition-transform duration-200',
        sidebarOpen
          ? 'translate-x-0'
          : '-translate-x-full',
        'lg:translate-x-0'
      ]"
    >

      <!-- Logo -->
      <div
        class="flex h-20 items-center gap-3 border-b
               border-slate-200 px-6
               dark:border-slate-800"
      >

        <img
          src="/ff-logo.png"
          alt="FreelanceFlow"
          class="h-10 w-10 rounded-xl"
        />

        <div>
          <div class="font-black text-slate-900 dark:text-white">
            Freelance<span class="text-primary-600">Flow</span>
          </div>

          <div class="text-xs font-bold uppercase tracking-wider text-red-500">
            Administration
          </div>
        </div>

      </div>


      <!-- Navigation -->
      <nav class="space-y-1 p-4">

        <RouterLink
          to="/admin/dashboard"
          class="admin-nav"
          @click="sidebarOpen = false"
        >
          <span>📊</span>
          Dashboard
        </RouterLink>

        <RouterLink
          to="/admin/users"
          class="admin-nav"
          @click="sidebarOpen = false"
        >
          <span>👥</span>
          Users
        </RouterLink>

        <RouterLink
          to="/admin/invoices"
          class="admin-nav"
          @click="sidebarOpen = false"
        >
          <span>🧾</span>
          Invoices
        </RouterLink>

        <RouterLink
          to="/admin/payments"
          class="admin-nav"
          @click="sidebarOpen = false"
        >
          <span>💳</span>
          Payments
        </RouterLink>

        <RouterLink
          to="/admin/audit-logs"
          class="admin-nav"
          @click="sidebarOpen = false"
        >
          <span>📋</span>
          Audit Logs
        </RouterLink>

        <RouterLink
          to="/admin/errors"
          class="admin-nav"
          @click="sidebarOpen = false"
        >
          <span>⚠️</span>
          Error Logs
        </RouterLink>

      </nav>


      <!-- Bottom -->
      <div
        class="absolute bottom-0 left-0 right-0 border-t
               border-slate-200 p-4
               dark:border-slate-800"
      >

        <div
          v-if="authStore.user"
          class="mb-3 rounded-xl bg-slate-100 p-3
                 dark:bg-slate-800"
        >

          <p class="truncate text-sm font-bold text-slate-900 dark:text-white">
            {{ authStore.user.name }}
          </p>

          <p class="truncate text-xs text-slate-500">
            {{ authStore.user.email }}
          </p>

          <span
            class="mt-2 inline-block rounded-full
                   bg-red-100 px-2 py-1 text-xs font-bold
                   text-red-700 dark:bg-red-950 dark:text-red-300"
          >
            ADMIN
          </span>

        </div>


        <button
          @click="handleLogout"
          class="flex w-full items-center gap-3 rounded-xl
                 px-4 py-3 text-left text-sm font-bold
                 text-red-600 transition
                 hover:bg-red-50
                 dark:hover:bg-red-950/30"
        >
          <span>🚪</span>
          Logout
        </button>

      </div>

    </aside>


    <!-- Main -->
    <div class="lg:pl-64">

      <!-- Desktop Header -->
      <header
        class="hidden h-20 items-center justify-between
               border-b border-slate-200 bg-white px-8
               dark:border-slate-800 dark:bg-slate-900
               lg:flex"
      >

        <div>

          <h1 class="text-xl font-black text-slate-900 dark:text-white">
            Admin Panel
          </h1>

          <p class="text-sm text-slate-500">
            Manage FreelanceFlow
          </p>

        </div>


        <div class="flex items-center gap-4">

          <div class="text-right">

            <p class="text-sm font-bold text-slate-900 dark:text-white">
              {{ authStore.user?.name }}
            </p>

            <p class="text-xs text-slate-500">
              Administrator
            </p>

          </div>


          <button
            @click="handleLogout"
            class="rounded-xl bg-red-50 px-4 py-2 text-sm
                   font-bold text-red-600
                   hover:bg-red-100
                   dark:bg-red-950/30 dark:hover:bg-red-950/50"
          >
            Logout
          </button>

        </div>

      </header>


      <!-- Page Content -->
      <main class="p-4 sm:p-6 lg:p-8">

        <RouterView />

      </main>

    </div>

  </div>
</template>


<script setup>

import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const router = useRouter()

const authStore = useAuthStore()

const sidebarOpen = ref(false)


async function handleLogout() {

  const result = await authStore.logoutUser()

  if (result.success || !authStore.isAuthenticated) {

    sidebarOpen.value = false

    await router.replace({
      name: 'login'
    })

  } else {

    console.error(
      'Logout failed:',
      result.message
    )
  }
}

</script>


<style scoped>

.admin-nav {
  @apply flex items-center gap-3 rounded-xl px-4 py-3
         text-sm font-semibold text-slate-600
         transition
         hover:bg-slate-100 hover:text-slate-900
         dark:text-slate-300
         dark:hover:bg-slate-800 dark:hover:text-white;
}

.admin-nav.router-link-active {
  @apply bg-primary-50 text-primary-700
         dark:bg-primary-950/40 dark:text-primary-400;
}

</style>