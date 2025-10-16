<script setup lang="ts">
import Footer from "@/components/Footer.vue";
import Navigation from "@/components/Navigation.vue";
</script>

<template>
    <div class="space-x-12">
        <div class="pb-9">
            <header class="fixed w-full flex flex-col z-50 top-0 left-0">
                <Navigation />
            </header>
        </div>

        <main :key="$page.url" class="mx-auto pt-4">
            <slot />
        </main>
    </div>
    <footer>
        <Footer />
    </footer>
</template>
