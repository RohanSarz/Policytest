<script setup>
import { usePage } from "@inertiajs/vue3";
const page = usePage();

// Safely access user — fallback to empty object if missing
const user = computed(() => page.props.auth?.user || {});
</script>
<template>
    <Avatar class="ring-1">
        <AvatarImage
            :src="
                user.avatar
                    ? `/storage/${props.post.user.avatar}`
                    : '/storage/avatars/def.jpg'
            "
            :alt="user.name[0].toUpperCase()"
            @error="$event.target.src = '/storage/avatars/def.jpg'"
        />
        <AvatarFallback>{{
            user.name?.charAt(0).toUpperCase()
        }}</AvatarFallback>
    </Avatar>
</template>
