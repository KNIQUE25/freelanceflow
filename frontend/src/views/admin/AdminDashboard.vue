<template>

  <div>

    <div class="mb-6">
      <h2 class="text-2xl font-black text-slate-900 dark:text-white">
        Admin Dashboard
      </h2>

      <p class="mt-1 text-sm text-slate-500">
        Overview of your FreelanceFlow system.
      </p>
    </div>


    <div
      v-if="!store.stats"
      class="rounded-2xl bg-white p-10 text-center shadow
             dark:bg-slate-900"
    >
      Loading...
    </div>


    <div v-else>

      <div
        class="mb-8 grid grid-cols-1 gap-4
               md:grid-cols-2 lg:grid-cols-3"
      >

        <div
          v-for="(value, key) in statsCards"
          :key="key"
          class="rounded-2xl border border-slate-200
                 bg-white p-5 shadow-sm
                 dark:border-slate-800 dark:bg-slate-900"
        >

          <p
            class="text-sm font-semibold capitalize
                   text-slate-500"
          >
            {{ key }}
          </p>

          <p
            class="mt-2 text-2xl font-black
                   text-slate-900 dark:text-white"
          >
            {{ value }}
          </p>

        </div>

      </div>


      <div
        class="rounded-2xl border border-slate-200
               bg-white p-6 shadow-sm
               dark:border-slate-800 dark:bg-slate-900"
      >

        <h3 class="font-black text-slate-900 dark:text-white">
          Quick Actions
        </h3>

        <div class="mt-4 flex flex-wrap gap-3">

          <button
            @click="clearCache"
            class="rounded-xl bg-yellow-500 px-4 py-2
                   text-sm font-bold text-white
                   hover:bg-yellow-600"
          >
            Clear Cache
          </button>

          <button
            @click="refreshStats"
            class="rounded-xl bg-primary-600 px-4 py-2
                   text-sm font-bold text-white
                   hover:bg-primary-700"
          >
            Refresh Stats
          </button>

        </div>

      </div>

    </div>

  </div>

</template>

<script setup>

import { computed, onMounted } from 'vue'
import { useAdminStore } from '@/stores/admin'

const store = useAdminStore()

const statsCards = computed(() => {

    if (!store.stats) {
        return {}
    }

    return {
        'Total Users': store.stats.total_users,
        'Total Invoices': store.stats.total_invoices,
        'Total Payments': store.stats.total_payments,
        'Total Revenue': 'KES ' + (store.stats.total_revenue || 0),
        'Pending Invoices': store.stats.pending_invoices,
        'Overdue Invoices': store.stats.overdue_invoices,
    }
})


async function refreshStats() {
    await store.fetchStats()
}


async function clearCache() {

    await store.clearCache()

    alert('Cache cleared!')
}


onMounted(refreshStats)

</script>