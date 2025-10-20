<script setup>
import { Form, usePage } from "@inertiajs/vue3";
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

const page = usePage();
const post = page.props.post;
</script>

<template>
    <Head :title="`Edit Post: ${post.title}`" />
    <div
        class="grid place-items-center mx-auto h-screen"
        data-aos="fade-down-left"
    >
        <Form
            :action="route('posts.update', post.id)"
            method="put"
            #default="{ processing, errors }"
        >
            <Card class="min-w-4xl px-2">
                <CardHeader>
                    <CardTitle>Edit Post</CardTitle>
                    <CardDescription>Update your post content</CardDescription>
                </CardHeader>
                <CardContent class="space-y-4">
                    <Label for="title">Title</Label>
                    <Input
                        name="title"
                        placeholder="News Title"
                        :defaultValue="post.title"
                    />
                    <div v-if="errors.title" class="text-red-500 text-sm">
                        {{ errors.title }}
                    </div>

                    <Label for="body">Content</Label>
                    <Textarea
                        name="body"
                        placeholder="Write your post..."
                        :defaultValue="post.body"
                    />
                    <div v-if="errors.body" class="text-red-500 text-sm">
                        {{ errors.body }}
                    </div>

                    <div class="flex gap-2">
                        <Button variant="outline" :disabled="processing">
                            Update Post
                        </Button>
                    </div>
                </CardContent>
            </Card>
        </Form>
    </div>
</template>
