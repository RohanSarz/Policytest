<script setup lang="ts">
import { PropType } from "vue";
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

interface Post {
    id: number;
    title: string;
    body: string;
    created_at: string;
    user: {
        id: number;
        name: string;
        avatar?: string | null;
    };
}

const props = defineProps({
    post: {
        type: Object as PropType<Post>,
        required: true,
    },
});
</script>

<template>
    <div class="max-w-lg min-w-[20rem] px-2">
        <Card>
            <CardHeader class="pb-3">
                <div class="flex items-center gap-4">
                    <Link :href="`/users/${props.post.user.id}`">
                        <Avatar class="ring-1">
                            <AvatarImage
                                :src="
                                    props.post.user.avatar
                                        ? `/storage/${props.post.user.avatar}`
                                        : 'storage/avatars/def.jpg'
                                "
                                :alt="props.post.user.name"
                            />
                            <AvatarFallback>{{
                                props.post.user.name.charAt(0).toUpperCase()
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
                                new Date(
                                    props.post.created_at
                                ).toLocaleDateString()
                            }}
                        </p>
                    </div>
                </div>

                <CardTitle class="mt-2">{{ props.post.title }}</CardTitle>
                <CardDescription class="line-clamp-2">
                    {{
                        props.post.body.substring(0, 100) +
                        (props.post.body.length > 100 ? "..." : "")
                    }}
                </CardDescription>
            </CardHeader>

            <CardContent class="pb-3">
                <p class="line-clamp-3 text-sm text-muted-foreground">
                    {{
                        props.post.body.substring(0, 150) +
                        (props.post.body.length > 150 ? "..." : "")
                    }}
                </p>
            </CardContent>

            <CardFooter>
                <Link
                    :href="`/posts/${props.post.id}`"
                    class="text-sm font-medium hover:underline"
                >
                    Read more
                </Link>
            </CardFooter>
        </Card>
    </div>
</template>
