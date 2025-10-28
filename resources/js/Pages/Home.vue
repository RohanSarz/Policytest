<script setup lang="ts">
import { computed } from "vue";
import { usePage, Link } from "@inertiajs/vue3";
import PostCard from "@/components/post/PostCard.vue";

const page = usePage().props;

const categories = computed(() => page.categories);
const posts = computed(() => page.posts);

const currentPath = computed(() => window.location.pathname);

function isActiveCategory(slug: string) {
    return (
        currentPath.value.endsWith(slug) ||
        (slug === "all" && currentPath.value === "/posts")
    );
}

const displayedPosts = computed(() => {
    if (isActiveCategory("all")) return posts.value;

    return posts.value.filter(
        (post) => post.category?.slug === currentPath.value.split("/").pop(),
    );
});
</script>

<template>
    <div class="max-w-7xl mx-auto px-4 py-6">
        <!-- Category Links -->
        <div class="flex flex-wrap gap-2 mb-6">
            <Link
                :href="route('posts.index')"
                class="px-3 py-1 rounded-md font-medium"
                :class="{
                    'bg-blue-500 text-white': isActiveCategory('all'),
                    'bg-gray-200 text-gray-700 hover:bg-gray-300':
                        !isActiveCategory('all'),
                }"
            >
                All
            </Link>

            <Link
                v-for="category in categories"
                :key="category.slug"
                :href="route('categories.show', category.slug)"
                class="px-3 py-1 rounded-md font-medium"
                :class="{
                    'bg-blue-500 text-white': isActiveCategory(category.slug),
                    'bg-gray-200 text-gray-700 hover:bg-gray-300':
                        !isActiveCategory(category.slug),
                }"
            >
                {{ category.name }}
            </Link>
        </div>

        <!-- Posts Grid -->
        <div
            class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6"
        >
            <PostCard
                v-for="post in displayedPosts"
                :key="post.id"
                :post="post"
            />
            <div
                v-if="displayedPosts.length === 0"
                class="col-span-full text-center text-gray-500 mt-6"
            >
                No posts in this category.
            </div>
        </div>
    </div>
</template>
