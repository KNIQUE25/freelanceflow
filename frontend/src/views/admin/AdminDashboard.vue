<template>
  <div>
    <h2 class="text-2xl font-bold mb-6">Admin Dashboard</h2>
    <div v-if="!stats" class="text-center py-8">Loading...</div>
    <div v-else>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div v-for="(value, key) in statsCards" :key="key" class="bg-white p-4 rounded shadow">
          <p class="text-sm text-gray-500">{{ key.replace('_', ' ') }}</p>
          <p class="text-2xl font-bold">{{ value }}</p>
        </div>
      </div>

      <div class="bg-white p-4 rounded shadow">
        <h3 class="font-bold mb-2">Quick Actions</h3>
        <div class="flex gap-2 flex-wrap">
          <button @click="clearCache" class="bg-yellow-500 text-white px-4 py-2 rounded">Clear Cache</button>
          <button @click="refreshStats" class="bg-blue-500 text-white px-4 py-2 rounded">Refresh Stats</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed, onMounted, ref } from 'vue'
import { useAdminStore } from '@/stores/admin'

const store = useAdminStore()
const stats = ref(null)

const statsCards = computed(() => {
  if (!stats.value) return {}
  return {
    'Total Users': stats.value.total_users,
    'Total Invoices': stats.value.total_invoices,
    'Total Payments': stats.value.total_payments,
    'Total Revenue': 'KES ' + (stats.value.total_revenue || 0),
    'Pending Invoices': stats.value.pending_invoices,
    'Overdue Invoices': stats.value.overdue_invoices,
  }
})

const refreshStats = async () => {
  stats.value = await store.fetchStats()
}

const clearCache = async () => {
  await store.clearCache()
  alert('Cache cleared!')
}

onMounted(refreshStats)
</script>