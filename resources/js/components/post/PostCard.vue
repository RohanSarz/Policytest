<script setup>
import { Link } from "@inertiajs/vue3";
import { Avatar, AvatarImage, AvatarFallback } from "@/components/ui/avatar";
import Badge from "@/components/ui/badge/Badge.vue";

const props = defineProps({
    post: {
        type: Object,
        required: true,
    },
    type: {
        type: String,
        default: "none", // Options: "title" | "none"
    },
});
</script>

<template>
    <!-- Title-only mode: displays short title + author -->
    <div v-if="type === 'title'" class="text-sm font-medium text-gray-800">

        {{
            `${props.post.title.split(" ").slice(0, 10).join(" ")}... | ${
                props.post.user?.name || "Unknown"
            }`
        }}
    </div>

    <!-- Thumbnail mode: image with floating title -->
    <div
        v-else
        class="relative w-full max-w-sm aspect-video overflow-hidden rounded-lg shadow-sm"
        data-aos="zoom-in-up"
        data-aos-duration="500"
    >
        <!-- Post thumbnail image -->
        <img
            v-if="props.post.image"
            :src="`/storage/${props.post.image}`"
            :alt="props.post.title"
            class="w-full h-full object-cover"
        />
        <div
            v-else
            class="w-full h-full bg-gray-100 flex items-center justify-center"
        >
            <span class="text-gray-400 text-xs">No image</span>
        </div>

        <!-- Floating title over image -->
        <div
            class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-3"
        >
            <h3 class="text-white text-sm font-semibold line-clamp-2">
                {{ props.post.category_id }} |||
                {{ props.post.title }}
            </h3>
        </div>
    </div>
</template>
