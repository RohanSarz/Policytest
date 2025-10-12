<script setup>
defineProps({
    class: {
        type: String,
        default: "size-8",
        required: false,
    },
});
</script>

<template>
    <Link as="image" :href="route('dashboard')">
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
