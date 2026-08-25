<template>
    <router-view />
    <Alert />
</template>

<script setup>
import Alert from '@/components/Alert.vue'
import { onMounted } from 'vue'
import { useAuthStore } from '@/stores/auth'

const authStore = useAuthStore()

onMounted(async () => {
    await authStore.fetchUser()
})
</script>