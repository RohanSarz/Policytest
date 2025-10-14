<script setup lang="ts">
import Navigation from "@/components/Navigation.vue";
</script>

<template>
    <div class="fixed inset-0 w-full flex flex-col z-10">
        <header class=""><Navigation /></header>

        <main>
            <div
                :key="$page.url"
                class="box place-items-center"
                data-aos="fade"
            >
                <slot />
            </div>
        </main>
    </div>
</template>
