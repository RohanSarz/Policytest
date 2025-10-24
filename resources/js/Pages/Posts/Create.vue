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
console.log(categories);

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
                <!-- Post Create Form -->
                <Form
                    :action="route('posts.store')"
                    method="post"
                    #default="{ processing, errors }"
                >
                    <!-- Category Select -->
                    <Select name="category_id">
                        <SelectTrigger>
                            <SelectValue
                                placeholder="Select a Category"
                                class="w-full bg-gray"
                            />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectGroup>
                                <SelectLabel>Category</SelectLabel>

                                <div
                                    v-for="{ name, id } in categories"
                                    :key="id"
                                >
                                    <SelectItem :value="id">
                                        {{ name }}
                                    </SelectItem>
                                </div>
                            </SelectGroup>
                        </SelectContent>
                    </Select>
                    <div class="space-y-4">
                        <div
                            v-if="errors.category_id"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ errors.category_id }}
                        </div>

                        <!-- Title Input-->
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

                        <!-- Image Input-->
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
                                        name="image"
                                        @change="handleFile"
                                        type="file"
                                        :disabled="processing"
                                    />
                                    <img
                                        class="border w-full h-24 rounded-lg text-center object-cover"
                                        :src="
                                            previewImage || $page.props.defUrl
                                        "
                                        alt="PI"
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
                                for="body"
                                class="block text-sm font-medium text-gray-700 mb-1"
                                >Content</Label
                            >
                            <Textarea
                                name="body"
                                placeholder="Write your post content here..."
                                class="w-full"
                            />
                            <div
                                v-if="errors.body"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ errors.body }}
                            </div>
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
