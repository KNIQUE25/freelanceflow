<template>
  <div>
    <label :for="id" class="mb-1.5 block text-sm font-semibold text-slate-700 dark:text-slate-200">{{ label }}</label>
    <div class="relative">
      <input :id="id" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" :type="show ? 'text' : 'password'" autocomplete="new-password" minlength="8" required class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 pr-12 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-primary-500 focus:ring-4 focus:ring-primary-500/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:placeholder:text-slate-500" />
      <button type="button" class="absolute right-0 top-0 grid h-full w-12 place-items-center text-slate-400 transition hover:text-primary-600 dark:text-slate-500 dark:hover:text-primary-400" :aria-label="show ? 'Hide password' : 'Show password'" @click="$emit('toggle')">
        <svg v-if="!show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M2.5 12s3.5-6 9.5-6 9.5 6 9.5 6-3.5 6-9.5 6-9.5-6-9.5-6Z"/><circle cx="12" cy="12" r="2.5"/></svg>
        <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="m3 3 18 18"/><path d="M10.6 5.1A10.7 10.7 0 0 1 12 5c6 0 9.5 7 9.5 7a17.8 17.8 0 0 1-3.1 3.9M6.2 6.3C3.7 8.2 2.5 12 2.5 12s3.5 6 9.5 6c1 0 1.9-.2 2.7-.5"/><path d="M9.9 9.9a3 3 0 0 0 4.2 4.2"/></svg>
      </button>
    </div>
  </div>
</template>

<script setup>
defineProps({
  id: { type: String, required: true },
  label: { type: String, required: true },
  modelValue: { type: String, required: true },
  show: { type: Boolean, default: false },
})
defineEmits(['update:modelValue', 'toggle'])
</script>