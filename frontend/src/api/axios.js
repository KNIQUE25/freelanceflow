import axios from 'axios';

const api = axios.create({
    // Keep API and cookie requests same-origin in production via Vercel rewrites.
    baseURL: '',
    withCredentials: true,
    withXSRFToken: true,
});

export default api;