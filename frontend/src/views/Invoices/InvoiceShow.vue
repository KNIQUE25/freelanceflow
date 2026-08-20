<template>
  <section>
    <Loader v-if="loading" />
    <div v-else-if="invoice" class="space-y-6">
      <div class="flex flex-col gap-4 rounded-2xl bg-slate-950 p-6 text-white sm:flex-row sm:items-end sm:justify-between">
        <div><p class="text-xs font-bold uppercase tracking-widest text-indigo-300">Invoice</p><h2 class="mt-1 text-3xl font-black">{{ invoice.invoice_number }}</h2><p class="mt-2 text-sm text-slate-300">{{ invoice.client?.name }}</p></div>
        <div class="flex gap-2"><button class="rounded-xl bg-white/10 px-4 py-2 text-sm font-bold hover:bg-white/20" @click="downloadPdf">Download PDF</button><router-link :to="`/invoices/${invoice.id}/edit`" class="rounded-xl bg-indigo-500 px-4 py-2 text-sm font-bold hover:bg-indigo-400">Edit</router-link></div>
      </div>
      <div class="grid grid-cols-2 gap-4 md:grid-cols-4"><div v-for="stat in summary" :key="stat.label" class="rounded-2xl border border-slate-200 bg-white p-5"><div class="text-xs font-bold uppercase tracking-wide text-slate-400">{{ stat.label }}</div><div class="mt-2 text-xl font-black text-slate-900">{{ stat.value }}</div></div></div>
      <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white"><div class="overflow-x-auto"><table class="min-w-[650px] w-full"><thead class="bg-slate-50"><tr><th class="p-3 text-left">Description</th><th class="p-3 text-right">Qty</th><th class="p-3 text-right">Unit</th><th class="p-3 text-right">Total</th></tr></thead><tbody><tr v-for="item in invoice.items" :key="item.id" class="border-t border-slate-100"><td class="p-3">{{ item.description }}</td><td class="p-3 text-right">{{ item.quantity }}</td><td class="p-3 text-right">KES {{ money(item.unit_price) }}</td><td class="p-3 text-right font-bold">KES {{ money(item.total) }}</td></tr></tbody><tfoot><tr class="border-t"><td colspan="3" class="p-3 text-right font-bold">Subtotal</td><td class="p-3 text-right font-bold">KES {{ money(invoice.subtotal) }}</td></tr><tr><td colspan="3" class="p-3 text-right">Tax</td><td class="p-3 text-right">KES {{ money(invoice.tax) }}</td></tr><tr class="bg-indigo-50"><td colspan="3" class="p-3 text-right font-black">Total</td><td class="p-3 text-right font-black">KES {{ money(invoice.total) }}</td></tr></tfoot></table></div></div>
      <div v-if="invoice.payments?.length" class="rounded-2xl border border-slate-200 bg-white p-5"><h3 class="mb-4 text-lg font-black">Payment history</h3><div class="space-y-3"><div v-for="payment in invoice.payments" :key="payment.id" class="flex flex-col gap-1 rounded-xl bg-slate-50 p-4 sm:flex-row sm:items-center sm:justify-between"><div><div class="font-bold">{{ pretty(payment.method) }}</div><div class="text-xs text-slate-400">{{ payment.payment_date }} · {{ payment.status }}</div></div><div class="font-black">KES {{ money(payment.amount) }}</div></div></div></div>
      <p v-if="invoice.note" class="rounded-2xl bg-amber-50 p-4 text-sm text-amber-800"><strong>Note:</strong> {{ invoice.note }}</p>
    </div>
  </section>
</template>

<script setup>
import { computed, onMounted } from 'vue'
import { storeToRefs } from 'pinia'
import { useRoute } from 'vue-router'
import api from '../../services/api'
import { useInvoicesStore } from '../../stores/invoices'
import Loader from '../../components/Loader.vue'

const route = useRoute()
const store = useInvoicesStore()
const { invoice, isLoading: loading } = storeToRefs(store)
const money = (v) => Number(v || 0).toLocaleString('en-KE', { minimumFractionDigits: 2, maximumFractionDigits: 2 })
const pretty = (v) => String(v || '').replaceAll('_', ' ')
const summary = computed(() => invoice.value ? [
  { label: 'Issue date', value: invoice.value.issue_date },
  { label: 'Due date', value: invoice.value.due_date },
  { label: 'Paid', value: `KES ${money(invoice.value.paid_amount)}` },
  { label: 'Balance', value: `KES ${money(invoice.value.balance)}` },
] : [])

async function downloadPdf() {
  const response = await api.get(`/api/invoices/${invoice.value.id}/pdf`, { responseType: 'blob' })
  const url = URL.createObjectURL(response.data)
  const link = document.createElement('a'); link.href = url; link.download = `${invoice.value.invoice_number}.pdf`; link.click(); URL.revokeObjectURL(url)
}
onMounted(() => store.fetchInvoice(route.params.id))
</script>
