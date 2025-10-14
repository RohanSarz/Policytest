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
</script>

<template>
    <Head title="Login" />
    <div class="relative">
        <Form action="/login" method="post" #default="{ processing, errors }">
            <Card class="w-[350px] px-2">
                <CardHeader>
                    <CardTitle class="text-2xl">Log In</CardTitle>
                    <CardDescription
                        >Login with your credintials.</CardDescription
                    >
                </CardHeader>
                <CardContent class="space-y-4">
                    <Label class="form-label" for="email">Email</Label>
                    <Input name="email" placeholder="eg@mail.com" />
                    <div v-if="errors.email">
                        {{ errors.email }}
                    </div>
                    <Label class="form-label" for="password">Password</Label>
                    <Input name="password" placeholder="* * * * * * * *" />
                    <div v-if="errors.name">
                        {{ errors.password }}
                    </div>

                    <Button :as="Link" class="w-full" :disabled="processing">
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
        </Form>
    </div>
</template>
