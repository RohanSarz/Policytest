<script setup>
import { Form, usePage } from "@inertiajs/vue3";
import Input from "@/components/ui/input/Input.vue";
import Label from "@/components/ui/label/Label.vue";
import Button from "@/components/ui/button/Button.vue";
import Textarea from "@/components/ui/textarea/Textarea.vue";
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
import { Avatar, AvatarImage, AvatarFallback } from '@/components/ui/avatar';

const page = usePage();
const post = page.props.post;
const categories = page.props.categories;

// holding the urls for image and cover
const previewImage = ref(null);
const previewCover = ref(null);

// clearing preview to avoid memory leakage
const clearUrl = (type) => {
    if (type === 'image' && previewImage.value) {
        URL.revokeObjectURL(previewImage.value);
        previewImage.value = null;
    } else if (type === 'cover' && previewCover.value) {
        URL.revokeObjectURL(previewCover.value);
        previewCover.value = null;
    }
};

// handle the file and create the url for image
const handleImageFile = (e) => {
    const file = e.target.files[0];
    if (file) {
        clearUrl('image');
        previewImage.value = URL.createObjectURL(file);
    } else {
        clearUrl('image');
        previewImage.value = post.value?.image ? `/storage/${post.value.image}` : '/storage/avatars/default.jpg';
    }
};

// handle the file and create the url for cover
const handleCoverFile = (e) => {
    const file = e.target.files[0];
    if (file) {
        clearUrl('cover');
        previewCover.value = URL.createObjectURL(file);
    } else {
        clearUrl('cover');
        previewCover.value = post.value?.cover ? `/storage/${post.value.cover}` : '/storage/avatars/default.jpg';
    }
};

// Initialize previews with existing images
if (post.value?.image) {
    previewImage.value = `/storage/${post.value.image}`;
}
if (post.value?.cover) {
    previewCover.value = `/storage/${post.value.cover}`;
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
                        {{ processing ? 'Updating...' : 'Update Post' }}
                    </Button>
                </div>
            </div>
        </header>
        
        <div class="flex-1 overflow-y-auto">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <Form id="post-form" :action="route('posts.update', post.id)" method="put" #default="{ processing, errors }">
                    <div class="space-y-6">
                        <div>
                            <Label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Category</Label>
                            <Select 
                                name="category_id"
                            >
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
                                                :class="{'bg-blue-500 text-white': category.id == post.category_id}"
                                            >
                                                {{ category.name }}
                                            </SelectItem>
                                        </div>
                                    </SelectGroup>
                                </SelectContent>
                            </Select>
                            <div v-if="errors.category_id" class="mt-1 text-sm text-red-600">
                                {{ errors.category_id }}
                            </div>
                        </div>

                        <div>
                            <Label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title</Label>
                            <Input 
                                name="title" 
                                placeholder="Enter post title" 
                                :defaultValue="post.title"
                                class="w-full"
                            />
                            <div v-if="errors.title" class="mt-1 text-sm text-red-600">
                                {{ errors.title }}
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
                                            v-if="previewImage || (post.image && !previewCover)"
                                            :src="previewImage || `/storage/${post.image}`"
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
                                for="cover"
                                data-aos="zoom-in-left"
                                data-aos-duration="500"
                            >
                                <div class="grid place-items-center gap-2">
                                    Cover Image
                                    <Input
                                        class="hidden"
                                        id="cover"
                                        @change="handleCoverFile"
                                        type="file"
                                        name="cover"
                                        :disabled="processing"
                                    />
                                    <Avatar
                                        class="size-16 border-2 border-black"
                                    >
                                        <AvatarImage
                                            class="object-cover w-full h-full"
                                            v-if="previewCover || post.cover"
                                            :src="previewCover || `/storage/${post.cover}`"
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
                                    errorName="cover"
                                />
                            </Label>
                        </div>

                        <div>
                            <Label for="excerpt" class="block text-sm font-medium text-gray-700 mb-1">Excerpt</Label>
                            <Textarea 
                                name="excerpt" 
                                placeholder="Enter post excerpt..."
                                rows="3"
                                :defaultValue="post.excerpt"
                                class="w-full"
                            />
                            <div v-if="errors.excerpt" class="mt-1 text-sm text-red-600">
                                {{ errors.excerpt }}
                            </div>
                        </div>

                        <div>
                            <Label for="content" class="block text-sm font-medium text-gray-700 mb-1">Content</Label>
                            <Textarea 
                                name="content" 
                                placeholder="Write your post content here..."
                                rows="6"
                                :defaultValue="post.content"
                                class="w-full"
                            />
                            <div v-if="errors.content" class="mt-1 text-sm text-red-600">
                                {{ errors.content }}
                            </div>
                        </div>

                        <div>
                            <Label
                                class="form-label"
                                for="cover"
                                data-aos="zoom-in-left"
                                data-aos-duration="500"
                            >
                                <div class="grid place-items-center gap-2">
                                    Cover Image
                                    <Input
                                        class="hidden"
                                        id="cover"
                                        @change="handleFile"
                                        type="file"
                                        name="cover"
                                        :disabled="processing"
                                    />
                                    <Avatar
                                        class="size-16 border-2 border-black"
                                    >
                                        <AvatarImage
                                            class="object-cover w-full h-full"
                                            v-if="previewImage || post.cover"
                                            :src="previewImage || post.cover"
                                            alt="Cover preview"
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
                                    errorName="cover"
                                />
                            </Label>
                        </div>

                    </div>
                </Form>
            </div>
        </div>
    </div>
</template>
