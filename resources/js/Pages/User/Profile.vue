<script setup lang="ts">
import { usePage, Link } from "@inertiajs/vue3";
import { show } from "@/routes/posts";
import ArticleCard from "@/components/Article/ArticleCard.vue";
import NewsletterSubscription from "@/components/Article/NewsletterSubscription.vue";
import TrendingSidebar from "@/components/Article/TrendingSidebar.vue";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";

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

interface Props {
  user: User;
  posts: Post[];
  trendingPosts: Post[];
}

const page = usePage<Props>();
const props = page.props;
</script>

<template>
  <div class="max-w-7xl mx-auto px-4 py-6 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
      <!-- Main Content Column -->
      <div class="lg:col-span-3">
        <!-- Author Profile Header -->
        <section class="mb-12">
          <Card class="overflow-hidden">
            <div class="bg-gradient-to-r from-blue-500 to-blue-700 h-32"></div>
            
            <div class="p-6 -mt-16">
              <div class="flex flex-col md:flex-row items-start gap-6">
                <Avatar class="w-24 h-24 ring-4 ring-white">
                  <AvatarImage 
                    v-if="user.avatar" 
                    :src="`/storage/${user.avatar}`" 
                    :alt="user.name" 
                  />
                  <AvatarFallback class="text-2xl">
                    {{ user.name.charAt(0) }}
                  </AvatarFallback>
                </Avatar>
                
                <div class="flex-1 mt-4 md:mt-0">
                  <h1 class="text-3xl font-bold text-gray-900">{{ user.name }}</h1>
                  <p class="text-gray-600 mt-1">{{ user.email }}</p>
                  
                  <div v-if="user.bio" class="mt-4">
                    <h3 class="font-semibold text-gray-900">About</h3>
                    <p class="text-gray-700 mt-1">{{ user.bio }}</p>
                  </div>
                  
                  <div class="mt-4 flex flex-wrap gap-2">
                    <span class="inline-block bg-blue-100 text-blue-700 text-xs px-2 py-1 rounded">
                      {{ posts.length }} articles
                    </span>
                    <span class="inline-block bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded">
                      Joined {{ new Date(user.created_at).getFullYear() }}
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </Card>
        </section>
        
        <!-- Author's Articles -->
        <section>
          <h2 class="text-2xl font-bold text-gray-900 mb-6">Articles by {{ user.name }}</h2>
          
          <div v-if="posts.length > 0" class="space-y-6">
            <ArticleCard 
              v-for="post in posts" 
              :key="post.id" 
              :post="post" 
              type="regular"
            />
          </div>
          
          <div v-else class="text-center py-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-2">
              No articles found
            </h3>
            <p class="text-gray-600">{{ user.name }} hasn't published any articles yet.</p>
          </div>
        </section>
      </div>
      
      <!-- Sidebar Column -->
      <div class="lg:col-span-1 space-y-8">
        <!-- Newsletter Subscription -->
        <NewsletterSubscription />
        
        <!-- Trending Section -->
        <TrendingSidebar 
          :posts="trendingPosts" 
        />
      </div>
    </div>
  </div>
</template>