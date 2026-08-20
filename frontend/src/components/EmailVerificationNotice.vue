<template>
  <div v-if="!verified" class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-4 rounded">
    <p>
      ⚠️ Your email is not verified.
      <router-link to="/email/verify" class="font-bold underline hover:text-yellow-900">
        Verify now
      </router-link>
    </p>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { useAuthStore } from '../stores/auth'

const authStore = useAuthStore()
const verified = computed(() => authStore.isEmailVerified)
</script>