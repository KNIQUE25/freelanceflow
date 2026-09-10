import api from '@/api/axios'

let csrfRefreshPromise = null

export function getCsrfCookie() {
    if (!csrfRefreshPromise) {
        csrfRefreshPromise = api.get('/sanctum/csrf-cookie')
            .then(() => undefined)
            .finally(() => {
                csrfRefreshPromise = null
            })
    }

    return csrfRefreshPromise
}

export async function withCsrfRecovery(request) {
    await getCsrfCookie()

    try {
        return await request()
    } catch (error) {
        if (error.response?.status !== 419) {
            throw error
        }

        await getCsrfCookie()
        return request()
    }
}

export async function register(data) {
    const response = await withCsrfRecovery(() =>
        api.post('/api/register', data)
    )

    return response.data
}

export async function login(data) {
    const response = await withCsrfRecovery(() =>
        api.post('/api/login', data)
    )

    return response.data
}

export async function getUser() {
    const response = await api.get('/api/user')

    return response.data
}

export async function logout() {
    const response = await withCsrfRecovery(() =>
        api.post('/api/logout')
    )

    return response.data
}

export async function forgotPassword(email) {
    const response = await withCsrfRecovery(() =>
        api.post('/api/forgot-password', {
            email,
        })
    )

    return response.data
}

export async function resetPassword(data) {
    const response = await withCsrfRecovery(() =>
        api.post('/api/reset-password', data)
    )

    return response.data
}
