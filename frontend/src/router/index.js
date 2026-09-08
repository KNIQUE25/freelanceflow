import { createRouter, createWebHistory } from "vue-router";
import { useAuthStore } from "../stores/auth";

// =========================
// Public pages
// =========================
import Home from "../views/Home.vue";
import About from "../views/About.vue";
import Contact from "../views/Contact.vue";
import FAQ from "../views/FAQ.vue";
import Features from "../views/Features.vue";
import HowItWorks from "../views/HowItWorks.vue";
import Pricing from "../views/Pricing.vue";
import Terms from "../views/Terms.vue";
import PrivacyPolicy from "../views/PrivacyPolicy.vue";

// =========================
// Auth pages
// =========================
import GuestLayout from "../layouts/GuestLayout.vue";

const Login = () => import("../views/Auth/Login.vue");
const Register = () => import("../views/Auth/Register.vue");
const ForgotPassword = () =>
  import("../views/Auth/ForgotPassword.vue");
const ResetPassword = () =>
  import("../views/Auth/ResetPassword.vue");

const EmailVerificationSuccess = () =>
  import("../views/Auth/EmailVerificationSuccess.vue");

// =========================
// Authenticated pages
// =========================
import MainLayout from "../layouts/MainLayout.vue";

const Dashboard = () => import("../views/Dashboard.vue");
const ClientsList = () => import("../views/Clients/ClientsList.vue");
const ClientForm = () => import("../views/Clients/ClientForm.vue");
const ClientShow = () => import("../views/Clients/ClientShow.vue");

const InvoicesList = () =>
  import("../views/Invoices/InvoicesList.vue");
const InvoiceForm = () =>
  import("../views/Invoices/InvoiceForm.vue");
const InvoiceShow = () =>
  import("../views/Invoices/InvoiceShow.vue");

const PaymentsList = () =>
  import("../views/Payments/PaymentsList.vue");
const PaymentForm = () =>
  import("../views/Payments/PaymentForm.vue");

const Profile = () => import("../views/Profile.vue");
const BusinessProfile = () =>
  import("../views/BusinessProfile.vue");
const Notifications = () =>
  import("../views/Notifications.vue");
const Reports = () => import("../views/Reports.vue");
const VerifyEmail = () => import("../views/VerifyEmail.vue");

// Public invoice
const PublicInvoice = () =>
  import("../views/PublicInvoice.vue");

// =========================
// Admin pages
// =========================
import AdminLayout from "../layouts/AdminLayout.vue";

const AdminDashboard = () =>
  import("../views/admin/AdminDashboard.vue");

const AdminUsers = () =>
  import("../views/admin/AdminUsers.vue");

const AdminInvoices = () =>
  import("../views/admin/AdminInvoices.vue");

const AdminPayments = () =>
  import("../views/admin/AdminPayments.vue");

const AdminAuditLogs = () =>
  import("../views/admin/AdminAuditLogs.vue");

const AdminErrors = () =>
  import("../views/admin/AdminErrors.vue");

// =========================
// Routes
// =========================
const routes = [
  // =========================
  // HOME
  // =========================
  {
    path: "/",
    name: "home",
    component: Home,
    meta: {
      public: true,
    },
  },

  // =========================
  // PUBLIC INFORMATION PAGES
  // =========================
  {
    path: "/about",
    name: "about",
    component: About,
    meta: {
      public: true,
    },
  },

  {
    path: "/contact",
    name: "contact",
    component: Contact,
    meta: {
      public: true,
    },
  },

  {
    path: "/faq",
    name: "faq",
    component: FAQ,
    meta: {
      public: true,
    },
  },

  {
    path: "/features",
    name: "features",
    component: Features,
    meta: {
      public: true,
    },
  },

  {
    path: "/how-it-works",
    name: "how-it-works",
    component: HowItWorks,
    meta: {
      public: true,
    },
  },

  {
    path: "/pricing",
    name: "pricing",
    component: Pricing,
    meta: {
      public: true,
    },
  },

  {
    path: "/terms",
    name: "terms",
    component: Terms,
    meta: {
      public: true,
    },
  },

  {
    path: "/privacy",
    name: "privacy",
    component: PrivacyPolicy,
    meta: {
      public: true,
    },
  },

  // =========================
  // GUEST / AUTH ROUTES
  // =========================
  {
    path: "/",
    component: GuestLayout,

    children: [
      {
        path: "login",
        name: "login",
        component: Login,
        meta: {
          guest: true,
        },
      },

      {
        path: "register",
        name: "register",
        component: Register,
        meta: {
          guest: true,
        },
      },

      {
        path: "forgot-password",
        name: "forgot-password",
        component: ForgotPassword,
        meta: {
          guest: true,
        },
      },

      {
        path: "reset-password/:token?",
        name: "reset-password",
        component: ResetPassword,
        meta: {
          guest: true,
        },
      },

      {
        path: "email/verification-success",
        name: "email-verification-success",
        component: EmailVerificationSuccess,
        meta: {
          guest: true,
        },
      },
    ],
  },

  // =========================
  // PUBLIC INVOICE
  // =========================
  {
    path: "/public/invoice/:uuid",
    name: "public-invoice",
    component: PublicInvoice,
    meta: {
      public: true,
    },
  },

  // =========================
  // AUTHENTICATED USER ROUTES
  // =========================
  {
    path: "/",
    component: MainLayout,

    meta: {
      requiresAuth: true,
    },

    children: [
      {
        path: "",
        redirect: "/dashboard",
      },

      {
        path: "dashboard",
        name: "dashboard",
        component: Dashboard,
      },

      {
        path: "email/verify",
        name: "email-verify",
        component: VerifyEmail,

        meta: {
          ignoreVerification: true,
        },
      },

      // Clients
      {
        path: "clients",
        name: "clients",
        component: ClientsList,
      },

      {
        path: "clients/create",
        name: "client-create",
        component: ClientForm,
      },

      {
        path: "clients/:id",
        name: "client-show",
        component: ClientShow,
      },

      {
        path: "clients/:id/edit",
        name: "client-edit",
        component: ClientForm,
      },

      // Invoices
      {
        path: "invoices",
        name: "invoices",
        component: InvoicesList,
      },

      {
        path: "invoices/create",
        name: "invoice-create",
        component: InvoiceForm,
      },

      {
        path: "invoices/:id",
        name: "invoice-show",
        component: InvoiceShow,
      },

      {
        path: "invoices/:id/edit",
        name: "invoice-edit",
        component: InvoiceForm,
      },

      // Payments
      {
        path: "payments",
        name: "payments",
        component: PaymentsList,
      },

      {
        path: "payments/create",
        name: "payment-create",
        component: PaymentForm,
      },

      // Profile
      {
        path: "profile",
        name: "profile",
        component: Profile,
      },

      // Business profile
      {
        path: "settings",
        name: "business-profile",
        component: BusinessProfile,
      },

      // Notifications
      {
        path: "notifications",
        name: "notifications",
        component: Notifications,
      },

      // Reports
      {
        path: "reports",
        name: "reports",
        component: Reports,
      },
    ],
  },

  // =========================
  // ADMIN ROUTES
  // =========================
  {
    path: "/admin",
    redirect: "/admin/dashboard",

    meta: {
      requiresAuth: true,
      admin: true,
    },
  },

  {
    path: "/admin/dashboard",
    name: "admin-dashboard",
    component: AdminDashboard,

    meta: {
      requiresAuth: true,
      admin: true,
    },
  },

  {
    path: "/admin/users",
    name: "admin-users",
    component: AdminUsers,

    meta: {
      requiresAuth: true,
      admin: true,
    },
  },

  {
    path: "/admin/invoices",
    name: "admin-invoices",
    component: AdminInvoices,

    meta: {
      requiresAuth: true,
      admin: true,
    },
  },

  {
    path: "/admin/payments",
    name: "admin-payments",
    component: AdminPayments,

    meta: {
      requiresAuth: true,
      admin: true,
    },
  },

  {
    path: "/admin/audit-logs",
    name: "admin-audit-logs",
    component: AdminAuditLogs,

    meta: {
      requiresAuth: true,
      admin: true,
    },
  },

  {
    path: "/admin/errors",
    name: "admin-errors",
    component: AdminErrors,

    meta: {
      requiresAuth: true,
      admin: true,
    },
  },

  // =========================
  // 404
  // =========================
  {
    path: "/:pathMatch(.*)*",
    redirect: "/",
  },
];

// =========================
// Router
// =========================
const router = createRouter({
  history: createWebHistory(),

  routes,

  scrollBehavior(to, from, savedPosition) {
    if (savedPosition) {
      return savedPosition;
    }

    if (to.hash) {
      return {
        el: to.hash,
        behavior: "smooth",
      };
    }

    return {
      top: 0,
      behavior: "smooth",
    };
  },
});

// =========================
// Navigation Guard
// =========================
router.beforeEach(async (to) => {
  const authStore = useAuthStore();

  // Load currently authenticated user
  if (!authStore.initialized) {
    await authStore.fetchUser();
  }

  // =========================
  // Authentication check
  // =========================
  if (
    to.meta.requiresAuth &&
    !authStore.isAuthenticated
  ) {
    return {
      name: "login",
      query: {
        redirect: to.fullPath,
      },
    };
  }

  // =========================
  // Admin check
  // =========================
  if (to.meta.admin) {
    if (!authStore.isAuthenticated) {
      return {
        name: "login",
        query: {
          redirect: to.fullPath,
        },
      };
    }

    if (authStore.user?.role !== "admin") {
      return {
        name: "dashboard",
      };
    }
  }

  // =========================
  // Prevent authenticated users
  // from visiting login/register
  // =========================
  if (
    to.meta.guest &&
    authStore.isAuthenticated &&
    [
      "login",
      "register",
      "forgot-password",
      "reset-password",
    ].includes(to.name)
  ) {
    return {
      name: "dashboard",
    };
  }

  return true;
});

export default router;