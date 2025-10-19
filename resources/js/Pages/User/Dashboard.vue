<script setup>
import UserNameUpper from "@/components/userDataComponents/UserNameUpper.vue";
import { usePage } from "@inertiajs/vue3";
import { computed } from "vue";
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";
import CreateButton from "@/components/post/CreateButton.vue";
import PostCard from "@/components/post/PostCard.vue";

const page = usePage();

// Safely access user — fallback to empty object if missing
const user = computed(() => page.props.auth?.user || {});

// Only show posts if they exist
const posts = page.props.posts || [];

// Keep fake stats for now (replace with real data later)
const stats = {
    posts: posts.length, // ✅ dynamic: use actual post count!
    followers: 128,
    following: 56,
    online: true,
};
</script>

<template>
    <Head title="User Dashboard" />

    <div class="min-h-screen bg-gray-50">
        <!-- Header -->
        <header class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div
                    class="flex flex-col md:flex-row md:items-center gap-2 md:justify-between"
                >
                    <div>
                        <h1 class="text-2xl font-semibold text-gray-900">
                            Dashboard
                        </h1>
                        <p class="mt-1 text-sm text-gray-600">
                            Welcome to the dashboard,
                            <UserNameUpper :name="user.name || 'Guest'" />
                        </p>
                    </div>
                    <div>
                        <CreateButton />
                    </div>
                </div>
            </div>
        </header>

        <main>
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 border">
                <!-- User Profile Card -->
                <div class="bg-white rounded-lg border p-6 shadow-sm">
                    <div class="flex flex-col md:flex-row gap-6">
                        <!-- User Info -->
                        <div class="flex flex-col items-center text-center">
                            <Avatar class="size-16 ring-1">
                                <AvatarImage
                                    v-if="user.avatar"
                                    :src="`/storage/${
                                        user?.avatar ?? 'avatars/def.jpg'
                                    }`"
                                    :alt="user.name || 'User avatar'"
                                />
                                <AvatarFallback>
                                    {{
                                        user.name
                                            ? user.name[0].toUpperCase()
                                            : "U"
                                    }}
                                </AvatarFallback>
                            </Avatar>

                            <h2 class="text-lg font-medium text-gray-900 mt-3">
                                {{ user.name || "Unknown User" }}
                            </h2>
                            <p class="text-gray-600 text-sm">
                                {{ user.email || "No email" }}
                            </p>
                            <div
                                class="mt-2 flex flex-wrap justify-center gap-2"
                            >
                                <span
                                    v-if="user.role"
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800"
                                >
                                    {{ user.role }} Admin
                                </span>
                            </div>
                        </div>

                        <!-- Stats -->
                        <div class="flex-1">
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="text-sm text-gray-500">
                                        Total Posts
                                    </div>
                                    <div class="text-xl font-semibold">
                                        {{ stats.posts }}
                                    </div>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="text-sm text-gray-500">
                                        Followers
                                    </div>
                                    <div class="text-xl font-semibold">
                                        {{ stats.followers }}
                                    </div>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="text-sm text-gray-500">
                                        Following
                                    </div>
                                    <div class="text-xl font-semibold">
                                        {{ stats.following }}
                                    </div>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="text-sm text-gray-500">
                                        Status
                                    </div>
                                    <div class="text-xl font-semibold">
                                        <span
                                            v-if="stats.online"
                                            class="text-green-600"
                                            >Active</span
                                        >
                                        <span v-else class="text-gray-400"
                                            >Offline</span
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Posts Grid -->
                <div class="grid grid-cols-2">
                    <PostCard
                        v-for="post in posts"
                        :key="post.id"
                        :post="post"
                        class="mx-auto my-12"
                        data-aos="zoom-in-up"
                        data-aos-duration="500"
                    />
                </div>
            </div>
        </main>
    </div>
</template>
