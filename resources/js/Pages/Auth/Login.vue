<script setup>
import { useForm } from "@inertiajs/vue3";
import TextInput from "../Components/TextInput.vue";
import Input from "@/components/ui/input/Input.vue";
import Label from "@/components/ui/label/Label.vue";
import {
    Card,
    CardContent,
    CardDescription,
    CardFooter,
    CardHeader,
    CardTitle,
} from "@/components/ui/card";
import Button from "@/components/ui/button/Button.vue";

const form = useForm({
    email: null,
    password: null,
    remember: null,
});

const submit = () => {
    form.post(route("login"), {
        onError: () => form.reset("password", "remember"),
    });
};
</script>

<template>
    <Head title="Login" />
    <div class="relative">
        <form @submit="submit">
            <Card class="w-[350px] px-2">
                <CardHeader>
                    <CardTitle class="text-2xl">Log In</CardTitle>
                    <CardDescription
                        >Login with your credintials.</CardDescription
                    >
                </CardHeader>
                <CardContent class="space-y-4">
                    <Label for="name">Name</Label>
                    <Input name="name" placeholder="name" />
                    <Label for="email">Email</Label>
                    <Input name="email" placeholder="eg@mail.com" />
                    <Label for="password">Password</Label>
                    <Input name="password" placeholder="* * * * * *" />

                    <Button class="w-full" :disabled="form.processing">
                        Login
                    </Button>
                </CardContent>
                <CardFooter class="flex justify-between px-6 pb-6">
                    <div>
                        <p class="text-slate-600 mb-2">
                            Already have a account?
                            <Link :href="route('register')" class="text-link"
                                >Register</Link
                            >
                        </p>
                    </div>
                </CardFooter>
            </Card>
        </form>
    </div>
</template>
