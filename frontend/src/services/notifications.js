import api from './api'

export async function getNotifications() {
  const response = await api.get('/api/notifications')
  return response.data
}

export async function markAsRead(id) {
  const response = await api.post(`/api/notifications/${id}/read`)
  return response.data
}

export async function markAllRead() {
  const response = await api.post('/api/notifications/read-all')
  return response.data
}