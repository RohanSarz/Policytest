<script setup>
import { Form } from "@inertiajs/vue3";
import Input from "@/components/ui/input/Input.vue";
import Label from "@/components/ui/label/Label.vue";
import { ArrowLeft } from "lucide-vue-next";
import {
    Card,
    CardContent,
    CardDescription,
    CardFooter,
    CardHeader,
    CardTitle,
} from "@/components/ui/card";
import Button from "@/components/ui/button/Button.vue";
import Textarea from "@/components/ui/textarea/Textarea.vue";
</script>
<template>
    <Head title="Login" />
    <div
        class="grid place-items-center mx-auto h-screen"
        data-aos="fade-down-left"
    >
        <Form action="/posts" method="post" #default="{ processing, errors }">
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
                        {{ errors.body }}
                    </div>

                    <Button class="w-full" :disabled="processing">
                        Create
                    </Button>
                </CardContent>
            </Card>
        </Form>
    </div>
</template>
