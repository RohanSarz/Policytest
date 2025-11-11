<script setup lang="ts">
import { usePage, Form } from "@inertiajs/vue3";
import {
    login,
    register,
    logout,
} from "@/actions/App/Http/Controllers/AuthController";
import { profileView } from "@/actions/App/Http/Controllers/UserDataController";

import { computed } from "vue";
import {
    Home,
    LayoutDashboard,
    Menu,
    User,
    UserRound,
    Key,
} from "lucide-vue-next";
import { Button } from "@/components/ui/button";
import UserNameUpper from "@/components/userDataComponents/UserNameUpper.vue";
import { Sheet, SheetContent, SheetTrigger } from "@/components/ui/sheet";

import {
    Breadcrumb,
    BreadcrumbItem,
    BreadcrumbLink,
    BreadcrumbList,
    BreadcrumbPage,
    BreadcrumbSeparator,
} from "@/components/ui/breadcrumb";
import LoginOrRegister from "@/components/userDataComponents/LoginOrRegister.vue";
import { dashboard, home } from "@/routes";

// User Reactive Data
const page = usePage<{ auth: { user: any } }>();
const user = computed(() => page.props.auth.user);

const navlinks = computed(() => {
    const baseLinks = [
        {
            id: 1,
            name: "Home",
            icon: Home,
            path: home().url,
        },
    ];

    // links to exclude if user is not logged
    if (user.value) {
        baseLinks.push({
            id: 2,
            name: "Dashboard",
            icon: LayoutDashboard,
            path: dashboard().url,
        });
    }
    return baseLinks;
});

// Function to close mobile menu after navigation
const closeMobileMenu = () => {
    // This will be handled by the Sheet component automatically
};

// Check if the current path matches the link path
const isActiveLink = (path: string) => {
    // Extract just the path from the full URL if needed
    const pathToCheck = path.startsWith("http") ? new URL(path).pathname : path;
    return window.location.pathname === pathToCheck;
};
</script>
<template>
    <nav class="relative">
        <!-- Desktop Nav Menu (hidden on mobile) -->

        <ul
            class="hidden md:flex justify-end items-center bg-secondary-foreground text-white dark:bg-primary space-x-6 px-3 py-3"
        >
            <!-- Guest Message -->
            <LoginOrRegister
                class="flex-1 text-gray-400"
                data-aos="fade-down"
            />

            <li v-if="user" class="flex-1 text-gray-300">
                Welcome,
                <span class="text-gray-600 uppercase"> {{ user.name }} </span>!
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

            <!-- Login and Register -->
            <li v-if="!user" class="space-x-6">
                <Button
                    variant="ghost"
                    :class="
                        login().url.split('/').pop() === 'login'
                            ? 'bg-accent text-black'
                            : ''
                    "
                >
                    <Link
                        class="hover:bg-accent flex items-center"
                        :href="login().url"
                    >
                        <Key class="w-4 h-4 mr-2" />
                        Login
                    </Link>
                </Button>
                <Button variant="ghost">
                    <Link
                        class="hover:bg-accent flex items-center"
                        :href="register().url"
                        :class="
                            isActiveLink(register().url)
                                ? 'bg-accent text-black'
                                : ''
                        "
                    >
                        <UserRound class="w-4 h-4 mr-2" />
                        Register
                    </Link>
                </Button>
            </li>
            <!-- Profile and Logout -->
            <li v-else class="space-x-6">
                <Button variant="ghost">
                    <Link class="hover:bg-accent" :href="profileView().url">
                        Profile</Link
                    >
                </Button>
                <Form class="inline" :action="logout().url" method="post">
                    <Button variant="ghost"> Logout </Button>
                </Form>
            </li>
        </ul>

        <!-- Mobile Nav Menu -->
        <div
            class="md:hidden flex justify-between items-center bg-secondary-foreground text-white dark:bg-primary px-3 py-3"
        >
            <!-- For Guest User -->
            <div v-if="!user" class="flex-1 text-gray-400">
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
            <!-- For Logged User -->
            <div v-if="user" class="flex-1 text-gray-400">
                Welcome,
                <UserNameUpper :name="user.name" />!
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

                        <div v-if="!user">
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
                                    :href="profileView().url"
                                    class="flex items-center w-full"
                                >
                                    Profile
                                </Link>
                            </Button>
                            <Form
                                :action="logout().url"
                                method="post"
                                class="w-full"
                            >
                                <Button
                                    variant="ghost"
                                    class="w-full justify-start hover:bg-accent"
                                >
                                    Logout
                                </Button>
                            </Form>
                        </div>
                    </div>
                </SheetContent>
            </Sheet>
        </div>
    </nav>
</template>
