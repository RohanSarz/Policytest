<script setup>
import { Form } from "@inertiajs/vue3";
import Input from "@/components/ui/input/Input.vue";
import Label from "@/components/ui/label/Label.vue";
<<<<<<< HEAD
import Button from "@/components/ui/button/Button.vue";
import Textarea from "@/components/ui/textarea/Textarea.vue";
=======
import { ArrowLeft } from "lucide-vue-next";
>>>>>>> 2a79c7e3c0681e4b9c4e00c23d755f56846b1f8b
import {
    Card,
    CardContent,
    CardDescription,
    CardFooter,
    CardHeader,
    CardTitle,
} from "@/components/ui/card";
<<<<<<< HEAD
</script>

<template>
    <Head title="Create Post" />
=======
import Button from "@/components/ui/button/Button.vue";
import Textarea from "@/components/ui/textarea/Textarea.vue";
</script>
<template>
    <Head title="Login" />
>>>>>>> 2a79c7e3c0681e4b9c4e00c23d755f56846b1f8b
    <div
        class="grid place-items-center mx-auto h-screen"
        data-aos="fade-down-left"
    >
        <Form action="/posts" method="post" #default="{ processing, errors }">
<<<<<<< HEAD
            <Card class="w-[350px] px-2">
                <CardHeader>
                    <CardTitle>Create a post</CardTitle>
                    <CardDescription>Share your thoughts</CardDescription>
                </CardHeader>
                <CardContent class="space-y-4">
                    <Label for="title">Title</Label>
                    <Input name="title" placeholder="News Title" />
                    <div v-if="errors.title" class="text-red-500 text-sm">
                        {{ errors.title }}
                    </div>

                    <Label for="body">Content</Label>
                    <Textarea name="body" placeholder="Write your post..." />
                    <div v-if="errors.body" class="text-red-500 text-sm">
=======
            <div class="flex items-center hover:underline">
                <ArrowLeft class="size-4" />
                <Link :href="route('dashboard')"> Go back to dashboard</Link>
            </div>
            <Card class="w-[350px] px-2">
                <CardHeader>
                    <CardTitle>Create a post</CardTitle>
                    <CardDescription>Post description</CardDescription>
                </CardHeader>
                <CardContent class="space-y-4">
                    <Label class="form-label" for="title">Title</Label>
                    <Input name="title" placeholder="News Title" />
                    <div v-if="errors.title">
                        {{ errors.email }}
                    </div>
                    <Label class="form-label" for="body">Body</Label>
                    <Textarea name="body" placeholder="Content" />
                    <div v-if="errors.name">
>>>>>>> 2a79c7e3c0681e4b9c4e00c23d755f56846b1f8b
                        {{ errors.body }}
                    </div>

                    <Button class="w-full" :disabled="processing">
<<<<<<< HEAD
                        Create Post
=======
                        Create
>>>>>>> 2a79c7e3c0681e4b9c4e00c23d755f56846b1f8b
                    </Button>
                </CardContent>
            </Card>
        </Form>
    </div>
</template>
