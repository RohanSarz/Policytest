<script setup lang="ts">
import { usePage, Form } from "@inertiajs/vue3";
import { computed, ref } from "vue";
import { Button } from "@/components/ui/button";
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from "@/components/ui/card";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { Badge } from "@/components/ui/badge";
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";
import { Camera, Calendar, Mail, MapPin } from "lucide-vue-next";
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from "@/components/ui/dialog";
import UserNameUpper from "../userDataComponents/UserNameUpper.vue";
const page = usePage();
const user = computed(() => page.props.auth.user);

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
        previewImage.value = `/storage/avatars/def.jpg`;
    }
    console.log(previewImage.value);
};

// handle the avatar form submission
const onAvatarSubmit = (data) => {
    // Inertia forms automatically handle the response
    // If the avatar update is successful, the page will be reloaded with updated user data
    // Clear the preview image after successful submission
    clearUrl();
};
</script>

<template>
    <Card>
        <CardContent class="p-6">
            <div
                class="flex flex-col items-start gap-6 md:flex-row md:items-center"
            >
                <div class="relative">
                    <Avatar class="h-24 w-24 border">
                        <AvatarImage
                            :src="`/storage/${
                                user?.avatar ?? 'avatars/def.jpg'
                            }`"
                            :alt="user?.name"
                            class="object-cover object-top"
                        />
                        <AvatarFallback class="text-2xl">
                            {{ user?.name ? user.name[0]?.toUpperCase() : "" }}
                        </AvatarFallback>
                    </Avatar>
                    <Dialog>
                        <!-- Trigger: camera button on avatar -->
                        <DialogTrigger asChild>
                            <Button
                                size="icon"
                                variant="outline"
                                class="absolute -right-2 -bottom-2 h-8 w-8 rounded-full"
                            >
                                <Camera class="h-4 w-4" />
                            </Button>
                        </DialogTrigger>

                        <!-- Dialog Content -->
                        <DialogContent class="sm:max-w-sm">
                            <DialogHeader>
                                <DialogTitle>Update Profile Image</DialogTitle>
                                <DialogDescription>
                                    Choose a new avatar to update your profile
                                    image.
                                </DialogDescription>
                            </DialogHeader>

                            <Form
                                :action="route('profile.avatar')"
                                method="post"
                                enctype="multipart/form-data"
                                #default="{ processing, wasSuccessful }"
                                @finish="() => { if(wasSuccessful) clearUrl(); }"
                            >
                                <div class="flex flex-col items-center gap-4">
                                    <!-- Avatar Preview -->
                                    <label for="avatar" class="cursor-pointer">
                                        <Avatar class="h-24 w-24 border-2">
                                            <AvatarImage
                                                v-if="previewImage"
                                                :src="previewImage"
                                                class="object-cover w-full h-full"
                                            />
                                            <AvatarImage
                                                v-else
                                                :src="`/storage/${
                                                    user?.avatar ??
                                                    'avatars/def.jpg'
                                                }`"
                                                class="object-cover w-full h-full"
                                            />
                                            <AvatarFallback>
                                                {{
                                                    user?.name
                                                        ? user.name[0].toUpperCase()
                                                        : "?"
                                                }}
                                            </AvatarFallback>
                                        </Avatar>
                                    </label>

                                    <!-- File Input -->
                                    <Input
                                        id="avatar"
                                        type="file"
                                        name="avatar"
                                        class="hidden"
                                        @change="handleFile"
                                        :disabled="processing"
                                    />

                                    <!-- Submit -->
                                    <Button
                                        type="submit"
                                        :disabled="processing"
                                        class="w-full"
                                    >
                                        Save Changes
                                    </Button>
                                </div>
                            </Form>
                        </DialogContent>
                    </Dialog>
                </div>
                <div class="flex-1 space-y-2">
                    <div
                        class="flex flex-col gap-2 md:flex-row md:items-center"
                    >
                        <h1 class="text-2xl font-bold">
                            <UserNameUpper :name="user.name" />
                        </h1>
                        <Badge variant="secondary">{{
                            user?.role || "MemberT  "
                        }}</Badge>
                    </div>
                    <p class="text-muted-foreground">
                        {{ user?.role || "UserT" }}
                    </p>
                    <div
                        class="text-muted-foreground flex flex-wrap gap-4 text-sm"
                    >
                        <div class="flex items-center gap-1">
                            <Mail class="h-4 w-4" />
                            {{ user?.email }}
                        </div>
                        <div class="flex items-center gap-1">
                            <MapPin class="h-4 w-4" />
                            {{ user?.address || "Location not set" }}
                        </div>
                        <div class="flex items-center gap-1">
                            <Calendar class="h-4 w-4" />
                            Joined
                            {{
                                user?.created_at
                                    ? new Date(
                                          user.created_at
                                      ).toLocaleDateString("en-US", {
                                          month: "long",
                                          year: "numeric",
                                      })
                                    : "date unknown"
                            }}
                        </div>
                    </div>
                </div>
                <Dialog>
                    <DialogTrigger
                        ><Button variant="default"
                            >Edit Profile</Button
                        ></DialogTrigger
                    >
                    <DialogContent>
                        <DialogHeader>
                            <DialogTitle>Make changes on profile </DialogTitle>
                            <DialogDescription>
                                Note: Changes will be reflected everywhere,
                                Currently the Email is disabled for editing.
                            </DialogDescription>

                            <Form
                                :action="route('profile.store')"
                                method="post"
                                #default="{ processing }"
                            >
                                <div
                                    class="grid grid-cols-1 gap-6 md:grid-cols-2"
                                >
                                    <div class="space-y-2">
                                        <Label for="name">Name</Label>
                                        <Input
                                            id="name"
                                            name="name"
                                            :default-value="
                                                user?.name?.split(' ')[0] || ''
                                            "
                                            :disabled="processing"
                                        />
                                    </div>

                                    <div class="space-y-2">
                                        <Label for="email">Email</Label>
                                        <Input
                                            id="email"
                                            name="email"
                                            type="email"
                                            :default-value="user?.email || ''"
                                            :disabled="processing"
                                        />
                                    </div>

                                    <div class="space-y-2">
                                        <Label for="jobTitle">Job Title</Label>
                                        <Input
                                            id="jobTitle"
                                            name="jobTitle"
                                            default-value="Software Engineer"
                                            disabled
                                        />
                                    </div>

                                    <div class="space-y-2">
                                        <Label for="company">Company</Label>
                                        <Input
                                            id="company"
                                            name="company"
                                            default-value="Your Company"
                                            disabled
                                        />
                                    </div>
                                    <DialogTrigger
                                        v-show="!processing"
                                        class="place-self-start"
                                        ><Button
                                            >Save Changes</Button
                                        ></DialogTrigger
                                    >
                                </div>
                            </Form>
                        </DialogHeader>
                    </DialogContent>
                </Dialog>
            </div>
        </CardContent>
    </Card>
</template>
