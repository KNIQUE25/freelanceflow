<template>
  <section>
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
      <div><p class="text-sm font-semibold text-indigo-600">Workspace</p><h2 class="text-2xl font-black text-slate-900">Clients</h2><p class="mt-1 text-sm text-slate-500">Keep your client records organized.</p></div>
      <router-link to="/clients/create" class="rounded-xl bg-indigo-600 px-4 py-3 text-center text-sm font-bold text-white shadow-lg shadow-indigo-600/20 hover:bg-indigo-700">+ Add Client</router-link>
    </div>
    <Loader v-if="loading" />
    <div v-else class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
      <div class="overflow-x-auto"><ClientTable :clients="clients" @delete-client="removeClient" /></div>
      <div class="px-4 pb-4"><Pagination :meta="meta" @page-change="fetchPage" /></div>
    </div>
    <p v-if="!loading && !clients.length" class="mt-6 rounded-2xl border border-dashed border-slate-300 bg-white p-8 text-center text-sm text-slate-500">No clients yet. Add your first client to start creating invoices.</p>
  </section>
</template>

<script setup>
import { computed, onMounted } from 'vue'
import { storeToRefs } from 'pinia'
import { useClientsStore } from '../../stores/clients'
import ClientTable from '../../components/ClientTable.vue'
import Pagination from '../../components/Pagination.vue'
import Loader from '../../components/Loader.vue'

const store = useClientsStore()
const { clients, meta, isLoading: loading } = storeToRefs(store)
const fetchPage = (page) => store.fetchClients({ page })
async function removeClient(id) { if ((await store.delete(id)).success) await store.fetchClients() }
onMounted(() => store.fetchClients())
</script>
