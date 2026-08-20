<template>
  <section class="mx-auto max-w-4xl">
    <div class="mb-6"><p class="text-sm font-semibold text-indigo-600">Settings</p><h2 class="text-2xl font-black">Business profile</h2><p class="mt-1 text-sm text-slate-500">This information appears on your invoices and PDFs.</p></div>
    <Loader v-if="loading" />
    <form v-else class="space-y-5 rounded-2xl bg-white p-5 ring-1 ring-slate-200" @submit.prevent="submit">
      <div class="grid gap-4 sm:grid-cols-2"><label class="block"><span class="label">Business name</span><input v-model="form.business_name" class="input" required /></label><label class="block"><span class="label">Business email</span><input v-model="form.email" type="email" class="input" /></label><label class="block"><span class="label">Phone</span><input v-model="form.phone" class="input" /></label><label class="block"><span class="label">Tax number</span><input v-model="form.tax_number" class="input" /></label><label class="block"><span class="label">Currency</span><input v-model="form.currency" maxlength="3" class="input uppercase" /></label><label class="block"><span class="label">Logo</span><input type="file" accept="image/*" class="input p-2" @change="handleLogo" /></label><label class="block sm:col-span-2"><span class="label">Address</span><textarea v-model="form.address" rows="3" class="input"></textarea></label></div>
      <div v-if="store.profile?.logo" class="rounded-xl bg-slate-50 p-3 text-sm text-slate-500">Current logo: <a :href="store.profile.logo" target="_blank" class="font-bold text-indigo-600">View logo</a></div>
      <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end"><button v-if="isEdit" type="button" class="rounded-xl bg-red-50 px-4 py-3 text-sm font-bold text-red-700" @click="deleteProfile">Delete profile</button><button type="submit" class="rounded-xl bg-indigo-600 px-5 py-3 text-sm font-bold text-white" :disabled="submitting">{{ submitting ? 'Saving…' : (isEdit ? 'Update profile' : 'Create profile') }}</button></div>
      <p v-if="message" :class="success ? 'text-emerald-600' : 'text-red-600'" class="text-sm font-semibold">{{ message }}</p>
    </form>
  </section>
</template>
<script setup>
import { computed, onMounted, ref } from 'vue'
import { useBusinessProfileStore } from '../stores/businessProfile'
import Loader from '../components/Loader.vue'
const store = useBusinessProfileStore(); const loading = ref(true); const submitting = ref(false); const message = ref(''); const success = ref(false); const logo = ref(null); const isEdit = computed(() => Boolean(store.profile?.id)); const form = ref({ business_name: '', email: '', phone: '', address: '', tax_number: '', currency: 'KES' })
async function load() { const result = await store.fetchProfile(); if (result.success && result.data) form.value = { business_name: result.data.business_name || '', email: result.data.email || '', phone: result.data.phone || '', address: result.data.address || '', tax_number: result.data.tax_number || '', currency: result.data.currency || 'KES' }; loading.value = false }
function handleLogo(e) { logo.value = e.target.files?.[0] || null }
async function submit() { submitting.value = true; message.value = ''; const data = new FormData(); Object.entries(form.value).forEach(([key, value]) => data.append(key, value ?? '')); if (logo.value) data.append('logo', logo.value); const result = isEdit.value ? await store.update(store.profile.id, data) : await store.create(data); submitting.value = false; success.value = result.success; message.value = result.success ? 'Business profile saved.' : (result.message || 'Unable to save profile.'); if (result.success) await load() }
async function deleteProfile() { if (!window.confirm('Delete your business profile?')) return; const result = await store.delete(store.profile.id); success.value = result.success; message.value = result.success ? 'Business profile deleted.' : result.message; if (result.success) form.value = { business_name: '', email: '', phone: '', address: '', tax_number: '', currency: 'KES' } }
onMounted(load)
</script>
<style scoped>
.label { @apply mb-1.5 block text-xs font-bold uppercase tracking-wide text-slate-500; }
.input { @apply w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10; }
</style>
