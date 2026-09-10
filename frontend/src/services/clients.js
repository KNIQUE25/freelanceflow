import api from './api'
import { withCsrfRecovery } from './auth'

export async function getClients(params) {
  const response = await api.get('/api/clients', { params })
  return response.data
}

export async function getClient(id) {
  const response = await api.get(`/api/clients/${id}`)
  return response.data
}

export async function createClient(data) {
  const response = await withCsrfRecovery(() =>
    api.post('/api/clients', data)
  )
  return response.data
}

export async function updateClient(id, data) {
  const response = await withCsrfRecovery(() =>
    api.put(`/api/clients/${id}`, data)
  )
  return response.data
}

export async function deleteClient(id) {
  const response = await withCsrfRecovery(() =>
    api.delete(`/api/clients/${id}`)
  )
  return response.data
}