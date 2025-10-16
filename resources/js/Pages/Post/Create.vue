<script setup>
import { Form } from "@inertiajs/vue3";
import Input from "@/components/ui/input/Input.vue";
import Label from "@/components/ui/label/Label.vue";
import Button from "@/components/ui/button/Button.vue";
import Textarea from "@/components/ui/textarea/Textarea.vue";
import {
    Card,
    CardContent,
    CardDescription,
    CardFooter,
    CardHeader,
    CardTitle,
} from "@/components/ui/card";
</script>

<template>
    <Head title="Create Post" />
    <div
        class="grid place-items-center mx-auto h-screen"
        data-aos="fade-down-left"
    >
        <Form action="/posts" method="post" #default="{ processing, errors }">
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
                        {{ errors.body }}
                    </div>

                    <Button class="w-full" :disabled="processing">
                        Create Post
                    </Button>
                </CardContent>
            </Card>
        </Form>
    </div>
</template>
