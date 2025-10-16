<script setup lang="ts">
import {
    Card,
    CardContent,
    CardDescription,
    CardFooter,
    CardHeader,
    CardTitle,
} from "@/components/ui/card";
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";
import { Link } from "@inertiajs/vue3";

interface User {
    id: number;
    name: string;
    avatar: string;
}

interface Post {
    id: number;
    user: User;
    title: string;
    description: string;
    content: string;
    created_at: string;
    updated_at: string;
}

defineProps<{
    post: Post;
}>();
</script>

<template>
    <div class="max-w-lg min-w-md px-2">
        <Card>
            <CardHeader class="pb-3">
                <div class="flex items-center space-x-4">
                    <Link :href="`/users/${post.user.id}`">
                        <Avatar class="ring-1">
                            <AvatarImage
                                class="border"
                                :src="`storage/${post.user.avatar}`"
                                :alt="post.user.name"
                            />
                            <AvatarFallback>
                                {{ post.user.name.charAt(0).toUpperCase() }}
                            </AvatarFallback>
                        </Avatar>
                    </Link>
                    <div class="flex-1 min-w-0">
                        <Link
                            :href="`/users/${post.user.id}`"
                            class="hover:underline"
                        >
                            <h4 class="text-sm font-semibold truncate">
                                {{ post.user.name }}
                            </h4>
                        </Link>
                        <p class="text-xs text-muted-foreground">
                            {{ new Date(post.created_at).toLocaleDateString() }}
                        </p>
                    </div>
                </div>

                <CardTitle class="mt-2">{{ post.title }}</CardTitle>
                <CardDescription class="line-clamp-2">{{
                    post.description
                }}</CardDescription>
            </CardHeader>
            <CardContent class="pb-3">
                <p class="line-clamp-3 text-sm text-muted-foreground">
                    {{ post.content }}
                </p>
            </CardContent>
            <CardFooter class="flex justify-between">
                <Link
                    :href="`/posts/${post.id}`"
                    class="text-sm font-medium hover:underline"
                >
                    Read more
                </Link>
            </CardFooter>
        </Card>
    </div>
</template>
