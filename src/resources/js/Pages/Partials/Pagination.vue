<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
  links: {
    type: Array,
    default: () => [],
  },
})
</script>

<template>
  <nav v-if="links.length > 3" class="flex flex-wrap gap-2" aria-label="Pagination">
    <template v-for="link in links" :key="link.label">
      <span
        v-if="!link.url"
        class="rounded-md border border-stone-200 px-3 py-2 text-sm text-slate-400"
        v-html="link.label"
      />
      <Link
        v-else
        :href="link.url"
        class="rounded-md border px-3 py-2 text-sm"
        :class="link.active ? 'border-leaf bg-leaf text-white hover:text-white' : 'border-stone-200 bg-white text-slate-700 hover:border-leaf'"
        v-html="link.label"
      />
    </template>
  </nav>
</template>
