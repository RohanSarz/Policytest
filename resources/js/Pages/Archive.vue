<script setup lang="ts">
import { ref, computed } from "vue";
import { Link } from "@inertiajs/vue3";
import { show } from "@/routes/posts";
import { show as categoryShow } from "@/routes/categories";
import ArticleCard from "@/components/Article/ArticleCard.vue";
import NewsletterSubscription from "@/components/Article/NewsletterSubscription.vue";
import TrendingSidebar from "@/components/Article/TrendingSidebar.vue";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { Button } from "@/components/ui/button";

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
  user: {
    id: number;
    name: string;
  };
}

interface Props {
  posts: Post[];
  categories: {
    id: number;
    name: string;
    slug: string;
  }[];
}

const props = defineProps<Props>();

// Group posts by year and month
const groupedPosts = computed(() => {
  const groups: Record<string, Post[]> = {};
  
  props.posts.forEach(post => {
    const date = new Date(post.created_at);
    const year = date.getFullYear();
    const month = date.toLocaleString('default', { month: 'long' });
    const key = `${year} ${month}`;
    
    if (!groups[key]) {
      groups[key] = [];
    }
    groups[key].push(post);
  });
  
  return groups;
});

// Get all unique years
const years = computed(() => {
  return Object.keys(groupedPosts.value).map(key => key.split(' ')[0]).filter((year, index, self) => self.indexOf(year) === index);
});

// Get posts by year
const getPostsByYear = (year: string) => {
  return Object.keys(groupedPosts.value)
    .filter(key => key.startsWith(year))
    .reduce((acc, key) => {
      acc[key] = groupedPosts.value[key];
      return acc;
    }, {} as Record<string, Post[]>);
};
</script>

<template>
  <div class="max-w-7xl mx-auto px-4 py-6 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
      <!-- Main Content Column -->
      <div class="lg:col-span-3">
        <section class="mb-12">
          <h1 class="text-3xl font-bold text-gray-900 mb-6">Article Archive</h1>
          
          <div class="space-y-12">
            <div v-for="year in years" :key="year">
              <h2 class="text-2xl font-bold text-gray-900 mb-6">{{ year }}</h2>
              
              <div v-for="(posts, month) in getPostsByYear(year)" :key="month" class="mb-8">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">{{ month }}</h3>
                
                <div class="space-y-4">
                  <div 
                    v-for="post in posts" 
                    :key="post.id" 
                    class="flex items-start gap-4 p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors"
                  >
                    <img 
                      v-if="post.cover_image" 
                      :src="`/storage/${post.cover_image}`" 
                      alt="Post cover" 
                      class="w-24 h-16 object-cover rounded"
                    />
                    <div class="flex-1">
                      <h4 class="font-bold text-gray-900 line-clamp-2">
                        <Link :href="show(post.slug)" class="hover:text-blue-700">
                          {{ post.title }}
                        </Link>
                      </h4>
                      <p class="text-sm text-gray-500 mt-1">
                        {{ new Date(post.created_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' }) }} • 
                        {{ post.category.name }}
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <div v-if="posts.length === 0" class="text-center py-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-2">
              No archived articles
            </h3>
            <p class="text-gray-600">There are no archived articles to display.</p>
          </div>
        </section>
      </div>
      
      <!-- Sidebar Column -->
      <div class="lg:col-span-1 space-y-8">
        <!-- Newsletter Subscription -->
        <NewsletterSubscription />
        
        <!-- Trending Section -->
        <TrendingSidebar 
          :posts="posts.slice(0, 5)" 
        />
      </div>
    </div>
  </div>
</template>