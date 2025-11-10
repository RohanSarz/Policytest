<script setup lang="ts">
import Button from "@/components/ui/button/Button.vue";
import { Link } from "@inertiajs/vue3";
import { create } from "@/actions/App/Http/Controllers/PostController";
</script>

<template>
    <Link :href="create().url">
        <Button variant="outline">Create Post</Button>
    </Link>
</template>
