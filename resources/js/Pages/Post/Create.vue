<script setup>
import { Form, usePage } from "@inertiajs/vue3";
import Input from "@/components/ui/input/Input.vue";
import Label from "@/components/ui/label/Label.vue";
import Button from "@/components/ui/button/Button.vue";
import Textarea from "@/components/ui/textarea/Textarea.vue";
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectLabel,
    SelectTrigger,
    SelectValue,
} from "@/components/ui/select";
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

const page = usePage();
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
        previewImage.value = '/storage/avatars/default.jpg';
    }
    console.log(previewImage.value);
};

// Initialize with default image
previewImage.value = '/storage/avatars/default.jpg';
</script>

<template>
    <Head title="Create Post" />
    <div
        class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8"
    >
        <Card class="w-full max-w-md">
            <CardHeader class="text-center">
                <CardTitle class="text-2xl font-bold"
                    >Create New Post</CardTitle
                >
                <CardDescription
                    >Share your thoughts with the world</CardDescription
                >
            </CardHeader>
            <CardContent>
                <Form
                    :action="route('posts.store')"
                    method="post"
                    #default="{ processing, errors }"
                >
                    <div class="space-y-4">
                        <div>
                            <Select name="category_id">
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
                                            <SelectItem :value="category.id.toString()">
                                                {{ category.name }}
                                            </SelectItem>
                                        </div>
                                    </SelectGroup>
                                </SelectContent>
                            </Select>
                            <div
                                v-if="errors.category_id"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ errors.category_id }}
                            </div>
                        </div>

                        <div>
                            <Label
                                for="title"
                                class="block text-sm font-medium text-gray-700 mb-1"
                                >Title</Label
                            >
                            <Input
                                name="title"
                                placeholder="Enter post title"
                                class="w-full"
                            />
                            <div
                                v-if="errors.title"
                                class="mt-1 text-sm text-red-600"
                            >
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
                                    Post Image
                                    <Input
                                        class="hidden"
                                        id="image"
                                        @change="handleFile"
                                        type="file"
                                        name="image"
                                        :disabled="processing"
                                    />
                                    <img
                                        class="border w-full h-24 rounded-lg text-center object-cover"
                                        :src="
                                            previewImage || '/storage/avatars/default.jpg'
                                        "
                                        alt="Post Image"
                                    />
                                </div>
                                <Error
                                    class="text-center py-2 text-xs font-mono"
                                    errorName="image"
                                />
                            </Label>
                        </div>

                        <div>
                            <Label
                                for="excerpt"
                                class="block text-sm font-medium text-gray-700 mb-1"
                                >Excerpt</Label
                            >
                            <Textarea
                                name="excerpt"
                                placeholder="Enter post excerpt..."
                                rows="3"
                                class="w-full"
                            />
                            <div
                                v-if="errors.excerpt"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ errors.excerpt }}
                            </div>
                        </div>

                        <div>
                            <Label
                                for="content"
                                class="block text-sm font-medium text-gray-700 mb-1"
                                >Content</Label
                            >
                            <Textarea
                                name="content"
                                placeholder="Write your post content here..."
                                rows="6"
                                class="w-full"
                            />
                            <div
                                v-if="errors.content"
                                class="mt-1 text-sm text-red-600"
                            >
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
                                    <img
                                        class="border w-full h-24 rounded-lg text-center object-cover"
                                        :src="
                                            previewImage || '/storage/avatars/default.jpg'
                                        "
                                        alt="Cover Preview"
                                    />
                                </div>
                                <Error
                                    class="text-center py-2 text-xs font-mono"
                                    errorName="cover"
                                />
                            </Label>
                        </div>

                        <Button
                            type="submit"
                            class="w-full mt-4"
                            :disabled="processing"
                        >
                            {{ processing ? "Creating..." : "Create Post" }}
                        </Button>
                    </div>
                </Form>
            </CardContent>
        </Card>
    </div>
</template>
