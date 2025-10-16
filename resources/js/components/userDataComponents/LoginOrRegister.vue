<script setup lang="ts">
import { usePage } from "@inertiajs/vue3";
<<<<<<< HEAD
=======
const page = usePage();
>>>>>>> 2a79c7e3c0681e4b9c4e00c23d755f56846b1f8b

const page = usePage();
</script>

<template>
    <li v-if="!$page.props.auth.user" class="space-x-2">
        Please
        <Link
            class="hover:underline hover:text-green-300"
<<<<<<< HEAD
            :class="{ 'text-green-300': $page.url === '/login' }"
=======
            :class="'text-green-300':fn() page.url === '/login'"
>>>>>>> 2a79c7e3c0681e4b9c4e00c23d755f56846b1f8b
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
