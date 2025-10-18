<script setup>
import UserNameUpper from "@/components/userDataComponents/UserNameUpper.vue";
import { usePage } from "@inertiajs/vue3";
import { computed } from "vue";
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";
import CreateButton from "@/components/post/CreateButton.vue";

// Get the current page and user information from Inertia
const page = usePage();
const user = computed(() => page.props.auth.user);

// Fake data for stats - in a real app, this would come from the backend
const stats = {
    posts: 24,
    followers: 128,
    following: 56,
    online: true,
};
</script>

<template>
    <Head title="User Dashboard" />

    <div class="min-w-full min-h-screen bg-gray-50">
        <!-- Header section with dashboard title and user information -->
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
                            <UserNameUpper :name="user.name" />
                        </p>
                    </div>
                    <div>
                        <CreateButton />
                    </div>
                </div>
            </div>
        </header>

        <main>
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 sm:dark">
                <!-- User Profile Card with Stats - combines user info with key metrics -->
                <div class="bg-white rounded-lg border p-6 shadow-sm">
                    <div class="flex flex-col md:flex-row gap-6">
                        <!-- Left side: User profile information including avatar, name, email and role -->
                        <div class="flex flex-col items-center text-center">
                            <Avatar class="size-16 ring-1">
                                <AvatarImage
                                    class="border"
                                    :src="`storage/${user.avatar}`"
                                    alt="@radix-vue"
                                />
                                <AvatarFallback v-if="!user.avatar">{{
                                    user.name[0].toUpperCase()
                                }}</AvatarFallback>
                            </Avatar>
                            <h2 class="text-lg font-medium text-gray-900 mt-3">
                                {{ user.name }}
                            </h2>
                            <p class="text-gray-600 text-sm">
                                {{ user.email }}
                            </p>
                            <div
                                class="mt-2 flex flex-wrap justify-center gap-2"
                            >
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800"
                                >
                                    {{ user.role }} Admin
                                </span>
                            </div>
                        </div>

                        <!-- Right side: Stats grid showing user metrics -->
                        <div class="flex-1">
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                                <!-- Total Posts stat -->
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="text-sm text-gray-500">
                                        Total Posts
                                    </div>
                                    <div class="text-xl font-semibold">
                                        {{ stats.posts }}
                                    </div>
                                </div>
                                <!-- Followers stat -->
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="text-sm text-gray-500">
                                        Followers
                                    </div>
                                    <div class="text-xl font-semibold">
                                        {{ stats.followers }}
                                    </div>
                                </div>
                                <!-- Following stat -->
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="text-sm text-gray-500">
                                        Following
                                    </div>
                                    <div class="text-xl font-semibold">
                                        {{ stats.following }}
                                    </div>
                                </div>
                                <!-- Online Status stat -->
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="text-sm text-gray-500">
                                        Status
                                    </div>
                                    <div class="text-xl font-semibold">
                                        <span
                                            class="text-green-600"
                                            v-if="stats.online"
                                            >Active</span
                                        >
                                        <span class="text-gray-400" v-else
                                            >Offline</span
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>
