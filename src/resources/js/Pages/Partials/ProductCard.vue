<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
  product: {
    type: Object,
    required: true,
  },
})
</script>

<template>
  <article class="overflow-hidden rounded-lg border border-stone-200 bg-white shadow-sm">
    <Link :href="product.url" class="block">
      <div class="aspect-[4/3] bg-mist">
        <img
          v-if="product.image"
          :src="product.image"
          :alt="product.name"
          class="h-full w-full object-cover"
        >
        <div v-else class="flex h-full items-center justify-center px-6 text-center text-sm font-medium text-slate-500">
          Product image
        </div>
      </div>
      <div class="p-5">
        <div class="flex items-start justify-between gap-4">
          <h3 class="text-base font-semibold text-ink">{{ product.name }}</h3>
          <p class="shrink-0 text-sm font-semibold text-ember">${{ product.price }}</p>
        </div>
        <p v-if="product.category" class="mt-1 text-xs font-semibold uppercase tracking-wide text-slate-500">
          {{ product.category.name }}
        </p>
        <p class="mt-3 line-clamp-3 text-sm leading-6 text-slate-600">
          {{ product.short_description || 'No short description has been added.' }}
        </p>
      </div>
    </Link>
  </article>
</template>
