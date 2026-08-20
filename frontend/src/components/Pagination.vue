<template>
  <div v-if="meta.total > meta.per_page" class="flex justify-between items-center mt-4">
    <div class="text-sm text-gray-700">
      Showing {{ meta.from }} to {{ meta.to }} of {{ meta.total }}
    </div>
    <div class="flex space-x-1">
      <button
        v-for="link in meta.links"
        :key="link.label"
        @click="goTo(link.url)"
        :disabled="!link.url"
        class="px-3 py-1 border rounded text-sm"
        :class="[
          link.active ? 'bg-primary-600 text-white' : 'hover:bg-gray-100',
          !link.url ? 'opacity-50 cursor-not-allowed' : ''
        ]"
        v-html="link.label"
      />
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  meta: { type: Object, required: true },
})
const emit = defineEmits(['page-change'])

function goTo(url) {
  if (!url) return
  const params = new URL(url).searchParams
  const page = params.get('page')
  if (page) emit('page-change', page)
}
</script>