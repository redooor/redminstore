<script setup>
import { Head } from '@inertiajs/vue3'
import StorefrontLayout from '../Layouts/StorefrontLayout.vue'

defineProps({
  post: {
    type: Object,
    required: true,
  },
})
</script>

<template>
  <StorefrontLayout :title="post.title">
    <Head :title="post.title" />
    <article class="mx-auto max-w-3xl px-4 py-12 sm:px-6 lg:px-8">
      <p class="text-sm font-semibold uppercase tracking-wide text-ember">Post</p>
      <h1 class="mt-3 text-3xl font-semibold text-ink">{{ post.title }}</h1>
      <div class="content-prose mt-8" v-html="post.content" />
    </article>
  </StorefrontLayout>
</template>
