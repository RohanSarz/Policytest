<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import { show } from "@/routes/posts";
import { Post } from "@/types/Post";

interface Props {
  post: Post;
  type?: 'featured' | 'regular' | 'thumbnail';
}

const props = withDefaults(defineProps<Props>(), {
  type: 'regular',
});

const formatDate = (dateString: string) => {
  const date = new Date(dateString);
  return date.toLocaleDateString('en-US', { 
    month: 'short', 
    day: 'numeric', 
    year: 'numeric' 
  });
};
</script>

<template>
  <!-- Featured Article Card -->
  <div
    v-if="type === 'featured'"
    class="relative group overflow-hidden rounded-xl bg-white shadow-md hover:shadow-lg transition-shadow duration-300"
    data-aos="fade-up"
    data-aos-duration="500"
  >
    <!-- Image container -->
    <div class="aspect-video overflow-hidden">
      <img
        v-if="post.cover_image"
        :src="`/storage/${post.cover_image}`"
        :alt="post.title"
        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
      />
      <div
        v-else
        class="w-full h-full bg-gray-100 flex items-center justify-center"
      >
        <span class="text-gray-400 text-sm">No image</span>
      </div>
    </div>

    <!-- Content overlay -->
    <div class="p-6">
      <!-- Category badge -->
      <Link
        v-if="post.category"
        :href="`/categories/${post.category.slug}`"
        class="inline-block px-3 py-1 text-xs font-semibold text-blue-700 bg-blue-100 rounded-full mb-2 hover:bg-blue-200 transition-colors"
      >
        {{ post.category.name }}
      </Link>

      <!-- Title -->
      <h3 class="text-xl font-bold mb-2 line-clamp-2">
        <Link :href="show(post.slug)" class="text-gray-900 hover:text-blue-700 transition-colors">
          {{ post.title }}
        </Link>
      </h3>

      <!-- Excerpt -->
      <p class="text-gray-600 text-sm mb-3 line-clamp-3">
        {{ post.excerpt }}
      </p>

      <!-- Meta info -->
      <div class="flex items-center text-xs text-gray-500">
        <span class="flex items-center mr-4">
          <span class="mr-1">{{ post.user.name }}</span>
        </span>
        <span class="flex items-center">
          <span>{{ formatDate(post.created_at) }}</span>
        </span>
      </div>
    </div>
  </div>

  <!-- Regular Article Card -->
  <div
    v-else-if="type === 'regular'"
    class="flex flex-col md:flex-row gap-4 group overflow-hidden rounded-xl bg-white shadow-sm hover:shadow-md transition-shadow duration-300 p-4"
    data-aos="fade-up"
    data-aos-duration="500"
  >
    <!-- Image -->
    <div class="md:w-2/5 flex-shrink-0">
      <div class="aspect-video overflow-hidden rounded-lg">
        <img
          v-if="post.cover_image"
          :src="`/storage/${post.cover_image}`"
          :alt="post.title"
          class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
        />
        <div
          v-else
          class="w-full h-full bg-gray-100 flex items-center justify-center rounded-lg"
        >
          <span class="text-gray-400 text-xs">No image</span>
        </div>
      </div>
    </div>

    <!-- Content -->
    <div class="flex-1">
      <!-- Category badge -->
      <Link
        v-if="post.category"
        :href="`/categories/${post.category.slug}`"
        class="inline-block px-2 py-1 text-xs font-semibold text-blue-700 bg-blue-100 rounded mb-2 hover:bg-blue-200 transition-colors"
      >
        {{ post.category.name }}
      </Link>

      <!-- Title -->
      <h3 class="text-lg font-bold mb-2 line-clamp-2">
        <Link :href="show(post.slug)" class="text-gray-900 hover:text-blue-700 transition-colors">
          {{ post.title }}
        </Link>
      </h3>

      <!-- Excerpt -->
      <p class="text-gray-600 text-sm mb-3 line-clamp-2">
        {{ post.excerpt }}
      </p>

      <!-- Meta info -->
      <div class="flex items-center text-xs text-gray-500">
        <span class="flex items-center mr-4">
          <span class="mr-1">{{ post.user.name }}</span>
        </span>
        <span class="flex items-center">
          <span>{{ formatDate(post.created_at) }}</span>
        </span>
      </div>
    </div>
  </div>

  <!-- Thumbnail Article Card -->
  <div
    v-else
    class="group overflow-hidden rounded-lg bg-white shadow-sm hover:shadow-md transition-shadow duration-300"
    data-aos="fade-up"
    data-aos-duration="500"
  >
    <div class="aspect-video overflow-hidden">
      <img
        v-if="post.cover_image"
        :src="`/storage/${post.cover_image}`"
        :alt="post.title"
        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
      />
      <div
        v-else
        class="w-full h-full bg-gray-100 flex items-center justify-center"
      >
        <span class="text-gray-400 text-xs">No image</span>
      </div>
    </div>

    <div class="p-3">
      <!-- Category badge for thumbnail -->
      <Link
        v-if="post.category"
        :href="`/categories/${post.category.slug}`"
        class="inline-block px-2 py-1 text-xs font-semibold text-blue-700 bg-blue-100 rounded mb-1 hover:bg-blue-200 transition-colors"
      >
        {{ post.category.name }}
      </Link>
      
      <h3 class="text-base font-bold mb-1 line-clamp-2">
        <Link :href="show(post.slug)" class="text-gray-900 hover:text-blue-700 transition-colors">
          {{ post.title }}
        </Link>
      </h3>

      <div class="flex items-center text-xs text-gray-500 mt-2">
        <span>{{ formatDate(post.created_at) }}</span>
      </div>
    </div>
  </div>
</template>