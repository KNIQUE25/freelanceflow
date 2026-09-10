import { defineStore } from 'pinia'
import api from '@/services/api'
import { getCsrfCookie } from '@/services/auth'

export const useAdminStore = defineStore('admin', {

    state: () => ({

        stats: null,

        users: {
            data: [],
            meta: {}
        },

        user: null,

        invoices: {
            data: [],
            meta: {}
        },

        payments: {
            data: [],
            meta: {}
        },

        logs: {
            data: [],
            meta: {}
        },

        errorLogs: [],

        loading: false,

    }),


    actions: {

        async fetchStats() {

            const response =
                await api.get('/api/admin/dashboard')

            this.stats = response.data

            return response.data
        },


        async fetchUsers(params = {}) {

            this.loading = true

            try {

                const response =
                    await api.get(
                        '/api/admin/users',
                        { params }
                    )

                this.users = response.data

            } finally {

                this.loading = false

            }
        },


        async fetchUser(id) {

            const response =
                await api.get(
                    `/api/admin/users/${id}`
                )

            this.user = response.data

            return response.data
        },


        async suspendUser(id) {

            await getCsrfCookie()
            await api.post(
                `/api/admin/users/${id}/suspend`
            )

            await this.fetchUsers()
        },


        async activateUser(id) {

            await getCsrfCookie()
            await api.post(
                `/api/admin/users/${id}/activate`
            )

            await this.fetchUsers()
        },


        async deleteUser(id) {

            await getCsrfCookie()
            await api.delete(
                `/api/admin/users/${id}`
            )

            await this.fetchUsers()
        },


        async fetchInvoices(params = {}) {

            const response =
                await api.get(
                    '/api/admin/invoices',
                    { params }
                )

            this.invoices = response.data
        },


        async fetchPayments(params = {}) {

            const response =
                await api.get(
                    '/api/admin/payments',
                    { params }
                )

            this.payments = response.data
        },


        async fetchAuditLogs(params = {}) {

            const response =
                await api.get(
                    '/api/admin/audit-logs',
                    { params }
                )

            this.logs = response.data
        },


        async fetchErrorLogs() {

            const response =
                await api.get(
                    '/api/admin/logs'
                )

            this.errorLogs =
                response.data.logs || []
        },


        async clearCache() {

            await getCsrfCookie()
            await api.post(
                '/api/admin/clear-cache'
            )
        }

    }

})