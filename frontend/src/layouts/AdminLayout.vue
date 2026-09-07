import AdminDashboard from '@/views/admin/AdminDashboard.vue'
import AdminUsers from '@/views/admin/AdminUsers.vue'
import AdminInvoices from '@/views/admin/AdminInvoices.vue'
import AdminPayments from '@/views/admin/AdminPayments.vue'
import AdminAuditLogs from '@/views/admin/AdminAuditLogs.vue'
import AdminErrors from '@/views/admin/AdminErrors.vue'

// Inside routes array (under MainLayout)
{
  path: '/admin',
  redirect: '/admin/dashboard',
  meta: { requiresAuth: true, admin: true }
},
{
  path: '/admin/dashboard',
  name: 'admin-dashboard',
  component: AdminDashboard,
  meta: { requiresAuth: true, admin: true }
},
{
  path: '/admin/users',
  name: 'admin-users',
  component: AdminUsers,
  meta: { requiresAuth: true, admin: true }
},
{
  path: '/admin/invoices',
  name: 'admin-invoices',
  component: AdminInvoices,
  meta: { requiresAuth: true, admin: true }
},
{
  path: '/admin/payments',
  name: 'admin-payments',
  component: AdminPayments,
  meta: { requiresAuth: true, admin: true }
},
{
  path: '/admin/audit-logs',
  name: 'admin-audit-logs',
  component: AdminAuditLogs,
  meta: { requiresAuth: true, admin: true }
},
{
  path: '/admin/errors',
  name: 'admin-errors',
  component: AdminErrors,
  meta: { requiresAuth: true, admin: true }
}