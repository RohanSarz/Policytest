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
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from "@/components/ui/select";
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";
import {
    storeUser,
    deleteUser,
} from "@/actions/App/Http/Controllers/AdminController";

// Define interfaces
interface Role {
    id: number;
    name: string;
    guard_name: string;
    created_at: string;
    updated_at: string;
}

interface UserRole {
    id: number;
    name: string;
    guard_name: string;
    created_at: string;
    updated_at: string;
}

interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
    roles: UserRole[];
}

interface Props {
    users: User[];
    roles: Role[];
}

// Define props
const props = defineProps<Props>();

// Define form for creating new users
const form = useForm({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
    role: "",
});

// Function to handle form submission
function submitForm() {
    form.post(storeUser().url, {
        onSuccess: () => {
            form.reset();
        },
    });
}

// Function to handle user deletion
function deleteUser(userId: number) {
    if (confirm("Are you sure you want to delete this user?")) {
        // Using Inertia.delete to make a DELETE request
        // We'll create a temporary form just for this action
        const deleteForm = useForm({});
        deleteForm.delete(deleteUser(userId).url, {
            onSuccess: () => {},
        });
    }
}

defineOptions({
    layout: AdminLayout,
});
</script>

<template>
    <div class="mx-auto px-4">
        <h1 class="text-2xl text-left font-bold px-2 py-4 mb-6 border-b">
            User Management
        </h1>

        <!-- Create User Card -->
        <Card class="mb-8">
            <CardHeader>
                <CardTitle>Create New User</CardTitle>
                <CardDescription>Add a new user to the system</CardDescription>
            </CardHeader>
            <CardContent>
                <form @submit.prevent="submitForm" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <Label for="name">Name</Label>
                            <Input
                                id="name"
                                v-model="form.name"
                                placeholder="Enter user's name"
                                :disabled="form.processing"
                            />
                            <div
                                v-if="form.errors.name"
                                class="text-red-500 text-sm mt-1"
                            >
                                {{ form.errors.name }}
                            </div>
                        </div>

                        <div>
                            <Label for="email">Email</Label>
                            <Input
                                id="email"
                                v-model="form.email"
                                type="email"
                                placeholder="Enter user's email"
                                :disabled="form.processing"
                            />
                            <div
                                v-if="form.errors.email"
                                class="text-red-500 text-sm mt-1"
                            >
                                {{ form.errors.email }}
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <Label for="password">Password</Label>
                            <Input
                                id="password"
                                v-model="form.password"
                                type="password"
                                placeholder="Enter password"
                                :disabled="form.processing"
                            />
                            <div
                                v-if="form.errors.password"
                                class="text-red-500 text-sm mt-1"
                            >
                                {{ form.errors.password }}
                            </div>
                        </div>

                        <div>
                            <Label for="password_confirmation"
                                >Confirm Password</Label
                            >
                            <Input
                                id="password_confirmation"
                                v-model="form.password_confirmation"
                                type="password"
                                placeholder="Confirm password"
                                :disabled="form.processing"
                            />
                        </div>
                    </div>

                    <div>
                        <Label for="role">Role (Optional)</Label>
                        <Select v-model="form.role" :disabled="form.processing">
                            <SelectTrigger>
                                <SelectValue placeholder="Select a role" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem
                                    v-for="role in props.roles"
                                    :key="role.id"
                                    :value="role.name"
                                >
                                    {{ role.name }}
                                </SelectItem>
                            </SelectContent>
                        </Select>
                        <div
                            v-if="form.errors.role"
                            class="text-red-500 text-sm mt-1"
                        >
                            {{ form.errors.role }}
                        </div>
                    </div>

                    <Button
                        type="submit"
                        :disabled="form.processing"
                        class="w-full md:w-auto"
                    >
                        <span v-if="!form.processing">Create User</span>
                        <span v-else>Creating...</span>
                    </Button>
                </form>
            </CardContent>
        </Card>

        <!-- Users Table -->
        <Card>
            <CardHeader>
                <CardTitle>Users List</CardTitle>
                <CardDescription
                    >Manage existing users in the system</CardDescription
                >
            </CardHeader>
            <CardContent>
                <!-- Desktop Table View -->
                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b">
                                <th class="py-2 px-4 text-left">Name</th>
                                <th class="py-2 px-4 text-left">Email</th>
                                <th class="py-2 px-4 text-left">Role</th>
                                <th class="py-2 px-4 text-left">Verified</th>
                                <th class="py-2 px-4 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="user in props.users"
                                :key="user.id"
                                class="border-b hover:bg-gray-50"
                            >
                                <td class="py-2 px-4">{{ user.name }}</td>
                                <td class="py-2 px-4">{{ user.email }}</td>
                                <td class="py-2 px-4">
                                    <span
                                        v-for="role in user.roles"
                                        :key="role.id"
                                        class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded mr-1"
                                    >
                                        {{ role.name }}
                                    </span>
                                    <span
                                        v-if="user.roles.length === 0"
                                        class="text-gray-500 text-sm italic"
                                    >
                                        No role
                                    </span>
                                </td>
                                <td class="py-2 px-4">
                                    <span
                                        :class="{
                                            'text-green-500':
                                                user.email_verified_at,
                                            'text-red-500':
                                                !user.email_verified_at,
                                        }"
                                    >
                                        {{
                                            user.email_verified_at
                                                ? "Yes"
                                                : "No"
                                        }}
                                    </span>
                                </td>
                                <td class="py-2 px-4">
                                    <Button
                                        variant="destructive"
                                        size="sm"
                                        @click="deleteUser(user.id)"
                                    >
                                        Delete
                                    </Button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Card View -->
                <div class="md:hidden space-y-4">
                    <div
                        v-for="user in props.users"
                        :key="user.id"
                        class="border rounded-lg p-4"
                    >
                        <div class="flex justify-between items-start">
                            <div class="flex-1 min-w-0">
                                <h3 class="font-medium text-sm">
                                    {{ user.name }}
                                </h3>
                                <p class="text-xs text-gray-500 truncate mt-1">
                                    {{ user.email }}
                                </p>
                                <div class="mt-2">
                                    <span
                                        v-for="role in user.roles"
                                        :key="role.id"
                                        class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded mr-1"
                                    >
                                        {{ role.name }}
                                    </span>
                                    <span
                                        v-if="user.roles.length === 0"
                                        class="text-gray-500 text-xs italic"
                                    >
                                        No role
                                    </span>
                                </div>
                                <p
                                    class="text-xs mt-2"
                                    :class="{
                                        'text-green-500':
                                            user.email_verified_at,
                                        'text-red-500': !user.email_verified_at,
                                    }"
                                >
                                    Verified:
                                    {{ user.email_verified_at ? "Yes" : "No" }}
                                </p>
                            </div>
                            <div class="ml-2">
                                <Button
                                    variant="destructive"
                                    size="sm"
                                    @click="deleteUser(user.id)"
                                >
                                    Delete
                                </Button>
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    v-if="props.users.length === 0"
                    class="text-center py-4 text-gray-500"
                >
                    No users found. Create your first user above.
                </div>
            </CardContent>
        </Card>
    </div>
</template>
