<script setup>
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";
import { Card } from "@/components/ui/card";
import UserNameUpper from "@/components/userDataComponents/UserNameUpper.vue";
import { usePage } from "@inertiajs/vue3";
import { computed } from "vue";

const { post } = usePage().props;
const user = computed(() => post.user || {});
const category = computed(() => post.category || {});
</script>

<template>
    <div class="min-h-screen bg-gray-50">
        <!-- Header -->
        <header class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div
                    class="flex flex-col md:flex-row md:items-center gap-2 md:justify-between"
                >
                    <div>
                        {{ post.title }}

                        <p class="mt-1 text-sm text-gray-600">
                            By
                            <UserNameUpper v-if="user.name" :name="user.name" />
                        </p>
                    </div>
                </div>
            </div>
        </header>

        <!-- Post Content -->
        <main class="py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <Card>
                    <div class="flex items-center space-x-4">
                        <Avatar v-if="user">
                            <AvatarImage :src="user.avatar" alt="User Avatar" />
                            <AvatarFallback>{{ user.name[0] }}</AvatarFallback>
                        </Avatar>
                        <div>
                            <p class="text-sm font-medium text-gray-900">
                                {{ user.name }}
                            </p>
                            <p class="text-sm text-gray-500">
                                {{ user.email }}
                            </p>
                        </div>
                    </div>
                    <div class="mt-4">
                        {{ post.body }}
                    </div>
                    <div class="mt-4">
                        <span class="text-sm font-semibold text-gray-600"
                            >Category:</span
                        >
                        <span class="text-sm text-gray-800">{{
                            category.name
                        }}</span>
                    </div>
                </Card>
            </div>
        </main>
    </div>
</template>
