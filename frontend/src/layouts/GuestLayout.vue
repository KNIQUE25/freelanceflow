<template>
  <div class="min-h-screen bg-[radial-gradient(circle_at_top_right,rgba(99,102,241,.16),transparent_32%),linear-gradient(135deg,#f8faff,#eef2ff)] px-4 py-6 sm:px-6 sm:py-10">
    <div class="mx-auto mb-6 flex max-w-md justify-center"><router-link to="/" class="flex items-center gap-2.5"><img src="/ff-logo.png" alt="FreelanceFlow" class="h-10 w-10 rounded-xl object-contain" /><span class="text-xl font-black text-slate-900">Freelance<span class="text-indigo-600">Flow</span></span></router-link></div>
    <div class="mx-auto w-full max-w-md"><router-view /></div>
    <p class="mx-auto mt-6 max-w-md text-center text-xs text-slate-400">© {{ year }} FreelanceFlow · Invoicing made simple.</p>
  </div>
</template>
<script setup>
const year = new Date().getFullYear()
</script>
