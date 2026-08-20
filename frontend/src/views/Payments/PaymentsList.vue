<template>
  <section>
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between"><div><p class="text-sm font-semibold text-indigo-600">Cash flow</p><h2 class="text-2xl font-black text-slate-900">Payments</h2><p class="mt-1 text-sm text-slate-500">Track cash, bank, card and M-Pesa payments.</p></div><router-link to="/payments/create" class="rounded-xl bg-indigo-600 px-4 py-3 text-center text-sm font-bold text-white">+ Record Payment</router-link></div>
    <Loader v-if="loading" />
    <div v-else class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"><div class="overflow-x-auto"><table class="min-w-[760px] w-full"><thead><tr class="border-b bg-slate-50"><th v-for="h in headers" :key="h" class="p-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">{{ h }}</th></tr></thead><tbody><tr v-for="payment in payments" :key="payment.id" class="border-b border-slate-100"><td class="p-3 font-bold">{{ payment.invoice?.invoice_number || '-' }}</td><td class="p-3 font-semibold">KES {{ money(payment.amount) }}</td><td class="p-3 text-sm">{{ payment.payment_date }}</td><td class="p-3 text-sm">{{ pretty(payment.method) }}</td><td class="p-3"><span :class="statusClass(payment.status)" class="rounded-full px-2.5 py-1 text-xs font-bold">{{ payment.status }}</span></td></tr></tbody></table></div><div class="p-4"><Pagination :meta="meta" @page-change="fetchPage" /></div></div>
  </section>
</template>

<script setup>
import { onMounted } from 'vue'
import { storeToRefs } from 'pinia'
import { usePaymentsStore } from '../../stores/payments'
import Pagination from '../../components/Pagination.vue'
import Loader from '../../components/Loader.vue'

const store = usePaymentsStore()
const { payments, meta, isLoading: loading } = storeToRefs(store)
const headers = ['Invoice', 'Amount', 'Date', 'Method', 'Status']
const fetchPage = (page) => store.fetchPayments({ page })
const money = (value) => Number(value || 0).toLocaleString('en-KE', { minimumFractionDigits: 2, maximumFractionDigits: 2 })
const pretty = (value) => String(value || '').replaceAll('_', ' ')
const statusClass = (status) => status === 'completed' ? 'bg-emerald-100 text-emerald-700' : status === 'pending' ? 'bg-amber-100 text-amber-700' : 'bg-red-100 text-red-700'
onMounted(() => store.fetchPayments())
</script>
