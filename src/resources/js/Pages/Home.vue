<script setup>
import { Head, Link } from '@inertiajs/vue3'
import StorefrontLayout from '../Layouts/StorefrontLayout.vue'
import ProductCard from './Partials/ProductCard.vue'

defineProps({
  featuredProducts: {
    type: Array,
    default: () => [],
  },
  pages: {
    type: Array,
    default: () => [],
  },
  posts: {
    type: Array,
    default: () => [],
  },
})
</script>

<template>
  <StorefrontLayout title="RedminStore">
    <Head title="Storefront" />

    <section class="bg-white">
      <div class="mx-auto grid max-w-6xl gap-8 px-4 py-12 sm:px-6 lg:grid-cols-[1.2fr_0.8fr] lg:px-8">
        <div>
          <p class="text-sm font-semibold uppercase tracking-wide text-ember">Laravel 12 storefront theme</p>
          <h1 class="mt-3 text-4xl font-semibold tracking-normal text-ink sm:text-5xl">
            A modern RedminPortal ecommerce front.
          </h1>
          <p class="mt-5 max-w-2xl text-lg leading-8 text-slate-600">
            Use this package as a practical starting point for catalog pages, CMS content, and product discovery.
          </p>
          <Link
            href="/products"
            class="mt-7 inline-flex items-center rounded-md bg-leaf px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-emerald-800 hover:text-white"
          >
            Browse products
          </Link>
        </div>
        <div class="rounded-lg border border-stone-200 bg-mist p-6">
          <h2 class="text-base font-semibold text-ink">Content managed in RedminPortal</h2>
          <div class="mt-5 grid gap-5 sm:grid-cols-2 lg:grid-cols-1">
            <div>
              <h3 class="text-sm font-semibold uppercase tracking-wide text-slate-500">Pages</h3>
              <ul class="mt-3 space-y-2">
                <li v-for="page in pages" :key="page.id">
                  <Link :href="page.url">{{ page.title }}</Link>
                </li>
              </ul>
            </div>
            <div>
              <h3 class="text-sm font-semibold uppercase tracking-wide text-slate-500">Posts</h3>
              <ul class="mt-3 space-y-2">
                <li v-for="post in posts" :key="post.id">
                  <Link :href="post.url">{{ post.title }}</Link>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="mx-auto max-w-6xl px-4 py-12 sm:px-6 lg:px-8">
      <div class="flex items-end justify-between gap-4">
        <div>
          <h2 class="text-2xl font-semibold text-ink">Featured products</h2>
          <p class="mt-2 text-slate-600">Active featured products from the RedminPortal catalog.</p>
        </div>
        <Link href="/products" class="hidden text-sm font-semibold sm:inline">View all</Link>
      </div>
      <div class="mt-6 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
        <ProductCard v-for="product in featuredProducts" :key="product.id" :product="product" />
      </div>
      <p v-if="featuredProducts.length === 0" class="mt-6 rounded-md border border-dashed border-stone-300 p-6 text-slate-500">
        No featured products are active yet.
      </p>
    </section>
  </StorefrontLayout>
</template>
