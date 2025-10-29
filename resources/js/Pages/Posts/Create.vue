<script setup>
import { useForm, usePage } from "@inertiajs/vue3";
import Input from "@/components/ui/input/Input.vue";
import Label from "@/components/ui/label/Label.vue";
import Button from "@/components/ui/button/Button.vue";
import Textarea from "@/components/ui/textarea/Textarea.vue";
import Tiptap from "@/components/Tiptap.vue";
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

// Use useForm for manual form handling
const form = useForm({
    title: "",
    excerpt: "",
    content: "",
    category_id: "",
    cover_image: null,
});

// holding the urls for cover preview
const coverPreview = ref(null);

// clearing preview to avoid memory leakage
const clearPreview = (previewRef) => {
    if (previewRef.value && previewRef.value.startsWith("blob:")) {
        URL.revokeObjectURL(previewRef.value);
        previewRef.value = null;
    }
};

// handle the cover file
const handleCoverFile = (e) => {
    const file = e.target.files[0];
    console.log(coverPreview.value);
    if (file) {
        clearPreview({ value: coverPreview.value }); // Clear existing preview
        coverPreview.value = URL.createObjectURL(file);
        // Set the file in the form data
        form.cover_image = file;
    } else {
        clearPreview({ value: coverPreview.value });
        // Clear the file in the form data
        form.cover_image = null;
    }
    console.log(coverPreview.value);
};

// Handle form submission
const submitForm = () => {
    form.post(route("posts.store"));
};
</script>

<template>
    <Head title="Create Post" />
    <div class="min-h-[100vh] bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <Card class="lg:max-w-full mx-auto">
            <CardHeader data-aos="fade-right">
                <CardTitle>Create New Post</CardTitle>
                <CardDescription
                    >Share your thoughts with the world</CardDescription
                >
            </CardHeader>
            <CardContent>
                <!-- Post Create Form -->
                <form @submit.prevent="submitForm" class="space-y-6">
                    <div class="lg:flex space-x-2 space-y-4">
                        <!-- to separate the form -->
                        <div
                            class="lg:w-1/3 space-x-4 space-y-3"
                            data-aos="fade-up"
                        >
                            <!-- Category Select -->
                            <Select v-model="form.category_id">
                                <SelectTrigger>
                                    <SelectValue
                                        placeholder="Select a Category"
                                    />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectGroup>
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

                            <div
                                v-if="form.errors.category_id"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ form.errors.category_id }}
                            </div>

                            <!-- Title Input-->

                            <Label for="title">Title</Label>
                            <Input
                                v-model="form.title"
                                id="title"
                                placeholder="Enter post title"
                                class="w-full"
                            />
                            <Error
                                class="text-center py-2 text-xs font-mono"
                                errorName="title"
                            />

                            <!-- Excerpt Input-->

                            <Label for="excerpt">Short Description</Label>
                            <Input
                                v-model="form.excerpt"
                                id="excerpt"
                                placeholder="Enter post excerpt"
                                class="w-full"
                            />
                            <Error
                                class="text-center py-2 text-xs font-mono"
                                errorName="excerpt"
                            />

                            <!-- Cover Input-->

                            <Label
                                class="form-label"
                                for="cover_image"
                                data-aos="fade-up"
                            >
                                <div>
                                    Cover / Thumbnail
                                    <Input
                                        class="hidden"
                                        id="cover_image"
                                        @change="handleCoverFile"
                                        type="file"
                                        :disabled="form.processing"
                                    />
                                    <img
                                        class="border-4 border-dashed w-full h-24 rounded-lg text-center text-xs object-cover"
                                        :src="coverPreview"
                                        alt="Add a cover?"
                                    />
                                </div>
                                <Error
                                    class="text-center py-2 text-xs font-mono"
                                    errorName="cover_image"
                                />
                            </Label>
                        </div>
                        <!-- Content Input with Tiptap Editor -->
                        <div class="flex-2 px-2 py-4" data-aos="fade-up">
                            <Label
                                for="content"
                                class="block text-sm font-semibold text-gray-700 mb-1"
                                data-aos="fade-up"
                                >Content</Label
                            >
                            <Tiptap
                                v-model="form.content"
                                id="content"
                                class="h-fit border-4 border"
                                data-aos="fade-up"
                                :disabled="form.processing"
                            />
                            <Error
                                class="text-center py-2 text-xs font-mono"
                                errorName="content"
                            />
                        </div>
                    </div>
                    <Button
                        type="submit"
                        class="w-full mt-4"
                        :disabled="form.processing"
                        data-aos="zoom-out-up"
                    >
                        {{ form.processing ? "Creating..." : "Create Post" }}
                    </Button>
                </form>
            </CardContent>
        </Card>
    </div>
</template>
