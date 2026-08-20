import { defineStore } from 'pinia'
import { getPayments, createPayment } from '../services/payments'
import { stkPush } from '../services/mpesa'

export const usePaymentsStore = defineStore('payments', {
  state: () => ({
    payments: [],
    meta: {},
    isLoading: false,
  }),
  actions: {
    async fetchPayments(params = {}) {
      this.isLoading = true
      try {
        const { data, meta } = await getPayments(params)
        this.payments = data
        this.meta = meta
        return { success: true, data }
      } catch (error) {
        return { success: false, message: error.response?.data?.message }
      } finally {
        this.isLoading = false
      }
    },
    async createPayment(data) {
      try {
        const response = await createPayment(data)
        return { success: true, data: response }
      } catch (error) {
        return { success: false, message: error.response?.data?.message }
      }
    },
    async mpesaPayment(data) {
      try {
        const response = await stkPush(data)
        return { success: true, data: response }
      } catch (error) {
        return { success: false, message: error.response?.data?.message }
      }
    },
  },
})