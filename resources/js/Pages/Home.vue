<script setup lang="ts">
import PostCard from "@/components/post/PostCard.vue";
import { usePage } from "@inertiajs/vue3";
import { Head } from "@inertiajs/vue3";
import {
    ToastAction,
    ToastClose,
    ToastDescription,
    ToastProvider,
    ToastRoot,
    ToastTitle,
    ToastViewport,
} from "radix-vue";
import { computed } from "vue";

const { posts } = usePage().props;
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
</template>
