<script setup lang="ts">
import Footer from "@/components/Footer.vue";
import Navigation from "@/components/Navigation.vue";
import Toaster from "@/components/Toaster.vue";
import Separator from "@/components/ui/separator/Separator.vue";
</script>

<template>
    <div class=" space-x-4">
        <div class="h-[4rem]">
            <header id="header" class="fixed w-full top-0 left-0 z-10">
                <Navigation />
            </header>
            <div class="fixed top-20 right-10 z-20">
                <Toaster />
            </div>
        </div>
        <main :key="$page.url" class="mx-auto z-0">
            <slot />
        </main>
        <footer>
            <Footer />
        </footer>
    </div>
</template>
