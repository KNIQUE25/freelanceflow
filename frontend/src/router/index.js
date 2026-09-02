import { createRouter, createWebHistory } from "vue-router";
import { useAuthStore } from "../stores/auth";

// Public pages
import Home from "../views/Home.vue";
import About from "../views/About.vue";
import Contact from "../views/Contact.vue";
import FAQ from "../views/FAQ.vue";
import Features from "../views/Features.vue";
import HowItWorks from "../views/HowItWorks.vue";
import Pricing from "../views/Pricing.vue";
import Terms from "../views/Terms.vue";
import PrivacyPolicy from "../views/PrivacyPolicy.vue";

// Auth pages
import GuestLayout from "../layouts/GuestLayout.vue";
const Login = () => import("../views/Auth/Login.vue");
const Register = () => import("../views/Auth/Register.vue");
const ForgotPassword = () => import("../views/Auth/ForgotPassword.vue");
const ResetPassword = () => import("../views/Auth/ResetPassword.vue");
const EmailVerificationSuccess = () =>
  import("../views/Auth/EmailVerificationSuccess.vue");

// Authenticated pages
import MainLayout from "../layouts/MainLayout.vue";
const Dashboard = () => import("../views/Dashboard.vue");
const ClientsList = () => import("../views/Clients/ClientsList.vue");
const ClientForm = () => import("../views/Clients/ClientForm.vue");
const ClientShow = () => import("../views/Clients/ClientShow.vue");
const InvoicesList = () => import("../views/Invoices/InvoicesList.vue");
const InvoiceForm = () => import("../views/Invoices/InvoiceForm.vue");
const InvoiceShow = () => import("../views/Invoices/InvoiceShow.vue");
const PublicInvoice = () => import("../views/PublicInvoice.vue");
const PaymentsList = () => import("../views/Payments/PaymentsList.vue");
const PaymentForm = () => import("../views/Payments/PaymentForm.vue");
const Profile = () => import("../views/Profile.vue");
const BusinessProfile = () => import("../views/BusinessProfile.vue");
const Notifications = () => import("../views/Notifications.vue");
const Reports = () => import("../views/Reports.vue");
const VerifyEmail = () => import("../views/VerifyEmail.vue");

const routes = [
  // Home – standalone
  {
    path: "/",
    name: "home",
    component: Home,
    meta: { guest: true, public: true },
  },

  // Public information pages
  {
    path: "/about",
    name: "about",
    component: About,
    meta: { guest: true, public: true },
  },
  {
    path: "/contact",
    name: "contact",
    component: Contact,
    meta: { guest: true, public: true },
  },
  {
    path: "/faq",
    name: "faq",
    component: FAQ,
    meta: { guest: true, public: true },
  },
  {
    path: "/features",
    name: "features",
    component: Features,
    meta: { guest: true, public: true },
  },
  {
    path: "/how-it-works",
    name: "how-it-works",
    component: HowItWorks,
    meta: { guest: true, public: true },
  },
  {
    path: "/pricing",
    name: "pricing",
    component: Pricing,
    meta: { guest: true, public: true },
  },
  {
    path: "/terms",
    name: "terms",
    component: Terms,
    meta: { guest: true, public: true },
  },
  {
    path: "/privacy",
    name: "privacy",
    component: PrivacyPolicy,
    meta: { guest: true, public: true },
  },

  // Auth (GuestLayout)
  {
    path: "/",
    component: GuestLayout,
    children: [
      { path: "login", name: "login", component: Login, meta: { guest: true } },
      {
        path: "register",
        name: "register",
        component: Register,
        meta: { guest: true },
      },
      {
        path: "forgot-password",
        name: "forgot-password",
        component: ForgotPassword,
        meta: { guest: true },
      },
      {
        path: "reset-password/:token?",
        name: "reset-password",
        component: ResetPassword,
        meta: { guest: true },
      },
      {
        path: "email/verification-success",
        name: "email-verification-success",
        component: EmailVerificationSuccess,
        meta: { guest: true },
      },
      {
        path: "/public/invoice/:uuid",
        name: "public-invoice",
        component: PublicInvoice,
        meta: { guest: true },
      },
    ],
  },

  // Authenticated (MainLayout)
  {
    path: "/",
    component: MainLayout,
    meta: { requiresAuth: true },
    children: [
      { path: "", redirect: "/dashboard" },
      { path: "dashboard", name: "dashboard", component: Dashboard },
      {
        path: "email/verify",
        name: "email-verify",
        component: VerifyEmail,
        meta: { ignoreVerification: true },
      },
      { path: "clients", name: "clients", component: ClientsList },
      { path: "clients/create", name: "client-create", component: ClientForm },
      { path: "clients/:id", name: "client-show", component: ClientShow },
      { path: "clients/:id/edit", name: "client-edit", component: ClientForm },
      { path: "invoices", name: "invoices", component: InvoicesList },
      {
        path: "invoices/create",
        name: "invoice-create",
        component: InvoiceForm,
      },
      { path: "invoices/:id", name: "invoice-show", component: InvoiceShow },
      {
        path: "invoices/:id/edit",
        name: "invoice-edit",
        component: InvoiceForm,
      },
      { path: "payments", name: "payments", component: PaymentsList },
      {
        path: "payments/create",
        name: "payment-create",
        component: PaymentForm,
      },
      { path: "profile", name: "profile", component: Profile },
      {
        path: "settings",
        name: "business-profile",
        component: BusinessProfile,
      },
      {
        path: "notifications",
        name: "notifications",
        component: Notifications,
      },
      { path: "reports", name: "reports", component: Reports },
    ],
  },

  // 404
  { path: "/:pathMatch(.*)*", redirect: "/" },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
  scrollBehavior(to, from, savedPosition) {
    if (savedPosition) return savedPosition;
    if (to.hash) return { el: to.hash, behavior: "smooth" };
    return { top: 0, behavior: "smooth" };
  },
});

router.beforeEach(async (to) => {
  const authStore = useAuthStore();
  if (!authStore.initialized) await authStore.fetchUser();
  if (to.meta.requiresAuth && !authStore.isAuthenticated)
    return { name: "login", query: { redirect: to.fullPath } };
  if (
    to.meta.guest &&
    authStore.isAuthenticated &&
    !to.meta.public &&
    ["login", "register", "forgot-password", "reset-password"].includes(to.name)
  )
    return { name: "dashboard" };
  return true;
});

export default router;
