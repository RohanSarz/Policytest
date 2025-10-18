<script setup>
import { Form } from "@inertiajs/vue3";
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
import Error from "@/components/Error.vue";
</script>

<template>
    <Head title="Login" />
    <div class="grid place-items-center mx-auto h-fit my-24">
        <Form action="/login" method="post" #default="{ processing }">
            <Card
                class="w-[350px] px-2"
                data-aos="fade-left"
                data-aos-duration="500"
            >
                <CardHeader data-aos="fade-left" data-aos-duration="300">
                    <CardTitle>Log In</CardTitle>
                    <CardDescription
                        >Login with your credintials.</CardDescription
                    >
                </CardHeader>
                <CardContent class="space-y-3">
                    <Label
                        class="form-label"
                        for="email"
                        data-aos="zoom-in-left"
                        data-aos-duration="500"
                        >Email
                        <Input name="email" placeholder="eg@mail.com" />
                        <Error errorName="email" />
                    </Label>
                    <Label
                        class="form-label"
                        for="password"
                        data-aos="zoom-in-left"
                        data-aos-duration="700"
                        >Password

                        <Input
                            name="password"
                            type="password"
                            placeholder="* * * * * * * *"
                        />
                        <Error errorName="password" />
                    </Label>
                    <div class="flex gap-2 items-center">
                        <Label
                            class="text-xs"
                            for="remember"
                            data-aos="zoom-in-left"
                            data-aos-duration="600"
                        >
                            <Input
                                class="size-3"
                                id="remember"
                                type="checkbox"
                            />

                            Remember Me
                        </Label>
                    </div>

                    <Button
                        class="w-full my-2"
                        :disabled="processing"
                        data-aos="zoom-in-left"
                        data-aos-duration="800"
                    >
                        Login
                    </Button>
                </CardContent>
                <CardFooter data-aos="zoom-in-left" data-aos-duration="1200">
                    <div class="flex justify-start text-xs">
                        <p class="text-slate-600 mb-2">
                            Already have a account?
                            <Link :href="route('register')" class="">
                                Register</Link
                            >
                        </p>
                    </div>
                </CardFooter>
            </Card>
        </Form>
    </div>
</template>
