<script setup lang="ts">
import { ProfileHeader, ProfileContent } from "@/components/profile";
</script>

<template>
    <div class="px-10 py-10 space-y-6">
        <Head title="Profile" />

        <div data-aos="fade-right" data-aos-duration="300">
            <ProfileHeader />
        </div>
        <div data-aos="fade-right" data-aos-duration="350">
            <ProfileContent />
        </div>
    </div>
</template>
