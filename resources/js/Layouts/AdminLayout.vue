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
import { Link } from "@inertiajs/vue3";
import { dashboard as adminDashboard } from "@/routes/admin";
import { index as adminRoles } from "@/routes/admin/roles/index";
import { index as adminUsers } from "@/routes/admin/users/index";
import { index as adminPermissions } from "@/routes/admin/permissions/index";
import { index as adminPosts } from "@/routes/admin/posts/index";
import { home } from "@/routes";

const page = usePage<{ auth: { user: any } }>();
const user = page.props.auth?.user || {};
</script>

<template>
    <Head>
        <title>Admin Dashboard</title>
    </Head>
    <SidebarProvider>
        <div class="flex">
            <!-- Admin Sidebar -->
            <Sidebar>
                <SidebarHeader class="p-4 border-b">
                    <div class="flex items-center gap-3">
                        <div
                            class="bg-blue-500 w-12 h-8 rounded-md flex items-center justify-center text-white font-bold"
                        >
                            Vuda
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
                                        <Link :href="adminDashboard().url">
                                            <BarChart3 class="mr-2 h-4 w-4" />
                                            <span>Dashboard</span>
                                        </Link>
                                    </SidebarMenuButton>
                                </SidebarMenuItem>
                                <SidebarMenuItem>
                                    <SidebarMenuButton as-child>
                                        <Link :href="adminUsers().url">
                                            <Users class="mr-2 h-4 w-4" />
                                            <span>Users</span>
                                        </Link>
                                    </SidebarMenuButton>
                                </SidebarMenuItem>
                                <SidebarMenuItem>
                                    <SidebarMenuButton as-child>
                                        <Link :href="adminRoles().url">
                                            <Key class="mr-2 h-4 w-4" />
                                            <span>Roles</span>
                                        </Link>
                                    </SidebarMenuButton>
                                </SidebarMenuItem>
                                <SidebarMenuItem>
                                    <SidebarMenuButton as-child>
                                        <Link :href="adminPermissions().url">
                                            <Folder class="mr-2 h-4 w-4" />
                                            <span>Permissions</span>
                                        </Link>
                                    </SidebarMenuButton>
                                </SidebarMenuItem>
                                <SidebarMenuItem>
                                    <SidebarMenuButton as-child>
                                        <Link :href="adminPosts().url">
                                            <MessageCircle
                                                class="mr-2 h-4 w-4"
                                            />
                                            <span>Posts</span>
                                        </Link>
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
                                <Link :href="home().url">
                                    <LogOut class="mr-2 h-4 w-4" />
                                    <span>Back to Site</span>
                                </Link>
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
            <SidebarInset class="w-[100rem] overflow-x-clip">
                <header class="flex gap-2 px-4 py-4 border-b">
                    <SidebarTrigger class="size-8" />

                    <h1 class="text-lg font-semibold">Admin Dashboard</h1>
                </header>
                <div>
                    <slot />
                </div>
            </SidebarInset>
        </div>
    </SidebarProvider>
</template>
