<script setup>
import { Form, usePage } from "@inertiajs/vue3";
import { update } from "@/actions/App/Http/Controllers/PostController";
import Input from "@/components/ui/input/Input.vue";
import Label from "@/components/ui/label/Label.vue";
import Button from "@/components/ui/button/Button.vue";
import Textarea from "@/components/ui/textarea/Textarea.vue";
import Tiptap from "@/components/Tiptap.vue";
import Select from "@/components/ui/select/Select.vue";
import {
    Card,
    CardContent,
    CardDescription,
    CardFooter,
    CardHeader,
    CardTitle,
} from "@/components/ui/card";
import { ref } from "vue";
import Error from "@/components/Error.vue";
import { Avatar, AvatarImage, AvatarFallback } from "@/components/ui/avatar";

import { useForm } from "@inertiajs/vue3";

const page = usePage();
const post = page.props.post;
const categories = page.props.categories;

// Use useForm for manual form handling (for content field with Tiptap)
const form = useForm({
    title: post.title,
    excerpt: post.excerpt,
    content: post.content, // Pass the content as-is (string or object) to the new Tiptap
    category_id: post.category_id,
    cover_image: null,
});

// holding the urls for image and cover
const previewImage = ref(null);
const previewCover = ref(null);

// clearing preview to avoid memory leakage
const clearUrl = (type) => {
    if (type === "image" && previewImage.value) {
        URL.revokeObjectURL(previewImage.value);
        previewImage.value = null;
    } else if (type === "cover" && previewCover.value) {
        URL.revokeObjectURL(previewCover.value);
        previewCover.value = null;
    }
};

// handle the file and create the url for image
const handleImageFile = (e) => {
    const file = e.target.files[0];
    if (file) {
        clearUrl("image");
        previewImage.value = URL.createObjectURL(file);
    } else {
        clearUrl("image");
        previewImage.value = post?.image
            ? `/storage/${post.image}`
            : "/storage/avatars/default.jpg";
    }
};

// handle the file and create the url for cover
const handleCoverFile = (e) => {
    const file = e.target.files[0];
    if (file) {
        clearUrl("cover");
        previewCover.value = URL.createObjectURL(file);
    } else {
        clearUrl("cover");
        previewCover.value = post?.cover_image
            ? `/storage/${post.cover_image}`
            : "/storage/avatars/default.jpg";
    }
};

// Initialize previews with existing images
if (post?.image) {
    previewImage.value = `/storage/${post.image}`;
}
if (post?.cover_image) {
    previewCover.value = `/storage/${post.cover_image}`;
}
</script>

<template>
    <Head :title="`Edit Article: ${post.title}`" />
    <div class="flex flex-col h-screen bg-gray-50">
        <header class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex justify-between items-center">
                    <h1 class="text-2xl font-bold text-gray-900">Edit Article</h1>
                    <Button
                        type="submit"
                        form="post-form"
                        :disabled="form.processing"
                        class="bg-blue-600 hover:bg-blue-700"
                    >
                        {{ form.processing ? "Updating..." : "Update Article" }}
                    </Button>
                </div>
            </div>
        </header>

        <div class="flex-1 overflow-y-auto py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <form
                    @submit.prevent="() => {
                        const formData = {
                            ...form.data(),
                            content: JSON.stringify(form.content)
                        };
                        form.transform(() => formData).put(update(post.id).url);
                    }"
                    class="space-y-6"
                >
                    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                        <div class="lg:col-span-1 space-y-6">
                            <!-- Category Select -->
                            <div>
                                <Label
                                    for="category_id"
                                    class="block text-sm font-medium text-gray-700 mb-2"
                                >Category</Label>
                                <Select v-model="form.category_id">
                                    <SelectTrigger>
                                        <SelectValue
                                            placeholder="Select a Category"
                                            class="w-full"
                                        />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectGroup>
                                            <SelectLabel>Category</SelectLabel>

                                            <div
                                                v-for="category in categories"
                                                :key="category.id"
                                            >
                                                <SelectItem
                                                    :value="category.id.toString()"
                                                    :class="{
                                                        'bg-blue-500 text-white':
                                                            category.id ==
                                                            form.category_id,
                                                    }"
                                                >
                                                    {{ category.name }}
                                                </SelectItem>
                                            </div>
                                        </SelectGroup>
                                    </SelectContent>
                                </Select>
                                <div
                                    v-if="form.errors.category_id"
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{ form.errors.category_id }}
                                </div>
                            </div>

                            <!-- Title Input -->
                            <div>
                                <Label
                                    for="title"
                                    class="block text-sm font-medium text-gray-700 mb-2"
                                >Title</Label>
                                <Input
                                    v-model="form.title"
                                    id="title"
                                    placeholder="Enter article title"
                                    class="w-full"
                                />
                                <div
                                    v-if="form.errors.title"
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{ form.errors.title }}
                                </div>
                            </div>

                            <!-- Cover Field -->
                            <div>
                                <Label
                                    class="block text-sm font-medium text-gray-700 mb-2"
                                    for="cover_image"
                                >
                                    Cover Image
                                </Label>
                                <Input
                                    class="hidden"
                                    id="cover_image"
                                    @change="handleCoverFile"
                                    type="file"
                                    name="cover_image"
                                    :disabled="form.processing"
                                />
                                <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center">
                                    <img
                                        v-if="previewCover || post.cover_image"
                                        class="w-full h-32 object-cover rounded-md mx-auto"
                                        :src="previewCover || `/storage/${post.cover_image}`"
                                        alt="Cover preview"
                                    />
                                    <div v-else class="text-gray-500 py-6">
                                        No cover image selected
                                    </div>
                                </div>
                                <Error
                                    class="text-center py-2 text-xs font-mono"
                                    errorName="cover_image"
                                />
                            </div>

                            <!-- Excerpt Field -->
                            <div>
                                <Label
                                    for="excerpt"
                                    class="block text-sm font-medium text-gray-700 mb-2"
                                >Summary</Label>
                                <textarea
                                    v-model="form.excerpt"
                                    id="excerpt"
                                    placeholder="Enter article summary..."
                                    rows="4"
                                    class="w-full border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500"
                                ></textarea>
                                <div
                                    v-if="form.errors.excerpt"
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{ form.errors.excerpt }}
                                </div>
                            </div>
                        </div>

                        <!-- Content Field with Tiptap Editor -->
                        <div class="lg:col-span-3">
                            <div class="h-[600px]">
                                <Label
                                    for="content"
                                    class="block text-sm font-medium text-gray-700 mb-2"
                                >Article Content</Label>
                                <Tiptap
                                    v-model="form.content"
                                    id="content"
                                    class="w-full h-[500px]"
                                />
                                <div
                                    v-if="form.errors.content"
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{ form.errors.content }}
                                </div>
                            </div>
                            
                            <Button
                                type="submit"
                                class="w-full mt-6 bg-blue-600 hover:bg-blue-700"
                                :disabled="form.processing"
                                data-aos="zoom-out-up"
                            >
                                {{
                                    form.processing ? "Updating..." : "Update Article"
                                }}
                            </Button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
