<template>
    <div class="min-h-screen bg-white text-slate-900 dark:bg-slate-950 dark:text-slate-100">

        <header class="border-b border-slate-200 dark:border-slate-800">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-5">

                <router-link to="/" class="flex items-center gap-3">
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

        <main class="mx-auto max-w-4xl px-6 py-16">

            <div class="mb-12">
                <p class="mb-3 text-sm font-semibold uppercase tracking-wider text-primary-600">
                    Legal
                </p>

                <h1 class="text-4xl font-extrabold sm:text-5xl">
                    Privacy Policy
                </h1>

                <p class="mt-4 text-slate-500 dark:text-slate-400">
                    Last updated: August 2026
                </p>
            </div>

            <div class="space-y-10 leading-8 text-slate-600 dark:text-slate-300">

                <section>
                    <h2 class="mb-3 text-2xl font-bold text-slate-900 dark:text-white">
                        1. Information We Collect
                    </h2>

                    <p>
                        FreelanceFlow may collect information such as your name,
                        email address, contact information, business details,
                        invoice information and payment-related records that you
                        provide when using the service.
                    </p>
                </section>

                <section>
                    <h2 class="mb-3 text-2xl font-bold text-slate-900 dark:text-white">
                        2. How We Use Information
                    </h2>

                    <p>
                        Information may be used to provide and improve the service,
                        authenticate users, manage invoices, process supported
                        payments, provide notifications and maintain account security.
                    </p>
                </section>

                <section>
                    <h2 class="mb-3 text-2xl font-bold text-slate-900 dark:text-white">
                        3. Account Information
                    </h2>

                    <p>
                        Your account information is used to provide access to your
                        FreelanceFlow workspace and its associated features.
                    </p>
                </section>

                <section>
                    <h2 class="mb-3 text-2xl font-bold text-slate-900 dark:text-white">
                        4. Payment Information
                    </h2>

                    <p>
                        Payment transactions may involve external payment providers.
                        FreelanceFlow should not be treated as storing sensitive
                        payment credentials unless explicitly stated by the service.
                    </p>
                </section>

                <section>
                    <h2 class="mb-3 text-2xl font-bold text-slate-900 dark:text-white">
                        5. Data Security
                    </h2>

                    <p>
                        We take reasonable measures to protect account and business
                        information against unauthorized access, alteration or disclosure.
                    </p>
                </section>

                <section>
                    <h2 class="mb-3 text-2xl font-bold text-slate-900 dark:text-white">
                        6. Data Retention
                    </h2>

                    <p>
                        Information may be retained for as long as necessary to
                        provide the service, comply with applicable requirements
                        and maintain appropriate business records.
                    </p>
                </section>

                <section>
                    <h2 class="mb-3 text-2xl font-bold text-slate-900 dark:text-white">
                        7. Your Rights
                    </h2>

                    <p>
                        Depending on applicable law, you may have rights relating
                        to accessing, correcting or requesting deletion of your
                        personal information.
                    </p>
                </section>

                <section>
                    <h2 class="mb-3 text-2xl font-bold text-slate-900 dark:text-white">
                        8. Contact
                    </h2>

                    <p>
                        If you have questions regarding privacy or your information,
                        please contact us through the Contact page.
                    </p>
                </section>

            </div>
        </main>

        <footer class="border-t border-slate-200 bg-slate-50 py-8 dark:border-slate-800 dark:bg-slate-900">
            <div class="mx-auto max-w-7xl px-6 text-center text-sm text-slate-500">
                © {{ new Date().getFullYear() }} FreelanceFlow.
            </div>
        </footer>

    </div>
</template>