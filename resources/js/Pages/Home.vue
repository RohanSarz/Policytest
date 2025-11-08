<script setup lang="ts">
import { computed } from "vue";
import { usePage, Link } from "@inertiajs/vue3";
import PostCard from "@/components/post/PostCard.vue";
import Separator from "@/components/ui/separator/Separator.vue";
import PostTitle from "@/components/post/PostTitle.vue";

const page = usePage().props;

const categories = computed(() => page.categories);
const posts = computed(() => page.posts);
const allPosts = computed(() => page.allPosts);
const livePosts = computed(() => page.livePosts);
const featCategoryPosts = computed(() => page.featCategoryPosts);
const currentPath = computed(() => window.location.pathname);

function isActiveCategory(slug: string) {
    route.current()
    if (slug === "all") {
        return cleanPath === "/posts";
    }
    return cleanPath === `/categories/${slug}`;
}

const CustomSection = "Politics";
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
                        'bg-blue-500 text-white': isActiveCategory(
                            category.slug,
                        ),
                        'bg-gray-200 text-gray-700 hover:bg-gray-300':
                            !isActiveCategory(category.slug),
                    }"
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
                    :key="post?.id"
                    :post="post"
                />
                <div
                    v-if="allPosts.length === 0"
                    class="col-span-full text-center text-gray-500 mt-6"
                >
                    No posts in this category.
                </div>
            </div>
            <!-- A custom section for news set by admin -->
            <div class="">
                <h2 class="text-lg font-semibold text-center px-4 py-4">
                    {{ CustomSection }}
                    <sup
                        class="text-xs border rounded-2xl p-1 opacity-40 bg-red-500 text-yellow-300"
                        >Hot</sup
                    >
                </h2>
                <div class="grid grid-cols-2 grid-rows-3">
                    <div
                        v-for="(post, id) in featCategoryPosts"
                        :key="post.id"
                        class="border-b px-2 py-2"
                    >
                        <PostCard
                            class="hover:underline"
                            type="title"
                            :post="post"
                        />
                    </div>
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
    {{ allPosts }}
</template>
