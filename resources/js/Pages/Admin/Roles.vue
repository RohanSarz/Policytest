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
const createRoleForm = useForm({
  name: '',
  permissions: [] as string[],
});

// Function to handle form submission for creating roles
function submitCreateRoleForm() {
  createRoleForm.post('/admin/roles', {
    onSuccess: () => {
      createRoleForm.reset();
    }
  });
}

// Function to handle permission checkbox changes for creating roles
function togglePermission(permissionName: string) {
  const index = createRoleForm.permissions.indexOf(permissionName);
  if (index > -1) {
    createRoleForm.permissions.splice(index, 1);
  } else {
    createRoleForm.permissions.push(permissionName);
  }
}

// For each role, define a form to update its permissions
function updateRolePermissions(roleId: number, rolePermissions: string[]) {
  const form = useForm({
    name: '', // We don't need to update the name here
    permissions: rolePermissions
  });
  
  // We need to determine the role name to submit the form
  const role = props.roles.find(r => r.id === roleId);
  if (role) {
    form.put(`/admin/roles/${roleId}`, {
      data: {
        name: role.name, // Keep the existing name
        permissions: rolePermissions
      },
      onSuccess: () => {
        // Optionally show success message
      }
    });
  }
}

// Function to toggle permission for a specific role
function toggleRolePermission(roleId: number, permissionName: string) {
  const role = props.roles.find(r => r.id === roleId);
  if (role) {
    const currentPermissions = role.permissions.map(p => p.name);
    const index = currentPermissions.indexOf(permissionName);
    
    if (index > -1) {
      // Remove permission
      const newPermissions = currentPermissions.filter(p => p !== permissionName);
      updateRolePermissions(roleId, newPermissions);
    } else {
      // Add permission
      const newPermissions = [...currentPermissions, permissionName];
      updateRolePermissions(roleId, newPermissions);
    }
  }
}

defineOptions({
    layout: AdminLayout
})
</script>

<template>
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-6">Roles Management</h1>
    
    <!-- Create Role Card -->
    <Card class="mb-8">
      <CardHeader>
        <CardTitle>Create New Role</CardTitle>
        <CardDescription>Add a new role with specific permissions</CardDescription>
      </CardHeader>
      <CardContent>
        <form @submit.prevent="submitCreateRoleForm" class="space-y-4">
          <div>
            <Label for="roleName">Role Name</Label>
            <Input 
              id="roleName" 
              v-model="createRoleForm.name" 
              placeholder="Enter role name" 
              :disabled="createRoleForm.processing"
            />
            <div v-if="createRoleForm.errors.name" class="text-red-500 text-sm mt-1">{{ createRoleForm.errors.name }}</div>
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
                  :checked="createRoleForm.permissions.includes(permission.name)"
                  @update:checked="togglePermission(permission.name)"
                  :disabled="createRoleForm.processing"
                />
                <Label :for="`perm-${permission.name}`" class="text-sm">
                  {{ permission.name }}
                </Label>
              </div>
            </div>
          </div>
          
          <Button 
            type="submit" 
            :disabled="createRoleForm.processing"
            class="w-full md:w-auto"
          >
            <span v-if="!createRoleForm.processing">Create Role</span>
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
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 mt-2">
              <div 
                v-for="permission in props.permissions" 
                :key="`role-${role.id}-perm-${permission.id}`"
                class="flex items-center space-x-2 p-2 border rounded"
              >
                <Checkbox 
                  :id="`role-${role.id}-perm-${permission.name}`"
                  :checked="role.permissions.some(p => p.name === permission.name)"
                  @update:checked="toggleRolePermission(role.id, permission.name)"
                />
                <Label :for="`role-${role.id}-perm-${permission.name}`" class="text-sm">
                  {{ permission.name }}
                </Label>
              </div>
            </div>
          </div>
        </div>
      </CardContent>
    </Card>
  </div>
</template>