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

// Function to render JSON content as HTML
const renderContent = (content: string) => {
    try {
        // Check if content is a JSON string
        if (
            typeof content === "string" &&
            (content.startsWith("{") || content.startsWith("["))
        ) {
            const parsedContent = JSON.parse(content);
            return convertJsonToHtml(parsedContent);
        }
        // If it's already HTML, return as is
        return content || "";
    } catch (e) {
        console.error("Error parsing content:", e);
        return content || "";
    }
};

// Function to convert Tiptap JSON to HTML
const convertJsonToHtml = (json: any) => {
    if (!json || !json.content) {
        return "";
    }

    let html = "";

    const processContent = (content: any[]) => {
        if (!content || !Array.isArray(content)) return "";

        return content
            .map((node) => {
                switch (node.type) {
                    case "paragraph":
                        const paragraphContent = node.content
                            ? processContent(node.content)
                            : "";
                        return `<p class="mb-4">${paragraphContent}</p>`;

                    case "heading":
                        const level = node.attrs?.level || 1;
                        const headingContent = node.content
                            ? processContent(node.content)
                            : "";
                        return `<h${level} class="text-2xl font-bold mt-6 mb-4">${headingContent}</h${level}>`;

                    case "text":
                        let text = node.text || "";

                        // Apply marks (bold, italic, etc.)
                        if (node.marks && Array.isArray(node.marks)) {
                            node.marks.forEach((mark) => {
                                switch (mark.type) {
                                    case "bold":
                                        text = `<strong>${text}</strong>`;
                                        break;
                                    case "italic":
                                        text = `<em>${text}</em>`;
                                        break;
                                    case "underline":
                                        text = `<u>${text}</u>`;
                                        break;
                                    case "strike":
                                        text = `<s>${text}</s>`;
                                        break;
                                }
                            });
                        }

                        return text;

                    case "image":
                        const src = node.attrs?.src || "";
                        const alt = node.attrs?.alt || "";
                        const align = node.attrs?.align || "center";

                        let imgClass = "mx-auto block"; // default center
                        if (align === "left") imgClass = "float-left mr-4";
                        if (align === "right") imgClass = "float-right ml-4";

                        return `<div class="my-4"><img src="${src}" alt="${alt}" class="${imgClass}" style="max-width: 100%; height: auto;"/></div>`;

                    case "bulletList":
                        const listItems = node.content
                            ? processContent(node.content)
                            : "";
                        return `<ul class="list-disc pl-5 my-2">${listItems}</ul>`;

                    case "orderedList":
                        const orderedListItems = node.content
                            ? processContent(node.content)
                            : "";
                        return `<ol class="list-decimal pl-5 my-2">${orderedListItems}</ol>`;

                    case "listItem":
                        const listItemContent = node.content
                            ? processContent(node.content)
                            : "";
                        return `<li class="mb-1">${listItemContent}</li>`;

                    case "blockquote":
                        const blockquoteContent = node.content
                            ? processContent(node.content)
                            : "";
                        return `<blockquote class="border-l-4 border-blue-500 pl-4 italic my-4 py-2 bg-gray-50">${blockquoteContent}</blockquote>`;

                    case "codeBlock":
                        const codeContent = node.content
                            ? node.content[0]?.text || ""
                            : "";
                        return `<pre class="bg-gray-100 p-4 rounded my-2 overflow-x-auto"><code class="text-sm">${codeContent}</code></pre>`;

                    case "horizontalRule":
                        return '<hr class="my-6 border-t border-gray-200" />';

                    default:
                        // For any other nodes that have content
                        return node.content ? processContent(node.content) : "";
                }
            })
            .join("");
    };

    return processContent(json.content);
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
