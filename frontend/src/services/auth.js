import api from './api'

export async function getCsrfCookie() {
  await api.get('/sanctum/csrf-cookie')
}

export async function register(data) {
  await getCsrfCookie()
  const response = await api.post('/api/register', data)
  return response.data
}

export async function login(data) {
  await getCsrfCookie()
  const response = await api.post('/api/login', data)
  return response.data
}

export async function logout() {
  const response = await api.post('/api/logout')
  return response.data
}

export async function getUser() {
  const response = await api.get('/api/user')
  return response.data
}

export async function forgotPassword(email) {
  const response = await api.post('/api/forgot-password', { email })
  return response.data
}

export async function resetPassword(data) {
  const response = await api.post('/api/reset-password', data)
  return response.data
}

export async function resendVerification() {
  const response = await api.post('/api/email/resend')
  return response.data
}