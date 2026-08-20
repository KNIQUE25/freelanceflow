import api from './api'

export async function stkPush(data) {
  const response = await api.post('/api/mpesa/stk-push', data)
  return response.data
}