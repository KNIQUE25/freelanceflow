import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from '@/stores/auth'


// =====================================================
// PUBLIC
// =====================================================

import Home from '../views/Home.vue'
import About from '../views/About.vue'
import Contact from '../views/Contact.vue'
import FAQ from '../views/FAQ.vue'
import Features from '../views/Features.vue'
import HowItWorks from '../views/HowItWorks.vue'
import Pricing from '../views/Pricing.vue'
import Terms from '../views/Terms.vue'
import PrivacyPolicy from '../views/PrivacyPolicy.vue'


// =====================================================
// GUEST
// =====================================================

import GuestLayout from '../layouts/GuestLayout.vue'

const Login = () =>
    import('../views/Auth/Login.vue')

const Register = () =>
    import('../views/Auth/Register.vue')

const ForgotPassword = () =>
    import('../views/Auth/ForgotPassword.vue')

const ResetPassword = () =>
    import('../views/Auth/ResetPassword.vue')


// =====================================================
// USER LAYOUT
// =====================================================

import MainLayout from '../layouts/MainLayout.vue'

const Dashboard = () =>
    import('../views/Dashboard.vue')

const ClientsList = () =>
    import('../views/Clients/ClientsList.vue')

const ClientForm = () =>
    import('../views/Clients/ClientForm.vue')

const ClientShow = () =>
    import('../views/Clients/ClientShow.vue')

const InvoicesList = () =>
    import('../views/Invoices/InvoicesList.vue')

const InvoiceForm = () =>
    import('../views/Invoices/InvoiceForm.vue')

const InvoiceShow = () =>
    import('../views/Invoices/InvoiceShow.vue')

const PaymentsList = () =>
    import('../views/Payments/PaymentsList.vue')

const PaymentForm = () =>
    import('../views/Payments/PaymentForm.vue')

const Profile = () =>
    import('../views/Profile.vue')

const BusinessProfile = () =>
    import('../views/BusinessProfile.vue')

const Notifications = () =>
    import('../views/Notifications.vue')

const Reports = () =>
    import('../views/Reports.vue')

const PublicInvoice = () =>
    import('../views/PublicInvoice.vue')


// =====================================================
// ADMIN
// =====================================================

import AdminLayout from '../layouts/AdminLayout.vue'

const AdminDashboard = () =>
    import('../views/admin/AdminDashboard.vue')

const AdminUsers = () =>
    import('../views/admin/AdminUsers.vue')

const AdminInvoices = () =>
    import('../views/admin/AdminInvoices.vue')

const AdminPayments = () =>
    import('../views/admin/AdminPayments.vue')

const AdminAuditLogs = () =>
    import('../views/admin/AdminAuditLogs.vue')

const AdminErrors = () =>
    import('../views/admin/AdminErrors.vue')


// =====================================================
// ROUTES
// =====================================================

const routes = [

    // -------------------------------------------------
    // PUBLIC
    // -------------------------------------------------

    {
        path: '/',
        name: 'home',
        component: Home,
        meta: {
            public: true
        }
    },

    {
        path: '/about',
        name: 'about',
        component: About,
        meta: {
            public: true
        }
    },

    {
        path: '/contact',
        name: 'contact',
        component: Contact,
        meta: {
            public: true
        }
    },

    {
        path: '/faq',
        name: 'faq',
        component: FAQ,
        meta: {
            public: true
        }
    },

    {
        path: '/features',
        name: 'features',
        component: Features,
        meta: {
            public: true
        }
    },

    {
        path: '/how-it-works',
        name: 'how-it-works',
        component: HowItWorks,
        meta: {
            public: true
        }
    },

    {
        path: '/pricing',
        name: 'pricing',
        component: Pricing,
        meta: {
            public: true
        }
    },

    {
        path: '/terms',
        name: 'terms',
        component: Terms,
        meta: {
            public: true
        }
    },

    {
        path: '/privacy',
        name: 'privacy',
        component: PrivacyPolicy,
        meta: {
            public: true
        }
    },


    // -------------------------------------------------
    // GUEST
    // -------------------------------------------------

    {
        path: '/',
        component: GuestLayout,

        children: [

            {
                path: 'login',
                name: 'login',
                component: Login,
                meta: {
                    guest: true
                }
            },

            {
                path: 'register',
                name: 'register',
                component: Register,
                meta: {
                    guest: true
                }
            },

            {
                path: 'forgot-password',
                name: 'forgot-password',
                component: ForgotPassword,
                meta: {
                    guest: true
                }
            },

            {
                path: 'reset-password/:token?',
                name: 'reset-password',
                component: ResetPassword,
                meta: {
                    guest: true
                }
            },

        ]
    },


    // -------------------------------------------------
    // PUBLIC INVOICE
    // -------------------------------------------------

    {
        path: '/public/invoice/:uuid',
        name: 'public-invoice',
        component: PublicInvoice,
        meta: {
            public: true
        }
    },


    // -------------------------------------------------
    // USER
    // -------------------------------------------------

    {
        path: '/',
        component: MainLayout,

        meta: {
            requiresAuth: true
        },

        children: [

            {
                path: '',
                redirect: '/dashboard'
            },

            {
                path: 'dashboard',
                name: 'dashboard',
                component: Dashboard
            },

            {
                path: 'clients',
                name: 'clients',
                component: ClientsList
            },

            {
                path: 'clients/create',
                name: 'client-create',
                component: ClientForm
            },

            {
                path: 'clients/:id',
                name: 'client-show',
                component: ClientShow
            },

            {
                path: 'clients/:id/edit',
                name: 'client-edit',
                component: ClientForm
            },

            {
                path: 'invoices',
                name: 'invoices',
                component: InvoicesList
            },

            {
                path: 'invoices/create',
                name: 'invoice-create',
                component: InvoiceForm
            },

            {
                path: 'invoices/:id',
                name: 'invoice-show',
                component: InvoiceShow
            },

            {
                path: 'invoices/:id/edit',
                name: 'invoice-edit',
                component: InvoiceForm
            },

            {
                path: 'payments',
                name: 'payments',
                component: PaymentsList
            },

            {
                path: 'payments/create',
                name: 'payment-create',
                component: PaymentForm
            },

            {
                path: 'profile',
                name: 'profile',
                component: Profile
            },

            {
                path: 'settings',
                name: 'business-profile',
                component: BusinessProfile
            },

            {
                path: 'notifications',
                name: 'notifications',
                component: Notifications
            },

            {
                path: 'reports',
                name: 'reports',
                component: Reports
            }
        ]
    },


    // =================================================
    // ADMIN
    // =================================================

    {
        path: '/admin',
        component: AdminLayout,

        meta: {
            requiresAuth: true,
            admin: true
        },

        children: [

            {
                path: '',
                redirect: {
                    name: 'admin-dashboard'
                }
            },

            {
                path: 'dashboard',
                name: 'admin-dashboard',
                component: AdminDashboard
            },

            {
                path: 'users',
                name: 'admin-users',
                component: AdminUsers
            },

            {
                path: 'invoices',
                name: 'admin-invoices',
                component: AdminInvoices
            },

            {
                path: 'payments',
                name: 'admin-payments',
                component: AdminPayments
            },

            {
                path: 'audit-logs',
                name: 'admin-audit-logs',
                component: AdminAuditLogs
            },

            {
                path: 'errors',
                name: 'admin-errors',
                component: AdminErrors
            }
        ]
    },


    // -------------------------------------------------
    // 404
    // -------------------------------------------------

    {
        path: '/:pathMatch(.*)*',
        redirect: '/'
    }
]


// =====================================================
// ROUTER
// =====================================================

const router = createRouter({

    history: createWebHistory(),

    routes,

    scrollBehavior(to, from, savedPosition) {

        if (savedPosition) {
            return savedPosition
        }

        if (to.hash) {
            return {
                el: to.hash,
                behavior: 'smooth'
            }
        }

        return {
            top: 0,
            behavior: 'smooth'
        }
    }
})


// =====================================================
// NAVIGATION GUARD
// =====================================================

router.beforeEach(async (to) => {

    const authStore = useAuthStore()


    // -------------------------------------------------
    // Load authenticated user
    // -------------------------------------------------

    if (!authStore.initialized) {

        await authStore.fetchUser()
    }


    // -------------------------------------------------
    // Requires authentication
    // -------------------------------------------------

    if (
        to.meta.requiresAuth &&
        !authStore.isAuthenticated
    ) {

        return {
            name: 'login',

            query: {
                redirect: to.fullPath
            }
        }
    }


    // -------------------------------------------------
    // ADMIN
    // -------------------------------------------------

    if (to.meta.admin) {

        if (!authStore.isAuthenticated) {

            return {
                name: 'login',

                query: {
                    redirect: to.fullPath
                }
            }
        }


        if (!authStore.isAdmin) {

            return {
                name: 'dashboard'
            }
        }
    }


    // -------------------------------------------------
    // Prevent logged-in users from login/register
    // -------------------------------------------------

    if (
        to.meta.guest &&
        authStore.isAuthenticated &&
        [
            'login',
            'register',
            'forgot-password',
            'reset-password'
        ].includes(to.name)
    ) {

        // Admin goes to admin dashboard
        if (authStore.isAdmin) {

            return {
                name: 'admin-dashboard'
            }
        }

        // Normal user
        return {
            name: 'dashboard'
        }
    }


    return true
})


export default router