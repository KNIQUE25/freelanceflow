<template>
  <div>
    <h2 class="text-2xl font-bold mb-4">Error Logs</h2>
    <button @click="fetchErrors" class="bg-blue-500 text-white px-4 py-2 rounded mb-4">Refresh</button>
    <div class="bg-red-50 p-4 rounded max-h-96 overflow-y-auto">
      <pre v-for="(line, i) in store.errorLogs" :key="i" class="text-xs text-red-700 border-b border-red-100 py-1">{{ line }}</pre>
      <p v-if="!store.errorLogs.length" class="text-green-600">No errors found.</p>
    </div>
  </div>
</template>

<script setup>
import { onMounted } from 'vue'
import { useAdminStore } from '@/stores/admin'

const store = useAdminStore()

const fetchErrors = () => store.fetchErrorLogs()

onMounted(fetchErrors)
</script>