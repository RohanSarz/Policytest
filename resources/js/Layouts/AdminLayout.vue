<script setup lang="ts">
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarGroup,
    SidebarGroupContent,
    SidebarGroupLabel,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
    SidebarRail,
    SidebarInset,
} from "@/components/ui/sidebar";
import { SidebarProvider } from "@/components/ui/sidebar";
import { SidebarTrigger } from "@/components/ui/sidebar";
import {
    Folder,
    Settings,
    User,
    Users,
    BarChart3,
    MessageCircle,
    Home,
    LogOut,
    Key,
} from "lucide-vue-next";
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";
import { Button } from "@/components/ui/button";
import { usePage } from "@inertiajs/vue3";

const page = usePage();
const user = page.props.auth?.user || {};
</script>

<template>
    <Head>
        <title>Admin Dashboard</title>
    </Head>
    <SidebarProvider>
        <div class="flex h-screen">
            <!-- Admin Sidebar -->
            <Sidebar>
                <SidebarHeader class="p-4 border-b">
                    <div class="flex items-center gap-3">
                        <div
                            class="bg-blue-500 w-8 h-8 rounded-md flex items-center justify-center text-white font-bold"
                        >
                            A
                        </div>
                        <span class="text-lg font-semibold">Admin Panel</span>
                    </div>
                </SidebarHeader>

                <SidebarContent class="p-2">
                    <SidebarGroup>
                        <SidebarGroupLabel>Navigation</SidebarGroupLabel>
                        <SidebarGroupContent>
                            <SidebarMenu>
                                <SidebarMenuItem>
                                    <SidebarMenuButton as-child>
                                        <a href="/admin">
                                            <BarChart3 class="mr-2 h-4 w-4" />
                                            <span>Dashboard</span>
                                        </a>
                                    </SidebarMenuButton>
                                </SidebarMenuItem>
                                <SidebarMenuItem>
                                    <SidebarMenuButton as-child>
                                        <a href="/admin/users">
                                            <Users class="mr-2 h-4 w-4" />
                                            <span>Users</span>
                                        </a>
                                    </SidebarMenuButton>
                                </SidebarMenuItem>
                                <SidebarMenuItem>
                                    <SidebarMenuButton as-child>
                                        <a href="/admin/roles">
                                            <Key class="mr-2 h-4 w-4" />
                                            <span>Roles</span>
                                        </a>
                                    </SidebarMenuButton>
                                </SidebarMenuItem>
                                <SidebarMenuItem>
                                    <SidebarMenuButton as-child>
                                        <a href="/admin/permissions">
                                            <Folder class="mr-2 h-4 w-4" />
                                            <span>Permissions</span>
                                        </a>
                                    </SidebarMenuButton>
                                </SidebarMenuItem>
                                <SidebarMenuItem>
                                    <SidebarMenuButton as-child>
                                        <a href="/admin/posts">
                                            <MessageCircle
                                                class="mr-2 h-4 w-4"
                                            />
                                            <span>Posts</span>
                                        </a>
                                    </SidebarMenuButton>
                                </SidebarMenuItem>
                            </SidebarMenu>
                        </SidebarGroupContent>
                    </SidebarGroup>
                </SidebarContent>

                <SidebarFooter class="p-4 border-t">
                    <SidebarMenu>
                        <SidebarMenuItem>
                            <SidebarMenuButton as-child>
                                <a href="/">
                                    <LogOut class="mr-2 h-4 w-4" />
                                    <span>Back to Site</span>
                                </a>
                            </SidebarMenuButton>
                        </SidebarMenuItem>
                    </SidebarMenu>
                    <div class="flex items-center gap-3 p-2 mt-2">
                        <Avatar class="h-10 w-10">
                            <AvatarImage
                                :src="
                                    user.avatar
                                        ? `/storage/${user.avatar}`
                                        : '/storage/avatars/admin.png'
                                "
                                :alt="user.name"
                            />
                            <AvatarFallback>{{
                                user.name?.charAt(0).toUpperCase()
                            }}</AvatarFallback>
                        </Avatar>
                        <div class="leading-none">
                            <p class="font-medium">
                                {{ user.name || "Admin User" }}
                            </p>
                            <p class="text-sm text-muted-foreground">
                                {{ user.email || "admin@example.com" }}
                            </p>
                        </div>
                    </div>
                </SidebarFooter>
                <SidebarRail />
            </Sidebar>

            <!-- Main Content Area with SidebarInset -->
            <SidebarInset>
                <header
                    class="flex w-[100rem] h-16 shrink-0 items-center gap-2 border-b px-4"
                >
                    <SidebarTrigger class="mr-2" />
                    <div class="flex items-center gap-2">
                        <h1 class="text-lg font-semibold">Admin Dashboard</h1>
                    </div>
                </header>
                <div>
                    <slot />
                </div>
            </SidebarInset>
        </div>
    </SidebarProvider>
</template>
