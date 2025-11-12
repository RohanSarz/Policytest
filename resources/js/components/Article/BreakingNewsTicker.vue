<script setup lang="ts">
import { Post } from "@/types/Post";
import { ref, onMounted, onUnmounted } from "vue";

interface Props {
  posts: Post[];
}

const props = defineProps<Props>();
const currentIndex = ref(0);
let intervalId: number | null = null;

const startTicker = () => {
  intervalId = window.setInterval(() => {
    currentIndex.value = (currentIndex.value + 1) % props.posts.length;
  }, 5000); // Change every 5 seconds
};

const stopTicker = () => {
  if (intervalId) {
    clearInterval(intervalId);
    intervalId = null;
  }
};

onMounted(() => {
  startTicker();
});

onUnmounted(() => {
  stopTicker();
});
</script>

<template>
  <div 
    class="bg-red-600 text-white py-2 px-4 flex items-center overflow-hidden"
    @mouseenter="stopTicker"
    @mouseleave="startTicker"
  >
    <span class="font-bold mr-4 uppercase">Breaking News</span>
    <div class="overflow-hidden whitespace-nowrap flex-1">
      <div 
        class="animate-marquee whitespace-nowrap inline-block"
        :key="currentIndex"
      >
        <span>{{ props.posts[currentIndex]?.title || '' }}</span>
      </div>
    </div>
  </div>
</template>

<style scoped>
@keyframes marquee {
  0% { transform: translateX(100%); }
  100% { transform: translateX(-100%); }
}

.animate-marquee {
  animation: marquee 15s linear infinite;
  display: inline-block;
}
</style>