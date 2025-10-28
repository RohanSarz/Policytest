<script setup>
import { Link } from "@inertiajs/vue3";
import {
    Card,
    CardHeader,
    CardTitle,
    CardContent,
    CardFooter,
} from "@/components/ui/card";
import { Avatar, AvatarImage, AvatarFallback } from "@/components/ui/avatar";
import Badge from "@/components/ui/badge/Badge.vue";

const props = defineProps({
    post: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <Card
        v-if="props.post"
        class="flex flex-col w-full max-w-sm h-auto overflow-hidden border-0 rounded-lg shadow-sm transition hover:shadow-md"
        data-aos="zoom-in-up"
        data-aos-duration="500"
    >
        <!-- 🖼️ Post Image -->
        <div
            class="relative w-full"
            style="aspect-ratio: 16 / 9; overflow: hidden"
        >
            <img
                v-if="props.post.image"
                :src="`/storage/${props.post.image}`"
                :alt="props.post.title"
                class="w-full h-full object-cover"
            />
            <div
                v-else
                class="flex items-center justify-center h-full text-gray-400 text-xs"
            >
                No image
            </div>
        </div>

        <CardHeader class="pb-1 pt-2 px-3">
            <div v-if="props.post.user" class="flex items-center gap-2">
                <Link :href="`/users/${props.post.user.id}`">
                    <Avatar class="ring-1 w-7 h-7">
                        <AvatarImage
                            :src="
                                props.post.user.avatar
                                    ? `/storage/${props.post.user.avatar}`
                                    : '/storage/avatars/def.jpg'
                            "
                            :alt="props.post.user.name"
                            class="object-cover object-top"
                        />
                        <AvatarFallback>
                            {{ props.post.user.name?.charAt(0).toUpperCase() }}
                        </AvatarFallback>
                    </Avatar>
                </Link>
                <div class="min-w-0 flex-1">
                    <Link
                        :href="`/users/${props.post.user.id}`"
                        class="hover:underline"
                    >
                        <h4 class="text-sm font-semibold truncate">
                            {{ props.post.user.name }}
                        </h4>
                    </Link>
                    <p class="text-[10px] text-gray-500">
                        {{ props.post.created_at_human }}
                    </p>
                </div>
            </div>

            <CardTitle class="text-base mt-1 line-clamp-2">
                {{ props.post.title }}
            </CardTitle>
        </CardHeader>

        <CardContent class="px-3 py-1">
            <p class="text-xs text-gray-600 line-clamp-4">
                {{ props.post.body || "No description." }}
            </p>
        </CardContent>

        <CardFooter class="flex justify-between items-center px-3 py-1 text-xs">
            <Link
                :href="`/posts/${props.post.slug}`"
                class="font-medium text-gray-500 hover:text-black"
            >
                Read more
            </Link>
            <Link :href="route('categories.show', props.post.category?.slug)">
                <Badge class="font-medium px-1 py-0 text-[10px]">
                    {{ props.post.category?.name || "Uncategorized" }}
                </Badge>
            </Link>
        </CardFooter>
    </Card>
</template>
