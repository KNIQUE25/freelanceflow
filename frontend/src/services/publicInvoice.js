import api from './api'

export async function getPublicInvoice(uuid) {
  const response = await api.get(`/public/invoice/${uuid}`)
  return response.data
}

export async function payPublicInvoice(uuid, phone) {
  const response = await api.post(`/public/invoice/${uuid}/pay`, { phone })
  return response.data
}

export async function checkPublicInvoiceStatus(uuid) {
  const response = await api.get(`/public/invoice/${uuid}/status`)
  return response.data
}