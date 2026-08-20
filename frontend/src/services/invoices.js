import api from './api'

export async function getInvoices(params) {
  const response = await api.get('/api/invoices', { params })
  return response.data
}

export async function getInvoice(id) {
  const response = await api.get(`/api/invoices/${id}`)
  return response.data
}

export async function createInvoice(data) {
  const response = await api.post('/api/invoices', data)
  return response.data
}

export async function updateInvoice(id, data) {
  const response = await api.put(`/api/invoices/${id}`, data)
  return response.data
}

export async function deleteInvoice(id) {
  const response = await api.delete(`/api/invoices/${id}`)
  return response.data
}

export async function downloadInvoicePdf(id) {
  const response = await api.get(`/api/invoices/${id}/pdf`, { responseType: 'blob' })
  return response.data
}