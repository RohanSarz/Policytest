<script setup>
defineProps({
    name: {
        type: String,
        required: true,
    },
});

// Capitalize the first letter of the user's name
const capitalizeName = (name) => {
    if (!name) return "";
    return name.charAt(0).toUpperCase() + name.slice(1);
};
</script>

<template>
    <span>{{ name.charAt(0).toUpperCase() + name.slice(1) }}</span>
</template>
