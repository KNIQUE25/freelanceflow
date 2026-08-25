<template>
    <div
        class="
            w-full
            rounded-2xl
            border
            border-gray-200
            bg-white
            p-6
            shadow-xl
            sm:p-8

            dark:border-slate-700
            dark:bg-slate-900
        "
    >
        <div class="mb-8 text-center">
            <h2
                class="
                    text-2xl
                    font-bold
                    text-gray-900
                    dark:text-white
                "
            >
                Forgot Password?
            </h2>

            <p
                class="
                    mt-2
                    text-sm
                    text-gray-600
                    dark:text-slate-400
                "
            >
                Enter your email and we'll send you a
                password reset link.
            </p>
        </div>

        <form
            class="space-y-5"
            @submit.prevent="handleSubmit"
        >
            <div>
                <label
                    for="email"
                    class="
                        mb-2
                        block
                        text-sm
                        font-medium
                        text-gray-700
                        dark:text-slate-300
                    "
                >
                    Email address
                </label>

                <input
                    id="email"
                    v-model="email"
                    type="email"
                    autocomplete="email"
                    placeholder="you@example.com"
                    required
                    class="
                        w-full
                        rounded-xl
                        border
                        border-gray-300
                        bg-white
                        px-4
                        py-3
                        text-gray-900
                        transition

                        placeholder:text-gray-400

                        focus:border-primary-500
                        focus:outline-none
                        focus:ring-2
                        focus:ring-primary-500/20

                        dark:border-slate-600
                        dark:bg-slate-800
                        dark:text-white
                    "
                />
            </div>

            <button
                type="submit"
                :disabled="loading"
                class="
                    w-full
                    rounded-xl
                    bg-primary-600
                    px-4
                    py-3
                    font-semibold
                    text-white
                    transition

                    hover:bg-primary-700

                    disabled:cursor-not-allowed
                    disabled:opacity-60
                "
            >
                {{ loading ? 'Sending...' : 'Send Reset Link' }}
            </button>

            <div
                v-if="message"
                :class="[
                    'rounded-lg px-4 py-3 text-sm',
                    success
                        ? 'bg-green-50 text-green-700 dark:bg-green-900/20 dark:text-green-400'
                        : 'bg-red-50 text-red-700 dark:bg-red-900/20 dark:text-red-400'
                ]"
            >
                {{ message }}
            </div>
        </form>

        <div class="mt-6 text-center">
            <router-link
                to="/login"
                class="
                    text-sm
                    font-medium
                    text-primary-600
                    hover:text-primary-700
                    hover:underline

                    dark:text-primary-400
                "
            >
                ← Back to Login
            </router-link>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import { useAuthStore } from '@/stores/auth'

const authStore = useAuthStore()

const email = ref('')
const loading = ref(false)
const message = ref('')
const success = ref(false)

async function handleSubmit() {
    if (!email.value) {
        message.value = 'Please enter your email address.'
        success.value = false
        return
    }

    loading.value = true
    message.value = ''

    const result = await authStore.forgotPassword(
        email.value
    )

    success.value = result.success
    message.value = result.message

    loading.value = false
}
</script>