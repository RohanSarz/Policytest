<script setup lang="ts">
import { usePage, Link } from "@inertiajs/vue3";
import { show } from "@/routes/posts";
import ArticleCard from "@/components/Article/ArticleCard.vue";
import NewsletterSubscription from "@/components/Article/NewsletterSubscription.vue";
import TrendingSidebar from "@/components/Article/TrendingSidebar.vue";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";
import type { PageProps } from "@inertiajs/core";
import ProfileHeader from "@/components/profile/ProfileHeader.vue";
import ProfileContent from "@/components/profile/ProfileContent.vue";

interface User {
    id: number;
    name: string;
    email: string;
    avatar?: string;
    bio?: string;
    created_at: string;
}

interface Post {
    id: number;
    title: string;
    excerpt: string;
    slug: string;
    created_at: string;
    cover_image?: string;
    category: {
        id: number;
        name: string;
        slug: string;
    };
    user: User;
}

interface Props extends PageProps {
    user: User;
    posts: Post[];
    trendingPosts: Post[];
}

const page = usePage<Props>();
const { user, posts, trendingPosts } = page.props;
</script>

<template>
    <div class="max-w-7xl mx-auto px-4 py-6 sm:px-6 lg:px-8">
        <div class="space-y-8">
            <!-- Profile Header -->
            <ProfileHeader />

            <!-- Profile Content Tabs -->
            <ProfileContent />
        </div>
    </div>
</template>
