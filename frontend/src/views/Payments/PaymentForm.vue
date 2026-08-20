<template>
  <section class="mx-auto max-w-3xl">
    <div class="mb-6"><p class="text-sm font-semibold text-indigo-600">Cash flow</p><h2 class="text-2xl font-black text-slate-900">Record Payment</h2></div>
    <form class="space-y-5 rounded-2xl bg-white p-5 ring-1 ring-slate-200" @submit.prevent="submit">
      <label class="block"><span class="label">Invoice</span><select v-model="form.invoice_id" class="input" required><option value="">Select invoice</option><option v-for="invoice in invoices" :key="invoice.id" :value="invoice.id">{{ invoice.invoice_number }} — balance KES {{ money(invoice.balance) }}</option></select></label>
      <div class="grid gap-4 sm:grid-cols-2">
        <label class="block"><span class="label">Amount</span><input v-model.number="form.amount" type="number" min="0.01" step="0.01" class="input" required /></label>
        <label class="block"><span class="label">Payment date</span><input v-model="form.payment_date" type="date" class="input" required /></label>
      </div>
      <label class="block"><span class="label">Method</span><select v-model="form.method" class="input"><option value="cash">Cash</option><option value="bank_transfer">Bank transfer</option><option value="card">Card</option><option value="mobile_money">M-Pesa</option></select></label>
      <label v-if="form.method !== 'mobile_money'" class="block"><span class="label">Reference</span><input v-model="form.reference" class="input" placeholder="Receipt or transaction reference" /></label>

      <div v-if="form.method === 'mobile_money'" class="rounded-2xl bg-emerald-50 p-5 ring-1 ring-emerald-100"><h3 class="font-black text-emerald-900">M-Pesa STK Push</h3><p class="mt-1 text-sm text-emerald-700">Enter the customer's phone number. The payment remains pending until the M-Pesa callback confirms it.</p><label class="mt-4 block"><span class="label">Safaricom number</span><input v-model="mpesaPhone" type="tel" class="input" placeholder="0712345678 or 254712345678" required /></label><button type="button" class="mt-4 w-full rounded-xl bg-emerald-600 px-4 py-3 text-sm font-bold text-white disabled:opacity-50" :disabled="mpesaLoading" @click="sendMpesa">{{ mpesaLoading ? 'Sending STK Push…' : 'Send STK Push' }}</button><p v-if="mpesaMessage" :class="mpesaSuccess ? 'text-emerald-700' : 'text-red-600'" class="mt-3 text-sm font-semibold">{{ mpesaMessage }}</p></div>

      <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end"><router-link to="/payments" class="rounded-xl bg-slate-100 px-5 py-3 text-center text-sm font-bold text-slate-700">Cancel</router-link><button v-if="form.method !== 'mobile_money'" type="submit" class="rounded-xl bg-indigo-600 px-5 py-3 text-sm font-bold text-white disabled:opacity-50" :disabled="loading">{{ loading ? 'Saving…' : 'Record payment' }}</button></div>
      <p v-if="error" class="rounded-xl bg-red-50 p-3 text-sm text-red-700">{{ error }}</p>
    </form>
  </section>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import { useRouter } from 'vue-router'
import { usePaymentsStore } from '../../stores/payments'
import { useInvoicesStore } from '../../stores/invoices'

const router = useRouter(); const paymentStore = usePaymentsStore(); const invoiceStore = useInvoicesStore()
const loading = ref(false); const invoices = ref([]); const error = ref(''); const mpesaPhone = ref(''); const mpesaLoading = ref(false); const mpesaMessage = ref(''); const mpesaSuccess = ref(false)
const form = ref({ invoice_id: '', amount: 0, payment_date: new Date().toISOString().slice(0, 10), method: 'cash', reference: '' })
const money = (v) => Number(v || 0).toLocaleString('en-KE', { minimumFractionDigits: 2, maximumFractionDigits: 2 })

async function submit() {
  loading.value = true; error.value = ''
  const result = await paymentStore.createPayment(form.value)
  loading.value = false
  if (result.success) router.push('/payments'); else error.value = result.message || 'Unable to record payment.'
}
async function sendMpesa() {
  mpesaLoading.value = true; mpesaMessage.value = ''; mpesaSuccess.value = false
  const result = await paymentStore.mpesaPayment({ invoice_id: form.value.invoice_id, phone: mpesaPhone.value, amount: form.value.amount })
  mpesaLoading.value = false; mpesaSuccess.value = result.success; mpesaMessage.value = result.success ? 'STK Push sent. Ask the customer to complete the prompt on their phone.' : (result.message || 'M-Pesa request failed.')
  if (result.success) setTimeout(() => router.push('/payments'), 1200)
}
onMounted(async () => { const result = await invoiceStore.fetchInvoices({ per_page: 100 }); invoices.value = (result.data || []).filter(i => Number(i.balance) > 0) })
</script>

<style scoped>
.label { @apply mb-1.5 block text-xs font-bold uppercase tracking-wide text-slate-500; }
.input { @apply w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10; }
</style>
