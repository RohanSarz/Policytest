<script setup>
import { useForm, usePage } from "@inertiajs/vue3";
import { store } from "@/actions/App/Http/Controllers/PostController";
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
    content: "", // Initialize as empty string for the new Tiptap
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
    // Convert JSON content to string before submitting
    const formData = {
        ...form.data(),
        content: JSON.stringify(form.content)
    };
    
    form.transform(() => formData).post(store().url);
};
</script>

<template>
    <Head title="Create Article" />
    <div class="min-h-[100vh] bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <Card class="lg:max-w-full mx-auto">
            <CardHeader data-aos="fade-right">
                <CardTitle>Create New Article</CardTitle>
                <CardDescription
                    >Share your news and stories with the world</CardDescription
                >
            </CardHeader>
            <CardContent>
                <!-- Article Create Form -->
                <form @submit.prevent="submitForm" class="space-y-6">
                    <div class="lg:flex space-x-2 space-y-4">
                        <!-- to separate the form -->
                        <div
                            class="lg:w-1/3 space-x-4 space-y-3"
                            data-aos="fade-up"
                        >
                            <!-- Category Select -->
                            <div class="mb-4">
                                <Label for="category_id" class="mb-2">Category</Label>
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
                            </div>

                            <div
                                v-if="form.errors.category_id"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ form.errors.category_id }}
                            </div>

                            <!-- Title Input-->
                            <div class="mb-4">
                                <Label for="title" class="mb-2">Title</Label>
                                <Input
                                    v-model="form.title"
                                    id="title"
                                    placeholder="Enter article title"
                                    class="w-full"
                                />
                                <Error
                                    class="text-center py-2 text-xs font-mono"
                                    errorName="title"
                                />
                            </div>

                            <!-- Excerpt Input-->
                            <div class="mb-4">
                                <Label for="excerpt" class="mb-2">Summary</Label>
                                <textarea
                                    v-model="form.excerpt"
                                    id="excerpt"
                                    placeholder="Enter article summary..."
                                    rows="3"
                                    class="w-full border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500"
                                ></textarea>
                                <Error
                                    class="text-center py-2 text-xs font-mono"
                                    errorName="excerpt"
                                />
                            </div>

                            <!-- Cover Input-->
                            <div class="mb-4">
                                <Label
                                    class="form-label mb-2"
                                    for="cover_image"
                                >
                                    <div class="mb-2">Cover Image</div>
                                    <Input
                                        class="hidden"
                                        id="cover_image"
                                        @change="handleCoverFile"
                                        type="file"
                                        :disabled="form.processing"
                                    />
                                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center">
                                        <img
                                            v-if="coverPreview"
                                            class="w-full h-32 object-cover rounded-md mx-auto"
                                            :src="coverPreview"
                                            alt="Cover preview"
                                        />
                                        <div v-else class="text-gray-500 py-8">
                                            No cover image selected
                                        </div>
                                    </div>
                                </Label>
                                <Error
                                    class="text-center py-2 text-xs font-mono"
                                    errorName="cover_image"
                                />
                            </div>
                        </div>
                        <!-- Content Input with Tiptap Editor -->
                        <div class="flex-1 px-2 py-4" data-aos="fade-up">
                            <Label
                                for="content"
                                class="block text-sm font-semibold text-gray-700 mb-1"
                                data-aos="fade-up"
                                >Article Content</Label
                            >
                            <Tiptap
                                v-model="form.content"
                                id="content"
                                class="w-full h-[500px]"
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
                        class="w-full mt-4 bg-blue-600 hover:bg-blue-700"
                        :disabled="form.processing"
                        data-aos="zoom-out-up"
                    >
                        {{ form.processing ? "Creating..." : "Publish Article" }}
                    </Button>
                </form>
            </CardContent>
        </Card>
    </div>
</template>
