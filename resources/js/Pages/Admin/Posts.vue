<script setup lang="ts">
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from "@/components/ui/card";
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from "@/components/ui/select";
import { Badge } from "@/components/ui/badge";
import { updatePostStatus } from "@/actions/App/Http/Controllers/AdminController";

// Define interfaces
interface User {
    id: number;
    name: string;
    email: string;
}

interface Category {
    id: number;
    name: string;
    slug: string;
}

interface Post {
    id: number;
    title: string;
    excerpt: string;
    status: "pending" | "approved" | "archived";
    created_at: string;
    updated_at: string;
    user: User;
    category: Category | null;
}

interface Props {
    posts: Post[];
    users: User[];
}

// Define props
const props = defineProps<Props>();

import { ref, computed } from "vue";
import { router } from "@inertiajs/vue3";

// Make posts reactive
const allPosts = ref<Post[]>(JSON.parse(JSON.stringify(props.posts)));

// Filter posts by status
const pendingPosts = computed(() =>
    allPosts.value.filter((post) => post.status === "pending"),
);
const approvedPosts = computed(() =>
    allPosts.value.filter((post) => post.status === "approved"),
);
const archivedPosts = computed(() =>
    allPosts.value.filter((post) => post.status === "archived"),
);

// Function to handle status update
function updateStatus(postId: number, newStatus: string) {
    router.patch(updatePostStatus(postId).url, 
        { status: newStatus },
        {
            onSuccess: () => {
                // Update the status in the local state
                const postIndex = allPosts.value.findIndex(
                    (post) => post.id === postId,
                );
                if (postIndex !== -1) {
                    // Create a new post object with updated status to ensure reactivity
                    const updatedPost = {
                        ...allPosts.value[postIndex],
                        status: newStatus as "pending" | "approved" | "archived"
                    };
                    
                    // Create a new array with the updated post
                    const newAllPosts = [...allPosts.value];
                    newAllPosts[postIndex] = updatedPost;
                    
                    // Update the ref to trigger reactivity
                    allPosts.value = newAllPosts;
                }
            },
            onError: (errors) => {
                console.error("Failed to update status:", errors);
                // Optionally reload the page to sync with server state
                window.location.reload();
            }
        }
    );
}

// Function to get status badge variant
function getStatusVariant(status: string) {
    switch (status) {
        case "approved":
            return "bg-green-100 text-green-800";
        case "pending":
            return "bg-yellow-100 text-yellow-800";
        case "archived":
            return "bg-gray-100 text-gray-800";
        default:
            return "bg-gray-100 text-gray-800";
    }
}

defineOptions({
    layout: AdminLayout,
});
</script>

<template>
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-6">Posts Management</h1>

        <!-- Pending Posts Table -->
        <Card class="mb-6">
            <CardHeader>
                <CardTitle>Pending Posts</CardTitle>
                <CardDescription
                    >Posts awaiting review and approval</CardDescription
                >
            </CardHeader>
            <CardContent>
                <!-- Desktop Table View -->
                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b">
                                <th class="py-2 px-4 text-left">Title</th>
                                <th class="py-2 px-4 text-left">Author</th>
                                <th class="py-2 px-4 text-left">Category</th>
                                <th class="py-2 px-4 text-left">Created</th>
                                <th class="py-2 px-4 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="post in pendingPosts"
                                :key="post.id"
                                class="border-b hover:bg-gray-50"
                            >
                                <td class="py-2 px-4 max-w-xs truncate">
                                    {{ post.title }}
                                </td>
                                <td class="py-2 px-4">{{ post.user.name }}</td>
                                <td class="py-2 px-4">
                                    {{
                                        post.category
                                            ? post.category.name
                                            : "Uncategorized"
                                    }}
                                </td>
                                <td class="py-2 px-4">
                                    {{
                                        new Date(
                                            post.created_at,
                                        ).toLocaleDateString()
                                    }}
                                </td>
                                <td class="py-2 px-4">
                                    <Select
                                        :value="post.status"
                                        @update:model-value="
                                            updateStatus(post.id, $event)
                                        "
                                    >
                                        <SelectTrigger class="w-32">
                                            <SelectValue
                                                :placeholder="post.status"
                                            />
                                        </SelectTrigger>
                                        <SelectContent>
                                            <SelectItem value="pending"
                                                >Pending</SelectItem
                                            >
                                            <SelectItem value="approved"
                                                >Approve</SelectItem
                                            >
                                            <SelectItem value="archived"
                                                >Discard</SelectItem
                                            >
                                        </SelectContent>
                                    </Select>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Card View -->
                <div class="md:hidden space-y-4">
                    <div 
                        v-for="post in pendingPosts"
                        :key="post.id"
                        class="border rounded-lg p-4"
                    >
                        <div class="flex justify-between items-start">
                            <div class="flex-1 min-w-0">
                                <h3 class="font-medium text-sm truncate">{{ post.title }}</h3>
                                <p class="text-xs text-gray-500 mt-1">Author: {{ post.user.name }}</p>
                                <p class="text-xs text-gray-500">Category: {{ post.category?.name || 'Uncategorized' }}</p>
                                <p class="text-xs text-gray-500">Created: {{ new Date(post.created_at).toLocaleDateString() }}</p>
                            </div>
                            <div class="ml-2">
                                <Select
                                    :value="post.status"
                                    @update:model-value="
                                        updateStatus(post.id, $event)
                                    "
                                >
                                    <SelectTrigger class="w-24 h-8">
                                        <SelectValue
                                            :placeholder="post.status"
                                        />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectItem value="pending"
                                            >Pending</SelectItem
                                        >
                                        <SelectItem value="approved"
                                            >Approve</SelectItem
                                        >
                                        <SelectItem value="archived"
                                            >Discard</SelectItem
                                        >
                                    </SelectContent>
                                </Select>
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    v-if="pendingPosts.length === 0"
                    class="text-center py-4 text-gray-500"
                >
                    No pending posts.
                </div>
            </CardContent>
        </Card>

        <!-- Approved Posts Table -->
        <Card class="mb-6">
            <CardHeader>
                <CardTitle>Approved Posts</CardTitle>
                <CardDescription
                    >Posts that have been approved and
                    published</CardDescription
                >
            </CardHeader>
            <CardContent>
                <!-- Desktop Table View -->
                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b">
                                <th class="py-2 px-4 text-left">Title</th>
                                <th class="py-2 px-4 text-left">Author</th>
                                <th class="py-2 px-4 text-left">Category</th>
                                <th class="py-2 px-4 text-left">Created</th>
                                <th class="py-2 px-4 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="post in approvedPosts"
                                :key="post.id"
                                class="border-b hover:bg-gray-50"
                            >
                                <td class="py-2 px-4 max-w-xs truncate">
                                    {{ post.title }}
                                </td>
                                <td class="py-2 px-4">{{ post.user.name }}</td>
                                <td class="py-2 px-4">
                                    {{
                                        post.category
                                            ? post.category.name
                                            : "Uncategorized"
                                    }}
                                </td>
                                <td class="py-2 px-4">
                                    {{
                                        new Date(
                                            post.created_at,
                                        ).toLocaleDateString()
                                    }}
                                </td>
                                <td class="py-2 px-4">
                                    <Select
                                        :value="post.status"
                                        @update:model-value="
                                            updateStatus(post.id, $event)
                                        "
                                    >
                                        <SelectTrigger class="w-32">
                                            <SelectValue
                                                :placeholder="post.status"
                                            />
                                        </SelectTrigger>
                                        <SelectContent>
                                            <SelectItem value="pending"
                                                >Pending</SelectItem
                                            >
                                            <SelectItem value="approved"
                                                >Approve</SelectItem
                                            >
                                            <SelectItem value="archived"
                                                >Discard</SelectItem
                                            >
                                        </SelectContent>
                                    </Select>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Card View -->
                <div class="md:hidden space-y-4">
                    <div 
                        v-for="post in approvedPosts"
                        :key="post.id"
                        class="border rounded-lg p-4"
                    >
                        <div class="flex justify-between items-start">
                            <div class="flex-1 min-w-0">
                                <h3 class="font-medium text-sm truncate">{{ post.title }}</h3>
                                <p class="text-xs text-gray-500 mt-1">Author: {{ post.user.name }}</p>
                                <p class="text-xs text-gray-500">Category: {{ post.category?.name || 'Uncategorized' }}</p>
                                <p class="text-xs text-gray-500">Created: {{ new Date(post.created_at).toLocaleDateString() }}</p>
                            </div>
                            <div class="ml-2">
                                <Select
                                    :value="post.status"
                                    @update:model-value="
                                        updateStatus(post.id, $event)
                                    "
                                >
                                    <SelectTrigger class="w-24 h-8">
                                        <SelectValue
                                            :placeholder="post.status"
                                        />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectItem value="pending"
                                            >Pending</SelectItem
                                        >
                                        <SelectItem value="approved"
                                            >Approve</SelectItem
                                        >
                                        <SelectItem value="archived"
                                            >Discard</SelectItem
                                        >
                                    </SelectContent>
                                </Select>
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    v-if="approvedPosts.length === 0"
                    class="text-center py-4 text-gray-500"
                >
                    No approved posts.
                </div>
            </CardContent>
        </Card>

        <!-- Discarded Posts Table -->
        <Card>
            <CardHeader>
                <CardTitle>Discarded Posts</CardTitle>
                <CardDescription
                    >Posts that have been discarded</CardDescription
                >
            </CardHeader>
            <CardContent>
                <!-- Desktop Table View -->
                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b">
                                <th class="py-2 px-4 text-left">Title</th>
                                <th class="py-2 px-4 text-left">Author</th>
                                <th class="py-2 px-4 text-left">Category</th>
                                <th class="py-2 px-4 text-left">Created</th>
                                <th class="py-2 px-4 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="post in archivedPosts"
                                :key="post.id"
                                class="border-b hover:bg-gray-50"
                            >
                                <td class="py-2 px-4 max-w-xs truncate">
                                    {{ post.title }}
                                </td>
                                <td class="py-2 px-4">{{ post.user.name }}</td>
                                <td class="py-2 px-4">
                                    {{
                                        post.category
                                            ? post.category.name
                                            : "Uncategorized"
                                    }}
                                </td>
                                <td class="py-2 px-4">
                                    {{
                                        new Date(
                                            post.created_at,
                                        ).toLocaleDateString()
                                    }}
                                </td>
                                <td class="py-2 px-4">
                                    <Select
                                        :value="post.status"
                                        @update:model-value="
                                            updateStatus(post.id, $event)
                                        "
                                    >
                                        <SelectTrigger class="w-32">
                                            <SelectValue
                                                :placeholder="post.status"
                                            />
                                        </SelectTrigger>
                                        <SelectContent>
                                            <SelectItem value="pending"
                                                >Pending</SelectItem
                                            >
                                            <SelectItem value="approved"
                                                >Approve</SelectItem
                                            >
                                            <SelectItem value="archived"
                                                >Discard</SelectItem
                                            >
                                        </SelectContent>
                                    </Select>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Card View -->
                <div class="md:hidden space-y-4">
                    <div 
                        v-for="post in archivedPosts"
                        :key="post.id"
                        class="border rounded-lg p-4"
                    >
                        <div class="flex justify-between items-start">
                            <div class="flex-1 min-w-0">
                                <h3 class="font-medium text-sm truncate">{{ post.title }}</h3>
                                <p class="text-xs text-gray-500 mt-1">Author: {{ post.user.name }}</p>
                                <p class="text-xs text-gray-500">Category: {{ post.category?.name || 'Uncategorized' }}</p>
                                <p class="text-xs text-gray-500">Created: {{ new Date(post.created_at).toLocaleDateString() }}</p>
                            </div>
                            <div class="ml-2">
                                <Select
                                    :value="post.status"
                                    @update:model-value="
                                        updateStatus(post.id, $event)
                                    "
                                >
                                    <SelectTrigger class="w-24 h-8">
                                        <SelectValue
                                            :placeholder="post.status"
                                        />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectItem value="pending"
                                            >Pending</SelectItem
                                        >
                                        <SelectItem value="approved"
                                            >Approve</SelectItem
                                        >
                                        <SelectItem value="archived"
                                            >Discard</SelectItem
                                        >
                                    </SelectContent>
                                </Select>
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    v-if="archivedPosts.length === 0"
                    class="text-center py-4 text-gray-500"
                >
                    No discarded posts.
                </div>
            </CardContent>
        </Card>
    </div>
</template>
