<script setup>
import { Head } from "@inertiajs/vue3";
import { usePage } from "@inertiajs/vue3";
import { computed } from "vue";
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";
import AdminLayout from "@/Layouts/AdminLayout.vue";

// Set the layout for this page
defineOptions({
    layout: AdminLayout,
});

const page = usePage();

// Safely access user — fallback to empty object if missing
const user = computed(() => page.props.auth?.user || {});

// Example users data
const users = [
  {
    id: 1,
    name: "John Doe",
    email: "john@example.com",
    role: "user",
    avatar: "/storage/avatars/default.png",
    status: "active"
  },
  {
    id: 2,
    name: "Jane Smith",
    email: "jane@example.com",
    role: "admin",
    avatar: "/storage/avatars/default.png",
    status: "active"
  },
  {
    id: 3,
    name: "Robert Johnson",
    email: "robert@example.com",
    role: "user",
    avatar: "/storage/avatars/default.png",
    status: "inactive"
  },
  {
    id: 4,
    name: "Emily Davis",
    email: "emily@example.com",
    role: "moderator",
    avatar: "/storage/avatars/default.png",
    status: "active"
  }
];
</script>

<template>
  <div class="max-w-6xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8">
      <h1 class="text-3xl font-bold text-gray-900">User Management</h1>
      <p class="mt-2 text-gray-600">Manage all users in the system</p>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
      <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500">
        <div class="text-gray-500 text-sm font-medium">Total Users</div>
        <div class="text-3xl font-bold text-gray-900 mt-1">{{ users.length }}</div>
      </div>
      <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500">
        <div class="text-gray-500 text-sm font-medium">Active Users</div>
        <div class="text-3xl font-bold text-gray-900 mt-1">{{ users.filter(u => u.status === 'active').length }}</div>
      </div>
      <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-yellow-500">
        <div class="text-gray-500 text-sm font-medium">Admins</div>
        <div class="text-3xl font-bold text-gray-900 mt-1">{{ users.filter(u => u.role === 'admin').length }}</div>
      </div>
      <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-purple-500">
        <div class="text-gray-500 text-sm font-medium">New This Month</div>
        <div class="text-3xl font-bold text-gray-900 mt-1">12</div>
      </div>
    </div>

    <!-- User Table -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
      <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-lg font-semibold text-gray-900">Users</h2>
      </div>
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="userItem in users" :key="userItem.id">
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                  <Avatar class="h-10 w-10">
                    <AvatarImage :src="userItem.avatar" :alt="userItem.name" />
                    <AvatarFallback>{{ userItem.name.charAt(0) }}</AvatarFallback>
                  </Avatar>
                  <div class="ml-4">
                    <div class="text-sm font-medium text-gray-900">{{ userItem.name }}</div>
                  </div>
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-gray-900">{{ userItem.email }}</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                  {{ userItem.role }}
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span v-if="userItem.status === 'active'" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                  Active
                </span>
                <span v-else class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                  Inactive
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                <button class="text-blue-600 hover:text-blue-900 mr-3">Edit</button>
                <button class="text-red-600 hover:text-red-900">Delete</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>