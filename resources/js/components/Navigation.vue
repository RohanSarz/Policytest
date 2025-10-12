<script setup lang="ts">
import { computed } from "vue";
import {
    Home,
    LayoutDashboard,
    Menu,
    Settings,
    User,
    UserRound,
} from "lucide-vue-next";
import { Button } from "@/components/ui/button";
import { Sheet, SheetContent, SheetTrigger } from "@/components/ui/sheet";

import {
    Breadcrumb,
    BreadcrumbItem,
    BreadcrumbLink,
    BreadcrumbList,
    BreadcrumbPage,
    BreadcrumbSeparator,
} from "@/components/ui/breadcrumb";

const navlinks = [
    {
        id: 1,
        name: "Home",
        icon: Home,
        path: "/",
    },
    {
        id: 2,
        name: "Dashboard",
        icon: LayoutDashboard,
        path: "/dashboard",
    },
];

// Function to close mobile menu after navigation
const closeMobileMenu = () => {
    // This will be handled by the Sheet component automatically
};

// Check if the current path matches the link path
const isActiveLink = (path: string) => {
    return window.location.pathname === path;
};
</script>
<template>
    <nav class="relative">
        <!-- Desktop Nav Menu (hidden on mobile) -->

        <ul
            class="hidden md:flex justify-end items-center bg-secondary-foreground text-white dark:bg-primary space-x-6 px-3 py-3"
        >
            <li v-if="!$page.props.auth.user" class="flex-1 text-gray-400">
                Please
                <Link class="hover:underline hover:text-gray-700" href="/login"
                    >Login</Link
                >
                or
                <Link
                    class="hover:underline hover:text-gray-700"
                    href="/register"
                >
                    Register</Link
                >
                to continue.
            </li>
            <li v-if="$page.props.auth.user" class="flex-1 text-gray-400">
                Welcome,
                <span class="text-gray-600">
                    {{ $page.props.auth.user.name }} </span
                >!
            </li>

            <li
                v-for="{ id, name, icon, path } in navlinks"
                :key="id"
                class="flex items-center"
            >
                <Button
                    variant="ghost"
                    :class="isActiveLink(path) ? 'bg-accent text-black' : ''"
                >
                    <Link :href="path" class="flex items-center">
                        <component :is="icon" class="w-4 h-4 mr-2" />
                        {{ name }}
                    </Link>
                </Button>
            </li>

            <li v-if="!$page.props.auth.user" class="space-x-6">
                <Button variant="ghost">
                    <Link
                        class="hover:bg-accent flex items-center"
                        href="/login"
                    >
                        <Settings class="w-4 h-4 mr-2" />
                        Login
                    </Link>
                </Button>
                <Button variant="ghost">
                    <Link
                        class="hover:bg-accent flex items-center"
                        href="/register"
                    >
                        <UserRound class="w-4 h-4 mr-2" />
                        Register
                    </Link>
                </Button>
            </li>

            <li v-else class="space-x-6">
                <Button variant="ghost">
                    <Link
                        class="hover:bg-accent"
                        :href="'/users/' + $page.props.auth.user.id"
                        >Profile</Link
                    >
                </Button>
                <Button variant="ghost">
                    <Link method="post" class="hover:bg-accent" href="/logout"
                        >Logout</Link
                    >
                </Button>
            </li>
        </ul>

        <!-- Mobile Nav Menu -->
        <div
            class="md:hidden flex justify-between items-center bg-secondary-foreground text-white dark:bg-primary px-3 py-3"
        >
            <div v-if="!$page.props.auth.user" class="flex-1 text-gray-400">
                Please
                <Link class="hover:underline hover:text-gray-700" href="/login"
                    >Login</Link
                >
                or
                <Link
                    class="hover:underline hover:text-gray-700"
                    href="/register"
                >
                    Register</Link
                >
                to continue.
            </div>
            <div v-if="$page.props.auth.user" class="flex-1 text-gray-400">
                Welcome,
                <span class="text-gray-600"> {{ $page.props.auth.user }} </span
                >!
            </div>

            <Sheet>
                <SheetTrigger as-child>
                    <Button variant="ghost" class="text-white hover:bg-accent">
                        <Menu class="w-5 h-5" />
                    </Button>
                </SheetTrigger>
                <SheetContent side="right" class="w-64 bg-background">
                    <div class="flex flex-col space-y-4 mt-6">
                        <div
                            v-for="{ id, name, icon, path } in navlinks"
                            :key="id"
                            class="mb-2"
                        >
                            <Button
                                :variant="
                                    isActiveLink(path) ? 'default' : 'ghost'
                                "
                                class="w-full justify-start hover:bg-accent"
                                :class="isActiveLink(path) ? 'bg-gray-400' : ''"
                                @click="closeMobileMenu"
                            >
                                <Link
                                    :href="path"
                                    class="flex items-center w-full"
                                >
                                    <component
                                        :is="icon"
                                        class="w-4 h-4 mr-2"
                                    />
                                    {{ name }}
                                </Link>
                            </Button>
                        </div>

                        <div class="border-t border-gray-200 my-4"></div>

                        <div v-if="!$page.props.auth.user">
                            <Button
                                variant="ghost"
                                class="w-full justify-start hover:bg-accent"
                            >
                                <Link
                                    href="/login"
                                    class="flex items-center w-full"
                                >
                                    <User class="w-4 h-4 mr-2" />
                                    Login
                                </Link>
                            </Button>
                            <Button
                                variant="ghost"
                                class="w-full justify-start hover:bg-accent"
                            >
                                <Link
                                    href="/register"
                                    class="flex items-center w-full"
                                >
                                    <UserRound class="w-4 h-4 mr-2" />
                                    Register
                                </Link>
                            </Button>
                        </div>
                        <div v-else>
                            <Button
                                variant="ghost"
                                class="w-full justify-start hover:bg-accent"
                            >
                                <Link
                                    :href="'/users/' + $page.props.auth.user.id"
                                    class="flex items-center w-full"
                                >
                                    Profile
                                </Link>
                            </Button>
                            <Button
                                variant="ghost"
                                class="w-full justify-start hover:bg-accent"
                            >
                                <Link
                                    method="post"
                                    href="/logout"
                                    class="flex items-center w-full"
                                >
                                    Logout
                                </Link>
                            </Button>
                        </div>
                    </div>
                </SheetContent>
            </Sheet>
        </div>
    </nav>
</template>
