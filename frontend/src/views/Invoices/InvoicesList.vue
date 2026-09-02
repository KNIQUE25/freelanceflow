<template>
  <section>
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
      <div>
        <p class="text-sm font-semibold text-indigo-600">Billing</p>
        <h2 class="text-2xl font-black text-slate-900">Invoices</h2>
        <p class="mt-1 text-sm text-slate-500">Create, track and download professional invoices.</p>
      </div>
      <router-link
        to="/invoices/create"
        class="rounded-xl bg-indigo-600 px-4 py-3 text-center text-sm font-bold text-white shadow-lg shadow-indigo-600/20 hover:bg-indigo-700"
      >
        + Create Invoice
      </router-link>
    </div>

    <!-- Search & Filters -->
    <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:flex-wrap">
      <div class="relative flex-1 min-w-[200px]">
        <input
          v-model="searchQuery"
          type="text"
          placeholder="Search by invoice number or client..."
          class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 pl-10 text-sm text-slate-900 outline-none transition focus:border-primary-500 focus:ring-4 focus:ring-primary-500/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:placeholder:text-slate-500"
          @input="handleSearch"
        />
        <span class="absolute left-3 top-3.5 text-slate-400">🔍</span>
      </div>

      <select
        v-model="statusFilter"
        class="rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-primary-500 focus:ring-4 focus:ring-primary-500/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white"
        @change="applyFilters"
      >
        <option value="">All Statuses</option>
        <option value="unpaid">Unpaid</option>
        <option value="partially_paid">Partially Paid</option>
        <option value="paid">Paid</option>
        <option value="overdue">Overdue</option>
      </select>

      <input
        v-model="dateFrom"
        type="date"
        class="rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-primary-500 focus:ring-4 focus:ring-primary-500/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white"
        @change="applyFilters"
      />
      <span class="self-center text-slate-500 dark:text-slate-400">to</span>
      <input
        v-model="dateTo"
        type="date"
        class="rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-primary-500 focus:ring-4 focus:ring-primary-500/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white"
        @change="applyFilters"
      />

      <button
        v-if="hasFilters"
        @click="clearFilters"
        class="rounded-xl bg-slate-100 px-4 py-3 text-sm font-semibold text-slate-600 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700"
      >
        Clear Filters
      </button>
    </div>

    <Loader v-if="loading" />
    <div v-else>
      <div v-if="invoices.length" class="grid grid-cols-1 gap-4 xl:grid-cols-2">
        <InvoiceCard v-for="invoice in invoices" :key="invoice.id" :invoice="invoice" @delete-invoice="removeInvoice" />
      </div>
      <div v-else class="rounded-2xl border border-dashed border-slate-300 bg-white p-10 text-center text-sm text-slate-500">
        {{ hasFilters ? 'No invoices match your filters.' : 'No invoices yet. Create your first invoice.' }}
      </div>
      <Pagination :meta="meta" @page-change="fetchPage" />
    </div>
  </section>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { storeToRefs } from 'pinia'
import { useInvoicesStore } from '../../stores/invoices'
import InvoiceCard from '../../components/InvoiceCard.vue'
import Pagination from '../../components/Pagination.vue'
import Loader from '../../components/Loader.vue'

const store = useInvoicesStore()
const { invoices, meta, isLoading: loading } = storeToRefs(store)

const searchQuery = ref('')
const statusFilter = ref('')
const dateFrom = ref('')
const dateTo = ref('')
let searchTimeout = null

const hasFilters = computed(() => searchQuery.value || statusFilter.value || dateFrom.value || dateTo.value)

function buildParams() {
  const params = {}
  if (searchQuery.value) params.search = searchQuery.value
  if (statusFilter.value) params.status = statusFilter.value
  if (dateFrom.value) params.date_from = dateFrom.value
  if (dateTo.value) params.date_to = dateTo.value
  return params
}

function fetchInvoices() {
  store.fetchInvoices(buildParams())
}

function handleSearch() {
  clearTimeout(searchTimeout)
  searchTimeout = setTimeout(fetchInvoices, 300)
}

function applyFilters() {
  fetchInvoices()
}

function clearFilters() {
  searchQuery.value = ''
  statusFilter.value = ''
  dateFrom.value = ''
  dateTo.value = ''
  fetchInvoices()
}

const fetchPage = (page) => store.fetchInvoices({ ...buildParams(), page })

async function removeInvoice(id) {
  if (await store.delete(id)) {
    fetchInvoices()
  }
}

onMounted(fetchInvoices)
</script>