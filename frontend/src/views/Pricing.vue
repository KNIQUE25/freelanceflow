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
        <p class="mb-3 text-sm font-semibold uppercase tracking-wider text-primary-600">Pricing</p>
        <h1 class="text-4xl font-extrabold tracking-tight sm:text-5xl">Simple, Transparent Pricing</h1>
        <p class="mt-4 text-slate-500 dark:text-slate-400">Choose the plan that fits your freelance business.</p>
      </div>
      <div class="grid gap-6 md:grid-cols-2">
        <div class="rounded-2xl border border-slate-200 p-8 dark:border-slate-800">
          <h3 class="text-xl font-bold text-slate-900 dark:text-white">Free</h3>
          <p class="mt-2 text-4xl font-extrabold text-slate-900 dark:text-white">$0</p>
          <ul class="mt-6 space-y-3 text-slate-600 dark:text-slate-400">
            <li>✓ 5 clients</li>
            <li>✓ 10 invoices/month</li>
            <li>✓ PDF export</li>
            <li>✓ Basic reports</li>
          </ul>
          <router-link to="/register" class="mt-6 block w-full rounded-xl bg-primary-600 px-4 py-3 text-center font-semibold text-white transition hover:bg-primary-700">Start Free</router-link>
        </div>
        <div class="rounded-2xl border-2 border-primary-600 bg-primary-50 p-8 dark:bg-primary-950/30">
          <h3 class="text-xl font-bold text-slate-900 dark:text-white">Pro</h3>
          <p class="mt-2 text-4xl font-extrabold text-slate-900 dark:text-white">$9/mo</p>
          <ul class="mt-6 space-y-3 text-slate-600 dark:text-slate-400">
            <li>✓ Unlimited clients</li>
            <li>✓ Unlimited invoices</li>
            <li>✓ M‑Pesa STK Push</li>
            <li>✓ Advanced reports</li>
            <li>✓ Priority support</li>
          </ul>
          <router-link to="/register" class="mt-6 block w-full rounded-xl bg-primary-600 px-4 py-3 text-center font-semibold text-white transition hover:bg-primary-700">Start Free Trial</router-link>
        </div>
      </div>
    </main>
    <footer class="border-t border-slate-200 bg-slate-50 py-8 dark:border-slate-800 dark:bg-slate-900">
      <div class="mx-auto max-w-7xl px-6 text-center text-sm text-slate-500">© {{ new Date().getFullYear() }} FreelanceFlow.</div>
    </footer>
  </div>
</template>