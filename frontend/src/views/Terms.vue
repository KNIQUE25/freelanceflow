<template>
    <div class="min-h-screen bg-white text-slate-900 dark:bg-slate-950 dark:text-slate-100">

        <!-- Header -->
        <header class="border-b border-slate-200 dark:border-slate-800">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-5">

                <router-link
                    to="/"
                    class="flex items-center gap-3"
                >
                    <img
                        src="/ff-logo.png"
                        alt="FreelanceFlow"
                        class="h-10 w-10 rounded-xl object-contain"
                    />

                    <span class="text-xl font-extrabold">
                        Freelance<span class="text-primary-600">Flow</span>
                    </span>
                </router-link>

                <router-link
                    to="/"
                    class="text-sm font-semibold text-slate-600 hover:text-primary-600 dark:text-slate-300"
                >
                    ← Back to Home
                </router-link>

            </div>
        </header>

        <!-- Content -->
        <main class="mx-auto max-w-4xl px-6 py-16">

            <div class="mb-12">
                <p class="mb-3 text-sm font-semibold uppercase tracking-wider text-primary-600">
                    Legal
                </p>

                <h1 class="text-4xl font-extrabold tracking-tight sm:text-5xl">
                    Terms of Service
                </h1>

                <p class="mt-4 text-slate-500 dark:text-slate-400">
                    Last updated: August 2026
                </p>
            </div>

            <div class="space-y-10 leading-8 text-slate-600 dark:text-slate-300">

                <section>
                    <h2 class="mb-3 text-2xl font-bold text-slate-900 dark:text-white">
                        1. Acceptance of Terms
                    </h2>

                    <p>
                        By creating an account or using FreelanceFlow, you agree
                        to these Terms of Service. If you do not agree with these
                        terms, please do not use the service.
                    </p>
                </section>

                <section>
                    <h2 class="mb-3 text-2xl font-bold text-slate-900 dark:text-white">
                        2. Description of Service
                    </h2>

                    <p>
                        FreelanceFlow provides tools for freelancers and small
                        businesses to manage clients, create invoices, track
                        payments, generate reports and manage business information.
                    </p>
                </section>

                <section>
                    <h2 class="mb-3 text-2xl font-bold text-slate-900 dark:text-white">
                        3. User Accounts
                    </h2>

                    <p>
                        You are responsible for maintaining the confidentiality
                        of your account credentials and for all activity performed
                        through your account.
                    </p>
                </section>

                <section>
                    <h2 class="mb-3 text-2xl font-bold text-slate-900 dark:text-white">
                        4. Invoices and Payments
                    </h2>

                    <p>
                        FreelanceFlow provides invoicing and payment-management
                        functionality. Users are responsible for ensuring that
                        invoice information, payment amounts and client details
                        are accurate.
                    </p>
                </section>

                <section>
                    <h2 class="mb-3 text-2xl font-bold text-slate-900 dark:text-white">
                        5. M-Pesa Payments
                    </h2>

                    <p>
                        Where M-Pesa functionality is available, transactions
                        may be processed through the relevant payment infrastructure.
                        Users are responsible for providing accurate payment
                        information and complying with applicable payment rules.
                    </p>
                </section>

                <section>
                    <h2 class="mb-3 text-2xl font-bold text-slate-900 dark:text-white">
                        6. Prohibited Use
                    </h2>

                    <p>
                        You must not use FreelanceFlow for unlawful activities,
                        fraudulent transactions, unauthorized access, abuse of
                        other users or activities that could damage the service.
                    </p>
                </section>

                <section>
                    <h2 class="mb-3 text-2xl font-bold text-slate-900 dark:text-white">
                        7. Service Availability
                    </h2>

                    <p>
                        We aim to keep FreelanceFlow available and reliable, but
                        temporary interruptions may occur due to maintenance,
                        infrastructure problems or circumstances outside our control.
                    </p>
                </section>

                <section>
                    <h2 class="mb-3 text-2xl font-bold text-slate-900 dark:text-white">
                        8. Changes to These Terms
                    </h2>

                    <p>
                        These terms may be updated from time to time. Continued
                        use of FreelanceFlow after changes are published means
                        you accept the updated terms.
                    </p>
                </section>

                <section>
                    <h2 class="mb-3 text-2xl font-bold text-slate-900 dark:text-white">
                        9. Contact
                    </h2>

                    <p>
                        If you have questions about these Terms of Service,
                        please contact us through the Contact page.
                    </p>
                </section>

            </div>
        </main>

        <footer class="border-t border-slate-200 bg-slate-50 py-8 dark:border-slate-800 dark:bg-slate-900">
            <div class="mx-auto max-w-7xl px-6 text-center text-sm text-slate-500">
                © {{ new Date().getFullYear() }} FreelanceFlow. All rights reserved.
            </div>
        </footer>

    </div>
</template>