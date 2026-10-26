<script setup>
import { Head, Link } from '@inertiajs/vue3'
import StorefrontLayout from '../../Layouts/StorefrontLayout.vue'
import ProductCard from '../Partials/ProductCard.vue'

defineProps({
  category: {
    type: Object,
    required: true,
  },
  products: {
    type: Array,
    default: () => [],
  },
  bundles: {
    type: Array,
    default: () => [],
  },
})
</script>

<template>
  <StorefrontLayout :title="category.name">
    <Head :title="category.name" />

    <section class="bg-white">
      <div class="mx-auto max-w-6xl px-4 py-12 sm:px-6 lg:px-8">
        <Link href="/products" class="text-sm font-semibold">All products</Link>
        <h1 class="mt-3 text-4xl font-semibold text-ink">{{ category.name }}</h1>
        <p v-if="category.short_description" class="mt-4 max-w-3xl text-lg leading-8 text-slate-600">
          {{ category.short_description }}
        </p>
        <div v-if="category.long_description" class="content-prose mt-6 max-w-3xl" v-html="category.long_description" />
      </div>
    </section>

    <section class="mx-auto max-w-6xl px-4 py-10 sm:px-6 lg:px-8">
      <h2 class="text-2xl font-semibold text-ink">Products</h2>
      <div class="mt-6 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
        <ProductCard v-for="product in products" :key="product.id" :product="product" />
      </div>
      <p v-if="products.length === 0" class="mt-6 rounded-md border border-dashed border-stone-300 p-6 text-slate-500">
        No active products are in this category.
      </p>
    </section>

    <section v-if="bundles.length" class="mx-auto max-w-6xl px-4 py-10 sm:px-6 lg:px-8">
      <h2 class="text-2xl font-semibold text-ink">Bundles</h2>
      <div class="mt-6 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
        <article v-for="bundle in bundles" :key="bundle.id" class="rounded-lg border border-stone-200 bg-white p-5">
          <h3 class="text-base font-semibold text-ink">{{ bundle.name }}</h3>
          <p class="mt-1 text-sm font-semibold text-ember">${{ bundle.price }}</p>
          <p class="mt-3 text-sm leading-6 text-slate-600">{{ bundle.short_description }}</p>
        </article>
      </div>
    </section>
  </StorefrontLayout>
</template>
