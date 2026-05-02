<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
  title: {
    type: String,
    default: 'RedminStore',
  },
})
</script>

<template>
  <div class="min-h-screen bg-stone-50">
    <header class="border-b border-stone-200 bg-white">
      <div class="mx-auto flex max-w-6xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
        <Link href="/" class="text-lg font-semibold tracking-normal text-ink">
          RedminStore
        </Link>
        <nav class="flex items-center gap-5 text-sm font-medium text-slate-700">
          <Link href="/products" class="text-slate-700 hover:text-leaf">Products</Link>
          <a href="/admin" class="text-slate-700 hover:text-leaf">Admin</a>
        </nav>
      </div>
    </header>

    <main>
      <slot />
    </main>

    <footer class="mt-16 border-t border-stone-200 bg-white">
      <div class="mx-auto max-w-6xl px-4 py-8 text-sm text-slate-500 sm:px-6 lg:px-8">
        {{ title }} is an example storefront powered by RedminPortal.
      </div>
    </footer>
  </div>
</template>
