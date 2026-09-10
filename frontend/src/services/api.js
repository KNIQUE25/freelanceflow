// Keep legacy imports on the same configured client as auth and contact requests.
// This avoids divergent base URLs and duplicated CSRF initialization.
import api from '@/api/axios'

export default api