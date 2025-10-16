<script setup lang="ts">
import Button from "@/components/ui/button/Button.vue";
import { Link } from "@inertiajs/vue3";
</script>

<template>
    <Link :href="route('posts.create')">
        <Button variant="outline">Create Post</Button>
    </Link>
</template>
