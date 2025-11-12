<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import { index as postsIndex } from "@/routes/posts";
import { show as categoryShow } from "@/routes/categories";
import { Category } from "@/types/Post";

interface Props {
  categories: Category[];
  activeCategory?: string | null;
}

const props = withDefaults(defineProps<Props>(), {
  activeCategory: null,
});
</script>

<template>
  <div class="bg-gray-50 py-3 px-2 overflow-x-auto">
    <div class="flex space-x-1 md:space-x-2">
      <Link
        :href="postsIndex().url"
        :class="[
          'px-3 py-1.5 rounded-full text-sm font-medium whitespace-nowrap',
          { 'bg-blue-600 text-white': !activeCategory },
          { 'bg-gray-200 text-gray-700 hover:bg-gray-300': activeCategory }
        ]"
      >
        All News
      </Link>

      <Link
        v-for="category in categories"
        :key="category.id"
        :href="categoryShow(category.slug)"
        :class="[
          'px-3 py-1.5 rounded-full text-sm font-medium whitespace-nowrap',
          { 'bg-blue-600 text-white': activeCategory === category.slug },
          { 'bg-gray-200 text-gray-700 hover:bg-gray-300': activeCategory !== category.slug }
        ]"
      >
        {{ category.name }}
      </Link>
    </div>
  </div>
</template>