<script setup lang="ts">
import { usePage } from "@inertiajs/vue3";
import { computed } from "vue";
import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/components/ui/tabs";
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from "@/components/ui/card";
import { Button } from "@/components/ui/button";
import { Label } from "@/components/ui/label";
import { Input } from "@/components/ui/input";
import { Textarea } from "@/components/ui/textarea";
import { Badge } from "@/components/ui/badge";
import { Separator } from "@/components/ui/separator";
import { Switch } from "@/components/ui/switch";
import { Key, Shield, Trash2 } from "lucide-vue-next";

const page = usePage();
const user = computed(() => page.props.auth.user);
</script>

<template>
    <div>
        <Tabs defaultValue="account" class="space-y-4">
            <TabsList class="grid w-full grid-cols-4">
                <TabsTrigger value="account">Account</TabsTrigger>
                <TabsTrigger value="security">Security</TabsTrigger>
                <TabsTrigger value="notifications">Notifications</TabsTrigger>
            </TabsList>

            <!-- Account Settings -->
            <TabsContent value="account" class="space-y-6">
                <Card>
                    <CardHeader>
                        <CardTitle>Account Settings</CardTitle>
                        <CardDescription
                            >Manage your account preferences and
                            subscription.</CardDescription
                        >
                    </CardHeader>
                    <CardContent class="space-y-6">
                        <div class="flex items-center justify-between">
                            <div class="space-y-1">
                                <Label class="text-base">Account Status</Label>
                                <p class="text-muted-foreground text-sm">
                                    Your account is currently active
                                </p>
                            </div>
                            <Badge
                                variant="outline"
                                class="border-green-200 bg-green-50 text-green-700"
                            >
                                Active
                            </Badge>
                        </div>
                        <Separator />
                        <div class="flex items-center justify-between">
                            <div class="space-y-1">
                                <Label class="text-base"
                                    >Subscription Plan</Label
                                >
                                <p class="text-muted-foreground text-sm">
                                    Pro Plan - $29/month
                                </p>
                            </div>
                            <Button variant="outline"
                                >Manage Subscription</Button
                            >
                        </div>
                        <Separator />
                        <div class="flex items-center justify-between">
                            <div class="space-y-1">
                                <Label class="text-base"
                                    >Account Visibility</Label
                                >
                                <p class="text-muted-foreground text-sm">
                                    Make your profile visible to other users
                                </p>
                            </div>
                            <Switch defaultChecked />
                        </div>
                        <Separator />
                        <div class="flex items-center justify-between">
                            <div class="space-y-1">
                                <Label class="text-base">Data Export</Label>
                                <p class="text-muted-foreground text-sm">
                                    Download a copy of your data
                                </p>
                            </div>
                            <Button variant="outline">Export Data</Button>
                        </div>
                    </CardContent>
                </Card>

                <Card class="border-destructive/50">
                    <CardHeader>
                        <CardTitle class="text-destructive"
                            >Danger Zone</CardTitle
                        >
                        <CardDescription
                            >Irreversible and destructive
                            actions</CardDescription
                        >
                    </CardHeader>
                    <CardContent>
                        <div
                            class="flex flex-col items-between justify-start gap-2"
                        >
                            <div class="space-y-2">
                                <Label class="text-base">Delete Account</Label>
                                <p class="text-muted-foreground text-sm">
                                    Permanently delete your account and all data
                                </p>
                            </div>
                            <Button variant="destructive">
                                <Trash2 class="mr-2 h-4 w-4" />
                                Delete Account
                            </Button>
                        </div>
                    </CardContent>
                </Card>
            </TabsContent>

            <!-- Security Settings -->
            <TabsContent value="security" class="space-y-6">
                <Card>
                    <CardHeader>
                        <CardTitle>Security Settings</CardTitle>
                        <CardDescription
                            >Manage your account security and
                            authentication.</CardDescription
                        >
                    </CardHeader>
                    <CardContent class="space-y-6">
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <div class="space-y-1">
                                    <Label class="text-base">Password</Label>
                                    <p class="text-muted-foreground text-sm">
                                        Last changed 3 months ago
                                    </p>
                                </div>
                                <Button variant="outline">
                                    <Key class="mr-2 h-4 w-4" />
                                    Change Password
                                </Button>
                            </div>
                            <Separator />
                            <div class="flex items-center justify-between">
                                <div class="space-y-1">
                                    <Label class="text-base"
                                        >Two-Factor Authentication</Label
                                    >
                                    <p class="text-muted-foreground text-sm">
                                        Add an extra layer of security to your
                                        account
                                    </p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <Badge
                                        variant="outline"
                                        class="border-green-200 bg-green-50 text-green-700"
                                    >
                                        Enabled
                                    </Badge>
                                    <Button variant="outline" size="sm">
                                        Configure
                                    </Button>
                                </div>
                            </div>
                            <Separator />
                            <div class="flex items-center justify-between">
                                <div class="space-y-1">
                                    <Label class="text-base"
                                        >Login Notifications</Label
                                    >
                                    <p class="text-muted-foreground text-sm">
                                        Get notified when someone logs into your
                                        account
                                    </p>
                                </div>
                                <Switch defaultChecked />
                            </div>
                            <Separator />
                            <div class="flex items-center justify-between">
                                <div class="space-y-1">
                                    <Label class="text-base"
                                        >Active Sessions</Label
                                    >
                                    <p class="text-muted-foreground text-sm">
                                        Manage devices that are logged into your
                                        account
                                    </p>
                                </div>
                                <Button variant="outline">
                                    <Shield class="mr-2 h-4 w-4" />
                                    View Sessions
                                </Button>
                            </div>
                        </div>
                    </CardContent>
                </Card>
            </TabsContent>

            <!-- Notification Settings -->
            <TabsContent value="notifications" class="space-y-6">
                <Card>
                    <CardHeader>
                        <CardTitle>Notification Preferences</CardTitle>
                        <CardDescription
                            >Choose what notifications you want to
                            receive.</CardDescription
                        >
                    </CardHeader>
                    <CardContent class="space-y-6">
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <div class="space-y-1">
                                    <Label class="text-base"
                                        >Email Notifications</Label
                                    >
                                    <p class="text-muted-foreground text-sm">
                                        Receive notifications via email
                                    </p>
                                </div>
                                <Switch defaultChecked />
                            </div>
                            <Separator />
                            <div class="flex items-center justify-between">
                                <div class="space-y-1">
                                    <Label class="text-base"
                                        >Push Notifications</Label
                                    >
                                    <p class="text-muted-foreground text-sm">
                                        Receive push notifications in your
                                        browser
                                    </p>
                                </div>
                                <Switch />
                            </div>
                            <Separator />
                            <div class="flex items-center justify-between">
                                <div class="space-y-1">
                                    <Label class="text-base"
                                        >Marketing Emails</Label
                                    >
                                    <p class="text-muted-foreground text-sm">
                                        Receive emails about new features and
                                        updates
                                    </p>
                                </div>
                                <Switch defaultChecked />
                            </div>
                            <Separator />
                            <div class="flex items-center justify-between">
                                <div class="space-y-1">
                                    <Label class="text-base"
                                        >Weekly Summary</Label
                                    >
                                    <p class="text-muted-foreground text-sm">
                                        Get a weekly summary of your activity
                                    </p>
                                </div>
                                <Switch defaultChecked />
                            </div>
                            <Separator />
                            <div class="flex items-center justify-between">
                                <div class="space-y-1">
                                    <Label class="text-base"
                                        >Security Alerts</Label
                                    >
                                    <p class="text-muted-foreground text-sm">
                                        Important security notifications (always
                                        enabled)
                                    </p>
                                </div>
                                <Switch :checked="true" disabled />
                            </div>
                        </div>
                    </CardContent>
                </Card>
            </TabsContent>
        </Tabs>
    </div>
</template>
