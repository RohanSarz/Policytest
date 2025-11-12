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
    storeRole,
    updateRole,
    deleteRole,
} from "@/actions/App/Http/Controllers/AdminController";
import RoleForm from "@/components/Admin/RoleForm.vue";
import RoleItem from "@/components/Admin/RoleItem.vue";
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

// Function to handle form submission for creating roles
function handleCreateRole(data: { name: string; permissions: string[] }) {
    const form = useForm(data);
    form.post(storeRole().url, {
        onSuccess: () => {
            // Form is reset in the RoleForm component after submit
        },
    });
}

// Function to handle updating role permissions
function handleUpdateRole(roleId: number, permissions: string[]) {
    const role = props.roles.find((r) => r.id === roleId);
    if (role) {
        const form = useForm({
            name: role.name,
            permissions: permissions,
        });

        form.put(updateRole(roleId).url, {
            name: <any>role.name,
            permissions: permissions,
        });
    }
}

// Function to delete a role
function handleDeleteRole(roleId: number) {
    if (
        confirm(
            "Are you sure you want to delete this role? This action cannot be undone.",
        )
    ) {
        // Submit a DELETE request to the backend
        // Since Inertia doesn't have a direct delete method, we'll use fetch
        fetch(deleteRole(roleId).url, {
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
    <div class="mx-auto px-4">
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
                <RoleForm
                    :permissions="props.permissions"
                    :on-submit="handleCreateRole"
                    :processing="false"
                />
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
                    <RoleItem
                        v-for="role in props.roles"
                        :key="role.id"
                        :role="role"
                        :permissions="props.permissions"
                        :on-update="handleUpdateRole"
                        :on-delete="handleDeleteRole"
                    />
                </div>
            </CardContent>
        </Card>
    </div>
</template>
