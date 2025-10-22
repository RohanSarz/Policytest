<script setup>
import UserNameUpper from "@/components/userDataComponents/UserNameUpper.vue";
import { usePage } from "@inertiajs/vue3";
import { computed } from "vue";
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";
import CreateButton from "@/components/post/CreateButton.vue";
import PostCard from "@/components/post/PostCard.vue";
import AdminLayout from "@/Layouts/AdminLayout.vue";

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
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Admin Dashboard</h1>
            <p class="mt-2 text-gray-600">
                You are the admin,
                <UserNameUpper :name="user.name || 'Admin'" />
            </p>
        </div>

        <!-- Admin Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div
                class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500"
            >
                <div class="text-gray-500 text-sm font-medium">Total Posts</div>
                <div class="text-3xl font-bold text-gray-900 mt-1">
                    {{ stats.posts }}
                </div>
            </div>
            <div
                class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500"
            >
                <div class="text-gray-500 text-sm font-medium">Followers</div>
                <div class="text-3xl font-bold text-gray-900 mt-1">
                    {{ stats.followers }}
                </div>
            </div>
            <div
                class="bg-white rounded-xl shadow-md p-6 border-l-4 border-yellow-500"
            >
                <div class="text-gray-500 text-sm font-medium">Following</div>
                <div class="text-3xl font-bold text-gray-900 mt-1">
                    {{ stats.following }}
                </div>
            </div>
            <div
                class="bg-white rounded-xl shadow-md p-6 border-l-4 border-purple-500"
            >
                <div class="text-gray-500 text-sm font-medium">Status</div>
                <div class="text-3xl font-bold text-gray-900 mt-1">
                    <span v-if="stats.online" class="text-green-600"
                        >Active</span
                    >
                    <span v-else class="text-gray-400">Offline</span>
                </div>
            </div>
        </div>

        <!-- Admin Profile and Actions -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
            <!-- Admin Profile Card -->
            <div class="lg:col-span-1 bg-white rounded-xl shadow-md p-6">
                <div class="flex flex-col items-center text-center">
                    <Avatar class="w-24 h-24 ring-2 ring-gray-200">
                        <AvatarImage
                            :src="
                                user.avatar
                                    ? `/storage/${user.avatar}`
                                    : '/storage/avatars/admin.png'
                            "
                            :alt="user.name[0].toUpperCase()"
                        />
                        <AvatarFallback class="text-xl">
                            {{ user.name?.charAt(0).toUpperCase() }}
                        </AvatarFallback>
                    </Avatar>

                    <h2 class="text-xl font-bold text-gray-900 mt-4">
                        {{ user.name || "Unknown User" }}
                    </h2>
                    <p class="text-gray-600 text-sm mt-1">
                        {{ user.email || "No email" }}
                    </p>
                    <div class="mt-3 flex flex-wrap justify-center gap-2">
                        <span
                            v-if="user.role"
                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800"
                        >
                            {{ user.role }} Admin
                        </span>
                    </div>
                </div>

                <div class="mt-6">
                    <button
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200"
                    >
                        Manage Profile
                    </button>
                </div>
            </div>

            <!-- Admin Actions -->
            <div class="lg:col-span-2 bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">
                    Admin Actions
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <button
                        class="bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium py-3 px-4 rounded-lg transition duration-200 text-left"
                    >
                        <div class="font-medium">User Management</div>
                        <div class="text-sm text-gray-600 mt-1">
                            Manage all users in the system
                        </div>
                    </button>
                    <button
                        class="bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium py-3 px-4 rounded-lg transition duration-200 text-left"
                    >
                        <div class="font-medium">Content Moderation</div>
                        <div class="text-sm text-gray-600 mt-1">
                            Review and moderate content
                        </div>
                    </button>
                    <button
                        class="bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium py-3 px-4 rounded-lg transition duration-200 text-left"
                    >
                        <div class="font-medium">System Settings</div>
                        <div class="text-sm text-gray-600 mt-1">
                            Configure system preferences
                        </div>
                    </button>
                    <button
                        class="bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium py-3 px-4 rounded-lg transition duration-200 text-left"
                    >
                        <div class="font-medium">Analytics</div>
                        <div class="text-sm text-gray-600 mt-1">
                            View system analytics
                        </div>
                    </button>
                </div>
            </div>
        </div>

        <!-- Create Post Button -->
        <div class="mb-6 flex justify-end">
            <CreateButton />
        </div>

        <!-- Recent Posts -->
        <div>
            <h2 class="text-xl font-semibold text-gray-900 mb-6">
                Recent Posts
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <PostCard
                    v-for="post in posts"
                    :key="post.id"
                    :post="post"
                    class="post-item"
                    data-aos="zoom-in-up"
                    data-aos-duration="500"
                />
            </div>
        </div>
    </div>
</template>
