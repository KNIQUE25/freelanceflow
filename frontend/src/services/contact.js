import api from '@/api/axios'
import { getCsrfCookie } from '@/services/auth'

export async function sendContactMessage(data) {
    await getCsrfCookie()
    const response = await api.post('/api/contact', data)

    return response.data
}
