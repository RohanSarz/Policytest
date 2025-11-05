<script setup lang="ts">
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Badge } from '@/components/ui/badge';

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
  status: 'published' | 'pending' | 'archived' | 'deleted';
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

// Function to handle status update
function updateStatus(postId: number, newStatus: string) {
  // Create a form for the patch request
  const form = new FormData();
  form.append('_method', 'PATCH');
  form.append('status', newStatus);
  
  fetch(`/admin/posts/${postId}/status`, {
    method: 'POST',
    body: form,
    headers: {
      'X-Requested-With': 'XMLHttpRequest',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
    }
  })
  .then(response => {
    if (response.ok) {
      // Refresh the page to show updated data
      window.location.reload();
    } else {
      console.error('Failed to update status');
    }
  })
  .catch(error => {
    console.error('Error:', error);
  });
}

// Function to get status badge variant
function getStatusVariant(status: string) {
  switch (status) {
    case 'published':
      return 'bg-green-100 text-green-800';
    case 'pending':
      return 'bg-yellow-100 text-yellow-800';
    case 'archived':
      return 'bg-gray-100 text-gray-800';
    case 'deleted':
      return 'bg-red-100 text-red-800';
    default:
      return 'bg-gray-100 text-gray-800';
  }
}
</script>

<template>
  <AdminLayout>
    <div class="p-6">
      <h1 class="text-2xl font-bold mb-6">Posts Management</h1>
      
      <!-- Posts Table -->
      <Card>
        <CardHeader>
          <CardTitle>Posts List</CardTitle>
          <CardDescription>Manage all posts in the system</CardDescription>
        </CardHeader>
        <CardContent>
          <div class="overflow-x-auto">
            <table class="w-full">
              <thead>
                <tr class="border-b">
                  <th class="py-2 px-4 text-left">Title</th>
                  <th class="py-2 px-4 text-left">Author</th>
                  <th class="py-2 px-4 text-left">Category</th>
                  <th class="py-2 px-4 text-left">Status</th>
                  <th class="py-2 px-4 text-left">Created</th>
                  <th class="py-2 px-4 text-left">Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr 
                  v-for="post in props.posts" 
                  :key="post.id"
                  class="border-b hover:bg-gray-50"
                >
                  <td class="py-2 px-4 max-w-xs truncate">{{ post.title }}</td>
                  <td class="py-2 px-4">{{ post.user.name }}</td>
                  <td class="py-2 px-4">
                    {{ post.category ? post.category.name : 'Uncategorized' }}
                  </td>
                  <td class="py-2 px-4">
                    <Badge :class="getStatusVariant(post.status)">
                      {{ post.status.charAt(0).toUpperCase() + post.status.slice(1) }}
                    </Badge>
                  </td>
                  <td class="py-2 px-4">
                    {{ new Date(post.created_at).toLocaleDateString() }}
                  </td>
                  <td class="py-2 px-4">
                    <Select 
                      :value="post.status" 
                      @update:model-value="updateStatus(post.id, $event)"
                    >
                      <SelectTrigger class="w-32">
                        <SelectValue :placeholder="post.status" />
                      </SelectTrigger>
                      <SelectContent>
                        <SelectItem value="published">Published</SelectItem>
                        <SelectItem value="pending">Pending</SelectItem>
                        <SelectItem value="archived">Archived</SelectItem>
                        <SelectItem value="deleted">Deleted</SelectItem>
                      </SelectContent>
                    </Select>
                  </td>
                </tr>
              </tbody>
            </table>
            
            <div v-if="props.posts.length === 0" class="text-center py-4 text-gray-500">
              No posts found.
            </div>
          </div>
        </CardContent>
      </Card>
    </div>
  </AdminLayout>
</template>