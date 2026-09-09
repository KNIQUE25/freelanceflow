import api from '@/api/axios'

export async function sendContactMessage(data) {
    const response = await api.post('/api/contact', data)

    return response.data
}
