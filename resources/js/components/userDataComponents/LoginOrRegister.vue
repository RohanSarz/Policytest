<script setup lang="ts">
import { usePage } from "@inertiajs/vue3";

const page = usePage();
</script>

<template>
    <li v-if="!$page.props.auth.user" class="space-x-2">
        Please
        <Link
            class="hover:underline hover:text-green-300"
            :class="{ 'text-green-300': $page.url === '/login' }"
            href="/login"
            >Login</Link
        >
        or
        <Link class="hover:underline hover:text-blue-300" href="/register">
            Register</Link
        >
        to continue.
    </li>
</template>
