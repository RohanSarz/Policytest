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
    content: post.content, // This should be JSON string or object
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
    <Head :title="`Edit Post: ${post.title}`" />
    <div class="flex flex-col h-screen bg-gray-50">
        <header class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex justify-between items-center">
                    <h1 class="text-2xl font-bold text-gray-900">Edit Post</h1>
                    <Button
                        type="submit"
                        form="post-form"
                        :disabled="processing"
                        variant="default"
                    >
                        {{ processing ? "Updating..." : "Update Post" }}
                    </Button>
                </div>
            </div>
        </header>

        <div class="flex-1 overflow-y-auto">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <form
                    @submit.prevent="() => form.put(update(post.id).url)"
                    class="space-y-6"
                >
                    <div class="space-y-6">
                        <div>
                            <Label
                                for="category_id"
                                class="block text-sm font-medium text-gray-700 mb-1"
                                >Category</Label
                            >
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

                        <div>
                            <Label
                                for="title"
                                class="block text-sm font-medium text-gray-700 mb-1"
                                >Title</Label
                            >
                            <Input
                                v-model="form.title"
                                id="title"
                                placeholder="Enter post title"
                                class="w-full"
                            />
                            <div
                                v-if="form.errors.title"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ form.errors.title }}
                            </div>
                        </div>

                        <!-- Image Field -->
                        <div>
                            <Label
                                class="form-label"
                                for="image"
                                data-aos="zoom-in-left"
                                data-aos-duration="500"
                            >
                                <div class="grid place-items-center gap-2">
                                    Post Image
                                    <Input
                                        class="hidden"
                                        id="image"
                                        @change="handleImageFile"
                                        type="file"
                                        name="image"
                                        :disabled="processing"
                                    />
                                    <Avatar
                                        class="size-16 border-2 border-black"
                                    >
                                        <AvatarImage
                                            class="object-cover w-full h-full"
                                            v-if="
                                                previewImage ||
                                                (post.image && !previewCover)
                                            "
                                            :src="
                                                previewImage ||
                                                `/storage/${post.image}`
                                            "
                                            alt="Post Image preview"
                                        />
                                        <AvatarFallback
                                            v-else-if="$page.props.auth.user"
                                        >
                                            {{ $page.props.auth.user.name[0] }}
                                        </AvatarFallback>
                                        <AvatarFallback v-else>
                                            ?
                                        </AvatarFallback>
                                    </Avatar>
                                </div>
                                <Error
                                    class="text-center py-2 text-xs font-mono"
                                    errorName="image"
                                />
                            </Label>
                        </div>

                        <!-- Cover Field -->
                        <div>
                            <Label
                                class="form-label"
                                for="cover_image"
                                data-aos="zoom-in-left"
                                data-aos-duration="500"
                            >
                                <div class="grid place-items-center gap-2">
                                    Cover Image
                                    <Input
                                        class="hidden"
                                        id="cover_image"
                                        @change="handleCoverFile"
                                        type="file"
                                        name="cover_image"
                                        :disabled="processing"
                                    />
                                    <Avatar
                                        class="size-16 border-2 border-black"
                                    >
                                        <AvatarImage
                                            class="object-cover w-full h-full"
                                            v-if="
                                                previewCover || post.cover_image
                                            "
                                            :src="
                                                previewCover ||
                                                `/storage/${post.cover_image}`
                                            "
                                            alt="Cover Image preview"
                                        />
                                        <AvatarFallback
                                            v-else-if="$page.props.auth.user"
                                        >
                                            {{ $page.props.auth.user.name[0] }}
                                        </AvatarFallback>
                                        <AvatarFallback v-else>
                                            ?
                                        </AvatarFallback>
                                    </Avatar>
                                </div>
                                <Error
                                    class="text-center py-2 text-xs font-mono"
                                    errorName="cover_image"
                                />
                            </Label>
                        </div>

                        <!-- Excerpt Field -->
                        <div>
                            <Label
                                for="excerpt"
                                class="block text-sm font-medium text-gray-700 mb-1"
                                >Excerpt</Label
                            >
                            <Input
                                v-model="form.excerpt"
                                id="excerpt"
                                placeholder="Enter post excerpt..."
                                class="w-full"
                            />
                            <div
                                v-if="form.errors.excerpt"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ form.errors.excerpt }}
                            </div>
                        </div>

                        <!-- Content Field with Tiptap Editor -->
                        <div class="h-[500px]">
                            <Label
                                for="content"
                                class="block text-sm font-medium text-gray-700 mb-1"
                                >Content</Label
                            >
                            <Tiptap
                                v-model="form.content"
                                id="content"
                                class="w-full h-full"
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
                            class="w-full mt-4"
                            :disabled="form.processing"
                            data-aos="zoom-out-up"
                        >
                            {{
                                form.processing ? "Updating..." : "Update Post"
                            }}
                        </Button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
