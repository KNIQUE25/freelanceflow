import api from './api'
export async function getProfile() { return (await api.get('/api/profile')).data }
export async function updateProfile(data) { return (await api.put('/api/profile', data)).data }
export async function changePassword(data) { return (await api.post('/api/profile/change-password', data)).data }
export async function deleteAccount() { return (await api.delete('/api/profile')).data }
