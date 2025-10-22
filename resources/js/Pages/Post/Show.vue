<script setup lang="ts">
import { Form, usePage } from "@inertiajs/vue3";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";
import { Button } from "@/components/ui/button";
import UserNameUpper from "@/components/userDataComponents/UserNameUpper.vue";
import { computed } from "vue";

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
const { can } = page.props;

const canEdit = computed(() => can.includes("edit-posts"));
const canDelete = computed(() => can.includes("delete-posts"));
</script>

<template>
    <div>
        <Head :title="post.title" />

        <header class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">
                            {{ post.title.toUpperCase() }}
                        </h1>
                    </div>
                    <div>
                        <Link
                            :href="route('posts.index')"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
                        >
                            Back to Posts
                        </Link>
                    </div>
                </div>
            </div>
        </header>

        <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <Card class="mb-8">
                <CardHeader class="pb-3">
                    <div class="flex items-center space-x-4">
                        <Link :href="`/users/${post.user.id}`">
                            <Avatar class="ring-1">
                                <AvatarImage
                                    class="border"
                                    :src="
                                        post.user.avatar
                                            ? `/storage/${post.user.avatar}`
                                            : '/storage/avatars/def.jpg'
                                    "
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
                        class="text-muted-foreground whitespace-pre-wrap break-words text-lg"
                    >
                        {{ post.body }}
                    </div>
                </CardContent>
            </Card>

            <!-- Actions -->
            <div class="flex justify-between">
                <div v-if="canEdit">
                    <Button variant="outline">
                        <Link :href="route('posts.edit', post.id)"> Edit </Link>
                    </Button>
                </div>
                <div v-if="canDelete">
                    <Form
                        :action="route('posts.destroy', post.id)"
                        method="delete"
                        :submitting="false"
                    >
                        <Button variant="destructive" type="submit">
                            Delete
                        </Button>
                    </Form>
                </div>
            </div>
        </main>
    </div>
</template>
