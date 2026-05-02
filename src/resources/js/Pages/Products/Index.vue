<script setup>
import { Head, Link, router } from '@inertiajs/vue3'
import StorefrontLayout from '../../Layouts/StorefrontLayout.vue'
import Pagination from '../Partials/Pagination.vue'
import ProductCard from '../Partials/ProductCard.vue'

const props = defineProps({
  products: {
    type: Object,
    required: true,
  },
  categories: {
    type: Array,
    default: () => [],
  },
  filters: {
    type: Object,
    default: () => ({}),
  },
})

function changeCategory(event) {
  const category = event.target.value

  router.get('/products', category ? { category } : {}, {
    preserveState: true,
    replace: true,
  })
}
</script>

<template>
  <StorefrontLayout title="Products">
    <Head title="Products" />

    <section class="mx-auto max-w-6xl px-4 py-12 sm:px-6 lg:px-8">
      <div class="flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">
        <div>
          <p class="text-sm font-semibold uppercase tracking-wide text-ember">Catalog</p>
          <h1 class="mt-2 text-3xl font-semibold text-ink">Products</h1>
          <p class="mt-2 text-slate-600">Active products managed in RedminPortal.</p>
        </div>

        <label class="block text-sm font-medium text-slate-700">
          Category
          <select
            class="mt-2 w-full rounded-md border border-stone-300 bg-white px-3 py-2 text-sm shadow-sm focus:border-leaf focus:outline-none focus:ring-2 focus:ring-leaf/20 sm:w-64"
            :value="filters.category || ''"
            @change="changeCategory"
          >
            <option value="">All categories</option>
            <option v-for="category in categories" :key="category.id" :value="category.id">
              {{ category.name }}
            </option>
          </select>
        </label>
      </div>

      <div class="mt-8 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
        <ProductCard v-for="product in products.data" :key="product.id" :product="product" />
      </div>

      <div v-if="products.data.length === 0" class="mt-8 rounded-md border border-dashed border-stone-300 p-8 text-center text-slate-500">
        No active products match this filter.
      </div>

      <div class="mt-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <p class="text-sm text-slate-500">
          Showing {{ products.meta.from || 0 }} to {{ products.meta.to || 0 }} of {{ products.meta.total }} products
        </p>
        <Pagination :links="products.links" />
      </div>

      <Link href="/" class="mt-8 inline-flex text-sm font-semibold">Back home</Link>
    </section>
  </StorefrontLayout>
</template>
