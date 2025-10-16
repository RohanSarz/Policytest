<script setup lang="ts">
import { usePage } from "@inertiajs/vue3";
// Define props for the component
const prop = defineProps({
    errorName: {
        type: String,
        required: true,
    },
});
// Access the Inertia page props, which include errors
const { props: pageProps } = usePage();
</script>
<template>
    <!-- Display error message if it exists for the specified errorName -->
    <div class="text-xs text-red-500 m-0" v-if="$page.props.errors">
        {{ $page.props.errors[prop.errorName] }}
    </div>
</template>
