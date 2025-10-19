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
import { TransitionGroup } from "vue";

const page = usePage();

const posts = page.props.posts;
console.log(posts);
</script>

<template>
    <Head title="Home" />

    <div class="grid grid-cols-2 place-items-center space-y-4 py-4">
        <PostCard
            v-for="post in posts"
            :key="post.id"
            :post="post"
            class="post-item"
            data-aos="zoom-in-up"
            data-aos-duration="500"
        />
    </div>
</template>
