<template>
  <div>
    <h2 class="text-2xl font-bold mb-4">All Invoices</h2>
    <div class="flex gap-2 mb-4">
      <input v-model="search" placeholder="Search by number..." class="border rounded px-3 py-1" @input="fetchInvoices" />
      <select v-model="statusFilter" class="border rounded px-3 py-1" @change="fetchInvoices">
        <option value="">All statuses</option>
        <option value="unpaid">Unpaid</option>
        <option value="partially_paid">Partially Paid</option>
        <option value="paid">Paid</option>
        <option value="overdue">Overdue</option>
      </select>
    </div>
    <table class="w-full bg-white rounded shadow">
      <thead>
        <tr class="border-b">
          <th class="p-3 text-left">Number</th>
          <th class="p-3 text-left">Client</th>
          <th class="p-3 text-left">Total</th>
          <th class="p-3 text-left">Status</th>
          <th class="p-3 text-left">Due</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="inv in store.invoices.data" :key="inv.id" class="border-b hover:bg-gray-50">
          <td class="p-3">{{ inv.invoice_number }}</td>
          <td class="p-3">{{ inv.client?.name }}</td>
          <td class="p-3">KES {{ inv.total }}</td>
          <td class="p-3">{{ inv.status }}</td>
          <td class="p-3">{{ inv.due_date }}</td>
        </tr>
      </tbody>
    </table>
    <Pagination :meta="store.invoices.meta" @page-change="fetchInvoices" />
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useAdminStore } from '@/stores/admin'
import Pagination from '@/components/Pagination.vue'

const store = useAdminStore()
const search = ref('')
const statusFilter = ref('')

const fetchInvoices = (page = 1) => {
  store.fetchInvoices({ search: search.value, status: statusFilter.value, page })
}

onMounted(fetchInvoices)
</script>