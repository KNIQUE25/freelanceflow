import { defineStore } from "pinia";
import api from "@/services/api";

export const useAdminStore = defineStore("admin", {
  state: () => ({
    stats: null,
    users: { data: [], meta: {} },
    user: null,
    invoices: { data: [], meta: {} },
    payments: { data: [], meta: {} },
    logs: { data: [], meta: {} },
    errorLogs: [],
    loading: false,
  }),

  actions: {
    async fetchStats() {
      const res = await api.get("/admin/dashboard");
      this.stats = res.data;
      return res.data;
    },

    async fetchUsers(params = {}) {
      this.loading = true;

      try {
        const res = await api.get("/admin/users", { params });
        this.users = res.data;
      } finally {
        this.loading = false;
      }
    },

    async fetchUser(id) {
      const res = await api.get(`/admin/users/${id}`);
      this.user = res.data;
      return res.data;
    },

    async suspendUser(id) {
      await api.post(`/admin/users/${id}/suspend`);
      await this.fetchUsers();
    },

    async activateUser(id) {
      await api.post(`/admin/users/${id}/activate`);
      await this.fetchUsers();
    },

    async deleteUser(id) {
      await api.delete(`/admin/users/${id}`);
      await this.fetchUsers();
    },

    async fetchInvoices(params = {}) {
      const res = await api.get("/admin/invoices", { params });
      this.invoices = res.data;
    },

    async fetchPayments(params = {}) {
      const res = await api.get("/admin/payments", { params });
      this.payments = res.data;
    },

    async fetchAuditLogs(params = {}) {
      const res = await api.get("/admin/audit-logs", { params });
      this.logs = res.data;
    },

    async fetchErrorLogs() {
      const res = await api.get("/admin/logs");
      this.errorLogs = res.data.logs || [];
    },

    async clearCache() {
      await api.post("/admin/clear-cache");
    },

    // ✅ ADMIN LOGOUT
    async logout() {
      try {
        await api.get("/sanctum/csrf-cookie");
        await api.post("/logout");

        // Clear admin state
        this.stats = null;
        this.users = { data: [], meta: {} };
        this.user = null;
        this.invoices = { data: [], meta: {} };
        this.payments = { data: [], meta: {} };
        this.logs = { data: [], meta: {} };
        this.errorLogs = [];

        return true;
      } catch (error) {
        console.error("Admin logout failed:", error);
        throw error;
      }
    },
  },
});