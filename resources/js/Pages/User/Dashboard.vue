<script setup>
import { UserNameUpper, UserCard } from "@/components/userDataComponents/";
import { usePage } from "@inertiajs/vue3";
import { computed } from "vue";
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";
import UserTable from "@/components/UserTable.vue";
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

    <div class="min-h-screen bg-gray-50">
        <!-- Header section with dashboard title and user information -->
        <header class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div
                    class="flex flex-col md:flex-row md:items-center md:justify-between"
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
                </div>
            </div>
        </header>

        <main>
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 sm:dark">
                <!-- User Profile Card with Stats  -->
                <div class="bg-white rounded-lg border p-6 shadow-sm">
                    <div class="flex flex-col md:flex-row gap-6">
                        <!-- Left side: User profile information including avatar, name, email and role -->

                        <UserCard :user="user" />

                        <!-- Right side: Stats grid showing user metrics -->
                        <div class="flex-1">
                            <div class="grid grid-cols-2 gap-4">
                                <!-- Total Posts stat -->

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
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="text-sm text-gray-500">
                                        Total Posts
                                    </div>
                                    <div class="text-xl font-semibold">
                                        {{ stats.posts }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="px-4">
                <UserTable />
            </div>
        </main>
    </div>
</template>
