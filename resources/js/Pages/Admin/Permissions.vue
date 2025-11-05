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
import { useForm } from "@inertiajs/vue3";

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

// Define form for creating new permissions
const form = useForm({
    name: "",
});

// Function to handle form submission
function submitForm() {
    form.post("/admin/permissions", {
        onSuccess: () => {
            form.reset();
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
                <form @submit.prevent="submitForm" class="space-y-4">
                    <div>
                        <Label for="permissionName">Permission Name</Label>
                        <Input
                            id="permissionName"
                            v-model="form.name"
                            placeholder="Enter permission name (e.g., create-posts, edit-users)"
                            :disabled="form.processing"
                        />
                        <div
                            v-if="form.errors.name"
                            class="text-red-500 text-sm mt-1"
                        >
                            {{ form.errors.name }}
                        </div>
                    </div>

                    <Button
                        type="submit"
                        :disabled="form.processing"
                        class="w-full md:w-auto"
                    >
                        <span v-if="!form.processing">Create Permission</span>
                        <span v-else>Creating...</span>
                    </Button>
                </form>
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
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4"
                >
                    <div
                        v-for="permission in props.permissions"
                        :key="permission.id"
                        class="border p-4 rounded-lg flex justify-between items-center"
                    >
                        <span class="font-medium">{{ permission.name }}</span>
                        <span class="text-xs text-gray-500">
                            Created:
                            {{
                                new Date(
                                    permission.created_at,
                                ).toLocaleDateString()
                            }}
                        </span>
                    </div>
                </div>
            </CardContent>
        </Card>
    </div>
</template>
