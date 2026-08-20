import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from '../stores/auth'

const GuestLayout = () => import('../layouts/GuestLayout.vue')
const MainLayout = () => import('../layouts/MainLayout.vue')
const Home = () => import('../views/Home.vue')
const Login = () => import('../views/Login.vue')
const Register = () => import('../views/Register.vue')
const ForgotPassword = () => import('../views/ForgotPassword.vue')
const ResetPassword = () => import('../views/ResetPassword.vue')
const EmailVerificationSuccess = () => import('../views/EmailVerificationSuccess.vue')
const Dashboard = () => import('../views/Dashboard.vue')
const ClientsList = () => import('../views/Clients/ClientsList.vue')
const ClientForm = () => import('../views/Clients/ClientForm.vue')
const ClientShow = () => import('../views/Clients/ClientShow.vue')
const InvoicesList = () => import('../views/Invoices/InvoicesList.vue')
const InvoiceForm = () => import('../views/Invoices/InvoiceForm.vue')
const InvoiceShow = () => import('../views/Invoices/InvoiceShow.vue')
const PaymentsList = () => import('../views/Payments/PaymentsList.vue')
const PaymentForm = () => import('../views/Payments/PaymentForm.vue')
const Profile = () => import('../views/Profile.vue')
const BusinessProfile = () => import('../views/BusinessProfile.vue')
const Notifications = () => import('../views/Notifications.vue')
const Reports = () => import('../views/Reports.vue')
const VerifyEmail = () => import('../views/VerifyEmail.vue')

const routes = [
  // ✅ Home – standalone, full width
  {
    path: '/',
    name: 'home',
    component: Home,
    meta: { guest: true },
  },

  // ✅ GuestLayout – only for auth forms
  {
    path: '/auth',
    component: GuestLayout,
    children: [
      { path: 'login', name: 'login', component: Login, meta: { guest: true } },
      { path: 'register', name: 'register', component: Register, meta: { guest: true } },
      { path: 'forgot-password', name: 'forgot-password', component: ForgotPassword, meta: { guest: true } },
      { path: 'reset-password/:token?', name: 'reset-password', component: ResetPassword, meta: { guest: true } },
    ],
  },

  // ✅ Email verification success – standalone
  {
    path: '/email/verification-success',
    name: 'email-verification-success',
    component: EmailVerificationSuccess,
    meta: { guest: true },
  },

  // ✅ MainLayout – authenticated routes
  {
    path: '/app',
    component: MainLayout,
    meta: { requiresAuth: true },
    children: [
      { path: '', redirect: '/app/dashboard' },
      { path: 'dashboard', name: 'dashboard', component: Dashboard },
      { path: 'email/verify', name: 'email-verify', component: VerifyEmail, meta: { ignoreVerification: true } },
      { path: 'clients', name: 'clients', component: ClientsList },
      { path: 'clients/create', name: 'client-create', component: ClientForm },
      { path: 'clients/:id/edit', name: 'client-edit', component: ClientForm },
      { path: 'clients/:id', name: 'client-show', component: ClientShow },
      { path: 'invoices', name: 'invoices', component: InvoicesList },
      { path: 'invoices/create', name: 'invoice-create', component: InvoiceForm },
      { path: 'invoices/:id/edit', name: 'invoice-edit', component: InvoiceForm },
      { path: 'invoices/:id', name: 'invoice-show', component: InvoiceShow },
      { path: 'payments', name: 'payments', component: PaymentsList },
      { path: 'payments/create', name: 'payment-create', component: PaymentForm },
      { path: 'profile', name: 'profile', component: Profile },
      { path: 'settings', name: 'business-profile', component: BusinessProfile },
      { path: 'notifications', name: 'notifications', component: Notifications },
      { path: 'reports', name: 'reports', component: Reports },
    ],
  },

  // ✅ Catch-all 404
  { path: '/:pathMatch(.*)*', redirect: '/' },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
  scrollBehavior: () => ({ top: 0 }),
})

router.beforeEach(async (to) => {
  const authStore = useAuthStore()
  await authStore.fetchUser()

  if (to.meta.requiresAuth && !authStore.isAuthenticated) {
    return { name: 'login' }
  }

  if (to.meta.guest && authStore.isAuthenticated) {
    return { name: 'dashboard' }
  }

  if (
    to.meta.requiresAuth &&
    !to.meta.ignoreVerification &&
    authStore.isAuthenticated &&
    !authStore.isEmailVerified
  ) {
    return { name: 'email-verify' }
  }

  return true
})

export default router