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
    <main class="mx-auto max-w-4xl px-6 py-16">
      <div class="mb-12 text-center">
        <p class="mb-3 text-sm font-semibold uppercase tracking-wider text-primary-600">Features</p>
        <h1 class="text-4xl font-extrabold tracking-tight sm:text-5xl">Everything You Need</h1>
        <p class="mt-4 text-slate-500 dark:text-slate-400">Powerful features without the complicated setup.</p>
      </div>
      <div class="grid gap-8 md:grid-cols-2">
        <div class="rounded-2xl border border-slate-200 p-6 dark:border-slate-800">
          <div class="text-4xl mb-3">👥</div>
          <h3 class="text-xl font-bold text-slate-900 dark:text-white">Client Management</h3>
          <p class="mt-2 text-slate-600 dark:text-slate-400">Organize all your clients in one place. Track contact details, project history and communication.</p>
        </div>
        <div class="rounded-2xl border border-slate-200 p-6 dark:border-slate-800">
          <div class="text-4xl mb-3">📄</div>
          <h3 class="text-xl font-bold text-slate-900 dark:text-white">Smart Invoices</h3>
          <p class="mt-2 text-slate-600 dark:text-slate-400">Create professional invoices with automatic numbering, taxes, discounts and PDF downloads.</p>
        </div>
        <div class="rounded-2xl border border-slate-200 p-6 dark:border-slate-800">
          <div class="text-4xl mb-3">💰</div>
          <h3 class="text-xl font-bold text-slate-900 dark:text-white">M‑Pesa Payments</h3>
          <p class="mt-2 text-slate-600 dark:text-slate-400">Get paid faster with M‑Pesa STK Push. Secure, instant and hassle‑free.</p>
        </div>
        <div class="rounded-2xl border border-slate-200 p-6 dark:border-slate-800">
          <div class="text-4xl mb-3">📊</div>
          <h3 class="text-xl font-bold text-slate-900 dark:text-white">Reports & Insights</h3>
          <p class="mt-2 text-slate-600 dark:text-slate-400">Understand your business with revenue summaries, invoice breakdowns and client analytics.</p>
        </div>
      </div>
    </main>
    <footer class="border-t border-slate-200 bg-slate-50 py-8 dark:border-slate-800 dark:bg-slate-900">
      <div class="mx-auto max-w-7xl px-6 text-center text-sm text-slate-500">© {{ new Date().getFullYear() }} FreelanceFlow.</div>
    </footer>
  </div>
</template>