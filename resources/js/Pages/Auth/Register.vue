<script setup>
import { useForm } from "@inertiajs/vue3";
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
const form = useForm({
    name: null,
    email: null,
    password: null,
    password_confirmation: null,
    avatar: null,
    preview: null,
});

const change = (e) => {
    form.avatar = e.target.files[0] || form.avatar;
    form.preview = URL.createObjectURL(e.target.files[0]);
};

const submit = () => {
    form.post(route("register"), {
        onError: () => form.reset("password", "password_confirmation"),
    });
};
</script>

<template>
    <Head title="Register" />
    <Transition name="page" mode="out-in">
        <form @submit="submit">
            <Card class="w-[350px] px-2">
                <CardHeader>
                    <CardTitle class="text-2xl">Register</CardTitle>
                    <CardDescription>Register a new account.</CardDescription>
                </CardHeader>
                <CardContent class="space-y-4">
                    <Label for="avatar"
                        >Avatar
                        <Input class="hidden" type="file" name="avatar" />
                        <Avatar>
                            <AvatarImage src="#" alt="Home" />
                            <AvatarFallback>CN </AvatarFallback>
                        </Avatar>
                    </Label>
                    <Label for="name">Name</Label>
                    <Input name="name" type="text" placeholder="name" />
                    <Label for="email">Email</Label>
                    <Input name="email" placeholder="eg@mail.com" />
                    <Label for="password">Password</Label>
                    <Input name="password" placeholder="* * * * * * * *" />

                    <Label for="password_confirmation">Confirm Password</Label>
                    <Input
                        name="password_confirmation"
                        placeholder="Confirm your Passcode"
                    />
                    <Button class="w-full" :disabled="form.processing">
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
                        <button class="primary-btn" :disabled="form.processing">
                            Register
                        </button>
                    </div>
                </CardFooter>
            </Card>
        </form>
    </Transition>
</template>
