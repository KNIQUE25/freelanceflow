<template>
  <table class="min-w-[760px] w-full bg-white">
    <thead><tr class="border-b border-slate-200 bg-slate-50"><th v-for="h in headers" :key="h" class="p-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">{{ h }}</th></tr></thead>
    <tbody>
      <tr v-for="client in clients" :key="client.id" class="border-b border-slate-100 hover:bg-slate-50">
        <td class="p-3"><div class="font-bold text-slate-800">{{ client.name }}</div><div class="text-xs text-slate-400">{{ client.email || 'No email' }}</div></td>
        <td class="p-3 text-sm text-slate-600">{{ client.phone || '-' }}</td>
        <td class="p-3 text-sm text-slate-600">{{ client.company || '-' }}</td>
        <td class="p-3 text-sm text-slate-600">{{ client.invoices_count ?? 0 }}</td>
        <td class="p-3"><div class="flex gap-3 text-sm"><router-link :to="`/clients/${client.id}`" class="font-semibold text-indigo-600">View</router-link><router-link :to="`/clients/${client.id}/edit`" class="font-semibold text-emerald-600">Edit</router-link><button class="font-semibold text-red-600" @click="handleDelete(client.id)">Delete</button></div></td>
      </tr>
    </tbody>
  </table>
</template>

<script setup>
defineProps({ clients: { type: Array, required: true } })
const emit = defineEmits(['delete-client'])
const headers = ['Client', 'Phone', 'Company', 'Invoices', 'Actions']
const handleDelete = (id) => { if (window.confirm('Delete this client? Any related invoices will also be deleted.')) emit('delete-client', id) }
</script>
