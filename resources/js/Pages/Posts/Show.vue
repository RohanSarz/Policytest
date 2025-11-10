<script setup>
import { show as userShow } from "@/routes/users";
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";
import Badge from "@/components/ui/badge/Badge.vue";
import { Card } from "@/components/ui/card";
import UserNameUpper from "@/components/userDataComponents/UserNameUpper.vue";
import { usePage } from "@inertiajs/vue3";
import { computed } from "vue";

const { post } = usePage().props;
const user = computed(() => post.user || {});
const category = computed(() => post.category || {});

// Function to render JSON content as HTML
const renderContent = (content) => {
  try {
    // Check if content is a JSON string
    if (typeof content === 'string' && (content.startsWith('{') || content.startsWith('['))) {
      const parsedContent = JSON.parse(content);
      return convertJsonToHtml(parsedContent);
    }
    // If it's already HTML, return as is
    return content || '';
  } catch (e) {
    console.error('Error parsing content:', e);
    return content || '';
  }
};

// Function to convert Tiptap JSON to HTML
const convertJsonToHtml = (json) => {
  if (!json || !json.content) {
    return '';
  }
  
  let html = '';
  
  const processContent = (content) => {
    if (!content || !Array.isArray(content)) return '';
    
    return content.map(node => {
      switch (node.type) {
        case 'paragraph':
          const paragraphContent = node.content ? processContent(node.content) : '';
          return `<p>${paragraphContent}</p>`;
        
        case 'heading':
          const level = node.attrs?.level || 1;
          const headingContent = node.content ? processContent(node.content) : '';
          return `<h${level}>${headingContent}</h${level}>`;
        
        case 'text':
          let text = node.text || '';
          
          // Apply marks (bold, italic, etc.)
          if (node.marks && Array.isArray(node.marks)) {
            node.marks.forEach(mark => {
              switch (mark.type) {
                case 'bold':
                  text = `<strong>${text}</strong>`;
                  break;
                case 'italic':
                  text = `<em>${text}</em>`;
                  break;
                case 'underline':
                  text = `<u>${text}</u>`;
                  break;
                case 'strike':
                  text = `<s>${text}</s>`;
                  break;
              }
            });
          }
          
          return text;
          
        case 'image':
          const src = node.attrs?.src || '';
          const alt = node.attrs?.alt || '';
          const align = node.attrs?.align || 'center';
          
          let imgClass = 'mx-auto'; // default center
          if (align === 'left') imgClass = 'float-left mr-4';
          if (align === 'right') imgClass = 'float-right ml-4';
          
          return `<img src="${src}" alt="${alt}" class="${imgClass}" style="max-width: 100%; height: auto;"/>`;
        
        case 'bulletList':
          const listItems = node.content ? processContent(node.content) : '';
          return `<ul class="list-disc pl-5">${listItems}</ul>`;
        
        case 'orderedList':
          const orderedListItems = node.content ? processContent(node.content) : '';
          return `<ol class="list-decimal pl-5">${orderedListItems}</ol>`;
        
        case 'listItem':
          const listItemContent = node.content ? processContent(node.content) : '';
          return `<li>${listItemContent}</li>`;
          
        case 'blockquote':
          const blockquoteContent = node.content ? processContent(node.content) : '';
          return `<blockquote class="border-l-4 border-gray-300 pl-4 italic">${blockquoteContent}</blockquote>`;
        
        case 'codeBlock':
          const codeContent = node.content ? node.content[0]?.text || '' : '';
          return `<pre class="bg-gray-100 p-2 rounded"><code>${codeContent}</code></pre>`;
        
        case 'horizontalRule':
          return '<hr class="my-4" />';
          
        default:
          // For any other nodes that have content
          return node.content ? processContent(node.content) : '';
      }
    }).join('');
  };
  
  return processContent(json.content);
};
</script>

<template>
    <div class="min-h-screen bg-gray-50">
        <!-- Header with cover image -->
        <header class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Cover image -->
                <div v-if="post.cover_image" class="w-full h-64 md:h-96 overflow-hidden rounded-t-lg">
                    <img
                        class="w-full h-full object-cover object-center"
                        :src="`/storage/${post.cover_image}`"
                        alt="Post cover image"
                    />
                </div>
                
                <!-- Post info below cover image -->
                <div class="py-6">
                    <div
                        class="flex flex-col md:flex-row md:items-center gap-2 md:justify-between"
                    >
                        <div class="flex items-center space-x-4">
                            <Avatar class="ring-1" v-if="user">
                                <AvatarImage
                                    v-if="user.avatar"
                                    :src="`/storage/${user.avatar}`"
                                    alt="User Avatar"
                                />
                                <AvatarFallback>{{ user.name[0] }}</AvatarFallback>
                            </Avatar>
                            <div>
                                <Link :href="userShow(user.id)">
                                    <p
                                        class="text-sm font-semibold hover:underline text-gray-900"
                                    >
                                        <UserNameUpper :name="user.name" /></p
                                ></Link>
                                <p class="text-xs text-gray-600">
                                    Published on {{ post.created_at_human}}
                                </p>
                            </div>
                        </div>
                        <h1 class="text-3xl font-bold text-gray-900 pt-4 md:pt-0">
                            {{ post.title }}
                        </h1>

                        <div></div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Post Content -->
        <main class="py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <Card class="p-6">
                    <div class="flex justify-between items-start">
                        <Badge
                            v-if="category"
                            variant="outline"
                            class="bg-blue-100 text-blue-800"
                        >
                            {{ category.name || "Uncategorized" }}
                        </Badge>
                    </div>

                    <div class="mt-6">
                        <!-- Display post content -->
                        <div class="prose prose-lg max-w-none mb-6">
                            <div class="content" v-html="renderContent(post.content)"></div>
                        </div>
                        
                        <!-- Display multiple images in a grid format -->
                        <div 
                            v-if="post.postImages && post.postImages.length > 0"
                            class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4"
                        >
                            <Card
                                v-for="postImage in post.postImages"
                                :key="postImage.id"
                                class="overflow-hidden"
                            >
                                <img
                                    class="w-full h-48 object-cover"
                                    :src="`/storage/${postImage.url}`"
                                    :alt="postImage.alt_text || 'Post image'"
                                />
                            </Card>
                        </div>
                    </div>
                </Card>
            </div>
        </main>
    </div>
</template>
