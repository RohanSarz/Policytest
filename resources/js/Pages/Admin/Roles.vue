<script setup lang="ts">
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Checkbox } from '@/components/ui/checkbox';
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';

// Define props interface
interface Permission {
  id: number;
  name: string;
  guard_name: string;
  created_at: string;
  updated_at: string;
}

interface Role {
  id: number;
  name: string;
  guard_name: string;
  created_at: string;
  updated_at: string;
  permissions: Permission[];
}

interface Props {
  roles: Role[];
  permissions: Permission[];
}

// Define props
const props = defineProps<Props>();

// Define form for creating new roles
const form = useForm({
  name: '',
  permissions: [] as string[],
});

// Function to handle form submission
function submitForm() {
  form.post('/admin/roles', {
    onSuccess: () => {
      form.reset();
    }
  });
}

// Function to handle permission checkbox changes
function togglePermission(permissionName: string) {
  const index = form.permissions.indexOf(permissionName);
  if (index > -1) {
    form.permissions.splice(index, 1);
  } else {
    form.permissions.push(permissionName);
  }
}
</script>

<template>
  <AdminLayout>
    <div class="p-6">
      <h1 class="text-2xl font-bold mb-6">Roles Management</h1>
      
      <!-- Create Role Card -->
      <Card class="mb-8">
        <CardHeader>
          <CardTitle>Create New Role</CardTitle>
          <CardDescription>Add a new role with specific permissions</CardDescription>
        </CardHeader>
        <CardContent>
          <form @submit.prevent="submitForm" class="space-y-4">
            <div>
              <Label for="roleName">Role Name</Label>
              <Input 
                id="roleName" 
                v-model="form.name" 
                placeholder="Enter role name" 
                :disabled="form.processing"
              />
              <div v-if="form.errors.name" class="text-red-500 text-sm mt-1">{{ form.errors.name }}</div>
            </div>
            
            <div>
              <Label>Permissions</Label>
              <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 mt-2">
                <div 
                  v-for="permission in props.permissions" 
                  :key="permission.name"
                  class="flex items-center space-x-2 p-2 border rounded"
                >
                  <Checkbox 
                    :id="`perm-${permission.name}`"
                    :checked="form.permissions.includes(permission.name)"
                    @update:checked="togglePermission(permission.name)"
                    :disabled="form.processing"
                  />
                  <Label :for="`perm-${permission.name}`" class="text-sm">
                    {{ permission.name }}
                  </Label>
                </div>
              </div>
            </div>
            
            <Button 
              type="submit" 
              :disabled="form.processing"
              class="w-full md:w-auto"
            >
              <span v-if="!form.processing">Create Role</span>
              <span v-else>Creating...</span>
            </Button>
          </form>
        </CardContent>
      </Card>

      <!-- Existing Roles -->
      <Card>
        <CardHeader>
          <CardTitle>Existing Roles</CardTitle>
          <CardDescription>Manage existing roles and their permissions</CardDescription>
        </CardHeader>
        <CardContent>
          <div v-if="props.roles.length === 0" class="text-center py-4 text-gray-500">
            No roles found. Create your first role above.
          </div>
          
          <div v-else class="space-y-4">
            <div 
              v-for="role in props.roles" 
              :key="role.id"
              class="border p-4 rounded-lg"
            >
              <h3 class="font-semibold text-lg">{{ role.name }}</h3>
              <p class="text-sm text-gray-500 mb-2">Permissions:</p>
              <div class="flex flex-wrap gap-2">
                <span 
                  v-for="permission in role.permissions" 
                  :key="permission.id"
                  class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded"
                >
                  {{ permission.name }}
                </span>
                <span 
                  v-if="role.permissions.length === 0" 
                  class="text-gray-500 text-sm italic"
                >
                  No permissions assigned
                </span>
              </div>
            </div>
          </div>
        </CardContent>
      </Card>
    </div>
  </AdminLayout>
</template>