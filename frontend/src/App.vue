<template>
    <router-view />
    <Alert />
</template>

<script setup>
import Alert from '@/components/Alert.vue'
import { onMounted } from 'vue'
import { useAuthStore } from '@/stores/auth'
import { useThemeStore } from '@/stores/theme'
import api from '@/services/api'

const authStore = useAuthStore()
const themeStore = useThemeStore()

onMounted(async () => {
    // ✅ Fetch CSRF cookie first
    await api.get('/sanctum/csrf-cookie')
    // Then fetch user
    await authStore.fetchUser()

     themeStore.init()
})
</script>