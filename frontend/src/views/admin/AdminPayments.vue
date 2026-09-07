<template>
  <div>
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-2xl font-bold">All Payments</h2>
      <div class="flex gap-2">
        <button @click="refresh" class="bg-blue-500 text-white px-3 py-1 rounded">Refresh</button>
      </div>
    </div>

    <!-- Filters -->
    <div class="flex flex-wrap gap-2 mb-4">
      <select v-model="methodFilter" class="border rounded px-3 py-1" @change="fetchPayments">
        <option value="">All methods</option>
        <option value="cash">Cash</option>
        <option value="bank_transfer">Bank Transfer</option>
        <option value="card">Card</option>
        <option value="mobile_money">M-Pesa</option>
      </select>

      <select v-model="statusFilter" class="border rounded px-3 py-1" @change="fetchPayments">
        <option value="">All statuses</option>
        <option value="pending">Pending</option>
        <option value="completed">Completed</option>
        <option value="failed">Failed</option>
      </select>
    </div>

    <!-- Loading state -->
    <div v-if="store.loading" class="text-center py-8">Loading...</div>

    <!-- Table -->
    <div v-else>
      <div class="overflow-x-auto">
        <table class="w-full bg-white rounded shadow">
          <thead>
            <tr class="border-b">
              <th class="p-3 text-left">Invoice</th>
              <th class="p-3 text-left">Client</th>
              <th class="p-3 text-left">Amount</th>
              <th class="p-3 text-left">Method</th>
              <th class="p-3 text-left">Status</th>
              <th class="p-3 text-left">Date</th>
              <th class="p-3 text-left">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="payment in store.payments.data" :key="payment.id" class="border-b hover:bg-gray-50">
              <td class="p-3 font-medium">{{ payment.invoice?.invoice_number || 'N/A' }}</td>
              <td class="p-3">{{ payment.invoice?.client?.name || 'N/A' }}</td>
              <td class="p-3 font-bold">KES {{ Number(payment.amount).toLocaleString() }}</td>
              <td class="p-3 capitalize">{{ payment.method?.replace('_', ' ') }}</td>
              <td class="p-3">
                <span :class="{
                  'bg-yellow-100 text-yellow-800': payment.status === 'pending',
                  'bg-green-100 text-green-800': payment.status === 'completed',
                  'bg-red-100 text-red-800': payment.status === 'failed',
                  'bg-gray-100 text-gray-800': !payment.status
                }" class="px-2 py-1 rounded text-xs font-bold">
                  {{ payment.status || 'Unknown' }}
                </span>
              </td>
              <td class="p-3">{{ payment.payment_date }}</td>
              <td class="p-3">
                <button @click="viewPayment(payment.id)" class="text-blue-600 hover:underline">View</button>
              </td>
            </tr>
            <tr v-if="!store.payments.data?.length">
              <td colspan="7" class="p-6 text-center text-gray-500">No payments found.</td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <Pagination :meta="store.payments.meta" @page-change="fetchPayments" class="mt-4" />
    </div>

    <!-- Payment Detail Modal (optional) -->
    <div v-if="selectedPayment" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
      <div class="bg-white rounded-xl max-w-2xl w-full p-6 max-h-[80vh] overflow-y-auto">
        <div class="flex justify-between items-start mb-4">
          <h3 class="text-xl font-bold">Payment Details</h3>
          <button @click="selectedPayment = null" class="text-gray-500 hover:text-gray-700">✕</button>
        </div>
        <div class="space-y-2">
          <div class="flex justify-between"><span class="font-semibold">Invoice:</span> <span>{{ selectedPayment.invoice?.invoice_number }}</span></div>
          <div class="flex justify-between"><span class="font-semibold">Client:</span> <span>{{ selectedPayment.invoice?.client?.name }}</span></div>
          <div class="flex justify-between"><span class="font-semibold">Amount:</span> <span class="font-bold">KES {{ Number(selectedPayment.amount).toLocaleString() }}</span></div>
          <div class="flex justify-between"><span class="font-semibold">Method:</span> <span>{{ selectedPayment.method }}</span></div>
          <div class="flex justify-between"><span class="font-semibold">Status:</span> <span>{{ selectedPayment.status }}</span></div>
          <div class="flex justify-between"><span class="font-semibold">Reference:</span> <span>{{ selectedPayment.reference || 'N/A' }}</span></div>
          <div class="flex justify-between"><span class="font-semibold">Date:</span> <span>{{ selectedPayment.payment_date }}</span></div>
          <div class="flex justify-between"><span class="font-semibold">Created:</span> <span>{{ new Date(selectedPayment.created_at).toLocaleString() }}</span></div>
          <div v-if="selectedPayment.provider" class="flex justify-between"><span class="font-semibold">Provider:</span> <span>{{ selectedPayment.provider }}</span></div>
          <div v-if="selectedPayment.provider_transaction_id" class="flex justify-between"><span class="font-semibold">Transaction ID:</span> <span class="text-xs">{{ selectedPayment.provider_transaction_id }}</span></div>
          <div v-if="selectedPayment.phone_number" class="flex justify-between"><span class="font-semibold">Phone:</span> <span>{{ selectedPayment.phone_number }}</span></div>
        </div>
        <div class="mt-4">
          <button @click="selectedPayment = null" class="bg-gray-300 px-4 py-2 rounded">Close</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useAdminStore } from '@/stores/admin'
import Pagination from '@/components/Pagination.vue'

const store = useAdminStore()
const methodFilter = ref('')
const statusFilter = ref('')
const selectedPayment = ref(null)

const fetchPayments = (page = 1) => {
  store.fetchPayments({
    method: methodFilter.value || undefined,
    status: statusFilter.value || undefined,
    page,
  })
}

const viewPayment = async (id) => {
  // We could fetch a single payment if needed, but we already have data in store
  const payment = store.payments.data.find(p => p.id === id)
  if (payment) {
    selectedPayment.value = payment
  }
}

const refresh = () => fetchPayments()

onMounted(fetchPayments)
</script>