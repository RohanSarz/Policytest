<script setup lang="ts">
import Button from "@/components/ui/button/Button.vue";
import { Post } from "@/types/Post";
import { Bookmark, BookmarkCheck, Heart, HeartIcon } from "lucide-vue-next";
import { ref } from "vue";

const props = defineProps<{ post: Post }>();
const post = props.post;
const isBookmarked = ref(false);

const toggleBookmark = async () => {
    isBookmarked.value = !isBookmarked.value;
};
</script>

<template>
    <div class="max-w-7xl min-h-screen mx-auto bg-gray-50 pt-4">
        <!-- Banner  -->
        <div
            v-if="post"
            class="relative rounded-t-2xl overflow-hidden shadow-sm"
        >
            <!-- Cover Image -->
            <img
                :src="'/storage/' + post.cover_image"
                :alt="post.title.slice(0, 20) + ' Cover Image'"
                class="w-full h-[22rem] object-cover"
            />
            <!-- Overlay -->
            <div
                class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent p-6 flex items-end justify-between"
            >
                <div>
                    <!-- Title -->
                    <h2
                        class="text-white text-wrap text-3xl font-semibold drop-shadow-sm cursor-pointer group"
                        data-aos="fade-in"
                        data-aos-duration="600"
                    >
                        {{ post.title }}

                        <p
                            v-if="post.excerpt"
                            class="text-gray-300 text-base drop-shadow-sm overflow-hidden max-h-0 opacity-0 -translate-y-2 transition-all duration-600 ease-in-out group-hover:max-h-110 group-hover:opacity-100 group-hover:translate-y-0"
                        >
                            {{ post.excerpt }}
                        </p>
                    </h2>
                    <!-- Author and Date -->
                    <span class="text-xs text-white mt-1">
                        by {{ post.user.name }}, {{ post.created_for_human }}
                    </span>
                </div>
                <div class="float-left">
                    <button @click="toggleBookmark">
                        <component
                            v-if="!isBookmarked"
                            :is="Bookmark"
                            class="size-8 text-white/80"
                        ></component>
                        <component
                            v-else
                            :is="BookmarkCheck"
                            class="size-8 text-yellow-400/80"
                        ></component>
                    </button>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div
            class="w-full bg-white shadow-sm content-display p-6 leading-8 text-[1.05rem]"
            v-html="post.content"
        ></div>
    </div>
</template>
