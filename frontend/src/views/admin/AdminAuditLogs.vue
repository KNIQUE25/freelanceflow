<template>
  <div>
    <h2 class="text-2xl font-bold mb-4">Audit Logs</h2>
    <div class="overflow-x-auto">
      <table class="w-full bg-white rounded shadow">
        <thead>
          <tr class="border-b">
            <th class="p-3 text-left">User</th>
            <th class="p-3 text-left">Action</th>
            <th class="p-3 text-left">Model</th>
            <th class="p-3 text-left">Changes</th>
            <th class="p-3 text-left">Time</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="log in store.logs.data" :key="log.id" class="border-b hover:bg-gray-50">
            <td class="p-3">{{ log.user?.name }}</td>
            <td class="p-3">{{ log.action }}</td>
            <td class="p-3">{{ log.model_type }}</td>
            <td class="p-3 text-xs truncate max-w-xs">{{ JSON.stringify(log.new_values) }}</td>
            <td class="p-3">{{ new Date(log.created_at).toLocaleString() }}</td>
          </tr>
        </tbody>
      </table>
      <Pagination :meta="store.logs.meta" @page-change="fetchLogs" />
    </div>
  </div>
</template>

<script setup>
import { onMounted } from 'vue'
import { useAdminStore } from '@/stores/admin'
import Pagination from '@/components/Pagination.vue'

const store = useAdminStore()

const fetchLogs = (page = 1) => store.fetchAuditLogs({ page })

onMounted(fetchLogs)
</script>