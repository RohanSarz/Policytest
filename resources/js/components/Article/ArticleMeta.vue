<script setup lang="ts">
import { Post } from "@/types/Post";
import Badge from "../ui/badge/Badge.vue";
import Label from "../ui/label/Label.vue";

interface Props {
    post: Post;
    showAuthor?: boolean;
    showDate?: boolean;
    showCategory?: boolean;
    showReadingTime?: boolean;
}

const props = withDefaults(defineProps<Props>(), {
    showAuthor: true,
    showDate: true,
    showCategory: true,
    showReadingTime: false,
});

const formatDate = (dateString: string) => {
    const date = new Date(dateString);
    return date.toLocaleString("en-US", {
        month: "short",
        day: "numeric",
        year: "numeric",
        hour: "2-digit",
        minute: "2-digit",
    });
};
</script>

<template>
    <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600">
        <div v-if="showAuthor" class="flex items-center">
            <Link href="">
                <Label>By {{ post.user.name }}</Label>
            </Link>
        </div>

        <div v-if="showDate" class="flex items-center">
            <span>{{ formatDate(post.created_at) }}</span>
        </div>

        <div v-if="showReadingTime" class="flex items-center">
            <span>5 min read</span>
        </div>
    </div>
</template>
