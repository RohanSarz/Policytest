<script setup lang="ts">
import AdminLayout from "@/Layouts/AdminLayout.vue";

import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";

// Define props
const props = defineProps<{
    totalPosts: number;
    totalVerifiedUsers: number;
    totalUsers: number;
}>();
defineOptions({
    layout: AdminLayout,
});
</script>

<template>
    <div class="mx-auto">
        <h1 class="text-2xl font-bold mb-6">Admin Dashboard</h1>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Total Posts Card -->
            <Card>
                <CardHeader
                    class="flex flex-row items-center justify-between space-y-0 pb-2"
                >
                    <CardTitle class="text-sm font-medium"
                        >Total Posts</CardTitle
                    >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="size-6 text-gray-500"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                        />
                    </svg>
                </CardHeader>
                <CardContent>
                    <div class="text-2xl font-bold">
                        {{ props.totalPosts }}
                    </div>
                    <p class="text-xs text-gray-500">All published posts</p>
                </CardContent>
            </Card>

            <!-- Total Users Card -->
            <Card>
                <CardHeader
                    class="flex flex-row items-center justify-between space-y-0 pb-2"
                >
                    <CardTitle class="text-sm font-medium"
                        >Total Users</CardTitle
                    >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6 text-gray-500"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"
                        />
                    </svg>
                </CardHeader>
                <CardContent>
                    <div class="text-2xl font-bold">
                        {{ props.totalUsers }}
                    </div>
                    <p class="text-xs text-gray-500">Registered users</p>
                </CardContent>
            </Card>

            <!-- Verified Users Card -->
            <Card>
                <CardHeader
                    class="flex flex-row items-center justify-between space-y-0 pb-2"
                >
                    <CardTitle class="text-sm font-medium"
                        >Verified Users</CardTitle
                    >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6 text-gray-500"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                        />
                    </svg>
                </CardHeader>
                <CardContent>
                    <div class="text-2xl font-bold">
                        {{ props.totalVerifiedUsers }}
                    </div>
                    <p class="text-xs text-gray-500">Email verified accounts</p>
                </CardContent>
            </Card>
        </div>

        <!-- Additional dashboard content can go here -->
        <div class="grid grid-cols-1 gap-6">
            <Card>
                <CardHeader>
                    <CardTitle>Recent Activity</CardTitle>
                </CardHeader>
                <CardContent>
                    <p class="text-gray-500">
                        Dashboard content will be added here.
                    </p>
                </CardContent>
            </Card>
        </div>
    </div>
</template>
