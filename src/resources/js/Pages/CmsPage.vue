<script setup>
import { Head } from '@inertiajs/vue3'
import StorefrontLayout from '../Layouts/StorefrontLayout.vue'

defineProps({
  page: {
    type: Object,
    required: true,
  },
})
</script>

<template>
  <StorefrontLayout :title="page.title">
    <Head :title="page.title" />
    <article class="mx-auto max-w-3xl px-4 py-12 sm:px-6 lg:px-8">
      <h1 class="text-3xl font-semibold text-ink">{{ page.title }}</h1>
      <div class="content-prose mt-8" v-html="page.content" />
    </article>
  </StorefrontLayout>
</template>
