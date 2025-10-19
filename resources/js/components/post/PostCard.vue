<script setup>
import { Link } from "@inertiajs/vue3";
import {
    Card,
    CardHeader,
    CardTitle,
    CardDescription,
    CardContent,
    CardFooter,
} from "@/components/ui/card";
import { Avatar, AvatarImage, AvatarFallback } from "@/components/ui/avatar";

const props = defineProps({
    post: {
        type: Object,
        required: false,
    },
    isSingle: {
        type: Boolean,
        default: false,
    },
});
</script>

<template>
    <Card
        :class="[
            props.isSingle
                ? 'max-w-3xl mx-auto w-full shadow-lg'
                : 'min-w-[280px] sm:min-w-[320px] max-w-lg w-full',
        ]"
    >
        <CardHeader class="pb-3">
            <div
                v-if="props.post && props.post.user"
                class="flex items-center gap-4"
            >
                <Link :href="`/users/${props.post.user.id}`">
                    <Avatar class="ring-1">
                        <AvatarImage
                            :src="
                                props.post.user.avatar
                                    ? `/storage/${props.post.user.avatar}`
                                    : '/storage/avatars/def.jpg'
                            "
                            :alt="props.post.user.name"
                            @error="
                                $event.target.src = '/storage/avatars/def.jpg'
                            "
                        />
                        <AvatarFallback>{{
                            props.post.user.name?.charAt(0).toUpperCase()
                        }}</AvatarFallback>
                    </Avatar>
                </Link>

                <div class="min-w-0 flex-1">
                    <Link
                        :href="`/users/${props.post.user.id}`"
                        class="hover:underline"
                    >
                        <h4 class="text-sm font-semibold truncate">
                            {{ props.post.user.name }}
                        </h4>
                    </Link>
                    <p class="text-xs text-muted-foreground">
                        {{
                            new Date(props.post.created_at).toLocaleDateString()
                        }}
                    </p>
                </div>
            </div>
            <div v-else class="flex items-center gap-4">
                <!-- Placeholder for user info -->
                <Avatar class="ring-1">
                    <AvatarImage
                        :src="'/storage/avatars/def.jpg'"
                        alt="Loading..."
                    />
                    <AvatarFallback>U</AvatarFallback>
                </Avatar>
                <div class="min-w-0 flex-1">
                    <h4 class="text-sm font-semibold truncate">{{}}</h4>
                    <p class="text-xs text-muted-foreground">Loading...</p>
                </div>
            </div>

            <!-- Larger title in single view -->
            <CardTitle :class="isSingle ? 'text-3xl mt-4' : 'text-xl mt-2'">
                {{ props.post?.title || "Loading..." }}
            </CardTitle>

            <!-- Hide description in single view (or show full body) -->
            <CardDescription v-if="!isSingle" class="line-clamp-2">
                {{
                    props.post?.body?.substring(0, 100) +
                        (props.post?.body?.length > 100 ? "..." : "") ||
                    "Loading post content..."
                }}
            </CardDescription>
        </CardHeader>

        <CardContent class="pb-3">
            <p
                :class="[
                    isSingle
                        ? 'text-base text-gray-800 whitespace-pre-line'
                        : 'line-clamp-3 text-sm text-muted-foreground',
                ]"
            >
                {{
                    isSingle
                        ? props.post?.body || "Loading post content..."
                        : props.post?.body?.substring(0, 150) +
                              (props.post?.body?.length > 150 ? "..." : "") ||
                          "Loading post content..."
                }}
            </p>
        </CardContent>

        <CardFooter v-if="!isSingle">
            <Link
                v-if="props.post"
                :href="`/posts/${props.post.id}`"
                class="text-sm font-medium hover:underline"
            >
                Read more
            </Link>
            <span v-else class="text-sm text-muted-foreground">Loading...</span>
        </CardFooter>
    </Card>
</template>
