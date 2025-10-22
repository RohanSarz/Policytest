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

// Example posts data
const posts = [
  {
    id: 1,
    title: "Getting Started with Vue.js",
    author: "John Doe",
    date: "2023-06-15",
    status: "published",
    category: "Tutorial",
    comments: 24,
    views: 1250
  },
  {
    id: 2,
    title: "Advanced CSS Techniques",
    author: "Jane Smith",
    date: "2023-06-18",
    status: "published",
    category: "Guide",
    comments: 18,
    views: 980
  },
  {
    id: 3,
    title: "Building a REST API with Laravel",
    author: "Robert Johnson",
    date: "2023-06-20",
    status: "draft",
    category: "Tutorial",
    comments: 0,
    views: 0
  },
  {
    id: 4,
    title: "Understanding Vue 3 Composition API",
    author: "Emily Davis",
    date: "2023-06-22",
    status: "published",
    category: "Tutorial",
    comments: 32,
    views: 2100
  },
  {
    id: 5,
    title: "Top 10 JavaScript Tips",
    author: "Michael Wilson",
    date: "2023-06-25",
    status: "published",
    category: "Tips",
    comments: 41,
    views: 3200
  }
];
</script>

<template>
  <div class="max-w-6xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8">
      <h1 class="text-3xl font-bold text-gray-900">Post Management</h1>
      <p class="mt-2 text-gray-600">Manage all posts in the system</p>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
      <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500">
        <div class="text-gray-500 text-sm font-medium">Total Posts</div>
        <div class="text-3xl font-bold text-gray-900 mt-1">{{ posts.length }}</div>
      </div>
      <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500">
        <div class="text-gray-500 text-sm font-medium">Published</div>
        <div class="text-3xl font-bold text-gray-900 mt-1">{{ posts.filter(p => p.status === 'published').length }}</div>
      </div>
      <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-yellow-500">
        <div class="text-gray-500 text-sm font-medium">Drafts</div>
        <div class="text-3xl font-bold text-gray-900 mt-1">{{ posts.filter(p => p.status === 'draft').length }}</div>
      </div>
      <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-purple-500">
        <div class="text-gray-500 text-sm font-medium">Total Views</div>
        <div class="text-3xl font-bold text-gray-900 mt-1">{{ posts.reduce((sum, post) => sum + post.views, 0) }}</div>
      </div>
    </div>

    <!-- Posts Table -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
      <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
        <h2 class="text-lg font-semibold text-gray-900">Posts</h2>
        <button class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg text-sm">
          Create Post
        </button>
      </div>
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Author</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Views</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="post in posts" :key="post.id" class="hover:bg-gray-50">
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm font-medium text-gray-900">{{ post.title }}</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                  <div class="flex-shrink-0 h-10 w-10">
                    <Avatar>
                      <AvatarFallback>{{ post.author.charAt(0) }}</AvatarFallback>
                    </Avatar>
                  </div>
                  <div class="ml-4">
                    <div class="text-sm font-medium text-gray-900">{{ post.author }}</div>
                  </div>
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                {{ new Date(post.date).toLocaleDateString() }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                  {{ post.category }}
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span 
                  :class="{
                    'px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800': post.status === 'published',
                    'px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800': post.status === 'draft'
                  }"
                >
                  {{ post.status }}
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                {{ post.views.toLocaleString() }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                <button class="text-blue-600 hover:text-blue-900 mr-3">Edit</button>
                <button class="text-red-600 hover:text-red-900">Delete</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="bg-gray-50 px-6 py-3 flex items-center justify-between border-t border-gray-200">
        <div class="text-sm text-gray-700">
          Showing <span class="font-medium">1</span> to <span class="font-medium">{{ posts.length }}</span> of <span class="font-medium">{{ posts.length }}</span> results
        </div>
        <div class="flex space-x-2">
          <button class="px-3 py-1 rounded-md bg-gray-200 text-gray-700">Previous</button>
          <button class="px-3 py-1 rounded-md bg-blue-600 text-white">Next</button>
        </div>
      </div>
    </div>
  </div>
</template>