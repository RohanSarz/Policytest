<script setup lang="ts">
import Button from "../ui/button/Button.vue";
</script>

<template>
    <Link :as="Button" variant="outline" :href="route('posts.create')"
        >Create</Link
    >
</template>
