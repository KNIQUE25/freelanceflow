import axios from 'axios';

const api = axios.create({
    // In development Vite proxies API requests; production uses the configured API origin.
    baseURL: import.meta.env.VITE_API_URL || '',
    withCredentials: true,
    withXSRFToken: true,
});

export default api;