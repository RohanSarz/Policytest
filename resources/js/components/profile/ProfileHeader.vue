<script setup lang="ts">
import { usePage } from "@inertiajs/vue3";
import { computed } from "vue";
import { Button } from "@/components/ui/button";
import { Card, CardContent } from "@/components/ui/card";
import { Badge } from "@/components/ui/badge";
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";
import { Camera, Calendar, Mail, MapPin } from "lucide-vue-next";

const page = usePage();
const user = computed(() => page.props.auth.user);
</script>

<template>
    <Card>
        <CardContent class="p-6">
            <div
                class="flex flex-col items-start gap-6 md:flex-row md:items-center"
            >
                <div class="relative">
                    <Avatar class="h-24 w-24">
                        <AvatarImage
                            :src="`/storage/${
                                user?.avatar ?? 'avatars/default.png'
                            }`"
                            alt="Profile"
                        />
                        <AvatarFallback class="text-2xl">
                            {{ user?.name ? user.name[0]?.toUpperCase() : "" }}
                        </AvatarFallback>
                    </Avatar>
                    <Button
                        size="icon"
                        variant="outline"
                        class="absolute -right-2 -bottom-2 h-8 w-8 rounded-full"
                    >
                        <Camera class="h-4 w-4" />
                    </Button>
                </div>
                <div class="flex-1 space-y-2">
                    <div
                        class="flex flex-col gap-2 md:flex-row md:items-center"
                    >
                        <h1 class="text-2xl font-bold">
                            {{ user?.name }}
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
                <Button variant="default">Edit Profile</Button>
            </div>
        </CardContent>
    </Card>
</template>
