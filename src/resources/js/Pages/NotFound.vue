<script setup>
import { Head, Link } from '@inertiajs/vue3'
import StorefrontLayout from '../Layouts/StorefrontLayout.vue'
</script>

<template>
  <StorefrontLayout title="Not found">
    <Head title="Not found" />
    <section class="mx-auto max-w-3xl px-4 py-20 text-center sm:px-6 lg:px-8">
      <p class="text-sm font-semibold uppercase tracking-wide text-ember">404</p>
      <h1 class="mt-3 text-4xl font-semibold text-ink">Page not found</h1>
      <p class="mt-4 text-lg leading-8 text-slate-600">
        The requested URL is not available in this storefront.
      </p>
      <Link
        href="/"
        class="mt-8 inline-flex items-center rounded-md bg-leaf px-5 py-3 text-sm font-semibold text-white hover:bg-emerald-800 hover:text-white"
      >
        Return home
      </Link>
    </section>
  </StorefrontLayout>
</template>
