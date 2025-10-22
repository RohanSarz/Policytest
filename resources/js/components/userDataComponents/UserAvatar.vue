<script setup>
import { usePage } from "@inertiajs/vue3";
import { computed } from "vue";
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";
const page = usePage();

// Safely access user — fallback to empty object if missing
const user = computed(() => page.props.auth?.user || {});
</script>
<template>
    <Avatar class="ring-1">
        <AvatarImage
            :src="
                user.avatar
                    ? `/storage/${user.avatar}`
                    : '/storage/avatars/def.jpg'
            "
            :alt="user.name[0].toUpperCase()"
        />
        <AvatarFallback>{{
            user.name?.charAt(0).toUpperCase()
        }}</AvatarFallback>
    </Avatar>
</template>
