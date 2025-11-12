<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import { show } from "@/routes/posts";
import { Post } from "@/types/Post";

interface Props {
  posts: Post[];
}

const props = defineProps<Props>();

const formatDate = (dateString: string) => {
  const date = new Date(dateString);
  return date.toLocaleDateString('en-US', { 
    month: 'short', 
    day: 'numeric' 
  });
};
</script>

<template>
  <div class="bg-white rounded-xl shadow-sm p-6">
    <h3 class="text-lg font-bold text-gray-900 mb-4">Trending Now</h3>
    
    <div v-if="posts.length === 0" class="text-center py-4 text-gray-500">
      No trending posts at the moment.
    </div>
    
    <div v-else class="space-y-4">
      <div 
        v-for="(post, index) in posts" 
        :key="post.id" 
        class="flex items-start"
      >
        <div class="flex-shrink-0 w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold mr-3">
          {{ index + 1 }}
        </div>
        
        <div class="flex-1 min-w-0">
          <h4 class="font-bold text-sm mb-1 line-clamp-2">
            <Link :href="show(post.slug)" class="text-gray-900 hover:text-blue-700">
              {{ post.title }}
            </Link>
          </h4>
          <p class="text-xs text-gray-500">
            {{ formatDate(post.created_at) }}
          </p>
        </div>
      </div>
    </div>
  </div>
</template>