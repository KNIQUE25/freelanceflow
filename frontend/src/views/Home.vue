<template>
  <div class="home-page min-h-screen overflow-x-hidden bg-[#f8f9ff] text-slate-900 transition-colors duration-300 dark:bg-slate-950 dark:text-slate-100">
    <!-- =====================================================
         NAVIGATION
    ====================================================== -->
    <header class="absolute inset-x-0 top-0 z-50 px-3 pt-3 sm:px-5 sm:pt-5 lg:px-8 lg:pt-7">
      <div class="mx-auto flex max-w-[1440px] items-center justify-between rounded-[1.5rem] border border-white/70 bg-white/90 px-4 py-3 shadow-[0_18px_55px_rgba(15,23,42,0.12)] backdrop-blur-xl transition-colors duration-300 dark:border-slate-800/70 dark:bg-slate-900/90 sm:px-6 lg:rounded-full lg:px-7 lg:py-3.5">
        <!-- Logo -->
        <router-link to="/" class="flex shrink-0 items-center gap-2.5" aria-label="FreelanceFlow home">
          <img
            src="/ff-logo.png"
            alt="FreelanceFlow"
            class="h-9 w-9 rounded-xl object-contain sm:h-10 sm:w-10"
            @error="hideLogo"
          />
          <span class="text-lg font-extrabold tracking-tight sm:text-xl">
            Freelance<span class="text-primary-600 dark:text-primary-400">Flow</span>
          </span>
        </router-link>

        <!-- Desktop nav -->
        <nav class="hidden items-center gap-7 text-sm font-semibold text-slate-600 dark:text-slate-300 lg:flex">
          <a href="#home" class="nav-link text-primary-600 dark:text-primary-400">Home</a>
          <a href="#features" class="nav-link">Features</a>
          <a href="#pricing" class="nav-link">Pricing</a>
          <a href="#how-it-works" class="nav-link">How It Works</a>
          <a href="#faq" class="nav-link">FAQ</a>
          <a href="#contact" class="nav-link">Contact</a>
        </nav>

        <!-- Desktop actions -->
        <div class="hidden items-center gap-2.5 lg:flex">
          <button
            type="button"
            class="grid h-10 w-10 place-items-center rounded-full bg-slate-50 text-slate-600 transition hover:bg-primary-50 hover:text-primary-600 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700"
            aria-label="Toggle dark mode"
            :aria-pressed="isDark"
            @click="toggleTheme"
          >
            <svg v-if="!isDark" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
              <path d="M12 3v2m0 14v2M4.93 4.93l1.42 1.42m11.3 11.3 1.42 1.42M3 12h2m14 0h2M4.93 19.07l1.42-1.42m11.3-11.3 1.42-1.42" />
              <circle cx="12" cy="12" r="4" />
            </svg>
            <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
              <path d="M21 12.79A9 9 0 0 1 11.21 3 7 7 0 1 0 21 12.79Z" />
            </svg>
          </button>
          <router-link to="/login" class="rounded-full px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 dark:text-slate-200 dark:hover:bg-slate-800">
            Login
          </router-link>
          <router-link to="/register" class="inline-flex items-center gap-2 rounded-full bg-primary-600 px-5 py-2.5 text-sm font-bold text-white shadow-lg shadow-primary-600/20 transition hover:-translate-y-0.5 hover:bg-primary-700">
            Get Started
            <span aria-hidden="true">→</span>
          </router-link>
        </div>

        <!-- Mobile menu trigger -->
        <button
          type="button"
          class="grid h-10 w-10 place-items-center rounded-full bg-slate-50 text-slate-700 dark:bg-slate-800 dark:text-slate-200 lg:hidden"
          :aria-expanded="mobileMenuOpen"
          aria-label="Open navigation"
          @click="mobileMenuOpen = !mobileMenuOpen"
        >
          <svg v-if="!mobileMenuOpen" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M4 6h16M4 12h16M4 18h16" />
          </svg>
          <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="m6 6 12 12M18 6 6 18" />
          </svg>
        </button>
      </div>

      <!-- Mobile menu -->
      <div v-if="mobileMenuOpen" class="mx-auto mt-2 max-w-[1440px] rounded-3xl border border-white/80 bg-white p-3 shadow-xl transition-colors duration-300 dark:border-slate-800 dark:bg-slate-900 lg:hidden">
        <nav class="flex flex-col gap-1 text-sm font-semibold text-slate-700 dark:text-slate-200">
          <a v-for="item in navItems" :key="item.href" :href="item.href" class="rounded-2xl px-4 py-3 hover:bg-primary-50 hover:text-primary-600 dark:hover:bg-slate-800 dark:hover:text-primary-400" @click="mobileMenuOpen = false">
            {{ item.label }}
          </a>
        </nav>
        <div class="mt-2 grid grid-cols-2 gap-2 border-t border-slate-100 pt-3 dark:border-slate-800">
          <router-link to="/login" class="rounded-2xl bg-slate-50 px-4 py-3 text-center text-sm font-semibold dark:bg-slate-800 dark:text-slate-100" @click="mobileMenuOpen = false">Login</router-link>
          <router-link to="/register" class="rounded-2xl bg-primary-600 px-4 py-3 text-center text-sm font-bold text-white" @click="mobileMenuOpen = false">Get Started</router-link>
        </div>
      </div>
    </header>

    <!-- =====================================================
         HERO
    ====================================================== -->
    <main id="home">
      <section class="relative px-3 pt-28 sm:px-5 sm:pt-32 lg:px-8 lg:pt-36">
        <div class="relative mx-auto min-h-[690px] max-w-[1440px] overflow-hidden rounded-[2rem] bg-slate-950 shadow-[0_30px_90px_rgba(15,23,42,0.24)] sm:min-h-[720px] sm:rounded-[2.5rem] lg:min-h-[700px]">
          <div class="absolute inset-0 bg-[radial-gradient(circle_at_72%_30%,rgba(16,185,129,0.45),transparent_34%),linear-gradient(115deg,#080b18_8%,#12162a_48%,#1d3130_100%)]"></div>
          <div class="absolute -right-24 top-20 h-80 w-80 rounded-full bg-primary-500/20 blur-3xl"></div>
          <div class="absolute -left-24 bottom-0 h-72 w-72 rounded-full bg-emerald-500/20 blur-3xl"></div>

          <!-- Workspace illustration -->
          <div class="absolute right-[-8%] top-[23%] hidden w-[57%] max-w-3xl rotate-[2deg] lg:block">
            <div class="rounded-[1.5rem] border-[10px] border-slate-800 bg-slate-900 p-2 shadow-2xl shadow-black/40">
              <div class="overflow-hidden rounded-xl bg-white dark:bg-slate-800">
                <div class="flex items-center justify-between border-b border-slate-100 px-5 py-3 dark:border-slate-700">
                  <div class="flex items-center gap-2">
                    <span class="h-7 w-7 rounded-lg bg-primary-600"></span>
                    <span class="text-xs font-bold text-slate-800 dark:text-white">Invoices</span>
                  </div>
                  <span class="h-7 w-24 rounded-full bg-primary-50 dark:bg-slate-700"></span>
                </div>
                <div class="grid grid-cols-4 gap-3 p-4">
                  <div v-for="stat in dashboardStats" :key="stat.label" class="rounded-xl bg-slate-50 p-3 dark:bg-slate-700/50">
                    <div class="mb-2 h-2 w-12 rounded-full bg-slate-200 dark:bg-slate-600"></div>
                    <div class="text-lg font-extrabold text-slate-800 dark:text-white">{{ stat.value }}</div>
                    <div class="mt-1 text-[9px] text-slate-400 dark:text-slate-400">{{ stat.label }}</div>
                  </div>
                </div>
                <div class="mx-4 mb-4 overflow-hidden rounded-xl border border-slate-100 dark:border-slate-700">
                  <div class="grid grid-cols-4 bg-slate-50 px-3 py-2 text-[9px] font-bold text-slate-400 dark:bg-slate-800 dark:text-slate-500">
                    <span>Invoice</span><span>Client</span><span>Amount</span><span>Status</span>
                  </div>
                  <div v-for="row in invoiceRows" :key="row.id" class="grid grid-cols-4 items-center border-t border-slate-100 px-3 py-3 text-[9px] dark:border-slate-700">
                    <span class="font-semibold text-slate-700 dark:text-white">{{ row.id }}</span>
                    <span class="text-slate-500 dark:text-slate-400">{{ row.client }}</span>
                    <span class="font-semibold text-slate-700 dark:text-white">{{ row.amount }}</span>
                    <span :class="statusClass(row.status)" class="w-fit rounded-full px-2 py-1 font-bold">{{ row.status }}</span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="relative z-10 flex min-h-[690px] items-center px-6 py-16 sm:px-10 lg:min-h-[700px] lg:w-[58%] lg:px-12 xl:px-16">
            <div class="max-w-xl">
              <div class="mb-5 inline-flex items-center gap-2 rounded-full border border-primary-300/30 bg-primary-500/20 px-4 py-2 text-xs font-bold text-primary-100 backdrop-blur-sm">
                <span class="h-2 w-2 animate-pulse rounded-full bg-primary-300 motion-reduce:animate-none"></span>
                Built for freelancers
              </div>

              <!-- ✅ HERO HEADING – WHITE IN BOTH MODES -->
              <h1 class="text-4xl font-black leading-[1.03] tracking-tight text-white sm:text-5xl lg:text-6xl xl:text-7xl">
                Manage Your Freelance Business
                <span class="block bg-gradient-to-r from-primary-300 via-emerald-200 to-primary-400 bg-clip-text text-transparent">With Ease</span>
              </h1>

              <p class="mt-6 max-w-xl text-base leading-7 text-slate-300 sm:text-lg sm:leading-8">
                Create professional invoices, manage clients, track payments and get paid faster with M-Pesa — all in one simple platform.
              </p>

              <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                <router-link to="/register" class="inline-flex items-center justify-center gap-2 rounded-full bg-primary-600 px-7 py-3.5 text-sm font-bold text-white shadow-xl shadow-primary-950/30 transition hover:-translate-y-0.5 hover:bg-primary-500 sm:text-base">
                  Get Started Free <span aria-hidden="true">→</span>
                </router-link>
                <a href="#features" class="inline-flex items-center justify-center gap-2 rounded-full border border-white/25 bg-white/5 px-7 py-3.5 text-sm font-semibold text-white backdrop-blur-sm transition hover:bg-white/10 sm:text-base">
                  <span class="grid h-6 w-6 place-items-center rounded-full border border-white/40">▶</span>
                  Explore Features
                </a>
              </div>
            </div>
          </div>
        </div>

        <!-- Floating quick links -->
        <div class="relative z-20 mx-auto -mt-8 max-w-6xl px-2 sm:-mt-10">
          <div class="grid overflow-hidden rounded-[1.7rem] border border-white bg-white/95 shadow-[0_20px_60px_rgba(15,23,42,0.14)] backdrop-blur-xl transition-colors duration-300 dark:border-slate-800 dark:bg-slate-900/95 sm:grid-cols-2 lg:grid-cols-5">
            <a v-for="item in quickLinks" :key="item.title" :href="item.href" class="group flex items-center gap-3 border-b border-slate-100 px-5 py-4 transition last:border-b-0 hover:bg-primary-50/60 dark:border-slate-800 dark:hover:bg-slate-800/60 sm:px-6 sm:[&:nth-child(3)]:border-b-0 lg:border-b-0 lg:border-r last:border-r-0">
              <span class="grid h-11 w-11 shrink-0 place-items-center rounded-2xl bg-primary-50 text-primary-600 transition group-hover:scale-105 group-hover:bg-primary-100 dark:bg-slate-800 dark:text-primary-400 dark:group-hover:bg-slate-700">
                <svg v-if="item.icon === 'users'" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                <svg v-else-if="item.icon === 'file'" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6M8 13h8M8 17h6"/></svg>
                <svg v-else-if="item.icon === 'card'" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20M6 15h4"/></svg>
                <svg v-else-if="item.icon === 'chart'" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 19V5M4 19h16"/><path d="m7 15 3-4 3 2 5-7"/></svg>
              </span>
              <span class="min-w-0">
                <strong class="block text-sm font-bold text-slate-800 dark:text-slate-100">{{ item.title }}</strong>
                <small class="block truncate text-xs text-slate-500 dark:text-slate-400">{{ item.description }}</small>
              </span>
            </a>
            <router-link to="/register" class="hidden items-center justify-center gap-2 bg-primary-600 px-5 text-sm font-bold text-white transition hover:bg-primary-700 lg:flex">
              Get Started <span>→</span>
            </router-link>
          </div>
        </div>
      </section>

      <!-- =====================================================
           ABOUT / HOW IT WORKS
      ====================================================== -->
      <section id="how-it-works" class="scroll-mt-24 px-4 py-20 sm:px-6 lg:px-8 lg:py-28">
        <div class="mx-auto grid max-w-[1440px] items-center gap-12 lg:grid-cols-2 lg:gap-16">
          <div class="relative mx-auto w-full max-w-xl">
            <div class="overflow-hidden rounded-[2rem] border border-white bg-gradient-to-br from-primary-100 to-emerald-100 p-5 shadow-xl dark:border-slate-800 dark:from-primary-900/30 dark:to-emerald-900/20">
              <div class="rounded-[1.5rem] bg-white p-4 shadow-lg dark:bg-slate-800">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4 dark:border-slate-700">
                  <div>
                    <p class="text-[10px] font-semibold uppercase tracking-wider text-primary-500 dark:text-primary-400">Business overview</p>
                    <h3 class="mt-1 text-lg font-extrabold dark:text-white">This month</h3>
                  </div>
                  <span class="rounded-full bg-emerald-50 px-3 py-1 text-[10px] font-bold text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-400">+18.4%</span>
                </div>
                <div class="mt-5 grid grid-cols-2 gap-3 sm:grid-cols-3">
                  <div v-for="stat in miniStats" :key="stat.label" class="rounded-2xl bg-slate-50 p-4 dark:bg-slate-700/50">
                    <div class="text-xl font-black text-slate-900 dark:text-white">{{ stat.value }}</div>
                    <div class="mt-1 text-[10px] font-medium text-slate-400 dark:text-slate-400">{{ stat.label }}</div>
                  </div>
                </div>
                <div class="mt-4 rounded-2xl bg-slate-950 p-5 dark:bg-slate-900">
                  <div class="flex items-center justify-between text-white">
                    <span class="text-xs font-semibold">Revenue</span>
                    <span class="text-xs text-slate-400">Last 6 months</span>
                  </div>
                  <div class="mt-6 flex h-28 items-end gap-2">
                    <span v-for="bar in bars" :key="bar" class="flex-1 rounded-t-lg bg-gradient-to-t from-primary-700 to-primary-300" :style="{ height: `${bar}%` }"></span>
                  </div>
                </div>
              </div>
            </div>
            <div class="absolute -bottom-5 right-2 rounded-2xl border border-white bg-white p-3 shadow-xl dark:border-slate-800 dark:bg-slate-900 sm:-right-5">
              <div class="flex items-center gap-3">
                <span class="grid h-10 w-10 place-items-center rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-400">✓</span>
                <div><strong class="block text-xs dark:text-slate-100">Secure & Reliable</strong><span class="text-[10px] text-slate-400 dark:text-slate-500">Built for your workflow</span></div>
              </div>
            </div>
          </div>

          <div>
            <p class="text-xs font-extrabold uppercase tracking-[0.2em] text-primary-600 dark:text-primary-400">About FreelanceFlow</p>
            <h2 class="mt-3 text-3xl font-black tracking-tight text-slate-900 dark:text-slate-50 sm:text-4xl lg:text-5xl">The simplest way to run your freelance business</h2>
            <p class="mt-5 text-base leading-7 text-slate-600 dark:text-slate-300 sm:text-lg sm:leading-8">FreelanceFlow helps you save time, get paid faster and focus on what you do best. No more messy spreadsheets or chasing payments.</p>

            <ul class="mt-7 space-y-4">
              <li v-for="point in aboutPoints" :key="point" class="flex items-start gap-3">
                <span class="mt-0.5 grid h-6 w-6 shrink-0 place-items-center rounded-full bg-primary-50 text-xs font-black text-primary-600 dark:bg-slate-800 dark:text-primary-400">✓</span>
                <span class="text-sm font-semibold text-slate-700 dark:text-slate-200 sm:text-base">{{ point }}</span>
              </li>
            </ul>

            <router-link to="/register" class="mt-8 inline-flex items-center gap-2 rounded-full bg-primary-600 px-6 py-3.5 text-sm font-bold text-white shadow-lg shadow-primary-600/20 transition hover:-translate-y-0.5 hover:bg-primary-700">Start for free <span>→</span></router-link>
          </div>
        </div>
      </section>

      <!-- =====================================================
           FEATURES
      ====================================================== -->
      <section id="features" class="scroll-mt-24 bg-white px-4 py-20 transition-colors duration-300 dark:bg-slate-900 sm:px-6 lg:px-8 lg:py-28">
        <div class="mx-auto max-w-[1440px]">
          <div class="mx-auto max-w-2xl text-center">
            <p class="text-xs font-extrabold uppercase tracking-[0.2em] text-primary-600 dark:text-primary-400">Features</p>
            <h2 class="mt-3 text-3xl font-black tracking-tight text-slate-900 dark:text-slate-50 sm:text-4xl">Everything you need to grow your business</h2>
            <p class="mt-4 text-base leading-7 text-slate-600 dark:text-slate-300">Powerful tools without the complicated setup. FreelanceFlow keeps your everyday finances organized.</p>
          </div>

          <div class="mt-12 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            <article v-for="feature in features" :key="feature.title" class="group overflow-hidden rounded-[1.75rem] border border-slate-100 bg-white shadow-[0_12px_35px_rgba(15,23,42,0.07)] transition duration-300 hover:-translate-y-1 hover:shadow-[0_20px_50px_rgba(16,185,129,0.12)] dark:border-slate-800 dark:bg-slate-800/60">
              <div class="relative h-48 overflow-hidden bg-gradient-to-br from-primary-50 via-white to-emerald-100 dark:from-slate-800 dark:via-slate-800 dark:to-slate-700">
                <div class="absolute inset-0 opacity-60 dark:opacity-30" :class="feature.bg"></div>
                <div class="absolute left-7 top-7 grid h-12 w-12 place-items-center rounded-2xl bg-primary-600 text-white shadow-lg shadow-primary-600/20">
                  <svg v-if="feature.icon === 'users'" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                  <svg v-else-if="feature.icon === 'invoice'" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6M8 13h8M8 17h5"/></svg>
                  <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20M6 15h4"/></svg>
                </div>
                <div v-if="feature.icon === 'users'" class="absolute bottom-7 right-8 h-24 w-32 rounded-2xl border-4 border-white bg-gradient-to-br from-amber-100 to-orange-200 shadow-xl"></div>
                <div v-else-if="feature.icon === 'invoice'" class="absolute bottom-5 right-7 h-28 w-40 rounded-xl border border-slate-200 bg-white p-3 shadow-xl rotate-2 dark:border-slate-700 dark:bg-slate-800">
                  <div class="h-2 w-20 rounded-full bg-primary-100"></div><div class="mt-3 h-2 w-full rounded-full bg-slate-100"></div><div class="mt-2 h-2 w-4/5 rounded-full bg-slate-100"></div><div class="mt-5 flex gap-2"><span class="h-8 flex-1 rounded-lg bg-primary-50"></span><span class="h-8 w-10 rounded-lg bg-emerald-50"></span></div>
                </div>
                <div v-else class="absolute bottom-5 right-10 h-32 w-20 rounded-[1.2rem] border-4 border-slate-800 bg-white shadow-xl dark:border-slate-600 dark:bg-slate-700">
                  <div class="m-2 rounded-lg bg-emerald-50 p-2 text-center dark:bg-emerald-900/30"><div class="text-[7px] font-bold text-emerald-700 dark:text-emerald-400">M-PESA</div><div class="mt-4 text-[9px] font-black text-slate-800 dark:text-white">KSh 25,000</div><div class="mt-4 rounded bg-emerald-500 py-1 text-[6px] font-bold text-white">Pay Now</div></div>
                </div>
              </div>
              <div class="p-6">
                <h3 class="text-lg font-extrabold text-slate-900 dark:text-slate-50">{{ feature.title }}</h3>
                <p class="mt-2 min-h-[72px] text-sm leading-6 text-slate-600 dark:text-slate-300">{{ feature.description }}</p>
                <a :href="feature.href" class="mt-4 inline-flex items-center gap-1 text-sm font-bold text-primary-600 dark:text-primary-400 transition group-hover:gap-2">Learn more <span>→</span></a>
              </div>
            </article>
          </div>
        </div>
      </section>

      <!-- =====================================================
           FAQ SECTION
      ====================================================== -->
      <section id="faq" class="bg-white px-4 py-16 transition-colors duration-300 dark:bg-slate-950 sm:px-6 sm:py-20 lg:px-8 lg:py-24">
        <div class="mx-auto max-w-3xl">
          <div class="mx-auto mb-12 max-w-2xl text-center">
            <p class="text-sm font-bold uppercase tracking-wider text-primary-600 dark:text-primary-400">FAQ</p>
            <h2 class="mt-3 text-3xl font-black text-slate-900 dark:text-white sm:text-4xl">Frequently Asked Questions</h2>
            <p class="mt-4 text-slate-600 dark:text-slate-400">Quick answers to the questions freelancers ask most.</p>
          </div>

          <div class="space-y-4">
            <details v-for="(item, idx) in homeFaqs" :key="idx" class="group rounded-2xl border border-slate-200 p-6 dark:border-slate-800">
              <summary class="flex cursor-pointer list-none items-center justify-between gap-4 font-bold text-slate-900 dark:text-white">
                <span>{{ item.question }}</span>
                <span class="text-2xl text-primary-600 transition group-open:rotate-45">+</span>
              </summary>
              <p class="mt-4 leading-7 text-slate-600 dark:text-slate-400">{{ item.answer }}</p>
            </details>
          </div>

          <div class="mt-8 text-center">
            <router-link to="/faq" class="font-bold text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300">View all frequently asked questions →</router-link>
          </div>
        </div>
      </section>

      <!-- =====================================================
           PRICING / CTA
      ====================================================== -->
      <section id="pricing" class="scroll-mt-24 px-4 py-16 sm:px-6 lg:px-8 lg:py-20">
        <div class="relative mx-auto max-w-[1440px] overflow-hidden rounded-[2rem] bg-gradient-to-br from-primary-50 via-emerald-50 to-primary-100/30 px-6 py-12 transition-colors duration-300 dark:from-slate-800 dark:via-slate-900 dark:to-primary-900/20 sm:px-10 lg:px-14 lg:py-14">
          <div class="absolute -right-16 -top-20 h-56 w-56 rounded-full bg-primary-200/40 blur-3xl dark:bg-primary-800/20"></div>
          <div class="relative grid items-center gap-10 lg:grid-cols-2">
            <div>
              <p class="text-xs font-extrabold uppercase tracking-[0.2em] text-primary-600 dark:text-primary-400">Simple. Professional. Fast.</p>
              <h2 class="mt-3 text-3xl font-black tracking-tight text-slate-900 dark:text-slate-50 sm:text-4xl">Ready to simplify your freelance business?</h2>
              <p class="mt-4 max-w-xl text-base leading-7 text-slate-600 dark:text-slate-300">Join freelancers who use FreelanceFlow to manage their clients, invoices and payments with less effort.</p>
              <div class="mt-7 flex flex-col gap-3 sm:flex-row">
                <router-link to="/register" class="inline-flex items-center justify-center gap-2 rounded-full bg-primary-600 px-6 py-3.5 text-sm font-bold text-white shadow-lg shadow-primary-600/20 hover:bg-primary-700">Get Started Free <span>→</span></router-link>
                <a href="#features" class="inline-flex items-center justify-center gap-2 rounded-full bg-white px-6 py-3.5 text-sm font-bold text-slate-700 shadow-sm hover:bg-slate-50 dark:bg-slate-800 dark:text-slate-100 dark:hover:bg-slate-700">View Features <span>→</span></a>
              </div>
            </div>
            <div class="hidden justify-end lg:flex">
              <div class="relative w-full max-w-md">
                <div class="rounded-3xl border border-white bg-white/90 p-4 shadow-2xl dark:bg-slate-900/90">
                  <div class="flex items-center justify-between"><span class="h-3 w-28 rounded-full bg-slate-100 dark:bg-slate-700"></span><span class="h-8 w-8 rounded-full bg-primary-50"></span></div>
                  <div class="mt-5 grid grid-cols-3 gap-3"><span v-for="n in 3" :key="n" class="h-20 rounded-2xl bg-slate-50 dark:bg-slate-800"></span></div>
                  <div class="mt-4 h-28 rounded-2xl bg-gradient-to-br from-primary-600 to-emerald-500 p-5"><div class="h-2 w-20 rounded bg-white/30"></div><div class="mt-6 h-3 w-32 rounded bg-white/80"></div></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>

    <!-- =====================================================
         FOOTER
    ====================================================== -->
    <footer id="contact" class="border-t border-slate-200 bg-white px-4 py-12 transition-colors duration-300 dark:border-slate-800 dark:bg-slate-950 sm:px-6 lg:px-8">
      <div class="mx-auto grid max-w-[1440px] gap-10 lg:grid-cols-5">
        <div class="lg:col-span-2">
          <router-link to="/" class="flex items-center gap-2.5">
            <img src="/ff-logo.png" alt="FreelanceFlow" class="h-9 w-9 rounded-xl object-contain" @error="hideLogo" />
            <span class="text-lg font-extrabold dark:text-white">Freelance<span class="text-primary-600 dark:text-primary-400">Flow</span></span>
          </router-link>
          <p class="mt-4 max-w-sm text-sm leading-6 text-slate-500 dark:text-slate-400">Invoicing made simple for freelancers. Manage your business, get paid and spend more time doing great work.</p>
          <div class="mt-5 flex gap-2">
            <a v-for="social in socials" :key="social" href="#contact" class="grid h-9 w-9 place-items-center rounded-full bg-slate-50 text-xs font-bold text-slate-500 hover:bg-primary-50 hover:text-primary-600 dark:bg-slate-800 dark:text-slate-400 dark:hover:bg-slate-700 dark:hover:text-primary-400">{{ social }}</a>
          </div>
        </div>

        <div class="grid grid-cols-2 gap-8 sm:grid-cols-3 lg:col-span-3 lg:grid-cols-subgrid">
          <div v-for="column in footerColumns" :key="column.title">
            <h3 class="text-sm font-bold text-slate-900 dark:text-slate-100">{{ column.title }}</h3>
            <ul class="mt-4 space-y-3 text-sm text-slate-500 dark:text-slate-400">
              <li v-for="link in column.links" :key="link.to">
                <router-link :to="link.to" class="transition hover:text-primary-600 dark:hover:text-primary-400">{{ link.label }}</router-link>
              </li>
            </ul>
          </div>
        </div>
      </div>

      <div class="mx-auto mt-10 flex max-w-[1440px] flex-col justify-between gap-3 border-t border-slate-100 pt-6 text-xs text-slate-400 dark:border-slate-800 dark:text-slate-500 sm:flex-row">
        <span>© {{ currentYear }} FreelanceFlow. All rights reserved.</span>
        <span>Built for independent professionals.</span>
      </div>
    </footer>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useThemeStore } from '../stores/theme'

// -------- THEME --------
const themeStore = useThemeStore()
const isDark = computed(() => themeStore.isDark)

const toggleTheme = () => {
  const current = themeStore.theme
  if (current === 'system') themeStore.setTheme('light')
  else if (current === 'light') themeStore.setTheme('dark')
  else themeStore.setTheme('system')
}

// -------- OTHER DATA --------
const currentYear = new Date().getFullYear()
const mobileMenuOpen = ref(false)

const navItems = [
  { label: 'Home', href: '#home' },
  { label: 'Features', href: '#features' },
  { label: 'Pricing', href: '#pricing' },
  { label: 'How It Works', href: '#how-it-works' },
  { label: 'FAQ', href: '#faq' },
  { label: 'Contact', href: '#contact' },
]

const quickLinks = [
  { title: 'Clients', description: 'Manage your clients', icon: 'users', href: '#features' },
  { title: 'Invoices', description: 'Create & send invoices', icon: 'file', href: '#features' },
  { title: 'Payments', description: 'Track payments', icon: 'card', href: '#features' },
  { title: 'Dashboard', description: 'Business overview', icon: 'chart', href: '#how-it-works' },
]

const dashboardStats = [
  { value: '24', label: 'Total invoices' },
  { value: '18', label: 'Paid' },
  { value: '5', label: 'Pending' },
  { value: '1', label: 'Overdue' },
]

const invoiceRows = [
  { id: 'INV-2026-001', client: 'Acme Operations', amount: 'KSh 25,000', status: 'Paid' },
  { id: 'INV-2026-002', client: 'Jane Doe', amount: 'KSh 18,500', status: 'Paid' },
  { id: 'INV-2026-003', client: 'Tech Solutions', amount: 'KSh 30,000', status: 'Pending' },
  { id: 'INV-2026-004', client: 'Creative Agency', amount: 'KSh 12,000', status: 'Overdue' },
]

const miniStats = [
  { value: 'KSh 250K', label: 'Revenue' },
  { value: '24', label: 'Invoices' },
  { value: '18', label: 'Paid' },
]

const bars = [38, 52, 45, 67, 74, 92]

const aboutPoints = [
  'Professional invoices in minutes',
  'M-Pesa STK Push payments',
  'Real-time reports and insights',
]

const features = [
  {
    title: 'Client Management',
    icon: 'users',
    bg: 'bg-[radial-gradient(circle_at_70%_30%,rgba(251,191,36,.45),transparent_40%),linear-gradient(135deg,#ecfdf5,#fff7ed)]',
    description: 'Organize all your clients in one place. Track contact details, project history and communication.',
    href: '#how-it-works',
  },
  {
    title: 'Smart Invoices',
    icon: 'invoice',
    bg: 'bg-[radial-gradient(circle_at_65%_40%,rgba(16,185,129,.35),transparent_45%),linear-gradient(135deg,#ecfdf5,#f5f3ff)]',
    description: 'Create professional invoices with automatic numbering, taxes, discounts and PDF downloads.',
    href: '#how-it-works',
  },
  {
    title: 'M-Pesa Payments',
    icon: 'payment',
    bg: 'bg-[radial-gradient(circle_at_65%_40%,rgba(16,185,129,.3),transparent_45%),linear-gradient(135deg,#ecfdf5,#eef2ff)]',
    description: 'Get paid faster with M-Pesa STK Push. Secure, instant and hassle-free for you and your clients.',
    href: '#how-it-works',
  },
]

const footerColumns = [
  {
    title: 'Product',
    links: [
      { label: 'Features', to: '/features' },
      { label: 'Pricing', to: '/pricing' },
      { label: 'How It Works', to: '/how-it-works' },
      { label: 'FAQ', to: '/faq' },
    ],
  },
  {
    title: 'Company',
    links: [
      { label: 'About Us', to: '/about' },
      { label: 'Contact', to: '/contact' },
    ],
  },
  {
    title: 'Legal',
    links: [
      { label: 'Terms of Service', to: '/terms' },
      { label: 'Privacy Policy', to: '/privacy' },
    ],
  },
]

const homeFaqs = [
  { question: 'What is FreelanceFlow?', answer: 'FreelanceFlow helps freelancers manage clients, invoices, payments and business information from one place.' },
  { question: 'Can I create PDF invoices?', answer: 'Yes. You can create professional invoices and download them as PDF documents.' },
  { question: 'Does FreelanceFlow support M-Pesa?', answer: 'Yes. FreelanceFlow is designed to support M-Pesa STK Push payments when the payment integration is configured.' },
  { question: 'Can I track outstanding invoices?', answer: 'Yes. The application tracks invoice status, paid amounts and outstanding balances.' },
]

const socials = ['f', '𝕏', 'in']

const statusClass = (status) => {
  if (status === 'Paid') return 'bg-emerald-50 text-emerald-600 dark:bg-emerald-900/40 dark:text-emerald-400'
  if (status === 'Overdue') return 'bg-red-50 text-red-600 dark:bg-red-900/40 dark:text-red-400'
  return 'bg-amber-50 text-amber-600 dark:bg-amber-900/40 dark:text-amber-400'
}

const hideLogo = (event) => {
  event.target.style.display = 'none'
}
</script>

<style scoped>
.nav-link {
  position: relative;
  transition: color 0.2s ease;
}

.nav-link:hover {
  color: #059669;
}

:global(.dark) .nav-link:hover {
  color: #34d399;
}

a:focus-visible,
button:focus-visible {
  outline: 2px solid #059669;
  outline-offset: 2px;
  border-radius: 4px;
}

@media (prefers-reduced-motion: no-preference) {
  html {
    scroll-behavior: smooth;
  }
}
</style>