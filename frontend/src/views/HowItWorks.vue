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
        <p class="mb-3 text-sm font-semibold uppercase tracking-wider text-primary-600">How It Works</p>
        <h1 class="text-4xl font-extrabold tracking-tight sm:text-5xl">Start in Minutes</h1>
        <p class="mt-4 text-slate-500 dark:text-slate-400">Three simple steps to manage your freelance business.</p>
      </div>
      <div class="space-y-12">
        <div class="flex flex-col md:flex-row gap-6 items-center">
          <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-full bg-primary-600 text-2xl font-bold text-white">1</div>
          <div><h2 class="text-2xl font-bold text-slate-900 dark:text-white">Create Your Account</h2><p class="mt-2 text-slate-600 dark:text-slate-400">Sign up with your email and password. Set up your business profile with your logo and company details.</p></div>
        </div>
        <div class="flex flex-col md:flex-row gap-6 items-center">
          <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-full bg-primary-600 text-2xl font-bold text-white">2</div>
          <div><h2 class="text-2xl font-bold text-slate-900 dark:text-white">Add Clients & Invoices</h2><p class="mt-2 text-slate-600 dark:text-slate-400">Create client records, then generate professional invoices with line items, taxes and due dates.</p></div>
        </div>
        <div class="flex flex-col md:flex-row gap-6 items-center">
          <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-full bg-primary-600 text-2xl font-bold text-white">3</div>
          <div><h2 class="text-2xl font-bold text-slate-900 dark:text-white">Get Paid</h2><p class="mt-2 text-slate-600 dark:text-slate-400">Track payments, send reminders and accept M‑Pesa STK Push payments when configured.</p></div>
        </div>
      </div>
    </main>
    <footer class="border-t border-slate-200 bg-slate-50 py-8 dark:border-slate-800 dark:bg-slate-900">
      <div class="mx-auto max-w-7xl px-6 text-center text-sm text-slate-500">© {{ new Date().getFullYear() }} FreelanceFlow.</div>
    </footer>
  </div>
</template>