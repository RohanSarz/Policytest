<script setup lang="ts">
import { usePage, useForm } from "@inertiajs/vue3";
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

// Holds the preview URL for the selected avatar
const previewImage = ref<string | null>(null);

// Reference to the hidden file input
const fileInput = ref<HTMLInputElement | null>(null);

// Revoke object URL to prevent memory leaks
const clearUrl = () => {
    if (previewImage.value) {
        URL.revokeObjectURL(previewImage.value);
        previewImage.value = null;
    }
};

// Handle file selection: generate preview or fall back to default
const handleFile = (e: Event) => {
    const target = e.target as HTMLInputElement;
    const file = target.files?.[0];

    clearUrl(); // Clean up any previous preview

    if (file) {
        // Create a local preview URL for the selected image
        previewImage.value = URL.createObjectURL(file);
    } else {
        // Fallback to default if no file (though this case rarely triggers on change)
        previewImage.value = `/storage/avatars/def.jpg`;
    }
};

// Inertia form for profile data submission
const profileForm = useForm({
    name: user.value?.name || '',
    email: user.value?.email || '',
});

// Inertia form for avatar submission
const avatarForm = useForm({
    avatar: null as File | null,
});

// Submit the selected avatar
const submitAvatar = () => {
    if (!avatarForm.avatar) return;

    avatarForm.post(route('profile.avatar.update'), {
        preserveScroll: true,
        onSuccess: () => {
            // On success, clear preview and let Inertia reload props
            clearUrl();
        },
    });
};

// Submit the profile form
const submitProfile = () => {
    profileForm.post(route('profile.store'), {
        preserveScroll: true,
        onSuccess: () => {
            clearUrl();
        },
    });
};

// Trigger file input click programmatically
const openFilePicker = () => {
    fileInput.value?.click();
};
</script>

<template>
    <Card>
        <CardContent class="p-6">
            <div
                class="flex flex-col items-start gap-6 md:flex-row md:items-center"
            >
                <!-- Avatar Section -->
                <div class="relative">
                    <!-- Display current or preview avatar -->
                    <Avatar class="h-24 w-24 border">
                        <AvatarImage
                            :src="previewImage || `/storage/${user?.avatar ?? 'avatars/def.jpg'}`"
                            :alt="user?.name"
                            class="object-cover object-top"
                        />
                        <AvatarFallback class="text-2xl">
                            {{ user?.name ? user.name[0]?.toUpperCase() : "" }}
                        </AvatarFallback>
                    </Avatar>

                    <!-- Hidden file input: bound to form data -->
                    <input
                        id="avatar"
                        ref="fileInput"
                        type="file"
                        name="avatar"
                        class="hidden"
                        accept="image/*"
                        @change="handleFile"
                        @input="avatarForm.avatar = ($event.target as HTMLInputElement).files?.[0] || null"
                        :disabled="avatarForm.processing"
                    />

                    <!-- Avatar Update Dialog -->
                    <Dialog>
                        <DialogTrigger as-child>
                            <Button
                                size="icon"
                                variant="outline"
                                class="absolute -right-2 -bottom-2 h-8 w-8 rounded-full"
                                :disabled="avatarForm.processing"
                            >
                                <Camera class="h-4 w-4" />
                            </Button>
                        </DialogTrigger>
                        <DialogContent>
                            <DialogHeader>
                                <DialogTitle>Update your avatar</DialogTitle>
                                <DialogDescription>
                                    Select an image file to update your profile picture.
                                    Image should be in JPG, JPEG, or PNG format and less than 2MB.
                                </DialogDescription>
                            </DialogHeader>
                            
                            <div class="space-y-4">
                                <!-- Preview of selected image -->
                                <div class="flex justify-center">
                                    <Avatar class="h-32 w-32 border">
                                        <AvatarImage
                                            :src="previewImage || `/storage/${user?.avatar ?? 'avatars/def.jpg'}`"
                                            :alt="user?.name"
                                            class="object-cover object-top"
                                        />
                                        <AvatarFallback class="text-3xl">
                                            {{ user?.name ? user.name[0]?.toUpperCase() : "" }}
                                        </AvatarFallback>
                                    </Avatar>
                                </div>
                                
                                <div class="space-y-2">
                                    <Label for="avatar-input">Choose Image</Label>
                                    <Input
                                        id="avatar-input"
                                        type="file"
                                        accept="image/*"
                                        @change="handleFile"
                                        @input="avatarForm.avatar = ($event.target as HTMLInputElement).files?.[0] || null"
                                        :disabled="avatarForm.processing"
                                    />
                                </div>
                                
                                <Button 
                                    @click="submitAvatar" 
                                    :disabled="!avatarForm.avatar || avatarForm.processing"
                                    class="w-full"
                                >
                                    {{ avatarForm.processing ? 'Updating...' : 'Save Avatar' }}
                                </Button>
                            </div>
                        </DialogContent>
                    </Dialog>
                </div>

                <!-- User Info Section (unchanged) -->
                <div class="flex-1 space-y-2">
                    <div
                        class="flex flex-col gap-2 md:flex-row md:items-center"
                    >
                        <h1 class="text-2xl font-bold">
                            <UserNameUpper :name="user.name" />
                        </h1>
                        <Badge variant="secondary">{{
                            page.props.auth.role && page.props.auth.role.length > 0 ? page.props.auth.role[0] : "User"
                        }}</Badge>
                    </div>
                    <p class="text-muted-foreground">
                        {{ page.props.auth.role && page.props.auth.role.length > 0 ? page.props.auth.role[0] : "User" }}
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

                <!-- Edit Profile Dialog (unchanged) -->
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

                            <form @submit.prevent="submitProfile">
                                <div
                                    class="grid grid-cols-1 gap-6 md:grid-cols-2"
                                >
                                    <div class="space-y-2">
                                        <Label for="name">Name</Label>
                                        <Input
                                            id="name"
                                            v-model="profileForm.name"
                                            :disabled="profileForm.processing"
                                        />
                                    </div>

                                    <div class="space-y-2">
                                        <Label for="email">Email</Label>
                                        <Input
                                            id="email"
                                            v-model="profileForm.email"
                                            type="email"
                                            :disabled="profileForm.processing"
                                        />
                                    </div>

                                    <div class="space-y-2">
                                        <Label for="jobTitle">Job Title</Label>
                                        <Input
                                            id="jobTitle"
                                            name="jobTitle"
                                            value="Software Engineer"
                                            disabled
                                        />
                                    </div>

                                    <div class="space-y-2">
                                        <Label for="company">Company</Label>
                                        <Input
                                            id="company"
                                            name="company"
                                            value="Your Company"
                                            disabled
                                        />
                                    </div>
                                    <Button
                                        type="submit"
                                        :disabled="profileForm.processing"
                                        class="place-self-start"
                                        >Save Changes</Button>
                                </div>
                            </form>
                        </DialogHeader>
                    </DialogContent>
                </Dialog>
            </div>
        </CardContent>
    </Card>
</template>
