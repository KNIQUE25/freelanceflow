<template>
  <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:shadow-lg">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
      <div>
        <div class="flex items-center gap-2">
          <h3 class="text-lg font-bold text-slate-900">{{ invoice.invoice_number }}</h3>
          <span
            :class="[
              'inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium',
              invoice.status === 'paid' ? 'bg-green-100 text-green-800' :
              invoice.status === 'overdue' ? 'bg-red-100 text-red-800' :
              invoice.status === 'partially_paid' ? 'bg-yellow-100 text-yellow-800' :
              'bg-gray-100 text-gray-800'
            ]"
          >
            {{ invoice.status.replace('_', ' ') }}
          </span>
        </div>
        <p class="text-sm text-slate-500">Client: {{ invoice.client?.name }}</p>
        <p class="text-sm text-slate-500">Due: {{ invoice.due_date }}</p>
      </div>
      <div class="flex flex-wrap items-center gap-2">
        <span class="text-lg font-bold text-indigo-600">KES {{ invoice.total }}</span>
      </div>
    </div>

    <!-- Action Buttons -->
    <div class="mt-4 flex flex-wrap items-center gap-2 border-t border-slate-100 pt-4">
      <router-link
        :to="`/invoices/${invoice.id}`"
        class="inline-flex items-center rounded-lg bg-indigo-50 px-3 py-1.5 text-xs font-medium text-indigo-600 hover:bg-indigo-100"
      >
        👁️ View
      </router-link>

      <router-link
        :to="`/invoices/${invoice.id}/edit`"
        class="inline-flex items-center rounded-lg bg-amber-50 px-3 py-1.5 text-xs font-medium text-amber-600 hover:bg-amber-100"
      >
        ✏️ Edit
      </router-link>

      <button
        @click="downloadPdf(invoice.id)"
        class="inline-flex items-center rounded-lg bg-blue-50 px-3 py-1.5 text-xs font-medium text-blue-600 hover:bg-blue-100"
      >
        📄 PDF
      </button>

      <button
        @click="copyPublicLink(invoice.id)"
        class="inline-flex items-center rounded-lg bg-green-50 px-3 py-1.5 text-xs font-medium text-green-600 hover:bg-green-100"
      >
        🔗 Share
      </button>

      <button
        @click="$emit('delete-invoice', invoice.id)"
        class="inline-flex items-center rounded-lg bg-red-50 px-3 py-1.5 text-xs font-medium text-red-600 hover:bg-red-100"
      >
        🗑️ Delete
      </button>
    </div>
  </div>
</template>

<script setup>
import { defineProps, defineEmits } from 'vue'
import api from '../services/api'

const props = defineProps({
  invoice: { type: Object, required: true },
})

const emit = defineEmits(['delete-invoice'])

// Download PDF
async function downloadPdf(invoiceId) {
  try {
    const response = await api.get(`/api/invoices/${invoiceId}/pdf`, {
      responseType: 'blob',
    })
    const url = window.URL.createObjectURL(new Blob([response.data]))
    const link = document.createElement('a')
    link.href = url
    link.setAttribute('download', `invoice-${props.invoice.invoice_number}.pdf`)
    document.body.appendChild(link)
    link.click()
    link.remove()
    window.URL.revokeObjectURL(url)
  } catch (e) {
    alert('Failed to download PDF.')
  }
}

// Copy public link
async function copyPublicLink(invoiceId) {
  try {
    const response = await api.get(`/api/invoices/${invoiceId}/public-url`)
    const url = response.data.url
    await navigator.clipboard.writeText(url)
    alert('Public invoice link copied to clipboard!')
  } catch (e) {
    alert('Failed to generate public link.')
  }
}
</script>