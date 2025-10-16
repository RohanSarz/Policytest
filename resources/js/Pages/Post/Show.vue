<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";
import { Button } from "@/components/ui/button";
import UserNameUpper from "@/components/userDataComponents/UserNameUpper.vue";

interface User {
    id: number;
    name: string;
    avatar: string;
}

interface Post {
    id: number;
    user: User;
    title: string;
    content: string;
    created_at: string;
    updated_at: string;
}

// This would normally come from the server via props
const post: Post = {
    id: 1,
    user: {
        id: 1,
        name: "Jane Smith",
        avatar: "avatars/jane.jpg"
    },
    title: "Breaking: Major Policy Change Announced",
    content: "In a surprise move today, the administration announced a comprehensive policy overhaul that will reshape the economic landscape. The changes include new tax regulations, healthcare provisions, and infrastructure investments worth billions of dollars. Experts predict this will have long-term implications for various sectors of the economy.\n\nThe announcement was made during a joint session of Congress, where the President outlined the key components of the new policy framework. The changes are expected to take effect starting next month, with implementation phases continuing through the end of the year.\n\nAccording to the Secretary of Economic Development, these changes will create an estimated 500,000 new jobs over the next two years while reducing the national deficit. The policy focuses on three main pillars: sustainable energy, healthcare reform, and technology advancement.\n\nSeveral industry experts have already weighed in on the announcement. \"This represents the most significant policy shift in a generation,\" said Dr. Emily Johnson, an economist at the National Policy Institute. \"The ripple effects will likely be felt across multiple sectors for years to come.\"\n\nOpposition leaders have voiced concerns about the implementation timeline and potential short-term economic disruptions. A spokesperson for the minority party said they would be reviewing the details carefully before making a complete assessment.\n\nThe announcement has caused mixed reactions in the stock market, with infrastructure and renewable energy stocks seeing gains while some traditional energy companies experienced losses. Financial analysts expect continued volatility as markets digest the implications of the new policy direction.",
    created_at: "2025-10-15T09:30:00Z",
    updated_at: "2025-10-15T09:30:00Z"
};
</script>

<template>
    <div>
        <Head :title="post.title" />
        
        <header class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-semibold text-gray-900">
                            Post Details
                        </h1>
                        <p class="mt-1 text-sm text-gray-600">
                            View and read the full post
                        </p>
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
                                    :src="`storage/${post.user.avatar}`"
                                    :alt="post.user.name"
                                />
                                <AvatarFallback>
                                    {{ post.user.name.charAt(0).toUpperCase() }}
                                </AvatarFallback>
                            </Avatar>
                        </Link>
                        <div class="flex-1 min-w-0">
                            <Link :href="`/users/${post.user.id}`" class="hover:underline">
                                <h4 class="text-sm font-semibold truncate">{{ post.user.name }}</h4>
                            </Link>
                            <p class="text-xs text-muted-foreground">
                                Published: {{ new Date(post.created_at).toLocaleDateString() }}
                                <span v-if="post.updated_at !== post.created_at">
                                    (Updated: {{ new Date(post.updated_at).toLocaleDateString() }})
                                </span>
                            </p>
                        </div>
                    </div>
                    
                    <CardTitle class="mt-4 text-3xl">{{ post.title }}</CardTitle>
                </CardHeader>
                
                <CardContent class="prose prose-gray max-w-none">
                    <div class="text-muted-foreground whitespace-pre-line text-lg">
                        {{ post.content }}
                    </div>
                </CardContent>
            </Card>

            <!-- Actions -->
            <div class="flex justify-between">
                <div>
                    <Button variant="outline">
                        <Link :href="route('posts.edit', { id: post.id })">
                            Edit
                        </Link>
                    </Button>
                </div>
                <div>
                    <form @submit.prevent="() => {
                        if (confirm('Are you sure you want to delete this post?')) {
                            // In a real app, this would be an actual delete request
                            console.log('Deleting post', post.id);
                        }
                    }">
                        <Button type="submit" variant="destructive">
                            Delete
                        </Button>
                    </form>
                </div>
            </div>
        </main>
    </div>
</template>