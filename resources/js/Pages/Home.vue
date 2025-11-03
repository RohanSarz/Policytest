<script setup>
import { usePage } from "@inertiajs/vue3";

let can = [...usePage().props.auth.can];
</script>
<template>
    {{ can }}
    sdsdsdsd
    {{ can["manage-users"] }}
</template>
