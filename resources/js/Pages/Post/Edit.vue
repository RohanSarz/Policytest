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

// holding the url
const previewImage = ref(null);

// clearing preview to avoid memory leakage
const clearUrl = () => {
    if (previewImage.value) {
        URL.revokeObjectURL(previewImage.value);
        previewImage.value = null;
    }
};

// handle the file and create the url
const handleFile = (e) => {
    const file = e.target.files[0];
    console.log(previewImage.value);
    if (file) {
        clearUrl();
        previewImage.value = URL.createObjectURL(file);
    } else {
        clearUrl();
        previewImage.value = $page.props.defUrl;
    }
    console.log(previewImage.value);
};
</script>

<template>
    <Head :title="`Edit Post: ${post.title}`" />
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <Card class="w-full max-w-md">
            <CardHeader class="text-center">
                <CardTitle class="text-2xl font-bold">Edit Post</CardTitle>
                <CardDescription>Update your post content</CardDescription>
            </CardHeader>
            <CardContent>
                <Form :action="route('posts.update', post.id)" method="put" #default="{ processing, errors }">
                    <div class="space-y-4">
                        <div>
                            <Label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Category</Label>
                            <Select 
                                name="category_id" 
                                :options="categories" 
                                :defaultValue="post.category_id"
                                class="w-full"
                            />
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

                        <div>
                            <Label
                                class="form-label"
                                for="image"
                                data-aos="zoom-in-left"
                                data-aos-duration="500"
                            >
                                <div class="grid place-items-center gap-2">
                                    Image
                                    <Input
                                        class="hidden"
                                        id="image"
                                        @change="handleFile"
                                        type="file"
                                        name="image"
                                        :disabled="processing"
                                    />
                                    <Avatar
                                        class="size-16 border-2 border-black"
                                    >
                                        <AvatarImage
                                            class="object-cover w-full h-full"
                                            v-if="previewImage || post.image"
                                            :src="previewImage || post.image"
                                            alt="Image preview"
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

                        <div>
                            <Label for="body" class="block text-sm font-medium text-gray-700 mb-1">Content</Label>
                            <Textarea 
                                name="body" 
                                placeholder="Write your post content here..."
                                rows="6"
                                :defaultValue="post.body"
                                class="w-full"
                            />
                            <div v-if="errors.body" class="mt-1 text-sm text-red-600">
                                {{ errors.body }}
                            </div>
                        </div>

                        <Button 
                            type="submit" 
                            class="w-full mt-4"
                            :disabled="processing"
                        >
                            {{ processing ? 'Updating...' : 'Update Post' }}
                        </Button>
                    </div>
                </Form>
            </CardContent>
        </Card>
    </div>
</template>
