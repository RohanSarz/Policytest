<script setup lang="ts">
import Footer from "@/components/Footer.vue";
import Navigation from "@/components/Navigation.vue";
import Toaster from "@/components/Toaster.vue";
import AOS from "aos";
import "aos/dist/aos.css";

AOS.init();
</script>

<template>
    <div class="space-x-12">
        <div class="pb-9">
            <header
                id="header"
                class="fixed w-full flex flex-col top-0 left-0 z-10"
            >
                <Navigation />
            </header>
            <div class="fixed top-20 right-10 z-20">
                <Toaster />
            </div>
        </div>
        <main :key="$page.url" class="mx-auto pt-4 z-0">
            <slot />
        </main>
    </div>
    <footer>
        <Footer />
    </footer>
</template>
