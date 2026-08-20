import api from './api'

export async function getRevenue(params) {
  const response = await api.get('/api/reports/revenue', { params })
  return response.data
}

export async function getInvoiceStatus() {
  const response = await api.get('/api/reports/invoice-status')
  return response.data
}

export async function getClientSummary() {
  const response = await api.get('/api/reports/client-summary')
  return response.data
}

export async function getPaymentMethods() {
  const response = await api.get('/api/reports/payment-methods')
  return response.data
}