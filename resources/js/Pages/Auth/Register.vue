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

    <div class="grid place-items-center mx-auto h-fit my-24">
        <Form action="/register" method="post" #default="{ processing }">
            <Card
                class="w-[350px] px-2"
                data-aos="fade-left"
                data-aos-duration="500"
            >
                <CardHeader data-aos="fade-left" data-aos-duration="300">
                    <CardTitle>Register</CardTitle>
                    <CardDescription>Register a new account.</CardDescription>
                </CardHeader>
                <CardContent class="space-y-3">
                    <Label
                        class="form-label"
                        for="avatar"
                        data-aos="zoom-in-left"
                        data-aos-duration="500"
                    >
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
                    <Label
                        class="form-label"
                        for="name"
                        data-aos="zoom-in-left"
                        data-aos-duration="600"
                    >
                        Name
                        <Input name="name" type="text" placeholder="name" />
                        <Error errorName="name" />
                    </Label>
                    <Label
                        class="form-label"
                        for="email"
                        data-aos="zoom-in-left"
                        data-aos-duration="700"
                    >
                        Email
                        <Input name="email" placeholder="eg@mail.com" />
                        <Error errorName="email" />
                    </Label>
                    <Label
                        class="form-label"
                        for="password"
                        data-aos="zoom-in-left"
                        data-aos-duration="800"
                    >
                        Password
                        <Input
                            name="password"
                            type="password"
                            placeholder="* * * * * * * *"
                        />
                        <Error errorName="password" />
                    </Label>
                    <Label
                        class="form-label"
                        for="password_confirmation"
                        data-aos="zoom-in-left"
                        data-aos-duration="900"
                    >
                        Confirm Password
                        <Input
                            name="password_confirmation"
                            type="password"
                            placeholder="Confirm your Passcode"
                        />
                        <Error errorName="password_confirmation" />
                    </Label>
                    <Button
                        class="w-full my-2"
                        type="submit"
                        :disabled="processing"
                        data-aos="zoom-in-left"
                        data-aos-duration="1000"
                    >
                        Register
                    </Button>
                </CardContent>
                <CardFooter data-aos="zoom-in-left" data-aos-duration="1200">
                    <div class="flex justify-start text-xs">
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
