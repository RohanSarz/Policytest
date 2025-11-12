<script setup lang="ts">
import { Post } from "@/types/Post";
import ArticleMeta from "@/components/Article/ArticleMeta.vue";
import SocialShare from "@/components/Article/SocialShare.vue";

interface Props {
    post: Post;
}

const props = defineProps<Props>();
</script>

<template>
    <article class="mb-8">
        <div class="mb-4">
            <Link
                v-if="post.category"
                :href="`/categories/${post.category.slug}`"
                class="inline-block px-3 py-1 text-sm font-semibold text-blue-700 bg-blue-100 rounded-full hover:bg-blue-200 transition-colors"
            >
                {{ post.category.name }}
            </Link>
        </div>

        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
            {{ post.title }}
        </h1>

        <ArticleMeta :post="post" :show-reading-time="true" class="mb-6" />

        <div class="flex justify-end">
            <SocialShare :title="post.title" :url="`/posts/${post.slug}`" />
        </div>
    </article>
</template>
