<template>
  <div>
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-2xl font-bold">Users</h2>
      <input v-model="search" placeholder="Search..." class="border rounded px-3 py-1" @input="fetchUsers" />
    </div>
    <div v-if="store.loading">Loading...</div>
    <div v-else>
      <table class="w-full bg-white rounded shadow">
        <thead>
          <tr class="border-b">
            <th class="p-3 text-left">Name</th>
            <th class="p-3 text-left">Email</th>
            <th class="p-3 text-left">Role</th>
            <th class="p-3 text-left">Status</th>
            <th class="p-3 text-left">Clients</th>
            <th class="p-3 text-left">Invoices</th>
            <th class="p-3 text-left">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="user in store.users.data" :key="user.id" class="border-b hover:bg-gray-50">
            <td class="p-3">{{ user.name }}</td>
            <td class="p-3">{{ user.email }}</td>
            <td class="p-3">{{ user.role }}</td>
            <td class="p-3">
              <span :class="user.suspended_at ? 'text-red-600' : 'text-green-600'">
                {{ user.suspended_at ? 'Suspended' : 'Active' }}
              </span>
            </td>
            <td class="p-3">{{ user.clients_count }}</td>
            <td class="p-3">{{ user.invoices_count }}</td>
            <td class="p-3 space-x-2">
              <button v-if="!user.suspended_at" @click="suspend(user.id)" class="text-yellow-600">Suspend</button>
              <button v-else @click="activate(user.id)" class="text-green-600">Activate</button>
              <button @click="deleteUser(user.id)" class="text-red-600">Delete</button>
            </td>
          </tr>
        </tbody>
      </table>
      <Pagination :meta="store.users.meta" @page-change="fetchUsers" class="mt-4" />
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useAdminStore } from '@/stores/admin'
import Pagination from '@/components/Pagination.vue'

const store = useAdminStore()
const search = ref('')

const fetchUsers = (page = 1) => {
  store.fetchUsers({ search: search.value, page })
}

const suspend = async (id) => {
  if (confirm('Suspend this user?')) await store.suspendUser(id)
}
const activate = async (id) => {
  if (confirm('Activate this user?')) await store.activateUser(id)
}
const deleteUser = async (id) => {
  if (confirm('Delete this user?')) await store.deleteUser(id)
}

onMounted(fetchUsers)
</script>