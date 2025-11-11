<script setup lang="ts">
import { Button } from "@/components/ui/button";
import { ref } from "vue";

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
    role: Role;
    permissions: Permission[];
    onUpdate: (roleId: number, permissions: string[]) => void;
    onDelete: (roleId: number) => void;
}

const props = defineProps<Props>();

// State for tracking role permissions
const rolePermissions = ref<string[]>(props.role.permissions.map(p => p.name));
const selectedPermission = ref("");

// Function to toggle permission for a specific role
const toggleRolePermission = (permissionName: string) => {
    const index = rolePermissions.value.indexOf(permissionName);
    if (index > -1) {
        rolePermissions.value = rolePermissions.value.filter(
            (perm) => perm !== permissionName
        );
    } else {
        rolePermissions.value = [...rolePermissions.value, permissionName];
    }
    props.onUpdate(props.role.id, rolePermissions.value);
};

// Function to add a permission to a role
const addRolePermission = () => {
    if (selectedPermission.value && !rolePermissions.value.includes(selectedPermission.value)) {
        rolePermissions.value = [...rolePermissions.value, selectedPermission.value];
        props.onUpdate(props.role.id, rolePermissions.value);
        selectedPermission.value = "";
    }
};

// Function to remove a permission from a role
const removeRolePermission = (permissionName: string) => {
    rolePermissions.value = rolePermissions.value.filter(perm => perm !== permissionName);
    props.onUpdate(props.role.id, rolePermissions.value);
};
</script>

<template>
    <div class="border p-4 rounded-lg">
        <div class="flex justify-between items-start">
            <div>
                <h3 class="font-semibold text-lg">
                    {{ role.name }}
                </h3>
                <p class="text-sm text-gray-500 mb-2">
                    Permissions:
                </p>
            </div>
            <button
                @click="onDelete(role.id)"
                class="text-red-600 hover:text-red-900"
                title="Delete role"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5"
                    viewBox="0 0 20 20"
                    fill="currentColor"
                >
                    <path
                        fill-rule="evenodd"
                        d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                        clip-rule="evenodd"
                    />
                </svg>
            </button>
        </div>
        <div class="mt-2">
            <div
                v-if="rolePermissions.length > 0"
                class="flex flex-wrap gap-2"
            >
                <span
                    v-for="permissionName in rolePermissions"
                    :key="permissionName"
                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800"
                >
                    {{ permissionName }}
                    <button
                        type="button"
                        @click="removeRolePermission(permissionName)"
                        class="ml-2 flex items-center justify-center text-blue-600 hover:text-blue-800"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </button>
                </span>
            </div>
            <div v-else class="text-gray-500 italic">
                No permissions assigned
            </div>

            <div class="mt-3">
                <label class="text-sm font-medium">Add Permission:</label>
                <select
                    v-model="selectedPermission"
                    class="mt-1 block w-1/6 h-8 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                    @change="addRolePermission"
                >
                    <option value="">
                        Select a permission
                    </option>
                    <option
                        v-for="permission in permissions"
                        :key="`add-${role.id}-${permission.name}`"
                        :value="permission.name"
                        :disabled="rolePermissions.includes(permission.name)"
                    >
                        {{ permission.name }}
                    </option>
                </select>
            </div>
        </div>
    </div>
</template>