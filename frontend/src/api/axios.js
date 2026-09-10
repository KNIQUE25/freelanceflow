import axios from 'axios';

let csrfToken = null;

const api = axios.create({
    baseURL: import.meta.env.VITE_API_URL,
    withCredentials: true,
    withXSRFToken: true,
});

api.interceptors.request.use((config) => {
    if (
        csrfToken &&
        ['post', 'put', 'patch', 'delete'].includes(config.method?.toLowerCase())
    ) {
        config.headers = config.headers || {};
        config.headers['X-XSRF-TOKEN'] = csrfToken;
    }

    return config;
});

export function setCsrfToken(token) {
    csrfToken = token;
}

export default api;