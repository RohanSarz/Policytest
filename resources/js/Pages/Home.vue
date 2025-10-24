<script setup lang="ts">
import { ref, computed } from "vue";
import { usePage } from "@inertiajs/vue3";
import PostCard from "@/components/post/PostCard.vue";

const { posts, categories } = usePage().props;

// Track active category filter
const activeCategory = ref("all");

// Group posts by category
const postsByCategory = computed(() => {
    const map: Record<string, any[]> = {};
    categories.forEach((cat) => (map[cat.id] = []));
    posts.forEach((post) => {
        if (post.category && map[post.category.id]) {
            map[post.category.id].push(post);
        }
    });
    return map;
});

// Filtered posts based on active category
const displayedPosts = computed(() => {
    if (activeCategory.value === "all") return posts;
    return postsByCategory.value[activeCategory.value] || [];
});
</script>

<template>
    <div class="max-w-7xl mx-auto px-4 py-6">
        <!-- Filter Buttons -->
        <div class="flex flex-wrap gap-2 mb-6">
            <button
                class="px-3 py-1 rounded-md font-medium transition"
                :class="
                    activeCategory === 'all'
                        ? 'bg-green-300 text-black'
                        : 'bg-gray-200 text-gray-700'
                "
                @click="activeCategory = 'all'"
            >
                All
            </button>

            <button
                v-for="category in categories"
                :key="category.id"
                class="px-3 py-1 rounded-md font-medium transition"
                :class="
                    activeCategory === category.id
                        ? 'bg-blue-400 text-white'
                        : 'bg-gray-200 text-gray-700'
                "
                @click="activeCategory = category.id"
            >
                {{ category.name }}
            </button>
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
