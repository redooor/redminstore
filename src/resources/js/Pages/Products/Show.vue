<script setup>
import { Head, Link } from '@inertiajs/vue3'
import StorefrontLayout from '../../Layouts/StorefrontLayout.vue'
import ProductCard from '../Partials/ProductCard.vue'

defineProps({
  product: {
    type: Object,
    required: true,
  },
})
</script>

<template>
  <StorefrontLayout :title="product.name">
    <Head :title="product.name" />

    <section class="mx-auto grid max-w-6xl gap-10 px-4 py-12 sm:px-6 lg:grid-cols-2 lg:px-8">
      <div class="overflow-hidden rounded-lg border border-stone-200 bg-mist">
        <img
          v-if="product.image"
          :src="product.image"
          :alt="product.name"
          class="aspect-[4/3] w-full object-cover"
        >
        <div v-else class="flex aspect-[4/3] items-center justify-center text-slate-500">
          Product image
        </div>
      </div>

      <div>
        <Link v-if="product.category" :href="product.category.url" class="text-sm font-semibold uppercase tracking-wide">
          {{ product.category.name }}
        </Link>
        <h1 class="mt-3 text-4xl font-semibold text-ink">{{ product.name }}</h1>
        <p class="mt-2 text-sm text-slate-500">SKU {{ product.sku }}</p>
        <p class="mt-6 text-3xl font-semibold text-ember">${{ product.price }}</p>
        <p class="mt-6 text-lg leading-8 text-slate-600">
          {{ product.short_description || 'No short description has been added.' }}
        </p>
        <div v-if="product.long_description" class="content-prose mt-8" v-html="product.long_description" />
      </div>
    </section>

    <section v-if="product.variants.length" class="mx-auto max-w-6xl px-4 py-8 sm:px-6 lg:px-8">
      <h2 class="text-2xl font-semibold text-ink">Variants</h2>
      <div class="mt-6 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
        <ProductCard v-for="variant in product.variants" :key="variant.id" :product="variant" />
      </div>
    </section>
  </StorefrontLayout>
</template>
