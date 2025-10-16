<script setup lang="ts">
<<<<<<< HEAD
import Button from "@/components/ui/button/Button.vue";
import { Link } from "@inertiajs/vue3";
</script>

<template>
    <Link :href="route('posts.create')">
        <Button variant="outline">Create Post</Button>
    </Link>
=======
import Button from "../ui/button/Button.vue";
</script>

<template>
    <Link :as="Button" variant="outline" :href="route('posts.create')"
        >Create</Link
    >
>>>>>>> 2a79c7e3c0681e4b9c4e00c23d755f56846b1f8b
</template>
