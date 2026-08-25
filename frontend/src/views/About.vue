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
      <div class="mb-12">
        <p class="mb-3 text-sm font-semibold uppercase tracking-wider text-primary-600">About</p>
        <h1 class="text-4xl font-extrabold tracking-tight sm:text-5xl">About FreelanceFlow</h1>
        <p class="mt-4 text-slate-500 dark:text-slate-400">Built for freelancers who want to focus on work, not paperwork.</p>
      </div>
      <div class="space-y-10 leading-8 text-slate-600 dark:text-slate-300">
        <section>
          <h2 class="mb-3 text-2xl font-bold text-slate-900 dark:text-white">Our Mission</h2>
          <p>FreelanceFlow was created to simplify the business side of freelancing. We believe that managing clients, invoices and payments should be straightforward so you can spend more time doing what you love.</p>
        </section>
        <section>
          <h2 class="mb-3 text-2xl font-bold text-slate-900 dark:text-white">Who We Are</h2>
          <p>We are a small team of developers and designers who understand the challenges freelancers face. Our goal is to provide a reliable, secure and easy‑to‑use platform that grows with your business.</p>
        </section>
        <section>
          <h2 class="mb-3 text-2xl font-bold text-slate-900 dark:text-white">Why FreelanceFlow?</h2>
          <ul class="list-disc space-y-2 pl-6">
            <li>Professional invoicing with PDF export</li>
            <li>M‑Pesa STK Push payments (where configured)</li>
            <li>Real‑time business insights and reports</li>
            <li>Secure Laravel Sanctum authentication</li>
          </ul>
        </section>
      </div>
    </main>
    <footer class="border-t border-slate-200 bg-slate-50 py-8 dark:border-slate-800 dark:bg-slate-900">
      <div class="mx-auto max-w-7xl px-6 text-center text-sm text-slate-500">© {{ new Date().getFullYear() }} FreelanceFlow. All rights reserved.</div>
    </footer>
  </div>
</template>