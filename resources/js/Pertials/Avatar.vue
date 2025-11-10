<script setup>
import { dashboardView } from "@/actions/App/Http/Controllers/UserDataController";

defineProps({
    class: {
        type: String,
        default: "size-8",
        required: false,
    },
});
</script>

<template>
    <Link as="image" :href="dashboardView().url">
        <img
            class="object-cover rounded-full"
            :class="class"
            :src="
                $page.props.auth.user.avatar
                    ? 'storage/' + $page.props.auth.user.avatar
                    : 'storage/avatars/default.jpg'
            "
            alt=""
        />
    </Link>
</template>
