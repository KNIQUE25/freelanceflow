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
      <div class="mx-auto mb-14 max-w-2xl text-center">
        <span class="inline-flex rounded-full bg-primary-50 px-4 py-2 text-sm font-semibold text-primary-700 dark:bg-primary-950/50 dark:text-primary-300">Help Center</span>
        <h1 class="mt-5 text-4xl font-extrabold sm:text-5xl">Frequently Asked Questions</h1>
        <p class="mt-5 text-lg text-slate-600 dark:text-slate-400">Everything you need to know about FreelanceFlow.</p>
      </div>
      <div class="space-y-4">
        <details v-for="(faq, index) in faqs" :key="index" class="group rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:shadow-md dark:border-slate-800 dark:bg-slate-900">
          <summary class="flex cursor-pointer list-none items-center justify-between gap-4 font-bold text-slate-900 dark:text-white">
            <span>{{ faq.question }}</span>
            <span class="text-2xl text-primary-600 transition group-open:rotate-45">+</span>
          </summary>
          <p class="mt-4 leading-7 text-slate-600 dark:text-slate-400">{{ faq.answer }}</p>
        </details>
      </div>
      <div class="mt-16 rounded-3xl bg-primary-600 p-8 text-center text-white sm:p-12">
        <h2 class="text-2xl font-bold">Still have questions?</h2>
        <p class="mt-3 text-primary-100">We're happy to help you understand how FreelanceFlow works.</p>
        <router-link to="/contact" class="mt-6 inline-flex rounded-xl bg-white px-6 py-3 font-bold text-primary-700 transition hover:bg-primary-50">Contact Us</router-link>
      </div>
    </main>
    <footer class="border-t border-slate-200 py-8 dark:border-slate-800">
      <div class="mx-auto max-w-7xl px-6 text-center text-sm text-slate-500">© {{ new Date().getFullYear() }} FreelanceFlow. All rights reserved.</div>
    </footer>
  </div>
</template>

<script setup>
const faqs = [
  { question: 'What is FreelanceFlow?', answer: 'FreelanceFlow is an invoicing and business-management platform designed to help freelancers and small businesses manage clients, invoices, payments and business records from one place.' },
  { question: 'Who is FreelanceFlow designed for?', answer: 'FreelanceFlow is designed primarily for freelancers, independent professionals and small businesses that need a simple way to manage clients, invoices and payments.' },
  { question: 'Can I create professional invoices?', answer: 'Yes. You can create invoices containing your client information, invoice items, taxes, totals, payment information and notes. Invoices can also be downloaded as PDF documents.' },
  { question: 'Does FreelanceFlow support M-Pesa?', answer: 'Yes. The platform is designed to support M-Pesa payment workflows, including STK Push payments where the required payment configuration is enabled.' },
  { question: 'Can I track payments?', answer: 'Yes. Payments can be associated with invoices so you can monitor paid amounts, outstanding balances and invoice payment status.' },
  { question: 'Can I manage multiple clients?', answer: 'Yes. You can create and manage client records containing information such as names, email addresses, phone numbers, companies and addresses.' },
  { question: 'Can I download invoices as PDF?', answer: 'Yes. FreelanceFlow provides PDF invoice generation so that professional invoices can be downloaded and shared with clients.' },
  { question: 'Can I see which invoices are overdue?', answer: 'Yes. Invoice statuses can be used to identify unpaid, partially paid, paid and overdue invoices.' },
  { question: 'Is my account protected?', answer: 'FreelanceFlow uses authentication and authorization controls to protect account information and restrict access to resources belonging to authenticated users.' },
  { question: 'Can I reset my password?', answer: 'Yes. If you forget your password, use the Forgot Password option on the login page to request a password reset link.' },
  { question: 'Can I update my business information?', answer: 'Yes. Business profile information such as business name, email, phone, address, tax number, logo and currency can be managed from the application.' },
  { question: 'Is FreelanceFlow free?', answer: 'The availability and pricing of FreelanceFlow features depend on the version and deployment of the application. Check the Pricing page for the current plan information.' },
]
</script>