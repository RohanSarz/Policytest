<script setup lang="ts">
import { ref, computed } from "vue";
import { usePage, Link } from "@inertiajs/vue3";
import { index as postsIndex, show } from "@/routes/posts";
import ArticleCard from "@/components/Article/ArticleCard.vue";
import CategoryBar from "@/components/Article/CategoryBar.vue";
import NewsletterSubscription from "@/components/Article/NewsletterSubscription.vue";
import TrendingSidebar from "@/components/Article/TrendingSidebar.vue";
import { Input } from "@/components/ui/input";
import { Button } from "@/components/ui/button";
import { Post, Category } from "@/types/Post";

interface Props {
  posts: Post[];
  categories: Category[];
  query?: string;
  category?: string;
}

const page = usePage<Props>();
const props = page.props;

const searchQuery = ref(props.query || "");
const selectedCategory = ref(props.category || "");

// Simulate the search functionality
const filteredPosts = computed(() => {
  let result = props.posts || [];
  
  // Filter by search query if provided
  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase();
    result = result.filter(post => 
      post.title.toLowerCase().includes(query) || 
      post.excerpt.toLowerCase().includes(query)
    );
  }
  
  // Filter by category if provided
  if (selectedCategory.value && selectedCategory.value !== "all") {
    result = result.filter(post => 
      post.category && post.category.slug === selectedCategory.value
    );
  }
  
  return result;
});

const search = () => {
  // In a real implementation, this would be handled by your Laravel backend
  // For now, we're filtering client-side
  console.log("Searching for:", searchQuery.value, "in category:", selectedCategory.value);
};

// Get trending posts (the first 5 posts for now)
const trendingPosts = computed(() => props.posts?.slice(0, 5) || []);
</script>

<template>
  <div class="max-w-7xl mx-auto px-4 py-6 sm:px-6 lg:px-8">
    <!-- Category Navigation Bar -->
    <CategoryBar 
      :categories="categories || []" 
      :active-category="selectedCategory"
      class="my-4"
    />
    
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
      <!-- Main Content Column -->
      <div class="lg:col-span-3">
        <!-- Search Section -->
        <section class="mb-12">
          <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Search Articles</h2>
            
            <div class="flex flex-col sm:flex-row gap-4 mb-6">
              <div class="flex-1">
                <Input
                  v-model="searchQuery"
                  type="text"
                  placeholder="Search for articles..."
                  @keyup.enter="search"
                  class="w-full"
                />
              </div>
              <Button @click="search" class="bg-blue-600 hover:bg-blue-700">
                Search
              </Button>
            </div>
            
            <!-- Search Results -->
            <div v-if="filteredPosts.length > 0">
              <h3 class="text-lg font-semibold text-gray-900 mb-4">
                {{ filteredPosts.length }} result(s) found for "{{ searchQuery }}"
              </h3>
              
              <div class="space-y-6">
                <ArticleCard 
                  v-for="post in filteredPosts" 
                  :key="post.id" 
                  :post="post" 
                  type="regular"
                />
              </div>
            </div>
            
            <div v-else-if="searchQuery" class="text-center py-8">
              <h3 class="text-lg font-semibold text-gray-900 mb-2">
                No results found for "{{ searchQuery }}"
              </h3>
              <p class="text-gray-600">Try different keywords or browse by category.</p>
            </div>
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