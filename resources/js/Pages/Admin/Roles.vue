<script setup lang="ts">
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from "@/components/ui/card";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { Checkbox } from "@/components/ui/checkbox";
import { ref, reactive } from "vue";
import { useForm } from "@inertiajs/vue3";

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

// State for tracking role permissions independently
const rolePermissions = reactive<{ [key: number]: string[] }>({});

// Initialize role permissions state with current permissions from each role
props.roles.forEach((role) => {
    rolePermissions[role.id] = role.permissions.map((p) => p.name);
});

// State for tracking selected permission for each role
const selectedPermission = reactive<{ [key: number]: string }>({});

// Define form for creating new roles
const createRoleForm = useForm({
    name: "",
    permissions: [] as string[],
});

// Reactive variable for selecting new permissions
const selectedNewPermission = ref("");

// Function to handle form submission for creating roles
function submitCreateRoleForm() {
    console.log(
        "Submitting form with permissions:",
        createRoleForm.permissions,
    );
    createRoleForm.post("/admin/roles", {
        onSuccess: () => {
            createRoleForm.reset();
        },
    });
}

// Function to handle permission checkbox changes for creating roles
function togglePermission(permissionName: string) {
    const index = createRoleForm.permissions.indexOf(permissionName);
    let newPermissions;

    if (index > -1) {
        // Remove permission
        newPermissions = createRoleForm.permissions.filter(
            (perm) => perm !== permissionName,
        );
    } else {
        // Add permission
        newPermissions = [...createRoleForm.permissions, permissionName];
    }

    // Update the form with new permissions array to ensure reactivity
    createRoleForm.permissions = newPermissions;
    console.log(
        "Toggled permission:",
        permissionName,
        "Current permissions:",
        createRoleForm.permissions,
    );
}

// Function to add a permission to the create form
function addPermission() {
    if (
        selectedNewPermission.value &&
        !createRoleForm.permissions.includes(selectedNewPermission.value)
    ) {
        createRoleForm.permissions = [
            ...createRoleForm.permissions,
            selectedNewPermission.value,
        ];
        console.log(
            "Added permission:",
            selectedNewPermission.value,
            "Current permissions:",
            createRoleForm.permissions,
        );
        // Reset the selected option
        selectedNewPermission.value = "";
    }
}

// Function to remove a permission from the create form
function removePermission(permissionName: string) {
    const newPermissions = createRoleForm.permissions.filter(
        (perm) => perm !== permissionName,
    );
    createRoleForm.permissions = newPermissions;
    console.log(
        "Removed permission:",
        permissionName,
        "Current permissions:",
        createRoleForm.permissions,
    );
}

// For updating existing role permissions
function updateRolePermissions(roleId: number) {
    const role = props.roles.find((r) => r.id === roleId);
    if (role) {
        const form = useForm({
            name: role.name, // Use current name
            permissions: rolePermissions[roleId] || [],
        });

        form.put(`/admin/roles/${roleId}`, {
            data: {
                name: role.name,
                permissions: rolePermissions[roleId] || [],
            },
            onSuccess: () => {
                // Optionally update the local state or refresh data
            },
        });
    }
}

// Function to toggle permission for a specific role
function toggleRolePermission(roleId: number, permissionName: string) {
    const permissions = [...(rolePermissions[roleId] || [])]; // Create a copy of the array
    const index = permissions.indexOf(permissionName);

    if (index > -1) {
        // Remove permission
        permissions.splice(index, 1);
    } else {
        // Add permission
        permissions.push(permissionName);
    }

    // Update reactive state
    rolePermissions[roleId] = permissions; // Update with new array

    // Update the role permissions
    updateRolePermissions(roleId);
    console.log(
        `Toggled permission ${permissionName} for role ${roleId}. Current permissions:`,
        permissions,
    );
}

// Function to add a permission to a role
function addRolePermission(roleId: number) {
    const permissionToAdd = selectedPermission[roleId];

    if (permissionToAdd && !rolePermissions[roleId].includes(permissionToAdd)) {
        rolePermissions[roleId] = [...rolePermissions[roleId], permissionToAdd];
        updateRolePermissions(roleId);
        // Reset the selected option
        selectedPermission[roleId] = "";
        console.log(
            `Added permission ${permissionToAdd} to role ${roleId}. Current permissions:`,
            rolePermissions[roleId],
        );
    }
}

// Function to remove a permission from a role
function removeRolePermission(roleId: number, permissionName: string) {
    const permissions = [...rolePermissions[roleId]];
    const index = permissions.indexOf(permissionName);

    if (index > -1) {
        permissions.splice(index, 1);
        rolePermissions[roleId] = permissions;
        updateRolePermissions(roleId);
        console.log(
            `Removed permission ${permissionName} from role ${roleId}. Current permissions:`,
            permissions,
        );
    }
}

// Function to delete a role
function deleteRole(roleId: number) {
    if (
        confirm(
            "Are you sure you want to delete this role? This action cannot be undone.",
        )
    ) {
        // Submit a DELETE request to the backend
        // Since Inertia doesn't have a direct delete method, we'll use fetch
        fetch(`/admin/roles/${roleId}`, {
            method: "DELETE",
            headers: {
                "X-CSRF-TOKEN":
                    document
                        .querySelector('meta[name="csrf-token"]')
                        ?.getAttribute("content") || "",
                "Content-Type": "application/json",
            },
            // Include credentials if needed for authentication
            credentials: "same-origin",
        })
            .then((response) => {
                if (response.ok) {
                    // Reload the page to reflect the changes
                    window.location.reload();
                } else {
                    console.error("Failed to delete role");
                }
            })
            .catch((error) => {
                console.error("Error deleting role:", error);
            });
    }
}

defineOptions({
    layout: AdminLayout,
});
</script>

<template>
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-6">Roles Management</h1>

        <!-- Create Role Card -->
        <Card class="mb-8">
            <CardHeader>
                <CardTitle>Create New Role</CardTitle>
                <CardDescription
                    >Add a new role with specific permissions</CardDescription
                >
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
                        <div
                            v-if="createRoleForm.errors.name"
                            class="text-red-500 text-sm mt-1"
                        >
                            {{ createRoleForm.errors.name }}
                        </div>
                    </div>

                    <div>
                        <Label>Permissions</Label>
                        <div class="mt-2">
                            <div
                                v-if="createRoleForm.permissions.length > 0"
                                class="flex flex-wrap gap-2"
                            >
                                <span
                                    v-for="permissionName in createRoleForm.permissions"
                                    :key="permissionName"
                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800"
                                >
                                    {{ permissionName }}
                                    <button
                                        type="button"
                                        @click="
                                            removePermission(permissionName)
                                        "
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
                                No permissions selected
                            </div>

                            <div class="mt-3">
                                <select
                                    v-model="selectedNewPermission"
                                    class="mt-1 block w-1/3 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                    @change="addPermission"
                                >
                                    <option value="">Add a permission</option>
                                    <option
                                        v-for="permission in props.permissions"
                                        :key="permission.name"
                                        :value="permission.name"
                                        :disabled="
                                            createRoleForm.permissions.includes(
                                                permission.name,
                                            )
                                        "
                                    >
                                        {{ permission.name }}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <Button
                        type="submit"
                        :disabled="createRoleForm.processing"
                        class="w-full md:w-auto"
                    >
                        <span v-if="!createRoleForm.processing"
                            >Create Role</span
                        >
                        <span v-else>Creating...</span>
                    </Button>
                </form>
            </CardContent>
        </Card>

        <!-- Existing Roles -->
        <Card>
            <CardHeader>
                <CardTitle>Existing Roles</CardTitle>
                <CardDescription
                    >Manage existing roles and their
                    permissions</CardDescription
                >
            </CardHeader>
            <CardContent>
                <div
                    v-if="props.roles.length === 0"
                    class="text-center py-4 text-gray-500"
                >
                    No roles found. Create your first role above.
                </div>

                <div v-else class="space-y-4">
                    <div
                        v-for="role in props.roles"
                        :key="role.id"
                        class="border p-4 rounded-lg"
                    >
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
                                @click="deleteRole(role.id)"
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
                                v-if="
                                    (rolePermissions[role.id] || []).length > 0
                                "
                                class="flex flex-wrap gap-2"
                            >
                                <span
                                    v-for="permissionName in rolePermissions[
                                        role.id
                                    ]"
                                    :key="permissionName"
                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800"
                                >
                                    {{ permissionName }}
                                    <button
                                        type="button"
                                        @click="
                                            removeRolePermission(
                                                role.id,
                                                permissionName,
                                            )
                                        "
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
                                <label class="text-sm font-medium"
                                    >Add Permission:</label
                                >
                                <select
                                    v-model="selectedPermission[role.id]"
                                    class="mt-1 block w-1/6 h-8 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                    @change="addRolePermission(role.id)"
                                >
                                    <option value="">
                                        Select a permission
                                    </option>
                                    <option
                                        v-for="permission in props.permissions"
                                        :key="`add-${role.id}-${permission.name}`"
                                        :value="permission.name"
                                        :disabled="
                                            (
                                                rolePermissions[role.id] || []
                                            ).includes(permission.name)
                                        "
                                    >
                                        {{ permission.name }}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </CardContent>
        </Card>
    </div>
</template>
