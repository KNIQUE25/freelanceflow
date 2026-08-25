<template>
  <div class="min-h-screen bg-white text-slate-900 dark:bg-slate-950 dark:text-slate-100">
    <header class="border-b border-slate-200 dark:border-slate-800">
      <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-5">
        <router-link to="/" class="flex items-center gap-3">
          <img src="/ff-logo.png" alt="FreelanceFlow" class="h-10 w-10 rounded-xl object-contain" />
          <span class="text-xl font-extrabold">Freelance<span class="text-primary-600">Flow</span></span>
        </router-link>
        <router-link to="/" class="text-sm font-semibold text-slate-600 hover:text-primary-600 dark:text-slate-300">← Back to Home</router-link>
      </div>
    </header>
    <main class="mx-auto max-w-3xl px-6 py-16">
      <div class="mb-12 text-center">
        <p class="mb-3 text-sm font-semibold uppercase tracking-wider text-primary-600">Contact</p>
        <h1 class="text-4xl font-extrabold tracking-tight sm:text-5xl">Get in Touch</h1>
        <p class="mt-4 text-slate-500 dark:text-slate-400">We'd love to hear from you.</p>
      </div>
      <form @submit.prevent="submit" class="space-y-6">
        <div>
          <label class="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-200">Full Name</label>
          <input type="text" v-model="form.name" required class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-slate-900 outline-none transition focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
        </div>
        <div>
          <label class="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-200">Email</label>
          <input type="email" v-model="form.email" required class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-slate-900 outline-none transition focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
        </div>
        <div>
          <label class="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-200">Message</label>
          <textarea rows="5" v-model="form.message" required class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-slate-900 outline-none transition focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 dark:border-slate-700 dark:bg-slate-800 dark:text-white"></textarea>
        </div>
        <button type="submit" class="w-full rounded-xl bg-primary-600 px-6 py-3.5 font-semibold text-white shadow-lg shadow-primary-600/20 transition hover:bg-primary-700">Send Message</button>
        <div v-if="submitted" class="rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700 dark:border-green-900/50 dark:bg-green-950/40 dark:text-green-300">Message sent successfully!</div>
      </form>
    </main>
    <footer class="border-t border-slate-200 bg-slate-50 py-8 dark:border-slate-800 dark:bg-slate-900">
      <div class="mx-auto max-w-7xl px-6 text-center text-sm text-slate-500">© {{ new Date().getFullYear() }} FreelanceFlow. All rights reserved.</div>
    </footer>
  </div>
</template>

<script setup>
import { reactive, ref } from 'vue'

const form = reactive({ name: '', email: '', message: '' })
const submitted = ref(false)

const submit = () => {
  // For now, just simulate sending
  console.log('Contact form:', form)
  submitted.value = true
  setTimeout(() => { submitted.value = false }, 5000)
}
</script>