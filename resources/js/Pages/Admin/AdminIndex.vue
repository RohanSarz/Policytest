<script setup>
import UserNameUpper from "@/components/userDataComponents/UserNameUpper.vue";
import { usePage } from "@inertiajs/vue3";
import { computed } from "vue";
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";
import CreateButton from "@/components/post/CreateButton.vue";
import PostCard from "@/components/post/PostCard.vue";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from "@/components/ui/card";

// Set the layout for this page
defineOptions({
    layout: AdminLayout,
});

const page = usePage();

// Safely access user — fallback to empty object if missing
const user = computed(() => page.props.auth?.user || {});

// Only show posts if they exist
const posts = page.props.posts || [];

// Keep fake stats for now (replace with real data later)
const stats = {
    posts: posts.length,
    followers: 128,
    following: 56,
    online: true,
};
</script>

<template>
    <div class="mx-auto w-8/12">
        <!-- Admin Dashboard Title -->
        <h1 class="text-3xl font-bold text-gray-900 mb-6">Admin Dashboard</h1>

        <!-- User Profile Section -->
        <div class="bg-white shadow-sm rounded-lg p-6 mb-8 flex items-center space-x-4">
            <Avatar class="h-16 w-16">
                <AvatarImage
                    :src="user.avatar ? `/storage/${user.avatar}` : '/storage/avatars/def.jpg'"
                    :alt="user.name"
                />
                <AvatarFallback>{{ user.name?.charAt(0).toUpperCase() }}</AvatarFallback>
            </Avatar>
            <div>
                <h2 class="text-2xl font-semibold text-gray-800">{{ user.name }}</h2>
                <p class="text-sm text-gray-600">{{ user.email }}</p>
                <div class="mt-2">
                    <span
                        v-for="role in user.roles"
                        :key="role.id"
                        class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10 mr-2"
                    >
                        {{ role.name }}
                    </span>
                    <span
                        v-if="user.is_super_admin"
                        class="inline-flex items-center rounded-md bg-purple-50 px-2 py-1 text-xs font-medium text-purple-700 ring-1 ring-inset ring-purple-700/10"
                    >
                        Super Admin
                    </span>
                </div>
            </div>
        </div>

        <!-- Stats Section -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <Card>
                <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
 <CardTitle class="text-sm font-medium">Total Posts</CardTitle>
 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
 stroke="currentColor" strokeLinecap="round" strokeLinejoin="round"
 strokeWidth="2" class="h-4 w-4 text-muted-foreground">
 <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
 <polyline points="14 2 14 8 20 8" />
 <line x1="16" x2="8" y1="13" y2="13" />
 <line x1="16" x2="8" y1="17" y2="17" />
 <polyline points="10 9 9 9 8 9" />
 </svg>
                </CardHeader>
                <CardContent>
                    <div class="text-2xl font-bold">{{ stats.posts }}</div>
                    <p class="text-xs text-muted-foreground">
                        +20.1% from last month
                    </p>
                </CardContent>
            </Card>
            <Card>
                <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                    <CardTitle class="text-sm font-medium">Followers</CardTitle>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
 stroke="currentColor" strokeLinecap="round" strokeLinejoin="round"
 strokeWidth="2" class="h-4 w-4 text-muted-foreground">
 <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
 <circle cx="9" cy="7" r="4" />
 <path d="M22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75" />
 </svg>
                </CardHeader>
                <CardContent>
                    <div class="text-2xl font-bold">{{ stats.followers }}</div>
                    <p class="text-xs text-muted-foreground">
                        +180.1% from last month
                    </p>
                </CardContent>
            </Card>
            <Card>
                <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                    <CardTitle class="text-sm font-medium">Following</CardTitle>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
 stroke="currentColor" strokeLinecap="round" strokeLinejoin="round"
 strokeWidth="2" class="h-4 w-4 text-muted-foreground">
 <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
 <circle cx="9" cy="7" r="4" />
 <path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75" />
 </svg>
                </CardHeader>
                <CardContent>
                    <div class="text-2xl font-bold">{{ stats.following }}</div>
                    <p class="text-xs text-muted-foreground">
                        +19% from last month
                    </p>
                </CardContent>
            </Card>
            <Card>
                <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                    <CardTitle class="text-sm font-medium">Status</CardTitle>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
 stroke="currentColor" strokeLinecap="round" strokeLinejoin="round"
 strokeWidth="2" class="h-4 w-4 text-muted-foreground">
 <circle cx="12" cy="12" r="10" />
 <path d="M12 6v6l4 2" />
 </svg>
                </CardHeader>
                <CardContent>
                    <div class="text-2xl font-bold">
                        {{ stats.online ? "Online" : "Offline" }}
                    </div>
                    <p class="text-xs text-muted-foreground">
                        Last updated just now
                    </p>
                </CardContent>
            </Card>
        </div>

        <!-- Create Post Button -->
        <div class="mb-8">
            <CreateButton />
        </div>

        <!-- Posts Section -->
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Recent Posts</h2>
        <div v-if="posts.length > 0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <PostCard v-for="post in posts" :key="post.id" :post="post" />
        </div>
        <div v-else class="text-gray-600">No posts available.</div>
    </div>
</template>
