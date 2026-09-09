import axios from 'axios'

// Was hardcoded to 'http://localhost:8000', which meant the deployed frontend
// kept calling your local machine instead of the real API. VITE_API_URL is
// already defined in .env / .env.production - we just weren't reading it.
const api = axios.create({
    baseURL: import.meta.env.VITE_API_URL || 'http://localhost:8000',
    withCredentials: true,
    withXSRFToken: true,
    headers: {
        Accept: 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
    },
})

export default api