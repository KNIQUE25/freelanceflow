import { defineStore } from 'pinia'

export const useThemeStore = defineStore('theme', {
    state: () => ({
        theme: 'system',
        initialized: false,
    }),

    getters: {
        isDark: (state) => {
            if (state.theme === 'dark') return true
            if (state.theme === 'light') return false
            return window.matchMedia('(prefers-color-scheme: dark)').matches
        },
    },

    actions: {
        initializeTheme() {
            const saved = localStorage.getItem('freelanceflow-theme')
            if (saved === 'light' || saved === 'dark' || saved === 'system') {
                this.theme = saved
            } else {
                this.theme = 'system'
            }
            this.applyTheme()

            const media = window.matchMedia('(prefers-color-scheme: dark)')
            media.addEventListener('change', this.handleSystemThemeChange)
            this.initialized = true
        },

        setTheme(theme) {
            if (!['light', 'dark', 'system'].includes(theme)) return
            this.theme = theme
            localStorage.setItem('freelanceflow-theme', theme)
            this.applyTheme()
        },

        applyTheme() {
            const html = document.documentElement
            const shouldBeDark =
                this.theme === 'dark' ||
                (this.theme === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches)

            html.classList.toggle('dark', shouldBeDark)
            html.style.colorScheme = shouldBeDark ? 'dark' : 'light'
        },

        handleSystemThemeChange() {
            if (this.theme === 'system') this.applyTheme()
        },
    },
})