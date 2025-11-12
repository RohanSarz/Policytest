<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import { show } from "@/routes/posts";
import { Post } from "@/types/Post";

interface Props {
  previousPost?: Post;
  nextPost?: Post;
}

const props = defineProps<Props>();
</script>

<template>
  <div class="flex justify-between items-center py-6 border-t border-b border-gray-200 my-8">
    <div 
      v-if="previousPost" 
      class="w-2/5"
    >
      <p class="text-sm text-gray-500 mb-1">Previous Article</p>
      <Link 
        :href="show(previousPost.slug)" 
        class="text-blue-700 hover:text-blue-800 font-medium line-clamp-2"
      >
        {{ previousPost.title }}
      </Link>
    </div>
    
    <div 
      v-if="!previousPost" 
      class="w-2/5 opacity-50"
    >
      <p class="text-sm text-gray-500">Previous Article</p>
      <span class="text-gray-400">No previous article</span>
    </div>
    
    <div 
      v-if="nextPost" 
      class="w-2/5 text-right"
    >
      <p class="text-sm text-gray-500 mb-1">Next Article</p>
      <Link 
        :href="show(nextPost.slug)" 
        class="text-blue-700 hover:text-blue-800 font-medium line-clamp-2"
      >
        {{ nextPost.title }}
      </Link>
    </div>
    
    <div 
      v-if="!nextPost" 
      class="w-2/5 text-right opacity-50"
    >
      <p class="text-sm text-gray-500">Next Article</p>
      <span class="text-gray-400">No next article</span>
    </div>
  </div>
</template>