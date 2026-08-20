import { defineStore } from 'pinia'
import { getInvoices, getInvoice, createInvoice, updateInvoice, deleteInvoice } from '../services/invoices'

export const useInvoicesStore = defineStore('invoices', {
  state: () => ({
    invoices: [],
    invoice: null,
    meta: {},
    isLoading: false,
  }),
  actions: {
    async fetchInvoices(params = {}) {
      this.isLoading = true
      try {
        const { data, meta } = await getInvoices(params)
        this.invoices = data
        this.meta = meta
        return { success: true, data }
      } catch (error) {
        return { success: false, message: error.response?.data?.message }
      } finally {
        this.isLoading = false
      }
    },
    async fetchInvoice(id) {
      this.isLoading = true
      try {
        const { data } = await getInvoice(id)
        this.invoice = data
        return { success: true, data }
      } catch (error) {
        return { success: false, message: error.response?.data?.message }
      } finally {
        this.isLoading = false
      }
    },
    async create(data) {
      try {
        const response = await createInvoice(data)
        return { success: true, data: response }
      } catch (error) {
        return { success: false, message: error.response?.data?.message }
      }
    },
    async update(id, data) {
      try {
        const response = await updateInvoice(id, data)
        return { success: true, data: response }
      } catch (error) {
        return { success: false, message: error.response?.data?.message }
      }
    },
    async delete(id) {
      try {
        await deleteInvoice(id)
        return { success: true }
      } catch (error) {
        return { success: false, message: error.response?.data?.message }
      }
    },
  },
})