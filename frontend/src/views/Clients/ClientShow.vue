<template>
  <section>
    <Loader v-if="loading" />
    <div v-else-if="client" class="space-y-6">
      <div class="flex flex-col gap-4 rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200 sm:flex-row sm:items-center sm:justify-between"><div><p class="text-sm font-semibold text-indigo-600">Client</p><h2 class="text-3xl font-black">{{ client.name }}</h2><p class="mt-1 text-sm text-slate-500">{{ client.company || 'Independent client' }}</p></div><router-link :to="`/clients/${client.id}/edit`" class="rounded-xl bg-indigo-600 px-4 py-3 text-center text-sm font-bold text-white">Edit Client</router-link></div>
      <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4"><div v-for="item in details" :key="item.label" class="rounded-2xl bg-white p-5 ring-1 ring-slate-200"><div class="text-xs font-bold uppercase tracking-wide text-slate-400">{{ item.label }}</div><div class="mt-2 break-words font-semibold text-slate-800">{{ item.value }}</div></div></div>
      <div class="rounded-2xl bg-white p-5 ring-1 ring-slate-200"><h3 class="mb-4 text-lg font-black">Invoices</h3><div v-if="client.invoices?.length" class="space-y-3"><router-link v-for="invoice in client.invoices" :key="invoice.id" :to="`/invoices/${invoice.id}`" class="flex items-center justify-between rounded-xl bg-slate-50 p-4 hover:bg-indigo-50"><span class="font-bold">{{ invoice.invoice_number }}</span><span class="text-sm font-semibold">KES {{ Number(invoice.total).toLocaleString('en-KE', { minimumFractionDigits: 2 }) }}</span></router-link></div><p v-else class="text-sm text-slate-500">No invoices for this client yet.</p></div>
    </div>
  </section>
</template>

<script setup>
import { computed, onMounted } from 'vue'
import { storeToRefs } from 'pinia'
import { useRoute } from 'vue-router'
import { useClientsStore } from '../../stores/clients'
import Loader from '../../components/Loader.vue'

const route = useRoute(); const store = useClientsStore(); const { client, isLoading: loading } = storeToRefs(store)
const details = computed(() => client.value ? [
  { label: 'Email', value: client.value.email || '—' }, { label: 'Phone', value: client.value.phone || '—' }, { label: 'Company', value: client.value.company || '—' }, { label: 'Address', value: client.value.address || '—' },
] : [])
onMounted(() => store.fetchClient(route.params.id))
</script>
