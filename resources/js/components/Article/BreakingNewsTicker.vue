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
  if (props.posts.length <= 1) return; // No need to cycle if there's only one post
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
    class="bg-red-600 text-white py-3 px-4 flex items-center overflow-hidden"
    @mouseenter="stopTicker"
    @mouseleave="startTicker"
  >
    <span class="font-bold mr-4 uppercase flex-shrink-0">Breaking News</span>

    <div class="flex-1 overflow-hidden">
      <transition
        name="fade"
        mode="out-in"
        appear
      >
        <div
          :key="currentIndex"
          class="h-6 flex items-center"
        >
          <span class="truncate">{{ props.posts[currentIndex]?.title || '' }}</span>
        </div>
      </transition>
    </div>
  </div>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>