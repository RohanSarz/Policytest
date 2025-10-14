<script setup lang="ts">
import UserNameUpper from "@/components/userDataComponents/UserNameUpper.vue";
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";
import { usePage } from "@inertiajs/vue3";
const page = usePage();
const user = page.props.auth.user;
</script>
<template>
    <div v-if="user" class="flex flex-col items-center text-center">
        <!-- User Avatar -->
        <Avatar class="size-16 ring-1">
            <AvatarImage
                class="border"
                :src="`storage/${user.avatar}`"
                alt="@radix-vue"
            />
            <AvatarFallback v-if="!user.avatar">{{
                user.name[0].toUpperCase()
            }}</AvatarFallback>
        </Avatar>
        <!-- User Name -->
        <h2 class="text-lg font-medium text-gray-900 mt-3">
            <UserNameUpper :name="user.name" />
        </h2>
        <p class="text-gray-600 text-sm">
            {{ user.email }}
        </p>
        <!-- User Role-->
        <div class="mt-2 flex flex-wrap justify-center gap-2">
            <span
                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800"
            >
                {{ user.role }} Admin
            </span>
        </div>
    </div>
</template>
