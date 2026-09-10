import { defineStore } from 'pinia'
import { getClients, getClient, createClient, updateClient, deleteClient } from '../services/clients'

export const useClientsStore = defineStore('clients', {
  state: () => ({
    clients: [],
    client: null,
    meta: {},
    isLoading: false,
  }),
  actions: {
    getErrorMessage(error) {
      const response = error.response
      const validationErrors = response?.data?.errors
      const firstValidationError = validationErrors
        ? Object.values(validationErrors)[0]
        : null

      return Array.isArray(firstValidationError)
        ? firstValidationError[0]
        : response?.data?.message || 'Unable to save client.'
    },

    async fetchClients(params = {}) {
      this.isLoading = true
      try {
        const { data, meta } = await getClients(params)
        this.clients = data
        this.meta = meta
        return { success: true, data }
      } catch (error) {
        return { success: false, message: this.getErrorMessage(error) }
      } finally {
        this.isLoading = false
      }
    },
    async fetchClient(id) {
      this.isLoading = true
      try {
        const { data } = await getClient(id)
        this.client = data
        return { success: true, data }
      } catch (error) {
        return { success: false, message: this.getErrorMessage(error) }
      } finally {
        this.isLoading = false
      }
    },
    async create(data) {
      try {
        const response = await createClient(data)
        return { success: true, data: response }
      } catch (error) {
        return { success: false, message: this.getErrorMessage(error) }
      }
    },
    async update(id, data) {
      try {
        const response = await updateClient(id, data)
        return { success: true, data: response }
      } catch (error) {
        return { success: false, message: this.getErrorMessage(error) }
      }
    },
    async delete(id) {
      try {
        await deleteClient(id)
        return { success: true }
      } catch (error) {
        return { success: false, message: this.getErrorMessage(error) }
      }
    },
  },
})