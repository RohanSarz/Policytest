<script setup lang="ts">
import { show as userShow } from "@/routes/users";
import { show } from "@/routes/posts";
import { usePage } from "@inertiajs/vue3";
import { computed } from "vue";
import { Post } from "@/types/Post";
import ArticleHeader from "@/components/Article/ArticleHeader.vue";
import ArticleNavigation from "@/components/Article/ArticleNavigation.vue";
import SocialShare from "@/components/Article/SocialShare.vue";
import NewsletterSubscription from "@/components/Article/NewsletterSubscription.vue";
import TrendingSidebar from "@/components/Article/TrendingSidebar.vue";

interface Props {
    post: Post;
    previousPost?: Post;
    nextPost?: Post;
    relatedPosts?: Post[];
    trendingPosts?: Post[];
}

const props = defineProps<Props>();
const { post } = usePage().props;

// Function to render HTML content from TinyMCE
const renderContent = (content: string) => {
    if (!content) {
        return "";
    }
    
    // If content is a JSON string, it might be from the old TipTap implementation
    if (
        typeof content === "string" &&
        (content.startsWith("{") || content.startsWith("["))
    ) {
        try {
            const parsedContent = JSON.parse(content);
            // If it's a valid JSON object, it could be TipTap content
            // For now, we'll return a message indicating this needs conversion
            console.warn("TipTap JSON content detected - needs conversion");
            return `<p class="text-red-500">Content format needs update - please edit and save this post to convert to TinyMCE format.</p>`;
        } catch (e) {
            // If it's not valid JSON, return as HTML
            return content;
        }
    }
    
    // Otherwise, return the content as HTML
    return content;
};
</script>

<template>
    <div class="min-h-screen bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <!-- Article Header -->
            <ArticleHeader :post="post" />

            <!-- Article Content -->
            <article class="bg-white rounded-xl shadow-sm p-6 mb-8">
                <!-- Cover image -->
                <div
                    v-if="post.cover_image"
                    class="w-full h-64 md:h-96 overflow-hidden rounded-lg mb-6"
                >
                    <img
                        class="w-full h-full object-cover object-center"
                        :src="`/storage/${post.cover_image}`"
                        alt="Post cover image"
                    />
                </div>

                <!-- Article content -->
                <div class="prose prose-lg max-w-none">
                    <div
                        class="content"
                        v-html="renderContent(post.content)"
                    ></div>
                </div>

                <!-- Display multiple images in a grid format -->
                <div
                    v-if="post.postImages && post.postImages.length > 0"
                    class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 my-6"
                >
                    <div
                        v-for="postImage in post.postImages"
                        :key="postImage.id"
                        class="overflow-hidden rounded-lg"
                    >
                        <img
                            class="w-full h-48 object-cover"
                            :src="`/storage/${postImage.url}`"
                            :alt="postImage.alt_text || 'Post image'"
                        />
                    </div>
                </div>
            </article>

            <!-- Social Share and Related Posts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8 mb-12">
                <!-- Main Content -->
                <div class="lg:col-span-3">
                    <!-- Social Share -->
                    <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">
                            Share this article
                        </h3>
                        <SocialShare
                            :title="post.title"
                            :url="show.url(post.slug)"
                        />
                    </div>

                    <!-- Related Posts -->
                    <div
                        v-if="
                            props.relatedPosts && props.relatedPosts.length > 0
                        "
                        class="bg-white rounded-xl shadow-sm p-6"
                    >
                        <h3 class="text-lg font-bold text-gray-900 mb-4">
                            Related Stories
                        </h3>
                        <div class="space-y-4">
                            <div
                                v-for="relatedPost in props.relatedPosts"
                                :key="relatedPost.id"
                                class="flex items-start gap-4"
                            >
                                <img
                                    v-if="relatedPost.cover_image"
                                    :src="`/storage/${relatedPost.cover_image}`"
                                    alt="Related post"
                                    class="w-24 h-16 object-cover rounded"
                                />
                                <div class="flex-1">
                                    <h4
                                        class="font-bold text-gray-900 line-clamp-2"
                                    >
                                        <Link
                                            :href="show(relatedPost.slug)"
                                            class="hover:text-blue-600"
                                        >
                                            {{ relatedPost.title }}
                                        </Link>
                                    </h4>
                                    <p class="text-sm text-gray-500 mt-1">
                                        {{
                                            new Date(
                                                relatedPost.created_at,
                                            ).toLocaleDateString("en-US", {
                                                month: "short",
                                                day: "numeric",
                                                year: "numeric",
                                            })
                                        }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1 space-y-8">
                    <!-- Newsletter Subscription -->
                    <NewsletterSubscription />

                    <!-- Trending Posts -->
                    <TrendingSidebar
                        v-if="
                            props.trendingPosts &&
                            props.trendingPosts.length > 0
                        "
                        :posts="props.trendingPosts"
                    />
                </div>
            </div>
        </div>
    </div>
</template>
