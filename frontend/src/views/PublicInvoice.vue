<template>
  <div class="min-h-screen bg-gray-100 py-8 px-4">
    <div v-if="loading" class="text-center py-12">
      <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-indigo-600 mx-auto"></div>
      <p class="mt-4 text-gray-600">Loading invoice...</p>
    </div>

    <div v-else-if="error" class="max-w-2xl mx-auto bg-white rounded-xl shadow-lg p-8 text-center">
      <div class="text-6xl mb-4">🔒</div>
      <h2 class="text-2xl font-bold text-gray-900 mb-2">Invoice Not Found</h2>
      <p class="text-gray-600">{{ error }}</p>
    </div>

    <div v-else-if="invoice" class="max-w-3xl mx-auto bg-white rounded-xl shadow-lg overflow-hidden">
      <!-- Header -->
      <div class="bg-indigo-600 px-6 py-8 text-white">
        <div class="flex justify-between items-center">
          <div>
            <h1 class="text-2xl font-bold">FreelanceFlow</h1>
            <p class="text-indigo-200 text-sm">Invoice #{{ invoice.invoice_number }}</p>
          </div>
          <span :class="[
            'px-4 py-2 rounded-full text-sm font-bold',
            invoice.status === 'paid' ? 'bg-green-500' :
            invoice.status === 'overdue' ? 'bg-red-500' :
            'bg-yellow-500'
          ]">
            {{ invoice.status.toUpperCase() }}
          </span>
        </div>
      </div>

      <!-- Body -->
      <div class="p-6">
        <!-- Client Info -->
        <div class="mb-6">
          <h2 class="text-sm font-semibold text-gray-500 uppercase">Bill To</h2>
          <p class="text-lg font-bold text-gray-900">{{ invoice.client.name }}</p>
          <p class="text-gray-600">{{ invoice.client.email }}</p>
          <p class="text-gray-600">{{ invoice.client.phone }}</p>
        </div>

        <!-- Invoice Details -->
        <div class="grid grid-cols-2 gap-4 mb-6">
          <div>
            <p class="text-sm text-gray-500">Issue Date</p>
            <p class="font-semibold">{{ invoice.issue_date }}</p>
          </div>
          <div>
            <p class="text-sm text-gray-500">Due Date</p>
            <p class="font-semibold">{{ invoice.due_date }}</p>
          </div>
        </div>

        <!-- Items -->
        <div class="border-t border-gray-200 pt-4 mb-6">
          <h3 class="text-sm font-semibold text-gray-500 uppercase mb-3">Items</h3>
          <table class="w-full">
            <thead>
              <tr class="border-b">
                <th class="text-left py-2 text-sm font-medium text-gray-500">Description</th>
                <th class="text-right py-2 text-sm font-medium text-gray-500">Qty</th>
                <th class="text-right py-2 text-sm font-medium text-gray-500">Price</th>
                <th class="text-right py-2 text-sm font-medium text-gray-500">Total</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="item in invoice.items" :key="item.id" class="border-b">
                <td class="py-2 text-gray-800">{{ item.description }}</td>
                <td class="py-2 text-right text-gray-800">{{ item.quantity }}</td>
                <td class="py-2 text-right text-gray-800">KES {{ item.unit_price }}</td>
                <td class="py-2 text-right text-gray-800 font-semibold">KES {{ item.total }}</td>
              </tr>
            </tbody>
            <tfoot>
              <tr><td colspan="3" class="text-right font-medium py-2">Subtotal</td><td class="text-right font-medium py-2">KES {{ invoice.subtotal }}</td></tr>
              <tr><td colspan="3" class="text-right font-medium py-2">Tax</td><td class="text-right font-medium py-2">KES {{ invoice.tax }}</td></tr>
              <tr class="border-t-2 border-gray-300"><td colspan="3" class="text-right font-bold py-2 text-lg">Total</td><td class="text-right font-bold py-2 text-lg">KES {{ invoice.total }}</td></tr>
              <tr class="text-green-600"><td colspan="3" class="text-right font-bold py-2">Paid</td><td class="text-right font-bold py-2">KES {{ invoice.paid_amount }}</td></tr>
              <tr class="border-t-2 border-gray-300"><td colspan="3" class="text-right font-bold py-2 text-xl text-indigo-600">Balance</td><td class="text-right font-bold py-2 text-xl text-indigo-600">KES {{ invoice.balance }}</td></tr>
            </tfoot>
          </table>
        </div>

        <!-- Note -->
        <div v-if="invoice.note" class="bg-gray-50 rounded-lg p-4 mb-6">
          <p class="text-sm text-gray-600">{{ invoice.note }}</p>
        </div>

        <!-- Payment Section -->
        <div v-if="!isPaid" class="border-t border-gray-200 pt-6">
          <h3 class="text-lg font-bold text-gray-900 mb-4">Pay with M-Pesa</h3>

          <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Phone Number</label>
            <div class="flex gap-3 mt-1">
              <input
                v-model="phone"
                type="tel"
                placeholder="2547xxxxxxxx"
                class="flex-1 rounded-lg border border-gray-300 px-4 py-3 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20"
              />
              <button
                @click="payWithMpesa"
                :disabled="paymentLoading || !phone"
                class="bg-green-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-green-700 transition disabled:opacity-50 disabled:cursor-not-allowed"
              >
                {{ paymentLoading ? 'Processing...' : 'Pay Now' }}
              </button>
            </div>
            <p class="text-xs text-gray-500 mt-1">Enter your Safaricom phone number (e.g., 2547xxxxxxxx)</p>
          </div>

          <div v-if="paymentMessage" :class="[
            'rounded-lg p-3 text-sm',
            paymentSuccess ? 'bg-green-50 text-green-800' : 'bg-red-50 text-red-800'
          ]">
            {{ paymentMessage }}
          </div>
        </div>

        <div v-else class="bg-green-50 border border-green-200 rounded-lg p-4 text-center">
          <div class="text-4xl mb-2">✅</div>
          <h3 class="text-lg font-bold text-green-800">Invoice Paid</h3>
          <p class="text-green-600">Thank you! This invoice has been fully paid.</p>
        </div>

        <!-- Payment History -->
        <div v-if="invoice.payments && invoice.payments.length" class="mt-6 border-t border-gray-200 pt-4">
          <h4 class="text-sm font-semibold text-gray-500 uppercase">Payment History</h4>
          <div v-for="payment in invoice.payments" :key="payment.id" class="flex justify-between py-2 border-b">
            <span class="text-gray-600">{{ payment.date }}</span>
            <span class="text-gray-600">{{ payment.method }}</span>
            <span class="font-semibold">KES {{ payment.amount }}</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import axios from 'axios'

const route = useRoute()
const invoice = ref(null)
const loading = ref(true)
const error = ref('')
const phone = ref('')
const paymentLoading = ref(false)
const paymentMessage = ref('')
const paymentSuccess = ref(false)

const isPaid = computed(() => invoice.value?.paid_amount >= invoice.value?.total)

// Fetch invoice data
async function fetchInvoice() {
  try {
    const response = await axios.get(`/api/public/invoice/${route.params.uuid}`)
    invoice.value = response.data.invoice
  } catch (e) {
    error.value = e.response?.data?.message || 'Invoice not found or has expired.'
  } finally {
    loading.value = false
  }
}

// Pay with M-Pesa
async function payWithMpesa() {
  if (!phone.value) {
    paymentMessage.value = 'Please enter your phone number.'
    paymentSuccess.value = false
    return
  }

  paymentLoading.value = true
  paymentMessage.value = ''
  paymentSuccess.value = false

  try {
    const response = await axios.post(`/api/public/invoice/${route.params.uuid}/pay`, {
      phone: phone.value
    })

    paymentSuccess.value = true
    paymentMessage.value = response.data.message

    // Refresh invoice status after a few seconds
    setTimeout(() => {
      fetchInvoice()
    }, 5000)

  } catch (e) {
    paymentSuccess.value = false
    paymentMessage.value = e.response?.data?.message || 'Payment failed. Please try again.'
  } finally {
    paymentLoading.value = false
  }
}

onMounted(() => {
  fetchInvoice()
})
</script>