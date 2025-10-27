<script setup lang="ts">
import { computed } from "vue";
import { usePage } from "@inertiajs/vue3";
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";
import AdminLayout from "@/Layouts/AdminLayout.vue";

// Use Admin layout
defineOptions({
    layout: AdminLayout,
});

// Get Inertia props
const page = usePage();
const users = computed(() => page.props.users || []);
</script>

<template>
    <div class="max-w-7xl mx-auto">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">
                User Roles Management
            </h1>
            <p class="mt-2 text-gray-600">
                View and manage all users and their roles
            </p>
        </div>

        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div
                class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500"
            >
                <div class="text-gray-500 text-sm font-medium">Total Users</div>
                <div class="text-3xl font-bold text-gray-900 mt-1">
                    {{ users.length }}
                </div>
            </div>
            <div
                class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500"
            >
                <div class="text-gray-500 text-sm font-medium">
                    Active Users
                </div>
                <div class="text-3xl font-bold text-gray-900 mt-1">
                    {{ users.filter((u) => u.status === "active").length }}
                </div>
            </div>
            <div
                class="bg-white rounded-xl shadow-md p-6 border-l-4 border-yellow-500"
            >
                <div class="text-gray-500 text-sm font-medium">Admins</div>
                <div class="text-3xl font-bold text-gray-900 mt-1">
                    {{ users.filter((u) => u.role === "admin").length }}
                </div>
            </div>
            <div
                class="bg-white rounded-xl shadow-md p-6 border-l-4 border-purple-500"
            >
                <div class="text-gray-500 text-sm font-medium">Roles</div>
                <div class="text-3xl font-bold text-gray-900 mt-1">
                    {{ [...new Set(users.map((u) => u.role))].length }}
                </div>
            </div>
        </div>

        <!-- Users Table -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div
                class="px-6 py-4 border-b border-gray-200 flex justify-between items-center"
            >
                <h2 class="text-lg font-semibold text-gray-900">
                    Users & Roles
                </h2>
                <button
                    class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg text-sm"
                >
                    Add User Role
                </button>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                User
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Email
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Role
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Status
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Permissions
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr
                            v-for="user in users"
                            :key="user.id"
                            class="hover:bg-gray-50"
                        >
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <Avatar class="h-10 w-10">
                                        <AvatarImage
                                            :src="user.avatar"
                                            :alt="user.name"
                                        />
                                        <AvatarFallback>{{
                                            user.name?.charAt(0)
                                        }}</AvatarFallback>
                                    </Avatar>
                                    <div class="ml-4">
                                        <div
                                            class="text-sm font-medium text-gray-900"
                                        >
                                            {{ user.name }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"
                            >
                                {{ user.email }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full"
                                    :class="{
                                        'bg-red-100 text-red-800':
                                            user.role === 'Admin',
                                        'bg-yellow-100 text-yellow-800':
                                            user.role === 'Moderator',
                                        'bg-blue-100 text-blue-800':
                                            user.role === 'Editor',
                                        'bg-green-100 text-green-800':
                                            user.role === 'User',
                                    }"
                                >
                                    {{ user.role }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    v-if="user.status === 'active'"
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800"
                                    >Active</span
                                >
                                <span
                                    v-else
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800"
                                    >Inactive</span
                                >
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-1">
                                    <span
                                        v-for="permission in user.permissions"
                                        :key="permission"
                                        class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800"
                                    >
                                        {{ permission }}
                                    </span>
                                </div>
                            </td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm font-medium"
                            >
                                <button
                                    class="text-blue-600 hover:text-blue-900 mr-3"
                                >
                                    Edit
                                </button>
                                <button class="text-red-600 hover:text-red-900">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination (optional) -->
            <div
                class="bg-gray-50 px-6 py-3 flex items-center justify-between border-t border-gray-200"
            >
                <div class="text-sm text-gray-700">
                    Showing 1 to {{ users.length }} of
                    {{ users.length }} results
                </div>
                <div class="flex space-x-2">
                    <button
                        class="px-3 py-1 rounded-md bg-gray-200 text-gray-700"
                    >
                        Previous
                    </button>
                    <button class="px-3 py-1 rounded-md bg-blue-600 text-white">
                        Next
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
