import { defineStore } from 'pinia'
import { getNotifications, markAsRead, markAllRead } from '../services/notifications'

function getErrorMessage(error) {
  const status = error.response?.status
  if (status === 401) return 'Please sign in to view notifications.'
  if (status === 403) return 'You are not authorized to view notifications.'
  if (status === 419) return 'Your session expired. Please try again.'
  if (status >= 500) return 'Notification service is temporarily unavailable.'
  return error.response?.data?.message || 'Unable to load notifications.'
}

export const useNotificationsStore = defineStore('notifications', {
  state: () => ({
    notifications: [],
    unreadCount: 0,
    isLoading: false,
  }),
  actions: {
    async fetchNotifications() {
      this.isLoading = true
      try {
        const { data } = await getNotifications()
        this.notifications = data
        this.unreadCount = data.filter(n => !n.read_at).length
        return { success: true, data }
      } catch (error) {
        return { success: false, message: getErrorMessage(error) }
      } finally {
        this.isLoading = false
      }
    },
    async markRead(id) {
      try {
        await markAsRead(id)
        await this.fetchNotifications()
        return { success: true }
      } catch (error) {
        return { success: false, message: getErrorMessage(error) }
      }
    },
    async markAllRead() {
      try {
        await markAllRead()
        await this.fetchNotifications()
        return { success: true }
      } catch (error) {
        return { success: false, message: getErrorMessage(error) }
      }
    },
  },
})