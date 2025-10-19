<script setup lang="ts">
import { Head, Link, useForm, usePage } from "@inertiajs/vue3";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { Avatar, AvatarImage, AvatarFallback } from "@/components/ui/avatar";
import { Button } from "@/components/ui/button";

interface User {
    id: number;
    name: string;
    avatar: string | null;
}

interface Post {
    id: number;
    user_id: number;
    user: User;
    title: string;
    body: string;
    created_at: string;
    updated_at: string;
}

const page = usePage();
const post = page.props.post as Post;
const form = useForm({});
</script>

<template>
    <div class="container mx-auto px-4 py-8">
        <Head :title="post.title" />

        <header class="mb-6">
            <Link
                :href="route('posts.index')"
                class="text-blue-600 hover:text-blue-800"
            >
                &larr; Back to Posts
            </Link>
        </header>

        <Card class="mb-8">
            <CardHeader class="pb-3">
                <div class="flex items-center gap-4">
                    <Link :href="`/users/${post.user.id}`">
                        <Avatar class="ring-1">
                            <AvatarImage
                                :src="
                                    post.user.avatar
                                        ? `/storage/${post.user.avatar}`
                                        : '/storage/avatars/def.jpg'
                                "
                                :alt="post.user.name"
                                @error="
                                    $event.target.src = '/storage/avatars/def.jpg'
                                "
                            />
                            <AvatarFallback>{{
                                post.user.name?.charAt(0).toUpperCase()
                            }}</AvatarFallback>
                        </Avatar>
                    </Link>
                    <div class="min-w-0 flex-1">
                        <Link
                            :href="`/users/${post.user.id}`"
                            class="hover:underline"
                        >
                            <h4 class="text-sm font-semibold truncate">
                                {{ post.user.name }}
                            </h4>
                        </Link>
                        <p class="text-xs text-muted-foreground">
                            Published:
                            {{
                                new Date(
                                    post.created_at
                                ).toLocaleDateString()
                            }}
                            <span
                                v-if="post.updated_at !== post.created_at"
                            >
                                (Updated:
                                {{
                                    new Date(
                                        post.updated_at
                                    ).toLocaleDateString()
                                }})
                            </span>
                        </p>
                    </div>
                </div>

                <CardTitle class="mt-4 text-3xl">{{
                    post.title
                }}</CardTitle>
            </CardHeader>

            <CardContent class="prose prose-gray max-w-none">
                <div
                    class="text-muted-foreground whitespace-pre-line text-lg"
                >
                    {{ post.body }}
                </div>
            </CardContent>
        </Card>

        <!-- Actions -->
        <div class="flex justify-between">
            <Button
                as="Link"
                :href="route('posts.edit', post.id)"
                variant="outline"
            >
                Edit
            </Button>
            <Button 
                @click="form.delete(route('posts.destroy', post.id))"
                variant="destructive"
                :disabled="form.processing"
            >
                {{ form.processing ? 'Deleting...' : 'Delete' }}
            </Button>
        </div>
    </div>
</template>
