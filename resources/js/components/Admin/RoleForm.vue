<script setup lang="ts">
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";

interface Permission {
    id: number;
    name: string;
    guard_name: string;
    created_at: string;
    updated_at: string;
}

interface Props {
    permissions: Permission[];
    onSubmit: (data: { name: string; permissions: string[] }) => void;
    processing: boolean;
    errors?: Record<string, string>;
}

const props = defineProps<Props>();
const form = useForm({
    name: "",
    permissions: [] as string[],
});

const selectedPermission = ref("");

const handleSubmit = () => {
    props.onSubmit(form.data());
    form.reset();
};

const togglePermission = (permissionName: string) => {
    const index = form.permissions.indexOf(permissionName);
    if (index > -1) {
        // Remove permission
        form.permissions = form.permissions.filter(
            (perm) => perm !== permissionName
        );
    } else {
        // Add permission
        form.permissions = [...form.permissions, permissionName];
    }
};

const addPermission = () => {
    if (selectedPermission.value && !form.permissions.includes(selectedPermission.value)) {
        form.permissions = [...form.permissions, selectedPermission.value];
        selectedPermission.value = "";
    }
};

const removePermission = (permissionName: string) => {
    form.permissions = form.permissions.filter(perm => perm !== permissionName);
};
</script>

<template>
    <form @submit.prevent="handleSubmit" class="space-y-4">
        <div>
            <Label for="roleName">Role Name</Label>
            <Input
                id="roleName"
                v-model="form.name"
                placeholder="Enter role name"
                :disabled="processing"
            />
            <div
                v-if="errors?.name"
                class="text-red-500 text-sm mt-1"
            >
                {{ errors.name }}
            </div>
        </div>

        <div>
            <Label>Permissions</Label>
            <div class="mt-2">
                <div
                    v-if="form.permissions.length > 0"
                    class="flex flex-wrap gap-2"
                >
                    <span
                        v-for="permissionName in form.permissions"
                        :key="permissionName"
                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800"
                    >
                        {{ permissionName }}
                        <button
                            type="button"
                            @click="removePermission(permissionName)"
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
                        v-model="selectedPermission"
                        class="mt-1 block w-1/3 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                        @change="addPermission"
                    >
                        <option value="">Add a permission</option>
                        <option
                            v-for="permission in props.permissions"
                            :key="permission.name"
                            :value="permission.name"
                            :disabled="form.permissions.includes(permission.name)"
                        >
                            {{ permission.name }}
                        </option>
                    </select>
                </div>
            </div>
        </div>

        <Button
            type="submit"
            :disabled="processing"
            class="w-full md:w-auto"
        >
            <span v-if="!processing">Create Role</span>
            <span v-else>Creating...</span>
        </Button>
    </form>
</template>