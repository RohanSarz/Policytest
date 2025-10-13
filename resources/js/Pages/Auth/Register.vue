<script setup>
import { Form } from "@inertiajs/vue3";
import TextInput from "../Components/TextInput.vue";
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
import { onMounted, onUnmounted, ref } from "vue";

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

    <Transition name="page" mode="out-in">
        <Form
            action="/register"
            method="post"
            #default="{ processing, errors }"
        >
            <Card class="w-[350px] px-2">
                <CardHeader>
                    <CardTitle class="text-2xl">Register</CardTitle>
                    <CardDescription>Register a new account.</CardDescription>
                </CardHeader>
                <CardContent class="space-y-4">
                    <Label for="avatar"
                        >Avatar
                        <Avatar>
                            <Input
                            class="hidden"
                                @change="handleFile"
                                type="file"
                                name="avatar"
                                :disabled="processing"
                            />
                            <!-- v-if="previewImage" -->
                            <AvatarImage
                                v-if="previewImage"
                                :src="previewImage"
                                alt="Avatar"
                            />
                            <AvatarFallback>No Image</AvatarFallback>
                        </Avatar>
                    </Label>
                    <Label for="name">Name</Label>
                    <Input name="name" type="text" placeholder="name" />
                    <div v-if="errors.name"></div>
                    <Label for="email">Email</Label>
                    <Input name="email" placeholder="eg@mail.com" />
                    <Label for="password">Password</Label>
                    <Input name="password" placeholder="* * * * * * * *" />

                    <Label for="password_confirmation">Confirm Password</Label>
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
    </Transition>
</template>
