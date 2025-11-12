<script setup lang="ts">
import { ref } from "vue";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";

const email = ref("");
const isSubscribed = ref(false);
const isLoading = ref(false);

const subscribe = () => {
  if (!email.value) return;
  
  isLoading.value = true;
  
  // In a real application, you would send the email to your backend
  // For now, we'll just show a success message
  setTimeout(() => {
    isLoading.value = false;
    isSubscribed.value = true;
    email.value = "";
    
    // Reset after 5 seconds
    setTimeout(() => {
      isSubscribed.value = false;
    }, 5000);
  }, 1000);
};
</script>

<template>
  <div class="bg-blue-50 p-6 rounded-xl">
    <h3 class="text-lg font-bold text-gray-900 mb-2">Stay Informed</h3>
    <p class="text-gray-600 mb-4 text-sm">
      Subscribe to our newsletter and never miss an update from the world of news.
    </p>
    
    <div v-if="!isSubscribed" class="flex flex-col sm:flex-row gap-2">
      <Input
        v-model="email"
        type="email"
        placeholder="Your email address"
        class="flex-1"
      />
      <Button 
        @click="subscribe" 
        :disabled="isLoading"
        class="bg-blue-600 hover:bg-blue-700"
      >
        <span v-if="!isLoading">Subscribe</span>
        <span v-else>Subscribing...</span>
      </Button>
    </div>
    
    <div v-else class="bg-green-100 text-green-700 p-3 rounded-md text-sm">
      Thank you for subscribing! Please check your email to confirm your subscription.
    </div>
  </div>
</template>