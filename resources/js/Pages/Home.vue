<script setup>
import PostCard from "@/components/post/PostCard.vue";
import { usePage } from "@inertiajs/vue3";
import { Head } from "@inertiajs/vue3";

const page = usePage();
const posts = page.props.posts || []; // fallback to empty array
</script>

<template>
    <Head title="Home" />

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 p-4">
        <PostCard
            v-for="post in posts"
            :key="post.id"
            :post="post"
            class="post-item"
            data-aos="fade-up"
            data-aos-duration="500"
        />
    </div>

    <div v-if="!posts.length" class="text-center text-gray-500">
        No posts found.
    </div>
</template>
