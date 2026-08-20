import api from './api'
const unwrap = (payload) => payload?.data ?? payload
export async function getBusinessProfile() { return unwrap((await api.get('/api/business-profile')).data) }
export async function createBusinessProfile(data) { return unwrap((await api.post('/api/business-profile', data)).data) }
export async function updateBusinessProfile(id, data) {
  const response = data instanceof FormData ? await api.post(`/api/business-profile/${id}`, data) : await api.put(`/api/business-profile/${id}`, data)
  return unwrap(response.data)
}
export async function deleteBusinessProfile(id) { return (await api.delete(`/api/business-profile/${id}`)).data }
