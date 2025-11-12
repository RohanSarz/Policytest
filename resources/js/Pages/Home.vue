<script setup lang="ts">
import { computed } from "vue";
import { usePage, Link, usePoll } from "@inertiajs/vue3";
import { index as postsIndex } from "@/routes/posts";
import { show as categoryShow } from "@/routes/categories";
import ArticleCard from "@/components/Article/ArticleCard.vue";
import BreakingNewsTicker from "@/components/Article/BreakingNewsTicker.vue";
import CategoryBar from "@/components/Article/CategoryBar.vue";
import NewsletterSubscription from "@/components/Article/NewsletterSubscription.vue";
import TrendingSidebar from "@/components/Article/TrendingSidebar.vue";
import { PageProps } from "@/types/Post"; // Import the shared types

// Get page props from Inertia
const page = usePage<PageProps>().props; // Type the page props

// Extract data from page props
const posts = page.posts; // Array of posts
const categories = page.categories; // Array of categories
const currentCategory = page.currentCategory; // Current category if on a category page
const livePosts = page.livePosts; // Live posts

// Fix undefined variables by defining them
const allPosts = posts || []; // Fallback to empty array if posts is undefined
const featuredPost = allPosts[0] || null; // First post as featured
const regularPosts = allPosts.slice(1, 4); // Next 3 posts as regular news
const sidebarPosts = allPosts.slice(4, 8); // Next 4 posts for sidebar

usePoll(2000); // Auto-refresh data every 2 seconds

// Compute active category slug for highlighting active link
const activeCategorySlug = currentCategory?.slug || null;
</script>

<template>
    <div class="max-w-7xl mx-auto px-4 py-4 sm:px-6 lg:px-8">
        <!-- Breaking News Ticker -->
        <BreakingNewsTicker 
            v-if="livePosts && livePosts.length > 0" 
            :posts="livePosts" 
        />
        
        <!-- Category Navigation Bar -->
        <CategoryBar 
            :categories="categories || []" 
            :active-category="activeCategorySlug"
            class="my-4"
        />
        
        <!-- Featured Article Section -->
        <section class="mb-12" v-if="featuredPost">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Featured Story</h2>
            <ArticleCard 
                :post="featuredPost" 
                type="featured"
            />
        </section>
        
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Main Content Column -->
            <div class="lg:col-span-3">
                <!-- Regular News Section -->
                <section class="mb-12">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-900">Latest News</h2>
                        <Link 
                            :href="postsIndex().url" 
                            class="text-blue-700 hover:text-blue-800 text-sm font-medium"
                        >
                            View All
                        </Link>
                    </div>
                    
                    <div class="space-y-6">
                        <ArticleCard 
                            v-for="post in regularPosts" 
                            :key="post.id" 
                            :post="post" 
                            type="regular"
                        />
                    </div>
                </section>
            </div>
            
            <!-- Sidebar Column -->
            <div class="lg:col-span-1 space-y-8">
                <!-- Newsletter Subscription -->
                <NewsletterSubscription />
                
                <!-- Trending Section -->
                <TrendingSidebar 
                    :posts="sidebarPosts" 
                />
            </div>
        </div>
    </div>
</template>
