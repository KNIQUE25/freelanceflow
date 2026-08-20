import api from './api'

export async function getPayments(params) {
  const response = await api.get('/api/payments', { params })
  return response.data
}

export async function createPayment(data) {
  const response = await api.post('/api/payments', data)
  return response.data
}