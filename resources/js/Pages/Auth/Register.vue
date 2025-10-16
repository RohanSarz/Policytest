<script setup>
import { Form } from "@inertiajs/vue3";
import Error from "@/components/Error.vue";

import Input from "@/components/ui/input/Input.vue";
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";
import {
    Card,
    CardContent,
    CardDescription,
    CardFooter,
    CardHeader,
    CardTitle,
} from "@/components/ui/card";
import Button from "@/components/ui/button/Button.vue";
import Label from "@/components/ui/label/Label.vue";
import { onBeforeMount, onMounted, onUnmounted, ref } from "vue";

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

onBeforeMount(() => {
    console.log(previewImage.value, "Before Mounted ");
});
// clearing and logging
onMounted(() => {
    console.log(previewImage.value, "Mounted ");
});
onUnmounted(() => {
    console.log(previewImage.value, "test ");
    clearUrl();
    console.log(previewImage.value, "Destroyed ");
});
</script>

<template>
    <Head title="Register" />

    <div class="grid place-items-center mx-auto h-screen">
        <Form
            action="/register"
            method="post"
            #default="{ processing, errors }"
        >
            <Card class="w-6/6 lg:w-[600px] px-6">
                <CardHeader>
                    <CardTitle class="text-2xl">Register</CardTitle>
                    <CardDescription>Register a new account.</CardDescription>
                </CardHeader>
                <CardContent class="space-y-4">
                    <Label class="form-label text" for="avatar">
                        <div class="grid place-items-center gap-2">
                            Avatar
                            <Input
                                class="hidden"
                                id="avatar"
                                @change="handleFile"
                                type="file"
                                name="avatar"
                                :disabled="processing"
                            />
                            <Avatar class="size-16 border-2 border-black">
                                <!-- v-if="previewImage" -->
                                <AvatarImage
                                    class="object-cover w-full h-full"
                                    v-if="previewImage"
                                    :src="previewImage"
                                    alt="Avatar"
                                />
                                <AvatarFallback
                                    v-else-if="$page.props.auth.user"
                                >
                                    {{ $page.props.auth.user.name[0] }}
                                </AvatarFallback>
                                <AvatarFallback v-else> ? </AvatarFallback>
                            </Avatar>
                        </div>
                        <Error
                            class="text-center py-2 text-xs font-mono"
                            errorName="avatar"
                        />
                    </Label>
                    <Label class="form-label" for="name">Name</Label>
                    <Input name="name" type="text" placeholder="name" />
                    <Error errorName="name" />
                    <Label class="form-label" for="email">Email</Label>
                    <Input name="email" placeholder="eg@mail.com" />
                    <Error errorName="email" />
                    <Label class="form-label" for="password">Password</Label>
                    <Input name="password" placeholder="* * * * * * * *" />
                    <Error errorName="password" />
                    <Label class="form-label" for="password_confirmation">
                        Confirm Password
                    </Label>
                    <Input
                        name="password_confirmation"
                        placeholder="Confirm your Passcode"
                    />
                    <Button class="w-full" type="submit" :disabled="processing">
                        Register
                    </Button>
                </CardContent>
                <CardFooter class="flex justify-between px-6 pb-6">
                    <div>
                        <p class="text-slate-600 mb-2">
                            Already a user?
                            <Link :href="route('login')" class="text-link"
                                >Login</Link
                            >
                        </p>
                    </div>
                </CardFooter>
            </Card>
        </Form>
    </div>
</template>
