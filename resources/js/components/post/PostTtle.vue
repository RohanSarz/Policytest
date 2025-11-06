<script setup lang="ts">
import { usePage } from "@inertiajs/vue3";

const page = usePage();
const { post } = defineProps({
    post: Object,
});
</script>

<template>
    {{ post.title }}
</template>
