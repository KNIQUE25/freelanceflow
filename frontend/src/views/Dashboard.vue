<template>
  <section>
    <div class="mb-6"><p class="text-sm font-semibold text-indigo-600">Overview</p><h2 class="text-2xl font-black text-slate-900 sm:text-3xl">Good to see you, {{ auth.user?.name?.split(' ')[0] || 'there' }}.</h2><p class="mt-1 text-sm text-slate-500">Here is how your freelance business is doing.</p></div>
    <Loader v-if="loading" />
    <div v-else class="space-y-6">
      <div class="grid grid-cols-2 gap-4 xl:grid-cols-4"><div v-for="stat in stats" :key="stat.label" class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm"><div class="text-xs font-bold uppercase tracking-wide text-slate-400">{{ stat.label }}</div><div class="mt-2 text-xl font-black text-slate-900 sm:text-2xl">{{ stat.value }}</div></div></div>
      <div class="grid gap-6 lg:grid-cols-[1.4fr_.6fr]">
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm"><div class="mb-4 flex items-center justify-between"><div><h3 class="font-black">Recent invoices</h3><p class="text-xs text-slate-400">Your latest billing activity</p></div><router-link to="/invoices" class="text-sm font-bold text-indigo-600">View all</router-link></div><div class="space-y-2"><router-link v-for="invoice in data.recent_invoices" :key="invoice.id" :to="`/invoices/${invoice.id}`" class="flex flex-col gap-2 rounded-xl bg-slate-50 p-4 hover:bg-indigo-50 sm:flex-row sm:items-center sm:justify-between"><div><div class="font-bold text-slate-800">{{ invoice.invoice_number }}</div><div class="text-xs text-slate-400">{{ invoice.client_name }} · due {{ invoice.due_date }}</div></div><div class="flex items-center justify-between gap-4"><span :class="statusClass(invoice.status)" class="rounded-full px-2 py-1 text-xs font-bold">{{ pretty(invoice.status) }}</span><strong>KES {{ money(invoice.total) }}</strong></div></router-link><p v-if="!data.recent_invoices.length" class="py-8 text-center text-sm text-slate-500">No invoices yet.</p></div></div>
        <div class="rounded-2xl border border-slate-200 bg-slate-950 p-5 text-white"><h3 class="font-black">Invoice status</h3><div class="mt-5 space-y-4"><div v-for="item in statusItems" :key="item.label"><div class="mb-1 flex justify-between text-xs"><span class="text-slate-400">{{ item.label }}</span><strong>{{ item.value }}</strong></div><div class="h-2 rounded-full bg-white/10"><div class="h-2 rounded-full bg-indigo-400" :style="{ width: `${item.percent}%` }"></div></div></div></div></div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { computed, onMounted, ref } from 'vue'
import { useAuthStore } from '../stores/auth'
import api from '../services/api'
import Loader from '../components/Loader.vue'

const auth = useAuthStore(); const loading = ref(true); const data = ref({ total_clients: 0, total_invoices: 0, invoice_value: 0, paid_amount: 0, outstanding_balance: 0, invoices: {}, recent_invoices: [] })
const money = (v) => Number(v || 0).toLocaleString('en-KE', { minimumFractionDigits: 2, maximumFractionDigits: 2 })
const pretty = (v) => String(v || '').replaceAll('_', ' ')
const stats = computed(() => [
  { label: 'Clients', value: data.value.total_clients }, { label: 'Invoices', value: data.value.total_invoices }, { label: 'Paid revenue', value: `KES ${money(data.value.paid_amount)}` }, { label: 'Outstanding', value: `KES ${money(data.value.outstanding_balance)}` },
])
const statusItems = computed(() => { const total = Math.max(1, data.value.total_invoices); return Object.entries({ Paid: data.value.invoices.paid || 0, Unpaid: data.value.invoices.unpaid || 0, 'Partially paid': data.value.invoices.partially_paid || 0, Overdue: data.value.invoices.overdue || 0 }).map(([label, value]) => ({ label, value, percent: Math.min(100, Math.round(value / total * 100)) })) })
const statusClass = (status) => ({ paid: 'bg-emerald-100 text-emerald-700', overdue: 'bg-red-100 text-red-700', partially_paid: 'bg-amber-100 text-amber-700', unpaid: 'bg-slate-200 text-slate-700' }[status] || 'bg-slate-200 text-slate-700')
onMounted(async () => { try { data.value = (await api.get('/api/dashboard')).data } finally { loading.value = false } })
</script>
