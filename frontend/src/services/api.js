import axios from 'axios'

const api = axios.create({
    baseURL: import.meta.env.VITE_API_URL || 'https://freelanceflow-6smh.onrender.com',
    withCredentials: true,
    withXSRFToken: true,
    headers: {
        Accept: 'application/json',
        'Content-Type': 'application/json',
    },
})

// ✅ Request interceptor – fetch CSRF cookie before state-changing requests
api.interceptors.request.use(async (config) => {
    // Only fetch CSRF for POST, PUT, PATCH, DELETE
    if (['post', 'put', 'patch', 'delete'].includes(config.method?.toLowerCase())) {
        try {
            // Check if XSRF-TOKEN cookie exists (optional check)
            // If not, fetch it. (Sanctum will set it even if it already exists)
            await api.get('/sanctum/csrf-cookie')
        } catch (e) {
            // Continue anyway – the request might still work
            console.warn('CSRF cookie fetch failed:', e)
        }
    }
    return config
})

export default api