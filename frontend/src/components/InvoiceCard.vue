<template>
  <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-lg">
    <div class="flex items-start justify-between gap-4"><div><h3 class="font-black text-slate-900">{{ invoice.invoice_number }}</h3><p class="mt-1 text-sm text-slate-500">{{ invoice.client?.name || 'Client' }}</p></div><span :class="statusClass" class="rounded-full px-2.5 py-1 text-xs font-bold">{{ prettyStatus }}</span></div>
    <div class="mt-5 grid grid-cols-2 gap-3 text-sm"><div><div class="text-xs text-slate-400">Due</div><div class="mt-1 font-semibold">{{ invoice.due_date }}</div></div><div class="text-right"><div class="text-xs text-slate-400">Total</div><div class="mt-1 font-black">KES {{ money(invoice.total) }}</div></div></div>
    <div class="mt-5 flex items-center justify-between border-t border-slate-100 pt-4"><span class="text-sm text-slate-500">Balance <strong class="text-slate-900">KES {{ money(invoice.balance) }}</strong></span><div class="flex gap-3 text-sm font-bold"><router-link :to="`/invoices/${invoice.id}`" class="text-indigo-600">View</router-link><router-link :to="`/invoices/${invoice.id}/edit`" class="text-emerald-600">Edit</router-link></div></div>
  </article>
</template>
<script setup>
import { computed } from 'vue'
const props = defineProps({ invoice: { type: Object, required: true } })
const money = (v) => Number(v || 0).toLocaleString('en-KE', { minimumFractionDigits: 2, maximumFractionDigits: 2 })
const prettyStatus = computed(() => String(props.invoice.status || '').replaceAll('_', ' '))
const statusClass = computed(() => ({ paid: 'bg-emerald-100 text-emerald-700', overdue: 'bg-red-100 text-red-700', partially_paid: 'bg-amber-100 text-amber-700', unpaid: 'bg-slate-100 text-slate-700' }[props.invoice.status] || 'bg-slate-100 text-slate-700'))
</script>
