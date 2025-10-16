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
    const big = name.charAt(0).toUpperCase();
    const rest = name.slice(1).toLowerCase();
    return big + rest;
};
</script>

<template>
    <span>{{ capitalizeName(name) }}</span>
</template>
