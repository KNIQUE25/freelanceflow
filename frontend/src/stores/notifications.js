import { defineStore } from 'pinia'
import { getNotifications, markAsRead, markAllRead } from '../services/notifications'

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
        return { success: false, message: error.response?.data?.message }
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
        return { success: false, message: error.response?.data?.message }
      }
    },
    async markAllRead() {
      try {
        await markAllRead()
        await this.fetchNotifications()
        return { success: true }
      } catch (error) {
        return { success: false, message: error.response?.data?.message }
      }
    },
  },
})