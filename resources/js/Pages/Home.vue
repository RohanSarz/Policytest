<script setup lang="ts">
import CreateButton from "@/components/post/CreateButton.vue";
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

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 p-4">
        <PostCard
            v-for="post in posts"
            :key="post.id"
            :post="post"
            class="post-item"
            data-aos="zoom-in-up"
            data-aos-duration="500"
        />
        <CreateButton />
    </div>
</template>
