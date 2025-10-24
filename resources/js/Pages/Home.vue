<script setup lang="ts">
import { ref, computed } from "vue";
import { usePage } from "@inertiajs/vue3";
import PostCard from "@/components/post/PostCard.vue";
import { Tabs, TabsList, TabsTrigger, TabsContent } from "@/components/ui/tabs";

const { posts, categories } = usePage().props;

// Track active tab
const activeTab = ref("all");

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

// Filter posts based on active tab
const displayedPosts = computed(() => {
    if (activeTab.value === "all") return posts;
    return postsByCategory.value[activeTab.value] || [];
});
</script>

<template>
    <div class="max-w-7xl mx-auto p-4">
        <Tabs
            default-value="all"
            v-model:active-value="activeTab"
            class="rounded-2xl border p-4"
        >
            <TabsList>
                <TabsTrigger value="all">All</TabsTrigger>
                <TabsTrigger
                    v-for="category in categories"
                    :key="category.id"
                    :value="category.id"
                >
                    {{ category.name }}
                </TabsTrigger>
            </TabsList>

            <TabsContent
                value="all"
                class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-4"
            >
                <PostCard v-for="post in posts" :key="post.id" :post="post" />
            </TabsContent>

            <TabsContent
                v-for="category in categories"
                :key="category.id"
                :value="category.id"
                class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-4"
            >
                <PostCard
                    v-for="post in postsByCategory[category.id]"
                    :key="post.id"
                    :post="post"
                />
                <div
                    v-if="postsByCategory[category.id].length === 0"
                    class="col-span-full text-center text-gray-500 mt-6"
                >
                    No posts in this category.
                </div>
            </TabsContent>
        </Tabs>
    </div>
</template>
