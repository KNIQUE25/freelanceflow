<template>
  <section><div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between"><div><p class="text-sm font-semibold text-indigo-600">Activity</p><h2 class="text-2xl font-black">Notifications</h2></div><button class="rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-bold text-white" @click="markAllRead">Mark all read</button></div><Loader v-if="loading" /><div v-else class="space-y-3"><div v-for="notification in notifications" :key="notification.id" class="rounded-2xl border p-4" :class="notification.read_at ? 'border-slate-200 bg-white' : 'border-indigo-200 bg-indigo-50/50'"><div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between"><div><p class="font-black">{{ notification.data?.title || notification.type }}</p><p class="mt-1 text-sm text-slate-600">{{ notification.data?.message }}</p><p class="mt-2 text-xs text-slate-400">{{ new Date(notification.created_at).toLocaleString() }}</p></div><button v-if="!notification.read_at" class="text-sm font-bold text-indigo-600" @click="markRead(notification.id)">Mark read</button></div></div><div v-if="!notifications.length" class="rounded-2xl border border-dashed p-10 text-center text-sm text-slate-500">No notifications.</div></div></section>
</template>
<script setup>
import { onMounted } from 'vue'
import { storeToRefs } from 'pinia'
import { useNotificationsStore } from '../stores/notifications'
import Loader from '../components/Loader.vue'
const store = useNotificationsStore(); const { notifications, isLoading: loading } = storeToRefs(store)
const markRead = (id) => store.markRead(id); const markAllRead = () => store.markAllRead(); onMounted(() => store.fetchNotifications())
</script>
