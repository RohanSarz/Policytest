<script setup lang="ts">
import { usePage } from "@inertiajs/vue3";
import { Post } from "@/types/Post"; // Import the shared Post type

// Define props interface for the component
interface Props {
  post: Post;  // The post object to display
}

// Get page instance from Inertia
const page = usePage();

// Define the props with type
const { post } = defineProps<Props>();
</script>

<template>
    {{ post.title }}
</template>
