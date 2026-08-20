<template>
  <section class="mx-auto max-w-5xl">
    <div class="mb-6"><p class="text-sm font-semibold text-indigo-600">Billing</p><h2 class="text-2xl font-black text-slate-900">{{ isEdit ? 'Edit Invoice' : 'Create Invoice' }}</h2></div>
    <form class="space-y-6" @submit.prevent="submit">
      <div class="grid gap-4 rounded-2xl bg-white p-5 ring-1 ring-slate-200 sm:grid-cols-2">
        <label class="block"><span class="label">Client</span><select v-model="form.client_id" class="input" required><option value="">Select client</option><option v-for="client in clients" :key="client.id" :value="client.id">{{ client.name }}{{ client.company ? ` — ${client.company}` : '' }}</option></select></label>
        <label class="block"><span class="label">Issue date</span><input v-model="form.issue_date" type="date" class="input" required /></label>
        <label class="block"><span class="label">Due date</span><input v-model="form.due_date" type="date" class="input" required /></label>
        <label class="block"><span class="label">Tax amount (KES)</span><input v-model.number="form.tax" type="number" min="0" step="0.01" class="input" /></label>
      </div>

      <div class="rounded-2xl bg-white p-5 ring-1 ring-slate-200">
        <div class="mb-4 flex items-center justify-between"><div><h3 class="font-black">Invoice items</h3><p class="text-xs text-slate-400">Quantity × unit price is calculated automatically.</p></div><button type="button" class="rounded-xl bg-indigo-50 px-3 py-2 text-sm font-bold text-indigo-700" @click="addItem">+ Add item</button></div>
        <div class="space-y-3">
          <div v-for="(item, index) in form.items" :key="index" class="grid gap-3 rounded-xl bg-slate-50 p-3 sm:grid-cols-[1fr_110px_140px_auto]">
            <input v-model="item.description" class="input bg-white" placeholder="Description" required />
            <input v-model.number="item.quantity" type="number" min="0.01" step="0.01" class="input bg-white" placeholder="Qty" required />
            <input v-model.number="item.unit_price" type="number" min="0" step="0.01" class="input bg-white" placeholder="Unit price" required />
            <button v-if="form.items.length > 1" type="button" class="rounded-xl px-3 text-red-600 hover:bg-red-50" @click="removeItem(index)">Remove</button>
          </div>
        </div>
        <div class="mt-5 ml-auto max-w-sm space-y-2 text-sm"><div class="flex justify-between"><span>Subtotal</span><strong>KES {{ money(subtotal) }}</strong></div><div class="flex justify-between"><span>Tax</span><strong>KES {{ money(form.tax) }}</strong></div><div class="flex justify-between border-t pt-3 text-base"><span class="font-black">Total</span><strong class="font-black">KES {{ money(total) }}</strong></div></div>
      </div>

      <div class="rounded-2xl bg-white p-5 ring-1 ring-slate-200"><label class="label">Note</label><textarea v-model="form.note" rows="4" class="input" placeholder="Payment terms or a short note..."></textarea></div>
      <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end"><router-link to="/invoices" class="rounded-xl bg-slate-100 px-5 py-3 text-center text-sm font-bold text-slate-700">Cancel</router-link><button type="submit" class="rounded-xl bg-indigo-600 px-5 py-3 text-sm font-bold text-white disabled:opacity-50" :disabled="loading">{{ loading ? 'Saving…' : (isEdit ? 'Update invoice' : 'Create invoice') }}</button></div>
      <p v-if="error" class="rounded-xl bg-red-50 p-3 text-sm text-red-700">{{ error }}</p>
    </form>
  </section>
</template>

<script setup>
import { computed, onMounted, ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useInvoicesStore } from '../../stores/invoices'
import { useClientsStore } from '../../stores/clients'

const router = useRouter(); const route = useRoute(); const invoiceStore = useInvoicesStore(); const clientStore = useClientsStore()
const loading = ref(false); const error = ref(''); const clients = ref([]); const isEdit = computed(() => Boolean(route.params.id))
const today = new Date(); const plusSeven = new Date(Date.now() + 7 * 86400000)
const dateValue = (d) => d.toISOString().slice(0, 10)
const form = ref({ client_id: '', issue_date: dateValue(today), due_date: dateValue(plusSeven), tax: 0, note: '', items: [{ description: '', quantity: 1, unit_price: 0 }] })
const subtotal = computed(() => form.value.items.reduce((sum, item) => sum + Number(item.quantity || 0) * Number(item.unit_price || 0), 0))
const total = computed(() => subtotal.value + Number(form.value.tax || 0))
const money = (v) => Number(v || 0).toLocaleString('en-KE', { minimumFractionDigits: 2, maximumFractionDigits: 2 })
const addItem = () => form.value.items.push({ description: '', quantity: 1, unit_price: 0 })
const removeItem = (index) => form.value.items.splice(index, 1)

async function submit() {
  error.value = ''
  if (form.value.due_date < form.value.issue_date) { error.value = 'Due date cannot be before issue date.'; return }
  loading.value = true
  const payload = JSON.parse(JSON.stringify(form.value))
  const result = isEdit.value ? await invoiceStore.update(route.params.id, payload) : await invoiceStore.create(payload)
  loading.value = false
  if (result.success) router.push(isEdit.value ? `/invoices/${route.params.id}` : '/invoices')
  else error.value = result.message || 'Unable to save invoice.'
}

onMounted(async () => {
  const clientsResult = await clientStore.fetchClients({ per_page: 100 })
  clients.value = clientsResult.data || []
  if (isEdit.value) {
    const result = await invoiceStore.fetchInvoice(route.params.id)
    if (result.success) {
      const data = result.data
      form.value = { client_id: data.client?.id || '', issue_date: data.issue_date, due_date: data.due_date, tax: Number(data.tax || 0), note: data.note || '', items: data.items?.map(i => ({ description: i.description, quantity: Number(i.quantity), unit_price: Number(i.unit_price) })) || [{ description: '', quantity: 1, unit_price: 0 }] }
    } else error.value = result.message || 'Invoice not found.'
  }
})
</script>

<style scoped>
.label { @apply mb-1.5 block text-xs font-bold uppercase tracking-wide text-slate-500; }
.input { @apply w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10; }
</style>
