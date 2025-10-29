<script setup>
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";
import Badge from "@/components/ui/badge/Badge.vue";
import { Card } from "@/components/ui/card";
import UserNameUpper from "@/components/userDataComponents/UserNameUpper.vue";
import { usePage } from "@inertiajs/vue3";
import { computed } from "vue";

const { post } = usePage().props;
const user = computed(() => post.user || {});
const category = computed(() => post.category || {});
</script>

<template>
    <div class="min-h-screen bg-gray-50">
        <!-- Header -->
        <header class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div
                    class="flex flex-col md:flex-row md:items-center gap-2 md:justify-between"
                >
                    <div class="flex items-center space-x-4">
                        <Avatar class="ring-1" v-if="user">
                            <AvatarImage
                                v-if="user.avatar"
                                :src="`/storage/${user.avatar}`"
                                alt="User Avatar"
                            />
                            <AvatarFallback>{{ user.name[0] }}</AvatarFallback>
                        </Avatar>
                        <div>
                            <Link :href="route('users.show', user.id)">
                                <p
                                    class="text-sm font-semibold hover:underline text-gray-900"
                                >
                                    <UserNameUpper :name="user.name" /></p
                            ></Link>
                            <p class="text-xs text-gray-600">
                                Published on {{ post.created_at_human}}
                            </p>
                        </div>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-900">
                        {{ post.title }}
                    </h1>

                    <div></div>
                </div>
            </div>
        </header>

        <!-- Post Content -->
        <main class="py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <Card class="p-6">
                    <div class="flex justify-between items-start">
                        <Badge
                            v-if="category"
                            variant="outline"
                            class="bg-blue-100 text-blue-800"
                        >
                            {{ category.name || "Uncategorized" }}
                        </Badge>
                    </div>

                    <div class="mt-6 prose prose-lg max-w-none">
                        <p class="mb-4">{{ post.content }}</p>
                        
                        <!-- Display cover image -->
                        <Card
                            v-if="post.cover_image"
                            class="w-full h-96 overflow-hidden my-4"
                        >
                            <img
                                class="w-full h-full object-cover object-top"
                                :src="`/storage/${post.cover_image}`"
                                alt="Post cover image"
                            />
                        </Card>
                        
                        <!-- Display multiple images -->
                        <div 
                            v-if="post.postImages && post.postImages.length > 0"
                            class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 my-4"
                        >
                            <Card
                                v-for="postImage in post.postImages"
                                :key="postImage.id"
                                class="overflow-hidden"
                            >
                                <img
                                    class="w-full h-48 object-cover"
                                    :src="`/storage/${postImage.url}`"
                                    :alt="postImage.alt_text || 'Post image'"
                                />
                            </Card>
                        </div>
                    </div>
                </Card>
            </div>
        </main>
    </div>
</template>
