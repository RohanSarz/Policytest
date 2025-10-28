<script setup lang="ts">
import { ProfileHeader, ProfileContent } from "@/components/profile";
</script>

<template>
    <div class="px-10 py-10 space-y-6">
        <Head title="Profile" />

        <div data-aos="fade-right">
            <ProfileHeader />
        </div>
        <div data-aos="fade-right">
            <ProfileContent />
        </div>
    </div>
</template>
