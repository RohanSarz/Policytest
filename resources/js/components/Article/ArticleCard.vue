<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import { show } from "@/routes/posts";
import { Post } from "@/types/Post";

interface Props {
    post: Post;
    type?: "featured" | "regular";
}

const props = withDefaults(defineProps<Props>(), {
    type: "regular",
});
</script>

<template>
    <!-- Featured Article Card -->
    <div
        v-if="type === 'featured'"
        class="relative group overflow-hidden rounded-md shadow-sm aspect-video"
    >
        <!-- Image -->
        <img
            v-if="post.cover_image"
            :src="`/storage/${post.cover_image}`"
            :alt="post.title"
            class="w-full h-full object-cover"
        />
        <div
            v-else
            class="w-full h-full bg-gray-200 flex items-center justify-center"
        >
            <span class="text-gray-500 text-sm">No image</span>
        </div>

        <!-- Overlay -->
        <div
            class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/40 to-transparent p-6 flex items-end justify-between"
        >
            <div class="flex-1">
                <!-- Category badge -->
                <Link
                    v-if="post.category"
                    :href="`/categories/${post.category.slug}`"
                    class="inline-block px-3 py-1 text-xs font-semibold text-blue-200 bg-blue-900/50 rounded mb-2 hover:bg-blue-800/70 transition-colors"
                >
                    {{ post.category.name }}
                </Link>

                <!-- Title with animated excerpt -->
                <h3
                    class="text-white text-xl font-semibold drop-shadow-sm cursor-pointer group"
                    data-aos="fade-in"
                    data-aos-duration="600"
                >
                    <Link
                        class="hover:underline underline-offset-2"
                        :href="show(post)"
                        >{{ post.title }}</Link
                    >

                    <p
                        v-if="post.excerpt"
                        class="text-gray-200 text-sm drop-shadow-sm overflow-hidden max-h-0 opacity-0 -translate-y-2 transition-all duration-600 ease-in-out group-hover:max-h-110 group-hover:opacity-100 group-hover:translate-y-0"
                    >
                        {{ post.excerpt }}
                    </p>
                </h3>
                <!-- Author and Date -->
                <span class="text-xs text-gray-200 mt-1 block">
                    by {{ post.user.name }}, {{ post.created_for_human }}
                </span>
            </div>
            <div class="flex-shrink-0">
                <!-- Placeholder for interaction elements like bookmark, like, etc. -->
            </div>
        </div>
    </div>

    <!-- Regular Article Card -->
    <div
        v-else
        class="relative group overflow-hidden rounded-md shadow-sm aspect-video"
        data-aos="fade-up"
        data-aos-duration="500"
    >
        <!-- Image -->
        <img
            v-if="post.cover_image"
            :src="`/storage/${post.cover_image}`"
            :alt="post.title"
            class="w-full h-full object-cover"
        />
        <div
            v-else
            class="w-full h-full bg-gray-200 flex items-center justify-center"
        >
            <span class="text-gray-500 text-sm">No image</span>
        </div>

        <!-- Overlay -->
        <div
            class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent p-4 flex items-end justify-between"
        >
            <div class="flex-1">
                <!-- Category badge -->
                <Link
                    v-if="post.category"
                    :href="`/categories/${post.category.slug}`"
                    class="inline-block px-2 py-1 text-xs font-semibold text-blue-200 bg-blue-900/50 rounded mb-1 hover:bg-blue-800/70 transition-colors"
                >
                    {{ post.category.name }}
                </Link>

                <!-- Title with animated excerpt -->
                <h3
                    class="text-white text-base font-semibold drop-shadow-sm cursor-pointer group"
                    data-aos="fade-in"
                    data-aos-duration="600"
                >
                    {{ post.title }}

                    <p
                        v-if="post.excerpt"
                        class="text-gray-200 text-sm drop-shadow-sm overflow-hidden max-h-0 opacity-0 -translate-y-2 transition-all duration-600 ease-in-out group-hover:max-h-110 group-hover:opacity-100 group-hover:translate-y-0"
                    >
                        {{ post.excerpt }}
                    </p>
                </h3>
                <!-- Author and Date -->
                <span class="text-xs text-gray-200 mt-1 block">
                    by {{ post.user.name }}, {{ post.created_for_human }}
                </span>
            </div>
            <div class="flex-shrink-0">
                <!-- Placeholder for interaction elements like bookmark, like, etc. -->
            </div>
        </div>
    </div>
</template>
