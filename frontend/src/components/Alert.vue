<template>
  <div v-if="show" class="fixed top-4 right-4 z-50 max-w-sm w-full">
    <div
      :class="[
        'px-4 py-3 rounded shadow-lg',
        type === 'success' ? 'bg-green-50 text-green-800 border border-green-300' :
        type === 'error' ? 'bg-red-50 text-red-800 border border-red-300' :
        type === 'warning' ? 'bg-yellow-50 text-yellow-800 border border-yellow-300' :
        'bg-blue-50 text-blue-800 border border-blue-300'
      ]"
    >
      {{ message }}
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { useAlertStore } from '../stores/alerts'

const alertStore = useAlertStore()
const show = computed(() => alertStore.messages.length > 0)
const message = computed(() => alertStore.messages[0]?.text || '')
const type = computed(() => alertStore.messages[0]?.type || 'info')
</script>