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
    async fetchClients(params = {}) {
      this.isLoading = true
      try {
        const { data, meta } = await getClients(params)
        this.clients = data
        this.meta = meta
        return { success: true, data }
      } catch (error) {
        return { success: false, message: error.response?.data?.message }
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
        return { success: false, message: error.response?.data?.message }
      } finally {
        this.isLoading = false
      }
    },
    async create(data) {
      try {
        const response = await createClient(data)
        return { success: true, data: response }
      } catch (error) {
        return { success: false, message: error.response?.data?.message }
      }
    },
    async update(id, data) {
      try {
        const response = await updateClient(id, data)
        return { success: true, data: response }
      } catch (error) {
        return { success: false, message: error.response?.data?.message }
      }
    },
    async delete(id) {
      try {
        await deleteClient(id)
        return { success: true }
      } catch (error) {
        return { success: false, message: error.response?.data?.message }
      }
    },
  },
})