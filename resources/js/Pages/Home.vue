<script setup lang="ts">
import { computed } from "vue";
import { usePage, Link, usePoll } from "@inertiajs/vue3";
import PostCard from "@/components/post/PostCard.vue";
import Separator from "@/components/ui/separator/Separator.vue";
import PostTitle from "@/components/post/PostTitle.vue";
import { PageProps } from "@/types/Post"; // Import the shared types

// Get page props from Inertia
const page = usePage<PageProps>().props; // Type the page props

// Extract data from page props
const posts = page.posts; // Array of posts
const categories = page.categories; // Array of categories
const currentCategory = page.currentCategory; // Current category if on a category page
const livePosts = page.livePosts; // Live posts

// Fix undefined variables by defining them
const allPosts = posts || []; // Fallback to empty array if posts is undefined

usePoll(2000); // Auto-refresh data every 2 seconds

// Compute active category slug for highlighting active link
const activeCategorySlug = currentCategory?.slug || null;
</script>

<template>
    <div
        class="max-w-7xl h-[100vh] mx-auto px-4 py-8 sm:px-6 lg:px-8 grid grid-cols-12 grid-rows-2 gap-4"
    >
        <!-- Category Section-->
        <div class="col-span-7">
            <!-- Category Links -->
            <div class="flex flex-wrap gap-2 mb-6">
                <Link
                    :href="route('posts.index')"
                    :class="[
                        'px-3 py-1 rounded-md font-medium',
                        { 'bg-gray-200': !activeCategorySlug },
                    ]"
                >
                    All
                </Link>

                <Link
                    v-for="category in categories"
                    :key="category.id"
                    :href="route('categories.show', category.slug)"
                    :class="[
                        'px-3 py-1 rounded-md font-medium',
                        { 'bg-gray-200': activeCategorySlug === category.slug },
                    ]"
                >
                    {{ category.name }}
                </Link>
            </div>

            <!-- Posts Grid -->
            <div
                class="py-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6"
            >
                <PostCard
                    v-for="post in allPosts"
                    :key="post.id"
                    :post="post"
                />
                <div
                    v-if="allPosts.length === 0"
                    class="col-span-full text-center text-gray-500 mt-6"
                >
                    No posts in this category.
                </div>
            </div>
        </div>
        <!-- Live News Section-->

        <div class="col-span-5 row-span-6 border-l h-auto">
            <h1 class="text-center font-semibold py-8">Live News</h1>

            <div class="flex flex-col gap-6 justify-center px-6">
                <div
                    v-for="post in livePosts"
                    :key="post.id"
                    class="hover:underline underline-offset-3"
                >
                    <PostTitle :post="post" />
                </div>
            </div>
        </div>
    </div>
</template>
