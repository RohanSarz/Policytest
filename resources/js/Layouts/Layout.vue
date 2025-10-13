<script setup lang="ts">
import { usePage } from "@inertiajs/vue3";
import Navigation from "@/components/Navigation.vue";

const page = usePage();
</script>

<template>
    <div class="w-full flex flex-col">
        <header class=""><Navigation /></header>

        <main class="grid col-span-1 px-3 mt-4">
            <transition
                enter-active-class="transition duration-400 ease-out transform"
                enter-from-class="translate-y-10 opacity-0"
                leave-active-class="transition duration-300 ease-in transform"
                leave-to-class="translate-y-12 opacity-0"
                mode="out-in"
            >
                <div :key="page.url" class="grid col-span-1 place-items-center">
                    <slot />
                </div>
            </transition>
        </main>
    </div>
</template>
