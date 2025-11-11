<script setup lang="ts">
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from "@/components/ui/card";
import { store } from "@/actions/App/Http/Controllers/AdminController";
import PermissionForm from "@/Components/Admin/PermissionForm.vue";
import PermissionItem from "@/Components/Admin/PermissionItem.vue";

// Define interfaces
interface Permission {
    id: number;
    name: string;
    guard_name: string;
    created_at: string;
    updated_at: string;
}

interface Props {
    permissions: Permission[];
}

// Define props
const props = defineProps<Props>();

// Function to handle form submission
function handleSubmit(data: { name: string }) {
    const form = useForm(data);
    form.post(store().url, {
        onSuccess: () => {
            // Form is reset in the PermissionForm component after submit
        },
    });
}

defineOptions({
    layout: AdminLayout,
});
</script>

<template>
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-6">Permissions Management</h1>

        <!-- Create Permission Card -->
        <Card class="mb-8">
            <CardHeader>
                <CardTitle>Create New Permission</CardTitle>
                <CardDescription
                    >Add a new permission to the system</CardDescription
                >
            </CardHeader>
            <CardContent>
                <PermissionForm 
                    :on-submit="handleSubmit"
                    :processing="false"
                />
            </CardContent>
        </Card>

        <!-- Permissions List -->
        <Card>
            <CardHeader>
                <CardTitle>Existing Permissions</CardTitle>
                <CardDescription>All permissions in the system</CardDescription>
            </CardHeader>
            <CardContent>
                <div
                    v-if="props.permissions.length === 0"
                    class="text-center py-4 text-gray-500"
                >
                    No permissions found. Create your first permission above.
                </div>

                <div
                    v-else
                    class="grid grid-cols-1 gap-4"
                >
                    <PermissionItem
                        v-for="permission in props.permissions"
                        :key="permission.id"
                        :permission="permission"
                    />
                </div>
            </CardContent>
        </Card>
    </div>
</template>
