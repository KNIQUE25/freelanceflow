<template>
  <section>
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between"><div><p class="text-sm font-semibold text-indigo-600">Billing</p><h2 class="text-2xl font-black text-slate-900">Invoices</h2><p class="mt-1 text-sm text-slate-500">Create, track and download professional invoices.</p></div><router-link to="/invoices/create" class="rounded-xl bg-indigo-600 px-4 py-3 text-center text-sm font-bold text-white shadow-lg shadow-indigo-600/20 hover:bg-indigo-700">+ Create Invoice</router-link></div>
    <Loader v-if="loading" />
    <div v-else>
      <div v-if="invoices.length" class="grid grid-cols-1 gap-4 xl:grid-cols-2"><InvoiceCard v-for="invoice in invoices" :key="invoice.id" :invoice="invoice" /></div>
      <div v-else class="rounded-2xl border border-dashed border-slate-300 bg-white p-10 text-center text-sm text-slate-500">No invoices yet. Create your first invoice.</div>
      <Pagination :meta="meta" @page-change="fetchPage" />
    </div>
  </section>
</template>

<script setup>
import { onMounted } from 'vue'
import { storeToRefs } from 'pinia'
import { useInvoicesStore } from '../../stores/invoices'
import InvoiceCard from '../../components/InvoiceCard.vue'
import Pagination from '../../components/Pagination.vue'
import Loader from '../../components/Loader.vue'

const store = useInvoicesStore()
const { invoices, meta, isLoading: loading } = storeToRefs(store)
const fetchPage = (page) => store.fetchInvoices({ page })
onMounted(() => store.fetchInvoices())
</script>
