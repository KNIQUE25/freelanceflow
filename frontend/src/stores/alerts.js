import { defineStore } from 'pinia'

export const useAlertStore = defineStore('alert', {
  state: () => ({
    messages: [],
  }),
  actions: {
    success(msg) {
      this.messages.push({ type: 'success', text: msg })
    },
    error(msg) {
      this.messages.push({ type: 'error', text: msg })
    },
    clear() {
      this.messages = []
    },
  },
})