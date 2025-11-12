<script setup lang="ts">
import { computed } from "vue";
import { Share, Facebook, Twitter, Mail, Copy } from "lucide-vue-next";

interface Props {
  title: string;
  url: string;
}

const props = defineProps<Props>();

const shareData = {
  title: props.title,
  url: props.url,
};

const shareToFacebook = () => {
  const url = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(props.url)}`;
  window.open(url, '_blank');
};

const shareToTwitter = () => {
  const text = encodeURIComponent(`Check out this article: ${props.title}`);
  const url = `https://twitter.com/intent/tweet?text=${text}&url=${encodeURIComponent(props.url)}`;
  window.open(url, '_blank');
};

const shareViaEmail = () => {
  const subject = encodeURIComponent(`Interesting article: ${props.title}`);
  const body = encodeURIComponent(`Check out this article: ${props.url}`);
  window.location.href = `mailto:?subject=${subject}&body=${body}`;
};

const copyToClipboard = async () => {
  try {
    await navigator.clipboard.writeText(props.url);
    // Here you could show a notification that the link was copied
    alert('Link copied to clipboard!');
  } catch (err) {
    console.error('Failed to copy: ', err);
  }
};

const canShare = computed(() => {
  return navigator.share !== undefined;
});

const nativeShare = async () => {
  if (canShare.value) {
    try {
      await navigator.share(shareData);
    } catch (error) {
      console.error('Error sharing:', error);
    }
  }
};
</script>

<template>
  <div class="flex items-center space-x-2">
    <span class="text-sm text-gray-600 mr-2">Share:</span>
    
    <button 
      @click="shareToFacebook" 
      class="p-2 rounded-full hover:bg-gray-100 transition-colors"
      aria-label="Share on Facebook"
    >
      <Facebook class="w-4 h-4 text-blue-600" />
    </button>
    
    <button 
      @click="shareToTwitter" 
      class="p-2 rounded-full hover:bg-gray-100 transition-colors"
      aria-label="Share on Twitter"
    >
      <Twitter class="w-4 h-4 text-blue-500" />
    </button>
    
    <button 
      @click="shareViaEmail" 
      class="p-2 rounded-full hover:bg-gray-100 transition-colors"
      aria-label="Share via Email"
    >
      <Mail class="w-4 h-4 text-gray-600" />
    </button>
    
    <button 
      @click="copyToClipboard" 
      class="p-2 rounded-full hover:bg-gray-100 transition-colors"
      aria-label="Copy link"
    >
      <Copy class="w-4 h-4 text-gray-600" />
    </button>
    
    <button 
      v-if="canShare"
      @click="nativeShare" 
      class="p-2 rounded-full hover:bg-gray-100 transition-colors"
      aria-label="Share"
    >
      <Share class="w-4 h-4 text-gray-600" />
    </button>
  </div>
</template>