<script setup lang="ts">
import Navigation from "@/components/Navigation.vue";
</script>

<template>
    <div class="w-full flex flex-col">
        <header class=""><Navigation /></header>

        <main>
            <transition
                enter-active-class="transition duration-400 ease-out transform"
                enter-from-class="translate-y-10 opacity-0"
                leave-active-class="transition duration-300 ease-in transform"
                leave-to-class="translate-y-12 opacity-0"
                mode="out-in"
            >
                <div :key="$page.url" class="h-screen">
                    <slot />
                </div>
            </transition>
        </main>
    </div>
</template>
