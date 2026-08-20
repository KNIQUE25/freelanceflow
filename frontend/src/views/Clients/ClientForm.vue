<template>
  <div class="bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-6">{{ isEdit ? 'Edit Client' : 'Create Client' }}</h2>
    <form @submit.prevent="submit">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700">Name *</label>
          <input v-model="form.name" type="text" class="w-full border rounded px-3 py-2" required />
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700">Email</label>
          <input v-model="form.email" type="email" class="w-full border rounded px-3 py-2" />
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700">Phone</label>
          <input v-model="form.phone" type="text" class="w-full border rounded px-3 py-2" />
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700">Company</label>
          <input v-model="form.company" type="text" class="w-full border rounded px-3 py-2" />
        </div>
        <div class="md:col-span-2">
          <label class="block text-sm font-medium text-gray-700">Address</label>
          <textarea v-model="form.address" rows="2" class="w-full border rounded px-3 py-2"></textarea>
        </div>
      </div>
      <div class="mt-4 flex gap-2">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition" :disabled="loading">
          {{ loading ? 'Saving...' : (isEdit ? 'Update' : 'Create') }}
        </button>
        <router-link to="/clients" class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400 transition">Cancel</router-link>
      </div>
      <p v-if="error" class="text-red-600 text-sm mt-2">{{ error }}</p>
    </form>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import { useClientsStore } from '../../stores/clients'

const router = useRouter()
const route = useRoute()
const store = useClientsStore()

const loading = ref(false)
const error = ref('')
const isEdit = computed(() => !!route.params.id)

const form = ref({
  name: '',
  email: '',
  phone: '',
  company: '',
  address: '',
})

async function submit() {
  loading.value = true
  error.value = ''
  let result
  if (isEdit.value) {
    result = await store.update(route.params.id, form.value)
  } else {
    result = await store.create(form.value)
  }
  if (result.success) {
    router.push('/clients')
  } else {
    error.value = result.message
  }
  loading.value = false
}

onMounted(async () => {
  if (isEdit.value) {
    const res = await store.fetchClient(route.params.id)
    if (res.success) {
      form.value = { ...res.data }
    }
  }
})
</script>